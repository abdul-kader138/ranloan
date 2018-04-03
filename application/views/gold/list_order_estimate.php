<script type="text/javascript">
	function openReceiptDetail(ele) {
		var myWindow = window.open(ele, "", "width=850, height=850");
	}
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">List of Customer Orders<span class="pull-right">
                <a href="<?=base_url()?>gold/order_estimate" style="text-decoration: none">
                    <button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>Add Order Customer Bill</button>
                </a>
            </span></h1>

		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
		
					<div class="row">
				
<!--                        <br/>
                        <br/>-->
                        <form action="<?=base_url()?>Gold/list_order_estimate" method="get">
                            <div class="row" style="margin-top: 10px;">
                               
                            
                               
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" name="start_date" class="form-control" id="startDate" autocomplete="OFF"   value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" name="end_date" class="form-control" id="endDate" autocomplete="OFF"  value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Status</label>
											<select class="form-control" name="status">
												<option value="">Select Status</option>
												<option <?php if(!empty($this->input->get('status'))) { if ($this->input->get('status') == 6) { echo "selected"; }}  ?> value="6">Pending </option>
												<option <?php if(!empty($this->input->get('status'))) { if ($this->input->get('status') == 1) { echo "selected"; }}  ?>  value="1">Production  </option>
												<option <?php if(!empty($this->input->get('status'))) { if ($this->input->get('status') == 2) { echo "selected"; }}  ?>  value="2">Partly Completed</option>
												<option <?php if(!empty($this->input->get('status'))) { if ($this->input->get('status') == 3) { echo "selected"; }}  ?>  value="3">Completed </option>
												<option <?php if(!empty($this->input->get('status'))) { if ($this->input->get('status') == 4) { echo "selected"; }}  ?>  value="4">Part Delivery  </option>
												<option <?php if(!empty($this->input->get('status'))) { if ($this->input->get('status') == 5) { echo "selected"; }}  ?>  value="5">Delivered   </option>
											</select>
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
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
						<div class="table-responsive">
							<table class="table" id="datatable">
							    <thead>
							    	<tr>
                                        <th width="15%">Date & Time</th>
								    	<th width="10%">Customer Order No</th>
									    <th width="10%">Cutomer</th>
									    <!--<th width="12%">Goldsmith</th>-->
										<th width="12%">Sales Officers</th>
									    <th width="12%">Outlet</th>
									    <th width="12%">Grand Total</th>
									    <th width="12%">Status</th>
										<th width="12%" style="display:none;">Change Status</th>
									    <th width="15%">Action</th>
									</tr>
							    </thead>
								<tbody>
									<?php 
									$ProductionBills = 0;
									$PendingBills = 0;
									$CompletedBills = 0;
									$DeliveredBills = 0;
									$PartlyCompletedBills = 0;
									$PartlyDeliveredBills = 0;
									
									$ProductionBillscount = 0;
									$PendingBillscount = 0;
									$CompletedBillscount = 0;
									$DeliveredBillscount = 0;
									$PartlyCompletedBillscount = 0;
									$PartlyDeliveredBillscount = 0;
									
									foreach($getcustomer_order as $getview)
									{
										?>
									<tr>
										<td><?= date('d-m-Y H:i:s', strtotime($getview->gold_created_datetime)) ?></td>
										<td><?= $getview->gold_id?></td>
										<td><?= $getview->customername?></td>
										<!--<td></td>-->
										<td><?= $getview->salesname?></td>
										<td><?= $getview->outletsname?></td>
										<!--<td></td>-->
										<td><?=$getview->gold_grandtotal?></td>
										<td><?php
												if($getview->status == 0)
												{
													$PendingBillscount++;
													$PendingBills = $PendingBills + $getview->gold_grandtotal;
													echo 'Pending';
												}	
												else if($getview->status == 1)
												{
													$ProductionBillscount++;
													$ProductionBills = $ProductionBills + $getview->gold_grandtotal;
													echo 'Production';
												}
												else if($getview->status == 2)
												{
													$PartlyCompletedBillscount++;
													$PartlyCompletedBills = $PartlyCompletedBills + $getview->gold_grandtotal;
													echo 'Partly Completed';
												}
												else if($getview->status == 3)
												{
													$CompletedBillscount++;
													$CompletedBills = $CompletedBills + $getview->gold_grandtotal;	
													echo 'Completed';
												}
												else if($getview->status == 4)
												{
													$PartlyDeliveredBillscount++;
													$PartlyDeliveredBills = $PartlyDeliveredBills + $getview->gold_grandtotal;
													echo 'Part Delivery';
												}
												else if($getview->status == 5)
												{
													$DeliveredBillscount++;
													$DeliveredBills = $DeliveredBills + $getview->gold_grandtotal;
													echo 'Delivered';
												}
										
										?></td>
										<td style="display:none;">
											<select class="form-control" id="getStatus<?php echo $getview->gold_id; ?>">
												<option <?php if($getview->status == 0) echo "selected" ;?> value="0">Pending </option>
												<option <?php if($getview->status == 1) echo "selected" ;?> value="1">Production  </option>
												<option <?php if($getview->status == 2) echo "selected" ;?> value="2">Partly Completed</option>
												<option <?php if($getview->status == 3) echo "selected" ;?> value="3">Completed </option>
												<option <?php if($getview->status == 4) echo "selected" ;?> value="4">Part Delivery  </option>
												<option <?php if($getview->status == 5) echo "selected" ;?> value="5">Delivered   </option>
											</select>
										</td>
										<td>
											<a class="btn btn-primary" onclick="openReceiptDetail('<?= base_url() ?>Gold/view_order_detail?id=<?php echo $getview->gold_id; ?>')" style="padding: 4px 12px;"  title="View Detail">More Detail</a>
											<button class="btn btn-primary UpdateStatus" id="<?php echo $getview->gold_id; ?>" style="padding: 4px 12px; width: 80px;display:none" >Update</button>
											<button class="btn btn-primary oldModelHide" style="width: 70px;padding: 4px 12px;"   data-toggle="modal" data-target="#myModal<?php echo $getview->gold_id; ?>">View</button>
										</td>
									</tr>
									
									
											<div id="myModal<?php echo $getview->gold_id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Date & Time</b>
																</div>
																<div class="col-md-8">
																	<?= date('d-m-Y H:i:s', strtotime($getview->gold_created_datetime)) ?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Customer Order No</b>
																</div>
																<div class="col-md-8">
																	<?= $getview->gold_id?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Customer</b>
																</div>
																<div class="col-md-8">
																	<?= $getview->customername?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Sales Person Name</b>
																</div>
																<div class="col-md-8">
																	<?= $getview->salesname?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Outlet</b>
																</div>
																<div class="col-md-8">
																	<?= $getview->outletsname?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Grand Total</b>
																</div>
																<div class="col-md-8">
																	<?= $getview->gold_grandtotal?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Current Status</b>
																</div>
																<div class="col-md-8">
																	<?php
																		if($getview->status == 0)
																		{
																			echo 'Pending';
																		}	
																		else if($getview->status == 1)
																		{
																			echo 'Production';
																		}
																		else if($getview->status == 2)
																		{
																			echo 'Partly Completed';
																		}
																		else if($getview->status == 3)
																		{
																			echo 'Completed';
																		}
																		else if($getview->status == 4)
																		{
																			echo 'Part Delivery';
																		}
																		else if($getview->status == 5)
																		{
																			echo 'Delivered';
																		}
																	?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Ordered products with price &Qty</b>
																</div>
																<div class="col-md-8">
																	<?php $total_price= $getview->gold_stock_subtotal +$getview->gold_order_subtotal?>
																	<?php echo $total_price_qty= $total_price* $getview->gold_total_qty_item ?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Showroom Item</b>
																</div>
																<div class="col-md-8">
																</div>
															</div>
															
															
															<div class="row">
																<div class="col-md-4">
																	<b>Goldsmith</b>
																</div>
																<div class="col-md-8">
																	<?= $getview->gold_smith_name	?>
																</div>
															</div>
															
															
															<div class="row">
																<div class="col-md-4">
																	<b>Work order No</b>
																</div>
																<div class="col-md-8">
																<?= $getview->work_order_id	?>
																</div>
															</div>
																
															<div class="row">
																<div class="col-md-4">
																	<b>Receive Work order No</b>
																</div>
																<div class="col-md-8">
																	<?= $getview->receive_work_id?>
																</div>
															</div>
															
															
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
									
									
									
									<?php } ?>
					</tbody>
							</table>
						</div>
							
						</div>
					</div>
					
				
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
		
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 style="color: #990000;">Summery</h3>
										<hr>
						<div class="col-md-12">
							<table style="width: 50%">
								<tbody>
									<tr>
										<td><label style="color:#333333; font-size: 16px;">Pending Bills:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($PendingBills)?number_format($PendingBills,2):'0.00'?></label></td>
										<td width="40%"><label style="color:#333333;font-size: 16px;">Num Of (<?=$PendingBillscount?>)</label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Completed Bills:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($CompletedBills)?number_format($CompletedBills,2):'0.00'?></label></td>
										<td width="40%"><label style="color:#333333;font-size: 16px;">Num Of (<?=$CompletedBillscount?>)</label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Delivered Bills:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($DeliveredBills)?number_format($DeliveredBills,2):'0.00'?></label></td>
										<td width="40%"><label style="color:#333333;font-size: 16px;">Num Of (<?=$DeliveredBillscount?>)</label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Partly Completed Bills:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($PartlyCompletedBills)?number_format($PartlyCompletedBills,2):'0.00'?></label></td>
											<td width="40%"><label style="color:#333333;font-size: 16px;">Num Of (<?=$PartlyCompletedBillscount?>)</label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Partly Delivered Bills:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($PartlyDeliveredBills)?number_format($PartlyDeliveredBills,2):'0.00'?></label></td>
											<td width="40%"><label style="color:#333333;font-size: 16px;">Num Of (<?=$PartlyDeliveredBillscount?>)</label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Production Bills:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($ProductionBills)?number_format($ProductionBills,2):'0.00'?></label></td>
											<td width="40%"><label style="color:#333333;font-size: 16px;">Num Of (<?=$ProductionBillscount?>)</label></td>
									</tr>
								</tbody>
							</table>
						</div>
					<hr>
				</div>
			</div>
		</div>
		
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	



	<script>
	$(document).ready(function () {
		
		$('.table').delegate('.UpdateStatus','click',function(){
			var id = $(this).attr('id');
			var statusval = $('#getStatus'+id).val();
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Gold/UpdateStatus",
				data: {statusval: statusval,id:id},
				dataType: 'JSON',
				success:function(data){
					alert('Status Successfully Change');
					location.reload();
				}
			 });
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
			order:[1,'desc'],
			responsive: true,
			
		});
		
		$('.PopupCustomer').click(function(){
		var id = $(this).attr('id');
		$('#myModalData'+id).modal('show');
		});
	
	});
</script>
	
