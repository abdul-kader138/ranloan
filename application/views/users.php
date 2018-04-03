<?php
    require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Users</h1>
		</div>
	</div><!--/.row-->
	
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
						<div class="col-md-12">
							<?php
                                if ($user_role < 3) {
                                    ?>
							<a href="<?=base_url()?>setting/adduser" style="text-decoration: none">
								<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>Add New User</button>
							</a>
							<?php

                                }
                            ?>
						</div>
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
						<div class="table-responsive">
							<table class="table" id="datatable">
							    <thead>
							    	<tr>
								    	<th width="15%">Full Name</th>
									    <th width="15%">Email</th>
									    <th width="10%">Role</th>
									    <th width="15%">Outlet</th>
									    <th width="10%">Status</th>
									    <th width="20%">Action</th>
									</tr>
							    </thead>
								<tbody>
								<?php
                                    if (count($results) > 0) {
                                        foreach ($results as $data) {
                                            $id = $data->id;
                                            $fullname = $data->fullname;
                                            $email = $data->email;
                                            $role_id = $data->role_id;
                                            $outlet_id = $data->outlet_id;
                                            $status = $data->status;

                                            $outlet_name = '-';
                                            if ($outlet_id > 0) {
                                                $outletNameData = $this->Constant_model->getDataOneColumn('outlets', 'id', "$outlet_id");
                                                $outlet_name = $outletNameData[0]->name;
                                            }
											$user_role_id = $this->session->userdata('user_role');
											//print_r($login_role);
												
											$role_name = '';
                                            $roleNameData = $this->Constant_model->getDataOneColumn('user_roles', 'id', "$role_id");

                                            $role_name = $roleNameData[0]->name; 
											if($role_id != 7 ||$user_role_id ==7){
											?>
								
											<tr>
												<td>
													<?php echo $fullname; ?>
												</td>
												<td>
													<?php echo $email; ?>
												</td>
												<td style="font-weight: bold;">
													<?php echo $role_name; ?>
												</td>
												<td>
													<?php echo $outlet_name; ?>
												</td>
												<td style="font-weight: bold;">
													<?php
                                                        if ($status == '1') {
                                                            echo '<span style="color: #090;">Active</span>';
                                                        }
                                            if ($status == '0') {
                                                echo '<span style="color: #f9243f;">Inactive</span>';
                                            } ?>
												</td>
												<td>
													<a href="<?=base_url()?>setting/changePassword?id=<?php echo $id; ?>" style="text-decoration: none; padding: 5px 5px;">
														<button class="btn btn-primary">Change Password</button>
													</a>
													<a href="<?=base_url()?>setting/edituser?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
														<button class="btn btn-primary">Edit</button>
													</a>
												</td>
											</tr>
									<?php
                                            unset($id);
                                            unset($fullname);
                                            unset($email);
                                            unset($role_id);
                                            unset($outlet_id);
                                            unset($status);
										}}
                                    } else {
                                        ?>
										<tr class="no-records-found">
											<td colspan="100%">No matching records found</td>
										</tr>
								<?php

                                    }
                                ?>
								</tbody>
							</table>
						</div>
							
						</div>
					</div>
					
					<div class="row">

					</div>
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
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
					className: "change btn-primary",
					exportOptions: {columns: [0, 1, 2, 4, 5, 6, 7, 8, 9]},
				},
				{
					extend: "pageLength",
				},
			],
		});
	});
</script>