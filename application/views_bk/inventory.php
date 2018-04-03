<style type="text/css">
	.table-responsive {
	     max-width: 1300px;
	     overflow-x: scroll;
	}
</style>
<?php
    require_once 'includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Inventory</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
								<div class="col-md-7">
								</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Sub Category</label>
									<select class="form-control" name="subcategory" >
										<option value="">Select Sub Category</option>
										<?php 
										$subcategorylist = $this->Constant_model->getSubCategory();
										foreach ($subcategorylist as $subcategory) {?>
											<option value="<?php echo $subcategory->id?>"><?php echo $subcategory->sub_category ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
<!--							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate"   value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate"   value="<?=!empty($this->input->get('start_date'))?$this->input->get('end_date'):''?>" />
								</div>
							</div>-->
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<button class="btn btn-primary" type="submit" style="width: 50%;">Search</button>
								</div>
							</div>
						</div>
					</form>
					
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive" style="max-width: 100%;">
								<table class="table" id="datatable_inven">
									<thead>
										<tr>
											<th width="5%">Code</th>
											<th width="5%">Name</th>
											<th width="5%">Outlet</th>
											<th width="5%">Store</th>
											<th width="5%">Gold Grade</th>
											<th width="5%">Sub Category</th>

											<th width="5%">Remaining Quantity</th>
											<th width="5%">Remaining Weight</th>
											<th width="5%">Transfer Quantity</th>
											<th width="5%">Transfer Weight</th>

											<th width="5%">Purchase/ transfer Cost</th>
											<th width="5%">Today Cost</th>
											<th width="5%">Type</th>
											<th width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									

									#**************************************************
									# added by a3frt 14-11-2017 start
									#**************************************************

									$CI =& get_instance();
									$CI->load->model('Gold_module');

									$data_name = array();

									$productweight = 0;


									#**************************************************
									# added by a3frt 14-11-2017 end
									#**************************************************

										$totalqty = 0;
										$total_cost_amt = 0;
										foreach ($results as $data) 
										{
											$totalqty = $totalqty + $data->qty;
										?>
											<tr>
												<td>
													<?php
													//	if($data->product_type != 'bulk')
													//	{
															echo $data->code;
													//	}
													?>
												</td>
												<td><?=$data->name?></td>
												<td><?=$data->outletname?></td>
												<td><?php echo $this->Inventory_model->getConcateStore($data->outlet_id_fk, $data->code, $data->ow_id); ?> </td>
												<td><?=$data->gold_grade?></td>
												<td><?=$data->sub_category?></td>
												
												<!-- add by a3frt date 14-11-17 start -->

												<td>
													<?php

													if($data->product_type == 'bulk')
													{
														$result = $CI->Gold_module->get_sum_weight_qty($data->name);

														if(!empty($result))
														{
															$sum_weight = $result[0]->sum_weight;
															$sum_qty = $result[0]->sum_qty;
														}

														$rem_weight = $data->weight - $sum_weight;
														$rem_qty = $data->product_qty - $sum_qty;

														echo number_format($rem_qty,3);

														$totalqty = $totalqty + $rem_qty;
													}

													else
													{
														if(!in_array($data->name, $data_name))
														{
															$data_name[] = $data->name;
															$result = $CI->Gold_module->get_bulk_weight_qty($data->name);

															$haystack  = $data->name;
															$needle    = ' ';
															$var = strstr($haystack, $needle, true);

															if(!empty($result))
															{
																$product["$var"]['weight'] = $result[0]->weight;
																$product["$var"]['qty'] = $result[0]->start_qty;
															

																$product["$var"]['qty']  = $product["$var"]['qty'] -  $data->product_qty;

																$product["$var"]['weight']  = $product["$var"]['weight'] -  $data->weight;

																echo number_format($product["$var"]['qty'],3);
															}
														}
														else
														{

															if(!empty($result))
															{
															$product["$var"]['qty']  = $product["$var"]['qty'] -  $data->product_qty;

															$product["$var"]['weight']  = $product["$var"]['weight'] -  $data->weight;
															
															echo number_format($product["$var"]['qty'],3);
														}
														}
														

													}


													?>
														
												</td>
												<td>
													<?php

														if($data->product_type == 'bulk')
														{
															echo number_format($rem_weight,3);
															
															$productweight = $productweight + $rem_weight;
														}
														else
														{
															if(!empty($result))
															{
																echo number_format($product["$var"]['weight'],3);
															}
															
														}
													?>
												</td>
												<td>
													<?php

														if($data->product_type == 'bulk')
														{
															echo number_format($sum_qty);
														}
														else
														{
															echo !empty($data->product_qty)?number_format($data->product_qty,3):0;
														}

													?>
												</td>
												<td>
													<?php

														if($data->product_type == 'bulk')
														{
															echo number_format($sum_weight);
														}
														else
														{
															echo !empty($data->product_weight)?number_format($data->product_weight,3):0;
														}

														
													?>
												</td>
												<!-- add by a3frt date 14-11-17 end -->

												

												<td><?php echo $data->TransferredCost;
//													$each_row_cost 	= $data->qty * $data->purchase_price;
//													$total_cost_amt = $total_cost_amt + $each_row_cost;
//													!empty($each_row_cost)?number_format($each_row_cost,2):0;
												?>
												</td>
												<td>
										<?php
												$grade_id_product = $data->grade_id;
												$category		  = $data->category;
												$sub_category     = $data->sub_category;

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
												$NetGoldWeight = !empty($data->NetGoldWeight) ? $data->NetGoldWeight:0;
												
												$calgoldnetWight = ($cal * ($NetGoldWeight + $data->Wastagegold)) + $data->TotalAllOtherCost;
												
													$salesPrice = $calgoldnetWight + (($calgoldnetWight * $profit) / 100);
												echo !empty($salesPrice)?number_format($salesPrice,2):0;
													?>
												</td>
												<td>
												<?php
													if($data->product_type == 'bulk')
													{
														echo "Bulk";
													}
													else
													{
														echo "Normal";
													}
												?>
												</td>
												<td>
													<a href="<?=base_url()?>inventory/view_detail?pcode=<?=$data->code?>" style="text-decoration: none;">
														<button class="btn btn-primary" style="padding: 5px 12px;">View</button>
													</a>
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
					<div class="row" style="padding-top: 10px; padding-bottom: 10px; margin-top: 50px; font-size: 18px; letter-spacing: 0.5px; border-top: 1px solid #ddd;">
						<div class="col-md-3" style="font-weight: bold;">Total Stock Qty.</div>
						<div class="col-md-9" style="font-weight: bold;">: 
							<?=!empty($totalqty)?number_format($totalqty,2):0?>
						</div>
					</div>
					
					<div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
						<div class="col-md-3" style="font-weight: bold;">Total Stock Value (<?php echo $site_currency; ?>)</div>
						<div class="col-md-9" style="font-weight: bold;">: 
							<?=!empty($total_cost_amt)?number_format($total_cost_amt, 2):0?>
						</div>
					</div>
					<?php
						foreach ($getOutlets as $value)
						{ ?>
							<div class="row" style="color: #0000cc;padding-top: 10px; padding-bottom: 10px; margin-top: 0px; font-size: 18px; letter-spacing: 0.5px; border-top: 1px solid #ddd;">
								<div class="col-md-12" style="font-weight: bold;"><?=$value->name?></div>
							</div>
							<?php
							$totalqtyinve = 0; 
							$totalcost = 0; 
							$getAllInvResult = $this->db->query("SELECT * FROM inventory where outlet_id = '".$value->id."' ")->result();
							foreach ($getAllInvResult as $inventroy)
							{
								$totalqtyinve		= $totalqtyinve + $inventroy->qty;
								$getCostResultin 	= $this->db->query("SELECT purchase_price FROM products WHERE code = '".$inventroy->product_code."' ")->row();
								$each_costin 		= !empty($getCostResultin->purchase_price)?$getCostResultin->purchase_price:'';
								$each_row_costin 	= $inventroy->qty * $each_costin;
								$totalcost  =$totalcost+ $each_row_costin;
							}
							?>
							<div class="row" style="padding-top: 10px; padding-bottom: 10px; margin-top: 0px; font-size: 18px; letter-spacing: 0.5px;  ">
								<div class="col-md-3" style="font-weight: bold;">Stock Qty.</div>
								<div class="col-md-9" style="font-weight: bold;">: 
									<?=!empty($totalqtyinve)?number_format($totalqtyinve,2):0; ?>
								</div>
							</div>
							<div class="row" style="padding-top: 10px; padding-bottom: 10px; font-size: 18px; letter-spacing: 0.5px; ">
								<div class="col-md-3" style="font-weight: bold;">Stock Value (<?php echo $site_currency; ?>)</div>
								<div class="col-md-9" style="font-weight: bold;">: 
									<?=!empty($totalcost)?number_format($totalcost,2):0; ?>
								</div>
							</div>
					<?php } ?>
					
					
					
				</div>
			</div>
			<br /><br /><br />
		</div>
		<?php require_once 'includes/header_notification.php'; ?>
	</div>
</div>
<?php require_once 'includes/footer.php'; ?>
<script>
$(document).ready(function() {
	$("#datatable_inven").DataTable({
		dom: "Bfrtip",
		"bPaginate": true,ordering: true,"pageLength":15,
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
				exportOptions:{columns:[0,1,2,3,4,5,6]},
			},
			{
				extend: "pageLength",
			},
		],
		responsive: true,
		"footerCallback": function ( row, data, start, end, display ) {
			var api = this.api(), data;
			var pagetotal = addCommas(api.column( 10, {page:'current'} ).data().sum().toFixed(2));
			$( api.table().column(10).footer() ).html("<strong>"+pagetotal+" LKR </strong>");
			$( api.table().column(8).footer() ).html("<strong>"+addCommas(api.column( 8, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
			$( api.table().column(7).footer() ).html("<strong>"+addCommas(api.column( 7, {page:'current'} ).data().sum().toFixed(2))+" (g) </strong>");
		}
	});
});
</script>	
