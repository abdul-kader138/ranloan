<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Loan extends CI_controller {
	
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('pumps_model');
		$this->load->model('Loan_model');
		$this->load->model('pump_operators_model');
		$this->load->model('category_model');
		$this->load->model('Constant_model');

		$this->load->library('pagination');
		$this->load->helper('email');
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$setting_timezone = $settingData->timezone;
		date_default_timezone_set("$setting_timezone");
		if ($this->session->userdata('user_id') == "") {
			redirect(base_url());
		}
	}

	public function loan_list()
	{
		
		$permisssion_url = 'loan_list';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getLoan'] = $this->Loan_model->getLoan();
		$data['getOutlet'] = $this->Constant_model->getOutlets();
		$this->load->view('includes/header');
		$this->load->view('loan/loan_list', $data);
		$this->load->view('includes/footer');
	}
	
	public function add_loan()
	{
		$data['getOutlet'] = $this->Constant_model->getOutlets();
		$data['getCustomer'] = $this->Constant_model->getCustomer();
		$data['getPaymentMethod'] = $this->Constant_model->getPaymentMethod();
		$data['LoanFormNo'] = $this->Loan_model->LoanFormNo();
		
		$loginUserId = $this->session->userdata('user_id');
		$loginData = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		
		$data['UserLoginName'] = @$loginData[0]->fullname;
		if(!empty($this->input->get('cus_id')))
		{
			$data['current_outstanding'] = $this->Loan_model->getOutstanding($this->input->get('cus_id'));
		}
		
		$this->load->view('includes/header');
		$this->load->view('loan/add_loan', $data);
		$this->load->view('includes/footer');
	}
	
	public function submitLoan()
	{
//		print_r($_POST);
//		die;
		$pay_query = $this->Constant_model->getPaymentIDName($this->input->post('payment_id'));
		$pay_balance = $pay_query->balance;
		$now_balance = $pay_balance - $this->input->post('loan_amount');
		if($pay_balance < $this->input->post('loan_amount'))
		{
			$status['success'] = 0;
		}
		else
		{
				$array_loan = array(
					'loan_form_no'	=> $this->input->post('loan_form_no'),
					'customer_id'	=> $this->input->post('customer_id'),
					'loan_amount'	=> $this->input->post('loan_amount'),
					'outlet_id'		=> $this->input->post('outlet_id'),
					'payment_id'	=> $this->input->post('payment_id'),
					'note'			=> $this->input->post('note'),
					'created_at'	=> date('Y-m-d H:i:s'),
					'created_by'	=> $this->session->userdata('user_id'),
				);

				$this->Loan_model->LoanSubmit($array_loan);
				$totalOutStnading	= $this->input->post('loan_amount') + $this->input->post('current_outstanding');
				$this->Loan_model->TotalOutStnading($totalOutStnading,$this->input->post('customer_id'));

				$pay_data = array(
					'balance'			=> $now_balance,
					'updated_user_id'	=> $this->session->userdata('user_id'),
					'updated_datetime'	=> date('Y-m-d H:i:s')
				);

				$this->db->update('payment_method', $pay_data, array('id' => $this->input->post('payment_id')));

				$transaction_data = array(
					'trans_type'		=> 'loan',
					'outlet_id'			=> $this->input->post('outlet_id'),
					'amount'			=> $this->input->post('loan_amount'),
					'bring_forword'		=> $pay_balance,
					'account_number'	=> $this->input->post('payment_id'),
					'created_by'		=> $this->session->userdata('user_id'),
					'created'			=> date('Y-m-d H:i:s')
				);	

				$this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);	
				$this->session->set_flashdata('SUCCESSMSG', "Loan Added Successfully!!");
				$status['success'] = true;
		}
		echo json_encode($status);
	}
	
	
	public function submitSettle()
	{
		
		if($this->input->post('current_outstanding') < $this->input->post('settle_amount'))
		{
			$status['success'] = 0;
		}
		else
		{
				$array_loan = array(
					'loan_form_no'	=> $this->input->post('loan_settle_form_no'),
					'customer_id'	=> $this->input->post('customer_id'),
					'settle_amount'	=> $this->input->post('settle_amount'),
					'outlet_id'		=> $this->input->post('outlet_id'),
					'payment_id'	=> $this->input->post('receive_account'),
					'note'			=> $this->input->post('note'),
					'created_by'	=> $this->session->userdata('user_id'),
					'created_at'	=> date('Y-m-d H:i:s'),
				);

				$this->Loan_model->LoanSubmit($array_loan);
				$totalOutStnading	= $this->input->post('settle_amount') - $this->input->post('current_outstanding');
				$this->Loan_model->TotalOutStnading($totalOutStnading,$this->input->post('customer_id'));

				$pay_query = $this->Constant_model->getPaymentIDName($this->input->post('receive_account'));
				$pay_balance = $pay_query->balance;
				$now_balance = $pay_balance + $this->input->post('settle_amount');
				
				$pay_data = array(
					'balance'			=> $now_balance,
					'updated_user_id'	=> $this->session->userdata('user_id'),
					'updated_datetime'	=> date('Y-m-d H:i:s')
				);

				$this->db->update('payment_method', $pay_data, array('id' => $this->input->post('receive_account')));

				$transaction_data = array(
					'trans_type'		=> 'dep',
					'outlet_id'			=> $this->input->post('outlet_id'),
					'amount'			=> $this->input->post('settle_amount'),
					'bring_forword'		=> $pay_balance,
					'account_number'	=> $this->input->post('receive_account'),
					'created_by'		=> $this->session->userdata('user_id'),
					'created'			=> date('Y-m-d H:i:s')
				);	

				$this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);	
				$this->session->set_flashdata('SUCCESSMSG', "Settle Amount Added Successfully!!");
				$status['success'] = true;
		}
		echo json_encode($status);
	}
	
	public function settle_loan()
	{
		
		
		$permisssion_url = 'settle_loan';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getOutlet'] = $this->Constant_model->getOutlets();
		$data['getCustomer'] = $this->Constant_model->getCustomer();
		$data['getPaymentMethod'] = $this->Constant_model->getPaymentMethod();
		$data['LoanFormNo'] = $this->Loan_model->LoanFormNo();
		
		
		$this->load->view('includes/header');
		$this->load->view('loan/settle_loan', $data);
		$this->load->view('includes/footer');
	}
	
	public function findOutstanding()
	{
		$cusotmerid = $this->input->post('customerid');
		$current_outstanding = $this->Loan_model->getOutstanding($cusotmerid);
		$json['amount'] = !empty($current_outstanding->loan_amount)?$current_outstanding->loan_amount:'0';
		echo json_encode($json);
	}	
}
?>