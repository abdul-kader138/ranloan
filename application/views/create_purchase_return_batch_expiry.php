<?php
require_once 'includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Purchase Return</h1>
		</div>
	</div>
	
	<form id="FormPurchaseReturnSubmit" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Purchase Return Ref No.<span style="color: #F00">*</span></label>
									<input type="text" name="return_purchase_number" value="<?=$getmaxIdPurchaseReturn?>" class="form-control" readonly=""  autofocus />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Outlet <span style="color: #F00">*</span></label>
									<input type="text" readonly="" value="<?=$getOutlets->name?>" class="form-control">
									<input type="hidden" name="outlet"  value="<?=$getOutlets->id?>" class="form-control">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Warehouse</label>
									<input type="text" readonly="" value="<?=$store_tank?>" class="form-control">
									<input type="hidden" name="warehouse_tank"  value="<?=$ow_id?>" >
									<input type="hidden" name="type"  value="<?=$type?>" >
									<input type="hidden" name="batch_expiry_id"  value="<?=$batch_expiry_id?>" >
									
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Date<span style="color: #F00">*</span></label>
									<input required type="text" name="date" value="<?=date('Y-m-d H:i:s')?>" readonly class="form-control" />
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Returned QTY <span style="color: #F00">*</span></label>
									<input required type="text" name="returned_qty" value="<?=$qty?>" class="form-control" />
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Ref Bill No. <span style="color: #F00">*</span></label>
									<input required type="text" name="ref_bill_no" value="" class="form-control" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Supplier <span style="color: #F00">*</span></label>
									<input type="text" readonly="" value="<?=$getSuppliers->name?>" class="form-control">
									<input type="hidden" name="supplier_id"  value="<?=$getSuppliers->id?>" >
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Product <span style="color: #F00">*</span></label>
									<input type="text" name="product_code" readonly="" value="<?=$product_code?>" class="form-control">
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Refund Amount <span style="color: #F00">*</span></label>
									<input type="text" required name="refund_amount" value="" class="form-control" />
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group" >
									<label>Payment Type <span style="color: #F00">*</span></label>
									<select required=""  id="paid_by"  class="form-control ChangePayment" name="payment_type">
										<?php
											foreach ($getPaymentType as $payment)
											{
												if($payment->name == 'Cash' || $payment->name == 'Credit cards' || $payment->name == 'Cheque' || $payment->name == 'Vouchers' || $payment->name == 'Gift Card')
												{
												?>
												<option value="<?=$payment->id?>"><?=$payment->name?></option>
												<?php }
											}
											?>
									</select>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group" > 
									<label>Refund Tax </label>
									<input type="text" value="0" name="refund_tax" class="form-control">
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>User</label>
									<input type="text" readonly="" value="<?=$LoginUser?>" class="form-control">
								</div>
							</div>
						</div>
						
						<div class="row" style="padding-bottom: 10px;">
							<span class="CheckDetail" style="display: none;">
								<div class="col-md-4">
									<label>Cheque Number</label><br>
									<input type="text" tabindex="3"  class="form-control" id="cheque" name="cheque" placeholder="Cheque Number" autocomplete="off" />
								</div>
								<div class="col-md-4">
									<label>Bank</label>
									<input type="text"  id="bank" class="form-control" name="bank" autocomplete="off" />
								</div>
								<div class="col-md-4">
									<label>Cheque Date</label>
									<input type="text" id="cheque_date" name="cheque_date" class="form-control datepicker" />
								</div>
							</span>

							<span class="CardNumber" style="display: none;">
								<div class="col-md-4">
									<label>Card Number</label>
									<input type="text"  id="addi_card_numb" name="addi_card_numb" class="form-control" autocomplete="off" />
								</div>
							</span>
							
							<span class="Gift_Card" style="display: none;">
								<div class="col-md-4">
									<label>Gift Card</label>
									<input type="text"  id="Gift_Card" name="Gift_Card" class="form-control" autocomplete="off" />
								</div>
							</span>
							
							<span class="Voucher" style="display: none;">
								<div class="col-md-4">
									<label>Voucher</label>
									<input type="text"  id="Voucher" name="Voucher" class="form-control" autocomplete="off" />
								</div>
							</span>
							
						</div>
						
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label>Reason</label>
									<textarea name="reason" class="form-control"></textarea>
								</div>
							</div>
							
						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button id="sendBtn" class="btn btn-primary" type="submit">Create Purchase Return</button>
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>

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

<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/js/select2.min.js"></script>
<?php
require_once 'includes/footer.php';
?>
<script>
	$('#cheque_date').datepicker();
	$('select').select2();
	

	
	$('.ChangePayment').change(function(){
		var paymenttype = $('.ChangePayment option:selected').text();
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
	
	$('#FormPurchaseReturnSubmit').submit(function(e){
		e.preventDefault();
		var formData = new FormData();
		var contact = $(this).serializeArray();
		$.each(contact, function (key, input) {
			formData.append(input.name, input.value);
		});
		$.ajax({
			type:'POST',
			url:"<?=base_url();?>Purchase_order/Insert_Purchase_Return",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'JSON',
			success:function(data){
				alert('Purchase Retrun Save Successfully!!')
				window.location.href='<?=base_url()?>reports/product_batch_expiry';
			}
		});
	});
	
</script>




