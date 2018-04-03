<?php
//require_once '../includes/header.php';
$this->load->view('includes/header');
?>
<script>
	
	function openReceipt(ele){
		window.open(ele, "", "width=380, height=550");
	}	
	function openReceiptDetail(ele) {
        window.open(ele, "", "width=650, height=650");
    }
	
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">List Of Sales Return</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">

					<form action="" method="get">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate"  value="<?=!empty($this->input->get('start_date')) ? $this->input->get('start_date') : ''?>" />
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
									<input type="submit" class="btn btn-primary" value="Search" />
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
											<th>Date</th>
											<th>Return Sale Id</th>
											<th>Outlet</th>
											<th>Customer Name</th>
											<th>Returned Payment Type</th>
											<th>Refund Method</th>
											<th>Condition</th>
											<th>Returned QTY</th>
											<th>Tax</th>
											<th>Grand Total </th>
											<th>User</th>
											<th width="18%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($getReturnSales as $value)
										{ ?>
											<tr>
												<td><?=$value->created_at?></td>
												<td><?=$value->id?></td>
												<td><?=$value->outlets_name?></td>
												<td><?=$value->customername?></td>
												<td><?=$value->payment_method_name?></td>
												<td><?php echo ($value->refund_method == 0) ? "Full Refund" : "Partial Refund";?></td>
												<td><?php echo ($value->condition == 0) ? "Good" : "Not Good";?></td>
												<td><?php echo !empty($value->returned_qty) ? number_format($value->returned_qty,2) : '0';?></td>
												<td><?php echo !empty($value->refund_tax) ? number_format($value->refund_tax,2) : '0';?></td>
												<td><?php echo !empty($value->refund_amount) ? number_format($value->refund_amount,2) : '0';?></td>
												<td><?=$value->fullname?></td>
												<td>
													<a class="btn btn-primary" onclick="openReceiptDetail('<?=base_url()?>returnorder/view_sales_return_detail?id=<?php echo $value->id; ?>')" style="text-decoration: none; cursor: pointer; " title="View Detail">
														Returned Items
													</a>
													
													<a onclick="openReceipt('<?=base_url()?>returnorder/printReturn?return_id=<?php echo $value->id; ?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
														<i class="icono-list" style="color: #005b8a;"></i>
													</a>
													
													
													<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $value->id; ?>">View</button>
														<div id="myModal<?php echo $value->id; ?>" class="modal fade" role="dialog">
															<div class="modal-dialog">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Basic Sales Return Detail</h4>
																	</div>
																	<div class="modal-body">
																		<div class="row">
																			<div class="col-md-4">
																				<b>Date & Time</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->created_at?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Return Sale Id</b>
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
																				<b>Customer Name</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->customername?>
																			</div>
																		</div>
																		
																		<div class="row">
																			<div class="col-md-4">
																				<b>Payment Name</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->payment_method_name?>
																			</div>
																		</div>
																		
																		<div class="row">
																			<div class="col-md-4">
																				<b>Refund Method</b>
																			</div>
																			<div class="col-md-8">
																				<?php 
																				echo ($value->refund_method == 0) ? "Full Refund" : "Partial Refund";
																				?>
																			</div>
																		</div>
																		
																		<div class="row">
																			<div class="col-md-4">
																				<b>Condition</b>
																			</div>
																			<div class="col-md-8">
																				<?php 
																				echo ($value->condition == 0) ? "Good" : "Not Good";
																				?>
																			</div>
																		</div>
																		
																		<div class="row">
																			<div class="col-md-4">
																				<b>Returned QTY</b>
																			</div>
																			<div class="col-md-8">
																				<?=!empty($value->returned_qty)?number_format($value->returned_qty,2):0?>
																			</div>
																		</div>
																		
																		<div class="row">
																			<div class="col-md-4">
																				<b>Refund Tax</b>
																			</div>
																			<div class="col-md-8">
																				<?=!empty($value->refund_tax)?number_format($value->refund_tax,2):0.00?>
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
																				<b>User</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->fullname?>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-4">
																				<b>Reason</b>
																			</div>
																			<div class="col-md-8">
																				<?=$value->remark?>
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
	$this->load->view('includes/footer.php');
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