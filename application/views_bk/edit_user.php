<?php
    require_once 'includes/header.php';

    $userDtaData = $this->Constant_model->getDataOneColumn('users', 'id', $id);

    if (count($userDtaData) == 0) {
        redirect(base_url());
    }

    $fullname = $userDtaData[0]->fullname;
    $email = $userDtaData[0]->email;
    $db_role_id = $userDtaData[0]->role_id;
    $db_outlet_id = $userDtaData[0]->outlet_id;
    $status = $userDtaData[0]->status;
?>
<style>
	label.error{
		color:red;
	}
</style>

<script type="text/javascript">
	function getValue(ele){
		if(ele == "1"){
			document.getElementById("outlet_block").style.display = "none";
			document.getElementById("outlet").removeAttribute("required", "required");
		} else {
			document.getElementById("outlet_block").style.display = "block";
			document.getElementById("outlet").setAttribute("required", "required");
		}
	}	
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit User : <?php echo $fullname; ?></h1>
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
                    
                    <?php
                        if ($user_role == 1) {
                            ?>
					<div class="row">
						<div class="col-md-12" style="text-align: right;">
<!--							<form action="<?=base_url()?>setting/deleteUser" method="post" onsubmit="return confirm('Do you want to delete this User?')">
								<input type="hidden" name="us_id" value="<?php echo $id; ?>" />
								<input type="hidden" name="us_name" value="<?php echo $fullname; ?>" />
								<button type="submit" class="btn btn-primary" style="border: 0px; background-color: #c72a25;">
									Delete User
								</button>
							</form>-->
							<button type="submit" class="btn btn-primary popup_user" style="border: 0px; background-color: #c72a25;">
									Delete User
								</button>
						</div>
					</div>
					
					<div class="message-box animated fadeIn edit_user_pop" data-sound="alert" id="mb-signout">
						<div class="mb-container">
							<div class="mb-middle">
								<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
								<div class="mb-content">
									<p>Do you want to delete this User :<?php echo $fullname; ?>?</p>                    
									<p>Press No if youwant to continue work. Press Yes to Remove current User.</p>
									
								</div>
								<div class="mb-footer">
									<div class="pull-right">
										<form action="<?=base_url()?>setting/deleteUser" method="post" >
											<input type="hidden" name="us_id" value="<?php echo $id; ?>" />
											<input type="hidden" name="us_name" value="<?php echo $fullname; ?>" />
											<button type="submit" class="btn btn-success btn-lg" >Yes</button>
											<a class="btn btn-default btn-lg mb-control-close" >No</a>
										</form>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
					<?php

                        }
                    ?>
					
				
					<form id="edit_new_user_valid" action="<?=base_url()?>setting/updateUser" method="post">	
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Full Name <span style="color: #F00">*</span></label>
								<input type="text" name="fullname" class="form-control"  maxlength="499" autofocus required autocomplete="off" value="<?php echo $fullname; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Email Address <span style="color: #F00">*</span></label>
								<input type="email"  name="email" class="form-control" maxlength="254" required autocomplete="off" value="<?php echo $email; ?>" />
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Role <span style="color: #F00">*</span></label>
								<select name="role" class="form-control" required onchange="getValue(this.value)">
								<?php

                                    if ($user_role == 3) {
                                    }
                                    $roleData = $this->Constant_model->getDataAll('user_roles', 'id', 'ASC');
                                    for ($r = 0; $r < count($roleData); ++$r) {
                                        $role_id = $roleData[$r]->id;
                                        $role_name = $roleData[$r]->name;

                                        if ($user_role == 2) {
                                            if ($role_id == 1) {
                                                continue;
                                            }
                                        }
                                        if ($user_role == 3) {
                                            if ($role_id < 3) {
                                                continue;
                                            }
                                        } ?>
										<option value="<?php echo $role_id; ?>" <?php if ($db_role_id == $role_id) {
                                            echo 'selected="selected"';
                                        } ?>>
											<?php echo $role_name; ?>
										</option>
								<?php

                                    }
                                ?>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group" id="outlet_block" <?php if ($db_role_id == '1') {
                                    echo 'style="display: none;"';
                                } ?>>
								<label>Outlet <span style="color: #F00">*</span></label>
								<select name="outlet" id="outlet" class="form-control">
								<?php
                                    if ($user_role == 1) {
                                        $outletData = $this->Constant_model->getDataOneColumnSortColumn('outlets', 'status', '1', 'name', 'ASC');
                                    } else {
                                        $outletData = $this->Constant_model->getDataOneColumn('outlets', 'id', "$user_outlet");
                                    }
                                    for ($u = 0; $u < count($outletData); ++$u) {
                                        $outlet_id = $outletData[$u]->id;
                                        $outlet_name = $outletData[$u]->name; ?>
										<option value="<?php echo $outlet_id; ?>" <?php if ($db_outlet_id == $outlet_id) {
                                            echo 'selected="selected"';
                                        } ?>>
											<?php echo $outlet_name; ?>
										</option>
								<?php

                                    }
                                ?>
								</select>
							</div>
						</div>
					</div>
										
					<div class="row" <?php if ($user_role > 2) {
                                    echo 'style="display: none"';
                                } ?>>
						<div class="col-md-6">
							<div class="form-group">
								<label>Status <span style="color: #F00">*</span></label>
								<select name="status" class="form-control" required>
									<option value="1" <?php if ($status == '1') {
                                    echo 'selected="selected"';
                                } ?>>Active</option>
									<option value="0" <?php if ($status == '0') {
                                    echo 'selected="selected"';
                                } ?>>Inactive</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							
						</div>
					</div>
					
										
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<button class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
				</form>		
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			
			<a href="<?=base_url()?>setting/users" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once 'includes/footer.php';
?>
<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script>
 $(document).ready(function () {
	//popupbox
		$(".popup_user").click(function () {
			 $('.edit_user_pop').modal('show');
		});
				
});

$("#edit_new_user_valid").validate({
	  rules: {
			fullname: "required",
			role: "required",
			outlet: "required",
			status: "required",
		},
		messages: {
			fullname: "Please enter fullname",
			role: "Please enter role",
			outlet: "Please enter outlet",
			status: "Please enter status",
		
		},

		submitHandler: function(form) {
			form.submit();
		}
	});



</script>