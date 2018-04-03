<?php
	class Pumps_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function index()
		{

		}
		
		
		public function getCustomerOutstanding($customer)
		{
			$outstanding = ($this->db->select('sum(unpaid_amt) as total')->from('orders_payment')->where('customer_id', $customer)->get()->row()->total);
			return !empty($outstanding)?$outstanding:0;
		}
		
		public function getPumpOperatorList()
		{
			$this->db->select('*');
			$this->db->from('pump_operators');
			if(!empty($this->input->get('operator_name')))
			{
				$this->db->where('operator_name',$this->input->get('operator_name'));
			}
			if(!empty($this->input->get('id')))
			{
				$this->db->where('id',$this->input->get('id'));
			}
			if(!empty($this->input->get('status')))
			{
				if($this->input->get('status') == 2)
				{
					$status = 0;
				}
				else
				{
					$status = 1;
				}
				$this->db->where('status',$status);
			}
			$query = $this->db->get();
			return $query->result(); 
		}
		
		public function getItemTemparary($settle_id)
		{
			$this->db->select('temporary_order_items.*,products.name as productname,products.id as product_id');
			$this->db->from('temporary_order_items');
			$this->db->join('products','products.code = temporary_order_items.product_code');
			$this->db->where('temporary_order_items.settlement_id',$settle_id);
			$query = $this->db->get();
		 	return $query->result();
		}
		
		public function getPumpName($pump_id)
		{
			$this->db->where('id',$pump_id);
			$query = $this->db->get('pumps');
		 	return !empty($query->row()->pump_name)?$query->row()->pump_name:'';
		}
		
		public function getTestingQty($pump_id,$settleid)
		{
			$this->db->where('pump_id',$pump_id);
			$this->db->where('settlement_id',$settleid);
			$query = $this->db->get('pump_testing');
		 	return $query->row();
		}
		
		public function SingleSettlementNumber($settle_id)
		{
			$query = $this->db->where('settlement_no',$settle_id);
			$query = $this->db->get('settlement');
		 	return $query->row();
		}
		
		public function getTransactionSettlement($settle_id)
		{
			$query = $this->db->where('settlement_id',$settle_id);
			$query = $this->db->get('transactions');
		 	return $query->result();
		}
		
		public function ViewDetailMainOrder($settle_id)
		{
			$this->db->select('orders.*,customers.fullname,customers.mobile');
			$this->db->from('orders');
			$this->db->join('customers','customers.id = orders.customer_id');
			$this->db->where('orders.settlement_no',$settle_id);
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}
		
		public function getOrderSettlement($settle_id)
		{
			$this->db->select('order_items.id,orders.outlet_id,order_items.product_code,order_items.ow_id,order_items.type,order_items.qty');
			$this->db->from('orders');
			$this->db->join('order_items','order_items.order_id = orders.id');
			$this->db->where('orders.settlement_no',$settle_id);
			$query = $this->db->get();
		 	return $query->result();
		}
		
//		public function getOrderSettlementTempory($settle_id)
//		{
//			$this->db->select('order_items.*');
//			$this->db->from('orders');
//			$this->db->join('order_items','order_items.order_id = orders.id');
//			$this->db->where('orders.settlement_no',$settle_id);
//			$query = $this->db->get();
//		 	return $query->result();
//		}
//		
//		public function UpdateMainOrder($settlement_no)
//		{
//			$this->db->set('status',0);	
//			$this->db->where('settlement_no',$settlement_no);	
//			$this->db->update('orders');	
//			return true;	
//		}
		
		
		public function RemoveOrder_Items($id)
		{
			$this->db->set('status',1);	
			$this->db->where('id',$id);	
			$this->db->update('order_items');	
			return true;
		}
		
//		public function UpdateOrderItem($id)
//		{
//			$this->db->set('status',0);	
//			$this->db->where('order_id',$id);	
//			$this->db->update('order_items');	
//			return true;
//		}
		
		
		public function RemoveOrder_Payment($id)
		{
			$this->db->set('status',1);	
			$this->db->where('id',$id);	
			$this->db->update('orders_payment');	
			return true;
		}
		
		public function RemoveSettelementNumber($settle_id)
		{
			$this->db->set('status',1);	
			$this->db->where('settlement_no',$settle_id);	
			$this->db->update('settlement');	
			return true;
		}
		
		public function UpdateSettelementNumber($settlement_no)
		{
			$this->db->set('status',0);	
			$this->db->where('settlement_no',$settlement_no);	
			$this->db->update('settlement');	
			return true;
		}
		
		public function DeleteInventoryInsert($delete_inventory_settlement)
		{
			$this->db->insert('delete_inventory_settlement',$delete_inventory_settlement);	
			return true;
		}
		
		public function DeletePumpReading($id)
		{
			$this->db->set('status',1);	
			$this->db->where('id',$id);	
			$this->db->update('pump_reading');	
			return true;
		}
		
//		public function UpdatePumpReadingSettle($settlement_no)
//		{
//			$this->db->set('status',0);	
//			$this->db->where('settlement_id',$settlement_no);	
//			$this->db->update('pump_reading');	
//			return true;
//		}
		
		
//		public function UpdatePumperReport($settlement_no)
//		{
//			$this->db->set('status',0);	
//			$this->db->where('settlement_receipt_no',$settlement_no);	
//			$this->db->update('pumper_report');	
//			return true;
//		}
		
		
		public function RemovePumpTesting($settle_id)
		{
			$this->db->set('status',1);	
			$this->db->where('settlement_id',$settle_id);	
			$this->db->update('pump_testing');	
			return true;
		}
		
//		public function UpdatePumpTesting($settlement_no)
//		{
//			$this->db->set('status',0);	
//			$this->db->where('settlement_id',$settlement_no);	
//			$this->db->update('pump_testing');	
//			return true;
//		}
//		
		
		
		public function getPumpData($pump_id)
		{
			$this->db->where('id',$pump_id);	
			$query = $this->db->get('pumps');	
			return $query->row();
		}
		
		public function UpdatePumpReading($pump_id,$final_last_meter_reading)
		{
			$this->db->set('last_meter_reading',$final_last_meter_reading);	
			$this->db->set('temp_meter_reading',$final_last_meter_reading);	
			$this->db->where('id',$pump_id);	
			$this->db->update('pumps');	
			return true;
		}
		
		
		
		public function RemoveMainOrder($settle_id)
		{
			$this->db->set('status',1);	
			$this->db->where('settlement_no',$settle_id);	
			$this->db->update('orders');	
			return true;
		}
		
		public function getPumpReading($settle_id)
		{
			$this->db->where('settlement_id',$settle_id);	
			$query = $this->db->get('pump_reading');	
			return $query->result();
		}
		
		
		public function getOrderPayment($settle_id)
		{
			$this->db->select('orders_payment.id,orders_payment.grandtotal,orders_payment.payment_method');
			$this->db->from('orders');
			$this->db->join('orders_payment','orders_payment.order_id = orders.id');
			$this->db->where('orders.settlement_no',$settle_id);
			$query = $this->db->get();
		 	return $query->result();
		}
		
		public function getPaymentData($payment_method)
		{
			$this->db->where('id',$payment_method);	
			$this->db->limit(1);	
			$query = $this->db->get('payment_method');	
			return $query->row();
		}
		
		public function UpdatePayment_MethodAmount($finalbalance,$payment_method)
		{
			$this->db->set('balance',$finalbalance);	
			$this->db->where('id',$payment_method);	
			$this->db->update('payment_method');	
			return true;
		}
		
		public function RemoveRecordTransaction($settle_id)
		{
			$this->db->set('status',1);	
			$this->db->where('settlement_id',$settle_id);	
			$this->db->update('transactions');	
			return true;
		}
		
		public function RemovePumperReport($settle_id)
		{
			$this->db->set('status',1);	
			$this->db->where('settlement_receipt_no',$settle_id);	
			$this->db->update('pumper_report');	
			return true;
		}
		
		public function RemoveRecordOrder($settle_id)
		{
			
		}
		
		public function getMeterResetting()
		{
			$this->db->select('meter_reset.*,pumps.pump_name,products.name as product_name,fuel_tanks.fuel_tank_number,outlets.name as outlet_name,users.fullname');	
			$this->db->from('meter_reset');	
			$this->db->join('pumps','pumps.id = meter_reset.pump_id','left');	
			$this->db->join('products','products.id = meter_reset.product_id','left');	
			$this->db->join('fuel_tanks','fuel_tanks.id = meter_reset.tank_id','left');	
			$this->db->join('outlets','outlets.id = meter_reset.outlet_id','left');	
			$this->db->join('users','users.id = meter_reset.created_at','left');	
			if(!empty($this->input->get('start_date')))
			{
				$this->db->where('DATE_FORMAT(meter_reset.created_date,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
			}
			if(!empty($this->input->get('end_date')))
			{
				$this->db->where('DATE_FORMAT(meter_reset.created_date,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
			}
			$query = $this->db->get();
			return $query->result();
		}
	
		
		function get_pumps()
		{
			if(!empty($this->input->get('start_date')))
			{
				$this->db->where('DATE_FORMAT(installation_date,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
			}
			if(!empty($this->input->get('end_date')))
			{
				$this->db->where('DATE_FORMAT(installation_date,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
			}
		 	$query = $this->db->get('pumps');
		 	return $query->result();
		}
		
		
		function getSettlement()
		{
			$this->db->select('settlement.*,outlets.name as outlets_name, pump_operators.operator_name');
			$this->db->from('settlement');
			$this->db->join('outlets','outlets.id  = settlement.outlet_id','left');
			$this->db->join('pump_operators','pump_operators.id  = settlement.pumper_id','left');
//			if(!empty($this->input->get('outlet')))
//			{
//				$this->db->where('settlement.outlet_id',$this->input->get('outlet'));
//			}
//			if(!empty($this->input->get('pumper')))
//			{
//				$this->db->where('settlement.pumper_id',$this->input->get('pumper'));
//			}
			
			if(!empty($this->input->get('type')))
			{
				if(!empty($this->input->get('start_date')))
				{
					$this->db->where('DATE_FORMAT(settlement.transaction_date,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
				}
				if(!empty($this->input->get('end_date')))
				{
					$this->db->where('DATE_FORMAT(settlement.transaction_date,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
				}
			}
			else
			{
				if(!empty($this->input->get('start_date')))
				{
					$this->db->where('DATE_FORMAT(settlement.created_at,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
				}
				if(!empty($this->input->get('end_date')))
				{
					$this->db->where('DATE_FORMAT(settlement.created_at,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
				}
			}
			$this->db->where_in('settlement.status',array(0,2));
			$query = $this->db->get();
		 	return $query->result();
		}
		
		
		
		function getDeletedSettlement()
		{
			$this->db->select('settlement.*,outlets.name as outlets_name, pump_operators.operator_name');
			$this->db->from('settlement');
			$this->db->join('outlets','outlets.id  = settlement.outlet_id','left');
			$this->db->join('pump_operators','pump_operators.id  = settlement.pumper_id','left');
			if(!empty($this->input->get('start_date')))
			{
				$this->db->where('DATE_FORMAT(settlement.created_at,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
			}
			if(!empty($this->input->get('end_date')))
			{
				$this->db->where('DATE_FORMAT(settlement.created_at,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
			}
			$this->db->where('settlement.status',1);
			$query = $this->db->get();
		 	return $query->result();
		}
		
		function get_FuelTank()
		{
			$this->db->select('fuel_tanks.*,products.name as productname,outlets.name as outletname');
			$this->db->from('fuel_tanks');
			$this->db->join('products','products.id = fuel_tanks.product_id','left');
			$this->db->join('outlets','outlets.id = fuel_tanks.outlet_id','left');
//			if(!empty($this->input->get('fuel_tank_number')))
//			{
//				$this->db->where('fuel_tanks.fuel_tank_number',$this->input->get('fuel_tank_number'));	
//			}
//			if(!empty($this->input->get('outlet')))
//			{
//				$this->db->where('fuel_tanks.outlet_id',$this->input->get('outlet'));	
//			}
//			if(!empty($this->input->get('start_date')))
//			{
//				$this->db->where('DATE_FORMAT(fuel_tanks.created,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
//			}
//			if(!empty($this->input->get('end_date')))
//			{
//				$this->db->where('DATE_FORMAT(fuel_tanks.created,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
//			}
			$query = $this->db->get();
		 	return $query->result();
		}
		
		public function getPumpOperatorAll()
		{
			$query = $this->db->get('pump_operators');
			return $query->result();
		}
		
		
		public function changeBalanceCollection($pumperid)
		{
			$this->db->select('SUM(amount) as totalamount,GROUP_CONCAT(id SEPARATOR ",") as concate_settle_id');
			$this->db->from('daily_collection');
			$this->db->where('pumper_id',$pumperid);
			$this->db->where('settlement_id','');
			$this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d")',date('Y-m-d'));
			$query = $this->db->get();
			return $query->row();
		}
		
		function OutletWiseProduct($outlet_id)
		{
			$query = $this->db->where('status','1');
			$query = $this->db->where('category','20');
			$query = $this->db->where('outlet_id_fk',$outlet_id);
			$query = $this->db->get('products');
		 	return $query->result();
		}

		function create_pump()
		{
			$config['upload_path']          = './assets/img/';
			$config['allowed_types']        = 'image/jpeg|gif|jpg|png';//gif|jpg|png|jpeg
			$config['max_size']             = 2000;

//			$this->load->library('upload', $config);
//			if(!$this->upload->do_upload('image_link'))
//			{
//				$error = array('error' => $this->upload->display_errors());
//				$this->session->set_flashdata('SUCCESSMSG', "Image Size only 100kb and below!!");
//				redirect('pumps/add_pump');
//			}
//			else
//			{
//				$data		= array('upload_data' => $this->upload->data());
				$pid		= $this->input->post("id_1");
				$ftids		= $this->input->post('typeahead');
				$get_tank	= $this->db->get_where('fuel_tanks',array('id'=>$ftids))->row();
				$product_id = $get_tank->product_id;
				
				$new_pump_data = array(
					'pump_name' => $this->input->post('pump_name'),
					'pump_no' => $this->input->post('pump_no'),
					'storage_tank' => $this->input->post('storage_tank'),
					'installation_date' => date('Y-m-d', strtotime(strip_tags($this->input->post('installation_date')))),
					'starting_meter' => $this->input->post('starting_meter'),
					'last_meter_reading' => $this->input->post('starting_meter'),
					'temp_meter_reading' => $this->input->post('starting_meter'),
					'outlet_id' => $this->input->post('outlet_id'),
					'fuel_tank_ids' => $this->input->post('typeahead'),
					'pid' => $product_id
				);

				$id = $this->Constant_model->insertDataReturnLastId('pumps', $new_pump_data);
//				upload_image('image_link',$this->input->post('pump_no'),'pumps','pumps',$id,'image_link',0);
				return $id;
//			}
		
		}
		
        function create_ft()
		{
			
			$pid				= $this->input->post("pid");
			$current_balance	= $this->input->post('current_balance');
			$outlet_id			= $this->input->post('outlet_id');
			
			$new_pump_data = array(
				'fuel_tank_number' => $this->input->post('fuel_tank_number'),
				'starting_volume' => $this->input->post('starting_volume'),
				'current_balance' => str_replace(",", "", $current_balance),
				'outlet_id' => $this->input->post('outlet_id'),
				'product_id' => $pid,
				'user_id'=>$this->session->userdata('user_id')
			);
			$id = $this->Constant_model->insertDataReturnLastId('fuel_tanks', $new_pump_data);
			
			$new_tank_reading = array(
				'tank_id'			=> $id,
				'outlet_id'			=> $this->input->post('outlet_id'),
				'total_tank_balance'=> $current_balance,
				'tank_qty'			=> $current_balance,
				'available_tank_qty'=> $current_balance,
				'purchase_qty'		=> 0,
				'created_by'		=> $this->session->userdata('user_id'),
				'created_date'      => date('Y-m-d H:i:s'),
				'status'			=> 2
			);
			$this->Constant_model->insertDataReturnLastId('fuel_tanks_reading', $new_tank_reading);
			
			$query =   $this->db->get_where('products',array('id'=>$pid))->row();
			$code  = $query->code;
			
			$get_product_report = $this->db->select('*');
			$get_product_report = $this->db->from('product_report');
			$get_product_report = $this->db->where('product_code',$code);
			$get_product_report = $this->db->order_by('id','desc');
			$get_product_report = $this->db->limit('1');
			$get_product_report = $this->db->get()->row();
			
			$opening_balance = $get_product_report->balance_qty + $current_balance;
			$product_balance = ($opening_balance + $get_product_report->purchase_qty) - $get_product_report->sales_qty;
			
			$product_report = array(
				'product_code'	=> $code,
				'opening_qty'	=> $opening_balance,
				'purchase_qty'	=> 0,
				'sales_qty'		=> 0,
				'balance_qty'   => $product_balance,
				'created_by'	=> $this->session->userdata('user_id'),
				'created_date'	=> date('Y-m-d H:i:s'),
			);
			
			$this->db->insert('product_report',$product_report);
			
			$checkinventory = $this->db->where('product_code',$code);
			$checkinventory = $this->db->where('outlet_id',$this->input->post('outlet_id'));
			$checkinventory = $this->db->where('ow_id',$id);
			$checkinventory = $this->db->where('type','1');
			$checkinventory = $this->db->get('inventory');
			$count_inventory = $checkinventory->num_rows();
			if($count_inventory>0)
			{
				$query1 = $checkinventory->row();
				$qty  = $query1->qty;
				$inventory_id  = $query1->id;
				$qty= $qty+$current_balance;
				$this->db->query("UPDATE inventory SET qty = $qty WHERE id = '".$inventory_id."' ");
				return $id;
			}
			else
			{
				$inventorydata = array('product_code' => $code,
					'outlet_id' => $this->input->post('outlet_id'),
					'qty' => $current_balance,
					'ow_id' => $id,
					'type' => '1',
					'date' => date('Y-m-d H:i:s'),
				);
				$this->db->insert('inventory',$inventorydata);
				return $id;
			}
			
			
			
			
		}
		
		function update_ft()
		{
			$id = $this->input->post('id');
			$pid				= $this->input->post("pid");
			$current_balance	= $this->input->post('current_balance');
			$outlet_id			= $this->input->post('outlet_id');
			
			$new_data = array(
				'fuel_tank_number' => $this->input->post('fuel_tank_number'),
				'product_id' => $pid,
				'outlet_id' => $outlet_id,
				'starting_volume' => $this->input->post('starting_volume'),
				'current_balance' => $current_balance,
			);
			$this->Constant_model->updateData('fuel_tanks', $new_data, $id);
			
			$query =   $this->db->get_where('products',array('id'=>$pid))->row();
			$code  = $query->code;
			
			$checkinventory = $this->db->where('product_code',$code);
			$checkinventory = $this->db->where('outlet_id',$this->input->post('outlet_id'));
			$checkinventory = $this->db->where('ow_id',$id);
			$checkinventory = $this->db->where('type','1');
			$checkinventory = $this->db->get('inventory');
			$count_inventory = $checkinventory->num_rows();
			if($count_inventory>0)
			{
				$query1 = $checkinventory->row();
				$qty  = $query1->qty;
				$inventory_id  = $query1->id;
				$qty= $qty + $current_balance;
				$this->db->query("UPDATE inventory SET qty = $qty WHERE id = '".$inventory_id."' ");
				return $id;
			}
		}
		
		function search_ft()
		{
			$pump_no = $this->input->get('pump_no');
			$pump_name = $this->input->get('pump_name');
			$category = $this->input->get('cid');
			
			$sort ="";
			if (!empty($pump_no)) {
		        $sort .= " AND pump_no LIKE '%$pump_no%' ";
		    }

		    if (!empty($pump_name)) {
		        $sort .= " AND pump_name LIKE '%$pump_name%' ";
		    }

		    if ($category != '') {
		        $sort .= " AND storage_tank = $category ";
		    }
		    
			$data = $this->db->query("SELECT * FROM pumps WHERE installation_date != '0000-00-00' $sort ORDER BY pump_name ASC ");
			return $data->result();	
			
		}
		           // ************************add to pumper report *******************//
        public function add_to_pumper_report($data){

			$query = $this->db->get_where('pump_operators',array("id"=>$data['pumper_id']))->row();
            $select_name = $query->operator_name;
            $commission_type = $query->commission_type;
            $commission_ap = $query->commission_ap;
            $Outlet_query = $this->db->get_where('outlets',array("id"=>$data['outlet_id']))->row();
            $select_outlet_name = $Outlet_query->name;
            //update fuel tank
//            $Pump_Query = $this->db->get_where('pumps',array("id"=>$data['pump_id']))->row();
//			  $select_fuel_tank = $Pump_Query->fuel_tank_ids;
//            $Fuel_tank_Query = $this->db->get_where("fuel_tanks",array('id'=>$select_fuel_tank))->row();
//            $select_current_balance = $Fuel_tank_Query->current_balance;
//            $now_balance = $select_current_balance - $data['qty'];
//            $data_tank = array("current_balance"=>$now_balance);
            
            //update inventory
            $Product_Query = $this->db->get_where('products',array("id"=>$data['product_id']))->row();
            $select_pcode = $Product_Query->code;
            $select_pname = $Product_Query->name;
			
//            $Inventry_Query = $this->db->get_where('inventory',array("product_code"=>$select_pcode,'outlet_id'=>$data['outlet_id'],'ow_id' =>$data['fuel_tank_ids'], 'type' => '1'))->row();
//			if(!empty($Inventry_Query))
//			{
//				$select_inventry_id = $Inventry_Query->id;
//				$select_qty = $Inventry_Query->qty;
//			}
//			else
//			{
//				$select_qty = 0;
//				$select_inventry_id = 0;
//			}
//           
//            $now_qty = $select_qty - $data['qty'];
//            $data_inventory = array("qty"=>$now_qty);
            
            
            $data = array(
                'fuel_type'				=> $data['product_id'],
                'product_name'			=> $select_pname,
                'pump_id_fk'			=> $data['pump_id'],
                'pump_fuel'				=>$data['qty'],
                'settlement_receipt_no' =>$data['settlement_receipt_no'],
                'commission_type'       =>$commission_type,
                'commission_rate'       =>$commission_ap,
                'outlet_id'				=>$data['outlet_id'],
                'outlet_name'			=>$select_outlet_name,
                'commission_amount'		=> $data['gtotal'],
                'sale_amount'			=> $data['sale_amount'],
                'pumper_id_fk'			=> $data['pumper_id'],
                'pumper_name'			=> $select_name,
                'created_by'			=> $data['created_by'],
                'orderDatetime'			=> $data['orderDatetime'],
                'customer_id'			=> $data['customer_id'],
                'status'				=> 0,
            );
            
//            $this->db->update("fuel_tanks",$data_tank,array("id"=>$select_fuel_tank));
//            $this->db->update("inventory",$data_inventory,array("id"=>$select_inventry_id));
            $res = $this->db->insert('pumper_report', $data);
			return true;
        }
		
		
		public function add_to_pumper_report_temporary($data)
		{
			$query = $this->db->get_where('pump_operators',array("id"=>$data['pumper_id']))->row();
            $select_name = $query->operator_name;
            $commission_type = $query->commission_type;
            $commission_ap = $query->commission_ap;
            $Outlet_query = $this->db->get_where('outlets',array("id"=>$data['outlet_id']))->row();
            $select_outlet_name = $Outlet_query->name;
            //update fuel tank
			
            $Product_Query = $this->db->get_where('products',array("id"=>$data['product_id']))->row();
            $select_pcode = $Product_Query->code;
            $select_pname = $Product_Query->name;

            $data = array(
                'fuel_type'				=> $data['product_id'],
                'product_name'			=> $select_pname,
                'pump_id_fk'			=> $data['pump_id'],
                'pump_fuel'				=>$data['qty'],
                'settlement_receipt_no' =>$data['settlement_receipt_no'],
                'commission_type'       =>$commission_type,
                'commission_rate'       =>$commission_ap,
                'outlet_id'				=>$data['outlet_id'],
                'outlet_name'			=>$select_outlet_name,
                'commission_amount'		=> $data['gtotal'],
                'sale_amount'			=> $data['sale_amount'],
                'pumper_id_fk'			=> $data['pumper_id'],
                'pumper_name'			=> $select_name,
                'created_by'			=> $data['created_by'],
                'orderDatetime'			=> $data['orderDatetime'],
                'customer_id'			=> $data['customer_id'],
                'status'				=> 2,
            );
			
			$res = $this->db->insert('pumper_report', $data);
			return true;
		}
		
		public function Testing_Detail()
		{
			$this->db->select("pump_testing.*,outlets.name as outletsname,products.name as productname,pumps.pump_name as pump_name, pumps.pump_name as pump_name, pump_operators.operator_name ");
			$this->db->from("pump_testing");
			$this->db->join("outlets","outlets.id = pump_testing.outlet_id",'left');
			$this->db->join("products","products.id = pump_testing.product_id",'left');
			$this->db->join("pumps","pumps.id = pump_testing.pump_id",'left');
			$this->db->join("pump_operators","pump_operators.id = pump_testing.pump_operators_id",'left');
			if(!empty($this->input->get('start_date')))
			{
				$this->db->where('DATE_FORMAT(pump_testing.created_at,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
			}
			if(!empty($this->input->get('end_date')))
			{
				$this->db->where('DATE_FORMAT(pump_testing.created_at,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
			}
            $this->db->where('pump_testing.status',0);
            $result = $this->db->get();
			return $result->result();
		}
		
		public function Pump_Reading()
		{
			$this->db->select("pump_reading.*,outlets.name as outletsname,products.name as productname,pumps.pump_name as pump_name");
			$this->db->from("pump_reading");
			$this->db->join("outlets","outlets.id = pump_reading.outlet_id",'left');
			$this->db->join("products","products.id = pump_reading.product_id",'left');
			$this->db->join("pumps","pumps.id = pump_reading.pump_id",'left');
			$this->db->where('pump_reading.status',0);
			if(!empty($this->input->get('start_date')))
			{
				$this->db->where('DATE_FORMAT(pump_reading.created_at,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
			}
			if(!empty($this->input->get('end_date')))
			{
				$this->db->where('DATE_FORMAT(pump_reading.created_at,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
			}
            $result = $this->db->get();
			return $result->result();
		}
		
		
			public function Fuel_Reading()
			{
				$this->db->select("fuel_tanks_reading.*,outlets.name as outletsname,fuel_tanks.fuel_tank_number");
				$this->db->from("fuel_tanks_reading");
				$this->db->join("outlets","outlets.id = fuel_tanks_reading.outlet_id",'left');
				$this->db->join("fuel_tanks","fuel_tanks.id = fuel_tanks_reading.tank_id",'left');
				if(!empty($this->input->get('start_date')))
				{
					$this->db->where('DATE_FORMAT(fuel_tanks_reading.created_date,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
				}
				if(!empty($this->input->get('end_date')))
				{
					$this->db->where('DATE_FORMAT(fuel_tanks_reading.created_date,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
				}
				$result = $this->db->get();
				return $result->result();
			}
		
		
		public function GetFuelSaleReport()
		{
			$this->db->select('pumper_report.*,pumps.pump_name,pump_operators.operator_name');
			$this->db->from('pumper_report');
			$this->db->join('pumps','pumps.id = pumper_report.pump_id_fk','left');
			$this->db->join('pump_operators','pump_operators.id = pumper_report.pumper_id_fk','left');
			if(!empty($this->input->get('start_date')))
			{
				$this->db->where('DATE_FORMAT(pumper_report.orderDatetime,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
			}
			if(!empty($this->input->get('start_date')))
			{
				$this->db->where('DATE_FORMAT(pumper_report.orderDatetime,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
			}
			$this->db->where('pumper_report.status', 0);
			$this->db->order_by('pumper_report.id', 'DESC');
			$query = $this->db->get();
			return $query->result();
		}
		
		public function GetFuelSaleReportProductWsie()
		{
			$this->db->select('*, SUM(sale_amount) as amount, SUM(pump_fuel) as qty ');
			$this->db->from('pumper_report');
			$this->db->group_by('fuel_type');
			$this->db->where('status', 0);
			$query = $this->db->get();
			return $query->result();
		}
		
		
		public function getWarehosueData($fuel_tank_ids)
		{
			$this->db->select('stores.s_id,stores.s_stock');
			$this->db->from('outlet_warehouse');
			$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
			$this->db->where('outlet_warehouse.ow_id',$fuel_tank_ids);
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}
				
		public function UpdateInventoryQty($inventory_final_qty,$inventory_id)
		{
			$this->db->set('qty',$inventory_final_qty);
			$this->db->where('id',$inventory_id);
			$this->db->update('inventory');
			return true;
		}
		
		public function getTankData($fuel_tank_ids)
		{
			$this->db->where('id',$fuel_tank_ids);
			$this->db->limit(1);
			$query = $this->db->get('fuel_tanks');
			return $query->row();
		}
		
		public function UpdateWareHouseQty($warehouse_qty,$s_id)
		{
			$this->db->set('s_stock',$warehouse_qty);
			$this->db->set('s_stock_upated',$warehouse_qty);
			$this->db->where('s_id',$s_id);
			$this->db->update('stores');
			return true;
		}
		
		public function UpdateTankQty($tank_qty,$tank_id)
		{
			$this->db->set('current_balance',$tank_qty);
			$this->db->where('id',$tank_id);
			$this->db->update('fuel_tanks');
			return true;
		}
		
}
?>