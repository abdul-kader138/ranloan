<?php
$app = realpath(APPPATH);
require_once $app . '/views/includes/header.php';
?>
<style>
	.boxremoveborder input {
		border: 0;
		background-color: #f7f7f8;
	}
	.boxremoveborder1 input {
		border: 0;
		background-color: #fff;
	}
	.active {
		background-color: orange !important;
	}
	#addPaymentMethod tr td input[type="text"]{
		border:none;
	}
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-8">
			<h1 class="page-header">Issue Voucher Details</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="get">
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Voucher Number </label>
                                    <input type="text" name="vocher_no" class="form-control" autocomplete="off" value="<?= !empty($this->input->get('vocher_no')) ? $this->input->get('vocher_no') : '' ?>" />
                                </div>
                            </div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate" autocomplete="off" value="<?= !empty($this->input->get('start_date')) ? $this->input->get('start_date') : '' ?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate" autocomplete="off"  value="<?= !empty($this->input->get('end_date')) ? $this->input->get('end_date') : '' ?>" />
								</div>
							</div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label><br />
                                    <button class="btn btn-primary" style="width: 100%;">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
					<hr>
					<div class="row" style="margin-top: 19px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th style="display: none;">id</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Date & Time</th>
											<!--<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="11%">Entry No</th>-->
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="11%">Note</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="12%">Outlet</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Customer</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Voucher Number</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Voucher Amount</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Action</th>
										</tr>
									</thead>
									<tbody> 
										<?php
										$numberOfVoucher = 0;
										$total_voucher_number = 0;
										foreach ($orders_data as $data) {
											$id = $data->id;
											$numberOfVoucher = $numberOfVoucher + 1;
											$date_time = $data->ordered_datetime;
											$outlet_name = $data->outlet_name;
											$customer_name = $data->customer_name;
											$voucher_number = $data->voucher_number;
											$customer_note = $data->customer_note;
											$paid_amt = $data->unpaid_amt;
											$outlet_id=$data->outlet_id;
											$total_voucher_number = $total_voucher_number + $paid_amt;
											?>
											<tr>
												<td style="display: none;"><?= $id ?></td>
												<td><?= $date_time ?></td>
												<!--<td><?= $id ?></td>-->
												<td><?= $customer_note ?></td>
												<td><?= $outlet_name ?></td>
												<td><?= $customer_name ?></td>
												<td><?= $voucher_number ?></td>
												<td><?= !empty($paid_amt) ? number_format($paid_amt, 2) : '0.00' ?></td>
												<td>
													<button class="btn btn-primary Popupvoucher" id="<?php echo $id; ?>" style="padding: 4px 12px; width: 80px;" >Action</button>
												</td>
											</tr>   
											
													<div id="myModalData<?php echo $id; ?>" class="modal fade" role="dialog">
														<div class="modal-dialog" style="width: 40%;padding-top: 2%;">
															<!-- Modal content-->
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Choose Your Action</h4>
																</div>
																<div class="modal-body">
																	<ul style="list-style-type:none; text-align:center;">

																		<li style="margin-top: 5px;"><button class="btn btn-primary" style="padding: 7px 44px;" data-toggle="modal" data-target="#myModal<?php echo $id; ?>">View</button>
																		</li>

																		<li style="margin-top: 5px;"><a class="btn btn-primary" onclick="openReceiptDetail('<?= base_url() ?>pos/view_order_detail?id=<?php echo $data->order_id; ?>')" style="text-decoration: none; cursor: pointer;padding: 7px 40px !important; " title="View Detail">
																				Detail
																			</a>
																		</li>
																		<?php
																		if($paid_amt != "" && $paid_amt !=0 )
																		{
																		?>
																		<li style="margin-top: 5px;"><a href="#timepicker4Modal" class="pop"  data-toggle="modal" data-customer="<?php echo $data->customer_id; ?>" data-id="<?php echo $id; ?>" data-outlet_id="<?php echo $outlet_id; ?>" data-amount="<?php echo $paid_amt; ?>" style="text-decoration: none;">
																				<button class="btn btn-primary" style="padding: 7px 12px;">Make Payment</button>
																			</a>
																		</li>
																		<?php
																		}
																		?>
																		<li style="margin-top: 5px;"><a  class="btn btn-primary" onclick="openReceipt('<?= base_url() ?>bank_accounts/view_bank_invoice?id=<?php echo $id; ?>')" style="text-decoration: none; cursor: pointer; width: 120px; " title="View Detail">
																				Normal Print
																			</a>
																		</li>
																		<li style="margin-top: 5px;">
																			<a class="btn btn-primary" onclick="openReceiptA4('<?= base_url() ?>bank_accounts/view_bank_invoice_a4/?id=<?php echo $id; ?>')" style="text-decoration: none; cursor: pointer; width: 120px;" title="Print Receipt">
																				A4 Print
																			</a>
																		</li>
																	</ul>

																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																</div>
															</div>
														</div>
													</div>




													<div id="myModal<?php echo $id; ?>" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">View Voucher Detail</h4>
																</div>
																<div class="modal-body">
																	<div class="row">
																		<div class="col-md-4">
																			<b>Date & Time</b>
																		</div>
																		<div class="col-md-8">
																			<?= $date_time ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Entry No</b>
																		</div>
																		<div class="col-md-8">
																			<?= $id ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Note</b>
																		</div>
																		<div class="col-md-8">
																			<?= $customer_note ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Outlet</b>
																		</div>
																		<div class="col-md-8">
																			<?= $outlet_name ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Customer</b>
																		</div>
																		<div class="col-md-8">
																			<?= $customer_name ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Voucher Number</b>
																		</div>
																		<div class="col-md-8">
																			<?= $voucher_number ?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Voucher Amount</b>
																		</div>
																		<div class="col-md-8">
																			<?= !empty($paid_amt) ? number_format($paid_amt, 2) : '0.00' ?>
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																</div>
															</div>
														</div>
													</div>
											
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<th style="display: none;"></th>
											<th></th>
											<!--<th></th>-->
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 style="color: #990000;">Summery</h3>
					<hr>
					<div class="col-md-12">
						<table>
							<tbody>
								<tr>
									<td><label style="color:#333333; font-size: 16px;">No of Voucher Customers:</label> </td>
									<td><label style="color:#333333; font-size: 16px;"><?= !empty($numberOfVoucher) ? number_format($numberOfVoucher, 2) : '0.00' ?></label></td>
								</tr>
								<tr>
									<td><label style="color:#333333;font-size: 16px;">Voucher Outstanding Total:</label> </td>
									<td><label style="color:#333333;font-size: 16px;"><?= !empty($total_voucher_number) ? number_format($total_voucher_number, 2) : '0.00' ?></label></td>
								</tr>
							</tbody>
						</table>
					</div>
					<hr>
				</div>
			</div>
		</div>



	</div>
	<br /><br /><br /><br /><br />
</div>

<style>
	.modal-dialog{
		width:60%;
		margin: auto;
	}
</style>
<div id="timepicker4Modal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background-color: #5fc509;">
									<h3 class="modal-title" style="color: #FFF; text-align: center;">Make Payment </h3>
								</div>
								<div class="modal-body" style="overflow: visible; background-color: #FFF;">
									<form id="paymentSubmit" method="post">
										<input type="hidden" name="customer_id"  value="" id="customerid"  />
										<input type="hidden" value="" name="Outletdata_id" id="Outletdata_id"  />
										<input type="hidden" value="" name="order_id" id="order_id"  />
									
										
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<select  id="paid_by" class="form-control ChangePayment">
													<option value="">Select Payment Method</option>
												</select>
												<span id="errorPayment" style="color: #cc0000;"></span>
											</div>
										</div>
										<div class="col-md-4">
											<input type="text"  class="form-control ChangeAmount" placeholder="0.00" value=""/>
											<span id="error_payment_amount" style="color: #cc0000;"></span>
										</div>
										<div class="col-md-4">
											<button class="btn btn-primary" type="button" id="AddPayment">Add Payment</button>
											<span id="add-item-loading3" style="display:none;position: absolute;top: 10%;left: 90%;"><img src="<?php echo base_url() . 'assets/img/loading.gif' ?>" /></span>
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
											<span class="CheckDetail" style="display: none">
												<div class="col-md-4">
													<label>Cheque Number :</label><br>
													<input type="text" tabindex="3"  class="form-control" id="cheque" placeholder="Cheque Number" autocomplete="off" />
												</div>
												
												<div class="col-md-4">
													<label>Bank :</label>
													<input type="text"  id="bank" class="form-control" autocomplete="off" />
												</div>

												<div class="col-md-4">
													<label>Cheque Date :</label>
													<input type="text" id="cheque_date"  class="form-control datepicker" />
												</div>
											</span>

											<span class="CardNumber" style="display: none">
												<div class="col-md-4">
													<label>Card Number :</label>
													<input type="text"  id="addi_card_numb" class="form-control" autocomplete="off" />
												</div>
											</span>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>
															<th>Payment Method</th>
															<th>Amount</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody id="addPaymentMethod">
													</tbody>
													<thead>
														<tr>
															<th>Total Amount</th>
															<th>
																<input class="form-control" id="customer_total_amount" style="width: 100px;" name="total_amount" value="0" readonly="readonly" type="text">
															</th>
															<th></th>
														</tr>
													</thead>
												</table>
												
												<hr>
											</div>
										</div>
									</div>
								
									<div class="row">
										<div class="col-md-12" style="padding-bottom: 10px;">
											<div class="col-md-4">
												<b>Total Amount:</b>
											</div>
											<div class="col-md-4">
												<input type="text" name="grand_amount" readonly="" id="totalamount1" value="" class="form-control" />
											</div>
										</div>

										<div class="col-md-12"  style="padding-bottom: 10px;">
											<div class="col-md-4">
												<b>Total Paid:</b>
											</div>
											<div class="col-md-4">
												<input type="text" value="0"  readonly="" class="form-control tpaid" />
											</div>
										</div>
										<div class="col-md-12" style="padding-bottom: 10px;">
											<div class="col-md-4">
												<b>Balance:</b>
											</div>
											<div class="col-md-4">
												<input type="text" readonly="" value="" class="form-control BalanceAmount" />
												<input type="hidden" id="returned_change" name="returned_change" value="0" />
												<input type="hidden" id="row_column"  value="0" />
											</div>
										</div>
									</div>
								
								</form>
								</div>

								<div class="modal-footer">
									<div class="row">
										<?php
										$us_id = $this->session->userdata('user_id');
										$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
										$logged_name = $get_logged_name->fullname;
										?>
										<div class="col-md-4">
											<div class="form-group">
												<label style="float: left;">Created By </label>
												<input type="text" name="created_by" class="form-control" value="<?= $logged_name ?>" readonly="">
											</div>
										</div>
										<div class="col-md-8">
											<button  type="button" id="submitdata" class="btn btn-primary">Submit</button>
											<span id="add-item-loading4" style="display:none;position: absolute;left: 70%;"><img src="<?php echo base_url() . 'assets/img/loading.gif' ?>" /></span>
										</div>
									</div>
								</div>
							</div>
							<!-- Panel Body // END -->
						</div>
						<!-- Panel Default // END -->
					</div>
<div id="outofstockwrp" class="modal fade"> 
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" style="overflow: visible; background-color: #FFF; border-radius: 12px;">
				<div class="row">
					<div class="col-md-12" style="text-align: center; font-size: 25px; padding-top: 20px; padding-bottom: 20px; color: #c72a25;">
						Out of Stock! 
						<br />
						Please update inventory OR make Purchase Order to Supplier!
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

		<div class="message-box animated fadeIn payment_cust_popup" data-sound="alert" id="mb-signout">
			<div class="mb-container">
				<div class="mb-middle">
					<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
					<div class="mb-content">
						<p>Are you sure you want to Remove?</p>                    
						<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
						<input type="hidden" id="remove_paym_id" >
						<input type="hidden" id="remove_totlamt" >
					</div>
					<div class="mb-footer">
						<div class="pull-right">
							<a id="remove_row" class="btn btn-success btn-lg payment_remove_row" data-dismiss="modal">Yes</a>
							<button class="btn btn-default btn-lg mb-control-close" >No</button>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>


<!--end payment method-->

<?php
$app = realpath(APPPATH);

require_once $app . '/views/includes/footer.php';

//    require_once 'includes/footer.php';
?>



<script>
	function openReceiptA4(ele) 
	{
            var myWindow = window.open(ele, "", "width=1020, height=650");
	}

	function openReceiptDetail(ele) 
	{
		var myWindow = window.open(ele, "", "width=650, height=650");
	}
	function openReceipt(ele)
	{
		var myWindow = window.open(ele, "", "width=380, height=550");
	}
	
	$(".pop").click(function () {
			var orderid = $(this).data('id');
            var amount = $(this).data('amount');
            var customer = $(this).data('customer');
			var outlet_id = $(this).data('outlet_id');
			$.ajax({
                url: "<?php echo base_url() . 'bank_accounts/get_payment_outletwise'; ?>",
                type: 'POST',
                data: {outlet_id: outlet_id},
                dataType: "json",
                success: function (response) {
					if (response) {
                        $('#paid_by').html(response.payment);
							$('#totalamount1').val(amount);
							$('.BalanceAmount').val(amount);
							$('.modal #customerid').val(customer);
							$('.modal #Outletdata_id').val(outlet_id);
							$('.modal #order_id').val(orderid);
							$('#timepicker4Modal').modal('show');
					}
				}
			});
		});
	
		
	 $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
    });
	

	$('#submitdata').click(function(event){
			event.preventDefault();
			var tpaid = $('.tpaid').val();
			if(tpaid != 0 || tpaid == "")
			{
				var formData = new FormData();
				var contact = $('#paymentSubmit').serializeArray();
				$.each(contact, function (key, input) {
					formData.append(input.name, input.value);
				});

				$('#submitdata').addClass('disabled');
				$.ajax({
					type:'POST',
					url: "<?php echo base_url(); ?>bank_accounts/save_payment",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'JSON',
					success:function(data){
						if(data.status == 1)
						{
							alert(data.message);
							location.reload();
						}
						else
						{
							alert(data.message);
							location.reload();
						}
					}
				});
			}
			else
			{
				alert('Your Paid amount is Zero (0)'); 
			}
			
			
		});
	
	
	
	function deletedivpay(ele) {
		var removevalue = ele;
		var total_paid = $('.tpaid').val();
		var totalamount = parseFloat($('#totalamount1').val());
		var newtotal = total_paid - removevalue;
		$("#customer_total_amount").val(newtotal);
		var a = $(".tpaid").val(newtotal);
		var aa = $(".tpaid").val();
		var b = totalamount - aa;
		$('.BalanceAmount').val(parseFloat(b));
	
	}
	
	
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
	

	$("#addPaymentMethod").on('click', '#btndelete', function () {
		var id = $(this).attr('data-id');
		var totlamt = $(this).attr('data-totlamt');
		$('#remove_paym_id').val(id);
		$('#remove_totlamt').val(totlamt);
		$('.payment_cust_popup').modal('show');
	});
	
	$('.payment_remove_row').click(function(){
	var id =	$('#remove_paym_id').val();
	var totlamt =	$('#remove_totlamt').val();
		$('#paym'+id).remove();
		deletedivpay(totlamt);
		$('.payment_cust_popup').modal('hide');
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
				var row_column				= $('#row_column').val();
				var customer_total_amount	= $('#customer_total_amount').val();
				//var payname					= $('#paid_by option:selected').attr('data-val');
				var payname				= $('#paid_by option:selected').text();
				//alert(paynames);
				var cheque			= $('#cheque').val();
				var bank			= $('#bank').val();
				var cheque_date		= $('#cheque_date').val();
				var addi_card_numb	= $('#addi_card_numb').val();
				var customer_name	= $('#customer_name').val();
				var finaltotal = parseFloat(customer_total_amount) + parseFloat(amount);
				$('#customer_total_amount').val(finaltotal);
				$('.tpaid').val(finaltotal);


						var cell = $('<tr id="paym'+row_column+'"><td><label>'+payname+'</label> <input type="hidden" value="' + paid_by +
											'" name="payment['+row_column+'][paid_by]" /> <input type="hidden" value="' + cheque +
											'" name="payment['+row_column+'][cheque]"  /> <input type="hidden" value="' + addi_card_numb +
											'" name="payment['+row_column+'][addi_card_numb]"  /> <input type="hidden" value="' + bank +
											'" name="payment['+row_column+'][bank]"  /> <input type="hidden" value="' + cheque_date +
											'" name="payment['+row_column+'][cheque_date]"   />  </td>\n\
											<td><input class="form-control" style="width: 100px;" type="text" readonly value="' + amount +
											'" name="payment['+row_column+'][paid]" ></td><td><i class="glyphicon glyphicon-remove-sign" id="btndelete" data-id='+row_column+' data-totlamt='+amount+' style="color: red; cursor: pointer; font-size: 28px;"></i></td></tr>');
						$('#addPaymentMethod').append(cell);

					row_column++;
					$('#row_column').val(row_column);
					var totalamount1 = $('#totalamount1').val();
					var tpaid = $('.tpaid').val();
					$('.ChangeAmount').val('0')
					$('#paid_by').val('');
					if(parseFloat(totalamount1) >= parseFloat((tpaid)))
					{
//						$('#submitdata').show();	
					}
					else
					{
//						$('#submitdata').hide();
					}
					
				$('#cheque').val('');
				$('#bank').val('');
				$('#cheque_date').val('');
				$('#addi_card_numb').val('');
				$('.CheckDetail').hide();
				$('.CardNumber').hide();
			}
			
			
		});
			
	
	
	
	$('.Popupvoucher').click(function () {
        var id = $(this).attr('id');
        $('#myModalData' + id).modal('show');
    });
	
	
    $(document).ready(function () {
        $("#datatable").DataTable({
            dom: "Bfrtip",
            "bPaginate": true, ordering: true, "pageLength": 10,
            buttons: [
                {
                    extend: "copy",
                    className: "change btn-primary "
                },

                {
                    extend: "csv",
                    className: " change btn-primary"
                },
                {
                    extend: "excel",
                    className: "change btn-primary"
                },
                {
                    extend: "print",
					footer: true,
                },
                {
                    extend: "pageLength",
                },
            ],
            order: [0, "desc"],
            responsive: true,
            drawCallback: function () {
                var api = this.api();
                $(api.table().column(6).footer()).html("<strong>" +
                        addCommas(api.column(6, {page: 'current'}).data().sum().toFixed(2)) + "(LKR)</strong>"
				);
            }
        });
    });


</script>	