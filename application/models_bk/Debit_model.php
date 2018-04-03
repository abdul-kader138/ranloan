<?php

class Debit_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function fetch_debit_data()
    {
		$this->db->select('gold_orders_payment.*,customers.credit_amount, customers.fullname as customer_name,outlets.name as outlet_name');
		$this->db->from('gold_orders_payment');
		$this->db->join('customers','customers.id = gold_orders_payment.customer_id','left');
		$this->db->join('outlets','outlets.id = gold_orders_payment.outlet_id','left');
		if(!empty($this->input->get('customer_id')))
		{
			$this->db->where('gold_orders_payment.customer_id', $this->input->get('customer_id'));
		}
        $this->db->where('gold_orders_payment.unpaid_amt !=', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
	
    public function getDebitPrint($id)
    {
		$this->db->select('orders_payment.*,customers.credit_amount');
		$this->db->from('orders_payment');
		$this->db->join('customers','customers.id = orders_payment.customer_id','left');
		$this->db->where('orders_payment.id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
        $result = $query->row();
        return $result;
    }
	
	
	
	public function getPaymentDataOrder($id)
	{
		$this->db->select('gold_orders_payment.*,customers.credit_amount, customers.fullname as customer_name,outlets.name as outlet_name');
		$this->db->from('gold_orders_payment');
		$this->db->join('customers','customers.id = gold_orders_payment.customer_id','left');
		$this->db->join('outlets','outlets.id = gold_orders_payment.outlet_id','left');
		$this->db->where('gold_orders_payment.id', $id);
		$this->db->limit(1);
	    $query = $this->db->get();
        return $query->row();
	}
}
