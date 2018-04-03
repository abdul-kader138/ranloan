<?php
    require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Inventory Changes</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate"   value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate"   value="<?=!empty($this->input->get('start_date'))?$this->input->get('end_date'):''?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<button class="btn btn-primary" type="submit" style="width: 100%;">Search</button>
								</div>
							</div>
						</div>
					</form>
					
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table" id="datatable_inven">
									<thead>
										<tr>
											<th>Date & Time</th>
											<th>Form No</th>
											<th>Product Code</th>
											<th>Product Name</th>
											<th>Category</th>
											<th>Sub Category</th>
											<th>Warehouse</th>
											<th>Available Qty</th>
											<th>Qty</th>
											<th>Price</th>
											<th>Value</th>
											<th>User</th>
											<th>Type(P/S)</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($results as $value)
										{
										?>
										<tr>
											<td><?=$value->created_date?></td>
											<td><?=$value->id?></td>
											<td><?=$value->product_code?></td>
											<td><?=$value->productname?></td>
											<td><?=$value->categoryname?></td>
											<td><?=$value->sub_category?></td>
											<td>
												<?php
													$store = $this->Reports_model->getWarehosueDetail($value->tank_warehouse_id);
													echo rtrim($store,",");
												?>
											</td>
											<td><?=!empty($value->available_qty)?number_format($value->available_qty,2):'0.00'?></td>
											<td><?=!empty($value->qty)?number_format($value->qty,2):'0.00'?></td>
											<td><?=!empty($value->price)?number_format($value->price,2):'0.00'?></td>
											<td><?=!empty($value->amount)?number_format($value->amount,2):'0.00'?></td>
											<td><?=$value->fullname?></td>
											<td><?php
											if($value->purchase_sale_type == '0')
											{
												echo "Sale";
											}
											else
											{
												echo "Purchase";
											}
												
											?></td>
											<td>
												<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?=$value->id?>">View</button>	
											</td>
										</tr>
										
										<div id="myModal<?=$value->id?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Date & Time</b>
																</div>
																<div class="col-md-8">
																	<?php echo $value->created_date; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Form No</b>
																</div>
																<div class="col-md-8">
																	<?php echo $value->id; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Product Code</b>
																</div>
																<div class="col-md-8">
																	<?php echo $value->product_code; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Product Name</b>
																</div>
																<div class="col-md-8">
																	<?php echo $value->productname; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Category</b>
																</div>
																<div class="col-md-8">
																	<?php echo $value->categoryname; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Sub Category</b>
																</div>
																<div class="col-md-8">
																	<?php echo $value->sub_category; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Warehouse</b>
																</div>
																<div class="col-md-8">
																	<?php
																		$store = $this->Reports_model->getWarehosueDetail($value->tank_warehouse_id);
																		echo rtrim($store,",");
																	?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Available Qty</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($value->available_qty)?number_format($value->available_qty,2):'0.00'?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Qty</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($value->qty)?number_format($value->qty,2):'0.00'?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Price</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($value->price)?number_format($value->price,2):'0.00'?>
																</div>
															</div>
											
															<div class="row">
																<div class="col-md-4">
																	<b>Value</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($value->amount)?number_format($value->amount,2):'0.00'?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>User</b>
																</div>
																<div class="col-md-8">
																	<?=$value->fullname?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Type(Purchase / Sales)</b>
																</div>
																<div class="col-md-8">
																<?php
																if($value->purchase_sale_type == '0')
																{
																	echo "Sale";
																}
																else
																{
																	echo "Purchase";
																}
																?>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
										
										<?php }
										?>
									</tbody>
									
									
								</table>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
			<br /><br /><br />
		</div>
			
		
	</div>
</div>
<?php
    require_once 'includes/footer.php';
?>



<script>
$(document).ready(function() {
	$("#datatable_inven").DataTable({
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
				exportOptions:{columns:[0,1,2,3,4,5,6]},
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
