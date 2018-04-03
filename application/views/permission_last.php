<?php
$dir = 'application/controllers';


$files1 = scandir($dir);


$file_arr = array();
foreach ($files1 as $val) 
{
	if ($val == '.' || $val == '..' || $val == 'Sys_admin.php') 
	{
		continue;
	}
	$val_arr = explode('.', $val);
	if (count($val_arr) == 2 && $val_arr[1] == 'php') 
	{
		$file_arr[] = $val;
	}
}
?>
<link href="<?=base_url()?>assets/plugins/iCheck/all.css" rel="stylesheet"> 
<script src="<?= base_url() ?>assets/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/plugins/select2/select2.full.min.js"></script>

<script>
$(document).ready(function(){
	   $(window).bind('scroll', function() {
	   var navHeight = $( window ).height() - 70;
			  if ($(window).scrollTop() > 240) {
      $('.top').addClass('fixed');
    }

    if ($(window).scrollTop() < 240) {
      $('.top').removeClass('fixed');
			 }
		});
		

	});
</script>
<style>
	.fixed{
		position:fixed;
		top:50px;
		width: 83.34%;
		z-index:9;
		right: 0;
		left: 15px;
		margin-left:16.66666667%;  
	}
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Manage Permission</h1>
		</div>
	</div>
	<?php
	if (!empty($alert_msg)) {
		$flash_status = $alert_msg[0];
		$flash_header = $alert_msg[1];
		$flash_desc = $alert_msg[2];
		if ($flash_status == 'failure') 
		{
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
		if ($flash_status == 'success') 
		{
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
			if (!empty($alert_msg)) 
			{
				$flash_status = $alert_msg[0];
				$flash_header = $alert_msg[1];
				$flash_desc = $alert_msg[2];
				if ($flash_status == 'failure') 
				{
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
				if ($flash_status == 'success') 
				{
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
					<div class="col-md-12">
						<form method="post" id='frmselrule' action="<?= base_url() ?>setting/permission" class="form-inline">
							<div class="box box-success box-flat">
								<div class="box-header">
									<h3 class="box-title">Manage User Menu</h3>
								</div>
								<div class="box-body">
									<div class="form-group">
										<?php
										echo sel_element($roles_dd, $user_id, 'Select user', 'user_id', 'Choose User', 1, '', '', 'select2');
										?>
									</div>
								</div>
							</div>

						</form>
					</div>
					<div class="col-md-6">
					</div>
				</div>

				<form action="<?= base_url() ?>setting/updatepermission" name="frm" id="frm" method="post" >
					<input type="hidden" name='user_id' value="<?php echo $user_id; ?>" />
					<div class="box box-success">
						<div class="box-header">
							<h3 class="box-title">SELECT MENU</h3>
						</div>
						<div class="box-body ">
							<table  class="table table-hover table-stripped table-bordered" id="data-table1" >
								<thead class="top">
									<tr class="header_link bg-purple" >
										<th width="310px">Page</th>
									<?php if($role_id == 7){ ?>
										<th width="121px">Admin Allow </th>
									<?php } ?>
										<th width="121px">View Menu </th>
										<th width="121px">Add Rights</th>
										<th width="120px">Edit Rights</th>
										<th width="121px">View Rights</th>
										<th width="121px">Delete Rights</th>
										<th width="120px">Print Rights</th>
										<th width="121px">Email Rights</th>
									</tr>
								</thead>
								<tbody id="">
									<tr>
										<td align="right" colspan="9">
											<div class="form-group">
												<input type="checkbox" onclick="chk_all_class(this.checked)"  name="check_all" class="minimal" id="check_all_" /> 
												<label for="check_all_">CHECK_ALL</label>
											</div>
										</td>
									</tr>
								<?php
								function rec($array,$role_id,$sel_main_menu_arr,$sel_view_menu_right_arr,$sel_add_right_arr, $sel_edit_right_arr, $sel_view_right_arr, $sel_delete_right_arr, $sel_print_right_arr, $sel_email_right_arr, $sp = '&nbsp;&nbsp;&nbsp;') {
										$count = 0;
										foreach ($array as $key => $val) 
										{
											$count++;
											
											if($role_id==7){ 
													$sel_main_menu = $sel_main_menu_arr;
													if (count($sel_main_menu_arr) > 0 && array_key_exists($key, $sel_main_menu_arr)) 
													{
														$sel_main_menu = $sel_main_menu_arr[$key];
													}
												 }
												 
											$sel_view_menu_right = $sel_view_menu_right_arr;
											if (count($sel_view_menu_right_arr) > 0 && array_key_exists($key, $sel_view_menu_right_arr)) 
											{
												$sel_view_menu_right = $sel_view_menu_right_arr[$key];
											}
											
											$sel_add_right = $sel_add_right_arr;
											if (count($sel_add_right_arr) > 0 && array_key_exists($key, $sel_add_right_arr)) 
											{
												$sel_add_right = $sel_add_right_arr[$key];
											}

											$sel_edit_right = $sel_edit_right_arr;
											if (count($sel_edit_right_arr) > 0 && array_key_exists($key, $sel_edit_right_arr)) 
											{
												$sel_edit_right = $sel_edit_right_arr[$key];
											}

											$sel_view_right = $sel_view_right_arr;
											if (count($sel_view_right_arr) > 0 && array_key_exists($key, $sel_view_right_arr)) 
											{
												$sel_view_right = $sel_view_right_arr[$key];
											}

											$sel_delete_right = $sel_delete_right_arr;
											if (count($sel_delete_right_arr) > 0 && array_key_exists($key, $sel_delete_right_arr)) 
											{
												$sel_delete_right = $sel_delete_right_arr[$key];
											}

											$sel_print_right = $sel_print_right_arr;
											if (count($sel_print_right_arr) > 0 && array_key_exists($key, $sel_print_right_arr)) 
											{
												$sel_print_right = $sel_print_right_arr[$key];
											}

											$sel_email_right = $sel_email_right_arr;
											if (count($sel_email_right_arr) > 0 && array_key_exists($key, $sel_email_right_arr)) 
											{
												$sel_email_right = $sel_email_right_arr[$key];
											}
										?> 
										<input type="hidden" name="resource_id[<?php echo $key; ?>]" value="<?php echo $key; ?>" />
										<tr <?php echo isset($val['children']) ? 'style="background-color:#f8f8f8;"' : ''; ?> >
											<td width="310px" ><?php echo $sp . ucfirst($val['title']); ?> Module</td>
											
											<?php if($role_id == 7){ ?>
											<td>
												<input type="checkbox" class="minimal change_permisssion" id="<?= $val['id'] ?>" value="1" <?php echo $sel_main_menu == 1 ? 'checked="checked"' : ''; ?> name="main_menu[<?php echo $key; ?>]"/>
											</td>
											<?php } ?>
											<td>
												<input type="checkbox" class="minimal" id="adminallow_view<?= $val['id'] ?>" value="1" <?php echo $sel_view_menu_right == 1 ? 'checked="checked"' : ''; ?> name="view_menu_right[<?php echo $key; ?>]"/>
											</td>
											
											<td>
												<input type="checkbox" class="minimal" value="1" <?php echo $sel_add_right == 1 ? 'checked="checked"' : ''; ?> name="add_right[<?php echo $key; ?>]"/>
											</td>
											<td>
												<input type="checkbox" class="minimal" value="1" <?php echo $sel_edit_right == 1 ? 'checked="checked"' : ''; ?> name="edit_right[<?php echo $key; ?>]" />
											</td>
											<td>
												<input type="checkbox" class="minimal" value="1" <?php echo $sel_view_right == 1 ? 'checked="checked"' : ''; ?> name="view_right[<?php echo $key; ?>]" />
											</td>
											<td>
												<input type="checkbox" class="minimal" value="1" <?php echo $sel_delete_right == 1 ? 'checked="checked"' : ''; ?> name="delete_right[<?php echo $key; ?>]" />
											</td>
											<td>
												<input type="checkbox" class="minimal" value="1" <?php echo $sel_print_right == 1 ? 'checked="checked"' : ''; ?> name="print_right[<?php echo $key; ?>]" />
											</td>
											<td>
												<input type="checkbox" class="minimal" value="1" <?php echo $sel_email_right == 1 ? 'checked="checked"' : ''; ?> name="email_right[<?php echo $key; ?>]" />
											</td>
										</tr>

										<?php
										if (isset($val['children'])) 
										{
											$sp .= '&nbsp;&nbsp;&nbsp;';
											rec($val['children'],$role_id,$sel_main_menu_arr,$sel_view_menu_right_arr, $sel_add_right_arr, $sel_edit_right_arr, $sel_view_right_arr, $sel_delete_right_arr, $sel_print_right_arr, $sel_email_right_arr, $sp);
										}
									}
								}

								$index = 0;
								$count = 0;
								$resource_dd_temp = $resource_dd;
								$sub_module_array = ci_submodules();
								foreach ($resource_dd_temp as $key => $val) 
								{
									$count++;
									if($role_id==7){
										$sel_main_menu = $sel_main_menu_arr;
										if (count($sel_main_menu_arr) > 0 && array_key_exists($key, $sel_main_menu_arr)) 
										{
											$sel_main_menu = $sel_main_menu_arr[$key];
										}
									}
									//main_menu
									$sel_view_menu_right = $sel_view_menu_right_arr;
									if (count($sel_view_menu_right_arr) > 0 && array_key_exists($key, $sel_view_menu_right_arr)) 
									{
										$sel_view_menu_right = $sel_view_menu_right_arr[$key];
									}


									$sel_add_right = $sel_add_right_arr;
									if (count($sel_add_right_arr) > 0 && array_key_exists($key, $sel_add_right_arr)) 
									{
										$sel_add_right = $sel_add_right_arr[$key];
									}

									$sel_edit_right = $sel_edit_right_arr;
									if (count($sel_edit_right_arr) > 0 && array_key_exists($key, $sel_edit_right_arr)) 
									{
										$sel_edit_right = $sel_edit_right_arr[$key];
									}

									$sel_view_right = $sel_view_right_arr;
									if (count($sel_view_right_arr) > 0 && array_key_exists($key, $sel_view_right_arr)) 
									{
										$sel_view_right = $sel_view_right_arr[$key];
									}

									$sel_delete_right = $sel_delete_right_arr;
									if (count($sel_delete_right_arr) > 0 && array_key_exists($key, $sel_delete_right_arr)) 
									{
										$sel_delete_right = $sel_delete_right_arr[$key];
									}

									$sel_print_right = $sel_print_right_arr;
									if (count($sel_print_right_arr) > 0 && array_key_exists($key, $sel_print_right_arr)) 
									{
										$sel_print_right = $sel_print_right_arr[$key];
									}

									$sel_email_right = $sel_email_right_arr;
									if (count($sel_email_right_arr) > 0 && array_key_exists($key, $sel_email_right_arr)) 
									{
										$sel_email_right = $sel_email_right_arr[$key];
									}
									?> 
									<input type="hidden" name="resource_id[<?php echo $key; ?>]" value="<?php echo $key; ?>" />
									<tr style="background-color:#f8f8f8;">
										<td><?php echo ucfirst($val['title']); ?> Module</td>
										
										<?php if($role_id==7){ ?>
										<td>
											<input type="checkbox" class="minimal change_permisssion" id="<?= $val['id'] ?>" value="1" <?php echo $sel_main_menu == 1 ? 'checked="checked"' : ''; ?> name="main_menu[<?php echo $key; ?>]"/>
										</td>
										<?php } ?>
										<td>
											<input type="checkbox" class="minimal" id="adminallow_view<?= $val['id'] ?>" value="1" <?php echo $sel_view_menu_right == 1 ? 'checked="checked"' : ''; ?> name="view_menu_right[<?php echo $key; ?>]"/>
										</td>
										<td>
											<input type="checkbox" class="minimal" value="1" <?php echo $sel_add_right == 1 ? 'checked="checked"' : ''; ?> name="add_right[<?php echo $key; ?>]"/>
										</td>
										<td>
											<input type="checkbox" class="minimal" value="1" <?php echo $sel_edit_right == 1 ? 'checked="checked"' : ''; ?> name="edit_right[<?php echo $key; ?>]" />
										</td>
										<td>
											<input type="checkbox" class="minimal" value="1" <?php echo $sel_view_right == 1 ? 'checked="checked"' : ''; ?> name="view_right[<?php echo $key; ?>]" />
										</td>
										<td>
											<input type="checkbox" class="minimal" value="1" <?php echo $sel_delete_right == 1 ? 'checked="checked"' : ''; ?> name="delete_right[<?php echo $key; ?>]" />
										</td>
										<td>
											<input type="checkbox" class="minimal" value="1" <?php echo $sel_print_right == 1 ? 'checked="checked"' : ''; ?> name="print_right[<?php echo $key; ?>]" />
										</td>
										<td>
											<input type="checkbox" class="minimal" value="1" <?php echo $sel_email_right == 1 ? 'checked="checked"' : ''; ?> name="email_right[<?php echo $key; ?>]" />
										</td>
									</tr>
									<tr>
										<td>
											
										</td>
									</tr>
									<?php
									isset($val['children']) ? rec($val['children'],$role_id,$sel_main_menu_arr,$sel_view_menu_right_arr, $sel_add_right_arr, $sel_edit_right_arr, $sel_view_right_arr, $sel_delete_right_arr, $sel_print_right_arr, $sel_email_right_arr) : '';
								}
								?>
								</tbody>
							</table>


							<table class="table table-hover table-stripped table-bordered">
								<tr>
									<th>Sale below Minimum price accept permission</th>
									<th>Sale above Maximum price accept Permission</th>
								</tr>
								<tr>
									<td>
										<input type="checkbox" class="minimal" value="1"  name="sale_minimum_right" <?php echo $sale_minimum_permission == 1 ? 'checked="checked"' : ''; ?> />
									</td>
									<td>
										<input type="checkbox" class="minimal" value="1"  name="sale_maximum_right" <?php echo $sale_maximum_permission == 1 ? 'checked="checked"' : ''; ?>/>
									</td>
								</tr>
							</table>



						</div>
						<div class="box-footer">
							<button type="submit" name="sbt_button" value="SUBMIT" class="btn btn-sm btn-success btn-flat" style="background-color: #00a65a !important; border-color: #00a65a;"> 
								<i class="fa fa-save"></i> 
								Save Rules
							</button>

						</div>
					</div>

			

				</form>
			</div>
			<a href="<?= base_url() . 'Sys_admin/modules' ?>" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
		</div>
	</div>
	<br /><br /><br />
</div>

<script type="text/javascript">
    $('#user_id').on('change', function () {
        $('#frmselrule').submit();
    });

    $(document).ready(function () {
        $('#data-table').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": true,
            "columnDefs": [{
                    "targets": [-1],
                    "orderable": false
			}]
        });
    });


    function chk_all_class(chk)
    {
        with (document.frm)
        {
            var d;
            d = document.getElementsByTagName("input");
            for (i = 0; i < d.length; i++)
            {
                var elm_name = d[i].name;
                if (d[i].type == "checkbox")
                {
                    if (chk == true)
                    {
                        d[i].checked = true;
                        if (elm_name.substr(0, 9) == 'add_right' || elm_name.substr(0, 10) == 'edit_right' || elm_name.substr(0, 12) == 'delete_right')
                        {
                            d[i].disabled = false;
                        }
                    } else
                    {
                        d[i].checked = false;
                        if (elm_name.substr(0, 9) == 'add_right' || elm_name.substr(0, 10) == 'edit_right' || elm_name.substr(0, 12) == 'delete_right')
                        {
                            d[i].disabled = true;
                        }
                    }
                }
            }
        }
    }
	$('.select2').select2();
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
	
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
	
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });



$('.change_permisssion').on('ifChanged', function(event){
	 var id = $(this).attr('id');
	 var adminallow_view = $(this).attr('id');
	 console.log(adminallow_view);
		var val = this.checked ? '1' : '0';
		if (val == '1') {
			 $('#adminallow_view'+adminallow_view).iCheck('check');   
			} else {
				$('#adminallow_view'+adminallow_view).iCheck('uncheck');
			}
	});	
		
		
		
    $('input[type="checkbox"]').on('ifClicked', function (ev) {
        $(ev.target).click();
        var d;
        var toggle = true;
        d = document.getElementsByTagName('input');
        for (i = 0; i < d.length; i++)
        {
            if (d[i].type == "checkbox")
            {
                if ($(d[i]).iCheck('ifUnchecked')) {
                    toggle = false;
                }
            }
        }

        if (toggle === true) 
		{
            $('#check_all_').iCheck('check');
        }
		else 
		{
            $('#check_all_').iCheck('unCheck');
        }
    });


    function chk_all_class(chk)
    {
        with (document.frm)
        {
            var d;
            d = document.getElementsByTagName("input");
            for (i = 0; i < d.length; i++)
            {
                var elm_name = d[i].name;
                if (d[i].type == "checkbox")
                {
                    if (chk == true)
                    {
                        $(d[i]).iCheck('check');
                        if (elm_name.substr(0, 9) == 'add_right' || elm_name.substr(0, 10) == 'edit_right' || elm_name.substr(0, 12) == 'delete_right')
                        {
                            d[i].disabled = false;
                        }
                    }
					else
                    {
                        $(d[i]).iCheck('uncheck');
                    }
                }
            }
        }
    }
</script>
