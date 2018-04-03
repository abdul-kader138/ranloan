
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
			<h1 class="page-header">Add GoldSmith</h1>
		</div>
	</div><!--/.row-->

	<form action="#" id="add-goldsmith" method="post">
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
									<input type="text" name="fullname" class="form-control"  maxlength="499" autofocus  autocomplete="off" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Email Address <span style="color: #F00">*</span></label>
									<input type="email" name="email" class="form-control"  maxlength="254" autocomplete="off" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Mobile </label>
									<input type="text" name="mobile" class="form-control" maxlength="499" autofocus autocomplete="off" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Address </label>
									<textarea name="address" id="address" class="form-control" ></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Land Phone Number<span style="color: #F00">*</span></label>
									<input type="text" name="land" id="land" class="form-control" maxlength="499"  autocomplete="off" value="" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>DOB</label>
									<input type="text" name="dob" class="form-control" id="endDate"   value="<?php echo $url_end = ''; ?>" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Employee Number <span style="color: #F00">*</span></label>
									<input type="text" id="emp-num" name="emp-num" class="form-control" maxlength="499"  autocomplete="off" value="" />
								</div>
							</div>

							<div class="col-md-6" style="display:none;">
								<div class="form-group">
									<label>Wastage Per Gram<span style="color: #F00">*</span></label>
									<input type="text" id="per" name="emp-pergram" class="form-control" maxlength="499" autocomplete="off" value="" />
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Opening Gold Qty </label>
									<input type="text" id="OpeningGoldQty" name="openinggoldqty" class="form-control" maxlength="499" autocomplete="off" value="" />
								</div>
							</div>


						</div>			


						<div class="row">
							<div class="progress" style="height:40px;display:none;">
								<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
									please wait...
                                </div>
                            </div>
							<div class="col-md-4">
								<div class="form-group ">
									<input type="submit" class="btn btn-primary text-center" value="Add New GoldSmith" />
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
	<a href="<?=base_url();?>Gold/Goldsmith" class="btn btn-primary"  style="width: 100px;"> Back</a>


	<br /><br /><br /><br /><br />

</div><!-- Right Colmn // END -->


<?php
require_once 'includes/footer.php';
?>

<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script type="text/javascript">
	$(function() {
		$("#add-goldsmith").validate({
			rules: {
				fullname:"required",
				email: {
					required: true,
					email: true,
					remote: {
                        url: "Checkemail_goldsmith",
                        type: "post"
                     }
				},
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
				email:{
					required: "Please provide a Email",
					remote: "Email already in use!",
				},
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
			submitHandler: function(form) {
				
					var formData = $("#add-goldsmith").serialize();
					$('.progress').css('display', 'block');
					$('#created-cycle-btn').attr('disabled', 'disabled');
					$.ajax({
						url: 'save_goldsmith',
						data: formData,
						type: 'POST',
						success: function (data) {
							if (data.error == true)
							{
								setTimeout(function () {
									$("#add-goldsmith").get(0).reset();
									$("#message").css("visibility", "visible");
									$("#message").html("<div class='alert alert-success text-center'>Successfully! Created GoldSmith</div>");
									$('.progress').css('display', 'none');
									$('#created-cycle-btn').removeAttr('disabled', 'disabled');
									setTimeout(function () {
										$("#message").css("visibility", "hidden");
										$("#message").html("");
									}, 4000);
								}, 4000);
							} else
							{
								$('.progress').css('display', 'none');
								$("#message").css("visibility", "visible");
								$("#message").html("<div class='alert alert-danger text-center'>" + data.error + "</div>");
								setTimeout(function () {
									$("#message").css("visibility", "hidden");
									$("#message").html("");
								}, 4000);
							}
						}
					});
				
				
				
			}
		});
	});









</script>



<!--------------->

