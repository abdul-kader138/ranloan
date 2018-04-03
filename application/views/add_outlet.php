<?php
    require_once 'includes/header.php';
?>
<link href="<?=base_url()?>assets/css/editor.css" rel="stylesheet">

<style>
	.error p
	{
		color: #cc0033;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add New Outlet</h1>
		</div>
	</div><!--/.row-->
	
	<form action="" method="post">
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
								<label>Outlet Name <span style="color: #F00">*</span></label>
								<input type="text" name="outlet_name" class="form-control" maxlength="499" value="<?=set_value('outlet_name');?>" autofocus  autocomplete="off" />
								<span class="error"><?php echo form_error('outlet_name'); ?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Outlet Contact <span style="color: #F00">*</span></label>
								<input type="text" name="outlet_contact" class="form-control" maxlength="30" value="<?=set_value('outlet_contact');?>" autocomplete="off" />
								<span class="error"><?php echo form_error('outlet_contact'); ?></span>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Outlet Address <span style="color: #F00">*</span></label>
								<textarea class="form-control" name="outlet_address"  rows="5" ><?=set_value('outlet_address');?></textarea>
								<span class="error"><?php echo form_error('outlet_address'); ?></span>
							</div>
						</div>
					</div>
										
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label>Receipt Footer <span style="color: #F00"></span></label>
								<textarea rows="10" id="receipt_footer" name="receipt_footer"><?=set_value('receipt_footer');?></textarea> 
								<span class="error"><?php echo form_error('receipt_footer'); ?></span>
							</div>
						</div>
						<div class="col-md-4">
							
						</div>
					</div>
										
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button class="btn btn-primary" style="width: 100px;">Add</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>setting/outlets" style="text-decoration: none;">
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
<script src="<?=base_url()?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
<script>
  tinymce.init({ 
        selector:'#receipt_footer',
        plugins:'link code image textcolor',
        toolbar: [
        "undo redo | styleselect | bold italic | link image",
        "alignleft aligncenter alignright Justify | forecolor backcolor",
        "fullscreen"
    ]
  });
</script>
