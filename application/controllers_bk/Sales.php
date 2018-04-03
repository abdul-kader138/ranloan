<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Sales_model');
        $this->load->model('Pos_model');
        $this->load->model('Gold_module');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
		
		if(empty($this->session->userdata('user_id')))
		{
			redirect(base_url());
		}
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }
	
	//******************************sales invoice***********************************//
	public function sales_invoice() {
        $permisssion_url = 'sales_invoice';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$getDefaultCustomer = $this->Pos_model->getDefaultCustomer();
		$data['totaltax'] = $getDefaultCustomer->tax;
		$us_id = $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
		$data['logged_name'] = $get_logged_name->fullname;
		//customer details add
		$data['group']=$this->db->where('is_active',1)->get('customer_group')->result();
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		//
		$data['getgold_grade'] = $this->Sales_model->select_all('gold_grade');
		$data['customer'] = $this->Sales_model->select_all('customers');
		$data['getgold_orders'] = $this->Sales_model->getgold_orders();
		$data['sale_per_user']=$this->Constant_model->getDataWhere('users','role_id=3');
		
		$data['staff'] = $this->Sales_model->select_all('staff');
		$data['outlets'] = $this->Sales_model->select_all('outlets');
		$data['orders'] = $this->Sales_model->select_all('orders_gold');
		$data['warehouse'] = $this->Sales_model->select_all('stores');
		$data['products'] = $this->Sales_model->select_all('refined_job_order');
		$data['gold_orders'] = $this->Sales_model->select_all('gold_orders');



		//$data['getSubcategory'] = $this->Sales_model->getCategorySubcategory();
		//up was old change by a3frt

		//this is new by a3frt
		$data['getSubcategory'] = $this->Gold_module->getServiceProduct();

		#*******************************************************************************
		#       ------- Bill Number Generate ---------------------------- start @ a3frt
		#*******************************************************************************

		$si_or_co = "SI"; #pass || SI || or || CO || SI = salesInvoice , CO = CustomOrder

		$res = $this->get_bill_num($si_or_co);

		if($res)
		{
		    $data['getgold_orders'] = $res;
		}
		else
		{
		    echo "<script> alert('No bill Number Found ! Please Add a Bill Number Or Contact admin'); </script>";
		    $data['getgold_orders'] = "";
		}

		#*******************************************************************************
		#       ------- Bill Number Generate ---------------------------- End @ a3frt
		#*******************************************************************************




		$this->load->view('gold/add_sales_invoice', $data);

/// previous Page is orders/sale.php
	}
	
	
	function getgoldOrderItem()
	{
		$html = '';
		
		
		
		
		$id   =  $this->input->post('data');
		
		$customer_id	=  $this->input->post('customer_id');
		
		$data_sales_id	=  $this->input->post('data_sales_id');
		
		$result = $this->Gold_module->getgoldOrderItem($id);
		$html.='<option value="">Select Product</option>';
		foreach ($result  as $value)
		{
			$select = '';
			if(!empty($value->product_code))
			{
				$select = '['.$value->product_code.']';	
			}
			$html.='<option value="'.$value->product_code.'">'.$value->product_name.' '.$select.'</option>';
		}
		
		$cus = $this->Gold_module->getCustomersingle($customer_id);
		$customer = '';
		$customer.= '<option value="">Choose Customer</option>';
		if(!empty($cus))
		{
			$customer.= '<option selected value='.$cus->id.'>'.$cus->fullname.'</option>';
		}
		$sales_invoice = $this->Gold_module->getSalesPersonSingle($data_sales_id);

		$sales = '';
		$sales.= '<option value="">Sales Person</option>';
		if(!empty($sales_invoice))
		{
			$sales.= '<option selected value='.$sales_invoice->id.'>'.$sales_invoice->fullname.'</option>';
		}
		
		
		
		
		
		$json['success']		= $html;
		$json['customer']		= $customer;
		$json['sales']			= $sales;
		echo json_encode($json);
	}
	
	
	//ok work
	function get_matchCustomername() {
		$json = array();
		$cust_id= $this->input->post('id');
		$outstanding = ($this->db->select('sum(unpaid_amt) as total')->from('sales_invoice_payment')->where('customer_id', $cust_id)->get()->row()->total);
		$customer_val	= $this->Sales_model->getmatchCustomer_Data($cust_id);
		if($customer_val->num_rows() > 0)
		{
			$deposit = $customer_val->row()->deposit;
			$bal = $deposit - $outstanding;
			
			$json['id']		= $customer_val->row()->id;
			$json['customer_name']    = $customer_val->row()->fullname;
			$json['customer_mobile']	= $customer_val->row()->mobile;
			$json['customer_email']	= $customer_val->row()->email;
			$json['customer_address']	= $customer_val->row()->address;
			$json['balance']	= $bal;
			
			$html = '';
			$customer_order_no = $this->Sales_model->getcustomer_order($cust_id);
			$html.= '<option value="">Select Order No.</option>';
			foreach ($customer_order_no as $view_cust)
			{
				$html.= '<option value='.$view_cust->gold_id.'>'.$view_cust->gold_id.'</option>';
			}
			
			$json['customer_order_no'] = $html;
			
		}
		else
		{
			$json['id']	= '';
			$json['customer_name']  = '';	
			$json['customer_mobile']  = '';
			$json['customer_email']  = '';
			$json['customer_address']  = '';
			$json['balance']	= '';
		}
		echo json_encode($json);
	}
	
	
	public function getMakepayment_name()
	{
		$default_store = $this->Pos_model->getDefaultCustomer();
		$default_store_id = $default_store->default_store_id;
		
		$html = '';
		$outlet_id = $this->input->post('outlet_id');
		$payment_method = $this->Sales_model->getpayment_mehtd_name($outlet_id);
			$html.= '<option value="">Select Payment Method</option>';
			foreach ($payment_method as $paynm)
			{
				$selected = '';
				if($default_store_id == $paynm->id)
				{
					$selected = 'selected'; 
				}
				$html.= '<option '.$selected.' data-val="0" value='.$paynm->id.'>'.$paynm->name.'</option>';
			}
		
			$json['success'] = $html;
			echo json_encode($json);
	}
	
	public function getOutletWiseWarehouse()
	{
		$default_store = $this->Pos_model->getDefaultCustomer();
		$default_store_id = $default_store->default_store_id;
		
		$html = '';
		//$outlet_id = $this->input->post('outlet_id'); //old 

		#added by a3frt date: 07-11-17 start

		$res_array_site_setting = $this->Sales_model->get_site_setting();
		$res_site_setting = $res_array_site_setting[0]->default_store_id;

		$outlet_id = explode(',', $res_site_setting); //new by a3frt for solve the setting issue

		#added by a3frt date: 07-11-17 End

		$warehouse = $this->Sales_model->getOutletWareHouse($outlet_id);
			$html.= '<option value="">Select Warehouse</option>';
			foreach ($warehouse as $ware)
			{
				$selected = '';
				if($default_store_id == $ware->s_id)
				{
					$selected = 'selected'; 
				}
				$html.= '<option '.$selected.' data-val="0" value='.$ware->s_id.'>'.$ware->s_name.'</option>';
			}
		
			$json['success'] = $html;
			echo json_encode($json);
	}
	
	function getOutletWiseWarehouseProduct()
	{
		$wareid		= $this->input->post('wareid'); 
		$type		= $this->input->post('type'); 
		$outlet_id	= $this->input->post('outlet_id'); 
		$productdata = $this->Sales_model->getOutletWiseWarehouseProduct($outlet_id,$wareid,$type);
		$product = '';
		$product .= '<option value="" >Select Product Item & Code</option>';
		foreach ($productdata as $pro)
		{
			$product .= "<option value='".$pro->product_code."'>".$pro->prdocuname." [".$pro->product_code."]</option>";
		}
		$json['product'] = $product;
		echo json_encode($json);
	}
	
	public function getProductDetailInventory()
	{
		$json = array();
		$pcode			= $this->input->post('product_code');
		$outlet_id		= $this->input->post('outlet_id');
		$type		    = $this->input->post('type');
		$warehouse_tank = $this->input->post('warehouse_tank');
		$gradeval  = '';
		$gradeval.= '<option value="">Select G. Grade</option>';
		$getgold_grade = $this->Sales_model->select_all('gold_grade');
		$inventory		= $this->Sales_model->getDataInventoryWise($pcode,$outlet_id,$type,$warehouse_tank);
		if($inventory->num_rows() > 0)
		{	
			$gold_purity = 0;
			$grade_name = '';
		
			if(!empty($inventory->row()->grade_id))
			{
				$gradeval_id = $inventory->row()->grade_id;
				$value		 = $this->Sales_model->getSingleGoldGrade($gradeval_id);
				$grade_id	 =	!empty($value->grade_id)?$value->grade_id:'';
				$grade_name	 =	!empty($value->grade_name)?$value->grade_name:'';
				$gold_purity =	!empty($value->gold_purity)?$value->gold_purity:0;
			}
			
			$grade_id_product = $inventory->row()->grade_id;
			$category		  = $inventory->row()->category;
			$sub_category     = $inventory->row()->sub_category_id_fk;
			
			$profile_calculation = $this->Sales_model->getProfileCalculationData($grade_id_product,$category, $sub_category);
			
			$min_profit = !empty($profile_calculation->min_profit)?$profile_calculation->min_profit:0;
			$profit		= !empty($profile_calculation->profit)?$profile_calculation->profit:0;
			
			$get_grade = $this->Constant_model->getLastGoldGradePrice();
			$CurrentPrice = !empty($get_grade->gp_price)?$get_grade->gp_price:0;
			$gp_purity	  = !empty($get_grade->gp_purity)?$get_grade->gp_purity:0;
			$cal = 0;

			if($grade_name == 24)
			{
				$cal = $CurrentPrice;
			}
			else
			{
				$cal = ($CurrentPrice / $gp_purity) * $gold_purity;
			}
			
			$NetGoldWeight = !empty($inventory->row()->NetGoldWeight)?$inventory->row()->NetGoldWeight:0;
				
			$calgoldnetWight = ($cal * ($NetGoldWeight + $inventory->row()->Wastagegold)) + $inventory->row()->TotalAllOtherCost;

			$salesPrice = $calgoldnetWight + (($calgoldnetWight * $profit) / 100);
			$MinPrice	= $calgoldnetWight + (($calgoldnetWight * $min_profit) / 100);
			
			
			$inventory_qty				= $inventory->row()->qty;
			$json['balance_stock']		= $inventory_qty;
			$json['product_price']		= $salesPrice;
			$json['ProductMinPrice']	= $MinPrice;
			$json['product_code']		= $inventory->row()->product_code;
			$json['product_weight']		= $inventory->row()->product_weight;
			$json['grade_id']			= !empty($grade_id)?$grade_id:'';
			$json['grade_name']			= !empty($grade_name)?$grade_name:'';
			
			if($inventory_qty == 0)
			{
				$json['status']=1;
			}
			
		}
		else
		{
			$json['balance_stock']		= 0;
			$json['product_price']		= 0;
			$json['ProductMinPrice']	= '';
			$json['product_code']		= '';
			$json['product_weight']		= '';
			$json['grade_id']			='';
			$json['grade_name']			=''	;
			$json['grade']				= $gradeval;
		}
		echo json_encode($json);
	}
	
	public function addCustomerorder_estimate()
	  {
		
		$user_id		= $this->session->userdata('user_id');
		$today			= date('Y-m-d H:i:s', time());
		
        $fullname	= $this->input->post('fullname');
        $email		= $this->input->post('email');
        $mobile		= $this->input->post('mobile');
		$outstanding = $this->input->post('outstanding');
        $address	= $this->input->post('address');
        $nic		= $this->input->post('nic');
		$group		= $this->input->post('group');
		$outlet_id	= $this->input->post('outlet_id');
		$paid_by = 6;
		$getOutletPayment = $this->Sales_model->getOutletWisePaymentMethod($outlet_id);
		foreach ($getOutletPayment as $pay)
		{
			if($pay->name == "Debit / Credit Sales")
			{
				$paid_by = $pay->id;
			}
		}
		
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

       
            if (!empty($email)) {
                $ckEmailData = $this->Constant_model->getDataOneColumn('customers', 'email', $email);
                if (count($ckEmailData) > 0) 
				{
                  $json['error_email']="<span style='color:red;'>Email already exits!</span>";
                }
				else
				{
			
					$ins_cust_data = array(
							  'fullname'		=> $fullname,
							  'email'			=> $email,
							  'mobile'			=> $mobile,
							  'created_user_id' => $us_id,
							  'created_datetime'=> $tm,
							  'nic'				=> $nic,
							  'outstanding'		=>$outstanding,
							  'address'			=>$address,
							  'outlet_id'		=>$outlet_id,
							  'customer_group'	=>$group,
					);
					$customer_id = $this->Constant_model->insertDataReturnLastId('customers', $ins_cust_data);

						$pay_query = $this->Constant_model->getPaymentIDName($paid_by);
						$pay_balance = $pay_query->balance;
						$now_balance = $pay_balance + $outstanding;
						$pay_data = array(
							'balance' => $now_balance,
							'updated_user_id' => $user_id,
							'updated_datetime' => $today
						);
						$this->db->update('payment_method', $pay_data, array('id' => $paid_by));


						$transaction_data = array(
							'trans_type' => 'outstanding',
							'user_id'		=> $customer_id,
							'outlet_id'		 => $outlet_id,
							'account_number' => $paid_by,
							'amount'		 => $outstanding,
							'bring_forword'	 => $pay_balance,
							'created_by'	 => $user_id,
							'created'        => $today
						);	

						$this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);

						$order_data = array(
								'outlet_id'			=> $outlet_id,
								'customer_id'		=> $customer_id,
								'customer_name'		=> $fullname,
								'customer_email'	=> $email,
								'customer_mobile'	=> $mobile,
								'ordered_datetime'	=> $today,
								'subtotal'			=> $outstanding,
								'grandtotal'		=> $outstanding,
								'payment_method'	=> $paid_by,
								'payment_method_name' => 'Debit / Credit Sales',
								'unpaid_amt'		=> $outstanding,
								'created_datetime'	=> $today,
								'customer_note'		=> 'outstanding'
						);	

						$this->Constant_model->insertDataReturnLastId('orders_payment', $order_data);
						$customer_details = $this->Constant_model->getDataOneColumn('customers', 'id', $customer_id);
						$html='<option selected="selected"  value='.$customer_details[0]->id.'>'.$customer_details[0]->fullname .'['. $customer_details[0]->mobile .']['. $customer_details[0]->nic .']'.'</option>';
						$json['customer_id']=$html;
						$json['success']="Successfully Added Customer";
				}
		}
		echo json_encode($json);
      
    }
	
	public function add_sales_invoice()
	{
	
		$showroom_item_val = $this->input->post('return');
		$payment	    = $this->input->post('payment');
		$customer_id    = $this->input->post('ser_custome_name');
		$outlet_id		= $this->input->post('outlet_id');
		$us_id			= $this->session->userdata('user_id');
		$grand_amount	= (float) str_replace(',', '',$this->input->post('grand_amount'));
		$pay_amount		= (float) str_replace(',', '',$this->input->post('total_amount'));
        $tm				= date('Y-m-d H:i:s', time());
		$us_id = $this->session->userdata('user_id');
		$paidpaymt = (float) str_replace(',', '',$this->input->post('total_amount'));
		$grandpaymt = (float) str_replace(',', '',$this->input->post('grand_amount'));
		$unpaidamt =$grandpaymt - $paidpaymt;
		$totalqty=0;
		$oultlet_id=$this->db->get_where('outlets', array('id' =>$outlet_id))->row();
		$data = array(
			'sales_customer_id' => $customer_id,
			'sales_customer_orderno_id' => $this->input->post('customer_order_no'),
			'sales_customer_name' => $this->input->post('customer_name'),
			'sales_customer_mobile' => $this->input->post('customer_mobile_no'),
			'sales_customer_note' => $this->input->post('note'),
			'sale_person_id' =>	$this->input->post('user_sales'),
			'sales_ordered_datetime' => date('Y-m-d H:i:s'),
			'sales_outlet_id' =>	$oultlet_id->id,
			'sales_outlet_name' =>	$oultlet_id->name,
			'sales_outlet_address' =>	$oultlet_id->address,
			'sales_outlet_contact' =>	$oultlet_id->contact_number,
			'sales_outlet_receipt_footer' =>	$oultlet_id->receipt_footer,
			'sales_created_user_id'=>$us_id,
			'sales_created_datetime'=>date('Y-m-d H:i:s'),
			'sales_paid_amt'=>$paidpaymt,
			'sales_unpaid_amt'=>$unpaidamt,
			'sales_showroom_subtotal'=>(float) str_replace(',', '',$this->input->post('product_total')),
			'sales_showroom_service_subtotal'=>(float) str_replace(',', '',$this->input->post('stock_service_total')),
			'sales_discount_total'=>$this->input->post('discount_grand_total'),
			'sales_discount_percentage'=>$this->input->post('discount_grand_persantge'),
			'sales_tax'=>$this->input->post('tax_grand_total'),
			'sales_tax_percentage'=>$this->input->post('tax_grand_persantge'),
			'sales_grandtotal'=>(float) str_replace(',', '',$this->input->post('grand_total')),
			'sales_point'=>$this->input->post('point'),
			'sales_balance'=>(float) str_replace(',', '',$this->input->post('balance')),
		);

		$last_id = $this->Constant_model->insertDataReturnLastId('sales_invoice', $data);


		#************************************************************************************
		#insert a new bill number for future use becuse current one is success @ a3frt start
		#************************************************************************************
		$co_bill_num = $this->input->post('estimate_no');

		if($last_id)
		{
		    $si_or_co = "SI";
		    $ck = $this->insert_new_bill($si_or_co,$co_bill_num);
		}

		#************************************************************************************
		#insert a new bill number for future use becuse current one is success @ a3frt start
		#************************************************************************************

		
		if(!empty($showroom_item_val))
		{
			foreach($showroom_item_val as $key=>$st_val)
			{

				if(!empty($_FILES['return']['name'][$key]))
				{
					foreach ($_FILES['return']['name'][$key] as $name => $value)
					{
						$sourcePath = $_FILES['return']['tmp_name'][$key]['product_image'][0];//[$name]['result_file'][0]
						if(!empty($sourcePath))
						{
							$image_name=date('ymdHis').$_FILES['return']['name'][$key]['product_image'][0];
							$targetPath = "product_image/".$image_name;
							move_uploaded_file($sourcePath,$targetPath); 
						}
						else
						{
							$image_name='';
						}
					}
				}
				else
				{
					$image_name='';
				}

				$product_val=$this->db->get_where('products', array('code' => $st_val['product_code_val']))->row();
				$product_service_id	 =	$st_val['product_service_id'];
				$sales_invoice_item = array(
						'sales_id'			=>$last_id,
						'warehouse_id'		=>$st_val['warehouse_tank'],
						'weight'			=>$st_val['product_weight'],
						'customer_id'		=>$customer_id,
						'price'				=>$st_val['product_price'],
						'qty'				=>$st_val['qty'],
						'discount'			=>$st_val['discount'],
						'tax'				=>$st_val['tax'],
						'gold_grade_id'		=>$st_val['gold_grade_id'],
						'product_image'		=>$image_name,
						'discount_amount'	=>$st_val['discount_amount'],
						'tax_amount'		=>$st_val['tax_amount'],
						'balance_stock'		=>$st_val['balance_stock'],
						'product_code'		=>$st_val['product_code_val'],
						'product_name'		=>$product_val->name,
						'cost'				=>$product_val->retail_price,
						'product_category'	=>$product_val->category,	
						'subtotal'			=>$st_val['total_val'],
						'grandtotal'		=>$st_val['total_val'],
				);
				
				$totalqty=$totalqty+$st_val['qty'];
				$sales_invoice_item_last_id = $this->Constant_model->insertDataReturnLastId('sales_invoice_item', $sales_invoice_item);
				$this->Gold_module->ProductUpdateStatus($st_val['product_code_val']);
				
				//----invertory store qty descr
				$product_code		= $st_val['product_code_val'];
				$warehouse_id		= $st_val['warehouse_tank'];
				$outlet_id			= $oultlet_id->id;
				$inventory_get		= $this->Gold_module->getInventoryqty($outlet_id,$warehouse_id,$product_code);
				$inventory_id		= $inventory_get->id;
				$inventory_qty		= $inventory_get->qty;
				$inventory_ow_idstores	= $inventory_get->ow_id;
				$stores_sid			= $inventory_get->s_id;
				$stores_s_stock		= $inventory_get->s_stock;
				$stores_s_stock_upated	= $inventory_get->s_stock_upated;
				
				$up_inventory = array('qty'	=> $inventory_qty - $st_val['qty']);
				$this->db->update('inventory', $up_inventory, array('id' => $inventory_id));
				
				$up_stores = array('s_stock'		=> $stores_s_stock			- $st_val['qty'],
								   's_stock_upated'	=> $stores_s_stock_upated	- $st_val['qty']
							 );
				$this->db->update('stores', $up_stores, array('s_id' => $stores_sid));

				//----end invertory store qty descr
				//-----------product_report
				
//				$sales_invoice_report_get	= $this->Sales_model->get_sales_report_qty($product_code);
//				$product_rep_balance_qty	= !empty($sales_invoice_report_get->balance_qty)?$sales_invoice_report_get->balance_qty:'0';
//				$product_rep_opening_qty	= $st_val['qty'] - $product_rep_balance_qty;
//				if($product_rep_balance_qty > $st_val['qty'])
//				{
//					$product_rep_opening_qty	= $product_rep_balance_qty - $st_val['qty'];
//				}
//				$product_report_data = array(
//							'product_code'	=>	$product_code ,
//							'opening_qty'	=>	$product_rep_balance_qty ,
//							'sales_qty'		=> $st_val['qty'],
//							'balance_qty'	=> $product_rep_opening_qty,
//							'created_by'	=>	$us_id,
//							'created_date'	=>	date('Y-m-d H:i:s'),
//							);
//				$this->db->insert('sales_invoice_report', $product_report_data);
//				
				//-----------end_product_report
			
				
				if(!empty($st_val['sales_return'])){
					$sales_return = $st_val['sales_return'];
					foreach($sales_return as $sal_view)
					{			

							$sales_services_data = array(
							'sales_invoice_item_id'	=>$sales_invoice_item_last_id ,
							'services_name'			=> $sal_view['services_id'],
							'price'					=> $sal_view['services_price'],
							'pre_print_invoice'		=>!empty($sal_view['pre_print_invoice'])?$sal_view['pre_print_invoice']:'0',
							);
							$this->Constant_model->insertDataReturnLastId('sales_invoice_item_services', $sales_services_data);
					}
				}

			}

		}
		
		$up_paid_amt=0;
		$up_unpaid_amt=0;
		foreach ($payment as $value)
		{
			$paid_amt       = $value['paid'];
			$payment_method = $value['paid_by'];
			
			$pay_query = $this->db->get_where('payment_method', array('id' => $payment_method))->row();
			$pay_mthod_name = $pay_query->name;
			$pay_balance = $pay_query->balance;
			$now_balance = $pay_balance + $paid_amt;
			$pay_data    = array(
				'balance' => $now_balance,
				'updated_user_id' => $us_id,
				'updated_datetime' => $tm
			);

			$this->db->update('payment_method', $pay_data, array('id' => $payment_method));
			
			$transaction_data = array(
				'trans_type'	=> 'dep',
				'user_id'		=> $customer_id,
				'outlet_id'		=> $outlet_id,
				'amount'		=> $paid_amt,
				'bring_forword'	=> $pay_balance,
				'account_number'=> $payment_method,
				'created_by'	=> $us_id,
				'cheque_number'	=> $value['cheque'],
				'voucher_number'=> $value['addi_voucher_numb'],
				'cheque_date'	=> !empty($value['cheque_date'])?$value['cheque_date']:'',
				'bank'			=> $value['bank'],
				'card_number'	=> $value['addi_card_numb'],
				'created'		=> $tm
			);	
			$res1 = $this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);
			
		
			if($pay_mthod_name == 'Debit / Credit Sales' || $pay_mthod_name == 'Vouchers')
			{
				$up_unpaid_amt= $up_unpaid_amt + $paid_amt;
				$paid_string ='unpaid_amt';
			}
			else
			{
				$up_paid_amt = $up_paid_amt + $paid_amt;
				$paid_string ='paid_amt';
			}
			
			$data = array(
				'sales_id'	=> $last_id,
				'customer_id'		=> $customer_id,
				'ordered_datetime'	=> $tm,
				'outlet_id'			=> $outlet_id,
				'subtotal'			=>	$paid_amt,
				'grandtotal'		=> $paid_amt,
				'payment_method'	=>$payment_method,
				'payment_method_name'=>$pay_mthod_name,
				'cheque_number'		=>$value['cheque'],
				'created_user_id'	=>$us_id,
				'card_number'		=>$value['addi_card_numb'],
				'voucher_number'	=> $value['addi_voucher_numb'],
				$paid_string		=>$paid_amt,
				'bank'				=>$value['bank'],
				'cheque_date'		=>!empty($value['cheque_date'])?$value['cheque_date']:'',
				'bring_forword'		=>$pay_balance,
				'customer_note'		=>$this->input->post('note'),
			);
			$this->Constant_model->insertDataReturnLastId('sales_invoice_payment', $data);
		}
		
		
		$unpaid_up = array(
			'sales_total_qty_item'	=> $totalqty,
			'sales_paid_amt'			=> $up_paid_amt,
			'sales_unpaid_amt'		=> $up_unpaid_amt + $unpaidamt
		);
		$this->db->update('sales_invoice', $unpaid_up, array('sales_id' => $last_id));
		
		echo $last_id;
	}

	
	
	
	public function view_invoice() {
		$id = $this->input->get('id');
        $data['setting_logo'] = $this->db->get_where('site_setting')->row();
		$data['getmainOrder']=$this->db->get_where('sales_invoice', array('sales_id' => $id))->row();
		$sales_id=$data['getmainOrder']->sale_person_id;
		$data['sales_person_name']=$this->Constant_model->getDataWhere('users','id='.$sales_id);
		$data['order_items_gold']=$this->Constant_model->getDataWhere('sales_invoice_item','sales_id='.$id);
		$data['getPaymentGoldOrder'] = $this->Constant_model->getDataWhere('sales_invoice_payment','sales_id='.$id);
		
		$data['new_sys_settings'] = ci_set_settings();
		$data['order_id']=$id;
		$data['getPaymentOrder']=0;
		$this->load->view('gold/print_invoice_sales', $data);
	}
	
	
	
	

	// ****************************** View Page -- START ****************************** //

    // View List Sales;
    public function list_sales()
    {
		$user_role = $this->session->userdata('user_role');
        $user_outlet = $this->session->userdata('user_outlet');
		        
        $permisssion_url = 'list_sales';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;
        $data['setting_dateformat'] = $setting_dateformat;
		$data['getTodaySales'] = $this->Sales_model->getTodaySales($user_role, $user_outlet);
		$data['gettodaycustomerorderprice'] = $this->Sales_model->getTodaySales_qty_price();
		$data['getTodaySalesInvoice'] = $this->Sales_model->getTodaySalesInvoice($user_role, $user_outlet);
		$data['gettodaySalesinvoceprice'] = $this->Sales_model->getTodaySalesInvoice_qty_price();
		$this->load->view('list_sales', $data);
    }
	
    public function reserved_Item_list()
    {
		$permisssion_url = 'reserved_Item_list';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getSubCategory'] = $this->Constant_model->getSubCategory();
		$data['getResult'] = $this->Sales_model->getReserved_Item_List();
//		print_r($data);
//		die;
	    $this->load->view('reserved_Item_list',$data);
    }
    public function old_reserved_item_list()
    {
		$permisssion_url = 'old_reserved_item_list';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getSubCategory'] = $this->Constant_model->getSubCategory();
		$this->load->view('old_reserved_Item_list',$data);
    }
	
    public function customer_payment_history()
    {
		$cust_id				= $this->input->get('cust_id');
		$user_role				= $this->session->userdata('user_role');
        $user_outlet			= $this->session->userdata('user_outlet');
		$paginationData			= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$pagination_limit		= $paginationData[0]->pagination;
        $setting_dateformat		= $paginationData[0]->datetime_format;
        $data['setting_dateformat'] = $setting_dateformat;
		
		
		$data['customerdetail'] = $this->Constant_model->getCustomerDetail($cust_id);
		$data['order_payment'] = $this->Constant_model->getCustomerOderPayment($cust_id);
        $this->load->view('customer_payment_history', $data);
    }
	
	public function export_customer_payment_history()
	{
		
		
		$this->load->library('excel');
		require_once './application/third_party/PHPExcel.php';
		require_once './application/third_party/PHPExcel/IOFactory.php';

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		$default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => '000000'),
		);

		$acc_default_border = array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => 'c7c7c7'),
		);
		$outlet_style_header = array(
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 10,
				'name' => 'Arial',
				'bold' => true,
			),
		);
		$top_header_style = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'ffff03'),
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 15,
				'name' => 'Arial',
				'bold' => true,
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			),
		);
		$style_header = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'ffff03'),
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 12,
				'name' => 'Arial',
				'bold' => true,
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
		);
		$account_value_style_header = array(
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 12,
				'name' => 'Arial',
			),
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
			),
		);
		$text_align_style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			),
			'borders' => array(
				'bottom' => $default_border,
				'left' => $default_border,
				'top' => $default_border,
				'right' => $default_border,
			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => 'ffff03'),
			),
			'font' => array(
				'color' => array('rgb' => '000000'),
				'size' => 12,
				'name' => 'Arial',
				'bold' => true,
			),
		);
		$cust_id		= $this->input->get('cust_id');
		$customerdetail = $this->Constant_model->getCustomerDetail($cust_id);
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Payment History for Customer: '.$customerdetail->fullname.'');

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);

		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date & Time');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'ID');
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Type');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Outlet');
		$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Opening Amount');
		$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Bill Amount');
		$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Received Amount');
		$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Balance Amount');


		$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$row = 3;
		
		$order_payment	= $this->Constant_model->getCustomerOderPayment($cust_id);
		
		foreach ($order_payment as $value)
		{
			
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $value->ordered_datetime);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $value->order_id);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $value->payment_method_name);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $value->outlet_name);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $value->openingBalance);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $value->paid_amt);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $value->unpaid_amt);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$row, $value->grandtotal);
			
			$objPHPExcel->getActiveSheet()->getStyle("A$row")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$row")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$row")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$row")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$row")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$row")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("G$row")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("H$row")->applyFromArray($account_value_style_header);
			
			
			$row++;
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Payment_History_Customer.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
		
		

    // Opened Bill;
    public function opened_bill()
    {
                $permisssion_url = 'opened_bill';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;

        $data['setting_dateformat'] = $setting_dateformat;

        $this->load->view('list_bills', $data);
    }

    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

    // Delete Sales;
    public function deleteSale()
    {
        $order_id = $this->input->get('id');
        $ordDtaData = $this->Constant_model->getDataOneColumn('orders', 'id', $order_id);
        $order_type = $ordDtaData[0]->status;
        $order_outlet_id = $ordDtaData[0]->outlet_id;
        // Delete Order;
        $this->Constant_model->deleteData('orders', $order_id);
        if ($order_type == '1') {
            $ordItemResult = $this->db->query("SELECT * FROM order_items WHERE order_id = '$order_id' ");
            $ordItemData = $ordItemResult->result();
            for ($i = 0; $i < count($ordItemData); ++$i) {
                $oitem_id = $ordItemData[$i]->id;
                $pcode = $ordItemData[$i]->product_code;
                $new_qty = $ordItemData[$i]->qty;

                // Check Id;
                $getInvDtaResult = $this->db->query("SELECT * FROM inventory WHERE product_code = '$pcode' AND outlet_id = '$order_outlet_id' ");
                $getInvDtaRows = $getInvDtaResult->num_rows();
                if ($getInvDtaRows == 1) {
                    $getInvDtaData = $getInvDtaResult->result();

                    $getInv_id = $getInvDtaData[0]->id;
                    $getInv_qty = $getInvDtaData[0]->qty;

                    unset($getInvDtaData);

                    $upd_inv_qty = 0;
                    $upd_inv_qty = $getInv_qty + $new_qty;

                    $upd_data = array(
                                'qty' => $upd_inv_qty,
                    );
                    $this->Constant_model->updateData('inventory', $upd_data, $getInv_id);

                    unset($upd_inv_qty);
                    unset($upd_inv_qty);
                } else {
                    $ins_data = array(
                            'product_code' => $pcode,
                            'outlet_id' => $order_outlet_id,
                            'qty' => $new_qty,
                    );
                    $last_inv_id = $this->Constant_model->insertDataReturnLastId('inventory', $ins_data);
                }
                unset($getInvDtaResult);
                unset($getInvDtaRows);

                // Delete Order Item;
                $this->Constant_model->deleteData('order_items', $oitem_id);

                unset($oitem_id);
                unset($pcode);
                unset($new_qty);
            }
            unset($ordItemResult);
            unset($ordItemData);
        }

        if ($order_type == '2') {
            $retItemResult = $this->db->query("SELECT * FROM return_items WHERE order_id = '$order_id' ");
            $retItemData = $retItemResult->result();
            for ($r = 0; $r < count($retItemData); ++$r) {
                $ret_id = $retItemData[$r]->id;
                $ret_pcode = $retItemData[$r]->product_code;
                $ret_qty = $retItemData[$r]->qty;
                $ret_cond = $retItemData[$r]->item_condition;

                if ($ret_cond == '1') {

                     // Check Id;
                    $getInvDtaResult = $this->db->query("SELECT * FROM inventory WHERE product_code = '$ret_pcode' AND outlet_id = '$order_outlet_id' ");
                    $getInvDtaRows = $getInvDtaResult->num_rows();
                    if ($getInvDtaRows == 1) {
                        $getInvDtaData = $getInvDtaResult->result();

                        $getInv_id = $getInvDtaData[0]->id;
                        $getInv_qty = $getInvDtaData[0]->qty;

                        unset($getInvDtaData);

                        $upd_inv_qty = 0;
                        $upd_inv_qty = $getInv_qty - $ret_qty;

                        $upd_data = array(
                                    'qty' => $upd_inv_qty,
                        );
                        $this->Constant_model->updateData('inventory', $upd_data, $getInv_id);

                        unset($upd_inv_qty);
                        unset($upd_inv_qty);
                    }
                    unset($getInvDtaResult);
                    unset($getInvDtaRows);
                }

                 // Delete Order Item;
                $this->Constant_model->deleteData('return_items', $ret_id);

                unset($ret_id);
                unset($ret_pcode);
                unset($ret_qty);
                unset($ret_cond);
            }
            unset($retItemResult);
            unset($retItemData);
        }

        if ($order_type == '1') {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Sales', 'Successfully Deleted Sales.'));
        } elseif ($order_type == '2') {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Return', 'Successfully Deleted Return Order.'));
        }
        redirect(base_url().'sales/list_sales');
    }

    // Delete Suspend;
    public function deleteSuspended()
    {
        $id = $this->input->get('id');

        $ckSusData = $this->Constant_model->getDataOneColumn('suspend', 'id', $id);

        if (count($ckSusData) == 1) {
            if ($this->Constant_model->deleteData('suspend', $id)) {
                $this->Constant_model->deleteByColumn('suspend_items', 'suspend_id', $id);

                $this->session->set_flashdata('alert_msg', array('success', 'Delete Opened bill', 'Successfully Deleted Opened Bill.'));
                redirect(base_url().'sales/opened_bill');
            }
        } else {
            $this->session->set_flashdata('alert_msg', array('failure', 'Delete Opened bill', 'Error on Deleting Opened Bill! Please try again!'));
            redirect(base_url().'sales/opened_bill');
        }
    }

    // ****************************** Action To Database -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //
    // Export Sales -- START;
    public function exportSales()
    {
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;

        $user_role = $this->session->userdata('user_role');
        $user_outlet = $this->session->userdata('user_outlet');

        // START Export Excel;
        $this->load->library('excel');

        require_once './application/third_party/PHPExcel.php';
        require_once './application/third_party/PHPExcel/IOFactory.php';

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        $default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000'),
        );

        $acc_default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => 'c7c7c7'),
        );
        $outlet_style_header = array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 10,
                'name' => 'Arial',
                'bold' => true,
            ),
        );
        $style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff03'),
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
                'bold' => true,
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $account_value_style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $text_align_style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff03'),
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
                'bold' => true,
            ),
        );

        $display_date = date("$setting_dateformat", time());

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Sales Report For : $display_date ");

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_header);
        

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Sale Id');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Type');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Outlet');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Customer Name');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Pumper Name');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'Total Items');
        $objPHPExcel->getActiveSheet()->setCellValue('H2','Grand Total');
        
        

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
        

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;
		
		
		
		$user_role = $this->session->userdata('user_role');
        $user_outlet = $this->session->userdata('user_outlet');
		$getTodaySales = $this->Sales_model->getTodaySales($user_role,$user_outlet);
        $total_grand_amt = 0;
        $total_item = 0;
		foreach ($getTodaySales as $value) {
			$total_grand_amt = $total_grand_amt + $value->totalamount;
			$total_item = $total_item + $value->total_items;
			$order_id = $value->id;
			$type_name = '';
			 if ($value->status == '1') {
                $type_name = 'Sale';
            } elseif ($value->status == '2') {
                $type_name = 'Return';
            }
			$objPHPExcel->getActiveSheet()->setCellValue("A$jj", date("$setting_dateformat H:i A", strtotime($value->created_at)));
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", $order_id);
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", $type_name);
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", $value->outlet_name);
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", $value->customername);
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", $value->pumper_name);
            $objPHPExcel->getActiveSheet()->setCellValue("G$jj", $value->total_items);
            $objPHPExcel->getActiveSheet()->setCellValue("H$jj", number_format($value->totalamount,2));
            

            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($account_value_style_header);
            ++$jj;
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:F$jj");
        $objPHPExcel->getActiveSheet()->setCellValue("A$jj", 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue("G$jj", number_format($total_item,2));
        $objPHPExcel->getActiveSheet()->setCellValue("H$jj", number_format($total_grand_amt,2));
        
		$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($style_header);
		
        $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Today_Sales.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    // Export Sales -- END;
    // ****************************** Action To Database -- END ****************************** //

    # add by a3frt 04-11-17 start

    #this function return the bill num call the function with SI or CO

    function get_bill_num($SI_or_CO = null)
    {
        $bl_num = '';
        $bill_number = '';

        if($SI_or_CO == "SI")
        {
            $bl_num = 'sale_invoice_num';
        }

        else if($SI_or_CO == "CO")
        {
            $bl_num = 'custom_order_num';
        }

        $res = $this->Gold_module->get_current_billnumber();

        foreach ($res as  $v) 
        {
            if(strlen($v->$bl_num) > 2)
            {
                $bill_number = $v->$bl_num;
                break;
            }
        }

       if(empty($bill_number))
        {
            return false;
        }

        return  $bill_number;
    }

    
    function insert_new_bill($si_or_co = null,$bill_num = null)
    {
        $st = $bill_num;

        $change_detect = substr($st, 3,2);

        $ci_or_co = substr($st, 0,2); //use in 1st condition is SI or CI

        $bill_date = substr($st, 6,8); //use in date check is today == invoiceday

        $last_number = substr($st, -1); //use in increment last number example -> 5 to 6

        $cut_last_number = substr($st, 0,15); //use get the full bill_number - last number
        
        $cut_date = substr($st, 0,6); //use get the full bill_number - last number

        $dash_last_number = substr($st,-2); //use get the full bill_number - last number

        $bill_number = '';

        if($change_detect == "CD")
        {
            $today = date("Ymd");

            if($today == $bill_date)
            {
                $increment = ((int)$last_number) + 1;
                $bill_number = $cut_last_number.$increment;
            }
            else
            {
                $bill_number = $cut_date.$today.$dash_last_number;
            }
        }

        else if($change_detect == "CW")
        {
            $week_date = date("Ymd", strtotime("+6 days",strtotime($bill_date)));
            $bill_number = $cut_date.$week_date.$dash_last_number;
        }
        else if($change_detect == "CM")
        {
            $month_date = date("Ymd", strtotime("+1 month", strtotime($bill_date)));
            $bill_number = $cut_date.$month_date.$dash_last_number;
        }
        else if($change_detect == "CY")
        {
            $month_date = date("Ymd", strtotime("+1 year", strtotime($bill_date)));
            $bill_number = $cut_date.$month_date.$dash_last_number;
        }

       $rec_data =  $this->Gold_module->get_current_billnumber_all_data($si_or_co,$bill_num);
       $rec_arr_data = $rec_data[0];
       
      if($si_or_co == "SI" && !empty($bill_number))
      {
        $rec_arr_data['sale_invoice_num'] = $bill_number;
        $rec_arr_data['user_id'] = $this->session->userdata('user_id');
        $rec_arr_data['created_date'] = date('Y-m-d H:i:s');

         unset($rec_arr_data['id']);

        $is_insert = $this->Gold_module->insert_new_billnumber($rec_arr_data);

      }
      else if($si_or_co == "CO" && !empty($bill_number))
      {
        $rec_arr_data['custom_order_num'] = $bill_number;
        $rec_arr_data['user_id'] = $this->session->userdata('user_id');
        $rec_arr_data['created_date'] = date('Y-m-d H:i:s');

         unset($rec_arr_data['id']);

        $is_insert = $this->Gold_module->insert_new_billnumber($rec_arr_data);
      }

      if($is_insert)
      {
        return true;
      }

      return false;

    }

    # add by a3frt 04-11-17 End


    #***********************************************************
    #       added by a3frt date 15-11-17 start
    #************************************************************

    function insert_below_min_price_request()
    {
    	$min_req_amn = $this->input->post('min_req_amn');
    	$p_code = $this->input->post('p_code');
    	$permission_for = $this->input->post('permission_for');
    	
    	$data = array(

    		'permission_for' => $permission_for,
    		'product_name_code' =>$p_code,
    		'desire_price'      => $min_req_amn,
    		'request_user'      => $this->session->userdata('user_id'),
    		'create_at'         => date('Y-m-d H:i:s'),
    		'actions'			=> 'pending'

    	);

    	
    	$is_insert = $this->Gold_module->insert_min_sale_req($data);
    	

    	if($is_insert)
    	{
    	  $ck['sucess'] = TRUE;
    	}
    	else
    	{
    		$ck['sucess'] = FALSE;
    	}

    	echo json_encode($ck);

    }


    function search_requested_min_sale_price()
    {
    	$p_code = $this->input->post('p_code');

    	$is_insert = $this->Gold_module->get_req_sale_price($p_code);

    	if(!empty($is_insert))
    	{
    		$v['success'] = $is_insert[0]->desire_price;
    	}
    	else
    	{
    		$v['success'] = 0;
    	}

    	echo json_encode($v);
    }


    #***********************************************************
    #       added by a3frt date 15-11-17 start
    #************************************************************

}
