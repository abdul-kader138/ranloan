<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function record_product_count()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('products');
        $this->db->save_queries = false;
        return $query->num_rows();
    }

    public function fetch_product_data()
    {
		$this->db->select('products.start_qty as product_qty,products.product_type,products.outlet_id_fk,products.grade_id,products.NetGoldWeight, products.Wastagegold, products.id,products.TransferredCost,products.product_add_from, products.TotalAllOtherCost, category.name as category_name, sub_category.sub_category, products.category, sum(inventory.qty) as qty, inventory.gold_weight,inventory.type as inventorytype, group_concat(inventory.ow_id) as ow_id, products.code, products.name, products.purchase_price, products.weight, outlets.name as outletname,gold_grade.grade_name,gold_grade.gold_purity');
		$this->db->from('products');
		$this->db->join('category','products.category = category.id','left');
		$this->db->join('sub_category','sub_category.id = products.sub_category_id_fk','left');
		$this->db->join('inventory','inventory.product_code = products.code','left');
		$this->db->join('outlets','outlets.id = products.outlet_id_fk','left');
		$this->db->join('gold_grade','gold_grade.grade_id = products.grade_id','left');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		if(!empty($this->input->get('subcategory')))
		{
			$this->db->where('products.sub_category_id_fk =',$this->input->get('subcategory'));
		}
		$this->db->group_by('products.code');
		$query = $this->db->get();
		return $query->result();
    }

    public function getOutletsForInventory()
	{
		$queryoutlet = $this->db->get_where('users', array('id' => $this->session->userdata('user_id')))->row();
		if(!empty($queryoutlet))
		{
			if($queryoutlet->outlet_id > 0)
			{
				$this->db->select('id,name')->where('id',$queryoutlet->outlet_id);
			}
		}
		$query = $this->db->get('outlets');
		return $query->result();
	}
	
	
	public function getConcateStore($outlet_id, $product_code, $ow_id)
	{
		$this->db->select('stores.s_name');
		$this->db->from('inventory');
		$this->db->join('outlet_warehouse','outlet_warehouse.ow_id = inventory.ow_id');
		$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
		$this->db->where('inventory.outlet_id',$outlet_id);
		$this->db->where('inventory.product_code',$product_code);
		$this->db->where_in('inventory.ow_id',explode(",", $ow_id));
		$this->db->where('inventory.qty !=', 0);
		$query = $this->db->get();
		$html = '';
		
		foreach ($query->result() as $store)
		{
			$html.= $store->s_name.',';
		}
		return trim($html,",");
	}
	
	
	
	
	public function getInventoryDetail($product_code)
	{
		$this->db->select('inventory.*,stores.s_name as s_name');
		$this->db->from('inventory');
		$this->db->join('outlet_warehouse','outlet_warehouse.ow_id = inventory.ow_id');
		$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
		$this->db->where('inventory.product_code',$product_code);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function updateInventoryAjax($inventory_id,$finalupdate_qty)
	{
		$this->db->set('qty',$finalupdate_qty);
		$this->db->where('id',$inventory_id);
		$this->db->update('inventory');
		return true;
	}	
	
	public function getInventoryChange()
	{
		$this->db->select('inventory_changes.*,users.fullname,products.name as productname,outlets.name as outletname,category.name as categoryname,sub_category.sub_category');
		$this->db->from('inventory_changes');
		$this->db->join('products','products.code = inventory_changes.product_code','left');
		$this->db->join('outlets','outlets.id = inventory_changes.outlet_id','left');
		$this->db->join('category','category.id = products.category','left');
		$this->db->join('sub_category','sub_category.id = products.sub_category_id_fk','left');
		$this->db->join('users','users.id = inventory_changes.created_by','left');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(inventory_changes.created_date,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(inventory_changes.created_date,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
	}
	
}
