<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/header.php';
?>
<link href="<?=base_url();?>assets/css/jquery.multiselect.css" rel="stylesheet" />
<script src="<?=base_url();?>assets/js/jquery.multiselect.js"></script>
<style>
	ul li{
		list-style: none;
	}
	.validation p{
		color:red;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Brand</h1>
		</div>
	</div>
	
	<form id="" action="<?=base_url()?>brand/insertBrand" method="post">
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
						} ?>
					
					
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Date & Time</label>
								<input type="text" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Brand <span style="color: #F00">*</span></label>
                                <input type="text" name="Brand" class="form-control" value="<?php echo set_value('Brand'); ?>"  autocomplete="off" />
								<span class="validation"><?php echo form_error('Brand'); ?></span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Suppliers <span style="color: #F00">*</span></label>
								<select id="ms" multiple="multiple" name="supplier[]">
									<?php foreach ($supplier_data as  $value) { ?>
											<option  value="<?=$value->id?>"><?=$value->name?></option>
                                    <?php } ?>
                                </select>
								<span class="validation"><?php echo form_error('supplier[]'); ?></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Staus </label>
									<select class="form-control" name="status" >
                                	<option value="">Select Status</option>
									<option  value="0" <?php echo (set_value('status')=='0')?" selected=' selected'":""?>>Active</option>
									<option  value="1" <?php echo (set_value('status')=='1')?" selected=' selected'":""?>>InActive  </option>
                                </select>           
								<span class="validation"><?php echo form_error('status'); ?></span>
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
			<a href="<?=base_url()?>brand/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div>
	</div>
	</form>
</div>
<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/footer.php';
?>
<script>
    $('document').ready(function(){
        $('#ms').multiselect({
            columns: 1,
            placeholder: 'Select Supplier',
            search: true,
            selectAll: true
        });
    

});
</script>