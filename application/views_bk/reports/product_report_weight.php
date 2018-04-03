<?php
//require_once '../includes/header.php';
$this->load->view('includes/header');
?>
<style>
	div#example_filter {
		display: none;
	}

	div#example_length {
		display: none;
	}
</style>
<script type="text/javascript">
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



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Product Report</h1>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row" style="padding-bottom: 8px;">
						<div class="col-md-12">
							<div class="col-md-6">
								<a href="<?= base_url() ?>reports/product_purchase_report"
								   style="text-decoration: none;">
									<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
										Purchase Report
									</button>
								</a>
								<a href="<?= base_url() ?>reports/sale_report"
								   style="text-decoration: none;">
									<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
										Sales Report
									</button>
								</a>
<!--								<a href="<?= base_url() ?>reports/sale_bar_chart"
								   style="text-decoration: none;">
									<button type="button" class="btn btn-success"
											style="background-color: #5cb85c; border-color: #4cae4c;">
										Sales Bar Chart
									</button>
								</a>-->
							</div>
<!--							<div class="col-md-6" style="text-align: right;">
								<a href="<?= base_url() ?>reports/exportProductReport"
								   style="text-decoration: none;">
									<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
										Export to Excel
									</button>
								</a>
							</div>-->
						</div>

					</div>

					<form action="<?= base_url() ?>reports/product_report" method="get">
						<div class="row">
							<div class="col-md-7"></div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" required=""  name="start_date" class="form-control" id="startDate" value="<?php echo $url_start; ?>"/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control"
										   id="endDate" required="" value="<?php echo $url_end; ?>"/>
								</div>
							</div>
							<div class="col-md-1">
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
							<div class="table-responsive">
								<table id="datatable" class="table" cellspacing="0" width="100%">
									<thead>
                                        <tr>
											<th style="display: none;">#</th>
											<th style="text-align: left;" width="10%">Date & Time</th>
											<th style="text-align: left;" width="10%">Outlet</th>
											<th style="text-align: left;" width="10%">Stores</th>
                                            <th style="text-align: left;" width="10%">Code <i class="fa fa-fw fa-sort"></i></th>
                                            <th style="text-align: left;" width="10%">Type</th>
                                            <th style="text-align: left;" class="sorting" width="10%">Name<i class="fa fa-fw fa-sort"></i></th>
                                            <th style="text-align: left;" width="15%">Supplier Name</th>
                                            <th style="text-align: left;" width="20%">Opening Qty</th>
                                            <th style="text-align: left;" width="20%">Purchased Qty</th>
                                            <th style="text-align: left;" width="20%">Bonus Qty</th>
                                            <th style="text-align: left;" width="20%">Sold Qty</th>
                                            <th style="text-align: left;" width="20%">Balance Qty</th>
                                        </tr>
									</thead>
									<tbody>
										<?php
											$total_opening_qty		= 0;
											$total_purchased_qty	= 0;
											$total_sold_qty			= 0;
											$total_balance_qty		= 0;
											
											$i = 1;
											foreach($results as $value)
											{ 
												
												$TodayAllQty = $this->Reports_model->TodayAllQty($value->code);
												$finalbalance = $this->Reports_model->LastTotalBalance($value->code);
												$TotalPurchaseQty	= $TodayAllQty->TotalPurchaseQty;
												$TotalBonusQty	= $TodayAllQty->totalBonusqty;
												$totalSaleQty		= $TodayAllQty->totalSaleQty;
												
												$TotalOpening		= ($finalbalance+$totalSaleQty) - ($TotalPurchaseQty+$TotalBonusQty);
												$total_opening_qty = $total_opening_qty + $TotalOpening;
												$total_purchased_qty = $total_purchased_qty + $TotalPurchaseQty;
												$total_sold_qty = $total_sold_qty + $totalSaleQty;
												
												
												$total_balance_qty = $total_balance_qty + $finalbalance;
												
												?>
												<tr>
													<td style="display: none;"><?=$i++;?></td>
													<td width="10%"><?php echo $value->created_datetime; ?>
													</td>	
													<td width="10%"><?php echo $value->outletname; ?></td>	
														<td width="10%">
															<?php
															$string = '';
															$inventorydate = $this->Reports_model->getInventoryDetail($value->code);
															foreach ($inventorydate as $invedetail)
															{
																$store = $this->Reports_model->getWarehosueDetail($invedetail->ow_id);
																$string.= $store.',';
															}
															echo rtrim($string,",");
															?>
														</td>
														<td width="10%">
															<?php
															if($value->product_type != 'bulk')
															{
																echo $value->code;
															}
															?>
														</td>	
														<td width="10%">
													<?php
													if($value->product_type == 'bulk')
													{
														echo "Bulk";
													}
													else
													{
														echo "Normal";
													}
													?>
														</td>	
													<td width="10%"><?php echo $value->name; ?></td>	
													<td width="10%"><?php echo $value->suppliers_name; ?></td>	
													<td width="10%"><?=!empty($TotalOpening)?number_format($TotalOpening,2):0?></td>	
													<td width="10%"><?=!empty($TotalPurchaseQty)?number_format($TotalPurchaseQty,2):0?></td>	
													<td width="10%"><?=!empty($TotalBonusQty)?number_format($TotalBonusQty,2):0?></td>	
													<td width="10%"><?=!empty($totalSaleQty)?number_format($totalSaleQty,2):0?></td>	
													<td width="10%"><?=!empty($finalbalance)?number_format($finalbalance,2):0?></td>	
												</tr>
											<?php 
											}
											?>
									</tbody>
									<tfoot>
										<tr>
											<td style="display: none;">#</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
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
<!--									<tr>
										<td><label style="color:#333333; font-size: 16px;">Total Opening Qty:</label> </td>
										<td><label style="color:#333333; font-size: 16px;"><?php //echo empty($total_opening_qty)?number_format($total_opening_qty,2):'0.00'?></label></td>
									</tr>-->
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Purchased Qty:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($total_purchased_qty)?number_format($total_purchased_qty,2):'0.00'?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Sold Qty:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($total_sold_qty)?number_format($total_sold_qty,2):'0.00'?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Balance Qty:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($total_balance_qty)?number_format($total_balance_qty,2):'0.00'?></label></td>
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
	$this->load->view('includes/header_notification.php');
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
			order:[0,"desc"],
            responsive: true,
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
//				$( api.table().column(8).footer() ).html("<strong>"+addCommas(api.column( 8, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				$( api.table().column(9).footer() ).html("<strong>"+addCommas(api.column( 9, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				$( api.table().column(10).footer() ).html("<strong>"+addCommas(api.column( 10, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				$( api.table().column(11).footer() ).html("<strong>"+addCommas(api.column( 11, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				$( api.table().column(12).footer() ).html("<strong>"+addCommas(api.column( 12, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
			}
        });
    });
</script>

<?php
	$this->load->view('includes/footer.php');
?>