<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Customer</h1>
		</div>
	</div><!--/.row-->
	
	<form action="<?=base_url()?>Gold/insertCustomer" method="post">
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
							<div class="form-group">
								<label>Full Name <span style="color: #F00">*</span></label>
								<input type="text" name="fullname" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Email Address <span style="color: #F00">*</span></label>
                                                                <input type="email" name="email" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Mobile </label>
								<input type="text" name="mobile" class="form-control" maxlength="499" autofocus autocomplete="off" />
							</div>
						</div>
                                            <div class="col-md-6">
                                                <div class="form-group">
								<label>Address </label>
                                                                <textarea name="address" id="address" class="form-control" ></textarea>
                                                </div>
                                            </div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Password <span style="color: #F00">*</span></label>
								<input type="password" name="password" id="password" class="form-control" maxlength="499" required autocomplete="off" value="" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Confirm Password <span style="color: #F00">*</span></label>
								<input type="password" name="conpassword" class="form-control" maxlength="499" data-match="#password" data-match-error="these don't match" required autocomplete="off" value="" />
							</div>
						</div>
					</div>					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>Gold/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	</form>
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
    require_once $app.'/views/includes/footer.php';
?>