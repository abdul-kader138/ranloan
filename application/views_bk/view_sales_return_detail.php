<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Sales Return Item Detail</title>
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
				max-width: 600px; 
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
					<table class="table">
						<thead>
							<tr>
								<th width="100%" align="center">
									<h2 style="padding-top: 0px; font-size: 24px;"><strong>Sales Return Item Detail</strong></h2>
								</th>
							</tr>
						</thead>
					</table>

					<div class="panel-body">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Sales Id</th>
												<th>Product Code</th>
												<th>Product Name</th>
												<th>Store</th>
												<th>Qty</th>
												<th>Price</th>
												<th>Sub Total</th>
												<th>Grand Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($getReturnSalesItem as $value)
											{ ?>
												<tr>
													<td><?=$value->order_id?></td>
													<td><?=$value->product_code?></td>
													<td><?=$value->product_name?></td>
													<td><?php
													if($value->type == 1)
													{
														echo $this->Inventory_model->getConcateFuelTanK($value->ow_id);
													}
													else
													{
														echo $this->Inventory_model->getConcateStore($value->ow_id);
													}
													?></td>
													<td><?=number_format($value->qty,2)?></td>
													<td><?=number_format($value->price,2)?></td>
													<td><?=number_format($value->subtotal,2)?></td>
													<td><?=number_format($value->grandtotal,2)?></td>
												</tr>
											<?php }
											?>
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
