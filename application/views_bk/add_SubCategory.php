<?php
    require_once 'includes/header.php';
?>
<style>
	label.error{
		color:red;
	}
	
</style>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Sub Category</h1>
		</div>
	</div>
	<form id="sub_catgory_valid" action="<?=base_url()?>sub_category/insertSubcategory" method="post">
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
								<?php
								}
							}
						?>


						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Date & Time</label>
									<input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Sub Category <span style="color: #F00">*</span></label>
									<input type="text" name="category_name" class="form-control" required  autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Category <span style="color: #F00">*</span></label>
									<select class="form-control" name="category_id_fk" required>
										<option value="">Select Category</option>
										<?php foreach ($category_data as  $value) { ?>
											<option  value="<?=$value->id?>"><?=$value->name?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Prefix</label>
									<input type="text" name="Prefix" class="form-control"   autocomplete="off" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Staus  <span style="color: #F00">*</span> </label>
									<select class="form-control" name="status" required>
										<option  value="0">Active</option>
										<option  value="1">InActive  </option>
									</select>           
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Created By</label>
									<input type="text" value="<?php echo $UserLoginName;  ?> " class="form-control"  readonly />
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
					</div>
				</div>
				<a href="<?=base_url()?>sub_category/view" style="text-decoration: none;">
					<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
						<i class="icono-caretLeft" style="color: #FFF;"></i>Back
					</div>
				</a>
			</div>
		</div>
	</form>
</div>

<?php
    require_once 'includes/footer.php';
?>


	<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script>

$("#sub_catgory_valid").validate({
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