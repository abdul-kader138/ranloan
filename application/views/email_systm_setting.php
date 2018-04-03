<?php
    require_once 'includes/header.php';
	//$email_method='';
	
?>
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
			<h1 class="page-header">Email Setting</h1>
		</div>
	</div><!--/.row-->
	
	
	<div class="row">
		<div class="col-md-12">
			<form action="<?=base_url()?>setting/update_email_system" method="post">
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
						<style>.mail_method_hide { display:none } </style>
						<script>
						  $(function() {
							$("#mail_method_show").on("change",function() {
							  $(".mail_method_hide").hide();
							  var mail_value = this.value;
							  if (mail_value !="") {
								$("#"+mail_value).show();
							  }
							});
							$("#mail_method_show").trigger("change"); // show/hide whatever matches the select
						  });
						</script>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Email Sending Method <span style="color: #F00">*</span></label>
									<select class="form-control" name="email_method" id="mail_method_show">
									<option >Choice Email Sending Method</option>
									<option value="default" <?php if ($email_method == 'default') { echo 'selected="selected"'; } ?>>Default</option>
									<option value="smtp" <?php if ($email_method == 'smtp') { echo 'selected="selected"'; } ?>>SMTP</option>
									</select>	
								</div>
							</div>
						</div>


					<div id="smtp" class="mail_method_hide" style="display:none">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Name <span style="color: #F00">*</span></label>
									<input type="text" name="smtp_name" class="form-control" placeholder="Name" maxlength="499" autofocus  value="<?php echo !empty($smtp_name)?$smtp_name:'' ?>" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Email Address <span style="color: #F00">*</span></label>
									<input type="email" name="smtp_email" class="form-control" placeholder="Email Address" maxlength="499" autofocus  value="<?php echo !empty($smtp_email)?$smtp_email:'' ?>" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Account Type <span style="color: #F00">*</span></label>
									<input type="text" name="smtp_account" class="form-control" placeholder="Account Type" maxlength="499" autofocus  value="<?php echo !empty($smtp_account)?$smtp_account:'' ?>" autocomplete="off" />
								</div>
							</div>

						</div>

							<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Incoming Mail Service <span style="color: #F00">*</span></label>
									<input type="text" name="smtp_incoming_mail" class="form-control" placeholder="Incoming Mail Service" maxlength="499" autofocus  value="<?php echo !empty($smtp_incoming_mail)?$smtp_incoming_mail:'' ?>" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Outgoing Mail Service(SMTP) <span style="color: #F00">*</span></label>
									<input type="text" name="smtp_outgoing_mail" class="form-control" placeholder="Outgoing Mail Service(SMTP)" maxlength="499" autofocus  value="<?php echo !empty($smtp_outgoing_mail)?$smtp_outgoing_mail:'' ?>" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>User Name <span style="color: #F00">*</span></label>
									<input type="text" name="smtp_username" class="form-control" placeholder="User Name" maxlength="499" autofocus  value="<?php echo !empty($smtp_username)?$smtp_username:'' ?>" autocomplete="off" />
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Password <span style="color: #F00">*</span></label>
									<input type="password" name="smtp_password" class="form-control" placeholder="Password" maxlength="499" autofocus  value="<?php echo !empty($smtp_password)?$smtp_password:'' ?>" autocomplete="off" />
								</div>
							</div>



						</div>
					</div>
						<div id="default" class="mail_method_hide" style="display:none">
								<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Email <span style="color: #F00">*</span></label>
									<input type="email" name="defult_email" class="form-control" placeholder="Email" maxlength="499" autofocus  value="<?php echo !empty($defult_email)?$defult_email:''; ?>" autocomplete="off" />
								</div>
							</div>



						</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>



					</div><!-- Panel Body // END -->
				</div><!-- Panel Default // END -->
			</form>
			
			
			<div class="panel panel-default">
				<form action="<?=base_url();?>Setting/TestMail" method="post">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Email <span style="color: #F00">*</span></label>
									<input type="email" required="" name="test_mail" class="form-control" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button class="btn btn-primary">Send</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
					
					
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>setting/system_setting" style="text-decoration: none;">
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