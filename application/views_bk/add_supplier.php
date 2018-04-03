<?php
    require_once 'includes/header.php';
?>

<style>
	.validation p
	{
		color: #cc0000;
	}
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add New Supplier</h1>
		</div>
	</div><!--/.row-->
	
	<form action="<?=base_url()?>setting/insertSupplier" method="post">
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
					<?php   }
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
								<label>Supplier Name <span style="color: #F00">*</span></label>
								<input type="text" name="name" class="form-control"  maxlength="499" autofocus  autocomplete="off" value="<?php echo set_value('name'); ?>" />
								<span class="validation"><?php echo form_error('name'); ?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Email Address <span style="color: #F00">*</span></label></label>
								<input type="email" name="email" class="form-control" maxlength="254" autocomplete="off" value="<?php echo set_value('email'); ?>" />
								<span class="validation"><?php echo form_error('email'); ?></span>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Telephone <span style="color: #F00">*</span></label>
								<input type="text" name="tel" class="form-control"  maxlength="499"  autocomplete="off" value="<?php echo set_value('tel'); ?>" />
								<span class="validation"><?php echo form_error('tel'); ?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>FAX </label>
								<input type="text" name="fax" class="form-control" maxlength="254" autocomplete="off" value="<?php echo set_value('fax'); ?>" />
								<span class="validation"><?php echo form_error('fax'); ?></span>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Address <span style="color: #F00">*</span></label>
								<textarea name="address" class="form-control"  style="height: 100px;"><?php echo set_value('address'); ?></textarea>
								<span class="validation"><?php echo form_error('address'); ?></span>
							</div>
						</div>
					</div>
										
					
										
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button class="btn btn-primary">Add</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>setting/suppliers" style="text-decoration: none;">
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
    require_once 'includes/footer.php';
?>