<?php //
	class Loan_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
		}

		function getOutstanding($cus_id)
		{
			$this->db->where('id',$cus_id);
			$this->db->limit(1);
			$query = $this->db->get('customers');
			return $query->row();
		}
		
		function LoanSubmit($array_loan)
		{
			$this->db->insert('loan', $array_loan);
			return true;
		}
		
		function TotalOutStnading($totalOutStnading,$customer_id)
		{
			$this->db->set('loan_amount', $totalOutStnading);
			$this->db->where('id', $customer_id);
			$this->db->update('customers');
			return true;
		}
		
		function LoanFormNo()
		{
			$this->db->order_by('id','desc');
			$this->db->limit(1);
			$query  = $this->db->get('loan');
			$num = !empty($query->row()->id)?$query->row()->id:'0';
			return $num+1; 
		}
		
		function getLoan()
		{
			$this->db->select('loan.*,outlets.name as outletname, payment_method.id as paymentname,customers.fullname');
			$this->db->from('loan');
			$this->db->join('outlets','outlets.id = loan.outlet_id','left');
			$this->db->join('payment_method','payment_method.id = loan.payment_id','left');
			$this->db->join('customers','customers.id = loan.customer_id','left');
			if(!empty($this->input->get('outlet')))
			{
				$this->db->where('loan.outlet_id',$this->input->get('outlet'));
			}
			if(!empty($this->input->get('startdate')))
			{
				$this->db->where('DATE_FORMAT(loan.created_at,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('startdate'))));
			}
			if(!empty($this->input->get('enddate')))
			{
				$this->db->where('DATE_FORMAT(loan.created_at,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('enddate'))));
			}
			$query = $this->db->get();
			return $query->result();
		}
		
		
		
		
	}
?>