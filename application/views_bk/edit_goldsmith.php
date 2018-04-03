
<?php
require_once 'includes/header.php';
?>


<style>
	label.error{
		color:red;
	}
</style>	

<script>
    $(function () {
        $("#startDate").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });

        $("#endDate").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });
        $("#transfer_date").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });
    });
</script> 





<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit GoldSmith</h1>
		</div>
	</div><!--/.row-->

	<form action="<?=base_url()?>goldsmith/Update_goldsmith" id="add-goldsmith" method="post">
		<div id="message" class="message text-center"></div>
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
									<label>Full Name <span style="color: #F00">*</span></label>
									<input type="text" name="fullname" class="form-control"  maxlength="499" value="<?= !empty($goldsmith->fullname) ? $goldsmith->fullname : ''; ?>" autofocus  autocomplete="off" />
									<input type="hidden" name="edit_id" class="form-control"  maxlength="499" value="<?= !empty($this->input->get('id')) ? $this->input->get('id') : ''; ?>" autofocus  autocomplete="off" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Email Address <span style="color: #F00">*</span></label>
									<input type="email" name="email" class="form-control" readonly=""  maxlength="254" value="<?= !empty($goldsmith->email) ? $goldsmith->email : ''; ?>" autocomplete="off" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Mobile </label>
									<input type="text" name="mobile" class="form-control" maxlength="499" value="<?= !empty($goldsmith->phone) ? $goldsmith->phone : ''; ?>" autofocus autocomplete="off" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Address </label>
									<textarea name="address" id="address" class="form-control" ><?= !empty($goldsmith->address) ? $goldsmith->address : ''; ?></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Land Phone Number<span style="color: #F00">*</span></label>
									<input type="text" name="land" id="land" class="form-control" maxlength="499"  autocomplete="off" value="<?= !empty($goldsmith->land_phone_number) ? $goldsmith->land_phone_number : ''; ?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>DOB</label>
									<input type="text" name="dob" class="form-control" id="endDate"   value="<?= !empty($goldsmith->dob) ? $goldsmith->dob : ''; ?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Employee Number <span style="color: #F00">*</span></label>
									<input type="text" id="emp-num" name="emp-num" class="form-control" maxlength="499"   autocomplete="off" value="<?= !empty($goldsmith->emp_no) ? $goldsmith->emp_no : ''; ?>" />
								</div>
							</div>



							<div class="col-md-6">
								<div class="form-group">
									<label>Opening Gold Qty </label>
									<input type="text" id="OpeningGoldQty" name="openinggoldqty" class="form-control" maxlength="499" autocomplete="off" value="<?= !empty($goldsmith->opening_gold_qty) ? $goldsmith->opening_gold_qty : ''; ?>" />
								</div>
							</div>


						</div>			


						<div class="row">
							<div class="col-md-4">
								<div class="form-group ">
									<input type="submit" class="btn btn-primary text-center" value="Update GoldSmith" />
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>
					</div><!-- Panel Body // END -->
				</div><!-- Panel Default // END -->
			</div><!-- Col md 12 // END -->
		</div><!-- Row // END -->
	</form>
	<a href="<?= base_url(); ?>Gold/Goldsmith" class="btn btn-primary"  style="width: 100px;"> Back</a>


	<br /><br /><br /><br /><br />

</div><!-- Right Colmn // END -->


<?php
require_once 'includes/footer.php';
?>

<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script type="text/javascript">
    $(function () {
        $("#add-goldsmith").validate({
            rules: {
                fullname: "required",
                email: "required",
                land: {
                    required: true,
                    number: true,
                },
                'emp-num': {
                    required: true,
                    number: true,
                },
                'emp-pergram': {
                    required: true,
                    number: true,
                },
            },
            messages: {
                fullname: "Please enter your Full Name",
                email: "Please enter email",
                land: {
                    required: "Please provide a Land Phone",
                    number: "Please provide a Numeric value",
                },
                'emp-num': {
                    required: "Please provide a Employee ",
                    number: "Please provide a Numeric value",
                },
                'emp-pergram': {
                    required: "Please provide a Wastage Per Gram",
                    number: "Please provide a Numeric value",
                },

            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    dataType: "json",
                    success: function (response) {
						if(response.success)
						{
							alert(response.success);
							window.location.href = '<?= base_url() ?>Gold/Goldsmith';
						}
						else
						{
							alert(response.error);
						}
					
                    }
                });

            }
        });
    });









</script>



<!--------------->

