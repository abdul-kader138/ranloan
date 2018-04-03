<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Sales Invoice Number : <?php echo $sales_id; ?></title>
		<script src="<?= base_url() ?>assets/js/jquery-1.7.2.min.js"></script>
		<link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/datepicker3.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet">

		<link href="<?= base_url() ?>assets/css/icono.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
		<link href="<?= base_url() ?>assets/css/multiple-select.css" rel="stylesheet" media="screen">
		<link href="<?= base_url() ?>assets/css/bootstrap-select.css" rel="stylesheet" media="screen">
		
		<link href="<?php echo base_url()?>assets/js/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" media="screen">
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
					<table class="table">
						<thead>
							<tr>
								<th width="100%" align="center">
									<h2 style="padding-top: 0px; font-size: 24px;"><strong><?= !empty($getmainOrder->outlet_name) ? $getmainOrder->outlet_name : '' ?></strong></h2>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div class="left" style="text-align: left; font-weight: bold;">Customer Name : <?= !empty($getmainOrder->fullname) ? $getmainOrder->fullname : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Customer Contact : <?= !empty($getmainOrder->mobile) ? $getmainOrder->mobile : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Sales Person Name : <?= !empty($getmainOrder->sales_person_name) ? $getmainOrder->sales_person_name : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Outlet Address : <?= !empty($getmainOrder->address) ? $getmainOrder->address : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Outlet Tel : <?= !empty($getmainOrder->contact_number) ? $getmainOrder->contact_number : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Sales Invoice No : <?= !empty($getmainOrder->sales_id) ? $getmainOrder->sales_id : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Date : <?= date("$setting_dateformat H:i A", strtotime(@$getmainOrder->gold_ordered_datetime)); ?></div>
								</td>
							</tr> 
						</tbody>
					</table>

					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<h2>Item Detail</h2>
							</div>
						</div>

						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Image</th>
												<th>Sales Invoice No</th>
												<th>Product Name</th>
												<th>Product Code</th>
												<th>Price</th>
												<th>Qty</th>
												<th>Sub Total</th>
												<th>Tax%</th>
												<th>Discount</th>
												<th>Grand Total</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$totalqty = 0;
											$totalprice = 0;
											$totalsubtotal = 0;
											$totalgrandtotal = 0;
											foreach ($getItemOrder as $item) {
												$item_id = $item->id;
												$totalqty = $totalqty + $item->qty;
												$totalprice = $totalprice + $item->price;
												$subtotal = $item->qty * $item->price;
												$totalsubtotal = $totalsubtotal + $subtotal;
												$totalgrandtotal = $totalgrandtotal + $item->grandtotal;
												?>
												<tr>
													<td style="text-align: left; ">
														<?php if(!empty($item->product_image)){ ?>
														
														<a class="fancybox" href="<?php echo base_url().'/product_image/'.$item->product_image; ?>" title="Product Image">
														<img src="<?php echo base_url().'/product_image/'.$item->product_image; ?>" width="50px"style="border: 2px saddlebrown solid;" alt="image" >
														</a>
														
														<?php } ?>
													</td>
													<td style="text-align: left;"><?= $item->sales_id ?></td>
													<td style="text-align: left;"><?= $item->product_name ?></td>
													<td style="text-align: left;"><?= $item->product_code ?></td>
													<td style="text-align: left;"><?=!empty($item->price)?number_format($item->price,2):'' ?></td>
													<td style="text-align: left;"><?=!empty($item->qty)?number_format($item->qty,2):'' ?></td>
													<td style="text-align: left;"><?=!empty($subtotal)?number_format($subtotal , 2):0.00 ?></td>
													<td style="text-align: left;"><?=!empty($item->tax)?number_format($item->tax,2):0.00?></td>
													<td style="text-align: left;"><?=!empty($item->discount)?$item->discount:0?></td>
													<td style="text-align: left;"><?=!empty($item->grandtotal)?number_format($item->grandtotal, 2):0.00 ?></td>
												</tr>
										<?php
											$query = $this->db->query("SELECT * FROM sales_invoice_item_services join sub_category on sales_invoice_item_services.services_name=sub_category.id WHERE sales_invoice_item_id = '".$item_id."' ");
											$subval=$query->result();
											
											if(!empty($subval)){
											foreach ($subval as $val)
											{
												$totalgrandtotal = $totalgrandtotal+$val->price;
												$service = $val->price;
											?>
											<tr>
													<td></td>
													<td></td>
													<td><?=!empty($val->sub_category)?$val->sub_category:''?></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<td style="text-align: left;"><?=!empty($val->price)?number_format($val->price,2):''?></td>
											</tr>	

									<?php	}
											} } ?>
											
											<tr>
												<td colspan="4" style="text-align: left;"><b>Total</b></td>
												<td style="text-align: left;"><b><?=!empty($totalprice)?number_format($totalprice, 2):0.00 ?></b></td>
												<td style="text-align: left;"><b><?=!empty($totalqty)?number_format($totalqty, 2):0.00 ?></b></td>
												<td style="text-align: left;"><b><?=!empty($totalsubtotal)?number_format($totalsubtotal, 2):0.00?></b></td>
												<td style="text-align: left;"></td>
												<td style="text-align: left;"></td>
												<td style="text-align: left;"><b><?=!empty($totalgrandtotal)?number_format($totalgrandtotal, 2):0.00 ?></b></td>
											</tr>
										</tbody>
									</table>

								</div>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<h2>Payment Detail</h2>
							</div>
						</div>

						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th>Sales Invoice No</th>
												<th>Payment Type</th>
												<th>Paid Amount</th>
												<th>Unpaid Amount</th>
												<th>Sub Total</th>
												<th>Grand Total</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$paid_amt = 0;
										$unpaid_amt = 0;
										$subtotal = 0;
										$grandtotal = 0;
										foreach ($getPaymentOrder as $payment) {
											$paid_amt = $paid_amt	+ $payment->paid_amt;
											$unpaid_amt = $unpaid_amt + $payment->unpaid_amt;
											$subtotal = $subtotal + $payment->subtotal;
											$grandtotal = $grandtotal + $payment->grandtotal;
											?>
												<tr>
													<td style="text-align: left;"><?= $payment->sales_id ?></td>
													<td style="text-align: left;"><?php
													echo $payment->payment_method_name;
													if($payment->payment_method_name == 'Cheque')
													{
														echo ' (Cheque No: '.$payment->cheque_number.')';
													}
													elseif ($payment->payment_method_name == 'Credit cards') 
													{
														echo ' (Credit Cards No: '.$payment->card_number.')';
													}
													?></td>
													<td style="text-align: left;"><?=!empty($payment->paid_amt)?number_format($payment->paid_amt, 2):0.00 ?></td>
													<td style="text-align: left;"><?=!empty($payment->unpaid_amt)?number_format($payment->unpaid_amt, 2):0.00 ?></td>
													<td style="text-align: left;"><?=!empty($payment->subtotal)?number_format($payment->subtotal, 2):0.00 ?></td>
													<td style="text-align: left;"><?=!empty($payment->grandtotal)?number_format($payment->grandtotal, 2):0.00?></td>
												</tr>
											<?php }
											?>
											<tr>
												<td colspan="2" style="text-align: left;"><b>Total</b></td>
												<td style="text-align: left;"><b><?=!empty($paid_amt)?number_format($paid_amt, 2):0.00 ?></b></td>
												<td style="text-align: left;"><b><?=!empty($unpaid_amt)?number_format($unpaid_amt, 2):0.00 ?></b></td>
												<td style="text-align: left;"><b><?=!empty($subtotal)?number_format($subtotal, 2):0.00 ?></b></td>
												<td style="text-align: left;"><b><?=!empty($grandtotal)?number_format($grandtotal, 2):0.00?></b></td>											</tr>
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


<script src="<?php echo base_url()?>assets/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.fancybox.js?v=2.1.5"></script>

<script>
 $('.fancybox').fancybox();
</script>