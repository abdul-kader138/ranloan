<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sub_category extends CI_Controller {
    
     public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Sub_category_model');
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
		if($this->session->userdata('user_id') == "")
		{
			redirect(base_url());
		}
    }

    public function view()
    {
        $permisssion_url = 'sub_category';
         
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                $permission_re_id=$permission->resource_id;
                $permisssion_sub_url = 'view';
                $permissionsub = $this->Constant_model->getPermissionSubPageWise($permission_re_id,$permisssion_sub_url);
               
		if($permissionsub->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['results'] = $this->Sub_category_model->fetch_sub_category_data();
        $this->load->view('sub_category', $data);
    }
 
    
    public function addSubCategory() {
        
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='sub_category')");
		
		if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add sub category', 'You can not add sub category. Please ask administrator!'));
				redirect($this->agent->referrer());
		}
		
		$loginUserId= $this->session->userdata('user_id');
        $loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
        $data['UserLoginName'] =  $loginData[0]->fullname;
        $data['category_data']=$this->db->where('status',1)->get('category')->result();
        $this->load->view('add_SubCategory',$data);
        
    }
	
    public function insertSubCategory() 
	{
        $category_name = $this->input->post('category_name');
        $category_id_fk = $this->input->post('category_id_fk');
        $Prefix = $this->input->post('Prefix');
        $status = $this->input->post('status');
        $us_id = $this->session->userdata('user_id');
        if (empty($category_name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Sub Category', 'Please enter Sub Category!'));
            redirect(base_url().'sub_category/addSubCategory');
        } 
		else
		{
            $data = array(
				'sub_category' => $category_name,
				'category_id_fk' => $category_id_fk,
				'prefix' => $Prefix,
				'created_by' => $us_id,
				'status' => $status
            );
            if ($this->Constant_model->insertData('sub_category', $data)) 
			{
                $this->session->set_flashdata('alert_msg', array('success', 'Add Sub Category', "Successfully Added Sub Category : $category_name"));
                redirect(base_url().'sub_category/addSubCategory');
            }
        }
    }
     
    public function edit_SubCategory()
    {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='sub_category')");
		
		if(!isset($permission_data[0]->edit_right)|| (isset($permission_data[0]->edit_right) && $permission_data[0]->edit_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Edit sub category', 'You can not edit sub category. Please ask administrator!'));
				redirect($this->agent->referrer());
		}
		
		$loginUserId= $this->session->userdata('user_id');
        $loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
        $data['UserLoginName'] =  $loginData[0]->fullname;
        $category_id = $this->input->get('id');
        $data['category_data']=$this->db->where('status',1)->get('category')->result();
        $data['category_id'] = $category_id;
        $this->load->view('edit_subcategory', $data);
    }
    
	public function updateSubCategory()
    {
        $category_id = $this->input->post('id');
        $category_name = $this->input->post('category_name');
        $category_id_fk = $this->input->post('category_id_fk');
        $Prefix = $this->input->post('Prefix');
        $status = $this->input->post('status');
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        $upd_data = array(
			'sub_category' => $category_name,
			'category_id_fk' => $category_id_fk,
			'prefix' => $Prefix,
			'last_modefied_id' => $us_id,
			'last_modefied_at' => $tm,
			'status' => $status
        );
        $this->Constant_model->updateData('sub_category', $upd_data, $category_id);
		$this->session->set_flashdata('alert_msg', array('success', 'Update Sub Category', 'Successfully Updated Sub Category Detail!'));
        redirect(base_url().'sub_category/edit_SubCategory?id='.$category_id); 
    }
    
    public function delete_SubCategory() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='sub_category')");
		if(!isset($permission_data[0]->delete_right)|| (isset($permission_data[0]->delete_right) && $permission_data[0]->delete_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Delete sub category', 'You can not delete sub category. Please ask administrator!'));
				redirect($this->agent->referrer());
		}
        $id = $this->input->get('id');
        if ($this->Constant_model->deleteData('sub_category', $id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Sub Category', "Successfully Deleted Sub Category."));
            redirect(base_url().'sub_category/view');
        }
    }
}
