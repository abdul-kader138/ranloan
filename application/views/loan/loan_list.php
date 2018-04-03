<?php
   $app = realpath(APPPATH);
   require_once $app . '/views/includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Loans</h1>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
				<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
				<div role="alert" class="alert alert-success">
				   <button data-dismiss="alert" class="close" type="button">
					   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
				   <strong>Well done!</strong>
				   <?= $this->session->flashdata('SUCCESSMSG') ?>
				</div>
				<?php } ?>
         <div class="panel panel-default">
            <div class="panel-body">
               <div class="row" style="margin-top: 20px;">
				   <form method="get">
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;<br /><br /><br /></label>
								<a href="<?=base_url('loan/add_loan')?>" style="width: 100px;" class="btn btn-primary">Add Loan</a>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							   <label>Outlet</label>
								<select class="form-control" name="outlet">
									<option value="">Select Outlet</option>
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
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
							   <label>Start Date</label>
							   <input type="text" value="<?=!empty($this->input->get('startdate'))?$this->input->get('startdate'):''?>" id="startDate" class="form-control" name="startdate">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>End Date</label>
								<input type="text" value="<?=!empty($this->input->get('enddate'))?$this->input->get('enddate'):''?>" id="endDate" class="form-control" name="enddate">
							</div>
						</div>
					
						<div class="col-md-3" style="padding-top: 23px;">
							<button class="btn btn-primary" type="submit"  style="width: 200px;">Search</button>
						</div>
				   </form>
					
                        <div class="col-md-12">
					        <div class="table-responsive">
                                <table class="table" id="datatable">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">id</th>
                                            <th style="text-align: left;" width="20%">Date & Time</th>
                                            <th style="text-align: left;" width="12%">Outlet</th>
                                            <th style="text-align: left;" width="12%">Loan / Settle Form No.</th>
                                            <th style="text-align: left;" width="13%">Loan Amount</th>
                                            <th style="text-align: left;" width="10%">Settle Amount</th>
                                            <th style="text-align: left;" width="13%">User</th>
                                            <th style="text-align: left;" width="20%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php
										foreach ($getLoan as $value) { ?>
											<tr>
												<td style="display: none;"><?=$value->id?></td>
												<td><?=$value->created_at?></td>
												<td><?=$value->outletname?></td>
												<td><?=$value->loan_form_no?></td>
												<td><?=!empty($value->loan_amount)?number_format($value->loan_amount,2):'0.00'?></td>
												<td><?=!empty($value->settle_amount)?number_format($value->settle_amount,2):'0.00'?></td>
												<td><?=$value->fullname?></td>
												<td>
													<button class="btn btn-primary ShowModel" id="<?=$value->id?>">View</button>
													
													<div id="myModal<?=$value->id?>" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">View Loan Detail</h4>
																</div>
																<div class="modal-body">
																	<div class="row">
																		<div class="col-md-4">
																			<b>Date & Time</b>
																		</div>
																		<div class="col-md-8">
																			<?=$value->created_at?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>User</b>
																		</div>
																		<div class="col-md-8">
																			<?=$value->fullname?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Outlet</b>
																		</div>
																		<div class="col-md-8">
																			<?=$value->outletname?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Loan / Settle Form No.</b>
																		</div>
																		<div class="col-md-8">
																			<?=$value->loan_form_no?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Loan Amount</b>
																		</div>
																		<div class="col-md-8">
																			<?=!empty($value->loan_amount)?number_format($value->loan_amount,2):'0.00'?>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-4">
																			<b>Settle Amount</b>
																		</div>
																		<div class="col-md-8">
																			<?=!empty($value->settle_amount)?number_format($value->settle_amount,2):'0.00'?>
																		</div>
																	</div>
																	
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																</div>
															</div>
														</div>
													</div>
													
													
													<button class="btn btn-primary">Print</button>
													<button class="btn btn-primary">E-Mail</button>
													
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
</div>
<?php
   $app = realpath(APPPATH);
   require_once $app . '/views/includes/footer.php';
?>
<script>
     $(document).ready(function() {
		 $('.ShowModel').click(function(){
			var id = $(this).attr('id');
			$('#myModal'+id).modal('show');
		 });
		 
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
					exportOptions:{columns:[0,1,2,3,4,5]},
				},
			],
			order: [0,'desc'],
			responsive: true,
                  
			});
		});

</script>

