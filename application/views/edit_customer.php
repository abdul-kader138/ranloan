<?php
    require_once 'includes/header.php';

    $custDtaData = $this->Constant_model->getDataOneColumn('customers', 'id', $cust_id);

    if (count($custDtaData) == 0) {
        redirect(base_url());
    }
	
    $fullname	= $custDtaData[0]->fullname;
    $email		= $custDtaData[0]->email;
    $mobile		= $custDtaData[0]->mobile;
    $address	= $custDtaData[0]->address;
    $nic		= $custDtaData[0]->nic;
    // start new
	$password	= $custDtaData[0]->password;
	$group_cust	= $custDtaData[0]->customer_group;
	// end new
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Customer : <?php echo $fullname; ?></h1>
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
                        if ($user_role == 1) {
                            ?>
							<div class="row">
								<div class="col-md-12" style="text-align: right;">
									<?php
									if($cust_id != $default_customer_id)
									{
									?>
										<button type="submit" class="btn btn-primary edit_cut_popup_click" style="border: 0px; background-color: #c72a25;">
											Delete Customer
										</button>
									<?php 
									}
									?>
								</div>
							</div>


						<div class="message-box animated fadeIn edit_customer_p" data-sound="alert" id="mb-signout">
							<div class="mb-container">
								<div class="mb-middle">
									<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
									<div class="mb-content">
										<p>Do you want to delete this Customer :<?php echo $fullname; ?>?</p>
										<p>Press No if youwant to continue work. Press Yes to Remove current Customer.</p>

									</div>
									<div class="mb-footer">
										<div class="pull-right">
											<form action="<?=base_url()?>customers/deleteCustomer" method="post">
												<input type="hidden" name="cust_id" value="<?php echo $cust_id; ?>" />
												<input type="hidden" name="cust_fn" value="<?php echo $fullname; ?>" />
												<button type="submit" class="btn btn-success btn-lg" >Yes</button>
												<a class="btn btn-default btn-lg mb-control-close" >No</a>
											</form>

										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
							}
						?>

					<form action="<?=base_url()?>customers/updateCustomer" method="post">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Full Name <span style="color: #F00">*</span></label>
								<input type="text" name="fullname" class="form-control"  maxlength="499" autofocus required autocomplete="off" value="<?php echo $fullname; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Email Address</label>
								<input type="email" name="email" readonly="" class="form-control" maxlength="254" required autocomplete="off" value="<?php echo $email; ?>" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Mobile </label>
								<input type="text" name="mobile" class="form-control"  maxlength="499" autofocus autocomplete="off" value="<?php echo $mobile; ?>" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Address </label>
								<textarea name="address" id="address" class="form-control" ><?php echo $address; ?></textarea>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Customer Group </label>
                                <select class="form-control" name="group" required>
                                	<option value="">--Select Customer Group--</option>
                                	<?php foreach ($group as $key => $value) { ?>
                                		<option <?php if($value->id==$group_cust)echo "selected"; ?> value="<?=$value->id?>"><?=$value->name?></option>
                                	<?php } ?>
                                </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Nic<span style="color: #F00">*</span></label>
								<input type="text" name="nic" class="form-control" maxlength="499"  required autocomplete="off" value="<?php echo $nic; ?>" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Password <span style="color: #F00"></span></label>
								<input type="password" name="password" class="form-control"  maxlength="499" autofocus required autocomplete="off" value="<?php echo $password; ?>" />
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<input type="hidden" name="cust_id" value="<?php echo $cust_id; ?>" />
								<button class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
						</div>
					</div>
				</form>

				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->

			<?php
			$url = (isset($_REQUEST['m']) && $_REQUEST['m']==='app') ? 'appointments':'customers/view';
			?>

			<a href="<?=base_url().$url?>" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;">
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>

		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->


	<br /><br /><br /><br /><br />

</div><!-- Right Colmn // END -->

<?php
    require_once 'includes/footer.php';
?>
<script>
 $(document).ready(function () {
	//popupbox
		$(".edit_cut_popup_click").click(function () {
			 $('.edit_customer_p').modal('show');
		});
				
});
</script>