<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Bank Account : <?=!empty($editBank->account_number)?$editBank->account_number:''?></h1>
		</div>
	</div><!--/.row-->
	
	
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
				
					
					<form action="<?=base_url()?>bank_accounts/updateBa" method="post">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Account Number <span style="color: #F00">*</span></label>
								<input type="text" name="account_number" class="form-control"  maxlength="499" autofocus required autocomplete="off" value="<?=!empty($editBank->account_number)?$editBank->account_number:''?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Bank <span style="color: #F00">*</span></label>
								<input type="text" name="bank" class="form-control" maxlength="254" required autocomplete="off" value="<?=!empty($editBank->bank)?$editBank->bank:''?>" />
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Branch </label>
								<input type="text" name="branch" class="form-control"  maxlength="499" autofocus autocomplete="off" value="<?=!empty($editBank->branch)?$editBank->branch:''?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Opening Balance </label>
								<input type="text" name="current_balance" value="<?=!empty($editBank->current_balance)?$editBank->current_balance:''?>"  class="form-control" maxlength="499" autofocus autocomplete="off" />
							</div>
						</div>
					</div>
									
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="hidden" name="id" value="<?=!empty($editBank->id)?$editBank->id:''?>" />
								<button class="btn btn-primary">Update</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					</form>
					
					
				</div>
			</div>
			
			
			
			<a href="<?=base_url()?>bank_accounts" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div>
	</div>
</div>
	
	
  