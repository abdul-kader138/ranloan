<?php
require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Product Batch & Expiry Details</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row" style="padding-top: 10px;">
							<div class="col-md-7">
								<a href="<?= base_url() ?>reports/export_product_batch_expiry"
								   style="text-decoration: none;">
									<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
										Export to Excel
									</button>
								</a>
							</div>
						
							<form action="" method="get">
								<div class="col-md-2">
									<div class="form-group">
										<label>Start Date</label>
										<input type="text" name="start_date" class="form-control" id="startDate" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>End Date</label>
										<input type="text" name="end_date" class="form-control" id="endDate" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" />
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-group">
										<label>&nbsp;</label><br/>
										<input type="submit" class="btn btn-primary" value="Search"/>
									</div>
								</div>
							</form>
						</div>
				

					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table" cellspacing="0" width="100%">
									<thead>
                                        <tr>
											<th style="display: none;">id</th>
											<th>Code</th>
											<th>Name</th>
											<th>Category</th>
											<th>Supplier</th>
											<th>Brand</th>
											<th>Batch Number</th>
											<th>Expiry Date</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
									</thead>
									<tbody>
										<?php
										foreach ($ProductBatchExpiry as $value)
										{
										?>
										<tr>
											<td style="display: none;"><?=$value->id?></td>
											<td><?=$value->product_code?></td>
											<td><?=$value->productname?></td>
											<td><?=$value->categoryname?></td>
											<td><?=$value->suppliers_name?></td>
											<td><?=$value->brandname?></td>
											<td><?=$value->batch_no?></td>
											<td><?=$value->expirydate?></td>
											<td>
												<?php
												if($value->status == 0)
												{
													echo "Active";
												}
												else {
													echo "InActive";
												}
												
												?>
												
											</td>
											<td>
											<button class="btn btn-primary" style="padding: 4px 12px; width: 80px;" data-toggle="modal" data-target="#myModal<?=$value->id?>">Action</button>
											<div id="myModal<?=$value->id?>" class="modal fade" role="dialog">
											   <div class="modal-dialog">
												   <div class="modal-content">
													   <div class="modal-header">
														   <button type="button" class="close" data-dismiss="modal">&times;</button>
														   <h4 class="modal-title">Choose Your Action</h4>
													   </div>
													   <div class="modal-body">
														   <ul style="list-style-type:none; text-align:center;">
															   <li>
																   <a class="btn btn-primary" href="<?=base_url()?>purchase_order/create_purchase_return_batch_expiry?outlet=<?=$value->outlet_id_fk?>&supplier=<?=$value->supplier_id_fk?>&code=<?=$value->product_code?>&qty=<?=$value->qty?>&type=<?=$value->type?>&ow_id=<?=$value->ow_id?>&batch_expiry_id=<?=$value->batch_expiry_id?>" style="text-decoration: none; cursor: pointer; border: none;" title="View Detail">
																		Return
																	</a>
															   </li>
															   <li>
																   <a class="btn btn-primary ViewReturnedDetails" id="<?=$value->batch_expiry_id?>"  style="text-decoration: none; cursor: pointer; border: none; margin-top: 10px;" title="View Detail">
																		 View Returned Details 
																	</a>
															   </li>
														   </ul>
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
	<br /><br /><br />
</div>
<div id="popupmyModal" class="modal fade" role="dialog"></div>
<?php
	require_once 'includes/header_notification.php';
?>
<script>
    $(document).ready(function () {
		
		$('body').delegate('.ViewReturnedDetails','click',function(){
			var batchid = $(this).attr('id');
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Reports/ViewPurchaseReturn",
				data: {batchid: batchid},
				dataType: 'JSON',
				success:function(data){
					$('#popupmyModal').html(data.success);
					$('#popupmyModal').modal('show');
				}
			});
		});
		
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
<?php
require_once 'includes/footer.php';
?>