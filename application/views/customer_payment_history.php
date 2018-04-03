<?php
    require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Payment History for Customer: <?=$customerdetail->fullname?></h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<div class="row">
						<div class="col-md-12" style="text-align: right;">
							<a href="" style="text-decoration: none">
								<a href="<?=base_url()?>sales/export_customer_payment_history?cust_id=<?=$customerdetail->id?>" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									Export
								</a>
							</a>
						</div>
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="display" cellspacing="0" width="100%">
									<thead>
										<tr>
									    	<th width="14%">Date & Time</th>
									    	<th width="7%">Customer Order No</th>
									    	<th width="15%">Type</th>
									    	<th width="12%">Outlet Name</th>
										    <th width="13%">Opening Amount</th>
										    <th width="13%">Bill Amount</th>
										    <th width="16%">Received Amount</th>
										    <th width="9%">Balance Amount</th>
										    <th width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($order_payment as $payment)
										{ 
											?>
											<tr>
												<td><?=$payment->ordered_datetime?></td>
												<td><?=$payment->gold_orders_id?></td>
												<td><?=$payment->payment_method_name?></td>
												<td><?=$payment->outlet_name?></td>
												<td><?=!empty($payment->openingBalance)?number_format($payment->openingBalance,2):0.00?></td>
												<td><?=!empty($payment->grandtotal)?number_format($payment->grandtotal,2):0.00?></td>
												<td><?=!empty($payment->paid_amt)?number_format($payment->paid_amt,2):0.00?></td>
												<td><?=!empty($payment->unpaid_amt)?number_format($payment->unpaid_amt,2):0.00?></td>
												<td><a href="<?=base_url()?>debit/make_payment?id=<?=$payment->id?>" class="btn btn-primary">Make Payment</a></td>
											</tr>
										<?php 
										}
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
	<a href="<?=base_url()?>customers/view" class="btn btn-primary">Back</a>
	<br /><br /><br />
	<br />
	<br />
</div>
<script>
	
	 $(document).ready(function() {
	 	$("#datatable").DataTable({
				dom: "Bfrtip",
				"bPaginate": true,ordering: true,"pageLength":15,
				buttons: [
				{
					extend: "copy",
					className: "change btn-primary "
				},
				{
					extend: "csv",
					className: " change btn-primary"
				},
				{
					extend: "excel",
					className: "change btn-primary"
				},
				{
					extend: "print",
					className: "change btn-primary",
					exportOptions:{columns:[0,1,2,3,4,5]},
				},
				{
					extend: "pageLength",
				},
			  ],
			  order:[1,"desc"],
			  responsive: true,
			});
	      });
</script>	
	
<?php
    require_once 'includes/footer.php';
?>