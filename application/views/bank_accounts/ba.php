<script src="<?=base_url()?>assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/datatable/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/datatable/jquery-ui.css">
<script src="<?=base_url()?>assets/datatable/jquery-1.12.4.js"></script>
<script src="<?=base_url()?>assets/datatable/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/datatable/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/datatable/buttons.dataTables.min.css">
<script src="<?=base_url()?>assets/datatable/jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/datatable/sum().js"></script>
<script src="<?=base_url()?>assets/datatable/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/datatable/buttons.html5.min.js"></script>
<script src="<?=base_url()?>assets/datatable/buttons.print.min.js"></script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Bank Accounts</h1>
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
						<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
							<div class="col-md-6">
								<a href="<?= base_url() ?>bank_accounts/addBa" style="text-decoration: none;">
									<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
										<i class="icono-plus"></i> Add Bank Account
									</button>
								</a>
							</div>
							<div class="col-md-6" style="text-align: right;">
								<a href="<?= base_url() ?>bank_accounts/exportBa" style="text-decoration: none;">
									<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
										Export
									</button>
								</a>
							</div>
						</div>
						<?php
					}
					?>

					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-3">
								<div class="form-group">
									<label>Account Number </label>
									<input type="text" name="account_number" value="<?=!empty($this->input->get('account_number'))?$this->input->get('account_number'):''?>"  class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Bank </label>
									<input type="text" name="bank" value="<?=!empty($this->input->get('bank'))?$this->input->get('bank'):''?>"  class="form-control" />
								</div>
							</div>
							<div class="col-md-2">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="text" name="startdate" id="startDate" class="form-control" value="<?=!empty($this->input->get('startdate'))?$this->input->get('startdate'):'' ?>" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="text" name="enddate" id="endDate"  class="form-control" value="<?=!empty($this->input->get('enddate'))?$this->input->get('enddate'):''?>"  />
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
								<table class="table" id="datatable">
									<thead>
										<tr>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">Date Time</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">Account Number</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">Bank Name</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">Branch</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Balance</th>
											<?php if ($user_role == 1) { ?>
												<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd; border-right: 1px solid #ddd;" width="10%">Action</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($getBankAccount as $data)
											{
										?>
											<tr>
												<td><?=date('d-m-Y H:i:s',strtotime($data->created))?></td>
												<td><?=$data->account_number?></td>
												<td><?=$data->bank?></td>
												<td><?=$data->branch?></td>
												<td><?=!empty($data->current_balance)?number_format($data->current_balance,2):0?></td>
												<td>
													<a href="<?= base_url() ?>bank_accounts/editBa?id=<?=$data->id?>" class="btn btn-primary" style="text-decoration: none;">Edit</a>
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
			responsive: true,
			
		});
	});
</script>
 

