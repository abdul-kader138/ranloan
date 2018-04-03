<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Products_model');
        $this->load->model('Constant_model');
        $this->load->model('Inventory_model');
        $this->load->model('Pos_model');
        $this->load->model('Product_Code_Numbering_model');
        $this->load->model('Sales_model');
//         $this->load->model('Gold_module');

        $this->load->library('pagination');
        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;
		require_once APPPATH.'third_party/PHPExcel.php';
		$this->excel = new PHPExcel(); 
        date_default_timezone_set("$setting_timezone");
		if($this->session->userdata('user_id') == "")
		{
			redirect(base_url());
		}
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }

	public function expireDetail() 
	{
		$data['expireDetail'] = $this->Products_model->getExpireDetail();
        $this->load->view('expire_detail',$data);
    }
	
	public function cron_product_report()
    {
        $product_entry = $this->Constant_model->getProduct();
		foreach ($product_entry as $value)
		{
			$product_report = array(
					'product_code'	=> $value->code,
					'opening_qty'	=> $value->start_qty,
					'purchase_qty'	=> 0,
					'sales_qty'		=> 0,
					'balance_qty'   => $value->start_qty,
					'created_by'	=> $this->session->userdata('user_id'),
					'created_date'	=> date('Y-m-d H:i:s'),
				);
			$this->Constant_model->insertDataReturnLastId('product_report', $product_report);
		}
    }
	
    // ****************************** View Page -- START ****************************** //

    // View Product Category;
    public function product_category()
    {
		$permisssion_url = 'product_category';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
	    $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;

        $config = array();
        $config['base_url'] = base_url().'products/product_category/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Products_model->record_category_count();
        $config['per_page'] = $pagination_limit;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = '<li>';
        $config['next_tagl_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tagl_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Products_model->fetch_category_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Products_model->record_category_count();
            $sh_text = 'Showing 1 to '.count($data['results']).' of '.$this->Products_model->record_category_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Products_model->record_category_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;

        $this->load->view('category', $data);
    }

    // Add New Product Category;
    public function addproductcategory()
    {
        $this->load->view('add_product_category');
    }

    // Edit Product Category;
    public function editproductcategory()
    {
        $id = $this->input->get('id');

        $data['id'] = $id;
        $this->load->view('edit_product_category', $data);
    }

    // View Products;
    public function list_products()
    {
			
		$permisssion_url = 'list_products';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['Category_List'] =  $this->Products_model->Category_List();
        $data['results'] = $this->Products_model->fetch_product_data();
		$this->load->view('products', $data);
    }
	
	// Import Product
	public function import_product()
    {

		
		$data['getSubCategory']	= $this->Constant_model->getSubCategory();
		$data['Category_List']	= $this->Constant_model->getCategory();
		$data['getBrand']		= $this->Constant_model->getBrand();
		$data['getSupplier']	= $this->Constant_model->getSuppliers();
		$data['getOutlet']      = $this->Constant_model->getOutlets();
		$this->load->view('import_product',$data);
    }
	
	public function getSubCategoryFilter()
	{
		$html = '';
		$category_id = $this->input->post('category_id');
		$subCategory = $this->Constant_model->getSubCategoryFilter($category_id);
		$html.= '<option value="">Select Sub Category</option>';
		foreach ($subCategory as $value)
		{
			$html.= '<option value='.$value->id.'>'.$value->sub_category.'</option>';
		}
		$json['html'] = $html;
		echo json_encode($json);
	}
	
	public function getWarehouseTank()
	{
		$html = '';
		$outletid	 = $this->input->post('outlet_id');
		$category_id = $this->input->post('category_id');
		
		$warehouses = $this->Products_model->get_warehouse_outletwise($outletid);
		$html.= '<div class="form-group">
				<label>Warehouse <span style="color: #F00">*</span></label>
				<select name="warehouse_tank_id" required class="form-control">
					<option value="">Select Warehouse</option>';

		foreach ($warehouses as $value)
		{
			$html.= '<option value='.$value->s_id.'>'.$value->s_name.'</option>';
		}
		$html.= '</select></div>';			
		$json['success'] = $html;
		echo json_encode($json);
	}
	
	
	public function insert_import_product()
	{
		$category_id		= $this->input->post('category_id');
		$outlet_id			= $this->input->post('outlet_id');
		$subCategory_id		= $this->input->post('sub_category_id');
		$warehouse_tank_id	= $this->input->post('warehouse_tank_id');
		
		$file_directory		= 'assets/product_import/';
		$new_file_name		= date("dmYHis").rand(000000, 999999).$_FILES["result_file"]["name"];
		move_uploaded_file($_FILES["result_file"]["tmp_name"], $file_directory . $new_file_name);

		$file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
		$objReader	= PHPExcel_IOFactory::createReader($file_type);
		$objPHPExcel = $objReader->load($file_directory . $new_file_name);
		$sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		$i = 0;
		foreach ($sheet_data as $data)
		{
			if($i != 0)
			{
				if(!empty($data['A']))
				{
					
					
					$count = $this->Products_model->CheckProductCode($data['A']);
					if($count == 0)
					{
						if(!empty($data['J']))
						{
							$supplier = $this->Products_model->CheckSupplierEmail($data['J']);
							if($supplier->num_rows() == 0)
							{
								$array_supplier  = array(
									'name'				=> !empty($data['I'])?$data['I']:'',
									'email'				=> !empty($data['J'])?$data['J']:'',
									'address'			=> !empty($data['K'])?$data['K']:'',
									'created_user_id'	=> $this->session->userdata('user_id'),
									'created_datetime'	=> date('Y-m-d H:i:s'),
									'status'			=> 1,
								); 
								$supplier_id = $this->Products_model->InsertSupplier($array_supplier);
							}
							else
							{
								$supplier_id = $supplier->row()->id;
							}
						}
						if(!empty($data['N']))
						{
							$brand = $this->Products_model->CheckBrandName($data['N']);
							if($brand->num_rows() == 0)
							{
								$array_brand  = array(
									'brand'		 => !empty($data['L'])?$data['L']:'',
									'created_by' => $this->session->userdata('user_id'),
									'created_at' => date('Y-m-d H:i:s'),
								); 

								$brand_id = $this->Products_model->InsertBrand($array_brand);
							}
							else
							{
								$brand_id = $brand->row()->id;
							}
						}
						
						
						$product_report = array(
								'product_code'	=> !empty($data['A'])?$data['A']:'',
								'opening_qty'	=> !empty($data['E'])?str_replace(",", "", $data['E']):'0',
								'purchase_qty'	=> 0,
								'sales_qty'		=> 0,
								'balance_qty'   => !empty($data['E'])?str_replace(",", "", $data['E']):'0',
								'created_by'	=> $this->session->userdata('user_id'),
								'created_date'	=> date('Y-m-d H:i:s'),
						);
				
						
						
						$array = array(
								'code'				=> !empty($data['A'])?$data['A']:'',
								'name'				=> !empty($data['B'])?$data['B']:'',
								'category'			=> !empty($category_id)?$category_id:'',
								'sub_category_id_fk'=> !empty($subCategory_id)?$subCategory_id:'',
								'purchase_price'	=> !empty($data['C'])?str_replace(",", "", $data['C']):0,
								'retail_price'		=> !empty($data['D'])?str_replace(",", "", $data['D']):0,
								'start_qty'			=> !empty($data['E'])?str_replace(",", "", $data['E']):0,
								'rack'				=> !empty($data['F'])?$data['F']:'0',
								'weight'			=> !empty($data['G'])?$data['G']:'0',
								'alt_qty'			=> !empty($data['H'])?$data['H']:'0',
								'brand_id_fk'		=> !empty($brand_id)?$brand_id:'',
								'supplier_id_fk'	=> !empty($supplier_id)?$supplier_id:'',
								'thumbnail'			=> 'no_image.jpg',
								'status'			=> '1',
								'product_add_from'	=> 'Import Product',
								'outlet_id_fk'		=> !empty($outlet_id)?$outlet_id:'',
								'created_datetime'	=> date('Y-m-d H:i:s'),
								'created_user_id'	=> $this->session->userdata('user_id'),
						);

						
							$getStore		= $this->Constant_model->OutletWarehouseget($warehouse_tank_id);
							$oldstore		= $getStore->s_stock;
							$newstoreQty	= $getStore->s_stock + !empty($data['E'])?$data['E']:0;

							$data_storeupdate = array(
								's_stock'		 => !empty($newstoreQty)?$newstoreQty:0,
								's_stock_upated' => !empty($newstoreQty)?$newstoreQty:0,
							);

							$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);

							$outlet_id_array = $this->db->select('out_id')->where('ow_id',$warehouse_tank_id)->get('outlet_warehouse')->row_array();
							$outlet_id = $outlet_id_array['out_id'];

							$data_inventory = array(
								'ow_id'			=> $warehouse_tank_id,
								'product_code'  => !empty($data['A'])?$data['A']:0,
								'outlet_id'		=> !empty($outlet_id)?$outlet_id:0,
								'qty'			=> !empty($data['E'])?$data['E']:0,
								'type'			=> '0',
								'date'			=> date("Y-m-d H:i:s")
							);

						$this->Constant_model->insertDataReturnLastId('inventory', $data_inventory);
						
						$this->Constant_model->insertDataReturnLastId('products', $array);
						$this->Constant_model->insertDataReturnLastId('product_report', $product_report);
					}
				}
			}
			$i++;
		}
		$this->session->set_flashdata('SUCCESSMSG', "Product Added Successfully!!");
		redirect('products/import_product');
		
	}
	
    // Add Product;
    public function addproduct()
    {
	
		$data['Category'] = $this->Constant_model->getDataOneColumn('category', 'status', '1');
		$data['brand'] = $this->Constant_model->getDataOneColumn('brand', 'status', '0');
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='list_products')");
		
		if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add products', 'You can not add products. Please ask administrator!'));
			redirect($this->agent->referrer());
		}
		
		
		$loginUserId= $this->session->userdata('user_id');
        $loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		
        $data['UserLoginName'] =  $loginData[0]->fullname;
        $data['loginUserId'] =  $loginUserId;
		$data['getGoldGradedata']  = $this->Constant_model->getGoldGrade();
        $this->load->view('add_product',$data);
    }
	
    // Add Product;
    public function add_bulk_product()
    {
		$data['Category'] = $this->Constant_model->getDataOneColumn('category', 'status', '1');
		$data['brand'] = $this->Constant_model->getDataOneColumn('brand', 'status', '0');
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='list_products')");
		
		if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add products', 'You can not add products. Please ask administrator!'));
			redirect($this->agent->referrer());
		}
		
		
		$loginUserId= $this->session->userdata('user_id');
        $loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		
        $data['UserLoginName'] =  $loginData[0]->fullname;
        $data['loginUserId'] =  $loginUserId;
		$data['getGoldGradedata']  = $this->Constant_model->getGoldGrade();
        $this->load->view('add_bulk_product',$data);
    }
	
	
	public function getProductCode()
	{
		$category		= $this->input->post('category');
		$sub_category	= $this->input->post('sub_category');
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
	
		echo json_encode($json);
	}
	
	public function reorder_detail()
	{
		$permisssion_url = 'reorder_detail';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		if(!empty($this->input->get('notify')))
		{
			$this->Products_model->UpdateReorderNotification($this->input->get('notify'));
		}
		
		$data['getOutlets']			= $this->Constant_model->getOutlets();
		$data['getCategory']		= $this->Constant_model->getCategory();
		$data['getReorderDetail']	= $this->Products_model->getReorderDetail();
		$this->load->view('reorder_detail',$data);
	}
	
	public function reorder_print() {
		$id = $this->input->get('id');
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		$data['result'] = $this->Products_model->getReorderPrint($id);
		$this->load->view('reorder_print',$data);
	}
	
	
	
	public function productDetail() {
        $id = $this->input->get('id');
		$data['id'] = $id;
	    $this->load->view('product_detail', $data);
    }
	
	
	
	
	public function CheckProductCode()
	{
		$product_code = $this->input->post('product_code');
		$count = $this->Products_model->CheckProductCode($product_code);
		if($count>0)
		{
			$json['found'] = true;
		}
		else
		{
			$json['error'] = FALSE;
		}
		echo json_encode($json);
	}
	public function get_Sub_Category($category_id) {
        $query_get_sub_category = $this->db->get_where('sub_category',array('category_id_fk'=>$category_id,'status'=>0))->result();
        $HTML = NULL;
           $HTML .="<option value=''>-----Select Category-----</option>";
        foreach ($query_get_sub_category as $row)  
        { 

           $HTML .="<option value='".$row->id."' >".$row->sub_category."</option>";
        } 
        echo $HTML;
    }
	public function get_Supplier($brand_id) {
      if(!empty($brand_id))
		{
			$query_get_supplier = $this->db->get_where('brand_suppliers',array('brand_id_fk'=>$brand_id))->result();
			$HTML ='';
			$HTML .="<option value=''>Select Supplier</option>";
			foreach ($query_get_supplier as $value) {
				$a = $this->db->get_where('suppliers',array('id'=>$value->supplier_id_fk))->row();
				$HTML .="<option value='".$a->id."'>".$a->name."</option>";
			}
			echo $HTML;
		}
		else
		{
			$query_get_supplier = $this->db->get('suppliers')->result();	
			$HTML ='';
			$HTML .="<option value=''>Select Supplier</option>";
			foreach ($query_get_supplier as $value) {
				$HTML .="<option value='".$value->id."'>".$value->name."</option>";
			}
			echo $HTML;
		}
    }
	public function get_warehouse_outletwise()
	{
		$html = '';
		$outlet_id = $this->input->post('val');
		$getSubCategoryvalue = $this->input->post('getSubCategoryvalue');
	
			$default = $this->Products_model->getDefaultStore();
			
			$warehouses = $this->Products_model->get_warehouse_outletwise($outlet_id);
			if(!empty($warehouses))
			{
				$c = 0;
				foreach ($warehouses as $ware)
				{
					$html.= '<tr>
							<td>
								<input type="hidden"  name="inventroy['.$c.'][ow_id]" class="form-control"  value='.$ware->ow_id.' >
								'.$ware->s_name.'
							</td>
							<td class="warehouse_product_quantity">
								<input id='.$ware->ow_id.' type="number" name="inventroy['.$c.'][warehouse_quantity]" class="form-control warehouse_quantity" min="0" max="5" value="0" style="width: 100%;">
							</td>
						</tr>';
					$c++;
				}
				$html.= '<tr>
							<td>
								<input type="hidden"  name="inventroy['.$c.'][ow_id]" class="form-control"  value='.$default->ow_id.' >
								'.$default->s_name.'
							</td>
							<td class="warehouse_product_quantity">
								<input id='.$default->ow_id.' type="number" name="inventroy['.$c.'][warehouse_quantity]" class="form-control warehouse_quantity" min="0" max="5" value="0" style="width: 100%;">
							</td>
						</tr>';
				$html.='<tr>
							<td></td>
							<td><button type="button" class="btn btn-success" id="add_to_warehouse" style="background-color: green; ">Add To Warehouse</button></td>
						</tr>';
			}
			else
			{
				$html.='<tr><td colspan="100%">Not Found Warehouse!!</td></tr>';
			}
			
		$json['warehousecount'] = count($warehouses);
		$json['warehousedata'] = $html;
		echo json_encode($json);
	}
	
	
	public function get_warehouse_outletwise_bulk()
	{
		$default_store = $this->Pos_model->getDefaultCustomer();
		$default_store_id = $default_store->default_store_id;
		$html = '';
		$outlet_id = $this->input->post('val');
		$warehouses = $this->Products_model->get_warehouse_outletwise($outlet_id);
		foreach ($warehouses as $store)
		{
			$selected = '';
			if($store->w_id == $default_store_id)
			{
				$selected = "selected";
			}
			//$html.= '<option '.$selected.' value="'.$store->w_id.'">'.$store->s_name.'</option>'; // New 16/12/2017
			$html.= '<option '.$selected.' value="'.$store->ow_id.'">'.$store->s_name.'</option>'; //Old Code 

		}
		$json['warehousedata'] = $html;
		echo json_encode($json);
	}
	
	public function get_warehouse_outletwise_bulk_store()
	{
		$html = '';
		$outlet_id = $this->input->post('val');
		$warehouses = $this->Products_model->get_warehouse_outletwise_store($outlet_id);
		$html.= '<option value="">Select Store</option>';
		foreach ($warehouses->result() as $store)
		{
			if ($store->ow_id == 1) {
		       $selected = 'selected';
		   } else {
		       $selected = '';
		   }
			$html.= '<option value="'.$store->ow_id.'" '.$selected.'>'.$store->s_name.'</option>';
		}
		
		$json['warehousedata'] = $html;
		$json['num_rows'] = $warehouses->num_rows();
		echo json_encode($json);
	}
	

    // Edit Product;
    public function editproduct()
    {
        $id = $this->input->get('id');
		$user_id = $this->session->userdata('user_id');
		
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $user_id);
		$data['UserLoginName'] = $loginData[0]->fullname; 
		$data['loginUserId'] = $user_id;
		
		
		$data['Category'] = $this->Constant_model->getDataOneColumn('category', 'status', '1');
		$data['getSuppliers'] = $this->Constant_model->getDataOneColumn('suppliers', 'status', '1');
		$data['brand'] = $this->Constant_model->getDataOneColumn('brand', 'status', '0');
		$data['getProductEdit'] = $this->Products_model->getEditProduct($id);
        $this->load->view('edit_product', $data);
    }

    // Print Label;
    public function print_label()
    {
		$permisssion_url = 'print_label';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;

        $config = array();
        $config['base_url'] = base_url().'products/print_label/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Products_model->record_label_count();
        $config['per_page'] = $pagination_limit;
        $config['uri_segment'] = 3;

        $config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = '<li>';
        $config['next_tagl_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tagl_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Products_model->fetch_label_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Products_model->record_label_count();
            $sh_text = 'Showing 1 to '.count($data['results']).' of '.$this->Products_model->record_label_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Products_model->record_label_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;

        $this->load->view('print_label', $data);
    }

    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

    // Delete Product;
    public function deleteProduct()
    {
        $prod_id = $this->input->post('prod_id');
        $prod_name = $this->input->post('prod_name');
        
        $prod_code		= "";
		$prodDtaData 	= $this->Constant_model->getDataOneColumn("products", "id", $prod_id);
		if(count($prodDtaData) > 0){
			$prod_code 		= $prodDtaData[0]->code;	
		}

        if ($this->Constant_model->deleteData('products', $prod_id)) {
	        $this->Constant_model->deleteByColumn("inventory", "product_code", $prod_code);
	        $this->session->set_flashdata('alert_msg', array('success', 'Delete Product', "Successfully Deleted Product : $prod_name."));
            redirect(base_url().'products/list_products');
        }
    }

    // Delete Product Category;
    public function deleteproductcategory()
    {
        $cat_id = $this->input->post('cat_id');
        $cat_name = $this->input->post('cat_name');

        if ($this->Constant_model->deleteData('category', $cat_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Product Category', "Successfully Deleted Product Category : $cat_name."));
            redirect(base_url().'products/product_category');
        }
    }

    // Update Product;
	public function updateProduct()
    {
        $id = $this->input->post('id');
        $code = strip_tags($this->input->post('code'));
        $name = strip_tags($this->input->post('name'));
        $purchase = strip_tags($this->input->post('purchase'));
        $retail = strip_tags($this->input->post('retail'));
        $status = strip_tags($this->input->post('status'));
        $rack = strip_tags($this->input->post('rack'));
		$uploadFile = ($this->input->post('uploadFile'));
        $generic_name = strip_tags($this->input->post('generic_name'));
        $alert_quan = strip_tags($this->input->post('alert_quan'));
        $brand = strip_tags($this->input->post('brand'));
        $weight = strip_tags($this->input->post('weight'));
		$supplier = strip_tags($this->input->post('s_editsupplier'));
	    $purchase = strip_tags($this->input->post('purchase'));
        $expire = strip_tags($this->input->post('expire'));

        
            if (!empty($_FILES['uploadFile']['name'])) {
				$mainPhoto_fn = $_FILES['uploadFile']['name'];
                $main_ext = pathinfo($mainPhoto_fn, PATHINFO_EXTENSION);
                $mainPhoto_name = $code.".$main_ext";

                // Main Photo -- START;
                $config['upload_path'] = './assets/upload/products/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['file_name'] = $mainPhoto_name;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('uploadFile')) {
                    $error = array('error' => $this->upload->display_errors());
                    //print_r($error);
                    //$this->load->view('upload_form', $error);
                    //$this->session->set_flashdata('alert_msg', array('error','warning','Error',"$error"));
                } else {
                    $width_array = array(100, 200);
                    $height_array = array(100, 200);
                    $dir_array = array('xsmall', 'small');

                    $this->load->library('image_lib');

                    for ($i = 0; $i < count($width_array); ++$i) {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = "./assets/upload/products/$mainPhoto_name";
                        $config['maintain_ratio'] = true;
                        $config['width'] = $width_array[$i];
                        $config['height'] = $height_array[$i];
                        $config['quality'] = '100%';

                        if (!file_exists('./assets/upload/products/'.$dir_array[$i].'/'.$code)) {
                            mkdir('./assets/upload/products/'.$dir_array[$i].'/'.$code, 0777, true);
                        }

                        $config['new_image'] = './assets/upload/products/'.$dir_array[$i].'/'.$code.'/'.$mainPhoto_name;

                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }

                    $this->load->helper('file');
                    $path = './assets/upload/products/'.$mainPhoto_name;

                    if (unlink($path)) {
                    }
                       $upd_file_data = array(
                                'thumbnail' => $mainPhoto_name,
                        );
                              

                        $this->Constant_model->updateData('products', $upd_file_data, $id);
                }
                // Main Photo -- END;
            }
			else
			{
				$mainPhoto_name = $this->input->post('oldfilename');
			}
        
        
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());
		$upd_data = array(
                        'name' => $name,
                        'generic_name' => $generic_name,
                        'purchase_price' => $purchase,
                        'retail_price' => $retail,
                        'alt_qty' => $alert_quan,
                        'brand_id_fk' => $brand,
                        'weight' => $weight,
                        'supplier_id_fk' => $supplier,
						'thumbnail' => $mainPhoto_name,
                        'rack' => $rack, 
                        'updated_user_id' => $us_id,
                        'updated_datetime' => $tm,
                        'status' => $status,
                        'expire' => $expire,
                );

        if (empty($code)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Product', 'Please enter Product Code!'));
            redirect(base_url().'products/editproduct?id='.$id);
        } elseif (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Product', 'Please enter Product Name!'));
            redirect(base_url().'products/editproduct?id='.$id);
        }elseif (empty($purchase)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Product', 'Please enter Purchase Price!'));
            redirect(base_url().'products/editproduct?id='.$id);
        } elseif (empty($retail)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Product', 'Please enter Retail Price!'));
            redirect(base_url().'products/editproduct?id='.$id);
        } else {
            $temp_fn = $_FILES['uploadFile']['name'];
            if (!empty($temp_fn)) {
                $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

                if (($temp_fn_ext == 'jpg') || ($temp_fn_ext == 'png') || ($temp_fn_ext == 'jpeg')) {
                    if ($_FILES['uploadFile']['size'] > 2048000) {
                        $this->session->set_flashdata('alert_msg', array('failure', 'Update Product', 'Upload file size must be less than 2MB!'));
                        redirect(base_url().'products/editproduct?id='.$id);

                        die();
                    }
                } else {
                    $this->session->set_flashdata('alert_msg', array('failure', 'Update Product', 'Invalid File Format! Please upload JPG, PNG, JPEG File Format for Product Image!'));
                    redirect(base_url().'products/editproduct?id='.$id);

                    die();
                }
            }
            $this->Constant_model->updateData('products', $upd_data, $id);
            $this->session->set_flashdata('alert_msg', array('success', 'Update Product', "Successfully Updated Product : $code."));
            redirect(base_url().'products/editproduct?id='.$id);
        }
    }

    // Insert New Product;
	
	public function insertProduct()
    {
		$code			= strip_tags($this->input->post('code'));
        $name			= strip_tags($this->input->post('name'));
		$generic_name	=  $this->input->post('generic_name');
        $generic_name	= isset($generic_name) ? $this->input->post('generic_name') : "";
        $category		= strip_tags($this->input->post('category'));
        $sub_category	= strip_tags($this->input->post('sub_category'));
        $retail			= strip_tags($this->input->post('retail'));
		$rack			= $this->input->post('rack');
        $rack			= isset($rack) ? $rack : "";
        $alert_quan		= strip_tags($this->input->post('alert_quan'));
        $brand			= strip_tags($this->input->post('brand'));
        $outlet			= strip_tags($this->input->post('outlet'));
		$weight			= $this->input->post('weight');
        $weight			= isset($weight) ? $this->input->post('weight') : "";
        $grade_id			= $this->input->post('grade_id');
		
		if(!empty($this->input->post('dependsupplier')))
		{
			$supplier = strip_tags($this->input->post('dependsupplier'));
		}
		else
		{
			$supplier = strip_tags($this->input->post('supplier'));
		}
		
	    $starting_qty	= strip_tags($this->input->post('starting_qty'));
        $purchase		= strip_tags($this->input->post('purchase'));
        $expire			= strip_tags($this->input->post('expire'));
        $uploadFile		= ($this->input->post('uploadFile'));
        $us_id	= $this->session->userdata('user_id');
        $tm		= date('Y-m-d H:i:s', time());
        
        if ($supplier != ''){
            if($expire == ""){
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Please enter Days!'));
                redirect(base_url().'products/addproduct');
            }
        }
        if (empty($code)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Please enter Product Code!'));
            redirect(base_url().'products/addproduct');
        }
		elseif (empty($name)) {
       
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Please enter Product Name!'));
            redirect(base_url().'products/addproduct');
        } elseif (empty($category)) {
          
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Please choose Product Category!'));
            redirect(base_url().'products/addproduct');
        } 
	    else {
            $temp_fn = $_FILES['uploadFile']['name'];
            if (!empty($temp_fn)) {
                $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

                if (($temp_fn_ext == 'jpg') || ($temp_fn_ext == 'png') || ($temp_fn_ext == 'jpeg')) {
                    if ($_FILES['uploadFile']['size'] > 2048000) {
                        $this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Upload file size must be less than 2MB!'));
                        redirect(base_url().'products/addproduct');
                        die();
                    }
                } else {
                    $this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Invalid File Format! Please upload JPG, PNG, JPEG File Format for Product Image!'));
                    redirect(base_url().'products/addproduct');
                    die();
                }
            }

            $ckPcodeData = $this->Constant_model->getDataOneColumn('products', 'code', "$code");

            if (count($ckPcodeData) == 0) {
                $this->load->library('Barcode39');
                $bc = new Barcode39("$code");
                $bc->barcode_text_size = 1;
                $bc->draw('./assets/barcode/'.$code.'.gif');
				
				$product_report = array(
					'product_code'	=> $code,
					'opening_qty'	=> $starting_qty,
					'purchase_qty'	=> 0,
					'sales_qty'		=> 0,
					'balance_qty'   => $starting_qty,
					'created_by'	=> $us_id,
					'created_date'	=> date('Y-m-d H:i:s'),
					);
				
				if($category == 1)
				{
					$retail = strip_tags($this->input->post('purchase'));
				}
				
				$ins_data = array(
                        'code' => $code,
                        'name' => $name,
                        'generic_name' => $generic_name,
                        'category' => $category,
                        'sub_category_id_fk' => $sub_category,
                        'grade_id' => $grade_id,
						'purchase_price' => !empty($purchase)?$purchase:0,
                        'retail_price' => !empty($retail)?$retail:0,
                        'alt_qty' => $alert_quan,
                        'brand_id_fk' => $brand,
                        'outlet_id_fk' => $outlet,
                        'weight' => $weight,
                        'supplier_id_fk' => $supplier,
                        'start_qty' => $starting_qty,
                        'thumbnail' => 'no_image.jpg',
                        'rack' => $rack, 
                        'created_user_id' => $us_id,
                        'created_datetime' => $tm,
                        'status' => '1',
                        'product_add_from' => 'Add Product',
                        'expire' => $expire,
                );

                $pcode_id = $this->Constant_model->insertDataReturnLastId('products', $ins_data);
				
				if(!empty($this->input->post('product_num_id')))
				{
					$code_num_array = array(
						'created_date'		=> $this->input->post('changeNewdate'),
						'updated_number'	=> $this->input->post('profecctional_code')+1,
						'updated_date'		=> date('Y-m-d'),
					);
					
					$this->Constant_model->UpdateProductCodeNumber($code_num_array, $this->input->post('product_num_id'));
				}
				
				
                $this->Constant_model->insertDataReturnLastId('product_report', $product_report);
				
				if(!empty($this->input->post('inventroy')))
				{
					$inventory = $this->input->post('inventroy');
					foreach ($inventory as $inve)
					{
						if ($inve['warehouse_quantity'] == null) {
							
						}else{
							$getStore = $this->Constant_model->OutletWarehouseget($inve['ow_id']);
							$oldstore = $getStore->s_stock;
							$newstoreQty = $getStore->s_stock + $inve['warehouse_quantity'];
							
							$data_storeupdate = array(
								's_stock' => $newstoreQty,
								's_stock_upated' => $newstoreQty,
							);
							
							$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);
							
							$outlet_id_array = $this->db->select('out_id')->where('ow_id',$inve['ow_id'])->get('outlet_warehouse')->row_array();
							$outlet_id = $outlet_id_array['out_id'];
							$data_inventory = array(
								'ow_id' => $inve['ow_id'],
								'product_code'   => $code,
								'outlet_id' =>$outlet_id,
								'qty'       => $inve['warehouse_quantity'],
								'type'       => '0',
								'date' => date("Y-m-d H:i:s")
							);
							$inventroy_id = $this->Constant_model->insertDataReturnLastId('inventory', $data_inventory);
							}
					}
				}
				
				
                $mainPhoto_fn = $_FILES['uploadFile']['name'];
                if (!empty($mainPhoto_fn)) {
                    $main_ext = pathinfo($mainPhoto_fn, PATHINFO_EXTENSION);
                    $mainPhoto_name = $code.".$main_ext";
                    $config['upload_path'] = './assets/upload/products/';
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    $config['file_name'] = $mainPhoto_name;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('uploadFile')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        $width_array = array(100, 200);
                        $height_array = array(100, 200);
                        $dir_array = array('xsmall', 'small');
                        $this->load->library('image_lib');
                        for ($i = 0; $i < count($width_array); ++$i) {
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = "./assets/upload/products/$mainPhoto_name";
                            $config['maintain_ratio'] = true;
                            $config['width'] = $width_array[$i];
                            $config['height'] = $height_array[$i];
                            $config['quality'] = '100%';
                            if (!file_exists('./assets/upload/products/'.$dir_array[$i].'/'.$code)) {
                                mkdir('./assets/upload/products/'.$dir_array[$i].'/'.$code, 0777, true);
                            }
                            $config['new_image'] = './assets/upload/products/'.$dir_array[$i].'/'.$code.'/'.$mainPhoto_name;
                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                        }
                        $this->load->helper('file');
                        $path = './assets/upload/products/'.$mainPhoto_name;

                        if (unlink($path)) {
                        }

                        $upd_file_data = array(
                                'thumbnail' => $mainPhoto_name,
                        );
                        $this->Constant_model->updateData('products', $upd_file_data, $pcode_id);
                    }
                }

                $this->session->set_flashdata('alert_msg', array('success', 'Add New Product', "Successfully Added New Product : $code."));
                redirect(base_url().'products/addproduct');
            } 
			else
			{
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', "Product Code : $code is already existing in the System! Please try another one!"));
                redirect(base_url().'products/addproduct');
            }
        }
    }
	
	
	
	public function insertBulkProduct()
    {
	    $name			= strip_tags($this->input->post('name'));
		$category		= strip_tags($this->input->post('category'));
        $sub_category	= strip_tags($this->input->post('sub_category'));
     	$rack			= $this->input->post('rack');
        $rack			= isset($rack) ? $rack : "";
        $alert_quan		= strip_tags($this->input->post('alert_quan'));
        $brand			= strip_tags($this->input->post('brand'));
        $outlet			= strip_tags($this->input->post('outlet'));
		$weight			= $this->input->post('weight');
        $weight			= isset($weight) ? $this->input->post('weight') : "";
        $grade_id			= $this->input->post('grade_id');
		
		if(!empty($this->input->post('dependsupplier')))
		{
			$supplier = strip_tags($this->input->post('dependsupplier'));
		}
		else
		{
			$supplier = strip_tags($this->input->post('supplier'));
		}
		
	    $starting_qty	= strip_tags($this->input->post('starting_qty'));
        $purchase		= strip_tags($this->input->post('purchase'));
     
        $uploadFile		= ($this->input->post('uploadFile'));
        $us_id	= $this->session->userdata('user_id');
        $tm		= date('Y-m-d H:i:s', time());
        
       if (empty($name)) 
		{
           $this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Please enter Product Name!'));
            redirect(base_url().'products/add_bulk_product');
        } 
		elseif (empty($category)) 
		{
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Please choose Product Category!'));
            redirect(base_url().'products/add_bulk_product');
        } 
	    else {
				$temp_fn = $_FILES['uploadFile']['name'];
				if (!empty($temp_fn)) {
					$temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

					if (($temp_fn_ext == 'jpg') || ($temp_fn_ext == 'png') || ($temp_fn_ext == 'jpeg')) {
						if ($_FILES['uploadFile']['size'] > 2048000) {
							$this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Upload file size must be less than 2MB!'));
							redirect(base_url().'products/add_bulk_product');
							die();
						}
					} else {
						$this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Invalid File Format! Please upload JPG, PNG, JPEG File Format for Product Image!'));
						redirect(base_url().'products/add_bulk_product');
						die();
					}
				}

			
				$ins_data = array(
                        'name' => $name,
                        'category' => $category,
                        'sub_category_id_fk' => $sub_category,
                        'grade_id' => $grade_id,
						'purchase_price' => !empty($purchase)?$purchase:0,
                        'alt_qty' => $alert_quan,
                        'brand_id_fk' => $brand,
                        'outlet_id_fk' => $outlet,
                        'weight' => $weight,
                        'supplier_id_fk' => $supplier,
                        'start_qty' => $starting_qty,
                        'thumbnail' => 'no_image.jpg',
                        'rack' => $rack, 
                        'created_user_id' => $us_id,
                        'created_datetime' => $tm,
                        'status' => '1',
                        'product_add_from' => 'Add Bulk Product',
                        'product_type' => 'bulk',
                );

				$pcode_id = $this->Constant_model->insertDataReturnLastId('products', $ins_data);
				
				$product_report = array(
					'product_code'	=> $pcode_id,
					'opening_qty'	=> $starting_qty,
					'purchase_qty'	=> 0,
					'sales_qty'		=> 0,
					'balance_qty'   => $starting_qty,
					'opening_wt'	=> $weight,
					'purchase_wt'	=> 0,
					'sales_wt'		=> 0,
					'balance_wt'    => $weight,
					'created_by'	=> $us_id,
					'created_date'	=> date('Y-m-d H:i:s'),
				);
				
				
				$this->Constant_model->insertDataReturnLastId('product_report', $product_report);
				
				$getStore = $this->Constant_model->OutletWarehouseget($this->input->post('store'));
				$oldstore = $getStore->s_stock;
				$newstoreQty = $getStore->s_stock + $starting_qty;

				$data_storeupdate = array(
					's_stock'			=> $newstoreQty,
					's_stock_upated'	=> $newstoreQty,
				);
							
				$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);
							
				$data_inventory = array(
					'ow_id'			=>	$this->input->post('store'),
					'product_code'	=> $pcode_id,
					'outlet_id'		=>	$outlet,
					'qty'			=>	$starting_qty,
					'type'			=>	'0',
					'gold_weight'	=> $weight,
					'date'			=>	date("Y-m-d H:i:s")
				);
						
				$inventroy_id = $this->Constant_model->insertDataReturnLastId('inventory', $data_inventory);
				
				
								
                $mainPhoto_fn = $_FILES['uploadFile']['name'];
                if (!empty($mainPhoto_fn)) {
                    $main_ext = pathinfo($mainPhoto_fn, PATHINFO_EXTENSION);
                    $mainPhoto_name = date('y-m-d').time().'.'.$main_ext;
                    $config['upload_path'] = './assets/upload/products/';
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    $config['file_name'] = $mainPhoto_name;
                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('uploadFile')) {
                        $error = array('error' => $this->upload->display_errors());
                    } else {
                        $width_array = array(100, 200);
                        $height_array = array(100, 200);
                        $dir_array = array('xsmall', 'small');
                        $this->load->library('image_lib');
                        for ($i = 0; $i < count($width_array); ++$i) {
                            $config['image_library'] = 'gd2';
                            $config['source_image'] = "./assets/upload/products/$mainPhoto_name";
                            $config['maintain_ratio'] = true;
                            $config['width'] = $width_array[$i];
                            $config['height'] = $height_array[$i];
                            $config['quality'] = '100%';
                            /*if (!file_exists('./assets/upload/products/'.$dir_array[$i].'/'.$code)) {
                                mkdir('./assets/upload/products/'.$dir_array[$i].'/'.$code, 0777, true);
                            }
                            $config['new_image'] = './assets/upload/products/'.$dir_array[$i].'/'.$code.'/'.$mainPhoto_name;*/
							 if (!file_exists('./assets/upload/products/'.$dir_array[$i])) {
                                mkdir('./assets/upload/products/'.$dir_array[$i], 0777, true);
                            }
							$config['new_image'] = './assets/upload/products/'.$dir_array[$i].'/'.$mainPhoto_name;
                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                        }
                        $this->load->helper('file');
                        $path = './assets/upload/products/'.$mainPhoto_name;

                        if (unlink($path)) {
                        }

                        $upd_file_data = array(
                                'thumbnail' => $mainPhoto_name,
                                'code' => $pcode_id,
                        );
                        $this->Constant_model->updateData('products', $upd_file_data, $pcode_id);
                    }
                }
				$update_file_data = array(
					'code' => $pcode_id,
				);
				$this->Constant_model->updateData('products', $update_file_data, $pcode_id);
						
                $this->session->set_flashdata('alert_msg', array('success', 'Add New Product', "Successfully Added New Product : $name."));
                redirect(base_url().'products/add_bulk_product');
        }
    }


    // Update Product Category;
    public function updateProductCategory()
    {
        $id = $this->input->post('id');
        $category = strip_tags($this->input->post('category'));
        $status = strip_tags($this->input->post('status'));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($category)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Product Category', 'Please enter Product Category Name!'));
            redirect(base_url().'products/editproductcategory?id='.$id);
        } else {
            $update_data = array(
                    'name' => $category,
                    'updated_user_id' => $us_id,
                    'updated_datetime' => $tm,
                    'status' => $status,
            );
            if ($this->Constant_model->updateData('category', $update_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Product Category', "Successfully Updated Product Category : $category."));
                redirect(base_url().'products/editproductcategory?id='.$id);
            }
        }
    }

    // Insert New Product Category;
    public function insertProductCategory()
    {
        $category = strip_tags($this->input->post('category'));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($category)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'New Product Category', 'Please enter New Product Category Name!'));
            redirect(base_url().'products/addproductcategory');
        } else {
            $ins_data = array(
                    'name' => $category,
                    'created_user_id' => $us_id,
                    'created_datetime' => $tm,
                    'status' => '1',
            );
            if ($this->Constant_model->insertData('category', $ins_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'New Product Category', "Successfully Added New Product Category : $category."));
                redirect(base_url().'products/addproductcategory');
            }
        }
    }

    // ****************************** Action To Database -- END ****************************** //

    // Print Barcode -- START;
    public function printBarcode()
    {
        $pcode = $this->input->get('pcode');

        $ckPcodeData = $this->Constant_model->getDataOneColumn('products', 'code', $pcode);

        if (count($ckPcodeData) == 1) {
            $data['pcode'] = $pcode;
            $this->load->view('print_barcode', $data);
        } else {
            $this->session->set_flashdata('alert_msg', array('failure', 'Wrong Product Code', 'Invalid Product Code!!'));
            redirect(base_url().'products/list_products');
        }
    }
    // Print Barcode -- END;
}
