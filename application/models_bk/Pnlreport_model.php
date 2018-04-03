<?php
class Pnlreport_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function getProfitLossReport()
	{
		$start_date =  date('Y-m-01',strtotime('this month'));
		$end_date	= date('Y-m-t',strtotime('this month'));
		
		$this->db->select('*');
		$this->db->from('gold_orders');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(gold_ordered_datetime,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		else
		{
			$this->db->where('DATE_FORMAT(gold_ordered_datetime,"%Y-%m-%d") >=', $start_date);
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(gold_ordered_datetime,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else
		{
			$this->db->where('DATE_FORMAT(gold_ordered_datetime,"%Y-%m-%d") <=', $end_date);
		}
		if(!empty($this->input->get('outlet')))
		{
			$this->db->where('gold_outlet_id', $this->input->get('outlet'));
		}
		$this->db->order_by('gold_id','desc');
//		$this->db->where('status','0');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getExpenseSum()
	{
		$start_date =  date('Y-m-01',strtotime('this month'));
		$end_date	= date('Y-m-t',strtotime('this month'));
		
		$this->db->select('SUM(amount) as totalExpenses');
		$this->db->from('expenses');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(date,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		else
		{
			$this->db->where('DATE_FORMAT(date,"%Y-%m-%d") >=', $start_date);
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(date,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else
		{
			$this->db->where('DATE_FORMAT(date,"%Y-%m-%d") <=', $end_date);
		}
		if(!empty($this->input->get('outlet')))
		{
			$this->db->where('outlet_id', $this->input->get('outlet'));
		}
		$query = $this->db->get();
		return $query->row()->totalExpenses;
	}
			
	
	public function getProfitLossItemReport($order_id)
	{
		$itemResult = $this->db->query("SELECT * FROM order_items_gold WHERE order_id = '".$order_id."'  ");
		return $itemResult->result();
	}
}
