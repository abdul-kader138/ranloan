<script>
   $( function() {
		$( "#startDate" ).datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
   	
		$("#endDate").datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
		
		$( ".datepicker" ).datepicker({
			format: "yyyy-mm-dd",
			todayBtn: "linked",
			autoclose: true
		});
   });
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Account Balance</h1>
      </div>
   </div>
   <!--/.row-->
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
<!--               <div class="row">
                  <div class="col-md-2 pull-right">
                     <div  style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
                        <div class="form-group">
                           <a href="#holdmodel" data-toggle="modal"  style="text-decoration: none;">
                              <div style=" background-color: #5fc509; color: #FFF; text-align: center; font-weight: bold; border-radius: 4px; padding-top: 10px; padding-bottom: 10px; width: 100%;">
                                 Expense							
                              </div>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>-->
               <?php
			      $alert_msg=$this->session->userdata('alert_msg');
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
                  ?>
               <form action="<?=base_url()?>bank_accounts/balance" method="get">
                  <div class="row" style="margin-top: 10px;">
                   <div class="col-md-2">
                        <div class="form-group">
                           <label>Payment Type</label>
						   <select name="payment" class="form-control" id="paid_by">
								<option value="">Select Payment Type</option>
								<?php
								 foreach ($getPaymentMethod as $pay)
								 { 
									$selected = '';
									if(!empty($this->input->get('payment'))) 
									{
										if($this->input->get('payment') == $pay->id)
										{
											$selected = 'selected';
										}
									}
									?>
								<option <?=$selected?> value="<?=$pay->id?>"><?=$pay->name?></option>
								 <?php }
								?>
						   </select>
						</div>
                     </div>
                   <div class="col-md-2">
                        <div class="form-group">
                           <label>Bank Account</label>
						   <select name="bank_id" class="form-control" >
								<option value="">Select Bank Account</option>
								<?php
								 foreach ($bank_account as $bank)
								 { 
									$selected = '';
									if(!empty($this->input->get('bank_id'))) 
									{
										if($this->input->get('bank_id') == $bank->id)
										{
											$selected = 'selected';
										}
									}
									?>
								<option <?=$selected?> value="<?=$bank->id?>"><?=$bank->account_number?></option>
								 <?php }
								?>
						   </select>
						</div>
                     </div>
					  
					  
                     <div class="col-md-2">
						 <div class="form-group">
							 <label>Outlet <span style="color: #cc0000;">*</span> </label>
							 <select name="outlet" id="outlet_id" required="" class="form-control">
						   <?php
							foreach ($getOutlet as $outlet)
							{ 
								$selected = '';
								if(!empty($this->input->get('outlet'))) 
								{
									if($this->input->get('outlet') == $outlet->id)
									{
										$selected = 'selected';
									}
								}
								?>
							   <option <?=$selected?> value="<?=$outlet->id?>"><?=$outlet->name?></option>
						<?php }
						   ?>
						   </select>
						 </div>
				     </div>
                     <div class="col-md-2">
                        <div class="form-group">
                           <label> Start Date</label>
                           <input type="text" name="start_date" class="form-control" id="startDate"     value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):""?>" />
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group">
                           <label> End Date</label>
                           <input type="text" name="end_date" class="form-control" id="endDate"   value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):""?>" />
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

				<input type="hidden" id="paymentValue" value="<?=!empty($this->input->get('payment'))?$this->input->get('payment'):""?>" />
				
				<?php
//				if(!empty($this->input->get('outlet')))
//				{
				?>
               <div class="row" style="margin-top: 0px;">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table" id="datatable">
                           <thead>
                              <tr>
								<th style="display: none;">#</th>
                                <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Date & Time</th>
                                <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Sr No</th>
								<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Bill Amount</th>
                                <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Outlet</th>
                                <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Account Number</th>
                                <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">B / F Balance</th>
                                <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Receipt</th>
                                <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Payment</th>
                                <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Balance</th>
                                <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Action</th>
                              </tr>
                           </thead>
                           <tbody>
							   <?php 
								$TotalReceived = 0;
								$TotalPaid = 0;
								$TotalbalanceSum = 0;
								foreach ($getBalanceSheet as $data)
								{
								
									$bring_forword = $data->bring_forword;
									$balance = $data->amount;
									$expense = !empty($data->expense)?$data->expense:0;
									if($data->trans_type == 'loan' || $data->trans_type == 'return' || $data->trans_type =='transfer')
									{
										$type = $data->trans_type;
										$totalbalance = $bring_forword - $balance;
									}
									else if($data->trans_type == 'payment_s')
									{
										$type = 'Purchase';
										$totalbalance = $bring_forword - $balance;
									}
									else
									{
										$type = '';
										$totalbalance = $balance + $bring_forword;
									}
									
									$finbaltotalbalance = $totalbalance - $expense;
									$TotalbalanceSum = $TotalbalanceSum + $finbaltotalbalance;
									?>
									<tr>
										<td style="display: none;"><?=$data->id?></td>
										<td><?=date($site_dateformat.' H:i:s a', strtotime($data->created))?></td>
										<td><?php
										if($data->settlement_id != 0)
										{
											echo $data->settlement_id.'-';
										}
										?><?=$data->id?></td>
										<td>
											<?php
											if(!empty($data->order_id))
											{
												echo $this->ba_model->getOrderPayment($data->order_id);
											}
											?>
										</td>
										
										<td><?=$data->outletname?></td>
										<td><?php
										if($data->transfer_status == 0) {								
											echo $data->paymenttype;
										}
										else
										{
											$babkaccount =  $this->bdt_model->getAccountNumber($data->account_number);
											echo 'Account No ('.$babkaccount.')';
										}
										?> <?php
										if($type != "")
										{ ?>
											 (<?=ucfirst($type)?>)
										<?php }
										?></td>
										<td><?=!empty($bring_forword)?number_format($bring_forword,2):'0.00'?></td>
										<td>
											<?php
											if($data->trans_type !='transfer' && $data->trans_type !='payment_s')
											{
												$TotalReceived = $TotalReceived + $balance;
												echo !empty($balance)?number_format($balance,2):'0.00';
											}
											else
											{
												echo "0.00";
											}
											?>
										</td>
										<td>
											<?php
											if($data->trans_type =='transfer' || $data->trans_type =='payment_s')
											{
												$TotalPaid = $TotalPaid + $balance;
												echo !empty($balance)?number_format($balance,2):'0.00';
											}
											else
											{
												echo !empty($expense)?number_format($expense,2):'0.00';
											}
											?>
										</td>
										<td><?=!empty($finbaltotalbalance)?number_format($finbaltotalbalance,2):'0.00'?></td>
										<td>
											<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $data->id; ?>">View</button>
											<div id="myModal<?php echo $data->id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Account Balance Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Date & Time</b>
																</div>
																<div class="col-md-8">
																	<?=date($site_dateformat.' H:i:s a', strtotime($data->created))?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Entry No</b>
																</div>
																<div class="col-md-8">
																	<?=$data->id?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Pumper</b>
																</div>
																<div class="col-md-8">
																	<?=$data->pumpername?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Outlet</b>
																</div>
																<div class="col-md-8">
																	<?=$data->outletname?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Account Number</b>
																</div>
																<div class="col-md-8">
																	<?php
																	if($data->transfer_status == 0) {								
																		echo $data->paymenttype;
																	}
																	else
																	{
																		$babkaccount =  $this->bdt_model->getAccountNumber($data->account_number);
																		echo 'Account No ('.$babkaccount.')';
																	}
																	?> <?php
																	if($type != "")
																	{ ?>
																		 (<?=ucfirst($type)?>)
																	<?php }
																	?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>B / F Balance</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($bring_forword)?number_format($bring_forword,2):'0.00'?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Receipt</b>
																</div>
																<div class="col-md-8">
																	<?php
																		if($data->trans_type !='transfer' && $data->trans_type !='payment_s')
																		{
																			echo !empty($balance)?number_format($balance,2):'0.00';
																		}
																		else
																		{
																			echo "0.00";
																		}
																		?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Payment</b>
																</div>
																<div class="col-md-8">
																	<?php
																	if($data->trans_type =='transfer' || $data->trans_type =='payment_s')
																	{
																		echo !empty($balance)?number_format($balance,2):'0.00';
																	}
																	else
																	{
																		echo !empty($expense)?number_format($expense,2):'0.00';
																	}
																	?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Balance</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($finbaltotalbalance)?number_format($finbaltotalbalance,2):'0.00'?>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
								<?php } 
							   ?>
						   </tbody>
						   <tfoot>
							   <tr>
								   <td style="display: none;"></td>
								   
								   <td></td>
								   <td></td>
								   <td></td>
								   <td></td>
								   <td></td>
								   <td></td>
								   <td></td>
								   <td></td>
								   <td></td>
								   <td></td>
							   </tr>
						   </tfoot>
                        </table>
                     </div>
                  </div>
               </div>
				<?php 
//					}
				?>

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
										<td><label style="color:#333333; font-size: 16px;">Total Received:</label> </td>
										<td><label style="color:#333333; font-size: 16px;"><?=!empty($TotalReceived)?number_format($TotalReceived,2):'0.00'?></label></td>
									</tr>
									
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Paid:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($TotalPaid)?number_format($TotalPaid,2):'0.00'?></label></td>
									</tr>
									
<!--									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Balance:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($TotalbalanceSum)?number_format($TotalbalanceSum,2):'0.00'?></label></td>
									</tr>
									-->
								</tbody>
							</table>
						</div>
					<hr>
				</div>
			</div>
		</div>
	   
   </div>
    <br /><br /><br />
<!--   <br /><br /><br />
   <div id="holdmodel" class="modal fade">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header" style="background-color: #5fc509 !important;">
               <h3 class="modal-title" style="color: #FFF;">Add New Expenses</h3>
            </div>
            <div class="modal-body" style="overflow: visible; background-color: #FFF;">
               <form action="#" id="form" >
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Expenes Ref. Number</label>
                           <input type="text" name="expense_no" class="form-control" id="expense_no" value="<?php echo $expensesOrderNumber;?>" readonly="" />
                           <div id="expens_error"></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Outlets</label>
                           <select name="Outlets" class="form-control" id="Outlets"  required>
                              <option value="">Choose Outlet</option>
								<?php
									foreach ($getOutlet as $outlet)
									{ ?>
										<option value="<?=$outlet->id?>"><?=$outlet->name?></option>
								<?php }
								?>
                           </select>
                           <div id="outlet_error"></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Date</label>
                           <input type="text" name="datee" class="form-control datepicker" id="datee" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly="" />
                           <div id="datee_error"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Amount(LKR)</label>
                           <input type="number" name="Amount" class="form-control" id="Amount"    value="" />
                           <div id="Amount_error"></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Expense Category</label>
                           <select name="Category" class="form-control" id="Category"  required>
                              <option value="">Choose Category</option>
							  <?php
								foreach ($expense_categories as $expense)
								{ ?>
									<option value="<?=$expense->id?>"><?=$expense->name?></option>		
							<?php }
							  ?>
                           </select>
                           <div id="Category_error"></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Payment Type</label>
                           <select name="payment" class="form-control" id="payment"  required>
                              <option value="">Choose Category</option>
								<?php
								foreach ($getPaymentMethod as $pay)
								{ ?>
								   <option value="<?=$pay->id?>"><?=$pay->name?></option>
								<?php }
								?>
                           </select>
                           <div id="payment_error"></div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Reason</label>
                           <textarea name="Reason" class="form-control" id="Reason"></textarea>
                           
                           <div id="Reason_error"></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Entry No</label>
                           <input type="text" name="entry_no" class="form-control" id="entry_no"    value="" />
                           <div id="entry_no_error"></div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <div class="modal-footer" style="margin-top: 10px;">
               <input type="submit" name="expense_submit" id="expense_submit"   onclick="save()"  value="Submit" class="btn btn-primary" style="background-color: #3fb618; color: #FFF; border: 0px; padding: 5px 25px; float: right;" />
            </div>
         </div>
      </div>
   </div>-->

</div>

<script>
//	function save()
//	{
//		$('#expense_submit').addClass('disabled');
//		  $.ajax({
//              url : "<?=base_url()?>Bank_accounts/add_expenses_ajax",
//              type: "POST",
//              data: $('#form').serialize(),
//              dataType: "JSON",
//              success: function(data)
//              {
//                  if(data.status) 
//                  {
//                      $('#holdmodel').modal('hide');
//                      $('#expens_error').text("");
//                      $('#outlet_error').text("");
//                      $('#datee').text("");
//                      $('#Amount_error').text("");
//                      $('#Category_error').text("");
//                      $('#payment_error').text("");
//                      $('#Reason_error').text("");
//                      $('#entry_no_error').text("");
//                      $("#form")[0].reset();
//
//                      window.location.reload();
//                  }
//                  else
//                  {
//                      $('#expens_error').text("");
//                      $('#outlet_error').text("");
//                      $('#datee').text("");
//                      $('#Amount_error').text("");
//                      $('#Category_error').text("");
//                      $('#payment_error').text("");
//                      $('#Reason_error').text("");
//                      $('#entry_no_error').text("");
//   
//                      $('#expens_error').html(data['expense_no']);
//                      $('#outlet_error').html(data['Outlets']);
//                      $('#datee_error').html(data['datee']);
//                      $('#Amount_error').html(data['Amount']);
//                      $('#Category_error').html(data['Category']);
//                      $('#payment_error').html(data['payment']);
//                      $('#Reason_error').html(data['Reason']);
//                      $('#entry_no_error').html(data['entry_no']);
//                  }
//              }
//          });
//      }
   $(document).ready(function() {
   
   $('#outlet_id').change(function(){
	   getoutlet();
   });
   	
	function getoutlet() 
	{
		var val = $('#outlet_id').val();
		var payment = $('#paymentValue').val();
		
		$.ajax({
			type:'POST',
			url: "<?php echo base_url(); ?>" + "Bank_accounts/getOutletWiseAmount",
			data: {val: val,payment:payment},
			dataType: 'JSON',
			success:function(data){
				$("#paid_by").html(data.payment);
			}
		 });
		 
	}
	
	getoutlet();
   
   
   
   $("#datatable").DataTable({
             dom: "Bfrtip",
             "bPaginate": true,ordering: true,"pageLength":15,
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
					className: "change btn-primary",
					footer:true,
					exportOptions:{columns:[0,1,2,3,4,5,6,7,8,9,10]},
				},
				{
					extend: "pageLength",
				},
             ],
			order:[0,"desc"],
			responsive: true,
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
//				$( api.table().column(3).footer() ).html("<strong>"+addCommas(api.column( 3, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				$( api.table().column(7).footer() ).html("<strong>"+addCommas(api.column( 7, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				$( api.table().column(8).footer() ).html("<strong>"+addCommas(api.column( 8, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
			}
		
           });
     });
</script>