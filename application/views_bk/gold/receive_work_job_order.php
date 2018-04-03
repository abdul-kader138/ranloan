<link href="<?=base_url();?>assets/css/jquery.multiselect.css" rel="stylesheet" />
<script src="<?=base_url();?>assets/js/jquery.multiselect.js"></script>
<style>
	label.error{
		color:red;
	}
</style>
<form  id="FormItemSubmit_1" method="post">	
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-6">
			<h1 class="page-header">Receive Work Order</h1>
		</div>
				<div class="col-lg-6" >
						<div class="col-md-4">
							<div class="form-group">
							<label>Outlet</label>
							<select name="out"  class="form-control"  id="out" class="out" autocomplete="off">
							<?php foreach($outlets as $out): ?>
							<option value="<?php echo $out->id; ?>" ><?php echo $out->name; ?></option>
							<?php endforeach;  
							?>
							</select>	
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label>GoldSmith<span style="color: #F00">*</span></label>
								<select name="goldsmith"  id="goldsmith" class="form-control goldsmith"  >
									<option value="" ><?php echo "Choose Goldsmith"; ?></option>
										<?php foreach($goldsmith as $smith): ?>
										<option value="<?php echo $smith->gs_id; ?>" ><?php echo $smith->fullname; ?></option>
										<?php endforeach;  
										?>
								</select>	
								<span style="color: #3333ff; margin-top: 2px;" id="getGoldSmithBalance"></span>
							</div>
						</div>
				</div>
	
	</div><!--/.row-->

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
					
					
<!-------------------------------------------------------------------------------------------------------------------------------	-->
			
	
					
					<div class="row" style="margin-top: 10px;">
							
							
							<div class="col-md-12" style="padding: 0px; margin-top: 10px;">
								<div class="col-md-2">
									<div class="form-group">
										<label>Date <span style="color: #F00">*</span></label>
										<input type="text" name="create_date" class="form-control" value="<?php echo date('Y-m-d H:i:s');  ?>" maxlength="499" autofocus  disabled required autocomplete="off" />
								
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Receive Work Order No.<span style="color: #F00">*</span></label>
										<input type="text" name="receive_job_order_no" id="receive_job_order_no" value="<?=  $getreceive_no; ?>" class="form-control receive_job_order_no" readonly=""  maxlength="254" autocomplete="off" />
							
									</div>
								</div>
								
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Receiving Store</label>
										<select name="receiving_store" id="receiving_store"  class="form-control receiving_store"  autocomplete="off">
											<option value="">Select store</option>
										</select>	
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Work Order No</label>
										<select name="main_wokorder_id"  class="form-control main_wokorder_id" id="main_wokorder_id"  autocomplete="off">
											<option value="">Select Work Order No.</option>
											<?php foreach($work_order_no as $workView){ ?>
											<option value="<?=$workView->job_order_no?>"><?=$workView->job_order_no?></option>
											<?php } ?>
										</select>	
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
									<label>Note <span style="color: #F00"></span></label>
									<textarea name="note" id="note" cols="30" class="form-control"></textarea>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Created By </label>
										<input type="text" readonly="" value="<?= $logged_name ?>"  class="form-control"   />
									</div>
								</div>
							</div>
					</div>
					<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<div class="" style="text-align: left;background: #f1f1f1;padding: 10px;">
									<h1 class="panel-title"></h1>
								</div>
							</div>
							
							<div class="col-md-12" style="padding: 0px; margin-top: 10px;">
								<div class="col-md-2">
									<div class="form-group">
										<label>Item .<span style="color: #F00">*</span></label>
										<select name="finish_product_item" id="finish_product_item" class="form-control finish_product_item"  autocomplete="off">
												<option value="">Select Finish Product Item</option>
										<?php
											  foreach($product_item as  $pro_view)
											  {  ?>
												  <!--<option  value="<?=$pro_view->id?>"> <?=$pro_view->name;?>  </option>-->
											<?php }  ?>
											</select>
										</select>	
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Gold Grade(kt).<span style="color: #F00">*</span></label>
										 <input type="text" readonly="" readonly=""name="gold_grade" id="gold_grade" class="form-control gold_grade"  maxlength="254" autocomplete="off" />
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
											<label>Item Weight (g)<span style="color: #F00">*</span></label>
											 <input type="text" readonly="" name="item_weight" id="item_weight" class="form-control item_weight"  maxlength="254" autocomplete="off" />
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Required Item Weight (g)<span style="color: #F00">*</span></label>
										 <input type="text" name="weight_item" id="weight_item" class="form-control weight_item"  maxlength="254" autocomplete="off" />
									</div>
								</div>
								
							
								<div class="col-md-2">
									<div class="form-group">
									<label>Required Qty<span style="color: #F00">*</span></label>
								 <input type="text" readonly="" name="qty" id="qty" class="form-control qty"  maxlength="254" autocomplete="off" />
									</div>
								</div>
								
							<div class="col-md-2">
							<div class="form-group">
								<label>Receive Qty<span style="color: #F00">*</span></label>
								 <input type="text" name="receive_qty" id="receive_qty" class="form-control receive_qty"  maxlength="254" autocomplete="off" />
								</div>
							</div>
						</div>	
					</div>
					
<!-------------------------------------------------------------------------------------------------------------------------------	-->
<br>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-12">
						<div class="col-md-3">
							<div class="form-group">
							<label>Prdouct Category<span style="color: #F00">*</span></label>
							<select name="product_category"  class="form-control product_category" id="product_category" >
								<option value="">Select Category</option>
									  <?php
										foreach($product_category as  $categ_view)
										{  ?>
											<option  value="<?=$categ_view->id?>"> <?=$categ_view->name;?>  </option>
									  <?php }  ?>
									</select>
							</div>
						</div>


						<div class="col-md-3">
							<div class="form-group">
								<label>Receive Weight for all item<span style="color: #F00">*</span></label>
								 <input type="text" name="receive_weight_item" id="receive_weight_item" class="form-control receive_weight_item calallitem"  maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Wastage (g) per 8 g<span style="color: #F00">*</span></label>
								 <input type="text" name="Wastage_add" id="Wastage_add" class="form-control Wastage_add calallitem"  maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label>Total Wastage (g)<span style="color: #F00">*</span></label>
								<input type="text" name="wastage" class="form-control wastage" id="wastage " maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Total Stone Weight<span style="color: #F00">*</span></label>
								<input type="text" name="stone_weight" class="form-control stone_weight" id="stone_weight" maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label>Labour Cost(Total)<span style="color: #F00">*</span></label>
                                <input type="text" name="labour_cost" class="form-control labour_cost"  maxlength="254" autocomplete="off" />
							</div>
						</div>

						
						<div class="col-md-3">
							<div class="form-group">
								<label>Note</label>
								<textarea name="note_details" class="form-control"  maxlength="254" autocomplete="off"></textarea>
                           </div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Item Details</label>
								<textarea name="item_details" class="form-control"  maxlength="254" autocomplete="off"></textarea>
                           </div>
						</div>

					</div>
				</div>	
<br>
<!--//--------------------------------------------------------------------------------------------------------->
						<div class="col-md-3">
							<div class="form-group">
								<label>Created By  <span style="color: #F00">*</span></label>
                               	<input type="text" name="created_by" class="form-control" value="<?= $logged_name ?>" readonly="">
                               	<input type="hidden" name="save_printvalue" class="form-control save_printvalue" value="" >
							</div>
						</div>
					
						<div class="col-md-12">
							<div class="form-group ">
								<input type="submit" class="btn btn-primary text-center" id="receive_data_submit" value="Save" / >
								<input type="submit" class="btn btn-primary text-center" id="save_print_submit" value="Save & Print" / >
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
<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script>
	
	$('.calallitem').keyup(function(){
		allitemcall();
	});
	
	$('.calallitem').blur(function(){
		allitemcall();
	});
	function allitemcall()
	{
		var receive_weight_item = $('#receive_weight_item').val();
		var Wastage_add = $('#Wastage_add').val();
		if(receive_weight_item=='')
		{
			receive_weight_item=0;
		}
		if(Wastage_add=='')
		{
			Wastage_add=0;
		}
		var total_wastage = parseFloat(receive_weight_item) +  parseFloat(Wastage_add);
		$('.wastage').val(total_wastage.toFixed(2));
	}
	
	
	
    $('document').ready(function(){
        $('#multiselectStore').multiselect({
            columns: 1,
            placeholder: 'Select Store',
            search: true,
            selectAll: true
        });
		
		
		$('#receive_data_submit').click(function(){
			$('.save_printvalue').val('0');
		})
		$('#save_print_submit').click(function(){
			$('.save_printvalue').val('1');
		})
		
	});
//alepsh


	
        $('.goldsmith').change(function () {
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

	$('#out').change(function(event){	
		outwise();

	});
	outwise();
	function outwise()
	{
		var outlet_id = $("#out option:selected").val();
		$.ajax({
			type:'POST',
			url:"<?=base_url();?>Productions/getoutletwiseStore",
			data: {outlet_id: outlet_id},
			dataType: 'JSON',
			success:function(data){
				$('.receiving_store').html(data.success);
			}
		});
	}


$('.main_wokorder_id').change(function(event){	
		var main_wokorder_id = $(".main_wokorder_id option:selected").val();
		$.ajax({
			type:'POST',
			url:"<?=base_url();?>Productions/getMainworkjobWiseSubworkjobProduct",
			data: {main_wokorder_id: main_wokorder_id},
			dataType: 'JSON',
			success:function(data){
				$('.finish_product_item').html(data.success);
			}
		});
});
	
	
$('.finish_product_item').change(function(event){	
	var order_items_gold_id = $(".finish_product_item option:selected").val();
	
		$.ajax({
			type:'POST',
			url:"<?=base_url();?>Productions/getProducttodeatilsItem ",
			data: {order_items_gold_id: order_items_gold_id},
			dataType: 'JSON',
			success:function(data){
				
				$('.item_weight').val(data.order_items_gold_weight);
				$('.qty').val(data.order_items_gold_qty);
				$('.gold_grade').val(data.order_items_gold_grade_name);
				
			}
		});
	
});	

//end alpesh	
	
	
$('.goldsmith').change(function(event){	
	var goldsmith_id = $(".goldsmith option:selected"). val();
	$.ajax({
			type:'POST',
			url:"<?=base_url();?>Productions/getGoldSmithWiseReceive_job",
			data: {goldsmith_id: goldsmith_id},
			dataType: 'JSON',
			success:function(data){
				$('.receive_job_sel_no').html(data.success);
				$('#customer_order_no').val('');
				$('.order_delivery_date').val('');
			}
	});
});



$('.receive_job_sel_no').change(function(event){		
		var receive_id = $(".receive_job_sel_no option:selected"). val();
		$.ajax({
			type:'POST',
			url:"<?=base_url();?>Productions/getRecevicewiseDetails",
			data: {receive_id: receive_id},
			dataType: 'JSON',
			success:function(data){
				if(data.status){
					$('#customer_order_no').val(data.customer_order_no);
				}else{
					$('#customer_order_no').val('');
				}
			}
		});
});
	

$(document).ready(function(){

$("#FormItemSubmit_1").validate({
			rules: {
				out:"required",
				goldsmith:"required",
				finish_product_item:"required",
				receiving_store:"required",
				main_wokorder_id:"required",
				'weight_item': {
					required: true,
					number: true,
				},
				'receive_qty': {
					required: true,
					number: true,
				},
				product_category:"required",
				receive_weight_item:"required",
				wastage:"required",
				stone_weight:"required",
				labour_cost:"required",
			},
			messages: {
				out: "Please enter outlet",
				goldsmith: "Please enter goldsmith",
				finish_product_item: "Please enter your Item",
				receiving_store: "Please enter receiving store",
				main_wokorder_id: "Please enter work order no",
				'weight_item': {
					required: "Please enter required item weight ",
					number: "Please enter Numeric value",
				},
				'receive_qty': {
					required: "Please enter receive qty",
					number: "Please enter Numeric value",
				},
				product_category: "Please enter product category",
				receive_weight_item: "Please enter receive weight all item",
				wastage: "Please enter total wastage",
				stone_weight: "Please enter total stone weight",
				labour_cost: "Please enter total labour cost",
			},
			submitHandler: function(form) {
				
				var formData= $("#FormItemSubmit_1").serialize();
				$.ajax({
						type:'POST',
						url:"<?=base_url();?>Productions/receive_WorkJob_add",
						data: formData,
						dataType: 'JSON',
						success:function(data){
							if(data.status==0)
							{
								window.location.href='<?=base_url()?>Productions/producation_receive' ;
							}
							else
							{
								window.location.href='<?=base_url()?>Productions/print_received_work_orders?id='+data.last_id;
							}
						}
				});
			}
		});


			
	});
	
	
	

</script>
