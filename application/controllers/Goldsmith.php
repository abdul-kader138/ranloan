<?php 
Class Goldsmith extends CI_Controller{


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

//  View Add gold smith
	 public function addGoldsmith()
    {
        $user_id = $this->session->userdata('user_id');
    	$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='goldsmith')");
    	
    	if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
    		$this->session->set_flashdata('alert_msg', array('failure', 'Add goldsmith', 'You can not add goldsmith. Please ask administrator!'));
                redirect($this->agent->referrer());
    	}
        
		$format_array = ci_date_format();
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['site_currency'] = $format_array['siteSetting_currency'];
        $data['dateformat'] = $format_array['dateformat'];
        $this->load->view('add_goldsmith',$data);
    }
	 public function editGoldsmith()
    {
        $user_id = $this->session->userdata('user_id');
    	$format_array = ci_date_format();
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['site_currency'] = $format_array['siteSetting_currency'];
        $data['dateformat'] = $format_array['dateformat'];
		$godsmith_id=$this->input->get('id');
		$data['goldsmith'] = $this->db->get_where('gold_smith', array('gs_id' => $godsmith_id))->row();
	
        $this->load->view('edit_goldsmith',$data);
    }
    
    
	public function Checkemail_goldsmith()
	{
		$requestedEmail = $this->input->post('email');
		$getemail=$this->db->get_where('gold_smith',array('email' => $requestedEmail))->num_rows();
		if($getemail == 0)
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}

	
	
// Save Goldsmith into the database
		public function save_goldsmith()
		{

				$old_date =  $this->input->post('dob');             
				$old_date_timestamp = strtotime($old_date);
				$new_date = date('Y-m-d', $old_date_timestamp);

                     $array_data =  array(
						'fullname'=>$this->input->post('fullname'),
						'email'=>$this->input->post('email'),
						'phone'=>$this->input->post('mobile'),
						'address'=>$this->input->post('address'),
						'land_phone_number'=>$this->input->post('land'),
						'dob'=>$new_date,
						'emp_no'=>$this->input->post('emp-num'),
						'opening_gold_qty'=>!empty($this->input->post('openinggoldqty'))?$this->input->post('openinggoldqty'):0,
						'gender'=>'Male',
						'status'=>'active',
						'gold_smith_num'=>$this->input->post('emp-pergram'),
						'date_created'=>date('Y-m-d'));
                    
                  $data = $this->Gold_module->insert_data('gold_smith',$array_data);
				  
				  $array_data_transaction =  array(
						'gold_smith_id'			=>	$data['last'],
						'weight_qty'			=>	!empty($this->input->post('openinggoldqty'))?$this->input->post('openinggoldqty'):0,
						'total_weight_balance'	=>	!empty($this->input->post('openinggoldqty'))?$this->input->post('openinggoldqty'):0,
						'available_weight_qty'	=>	!empty($this->input->post('openinggoldqty'))?$this->input->post('openinggoldqty'):0,
						'created_by'			=>	$this->session->userdata('user_id'),
						'created_date'			=>	date('Y-m-d H:i:s'));
				  
				  $this->Gold_module->insert_data('goldsmith_transaction',$array_data_transaction);
				  
                  $this->output->set_content_type('application/json')->set_output(json_encode($data));


		}
		public function Update_goldsmith()
		{

				$old_date =  $this->input->post('dob');             
				$old_date_timestamp = strtotime($old_date);
				$new_date = date('Y-m-d', $old_date_timestamp);
			         $up_array_data =  array(
                     'fullname'=>$this->input->post('fullname'),
                     'email'=>$this->input->post('email'),
                     'phone'=>$this->input->post('mobile'),
                     'address'=>$this->input->post('address'),
                     'land_phone_number'=>$this->input->post('land'),
                     'dob'=>$new_date,
                     'emp_no'=>$this->input->post('emp-num'),
                     'opening_gold_qty'=>!empty($this->input->post('openinggoldqty'))?$this->input->post('openinggoldqty'):0,
                     'gender'=>'Male',
                     'status'=>'active',
                     'date_created'=>date('Y-m-d'));
				$edit_id =  $this->input->post('edit_id');
				
				if(!empty($edit_id))
				{
					$this->Constant_model->updateDataGoldsmith('gold_smith', $up_array_data, $edit_id);
					$data['success']='update successfully';
				}
				else
				{
					$data['error']='error';
				}
				echo json_encode($data);


		}

function goldsmith(){
    
    $user_id = $this->session->userdata('user_id');
	$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='goldsmith')");
	
	if(!isset($permission_data[0]->view_right)|| (isset($permission_data[0]->view_right) && $permission_data[0]->view_right!=1)){
		$this->session->set_flashdata('alert_msg', array('failure', 'View goldsmith', 'You can not view goldsmith. Please ask administrator!'));
            redirect($this->agent->referrer());
	}

$format_array = ci_date_format();
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['site_currency'] = $format_array['siteSetting_currency'];
        $data['dateformat'] = $format_array['dateformat'];
$data['goldsmith'] = $this->Gold_module->select_All('gold_smith');
$this->load->view('includes/header');
$this->load->view('gold/goldsmith_list',$data);

$this->load->view('includes/footer');


    }
    
    
    




}

?>