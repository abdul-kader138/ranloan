<?php
class Ba_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	
	
	public function getBankTransactionSheet()
	{
		$this->db->select('transactions.*, outlets.name as outletname,bank_accounts.account_number as bankaccountnumber');
		$this->db->from('transactions');
		$this->db->join('outlets','outlets.id = transactions.outlet_id','left');
		$this->db->join('bank_accounts','bank_accounts.id = transactions.account_number','left');
		if(!empty($this->input->get('outlet')))
		{
			$this->db->where('transactions.outlet_id',$this->input->get('outlet'));
		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(transactions.created,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(transactions.created,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$this->db->where('transactions.status','0');
		$this->db->where('transactions.transfer_status','1');
        $query = $this->db->get();
        return $query->result();	
	}
	
	public function getBankTransactionPrint($id)
	{
		$this->db->select('transactions.*, outlets.name as outletname,bank_accounts.account_number as bankaccountnumber');
		$this->db->from('transactions');
		$this->db->join('outlets','outlets.id = transactions.outlet_id','left');
		$this->db->join('bank_accounts','bank_accounts.id = transactions.account_number','left');
		$this->db->where('transactions.id',$id);
		$this->db->limit(1);
        $query = $this->db->get();
        return $query->row();	
	}
	
	
	
	
	
	public function getOrderPayment($order_id)
	{
		$this->db->where('id',$order_id);
		$this->db->limit('1');
		$query = $this->db->get('orders');
		return !empty($query->row()->totalamount)?number_format($query->row()->totalamount,2):0;
	}
	
	public function getBankAccount()
	{
		$this->db->select('*');
		$this->db->from('bank_accounts');
		if(!empty($this->input->get('account_number')))
		{
			$this->db->where('account_number',$this->input->get('account_number'));
		}
		if(!empty($this->input->get('bank')))
		{
			$this->db->where('bank',$this->input->get('bank'));
		}
		if(!empty($this->input->get('startdate')))
		{
			$this->db->where('DATE_FORMAT(created,"%Y-%m-%d") >= ',date('Y-m-d', strtotime($this->input->get('startdate'))));
		}
		if(!empty($this->input->get('enddate')))
		{
			$this->db->where('DATE_FORMAT(created,"%Y-%m-%d") <= ',date('Y-m-d', strtotime($this->input->get('enddate'))));
		}
		$query = $this->db->get();
		return $query->result();	
	}
	
	public function editBank($id)
	{
        $this->db->where('id', $id);
        $query = $this->db->get('bank_accounts');
        return $query->row();
	}
	
	public function getBalanceSheet()
	{
		$this->db->select('transactions.*, outlets.name as outletname, payment_method.name paymenttype');
		$this->db->from('transactions');
		$this->db->join('outlets','outlets.id = transactions.outlet_id','left');
		$this->db->join('payment_method','payment_method.id = transactions.account_number','left');
		if(!empty($this->input->get('payment')))
		{
			$this->db->where('transactions.account_number',$this->input->get('payment'));
		}
		if(!empty($this->input->get('bank_id')))
		{
			$this->db->where('transactions.transfer_status',1);
			$this->db->where('transactions.account_number',$this->input->get('bank_id'));
		}
		if(!empty($this->input->get('outlet')))
		{
			$this->db->where('transactions.outlet_id',$this->input->get('outlet'));
		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(transactions.created,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(transactions.created,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$this->db->where('transactions.status','0');
		$this->db->order_by('transactions.id','desc');
        $query = $this->db->get();
        return $query->result();	
	}
	
	public function getReceivedCheque()
	{
		$this->db->select('*');
		$this->db->from('orders_payment');
		$this->db->where('payment_method_name','Cheque');
		if(!empty($this->input->get('cheque_no')))
		{
			$this->db->where('cheque_number',$this->input->get('cheque_no'));
		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();	
	}
	
	public function getVoucherDetail()
	{
		$this->db->select('*');
		$this->db->from('orders_payment');
		$this->db->where('payment_method_name','Vouchers');
		if(!empty($this->input->get('vocher_no')))
		{
			$this->db->where('voucher_number',$this->input->get('vocher_no'));
		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
        $query = $this->db->get();
        return $query->result();	
	}
	
	public function getVoucherDetail_print($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('orders_payment');
		return $query->row();
		 
	}
	
	public function getExpensesOrderNumber()
	{
		$this->db->limit(1);
		$this->db->order_by('id', 'DESC');
        $query = $this->db->get('expenses');
		$number = !empty($query->row()->id) ? $query->row()->id : 0;
        return $number+1;
	}
	
	public function getChequeManager()
	{
		$this->db->where('payment_method_name','Cheque');
	    $query = $this->db->get('orders_payment');
		return $query->result();
	}
	
	public function getSupplierCheque()
	{
		$this->db->select('purchase_bills.*,bank_accounts.account_number, bank_accounts.bank as bank_name');
		$this->db->from('purchase_bills');
		$this->db->join('bank_accounts','bank_accounts.id = purchase_bills.cheque_bank','left');
		$this->db->where('purchase_bills.payment_name', 'Cheque');
        $query = $this->db->get();
		return $query->result();
	}
	
}
