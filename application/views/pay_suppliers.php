<?php
require_once 'includes/header.php';
?>
<script>
	$( function() {
		$( "#startDate" ).datepicker();
		$("#endDate").datepicker();
		$("#cheque_da").datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,});
	});
</script>

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
            <div class="col-lg-12">
                <h1 class="page-header">Pay Suppliers</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
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
<!--                            <div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
                                <div class="col-md-6"></div>
                                <div class="col-md-6" style="text-align: right;">
                                    <a href="<?=base_url()?>store/exportSuppliers" style="text-decoration: none;">
                                        <button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
                                            Export Supplier Outstanding
                                        </button>
                                    </a>
                                </div>
                            </div>-->
                            <?php
                        }
                        ?>

                        <form action="" method="get">
                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Supplier Name</label>
                                        <input type="text" name="search_name" value="<?=!empty($this->input->get('search_name'))?$this->input->get('search_name'):''?>" class="form-control" style="height: 35px" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date From</label>
                                        <input type="text" name="start_date" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" class="form-control" id="startDate" style="height: 35px" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date To</label>
                                        <input type="text" name="end_date" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>"  class="form-control" id="endDate" style="height: 35px" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br />
                                        <input type="hidden" name="report" value="1" />
                                        <button class="btn btn-primary" style="width: 100%; height: 35px;">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row" style="margin-top: 0px;">
                            <div class="col-md-12">

                                <div class="table-responsive">
                                    <table class="table" id="datatable">
                                        <thead>
                                        <tr>
                                            <th style="text-align: left;" width="5%">Sale Id</th>
                                            <th style="text-align: left;" width="16%">Date</th>
                                            <th style="text-align: left;" width="16%">Outlet</th>
                                            <th style="text-align: left;" width="16%">Supplier</th>
                                            <th style="text-align: left;" width="10%">Grand Total</th>
                                            <th style="text-align: left;" width="10%">Unpaid Amt</th>
                                            <th style="text-align: left;" width="18%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
											<?php
												foreach ($results as $data) 
												{
													$grandTotal = $data->grandTotal;
													?>
													<tr>
														<td><?=$data->id?></td>
														<td><?=date("d-M-Y H:i:s", strtotime($data->created_datetime))?></td>
														<td><?=$data->outlet_name?></td>
														<td><?=$data->supplier_name?></td>
														<td><?=$data->grandTotal?></td>
														<td>
															<?php
															$amount = 0;
															$purchase_bill = $this->db->query("SELECT purchase_id,  SUM(paid_amt) as amount FROM purchase_bills WHERE purchase_id= $data->id ")->result();
															foreach ($purchase_bill as $value) {
																$amount = $value->amount;
															}
															$unpaid_amt = 0;
															$unpaid_amt = $amount - $data->grandTotal;
															echo !empty($unpaid_amt)?number_format($unpaid_amt,2):0;
															?>
														</td>
														<td>
															<a href="#" class="pop" data-id="<?php echo $data->id; ?>" data-outletid="<?php echo $data->outlet_id; ?>" data-outletname="<?php echo $data->outlet_name; ?>" data-supplier="<?php echo $data->supplier_name;?>" data-spid="<?php echo $data->supplier_id; ?>" data-total="<?php echo $grandTotal-$amount;?>" data-items="<?php echo $data->totalitem;?>"  style="text-decoration: none;">
																<button class="btn btn-primary" style="padding: 4px 12px;">Make Payment</button>
															</a>
															<a class="btn btn-primary" href="<?=base_url();?>purchase_order/viewpo?id=<?=$data->id?>">View</a>
														</td>
													</tr>
											<?php	}
											?>
									    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<br /><br /><br />
		
		
<style>
	.supplierdialog{
		width:60%;
		margin: auto;
	}
</style>


	<div id="timepicker4Modal" class="modal fade"> 
        <div class="modal-dialog supplierdialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #5fc509;">

					<h3 class="modal-title" style="color: #FFF; text-align: center;"  >Make Payment </h3>

                </div>
                <div class="modal-body" style="overflow: visible; background-color: #FFF;">
					<script src="<?= base_url() ?>assets/js/input-mask/jquery.inputmask.js" type="text/javascript"></script>
					<script src="<?= base_url() ?>assets/js/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
					<script type="text/javascript">
						$(document).ready(function () {
							$('#card_numb').inputmask("9999 9999 9999 9999");
        
							$("#card_numb").on("keyup", function(event) {
            
								var card_numb       = document.getElementById("card_numb").value;
            
								//alert(card_numb.length);
            
								if(card_numb.length == 0) {
								  //  document.getElementById("submit_btn").style.display = "none";
								} else if(card_numb.indexOf('_') == -1){
									var addNewCustomer = $.ajax({
										url     : '<?= base_url() ?>pos/loadGiftCardValue?card_numb='+card_numb,
										type    : 'GET',
										cache   : false,
										data    : {
											format: 'json'
										},
										error   : function() {
											//alert("Sorry! we do not have stock!");
										},
										dataType: 'json',
										success : function(data) {
											var card_value  = data.value;
											var card_status = data.errorMsg;
												if (card_status == "failure") {
													document.getElementById("paid").value = 0;
													document.getElementById("return_change").innerHTML = 0;
													//  document.getElementById("submit_btn").style.display = "none";
													alert("Card Do not Exist!");
													document.getElementById("card_numb").value = "";
												} else if (card_status == "used") {

													document.getElementById("paid").value = 0;
													document.getElementById("return_change").innerHTML = 0;
													//document.getElementById("submit_btn").style.display = "none";
													alert("Card used!");
													document.getElementById("card_numb").value = "";

												} else if (card_status == "expired") {

													document.getElementById("paid").value = 0;
													document.getElementById("return_change").innerHTML = 0;
													//document.getElementById("submit_btn").style.display = "none";
													alert("Card Expired!");
													document.getElementById("card_numb").value = "";

												} else if (card_status == "success") {

													document.getElementById("paid").readOnly = true;
													document.getElementById("paid").value = card_value;
													//document.getElementById("submit_btn").style.display = "block";
													document.getElementById("paid").onclick = false;
													calculatePaidAmtGift(card_value);
												}

											}
										});
										//document.getElementById("submit_btn").style.display = "block";
									} else {
										//document.getElementById("submit_btn").style.display = "none";
									}


								});
								
								
								
								
								$('.ChangePaymentMethod').change(function(){
										var value = $(".ChangePaymentMethod option:selected").text();
										if(value == 'Cheque')
										{
											CleardataPayment();
											$('#customer_fields').show();
											$('#ChequeDetail').show();
										}
										else if(value == 'Credit cards')
										{
											CleardataPayment();
											$('#CardDetail').show();
										}
										else if(value == 'Gift Card')
										{
											CleardataPayment();
											$('#GiftCardDetail').show();
										}
										
										else if(value == 'Vouchers')
										{
											CleardataPayment();
											$('#VocherDetail').show();
										}
										else
										{
											CleardataPayment();
										}
								});
								
								function CleardataPayment()
								{
									$('#cheque').val('');
									$('#bank').val('');
									$('#cheque_da').val('');
									$('#voucher').val('');
									$('#card_numb').val('');
									$('#addi_card_numb').val('');
									
									$('#ChequeDetail').hide();
									$('#CardDetail').hide();
									$('#GiftCardDetail').hide();
									$('#VocherDetail').hide();
								}
							});
					</script>     
					<div class="row">

						<div class="col-lg-4 ">
							<h4 > Supplier:   
								<input type="hidden"  id="orderid" />
								<input type="hidden" id="supplier" style="border:0;" />
								<input type="hidden" id="supplierid" />
								<input type="hidden" id="outletid" />
								<input type="hidden" id="outletname" />

								<span id="supplier" style="background-color: #FFFF99;"><?php //echo $grandTotal;  ?></span>
							</h4>  
						</div>
						<div class="col-lg-4 ">
							<h4 > Total Payable Amount: 

								<span id="final_payable_amt" style="background-color: #FFFF99;"><?php //echo $grandTotal;  ?></span> </h4>  
						</div>
						<div class="col-lg-4 ">
							<h4 > Total Purchased Items: <span id="final_purchased_item" style="background-color: #FFFF99;"><?php //echo $total_items;  ?></span>
							</h4>  
						</div>
					</div>

					<hr>
					
					
					<div class="row">

						<div class="col-md-4">
							<div class="form-group">   
								<label>&nbsp;&nbsp;</label><br>
								<input type="hidden" name="rowControl" id="rowControl"  value="0" />
								<select name="paid_by" tabindex="2" id="paid_by" class="form-control ChangePaymentMethod" >
									<option value="">Select Payment Method</option>
									<?php
									$payMethodData = $this->Constant_model->getDataOneColumn('payment_method', 'status', '1');
									for ($p = 0; $p < count($payMethodData); ++$p) {
										$payMethod_id = $payMethodData[$p]->id;
										$payMethod_name = $payMethodData[$p]->name;
										?>
										<option value="<?php echo $payMethod_id; ?>"><?php echo $payMethod_name; ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-2" style="margin-top:24px;">
							<input type="number" step="0.01" tabindex="4" name="paid" id="paid" class="form-control" placeholder="0.00"  onchange="chkReturn(this.value)" onkeyup="chkReturn(this.value)" value="" autocomplete="off" />
						</div>

						

						<div class="col-md-2">
							<label>&nbsp;</label><br>
							<input type="button" value="Add Payment" id="addPayment" class="btn btn-primary" id="submit_btn"  />
							<span id="add-item-loading3" style="display:none;position: absolute;top: 10%;left: 90%;"><img src="<?php echo base_url() . 'assets/img/loading.gif' ?>" /></span>
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px;">
						
						<span id="ChequeDetail"  style="display: none;">
							
							<div class="col-md-3"  id="cheque_wrp" >
								<label>Cheque Number :</label><br>
								<input type="text" tabindex="3" name="cheque[]" class="form-control" id="cheque" placeholder="Cheque Number" autocomplete="off" />
							</div>

							<div class="col-md-3" id="bank_wrp" >
								<label>Bank :</label><br>
								<select name="bank" id="bank"  tabindex="2"  class="form-control" >
								<option value="">Select Bank</option>
									<?php
									foreach ($bank_account as $bank)
									{ ?>
									<option value="<?=$bank->id?>"><?=$bank->account_number?> (Account Number)</option>
									<?php } ?> 
								</select>
							</div> 

							<div class="col-md-3" id="cheque_date_wrp" >
								<label>Cheque Date :</label><br>
								<input type="date" name="cheque_date" id="cheque_da" class="form-control datepicker" autocomplete="off" />
							</div>
						</span>
						
						<span id="VocherDetail" style="display: none;">
							<div class="col-md-3"  id="voucher_wrp" >
								<label>Vocher Number :</label><br>
								<input type="text" tabindex="3" name="voucher[]" class="form-control" id="voucher" placeholder="Voucher Number" autocomplete="off" />
							</div>
						</span>	
						
						<span id="GiftCardDetail" style="display: none;">
							<div class="col-md-3"  id="card_wrp">
								<label>Gift Card Number :</label><br>
								<input type="text" name="card_numb" class="form-control" id="card_numb" placeholder="Gift Card Number" autocomplete="off" />
							</div>
						</span>
						
						<span id="CardDetail" style="display: none;">
							<div class="col-md-3" id="addi_card_numb_wrp" >
								<label>Card Number :</label><br>
								<input type="text" name="addi_card_numb" id="addi_card_numb" class="form-control" autocomplete="off" />
							</div> 
						</span>
						
						
					</div>



					<div class="row"  style="margin: 0%">
						<div class="col-md-12" style="padding: 0px;">
							<div class="table-responsive">
                                <form name="payment_form" id="payment_form" method="post" enctype="multipart/form-data">
                                    <table class="table " >
                                        <thead>
											<tr>
												<th>Payment Method</th>
												<th>Supplier</th>
												<th>Amount</th>
												<th></th>
											</tr>
                                        </thead>
                                        <tbody id="addPaymentMethod">
                                        </tbody>
										<input type="hidden" id="row_count_hidden" value="1"  />
                                    </table>
								</form>
								<hr>


							</div>
						</div>
					</div>  


                    <div class="row" style="padding-top: 3px; padding-bottom: 3px;">
                        <div class="col-md-6"><b>Total Amount: </b></div>
						<div class="col-md-4">  <span id="totalamount" style="background-color: #FFFF99;"><?php //echo $grandTotal;  ?></span>
							<span class="boxremoveborder1"> <input type="text" class="total" id="totalamount1" name="total" value="0" readonly="readonly" /></span>
						</div>
                    </div>
                    <div class="row" style="padding-top: 3px; padding-bottom: 3px;">
                        <div class="col-md-6"><b>Total Paid :</b></div>
                        <div class="col-md-4">
							<span class="boxremoveborder1">     <input type="text" class="tpaid" id="tpaid" name="tpaid" value="0" readonly="readonly" />
							</span>
							<span id="return_change" style="display:none;" ></span>
							<input type="hidden" id="returned_change" name="returned_change" value="0" />
                        </div>
                    </div>
                    <div class="row" style="padding-top: 3px; padding-bottom: 3px;">
                        <div class="col-md-6"><b>Balance: </b></div>
                        <div class="col-md-4">

							<span class="boxremoveborder1">     <input type="text" disabled="disabled" id="lbl_balance" value="0"/>   </span>
							<input type="hidden"  id="added_prvious" value="0"/>   
                        </div>
                    </div>
				</div>

				<div class="modal-footer" style="margin-right: 50px;">

					<div class="row">
						<?php
						$us_id = $this->session->userdata('user_id');
						$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
						$logged_name = $get_logged_name->fullname;
						?>
						<div class="col-md-4">
							<div class="form-group">
								<label style="margin-right:  60%;" >Created By </label>
								<input type="text" name="created_by" class="form-control" value="<?= $logged_name ?>" readonly="">
                            </div>
                        </div>
						<div class="col-md-8">
							<button type="button" onclick="save_payment()" name="sendBtn" class="btn btn-success" id="sendBtn" >Submit</button>
							<span id="add-item-loading4" style="display:none;position: absolute;left: 70%;"><img src="<?php echo base_url() . 'assets/img/loading.gif' ?>" /></span>

						</div>
					</div>
                </div>
			</div>
		</div>
	</div>
		<div id="outofstockwrp" class="modal fade"> 
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body" style="overflow: visible; background-color: #FFF; border-radius: 12px;">
						<div class="row">
							<div class="col-md-12" style="text-align: center; font-size: 25px; padding-top: 20px; padding-bottom: 20px; color: #c72a25;">
								No enough money and should not make the payment!
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	

<script type="text/javascript">
        $(function () {
            $(".pop").click(function () {
		        var outletid = $(this).data('outletid');
				var outletname = $(this).data('outletname');
				var total = $(this).data('total');
				var items = $(this).data('items');
				var supplier = $(this).data('supplier');
				var supplierid = $(this).data('spid');
				var orderid = $(this).data('id');
				
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>Purchase_order/getOutletPayment",
					data: {outletid: outletid},
					dataType: 'JSON',
					success:function(data){
							$('#paid_by').html(data.payment);
							
							$('.modal #final_payable_amt').text(total);
							$('.modal #totalamount1').val(total);

							$('.modal #final_purchased_item').text(items);
							$('.modal #supplier').text(supplier);
							$('.modal #supplier').val(supplier);
							$('.modal #orderid').val(orderid);
							$('.modal #supplierid').val(supplierid);
							$('.modal #final_total_payable').val(total);
							$('.modal #final_total_qty').val(items);
							$('.modal #outletid').val(outletid);
							$('.modal #outletname').val(outletname);
							$("#timepicker4Modal").modal("show");
						}
				 });
				 
			});
        });


        function chkReturn(ele) {
		
            var total_paid = parseFloat($('#paid').val());
			if (isNaN(total_paid)) {
                total_paid = 0;
            }
					
            change_amt = (parseFloat(total_paid));
			
            document.getElementById("returned_change").value = change_amt.toFixed(2);
            document.getElementById("return_change").innerHTML = change_amt.toFixed(2);
            var balance1 = parseFloat($('#totalamount1').val()) - parseFloat($('.tpaid').val());
            var balance = parseFloat(balance1) - parseFloat(change_amt);
            var balance = balance.toFixed(2);
			$('#lbl_balance').val(balance.toLocaleString());
		
        }
//		function chktotal() {
////			alert('hello');
//			var total_paid = parseFloat($('#paid').val());
//			if (isNaN(total_paid)) {
//                total_paid = 0;
//            }
//					
//            change_amt = (parseFloat(total_paid));
//			document.getElementById("returned_change").value = change_amt.toFixed(2);
//            document.getElementById("return_change").innerHTML = change_amt.toFixed(2);
//            var balance1 = parseFloat($('#totalamount1').val()) - parseFloat($('.tpaid').val());
//            var balance = parseFloat(balance1) - parseFloat(change_amt);
//            var balance = balance.toFixed(2);
//			$('#lbl_balance').val(balance.toLocaleString());
//			
//			var bal =parseFloat($('#totalamount1').val());
//			var sub_bal = parseFloat($('#tpaid').val());
//			$('#sendBtn').show();	
//			if(bal < sub_bal)
//			{
//				$('#sendBtn').hide();
//			}
//		
//        }


        $("#addPayment").click(function () {
			//chktotal();
            if (confirm('Do you want to add payment ?'))
            {
				
				$('#add-item-loading3').show();
                var row_count = parseInt($('#row_count_hidden').val());
                var tpaid = $('.tpaid').val();
                var paid = $('#paid').val();
                var paid_by = $('#paid_by').val();
				
				var cheque = $('#cheque').val();
				var cheque_date = $('#cheque_da').val();
				var cheque_bank = $('#bank').val();
				var totalamount1 = $('#totalamount1').val();
				var addi_card_numb = $('#addi_card_numb').val();
                var card_numb = $('#card_numb').val(); 
                var customer = $('#supplier').val();
//				var paid_by_val = $("#paid_by option:selected").text();
				var Paymethod = '';
				
			    $.ajax({
                    url: "<?php echo base_url().'purchase_order/get_payment_name'; ?>",
                    type: 'POST',
                    data: {id: paid_by, paid: paid, tpaid: tpaid},
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 2) 
						{
                            $('#outofstockwrp').modal('show');
                            $('#add-item-loading3').hide();
                            document.getElementById("paid").value = 0;
                        } 
						else if (response.status == 1)
                        {
                            $('#add-item-loading3').hide();
                            Paymethod = response.data;
							var		paidAmount = response.paidAmount;
                            var		tpaid1 = +tpaid + +paidAmount;
                            $('.tpaid').val(tpaid1);
							
                            if (paid != 0) 
							{
                                var cell = $('<tr id="row_' + row_count + '"><td><label>' + Paymethod + '</label> <input type="hidden" value="' + paid_by +
                                        '" name="payment['+row_count+'][paid_by]"  />\n\
										<input type="hidden" value="' + cheque +'" name="payment['+row_count+'][cheque]"  /> \n\
										<input type="hidden" value="' + cheque_date +'" name="payment['+row_count+'][cheque_date]"  /> \n\
										<input type="hidden" value="' + cheque_bank +'" name="payment['+row_count+'][cheque_bank]"  /> \n\
											<input type="hidden" value="' + addi_card_numb +
                                        '" name="payment['+row_count+'][addi_card_numb]"   /> <input type="hidden" value="' + card_numb +
                                        '" name="payment['+row_count+'][card_numb]"  /> </td><td><label>' + customer + '</label><input type="hidden" readonly value="' + customer +
                                        '" name="payment['+row_count+'][customer]"  /></td><td><input type="text" readonly value="' + paid +
                                        '" name="payment['+row_count+'][paid]"   /></td><td><i class="glyphicon glyphicon-remove-sign" id="btndelete" onclick="deletedivpay(' + paidAmount + ')" style="color: red; cursor: pointer; font-size: 28px;"></i></td></tr>');
                                $('#addPaymentMethod').append(cell);
                                row_count = row_count + 1;
                                $('#row_count_hidden').val(row_count);
								
					
							   if (parseFloat(tpaid1) > parseFloat(totalamount1)) {
								  	$("#sendBtn").hide();
								} 
								else 
								{
									$("#sendBtn").show();
								}
								
								$('#cheque').val('');
								$('#bank').val('');
								$('#cheque_da').val('');
								$('#voucher').val('');
								$('#card_numb').val('');
								$('#addi_card_numb').val('');
								$('#paid').val('0');
								$('#paid_by').val('');

								$('#ChequeDetail').hide();
								$('#CardDetail').hide();
								$('#GiftCardDetail').hide();
								$('#VocherDetail').hide();
							   
							   
                            }
                        } 
						else
                        {
                            alert('No name available');
                        }
                    }
                });
            }
        });
        function deletedivpay(ele) {

            var removevalue = ele;
            var total_paid = $('.tpaid').val();
            var totalamount = parseFloat($('#totalamount1').val());
            var newtotal = total_paid - removevalue;
            var a = $(".tpaid").val(newtotal);
            var aa = $(".tpaid").val();
            var b = totalamount - aa;

			if (parseFloat(newtotal) > parseFloat(totalamount)) 
			{
				$("#sendBtn").hide();
			} 
			else 
			{
				$("#sendBtn").show();
			}

            $('#lbl_balance').val(b.toLocaleString());
            $("#paid").val(0);

        }
        $(document).ready(function () {
            $("#addPaymentMethod").on('click', '#btndelete', function () {
                var row_count = $('#row_count_hidden').val();
                row_count = parseInt(row_count) - 1;
                $('#row_count_hidden').val(row_count);
                $(this).closest('tr').remove();

            });
        });


        function save_payment() {
			
			$('#add-item-loading4').show();
			var tpaid = $('#tpaid').val();
			if(tpaid == "" || tpaid == "0")
			{
				$('#add-item-loading4').hide();
				alert('Total Paid amount is zero(0) !!');
			}
			else
			{
				var orderid			= $('#orderid').val();
				var supplier		= $('#supplier').val();
				var supplierid		= $('#supplierid').val();
				var totalamount1	= $('#totalamount1').val();
				var outletid		= $('#outletid').val();
				var outletname		= $('#outletname').val();
					//alpesh
				var cheque_bank		= $('#cheque_bank').val();	
				
				var formData = new FormData();
				var other_data = $('#payment_form').serializeArray();
				$.each(other_data, function (key, input) {
					formData.append(input.name, input.value);
				});
				formData.append('orderid', orderid);
				formData.append('supplier', supplier);
				formData.append('supplierid', supplierid);
				formData.append('totalamount1', totalamount1);
				formData.append('outletid', outletid);
				formData.append('outletname', outletname);
				//alpesh
				formData.append('cheque_bank', cheque_bank);
				
				var row_count = $('#row_count_hidden').val();
				row_count = parseInt(row_count) - 1;
				formData.append('row_count', row_count);

				$.ajax({
					url: "<?php echo base_url(); ?>purchase_order/save_bill_payment",
					type: 'POST',
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'JSON',
					success: function (response) {
						if (response.status == 1)
						{
							$('#add-item-loading4').hide();
							alert(response.message);
							window.location = "<?php echo base_url(); ?>purchase_order/purchase_bills";
						} 
						else
						{
							alert(response.message);
							location.reload();
						}
					}
				});
			}
		}
	</script>

<?php
	require_once 'includes/footer.php';
?>
<script>
	$(document).ready(function () {

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
			order:[1,'desc'],
			responsive: true,
			
		});
	});
</script>