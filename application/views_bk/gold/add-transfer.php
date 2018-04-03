<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Transfer Record</h1>
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
                    ?>
					
					
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label>Date <span style="color: #F00">*</span></label>
								<input type="text" name="gpro_name" class="form-control" value="<?php echo date('Y-m-d');  ?>"
								maxlength="499" autofocus  disabled required autocomplete="off" />
								<input type="hidden" name="gpro_name" class="form-control"  maxlength="499" autofocus   required autocomplete="off"  value="<?php echo date('Y-m-d');  ?>" />
							</div>
						</div>

						<div class="col-md-3">
								<div class="form-group">
								<label>Item Code<span style="color: #F00">*</span></label>
								<select name="out" class="form-control" required autocomplete="off">
								<?php foreach($rjo as $rj): ?>
								<option value="<?php echo $rj->rjo_id; ?>" ><?php echo $rj->rjo; ?></option>
								<?php endforeach; ?>
								</select>	
							</div>
						</div>


						<div class="col-md-3">	
							<div class="form-group">
								<label>Gold Product<span style="color: #F00">*</span></label>
								<select name="product_id" class="form-control"  required autocomplete="off">
									<?php foreach($products as $pro): ?>
									<option value="<?php echo $pro->gpro_id; ?>" ><?php echo $pro->gpro_name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Gold Grade<span style="color: #F00">*</span></label>
								<input type="number" onkeyup="get_price()" name="grade" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Profit Percentage<span style="color: #F00">*</span></label>
								<input type="number" name="profit" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>

						
						<div class="col-md-3">
							<div class="form-group">
								<label>Gold Weight<span style="color: #F00">*</span></label>
								<input type="number" min="0" name="weight" onkeyup="total_sum()" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Stone Weight <span style="color: #F00">*</span></label>
								<input type="number" min="0" name="stone" onkeyup="total_sum()" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label>Total Weight <span style="color: #F00">*</span></label>
								<input type="number" name="total_weight" onkeyup="total_sum()" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>

						 <div class="col-md-3">
							<div class="form-group">
								<label>Total Stone Cost<span style="color: #F00">*</span></label>
								<input type="number" name="stonecost" onkeyup="total_sum()" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Total Other Cost<span style="color: #F00">*</span></label>
								<input type="number" name="totalother" onkeyup="total_sum()" class="form-control" required maxlength="254" autocomplete="off" />
								<input type="hidden" name="day_price" id="day_price" class="form-control"  autocomplete="off" />
							</div>
						</div>

                    <div class="col-md-3">
							<div class="form-group">
								<label>Profit Caculation <span style="color: #F00">*</span></label>
								<input type="number" name="grade_" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Total Minimum Selling Price<span style="color: #F00">*</span></label>
								<input type="number" name="grade_minimum" class="form-control" required  autocomplete="off" />
							</div>
						</div>

						

						<div class="col-md-3">
							<div class="form-group">
								<label>Note<span style="color: #F00">*</span></label>
								<textarea name="note" class="form-control"></textarea>
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
	
<script type="text/javascript">
	$("#trans-goldproduct").on("submit",function(event){
    event.preventDefault();
var formData = $("#trans-goldproduct").serialize();
$('.progress').css('display','block');
              $('#created-cycle-btn').attr('disabled','disabled');    
              $.ajax({
               url: 'save_transfer',
               data: formData,
               type: 'POST',
              success:function(data){
               if(data.error == true)
               { 
                 setTimeout(function(){
                 $("#trans-goldproduct").get(0).reset();
                 $("#message").css("visibility","visible");
                 $("#message").html("<div class='alert alert-success text-center'>Successfully! Add Gold Product</div>");
                 $('.progress').css('display','none');
                 $('#created-cycle-btn').removeAttr('disabled','disabled');  
                  setTimeout(function(){
                  $("#message").css("visibility","hidden");
                  $("#message").html(""); 
                  },100); },100);
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
	




