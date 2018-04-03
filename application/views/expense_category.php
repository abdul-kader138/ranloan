<?php
    require_once 'includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Expense Category</h1>
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
							<a href="<?=base_url()?>expenses/expense_category_add" style="text-decoration: none">
								<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>Add New Expense Category</button>
							</a>
						</div>
						<div class="col-md-6"></div>
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
							<div class="table-responsive" >
								<table class="table" id="datatable" style="margin-bottom: 0px;">
									<thead>
										<tr>
											<th style="display: none;">id</th>
											<th width="15%">Expense Category Name</th>
											<th width="10%">Status</th>
											<th width="10%">Action</th>
										</tr>
								    </thead>
									<tbody>
									<?php
									
									foreach ($expData as $value)
									{ ?>
										<tr>
											<td style="display: none;"><?=$value->id?></td>
											<td><?=$value->name?></td>
											<td style="font-weight: bold;"><?php
												if ($value->status == '1') {
													echo '<span style="color: #090;">Active</span>';
												}
												if ($value->status == '0') {
													echo '<span style="color: #f9243f;">Inactive</span>';
												} 
											?></td>
											<td>
												<a href="<?=base_url()?>expenses/expense_category_edit?id=<?=$value->id?>" style="text-decoration: none;">
														<button class="btn btn-primary">Edit</button>
												</a>
											</td>
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

<?php
    require_once 'includes/footer.php';
?>
<script>
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
</script>