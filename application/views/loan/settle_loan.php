<?php
   $app = realpath(APPPATH);
   require_once $app . '/views/includes/header.php';
?>
<style>
	label.error{
		color:red;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Settle Loans</h1>
      </div>
   </div>
	
   <div class="row">
      <div class="col-md-12">
		
         <div class="panel panel-default">
            <div class="panel-body">
				<form method="post" id="submitSettle">
					<div class="row">
					   <div class="col-md-2">
						  <div class="form-group">
							 <label>Date & Time</label>
							 <input type="text" name="date" class="form-control" value="<?=date('Y-m-d H:i:s')?>" readonly />
						  </div>
					   </div>
					   <div class="col-md-2">
						  <div class="form-group">
							 <label>Loan Settle Form No.</label>
							 <input type="text"  value="<?=$LoanFormNo?>" name="loan_settle_form_no" class="form-control"  readonly />
						  </div>
					   </div>
					    <div class="col-md-2">
						  <div class="form-group">
							 <label>Customer</label>
							 <select class="form-control" id="customer_focus"  name="customer_id">
								 <option value="">Select Customer</option>
								 <?php
								 foreach ($getCustomer as $customer)
								 { 
									 $selected = "";
									if(!empty($this->input->get('cus_id')))
									{
										if($this->input->get('cus_id') == $customer->id)
										{
											$selected = "selected";
										}
									}
									 ?>
								 <option <?=$selected?> value="<?=$customer->id?>"><?=$customer->fullname?></option>
							 <?php
								 }
								 ?>
							 </select>
						  </div>
					   </div>
					   <div class="col-md-2">
						  <div class="form-group">
							 <label>Current Outstanding</label>
							 <input type="text" id="current_outstanding" value="<?=!empty($current_outstanding->outstanding)?$current_outstanding->outstanding:'0'?>" name="current_outstanding"  class="form-control"  readonly />
						  </div>
					   </div>
					   <div class="col-md-2">
						  <div class="form-group">
							 <label>Settle  Amount</label>
							 <input type="text"  value=""  name="settle_amount" class="form-control"  />
						  </div>
					   </div>
					   <div class="col-md-2">
						  <div class="form-group">
							 <label>Outlet</label>
							 <select class="form-control"  name="outlet_id">
								 <?php
								 foreach ($getOutlet as $outlet)
								 { ?>
									 <option value="<?=$outlet->id?>"><?=$outlet->name?></option>
							 <?php
								 }
								 ?>
							 </select>
						  </div>
					   </div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
							   <label>Receive Account</label>
							   <select name="receive_account" class="form-control">
								   <option value="">Select Receive Account</option>
								   <?php
									foreach ($getPaymentMethod as $payment)
									{ ?>
										<option value="<?=$payment->id?>"><?=$payment->name?></option>
								<?php }
								   ?>
							   </select>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
							   <label>Note</label>
							   <textarea class="form-control" name="note"></textarea>
							</div>
						</div>

						<div class="col-md-4">
						   <div class="form-group">
							  <label>Created By</label>
							  <input type="text" id="created_by" value="<?=!empty($UserLoginName)?$UserLoginName:''?>" name="created_by" class="form-control"  readonly />
						   </div>
						</div>
				   </div>
					<div class="row">
					   <div class="col-md-12">
						  <div class="form-group">
							  <button style="width: 150px;" id="sendBtn" type="submit" class="btn btn-primary" type="button" >Save</button>
						  </div>
					   </div>
					</div>
				</form>
			</div>
		</div>
      </div>
   </div>
</div>
<!--end payment method-->
<?php
   $app = realpath(APPPATH);
   require_once $app . '/views/includes/footer.php';
?>
	<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script>
	$('document').ready(function(){
		
		
		
		$("#submitSettle").validate({
			rules: {
				customer_id:"required",
				settle_amount: {
					required: true,
					number: true,
				},
				outlet_id:"required",
				receive_account:"required",
			},
			messages: {
				customer_id: "Please enter your customer name",
				settle_amount:{
					required: "Please provide a settle amount ",
					number: "Please provide a Numeric value",
				},
				outlet_id: "Please enter your outlet name",
				receive_account: "Please enter your receive account",
				
			},
			submitHandler: function(form) {
				var formData = new FormData();
				var submitLoan = $(form).serializeArray();
				$.each(submitLoan, function (key, input) {
					formData.append(input.name, input.value);
				});
				$('#sendBtn').addClass('disabled');
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>Loan/submitSettle",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'JSON',
					success:function(data){
						if(data.success == 0)
						{
							$('#sendBtn').removeClass('disabled');
							alert('Loan amount greater than your account!!');
						}
						else
						{
							window.location.href="<?=base_url();?>loan/loan_list";
						}
					}
				});
				
			}
		});

		
		
		
		
		
		
		
		
		
		
//		$('#submitSettle').submit(function(event){
//				event.preventDefault();
//				
//				var formData = new FormData();
//				var submitLoan = $(this).serializeArray();
//				$.each(submitLoan, function (key, input) {
//					formData.append(input.name, input.value);
//				});
//				$('#sendBtn').addClass('disabled');
//				$.ajax({
//					type:'POST',
//					url:"<?=base_url();?>Loan/submitSettle",
//					data: formData,
//					cache: false,
//					contentType: false,
//					processData: false,
//					dataType: 'JSON',
//					success:function(data){
//						if(data.success == 0)
//						{
//							$('#sendBtn').removeClass('disabled');
//							alert('Loan amount greater than your account!!');
//						}
//						else
//						{
//							window.location.href="<?=base_url();?>loan/loan_list";
//						}
//					}
//				});
//		});
//		
		
		$('#customer_focus').change(function(){
			var customerid = $(this).val();
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>loan/findOutstanding",
				data: {customerid: customerid},
				dataType: 'JSON',
				success:function(data){
					$('#current_outstanding').val(data.amount);
				}
			 });
		});	
	});
</script>
