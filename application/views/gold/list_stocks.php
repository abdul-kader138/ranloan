<?php error_reporting(0) ?>

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


									$prdtr = $this->db->select('code')->from('products')->where('product_add_from','Transfer bulk')->get()->row()->code;
											
									$prdinv = $this->db->select('sum(qty)as qty')->where('product_code',$prdtr)->from('inventory')->get()->row()->qty;
									$prdinvwt = $this->db->select('sum(gold_weight)as gtwt')->where('product_code',$prdtr)->from('inventory')->get()->row()->gtwt;
									foreach ($stocks as $stock){
										
										
										if($stock->inventoryqty > 0)
										{
										?>
											<tr>
												<td><?=$stock->id?></td>
												<td><?=$stock->productname?></td>
												<td>
												<?php
												
													echo $stock->product_code;
											
												?>
												</td>
												
												<td>
													<?php

														echo $stock->storename;

													?>
												</td>

												<td>
													<?php

													
														 $productq = 0;
														$productqty = $productq + $stock->inventoryqty;
															echo number_format($productqty,3);;
													?>
														
												</td>
												<td>
													<?php
															$productweight = 0;
															 $productweight = $productweight + $stock->gold_weight;
															echo number_format($productweight,3);;
														
													?>
												</td>
												<?php
												?>
												<td>
													<?php
														if ($stock->product_type == 'bulk') {
															// echo $prdinv;
															echo !empty($prdinv)?number_format($prdinv,3):0;
														}else{
															echo 0;
														}
													?>
												</td>
												<?php
												?>
												<td>
													<?php

														if($stock->product_type != 'bulk')
														{
															echo 0;
														}
														else
														{
															echo !empty($prdinvwt)?number_format($prdinvwt,3):0;
														}	
													?>
												</td>
												
												<td><?=$stock->outletname?></td>
												<td>
													<?php
													if($stock->product_type == 'bulk')
													{
														echo $stock->product_add_from;
													}
													else
													{
														echo $stock->product_add_from;
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
										<?php
										$totalq=$this->db->select('sum(qty) as qty')->from('inventory')->get()->row()->qty;
										?>
										<td><label style="color:#333333; font-size: 16px;"><?=number_format($totalq,2)?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Weight (g):</label> </td>
										<?php
										$totalwt=$this->db->select('sum(gold_weight) as weight')->from('inventory')->get()->row()->weight;
										?>
										<td><label style="color:#333333;font-size: 16px;"><?=number_format($totalwt,2)?></label></td>
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



