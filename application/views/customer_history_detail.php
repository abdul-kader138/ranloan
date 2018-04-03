<?php
    require_once 'includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">View History for Customer Payment and Item  : <?php echo $fullname; ?></h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12" >
							<h2>Item Detail</h2>
						</div>
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
								    <thead>
								    	<tr>
									    	<th>Sales Id</th>
									    	<th>Product Name</th>
									    	<th>Price</th>
									    	<th>Qty</th>
									    	<th>Sub Total (<?php echo $currency; ?>)</th>
										    <th>Grand Total (<?php echo $currency; ?>)</th>
										</tr>
								    </thead>
									<tbody>
										<?php 
										$totalqty  = 0;
										$totalprice  = 0;
										$totalsubtotal  = 0;
										$totalgrandtotal = 0;
										foreach ($customer_history_item as $item)
										{ 
											$totalqty = $totalqty + $item->qty;
											$totalprice = $totalprice + $item->price;
											$totalsubtotal = $totalsubtotal + $item->subtotal;
											$totalgrandtotal= $totalgrandtotal + $item->grandtotal;
											
											?>
										<tr>
											<td><?=$item->order_id?></td>
											<td><?=$item->product_name?></td>
											<td><?=!empty($item->price)?number_format($item->price,2):0.00?></td>
											<td><?=!empty($item->qty)?number_format($item->qty,2):0.00?></td>
											<td><?=!empty($item->subtotal)?number_format($item->subtotal,2):0.00?></td>
											<td><?=!empty($item->grandtotal)?number_format($item->grandtotal,2):0.00?></td>
										</tr>
									<?php }
										?>
										<tr>
											<td colspan="2"><b>Total</b></td>
											<td><?=!empty($totalprice)?number_format($totalprice,2):0.00?></td>
											<td><?=!empty($totalqty)?number_format($totalqty,2):0.00?></td>
											<td><?=!empty($totalsubtotal)?number_format($totalsubtotal,2):0.00?></td>
											<td><?=!empty($totalgrandtotal)?number_format($totalgrandtotal,2):0.00?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12" >
							<h2>Payment Detail</h2>
						</div>
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
								    <thead>
								    	<tr>
									    	<th>Sales Id</th>
									    	<th>Payment Type</th>
									    	<th>Paid Amount (<?php echo $currency; ?>)</th>
									    	<th>Unpaid Amount (<?php echo $currency; ?>)</th>
									    	<th>Sub Total (<?php echo $currency; ?>)</th>
										    <th>Grand Total (<?php echo $currency; ?>)</th>
										</tr>
								    </thead>
									<tbody>
										<?php 
										foreach ($customer_history_payment as $payment)
										{ 
										?>
										<tr>
											<td><?=$payment->order_id?></td>
											<td><?=$payment->payment_method_name?></td>
											<td><?=!empty($payment->paid_amt)?number_format($payment->paid_amt,2):0.00?></td>
											<td><?=!empty($payment->unpaid_amt)?number_format($payment->unpaid_amt,2):0.00?></td>
											<td><?=!empty($payment->subtotal)?number_format($payment->subtotal,2):0.00?></td>
											<td><?=!empty($payment->grandtotal)?number_format($payment->grandtotal,2):0.00?></td>
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
			<a href="<?=base_url()?>customers/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
		</div>

	</div>
		<br /><br />
</div>
<?php
    require_once 'includes/footer.php';
?>