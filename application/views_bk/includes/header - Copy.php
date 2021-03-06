<?php
$user_id = $this->session->userdata('user_id');
$user_em = $this->session->userdata('user_email');
$user_role = $this->session->userdata('user_role');
$user_role_name = $this->session->userdata('user_role_name');

$user_outlet = $this->session->userdata('user_outlet');
if (empty($user_id)) {
	redirect(base_url(), 'refresh');
}

$tk_c = $this->router->class; //DASHOBOARD
$tk_m = $this->router->method; //INDEX
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
$new_sys_settings = array();
if ($settingData->new_settings != '')
	$new_sys_settings = json_decode($settingData->new_settings, true);

if (isset($_COOKIE['outlet'])) {
	$this->load->helper('cookie');
	delete_cookie('outlet');
}

$login_name = '';
$this->db->where('id', $user_id);
$query = $this->db->get('users');
$result = $query->result();
setlocale(LC_MONETARY, "en_US");

$login_name = !empty($result[0]->fullname)?$result[0]->fullname:'';
//$rule_array = ci_check_permission($user_role);
//    echo "<pre>";
//        print_r($rule_array);
//        die;
$rule_array = ci_check_user_permission($user_id);
/*    echo "<pre>";
  print_r($user_rule_array);
  die; */
/* 	if(!array_key_exists(strtolower($tk_c), $rule_array)){
  redirect(base_url().'error');
  } */
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php echo $setting_site_name; ?></title>


		<link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/datepicker3.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/icono.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
		<link href="<?= base_url() ?>assets/css/multiple-select.css" rel="stylesheet" media="screen">
		<link href="<?= base_url() ?>assets/css/font-awesome.min.css" rel="stylesheet" media="screen">

		<!--[if lt IE 9]>
		<script src="<?= base_url() ?>assets/js/html5shiv.js"></script>
		<script src="<?= base_url() ?>assets/js/respond.min.js"></script>
		<![endif]-->
		<script src="<?= base_url() ?>assets/js/jquery-1.11.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/datatable/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/datatable/buttons.dataTables.min.css">
		<script src="<?= base_url() ?>assets/datatable/jquery.min.js"></script>
		<script src="<?= base_url() ?>assets/datatable/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>assets/datatable/sum().js"></script>
		<script src="<?= base_url() ?>assets/datatable/dataTables.buttons.min.js"></script>
		<script src="<?= base_url() ?>assets/datatable/buttons.html5.min.js"></script>
		<script src="<?= base_url() ?>assets/datatable/buttons.print.min.js"></script>


		<script type="text/javascript">
			//CLOSE TAB AND BROWSER CONFROMATION TAB 
		//	skipCheck = false;
		//		$(document).on('click', function(){
		//			skipCheck = true;
		//			setTimeout(function(){
		//				skipCheck = false;
		//			},500);
		//		});
		//		window.onbeforeunload = function(e){
		//			if(!skipCheck) {    
		//			   if(confirm('are you sure you want to leave?')){
		//				  return 'goodbye';
		//			   } else {
		//				  e.preventDefault();
		//				  return '??'
		//			   }
		//			}
		//		}
		</script>




		<script type="text/javascript">
            $(document).ready(function () {
                $("#closeAlert").click(function () {
                    $("#notificationWrp").fadeToggle(1000);
                });
            });
		</script>
	</head>
	<style>
		.navbar-inverse{
			background-color: <?php echo THEME_COLOR; ?> !important;
		}

		.sidebar ul.nav .active a, .sidebar ul.nav li.parent a.active,
		.sidebar ul.nav .active > a:hover, .sidebar ul.nav li.parent a.active:hover,
		.sidebar ul.nav .active > a:focus, .sidebar ul.nav li.parent a.active:focus {
			color: #fff;
			background-color: <?php echo THEME_COLOR; ?>;
		}
		.sidebar ul.nav ul.children li a {
			height: 40px;
			background: #f9f9f9;
			color: #005b8a !important;
		}
		.btn-primary,.btn-success{
			background-color: <?php echo THEME_COLOR; ?> !important;
		}
		.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus{
			background-color: <?php echo THEME_COLOR; ?> !important;
		}
		.sub-active{
			background-color: #e9ecf2 !important;
		}
		.table tr th
		{
			text-align: left !important;
		}
	</style>
	<body >
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?= base_url() ?>dashboard">
						<?php echo $setting_site_name; ?>
					</a>
					<ul class="user-menu">
						<li class="dropdown  pull-left" style="padding-right: 10px;">
							<a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">Expiry <span style="color: brown;"><i class="fa fa-bell" aria-hidden="true"></i></span></a>
							<ul class="dropdown-menu pull-right" style="padding: 15px;width: 335px;max-height: 300px;overflow: auto;">
								<li>
									<div class="row" >
										<div class="col-md-12">
											<form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
												<div class="form-group">
													<div style="font-weight: 600;">Expiry Notification</div>
													<hr style="margin:  0px;" />
													<table class="table">
														<thead>
															<tr> 
																<td>Product Code</td>
																<td>Batch No.</td>
																<td>Expiry Date</td>
															</tr>
														</thead>
														<tbody>
															<?php
															$pro_Data = $this->db->select('inventory.product_code,batch_expire_multi.expirydate,batch_expire_multi.batch_no');
															$pro_Data = $this->db->from('inventory');
															$pro_Data = $this->db->join('batch_expire_multi', 'batch_expire_multi.inventory_id = inventory.id');
															$pro_Data = $this->db->get()->result();

															$yellow = 90;
															$ash = 30;
															$red = 7;
															$Display = 0;
															$today_date = date('Y-m-d');
															foreach ($pro_Data as $value) {
																$pcode = $value->product_code;
																$pQuery = $this->db->get_where("products", array('code' => $pcode))->row();
																$pname = @$pQuery->name;
																$batch_no = $value->batch_no;
																$expire_date = $value->expirydate;
																$date1 = date_create($today_date);
																$date2 = date_create($expire_date);
																$diff = date_diff($date1, $date2);
																$days = $diff->format("%a");
																if ($today_date < $expire_date) {
																	$Display = 1;
																	if ($days <= $yellow AND $days > $ash) {
																		?>
																		<tr  style="background-color:yellow">
																			<td> <?php echo $pcode; ?> </td>
																			<td> <?php echo $batch_no; ?> </td>
																			<td> <?php echo $expire_date; ?> </td>
																		</tr>
																		<?php
																	} else if ($days <= $ash AND $days > $red) {
																		?>
																		<tr style="background-color:#b2beb5">
																			<td> <?php echo $pcode; ?> </td>
																			<td> <?php echo $batch_no; ?> </td>
																			<td> <?php echo $expire_date; ?> </td>
																		</tr>
																		<?php
																	} else if ($days <= $red) {
																		?>
																		<tr style="background-color:red">
																			<td> <?php echo $pcode; ?> </td>
																			<td> <?php echo $batch_no; ?> </td>
																			<td> <?php echo $expire_date; ?> </td>
																		</tr>
																		<?php
																	}
																}
															}
															?>
														</tbody>
													</table>
												</div>
											</form>
										</div>
									</div>
								</li>
							</ul>
						</li>

						<li class="dropdown  pull-left">
							<a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">Re-Order <span style="color: brown;"><i class="fa fa-bell" aria-hidden="true"></i></span></a>
							<ul class="dropdown-menu pull-right" style="padding: 15px;width: 280px;">
								<li>
									<div class="row" >
										<div class="col-md-12">
											<form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
												<div class="form-group">
													<div style="font-weight: 600;">Re-Order Notification <a style="float: right; padding: 5px 15px;margin-top: -8px;margin-bottom: 8px;" href="<?= base_url() ?>products/reorder_detail" class="btn btn-primary">Detail</a></div>
													<div style="clear: both; float: none;"></div>
													<hr style="margin:  0px;" />
													<ul style="padding-left: 15px;">
														<?php
														$OrderDispaly = 0;
														$Pro_Alert_Data = $this->db->get_where('products', array('status' => 1, 'alt_qty !=' => 0, 'notification' => 0))->result();
														foreach ($Pro_Alert_Data as $value) {
															$code = $value->code;
															$name = $value->name;
															$outlet_id_fk = $value->outlet_id_fk;

															$get_inventoryrow = $this->db->query('SELECT SUM(qty) as qty FROM inventory WHERE product_code = "' . $code . '" ')->row();
															$get_qty = @$get_inventoryrow->qty;
															if ($get_qty <= $value->alt_qty AND $get_qty != 0) {
																?>
																<li><a style="color: #000000;" href="<?= base_url() ?>products/reorder_detail?notify=<?= $value->id ?>">Product Code: <?= $code ?></a></li>
															<?php
															}
														}
														?>
													</ul>
												</div>
											</form>
										</div>
									</div>
								</li>
							</ul>
						</li>


						<li class="dropdown pull-right">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<svg class="glyph stroked male-user">
								<use xlink:href="#stroked-male-user"></use>
								</svg><?php echo $login_name; ?> <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a onclick = "if (!confirm('Are your sure logout ?')) {
                                            return false;
                                        }"  href="<?= base_url() ?>auth/logout"><span><img src="<?php echo base_url() . 'assets/dashboard/logout.jpg'; ?>" width="25px" />&nbsp;</span>Logout</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
			<!-- /.container-fluid -->
		</nav>

	<?php if ($tk_c != 'pos') { ?>
			<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
				<ul class="nav menu">
	<?php //}  ?>



					<!------------------- Start Dashboard ------------->    
					<li <?php echo ($tk_c == 'dashboard') ? 'class="parent active"' : 'class="parent"';	?>><a href="<?= base_url() ?>dashboard">Dashboard</a></li>
					<!------------------- End Dashboard ------------->    

					<!------------------- Start Appointments ------------->    
					<?php
					if (array_key_exists(strtolower('appointments'), $rule_array)) {
						if (($rule_array['appointments']->view_menu_right == 1)) {
							?>
							<li <?php echo ($tk_c == 'appointments') ? 'class="parent active"' : 'class="parent"'; ?>>
								<a data-toggle="collapse" href="#appointments">
									Appointments
								</a>
								<ul class="children <?php if ($tk_c != 'appointments') { ?> collapse <?php } ?> <?php if ($tk_m == 'index' || $tk_m == 'add_appointment' || $tk_m == 'list_appointment') { ?> children in <?php } ?>" id="appointments">
									<?php if (array_key_exists(strtolower('index'), $rule_array) && array_key_exists(ci_is_sub_module('appointments', 'index'), $rule_array)) { ?>
										<li ><a <?php if ($tk_m == 'index') { ?> class="sub-active" <?php } ?>  href="<?= base_url() ?>appointments">Appointments</a></li>
									<?php } ?> 

									<?php
									if (array_key_exists(strtolower('add_appointment'), $rule_array)) {
										if (($rule_array['add_appointment']->view_menu_right == 1)) {
											?> 
											<li ><a <?php if ($tk_m == 'add_appointment') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>appointments/add_appointment">Add Appointment</a></li>
										<?php }
									}
									?>     

									<?php
									if (array_key_exists(strtolower('list_appointment'), $rule_array)) {
										if (($rule_array['list_appointment']->view_menu_right == 1)) {
											?> 
											<li><a <?php if ($tk_m == 'list_appointment') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>appointments/list_appointment">Manage Appointments</a></li>
											<?php
										}
									}
									?> 
								</ul>
							</li>
						<?php
						}
					}
					?>  
					<!------------------- End Appointments ------------->   


					<!------------------- Start Purchase Module ------------->    
					<?php
					if (array_key_exists(strtolower('purchase_order'), $rule_array)) {
						if (($rule_array['purchase_order']->view_menu_right == 1)) {
							?>

							<li <?php if ($tk_c == 'purchase_order' || ($tk_c == 'setting' && $tk_m == 'suppliers' )) { ?> class="parent active" <?php
									} else {
										echo 'class="parent"';
									}
									?>>
								<a data-toggle="collapse" href="#purchase_order"> Purchase Module</a>
								<ul class="children <?php if ($tk_c != 'purchase_order' && ($tk_c != 'setting' && $tk_m != 'po_view' )) { ?> collapse <?php } ?> <?php if ($tk_m == 'po_view' || $tk_m == 'suppliers') { ?> children in <?php } ?>" id="purchase_order">


									<?php
									if (array_key_exists(strtolower('po_view'), $rule_array)) {
										if (($rule_array['po_view']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'po_view') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>purchase_order/po_view">Purchases</a> </li>
				<?php }
			}
			?> 
									<?php
									if (array_key_exists(strtolower('purchase_direct'), $rule_array)) {
										if (($rule_array['purchase_direct']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'purchase_direct') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>purchase_order/purchase_direct">Purchase Direct</a> </li>
				<?php }
			}
			?> 




									<?php
									if (array_key_exists(strtolower('suppliers'), $rule_array)) {
										if (($rule_array['suppliers']->view_menu_right == 1)) {
											?> 

											<li> <a <?php if ($tk_m == 'suppliers') { ?> class="sub-active" <?php } ?>  href="<?= base_url() ?>setting/suppliers" >Suppliers</a> </li>
				<?php
				}
			}
			?>

									<?php
									if (array_key_exists(strtolower('purchase_order'), $rule_array)) {
										if (($rule_array['pay_suppliers']->view_menu_right == 1)) {
											?>
											<li> <a <?php if ($tk_m == 'pay_suppliers') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>purchase_order/pay_suppliers">Pay Suppliers</a> </li>
										<?php }
									}
									?>


									<?php
									if (array_key_exists(strtolower('purchase_return'), $rule_array)) {
										if (($rule_array['purchase_return']->view_menu_right == 1)) {
											?>
											<li> <a <?php if ($tk_m == 'purchase_return') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>purchase_order/purchase_return">Purchase Return</a> </li>
										<?php }
									}
									?>


							<?php
							if (array_key_exists(strtolower('purchase_order'), $rule_array)) {
								if (($rule_array['purchase_bills']->view_menu_right == 1)) {
									?>
											<li> <a <?php if ($tk_m == 'purchase_bills') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>purchase_order/purchase_bills">Purchase Bills</a> </li>
								<?php } if (($rule_array['purchase_bonus']->view_menu_right == 1)) { ?>

											<li> <a <?php if ($tk_m == 'purchase_bonus') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>purchase_order/purchase_bonus">Purchase Bonus</a> </li>
								<?php }
							}
							?>
								</ul>
							</li>
		<?php
		}
	}
	?>
					<!------------------- End Purchase Module ------------->  


					<!------------------- End Purchase Module ------------->  
					<!------------------- Start Sale Module ------------->    
							<?php
							if (array_key_exists(strtolower('sales'), $rule_array)) {
								if (($rule_array['sales']->view_menu_right == 1)) {
									?>
							<li <?php if ($tk_c == 'sales' || ($tk_c == 'customers' || $tk_c == 'debit' || $tk_c == 'pos' || $tk_c == 'returnorder' )) { ?> class="parent active" <?php
					} else {
						echo 'class="parent"';
					}
									?>>
								<a data-toggle="collapse" href="#sub-item-sales">
									Sales Module
								</a>
								<ul class="children <?php if ($tk_c != 'sales' && ($tk_c != 'customers' && $tk_c != 'gold' && $tk_c != 'settlement' && $tk_c != 'debit' && $tk_c != 'pos' && $tk_c != 'returnorder' )) { ?> collapse <?php } ?> 
									<?php if ($tk_m == 'view' || $tk_m == 'list_sales' || $tk_m = 'order_estimate' || $tk_m == 'opened_bill' || $tk_m == 'opened_bill' || $tk_m == 'create_return' || $tk_m == 'return_report') { ?> children in <?php } ?> " id="sub-item-sales">


									<?php
									if (array_key_exists(strtolower('view'), $rule_array) && array_key_exists(ci_is_sub_module('customers', 'view'), $rule_array)) {
										if (($rule_array['customers']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (($tk_c == 'customers')) { ?> class='sub-active'   <?php } ?> href="<?= base_url() ?>customers/view"> Customers </a> </li>
										<?php }
									}
									?>
											
											
									<?php
									if (array_key_exists(strtolower('credit_limits'), $rule_array)) {
										if (($rule_array['credit_limits']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (($tk_c == 'credit_limits')) { ?> class='sub-active'   <?php } ?> href="<?= base_url() ?>customers/credit_limits"> Credit Limits </a> </li>
										<?php }
									}
									?>


									<?php
									if (array_key_exists(strtolower('view'), $rule_array) && array_key_exists(ci_is_sub_module('debit', 'view'), $rule_array)) {
										if (($rule_array['debit']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (($tk_c == 'debit')) { ?> class='sub-active'   <?php } ?> href="<?= base_url() ?>debit/view"> Credit Sales </a> </li>


											<?php
										}
									} if (array_key_exists(strtolower('list_sales'), $rule_array)) {
										if (($rule_array['list_sales']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (($tk_m == 'list_sales')) { ?> class='sub-active'  <?php } ?> href="<?= base_url() ?>sales/list_sales"> Today Sales </a> </li>


											<?php
										}
									}if (array_key_exists(strtolower('opened_bill'), $rule_array)) {
										if (($rule_array['opened_bill']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (($tk_m == 'opened_bill')) { ?> class='sub-active'  <?php } ?> href="<?= base_url() ?>sales/opened_bill"> Opened Bill </a> </li>

											<?php
										}
									}if (array_key_exists(strtolower('pos'), $rule_array)) {
										if (($rule_array['pos']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (($tk_c == 'pos')) { ?>  class='sub-active'   <?php } ?> href="<?= base_url() ?>pos">POS </a> </li>
											<?php }
										}
										?> 



			<?php
			if (array_key_exists(strtolower('settlement'), $rule_array)) {
				if (($rule_array['settlement']->view_menu_right == 1)) {
					?> 
											<li> <a <?php if (($tk_m == 'settlement')) { ?> class='sub-active'  <?php } ?> href="<?= base_url() ?>sales/settlement"> Settle Collection </a> </li>
												<?php }
											}
											?>


											<?php if (($rule_array['returnorder']->view_menu_right == 1)) { ?>
										<li <?php if ($tk_c == 'returnorder') { ?> class="parent active" <?php
												} else {
													echo 'class="parent"';
												}
												?>>
											<a data-toggle="collapse" href="#salereturn">
												Sales Return
											</a>
										<?php
										// start new
										$queryIsview = $this->db->get_where('staff', array('id' => $user_id, 'isview_sale' => '1'));
										if ($queryIsview->num_rows() == 1) {
											?>
												<a data-toggle="collapse" href="#salereturn">
													Sales Return
												</a>
								<?php } //end new ?>

											<ul class="children <?php if ($tk_c != 'returnorder') { ?> collapse <?php } ?> <?php if ($tk_m == 'create_return' || $tk_m == 'return_report') { ?> children in <?php } ?>" id="salereturn">
								<?php
								if (array_key_exists(strtolower('create_return'), $rule_array)) {
									if (($rule_array['create_return']->view_menu_right == 1)) {
										?> 
														<li> <a <?php if (($tk_c == 'returnorder' && $tk_m == 'create_return')) { ?> class='sub-active' <?php } ?> href="<?= base_url() ?>returnorder/create_return">Create Sales Return </a> </li>
					<?php
					}
				} if (array_key_exists(strtolower('return_report'), $rule_array)) {
					if (($rule_array['return_report']->view_menu_right == 1)) {
						?> 
														<li> <a <?php if (($tk_c == 'returnorder' && $tk_m == 'return_report')) { ?>  class='sub-active' <?php } ?> href="<?= base_url() ?>returnorder/return_report">Sales Return Receipt </a> </li>
											<?php }
										}
										?>
											</ul>
										</li>
									<?php } ?>
								</ul>
							</li>
								<?php }
							}
							?>
					<!------------------- End Sale Module ------------->    

							<?php
							if (array_key_exists(strtolower('store'), $rule_array)) {
								if (($rule_array['store']->view_menu_right == 1)) {
									?> 
										
							<li <?php echo ($tk_c == 'Store' || ($tk_c == 'rgrn' ) || ($tk_c == 'list' )) ? 'class="parent active"' : 'class="parent"'; ?>>
								<a data-toggle="collapse" href="#purchase_order3"> Warehouse Module</a>
								<ul class="children <?php if ($tk_c != 'Store' || $tk_c != 'Store') { ?> collapse <?php } ?> <?php if ($tk_m == 'warehouse_list' || $tk_m == 'add_store') { ?> children in <?php } ?>" id="purchase_order3">
									<?php
									if (array_key_exists(strtolower('gold'), $rule_array)) {
										if (($rule_array['warehouse_list']->view_menu_right == 1)) {
										?>
										<li> <a <?php echo ($tk_c == 'Store' && $tk_m == 'warehouse_list') ? 'class="sub-active"' : ''; ?> href="<?= base_url(); ?>Store/warehouse_list">List Warehouses</a> </li>
										<?php
										}
									}
									?> 

									<?php
									if (array_key_exists(strtolower('store'), $rule_array)) {
										if (($rule_array['assign_store']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_c == 'Store' && $tk_m == 'assign_store') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Store/assign_store">Assign Warehouse</a> </li>
										<?php }
									}
									?>

									<?php
									if (array_key_exists(strtolower('store'), $rule_array)) {
										if (($rule_array['warehouse_stocks']->view_menu_right == 1)) {
											?>
											<li> <a <?php if ($tk_c == 'Store' && $tk_m == 'warehouse_stocks') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Store/warehouse_stocks">Warehouse Stocks</a> </li>
										<?php }
									}
									?>

									<?php
									if (array_key_exists(strtolower('store'), $rule_array)) {
										if (($rule_array['transfer_stocks']->view_menu_right == 1)) {
											?>
											<li> <a <?php if ($tk_c == 'Store' && $tk_m == 'transfer_stocks') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Store/transfer_stocks">Transfer Stocks</a> </li>
										<?php }
									}
									?>

								</ul>
							</li>
								<?php
								}
							}
							?>

					<!------------------- End Gold Module ------------->

					<!------------------- Start Gold Module ------------->    
							<?php
							if (array_key_exists(strtolower('gold'), $rule_array)) {
								if (($rule_array['gold']->view_menu_right == 1)) {
									?>
							<li <?php if ($tk_c == 'Gold' || ($tk_c == 'rgrn' ) || ($tk_c == 'list' ) || ($tk_c == 'Goldsmith' )) { ?> class="parent active" <?php
									} else {
										echo 'class="parent"';
									}
									?>>
								<a data-toggle="collapse" href="#purchase_order1"> Gold Module</a>
								<ul class="children <?php if ($tk_c != 'Gold' || $tk_c != 'Gold') { ?> collapse <?php } ?> <?php if ($tk_m == 'rjo' || $tk_m == 'addGoldsmith') { ?> children in <?php } ?>" id="purchase_order1">

									<?php
									if (array_key_exists(strtolower('gold'), $rule_array)) {
										if (($rule_array['addgrade']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'addgrade') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Gold/addgrade">Add Gold-Grade</a> </li>
										<?php }
									}
									?> 

									<?php
									if (array_key_exists(strtolower('gold'), $rule_array)) {
										if (($rule_array['Gold_gold_prices']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'Gold_gold_prices') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Gold/Gold_gold_prices">Gold Grade & Prices</a> </li>
										<?php }
									}
									?> 

									<?php
									if (array_key_exists(strtolower('gold'), $rule_array)) {
										if (($rule_array['order_estimate']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (($tk_c == 'order_estimate')) { ?> class='sub-active'   <?php } ?> href="<?= base_url() ?>Gold/order_estimate"> Order Estimate </a> </li>
										<?php }
									}
									?> 

									<?php
									if (array_key_exists(strtolower('gold'), $rule_array)) {
										if (($rule_array['Goldsmith']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'Goldsmith') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Gold/Goldsmith">Goldsmith</a> </li>
								<?php }
							}
							?> 

							<?php
							if (array_key_exists(strtolower('gold'), $rule_array)) {
								if (($rule_array['view_transfer']->view_menu_right == 1)) {
									?>  
											<li> <a <?php if ($tk_m == 'view_transfer') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Gold/view_transfer">Transfer</a> </li>
																													   <?php }
																												   }
																												   ?> 

									<?php
									if (array_key_exists(strtolower('gold'), $rule_array)) {
										if (($rule_array['list_store_transfer']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'list_store_transfer') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Gold/list_store_transfer">View Store Record</a> </li>
										<?php }
									}
									?> 

									<?php
									if (array_key_exists(strtolower('gold'), $rule_array)) {
										if (($rule_array['list_order_estimate']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'list_order_estimate') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Gold/list_order_estimate">List Order Estimate</a> </li>
										<?php }
									}
									?> 

									<?php if (array_key_exists(strtolower('gold'), $rule_array)) {
										?> 

										<?php
										if (array_key_exists(strtolower('gold'), $rule_array)) {
											if (($rule_array['Gold_gradeview']->view_menu_right == 1)) {
												?> 
												<li> <a <?php if ($tk_m == 'Gold_gradeview') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Gold/Gold_gradeview">Gold Grade List</a> </li>
											<?php
											}
										}
									}
									?> 
								</ul>
							</li>
						<?php
						}
					}
					?>
					<!------------------- End Gold Module ------------->    
					<!----------------------------------------------------------------   Start Side Nav for Refine Gold Module    --------------------------------------------------------------->
					<?php
					if (array_key_exists(strtolower('refine_gold'), $rule_array)) {
						if (($rule_array['refine_gold']->view_menu_right == 1)) {
							?>
							<li <?php if ($tk_c == 'Refine_gold' || ($tk_c == 'rgrn' ) || ($tk_c == 'list' )) { ?> class="parent active" <?php
							} else {
								echo 'class="parent"';
							}
							?>>
								<a data-toggle="collapse" href="#goldsmith"> Refined Gold Module</a>
								<ul class="children <?php if ($tk_c != 'Refine_gold' || $tk_c != 'Store') { ?> collapse <?php } ?> <?php if ($tk_m == 'add_store' || $tk_m == 'add_store') { ?> children in <?php } ?>" id="goldsmith">

									<?php
									if (array_key_exists(strtolower('refine_gold'), $rule_array)) {
										if (($rule_array['refine_order_list']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'refine_order_list') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Refine_gold/refine_order_list">Refine Order List</a> </li>
										<?php }
									}
									?> 

									<?php
									if (array_key_exists(strtolower('refine_gold'), $rule_array)) {
										if (($rule_array['add_refine_order']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'add_refine_order') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Refine_gold/add_refine_order">Add Refine Order</a> </li>
										<?php }
									}
									?> 


									<?php
									if (array_key_exists(strtolower('refine_gold'), $rule_array)) {
										if (($rule_array['add_refined_receive_note']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'add_refined_receive_note') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Refine_gold/add_refined_receive_note">Add Refined Receieved Note</a> </li>
				<?php }
			}
			?> 

									<?php
									if (array_key_exists(strtolower('refine_gold'), $rule_array)) {
										if (($rule_array['refined_gold']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if ($tk_m == 'refined_gold') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Refine_gold/refined_gold">Refined Gold List</a> </li>
										<?php }
									}
									?> 
								</ul>
							</li>
						<?php
						}
					}
					?>
					<!-------------------------------------------------------------------------------   End Side Nav for Refine Gold Module    ------------------------------------------------------->
					<!--  Start Side Nav for Production    -->
					<?php
					if (array_key_exists(strtolower('productions'), $rule_array)) {
						if (($rule_array['productions']->view_menu_right == 1)) {
							?>


							<li <?php if ($tk_c == 'Productions' || ($tk_c == 'rgrn' ) || ($tk_c == 'list' )) { ?> class="parent active" <?php } else {
					echo 'class="parent"';
				} ?>>				

								<a data-toggle="collapse" href="#productions"> Production</a>
								<ul class="children <?php if ($tk_c != 'Productions') { ?>  <?php } ?> <?php if ($tk_m == 'add_store' || $tk_m == 'add_store') { ?> children in <?php } ?>" id="productions">

			<?php
			if (array_key_exists(strtolower('productions'), $rule_array)) {

				if (($rule_array['all_production']->view_menu_right == 1)) {
					?> 
											<li> <a <?php if ($tk_m == 'all_production') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Productions/all_production">Production</a> </li>
										<?php }
									}
									?> 


			<?php
			if (array_key_exists(strtolower('productions'), $rule_array)) {
				if (($rule_array['list_goldsmith_wastage']->view_menu_right == 1)) {
					?> 
											<li> <a <?php if (($tk_c == 'Productions' && $tk_m == 'list_goldsmith_wastage')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Productions/list_goldsmith_wastage">Goldsmith Wastage </a> </li>
				<?php }
			}
			?>


							<?php
							if (array_key_exists(strtolower('productions'), $rule_array)) {
								
								if (($rule_array['all_work_job_order']->view_menu_right == 1)) {
									?> 
											<li> <a <?php if (($tk_c == 'Productions' && $tk_m == 'all_work_job_order')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Productions/all_work_job_order">Work /Job Order </a> </li>
										<?php }
									}
									?>
											
									<?php		
										if ((@$rule_array['receive_work_job_order']->view_menu_right == 1)) {
									?> 
										<li> <a <?php if (($tk_c == 'Productions' && $tk_m == 'receive_work_job_order')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Productions/receive_work_job_order">Receive Work /Job Order </a> </li>
										<?php }
									?>		
											
											

									<?php
									if (array_key_exists(strtolower('productions'), $rule_array)) {
										if (($rule_array['producation_receive']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (($tk_c == 'Productions' && $tk_m == 'producation_receive')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>Productions/producation_receive">Producation Receive </a> </li>
										<?php }
									}
									?>



								</ul>
							</li>
								<?php
								}
							}
							?>
					<!--   End Side Nav for Production    -->
					<!------------------- Start Bakery Sale Module ------------->    
							<?php
							if (array_key_exists(strtolower('bakery_sales'), $rule_array)) {
								if (($rule_array['bakery_sales']->view_menu_right == 1)) {
									?> 
							<li <?php if ($tk_m == 'bakerySales' || $tk_m == 'issue_sale_report') { ?> class="parent" <?php } else {
						echo 'class="parent"';
					} ?>>
								<a data-toggle="collapse" href="#bakerysales"> Bakery Module</a>
								<ul class="children <?php if ($tk_m != 'bakerySales' && $tk_m != 'issue_sale_report') { ?> collapse <?php } ?>
									<?php if ($tk_m == 'bakerySales' || $tk_m == 'issue_sale_report') { ?> children in <?php } ?>" id="bakerysales">

									<?php
									if (array_key_exists('bakerySales', $rule_array)) {
										if (($rule_array['bakerySales']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (( $tk_m == 'bakerySales')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>bakery_sales/bakerySales">Bakery Sales</a> </li>

											<?php
										}
									} if (array_key_exists(strtolower('issue_sale_report'), $rule_array)) {
										if (($rule_array['issue_sale_report']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (( $tk_m == 'issue_sale_report')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>reports/issue_sale_report">Issue Sales Report</a> </li>
										<?php }
									}
									?>

								</ul>
							</li>
								<?php }
							}
							?>	 
					<!------------------- End  Bakery Sale Module ------------->    



					<!------------------- Start Pump Module ------------->    
					<?php
					if (array_key_exists(strtolower('pumps'), $rule_array)) {
						if (($rule_array['pumps']->view_menu_right == 1)) {
							?>
							<li <?php echo ($tk_c == 'pumps') ? 'class="parent active"' : 'class="parent"'; ?>>
								<a data-toggle="collapse" href="#pumps">Pumps Module</a>
								<ul class="children <?php if ($tk_c != 'pumps') { ?> collapse <?php } ?>
								<?php if ($tk_m == 'index' || $tk_m == 'list_operators' || $tk_m == 'list_ft' || $tk_m == 'pumpSales' || $tk_m == 'pumperreport' || $tk_m == 'fuelType' || $tk_m == 'settelment') { ?> children in <?php } ?>" id="pumps">


									<?php
									if (array_key_exists(strtolower('index'), $rule_array) && array_key_exists(ci_is_sub_module('pumps', 'index'), $rule_array)) {
										if (($rule_array['pumps']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'index')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps">List Pumps</a></li>

											<?php
										}
									} if (array_key_exists(strtolower('list_operators'), $rule_array)) {
										if (($rule_array['list_operators']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'list_operators')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/list_operators">List Pump Operators</a></li>


											<?php
										}
									} if (array_key_exists(strtolower('list_ft'), $rule_array)) {
										if (($rule_array['list_ft']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'list_ft')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/list_ft">List Fuel Tanks</a></li>
											<?php
										}
									} if (array_key_exists(strtolower('pumpSales'), $rule_array)) {
										if (($rule_array['pumpSales']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'pumpSales')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/pumpSales">Pump Comm & Shortage</a></li>
										<?php }
									}
									?> 

									<?php
									if (array_key_exists(strtolower('settlement_pump'), $rule_array)) {
										if (($rule_array['settlement_pump']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'settlement_pump')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/settlement">Settlement</a></li>
										<?php }
									}
									?>


									<?php
									if (array_key_exists(strtolower('settlement_list'), $rule_array)) {
										if (($rule_array['settlement_list']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'settlement_list')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/settlement_list">Settlement List</a></li>
										<?php }
									}
									?>

									<?php
									if (array_key_exists(strtolower('deleted_settlement'), $rule_array)) {
										if (($rule_array['deleted_settlement']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'deleted_settlement')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/deleted_settlement">Deleted Settlement</a></li>
										<?php }
									}
									?>


									<?php
									if (array_key_exists(strtolower('escTax'), $rule_array)) {
										if (($rule_array['escTax']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'escTax')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/escTax">Esc Tax</a></li>

									<?php
								}
							} if (array_key_exists(strtolower('pumperreport'), $rule_array)) {
								if (($rule_array['pumperreport']->view_menu_right == 1)) {
									?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'pumperreport')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/pumperreport">Pump Operator Reports</a></li>

									<?php
								}
							} if (array_key_exists(strtolower('fuelsalereport'), $rule_array)) {
								if (($rule_array['fuelsalereport']->view_menu_right == 1)) {
									?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'fuelsalereport')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/fuelsalereport">Fuel Sale Reports</a></li>
				<?php }
			}
			?>


									<?php
									if (array_key_exists(strtolower('dipreport'), $rule_array)) {
										if (($rule_array['dipreport']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'dipreport')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/dipreport">Dip Reports</a></li>
										<?php }
									}
									?>


									<?php
									if (array_key_exists(strtolower('daily_collection'), $rule_array)) {
										if (($rule_array['daily_collection']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'daily_collection')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/daily_collection">Daily Collection</a></li>
										<?php }
									}
									?>

							<?php
							if (array_key_exists(strtolower('pump_reading'), $rule_array)) {
								if (($rule_array['pump_reading']->view_menu_right == 1)) {
									?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'pump_reading')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/pump_reading">Pump Reading</a></li>
				<?php }
			}
			?>


							<?php
							if (array_key_exists(strtolower('fuel_reading'), $rule_array)) {
								if (($rule_array['fuel_reading']->view_menu_right == 1)) {
									?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'fuel_reading')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/fuel_reading">Fuel Tank Reading</a></li>
				<?php }
			}
			?>



									<?php
									if (array_key_exists(strtolower('testing_detail'), $rule_array)) {
										if (($rule_array['testing_detail']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'testing_detail')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/testing_detail">Testing Detail</a></li>
										<?php }
									}
									?>

									<?php
									if (array_key_exists(strtolower('meter_resetting'), $rule_array)) {
										if (($rule_array['meter_resetting']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'pumps' && $tk_m == 'meter_resetting')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>pumps/meter_resetting">Meter Resetting</a></li>
				<?php }
			}
			?>


								</ul>
							</li>
										<?php }
									}
									?>
					<!------------------- End Pump Module ------------->    



					<!------------------- Loan Module ------------->    
									<?php
									if (array_key_exists(strtolower('loan'), $rule_array)) {
										if (($rule_array['loan']->view_menu_right == 1)) {
											?>
							<li <?php if ($tk_c == 'loan') { ?> class="parent active" <?php
											} else {
												echo 'class="parent"';
											}
											?>>
								<a data-toggle="collapse" href="#loan">
									Loans Module
								</a>
								<ul class="children <?php if ($tk_c != 'loan') { ?> collapse <?php } ?>
											<?php if ($tk_m == 'index' || $tk_m == 'loan_list' || $tk_m == 'settle_loan') { ?> children in <?php } ?>" id="loan">

											<?php
											if (array_key_exists(strtolower('loan_list'), $rule_array)) {
												if (($rule_array['loan_list']->view_menu_right == 1)) {
													?> 
											<li><a <?php if (($tk_c == 'loan' && $tk_m == 'loan_list')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>loan/loan_list">Loan List</a></li>
				<?php }
			}
			?>

									<?php
									if (array_key_exists(strtolower('settle_loan'), $rule_array)) {
										if (($rule_array['settle_loan']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'loan' && $tk_m == 'settle_loan')) { ?> class='sub-active' <?php } ?>  href="<?= base_url() ?>loan/settle_loan">Settle Loan</a></li>
										<?php }
									}
									?>

								</ul>
							</li>
						<?php }
					}
					?>




					<!------------------- Start Inventory Module ------------->    
						<?php
						//echo "prod-$tk_c";
						if (array_key_exists(strtolower('inventory'), $rule_array)) {
							if (($rule_array['inventory']->view_menu_right == 1)) {
								?>
							<li <?php if ($tk_c == 'inventory' || $tk_c == 'products' || $tk_c == 'sub_category' || $tk_c == 'brand') { ?> class="parent active" <?php
				} else {
					echo 'class="parent"';
				}
				?>>
								<a data-toggle="collapse" href="#inventory">
									Inventory Module
								</a>
								<ul class="children <?php if ($tk_c != 'inventory' && $tk_c != 'products' && $tk_c != 'sub_category' && $tk_c != 'brand') { ?> collapse <?php } ?>
									<?php if ($tk_m == 'index' || $tk_m == 'list_products' || $tk_m == 'product_category' || $tk_m == 'print_label') { ?> children in <?php } ?>" id="inventory">

									<?php
									if (array_key_exists(strtolower('view'), $rule_array) && array_key_exists(ci_is_sub_module('inventory', 'view'), $rule_array)) {
										if (($rule_array['inventory']->view_menu_right == 1)) {
											?> 

											<li><a href="<?= base_url() ?>inventory/view">Inventory</a></li>
										<?php }
									}
									?> 

									<?php if (($rule_array['products']->view_menu_right == 1)) { ?>

										<li <?php if ($tk_c == 'products') { ?> class="parent active" <?php
										} else {
											echo 'class="parent"';
										}
										?>>
											<a data-toggle="collapse" href="#products">
												Products
											</a>
											<ul class="children <?php if ($tk_c !== 'products') { ?> collapse <?php } ?>
										<?php if ($tk_m == 'list_products' || $tk_m == 'product_category' || $tk_m == 'print_label') { ?> children in <?php } ?> " id="products">

				<?php
				if (array_key_exists(strtolower('list_products'), $rule_array)) {
					if (($rule_array['list_products']->view_menu_right == 1)) {
						?> 
														<li> <a <?php if (($tk_c == 'products' && $tk_m == 'list_products')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>products/list_products">List Products </a> </li>
												<?php
											}
										} if (array_key_exists(strtolower('product_category'), $rule_array)) {
											if (($rule_array['product_category']->view_menu_right == 1)) {
												?> 
														<li> <a <?php if (($tk_c == 'products' && $tk_m == 'product_category')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>products/product_category">Product Category </a> </li>
											<?php }
										}
										?>

										<?php
										if (array_key_exists(strtolower('print_label'), $rule_array)) {
											if (($rule_array['print_label']->view_menu_right == 1)) {
												?> 
														<li> <a <?php if (($tk_c == 'products' && $tk_m == 'print_label')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>products/print_label">Print Product Label</a> </li>
					<?php }
				}
				?>

								<?php
								if (array_key_exists(strtolower('reorder_detail'), $rule_array)) {
									if (($rule_array['reorder_detail']->view_menu_right == 1)) {
										?> 
														<li> <a <?php if (($tk_c == 'products' && $tk_m == 'reorder_detail')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>products/reorder_detail">Re Order Details</a> </li>
					<?php }
				}
				?>

											</ul>
										</li>

							<?php } ?>

			<?php if (($rule_array['brand']->view_menu_right == 1)) { ?> 
										<li><a href="<?= base_url() ?>brand/view">Brand</a></li>

									<?php } if (($rule_array['sub_category']->view_menu_right == 1)) { ?> 
										<li><a href="<?= base_url() ?>sub_category/view">Sub Category</a></li>
									<?php } ?>

								</ul>
							</li>
								<?php }
							}
							?>
					<!------------------- End Inventory Module ------------->    
					<!------------------- Start Banking Module -------------> 
	<?php
	if (array_key_exists(strtolower('bank_accounts'), $rule_array)) {
		if (($rule_array['bank_accounts']->view_menu_right == 1)) {
			?>
							<li <?php if ($tk_c == 'bank_accounts' || $tk_c == 'bank_dt') {
							?> class="parent active" <?php
									} else {
										echo 'class="parent"';
									}
									?>>
								<a data-toggle="collapse" href="#banking">
									Banking Module                                                        
								</a>

								<ul class="children <?php if ($tk_c != 'bank_accounts' && $tk_c != 'bank_dt') { ?> collapse <?php } ?>
									<?php if ($tk_m == 'index' || $tk_m == 'view' || $tk_m == 'balance') { ?> children in <?php } ?> " id="banking">

			<?php
			if (array_key_exists(strtolower('index'), $rule_array) && array_key_exists(ci_is_sub_module('bank_accounts', 'index'), $rule_array)) {
				if (($rule_array['bank_accounts']->view_menu_right == 1)) {
					?> 

											<li><a <?php if (($tk_c == 'bank_accounts' && ($tk_m == 'view' || $tk_m == 'index'))) { ?> class="sub-active" <?php } ?>  href="<?= base_url() ?>bank_accounts">Bank Accounts</a></li>
									<?php
								}
							} if (array_key_exists(strtolower('index'), $rule_array) && array_key_exists(ci_is_sub_module('bank_dt', 'index'), $rule_array)) {
								if (($rule_array['bank_dt']->view_menu_right == 1)) {
									?> 

											<li><a  <?php if (($tk_c == 'bank_dt' && ($tk_m == 'view' || $tk_m == 'index'))) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>bank_dt">Bank Deposit/Transfer</a></li>

									<?php
								}
							} if (array_key_exists(strtolower('balance'), $rule_array)) {
								if (($rule_array['balance']->view_menu_right == 1)) {
									?> 
											<li><a <?php if (($tk_c == 'bank_accounts' && $tk_m == 'balance')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>bank_accounts/balance">Account Balances</a></li>

											<?php
										}
									} if (array_key_exists(strtolower('receivedcheque'), $rule_array)) {
										if (($rule_array['receivedcheque']->view_menu_right == 1)) {
											?> 
											<li><a <?php if (($tk_c == 'receivedcheque' && $tk_m == 'receivedcheque')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>bank_accounts/receivedcheque">Received Cheque Detail</a></li>

											<?php }
										}
										?>

										<?php
										if (array_key_exists(strtolower('receivedcheque'), $rule_array)) {
											if (($rule_array['voucherdetail']->view_menu_right == 1)) {
												?> 
											<li><a <?php if (($tk_c == 'voucherdetail' && $tk_m == 'voucherdetail')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>bank_accounts/voucherdetail">Voucher Details</a></li>
											<?php }
										}
										?>   

			<?php
			if (array_key_exists(strtolower('cheque_manager'), $rule_array)) {
				if (($rule_array['cheque_manager']->view_menu_right == 1)) {
					?> 
											<li><a <?php if (($tk_c == 'cheque_manager' && $tk_m == 'cheque_manager')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>bank_accounts/cheque_manager">Cheque Manager</a></li>
				<?php }
			}
			?>   


								</ul>
							</li>

						<?php }
					}
					?>    
					<!------------------- End Banking Module ------------->   


					<!-------------------Start Gift Card Module ------------->
	<?php
	if (array_key_exists(strtolower('gift_card'), $rule_array)) {
		if (($rule_array['gift_card']->view_menu_right == 1)) {
			?>
							<li <?php if ($tk_c == 'gift_card') { ?> class="parent active" <?php
									} else {
										echo 'class="parent"';
									}
									?>>
								<a data-toggle="collapse" href="#sub-item-gift">
									Gift Card
								</a>
								<ul class="children <?php if ($tk_c != 'gift_card') { ?> collapse <?php } ?>
			<?php if ($tk_m == 'add_gift_card' || $tk_m == 'list_gift_card') { ?> children in <?php } ?>" id="sub-item-gift">
									<?php
									// if ($user_role == '1' || $user_role == '2' ) {

									if ($user_role_name == SYSTEM_ADMIN_ROLE || $user_role_name == ADMIN_ROLE || $user_role_name == MANAGER_ROLE) {
										?>

				<?php
				if (array_key_exists(strtolower('add_gift_card'), $rule_array)) {
					if (($rule_array['add_gift_card']->view_menu_right == 1)) {
						?> 
												<li> <a <?php if (($tk_c == 'gift_card' && $tk_m == 'add_gift_card')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>gift_card/add_gift_card"> Add Gift Card
													</a>
												</li>
											<?php }
										}
										?>

										<?php
									} if (array_key_exists(strtolower('list_gift_card'), $rule_array)) {
										if (($rule_array['list_gift_card']->view_menu_right == 1)) {
											?> 
											<li>
												<a  <?php if (($tk_c == 'gift_card' && $tk_m == 'list_gift_card')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>gift_card/list_gift_card">
													List Gift Card
												</a>
											</li>
										<?php }
									}
									?>
								</ul>
							</li>

								<?php }
							}
							?>              
					<!------------------- End Gift Card Module ------------->    
					<!------------------- Start Expense Module ------------->  
	<?php
	if (array_key_exists(strtolower('expenses'), $rule_array)) {
		if (($rule_array['expenses']->view_menu_right == 1)) {
			//  echo "<pre>";
			//   print_r($rule_array);
			//   die;
			?>
							<li <?php if ($tk_c == 'expenses') { ?> class="parent active" <?php
									} else {
										echo 'class="parent"';
									}
									?>>
								<a data-toggle="collapse" href="#sub-item-expenses">
									Expenses Module
								</a>
								<ul class="children <?php if ($tk_c != 'expenses') { ?> collapse <?php } ?>
									<?php if ($tk_m == 'view' || $tk_m == 'expense_category') { ?> children in <?php } ?>" id="sub-item-expenses">
									<li>
									<?php
									if (array_key_exists(strtolower('expenses'), $rule_array)) {
										if (($rule_array['expenses']->view_menu_right == 1)) {
											?> 
												<a <?php if (($tk_c == 'expenses' && $tk_m == 'view')) { ?> class="sub-active" <?php } ?>  href="<?= base_url() ?>expenses/view">Expenses</a>

					<?php
				}
			} if (array_key_exists(strtolower('expense_category'), $rule_array)) {
				if (($rule_array['expense_category']->view_menu_right == 1)) {
					?> 

												<a   <?php if (($tk_c == 'expenses' && $tk_m == 'expense_category')) { ?> class="sub-active" <?php } ?>  href="<?= base_url() ?>expenses/expense_category">
													Expense Category
												</a>
										<?php }
									}
									?>   
									</li>
								</ul>
							</li>

		<?php }
	}
	?>
					<!------------------- End Expense Module ------------->    
					<!------------------- Start Report Module ------------->    
							<?php
							if (array_key_exists(strtolower('reports'), $rule_array)) {
								if (($rule_array['reports']->view_menu_right == 1)) {
									?>


							<li <?php if ($tk_c == 'reports') { ?> class="parent active" <?php
						} else {
							echo 'class="parent"';
						}
						?>>
								<a data-toggle="collapse" href="#sub-item-reports">
									Reports
								</a>
								<ul class="children <?php if ($tk_c != 'reports') { ?> collapse <?php } ?>
			<?php if ($tk_m == 'sales_report' || $tk_m == 'product_category_report') { ?> children in <?php } ?>"
									id="sub-item-reports">

							<?php
							if (array_key_exists(strtolower('sales_report'), $rule_array)) {
								if (($rule_array['sales_report']->view_menu_right == 1)) {
									?>
											<li><a <?php if (($tk_m == 'sales_report')) { ?> class="sub-active" <?php } ?>
																							 href="<?= base_url() ?>reports/sales_report">
													Product Sales Report
												</a>
											</li>

									<?php
								}
							} if (array_key_exists(strtolower('product_report'), $rule_array)) {
								if (($rule_array['product_report']->view_menu_right == 1)) {
									?>
											<li>
												<a <?php if (($tk_m == 'product_report')) { ?> class="sub-active" <?php } ?>
																							   href="<?= base_url() ?>reports/product_report">
													Product Report
												</a>
											</li>

											<?php
										}
									}
									if (array_key_exists(strtolower('product_category_report'), $rule_array)) {
										if (($rule_array['product_category_report']->view_menu_right == 1)) {
											?>
											<li>
												<a <?php if (($tk_m == 'product_category_report')) { ?> class="sub-active" <?php } ?>
																										href="<?= base_url() ?>reports/product_category_report">
													Product Category Report
												</a>
											</li>

										<?php }
									}
									?>

									<?php
									if (array_key_exists(strtolower('sales_report_payement'), $rule_array)) {
										if (($rule_array['sales_report_payement']->view_menu_right == 1)) {
											?>
											<li>
												<a <?php if (($tk_m == 'sales_report_payement')) { ?> class="sub-active" <?php } ?>
																									  href="<?= base_url() ?>reports/sales_report_payement">
													Sales Report
												</a>
											</li>
				<?php }
			}
			?>

							<?php
							if (array_key_exists(strtolower('daily_summary_report'), $rule_array)) {
								if (($rule_array['daily_summary_report']->view_menu_right == 1)) {
									?>
											<li>
												<a <?php if (($tk_m == 'daily_summary_report')) { ?> class="sub-active" <?php } ?>
																									 href="<?= base_url() ?>reports/daily_summary_report">
													Daily Summary Report
												</a>
											</li>
								<?php }
							}
							?>


							<?php
							if (array_key_exists(strtolower('credit_sales_payment'), $rule_array)) {
								if (($rule_array['credit_sales_payment']->view_menu_right == 1)) {
									?>
											<li>
												<a <?php if (($tk_m == 'credit_sales_payment')) { ?> class="sub-active" <?php } ?>
																									 href="<?= base_url() ?>reports/credit_sales_payment">
													Credit Sales Payments
												</a>
											</li>
										<?php }
									}
									?>


									<?php
									if (array_key_exists(strtolower('taxes'), $rule_array)) {
										if (($rule_array['taxes']->view_menu_right == 1)) {
											?>
											<li>
												<a <?php if (($tk_m == 'taxes')) { ?> class="sub-active" <?php } ?>
																					  href="<?= base_url() ?>reports/taxes">
													Taxes
												</a>
											</li>
										<?php }
									}
									?>

									<?php
									if (array_key_exists(strtolower('product_batch_expiry'), $rule_array)) {
										if (($rule_array['product_batch_expiry']->view_menu_right == 1)) {
											?>
											<li>
												<a <?php if (($tk_m == 'product_batch_expiry')) { ?> class="sub-active" <?php } ?>
																									 href="<?= base_url() ?>reports/product_batch_expiry">
													Product Batch Expiry
												</a>
											</li>
										<?php }
									}
									?>

								</ul>
							</li>

			<?php
		}
	}
	?>
					<!------------------- End Reports Module ------------->    
					<!------------------- Start Profit Loss Module ------------->    
							<?php
							if (array_key_exists(strtolower('pnl'), $rule_array)) {
								if (($rule_array['pnl']->view_menu_right == 1)) {
									?>

							<li <?php if ($tk_c == 'pnl') { ?> class="parent active" <?php
											} else {
												echo 'class="parent"';
											}
											?>>
								<a data-toggle="collapse" href="#pl-report">
									Profit &amp; Loss
								</a>

								<ul class="children <?php if ($tk_c != 'pnl' && $tk_c != 'pnl_report') { ?> collapse <?php } ?>
									<?php if ($tk_m == 'view' || $tk_m == 'view_pnl_report') { ?> children in <?php } ?>" id="pl-report">

									<?php
									if (array_key_exists(strtolower('view'), $rule_array) && array_key_exists(ci_is_sub_module('pnl', 'view'), $rule_array)) {
										if (($rule_array['view']->view_menu_right == 1)) {
											?> 


											<li> <a <?php if (($tk_c == 'pnl' && $tk_m == 'view')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>pnl/view">
													P &amp; L Graphs
												</a>
											</li>

											<?php
										}
									} if (array_key_exists(strtolower('view_pnl_report'), $rule_array)) {
										if (($rule_array['view_pnl_report']->view_menu_right == 1)) {
											?> 
											<li> <a <?php if (($tk_c == 'pnl_report' && $tk_m == 'view_pnl_report')) { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>pnl_report/view_pnl_report">
													P &amp;L Report
												</a>
											</li>
												<?php }
											}
											?>
								</ul>
							</li>
									<?php
								}
							}
							?>	
					<!------------------- End Profit Loss Module ------------->    
					<!------------------- Start Setting Module ------------->    

							<?php
							if (array_key_exists(strtolower('setting'), $rule_array)) 
							{
								if (@$rule_array['permission']->view_menu_right = 1)
								{
									$permission_hide = $rule_array['permission']->view_menu_right;
								}
							} 
							else 
							{
								$permission_hide = 0;
							}
							if ($user_role == 7 && $permission_hide == 0) {
								?>
						<li>
							<a <?php if (($tk_m == 'permission') || ($user_role == 7) || ($tk_m == 'addPermission') || ($tk_m == 'edit_permission')) {
									?> class="sub-active" <?php }
								?> href="<?= base_url() ?>setting/permission">
								Permission
							</a>
						</li>

								<?php
							} else {
								if (array_key_exists(strtolower('setting'), $rule_array)) {


									if (($rule_array['setting']->view_menu_right == 1)) {
										?>
								<li <?php if ($tk_c == 'setting' || $tk_c == 'Bill_Numbering' || $tk_c == 'staff' || $tk_c == 'Product_Code_Numbering') { ?> class="parent active" <?php
								} else {
									echo 'class="parent"';
								}
										?>>
									<a data-toggle="collapse" href="#sub-item-1">
										Setting
									</a>
									<ul class="children <?php if ($tk_c != 'setting') { ?> collapse <?php } ?>
										<?php if ($tk_m == 'outlets' || $tk_m == 'users' || $tk_m == 'payment_methods' || $tk_m == 'system_setting' || $tk_m == 'bill_numbering' || $tk_m == 'product_code_numbering') { ?> children in <?php } ?>" id="sub-item-1">


										<?php
										if (array_key_exists(strtolower('outlets'), $rule_array)) {
											if (($rule_array['outlets']->view_menu_right == 1)) {
												?> 
												<li>
													<a <?php if (($tk_m == 'outlets') || ($tk_m == 'addoutlet') || ($tk_m == 'editoutlet')) {
									?> class="sub-active" <?php } ?> href="<?= base_url() ?>setting/outlets">
														Outlets
													</a>
												</li>

												<?php
											}
										} if (array_key_exists(strtolower('users'), $rule_array)) {
											if (($rule_array['users']->view_menu_right == 1)) {
												?> 
												<li>
													<a <?php if (($tk_m == 'users') || ($tk_m == 'adduser') || ($tk_m == 'edituser')) {
							?> class="sub-active" <?php }
						?> href="<?= base_url() ?>setting/users">
														Users
													</a>
												</li>
												<?php
											}
										} if (array_key_exists(strtolower('staff'), $rule_array)) {
											if (($rule_array['staff']->view_menu_right == 1)) {
												?> 
												<li>
													<a <?php if (($tk_m == 'staff') || ($tk_m == 'addStaff') || ($tk_m == 'edit_staff')) {
													?> class="sub-active" <?php }
												?> href="<?= base_url() ?>staff/view">
														Staff
													</a>
												</li>
						<?php
					}
				} if (array_key_exists(strtolower('permission'), $rule_array)) {
					if (($rule_array['permission']->view_menu_right == 1)) {
						?> 

												<li>
													<a <?php if (($tk_m == 'permission') || ($tk_m == 'addPermission') || ($tk_m == 'edit_permission')) {
							?> class="sub-active" <?php }
						?> href="<?= base_url() ?>setting/permission">
														Permission
													</a>
												</li>

					<?php }
				}
				?>
				<?php
				if (array_key_exists(strtolower('payment_methods'), $rule_array)) {
					if (($rule_array['payment_methods']->view_menu_right == 1)) {
						?> 
										<?php if (ci_permissionSysAdminRole()) { ?>
													<li>
														<a <?php if (($tk_m == 'payment_methods') || ($tk_m == 'addpaymentmethod') || ($tk_m == 'editpaymentmethod')) {
												?> class="sub-active" <?php }
							?> href="<?= base_url() ?>setting/payment_methods">
															Payment Methods
														</a>
													</li>
												<?php
												}
											}
											?>
					<?php
				}

				if (array_key_exists(strtolower('bill_numbering'), $rule_array)) {
					if (($rule_array['bill_numbering']->view_menu_right == 1)) {
						?> 
										<?php if (ci_permissionSysAdminRole()) { ?>
													<li>
														<a <?php if (($tk_m == 'bill_numbering') || ($tk_m == 'add_bill_numbering')) {
								?> class="sub-active" <?php }
							?> href="<?= base_url() ?>setting/bill_numbering">
															Bill Numbering
														</a>
													</li>
								<?php
								}
							}
							?>
					<?php
				}


				if (array_key_exists(strtolower('product_code_numbering'), $rule_array)) {
					if (($rule_array['product_code_numbering']->view_menu_right == 1)) {
						?> 
						<?php if (ci_permissionSysAdminRole()) { ?>
													<li>
														<a <?php if (($tk_m == 'product_code_numbering')) {
								?> class="sub-active" <?php }
							?> href="<?= base_url() ?>setting/product_code_numbering">
															Product Code Numbering
														</a>
													</li>
						<?php
						}
					}
					?>
					<?php
				}

				if (array_key_exists(strtolower('add_new_page'), $rule_array)) {
					if (($rule_array['add_new_page']->view_menu_right == 1)) {
						?> 
						<?php if (ci_permissionSysAdminRole()) { ?>
													<li>
														<a <?php if (($tk_m == 'add_new_page')) {
								?> class="sub-active" <?php }
							?> href="<?= base_url() ?>setting/add_new_page">
															Add New Page
														</a>
													</li>
						<?php
						}
					}
					?>
					<?php
				}

				if (array_key_exists(strtolower('download_database'), $rule_array)) {
					if (($rule_array['download_database']->view_menu_right == 1)) {
						?> 
						<?php if (ci_permissionSysAdminRole()) { ?>
													<li>
														<a <?php if (($tk_m == 'download_database')) {
								?> class="sub-active" <?php }
							?> href="<?= base_url() ?>setting/download_database">
															Download Database
														</a>
													</li>
						<?php
						}
					}
					?>
					<?php
				}

				if (array_key_exists(strtolower('system_setting'), $rule_array)) {
					if (($rule_array['system_setting']->view_menu_right == 1)) {
						?> 
						<?php if (ci_permissionSysAdminRole()) { ?>
													<li>
														<a <?php if ($tk_m == 'system_setting') { ?> class="sub-active" <?php } ?> href="<?= base_url() ?>setting/system_setting">
															System Setting
														</a>
													</li>
						<?php
						}
					}
				}
				?>
									</ul>
								</li>
			<?php
			}
		}
	}
	?>





					<!------------------- End Settings Module ------------->    
	<?php
	if ($user_role == 7) {
		?>

						<li <?php if ($tk_c == 'Sys_admin') { ?> class="parent active" <?php } else {
			echo 'class="parent"';
		} ?>>
							<a data-toggle="collapse" href="#Sys_admin">
								System Administration
							</a>
							<ul class="children <?php if ($tk_c != 'Sys_admin') { ?> collapse <?php } ?>
		<?php if ($tk_m == 'roles' || $tk_m == 'modules' || $tk_m == 'rules' || $tk_m == 'Sys_setting') { ?> children in <?php } ?>" id="Sys_admin">
								<li><a <?php if ($tk_m == 'roles') { ?> class="sub-active" <?php } ?>		href="<?= base_url() ?>Sys_admin/roles">Manage Roles</a></li>
								<li><a <?php if ($tk_m == 'modules') { ?> class="sub-active" <?php } ?>		href="<?= base_url() ?>Sys_admin/modules">Manage Modules</a></li>
								<li><a <?php if ($tk_m == 'rules') { ?> class="sub-active" <?php } ?>		href="<?= base_url() ?>Sys_admin/rules">Manage Rules</a></li>
								<li><a <?php if ($tk_m == 'Sys_setting') { ?> class="sub-active" <?php } ?>  href="<?= base_url() ?>Sys_admin/Sys_setting">System Settings</a></li>
							</ul>
						</li>

		<?php
	} else {
		if (array_key_exists(strtolower('Sys_admin'), $rule_array)) {
			?>
			<?PHP if ($user_role_name === SYSTEM_ADMIN_ROLE) { ?>
								<li <?php if ($tk_c == 'Sys_admin') { ?> class="parent active" <?php } else {
					echo 'class="parent"';
				} ?>>
									<a data-toggle="collapse" href="#Sys_admin">
										System Administration
									</a>
									<ul class="children <?php if ($tk_c != 'Sys_admin') { ?> collapse <?php } ?>
				<?php if ($tk_m == 'roles' || $tk_m == 'modules' || $tk_m == 'rules' || $tk_m == 'Sys_setting') { ?> children in <?php } ?>" id="Sys_admin">
										<li><a <?php if ($tk_m == 'roles') { ?> class="sub-active" <?php } ?>		href="<?= base_url() ?>Sys_admin/roles">Manage Roles</a></li>
										<li><a <?php if ($tk_m == 'modules') { ?> class="sub-active" <?php } ?>		href="<?= base_url() ?>Sys_admin/modules">Manage Modules</a></li>
										<li><a <?php if ($tk_m == 'rules') { ?> class="sub-active" <?php } ?>		href="<?= base_url() ?>Sys_admin/rules">Manage Rules</a></li>
										<li><a <?php if ($tk_m == 'Sys_setting') { ?> class="sub-active" <?php } ?>  href="<?= base_url() ?>Sys_admin/Sys_setting">System Settings</a></li>
									</ul>
								</li>
				<?php
			}
		}
	}
	?>

					<br><br>
					<!-- <li role="presentation" class="divider"></li>-->
				</ul>
			</div>
			<!--/.sidebar-->
	<?php
}
?>
		<script>
			/*********************************/
			$('.parent>.children ').removeClass('in');
			//$('.parent>a ').addClass('collapse');   
			$('.children ').addClass('collapse');

			$('.parent').click(function () {
				$('.parent').removeClass('active');
				$(this).addClass('active');
				//$('.active>ul ').addClass('');   
			});

			$('.active>a').addClass('collapsed');
			$('.active>.children ').addClass('in');
			/******************************/
		</script>