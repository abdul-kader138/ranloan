<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Work Order : <?php echo $main_work_job->job_order_no; ?></title>
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
				max-width: 60%; 
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
									<h2 style="padding-top: 0px; font-size: 24px;"><strong><?= !empty($main_work_job->outlets_name) ? $main_work_job->outlets_name : '' ?></strong></h2>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div class="left" style="text-align: left; font-weight: bold;">Outlet Address : <?= !empty($main_work_job->outlets_address) ? $main_work_job->outlets_address : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Outlet Tel : <?= !empty($main_work_job->outlets_contact) ? $main_work_job->outlets_contact : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Goldsmith Name : <?= !empty($main_work_job->gold_smith_name) ? $main_work_job->gold_smith_name : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Work Order No : <?= !empty($main_work_job->job_order_no) ? $main_work_job->job_order_no : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Customer Order No : <?= !empty($main_work_job->customer_order_no) ? $main_work_job->customer_order_no : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Customer Name : <?= !empty($main_work_job->customer_fillname) ? $main_work_job->customer_fillname : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Date : <?= date("$setting_dateformat H:i A", strtotime(!empty($main_work_job->created_at)?$main_work_job->created_at:'')); ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Order Delivery Date: <?=$main_work_job->order_delivery_date?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Gold for Goldsmith: <?=$main_work_job->TotalGoldforGoldsmith?></div>
								</td>
							</tr> 
						</tbody>
					</table>

					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<h2>Work Order Detail</h2>
							</div>
						</div>

						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-4"></div>
									<div class="col-md-8"></div>
								</div>
								
								
								<div class="table-responsive">
									<table class="table">
											
										<tr>
											<th>Order Received Date</th>
											<th>Order No</th>
											<th>Ordered Product</th>
											<th>Price</th>
											<th>Ordered Qty</th>
											<th>Show Room Product</th>
											<th>Gold Qty</th>
											<th>Sub Total</th>
											<th>Tax%</th>
											<th>Discount</th>
											<th>Grand Total</th>
										
										</tr>
										<?php 
										$totalqty=0;
										$total_price=0;
										$total_sub =0;
										$totaltax=0;
										$main_subtotal = 0 ;
										$total_disco=0;
										$total_grad=0;
										foreach($view_job as $view)
										{
//											$order_items_gold_id=$view->order_items_gold_id;
//											$query= $this->db->query("SELECT * FROM gold_orders where gold_id = '$order_items_gold_id' ");
//											$subval=$query->row();
											$qty=$view->qty;
											$totalqty=$totalqty+$qty;
											$product_price=$view->price;
											$total_price=$total_price+$product_price;
											$product_tax=$view->tax;
											$totaltax=$totaltax+$product_tax;
											$product_discount=$view->discount;
											$total_disco=$total_disco+$product_discount;
											$product_subtotal=$product_price*$qty;
											$total_sub=$total_sub+$product_subtotal;
											$product_grandtotal=$view->grandtotal;
											$total_grad=$total_grad+$product_grandtotal;
											$gold_qty_goldsmith = $view->gold_qty_goldsmith;
											$alloy_gold_qty = $view->alloy_qty_goldsmith;
											
											
										?>
										<tr>
											<td><?= $view->order_delivery_date?></td>
											<td><?= $view->job_order_no?></td>
											<td><?= $view->product_name?></td>
											<td><?= $product_price ?></td>
											<td><?= $qty ?></td>
											<td><?=$view->weight_bluk_store_product?></td>
											<td><?= $gold_qty_goldsmith?></td>
											<td><?= number_format($product_subtotal,2)?></td>
											<td><?=!empty($product_tax)?$product_tax:'0';?></td>
											<td><?=!empty($product_discount)?$product_discount:'0';?></td>
											<td><?= $product_grandtotal ?></td>
										
										</tr>
											
										<?php
										}
										?>
										
										<tr>
											<td><b>Total</b></td>
											<td><b></b></td>
											<td><b></b></td>
											<td><b><?=number_format($total_price,2);?></b></td>
											<td><b><?= number_format($totalqty,2); ?></b></td>
											<td><b></b></td>
											<td></td>
											<td><b><?=number_format($total_sub,2);?></b></td>
											<td><b><?=$totaltax?></b></td>
											<td><b><?=$total_disco?></b></td>
											<td><b><?=number_format($total_grad,2);?></b></td>
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
												<th>Customer Order No</th>
												<th>Payment Type</th>
												<th>Paid Amount</th>
												<th>Unpaid Amount</th>
												<th>Sub Total</th>
												<th>Grand Total</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$getPaymentOrder=$this->db->get_where('gold_orders_payment', array('gold_orders_id' => $main_work_job->customer_order_no))->result();
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
													<td style="text-align: left;"><?= $payment->gold_orders_id ?></td>
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

											
											<?php
											$getpayunpay=$this->db->query("select * from gold_orders where gold_id = '$main_work_job->customer_order_no'")->row();
											
											?>
											<tr>
												<td colspan="3" style="text-align: right;"><b></b></td>
												<td colspan="2"style="text-align: right;"><b>Total Paid Amount</b></td>
												<td style="text-align: left;"><b><?=!empty($getpayunpay->gold_paid_amt)?number_format($getpayunpay->gold_paid_amt, 2):0.00 ?></b></td>
											</tr>
											<tr>
												<td colspan="3" style="text-align: right;"><b></b></td>
												<td colspan="2"style="text-align: right;"><b>Total UnPaid Amount</b></td>
												<td style="text-align: left;"><b><?=!empty($getpayunpay->gold_unpaid_amt)?number_format($getpayunpay->gold_unpaid_amt, 2):0.00 ?></b></td>
											</tr>
											
											<?php
											$duepay = $getpayunpay->gold_unpaid_amt - $getpayunpay->gold_paid_amt;
											if($getpayunpay->gold_unpaid_amt <= $getpayunpay->gold_paid_amt)
											{
												$duepay = $getpayunpay->gold_paid_amt - $getpayunpay->gold_unpaid_amt;
											}
											?>
											<tr>
												<td colspan="3" style="text-align: right;"><b></b></td>
												<td colspan="2"style="text-align: right;"><b>Total Due Amount</b></td>
												<td style="text-align: left;"><b><?=!empty($duepay)?number_format($duepay, 2):0.00 ?></b></td>
											</tr>
											
											<tr>
												<td colspan="3" style="text-align: right;"><b></b></td>
												<td colspan="2"style="text-align: right;"><b>Grand Total</b></td>
												<td style="text-align: left;"><b><?=!empty($getpayunpay->gold_grandtotal)?number_format($getpayunpay->gold_grandtotal, 2):0.00 ?></b></td>
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
