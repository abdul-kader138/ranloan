<?php
require_once 'includes/header.php';
$orderRows = 0;
?>
<script type="text/javascript">
    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>
<style>
.custombtns{
	padding: 4px 12px;width:160px; margin-bottom:6px;
}
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Re-Order Detail</h1>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="get">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>"  />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<input type="submit" class="btn btn-primary" value="Get Search" />
								</div>
							</div>
						</div>
					</form>



					<br /><br /><br />
					<div class="table-responsive">
						<table class="table" id="datatable">
							<thead>
								<tr>
									<th style="display: none;" >id</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Alert Date</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Code</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Product Name</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Outlet</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Category</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Sub Category</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="5%">Qty</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="5%">Supplier Name</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="5%">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($getReorderDetail as $value)
								{
//									if ($value->qty <= $value->alt_qty AND $value->qty != 0) 
//										{
								?>
								<tr>
									<td style="display: none;"><?=$value->id?></td>
									<td><?=$value->created_datetime?></td>
									<td><?=$value->code?></td>
									<td><?=$value->name?></td>
									<td><?=$value->outletname?></td>
									<td><?=$value->categoryname?></td>
									<td><?=$value->sub_category?></td>
									<td><?=$value->qty?></td>
									<td><?php
											$get_supplier_name  = $this->Products_model->getLastSupplier($value->code);
											if(!empty($get_supplier_name))
											{
												echo $get_supplier_name;
											}
											else
											{
												echo $value->suppliers_name;
											}
										?>
									</td>
									<td>
										<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalAction<?=$value->id?>">Action</button>									
										
										
										
										<div id="myModalAction<?=$value->id?>" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Choose Your Action</h4>
													</div>
													<div class="modal-body">
														<ul style="list-style-type:none; text-align:center;">
															<li style="margin-bottom: 5px;">
																<form action="<?=base_url()?>purchase_order/create_purchase_order" method="get">
																	<input type="hidden" name="code" value="<?=$value->code?>">
																	<input type="hidden" name="outlet_id" value="<?=$value->outlet_id_fk?>">
																	<input type="hidden" name="supplier_id_fk" value="<?=$value->supplier_id_fk?>">
																	<button type="submit" style="width: 158px;"  class="btn btn-primary">Order Now</button>																					
																</form>
															</li>
															
															<li style="margin-bottom: 5px;">
																<button type="button" style="width: 158px;"  class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $value->id; ?>">View</button>									
															</li>
															
															<li style="margin-bottom: 5px;">
																<a onclick="openReceipt('<?=base_url()?>products/reorder_print?id=<?=$value->id?>')" class="btn btn-primary" style=" width: 158px; padding: 0px; text-decoration: none; cursor: pointer;" title="Print Receipt">
																			<i class="icono-list" style="color: #ffffff;"></i>
																</a>
															</li>
															
															<li><a style="width: 158px;" href="" class="btn btn-primary custombtns">Current Balance</a></li>
															<li><a style="width: 158px;" href="" class="btn btn-primary custombtns">Alert Qty level</a></li>
															<li><a style="width: 158px;" href="" class="btn btn-primary custombtns">Received Date</a></li>
															<li><a style="width: 158px;" href="" class="btn btn-primary custombtns">Received Qty</a></li>
														</ul>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
										
										
										
										
										
										
										
										
										
										
										
										
										
										<div id="myModal<?php echo $value->id; ?>" class="modal fade" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Product Price Detail</h4>
													</div>
													<div class="modal-body">
														<div class="row">
															<div class="col-md-4">
																<b>Product Code:</b>
															</div>
															<div class="col-md-6">
																<?=$value->code?>
															</div>
														</div>
														<div class="row">
															<div class="col-md-4">
																<b>Product Price:</b>
															</div>
															<div class="col-md-6">
																<?=number_format($value->purchase_price,2)?>
															</div>
														</div>
														<div class="row">
															<div class="col-md-4">
																<b>Qty:</b>
															</div>
															<div class="col-md-6">
																<?=number_format($value->qty,2)?>
															</div>
														</div>
														<div class="row">
															<div class="col-md-4">
																<b>Amount:</b>
															</div>
															<div class="col-md-6">
																<?=number_format($value->purchase_price*$value->qty,2)?>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
						<?php
//						}
								}?>
								
							</tbody>
							<tbody>

							</tbody>
						</table>
					</div>


				</div>
			</div>
		</div>
	</div>




	<br /><br /><br />
</div><!-- Right Colmn // END -->

<?php
require_once 'includes/footer.php';
?>
<script type="text/javascript">
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
                    className: "change btn-primary",
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]},
                },
				{
					extend: "pageLength",
				},
            ],
            order: [0, "desc"],
            responsive: true,

        });
    });
</script>
