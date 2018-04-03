<?php 
Class Store extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Gold_module');
		$this->load->model('Purchaseorder_model');
		$this->load->model('Constant_model');
		$this->load->model('Products_model');
		$this->load->model('Product_Code_Numbering_model');

		$this->load->library('pagination');
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$setting_timezone = $settingData->timezone;
		date_default_timezone_set("$setting_timezone");
		if($this->session->userdata('user_id') == "")
		{
			redirect(base_url());
		}

		require_once APPPATH.'third_party/PHPExcel.php';
		$this->excel = new PHPExcel(); 
	}
	
	
	public function warehouse_list()
	{       
		$permisssion_url = 'warehouse_list';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);

		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}

		$data['getWarehouse'] = $this->Gold_module->getAllWarehouse();
		$this->load->view('includes/header');
		$this->load->view('gold/list_store',$data);
		$this->load->view('includes/footer',$data);
	}
	
	
		
		public function add_store()
		{
			$data['getBulkStoreCount'] = $this->Constant_model->getBulkStoreCount();
			$this->load->view('includes/header');
			$this->load->view('gold/add_store',$data);
			$this->load->view('includes/footer');
		}
		
		public function save_wherehouse()
		{
			$array_data = array(
				'date_created'=>$this->input->post('gpro_name'),
				's_name'=>$this->input->post('store'),
				's_address'=>$this->input->post('address'),
				's_stock'=>$this->input->post('stock'),
				's_stock_upated'=>$this->input->post('stock'),
				's_contact'=>$this->input->post('contact'),
				'bulk_status'=>!empty($this->input->post('bulk_status'))?$this->input->post('bulk_status'):0,
				's_status'=>1);
			$data = $this->Gold_module->insert_data('stores',$array_data);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
		
		public function assign_store()
		{
			$permisssion_url = 'assign_store';
			$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);

			if($permission->view_menu_right == 0)
			{
				redirect('dashboard');
			}
		
			
			$single_status['store_']			= $this->Gold_module->select_all_join_two('outlet_warehouse','stores');
			$single_status['outlets']			= $this->Constant_model->getOutlets();
			$single_status['user_role']			= $this->session->userdata('user_role');
			
			$this->load->view('includes/header');
			$this->load->view('gold/assigning_stores',$single_status);
			$this->load->view('includes/footer');
		}
		
		function save_store()
		{
			$all_ = $this->input->post('ware');
			for($i=0;$i<count($all_);$i++){
			$array_data = array(
				'ow_date'=>$this->input->post('gpro_name'),
				'out_id'=>$this->input->post('out'),
				'w_id'=>$all_[$i]);
				$data = $this->Gold_module->insert_data('outlet_warehouse',$array_data);
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
		
		function get_netstore()
		{
			$selected = '';
			$condition   =  $this->input->post('data');
			$query = $this->db->query('SELECT * FROM outlet_warehouse WHERE out_id  = "'.$condition.'" ');
			foreach ($query->result() as $row)
			{
				$selected.= $row->w_id.',';	
			}
			$finalid  = rtrim($selected,",");
			if(!empty($finalid))
			{
				$data['stores'] = $this->Gold_module->getwarehouseData($finalid);
				$data['message1'] =   $this->load->view('gold/store_name.php',$data,TRUE);
				$this->output->set_content_type('application/json')->set_output(json_encode($data));
			}
			else
			{
				$data['stores'] = $this->Constant_model->getStoreDropDefaultStore();
				$data['message1'] =   $this->load->view('gold/store_name.php',$data,TRUE);
				$this->output->set_content_type('application/json')->set_output(json_encode($data));
			}
		}
		
		function get_outlet_store()
		{
			$single_status['store_'] =$this->Gold_module->select_all_join_two('outlet_warehouse','stores');
			$single_status['outlets'] =$this->Gold_module->select_all('outlets');
			$data['message'] =   $this->load->view('gold/outlet_warehouse_ajax.php',$single_status,TRUE);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));   
		}
		
		public function warehouse_stocks()
		{
			$permisssion_url = 'warehouse_stocks';
			$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);

			if($permission->view_menu_right == 0)
			{
				redirect('dashboard');
			}
			
			$data['stocks'] = $this->Gold_module->getWarehouseStocks();

			$this->load->view('includes/header');
			$this->load->view('gold/list_stocks',$data);
			$this->load->view('includes/footer');
		}
		
		function transfer_stocks()
		{
			$permisssion_url = 'transfer_stocks';
			$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);

			if($permission->view_menu_right == 0)
			{
					redirect('dashboard');
			}
			
			$data['getOutlets']			= $this->Constant_model->getOutlets();
			$data['getTransformStock']	= $this->Gold_module->getTransformStock();
				
			$this->load->view('includes/header');
			$this->load->view('gold/transfer_stocks',$data);
			$this->load->view('includes/footer');
			$this->load->view('includes/header_notification');
		}
		
	function add_transfer_stocks()
	{
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getStore'] = $this->Constant_model->getStore();
		$data['getProduct'] = $this->Constant_model->getProductWareHouse();
		$data['getCategory'] = $this->Constant_model->getDataWhere('category');
		$data['getGoldGrade'] = $this->Constant_model->getDataWhere('gold_grade');
		$data['getTransFormNumber'] = $this->Gold_module->getTransFormNumber();


		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);

		$data['UserLoginName'] = @$loginData[0]->fullname;
		$this->load->view('includes/header');
		$this->load->view('gold/add_transfer_stocks',$data);
		$this->load->view('includes/footer');
	}
		
	public function transfer_bulk_item()
	{
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getStore'] = $this->Constant_model->getStore();
		$data['getProduct'] = $this->Constant_model->getProductWareHouse();
		$data['getCategory'] = $this->Constant_model->getDataWhere('category');
		$data['getGoldGrade'] = $this->Constant_model->getDataWhere('gold_grade');
		$data['getgold_smith'] = $this->Constant_model->getDataWhere('gold_smith');
		$data['getTransFormNumber'] = $this->Gold_module->getTransFormNumber();


		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['getTransformStock']	= $this->Gold_module->getTransformStock();
		$data['UserLoginName'] = @$loginData[0]->fullname;
		$this->load->view('includes/header');
		$this->load->view('gold/transfer_bulk_item',$data);
		$this->load->view('includes/footer');
	}
	
	public function get_Category_wise_Subcategory()
	{
		$html = '';
			$category_id = $this->input->post('cate_id');
			$getSubCategory = $this->Constant_model->getDataWhere('sub_category','category_id_fk='.$category_id);;
			$html.= '<option value="">Select Sub Category</option>';
			foreach ($getSubCategory as $subcateg)
			{
					$html.= '<option value='.$subcateg->id.'>'.$subcateg->sub_category.'</option>';	
			}
			
			$json['subcategory'] = $html;
			echo json_encode($json);
		
	}
	
	public function get_warehouse_outletwise_bulk()
	{
		$html = '';
		$outlet_id = $this->input->post('val');
		$warehouses = $this->Products_model->get_warehouse_outletwise($outlet_id);
		$html.= '<option value="">Select Store</option>';
		foreach ($warehouses as $store)
		{
			$html.= '<option value="'.$store->ow_id.'">'.$store->s_name.'</option>';
		}
		$json['warehousedata'] = $html;
		echo json_encode($json);
	}
		
	public function getProductCodeItem()
	{
		$category		= $this->input->post('category');
		$sub_category	= $this->input->post('sub_category');
		$product = '';
		$product.= '<option value="">Select Item</option>';
		$getProduct = $this->Constant_model->getCategorySubcategoryProductTransfer($category,$sub_category);
		foreach ($getProduct->result() as $value)
		{
			$getInveCount = $this->Constant_model->CheckInventoryQty($value->id);
			if($getInveCount > 0)
			{
				$product.= '<option value="'.$value->id.'">'.$value->name.'</option>';
			}
		}
		$json['bulk_product_count'] = $getProduct->num_rows();
		
		
		
		$getCode = $this->Product_Code_Numbering_model->getProductCodeCategorySubcategory($category,$sub_category);
		if(!empty($getCode))
		{
				$now			= strtotime($getCode->updated_date);
				$your_date		= date('Y-m-d',  strtotime($getCode->created_date));
				$finalmydate	= strtotime($your_date);
				$datediff		= $now - $finalmydate;
				$totalday		=  floor($datediff / (60 * 60 * 24));

				$auto_generate_code = $getCode->auto_generate_code;
				$product_num_id = $getCode->id;
				$updated_date = $getCode->updated_date;
				if(!empty($getCode->change_daily))
				{
					$today = date('Y-m-d');
					if($today == $updated_date)
					{
						$changeNewdate = $getCode->created_date;
						$profecctional_code = $getCode->updated_number;
					}
					else
					{
						$changeNewdate = $getCode->created_date;
						$profecctional_code = $getCode->auto_generate_code;
					}
				}
				else if(!empty($getCode->change_weekly))
				{
					if($totalday<=7)
					{
						$changeNewdate = $getCode->created_date;
						$profecctional_code = $getCode->updated_number;
					}
					else
					{
						$changeNewdate = date('Y-m-d H:i:s');
						$profecctional_code = $getCode->auto_generate_code;
					}
				}
				else if(!empty($getCode->change_monthly))
				{
					if($totalday<=30)
					{
						$changeNewdate = $getCode->created_date;
						$profecctional_code = $getCode->updated_number;
					}
					else
					{
						$changeNewdate = date('Y-m-d H:i:s');
						$profecctional_code = $getCode->auto_generate_code;
					}
				}
				else if(!empty($getCode->change_yearly))
				{
					if($totalday<=365)
					{
						$changeNewdate = $getCode->created_date;
						$profecctional_code = $getCode->updated_number;
					}
					else
					{
						$changeNewdate = date('Y-m-d H:i:s');
						$profecctional_code = $getCode->auto_generate_code;
					}
				}
				
				$current_year = ($getCode->current_year == 1)?date('Y'):'';
				$current_month = ($getCode->current_month == 1)?date('m'):'';
				$current_day = ($getCode->current_day == 1)?date('d'):'';
				$prefix = $getCode->prefix;
				$concate = $prefix.$current_year.$current_month.$current_day.'-'.$profecctional_code;
		
			$json['success']			= true;
			$json['code']				= $concate;
			$json['product_num_id']		= $product_num_id;
			$json['profecctional_code'] = $profecctional_code;
			$json['changeNewdate']		= $changeNewdate;
		}
		else
		{
			$json['error']				= true;
			$json['code']				= '';
			$json['product_num_id']		= '';
			$json['profecctional_code'] = '';
			$json['changeNewdate']		= '';
		}
		
		$json['product'] = $product;
	
		echo json_encode($json);
	}
	

	public function getGoldGrade()
	{
		$grade_id		= $this->input->post('grade_id');
		$grade_name		= $this->input->post('grade_name');
		$gold_purity	= $this->input->post('gold_purity');
		
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
		
		$json['CurrentPrice'] = $cal;
		
		echo json_encode($json);
	}
	
	
	public function SubmitTransferStore()
	{
		$ins_data = array(
			'code'					=> $this->input->post('code'),
			'name'					=> $this->input->post('product_name'),
			'category'				=> $this->input->post('category'),
			'sub_category_id_fk'	=> $this->input->post('sub_category'),
			'grade_id'				=> $this->input->post('grade_id'),
			'GoldWeight'			=> $this->input->post('GoldWeight'),
			'StoneWeight'			=> $this->input->post('StoneWeight'),
			'NetGoldWeight'			=> $this->input->post('NetGoldWeight'),
			'weight'				=> $this->input->post('GoldWeight'),
			'Wastageperg'			=> $this->input->post('Wastageperg'),
			'Wastagegold'			=> $this->input->post('Wastagegold'),
			'StoneCost'				=> $this->input->post('StoneCost'),
			'LabourCost'			=> $this->input->post('LabourCost'),
			'OtherCost1'			=> $this->input->post('OtherCost1'),
			'OtherCost2'			=> $this->input->post('OtherCost2'),
			'OtherCost3'			=> $this->input->post('OtherCost3'),
			'TotalGoldweight'		=> $this->input->post('TotalGoldweight'),
			'GoldGradeCurrentPrice'	=> $this->input->post('GoldGradeCurrentPrice'),
			'TotalGoldCost'			=> $this->input->post('TotalGoldCost'),
			'TotalAllOtherCost'		=> $this->input->post('TotalAllOtherCost'),
			'TransferredCost'		=> $this->input->post('TransferredCost'),
			'note'					=> $this->input->post('note'),
			'start_qty'				=> 1,
			'thumbnail'				=> 'no_image.jpg',
			'status'				=> '1',
			'outlet_id_fk'			=> $this->input->post('outlet_id'),
			'created_datetime'		=> date('Y-m-d H:i:s'),
			'created_user_id'		=> $this->session->userdata('user_id'),
		);
		
		$product_report = array(
			'opening_qty'	=> 1,
			'product_code'	=> $this->input->post('code'),
			'purchase_qty'	=> 0,
			'sales_qty'		=> 0,
			'balance_qty'   => 1,
			'created_by'	=> $this->session->userdata('user_id'),
			'created_date'	=> date('Y-m-d H:i:s'),
		);
		
		/*
		 * CHeck product code already inserted
		 */
		$ckPcodeData = $this->Constant_model->getDataOneColumn('products', 'code', $this->input->post('code'));
		
						
		if (count($ckPcodeData) == 0) {
			
			if(!empty($this->input->post('product_num_id')))
			{
				$code_num_array = array(
					'created_date'		=> $this->input->post('changeNewdate'),
					'updated_number'	=> $this->input->post('profecctional_code')+1,
					'updated_date'		=> date('Y-m-d'),
				);
				$this->Constant_model->UpdateProductCodeNumber($code_num_array, $this->input->post('product_num_id'));
			}
			
			$this->Constant_model->insertDataReturnLastId('products', $ins_data);
			$this->Constant_model->insertDataReturnLastId('product_report', $product_report);
		
			$get_product_report = $this->db->select('*');
			$get_product_report = $this->db->from('product_report');
			$get_product_report = $this->db->where('product_code',$this->input->post('bulk_product_item'));
			$get_product_report = $this->db->order_by('id','desc');
			$get_product_report = $this->db->limit('1');
			$get_product_report = $this->db->get()->row();

			$opening_balance = $get_product_report->balance_qty;
			$product_balance = $opening_balance - 1;

			$product_report_old = array(
				'product_code'	=> $this->input->post('bulk_product_item'),
				'opening_qty'	=> $opening_balance,
				'purchase_qty'	=> 0,
				'bonusqty'		=> 0,
				'sales_qty'		=> 1,
				'balance_qty'   => $product_balance,
				'created_by'	=> $this->session->userdata('user_id'),
				'created_date'	=> date('Y-m-d H:i:s'),
			);
			$this->db->insert('product_report',$product_report_old);
			
			
			$inventory		= $this->Constant_model->getInventorydata($this->input->post('bulk_product_item'));

			$inventory_id	= $inventory->id;
			$gold_weight	= $inventory->gold_weight;
			$qty			= $inventory->qty;
			$old_ow_id		= $inventory->ow_id;
			$store_id       = $this->input->post('store_id');

			$getStore = $this->Constant_model->OutletWarehouseget($store_id);
			$newstoreQty = $getStore->s_stock + 1;

			$data_storeupdate = array(
				's_stock'			=> $newstoreQty,
				's_stock_upated'	=> $newstoreQty,
			);
			$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);


			$data_inventory = array(
				'ref_number'	=> $this->Gold_module->getTransFormNumber_inventory(),
				'ow_id'			=>	$this->input->post('store_id'),
				'product_code'	=>  $this->input->post('code'),
				'outlet_id'		=>	$this->input->post('outlet_id'),
				'gold_weight'	=>	$this->input->post('GoldWeight'),
				'qty'			=>	1,
				'type'			=>	'0',
				'date'			=>	date("Y-m-d H:i:s")
			);
			$inventroy_id = $this->Constant_model->insertDataReturnLastId('inventory', $data_inventory);
			$getStore_old = $this->Constant_model->OutletWarehouseget($old_ow_id);
			$newstoreQty_old = $getStore_old->s_stock - 1;

			$data_storeupdate_old = array(
				's_stock'			=> $newstoreQty_old,
				's_stock_upated'	=> $newstoreQty_old,
			);
			
			$this->Constant_model->UpdateStoreInventory($data_storeupdate_old, $getStore_old->store_id);
			
			$transfer = array (
				'sr_transform_no'		=> $this->input->post('stores_transform_form_no'),
				'ref_number'			=> $this->input->post('stores_transform_form_no'),
				'outlet_id'				=> $this->input->post('outlet_id'),
				'from_store'			=> $old_ow_id,
				'to_store'				=> $this->input->post('store_id'),
				'product_code'			=> $this->input->post('code'),
				'qty'					=> 1,
				'subtotal'				=> 0,
				'toStore_warehouse'		=> $getStore->store_id,
				'FromStore_warehouse'	=> $getStore_old->store_id,
				'createdby'				=> $this->session->userdata('user_id'),
				'date'					=> date('Y-m-d H:i:s'),
			);
			
			$this->Constant_model->insertDataReturnLastId('store_transform',$transfer);
			
			
			$data_reduce_inventory = array(
				'gold_weight' => $gold_weight - $this->input->post('GoldWeight'),
				'qty' => $qty-1,
			);

			$this->Constant_model->reduce_inventory($inventory_id,$data_reduce_inventory);

			$json['success'] = true;
		}
		else
		{
			$json['success'] = false;//false
		}
		
		#***********************************************
		# End of data insertion 
		#***********************************************

		$getTransformStock = $this->Gold_module->getTransformStock();
		$bulkvalue = '';
		$i = 1;
		
		foreach ($getTransformStock as $stock)
		{
			$bulkvalue.= '
				<tr>
					<td>'.$stock->ref_number.'</td>
					<td>'.date('d-m-Y H:i:s', strtotime($stock->date)).'</td>
					<td>'.$stock->product_code.'</td>
					<td>'.$stock->name.'</td>
					<td>'.$stock->outletname.'</td>
					<td>'.$stock->fromstore.'</td>
					<td>'.$stock->toname.'</td>
					<td>'.$stock->qty.'</td>
					<td>'.$stock->fullname.'</td>
					<td><button class="btn btn-primary ViewMoreDetail" id="'.$stock->id.'">View</button></td>
				</tr>';
		}
		
		$json['getTransFormNumber'] = $this->Gold_module->getTransFormNumber();
		$json['bulkvalue'] = $bulkvalue;
		echo json_encode($json);
	}
	
	//end here

	function getBulkTransaferStockDetail()
	{
		$html = '';
		$id = $this->input->post('id');
		$getTransformStock = $this->Gold_module->getBulkTransaferStockDetail($id);
		$html = '<div class="col-md-12"><table>'
						. '<tr><td>Outlet</td><td>'.$getTransformStock->outletname.'</td></tr>'
						. '<td>Product</td><td>'.$getTransformStock->name.'</td></tr>'
						. '<td>Product Code</td><td>'.$getTransformStock->product_code.'</td></tr>'
						. '<td>From Store</td><td>'.$getTransformStock->fromstore.'</td></tr>'
						. '<td>To Store</td><td>'.$getTransformStock->toname.'</td></tr>'
						. '<td>Qty</td><td>'.$getTransformStock->qty.'</td></tr>'
						. '<td>Product Weight(g)</td><td>'.$getTransformStock->GoldWeight.'</td></tr>'
						. '<td>Stone Weight</td><td>'.$getTransformStock->StoneWeight.'</td></tr>'
						. '<td>Net Gold Weight</td><td>'.$getTransformStock->NetGoldWeight.'</td></tr>'
						. '<td>Wastage(g) per 8g</td><td>'.$getTransformStock->Wastageperg.'</td></tr>'
						. '<td>Stone Cost</td><td>'.$getTransformStock->StoneCost.'</td></tr>'
						. '<td>Labour Cost</td><td>'.$getTransformStock->LabourCost.' </td></tr>'
						. '<td>OtherCost 1</td><td>'.$getTransformStock->OtherCost1.' </td></tr>'
						. '<td>OtherCost 2</td><td>'.$getTransformStock->OtherCost2.' </td></tr>'
						. '<td>OtherCost 3</td><td>'.$getTransformStock->OtherCost3.' </td></tr>'
						. '<td>Total Gold Weight</td><td>'.$getTransformStock->TotalGoldweight.' </td></tr>'
						. '<td>Gold Grade Current Price</td><td>'.$getTransformStock->GoldGradeCurrentPrice.' </td></tr>'
						. '<td>Total Gold Cost</td><td>'.$getTransformStock->TotalGoldCost.' </td></tr>'
						. '<td>Total All Other Cost</td><td>'.$getTransformStock->TotalAllOtherCost.' </td></tr>'
						. '<td>Transferred Cost</td><td>'.$getTransformStock->TransferredCost.' </td></tr>'
						. '<td>Note</td><td>'.$getTransformStock->note.' </td></tr>'
				. '</table></div>';
		$json['success'] = $html;
		echo json_encode($json);
	}

	
	// ****************** Get data For bulk transfer edit a3frt ************


	function get_edit_data($id = null)
	{
		$html = array();
		$getTransformStock = $this->Gold_module->getBulkTransaferStockDetail($id);
		
		$html['id']                    = $id;
		$html['outletname']            = $getTransformStock->outletname;
		$html['name']                  = $getTransformStock->name;
		$html['product_code']          = $getTransformStock->product_code;
		$html['fromstore']             = $getTransformStock->fromstore;
		$html['toname']                = $getTransformStock->toname;
		$html['qty']                   = $getTransformStock->qty;
		$html['GoldWeight']            = $getTransformStock->GoldWeight;
		$html['StoneWeight']           = $getTransformStock->StoneWeight;
		$html['NetGoldWeight']         = $getTransformStock->NetGoldWeight;
		$html['Wastageperg']           = $getTransformStock->Wastageperg;
		$html['StoneCost']             = $getTransformStock->StoneCost;
		$html['LabourCost']            = $getTransformStock->LabourCost;
		$html['OtherCost1']            = $getTransformStock->OtherCost1;
		$html['OtherCost2']            = $getTransformStock->OtherCost2;
		$html['OtherCost3']            = $getTransformStock->OtherCost3;
		$html['TotalGoldweight']       = $getTransformStock->TotalGoldweight;
		$html['GoldGradeCurrentPrice'] = $getTransformStock->GoldGradeCurrentPrice;
		$html['TotalGoldCost']         = $getTransformStock->TotalGoldCost;
		$html['TotalAllOtherCost']     = $getTransformStock->TotalAllOtherCost;
		$html['TransferredCost']	   = $getTransformStock->TransferredCost;
		$html['note'] 				   = $getTransformStock->note;

		
		$data['edit_data'] = $html;

		$data['getOutlets'] = $this->Constant_model->getOutlets();
		$data['getStore'] = $this->Constant_model->getStore();
		$data['getProduct'] = $this->Constant_model->getProductWareHouse();
		$data['getCategory'] = $this->Constant_model->getDataWhere('category');
		$data['getGoldGrade'] = $this->Constant_model->getDataWhere('gold_grade');
		$data['getgold_smith'] = $this->Constant_model->getDataWhere('gold_smith');
		$data['getTransFormNumber'] = $this->Gold_module->getTransFormNumber();


		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['getTransformStock']	= $this->Gold_module->getTransformStock();
		$data['UserLoginName'] = @$loginData[0]->fullname;
		$this->load->view('includes/header');
		$this->load->view('gold/edit_transfer_bulk_item',$data);
		$this->load->view('includes/footer');
	}

function update_data()
	{
	
		$id = $this->input->post('id');
		$id = (int)$id;
		$st_data = array(

			'outlet_id' => $this->input->post('outlet_id'),
			'to_store' => $this->input->post('store_id'),
			'to_store' => $this->input->post('store_id'),
		);

		$pro_data = array(

			'GoldWeight' => $this->input->post('GoldWeight'),
			'StoneWeight' => $this->input->post('StoneWeight'),
			'NetGoldWeight' => $this->input->post('NetGoldWeight'),
			'Wastageperg' => $this->input->post('Wastageperg'),
			'Wastagegold' => $this->input->post('Wastagegold'),
			'StoneCost' => $this->input->post('StoneCost'),
			'LabourCost' => $this->input->post('LabourCost'),
			'OtherCost1' => $this->input->post('OtherCost1'),
			'OtherCost2' => $this->input->post('OtherCost2'),
			'OtherCost3' => $this->input->post('OtherCost3'),
			'TotalGoldweight' => $this->input->post('TotalGoldweight'),
			'GoldGradeCurrentPrice' => $this->input->post('GoldGradeCurrentPrice'),
			'TotalGoldCost' => $this->input->post('TotalGoldCost'),
			'TotalAllOtherCost' => $this->input->post('TotalAllOtherCost'),
			'TransferredCost' => $this->input->post('TransferredCost'),
			'note' => $this->input->post('note')
		);

		
		$product_code = $this->Constant_model->get_store_transform_product_code($id);
		$product_id = $this->Constant_model->get_product_id($product_code[0]->product_code);

		$res1 = $this->Constant_model->update_bulk_transfer('store_transform',$id,$st_data);

		$res2 = $this->Constant_model->update_bulk_transfer('products',$product_id[0]->id,$pro_data);

		if($res1 && $res2)
		{
			$this->session->set_flashdata('update_msg', "Update successfull !!");
			redirect('Store/transfer_bulk_item');
		}
		else
		{
			$this->session->set_flashdata('update_msg', "Update Failed !!");
			redirect('Store/transfer_bulk_item');
		}
	}

	// ****************** Get data For bulk transfer edit a3frt  end************

		
	function categorywiseSubcategory()
	{
		$html = '';
		$category_id = $this->input->post('category_id');
		$getSubCategory = $this->Constant_model->getDataWhere('sub_category','category_id_fk='.$category_id);;
		$html.= '<option value="">Select Sub Category</option>';
		foreach ($getSubCategory as $subcateg)
		{
				$html.= '<option value='.$subcateg->id.'>'.$subcateg->sub_category.'</option>';	
		}

		$json['getSubcategory'] = $html;
		echo json_encode($json);
	}
		
		function FromStore()
		{
			$html = '';
			$storeid = $this->input->post('storeid');
			$outlet_id = $this->input->post('outlet_id');
			$getStore = $this->Gold_module->OutletWiseStore($outlet_id);
			$html.= '<option value="">Select To Store</option>';
			foreach ($getStore as $store)
			{
				if($storeid != $store->s_id)
				{
					$html.= '<option data-val='.$store->ow_id.' value='.$store->s_id.'>'.$store->s_name.'</option>';	
				}
			}
			
			$json['toStore'] = $html;
			echo json_encode($json);
		}
		
		function OutletWiseProductStore()
		{
			$html = '';
			$product = '';
			$outlet_id = $this->input->post('outlet_id');
			if(!empty($outlet_id))
			{
				$getStore = $this->Gold_module->OutletWiseStore($outlet_id);
				$html.= '<option value="">Select Store</option>';
				foreach ($getStore as $store)
				{
					$html.= '<option data-val='.$store->ow_id.' value='.$store->s_id.'>'.$store->s_name.'</option>';	
				}
				$json['store'] = $html;
				
				$getProduct = $this->Gold_module->getProductOutlet($outlet_id);
				$product.= '<option value="">Enter name / code</option>';
				foreach ($getProduct as $pro)
				{
					$product.= '<option value='.$pro->code.' data-weight='.$pro->weight.'>'.$pro->name.' ['.$pro->code.']</option>';	
				}
				$json['product'] = $product;
			}
			else
			{
				$getStore = $this->Constant_model->getStore();
				$html.= '<option value="">Select Store</option>';
				foreach ($getStore as $store)
				{
					$html.= '<option value='.$store->s_id.'>'.$store->s_name.'</option>';	
				}
				$json['store'] = $html;
				
				$getProduct = $this->Constant_model->getProductWareHouse();
				$product = '';
				$product.= '<option value="">Enter name / code</option>';
				foreach ($getProduct as $pro)
				{
					$product.= '<option value='.$pro->code.'>'.$pro->name.' ['.$pro->code.']</option>';	
				}
				
				$json['product'] = $product;
			}
			echo json_encode($json);
		}
		
		function getProductPurchasePrice()
		{
			$product_code = $this->input->post('product_code');
			$purchase = $this->Gold_module->getProductPurchasePrice($product_code);
			$json['price'] = $purchase->purchase_price;
			$json['name'] = $purchase->name;
			echo json_encode($json);
		}
		
		
		function InStockInventory()
		{
			$getInStock = $this->Gold_module->InStockInventory();
			$json['InStock'] = $getInStock;
			echo json_encode($json);
		}
		
		function SubmitTransformStore()
		{
			if(!empty($this->input->post('transfer')))
			{
				$transfer = $this->input->post('transfer');
				foreach ($transfer as $value)
				{
						//to inventory update
						$outlet_id		= $value['outlet_id'];
						$product_code	= $value['product_code'];
						$towarehouse  = $value['toStore_warehouse'];
						$to_inventory	= $this->Gold_module->toWareTransformInventory($towarehouse,$outlet_id,$product_code);
						if($to_inventory->num_rows()>0)
						{
							$update_qty		= $to_inventory->row()->qty + $value['qty'];
							$inventory_id	= $to_inventory->row()->id;
							$update_to_inventory  = array('qty' => $update_qty);
							$this->Gold_module->UpdateInventory($update_to_inventory,$inventory_id);
						}
						else
						{
							$insert_inventory  = array(

									'product_code' => $value['product_code'],
									'outlet_id'  =>$value['outlet_id'],
									'ow_id'      =>  $towarehouse,
									'qty'        => $value['qty'],
									'type'       => '0',
									'date'       => date('Y-m-d H:i:s'),
								);
							$this->Constant_model->insertDataReturnLastId('inventory',$insert_inventory);
						}
						
						
						
						//form inventory update
						
						$fromwarehouse		= $value['FromStore_warehouse'];
						$from_inventory		= $this->Gold_module->toWareTransformInventory($fromwarehouse,$outlet_id,$product_code);
						$from_qty			= $from_inventory->row()->qty - $value['qty'];
						$inventory_id_from	= $from_inventory->row()->id;
						$update_to_inventory_from  = array('qty' => $from_qty);
						$this->Gold_module->UpdateInventory($update_to_inventory_from,$inventory_id_from);
						
						// from Store update
						$from_store = $value['from_store'];
						$from_store_inventory = $this->Gold_module->get_store_data($from_store);
						$from_store_id  = $from_store_inventory->row()->s_id;
						$from_store_stock  = $from_store_inventory->row()->s_stock - $value['qty'];

						$update_store = array('s_stock' => $from_store_stock,
											's_stock_upated' => $from_store_stock,
									);
						$this->Gold_module->UpdateStock($update_store,$from_store_id);
						
						// to Store update
						$to_store = $value['to_store'];
						$to_store_inventory = $this->Gold_module->get_store_data($to_store);
						$to_store_id  = $to_store_inventory->row()->s_id;
						$to_store_stock  = $to_store_inventory->row()->s_stock + $value['qty'];
						$update_store_to = array('s_stock' => $to_store_stock,
											's_stock_upated' => $to_store_stock,
									);
						$this->Gold_module->UpdateStock($update_store_to,$to_store_id);
						
						
						$transfer = array ('sr_transform_no'	=> $this->input->post('stores_transform_form_no'),
							'outlet_id'				=> $value['outlet_id'],
							'from_store'			=> $value['from_store'],
							'to_store'				=> $value['to_store'],
							'product_code'			=> $value['product_code'],
							'qty'					=> $value['qty'],
							'subtotal'				=> $value['subtotal'],
							'toStore_warehouse'		=> $value['toStore_warehouse'],
							'FromStore_warehouse'	=> $value['FromStore_warehouse'],
							'createdby'				=> $this->session->userdata('user_id'),
							'date'					=> date('Y-m-d H:i:s'),
						);
						$success = $this->Constant_model->insertDataReturnLastId('store_transform',$transfer);
				}
			}
			
			$this->session->set_flashdata('SUCCESSMSG', "Stock Transform Successfully!!");
			$json['success'] = true;
			echo json_encode($json);
		}
		
	// Export Pay Suppliers;
    public function exportSuppliers()
    {
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;

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

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Pay Suppliers');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Sale Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Date');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet Name');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Supplier');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Grand Total');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Unpaid Amt');

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;

        $total_amt = 0;

        $orderResult = $this->db->query("SELECT * FROM purchase_order WHERE status=5 OR status=6 ORDER BY id DESC ");
        $orderData = $orderResult->result();

        for ($d = 0; $d < count($orderData); ++$d) {
            $order_id = $orderData[$d]->po_number;
            $cust_name = $orderData[$d]->supplier_name;
            $order_date = date("$setting_dateformat", strtotime($orderData[$d]->created_datetime));
            $outlet_name = $orderData[$d]->outlet_name;
            $grandTotal = $orderData[$d]->grandTotal;

            $total_amt += $grandTotal;
            $paid_amt = $orderData[$d]->paid_amt;

            $unpaid_amt = 0;
            $unpaid_amt = $paid_amt - $grandTotal;
            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$order_id");
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$order_date");
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$outlet_name");
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$cust_name");
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$grandTotal");
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$unpaid_amt");

            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);

            unset($order_id);
            unset($cust_name);
            unset($order_date);
            unset($outlet_name);
            unset($grandTotal);

            $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(20);

            ++$jj;
        }
        unset($orderResult);
        unset($orderData);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:D$jj");
        $objPHPExcel->getActiveSheet()->setCellValue("A$jj", 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$total_amt");

        $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="PaySuppliers_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    ###########################################################################
    ### add by a3frt date: 31 Oct 2017 |||| start 							###
    ###########################################################################

 	function import_transferBulkItem()
 	{
 		$this->load->view('includes/header');
 		$this->load->view('gold/import_transferBulkItems');
 		$this->load->view('includes/footer');
 	}

 	function insert_import_transferBulkItem()
 	{
 		if($this->input->post())
 		{
 			 		$file_directory		= 'assets/importTransferBulk/';
 			 		$new_file_name		= date("dmYHis").rand(000000, 999999).$_FILES["result_file"]["name"];
 			 		$ck = move_uploaded_file($_FILES["result_file"]["tmp_name"], $file_directory . $new_file_name);
 			 		$file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
 			 		$objReader	= PHPExcel_IOFactory::createReader($file_type);
 			 		$objPHPExcel = $objReader->load($file_directory . $new_file_name);
 			 		$sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
 			 		$i = 0;
  
    $data = array_map('array_filter', $sheet_data);
    $sheet_data = array_filter($data);

  
 			 		foreach ($sheet_data as $data)
 			 		{
 			 			if($i != 0)
 			 			{
 			 				$outletName = !empty($data['A']) ? $data['A'] : '';
 			 				$receivingStore = !empty($data['B']) ? $data['B'] : '';
 			 				$category = !empty($data['C']) ? $data['C'] : '';
 			 				$subCategory = !empty($data['D']) ? $data['D'] : '';
 			 				$goldsmith = !empty($data['E']) ? $data['E'] : '';
 			 				$productName  = !empty($data['F']) ? $data['F'] : '';
 			 				$goldGrade = !empty($data['G']) ? $data['G'] : '';
 			 				$productWeight  = !empty($data['H']) ? $data['H'] : '';
 			 				$stoneWeight  = !empty($data['I']) ? $data['I'] : '';
 			 				$wastage = !empty($data['J']) ? $data['J'] : '';
 			 				$stoneCost = !empty($data['K']) ? $data['K'] : '';
 			 				$labourCost = !empty($data['L']) ? $data['L'] : '';
 			 				$otherCost1 = !empty($data['M']) ? $data['M'] : '';
 			 				$otherCost2 = !empty($data['N']) ? $data['N'] : '';
 			 				$otherCost3 = !empty($data['O']) ? $data['O'] : '';

 			 				$reserence_store_transform =  $this->Gold_module->getTransFormNumber();
 			 				$reserence_store_inventory = $this->Gold_module->getTransFormNumber_inventory();

 			 				$date =  date('Y-m-d H:i:s');

 			 				# fetching cataogy id and sub category id outlet id store id start

 			 				$caidarray = $this->Constant_model->getCategory_id($category);
 			 				$subidarray = $this->Constant_model->getSunCategory_id($subCategory);
 			 				$getOutletIdarray =  $this->Constant_model->getOutletId($outletName);
 			 				$getProducttIdArray =  $this->Constant_model->getProducttId($productName);
 			 				$getStoresIdArray =  $this->Constant_model->getStoresId($receivingStore);

                           
						if(empty($caidarray) || empty($subidarray) || empty($getOutletIdarray) || empty($productName) || empty($getStoresIdArray))
						{
						$this->session->set_flashdata('import_error_message', "File not imported,Please check data and Try again.");
						redirect('Store/import_transferBulkItem');
						}
						else
						{
					
 			 				if(!empty($caidarray))
 			 				{
 			 					$category__id = $caidarray[0]->id;
 			 				}
 			 				else
 			 				{
 			 					$category__id = 0;	
 			 				}

 			 				if(!empty($subidarray))
 			 				{
 			 					$subcat__id = $subidarray[0]->id;
 			 				}
 			 				else
 			 				{
 			 					$subcat__id = 0;	
 			 				}
 			 				if(!empty($getOutletIdarray))
 			 				{
 			 					$getOutletId = $getOutletIdarray[0]->id;
 			 				}
 			 				else
 			 				{
 			 					$getOutletId = 0;	
 			 				}
 			 				if(!empty($getProducttIdArray))
 			 				{
 			 					$getProducttId = $getProducttIdArray[0]->id;
 			 				}
 			 				else
 			 				{
 			 					$getProducttId = 0;	
 			 				}
 			 				if(!empty($getStoresIdArray))
 			 				{
 			 					$getStoresId = $getStoresIdArray[0]->s_id;
 			 				}
 			 				else
 			 				{
 			 					$getStoresId = 0;	
 			 				}


 			 				# fetching category id and subcategory id outlet id store id end

 							$getCode = $this->Product_Code_Numbering_model->getProductCodeCategorySubcategory($category__id,$subcat__id);
                           
						  // echo '<pre>';
						 //  print_r($getCode);
						  // die;

							
							
							
 							$concate = '';
 							$changeNewdate= '';
 							$profecctional_code = '';
 							if(!empty($getCode))
 							{
 									$now			= strtotime($getCode->updated_date);
 									$your_date		= date('Y-m-d',  strtotime($getCode->created_date));
 									$finalmydate	= strtotime($your_date);
 									$datediff		= $now - $finalmydate;
 									$totalday		= floor($datediff / (60 * 60 * 24));

 									$auto_generate_code = $getCode->auto_generate_code;
 									$product_num_id = $getCode->id;
 									$updated_date = $getCode->updated_date;
 									if(!empty($getCode->change_daily))
 									{
 										$today = date('Y-m-d');
 										if($today == $updated_date)
 										{
 											$changeNewdate = $getCode->created_date;
 											$profecctional_code = $getCode->updated_number;
 										}
 										else
 										{
 											$changeNewdate = $getCode->created_date;
 											$profecctional_code = $getCode->auto_generate_code;
 										}
 									}
 									else if(!empty($getCode->change_weekly))
 									{
 										if($totalday<=7)
 										{
 											$changeNewdate = $getCode->created_date;
 											$profecctional_code = $getCode->updated_number;
 										}
 										else
 										{
 											$changeNewdate = date('Y-m-d H:i:s');
 											$profecctional_code = $getCode->auto_generate_code;
 										}
 									}
 									else if(!empty($getCode->change_monthly))
 									{
 										if($totalday<=30)
 										{
 											$changeNewdate = $getCode->created_date;
 											$profecctional_code = $getCode->updated_number;
 										}
 										else
 										{
 											$changeNewdate = date('Y-m-d H:i:s');
 											$profecctional_code = $getCode->auto_generate_code;
 										}
 									}
 									else if(!empty($getCode->change_yearly))
 									{
 										if($totalday<=365)
 										{
 											$changeNewdate = $getCode->created_date;
 										$profecctional_code = $getCode->updated_number;
 										}
 										else
 										{
 											$changeNewdate = date('Y-m-d H:i:s');
 										$profecctional_code = $getCode->auto_generate_code;
 										}
 									}
 									
 									$current_year = ($getCode->current_year == 1)?date('Y'):'';
 									$current_month = ($getCode->current_month == 1)?date('m'):'';
 									$current_day = ($getCode->current_day == 1)?date('d'):'';
 									$prefix = $getCode->prefix;
 									$concate = $prefix.$current_year.$current_month.$current_day.'-'.$profecctional_code;
									
									
 							} 	

 							$product_code = $concate;

 							$NetGoldWeight = (float)($productWeight - $stoneWeight);
 							$Wastagegold   = (float)(($NetGoldWeight/8)*$wastage);
 							$TotalGoldweight = (float)($NetGoldWeight + $Wastagegold);

 							$grade_name = $goldGrade;
 								
 							$get_grade = $this->Constant_model->getLastGoldGradePrice();

 							$gold_purity =  $this->Constant_model->gold_gold_purity($goldGrade);

 							//$get_grade_id = $gold_purity[0]->grade_id;
 							//$gold_purity = $gold_purity[0]->gold_purity;
                            
							$get_grade_id = !empty($gold_purity[0]->grade_id)?$gold_purity[0]->grade_id:0;
 							$gold_purity  = !empty($gold_purity[0]->gold_purity)?$gold_purity[0]->gold_purity:0;
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
 							$GoldGradeCurrentPrice = $cal;

 							$TotalGoldCost = $TotalGoldweight * $GoldGradeCurrentPrice;

 							$TotalAllOtherCost = $stoneCost + $labourCost + $otherCost1 + $otherCost2 + $otherCost3;

 							$TransferredCost = $TotalAllOtherCost + $TotalGoldCost;
 							$user =  $this->session->userdata('user_id');

 						#***********************************************************************#
 						#	             **Import insert start by a3frt						    #
 						#***********************************************************************#
 							
							$ins_data = array(
 								'code'					=> $product_code,
 								'name'					=> $productName,
 								'category'				=> $category__id,
 								'sub_category_id_fk'	=> $subcat__id,
 								'grade_id'				=> $get_grade_id,
 								'GoldWeight'			=> $productWeight,
 								'StoneWeight'			=> $stoneWeight,
 								'NetGoldWeight'			=> $NetGoldWeight,
 								'weight'				=> $productWeight,
								'product_type'          => 'bulk',
 								'Wastageperg'			=> $wastage,
 								'Wastagegold'			=> $wastage,
 								'StoneCost'				=> $stoneCost,
 								'LabourCost'			=> $labourCost,
 								'OtherCost1'			=> $otherCost1,
 								'OtherCost2'			=> $otherCost2,
 								'OtherCost3'			=> $otherCost3,
 								'TotalGoldweight'		=> $TotalGoldweight,
 								'GoldGradeCurrentPrice'	=> $GoldGradeCurrentPrice,
 								'TotalGoldCost'			=> $TotalGoldCost,
 								'TotalAllOtherCost'		=> $TotalAllOtherCost,
 								'TransferredCost'		=> $TransferredCost,
 								'note'					=> 'No note',
 								'start_qty'				=> 1,
 								'thumbnail'				=> 'no_image.jpg',
 								'status'				=> '1',
 								'outlet_id_fk'			=> $getOutletId,
 								'created_datetime'		=> date('Y-m-d H:i:s'),
 								'created_user_id'		=> $this->session->userdata('user_id'),
 							);

 							
 							$product_report = array(
 								'opening_qty'	=> 1,
 								'product_code'	=> $product_code,
 								'purchase_qty'	=> 0,
 								'sales_qty'		=> 0,
 								'balance_qty'   => 1,
 								'created_by'	=> $this->session->userdata('user_id'),
 								'created_date'	=> date('Y-m-d H:i:s')
 							);

 							
								
							
							$ckPcodeData = $this->Constant_model->getDataOneColumn('products', 'code',$product_code); 
								
 							if (count($ckPcodeData) == 0) {
 								
 								if(!empty($product_num_id))
 								{
 									$code_num_array = array(
 										'created_date'		=> $changeNewdate,
 										'updated_number'	=> $profecctional_code+1,
 										'updated_date'		=> date('Y-m-d'),
 									);
 									$this->Constant_model->UpdateProductCodeNumber($code_num_array,$product_num_id);  
 								}
							$this->Constant_model->insertDataReturnLastId('products', $ins_data); //done by a3frt
							$this->Constant_model->insertDataReturnLastId('product_report', $product_report); // done by a3frt 
 							
				
				//////////////////////////////////////////   13/12/2017   ///////////////////////////////////////
				//$sid = '1';
				$outlet_id = $getOutletId;
				$getStore = $this->Products_model->get_warehouse_outletwise_store($outlet_id);
				$getStoree = $getStore->result();
				$sid = $getStoree[0]->ow_id;
					
				
				$getStoreId = $this->Products_model->get_warehouse_outletwise($outlet_id);
				$store_id = $getStoreId[0]->ow_id;
								
				$getStore = $this->Constant_model->OutletWarehouseget($sid);
				$oldstore = $getStore->s_stock;
				$newstoreQty = $getStore->s_stock + 1;

				$data_storeupdate = array(
					's_stock'			=> $newstoreQty,
					's_stock_upated'	=> $newstoreQty,
				);
							
				$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);
							
				$data_inventory = array(
					'ow_id'			=>	$sid,
					'product_code'	=>  $product_code,
					'outlet_id'		=>	$getOutletId,
					'qty'			=>	1,
					'type'			=>	'0',
					'gold_weight'	=>  $productWeight,
					'date'			=>	date("Y-m-d H:i:s")
				);
						
				$inventroy_id = $this->Constant_model->insertDataReturnLastId('inventory', $data_inventory);
														
                $getProducttId = $product_code;
								
				//////////////////////////////////////////   13/12/2017   ///////////////////////////////////////
 								#done by a3frt.....
 								$get_product_report = $this->db->select('*');
 								$get_product_report = $this->db->from('product_report');
 								$get_product_report = $this->db->where('product_code',$getProducttId);
 								$get_product_report = $this->db->order_by('id','desc');
 								$get_product_report = $this->db->limit('1');
 								$get_product_report = $this->db->get()->row();

 								$opening_balance = $get_product_report->balance_qty;
 								$product_balance = $opening_balance - 1;

 								$product_report_old = array(
 									'product_code'	=> $getProducttId,
 									'opening_qty'	=> $opening_balance,
 									'purchase_qty'	=> 0,
 									'bonusqty'		=> 0,
 									'sales_qty'		=> 1,
 									'balance_qty'   => $product_balance,
 									'created_by'	=> $this->session->userdata('user_id'),
 									'created_date'	=> date('Y-m-d H:i:s'),
 								);

 								$this->db->insert('product_report',$product_report_old); #done

 								$inventory		= $this->Constant_model->getInventorydata($getProducttId);

 								$inventory_id	= $inventory->id;
 								$gold_weight	= $inventory->gold_weight;
 								$qty			= $inventory->qty;
 								$old_ow_id		= $inventory->ow_id;
 								$store_id       = $store_id; // 2 $getStoresId; Showroom Store 

 								$getStore = $this->Constant_model->OutletWarehouseget($store_id);
 								$newstoreQty = $getStore->s_stock + 1;

 								$data_storeupdate = array(
 									's_stock'			=> $newstoreQty,
 									's_stock_upated'	=> $newstoreQty,
 								);
 								$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);  #Done

 								$data_inventory = array(
 									'ref_number'	=> $this->Gold_module->getTransFormNumber_inventory(),
 									'ow_id'			=>	$store_id,
 									'product_code'	=>  $product_code,
 									'outlet_id'		=>	$getOutletId,
 									'gold_weight'	=>	$productWeight,
 									'qty'			=>	1,
 									'type'			=>	'0',
 									'date'			=>	date("Y-m-d H:i:s")
 								);
 								$inventroy_id = $this->Constant_model->insertDataReturnLastId('inventory', $data_inventory);  #Done

 								$getStore_old = $this->Constant_model->OutletWarehouseget($old_ow_id);
 								$newstoreQty_old = $getStore_old->s_stock - 1;

 								$data_storeupdate_old = array(
 									's_stock'			=> $newstoreQty_old,
 									's_stock_upated'	=> $newstoreQty_old,
 								);
 								
 								$this->Constant_model->UpdateStoreInventory($data_storeupdate_old, $getStore_old->store_id);  #Done

 								$transfer = array (
 									'sr_transform_no'		=> $this->Gold_module->getTransFormNumber(),
 									'ref_number'			=> $this->Gold_module->getTransFormNumber(),
 									'outlet_id'				=> $getOutletId,
 									'from_store'			=> $old_ow_id,
 									'to_store'				=> $getStoresId,
 									'product_code'			=> $product_code,
 									'qty'					=> 1,
 									'subtotal'				=> 0,
 									'toStore_warehouse'		=> $getStore->store_id,
 									'FromStore_warehouse'	=> $getStore_old->store_id,
 									'createdby'				=> $this->session->userdata('user_id'),
 									'date'					=> date('Y-m-d H:i:s'),
 								);

 								$this->Constant_model->insertDataReturnLastId('store_transform',$transfer);  #Done					
 								$data_reduce_inventory = array(
 									'gold_weight' => $gold_weight - $productWeight,
 									'qty' => $qty-1
 								);

 								$this->Constant_model->reduce_inventory($inventory_id,$data_reduce_inventory);  #Done

 							} # end of if and insert and update

 						#***********************************************************************#
 						#	             **Import insert End by a3frt						    #
 						#***********************************************************************#
						
						}
						
 			 			}

 			 			$i++;
 			 		}

 			 		$this->session->set_flashdata('import_message', "Import  successfull !!");
 			 		redirect('Store/transfer_bulk_item');
 		}

 		else
 		{
 			redirect('Store/import_transferBulkItem');
 		}

 		
 	}


    ###########################################################################
    #     ## add by a3frt date: 31 Oct 2017 |||| End 						  #
    ###########################################################################
		
		
}