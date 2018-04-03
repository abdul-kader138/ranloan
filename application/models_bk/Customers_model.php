<?php
class Customers_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	
	public function getCustomerDeposite($customer_id)
	{
		$this->db->where('id',$customer_id);
		$this->db->limit(1);
		$query = $this->db->get('customers');
		return !empty($query->row()->deposit)?$query->row()->deposit:0;
	}
	
	
	public function record_customers_count()
    {
		
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('customers');
        $this->db->save_queries = false;

        return $query->num_rows();
    }
	
	public function UpdateDeposite($finaldeposite,$customer_id)
	{
		$this->db->where('id',$customer_id);
		$this->db->set('deposit',$finaldeposite);
		$this->db->update('customers');
		return true;
	}
	
	public function getMaxSetLimitid()
	{
		$this->db->limit(1);
		$this->db->order_by('id','desc');
		$query = $this->db->get('credit_limit');
		$number = !empty($query->row()->id)?$query->row()->id:0;
		return $number + 1;
	}
	
	public function getCustomerCredit($customer_id)
	{
		$this->db->where('id',$customer_id);
		$this->db->limit(1);
		$query = $this->db->get('customers');
		return !empty($query->row()->credit_amount)?$query->row()->credit_amount:0;
	}
	
	public function UpdateNewCreditLimit($customer_id,$new_limit)
	{
		$this->db->where('id',$customer_id);
		$this->db->set('credit_amount',$new_limit);
		$this->db->update('customers');
		return true;
	}
		
	public function UpdateCreditColor($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('credit_colours',$data);
		return true;
	}
	
	public function SubmitCreditLimit($array)
	{
		$this->db->insert('credit_limit',$array);
		return true;
	}
	
	public function getCreditLimit()
	{
		$this->db->select('credit_limit.*,customers.fullname');
		$this->db->from('credit_limit');
		$this->db->join('customers','customers.id = credit_limit.customer_id','left');
		$query = $this->db->get();
		return $query->result();
	}
	public function getCreditCust_list()
	{
		$this->db->select('credit_limit.*,customers.fullname');
		$this->db->from('credit_limit');
		$this->db->join('customers','customers.id = credit_limit.customer_id','left');
		$this->db->group_by('customer_id');
		$query = $this->db->get();
		return $query->result();
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
		$this->db->select('gold_orders.*, (SELECT SUM(qty) FROM order_items_gold WHERE order_items_gold.order_id = gold_orders.gold_id) as totalqty ');
		$this->db->from('gold_orders');
		$this->db->where('gold_orders.gold_customer_id',$cust_id);
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
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(transactions.created,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(transactions.created,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
	
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
	
	public function getUnpaidOrderTotal($customer_id)
	{
		$this->db->select('sum(unpaid_amt) as TotalGrandAmount');
		$this->db->from('orders_payment');
		$this->db->where('customer_id',$customer_id);
		$this->db->where('unpaid_amt !=', 0);
		$query = $this->db->get();
		return  !empty($query->row()->TotalGrandAmount)?$query->row()->TotalGrandAmount:0;
	}
	
	
}
