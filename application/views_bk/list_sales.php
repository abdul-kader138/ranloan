<?php
require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Today Sales & Orders</h1>
		</div>
	</div>
	<script type="text/javascript">
        function openReceipt(ele) {
            var myWindow = window.open(ele, "", "width=380, height=550");
        }
        function openReceiptDetail(ele) {
            var myWindow = window.open(ele, "", "width=850, height=850");
        }
        function openReceiptA4(ele) {
            var myWindow = window.open(ele, "", "width=1020, height=650");
        }

	</script>

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
					
					
						<form action="" method="get">
							  <div class="row">

								 <div class="col-md-2">
									<div class="form-group">
									   <label>Start Date</label>
									   <input name="start_date" class="form-control" id="startDate" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" type="text">
									</div>
								 </div>
								 <div class="col-md-2">
									<div class="form-group">
									   <label>End Date</label>
									   <input name="end_date" class="form-control" id="endDate"  value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" type="text">
									</div>
								 </div>
								 <div class="col-md-2">
									<div class="form-group">
									   <label>&nbsp;</label><br>
									   <input class="btn btn-primary" value="Get Report" type="submit">
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
											<th>Date & Time</th>
											<th>Customer Order No</th>
											<th>Sales Invoice No</th>
											<th>Customer Name</th>
											<th>Sales Officers</th>
											<th>Outlet</th>
											<th>Grand Total</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($getTodaySales as $value) {
											$order_id = $value->gold_id;
											?>
											<tr>
												<td><?= date("$setting_dateformat H:i A", strtotime($value->gold_ordered_datetime)) ?></td>
												<td><?= $order_id ?></td>
												<td></td>
												<td><?= $value->customername ?></td>
												<td><?= $value->sales_person_name ?></td>
												<td><?= $value->gold_outlet_name ?></td>
												<td><?=!empty($value->gold_grandtotal)?number_format($value->gold_grandtotal, 2):0?></td>
												<td>
													<button class="btn btn-primary" style="padding: 4px 12px; width: 80px;" data-toggle="modal" data-target="#myModal<?php echo $order_id; ?>">Action</button>
													<div id="myModal<?php echo $order_id; ?>" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Choose Your Action</h4>
																</div>
																<div class="modal-body">
																	
																	<ul style="list-style-type:none; text-align:center;">
																		<li style="margin-bottom: 5px;">
																			<a class="btn btn-primary" onclick="openReceipt('<?= base_url() ?>Gold/view_invoice?id=<?php echo $order_id; ?>')" style=" border: none;text-decoration: none; cursor: pointer; width: 100px;" title="Print Receipt">
																				Normal Print
																			</a>
																		</li>
																		<li style="margin-bottom: 5px;">
																			<a class="btn btn-primary" onclick="openReceiptA4('<?= base_url() ?>Gold/view_invoice_a4?id=<?php echo $order_id; ?>')" style=" border: none;text-decoration: none; cursor: pointer; width: 100px;" title="Print Receipt">
																				A4 Print
																			</a>
																		</li>
																		<li>
																			<a class="btn btn-primary" onclick="openReceiptDetail('<?= base_url() ?>Gold/view_order_detail?id=<?php echo $order_id ?>')" style="text-decoration: none; cursor: pointer; border: none; width: 100px;" title="View Detail">
																				Detail
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
										<?php }
										?>
										<?php
										
										foreach ($getTodaySalesInvoice as $valueinvoice) {
											$sales_id = $valueinvoice->sales_id;
											?>
											<tr>
												<td><?= date("$setting_dateformat H:i A", strtotime($valueinvoice->sales_ordered_datetime)) ?></td>
												<td></td>
												<td><?= $sales_id ?></td>
												<td><?= $valueinvoice->customername ?></td>
												<td><?= $valueinvoice->sales_person_name ?></td>
												<td><?= $valueinvoice->sales_outlet_name ?></td>
												<td><?=!empty($valueinvoice->sales_grandtotal)?number_format($valueinvoice->sales_grandtotal, 2):0?></td>
												<td>
													<button class="btn btn-primary" style="padding: 4px 12px; width: 80px;" data-toggle="modal" data-target="#myModals<?php echo $sales_id; ?>">Action</button>
													<div id="myModals<?php echo $sales_id; ?>" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Choose Your Action</h4>
																</div>
																<div class="modal-body">
																	
																	<ul style="list-style-type:none; text-align:center;">
																		<li style="margin-bottom: 5px;">
																			<a class="btn btn-primary" onclick="openReceipt('<?= base_url() ?>Gold/view_sales_invoice?id=<?php echo $sales_id; ?>')" style=" border: none;text-decoration: none; cursor: pointer; width: 100px;" title="Print Receipt">
																				Normal Print
																			</a>
																		</li>
																		<li style="margin-bottom: 5px;">
																			<a class="btn btn-primary" onclick="openReceiptA4('<?= base_url() ?>Gold/sales_invoice_a4?id=<?php echo $sales_id; ?>')" style=" border: none;text-decoration: none; cursor: pointer; width: 100px;" title="Print Receipt">
																				A4 Print
																			</a>
																		</li>
																		<li>
																			<a class="btn btn-primary" onclick="openReceiptDetail('<?= base_url() ?>Gold/view_sales_invoice_detail?id=<?php echo $sales_id ?>')" style="text-decoration: none; cursor: pointer; border: none; width: 100px;" title="View Detail">
																				Detail
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
										<?php }
										?>
									</tbody>
									
									
									<tfoot>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</tfoot>
								</table>
								
								
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="col-md-12">
													<div class="col-md-3">
														<h3 style="color: #990000;">Summery</h3>
													</div>
													<div class="col-md-2">
														<h3 style="color: #990000;">Number</h3>
													</div>
													<div class="col-md-2">
														<h3 style="color: #990000;">Amount</h3>
													</div>
											</div>			<hr>
												<div class="col-md-12">
													<table>
														<tbody>
															<tr>
																<td><label style="color:#333333; font-size: 16px;">Today Sales Invoice:</label> </td>
																<td style="padding-left: 15%; text-align:left;"><label style="color:#333333; font-size: 16px;"><?=!empty($gettodaySalesinvoceprice->total_order)?number_format($gettodaySalesinvoceprice->total_order,2):'0.00'?></label></td>
																<td style="padding-left: 50%;text-align:right;"><label style="color:#333333; font-size: 16px;"><?=!empty($gettodaySalesinvoceprice->total_amount)?number_format($gettodaySalesinvoceprice->total_amount,2):'0.00'?></label></td>
															</tr>
															<tr>
																<td><label style="color:#333333;font-size: 16px;">Today Customer Order:</label> </td>
																<td style="padding-left: 15%; text-align:left;"><label style="color:#333333; font-size: 16px;"><?=!empty($gettodaycustomerorderprice->total_order)?number_format($gettodaycustomerorderprice->total_order,2):'0.00'?></label></td>
																<td style="padding-left: 50%;text-align:right;"><label style="color:#333333; font-size: 16px;"><?=!empty($gettodaycustomerorderprice->total_amount)?number_format($gettodaycustomerorderprice->total_amount,2):'0.00'?></label></td>
															</tr>
															<tr >
																<td ><label style="color:#333333;font-size: 16px;">Today Total Payment Receive:</label> </td>
																<?php $total_paid_amt =$gettodaySalesinvoceprice->total_sales_paid_amt + $gettodaycustomerorderprice->total_gold_paid_amt; ?>
																<?php $total_ordert =$gettodaySalesinvoceprice->total_order + $gettodaycustomerorderprice->total_order; ?>
																<td style="padding-left: 15%; text-align:left;"><label style="color:#333333;font-size: 16px;"><?=!empty($total_ordert)?number_format($total_ordert,2):'0.00'?></label></td>
																<td style="padding-left: 50%;text-align:right;"><label style="color:#333333;font-size: 16px;"><?=!empty($total_paid_amt)?number_format($total_paid_amt,2):'0.00'?></label></td>
															</tr>
															
														</tbody>
													</table>
												</div>
											<hr>
										</div>
									</div>
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
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]},
                },
                {
                    extend: "pageLength",
                },
            ],
            order: [1, 'desc'],
            responsive: true,
				"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
				$( api.table().column(6).footer() ).html("<strong>Grand Total : "+addCommas(api.column( 6, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				}
        });
		
		
//		
//				$(".del_sale_pop").click(function () {
//						var val_link = $(this).attr('data-val');
//						 $('#val_link').val(val_link);
//						 $('.popup_sales').modal('show');
//				});
//
//				$(".remove_sale_data").click(function () {
//						var val_link = $('#val_link').val();
//						window.location.href= val_link;
//						$('.popup_sales').modal('hide');
//				});
		});

    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>

<?php
require_once 'includes/footer.php';
?>