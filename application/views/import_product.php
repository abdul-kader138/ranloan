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
			<h1 class="page-header">Import Product</h1>
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

	<form action="<?=base_url()?>products/insert_import_product" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Category Name <span style="color: #F00">*</span></label>
									<select name="category_id" required="" id="category_id" class="form-control">
										<?php
										foreach ($Category_List as $category)
										{ ?>
											<option value="<?=$category->id?>"><?=$category->name?></option>
										<?php }
										?>
									</select>
									<div id="errorMessge" style="color: #cc0033;"></div>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Sub Category Name </label>
									<select name="sub_category_id" id="sub_category_id" class="form-control">
										<option value="">Select Sub Category</option>
										<?php
										foreach ($getSubCategory as $sub)
										{ ?>
										<option value="<?=$sub->id?>"><?=$sub->sub_category?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Outlet <span style="color: #F00">*</span></label>
									<select  required="" name="outlet_id" id="ChangeOutlet" class="form-control">
										<?php
										foreach ($getOutlet as $outle)
										{ ?>
											<option value="<?=$outle->id?>"><?=$outle->name?></option>
										<?php 
										}
										?>
									</select>
								</div>
							</div>
							
							
						</div>
						
						<div class="row">

							<div class="col-md-4" id="getTankWareHouse">
								
							</div>
							
						</div>
						<div class="row">
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Product File <span style="color: #F00">*</span></label>
									<br />
									<input id="uploadFile" readonly style="height: 40px; width: 250px; border: 1px solid #ccc" />
									<div class="fileUpload btn btn-primary" style="padding: 9px 12px;">
										<span>Browse</span>
										<input id="uploadBtn" name="result_file"  required="" type="file" class="upload" />
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>&nbsp;</label>
									<br />
									<a style="color: #0000ff;" href="<?=base_url();?>assets/demo/product_demo.xls"><b>Download Demo File</b></a>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button class="btn btn-primary" type="submit" >Import Product</button>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</form>
	<br />
	<a href="<?= base_url() ?>products/list_products" style="text-decoration: none;">
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
		
		getWarehouseTank();	
		
		$('#category_id').change(function(){
			$('#errorMessge').html('');
			$('#getTankWareHouse').html('');
			getWarehouseTank();	
			var category_id = $(this).val();
			if(category_id!="")
			{
				$.ajax({
					type:'POST',
					url:"<?=base_url()?>Products/getSubCategoryFilter",
					data: {category_id:category_id},
					dataType: 'JSON',
					success:function(data){
						$('#sub_category_id').html(data.html);
					}
				});
			}
			else
			{
				$('#sub_category_id').html('<option value="">Select Sub Category</option>');
			}
		});
		
	});
</script>

