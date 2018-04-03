<?php
class Customers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function fetch_customers_data()
    {
        if(!empty($this->input->get('name')))
		{
			$this->db->where('fullname',$this->input->get('name'));
		}
        if(!empty($this->input->get('email')))
		{
			$this->db->where('email',$this->input->get('email'));
		}
        if(!empty($this->input->get('mobile')))
		{
			$this->db->where('mobile',$this->input->get('mobile'));
		}
        $query = $this->db->get('customers');
		return  $query->result();
    }
	
	public function getUnpaidCustomerOrder($customerid)
	{
		$this->db->select('*');
		$this->db->from('orders_payment');
		$this->db->where('unpaid_amt !=', 0);
		$this->db->where('customer_id',$customerid);
		$this->db->where('status',0);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getOrderCustomerHistory($cust_id)
	{
		$this->db->select('orders.*, (SELECT SUM(qty) FROM order_items WHERE order_items.order_id = orders.id) as totalqty ');
		$this->db->from('orders');
		$this->db->where('orders.customer_id',$cust_id);
		$query = $this->db->get();
		return  $query->result();
	}
	
	
	public function getOrderItemCustomerHistory($sales_id)
	{
		$this->db->where('order_id',$sales_id);
		$query = $this->db->get('order_items');
		return  $query->result();
	}
	
	public function getOrderPaymentCustomerHistory($sales_id)
	{
		$this->db->where('order_id',$sales_id);
		$query = $this->db->get('orders_payment');
		return  $query->result();
	}
	
	public function customer_transaction($customer_id)
	{
		$this->db->select('transactions.*, outlets.name as outletname, payment_method.name paymenttype');
		$this->db->from('transactions');
		$this->db->join('outlets','outlets.id = transactions.outlet_id','left');
		$this->db->join('payment_method','payment_method.id = transactions.account_number','left');
		$this->db->where('transactions.user_id',$customer_id);
		$query = $this->db->get();
		return  $query->result();
	}
	
	public function getUnpaidOrder($customer_id)
	{
		$this->db->where('customer_id',$customer_id);
		$this->db->where('unpaid_amt !=', 0);
		$query = $this->db->get('orders_payment');
		return  $query->result();
	}
	
	
}
