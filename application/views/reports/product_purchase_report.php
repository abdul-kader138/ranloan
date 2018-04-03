<?php
//require_once 'includes/header.php';
$this->load->view('includes/header');

?>


<?php
$orderRows = 0;
$dd_cat = $this->Constant_model->getddData('category', 'id', 'name', 'name');
?>
<script>
    $(function () {
        $("#startDate").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });

        $("#endDate").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });
    });
</script>
<style>
	.modal-dialog{
      width:60%;
      margin: auto;
	}
</style>
<?php
?>
<script type="text/javascript">
    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Product Purchase Report</h1>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px;">
						<div class="col-md-12">
							<div class="col-md-6">
								<a href="<?= base_url() ?>reports/product_purchase_report"
								   style="text-decoration: none;">
									<button type="button" class="btn btn-success"
											style="background-color: #5cb85c; border-color: #4cae4c;">
										Product Report
									</button>
								</a>
								<a href="<?= base_url() ?>reports/sale_report"
								   style="text-decoration: none;">
									<button type="button" class="btn btn-success"
											style="background-color: #5cb85c; border-color: #4cae4c;">
										Sales Report
									</button>
								</a>
							</div>
						</div>

					</div>

					<form action="<?= base_url() ?>reports/product_purchase_report" method="get">
						<div class="row">

							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate"
										   value="<?php echo $url_start; ?>"/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control"
										   id="endDate" value="<?php echo $url_end; ?>"/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br/>
									<input type="hidden" name="report" value="1"/>
									<input type="submit" class="btn btn-primary" value="Search"/>
								</div>
							</div>
						</div>
					</form>

					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive table-striped">
								<table id="datatable" class="table" >
									<thead>
                                        <tr>
											<th style="display: none;">#</th>
                                            <th width="20%">Date & Time</th>
                                            <th width="20%">Purchase ID / Purchase Return ID</th>
                                            <th width="20%">Code <i class="fa fa-fw fa-sort"></i></th>
                                            <th class="sorting" width="20%">Name<i class="fa fa-fw fa-sort"></i></th>
                                            <th width="20%">Outlet</th>
                                            <th width="20%">Stores</th>
                                            <th width="20%">Total purchase Qty </th>
                                            <th width="20%">Total purchase Cost</th>
                                            <th width="20%">Action</th>
                                        </tr>
									</thead>
									<tbody>
										<?php
											$i = 1;
										foreach ($product_report->result() as $report) {
											?>
											<tr>
												<td style="display: none;"><?=$i++;?></td>
												<td width="20%"><?php echo $report->created_datetime; ?></td>
												<td width="20%"><?= $report->pur_id ?></td>
												<td width="20%"><?php echo $report->product_code; ?></td>
												<td width="20%"><?php echo $report->name; ?></td>
												<td width="20%"><?php echo $report->outlet_name; ?></td>
												<td width="20%">
													<?php
													$stringstore = '';
													$store = $this->db->query("SELECT outlet_warehouse.*,stores.s_name FROM outlet_warehouse INNER JOIN stores ON stores.s_id = outlet_warehouse.w_id WHERE outlet_warehouse.out_id = '" . $report->outlet_id . "' ");
													foreach ($store->result() as $stor) {
														$stringstore.=$stor->s_name . ',';
													}
													echo rtrim($stringstore, ",");
													?>
												</td>
												<td width="20%"><?=!empty($report->purchase_qty)?number_format($report->purchase_qty,2):'0.00'?></td>
												<td width="20%"><?php 
															$totalg = $report->purchase_qty * $report->cost;
															echo !empty($totalg)?number_format($totalg):'0.00'; ?></td>
												<td width="20%">
													<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?=$report->pur_id ?>">View</button>
													<div id="myModal<?=$report->pur_id ?>" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Purchase Detail</h4>
																</div>
																<div class="modal-body">
																	<div class="row">
																		<div class="col-md-4">
																			<b>Date & Time</b>
																		</div>
																		<div class="col-md-8">
																			<?php echo $report->created_datetime; ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Purchase ID / Purchase Return ID</b>
																		</div>
																		<div class="col-md-8">
																			<?= $report->pur_id ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Product Code</b>
																		</div>
																		<div class="col-md-8">
																			<?php echo $report->product_code; ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Product Name</b>
																		</div>
																		<div class="col-md-8">
																			<?php echo $report->name; ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Outlet</b>
																		</div>
																		<div class="col-md-8">
																			<?=$report->outlet_name?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Stores</b>
																		</div>
																		<div class="col-md-8">
																			<?php echo rtrim($stringstore, ","); ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Total Purchased Qty</b>
																		</div>
																		<div class="col-md-8">
																			<?=!empty($report->purchase_qty)?number_format($report->purchase_qty,2):'0.00'; ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Total Purchased Cost</b>
																		</div>
																		<div class="col-md-8">
																			<?=!empty($totalg)?number_format($totalg):'0.00'; ?>
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
										}
										?>
									</tbody>
								</table>
								
								
									<div class="row">
										<div class="col-lg-6">
											<h1 class="page-header">&nbsp;Purchase Return Report</h1>
										</div>
										<div class="col-lg-6" style="text-align: right;">
											<br />
										</div>
			
									<div class="col-md-12">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="row" style="margin-top: 0px;">
													<div class="col-md-12">
														<div class="table-responsive">
															<table id="datatablereturn" class="table">
																<thead>
																	<tr>
																		<th width="12%">Date</th>
																		<th width="12%">Outlet</th>
																		<th width="12%">Warehouse</th>
																		<th width="12%">Supplier</th>
																		<th width="12%">Product Code</th>
																		<th width="12%">Ref Bill No</th>
																		<th width="12%">Return Qty</th>
																		<th width="12%">Refund Amount</th>
																		<th width="12%">Payment Type</th>
																		<th width="12%">Refund Tax</th>
																		<th width="10%">Grand Total </th>
																		<th width="10%">View</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	foreach ($getPurchaseReturnReport as $valueretun)
																	{	?>
																		<tr>
																			<td><?=$valueretun->created_date?></td>
																			<td><?=$valueretun->outlet_name?></td>
																			<td>
																				<?php
																				if($valueretun->type == 1)
																				{
																					echo $this->Inventory_model->getConcateFuelTanK($valueretun->outlet_id,$valueretun->product_code,$valueretun->warehouse_tank);
																				}
																				else
																				{
																					echo $this->Inventory_model->getConcateStore($valueretun->outlet_id,$valueretun->product_code,$valueretun->warehouse_tank);
																				}
																				?>
																			</td>
																			<td><?=$valueretun->suppliers_name?></td>
																			<td><?=$valueretun->product_code?></td>
																			<td><?=$valueretun->ref_bill_no?></td>
																			<td><?=$valueretun->returned_qty?></td>
																			<td><?=$valueretun->refund_amount?></td>
																			<td><?=$valueretun->payment_method_name?></td>
																			<td><?=$valueretun->refund_tax?></td>
																			<td><?= number_format($valueretun->returned_qty * $valueretun->refund_amount,2)?></td>

																			<td>
																			<button class="btn btn-primary PopupPurachsereturnsales" id="<?php echo $valueretun->id; ?>" >View Detail</button>

																					<div id="myModalData<?php echo $valueretun->id; ?>" class="modal fade" role="dialog">
																						<div class="modal-dialog">
																							<!-- Modal content-->
																							<div class="modal-content">
																								<div class="modal-header">
																									<button type="button" class="close" data-dismiss="modal">&times;</button>
																									<h4 class="modal-title">View Detail</h4>
																								</div>
																								<div class="modal-body">

																									<table class="table">
																										<thead>
																											<tr>
																												<th width="12%">Date</th>
																												<th width="12%">Outlet</th>
																												<th width="12%">Warehouse</th>
																												<th width="12%">Supplier</th>
																												<th width="12%">Product Code</th>
																												<th width="12%">Ref Bill No</th>
																												<th width="12%">Return Qty</th>
																												<th width="12%">Refund Amount</th>
																												<th width="12%">Payment Type</th>
																												<th width="12%">Refund Tax</th>
																												<th width="10%">Grand Total </th>
																											</tr>
																										</thead>
																										<tbody>
																											<tr>
																												<td><?=$valueretun->created_date?></td>
																												<td><?=$valueretun->outlet_name?></td>
																												<td>
																													<?php
																													echo $this->Inventory_model->getConcateStore($valueretun->outlet_id,$valueretun->product_code,$valueretun->warehouse_tank);
																													?>
																												</td>
																												<td><?=$valueretun->suppliers_name?></td>
																												<td><?=$valueretun->product_code?></td>
																												<td><?=$valueretun->ref_bill_no?></td>
																												<td><?=$valueretun->returned_qty?></td>
																												<td><?=$valueretun->refund_amount?></td>
																												<td><?=$valueretun->payment_method_name?></td>
																												<td><?=$valueretun->refund_tax?></td>
																												<td><?= number_format($valueretun->returned_qty * $valueretun->refund_amount,2)?></td>

																											</tr>
																										</tbody>
																									</table>


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
							</div>
							<br /><br /><br />
						</div>
					</div>
					
				
<script>
    $(document).ready(function () {

        $("#datatable").DataTable({
            dom: "Bfrtip",
            "bPaginate": true, ordering: true, "pageLength":10,
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
        $("#datatablereturn").DataTable({
            dom: "Bfrtip",
            "bPaginate": true, ordering: true, "pageLength": 10,
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
	
	
		$('.PopupPurachsereturnsales').click(function(){
		var id = $(this).attr('id');
		$('#myModalData'+id).modal('show');
	});
	
</script>
<?php
//require_once 'includes/footer.php';
	$this->load->view('includes/footer.php');
?>