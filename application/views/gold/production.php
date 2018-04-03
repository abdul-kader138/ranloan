<style>
	label.error{
		color:red;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Production</h1>
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
						<div class="col-md-4">
							<div class="form-group">
								<label>Referance Number<span style="color: #F00">*</span></label>
								<input type="text" name="reference" value="<?php echo $code; ?>"  class="form-control" disabled  maxlength="254" autocomplete="off" /><input type="hidden" name="reference" value="<?php echo $code; ?>"  class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Outlet<span style="color: #F00">*</span></label>
								<select name="out" onchange="get_store()" class="form-control"  autocomplete="off">
									<?php foreach($outlets as $out): ?>
									<option value="<?php echo $out->id; ?>" ><?php echo $out->name; ?></option>
									<?php endforeach;  
									?>
								</select>	
							</div>
						</div>

					<div class="col-md-4">			
						<div class="form-group">
							<label>GoldSmith<span style="color: #F00">*</span></label>
							<select name="goldsmith" onchange="asd()" class="form-control" >
								<option ><?php echo "Choose Goldsmith"; ?></option>
								<?php foreach($goldsmith as $smith): ?>
								<option value="<?php echo $smith->gs_id; ?>" ><?php echo $smith->fullname; ?></option>
								<?php endforeach;  
								?>
							</select>	
						</div>
					</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Date <span style="color: #F00">*</span></label>
								<input type="text" name="gpro_name" class="form-control" value="<?php echo date('Y-m-d H:i:s');  ?>"
								maxlength="499" autofocus  disabled  autocomplete="off" />
								<input type="hidden" name="gpro_name" class="form-control"  maxlength="499" autofocus    autocomplete="off"  value="<?php echo date('Y-m-d H:i:s');  ?>" />
							</div>
						</div>


						<div class="col-md-4">
							<div class="form-group">
								<label>Category Type<span style="color: #F00">*</span></label>
								<select name="type" id="type" class="form-control"  autocomplete="off">
								<option value="service" ><?php echo "Service"; ?></option>
								<option value="non" ><?php echo "Non Inventory"; ?></option>
								</select>	
							</div>
						</div>


						<div class="col-md-4">
							<div class="form-group">
								<label>Product Quantity<span style="color: #F00">*</span></label>
								 <input type="text" name="qty" id="qty" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Receiving Store<span style="color: #F00">*</span></label>
								<select name="ware" id="ware" class="form-control"  autocomplete="off">
									<?php foreach($warehouse as $ware): ?>
									<option value="<?php echo $ware->s_id; ?>" ><?php echo $ware->s_name; ?></option>
									<?php endforeach;  
									?>
								</select>	
							</div>
						</div>	

						<div class="col-md-4">
							<div class="form-group">
								<label>Gold Grade (Kt)<span style="color: #F00">*</span></label>
								<select name="grade" class="form-control" onchange="get_price()"   autocomplete="off">
									<?php foreach($grades as $grade): ?>
									<option value="<?php echo $grade->grade_name; ?>" ><?php echo $grade->grade_name; ?> kt</option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>					

						<div class="col-md-4">
							<div class="form-group">
								<label>Wastage per 8 g(in gm) <span style="color: #F00">*</span></label>
								<input type="text" name="wastage" onkeyup="cal_wastage()"  id="wastage" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Total Product Gold weight -g<span style="color: #F00">*</span></label>
								<input type="number" name="total_product" onkeyup="cal_wastage()" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Total Stone - Other weight -g<span style="color: #F00">*</span></label>
								<input type="text" name="otherweight" onkeyup="cal_wastage()" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Wastage calculation <span style="color: #F00">*</span></label>
								<input type="text" name="wastage_cal" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Total Gold wastage <span style="color: #F00">*</span></label>
								<input type="text" name="total_gold_wastage" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Total GoldSmith in g(product & wastage) <span style="color: #F00">*</span></label>
								<input type="text" name="goldsmith_was" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>



				<!--		<div class="col-md-3">
							<div class="form-group">
								<label>Total Weight<span style="color: #F00">*</span></label>


                                                                <input type="text" name="total_weight" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>

							<div class="col-md-3">
														<div class="form-group">
							<label>Warehouse<span style="color: #F00">*</span></label>
															<select name="ware"  id="ware" class="form-control"  autocomplete="off">
							<?php foreach($warehouse as $ware): ?>
							<option value="<?php echo $ware->s_id; ?>" ><?php echo $ware->s_name; ?></option>
							<?php endforeach; ?>
							</select>	
													</div>
													</div>
							 <div class="col-md-4">
														<div class="form-group">
															<label>Gold Grade (Kt)<span style="color: #F00">*</span></label>
															<select name="grade" class="form-control"   autocomplete="off">
							<?php foreach($grades as $grade): ?>
							<option value="<?php echo $grade->grade_name; ?>" ><?php echo $grade->grade_name; ?> kt</option>
							<?php endforeach; ?>
							</select>
							</div>
						</div> -->





						<div class="col-md-4">
							<div class="form-group">
								<label>Labour Cost<span style="color: #F00">*</span></label>
								<input type="text" name="labourunit" onkeyup="total_cost()" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Labour Cost Total<span style="color: #F00">*</span></label>
								<input type="text" name="labourtotal" class="form-control"  maxlength="254" autocomplete="off" />
								<input type="text" name="day_price" id="day_price" class="form-control"  maxlength="254" autocomplete="off" />

							</div>
						</div>


						<div class="col-md-4">
							<div class="form-group">
								<label>Design Cost<span style="color: #F00">*</span></label>
								<input type="text" name="design-cost" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Stone Cost<span style="color: #F00">*</span></label>
								<input type="text" name="stone-cost" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>
				<div id="ids">

					<div class="col-md-12" id="id2" >
							<!-- <div class="form-group" >
								<label>Other Cost1<span style="color: #F00">*</span></label>
                                                                <input type="text" name="other1[]"  class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>

<div class="col-md-4" id="id2" >
							<div class="form-group">
								<label>Other Cost2<span style="color: #F00">*</span></label>
                                                                <input type="text" name="other1[]" class="form-control"  maxlength="254" autocomplete="off" />
							</div>
						</div>-->
					</div>

				</div>
					
			
		
					<div class="row">
						<div class="progress" style="height:40px;display:none;">
                               <div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
                                please wait...
                                </div>
						</div>
						<div class="col-md-12">
							<div class="form-group ">
								<input type="submit" class="btn btn-primary text-center" value="Add Production" / >
								<input type="button" class="btn btn-primary text-center" onclick="addothercost()" value="Add Other Cost" / >
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
				out:"required",
				goldsmith:"required",
				type:"required",
				qty: {
					required: true,
					number: true,
				},
				ware:"required",
				grade:"required",
				'wastage': {
					required: true,
					number: true,
				},
				total_product: {
					required: true,
					number: true,
				},
				otherweight: {
					required: true,
					number: true,
				},
				wastage_cal: {
					required: true,
					number: true,
				},
				total_gold_wastage: {
					required: true,
					number: true,
				},
				goldsmith_was: {
					required: true,
					number: true,
				},
				labourunit: {
					required: true,
					number: true,
				},
				labourtotal: {
					required: true,
					number: true,
				},
				'design-cost': {
					required: true,
					number: true,
				},
				'stone-cost': {
					required: true,
					number: true,
				},
				
			},
			messages: {
				out: "Please enter your outlet",
				goldsmith: "Please enter your goldSmith",
				type: "Please enter your category type",
				qty:{
					required: "Please provide a product quantity ",
					number: "Please provide a Numeric value",
				},
				ware: "Please enter your receiving store",
				grade: "Please enter your gold grade",
				'wastage':{
					required: "Please provide a wastage  ",
					number: "Please provide a Numeric value",
				},
				total_product:{
					required: "Please provide a total product",
					number: "Please provide a Numeric value",
				},
				otherweight:{
					required: "Please provide a total stone",
					number: "Please provide a Numeric value",
				},
				wastage_cal:{
					required: "Please provide a wastage calculation",
					number: "Please provide a Numeric value",
				},
				total_gold_wastage:{
					required: "Please provide a total gold wastage ",
					number: "Please provide a Numeric value",
				},
				goldsmith_was:{
					required: "Please provide a total goldSmith",
					number: "Please provide a Numeric value",
				},
				labourunit:{
					required: "Please provide a labour cost",
					number: "Please provide a Numeric value",
				},
				labourtotal:{
					required: "Please provide a labour cost total",
					number: "Please provide a Numeric value",
				},
				'design-cost':{
					required: "Please provide a desgin cost",
					number: "Please provide a Numeric value",
				},
				'stone-cost':{
					required: "Please provide a stone cost",
					number: "Please provide a Numeric value",
				},
				
			},
			submitHandler: function(form) {

				var formData = $("#trans-goldproduct").serialize();
				$('.progress').css('display','block');
				  $('#created-cycle-btn').attr('disabled','disabled');    
				  $.ajax({
				   url: 'save_production',
				   data: formData,
				   type: 'POST',
				  success:function(data){
				   if(data.error == true)
				   { 
					 setTimeout(function(){
					 $("#trans-goldproduct").get(0).reset();
					 $("#message").css("visibility","visible");
					 $("#message").html("<div class='alert alert-success text-center'>Successfully! Added Production</div>");
					 $('.progress').css('display','none');
					 $('#created-cycle-btn').removeAttr('disabled','disabled');  
					  setTimeout(function(){
					  $("#message").css("visibility","hidden");
					  $("#message").html(""); 

					  $("#id2").html(" ");
					  $("input[name=reference]").val('<?= uniqid(); ?>');
					  $("input[name=gpro_name]").val('<?php echo date("Y-m-d H:i:s"); ?>');
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

  var val = $('select[name=grade]').val();
   event.preventDefault();
   $.ajax({      url: "get_gold_day_price",
              method:"post",
              data:{data:val},
             success:function(data){
  if(data.error==1){
            console.log(data.message);
           // alert(data.message.gp_id);
$("#day_price").val(data.message.gp_price)

             }
else {
  alert("No record Found");
}
}

             });  
}





function asd(){


  var val = $('select[name=goldsmith]').val();
   event.preventDefault();
   $.ajax({      url: "get_wastage_gram",
              method:"post",
              data:{data:val},
             success:function(data){
console.log(data);
  if(data.error==true){
       
$("input[name=wastage]").val(data.message.weight__qty_pergram)

             }
else {
  alert("No record Found");
}
} });  

}



function addothercost(){

$("#id2").append("<div class='col-md-4' id='id3' ><div class='form-group'><label><input type='text' name='other_name[]' class='form-control' placeholder='Cost Name'  /><span style='color: #F00'>*</span></label><input type='text' name='other1[]' placeholder='Cost' class='form-control' required  /></div></div>");

}


function total_cost(){

var total =  $("input[name=qty]").val();
var total_price = $("input[name=labourunit]").val();
alert(total)
alert(total_price)
var result2 = (parseFloat(total_price)*parseFloat(total));
 $("input[name=labourtotal]").val(result2);
//alert(result2);

}










function cal_wastage(){

var wastage= $("input[name=wastage]").val();
var other= $("input[name=otherweight]").val();
var total= $("input[name=total_product]").val();

if(wastage>0  && other>0  && total>0){


var result2 = (parseFloat(total)-parseFloat(other));
$("input[name=total_gold_wastage]").val(math.round(result2*1000)/1000);



var result = ((parseFloat(total)-parseFloat(other))/8)*wastage;
result3  = parseFloat(result2)+parseFloat(math.round(result*1000)/1000);
$("input[name=goldsmith_was]").val(math.round(result3*1000)/1000);
var wastage= $("input[name=wastage_cal]").val(math.round(result*1000)/1000);
}
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






</script>
	




