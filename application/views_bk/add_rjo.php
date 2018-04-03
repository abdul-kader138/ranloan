<?php
require_once 'includes/header.php';
$uniqid = uniqid();
?>

<style>
	label.error{
		color:red;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Refine Order </h1>
		</div>
	</div>

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
							<div class="col-md-4">
								<div class="form-group">
									<label>Date <span style="color: #F00">*</span></label>
									<input type="text" disabled name="date1" class="form-control"  value="<?php echo date('Y-m-d'); ?>"   autocomplete="off" />

									<input type="hidden" name="date2" class="form-control"  value="<?php echo date('Y-m-d'); ?>"   autocomplete="off" />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Refine Job Order Number <span style="color: #F00">*</span></label>
									<input type="text" disabled name="order" class="form-control"  value="<?php echo $uniqid; ?>"   autocomplete="off" />  
									<input type="hidden" name="job" class="form-control"  value="<?php echo $uniqid; ?>"  required autocomplete="off" />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>GoldSmiths <span style="color: #F00">*</span></label>
									<select name="gold" class="form-control"  autocomplete="off">
										<?php foreach ($goldsmiths as $golds): ?>
											<option value="<?php echo $golds->gs_id; ?>" ><?php echo $golds->fullname; ?>                      
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Outlets<span style="color: #F00">*</span></label>
									<select name="out" onchange="get_store()"  class="form-control"  autocomplete="off">
										<?php foreach ($outlets as $out): ?>
											<option value="<?php echo $out->id; ?>" ><?php echo $out->name; ?></option>
										<?php endforeach; ?>
									</select>	
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Warehouse<span style="color: #F00">*</span></label>
									<select name="ware"  id="ware" class="form-control"  autocomplete="off">
										<?php foreach ($warehouse as $ware): ?>
											<option value="<?php echo $ware->s_id; ?>" ><?php echo $ware->s_name; ?></option>
										<?php endforeach; ?>
									</select>	
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Gold Grade (Kt)<span style="color: #F00">*</span></label>
									<select name="grade" class="form-control" onchange="calculations()"  autocomplete="off">
										<?php foreach ($grades as $grade): ?>
											<option value="<?php echo $grade->grade_name; ?>" ><?php echo $grade->grade_name; ?> kt</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Gold Weight (g)<span style="color: #F00">*</span></label>
									<input type="number" name="weight" onkeyup="calculations()"  id="weight" class="form-control"  maxlength="254" autocomplete="off" />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Net Gold weight (g) in 24 kt – Estimated<span style="color: #F00">*</span></label>
									<input type="text" name="total" id="total" class="form-control"  maxlength="499" autofocus  autocomplete="off" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="progress" style="height:40px;display:none;">
								<div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
									please wait...
                                </div>
                            </div>
							<div class="col-md-4">
								<div class="form-group ">
									<input type="submit" id="created-btn" class="btn btn-primary text-center" value="Add Refine order" / >
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
				gold:"required",
				out:"required",
				ware:"required",
				grade:"required",
				weight: {
					required: true,
					number: true,
				},
				total:"required",
				
			},
			messages: {
				gold: "Please enter your goldSmiths",
				out: "Please enter your outlets",
				ware: "Please enter your warehouse",
				grade: "Please enter your gold grade",
				weight:{
					required: "Please provide a gold weight",
					number: "Please provide a Numeric value",
				},
				total:"Please enter your estimated",
			
				
			},
			submitHandler: function(form) {
				
				var formData = $("#add-goldsmith").serialize();
				$('.progress').css('display', 'block');
				$('#created-cycle-btn').attr('disabled', 'disabled');
				$.ajax({
					url: 'save_addrjo',
					data: formData,
					type: 'POST',
					success: function (data) {
						if (data.error == true)
						{
							setTimeout(function () {
								$("#add-goldsmith").get(0).reset();
								$("#message").css("visibility", "visible");
								$("#message").html("<div class='alert alert-success text-center'>Successfully! Created Refined Job order</div>");
								$('.progress').css('display', 'none');
								$('#created-btn').removeAttr('disabled', 'disabled');
								setTimeout(function () {
									$("#message").css("visibility", "hidden");
									$("#message").html("");
								}, 400);
							}, 400);
						} else
						{
							$('.progress').css('display', 'none');
							$("#message").css("visibility", "visible");
							$("#message").html("<div class='alert alert-danger text-center'>" + data.error + "</div>");
							setTimeout(function () {
								$("#message").css("visibility", "hidden");
								$("#message").html("");
							}, 400);
						}
					}
				});

			}
	
		});
	});
	
    function get_price() {
        var val = $('select[name=grade]').val();
        $.ajax({url: "get_price",
            method: "post",
            data: {data: val},
            success: function (data) {
                $("#price").val('');
                $("#price").val(data.message.grade_price);
            }
        });

    }

    function calculations() {
		var price = $('select[name=grade]').val();
		var weight = $("#weight").val();
        if (weight.length > 0) {
            var result = (price / 24) * weight;
            $("#total").val('');
            $("#total").val(result.toFixed(2));
        }
    }


    function get_store() {
        var val = $('select[name=out]').val();
        $.ajax({url: "get_netstore",
            method: "post",
            data: {data: val},
            success: function (data) {
                $("#ware").html(data.message1);
            }
        });
    }

</script>





