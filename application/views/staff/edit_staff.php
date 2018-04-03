<?php
	$app = realpath(APPPATH);
	require_once $app . '/views/includes/header.php';
	 

    $custDtaData = $this->Constant_model->getDataOneColumn('staff', 'id', $id);
    if (count($custDtaData) == 0) {
        redirect(base_url());
    }
	$staff_code = $custDtaData[0]->staff_code;
    $staff_name = $custDtaData[0]->staff_name;
    $staff_mobile = $custDtaData[0]->staff_mobile;
    $outlets_id=$custDtaData[0]->assign_outlet;
	$staff_cni = $custDtaData[0]->staff_cni;
    $thumbnail = $custDtaData[0]->thumbnail;
     $point_title = $custDtaData[0]->point_title;
    $point_percentage = $custDtaData[0]->point_percentage;
    $isview_sale = $custDtaData[0]->isview_sale;
    
   
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
			<h1 class="page-header">Edit Staff : <?php echo $staff_name; ?></h1>
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
<!--							<form action="<?=base_url()?>staff/deleteStaff" method="post" onsubmit="return confirm('Do you want to delete this staff?')">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<input type="hidden" name="staff_name" value="<?php echo $staff_name; ?>" />
								<input type="hidden" name="thumbnail" value="<?php echo $thumbnail; ?>" />
								<button type="submit" class="btn btn-primary" style="border: 0px; background-color: #c72a25;">
									Delete Staff
								</button>
							</form>-->
							<button type="submit" class="btn btn-primary popup_staff" style="border: 0px; background-color: #c72a25;">
									Delete Staff
							</button>
						</div>
					</div>
					
					
					
					<div class="message-box animated fadeIn edit_staff_pop" data-sound="alert" id="mb-signout">
						<div class="mb-container">
							<div class="mb-middle">
								<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
								<div class="mb-content">
									<p>Do you want to delete this staff :<?php echo $staff_name; ?>?</p>                    
									<p>Press No if youwant to continue work. Press Yes to Remove current staff.</p>
									
								</div>
								<div class="mb-footer">
									<div class="pull-right">
										<form action="<?=base_url()?>staff/deleteStaff" method="post">
											<input type="hidden" name="id" value="<?php echo $id; ?>" />
											<input type="hidden" name="staff_name" value="<?php echo $staff_name; ?>" />
											<input type="hidden" name="thumbnail" value="<?php echo $thumbnail; ?>" />
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
					
					<?php // echo form_open_multipart('staff/updateStaff');     ?>
				<form id="update_staff_validat" action="<?=base_url()?>staff/updateStaff" method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Staff Code <span style="color: #F00">*</span></label>
								<input type="text" name="staff_code" class="form-control"  maxlength="499" autofocus required autocomplete="off" value="<?php echo $staff_code; ?>" />
							</div>
						</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label>Staff Name <span style="color: #F00">*</span></label>
								<input type="text" name="staff_name" class="form-control"  maxlength="499" autofocus required autocomplete="off" value="<?php echo $staff_name; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Mobile </label>
								<input type="text" name="staff_mobile" class="form-control"  maxlength="499" autofocus autocomplete="off" value="<?php echo $staff_mobile; ?>" />
							</div>
						</div>
					 
                                            <div class="col-md-6">
                                                <div class="form-group">
								<label>Outlets </label>
                                <select class="form-control" name="outlets_id" required>
                                	<option value="">--Select Outlets--</option>
                                	<?php   foreach ($outlet_group as $key => $value) { ?>
                                		<option <?php if($value->id==$outlets_id)echo "selected"; ?> value="<?=$value->id?>"><?=$value->name?></option>
                                	<?php } ?>
                                	

                                </select>
                                                </div> </div>
                                            
                        <div class="col-md-6">
							<div class="form-group">
								<label>Nic<span style="color: #F00">*</span></label>
								<input type="text" name="staff_cni" class="form-control" maxlength="499"  required autocomplete="off" value="<?php echo $staff_cni; ?>" />
							</div>
						</div>
                                               <div class="col-md-3">
                            <div class="form-group">
                                <label>Entitled for the Points </label> <br>
                                  <label>
    <input type="radio" name="title_points" class="radioBtn" value="1" <?php if(isset($point_title) && $point_title==1) echo "checked"; ?> />
    <img width="60px" class="img-circle" src="<?php echo base_url("assets/img/yes.jpg"); ?>">

  </label>
     <label>
    <input type="radio" name="title_points" class="radioBtn" value="0" <?php if(isset($point_title) && $point_title==0) echo "checked"; ?>/>
    <img width="60px" class="img-circle" src="<?php echo base_url("assets/img/noo.jpg"); ?>">

  </label>
<!--                                <input type="radio" name="title_points" class="radioBtn" value="1"  <?php if(isset($point_title) && $point_title==1) echo "checked"; ?> /> Yes
                                 <input type="radio" name="title_points" class="radioBtn" value="0" <?php if(isset($point_title) && $point_title==0) echo "checked"; ?> /> No-->
                            </div>
                        </div>
                                            
                                             <div class="col-md-3">
							<div class="form-group">
								<label>Points Percentage</label>
								<input type="text" name="percentage" id="percentage" onkeypress='return isNumber(event)' class="form-control" maxlength="499"  required autocomplete="off" value="<?php echo $point_percentage; ?>" />
							</div>
						</div>
   <div class="col-md-6">
<div class="form-group">
<label>Is this user view their own<br> sales and points records </label> <br>
<label>
<input type="radio" name="isview"  value="1" <?php if(isset($isview_sale) && $isview_sale==1) echo "checked"; ?> />
<img width="60px" class="img-circle" src="<?php echo base_url("assets/img/yes.jpg"); ?>">

</label>
<label>
<input type="radio" name="isview"  value="2" <?php if(isset($isview_sale) && $isview_sale==2) echo "checked"; ?>/>
<img width="60px" class="img-circle" src="<?php echo base_url("assets/img/noo.jpg"); ?>">

</label>
</div>
</div>
                        <div class="col-md-6">
							<div class="form-group">
								<label>Image<span style="color: #F00">*</span></label>
                                                                <!--required-->
                                     <?php
										 $src= base_url("assets/upload/staff/$thumbnail");
											if(!empty($thumbnail)){
											?>
								
								<img src="<?php echo $src;?>" width="100px" height="50px" style='margin-right:0px;'>	
									<?php } ?>
								<input type="file" name="thumbnail" class="form-control" maxlength="499"   autocomplete="off"  />
							</div>
						</div>
					</div>		
					 <input type="hidden" name="tumbnail_file" value="<?php echo $thumbnail;  ?>" />

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
			
						<?php
                         $url = (isset($_REQUEST['m']) && $_REQUEST['m']==='app') ? 'appointments':'staff/view';
                        ?>
			
			<a href="<?=base_url().$url?>" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
		
<?php
$app = realpath(APPPATH);

require_once $app . '/views/includes/footer.php';

?>



<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script>
	var point = "<?php  echo $point_title; ?>";
    var percentage = "<?php  echo $point_percentage; ?>";
    if(point == 0){
        
    $("#percentage").attr("disabled", true);
    }
	$(".radioBtn").click(function() {
		$("#percentage").attr("disabled", true);
		 $("#percentage").val("");
		if ($("input[name=title_points]:checked").val() == 1) {
			$("#percentage").val(percentage);
			$("#percentage").attr("disabled", false);
		}
	});

	
	$(document).ready(function () {
	   //popupbox
		   $(".popup_staff").click(function () {
				$('.edit_staff_pop').modal('show');
		   });

   });

           
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
	
	
	
	$("#update_staff_validat").validate({
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
