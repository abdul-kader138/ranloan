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
</style>

<script type="text/javascript">
    $(document).ready(function () {
        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
        };
    });
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Import Customer</h1>
		</div>
	</div>
	<?php if ($this->session->flashdata('SUCCESSMSG')) 
	{ ?>
		<div role="alert" class="alert alert-success">
		   <button data-dismiss="alert" class="close" type="button">
			   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
		   <strong>Well done!</strong>
		   <?= $this->session->flashdata('SUCCESSMSG') ?>
		</div>
	<?php 
	} ?>

	<form action="<?=base_url()?>customers/insert_import_customer" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Customer Group<span style="color: #F00">*</span></label>
									<select name="customer_group" class="form-control" required="">
										<option value="">Select Customer Group</option>
										<?php
										 foreach ($customer_group as $group)
										 { ?>
											<option value="<?=$group->id?>"><?=$group->name?></option>	 
									<?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Outlet <span style="color: #F00">*</span></label>
									<select name="outlet_id" class="form-control" required="">
										<?php
										 foreach ($getOutlets as $value)
										 { ?>
												<option value="<?=$value->id?>"><?=$value->name?></option>	 
										<?php }
										?>
									</select>
								</div>
							</div>
						
						</div>
						
						<div class="row">
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Excel Sheet with Customer Data<span style="color: #F00">*</span></label>
									<br />
									<input id="uploadFile" readonly style="height: 40px; width: 250px; border: 1px solid #ccc" />
									<div class="fileUpload btn btn-primary" style="padding: 9px 12px;">
										<span>Browse</span>
										<input id="uploadBtn" name="result_file"  required="" type="file" class="upload" />
									</div>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group"  style="padding-top: 10px;">
									<label>&nbsp;</label>
									<br />
									<a style="color: #0000ff;" href="<?=base_url();?>assets/demo/custimer_import.xls"><b>Download Demo File</b></a>
								</div>
							</div>
							
						</div>
						
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button class="btn btn-primary" type="submit" >Import Customer</button>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</form>
	<br />
	<a href="<?= base_url() ?>customers/view" style="text-decoration: none;">
		<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
			<i class="icono-caretLeft" style="color: #FFF;"></i>Back
		</div>
	</a>
</div>
<?php
	require_once 'includes/footer.php';
?>
<script type="text/javascript">
	function getSupplier(val) {
           $.ajax({
               type: "POST",
               url: "<?php echo base_url(); ?>" + "Products/get_Supplier/" + val,
               success: function (data) {
                   $("#supplier").html(data);
				}
           });
       
	}

	$('document').ready(function(){
		$('#ChangeOutlet').change(function(){
			
			var category_id = $('#category_id').val();
			if(category_id == "")
			{
				$('#errorMessge').html('Please Select Category!!');
			}
			else
			{
				$('#errorMessge').html('');
				getWarehouseTank();	
			}
		});
		
		function getWarehouseTank()
		{
			var category_id = $('#category_id').val();
			var outlet_id = $('#ChangeOutlet').val();
			if(outlet_id !="")
			{
				$.ajax({
						type:'POST',
						url:"<?=base_url()?>Products/getWarehouseTank",
						data: {outlet_id: outlet_id,category_id:category_id},
						dataType: 'JSON',
						success:function(data){
							$('#getTankWareHouse').html(data.success);
						}
				});
			}
			else
			{
				$('#getTankWareHouse').html('');
			}
		}
		
		
		$('#category_id').change(function(){
			$('#errorMessge').html('');
			$('#ChangeOutlet').val('');
			$('#getTankWareHouse').html('');
		});
		
	});
</script>

