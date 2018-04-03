<script type="text/javascript">
   function openReceipt(ele){
   	var myWindow = window.open(ele, "", "width=380, height=550");
   }	
</script>   
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo BDT; ?></h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">

					<?php
					$alert_msg = $this->session->userdata('alert_msg');
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
							<div class="col-md-6">
								<a href="<?= base_url() ?>bank_dt/addBdt" style="text-decoration: none;">
									<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
										<i class="icono-plus"></i> Add <?php echo BDT ?>
									</button>
								</a>
							</div>
							<div class="col-md-6" style="text-align: right;">
<!--								<a href="<?= base_url() ?>bank_dt/exportBdt" style="text-decoration: none;">
									<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
										Export
									</button>
								</a>-->
							</div>
						</div>
						<?php
					}
					?>

					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-3">
<!--								<div class="form-group">
									<label>Payment Type</label>
									<select name="payment_type" class="form-control">
										<option value="">Select Payment Type</option>
										<?php
										foreach ($payment_methods as $pay)
										{
											$selected = '';
											if(!empty($this->input->get('payment_type')))
											{
												if($this->input->get('payment_type') == $pay->id)
												{
													$selected = 'selected';
												}
											}
											?>
										<option <?=$selected?> value="<?=$pay->id?>"><?=$pay->name?></option>
										<?php }
										?>
									</select>
								</div>-->
							</div>
							<div class="col-md-3">
<!--								<div class="form-group">
									<label>Select Outlet</label>
									<select name="outlet" class="form-control">
										<option value="">Select Outlet</option>
										<?php
										foreach ($getOutlets as $outlet)
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
								</div>-->
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate"   value="<?=!empty($this->input->get('start_date')) ? $this->input->get('start_date') : ''?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate"   value="<?=!empty($this->input->get('end_date')) ? $this->input->get('end_date') : ''?>" />
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

					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th>Date</th>
											<th>Ref No</th>
											<th>Outlet</th>
											<th>From Account</th>
											<th>To Account</th>
											<th>Deposit Amount(LKR)</th>
											<th>User</th>
											<th>Reason</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($getTransform as $value) 
										{
										?>
										<tr>
											<td><?=date('d-m-Y',strtotime($value->transfer_date))?></td>
											<td><?=$value->id?></td>
											<td><?=$value->outletname?></td>
											<td>
												<?php
												if($value->payment_method == 0)
												{
													echo $this->bdt_model->getPaymentname($value->bank_from);
												}
												else
												{
													echo $this->bdt_model->getBankName($value->bank_from) .' (Account)';
												}
												?>
											</td>
											<td>
												<?php
												if($value->payment_method == 1)
												{
													echo $this->bdt_model->getPaymentname($value->bank_to);													
													
												}
												else
												{
													echo $this->bdt_model->getBankName($value->bank_to).' (Account)';;
												}
												?>
											</td>
											
											<td><?=!empty($value->amount)?number_format($value->amount,2):0?></td>
											<td><?=$value->fullname?></td>
											<td><?=$value->reference?></td>
											<td>
												<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $value->id; ?>">View</button>
												
												<a onclick="openReceipt('<?=base_url()?>Bank_dt/print_bank_transfer?id=<?php echo $value->id; ?>')" style="text-decoration: none; cursor: pointer;" title="Print Receipt">
													<i class="icono-list" style="color: #005b8a;"></i>
												</a>
											</td>
											
										</tr>
										
										<div id="myModal<?php echo $value->id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Bank Deposit / Transfer Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Date</b>
																</div>
																<div class="col-md-8">
																	<?=date('d-m-Y',strtotime($value->transfer_date))?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Ref No</b>
																</div>
																<div class="col-md-8">
																	<?=$value->id?>
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
																	<b>From Account</b>
																</div>
																<div class="col-md-8">
																	<?php
																		if($value->payment_method == 0)
																		{
																			echo $this->bdt_model->getPaymentname($value->bank_from);
																		}
																		else
																		{
																			echo $this->bdt_model->getBankName($value->bank_from) .' (Account)';
																		}
																	?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>To Account</b>
																</div>
																<div class="col-md-8">
																	<?php
																		if($value->payment_method == 1)
																		{
																			echo $this->bdt_model->getPaymentname($value->bank_to);													

																		}
																		else
																		{
																			echo $this->bdt_model->getBankName($value->bank_to).' (Account)';;
																		}
																	?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Deposit Amount</b>
																</div>
																<div class="col-md-8">
																	<?=number_format($value->amount,2)?>
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
																	<b>Reason</b>
																</div>
																<div class="col-md-8">
																	<?=$value->reference?>
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

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br /><br /><br />
</div>

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
			order:[1,"desc"],
            responsive: true,
        });
    });
</script>