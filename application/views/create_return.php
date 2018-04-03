<?php
require_once 'includes/header.php';
?>


<!-- Select2 -->
<link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet">

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Create Return Order</h1>
		</div>
	</div><!--/.row-->

	
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<form id="submitalldata" method="post">
							
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Date & Time <span style="color: #F00">*</span></label>
									<input name="date_and_time" class="form-control"  readonly value="<?=date('Y-m-d H:i:s')?>" type="text">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Sales Return Ref No. <span style="color: #F00">*</span></label>
									<input name="sales_return_ref" class="form-control" readonly="" value="<?=$getSalesReturnID?>" type="text">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label style="font-size: 13px;">Customer <span style="color: #F00">*</span></label>
									<select class="payment_customer" style="width: 100%;" name="payment_customer" >
										<?php
										foreach ($getCustomer as $customer)
										{ 
											$selecred = '';
											if(!empty($getDefaultCustomer))
											{
												if($getDefaultCustomer == $customer->id)
												{
													$selecred = "selected";
												}
											}
											?>
										<option <?=$selecred?> value="<?=$customer->id?>"><?=$customer->fullname?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Outlet <span style="color: #F00">*</span></label>
									<?php
									if($RollID == 3)
									{ ?>
									<input name="outlet" type="hidden" value="<?=$outlet_id?>" id="outlet_id" class="form-control" >
									<input type="text" readonly="" value="<?=$UserOutletName?>" class="form-control" >
								<?php	}
								 else {
									?>
									<select name="outlet" id="outlet_id" class="form-control" >
										<?php
										foreach($getOutlets as $outlet)
										{ 
											$selected = '';
											if(!empty($getMainSuspend->outlet_id))
											{
												if($getMainSuspend->outlet_id == $outlet->id)
												{
													$selected = "selected";
												}
											}
											?>
											<option <?=$selected?> value="<?=$outlet->id?>"><?=$outlet->name?></option>
										<?php 
										}
								 }
										?>
									</select>
									<div id="outlet_error" style="color: #ff0033"></div>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Warehouse <span style="color: #F00">*</span></label>
									<select name="warehouse_tank" id="warehouse_tank" class="form-control">
										<option value="">Select Warehouse / Tank</option>
									</select>
									<div id="warehouse_tank_error" style="color: #ff0033;"></div>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>User <span style="color: #F00">*</span></label>
									<input name="user" class="form-control"  readonly value="<?=$LoginUser?>" type="text">
								</div>
							</div>
							
						</div>
						
						
						<div class="row" style="margin-top: 15px;">
							
					
							<div class="col-md-2">
								<div class="form-group">
									<label>Scan Barcode</label>
									<input  id="scan_barcode" class="form-control frontcal "  value="" placeholder="Scan Barcode" type="text">
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Search Suppliers</label>
									<select class="form-control" id="">
										<option value="" >Select Suppliers</option>
										<?php
										foreach ($getsuppliers as $supplier)
										{ ?>
										<option value="<?=$supplier->id?>"><?=$supplier->name?> </option>
										<?php }
									?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Search Product by Name or Code</label>
									<select class="form-control" id="product_name_code">
										<option value="" >Select Product by Name or Code</option>
									<?php
										foreach ($getAllProduct as $product)
										{ ?>
										<option value="<?=$product->code?>"><?=$product->name?> [<?=$product->code?>]</option>
										<?php }
									?>
									</select>
								</div>
							</div>

							<div class="col-md-1">
								<div class="form-group">
									<label>Balance Stock</label>
									<input id="balance_stock" class="form-control frontcal " readonly=""  value="0" type="text">
								</div>
							</div>

							<div class="col-md-1">
								<div class="form-group">
									<label>Price</label>
									<input id="product_price" class="form-control product_price frontcal "  value="0" type="text">
								</div>
							</div>

							<div class="col-md-1">
								<div class="form-group">
									<label>Qty</label>
									<input id="pcs" class="form-control pcs frontcal "  value="0" type="text">
								</div>
							</div>


							<div class="col-md-1">
								<div class="form-group">
									<label>Discount %</label>
									<input id="discount" class="form-control discount frontcal "  value="0" type="text">
								</div>
							</div>

							<div class="col-md-1">
								<div class="form-group">
									<label>Tax</label>
									<input  class="form-control tax frontcal" id="tax" readonly value="<?=!empty($totaltax)?$totaltax:0?>" type="text">
								</div>
							</div>

							<div class="col-md-1">
								<div class="form-group">
									<label>Amount</label>
									<input id="amount" class="form-control net_amount frontcal " readonly=""  value="0" type="text">
									<input id="discountamt" class="form-control discountamt frontcal " readonly=""  value="0" type="hidden">
									<input id="calculateTax" class="form-control calculateTax frontcal " readonly=""  value="0" type="hidden">
								</div>
							</div>


						</div>
						

						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<button style="width: 150px;background: #3fb617;border: none;" type="button" id="FrontSave" class="btn btn-primary">Save</button>
								</div>
							</div>
						</div>

					
						<div class="col-md-12"  style="margin-top: 20px;">
							<table class="table" id="items">
								<thead>
									<tr>
										<th width="10%">Code</th>
										<th width="10%">Products</th>
										<th width="10%">Balance Stock</th>
										<th width="10%">Price</th>
										<th width="10%">Qty</th>
										<th width="10%">Discount %</th>
										<th width="10%">Tax</th>
										<th width="10%">Sub Total</th>
										<th width="10%">Action</th>
									</tr>
								</thead>
								<tbody>

									<tr id="appendForntItem">
										<td colspan="7" style="text-align: right;"><div style="margin-top: 12px;"><label>Total</label></div></td>
										<td colspan="2">
											<input name="table_total_amount" type="text" style="width: 300px; font-size: 24px;color: #ff0033;" id="total_net" class="form-control" readonly="" value="0">
											<input name="total_discount_amount" type="hidden"  id="total_discount_amount"  value="0">
											<input name="total_discount_percent" type="hidden"  id="total_discount_percent"  value="0">
											<input name="total_item_qty" type="hidden" id="total_item_qty"  value="0">
											<input type="hidden" id="total_row"  value="<?=!empty($i) ? $i : 1?>">
										</td>
									</tr>
								</tbody>

							</table>
						</div>

						<!-- Product List // END -->
						</form>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group" style="text-align: left;">
									<button class="btn btn-primary SalesReturn" >
										Create Return Order
									</button>
								</div>
							</div>
						</div>



					</div><!-- Panel Body // END -->
				</div><!-- Panel Default // END -->

	

			</div><!-- Col md 12 // END -->
		</div><!-- Row // END -->
	

		<!--Sales-Return-Popup-->
	<div id="Sales_Return_Popup" class="modal fade"> 
		<div class="modal-dialog">
			<form method="post" id="formSalesReturn">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #5fc509;">
						<h3 class="modal-title" style="color: #FFF;">Sales Return</h3>
					</div>
					
					<div class="modal-body" style="overflow: visible; background-color: #FFF; border-radius: 12px;">
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Sales Return Ref No.</label>
										<input name="sales_return_ref" class="form-control" readonly="" value="<?=$getSalesReturnID?>" type="text">
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Date</label>
										<input name="sales_date" class="form-control"  readonly="" value="<?=date('Y-m-d H:i:s')?>" type="text">
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Customer</label>
										<select required=""  style="width: 100%"  class="payment_customer" name="sales_customer" >
											<?php
											foreach ($getCustomer as $customer)
											{ 
												$selecred = '';
												if(!empty($getDefaultCustomer))
												{
													if($getDefaultCustomer == $customer->id)
													{
														$selecred = "selected";
													}
												}
												?>
											<option <?=$selecred?> value="<?=$customer->id?>"><?=$customer->fullname?></option>
											<?php }
											?>
										</select>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Returned Qty</label>
										<input name="sales_returned_qty" id="SalesReturnedQty" required="" class="form-control"  value="" type="text">
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Ref Bill No.</label>
										<input name="sales_ref_bill_no" required="" class="form-control" value="" type="text">
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Refund Amount</label>
										<input id="SalesRefundAmount" name="sales_amount_refund_amount" required="" class="form-control"  value="" type="text">
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Refund Tax</label>
										<input name="sales_refund_tax" class="form-control"  value="" type="text">
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Payment Type</label>
										<select class="form-control ChangePayment" style="width: 100%;"    name="sales_payment_type">
										</select>
									</div>
								</div>
								
								<div class="col-md-4">
									<div class="form-group">
										<label>Refund Method</label>
										<select required="" name="sales_refund_method"  class="form-control"  style="width: 100%;">
											<option value="">Select Refund Method</option>
											<option value="0">Full Refund</option>
											<option value="1">Partial Refund</option>
										</select>
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-4">
									<div class="form-group">
										<label>Condition</label>
										<select required="" name="sales_condition" class="form-control"  style="width: 100%;">
											<option value="">Select Condition</option>
											<option value="0">Good</option>
											<option value="1">Not Good</option>
										</select>
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label>Reason</label>
										<textarea name="sales_reason" class="form-control"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer" style="text-align: right;">
						<button class="btn btn-primary" type="submit"  style="width:100px; background:#40b518; border: none;">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
		
	<div id="errornoitemsave" class="modal fade"> 
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" style="overflow: visible; background-color: #FFF; border-radius: 12px;">
					<div class="row">
						<div class="col-md-12" style="text-align: center; font-size: 25px; padding-top: 20px; padding-bottom: 20px; color: #090;">
							Please add barcode and qty after than save!!
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		
		
	<div id="errornoitem" class="modal fade"> 
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" style="overflow: visible; background-color: #FFF; border-radius: 12px;">
					<div class="row">
						<div class="col-md-12" style="text-align: center; font-size: 25px; padding-top: 20px; padding-bottom: 20px; color: #090;">
							Please add product first to make a payment!
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--End Sales-Return-Popup-->
		
		


</div><!-- Right Colmn // END -->


<?php
require_once 'includes/footer.php';
?>
<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/js/select2.min.js"></script>
<script>
	$('select').select2();
	
	$('#formSalesReturn').submit(function(e){
		e.preventDefault();
		
		var formData = new FormData();
		var submitalldata = $("#submitalldata").serializeArray();
		$.each(submitalldata, function (key, input) {
			formData.append(input.name, input.value);
		});
			
		var sales_return = $(this).serializeArray();
		$.each(sales_return, function (key, input) {
			formData.append(input.name, input.value);
		});
		
		$.ajax({
			type:'POST',
			url:"<?=base_url();?>Returnorder/SalesReturnInsert",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'JSON',
			success:function(data)
			{
				if(data.order_id)
				{
					alert('Sales Return Successfully Save!!');
					location.reload();
				}
			}
		});
	});
	
		$('.SalesReturn').click(function(){
			var total_net = $('#total_net').val();
			if(total_net != 0 && total_net != '')
			{
				$('#Sales_Return_Popup').modal('show');			
			}
			else
			{
				$('#errornoitem').modal('show');	
			}
		});

		
		$('.ChangeCustomer').change(function(){
			var customerid = $(this).val();
			$(".payment_customer").val(customerid).trigger("change");
		});
	
	
	$('.ChangePayment').change(function(){
			var paymenttype = $(this).val();
			if(paymenttype == 5)
			{
				$('#addi_card_numb').val('');
				$('#payment_gift_card').val('');
				$('.CardNumber').hide();
				$('.gift_card').hide();
				$('.CheckDetail').show();
			}
			else if(paymenttype == 3)
			{
				$('#payment_gift_card').val('');
				$('#cheque').val('');
				$('#bank').val('');
				$('#cheque_date').val('');
				$('.CheckDetail').hide();
				$('.gift_card').hide();
				$('.CardNumber').show();
			}
			else if(paymenttype == 7)
			{
				$('#addi_card_numb').val('');
				$('#cheque').val('');
				$('#bank').val('');
				$('#cheque_date').val('');
				$('.CheckDetail').hide();
				$('.CardNumber').hide();
				$('.gift_card').show();
			}
			else
			{
				$('#payment_gift_card').val('');
				$('#cheque').val('');
				$('#bank').val('');
				$('#cheque_date').val('');
				$('#addi_card_numb').val('');
				$('.CheckDetail').hide();
				$('.CardNumber').hide();
				$('.gift_card').hide();
			}
		});

		$('#outlet_id').change(function(){
			 outlet();
		});

		$('#warehouse_tank').change(function(){
				warehousegetdata();
		});


		function outlet()
		{
			$('#outlet_error').html('');
			$('#warehouse_tank_error').html('');
			var outlet_id = $('#outlet_id').val();
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Pos/getOutletWiseTankWarehouse",
				data: {outlet_id: outlet_id},
				dataType: 'JSON',
				success:function(data){
					$('#warehouse_tank').html(data.success);
					$('.ChangePayment').html(data.payment);
					warehousegetdata();
				}
			 });

		}
		outlet();

		function warehousegetdata()
		{
			var wareid = $('#warehouse_tank').val();
			var outlet_id = $('#outlet_id').val();
			var type = $('#warehouse_tank option:selected').attr('data-val');
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Pos/getOutletWiseWarehouseProduct",
				data: {wareid: wareid,outlet_id:outlet_id,type:type},
				dataType: 'JSON',
				success:function(data){
					$('#product_name_code').html(data.product);
					$('#product_price').val('0');
					$('#balance_stock').val('0');
					$('#scan_barcode').val('');
					$('#pcs').val('0');
				}
			 });

		}



		$('#scan_barcode').keyup(function(e){

			var outlet_id = $('#outlet_id').val();
			var warehouse_tank = $('#warehouse_tank').val();
			if(outlet_id == "")
			{ 
				if(e.keyCode !=119 &&  e.keyCode !=120 && e.keyCode !=115) 
				{
					$('#outlet_error').html('Please Select Outlet!!');
				}
			}
			else if(warehouse_tank == "")
			{
				$('#warehouse_tank_error').html('Please Select Warehouse/Tank!!');
			}
			else
			{
				$('#outlet_error').html('');
				$('#warehouse_tank_error').html('');
				var type = $('#warehouse_tank option:selected').attr('data-val');
				var product_code = $(this).val();
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>Pos/getProductDetailInventory",
					data: {product_code: product_code,outlet_id:outlet_id,warehouse_tank:warehouse_tank,type:type},
					dataType: 'JSON',
					success:function(data){
						$('#batch_no').val(data.batch_no);
						$('#product_price').val(data.product_price);
						$('#balance_stock').val(data.balance_stock);
						if(data.product_code != "")
						{
							$("#product_name_code").val(data.product_code).trigger("change");
						}
					}
			 });

			}

		});
		$('#product_name_code').change(function(){
			var outlet_id = $('#outlet_id').val();
			var warehouse_tank = $('#warehouse_tank').val();
			if(outlet_id == "")
			{
				$('#outlet_error').html('Please Select Outlet!!');
			}
			else if(warehouse_tank == "")
			{
				$('#warehouse_tank_error').html('Please Select Warehouse/Tank!!');
			}
			else
			{
				$('#outlet_error').html('');
				$('#warehouse_tank_error').html('');
				var type = $('#warehouse_tank option:selected').attr('data-val');
				var product_code = $(this).val();
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>Pos/getProductDetailInventory",
					data: {product_code: product_code,outlet_id:outlet_id,warehouse_tank:warehouse_tank,type:type},
					dataType: 'JSON',
					success:function(data){
						$('#batch_no').val(data.batch_no);
						$('#product_price').val(data.product_price);
						$('#balance_stock').val(data.balance_stock);
						$('#scan_barcode').val(data.product_code);
					}
			 });

			}

		});
		var item_row = $('#total_row').val();

		$('#FrontSave').click(function(){
			var product_code  = $('#scan_barcode').val();
			var product_name  = $('#product_name_code').val();
			var balance_stock = $('#balance_stock').val();
			var product_price = $('#product_price').val();
			var qty			  = $('#pcs').val();
			var discount	  = $('#discount').val();
			var discountamt	  = $('#discountamt').val();
			var calculateTax  = $('#calculateTax').val();
			var tax			  = $('#tax').val();
			var amount		  = $('#amount').val();
		
			var warehouse_tank = $('#warehouse_tank').val();
			var type		   = $('#warehouse_tank option:selected').attr('data-val');
			if(product_code != "" && product_price != 0 && qty != 0 && qty != ""  )
			{
				var html = '<tr class="dynamic_row">\n\
						<td>'+product_code+'<input name="item['+item_row+'][product_code]" type="hidden" class="form-control" value="'+product_code+'">\n\
							<input name="item['+item_row+'][warehouse]" type="hidden" class="form-control" value="'+warehouse_tank+'">\n\
							<input name="item['+item_row+'][type]" type="hidden" class="form-control" value="'+type+'"></td>\n\
						<td>'+product_name+'</td>\n\
						<td><input name="item['+item_row+'][balance_stock]" type="text" style="" readonly class="form-control dynamic_balance_stock" value="'+balance_stock+'"></td>\n\
						<td><input name="item['+item_row+'][product_price]" type="text" style="" readonly class="form-control dynamic_rate" value="'+product_price+'"></td>\n\
						<td><input id="finalQty'+item_row+'" name="item['+item_row+'][qty]" type="text" style="" class="form-control dynamic_pcs" value="'+qty+'"></td>\n\
						<td><input name="item['+item_row+'][discount]" type="text" style="" class="form-control dynamic_discount" value="'+discount+'">\n\
							<input name="item['+item_row+'][discountamt]" type="hidden" style="" class="form-control dynamic_discountamt" value="'+discountamt+'">\n\
							<input name="item['+item_row+'][calculateTax]" type="hidden" style="" class="form-control dynamic_calculateTax" value="'+calculateTax+'"></td>\n\
						<td><input name="item['+item_row+'][tax]" type="text" style="" readonly class="form-control dynamic_tax" value="'+tax+'"></td>\n\
						<td><input name="item['+item_row+'][sub_amount]" type="text" style="" readonly class="form-control dynamic_net_amount" value="'+amount+'"></td>\n\
						<td><a href="#" class="item_remove">Remove</a></td>\n\
					</tr>';
				$('#appendForntItem').before(html);

				$('#scan_barcode').val('');
				$('#product_name_code').val('');
				$('#balance_stock').val('0');
				$('#product_price').val('0');
				$('#pcs').val('0');
				$('#discount').val('0');
				$('#amount').val('0');
				$('#calculateTax').val('0');
				$('#discountamt').val('0');
				$('#batch_no').val('');
				dynamiccalamount();
				item_row++;
			}
			else
			{
				$('#errornoitemsave').modal('show');
			}
		});

		$(".table").delegate(".item_remove","click",function(e) {
			if (confirm("Are you sure want to delete?")) {
				e.preventDefault();
				$(this).parent().parent().remove();
				$("#total_net").val('0');
				$("#TotalPayableAmount").val('0');
				dynamiccalamount();
			}
			return false;
		});


		$(".table").delegate(".dynamic_row input, select", "keyup", function() {
			dynamiccalamount();
		});

		function dynamiccalamount()
		{
			var total_discount_amount = 0;
			var total_discount_percent = 0;
			var totalnetamount = 0;
			var total_item_qty = 0;
			$("#items").find('.dynamic_row').each(function (i) {
				var $fieldset = $(this);

				var dynamic_balance_stock   = ($('.dynamic_balance_stock', $fieldset).val());
				var dynamic_pcs				= ($('.dynamic_pcs', $fieldset).val());
				var dynamic_rate			= ($('.dynamic_rate', $fieldset).val());
				var dynamic_discount		= ($('.dynamic_discount', $fieldset).val());
				var dynamic_tax				= ($('.dynamic_tax', $fieldset).val());

				if(dynamic_pcs.trim()==''){
					dynamic_pcs=0;
					$('.dynamic_pcs', $fieldset).val('0');
				}

				if(dynamic_discount.trim()==''){
					dynamic_discount=0;
					$('.dynamic_discount', $fieldset).val('0');
				}

//				if(parseFloat(dynamic_pcs) > parseFloat(dynamic_balance_stock))
//				{
//					alert('Please Enter QTY below than Balance Stock!!');
//					$('.dynamic_pcs', $fieldset).val('1');
//					dynamic_pcs = 1;
//				}

				total_item_qty = parseFloat(total_item_qty) + parseFloat(dynamic_pcs);

				var grossamount = 0.00;
				var grossamount = parseFloat(dynamic_pcs*dynamic_rate).toFixed(2);
				var calculateTax = dynamic_tax / 100 * grossamount;
				grossamount = parseFloat(grossamount) + parseFloat(calculateTax);

				if (dynamic_discount.indexOf("%") >= 0) {
						total_discount_percent = parseFloat(total_discount_percent) + parseFloat(dynamic_discount);
						var dynamic_discount = dynamic_discount.substr(0, dynamic_discount.indexOf('%'));
						var discountamt = parseFloat((dynamic_discount/100)*grossamount).toFixed(2);
				}
				else
				{
					if(parseFloat(dynamic_discount)>parseFloat(grossamount))
					{
						var dynamic_discount = 0;
						$('.dynamic_discount', $fieldset).val(dynamic_discount);
						alert('Discount Amount must to less than Payable Amount!');
					}
					var discountamt = dynamic_discount;
				}


				var netamount   = parseFloat(grossamount-discountamt).toFixed(2);
				total_discount_amount = parseFloat(total_discount_amount) +parseFloat(discountamt);


				$('.dynamic_net_amount', $fieldset).val(netamount);
				$('.dynamic_discountamt', $fieldset).val(discountamt);

				totalnetamount = parseFloat(totalnetamount) + parseFloat(netamount);
				$("#total_net").val(parseFloat(totalnetamount).toFixed(2));
				$("#final_total_payable").val(parseFloat(totalnetamount).toFixed(2));
				$("#total_discount_amount").val(parseFloat(total_discount_amount).toFixed(2));
				$("#total_discount_percent").val(parseFloat(total_discount_percent).toFixed(2));
				$("#SalesRefundAmount").val(parseFloat(totalnetamount).toFixed(2));
				$("#total_item_qty").val(parseFloat(total_item_qty).toFixed(2));
				$("#SalesReturnedQty").val(parseFloat(total_item_qty).toFixed(2));
			});
		}

		dynamiccalamount();

		$("body").delegate(".frontcal", "keyup", function() {
			calamount();
		});

		function calamount()
		{
			var tax			= $('.tax').val();
			var pcs			= $('.pcs').val();
			var rate		= $('.product_price').val();
			var discount	= $('.discount').val();

			if(pcs.trim()==''){
				pcs=0;
				$('.pcs').val('0');
			}

			if(discount.trim()==''){
				discount=0;
				$('.discount').val('0');
			}
			var grossamount = 0.00;
			var grossamount = parseFloat(pcs*rate).toFixed(2);
			var calculateTax = tax / 100 * grossamount;
			grossamount		= parseFloat(grossamount) + parseFloat(calculateTax);





			if (discount.indexOf("%") >= 0) {
					var discount = discount.substr(0, discount.indexOf('%'));
					var discountamt = parseFloat((discount/100)*grossamount).toFixed(2);
					var netamount   = parseFloat(grossamount-discountamt).toFixed(2);
			}
			else
			{

				if(parseFloat(discount)>parseFloat(grossamount))
				{
					var discount = 0;
					$('.discount').val('0');
					alert('Discount Amount must to less than Payable Amount!');
				}
				var discountamt = discount;
				var netamount   = parseFloat(grossamount-discountamt).toFixed(2);
			}





			$('.net_amount').val(netamount);
			$('.discountamt').val(discountamt);
			$('.calculateTax').val(calculateTax);
		}

	
</script>


