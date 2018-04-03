<?php
	require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">List of Purchase Orders - <?= $type ?> <span class="pull-right">
					<?php
					if ($user_role < 3) {
						?>
						<a href="<?= base_url() ?>purchase_order/create_purchase_order" style="text-decoration: none">
							<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>Create Purchase Order</button>
						</a>
					<?php } ?>
				</span>
			</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
					if (!empty($alert_msg)) {
						$flash_status = $alert_msg[0];
						$flash_header = $alert_msg[1];
						$flash_desc = $alert_msg[2];

						if ($flash_status == 'failure') {
							?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-warning" role="alert">
										<i class="icono-exclamationCircle" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
							<?php
						}
						if ($flash_status == 'success') {
							?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-success" role="alert">
										<i class="icono-check" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
							<?php
						}
					}
					?>


					<div class="row">
						<div class="col-md-12">
							<?php if ($type != 'All') { ?>
								<a href="<?= base_url() ?>purchase_order/po_view/">
									<button class="btn btn-primary" style="padding: 0px 12px;">All</button>
								</a>
								<?php
							}
							if (!empty($status)) {
								foreach ($status as $st) {
									if ($type != $st['name']) {
										?>
										<a href="<?= base_url() ?>purchase_order/po_<?=strtolower($st['name'])?>?p_status=<?=$st['id']?>">
											<button class="btn btn-primary" style="padding: 0px 12px;"><?php echo $st['name']; ?></button>
										</a>
									<?php
									}
								}
							}
							?>
                        </div>
						<br /><br />
						
						<form action="" method="get">
                            <div class="row" style="margin-top: 10px;">
								<div class="col-md-12">
									<div class="col-md-3">
										<div class="form-group">
											<label>Start Date</label>
											<input type="text" name="start_date" class="form-control" id="startDate" autocomplete="OFF"  value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" />
											<input type="hidden" name="p_status"  class="form-control" value="<?=!empty($p_status)?$p_status:''?>"  />
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>End Date</label>
											<input type="text" name="end_date" class="form-control" id="endDate" autocomplete="OFF"  value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" />
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label>&nbsp;</label><br />
											<button class="btn btn-primary" style="width: 100%;">Search</button>
										</div>
									</div>
								</div>
                            </div>
                        </form>
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table" id="datatable">
									<thead>
										<tr>
											<th>Date & Time</th>
											<th>Purchase Bill Date</th>
											<th>Purchase Order Number</th>
											<th>Outlet</th>
											<th>Stores</th>
											<th>Supplier</th>
											<th>User-Created</th>
											<th>Payment Type</th>
											<th>Amount</th>
											<th>Product Type</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($results as $value) {
											$id = $value->id;
											$status_id = $value->status;
											$po_numb = $value->po_number;
											?>
											<tr>
												<td><?= date('d-m-Y H:i:s', strtotime($value->created_datetime)) ?></td>
												<td><?= $value->transation_date=='0000-00-00'?$value->transation_date:(date('d-m-Y',strtotime($value->transation_date))); ?></td>
												<td><?= $value->po_number?></td>
												<td><?= $value->outlet_name ?></td>
												<td>
												<?php
													echo $storeandwarehouse = $this->Purchaseorder_model->getReceivedStoreTank($id);
												?>
												</td>
												<td><?= $value->supplier_name ?></td>
												<td><?= $value->fullname ?></td>
												<td><?= !empty($value->payment_method_name) ? $value->payment_method_name : 'Not Paid' ?></td>
												<td><?php echo $value->grandTotal; // echo !empty($value->grandTotal)?number_format($value->grandTotal, 2):0 ?></td>
												<td><?php
													if($value->product_type == "bulk")
													{
														echo "Bulk";
													}
													else
													{
														echo "Normal";
													}
												?></td>
												<td><?= $value->statusname ?></td>
												<td><div class="btn-group">
														<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
															Action    <span class="caret"></span>
															<span class="sr-only">Toggle Dropdown</span>
														</button>
														<ul class="dropdown-menu" role="menu">
															<?php
															if ($status_id == '4') {
																?>
																<li> <a href="<?= base_url() ?>purchase_order/raisepo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		Raise
																	</a></li>
																<li> <a href="<?= base_url() ?>purchase_order/editpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		Edit
																	</a></li>
																<?php
																if ($user_role == '1') {
																	?>
																	<li>
																		<a href="<?= base_url() ?>purchase_order/deletePO?id=<?php echo $id; ?>&po_numb=<?php echo $po_numb; ?>" style="text-decoration: none; margin-left: 5px;" onclick="return confirm('Are you sure to delete this Purchase Order : <?php echo $po_numb; ?>?')">
																			Delete
																		</a></li>
																	<?php }
																?>

																<li><a href="<?= base_url() ?>purchase_order/viewpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		View
																	</a></li>
																<li>  <a href="<?= base_url() ?>purchase_order/exportPurchaseOrder?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		Print
																	</a></li>
																<?php } elseif ($status_id == '5') {
																?>
																<li> <a href="<?= base_url() ?>purchase_order/receivedpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		Receive
																	</a></li>
																<li> <a href="<?= base_url() ?>purchase_order/partialpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		Partail
																	</a></li>
																<li> <a href="<?= base_url(); ?>purchase_order/send_invoice/<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		Email
																	</a></li>
																<li><a href="<?= base_url() ?>purchase_order/viewpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		View
																	</a>
																</li>

															<?php } elseif ($status_id == '6') { ?>
<!--																<li><a class="archive_popup_show"href="<?= base_url() ?>purchase_order/archivepo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		Archive
																	</a></li>-->
																<li><a class="archive_popup_show" id="<?= $id; ?>" style="text-decoration: none; margin-left: 5px;cursor:pointer">
																		Archive
																	</a></li>

																<li><a href="<?= base_url() ?>purchase_order/viewpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		View
																	</a></li>
															<?php } elseif ($status_id == '8') { ?>
																<li> <a href="<?= base_url() ?>purchase_order/partialpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		Partail
																</a></li>
																	
																<li><a href="<?= base_url() ?>purchase_order/viewpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		View
																</a></li>
																

															<?php } else {
																?>
																<?php
																if ($status_id == '2') {
																	?>
																	<li> <a href="<?= base_url() ?>purchase_order/receivepo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																			Receive
																		</a></li>
																	<?php }
																?>
																<li><a href="<?= base_url() ?>purchase_order/viewpo?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
																		View
																	</a></li>
															<?php }
															?>
																	
																<li>
																	
																	<a data-toggle="modal" data-target="#myModal<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px; cursor: pointer;">Note</a>
											
																</li>
														</ul>
													</div>
									
										<div class="message-box animated fadeIn edit_archive" data-sound="alert" id="archive-signout<?=$id;?>">
												<div class="mb-container">
													<div class="mb-middle">
														<div class="mb-title"><span class="fa fa-times "></span> Archive<strong></strong> ?</div>
														<div class="mb-content">
															<p>Do you want to Archive this?</p>                    
															<p>Press No if you want to continue work. Press Yes to current Archive.</p>

														</div>
														<div class="mb-footer">
															<div class="pull-right">

																	<a href="<?= base_url() ?>purchase_order/archivepo?id=<?php echo $id; ?>" class="btn btn-success btn-lg" >Yes</a>
																	<a class="btn btn-default btn-lg mb-control-close" >No</a>

															</div>
														</div>
													</div>
												</div>
											</div>
													
											<div id="myModal<?php echo $id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Note</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-12">
																	<?=$value->note?>
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
			order:[1,'desc'],
			responsive: true,
			
		});
				$(".table").delegate(".archive_popup_show", "click", function(){
					var id = $(this).attr('id'); 
					$('#archive-signout'+id).modal('show');
					
			   });
	});
</script>
 