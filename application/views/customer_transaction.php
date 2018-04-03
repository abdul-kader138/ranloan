<?php
    require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Transaction History for Customer: <?=$customerdetail->fullname?></h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
				<form action="" method="get">
                  <div class="row" style="margin-top: 10px;">

                     <div class="col-md-6">
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
                           <input type="hidden" name="cust_id" class="form-control"   value="<?=!empty($this->input->get('cust_id'))?$this->input->get('cust_id'):""?>" />
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group">
                           <label>&nbsp;</label><br />
                           <button class="btn btn-primary" type="submit" style="width: 100%;">Search</button>
                        </div>
                     </div>
                  </div>
               </form>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
							<div class="table-responsive">
							<table class="table" id="datatable">
                           <thead>
                              <tr>
								 <th style="display: none;">#</th>
                                 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Date & Time</th>
                                 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Serial No</th>
                                 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Outlet</th>
                                 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Account Number</th>
								 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Type</th>
                                 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">B / F Balance</th>
                                 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Paid</th>
                                 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Sales Amount</th>
                                 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Balance</th>
                                 <th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Action</th>
                              </tr>
                           </thead>
                           <tbody>
							   <?php 
							   $bfbalance = 0;
							   $i = 1; 
							   $final_balance = 0;
								foreach ($results as $data)
								{
									$balance = $data->amount;
									$expense = !empty($data->expense)?$data->expense:0;
									if($data->trans_type == 'loan' || $data->trans_type == 'return' || $data->trans_type == 'dep' || $data->trans_type == 'outstanding')
									{
										$type = $data->trans_type;
										$final_balance = $final_balance - $data->amount;
										if($data->paymenttype == 'Cheque')
										{
											$final_balance = $final_balance + $data->amount;
										}
									}
									else
									{
										$type = '';
										$final_balance = $final_balance + $data->amount;
									}

									$finbaltotalbalance = $final_balance - $expense;
									?>
									<tr>
										<td style="display: none;"><?=$i++?></td>
										<td><?=date('Y-m-d H:i:s a', strtotime($data->created))?></td>
										<td><?php
										if($data->settlement_id != 0)
										{
											echo $data->settlement_id.'-';
										}
										?><?=$data->id?></td>
										<td><?=$data->outletname?></td>
										<td><?=$data->paymenttype?>
										<td>
											<?php
											if($data->trans_type == 'payment')
											{
												echo "Payment";
											}
											else if($data->trans_type == 'return')
											{
												echo "Sales Return";
											}
											else if($data->trans_type == 'dep')
											{
												echo "Sales";
											}
											else if($data->trans_type == 'outstanding')
											{
												echo "Open Outstanding";
											}
											else if($data->trans_type == 'loan')
											{
												echo "Loan";
											}
											else if($data->trans_type == 'wd')
											{
												echo "Withdraw";
											}
											?>
											<?php
												if($type != "")
												{ ?>
													(<?=$type?>)
												<?php }
											?>
										</td>
										<td><?=number_format($bfbalance,2)?></td>
										<td>
											<?php
												
												if($data->trans_type != 'dep' && $data->trans_type != 'outstanding')
												{
													echo number_format($balance,2);
												}
												else if($data->paymenttype == 'Cheque' && $data->trans_type == 'dep' )
												{
													echo number_format($balance,2);
												}
												else
												{
													echo '0.00';
												}
											?>
										</td>
										<td><?php
												if($data->trans_type == 'dep' || $data->trans_type == 'outstanding')
												{
													echo number_format($balance,2);
												}
												else
												{
													echo '0.00';
												}
											?>
										</td>
										
										
<!--										<td><?=number_format($balance,2)?></td>-->
										
										<td><?=number_format($finbaltotalbalance,2)?></td>
										<td>
											<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $data->id; ?>">View</button>
										</td>
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
																	<?=date('Y-m-d H:i:s a', strtotime($data->created))?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Serial No</b>
																</div>
																<div class="col-md-8">
																	<?=$data->id?>
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
																	<?=$data->paymenttype?>
																	 <?php
																if($type != "")
																{ ?>
																	(<?=$type?>)
																<?php }
																?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>B / F Balance</b>
																</div>
																<div class="col-md-8">
																	<?=number_format($bfbalance,2)?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Receipt</b>
																</div>
																<div class="col-md-8">
																	<?=number_format($balance,2)?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Expense</b>
																</div>
																<div class="col-md-8">
																	<?=number_format($expense,2)?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Balance</b>
																</div>
																<div class="col-md-8">
																	<?=number_format($finbaltotalbalance,2)?>
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
									if($data->trans_type == 'loan' || $data->trans_type == 'return' || $data->trans_type == 'dep' || $data->trans_type == 'outstanding')
									{
										$bfbalance = $bfbalance - $data->amount;
										if($data->paymenttype == 'Cheque')
										{
											$bfbalance = $bfbalance + $data->amount;
										}
									}
									else
									{
										$bfbalance = $bfbalance + $data->amount;
									}
								}
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
	<a href="<?=base_url()?>customers/view" class="btn btn-primary">Back</a>
	<br /><br /><br />
	<br />
	<br />
</div>
<script>
	
	 $(document).ready(function() {
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
						extend: "print",
						className: "change btn-primary",
					},
					{
						extend: "pageLength",
					},
	              ],
				  order:[0,"desc"],
	              responsive: true,
	            });
	      });
</script>	
	
<?php
    require_once 'includes/footer.php';
?>