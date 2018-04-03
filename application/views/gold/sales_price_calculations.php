

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Sales Price Calculations</h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
		
					<div class="row">
						<div class="col-md-12">
							<form action="" method="get">
								<div class="row" style="margin-top: 10px;">
									<div class="col-md-3">
										<div class="form-group">
											<label>Sub Category</label>
											<select class="form-control" name="subcategory">
												<option value="">All</option>
												<?php foreach($getSubCategory as $cate_view){ ?>
												<option value="<?=$cate_view->id?>"><?=$cate_view->sub_category?></option>
												<?php } ?>
											</select>
										</div>
									</div>
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
											<label>&nbsp;</label><br />
											<button class="btn btn-primary" style="width: 100px;">Search</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table" id="datatable">
							    <thead>
							    	<tr>
                                        <th>Date & Time</th>
                                        <th>Code</th>
                                        <th>Item</th>
                                        <th>Sub Category</th>
                                        <th>Weight</th>
                                        <th>Purchase / Transferred Cost</th>
                                        <th>Sale Price</th>
                                        <th>Minimum Sales Price</th>
                                        <th>Action</th>
									</tr>
							    </thead>
									<tbody>
										<?php foreach($getProduct_invertory as $listview) {
												
												$grade_id_product = $listview->grade_id;
												$category		  = $listview->category;
												$sub_category     = $listview->sub_category_id_fk;

												$profile_calculation = $this->Sales_model->getProfileCalculationData($grade_id_product, $category, $sub_category);
												
												$profit		= !empty($profile_calculation->profit)?$profile_calculation->profit:0;
												$min_profit = !empty($profile_calculation->min_profit)?$profile_calculation->min_profit:0;
		
												$gold_purity = 0;
												$grade_name = '';
												if(!empty($grade_id_product))
												{
													$value		 = $this->Sales_model->getSingleGoldGrade($grade_id_product);
													$grade_name	 =	!empty($value->grade_name)?$value->grade_name:'';
													$gold_purity =	!empty($value->gold_purity)?$value->gold_purity:0;
												}
			
												$get_grade = $this->Constant_model->getLastGoldGradePrice();
												$CurrentPrice = !empty($get_grade->gp_price)?$get_grade->gp_price:0;
												$gp_purity	  = !empty($get_grade->gp_purity)?$get_grade->gp_purity:0;
												$cal = 0;

												if($grade_name == 24)
												{
													$cal = $CurrentPrice;
												}
												else
												{
													$cal = ($CurrentPrice / $gp_purity) * $gold_purity;
												}
												$NetGoldWeight = !empty($listview->NetGoldWeight) ? $listview->NetGoldWeight:0;
												
												$calgoldnetWight = ($cal * ($NetGoldWeight + $listview->Wastagegold)) + $listview->TotalAllOtherCost;
												
												$salesPrice = $calgoldnetWight + (($calgoldnetWight * $profit) / 100);
												$MinPrice	= $calgoldnetWight + (($calgoldnetWight * $min_profit) / 100);
												
												/*if($listview->categoryname == 'Gold') { */
													$TransferredCost = $listview->TransferredCost;
                                                 /* } else { 
                                                   $TransferredCost = $listview->purchase_price;
                                                }  */
												?>
											<tr>
												<td><?= !empty($listview->created_datetime)?$listview->created_datetime:'' ?></td>
												<td><?= !empty($listview->code)?$listview->code:'' ?></td>
												<td><?= !empty($listview->name)?$listview->name:'' ?></td>
												<td><?= !empty($listview->sub_category_name)?$listview->sub_category_name:'' ?></td>
												<td><?= !empty($listview->NetGoldWeight)?number_format($listview->NetGoldWeight,2):'0.00' ?></td>
												<td><?= !empty($TransferredCost)?number_format($TransferredCost,2):'0.00' ?></td>
												<td><?= !empty($salesPrice)?number_format($salesPrice,2):'0.00' ?></td>
												<td><?= !empty($MinPrice)?number_format($MinPrice,2):'0.00' ?></td>
												
												<td> 
													<button class="btn btn-primary oldModelHide" style="width: 70px;padding: 4px 12px;"   data-toggle="modal" data-target="#myModal<?php echo $listview->id; ?>">View</button>
												</td>
											</tr>
											
											
											<div id="myModal<?php echo $listview->id; ?>" class="modal fade" role="dialog">
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
																	<?= date('d-m-Y H:i:s', strtotime($listview->created_datetime)) ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Code</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($listview->code)?$listview->code:'' ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Item</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($listview->name)?$listview->name:'' ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Sub Category</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($listview->sub_category_name)?$listview->sub_category_name:'' ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Weight</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($listview->weight)?$listview->weight:'' ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Purchase Cost</b>
																</div>
																<div class="col-md-8">
																<?= !empty($calgoldnetWight)?number_format($calgoldnetWight,2):'0.00' ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Sale Price</b>
																</div>
																<div class="col-md-8">
																<?= !empty($salesPrice)?number_format($salesPrice,2):'0.00' ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Minimum Sale Price</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($MinPrice)?number_format($MinPrice,2):'0.00' ?>	
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Start Qty</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($listview->start_qty)?$listview->start_qty:'' ?>
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
				</div>
			</div>
		</div>
	</div>
	<br /><br /><br />
</div>
	
	



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
	
