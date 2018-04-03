<?php 
$alert_msg=$this->session->userdata('alert_msg');
?>
<script type="text/javascript">
    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Received Work Orders</h1>
        </div>
    </div><!--/.row-->

    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="search_box" method="get" >
						
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-2">
								<label>Goldsmith</label>
								<select class="form-control" name="Goldsmith">
									<option  value="">Select Goldsmith</option>
								   <?php  foreach($goldsmith as $gold){
									    $selected = '';
										if(!empty($this->input->get('Goldsmith')))
										{
											if($this->input->get('Goldsmith') == $outlet->id)
											{
												$selected = 'selected';
											}
										}
								    ?>
									<option <?=$selected?> value="<?php echo $gold->gs_id; ?>" > <?php echo $gold->fullname; ?></option>
								   <?php } ?>
								</select>
							</div>
							
                            <div class="col-md-2">
								<label>Outlet</label>
								<select class="form-control" name="outlet">
									<option  value="">Select Outlet</option>
								   <?php  foreach($getOutlet as $outlet) 
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
									<option <?=$selected?> value="<?php echo $outlet->id; ?>" > <?php echo $outlet->name; ?></option>
									<?php }
									?>
								</select>
							</div>
							
                            <div class="col-md-2">
								<label>Start Date</label>
								<input type="text" class="form-control" name="startDate" value="<?=!empty($this->input->get('startDate'))?$this->input->get('startDate'):''?>" id="startDate">
							</div>
							
                            <div class="col-md-2">
								<label>End Date</label>
								<input type="text" class="form-control" name="endDate" id="endDate" value="<?=!empty($this->input->get('endDate'))?$this->input->get('endDate'):''?>">
							</div>
							
							
					
					
							
                            <div class="col-md-2" style="margin-top: -15px;">
                                <div class="form-group">
                                    <label>&nbsp;</label><br />
                                    <input type="submit" class="btn btn-primary" style="width: 100%; margin-top: 14px;height: 41px" value="Search" >
                                </div>
                            </div>
                      
						</div>
                    </form>
                
                    
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12" >
                            
                            <div class="table-responsive">
                                <table class="table" id="ReceivedWorkOrders">
                                    <thead>
                                        <tr>
											<th>Date & Time</th>
											<th>Outlet</th>
											<th>Received Work Order </th>
											<th>Goldsmith</th>
											<th>Work Order No.</th>
											<th>Item</th>
											<th>Total Weight (g)</th>
											<th>Action</th>
										</tr>
                                    </thead>
									
                                    <tbody id="replaceable">
                                        <?php foreach($getProducationReceive as $value) { ?>
											<tr>
												<td><?=$value->create_date?></td>
												<td><?=$value->outletname?></td>
												<td><?=$value->id?></td>
												<td><?=$value->gold_smith_name?></td>
												<td><?=$value->customer_order_no?></td>
												<td><?=$value->product_name  ?></td>
												<td><?= number_format($value->item_weight,2) ?></td>
												<td>
													<a onclick="openReceipt('<?=base_url()?>/Productions/print_received_work_orders?id=<?=$value->id?>')" class="btn btn-primary" style=" width: 80px; padding: 0px; text-decoration: none; cursor: pointer;" title="Print Receipt">
															<i class="icono-list" style="color: #ffffff;"></i>
													</a>
													<button class="btn btn-primary" style="width: 80px;"   data-toggle="modal" data-target="#myModal<?php echo $value->id; ?>">View</button>
													<button class="btn btn-primary" style="width: 80px;"   data-toggle="modal" data-target="#Note<?php echo $value->id; ?>">Note</button>
												</td>
												<div id="Note<?php echo $value->id; ?>" class="modal fade" role="dialog">
													<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">All Note Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Note </b>
																</div>
																<div class="col-md-8">
																<?=$value->note?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Note Detail</b>
																</div>
																<div class="col-md-8">
																	<?=$value->note_details?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Item Details</b>
																</div>
																<div class="col-md-8">
																	<?=$value->item_details?>
																</div>
															</div>
														
															
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
									
									
									
												<div id="myModal<?php echo $value->id; ?>" class="modal fade" role="dialog">
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
																<?=$value->create_date?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Received Work Order No</b>
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
																	<?=$value->outletname?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Work order No</b>
																</div>
																<div class="col-md-8">
																	<?=$value->customer_order_no?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Product Category</b>
																</div>
																<div class="col-md-8">
																	<?=$value->category_name?>
																	
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Item</b>
																</div>
																<div class="col-md-8">
																	<?=$value->product_name?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Ordered Qty</b>
																</div>
																<div class="col-md-8">
																	<?=$value->qty?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Received Qty</b>
																</div>
																<div class="col-md-8">
																	<?=$value->receive_qty?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Total Item Weight (g)</b>
																</div>
																<div class="col-md-8">
																	<?=number_format($value->item_weight,2) ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Total Stone weight</b>
																</div>
																<div class="col-md-8">
																	<?=$value->stone_weight?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Received Store</b>
																</div>
																<div class="col-md-8">
																	<?=$value->storename?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Goldsmith</b>
																</div>
																<div class="col-md-8">
																	<?=$value->gold_smith_name?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Total Net Gold Weight (g)</b>
																</div>
																<div class="col-md-8">
																	<?=$value->category_name?>
																</div>
															</div>
<!--															<div class="row">
																<div class="col-md-4">
																	<b>Wastage Per gram</b>
																</div>
																<div class="col-md-8">
																<?=$value->category_name?>
																</div>
															</div>-->
															<div class="row">
																<div class="col-md-4">
																	<b>wastage</b>
																</div>
																<div class="col-md-8">
																	<?=$value->wastage?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Total wastage (g)</b>
																</div>
																<div class="col-md-8">
																	<?=$value->total_wastage?>
																</div>
															</div>
<!--															<div class="row">
																<div class="col-md-4">
																	<b>Total Gold weight (Total Net Gold weight + Total Wastage)</b>
																</div>
																<div class="col-md-8">
																	<?=$value->category_name?>
																</div>
															</div>-->
															<div class="row">
																<div class="col-md-4">
																	<b>Stone Cost</b>
																</div>
																<div class="col-md-8">
																	<?=$value->stone_weight?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Labour Cost</b>
																</div>
																<div class="col-md-8">
																	<?=$value->labour_cost?>
																</div>
															</div>
<!--															<div class="row">
																<div class="col-md-4">
																	<b>Other Cost</b>
																</div>
																<div class="col-md-8">
																	<?=$value->category_name?>
																</div>
															</div>-->
															
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
											</tr>
										<?php } ?>
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








<script>
	$(document).ready(function () {

		$("#ReceivedWorkOrders").DataTable({
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
			responsive: true,
			
		});
	});
</script>
    

 