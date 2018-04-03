<?php
    $settingResult = $this->db->get_where('site_setting');
    $settingData = $settingResult->row();

    $setting_dateformat = $settingData->datetime_format;
    $setting_site_logo = $settingData->site_logo;

   
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Sale No : <?php echo $detail_id;; ?></title>
		<script src="<?=base_url()?>assets/js/jquery-1.7.2.min.js"></script>
		
<style type="text/css" media="all">
	body { 
		max-width: 950px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
	#wrapper { 
		min-width: 900px; 
		margin: 0px auto; 
	}
	#wrapper img { 
		max-width: 300px; 
		width: auto; 
	}

	h2, h3, p { 
		margin: 5px 0;
	}
	.left { 
		width:100%; 
		float:right; 
		text-align:right; 
		margin-bottom: 3px;
		margin-top: 3px;
	}
	.right { 
		width:40%; 
		float:right; 
		text-align:right; 
		margin-bottom: 3px; 
	}
	.table, .totals { 
		width: 100%; 
		margin:10px 0; 
	}
	.table th { 
		border-top: 1px solid #000; 
		border-bottom: 1px solid #000; 
		padding-top: 4px;
		padding-bottom: 4px;
	}
	.table td { 
		padding:0; 
	}
	.totals td { 
		width: 24%; 
		padding:0; 
	}
	.table td:nth-child(2) { 
		overflow:hidden; 
	}

	@media print {
		body { text-transform: uppercase; }
		#buttons { display: none; }
		#wrapper { width: 100%; margin: 0; font-size:9px; }
		#wrapper img { max-width:300px; width: 80%; }
		#bkpos_wrp{
			display: none;
		}
	}
</style>
</head>

<body>
<div id="wrapper">
    <table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
	    <tr>
		    <td width="100%" align="center">
			    <center>
			    	<img src="<?=base_url()?>assets/img/logo/<?php echo $setting_site_logo; ?>" style="width: 80px;" />
			    </center>
		    </td>
	    </tr>
	    <tr>
		    <td width="100%" align="center">
			      <h2 style="padding-top: 0px; font-size: 24px;"><strong><?=!empty($getmainOrder->outlets_name)?$getmainOrder->outlets_name:''?></strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
				<span class="left" style="text-align: left;">Date : <?= date("$setting_logo->datetime_format H:i A", strtotime($getmainOrder->create_date));?></span>
				<span class="left" style="text-align: left;">Work Order No : <?=!empty($getmainOrder->job_order_no)?$getmainOrder->job_order_no:''?></span>
				<span class="left" style="text-align: left;">Goldsmith : <?=!empty($getmainOrder->gold_smith_name)?$getmainOrder->gold_smith_name:''?></span>
				<span class="left" style="text-align: left;">Order Delivery Date : <?=!empty($getmainOrder->order_delivery_date)?$getmainOrder->order_delivery_date:''?></span>
				<span class="left" style="text-align: left;">Item Details: <?=!empty($getmainOrder->item_details)?$getmainOrder->item_details:''?></span>
				<span class="left" style="text-align: left;">Address : <?=!empty($getmainOrder->outlets_address)?$getmainOrder->outlets_address:''?></span>	
				<span class="left" style="text-align: left;">Tel : <?=!empty($getmainOrder->outlets_contact)?$getmainOrder->outlets_contact:''?></span> 
				<span class="left" style="text-align: left;">Customer Name&nbsp; : <?=!empty($getmainOrder->customer_fillname)?$getmainOrder->customer_fillname:''?></span> 
				<span class="left" style="text-align: left;">Customer Phone : <?=!empty($getmainOrder->customer_mobile)?$getmainOrder->customer_mobile:''?></span>
				<span class="left" style="text-align: left;">Created Date: <?=!empty($getmainOrder->create_date)?$getmainOrder->create_date:''?></span>
				<span class="left" style="text-align: left;">Total Qty: <?=!empty($getmainOrder->TotalQty)?$getmainOrder->TotalQty:''?></span>
				<span class="left" style="text-align: left;">Total Current Weight: <?=!empty($getmainOrder->TotalCurrentWeight)?$getmainOrder->TotalCurrentWeight:''?></span>
				<span class="left" style="text-align: left;">Total Unit Weight: <?=!empty($getmainOrder->TotalUnitWeight)?$getmainOrder->TotalUnitWeight:''?></span>
				<span class="left" style="text-align: left;">Gold for Goldsmith: <?=!empty($getmainOrder->TotalGoldforGoldsmith)?$getmainOrder->TotalGoldforGoldsmith:''?></span>
			</td>
		</tr>   
    </table>
	 
	    
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
		<thead> 
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
		</thead> 
		<tbody> 
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
				<td><?=$product_tax?></td>
				<td><?=$product_discount?></td>
				<td><?= number_format($product_grandtotal,2) ?></td>
			
			</tr>	
			<?php
			}
	
			?>
		
		<tr>
			<td style="border-top: 1px solid;padding-top: 5px;"><b>Total</b></td>
			<td style="border-top: 1px solid;padding-top: 5px;"><b></b></td>
			<td style="border-top: 1px solid;padding-top: 5px;"><b></b></td>
			<td style="border-top: 1px solid;padding-top: 5px;"><b><?=number_format($total_price,2);?></b></td>
			<td style="border-top: 1px solid;padding-top: 5px;"><b><?= number_format($totalqty,2); ?></b></td>
			<td style="border-top: 1px solid;padding-top: 5px;"><b></b></td>
			<td style="border-top: 1px solid;padding-top: 5px;"></td>
			<td style="border-top: 1px solid;padding-top: 5px;"><b><?=number_format($total_sub,2);?></b></td>
			<td style="border-top: 1px solid;padding-top: 5px;" ><b><?=$totaltax?></b></td>
			<td style="border-top: 1px solid;padding-top: 5px;"><b><?=$total_disco?></b></td>
			<td style="border-top: 1px solid;padding-top: 5px;"><b><?=number_format($total_grad,2);?></b></td>
		</tr>
		
			
		
		</tbody> 
	</table> 
	
	
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
										$getPaymentOrder=$this->db->get_where('gold_orders_payment', array('gold_orders_id' => $getmainOrder->customer_order_no))->result();
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
											$getpayunpay=$this->db->query("select * from gold_orders where gold_id = '$getmainOrder->customer_order_no'")->row();
											
											?>
											<tr>
												
												<td colspan="5"style="text-align: left;border-top: 1px solid;padding-top: 5px;"><b>Total Paid Amount</b></td>
												<td style="text-align: left;border-top: 1px solid;padding-top: 5px;"><b><?=!empty($getpayunpay->gold_paid_amt)?number_format($getpayunpay->gold_paid_amt, 2):0.00 ?></b></td>
											</tr>
											<tr>
												
												<td colspan="5"style="text-align: left;border-top: 1px solid;padding-top: 5px;"><b>Total UnPaid Amount</b></td>
												<td style="text-align: left;border-top: 1px solid;padding-top: 5px;"><b><?=!empty($getpayunpay->gold_unpaid_amt)?number_format($getpayunpay->gold_unpaid_amt, 2):0.00 ?></b></td>
											</tr>
											
											<?php
											$duepay = $getpayunpay->gold_unpaid_amt - $getpayunpay->gold_paid_amt;
											if($getpayunpay->gold_unpaid_amt <= $getpayunpay->gold_paid_amt)
											{
												$duepay = $getpayunpay->gold_paid_amt - $getpayunpay->gold_unpaid_amt;
											}
											?>
											<tr>
												
												<td colspan="5"style="text-align: left;border-top: 1px solid;padding-top: 5px;"><b>Total Due Amount</b></td>
												<td style="text-align: left;border-top: 1px solid;padding-top: 5px;"><b><?=!empty($duepay)?number_format($duepay, 2):0.00 ?></b></td>
											</tr>
											
											<tr>
												
												<td colspan="5"style="text-align: left;border-top: 1px solid;padding-top: 5px;"><b>Grand Total</b></td>
												<td style="text-align: left;border-top: 1px solid;padding-top: 5px;"><b><?=!empty($getpayunpay->gold_grandtotal)?number_format($getpayunpay->gold_grandtotal, 2):0.00 ?></b></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

	
    
    <div style="border-top:1px solid #000; padding-top:10px;">
    	<?php
		 echo !empty($getmainOrder->gold_outlet_receipt_footer)?$getmainOrder->gold_outlet_receipt_footer:'';          
        ?>    
    </div>

    <div id="bkpos_wrp">
    	<a href="<?=base_url()?>Productions/all_work_job_order" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;">Back to Work List</a>
    </div>
    
    <div id="bkpos_wrp">
	    <a href="<?=base_url()?>Productions/print_invoice_work_job?id=<?php echo $detail_id; ?>" style="text-decoration: none;">
    		<button type="button" style="width:101%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 0px; font-weight:bold;">Print Small Receipt</button>
	    </a>
    </div>
    
	<div id="bkpos_wrp" style="margin-top: 8px;">
    	<span class="left"><a href="#" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold;" id="email">Email</a></span>
    </div>
    
    <div id="bkpos_wrp">
    	<span class="left">
    		<a href="" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold; margin-top: 6px;" onClick="window.print();return false;">
	    		Print A4
	    	</a>
	    </span>
    </div>
    
    <input type="hidden" id="id" value="<?php echo $detail_id; ?>" />
    
</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('#email').click( function(){
			var email 	= prompt("Please enter email address","test@mail.com");	
			var id 		= document.getElementById("id").value;
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>gold/send_invoice",
				data: { email: email, id: id}
			}).done(function( msg ) {
			      alert( "Successfully Sent Receipt to "+email);
			});
			
		});
	});

	$(window).load(function() { window.print(); });
</script>




</body>
</html>
