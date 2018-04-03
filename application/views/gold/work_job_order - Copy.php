<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Work Order</h1>
		</div>
	</div><!--/.row-->
	<form action="<?= base_url() ?>productions/insertWork_job" id="" method="post">
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

							<div class="col-md-3">
								<div class="form-group">
									<label>Date <span style="color: #F00">*</span></label>
									<input type="text" name="create_date" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" maxlength="499" autofocus  disabled required autocomplete="off" />

								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Job Order No.<span style="color: #F00">*</span></label>
									<input type="text" name="job_order_no" id="job_order_no" value="<?= $JobOrderNumber ?>" class="form-control" readonly="" required maxlength="254" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Outlet<span style="color: #F00">*</span></label>
									<select name="out"  class="form-control" required autocomplete="off">
									<?php foreach ($outlets as $out): ?>
											<option value="<?php echo $out->id; ?>" ><?php echo $out->name; ?></option>
										<?php endforeach;
										?>
									</select>	
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>GoldSmith<span style="color: #F00">*</span></label>
									<select name="goldsmith"  class="form-control" id="getValuegoldsmith" >
										<option ><?php echo "Choose Goldsmith"; ?></option>
										<?php foreach ($goldsmith as $smith): ?>
											<option value="<?php echo $smith->gs_id; ?>" ><?php echo $smith->fullname; ?></option>
										<?php endforeach;
										?>
									</select>	
									<span style="color: #3333ff; margin-top: 2px;" id="getGoldSmithBalance"></span>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Customer Name.<span style="color: #F00">*</span></label>
									<select name="customer_id" id="changevaluepop" class="form-control"  autocomplete="off">
										<option ><?php echo "Choose Customer"; ?></option>
											<?php foreach ($customer_val as $cus_val): ?>
											<option value="<?php echo $cus_val->id; ?>" ><?php echo $cus_val->fullname; ?></option>
										<?php endforeach;
										?>
									</select>	
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Customer Order No <span style="color: #F00">*</span></label>
									<select name="customer_order_no"  class="form-control getIncompleteOrder"  required="" autocomplete="off">
										<option value="">Select Customer Order</option>
									</select>	
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Product Name (if form Showroom) <span style="color: #F00">*</span></label>
									<select name="product_code" class="form-control product_code" required="" >
										<option value="">Select Product</option>
									</select>
								</div>
							</div>


							<div class="col-md-3">
								<div class="form-group">
									<label>Product Quantity<span style="color: #F00">*</span></label>
									<input type="text" name="product_qty" id="qty" readonly="" class="form-control" value="0"  maxlength="254" autocomplete="off" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Weight – Showroom Product<span style="color: #F00">*</span></label>
									<input type="text" id="weight_bluk_product" readonly="" name="weight_bluk_product" class="form-control"  maxlength="254" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Required weight each product<span style="color: #F00">*</span></label>
									<input type="text" name="weight_each_product" class="form-control"  maxlength="254" autocomplete="off" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Required Qty. <span style="color: #F00">*</span></label>
									<input type="text" name="qty" class="form-control"  maxlength="254" autocomplete="off" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Gold Qty. for Goldsmith <span style="color: #F00">*</span></label>
									<input type="text" name="gold_qty_goldsmith" class="form-control"  maxlength="254" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Item Details <span style="color: #F00">*</span></label>
									<textarea name="item_details" class="form-control"  maxlength="254" autocomplete="off"></textarea>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Alloy Qty for Goldsmith <span style="color: #F00">*</span></label>
									<input type="text" name="alloy_qty_goldsmith" class="form-control"  maxlength="254" autocomplete="off" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Order Delivery Date <span style="color: #F00">*</span></label>
									<input type="text" name="order_delivery_dt" class="form-control" id="endDate"   value="" />
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Created By  <span style="color: #F00">*</span></label>
									<input type="text" name="created_by" class="form-control" value="<?= $logged_name ?>" readonly="">
								</div>
							</div>

							<div class="row">
								<div class="progress" style="height:40px;display:none;">
									<div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
										please wait...
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group " style="padding-left: 15px;">
										<input type="submit" class="btn btn-primary text-center" value="Save" / >
											   <!--<input type="button" class="btn btn-primary text-center" onclick="addothercost()" value="Save & Print" / >-->
									</div>
								</div>
								<div class="col-md-4"></div>
								<div class="col-md-4"></div>
							</div>
						</div><!-- Panel Body // END -->
					</div><!-- Panel Default // END -->
				</div><!-- Col md 12 // END -->
			</div><!-- Row // END -->
	

	<br /><br /><br /><br /><br />
</div><!-- Right Colmn // END -->
</form>

<script type="text/javascript">
	   
    $("#trans-goldproduct").on("submit", function (event) {
        event.preventDefault();
        var formData = $("#trans-goldproduct").serialize();
        $('.progress').css('display', 'block');
        $('#created-cycle-btn').attr('disabled', 'disabled');
        $.ajax({
            url: 'save_production',
            data: formData,
            type: 'POST',
            success: function (data) {
                if (data.error == true)
                {
                    setTimeout(function () {
                        $("#trans-goldproduct").get(0).reset();
                        $("#message").css("visibility", "visible");
                        $("#message").html("<div class='alert alert-success text-center'>Successfully! Added Production</div>");
                        $('.progress').css('display', 'none');
                        $('#created-cycle-btn').removeAttr('disabled', 'disabled');
                        setTimeout(function () {
                            $("#message").css("visibility", "hidden");
                            $("#message").html("");
                            $("input[name=reference]").val('<?= uniqid(); ?>');
                            $("input[name=gpro_name]").val('<?php echo date("Y-m-d H:i:s"); ?>');
                        }, 100);
                    }, 100);
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


<script>
    $('document').ready(function () {
		
		$('.product_code').change(function(){
			var product_code = $(this).val();
			if(product_code!="")
			{
				$.ajax({
					url: "<?=base_url()?>Productions/getProductCodeDetail",
					method: "post",
					dataType: 'json',
					data: {code: product_code},
					success: function (data) {
						$('#weight_bluk_product').val(data.weight);
						$('#qty').val(data.totalQty);
					}
				});
			}
			else
			{
				$('#weight_bluk_product').val('');
				$('#qty').val('0');
			}
		});
		
		
        $('#getValuegoldsmith').change(function () {
			var val = $(this).val();
            $.ajax({
                url: "<?=base_url()?>Productions/getValuegoldsmith",
                method: "post",
                dataType: 'json',
                data: {val: val},
                success: function (data) {
					$("#getGoldSmithBalance").html(data.success);
                }
            });
		});
		
		
		
        $('#changevaluepop').change(function () {
            var id = $(this).val();
            $.ajax({
                url: "get_customer_view",
                method: "post",
                dataType: 'json',
                data: {data: id},
                success: function (data) {
                    if (data)
                    {
                        $(".getIncompleteOrder").html(data.result_data);
                    }
                }
            });
        });
		
		
		$('.getIncompleteOrder').change(function(){
			var id = $(this).val();
            $.ajax({
                url: "<?=base_url()?>Productions/getgoldOrderItem",
                method: "post",
                dataType: 'json',
                data: {data: id},
                success: function (data) {
                    $(".product_code").html(data.success);
                }
            });
		});
		
		
    });
</script>