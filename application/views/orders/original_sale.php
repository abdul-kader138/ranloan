<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/header.php';
$paid_bys =  $this->Constant_model->getddData('payment_method','id','name', 'id');
?>
<script>
    $( function() {
        $( "#startDate" ).datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });
        
        $("#endDate").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
                $("#transfer_date").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });
    } );
</script>
	<form action="<?=base_url()?>Gold/insertSale" id="sales_form11" method="post"> 
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-4">
			<h1 class="page-header">Add Sale   <button type="button" class="btn btn-primary btn-circle" data-toggle="modal"  data-target="#UpdateModal"><i class="fa fa-plus"></i> Add Customer </button></td></h1>
		</div>







<div class="col-md-3">
														
<div class="form-group">

<label>Select Search<span style="color: #F00">*</span></label>
								<select name="search-area12" id="search-area12"  class="form-control" required autocomplete="off">
<option ><?php echo "Selection Area"; ?></option>
<option ><?php echo "mobile"; ?></option>
<option value="<?php echo 'fullname'; ?>"><?php echo "Name"; ?></option>
<option value="<?php echo 'nic'; ?>" ><?php echo "NIC"; ?></option>


</select>	
						</div>
						</div>


<div class="col-md-3" >
														
<div class="form-group">

<label>Nic,Name, Phone<span style="color: #F00">*</span></label>
		<input type="text" name="search-phone12" id="search-phone12" onkeyup="get_value_item_customer_three()"  class="form-control" maxlength="499" required="" autocomplete="off" value="">
						</div>
						</div>












<div class="col-lg-12" style="display:none" >
			<h1 class="page-header">Add Sale <button type="button" id="order_model2" class="btn btn-primary btn-circle" data-toggle="modal"  data-target="#UpdateModal2"><i class="fa fa-plus"></i> Add Customer </button></td></h1>
		</div>


<div class="col-lg-12" style="display:none" >
			<h1 class="page-header">Add Sale <button type="button" id="order_model1" class="btn btn-primary btn-circle" data-toggle="modal"  data-target="#UpdateModal1"><i class="fa fa-plus"></i> Add Customer </button></td></h1>
		</div>

<div class="col-lg-12" style="display:none" >
			<h1 class="page-header">Add Sale <button type="button" id="order_model3" class="btn btn-primary btn-circle" data-toggle="modal"  data-target="#UpdateModal3"><i class="fa fa-plus"></i> Add Customer </button></td></h1>
		</div>

<div class="col-lg-12" style="display:none" >
			<h1 class="page-header">Add Sale <button type="button" id="order_model0" class="btn btn-primary btn-circle" data-toggle="modal"  data-target="#UpdateModal0"><i class="fa fa-plus"></i> Add Customer </button></td></h1>
		</div>



	</div><!--/.row-->
    

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
<div class="col-md-8">
<div class="row">
<div class="col-md-3">
                                                        
<div class="form-group">
<label>Customer<span style="color: #F00">*</span></label>
<input type="text" name="cus" id="cus" class="form-control" required autocomplete="off" />
<!--                                <select name="customer" id="customer" onchange="get_value_item_customer()" class="form-control" required autocomplete="off">

?>
</select>   -->
                        </div>
</div>

<div class="col-md-3">
                            <div class="form-group">
                                <label>Email<span style="color: #F00">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" maxlength="499" required autocomplete="off" value="" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Phone<span style="color: #F00">*</span></label>
                                <input type="phone" name="phone" id="phone" class="form-control" maxlength="499" required autocomplete="off" value="" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>NIC<span style="color: #F00">*</span></label>
                                <input type="text" name="nic1" id="nic1" class="form-control" maxlength="499" required autocomplete="off" value="" />
                            </div>
                        </div>

</div>
<div class="row">
<div class="col-md-6">
                            <div class="form-group">
                                <label>Address<span style="color: #F00">*</span></label>
                                <textarea name="address1" rows="4" id="address1" class="form-control"  required autocomplete="off" > 
</textarea>
                            </div>
</div>
<div class="col-md-3">
                                                        
<div class="form-group">
<label>Outlets<span style="color: #F00">*</span></label>
                                <select name="out" onchange="get_store()"  class="form-control" required autocomplete="off">
<?php foreach($outlets as $out): ?>
<option value="<?php echo $out->id; ?>" ><?php echo $out->name; ?></option>
<?php endforeach; ?>
</select>   
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

</div>




</div>

    <div class="col-md-4">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Date<span style="color: #F00">*</span></label>
                                <input type="text" name="dates"  disabled class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" maxlength="499" autofocus required autocomplete="off" />
                                <input type="hidden" name="date" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" maxlength="499" autofocus required autocomplete="off" />

                            </div>
                        </div>
<div class="col-md-12">
                            <div class="form-group">
                                <label>Invoice <span style="color: #F00">*</span></label>
<?php $code = uniqid(); ?>
                                <input type="text" name="invoice1" disabled class="form-control" value="<?php echo $code; ?>" maxlength="499" autofocus required autocomplete="off" />
                                <input type="hidden" name="invoice" class="form-control" value="<?php echo $code; ?>" maxlength="499" autofocus required autocomplete="off" />

                            </div>
                        </div>
                        <div class="col-md-12">
                                                        
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


                    </div>

                                        <style>
.lable{
    margin-top: 10px;
    margin-left: 30px;
 
}
.lable1{
    margin-top: 10px;
    margin-left: 55px;
 
}
.lable1{
    margin-top: 10px;
    margin-left: 45px;
 
}

.lableradip{
    
    border-radius:15px;
    border:1px solid #eee;
}
.butonmove{
    margin-left: 25px;
    height: 150px;
}
.butonmove1{
    margin-left: 20px;
}

</style>


<div class="row">
<div class="col-md-2" >
                            <div class="form-group lableradip" style="height: 90px;"  >
                                <label class="lable1  newitem text-center">New Item</label><br>
<br><span class="butonmove" ><input type="radio" value="1" name="newitem"  onClick="getva(this.id);" id="newitem"/><label for="newitem" ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/yes1.jpg"></label>&nbsp;&nbsp;
<input type="radio" name="newitem" value="0" id="newitem1" onClick="getva(this.id);" /><label for="newitem1"   ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/no.jpg"></label></span>
                            </div>
                        </div>
<div class="col-md-2">
                            <div class="form-group lableradip" style="height: 90px;" >
                                <label class="lable order_extimate " >Order/Extimate</label><br><br><span class="butonmove" ><input type="radio" value="1"   name="order_extimate" id="order_extimate" onClick="getva(this.id);" /><label for="order_extimate"   ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/yes1.jpg"></label> &nbsp;&nbsp;
<input type="radio"  name="order_extimate" value="0" id="order_extimate1"  onClick="getva(this.id);" /><label for="order_extimate1" ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/no.jpg"></label></span>
                            </div>
                        </div>

<div class="col-md-2" >
                            <div class="form-group lableradip" style="height: 90px;" >
                                <label class="lable1 exchange" >Exchange</label><br>
                                <br><span class="butonmove" ><input type="radio"  onClick="getva(this.id);" value="1" name="exchange" id="exchange"/><label for="exchange" ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/yes1.jpg"></label> &nbsp;&nbsp;
<input type="radio" name="exchange" value="0" id="exchange1"  onClick="getva(this.id);" /><label for="exchange1" ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/no.jpg" ></label></span>

                            </div>
                        </div>
<div class="col-md-2" >
                            <div class="form-group lableradip " style="height: 90px;">
                                <label class="lable text-center old" >Old Gold Exch..</label><br>
<br><span class="butonmove" ><input type="radio" onClick="getva(this.id);" value="1" name="old" id="old"/><label for="old" ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/yes1.jpg"></label>&nbsp;
<input type="radio" name="old" value="0" onClick="getva(this.id);" id="old1"/><label for="old1" ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/no.jpg" ></label></span>
                            </div>
                        </div> 



<div class="col-md-2" >
                            <div class="form-group lableradip" style="height: 90px;"  >
                                <label class="lable1 discount">Discount</label><br>
<br><span class="butonmove" ><input type="radio" value="1" name="discount"  onClick="getva(this.id);" id="discount"/><label for="discount" ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/yes1.jpg"></label>&nbsp;&nbsp;
<input type="radio" name="discount" value="0" id="discount1"  onClick="getva(this.id);" /><label for="discount1"  ><img width="30px;" height="25px;" src="<?php echo base_url() ?>assets/img/no.jpg"></label></span>
                            </div>
                        </div></div>
                        <input type="hidden" name="subsec" id="subsec" class="form-control"  maxlength="499" />
<input type="hidden" name="subval" id="subval" class="form-control"  maxlength="499" />

<div class="row"> 
                <div class="col-md-3" style="margin-left:15px;" id="code">
                                                        
<div class="form-group">

<label>Showroom Item<span style="color: #F00">*</span></label>
                                <select name="rjo" id="rjo" onchange="get_value_item_code()" class="form-control" required autocomplete="off">
<option ><?php echo "Select Item Code"; ?></option>
<?php foreach($products as $pro): ?>
<option value="<?php echo $pro->rjo_id; ?>" ><?php echo $pro->rjo; ?></option>
<?php endforeach;  
?>
</select>   
                        </div>
                        </div>
<div class="col-md-3">
                            <div class="form-group">
                                <label>Deposit<span style="color: #F00">*</span></label>
                                <input type="number" disabled name="deposit" id="deposit" class="form-control" maxlength="499" required autocomplete="off" value="" />
                            </div>
                        </div>      



    <div class="col-md-3 col-md-offset-4 text-center"> 
<div id="mes" style=" padding-top: 50px;"></div>


</div>

</div>
 <style type="text/css">
          table{
            table-layout: fixed;
          }
          td
          {
            word-wrap: break-word;
          }
        </style>
<div class="table-responsive">
<table  class="table table-bordered " width="100%" id="hii">

<tr>
<td class="text-center" width="15%">Code</td>                           
<td class="text-center" width="17%" >Item</td>
<td class="text-center" width="8%" >Qty</td>
<td class="text-center" width="10%" >Gold Grade</td>
<td class="text-center" width="12%">Weight gm</td>
<td class="text-center" width="13%" >Price</td>
<td class="text-center" width="12%" >Minimum Price</td>
<td class="text-center" width="12%" >Total Price</td>
<td class="text-center" width="3%"></td>
</tr>

<!-- <tr id="app0">
<td class="text-center"></td>                           
<td class="text-center"></td>
<td class="text-center"></td>
<td class="text-center"></td>
<td class="text-center"></td>
<td class="text-center"></td>
<td class="text-center"></td>
<td class="text-center"></td>
</tr>  -->


</table>
</div>

<div class="col-md-offset-9 col-3">
<table class="table" id="total">
<tr><td>Total</td><td><input type='text' name='to' disabled  class='form-control numbers' maxlength='499'  value='' /><input type='hidden' name='to1'  id='to1' class='form-control'    maxlength='499'  value='' /></td></tr>

</table>
</div>
<div class="row">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                            <!--    <button class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button> -->
                            </div>
                        </div>
                        <div class="col-md-2">
                                        <a class="btn btn-primary" href="#timepicker4Modal"  disabled id="pay_dis" data-toggle="modal" style="background-color: #3fb618; float: right; font-weight: bold; color: #FFF; border: 0px; padding-top: 10px; padding-bottom: 10px; width: 100%;">
                                            PAYMENT
                                        </a>
                                    </div>
                        <div class="col-md-4"></div>
                    </div>
                    
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
    
    
    <br /><br /><br /><br /><br />
    
</div><!-- Right Colmn // END -->
                    
    
<script>
  function add_customer(event){
event.preventDefault();

mobile = $("#mobile1").val();
nic = $("#nic2").val();
email = $("#email1").val();
address = $("#address").val();
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
$("#address1").val(address);

$("#email2").val(email);
$("#phone2").val(mobile);
$("#nic3").val(nic);
$("#address2").val(address);
$("#email2_").val(email);
$("#phone2_").val(mobile);
$("#nic3_").val(nic);
$("#address2_").val(address);

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




function get_store_(){

  var val = $('select[name=out1]').val();
   event.preventDefault();
   $.ajax({      url: "get_netstore",
              method:"post",
              data:{data:val},
             success:function(data){
$("#ware1").html(data.message1);
             }
             });  

}



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
var subse = $("input[name=subsec]").val();
if(subse=='New Item'){

if(subse.length!=0){
$.ajax({
               url: 'store_transfer_record_uni',
               data: {data:id},   
               type: 'POST',
              success:function(data){
if(data.error==true){
//               $("#customer").html(data.message);
console.log(data.message.trans_grade_minimum);
//alert(data.message.trans_grade_minimum);
var subse = $("input[name=subsec]").val();
var subvl = $("input[name=subval]").val();
var subvl1 ;
data4= ['old','exchange','order_extimate','discount','newitem'];
data5= ['od','ex','or','dis','item'];
//alert(data[0])
for(i=0;i<5;i++){
//alert(data4[i]);
text1 = $("."+data4[i]).text();
if(text1==subse){
 subvl1=data5[i];
}

}

id1=id+subvl1;


var rowCount = $('#hii tr').length;
var verificaHorario = $("#hii").find("#app"+id1);
//console.log(verificaHorario);
var counter=0;
$('tr').map(function () {
//alert(this.id);
if('app'+id1==this.id){
counter=1;
}

    return this.id;
})

var id2 = $("select[name=rjo]").val();
var code = $("#rjo option:selected").text();
//alert(data.message.trans_grade_minimum);

if(counter==0){

$("#hii").append(
"<tr id=app"+id1+" ><td style='padding: 0px;'><div class='col-md-2'><div class='form-group'><label class='label' style='width:100px;' ><span style='color: #F00'>"+subse+"</span></label><input type='text' style='width: 130px;' name='code[]'  class='form-control' value='"+code+"' maxlength='499'  disabled/><input type='hidden' style='width: 100px;' name='code1[]'  class='form-control' value='"+code+"' maxlength='499' /><input type='hidden' style='width: 100px;' name='subsection[]'  class='form-control' value='"+subse+"' maxlength='499' /><input type='hidden' style='width: 100px;' name='subsectionvl[]'  class='form-control' value='"+subvl+"' maxlength='499' /></div></div></td><td style='padding: 0px;'><div class='col-md-2'><div class='form-group'><label><span style='color: #F00'></span></label><input type='text' name='item_name[]' style='width: 140px;'  class='form-control' value='"+data.message.item_name+"'  maxlength='499' disabled /><input type='hidden' name='item_name1[]' style='width: 70px;'  class='form-control' value='"+data.message.item_name+"'  maxlength='499' /></div></div></td><td style='padding: 0px;' > <div class='col-md-1'><div class='form-group'><label><span style='color: #F00'></span></label><input type='text'  name='qty12[]'  id='qty_"+id1+"' onkeyup=updated_v('"+id1+"') class='form-control "+id1+"'   style='width: 50px;' value=1  maxlength='499' required autocomplete='off'  /></div></div></td><td style='padding: 0px;' ><div class='col-md-2'><div class='form-group'><label><span style='color: #F00'></span></label><input type='text' name='gold_grade[]'  class='form-control' value='"+data.message.trans_grade+"' style='width: 50px;'  maxlength='499' required autocomplete='off' disabled  /><input type='hidden' name='gold_grade1[]'  class='form-control' value='"+data.message.trans_grade+"' style='width: 100px;'  maxlength='499' required autocomplete='off'  /></div></div></td><td style='padding: 0px;' > <div class='col-md-2'><div class='form-group'><label><span style='color: #F00'></span></label><input type='text' name='weight[]' value='"+data.message.trans_weight+"' class='form-control'   maxlength='499'  style='width: 80px;' disabled /><input type='hidden' name='weight1[]' value='"+data.message.trans_weight+"' class='form-control'   maxlength='499'  style='width: 50px;' /></div></div></td><td style='padding: 0px;' > <div class='col-md-2'><div class='form-group'><label><span style='color: #F00'></span></label><input type='text' onkeyup=Price_calculation("+"'"+id1+"') name='price[]' style='width: 80px;' class='form-control' id='price"+id1+"'  maxlength='499'  value='0' /></div></div></td><td style='padding: 0px;' > <div class='col-md-2'><div class='form-group'><label><span style='color: #F00'></span></label><input type='text' name='mini[]'  disabled style='width: 100px;' class='form-control'   maxlength='499'  value='"+$.number(data.message.trans_grade_minimum,2)+"' /><input type='hidden' id='mini"+id1+"' name='mini1[]'  style='width: 100px;' class='form-control'    maxlength='499'  value='"+data.message.trans_grade_minimum+"' /></div></div></td><td style='padding: 0px;' > <div class='col-md-2'><div class='form-group'><label><span style='color: #F00'></span></label><input type='text' name='total_price_final[]'  id='total_price_final1"+id1+"' disabled style='width: 100px;' class='form-control'   maxlength='499'  value='0' /><input type='hidden' id='total_price_final"+id1+"' name='total_price_final1[]'  style='width: 100px;' class='form-control'    maxlength='499'  value='0' /><input type='hidden' id='id2"+id1+"' name='id2[]'  style='width: 100px;' class='form-control'    maxlength='499'  value='"+id2+"' /></div></div></td><td  onclick=delqty('"+id1+"') style='color: #F00; padding:0px;'><span class='glyphicon glyphicon-trash' style='margin-top: 25px;' ></span></td></tr>");



total_price(data.message.trans_grade_minimum);



}
else{
qty = $("."+id+subvl1).val();
total = parseInt(qty)+parseInt(1);
qty = $("."+id+subvl1).val(total);
//$("#final_total_qty").val(total);
//$("#final_purchased_item").html(qty);
Price_calculation(id+subvl1);
//total_price(data.message.trans_grade_minimum);
//total_price();
}



/* 
$("#grade_name").val(data.message.trans_grade);
$("#trans_total_weight").val(data.message.trans_total_weight);
$("#weight").val(data.message.trans_weight);
$("#trans_stonecost").val(data.message.trans_stonecost);
$("#mini").val(data.message.trans_grade_minimum);
$("#trans_day_price").val(data.message.trans_day_price);
$("#trans_stone").val(data.message.trans_stone);
*/




}
else{
//alert(data.message);
}
}

});
}
else{

alert("First Select Subsection ");
}
}
}
function delqty(id){
                    var mini = $("input[name='mini1[]']")
                   .map(function(){return $(this).val();}).get();
                    var qty = $("input[name='qty12[]']")
                   .map(function(){return $(this).val();}).get();
                   if(mini.length==1){
                                      if(qty[0]==1 || qty[0]==0 ){    
                            alert("One Product can not be deleted");
                                     }
                                      else{
                                          qty_val = parseInt(qty[0])-1;
                                          $("#qty_"+id).val(qty_val);
Price_calculation(id)
                                          //$('#app'+id).remove();
                                         // $("input[name=to]").val($.number(0,2));
                                         // $("input[name=to1]").val(0);
                                           }
                                     }
                  else{
vale =   $("#qty_"+id).val();
        if(vale==1 || vale==0 ){
          $('#app'+id).remove();
total_price(id)
         }
else{

   qty_val = parseInt(vale)-1;
  $("#qty_"+id).val(qty_val);

//$('#app'+id).remove();
//$("input[name=to]").val($.number(0,2));
//$("input[name=to1]").val(0);

Price_calculation(id);
}
}

}

function get_value_item_customer(){

var id = $("#search-phone").val()
var  name = $("#search-area").val()
$.ajax({
               url: 'get_uni_customer_three',
               data: {data:id,name:name},
               type: 'POST',
              success:function(data){
if(data.error==true){
//               $("#customer").html(data.message);
//console.log(data.message.id);
//alert(data.message.id);
$("#email").val(data.message.email);
$("#phone").val(data.message.mobile);
$("#cus").val(data.message.fullname);
$("#nic1").val(data.message.nic);
$("#address1").val(data.message.address);
$("#deposit").val(data.message.deposit);
$("#deposit_amount").val(data.message.deposit);
$("#deposit3").html(data.message.deposit);

$("#email2").val(data.message.email);
$("#phone2").val(data.message.mobile);
$("#nic3").val(data.message.nic);
$("#address2").val(data.message.address);
$("#email2_").val(data.message.email);
$("#phone2_").val(data.message.mobile);
$("#nic3_").val(data.message.nic);
$("#address2_").val(data.message.address);
$("#deposit_amount23").val(data.message.deposit);
$("#deposit_amount1").val(data.message.deposit);
$("#search-phone").val(data.message.fullname);
$("#search-phone1").val(data.message.fullname);



//alert(data.message.trans_grade_minimum);
}
else{
//alert(data.message);

$("#email2").val('');
$("#phone2").val('');
$("#nic3").val('');
$("#address2").val('');
$("#email2_").val('');
$("#phone2_").val('');
$("#nic3_").val('');
$("#address2_").val('');
$("#deposit_amount23").val('0');
$("#deposit_amount23").val('0');
$("#search-phone").val('');
$("#search-phone1").val('');



}
}

});
}



function get_value_item_customer_three(){

var id = $("#search-phone12").val()
var  name = $("#search-area12").val()
$.ajax({
               url: 'get_uni_customer_three',
               data: {data:id,name:name},
               type: 'POST',
              success:function(data){
if(data.error==true){
//               $("#customer").html(data.message);
//console.log(data.message.id);
//alert(data.message.id);
$("#email").val(data.message.email);
$("#phone").val(data.message.mobile);
$("#cus").val(data.message.fullname);
$("#nic1").val(data.message.nic);
$("#address1").val(data.message.address);
$("#deposit").val(data.message.deposit);
$("#deposit_amount").val(data.message.deposit);
$("#deposit3").html(data.message.deposit);

$("#email2").val(data.message.email);
$("#phone2").val(data.message.mobile);
$("#nic3").val(data.message.nic);
$("#address2").val(data.message.address);
$("#email2_").val(data.message.email);
$("#phone2_").val(data.message.mobile);
$("#nic3_").val(data.message.nic);
$("#address2_").val(data.message.address);
$("#deposit_amount23").val(data.message.deposit);
$("#deposit_amount1").val(data.message.deposit);
$("#search-phone").val(data.message.fullname);
$("#search-phone1").val(data.message.fullname);



//alert(data.message.trans_grade_minimum);
}
else{
//alert(data.message);

$("#email2").val('');
$("#phone2").val('');
$("#nic3").val('');
$("#address2").val('');
$("#email2_").val('');
$("#phone2_").val('');
$("#nic3_").val('');
$("#address2_").val('');
$("#deposit_amount23").val('0');
$("#deposit_amount23").val('0');
$("#search-phone").val('');
$("#search-phone1").val('');


$("#email").val('');
$("#phone").val('');
$("#cus").val('');
$("#nic1").val('');
$("#address1").val('');
$("#deposit").val('');
$("#deposit_amount").val(0);
$("#deposit3").html(0)



}
}

});



}





function get_value_order_item_details(){

var id = $("#order_id").val()
$.ajax({
               url: 'get_value_order_item_details',
               data: {data:id},   
               type: 'POST',
              success:function(data){
//console.log(data);
if(data.error==true){
for(i=0;i<data.message.length;i++){
alert("Code "+data.message[i].product_code + "--- Name"+ data.message[i].product_name);


}
console.log(data);
//               $("#customer").html(data.message);
//console.log(data.message.id);
//alert(data.message.id);
/*  $("#email").val(data.message.email);
$("#phone").val(data.message.mobile);
$("#nic1").val(data.message.nic);
$("#address1").val(data.message.address);
$("#deposit").val(data.message.deposit);
$("#deposit_amount").val(data.message.deposit);
$("#deposit3").html(data.message.deposit);

*/

//alert(data.message.trans_grade_minimum);
}
else{
//alert(data.message);
}
}

});
}


function updated_v(q){
x = event.keyCode;
//alert(x);
if((x>=49 && x<=57) || x==8 ){
vall = $("#qty_"+q).val();

$("#final_total_qty").val(vall);
vallll = $("#final_total_qty").val();
//alert(vall);
//alert(vallll);
$("#final_purchased_item").html(vall);

Price_calculation(q);
}
else{
  $("#qty_"+q).val(1);
}


}


function total_price(id){

var myForm = document.forms.sales_form11;
//var mini = myForm.elements['mini1[]'];
var mini = $("input[name='mini1[]']")
              .map(function(){return $(this).val();}).get();

var qty= $("input[name='qty12[]']")
              .map(function(){return $(this).val();}).get();

var weight1 = $("input[name='weight1[]']")
              .map(function(){return $(this).val();}).get();

var price= $("input[name='price[]']")
              .map(function(){return $(this).val();}).get();

var total_price_final1 = $("input[name='total_price_final1[]']")
              .map(function(){return $(this).val();}).get();
//vat = 0;
//parsedTest = JSON.parse(test);
//alert(qty5.length)
//for(var i1=0;i1<qty5.length;i1++){
//vat = vat+parseInt(qty5[i1]);
//alert(weight5[i1])
//}
//alert(vat);
//console.log(mini5);console.log(qty5);console.log(weight5);console.log(price5);
//console.log(total_price_final15 );
//alert(values.length);



//var qty = myForm.elements['qty12[]'];
//var weight1 = myForm.elements['weight1[]'];
//var price = myForm.elements['price[]'];
//var total_price_final1 = myForm.elements['total_price_final1[]'];
 var tmini=0; var tqty=0; var tweight=0; var total_price1=0;total_price1_final=0;
//alert($("#qty_1").val());
 $("#final_total_qty").val($("#qty_1").val());

$("#final_purchased_item").html($("#qty_1").val());


 for (var i = 0; i < mini.length; i++) {
    var tmini =parseFloat(tmini)+ parseFloat(mini[i]);
    var tqty=parseFloat(tqty)+ parseFloat(qty[i]);
    var tweight=parseFloat(tweight)+ parseFloat(weight1[i]);

    totalproductprice =  parseFloat(qty[i])  * parseFloat(mini[i]) ;

    totalproductprice_ =  parseFloat(qty[i])  * parseFloat(price[i]) ;

    totalqty =  parseFloat(qty[i])  * parseFloat(weight1[i]) ;
   
 total_price1 =parseFloat(total_price1)+ parseFloat(totalproductprice);
 
 total_price1_final =parseFloat(total_price1_final)+ parseFloat(totalproductprice_);


//alert("To"+totalproductprice_)
//alert("mini"+totalproductprice);
/* alert("Qty"+totalqty);
//alert(qty[i].value);
 alert("weight"+tweight);
 alert("Totalt"+tqty);
 alert("total_min"+tmini); 
*/

}

if(parseInt(total_price1_final)>parseInt(total_price1)){$("#pay_dis").removeAttr("disabled");}else{$("#pay_dis").attr("disabled","disabled");}



/* if(total_price1_final ==0 ){
//for minimum total_price1  = id;
//$("#final_total_qty").val(1);
//var ff = $("#final_total_qty").val();

//$("#final_purchased_item").html(1);
tqty =1;

total_price1_final = id;
}
*/



//total_price1_final
//total_price1= total_price1.toLocaleString();
total_price1_final2 = total_price1_final;
//total_price1_final = total_price1_final.toLocaleString();
//alert(total_price1_final);
$("input[name=to]").val($.number(total_price1_final,2));
$("input[name=to1]").val(total_price1_final2);
$("#final_total_payable").val(total_price1_final2);
$("#final_payable_amt").html(total_price1_final);
$("#final_total_qty").val(tqty);
$("#final_purchased_item").html(tqty);




}




function detva(id){

val = $("#"+id).val();
alert(val);
if(val=='0'){
$("#code").css("display","none");
}
}
 function getva(id){
val = $("#"+id).val()
name = $("#"+id).attr("name");
//alert(val);
//alert(name);
data= ['old','exchange','order_extimate','discount','newitem'];
//alert(data[0])
for(i=0;i<5;i++){

if(data[i]!=name){
$('input[name='+data[i]+']').removeAttr('checked');
}

else if(data[i]==name){
er = $('#'+id).val();
er1 = $('.'+name).text();
//$("#dfs").click();
$("#subsec").val(er1)
$("#subval").val(er)
//alert(er);alert(er1);
}


}
//alert(name)
valuess = $("#"+id).val();
//alert(valuess)
 if(data[2]==name && valuess==1){
//$("#order_model2").click();
//alert(er);alert(er1);
$('input[name='+data[2]+']').removeAttr('disabled');
$('input[name='+data[4]+']').attr('disabled','disabled');
}

if(data[1]==name && valuess==1){
$("#order_model1").click();
//alert(er);alert(er1);
}

if(data[3]==name && valuess==1){
$("#order_model3").click();
//alert(er);alert(er1);
}

if(data[0]==name && valuess==1){
$("#order_model0").click();
$('input[name='+data[4]+']').removeAttr("disabled");
$('input[name='+data[2]+']').attr("disabled","disabled");
//alert(er);alert(er1);
}

//$(this).attr('checked', false);
//$(this).attr('checked', false);
//$(this).attr('checked', true);
if(val==1){
$("#code").css("display","block");
}
else{
$("#code").css("display","none");
}
}


function Price_calculation(id){

val = $("#price"+id).val();
val1 = $("#mini"+id).val();
qty = $("#qty_"+id).val();
//alert(val + "" + val1);
//or1 = numberWithCommas(val);


//val = $("#price"+id).val(or1);
total_price1 = qty*val;
if(val.length>=4){

if(parseFloat(val)<=parseFloat(val1)){
$("#total_price_final"+id).val();
$("#total_price_final1"+id).val($.number(0,2));
if(parseFloat(val)<=parseFloat(val1)){


$("#pay_dis").attr("disabled");

total_price(total_price1);
}
$("#pay_dis").attr("disabled");
$("#mes").html("<p class='text-warning text-center'>Manual Price is not smaller than minimum price")
}else{
total_price(total_price1);
$("#total_price_final"+id).val(total_price1);
$("#total_price_final1"+id).val($.number(total_price1,2));
$("#mes").html("<p class='text-info text-center'>It is okey");
total_price(total_price1);
}

}

else if(val.length==0){
$("#mes").html(" ");
$("#pay_dis").attr("disabled");
total_price(total_price1);
}

else{
if(parseFloat(val)>=parseFloat(val1)){
total_price(total_price1);
$("#pay_dis").attr("disabled");
}else{
$("#pay_dis").attr("disabled");
}
$("#mes").html("<p class='text-warning text-center'>So Small");
}


}
function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

</script>
<script>
$('#timepicker4Modal').on('shown.bs.modal', function () {
            
            var cartitem    = document.getElementById("final_total_qty").value;
            $('#paid').val(0)
            if(cartitem == 0){
                $('#timepicker4Modal').modal('hide');
alert("sdfsf")
                $('#errornoitem').modal('show');
            } else {
                
                $("#paid").attr("required", true);
                $("#paymentLoadCust").focus();
                //document.getElementById("hold_bill_submit").style.display = "none";
                
                var addNewCustomer = $.ajax({
                        url     : '<?=base_url()?>gold/loadCustomer',
                        type    : 'GET',
                        cache   : false,
                        data    : {
                            format: 'json'
                        },
                        error   : function() {
                            //alert("Sorry! we do not have stock!");
alert("sdfsf")
                        },
                        dataType: 'json',
                        success : function(data) {
alert("success")
                            //var data_display = data.display;
                            //var category  = data.categories;
                                                        $('#deposit').html(data.deposit);
                                                        $('#deposit_amount').val(data.deposit);
                            var jsonData = jQuery.parseJSON(JSON.stringify(data));
                            var select, i, option;
                            
                            document.getElementById("paymentLoadCust").options.length = 0;
                            
                            select = document.getElementById( 'paymentLoadCust' );
                            
                            for (var i = 0; i < jsonData.categories.length; i++) {
                                var counter = jsonData.categories[i];
                                console.log(counter.cust_id);
                                
                                var cust_id     = counter.cust_id;
                                var cust_name   = counter.cust_name;
                                
                                option = document.createElement( 'option' );
                                option.value = cust_id;
                                option.text = cust_name;
                                select.add( option );
                            }
                            
                            
                            
                            document.getElementById("loadPaymentCustomer").innerHTML = data_display;
                        }
                    });
                    
            }
            
        })
        $('#timepicker4Modal').on('hidden.bs.modal', function () {
            document.getElementById("paid").required = false;
            document.getElementById("hold_bill_submit").style.display = "block";
        })
        
        $('html').bind('keypress', function(e)
        {
           if(e.keyCode == 13)
           {
              return false;
           }
        });
</script>
<div id="timepicker4Modal" class="modal fade"> 
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #373942;">
                    <h3 class="modal-title" style="color: #FFF;">Payment</h3>
                </div>
                <div class="modal-body" style="overflow: visible; background-color: #FFF;">
                    <div class="row">
                         <!-- <div class="col-md-6">
                            <b>Customer</b>
                        </div > -->
                        <!-- <div class="col-md-6"> -->

<script type="text/javascript" src="<?=base_url()?>assets/js/search/jquery.searchabledropdown.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        jQuery.browser = {};
        (function () {
            jQuery.browser.msie = false;
            jQuery.browser.version = 0;
            if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
                jQuery.browser.msie = true;
                jQuery.browser.version = RegExp.$1;
            }
        })();       
        
        $("#paymentLoadCust").searchable(); 
        $("#openBillLoadCust").searchable();        
    });
</script>
 <!-- <select name="customer" tabindex="1" id="paymentLoadCust" autofocus class="form-control" style="border: 1px solid #3a3a3a; color: #010101;">
                                
                            </select> 
<input type="hidden" id='deposit_amount' /> 
                             <div id="loadPaymentCustomer"></div>
                                
                        </div> -->
                    </div>
                    <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                         <div class="col-md-6"><b>Deposit</b></div>
                        <div class="col-md-6">
                            <span id="deposit3" style="background-color: #FFFF99; padding: 5px 10px;"></span>
                        </div> 
                    </div>
                    <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                        <div class="col-md-6"><b>Total Payable Amount</b></div>
                        <div class="col-md-6">
                            <span id="final_payable_amt" style="background-color: #FFFF99; padding: 5px 10px;"></span>
                        </div>
                    </div>
                    
                    <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                        <div class="col-md-6"><b>Total Purchased Items</b></div>
                        <div class="col-md-6">
                            <span id="final_purchased_item" style="background-color: #FFFF99; padding: 5px 10px;"></span>
                        </div>
                    </div>
                    
<script type="text/javascript">     
    function checkChequePayment(ele){
        if(ele == "5"){         // Cheque;
            document.getElementById("paid").readOnly            = false;
            document.getElementById("paid").value               = 0;
            document.getElementById("return_change").innerHTML  = 0;
            document.getElementById("card_numb").value          = "";
            document.getElementById("cheque").value             = "";
            
            
            document.getElementById("addi_card_numb").value                 = "";
            document.getElementById("addi_card_numb_wrp").style.display     = "none";
            document.getElementById("addi_card_numb").required              = false;
            
        //  document.getElementById("submit_btn").style.display = "none";
            
            document.getElementById("card_wrp").style.display = "none";
            document.getElementById("card_numb").required = false;
            
            document.getElementById("cheque_wrp").style.display = "block";
            document.getElementById("cheque").required = true;
            document.getElementById("cheque").focus();
            
        } else if ( (ele == "3") || (ele == "4") ) {        // VISA and Master;
            
            document.getElementById("paid").readOnly            = false;
            document.getElementById("paid").value               = 0;
            document.getElementById("return_change").innerHTML  = 0;
            document.getElementById("card_numb").value          = "";
            document.getElementById("cheque").value             = "";
            document.getElementById("addi_card_numb").value     = "";
            
            document.getElementById("addi_card_numb_wrp").style.display     = "block";
            document.getElementById("addi_card_numb").required              = true;
            document.getElementById("addi_card_numb").focus();
            
            //document.getElementById("submit_btn").style.display = "none";
            
            document.getElementById("card_wrp").style.display = "none";
            document.getElementById("card_numb").required = false;
            
            document.getElementById("cheque_wrp").style.display = "none";
            document.getElementById("cheque").required = false;
            
            
        } else if (ele == "7") {        // Gift Card;
            document.getElementById("paid").value               = 0;
            document.getElementById("return_change").innerHTML  = 0;
            document.getElementById("card_numb").value          = "";
            document.getElementById("cheque").value             = "";
            document.getElementById("addi_card_numb").value     = "";
            
            //document.getElementById("submit_btn").style.display = "none";
            
            document.getElementById("cheque_wrp").style.display = "none";
            document.getElementById("cheque").required = false;
            
            document.getElementById("addi_card_numb_wrp").style.display     = "none";
            document.getElementById("addi_card_numb").required              = false;
            
            document.getElementById("card_wrp").style.display = "block";
            document.getElementById("card_numb").required = true;
            document.getElementById("card_numb").focus();
            
        } else if(ele == "6"){          // Debit;
            document.getElementById("paid").readOnly            = false;
            document.getElementById("paid").value               = 0;
            document.getElementById("return_change").innerHTML  = 0;
            document.getElementById("card_numb").value          = "";
            document.getElementById("cheque").value             = "";
            document.getElementById("addi_card_numb").value     = "";
            
            //document.getElementById("submit_btn").style.display = "block";
            
            document.getElementById("cheque_wrp").style.display = "none";
            document.getElementById("cheque").required = false;
            
            document.getElementById("addi_card_numb_wrp").style.display     = "none";
            document.getElementById("addi_card_numb").required              = false;
            
            document.getElementById("card_wrp").style.display = "none";
            document.getElementById("card_numb").required = false;
            
        }else if(ele == "8"){           // Deposit;
            
                        var deposit_val = $('#deposit_amount').val();
                        var total =$('#final_total_payable').val();
                        console.log('total'+total+'deposot'+deposit_val)
                        document.getElementById("paid").readOnly            = true;
            
                        document.getElementById("paid").value               = 0;
            if(parseFloat(total) <= parseFloat(deposit_val)){
                            //document.getElementById("submit_btn").style.display = "block";
                            document.getElementById("paid").value = total;

                        } else {
                             //   document.getElementById("submit_btn").style.display = "none";

                        }
                        document.getElementById("return_change").innerHTML  = 0;
            
                        document.getElementById("card_numb").value          = "";
            document.getElementById("cheque").value             = "";
            document.getElementById("addi_card_numb").value     = "";
            
            
            document.getElementById("cheque_wrp").style.display = "none";
            document.getElementById("cheque").required = false;
            
            document.getElementById("addi_card_numb_wrp").style.display     = "none";
            document.getElementById("addi_card_numb").required              = false;
            
            document.getElementById("card_wrp").style.display = "none";
            document.getElementById("card_numb").required = false;
            
        }
                else {
            
            document.getElementById("paid").readOnly            = false;
            document.getElementById("paid").value               = 0;
            document.getElementById("return_change").innerHTML  = 0;
            document.getElementById("card_numb").value          = "";
            document.getElementById("cheque").value             = "";
            document.getElementById("addi_card_numb").value     = "";
            
            //document.getElementById("submit_btn").style.display = "none";
            
            document.getElementById("cheque_wrp").style.display = "none";
            document.getElementById("cheque").required = false;
            
            document.getElementById("addi_card_numb_wrp").style.display     = "none";
            document.getElementById("addi_card_numb").required              = false;
            
            document.getElementById("card_wrp").style.display = "none";
            document.getElementById("card_numb").required = false;
        }
    }
</script>           
                    <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                        <div class="col-md-6"><b>Paid by :</b></div>
                        <div class="col-md-6">
                            <select name="paid_by" tabindex="2" id="paid_by" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" onchange="checkChequePayment(this.value)">
                            <?php
                                $payMethodData = $this->Constant_model->getDataOneColumn('payment_method', 'status', '1');
                                for ($p = 0; $p < count($payMethodData); ++$p) {
                                    $payMethod_id = $payMethodData[$p]->id;
                                    $payMethod_name = $payMethodData[$p]->name; ?>
                                    <option value="<?php echo $payMethod_id; ?>"><?php echo $payMethod_name; ?></option>
                            <?php

                                }
                            ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row" id="cheque_wrp" style="padding-top: 10px; padding-bottom: 10px; display: none;">
                        <div class="col-md-6"><b>Cheque Number :</b></div>
                        <div class="col-md-6">
                            <input type="text" tabindex="3" name="cheque" class="form-control" id="cheque" placeholder="Cheque Number" style="border: 1px solid #3a3a3a; color: #010101;" />
                        </div>
                    </div>

<script src="<?=base_url()?>assets/js/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#card_numb').inputmask("9999 9999 9999 9999");
        
        $("#card_numb").on("keyup", function(event) {
            
            var card_numb       = document.getElementById("card_numb").value;
            
            //alert(card_numb.length);
            
            if(card_numb.length == 0) {
              //  document.getElementById("submit_btn").style.display = "none";
            } else if(card_numb.indexOf('_') == -1){
                
                var addNewCustomer = $.ajax({
                    url     : '<?=base_url()?>pos/loadGiftCardValue?card_numb='+card_numb,
                    type    : 'GET',
                    cache   : false,
                    data    : {
                        format: 'json'
                    },
                    error   : function() {
                        //alert("Sorry! we do not have stock!");
                    },
                    dataType: 'json',
                    success : function(data) {
                        var card_value  = data.value;
                        var card_status = data.errorMsg;
                        
                        if(card_status == "failure"){
                            
                            document.getElementById("paid").value               = 0;
                            document.getElementById("return_change").innerHTML  = 0;
                            
                        //  document.getElementById("submit_btn").style.display = "none";
                            alert("Card Do not Exist!");
                            document.getElementById("card_numb").value  = "";
                            
                        } else if (card_status == "used"){
                            
                            document.getElementById("paid").value               = 0;
                            document.getElementById("return_change").innerHTML  = 0;
                            
                            //document.getElementById("submit_btn").style.display = "none";
                            alert("Card used!");
                            document.getElementById("card_numb").value  = "";
                            
                        } else if (card_status == "expired"){
                            
                            document.getElementById("paid").value               = 0;
                            document.getElementById("return_change").innerHTML  = 0;
                            
                            //document.getElementById("submit_btn").style.display = "none";
                            alert("Card Expired!");
                            document.getElementById("card_numb").value  = "";
                            
                        } else if (card_status == "success"){
                            
                            document.getElementById("paid").readOnly            = true;
                            document.getElementById("paid").value               = card_value;
                            //document.getElementById("submit_btn").style.display = "block";
                            
                            document.getElementById("paid").onclick = false;
                            
                            calculatePaidAmtGift(card_value);
                        }
                        
                    }
                });
                
                //document.getElementById("submit_btn").style.display = "block";
            } else {
                //document.getElementById("submit_btn").style.display = "none";
            }
            
            
        });
        
        
    });
</script> 
                    
                    <div class="row" id="card_wrp" style="padding-top: 10px; padding-bottom: 10px; display: none;">
                        <div class="col-md-6"><b>Gift Card Number :</b></div>
                        <div class="col-md-6">
                            <input type="text" name="card_numb" class="form-control" id="card_numb" placeholder="Gift Card Number" style="border: 1px solid #3a3a3a; color: #010101;" />
                        </div>
                    </div>
                    
                    <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                        <div class="col-md-6"><b>Paid :</b></div>
                        <div class="col-md-6">
                                                    <input type="number" step="0.01" tabindex="4" name="paid" id="paid" class="form-control" placeholder="0.00" style="border: 1px solid #3a3a3a; color: #010101;" 
                                                           onchange="chkReturn(this.value)" onkeyup="chkReturn(this.value)"               autocomplete="off" />
                        </div>
                    </div>
                    
                    <div class="row" id="addi_card_numb_wrp" style="padding-top: 10px; padding-bottom: 10px; display: none;">
                        <div class="col-md-6"><b>Card Number :</b></div>
                        <div class="col-md-6">
                            <input type="text" name="addi_card_numb" id="addi_card_numb" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" />
                        </div>
                    </div>
                    
                    <div class="row" style="padding-top: 10px; padding-bottom: 10px;">
                        <div class="col-md-6"><b>Return Change :</b></div>
                        <div class="col-md-6">
                            <span id="return_change" style="background-color: #FFFF99; padding: 10px 10px;"></span>
                            <input type="hidden" id="returned_change" name="returned_change" value="0" />
                        </div>
                    </div>
                    
                </div>
                
                <div class="modal-footer" style="margin-top: 0px;">
                    <input type="button" value="Add Payment" class="btn btn-primary" id="submit_btn" style="background-color: #3fb618; color: #FFF; border: 0px; padding: 5px 25px; float: right; display: block;" />
                </div>
            </div>
        </div>
    </div>
    

    <input type="hidden" name="row_count" id="row_count" value="<?php //echo $sus_row_count; ?>" />
<!--    <input type="hidden" name="row_count" id="row_count" value="1" /> -->
    
    <input type="hidden" name="final_total_payable" id="final_total_payable" value="" />
    <input type="hidden" name="final_total_qty" id="final_total_qty" value="" />
    
    <input type="hidden" name="tax" id="tax" value="<?php //echo $tax; ?>" />
    <input type="hidden" name="tax_amt" id="tax_amt" value="<?php //echo $tax_amt; ?>" />
    
    <input type="hidden" name="subTotal" id="subTotal" value="<?php //echo $subTotal; ?>" />
    <input type="hidden" name="total_paid"  id="total_paid" value="0" />
        
    <input type="hidden" name="suspend_id" value="<?php //echo $suspend_id; ?>" />
    
    <input type="hidden" name="outlet" id="outlet" value="<?php //echo $outlet; ?>" />
    <div class="row">
<!--            <div class="col-sm-4" >
                     <p style="color:red;">Payment Details</p>
                     <p style="color:red;" >Total Bill: <span id="h2_gtotal"><?php //echo $grandTotal;?></span></p>
            </div> -->
                <div class="col-sm-4" id="pumper_sale">
                    <?php 
                    $paid_bys1 =  $this->Constant_model->getddData('payment_method','id','name', 'id');

                    foreach($paid_bys1 as $id=>$obj){?>
                    <input type="hidden" id="hpbamount_<?php echo $id;?>" name="hpbamount_<?php echo $id;?>" value="0.00" />
                    <input type="hidden" id="single_pb_amount_<?php echo $id;?>" name="single_pb_amount_<?php echo $id;?>" value="0.00" />
                    <span id="payment_sp<?php echo $id;?>"></span>
                    <?php } ?>
                    <div class="row" id="short_row" style="display:none">
                        <div class="col-md-6">Paid Today</div>
                        <div class="col-md-6" id="paid_div"> </div>
                        <div class="col-md-6">Remaining</div>
                        <div class="col-md-6" id="short_div"> </div>
                        </div>
                    

                </div>
                <div class="col-sm-4" style="text-align:center" >
                     <input type="hidden" id="totalcount" value="" />
                <input type="hidden" id="curr_index" value="0" />
                <button type="submit" name="sendBtn" class="btn btn-success" id="sendBtn" style="display:none">Submit</button>
                 </div>
    </div>
    </form>
</div><!-- Right Colmn // END -->



<script>
    
        
/*  var logDiv = $( "#log" );

    for ( var i = 0; i <= <?php echo $pp; ?>; i++ ) {
        $( "button" ).eq( i ).on( "click", {val: $('#txtMessage_'+i).val()}, function( event ) {
        
            var row_count           = document.getElementById("row_count").value;
            row_count               = parseInt(row_count);
            add_row_count           = row_count;
            console.log('btn clicked')
            var discount_amt        = document.getElementById("dis_amt").value;
            if(discount_amt.length == 0){
                discount_amt        = 0;
            }
            discount_amt            = parseFloat(discount_amt);
        
            var tax                 = document.getElementById("tax").value;
            tax                     = parseFloat(tax);
            
            var pcode               = event.data.val;
            
            var temp_outlet         = document.getElementById("outlet").value;
                        var img_src         = document.getElementById("img"+pcode).src;

            
            //document.getElementById("row_count").value    = add_row_count;
            
            var resultPrice = $.ajax({
                    url     : '<?=base_url()?>pos/getProductDetail?pcode='+pcode+'&outlet_id='+temp_outlet+'&img_src='+img_src,
                    type    : 'GET',
                    cache   : false,
                    data    : {
                        format: 'json'
                    },
                    error   : function() {
                        //alert("Sorry! we do not have stock!");
                    },
                    dataType: 'json',
                    success : function(data) {
                        var name        = data.prod_name;
                        var price       = data.price;
                        var qty         = data.qty;
                        var is_service          =data.is_service;
                        
                        if(add_row_count == 1){
                            
                            if(qty >= 1 || parseInt(is_service)==1){
                                                                
                                                                var service_str = (is_service==0)? '<br />'+qty+' Available':'';
                                var msgs        = '<div class="row" id="item_row_'+add_row_count+'" style="margin: 0px; border-bottom: 1px solid #dddddd; padding-top: 5px; padding-bottom: 5px;"><div class="col-md-4" style="background-color: #4d9fe4; color: #FFF;"><img src="'+img_src+'"/><br /> '+name+' <br />['+pcode+']'+service_str+'</div><div class="col-md-4" style="text-align: center; font-size: 15px; color: #000;"><div class="row"><div class="col-md-3" style="padding-top:7px"><span onclick="minusDiv('+add_row_count+')" style="cursor:pointer;"><img src="<?=base_url()?>assets/img/minus_icon.png" /></span></div><div class="col-md-6" style="padding-left: 0px; padding-right: 0px;"><input type="text" autofocus id="display_qty_'+add_row_count+'" class="form-control" value="1" onchange="manualQty(this.value, '+add_row_count+')" style="text-align:center;" /></div><div class="col-md-3" style="padding-left:0px; padding-top:7px;"><span onclick="plusDiv('+add_row_count+')" style="cursor:pointer;"><img src="<?=base_url()?>assets/img/plus_icon.png" /></span></div></div></div><div class="col-md-3">'+price+'</div><div class="col-md-1" style="font-weight: bold;"><span onclick="deleteDiv('+add_row_count+')" style="cursor:pointer;">x</span></div></div><input type="hidden" name="pcode_'+add_row_count+'" id="pcode_'+add_row_count+'" value="'+pcode+'" /><input type="hidden" name="price_'+add_row_count+'" id="price_'+add_row_count+'" value="'+price+'" /><input type="hidden" name="qty_'+add_row_count+'" id="qty_'+add_row_count+'" value="1" />';
                                logDiv.append( msgs + "" );
                                                                $('#display_qty_'+add_row_count).focus();

                                add_row_count++;
                                document.getElementById("row_count").value  = add_row_count;
                            } else {
                                $('#outofstockwrp').modal('show');
                                //alert("Out of Stock! Please Make Purchase Order!");
                            }
                        } else {
                            
                            var check_existing_pcode    = 0;
                            
                            for(var q = 1; q < add_row_count; q++){
                                var exist_pcode     = document.getElementById("pcode_"+q).value;
                                
                                if(pcode == exist_pcode){
                                    check_existing_pcode++;
                                }   
                            }
                            
                            if(check_existing_pcode == 0){
                                
                                if(qty >= 1 || parseInt(is_service)==1){
                                                                        var service_str = (is_service==0)? '<br />'+qty+' Available':'';

                                    var msgs        = '<div class="row" id="item_row_'+add_row_count+'" style="margin: 0px; border-bottom: 1px solid #dddddd; padding-top: 5px; padding-bottom: 5px;"><div class="col-md-4" style="background-color: #4d9fe4; color: #FFF;"><img src="'+img_src+'"/> '+name+' <br />['+pcode+']'+service_str+'</div><div class="col-md-4" style="text-align: center; font-size: 15px; color: #000;"><div class="row"><div class="col-md-3" style="padding-top:7px"><span onclick="minusDiv('+add_row_count+')" style="cursor:pointer;"><img src="<?=base_url()?>assets/img/minus_icon.png" /></span></div><div class="col-md-6" style="padding-left: 0px; padding-right: 0px;"><input type="text" autofocus id="display_qty_'+add_row_count+'" class="form-control" value="1" onchange="manualQty(this.value, '+add_row_count+')" style="text-align:center;" /></div><div class="col-md-3" style="padding-left:0px; padding-top:7px;"><span onclick="plusDiv('+add_row_count+')" style="cursor:pointer;"><img src="<?=base_url()?>assets/img/plus_icon.png" /></span></div></div></div><div class="col-md-3">'+price+'</div><div class="col-md-1" style="font-weight: bold;"><span onclick="deleteDiv('+add_row_count+')" style="cursor:pointer;">x</span></div></div><input type="hidden" name="pcode_'+add_row_count+'" id="pcode_'+add_row_count+'" value="'+pcode+'" /><input type="hidden" name="price_'+add_row_count+'" id="price_'+add_row_count+'" value="'+price+'" /><input type="hidden" name="qty_'+add_row_count+'" id="qty_'+add_row_count+'" value="1" />';
                                    logDiv.append( msgs + "" );
                                                                        $('#display_qty_'+add_row_count).focus();

                                    add_row_count++;
                                    document.getElementById("row_count").value  = add_row_count;
                                } else {
                                    $('#outofstockwrp').modal('show');
                                    //alert("Out of Stock! Please make Purchase Order!");
                                }
                            } else {
                                
                                for(var q = 1; q < add_row_count; q++){
                                    var exist_pcode     = document.getElementById("pcode_"+q).value;
                                    var exist_qty       = document.getElementById("qty_"+q).value;
                                    
                                    exist_qty           = parseInt(exist_qty);
                                    
                                    if(pcode == exist_pcode){
                                        var new_qty     = exist_qty + 1;
                                        
                                        if(qty >= new_qty || parseInt(is_service)==1){
                                            //document.getElementById("display_qty_"+q).innerHTML   = new_qty;
                                            document.getElementById("display_qty_"+q).value         = new_qty;  
                                            document.getElementById("qty_"+q).value                 = new_qty;
                                                                                        document.getElementById("display_qty_"+q).focus();
                                        } else {
                                            $('#outofstockwrp').modal('show');
                                            //alert("Out of Stock! Please make Purchase Order!");
                                        }
                                        
                                        
                                    }
                                }
                                
                                
                                
                            }
                            
                        }
                        
                        
                        
                        //document.getElementById("row_count").value    = add_row_count;
                        
                        var total_item_qty      = 0;
                        var total_item_price    = 0;
                        for(var p = 1; p < add_row_count; p++){
                            var each_price      = document.getElementById("price_"+p).value;
                            var each_qty        = document.getElementById("qty_"+p).value;
                            
                            each_price          = parseFloat(each_price);
                            each_qty            = parseInt(each_qty);
                            
                            //alert(each_qty);
                            
                            total_item_price    += (each_price * each_qty);
                            
                            if(each_price > 0){
                                total_item_qty += each_qty;
                            }
                        }
                        
                        total_item_price    = total_item_price - discount_amt;
                        
                        var total_tax_amt   = total_item_price * (tax/100);
                        
                        var grandTotal      = total_item_price + total_tax_amt;
                        grandTotal          = grandTotal.toFixed(2);
                        
                        
                        document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
                        document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
                        
                        document.getElementById("total_price").innerHTML            = total_item_price.toFixed(2);
                        document.getElementById("total_payable").innerHTML          = grandTotal;
                        
                        // To display at Model;
                        document.getElementById("final_payable_amt").innerHTML      = grandTotal;
                        document.getElementById("final_purchased_item").innerHTML   = total_item_qty;
                        
                        // To Insert DB;
                        document.getElementById("final_total_payable").value        = grandTotal;
                        document.getElementById("final_total_qty").value            = total_item_qty;
                        
                        document.getElementById("total_item_qty").innerHTML         = total_item_qty;
                        
                        document.getElementById("subTotal").value                   = total_item_price.toFixed(2);
                        
                        
                        
                    }   // end of success;
            });
            
            
        });
    } */
    function manualQty(comQty, ele){
        var pcode       = document.getElementById("pcode_"+ele).value;
        var temp_outlet = document.getElementById("outlet").value;
        
        comQty          = parseInt(comQty);
        
        var new_qty     = comQty;
        
        if(new_qty < 1){
            document.getElementById("display_qty_"+ele).value   = "1";
            document.getElementById("qty_"+ele).value           = 1;
            
            var row_count       = document.getElementById("row_count").value;
            
            var upd_row_count       = 0;
            var total_item_qty      = 0;
            var total_item_price    = 0;
            for(var p = 1; p < row_count; p++){
                var each_price      = document.getElementById("price_"+p).value;
                var each_qty        = document.getElementById("qty_"+p).value;
                
                each_price          = parseFloat(each_price);
                each_qty            = parseInt(each_qty);
                
                total_item_price    += (each_price * each_qty);
                    
                if(each_price > 0){
                    total_item_qty += each_qty; 
                }
                    
                upd_row_count++;
                
            }
            
            var discount_amt        = document.getElementById("dis_amt").value;
            discount_amt            = parseFloat(discount_amt);
        //  alert(discount_amt);
            var tax                 = document.getElementById("tax").value;
            tax                     = parseFloat(tax);
            
            total_item_price        = total_item_price - discount_amt;
            
            var total_tax_amt       = total_item_price * (tax/100);
                            
            var grandTotal          = total_item_price + total_tax_amt;
            grandTotal              = grandTotal.toFixed(2);
            
            document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
            document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
            
            document.getElementById("total_price").innerHTML            = total_item_price.toFixed(2);
            document.getElementById("total_payable").innerHTML          = grandTotal;
            
            // to display at Model;
            document.getElementById("final_payable_amt").innerHTML      = grandTotal;
            document.getElementById("final_purchased_item").innerHTML   = total_item_qty;
            
            // to insert Database;
            document.getElementById("final_total_payable").value        = grandTotal;
            document.getElementById("final_total_qty").value            = total_item_qty;
            
            document.getElementById("total_item_qty").innerHTML         = total_item_qty;
            
            //document.getElementById("row_count").value                    = upd_row_count;
            
            document.getElementById("subTotal").value                   = total_item_price.toFixed(2);
            
            $("#openreachmini").modal('show');
        } else {
            var resultPrice = $.ajax({
                        url     : '<?=base_url()?>pos/getProductDetail?pcode='+pcode+'&outlet_id='+temp_outlet,
                        type    : 'GET',
                        cache   : false,
                        data    : {
                            format: 'json'
                        },
                        error   : function() {
                            //alert("Sorry! we do not have stock!");
                        },
                        dataType: 'json',
                        success : function(data) {
                            var name        = data.prod_name;
                            var price       = data.price;
                            var qty         = data.qty;
                                                        var is_service          =data.is_service;

                            if(qty >= new_qty || parseInt(is_service)==1){
                                
                                //document.getElementById("display_qty_"+ele).innerHTML     = new_qty;
                                document.getElementById("display_qty_"+ele).value       = new_qty;  
                                document.getElementById("qty_"+ele).value               = new_qty;
                                
                                var row_count       = document.getElementById("row_count").value;
            
                                var upd_row_count       = 0;
                                var total_item_qty      = 0;
                                var total_item_price    = 0;
                                for(var p = 1; p < row_count; p++){
                                    var each_price      = document.getElementById("price_"+p).value;
                                    var each_qty        = document.getElementById("qty_"+p).value;
                                    
                                    each_price          = parseFloat(each_price);
                                    each_qty            = parseInt(each_qty);
                                    
                                    total_item_price    += (each_price * each_qty);
                                        
                                    if(each_price > 0){
                                        total_item_qty += each_qty; 
                                    }
                                        
                                    upd_row_count++;
                                    
                                }
                                
                                var discount_amt        = document.getElementById("dis_amt").value;
                                discount_amt            = parseFloat(discount_amt);
                                
                                var tax                 = document.getElementById("tax").value;
                                tax                     = parseFloat(tax);
                                
                                total_item_price        = total_item_price - discount_amt;
                                
                                var total_tax_amt       = total_item_price * (tax/100);
                                                
                                var grandTotal          = total_item_price + total_tax_amt;
                                grandTotal              = grandTotal.toFixed(2);
                                
                                document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
                                document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
                                
                                document.getElementById("total_price").innerHTML            = total_item_price.toFixed(2);
                                document.getElementById("total_payable").innerHTML          = grandTotal;
                                
                                // to display at Model;
                                document.getElementById("final_payable_amt").innerHTML      = grandTotal;
                                document.getElementById("final_purchased_item").innerHTML   = total_item_qty;
                                
                                // to insert Database;
                                document.getElementById("final_total_payable").value        = grandTotal;
                                document.getElementById("final_total_qty").value            = total_item_qty;
                                
                                document.getElementById("total_item_qty").innerHTML         = total_item_qty;
                                
                                //document.getElementById("row_count").value                    = upd_row_count;
                                
                                document.getElementById("subTotal").value                   = total_item_price.toFixed(2);
                                
                            } else {
                                document.getElementById("display_qty_"+ele).value   = "1";
                                document.getElementById("qty_"+ele).value           = 1;
            
                                var row_count       = document.getElementById("row_count").value;
            
                                var upd_row_count       = 0;
                                var total_item_qty      = 0;
                                var total_item_price    = 0;
                                for(var p = 1; p < row_count; p++){
                                    var each_price      = document.getElementById("price_"+p).value;
                                    var each_qty        = document.getElementById("qty_"+p).value;
                                    
                                    each_price          = parseFloat(each_price);
                                    each_qty            = parseInt(each_qty);
                                    
                                    total_item_price    += (each_price * each_qty);
                                        
                                    if(each_price > 0){
                                        total_item_qty += each_qty; 
                                    }
                                        
                                    upd_row_count++;
                                    
                                }
                                
                                var discount_amt        = document.getElementById("dis_amt").value;
                                discount_amt            = parseFloat(discount_amt);
                                
                                var tax                 = document.getElementById("tax").value;
                                tax                     = parseFloat(tax);
                                
                                total_item_price        = total_item_price - discount_amt;
                                
                                var total_tax_amt       = total_item_price * (tax/100);
                                                
                                var grandTotal          = total_item_price + total_tax_amt;
                                grandTotal              = grandTotal.toFixed(2);
                                
                                document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
                                document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
                                
                                document.getElementById("total_price").innerHTML            = total_item_price.toFixed(2);
                                document.getElementById("total_payable").innerHTML          = grandTotal;
                                
                                // to display at Model;
                                document.getElementById("final_payable_amt").innerHTML      = grandTotal;
                                document.getElementById("final_purchased_item").innerHTML   = total_item_qty;
                                
                                // to insert Database;
                                document.getElementById("final_total_payable").value        = grandTotal;
                                document.getElementById("final_total_qty").value            = total_item_qty;
                                
                                document.getElementById("total_item_qty").innerHTML         = total_item_qty;
                                
                                //document.getElementById("row_count").value                    = upd_row_count;
                                
                                document.getElementById("subTotal").value                   = total_item_price.toFixed(2);
            
                                $('#outofstockwrp').modal('show');
                            }
                        }
                    });
                    
        }
    }
    
    function minusDiv(ele){
        var pcode       = document.getElementById("pcode_"+ele).value;
        var temp_outlet = document.getElementById("outlet").value;
        
        var curr_qty    = document.getElementById("qty_"+ele).value;
        curr_qty        = parseInt(curr_qty);
        
        var new_qty     = curr_qty - 1;
        
        if(new_qty < 1){
            $("#openreachmini").modal('show');  
        } else {
        
            var resultPrice = $.ajax({
                        url     : '<?=base_url()?>pos/getProductDetail?pcode='+pcode+'&outlet_id='+temp_outlet,
                        type    : 'GET',
                        cache   : false,
                        data    : {
                            format: 'json'
                        },
                        error   : function() {
                            //alert("Sorry! we do not have stock!");
                        },
                        dataType: 'json',
                        success : function(data) {
                            var name        = data.prod_name;
                            var price       = data.price;
                            var qty         = data.qty;
                            var is_service          = data.is_service;
                            if(qty >= new_qty || parseInt(is_service)==1){
                                
                                //document.getElementById("display_qty_"+ele).innerHTML     = new_qty;
                                document.getElementById("display_qty_"+ele).value       = new_qty;  
                                document.getElementById("qty_"+ele).value               = new_qty;
                                
                                var row_count       = document.getElementById("row_count").value;
            
                                var upd_row_count       = 0;
                                var total_item_qty      = 0;
                                var total_item_price    = 0;
                                for(var p = 1; p < row_count; p++){
                                    var each_price      = document.getElementById("price_"+p).value;
                                    var each_qty        = document.getElementById("qty_"+p).value;
                                    
                                    each_price          = parseFloat(each_price);
                                    each_qty            = parseInt(each_qty);
                                    
                                    total_item_price    += (each_price * each_qty);
                                        
                                    if(each_price > 0){
                                        total_item_qty += each_qty; 
                                    }
                                        
                                    upd_row_count++;
                                    
                                }
                                
                                var discount_amt        = document.getElementById("dis_amt").value;
                                discount_amt            = parseFloat(discount_amt);
                                
                                var tax                 = document.getElementById("tax").value;
                                tax                     = parseFloat(tax);
                                
                                total_item_price        = total_item_price - discount_amt;
                                
                                var total_tax_amt       = total_item_price * (tax/100);
                                                
                                var grandTotal          = total_item_price + total_tax_amt;
                                grandTotal              = grandTotal.toFixed(2);
                                
                                document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
                                document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
                                
                                document.getElementById("total_price").innerHTML            = total_item_price.toFixed(2);
                                document.getElementById("total_payable").innerHTML          = grandTotal;
                                
                                // to display at Model;
                                document.getElementById("final_payable_amt").innerHTML      = grandTotal;
                                document.getElementById("final_purchased_item").innerHTML   = total_item_qty;
                                
                                // to insert Database;
                                document.getElementById("final_total_payable").value        = grandTotal;
                                document.getElementById("final_total_qty").value            = total_item_qty;
                                
                                document.getElementById("total_item_qty").innerHTML         = total_item_qty;
                                
                                //document.getElementById("row_count").value                    = upd_row_count;
                                
                                document.getElementById("subTotal").value                   = total_item_price.toFixed(2);
                                
                            } else {
                                //document.getElementById("updInvPDT").innerHTML            = name+" ["+pcode+"]";;
                                //document.getElementById("updInvPcode").value          = pcode;
                                
                                //$("#openreachmini").modal('show');    
                            }
                        }
                    });
        }
    }
    
    function plusDiv(ele){
        var pcode       = document.getElementById("pcode_"+ele).value;
        var temp_outlet = document.getElementById("outlet").value;
        
        var curr_qty    = document.getElementById("qty_"+ele).value;
        curr_qty        = parseInt(curr_qty);
        
        var new_qty     = curr_qty + 1;
        
        var resultPrice = $.ajax({
                    url     : '<?=base_url()?>pos/getProductDetail?pcode='+pcode+'&outlet_id='+temp_outlet,
                    type    : 'GET',
                    cache   : false,
                    data    : {
                        format: 'json'
                    },
                    error   : function() {
                        //alert("Sorry! we do not have stock!");
                    },
                    dataType: 'json',
                    success : function(data) {
                        var name        = data.prod_name;
                        var price       = data.price;
                        var qty         = data.qty;
                        var is_service          = data.is_service;
                        if(qty >= new_qty || parseInt(is_service)==1){
                            
                            //document.getElementById("display_qty_"+ele).innerHTML     = new_qty;
                            document.getElementById("display_qty_"+ele).value       = new_qty;  
                            document.getElementById("qty_"+ele).value               = new_qty;
                            
                            var row_count       = document.getElementById("row_count").value;
        
                            var upd_row_count       = 0;
                            var total_item_qty      = 0;
                            var total_item_price    = 0;
                            for(var p = 1; p < row_count; p++){
                                var each_price      = document.getElementById("price_"+p).value;
                                var each_qty        = document.getElementById("qty_"+p).value;
                                
                                each_price          = parseFloat(each_price);
                                each_qty            = parseInt(each_qty);
                                
                                total_item_price    += (each_price * each_qty);
                                    
                                if(each_price > 0){
                                    total_item_qty += each_qty; 
                                }
                                    
                                upd_row_count++;
                                
                            }
                            
                            var discount_amt        = document.getElementById("dis_amt").value;
                            discount_amt            = parseFloat(discount_amt);
                            
                            var tax                 = document.getElementById("tax").value;
                            tax                     = parseFloat(tax);
                            
                            total_item_price        = total_item_price - discount_amt;
                            
                            var total_tax_amt       = total_item_price * (tax/100);
                                            
                            var grandTotal          = total_item_price + total_tax_amt;
                            grandTotal              = grandTotal.toFixed(2);
                            
                            document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
                            document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
                            
                            document.getElementById("total_price").innerHTML            = total_item_price.toFixed(2);
                            document.getElementById("total_payable").innerHTML          = grandTotal;
                            
                            // to display at Model;
                            document.getElementById("final_payable_amt").innerHTML      = grandTotal;
                            document.getElementById("final_purchased_item").innerHTML   = total_item_qty;
                            
                            // to insert Database;
                            document.getElementById("final_total_payable").value        = grandTotal;
                            document.getElementById("final_total_qty").value            = total_item_qty;
                            
                            document.getElementById("total_item_qty").innerHTML         = total_item_qty;
                            
                            //document.getElementById("row_count").value                    = upd_row_count;
                            
                            document.getElementById("subTotal").value                   = total_item_price.toFixed(2);
                            
                        } else {
                            //document.getElementById("updInvPDT").innerHTML            = name+" ["+pcode+"]";;
                            //document.getElementById("updInvPcode").value          = pcode;                            
                            
                            $('#outofstockwrp').modal('show');
                            
                            //$("#opendInventoryUpdate").modal('show');
                        }
                    }
                });
    }
    
    function deleteDiv(ele){
        
        $('#item_row_' + ele).remove();
        document.getElementById("pcode_"+ele).value             = "";
        document.getElementById("price_"+ele).value = 0;
        document.getElementById("qty_"+ele).value   = 0;
        
        var row_count       = document.getElementById("row_count").value;
        
        var upd_row_count       = 0;
        var total_item_qty      = 0;
        var total_item_price    = 0;
        for(var p = 1; p < row_count; p++){
            var each_price      = document.getElementById("price_"+p).value;
            var each_qty        = document.getElementById("qty_"+p).value;
            
            each_price          = parseFloat(each_price);
            each_qty            = parseInt(each_qty);
            
            total_item_price    += (each_price * each_qty);
                
            if(each_price > 0){
                total_item_qty += each_qty; 
            }
                
            upd_row_count++;
            
        }
        
        var discount_amt        = document.getElementById("dis_amt").value;
        discount_amt            = parseFloat(discount_amt);
        
        var tax                 = document.getElementById("tax").value;
        tax                     = parseFloat(tax);
        
        total_item_price        = total_item_price - discount_amt;
        
        var total_tax_amt       = total_item_price * (tax/100);
                        
        var grandTotal          = total_item_price + total_tax_amt;
        grandTotal              = grandTotal.toFixed(2);
        
        document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
        document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
        
        document.getElementById("total_price").innerHTML            = total_item_price.toFixed(2);
        document.getElementById("total_payable").innerHTML          = grandTotal;
        
        // to display at Model;
        document.getElementById("final_payable_amt").innerHTML      = grandTotal;
        document.getElementById("final_purchased_item").innerHTML   = total_item_qty;
        
        // to insert Database;
        document.getElementById("final_total_payable").value        = grandTotal;
        document.getElementById("final_total_qty").value            = total_item_qty;
        
        document.getElementById("total_item_qty").innerHTML         = total_item_qty;
        
        //document.getElementById("row_count").value                    = upd_row_count;
        
        document.getElementById("subTotal").value                   = total_item_price.toFixed(2);
    }
    
    function cancelSelected(){
        var row_count       = document.getElementById("row_count").value;
        document.getElementById("dis_amt").value    = 0;
        
        for(var r = 1; r < row_count; r++){
            $('#item_row_' + r).remove();
            document.getElementById("pcode_"+r).value = "";
            document.getElementById("price_"+r).value = 0;
            document.getElementById("qty_"+r).value = 0;
        }
        
        var upd_row_count       = 0;
        var total_item_qty      = 0;
        var total_item_price    = 0;
        for(var p = 1; p < row_count; p++){
            var each_price      = document.getElementById("price_"+p).value;
            var each_qty        = document.getElementById("qty_"+p).value;
            
            each_price          = parseFloat(each_price);
            each_qty            = parseInt(each_qty);
            
            total_item_price    += (each_price * each_qty);
                
            if(each_price > 0){
                total_item_qty += each_qty; 
            }
                
            upd_row_count++;
            
        }
        
        var discount_amt        = document.getElementById("dis_amt").value;
        discount_amt            = parseFloat(discount_amt);
        
        var tax                 = document.getElementById("tax").value;
        tax                     = parseFloat(tax);
        
    //  total_item_price        = total_item_price - discount_amt;
    //  total_item_price        = total_item_price * discount_amt / 100;
        
        var total_tax_amt       = total_item_price * (tax/100);
                        
        var grandTotal          = total_item_price + total_tax_amt;
        grandTotal              = grandTotal.toFixed(2);
        
        document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
        document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
        
        document.getElementById("total_price").innerHTML            = total_item_price.toFixed(2);
        document.getElementById("total_payable").innerHTML          = grandTotal;
        
        // to display at Model;
        document.getElementById("final_payable_amt").innerHTML      = grandTotal;
        document.getElementById("final_purchased_item").innerHTML   = total_item_qty;
        
        // to insert Database;
        document.getElementById("final_total_payable").value        = grandTotal;
        document.getElementById("final_total_qty").value            = total_item_qty;
        
        document.getElementById("total_item_qty").innerHTML         = total_item_qty;
        
        document.getElementById("row_count").value                  = upd_row_count;
        
        document.getElementById("subTotal").value                   = total_item_price.toFixed(2);  
        
    }
    
    
    function calculateDiscount(ele){
    //  alert(ele);
        var tax                 = document.getElementById("tax").value;
    //  var total_price                 = $('#total_price').val();
        tax                     = parseFloat(tax);
    //  total_price                     = parseFloat(total_price);
    //  alert(tax); 
        if(ele == 0){
            
            var row_count       = document.getElementById("row_count").value;
        
            var total_item_price    = 0;
            for(var p = 1; p < row_count; p++){
                var each_price      = document.getElementById("price_"+p).value;
                var each_qty        = document.getElementById("qty_"+p).value;
            
                each_price          = parseFloat(each_price);
                each_qty            = parseInt(each_qty);
                
                total_item_price    += (each_price * each_qty);
            }
            
            var total_tax_amt       = total_item_price * (tax/100);
    //      var total_discount = total_item_price * dis_amt / 100;
        
            var grandTotal          = total_item_price + total_tax_amt;
            //var grandTotal            = (total_item_price * dis_amt/100)  + total_tax_amt;
            grandTotal              = grandTotal.toFixed(2);
            
            document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
            document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
            
            document.getElementById("total_price").innerHTML            = total_item_price.toFixed(2);
            document.getElementById("total_payable").innerHTML          = grandTotal;
            
            document.getElementById("final_total_payable").value        = grandTotal;
            document.getElementById("final_payable_amt").innerHTML      = grandTotal;
            
            document.getElementById("subTotal").value                   = total_item_price.toFixed(2);
            //alert(subTotal);
            
        } else {
        //  alert('else');
            if(ele.indexOf("%") >= 0){
            //  alert('else 2');
                var row_count       = document.getElementById("row_count").value;
        
                var final_total_payable     = 0;
                for(var p = 1; p < row_count; p++){
                    var each_price      = document.getElementById("price_"+p).value;
                    var each_qty        = document.getElementById("qty_"+p).value;
                    
                    each_price          = parseFloat(each_price);
                    each_qty            = parseInt(each_qty);
                    
                    final_total_payable += (each_price * each_qty);
                    //alert(final_total_payable);
                }
    
                
                var sep_ele         = ele.substr(0, ele.indexOf('%'));
                sep_ele             = parseInt(sep_ele);
                 
                var ele_amt         = (final_total_payable  * (sep_ele/100));
            //  alert(ele_amt);
                if(ele_amt < final_total_payable){
                    var amt                 = final_total_payable - ele_amt;
                    
                    var total_tax_amt       = amt * (tax/100);
                                
                    var grandTotal          = amt + total_tax_amt;
                    grandTotal              = grandTotal.toFixed(2);
                //  alert(grandTotal);
                    
                    document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
                    document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
            //  alert(total_price); 
                    document.getElementById("total_price").innerHTML            = amt.toFixed(2);
                    document.getElementById("total_payable").innerHTML          = grandTotal;
                    
                    document.getElementById("final_total_payable").value        = grandTotal;
                    document.getElementById("final_payable_amt").innerHTML      = grandTotal;
                    
                    document.getElementById("subTotal").value                   = amt.toFixed(2);
                } else {
                    alert("Discount Amount must to less than Payable Amount!");
                }
                
                
            } else {
            //  alert('else 3');
                var row_count       = document.getElementById("row_count").value;
        
                var final_total_payable     = 0;
                for(var p = 1; p < row_count; p++){
                    var each_price      = document.getElementById("price_"+p).value;
                    var each_qty        = document.getElementById("qty_"+p).value;
                    
                    each_price          = parseFloat(each_price);
                    each_qty            = parseInt(each_qty);
                    
                    final_total_payable += (each_price * each_qty);
                }
    
                
                if(ele < final_total_payable){
                //  alert('else 4');
                //  alert(final_total_payable);
                //  var discount_P = final_total_payable * ele / 100;
                    var amt                 = final_total_payable - ele;// this was previous calculation
                /// this is my Robin
                //  var amt                 = final_total_payable - discount_P;
                    //alert(amt);
                //end
                    var total_tax_amt       = amt * (tax/100);
                                
                    var grandTotal          = amt + total_tax_amt;
                    grandTotal              = grandTotal.toFixed(2);
                    
                    document.getElementById("display_tax_amt").innerHTML        = total_tax_amt.toFixed(2);
                    document.getElementById("tax_amt").value                    = total_tax_amt.toFixed(2);
                    
                    document.getElementById("total_price").innerHTML            = amt.toFixed(2);
                    document.getElementById("total_payable").innerHTML          = grandTotal;
                    
                    document.getElementById("final_total_payable").value        = grandTotal;
                    document.getElementById("final_payable_amt").innerHTML      = grandTotal;
                    
                    document.getElementById("subTotal").value                   = amt.toFixed(2);
                    
                } else {
                    alert("Discount Amount must to less than Payable Amount!");
                }
                
            }
            
            
            
        }
    }
    
    function calculatePaidAmt(ele){ 
        var paid_by             = document.getElementById("paid_by").value;
        var payable_amt         = document.getElementById("final_total_payable").value;
        payable_amt             = parseFloat(payable_amt);
                temp =  parseFloat($('#single_pb_amount_'+paid_by).val());
                if(temp>0){
                    $('#single_pb_amount_'+paid_by).val(parseFloat(ele)+temp);

                } else {
                    $('#single_pb_amount_'+paid_by).val(ele);
                }
    //pbamount
            var hpbamount_ = parseFloat($('#hpbamount_'+paid_by).val());
            if(hpbamount_>0){
               $('#hpbamount_'+paid_by).val(hpbamount_+parseFloat(ele));
            } else {
                $('#hpbamount_'+paid_by).val(ele);

            }
            if(ele>0){
                var paid_val = parseFloat($('#total_paid').val());
                  console.log('paid_val'+paid_val)
                $('#total_paid').val(paid_val+parseFloat(ele));
            } else{
                $('#total_paid').val(parseFloat(ele));

            }
            console.log('new paid_val'+$('#total_paid').val())

        if(paid_by == "6"){
            var change_amt          = 0;
        } else {
            var change_amt          = ele - payable_amt;
        }
        
        document.getElementById("returned_change").value    = change_amt.toFixed(2);
        document.getElementById("return_change").innerHTML  = change_amt.toFixed(2);
        
        if( (paid_by == "6") || (paid_by == "7") ){
            document.getElementById("submit_btn").style.display     = "block";
        } else {
            if(change_amt < 0){
                //document.getElementById("submit_btn").style.display   = "none";
            } else {
                document.getElementById("submit_btn").style.display     = "block";
            }
        }
    }
    
    function calculatePaidAmtGift(ele){ 
        var paid_by             = document.getElementById("paid_by").value;
        var payable_amt         = document.getElementById("final_total_payable").value;
        payable_amt             = parseFloat(payable_amt);
        
        var change_amt          = 0;
        if(ele <= payable_amt){
            change_amt          = ele - payable_amt;
        } else {
            change_amt          = 0;
        }
        
        document.getElementById("returned_change").value    = change_amt.toFixed(2);
        document.getElementById("return_change").innerHTML  = change_amt.toFixed(2);
        
        if(change_amt < 0){
            alert("Gift Card Amount is less than Payable Amount!");
            //document.getElementById("submit_btn").style.display   = "none";
        } else {
            document.getElementById("submit_btn").style.display     = "block";
        }
        
    }
    
</script>

<?php
   // if ($keyboard == '1') {
        ?>
<!-- jQuery.NumPad -->
<script src="<?=base_url()?>assets/numberpad/jquery.numpad.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/numberpad/jquery.numpad.css">
<script type="text/javascript">
    // Set NumPad defaults for jQuery mobile. 
    // These defaults will be applied to all NumPads within this document!
    $.fn.numpad.defaults.gridTpl = '<table class="table modal-content"></table>';
    $.fn.numpad.defaults.backgroundTpl = '<div class="modal-backdrop in"></div>';
    $.fn.numpad.defaults.displayTpl = '<input type="text" class="form-control" />';
    $.fn.numpad.defaults.buttonNumberTpl =  '<button type="button" class="btn btn-default"></button>';
    $.fn.numpad.defaults.buttonFunctionTpl = '<button type="button" class="btn" style="width: 100%;"></button>';
    $.fn.numpad.defaults.onKeypadCreate = function(){$(this).find('.done').addClass('btn-primary');};
    
    // Instantiate NumPad once the page is ready to be shown
    $(document).ready(function(){
           // $('#txtMessage_0').focus();    
        //$('#paid').numpad();
            
         

});
$(document).on('keyup',function(e){
   // code =  e.which;  
    var code = (window.event) ? e.which : e.keyCode;
    target_id = e.target.id;
  //  console.log(code);

    switch(code){
        case 13:
            e.preventDefault();
            if(target_id ==='searchProd'){
                  var filter = $('#searchProd').val();
                    filter = filter.toLowerCase();
                    console.log('in search prod')
                $("#allProd #proname").each(function(){
                        var text = $(this).text().toLowerCase();
                        var search_text = text.search(filter);
                        console.log('search='+search_text);
                       // if (parseInt(search_text) >= 0  && parseInt(search_text) < 5) {
                        if ($(this).text().search(new RegExp(filter, "i")) >= 0) {

                             obj = $(this).parent();
                            id = obj[0].id;
                          //  $('#current_btn').val(id)

                            $('#'+id).focus();
                            $('#selectedbtn').val(id);
                            $('#curr_index').val(0);
                             return false;
                        }                              
                    });
            }
            selected_btn_val = $('#selectedbtn').val();
            sub_tid = target_id.substring(0,10);
            if(  selected_btn_val !== ''){
                $('#'+selected_btn_val).click();
            }
            if($('#submit_btn').is(":visible") === true ){
                $('#submit_btn').click()
            } 
             
        break;
         
    }
}) 
$(document).on('keypress',function(e){
    //console.log('visible='+e.target.id);
            code =  e.which || e.code;   
            console.log('code'+code);
        if(e.target.id !=='searchProd'){

//            obj_target = e.target.id;
//            console.log('target'+obj_target)
//            obj_target_qty = obj_target.search('display_qty');
//            //console.log($('#'+obj_tatget.id).attr('class'));
//            if(e.target.id !=='paid' && e.target.id !== 'searchProd'  && parseInt(obj_target_qty)<0){
//                if( (code>96 && code<123) || (code>64 && code <91) ||  (code>47 && code < 58)){
//                    var filter = e.key;
//                    filter = filter.toLowerCase();
//
//                    $("#allProd #proname").each(function(){
//                        var text = $(this).text().toLowerCase();
//                        var search_text = text.search(filter);
//    //                                   console.log('search='+search_text)
//                        if (parseInt(search_text) >= 0  && parseInt(search_text) < 5) {
//                             obj = $(this).parent();
//                            id = obj[0].id;
//                          //  $('#current_btn').val(id)
//
//                            $('#'+id).focus();
//                            $('#selectedbtn').val(id);
//                             return false;
//                        }                              
//                    });
//                }
//            }
            switch(code){
                 case 67:
                 case 99:
                     console.log('cancel');
                     cancelSelected();
                break
                case 68:
                case 100:
                     console.log('discount');
                    $('#dis_amt').focus();
                    $('#dis_amt').val(0);


                break
                case 72:
                case 104: 
                     console.log('hold');
                    $('#holdmodel').modal('show');

                break
                case 2:
                     console.log('payment');
                    $('#timepicker4Modal').modal('show');
                   
                break
                case 80:
                case 112:
                    
                     console.log('ctrl p');
                   //  $('.print').click();
                    $('#timepicker4Modal').modal('show');

                break
               // case 83:
               // case 115:
               case 63:
                  
                     console.log('?');
                     $('#searchProd').focus();
                
                break
                  
            }
        }
             
 
          } ); 
          
        $('#submit_btn').on('click',function(){
            calculatePaidAmt($('#paid').val());
            var total =$('#final_total_payable').val();
            var total_paid =$('#total_paid').val();
            $('#sendBtn').hide();
            console.log('total='+total+'paid='+total_paid);
            if(parseFloat(total_paid) >= parseFloat(total)){
                $('#sendBtn').show();
            }
            
            $('#timepicker4Modal').modal('toggle');
            show_payments();
            $('#searchProd').focus();
        })
    var paid_by_arr=[]; 
<?php 

foreach($paid_bys as $pm_id=>$obj){?>


paid_by_arr[<?php echo $pm_id;?>]='<?php echo $obj;?>';
<?php } ?>      
    function show_payments(){
    
 
        var paid_total_arr =[];

         var total = 0;
        //console.log('gtotal='+gtotal)
        var str='';
        total_paid =0;
        var total_paid = parseFloat($('#total_paid').val());
        var gtotal = $('#final_total_payable').val();
        for( cid in paid_by_arr){
            temp_total = parseFloat($('#hpbamount_'+cid).val());
            var  str='';
            if( temp_total   >   0   ){
                str += '<div class="row">';
                str += '<div class="col-md-6">'+paid_by_arr[cid]+':</div>';
                str += '<div class="col-md-6">'+temp_total+'</div>';
                str += '</div>';
                $('#payment_sp'+cid).html(str);
            }

        }
         var short = parseFloat(gtotal) - parseFloat(total_paid);
             //   console.log('short'+short +'paid='+total_paid);
         $('#paid_div').html(total_paid);
            $('#short_div').html(short);
            $('#short_row').show();
            
       // }

        $('#h2_gtotal').html($.number(gtotal,2));
 
    }
    function chkReturn(ele){
        var total_paid = parseFloat($('#total_paid').val());

        var gtotal = $('#final_total_payable').val();
        console.log('gtotal'+gtotal)
        change_amt =  ( parseFloat(ele)+parseFloat(total_paid)) - parseFloat(gtotal);
        document.getElementById("returned_change").value    = change_amt.toFixed(2);
        document.getElementById("return_change").innerHTML  = change_amt.toFixed(2);
    }
    
$(document).ready(function(){
      $('#searchProd').focus();
    //$('#selectedbtn').val('txtMessage_0');
           
    
})
function getProducts(){
    sparray=[];
    index=0;
    $('button[id^="txtMessage_"]').each(function(){
        id = $(this).attr('id');
        if($('#'+id).is(":visible")){
            console.log('in search id='+id);
            sparray[index] = id;
            index++;
        }
    });
    //console.log(sparray)
}
</script>


<?php

   // }
?>

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
                    <form  id="add-customer">
                     


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
                <button type="submit" id="created-cycle-btn" name="created-cycle-btn"  onclick="add_customer(event)"  class="btn btn-info col-md-offset-5 ">Add Customer</button>
	
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

<div class="modal fade" id="UpdateModal1" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Exchange</h4>
        </div>
<!--        <div class="modal-body">
           <div class="row">
                <div class="col-lg-12">
                  <div id="message2"></div>
                    <form enctype="multipart/form-data" id="add-exchange">
                     


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
                </div>-->
                <!-- /.col-lg-12 -->
            </div>
               <!-- end of row -->
         <!-- </div> -->
          <!-- end of modal body -->
      </div>   
      <!-- end of modal content --> 
    </div>
    <!-- end of modal dialogue -->
  </div> <!--  Update modal is finish -->




<div class="modal fade" id="UpdateModal2" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Order Estimate</h4>
        </div>
       <div class="modal-body">
           <div class="row">
                <div class="col-lg-12">
                  <div id="message2"></div>
                    <form enctype="multipart/form-data" id="order_estimate_form">
                     


<div class="row">

<div class="col-md-6">
														
<div class="form-group">

<label>Select Code <span style="color: #F00">*</span></label>
								<select name="search-area" id="search-area"  class="form-control" required autocomplete="off">
<option ><?php echo "Code 1"; ?></option>
<option ><?php echo "Code 2"; ?></option>
<option value="<?php echo 'code 3'; ?>"><?php echo "Name"; ?></option>
<option value="<?php echo 'COde 4'; ?>" ><?php echo "NIC"; ?></option>


</select>	
						</div>
						</div>


<div class="col-md-6" >
														
<div class="form-group">
<!-- onkeyup="get_value_item_customer_three() -->
<label>Name<span style="color: #F00">*</span></label>
		<input type="text" name="search-phone1" id="search-phone1" disabled  class="form-control" maxlength="499" required="" autocomplete="off" value=""><input type="hidden" name="search-phone" id="search-phone"   class="form-control" maxlength="499" required="" autocomplete="off" value="">
						</div>
						</div>

<div class="col-md-6" >
														
<div class="form-group">

<label>Deposit<span style="color: #F00">*</span></label>
		<input type="text" name="deposit_amount23" id="deposit_amount23"   class="form-control" maxlength="499" required="" autocomplete="off" value=""><input type="hidden" id='deposit_amount1' /> 
						</div>
						</div>
<div class="col-md-6">
		<div class="form-group">
		<label>Email<span style="color: #F00">*</span></label>
		<input type="email" disabled name="email2" id="email2" class="form-control" maxlength="499" required autocomplete="off" value="" />
                 <input type="hidden" name="email2_" id="email2_" class="form-control" maxlength="499" required autocomplete="off" value="" />
		</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
			<label>Phone<span style="color: #F00">*</span></label>
			<input type="text" disabled name="phone2" id="phone2" class="form-control" maxlength="499" required autocomplete="off" value="" />
		        <input type="hidden" name="phone2_" id="phone2_" class="form-control" maxlength="499" required autocomplete="off" value="" />
 <label>Need To reserve<span style="color: #F00">*</span></label><br>
		<input type="radio"  name="reserve" id="reserve" value="1" />Yes<input type="radio"  name="reserve" id="reserve" value="0" />No<br>
			</div>
			</div>
	        <div class="col-md-6">
		<div class="form-group">
		<label>NIC<span style="color: #F00">*</span></label>
		<input type="text" disabled name="nic3" id="nic3" class="form-control" maxlength="499" required autocomplete="off" value="" />
                <input type="hidden" name="nic3_" id="nic3_" class="form-control" maxlength="499" required autocomplete="off" value="" />
                 <label>Advance Payment<span style="color: #F00">*</span></label>
		<input type="text"  name="payemnt_adv" id="payemnt_adv" class="form-control" maxlength="499" required autocomplete="off" value="" />


							</div>
						</div>
<div class="col-md-6">
							<div class="form-group">
								<label>Expected Delivery Date<span style="color: #F00">*</span></label>
								<input type="text" name="startDate" id="startDate" class="form-control" maxlength="499" required autocomplete="off"  />


							</div>
						</div>
<div class="col-md-6">
							<div class="form-group">
								<label>Price<span style="color: #F00">*</span></label>
								<input type="number" name="order_price" id="order_price" class="form-control" maxlength="499" required autocomplete="off" value="" />

							</div>
						</div>
<div class="col-md-6">
							<div class="form-group">
								<label>Weight<span style="color: #F00">*</span></label>
								<input type="number" name="order_weight" id="order_price" class="form-control" maxlength="499" required autocomplete="off" value="" />
 <label>Total paypalable<span style="color: #F00">*</span></label>
		<input type="text"  disabled name="payables" id="payables" class="form-control" maxlength="499" required autocomplete="off" value="" />
		<input type="hidden"  name="payables1" id="payables1" class="form-control" maxlength="499" required autocomplete="off" value="" />

							</div>
						</div>
<div class="col-md-6">
							<div class="form-group">
								<label>Address<span style="color: #F00">*</span></label>
								<textarea name="address2" disabled rows="4" id="address2" class="form-control"  required autocomplete="off" > </textarea> <textarea name="address2_" style="display:none;"  rows="4" id="address2_" class="form-control"  required autocomplete="off" > 
</textarea>
							</div>
</div>
<div id="id2">
</div>
</div>
<div class="row">
<div class="col-md-6">
														
<div class="form-group">
<label>Outlets<span style="color: #F00">*</span></label>
								<select name="out1" onchange="get_store_()"  class="form-control" required autocomplete="off">
<?php foreach($outlets as $out): ?>
<option value="<?php echo $out->id; ?>" ><?php echo $out->name; ?></option>
<?php endforeach; ?>
</select>	
						</div>
</div>

<div class="col-md-6">
														
<div class="form-group">
<label>Warehouse<span style="color: #F00">*</span></label>
								<select name="ware1"  id="ware1" class="form-control" required autocomplete="off">
<?php foreach($warehouse as $ware): ?>
<option value="<?php echo $ware->s_id; ?>" ><?php echo $ware->s_name; ?></option>
<?php endforeach; ?>
</select>	
						</div>
</div>

</div>




</div>




<!-- 
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
						</div>-->
					</div>					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">


<div id="p" class="progress" style="height:40px;display:none;">
                               <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
                                please wait...
                               </div>
        
                        </div>

                <button type="submit" id="created-cycle-btn" name="created-cycle-btn"   class="btn btn-info col-md-offset-5 ">Order Estimate</button>


							</div>
						</div>
						<div class="col-md-4"> <button type="submit" id="created-cycle-btn" name="created-cycle-btn" onclick="addothercost()"   class="btn btn-info col-md-offset-5 ">Add Other Cost</button></div>

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





<div class="modal fade" id="UpdateModal3" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Discount</h4>
        </div>
<!--        <div class="modal-body">
           <div class="row">
                <div class="col-lg-12">
                  <div id="message2"></div>
                    <form enctype="multipart/form-data" id="add-discount">
                     


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
                </div>-->
                <!-- /.col-lg-12 -->
            </div>
               <!-- end of row -->
         <!-- </div> -->
          <!-- end of modal body -->
      </div>   
      <!-- end of modal content --> 
    </div>
    <!-- end of modal dialogue -->
  </div> <!--  Update modal is finish -->




<div class="modal fade" id="UpdateModal0" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Old Gold</h4>
        </div>
<!--        <div class="modal-body">
           <div class="row">
                <div class="col-lg-12">
                  <div id="message2"></div>
                    <form enctype="multipart/form-data" id="old_gold_form">
                     


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
                </div>-->
                <!-- /.col-lg-12 -->
            </div>
               <!-- end of row -->
         <!-- </div> -->
          <!-- end of modal body -->
      </div>   
      <!-- end of modal content --> 
    </div>
    <!-- end of modal dialogue -->
  </div> <!--  Update modal is finish -->

<?php
    require_once $app.'/views/includes/footer.php';
?>

<script>
function addothercost(){

$("#id2").append("<div class='col-md-4' id='id3' ><div class='form-group'><label><input type='text' name='other_name[]'  class='form-control' placeholder='Cost Name'  /><span style='color: #F00'>*</span></label><input type='text' name='other1[]' placeholder='Cost' class='form-control' required onkeyup='calucalt()'  /></div></div>");

}

function calucalt(){

var other1 = $("input[name='other1[]']")
              .map(function(){return $(this).val();}).get();
var payables=0;
for(i=0;i<other1.length;i++){
payables += other1[i];
}

price_ = $("input[name=order_price]").val();
p_ = $("input[name=payemnt_adv]").val();

payable = parseFloat(price_)-parseFloat(p_)+parseFloat(payables);


$("#payables").val($.number(payable,2))
$("#payables1").val(payable)

}
</script>