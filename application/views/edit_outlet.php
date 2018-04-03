<?php
    require_once 'includes/header.php';

    $outletData = $this->Constant_model->getDataOneColumn('outlets', 'id', "$id");

    if (count($outletData) == 0) {
        redirect(base_url());
    }

    $outlet_name = $outletData[0]->name;
    $outlet_address = $outletData[0]->address;
    $outlet_contact = $outletData[0]->contact_number;
    $outlet_header = $outletData[0]->receipt_header;
    $outlet_footer = $outletData[0]->receipt_footer;
?>
<link href="<?=base_url()?>assets/css/editor.css" rel="stylesheet">

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Outlet : <?php echo $outlet_name; ?></h1>
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
<!--							<form action="<?=base_url()?>setting/deleteOutlet" method="post" onsubmit="return confirm('Do you want to delete this Outlet?')">
								<input type="hidden" name="outlet_id" value="<?php echo $id; ?>" />
								<input type="hidden" name="outlet_name" value="<?php echo $outlet_name; ?>" />
								<button type="submit" class="btn btn-primary" style="border: 0px; background-color: #c72a25;">
									Delete Outlet
								</button>
							</form>-->
							<button type="submit" class="btn btn-primary popup_outlet" style="border: 0px; background-color: #c72a25;">
									Delete Outlet
							</button>
						</div>
					</div>
					
					
					
					<div class="message-box animated fadeIn edit_outlet" data-sound="alert" id="mb-signout">
						<div class="mb-container">
							<div class="mb-middle">
								<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
								<div class="mb-content">
									<p>Do you want to delete this Outlet :<?php echo $outlet_name; ?>?</p>                    
									<p>Press No if youwant to continue work. Press Yes to Remove current Outlet.</p>
									
								</div>
								<div class="mb-footer">
									<div class="pull-right">
										<form action="<?=base_url()?>setting/deleteOutlet" method="post" >
											<input type="hidden" name="outlet_id" value="<?php echo $id; ?>" />
											<input type="hidden" name="outlet_name" value="<?php echo $outlet_name; ?>" />
											<button type="submit" class="btn btn-success btn-lg " >Yes</button>
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
                    
					
				<form action="<?=base_url()?>setting/updateOutlet" method="post">				
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Outlet Name <span style="color: #F00">*</span></label>
								<input type="text" name="outlet_name" class="form-control" maxlength="499" autofocus required autocomplete="off" value="<?php echo $outlet_name; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Outlet Contact <span style="color: #F00">*</span></label>
								<input type="text" name="outlet_contact" class="form-control" maxlength="30" required autocomplete="off" value="<?php echo $outlet_contact; ?>" />
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Outlet Address <span style="color: #F00">*</span></label>
								<textarea class="form-control" name="outlet_address" rows="5" required><?php echo $outlet_address; ?></textarea>
							</div>
						</div>
					</div>
										
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label>Receipt Footer <span style="color: #F00">*</span></label>
								<textarea id="receipt_footer" rows="10" name="receipt_footer"><?php echo isset($outlet_footer) ? $outlet_footer : '';?></textarea> 
							</div>
						</div>
						<div class="col-md-6">
							
						</div>
					</div>
										
					<?php
                        if ($user_role == 1) {
                    ?>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<button class="btn btn-primary" style="width:100px;">Update</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					<?php

                        }
                    ?>
				</form>				
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>setting/outlets" style="text-decoration: none;">
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
