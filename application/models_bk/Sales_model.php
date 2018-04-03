<?php
class Sales_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function getTodaySales($user_role,$user_outlet)
	{
		$today_start = date('Y-m-d');
		$this->db->select('gold_orders.*,customers.fullname as customername,users.fullname  as sales_person_name');
		$this->db->from('gold_orders');
		$this->db->join('customers','customers.id = gold_orders.gold_customer_id','left');
		$this->db->join('users','users.id = gold_orders.sale_person_id','left');
		$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d")', $today_start);
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_created_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_created_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		if ($user_role == 1) {
			$query = $this->db->get();
		} 
		else 
		{
			$this->db->where('gold_orders.outlet_id', $user_outlet);
			$query = $this->db->get();
		}
		return $query->result();
	}
	
	public function getTodaySales_qty_price()
	{
		$today_start = date('Y-m-d');
		$this->db->select('COUNT(gold_id) as total_order,SUM(gold_grandtotal) as total_amount,SUM(gold_paid_amt) as total_gold_paid_amt');
		$this->db->from('gold_orders');
		$this->db->where('DATE_FORMAT(gold_ordered_datetime,"%Y-%m-%d")', $today_start);
		$query = $this->db->get();
		return $query->row();
	}
	public function getReserved_Item_List()
	{
		$this->db->select('gold_orders.*,order_items_gold.*,inventory.*,sub_category.sub_category as sub_category_name,order_items_gold.id as order_item_id');
		$this->db->from('gold_orders');
		$this->db->join('order_items_gold','order_items_gold.order_id = gold_orders.gold_id','left');
		$this->db->join('gold_order_services','gold_order_services.order_items_gold_id = order_items_gold.id','left');
		$this->db->join('sub_category','sub_category.id = gold_order_services.services_name','left');
		$this->db->join('inventory','inventory.ow_id = order_items_gold.warehouse_id','left');
		$this->db->where('inventory.outlet_id = gold_orders.gold_outlet_id');
		$this->db->where('inventory.ow_id = order_items_gold.warehouse_id');
		$this->db->where('inventory.product_code = order_items_gold.product_code');
		$this->db->where('inventory.qty <= 0');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		if(!empty($this->input->get('sub_category')))
		{
			$this->db->where('gold_order_services.services_name =',$this->input->get('sub_category'));
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function getTodaySalesInvoice($user_role,$user_outlet)
	{
		$today_starts = date('Y-m-d');
		$this->db->select('sales_invoice.*,customers.fullname as customername,users.fullname  as sales_person_name');
		$this->db->from('sales_invoice');
		$this->db->join('customers','customers.id = sales_invoice.sales_customer_id','left');
		$this->db->join('users','users.id = sales_invoice.sale_person_id','left');
		$this->db->where('DATE_FORMAT(sales_invoice.sales_ordered_datetime,"%Y-%m-%d")', $today_starts	);
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(sales_invoice.sales_ordered_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(sales_invoice.sales_ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		if ($user_role == 1) {
			$query = $this->db->get();
		} 
		else 
		{
			$this->db->where('sales_invoice.sales_outlet_id', $user_outlet);
			$query = $this->db->get();
		}
		return $query->result();
	}
	
	public function getTodaySalesInvoice_qty_price()
	{
		$today_startaa = date('Y-m-d');
		$this->db->select('COUNT(sales_id) as total_order,SUM(sales_grandtotal) as total_amount,SUM(sales_paid_amt) as total_sales_paid_amt');
		$this->db->from('sales_invoice');
		$this->db->where('DATE_FORMAT(sales_ordered_datetime,"%Y-%m-%d")', $today_startaa);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	function getmatchCustomer_Data($cust_id)
	{
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->where('id',$cust_id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query;
	}
	
	public function getSingleGoldGrade($gradeval_id)
	{	
		$this->db->where('grade_id',$gradeval_id);
		$this->db->limit(1);
		$query = $this->db->get('gold_grade');
		return $query->row();
	}
	
	public function get_sales_report_qty($product_code)
	{
		
		$this->db->limit(1);
		$this->db->order_by('id', 'DESC');
		$this->db->where('product_code',$product_code);
        $query = $this->db->get('sales_invoice_report');
		return $query->row();
	}
	public function getcustomer_order($id)
	{
		$this->db->select('*');
		$this->db->from('gold_orders');
		$this->db->where('gold_customer_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function getpayment_mehtd_name($id)
	{
		$this->db->where('outlet_id',$id);
		$query = $this->db->get('payment_method');
		return $query->result();
	}
	/*
	#############################################################
	# this existing function is modified by a3frt
	# data: 07-11-17 for fixing show the setting showrooms START
	#############################################################
	*/
	/*public function getOutletWareHouse($id)
	{
		$this->db->select('outlet_warehouse.*,stores.s_name');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','outlet_warehouse.w_id  = stores.s_id');
		$this->db->where('outlet_warehouse.out_id',$id);
		$this->db->where('stores.s_status','1');
		$this->db->where('stores.bulk_status','0');
		$query = $this->db->get();
		return $query->result();
	}*/ //this was main

	//New added by a3frt

	function get_site_setting()
	{
		$this->db->select('default_store_id');
		$this->db->from('site_setting');
		$query = $this->db->get();
		return $query->result();
	}

	public function getOutletWareHouse(array $default_store_id)
	{
		$this->db->select('s_id,s_name');
		$this->db->from('stores');
		$this->db->where_in('s_id',$default_store_id);
		$query = $this->db->get();
		return $query->result();
	}

	/*
	#############################################################
	# this existing function is modified by a3frt
	# data: 07-11-17 for fixing show the setting showrooms End
	#############################################################
	*/
	
	public function getgold_orders()
	{
		$this->db->limit(1);
		$this->db->order_by('gold_id', 'DESC');
        $query = $this->db->get('gold_orders');
		$number = !empty($query->row()->gold_id) ? $query->row()->gold_id : 0;
        return $number+1;
	}
	function getCategorySubcategory()
	{
		$this->db->select('*');
		$this->db->from('category');
		$this->db->join('sub_category',"sub_category.category_id_fk=category.id");
		$this->db->where('category.id',9);
		$result = $this->db->get();
		return $result->result();
	}
	
	
	public function getOutletWiseWarehouseProduct($outlet_id,$warehouse_id,$type)
	{
		$this->db->select('inventory.*,products.name as prdocuname,products.id as product_id ');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('ow_id',$warehouse_id);
		$this->db->where('type',$type);
		$this->db->group_by('inventory.product_code');
		$query = $this->db->get();
		return $query->result();
	}
	function select_all($table_name)
	{
		$this->db->select('*');
		$record = $this->db->get($table_name);
		return $record->result();
	}
	
	public function getDataInventoryWise($pcode,$outlet_id,$type,$WareHouse)
	{
		$this->db->select('inventory.*,products.NetGoldWeight, products.Wastagegold, products.TotalAllOtherCost,  products.grade_id,products.category,products.sub_category_id_fk,products.purchase_price,products.name as product_name,products.weight as product_weight,products.retail_price');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('product_code',$pcode);
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('type',$type);
		$this->db->where('ow_id',$WareHouse);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query;	
	}
	
	public function getProfileCalculationData($grade_id_product,$category, $sub_category)
	{
		$this->db->where('gold_grade_id',$grade_id_product);
		$this->db->where('category_id',$category);
		$this->db->where('sub_category_id',$sub_category);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get('profit_calculations');
		return $query->row();
	}


	public function getOutletWisePaymentMethod($id)
	{
		$this->db->where('outlet_id',$id);
		$this->db->order_by('id','asc');
		$query = $this->db->get('payment_method');
		return $query->result();
	}
}
