<?php
    require_once 'includes/header.php';
    $custDtaData = $this->Constant_model->getDataOneColumn('sub_category', 'id', $category_id);
    if (count($custDtaData) == 0) {
        redirect(base_url());
    }
    $sub_category= $custDtaData[0]->sub_category;
    $category_id_fk = $custDtaData[0]->category_id_fk;
    $prefix = $custDtaData[0]->prefix;
    $status = $custDtaData[0]->status;
?>

<style>
	label.error{
		color:red;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Sub Category : <?php echo $sub_category; ?></h1>
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
					<?php	}
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
					<?php } } ?>
					
			
					
					<form id="sub_catgory_valid_up" action="<?=base_url()?>sub_category/updateSubCategory" method="post">
						<div class="row">

							<div class="col-md-3">
								<div class="form-group">
									<label>Sub Category <span style="color: #F00">*</span></label>
									<input type="text" name="category_name" value="<?php echo $sub_category; ?>" class="form-control"   autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Category <span style="color: #F00">*</span></label>
									<select class="form-control" name="category_id_fk" >
										<option value="">Select Category</option>
										<?php foreach ($category_data as  $value) { ?>
											<option  value="<?=$value->id?>" <?php  if($category_id_fk == $value->id) echo 'selected' ?>><?=$value->name?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Prefix</label>
									<input type="text" name="Prefix" class="form-control" value="<?php echo $prefix; ?>"   autocomplete="off" />
								</div>
							</div>
						</div>
					
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Staus  <span style="color: #F00">*</span> </label>
										<select class="form-control" name="status" required>
											<option value="">Select Status</option>
											<option  value="0" <?php  if($status == '0') echo 'selected' ?>>Active</option>
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
									<input type="hidden" name="id" value="<?php echo $category_id; ?>" />
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
		
			<a href="<?=base_url()?>sub_category/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div>
	</div>
</div>
	
	
	
<?php
    require_once 'includes/footer.php';
?>
<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script>
$("#sub_catgory_valid_up").validate({
	  rules: {
			category_name: "required",
			category_id_fk: "required",
			status: "required",
		},
		messages: {
			category_name: "Please enter sub category",
			category_id_fk: "Please enter category",
			status: "Please enter status",
		
		},
		submitHandler: function(form) {
			form.submit();
		}
	});
</script>