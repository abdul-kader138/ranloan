<?php
    $user_id = $this->session->userdata('user_id');
    $user_em = $this->session->userdata('user_email');
    $user_role = $this->session->userdata('user_role');
    $user_outlet = $this->session->userdata('user_outlet');

    if (empty($user_id)) {
        redirect(base_url(), 'refresh');
    }

    $tk_c = $this->router->class;
    $tk_m = $this->router->method;

    $alert_msg = $this->session->flashdata('alert_msg');

    $settingResult = $this->db->get_where('site_setting');
    $settingData = $settingResult->row();

    $setting_site_name = $settingData->site_name;
    $setting_pagination = $settingData->pagination;
    $setting_tax = $settingData->tax;
    $setting_currency = $settingData->currency;
    $setting_date = $settingData->datetime_format;
    $setting_product = $settingData->display_product;
    $setting_keyboard = $settingData->display_keyboard;
    $setting_customer_id = $settingData->default_customer_id;
	$permission_data		= $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='pos')");
	$add_right		= $permission_data[0]->add_right;
	$view_right		= $permission_data[0]->edit_right;
	
	
	$this->db->where('id', $user_id);
	$query = $this->db->get('users');
	$result = $query->result();
	$login_name = $result[0]->fullname;
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php echo $setting_site_name; ?></title>

		<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/css/datepicker3.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/css/styles.css" rel="stylesheet">
		
		<link href="<?=base_url()?>assets/css/icono.min.css" rel="stylesheet">
		<style>
	/* message box */
	body{
		height:100%;
	}
	.modal-backdrop{
	z-index: 0 !important;
	}
	.message-box {
	  display: none;
	  position: fixed;
	  left: 0px;
	  top: 0px;
	  width: 100%;
	  height: 100%;
	  background: rgba(0, 0, 0, 0.5);
	  z-index: 9999;
	}
	.message-box.open {
	  display: block;
	}
	.message-box .mb-container {
	  position: absolute;
	  left: 0px;
	  top: 35%;
	  background: rgba(0, 0, 0, 0.9);
	  padding: 20px;
	  width: 100%;
	  z-index:0;
	}
	.message-box .mb-container .mb-middle {
	  width: 50%;
	  left: 25%;
	  position: relative;
	  color: #FFF;
	}
	.message-box .mb-container .mb-middle .mb-title {
	  width: 100%;
	  float: left;
	  padding: 10px 0px 0px;
	  font-size: 31px;
	  font-weight: 400;
	  line-height: 36px;
	}
	.message-box .mb-container .mb-middle .mb-title .fa,
	.message-box .mb-container .mb-middle .mb-title .glyphicon {
	  font-size: 38px;
	  float: left;
	  margin-right: 10px;
	}
	.message-box .mb-container .mb-middle .mb-content {
	  width: 100%;
	  float: left;
	  padding: 10px 0px 0px;
	}
	.message-box .mb-container .mb-middle .mb-content p {
	  margin-bottom: 0px;
	}
	.message-box .mb-container .mb-middle .mb-footer {
	  width: 100%;
	  float: left;
	  padding: 10px 0px;
	}
	.message-box.message-box-warning .mb-container {
	  background: rgba(254, 162, 35, 0.9);
	}
	.message-box.message-box-danger .mb-container {
	  background: rgba(182, 70, 69, 0.9);
	}
	.message-box.message-box-info .mb-container {
	  background: rgba(63, 186, 228, 0.9);
	}
	.message-box.message-box-success .mb-container {
	  background: rgba(149, 183, 93, 0.9);
	}
/* end message box */
</style>
		<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/js/html5shiv.js"></script>
		<script src="<?=base_url()?>assets/js/respond.min.js"></script>
		<![endif]-->
		
		<script src="<?=base_url()?>assets/js/jquery-1.11.1.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
			    $("#closeAlert").click(function(){
			        $("#notificationWrp").fadeToggle(1000);
			    });
			});
		</script>
	</head>

<body>
	
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background: #5fc509;" >
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?=base_url()?>dashboard">
					<?php echo $setting_site_name; ?>
				</a>
				<ul class="user-menu">
					
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg><?=$login_name?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li ><a href="#" class="pos_hedr_logout" ><i class="icono-power" style="color: #30a5ff;"></i> Logout</a></li>
						</ul>
					</li>
					
					
					
					<?php
					if($view_right == 1)
					{
					?>
					<li class="dropdown pull-right">
						<button class="btn btn-primary OpenedHold" style="background: #cc0000">Opened Hold</button>
					</li>
					<?php }
					?>
					
					<li class="dropdown pull-right">
						<a href="<?=base_url()?>dashboard" class="btn btn-primary" style="background: #cc0000;">
							Dashboard
						</a>
					</li>
					<?php
					if($add_right == 1)
						{
					?>
					<li class="dropdown pull-right">
						<button class="btn btn-primary AddNewCustomer" style="background: #cc0000;">Add New Customer</button>
					</li>
					
					<li class="dropdown pull-right" style="padding-right: 100px;">
						<button class="btn btn-primary SalesReturn" style="background: #cc0000;">Sales Return</button>
					</li>
					<?php }
					?>
					
					
					
				</ul>
			</div>
		</div>
	</nav>
				<div class="message-box animated fadeIn pos_heder_logout" data-sound="alert" id="mb-signout">
					<div class="mb-container">
						<div class="mb-middle">
							<div class="mb-title"><span class="fa fa-sign-out"></span>Log <strong>Out</strong> ?</div>
							<div class="mb-content">
								<p>Are you sure you want to log out?</p>                    
								<p>Press No if youwant to continue work. Press Yes to logout current user.</p>
							</div>
							<div class="mb-footer">
								<div class="pull-right">
									<a href="<?= base_url() ?>auth/logout" id="logout_enter" class="btn btn-success btn-lg">Yes</a>
									<button class="btn btn-default btn-lg mb-control-close" >No</button>
								</div>
							</div>
						</div>
					</div>
				</div>
	
	
	<script type="text/javascript">
            $(document).ready(function () {
               

					//popupbox
					$(".pos_hedr_logout").click(function () {
						 $('.pos_heder_logout').modal('show');
					});

					$(".mb-control-close").click(function () {
						$('.message-box').modal('hide');
					});

					//logout
					$("body").keyup(function (e) {
						if(e.keyCode==115)
						{
							var href = $('#logout_enter').attr('href');
							window.location.href = href;
						}
					});
			
            });
			
			
			
		</script>