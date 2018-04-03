<?php
//require_once 'includes/header.php';
$this->load->view('includes/header');

?>
<script src="<?= base_url() ?>assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/datatable/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/datatable/jquery-ui.css">
<script src="<?= base_url() ?>assets/datatable/jquery-1.12.4.js"></script>
<script src="<?= base_url() ?>assets/datatable/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/datatable/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/datatable/buttons.dataTables.min.css">
<script src="<?= base_url() ?>assets/datatable/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/datatable/sum().js"></script>
<script src="<?= base_url() ?>assets/datatable/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/datatable/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/datatable/buttons.print.min.js"></script>

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

<script type="text/javascript">
    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>
<style>
	.modal-dialog{
      width:60%;
      margin: auto;
	}
</style>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-6">
			<h1 class="page-header">Product Sales Report</h1>
		</div>
		<div class="col-lg-6" style="text-align: right;">
			<br />
			
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row" style="padding-bottom: 8px;">
						<div class="col-md-12">
							<div class="col-md-6">
								<a href="<?= base_url() ?>reports/product_report" class="btn btn-success">Product Report</a>
								<a href="<?= base_url() ?>reports/product_purchase_report" class="btn btn-success">Purchase Report</a>
							</div>
							<div class="col-md-6" style="text-align: right;">
								<a href="<?=base_url()?>reports/exportSalesReport"  class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">Export to Excel</a>
							</div>
						</div>

					</div>
					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-6"></div>
<!--							<div class="col-md-3">
								<div class="form-group">
									<label>Payment Type</label>
									<select name="payment_type" class="form-control">
										<option value="">Select Payment Type</option>
										<?php
										foreach ($payment_methods as $pay)
										{
											$selected = '';
											if(!empty($this->input->get('payment_type')))
											{
												if($this->input->get('payment_type') == $pay->id)
												{
													$selected = 'selected';
												}
											}
											?>
										<option <?=$selected?> value="<?=$pay->id?>"><?=$pay->name?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Outlet</label>
									<select name="outlet" class="form-control">
										<option value="">Select Outlet</option>
										<?php
										foreach ($getOutlets as $outlet)
										{ 
											$selected = '';
											if(!empty($this->input->get('outlet')))
											{
												if($this->input->get('outlet') == $outlet->id)
												{
													$selected = 'selected';
												}
											}
											
											?>
										<option <?=$selected?> value="<?=$outlet->id?>"><?=$outlet->name?></option>
										<?php }
										?>
									</select>
								</div>
							</div>-->
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate" value="<?=!empty($this->input->get('start_date')) ? $this->input->get('start_date') : ''?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate" value="<?=!empty($this->input->get('end_date')) ? $this->input->get('end_date') : ''?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<button class="btn btn-primary" style="width: 100%;">Search</button>
								</div>
							</div>
						</div>
					</form>

					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th width="12%">Serial No</th>
											<th width="12%">HR No</th>
											<th width="12%">Customer Name</th>
											<th width="12%">Code</th>
											<th width="12%">Name</th>
											<th width="12%">Outlet</th>
											<th width="12%">Sold Qty</th>
											<th width="10%">Sub Total (<?php echo $site_currency; ?>)</th>
											<th width="10%">Grand Total (<?php echo $site_currency; ?>)</th>
											<th width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$totalQtysold = 0;
										$totalQtysoldIncome = 0;
//										print_r($getSalesReturnReport);
//										die;
										foreach ($getSalesReport as $value)
										{
											$totalQtysold = $totalQtysold + $value->total_items;
											$totalQtysoldIncome = $totalQtysoldIncome + $value->totalamount;
											$order_id = $value->id;
											?>
											<tr>
												<td><?=$value->id?></td>
												<td><?php
												if(!empty($value->settlement_no))
												{ ?>
													Settle -  <?=$value->settlement_no?>
											<?php	}
												else
												{ ?>
													POS - <?=$order_id?>
												<?php }
												
												?></td>
												
												<td><?=$value->fullname?></td>
												<td><?=$value->product_code?></td>
												<td><?=$value->product_name?></td>
												<td><?=$value->outlet_name?></td>
												<td><?=!empty($value->total_items)?number_format($value->total_items,2):0?></td>
												<td><?=!empty($value->tpaid)?number_format($value->tpaid,2):0?></td>
												<td><?=!empty($value->totalamount)?number_format($value->totalamount,2):0?></td>
<!--												
												<td style="display: none;"><?=$value->id?></td>
												<td><?=date("$site_dateformat H:i A", strtotime($value->ordered_datetime))?></td>
												<td><?=$value->order_id?>-<?=$order_id?></td>
												
												<td><?=$value->payment_method_name?>
												<?php
//													if (!empty($value->cheque_number)) {
//														echo "<br />(Cheque No. : $value->cheque_number)";
//													}
												?>
												</td>-->
												<td>
													<a href="<?= base_url() ?>reports/sales_report_detail?id=<?php echo $value->id;?>" class="btn btn-success">View Detail</a>
												<?php
													if ($value->status == '1') {
														?>
<!--														<a onclick="openReceipt('<?= base_url() ?>pos/view_invoice?id=<?php echo $order_id; ?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
															<i class="icono-list" style="color: #005b8a;"></i>
														</a>-->
													<?php
													}
													if ($value->status == '2') 
													{
													?>
<!--														<a onclick="openReceipt('<?= base_url() ?>returnorder/printReturn?return_id=<?php echo $order_id; ?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
															<i class="icono-list" style="color: #005b8a;"></i>
														</a>-->
													<?php 
													}
												?>
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
		
		
	<div class="row">
			<div class="col-lg-6">
				<h1 class="page-header">&nbsp;Product Sales Return Report</h1>
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
											<th width="12%">Serial No</th>
											<th width="12%">Customer Name</th>
											<th width="12%">Outlet</th>
											<th width="12%">Return Qty</th>
											<th width="10%">Grand Total (<?php echo $site_currency; ?>)</th>
											<th width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($getSalesReturnReport as $valueretun)
										{	?>
											<tr>
												<td><?=$valueretun->id?></td>
												<td><?=$valueretun->fullname?></td>
												<td><?=$valueretun->outlet_name?></td>
												<td><?=!empty($valueretun->returned_qty)?number_format($valueretun->returned_qty,2):0?></td>
												<td><?=!empty($valueretun->grandtotal)?number_format($valueretun->grandtotal,2):0?></td>

												<td>
												<button class="btn btn-primary Popupreturnsales" id="<?php echo $valueretun->id; ?>" >View Detail</button>
														
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
																					<th width="12%">Customer Name</th>
																					<th width="12%">Code</th>
																					<th width="12%">Name</th>
																					<th width="12%">Outlet</th>
																					<th width="12%">Return Qty</th>
																					<th width="12%">Amount</th>
																					<th width="10%">Sub Total </th>
																				</tr>
																			</thead>
																			<tbody>
																				<?php 
																				$return_item_id=$valueretun->id;
																				$returnitemdata = $this->Reports_model->getreturnItemVal($return_item_id);
																				$totalqty=0;
																				$totalprice=0;
																				$totalSub=0;
																				foreach($returnitemdata as $retValItem)
																				{	
																					$totalqty=$totalqty+$retValItem->qty;
																					$totalprice=$totalprice+$retValItem->price;
																					$totalSub=$totalSub+$retValItem->subtotal;
																				?>
																				<tr>
																					<td><?=$valueretun->fullname?></td>
																					<td><?=$retValItem->product_code?></td>
																					<td><?=$retValItem->product_name?></td>
																					<td><?=$valueretun->outlet_name?></td>
																					<td><?=!empty($retValItem->qty)?number_format($retValItem->qty,2):0?></td>
																					<td><?=!empty($retValItem->price)?number_format($retValItem->price,2):0?></td>
																					<td><?=!empty($retValItem->subtotal)?number_format($retValItem->subtotal,2):0?></td>
																				</tr>
																				<?php
																				}
																				?>
																					
																				<tr>
																					<td><b>Total</b><td>
																					<td></td>
																					<td></td>
																					<td><b><?=!empty($totalqty)?number_format($totalqty,2):0?></b></td>
																					<td><b><?=!empty($totalprice)?number_format($totalprice,2):0?></b></td>
																					<td><b><?=!empty($totalSub)?number_format($totalSub,2):0?></b></td>
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
		
		
		
		
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 style="color: #990000;">Summery</h3>
										<hr>
						<div class="col-md-12">
							<table>
								<tbody>
									<tr>
										<td><label style="color:#333333; font-size: 16px;">Total QTY Sold:</label> </td>
										<td><label style="color:#333333; font-size: 16px;"><?=!empty($totalQtysold)?number_format($totalQtysold,2):'0.00'?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Income on the Total Sold:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($totalQtysoldIncome)?number_format($totalQtysoldIncome,2):'0.00'?></label></td>
									</tr>
									
								</tbody>
							</table>
						</div>
					<hr>
				</div>
			</div>
		</div>
	</div>
	<br /><br /><br />
</div>







	
<?php
//	require_once 'includes/header_notification.php';
	$this->load->view('includes/header_notification.php');
?>
<script>
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
	
	
	$('.Popupreturnsales').click(function(){
		var id = $(this).attr('id');
		$('#myModalData'+id).modal('show');
	});
</script>
<?php
//require_once 'includes/footer.php';
	$this->load->view('includes/footer.php');
?>