<!--<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link rel="stylesheet" href="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?=base_url()?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="<?=base_url()?>files/tableExport.js"></script>
<script src="<?=base_url()?>files/jquery.base64.js"></script>
<script src="<?=base_url()?>files/html2canvas.js"></script>
<script src="<?=base_url()?>files/jspdf/jspdf.js"></script>
<script src="<?=base_url()?>files/jspdf/libs/sprintf.js"></script>
<script src="<?=base_url()?>files/jspdf/libs/base64.js"></script>-->

 
<?php 
$alert_msg=$this->session->userdata('alert_msg');
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo "Goldsmith Wastage Details ";?></h1>
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
                    
                    <?php
                        if ($user_role < 3) {
                            ?>
                            <div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
                        <div class="col-md-10">
                           <!-- <a href="<?=base_url()?>bank_dt/addBdt" style="text-decoration: none;">
                                <button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
                                    <i class="icono-plus"></i> Add <?php echo BDT?>
                                </button>
                            </a> -->
                          <!-- //Gold/addrjo -->
                          
                           <a href="<?=base_url()?>Productions/add_gold_product_wastage" style="text-decoration: none;">
                                <button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
                                    <i class="icono-plus"></i> Add Goldsmith gold wastage
                                </button></a>
                                <!-- Gold viewrjo  renamed   as   refine_order_list -->
                                <!--refine_order_lis -->
                          
                        </div>
                        <div class="col-md-2" style="text-align: right;">
                           <!--  <a href="<?=base_url()?>Gold/exportBdt" style="text-decoration: none;">
                                <button type="button" class="btn btn-success" style="background-color: #5cb85c;width: 100%; border-color: #4cae4c;">
                                    Export
                                </button>
                            </a> -->
								<button type="button" class="btn btn-success pull-right " id="csv" style="background-color: #5cb85c; width: 100%;border-color: #4cae4c;">
                                    Export Excel
                                </button>
                        </div>
                    </div>
                    <?php

                        }
                    ?>

                    <form id="search_box" method="get" >
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-2">
										<label>Goldsmith</label>
										<select class="form-control" name="gold">
											  <option  value="all"> <?php echo "All Goldsmith"; ?></option>
											 <?php  foreach($goldsmith as $gold): ?>
											  <option value="<?php echo $gold->gs_id; ?>" > <?php echo $gold->fullname; ?></option>
											 <?php endforeach; ?>
											 </select>
                                                             
                                                        </div>
<!--                                                        <div class="col-md-2">
                                                            <?php 
                                                            $payment_methods['-'] = 'All Payment Types';
                                                            $payment_methods = $payment_methods+$this->Constant_model->getddData('payment_method','id','name', 'name');
                                                             echo sel_element($payment_methods,$payment_method=0,'Select Payment Type','payment_method','Choose Payment Type');
                                                            
                                                            ?>
                                                             
                                                        </div>-->

                                                        <div class="col-md-2"> <label>Products Category</label>
																	<select class="form-control" name="products" onchange="get_subproduct()">

																  <option  value="all" > <?php echo "All Categories"; ?></option>
																  <?php foreach($gold_products as $out): ?>
																  <option value="<?php echo $out->gpro_id; ?>" > <?php echo $out->gpro_name; ?></option>
																 <?php endforeach; ?>                        </select>                                    
																							 </div>
																							 <div class="col-md-3">
																  <label>Product Sub category</label>
																	<select class="form-control" name="subs" id="subs">
																 <option value="all" >All Sub Categories</option>
																 </select>
                                                             
                                                        </div>
                                                    
													<div>
												   <div class="col-md-2" style="margin-top: -15px;">
													   <div class="form-group">
														   <label>&nbsp;</label><br />

														   <input type="submit" class="btn btn-primary" style="width: 100%; margin-top: 14px;height: 41px" value="Search" >
													   </div>
												   </div>
											   </div>
										   </form>
                
                    
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12">
                            
                            <div class="table-responsive">
                                <table class="table btnExport" id="btnExport">
                                    <thead>
                                        <tr>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="13%">Date</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="17%">Wastage Form No.</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="10%">Goldsmith</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="15%">Product Category</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="20%">Product Sub Category</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="15%">Wastage per 8 g (in mg)</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="10%">Action</th>

																								</tr>
                                    </thead>
                                    <tbody id="replaceable">
                                        <?php foreach($wastage as $was): ?>
                                    <tr id="<?php echo $was->w_id; ?>" >
                                        <td  class="text-center" ><?php echo  $was->was_datetime;?></td>
                                        <td class="text-center" ><?php echo  $was->reference;?></td>
                                        <td class="text-center" ><?php echo  $was->fullname;?></td>
                                        <td class="text-center"><?php echo  $was->gpro_name;?></td>
                                        <td class="text-center" ><?php echo  $was->cate_name;?></td>
                                        <td class="text-center"><?php echo  $was->wastage_amount;?></td>
                                        <td class="text-center" ><button type="button" class="btn btn-primary btn-circle" id="<?php echo $was->w_id; ?>" onclick="viewdata(<?php echo $was->w_id;?>)" data-toggle="modal"  data-target="#ViewModal"><i class="glyphicon glyphicon-eye-open"></i></button>
                                        <button type="button" class="btn btn-primary btn-circle" id="<?php echo $was->w_id; ?>" onclick="updatedata(<?php echo $was->w_id;?>)" data-toggle="modal"  data-target="#UpdateModal"><i class="glyphicon glyphicon-edit"></i></button></td></td>
                                    
                                    <?php endforeach; ?>
                                    </tr>
                                    
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6" style="float: left; padding-top: 10px;">
                            <?php //echo $displayshowingentries; ?>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                            <?php // echo $links; ?>
                        </div>
                    </div>
                    
                </div><!-- Panel Body // END -->
            </div><!-- Panel Default // END -->
        </div><!-- Col md 12 // END -->
    </div><!-- Row // END -->
    
    <br /><br /><br />
    
</div><!-- Right Colmn // END -->



<div class="modal fade" id="ViewModal" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Previous Details</h4>
        </div>
        <div class="modal-body">
           <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <!--<h3 class="box-title">Applicant Details</h3>-->

              <!--<div class="box-tools">-->
                <!--<div class="input-group input-group-sm" style="width: 150px;">-->
                <!--  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">-->

                <!--  <div class="input-group-btn">-->
                <!--    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>-->
                <!--  </div>-->
                <!--</div>-->
              <!--</div>-->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover" id="">
              <thead>
                <tr>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="18%">Date</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="17%">Wastage Form No.</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="10%">Goldsmith</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="15%">Product Category</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="20%">Product Sub Category</th>
				<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="20%">Wastage per 8 g (in mg)</th>
<!--<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="5%">Date</th>-->
				</tr>
                </thead>
                <tbody id="repalceable1" >
                  
                </tbody>
              
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
               <!-- end of row -->
          </div>
          <!-- end of modal body -->
      </div>   
      <!-- end of modal content --> 
    </div>
    <!-- end of modal dialogue -->
  </div> <!-- view modal -->

<div class="modal fade" id="UpdateModal" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Update Wastage Gold details  </h4>
        </div>
        <div class="modal-body">
           <div class="row">
                <div class="col-lg-12">
                  <div id="message1"></div>
                    <form  id="update-goldwastage" method="post">
                     <div id="message1" class="message text-center"></div>
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
								<label>Date <span style="color: #F00">*</span></label>
								<input type="text" name="gpro_name" class="form-control" value="<?php echo date('Y-m-d H:i:s');  ?>"
								maxlength="499" autofocus  disabled required autocomplete="off" />
								<input type="hidden" name="gpro_name" class="form-control"  maxlength="499" autofocus   required autocomplete="off"  value="<?php echo date('Y-m-d H:i:s');  ?>" />
								<input type="hidden" name="w_id" class="form-control"  maxlength="499" autofocus   required autocomplete="off"  value="" />
								<input type="hidden" name="ori_wastage" class="form-control"  maxlength="499" autofocus   required autocomplete="off"  value="" />
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label>Gold wastage form No.<span style="color: #F00">*</span></label>
								<input type="text" name="reference" value="<?php echo $code; ?>"  class="form-control" disabled required maxlength="254" autocomplete="off" /><input type="hidden" name="reference" value="<?php echo $code; ?>"  class="form-control" required maxlength="254" autocomplete="off" />
							</div>

						</div>

							<div class="col-md-4">

							<div class="form-group">
								<input type="hidden" name="sub_gold" value="" >
								<label>GoldSmith<span style="color: #F00">*</span></label>
									<input type="text" name="goldsmith" disabled class="form-control" required>
							</div>
						</div>


						<div class="col-md-4">
							<div class="form-group">
								<label>Product Category <span style="color: #F00">*</span></label>
								<input type="hidden" name="ori_out" value="" >
								<input type="text" name="out" disabled  class="form-control" required autocomplete="off" />
								    
							</div>	
						</div>


						<div class="col-md-4">
							<div class="form-group">
									<label>Sub product category  <span style="color: #F00">*</span></label>
									<input type="hidden" name="ori_sub">
									<input type="text" name="sub" id="sub" class="form-control" disabled required autocomplete="off" />
							</div>
						</div>


						<div class="col-md-4">
							<div class="form-group">
								<label>Wastage per 8g(in mg)<span style="color: #F00">*</span></label>
								<input type="text" name="wastage" class="form-control" required autocomplete="off">

							</div>
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
								<input type="submit" class="btn btn-primary text-center" value="Update gold wastage" / >
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
/*
$("#search_box").on("submit",function(event){
event.preventDefault();
var formdata = $("#search_box").serialize();
$.ajax({      url: "search_gold_status_",
              method:"post",
              data:formdata,
             success:function(data){       
   $("#replaceable").html(data.message);
       
             }
             });  
});
*/
function exportexel(event){
event.preventDefault();

var formdata = $("#search_box").serialize();
$.ajax({      url: "exportBdt",
              method:"get",
              data:formdata,
              dataType:'json',
             success:function(data){

             }
             });  

//alert("dgf");


}


$("#csv").click(function(){
$(".btnExport").tableExport({
type:'excel',
escape:false,
}); 
});
</script>
    
 <script>
     function get_subproduct(){

  var val = $('select[name=out]').val();
   event.preventDefault();
   $.ajax({      url: "get_subproduct",
              method:"post",
              data:{data:val},
             success:function(data){
$("#subs").html(data.message1);
             }
             });  

}


    $("#search_box").on("submit",function(){

  var form_data = $("#search_box").serialize();
   event.preventDefault();
   $.ajax({      url: "get_subproduct_wastage",
              method:"post",
              data:form_data,
             success:function(data){
$("#replaceable").html(data.message1);
             }
             });  

})

/*
function get_subproduct(){

  var val = $('select[name=products]').val();
   event.preventDefault();
   $.ajax({      url: "get_subproduct",
              method:"post",
              data:{data:val},
             success:function(data){
$("#sub").html(data.message1);
             }
             });  

} */

$("#update-goldwastage").on("submit",function(event){
    
    
            
            
    event.preventDefault();
var formData = $("#update-goldwastage").serialize();
 
                
                // var date =  $("input[name=gpro_name]").val();
                 var id =  $("input[name=w_id]").val();
                var  was = $("input[name=wastage]").val();
                // var product= $("select[name=out] option:selected").text();
                // var sub = $("select[name=sub] option:selected").text();
                // var gold = $("select[name=goldsmith] option:selected ").text();
                
            
$('.progress').css('display','block');
              $('#created-cycle-btn').attr('disabled','disabled');    
              $.ajax({
               url: 'update_wastage',
               data: formData,
               type: 'POST',
              success:function(data){
                  console.log(data.error);
                
                                  console.log(data);
               if(data.error == true)
               { 
                   
                   
                   
                  //  $("#update-goldwastage").get(0).reset();
                    
            // v2 = $("#"+id+" > td:nth-child(3)").html(gold);
            // v4 = $("#"+id+" > td:nth-child(4)").html(product);
            // v4 = $("#"+id+" > td:nth-child(5)").html(sub);
            v6 = $("#"+id+">td:nth-child(6)").html(was);
            
                 setTimeout(function(){
                
                 $("#message1").css("visibility","visible");
                 $("#message1").html("<div class='alert alert-success text-center'>Successfully! update Wastage</div>");
                 $('.progress').css('display','none');
                 $('#created-cycle-btn').removeAttr('disabled','disabled');  
                  setTimeout(function(){
                  $("#message1").css("visibility","hidden");
                  $("#message1").html(""); 
                  
                  $("#id2").html(" ");
                  $("input[name=reference]").val('<?= uniqid(); ?>');
                  $("input[name=gpro_name]").val('<?php echo date("Y-m-d H:i:s"); ?>');
                  },2000); },100);
                  $("#UpdateModal").modal('hide');
                }
               else
               {
              $('.progress').css('display','none');
               $("#message1").css("visibility","visible");
               $("#message1").html("<div class='alert alert-danger text-center'>"+data.message+"</div>");
               setTimeout(function(){
                $("#message1").css("visibility","hidden");
                $("#message1").html("");
                },4000);
               }
              }        
           });


  });
  
  
  
  
  
function updatedata(id){

    event.preventDefault();
   $.ajax({      url: "edit",
              method:"post",
              data:{data:parseInt(id)},
             success:function(data){

                $("input[name=reference]").val(data.wastage.message.reference);
                $("input[name=gpro_name]").val(data.wastage.message.was_datetime);
                $("input[name=gpro_name]").val(data.wastage.message.was_datetime);
                $("input[name=wastage]").val(data.wastage.message.wastage_amount);
                $("input[name=out]").val(data.product.message.gpro_name);
                $("input[name=sub]").val(data.category.message.cate_name);
                $("input[name=goldsmith]").val(data.goldsmith.message.fullname);
         

         $("input[name=ori_sub]").val(data.category.message.pro_cate_id);
         $("input[name=ori_out]").val(data.product.message.gpro_id);
         $("input[name=sub_gold]").val(data.goldsmith.message.gs_id);
         $("input[name=w_id]").val(data.wastage.message.w_id);
         $("input[name=ori_wastage]").val(data.wastage.message.wastage_amount);
         
         
         
         
              }
          });

}

function viewdata(id){
  event.preventDefault();
   $.ajax({      url: "wastage_backup",
              method:"post",
              data:{data:id},
             success:function(data){
   $("#repalceable1").html(data.message1);
             }
             });  

}

 </script>   
 