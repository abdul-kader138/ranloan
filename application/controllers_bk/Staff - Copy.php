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
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='staff')");
		
		if(!isset($permission_data[0]->view_right)|| (isset($permission_data[0]->view_right) && $permission_data[0]->view_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'View Staff', 'You can not view staff. Please ask administrator!'));
				redirect($this->agent->referrer());
		}
        
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;

        $config = array();
        $config['base_url'] = base_url().'staff/view/';
        
        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Staff_model->record_staff_count();
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

        $data['results'] = $this->Staff_model->fetch_staff_data($config['per_page'], $page);
        
        //$data['deposits'] =ci_staff_deposit();
        
        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Staff_model->record_staff_count();

            $start_pg_point = 0;
            if ($have_count == 0) {
                $start_pg_point = 0;
            } else {
                $start_pg_point = 1;
            }

            $sh_text = "Showing $start_pg_point to ".count($data['results']).' of '.$this->Staff_model->record_staff_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Staff_model->record_staff_count().' entries';
            
        }
		$data['division_data'] = $this->db->get('division')->result();
        $data['outlet_data'] = $this->db->get('outlets')->result();
            
        $data['displayshowingentries'] = $sh_text;
        $data['setting_dateformat'] = $setting_dateformat;

        $this->load->view('staff', $data);
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
        $this->load->view('edit_staff', $data);
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
           $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
        $setting_currency = $paginationData[0]->currency;
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
           $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
        $setting_currency = $paginationData[0]->currency;
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
        
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat = $paginationData[0]->datetime_format;
        $setting_currency = $paginationData[0]->currency;
        
        
        $cust_id = $this->input->get('id');
            $startdate = $this->input->post('startdate');
             $enddate = $this->input->post('enddate');
        if(isset($start_date) and isset($end_date)){
            $this->db->where('ordered_datetime BETWEEN "'. 
                    date('Y-m-d', strtotime($startdate)). '" and "'.
                   date('Y-m-d', strtotime($enddate)).'"');
        }
        $data['id'] = $cust_id;
        $data['dateformat'] = $setting_dateformat;
        $data['currency'] = $setting_currency;
         $this->db->where("created_user_id", $cust_id);
         $this->db->order_by("id"," DESC");

        $query = $this->db->get("orders");
        $result = $query->result();
        $this->db->save_queries = false;
        $data['historyData']  =$result;
     //   $historyData = $this->Constant_model->getDataOneColumnSortColumn('orders', 'created_user_id', "$id", 'id', 'DESC');
    
       $this->load->view('staff_history', $data); 
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
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='staff')");
		
		if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add Staff', 'You can not add staff. Please ask administrator!'));
				redirect($this->agent->referrer());
		}
		
		
          $loginUserId= $this->session->userdata('user_id');
    $loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
     $data['UserLoginName'] =  $loginData[0]->fullname;
         
        $data['group']=$this->db->where('is_active',1)->get('division')->result();
        $data['outlet_group']=$this->db->where('status',1)->get('outlets')->result();
        $this->load->view('add_staff',$data);
        
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

        if ($this->Constant_model->deleteData('staff', $cust_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Staff', "Successfully Deleted Staff : $cust_fn."));
            redirect(base_url().'staff/view');
        }
    }
    // Delete Customer group;
    public function deldivision($id=0)
    {
        if ($id>0) {
            $array=array('is_active'=>0);
            $this->db->where('id',$id)->update('division',$array);
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Diviison', "Successfully Deleted Division"));
            redirect(base_url().'staff/adddivision');
        }
    }

    // Insert New Customer;
    public function insertDivision()
    {
        $name = $this->input->post('name');
        $id=$this->input->post('id');
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Division', 'Please enter Division Name!'));
            redirect(base_url().'staff/adddivision');
                    die();

        } 


            $ins_cust_data = array(
                      'name' => $name
                      
            );
            if ($id>0) {
                $this->db->where('id',$id)->update('division',$ins_cust_data);
                $this->session->set_flashdata('alert_msg', array('success', 'Update Division Group', "Successfully Division Update : $name"));
                redirect(base_url().'staff/adddivision');
            }else{
                $this->db->insert('division',$ins_cust_data);
                $this->session->set_flashdata('alert_msg', array('success', 'Add Division', "Successfully Added Division: $name"));
                redirect(base_url().'staff/adddivision');
            }
        
    }


    // Insert New Customer;
    public function insertStaff()
    {
        $staff_code = $this->input->post('staff_code');
        $staff_name = $this->input->post('staff_name');
        $staff_mobile = $this->input->post('staff_mobile');
        $email = $this->input->post('email');
        
        $password = $this->input->post('password');
        $conpassword = $this->input->post('conpassword');
        
        $division_id = $this->input->post('division_id');
        $outlet_id = $this->input->post('outlet_id');
        $address=$this->input->post('address');
		$staff_cni = $this->input->post('staff_cni');
        $thumbnail=$this->input->post('thumbnail');
        $title_points=$this->input->post('title_points');
        $percentage=$this->input->post('percentage');
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());
        
        $isviewsales=$this->input->post('isview');
        
        if(!isset($percentage)){
            echo $percentage =   0;
        }
        if(!isset($title_points)){
            echo $title_points =   0;
        }
        if(!isset($isviewsales)){
            echo $isviewsales =   0;
        }
        if(empty($division_id)){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Division', 'Please  Select Division!'));
            redirect(base_url().'staff/addStaff');
        }
        else if (empty($staff_name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Staff', 'Please enter Staff Full Name!'));
            redirect(base_url().'staff/addStaff');
        } else if($password != $conpassword){
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Staff', 'passwords does not match!'));
            redirect(base_url().'staff/addStaff');
        }
        else {
            if (!empty($email)) {
                $ckEmailData = $this->Constant_model->getDataOneColumn('staff', 'email', $email);

                if (count($ckEmailData) > 0) {
                    $this->session->set_flashdata('alert_msg', array('failure', 'Add Staff', "Email Address : $email is already existing in the system! Please try another email address!"));
                    redirect(base_url().'staff/addStaff');
                    die();
                }
            }
//            if(!empty($thumbnail)){
                //file upload

                    $config['upload_path']   = './assets/upload/staff'; 
                    $config['allowed_types'] = 'png|jpg|jpeg|gif|btm'; 
                    $config['max_size']      = 150; 
                    $config['file_name']      = $_FILES['thumbnail']['name'];; 
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload('thumbnail')) {
                        $this->session->set_flashdata('alert_msg', array('failure', 'Add Staff', $this->upload->display_errors()));
                    redirect(base_url().'staff/addStaff');
                    die();
//            }
             
                          
                    } else { 
//                        if(!empty($thumbnail)){
                              $image_path = $this->upload->data();
//                        }
                       
                        
            $ins_cust_data = array(
			/////
			'staff_code'=>$staff_code,
			'staff_name'=>$staff_name,
			'staff_mobile'=>$staff_mobile,
			'email'=>$email,
//			'password'=>$password,
			'division_id'=>$division_id,
			'assign_outlet'=>$outlet_id,
			'address'=>$address,
			'staff_cni'=>$staff_cni,
			'thumbnail'=> pathinfo($image_path['full_path'], PATHINFO_BASENAME),
//			'thumbnail'=>$thumbnail,
			'created_user_id'=>$us_id,
			'date_cre'=>$tm,
			'point_title'=>$title_points,
			'point_percentage'=>$percentage,
			'isview_sale'=>$isviewsales,
            );
//            echo "<pre>";
//            print_r($ins_cust_data);
//            exit;
                    }
            if ($this->Constant_model->insertData('staff', $ins_cust_data)) {
                $lastid = $this->db->insert_id();
                
               $password = encryptPassword($password);
                $ins_user_data = array(
                        'id' => $lastid,
                        'fullname' => $staff_name,
                        'email' => $email,
                        'password' => $password,
                        'role_id' => 3,
                        'outlet_id' => $outlet_id,
                        'created_user_id' => $us_id,
                        'created_datetime' => $tm,
                        'status' => '1',
                );
                    $this->Constant_model->insertData('users', $ins_user_data);
                $this->session->set_flashdata('alert_msg', array('success', 'Add Staff', "Successfully Added Staff : $staff_name"));
                redirect(base_url().'staff/addStaff');
            }
        }
    }


    public function updateStaff()
    {
        $cust_id = $this->input->post('id');
        $staff_code = $this->input->post('staff_code');
        $staff_name = $this->input->post('staff_name');
        $staff_mobile = $this->input->post('staff_mobile');
        $email = $this->input->post('email');
        $division_id = $this->input->post('division_id');
        $outlet_id = $this->input->post('outlets_id');
        $address=$this->input->post('address');
        $staff_cni = $this->input->post('staff_cni');
        $thumbnail=$this->input->post('thumbnail');
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

       echo     $title_points=$this->input->post('title_points');
       echo $percentage=$this->input->post('percentage');
     
        
              $upd_data = array(
                        'staff_code'=>$staff_code,
			'staff_name'=>$staff_name,
			'staff_mobile'=>$staff_mobile,
			'email'=>$email,
			'division_id'=>$division_id,
			'assign_outlet'=>$outlet_id,
			'address'=>$address,
			'staff_cni'=>$staff_cni,
//                               'thumbnail'=> pathinfo($image_path['full_path'], PATHINFO_BASENAME),
			'thumbnail'=>$thumbnail,
			'created_user_id'=>$us_id,
			'date_cre'=>$tm,
			'point_title'=>$title_points,
			'point_percentage'=>$percentage,
        ); 
//    }
       
        
        
        
        
        $upd_user_data = array(
                        'fullname' => $staff_name,
                        'email' => $email,
//                        'role_id' => $role,
                        'outlet_id' => $outlet_id,
                        'updated_user_id' => $us_id,
                        'updated_datetime' => $tm,
//                        'status' => $status,
                );
       if( $this->Constant_model->updateData('staff', $upd_data, $cust_id)){
           $this->Constant_model->updateData('users', $upd_user_data, $cust_id); 
       }

        $this->session->set_flashdata('alert_msg', array('success', 'Update Staff', 'Successfully Updated Staff Detail!'));
        redirect(base_url().'staff/edit_staff?id='.$cust_id);
    }
    
 


    // ****************************** Action To Database -- END ****************************** //
}
