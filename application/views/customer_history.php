<?php
    require_once 'includes/header.php';
?>
<script type="text/javascript">
	function openReceiptDetail(ele) {
		var myWindow = window.open(ele, "", "width=850, height=850");
	}
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">View History for Customer : <?php echo $fullname; ?></h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12" style="text-align: right;">
							<?php
                                if ($user_role < 3) {
                                    ?>
							<a href="<?=base_url()?>customers/exportCustomerHistory?cust_id=<?php echo $cust_id; ?>" style="text-decoration: none;">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									Export
								</button>
							</a>
							<?php
							}
                            ?>
						</div>
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table" id="datatable">
								    <thead>
								    	<tr>
									    	<th>Customer Order No</th>
									    	<th>Type</th>
									    	<th>Date & Time</th>
									    	<th>Outlet Name</th>
									    	<th>Total Qty</th>
										    <th>Sub Total (<?php echo $currency; ?>)</th>
										    <th>Grand Total (<?php echo $currency; ?>)</th>
										    <th>Action</th>
										</tr>
								    </thead>
									<tbody>
										<?php
										foreach ($customer_history as $value)
										{ ?>
											<tr>
												<td><?=$value->gold_id?></td>
												<td><?php 
												if($value->status == '1')
												{
													echo "Sale";
												}
												else
												{
													echo "Return";
												}
												?></td>
												<td><?=$value->gold_ordered_datetime?></td>
												<td><?=$value->gold_outlet_name?></td>
												<td><?=number_format($value->totalqty,2)?></td>
												<td><?=number_format($value->gold_grandtotal,2)?></td>
												<td><?=number_format($value->gold_grandtotal,2)?></td>
												
												<td>
													<a class="btn btn-primary" onclick="openReceiptDetail('<?= base_url() ?>Gold/view_order_detail?id=<?php echo $value->gold_id; ?>')" style="padding: 4px 12px;"  title="View Detail">View Detail</a>
													<!--<a href="<?=base_url()?>customers/customer_sales_history_detail?sales_id=<?=$value->gold_id?>&cust_id=<?=$cust_id?>" class="btn btn-primary">View Detail</a>-->
												</td>
											</tr>
									<?php	}
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
</div>
<?php
    require_once 'includes/footer.php';
?>
<script>
	$(document).ready(function () {

		$("#datatable").DataTable({
			dom: "Bfrtip",
			"bPaginate": true, ordering: true, "pageLength": 15,
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
				},
				{
					extend: "pageLength",
				},
			],
			 order:[0,"desc"],
			responsive: true,
			
		});
	});
</script>
 