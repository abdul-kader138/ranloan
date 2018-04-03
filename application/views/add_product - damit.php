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
			<h1 class="page-header">Add Product</h1>
		</div>
	</div><!--/.row-->

	<form id="product_order_submit" action="<?= base_url() ?>products/insertProduct" method="post" enctype="multipart/form-data">
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
							<div class="col-md-4">
								<div class="form-group">
									<label>Product Code <span style="color: #F00">*</span></label>
									<input  type="text" name="code" id='code' class="form-control CheckProductCode" maxlength="250" autofocus required autocomplete="off" />
									<div id="errorproductCode" style="color: #cc0033"></div>
								</div>
							</div>
							<div class="col-md-4">
							   <div class="form-group">
								  <label>Product Name <span style="color: #F00">*</span></label>
								  <input type="text" name="name" id='name' class="form-control" maxlength="250" required autocomplete="off" />
							   </div>
							</div>
<!--							<div class="col-md-4">
								<div class="form-group">
									<label>Generic Name (If Applicable)</label>
									<input type="text" name="generic_name" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>-->
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Product Category <span style="color: #F00">*</span></label>
									<select name="category" id="getSubCategoryvalue" class="form-control" onChange="getSubCategory(this.value);" required>
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
									<label>Product Sub Category </label>
									<select name="sub_category" class="form-control" id="sub_category" >
										<option value="">Select Sub Category</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
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
							<div class="col-md-4">
								<div class="form-group">
									<label>Alert Quantity</label>
									<input type="text" name="alert_quan" class="form-control" maxlength="250"  autocomplete="off" />
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
									<label>Outlet <span style="color: #F00">*</span></label>
									<?php
									if ($useroutlet > 0) 
									{
										?>
										<input type="hidden" name="outlet" id="outlet" class="form-control"  value="<?php echo $query_outlet->id; ?>" readonly />          
										<input type="text" id='outlet11' class="form-control" required value="<?php echo $query_outlet->name; ?>" readonly />          
									<?php 
									} 
									else 
									{ ?>
										<select name="outlet" class="form-control" id="outlet"  onChange="getOutlet();" required>
											<option value="">Select Outlet</option>
											<?php
											for ($c = 0; $c < count($catData); ++$c) {
												$cat_id = $catData[$c]->id;
												$cat_name = $catData[$c]->name;
												?>
												<option value="<?php echo $cat_id; ?>"  ><?php echo $cat_name; ?></option>
												<?php
											}
										}
										?>
									</select>
									<input type='hidden' name='ou' id='ou' value="" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
								   <label>Supplier <span style="color: #F00">*</span></label>
								   <div id="depend">
									  <select name="dependsupplier" class="form-control" id="supplier" onchange='getExpire(this.value);' >
										 <!--  <select name="supplier" class="form-control" id="supplier" onchange='CheckColors(this.value);' required>-->
										 <option value="">Select Supplier</option>
									  </select>
								   </div>
								   <div id="notdepned">
									  <?php $query_supplier = $this->db->get_where('suppliers', array('status' => 1));
										 $query_count = $query_supplier->num_rows();
										 ?>
									  <select name="supplier" class="form-control" id="supplier" onchange='getExpire(this.value);' >
										 <option value="">Select Supplier</option>
										 <?php
											if ($query_count > 0) {
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
							 </div>
							<div class="col-md-4"  id="expire" style='display:none;'>
								<div class="form-group">
									<label>Enter Days <span style="color: #F00">*</span></label>
									<input type="text" name="expire" id="exp" class="form-control"  autocomplete="off" />
								</div>
							</div>
<!--							<div class="col-md-4">
								<div class="form-group">
									<label>Weight</label>
									<input type="text" name="weight" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>-->
<!--							<div class="col-md-4">
								<div class="form-group">
									<label>Rack</label>
									<input type="text" name="rack" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>-->
							<div class="col-md-4">
								<div class="form-group">
									<label>Starting Qty</label>
									<input type="text" name="starting_qty" id="starting_qty" class="form-control" maxlength="250"  autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Purchase Price (Cost) <span style="color: #F00">*</span></label>
									<input type="text" name="purchase" class="form-control" maxlength="250" autofocus required autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Retail Price (Price) <span style="color: #F00">*</span></label>
									<input type="text" name="retail" class="form-control" maxlength="250" required autocomplete="off" />
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
									<label>Created By <span style="color: #F00">*</span></label>
									<input type="text" name="created_by" class="form-control" value="<?php echo $UserLoginName; ?>" readonly  />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button class="btn btn-primary submitformproduct" type="button" id="sbmt" >Add Product</button>
								</div>
							</div>
							<div class="col-md-4" id="distribute_warehouses">
								<div class="form-group">
									<label>&nbsp;&nbsp;</label>
									<a class="btn btn-primary"  id="btncl"> Click Here To Distribute to the warehouses </a>
								</div>
							</div>
							<div class="col-md-4" id="fuel_tank" style="display: none;">
								<div class="form-group">
									<label>&nbsp;&nbsp;</label>
									<a class="btn btn-primary"  id="tank"> Click Here To Distribute to the Fuel Tank </a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	<div class="row">
         <div class="col-md-8 warehouse_table" style="display: none;">
            <div class="row product_heading" style="text-align: center; font-size: 13px; color: #FFF; background-color: #5fc509; padding-top: 7px; padding-bottom: 7px; margin-left: 0px; margin-right: 0px;"></div>
            <table class="table table-bordered table-responsive" >
               <thead>
                  <tr>
                     <th width="25%">Warehouse</th>
                     <th width="25%">Batch No</th>
                     <th width="25%">Expire</th>
                     <th width="25%">Quantity</th>
                  </tr>
               </thead>
               <tbody id="getWareHouse">
               </tbody>
            </table>
         </div>
      </div>
	  
		 
	  <div class="row">
		  <div class="col-md-8 fuel_tank_table" style="display: none;"  >
            <div class="row product_heading_tank" style="text-align: center; font-size: 13px; color: #FFF; background-color: #5fc509; padding-top: 7px; padding-bottom: 7px; margin-left: 0px; margin-right: 0px;"></div>
            <table class="table table-bordered table-responsive" >
               <thead>
                  <tr>
					<th width="25%">Fuel Tank Number</th>
					<th width="25%">Batch No</th>
					<th width="25%">Expire</th>
					<th width="25%">Quantity</th>
                  </tr>
               </thead>
			   <tbody id="getTank">
			   </tbody>
            </table>
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
	
</div>
<?php
require_once 'includes/footer.php';
?>
<script>
   $("#depend").hide();
   $("#notdepned").show();
   
   $('.submitformproduct').click(function () {
	   document.getElementById("product_order_submit").submit();
   });
   
   $('#sbmt').attr('disabled', true);
   
   
   $('.CheckProductCode').blur(function (){
		var product_code = $(this).val();
		CheckProductCode(product_code);
   });
   
   function CheckProductCode(product_code){
	   $.ajax({
			type:'POST',
			url:"<?=base_url()?>Products/CheckProductCode",
			data: {product_code: product_code},
			dataType: 'JSON',
			success:function(data){
				if(data.found)
				{
					$('#errorproductCode').html('Product Code allready available please enter another!!');
				}
				else
				{
					$('#errorproductCode').html('');
				}
			}
		});
   }

   
   
   function getOutlet()
   {
	   var val = $('#outlet').val();
	   console.log(val);
		var getSubCategoryvalue = $('#getSubCategoryvalue').val();
		if(getSubCategoryvalue != "")
		{
			$.ajax({
			type:'POST',
			url:"<?=base_url()?>Products/get_warehouse_outletwise",
			data: {val: val,getSubCategoryvalue:getSubCategoryvalue},
			dataType: 'JSON',
			success:function(data){
					if(getSubCategoryvalue  == 20)
					{
						$('#getWareHouse').html('');
						$('#getTank').html(data.tank);
					}
					else
					{
						$('#getTank').html('');
						$('#getWareHouse').html(data.warehousedata);
						$('#warehousecount').val(data.warehousecount);
					}

					$('.datepicker').datepicker({
						format: "yyyy-mm-dd",
						todayBtn: "linked",
						autoclose: true
					});
				}
			});
		}
		else
		{
			alert('Please select category!!');
		}
   }
   
	var item_row = 1;
	$('#getWareHouse').delegate('.AddBatchExpire','click',function(){
		var id = $(this).attr('id');
		var c = $(this).attr('data-val');
		var html = '<span class="removeAddBatch'+id+item_row+'"><input type="text"  name="inventroy['+c+'][warehouse_batchno][]" class="form-control warehouse_batchno"  value="0" style="width: 100%;"></span>';
		$('#append_batchno'+id+c).append(html);
		var html = '<span class="removeAddBatch'+id+item_row+'"><div class="col-md-9" style="padding: 0px;">\n\
						<input type="text" name="inventroy['+c+'][warehouse_expire][]" class="form-control warehouse_expire datepicker"  style="width: 100%;">\n\
					</div>\n\
					<div  class="col-md-3" style="padding: 0px;margin-top:10px;">\n\
						<a style="cursor: pointer;"  class="RemoveBatchExpire" id='+id+item_row+'>Remove</a>\n\
					</div></span>';
		$('#append_expire'+id+c).append(html);
		item_row++;
		
		$('.datepicker').datepicker({
			format: "yyyy-mm-dd",
			todayBtn: "linked",
			autoclose: true
		});
	});
   
    $('body').delegate('.RemoveBatchExpire','click',function(){
		var id = $(this).attr('id');
		$('.removeAddBatch'+id).html('');
	});
   
   
	var item_row_tank = 1;
	$('#getTank').delegate('.AddBatchExpireTank','click',function(){
		var id = $(this).attr('id');
		var c = $(this).attr('data-val');
		var html = '<span class="removeAddBatch_tank'+id+item_row_tank+'"><input type="text"  name="tank['+c+'][warehouse_batchno][]" class="form-control tank_warehouse_batchno"  value="0" style="width: 100%;"></span>';
		$('#append_batchno_tank'+id+c).append(html);
		var html = '<span class="removeAddBatch_tank'+id+item_row_tank+'"><div class="col-md-9" style="padding: 0px;">\n\
						<input type="text" name="tank['+c+'][warehouse_expire][]" class="form-control tank_warehouse_expire datepicker"  style="width: 100%;">\n\
					</div>\n\
					<div  class="col-md-3" style="padding: 0px;margin-top:10px;">\n\
						<a style="cursor: pointer;"  class="RemoveBatchExpire_Tank" id='+id+item_row_tank+'>Remove</a>\n\
					</div></span>';
		$('#append_expire_tank'+id+c).append(html);
		item_row_tank++;
		
		$('.datepicker').datepicker({
			format: "yyyy-mm-dd",
			todayBtn: "linked",
			autoclose: true
		});
   });
   
    $('body').delegate('.RemoveBatchExpire_Tank','click',function(){
		var id = $(this).attr('id');
		$('.removeAddBatch_tank'+id).html('');
	});
   
   
   
	function getSubCategory(val) {
		if(val==20)
		{
			$('#distribute_warehouses').hide();	
			$('.warehouse_table').hide();	
			$('#fuel_tank').show();
		}
		else
		{
			$('.fuel_tank_table').hide();	
			$('#fuel_tank').hide();
			$('#distribute_warehouses').show();
		}
		
       $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>" + "Products/get_Sub_Category/" + val,
           success: function (data) {
               $("#sub_category").html(data);
           }
       });
	   getOutlet();
	}
	function getSupplier(val) {
		if (val == "") {
			$("#notdepned").show();
			$("#depend").hide();
		} else {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>" + "Products/get_Supplier/" + val,
				success: function (data) {
					$("#supplier").html(data);
					$("#depend").show();
					$("#notdepned").hide();
				}
			});
		}
	}
   
	function getExpire(val) {
		var element = document.getElementById('expire');
		if (val != '')
		{
			 element.style.display = 'block';
		}
		else
		{
			 element.style.display = 'none';
		}
	}

   $('.datepicker').datepicker({
   	format: "yyyy-mm-dd",
   	todayBtn: "linked",
   	autoclose: true
   });
   

   var variant_quantity;
   $(document).ready(function () {
   
   	$("#btncl").click(function () {
   		variant_quantity = $("#starting_qty").val();
   		var pname =  $.trim($("#name").val()) ;
		
		$("#name").css("border", "1px solid #ccc");
		$("#starting_qty").css("border", "1px solid #ccc");
		$("#outlet").css("border", "1px solid #ccc");
   		if ($(".warehouse_table").css('display') == 'none') {
			if (variant_quantity != "" && pname != "") {
				if($("#warehousecount").val() == 1)
				{
					$(".warehouse_quantity").val(variant_quantity); // show qyantiry if only one where house
				}
   				$(".warehouse_table").css('display', 'block');
   			}
			else
			{
				if(pname == "")
					$("#name").css("border", "1px solid red");
				
				if(variant_quantity == "")
					$("#starting_qty").css("border", "1px solid red");
				
				if($("#name").val() == "")
				{
					$("#outlet").css("border", "1px solid red");
				}
			}
			$(".product_heading").html(pname);
		} else {
   			$(".warehouse_table").css('display', 'none');
   			$("#mrk").css('display', 'none');
   		}
   	});
   
	$("#tank").click(function () {
   		variant_quantity = $("#starting_qty").val();
   		var pname = $("#name").val();
   		if ($(".fuel_tank_table").css('display') == 'none') {
   			if (variant_quantity != "" && pname != "") {
   				$(".fuel_tank_table").css('display', 'block');
   			}
			$(".product_heading_tank").html(pname);
   
   		} else {
   			$(".fuel_tank_table").css('display', 'none');
   		}
   	});
   
   
   
   });
   
   $('#getWareHouse').delegate('#add_to_warehouse','click',function(){
	   variant_quantity = $("#starting_qty").val();
		var sum = 0;
		$(".warehouse_quantity").each(function () {
			var value = $(this).val();
			if (!isNaN(value) && value.length != 0) {
				sum += parseInt(value);
			}
		});

//		if(variant_quantity != 0 && variant_quantity != '')
//		{
			if (parseInt(sum) === parseInt(variant_quantity)) {

				var variant_code = $("#code").val();
				$('.warehouse_quantity').each(function () {

					var warehouse_code = this.id;
					var warehouse_quantity = $('#' + this.id).val();
					var warehouse_batchno = $("#batchno" + this.id).val();
					var warehouse_expire = $("#expire" + this.id).val();
					$('#sbmt').attr('disabled', false);
					$('#btncl').attr('disabled', true);
					$('.warehouse_table').slideUp();
					$("#mrk").css('display', 'block');
				});

			} else {
				alert('Quantity does not match');
			}
//		}
//		else
//		{
//			alert('Please Enter Starting qty!!');
//		}
	});
   
   
	$('#getTank').delegate('#add_to_tank','click',function(){
	   variant_quantity = $("#starting_qty").val();
	 	var sum = 0;
		$(".tank_warehouse_quantity").each(function () {
			var value = $(this).val();
			if (!isNaN(value) && value.length != 0) {
				sum += parseInt(value);
			}
		});
		
		if(variant_quantity == 0)
		{
			if(sum == 0)
			{
				$('#sbmt').attr('disabled', false);
				$('#tank').attr('disabled', true);
				$('.fuel_tank_table').slideUp();
			}
			else
			{
				alert('Please Enter Starting qty!!');
			}
		}
		else if (parseInt(sum) === parseInt(variant_quantity)) {
			$('.tank_warehouse_quantity').each(function () {
				$('#sbmt').attr('disabled', false);
				$('#tank').attr('disabled', true);
				$('.fuel_tank_table').slideUp();
			});
		} else {
			alert('Quantity does not match');
		}
	});
</script>
