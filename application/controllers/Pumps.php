<?php
class Pumps extends CI_controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('pumps_model');
		$this->load->model('Pos_model');
		$this->load->model('category_model');
		$this->load->model('Constant_model');
		$this->load->model('Gold_module');
		$this->load->model('Customers_model');
		$this->load->library('form_validation');
		
		$this->load->library('pagination');
		$this->load->helper('email');
		
		$settingResult		= $this->db->get_where('site_setting');
		$settingData		= $settingResult->row();
		$setting_timezone	= $settingData->timezone;
		date_default_timezone_set("$setting_timezone");
		if ($this->session->userdata('user_id') == "") {
			redirect(base_url());
		}
	}

	function index() {
		$permisssion_url = 'pumps';
		$permission			= $this->Constant_model->getPermissionPageWise($permisssion_url);
		$permission_re_id	= $permission->resource_id;
		$permisssion_sub_url = 'index';
		$permissionsub		= $this->Constant_model->getPermissionSubPageWise($permission_re_id,$permisssion_sub_url);
		
		if($permissionsub->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$this->view();
	}
	
	
	
	function settlement_opertor($id) {
		
		$data['getPumper'] = $this->Constant_model->getPumper();
		
		$data['getPumpOperator'] = $this->Constant_model->getPumpOperator($id);
		
		$data['TotalExpensePumpOperator'] = $this->Constant_model->TotalExpensePumpOperator($id);
		
		$data['getCustomer'] = $this->Constant_model->getCustomer($id);
		
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;

		$this->load->view('includes/header');
		$this->load->view('pumps/settlement_opertor', $data);
		$this->load->view('includes/footer');
	}
	
	function view() {
		$data['results']		= $this->pumps_model->get_pumps();
		$data['user_role']		= $this->session->userdata('user_role');
		$data['cid']			= $this->input->post_get('cid');
		$data['outlets']		= $this->Constant_model->getddData('outlets', 'id', 'name', 'id');
		$data['fuel_types_dd']	= $this->Constant_model->getddData('fuel_types', 'id', 'fuel_type', 'id');
		$data['fuel_tank_dd']	= $this->Constant_model->getddData('fuel_tanks', 'id', 'fuel_tank_number', 'id');
		$data['user_role_name'] = $this->session->userdata('user_role_name');
		//$ft_dd = $this->Constant_model->getddData('fuel_tanks', 'id', 'fuel_tank_number', 'fuel_tank_number')
		$this->load->view('includes/header');
		$this->load->view('pumps/list_pumps', $data);
		$this->load->view('includes/footer');
	}
	
	
	
	
	
	function meter_resetting()
	{
		
		$permisssion_url = 'meter_resetting';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$user_id					= $this->session->userdata('user_id');
		$data['getMeterResetID']	= $this->Constant_model->getMeterReset($user_id);
		$data['getUsers']			= $this->Constant_model->getUsers($user_id);
		$data['getOutlets']			= $this->Constant_model->getOutlets();
		$data['getpumps']			= $this->Constant_model->getPumper();
		$data['getMeterResetting']	= $this->pumps_model->getMeterResetting();
		$this->load->view('includes/header');
		$this->load->view('pumps/meter_resetting',$data);
		$this->load->view('includes/footer');
	}
	
	
	
	function bulk_voucher()
	{
		$permisssion_url = 'bulk_voucher';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$user_id					= $this->session->userdata('user_id');
		
		$data['getBulkVoucher']		= $this->pumps_model->getBulkVoucher();
		$this->load->view('includes/header');
		$this->load->view('pumps/bulk_voucher',$data);
		$this->load->view('includes/footer');
	}
	
	function bulk_debit_credit()
	{
		$permisssion_url = 'bulk_debit_credit';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$user_id					= $this->session->userdata('user_id');
		
		$data['getBulkDebitCredit']		= $this->pumps_model->getBulkDebitCredit();
		$this->load->view('includes/header');
		$this->load->view('pumps/bulk_debit_credit',$data);
		$this->load->view('includes/footer');
	}
	
	
	function debit_credit_bulk_payment()
	{
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
		
		$id = $this->input->get('id');
		
		$data['getCustomer'] = $this->Constant_model->getCustomer();
		$data['value'] = $this->pumps_model->voucher_bulk_payment($id);
		$this->load->view('includes/header');
		$this->load->view('pumps/debit_credit_bulk_payment',$data);
		$this->load->view('includes/footer');
	}
	
	
	function voucher_bulk_payment()
	{
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
		
		$id = $this->input->get('id');
		
		$data['getCustomer'] = $this->Constant_model->getCustomer();
		$data['value'] = $this->pumps_model->voucher_bulk_payment($id);
		$this->load->view('includes/header');
		$this->load->view('pumps/voucher_bulk_payment',$data);
		$this->load->view('includes/footer');
	}
	
	
	function Voucher_Payment_Submit()
	{
		
		if(!empty($this->input->post('voucher')))
		{
			$user_id			= $this->session->userdata('user_id');
			$today				= date('Y-m-d H:i:s', time());

			$total_amount = $this->input->post('total_amount');
			$payment_id = $this->input->post('payment_id');
			$old_payment = $this->pumps_model->voucher_bulk_payment($payment_id);
			$remaining_unpaid_amount = $old_payment->unpaid_amt - $total_amount;
			
			$arryaremaining = array(
					"subtotal" => $remaining_unpaid_amount,
					"grandtotal" => $remaining_unpaid_amount,
					"unpaid_amt" => $remaining_unpaid_amount,
				);

			$getCustomerData = $this->pumps_model->UpdateVoucher_Payment($arryaremaining,$payment_id);
		
			foreach ($this->input->post('voucher') as $value)
			{

				$getCustomerData = $this->Constant_model->getDataOneColumn('customers', 'id', $value['customer_id']);

				$Customer_fullname  = $getCustomerData[0]->fullname;
				$Customer_email		= $getCustomerData[0]->email;
				$Customer_mobile	= $getCustomerData[0]->mobile;


				$order_payment = array(
							'order_id' => $old_payment->order_id,
							'payment_method' => $old_payment->payment_method,
							'payment_method_name' => $old_payment->payment_method_name,
							'unpaid_amt' => $value['amount'],
							'subtotal' => $value['amount'],
							'grandtotal' => $value['amount'],
							'created_user_id' => $user_id,
							'updated_user_id' => $user_id,
							'ordered_datetime' => $today,
							'created_datetime' => $today,
							'updated_datetime' => $today,
							'voucher_number' => $value['VoucherNumber'],
							'outlet_id' => $old_payment->outlet_id,
							'pump_operators_id' => $old_payment->pump_operators_id,
							'outlet_name' => $old_payment->outlet_name,
							"outlet_address" => $old_payment->outlet_address,
							"outlet_contact" => $old_payment->outlet_contact,
							"outlet_receipt_footer" => $old_payment->outlet_receipt_footer,
							'customer_note' => $value['note'],
							"customer_id" => $value['customer_id'],
							"customer_name" => !empty($Customer_fullname)?$Customer_fullname:'',
							"customer_email" => !empty($Customer_email)?$Customer_email:'',
							"customer_mobile" => !empty($Customer_mobile)?$Customer_mobile:'',
							"sid" => $old_payment->sid,
							"status" => 0,
							"default_bulk_status" => 0,
							"vt_status" => $old_payment->vt_status,
						);
					$order_payment_id = $this->Constant_model->insertDataReturnLastId('orders_payment', $order_payment);	
			}
			$json['success'] = TRUE;
			
		}
		else
		{
			$json['error'] = TRUE;
		}
		echo json_encode($json);
	}
	
	function Debit_Credit_Payment_Submit()
	{
		
		if(!empty($this->input->post('voucher')))
		{
			$user_id			= $this->session->userdata('user_id');
			$today				= date('Y-m-d H:i:s', time());

			$total_amount = $this->input->post('total_amount');
			$payment_id = $this->input->post('payment_id');
			$old_payment = $this->pumps_model->voucher_bulk_payment($payment_id);
			$remaining_unpaid_amount = $old_payment->unpaid_amt - $total_amount;

			$arryaremaining = array(
					"subtotal" => $remaining_unpaid_amount,
					"grandtotal" => $remaining_unpaid_amount,
					"unpaid_amt" => $remaining_unpaid_amount,
				);

			$getCustomerData = $this->pumps_model->UpdateVoucher_Payment($arryaremaining,$payment_id);
		
			foreach ($this->input->post('voucher') as $value)
			{

				$getCustomerData = $this->Constant_model->getDataOneColumn('customers', 'id', $value['customer_id']);

				$Customer_fullname  = $getCustomerData[0]->fullname;
				$Customer_email		= $getCustomerData[0]->email;
				$Customer_mobile	= $getCustomerData[0]->mobile;


				$order_payment = array(
							'order_id' => $old_payment->order_id,
							'payment_method' => $old_payment->payment_method,
							'payment_method_name' => $old_payment->payment_method_name,
							'unpaid_amt' => $value['amount'],
							'subtotal' => $value['amount'],
							'grandtotal' => $value['amount'],
							'created_user_id' => $user_id,
							'updated_user_id' => $user_id,
							'ordered_datetime' => $today,
							'created_datetime' => $today,
							'updated_datetime' => $today,
							'outlet_id' => $old_payment->outlet_id,
							'pump_operators_id' => $old_payment->pump_operators_id,
							'outlet_name' => $old_payment->outlet_name,
							"outlet_address" => $old_payment->outlet_address,
							"outlet_contact" => $old_payment->outlet_contact,
							"outlet_receipt_footer" => $old_payment->outlet_receipt_footer,
							'customer_note' => $value['note'],
							"customer_id" => $value['customer_id'],
							"customer_name" => !empty($Customer_fullname)?$Customer_fullname:'',
							"customer_email" => !empty($Customer_email)?$Customer_email:'',
							"customer_mobile" => !empty($Customer_mobile)?$Customer_mobile:'',
							"sid" => $old_payment->sid,
							"status" => 0,
							"credit_debit_bulk_status" => 0,
							"vt_status" => $old_payment->vt_status,
						);
					$order_payment_id = $this->Constant_model->insertDataReturnLastId('orders_payment', $order_payment);	
			}
			$json['success'] = TRUE;
		}
		else
		{
			$json['error'] = TRUE;
		}
		echo json_encode($json);
	}
	
	
	function getPumpsRecord()
	{
		$pump_id = $this->input->post('pump_id');
		$getpumps = $this->Constant_model->getPumpsSingleRecord($pump_id);
		$json = array(
			'product'	 => $getpumps->product_name, 
			'product_id'	 => $getpumps->product_id, 
			'tank_id'	 => $getpumps->tank_id, 
			'tank'		 => $getpumps->fuel_tank_number, 
			'last_meter' => $getpumps->last_meter_reading, 
			);
		echo json_encode($json);
	}
	
	function MeterResettingSubmit()
	{
		$data = array(
			'outlet_id'			=> $this->input->post('outlet'),
			'pump_id'			=> $this->input->post('pump_id'),
			'product_id'		=> $this->input->post('product_id'),
			'tank_id'			=> $this->input->post('tank_id'),
			'last_meter'		=> $this->input->post('last_meter'),
			'reset_new_meter'	=> $this->input->post('reset_new_meter'),
			'reason'			=> $this->input->post('reason'),
			'created_at'		=> $this->session->userdata('user_id'),
			'created_date'		=> date('Y-m-d H:i:s'),
		);
		$this->Constant_model->insertDataReturnLastId('meter_reset', $data);
		
		$data = array(
			'outlet_id'			=> $this->input->post('outlet'),
			'pump_id'			=> $this->input->post('pump_id'),
			'product_id'		=> $this->input->post('product_id'),
			'start_meter'		=> $this->input->post('reset_new_meter'),
			'end_meter'			=> $this->input->post('reset_new_meter'),
			'sold_qty'			=> 0,
			'amount'			=> 0,
			'testing_qty'		=> 0,
			'created_at'		=> date('Y-m-d H:i:s'),
		);
		$this->Constant_model->insertDataReturnLastId('pump_reading', $data);
		
		
		
		
		
		
		$update = array(
			'last_meter_reading' => $this->input->post('reset_new_meter'),
			'temp_meter_reading' => $this->input->post('reset_new_meter'),
		);
		
		$this->Constant_model->UpdateResettingMeter($update,$this->input->post('pump_id'));
		
		$json['success'] = true;
		echo json_encode($json);
	}
	
	
	
	
	function Delete_Settlement($settle_id)
	{
		if(!empty($settle_id))
		{
			$getSettlement			= $this->pumps_model->SingleSettlementNumber($settle_id);
			$TransactionSettlement	= $this->pumps_model->getTransactionSettlement($settle_id);
			$OrderSettlement		= $this->pumps_model->getOrderSettlement($settle_id);
			$OrderPayment			= $this->pumps_model->getOrderPayment($settle_id);
			$PumpReading			= $this->pumps_model->getPumpReading($settle_id);
			foreach ($OrderSettlement as $settle)
			{
				$qty			= $settle->qty;
				$ppcode			= $settle->product_code;
				$outlet_id		= $settle->outlet_id;
				$fuel_tank_ids	= $settle->ow_id;
				$type			= $settle->type;
				$inventory		= $this->Constant_model->CheckInventoryByTank($ppcode,$outlet_id,$fuel_tank_ids,$type)->row();
				$inventory_final_qty = $inventory->qty + $qty; 
				if($type == 0) //WareHouse
				{
					$warehosue = $this->pumps_model->getWarehosueData($fuel_tank_ids);
					$warehouse_qty = $warehosue->s_stock + $qty;
					$this->pumps_model->UpdateWareHouseQty($warehouse_qty,$warehosue->s_id);
				}
				else //Tank
				{
					$tank = $this->Constant_model->getTankData($fuel_tank_ids);
					$tank_qty = $tank->current_balance + $qty;
					$this->pumps_model->UpdateTankQty($tank_qty,$tank->id);
				}
				
				$delete_inventory_settlement = array(
					'qty'				=> $qty,
					'product_code'		=> $ppcode,
					'outlet_id'			=> $outlet_id,
					'fuel_warehouse_id'	=> $fuel_tank_ids,
					'type'				=> $type,
					'inventory_id'		=> $inventory->id,
					'orders_item_id'	=> $settle->id,
					'created_at'		=> $this->session->userdata('user_id'),
					'created_date'		=> date('Y-m-d H:i:s'),
				);
				
				$this->pumps_model->DeleteInventoryInsert($delete_inventory_settlement);
				$this->pumps_model->UpdateInventoryQty($inventory_final_qty,$inventory->id);
				$this->pumps_model->RemoveOrder_Items($settle->id);	
			}
			
			foreach ($OrderPayment as $payment)
			{
				$totalpayment	= $payment->grandtotal;
				$payment_method = $payment->payment_method;
				$paymentdata	= $this->pumps_model->getPaymentData($payment_method);	
				$finalbalance	= $paymentdata->balance - $totalpayment;
				$this->pumps_model->UpdatePayment_MethodAmount($finalbalance,$payment_method);	
				$this->pumps_model->RemoveOrder_Payment($payment->id);	
			}
			
			foreach ($PumpReading as $reading)
			{
				$total_pump_qty = $reading->sold_qty + $reading->testing_qty;
				$pump = $this->pumps_model->getPumpData($reading->pump_id);	
				$final_last_meter_reading = $pump->last_meter_reading - $total_pump_qty;
				$this->pumps_model->UpdatePumpReading($reading->pump_id,$final_last_meter_reading);	
				$this->pumps_model->DeletePumpReading($reading->id);	
			}
			
			$this->pumps_model->RemovePumperReport($settle_id);	
			$this->pumps_model->RemoveRecordTransaction($settle_id);	
			$this->pumps_model->RemoveMainOrder($settle_id);	
			$this->pumps_model->RemovePumpTesting($settle_id);	
			$this->pumps_model->RemoveSettelementNumber($settle_id);	
			
			
			$this->session->set_flashdata('SUCCESSMSG', "Settlement Deleted Successfully!!");
			redirect('pumps/settlement_list');
		}
		else
		{
			redirect('pumps/settlement_list');
		}
	}
	
	function pump_reading()
	{
		
		$permisssion_url = 'pump_reading';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['pump_reading']	= $this->pumps_model->Pump_Reading();
		$this->load->view('includes/header');
		$this->load->view('pumps/pump_reading',$data);
		$this->load->view('includes/footer');
	}
	function fuel_reading()
	{
		$permisssion_url = 'fuel_reading';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		
        if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['fuel_reading']	= $this->pumps_model->Fuel_Reading();
		$this->load->view('includes/header');
		$this->load->view('pumps/fuel_reading',$data);
		$this->load->view('includes/footer');
	}
	
	function testing_detail()
	{
			
		$permisssion_url = 'testing_detail';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['testing_detail']	= $this->pumps_model->Testing_Detail();
		$this->load->view('includes/header');
		$this->load->view('pumps/testing_detail',$data);
		$this->load->view('includes/footer');
	}
	
	function add_pump() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='pumps')");
		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Add pumps',
				'You can not add pumps. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}
		$res_arr				= array();
		$pump_records_arr_temp	= array();
		$pump_records_arr		= array();
		$pump_res = $this->db->query(' SELECT outlet_id,count(id) as pump_count FROM pumps GROUP BY outlet_id')->result();
		$siteDtaData	= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$new_settings	= $siteDtaData[0]->new_settings;
		$new_settings_array = json_decode($new_settings, true);
		$outlet = $this->input->post('outlet_id');
		
		foreach ($pump_res as $row) {
			$pump_records_arr_temp[$row->outlet_id] = $row->pump_count;
		}
		
		$dd_outlets = $this->Constant_model->getddData('outlets', 'id', 'name', 'id');
		foreach ($dd_outlets as $oid => $val) {
			if (array_key_exists($oid, $pump_records_arr_temp)) {
				$pump_records_arr[$oid] = $pump_records_arr_temp[$oid];
			} else {
				$pump_records_arr[$oid] = 0;
			}
			$res_arr[$oid] = (array_key_exists('max_pumps' . $oid, $new_settings_array)) ? $new_settings_array['max_pumps' . $oid] : 0;
		}
		$sess_arr = ci_getSession_data();
		$data['user_outlet']	= $sess_arr['user_outlet'];
		$data['dd_outlets']		= $dd_outlets;
		$data['categories']		= $this->category_model->get_categories();
		$data['user_role_name'] = $this->session->userdata('user_role_name');
		$data['user_role']		= $this->session->userdata('user_role');
		
		$format_array = ci_date_format();
		$data['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$data['site_currency'] = $format_array['siteSetting_currency'];
		$data['dateformat'] = $format_array['dateformat'];
		$data['pump_records_arr'] = $pump_records_arr;
		$data['res_arr'] = $res_arr;
		
		$this->load->view('includes/header');
		$this->load->view('pumps/add_pump', $data);
		$this->load->view('includes/footer');
	}
	
	function create_pump() {
		
		$siteDtaData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$new_settings = $siteDtaData[0]->new_settings;
		$new_settings_array = json_decode($new_settings, true);
		
		$outlet = $this->input->post('outlet_id');
		$allowed_pumps = (array_key_exists('max_pumps' . $outlet, $new_settings_array)) ? $new_settings_array['max_pumps' . $outlet] : 0;

		if (ci_validate_restriction($allowed_pumps, 'pumps') == false) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Add Pump',
				'You can not add more Pumps. Please ask administrator!'
			));
			redirect(base_url() . 'pumps');
		}
		
		$this->form_validation->set_rules('pump_name', 'Pump Name', 'required');
		$this->form_validation->set_rules('pump_no', 'Pump No. ', 'required');
		$this->form_validation->set_rules('typeahead', 'Fuel Tank', 'required');
//		$this->form_validation->set_rules('fuel_type', 'Fuel Type', 'required');
		$this->form_validation->set_rules('installation_date', 'Installation Date', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->add_pump();
		} else if ($this->pumps_model->create_pump() == FALSE) {
			$this->add_pump;
		} else {
			redirect('pumps');
		}
	}

	function edit_pump() {

		$id = $this->uri->segment(3);
		$data['user_role'] = $this->session->userdata('user_role');
		$user_id = $this->session->userdata('user_id');
		
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='pumps')");

		if (!isset($permission_data[0]->edit_right) || (isset($permission_data[0]->edit_right) && $permission_data[0]->edit_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Edit pumps',
				'You can not edit pumps. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$data['categories'] = $this->category_model->get_categories();
		
		$format_array = ci_date_format();
		$data['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$site_dateformat = $format_array['siteSetting_dateformat'];
		$data['site_currency'] = $format_array['siteSetting_currency'];
		$data['dateformat'] = $format_array['dateformat'];
		$data['id'] = $id;
		
		$data['dd_outlets'] = $this->Constant_model->getddData('outlets', 'id', 'name', 'id');
		$DtaData = $this->Constant_model->getDataOneColumn('pumps', 'id', $id);
		$data['DtaData'] = $DtaData;
		if (count($DtaData) == 0) {
			redirect(base_url() . "pumps");
		}
		$where = '0';
		$pname = '';
		$data['pcode'] = $DtaData[0]->pid;
		
		$prodData = $this->Constant_model->getddData("products", "id", 'name', 'id', 'id=' . $DtaData[0]->pid);
		if (count($prodData) > 0) {
			$pname = $prodData[$DtaData[0]->pid];
		}
		$data['pname'] = $pname;
		$data['rc'] = 1;

		$this->load->view('includes/header');
		$this->load->view('pumps/edit_pump', $data);
		$this->load->view('includes/footer');
	}
	
	public function updatePump() {
		
		$id = $this->input->post('id');
		//upload_image('image_link', $this->input->post('pump_no'), 'pumps', 'pumps', 'id', 'image_link', 1);
		$ftids = $this->input->post("typeahead");
		
		$get_tank	= $this->db->get_where('fuel_tanks', array('id' => $ftids))->row();
		$product_id = $get_tank->product_id;
		$pump_data = array(
			'pump_name' => $this->input->post('pump_name'),
			'pump_no' => $this->input->post('pump_no'),
			'storage_tank' => $this->input->post('storage_tank'),
//			'fuel_type' => $this->input->post('fuel_type'),
			'installation_date' => date('Y-m-d', strtotime(strip_tags($this->input->post('installation_date')))),
			'starting_meter' => $this->input->post('starting_meter'),
			'last_meter_reading' => $this->input->post('starting_meter'),
			'temp_meter_reading' => $this->input->post('starting_meter'),
			'outlet_id' => $this->input->post('outlet_id'),
		//	'image_link' => 'image',
			'fuel_tank_ids' => $ftids,
			'pid' => $product_id
		);
		$this->Constant_model->updateData('pumps', $pump_data, $id);
		$this->session->set_flashdata('alert_msg', array(
			'success',
			'Update Pump',
			"Successfully Updated Pump record"
		));
		redirect(base_url() . 'pumps');
	}
	
	public function deletePump() {
		
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='pumps')");

		if (!isset($permission_data[0]->delete_right) || (isset($permission_data[0]->delete_right) && $permission_data[0]->delete_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Delete pumps',
				'You can not delete pumps. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$id = $this->input->post('id');
		if ($this->Constant_model->deleteData('pumps', $id)) {
			$this->session->set_flashdata('alert_msg', array(
				'success',
				'Delete Pump',
				"Successfully Deleted Pump record"
			));
			redirect(base_url() . 'pumps');
		}
	}
	
	public function showPumps() {
		$id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
		
		$fuel_tank_numbers = $this->Constant_model->getSingle('pumps', 'fuel_tank_ids', "find_in_set('" . $id . "',fuel_tank_ids) != 0 ");
		$ft_arr = explode(',', $fuel_tank_numbers);
		$ft_dd_data = $this->Constant_model->getddData('fuel_tanks', 'id', 'fuel_tank_number', 'id');
		$ft_str = array();

		if (count($ft_arr) > 0) {
			foreach ($ft_arr as $ft_id) {
				$ft_str[] = @$ft_dd_data[$ft_id];
			}
		}

		$where = 'AND pid IN (0)';
		if ($id !== '') {
			$where = " AND fuel_tank_ids IN ($id)";
		}
		$sql = "SELECT * FROM pumps WHERE 1 $where ORDER BY id DESC ";
		$data = records_with_page("pumps/showPumps", '', '', 3, 'DESC', $sql);
		$data['user_role'] = $this->session->userdata('user_role');
		$data['ft_str'] = implode(',', $ft_str);
		
		$this->load->view('includes/header');
		$this->load->view('pumps/showPumps', $data);
		$this->load->view('includes/footer');
	}
	
//	function search_pumps() {
//		
//		$is_get = (isset($_REQUEST['pump_no'])) ? 1 : 0;
//		
//		$pump_no	= ($is_get == 1) ? $this->input->get('pump_no') : $this->uri->segment(3);
//		$pump_name	= ($is_get == 1) ? $this->input->get('pump_name') : $this->uri->segment(4);
//		$ft_id		= ($is_get == 1) ? $this->input->get('ft_id') : $this->uri->segment(5);
//		
//		if (empty($ft_id)) {
//			$ft_id = '0';
//		}
//		$sort = "";
//		
//		if (!empty($pump_no)) {
//			$sort .= " AND pump_no LIKE '%$pump_no%' ";
//		}
//		if (!empty($pump_name)) {
//			$sort .= " AND pump_name LIKE '%$pump_name%' ";
//		}
//		
//		if (!empty($ft_id)) {
//			if ($ft_id == '-') {
//				$sort .= " AND fuel_tank_ids != '' ";
//			} else {
//				$sort .= " AND find_in_set('" . $ft_id . "',fuel_tank_ids) != 0  ";
//			}
//		}
//		
//		$sql = "SELECT * FROM pumps WHERE installation_date != '0000-00-00' $sort ORDER BY pump_name ASC ";
//		$data = records_with_page("pumps/search_pumps/$pump_no/$pump_name/$ft_id", '', '', 6, 'DESC', $sql);
//		
//		$data['pump_no'] = $pump_no;
//		$data['pump_name'] = $pump_name;
//		$data['ft_id'] = $ft_id;
//		$data['fuel_types_dd'] = $this->Constant_model->getddData('fuel_types', 'id', 'fuel_type', 'id');
//		$data['fuel_tank_dd'] = $this->Constant_model->getddData('fuel_tanks', 'id', 'fuel_tank_number', 'id');
//		$data['user_role'] = $this->session->userdata('user_role');
//		$data['user_role_name'] = $this->session->userdata('user_role_name');
//		
//		$this->load->view('includes/header');
//		$this->load->view('pumps/list_pumps', $data);
//		$this->load->view('includes/footer');
//	}
	
	
	/*
	 * Fuel Tank Module
	 */
	function list_ft() 
	{
        $permisssion_url = 'list_ft';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['user_role'] = $this->session->userdata('user_role');
		$data['get_FuelTank'] = $this->pumps_model->get_FuelTank();
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$this->load->view('includes/header');
		$this->load->view('pumps/fueltank', $data);
		$this->load->view('includes/footer');
	}
	
	function show_ftdetails() 
	{
		$id = $this->input->get('id');
		$ftdetails = $this->Constant_model->getShowFtdetails($id);
		$html = '';
		if(!empty($ftdetails))
		{
			foreach ($ftdetails as $value) 
			{
				$befor = $value->available_tank_qty - $value->tank_qty;
				$html.= '<tr>
					<td>'.$value->created_date.'</td>
					<td>'.$value->fuel_tank_number.'</td>
					<td>'.$value->outletsname.'</td>
					<td>'.number_format(0,2).'</td>
					<td>'.number_format($value->tank_qty,2).'</td>
					<td>'.number_format($value->total_tank_balance,2).'</td>
					<td>'.number_format($value->available_tank_qty,2).'</td>
				</tr>'; 
			}
		}
		else
		{
			$html.= '<tr>
						<td colspan="100%">No Record Found!!</td>
					</tr>'; 
		}
		
		$json['success'] = $html;
		echo json_encode($json);
	}
	
	function addFt() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='list_ft')");

		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Add FT',
				'You can not add FT. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$pump_records_arr = array();
		$pump_res = $this->db->query(' SELECT outlet_id,count(id) as pump_count FROM pumps GROUP BY outlet_id')->result();
		foreach ($pump_res as $row) {
			$pump_records_arr[$row->outlet_id] = $row->pump_count;
		}
		$data['categories'] = $this->category_model->get_categories();
		$data['user_role'] = $this->session->userdata('user_role');

		$format_array = ci_date_format();
		$data['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$data['site_currency'] = $format_array['siteSetting_currency'];
		$data['dateformat'] = $format_array['dateformat'];
		$data['pump_records_arr'] = $pump_records_arr;
		
		$this->load->view('includes/header');
		$this->load->view('pumps/add_fueltank', $data);
		$this->load->view('includes/footer');
	}
	
	function OutletWiseProduct()
	{
		$outlet_id	= $this->input->post('outlet_id');
		$data		= $this->pumps_model->OutletWiseProduct($outlet_id);
		$html		= '';
		$html.= '<option value="">Search product</option>';
		foreach ($data as $value)
		{
			$html.= '<option value="'.$value->id.'">'.$value->name.'</option>';
		}
		$json['success'] = $html;
		echo json_encode($json);
	}
	
	
	function create_Ft() {
		$this->form_validation->set_rules('fuel_tank_number', 'Fuel Tank Number', 'required');
		$this->form_validation->set_rules('pid', 'Product ', 'required');
		$this->form_validation->set_rules('outlet_id', 'Outlet', 'required');
		$this->form_validation->set_rules('starting_volume', 'Starting Volume', 'required');
		$this->form_validation->set_rules('current_balance', 'Current Balance', 'required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->addFt();
		} else if ($this->pumps_model->create_ft() == FALSE) {
			$this->addFt();
		} else {
			redirect('pumps/list_ft');
		}
	}
	
	function editFt() {
		$id = $_REQUEST['id'];
		
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='list_ft')");

		if (!isset($permission_data[0]->edit_right) || (isset($permission_data[0]->edit_right) && $permission_data[0]->edit_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Edit FT',
				'You can not edit FT. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$data['id'] = $id;
		
		$DtaData = $this->Constant_model->getDataOneColumn('fuel_tanks', 'id', $id);
		$data['DtaData'] = $DtaData;
		
		if (count($DtaData) == 0) {
			redirect(base_url() . "pumps/fuel_tanks");
		}
		
		$data['categories'] = $this->category_model->get_categories();
		$data['user_role'] = $this->session->userdata('user_role');
		
		$format_array = ci_date_format();
		$data['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$data['site_currency'] = $format_array['siteSetting_currency'];
		$data['dateformat'] = $format_array['dateformat'];
		
		$data['pump_name_dd'] = $this->Constant_model->getddData('pumps', 'id', 'pump_name', 'id');
		$data['pump_no_dd'] = $this->Constant_model->getddData('pumps', 'id', 'pump_no', 'id');
		$data['rc'] = (@$prodData[$DtaData[0]->pid]) ? 2 : 1;
		
		$this->load->view('includes/header');
		$this->load->view('pumps/edit_fueltank', $data);
		$this->load->view('includes/footer');
	}

	public function updateFt() {
		$id = $this->input->post('id');
		
		$this->form_validation->set_rules('fuel_tank_number', 'Fuel Tank Number', 'required');
		$this->form_validation->set_rules('pid', 'Product ', 'required');
		$this->form_validation->set_rules('outlet_id', 'Outlet', 'required');
		$this->form_validation->set_rules('starting_volume', 'Starting Volume', 'required');
		// $this->form_validation->set_rules('current_balance', 'Current Balance', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->editFt();
		}
		else
		{
			$this->pumps_model->update_ft();
			
			$this->session->set_flashdata('alert_msg', array(
				'success',
				'Update Fuel Tanks',
				"Successfully Updated Fuel Tank record"
			));
			redirect(base_url() . 'pumps/list_ft');
		}
	}

	public function deleteFt() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='list_ft')");

		if (!isset($permission_data[0]->delete_right) || (isset($permission_data[0]->delete_right) && $permission_data[0]->delete_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Delete FT',
				'You can not delete FT. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$id = $this->input->get('id');
		if ($this->Constant_model->deleteData('fuel_tanks', $id)) {
			$this->session->set_flashdata('alert_msg', array(
				'success',
				'Delete Fuel Tank',
				"Successfully Deleted Fuel Tank record"
			));
			redirect(base_url() . 'pumps/list_ft');
		}
	}
	
//	public function searchFt() {
//		
//		$is_get = (isset($_REQUEST['fuel_tank_number'])) ? 1 : 0;
//		
//		$fuel_tank_number	= ($is_get == 1) ? $this->input->get('fuel_tank_number') : $this->uri->segment(3);
//		$fuel_type			= ($is_get == 1) ? $this->input->get('fuel_type') : $this->uri->segment(4);
//
//		$sort = '';
//		if (!empty($fuel_tank_number)) {
//			$sort .= " AND fuel_tank_number LIKE '%$fuel_tank_number%' ";
//		}
//		if (!empty($fuel_type)) {
//			$sort .= " AND fuel_type = '" . $fuel_type . "' ";
//		}
//
//		$sql = "SELECT * FROM fuel_tanks WHERE created != '0000-00-00 00:00:00' $sort ORDER BY id DESC ";
//		$data = records_with_page("pumps/searchFt/$fuel_tank_number/$fuel_type", '', '', 5, 'DESC', $sql);
//		
//		$data['user_role'] = $this->session->userdata('user_role');
//		$data['fuel_tank_number'] = $fuel_tank_number;
//		$data['fuel_type'] = $fuel_type;
//
//		$this->load->view('includes/header');
//		$this->load->view('pumps/fueltank', $data);
//		$this->load->view('includes/footer');
//	}
	
	public function exportFt() {
		$siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$site_dateformat = $siteSettingData[0]->datetime_format;
		$site_currency = $siteSettingData[0]->currency;
		
		$this->load->library('excel');
		require_once './application/third_party/PHPExcel.php';
		require_once './application/third_party/PHPExcel/IOFactory.php';
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();
		$default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array(
				'rgb' => '000000'
			)
		);
		$acc_default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array(
				'rgb' => 'c7c7c7'
			)
		);
		$outlet_style_header = array(
			'font' => array(
				'color' => array(
					'rgb' => '000000'
				),
				'size' => 10,
				'name' => 'Arial',
				'bold' => true
			)
		);
		$top_header_style = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array(
					'rgb' => 'ffff03'
				)
			),
			'font' => array(
				'color' => array(
					'rgb' => '000000'
				),
				'size' => 15,
				'name' => 'Arial',
				'bold' => true
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
			)
		);
		$style_header = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array(
					'rgb' => 'ffff03'
				)
			),
			'font' => array(
				'color' => array(
					'rgb' => '000000'
				),
				'size' => 12,
				'name' => 'Arial',
				'bold' => true
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			)
		);
		$account_value_style_header = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border
			),
			'font' => array(
				'color' => array(
					'rgb' => '000000'
				),
				'size' => 12,
				'name' => 'Arial'
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
			)
		);
		$text_align_style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array(
					'rgb' => 'ffff03'
				)
			),
			'font' => array(
				'color' => array(
					'rgb' => '000000'
				),
				'size' => 12,
				'name' => 'Arial',
				'bold' => true
			)
		);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Fuel Tank Report');
		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Fuel Tank Number');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Fuel Type');
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Starting Volume');
		$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Current Balance');

		$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		
		
		$jj = 3;
		$DtaResult = $this->db->query('SELECT * FROM fuel_tanks ORDER BY id desc');
		$DtaData = $DtaResult->result();
		$outlets_dd = $this->Constant_model->getddData('outlets', 'id', 'name', 'id');
		$ft_dd = $this->Constant_model->getddData('fuel_types', 'id', 'fuel_type', 'id');
		if(!empty($DtaData))
		{
			for ($t = 0; $t < count($DtaData); ++$t) {
				$fule_type = isset($DtaData[$t]->fuel_type) ? $DtaData[$t]->fuel_type : '';
				$id = $DtaData[$t]->id;
				$fuel_tank_number = $DtaData[$t]->fuel_tank_number;
				//$fuel_type = ucfirst($ft_dd[$fule_type]);
				$outlet = $outlets_dd[$DtaData[$t]->outlet_id];
				$current_balance = $DtaData[$t]->current_balance;
				$starting_volume = $DtaData[$t]->starting_volume;
				
				if (empty($fuel_tank_number)) {
					$fuel_tank_number = '-';
				}
				if (empty($fuel_type)) {
					$fuel_type = '-';
				}

				$objPHPExcel->getActiveSheet()->setCellValue("A$jj", $fuel_tank_number);
				$objPHPExcel->getActiveSheet()->setCellValue("B$jj", $fuel_type);
				$objPHPExcel->getActiveSheet()->setCellValue("C$jj", $outlet);
				$objPHPExcel->getActiveSheet()->setCellValue("D$jj", $starting_volume);
				$objPHPExcel->getActiveSheet()->setCellValue("E$jj", $current_balance);

				//$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
				//$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
				//$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
				//$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);

				unset($fuel_tank_number);
				unset($fuel_type);
				unset($starting_volume);
				unset($current_balance);
				++$jj;
			}
		}
		unset($DtaResult);
		unset($DtaData);
		// Redirect output to a clientâ€™s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Fuel_tank_Report.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
	/*
	 * Dip Reprot
	 */
	public function getTank($id) {
		$getTank = $this->db->get_where('fuel_tanks', array('outlet_id' => $id))->result();
		$HTML = NULL;
		$HTML .= "<option value=''>-----Select-----</option>";
		foreach ($getTank as $row) {
			$HTML .= "<option value='" . $row->id . "' >" . $row->fuel_tank_number . "</option>";
		}
		echo $HTML;
	}
	
	
	public function dipreport() {

		
		$permisssion_url = 'dipreport';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(dip_datetime,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(dip_datetime,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('dip_report');
		$result = $query->result();
		$this->db->save_queries = false;
		
		$data['results'] = $result;
		$data['user_role'] = $this->session->userdata('user_role');

		$this->load->view('includes/header');
		$this->load->view('pumps/dipreport', $data);
		$this->load->view('includes/footer');
	}
	
	public function getTankFuel() {

		$id			= $this->input->get('tank');
		$tank_query = $this->db->get_where('fuel_tanks', array("id" => $id))->row();
		$current_balance = $tank_query->current_balance;

		$response = array(
			'status' => 1,
			'message' => 'saved successfully',
			'current_balance' => $current_balance
		);

		echo json_encode($response);
	}

	public function save_divreport() {
		$outlet_id = $this->input->post('outlet_id');
		$dip_balance = $this->input->post('dip_balance');
		$ref_number = $this->input->post('ref_number');
		$enter_date = $this->input->post('enter_date');
		$tank = $this->input->post('tank');
		$dip_reading = $this->input->post('dip_reading');
		$note = $this->input->post('note');
		$sys_balance = $this->input->post('sys_balance');
		$u_id = $this->session->userdata('user_id');
		$query = $this->db->get_where('fuel_tanks', array('id' => $tank))->row();
		$tm = date('Y-m-d H:i:s', time());

		$diff = $sys_balance - $dip_balance;

		$data = array(
			'outlet_id_fk' => $outlet_id,
			'tank_id_fk' => $tank,
			'dip_reading' => $dip_reading,
			'tank_fuel_dip' => $dip_balance,
			'tank_fuel_system' => $sys_balance,
			'ref_numb' => $ref_number,
			'dip_datetime' => $tm,
			'created_by' => $u_id,
			'tank_number' => $query->fuel_tank_number,
			'reading_diff' => $diff
		);

		$bool = $this->db->insert('dip_report', $data);
		if ($bool) {
			$response = array(
				'status' => 1,
				'message' => 'saved successfully'
			);
		} else {
			$response = array(
				'status' => 0,
				'message' => 'Something went wrong!'
			);
		}
		echo json_encode($response);
	}

	/*
	 * Operator Module
	 * 
	 */
	
	function list_operators() 
	{
        $permisssion_url = 'list_operators';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
    	if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['results'] = $this->pumps_model->getPumpOperatorList();
		$data['user_role'] = $this->session->userdata('user_role');
		$this->load->view('includes/header');
		$this->load->view('pumps/list_pump_operators', $data);
		$this->load->view('includes/footer');
	}

	

	function add_operator() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='list_operators')");

		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Add operators',
				'You can not add operators. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getPumper'] = $this->Constant_model->getPumper();
		
		$data['user_role'] = $this->session->userdata('user_role');
		$format_array = ci_date_format();
		$data['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$data['site_currency'] = $format_array['siteSetting_currency'];
		$data['dateformat'] = $format_array['dateformat'];
		
		$this->load->view('includes/header');
		$this->load->view('pumps/add_pump_operator', $data);
		$this->load->view('includes/footer');
	}

	function create_operator() {
		
		$this->load->model('pump_operators_model');
		
		$this->form_validation->set_rules('operator_name', 'Name', 'required');
		$this->form_validation->set_rules('operator_address', 'Address', 'required');
		$this->form_validation->set_rules('operator_mobile_number', 'Mobile Number', 'required');
		$this->form_validation->set_rules('operator_dob', 'DOB', 'required');
		$this->form_validation->set_rules('operator_cnic', 'CNIC', 'required');
		if ($this->form_validation->run() == FALSE) {
			$this->add_operator();
		} else if ($this->pump_operators_model->create_operator() == FALSE) {
			$this->add_operator();
		} else {
			redirect('pumps/list_operators');
		}
	}

	function change_operator_status($id = '0') {
		$this->load->model('pump_operators_model');
		
		$id = $this->uri->segment(3);
		if ($this->pump_operators_model->change_operator_status($id)) {
			redirect('pumps/list_operators');
		} else
			redirect('pumps/list_operators');
	}

	function edit_operator() {
		
		$this->load->model('pump_operators_model');
		
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='list_operators')");

		if (!isset($permission_data[0]->edit_right) || (isset($permission_data[0]->edit_right) && $permission_data[0]->edit_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Edit operators',
				'You can not edit operators. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getPumper'] = $this->Constant_model->getPumper();
		$format_array = ci_date_format();
		$data['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$data['site_currency'] = $format_array['siteSetting_currency'];
		$data['dateformat'] = $format_array['dateformat'];
		$id = $this->uri->segment(3);
		$data['operator_data'] = $this->pump_operators_model->edit_operator($id);
		$data['id_to_edit'] = $id;
		$data['user_role'] = $this->session->userdata('user_role');
		$sess_arr = ci_getSession_data();
		$user_outlet = $sess_arr['user_outlet'];
		$data['user_role'] = $sess_arr['user_role'];
		
		$this->load->view('includes/header');
		$this->load->view('pumps/edit_operator', $data);
		$this->load->view('includes/footer');
	}

	function update_operator() {
		
		$this->load->model('pump_operators_model');
		
		$this->form_validation->set_rules('operator_name', 'Name', 'required');
		$this->form_validation->set_rules('operator_cnic', 'CNIC', 'required');
		$this->form_validation->set_rules('operator_address', 'Address', 'required');
		$this->form_validation->set_rules('operator_dob', 'DOB', 'required');
		$this->form_validation->set_rules('operator_mobile_number', 'Mobile Number', 'required');
		if ($this->form_validation->run() == false) {
			$id = $this->uri->segment(3);
			$this->edit_operator($id);
		} else {
			$id = $this->uri->segment(3);
			if ($this->pump_operators_model->update_operator($id) == true) {
				redirect('pumps/list_operators');
			} else {
				$id = $this->uri->segment(3);
				$this->edit_operator($id);
			}
		}
	}

	function delete_operator() {
		
		$this->load->model('pump_operators_model');
		
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='list_operators')");

		if (!isset($permission_data[0]->delete_right) || (isset($permission_data[0]->delete_right) && $permission_data[0]->delete_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Delete operators',
				'You can not delete operators. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$id = $this->uri->segment(3);
		if ($this->pump_operators_model->delete_operator($id)) {
			redirect('pumps/list_operators');
		} else {
			$this->edit_operator($id);
		}
	}
	
	
	
	/*
	 * Settelment Page
	 */
	public function settlement1() {
        $permisssion_url = 'settlement_pump';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['getWarehouse'] = $this->Constant_model->getStore();
		$data['getOutlet'] = $this->Constant_model->getOutlets();
		$data['query_pump_operators'] = $this->Constant_model->getPumpOperatorAll();
		$data['getProductOtherSale'] = $this->Constant_model->getProductOtherSale();
		$data['SettlementNumber'] = $this->Constant_model->getSettleMentNumber();
		
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
		
		$default_store = $this->Pos_model->getDefaultCustomer();
		$data['totaltax'] = $default_store->tax;
		
		
		$this->load->view('includes/header');
		$this->load->view('pumps/settelment_collection1', $data);
		$this->load->view('includes/footer');
	}
	
	
//	public function settlement2() {
//        $permisssion_url = 'settlement_pump';
//		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
//                
//		if($permission->view_menu_right == 0)
//		{
//			redirect('dashboard');
//		}
//		
//		$data['getWarehouse'] = $this->Constant_model->getStore();
//		$data['getOutlet'] = $this->Constant_model->getOutlets();
//		$data['query_pump_operators'] = $this->Constant_model->getPumpOperatorAll();
//		$data['getProductOtherSale'] = $this->Constant_model->getProductOtherSale();
//		$data['SettlementNumber'] = $this->Constant_model->getSettleMentNumber();
//		
//		$loginUserId = $this->session->userdata('user_id');
//		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
//		$data['UserLoginName'] = @$loginData[0]->fullname;
//		
//		$default_store = $this->Pos_model->getDefaultCustomer();
//		$data['totaltax'] = $default_store->tax;
//		
//		$default_store = $this->Pos_model->getDefaultCustomer();
//		$data['default_customer_id'] =  $default_store->default_customer_id;
//		
//		
//		$this->load->view('includes/header');
//		$this->load->view('pumps/settelment_collection', $data);
//		$this->load->view('includes/footer');
//	}
//	
	
	public function settlement() {
        $permisssion_url = 'settlement_pump';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$allready = $this->Constant_model->getAllreadySettlement();
		if($allready->num_rows()>0)
		{
				echo "<script>alert('Please Complete imcomplate Settlement first !!');
            window.location.href='".base_url()."pumps/settlement_list'
            </script>";
		}
		$data['getWarehouse'] = $this->Constant_model->getStore();
		$data['getOutlet'] = $this->Constant_model->getOutlets();
		$data['query_pump_operators'] = $this->Constant_model->getPumpOperatorAll();
		$data['getProductOtherSale'] = $this->Constant_model->getProductOtherSale();
		$data['SettlementNumber'] = $this->Constant_model->getSettleMentNumber();
		
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
		
		$default_store = $this->Pos_model->getDefaultCustomer();
		$data['totaltax'] = $default_store->tax;
		
		$default_store = $this->Pos_model->getDefaultCustomer();
		$data['default_customer_id'] =  $default_store->default_customer_id;
		
		
		$this->load->view('includes/header');
		$this->load->view('pumps/settelment_collection', $data);
		$this->load->view('includes/footer');
	}
	
	
	public function settlement_list()
	{
		
		$permisssion_url = 'settlement_list';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getSettlement']	= $this->pumps_model->getSettlement();
		$data['getOutlet']		= $this->Constant_model->getOutlets();
		$data['getPumpers']	= $this->Constant_model->getPumpOperatorAll();
		$this->load->view('includes/header');
		$this->load->view('pumps/settelment_list', $data);
		$this->load->view('includes/footer');
	}
	
	
	function settle_view_order_detail()
	{
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		
		$settle_id = $this->input->get('id');
		$OrderSettlement		= $this->pumps_model->ViewDetailMainOrder($settle_id);
		$data['getItemOrder'] = $this->Pos_model->getOrderItemPrint($OrderSettlement->id);
        $data['getPaymentOrder'] = $this->Pos_model->getOrderPaymentPrint($OrderSettlement->id);
		$data['getmainOrder'] = $OrderSettlement;
		$data['order_id'] = $OrderSettlement->id;
		$this->load->view('includes/header');
		$this->load->view('view_order_detail_settlement', $data);
		$this->load->view('includes/footer');
	}
	
	
	public function getSingleProductData()
	{
		$product_code = $this->input->post('product_code');
		$result = $this->Constant_model->getProductPrice($product_code);
		$json['retail_price'] = $result->retail_price;
		echo json_encode($json);
	}
	
	public function SubmitDataDetailItemCustomer()
	{
		$sales_payment_id	= $this->input->post('sales_payment_id');
		$settlement_no		= $this->input->post('settlement_no');
		$customer_id		= $this->input->post('customer_id');
		if(!empty($this->input->post('return')))
		{
			foreach ($this->input->post('return') as $value)
			{
				$array = array(
					'customer_id'	  => $customer_id,
					'settlement_id'	  => $settlement_no,
					'sale_payment_id' => $sales_payment_id,
					'product_code'	  => $value['product_code'],
					'unit_price'	  => $value['unit_price'],
					'qty'			  => $value['qty'],
					'total_amount'	  => $value['total_amount'],
					'created_by'	  => $this->session->userdata('user_id'),
					'created_date'	  => date('Y-m-d H:i:s'),
					'status' => 0,
				);
				$this->Constant_model->insertDataReturnLastId('customer_more_details_payment',$array);
			}
			$json['success'] = true;
		}
		else
		{
			$json['error'] = true;
		}
		echo json_encode($json);
	}
	
	public function deleted_settlement()
	{
		
		$permisssion_url = 'deleted_settlement';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['getDeletedSettlement']	= $this->pumps_model->getDeletedSettlement();
		$data['getOutlet']		= $this->Constant_model->getOutlets();
		$data['getPumpers']	= $this->Constant_model->getPumpOperatorAll();
		$this->load->view('includes/header');
		$this->load->view('pumps/deleted_settlement', $data);
		$this->load->view('includes/footer');
	}
	
	public function refreshpumps() {
		$pumpData = $this->db->get_where('pumps', array(
			'checkk' => 0
		))->result();
		foreach ($pumpData as $value) 
		{
			$temp_meter_reading = $value->temp_meter_reading;
			$this->db->query("UPDATE pumps SET last_meter_reading = '$temp_meter_reading' , checkk = 1   WHERE checkk = 0 LIMIT 1");
		}
		
		$testing_pumpData = $this->db->get_where('pumps', array(
			'testing' => 0
		))->result();
		foreach ($testing_pumpData as $value_test) 
		{
			$teting_temp_meter_reading = $value_test->temp_meter_reading;
			$this->db->query("UPDATE pumps SET last_meter_reading = '".$teting_temp_meter_reading."' , testing = 1   WHERE testing = 0 LIMIT 1");
		}
	}
	
	public function getPumpWarehouse($id) {
		$warehous = '';
		$product = '';
		
		$default_store = $this->Pos_model->getDefaultCustomer();
		$default_store_id = $default_store->default_store_id;
		
		$getOutletWisePaymentMethod = $this->Constant_model->getOutletWisePaymentMethod($id);
		
		$warehouse_data = $this->Constant_model->getOutletWareHouse($id);
		$warehous .= "<option value=''>Select Warehouse</option>";
		foreach ($warehouse_data as $value)
		{
			$selected = '';
			if($default_store_id == $value->w_id)
			{
				$selected = 'selected'; 
			}
			
			$warehous .= "<option ".$selected." value='" . $value->ow_id . "' >" . $value->s_name . "</option>";
		}
		
		$product .= "<option value=''>Select Item</option>";
		$productdata = $this->Gold_module->getProductOutlet($id);
		foreach ($productdata as $pro)
		{
			$product .= "<option value='".$pro->id."' >" . $pro->name . " [".$pro->code."]</option>";
		}
		
		$query_get_pump = $this->db->get_where('pumps', array(
					'outlet_id' => $id,
					'checkk' => 1
				))->result();

		$HTML = NULL;
		$HTML1 = NULL;
		$d = array();
		$HTML .= "<option value=''>-----Select-----</option>";
		foreach ($query_get_pump as $row) {
			$HTML .= "<option value='" . $row->id . "' >" . $row->pump_name . "</option>";
		}
		
		
		$testing_query_get_pump = $this->db->get_where('pumps', array(
					'outlet_id' => $id,
					'testing' => 1
				))->result();

		$testing = "";
		

		$testing .= "<option value=''>-----Select-----</option>";
		foreach ($testing_query_get_pump as $testing_row) {
			$testing .= "<option value='" . $testing_row->id . "' >" . $testing_row->pump_name . "</option>";
		}
		
		$payment = '';
		$payment = '<option value="">Select Payment Method</option>';
		
		foreach ($getOutletWisePaymentMethod as $payment_outlet) {
			$payment .= "<option value='".$payment_outlet->id."' >".$payment_outlet->name."</option>";
		}
		
		$json['payment']	= $payment;
		$json['pump']		= $HTML;
		$json['testing']	= $testing;
		$json['store']		= $warehous;
		$json['product']	= $product;
		echo json_encode($json);
	}
	
	
	
	
	public function getPumpWarehouseTemporary($id) {
		$warehous = '';
		$product = '';
		
		$settelment_no = $this->input->post('settelment_no');
		
		
		$default_store = $this->Pos_model->getDefaultCustomer();
		$default_store_id = $default_store->default_store_id;
		
		$getOutletWisePaymentMethod = $this->Constant_model->getOutletWisePaymentMethod($id);
		
		$warehouse_data = $this->Constant_model->getOutletWareHouse($id);
		$warehous .= "<option value=''>Select Warehouse</option>";
		foreach ($warehouse_data as $value)
		{
			$selected = '';
			if($default_store_id == $value->w_id)
			{
				$selected = 'selected'; 
			}
			
			$warehous .= "<option ".$selected." value='" . $value->ow_id . "' >" . $value->s_name . "</option>";
		}
		
		$product .= "<option value=''>Select Item</option>";
		$productdata = $this->Gold_module->getProductOutlet($id);
		foreach ($productdata as $pro)
		{
			$product .= "<option value='".$pro->id."' >" . $pro->name . " [".$pro->code."]</option>";
		}
		
		$query_get_pump = $this->db->get_where('pumps', array(
					'outlet_id' => $id,
					'checkk' => 1
				))->result();

		$HTML = NULL;
		$HTML1 = NULL;
		$d = array();
		$HTML .= "<option value=''>-----Select-----</option>";
		foreach ($query_get_pump as $row) {
			$pumpSettlementData = $this->Constant_model->getpumpSettlementData($settelment_no,$row->id);
			if($pumpSettlementData->num_rows() == 0)
			{
				$HTML .= "<option value='" . $row->id . "' >" . $row->pump_name . "</option>";
			}
		}
		
		
		$testing_query_get_pump = $this->db->get_where('pumps', array(
					'outlet_id' => $id,
					'testing' => 1
				))->result();

		$testing = "";
		

		$testing .= "<option value=''>-----Select-----</option>";
		foreach ($testing_query_get_pump as $testing_row) {
				$testing .= "<option value='" . $testing_row->id . "' >" . $testing_row->pump_name . "</option>";
		}
		
		$payment = '';
		$payment = '<option value="">Select Payment Method</option>';
		
		foreach ($getOutletWisePaymentMethod as $payment_outlet) {
			$payment .= "<option value='".$payment_outlet->id."' >".$payment_outlet->name."</option>";
		}
		
		$json['payment']	= $payment;
		$json['pump']		= $HTML;
		$json['testing']	= $testing;
		$json['store']		= $warehous;
		$json['product']	= $product;
		echo json_encode($json);
	}
	
	public function getWarehouseandOuletWiseProduct()
	{
		$product = '';
		$outlet_id = $this->input->post('outlet_id');
		$warehouse_id = $this->input->post('ware_id');
		$warehouse_data = $this->Constant_model->getWarehouseandOuletWiseProduct($outlet_id,$warehouse_id);
		$product .= "<option value=''>Select Item</option>";
		foreach ($warehouse_data as $pro)
		{
			$product .= "<option value='".$pro->product_id."'>".$pro->prdocuname." [".$pro->product_code."]</option>";
		}
		$json['product'] = $product;
		$json['qty'] = 0;
		echo json_encode($json);
	}
	
	
	
	
	function getPumperinfo() {
		extract($_POST);
		$daily_collection		= $this->pumps_model->changeBalanceCollection($pumper_name);
		$concate_collection_id	= !empty($daily_collection->concate_settle_id)?$daily_collection->concate_settle_id:'';
		$daily_totalamount		= !empty($daily_collection->totalamount)?$daily_collection->totalamount:0;
		
		$getPumpData = $this->Constant_model->getDataOneColumn('pump_operators', 'id', $pumper_name);
		$operaterName = '';
		$short_amount = '';
		$excess_amount = 0;

		if (count($getPumpData) == 1) {
			$operaterName = $getPumpData[0]->operator_name;
			$short_amount = $getPumpData[0]->short_amount;
			$excess_amount = $getPumpData[0]->excess_amount;
		}
		$arr = array(
			'status' => 1,
			'operaterName'			=> $operaterName,
			'short_amount'			=> $short_amount,
			'excess_amount'			=> $excess_amount,
			'daily_collection'		=> $daily_totalamount,
			'concate_collection_id'	=> $concate_collection_id,
		);
		echo json_encode($arr);
	}
	
	public function getProductDetailWarehouseWise() {
		$pid = $this->input->get('pid');
		$outlet_id = $this->input->get('outlet_id');
		$outlet_warehouse_id = $this->input->get('outlet_warehouse_id');
		$query_product = $this->db->get_where('products', array(
					'id' => $pid
				))->row();
		$pcode		  = $query_product->code;
		$prod_name	  = $query_product->name;
		$category	  = $query_product->category;
		$retailPrice  = $query_product->retail_price;
		$qty = 0;
		
		$ckInvData = $this->Constant_model->getDataThreeColumnInventory($pcode,$outlet_id,$outlet_warehouse_id);
		if (count($ckInvData) > 0) {
			$qty = $ckInvData[0]->qty;
			$response = array(
				'qty' => $qty,
				'category' => $category,
				'retailPrice' => $retailPrice
			);
		}
		else
		{
			$response = array(
				'qty' => $qty,
				'category' => $category,
				'retailPrice' => $retailPrice
			);
		}
			
		echo json_encode($response);
	}
	
	public function checkOthersalesDetail() {
		$items = $this->input->get('items');
		$qty = $this->input->get('qty');
		$outlets = $this->input->get('outlets');
		$outlet_warehouse_id = $this->input->get('outlet_warehouse_id');

		$ckPcodeResult = $this->db->query("SELECT * FROM products WHERE id=$items ");
		$ckPcodeRows = $ckPcodeResult->num_rows();
		if ($ckPcodeRows == 0) {
			$response = array(
				'errorMsg' => 'failure',
				'name' => ''
			);
		} else {

			$ckPcodeDataresult = $ckPcodeResult->result();
			$ppcode = $ckPcodeDataresult[0]->code;
			$ppname = $ckPcodeDataresult[0]->name;
			$ppretail_price = $ckPcodeDataresult[0]->retail_price;
			$get_Inventry = $this->db->query("SELECT * FROM inventory WHERE product_code= '".$ppcode."' AND outlet_id = '".$outlets."' AND ow_id = '".$outlet_warehouse_id."' and type = '0' ")->row();
			$getQty = $get_Inventry->qty;
			$totalQty = $getQty - $qty;

			$response = array(
				'errorMsg' => 'success',
				'code' => $ppcode,
				'name' => $ppname,
				'retail_price' => $ppretail_price,
				'getStock' => $totalQty
			);
		}
		echo json_encode($response);
	}
	
	public function checkOthersalesDetail1() {
		$items = $this->input->get('items');
		$qty = $this->input->get('qty');
		$outlets = $this->input->get('outlets');
		$outlet_warehouse_id = $this->input->get('outlet_warehouse_id');
		$tax = $this->input->get('tax');
		
		$pumper_name		= $this->input->get('pumper_name');
		$ShiftStartingTime	= $this->input->get('ShiftStartingTime');
		$ShiftEndTime		= $this->input->get('ShiftEndTime');
		$settelment_no		= $this->input->get('settelment_no');
		$transaction_date	= $this->input->get('transaction_date');
		$discount			= !empty($this->input->get('discount'))?$this->input->get('discount'):0;

		$ckPcodeResult = $this->db->query("SELECT * FROM products WHERE id=$items ");
		$ckPcodeRows = $ckPcodeResult->num_rows();
		if ($ckPcodeRows == 0) {
			$response = array(
				'errorMsg' => 'failure',
				'name' => ''
			);
		} else {
			
			$ckPcodeDataresult = $ckPcodeResult->result();
			$ppcode = $ckPcodeDataresult[0]->code;
			$ppname = $ckPcodeDataresult[0]->name;
			$ppretail_price = $this->input->get('retailPrice');
			$purchase_price = $ckPcodeDataresult[0]->purchase_price;
			$get_Inventry = $this->db->query("SELECT * FROM inventory WHERE product_code= '".$ppcode."' AND outlet_id = '".$outlets."' AND ow_id = '".$outlet_warehouse_id."' and type = '0' ")->row();
			$getQty = $get_Inventry->qty;
			$totalQty = $getQty - $qty;

			
			
			$resultsettle = $this->Constant_model->CheckSettlementNumber($settelment_no);
			if($resultsettle->num_rows() > 0)
			{

				$update_settlement =  array(
					'outlet_id'			=> $outlets,
					'transaction_date'  => $transaction_date,
					'pumper_id'			=> $pumper_name,
					'shift_start_time'	=> $ShiftStartingTime,
					'shift_end_time'	=> $ShiftEndTime,
					'status'			=> 2,
				);

				$this->Constant_model->UpdateSettlementNumber($update_settlement,$settelment_no);

			}
			else
			{
				$insert_settlement =  array(
					'settlement_no'		=> $settelment_no,
					'transaction_date'  => $transaction_date,
					'outlet_id'			=> $outlets,
					'pumper_id'			=> $pumper_name,
					'shift_start_time'	=> $ShiftStartingTime,
					'shift_end_time'	=> $ShiftEndTime,
					'created_at'		=> date('Y-m-d H:i:s'),
					'status'			=> 2,
					);

				$this->Constant_model->insertDataReturnLastId('settlement',$insert_settlement);
			}
			
			$grandtotal = $ppretail_price * $qty;
			$calculateTax = $tax / 100 * $grandtotal;
			$total_with_tax = $grandtotal + $calculateTax;
			
			$calculateDis = $discount / 100 * $total_with_tax;
			$payable_total = $total_with_tax - $calculateDis;

			
			$temporary_item = array(
				'settlement_id' => $settelment_no, 
				'product_code'	=> $ppcode, 
				'qty'			=> $qty, 
				'tax'			=> $tax, 
				'tax_amount'	=> $calculateTax, 
				'discount'		=> $discount, 
				'discount_amount' => $calculateDis, 
				'cost'			=> $purchase_price, 
				'price'			=> $ppretail_price, 
				'grandtotal'	=> $payable_total, 
				'paid	'		=> $payable_total, 
				'ow_id'			=> $outlet_warehouse_id, 
				'type'			=> 0, 
			);

			$lastid = $this->Constant_model->insertDataReturnLastId('temporary_order_items', $temporary_item);
			
			
			$response = array(
				'errorMsg'	=> 'success',
				'code'		=> $ppcode,
				'name'		=> $ppname,
				'retail_price' => $ppretail_price,
				'getStock'	=> $totalQty,
				'temporary_item_id' => $lastid
			);
		}
		echo json_encode($response);
	}
	
	
	function Delete_Temporary_Payment()
	{
		$temporary_id = $this->input->post('temporary_id');
		$this->Constant_model->Delete_Temporary_Payment($temporary_id);
		$json['success'] = true;
		echo json_encode($json);
	}
	
	function get_payment_name() {
		
		extract($_POST);
		$array_tempory_payment =  array(
			'settlement_no'		=> $settelment_no,
			'payment_type'		=> $id,
			'amount'			=> $paid,
			'cheque_number'		=> $cheque,
			'card_numb'			=> $card_numb,
			'addi_card_numb'	=> $addi_card_numb,
			'voucher_number'	=> $voucher,
			'bank'				=> $bank,
			'cheque_date'		=> date('Y-m-d', strtotime($cheque_date)),
			'customer_id'		=> $customer,
			'pumper_id'			=> $pumper_name,
			'default_bulk_status'=> $default_bulk_status,
			'credit_debit_bulk_status'=> $ValueDebitCreditBulk,
			'note'				=> $customer_note,
			'created_date'			=> date('Y-m-d H:i:s'),
		);
		
		$lastid = $this->Constant_model->insertDataReturnLastId('temporary_payment_method',$array_tempory_payment);
		
		
		$getPayMethodData = $this->Constant_model->getDataOneColumn('payment_method', 'id', $id);
		$getCustomerData = $this->Constant_model->getDataOneColumn('customers', 'id', $customer);
		$getPumpData = $this->Constant_model->getDataOneColumn('pump_operators', 'id', $pumper_name);
		$operaterName = '';
		$creditcolor = '';
		$customerName = '';
		if (count($getPumpData) == 1) {
			$operaterName = $getPumpData[0]->operator_name;
		}
		if (count($getCustomerData) == 1) {
			$getOutstanding = $this->pumps_model->getCustomerOutstanding($customer);
			$getCreditColor = $this->Constant_model->getCreditColor();
		
			$customerName	= $getCustomerData[0]->fullname;
			$credit_amount  = $getCustomerData[0]->credit_amount;
			if($credit_amount != 0 && $getOutstanding != 0)
			{
				$percenttage = ($getOutstanding * 100) / $credit_amount;
				foreach ($getCreditColor as $color)
				{
					if($color->to > $percenttage && $color->from < $percenttage )
					{ 
						$creditcolor ='<button class="btn" type="button" style="background: #'.$color->color.'">&nbsp;</button>';

					}
					else if($percenttage > 100)
					{ 
						$creditcolor = '<button class="btn" type="button" style="background: #cc0000">&nbsp;</button>';
						break;
					}
				}
			}
		}
		if (count($getPayMethodData) == 1) {
			$payMethod_name = $getPayMethodData[0]->name;
			$arr = array(
				'status' => 1,
				'data' => $payMethod_name,
				'paidAmount' => $paid,
				'customerName' => $customerName,
				'operaterName' => $operaterName,
				'temporary_id' => $lastid,
				'outstanding' => !empty($getOutstanding)?number_format($getOutstanding,2):'',
				'credit_amount' => !empty($credit_amount)?number_format($credit_amount,2):'',
				'creditcolor' => !empty($creditcolor)?$creditcolor:'',
			);
			echo json_encode($arr);
		}
	}
	
//	public function save_settlement_temporary()
//	{
//		$totalqty			= 0;
//		$user_id			= $this->session->userdata('user_id');
//		$today				= date('Y-m-d H:i:s', time());
//		$settlement_no		= $this->input->post('settlement_no');
//		$outlet_id			= $this->input->post('outlet_id');
//		$CurrentShort		= $this->input->post('CurrentShort');
//		$ExcessAmount		= $this->input->post('ExcessAmount');
//		$customer_id		= $this->input->post('customer_id');
//		$totalamount		= $this->input->post('totalamount');
//		$pumper_id			= $this->input->post('pumper_name');
//		$tpaid				= $this->input->post('tpaid');
//		$note				= $this->input->post('noteinfo');
//		$payment_method		= $this->input->post('payment');
//		$fuelsale			= $this->input->post('fuelsale');
//		$othersale			= $this->input->post('othersale');
//		$shift_start_time	= $this->input->post('Startingtimepicker');
//		$shift_end_time		= $this->input->post('Endtimepicker');
//		
//		$current_orders = $this->db->from('orders')->where("outlet_id=" . $outlet_id)->count_all_results(); // Produces an integer, like 25
//		$current_orders++; 
//		
//		$outletdata = $this->Constant_model->GetOutletDetail($outlet_id);
//	
//		$resultsettle = $this->Constant_model->CheckSettlementNumber($settlement_no);
//		if($resultsettle->num_rows() > 0)
//		{
//			$update_settlement =  array(
//				'outlet_id'			=> $outlet_id,
//				'pumper_id'			=> $pumper_id,
//				'total_amount'		=> $totalamount,
//				'shift_start_time'	=> $shift_start_time,
//				'shift_end_time'	=> $shift_end_time,
//				'status'			=> 2,
//			);
//
//			$this->Constant_model->UpdateSettlementNumber($update_settlement,$settlement_no);
//		}
//		else
//		{
//			$insert_settlement =  array(
//				'settlement_no'		=> $settelment_no,
//				'outlet_id'			=> $outlet_id,
//				'pumper_id'			=> $pumper_id,
//				'total_amount'		=> $totalamount,
//				'shift_start_time'	=> $shift_start_time,
//				'shift_end_time'	=> $shift_end_time,
//				'created_at'		=> date('Y-m-d H:i:s'),
//				'status'			=> 2,
//			);
//
//			$this->Constant_model->insertDataReturnLastId('settlement',$insert_settlement);
//		}
//			
//		$this->Constant_model->RemoveTemporaryItem($settlement_no);
//		
//		$orderdata = array('outlet_id' => $outlet_id,
//			'customer_id'			=> $this->input->post('customer_id'),
//			'pump_operators_id'		=> $pumper_id,
//			'outlet_name'			=> $outletdata->name,
//			"outlet_address"		=> $outletdata->address,
//			"outlet_contact"		=> $outletdata->contact_number,
//			"outlet_receipt_footer" => $outletdata->receipt_footer,
//			'settlement_no'			=> $settlement_no,
//			'created_by'			=> $user_id,
//			'tpaid'					=> $tpaid,
//			'totalamount'			=> $totalamount,
//			'total_items'			=> $this->input->post('row_count') + $this->input->post('row_count_hidden_fuel'),
//			'created_at'			=> $today,
//			'sid'					=> $current_orders,
//			"status"				=> 2,	
//		);
//		
//		$order_id = $this->Constant_model->insertDataReturnLastId('orders', $orderdata);
//		
//		if(!empty($fuelsale))
//		{
//			foreach ($fuelsale as $sale)
//			{
//				$totalqty = $totalqty + $sale['qty'];
//				$single_product_data = $this->Constant_model->getSingleProduct($sale['codee']);
//				$ins_order_item_data = array(
//					'product_id'		=> $sale['codee'],
//					'order_id'			=> $order_id,
//					'product_code'		=> $single_product_data->code,
//					'product_name'		=> $single_product_data->name,
//					'product_category'	=> $single_product_data->category,
//					'cost'				=> $single_product_data->purchase_price,
//					'price'				=> $sale['retail_price'],
//					'qty'				=> $sale['qty'],
//					'paid'				=> $sale['gtotal'],
//					'subtotal'			=> $sale['gtotal'],
//					'grandtotal'		=> $sale['gtotal'],
//					'pump_operators_id' => $pumper_id,
//					'pump_id'			=> $sale['pump_no'],
//					'ow_id'				=> $sale['fuel_tank_ids'],
//					'type'				=> '1',
//					'status'			=> '2',
//				);
//				$this->Constant_model->insertData('order_items', $ins_order_item_data);
//				
//				
//				$pumpData = $this->Constant_model->getPumpSignleRecord($sale['pump_no']);
//				$last_meter_reading = $pumpData->last_meter_reading;
//				
//				$update_metter = array(
//					'temp_meter_reading' => $last_meter_reading,
//					'checkk' => 1,
//				);
//				$this->Constant_model->UpdatePumpSignleRecord($update_metter,$sale['pump_no']);
//				
//				
//				$pump_reading = array(
//						'outlet_id'		=> $outlet_id,
//						'settlement_id'	=> $settlement_no,
//						'pump_id'		=> $sale['pump_no'],
//						'product_id'	=> $sale['codee'],
//						'start_meter'	=> $sale['start_meter'],
//						'end_meter'		=> $sale['end_meter'],
//						'sold_qty'		=> $sale['qty'],
//						'amount'		=> $sale['gtotal'],
//						'testing_qty'	=> $sale['testing_qty'],
//						'created_at'	=> $today,
//						'status'		=> 2,
//					);
//				
//				$this->Constant_model->insertData('pump_reading', $pump_reading);
//				
//				if($sale['testing_qty'] != "" && $sale['testing_qty'] != 0)
//				{
//					$testing_grandtotal = $sale['retail_price'] * $sale['testing_qty'];
//					$ins_order_testing_pump = array(
//						'pump_id'			=> $sale['pump_no'],
//						'outlet_id'			=> $outlet_id,
//						'product_id'		=> $sale['codee'],
//						'settlement_id'		=> $settlement_no,
//						'order_id'			=> $order_id,
//						'product_code'		=> $single_product_data->code,
//						'price'				=> $sale['retail_price'],
//						'testing_qty'		=> $sale['testing_qty'],
//						'grand_total'		=> $testing_grandtotal,
//						'pump_operators_id' => $pumper_id,
//						'created_by'		=> $user_id,
//						'created_at'		=> $today,
//						'status'			=> 2,
//					);
//					$this->Constant_model->insertData('pump_testing', $ins_order_testing_pump);
//				}
//				
//			
//					$Fuel_tank_Query = $this->db->get_where("fuel_tanks",array('id'=>$sale['fuel_tank_ids']))->row();
//					$select_current_balance = $Fuel_tank_Query->current_balance;
//					$now_balance = $select_current_balance - $sale['qty'];
//					$total_tank_balance = $select_current_balance + $sale['qty'];
//					$data_tank = array("current_balance"=>$now_balance);
//
//					$this->db->update("fuel_tanks",$data_tank , array("id" => $sale['fuel_tank_ids']));
//
//					$Product_Query = $this->db->get_where('products',array("id"=>$sale['codee']))->row();
//					$select_pcode = $Product_Query->code;
//
//					$Inventry_Query		= $this->db->get_where('inventory',array("product_code"=>$select_pcode,'outlet_id'=>$outlet_id,'ow_id' =>$sale['fuel_tank_ids'], 'type' => '1'))->row();
//					$select_inventry_id = $Inventry_Query->id;
//					$select_qty			= $Inventry_Query->qty;
//
//					$now_qty		= $select_qty - $sale['qty'];
//					$data_inventory = array("qty" => $now_qty);
//
//					$this->db->update("inventory",$data_inventory,array("id"=>$select_inventry_id));
//					
//					$new_tank_reading = array(
//						'tank_id'			=> $sale['fuel_tank_ids'],
//						'settlement_id'		=> $settlement_no,
//						'outlet_id'			=> $outlet_id,
//						'total_tank_balance'=> $total_tank_balance,
//						'available_tank_qty'=> $now_balance,
//						'tank_qty'			=> $sale['qty'],
//						'sold_qty'			=> $sale['qty'],
//						'created_by'		=> $this->session->userdata('user_id'),
//						'created_date'      => date('Y-m-d H:i:s'),
//						'status'			=> 2
//					);
//					
//					$this->Constant_model->insertDataReturnLastId('fuel_tanks_reading', $new_tank_reading);
//				
//				if(!empty($pumper_id))
//				{
//					$pumper_Query = $this->db->get_where('pump_operators', array(
//								'id' => $pumper_id
//					))->row();
//					
//					$select_commisiion = $pumper_Query->commission_ap;
//					$gtotal_commesion = $select_commisiion / 100 * $sale['gtotal'];
//					
//					$data = array(
//						'product_id'	=>  $sale['codee'],
//						'outlet_id'		=>	$outlet_id,
//						'pump_id'		=>	$sale['pump_no'],
//						'qty'			=>  $sale['qty'],
//						'fuel_tank_ids' =>  $sale['fuel_tank_ids'],
//						'gtotal'		=>	$gtotal_commesion,
//						'sale_amount'	=>  $sale['gtotal'],
//						'pumper_id'		=>  $pumper_id,
//						'customer_id'	=>	$customer_id,
//						'settlement_receipt_no'	=>	$settlement_no,
//						'created_by'	=>	$user_id,
//						'orderDatetime' =>	date("Y-m-d H:i:s")
//					);
//					$this->pumps_model->add_to_pumper_report_temporary($data);
//				}
//			}
//		}
//		
//		
//		if(!empty($othersale))
//		{
//			foreach ($othersale as $other)
//			{
//				$single_product_data = $this->Constant_model->getSingleProduct($other['codeone']);
//				$totalqty = $totalqty + $other['qtyone'];
//				$ins_order_item_data = array(
//					'product_id'		=> $other['codeone'],
//					'order_id'			=> $order_id,
//					'product_code'		=> $single_product_data->code,
//					'product_name'		=> $single_product_data->name,
//					'product_category'	=> $single_product_data->category,
//					'cost'				=> $single_product_data->purchase_price,
//					'price'				=> $other['retail_priceone'],
//					'qty'				=> $other['qtyone'],
//					'paid'				=> $other['gtotal1one'],
//					'subtotal'			=> $other['gtotal1one'],
//					'grandtotal'		=> $other['gtotal1one'],
//					'tax'				=> $other['taxone'],
//					'discount'			=> $other['discountone'],
//					'discount_amount'	=> $other['discountamountone'],
//					'tax_amount'		=> $other['calculateTaxone'],
//					'ow_id'				=> $other['outlet_warehouse_id_data'],
//					'type'				=> '0',
//					'status'            => '2',
//				);
//				
//				
//				$getStore = $this->Constant_model->OutletWarehouseget($other['outlet_warehouse_id_data']);
//				$oldstore = $getStore->s_stock;
//				$newstoreQty = $getStore->s_stock - $other['qtyone'];
//				$data_storeupdate = array(
//					's_stock' => $newstoreQty,
//					's_stock_upated' => $newstoreQty,
//				);
//				$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);
//				
//				$this->Constant_model->InventoryUpdateOtherSales($single_product_data->code,$outlet_id,$other['outlet_warehouse_id_data'],$other['qtyone']);
//				$this->Constant_model->insertData('order_items', $ins_order_item_data);
//			}
//		}
//		
//		$finalResult = 	$this->db->query("UPDATE orders SET total_items = '".$totalqty."' WHERE id = '".$order_id."' ");
//		if($finalResult)
//		{
//			$response = array(
//				'status' => 1,
//				'message' => 'saved successfully',
//				'id' => $order_id
//			);
//		}	
//		echo json_encode($response);
//	}
//	
	
	
	public function SavePayment_Settlement()
	{
		$settle_id = $this->input->get('settleid');
		$data['getSettlement']	= $this->pumps_model->SingleSettlementNumber($settle_id);
		if($data['getSettlement']->status == 0)
		{
			redirect('pumps/settlement_list');
		}
				
		$data['getItemTemporary']	= $this->pumps_model->getItemTemparary($settle_id);
		

		
//		$data['OrderSettlement']= $this->pumps_model->getOrderSettlementTempory($settle_id);
		
//		$data['PumpReading']	= $this->pumps_model->getPumpReading($settle_id);
		
		$data['getWarehouse'] = $this->Constant_model->getStore();
		$data['getOutlet'] = $this->Constant_model->getOutlets();
		$data['query_pump_operators'] = $this->Constant_model->getPumpOperatorAll();
		$data['getProductOtherSale'] = $this->Constant_model->getProductOtherSale();
		
//		$data['SettlementNumber'] = $this->Constant_model->getSettleMentNumber();
		
		$data['getPaymentTemporyData'] = $this->Constant_model->getPaymentTemporyData($settle_id);
		$data['getCreditColor'] = $this->Constant_model->getCreditColor();
		
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
		
		$default_store = $this->Pos_model->getDefaultCustomer();
		$data['default_customer_id'] =  $default_store->default_customer_id;
		$data['totaltax']			 = $default_store->tax;
		
		$this->load->view('includes/header');
		$this->load->view('pumps/settelment_temporary', $data);
		$this->load->view('includes/footer');
	}
	

	
	
	
	
	
	
	
	
//	public function save_payment_settlement_temporary()
//	{
//		
//		$today				= date('Y-m-d H:i:s', time());
//		$user_id			= $this->session->userdata('user_id');
//		$settlement_no		= $this->input->post('settlement_no');
//		$outlet_id			= $this->input->post('outlet_id');
//		$CurrentShort		= $this->input->post('CurrentShort');
//		$ExcessAmount		= $this->input->post('ExcessAmount');
//		$totalamount		= $this->input->post('totalamount');
//		$customer_id		= $this->input->post('customer_id');
//		$pumper_id			= $this->input->post('pumper_name');
//		$tpaid				= $this->input->post('tpaid');
//		$payment_method		= $this->input->post('payment');
//		
//		$getOrderData = $this->Constant_model->getOrderDataSettlement($settlement_no);
//		$order_id  = $getOrderData->id;
//				
//		$outletdata = $this->Constant_model->GetOutletDetail($outlet_id);
//		if(!empty($this->input->post('concate_collection_id')))
//		{
//			$explode_collection = explode(",",trim($this->input->post('concate_collection_id')));
//			foreach ($explode_collection as $coll)
//			{
//				$this->db->set('settlement_id',$settlement_no);
//				$this->db->set('settlement_date',date('Y-m-d H:i:s'));
//				$this->db->where('id',  rtrim($coll));
//				$this->db->update('daily_collection');
//			}
//		}
//		
//		if(!empty($payment_method))
//		{
//			foreach ($payment_method as $value) {
//					$old_payment = $value['deleteoldPayment'];
//					$this->Constant_model->Delete_Temporary_Payment($old_payment);
//					
//					$pay_query = $this->Constant_model->getPaymentIDName($value['paid_by']);
//					$vt_status = '';
//					$short_amount = 0;
//					$excess_amount = 0;
//					$customer = $value['customer'];
//					
//					if ($pay_query->name == 'Debit / Credit Sales' || $pay_query->name == 'Vouchers') 
//					{ 
//						$vt_status = '0';
//					} 
//					else
//					{ 
//						$vt_status = '1';
//					}
//					$paid_amt = $value['paid'];
//
//					
//					if ($pay_query->name == 'Deposit') {
//						$this->db->query("UPDATE customers set deposit = deposit-$paid_amt WHERE id = '".$customer."' ");
//					}
//					
//
//					$percenCustomer = 0;
//					if ($pay_query->name == 'Shortage Account') {
//						$getpumpData = $this->Constant_model->getDataOneColumn('pump_operators', 'id', $pumper_id);
//						if (count($getpumpData) == 1) {
//							$customer = $getpumpData[0]->id;
//							$Customer_fullname = $getpumpData[0]->operator_name . "[PO]";
//							$Customer_mobile = $getpumpData[0]->operator_mobile_number . "[PO]";
//							$short_amount = $getpumpData[0]->short_amount;
//						}
//					}
//					else if ($pay_query->name == 'Excess') {
//						$getpumpDataexcee = $this->Constant_model->getDataOneColumn('pump_operators', 'id', $pumper_id);
//
//						$customer = $getpumpDataexcee[0]->id;
//						$Customer_fullname = $getpumpDataexcee[0]->operator_name . "[PO]";
//						$Customer_mobile = $getpumpDataexcee[0]->operator_mobile_number . "[PO]";
//						$excess_amount = $getpumpDataexcee[0]->excess_amount;
//					}
//					else {
//						$getCustomerData = $this->Constant_model->getDataOneColumn('customers', 'id', $customer);
//						if (count($getCustomerData) == 1) {
//							$Customer_fullname  = $getCustomerData[0]->fullname;
//							$Customer_email		= $getCustomerData[0]->email;
//							$Customer_mobile	= $getCustomerData[0]->mobile;
//						}
//						//customer percentage
//						$siteDtaData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
//						$new_settings = $siteDtaData[0]->new_settings;
//						$new_settings_array = json_decode($new_settings, true);
//						$is_point = (array_key_exists('is_point', $new_settings_array)) ? $new_settings_array['is_point'] : '';
//						$point_percentage = (array_key_exists('point_percentage', $new_settings_array)) ? $new_settings_array['point_percentage'] : '';
//						if ($is_point == "yes") {
//							$percenCustomer = $point_percentage / 100 * $paid_amt;
//						} else {
//							$percenCustomer = 0;
//						}
//					}
//			
//					if ($pay_query->name == 'Shortage Account' || $pay_query->name == 'Vouchers' || $pay_query->name == 'Debit / Credit Sales') {
//						$paid_amt_string = 'unpaid_amt';
//					}
//					else
//					{
//						$paid_amt_string = 'paid_amt';
//					}
//					
//					$order_payment = array(
//						'order_id' => $order_id,
//						'payment_method' => $value['paid_by'],
//						'payment_method_name' => $pay_query->name,
//						$paid_amt_string => $value['paid'],
//						'subtotal' => $value['paid'],
//						'grandtotal' => $value['paid'],
//						'created_user_id' => $user_id,
//						'updated_user_id' => $user_id,
//						'ordered_datetime' => $today,
//						'created_datetime' => $today,
//						'updated_datetime' => $today,
//						'outlet_id' => $outlet_id,
//						'pump_operators_id' => $pumper_id,
//						'outlet_name' => $outletdata->name,
//						"outlet_address" => $outletdata->address,
//						"outlet_contact" => $outletdata->contact_number,
//						"outlet_receipt_footer" => $outletdata->receipt_footer,
//						'cheque_number' => $value['cheque'],
//						'voucher_number' => $value['voucher'],
//						"card_number" => $value['addi_card_numb'],
//						"gift_card" => $value['card_numb'],
//						'customer_note' => $value['customer_note'],
//						"bank" => $value['bank'],
//						"cheque_date" => date('Y-m-d', strtotime($value['cheque_date'])),
//						"customer_id" => !empty($customer)?$customer:'',
//						"customer_name" => !empty($Customer_fullname)?$Customer_fullname:'',
//						"customer_email" => !empty($Customer_email)?$Customer_email:'',
//						"customer_mobile" => !empty($Customer_mobile)?$Customer_mobile:'',
//						"status" => 0,
//						"vt_status" => $vt_status,
//						"customer_Point" => $percenCustomer
//					);
//				$order_payment_id = $this->Constant_model->insertDataReturnLastId('orders_payment', $order_payment);	
//				
//				
//				if (!empty($value['card_numb'])) {
//					$ckGiftResult = $this->db->query("SELECT * FROM gift_card WHERE card_number = '".$value['card_numb']."' ");
//					$ckGiftRows = $ckGiftResult->num_rows();
//					if ($ckGiftRows == 1) {
//						$ckGiftData = $ckGiftResult->result();
//						$ckGift_id = $ckGiftData[0]->id;
//						$upd_gift_data = array(
//							'status' => '1',
//							'updated_user_id' => $us_id,
//							'updated_datetime' => $tm
//						);
//						$this->Constant_model->updateData('gift_card', $upd_gift_data, $ckGift_id);
//					}
//				}
//				
//				
//				$pay_balance = $pay_query->balance;
//				$now_balance = $pay_balance + $paid_amt;
//				
//				$pay_data = array(
//					'balance'			=> $now_balance,
//					'updated_user_id'	=> $user_id,
//					'updated_datetime'	=> $today
//				);
//				
//				$this->db->update('payment_method', $pay_data, array('id' => $value['paid_by']));
//
//				$this->db->update('orders_payment', array('bring_forword' => $pay_balance), array('id' => $order_payment_id));
//					
//				if ($pay_query->name == 'Shortage Account') {
//					$this->db->query("UPDATE pump_operators set short_amount=$short_amount+$paid_amt WHERE id=$pumper_id");
//				}
//				else if($pay_query->name == 'Excess')
//				{
//					$this->db->query("UPDATE pump_operators set excess_amount=$excess_amount+$paid_amt WHERE id=$pumper_id");	
//				}
//				
//				$transaction_data = array(
//					'trans_type'	=> 'dep',
//					"user_id"		=> !empty($customer)?$customer:'0',
//					'order_id'		=> $order_id,
//					'outlet_id'		=> $outlet_id,
//					'amount'		=> $paid_amt,
//					'bring_forword' => $pay_balance,
//					'account_number'=> $value['paid_by'],
//					'pumper_id'		=> $pumper_id,
//					'settlement_id' => $settlement_no,
//					'created_by'	=> $user_id,
//					'created'		=> $today,
//					'cheque_number'	=> $value['cheque'],
//					'cheque_date'	=> !empty($value['cheque_date'])?date('Y-m-d', strtotime($value['cheque_date'])):'',
//					'bank'			=> $value['bank'],
//					'voucher_number'=> $value['voucher'],
//					'card_number'	=> $value['addi_card_numb'],
//				);	
//				
//				$this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);	
//			}
//		}
//		
//		$this->pumps_model->UpdateOrderItem($order_id);	
//		$this->pumps_model->UpdatePumpReadingSettle($settlement_no);	
//		$this->pumps_model->UpdatePumperReport($settlement_no);	
//		$this->pumps_model->UpdateMainOrder($settlement_no);	
//		$this->pumps_model->UpdatePumpTesting($settlement_no);	
//		$successpayment = $this->pumps_model->UpdateSettelementNumber($settlement_no);	
//		if($successpayment)
//		{
//			$response = array(
//				'status' => 1,
//				'message' => 'saved successfully',
//				'id' => $order_id
//			);
//		}
//		echo json_encode($response);
//	}
//	

	
	
	public function save_payment_settlement()
	{
		
		$default_store = $this->Pos_model->getDefaultCustomer();
		
		$default_store = $this->Pos_model->getDefaultCustomer();
		$default_customer_id =  $default_store->default_customer_id;
		$us_id			= $this->session->userdata('user_id');
        $tm				= date('Y-m-d H:i:s', time());
		
		$totalqty = 0;
		$user_id			= $this->session->userdata('user_id');
		$today				= date('Y-m-d H:i:s', time());
		$settlement_no		= $this->input->post('settlement_no');
		$transaction_date	= $this->input->post('transaction_date');
		$outlet_id			= $this->input->post('outlet_id');
		$CurrentShort		= $this->input->post('CurrentShort');
		$ExcessAmount		= $this->input->post('ExcessAmount');
		$totalamount		= $this->input->post('totalamount');
		$customer_id		= $this->input->post('customer_id');
		$pumper_id			= $this->input->post('pumper_name');
		$tpaid				= $this->input->post('tpaid');
		$note				= $this->input->post('noteinfo');
		$payment_method		= $this->input->post('payment');
		$fuelsale			= $this->input->post('fuelsale');
		$othersale			= $this->input->post('othersale');
		$shift_start_time	= $this->input->post('Startingtimepicker');
		$shift_end_time		= $this->input->post('Endtimepicker');
		
		$current_orders = $this->db->from('orders')->where("outlet_id=" . $outlet_id)->count_all_results(); // Produces an integer, like 25
		$current_orders++; 
		
		$outletdata = $this->Constant_model->GetOutletDetail($outlet_id);
		
		if(!empty($this->input->post('concate_collection_id')))
		{
			$explode_collection = explode(",",trim($this->input->post('concate_collection_id')));
			foreach ($explode_collection as $coll)
			{
				$this->db->set('settlement_id',$settlement_no);
				$this->db->set('settlement_date',date('Y-m-d H:i:s'));
				$this->db->where('id',  rtrim($coll));
				$this->db->update('daily_collection');
			}
		}
		
		
		
		$resultsettle = $this->Constant_model->CheckSettlementNumber($settlement_no);
		if($resultsettle->num_rows() > 0)
		{
			$update_settlement = array(
					'outlet_id'			=> $outlet_id,
					'transaction_date'  => $transaction_date,
					'pumper_id'			=> $pumper_id,
					'note'				=> $note,
					'total_amount'		=> $totalamount,
					'shift_start_time'	=> $shift_start_time,
					'shift_end_time'	=> $shift_end_time,
					'created_at'		=> $today,
			);

			$this->Constant_model->UpdateSettlementNumber($update_settlement,$settlement_no);
		}
		else
		{
			$insert_settlement = array(
				'settlement_no'		=> $settlement_no,
				'transaction_date'  => $transaction_date,
				'outlet_id'			=> $outlet_id,
				'pumper_id'			=> $pumper_id,
				'note'				=> $note,
				'total_amount'		=> $totalamount,
				'shift_start_time'	=> $shift_start_time,
				'shift_end_time'	=> $shift_end_time,
				'created_at'		=> $today,
			);
			
			$this->Constant_model->insertDataReturnLastId('settlement',$insert_settlement);
		}
		
		$this->Constant_model->RemoveTemporaryItem($settlement_no);
		
		$orderdata = array('outlet_id' => $outlet_id,
				'customer_id'			=> $default_customer_id,
				'pump_operators_id'		=> $pumper_id,
				'outlet_name'			=> $outletdata->name,
				"outlet_address"		=> $outletdata->address,
				"outlet_contact"		=> $outletdata->contact_number,
				"outlet_receipt_footer" => $outletdata->receipt_footer,
				'settlement_no'			=> $settlement_no,
				'created_by'			=> $user_id,
				'tpaid'					=> $tpaid,
				'totalamount'			=> $totalamount,
				'total_items'			=> $this->input->post('row_count') + $this->input->post('row_count_hidden_fuel'),
				'created_at'			=> $today,
				'sid'					=> $current_orders,
				"status"				=> 0,	
		);
		$order_id = $this->Constant_model->insertDataReturnLastId('orders', $orderdata);
		
		
		if(!empty($payment_method))
		{
			foreach ($payment_method as $value) {
					$pay_query = $this->Constant_model->getPaymentIDName($value['paid_by']);
					$vt_status = '';
					$short_amount = 0;
					$excess_amount = 0;
					$customer = $value['customer'];
					
					if ($pay_query->name == 'Debit / Credit Sales' || $pay_query->name == 'Vouchers') 
					{ 
						$vt_status = '0';
					} 
					else
					{ 
						$vt_status = '1';
					}
					$paid_amt = $value['paid'];

					
					if ($pay_query->name == 'Deposit') {
						$this->db->query("UPDATE customers set deposit = deposit-$paid_amt WHERE id = '".$customer."' ");
					}
					
					if ($pay_query->name == 'Pay Outstanding') 
					{
							$pay_amount = $paid_amt;
							$grand_amount = $this->Customers_model->getUnpaidOrderTotal($customer);
							
							if($pay_amount > $grand_amount)
							{
								$deposite = $this->Customers_model->getCustomerDeposite($customer);
								$customerdeposite = $pay_amount - $grand_amount;
								$finaldeposite = $deposite +  $customerdeposite;
								$deposite = $this->Customers_model->UpdateDeposite($finaldeposite,$customer);
								$pay_amount = $grand_amount;
							}
							$orderdetail = $this->Customers_model->getUnpaidOrder($customer);
							foreach ($orderdetail as $valueCustomer)
							{
								$unpaid = $valueCustomer->unpaid_amt;
								$paid	= $valueCustomer->paid_amt;
								if($unpaid <= $pay_amount)
								{
									$pay_amount  = $pay_amount - $unpaid;
									$finalPaidamount = $paid + $unpaid;
									$update_order_id = array(
										'paid_amt' => $finalPaidamount,
										'unpaid_amt' => 0,
										'updated_user_id' => $us_id,
										'updated_datetime' => $tm,
										"vt_status" => 1
									);

									$this->db->update('orders_payment', $update_order_id, array(
										'id' => $valueCustomer->id
									));
								}
								else
								{
									if($pay_amount !=0)
									{
										$final_unpaid_amount = $unpaid - $pay_amount;
										$finalPaidamount = $paid + $pay_amount;

										$update_order_id = array(
											'paid_amt' => $finalPaidamount,
											'unpaid_amt' => $final_unpaid_amount,
											'updated_user_id' => $us_id,
											'updated_datetime' => $tm,
											"vt_status" => 1
										);

										$this->db->update('orders_payment', $update_order_id, array(
											'id' => $valueCustomer->id
										));
										$pay_amount	= 0;
									}
								}
							}
					}

					$percenCustomer = 0;
					if ($pay_query->name == 'Shortage Account') {
						$getpumpData = $this->Constant_model->getDataOneColumn('pump_operators', 'id', $pumper_id);
						if (count($getpumpData) == 1) {
							$customer = $getpumpData[0]->id;
							$Customer_fullname = $getpumpData[0]->operator_name . "[PO]";
							$Customer_mobile = $getpumpData[0]->operator_mobile_number . "[PO]";
							$short_amount = $getpumpData[0]->short_amount;
						}
					}
					else if ($pay_query->name == 'Excess') {
						$getpumpDataexcee = $this->Constant_model->getDataOneColumn('pump_operators', 'id', $pumper_id);

						$customer = $getpumpDataexcee[0]->id;
						$Customer_fullname = $getpumpDataexcee[0]->operator_name . "[PO]";
						$Customer_mobile = $getpumpDataexcee[0]->operator_mobile_number . "[PO]";
						$excess_amount = $getpumpDataexcee[0]->excess_amount;
					}
					else {
						$getCustomerData = $this->Constant_model->getDataOneColumn('customers', 'id', $customer);
						if (count($getCustomerData) == 1) {
							$Customer_fullname  = $getCustomerData[0]->fullname;
							$Customer_email		= $getCustomerData[0]->email;
							$Customer_mobile	= $getCustomerData[0]->mobile;
						}
						
						
						//customer percentage
						$siteDtaData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
						$new_settings = $siteDtaData[0]->new_settings;
						$new_settings_array = json_decode($new_settings, true);
						$is_point = (array_key_exists('is_point', $new_settings_array)) ? $new_settings_array['is_point'] : '';
						$point_percentage = (array_key_exists('point_percentage', $new_settings_array)) ? $new_settings_array['point_percentage'] : '';
						if ($is_point == "yes") {
							$percenCustomer = $point_percentage / 100 * $paid_amt;
						} else {
							$percenCustomer = 0;
						}
					}
			
					if ($pay_query->name == 'Shortage Account' || $pay_query->name == 'Vouchers' || $pay_query->name == 'Debit / Credit Sales') {
						$paid_amt_string = 'unpaid_amt';
					}
					else
					{
						$paid_amt_string = 'paid_amt';
					}
					
					$order_payment = array(
						'order_id' => $order_id,
						'payment_method' => $value['paid_by'],
						'payment_method_name' => $pay_query->name,
						$paid_amt_string => $value['paid'],
						'subtotal' => $value['paid'],
						'grandtotal' => $value['paid'],
						'created_user_id' => $user_id,
						'updated_user_id' => $user_id,
						'ordered_datetime' => $today,
						'created_datetime' => $today,
						'updated_datetime' => $today,
						'outlet_id' => $outlet_id,
						'pump_operators_id' => $pumper_id,
						'outlet_name' => $outletdata->name,
						"outlet_address" => $outletdata->address,
						"outlet_contact" => $outletdata->contact_number,
						"outlet_receipt_footer" => $outletdata->receipt_footer,
						'cheque_number' => $value['cheque'],
						'voucher_number' => $value['voucher'],
						"card_number" => $value['addi_card_numb'],
						"gift_card" => $value['card_numb'],
						'customer_note' => $value['customer_note'],
						"bank" => $value['bank'],
						"cheque_date" => date('Y-m-d', strtotime($value['cheque_date'])),
						"customer_id" => !empty($customer)?$customer:'',
						"customer_name" => !empty($Customer_fullname)?$Customer_fullname:'',
						"customer_email" => !empty($Customer_email)?$Customer_email:'',
						"customer_mobile" => !empty($Customer_mobile)?$Customer_mobile:'',
						"sid" => $current_orders,
						"status" => 0,
						"default_bulk_status" => $value['default_bulk_status'],
						"credit_debit_bulk_status" => $value['ValueDebitCreditBulk'],
						"vt_status" => $vt_status,
						"customer_Point" => $percenCustomer
					);
				$order_payment_id = $this->Constant_model->insertDataReturnLastId('orders_payment', $order_payment);	
				
				
				if (!empty($value['card_numb'])) {
					$ckGiftResult = $this->db->query("SELECT * FROM gift_card WHERE card_number = '".$value['card_numb']."' ");
					$ckGiftRows = $ckGiftResult->num_rows();
					if ($ckGiftRows == 1) {
						$ckGiftData = $ckGiftResult->result();
						$ckGift_id = $ckGiftData[0]->id;
						$upd_gift_data = array(
							'status' => '1',
							'updated_user_id' => $us_id,
							'updated_datetime' => $tm
						);
						$this->Constant_model->updateData('gift_card', $upd_gift_data, $ckGift_id);
					}
				}
				
				
				$pay_balance = $pay_query->balance;
				$now_balance = $pay_balance + $paid_amt;
				
				$pay_data = array(
					'balance'			=> $now_balance,
					'updated_user_id'	=> $user_id,
					'updated_datetime'	=> $today
				);
				
				$this->db->update('payment_method', $pay_data, array('id' => $value['paid_by']));

				$this->db->update('orders_payment', array('bring_forword' => $pay_balance), array('id' => $order_payment_id));
					
				if ($pay_query->name == 'Shortage Account') {
					$this->db->query("UPDATE pump_operators set short_amount=$short_amount+$paid_amt WHERE id=$pumper_id");
				}
				else if($pay_query->name == 'Excess')
				{
					$this->db->query("UPDATE pump_operators set excess_amount=$excess_amount+$paid_amt WHERE id=$pumper_id");	
				}
				
				$transaction_data = array(
					'trans_type'	=> 'dep',
					"user_id"		=> !empty($customer)?$customer:'0',
					'order_id'		=> $order_id,
					'outlet_id'		=> $outlet_id,
					'amount'		=> $paid_amt,
					'bring_forword' => $pay_balance,
					'account_number'=> $value['paid_by'],
					'pumper_id'		=> $pumper_id,
					'settlement_id' => $settlement_no,
					'created_by'	=> $user_id,
					'created'		=> $today,
					'cheque_number'	=> $value['cheque'],
					'cheque_date'	=> !empty($value['cheque_date'])?date('Y-m-d', strtotime($value['cheque_date'])):'',
					'bank'			=> $value['bank'],
					'voucher_number'=> $value['voucher'],
					'card_number'	=> $value['addi_card_numb'],
				);	
				
				$this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);	
			}
		}
		
		if(!empty($fuelsale))
		{
			foreach ($fuelsale as $sale)
			{
				$totalqty = $totalqty + $sale['qty'];
				$single_product_data = $this->Constant_model->getSingleProduct($sale['codee']);
				$ins_order_item_data = array(
					'product_id'		=> $sale['codee'],
					'order_id'			=> $order_id,
					'product_code'		=> $single_product_data->code,
					'product_name'		=> $single_product_data->name,
					'product_category'	=> $single_product_data->category,
					'cost'				=> $single_product_data->purchase_price,
					'price'				=> $sale['retail_price'],
					'qty'				=> $sale['qty'],
					'paid'				=> $sale['gtotal'],
					'subtotal'			=> $sale['gtotal'],
					'grandtotal'		=> $sale['gtotal'],
					'pump_operators_id' => $pumper_id,
					'pump_id'			=> $sale['pump_no'],
					'ow_id'				=> $sale['fuel_tank_ids'],
					'type'				=> '1',
				);
				$order_item_id = $this->Constant_model->insertDataReturnLastId('order_items', $ins_order_item_data);
				
				
				$get_product_report = $this->db->select('*');
				$get_product_report = $this->db->from('product_report');
				$get_product_report = $this->db->where('product_code',$single_product_data->code);
				$get_product_report = $this->db->order_by('id','desc');
				$get_product_report = $this->db->limit('1');
				$get_product_report = $this->db->get()->row();

				$opening_balance = $get_product_report->balance_qty;
				$product_balance = $opening_balance  -  $sale['qty'];

				$product_report = array(
					'product_code'	=> $single_product_data->code,
					'opening_qty'	=> $opening_balance,
					'purchase_qty'	=> 0,
					'sales_qty'		=>  $sale['qty'],
					'balance_qty'   => $product_balance,
					'created_by'	=> $this->session->userdata('user_id'),
					'created_date'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('product_report',$product_report);

				
				$pumpData = $this->Constant_model->getPumpSignleRecord($sale['pump_no']);
				$last_meter_reading = $pumpData->last_meter_reading;
				
				$update_metter = array(
					'temp_meter_reading' => $sale['end_meter'],
					'last_meter_reading' => $sale['end_meter'],
					'checkk' => 1,
				);
				$this->Constant_model->UpdatePumpSignleRecord($update_metter,$sale['pump_no']);
				
				$pump_reading = array(
						'outlet_id'		=> $outlet_id,
						'settlement_id'	=> $settlement_no,
						'order_item_id'	=> $order_item_id,
						'pump_id'		=> $sale['pump_no'],
						'product_id'	=> $sale['codee'],
						'start_meter'	=> $sale['start_meter'],
						'end_meter'		=> $sale['end_meter'],
						'sold_qty'		=> $sale['qty'],
						'amount'		=> $sale['gtotal'],
						'testing_qty'	=> $sale['testing_qty'],
						'created_at'	=> $today,
					);
				
				$this->Constant_model->insertData('pump_reading', $pump_reading);
				
				if($sale['testing_qty'] != "" && $sale['testing_qty'] != 0)
				{
					$testing_grandtotal = $sale['retail_price'] * $sale['testing_qty'];
					$ins_order_testing_pump = array(
						'pump_id'			=> $sale['pump_no'],
						'outlet_id'			=> $outlet_id,
						'product_id'		=> $sale['codee'],
						'settlement_id'		=> $settlement_no,
						'order_id'			=> $order_id,
						'product_code'		=> $single_product_data->code,
						'price'				=> $sale['retail_price'],
						'testing_qty'		=> $sale['testing_qty'],
						'grand_total'		=> $testing_grandtotal,
						'pump_operators_id' => $pumper_id,
						'created_by'		=> $user_id,
						'created_at'		=> $today,
					);
					$this->Constant_model->insertData('pump_testing', $ins_order_testing_pump);
				}
				
			
					$Fuel_tank_Query = $this->db->get_where("fuel_tanks",array('id'=>$sale['fuel_tank_ids']))->row();
					$select_current_balance = $Fuel_tank_Query->current_balance;
					$now_balance = $select_current_balance - $sale['qty'];
					$total_tank_balance = $select_current_balance + $sale['qty'];
					$data_tank = array("current_balance"=>$now_balance);

					$this->db->update("fuel_tanks",$data_tank , array("id" => $sale['fuel_tank_ids']));

					$Product_Query = $this->db->get_where('products',array("id"=>$sale['codee']))->row();
					$select_pcode = $Product_Query->code;

					$Inventry_Query		= $this->db->get_where('inventory',array("product_code"=>$select_pcode,'outlet_id'=>$outlet_id,'ow_id' =>$sale['fuel_tank_ids'], 'type' => '1'))->row();
					$select_inventry_id = $Inventry_Query->id;
					$select_qty			= $Inventry_Query->qty;

					$now_qty		= $select_qty - $sale['qty'];
					$data_inventory = array("qty" => $now_qty);

					$this->db->update("inventory",$data_inventory,array("id"=>$select_inventry_id));
					
					
					$inventory_changes = array(
						'product_code'		=>$select_pcode,
						'settlement_no'		=>$settlement_no,
						'outlet_id'			=>$outlet_id,
						'qty'				=>$sale['qty'],
						'available_qty'		=>$now_qty,
						'tank_warehouse_id'	=>$sale['fuel_tank_ids'],
						'type'				=>1,
						'price'				=>$sale['retail_price'],
						'amount'			=>$sale['gtotal'],
						'created_by'		=>$this->session->userdata('user_id'),
						'created_date'		=>date('Y-m-d H:i:s'),
						'purchase_sale_type' =>	0,
					);
					
					$this->Constant_model->insertDataReturnLastId('inventory_changes', $inventory_changes);
					
					
					$new_tank_reading = array(
						'tank_id'			=> $sale['fuel_tank_ids'],
						'settlement_id'		=> $settlement_no,
						'outlet_id'			=> $outlet_id,
						'total_tank_balance'=> $total_tank_balance,
						'available_tank_qty'=> $now_balance,
						'tank_qty'			=> $sale['qty'],
						'sold_qty'			=> $sale['qty'],
						'created_by'		=> $this->session->userdata('user_id'),
						'created_date'      => date('Y-m-d H:i:s')
					);
					
					$this->Constant_model->insertDataReturnLastId('fuel_tanks_reading', $new_tank_reading);
				
				if(!empty($pumper_id))
				{
					$pumper_Query = $this->db->get_where('pump_operators', array(
								'id' => $pumper_id
					))->row();
					
					$select_commisiion = $pumper_Query->commission_ap;
					$gtotal_commesion = $select_commisiion / 100 * $sale['gtotal'];
					
					$data = array(
						'product_id'	=>  $sale['codee'],
						'outlet_id'		=>	$outlet_id,
						'pump_id'		=>	$sale['pump_no'],
						'qty'			=>  $sale['qty'],
						'fuel_tank_ids' =>  $sale['fuel_tank_ids'],
						'gtotal'		=>	$gtotal_commesion,
						'sale_amount'	=>  $sale['gtotal'],
						'pumper_id'		=>  $pumper_id,
						'customer_id'	=>	$customer_id,
						'settlement_receipt_no'	=>	$settlement_no,
						'created_by'	=>	$user_id,
						'orderDatetime' =>	date("Y-m-d H:i:s")
					);
					$this->pumps_model->add_to_pumper_report($data);
				}
			}
		}
		
		if(!empty($othersale))
		{
			foreach ($othersale as $other)
			{
				$single_product_data = $this->Constant_model->getSingleProduct($other['codeone']);
				$totalqty = $totalqty + $other['qtyone'];
				$ins_order_item_data = array(
					'product_id'		=> $other['codeone'],
					'order_id'			=> $order_id,
					'product_code'		=> $single_product_data->code,
					'product_name'		=> $single_product_data->name,
					'product_category'	=> $single_product_data->category,
					'cost'				=> $single_product_data->purchase_price,
					'price'				=> $other['retail_priceone'],
					'qty'				=> $other['qtyone'],
					'paid'				=> $other['gtotal1one'],
					'subtotal'			=> $other['gtotal1one'],
					'grandtotal'		=> $other['gtotal1one'],
					'tax'				=> $other['taxone'],
					'discount'			=> $other['discountone'],
					'discount_amount'	=> $other['discountamountone'],
					'tax_amount'		=> $other['calculateTaxone'],
					'ow_id'				=> $other['outlet_warehouse_id_data'],
					'type'				=> '0',
				);
				
				
				
				
				
				
				$get_product_report = $this->db->select('*');
				$get_product_report = $this->db->from('product_report');
				$get_product_report = $this->db->where('product_code',$single_product_data->code);
				$get_product_report = $this->db->order_by('id','desc');
				$get_product_report = $this->db->limit('1');
				$get_product_report = $this->db->get()->row();

				$opening_balance = $get_product_report->balance_qty;
				$product_balance = $opening_balance  - $other['qtyone'];

				$product_report = array(
					'product_code'	=> $single_product_data->code,
					'opening_qty'	=> $opening_balance,
					'purchase_qty'	=> 0,
					'sales_qty'		=> $other['qtyone'],
					'balance_qty'   => $product_balance,
					'created_by'	=> $this->session->userdata('user_id'),
					'created_date'	=> date('Y-m-d H:i:s'),
				);
				$this->db->insert('product_report',$product_report);

				
			
				
				$getStore = $this->Constant_model->OutletWarehouseget($other['outlet_warehouse_id_data']);
				$oldstore = $getStore->s_stock;
				$newstoreQty = $getStore->s_stock - $other['qtyone'];
				$data_storeupdate = array(
					's_stock' => $newstoreQty,
					's_stock_upated' => $newstoreQty,
				);
				$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);
				
				$this->Constant_model->InventoryUpdateOtherSales($single_product_data->code,$outlet_id,$other['outlet_warehouse_id_data'],$other['qtyone']);
				$this->Constant_model->insertData('order_items', $ins_order_item_data);
				
				
				$inventory_changes = array(
					'product_code'		=>$single_product_data->code,
					'settlement_no'		=>$settlement_no,
					'outlet_id'			=>$outlet_id,
					'qty'				=>$other['qtyone'],
					'available_qty'		=>$newstoreQty,
					'tank_warehouse_id'	=>$other['outlet_warehouse_id_data'],
					'type'				=>0,
					'price'				=>$other['retail_priceone'],
					'amount'			=>$other['gtotal1one'],
					'created_by'		=>$this->session->userdata('user_id'),
					'created_date'		=>date('Y-m-d H:i:s'),
					'purchase_sale_type'		=>	0,
				);
				$this->Constant_model->insertDataReturnLastId('inventory_changes', $inventory_changes);
				
			}
		}
		
//			$pumpData = $this->db->get_where('pumps', array('checkk' => 0))->result();
//			foreach ($pumpData as $value) {
//				$m = $this->db->get_where('pumps', array('id' => $value->id))->row();
//				$llast_meter_reading = $value->last_meter_reading;
//				$this->db->query("UPDATE pumps SET temp_meter_reading = '$llast_meter_reading' , checkk = 1     WHERE checkk = 0 LIMIT 1");
//			}
		
			$this->Constant_model->RemoveTemparyPayment($settlement_no);	
			$this->pumps_model->UpdateSettelementNumber($settlement_no);	
			$finalResult = 	$this->db->query("UPDATE orders SET total_items = '".$totalqty."' WHERE id = '".$order_id."' ");
			if($finalResult)
			{
				$response = array(
					'status' => 1,
					'message' => 'saved successfully',
					'id' => $order_id
				);
			}	
	
		echo json_encode($response);
	}
	
	
	
	public function getPump_last_reading($id = 0) {

		$HTML = "";
		if(!empty($id))
		{
			$query_get_pump = $this->db->query("SELECT * FROM pump_reading WHERE pump_id = '".$id."' and status = 0 order by id DESC limit 1");
			$query_get_pump = $query_get_pump->result();
			
			$query_get_fueltank = $this->db->get_where('pumps', array('id' => @$id))->row();
			if(!empty($query_get_pump))
			{
				$HTML = "<div class='form-group'> <label>Pump Last Meter</label> <input type='text' value='" . @$query_get_pump[0]->end_meter . "' " . "name='last_meter' id='lastreading'  class='form-control'  readonly /> <input type='hidden' id='id' name='id' value='" . @$query_get_fueltank->id . "' /><input type='hidden' id='fuel_tank_ids' value=".@$query_get_fueltank->fuel_tank_ids."> </div>";
			}
			else
			{
				$HTML = "<div class='form-group'> <label>Pump Last Meter</label> <input type='text' value='" . $query_get_fueltank->temp_meter_reading . "' " . "name='last_meter' id='lastreading'  class='form-control'  readonly /> <input type='hidden' id='id' name='id' value='" . $query_get_fueltank->id . "' /><input type='hidden' id='fuel_tank_ids' value=".$query_get_fueltank->fuel_tank_ids."> </div>";
			}
		}
		echo $HTML;
	}
	
	public function testing_getPump_last_reading($id = 0) {

		$HTML = "";
		if(!empty($id))
		{
			$query_get_pump = $this->db->get_where('pumps', array('id' => @$id))->row();
			$HTML = "<div class='form-group'> <label>Pump Last Meter</label> <input type='text' value='" . @$query_get_pump->last_meter_reading . "' " . "name='testing_last_meter' id='testing_lastreading'  class='form-control'  readonly /> <input type='hidden' id='id' name='id' value='" . @$query_get_pump->id . "' /><input type='hidden' id='testing_fuel_tank_ids' value=".@$query_get_pump->fuel_tank_ids."> </div>";
		}
		echo $HTML;
	}
	
	public function checkPumps() {
		
		$pid			= $this->input->get('pid');
		$current		= $this->input->get('current');
		$lastreading	= $this->input->get('lastreading');
		$finalqty		= $this->input->get('finalqty');
		
		if(!empty($pid) && !empty($current) && !empty($lastreading))
		{
			
			$ckPcodeResult = $this->db->query("SELECT *,(select product_id from fuel_tanks WHERE id = fuel_tank_ids limit 1) as product_id FROM pumps WHERE id=$pid ");
			$ckPcodeRows = $ckPcodeResult->num_rows();
			if ($ckPcodeRows == 0) {
				$response = array(
					'errorMsg' => 'failure',
					'name' => 'Pumps not found'
				);
			}
			else 
			{
				$ckPcodeData = $ckPcodeResult->result();
				$ckPcode_id = $ckPcodeData[0]->id;
				$ckPcode_name = $ckPcodeData[0]->pump_name;
				$ckPcode_no = $ckPcodeData[0]->pump_no;
				//$product_id = $ckPcodeData[0]->pid;
				$product_id = $ckPcodeData[0]->product_id;
				$fuel_tank_ids = $ckPcodeData[0]->fuel_tank_ids;
				
				$productdata = $this->db->query("SELECT * FROM products WHERE id= '".$product_id."' ");
				if ($productdata->num_rows() > 0) {
					$ckPcodeDataresult = $productdata->result();
					$ppcode = $ckPcodeDataresult[0]->code;
					$ppname = $ckPcodeDataresult[0]->name;
					
					$ppretail_price = $ckPcodeDataresult[0]->retail_price;
					$outlet_id = $ckPcodeDataresult[0]->outlet_id_fk;
					$type = 1;
					
					$inventory = $this->Constant_model->CheckInventoryByTank($ppcode,$outlet_id,$fuel_tank_ids,$type);
					if($inventory->num_rows())
					{
						$inventoryqty = $inventory->row()->qty;
						if($finalqty > $inventoryqty)
						{
							$response = array(
								'errorMsg' => 'stock',
								'name' => 'Out of Stock Availabe Qty is <b>'.$inventoryqty.'</b> ',
							);
						}
						else
						{
							$data = array(
								'last_meter_reading' => $current,
								'checkk' => 0
							);

							$this->db->where('id', $pid)->update('pumps', $data);

							$response = array(
								'errorMsg' => 'success',
								'code' => $ppcode,
								'ppname' => $ppname,
								'name' => $ckPcode_name,
								'retail_price' => $ppretail_price,
								'id' => $ckPcode_id,
								'product_id' => $product_id
							);
						}
					}
					else
					{
						$response = array(
								'errorMsg' => 'stock',
								'name' => 'Out of Stock Availabe Qty is 0 n</b> ',
							);
					}
					
				}
				else
				{
					$response = array(
						'errorMsg' => 'failure',
						'name' => 'Product not found'
					);
				}
			}
		}
		else
		{
			$response = array(
				'errorMsg' => 'failure',
				'name' => 'Data not complete'
			);
		}
		echo json_encode($response);
	}
	
	public function checkPumps1() {
		
		$pid			= $this->input->get('pid');
		$current		= $this->input->get('current');
		$lastreading	= $this->input->get('lastreading');
		$finalqty		= $this->input->get('finalqty');
		$testingqty		= $this->input->get('testingqty');
		$settelment_no	= $this->input->get('settelment_no');
		$transaction_date	= $this->input->get('transaction_date');
		$outlet_id		= $this->input->get('outlet_id');
		$pumper_name	= $this->input->get('pumper_name');
		$ShiftStartingTime	= $this->input->get('ShiftStartingTime');
		$ShiftEndTime	= $this->input->get('ShiftEndTime');
		
		
		
		
		if(!empty($pid) && !empty($current) && !empty($lastreading))
		{
			
			$ckPcodeResult = $this->db->query("SELECT *,(select product_id from fuel_tanks WHERE id = fuel_tank_ids limit 1) as product_id FROM pumps WHERE id=$pid ");
			$ckPcodeRows = $ckPcodeResult->num_rows();
			if ($ckPcodeRows == 0) {
				$response = array(
					'errorMsg' => 'failure',
					'name' => 'Pumps not found'
				);
			}
			else 
			{
				$ckPcodeData = $ckPcodeResult->result();
				$ckPcode_id = $ckPcodeData[0]->id;
				$ckPcode_name = $ckPcodeData[0]->pump_name;
				$ckPcode_no = $ckPcodeData[0]->pump_no;
				//$product_id = $ckPcodeData[0]->pid;
				$product_id = $ckPcodeData[0]->product_id;
				$fuel_tank_ids = $ckPcodeData[0]->fuel_tank_ids;
				
				$productdata = $this->db->query("SELECT * FROM products WHERE id= '".$product_id."' ");
				if ($productdata->num_rows() > 0) {
					$ckPcodeDataresult = $productdata->result();
					$ppcode = $ckPcodeDataresult[0]->code;
					$ppname = $ckPcodeDataresult[0]->name;
					
					$purchase_price = $ckPcodeDataresult[0]->purchase_price;
					$ppretail_price = $ckPcodeDataresult[0]->retail_price;
					$outlet_id = $ckPcodeDataresult[0]->outlet_id_fk;
					$type = 1;
					
					$inventory = $this->Constant_model->CheckInventoryByTank($ppcode,$outlet_id,$fuel_tank_ids,$type);
					if($inventory->num_rows())
					{
						$inventoryqty = $inventory->row()->qty;
						if($finalqty > $inventoryqty)
						{
							$response = array(
								'errorMsg' => 'stock',
								'name' => 'Out of Stock Availabe Qty is <b>'.$inventoryqty.'</b> ',
							);
						}
						else
						{
							$data = array(
								'last_meter_reading' => $current,
								'checkk' => 0
							);

							$this->db->where('id', $pid)->update('pumps', $data);

							
							$resultsettle = $this->Constant_model->CheckSettlementNumber($settelment_no);
							if($resultsettle->num_rows() > 0)
							{
								
								$update_settlement =  array(
									'outlet_id'			=> $outlet_id,
									'transaction_date' => $transaction_date,
									'pumper_id'			=> $pumper_name,
									'shift_start_time'	=> $ShiftStartingTime,
									'shift_end_time'	=> $ShiftEndTime,
									'status'			=> 2,
								);
								
								$this->Constant_model->UpdateSettlementNumber($update_settlement,$settelment_no);
								
							}
							else
							{
								$insert_settlement =  array(
									'settlement_no'		=> $settelment_no,
									'transaction_date' => $transaction_date,
									'outlet_id'			=> $outlet_id,
									'pumper_id'			=> $pumper_name,
									'shift_start_time'	=> $ShiftStartingTime,
									'shift_end_time'	=> $ShiftEndTime,
									'created_at'		=> date('Y-m-d H:i:s'),
									'status'			=> 2,
									);
								
								$this->Constant_model->insertDataReturnLastId('settlement',$insert_settlement);
							}
							
							
							$grandtotal = $ppretail_price * $finalqty;
							$temporary_item = array(
								'settlement_id' => $settelment_no, 
								'product_code'	=> $ppcode, 
								'pump_operators_id'	=> $pumper_name, 
								'testing_qty'	=> $pumper_name, 
								'start_meter'	=> $lastreading, 
								'end_meter'		=> $current, 
								'testing_qty'		=> $testingqty, 
								'qty'			=> $finalqty, 
								'cost'			=> $purchase_price, 
								'price'			=> $ppretail_price, 
								'pump_id'		=> $pid, 
								'grandtotal'	=> $grandtotal, 
								'paid	'		=> $grandtotal, 
								'ow_id'			=> $fuel_tank_ids, 
								'type'			=> 1, 
							);
							
							$lastid = $this->Constant_model->insertDataReturnLastId('temporary_order_items', $temporary_item);
							
							
							$response = array(
								'errorMsg' => 'success',
								'code'				=> $ppcode,
								'ppname'			=> $ppname,
								'name'				=> $ckPcode_name,
								'retail_price'		=> $ppretail_price,
								'id'				=> $ckPcode_id,
								'product_id'		=> $product_id,
								'item_temporary_id' => $lastid
							);
						}
					}
					else
					{
						$response = array(
								'errorMsg' => 'stock',
								'name' => 'Out of Stock Availabe Qty is 0 n</b> ',
							);
					}
					
				}
				else
				{
					$response = array(
						'errorMsg' => 'failure',
						'name' => 'Product not found'
					);
				}
			}
		}
		else
		{
			$response = array(
				'errorMsg' => 'failure',
				'name' => 'Data not complete'
			);
		}
		echo json_encode($response);
	}
	
	public function DeleteTemporaryItem()
	{
		$item_id = $this->input->post('item_id');
		$this->Constant_model->DeleteTemporaryItem($item_id);
		$json['success'] = true;
		echo json_encode($json);
	}
	
	public function removemeterReading() {
		$id = $this->input->post('id');
		$qty = $this->input->post('qty');
		$query = $this->db->get_where('pumps', array(
					'id' => $id
				))->row();
		$lastreading = $query->last_meter_reading;
		$nowreading = $lastreading - $qty;
		$data = array(
			'last_meter_reading' => $nowreading,
			'checkk' => 1
		);
		$bool = $this->db->where('id', $id)->update('pumps', $data);
		if ($bool) {
			$response = array(
				'status' => 1,
				'message' => 'saved successfully'
			);
		} else {
			$response = array(
				'status' => 0,
				'message' => 'Something went wrong!'
			);
		}
		echo json_encode($response);
	}
	
	
	public function Testing_checkPumps() {
		
		$pid		= $this->input->get('pid');
		$current	= $this->input->get('current');
		$lastreading = $this->input->get('lastreading');
		if(!empty($pid) && !empty($current) && !empty($lastreading))
		{
			$data = array(
				'last_meter_reading' => $current,
				'testing' => 0
			);
			$this->db->where('id', $pid)->update('pumps', $data);
			$ckPcodeResult = $this->db->query("SELECT *,(select product_id from fuel_tanks WHERE id = fuel_tank_ids limit 1) as product_id FROM pumps WHERE id=$pid ");
			$ckPcodeRows = $ckPcodeResult->num_rows();
			if ($ckPcodeRows == 0) {
				$response = array(
					'errorMsg' => 'failure',
					'name' => 'Pumps not found'
				);
			}
			else 
			{
				$ckPcodeData = $ckPcodeResult->result();
				$ckPcode_id = $ckPcodeData[0]->id;
				$ckPcode_name = $ckPcodeData[0]->pump_name;
				$ckPcode_no = $ckPcodeData[0]->pump_no;
				$product_id = $ckPcodeData[0]->product_id;
				
				$productdata = $this->db->query("SELECT * FROM products WHERE id= '".$product_id."' ");
				if ($productdata->num_rows() > 0) {
					$ckPcodeDataresult = $productdata->result();
					$ppcode = $ckPcodeDataresult[0]->code;
					$ppname = $ckPcodeDataresult[0]->name;
					$ppretail_price = $ckPcodeDataresult[0]->retail_price;
					$response = array(
						'errorMsg' => 'success',
						'code' => $ppcode,
						'ppname' => $ppname,
						'name' => $ckPcode_name,
						'retail_price' => $ppretail_price,
						'id' => $ckPcode_id,
						'product_id' => $product_id
					);
				}
				else
				{
					$response = array(
						'errorMsg' => 'failure',
						'name' => 'Product not found'
					);
				}
			}
		}
		else
		{
			$response = array(
				'errorMsg' => 'failure',
				'name' => 'Data not complete'
			);
		}
		echo json_encode($response);
	}
	
	
	
	//Tax Module
	public function view_invoice() {
		if(!empty($this->input->get('id')))
		{
			$id = $this->input->get('id');
			$data['order_id'] = $id;
			
			$data['getItemOrder'] = $this->Pos_model->getOrderItemPrint($id);
			$data['orderdetail'] = $this->Constant_model->getMainOrderDetail($id);
			$data['paymentDetail'] = $this->Constant_model->getPaymentDetail($id);
			$data['new_sys_settings'] = ci_set_settings();
			//echo "<pre>";
			//print_r($data['getItemOrder']);
			//die;
			
			$this->load->view('pumps/print_invoice', $data);
		}
		else
		{
			redirect(base_url().'pumps/settlement');
		}
	}
	
	public function send_invoice_pumps() {
		$this->load->library('email');
		$new_sys_settings = ci_set_settings();
		$order_id = $this->input->post('id');
		$orderdetail = $this->Constant_model->getMainOrderDetail($order_id);
		$paymentDetail = $this->Constant_model->getPaymentDetail($order_id);
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();

		$setting_dateformat = $settingData->datetime_format;
		$setting_site_logo = $settingData->site_logo;
		$email = $this->input->post('email');
		$mesg = '';
		$fromemail = 'noreply@syzygy.technologies.com';
		$toemail = "$email";
		$subject = "Receipt from $settingData->site_name";
		
		
	$mesg.= '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	 
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Reset BabyQ Password</title>
	<style type="text/css">
	
	@media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
		body[yahoo] .hide {display: none!important;}
		body[yahoo] .buttonwrapper {background-color: transparent!important;}
		body[yahoo] .button {padding: 0px!important;}
		body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
		body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
	}
	
	/*@media only screen and (min-device-width: 601px) {
	.content {width: 600px !important;}
	.col425 {width: 425px!important;}
	.col380 {width: 380px!important;}
	}*/
	
	body { 
		max-width: 300px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
	#wrapper { 
		min-width: 250px; 
		margin: 0px auto; 
	}
	#wrapper img { 
		max-width: 300px; 
		width: auto; 
	}

	h2, h3, p { 
		margin: 5px 0;
	}
	.left { 
		width:100%; 
		float: right; 
		text-align: right; 
		margin-bottom: 3px;
		margin-top: 3px;
	}
	.right { 
		width:40%; 
		float:right; 
		text-align:right; 
		margin-bottom: 3px; 
	}
	.table, .totals { 
		width: 100%; 
		margin:10px 0; 
	}
	.table th { 
		border-top: 1px solid #000; 
		border-bottom: 1px solid #000; 
		padding-top: 4px;
		padding-bottom: 4px;
	}
	.table td { 
		padding:0; 
	}
	.totals td { 
		width: 24%; 
		padding:0; 
	}
	.table td:nth-child(2) { 
		overflow:hidden; 
	}
	
	</style>
	</head>
	
	<body yahoo bgcolor="#f6f8f1" style="margin: 0; padding: 0; min-width: 100% !important;">
		<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
				<!--[if (gte mso 9)|(IE)]>
				<table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
				<tr>
				<td>
				<![endif]-->     
					<table bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, Helvetica, sans-serif; width: 100%; max-width: 600px;">
						<tr>
							<td style="padding: 30px 20px 30px 20px;">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td style="font-size: 13px; line-height: 22px;">



<div id="wrapper">
    <table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
		<tr>
		    <td width="100%" align="center">
			    <center>
			    	<img src="' . base_url() . 'assets/img/logo/' . $setting_site_logo . '" style="width: 80px;" />
			    </center>
		    </td>
	    </tr>
	    <tr>
		    <td width="100%" align="center">
			    <h2 style="padding-top: 0px; font-size: 24px;"><strong>'.$orderdetail->outlet_name.'</strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
			    <span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Pump Operator : '.!empty($orderdetail->operator_name)?$orderdetail->operator_name:'Nil'. '</span>
				<span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Address : '.$orderdetail->outlet_address. '</span>	
				<span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Tel : ' . $orderdetail->outlet_contact  . '</span> 
				<span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Sale Id : '.$order_id.'</span>
				<span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Date : '.date("d-M-y H:i A", strtotime($orderdetail->created_at)).'</span>
			</td>
		</tr>   
            
    </table>
    
	 
	    
	<div style="clear:both;"></div>
    <table class="table" cellspacing="0"  border="0"> 
		<thead> 
			<tr> 
				<th width="5%"><em>#</em></th> 
				<th width="30%" align="left">Customer Name</th>
				<th width="25%" align="left">Product</th>
				<th width="25%">Paid By</th>
				<th width="20%">Grand Total</th>
 
			</tr> 
		</thead> 
		<tbody>';
		
			$i = 1;
			$subtotal = 0;
			foreach ($paymentDetail as $pay)
			{ 
			
			  $mesg.= '<tr>
				<td>'.$i++.'</td>
				<td>'.$pay->customer_name.'</td>
				<td>Pump Product (Fuel)</td>
				<td>'.$pay->payment_method_name.'</td>
				<td>';
					if ($pay->payment_method == 6 || $pay->payment_method == 17) {
						$mesg.= ''.number_format($pay->unpaid_amt,2).'';
						$subtotal  = $subtotal + $pay->unpaid_amt;
					}
					else
					{
						$mesg.= ''.number_format($pay->paid_amt,2).'';
						$subtotal  = $subtotal + $pay->paid_amt;
					}
			  $mesg.= '</td>
			</tr>';
			}
			$mesg .= '	 
    	</tbody> 
	</table> 
	
    
    <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000;" width="100%">
    	<tbody>
			<tr>
				<td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Sub Total </td>
				<td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; 
                                font-weight:bold; ">' . number_format($subtotal, 2) . '</td>
    		</tr>
    </tbody>
    </table>
    <center>
    <div style="border-top:1px solid #000; padding-top:10px;">' . $new_sys_settings['invoice_footer'] . '</div>
    </center>
</div>


										</td>
									</tr>
									<tr>
										<td height="20px"></td>
									</tr>
									<tr>
										<td style="font-size: 13px; line-height: 22px;">
											Sincerely,
											<Br />
											- ' . $new_sys_settings['invoice_footer'] . ' 
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
	
					</table>
				<!--[if (gte mso 9)|(IE)]>
				</td>
				</tr>
				</table>
				<![endif]-->
				</td>
			</tr>
		</table>
	</body>
	</html>	
		';
		
		$config = array(
			'charset' => 'utf-8',
			'wordwrap' => true,
			'mailtype' => 'html'
		);
		$this->email->initialize($config);
		$this->email->to($toemail);
		$this->email->from($fromemail, "$settingData->site_name");
		$this->email->subject($subject);
		$this->email->message($mesg);
		if($this->email->send())
		{
			return true;
		}
		
	}
	
	public function view_invoice_a4() {
		if(!empty($this->input->get('id')))
		{
			$id = $this->input->get('id');
			$data['order_id'] = $id;
			$data['getItemOrder'] = $this->Pos_model->getOrderItemPrint($id);
			$data['orderdetail'] = $this->Constant_model->getMainOrderDetail($id);
			$data['paymentDetail'] = $this->Constant_model->getPaymentDetail($id);
			$data['new_sys_settings'] = ci_set_settings();
			
			$this->load->view('pumps/print_invoice_a4', $data);
		}
		else
		{
			redirect(base_url().'pumps/settlement');
		}
	}

	public function esctax() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='escTax')");

		if (!isset($permission_data[0]->view_right) || (isset($permission_data[0]->view_right) && $permission_data[0]->view_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'View esc tax',
				'You can not view esc tax. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
		$esc_data = $this->db->get_where('esctax', array(
					'status' => 1
				))->result();
		$outlet_data = $this->db->get_where('outlets', array(
					'status' => 1
				))->result();
		$taxData = $this->Constant_model->getDataOneColumnSortColumn('purchase_taxes', 'status', '1', 'created_at', 'ASC');


		$data['esc_data'] = $esc_data;
		$data['outlet_dataa'] = $outlet_data;
		$data['taxData'] = $taxData;

		$this->load->view('pumps/esctax', $data);
	}
	
	public function pumperreport() {
		
		$permisssion_url = 'pumperreport';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		

		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(orderDatetime,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(orderDatetime,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('pumper_report');
		$result = $query->result();
		$this->db->save_queries = false;
		$data['results'] = $result;
		$data['user_role'] = $this->session->userdata('user_role');

		$this->load->view('includes/header');
		$this->load->view('pumps/pumperreport', $data);
		$this->load->view('includes/footer');
	}
	
	public function fuelsalereport() {
		
		
		$permisssion_url = 'fuelsalereport';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['user_role'] = $this->session->userdata('user_role');
		
		$data['results'] = $this->pumps_model->GetFuelSaleReport();
		$data['results_product_wise'] = $this->pumps_model->GetFuelSaleReportProductWsie();
		$this->load->view('includes/header');
		$this->load->view('pumps/fuelsalereport', $data);
		$this->load->view('includes/footer');
	}
	
	

	function daily_collection()
	{
		
		$permisssion_url = 'daily_collection';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getDailyCollectionFormNo'] = $this->Constant_model->getDailyCollectionFormNo();
		$data['getPumpOperatorAll'] = $this->Constant_model->getPumpOperatorAll();
		$data['getOutlet'] = $this->Constant_model->getOutlets();
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
		
		$data['getDailyCollection'] = $this->Constant_model->getDailyCollection();
		$this->load->view('includes/header');
		$this->load->view('pumps/daily_collection', $data);
		$this->load->view('includes/footer');
	}
	
	
	function print_daily_collection($id)
	{
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		$data['value'] = $this->Constant_model->getDailyCollectionPrint($id);
		$this->load->view('pumps/daily_collection_print', $data);
	}
	
	function changeBalanceCollection()
	{
		$pumperid		= $this->input->post('pumperid');
		$amount			= $this->pumps_model->changeBalanceCollection($pumperid);
		$data['amount'] = !empty($amount->totalamount)?$amount->totalamount:0;
		echo json_encode($data);
	}
	
	
	function InsertDailyCollection()
	{
		$data = array(
			'collection_form_no'	=> $this->input->post('collection_form_no'),
			'pumper_id'				=> $this->input->post('pumper_id'),
			'balance_collection'	=> $this->input->post('balance_collection'),
			'amount'				=> $this->input->post('amount'),
			'outlet_id'				=> $this->input->post('outlet_id'),
			'created_by'			=> $this->session->userdata('user_id'),
			'created_at'			=> $this->input->post('created_at'),
		);
		
		$id = $this->Constant_model->insertDataReturnLastId('daily_collection', $data);
		$this->session->set_flashdata('SUCCESSMSG', "Daily Collection Saved Successfully!!");
		redirect('pumps/print_daily_collection/'.$id.'');
	}

	public function tax_search() {
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$setting_dateformat = $paginationData[0]->datetime_format;
		$setting_currency = $paginationData[0]->currency;
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
		$data['esc_data'] = $this->db->get_where('esctax', array(
					'status' => 1
				))->result();
		if ($this->input->post()) {
			$startdate = $this->input->post('startdate');
			$status = $this->input->post('status');
			$outlet = $this->input->post('outlet');
			$tax_name = $this->input->post('tax_name');

			$enddate = $this->input->post('enddate');
			$this->db->where('created_at BETWEEN  "' . date('Y-m-d', strtotime($startdate)) . '" AND  "' . date('Y-m-d', strtotime($enddate)) . '"');

			$this->db->where("status", $status);
			$this->db->where("outlet_id", $outlet);
			$this->db->where("tax_name", $tax_name);

			$this->db->order_by("id", " ASC");
			$taxData = $this->db->get("purchase_taxes");
			$result = $taxData->result();
			$this->db->save_queries = false;
			$data['taxData'] = $result;
		}
		$outlet_data = $this->db->get_where('outlets', array(
					'status' => 1
				))->result();
		$data['outlet_dataa'] = $outlet_data;
		$this->load->view('pumps/esctax', $data);
	}

	public function insertTax() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='escTax')");

		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Add esc Tax',
				'You can not add esc Tax. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$date = $this->input->post('date');
		$tax_name = $this->input->post('tax_name');
		$percetage = $this->input->post('percetage');
		$status = $this->input->post('status');
		$loginUserId = $this->session->userdata('user_id');

		if (empty($tax_name) && empty($percetage) && empty($status)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Add Tax',
				'Please enter all fields!'
			));
			redirect(base_url() . 'pumps/esctax');
		} else {
			$data = array(
				'tax_name' => $tax_name,
				'tax_percentage' => $percetage,
				'status' => $status,
				'created_at' => $date,
				'created_by' => $loginUserId
			);

			if ($this->Constant_model->insertData('esctax', $data)) {
				$this->session->set_flashdata('alert_msg', array(
					'success',
					'Add Esc Tax',
					"Successfully Added Esc Tax : $tax_name"
				));
				redirect(base_url() . 'pumps/esctax');
			}
		}
	}

	public function edit_tax() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='escTax')");

		if (!isset($permission_data[0]->edit_right) || (isset($permission_data[0]->edit_right) && $permission_data[0]->edit_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Edit esc Tax',
				'You can not edit esc Tax. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
		$id = $this->input->get('id');
		$data['id'] = $id;
		$this->load->view('pumps/edit_tax', $data);
	}


	public function updateTax() {
		$tax_name = $this->input->post('tax_name');
		$percetage = $this->input->post('percetage');
		$status = $this->input->post('status');
		$loginUserId = $this->session->userdata('user_id');
		$id = $this->input->post('id');

		$us_id = $this->session->userdata('user_id');
		$tm = date('Y-m-d H:i:s', time());
		$data = array(
			'tax_name' => $tax_name,
			'tax_percentage' => $percetage,
			'status' => $status,
			'last_modefied_by' => $us_id,
			'last_modefied_at' => $tm
		);

		$this->Constant_model->updateData('esctax', $data, $id);
		$this->session->set_flashdata('alert_msg', array(
			'success',
			'Update Esc Tax',
			'Successfully Updated Esc Tax Detail!'
		));
		redirect(base_url() . 'pumps/edit_tax?id=' . $id);
	}


	public function delete_tax() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='escTax')");

		if (!isset($permission_data[0]->delete_right) || (isset($permission_data[0]->delete_right) && $permission_data[0]->delete_right != 1)) {
			$this->session->set_flashdata('alert_msg', array(
				'failure',
				'Delete esc Tax',
				'You can not delete esc Tax. Please ask administrator!'
			));
			redirect($this->agent->referrer());
		}

		$id = $this->input->get('id');

		if ($this->Constant_model->deleteData('esctax', $id)) {
			$this->session->set_flashdata('alert_msg', array(
				'success',
				'Delete Esc Tax',
				"Successfully Deleted Esc Tax."
			));
			redirect(base_url() . 'pumps/esctax');
		}
	}
}
?>