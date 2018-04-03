 

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Warehouses List</h1>
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
                            if ($flash_status == 'success') 
							{
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
							<a href="<?=base_url()?>Store/add_store" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Add Warehouse
								</button>
							</a>
						</div>
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
							<div class="table-responsive">
								<table id="datatable" class="table" >
									<thead>
										<tr>
											<th style="display: none;">id</th>
									    	<th width="10%">Date</th>
									    	<th width="20%">Warehouse Name</th>
									    	<th width="20%">Address</th>
									    	<th width="20%">Contact</th>
									    	<th width="20%">Stock</th>
										    <th width="10%">Status</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										foreach($getWarehouse as $ware):
										?>
											<tr>
												<td style="display: none;"><?php  echo $ware->s_id; ?></td>
												<td><?php  echo $ware->date_created; ?></td>
												<td><?php  echo $ware->s_name; ?></td>
												<td><?php  echo $ware->s_address; ?></td>
												<td><?php  echo $ware->s_contact; ?></td>
												<td><?=!empty($ware->s_stock)?number_format($ware->s_stock,2):0?></td>
												<td>
												<?php
												if($ware->s_status == 1)
												{
													echo "Active";
												}
												else
												{
													echo "Inactive";
												}
												?>
												</td>
											</tr>
										<?php 
										endforeach;
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
			 order:[0,"desc"],
			responsive: true,
			
		});
	});
</script>
 