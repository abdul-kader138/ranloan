<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product_Code_Numbering extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Purchaseorder_model');
        $this->load->model('Gold_module');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');
		$this->load->model('Bill_Numbering_model');
		$this->load->model('Product_Code_Numbering_model');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
		if($this->session->userdata('user_id') == "")
		{
			redirect(base_url());
		}
    }

    public function index()
    {
		$permisssion_url = 'product_code_numbering';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getBrand'] = $this->Bill_Numbering_model->getBrand();
		$data['getSupplier'] = $this->Bill_Numbering_model->getSupplier();
		$data['getCategory'] = $this->Bill_Numbering_model->getCategory();
		$data['getSubCategory'] = $this->Bill_Numbering_model->getSubCategory();
		$data['resultdata'] = $this->Product_Code_Numbering_model->getProductCodeNumberingDate();
	    $this->load->view('product_code_numbering', $data);
    }
	
	
	public function editproductcode()
	{
		$id = $this->input->get('id');
		$loginUserId= $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] =  $loginData[0]->fullname;
		$data['getCategory'] = $this->Constant_model->getCategory();
		$data['getProductno'] = $this->Product_Code_Numbering_model->getProductNO($id);
		$this->load->view('edit_product_code_numbering', $data);	
	}


	public function AddProductCodeNumbering()
	{
		$loginUserId= $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] =  $loginData[0]->fullname;
		$data['getCategory'] = $this->Constant_model->getCategory();
		$this->load->view('add_product_code_numbering', $data);	
	}
	
	public function SubmitProduct_Code_Numbering()
	{
		$category	  = $this->input->post('category');
		$sub_category = $this->input->post('sub_category');
		
		$count = $this->Product_Code_Numbering_model->ValidationCategoryandSubcategory($category,$sub_category);
		if($count > 0)
		{
			$json['error'] = true;
		}
		else
		{
			$data = array('user_id' =>$this->session->userdata('user_id'),
				'created_date'			=>date('Y-m-d H:i:s'),	
				'auto_generate_code'	=>$this->input->post('auto_number_change'),	
				'change_daily'			=> $this->input->post('dailyplay'),	
				'change_weekly'			=> $this->input->post('weeklyplay'),	
				'change_monthly'		=> $this->input->post('monthlyplay'),	
				'change_yearly'			=> $this->input->post('yearlyplay'),	
				'current_year'			=> $this->input->post('current_year'),	
				'current_month'			=> $this->input->post('current_month'),	
				'category'				=> $this->input->post('category'),	
				'sub_category'			=> $this->input->post('sub_category'),	
				'current_day'			=> $this->input->post('current_day'),	
				'enter_starting_number' => !empty($this->input->post('enter_starting_number'))?$this->input->post('enter_starting_number'):1,	
				'updated_number'		=> !empty($this->input->post('enter_starting_number'))?$this->input->post('enter_starting_number'):1,	
				'updated_date'			=> date('Y-m-d'),	
				'status' => '0',	
			);
			$this->Product_Code_Numbering_model->InsertNumbering($data);
			$this->session->set_flashdata('SUCCESSMSG', 'Product Code Numbering Added Successfully!!');
			$json['success'] = true;
		}
		
		echo json_encode($json);
	}
	
	public function UpdateProduct_Code_Numbering()
	{
		$id = $this->input->post('product_code_id');
		$getProductno = $this->Product_Code_Numbering_model->getProductNO($id);
		if($getProductno->enter_starting_number == $this->input->post('enter_starting_number'))
		{
			$updatedno		= $getProductno->enter_starting_number;
			$updated_date	= $getProductno->updated_date;
		}
		else
		{
			$updatedno		= $this->input->post('enter_starting_number');
			$updated_date	= date('Y-m-d');
		}
		$data = array('user_id'		=> $this->session->userdata('user_id'),
			'created_date'			=> date('Y-m-d H:i:s'),	
			'auto_generate_code'	=> $this->input->post('auto_number_change'),	
			'change_daily'			=> $this->input->post('dailyplay'),	
			'change_weekly'			=> $this->input->post('weeklyplay'),	
			'change_monthly'		=> $this->input->post('monthlyplay'),	
			'change_yearly'			=> $this->input->post('yearlyplay'),	
			'current_year'			=> $this->input->post('current_year'),	
			'current_month'			=> $this->input->post('current_month'),	
			'current_day'			=> $this->input->post('current_day'),	
			'enter_starting_number' => !empty($this->input->post('enter_starting_number'))?$this->input->post('enter_starting_number'):1,	
			'updated_number'		=> !empty($updatedno)?$updatedno:1,	
			'updated_date'			=> $updated_date,	
			'status' => '0',	
		);
		
		
		$this->Product_Code_Numbering_model->UpdateProduct_Code_Numbering($id, $data);
		
		$this->session->set_flashdata('SUCCESSMSG', 'Product Code Numbering Updated Successfully!!');
		$json['success'] = true;
		echo json_encode($json);
	}
	
}
