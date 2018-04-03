<link href="<?php echo base_url()?>assets/js/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery-confirm.min.css">
<script src="<?php echo base_url()?>assets/js/jquery-confirm.min.js"></script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<form action="" id="InsertRecordInTable" method="post">
	<div class="row">
		<div class="col-lg-12">
			<div class="col-lg-6">
					<h1 class="page-header">Create Work Order</h1>
			</div>
			
			<div class="col-lg-3">
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
			
			<div class="col-lg-3">
				<div class="form-group">
					<label>Goldsmith<span style="color: #F00">*</span></label>
					<select name="goldsmith" required=""  class="form-control" id="getValuegoldsmith" >
							<option value="">Choose Goldsmith</option>
								<?php foreach ($goldsmith as $smith): ?>
									<option value="<?php echo $smith->gs_id; ?>" ><?php echo $smith->fullname; ?></option>
								<?php endforeach;
							?>
						</select>	
					<span style="color: #3333ff; margin-top: 2px;" id="getGoldSmithBalance"></span>
				</div>
			</div>
			
		</div>
	</div>
	<!--<form action="<?= base_url() ?>productions/insertWork_job" id="" method="post">-->
	
		<div id="message" class="message text-center"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Date <span style="color: #F00">*</span></label>
									<input type="text" name="create_date" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" maxlength="499" autofocus  disabled required autocomplete="off" />
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Work Order No.<span style="color: #F00">*</span></label>
									<input type="text" name="job_order_no" id="job_order_no" value="<?= $JobOrderNumber ?>" class="form-control" readonly="" required maxlength="254" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Order Delivery Date <span style="color: #F00">*</span></label>
									<input type="text" name="order_delivery_dt" class="form-control order_delivery_dt" id="endDate"  required=""  value="" />
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Note</label>
									<textarea name="item_details" class="form-control" ></textarea>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Created By  <span style="color: #F00">*</span></label>
									<input type="text" name="created_by" class="form-control" value="<?= $logged_name ?>" readonly="">
								</div>
							</div>
						</div>
						<hr />
						<div class="row">
							
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Customer Order No <span style="color: #F00">*</span></label>
									<select name="customer_order_no"  class="form-control getIncompleteOrder"  required="" autocomplete="off">
										<option value="">Select Order</option>
										<?php
											foreach ($UnCompleteOrder as $order)
											{ ?>
										<option data-val="<?=$order->gold_customer_id?>" value="<?=$order->gold_id?>"><?=$order->gold_id?></option>	
										<?php	}
										?>
									</select>	
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Select Customer <span style="color: #F00">*</span></label>
									<select name="customer_id"  id="changevaluepop" class="form-control SelectCustomer"  required autocomplete="off">
										<option value="">Choose Customer</option>
									</select>	
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Select Item <span style="color: #F00">*</span></label>
									<select name="product_code" class="form-control SelectItem" required="" >
										<option value="">Select Item</option>
									</select>
								</div>
							</div>

							<div class="col-md-1">
								<div class="form-group">
									<label>Qty<span style="color: #F00">*</span></label>
									<input type="text" name="product_qty" id="qty" readonly="" class="form-control qty" value="0"  maxlength="254" autocomplete="off" />
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Required Qty. <span style="color: #F00">*</span></label>
									<input type="text" name="qty" required class="form-control RequiredQty"  maxlength="254" autocomplete="off" />
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Weight – Showroom Product<span style="color: #F00">*</span></label>
									<input type="text" id="weight_bluk_product" readonly="" name="weight_bluk_product" class="form-control WeightShowroomProduct"  maxlength="254" autocomplete="off" />
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Required Unit Weight(g) <span style="color: #F00">*</span></label>
									<input type="text" required name="weight_each_product" class="form-control RequiredUnitWeight"  maxlength="254" autocomplete="off" />
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Gold Qty. for Goldsmith in 22 kt (g)<span style="color: #F00">*</span></label>
									<input type="text" required="" name="gold_qty_goldsmith" class="form-control GoldQtyforGoldsmith"  maxlength="254" autocomplete="off" />
								</div>
							</div>
							

<!--							<div class="col-md-2">
								<div class="form-group">
									<label>Alloy Qty for Goldsmith <span style="color: #F00">*</span></label>
									<input type="text" required name="alloy_qty_goldsmith" class="form-control AlloyQtyforGoldsmith "  maxlength="254" autocomplete="off" />
								</div>
							</div>-->
							
							<div class="col-md-1">
								<div class="form-group" id="images" style="border: 2px saddlebrown solid; height: 70px;">
									
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<button style="width: 100px;margin-top: 29px;" type="submit" class="btn btn-primary">Add</button>
								</div>
							</div>
						</div>
						<hr >
						<div class="row">
							<div class="col-md-12">
								<table class="table" id="items">
									<thead>
										<tr>
											<th>Item & Code</th>
											<th>Qty</th>
											<th>Required Qty</th>
											<th>Current Weight</th>
											<th>Unit Weight (g)</th>
											<th>Gold Qty. for Goldsmith in 22 kt (g)</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="getRecord">
										
									</tbody>
									<tfoot>
										<tr>
											<td><label style="margin-top: 10px;">Total</label></td>
											<td><input type="text" value="0" name="TotalQty"				readonly=""		class="form-control TotalQty"></td>
											<td><input type="text" value="0" name="TotalRequiredQty"		readonly=""		class="form-control TotalRequiredQty"></td>
											<td><input type="text" value="0" name="TotalCurrentWeight"		readonly=""		class="form-control TotalCurrentWeight"></td>
											<td><input type="text" value="0" name="TotalUnitWeight"			readonly=""		class="form-control TotalUnitWeight"></td>
											<td><input type="text" value="0" name="TotalGoldforGoldsmith"	readonly=""		class="form-control TotalGoldforGoldsmith"></td>
											<td></td>
										</tr>
									</tfoot>
								</table>
							</div>
							<div class="col-md-12" style="text-align: right;">  
								<button type="button" class="btn btn-primary" id="SubmitForm">Submit</button>
							</div>
						</div>
						
					
					</div>
				</div>
					<br /><br /><br /><br /><br />
			</div>
	


</div>
</form>
	
<script src="<?php echo base_url()?>assets/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.fancybox.js?v=2.1.5"></script>
	
<script type="text/javascript">
	  
$('document').ready(function () {
	 var row_item = 1;
	 
	 $('#SubmitForm').click(function(e) {
		e.preventDefault();
		var TotalQty = $('.TotalQty').val();
		if(TotalQty == 0 || TotalQty == "")
		{
			alert ("Please add at least one item!!");
		}
		else
		{
			 
			$.confirm({
				title: 'Confirm Save!',
				content: 'Are you confirm!',
				buttons: {
					confirm: function () {
							var formData = new FormData();
							var contact = $('#InsertRecordInTable').serializeArray();
							$.each(contact, function (key, input) {
								formData.append(input.name, input.value);
							});

							$.ajax({
								type:'POST',
								url:"<?=base_url();?>productions/insertWork_job",
								data: formData,
								cache: false,
								contentType: false,
								processData: false,
								dataType: 'JSON',
								success:function(data)
								{
				//					alert('Work Order Successfully Save!!');
									window.location.href = '<?= base_url() ?>productions/all_work_job_order';
								}
							});
					},
					cancel: function () {
						$.alert('Canceled!');
					},

				}
			});
		}
		 
	 });
	  
    $("#InsertRecordInTable").on("submit", function (event) {
			event.preventDefault();
			
			var SelectItemid = $('.SelectItem').val();
			var SelectItem = $(".SelectItem option:selected").text();
			var qty = $('.qty').val();
			var RequiredQty1 = $('.RequiredQty').val();
			var RequiredQty = parseFloat(RequiredQty1).toFixed(2);
			var WeightShowroomProduct1 = $('.WeightShowroomProduct').val();
			var WeightShowroomProduct = parseFloat(WeightShowroomProduct1).toFixed(2);
			var RequiredUnitWeight1 = $('.RequiredUnitWeight').val();
			var RequiredUnitWeight = parseFloat(RequiredUnitWeight1).toFixed(2);
			var GoldQtyforGoldsmith1 = $('.GoldQtyforGoldsmith').val();
			var GoldQtyforGoldsmith = parseFloat(GoldQtyforGoldsmith1).toFixed(2);
			var html = '';
			html+='<tr class="dynamic_row" id="item_row_'+row_item+'" >\n\
						<td><input name="workjob['+row_item+'][SelectItemid]" value='+SelectItemid+' type="hidden"> '+SelectItem+'</td> \n\
						<td><input name="workjob['+row_item+'][qty]"					class="form-control calqty"						readonly	type="text" value='+qty+' ></td> \n\
						<td><input name="workjob['+row_item+'][RequiredQty]"			class="form-control calRequiredQty"				readonly	type="text" value='+RequiredQty+' ></td> \n\
						<td><input name="workjob['+row_item+'][WeightShowroomProduct]"	class="form-control calWeightShowroomProduct"	readonly	type="text" value='+WeightShowroomProduct+' ></td> \n\
						<td><input name="workjob['+row_item+'][RequiredUnitWeight]"		class="form-control calRequiredUnitWeight"		readonly	type="text" value='+RequiredUnitWeight+' ></td> \n\
						<td><input name="workjob['+row_item+'][GoldQtyforGoldsmith]"	class="form-control calGoldQtyforGoldsmith"		readonly	type="text" value='+GoldQtyforGoldsmith+' ></td> \n\
						<td><i id='+row_item+' class="glyphicon glyphicon-remove-sign item_remove popup_remove" id="0" style="color: red; cursor: pointer; font-size: 28px;"></i></td> \n\
						<td></td> \n\
				</tr>';
			$('#getRecord').prepend(html);	
			
			$('.SelectItem').val('');
			$('.qty').val('');
			$('.RequiredQty').val('');
			$('.WeightShowroomProduct').val('');
			$('.RequiredUnitWeight').val('');
			$('.GoldQtyforGoldsmith').val('');
			row_item++;
			calamount();
	});
	
	
	$('.table').delegate('.item_remove','click',function(e){
		e.preventDefault();
		var id = $(this).attr('id');
		$('#item_row_'+id).remove();
		calamount();
	});
	
	function calamount()
	{
		
		var calqty = 0;
		var calRequiredQty = 0;
		var calWeightShowroomProduct = 0;
		var calRequiredUnitWeight = 0;
		var calGoldQtyforGoldsmith = 0;
	
		$("#items").find('.dynamic_row').each(function (i) {
			
			var $fieldset = $(this);
			
			var qty						= ($('.calqty', $fieldset).val());
			var RequiredQty				= ($('.calRequiredQty', $fieldset).val());
			var WeightShowroomProduct   = ($('.calWeightShowroomProduct', $fieldset).val());
			var RequiredUnitWeight		= ($('.calRequiredUnitWeight', $fieldset).val());
			var GoldQtyforGoldsmith		= ($('.calGoldQtyforGoldsmith', $fieldset).val());
	
			
			calqty					 = parseFloat(calqty) + parseFloat(qty);
			calRequiredQty			 = parseFloat(calRequiredQty) + parseFloat(RequiredQty);
			calWeightShowroomProduct = parseFloat(calWeightShowroomProduct) + parseFloat(WeightShowroomProduct);
			calRequiredUnitWeight	 = parseFloat(calRequiredUnitWeight) + parseFloat(RequiredUnitWeight);
			calGoldQtyforGoldsmith	 = parseFloat(calGoldQtyforGoldsmith) + parseFloat(GoldQtyforGoldsmith);
			
		
		});
		
		$(".TotalQty").val(parseFloat(calqty).toFixed(2));
		$(".TotalRequiredQty").val(parseFloat(calRequiredQty).toFixed(2));
		$(".TotalCurrentWeight").val(parseFloat(calWeightShowroomProduct).toFixed(2));
		$(".TotalUnitWeight").val(parseFloat(calRequiredUnitWeight).toFixed(2));
		$(".TotalGoldforGoldsmith").val(parseFloat(calGoldQtyforGoldsmith).toFixed(2));
	}
	
	
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

});


</script>


<script>
    $('document').ready(function () {
		
		$('.SelectItem').change(function(){
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
						$('#images').html(data.images);
						 $('.fancybox').fancybox();
					}
				});
			}
			else
			{
				$('#weight_bluk_product').val('');
				$('#qty').val('0');
				$('#images').html('');
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
					$("#getGoldSmithBalance").html("Balance Gold with Goldsmith: "+data.success+" g");
                }
            });
		});
		
		
		
//        $('#changevaluepop').change(function () {
//            var id = $(this).val();
//            $.ajax({
//                url: "get_customer_view",
//                method: "post",
//                dataType: 'json',
//                data: {data: id},
//                success: function (data) {
//                    if (data)
//                    {
//                        $(".getIncompleteOrder").html(data.result_data);
//                    }
//                }
//            });
//        });
		
		
		$('.getIncompleteOrder').change(function(){
			var id = $(this).val();
			var data_val = $('.getIncompleteOrder option:selected').attr('data-val');
            $.ajax({
                url: "<?=base_url()?>Productions/getgoldOrderItem",
                method: "post",
                dataType: 'json',
                data: {data: id,customer_id:data_val},
                success: function (data) {
                    $(".SelectItem").html(data.success);
                    $("#changevaluepop").html(data.customer);
//                    $("#changevaluepop").html(data.customer);
                    $(".order_delivery_dt").val(data.deliverydate);
                }
            });
		});
		
		
    });
</script>