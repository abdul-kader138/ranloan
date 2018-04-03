<?php
    require_once 'includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Make Payment for Sales Id : <?php echo $id; ?></h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				
				<div class="panel-body">
					<form method="post" id="paymentSubmit">
					<div class="col-md-1"></div>
					<div class="col-md-10">
							<div class="row">
								<div class="col-md-6"><h4>Customer: <span style="background-color: #FFFF99;"><?=$result_payment->customer_name?></span> </h4>
									<input name="orderid" type="hidden" value="<?=$result_payment->id?>"  id="orderid" />
									<input name="customer_id" type="hidden" value="<?=$result_payment->customer_id?>" id="customerid"  />
									<input name="customer_name" type="hidden" value="<?=$result_payment->customer_name?>" id="customer_name" />
									<input name="outlet_id" type="hidden" value="<?=$result_payment->outlet_id?>" id="outletid" />
									<input name="outlet_name" type="hidden" value="<?=$result_payment->outlet_name?>" id="outletname" />
								</div>
								<div class="col-md-6" style="text-align: right;"><h4>Total Payable Amount: <span style="background-color: #FFFF99;"><?=number_format($result_payment->unpaid_amt)?></span></h4></div>
							</div>
							<hr />
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-4">
										<div class="form-group">
										   <label>Select Payment Type</label><br>
										   <select  id="paid_by" class="form-control ChangePayment">
											   <option value="">Select Payment Method</option>
											   <?php
											   foreach ($getPaymentMethod as $payment)
											   { 
												   if($payment->name == "Cash" || $payment->name == "Cheque" || $payment->name == 'Credit cards' )
												   {
												   ?>
													<option data-val="<?=$payment->name?>" value="<?=$payment->id?>"><?=$payment->name?></option>
											  <?php }
											   }
											   ?>
										   </select>
										   <span id="errorPayment" style="color: #cc0033;"></span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Amount</label><br>
											<input type="text" value="" placeholder="0.00" class="form-control ChangeAmount">
											<span id="errorAmount" style="color: #cc0033;"></span>
										</div>
									</div>
									<div class="col-md-4">
										 <div class="form-group">
											 <label>&nbsp;</label><br>
											 <button class="btn btn-primary" type="button" id="AddPayment">Add Payment</button>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<span class="CheckDetail" style="display: none">
										<div class="col-md-3">
											<label>Cheque Number :</label><br>
											<input type="text" tabindex="3"  class="form-control" id="cheque" placeholder="Cheque Number" autocomplete="off" />
										</div>
										<div class="col-md-3">
											<label>Bank :</label>
											<!--<input type="text"  id="bank" class="form-control" autocomplete="off" />-->
											<select name="bank" id="bank"  class="form-control">
												<option value="">Select Bank</option>
												<?php
												foreach ($bank_account as $bank)
												{ ?>
												<option value="<?=$bank->account_number?>"><?=$bank->account_number?> (Account Number)</option>
												<?php } ?> 
											</select>
											
										</div>

										<div class="col-md-3">
											<label>Cheque Date :</label>
											<input type="text" id="cheque_date"  class="form-control datepicker" />
										</div>
									</span>
									
									<span class="CardNumber" style="display: none">
										<div class="col-md-3">
											<label>Card Number :</label>
											<input type="text"  id="addi_card_numb" class="form-control" autocomplete="off" />
										</div>
									</span>
									
								</div>
							</div>
							
							<br />
								<div class="row">
								<div class="col-md-12">
									<table class="table">
										<thead>
											<tr>
												<th>Payment Method</th>
												<th>Customer</th>
												<th>Amount</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="addPaymentMethod">
										</tbody>
										<thead>
											<tr>
												<th></th>
												<th>Total Amount</th>
												<th>
													<input class="form-control" id="customer_total_amount" style="width: 100px;" name="total_amount" value="0" readonly="readonly" type="text">
												</th>
												<th></th>
											</tr>
										</thead>
									</table>
								</div>
								<div class="col-md-12" style="padding-bottom: 10px;">
									<div class="col-md-2">
										<b>Total Amount:</b>
									</div>
									<div class="col-md-2">
										<input type="text" name="grand_amount" readonly="" id="totalamount1" value="<?=$result_payment->unpaid_amt?>" class="form-control" />
									</div>
								</div>
								
								<div class="col-md-12"  style="padding-bottom: 10px;">
									<div class="col-md-2">
										<b>Total Paid:</b>
									</div>
									<div class="col-md-2">
										<input type="text" value="0"  readonly="" class="form-control tpaid" />
									</div>
								</div>
								<div class="col-md-12" style="padding-bottom: 10px;">
									<div class="col-md-2">
										<b>Balance:</b>
									</div>
									<div class="col-md-2">
										<input type="text" readonly="" value="<?=$result_payment->unpaid_amt?>" class="form-control BalanceAmount" />
										<input type="hidden" id="returned_change" name="returned_change" value="0" />
										<input type="hidden" id="row_column"  value="0" />
									</div>
								</div>
							</div>
							<hr />
							<div class="col-md-12">
									<div class="col-md-4">
										<div class="form-group">
										   <label>Created By</label><br>
										   <input type="text" value="<?=!empty($UserLoginName)?$UserLoginName:''?>" readonly="" class="form-control" />
										</div>
									</div>
								<div class="col-md-8" style="text-align: right;">
									 <div class="form-group">
										 <label>&nbsp;</label><br>
										 <button  type="button" id="submitdata" class="btn btn-primary">Submit</button>
									</div>
								</div>
							</div>
								
						</div>
					<div class="col-md-1"></div>
					</form>
				</div>
			</div>
			
			<a href="<?=base_url()?>debit/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
		</div>
	</div>
	<br /><br /><br /><br /><br />
</div>

		<div class="message-box animated fadeIn debit_make_popup" data-sound="alert" id="mb-signout">
			<div class="mb-container">
				<div class="mb-middle">
					<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
					<div class="mb-content">
						<p>Are you sure you want to Remove?</p>                    
						<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
						<input type="hidden" id="remove_debit_make_id" >
						<input type="hidden" id="remove_debit_make_amt" >
					</div>
					<div class="mb-footer">
						<div class="pull-right">
							<a id="debit_make_remove_row" class="btn btn-success btn-lg debit_make_remove_row" data-dismiss="modal">Yes</a>
							<button class="btn btn-default btn-lg mb-control-close" >No</button>
						</div>
					</div>
				</div>
			</div>
		</div>


<?php
    require_once 'includes/footer.php';
?>
  
<script>

	function deletedivpay(ele) {
		var removevalue = ele;
		var total_paid = $('.tpaid').val();
		var totalamount = parseFloat($('#totalamount1').val());
		var newtotal = total_paid - removevalue;
		$("#customer_total_amount").val(newtotal);
		var a = $(".tpaid").val(newtotal);
		var aa = $(".tpaid").val();
		var b = totalamount - aa;
		$('.BalanceAmount').val(b.toLocaleString());
		var tpaid = $('.tpaid').val();
		if (parseFloat(totalamount) >= parseFloat(tpaid))
		{
			if(tpaid == 0)
			{
//				$("#submitdata").hide();
			}
			else
			{
//				$("#submitdata").show();
			}
		} 
		else 
		{
//			$("#submitdata").hide();
		}
	}
	
	
	$('document').ready(function(){
		$('#cheque_date').datepicker();
		
		$('#submitdata').click(function(event){
			var tpaid = $('.tpaid').val();
			event.preventDefault();
			var formData = new FormData();
			var contact = $('#paymentSubmit').serializeArray();
			$.each(contact, function (key, input) {
				formData.append(input.name, input.value);
			});
			
			if(tpaid == 0 || tpaid == "")
			{
				alert('Total Paid amount is zero(0)!!');
			}
			else
			{
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>Debit/Payment_Submit",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'JSON',
					success:function(data){
						if(data.status == 1)
						{
							alert(data.message);
							window.location.href='<?=base_url()?>debit/view';
						}
						else
						{
							alert(data.message);
						}
					}
				});
			}
		});
		
		
		
		$("#addPaymentMethod").on('click', '#btndelete', function () {
			var id  = $(this).attr('data-id');
			var amt = $(this).attr('data-amt');
			$('#remove_debit_make_id').val(id);
			$('#remove_debit_make_amt').val(amt);
			$('.debit_make_popup').modal('show');
		//			$(this).closest('tr').remove();
		});
		
		$('.debit_make_remove_row').click(function(){
			var id = $('#remove_debit_make_id').val();
			var amt = $('#remove_debit_make_amt').val();
			deletedivpay(amt)
			$('.removemake'+id).remove();
		});
		
		
		
		
		
		$('.ChangeAmount').keyup(function(){
			var total_paid = $(this).val();
			if (total_paid == 0 || total_paid == '' ) {
				total_paid = 0;
			}
			$('#returned_change').val(parseFloat(total_paid).toFixed(2));
			var balance1 = parseFloat($('#totalamount1').val()) - parseFloat($('.tpaid').val());
			var balance = parseFloat(balance1) - parseFloat(total_paid);
			var balance = parseFloat(balance).toFixed(2);
			$('.BalanceAmount').val(balance);

		});
			
		
		$('.ChangePayment').change(function(){
			
			var paymenttype = $(".ChangePayment option:selected").text();
			
			if(paymenttype == 'Cheque')
			{
				$('#addi_card_numb').val('');
				$('.CardNumber').hide();
				$('.CheckDetail').show();
			}
			else if(paymenttype == 'Credit cards')
			{
				$('#cheque').val('');
				$('#bank').val('');
				$('#cheque_date').val('');
				$('.CheckDetail').hide();
				$('.CardNumber').show();
			}
			else
			{
				$('#cheque').val('');
				$('#bank').val('');
				$('#cheque_date').val('');
				$('#addi_card_numb').val('');
				$('.CheckDetail').hide();
				$('.CardNumber').hide();
			}
		});
			
			
	
			
			
		$('#AddPayment').click(function(){
			var paid_by = $('#paid_by').val();
			var amount = $('.ChangeAmount').val();
			if(paid_by == "")
			{
				$('#errorPayment').html('Please select payment type!!');
			}
			else if(amount == 0 || amount == "")
			{
				$('#errorPayment').html('');
				$('#errorAmount').html('Please Enter Amount!!');
			}
			else
			{
				
				
			var row_column = $('#row_column').val();
			var customer_total_amount = $('#customer_total_amount').val();
			var payname			= $('#paid_by option:selected').attr('data-val');
			var Gift_card_numb	= $('#Gift_card_numb').val();
			var cheque			= $('#cheque').val();
			var bank			= $('#bank').val();
			var cheque_date		= $('#cheque_date').val();
			var addi_card_numb	= $('#addi_card_numb').val();
			var customer_name	= $('#customer_name').val();
			var finaltotal = parseFloat(customer_total_amount) + parseFloat(amount);
			$('#customer_total_amount').val(finaltotal);
			$('.tpaid').val(finaltotal);
			
			
					var cell = $('<tr id="" class="removemake'+row_column+'"><td><label>'+payname+'</label> <input type="hidden" value="' + paid_by +
										'" name="payment['+row_column+'][paid_by]" /> <input type="hidden" value="' + cheque +
										'" name="payment['+row_column+'][cheque]"  /> <input type="hidden" value="' + addi_card_numb +
										'" name="payment['+row_column+'][addi_card_numb]"  /> <input type="hidden" value="' + bank +
										'" name="payment['+row_column+'][bank]"  /> <input type="hidden" value="' + cheque_date +
										'" name="payment['+row_column+'][cheque_date]"   />  </td><td><label>' + customer_name + '</label><input type="hidden" readonly value="' + customer_name +
										'" name="payment['+row_column+'][customer]"  > </td><td><input class="form-control" style="width: 100px;" type="text" readonly value="' + amount +
										'" name="payment['+row_column+'][paid]" ></td><td><i class="glyphicon glyphicon-remove-sign" id="btndelete" data-id="'+row_column+'" data-amt="'+amount+'"  style="color: red; cursor: pointer; font-size: 28px;"></i></td></tr>');
					$('#addPaymentMethod').append(cell);
					
				row_column++;
				$('#row_column').val(row_column);
				var totalamount1 = $('#totalamount1').val();
				var tpaid = $('.tpaid').val();
				$('.ChangeAmount').val('0');
				$('#paid_by').val('');
				if(parseFloat(totalamount1) >= parseFloat((tpaid)))
				{
//					$('#submitdata').show();	
				}
				else
				{
//					$('#submitdata').hide();
				}
			}
			
			
		});
		
	

	});
</script>