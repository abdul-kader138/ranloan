<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Sub_category_model');
		$this->load->model('Brand_model');
		$this->load->model('Constant_model');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->library('pagination');
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$setting_timezone = $settingData->timezone;
		date_default_timezone_set("$setting_timezone");
		if ($this->session->userdata('user_id') == "") {
			redirect(base_url());
		}
	}

	public function view() {
		
		 $permisssion_url = 'brand';
         
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                $permission_re_id=$permission->resource_id;
                $permisssion_sub_url = 'view';
                $permissionsub = $this->Constant_model->getPermissionSubPageWise($permission_re_id,$permisssion_sub_url);
               
		if($permissionsub->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		

		$data['results'] = $this->Brand_model->fetch_brand_data();
		$this->load->view('brand/brand', $data);
	}

	public function addBrand() {

		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='brand')");

		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add brand', 'You can not add brand. Please ask administrator!'));
			redirect($this->agent->referrer());
		}

		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = $loginData[0]->fullname;
		$data['supplier_data'] = $this->db->where('status', 1)->get('suppliers')->result();
		$this->load->view('brand/add_brand', $data);
	}

	public function insertBrand() 
	{
		$this->form_validation->set_rules('Brand', 'Brand', 'required');
		$this->form_validation->set_rules('supplier[]', 'supplier', 'required');
		$this->form_validation->set_rules('status', 'status', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->addBrand();
		}
		else
		{
		
			$Brand = $this->input->post('Brand');
			$supplier = $this->input->post('supplier');
			$status = $this->input->post('status');
			$us_id = $this->session->userdata('user_id');
			if (empty($Brand)) {
				$this->session->set_flashdata('alert_msg', array('failure', 'Add Brand', 'Please enter Brand!'));
				redirect(base_url() . 'brand/addBrand');
			} 
			else 
			{
				$data = array(
					'brand' => $Brand,
					'created_by' => $us_id,
					'status' => $status
				);
				$brand_id = $this->Constant_model->insertDataReturnLastId('brand', $data);
				if ($brand_id) 
				{
					$data1 = array();
					for ($i = 0; $i < count($this->input->post('supplier')); $i++) 
					{
						$data1[] = array(
							'brand_id_fk' => $brand_id,
							'supplier_id_fk' => $this->input->post('supplier')[$i]
						);
					}
					if ($this->db->insert_batch('brand_suppliers', $data1)) 
					{
						$this->session->set_flashdata('alert_msg', array('success', 'Add Brand', "Successfully Added Brand : $Brand"));
						redirect(base_url() . 'brand/addBrand');
					}
				}
			}
		}
	}

	public function edit_Brand() 
	{
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='brand')");

		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add brand', 'You can not add brand. Please ask administrator!'));
			redirect($this->agent->referrer());
		}
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = $loginData[0]->fullname;
		$id = $this->input->get('id');
		$this->db->where('brand_id_fk', $id);
		$query = $this->db->get('brand_suppliers');
		$data['brand_supplier'] = $query->result();
		$data['supplier_data'] = $this->db->where('status', 1)->get('suppliers')->result();
		$data['brand_id'] = $id;
		$this->load->view('brand/edit_brand', $data);
	}

	public function updateBrand() 
	{
		$brand_id = $this->input->post('id');
		$Brand = $this->input->post('Brand');
		$supplier = $this->input->post('supplier');
		$status = $this->input->post('status');
		$us_id = $this->session->userdata('user_id');
		$tm = date('Y-m-d H:i:s', time());
		$upd_data = array(
			'brand' => $Brand,
			'last_modefied_by' => $us_id,
			'status' => $status
		);
		if ($this->Constant_model->updateData('brand', $upd_data, $brand_id)) {
			if ($this->db->delete('brand_suppliers', array('brand_id_fk' => $brand_id))) {
				$data1 = array();
				for ($i = 0; $i < count($this->input->post('supplier')); $i++) {
					$data1[] = array(
						'brand_id_fk' => $brand_id,
						'supplier_id_fk' => $this->input->post('supplier')[$i]
					);
				}
				if ($this->db->insert_batch('brand_suppliers', $data1)) {
					$this->session->set_flashdata('alert_msg', array('success', 'Update Brand', "Successfully Updated Brand : $Brand"));
					redirect(base_url() . 'brand/edit_Brand?id=' . $brand_id);
				}
			}
		}
	}
	public function delete_brand() 
	{
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='brand')");
		if (!isset($permission_data[0]->delete_right) || (isset($permission_data[0]->delete_right) && $permission_data[0]->delete_right != 1)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Delete brand', 'You can not delete brand. Please ask administrator!'));
			redirect($this->agent->referrer());
		}
		$id = $this->input->get('id');
		if ($this->Constant_model->deleteData('brand', $id)) {
			$this->db->delete('brand_suppliers', array('brand_id_fk' => $id));
			$this->session->set_flashdata('alert_msg', array('success', 'Delete Sub Category', "Successfully Deleted Sub Category."));
			redirect(base_url() . 'brand/view');
		}
	}

}
