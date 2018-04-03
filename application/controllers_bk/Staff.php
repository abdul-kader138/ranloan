<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Staff extends CI_Controller
{
    
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Staff_model');
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

    // ****************************** View Page -- START ****************************** //

    // View Customers;
    public function view()
    {
		$user_id = $this->session->userdata('user_id');
		$permisssion_url = 'staff';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
	    
		$data['results'] = $this->Staff_model->fetch_staff_data();
    	$data['division_data'] = $this->db->get('division')->result();
        $data['outlet_data'] = $this->db->get('outlets')->result();
		$this->load->view('staff/staff', $data);
    }

    // Edit Customer;
    public function edit_staff()
    {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='staff')");
		
		if(!isset($permission_data[0]->edit_right)|| (isset($permission_data[0]->edit_right) && $permission_data[0]->edit_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Edit Staff', 'You can not edit staff. Please ask administrator!'));
				redirect($this->agent->referrer());
		}
		
        $cust_id = $this->input->get('id');
        $data['group']=$this->db->where('is_active',1)->get('division')->result();
        $data['outlet_group']=$this->db->where('status',1)->get('outlets')->result();
        $data['id'] = $cust_id;
        $this->load->view('staff/edit_staff', $data);
    }
    
     // Edit Customer Password;
    public function edit_staff_pass()
    {
        $cust_id = $this->input->get('id');
        //$data['group']=$this->db->where('is_active',1)->get('customer_group')->result();
        $data['id'] = $cust_id;
        $this->load->view('edit_staff_pass', $data);
    }

    public function staff_history_search() {
         
        if($this->input->post())
        {
            $hid = $this->input->post('hid');
            $startdate = $this->input->post('startdate');
             $enddate = $this->input->post('enddate');
			  $q = $this->db->where('ordered_datetime BETWEEN "'. 
			date('Y-m-d', strtotime($startdate)). '" and "'.
		   date('Y-m-d', strtotime($enddate)).'"');
			$this->db->where("created_user_id", $hid);
			$this->db->order_by("id"," DESC");
		   $query = $this->db->get("orders");
		   $result = $query->result();
		   $this->db->save_queries = false;
		   $data['historyData']  =$result;
     
        $data['id'] = $hid;
        $data['dateformat'] = $setting_dateformat;
        $data['currency'] = $setting_currency;   
        $this->load->view('staff_history', $data);
        }
         
    }
    public function staff_point_search() {
          
        if($this->input->post())
        {
            $hid = $this->input->post('hid');
            $startdate = $this->input->post('startdate');
             $enddate = $this->input->post('enddate');
       $q = $this->db->where('ordered_datetime BETWEEN "'. 
                    date('Y-m-d', strtotime($startdate)). '" and "'.
                   date('Y-m-d', strtotime($enddate)).'"');
         $this->db->where("created_user_id", $hid);
         $this->db->order_by("id"," DESC");
        $query = $this->db->get("orders");
        $result = $query->result();
        $this->db->save_queries = false;
        $data['historyData']  =$result;
     
        $data['id'] = $hid;
        $data['dateformat'] = $setting_dateformat;
        $data['currency'] = $setting_currency;   
        $this->load->view('staff_point_history', $data);
        }
         
    }
    // View Customer History;
    public function staff_history()
    {
			$cust_id = $this->input->get('id');
            $startdate = $this->input->post('startdate');
             $enddate = $this->input->post('enddate');
			if(isset($start_date) and isset($end_date)){
				$this->db->where('ordered_datetime BETWEEN "'. 
				date('Y-m-d', strtotime($startdate)). '" and "'.
			    date('Y-m-d', strtotime($enddate)).'"');
			}
			
			$data['historyData'] =$this->Staff_model->fetch_sale_history($cust_id);
		    $this->load->view('staff/staff_history', $data); 
    }

      // View Customer History;
    public function staff_point_history()
    {

        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
        $setting_currency = $paginationData[0]->currency;

        $cust_id = $this->input->get('id');
 $this->db->where("created_user_id", $cust_id);
         $this->db->order_by("id"," DESC");

        $query = $this->db->get("orders");
        $result = $query->result();
        $this->db->save_queries = false;
        $data['historyData']  =$result;

       // $data['perDetail'] = $this->db->get_where('staffpercentage',array('staffId' => $cust_id))->result();
        $data['id'] = $cust_id;
        $data['dateformat'] = $setting_dateformat;
        $data['currency'] = $setting_currency;

        $this->load->view('staff_point_history', $data);
    }

    public function staff_redeem(){
    $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
        $setting_currency = $paginationData[0]->currency;

        $cust_id = $this->input->get('id');
     $loginUserId= $this->session->userdata('user_id');
    $loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
     $data['UserLoginName'] =  $loginData[0]->fullname;
       $data['id'] = $cust_id;
        $data['dateformat'] = $setting_dateformat;
        $data['currency'] = $setting_currency;
      //  $data['division_group']=$this->db->get('division')->result();
      //  $data['outlet_group']=$this->db->get('outlets')->result();
    $this->load->view('staff_redeem', $data);
    }

    public function insertRedeem(){
        $order_id = $this->input->post('hid');
        $staffPoint = $this->input->post('staffPoint');
        $redemmAmount = $this->input->post('redeemAmount');
        $date = $this->input->post('date');        
        $loginUserId= $this->session->userdata('user_id');
        if($redemmAmount >= $staffPoint){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Redeem Amount', 'Please enter amount less than balance amount!'));
         redirect(base_url().'staff/staff_redeem?id='.$order_id);
                    die();
        }

        
              $redeem_data = array(
                     'order_id'=>$order_id,
                      'staff_redeem'=>$redemmAmount,
                       'datee'=>$date,
                        'Created_by'=>$loginUserId,
                ); 

      $this->Constant_model->insertData('redeem', $redeem_data);
    $this->session->set_flashdata('alert_msg', array('success', 'Add Redeem Amount', 'Successfully Redeemed!'));
 redirect(base_url().'staff/staff_redeem?id='.$order_id);
    }

      // Edit redeem
    public function edit_redeem()
    {
        $cust_id = $this->input->get('id');
         $loginUserId= $this->session->userdata('user_id');
    $loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
     $data['UserLoginName'] =  $loginData[0]->fullname;
      //  $data['group']=$this->db->where('is_active',1)->get('division')->result();
      //  $data['outlet_group']=$this->db->where('status',1)->get('outlets')->result();
        $data['id'] = $cust_id;
        $this->load->view('edit_redeem', $data);
    }

     public function updateRedeem()
    {

        $redeem_id = $this->input->post('id');
        $redeemAmount = $this->input->post('redeemAmount');
        $datee = $this->input->post('date');
        $loginUserId= $this->session->userdata('user_id');

        $selectQuery = $this-> db-> get_where('redeem',array('id'=> $redeem_id)) ->row();
        $orderId = $selectQuery ->order_id;
        $alreadystaffredeem = $selectQuery ->staff_redeem;

        $selectOrderQuery = $this-> db-> get_where('orders',array('id'=> $orderId))-> row();
         $selectStaffRedeem= $selectOrderQuery-> staffPoint;

        $selectRedeemsData = $this-> db-> get_where('redeem',array('order_id'=> $orderId)) ->result();

        $totl = '';
        foreach ($selectRedeemsData as  $value) {
             $amount= $value-> staff_redeem;
            $totl +=$amount;
        }
            $totl -= $alreadystaffredeem;
            $totl += $redeemAmount;

        if($totl> $selectStaffRedeem ){
             $this->session->set_flashdata('alert_msg', array('failure', 'Add Redeem Amount', 'Please enter amount less than balance amount!'));
         redirect(base_url().'staff/edit_redeem?id='.$redeem_id);
                    die();
        }
              $redeem_data = array(   
                      'staff_redeem'=>$redeemAmount,
                       'datee'=>$datee,
                        'Created_by'=>$loginUserId,
                ); 

       $this->Constant_model->updateData('redeem',
        $redeem_data, $redeem_id);
 
        $this->session->set_flashdata('alert_msg', array('success', 'Update Redeem', 'Successfully Updated Redeem Detail!'));
        redirect(base_url().'staff/edit_redeem?id='.$redeem_id);
    }
    
    // Add Customer;
    public function addStaff()
    {
		$loginUserId= $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] =  $loginData[0]->fullname;

        $data['group']=$this->db->where('is_active',1)->get('division')->result();
        $data['outlet_group']=$this->db->where('status',1)->get('outlets')->result();
        $this->load->view('staff/add_staff',$data);
        
    }
	 public function adddivision($id=0)
    {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='division')");
		
		if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add Diviison', 'You can not add division. Please ask administrator!'));
				redirect($this->agent->referrer());
		}
		
        if($id>0){
            $data['edit']=$this->db->where('id',$id)->get('division')->row_array();
        }else{
            $data['edit']=null;
        }
        $data['group']=$this->db->where('is_active',1)->get('division')->result();
        $this->load->view('division',$data);
    }
    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

    // Delete Customer;
    public function deleteStaff()
    {
	   $cust_id = $this->input->post('id');
        $cust_fn = $this->input->post('staff_name');
		$cust_img = $this->input->post('thumbnail');
		
		unlink(base_url('assets/upload/staff/'.$cust_img));

        if ($this->Constant_model->deleteData('staff', $cust_id)) {
			$this->Constant_model->deleteData('users', $cust_id);
			
			
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Staff', "Successfully Deleted Staff : $cust_fn."));
            redirect(base_url().'staff/view');
        }
    }
    

   
    // Insert New Customer;
    public function insertStaff()
    {
		if(!empty($_POST))
		{
			$title_points=$this->input->post('title_points');
			$percentage=$this->input->post('percentage');
			$tm = date('Y-m-d H:i:s', time());
			$isviewsales=$this->input->post('isview');
			if (empty($this->input->post('staff_name'))) {
				$this->session->set_flashdata('alert_msg', array('failure', 'Add Staff', 'Please enter Staff Full Name!'));
				redirect(base_url().'staff/addStaff');
			} 
			else 
			{ 
					$ins_user_data = array(
					'fullname' => $this->input->post('staff_name'),
					'role_id' => 3,
					'outlet_id' => $this->input->post('outlet_id'),
					'created_user_id' => $this->session->userdata('user_id'),
					'created_datetime' => $tm,
					'status' => '1', );
			}   
			if ($this->Constant_model->insertData('users', $ins_user_data)) 
			{
				
					if(!empty($_FILES["thumbnail"]["name"]))
					{
						$target_file = date('Ymdhis').$_FILES["thumbnail"]["name"];
						move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'assets/upload/staff/' . $target_file);
					}
					else
					{
						$target_file = '';
					}
				
					$lastid = $this->db->insert_id();
					$ins_cust_data = array(
						'id'				=> $lastid,
						'staff_code'		=>$this->input->post('staff_code'),
						'staff_name'		=> $this->input->post('staff_name'),
						'staff_mobile'		=>$this->input->post('staff_mobile'),
						'assign_outlet'		=>$this->input->post('outlet_id'),
						'staff_cni'			=>$this->input->post('staff_cni'),
						'thumbnail'			=>$target_file,
						'created_user_id'	=>$this->session->userdata('user_id'),
						'date_cre'			=>$tm,
						'point_title'		=>!empty($title_points)?$title_points:0,
						'point_percentage'	=>!empty($percentage)?$percentage:0,
						'isview_sale'		=>!empty($isviewsales)?$isviewsales:0,
					);

					$this->Constant_model->insertData('staff', $ins_cust_data);
					$this->session->set_flashdata('alert_msg', array('success', 'Add Staff', "Successfully Added Staff : '".$this->input->post('staff_name')."'"));
					redirect(base_url().'staff/addStaff');
			}
		}
		else
		{
			redirect(base_url().'staff/addStaff');
		}
	}
    


    public function updateStaff()
    {
        $cust_id = $this->input->post('id');
	 if(!empty($_FILES['thumbnail']['name'])){ 
				 move_uploaded_file($_FILES['thumbnail']['tmp_name'],'./assets/upload/staff/'.date('ymdHis').$_FILES['thumbnail']['name']);
				   $thumbnail= date('ymdHis').$_FILES['thumbnail']['name'];
	 }else{
		 $tumbnail_file=$this->input->post('tumbnail_file');			
		 $thumbnail=$tumbnail_file;
	 }
        $upd_data = array(
            'staff_code'=>$this->input->post('staff_code'),
			'staff_name'=>$this->input->post('staff_name'),
			'staff_mobile'=>$this->input->post('staff_mobile'),
			'assign_outlet'=>$this->input->post('outlets_id'),
			'staff_cni'=>$this->input->post('staff_cni'),
			'thumbnail'=>$thumbnail,
			'created_user_id'=>$this->session->userdata('user_id'),
			'date_cre'=>date('Y-m-d H:i:s', time()),
			'point_title'=>$this->input->post('title_points'),
			'point_percentage'=>$this->input->post('percentage'),
        ); 

		 $upd_user_data = array(
                        'fullname' => $this->input->post('staff_name'),
                       'outlet_id' => $this->input->post('outlets_id'),
                        'updated_user_id' =>$this->session->userdata('user_id'),
                        'updated_datetime' => date('Y-m-d H:i:s', time()),

                );
       if( $this->Constant_model->updateData('staff', $upd_data, $cust_id)){
           $this->Constant_model->updateData('users', $upd_user_data, $cust_id); 
       }

        $this->session->set_flashdata('alert_msg', array('success', 'Update Staff', 'Successfully Updated Staff Detail!'));
        redirect(base_url().'staff/edit_staff?id='.$cust_id);
    }
    
 


    // ****************************** Action To Database -- END ****************************** //
}
