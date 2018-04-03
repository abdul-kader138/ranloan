<?php
require_once 'includes/header.php';
?>
<script src="<?= base_url() ?>assets/js/jquery.js"></script>
<script src="<?= base_url() ?>assets/js/typeahead.min.js"></script>


<link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet">

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

	.typeahead, .tt-query, .tt-hint {
		border: 1px solid #CCCCCC;
		border-radius: 4px;
		font-size: 14px;
		height: 40px;
		line-height: 30px;
		outline: medium none;
		padding: 8px 12px;
		width: 312px;
	}
	.typeahead {
		background-color: #FFFFFF;
	}
	.typeahead:focus {
		border: 2px solid #0097CF;
	}
	.tt-query {
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
	}
	.tt-hint {
		color: #999999;
	}
	.tt-dropdown-menu {
		background-color: #FFFFFF;
		border: 1px solid rgba(0, 0, 0, 0.2);
		border-radius: 4px;
		box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
		margin-top: 0px;
		padding: 8px 0;
		width: 312px;
	}
	.tt-suggestion {
		font-size: 14px;
		line-height: 24px;
		padding: 3px 20px;
	}
	.tt-suggestion.tt-is-under-cursor {
		background-color: #0097CF;
		color: #FFFFFF;
	}
	.tt-suggestion p {
		margin: 0;
	}
</style>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Create Purchase Order</h1>
		</div>
	</div>
	
	<form id="FormPurchaseSubmit" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Purchase Order Number <span style="color: #F00">*</span></label>
									<input type="text" name="po_number" value="<?= $purchaseOrderNumber ?>" class="form-control" readonly=""  autofocus required autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Outlet <span style="color: #F00">*</span></label>
									<select name="outlet" class="form-control outletwiseProduct" required>
										<?php
										foreach ($getOutlets as $outlet) { 
											$selected = '';
											if(!empty($this->input->get('outlet_id')))
											{
												if($outlet->id == $this->input->get('outlet_id'))
												{
													$selected = 'selected';
												}
											}
											?>
										<option <?=$selected?> value="<?=$outlet->id?>"><?= $outlet->name ?></option>	
										<?php } ?>
									</select>
								</div>
							</div>
							<span id="warehouse">
							</span>
							<div class="col-md-4">
								<div class="form-group">
									<label>Supplier <span style="color: #F00">*</span></label>
									<select name="supplier" id="getSupplierDate" class="form-control" required>
										<option value="">Choose Supplier</option>
										<?php
										foreach ($getSupplier as $supplier) {
											$selected = '';
											if(!empty($this->input->get('supplier_id_fk')))
											{
												if($supplier->id == $this->input->get('supplier_id_fk'))
												{
													$selected = 'selected';
												}
											}
											?>
										<option <?=$selected?> value="<?= $supplier->id ?>"><?= $supplier->name ?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Purchase Order Date <span style="color: #F00">*</span></label>
									<input type="text" name="po_date" value="<?php echo date($dateformat, time()); ?>" readonly class="form-control" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Purchase Bill Date <span style="color: #F00">*</span></label>
									<input type="text" name="transation_date" class="form-control" id="transation_date" value="<?= date('d-m-Y'); ?>" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Supplier Address</label>
									<textarea id="SupplierAddress" name="supplieraddress" class="form-control"></textarea>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12" style="border-top: 1px solid #ccc;"></div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive" width="100%">
									<table class="table" id="items">
										<thead>
											<tr>
												<th style="background-color: #686868; color: #FFF;">Product Code</th>
												<th style="background-color: #686868; color: #FFF;">Price</th>
												<th style="background-color: #686868; color: #FFF;">In Stock</th>
												<th style="background-color: #686868; color: #FFF;">New Price</th>
												<th style="background-color: #686868; color: #FFF;">Order Qty.</th>
												<th style="background-color: #686868; color: #FFF;">Discount %</th>
												<th style="background-color: #686868; color: #FFF;">Tax %</th>
												<th width="12%" style="background-color: #686868; color: #FFF;">Sub Total</th>
												<th width="2%" style="background-color: #686868; color: #FFF;">Action</th>
											</tr>
										</thead>
										<tbody id="addItemWrp">
											<tr  id="item_row_0" class="dynamic_row">
												<td width="25%">
													<span id="productFilter">
														<select name="purchase[0][product_id]" id="0" class="form-control add_product_po FilterProduct checkFilter0">
														<option value="">Search Product by Name OR Code</option>
														<?php
															foreach ($getProduct as $product)	
															{ 
																$selected = '';
																if(!empty($this->input->get('code')))
																{
																	if($product->code == $this->input->get('code'))
																	{
																		$selected = 'selected';
																	}
																}
																?>
														<option <?=$selected?> value="<?=$product->code?>"><?=$product->code."[".$product->name."]";?></option>
														<?php }
														?>
														</select>
													</span>
												</td>
												<td><input  class="form-control price" id="price0" name="purchase[0][price]" value="" placeholder="0" readonly="" type="text"></td>
												<td><input  class="form-control in_stock" id="in_stock0" name="purchase[0][in_stock]" value="" placeholder="0" readonly="" type="text"></td>
												<td><input  class="form-control new_price" id="new_price0" name="purchase[0][new_price]" value="" placeholder="0" type="text"></td>
												<td><input  class="form-control qty" id="qty0" name="purchase[0][qty]" value="" placeholder="0" type="text"></td>
												<td>
													<input  class="form-control discount" id="discount0" name="purchase[0][discount]" value="" placeholder="0" type="text">
													<input  class="form-control sub_discount_amount" id="sub_discount_amount0" name="purchase[0][sub_discount_amount]" value="" placeholder="0" type="hidden">
												</td>
												<td><input  class="form-control tax" id="tax0" name="purchase[0][tax]" value="" placeholder="0" type="text">
													<input  class="form-control sub_tax" id="sub_tax0" name="purchase[0][sub_tax]" value="" placeholder="0" type="hidden">
													<input  class="form-control inventoryid" id="inventoryid0" name="purchase[0][inventoryid]" value="" placeholder="0" type="hidden">
												</td>
												<td><input  class="form-control subtotal" id="subtotal0" name="purchase[0][subtotal]" value="" placeholder="0" type="text"></td>
												<td><i class="glyphicon glyphicon-remove-sign item_remove create_popup_remove" id="0" style="color: red; cursor: pointer; font-size: 28px;"></i></td>
											</tr>
											<tr id="item_below_row">
												<td colspan="6">
													<button type="button" style="width:100px;" id="add_row" class="btn btn-primary">Add Row</button>
												</td>
												<td>
													<span style="font-size: 18px;"><b>Total Amount</b></span>
												</td>
												<td colspan="2">
													<input type="text" readonly="" value=""  placeholder="0" name="total_amount" id="total_net" class="form-control" />
													<input type="hidden" readonly="" value="0" name="total_items" id="total_items" class="form-control" />
													<input type="hidden" readonly="" value="0" name="discount_amount" id="discount_amount" class="form-control" />
													<input type="hidden" readonly="" value="0" name="discount_percentage" id="discount_percentage" class="form-control" />
													<input type="hidden" readonly="" value="0" name="tax_amount" id="tax_amount" class="form-control" />
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button id="sendBtn" class="btn btn-primary" type="submit">Create Purchase Order</button>
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>

					</div>
				</div>
				
				<a href="<?= base_url() ?>purchase_order/po_view" style="text-decoration: none;">
					<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
						<i class="icono-caretLeft" style="color: #FFF;"></i>Back
					</div>
				</a>

			</div>
		</div>
	</form>
	
	<br /><br /><br /><br /><br />
</div>

<div class="message-box animated fadeIn create_remove_popup" data-sound="alert" id="mb-signout">
	<div class="mb-container">
		<div class="mb-middle">
			<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
			<div class="mb-content">
				<p>Are you sure you want to Remove?</p>                    
				<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
				<input type="hidden" id="crearemove_data" class="crearemove_data">
			</div>
			<div class="mb-footer">
				<div class="pull-right">
					<a id="remove_row" class="btn btn-success btn-lg createdata_remove_row" data-dismiss="modal">Yes</a>
					<button class="btn btn-default btn-lg mb-control-close" >No</button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
require_once 'includes/footer.php';
?>

<script src="<?= base_url() ?>assets/js/select2.full.min.js"></script>
<!-- Select2 -->
<script>
    $(document).ready(function () {
		
		$("#transation_date").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
			
        });

		$('#getSupplierDate').change(function(){
			supplierinfo();
		});
		
		function supplierinfo()
		{
			var supplierid = $('#getSupplierDate').val();
			if(supplierid != "")
			{
				$.ajax({
					type:'POST',
					url:"<?=base_url()?>purchase_order/getSupplierData",
					data: {supplierid: supplierid},
					dataType: 'JSON',
					success:function(data){
						$('#SupplierAddress').html(data.supplier_name);
					}
				});
			}
			else
			{
				$('#SupplierAddress').html('');
			}
		}
		supplierinfo();
		
		
		
        $('#FormPurchaseSubmit').submit(function(e){
			e.preventDefault();
			var checkFilter = $('.checkFilter0').val();
			var qty = $('#qty0').val();
			if(checkFilter == "")
			{
				alert('Please Select at least one product!!');
			}
			else if(qty == "" || qty == 0)
			{
				alert('Please enter Qty!!');
			}
			else
			{
				
				var formData = new FormData();
				var contact = $(this).serializeArray();
				$.each(contact, function (key, input) {
					formData.append(input.name, input.value);
				});
				$('#sendBtn').addClass('disabled');
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>purchase_order/insertNewPO",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'JSON',
					success:function(data){
						 window.location.href='<?=base_url()?>purchase_order/po_view';
					}
				});
			}
		});
		
		
		
		
		var item_row = 1;
		$("#add_row").click(function(e) {
				e.preventDefault();
				var outlet_id = $('.outletwiseProduct').val();
				if(outlet_id == "")
				{
					alert('Please Select Outlet!!');
				}
				else
				{
					$.ajax({
						type:'POST',
						url:"<?=base_url()?>Purchase_order/outletwiseProduct",
						data: {outlet_id: outlet_id,item_row:item_row},
						dataType: 'JSON',
						success:function(data){
							var html = '';
							html ='<tr  id="item_row_'+item_row+'" class="dynamic_row"><td>'+data.product+'</td>\n\
									<td><input  class="form-control price" id="price'+item_row+'" name="purchase['+item_row+'][price]" value="" placeholder="0" readonly="" type="text"></td>\n\
									<td><input  class="form-control in_stock" id="in_stock'+item_row+'" name="purchase['+item_row+'][in_stock]" value="" placeholder="0" readonly="" type="text"></td>\n\
									<td><input  class="form-control new_price" id="new_price'+item_row+'" name="purchase['+item_row+'][new_price]" value="" placeholder="0"	type="text"></td>\n\
									<td><input  class="form-control qty" id="qty'+item_row+'"  name="purchase['+item_row+'][qty]" value="" placeholder="0"  type="text"></td>\n\
									<td><input  class="form-control discount" id="discount'+item_row+'" name="purchase['+item_row+'][discount]" value="" placeholder="0"  type="text">\n\
										<input  class="form-control sub_discount_amount" id="sub_discount_amount'+item_row+'" name="purchase['+item_row+'][sub_discount_amount]" value="" placeholder="0" type="hidden">\n\
										<input  class="form-control inventoryid" id="inventoryid'+item_row+'" name="purchase['+item_row+'][inventoryid]" value="" type="hidden"></td>\n\
									<td><input  class="form-control tax" id="tax'+item_row+'" name="purchase['+item_row+'][tax]" value="" placeholder="0"  type="text">\n\
										<input  class="form-control sub_tax" id="sub_tax'+item_row+'" name="purchase['+item_row+'][sub_tax]" value="" placeholder="0" type="hidden"></td>\n\
									<td><input  class="form-control subtotal" id="subtotal'+item_row+'" name="purchase['+item_row+'][subtotal]" value="" placeholder="0"  type="text"></td>\n\
									<td><i class="glyphicon glyphicon-remove-sign item_remove create_popup_remove " id="'+item_row+'" style="color: red; cursor: pointer; font-size: 28px;"></i></td>\n\
								</tr>';
							$("#addItemWrp").prepend(html);
							selecttwo();
							item_row++;
						}
					});
				}
		});
		
		
		
		
		$(".table").delegate(".create_popup_remove", "click", function(){
			var id = $(this).attr('id'); 
			$('.crearemove_data').val(id);
			$('.create_remove_popup').modal('show');
		});
		
		$(".createdata_remove_row").click(function () {
			var id = $('.crearemove_data').val();
			$("#item_row_"+id).remove();
			calamount();
		});
		

		function changeFiltter()
		{
			var outlet_id = $('.outletwiseProduct').val();
			var warehouse_id = $('.StoreWarehouse').val();
			var warehouse_type = $('.StoreWarehouse option:selected').attr('data-val');
			var id = 0;
			var product_code = $('.FilterProduct').val();
			if(product_code!="")
			{
					$.ajax({
						type:'POST',
						url:"<?=base_url()?>Purchase_order/FilterProduct",
						data: {outlet_id: outlet_id,warehouse_id:warehouse_id,warehouse_type:warehouse_type,product_code:product_code},
						dataType: 'JSON',
						success:function(data){
							if(data.status)
							{
								$('#in_stock'+id).val(data.in_stock);
								$('#price'+id).val(data.purchase_price);
								$('#inventoryid'+id).val(data.inventoryid);
								$('#new_price'+id).val(data.purchase_price);
							}
							else
							{
								$('#in_stock'+id).val('0');
								$('#price'+id).val(data.purchase_price);
							}
						}
					});
			}
		}
		
		changeFiltter();
		
		$(".table").delegate(".FilterProduct","change",function(e) {
			var outlet_id = $('.outletwiseProduct').val();
			var warehouse_id = $('.StoreWarehouse').val();
			if(outlet_id == "")
			{
				alert('Please Select Outlet!!');
			}
			else if(warehouse_id == "")
			{
				alert('Please Select WareHouse!!');
			}
			else
			{
				var warehouse_type = $('.StoreWarehouse option:selected').attr('data-val');
				var id = $(this).attr('id');
				var product_code = $(this).val();
				if(product_code!="")
				{
					$.ajax({
						type:'POST',
						url:"<?=base_url()?>Purchase_order/FilterProduct",
						data: {outlet_id: outlet_id,warehouse_id:warehouse_id,warehouse_type:warehouse_type,product_code:product_code},
						dataType: 'JSON',
						success:function(data){
							if(data.status)
							{
								$('#in_stock'+id).val(data.in_stock);
								$('#price'+id).val(data.purchase_price);
								$('#inventoryid'+id).val(data.inventoryid);
								$('#new_price'+id).val(data.purchase_price);
							}
							else
							{
								$('#in_stock'+id).val('0');
								$('#price'+id).val(data.purchase_price);
							}
						}
					});
				}
			}
		});
		
		
		
		
		
		$('.outletwiseProduct').change(function(){
			changeoutlet();
		});
		
		function changeoutlet()
		{
			var outlet_id = $('.outletwiseProduct').val();
			var item_rows = 0
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Purchase_order/outletwiseProduct",
				data: {outlet_id: outlet_id,item_row:item_rows},
				dataType: 'JSON',
				success:function(data){
					$('#productFilter').html(data.product);
					$('#warehouse').html(data.warehouse);
					selecttwo();
				}
			});
		}
		changeoutlet();
		
		
		function selecttwo()
		{
			$(".add_product_po").select2();
		}
		selecttwo();
		
	$(".table").delegate(".dynamic_row input, select", "keyup", function() {
		calamount();
	});

	function calamount()
	{
		var totalnetamount	= 0;
		var total_items		= 0;
		var discount_amount = 0;
		var discount_percentage = 0;
		var tax_amount		= 0;
		$("#items").find('.dynamic_row').each(function (i) {
			var $fieldset = $(this);

			var pcs        = ($('.qty', $fieldset).val());
			var rate       = ($('.price', $fieldset).val());
			var new_price  = ($('.new_price', $fieldset).val());
			var discount   = ($('.discount', $fieldset).val());
			var tax        = ($('.tax', $fieldset).val());
			var in_stock        = ($('.in_stock', $fieldset).val());

			if(pcs.trim()==''){
				pcs=0;
				$('.qty', $fieldset).val('0');
			}
			if(rate.trim()==''){
				rate=0;
				$('.price', $fieldset).val('0');
			}
			if(new_price.trim()==''){
				new_price=0;
				$('.new_price', $fieldset).val('0');
			}
			if(discount.trim()==''){
				discount=0;
				$('.discount', $fieldset).val('0');
			}
			if(tax.trim()==''){
				tax=0;
				$('.tax', $fieldset).val('0');
			}
			


			var grossamount = parseFloat(pcs*new_price).toFixed(2);
			
			if (discount.indexOf("%") >= 0) 
			{
				var discount = discount.substr(0, discount.indexOf('%'));
				var discountamt = parseFloat((discount/100)*grossamount).toFixed(2);
				var subtotal = parseFloat(grossamount-discountamt);
				discount_percentage = parseFloat(discount_percentage) + parseFloat(discount);
			}
			else
			{
				if(parseFloat(discount)>parseFloat(grossamount))
				{
					var discount = 0;
					$('.discount', $fieldset).val(discount);
					alert('Discount Amount must to less than Payable Amount!');
				}
				var discountamt = discount;
				var subtotal = parseFloat(grossamount)-parseFloat(discount);
			}
		
			var taxamount = parseFloat(grossamount) * (parseFloat(tax) / 100);
			var netamount   = parseFloat(subtotal + parseFloat(taxamount)).toFixed(2);
			$('.subtotal', $fieldset).val(netamount);
			$('.sub_discount_amount', $fieldset).val(discountamt);
			$('.sub_tax', $fieldset).val(taxamount);
			
			tax_amount			= parseFloat(tax_amount) + parseFloat(taxamount);
			discount_amount		= parseFloat(discount_amount) + parseFloat(discountamt);
			
			total_items			= parseFloat(total_items) + parseFloat(pcs);
			totalnetamount		= parseFloat(totalnetamount) + parseFloat(netamount);
			
			$("#total_net").val(parseFloat(totalnetamount).toFixed(2));
			$("#total_items").val(parseFloat(total_items).toFixed(2));
			$("#discount_amount").val(parseFloat(discount_amount).toFixed(2));
			$("#discount_percentage").val(parseFloat(discount_percentage).toFixed(2));
			$("#tax_amount").val(parseFloat(tax_amount).toFixed(2));
		});
	}
    });
	
	

</script>
