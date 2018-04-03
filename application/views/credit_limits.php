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
			<h1 class="page-header">Customer Credit Limits</h1>
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
					<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px;">
						<div class="col-md-12" style="text-align: right;">
							<button class="btn btn-primary CreditLimit">Set Credit Limit</button>
							<button class="btn btn-primary CreditColours">Set Credit Colours</button>
							</div>
					</div>
					
				<div class="row" style="margin-top: 0px;">
				<div class="col-md-12">
					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-6">
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date </label>
									<input name="start_date" id="startDate" class="form-control" value="" type="text">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date </label>
									<input name="end_date" id="endDate" class="form-control" value="" type="text">
								</div>
							</div>
				
							<div class="col-md-2" style="margin-top: 2%">
								<div class="form-group">
									<input id="btnSearch" style="display:block;width: 150px;" name="submit" value="Search" class="btn btn-primary uppercase" type="submit">					
								</div>
							</div>
						</div>
					</form>
							<div class="table-responsive">
								<table class="table" id="datatable">
									<thead>
										<tr>
											<th>Date & Time</th>
											<th>Ref No.</th>
											<th>Customer</th>
											<th>New Credit Limit</th>
											<th>Last Credit Limit</th>
											<th>Current Outstanding</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($getCreditLimit as $value)
										{
											$outstanding = ($this->db->select('sum(unpaid_amt) as total')->from('orders_payment')->where('customer_id', $value->customer_id)->get()->row()->total);
										?>
										<tr>
											<td><?=$value->created_date?></td>
											<td><?=$value->id?></td>
											<td><?=$value->fullname?></td>
											<td><?=!empty($value->new_limit)?number_format($value->new_limit,2):0?></td>
											<td><?=!empty($value->credit_limit)?number_format($value->credit_limit,2):0?></td>
											<td><?=!empty($outstanding)?number_format($outstanding,2):0?></td>
											<td>
												<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?=$value->id?>">View</button>
											</td>
										</tr>
										
										<div id="myModal<?=$value->id?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Date & Time</b>
																</div>
																<div class="col-md-8">
																	<?=$value->created_date?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Ref No.</b>
																</div>
																<div class="col-md-8">
																	<?=$value->id?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Customer</b>
																</div>
																<div class="col-md-8">
																	<?=$value->fullname?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>New Credit Limit</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($value->new_limit)?number_format($value->new_limit,2):0?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Last Credit Limit</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($value->credit_limit)?number_format($value->credit_limit,2):0?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Current Outstanding</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($outstanding)?number_format($outstanding,2):0?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Reason</b>
																</div>
																<div class="col-md-8">
																	<?=$value->reason?>
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
										}
										?>
									</tbody>
								</table>
							</div>

					<div id="CreditLimitModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background-color: #5fc509;">
									<h3 class="modal-title" style="color: #FFF; text-align: left;">Set Limits</h3>
								</div>
								<form id="SetCreditLimitForm"  method="post">
								<div class="modal-body" style="overflow: visible; background-color: #FFF;">
									
										<div class="row">
											<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
												<div class="col-md-4">
													<label>Meter Reset Ref No.</label><br>
													<input type="text"  name="meter_reset_ref_no" class="form-control" value="<?=$getMaxSetLimitid?>" readonly="" />
												</div>

												<div class="col-md-4">
													<label>Date </label>
													<input type="text"   class="form-control" value="<?=date('Y-m-d H:i:s')?>" />
												</div>

												<div class="col-md-4">
													<label>Customer <span style="color: #cc0000;">*</span></label>
													<select class="form-control" required="" name="customer_id" id="find_credit_limit" >
														<option value="">Select Customer</option>
														<?php
														foreach ($getCustomer as $value)
														{ ?>
															<option value="<?=$value->id?>"><?=$value->fullname?></option>
														<?php }
														?>
													</select>
													
												</div>
											</div>
										</div>

									
										<div class="row" style="margin-top: 20px;">
											<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
												<div class="col-md-4">
													<label>Credit Limit </label><br>
													<input type="text"  name="creditlimit" id="creditlimit" class="form-control" value="" readonly="" />
												</div>

												<div class="col-md-4">
													<label>New Limit <span style="color: #cc0000;">*</span></label>
													<input type="text" required="" class="form-control" name="new_limit" />
												</div>

												<div class="col-md-4">
													<?php
													$us_id = $this->session->userdata('user_id');
													$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
													$logged_name = $get_logged_name->fullname;
													?>
													<label>Created By</label>
													<input type="text" readonly="" class="form-control" value="<?=$logged_name?>" />
												</div>
											</div>
										</div>
										<div class="row" style="margin-top: 20px;">
											<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
												<div class="col-md-8">
													<label>Reason </label><br>
													<textarea class="form-control" name="reason" ></textarea>
												</div>
											</div>
										</div>

									
								</div>

								<div class="modal-footer">
									<div class="row">
										<div class="col-md-12" style="text-align: right">
											<button type="submit" id="submitdata" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</div>
							</form>
							</div>
							<!-- Panel Body // END -->
						</div>
						<!-- Panel Default // END -->
					</div>
					
					
					<div id="CreditColoursModal" class="modal fade">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header" style="background-color: #5fc509;">
									<h3 class="modal-title" style="color: #FFF; text-align: left;">Set Credit Colours</h3>
								</div>
								<form id="SetCreditColoursForm" method="post">
								<div class="modal-body" style="overflow: visible; background-color: #FFF;">
									<?php
										foreach ($getCreditColor as $color)
										{
									?>
										<div class="row">
											<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
												<div class="col-md-4">
													<label>Limit %(From)</label><br>
													<input type="text" required="" value="<?=$color->from?>" name="colours[<?=$color->id?>][from]"  class="form-control"  />
													<input type="hidden"  name="colours[<?=$color->id?>][id]" value="<?=$color->id?>"  />
												</div>

												<div class="col-md-4">
													<label>Limit %(To)</label>
													<input type="text" required="" value="<?=$color->to?>"  name="colours[<?=$color->id?>][to]"  class="form-control" />
												</div>
												<div class="col-md-4">
													<label>Change Colour</label>
													<input type="text" required="" value="<?=$color->color?>"  name="colours[<?=$color->id?>][color]" class="form-control jscolor"   />
												</div>
											</div>
										</div>
									<?php
										}
									?>
								</div>

								<div class="modal-footer">
									<div class="row">
										<div class="col-md-6" style="text-align: left;">
											<?php
												$us_id = $this->session->userdata('user_id');
												$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
												$logged_name = $get_logged_name->fullname;
											?>
											<label>Created By</label>
											<input type="text" readonly="" class="form-control" value="<?=$logged_name?>" />
										</div>
										<div class="col-md-6" style="text-align: right;">
											<button type="submit" id="submitdata" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</div>
							</form>
							</div>
							<!-- Panel Body // END -->
						</div>
						<!-- Panel Default // END -->
					</div>
					
					
					
					
				</div>
			</div>
		</div>
	</div>
	<br /><br /><br />
</div>
	</div>
</div>
<?php
require_once 'includes/footer.php';
?>
<script src="<?=base_url();?>assets/js/jscolor.js"></script>

<script>
		
		$('.CreditLimit').click(function(){
			$('#CreditLimitModal').modal('show');
		});
		
		$('.CreditColours').click(function(){
			$('#CreditColoursModal').modal('show');
		});
		
		$('#find_credit_limit').change(function(){
			var customer_id = $(this).val();
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Customers/getCustomerCredit",
				data: {customer_id: customer_id},
				dataType: 'JSON',
				success:function(data){
					$('#creditlimit').val(data.credit);
				}
			 });
		});
		
		
		$('#SetCreditColoursForm').submit(function(e){
			e.preventDefault();
			var formData = new FormData();
			var contact = $(this).serializeArray();
			$.each(contact, function (key, input) {
				formData.append(input.name, input.value);
			});
			
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Customers/SubmitColor",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				success:function(data){
					if(data.success)
					{
						alert('Color Successfully Save!!');
					}
					else
					{
						alert('Due to some error please try again!!');
						location.reload();
					}
				}
			});
			
		});
		
		
		
		$('#SetCreditLimitForm').submit(function(e){
			e.preventDefault();
			var formData = new FormData();
			var contact = $(this).serializeArray();
			$.each(contact, function (key, input) {
				formData.append(input.name, input.value);
			});
			
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Customers/SubmitCreditLimit",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				success:function(data){
					alert('Credit Limit Successfully Save!!');
					location.reload();
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
			order:[1,"desc"],
			responsive: true,
		});
		
</script>
