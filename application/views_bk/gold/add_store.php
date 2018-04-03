<style>
	.error{
		color:red !important;
	}
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Warehouse</h1>
		</div>
	</div>
	<form action="#" id="trans-goldproduct" method="post">
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
									<input type="text" name="gpro_name" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>"
										   maxlength="499" autofocus  disabled required autocomplete="off" />
									<input type="hidden" name="gpro_name" class="form-control"  maxlength="499" autofocus    autocomplete="off"  value="<?php echo date('Y-m-d H:i:s'); ?>" />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Warehouse<span style="color: #F00">*</span></label>
									<input type="text" name="store" class="form-control"  maxlength="499" autofocus    autocomplete="off" />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Address<span style="color: #F00">*</span></label>
									<input type="text" name="address" class="form-control"  maxlength="499" autofocus    autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Contact No<span style="color: #F00">*</span></label>
									<input type="text" name="contact" class="form-control"  maxlength="499" autofocus    autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Stock<span style="color: #F00">*</span></label>
									<input type="text" name="stock" class="form-control"  maxlength="499" autofocus    autocomplete="off" />
								</div>
							</div>
							<?php
							
							if($getBulkStoreCount == 0)
							{
							?>
							<div class="col-md-4">
								<div class="form-group">
									<label style="margin-top:15px;">Bulk Store</label>
									<br />
									<input type="checkbox" id="changeStatusBulk" value="0" name="bulk_status" />
								</div>
							</div>
							<?php }
							?>
						</div>
						
						<div class="row">
							<div class="progress" style="height:40px;display:none;">
								<div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
									please wait...
                                </div>
                            </div>
							<div class="col-md-4">
								<div class="form-group ">
									<input type="submit" class="btn btn-primary text-center" value="Add Warehouse" />
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>
						
					</div>
				</div>
				
				<a style="width: 100px;" href="<?=base_url();?>Store/warehouse_list" class="btn btn-primary">Back</a>
			</div>
		</div>
	</form>
</div>


<script src="<?=base_url();?>assets/js/jquery.validate.min.js"></script>	

<script type="text/javascript">
	
	
$(function() {
	
$('#changeStatusBulk').on('change', function(){
   this.value = this.checked ? 1 : 0;
});
	  
	  
	$("#trans-goldproduct").validate({
		rules: {
			store:"required",
			address:"required",
			contact: {
				required: true,
				number: true,
			},
			stock:{
				required: true,
				number: true,
			},
		},
		messages: {
			store: "Please enter your warehouse name",
			address: "Please enter your address",
			contact: {
				required: "Please provide a contact",
				number: "Please provide a Numeric value",
			},
			stock: {
				required: "Please provide a stock",
				number: "Please provide a Numeric value",
			},
			
		},
		submitHandler: function(form) {
			
			 var formData = $("#trans-goldproduct").serialize();
        $('.progress').css('display', 'block');
        $('#created-cycle-btn').attr('disabled', 'disabled');
        $.ajax({
            url: 'save_wherehouse',
            data: formData,
            type: 'POST',
            success: function (data) {
                if (data.error == true)
                {
                    setTimeout(function () {
                        $("#trans-goldproduct").get(0).reset();
                        $("#message").css("visibility", "visible");
                        $("#message").html("<div class='alert alert-success text-center'>Successfully! Add Warehouse Successfully</div>");
                        $('.progress').css('display', 'none');
                        $('#created-cycle-btn').removeAttr('disabled', 'disabled');
                        setTimeout(function () {
                            $("#message").css("visibility", "hidden");
                            $("#message").html("");
                        }, 1000);
                    }, 1000);
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
	

    function get_store() {

        var val = $('select[name=out]').val();
        event.preventDefault();
        $.ajax({url: "get_netstore",
            method: "post",
            data: {data: val},
            success: function (data) {
                $("#ware").html(data.message1);
            }
        });

    }



</script>





