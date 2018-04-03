<?php
class Pos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	
	public function getInvoiceNumber()
	{
		$this->db->limit(1);
		$this->db->order_by('id','desc');
		$query = $this->db->get('orders');
		$number = !empty($query->row()->id) ? $query->row()->id : 0;
		return $number+1;
	}
	
	public function getOutletWiseWarehouseProduct($outlet_id,$warehouse_id)
	{
		$this->db->select('inventory.*,products.name as prdocuname,products.id as product_id ');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('ow_id',$warehouse_id);
		$this->db->group_by('inventory.product_code');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function LoginUser()
	{
		$this->db->limit(1);
		$this->db->where('id',$this->session->userdata('user_id'));
		$query = $this->db->get('users');
		return !empty($query->row()->fullname)?$query->row()->fullname:'';
	}
	
	public function getDataInventoryWise($pcode,$outlet_id,$WareHouse)
	{
		$this->db->select('inventory.*,products.purchase_price,products.name as product_name,products.retail_price');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('product_code',$pcode);
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('ow_id',$WareHouse);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query;	
	}
	
	public function getCustomer()
	{
		$query = $this->db->get('customers');
		return $query->result();	
	}
	
	public function getPaymentMethod()
	{
		$query = $this->db->get('payment_method');
		return $query->result();	
	}
	
	public function getMainSuspend($suspend_id)
	{
		$this->db->where('id',$suspend_id);
		$this->db->where('status','0');
		$query = $this->db->get('suspend');
		return $query->row();	
	}
	
	public function getItemSuspend($suspend_id)
	{
		$this->db->where('suspend_id',$suspend_id);
		$query = $this->db->get('suspend_items');
		return $query->result();	
	}
	
	public function RemoveSuspend($suspend_id)
	{
		$main = $this->db->where('id',$suspend_id);
		$main = $this->db->delete('suspend');
		
		$item = $this->db->where('suspend_id',$suspend_id);
		$item = $this->db->delete('suspend_items');
		return true;
	}
			
	public function getDefaultCustomer()
	{
		$this->db->where('id','1');
		$this->db->limit(1);
		$query = $this->db->get('site_setting');
		return $query->row(); 
	}
	
	public function getAllProduct()
	{
		$this->db->where('status',1);
		$query = $this->db->get('products');
		return $query->result();
	}
	
	public function getUserRoll()
	{
		$this->db->where('id',$this->session->userdata('user_id'));
		$this->db->limit(1);
		$query = $this->db->get('users');
		return $query->row(); 
	}
	
	public function UserOutlet($outlet_id)
	{
		
		$this->db->where('id',$outlet_id);
		$this->db->limit(1);
		$query = $this->db->get('outlets');
		return !empty($query->row()->name)?$query->row()->name:''; 
	}
	
	
	
	
	
	

	
	public function getProductOutletWise($outlet)
	{
		$this->db->where('outlet_id_fk',$outlet);
		$this->db->where('status',1);
		$query = $this->db->get('products');
		return $query->result();	
	}
	
	public function getDataTwoColumnOutletWise($category_id,$outlet)
	{
		$this->db->where('category',$category_id);
		$this->db->where('outlet_id_fk',$outlet);
		$this->db->where('status',1);
		$query = $this->db->get('products');
		return $query->result();	
	}
	
	public function getDataInventory($pcode,$outlet_id,$type,$WareHouse)
	{
		$this->db->where('product_code',$pcode);
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('type',$type);
		$this->db->where('ow_id',$WareHouse);
		$this->db->limit(1);
		$query = $this->db->get('inventory');
		return $query->result();	
	}
	
	
	
}
