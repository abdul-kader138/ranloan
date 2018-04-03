<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Bank Account</h1>
		</div>
	</div>
	<style>
		.validation p{
			color:red;
		}
	</style>
	<form action="<?= base_url() ?>bank_accounts/insertBa" method="post">
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
								<div class="form-group">
									<label>Bank Account <span style="color: #F00">*</span></label>
									<input type="text" name="account_number" class="form-control" value="<?php echo set_value('account_number'); ?>"  maxlength="499" autofocus  autocomplete="off" />
									<span class="validation"><?php echo form_error('account_number'); ?></span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Bank </label>
									<input type="text" name="bank" class="form-control" maxlength="254" autocomplete="off" value="<?php echo set_value('bank'); ?>" />
									<span class="validation"><?php echo form_error('bank'); ?></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Branch </label>
									<input type="text" name="branch" value="<?php echo set_value('branch'); ?>" class="form-control" maxlength="499" autofocus autocomplete="off" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Opening Balance </label>
									<input type="text" name="current_balance" value="<?php echo set_value('current_balance'); ?>" class="form-control" maxlength="499" autofocus autocomplete="off" />
									<span class="validation"><?php echo form_error('current_balance'); ?></span>
								</div>
							</div>
						</div>


						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<button class="btn btn-primary">Add</button>
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>
					</div>
				</div>

				<a href="<?= base_url() ?>bank_accounts" style="text-decoration: none;">
					<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
						<i class="icono-caretLeft" style="color: #FFF;"></i>Back
					</div>
				</a>

			</div>
		</div>
	</form>
</div>


