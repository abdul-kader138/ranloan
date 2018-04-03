<?php
class Expenses_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function fetch_expenses_data()
    {
		$temp_role = $this->session->userdata('user_role');
		$this->db->select('expenses.*,payment_method.name as paymentname,expense_categories.name as expense_categories_name,outlets.name as outletname');
		$this->db->from('expenses');
		$this->db->join('payment_method','payment_method.id = expenses.payment_type','left');
		$this->db->join('expense_categories','expense_categories.id = expenses.expense_category','left');
		$this->db->join('outlets','outlets.id = expenses.outlet_id','left');
		if ($temp_role > 1) 
		{
            $this->db->where('expenses.outlet_id', $temp_outlet);
        }
		if(!empty($this->input->get('expenses_numb')))
		{
			$this->db->where('expenses.expenses_number', $this->input->get('expenses_numb'));
		}
		if(!empty($this->input->get('search_category')))
		{
			$this->db->where('expenses.expense_category', $this->input->get('search_category'));
		}
		if(!empty($this->input->get('outlet')))
		{
			$this->db->where('expenses.outlet_id', $this->input->get('outlet'));
		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(expenses.created_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(expenses.created_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
    }
	
	
	
	public function getExpensesPrint($id)
	{
		$this->db->select('expenses.*,payment_method.name as paymentname,expense_categories.name as expense_categories_name,outlets.name as outletname');
		$this->db->from('expenses');
		$this->db->join('payment_method','payment_method.id = expenses.payment_type','left');
		$this->db->join('expense_categories','expense_categories.id = expenses.expense_category','left');
		$this->db->join('outlets','outlets.id = expenses.outlet_id','left');
		$this->db->where('expenses.id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	public function CategoryExpenseTotal($expense_id)
	{
		$this->db->select('SUM(amount) AS TotalAmount');
		$this->db->from('expenses');
		$this->db->where('expense_category',$expense_id);
		$query = $this->db->get();
		return !empty($query->row()->TotalAmount)?$query->row()->TotalAmount:0;
	}
	
	
	
	
	
}
