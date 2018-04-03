<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Expenses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('pagination');
		
		
		$this->load->model('Expenses_model');
		$this->load->model('bdt_model');
		$this->load->model('ba_model');
        $this->load->model('Constant_model');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;
        date_default_timezone_set("$setting_timezone");
		
		if(empty($this->session->userdata('user_id')))
		{
			redirect(base_url());
		}
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }
	
	public function  expenses_print()
	{
		$id		= $this->input->get('id');
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		$data['result'] = $this->Expenses_model->getExpensesPrint($id);
		$this->load->view('expenses_print', $data);
	}
	
	
    // ****************************** View Page -- START ****************************** //

    // View Product Category;
    public function view()
    {
		$permisssion_url = 'expenses';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                $permission_re_id=$permission->resource_id;
                $permisssion_sub_url = 'view';
                $permissionsub = $this->Constant_model->getPermissionSubPageWise($permission_re_id,$permisssion_sub_url);
		if($permissionsub->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$paginationData		= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit	= $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;
        $setting_currency	= $paginationData[0]->currency;
		$data['results']			= $this->Expenses_model->fetch_expenses_data();
		$data['sExpData']			= $this->Constant_model->getDataAll("expense_categories", "name", "ASC");
        $data['site_currency']		= $setting_currency;
        $data['setting_dateformat']	= $setting_dateformat;
      	$sess_arr = ci_getSession_data();
		$user_outlet					= $sess_arr['user_outlet'];
        $user_role						= $sess_arr['user_role'];
		$data['getOutlet']				= $this->bdt_model->getOutletUserWise($user_outlet, $user_role);
		$data['expense_categories']		= $this->Constant_model->getDataOneColumn('expense_categories', 'status', '1');
		$data['getPaymentMethod']		= $this->bdt_model->getPaymentMethod();
		$data['expensesOrderNumber']	= $this->ba_model->getExpensesOrderNumber();
        $this->load->view('expenses', $data);
    }
	
	public function add_expenses_ajax()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules('expense_no','Expense No','trim|required');
        $this->form_validation->set_rules('Outlets','Outlets','trim|required');
        $this->form_validation->set_rules('datee','date','trim|required');
        $this->form_validation->set_rules('Amount','Amount','trim|required');
        $this->form_validation->set_rules('Category','Category','trim|required');
        $this->form_validation->set_rules('payment','payment','trim|required');
        $this->form_validation->set_rules('Reason','Reason','trim');
        $this->form_validation->set_rules('entry_no','Entry No','trim');
        $this->form_validation->set_error_delimiters("<span class='label label-danger'>","</span>");
		
		$us_id = $this->session->userdata('user_id');
        if($this->form_validation->run()== false){
            $data = array(
                'expense_no'	=> form_error('expense_no'),
                'Outlets'		=> form_error('Outlets'),
                'datee'			=> form_error('datee'),
                'Amount'		=> form_error('Amount'),
                'Category'		=> form_error('Category'),
                'payment'		=> form_error('payment'),
                'Reason'		=> form_error('Reason'),
                'entry_no'		=> form_error('entry_no'),
                'status'		=> FALSE
            );
            echo json_encode($data);
            die();
        }
		else
        {
			$payment_id			= $this->input->post('payment');
			$transcation_date	= $this->input->post('transation_date');
		
            $outlet				= $this->input->post('Outlets');
			$select_outlet		= $this->db->get_where('outlets',array('id'=>$outlet))->row();
			
			$data = array(
				'expenses_number'	=> ($this->input->post('expense_no')),
				'outlet_id'			=> $this->input->post('Outlets'),
				'outlet_name'		=> $select_outlet->name,
				'date'				=> $this->input->post('datee'),
				'created_datetime'	=> date('Y-m-d H:i:s'),
				'amount'			=> $this->input->post('Amount'),
				'expense_category'	=> $this->input->post('Category'),
				'reason'			=> $this->input->post('Reason'),
				'transation_date'	=> date( 'Y-m-d', strtotime($transcation_date)),
				'payment_type'		=> $this->input->post('payment'),
				'transaction_id_fk' => $this->input->post('entry_no'),
				'created_user_id'	=> $us_id,
				'status'			=> "1",
			);
			$this->db->insert('expenses',$data);
            echo json_encode(array("status" => TRUE));
        }
    }
	
	public function ChangePaymentOutlet()
	{
		$outlet_id = $this->input->post('outletid');
		$getOutletWisePaymentMethod = $this->Constant_model->getOutletWisePaymentMethod($outlet_id);
		$html = '';
		$html.='<option value="">Choose Payment Type</option>';
		foreach ($getOutletWisePaymentMethod as $payment)
		{
			if($payment->name  == "Cash" || $payment->name  == "Cheque")
			{ 
				$html.='<option value='.$payment->id.'>'.$payment->name.'</option>';
			}
		}
		$json['payment'] = $html;
		echo json_encode($json);
	}
	
    // Search Expenses;
    public function searchExpenses()
    {
        $expenses_numb		= $this->input->get('expenses_numb');
        $search_category 	= $this->input->get("search_category");
		$outlet				= $this->input->get('outlet');
        $start_date			= $this->input->get('start_date');
        $end_date			= $this->input->get('end_date');

        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;
        $setting_currency = $paginationData[0]->currency;

        if ($setting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($setting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($setting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($setting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($setting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($setting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($setting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($setting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($setting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }

        $data['dateformat']			= $dateformat;
        $data['setting_dateformat'] = $setting_dateformat;
        $data['site_currency']		= $setting_currency;

        $data['search_expenses_numb']	= $expenses_numb;
        $data["search_category"]		= $search_category;
        $data['search_outlet']			= $outlet;
        $data['search_start_date']		= $start_date;
        $data['search_end_date']		= $end_date;
        $this->load->view('search_expenses', $data);
    }

    // View Add New Expenses;
    public function addNewExpenses()
    {
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency = $siteSettingData[0]->currency;

        if ($siteSetting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($siteSetting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($siteSetting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($siteSetting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($siteSetting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($siteSetting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($siteSetting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($siteSetting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($siteSetting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }

        $data['site_dateformat'] = $siteSetting_dateformat;
        $data['site_currency'] = $siteSetting_currency;
        $data['dateformat'] = $dateformat;

        $this->load->view('add_expenses', $data);
    }

    // Edit Expenses;
    public function editExpenses()
    {
        $id = $this->input->get('id');

        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency = $siteSettingData[0]->currency;

        if ($siteSetting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($siteSetting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($siteSetting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($siteSetting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($siteSetting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($siteSetting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($siteSetting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($siteSetting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($siteSetting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }

        $data['site_dateformat'] = $siteSetting_dateformat;
        $data['site_currency'] = $siteSetting_currency;
        $data['dateformat'] = $dateformat;
        $data['id'] = $id;
        $this->load->view('edit_expenses', $data);
    }
    
    // View Expenses Category;
    public function expense_category(){
		$permisssion_url = 'expense_category';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['expData'] = $this->Constant_model->getDataAll("expense_categories", "id", "DESC");
	    $this->load->view("expense_category",$data);
    }
    // View Add Expenses Category;
    public function expense_category_add(){
	    $this->load->view("expense_category_add");
    }
    // View Edit Expenses Category;
    public function expense_category_edit(){
	    $id 		= $this->input->get("id");
	    
	    $data["id"]	= $id;
	    $this->load->view("expense_category_edit", $data);
    }
    

    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

	// Update Expenses Category;
	public function updateExpenseCategory(){
		$id 			= $this->input->post("id");
		$name 			= strip_tags($this->input->post("name"));
		$status 		= strip_tags($this->input->post("status"));
		
		$us_id 			= $this->session->userdata('user_id');
        $tm 			= date('Y-m-d H:i:s', time());
        
        if(empty($name)){
	        $this->session->set_flashdata('alert_msg', array('failure', 'Update Expense Category', 'Please enter Expense Category Name!'));
            redirect(base_url().'expenses/expense_category_edit?id='.$id);
        } else {
	        $upd_data 		= array(
		      		"name"				=>	$name,
		      		"updated_user_id"	=>	$us_id,
		      		"updated_datetime"	=>	$tm,
		      		"status"			=>	$status  
	        );
	        if($this->Constant_model->updateData("expense_categories", $upd_data, $id)){
				$this->session->set_flashdata('alert_msg', array('success', 'Update Expense Category', "Successfully Updated Expense Category Name : $name!"));
				redirect(base_url().'expenses/expense_category_edit?id='.$id);
			}
        }
	}

	// Insert Expenses Category;
	public function insertExpenseCategory(){
		$name 			= strip_tags($this->input->post("name"));
		$status 		= strip_tags($this->input->post("status"));
		
		$us_id 			= $this->session->userdata('user_id');
        $tm 			= date('Y-m-d H:i:s', time());

		if(empty($name)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add Expense Category', 'Please enter Expense Category Name!'));
            redirect(base_url().'expenses/expense_category_add');
		} else {
			
			$ins_data 	= array(
					"name"				=>	$name,
					"created_user_id"	=>	$us_id,
					"created_datetime"	=>	$tm,
					"status"			=>	$status	
			);
			if($this->Constant_model->insertData("expense_categories", $ins_data)){
				$this->session->set_flashdata('alert_msg', array('success', 'Add Expense Category', "Successfully Added New Expense Category Name : $name!"));
				redirect(base_url().'expenses/expense_category');
			}
		}
	}

    // Delete Expenses;
    public function deleteExpenses()
    {
        $id = $this->input->get('id');

        $expDtaData = $this->Constant_model->getDataOneColumn('expenses', 'id', $id);
        if (count($expDtaData) == 0) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Delete Expenses', 'Error on deleting Expenses!'));
            redirect(base_url().'expenses/view');
        } else {
            if ($this->Constant_model->deleteData('expenses', $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Delete Expenses', 'Successfully Deleted Expenses!'));
                redirect(base_url().'expenses/view');
            }
        }
    }

    // Update Expenses;
    public function updateExpenses()
    {
        $id = $this->input->post('id');
        $number = strip_tags($this->input->post('number'));
        $outlet = strip_tags($this->input->post('outlet'));
        $date = date('Y-m-d', strtotime(strip_tags($this->input->post('date'))));
        $amount = strip_tags($this->input->post('amount'));
        $reason = strip_tags($this->input->post('reason'));
        $exp_category 		= strip_tags($this->input->post("category"));
		$transcation_date= $this->input->post('transation_date');
			
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        $temp_fn = $_FILES['uploadFile']['name'];
        if (!empty($temp_fn)) {
            $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

            if ($_FILES['uploadFile']['size'] > 2097152) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New Expenses', 'Upload file size must be less than 2MB!'));
                redirect(base_url().'expenses/addNewExpenses');

                die();
            }
        }

        if (empty($number)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Expenses', 'Please enter Expenses Number!'));
            redirect(base_url().'expenses/editExpenses?id='.$id);
        } elseif (empty($outlet)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Expenses', 'Please Choose Expenses for Outlet!'));
            redirect(base_url().'expenses/editExpenses?id='.$id);
        } elseif (empty($date)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Expenses', 'Please enter Expenses Date!'));
            redirect(base_url().'expenses/editExpenses?id='.$id);
        } elseif (empty($amount)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Expenses', 'Please enter Expenses Amount!'));
            redirect(base_url().'expenses/editExpenses?id='.$id);
        } else if (empty($exp_category)){
	        $this->session->set_flashdata('alert_msg', array('failure', 'Update Expenses', 'Please select Expenses Category!'));
            redirect(base_url().'expenses/editExpenses?id='.$id);
        } else {
            $upd_data = array(
                    'expenses_number' => $number,
                    "expense_category"		=>	$exp_category,
                    'outlet_id' => $outlet,
                    'date' => $date,
                    'amount' => $amount,
                    'reason' => $reason,
					'transation_date'=>date( 'Y-m-d', strtotime($transcation_date)),
                    'updated_user_id' => $us_id,
                    'updated_datetime' => $tm,
            );
            if ($this->Constant_model->updateData('expenses', $upd_data, $id)) {
                $temp_fn = $_FILES['uploadFile']['name'];
                if (!empty($temp_fn)) {
                    $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

                    $new_name = time().".$temp_fn_ext";

                    // Main Photo -- START;
                    $config['upload_path'] = './assets/upload/expenses/';
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $new_name;
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('uploadFile')) {
                        $error = array('error' => $this->upload->display_errors());
                        //print_r($error);
                        //$this->load->view('upload_form', $error);
                        //$this->session->set_flashdata('alert_msg', array('error','warning','Error',"$error"));
                    } else {
                        $upd_file_name_data = array(
                                'file_name' => $new_name,
                        );
                        $this->Constant_model->updateData('expenses', $upd_file_name_data, $id);
                    }
                }

                $this->session->set_flashdata('alert_msg', array('success', 'Update Expenses', 'Successfully Updated Expenses!'));
                redirect(base_url().'expenses/editExpenses?id='.$id);
            }
        }
    }

    // Insert;
    public function insertNewExpenses()
    {
        $number = strip_tags($this->input->post('number'));
        $outlet = strip_tags($this->input->post('outlet'));
        $date = date('Y-m-d', strtotime(strip_tags($this->input->post('date'))));
        $amount = strip_tags($this->input->post('amount'));
        $reason = strip_tags($this->input->post('reason'));
		$exp_category 		= strip_tags($this->input->post("category"));

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        $temp_fn = $_FILES['uploadFile']['name'];
        if (!empty($temp_fn)) {
            $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

            if ($_FILES['uploadFile']['size'] > 2097152) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New Expenses', 'Upload file size must be less than 2MB!'));
                redirect(base_url().'expenses/addNewExpenses');

                die();
            }
        }

        if (empty($number)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Expenses', 'Please enter Expenses Number!'));
            redirect(base_url().'expenses/addNewExpenses');
        } elseif (empty($outlet)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Expenses', 'Please Choose Expenses for Outlet!'));
            redirect(base_url().'expenses/addNewExpenses');
        } elseif (empty($date)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Expenses', 'Please enter Expenses Date!'));
            redirect(base_url().'expenses/addNewExpenses');
        } elseif (empty($amount)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Expenses', 'Please enter Expenses Amount!'));
            redirect(base_url().'expenses/addNewExpenses');
        } else if (empty($exp_category)){
	        $this->session->set_flashdata('alert_msg', array('failure', 'Add New Expenses', 'Please select Expenses Category!'));
            redirect(base_url().'expenses/addNewExpenses');
        } else {
            $ins_data = array(
                    'expenses_number' => $number,
                    "expense_category"		=>	$exp_category,
                    'outlet_id' => $outlet,
                    'date' => $date,
                    'amount' => $amount,
                    'reason' => $reason,
                    'created_user_id' => $us_id,
                    'created_datetime' => $tm,
                    'status' => '1',
            );
            $exp_id = $this->Constant_model->insertDataReturnLastId('expenses', $ins_data);

            $temp_fn = $_FILES['uploadFile']['name'];
            if (!empty($temp_fn)) {
                $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

                $new_name = time().".$temp_fn_ext";

                // Main Photo -- START;
                $config['upload_path'] = './assets/upload/expenses/';
                $config['allowed_types'] = '*';
                $config['file_name'] = $new_name;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('uploadFile')) {
                    $error = array('error' => $this->upload->display_errors());
                    //print_r($error);
                    //$this->load->view('upload_form', $error);
                    //$this->session->set_flashdata('alert_msg', array('error','warning','Error',"$error"));
                } else {
                    $upd_file_name_data = array(
                            'file_name' => $new_name,
                    );
                    $this->Constant_model->updateData('expenses', $upd_file_name_data, $exp_id);
                }
            }

            $this->session->set_flashdata('alert_msg', array('success', 'Add New Expenses', 'Successfully Added New Expenses!'));
            redirect(base_url().'expenses/addNewExpenses');
        }
    }

    // ****************************** Action To Database -- END ****************************** //

    // ****************************** Export Excel -- START ****************************** //
    // Export Expenses;
    public function exportExpenses()
    {
        $user_role = $this->session->userdata('user_role');
        $user_outlet = $this->session->userdata('user_outlet');

        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $site_dateformat = $siteSettingData[0]->datetime_format;
        $site_currency = $siteSettingData[0]->currency;

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

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Expenses Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Expenses Number');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Expenses Category');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Expense Date');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Reason');
		$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Payment Type');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Amount ($site_currency)");

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;
        $total_exp_amt = 0;
		
		$results = $this->Expenses_model->fetch_expenses_data();
		foreach ($results as $value)
		{
			$total_exp_amt = $total_exp_amt + $value->amount;
			$objPHPExcel->getActiveSheet()->setCellValue("A$jj", $value->expenses_number);
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", $value->expense_categories_name);
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", $value->outletname);
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", date("$site_dateformat", strtotime($value->date)));
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", $value->reason);
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", $value->paymentname);
            $objPHPExcel->getActiveSheet()->setCellValue("G$jj", $value->amount);

            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);

            $objPHPExcel->getActiveSheet()->getDefaultStyle("F$jj")->getAlignment()->setWrapText(true);
			 ++$jj;
		}
		
	    $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:F$jj");
        $objPHPExcel->getActiveSheet()->setCellValue("A$jj", 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$total_exp_amt ($site_currency)");

        $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Expenses_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function exportSearchExpenses()
    {
        $user_role = $this->session->userdata('user_role');
        $user_outlet = $this->session->userdata('user_outlet');

        $search_expenses_numb = $this->input->get('expenses_numb');
        $search_outlet = $this->input->get('outlet');
        $search_start_date = $this->input->get('start_date');
        $search_end_date = $this->input->get('end_date');

        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;
        $setting_currency = $paginationData[0]->currency;

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

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Expenses Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Expenses Number');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Expenses Category');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Expense Date');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Reason');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Amount ($setting_currency)");

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;
        $total_exp_amt = 0;

        $sort = '';
        $date_sort = '';

        if (!empty($search_expenses_numb)) {
            $sort .= " AND expenses_number LIKE '$search_expenses_numb%' ";
        }
        if (!empty($search_outlet)) {
            if ($search_outlet == '-') {
                $sort .= ' AND outlet_id > 0 ';
            } else {
                $sort .= " AND outlet_id = '$search_outlet' ";
            }
        }
        if (!empty($search_start_date) && !empty($search_end_date)) {
            $url_start = $search_start_date;
            $url_end = $search_end_date;

            if ($setting_dateformat == 'd/m/Y') {
                $startArray = explode('/', $url_start);
                $endArray = explode('/', $url_end);

                $start_day = $startArray[0];
                $start_mon = $startArray[1];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[0];
                $end_mon = $endArray[1];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($setting_dateformat == 'd.m.Y') {
                $startArray = explode('.', $url_start);
                $endArray = explode('.', $url_end);

                $start_day = $startArray[0];
                $start_mon = $startArray[1];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[0];
                $end_mon = $endArray[1];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($setting_dateformat == 'd-m-Y') {
                $startArray = explode('-', $url_start);
                $endArray = explode('-', $url_end);

                $start_day = $startArray[0];
                $start_mon = $startArray[1];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[0];
                $end_mon = $endArray[1];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }

            if ($setting_dateformat == 'm/d/Y') {
                $startArray = explode('/', $url_start);
                $endArray = explode('/', $url_end);

                $start_day = $startArray[1];
                $start_mon = $startArray[0];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[1];
                $end_mon = $endArray[0];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($setting_dateformat == 'm.d.Y') {
                $startArray = explode('.', $url_start);
                $endArray = explode('.', $url_end);

                $start_day = $startArray[1];
                $start_mon = $startArray[0];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[1];
                $end_mon = $endArray[0];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($setting_dateformat == 'm-d-Y') {
                $startArray = explode('-', $url_start);
                $endArray = explode('-', $url_end);

                $start_day = $startArray[1];
                $start_mon = $startArray[0];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[1];
                $end_mon = $endArray[0];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }

            if ($setting_dateformat == 'Y.m.d') {
                $startArray = explode('.', $url_start);
                $endArray = explode('.', $url_end);

                $start_day = $startArray[2];
                $start_mon = $startArray[1];
                $start_yea = $startArray[0];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[2];
                $end_mon = $endArray[1];
                $end_yea = $endArray[0];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($setting_dateformat == 'Y/m/d') {
                $startArray = explode('/', $url_start);
                $endArray = explode('/', $url_end);

                $start_day = $startArray[2];
                $start_mon = $startArray[1];
                $start_yea = $startArray[0];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[2];
                $end_mon = $endArray[1];
                $end_yea = $endArray[0];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($setting_dateformat == 'Y-m-d') {
                $startArray = explode('-', $url_start);
                $endArray = explode('-', $url_end);

                $start_day = $startArray[2];
                $start_mon = $startArray[1];
                $start_yea = $startArray[0];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[2];
                $end_mon = $endArray[1];
                $end_yea = $endArray[0];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }

            $url_start = date('Y-m-d', strtotime($url_start));
            $url_end = date('Y-m-d', strtotime($url_end));

            //$start_date = $url_start.' 00:00:00';
            //$end_date 	= $url_end.' 23:59:59';

            $date_sort = " AND date >= '$url_start' AND date <= '$url_end' ";
        }

        $expResult = $this->db->query("SELECT * FROM expenses WHERE status = '1' $sort $date_sort ORDER BY date DESC ");
        $expData = $expResult->result();

        for ($e = 0; $e < count($expData); ++$e) {
            $id = $expData[$e]->id;
            $number = $expData[$e]->expenses_number;
            $outlet_id = $expData[$e]->outlet_id;
            $amount = $expData[$e]->amount;
            $date = date("$setting_dateformat", strtotime($expData[$e]->date));
            $exp_reason = $expData[$e]->reason;
            
            $exp_cat_id 		= $expData[$e]->expense_category;
            
            $exp_cat_name 		= "";
            $expCatNameData 	= $this->Constant_model->getDataOneColumn('expense_categories', 'id', $exp_cat_id);
            if(count($expCatNameData) > 0){
                $exp_cat_name 	= $expCatNameData[0]->name;
            }

            $total_exp_amt += $amount;

            $outlet_name = '';
            $outletNameData = $this->Constant_model->getDataOneColumn('outlets', 'id', $outlet_id);
            $outlet_name = $outletNameData[0]->name;

            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$number");
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$exp_cat_name");
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$outlet_name");
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$date");
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$exp_reason");
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$amount");

            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);

            $objPHPExcel->getActiveSheet()->getDefaultStyle("D$jj")->getAlignment()->setWrapText(true);

            unset($id);
            unset($number);
            unset($outlet_id);
            unset($amount);
            unset($date);
            unset($exp_reason);

            ++$jj;
        }
        unset($expResult);
        unset($expData);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:E$jj");
        $objPHPExcel->getActiveSheet()->setCellValue("A$jj", 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$total_exp_amt ($setting_currency)");

        $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Expenses_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    // ****************************** Export Excel -- END ****************************** //
}
