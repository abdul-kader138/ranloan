<?php
	$app = realpath(APPPATH);
	require_once $app . '/views/includes/header.php';
	?>                 
<style>
/* Extras */
a:visited{color:#888}
a{color:#444;text-decoration:none;}
p{margin-bottom:.3em;}

label > input{ /* HIDE RADIO */
  visibility: hidden; /* Makes input not-clickable */
  position: absolute; /* Remove input from document flow */
}
label > input + img{ /* IMAGE STYLES */
  cursor:pointer;
  border:2px solid transparent;
   border-radius: 90%;
}
label > input:checked + img{ /* (RADIO CHECKED) IMAGE STYLES */
  border:4px solid #5fc509;
  /*border:2px solid #f00;*/
   border-radius: 90%;
}
label.error{
	color:red;
}

 </style> 
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Staff</h1>
		</div>
	</div><!--/.row-->
	
	<form id="add_staff_validat" action="<?=base_url()?>staff/insertStaff" method="post" enctype="multipart/form-data">
        <?php //            echo form_open_multipart('staff/insertStaff');     ?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
								<div class="row">
                                  </div>

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
						<div class="col-md-3">
							<div class="form-group">
								<label>Staff Code <span style="color: #F00">*</span></label>
								<input type="text" name="staff_code" class="form-control"  maxlength="499" autofocus required autocomplete="off" value="" />
							</div>
						</div>
                                           
                        <div class="col-md-3">
							<div class="form-group">
								<label>Staff Name <span style="color: #F00">*</span></label>
								<input type="text" name="staff_name" class="form-control"  maxlength="499" autofocus required autocomplete="off" value="" />
							</div>
						</div>
                                            <div class="col-md-3">
							<div class="form-group">
								<label>Mobile </label>
								<input type="text" name="staff_mobile" class="form-control"  maxlength="499" autofocus autocomplete="off" value="" />
							</div>
						</div>
					</div>
						<div class="row">   
							<div class="col-md-3">
								<div class="form-group">
								<label>Nic<span style="color: #F00">*</span></label>
								<input type="text" name="staff_cni" class="form-control" maxlength="499"  required autocomplete="off" value="" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
								<label>Upload Photo </label>
								<input  type="file" name="thumbnail"  maxlength="499"   autocomplete="off"  />
								</div>
							</div>
							 <div class="col-md-3">
								<div class="form-group">
									<label>Outlets <span style="color: #F00">*</span></label>
									<select class="form-control" name="outlet_id" required>
										<?php foreach ($outlet_group as $key => $value) { ?>
											<option  value="<?=$value->id?>"><?=$value->name?></option>
										<?php } ?>
									</select>
								</div></div>
						  </div>
                         
                                    <div class="row">
										<div class="col-md-3">
											 <div class="form-group">
											  <label>Entitled for the Points </label> <br>                                
												 <label>
												<input type="radio" name="title_points" class="radioBtn" value="1" />
												<img width="60px" class="img-circle" src="<?php echo base_url("assets/img/yes.jpg"); ?>">
											  </label>
												 <label>
												<input type="radio" name="title_points" class="radioBtn" value="0" />
												<img width="60px" class="img-circle" src="<?php echo base_url("assets/img/noo.jpg"); ?>">
											 </label>
											 </div>
									  </div>
                                            
											<div class="col-md-3">
											   <div class="form-group">
												   <label>Points Percentage</label>
												   <input type="text" name="percentage" id="percentage" onkeypress='return isNumber(event)' class="form-control" maxlength="499"  required autocomplete="off" value="" />
											   </div>
										   </div>
										
										<div class="col-md-6">
											  <div class="form-group">
												  <label>Is this user view their own<br> sales and points records </label> <br>
												   <label>
												  <input type="radio" name="isview"  value="1" />
												  <img width="60px" class="img-circle" src="<?php echo base_url("assets/img/yes.jpg"); ?>">
												  </label>
												 <label>
												  <input type="radio" name="isview"  value="2" />
												  <img width="60px" class="img-circle" src="<?php echo base_url("assets/img/noo.jpg"); ?>">
												  </label>
											   </div>
										  </div>
                                </div>        
                                     
					
					
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>Created By</label>
											<input type="text"   class="form-control"  value="<?php echo $UserLoginName; ?>" readonly/>
										</div>
									</div>  

									<div class="col-md-3">
										<div class="form-group">
											<button class="btn btn-primary" style="margin-top: 25px; width: 100px;">Add</button>
										</div>
									</div>
								</div>
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>staff/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	</form>
	
	<br /><br /><br /><br /><br />
</div>	
</div><!-- Right Colmn // END -->
	
	
	
<script type="text/javascript">
    $("#percentage").attr("disabled", true);
$(".radioBtn").click(function() {
    $("#percentage").attr("disabled", true);
    if ($("input[name=title_points]:checked").val() == 1) {
        $("#percentage").attr("disabled", false);
    }
});
     function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
</script> 
		
		
<?php
$app = realpath(APPPATH);

require_once $app . '/views/includes/footer.php';

?>
<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>		
<script>
	$("#add_staff_validat").validate({
	  rules: {
			staff_code: "required",
			staff_name: "required",
			staff_cni: "required",
			outlet_id: "required",
		},
		messages: {
			staff_code: "Please enter staff code",
			staff_name: "Please enter staff name",
			staff_cni: "Please enter NIC",
			outlet_id: "Please enter outlet",
		
		},

		submitHandler: function(form) {
			form.submit();
		}
	});



</script>