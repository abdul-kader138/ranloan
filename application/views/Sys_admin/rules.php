<?php
$dir    = 'application/controllers';
$files1 = scandir($dir);
$file_arr = array();
foreach($files1 as $val){
    if($val =='.' || $val=='..' || $val== 'Sys_admin.php'){continue;}
    $val_arr = explode('.',$val);
    if(count($val_arr)==2 &&  $val_arr[1]=='php'){
        $file_arr[]= $val;
    
    }
    
}
//print_r($file_arr);
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Manage Rules</h1>
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
					
                                    <div>
                                         <div class="row">
                                                 <div class="col-md-6">
                                                     <form method="post" id='frmselrule' action="<?=base_url()?>Sys_admin/rules">
                                                        <?php 
                                                        echo sel_element($roles_dd,$role_id,'Select Role','role_id','Choose Role',1 );

                                                        ?>
                                                         </form>
                                                </div>
                                                <div class="col-md-6">
                                                </div>
                                            </div>
                                        <form action="<?=base_url()?>Sys_admin/updaterules" method="post" >
                                            <input type="hidden" name='role_id' value="<?php echo $role_id;?>" />
                                             
 
                                                  <?php 
                                                    $index=0;
                                                    $resource_dd_temp = $resource_dd;
                                                         $sub_module_array = ci_submodules();
                                                     //   echo "<pre>";print_r($sub_module_array);echo "</pre>";
                                                    foreach($resource_dd_temp as $key=>$val){
                                                        $sel_allowed_type = $allowed_type;
                                                        if(count($sel_allowed_type_arr)>0 && array_key_exists($key, $sel_allowed_type_arr)){
                                                            $sel_allowed_type = $sel_allowed_type_arr[$key];
                                                        }
                                                     ?> 
                                            <div class="row" style="border-top: 1px #999 solid;margin:">
                                                <div class="col-md-12" style="margin-top:3%">
                                                      <div class="row">
                                                      
                                                        <div class="col-md-2">
                                                           <?php  //echo sel_element($resource_dd,$key,'Select Module','resource_id[]','Choose Module',1); ?>  
                                                        
                                                            <div class="form-group">
                                                                <strong><?php echo ucfirst($val);?> Module</strong>
                                                                
                                                                
                                                                <input type="hidden" name="resource_id[]" value="<?php echo $key;?>" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-10">
                                                             <div class="form-group">
                                                               
                                                                 
                                                                 <?php if($val === 'auth' || $val === 'error'){
                                                                ?>
                                                                <input type='hidden' name="allowed_type[]" value="allow" />
                                                                <br />Allow
                                                               <?php 
                                                               
                                                                } else {  ?>
                                                                <select class="form-control" name='allowed_type[]'>
                                                            <?php 
                                                                
                                                                foreach($allowed_type_dd as $akey=>$arow){
                                                                    $sel='';
                                                                    
                                                                    if($sel_allowed_type == $akey){
                                                                        $sel='selected';
                                                                        
                                                                    }
                                                                    echo "<option value='".$akey."'".$sel.">".$arow."</option>";
                                                                }
                                                           // echo sel_element($allowed_type_dd,$sel_allowed_type,'Select Allowed Type','allowed_type[]','Choose Allowed Type',1);

                                                            ?>
                                                                </select>
                                                               <?php } ?>
                                                        </div>
                                                            
                                                            
                                                    </div>  
                                                    </div>
                                                    <?php 
                                                    if(array_key_exists($val, $sub_module_array)){
                                                        $total_sub = count($sub_module_array);
                                                        $sindex=0;
                                                        echo '<div class="row">';
                                                        foreach($sub_module_array[$val] as $sub_module=>$sub_module_title){
                                                            $sub_key = (array_key_exists($sub_module, $sub_resource_dd))?$sub_resource_dd[$sub_module]:'-';
                                                            $sel_allowed_type = $allowed_type;
                                                            if(count($sel_allowed_type_arr)>0 && array_key_exists($sub_key, $sel_allowed_type_arr)){
                                                                $sel_allowed_type = $sel_allowed_type_arr[$sub_key];
                                                            }
                                                            ?>
                                                            
                                                      
                                                                <div class="col-md-2">
                                                                   <?php  //echo sel_element($resource_dd,$key,'Select Module','resource_id[]','Choose Module',1); ?>  

                                                                    <div class="form-group">
                                                                        <strong><?php echo ucfirst($sub_module_title);?> Module</strong>


                                                                        <input type="hidden" name="resource_id[]" value="<?php echo $sub_key;?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                     <div class="form-group">


                                                                         <?php if($val === 'auth' || $val === 'error'){
                                                                        ?>
                                                                        <input type='hidden' name="allowed_type[]" value="allow" />
                                                                        <input type="text" disabled="" value="allowed" />
                                                                       <?php 

                                                                        } else {  ?>
                                                                        <select class="form-control" name='allowed_type[]'>
                                                                    <?php 

                                                                        foreach($allowed_type_dd as $akey=>$arow){
                                                                            $sel='';

                                                                            if($sel_allowed_type == $akey){
                                                                                $sel='selected';

                                                                            }
                                                                            echo "<option value='".$akey."'".$sel.">".$arow."</option>";
                                                                        }
                                                                   // echo sel_element($allowed_type_dd,$sel_allowed_type,'Select Allowed Type','allowed_type[]','Choose Allowed Type',1);

                                                                    ?>
                                                                        </select>
                                                                       <?php } ?>
                                                                </div>


                                                            </div>  
                                                    <?php
                                                        $sindex++;
                                                        if($sindex % 2 ==0)
                                                        {
                                                            echo "</div>";
                                                            if($sindex < $total_sub){echo "<div class='row'>";}
                                                        }
                                                      }
                                                      //if($sindex % 2 !=0){ 
                                                                echo "</div>";

                                                       //}
                                                        
                                                    }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                                       <?php 
                                                       $index++;
                                                       //if($index % 2 ==0){echo "</div><div class='row'>";}
                                                       ?>
                                                <?php 
                                                
                                                
                                                } ?>
                                             </div>  
                                            <div class="row" style="margin-top: 20px;">
                                                    <div class="col-md-4">
                                                            <div class="form-group">
                                                                <button class="btn btn-primary">&nbsp;&nbsp;Save Rules&nbsp;&nbsp;</button>
                                                            </div>
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4"></div>
                                            </div>
                                            </form>
                                        </div>
					 
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
                         
			
			<a href="<?=base_url().'Sys_admin/modules'?>" style="text-decoration: none;">
                        <div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->

<script>
$('#role_id').on('change',function(){
    $('#frmselrule').submit();
})
</script>
	
	
 