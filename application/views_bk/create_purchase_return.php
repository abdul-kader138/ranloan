<?php
require_once 'includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Purchase Return</h1>
		</div>
	</div>
	
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<form id="FormPurchaseReturnSubmit" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label>Purchase Return Ref No.<span style="color: #F00">*</span></label>
										<input type="text" name="return_purchase_number" value="<?=$getmaxIdPurchaseReturn?>" class="form-control" readonly=""  autofocus />
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Date<span style="color: #F00">*</span></label>
										<input required type="text" name="date" value="<?=date('Y-m-d H:i:s')?>" readonly class="form-control" />
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
									<?php }
									 else 
										{
										?>
										<select  required name="outlet" id="outlet_id" class="form-control" >
											<?php
											foreach($getOutlets as $outlet)
											{ ?>
												<option value="<?=$outlet->id?>"><?=$outlet->name?></option>
											<?php 
											}
										}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Warehouse</label>
										<select required name="warehouse_tank" id="warehouse_tank" class="form-control">
											<option value="">Select Warehouse / Tank</option>
										</select>
										<div id="warehouse_tank_error" style="color: #ff0033;"></div>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Returned QTY <span style="color: #F00">*</span></label>
										<input required type="text" id="returned_qty" name="returned_qty" value="" class="form-control" />
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Ref Bill No. <span style="color: #F00">*</span></label>
										<input required type="text" id="ref_bill_no" name="ref_bill_no" value="" class="form-control" />
									</div>
								</div>
								
							</div>
							
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label>Supplier <span style="color: #F00">*</span></label>
										<select  required class="form-control" id="supplier_id" name="supplier_id">
											<option value="">Select Supplier</option>
											<?php
											foreach ($getSuppliers as $supplier)
											{ ?>
												<option value="<?=$supplier->id?>"><?=$supplier->name?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Product <span style="color: #F00">*</span></label>
										<select required class="form-control" name="product_code" id="product_code">
											<option value="">Select Product</option>
										</select>
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<label>Refund Amount <span style="color: #F00">*</span></label>
										<input type="text" required name="refund_amount" id="refund_amount" value="" class="form-control" />
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group" >
										<label>Payment Type <span style="color: #F00">*</span></label>
										<select required=""  id="paid_by"  class="form-control ChangePayment" name="payment_type">
											<option value="">Select Payment Method</option>
										</select>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group" > 
										<label>Refund Tax </label>
										<input type="text" id="refund_tax" value="0" name="refund_tax" class="form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>User</label>
										<input type="text" readonly="" value="<?=$LoginUser?>" class="form-control">
									</div>
								</div>
								
							</div>
							<div class="row">
								

								

								
							</div>

							<div class="row" style="padding-bottom: 10px;">
								<span class="CheckDetail" style="display: none;">
									<div class="col-md-2">
										<label>Cheque Number</label><br>
										<input type="text" tabindex="3"  class="form-control" id="cheque" name="cheque" placeholder="Cheque Number" autocomplete="off" />
									</div>
									<div class="col-md-2">
										<label>Bank</label>
										<input type="text"  id="bank" class="form-control" name="bank" autocomplete="off" />
									</div>
									<div class="col-md-2">
										<label>Cheque Date</label>
										<input type="text" id="cheque_date" name="cheque_date" class="form-control datepicker" />
									</div>
								</span>

								<span class="CardNumber" style="display: none;">
									<div class="col-md-2">
										<label>Card Number</label>
										<input type="text"  id="addi_card_numb" name="addi_card_numb" class="form-control" autocomplete="off" />
									</div>
								</span>

								<span class="Gift_Card" style="display: none;">
									<div class="col-md-2">
										<label>Gift Card</label>
										<input type="text"  id="Gift_Card" name="Gift_Card" class="form-control" autocomplete="off" />
									</div>
								</span>

								<span class="Voucher" style="display: none;">
									<div class="col-md-2">
										<label>Voucher</label>
										<input type="text"  id="Voucher" name="Voucher" class="form-control" autocomplete="off" />
									</div>
								</span>

							</div>

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Reason</label>
										<textarea name="reason" id="reason" class="form-control"></textarea>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group" style="margin-top: 50px;">
										<button type="submit" class="btn btn-primary addItem" style="width: 100px;">Add</button>
									</div>
								</div>
							</div>
						</form>
						
					<form id="ReturnSubmit" method="post" enctype="multipart/form-data">	
						<div class="row" >
							<div class="col-md-12">
								<table class="table">
									<thead>
										<tr>
											<th>Product Code</th>
											<th>Payment Type</th>
											<th>Supplier</th>
											<th>Outlet</th>
											<th>Warehouse</th>
											<th>Ref Bill No.</th>
											<th>Return Qty</th>
											<th>Refund Tax</th>
											<th width="13%">Refund Amount</th>
											<th width="2%">Action</th>
										</tr>
									</thead>
									<tbody id="appendItem">
									</tbody>
									<tfoot>
										<tr>
											<td colspan="8" style="text-align: right;">
												<div style="padding-top: 10px;"><b>Total</b></div>
											</td>
											<td colspan="2"><input type="text" readonly="" id="subtotal" name="subtotal" value="0" class="form-control"></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
						
						<div class="row" style="margin-top: 20px;">
							<div class="col-md-4">
								<div class="form-group">
									<button id="sendBtn" class="btn btn-primary" type="submit">Create Purchase Return</button>
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>
					</form>
					</div>
				</div>
				
				<a href="<?= base_url() ?>purchase_order/purchase_return" style="text-decoration: none;">
					<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
						<i class="icono-caretLeft" style="color: #FFF;"></i>Back
					</div>
				</a>

			</div>
		</div>
	</form>
	
	<br /><br /><br /><br /><br />
</div>
<div class="message-box animated fadeIn create_return_remove_popup" data-sound="alert" id="mb-signout">
	<div class="mb-container">
		<div class="mb-middle">
			<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
			<div class="mb-content">
				<p>Are you sure you want to Remove?</p>                    
				<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
				<input type="hidden" id="retunremove_data" class="retunremove_data">
				<input type="hidden" id="amount_val" class="amount_val">
				
			</div>
			<div class="mb-footer">
				<div class="pull-right">
					<a id="remove_row" class="btn btn-success btn-lg remove_row_create_remov" data-dismiss="modal">Yes</a>
					<button class="btn btn-default btn-lg mb-control-close" >No</button>
				</div>
			</div>
		</div>
	</div>
</div>
<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/js/select2.min.js"></script>
<?php
require_once 'includes/footer.php';
?>
<script>
	
	$('#cheque_date').datepicker();
	$('select').select2();
	
	var row_item = 1;
	
	$('#FormPurchaseReturnSubmit').submit(function(e){
		e.preventDefault();
			var outlet_id		= $('#outlet_id').val();
			var warehouse_tank	= $('#warehouse_tank').val();
			var returned_qty	= $('#returned_qty').val();
			var ref_bill_no		= $('#ref_bill_no').val();
			var product_code	= $('#product_code').val();
			var refund_amount	= $('#refund_amount').val();
			var refund_tax		= $('#refund_tax').val();
			var paid_by			= $('#paid_by').val();
			var addi_card_numb	= $('#addi_card_numb').val();
			var cheque			= $('#cheque').val();
			var cheque_date		= $('#cheque_date').val();
			var Gift_Card		= $('#Gift_Card').val();
			var Voucher			= $('#Voucher').val();
			var bank			= $('#bank').val();
			var supplier_id		= $('#supplier_id').val();
			var reason			= $('#reason').val();
			
			

		var outlet_text			= $("#outlet_id option:selected").text();
		var warehouse_tank_text = $("#warehouse_tank option:selected").text();
		var type				= $("#warehouse_tank option:selected").attr('data-val');
		var paid_by_text		= $("#paid_by option:selected").text();
		var supplier_id_text		= $("#supplier_id option:selected").text();
			
		var html = '<tr id="RemoveData'+row_item+'">\n\
				<td>'+product_code+'\
					<input type="hidden" name="return['+row_item+'][addi_card_numb]" value="'+addi_card_numb+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][cheque]"		 value="'+cheque+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][cheque_date]"	 value="'+cheque_date+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][Gift_Card]"		 value="'+Gift_Card+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][Voucher]"        value="'+Voucher+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][paid_by]"		 value="'+paid_by+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][outlet_id]"		 value="'+outlet_id+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][warehouse_tank]" value="'+warehouse_tank+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][type]"			 value="'+type+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][supplier_id]"	 value="'+supplier_id+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][reason]"		 value="'+reason+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][product_code]"	 value="'+product_code+'" class="form-control">\n\
					<input type="hidden" name="return['+row_item+'][bank]"			 value="'+bank+'" class="form-control">\n\
				</td>\n\
				<td>'+paid_by_text+'</td>\n\
				<td>'+supplier_id_text+'</td>\n\
				<td>'+outlet_text+'</td>\n\
				<td>'+warehouse_tank_text+'</td>\n\
				<td><input type="text" readonly name="return['+row_item+'][ref_bill_no]" value="'+ref_bill_no+'" class="form-control"></td>\n\
				<td><input type="text" readonly name="return['+row_item+'][returned_qty]" value="'+returned_qty+'" class="form-control"></td>\n\
				<td><input type="text" readonly name="return['+row_item+'][refund_tax]" value="'+refund_tax+'" class="form-control"></td>\n\
				<td><input type="text" readonly name="return['+row_item+'][refund_amount]" value="'+refund_amount+'" class="form-control"></td>\n\
				<td><span style="cursor:pointer" data-val="'+refund_amount+'" class="removeItem create_return_popup_remove" id="'+row_item+'" ><i class="glyphicon glyphicon-remove-sign "  style="color: red; cursor: pointer; font-size: 28px;"></i></span></td>\n\
		</tr>';
						
		$('#appendItem').prepend(html);
		var subtotal = $('#subtotal').val();
		var finaltotal = parseFloat(subtotal) + parseFloat(refund_amount);
		$('#subtotal').val(finaltotal);
		
		$('#returned_qty').val('');
		$('#ref_bill_no').val('');
		$('#refund_amount').val('');
		$('#refund_tax').val('0');
		$('#addi_card_numb').val('');
		$('#cheque').val('');
		$('#cheque_date').val('');
		$('#Gift_Card').val('');
		$('#Voucher').val('');
		
		 $("#supplier_id").select2().val("").trigger("change");
		
		$('.CheckDetail').hide();
		$('.CardNumber').hide();
		$('.Gift_Card').hide();
		$('.Voucher').hide();
			
		row_item++;	
		outlet();
	});
	
	
	
		$(".table").delegate(".create_return_popup_remove", "click", function(){
			var id = $(this).attr('id'); 
			var amount = $(this).attr('data-val');
			$('.retunremove_data').val(id);
			$('.amount_val').val(amount);
			$('.create_return_remove_popup').modal('show');
		});
		
		$(".remove_row_create_remov").click(function () {
			var id = $('.retunremove_data').val();
			var amount = $('.amount_val').val();
			var subtotal = $('#subtotal').val();
			var finaltotal = parseFloat(subtotal) - parseFloat(amount);
			$('#subtotal').val(finaltotal);
			$("#RemoveData"+id).remove();
		});
//	$('.table').delegate('.removeItem','click',function(){
//		if (confirm("Are you sure you want to delete?")) {
//			var id = $(this).attr('id');
//			var amount = $(this).attr('data-val');
//			var subtotal = $('#subtotal').val();
//			var finaltotal = parseFloat(subtotal) - parseFloat(amount);
//			$('#subtotal').val(finaltotal);
//
//			$('#RemoveData'+id).html('');
//		}
//		return false;
//	});
	
	
	function outlet()
	{
		var outlet_id = $('#outlet_id').val();
		$.ajax({
			type:'POST',
			url:"<?=base_url();?>Purchase_order/getOutletWiseTankWarehouse",
			data: {outlet_id: outlet_id},
			dataType: 'JSON',
			success:function(data){
				$('#warehouse_tank').html(data.success);
				$('#product_code').html(data.product);
				$('#paid_by').html(data.payment);
				warehouse_tank();
			}
		 });
	}
	outlet();
	
	$('#warehouse_tank').change(function(){
		warehouse_tank();
		
	});
	
	function warehouse_tank()
	{
		var outlet_id       = $('#outlet_id').val();
		var warehouse_tank	= $('#warehouse_tank').val();
		var type			= $('#warehouse_tank option:selected').attr('data-val');
		$.ajax({
			type:'POST',
			url:"<?=base_url();?>Purchase_order/getOutletWiseTankWarehouseProduct",
			data: {outlet_id: outlet_id,warehouse_tank:warehouse_tank,type:type},
			dataType: 'JSON',
			success:function(data){
				$('#product_code').html(data.product);
			}
		 });
	}
	warehouse_tank();
	
	
	
	
	$('#outlet_id').change(function(){
		 outlet();
	});
	
	$('.ChangePayment').change(function(){
		var paymenttype = $(".ChangePayment option:selected").text();
		if(paymenttype == 'Cheque')
		{
			$('#addi_card_numb').val('');
			$('#Gift_Card').val('');
			$('#Voucher').val('');
			$('.CardNumber').hide();
			$('.Gift_Card').hide();
			$('.Voucher').hide();
			$('.CheckDetail').show();
			
		}
		else if(paymenttype == 'Credit cards')
		{
			$('#cheque').val('');
			$('#bank').val('');
			$('#Voucher').val('');
			$('#cheque_date').val('');
			$('#Gift_Card').val('');
			$('.CheckDetail').hide();
			$('.Gift_Card').hide();
			$('.Voucher').hide();
			$('.CardNumber').show();
		}
		else if(paymenttype == 'Gift Card')
		{
			$('#cheque').val('');
			$('#bank').val('');
			$('#cheque_date').val('');
			$('#addi_card_numb').val('');
			$('#Voucher').val('');
			$('.CheckDetail').hide();
			$('.CardNumber').hide();
			$('.Voucher').hide();
			$('.Gift_Card').show();
		}
		else if(paymenttype == 'Vouchers')
		{
			$('#cheque').val('');
			$('#bank').val('');
			$('#cheque_date').val('');
			$('#addi_card_numb').val('');
			$('#Gift_Card').val('');
			$('.CheckDetail').hide();
			$('.CardNumber').hide();
			$('.Gift_Card').hide();
			$('.Voucher').show();
		}
		else
		{
			$('#Gift_Card').val('');
			$('#cheque').val('');
			$('#bank').val('');
			$('#cheque_date').val('');
			$('#addi_card_numb').val('');
			$('#Voucher').val('');
			$('.CheckDetail').hide();
			$('.CardNumber').hide();
			$('.Gift_Card').hide();
			$('.Voucher').hide();
		}
	});
			
			
	


	$('#ReturnSubmit').submit(function(e){
		e.preventDefault();
		var subtotal = $('#subtotal').val();
		if(subtotal == 0 || subtotal ==  "")
		{
			alert("Please add at least one item!!");
		}
		else
		{
			var formData = new FormData();
			var contact = $(this).serializeArray();
			$.each(contact, function (key, input) {
				formData.append(input.name, input.value);
			});

			var type = $('#warehouse_tank option:selected').attr('data-val');
			formData.append('type', type);

			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Purchase_order/Insert_Return_multiple",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				success:function(data){
					window.location.href='<?=base_url()?>purchase_order/purchase_return';
				}
			});
		}
		
		
	});
	

</script>




