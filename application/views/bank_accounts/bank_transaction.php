<script type="text/javascript">
   function openReceipt(ele){
   	var myWindow = window.open(ele, "", "width=380, height=550");
   }	
</script>   
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Bank Transaction</h1>
      </div>
   </div>
   <!--/.row-->
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <form action="" method="get">
                  <div class="row" style="margin-top: 10px;">

                     <div class="col-md-3">
						 <div class="form-group">
							 <label>Outlet <span style="color: #cc0000;">*</span> </label>
						   <select name="outlet" required="" class="form-control">
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
				<?php
//				if(!empty($this->input->get('outlet')))
//				{
				?>
               <div class="row" style="margin-top: 0px;">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table class="table" id="datatableBank">
                           <thead>
								<tr>
									<th>Date & Time</th>
									<th>Sr No</th>
									<th>Outlet</th>
									<th>Account Number</th>
									<th>B / F Balance</th>
									<th>Receipt</th>
									<th>Paid</th>
									<th>Balance</th>
									<th>Reconcile</th>
									<th style="color: #ff9900">Action</th>
								</tr>
                           </thead>
                           <tbody>
							   <?php
									$jjj = 1;
									foreach ($getBankBalanceSheet as $data)
									{  
										$color = "";
										if($data->reconcile == 1)
										{
											$color = "#abffab";
										}
										
										$bring_forword = $data->bring_forword;
										$balance = $data->amount;
										
										if($data->trans_type == 'transfer' || $data->trans_type == 'payment_s')
										{  
											$totalbalance = $bring_forword - $balance;
										}
										else
										{
											$totalbalance = $balance + $bring_forword;
										}
										?>
									<tr style="background: <?=$color?>">
										<td><?=date($site_dateformat.' H:i:s a', strtotime($data->created))?></td>
										<td><?=$jjj;?></td>
										<td><?=$data->outletname?></td>
										<td><?=$data->bankaccountnumber?></td>
										<td><?=!empty($bring_forword)?number_format($bring_forword,2):'0.00'?></td>
										<td>
											<?php
												if($data->trans_type != 'transfer' && $data->trans_type != 'payment_s')
												{
													echo !empty($balance)?number_format($balance,2):'0.00';
												}
												else
												{
													echo "0.00";
												}
											?>
										<td>
											<?php
												if($data->trans_type == 'transfer' || $data->trans_type == 'payment_s')
												{ 
													echo !empty($balance)?number_format($balance,2):'0.00';
												}
												else
												{
													echo "0.00";
												}
											?>
										</td>
										<td><?=!empty($totalbalance)?number_format($totalbalance,2):'0.00'?></td>
										<td>
											<?php
											if($data->reconcile == 0)
											{
											?>
												<button data-val="1" id="<?=$data->id?>" style="background-color: #ff9900 !important;" class="btn btn-primary changeReconcile">No</button>
											<?php }
											else
											{ ?>
												<button data-val="0" id="<?=$data->id?>" class="btn btn-primary changeReconcile">Yes</button>
										<?php }
											?>
										</td>
										<td>
											<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $data->id; ?>">View</button>
											
											<a onclick="openReceipt('<?=base_url()?>Bank_accounts/print_bank_transaction?id=<?=$data->id;?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
												<i class="icono-list" style="color: #005b8a;"></i>
											</a>
										</td>
									</tr>
											<div id="myModal<?php echo $data->id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Bank Transaction Detail</h4>
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
																	<b>Sr No</b>
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
																	<?=$data->bankaccountnumber?>
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
																		if($data->trans_type != 'transfer' && $data->trans_type != 'payment_s')
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
																	<b>Paid</b>
																</div>
																<div class="col-md-8">
																	<?php
																	if($data->trans_type == 'transfer' || $data->trans_type == 'payment_s')
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
																	<b>Balance</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($totalbalance)?number_format($totalbalance,2):'0.00'?>
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												  </div>
												</div>
									
									<?php
									$jjj++;
									
											}
							   ?>
						   </tbody>
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
   </div>
    <br /><br /><br />

</div>

<script>
$(document).ready(function() {
	
	
	$('.table').delegate('.changeReconcile','click',function(){
			var id = $(this).attr('id');
			var value = $(this).attr('data-val');
			$.ajax({
					type:'POST',
					url:"<?=base_url()?>Bank_accounts/changeReconcile",
					data: {id: id,value:value},
					dataType: 'JSON',
					success:function(data){
						alert('Reconcile Successfully Change!!');
						location.reload();
					}
			});
	});
	
   $("#datatableBank").DataTable({
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
				},
				{
					extend: "pageLength",
				},
             ],
			order:[1,"desc"],
			responsive: true,
		
           });
     });
</script>