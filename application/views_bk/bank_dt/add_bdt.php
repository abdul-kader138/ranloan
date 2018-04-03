<style>
	label.error{
		color:red;
	}
</style>
<script>
    $(function () {
        $("#startDate").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });

        $("#endDate").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });

        $("#transfer_date").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });

        $('.paymethod').on('change', function () {
			var paymentmethod = $("input[name='payemtmethod']:checked").val();
			if(paymentmethod == "0")
			{
				var bank_form1 = $('#bank_from1').val();
			}
			else if(paymentmethod == "1")
			{
				var bank_form1 = $('#bank_from_m').val();
			}
            
            $.ajax({
                url: '<?= base_url() ?>Bank_dt/showBalancee?id=' + bank_form1 + '&paymentmethod='+paymentmethod+'&outlet_id=' + $('#outlet_id').val(),
                type: 'GET',
                cache: false,
                data: {
                    format: 'json'
                },
                dataType: 'json',
                success: function (data) {
                    var b = data.balance;
                    $('#balance_label1').html('Current Balance: ' + b);
                    $('#balance_row1').show();
                    $("#balance_row2").val(b);
                }
            });
        });
		
		$(".paymentmethodchoose").click(function(){
			var type = $(this).val();
			if(type == "0")
			{
				$(".bank").hide();
				$(".default").show();
			}
			else if(type == "1")
			{
				$(".default").hide();
				$(".bank").show();
			}
		});
    });
</script> 
<?php

$dd_outlet = $this->Constant_model->getddData('outlets', 'id', 'name', 'name');
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add <?php echo BDT; ?></h1>
		</div>
	</div>
    <form id="transferamt" action="<?= base_url() ?>bank_dt/insertBdt" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
					<?php
						$alert_msg = $this->session->userdata('alert_msg');
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
									<label>Ref. Number <span style="color: #F00">*</span></label>
									<input type="text"  name="id" value="<?php echo $newid; ?>" class="form-control" maxlength="499" autofocus autocomplete="off" readonly="" />
								</div>
							</div>

							<div class="col-md-4">
									<div class="form-group">
										<label>Outlet <span style="color: #F00">*</span></label>
										<select name="outlet_id" required="" id="outlet_id" class="form-control">
											<?php
												foreach ($getOutlet as $outlet)
												{ ?>
													<option value="<?=$outlet->id?>"><?=$outlet->name?></option>
											<?php }
											?>
										</select>
									</div>
							</div> 
							<div class="col-md-4">
								<div class="form-group">
									<label>Transfer Date <span style="color: #F00">*</span></label>
									<input type="text" name="transfer_date" class="form-control" id="transfer_date" value="<?php echo date('d-m-Y'); ?>" readonly=""/>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-4">
								<div class="form-group" style="margin:20px 0 ;">
									<label class="radio-inline">
										<input type="radio"  name="payemtmethod" class="paymentmethodchoose" id="defaultm" value="0" required="required" checked="checked"/> Default
									</label>
									<label class="radio-inline">
										<input type="radio" name="payemtmethod" class="paymentmethodchoose" id="bankm" value="1" required="required" /> Bank account
									</label>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-4">
								<label>Choose Deposit / Transfer Account  (From)<span style="color: #F00">*</span></label>
								<select id="bank_from1" class="form-control paymethod default" name="bank_from">
									<option value="">Choose Deposit / Transfer Account</option>
									<?php
									foreach ($payment_method as $payment)
									{ ?>
									<option value="<?=$payment->id?>"><?=$payment->name?></option>
									<?php } ?> 
								</select>
								
								<select id="bank_from_m" class="form-control paymethod bank change_account" name="bank_from_m" style="display: none;">
									<option value="">Choose Deposit / Transfer Account</option>
									<?php
									foreach ($bank_account as $bank)
									{ ?>
									<option value="<?=$bank->id?>"><?=$bank->account_number?> (Account Number)</option>
									<?php } ?> 
								</select>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Deposit Amount (LKR)<span style="color: #F00">*</span></label>
									<input required="" type="text" name="amount" value="<?php echo $amount = ''; ?>" class="form-control" maxlength="499" autofocus autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<label>Choose Deposit / Transfer Account (To)<span style="color: #F00">*</span></label>
								<select id="bank_to" class="form-control default" name="bank_to">
									<option value="">Receiving Account</option>
									<?php
									foreach ($bank_account as $bank)
									{ ?>
									<option value="<?=$bank->id?>"><?=$bank->account_number?> (Account Number)</option>
									<?php } ?> 
									
								</select>

								<select id="bank_to_m" class="form-control bank" name="bank_to_m" style="display: none;">
									<option value="">Receiving Account</option>
								</select>


								<?php
//								$bdt0 = bank_to_data();
//								echo sel_element($bdt0, $bank_to = 0, 'Receiving Account', 'bank_to', 'Choose Receiving Account ', 1);
								?>
							</div>	
						</div>
						<div class="row" id="balance_row1" style="">
							<div class="col-md-4">
								<div class="form-group">
									<label id="balance_label1"> </label>
									<input  type="hidden" name="balance_row2" value="" id="balance_row2" />
									<input  type="hidden" name="bank_to_data_val" value="" id="bank_to_data_val" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>File (Less than 2MB)<span style="color: #F00"></span></label>
									<input type="file" name="document" class="form-control" maxlength="499" autofocus autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Reason</label>
									<textarea name="reference" class="form-control"></textarea>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button type="submit" class="btn btn-primary">Add</button>
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>
					</div>
				</div>
				
				<a href="<?= base_url() ?>bank_dt" style="text-decoration: none;">
					<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
						<i class="icono-caretLeft" style="color: #FFF;"></i>Back
					</div>
				</a>
				
			</div>
		</div>
	</form>
</div>
	<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script>
	$('document').ready(function(){
		
	$("#transferamt").validate({
	  rules: {
			
			amount: {
				required: true,
				number: true,
				
			}
		},
		messages: {
			amount: "Please enter numeric number",
		
		},

		submitHandler: function(form) {
			form.submit();
		}
	});
		
		
		$('.change_account').change(function(){
			var bank_accounts_id = $(this).val();
			var outlet_id = $('#outlet_id').val();
				$.ajax({
				type:'POST',
				url:"<?=base_url();?>Bank_dt/Get_notMatchAllGetAccount",
				data: {bank_accounts_id: bank_accounts_id,outlet_id:outlet_id},
				dataType: 'JSON',
				success:function(data){
					$('#bank_to_m').html(data.success);
				}
				});
		});
		$('#bank_to_m').change(function(){
			var val = $("#bank_to_m option:selected").attr('data-val');
			$('#bank_to_data_val').val(val);
		});
		
		
		
		$('#outlet_id').change(function(){
			outlet();	
		});
		
		function outlet()
		{
			var outlet_id = $('#outlet_id').val();
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Bank_dt/getOutletPayment",
				data: {outlet_id: outlet_id},
				dataType: 'JSON',
				success:function(data){
					$('#bank_from1').html(data.success);
					$('#bank_to_m').html(data.anotherpayment);
				}
			 });
		}
		outlet();
	});
</script>