<?php
$app = realpath(APPPATH);

require_once $app . '/views/includes/header.php';

//    require_once 'includes/header.php';
?>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-8">
			<h1 class="page-header">Received Cheque Details</h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="get">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cheque Number</label>
                                    <input type="text" name="cheque_no" class="form-control" autocomplete="off" value="<?=!empty($this->input->get('cheque_no'))?$this->input->get('cheque_no'):''?>" />
                                </div>
                            </div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate" autocomplete="off"  value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>"  />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate" autocomplete="off"  value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>"  />
								</div>
							</div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label><br />
                                    <button class="btn btn-primary" style="width: 100%;">&nbsp;&nbsp;Search&nbsp;&nbsp;</button>
                                </div>
                            </div>
                        </div>
                    </form>




					<hr>
					<div class="row" style="margin-top: 19px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Date & Time</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="11%">Entry No</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="12%">Outlet</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Customer</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Cheque Number</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="11%">Cheque Date</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Bank</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Cheque Amount</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php
									
									
											foreach ($orders_data as $data) {
												$date_time = $data->ordered_datetime;
												$outlet_name = $data->outlet_name;
												$customer_name = $data->customer_name;
												$cheque_number = $data->cheque_number;
												$bank = $data->bank;
												$cheque_date = $data->cheque_date;
												$paid_amt = $data->paid_amt;
												?>
												<tr>
													<td><?php echo $date_time; ?></td>
													<td><?php echo $data->order_id; ?></td>
													<td><?php echo $outlet_name; ?></td>
													<td><?php echo $customer_name; ?></td>
													<td><?php echo $cheque_number; ?></td>
													<td><?php echo $cheque_date; ?></td>
													<td><?php echo $bank; ?></td>
													<td><?php echo !empty($paid_amt)?number_format($paid_amt,2):'0.00'; ?></td>
													<td>
														<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $data->id; ?>">View</button>
															<div id="myModal<?php echo $data->id; ?>" class="modal fade" role="dialog">
																<div class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal">&times;</button>
																			<h4 class="modal-title">View Cheque Detail</h4>
																		</div>
																		<div class="modal-body">
																			<div class="row">
																				<div class="col-md-4">
																					<b>Customer</b>
																				</div>
																				<div class="col-md-8">
																					<?php echo $customer_name; ?>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-4">
																					<b>Outlet</b>
																				</div>
																				<div class="col-md-8">
																					<?php echo $outlet_name; ?>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-4">
																					<b>Entry Date</b>
																				</div>
																				<div class="col-md-8">
																					<?php echo $date_time; ?>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-4">
																					<b>Entry Number</b>
																				</div>
																				<div class="col-md-8">
																					<?php echo $data->order_id; ?>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-4">
																					<b>Cheque Date</b>
																				</div>
																				<div class="col-md-8">
																					<?php echo $cheque_date; ?>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-4">
																					<b>Cheque No</b>
																				</div>
																				<div class="col-md-8">
																					<?php echo $cheque_number; ?>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-4">
																					<b>Bank</b>
																				</div>
																				<div class="col-md-8">
																					<?php echo $bank; ?>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-4">
																					<b>Amount</b>
																				</div>
																				<div class="col-md-8">
																					<?=!empty($paid_amt)?number_format($paid_amt,2):'0.00'; ?>
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
									<tfoot>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br /><br /><br /><br /><br />
</div>
<?php
	$app = realpath(APPPATH);
	require_once $app . '/views/includes/footer.php';
?>

<script>
    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        autoclose: true
    });
	
    $(document).ready(function () {
        $("#datatable").DataTable({
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
                    className: "change btn-primary",
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5]},
                },
				{
					extend: "pageLength",
				},
            ],
            responsive: true,
            drawCallback: function () {
                var api = this.api();
                $(api.table().column(7).footer()).html("<strong>" +
					addCommas(api.column(7, {page: 'current'}).data().sum().toFixed(2)) + "(LKR)</strong>"
				);
            }
        });
	});
</script>	

