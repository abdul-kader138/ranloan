<?php
error_reporting(0);
	require_once 'includes/header.php';
?>

<script type="text/javascript">
	$(document).ready(function () {
        $(".fancybox").fancybox();
    });
	
    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
	
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">List Products</h1>
		</div>
	</div>
	
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
					<?php
					if ($user_role < 2) {
						?>
						<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px;">
							<div class="col-md-12">
								<a class="btn btn-primary" href="<?= base_url() ?>products/addproduct" style="text-decoration: none; padding: 0px 12px;">
									<i class="icono-plus"></i>Add Product
								</a>
								<a  class="btn btn-primary" href="<?= base_url() ?>products/import_product"  style="text-decoration: none">
									Import Product
								</a>
								<a  class="btn btn-primary" href="<?= base_url() ?>products/add_bulk_product"  style="text-decoration: none">
									Add Bulk Product
								</a>
							</div>
						</div>
						<?php
					}
					?>

					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
<!--							<div class="col-md-3">
								<div class="form-group">
									<label>Product Code</label>
									<input type="text" name="code" value="<?=!empty($this->input->get('code')) ? $this->input->get('code') : ''?>" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Product Name</label>
									<input type="text" name="name" value="<?=!empty($this->input->get('name')) ? $this->input->get('name') : ''?>" class="form-control" />
								</div>
							</div>-->
							<div class="col-md-3">
								<div class="form-group">
									<label>Category</label>
									<select name="category" class="form-control">
										<option value="">All</option>
											<?php
											foreach ($Category_List as $cate)
											{
												$selected = "";
												if(!empty($this->input->get('category')))
												{
													if($this->input->get('category') == $cate->id)
													{
														$selected = "selected";
													}
												}
												?>
												<option <?=$selected?> value="<?=$cate->id?>"><?=$cate->name?></option>
											<?php
											}
											?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
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
								<table class="table" id="datatable">
									<thead>
										<tr>
											<th style="display: none;">id</th>
											<th style="text-align: left;" width="8%">Code</th>
											<th style="text-align: left;" width="12%">Name</th>
											<th style="text-align: left;" width="10%">Rack</th>
											<th style="text-align: left;" width="10%">Image</th>
											<th style="text-align: left;" width="8%">Category</th>
											<th style="text-align: left;" width="8%">Brand</th>
											<th style="text-align: left;" width="8%">Alert Qty</th>
											<th style="text-align: left;" width="8%">Cost</th>
											<th style="text-align: left;" width="8%">Price</th>
											<th style="text-align: left;" width="8%">Status</th>
											<th style="text-align: left;" width="8%">Type</th>
											<th style="text-align: left;" width="15%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
								$i = 1;
								if (count($results) > 0) {
									
									$get_grade = $this->Constant_model->getLastGoldGradePrice();
											$CurrentPrice = !empty($get_grade->gp_price)?$get_grade->gp_price:0;
											$gp_purity	  = !empty($get_grade->gp_purity)?$get_grade->gp_purity:0;
											$cal = 0;
									// $prd = $this->db->select('name')->from('products')->get()->row()->name;									
									$prdtr = $this->db->select('code')->from('products')->where('product_add_from','Transfer bulk')->get()->row()->code;
											
									$prdinv = $this->db->select('sum(gold_weight)as gtwt')->where('product_code',$prdtr)->from('inventory')->get()->row()->gtwt;
									// echo $prdinv;

									foreach ($results as $data) {
										$large_file_path = '';
									
                                    $grade_id_product = $data->grade_id;
									$category		  = $data->category;
									$sub_category     = $data->sub_category_id_fk;
		                            $profile_calculation = $this->Sales_model->getProfileCalculationData($grade_id_product, $category, $sub_category);
		                             
									$profit		= !empty($profile_calculation->profit)?$profile_calculation->profit:0;
									$min_profit = !empty($profile_calculation->min_profit)?$profile_calculation->min_profit:0;
		                             
									$gold_purity = $data->grade_name;
									$grade_name = $data->gold_purity;
									if($grade_name == 24)
										{
											$cal = $CurrentPrice;
										}
										else
										{
											$cal = ($CurrentPrice / $gp_purity) * $gold_purity;
										}

												$NetGoldWeight = !empty($data->NetGoldWeight) ? $data->NetGoldWeight:0;
												$Wastagegold = !empty($data->Wastagegold) ? $data->Wastagegold:0;
												$calgoldnetWight = ($cal * ($NetGoldWeight + $Wastagegold)) + $data->TotalAllOtherCost;
												
												$salesPrice = $calgoldnetWight + (($calgoldnetWight * $profit) / 100);  
		 
		 
?>
											<tr>
												<td style="display: none;"><?=$data->id?></td>
												<td>
												<?php
											//	if($data->product_type != 'bulk')
											//	{
													echo $data->code;
											//	}
												?>
												</td>
												<td><?=$data->name?></td>
												<td><?=$data->rack?></td>
												<td>
													<?php
													if ($data->thumbnail == 'no_image.jpg') {
														$large_file_path = base_url() . 'assets/upload/products/small/no_image.jpg';
														?>
														<img src="<?= base_url() ?>assets/upload/products/xsmall/no_image.jpg" height="50px" style="border: 1px solid #ccc" />
														<?php
													} else {
													   $product_type = $data->product_type;
														if($product_type == 'bulk')
														$codee = '';
														else
														$codee = $data->code.'/';
														
														$large_file_path = base_url() . 'assets/upload/products/small/' .$codee. $data->thumbnail;
														?>
														<img src="<?= base_url() ?>assets/upload/products/xsmall/<?= $codee ?><?=$data->thumbnail;?>" height="50px" style="border: 1px solid #ccc" />
														<?php }
													?>
												</td>
												<td><?=$data->categoryname?></td>
												<td><?php
														$brand_name = $data->brandname;
														
														echo $brand_name;
													?>
												</td>
												<td><?=$data->alt_qty?></td>
                                                
												<td>
												<?php
												
											if($data->categoryname == 'Gold') {							
											if($data->product_type == 'bulk' )
												{
											$stwt = !empty($data->weight)?($data->weight):0;
											// echo $stwt;
											$goldwt = $data->gold_weight;
											$wtBalk =  (!empty($goldwt)?$goldwt:0)-($stwt);
											$grade_id_product = $data->grade_id;			
											$category = $data->category;
											$sub_category = $data->sub_category_id_fk;
											$totaltodaycost = ((abs($wtBalk))+$prdinv) * $cal;
											$stwt = (!empty($data->purchase_price)?$data->purchase_price:0);
											$bulkpurchasetotal = $totaltodaycost + $stwt;
											if ($goldwt == 0) {
												$bulkproductprice = 0;
											}else{
												$bulkproductprice=$bulkpurchasetotal/($goldwt+$prdinv);
											}

											echo !empty($bulkproductprice)?number_format($bulkproductprice,2):0;
												 }else{
												 	if ($data->product_add_from != 'Transfer bulk') {
												 	$prcost = (!empty($data->purchase_price)?$data->purchase_price:0);
												 	echo !empty($prcost)?number_format($prcost,2):0;
												 }
												}


											 	if($data->product_add_from == 'Transfer bulk' )
												{
													echo !empty($data->TransferredCost)?number_format($data->TransferredCost,2):0;
												}

											}
												
                                                 ?>
                                                </td>
                                                 
												<td>
                                                <?php
                                                if($data->categoryname == 'Gold' OR $data->categoryname =='Silver') {
                                                	if($data->product_type == 'bulk' )
												{

												$salesPrice = $bulkproductprice + (($bulkproductprice * $profit) / 100);
												echo !empty($salesPrice)?number_format($salesPrice,2):0;
												}else{
													if ($data->product_add_from != 'Transfer bulk') {
														
													
													$salesPrice = $prcost + (($prcost * $profit) / 100);
												echo !empty($salesPrice)?number_format($salesPrice,2):0;
												}
												}
												if($data->product_add_from == 'Transfer bulk' )
												{

												echo !empty($data->TransferredCost + (($data->TransferredCost * $profit) / 100))?number_format($data->TransferredCost + (($data->TransferredCost * $profit) / 100),2):0;
												}
                                                } 
                                                ?>
                                                </td>
												<td style="font-weight: bold;">
													<?php
													if ($data->status == '1') {
														echo '<span style="color: #090;">Active</span>';
													}
													if ($data->status == '0') {
														echo '<span style="color: #f9243f;">Inactive</span>';
													}
													?>
												</td>
												<td>
													<?php
													if($data->product_type == 'bulk' )
													{
														echo $data->product_add_from;
													}
													else
													{
														echo $data->product_add_from;
													}
													?>
												</td>
												<td>
													<div class="dropdown">
														<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
															<span class="caret"></span></button>
														<ul class="dropdown-menu">
															<li>
																<a href="<?= base_url() ?>products/editproduct?id=<?=$data->id?>" style="text-decoration: none;" title="Edit">
																	<img src="<?= base_url() ?>assets/img/edit_icon.png" height="30px" />
																</a>
															</li>
															<li>
																<a class="fancybox" rel="group" href="<?php echo $large_file_path; ?>" style="text-decoration: none;" title="<?=$data->code?>">
																	<i class="icono-image" style="color: #005b8a; height: 30px;"></i>
																</a>
															</li>
															<li>
																<a onclick="openReceipt('<?= base_url() ?>products/printBarcode?pcode=<?=$data->code?>')" style="text-decoration: none; cursor: pointer;" title="Print Barcode">
																	<img src="<?= base_url() ?>assets/img/barcode_icon.png" height="20px" />
																</a>
															</li>
															<li>
																<a onclick="openReceipt('<?= base_url() ?>products/productDetail?id=<?=$data->id?>')" style="text-decoration: none; cursor: pointer;" title="Product Detail">
																	Product Detail
																</a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
										<?php
										}
									} 
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
			require_once 'includes/header_notification.php';
		?>	
	
	<?php
		require_once 'includes/footer.php';
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
		});
	});
</script>