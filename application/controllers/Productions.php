<?php 
Class Productions extends CI_Controller{


public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Gold_module');
        $this->load->model('Customers_model');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');
        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();
        $setting_timezone = $settingData->timezone;
        date_default_timezone_set("$setting_timezone");
		if($this->session->userdata('user_id') == "")
		{
			redirect(base_url());
		}
    }

	public function add_production()
    {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='all_production')");
		
		if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add production', 'You can not add production. Please ask administrator!'));
				redirect($this->agent->referrer());
		}
		
        $format_array = ci_date_format();
        $single_status['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $single_status['site_currency'] = $format_array['siteSetting_currency'];
        $single_status['dateformat'] = $format_array['dateformat'];
        $single_status['rjo'] =$this->Gold_module->select_all('refined_job_order');
        $single_status['warehouse'] =$this->Gold_module->select_all('stores');
        $single_status['grades'] =$this->Gold_module->select_all('gold_grade');
        $single_status['goldsmith'] =$this->Gold_module->select_all('gold_smith');
        $single_status['outlets'] =$this->Gold_module->select_all('outlets');
        $single_status['products'] =$this->Gold_module->select_all('gold_products');
        $single_status['user_role']=   $this->session->userdata('user_role');
        $this->load->view('includes/header');
        $this->load->view('gold/production',$single_status);
        $this->load->view('includes/footer');
    }
	
	
	public function add_work_job_order()
	{
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='all_production')");
		
		if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add production', 'You can not add production. Please ask administrator!'));
				redirect($this->agent->referrer());
		} 
       
		$single_status['goldsmith'] =$this->Gold_module->select_all('gold_smith');
		$single_status['outlets'] =$this->Gold_module->select_all('outlets');
		$single_status['user_id']=   $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $single_status['user_id']))->row();
		$single_status['logged_name'] = $get_logged_name->fullname;
		$single_status['JobOrderNumber'] = $this->Gold_module->getJobOrderNumber();
		$single_status['product_code'] = $this->Constant_model->getDataAll('products', 'id', 'ASC');
		$single_status['customer_val'] = $this->Constant_model->getDataAll('customers', 'id', 'ASC');
		$single_status['getCreditLimit'] = $this->Customers_model->getCreditCust_list();
		$single_status['UnCompleteOrder'] = $this->Gold_module->UnCompleteOrder();
        $this->load->view('includes/header');
        $this->load->view('gold/work_job_order',$single_status);
        $this->load->view('includes/footer');
    }
	
	
	
	
//	function get_customer_view(){
//		$json = array();
//		$id   =  $this->input->post('data');
//		$result = $this->Gold_module->UnCompleteOrder($id);
//		$html='';
//		$html.='<option value="">Select Customer Order</option>';
//		foreach($result as $data)
//		{
//			$html.='<option value='.$data->gold_id.'>'.$data->gold_id.'</option>';
//		}
//		
//		$json['result_data'] = $html;
//		echo json_encode($json);
//	}	
	
	function getgoldOrderItem()
	{
		$html = '';
		$id   =  $this->input->post('data');
		$customer_id =  $this->input->post('customer_id');
		
		$deliverdate = $this->Gold_module->getOrderDeliveryDate($id);
		
		$result = $this->Gold_module->getgoldOrderItem($id);
		$html.='<option value="">Select Product</option>';
		foreach ($result  as $value)
		{
			$select = '';
			if(!empty($value->product_code))
			{
				$select = '['.$value->product_code.']';	
			}
			$html.='<option value="'.$value->id.'">'.$value->product_name.' '.$select.'</option>';
		}
		
		$cus = $this->Gold_module->getCustomersingle($customer_id);
		$customer = '';
		$customer.= '<option value="">Choose Customer</option>';
		$customer.= '<option selected value='.$cus->id.'>'.$cus->fullname.'</option>';
		
		$json['success'] = $html;
		$json['customer'] = $customer;
		$json['deliverydate'] = $deliverdate;
		echo json_encode($json);
	}
	
	function getValuegoldsmith()
	{
		$id   =  $this->input->post('val');
		$result = $this->Gold_module->getValuegoldsmith($id);
		$json['success'] = $result;
		echo json_encode($json);
	}
	
	function getProductCodeDetail()
	{
		$id  =  $this->input->post('code');
		$result = $this->Gold_module->getGoldItemDetailSignle($id);
		$json['weight'] = $result->weight;
		$json['totalQty'] = $result->qty;
//		$json['images'] = ' <img style="height:63px; width:63px;" src="'.base_url().'product_image/'.$result->product_image.'">';
		$json['images'] = '<a class="fancybox" href="'.base_url().'product_image/'.$result->product_image.'" title="Product Image"><img style="height:65px; width:100%;display: block; cursor: pointer;" src="'.base_url().'product_image/'.$result->product_image.'"  alt="image" /></a>';
		echo json_encode($json);
	}
	
	public function insertWork_job()
	{
		
		
		if(!empty($this->input->post('workjob')))
		{
			
			$mainarray = array(
					'customer_id' => $this->input->post('customer_id'),
					'create_date' => date('Y-m-d H:i:s'),
					'job_order_no' => $this->input->post('job_order_no'),
					'outlet_id' => $this->input->post('out'),
					'gold_smith_id' => $this->input->post('goldsmith'),
					'customer_order_no' => $this->input->post('customer_order_no'),
					'order_delivery_date' => $this->input->post('order_delivery_dt'),
					'TotalQty' => $this->input->post('TotalQty'),
					'TotalRequiredQty' => $this->input->post('TotalRequiredQty'),
					'TotalCurrentWeight' => $this->input->post('TotalCurrentWeight'),
					'TotalUnitWeight' => $this->input->post('TotalUnitWeight'),
					'TotalGoldforGoldsmith' => $this->input->post('TotalGoldforGoldsmith'),
					'item_details' => $this->input->post('item_details'),
					'created_user_id'		=>	$this->session->userdata('user_id'),
				);
			
			
			$this->Constant_model->insertData('main_work_job_order', $mainarray);
			foreach ($this->input->post('workjob') as $value)
			{
				$ins_data = array(
					'create_date'			=>	date('Y-m-d H:i:s'),
					'job_order_no'			=>	$this->input->post('job_order_no'),
					'outlet_id'				=>	$this->input->post('out'),
					'gold_smith_id'			=>	$this->input->post('goldsmith'),
					'customer_id'			=>	$this->input->post('customer_id'),
					'customer_order_no'		=>	$this->input->post('customer_order_no'),
					'product_code_id'		=>	$value['SelectItemid'],
					'product_qty'			=>	$value['qty'],
					'weight_bluk_store_product' => $value['WeightShowroomProduct'],
					'weight_each_product'	=>	$value['RequiredUnitWeight'],
					'qty'					=>	$value['RequiredQty'],
					'item_details'			=>	$this->input->post('item_details'),
					'gold_qty_goldsmith'	=>	$value['GoldQtyforGoldsmith'],
					'order_delivery_date'	=>	$this->input->post('order_delivery_dt'),
					'created_user_id'		=>	$this->session->userdata('user_id'),
				);
				
				$this->Constant_model->insertData('work_job_order', $ins_data);
				$Gold_item_id = $value['SelectItemid'];
				$this->db->query("UPDATE order_items_gold set work_completd_status = 1 WHERE id=$Gold_item_id");
				
				
				$gold_smit_Query = $this->db->get_where("gold_smith",array('gs_id'=>$this->input->post('goldsmith')))->row();
				
				$select_current_balance = $gold_smit_Query->opening_gold_qty;
				$now_balance = $select_current_balance + $value['GoldQtyforGoldsmith'];
				$total_weight_balance = $select_current_balance + $value['GoldQtyforGoldsmith'];
				$data_gold_smith = array("opening_gold_qty"=>$now_balance);
				
				$this->db->update("gold_smith",$data_gold_smith , array("gs_id" => $this->input->post('goldsmith')));
				
				$new_weight_reading = array(
					'gold_smith_id'			=> $this->input->post('goldsmith'),
					'total_weight_balance'	=> $total_weight_balance,
					'available_weight_qty'	=> $now_balance,
					'weight_qty'			=> $value['GoldQtyforGoldsmith'],
					'purchase_qty'			=> $value['GoldQtyforGoldsmith'],
					'created_by'			=> $this->session->userdata('user_id'),
					'created_date'			=> date('Y-m-d H:i:s')
				);

				$this->Constant_model->insertData('goldsmith_transaction', $new_weight_reading);
				
			}
		}
			
		
		$this->session->set_flashdata('alert_msg', array('success', 'Add Work & Job', "Successfully Added New Work & No : '".$this->input->post('job_order_no')."'", '', '', '', '', ''));
		$json['success'] = true;
		echo json_encode($json);
	}

	
	public function producation_receive()
	{
		$permisssion_url = 'producation_receive';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
  		$data['wastage']		= $this->Gold_module->multiple_joins('wastage_product_gold','gold_smith','gold_products','pro_subcategory_gold');
		$data['user_role']		= $this->session->userdata('user_role');
		$data['goldsmith']		= $this->Gold_module->select_all('gold_smith');
		
		$data['getOutlet']		= $this->Gold_module->select_all('outlets');
		$data['gold_products']	= $this->Gold_module->select_all('gold_products');
		$data['getProducationReceive']	= $this->Gold_module->getProducationReceive();
		
		$this->load->view('includes/header');
        $this->load->view('gold/list_producation_receive',$data);
        $this->load->view('includes/footer');
	
	}
	
	
	public function print_received_work_orders()
	{
		$id		= $this->input->get('id');
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		$data['value'] = $this->Gold_module->getProducationPrintReceive($id);
		$this->load->view('gold/print_received_work_orders', $data);
	}
	

		


		public function save_production()
		{

				$len = $this->input->post('other1');
				$names = $this->input->post('other_name');
				for($i=0;$i<count($len);$i++){

				$other_data = array('pro_reference_id'=>$this->input->post('reference'),'other_name'=>$names[$i],'other_cost'=>$len[$i],'date_created'=>$this->input->post('gpro_name'));
				$data = $this->Gold_module->insert_data('other_cost_and_name',$other_data);
				}


                  $array_data =  array(
                     'pro_reference'=>$this->input->post('reference'),        
                     'pro_out_id'=>$this->input->post('out'),
                     'goldsmith'=>$this->input->post('goldsmith'),
                     'pro_date_created'=>$this->input->post('gpro_name'),
                     'pro_type'=>$this->input->post('type'),
                     'pro_qty'=>$this->input->post('qty'),
                     'pro_ware'=>$this->input->post('ware'),
                     'pro_grade'=>$this->input->post('grade'),
                     'pro_wastage'=>$this->input->post('wastage'),
                     'pro_total_product'=>$this->input->post('total_product'),
                     'pro_otherweight'=>$this->input->post('otherweight'),
                     'pro_wastage_cal'=>$this->input->post('wastage_cal'),
                     'pro_total_gold_wastage'=>$this->input->post('total_gold_wastage'),
                     'pro_goldsmith_was'=>$this->input->post('goldsmith_was'),
                     'pro_date'=>date('Y-m-d'),
                     'design_cost'=>$this->input->post('design-cost'),
                     'stone_cost'=>$this->input->post('stone-cost'),
                     'labour_unit_cost'=>$this->input->post('labourunit'),
                     'labour_cost'=>$this->input->post('labourtotal'),
                      'day_price'=>$this->input->post('day_price'),
                    );


                  $data = $this->Gold_module->insert_data('production',$array_data);
                  $this->output->set_content_type('application/json')->set_output(json_encode($data));


		}


		function all_production()
		{
			$permisssion_url = 'all_production';
			$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);

			if($permission->view_menu_right == 0)
			{
				redirect('dashboard');
			}
			$data['production']  = $this->Gold_module->production_join('production','gold_smith','stores','outlets');
			$data['others'] = $this->Gold_module->select_all('other_cost_and_name');

			$this->load->view('includes/header');
			$this->load->view('gold/production_list',$data);

			$this->load->view('includes/footer');


		}


	function all_work_job_order(){

	
		$permisssion_url = 'all_work_job_order';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}

		$data['work_job_order']  = $this->Gold_module->getworkjobOrder();
		
		$this->load->view('includes/header');
		$this->load->view('gold/list_work_job_order',$data);
		$this->load->view('includes/footer');


	}
	
	
	
	public function getGoldSmithWiseReceive_job()
	{
		$html = '';
		$goldsmith_id = $this->input->post('goldsmith_id');
		$work_job = $this->Gold_module->getGoldSmithWiseReceive($goldsmith_id);
			$html.= '<option value="">Select Receive Job Order No</option>';
			foreach ($work_job as $work_val)
			{
				$selected = '';
				$html.= '<option '.$selected.' data-val="0" value='.$work_val->id.'>'.$work_val->gold_smith_id.'</option>';
			}
		
			$json['success'] = $html;
			echo json_encode($json);
	}
	public function getMainworkjobWiseSubworkjobProduct()
	{
		$html = '';
		$main_wokorder_id = $this->input->post('main_wokorder_id');
		$getproduct = $this->Gold_module->getMainworkjobWiseSubworkjobProduct($main_wokorder_id);
			$html.= '<option value="">Select Item</option>';
			foreach ($getproduct as $product_val)
			{
				$selected = '';
				$html.= '<option '.$selected.' data-val="0" value='.$product_val->order_item_gold_id.'>'.$product_val->product_name.'</option>';
			}
		
			$json['success'] = $html;
			echo json_encode($json);
	}
	public function getProducttodeatilsItem()
	{
		
		$main_wokorder_id = $this->input->post('order_items_gold_id');
		if(!empty($main_wokorder_id))
		{
		$getorder_items_gold = $this->Gold_module->getdataorderitem($main_wokorder_id);
//		$getorder_items_gold = $this->db->get_where('order_items_gold', array('id' => $main_wokorder_id))->row();
		$json['order_items_gold_weight']=!empty($getorder_items_gold->weight)?$getorder_items_gold->weight:'';
		$json['order_items_gold_qty']=!empty($getorder_items_gold->qty)?$getorder_items_gold->qty:'';
		$json['order_items_gold_grade_name']=!empty($getorder_items_gold->grade_name)?$getorder_items_gold->grade_name:'';
		}
		else
		{
			$json['order_items_gold_weight']='';
			$json['order_items_gold_qty']='';
			$json['order_items_gold_grade_name']='';
		}
		echo json_encode($json);
	}
	public function getoutletwiseStore()
	{
		$html = '';
		$outlet_id= $this->input->post('outlet_id');
		$store_outwise = $this->Gold_module->getoutletwiseStore($outlet_id);
		$Defaultstore_outwise = $this->Gold_module->DefaultgetoutletwiseStore();
			$html.= '<option value="">Select Choice</option>';
			$html.= '<option  data-val="0" value='.$Defaultstore_outwise->s_id.'>'.$Defaultstore_outwise->s_name.'</option>';
			foreach ($store_outwise as $store_val)
			{
				$selected = '';
				$html.= '<option '.$selected.' data-val="0" value='.$store_val->s_id.'>'.$store_val->s_name.'</option>';
			}
			
		
			$json['success'] = $html;
			echo json_encode($json);
	}
	
	public function getRecevicewiseDetails()
	{
		$json = array();
		$receive_id= $this->input->post('receive_id');

		$work_job_data= $this->Gold_module->getDataWork_job($receive_id);
		
		if(!empty($work_job_data->row()))
		{
			$json['status']	=True;
			$json['customer_order_no']	= $work_job_data->row()->customer_order_no;
			$json['order_delivery_date'] = $work_job_data->row()->order_delivery_date;
		}
		else
		{
			$json['error']	=True;
			
		
		}
		echo json_encode($json);
	}
	
	public function receive_WorkJob_add()
	{
		
		$us_id = $this->session->userdata('user_id');
		$save_print =$this->input->post('save_printvalue');//1 redirect print
			$data = array(
					'create_date' =>date('Y-m-d H:i:s'),
					'outlet_id' => $this->input->post('out'),
					'goldsmith' => $this->input->post('goldsmith'),
					'receive_job_sel_no'=>$this->input->post('receive_job_order_no'),
					'note'=>$this->input->post('note'),
					'customer_order_no'=>$this->input->post('main_wokorder_id'),
					'receiving_store'=>$this->input->post('receiving_store'),
//					'order_delivery_date'=>date('Y-m-d H:i:s',strtotime($this->input->post('order_delivery_date'))),
					'finish_product_item'=>$this->input->post('finish_product_item'),
					'gold_grade'=>$this->input->post('gold_grade'),
					'item_weight' => $this->input->post('item_weight'),
					'weight_item' => $this->input->post('weight_item'),
					'qty'=>$this->input->post('qty'),
					'receive_qty'=>$this->input->post('receive_qty'),
					'product_category'=>$this->input->post('product_category'),
					'receive_weight_item' => $this->input->post('receive_weight_item'),
					'wastage'=>$this->input->post('Wastage_add'),
					'total_wastage'=>$this->input->post('wastage'),
					'stone_weight'=>$this->input->post('stone_weight'),
					'labour_cost'=>$this->input->post('labour_cost'),
					'note_details'=>$this->input->post('note_details'),
					'item_details'=>$this->input->post('item_details'),
					'created_user_by'=>$us_id,
					);
		
				$last_id = $this->Constant_model->insertDataReturnLastId('work_job_order_receive', $data);
				$json['last_id']=$last_id;
				$json['status']=$save_print;
				echo json_encode($json);
	}

	
	public function print_invoice_receive_job() {
		$id = $this->input->get('id');
        $data['setting_logo'] = $this->db->get_where('site_setting')->row();
		$data['getmainOrder']=$this->db->get_where('work_job_order_receive', array('id' => $id))->row();
		$data['getwork_job_order_receive']=$this->Gold_module->getDataReceiveJob($id);
		$data['new_sys_settings'] = ci_set_settings();
		$data['order_id']=$id;
		$data['getPaymentOrder']=0;
		$this->load->view('Gold/print_invoice_receive_job', $data);
	}
	public function view_invoice_receiveJob_a4() {
		$id = $this->input->get('id');
        $data['setting_logo'] = $this->db->get_where('site_setting')->row();
		$data['getmainOrder']=$this->db->get_where('work_job_order_receive', array('id' => $id))->row();
		$data['getwork_job_order_receive']=$this->Gold_module->getDataReceiveJob($id);
		$data['new_sys_settings'] = ci_set_settings();
		$data['order_id']=$id;
		$data['getPaymentOrder']=0;
		$this->load->view('Gold/print_invoice_a4_receive_job', $data);
	}	
	
	
	
	
	function receive_work_job_order(){
		$permisssion_url = 'receive_work_job_order';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
        if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$single_status['goldsmith'] =$this->Gold_module->select_all('gold_smith');
		$single_status['outlets'] =$this->Gold_module->select_all('outlets');
		$single_status['user_id']=   $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $single_status['user_id']))->row();
		$single_status['logged_name'] = $get_logged_name->fullname;
		$single_status['getreceive_no'] = $this->Gold_module->getrecevie_jobOrder();
		$single_status['JobOrderNumber'] = $this->Gold_module->getJobOrderNumber();
		$single_status['product_item'] = $this->Constant_model->getDataAll('products', 'id', 'ASC');
		$single_status['product_category'] = $this->Constant_model->getDataAll('category', 'id', 'ASC');
		$single_status['work_order_no'] = $this->Constant_model->getDataAll('main_work_job_order', 'id', 'ASC');
		$this->load->view('includes/header');
		$this->load->view('gold/receive_work_job_order',$single_status);
		$this->load->view('includes/footer');
	}
	function goldsmith_wastage(){
		$permisssion_url = 'goldsmith_wastage';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
        if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['user_id']=   $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $data['user_id']))->row();
		$data['logged_name'] = $get_logged_name->fullname;
		$data['goldsmith'] =$this->Gold_module->select_all('gold_smith');
		$data['outlets'] =$this->Gold_module->select_all('outlets');
		$data['category'] =$this->Gold_module->select_all('category');
		$this->load->view('includes/header');
		$this->load->view('gold/goldsmith_wastage',$data);
		$this->load->view('includes/footer');
	}
	
	//subcategioryget
	public function getSubCategoryGoldsmith()
	{
		$html = '';
		$category_id = $this->input->post('category_id');
		$selected_subcategory = $this->input->post('selected_subcategory');
		$sub = $this->Gold_module->getSubCategoryGoldsmith($category_id);
		$html.='<option value="">Select Sub Category</option>'; 
		foreach ($sub as $result)
		{
			$selected = '';
			if($selected_subcategory == $result->id)
			{
				$selected = 'selected';
			}
			$html.='<option '.$selected.' value='.$result->id.'>'.$result->sub_category.'</option>';
		}
		$json['subcategory'] = $html;
		echo json_encode($json);
	}
	
	
	function work_job_view_detail()
	{
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		$detail_id = $this->input->get('id');
		$data['main_work_job'] = $this->Gold_module->getWorkJobMainDetails($detail_id);
		$data['view_job'] = $this->Gold_module->getdetailvieworder($detail_id);
		$this->load->view('gold/view_work_job_detail', $data);
	}
	
	
	function print_invoice_work_job()
	{
	
        $data['setting_logo'] = $this->db->get_where('site_setting')->row();
		$detail_id = $this->input->get('id');
		$data['detail_id']=$detail_id;
		$data['getmainOrder'] = $this->Gold_module->getWorkJobMainDetails($detail_id);
		$data['view_job'] = $this->Gold_module->getdetailvieworder($detail_id);
		$this->load->view('gold/print_invoice_work_job', $data);
	}
	
	function print_invoice_work_joba4()
	{
	
        $data['setting_logo'] = $this->db->get_where('site_setting')->row();
		$detail_id = $this->input->get('id');
		$data['detail_id']=$detail_id;
		$data['getmainOrder'] = $this->Gold_module->getWorkJobMainDetails($detail_id);
		$data['view_job'] = $this->Gold_module->getdetailvieworder($detail_id);
		$this->load->view('gold/print_invoice_work_joba4', $data);
	}

function get_price(){
  $condition   =  array('grade_id'=>$this->input->post('data'));
  $data = $this->Gold_module->edit_specific_data('gold_grade',$condition);
  $this->output->set_content_type('application/json')->set_output(json_encode($data));
}

function get_jobno(){
  $condition   =  array('gold_smith_id'=>$this->input->post('data'),'status'=>'pending');
  $data['rjos'] = $this->Gold_module->get_all_data_specific_id('refined_job_order',$condition);
$data_['message'] =   $this->load->view('jobs.php',$data,TRUE);
  $this->output->set_content_type('application/json')->set_output(json_encode($data_));
}
function get_netweight(){
  $condition   =  array('rjo'=>$this->input->post('data'));
  $data = $this->Gold_module->get_all_data_specific_id_join('refined_job_order',$condition);
  $this->output->set_content_type('application/json')->set_output(json_encode($data));
}


function get_customer_credit(){
  $condition   =  array('id'=>$this->input->post('data'));

  $data['stores'] = $this->Gold_module->getwarehouse('outlet_warehouse',$condition);
$data['message1'] =   $this->load->view('gold/store_name.php',$data,TRUE);
 $this->output->set_content_type('application/json')->set_output(json_encode($data));
}



function get_subproduct(){
  $condition   =  array('product_id'=>$this->input->post('data'));

  $data['stores'] = $this->Gold_module->select_all_con('pro_subcategory_gold',$condition);
$data['message1'] =   $this->load->view('gold/subcate_name.php',$data,TRUE);
 $this->output->set_content_type('application/json')->set_output(json_encode($data));
}


function get_gold_day_price(){


//   $condition   =  array('gp_grade'=>$this->input->post('data'),'gp_date'=>date('Y-m-d'));
$condition   =  array('gp_grade'=>$this->input->post('data'));
  $data = $this->Gold_module->get_day_price('gold_prices',$condition);
  $this->output->set_content_type('application/json')->set_output(json_encode($data));

}




function get_wastage_gram(){


//   $condition   =  array('gp_grade'=>$this->input->post('data'),'gp_date'=>date('Y-m-d'));
  $condition   =  array('gs_id'=>$this->input->post('data'));
  $data = $this->Gold_module->get_record_by_id('gold_smith',$condition);
  $this->output->set_content_type('application/json')->set_output(json_encode($data));

}

	function add_gold_product_wastage()
	{

		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='list_goldsmith_wastage')");

		if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add list goldsmith wastage', 'You can not add list goldsmith wastage. Please ask administrator!'));
				redirect($this->agent->referrer());
		}

		$data['goldsmith'] = $this->Gold_module->select_all('gold_smith');
		$data['gold_products'] = $this->Gold_module->select_all('gold_products');
		$this->load->view('includes/header');
		$this->load->view('gold/add_gold_product_wastage',$data);
		$this->load->view('includes/footer');
	}


function save_wastage(){
    
    $data1  =  array('was_datetime'=>$this->input->post('gpro_name') ,'date'=>date('Y-m-d'),'how_created'=>$this->session->userdata('user_id'),'reference'=>$this->input->post('reference') ,'goldsmith_id'=>$this->input->post('goldsmith') ,'pro_id'=>$this->input->post('out') ,'sub_id'=>$this->input->post('sub') ,'wastage_amount'=>$this->input->post('wastage'));
    $data = $this->Gold_module->insert_data('wastage_product_gold',$data1);
       $this->output->set_content_type('application/json')->set_output(json_encode($data));
    
}
function list_goldsmith_wastage(){
    

		$permisssion_url = 'list_goldsmith_wastage';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
  
$data['wastage'] = $this->Gold_module->multiple_joins('wastage_product_gold','gold_smith','gold_products','pro_subcategory_gold');
$data['user_role']=   $this->session->userdata('user_role');
$data['goldsmith'] = $this->Gold_module->select_all('gold_smith');
$data['gold_products'] = $this->Gold_module->select_all('gold_products');
$this->load->view('includes/header');
$this->load->view('gold/list_goldsmith_wastage',$data);
$this->load->view('includes/footer');
}


function get_subproduct_wastage(){

    $con  =array();
    
  
    if(!empty($this->input->post('gold'))){
        if($this->input->post('gold')=='all'){
            
        }
     else{
         $con['goldsmith_id'] = $this->input->post('gold');
     }
 }
 
 if(!empty($this->input->post('out'))){
     if($this->input->post('gold')=='all'){
            
        }else{
     $con['pro_id'] = $this->input->post('out');
        }
 }
 
 if(!empty($this->input->post('sub'))){
     if($this->input->post('gold')=='all'){
            
        }else{
     $con['sub_id'] = $this->input->post('sub');
        }
 }
 
 
 $length = count($con);
 if($length>0){
  $data1['wastage'] = $this->Gold_module->multiple_joins_con('wastage_product_gold','gold_smith','gold_products','pro_subcategory_gold',$con);
 }else{
      $data1['wastage'] = $this->Gold_module->multiple_joins('wastage_product_gold','gold_smith','gold_products','pro_subcategory_gold');

}
$data['message1'] =   $this->load->view('gold/wastage_ajax.php',$data1,TRUE);
 $this->output->set_content_type('application/json')->set_output(json_encode($data));
 
}




function edit(){
	
	$user_id = $this->session->userdata('user_id');
	$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='list_goldsmith_wastage')");
	
	if(!isset($permission_data[0]->edit_right)|| (isset($permission_data[0]->edit_right) && $permission_data[0]->edit_right!=1)){
		$this->session->set_flashdata('alert_msg', array('failure', 'Edit list goldsmith wastage', 'You can not edit list goldsmith wastage. Please ask administrator!'));
            redirect($this->agent->referrer());
	}
	
    $con = array('w_id'=>$this->input->post('data'));
    
       $res['wastage'] = $this->Gold_module->get_record_by_id('wastage_product_gold',$con);
           
            
               $cate = $res['wastage']['message']->sub_id;
               $pro = $res['wastage']['message']->pro_id;
               $gold = $res['wastage']['message']->goldsmith_id;
               
                     $res['product'] = $this->Gold_module->get_record_by_id('gold_products',array('gpro_id'=>$pro));
                     $res['category'] = $this->Gold_module->get_record_by_id('pro_subcategory_gold',array('pro_cate_id'=>$cate));
                      $res['goldsmith'] = $this->Gold_module->get_record_by_id('gold_smith',array('gs_id'=>$gold));
    
    
   // $res = $this->Gold_module->updated_data('gold_grade',$array_data ,$update_con);       
   $this->output->set_content_type('application/json')->set_output(json_encode($res));
    
}


function update_wastage(){
    $counter = 0;
    $con = array();
    
     $con = array('w_id'=>$this->input->post('w_id'));
//   if($this->input->post('sub_gold')==$this->input->post('goldsmith')){
//       $gold = $this->input->post('sub_gold');
    
//   }
//   else{
//       $counter = 1;  
//       $gold = $this->input->post('goldsmith');
//   }
//   if($this->input->post('ori_out')==$this->input->post('out')){
       
//       $pro = $this->input->post('ori_out');
//   }
//   else{
//       $counter = 2;  
//       $pro = $this->input->post('out');
//   }
//   if($this->input->post('ori_sub')==$this->input->post('sub')){
       
//       $sub= $this->input->post('ori_sub');
//   }
//   else{
//       $counter = 3;  
//       $sub = $this->input->post('sub');
//   }
   if($this->input->post('ori_wastage')==$this->input->post('wastage')){
       
       $wastage= $this->input->post('ori_wastage');
   }
   else{
       $counter = 4;  
       $wastage = $this->input->post('wastage');
   }
 
if($counter>0){
$data1  =  array(
    'how_created'=>$this->session->userdata('user_id'),
    'wastage_amount'=>$wastage);
     $res = $this->Gold_module->get_record_by_id('wastage_product_gold',$con);
     $was_datetime  = $res['message']->was_datetime;
     $reference  = $res['message']->reference;
     $sub_id  = $res['message']->sub_id;
     $product_id  = $res['message']->pro_id;
     $goldsmith  = $res['message']->goldsmith_id;
     $who_created  = $this->session->userdata('user_id');
     $w_id  = $res['message']->w_id;
     $date_  = $res['message']->date;
     $wastage_amount  = $res['message']->wastage_amount;
     $insert_data = array(
                            'w_id'=>$w_id, 
                            'reference'=>$reference,
                            'pro_id'=>$product_id,
                            'sub_id'=>$sub_id,
                            'goldsmith_id'=>$goldsmith,
                            'wastage_amount'=>$wastage_amount,
                            'how_created'=>$who_created,
                            'date'=>$date_,
                            'was_datetime'=>$was_datetime
                            );
                            
                            $data = $this->Gold_module->insert_data('wastage_product_gold_backup',$insert_data);
     
$data1  =  array(
    'how_created'=>$this->session->userdata('user_id'),
    'wastage_amount'=>$wastage);
    
    
    
        
    
    $data = $this->Gold_module->updated_data('wastage_product_gold',$data1,$con);
       $this->output->set_content_type('application/json')->set_output(json_encode($data));
}
else{
    $data = array();
    $data['message'] ='You did not change the record';
    $data['error']=false;
    $this->output->set_content_type('application/json')->set_output(json_encode($data));
}
}


function wastage_backup(){
    
       $con = array('w_id'=>$this->input->post('data'));
     $data1['wastage'] = $this->Gold_module->multiple_joins_con('wastage_product_gold_backup','gold_smith','gold_products','pro_subcategory_gold',$con);
     $data['message1'] =   $this->load->view('gold/wastage_previous.php',$data1,TRUE);
     $this->output->set_content_type('application/json')->set_output(json_encode($data));

    
}

}
?>
