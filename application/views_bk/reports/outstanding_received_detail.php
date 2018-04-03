<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Payment No : <?php echo $order_id; ?></title>
		<script src="<?= base_url() ?>assets/js/jquery-1.7.2.min.js"></script>
		<link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/datepicker3.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet">

		<link href="<?= base_url() ?>assets/css/icono.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
		<link href="<?= base_url() ?>assets/css/multiple-select.css" rel="stylesheet" media="screen">
		<link href="<?= base_url() ?>assets/css/bootstrap-select.css" rel="stylesheet" media="screen">
		<style type="text/css" media="all">
			body { 
				max-width: 770px; 
				margin:0 auto; 
				text-align:center; 
				color:#000; 
				
				font-size:12px; 
			}
		</style>
	</head>

	<body>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<h2>Payment Detail (<?=!empty($customername->customer_name)?$customername->customer_name:''?>)</h2>
							</div>
						</div>

						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>Date & Time</th>
												<th>Payment Type</th>
												<th>Paid Amount</th>
												<th>Grand Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$i = 1;
											$totalamount = 0;
											foreach ($payment_data as $payment)
											{
												$totalamount = $totalamount + $payment->amount
											?>
											<tr>
												<td style="text-align: left;"><?=$i++;?></td>
												<td style="text-align: left;"><?=$payment->created?>
												<td style="text-align: left;"><?=$payment->paymentname?>
												<?php
													if($payment->paymentname == "Cheque")
													{
													echo '<br>(Cheque No:'.$payment->cheque_number.'),<br> Cheque Date:('.$payment->cheque_date.')';
													}
													elseif($payment->paymentname == "Credit cards")
													{
														echo '<br>(Card No:'.$payment->card_number.')';
													}
														
												?>
												</td>
												<td style="text-align: left;"><?=!empty($payment->amount)?number_format($payment->amount,2):'0.00'?></td>
												<td style="text-align: left;"><?=!empty($payment->amount)?number_format($payment->amount,2):'0.00'?></td>
											</tr>
											<?php
											}
											?>
											<tr>
												<td colspan="3" style="text-align: left"><label>Total</label></td>
												<td style="text-align: left"><?=!empty($totalamount)?number_format($totalamount,2):'0.00'?></td>
												<td style="text-align: left"><?=!empty($totalamount)?number_format($totalamount,2):'0.00'?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>