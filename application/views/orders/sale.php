<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Sale   <button type="button" class="btn btn-primary btn-circle" data-toggle="modal"  data-target="#UpdateModal"><i class="fa fa-plus"></i> Add Customer </button></td></h1>
		</div>
	</div><!--/.row-->
	
	<form action="<?=base_url()?>Gold/insertCustomer" method="post">
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
						<div class="col-md-6">
							<div class="form-group">
								<label>Date<span style="color: #F00">*</span></label>
								<input type="text" name="dates" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" maxlength="499" autofocus required autocomplete="off" />
								<input type="hidden" name="date" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" maxlength="499" autofocus required autocomplete="off" />

							</div>
						</div>
						<div class="col-md-6">
														
<div class="form-group">

<label>Sale Officer<span style="color: #F00">*</span></label>
								<select name="sale" class="form-control" required autocomplete="off">
<?php foreach($staff as $out): ?>
<option value="<?php echo $out->id; ?>" ><?php echo $out->staff_name; ?></option>
<?php endforeach;  
?>
</select>	
						</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
														
<div class="form-group">

<label>Customer<span style="color: #F00">*</span></label>
								<select name="sale" id="customer" onchange="get_value_item_customer()" class="form-control" required autocomplete="off">
<?php foreach($customer as $cus): ?>
<option value="<?php echo $cus->id; ?>" ><?php echo $cus->fullname; ?></option>
<?php endforeach;  
?>
</select>	
						</div>
						</div><div class="col-md-6">
														
<div class="form-group">

<label>Item Code<span style="color: #F00">*</span></label>
								<select name="rjo" id="rjo" onchange="get_value_item_code()" class="form-control" required autocomplete="off">
<?php foreach($products as $pro): ?>
<option value="<?php echo $pro->rjo_id; ?>" ><?php echo $pro->rjo; ?></option>
<?php endforeach;  
?>
</select>	
						</div>
						</div>
					</div>

<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Email<span style="color: #F00">*</span></label>
								<input type="email" name="email" id="email" class="form-control" maxlength="499" required autocomplete="off" value="" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Grade Name <span style="color: #F00">*</span></label>
								<input type="text" name="grade_name" id="grade_name" class="form-control" maxlength="499" data-match="#password" data-match-error="these don't match" required autocomplete="off" value="" />
							</div>
						</div>
					</div>		


<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Phone<span style="color: #F00">*</span></label>
								<input type="phone" name="phone" id="phone" class="form-control" maxlength="499" required autocomplete="off" value="" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Minimum Price<span style="color: #F00">*</span></label>
								<input type="text" name="mini" id="mini" class="form-control" maxlength="499" data-match="#password" data-match-error="these don't match" required autocomplete="off" value="" />
							</div>
						</div>

					</div>		




<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>NIC<span style="color: #F00">*</span></label>
								<input type="text" name="nic1" id="nic1" class="form-control" maxlength="499" required autocomplete="off" value="" />
							</div>
						</div>
<div class="col-md-6">
							<div class="form-group">
								<label>Day Price<span style="color: #F00">*</span></label>
								<input type="text" name="trans_day_price" id="trans_day_price" class="form-control" maxlength="499" required autocomplete="off" value="" />
							</div>
						</div>
						
					</div>		



<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Weigth<span style="color: #F00">*</span></label>
								<input type="text" name="weight" id="weight" class="form-control" maxlength="499" required autocomplete="off" value="" />
							</div>
						</div>

<div class="col-md-6">
							<div class="form-group">
								<label>Total Weight <span style="color: #F00">*</span></label>
								<input type="text" name="trans_total_weight" id="trans_total_weight" class="form-control" maxlength="499" data-match="#password" data-match-error="these don't match" required autocomplete="off" value="" />
							</div>
						</div>
					</div>		


					<div class="row">
						
						
						<div class="col-md-6">
							<div class="form-group">
								<label>Stone Cost<span style="color: #F00">*</span></label>
								<input type="text" name="trans_stone" id="trans_stone" class="form-control" maxlength="499" data-match="#password" data-match-error="these don't match" required autocomplete="off" value="" />
							</div>
						</div>



					</div>					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>Gold/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	</form>
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	



<div class="modal fade" id="UpdateModal" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Add Customer  </h4>
        </div>
        <div class="modal-body">
           <div class="row">
                <div class="col-lg-12">
                  <div id="message2"></div>
                    <form enctype="multipart/form-data" id="add-customer">
                     


<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Full Name <span style="color: #F00">*</span></label>
								<input type="text" name="fullname" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Email Address <span style="color: #F00">*</span></label>
                                                                <input type="email" name="email" id="email1" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Mobile </label>
								<input type="text" name="mobile" id="mobile1" class="form-control" maxlength="499" autofocus autocomplete="off" />
							</div>
						</div>
                                            <div class="col-md-6">
                                                <div class="form-group">
								<label>Address </label>
                                                                <textarea name="address" id="address" class="form-control" ></textarea>
                                                </div>
                                            </div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Password <span style="color: #F00">*</span></label>
								<input type="password" name="password" id="password" class="form-control" maxlength="499" required autocomplete="off" value="" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Confirm Password <span style="color: #F00">*</span></label>
								<input type="password" name="conpassword" class="form-control" maxlength="499" data-match="#password" data-match-error="these don't match" required autocomplete="off" value="" />
							</div>
						</div>
<div class="col-md-6">
							<div class="form-group">
								<label>NIC <span style="color: #F00">*</span></label>
								<input type="nic" name="nic" id="nic2" class="form-control" maxlength="499" data-match="#password" data-match-error="these don't match" required autocomplete="off" value="" />
							</div>
						</div>
					</div>					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">


<div id="p" class="progress" style="height:40px;display:none;">
                               <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
                                please wait...
                               </div>
        
                        </div>
                <button type="submit" id="created-cycle-btn" name="created-cycle-btn"   class="btn btn-info col-md-offset-5 ">Add Customer</button>
	
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
                </div>
                <!-- /.col-lg-12 -->
            </div>
               <!-- end of row -->
          </div>
          <!-- end of modal body -->
      </div>   
      <!-- end of modal content --> 
    </div>
    <!-- end of modal dialogue -->
  </div> <!--  Update modal is finish -->



<script>



   $("#add-customer").on("submit",function(event){
event.preventDefault();

mobile = $("#mobile1").val();
nic = $("#nic2").val();
email = $("#email1").val();
var formData = $("#add-customer").serialize();
$('.progress').css('display','block');
              $('#sign-up-btn').attr('disabled','disabled');
              //formData =  $("#dd-customer").serialize(); 
              $.ajax({
               url: 'insertCustomer_ajax',
               data: formData,   
               type: 'POST',
              success:function(data){
               if(data.error == true)
               { 
get_customer();
                 setTimeout(function(){
                 $("#add-customer").get(0).reset();
                 $("#message2").css("visibility","visible");
                 $("#message2").html("<div class='alert alert-success text-center'>"+data.message+"</div>");
                 $('.progress').css('display','none');
                 $('#upload-btn').removeAttr('disabled','disabled'); 
               setTimeout(function(){
                $("#message2").css("visibility","hidden");
                $("#message2").html("");
                },400);              
  },300);

$("#email").val(email);
$("#phone").val(mobile);
$("#nic1").val(nic);


$("#UpdateModal").modal('hide');
                }
               else
               {

              $('.progress').css('display','none');
               $("#message").css("visibility","visible");
               $("#message").html("<div class='alert alert-danger text-center'>Failed to Created Co-admin</div>");
               setTimeout(function(){
                $("#message").css("visibility","hidden");
                $("#message").html("");
                },4000);
               }
              }        
           });

});

function get_customer(){
$.ajax({
               url: 'getcustomer',
               data: {data:1},   
               type: 'POST',
              success:function(data){
               $("#customer").html(data.message);

}
});
}


function get_value_item_code(){

var id = $("#rjo").val()
$.ajax({
               url: 'store_transfer_record_uni',
               data: {data:id},   
               type: 'POST',
              success:function(data){
if(data.error==true){
//               $("#customer").html(data.message);
console.log(data.message.trans_grade_minimum);
//alert(data.message.trans_grade_minimum);


$("#grade_name").val(data.message.trans_grade);
$("#trans_total_weight").val(data.message.trans_total_weight);
$("#weight").val(data.message.trans_weight);
$("#trans_stonecost").val(data.message.trans_stonecost);
$("#mini").val(data.message.trans_grade_minimum);
$("#trans_day_price").val(data.message.trans_day_price);
$("#trans_stone").val(data.message.trans_stone);





}
else{
alert(data.message);
}
}

});

}

function get_value_item_customer(){

var id = $("#customer").val()
$.ajax({
               url: 'get_uni_customer',
               data: {data:id},   
               type: 'POST',
              success:function(data){
if(data.error==true){
//               $("#customer").html(data.message);
console.log(data.message.id);
//alert(data.message.id);
$("#email").val(data.message.email);
$("#phone").val(data.message.mobile);
$("#nic1").val(data.message.nic);
//alert(data.message.trans_grade_minimum);
}
else{
alert(data.message);
}
}

});
}

</script>
	
	
<?php
    require_once $app.'/views/includes/footer.php';
?>