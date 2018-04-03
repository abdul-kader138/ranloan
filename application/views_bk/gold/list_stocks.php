

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Warehouses Stocks</h1>
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

					<div class="row">
						<div class="col-md-6">

						</div>
						<div class="col-md-6" style="text-align: right;">							
							<a href="<?= base_url() ?>sales/exportSales" style="text-decoration: none">
							</a>
						</div>
					</div>

					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">

							<div class="table-responsive">
								<table id="datatable_warehouse" class="table" >
									<thead>
										<tr>
											<th>Ref. Number</th>
											<th>Product Name</th>
											<th>Product Code</th>
											<th>Warehouse name</th>
											<th>Remaining Quantity</th>
											<th>Remaining Weight</th>
											<th>Transfer Quantity</th>
											<th>Transfer Weight</th>
											<th>Outlet</th>
											<th>Type</th>
										</tr>
									</thead>
									<tbody>
									<?php
									
									$totalqty = 0; 
									$productweight = 0; 
									

									#**************************************************
									# added by a3frt 14-11-2017 start
									#**************************************************

									$CI =& get_instance();
									$CI->load->model('Gold_module');

									$data = array();


									#**************************************************
									# added by a3frt 14-11-2017 end
									#**************************************************



									foreach ($stocks as $stock){
										
										
										if($stock->inventoryqty > 0)
										{
										?>
											<tr>
												<td><?=$stock->id?></td>
												<td><?=$stock->productname?></td>
												<td>
												<?php
												//if($stock->product_type != 'bulk')
											//	{
													echo $stock->product_code;
											//	}
												
												?>
												</td>
												
												<td>
													<?php

														echo $stock->storename;

													?>
												</td>

												<td>
													<?php

													if($stock->product_type == 'bulk')
													{
														$result = $CI->Gold_module->get_sum_weight_qty($stock->productname);

														$sum_weight = $result[0]->sum_weight;
														$sum_qty = $result[0]->sum_qty;

														$rem_weight = $stock->product_weight - $sum_weight;
														$rem_qty = $stock->product_qty - $sum_qty;

														echo number_format($rem_qty,3);

														$totalqty = $totalqty + $rem_qty;
													}

													else
													{
														if(!in_array($stock->productname, $data))
														{
															$data[] = $stock->productname;
															$result = $CI->Gold_module->get_bulk_weight_qty($stock->productname);

															$haystack  = $stock->productname;
															$needle    = ' ';
															$var = strstr($haystack, $needle, true);

															$product["$var"]['weight'] = $result[0]->weight;
															$product["$var"]['qty'] = $result[0]->start_qty;

															$product["$var"]['qty']  = $product["$var"]['qty'] -  $stock->product_qty;

															$product["$var"]['weight']  = $product["$var"]['weight'] -  $stock->product_weight;

															echo number_format($product["$var"]['qty'],3);
														}
														else
														{
															$product["$var"]['qty']  = $product["$var"]['qty'] -  $stock->product_qty;

															$product["$var"]['weight']  = $product["$var"]['weight'] -  $stock->product_weight;
															
															echo number_format($product["$var"]['qty'],3);
														}
														

													}


													?>
														
												</td>
												<td>
													<?php

														if($stock->product_type == 'bulk')
														{
															echo number_format($rem_weight,3);
															
															$productweight = $productweight + $rem_weight;
														}
														else
														{
															echo number_format($product["$var"]['weight'],3);
															
														}
													?>
												</td>
												<td>
													<?php

														if($stock->product_type == 'bulk')
														{
															echo number_format($sum_qty);
														}
														else
														{
															echo !empty($stock->product_qty)?number_format($stock->product_qty,3):0;
														}

													?>
												</td>
												<td>
													<?php

														if($stock->product_type == 'bulk')
														{
															echo number_format($sum_weight);
														}
														else
														{
															echo !empty($stock->product_weight)?number_format($stock->product_weight,3):0;
														}

														
													?>
												</td>
												
												<td><?=$stock->outletname?></td>
												<td>
													<?php
													if($stock->product_type == 'bulk')
													{
														echo "Bulk";
													}
													else
													{
														echo "Normal";
													}
													?>
												</td>
											</tr>
											<?php
										}
									}
									?>
									</tbody>
									<tfoot>
										<tr>
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
					<h3 style="color: #990000;">Summary</h3>
										<hr>
						<div class="col-md-12">
							<table>
								<tbody>
									<tr>
										<td><label style="color:#333333; font-size: 16px;">Total Qty:</label> </td>
										<td><label style="color:#333333; font-size: 16px;"><?=number_format($totalqty,2)?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Weight:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=number_format($productweight,2)?></label></td>
									</tr>
								</tbody>
							</table>
						</div>
					<hr>
				</div>
			</div>
		</div>
		
		
	</div>
	<br />
	<br /><br />
	
</div>

<script>
	$(document).ready(function () {

		$("#datatable_warehouse").DataTable({
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
			"footerCallback": function ( row, data, start, end, display ) {
			var api = this.api(), data;
			$( api.table().column(4).footer() ).html("<strong>"+addCommas(api.column( 4, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
			$( api.table().column(5).footer() ).html("<strong>"+addCommas(api.column( 5, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
		}
			
		});
	});
</script>



