
<style>
	label.error{
		color:red;
	}
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Assign Warehouse</h1>
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
					$code = uniqid();
					?>
					<form action="#" id="trans-goldproduct" method="post">
						<div id="message" class="message text-center"></div>

						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Date <span style="color: #F00">*</span></label>
									<input type="text" name="gpro_name" class="form-control" value="<?php echo date('Y-m-d'); ?>"
										   maxlength="499" autofocus  disabled required autocomplete="off" />
									<input type="hidden" name="gpro_name" class="form-control"  maxlength="499" autofocus   required autocomplete="off"  value="<?php echo date('Y-m-d'); ?>" />
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="form-group">
									<label>Outlet<span style="color: #F00">*</span></label>
									<select name="out" onchange="get_store()" class="form-control"  autocomplete="off">
										<option value="" >Select Outlet</option>
										<?php foreach ($outlets as $out) { ?>
											<option value="<?php echo $out->id; ?>" ><?php echo $out->name; ?></option>
										<?php }
										?>
									</select>	
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Receiving Store<span style="color: #F00">*</span></label>
									<select name="ware[]" multiple id="ware" class="form-control"  autocomplete="off">
										<?php foreach ($warehouse as $ware) { ?>
											<option value="<?php echo $ware->s_id; ?>" ><?php echo $ware->s_name; ?></option>
										<?php }
										?>
									</select>	
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
									<input type="submit" class="btn btn-primary text-center" value="Assign Store" />
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>

					</form>
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12  panel panel-default ">

								<div class="table-responsive">
									<table id="example" class="display" cellspacing="0" width="100%">
										<thead>
											<tr>
												<th width="14%">Date</th>
												<th width="17%">Outlet name</th>
												<th width="30%">Warehouse</th>
											</tr>
										</thead>
										<tbody id="replaceable">
											<?php
											foreach ($outlets as $out):
												?>
												<tr>
													<td><?php echo $out->created_datetime; ?></td>
													<td><?php echo $out->name; ?></td>
													<td>
														<?php foreach ($store_ as $store): ?>
															<?php
															if ($out->id == $store->out_id) {
																echo $store->s_name . "<br>";
																?>
																<?php
															}
														endforeach;
														?>
													</td>
												</tr>
												<?php
											endforeach;
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
<script src="<?=base_url();?>assets/js/jquery.validate.min.js"></script>	

<script type="text/javascript">
	$(function() {
		$('#example').DataTable();
	});
	
$(function() {	
	$("#trans-goldproduct").validate({
		rules: {
			out:"required",
			'ware[]':"required",
			
		},
		messages: {
			out: "Please enter your Outlet name",
			'ware[]': "Please enter your Receiving Store",
			
		},
		submitHandler: function(form) {
			var formData = $("#trans-goldproduct").serialize();
			$('.progress').css('display', 'block');
			$('#created-cycle-btn').attr('disabled', 'disabled');
			var ware = $('#ware').val();
			$.ajax({
				url: 'save_store',
				data: formData,
				type: 'POST',
				success: function (data) {
					if (data.error == true)
					{
						setTimeout(function () {
							$("#trans-goldproduct").get(0).reset();
							$("#message").css("visibility", "visible");
							$("#message").html("<div class='alert alert-success text-center'>Successfully! Assign Store to Outlet Successfully</div>");
							$('.progress').css('display', 'none');
							$('#created-cycle-btn').removeAttr('disabled', 'disabled');
							$('#ware').html('');
							setTimeout(function () {
								$("#message").css("visibility", "hidden");
								$("#message").html("");
								get_outlet_store();
							}, 1000);
						}, 1000);
					} else
					{
						$('.progress').css('display', 'none');
						$("#message").css("visibility", "visible");
						$("#message").html("<div class='alert alert-danger text-center'>" + data.error + "</div>");
						$('#ware').html('');
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
	
	


    function get_store() {
        var val = $('select[name=out]').val();
		if(val != "")
		{
			$.ajax({url: "get_netstore",
				method: "post",
				data: {data: val},
				success: function (data) {
					$("#ware").html(data.message1);
				}
			});
		}
		else
		{
			$('#ware').html('');
		}
        

    }

    function get_outlet_store() {
        var val = $('select[name=out]').val();
        $.ajax({url: "get_outlet_store",
            method: "post",
            data: {data: val},
            success: function (data) {
                $("#replaceable").html(data.message);
            }
        });

    }



</script>





