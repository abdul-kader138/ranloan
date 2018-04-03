<?php
require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Reserved Item List - Old</h1>
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
									<input name="start_date" class="form-control" id="startDate" type="text" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input name="end_date" class="form-control" id="endDate" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>"  type="text">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Sub Category</label>
									<select class="form-control" name="sub_category">
										<option value="">Select Sub Category</option>
										<?php
										foreach ($getSubCategory as $category)
										{
											$selected = '';
											if(!empty($this->input->get('sub_category')))
											{
												if($this->input->get('sub_category') == $category->id)
												{
													$selected = "selected";
												}
											}
											?>
										<option <?=$selected?> value="<?=$category->id?>"><?=$category->sub_category?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br>
									<button class="btn btn-primary" style="width: 100%; height: 35px;">Search</button>
								</div>
							</div>
						</div>
					</form>
					
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">

							<div class="table-responsive">
								<table id="example" class="table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="10%">Date & Time</th>
											<th width="10%">Outlet</th>
											<th width="10%">Customer Order No</th>
											<th width="10%">Sub Category</th>
											<th width="10%">Code</th>
											<th width="10%">Item</th>
											<th width="10%">Work Order No</th>
											<th width="14%">Action</th>
										</tr>
									</thead>
									<tbody>
									<tbody>
                                    
										<?php 
										if(!empty($getResult))
										foreach($getResult as $view){ ?>
										<tr>
											<td><?=$view->gold_ordered_datetime?></td>
											<td><?=$view->gold_outlet_name?></td>
											<td><?=$view->gold_id?></td>
											<td><?=$view->sub_category_name?></td>
											<td><?=$view->product_code?></td>
											<td><?=$view->product_name?></td>
											<td><?=$view->gold_delivery_date?></td>
											<td><button class="btn btn-primary oldModelHide" style="width: 70px;padding: 4px 12px;"   data-toggle="modal" data-target="#myModal<?php echo $view->order_item_id; ?>">View</button>
											</td>
										</tr>
										
											<div id="myModal<?php echo $view->order_item_id; ?>" class="modal fade" role="dialog">
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
																	<?= date('d-m-Y H:i:s', strtotime($view->gold_ordered_datetime)) ?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Outlet</b>
																</div>
																<div class="col-md-8">
																	<?=$view->gold_outlet_name?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Customer Order No</b>
																</div>
																<div class="col-md-8">
																	<?=$view->gold_id?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Sub Category</b>
																</div>
																<div class="col-md-8">
																	<?=$view->sub_category_name?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Product Code</b>
																</div>
																<div class="col-md-8">
																	<?=$view->product_code?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Product Name</b>
																</div>
																<div class="col-md-8">
																	<?=$view->product_name?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Deliver Date</b>
																</div>
																<div class="col-md-8">
																	<?=$view->gold_delivery_date?>
																</div>
															</div>
															
														
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
										<?php } ?>

									
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br /><br /><br />
</div>
<?php
require_once 'includes/header_notification.php';
?>	
<script>
    $(function () {
        $("#example").DataTable({
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
                    className: "change btn-primary",
                },
                {
                    extend: "pageLength",
                },
            ],
            order: [1, 'desc'],
            responsive: true,
        });
	});

</script>

<?php
require_once 'includes/footer.php';
?>