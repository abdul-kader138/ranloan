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
			<h1 class="page-header">Add Bulk Product</h1>
		</div>
	</div><!--/.row-->

	<form id="product_order_submit" action="<?=base_url()?>products/insertBulkProduct" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<input type="hidden" name="warehousecount" id="warehousecount" value="0"/>
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
							
							<?php
							$catData = $this->Constant_model->getDataOneColumn('outlets', 'status', '1');
							?>
							<div class="col-md-4">
								<div class="form-group">
									<label>Outlet <span style="color: #F00">*</span></label>
										<select name="outlet" class="form-control" id="outlet"  onChange="getOutlet();" required>
											<?php
											for ($c = 0; $c < count($catData); ++$c) {
												$cat_id = $catData[$c]->id;
												$cat_name = $catData[$c]->name;
												?>
												<option value="<?php echo $cat_id; ?>"  ><?php echo $cat_name; ?></option>
												<?php
											}
										?>
									</select>
									<input type='hidden' name='ou' id='ou' value="" />
								</div>
							</div>
							
							
							
							<div class="col-md-4">
								<div class="form-group">
									<label><span id="changeProductCategory">Product Category </span><span style="color: #F00">*</span></label>
									<select name="category" id="getSubCategoryvalue" class="form-control" autofocus onChange="getSubCategory(this.value);" required>
										<option value="">Select Product Category</option>
										<?php
										foreach ($Category as $cat) {
											?>
											<option value="<?= $cat->id ?>"><?= $cat->name ?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
							
							
							
							<div class="col-md-4">
								<div class="form-group">
									<label><span id="changeSubCategory">Product Sub Category </span></label>
									<select name="sub_category" class="form-control" id="sub_category" >
										<option value="">Select Sub Category</option>
									</select>
								</div>
							</div>
							
						</div>
						<div class="row">
							
							<div class="col-md-4">
							   <div class="form-group">
								   <label><span id="changeProductName">Product Name</span> <span style="color: #F00">*</span></label>
								  <input type="text" name="name" id='name' class="form-control" maxlength="250" required autocomplete="off" />
							   </div>
							</div>
						
							<div class="col-md-4" id="changeBrand">
								<div class="form-group">
									<label>Brand </label>
									<select name="brand" class="form-control" id='brand' onChange="getSupplier(this.value);" >
										<option value="">Select Brand</option>
										<?php
										foreach ($brand as $bra) {
											?> 
											<option value="<?= $bra->id ?>"><?= $bra->brand ?></option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
								<div class="col-md-4" id="ChangeGoldGrade">
								<div class="form-group">
									<label>Gold Grade <span style="color: #F00">*</span></label>
									
									 <select name="grade_id" class="form-control" >
										  <option value="">Select Grade</option>
										  <?php
												foreach ($getGoldGradedata as $grade)
												{ ?>
													<option value="<?=$grade->grade_id?>"><?=$grade->grade_name?></option>
											<?php	}
										  ?>
									 </select>
								</div>
							</div>
							
							<div class="col-md-4" id="changeStartingQty">
								<div class="form-group">
									<label>Starting Qty</label>
									<input type="text" name="starting_qty" id="starting_qty" required="" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>
							
							
							<div class="col-md-4" id="changeWeight">
								<div class="form-group">
									<label>Total Weight</label>
									<input type="text" name="weight" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>
							
							
							<div class="col-md-4">
								<div class="form-group">
								   <label>Supplier <span style="color: #F00">*</span></label>
								  	  <?php 
										$query_supplier = $this->db->get_where('suppliers', array('status' => 1));
										 $query_count = $query_supplier->num_rows();
										 ?>
									  <select name="supplier" class="form-control" id="supplier" onchange='getExpire(this.value);' >
										 <option value="">Select Supplier</option>
										 <?php
											if ($query_count > 0) 
											{
												$query_supplier = $query_supplier->result();
												foreach ($query_supplier as $value) {
													?>
												<option value="<?php echo $value->id; ?>" ><?php echo $value->name; ?></option>
												<?php
												   }
											   }
											?>
									  </select>
								</div>
							 </div>
						
						
							
							<div class="col-md-4" id="changeRack">
								<div class="form-group">
									<label>Rack</label>
									<input type="text" name="rack" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Purchase Price (Cost) <span style="color: #F00">*</span></label>
									<input type="text" id="purchase" name="purchase" class="form-control" maxlength="250" autofocus required autocomplete="off" />
								</div>
							</div>
							

							<div class="col-md-4" id="changeProductImage">
								<div class="form-group">
									<label>Product Image <span style="color: #F00">*</span></label>
									<br />
									<input id="uploadFile" readonly style="height: 40px; width: 230px; border: 1px solid #ccc" />
									<div class="fileUpload btn btn-primary" style="padding: 9px 12px;">
										<span>Browse</span>
										<input id="uploadBtn" name="uploadFile" type="file" class="upload" />
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Store <span style="color: #F00">*</span></label>
									<select class="form-control" id="getWareHouse"  name="store" required="">
										<option value="">Select Store </option>
									</select>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Created By <span style="color: #F00">*</span></label>
									<input type="text" name="created_by" class="form-control" value="<?php echo $UserLoginName; ?>" readonly  />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button class="btn btn-primary submitformproduct" type="submit"  >Add Product</button>
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
	<br /><br /><br /><br /><br />
	
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Error</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12" style="color: red; font-size: 18px;">
							Please add Bulk Store in this Outlet !!
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
</div>
<?php
require_once 'includes/footer.php';
?>
<script>

   
   function getOutlet()
   {
		var val = $('#outlet').val();
	 	
			$.ajax({
			type:'POST',
			url:"<?=base_url()?>Products/get_warehouse_outletwise_bulk_store",
			data: {val: val},
			dataType: 'JSON',
			success:function(data)
			{
				if(data.num_rows == 0)
				{
						$('#myModal').modal('show');
				}
				$('#getWareHouse').html(data.warehousedata);
			}
		});
	}
	 getOutlet();
   
   
   
	function getSubCategory(val) 
	{
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "Products/get_Sub_Category/" + val,
			success: function (data) {
				$("#sub_category").html(data);
			}
		});
	}

	function getSupplier(val) {
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "Products/get_Supplier/" + val,
			success: function (data) {
				$("#supplier").html(data);
			}
		});
	}

   
   
   
</script>
