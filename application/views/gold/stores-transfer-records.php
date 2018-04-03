<style>
label.error
{
	color:red;
}
	</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Stores Transfer Records</h1>
		</div>
	</div><!--/.row-->
	
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
					$code = uniqid();
                    ?>
					
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Date <span style="color: #F00">*</span></label>
								<input type="text" name="gpro_name" class="form-control" value="<?php echo date('Y-m-d H:i:s');  ?>"
								maxlength="499" autofocus  disabled required autocomplete="off" />
								<input type="hidden" name="gpro_name" class="form-control"  maxlength="499" autofocus   required autocomplete="off"  value="<?php echo date('Y-m-d H:i:s');  ?>" />
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Transfer Number<span style="color: #F00">*</span></label>
								<input type="text" name="transfer_code1" value="<?php echo $code; ?>"  class="form-control" disabled required maxlength="254" autocomplete="off" /><input type="hidden" name="transfer_code" value="<?php echo $code; ?>"  class="form-control" required maxlength="254" autocomplete="off" />
							</div>

						</div>


						<div class="col-md-3">
							<div class="form-group">
								<label>Transfer From Warehouse Name<span style="color: #F00">*</span></label>
																<select name="from" class="form-control" required autocomplete="off">
								<?php foreach($warehouse as $ware): ?>
								<option value="<?php echo $ware->s_id; ?>" ><?php echo $ware->s_name; ?></option>
								<?php endforeach;  
								?>
								</select>	
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Transfer To Warehouse<span style="color: #F00">*</span></label>
																<select name="to" class="form-control" required autocomplete="off">
								<?php foreach($warehouse as $ware): ?>
								<option value="<?php echo $ware->s_id; ?>" ><?php echo $ware->s_name; ?></option>
								<?php endforeach;  
								?>
								</select>	
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>GoldSmith<span style="color: #F00">*</span></label>
																<select name="out" class="form-control" required autocomplete="off">
								<?php foreach($goldsmith as $smith): ?>
								<option value="<?php echo $smith->gs_id; ?>" ><?php echo $smith->fullname; ?></option>
								<?php endforeach;  
								?>
								</select>	
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Item <span style="color: #F00">*</span></label>
								<input type="number" name="item" id="item" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>

							
							<div class="col-md-3">
								<div class="form-group">
								<label>Total weight of the transfer gold<span style="color: #F00">*</span></label>
								<input type="number" name="total_w_transfer" id="price" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Total no of Items transferred <span style="color: #F00">*</span></label>
								<input type="number" name="transfered"  id="transfered" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Total item’s cost of the transfer<span style="color: #F00">*</span></label>
								<input type="number" name="total_items_cost" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
						<!--		<label>Transfer done By user name <span style="color: #F00">*</span></label> -->
								<input type="hidden" name="username" class="form-control"  maxlength="254" autocomplete="off" value="<?php echo $_SESSION['user_id'] ?>" />
							</div>
						</div>




				<!--		<div class="col-md-3">
							<div class="form-group">
								<label>Total Weight<span style="color: #F00">*</span></label>
                                                                <input type="number" name="total_weight" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-3">
													<div class="form-group">
						<label>Warehouse<span style="color: #F00">*</span></label>
														<select name="ware"  id="ware" class="form-control" required autocomplete="off">
						<?php foreach($warehouse as $ware): ?>
						<option value="<?php echo $ware->s_id; ?>" ><?php echo $ware->s_name; ?></option>
						<?php endforeach; ?>
						</select>	
												</div>
						</div>
						<div class="col-md-4">
												   <div class="form-group">
													   <label>Gold Grade (Kt)<span style="color: #F00">*</span></label>
													   <select name="grade" class="form-control"  required autocomplete="off">
					   <?php foreach($grades as $grade): ?>
					   <option value="<?php echo $grade->grade_name; ?>" ><?php echo $grade->grade_name; ?> kt</option>
					   <?php endforeach; ?>
					   </select>
												   </div>
						</div> -->
					</div>
					
			
		
					<div class="row">
						<div class="progress" style="height:40px;display:none;">
                               <div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
                                please wait...
                                </div>
                            </div>
						<div class="col-md-4">
							<div class="form-group ">
								<input type="submit" class="btn btn-primary text-center" value="Add Transfer" / >
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
	<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script type="text/javascript">
	$(function() {
		$("#trans-goldproduct").validate({
			rules: {
				from:"required",
				to:"required",
				out:"required",
				item: {
					required: true,
					number: true,
				},
				total_w_transfer: {
					required: true,
					number: true,
				},
				transfered: {
					required: true,
					number: true,
				},
				total_items_cost: {
					required: true,
					number: true,
				},
				
			},
			messages: {
				from: "Please enter your transfer from",
				to: "Please enter your transfer to",
				out: "Please enter your goldSmith",
				item:{
					required: "Please provide a item ",
					number: "Please provide a Numeric value",
				},
				total_w_transfer:{
					required: "Please provide a total weight ",
					number: "Please provide a Numeric value",
				},
				transfered:{
					required: "Please provide a total no",
					number: "Please provide a Numeric value",
				},
				total_items_cost:{
					required: "Please provide a total items cost",
					number: "Please provide a Numeric value",
				},
				
			},
			submitHandler: function(form) {
				
					var formData = $("#trans-goldproduct").serialize();
					$('.progress').css('display','block');
						  $('#created-cycle-btn').attr('disabled','disabled');    
						  $.ajax({
						   url: 'store_transfer_record_save',
						   data: formData,
						   type: 'POST',
						  success:function(data){
							alert(data.error);
						   if(data.error == true)
						   { 
							 setTimeout(function(){
							 $("#trans-goldproduct").get(0).reset();
							 $("#message").css("visibility","visible");
							 $("#message").html("<div class='alert alert-success text-center'>Successfully! Stored Gold Record</div>");
							 $('.progress').css('display','none');
							 $('#created-cycle-btn').removeAttr('disabled','disabled');  
							  setTimeout(function(){
							  $("#message").css("visibility","hidden");
							  $("#message").html(""); 
							  },1000); },1000);
							}
						   else
						   {
						  $('.progress').css('display','none');
						   $("#message").css("visibility","visible");
						   $("#message").html("<div class='alert alert-danger text-center'>"+data.error+"</div>");
						   setTimeout(function(){
							$("#message").css("visibility","hidden");
							$("#message").html("");
							},4000);
						   }
						  }        
					   });
				
				
			}
		});
	});
	
	
	
function get_store(){

  var val = $('select[name=out]').val();
   event.preventDefault();
   $.ajax({      url: "get_netstore",
              method:"post",
              data:{data:val},
             success:function(data){
             $("#ware").html(data.message1);
             }
             });  
}


function get_price(){

  var val = $('input[name=grade]').val();
   event.preventDefault();
   $.ajax({      url: "get_gold_day_price",
              method:"post",
              data:{data:val},
             success:function(data){
  if(data.error==1){
            console.log(data.message);
            alert(data.message.gp_id);
$("#day_price").val(data.message.gp_price)

             }
else {
  alert("No record Found");
}
}

             });  
}

function total_sum(){

var weight = $("input[name=weight]").val();
var stone = $("input[name=stone]").val();
var profit= $("input[name=profit]").val();
var price= $("input[name=day_price]").val();
var other_cost= $("input[name=totalother]").val();
var stone_Cost= $("input[name=stonecost]").val();
if(stone>0  && weight>0  && profit>0 && other_cost>0 && stone_Cost>0){
   stone1 = $("input[name=total_weight]").val(parseFloat(weight)+parseFloat(stone));
var total_we = parseFloat(weight)+parseFloat(stone);



    result   =  (((1+4)/8) * (parseFloat(price)*parseFloat(weight))+parseFloat(other_cost)+ parseFloat(stone_Cost))*parseFloat(profit);


    result2   =    (parseFloat(total_we) * parseFloat(price))+parseFloat(other_cost)+parseFloat(stone_Cost)+parseFloat(profit);

//alert(result);
   auto_profit = $("input[name=grade_]").val(parseFloat(result));
auto_profit1 = $("input[name=grade_minimum]").val(parseFloat(result2));
     
}


}


</script>

	




