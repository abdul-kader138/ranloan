

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Cheque Manager</h1>
      </div>
   </div>
   <!--/.row-->
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <div class="row" style="margin-top: 0px;">
                  <div class="col-md-12">
                     <div class="table-responsive">
						 <h2>Customer Payment</h2>
                        <table class="table datatable" >
                           <thead>
                              <tr>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Date & Time</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Entry No</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Outlet Name</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Cheque Number</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Cheque Date</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Customer</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Bank Name</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Amount</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Action</th>
									<!--<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Deposit</th>-->
                              </tr>
				           </thead>
                           <tbody>
							   <?php
							   foreach ($getChequeManager as $data)
							   {
								   ?>
								   <tr>
										<td><?=$data->ordered_datetime?></td>
										<td><?=$data->id?></td>
										<td><?=$data->outlet_name?></td>
										<td><?=$data->cheque_number?></td>
										<td><?=$data->cheque_date?></td>
										<td><?=$data->customer_name?></td>
										<td><?=$data->bank?></td>
										<td><?=!empty($data->paid_amt)?number_format($data->paid_amt,2):'0.00'?></td>
										<td>
											<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $data->id; ?>">View</button>
											<div id="myModal<?php echo $data->id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Cheque Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Date & Time</b>
																</div>
																<div class="col-md-8">
																	<?=$data->ordered_datetime?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Customer</b>
																</div>
																<div class="col-md-8">
																	<?=$data->customer_name?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Cheque Number</b>
																</div>
																<div class="col-md-8">
																	<?=$data->cheque_number?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Cheque Date</b>
																</div>
																<div class="col-md-8">
																	<?=$data->cheque_date?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Bank Name</b>
																</div>
																<div class="col-md-8">
																	<?=$data->bank?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Amount</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($data->paid_amt)?number_format($data->paid_amt,2):'0.00'?>
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
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
		  
		  
         <div class="panel panel-default">
            <div class="panel-body">
               <div class="row" style="margin-top: 0px;">
                  <div class="col-md-12">
                     <div class="table-responsive">
						 <h2>Supplier Payment</h2>
                        <table class="table datatable" >
                           <thead>
                              <tr>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Date & Time</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Entry No</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Outlet Name</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Date & Time</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Cheque Number</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Cheque Date</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Supplier</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Bank Name</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Amount</th>
									<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;">Deposit</th>
                              </tr>
				           </thead>
                           <tbody>
							   <?php
							   foreach ($getSupplierCheque as $data)
							   {
								   ?>
								   <tr>
										<td><?=$data->paid_date?></td>
										<td><?=$data->id?></td>
										<td><?=$data->outlet_name?></td>
										<td><?=$data->paid_date?></td>
										<td><?=$data->cheque_number?></td>
										<td><?=$data->cheque_date?></td>
										<td><?=$data->supplier_name?></td>
										<td><?=$data->bank_name?> (Acc No: <?=$data->account_number?>)</td>
										<td><?=!empty($data->paid_amt)?number_format($data->paid_amt,2):0?></td>
										<td>
											<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $data->id; ?>">View</button>
											<div id="myModal<?php echo $data->id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Cheque Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Date & Time</b>
																</div>
																<div class="col-md-8">
																	<?=$data->paid_date?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Supplier</b>
																</div>
																<div class="col-md-8">
																	<?=$data->supplier_name?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Cheque Number</b>
																</div>
																<div class="col-md-8">
																	<?=$data->cheque_number?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Cheque Date</b>
																</div>
																<div class="col-md-8">
																	<?=$data->cheque_date?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Bank Name</b>
																</div>
																<div class="col-md-8">
																	<?=$data->cheque_bank?>
																</div>
															</div>
															
															<div class="row">
																<div class="col-md-4">
																	<b>Deposit</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($data->paid_amt)?number_format($data->paid_amt,2):0?>
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
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   
 
</div>

<script>

   $(document).ready(function() {
   
   $(".datatable").DataTable({
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
					exportOptions:{columns:[0,1,2,3,4,5,6,7,8]},
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