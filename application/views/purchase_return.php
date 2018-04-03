<?php
require_once 'includes/header.php';
?>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="page-header">List of Purchase Returns</h1>
            </div>
            <div class="col-lg-6" style="text-align: right;">
				<a style="margin-top: 10px;" class="btn btn-primary" href="<?=base_url()?>purchase_order/create_purchase_return">Add Purchase Return</a>
            </div>
			
        </div>

        <div class="row">
            <div class="col-md-12">
				<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
				<div role="alert" class="alert alert-success">
				   <button data-dismiss="alert" class="close" type="button">
					   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
				   <strong>Well done!</strong>
				   <?= $this->session->flashdata('SUCCESSMSG') ?>
				</div>
				<?php } ?>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="" method="get">
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" name="start_date" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" class="form-control" id="startDate" style="height: 35px" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" name="end_date" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>"  class="form-control" id="endDate" style="height: 35px" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br />
                                        <button class="btn btn-primary" style="width: 100%; height: 35px;">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row" style="margin-top: 0px;">
                            <div class="col-md-12">

                                <div class="table-responsive">
                                    <table class="table" id="datatable">
                                        <thead>
											<tr>
												<th>Date & Time</th>
												<th>Purchase Return No.</th>
												<th>Product</th>
												<th>Returned QTY</th>
												<th>Outlet</th>
												<th>Stores</th>
												<th>Suppliers</th>
												<th>Returned Payment Type</th>
												<th>Amount</th>
												<th>View</th>
											</tr>
                                        </thead>
                                        <tbody>
											<?php
											foreach ($getPurchaseReturn as $value)
											{ ?>
												<tr>
													<td><?=$value->created_date?></td>
													<td><?=$value->id?></td>
													<td><?=$value->product_name?></td>
													<td><?=!empty($value->returned_qty)?number_format($value->returned_qty,2):0?></td>
													<td><?=$value->outlets_name?></td>
													<td>
														<?php
													if($value->type == 1)
													{
														echo $this->Inventory_model->getConcateFuelTanK($value->warehouse_tank);
													}
													else
													{
														echo $this->Inventory_model->getConcateStore($value->warehouse_tank);
													}
														?>
													</td>
													<td><?=$value->suppliers_name?></td>
													<td><?=$value->payment_method_name?></td>
													<td><?=!empty($value->refund_amount)?number_format($value->refund_amount,2):0?></td>
													<td>
														
														<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $value->id; ?>">View</button>
														<div id="myModal<?php echo $value->id; ?>" class="modal fade" role="dialog">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Purchase Return Detail</h4>
																	</div>
																	<div class="modal-body">
																		<div class="row">
																			<div class="col-md-4">
																				<b>Date & Time</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->created_date?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Purchase Return No</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->id?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Outlet</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->outlets_name?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Store</b>
																			</div>
																			<div class="col-md-8">
																				<?php
																				if($value->type == 1)
																				{
																					echo $this->Inventory_model->getConcateFuelTanK($value->warehouse_tank);
																				}
																				else
																				{
																					echo $this->Inventory_model->getConcateStore($value->warehouse_tank);
																				}
																				?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Supplier</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->suppliers_name?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Product</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->product_name?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Returned Qty</b>
																			</div>
																			<div class="col-md-8">
																				<?=!empty($value->returned_qty)?number_format($value->returned_qty,2):0?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Refund Amount</b>
																			</div>
																			<div class="col-md-8">
																				<?=!empty($value->refund_amount)?number_format($value->refund_amount,2):0?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Payment Type</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->payment_method_name;?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Refund Tax</b>
																			</div>
																			<div class="col-md-8">
																				<?=number_format($value->refund_tax,2);?>
																			</div>
																		</div>
																		
																		<div class="row">
																			<div class="col-md-4">
																				<b>User</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->fullname;?>
																			</div>
																		</div>
																		
																		<div class="row">
																			<div class="col-md-4">
																				<b>Reason</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->reason;?>
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
										<?php }
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
	});
</script>