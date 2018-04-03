<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function record_category_count()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('category');
        $this->db->save_queries = false;
        return $query->num_rows();
    }

	
	public function CheckSupplierEmail($suppliername)
	{
		$this->db->select('*');
		$this->db->from('suppliers');
		$this->db->where('email',$suppliername);
		$this->db->limit(1);
		$result = $this->db->get();
		return $result;
	}
	
	public function CheckBrandName($brand)
	{
		$this->db->select('*');
		$this->db->from('brand');
		$this->db->where('brand',$brand);
		$this->db->limit(1);
		$result = $this->db->get();
		return $result;
	}
	
	
	
	public function InsertSupplier($array_supplier)
	{
		$this->db->insert('suppliers',$array_supplier);
		return  $this->db->insert_id();
	}
	
	public function InsertBrand($array_brand)
	{
		$this->db->insert('brand',$array_brand);
		return  $this->db->insert_id();
	}
	
	public function CheckProductCode($product_code)
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('code',$product_code);
		$result = $this->db->get();
		return $result->num_rows();
	}
	
	public function get_warehouse_outletwise($outlet_id)
	{
		$this->db->select('*');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','outlet_warehouse.w_id = stores.s_id');
		$this->db->where('outlet_warehouse.out_id',$outlet_id);
		$this->db->where('stores.s_status','1');
		$this->db->where('stores.bulk_status','0');
		$result = $this->db->get();
		return $result->result();
	}
	
	public function get_warehouse_outletwise_store($outlet_id)
	{
		$this->db->select('*');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','outlet_warehouse.w_id = stores.s_id');
		$this->db->where('outlet_warehouse.out_id',$outlet_id);
		$this->db->where('stores.s_status','1');
		$this->db->where('stores.bulk_status','1');
		$result = $this->db->get();
		return $result;
	}
	
	
	public function getDefaultStore()
	{
		$this->db->select('*');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','outlet_warehouse.w_id = stores.s_id');
		$this->db->where('outlet_warehouse.ow_id',1);
		$this->db->limit(1);
		$result = $this->db->get();
		return $result->row();
	}
	
	public function get_tank_outletwise($outlet_id)
	{
		$this->db->select('*');
		$this->db->from('fuel_tanks');
		$this->db->where('outlet_id',$outlet_id);
		$result = $this->db->get();
		return $result->result();
	}
	
    public function fetch_category_data($limit, $start)
    {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('category');

        $result = $query->result();

        $this->db->save_queries = false;

        return $result;
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
        $this->db->select('products.*,category.name as categoryname');
        $this->db->from('products');
        $this->db->join('category','category.id = products.category');
		if(!empty($this->input->get('category')))
		{
			$this->db->where('category.id',$this->input->get('category'));
		}
        $this->db->order_by('products.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function getEditProduct($id)
	{
		$this->db->where('id',$id);
		$this->db->limit('1');
        $query = $this->db->get('products');	
		return $query->row();
	}
	
	public function OutletWiseInvenotyWarehouse($code,$outletid)
	{
		$this->db->select('inventory.*,stores.s_name');
        $this->db->from('inventory');
		$this->db->join('outlet_warehouse','outlet_warehouse.ow_id = inventory.ow_id');
		$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
        $this->db->where('inventory.product_code',$code);
        $this->db->where('inventory.outlet_id',$outletid);
        $query = $this->db->get();	
		return $query->result();
	}
	

    public function record_label_count()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('products');
        $this->db->save_queries = false;
	    return $query->num_rows();
    }

    public function fetch_label_data($limit, $start)
    {
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('products');
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }
	
	public function UpdateReorderNotification($notify)
	{
		$this->db->set('notification', 1);	
		$this->db->where('id', $notify);	
		$this->db->update('products');	
		return true;
	}
	
	public function getReorderDetail()
	{
		$this->db->select('suppliers.name as suppliers_name,products.*, (SELECT SUM(qty) FROM inventory WHERE inventory.product_code = products.code) as qty, outlets.name as outletname,category.name as categoryname,sub_category.sub_category ');
		$this->db->from('products');
		$this->db->join('outlets','outlets.id = products.outlet_id_fk','left');
		$this->db->join('category','category.id = products.category','left');
		$this->db->join('sub_category','sub_category.id = products.sub_category_id_fk','left');
		$this->db->join('suppliers','suppliers.id = products.supplier_id_fk','left');
		$this->db->where('products.status',1);
		$this->db->where('products.alt_qty !=',0);
		if(!empty($this->input->get('notify')))
		{
			$this->db->where('products.id',$this->input->get('notify'));
		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$query  = $this->db->get();
		return $query->result();
	}
	public function getReorderPrint($id)
	{
		$this->db->select('suppliers.name as suppliers_name,products.*, (SELECT SUM(qty) FROM inventory WHERE inventory.product_code = products.code) as qty, outlets.name as outletname,category.name as categoryname,sub_category.sub_category ');
		$this->db->from('products');
		$this->db->join('outlets','outlets.id = products.outlet_id_fk','left');
		$this->db->join('category','category.id = products.category','left');
		$this->db->join('sub_category','sub_category.id = products.sub_category_id_fk','left');
		$this->db->join('suppliers','suppliers.id = products.supplier_id_fk','left');
		$this->db->where('products.id',$id);
		$this->db->limit(1);
		$query  = $this->db->get();
		return $query->row();
	}
	
	public function getExpireDetail()
	{
		$this->db->select('outlets.name as outletname,products.category, inventory.ow_id, products.name as product_name, products.generic_name,inventory.product_code,batch_expire_multi.expirydate,batch_expire_multi.batch_no');
		$this->db->from('inventory');
		$this->db->join('batch_expire_multi','batch_expire_multi.inventory_id = inventory.id');
		$this->db->join('products','products.code = inventory.product_code','left');
		$this->db->join('outlets','outlets.id = inventory.outlet_id','left');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getLastSupplier($code)
	{
		$this->db->select('purchase_order.supplier_name');
		$this->db->from('purchase_order_items');
		$this->db->join('purchase_order','purchase_order.id = purchase_order_items.po_id');
		$this->db->where('purchase_order_items.product_code','Product1');
		$this->db->order_by('purchase_order_items.id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return !empty($query->row()->supplier_name)?$query->row()->supplier_name:'';
	}
}
