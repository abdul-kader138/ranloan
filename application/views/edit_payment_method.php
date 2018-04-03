<?php
    require_once 'includes/header.php';

    $payDtaData = $this->Constant_model->getDataOneColumn('payment_method', 'id', $id);

    if (count($payDtaData) == 0) {
        redirect(base_url());
    }
    $payment_name = $payDtaData[0]->name;
    $payment_status = $payDtaData[0]->status;
?>
<style>
	label.error{
		color:red;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Payment Method : <?php echo $payment_name; ?></h1>
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
<!--							<form action="<?=base_url()?>setting/deletePaymentMethod" method="post" onsubmit="return confirm('Do you want to delete this Payment Method?')">
								<input type="hidden" name="pay_id" value="<?php echo $id; ?>" />
								<input type="hidden" name="pay_name" value="<?php echo $payment_name; ?>" />
								<button type="submit" class="btn btn-primary" style="border: 0px; background-color: #c72a25;">
									Delete Payment Method
								</button>
							</form>-->
							<button type="submit" class="btn btn-primary pop_paymt_methd" style="border: 0px; background-color: #c72a25;">
									Delete Payment Method
							</button>
						</div>
					</div>
					
					
					
					<div class="message-box animated fadeIn edit_paymt_methd_pop" data-sound="alert" id="mb-signout">
						<div class="mb-container">
							<div class="mb-middle">
								<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
								<div class="mb-content">
									<p>Do you want to delete this Payment Method :<?php echo $payment_name; ?>?</p>                    
									<p>Press No if you want to continue work. Press Yes to Remove current Payment Method.</p>
									
								</div>
								<div class="mb-footer">
									<div class="pull-right">
										<form action="<?=base_url()?>setting/deletePaymentMethod" method="post">
											<input type="hidden" name="pay_id" value="<?php echo $id; ?>" />
											<input type="hidden" name="pay_name" value="<?php echo $payment_name; ?>" />
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
					
	
	<form id="up_payment_valida" action="<?=base_url()?>setting/updatePaymentMethod" method="post">					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Payment Method Name <span style="color: #F00">*</span></label>
								<input type="text" name="name" class="form-control" maxlength="99" autofocus required autocomplete="off" value="<?php echo $payment_name; ?>" />
							</div>
						</div>
						<div class="col-md-6"></div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Status <span style="color: #F00">*</span></label>
								<select name="status" class="form-control">
									<option value="0" <?php if ($payment_status == '0') {
                        echo 'selected="selected"';
                    } ?>>Inactive</option>
									<option value="1" <?php if ($payment_status == '1') {
                        echo 'selected="selected"';
                    } ?>>Active</option>
								</select>
							</div>
						</div>
						<div class="col-md-6"></div>
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
			
			<a href="<?=base_url()?>setting/payment_methods" style="text-decoration: none;">
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
		   $(".pop_paymt_methd").click(function () {
				$('.edit_paymt_methd_pop').modal('show');
		   });
		   
		   	$("#up_payment_valida").validate({
				rules: {
					name: "required",
				},
				messages: {
					name: "Please enter payment method name",
				},
				submitHandler: function(form) {
					form.submit();
				}
			});

   });
</script>
