<?php
    require_once 'includes/header.php';
?>
<script type="text/javascript">
    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Credit Sales (Debit)</h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="<?=base_url()?>debit/searchDebit" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-3">
								<div class="form-group">
									<label>Customer Name</label>
									<input type="text" name="search_name" class="form-control" style="height: 35px" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Date From</label>
									<input type="text" name="start_date" class="form-control" id="startDate" style="height: 35px" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Date To</label>
									<input type="text" name="end_date" class="form-control" id="endDate" style="height: 35px" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<input type="hidden" name="report" value="1" />
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
								    	<th width="16%">Sale Id</th>
								    	<th width="16%">Date</th>
								    	<th width="16%">Outlet</th>
								    	<th width="16%">Customer</th>
								    	<th width="16%">Grand Total</th>
								    	<th width="10%">Unpaid Amt</th>
								    	<th width="10%">Credit Limit Code</th>
									    <th width="10%">Action</th>
									</tr>
							    </thead>
								<tbody>
								<?php
										$total_unpaid_amt = 0;
										$total_client = 0;
										foreach ($results as $data) {
											$total_client = $total_client + 1;
                                            $id = $data->id;
                                            $cust_name = $data->customer_name;
                                            $order_date = date("$display_dateformat", strtotime($data->ordered_datetime));
                                            $outlet_name = $data->outlet_name;
                                            $grandTotal = $data->grandtotal;
                                            $paid_amt = $data->paid_amt;
										    $unpaid_amt = 0;
                                            $unpaid_amt = $paid_amt - $grandTotal; 
											$out_unpaid_amt = $grandTotal - $paid_amt; 
											$outstanding = $grandTotal - $paid_amt; 
											$total_unpaid_amt = $total_unpaid_amt + $out_unpaid_amt;
											?>
                                			<tr>
	                                			<td><?php echo $id; ?></td>
	                                			<td><?php echo $order_date; ?></td>
	                                			<td><?php echo $outlet_name; ?></td>
	                                			<td><?php echo $cust_name; ?></td>
												<td><?php echo !empty($grandTotal)?number_format($grandTotal, 2):0; ?></td>
												<td><?php echo !empty($unpaid_amt)?number_format($unpaid_amt, 2):0; ?></td>
												<td>
													<?php
														$creditlimit = $data->credit_amount;
														if($creditlimit != 0 && $outstanding != 0)
														{
															$percenttage = ($outstanding * 100) / $creditlimit;
															foreach ($getCreditColor as $color)
															{
																if($color->to > $percenttage && $color->from < $percenttage )
																{ ?>
																	<button class="btn" style="background: #<?=$color->color?>">&nbsp;</button>
																	<?php 
																}
																else if($percenttage > 100)
																{ ?>
																	<button class="btn" style="background: #cc0000">&nbsp;</button>
																<?php 
																	break;
																}
															}
														}
														?>
												</td>
	                                			<td width="10%">
													<button class="btn btn-primary PopupDebit" id="<?php echo $id; ?>" style="padding: 4px 12px; width: 80px;" >Action</button>
													<div id="myModalData<?php echo $id; ?>" class="modal fade" role="dialog">
															<div class="modal-dialog">
																<!-- Modal content-->
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Choose Your Action</h4>
																	</div>
																	<div class="modal-body">
																		<ul style="list-style-type:none; text-align:center;">
																				<li>
																					<a class="btn btn-primary" href="<?=base_url()?>debit/make_payment?id=<?php echo $id; ?>" style="text-decoration: none;width: 117px;">
																							Make Payment	
																					</a>
																				</li>
<!--																				<li style="margin-top: 5px;">
																					<a class="btn btn-primary"   onclick="openReceiptDetail('<?=base_url()?>pos/view_order_detail?id=<?php echo $data->gold_orders_id; ?>')" style="text-decoration: none; cursor: pointer;width: 117px; " title="View Detail">
																						Detail
																					</a>
																				</li>
																				
																				<li style="margin-top: 5px;">
																					<a  class="btn btn-primary"  onclick="openReceipt('<?=base_url()?>debit/debit_print?id=<?=$id?>')" style="text-decoration: none; cursor: pointer; width: 117px;padding: 0px; color: #ffffff;" title="Print Receipt">
																							<i class="icono-list" style="color: #ffffff;"></i>
																					</a>
																				</li>-->
																				
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
								<tfoot>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
									</tfoot>
							</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 style="color: #990000;">Outstanding Summery</h3>
					<hr>
						<div class="col-md-12">
							<table>
								<tbody>
									<tr>
										<td><label style="color:#333333; font-size: 16px;">No of Outstanding Clients:</label> </td>
										<td><label style="color:#333333; font-size: 16px;"><?=number_format($total_client,2)?></label> </td>

									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Outstanding Amount:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=number_format($total_unpaid_amt,2)?></label></td>
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
    require_once 'includes/footer.php';
?>
<script>
	function openReceiptDetail(ele){
		var myWindow = window.open(ele, "", "width=650, height=650");
	}	
	$(document).ready(function () {
		
		$('.table').delegate('.PopupDebit','click',function(){
			var id = $(this).attr('id');
			$('#myModalData'+id).modal('show');
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
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
				var pagetotal = addCommas(api.column( 6, {page:'current'} ).data().sum().toFixed(2));
				$( api.table().column(5).footer() ).html("<strong>"+addCommas(api.column( 5, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				$( api.table().column(4).footer() ).html("<strong>"+addCommas(api.column( 4, {page:'current'} ).data().sum().toFixed(2))+" (g) </strong>");
			}
		});
	});
</script>