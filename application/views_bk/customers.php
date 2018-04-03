<?php
require_once 'includes/header.php';
?>

<style>
.custombtns{
	padding: 4px 12px;width:160px; margin-bottom:6px;
}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Customers</h1>
		</div>	
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
					<div role="alert" class="alert alert-success">
					   <button data-dismiss="alert" class="close" type="button">
						   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
					   <strong>Well done!</strong>
					   <?= $this->session->flashdata('SUCCESSMSG') ?>
					</div>
					<?php } ?>
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

					<?php
					if ($user_role < 3) {
						?>
						<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
							<div class="col-md-8">
								<a href="<?= base_url() ?>customers/addCustomer" style="text-decoration: none;">
									<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
										<i class="icono-plus"></i> Add Customer
									</button>
								</a>
								
								<a href="<?= base_url() ?>customers/addcustomergroup" style="text-decoration: none;">
									<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
										<i class="icono-plus"></i> Add Customer Group
									</button>
								</a>
								<a href="<?= base_url() ?>customers/import_customer" style="text-decoration: none;">
									<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
										<i class="icono-plus"></i> Import Customer
									</button>
								</a>
							</div>
							
							<div class="col-md-4" style="text-align: right;">
								<?php if ($user_role < 3) {
								?>
<!--								<a href="<?= base_url() ?>customers/exportCustomer" style="text-decoration: none;">
									<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
										Export
									</button>
								</a>-->
								<?php } ?>
							</div>
						</div>
						<?php
					}
					?>
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<br/>
							<div class="table-responsive">
								<table class="table" id="datatable">
									<thead>
										<tr>
											<th style="display: none;">id</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Customer Name</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="17%">Email</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Mobile</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Outstanding</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Points</th>
                                            <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Deposit</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Balance (Deposit – Outstanding)</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Credit Amount</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Credit Limit Code</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd; border-right: 1px solid #ddd;" width="13%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$new_settings = $settingData->new_settings;
										$new_settings_array = json_decode($new_settings, true);
										$is_point			= (array_key_exists('is_point', $new_settings_array)) ? $new_settings_array['is_point'] : '';
										$point_percentage	= (array_key_exists('point_percentage', $new_settings_array)) ? $new_settings_array['point_percentage'] : '';
										
										if ($is_point == "yes") {
											$pointCustomer = $point_percentage;
										} else {
											$pointCustomer = 0;
										}
											$total_outstanding=0;
											$total_depostit=0;
											$totalbal=0;
										if (count($results) > 0) {
											foreach ($results as $data) {
												$cust_id = $data->id;
												$cust_fn = $data->fullname;
												$cust_em = $data->email;
												$cust_mb = $data->mobile;
												$outstanding = ($this->db->select('sum(unpaid_amt) as total')->from('gold_orders_payment')->where('customer_id', $data->id)->get()->row()->total);
												$customer_Point = $this->db->select('sum(customer_Point) as total')->from('gold_orders_payment')->where('customer_id', $data->id)->get()->row()->total;
												$total_outstanding =$total_outstanding + $outstanding;
											?>
												<tr>
													<td style="display: none;"><?=$cust_id;?></td>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $cust_fn; ?></td>
													<td style="border-bottom: 1px solid #ddd;">
														<?php
														if (empty($cust_em)) {
															echo '-';
														} else {
															echo $cust_em;
														}
														?>	
													</td>
													<td style="border-bottom: 1px solid #ddd;">
														<?php
														if (empty($cust_mb)) {
															echo '-';
														} else {
															echo $cust_mb;
														}
														?>
													</td>
													<td style="border-bottom: 1px solid #ddd;"><?php echo !empty($outstanding)? number_format($outstanding,2) : 0?> </td>
													<td style="border-bottom: 1px solid #ddd;"><?=!empty($customer_Point)?number_format($customer_Point,2):0;?></td>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $customerdeposit = (array_key_exists($cust_id, $deposits)) ? ci_format_number($deposits[$cust_id]) : '-'; ?></td>
													<td style="border-bottom: 1px solid #ddd;"><?php $bal = $deposits[$cust_id] - $outstanding; echo number_format($bal,2)?></td>
													<td style="border-bottom: 1px solid #ddd;"><?=!empty($data->credit_amount)?number_format($data->credit_amount,2):0?></td>
													<td style="border-bottom: 1px solid #ddd;">
													<?php
													$total_depostit = $total_depostit + $deposits[$cust_id];
													$totalbal = $totalbal+ $bal;
													$creditlimit = $data->credit_amount;
														if($creditlimit != 0 && $outstanding != 0)
														{
															$percenttage = ($outstanding * 100) / $creditlimit;
															foreach ($getCreditColor as $color)
															{
																if($color->to > $percenttage && $color->from < $percenttage )
																{ ?>
																	<button class="btn" style="background: #<?=$color->color?>">&nbsp;</button>
																	<?php 
																}
																else if($percenttage > 100)
																{ ?>
																	<button class="btn" style="background: #cc0000">&nbsp;</button>
																<?php 
																	break;
																}
															}
														}
														?>
													</td>
													<td style="border-bottom: 1px solid #ddd;">
														<button class="btn btn-primary PopupCustomer" id="<?php echo $cust_id; ?>" style="padding: 4px 12px; width: 80px;" >Action</button>
														
														<div id="myModalData<?php echo $cust_id; ?>" class="modal fade" role="dialog">
															<div class="modal-dialog">
																<!-- Modal content-->
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Choose Your Action</h4>
																	</div>
																	<div class="modal-body">
																		<ul style="list-style-type:none; text-align:center;">
																			<li><a href="<?= base_url() ?>customers/edit_customer?cust_id=<?php echo $cust_id; ?>" class="btn btn-primary custombtns">Edit</a></li>
																			
																			<li style="padding-bottom:4px;"><button class="btn btn-primary popdebit" data-val="<?=$data->outlet_id?>" data-id="<?=$data->id?>"  data-total="<?=$outstanding?>" data-items="1" style="width: 160px;"  >Add Payment</button></li>
																			
																			<li><a href="<?= base_url() ?>customers/customer_history?cust_id=<?php echo $cust_id; ?>" class="btn btn-primary custombtns">Sales History</a></li>
																			<li><a href="<?= base_url() ?>customers/customer_transaction?cust_id=<?php echo $cust_id; ?>" class="btn btn-primary custombtns">Transaction</a></li>
																			<li><a href="<?= base_url() ?>sales/customer_payment_history?cust_id=<?php echo $cust_id; ?>" class="btn btn-primary custombtns">Payment History</a></li>
																			<li><a href="<?= base_url() ?>customers/customer_point_history?cust_id=<?php echo $cust_id; ?>" class="btn btn-primary custombtns">Points History</a></li>
																			<li><a href="<?= base_url() ?>customers/prepay?customer_id=<?php echo $cust_id; ?>" class="btn btn-primary custombtns">Deposits</a></li>
																			<li><a href="<?= base_url() ?>debit/view?customer_id=<?php echo $cust_id; ?>" class="btn btn-primary custombtns">Outstanding details</a></li>
																			<li><a href="<?= base_url() ?>customers/edit_customer_pass?cust_id=<?php echo $cust_id; ?>" class="btn btn-primary custombtns">Change Password</a></li>
																			<li><a href="<?=base_url()?>loan/add_loan?cus_id=<?=$cust_id?>" class="btn btn-primary custombtns">Add Loan</a></li>
																			<li><a href="<?=base_url()?>loan/settle_loan?cus_id=<?=$cust_id?>" class="btn btn-primary custombtns">Settle Loan</a></li>
																			<li><a href="<?=base_url()?>loan/loan_list?cus_id=<?=$cust_id?>" class="btn btn-primary custombtns">Loan Details</a></li>
																		</ul>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																	</div>
																</div>
															</div>
														</div>
														
													</td>
												</tr>
												<!-- Modal -->
												
											<?php
											}
										} else {
										?>
											<tr>
												<td colspan="100%">No matching records found</td>
											</tr>
										<?php
										}
										?>
									</tbody>
									<tfoot>
										<th style="display: none;" ></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
									</tfoot>
								</table>
							</div>


					<div id="timepicker4Modal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background-color: #5fc509;">
									<h3 class="modal-title" style="color: #FFF; text-align: center;">Make Payment </h3>
								</div>
								<div class="modal-body" style="overflow: visible; background-color: #FFF;">
									<form id="paymentSubmit" method="post">
										<input name="customer_id" type="hidden" value="" id="customerid"  />
										<input  type="hidden" value="" name="Outletdata_id" id="Outletdata_id"  />
									
										
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<select  id="paid_by" class="form-control ChangePayment">
													<option value="">Select Payment Method</option>
													<?php
													$payMethodData = $this->Constant_model->getDataOneColumn('payment_method', 'status', '1');
													for ($p = 0; $p < count($payMethodData); ++$p) {
														$payMethod_id = $payMethodData[$p]->id;
														$payMethod_name = $payMethodData[$p]->name;
														if ($payMethod_id == 1 || $payMethod_id == 3 || $payMethod_id == 5) {
															?>
															<option data-val="<?=$payMethod_name?>" value="<?php echo $payMethod_id; ?>"><?php echo $payMethod_name; ?></option>
															<?php
														}
													}
													?>
												</select>
												<span id="errorPayment" style="color: #cc0000;"></span>
											</div>
										</div>
										<div class="col-md-4">
											<input type="text"  class="form-control ChangeAmount" placeholder="0.00" value="0"/>
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


				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->


	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 style="color: #990000;">Summery</h3>
					<hr>
						<div class="col-md-12">
							<table>
								<tbody>
									<tr>
										<td><label style="color:#333333; font-size: 16px;">Total Deposits:</label> </td>
										<td><label style="color:#333333; font-size: 16px;"><?=!empty($total_depostit)?number_format($total_depostit,2):'0.00';?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Outstanding:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($total_outstanding)?number_format($total_outstanding,2):'0.00';?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Balance:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($totalbal)?number_format($totalbal,2):'0.00';?></label></td>
									</tr>
									
								</tbody>
							</table>
						</div>
					<hr>
				</div>
			</div>
		</div>
	</div>
	
		
	<br /><br /><br />

</div><!-- Right Colmn // END -->
	</div>
	
	
</div>

	
<?php
require_once 'includes/footer.php';
?>
	
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
<script type="text/javascript">
	
	
	
	
	
	
	
	
	
	$( ".datepicker" ).datepicker();
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
					url:"<?=base_url();?>customers/save_payment",
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
		var tpaid = $('.tpaid').val();
		if (parseFloat(totalamount) >= parseFloat(tpaid).toFixed(2))
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
	
//	$("#addPaymentMethod").on('click', '#btndelete', function () {
//		$(this).closest('tr').remove();
//	});

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
			
	
	
	$('.PopupCustomer').click(function(){
		var id = $(this).attr('id');
		$('#myModalData'+id).modal('show');
	});
	
     $(document).ready(function () {
		 
		 
		 $('#timepicker4Modal').delegate('.order_payment_totalPaid_loop','blur',function(){
			 var totalUnpaid = $('#order_payment_totalUnpaid').val();
			 var totalpaidamount = 0;
			  $('.order_payment_totalPaid_loop').each(function(){
					var paid = $(this).val();
					totalpaidamount = parseFloat(totalpaidamount) + parseFloat(paid); 
			  });
			 
			 if(parseFloat(totalUnpaid) >= parseFloat(totalpaidamount))
			 {
				 $('#order_payment_totalPaid').val(totalpaidamount); 
			 }
			 else
			 {
				$('.order_payment_totalPaid_loop').each(function(){
					$(this).val('0');
				});
				$('#order_payment_totalPaid').val('0'); 
				alert('Please enter amount less than unpaid amount!!');
			 }
		 });
		 
		 
		 
		$(".table-responsive").on("click", ".popdebit", function() {
			var total = $(this).data('total');
			var customer_id = $(this).data('id');
			var outletid = $(this).data('val');

			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Customers/getOutletPayment",
				data: {outletid: outletid},
				dataType: 'JSON',
				success:function(data){
					$('#paid_by').html(data.payment);
					$('#totalamount1').val(total);
					$('.BalanceAmount').val(total);
					$('.modal #customerid').val(customer_id);
					$('.modal #Outletdata_id').val(outletid);
					$('#timepicker4Modal').modal('show');
				}
			 });
			

		});
		
	
        


		
		
		$("#datatable").DataTable({
			dom: "Bfrtip",
			"bPaginate": true, ordering: true, "pageLength": 15,
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
				},
				{
					extend: "pageLength",
				},
			],
			 order:[0,"desc"],
			responsive: true,
			"footerCallback": function ( row, data, start, end, display ) {
			var api = this.api(), data;
			var pagetotal = addCommas(api.column( 6, {page:'current'} ).data().sum().toFixed(2));
			$( api.table().column(7).footer() ).html("<strong>"+addCommas(api.column( 7, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
			$( api.table().column(6).footer() ).html("<strong>"+pagetotal+" LKR </strong>");
			$( api.table().column(5).footer() ).html("<strong>"+addCommas(api.column( 5, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
			$( api.table().column(4).footer() ).html("<strong>"+addCommas(api.column( 4, {page:'current'} ).data().sum().toFixed(2))+" (g) </strong>");
			
		}
		});
	});
</script>