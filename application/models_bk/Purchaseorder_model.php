<?php
class Purchaseorder_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	public function getPurchaseReturn()
	{
		$this->db->select('users.fullname,purchase_return.*, payment_method.name as payment_method_name,suppliers.name as suppliers_name, outlets.name as outlets_name, products.name as product_name');	
		$this->db->from('purchase_return');	
		$this->db->join('outlets','outlets.id = purchase_return.outlet_id','left');	
		$this->db->join('products','products.code = purchase_return.product_code','left');	
		$this->db->join('suppliers','suppliers.id = purchase_return.supplier_id','left');	
		$this->db->join('payment_method','payment_method.id = purchase_return.payment_type','left');	
		$this->db->join('users','users.id = purchase_return.created_by','left');	
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(purchase_return.created_date,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(purchase_return.created_date,"%Y-%m-%d") <=', date('Y-m-d', strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getPurchaseTemporaryData()
	{
		$query = $this->db->get('temporary_purchase_order_items');
		return $query->result();
	}
	
	
	public function DeletePurchaseItemTemporary()
	{
		
		$this->db->query('delete from temporary_purchase_order_items');
		return true;
	}
	
	
	public function get_warehouse_outletwise($outlet_id)
	{
		$this->db->select('*');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','outlet_warehouse.w_id = stores.s_id');
		$this->db->where('outlet_warehouse.out_id',$outlet_id);
		$this->db->where('stores.s_status','1');
		$this->db->where('stores.bulk_status','1');
		$result = $this->db->get();
		return $result->result();
	}

	
	public function getallProduct()
	{
//		$this->db->where('product_type !=', 'bulk');
		$query = $this->db->get('products');
		return $query->result();
	}
	
	public function fetch_po_data()
    {
        $temp_outlet = $this->session->userdata('user_outlet');
        $temp_role = $this->session->userdata('user_role');
		$this->db->select('purchase_order.*,users.fullname,purchase_order_status.name as statusname');
		$this->db->from('purchase_order');
		$this->db->join('users','users.id = purchase_order.created_user_id','left');
		$this->db->join('purchase_order_status',' purchase_order_status.id = purchase_order.status','left');
        if ($temp_role > 1) 
		{
            $this->db->where('purchase_order.outlet_id', $temp_outlet);
        }
//		if(!empty($this->input->get('code')))
//		{
//			$this->db->where('purchase_order.po_number', $this->input->get('code'));
//		}
//		
//		if(!empty($this->input->get('outlet')))
//		{
//			$this->db->where('purchase_order.outlet_id', $this->input->get('outlet'));
//		}
//		
//		if(!empty($this->input->get('supplier')))
//		{
//			$this->db->where('purchase_order.supplier_id', $this->input->get('supplier'));
//		}
//		if(!empty($this->input->get('payment')))
//		{
//			$this->db->where('purchase_order.payment_method', $this->input->get('payment'));
//		}
		
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") <=', date('Y-m-d', strtotime($this->input->get('end_date'))));
		}
		if(!empty($this->input->get('p_status')))
		{
			$this->db->where('purchase_order.status', $this->input->get('p_status'));
		}
		$this->db->order_by('purchase_order.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function UpdateRaisepo($id)
	{
		$this->db->set('status', '5');
		$this->db->where('id', $id);
		$this->db->update('purchase_order');
        return true;
	}
	
	public function getSupplierData($supplierid)
	{
		$this->db->where('id', $supplierid);
		$this->db->limit(1);
		$query = $this->db->get('suppliers');
        return $query->row()->address;
	}
	
	public function UpdateMainPurchaseStatus($purchase_id,$purchase_bill_no)
	{
		$this->db->set('status',6);
		$this->db->set('purchase_bill_no',$purchase_bill_no);
		$this->db->where('id',$purchase_id);
		$this->db->update('purchase_order');
        return true;
	}
	
	public function getPurchaseOrderNumber()
	{
		$this->db->limit(1);
		$this->db->order_by('id', 'DESC');
        $query = $this->db->get('purchase_order');
		$number = !empty($query->row()->id) ? $query->row()->id : 0;
        return $number+1;
	}
	
	public function getOutletProduct($outlet_id)
	{
		$this->db->where('outlet_id_fk', $outlet_id);
		$this->db->where('status', 1);
        $query = $this->db->get('products');
        return $query->result();	
	}

	public function getOutletWiseAllProduct($outlet_id)
	{
		$this->db->select('inventory.*,products.name as prdocuname,products.id as product_id ');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('outlet_id',$outlet_id);
		$this->db->group_by('inventory.product_code');
		$query = $this->db->get();
		return $query->result();
	}

	
	public function FilterProduct($outlet_id,$warehouse_id,$warehouse_type,$product_code)
	{
		$this->db->select('inventory.*,products.purchase_price');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('inventory.product_code', $product_code);
		$this->db->where('inventory.outlet_id', $outlet_id);
		$this->db->where('inventory.ow_id', $warehouse_id);
		$this->db->where('inventory.type', $warehouse_type);
        $query = $this->db->get();
        return $query;	
	}
	
	public function FilterProductNew($outlet_id,$warehouse_id,$warehouse_type,$product_code)
	{
		$this->db->select('inventory.*, sum(inventory.qty) as qty, products.purchase_price');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('inventory.product_code', $product_code);
		$this->db->where('inventory.outlet_id', $outlet_id);
//		$this->db->where('inventory.ow_id', $warehouse_id);
//		$this->db->where('inventory.type', $warehouse_type);
		$this->db->group_by('product_code');
        $query = $this->db->get();
        return $query;	
	}
	
	public function getPurchaseDetail($id)
	{
		$this->db->select('purchase_order.*,purchase_order_status.name as statusname');
		$this->db->from('purchase_order');
		$this->db->join('purchase_order_status','purchase_order_status.id = purchase_order.status','left');
		$this->db->where('purchase_order.id',$id);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getPurchaseItem($id)
	{
		$this->db->select('purchase_order_items.*,(SELECT SUM(inventory.qty) FROM inventory WHERE inventory.product_code = purchase_order_items.product_code ) as instock,products.name,products.purchase_price');
		$this->db->from('purchase_order_items');
//		$this->db->join('inventory','inventory.product_code = purchase_order_items.product_code','left');
		$this->db->join('products','products.code			= purchase_order_items.product_code','left');
		$this->db->where('purchase_order_items.po_id',$id);
		$query = $this->db->get();
//		print_r($this->db->last_query());
//		die;
		return $query->result();
	}
	
	public function data_purchaseUpdate($data_purchase,$productid)
	{
		$this->db->where('id',$productid);
		$this->db->update('purchase_order_items',$data_purchase);
		return true;
	}
	
	public function mainidpurchaseid_Update($mainidpurchaseid_update,$mainidpurchaseid)
	{
		$this->db->where('id',$mainidpurchaseid);
		$this->db->update('purchase_order',$mainidpurchaseid_update);
		return true;
	}

	public function data_inventoryUpdate($data_inventory,$inventory_id)
	{
		$this->db->where('id',$inventory_id);
		$this->db->update("inventory",$data_inventory);
		return true;
	}
	
	public function WareHouseTank($inventory_id)
	{
		$this->db->where('id',$inventory_id);
		$query  = $this->db->get("inventory");
		return $query->row();
	}
	
	public function CheckInventory($ow_id,$outlet_id,$type,$product_code)
	{
		$this->db->where('product_code',$product_code);
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('ow_id',$ow_id);
		$this->db->where('type',$type);
		$query = $this->db->get('inventory');
		return $query;
	}
	
	public function getPurchasePrice($product_id)
	{
		$this->db->where('code',$product_id);
		$this->db->limit(1);
		$query = $this->db->get('products');
		return $query->row();
	}
	
	public function getStoreInventory($storeid)
	{
		$this->db->where('s_id',$storeid);
		$query = $this->db->get('stores');
		return $query->row()->s_stock;
	}
	
	public function UpdatePurchaseItemStatus($purchaseid)
	{
		$this->db->set('warehouse_tank_status',1);
		$this->db->where('id',$purchaseid);
		$this->db->update('purchase_order_items');
		return true;
	}
	
	public function purchase_bill_data()
	{
		$this->db->select('purchase_bills.*,purchase_order.po_number');
		$this->db->from('purchase_bills');
		$this->db->join('purchase_order','purchase_order.id = purchase_bills.purchase_id','left');
		$this->db->order_by('paid_date','DESC');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function purchase_Item_data($purchase_id)
	{
		$this->db->select('purchase_order_items.*,products.name as productname');
		$this->db->from('purchase_order_items');
		$this->db->join('products','products.code = purchase_order_items.product_code','left');
		$this->db->where('purchase_order_items.po_id',$purchase_id);
		$query = $this->db->get();
		return $query->result();
	}

	public function UpdatePurchaseItemStatusPartial($purchaseid,$qty)
	{
		$this->db->where('id',$purchaseid);
		$query = $this->db->get('purchase_order_items');
		$partail_qty = $query->row()->partail_qty;
		$finalpartail_qty = $partail_qty + $qty;
		$update = array ('partail_qty' =>$finalpartail_qty,
				'warehouse_tank_status_partial' => 1
			);
		$upq = $this->db->where('id',$purchaseid);
		$upq = $this->db->update('purchase_order_items',$update);
		return true;
	}
	
	public function getCategoryWareHouseTank($product_code)
	{
		$this->db->where('code',$product_code);
		$this->db->limit(1);
		$query = $this->db->get('products');
		return $query->row();
	}

    public function fetch_debit_data()
    {
		$this->db->select('purchase_order.*,(SELECT SUM(ordered_qty) FROM purchase_order_items WHERE purchase_order_items.po_id = purchase_order.id ) as totalitem');
		$this->db->from('purchase_order');
	    $this->db->where('(purchase_order.status=5 OR purchase_order.status=6)');
		
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		if(!empty($this->input->get('search_name')))
		{
			$this->db->where('purchase_order.supplier_name', $this->input->get('search_name'));
		}
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function getReceivedStoreTank($id)
	{
		$html = '';
		$this->db->select('stores.s_name');
		$this->db->from('purchase_received');
		$this->db->join('outlet_warehouse','outlet_warehouse.ow_id = purchase_received.tank_id');
		$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
		$this->db->where('purchase_id',$id);
		$this->db->where('type',0);
		$query = $this->db->get();
		foreach ($query->result() as $store)
		{
			$html.= $store->s_name.',';
		}
		return trim($html,",");
	}
	
	public function DistributedPurchaseDetail($id)
	{
		$this->db->select('purchase_received.*,outlets.name as outletname');
		$this->db->from('purchase_received');
		$this->db->join('outlets','outlets.id = purchase_received.outlet_id','left');
		$this->db->where('purchase_received.purchase_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function DistributedPurchaseWareHouse($id)
	{
		$this->db->select('stores.s_name');
		$this->db->from('purchase_received');
		$this->db->join('outlet_warehouse','outlet_warehouse.ow_id = purchase_received.tank_id');
		$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
		$this->db->where('purchase_received.id',$id);
		$query = $this->db->get();
		return $query->row()->s_name;
	}
	
	public function DistributedPurchaseTank($id)
	{
		$this->db->select('fuel_tanks.fuel_tank_number');
		$this->db->from('purchase_received');
		$this->db->join('fuel_tanks','fuel_tanks.id = purchase_received.tank_id');
		$this->db->where('purchase_received.id',$id);
		$query = $this->db->get();
		return $query->row()->fuel_tank_number;
	}
	
	public function PaymentPurchaseDetail($id)
	{
		$this->db->select('*');
		$this->db->from('purchase_bills');
		$this->db->where('purchase_id',$id);
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->result(); 
	}
	
}
