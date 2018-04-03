<?php
$app = realpath(APPPATH);
$this->load->view('includes/header.php');
$paid_bys = $this->Constant_model->getddData('payment_method', 'id', 'name', 'id');
?>
<style>
	body.modal-open .yes_print
	{
		display: none !important;
	}


</style>


	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<!--/popup add customer-->
		
			<div id="PopupCustomer" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Add New Customer</h4>
						</div>
						<div class="modal-body">
<!--					<form action="<?=base_url()?>customers/insertCustomer" method="post">-->
							<form id="add_customer" method="post">
						<div class="panel-body">
							<span align="center" id="message_customer"></span>
							
							<div class="row">
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Full Name <span style="color: #F00">*</span></label>
										<input type="text" name="fullname" id="fullname" class="form-control customer_empty"  maxlength="499" autofocus required autocomplete="off" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Email Address <span style="color: #F00">*</span></label>
										<input type="email" name="email" id="email" class="form-control customer_empty" required maxlength="254" autocomplete="off" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Mobile </label>
										<input type="text" name="mobile" id="mobile" class="form-control customer_empty" maxlength="499" autofocus autocomplete="off" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Address </label>
										<textarea name="address" id="address" class="form-control customer_empty" ></textarea>
									 </div>
								</div>
													<!--start new-->
								<div class="col-md-6">
									 <div class="form-group">
										<label>Customer Group </label>
										<div style="clear:both;"></div>
										<select class="form-control" name="group" id="group" required style="width:255px;">
											<option value="">--Select Customer Group--</option>
											<?php foreach ($group as $key => $value) { ?>
												<option  value="<?=$value->id?>"><?=$value->name?></option>
											<?php } ?>
											 </select>
									   </div>
								 </div>
								 <div class="col-md-6">
									<div class="form-group">
										<label>Nic<span style="color: #F00">*</span></label>
										<input type="text" name="nic" id="nic" class="form-control customer_empty" maxlength="499"  required autocomplete="off" value="" />
									</div>
								</div> 
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Password <span style="color: #F00">*</span></label>
										<input type="password" name="password" id="password" class="form-control customer_empty" maxlength="499" required autocomplete="off" value="" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Confirm Password <span style="color: #F00">*</span></label>
										<input type="password" name="conpassword" id="conpassword" class="form-control customer_empty" maxlength="499" data-match="#password" data-match-error="these don't match" required autocomplete="off" value="" />
									</div>
								</div>

							</div>
					
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Outstanding<span style="color: #F00"></span></label>
										<input type="number" name="outstanding" id="outstanding" class="form-control customer_empty" step=".01" autocomplete="off" value="" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Outlet <span style="color: #cc0000;">*</span></label>
										<div style="clear:both;"></div>
										<select required="" name="outlet_id" id="outlet_id" class="form-control" style="width:255px;">
											<?php
												foreach ($getOutlets as $outlet)
												{ ?>
													<option value="<?=$outlet->id?>"><?=$outlet->name?></option>		
											<?php }
											?>
										</select>

									</div>
								</div>
							</div>	
						
						</div><!-- Panel Body // END -->
					</div>
						<div class="modal-footer">
								<button class="btn btn-primary" style="width:100px;">Add</button>
						</div>
				</form>
					</div>
				</div>
			</div>	
		<!--/end popup add customer-->
		
			
		
	<form id="FormStockItemSubmit" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-lg-4">
				<h2>Customer Order</h2>
			</div>
			<div class="col-md-3">
				<div class="form-group" style="margin-top: 5px;">
					<label>Search Customer By Name, Mobile or NIC </label>
					<select name="ser_custome_name" id="ser_custome_name"  class="form-control ser_custome_name"  autocomplete="off">
						<option value="">Select Customer</option>	
						<?php foreach($customer as $cust_view){ ?>
						<option value="<?= $cust_view->id ?>"><?= $cust_view->fullname ?>[<?= $cust_view->mobile ?>][<?= $cust_view->nic ?>]</option>	
						<?php } ?>
					</select>	
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="form-group" style="margin-top: 5px;">
					<label>Sales Person </label>
					<select name="user_sales" id="user_sales"  class="form-control"  autocomplete="off">
						<option value="">Sales Person</option>	
						<?php foreach($sale_per_user as $sales_user_view){ 
						?>
						<option  value="<?= $sales_user_view->id ?>"><?= $sales_user_view->fullname ?></option>	
						<?php } ?>
					</select>	
				</div>
			</div>
			<div class="col-md-1" >
				<div class="form-group" style="margin-top: 30px;">
					<a  class="btn btn-success PopupCustomerclick" >
						Add New Customer
					</a>
					
				</div>
			</div>

		</div><!--/.row-->

		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label>Date & Time </label>
											<input type="text" name="date" value="<?=date('Y-m-d H:i:s')?>"  class="form-control" style="margin-top: 5px;" readonly />
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group">
											<label>Order / Estimate No.</label>
											<input type="text" readonly="" name="estimate_no" class="form-control" value="<?= $getgold_orders;?>" />
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label>Customer Name</label>
											<input type="text" name="customer_name" id="customer_name" class="form-control" />
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Customer Mobile No.</label>
											<input type="text" name="customer_mobile_no" id="customer_mobile" class="form-control" />
										</div>
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
											<label>Created By</label>
											<input readonly="" type="text" name="created_by" id="created_by" value="<?= $logged_name ?>" class="form-control" />
										</div>
									</div>

								</div>
								<div class="row">
									
									<div class="col-md-3">
										<div class="form-group">
											<label>Address</label>
											<textarea name="address" id="customer_address" class="form-control" ></textarea>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Note</label>
											<textarea name="note"  id="note" class="form-control" ></textarea>
										</div>
									</div>
									
								</div>
								
								<div class="row">
									<div class="col-md-5" style="margin-top: 22px;">
										<button class="btn btn-primary" style="width:100px;">Stock Item</button>
										<button class="btn btn-primary" style="width:100px;">Order Item</button>
										<button class="btn btn-primary" style="width:100px;">Discount</button>
										<button class="btn btn-primary" style="width:100px;">Tax</button>
									</div>
									<div class="col-md-3">
									<div class="form-group" style="margin-top: 5px;">
										<label>Outlet</label>
										<select name="outlet_id" id="outlet_id" class="form-control outlet_id" required autocomplete="off">
											<?php foreach($outlets as $outlet_view){?>
											<option  value="<?= $outlet_view->id ?>"><?= $outlet_view->name ?></option>	
											<?php } ?>
										</select>	
										</div>
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
											<label>Point</label>
											<input type="text"  name="point" id="point" class="form-control" />
										</div>
									</div>
									
									<div class="col-md-2">
										<div class="form-group">
											<label>Balance</label>
											<input type="text"  name="balance" id="balance" class="form-control" />
										</div>
									</div>
								</div>
								
								
							</div>
							
						</div>

						
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<div class="" style="text-align: left;background: #f1f1f1;padding: 10px;">
									<h1 class="panel-title"><i class="fa fa-shopping-cart"></i> Stock Item</h1>
								</div>
							</div>
							
							<div class="col-md-12" style="padding: 0px; margin-top: 10px;">
								<div class="col-md-2">
									<div class="form-group">
										<label>Warehouse</label>
										<select name="warehouse_tank" id="warehouse_tank"   class="form-control warehouse_tank">
											<option value="">Select Warehouse</option>					
										</select>	
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Select Item / Code</label>
											<select name="product_name_code" id="product_name_code" class="form-control product_name_code">
											<option value="">Select Item / Code</option>
										</select>
										<div id="warehouse_tank_error" style="color: #ff0033;"></div>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Balance Stock</label>
										<input type="text" id="balance_stock" readonly="" name="balance_stock"  class="form-control" />
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Price</label>
										<input type="text" name="price" id="product_price" readonly="" value="0" class="form-control" />
									</div>
								</div>
								
								<div class="col-md-1">
									<div class="form-group">
										<label>Qty</label>
										<input type="text" name="qty" id="qty" value="0" class="form-control" />
									</div>
								</div>
								
							
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Weight (g)</label>
										<input type="text" name="price" id="product_weight" readonly="" class="form-control" />
									</div>
								</div>
								
								<div class="col-md-1" style="padding-left: 0px;">
									<div class="form-group" style="margin-top: 25px;">
										<button  type="submit" class="btn btn-primary" style="width:80px;">Save</button>
									</div>
								</div>
							</div>
						</div>
						
				
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<table class="table">
									<thead>
										<tr>
											<th width="15%">Code</th>
											<th width="15%">Products</th>
											<th width="15%">Balance Stock</th>
											<th width="15%">Price</th>
											<th width="15%">Qty</th>
											<th width="10%">Weight (g)</th>
											<th width="20%">Sub Total</th>
											<th width="20%" conspan="2" align="center" >Action</th>
										</tr>
									</thead>
									<tbody id="appendItem">
									</tbody>
									
									<tfoot>
										<tr>
											<th colspan="6" style="text-align: right !important;">
												<div style="margin-top: 10px;">Total</div>
											</th>
											<th><input readonly="" type="text" name="subtotal" id="subtotal" value="0" class="form-control" /></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</form>	
		
		
		
		
	<div id="myModalData" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">
								<div class="" style="text-align: left;background: #f1f1f1;padding: 10px;">
									<h1 class="panel-title"><i class="fa fa-shopping-cart"></i> Services - <span id="product_code_popup" ></span></h1>
									
								</div>
							</h4>
						</div>
						<div class="modal-body">
									
													
					<form method="post" id="FormServiceSubmit"  >
						<div class="row" style="margin-top: 10px;">
							
							<div class="col-md-12" style="padding: 0px; margin-top: 10px;">
							
								<div class="col-md-5">
									<div class="form-group">
										<label>Select Service</label>
										<select name="service" id="service"  class="form-control service" style="width: 220px !important;">
											<option value="">Select Service</option>					
										<?php foreach($getSubcategory as $subcatg_view){ 
											?>
											<option  value="<?= $subcatg_view->id ?>"><?= $subcatg_view->sub_category ?></option>	
										<?php } ?>
										</select>	
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Price</label>
										<input type="text" name="service_price" id="service_price" class="form-control" />
									</div>
								</div>
								<div class="col-md-3" style="padding-left: 0px;">
									<div class="form-group" style="margin-top: 28px;">
										<button  class="btn btn-primary" style="width:80px;">Add</button>
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<table class="table" >
									<thead>
										<tr>
											<th width="20%">Code</th>
											<th width="20%">Service</th>
											<th width="20%">Price</th>
											<th width="40%" conspan="2" align="center" >Action</th>
										</tr>
									</thead>
									<tbody id="appendItemservices">
									</tbody>
									<tfoot>
										<tr>
											<th colspan="2" style="text-align: right !important;">
												<div style="margin-top: 10px;">Total</div>
											</th>
											<th><input readonly=""  style="width: 200px;" type="text" name="service_subtotal" id="service_subtotal" value="0" class="form-control service_subtotal" /></th>
											
										</tr>
										
									</tfoot>
								</table>
							</div>
						</div>
			
						</form>	
						</div>
							<div class="modal-footer">
								<button type="button"  class="btn btn-primary" id="services_stock_save" style="width:80px;" data-dismiss="modal">save</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
				</div>
					
		
		
		
		
		
		
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12" style="text-align: right;">
								<button class="btn btn-primary" id="save_print_submit">Save & Print</button>
							</div>
						</div>
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12" style="margin-bottom: 10px;">
								<div class="col-md-2" style="margin-top:8px; color: #cc0033; ">
									<b>Total Amount</b>
								</div>
							
							</div>
							<div class="col-md-12" style="margin-bottom: 10px;">
								<div class="col-md-2" style="margin-top:8px; color: #cc0033; ">
									<b>Total Product Cost</b>
								</div>
								<div class="col-md-4">
									<input readonly=""  style="width: 200px;" type="text" name="product_total" id="product_total" value="0" class="form-control" />
								</div>
							</div>
							<div class="col-md-12" style="margin-bottom: 10px;">
								<div class="col-md-2" style="margin-top:8px;color: #cc0033; ">
									<b>Total Service</b>
								</div>
								<div class="col-md-4">
									<input readonly=""  style="width: 200px;" type="text" name="service_total" id="service_total" value="0" class="form-control" />
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-2" style="margin-top:8px; color: #cc0033;">
									<b>Grand Total</b>
								</div>
								<div class="col-md-4">
									<input readonly=""  style="width: 200px;" type="text" name="grand_total" id="grand_total" value="0" class="form-control" />
								</div>
							</div>
						</div>
						
						
						
					</div>
				</div>
				
				
						

				<a href="<?= base_url() ?>Gold/view" style="text-decoration: none;">
					<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
						<i class="icono-caretLeft" style="color: #FFF;"></i>Back
					</div>
				</a>

			</div>
		</div>
	<br /><br /><br />
	</div>
<br /><br />
<!--//main conform message-->
		<div class="message-box animated fadeIn order_esta_popup" data-sound="alert" id="mb-signout">
			<div class="mb-container">
				<div class="mb-middle">
					<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
					<div class="mb-content">
						<p>Are you sure you want to Remove?</p>                    
						<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
						<input type="hidden" id="remove_data_ord" class="remove_data">
						<input type="hidden" id="totalval" class="totalval_data">
					</div>
					<div class="mb-footer">
						<div class="pull-right">
							<a id="remove_row" class="btn btn-success btn-lg esta_remove_row" data-dismiss="modal">Yes</a>
							<button class="btn btn-default btn-lg mb-control-close" >No</button>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--//service conform message-->
		<div class="message-box animated fadeIn order_services_popup" data-sound="alert" id="mb-signout">
					<div class="mb-container">
						<div class="mb-middle">
							<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
							<div class="mb-content">
								<p>Are you sure you want to Remove?</p>                    
								<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
								<input type="hidden" id="remove_data_ser" class="serremove_data">
								<input type="hidden" id="totalvalser" class="totalser_data">
							</div>
							<div class="mb-footer">
								<div class="pull-right">
									<a id="remove_row" class="btn btn-success btn-lg services_remove_row" data-dismiss="modal">Yes</a>
									<button class="btn btn-default btn-lg mb-control-close" >No</button>
								</div>
							</div>
						</div>
					</div>
				</div>

<?php
    require_once $app.'/views/includes/footer.php';
?>
<!--dropdown searching-->
<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/js/select2.min.js"></script>
<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>

<script>
	//dropdown seraching
	$('select').select2();
	
	//alpesh
	$('.ser_custome_name').change(function(event){	
		customer_change()
	});
	
	function customer_change()
	{
		var id = $('.ser_custome_name').attr('id');
		var customer_id = $(".ser_custome_name option:selected"). val();
				$.ajax({
				type:'POST',
				url:"<?=base_url();?>Gold/get_matchCustomername",
				data: {id: customer_id},
				dataType: 'JSON',
				success:function(data){
					$('#id').val(data.id);
					$('#customer_name').val(data.customer_name);
					$('#customer_mobile').val(data.customer_mobile);
					$('#customer_email').val(data.customer_email);
					$('#customer_address').val(data.customer_address);
					
				}
		 });
	}
	$('.outlet_id').change(function(event){	
		outletdata();
	});
	
	function outletdata()
	{
		var oultet_id = $("#outlet_id"). val();
				$.ajax({
				type:'POST',
				url:"<?=base_url();?>Gold/getOutletWiseWarehouse",
				data: {outlet_id: oultet_id},
				dataType: 'JSON',
				success:function(data){
					$('.warehouse_tank').html(data.success);
					warehousegetdata();
				}
		 });
	}
	outletdata();
	
	
$('.warehouse_tank').change(function(event){		
	warehousegetdata();
});

function warehousegetdata()
{
	var outlet_id = $('.outlet_id').val();
	var wareid = $(".warehouse_tank option:selected"). val();
	var type = $('.warehouse_tank option:selected').attr('data-val');;
	$.ajax({
		type:'POST',
		url:"<?=base_url();?>Gold/getOutletWiseWarehouseProduct",
		data: {wareid: wareid,outlet_id:outlet_id,type:type},
		dataType: 'JSON',
		success:function(data){
		$('#product_name_code').html(data.product);
			$('#product_price').val('0');
			$('#balance_stock').val('0');
		}
	 });
}



$('.product_name_code').change(function(event){	
		
		
	var outlet_id = $('.outlet_id').val();
		var warehouse_tank = $('.warehouse_tank').val();
			$('#outlet_error').html('');
			$('#warehouse_tank_error').html('');
			var type = $('.warehouse_tank option:selected').attr('data-val');
			var product_code = $(this).val();
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Gold/getProductDetailInventory",
				data: {product_code: product_code,outlet_id:outlet_id,warehouse_tank:warehouse_tank,type:type},
				dataType: 'JSON',
				success:function(data){
					$('#product_price').val(data.product_price);
					$('#balance_stock').val(data.balance_stock);
					$('#product_weight').val(data.product_weight);
				}
		 });

	});
	
//----------------
	var row_item = 1;
$('#FormStockItemSubmit').submit(function(e){
	
		e.preventDefault();
			var outlet_id		= $('.outlet_id').val();
			var warehouse_tank	= $('.warehouse_tank').val();
			var product_code_val	= $("#product_name_code option:selected").val();
			var product_name_code	= $("#product_name_code option:selected").text();
			var balance_stock = $("#balance_stock").val();
			var product_price = $('#product_price').val();
			var qty = $('#qty').val();
			var product_weight = $('#product_weight').val();
			var total_val=product_price*qty;
			
			
		var html = '<tr id="RemoveData'+row_item+'">\n\
				<td>'+product_code_val+'\
					<input type="hidden" name="return['+row_item+'][outlet_id]" value="'+outlet_id+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][warehouse_tank]" value="'+warehouse_tank+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][product_code_val]" value="'+product_code_val+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][product_name_code]" value="'+product_name_code+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][product_service_id]" value="'+product_code_val+row_item+'" class="form-control">\n\
					</td>\n\
					<td>'+product_name_code+'</td>\n\
					<td><input type="text" readonly name="return['+row_item+'][balance_stock]"			 value="'+balance_stock+'" class="form-control"></td>\n\
					<td><input type="text" readonly name="return['+row_item+'][product_price]"	 value="'+product_price+'" class="form-control"></td>\n\
					<td><input type="text" readonly name="return['+row_item+'][qty]"		 value="'+qty+'" class="form-control"></td>\n\
					<td><input type="text"readonly name="return['+row_item+'][product_weight]" value="'+product_weight+'" class="form-control"></td>\n\
					<td><input type="text"readonly name="return['+row_item+'][total_val]" value="'+total_val+'" class="form-control"></td>\n\
					<td><span style="cursor:pointer" data-val="'+total_val+'" class="btn btn-primary btn-circle removeItem" id="'+row_item+'" ><i class=" glyphicon glyphicon-trash"></i></span></td>\n\
					<td><span style="cursor:pointer" data-val="'+product_code_val+'" class="btn btn-primary PopupServices " id="'+row_item+'" >Services</span></td>\n\
					</tr><tr ><td colspan="100%" id="service_append'+row_item+'"></td></tr>';
					
		if(qty == '0')
		{
			alert("Please add at least one item!!");
		}
		else
		{
			$('#appendItem').append(html);
				var subtotal = $('#subtotal').val();
				var finaltotal = parseFloat(subtotal) + parseFloat(total_val);
				 $('#subtotal').val(finaltotal);
				// $(".outlet_id").select2().val("").trigger("change");	
				 $(".warehouse_tank").select2().val("").trigger("change");	
				 $('#qty').val('0');
				 $('#product_weight').val('0');
				
			row_item++;	
		}
		calamount();
	});
	
	//popup
	$(".table").delegate(".removeItem", "click", function(){
			var id = $(this).attr('id'); 
			var totalval = $(this).attr('data-val');
			$('.remove_data').val(id);
			$('.totalval_data').val(totalval);
			$('.order_esta_popup').modal('show');
		});
	
		$(".esta_remove_row").click(function () {
			var id = $('.remove_data').val();
			var total_val = $('.totalval_data').val();
			var subtotal = $('#subtotal').val();
			var finaltotal = parseFloat(subtotal) - parseFloat(total_val);
			$('#subtotal').val(finaltotal);
			$("#RemoveData"+id).remove();
			//$('#RemoveData'+id).html('');
			calamount();
		});
	//end popup	
	
	
	//services
		var row = 0;
$('#FormServiceSubmit').submit(function(e){
	
		e.preventDefault();
			var services_id		= $('.service option:selected').val();
			var services_price	= $('#service_price').val();
			var services_name	= $(".service option:selected").text();
			var product_code_id	= $("#product_code_popup").text();
			var total_val=services_price;
		
		var html = '<tr id="RemoveDataService'+row+'" >\n\
				<td >'+services_id+'\
					<input type="hidden" name="return['+product_code_id+'][sales_return]['+row+'][product_service_id]" value="'+product_code_id+'" class="form-control">\n\
					<input type="hidden" name="return['+product_code_id+'][sales_return]['+row+'][services_id]" value="'+services_id+'" class="form-control">\n\
					</td>\n\
					<td>'+services_name+'</td>\n\
					<td><input type="text" style="width: 125px;" readonly name="return['+product_code_id+'][sales_return]['+row+'][services_price]" value="'+services_price+'" class="form-control"></td>\n\
					<td><span style="cursor:pointer" data-val="'+total_val+'" class="btn btn-primary btn-circle RemoveDataService"  id="'+row+'" ><i class=" glyphicon glyphicon-trash"></i>  </span>\n\
					 <span>  <input type="checkbox"  class="yes_print"  name="return['+product_code_id+'][sales_return]['+row+'][pre_print_invoice]" value="1" ></span></td>\n\
		</tr>';
					
		if(services_price == 0)
		{
			alert("Please add at least one item!!");
		}
		else
		{
			$('#appendItemservices').append(html);
				var service_subtotal = $('#service_subtotal').val();
				var finaltotal = parseFloat(service_subtotal) + parseFloat(total_val);
				 $('#service_subtotal').val(finaltotal);
				 $(".service").select2().val("").trigger("change");	
				 $('#service_price').val('0');
			

			row++;	
		}
		calamount();
	});
	
	
		//popup//services
	$(".table").delegate(".RemoveDataService", "click", function(){
			var id = $(this).attr('id'); 
			var totalval = $(this).attr('data-val');
			$('.serremove_data').val(id);
			$('.totalser_data').val(totalval);
			$('.order_services_popup').modal('show');
		});
	
		$(".services_remove_row").click(function () {
			var id = $('.serremove_data').val();
			var total_val = $('.totalser_data').val();
			var service_subtotal = $('#service_subtotal').val();
			var finaltotal = parseFloat(service_subtotal) - parseFloat(total_val);
			$('#service_subtotal').val(finaltotal);
			$("#RemoveDataService"+id).remove();
			//$('#RemoveData'+id).html('');
			calamount();
		});
	//end popup	services
	
	
	
//grand total
	function calamount()
	{
			var Product_total = $('#subtotal').val();
			var Services_total = $('#service_subtotal').val();
			var gardtotal= parseFloat(Product_total) + parseFloat(Services_total);
			$("#product_total").val(parseFloat(Product_total).toFixed(2));
			$("#service_total").val(parseFloat(Services_total).toFixed(2));
			$("#grand_total").val(parseFloat(gardtotal).toFixed(2));
		
	}
	
	
	
//multiple form array value store	
	
	 $(document).ready(function(){
		 
		 //add new customer
			$('.PopupCustomerclick').click(function(){
				$('#PopupCustomer').modal('show');
			});
		 
		 
      $('#save_print_submit').click(function(e){
			e.preventDefault();
			
			var formData = new FormData();
			
			var form1 = $('#FormStockItemSubmit').serializeArray();
			//alert(form1);
			$.each(form1, function (key, input) {
				formData.append(input.name, input.value);
			});
			
			var form2 = $('#FormServiceSubmit').serializeArray();
		//	alert(form2);
		
			$.each(form2, function (key, input) {
				formData.append(input.name, input.value);
			});
	
		
		var grand_total = $('#grand_total').val();
			var ser_custome_name = $('#ser_custome_name').val();
			var user_sales = $('#user_sales').val();
		if(ser_custome_name == 0 || ser_custome_name ==  "" && user_sales == 0 || user_sales ==  "")
		{
			alert("Please add at Search Customer & Sales Person !!");
		}
		else if(grand_total == 0 || grand_total ==  "")
		{
			alert("Please add at least one item!!");
		}
		else
		{
			
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>Gold/customer_order_esatb_add",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'JSON',
					success:function(data){
						window.location.href='<?=base_url()?>Gold/view_invoice?id='+data;
					}
			});

}
		
	  });
	  
	  $('.outlet_id').change(function(event){	
		$('#RemoveData1').html('');
		$('#RemoveData').html('');
		$('#subtotal').val('0');
		$('#service_subtotal').val('0');
		 $('#point').val('0');
		$('#balance').val('0');
		calamount();
	});
	
	$( "tbody" ).delegate(".PopupServices","click", function() {
			var id = $(this).attr('id');
			$('#service_subtotal').val('0');
			$('#product_code_popup').html(id);
			$('#myModalData').modal('show');
			
		});
    });
	
	
		 
      $('#services_stock_save').click(function(e){
			e.preventDefault();
			
			var Product_code = $('#product_code_popup').text();
			var serviceval=$('#appendItemservices').html();
			$('#service_append'+Product_code).html(
								'<table class="table"> '+
									'<thead>' +
										'<tr>'+
											'<th width="25%">Code</th>'+
											'<th width="25%">Service</th>'+
											'<th width="25%">Price</th>'+
											'<th width="25%">Action</th>'+
										'</tr>'+
										'</thead><tbody>'+serviceval+'</tbody></table>');
			
			$(".service").select2().val("").trigger("change");	
			$('#service_price').val('0');
			$('#appendItemservices').html('');
			$('#service_subtotal').val('0');
			
	});
	
	
	$(function() {
		
		
		
		
//		$(".table").delegate(".yes_print", "change", function(){
//			this.value = this.checked ? 0 : 1;
//			console.log('hello')
//		 });
	  
		$("#add_customer").validate({
		  rules: {
				fullname: "required",
				email: {
							required: true,
							email: true,
						},
				nic: "required",
						
				password: {
							required: true,
							//number: true,
						  },
				conpassword:{
								required: true,
								equalTo: '[name="password"]'
							},
				
				outlet_id: "required",
				
			},
			messages: {
				fullname: "Please enter your first name",
				password: {
							required: "Please provide a password",
							},
				email: "Please enter a valid email address",
				nic : "Please enter your group ",
				outlet_id: "Please enter your choice",
		
				},

			submitHandler: function(form) {
					var formData = new FormData();
					var contact = $('#add_customer').serializeArray();
					$.each(contact, function (key, input) {
						formData.append(input.name, input.value);
					});
				//	alert(formData);
					$
					$.ajax({
							type:'POST',
							url:"<?=base_url();?>Gold/addCustomerorder_estimate",
							data: formData,
							cache: false,
							contentType: false,
							processData: false,
							dataType: 'JSON',
							success:function(data){
									if(data.error_email)
									{	
										$('#message_customer').html(data.error_email);
									}
									else
									{
										alert(data.success);
										$('.customer_empty').val('');
										$('#ser_custome_name').append(data.customer_id);
										customer_change();
										$('#PopupCustomer').modal('hide');
									}
									
						}
					});
		
				}
		});
});
	
	
	</script>
	<script src="<?= base_url()?>assets/js/jquery.validate.min.js"></script>