<?php
    require_once 'includes/header.php';
?>
<script type="text/javascript">
    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Expenses</h1>
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
					
					<div class="row">
						<div class="col-md-6">
							<a href="#holdmodel" data-toggle="modal"  class="btn btn-primary">Add Expense</a>
<!--					<a href="<?php //echo base_url()?>expenses/addNewExpenses" style="text-decoration: none">
								<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>Add New Expenses</button>
						</a>-->
						</div>
						<div class="col-md-6" style="text-align: right;">
							<?php
                                if ($user_role < 3) {
							?>
<!--							<a href="<?php //echo base_url()?>expenses/exportExpenses" style="text-decoration: none;">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">Export</button>
							</a>-->
							<?php
                                }
                            ?>
						</div>
					</div>
					
					<form action="" method="get" style="margin-top: 7px;">
						<div class="row">
							<div class="col-md-2">
<!--								<div class="form-group">
									<label>Expenses Number</label>
									<input type="text" name="expenses_numb" value="<?=!empty($this->input->get('expenses_numb'))?$this->input->get('expenses_numb'):''?>"  class="form-control">
								</div>-->
							</div>
							
							
							<div class="col-md-2">
<!--								<div class="form-group">
									<label>Outlet</label>
									<select name="outlet" class="form-control">
										<option value="">All Outlets</option>
										<?php	
//										foreach ($getOutlet as $values) { 
//											$selected = '';
//											if(!empty($this->input->get('outlet')))
//											{
//												if($values->id == $this->input->get('outlet'))
//												{
//													$selected = 'selected';
//												}
//											}
											?>
											<option <?php //echo $selected;?> value="<?php //echo $value->id;?>"><?php //echo $value->name; ?></option>
										<?php // } ?>
									</select>
								</div>-->
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Expenses Category</label>
									<select name="search_category" class="form-control">
										<option value="">Select Category</option>
										<?php
										foreach ($sExpData as $value) { 
											$selected = '';
											if(!empty($this->input->get('search_category')))
											{
												if($value->id == $this->input->get('search_category'))
												{
													$selected = 'selected';
												}
											}
											?>
										<option <?php echo $selected;?> value="<?php echo $value->id;?>"><?php echo $value->name; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Date From</label>
									<input type="text" name="start_date" class="form-control" id="startDate" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" style="height: 35px" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Date To</label>
									<input type="text" name="end_date" class="form-control" id="endDate" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" style="height: 35px" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br>
									<button class="btn btn-primary" style="width: 100%;">Search</button>
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
											<th width="10%">Expenses No.</th>
											<th width="10%">Expenses Category</th>
											<th width="10%">Outlet</th>
											<th width="10%">Payment Type</th>
											<th width="10%">Expense Bill Date</th>
											<th width="10%">Date</th>
											<th width="10%">Amount (<?php echo $site_currency; ?>)</th>
											<th width="5%">Action</th>
										</tr>
								    </thead>
									<tbody>
									<?php
									$TotalExpenseAmount = 0;
									foreach ($results as $data) {
										$TotalExpenseAmount = $TotalExpenseAmount + $data->amount;
										$id				= $data->id;
										$number			= $data->expenses_number;
										$outlet_id		= $data->outlet_id;
										$amount			= $data->amount;
										$date			= date("$setting_dateformat", strtotime($data->date));
										$transation_date= $data->transation_date=='0000-00-00'?$data->transation_date:(date('d-m-Y',strtotime($data->transation_date)));
										$exp_cat_name	= $data->expense_categories_name;
										$paymentname	= $data->paymentname;
										$outlet_name	= $data->outletname; ?>
										<tr>

											<td><?php echo $number; ?></td>
											<td><?php echo $exp_cat_name; ?></td>
											<td><?php echo $outlet_name; ?></td>
											<td><?php echo $paymentname; ?></td>
											<td><?php echo $transation_date; ?></td>
											<td><?php echo $date; ?></td>
											<td><?=!empty($amount)?number_format($amount, 2):'0.00'; ?></td>
											<td>
												<button class="btn btn-primary PopupExpenses" id="<?php echo $id; ?>" style="padding: 4px 12px; width: 80px;" >Action</button>
											</td>
											<div id="myModalData<?php echo $id; ?>" class="modal fade" role="dialog">
															<div class="modal-dialog">
																<!-- Modal content-->
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Choose Your Action</h4>
																	</div>
																	<div class="modal-body">
																		<ul style="list-style-type:none; text-align:center;">
																				<li>
																					<button class="btn btn-primary oldModelHide" style="width: 80px;" id="<?php echo $id; ?>"  data-toggle="modal" data-target="#myModal<?php echo $number; ?>">View</button>
																				</li>
																				<li style="margin-top: 5px;">
																					<a href="<?=base_url()?>expenses/editExpenses?id=<?php echo $id; ?>" style="width: 80px;" class="btn btn-primary">Edit</a>
																				</li>
																				
																				<li style="margin-top: 5px;">
																					<a onclick="openReceipt('<?=base_url()?>/expenses/expenses_print?id=<?=$id?>')" class="btn btn-primary" style=" width: 80px; padding: 0px; text-decoration: none; cursor: pointer;" title="Print Receipt">
																						<i class="icono-list" style="color: #ffffff;"></i>
																					</a>
																				</li>
																				<li style="margin-top: 5px;">
																					<a  id="<?= $id ?>"  class="popup_expenses_data btn btn-primary"  style="width: 80px; padding: 0px;text-decoration: none; " title="Delete" >
																							<i class="icono-crossCircle" style="color: #F00"></i>
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
									
												<div class="message-box animated fadeIn " data-sound="alert" id="expenses-signout<?= $id ?>">
														<div class="mb-container">
															<div class="mb-middle">
																<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
																<div class="mb-content">
																	<p>Do you want to delete this Expenses?</p>                    
																	<p>Press No if you want to continue work. Press Yes to Remove current Expenses.</p>

																</div>
																<div class="mb-footer">
																	<div class="pull-right">
																			<a href="<?=base_url()?>expenses/deleteExpenses?id=<?php echo $id; ?>" class="btn btn-success btn-lg" >Yes</a>
																			<a class="btn btn-default btn-lg mb-control-close" >No</a>
																	</div>
																</div>
															</div>
														</div>
													</div>
									
									
									
											<div id="myModal<?php echo $number; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Expense</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Expense No</b>
																</div>
																<div class="col-md-8">
																	<?php echo $number; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Expenses Category</b>
																</div>
																<div class="col-md-8">
																	<?php echo $exp_cat_name; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Outlet</b>
																</div>
																<div class="col-md-8">
																	<?php echo $outlet_name; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Payment Type</b>
																</div>
																<div class="col-md-8">
																	<?php echo $paymentname; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Date</b>
																</div>
																<div class="col-md-8">
																	<?php echo $date; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Expense Bill Date</b>
																</div>
																<div class="col-md-8">
																	<?php echo $transation_date; ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Amount</b>
																</div>
																<div class="col-md-8">
																	<?php echo number_format($amount,2); ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Note</b>
																</div>
																<div class="col-md-8">
																	<?php echo $data->reason; ?>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
										</tr>
									<?php
									}
									?>
									</tbody>
									<tfoot>
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
							
								<div class="row" style="padding-top: 10px; padding-bottom: 10px; margin-top: 50px; font-size: 18px; letter-spacing: 0.5px; border-top: 1px solid #ddd;">
									<div class="col-md-3" style="font-weight: bold;">Total Expense Amount:</div>
									<div class="col-md-9" style="font-weight: bold;">: <?=!empty($TotalExpenseAmount)?number_format($TotalExpenseAmount,2):'0.00'?>
									</div>
								</div>
								<?php
								foreach ($expense_categories as $expense_cat)
								{
								?>
<!--								<div class="row" style="color: #0000cc;padding-top: 10px; padding-bottom: 10px; margin-top: 0px; font-size: 18px; letter-spacing: 0.5px; border-top: 1px solid #ddd;">
									<div class="col-md-12" style="font-weight: bold;"><?=$expense_cat->name?></div>
								</div>-->
							
<!--								<div class="row" style="padding-top: 10px; padding-bottom: 10px; margin-top: 0px; font-size: 18px; letter-spacing: 0.5px;">
									<div class="col-md-3" style="font-weight: bold;">Total Amount.</div>
									<div class="col-md-9" style="font-weight: bold;">: 
									<?php
										$totalExpenseTotal = $this->Expenses_model->CategoryExpenseTotal($expense_cat->id);
										echo !empty($totalExpenseTotal)?number_format($totalExpenseTotal,2):'0.00';
									?>
									</div>
								</div>-->
								<?php 
									}
								?>
							
							
						</div>
						
						
						
						
					</div>
				</div>
			</div>
		</div>
	</div>
	<br /><br /><br />
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
                           <input type="text" name="expense_no" class="form-control" id="expense_no" value="<?=$expensesOrderNumber?>" readonly="" />
                           <div id="expens_error"></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Outlets</label>
                           <select name="Outlets" class="form-control" id="Outlets"  required>
<!--                              <option value="">Choose Outlet</option>-->
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
							<label>Expense Bill Date <span style="color: #F00">*</span></label>
							<input type="text" name="transation_date" class="form-control" id="transation_date" value="<?= date('d-m-Y'); ?>" />
						</div>
					</div>
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
                    
                  </div>
                  <div class="row">
					<div class="col-md-4">
                        <div class="form-group">
                           <label>Payment Type</label>
                           <select name="payment" class="form-control ChangePayment" id="payment"  required>
                              <option value="">Choose payment type</option>
                           </select>
                           <div id="payment_error"></div>
                        </div>
                     </div>
					  
                     <div class="col-md-4">
                        <div class="form-group">
                           <label>Reason</label>
                           <textarea name="Reason" class="form-control" id="Reason"></textarea>
                           <!--                                                        <input type="number" name="Amount" class="form-control" id="Amount"    value="" />-->
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
				   
				   
				   <div class="row">
						<span class="CheckDetail" style="display: none">
							<div class="col-md-4">
								<label>Cheque Number :</label><br>
								<input type="text" tabindex="3"  class="form-control" id="cheque" placeholder="Cheque Number" autocomplete="off" />
							</div>
							<div class="col-md-4">
								<label>Bank :</label>
								<input type="text" name="bank"  id="bank" class="form-control" autocomplete="off" />
							</div>

							<div class="col-md-4">
								<label>Cheque Date :</label>
								<input type="text" id="cheque_date"  class="form-control datepicker" />
							</div>
						</span>
					</div>
				   
				   
               </form>
            </div>
            <div class="modal-footer" style="margin-top: 10px;">
               <input type="submit" name="expense_submit" id="expense_submit"   onclick="save()"  value="Submit" class="btn btn-primary" style="background-color: #3fb618; color: #FFF; border: 0px; padding: 5px 25px; float: right;" />
            </div>
         </div>
      </div>
   </div>
</div>
<?php
    require_once 'includes/footer.php';
?>
<script>
	
	
	$('.ChangePayment').change(function(){
			var paymenttype = $(".ChangePayment option:selected").text();
			if(paymenttype == 'Cheque')
			{
				$('.CheckDetail').show();
			}
			else
			{
				$('#cheque').val('');
				$('#bank').val('');
				$('#cheque_date').val('');
				$('.CheckDetail').hide();
			}
		});
	
	
	
	
	$('.table').delegate('.PopupExpenses','click',function(){
		var id = $(this).attr('id');
		$('#myModalData'+id).modal('show');
	});
		
	$('.table').delegate('.oldModelHide','click',function(){
		var id = $(this).attr('id');
		$('#myModalData'+id).modal('hide');
	});
		
		
		
	$(document).ready(function() {
			$("#Outlets").change();
	});



	function save()
	{
		$('#expense_submit').addClass('disabled');
          $.ajax({
              url : "<?=base_url()?>Expenses/add_expenses_ajax",
              type: "POST",
              data: $('#form').serialize(),
              dataType: "JSON",
              success: function(data)
              {
                  if(data.status) 
                  {
                      $('#holdmodel').modal('hide');
                      $('#expens_error').text("");
                      $('#outlet_error').text("");
                      $('#datee').text("");
                      $('#Amount_error').text("");
                      $('#Category_error').text("");
                      $('#payment_error').text("");
                      $('#Reason_error').text("");
                      $('#entry_no_error').text("");
                      $("#form")[0].reset();

                      window.location.reload();
                  }
                  else
                  {
                      $('#expens_error').text("");
                      $('#outlet_error').text("");
                      $('#datee').text("");
                      $('#Amount_error').text("");
                      $('#Category_error').text("");
                      $('#payment_error').text("");
                      $('#Reason_error').text("");
                      $('#entry_no_error').text("");
   
                      $('#expens_error').html(data['expense_no']);
                      $('#outlet_error').html(data['Outlets']);
                      $('#datee_error').html(data['datee']);
                      $('#Amount_error').html(data['Amount']);
                      $('#Category_error').html(data['Category']);
                      $('#payment_error').html(data['payment']);
                      $('#Reason_error').html(data['Reason']);
                      $('#entry_no_error').html(data['entry_no']);
                  }
              }
          });
      }
	  
	  
	  
	  $('#Outlets').change(function(){
			var outletid = $(this).val();
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Expenses/ChangePaymentOutlet",
				data: {outletid: outletid},
				dataType: 'JSON',
				success:function(data){
					$('#payment').html(data.payment);
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
					footer: true,
				},
				{
					extend: "pageLength",
				},
			],
			 order:[0,"desc"],
			responsive: true,
			"footerCallback": function ( row, data, start, end, display ) {
			var api = this.api(), data;
			$( api.table().column(6).footer() ).html("<strong>"+addCommas(api.column( 6, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
			
		}
				
		});
	  
	  
	  $(document).ready(function() { 
	  	$("#transation_date").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
			
        });
	  
	  	$(".modal").delegate(".popup_expenses_data", "click", function(){
				 	var id = $(this).attr('id'); 
					$('#expenses-signout'+id).modal('show');
					
			   });
		   });
	</script>