<?php
class Returnorder_model extends CI_Model
{
    public function __construct()
    {
        
        parent::__construct();
        $this->load->database();
    }
	
	public function getSalesReturnData()
	{
		$this->db->select('customers.fullname as customername,users.fullname,sales_return.*, payment_method.name as payment_method_name, outlets.name as outlets_name');	
		$this->db->from('sales_return');	
		$this->db->join('outlets','outlets.id = sales_return.outlet_id','left');	
		$this->db->join('payment_method','payment_method.id = sales_return.payment_method','left');	
		$this->db->join('users','users.id = sales_return.created_by','left');	
		$this->db->join('customers','customers.id = sales_return.customer_id','left');	
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(sales_return.created_at,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(sales_return.created_at,"%Y-%m-%d") <=', date('Y-m-d', strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getSalesReturnItemDetail($id)
	{
		$this->db->select('return_items.*,category.name as categoryname');	
		$this->db->from('return_items');	
		$this->db->join('category','category.id = return_items.product_category','left');	
		$this->db->where('return_items.order_id',$id);	
		$query = $this->db->get();	
		return $query->result();
	}
	
	public function getReturnSalesItemPrint($return_id)
	{
		$this->db->select('return_items.*,category.name as categoryname');	
		$this->db->from('return_items');	
		$this->db->join('category','category.id = return_items.product_category','left');	
		$this->db->where('return_items.order_id',$return_id);	
		$query = $this->db->get();	
		return $query->result();
	}
	
	public function getReturnSalesPrint($return_id)
	{
		$this->db->select('customers.fullname as customername,users.fullname,sales_return.*, payment_method.name as payment_method_name, outlets.name as outlets_name, outlets.address as outlets_address, outlets.contact_number as  outlets_tel, outlets.receipt_footer as receipt_footer');	
		$this->db->from('sales_return');	
		$this->db->join('outlets','outlets.id = sales_return.outlet_id','left');	
		$this->db->join('payment_method','payment_method.id = sales_return.payment_method','left');	
		$this->db->join('users','users.id = sales_return.created_by','left');	
		$this->db->join('customers','customers.id = sales_return.customer_id','left');	
		$this->db->where('sales_return.id',$return_id);
		$query = $this->db->get();
		return $query->row();
	}
	
	
}
