<?php
require_once 'includes/header.php';
?>

<style>
	label.error{
		color:red;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Gold Grade</h1>
		</div>
	</div><!--/.row-->


	<div id="message" class="message text-center"></div>
	<div class="row">
		<form action="#" id="add-goldsmith" method="post">
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
							<div class="col-md-2">
								<div class="form-group">
									<label>Date & Time <span style="color: #F00"></span></label>
									<input type="text" name="datetime" class="form-control"  maxlength="499" autofocus value="<?php echo date('Y-m-d H:i:s');?>" autocomplete="off" readonly="readonly" />
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Grade Grade <span style="color: #F00">*</span></label>
									<input type="text" name="fullname" class="form-control"  maxlength="499" autofocus  autocomplete="off" />
									<span id="allreadyRegister" style="color: #ff0000"></span>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Gold Purity<span style="color: #F00">*</span></label>
									<input type="number" name="gold_purity" class="form-control"  maxlength="254" autocomplete="off" />
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Created By </label>
									<input type="text" readonly="" value="<?= $logged_name ?>"  class="form-control"   />
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
									<input type="submit" class="btn btn-primary text-center" value="Add Grade" />
								</div>
							</div>
							
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>

					</div>
				</div>

			</div>
		</form>

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<h2 style="margin-top: 0px;">List Gold Grade</h2>
							
						<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
						<div role="alert" class="alert alert-success">
						   <button data-dismiss="alert" class="close" type="button">
							   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
						   <strong>Well done!</strong>
						   <?= $this->session->flashdata('SUCCESSMSG') ?>
						</div>
						<?php } ?>
							
							<form action="" method="get">
							  <div class="row">

								 <div class="col-md-2">
									<div class="form-group">
									   <label>Start Date</label>
									   <input name="start_date" class="form-control" id="startDate" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" type="text">
									</div>
								 </div>
								 <div class="col-md-2">
									<div class="form-group">
									   <label>End Date</label>
									   <input name="end_date" class="form-control" id="endDate"  value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" type="text">
									</div>
								 </div>
								 <div class="col-md-2">
									<div class="form-group">
									   <label>&nbsp;</label><br>
									   <input class="btn btn-primary" value="Get Report" type="submit">
									</div>
								 </div>
							  </div>
						   </form>
							<div class="table-responsive">
								<table class="table" id="datatable">
										<thead>
											<tr>
												<th>Date & Time</th>
												<th>Gold Grade(KT)</th>
												<th>Last Gold Purity</th>
												<th>Current Gold Purity</th>
												<th>Create By</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
												foreach ($getGoldeGrade as $value)
												{ ?>
													<tr>
														<td><?=$value->date_created;?></td>
														<td><?=$value->grade_name;?></td>
														<td><?=number_format($value->last_gold_purity,3)?></td>
														<td><?=number_format($value->gold_purity,3);?></td>
														<td><?=$value->fullname;?></td>
														<td><a href="<?=base_url()?>Gold/Editgrade?id=<?=$value->grade_id?>" class="btn btn-primary">Edit Purity</a></td>
													</tr>
											<?php } ?>
										</tbody>
									</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>


	<br /><br /><br /><br /><br />
</div>

<?php
require_once 'includes/footer.php';
?>
<script src="<?=base_url();?>assets/js/jquery.validate.min.js"></script>	

<script type="text/javascript">
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
			order:[2,"desc"],
            responsive: true,
        });
 
 

	$(function() {

		$("#add-goldsmith").validate({
			rules: {
				fullname:"required",
				gold_purity: {
					required: true,
					number: true,
				},
				
			},
			messages: {
				fullname: "Please enter your Grade Grade",
				gold_purity: {
					required: "Please provide a Gold Purity",
					number: "Please provide a Numeric value",
				},
			},
			submitHandler: function(form) {
				$('#allreadyRegister').html('');
				var formData = $("#add-goldsmith").serialize();
				$('.progress').css('display', 'block');
				$('#created-cycle-btn').attr('disabled', 'disabled');
				$.ajax({
					url: 'save_goldgrade',
					data: formData,
					type: 'POST',
					dataType: 'JSON',
					success: function (data) {
						if (data.suceess == true)
						{
							location.reload();
							setTimeout(function () {
								$("#add-goldsmith").get(0).reset();
								$("#message").css("visibility", "visible");
								$("#message").html("<div class='alert alert-success text-center'>Successfully! Add Grade</div>");
								$('.progress').css('display', 'none');
								$('#created-cycle-btn').removeAttr('disabled', 'disabled');
								setTimeout(function () {
									$("#message").css("visibility", "hidden");
									$("#message").html("");

								}, 4000);
							}, 4000);
						} 
						else if(data.error == true)
						{
							$('.progress').css('display', 'none');
							$('#allreadyRegister').html('Grade allready register!!');
						}
						else
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
});
</script>





