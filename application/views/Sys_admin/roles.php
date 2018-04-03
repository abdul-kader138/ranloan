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
			<h1 class="page-header">Manage Roles</h1>
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
                                        <form action="<?=base_url()?>Sys_admin/saverole" method="post" >
                                            <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>New Role</label>
                                                            <input type='text' name='name' class="form-control" value="" />
                                                        </div>
                                            </div>
                                            <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>&nbsp;</label>
                                                                <button class="btn btn-primary form-control">&nbsp;&nbsp;Save New Role&nbsp;&nbsp;</button>
                                                            </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div>
                                        <form action="<?=base_url()?>Sys_admin/updateroles" method="post" >
                                            <div class="row">
 
                                                  <?php 
                                                $index=0;
                                                foreach($roles_dd as $name){
 
                                                    ?> 
 
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Role</label>
                                                            <input type='text' name='name[]' class="form-control" value="<?php echo $name;?>" />
                                                        </div>
                                                    </div>
                                                     
                                                  <?php
                                                    $index++;

                                                    if($index %3 ==0){echo "</div><div class='row'>";}
                                                  
                                                } ?>      

                                            </div> 
					
                                            <div class="row" style="margin-top: 20px;">
                                                    <div class="col-md-4">
                                                            <div class="form-group">
                                                                <button class="btn btn-primary">&nbsp;&nbsp;Save Role&nbsp;&nbsp;</button>
                                                            </div>
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-4"></div>
                                            </div>
                                            </form>
                                        </div>
					 
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
                         
			
			<a href="<?=base_url().'Sys_admin/roles'?>" style="text-decoration: none;">
                        <div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
 