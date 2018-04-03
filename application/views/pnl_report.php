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
        });

    });

    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Profit & Loss Report</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">

					<form action="" method="get">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Outlet</label>
									<select name="outlet" class="form-control" >
										<option value="">Select Outlet</option>
										<?php
										foreach ($getOutlets as $outlet)
										{
											$selected = '';
											if(!empty($this->input->get('outlet')))
											{
												if($outlet->id == $this->input->get('outlet'))
												{
													$selected = 'selected';
												}
											}
											else
											{
												if($outlet->id == 1)
												{
													$selected = 'selected';
												}
											}
											?>
										<option  <?=$selected?> value="<?=$outlet->id?>"><?=$outlet->name?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate_new" value="<?=$startdate?>" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate_new" value="<?=$end_date?>" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<input type="submit" class="btn btn-primary" value="Get Report" />
								</div>
							</div>
						</div>
					</form>

					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12" style="text-align: right;">
							<a href="<?= base_url() ?>pnl_report/exportpnlReport" style="text-decoration: none">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									Export to Excel
								</button>
							</a>
						</div>
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="example" class="display" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="12%">Date</th>
											<th width="5%">Sale Id</th>
											<th width="10%">Outlet</th>
											<th width="10%">Grand Total (<?php echo $site_currency; ?>)</th>
											<th width="10%">Cost (<?php echo $site_currency; ?>)</th>
											<th width="10%">Tax (<?php echo $site_currency; ?>)</th>
											<th width="8%">Profit (<?php echo $site_currency; ?>)</th>
											<th width="15%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$all_grand_amt = 0;
										$all_tax_amt = 0;
										$all_cost_amt = 0;
										$all_profit_amt = 0;
										foreach ($ProfileLossReport as $report) {
											$order_id = $report->gold_id;
											$each_sales_cost = 0;
											$totaltax = 0;
											$order_type = $report->status;
											$itemResult = $this->Pnlreport_model->getProfitLossItemReport($order_id);
											?>
												
												<div id="myModalCostItem<?php echo $order_id; ?>" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<!-- Modal content-->
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Item Detail</h4>
																</div>
																<div class="modal-body">
																	<div class="row" style="border-bottom: 1px solid #e3e3e3; margin-bottom: 5px;">
																		<div class="col-md-3" style="padding-bottom:  10px;">
																			<b>Product</b>
																		</div>
																		<div class="col-md-3" style="padding-bottom:  10px;">
																			<b>Qty</b>
																		</div>
																		<div class="col-md-3" style="padding-bottom:  10px;">
																			<b>Cost</b>
																		</div>
																		<div class="col-md-3" style="padding-bottom:  10px;">
																			<b>Total</b>
																		</div>
																	</div>
												<?php
												$total_item_cost = 0;
												foreach ($itemResult as $itemData) {
														$totaltax	= $totaltax + $itemData->tax;
														$item_cost	= $itemData->cost;
														$item_qty	= $itemData->qty;
														$itemsubTotal = $item_cost * $item_qty;
														$total_item_cost = $total_item_cost + $itemsubTotal;
														$each_sales_cost = $each_sales_cost + $itemsubTotal;
														?>
																	<div class="row" style="padding-top:2px;" >
																		<div class="col-md-3">
																			<?=$itemData->product_name?>
																		</div>
																		<div class="col-md-3">
																			<?=!empty($item_qty)?number_format($item_qty,2):'0.00'?>
																		</div>
																		<div class="col-md-3">
																			<?=!empty($item_cost)?number_format($item_cost,2):'0.00'?>
																		</div>
																		<div class="col-md-3">
																			<?=!empty($itemsubTotal)?number_format($itemsubTotal,2):'0.00'?>
																		</div>
																	</div>
																	
														<?php }
														?>
																	<div class="row" style="margin-top:5px;  border-top: 1px solid #e1e1e1;" >
																		<div class="col-md-3" style="padding-top: 10px;">
																			
																		</div>
																		<div class="col-md-3" style="padding-top: 10px;">
																			
																		</div>
																		<div class="col-md-3" style="padding-top: 10px;">
																			<b>Sub Cost</b>
																		</div>
																		<div class="col-md-3" style="padding-top: 10px;">
																			<b><?=!empty($total_item_cost)?number_format($total_item_cost,2):'0.00'?></b>
																		</div>
																	</div>
																	
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																</div>
															</div>
														</div>
													</div>
										<?php
											$each_profit	= $report->gold_grandtotal - $each_sales_cost - $totaltax;
											$all_grand_amt	= $all_grand_amt + $report->gold_grandtotal;
											$all_tax_amt	= $all_tax_amt + $totaltax;
											$all_cost_amt	= $all_cost_amt + $each_sales_cost;
											$all_profit_amt = $all_profit_amt + $each_profit;
											?>
											<tr>
												<td><?= date("$site_dateformat H:i A", strtotime($report->gold_ordered_datetime)); ?></td>
												<td><?= $order_id ?></td>
												<td><?= $report->gold_outlet_name ?></td>
												<td><?=!empty($report->gold_grandtotal)?number_format($report->gold_grandtotal, 2):'0.00' ?></td>
												<td><?=!empty($each_sales_cost)?number_format($each_sales_cost, 2):'0.00' ?></td>
												<td><?=!empty($totaltax)?number_format($totaltax, 2):'0.00' ?></td>
												<td><?=!empty($each_profit)?number_format($each_profit, 2):'0.00'?></td>
												<td>
													<?php
													if ($order_type == '1') {
														?>
														<a onclick="openReceipt('<?= base_url() ?>pos/view_invoice?id=<?php echo $order_id; ?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
															<i class="icono-list" style="color: #005b8a;"></i>
														</a>
														<?php
													}
													if ($order_type == '2') {
														?>
														<a onclick="openReceipt('<?= base_url() ?>returnorder/printReturn?return_id=<?php echo $order_id; ?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
															<i class="icono-list" style="color: #005b8a;"></i>
														</a>
													<?php }
													?>
													
													<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $order_id; ?>">View</button>
													<button class="btn btn-primary" data-toggle="modal" data-target="#myModalCostItem<?php echo $order_id; ?>">Cost Item</button>
													<div id="myModal<?php echo $order_id; ?>" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<!-- Modal content-->
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Profit & Loss Detail</h4>
																</div>
																<div class="modal-body">
																	<div class="row">
																		<div class="col-md-4">
																			<b>Date & Time</b>
																		</div>
																		<div class="col-md-8">
																			<?=date("$site_dateformat H:i A", strtotime($report->gold_ordered_datetime)); ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Sale Id</b>
																		</div>
																		<div class="col-md-8">
																			<?=$order_id;?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Outlet</b>
																		</div>
																		<div class="col-md-8">
																			<?= $report->gold_outlet_name ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Grand Total (<?php echo $site_currency; ?>)</b>
																		</div>
																		<div class="col-md-8">
																			<?= !empty($report->gold_grandtotal)?number_format($report->gold_grandtotal, 2):'0.00' ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Cost (<?php echo $site_currency; ?>)</b>
																		</div>
																		<div class="col-md-8">
																			<?=!empty($each_sales_cost)?number_format($each_sales_cost, 2):'0.00'?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Tax (<?php echo $site_currency; ?>)</b>
																		</div>
																		<div class="col-md-8">
																			<?=!empty($totaltax)?number_format($totaltax, 2):'0.00' ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Profit (<?php echo $site_currency; ?>)</b>
																		</div>
																		<div class="col-md-8">
																			<?=!empty($each_profit)?number_format($each_profit, 2):'0.00'?>
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
					<div class="row" style="padding-top: 10px; padding-bottom: 10px; margin-top: 50px; font-size: 18px; letter-spacing: 0.5px;">
						<div class="col-md-3" style="font-weight: bold;">Grand Total (<?php echo $site_currency; ?>)</div>
						<div class="col-md-9" style="font-weight: bold;">: <?=!empty($all_grand_amt)?number_format($all_grand_amt,2):'0.00'?></div>
					</div>

					<div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px;">
						<div class="col-md-3" style="font-weight: bold;">Cost Total (<?php echo $site_currency; ?>)</div>
						<div class="col-md-9" style="font-weight: bold;">: <?=!empty($all_cost_amt)?number_format($all_cost_amt,2):'0.00'?></div>
					</div>

					<div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px;">
						<div class="col-md-3" style="font-weight: bold;">Tax Total (<?php echo $site_currency; ?>)</div>
						<div class="col-md-9" style="font-weight: bold;">: <?=!empty($all_tax_amt)?number_format($all_tax_amt,2):'0.00'?></div>
					</div>
					
					<div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px;">
						<div class="col-md-3" style="font-weight: bold;">Expense Total (<?php echo $site_currency; ?>)</div>
						<div class="col-md-9" style="font-weight: bold;">: <?=!empty($getExpense)?number_format($getExpense,2):'0.00'?></div>
					</div>

					<div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px;">
						<div class="col-md-3" style="font-weight: bold;">Profit Total (<?php echo $site_currency; ?>)</div>
						<div class="col-md-9" style="font-weight: bold;">: <?php
							$TotalProfitLoss = $all_profit_amt - $getExpense;
							echo !empty($TotalProfitLoss)?number_format($TotalProfitLoss,2):'0.00' ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br /><br /><br />
</div>
   <script>
        $( function() {
			 
            $( "#startDate_new" ).datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
            });

            $("#endDate_new").datepicker({
                format: 'dd-mm-yyyy',
				autoclose: true,
            });
        } );
    </script>