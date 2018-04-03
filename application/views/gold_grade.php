<?php
    require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Gold Grade</h1>
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
						<div class="col-md-12">
							<?php
                                                  //      echo "uder rle=$user_role";
                                //if ($user_role_name == SYSTEM_ADMIN_ROLE  || $user_role_name == ADMIN_ROLE || $user_role_name == MANAGER_ROLE ) {
                                                        if(ci_permissionSysAdminSuperManagerRole()){
                                                        ?>
							<a href="<?=base_url()?>Gold/addgrade" style="text-decoration: none">
								<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>Add New Gold Grade</button>
							</a>
							<?php

                                }
                            ?>
						</div>
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
						<div class="table-responsive">
							<table class="table">
							    <thead>
							    	<tr>
								    	<th width="15%">Date</th>
									    <th width="15%">Grade Purity Grade</th>
									    <th width="10%">Gold Purity</th>
									    <th width="15%">Per Gram</th>
									    <th width="10%">Status</th>
									    <th width="20%">Action</th>
									</tr>
							    </thead>
								<tbody>
								<?php
                                    if (count($results) > 0) {
                                        foreach ($results as $data) {
                                            $sys_role_id =  $this->Constant_model->getSingle('user_roles','id', ' name="'.SYSTEM_ADMIN_ROLE.'"');

                                        
                                            $date = $data->date_created;
                                            $fullname = $data->grade_name;
                                            $price = $data->grade_price;
                                            $purity= $data->gold_purity;                                            
                                            $status = $data->status;
                                           ?>
											<tr id="grade<?php echo $data->grade_id; ?>">
												<td>
													<?php echo $date; ?>
												</td>
												<td>
													<?php echo $fullname; ?>
												</td>
												<td style="font-weight: bold;">
													<?php echo $purity; ?>
												</td>
												<td>
													<?php echo $price; ?>
												</td>
												<td style="font-weight: bold;">
									edf
												</td>
												<td>
						

<button type="button" class="btn btn-primary btn-circle" id="<?php echo $data->grade_id; ?>" onclick="updatedata(<?php echo $data->grade_id;?>)" data-toggle="modal"  data-target="#UpdateModal"><i class="fa fa-edit">Edit</i></button>
<button type="button" class="btn btn-primary btn-circle" class="<?php echo $data->grade_id; ?>" onclick="delete_grade(<?php echo $data->grade_id;?>)" ><i class=" glyphicon glyphicon-trash"></i></button>                  
</td>

													</a>
												</td>
											</tr>
								<?php
                                           
                                        }
                                    } else {
                                        ?>
										<tr class="no-records-found">
											<td colspan="5">No matching records found</td>
										</tr>
								<?php

                                    }
                                ?>
								</tbody>
							</table>
						</div>
							
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6" style="float: left; padding-top: 10px;">
						
						</div>
						<div class="col-md-6" style="text-align: right;">
						
						</div>
					</div>
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	<div class="modal fade" id="UpdateModal" role="dialog">
     <div class="modal-dialog">
      <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4>Update Gold Grade</h4>
        </div>
        <div class="modal-body">
           <div class="row">
                <div class="col-lg-12">
                  <div id="message1"></div>
                    <form enctype="multipart/form-data" id="userupdate">

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
								<label>Grade Name <span style="color: #F00">*</span></label>
								<input type="text" name="fullname" id="fullname" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Price<span style="color: #F00">*</span></label>
                                                                <input type="number" name="price" id="price" class="form-control" required maxlength="254" autocomplete="off" />
							</div>
						</div>
		<div class="col-md-6">
							<div class="form-group">
								<label>Gold Purity<span style="color: #F00">*</span></label>
                                                                <input type="number" name="gold_purity" id="gold_purity"class="form-control" required maxlength="254" autocomplete="off" />


 <input type="hidden" name="id" id="id" class="form-control" required maxlength="254" autocomplete="off" />

							</div>
						</div>
					</div>
					
			
		
					<div class="row">
  <div class="progress" style="height:40px;display:none;">
                               <div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
                                please wait...
                                </div>
                            </div>
						<div class="col-md-4">
							<div class="form-group ">
								<input type="submit" class="btn btn-primary text-center" value="Update Grade" / >
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
function updatedata(id){

    event.preventDefault();
   $.ajax({      url: "get_price",
              method:"post",
              data:{data:parseInt(id)},
             success:function(data){
                //console.log(data);
          $("#fullname").val(data.message.grade_name);
          $("#price").val(data.message.grade_price);
          $("#gold_purity").val(data.message.gold_purity);
          $("#id").val(data.message.grade_id);

              }
          });

}

function delete_grade(id){

event.preventDefault(); 
   $.ajax({   
              url: "grade_delete",
              method:"post",
              data:{data:parseInt(id)},
             success:function(data){

      if(data.error == true)
      { 
        $("#grade"+id).remove();
      setTimeout(function(){                 
            // $("#message1").css("display","block");      
      $("#message1").html("<div class='alert alert-success text-center'>Successfully ! Deleted</div>");                                  
      setTimeout(function(){                  
      $("#message1").html("");     
      },3000); },2000);
      }
      else
      {   
      $("#message1").html("<div class='alert alert-danger text-center'>Failed! to Failed to delete try again</div>");
      setTimeout(function(){      
      $("#message1").html("");
      },4000);
      }
      }        
      });


}


     $("#userupdate").on("submit",function(event){
      event.preventDefault();
    var   price =  $("#price").val();
    var   id =  $("#id").val();
    var   name =  $("#fullname").val();
    var    purity =  $("#gold_purity").val();

      var formdata = $("#userupdate").serialize();
      $('.progress').css('display','block');
      $.ajax({
      url: 'updated_data_grade',
      data: formdata,
      type: 'POST',
      success:function(data){ 
alert(data.error);
      if(data.error == true)
      {   
       
        v6 = $("#grade"+id+" > td:nth-child(2)").html(name);
        v6 = $("#grade"+id+" > td:nth-child(3)").html(price);
        v6 = $("#grade"+id+" > td:nth-child(4)").html(purity);
      setTimeout(function(){                 
      // $("#message1").css("display","block");
      $('.progress').css('display','none');
      $("#message1").html("<div class='alert alert-success text-center'>Successfully! Updated grade</div>");                                  

      setTimeout(function(){                  
      $("#message1").html(""); 
      $("#UpdateModal").modal('hide');
      //$("#replaceable").html(data.message);

      },2000); },2000);
      }
      else
      {
      // $("#message1").css("visibility","visible");
      $("#message1").html("<div class='alert alert-danger text-center'>Failed! to update Grade try again</div>");
      setTimeout(function(){
      // $("#message1").css("visibility","hidden");
      $("#message1").html("");
      },4000);
      }
      }        
      });
});


</script>
	
<?php
    require_once 'includes/footer.php';
?>