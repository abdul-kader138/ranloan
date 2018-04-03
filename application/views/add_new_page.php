<?php
	require_once 'includes/header.php';
?>
<style type="text/css">
	.fileUpload {
		position: relative;
		overflow: hidden;
		border-radius: 0px;
		margin-left: -4px;
		margin-top: -2px;
	}
	.fileUpload input.upload {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		font-size: 20px;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}
	.required
	{
		color: #ff0033;
	}
	.rederror p
	{
		color: #ff0033;
	}
	label.error{
		color:red;
	}
</style>
<link href="<?=base_url();?>assets/css/jquery.multiselect.css" rel="stylesheet" />
<script src="<?=base_url();?>assets/js/jquery.multiselect.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add New Page</h1>
		</div>
	</div>
	
	<form id="product_order_submit" action="" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
					<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
					<div role="alert" class="alert alert-success">
					   <button data-dismiss="alert" class="close" type="button">
						   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
					   <strong>Well done!</strong>
					   <?= $this->session->flashdata('SUCCESSMSG') ?>
					</div>
					<?php } ?>
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							
							<div class="col-md-6">
								<div class="form-group">
									<label>Module Title <span class="required">*</span></label>
									<input type="text" required=""  value="<?php echo set_value('title'); ?>" name="title" class="form-control" />
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<label>Page Url Name <span class="required">*</span></label>
									<input type="text" required="" value="<?php echo set_value('name'); ?>" name="name" class="form-control checkPageUrl" />
									<div class="rederror"><?=form_error('name')?></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6" >
								<div class="form-group">
									<label>Module <span class="required">*</span></label>
									<select class="form-control" name="module" required="" id="MuduleCategory">
										<option value="">Select Module</option>
										<option value="0">Main Module</option>
										<option value="1">Sub Module</option>
									</select>
								</div>
							</div>
							
							<div class="col-md-6" style="display: none;" id="showmainmodule">
								<div class="form-group">
									<label>Main Module <span class="required">*</span></label>
									<select class="form-control" name="mainmodule" id="requiredField" name="module">
										<option value="">Select Main Module</option>
										<?php
										foreach ($getMainMoule as $module)
										{ ?>
											<option value="<?=$module->id?>"><?=$module->title?></option>	
									<?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Role <span style="color: #F00">*</span></label>
									<select name="role_user[]" id="multiselectStore" multiple="" class="form-control" >
									  <?php
										foreach($getroleData as  $roleuser)
										{  ?>
											<option  value="<?=$roleuser->id?>"> <?=$roleuser->name;?>  </option>
									  <?php }  ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button class="btn btn-primary" type="submit" >Add New Page</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<?php
require_once 'includes/footer.php';
?>

<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script type="text/javascript">
	$('document').ready(function(){
		
		$('#MuduleCategory').change(function(){
			var module = $(this).val();
			if(module == '1')
			{
				$('#showmainmodule').show();
				$('#requiredField').prop('required',true);
			}
			else
			{
				$('#requiredField').prop('required',false);
				$('#showmainmodule').hide();
			}
		});
		
	});
</script>
<script>
    $('document').ready(function(){
        $('#multiselectStore').multiselect({
            columns: 1,
            placeholder: 'Select Store',
            search: true,
            selectAll: true
        });
		
		$("#product_order_submit").validate({
			rules: {
				title: "required",
				name: "required",
				module: "required",
				mainmodule: "required",
			},
			messages: {
				title: "Please enter module title",
				name: "Please enter page url name",
				module: "Please enter module",
				mainmodule: "Please enter main module",
			},
			submitHandler: function(form) {
				form.submit();
			}
		});
		
		
    });
</script>