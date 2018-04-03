<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Setting_model');
        $this->load->model('Constant_model');
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
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }
	
	public function download_database()
	{
		
		$permisssion_url = 'download_database';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$this->load->view('download_database');
	}
	
	
	
	public function import_database() 
	{
		$templine = '';
		$lines = file($_FILES["uploadFile"]["tmp_name"]); 
		foreach ($lines as $line)
		{
			// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || $line == '')
			continue;

			// Add this line to the current templine we are creating
			$templine .= $line;

			// If it has a semicolon at the end, it's the end of the query so can process this templine
			if (substr(trim($line), -1, 1) == ';')
			{
			// Perform the query
			$this->db->query($templine);
			
			// Reset temp variable to empty
			$templine = '';
			}
		}
		$this->session->set_flashdata('SUCCESSMSG', "Database Import Successfully!!");
		redirect('setting/download_database');
	}
	
	
	public function getSubCategory()
	{
		$html = '';
		$category_id = $this->input->post('category_id');
		$selected_subcategory = $this->input->post('selected_subcategory');
		$sub = $this->Product_Code_Numbering_model->getSubCategory($category_id);
		$html.='<option value="">Select Sub Category</option>'; 
		foreach ($sub as $result)
		{
			$selected = '';
			if($selected_subcategory == $result->id)
			{
				$selected = 'selected';
			}
			$html.='<option '.$selected.' value='.$result->id.'>'.$result->sub_category.'</option>';
		}
		$json['suucess'] = $html;
		echo json_encode($json);
	}
	
	
	
	public function export_database() {
		$this->load->library('email');
		$getemail = $this->session->userdata('user_id');
		$email = $this->Constant_model->getEmailUser($getemail);
		$this->load->dbutil();
		$prefs = array(
				'format' => 'zip',
				'filename' => 'crmdata.sql'
		);
		$backup		= $this->dbutil->backup($prefs);
		$db_name	= 'crm-on-'. date("Y-m-d-H-i-s") .'.zip';
		$save		= 'assets/database_backup/'.$db_name;
		$this->load->helper('file');
		write_file($save, $backup);
		$this->load->helper('download');
		force_download($db_name, $backup);
	}
	
	
	public function send_mail_database() {
		$this->load->library('email');
		$getemail = $this->session->userdata('user_id');
		$email = $this->Constant_model->getEmailUser($getemail);
		$this->load->dbutil();
		$prefs = array(
				'format' => 'zip',
				'filename' => 'crmdata.sql'
		);
		$backup		= $this->dbutil->backup($prefs);
		$db_name	= 'crm-on-'. date("Y-m-d-H-i-s") .'.zip';
		$save		= 'assets/database_backup/'.$db_name;
		$this->load->helper('file');
		write_file($save, $backup);
		$this->load->helper('download');
//		force_download($db_name, $backup);
		$this->email->from($email, 'CRM');
		$this->email->to($email);
		$this->email->subject('CRM Database');
		$this->email->message('Please find attachment');
		$this->email->attach($save);
		if($this->email->send())
		{
			$this->session->set_flashdata('SUCCESSMSG', "Database Mail Successfully Send!!");
			redirect('setting/download_database');
		}
	}
	
	
	

    // ****************************** View Page -- START ****************************** //

    // View Setting;
    public function system_setting()
    {
		
		$permisssion_url = 'system_setting';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
        $this->load->view('system_setting');
    }

	public function add_new_page()
	{
		
		
		$permisssion_url = 'add_new_page';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getMainMoule'] = $this->Constant_model->getMainMoule();
		 $data['getroleData'] = $this->Constant_model->getDataAll('user_roles', 'id', 'ASC');
		if(!empty($_POST))
		{
			$this->form_validation->set_rules('name', 'Page Url', 'trim|required|alpha_dash|is_unique[resources.name]');
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('add_new_page',$data);
			}
			else
			{
				if($this->input->post('module') == 0)
				{
					$pid = 0;
				}
				else
				{
					$pid = $this->input->post('mainmodule');
				}
				$resources = array(
					'pid' => $pid,
					'name' => $this->input->post('name'),
					'title' => $this->input->post('title'),
					'created_user_id' => $this->session->userdata('user_id'),
					'created_datetime' => date('Y-m-d H:i:s'),
				);

				$reource_id = $this->Constant_model->insertDataReturnLastId('resources', $resources);
				
				$rules = array('role_id' => 1,
					'resource_id' => $reource_id,
					'allowed_type' => 'allow',
					'created_user_id' => $this->session->userdata('user_id'),
					'created_datetime' => date('Y-m-d H:i:s'),
				);

				$roleData=$this->input->post('role_user'); 
				
				foreach($roleData as $a) {    
					$rules['role_id'] = $a;     
					$rules_id = $this->Constant_model->insertDataReturnLastId('rules', $rules);
				}
				
				$modules = array('pid' => $pid,
					'name' => $this->input->post('name'),
					'title' => $this->input->post('title'),
					'created_user_id' => $this->session->userdata('user_id'),
					'created_datetime' => date('Y-m-d H:i:s'),
				);

				$module_id = $this->Constant_model->insertDataReturnLastId('modules', $modules);

				$permission = array(
					'user_id' => $this->session->userdata('user_id'),
					'resource_id' => $reource_id,
					'view_menu_right'=>1,
					'add_right'=>1,
					'edit_right'=>1,
					'view_right'=>1,
					'delete_right'=>1,
					'print_right'=>1,
					'email_right'=>1,
					'created_user_id' => $this->session->userdata('user_id'),
					'created_datetime' => date('Y-m-d H:i:s'),
				);
				$rules_id = $this->Constant_model->insertDataReturnLastId('permissions', $permission);
				
				$this->session->set_flashdata('SUCCESSMSG', "Page Added Successfully!!");
				redirect('setting/add_new_page');
			}
		}
		else
		{
			$this->load->view('add_new_page',$data);
		}
	}
		
	public function profitCalculations()
	{
		
		if(!empty($_POST))
		{
			$array_data = array(
			'category_id'	=> $this->input->post('category_id'),
			'category_name'	=> $this->input->post('category_name'),
			'sub_category_id'	=> $this->input->post('sub_category_id'),
			'sub_category_name'	=> $this->input->post('sub_category_name'),
			'gold_grade_id'	=> $this->input->post('gold_grade_id'),
			'gold_grade_name'	=> $this->input->post('gold_grade_name'),
			'profit'	=> $this->input->post('profit'),
			'min_profit'	=> $this->input->post('min_profit'),
			'gold_weight'	=> $this->input->post('gold_weight'),
			'wastage_weight'	=> $this->input->post('wastage_weight'),
			'stone_cost'	=> $this->input->post('stone_cost'),
			'labout_cost'	=> $this->input->post('labout_cost'),
			'other1_cost'	=> $this->input->post('other1_cost'),
			'other2_cost'	=> $this->input->post('other2_cost'),
			'other3_cost'	=> $this->input->post('other3_cost'),
			'create_date'	=> date('Y-m-d H:i:s'),
			'created_by'	=> $this->session->userdata('user_id')
			);
			$up_id=$this->input->post('edit_id');
			if(!empty($up_id))
			{
				$this->Constant_model->updateData('profit_calculations', $array_data, $up_id);
			}
			else
			{	
			$data = $this->db->insert('profit_calculations', $array_data);
			}
			$json['suceess'] = true;
		}
		else
		{
			$json['error'] = true;

		}
		echo json_encode($json);
	}
	
	
	
	
	//subcategioryget
	public function getSubCategoryProfit()
	{
		$html = '';
		$category_id = $this->input->post('category_id');
		$selected_subcategory = $this->input->post('selected_subcategory');
		$sub_cat_name = $this->input->post('sub_cat_name');
		$sub = $this->Setting_model->getSubCategoryprofit($category_id);
		$html.='<option value="">Select Sub Category</option>'; 
		foreach ($sub as $result)
		{
			$selected = '';
			$sub_cate = $result->sub_category;
			if($selected_subcategory == $result->id)
			{
				$selected = 'selected';
			}
			if($sub_cat_name == $sub_cate)
			$selected = 'selected';
			
			$html.='<option '.$selected.' value='.$result->id.'>'.$result->sub_category.'</option>';
		}
		$json['subcategory'] = $html;
		echo json_encode($json);
	}
	
	
	// View Outlet;
	public function outlets()
    {
		
		
		$permisssion_url = 'outlets';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;

        $config = array();
        $config['base_url'] = base_url().'setting/outlets/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Setting_model->record_outlet_count();
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

        $data['results'] = $this->Setting_model->fetch_outlet_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Setting_model->record_outlet_count();
            $sh_text = 'Showing 1 to '.count($data['results']).' of '.$this->Setting_model->record_outlet_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Setting_model->record_outlet_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;

        $this->load->view('outlets', $data);
    }
    
    // Add Outlet;
    public function addoutlet()
    {
		$path = '../js/ckfinder';
		$width = '100%';
		$this->editor($path, $width);  
		if(!empty($_POST))
		{
			
			$this->form_validation->set_rules('outlet_name', 'Outlet Name', 'required|is_unique[outlets.name]');
			$this->form_validation->set_rules('outlet_address', 'Outlet Address', 'required');
			$this->form_validation->set_rules('outlet_contact', 'Outlet Contact', 'required');
//			$this->form_validation->set_rules('receipt_footer', 'Receipt Footer', 'required');
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('add_outlet');
			}
			else
			{
				$outlet_name = strip_tags($this->input->post('outlet_name'));
				$outlet_address = strip_tags($this->input->post('outlet_address'));
				$outlet_contact = strip_tags($this->input->post('outlet_contact'));
				$receipt_footer = $this->input->post('receipt_footer');
				
				$ins_outlet_data = array(
					'name'				=> $outlet_name,
					'address'			=> $outlet_address,
					'contact_number'	=> $outlet_contact,
					'receipt_footer'	=> $receipt_footer,
					'created_user_id'	=> $this->session->userdata('user_id'),
					'created_datetime'	=> date('Y-m-d H:i:s'),
					'status'			=> '1',
				);

				$last_id = $this->Constant_model->insertDataReturnLastId('outlets', $ins_outlet_data);
				
				$count = $this->Constant_model->checkPaymentmethodOutletid($last_id);
				if($count == 0)
				{
					$getpayment = $this->Constant_model->getPaymentTypeGroupby();
					foreach ($getpayment as $value)
					{
						$payment = array(
							'name'				=> $value->name,
							'balance'			=> 0,
							'outlet_id'			=> $last_id,
							'created_user_id'   => $this->session->userdata('user_id'),
							'created_datetime'	=> date('Y-m-d H:i:s'),
							'updated_user_id'	=> $this->session->userdata('user_id'),
							'updated_datetime'	=> date('Y-m-d H:i:s'),
							'status'			=> '1',
						);

						$this->Constant_model->insertDataReturnLastId('payment_method', $payment);
					}
				}
				
				$this->session->set_flashdata('alert_msg', array('success', 'Add New Outlet', "Successfully added New Outlet : $outlet_name."));
				redirect(base_url().'setting/addoutlet');
			}
		}
		else
		{
			
			$this->load->view('add_outlet');
		}
		
    }

    // Edit Outlet;
	public function editoutlet()
    {
		$id = $this->input->get('id');
		$data['id'] = $id;
		$this->load->view('edit_outlet', $data);

    }

    // View User;
    public function users()
    {
		$permisssion_url = 'users';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}

        $data['results'] = $this->Setting_model->fetch_user_data();

        $this->load->view('users', $data);
    }

	public function adduser()
    {
        $this->load->view('add_user');
    }
	
	public function Checkemail_addnewuser()
	{
		$requestedEmail = $this->input->post('email');
		$getemail=$this->db->get_where('users',array('email' => $requestedEmail))->num_rows();
		if($getemail == 0)
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	}
    // Edit User;
    public function edituser()
    {
        $id = $this->input->get('id');

        $data['id'] = $id;
        $this->load->view('edit_user', $data);
    }

    // Change Password;
    public function changePassword()
    {
        $id = $this->input->get('id');

        $data['id'] = $id;
        $this->load->view('change_password', $data);
    }


   // Payment Method;
    public function payment_methods()
    {
		$permisssion_url = 'payment_methods';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;

        $config = array();
        $config['base_url'] = base_url().'setting/payment_methods/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';

        $config['total_rows'] = $this->Setting_model->record_payment_count();
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

        $data['results'] = $this->Setting_model->fetch_payment_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Setting_model->record_payment_count();
            $sh_text = 'Showing 1 to '.count($data['results']).' of '.$this->Setting_model->record_payment_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Setting_model->record_payment_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;

        $this->load->view('payment_methods', $data);
    }

	
	public function profit_calculations()
	{
     	$permisssion_url = 'profit_calculations';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$us_id = $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
		$data['logged_name'] = $get_logged_name->fullname;
		$data['getCategory'] = $this->Constant_model->getDataWhere('category');
		$data['getGoldGrade'] = $this->Constant_model->getDataWhere('gold_grade');
		$data['ListGetProfitcal'] = $this->Constant_model->getprofitcalall();
		 $data['user_profit_calculations'] = $this->db->order_by("id","desc")->get_where('profit_calculations', array('created_by' => $us_id))->row();
		$this->load->view('profit_calculations',$data);
	}
	public function edit_profit_calculations()
	{
     	$us_id = $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
     	$data['logged_name'] = $get_logged_name->fullname;
		$data['getCategory'] = $this->Constant_model->getDataWhere('category');
		$data['getGoldGrade'] = $this->Constant_model->getDataWhere('gold_grade');
		
		$edit_id = $this->input->get('id');
		$data['get_edit_data'] = $this->db->get_where('profit_calculations', array('id' => $edit_id))->row();
		$this->load->view('edit_profit_calculations',$data);
	}
	
	
    // Add New Payment Method;
    public function addpaymentmethod()
    {
        $this->load->view('add_payment_method');
    }

    // Edit Payment Method;
    public function editpaymentmethod()
    {
        $id = $this->input->get('id');
        $data['id'] = $id;
        $this->load->view('edit_payment_method', $data);
    }

    // View Suppliers;
    public function suppliers()
    {
		$permisssion_url = 'suppliers';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
        $data['results'] = $this->Setting_model->fetch_suppliers_data();
		$this->load->view('suppliers', $data);
    }

    // Add Supplier;
	
    public function addsupplier()
    {
        $this->load->view('add_supplier');
    }
	
    // Edit Supplier;
    public function editsupplier()
    {
        $id = $this->input->get('id');

        $data['id'] = $id;
        $this->load->view('edit_supplier', $data);
    }

    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

    // Delete Supplier;
    public function deleteSupplier()
    {
        $supplier_id = $this->input->post('supplier_id');
        $supplier_name = $this->input->post('supplier_name');

        if ($this->Constant_model->deleteData('suppliers', $supplier_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Supplier', "Successfully Deleted Supplier : $supplier_name."));
            redirect(base_url().'setting/suppliers');
        }
    }

    // Delete Outlet;
    public function deleteOutlet()
    {
        $outlet_id = $this->input->post('outlet_id');
        $outlet_name = $this->input->post('outlet_name');

        if ($this->Constant_model->deleteData('outlets', $outlet_id)) {
			$this->Constant_model->deleteDataPaymentOutlet($outlet_id);
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Outlet', "Successfully Deleted Outlet : $outlet_name."));
            redirect(base_url().'setting/outlets');
        }
    }

    // Delete User;
    public function deleteUser()
    {
        $us_id = $this->input->post('us_id');
        $us_name = $this->input->post('us_name');

        if ($this->Constant_model->deleteData('users', $us_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete User', "Successfully Deleted User : $us_name."));
            redirect(base_url().'setting/users');
        }
    }

    // Delete Payment Method;
    public function deletePaymentMethod()
    {
        $pay_id = $this->input->post('pay_id');
        $pay_name = $this->input->post('pay_name');

        if ($this->Constant_model->deleteData('payment_method', $pay_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Payment Method', "Successfully Deleted Payment Method : $pay_name."));
            redirect(base_url().'setting/payment_methods');
        }
    }

    // Update Supplier;
    public function updateSupplier()
    {
        $id = $this->input->post('id');
        $name = strip_tags($this->input->post('name'));
        $email = strip_tags($this->input->post('email'));
        $tel = strip_tags($this->input->post('tel'));
        $fax = strip_tags($this->input->post('fax'));
        $address = strip_tags($this->input->post('address'));
        $status = strip_tags($this->input->post('status'));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Supplier', 'Please enter Supplier Name!'));
            redirect(base_url().'setting/editsupplier?id='.$id);
        } elseif (empty($tel)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Supplier', 'Please enter Supplier Telephone Number!'));
            redirect(base_url().'setting/editsupplier?id='.$id);
        } elseif (empty($address)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Supplier', 'Please enter Supplier Address!'));
            redirect(base_url().'setting/editsupplier?id='.$id);
        } else {
            $upd_data = array(
                'name' => $name,
                'email' => $email,
                'address' => $address,
                'tel' => $tel,
                'fax' => $fax,
                'status' => $status,
                'updated_user_id' => $us_id,
                'updated_datetime' => $tm,
            );
            if ($this->Constant_model->updateData('suppliers', $upd_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Supplier', "Successfully Updated Supplier : $name"));
                redirect(base_url().'setting/editsupplier?id='.$id);
            }
        }
    }

    // Insert New Supplier;
    public function insertSupplier()
    {
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[suppliers.email]');
		$this->form_validation->set_rules('tel', 'Telephone ', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('add_supplier');
		}
		else
		{
			$name = strip_tags($this->input->post('name'));
			$email = strip_tags($this->input->post('email'));
			$tel = strip_tags($this->input->post('tel'));
			$fax = strip_tags($this->input->post('fax'));
			$address = strip_tags($this->input->post('address'));
			
			$us_id = $this->session->userdata('user_id');
			$tm = date('Y-m-d H:i:s', time());
			$ins_data = array(
				'name' => $name,
				'email' => $email,
				'address' => $address,
				'tel' => $tel,
				'fax' => $fax,
				'created_user_id' => $us_id,
				'created_datetime' => $tm,
				'status' => '1',
			);
			
			if ($this->Constant_model->insertData('suppliers', $ins_data)) {
				$this->session->set_flashdata('alert_msg', array('success', 'Add Supplier', "Successfully Added New Supplier : $name", '', '', '', '', ''));
				redirect(base_url().'setting/addsupplier');
			}
		}
    }

    // Update Payment Method;
    public function updatePaymentMethod()
    {
        $id = $this->input->post('id');
        $name = strip_tags($this->input->post('name'));
        $status = strip_tags($this->input->post('status'));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Payment Method', 'Please enter Payment Method!'));
            redirect(base_url().'setting/editpaymentmethod?id='.$id);
        } else {
            $upd_data = array(
                    'name' => $name,
                    'status' => $status,
                    'updated_user_id' => $us_id,
                    'updated_datetime' => $tm,
            );
            if ($this->Constant_model->updateData('payment_method', $upd_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Payment Method', 'Successfully Updated Payment Method.'));
                redirect(base_url().'setting/editpaymentmethod?id='.$id);
            }
        }
    }

    // Insert New Payment Method;
    public function insertPaymentMethod()
    {
        $name = strip_tags($this->input->post('name'));
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Payment Method', 'Please enter Payment Method Name!'));
            redirect(base_url().'setting/addpaymentmethod');
        } else {
            $ins_data = array(
                    'name' => $name,
                    'created_user_id' => $us_id,
                    'created_datetime' => $tm,
                    'status' => '1',
            );
            if ($this->Constant_model->insertData('payment_method', $ins_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Add New Payment Method', 'Successfully Added New Payment Method.'));
                redirect(base_url().'setting/addpaymentmethod');
            }
        }
    }

    // Update Password;
    public function updatePassword()
    {
        $id = $this->input->post('id');
        $pass = $this->input->post('pass');
        $conpass = $this->input->post('conpass');

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($pass)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Password', 'Please enter your New Password!'));
            redirect(base_url().'setting/changePassword?id='.$id);
        } elseif (empty($conpass)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Password', 'Please enter your Confirm Password!'));
            redirect(base_url().'setting/changePassword?id='.$id);
        } elseif ($pass != $conpass) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Password', 'New Password &amp; Confirm Password must be the same!'));
            redirect(base_url().'setting/changePassword?id='.$id);
        } else {
            $password = $this->encryptPassword($pass);

            $upd_data = array(
                    'password' => $password,
                    'updated_user_id' => $us_id,
                    'updated_datetime' => $tm,
            );
            if ($this->Constant_model->updateData('users', $upd_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Password', 'Successfully Updated your New Password.'));
                redirect(base_url().'setting/changePassword?id='.$id);
            }
        }
    }

    // Update User;
    public function updateUser()
    {
        $id = $this->input->post('id');
        $fn = strip_tags($this->input->post('fullname'));
        $email = strip_tags($this->input->post('email'));
        $role = strip_tags($this->input->post('role'));
        $outlet = strip_tags($this->input->post('outlet'));
        $status = strip_tags($this->input->post('status'));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if ($role == '1') {
            $outlet = '0';
        }

        if (empty($fn)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update User', 'Please enter Full Name!'));
            redirect(base_url().'setting/edituser?id='.$id);
        } elseif (empty($email)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update User', 'Please enter Email Address!'));
            redirect(base_url().'setting/edituser?id='.$id);
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update User', 'Invalid Email Address!'));
            redirect(base_url().'setting/edituser?id='.$id);
        } elseif (empty($role)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update User', 'Please Choose User Role!'));
            redirect(base_url().'setting/edituser?id='.$id);
        } else {
            $ckEmailData = $this->Constant_model->twoColumnNotEqual('users', 'email', "$email", 'id', "$id");

            if (count($ckEmailData) == 0) {
                $upd_data = array(
                        'fullname' => $fn,
                        'email' => $email,
                        'role_id' => $role,
                        'outlet_id' => $outlet,
                        'updated_user_id' => $us_id,
                        'updated_datetime' => $tm,
                        'status' => $status,
                );
                if ($this->Constant_model->updateData('users', $upd_data, $id)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Update User', 'Successfully Updated User Detail.'));
                    redirect(base_url().'setting/edituser?id='.$id);
                }
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Update User', 'Email Address, you updated already existing in the system!'));
                redirect(base_url().'setting/edituser?id='.$id);
            }
        }
    }

    // Insert New User;
    public function insertUser()
    {
		ini_set('memory_limit', '300M' );
		ini_set('upload_max_filesize', '300M');  
		ini_set('post_max_size', '300M');  
		ini_set('max_input_time', 3600);  
		ini_set('max_execution_time', 3600);
		
        $fn = strip_tags($this->input->post('fullname'));
        $email = strip_tags($this->input->post('email'));
        $pass = strip_tags($this->input->post('password'));
        $conpass = strip_tags($this->input->post('conpassword'));
        $role = strip_tags($this->input->post('role'));
		
        $outlet = strip_tags($this->input->post('outlet'));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($fn)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', 'Please enter Full Name!', "$fn", "$email", "$pass", "$conpass", "$role", "$outlet"));
            redirect(base_url().'setting/adduser');
        } elseif (empty($email)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', 'Please enter Email Address!', "$fn", "$email", "$pass", "$conpass", "$role", "$outlet"));
            redirect(base_url().'setting/adduser');
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', 'Invalid Email Address!', "$fn", "$email", "$pass", "$conpass", "$role", "$outlet"));
            redirect(base_url().'setting/adduser');
        } elseif (empty($pass)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', 'Please enter Password!', "$fn", "$email", "$pass", "$conpass", "$role", "$outlet"));
            redirect(base_url().'setting/adduser');
        } elseif (empty($conpass)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', 'Please enter Confirm Password!', "$fn", "$email", "$pass", "$conpass", "$role", "$outlet"));
            redirect(base_url().'setting/adduser');
        } elseif ($pass != $conpass) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', 'Password &amp; Confirm Password must be the same!', "$fn", "$email", "$pass", "$conpass", "$role", "$outlet"));
            redirect(base_url().'setting/adduser');
        } elseif (empty($role)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', 'Please Choose User Role!', "$fn", "$email", "$pass", "$conpass", "$role", "$outlet"));
            redirect(base_url().'setting/adduser');
        } else {
            $ckEmailData = $this->Constant_model->getDataOneColumn('users', 'email', "$email");

            if (count($ckEmailData) == 0) {
                $password = $this->encryptPassword($pass);

                $ins_user_data = array(
                        'fullname' => $fn,
                        'email' => $email,
                        'password' => $password,
                        'role_id' => $role,
                        'outlet_id' => $outlet,
                        'created_user_id' => $us_id,
                        'created_datetime' => $tm,
                        'status' => '1',
                );
				     $last_id=$this->Constant_model->insertDataReturnLastId('users', $ins_user_data);
						 
					if($role==7){
						$ins_permission = array(
							'user_id' => $last_id,
							'view_menu_right'=>1,
							'add_right'=>1,
							'edit_right'=>1,
							'view_right'=>1,
							'delete_right'=>1,
							'print_right'=>1,
							'email_right'=>1,
							'created_user_id' => $this->session->userdata('user_id'),
							'created_datetime' => date('Y-m-d H:i:s'),
						);
						$data_resources = $this->Constant_model->getDataWhere('resources');
						foreach($data_resources as $res)
						{
							$ins_permission['resource_id'] = $res->id;
							$this->Constant_model->insertDataReturnLastId('permissions', $ins_permission);
						}
					}
                    $this->session->set_flashdata('alert_msg', array('success', 'Add New User', "Successfully Added New User Account with Email : $email.", '', '', '', '', '', ''));
                    redirect(base_url().'setting/adduser');
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', "Email Address : $email is already registered at the system! Please try another Email Address!", "$fn", "$email", "$pass", "$conpass", "$role", "$outlet"));
                redirect(base_url().'setting/adduser');
            }
        }
    }

    // Update Outlet;
    public function updateOutlet()
    {
        $id = $this->input->post('id');
        $outlet_name = strip_tags($this->input->post('outlet_name'));
        $outlet_address = strip_tags($this->input->post('outlet_address'));
        $outlet_contact = strip_tags($this->input->post('outlet_contact'));
        $receipt_footer = $this->input->post('receipt_footer');
		
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($outlet_name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Outlet', 'Please enter your Outlet Name!'));
            redirect(base_url().'setting/editoutlet?id='.$id);
        } elseif (empty($outlet_address)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Outlet', 'Please enter your Outlet Address!'));
            redirect(base_url().'setting/editoutlet?id='.$id);
        } elseif (empty($outlet_contact)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Outlet', 'Please enter your Outlet Contact!'));
            redirect(base_url().'setting/editoutlet?id='.$id);
        } else {
            $upd_outlet_data = array(
                    'name' => $outlet_name,
                    'address' => $outlet_address,
                    'contact_number' => $outlet_contact,
                    'receipt_footer' => $receipt_footer,
                    'updated_user_id' => $us_id,
                    'updated_datetime' => $tm,
            );
            if ($this->Constant_model->updateData('outlets', $upd_outlet_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Outlet', "Successfully updated Outlet : $outlet_name."));
                redirect(base_url().'setting/editoutlet?id='.$id);
            }
        }
    }

    // Update Site Setting;
    public function updateSiteSetting()
    {
		
        $site_name	= strip_tags($this->input->post('site_name'));
        $timezone	= strip_tags($this->input->post('timezone'));
        $pagination = strip_tags($this->input->post('pagination'));
        $tax		= strip_tags($this->input->post('tax'));
        $currency	= strip_tags($this->input->post('currency'));
        $date_format		= strip_tags($this->input->post('date_format'));
        $display_product	= strip_tags($this->input->post('display_product'));
        $display_keyboard	= strip_tags($this->input->post('display_keyboard'));
        $default_customer	= strip_tags($this->input->post('default_customer'));
		$pre_print_invoice	= strip_tags($this->input->post('pre_print_invoice'));
		
		
		$new_settings['pre_so'] = strip_tags($this->input->post('pre_so'));
        $new_settings['post_so'] = strip_tags($this->input->post('post_so'));
        $new_settings['pre_po'] = strip_tags($this->input->post('pre_po'));
        $new_settings['post_po'] = strip_tags($this->input->post('post_po'));
        $new_settings['pumps'] = strip_tags($this->input->post('pumps'));
        $new_settings['invoice_footer'] = $this->input->post('invoice_footer');
        $new_settings['is_point'] = $this->input->post('is_point');
        $new_settings['point_percentage'] = $this->input->post('point_percentage');
		
		if(!empty($this->input->post('default_store')))
		{
			$default_store	= implode(",", $this->input->post('default_store'));
		}
		else
		{
			$default_store = '';
		}

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        if (empty($site_name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Site Setting', 'Please enter your Site Name!'));
            redirect(base_url().'setting/system_setting');
        } elseif (strlen($tax) == 0) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Site Setting', 'Please enter your Government Tax!'));
            redirect(base_url().'setting/system_setting');
        } elseif (!is_numeric($tax)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Site Setting', 'Government Tax must be Numeric Number!'));
            redirect(base_url().'setting/system_setting');
        } else {
//            $temp_fn = $_FILES['uploadFile']['name'];
//            if (!empty($temp_fn)) {
//                $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);
//
//                if (($temp_fn_ext == 'jpg') || ($temp_fn_ext == 'png') || ($temp_fn_ext == 'jpeg')) {
//                    if ($_FILES['uploadFile']['size'] > 500000) {
//                        $this->session->set_flashdata('alert_msg', array('failure', 'Update Site Setting', 'Upload file size must be less than 500KB!'));
//                        redirect(base_url().'setting/system_setting');
//
//                        die();
//                    }
//                } else {
//                    $this->session->set_flashdata('alert_msg', array('failure', 'Update Product', 'Invalid File Format! Please upload JPG, PNG, JPEG File Format for Log In Logo!'));
//                    redirect(base_url().'setting/system_setting');
//
//                    die();
//                }
//            }

            $mainPhoto_fn = $_FILES['uploadFile']['name'];
            if (!empty($mainPhoto_fn)) {
                $main_ext = pathinfo($mainPhoto_fn, PATHINFO_EXTENSION);
                $mainPhoto_name = 'logo.jpg';

                // Main Photo -- START;
                $config['upload_path'] = './assets/img/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['file_name'] = $mainPhoto_name;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('uploadFile')) {
                    $error = array('error' => $this->upload->display_errors());
                    //print_r($error);
                    //$this->load->view('upload_form', $error);
                    //$this->session->set_flashdata('alert_msg', array('error','warning','Error',"$error"));
                } else {
                    $width_array = array(200);
                    $height_array = array(200);
                    $dir_array = array('logo');

                    $this->load->library('image_lib');

                    for ($i = 0; $i < count($width_array); ++$i) {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = "./assets/img/$mainPhoto_name";
                        $config['maintain_ratio'] = true;
                        $config['width'] = $width_array[$i];
                        $config['height'] = $height_array[$i];
                        $config['quality'] = '100%';

                        $config['new_image'] = './assets/img/logo/'.$mainPhoto_name;

                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }

                    $this->load->helper('file');
                    $path = './assets/img/'.$mainPhoto_name;

                    if (unlink($path)) {
                    }
                }
                // Main Photo -- END;
            }// End of File;

            $update_data = array(
                    'site_name' => $site_name,
                    'timezone' => $timezone,
                    'pagination' => $pagination,
                    'tax' => $tax,
                    'currency' => $currency,
                    'datetime_format' => $date_format,
                    'display_product' => $display_product,
                    'display_keyboard' => $display_keyboard,
                    'default_customer_id' => $default_customer,
					'default_store_id' => $default_store,
                    'updated_user_id' => $us_id,
                    'updated_datetime' => $tm,
					'pre_print_invoice'=>$pre_print_invoice,
					'new_settings' => json_encode($new_settings),
            );
            if ($this->Constant_model->updateData('site_setting', $update_data, '1')) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Site Setting', 'Successfully updated Site Setting.'));
                redirect(base_url().'setting/system_setting');
            }
        }
    }

    // ****************************** Action To Database -- END ****************************** //

    public function encryptPassword($password)
    {
        return md5("$password");
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
	
	
	public function permission()
    {
		$permisssion_url = 'permission';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		
		$user_role = $this->session->userdata('user_role');
		if($user_role== 7)
		{
			$view_menu = 1;
		}
		else
		{
			$view_menu = $permission->view_menu_right;
		}
		
		if(( $view_menu == 0))
		{
			redirect('dashboard');
		}
		
		
		if(!empty($this->session->userdata('user_id')))
		{
			$user_id = $this->session->userdata('user_id');
			$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='permission')");
		
		}
		else
		{
			redirect('dashboard');
		}
		
	    $data=array();
		
        $user_id = 0;
		$allowed_type = 'allow';
		$sel_main_menu_arr = array();  
        $sel_view_menu_right_arr = array();  
        $sel_add_right_arr = array();
        $sel_edit_right_arr = array();
        $sel_view_right_arr = array();
        $sel_delete_right_arr = array();
        $sel_print_right_arr = array();
        $sel_email_right_arr = array();
        
        if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] >0){
            $user_id = $_REQUEST['user_id'];
            $data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id);
            foreach ($data as $row){
				$sel_main_menu_arr[$row->resource_id]= $row->main_menu;
                $sel_view_menu_right_arr[$row->resource_id]= $row->view_menu_right;
				$sel_add_right_arr[$row->resource_id]= $row->add_right;
                $sel_edit_right_arr[$row->resource_id]= $row->edit_right;
                $sel_view_right_arr[$row->resource_id]= $row->view_right;
                $sel_delete_right_arr[$row->resource_id]= $row->delete_right;
                $sel_print_right_arr[$row->resource_id]= $row->print_right;
                $sel_email_right_arr[$row->resource_id]= $row->email_right;
             
            }
            
        }
		$data ['sel_main_menu_arr'] =$sel_main_menu_arr;
        $data ['sel_view_menu_right_arr'] =$sel_view_menu_right_arr;
	    $data ['sel_add_right_arr'] =$sel_add_right_arr;
        $data ['sel_edit_right_arr'] =$sel_edit_right_arr;
        $data ['sel_view_right_arr'] =$sel_view_right_arr;
        $data ['sel_delete_right_arr'] =$sel_delete_right_arr;
        $data ['sel_print_right_arr'] =$sel_print_right_arr;
        $data ['sel_email_right_arr'] =$sel_email_right_arr;
        
       
        
		$user_role_id = $this->session->userdata('user_role');
		$role_condition='';
		if($user_role_id!=7){
			$role_condition='role_id!=7';
		}
		
        $data['roles_dd'] =  $this->Constant_model->getddData('users','id','fullname', 'id',$role_condition);
		
		$resource_dd =  $this->Constant_model->getmoduledata();
       
		function buildTree($elements, $parentId = 0) {
			$branch = array();
		
			foreach ($elements as $key=>$element) {
				if ($element['pid'] == $parentId) {
					$children = buildTree($elements, $element['id']);
					if ($children) {
						$element['children'] = $children;
					}
					$branch[$key] = $element;
				}
			}
			return $branch;
		}
		
		$data['role_id']=$user_role_id;
		$data['resource_dd'] = buildTree($resource_dd);
        $data['allowed_type_dd'] =  array('1'=>'1','0'=>'0');
        $data['user_id'] = $user_id;
        $data['allowed_type'] = $allowed_type;
		
		foreach($data['resource_dd'] as $key=>$val){
			$data['sub_resource_dd'][$key] = $this->Constant_model->getddData('resources','name','id', 'id',"pid=$key");
		}

		$two_res =  $this->Constant_model->get_sale_minimum_maxim($user_id);
		
		if(!empty($two_res))
		{
			$data ['sale_minimum_permission'] = $two_res[0]->sale_minimum_permission;
			$data ['sale_maximum_permission'] = $two_res[0]->sale_maximum_permission;
		}
		else
		{
			$data ['sale_minimum_permission'] = 0;
			$data ['sale_maximum_permission'] = 0;
		}

        $this->load->view('includes/header');
        $this->load->view('permission', $data);
        $this->load->view('includes/footer');    
    }
	
    public function updatepermission(){
        
		ini_set('memory_limit', '300M' );
		ini_set('upload_max_filesize', '300M');  
		ini_set('post_max_size', '300M');  
		ini_set('max_input_time', 3600);  
		ini_set('max_execution_time', 3600);

		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='permission')");
		
		if($this->session->userdata('user_role')!=7){
			
			if(!isset($permission_data[0]->edit_right)|| (isset($permission_data[0]->edit_right) && $permission_data[0]->edit_right!=1)){
				$this->session->set_flashdata('alert_msg', array('failure', 'Edit Permission', 'You can not edit permissions. Please ask administrator!'));
					redirect($this->agent->referrer());
			}
		}
		
        $resource_id = $_REQUEST['resource_id'];
        $user_id = $_REQUEST['user_id'];
		
		if($this->session->userdata('user_role')==7){
			$main_menu = isset($_REQUEST['main_menu'])?$_REQUEST['main_menu']:array();
		}
		
        $view_menu_right = isset($_REQUEST['view_menu_right'])?$_REQUEST['view_menu_right']:array();
	    $add_right = isset($_REQUEST['add_right'])?$_REQUEST['add_right']:array();
        $edit_right = isset($_REQUEST['edit_right'])?$_REQUEST['edit_right']:array();;
        $view_right = isset($_REQUEST['view_right'])?$_REQUEST['view_right']:array();
        $delete_right = isset($_REQUEST['delete_right'])?$_REQUEST['delete_right']:array();
        $print_right = isset($_REQUEST['print_right'])?$_REQUEST['print_right']:array();
        $email_right = isset($_REQUEST['email_right'])?$_REQUEST['email_right']:array();

        $sale_minimum_price = isset($_REQUEST['sale_minimum_right']) ? $_REQUEST['sale_minimum_right'] : 0 ;
        $sale_maximum_price = isset($_REQUEST['sale_maximum_right']) ? $_REQUEST['sale_maximum_right'] : 0;

            foreach($resource_id as $key=>$resource)
			{
				if($this->session->userdata('user_role')==7){
					$main_menu_data = isset($main_menu[$key])?$main_menu[$key]:0;
				}

                $view_menu = isset($view_menu_right[$key])?$view_menu_right[$key]:0;
				$add = isset($add_right[$key])?$add_right[$key]:0;
                $edit = isset($edit_right[$key])?$edit_right[$key]:0;
                $view = isset($view_right[$key])?$view_right[$key]:0;
                $delete = isset($delete_right[$key])?$delete_right[$key]:0;
                $print = isset($print_right[$key])?$print_right[$key]:0;
                $test = isset($email_right[$key])?$email_right[$key]:0;
               
				
                $data = array(
                    'user_id'		=>trim($user_id),
                    'resource_id'	=>trim($resource),
					'add_right'		=>trim($add),
                    'edit_right'	=>trim($edit),
                    'view_right'	=>trim($view),
                    'delete_right'	=>trim($delete),
                    'print_right'	=>trim($print),
                    'email_right'	=>trim($test),
                    'sale_minimum_permission'	=>trim($sale_minimum_price),
                    'sale_maximum_permission'	=>trim($sale_maximum_price),

				);

				if($this->session->userdata('user_role')==7)
				{
					$data['main_menu'] = $main_menu_data;
					$data['view_menu_right'] = $main_menu_data;
				}
				else
				{
					$data['view_menu_right'] = $view_menu;
				}
				
                $id =  $this->Constant_model->getSingle('permissions','id', 'user_id='.$user_id.' AND resource_id='.$resource);
		        $this->Constant_model->add_update('permissions','id='.$id,$data);
            }
			 redirect(base_url().'setting/permission');
    }
	
	
	 public function email_system_setting()
	 {
		$result= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$data['email_method']= $result[0]->email_method;
		$data['defult_email']= $result[0]->defult_email;
		$data['smtp_name']= $result[0]->smtp_name;
		$data['smtp_email']= $result[0]->smtp_email;
		$data['smtp_account']= $result[0]->smtp_account;
		$data['smtp_incoming_mail']= $result[0]->smtp_incoming_mail;
		$data['smtp_outgoing_mail']= $result[0]->smtp_outgoing_mail;
		$data['smtp_username']= $result[0]->smtp_username;
		$data['smtp_password']= $result[0]->smtp_password;
		
		$this->load->view('email_systm_setting',$data);
	  }
	
	public function update_email_system()
	{
		$result= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$password_val=$result[0]->smtp_password;
		$smtp_password=	$this->input->post('smtp_password');
		if($password_val != $smtp_password &&$password_val==''){
				$password=encryptPassword($smtp_password);
		}
		else{
			$password=	$this->input->post('smtp_password');
		}
		  $update_data = array(
			  'email_method' => $this->input->post('email_method'),
			  'defult_email' => $this->input->post('defult_email'),
			  'smtp_name' => $this->input->post('smtp_name'),
			  'smtp_email' => $this->input->post('smtp_email'),
			  'smtp_account' => $this->input->post('smtp_account'),
			  'smtp_incoming_mail' => $this->input->post('smtp_incoming_mail'),
			  'smtp_outgoing_mail' => $this->input->post('smtp_outgoing_mail'),
			  'smtp_username' => $this->input->post('smtp_username'),
			  'smtp_password' => $password,
			  
             );
		  
            if ($this->Constant_model->updateData('site_setting', $update_data, '1')) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Site Setting', 'Successfully updated Site Setting.'));
                redirect(base_url().'setting/email_system_setting');
            }
	}
	
	
	public function TestMail()
	{
		$result= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$email_setting =$result[0]->defult_email;
		if(!empty($email_setting))
		{
			$touser	 = $this->input->post('test_mail');
			$subjectuser = "Testing Mail by syzygy-systems";
			$txtuser	= 'Test Mail by syzygy-systems';

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From:".$email_setting."" . "\r\n";

			if(mail($touser,$subjectuser,$txtuser,$headers))
			{ 
				$this->session->set_flashdata('alert_msg', array('success', 'Send Mail', 'Successfully Mail Send!!'));
				redirect(base_url().'setting/email_system_setting');
			}
			else
			{
				$this->session->set_flashdata('alert_msg', array('failure', 'Send Mail', 'Due some error please try again!!'));
				redirect(base_url().'setting/email_system_setting');
			}
		
		}
		else
		{
			$this->session->set_flashdata('alert_msg', array('failure', 'Send Mail', 'Please enter frist default email!!'));
			redirect(base_url().'setting/email_system_setting');
		}
		
		
	}

	public function add_loan_type()
	{
     	$permisssion_url = 'add_loan_type';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$us_id = $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
		$data['logged_name'] = $get_logged_name->fullname;
		$data['GetloanDetailData'] = $this->Constant_model->GetloanDetailData();
		$this->load->view('add_loan_type',$data);
	}

	public function submit_loan_detail()
	{
		
		if(!empty($_POST))
		{
			$array_data = array(
			'loan_name'	=> $this->input->post('loan_name'),
			'no_of_month'	=> $this->input->post('no_of_month'),
			'monthly_interest'	=> $this->input->post('monthly_interest'),
			'grace_period'	=> $this->input->post('grace_period'),
			'first_penalty_interest'	=> $this->input->post('first_penalty_interest'),
			'first_penalty_afterday'	=> $this->input->post('first_penalty_afterday'),
			'first_penalty_firstday'	=> $this->input->post('first_penalty_firstday'),
			'first_penalty_applyday'	=> $this->input->post('first_penalty_applyday'),
			'second_penalty_interest'	=> $this->input->post('second_penalty_interest'),
			'second_penalty_afterday'	=> $this->input->post('second_penalty_afterday'),
			'second_penalty_firstday'	=> $this->input->post('second_penalty_firstday'),
			'second_penalty_applyday'	=> $this->input->post('second_penalty_applyday'),
			'create_date'	=> date("Y-m-d h:i:sa"),
			);
			$data = $this->db->insert('loan_detail', $array_data);
			$json['suceess'] = true;
		}
		else
		{
			$json['error'] = true;

		}
		echo json_encode($json);
	}
}
