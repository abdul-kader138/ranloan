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
	$(document).ready(function(){
		document.getElementById("uploadBtn").onchange = function () {
			document.getElementById("uploadFile").value = this.value;
		};
	});
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Product :  <?=$getProductEdit->code?></h1>
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
<!--								<form action="<?=base_url()?>products/deleteProduct" method="post" onsubmit="return confirm('Do you want to delete this Product?')">
									<input type="hidden" name="prod_id" value="<?php echo $getProductEdit->id; ?>" />
									<input type="hidden" name="prod_name" value="<?php echo $getProductEdit->name; ?>" />-->
									<button type="submit" class="btn btn-primary popup_edit_product" style="border: 0px; background-color: #c72a25;">
										Delete Product
									</button>
<!--								</form>-->
							</div>
						</div>
					
					
					
						<div class="message-box animated fadeIn edit_product_pop" data-sound="alert" id="mb-signout">
						<div class="mb-container">
							<div class="mb-middle">
								<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
								<div class="mb-content">
									<p>Do you want to delete this Product :<?php echo $getProductEdit->name; ?>?</p>                    
									<p>Press No if youwant to continue work. Press Yes to Remove current Product.</p>
									
								</div>
								<div class="mb-footer">
									<div class="pull-right">
										<form action="<?=base_url()?>products/deleteProduct" method="post" >
										<input type="hidden" name="prod_id" value="<?php echo $getProductEdit->id; ?>" />
											<input type="hidden" name="prod_name" value="<?php echo $getProductEdit->name; ?>" />
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
					
				<form action="<?= base_url() ?>products/updateProduct" method="post" enctype="multipart/form-data">				
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Product Code <span style="color: #F00">*</span></label>
									<input type="text" name="code" class="form-control" maxlength="250" autofocus required autocomplete="off" value="<?=!empty($getProductEdit->code)?$getProductEdit->code:''?>" readonly />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Product Name <span style="color: #F00">*</span></label>
									<input type="text" name="name" class="form-control" maxlength="250" required autocomplete="off" value="<?=!empty($getProductEdit->name)?$getProductEdit->name:''?>" />
								</div>
							</div>
							<div class="col-md-4" style="display:none;">
								<div class="form-group">
									<label>Generic Name </label>
									<input type="text" name="generic_name" value="<?=!empty($getProductEdit->generic_name)?$getProductEdit->generic_name:''?>" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>
						
							<div class="col-md-4">
								<div class="form-group">
									<label>Product Category <span style="color: #F00">*</span></label>
									<select disabled name="category" class="form-control"  required>
										<option value="">Select Product Category</option>
										<?php
												foreach ($Category as $cat)
												{ 
													$selected = "";
													if($getProductEdit->category == $cat->id)
													{
														$selected = "selected";
													}
													?>
										<option <?=$selected?> value="<?=$cat->id?>"><?=$cat->name?></option>
											<?php } ?>
									</select>
								</div>
							</div>
							<?php
							$select_sub_cate = $this->db->get_where('sub_category', array('id' => $getProductEdit->sub_category_id_fk))->row();
							?>
							<div class="col-md-4">
								<div class="form-group">
									<label>Product Sub Category </label>
									<div id="c_edit">
										<select  disabled name="sub_category1" class="form-control">
											<option value="">Select Sub Category</option>
											<option selected="" value="<?=!empty($getProductEdit->sub_category_id_fk)?$getProductEdit->sub_category_id_fk:''?>"><?=!empty($select_sub_cate->sub_category)?$select_sub_cate->sub_category:''?></option>
										</select>
									</div>
								</div>
							</div>

							<!--						</div>-->
							<div class="col-md-4">
								<div class="form-group">
									<label>Brand </label>
									<select name="brand" class="form-control" onChange="getSupplier(this.value);" >
										<option value="">Select Brand</option>
										<?php
										foreach($brand as $bran)
										{ 
											$selectedb = "";
											if($getProductEdit->brand_id_fk == $bran->id)
											{
												$selectedb = "selected";
											}
											?>
											<option <?=$selectedb?> value="<?=$bran->id?>"><?=$bran->brand?></option>
									<?php } ?>
									</select>
								</div>
							</div>		
						
							<div class="col-md-4">
								<div class="form-group">
									<label>Alert Quantity </label>
									<input type="text" name="alert_quan" value="<?=!empty($getProductEdit->alt_qty)?$getProductEdit->alt_qty:''?>" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>
							<?php
							$catData = $this->Constant_model->getDataOneColumn('outlets', 'status', '1');
							$query = $this->db->get_where('users', array('id' => $loginUserId))->row();
							$useroutlet = $query->outlet_id;
							$query_outlet = $this->db->get_where('outlets', array('id' => $useroutlet))->row();
							?>
							<div class="col-md-4">
								<div class="form-group">
									<label>Outlet </label>
									<?php
									if ($useroutlet > 0) {
										?>
										<input type="text" name="outlet" class="form-control" required value="<?php echo $query_outlet->name; ?>" readonly />          
										<?php } else { ?>
										<select name="outlet" class="form-control" required disabled>
											<option value="">Select Outlet</option>
											<?php
											for ($c = 0; $c < count($catData); ++$c) {


												$cat_id = $catData[$c]->id;
												$cat_name = $catData[$c]->name;
												?>
												<option value="<?php echo $cat_id; ?>"  <?php if ($getProductEdit->outlet_id_fk == $cat_id) {
													echo 'selected';
												} ?>   ><?php echo $cat_name; ?></option>
												<?php
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Supplier </label>
									<?php
									$select_supplier = $this->db->get_where('suppliers', array('id' => !empty($getProductEdit->supplier_id_fk)))->row();
									?>
									<div id='s_edit2'>
										<select name="s_editsupplier" class="form-control" id="supplier">
											<option value="">Select Supplier</option>
											<?php
												foreach ($getSuppliers as $supp)
												{
													$seletced = '';
													if($getProductEdit->supplier_id_fk == $supp->id)
													{
														$seletced = 'selected';
													}
											?>
											<option <?=$seletced?> value="<?=$supp->id?>"><?=$supp->name?></option>
												<?php } ?>
										</select>
									</div>
								</div>
							</div>
						
							<div class="col-md-4"  id="expire" >

								<div class="form-group">
									<label>Enter Days </label>
									<input type="text" name="expire" id="exp" value="<?=!empty($getProductEdit->expire) ? $getProductEdit->expire : ''?>" class="form-control"  autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">

								<div class="form-group">
									<label>Weight  </label>
									<input type="text" name="weight" value="<?=!empty($getProductEdit->weight)?$getProductEdit->weight:''?>" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Rack</label>
									<input type="text" name="rack" value="<?=!empty($getProductEdit->rack)?$getProductEdit->rack:''?>" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>
						
							<div class="col-md-4">
								<div class="form-group">
									<label>Starting Qty</label>
									<input type="text" name="starting_qty" value="<?=$getProductEdit->start_qty?>" class="form-control" maxlength="250"  autocomplete="off" readonly/>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Purchase Price (Cost) <span style="color: #F00">*</span></label>
									<input type="text" name="purchase" class="form-control" maxlength="250" autofocus required autocomplete="off" value="<?=!empty($getProductEdit->purchase_price)?$getProductEdit->purchase_price:''?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Retail Price (Price) <span style="color: #F00">*</span></label>
									<input type="text" name="retail" class="form-control" maxlength="250" required autocomplete="off" value="<?=!empty($getProductEdit->retail_price)?$getProductEdit->retail_price:''?>" />
								</div>
							</div>
						
							<div class="col-md-4">
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
									<label>Updated By <span style="color: #F00">*</span></label>
									<input type="text" name="created_by" class="form-control" value="<?php echo $UserLoginName; ?>" readonly  />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Status <span style="color: #F00">*</span></label>
									<select name="status" class="form-control">
										<option value="1" <?php
										if ($getProductEdit->status == '1') {
												echo 'selected="selected"';
										}
									?>>Active</option>
									<option value="0" <?php
												if ($getProductEdit->status == '0') {
													echo 'selected="selected"';
												}
									?>>Inactive</option>
									</select>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-4">
								<?php
								if ($getProductEdit->thumbnail != 'no_image.jpg') {
									?>
									<img src="<?= base_url() ?>assets/upload/products/xsmall/<?php echo $getProductEdit->code; ?>/<?=$getProductEdit->thumbnail;?>" />
									<?php
								}
								?>
							</div>
						</div>

						<?php
						if ($user_role == '1') {
							?>					
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										
										<input type="hidden" name="oldfilename" value="<?=$getProductEdit->thumbnail?>" />
										<input type="hidden" name="id" value="<?=$getProductEdit->id?>" />
										<button class="btn btn-primary" type="submit">Update Product</button>
									</div>
								</div>
								<div class="col-md-4"></div>
								<div class="col-md-4"></div>
							</div>
							<?php
						}
						?>
					</form>				
					
				</div>
			</div>
			
			
			<div class="panel panel-default">
				<div class="panel-body">
					<h1 class="page-header" style="margin-top: 0px; padding-bottom: 4px; font-size: 30px; margin: 0px 0 11px; color: #0079c0;">
						Inventory by Outlet
					</h1>
					<?php
						$outletData = $this->Constant_model->getDataOneColumn('outlets', 'id', "$getProductEdit->outlet_id_fk");
						for ($t = 0; $t < count($outletData); ++$t) {
                            $outlet_id = $outletData[$t]->id;
                            $outlet_name = $outletData[$t]->name; ?>
					<div class="row" style="padding-top: 5px; padding-bottom: 5px;" >
						<div class="col-md-12">
							<b><?=$outlet_name?></b>
						</div>
						<div class="col-md-12">
							<table class="table">
								<tr>
									<th>Warehouse</th>
									<th>Inventory Qty</th>
								</tr>
								<tr>
							<?php
							$invQtyData = $this->Products_model->OutletWiseInvenotyWarehouse($getProductEdit->code,$outlet_id);
							foreach ($invQtyData as $ware_qty){
                            ?>
									<td width="20%"><?=$ware_qty->s_name?></td>
									<td><?=number_format($ware_qty->qty,2)?></td>
								</tr>
							<?php }?>
							</table>
							
						</div>
					</div>
					<?php	
					}
                    ?>
				</div>
			</div>
			
			<a href="<?=base_url()?>products/list_products" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			<br /><br /><br />
		</div>
	</div>
</div>
	
	
	
<?php
    require_once 'includes/footer.php';
?>
<script>
	 function getSupplier(val) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "Products/get_Supplier/" + val,
            success: function (data) {
                $("#supplier").html(data);
            }
        });
    }
	
	
	
	 $(document).ready(function () {
	//popupbox
		$(".popup_edit_product").click(function () {
			 $('.edit_product_pop').modal('show');
		});
				
});
</script>

