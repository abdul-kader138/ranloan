<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/header.php';
    $custDtaData = $this->Constant_model->getDataOneColumn('brand', 'id', $brand_id);
    if (count($custDtaData) == 0) 
	{
        redirect(base_url());
    }
	$brand= $custDtaData[0]->brand;
    $status = $custDtaData[0]->status;
?>
<link href="<?=base_url();?>assets/css/jquery.multiselect.css" rel="stylesheet" />
<script src="<?=base_url();?>assets/js/jquery.multiselect.js"></script>
<style>
	ul li{
		list-style: none;
	}
	label.error{
		color:red;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Brand  : <?php echo $brand; ?></h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
                        if (!empty($alert_msg)) {
                            $flash_status = $alert_msg[0];
                            $flash_header = $alert_msg[1];
                            $flash_desc = $alert_msg[2];
                            if ($flash_status == 'failure') 
							{
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
					
			
					
					<form id="edit_brand" action="<?=base_url()?>brand/updateBrand" method="post">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Brand <span style="color: #F00">*</span></label>
								<input type="text" name="Brand" class="form-control" required value="<?php echo $brand; ?>" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-3">
						<div class="form-group">
							<?php 
								$supp_ids=array();
								foreach ($brand_supplier as $value) {
									$supp_ids[] = $value->supplier_id_fk;
								}              
							?>
							<label>Suppliers <span style="color: #F00">*</span></label>
							<select id="ms" multiple="multiple" name="supplier[]" required="">
									<?php foreach ($supplier_data as  $value) { ?>
										<option  value="<?=$value->id?>"
											<?php
											if(in_array( $value->id ,$supp_ids ) )
											{ echo "selected"; } 
											   ?>>
											<?=$value->name?></option>
										<?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Staus </label>
								<select class="form-control" name="status" required>
									<option value="">Select Status</option>
									<option  value="0" <?php  if($status == '0') echo 'selected' ?> >Active</option>
									<option  value="1" <?php  if($status == '1') echo 'selected' ?>>InActive  </option>
								</select>           
							</div>
						</div>
                        <div class="col-md-3">
							<div class="form-group">
								<label>Updated By</label>
								<input type="text" value="<?php echo $UserLoginName;  ?> " class="form-control"  readonly />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="hidden" name="id" value="<?php echo $brand_id; ?>" />
								<button class="btn btn-primary">Update</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					</form>
					
					</div>
				</div>
			</div>
			<a href="<?=base_url()?>brand/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
		</div>
	</div>
</div>
	
	
	
<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/footer.php';
?>
	<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	

<script>
    $('document').ready(function(){
        $('#ms').multiselect({
            columns: 1,
            placeholder: 'Select Supplier',
            search: true,
            selectAll: true
        });
    
	
	
		$("#edit_brand").validate({
		  rules: {
				Brand: "required",
				status: "required",

			},
			messages: {
				Brand: "Please enter Brand ",
				status: "Please enter status ",

			},

			submitHandler: function(form) {
				form.submit();
			}
		});
	
	
	
	});
	
	
	
	
</script>