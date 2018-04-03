<?php
    $user_id = $this->session->userdata('user_id');
    $user_em = $this->session->userdata('user_email');
    $user_role = $this->session->userdata('user_role');
    $user_role_name = $this->session->userdata('user_role_name');
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
    $new_sys_settings=array();
    if($settingData->new_settings !='')
    $new_sys_settings = json_decode($settingData->new_settings,true);

    if (isset($_COOKIE['outlet'])) {
        $this->load->helper('cookie');
        delete_cookie('outlet');
    }

    $login_name = '';
    $this->db->where('id', $user_id);
    $query = $this->db->get('users');
    $result = $query->result();
	
	setlocale(LC_MONETARY,"en_US");
    $login_name = $result[0]->fullname;
    $rule_array = ci_check_permission($user_role);
 
    if(!array_key_exists(strtolower($tk_c), $rule_array)){
       redirect(base_url().'error');
    }
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
		<link href="<?=base_url()?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
              
		<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/js/html5shiv.js"></script>
		<script src="<?=base_url()?>assets/js/respond.min.js"></script>
		<![endif]-->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function(){
			    $("#closeAlert").click(function(){
			        $("#notificationWrp").fadeToggle(1000);
			    });
			});
		</script>
	</head>
<style>
.navbar-inverse{
	background-color: <?php echo THEME_COLOR;?> !important;
}
.sidebar ul.nav .active a, .sidebar ul.nav li.parent a.active,
.sidebar ul.nav .active > a:hover, .sidebar ul.nav li.parent a.active:hover,
.sidebar ul.nav .active > a:focus, .sidebar ul.nav li.parent a.active:focus {
	color: #fff;
	background-color: <?php echo THEME_COLOR;?>;
} 
.sidebar ul.nav ul.children li a {
	height: 40px;
	background: #f9f9f9;
	color: #005b8a !important;
}
.btn-primary,.btn-success{
    background-color: <?php echo THEME_COLOR;?> !important;
}
.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus{
	background-color: <?php echo THEME_COLOR;?> !important;
}
.sub-active{
    background-color: #e9ecf2 !important;
}
</style>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=base_url()?>dashboard">
					<?php echo $setting_site_name; ?>
				</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo $login_name; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?=base_url()?>auth/logout"><span><img src="<?php echo base_url().'assets/dashboard/logout.jpg';?>" width="25px" />&nbsp;</span>Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	
	 
	<?php
	if ($tk_c != 'pos') {
	?>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
                    <a href="../includes/header.php"></a>
			<?php
			var_dump(array_key_exists(strtolower('dashboard'), $rule_array));
			 ?>
			<!------------------- Start Dashboard ------------->    
			<?php if(array_key_exists(strtolower('dashboard'), $rule_array)){?>
				<li <?php if ($tk_c == 'dashboard') {  ?> class="parent active" <?php  } else { echo 'class="parent"'; } ?>><a href="<?=base_url()?>dashboard">Dashboard</a></li>
			<?php }?>                      
			<!------------------- End Dashboard ------------->    

			<!------------------- Start Appointments ------------->    
			<?php if(array_key_exists(strtolower('appointments'), $rule_array)){?>

				<li <?php if ($tk_c == 'appointments'   ) { ?> class="parent active" <?php   } else { echo 'class="parent"';  } ?>>
					 <a data-toggle="collapse" href="#appointments">Appointments</a>
					<ul class="children <?php if ($tk_c != 'appointments' ) { ?> collapse <?php  } ?> <?php if ($tk_m == 'index' || $tk_m == 'add_appointment' || $tk_m == 'list_appointment' ) { ?> children in <?php  } ?>" id="appointments">   
						<li ><a <?php if ($tk_m == 'index'){ ?> class="sub-active" <?php }?>  href="<?=base_url()?>appointments">Appointments</a></li>
						<li ><a <?php if ($tk_m == 'add_appointment'){ ?> class="sub-active" <?php }?> href="<?=base_url()?>appointments/add_appointment">Add Appointment</a></li>
						<li><a <?php if ($tk_m == 'list_appointment'){ ?> class="sub-active" <?php }?> href="<?=base_url()?>appointments/list_appointment">Manage Appointments</a></li>
					</ul>
				</li>
			<?php } ?>  
			<!------------------- End Appointments ------------->    

			<!------------------- Start Purchase Module ------------->    
			<?php if(array_key_exists(strtolower('purchase_order'), $rule_array)){?>
				<li <?php if ($tk_c == 'purchase_order' || ($tk_c == 'setting' && $tk_m == 'suppliers' )) { ?> class="parent active" <?php   } else { echo 'class="parent"'; } ?>>
					<a data-toggle="collapse" href="#purchase_order"> Purchase Module</a>
					<ul class="children <?php if ($tk_c != 'purchase_order' && ($tk_c != 'setting' && $tk_m != 'po_view' ) ) { ?> collapse <?php  } ?> <?php if ($tk_m == 'po_view' || $tk_m == 'suppliers'   ) { ?> children in <?php  } ?>" id="purchase_order">   
						<li> <a <?php if ($tk_m == 'po_view'){ ?> class="sub-active" <?php }?> href="<?=base_url()?>purchase_order/po_view">Purchases</a> </li>
						<?php  if ($user_role < 3) { ?>
						<li> <a <?php if ($tk_m == 'suppliers'){ ?> class="sub-active" <?php }?>  href="<?=base_url()?>setting/suppliers" >Suppliers</a> </li>
						<?php } ?>
					</ul>
				</li>
			<?php } ?>

			<!------------------- End Purchase Module ------------->  


			<!------------------- Start Sale Module ------------->    
			<?php if(array_key_exists(strtolower('sales'), $rule_array)){?>
			<li <?php if ($tk_c == 'sales' || ($tk_c == 'customers' || $tk_c == 'debit' || $tk_c=='pos' || $tk_c=='returnorder' ) && (strtolower($tk_m) !='bakerysales')) { ?> class="parent active" <?php  } else {  echo 'class="parent"';  } ?>>
				<a data-toggle="collapse" href="#sub-item-sales">
					Sales Module
				</a>
				<ul class="children <?php if ($tk_c != 'sales' && ($tk_c != 'customers' && $tk_c != 'debit' && $tk_c!='pos' && $tk_c !='returnorder' )) { ?> collapse <?php  } ?> 
					<?php if ($tk_m == 'view' || $tk_m == 'list_sales' || $tk_m == 'opened_bill' || $tk_m == 'opened_bill' || $tk_m == 'create_return'  || $tk_m == 'return_report'   ) { ?> children in <?php  } ?> " id="sub-item-sales">
					<li> <a <?php if (($tk_c == 'customers')) { ?> class='sub-active'   <?php  } ?> href="<?=base_url()?>customers/view"> Customers </a> </li>
					<li> <a <?php if (($tk_c == 'debit')) { ?> class='sub-active'   <?php  } ?> href="<?=base_url()?>debit/view"> Credit Sales </a> </li>
					<li> <a <?php if (($tk_m == 'list_sales')) { ?> class='sub-active'  <?php  } ?> href="<?=base_url()?>sales/list_sales"> Today Sales </a> </li>
					<li> <a <?php if (($tk_m == 'opened_bill')) {  ?> class='sub-active'  <?php  } ?> href="<?=base_url()?>sales/opened_bill"> Opened Bill </a> </li>
					<li> <a <?php if (($tk_c == 'pos')) { ?>  class='sub-active'   <?php  } ?> href="<?=base_url()?>pos">POS </a> </li>
					<li <?php if ($tk_c == 'returnorder') { ?> class="parent active" <?php  } else {  echo 'class="parent"';  } ?>>
						<a data-toggle="collapse" href="#salereturn">Sales Return</a>
						<ul class="children <?php if ($tk_c != 'returnorder' ) { ?> collapse <?php  } ?> <?php if ($tk_m == 'create_return' || $tk_m == 'return_report'   ) { ?> children in <?php  } ?>" id="salereturn">
							<li> <a <?php if (($tk_c == 'returnorder' && $tk_m=='create_return')) { ?> class='sub-active' <?php  } ?> href="<?=base_url()?>returnorder/create_return">Create Sales Return </a> </li>
							<li> <a <?php if (($tk_c == 'returnorder' && $tk_m=='return_report' )) { ?>  class='sub-active' <?php  } ?> href="<?=base_url()?>returnorder/return_report">Sales Return Receipt </a> </li>
						</ul>
					</li>
				</ul>
			</li>
			<?php } ?>
			<!------------------- End Sale Module ------------->    

			<!------------------- Start Bakery Sale Module ------------->    
			<?php if(array_key_exists(strtolower('sales'), $rule_array)){ ?> 
				<li <?php if ( $tk_m=='bakerySales' ||  $tk_m=='issue_sale_report' ) { ?> class="parent active" <?php   } else { echo 'class="parent"'; } ?>>
					<a data-toggle="collapse" href="#bakerysales"> Bakery Module</a>
					<ul class="children <?php if ($tk_m != 'bakerySales' && $tk_m != 'issue_sale_report' ) { ?> collapse <?php  } ?>
						 <?php if ($tk_m == 'bakerySales' || $tk_m == 'issue_sale_report'   ) { ?> children in <?php  } ?>" id="bakerysales">   
						<li> <a <?php if ((  $tk_m=='bakerySales')) { ?> class='sub-active' <?php  } ?>  href="<?=base_url()?>sales/bakerySales">Bakery Sales</a> </li>
						<li> <a <?php if (( $tk_m=='issue_sale_report')) { ?> class='sub-active' <?php  } ?>  href="<?=base_url()?>reports/issue_sale_report">Issue Sales Report</a> </li>
					</ul>
				</li>
			<?php } ?>	 
			<!------------------- End  Bakery Sale Module ------------->    


			<!------------------- Start Pump Module ------------->    
			<?php if(array_key_exists(strtolower('pumps'), $rule_array)){?>
				<li <?php if ($tk_c == 'pumps' ) { ?> class="parent active" <?php  } else { echo 'class="parent"'; } ?>>
					<a data-toggle="collapse" href="#pumps">Pumps Module</a>
					<ul class="children <?php if ($tk_c != 'pumps' ) { ?> collapse <?php  } ?>
						<?php if ($tk_m == 'index' || $tk_m == 'list_operators' || $tk_m == 'list_ft' || $tk_m == 'pumpSales' || $tk_m == 'fuelType'   ) { ?> children in <?php  } ?>" id="pumps">   
						<li><a <?php if (($tk_c == 'pumps' && $tk_m=='index')) { ?> class='sub-active' <?php  } ?>  href="<?=base_url()?>pumps">List Pumps</a></li>
						<li><a <?php if (($tk_c == 'pumps' && $tk_m=='list_operators')) { ?> class='sub-active' <?php  } ?>  href="<?=base_url()?>pumps/list_operators">List Pump Operators</a></li>
						<li><a <?php if (($tk_c == 'pumps' && $tk_m=='list_ft')) { ?> class='sub-active' <?php  } ?>  href="<?=base_url()?>pumps/list_ft">List Fuel Tanks</a></li>
						<li><a <?php if (($tk_c == 'pumps' && $tk_m=='pumpSales')) { ?> class='sub-active' <?php  } ?>  href="<?=base_url()?>pumps/pumpSales">Pump Comm & Shortage</a></li>

						<?php  //if (ci_permissionSysAdminSuperManagerRole() ) { ?>
<!--                                <li><a <?php //if (($tk_c == 'pumps' && $tk_m=='fuelType')) { ?> class='sub-active' <?php  //} ?> href="<?=base_url()?>pumps/fuelType">Fuel Types</a></li>-->
						<?php //} ?>
					</ul>
				</li>
			<?php } ?>
			<!------------------- End Pump Module ------------->    

			<!------------------- Start Inventory Module ------------->    
			<?php //echo "prod-$tk_c";
				if(array_key_exists(strtolower('inventory'), $rule_array)){?>
				<li <?php if ($tk_c == 'inventory' || $tk_c == 'products'   ) { ?> class="parent active" <?php  } else { echo 'class="parent"'; } ?>>
					<a data-toggle="collapse" href="#inventory">Inventory Module</a>
					<ul class="children <?php if ($tk_c != 'inventory' && $tk_c != 'products') { ?> collapse <?php  } ?>
						<?php if ($tk_m == 'index' || $tk_m == 'list_products' || $tk_m == 'product_category' || $tk_m == 'print_label' ) { ?> children in <?php  } ?>" id="inventory">
						<li><a href="<?=base_url()?>inventory/view">Inventory</a></li>
						<li <?php if ($tk_c == 'products') { ?> class="parent active" <?php  } else {  echo 'class="parent"';  } ?>>
							<a data-toggle="collapse" href="#products">Products</a>
							<ul class="children <?php if ($tk_c !== 'products') { ?> collapse <?php  } ?>
								<?php if (  $tk_m == 'list_products' || $tk_m == 'product_category' || $tk_m == 'print_label' ) { ?> children in <?php  } ?> " id="products">
								<li> <a <?php if (($tk_c == 'products' && $tk_m== 'list_products')) { ?> class="sub-active" <?php  } ?> href="<?=base_url()?>products/list_products">List Products </a> </li>
								<li> <a <?php if (($tk_c == 'products' && $tk_m== 'product_category')) { ?> class="sub-active" <?php  } ?> href="<?=base_url()?>products/product_category">Product Category </a> </li>
								<li> <a <?php if (($tk_c == 'products' && $tk_m== 'print_label')) { ?> class="sub-active" <?php  } ?> href="<?=base_url()?>products/print_label">Print Product Label</a> </li>
							</ul>
						</li>
					</ul>
				</li>
			<?php } ?>
			<!------------------- End Inventory Module ------------->    

			<!------------------- Start Banking Module -------------> 
			<?php if(array_key_exists(strtolower('bank_accounts'), $rule_array)){?>
			<li <?php if ($tk_c == 'bank_accounts' || $tk_c == 'bank_dt') {
					?> class="parent active" <?php 
				} else {
					echo 'class="parent"';
				} ?>>
				<a data-toggle="collapse" href="#banking">Banking Module</a>
				<ul class="children <?php if ($tk_c != 'bank_accounts' && $tk_c != 'bank_dt') { ?> collapse <?php  } ?>
					<?php if (  $tk_m == 'index' || $tk_m == 'view' || $tk_m == 'balance' ) { ?> children in <?php  } ?> " id="banking">   
					<li><a <?php if (($tk_c == 'bank_accounts' && ($tk_m== 'view' || $tk_m== 'index') )) { ?> class="sub-active" <?php  } ?>  href="<?=base_url()?>bank_accounts">Bank Accounts</a></li>
					<li><a  <?php if (($tk_c == 'bank_dt' && ($tk_m== 'view' || $tk_m== 'index'))) { ?> class="sub-active" <?php  } ?> href="<?=base_url()?>bank_dt">Bank Deposit/Transfer</a></li>
					<li><a <?php if (($tk_c == 'bank_accounts' && $tk_m== 'balance')) { ?> class="sub-active" <?php  } ?> href="<?=base_url()?>bank_accounts/balance">Account Balances</a></li>

				</ul>
			</li>
			<?php } ?>    
			<!------------------- End Banking Module ------------->    

			<!-------------------Start Gift Card Module ------------->
			<?php if(array_key_exists(strtolower('gift_card'), $rule_array)){?>
			<li <?php if ($tk_c == 'gift_card') {  ?> class="parent active" <?php  } else { echo 'class="parent"';  } ?>>
				<a data-toggle="collapse" href="#sub-item-gift">
					Gift Card
				</a>
				<ul class="children <?php if ($tk_c != 'gift_card') {  ?> collapse <?php  } ?><?php if (  $tk_m == 'add_gift_card' || $tk_m == 'list_gift_card' ) { ?> children in <?php  } ?>" id="sub-item-gift">
					<?php
					// if ($user_role == '1' || $user_role == '2' ) {
					if ( $user_role_name == SYSTEM_ADMIN_ROLE  ||  $user_role_name == ADMIN_ROLE || $user_role_name == MANAGER_ROLE ) { ?>
						<li>
							<a <?php if (($tk_c == 'gift_card' && $tk_m== 'add_gift_card')) { ?> class="sub-active" <?php  } ?> href="<?=base_url()?>gift_card/add_gift_card">
								Add Gift Card
							</a>
						</li>
					<?php } ?>
					<li>
						<a  <?php if (($tk_c == 'gift_card' && $tk_m== 'list_gift_card')) { ?> class="sub-active" <?php  } ?> href="<?=base_url()?>gift_card/list_gift_card">
							List Gift Card
						</a>
					</li>
				</ul>
			</li>
			<?php } ?>              
			<!------------------- End Gift Card Module ------------->    


			<!------------------- Start Expense Module ------------->  
			<?php if(array_key_exists(strtolower('expenses'), $rule_array)){?>

			<li <?php if ($tk_c == 'expenses') { ?> class="parent active" <?php } else { echo 'class="parent"'; } ?>>
				<a data-toggle="collapse" href="#sub-item-expenses">
					Expenses Module
				</a>
				<ul class="children <?php if ($tk_c != 'expenses') { ?> collapse <?php } ?><?php if (  $tk_m == 'view' || $tk_m == 'expense_category' ) { ?> children in <?php  } ?>" id="sub-item-expenses">
					<li>
						<a <?php if (($tk_c == 'expenses' && $tk_m== 'view')) { ?> class="sub-active" <?php  } ?>  href="<?=base_url()?>expenses/view">
							Expenses
						</a>
						<a   <?php if (($tk_c == 'expenses' && $tk_m== 'expense_category')) { ?> class="sub-active" <?php  } ?>  href="<?=base_url()?>expenses/expense_category">
							Expense Category
						</a>
					</li>
				</ul>
			</li>  
			<?php } ?>
			<!------------------- End Expense Module ------------->    

			<!------------------- Start Report Module ------------->    
			<?php if(array_key_exists(strtolower('reports'), $rule_array)){?>

			<?php
		   // if ($user_role < 3) {
			if ( $user_role_name == SYSTEM_ADMIN_ROLE  ||  $user_role_name == ADMIN_ROLE || $user_role_name == MANAGER_ROLE ) { ?>
			<li <?php if ($tk_c == 'reports') { ?> class="parent active" <?php  } else {  echo 'class="parent"'; } ?>>
				<a data-toggle="collapse" href="#sub-item-reports">
					Reports
				</a>
				<ul class="children <?php if ($tk_c != 'reports') {  ?> collapse <?php   } ?>
					<?php if (  $tk_m == 'sales_report' || $tk_m == 'product_category_report' ) { ?> children in <?php  } ?>" id="sub-item-reports">
					<li>
						<a <?php if (($tk_m == 'sales_report')) { ?> class="sub-active" <?php   } ?> href="<?=base_url()?>reports/sales_report">Sales Report</a>
					</li>
					<li>
						<a <?php if (($tk_m == 'product_category_report')) { ?> class="sub-active" <?php   } ?> href="<?=base_url()?>reports/product_category_report">
							Product Category Report
						</a>
					</li>
				</ul>
			</li>
			<?php
				}
			}
			?>

			<!------------------- End Reports Module ------------->    

			<!------------------- Start Profit Loss Module ------------->    
			<?php if(array_key_exists(strtolower('pnl'), $rule_array)){?>
			<?php
		   // if ($user_role < 3) {
				if ( $user_role_name == SYSTEM_ADMIN_ROLE  ||  $user_role_name == ADMIN_ROLE  ) { ?>
					<li <?php if ($tk_c == 'pnl') { ?> class="parent active" <?php   } else { echo 'class="parent"';  } ?>>
						<a data-toggle="collapse" href="#pl-report">
							Profit &amp; Loss
						</a>
						<ul class="children <?php if ($tk_c != 'pnl' && $tk_c != 'pnl_report') {  ?> collapse <?php   } ?><?php if (  $tk_m == 'view' || $tk_m == 'view_pnl_report' ) { ?> children in <?php  } ?>" id="pl-report">
							<li> <a <?php if (($tk_c == 'pnl' && $tk_m=='view')) { ?> class="sub-active" <?php   } ?> href="<?=base_url()?>pnl/view">
									P &amp; L Graphs
								</a>
							</li>
							<li>
								<a <?php if (($tk_c == 'pnl_report' && $tk_m=='view_pnl_report')) { ?> class="sub-active" <?php   } ?> href="<?=base_url()?>pnl_report/view_pnl_report">
									P &amp;L Report
								</a>
							</li>
						</ul>
					</li>
				<?php
				}
			}
			?>	

			<!------------------- End Profit Loss Module ------------->    

			<!------------------- Start Setting Module ------------->    

				<?php if(array_key_exists(strtolower('setting'), $rule_array)){?>

				<li <?php if ($tk_c == 'setting') { ?> class="parent active" <?php  } else {  echo 'class="parent"'; } ?>>
					<a data-toggle="collapse" href="#sub-item-1">
						Setting
					</a>
					<ul class="children <?php if ($tk_c != 'setting') {  ?> collapse <?php   } ?>
						<?php if (  $tk_m == 'outlets' || $tk_m == 'users'  || $tk_m == 'payment_methods' || $tk_m == 'system_setting' ) { ?> children in <?php  } ?>    " id="sub-item-1">
						<li>
							<a <?php if (($tk_m == 'outlets') || ($tk_m == 'addoutlet') || ($tk_m == 'editoutlet')) { ?> class="sub-active" <?php  } ?> href="<?=base_url()?>setting/outlets">
								Outlets
							</a>
						</li>
						<li>
							<a <?php if (($tk_m == 'users') || ($tk_m == 'adduser') || ($tk_m == 'edituser')) { ?> class="sub-active" <?php  } ?> href="<?=base_url()?>setting/users">
								Users
							</a>
						</li>
						<?php } ?>
						<?php if ( $user_role_name == SYSTEM_ADMIN_ROLE  ||  $user_role_name == ADMIN_ROLE  ) { ?>
							<li>
								<a <?php if (($tk_m == 'payment_methods') || ($tk_m == 'addpaymentmethod') || ($tk_m == 'editpaymentmethod')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>setting/payment_methods">
									Payment Methods
								</a>
							</li>
						<?php } ?>
						<?php if ($user_role_name == SYSTEM_ADMIN_ROLE || $user_role_name == ADMIN_ROLE) { ?>
							<li>
								<a <?php if ($tk_m == 'system_setting') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>setting/system_setting">
									System Setting
								</a>
							</li>
						<?php } ?>
					</ul>
				</li>

				<!------------------- End Settings Module ------------->    
				<?php if(array_key_exists(strtolower('Sys_admin'), $rule_array)){?>
				<?php
				if($user_role_name === SYSTEM_ADMIN_ROLE){ ?>
					<li <?php if ($tk_c == 'Sys_admin' ) { ?> class="parent active" <?php  } else {  echo 'class="parent"'; } ?>>
						<a data-toggle="collapse" href="#Sys_admin">System Administration</a>
						<ul class="children <?php if ($tk_c != 'Sys_admin' ) { ?> collapse <?php  } ?>
							<?php if (  $tk_m == 'roles' || $tk_m == 'modules'  || $tk_m == 'rules' || $tk_m == 'Sys_setting' ) { ?> children in <?php  } ?>" id="Sys_admin">   
							<li><a <?php if ($tk_m == 'roles') { ?> class="sub-active" <?php   } ?>  href="<?=base_url()?>Sys_admin/roles">Manage Roles</a></li>
							<li><a <?php if ($tk_m == 'modules') { ?> class="sub-active" <?php   } ?>   href="<?=base_url()?>Sys_admin/modules">Manage Modules</a></li>
							<li><a <?php if ($tk_m == 'rules') { ?> class="sub-active" <?php   } ?>  href="<?=base_url()?>Sys_admin/rules">Manage Rules</a></li>
							<li><a <?php if ($tk_m == 'Sys_setting') { ?> class="sub-active" <?php   } ?>  href="<?=base_url()?>Sys_admin/Sys_setting">System Settings</a></li>
						</ul>
					</li>
				<?php 
				}
			}
			?>
			<li role="presentation" class="divider"></li>
		</ul>
	</div><!--/.sidebar-->
	<?php        
   }
?>