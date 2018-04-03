<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sys_admin extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Setting_model');
        $this->load->model('Constant_model');
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

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }
	
    public function roles()
    {
        $data=array();
        $data['roles_dd'] =  $this->Constant_model->getddData('user_roles','id','name', 'id');

        $this->load->view('includes/header');
        $this->load->view('Sys_admin/roles', $data);
        $this->load->view('includes/footer');
    }
	
	public function saverole(){
		$role = $_REQUEST['name'];
		$this->Constant_model->insertData('user_roles',array('name'=>$role));
		redirect(base_url().'Sys_admin/roles');
    }
	
    public function updateroles(){
        $roles = $_REQUEST['name'];
		foreach($roles as $role){
			$id =  $this->Constant_model->getSingle('roles','id', ' name="'.$role.'"');
			$this->Constant_model->add_update('user_roles','id='.$id,array('name'=>$role));
		}
        redirect(base_url().'Sys_admin/roles');
    }
	
    public function modules()
    {
        $data=array();
        $this->load->view('includes/header');
        $this->load->view('Sys_admin/modules', $data);
        $this->load->view('includes/footer');    
    }
	
    public function updatemodules(){
        $modules = $_REQUEST['name'];
        $sub_module_array = ci_submodules();

        foreach($modules as $module){
			$id =  $this->Constant_model->getSingle('resources','id', ' name="'.$module.'"');
			if($id>0){
				$this->Constant_model->add_updatev2('resources','id='.$id,array('name'=>$module));
			}else {
				$id  = $this->Constant_model->add_updatev2('resources','id='.$id,array('name'=>$module));
			}
			if(array_key_exists($module, $sub_module_array)){
				$submodules = $sub_module_array[$module];
				foreach($submodules as $ksub=>$sub){
					$sid =  $this->Constant_model->getSingle('resources','id', ' name="'.$ksub.'" and pid='.$id);
					$this->Constant_model->add_update('resources','id='.$sid,array('title'=>$sub,'name'=>$ksub,'pid'=>$id));
				}
			}
        }
        redirect(base_url().'Sys_admin/modules');
    }
	
    public function rules()
    {
        $data=array();
        $role_id = 0;
		$allowed_type='allow';
        $sel_allowed_type_arr = array();
		
        if(isset($_REQUEST['role_id']) && $_REQUEST['role_id'] >0){
            $role_id = $_REQUEST['role_id'];
            $data = $this->Constant_model->getDataWhere('rules',' role_id='.$role_id);
            foreach ($data as $row){
                $sel_allowed_type_arr[$row->resource_id]= $row->allowed_type;
            }
        }
        $data ['sel_allowed_type_arr'] =$sel_allowed_type_arr;
        $data['roles_dd'] =  $this->Constant_model->getddData('user_roles','id','name', 'id');
        //$data['roles_dd'] =  $this->Constant_model->getddData('users','id','fullname', 'id');
        $data['resource_dd']		=  $this->Constant_model->getddData('resources','id','name', 'id','pid=0');
        $data['sub_resource_dd']	=  $this->Constant_model->getddData('resources','name','id', 'id','pid>0');
		$data['allowed_type_dd']	=  array('allow'=>'Allow','deny'=>'Deny');
        $data['role_id']			= $role_id;
        $data['allowed_type']		= $allowed_type;
        
        $this->load->view('includes/header');
        $this->load->view('Sys_admin/rules', $data);
        $this->load->view('includes/footer');
    }
	
    public function updaterules(){
        $resource_id = $_REQUEST['resource_id'];
        $role_id = $_REQUEST['role_id'];
        $allowed_type = $_REQUEST['allowed_type'];
            foreach($resource_id as $key=>$resource){
                $data = array(
                    'role_id'=>$role_id,
                    'resource_id'=>$resource,
                    'allowed_type'=>$allowed_type[$key],
                );
                $id =  $this->Constant_model->getSingle('rules','id', 'role_id='.$role_id.' AND resource_id='.$resource);
                $this->Constant_model->add_update('rules','id='.$id,$data);
            }
        redirect(base_url().'Sys_admin/rules');
    }

    public function Sys_setting()
    {
        $data=array();
        $data['outlets'] =  $this->Constant_model->getddData('outlets','id','name', 'id');
        $this->load->view('includes/header');
        $this->load->view('Sys_admin/sys_setting', $data);
        $this->load->view('includes/footer');    
	}
	
    public function updateSetting(){
        $siteDtaData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $new_settings = $siteDtaData[0]->new_settings;
        $new_settings = json_decode($new_settings, true);
        $new_settings['invoice_footer'] = $this->input->post('invoice_footer');
        $new_settings['max_outlets'] = $this->input->post('max_outlets');
        $outlet = $this->input->post('outlet_id');
		
        if($outlet>0){
            $new_settings['max_pumps'.$outlet] = $this->input->post('max_pumps');
        }
		
		$update_data = array(
			'new_settings' => json_encode($new_settings)
		);

		if ($this->Constant_model->updateData('site_setting', $update_data, '1')) {
			$this->session->set_flashdata('alert_msg', array('success', 'Update Site Setting', 'Successfully updated Site Setting.'));
			redirect(base_url().'Sys_admin/sys_setting');
		}
    }
   
    public function editor($path, $width)
    {
        //Loading Library For Ckeditor
        $this->load->library('Ckeditor');
        $this->load->library('Ckfinder');
		
        //configure base path of ckeditor folder
        $this->ckeditor->basePath = base_url().'assets/ckeditor/';
        $this->ckeditor->config['toolbar'] = 'Full';
        $this->ckeditor->config['language'] = 'en';
        $this->ckeditor->config['width'] = $width;
		
        //configure ckfinder with ckeditor config
        $this->ckfinder->SetupCKEditor($this->ckeditor, $path);
    }
}
