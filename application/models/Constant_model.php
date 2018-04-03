<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Constant_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	public function getCreditColor()
	{
		$query = $this->db->get('credit_colours');
		return $query->result();
	}
	
	public function getGoldGrade()
	{
		$query = $this->db->get('gold_grade');
		return $query->result();
	}

	public function getSingleGoldGrade($gradeval_id)
	{	
		$this->db->where('grade_id',$gradeval_id);
		$this->db->limit(1);
		$query = $this->db->get('gold_grade');
		return $query->row();
	}
	
	public function getBulkStoreCount()
	{
		$this->db->where('bulk_status',1);
		$query = $this->db->get('stores');
		return $query->num_rows();
	}
	
	public function getSingleGoldGradePrice($grade_id)
	{
		$this->db->where('gp_grade',$grade_id);
		$this->db->order_by('gp_id','desc');
		$this->db->limit(1);
		$query = $this->db->get('gold_prices');
		return $query->row();
	}
	
	public function getLastGoldGradePrice()
	{
		$this->db->order_by('gp_id','desc');
		$this->db->limit(1);
		$query = $this->db->get('gold_prices');
		return $query->row();
	}
	
	
	
	public function UpdateProductCodeNumber($code_num_array, $product_code_id)
	{
		$this->db->where('id',$product_code_id);
		$this->db->update('product_code_numbering',$code_num_array);
		return TRUE;
	}
			
	public function getInventorydata($bulk_product_item)
	{
		$this->db->where('product_code',$bulk_product_item);
		$this->db->limit(1);
		$query = $this->db->get('inventory');
		return $query->row();
	}

	public function changeReconcile($id,$value)
	{
		$this->db->where('id',$id);
		$this->db->set('reconcile',$value);
		$this->db->update('transactions');
		return true;
	}
	
	
	public function GetPurchaseItemData($purchaseid)
	{
		$this->db->where('id',$purchaseid);
		$this->db->limit(1);
		$query = $this->db->get('purchase_order_items');
		return $query->row();
	}

	function gold_gold_purity($grade_name = null)
	{
		$this->db->select("grade_id,gold_purity");
		$this->db->where('grade_name',$grade_name);
		$this->db->limit(1);
		$query = $this->db->get('gold_grade');
		return $query->result();
	}
	



	public function getpumpSettlementData($settelment_no,$pumpid)
	{
		$this->db->where("settlement_id",$settelment_no);
		$this->db->where("pump_id",$pumpid);
		$this->db->where("type",1);
		$query = $this->db->get('temporary_order_items');
		return $query;
	}
	
	public function getSigleProductDetail($pcode)
	{
		$this->db->select("products.*,category.name as categoryname");
		$this->db->from("products");
		$this->db->join("category",'category.id = products.category','left');
		$this->db->where('products.code',$pcode);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getPrepayData()
	{
		$this->db->select("prepay.*, payment_method.name as payment_name, outlets.name as outletname, customers.fullname");
		$this->db->from("prepay");
		$this->db->join("customers",'customers.id = prepay.customer_id','left');
		$this->db->join("outlets",'outlets.id = prepay.outlet_id','left');
		$this->db->join("payment_method",'payment_method.id = prepay.payment_method','left');
		$query = $this->db->get();
		return $query->result();
		
	}
	
	
	
	public function Delete_Temporary_Payment($temporary_id)
	{
		$this->db->where("id",$temporary_id);
		$this->db->delete('temporary_payment_method');
		return true;
	}
	
	
	public function RemoveTemparyPayment($settlement_no)
	{
		$this->db->where("settlement_no",$settlement_no);
		$this->db->delete('temporary_payment_method');
		return true;
	}
	
	public function getAllreadySettlement()
	{
		$this->db->where("status",2);
		$query = $this->db->get('settlement');
		return $query;
	}
	
	
	
	public function CheckSettlementNumber($settelment_no)
	{
		$this->db->where('settlement_no',$settelment_no);
		$this->db->limit(1);
		$query = $this->db->get('settlement');
		return $query;
	}
	
	
	public function UpdateSettlementNumber($update_settlement,$settelment_no)
	{
		$this->db->where('settlement_no',$settelment_no);
		$this->db->update('settlement',$update_settlement);
		return true;
	}
	
	public function DeleteTemporaryItem($item_id)
	{
		$this->db->where("id",$item_id);
		$this->db->delete('temporary_order_items');
		return true;
	}
	
	public function RemoveTemporaryItem($settelment_no)
	{
		$this->db->where("settlement_id",$settelment_no);
		$this->db->delete('temporary_order_items');
		return true;
	}
	
	public function getProductPrice($product_code)
	{
		$this->db->where("code",$product_code);
		$query = $this->db->get('products');
		return $query->row();
	}
	
	
	public function getPaymentTemporyData($settle_id)
	{
		$this->db->select("temporary_payment_method.*,payment_method.name as paymentname,customers.fullname,pump_operators.operator_name,customers.credit_amount");
		$this->db->from("temporary_payment_method");
		$this->db->join("payment_method",'payment_method.id = temporary_payment_method.payment_type','left');
		$this->db->join("customers",'customers.id = temporary_payment_method.customer_id','left');
		$this->db->join("pump_operators",'pump_operators.id = temporary_payment_method.pumper_id','left');
		$this->db->where("temporary_payment_method.settlement_no",$settle_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	
	
	
	public function getOrderDataSettlement($settlement_no)
	{
		$this->db->where('settlement_no', $settlement_no);
		$this->db->limit(1);
		$query = $this->db->get('orders');
		return $query->row();
	}
	
	public function getPumpSignleRecord($pump_no)
	{
		$this->db->where('id', $pump_no);
		$query = $this->db->get('pumps');
		return $query->row();
	}
	
	
	public function UpdatePumpSignleRecord($update_metter,$pump_no)
	{
		$this->db->where('id', $pump_no);
		$this->db->update('pumps',$update_metter);
		return true;
	}
	
	
	public function getPermissionPageWise($permisssion_url)
	{
		$user_id = $this->session->userdata('user_id');
		$this->db->select('permissions.*,resources.name');
		$this->db->from('permissions');
		$this->db->join('resources','resources.id = permissions.resource_id');
		$this->db->where('resources.name',$permisssion_url);
		$this->db->where('permissions.user_id',$user_id);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	public function getPermissionSubPageWise($permission_re_id,$permisssion_sub_url)
	{
		$user_id = $this->session->userdata('user_id');
		$this->db->select('permissions.*,resources.name');
		$this->db->from('permissions');
		$this->db->join('resources','resources.id = permissions.resource_id');
		$this->db->where('resources.name',$permisssion_sub_url);
        $this->db->where('resources.pid',$permission_re_id);
		$this->db->where('permissions.user_id',$user_id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	public function getOutletsUseriwse()
	{
		$this->db->where('status','1');
		if ($this->session->userdata('user_role') == 1) 
		{
			$query = $this->db->get('outlets');
			return $query->result();
		} 
		else 
		{
			$this->db->where('id',$this->session->userdata('user_role'));
			$query = $this->db->get('outlets');
			return $query->result();
		}
	}
	
	public function UpdateResettingMeter($update,$pump_id)
	{
		$this->db->where('id',$pump_id);
		$this->db->update('pumps',$update);
		return true;
	}
	
	public function getPaymentTypeGroup()
	{
		$this->db->group_by('name');
		$this->db->where('name !=', '');
		$this->db->where('outlet_id !=', '');
		$query = $this->db->get('payment_method');
		return $query->result();
	}
	
	public function getSpecificPaymentID($outlet,$name)
	{
		$this->db->where('name',$name);
		$this->db->where('outlet_id',$outlet);
		$this->db->limit(1);
		$query = $this->db->get('payment_method');
		return $query->row()->id;
	}

	
	public function getMainMoule()
	{
		$this->db->where('pid','0');
		$query = $this->db->get('modules');
		return $query->result();	
	}
	
	public function getOutletProduct($outlet_id)
	{
		$this->db->where('status',1);
		$this->db->where('outlet_id_fk',$outlet_id);
		$query = $this->db->get('products');
		return $query->result();	
	}
	
	public function getCustomerGroup()
	{
		$query = $this->db->get('customer_group');
		return $query->result();	
	}
	
	public function getSalesReturnID()
	{
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get('sales_return');
		return !empty($query->row()->id) ? $query->row()->id : 1;	
	}
	
	
	public function getProductSingle($code)
	{
		$this->db->where('code',$code);
		$this->db->limit(1);
		$query = $this->db->get('products');
		return $query->row();
	}
	
	public function OutletWarehouseget($ow_id)
	{
		$this->db->select('outlet_warehouse.*,stores.s_id as store_id, stores.s_stock');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
		$this->db->where('outlet_warehouse.ow_id',$ow_id);
		$query = $this->db->get();
		return $query->row();	
	}
	
	public function reduce_inventory($inventory_id,$data_reduce_inventory)
	{
		$this->db->where('id',$inventory_id);
		$query = $this->db->update('inventory',$data_reduce_inventory);
		return true;
	}
	
	public function CheckInventoryQty($id)
	{
		$this->db->where('product_code',$id);
		$this->db->where('qty !=', 0);
		$this->db->limit(1);
		$query = $this->db->get('inventory');
		return $query->num_rows();
	}
	
	
	
	
	
	public  function getOutletAssignStore()
	{
		$this->db->select('stores.s_id as store_id, stores.s_name');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
		$this->db->group_by('outlet_warehouse.w_id');
		$query = $this->db->get();
		return $query->result();	
	}

	public function UpdateStoreInventory($data_storeupdate, $store_id)
	{
		$this->db->where('s_id',$store_id);
		$query = $this->db->update('stores',$data_storeupdate);
		return true;
	}
	public function getProductWareHouse()
	{
		$this->db->where('product_type !=', 'bulk');
		$query = $this->db->get('products');
		return $query->result();
	}
			
	public function getCategorySubcategoryProduct($category,$sub_category)
	{
		$this->db->where('category',$category);
		$this->db->where('sub_category_id_fk',$sub_category);
		$this->db->where('product_type','bulk');
		$query = $this->db->get('products');
		return $query->result();
	}
	
	public function getCategorySubcategoryProductTransfer($category,$sub_category)
	{
		$this->db->where('category',$category);
		$this->db->where('sub_category_id_fk',$sub_category);
		$this->db->where('product_type','bulk');
		$query = $this->db->get('products');
		// echo $this->db->last_query(); exit();
		return $query;
	}
	
	

	public function getMainOrderDetail($id)
	{
		$this->db->select('orders.*,pump_operators.operator_name');
		$this->db->from('orders');
		$this->db->join('pump_operators','pump_operators.id = orders.pump_operators_id','left');
		$this->db->where('orders.id',$id);
		$query = $this->db->get();
		return $query->row();
	}

		
	public function getBrand()
	{
		$this->db->where('status','0');
		$query = $this->db->get('brand');
		return $query->result();
	}
	
	public function getSubCategory()
	{
		$this->db->select('id,sub_category,category_id_fk');
		$this->db->where('status','0');
		$query = $this->db->get('sub_category');
		return $query->result();
	}
	
	public function getSubCategoryFilter($category_id)
	{
		$this->db->where('status','0');
		$this->db->where('category_id_fk',$category_id);
		$query = $this->db->get('sub_category');
		return $query->result();
	}
	
	public function getPaymentDetail($id)
	{
		$this->db->where('order_id',$id);
		$query = $this->db->get('orders_payment');
		return $query->result();
	}
	
	public function getPaymentIDName($paid_by)
	{
		$this->db->where('id',$paid_by);
		$query = $this->db->get('payment_method');
		return $query->row();
	}
	public function GetOutletDetail($outlet_id)
	{
		$this->db->where('id',$outlet_id);
		$query = $this->db->get('outlets');
		return $query->row();
	}
	
	public function getSuppliersSingle($supplier)
	{
		$this->db->where('id',$supplier);
		$query = $this->db->get('suppliers');
		return $query->row();
	}
	
	public function StoreSingleData($ow_id)
	{
		$this->db->select('outlet_warehouse.*,stores.s_name');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','outlet_warehouse.w_id  = stores.s_id');
		$this->db->where('outlet_warehouse.ow_id',$ow_id);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	
	public function getOutletWareHouse($id)
	{
		$this->db->select('outlet_warehouse.*,stores.s_name');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','outlet_warehouse.w_id  = stores.s_id');
		$this->db->where('outlet_warehouse.out_id',$id);
		$this->db->where('stores.s_status','1');
		$this->db->where('stores.bulk_status','0');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function getpayment_mehtd_name($id)
	{
		$this->db->where('outlet_id',$id);
		$this->db->order_by('id','asc');
		$query = $this->db->get('payment_method');
		return $query->result();
	}
	

	
	public function getDataThreeColumnInventory($pcode,$outlet_id,$outlet_warehouse_id)
	{
	    $this->db->where("product_code", $pcode);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("ow_id", $outlet_warehouse_id);
        $this->db->where("type", '0');
        $query = $this->db->get("inventory");
        $result = $query->result();
		return $result;
	}
	
	public function CheckInventoryByTank($ppcode,$outlet_id,$fuel_tank_ids,$type)
	{
		$this->db->where("product_code", $ppcode);
        $this->db->where("outlet_id", $outlet_id);
        $this->db->where("ow_id", $fuel_tank_ids);
        $this->db->where("type", $type);
        $this->db->limit(1);
        $query = $this->db->get("inventory");
		return $query;
	}

	public function getDataAllFualCategory()
	{
		$this->db->where('category','20');
		$query = $this->db->get('products');
		return $query->result();
	}
	
	public function getSingleProduct($product_id)
	{
		$this->db->where('id',$product_id);
		$query = $this->db->get('products');
		return $query->row();
	}
	
	public function InventoryUpdateOtherSales($product_code,$outlet_id,$outlet_warehouse_id_data,$qtyone)
	{
		$query = $this->db->where('product_code',$product_code);
		$query = $this->db->where('outlet_id',$outlet_id);
		$query = $this->db->where('ow_id',$outlet_warehouse_id_data);
		$query = $this->db->where('type','0');
		$query = $this->db->limit('1');
		$query = $this->db->get('inventory');
		$inventory_qty = $query->row()->qty;
		$remaining_qty = $inventory_qty - $qtyone;
		
		$update = $this->db->where('product_code',$product_code);
		$update = $this->db->where('outlet_id',$outlet_id);
		$update = $this->db->where('ow_id',$outlet_warehouse_id_data);
		$update = $this->db->where('type','0');
		$update = $this->db->set('qty',$remaining_qty);
		$update = $this->db->update('inventory');
		return true;
	}
	
	public function getWarehouseandOuletWiseProduct($outlet_id,$warehouse_id)
	{
		$this->db->select('inventory.*,products.name as prdocuname,products.id as product_id ');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('ow_id',$warehouse_id);
		$this->db->where('type','0');
		$this->db->group_by('inventory.product_code');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getOutletWiseTankWarehouseProduct($outlet_id,$warehouse_tank,$type)
	{
		$this->db->select('inventory.*,products.name as prdocuname,products.id as product_id ');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('ow_id',$warehouse_tank);
		$this->db->where('type',$type);
		$this->db->group_by('inventory.product_code');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function getSettleMentNumber()
	{
		$query = $this->db->order_by('id','desc');
		$query = $this->db->limit('1');
		$query = $this->db->get('settlement');
		$ids = !empty($query->row()->id) ? $query->row()->id : '';
		return $ids + 1;	
	}
		
	
	public function	getPumpOperatorAll()
	{
		$query = $this->db->get('pump_operators');
		return $query->result();
	}
	
	public function getProductOtherSale()
	{
		$query = $this->db->query("SELECT * FROM products WHERE category = 21");
		return $query->result();
		
	}
			
	public function getDailySummaryReport($outlet)
	{
		$today = date('Y-m-d');
		$this->db->select('sum(gold_orders.gold_grandtotal) as totalsale,sum(gold_orders.gold_total_qty_item) as totalqty');
		$this->db->from('gold_orders');
		$this->db->where('gold_outlet_id',$outlet);
		if(!empty($this->input->get('start_date')) )
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d")',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d")',$today);
		}
//		$this->db->where('gold_orders.status',0);
		$query = $this->db->get();
		return $query->row();
		
		
	}
	
	public function getDailySummaryReportCash($outlet,$paymentid)
	{
		$today = date('Y-m-d');
		$this->db->select('sum(grandtotal) as paymentamount');
		$this->db->from('gold_orders_payment');
		$this->db->where('outlet_id',$outlet);
		$this->db->where('payment_method',$paymentid);
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d")',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else 
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d")',$today);
		}
//		$this->db->where('orders_payment.status',0);
//		$this->db->where('orders_payment.customer_note !=','outstanding');
		$query = $this->db->get();
		return $query->row();
	}
	
	public function UpdateProductPrice($product_id,$new_price)
	{
		$this->db->set('purchase_price',$new_price);
		$this->db->where('code',$product_id);
		$this->db->update('products');
		return true;
	}
	
	public function BFOutstanding()
	{
		$yesterday = date('Y-m-d',strtotime("-1 days"));
		$this->db->select('sum(unpaid_amt) as unpaid_amount');
		$this->db->from('gold_orders_payment');
		if(!empty($this->input->get('start_date')) )
		{
			
			$openingtoday = date('Y-m-d',strtotime($this->input->get('start_date')));
			$openingdate = date('Y-m-d', strtotime('-1 day', strtotime($openingtoday)));
			
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d")', $openingdate);
			
//			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d")',$yesterday);
		}
//		$this->db->where('gold_orders_payment.status',0);
		$this->db->where_in('payment_method_name',array('Vouchers','Debit / Credit Sales'));
		$query = $this->db->get();
		return !empty($query->row()->unpaid_amount) ? $query->row()->unpaid_amount : 0.00;
	}
	
	public function TodayOutstanding()
	{
		$today = date('Y-m-d');
		$this->db->select('sum(unpaid_amt) as unpaid_amount');
		$this->db->from('gold_orders_payment');
		if(!empty($this->input->get('start_date')) )
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d")',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else 
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d")',$today);
		}
//		$this->db->where('gold_orders_payment.status',0);
//		$this->db->where('gold_orders_payment.customer_note !=', 'outstanding');
		$this->db->where_in('payment_method_name',array('Vouchers','Debit / Credit Sales'));
		$query = $this->db->get();
		return !empty($query->row()->unpaid_amount) ? $query->row()->unpaid_amount : 0.00;
	}
	
	public function OutstandingReceived()
	{
		$today = date('Y-m-d');
		$this->db->select('sum(paid_amt) as paid_amount');
		$this->db->from('gold_orders_payment');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d")',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(updated_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else 
		{
			$this->db->where('DATE_FORMAT(ordered_datetime,"%Y-%m-%d")',$today);
		}
//		$this->db->where('gold_orders_payment.status',0);
		$this->db->where_in('payment_method_name',array('Vouchers','Debit / Credit Sales','Pay Outstanding'));
		$query = $this->db->get();
		return !empty($query->row()->paid_amount) ? $query->row()->paid_amount : 0.00;
	}
	
	public function getCategoryWiseSaleQty($cat)
	{
		$today = date('Y-m-d');
		$this->db->select('sum(order_items_gold.qty) as totalqty, sum(order_items_gold.grandtotal) as totalgrandtotal ');
		$this->db->from('order_items_gold');
		$this->db->join('gold_orders','gold_orders.gold_id = order_items_gold.order_id','left');
		$this->db->where('order_items_gold.product_category',$cat);
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d")',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else 
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d")',$today);
		}
//		$this->db->where('order_items_gold.status',0);
		$query = $this->db->get();
		return $query->row(); 
	}
	
	

	
	public function getTanksReceivedStocks($tank_id)
	{
		$today = date('Y-m-d');
		$this->db->select('*, sum(tank_qty) as total_tank_qty ');
		$this->db->from('purchase_received');
		$this->db->where('tank_id',$tank_id);
		$this->db->where('type',1);
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d")',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else 
		{
			$this->db->where('DATE_FORMAT(created_at,"%Y-%m-%d")',$today);
		}
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row(); 
	}
	
	public function getPumper()
	{
		$query = $this->db->get('pumps');
		return $query->result();
	}
	
	public function getCustomer()
	{
		$query = $this->db->get('customers');
		return $query->result();
	}
	
	public function getStore()
	{
		$this->db->where('s_status','1');
		$query = $this->db->get('stores');
		return $query->result();
	}
	
	public function getStoreDropDefaultStore()
	{
		$this->db->where('s_status','1');
		$this->db->where('s_id !=',1);
		$query = $this->db->get('stores');
		return $query->result();
	}
	
	public function getSuppliers()
	{
		$this->db->where('status','1');
		$query = $this->db->get('suppliers');
		return $query->result();
	}
	
	public function getmaxIdPurchaseReturn()
	{
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get('purchase_return');
		$number = !empty($query->row()->id)?$query->row()->id:0;
		return $number+1;
	}
	
	public function getPaymentType()
	{
		$this->db->where('status','1');
		$query = $this->db->get('payment_method');
		return $query->result();
	}
	
	public function getPaymentTypeGroupby()
	{
		$this->db->group_by('name');
		$query = $this->db->get('payment_method');
		return $query->result();
	}
	
	public function checkPaymentmethodOutletid($last_id)
	{
		$this->db->where('outlet_id',$last_id);
		$query = $this->db->get('payment_method');
		return $query->num_rows();
	}
	
	public function getProduct()
	{
		$this->db->where('status','1');
		$query = $this->db->get('products');
		return $query->result();
	}
	

	
	public function	upadateshorage_amount($upadateshorage_amount,$operator_pump_id)
	{
		$this->db->where('id',$operator_pump_id);
		$this->db->update('pump_operators',$upadateshorage_amount);
		return true;
	}
			
	public function getPumpOperator($id)
	{
		$this->db->where('id',$id);
		$this->db->limit(1);
		$query = $this->db->get('pump_operators');
		return $query->row();
	}
	
	public function getSettlementMaxno()
	{
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get('transactions');
		return $query->row()->settlement_id+1;
	}

	public function TotalExpensePumpOperator($id)
	{
		$query = $this->db->query('SELECT SUM(extra_credit_debit_balance) AS total_expense FROM orders_payment WHERE pump_operators_id = '.$id.' ');
		return $query->row()->total_expense;
	}
			
	public function getOutlets()
	{
		$queryoutlet = $this->db->get_where('users', array('id' => $this->session->userdata('user_id')))->row();
		if(!empty($queryoutlet))
		{
			if($queryoutlet->outlet_id > 0)
			{
				$this->db->where('id',$queryoutlet->outlet_id);
			}
		}
		$query = $this->db->get('outlets');
		return $query->result();
	}
	
	public function getPaymentMethod()
	{
		$query = $this->db->get('payment_method');
		return $query->result();
	}
	
	public function getOutletWisePaymentMethod($id)
	{
		$this->db->where('outlet_id',$id);
		$this->db->order_by('id','asc');
		$query = $this->db->get('payment_method');
		return $query->result();
	}
	
	
	public function getCategory()
	{
		$this->db->where('status','1');
		$query = $this->db->get('category');
		return $query->result();
	}
	
//****** add by a3frt start *******************
	function getCategory_id($name = null)
	{
		$this->db->select('id');
		$this->db->where('name',"$name");
		$query = $this->db->get('category');		
		return $query->result();
	}

	function getSunCategory_id($sub_category = null)
	{
		$this->db->select('id');
		$this->db->where('sub_category',"$sub_category");
		$query = $this->db->get('sub_category');
		return $query->result();
	}

	function getOutletId($name = null)
	{
		$this->db->select('id');
		$this->db->where('name',"$name");
		$query = $this->db->get('outlets');
		return $query->result();
	}

	function getProducttId($name = null)
	{
		$this->db->select('id');
		$this->db->where('name',"$name");
		$query = $this->db->get('products');
		return $query->result();
	}

	function getStoresId($s_name = null)
	{
		$this->db->select('s_id');
		$this->db->where('s_name',"$s_name");
		$query = $this->db->get('stores');
		return $query->result();
	}

//****** add by a3frt End *******************

	public function UpdateRaisepo($id)
	{
		$this->db->set('status', '5');
		$this->db->where('id', $id);
		$this->db->update('purchase_order');
		return true;
	}
	
	public function getBonusPurchase()
	{
		$this->db->select('purchase_order_items.*,outlets.name as outletsname,suppliers.name as suppliersname,products.name as productname,purchase_order.created_datetime,products.purchase_price');
		$this->db->from('purchase_order_items');
		$this->db->join('purchase_order', 'purchase_order_items.po_id = purchase_order.id');
		$this->db->join('outlets', 'purchase_order.outlet_id = outlets.id');
		$this->db->join('suppliers', 'purchase_order.supplier_id = suppliers.id');
		$this->db->join('products', 'purchase_order_items.product_code = products.code');
		$this->db->where('purchase_order_items.bonusqty >= ','1');
//		if(!empty($this->input->get('product_code')))
//		{
//			$this->db->where('purchase_order_items.product_code',$this->input->get('product_code'));
//		}
//		if(!empty($this->input->get('product_name')))
//		{
//			$this->db->where('products.name',$this->input->get('product_name'));
//		}
//		if(!empty($this->input->get('outlet_id')))
//		{
//			$this->db->where('purchase_order.outlet_id',$this->input->get('outlet_id'));
//		}
//		if(!empty($this->input->get('supplier_id')))
//		{
//			$this->db->where('purchase_order.supplier_id',$this->input->get('supplier_id'));
//		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(purchase_order.created_datetime, "%Y-%m-%d") >=',date('Y-m-d', strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(purchase_order.created_datetime, "%Y-%m-%d") <=',date('Y-m-d', strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
	}
	

    // Query Data from Table with Order;
    public function getDataAll($table, $order_column, $order_type)
    {
        $this->db->order_by("$order_column", "$order_type");
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
		return $result;
    }
	
	
	
	public function getprofitcalall()
	{
		$this->db->select('*');
		$this->db->from('profit_calculations');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(create_date, "%Y-%m-%d") >=',date('Y-m-d', strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(create_date, "%Y-%m-%d") <=',date('Y-m-d', strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
	
	}
	
	public function getmoduledata()
	{
		$array = array();
		$this->db->select('resources.*');
		$this->db->from('resources');
		
		if($this->session->userdata('user_role') != 7)
		{
			$this->db->join('permissions','permissions.resource_id = resources.id');
			$query = $this->db->where('permissions.user_id',$this->session->userdata('user_id'));
			$query = $this->db->where('permissions.main_menu',1);
		}
		
		$query = $this->db->get();
		$result= $query->result();
		for($i=0;$i<count($result);$i++){
			$cnt = $result[$i]->id;
			$array[$cnt]['id']   = $result[$i]->id;
			$array[$cnt]['pid']   = $result[$i]->pid;
			$array[$cnt]['name']   = $result[$i]->name;
			$array[$cnt]['title']   = $result[$i]->title;

        }
		
		return $array;
	}
	
	
	
	
	
	public function getmoduledata1()
	{
		$this->db->select('resources.*');
		$this->db->from('resources');
		$this->db->join('permissions','permissions.resource_id = resources.id');
		$query = $this->db->where('permissions.user_id',$this->session->userdata('user_id'));
		if($this->session->userdata('user_role') != 7)
		{
			$query = $this->db->where('permissions.main_menu',1);
		}

		$query = $this->db->get();
		$result= $query->result();
		$array = array();
		 for($i=0;$i<count($result);$i++){
			$cnt = $result[$i]->id;
			$array[$cnt]['id']   = $result[$i]->id;
			$array[$cnt]['pid']   = $result[$i]->pid;
			$array[$cnt]['name']   = $result[$i]->name;
			$array[$cnt]['title']   = $result[$i]->title;

        }
		  return $array;
		
	}

	public function getAllddData($table,$where='')
    {
        $this->db->select("*");
        if($where!='')
		{
			$query = $this->db->where($where)->get("$table");
        } 
		else 
		{
			$query = $this->db->get("$table");
        }
        $result = $query->result();
        $array = array();
        for($i=0;$i<count($result);$i++){
			$cnt = $result[$i]->id;
			$array[$cnt]['id']   = $result[$i]->id;
			$array[$cnt]['pid']   = $result[$i]->pid;
			$array[$cnt]['name']   = $result[$i]->name;
			$array[$cnt]['title']   = $result[$i]->title;
        }
        return $array;
    }
	
    // Query Data from Table by One Columns;
    public function getDataOneColumn($table, $col1_name, $col1_value)
    {
        $this->db->where("$col1_name", $col1_value);
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }
	
	
    public function getGeneralRowData($table, $col1_name, $col1_value)
    {
        $this->db->where("$col1_name", $col1_value);
        $this->db->limit(1);
        $query = $this->db->get("$table");
        $result = $query->row();
        return $result;
    }
	
	// update bulk_transfer by a3frt

    function update_bulk_transfer($table = null,$id = null,$data = null)
    {
    	$this->db->where('id',"$id");
    	$res = $this->db->update("$table",$data);
    	if($res)
    	{
    		return true;
    	}
    	return false;
    }

    function get_store_transform_product_code($id=null)
    {
    	$id = (int)$id;
    	$this->db->select('product_code');
    	$this->db->from("store_transform");	
    	$this->db->where('id',"$id");		
    	$query = $this->db->get();

    	return $query->result();
    	
    }

    function get_product_id($product_code=null)
    {
    	$this->db->select('id');
    	$this->db->from("products");	
    	$this->db->where('code',"$product_code");		
    	$query = $this->db->get();

    	return $query->result();
    }

  /*  function get_inventory_id($product_code=null)
    {
    	$this->db->select('id');
    	$this->db->from('inventory');	
    	$this->db->where('product_code',"$product_code");		
    	$query = $this->db->get();	
    	return $query->row()->id;
    }*/

	// update bulk_transfer by a3frt end
	
	
	

    // Query Data from Table By two columns;
    public function getDataTwoColumn($table, $col1_name, $col1_value, $col2_name, $col2_value)
    {
        $this->db->where("$col1_name", $col1_value);
        $this->db->where("$col2_name", $col2_value);
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }
	
    // Query Data from Table by One Columns and Sort;
    public function getDataOneColumnSortColumn($table, $col1_name, $col1_value, $sort_column, $sort_type)
    {
        $this->db->where("$col1_name", $col1_value);
        $this->db->order_by("$sort_column", "$sort_type");
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }

    // Query Data from Table by One Columns and Sort;
    public function getDataTwoColumnSortColumn($table, $col1_name, $col1_value, $col2_name, $col2_value, $sort_column, $sort_type)
    {
        $this->db->where("$col1_name", $col1_value);
        $this->db->where("$col2_name", $col2_value);
        $this->db->order_by("$sort_column", "$sort_type");
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }

    // Not Equal To;
    public function twoColumnNotEqual($table, $col1_name, $col1_value, $col2_name, $col2_value)
    {
        $this->db->where("$col1_name", $col1_value);
        $this->db->where("$col2_name != ", $col2_value);
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }

    // Insert Data to Any Table;
    public function insertData($table, $data)
    {
        return $this->db->insert("$table", $data);
    }
    
    public function record_count($table,$key)
    {
        $this->db->order_by($key, 'DESC');
        $query = $this->db->get($table);
        $this->db->save_queries = false;
        return $query->num_rows();
    }
    
    public function fetch_data($table,$key,$order,$limit, $start)
    {
        $this->db->order_by($key, $order);
        $this->db->limit($limit, $start);
        $query = $this->db->get($table);
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }
    
    // Insert Data to Any Table and get the last id;
    public function insertDataReturnLastId($table, $data)
    {
        $this->db->insert("$table", $data);
        return $this->db->insert_id();
    }

    // Update Data to Any Table;
    public function updateData($table, $data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update("$table", $data);
        return true;
    }
    public function updateDataGoldsmith($table, $data, $id)
    {
        $this->db->where('gs_id', $id);
        $this->db->update("$table", $data);
        return true;
    }

    // Delete Data from Any Table;
    public function deleteData($table, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete("$table");
        return true;
    }
	
	public function deleteDataPaymentOutlet($id)
	{
		$this->db->where('outlet_id', $id);
        $this->db->delete("payment_method");
        return true;	
	}
	
    public function deleteByColumn($table, $col_name, $col_value)
    {
        $this->db->where("$col_name", $col_value);
        $this->db->delete("$table");
        return true;
    }
	
	public function getDataWhere($table,$where='')
    {
        if($where!='')
		{
            $this->db->where($where);
        } 
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }
	
	public function getddData($table,$key,$name, $order_column,$where='')
    {
        $this->db->select("$key,$name")->order_by("$order_column", "ASC");
        if($where!='')
		{
			$query = $this->db->where($where)->get("$table");
        } 
		else 
		{
			$query = $this->db->get("$table");
        }
        $result = $query->result();
        $array = array();
        for($i=0;$i<count($result);$i++)
		{
			$key_data= $result[$i]->$key;
			$name_data= $result[$i]->$name;
			$array[$key_data]   = $name_data;
        }
        return $array;
    }

#*************************************************************
# added by a3frt date: 15-11-17 start
#*************************************************************

    function get_sale_minimum_maxim($user_id =  null)
    {
    	$this->db->select('sale_minimum_permission,sale_maximum_permission');
    	$this->db->limit(1);
    	$this->db->where('user_id',"$user_id");
    	$query = $this->db->get('permissions');

    	return $query->result();

    }
	
	#*************************************************************
	# added by a3frt date: 15-11-17 end
	#*************************************************************
	
	function add_update($table,$where,$data)
	{
        $records=  $this->db->where($where)->from($table)->count_all_results();
        if($records>0)
		{
            $this->db->where($where);
             $this->db->update($table, $data);
        } 
		else 
		{
            $this->db->insert($table, $data);
		}
        return true;
    }
	
	public function getSingle($table,$select,$where,$field='',$order_by='',$sort='')
	{
		if($order_by!='')
		{
			$row = $this->db->select($select)->where($where)->order_by($order_by,$sort)->from($table)->get()->row();
		}
		else
		{
			$row = $this->db->select($select)->where($where)->from($table)->get()->row();
		}
		if(is_object($row))
		{
			if($field==''){$field=$select;}
			return $this->db->select($select)->where($where)->from($table)->get()->row()->$field;
		} 
		else 
		{
			return 0;
		}
    }
	
	
	public function getNextId($table,$is_outlet=0,$field=0)
	{
        $arr=array();
        if($is_outlet==1)
		{
            $outlets =  $this->Constant_model->getddData('outlets','id','name', 'id');
            foreach($outlets as $oid=>$val)
			{
                $arr[$oid]= $this->db->select_max($field)->where('outlet_id='.$oid)->from($table)->get()->row()->sid;
            }
           return $arr;
        }
		else
		{
            return $this->db->query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA ='".$this->db->database."' AND TABLE_NAME = '".$table."'")->row()->AUTO_INCREMENT;
        }
    }
	
	public function getDailyCollectionFormNo()
	{
		$this->db->limit(1);
		$this->db->order_by('id','desc');
		$query = $this->db->get('daily_collection');
		$formno = !empty($query->row()->id)?$query->row()->id:0;
		return $formno + 1;
	}
	
	public function getDailyCollection()
	{
		$this->db->select('daily_collection.*,pump_operators.operator_name,outlets.name as outletname,users.fullname');
		$this->db->from('daily_collection');
		$this->db->join('pump_operators','pump_operators.id = daily_collection.pumper_id','left');
		$this->db->join('outlets','outlets.id = daily_collection.outlet_id','left');
		$this->db->join('users','users.id = daily_collection.created_by','left');
		if(!empty($this->input->get('startdate')))
		{
			$this->db->where('DATE_FORMAT(daily_collection.created_at,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('startdate'))));
		}
		if(!empty($this->input->get('enddate')))
		{
			$this->db->where('DATE_FORMAT(daily_collection.created_at,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('enddate'))));
		}
		if(!empty($this->input->get('outlet')))
		{
			$this->db->where('daily_collection.outlet_id',$this->input->get('outlet'));
		}
		if(!empty($this->input->get('formno')))
		{
			$this->db->where('daily_collection.collection_form_no',$this->input->get('formno'));
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getDailyCollectionPrint($id)
	{
		$this->db->select('daily_collection.*,pump_operators.operator_name,outlets.name as outletname,users.fullname');
		$this->db->from('daily_collection');
		$this->db->join('pump_operators','pump_operators.id = daily_collection.pumper_id','left');
		$this->db->join('outlets','outlets.id = daily_collection.outlet_id','left');
		$this->db->join('users','users.id = daily_collection.created_by','left');
		$this->db->where('daily_collection.id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function getOutletsDailySummer()
	{
		$this->db->where('status','1');
		if(!empty($this->input->get('outlet')))
		{
			$this->db->where('id',$this->input->get('outlet'));
		}
		$query = $this->db->get('outlets');
		return $query->result();
	}
	public function getGradeprice($grade_id)
	{
		$today = date('Y-m-d');
		$this->db->select('*');
		$this->db->from('gold_prices');
		$this->db->where('gp_grade=',$grade_id);
		$this->db->where('DATE_FORMAT(gp_date_created,"%Y-%m-%d")=',$today);
		$this->db->limit(1);
		$this->db->order_by("gp_id", "desc");
		$query = $this->db->get();
		return $query->row();
	}
	
	
	
	public function getSubCategoruQty($sub)
	{
		$today = date('Y-m-d');
		$this->db->select('sum(order_items_gold.qty) as totalqty, sum(order_items_gold.grandtotal) as totalPurchaseprice ');
		$this->db->from('order_items_gold');
		$this->db->join('gold_orders','gold_orders.gold_id = order_items_gold.order_id');
		$this->db->join('products','products.code = order_items_gold.product_code');
		$this->db->where('products.sub_category_id_fk',$sub);
//		$this->db->where('order_items_gold.status',0);
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d")',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else 
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d")',$today);
		}
		$query = $this->db->get();
		return $query->row();
	}
	
	
//	public function SalesReturnSubCategoryQty($sub)
//	{
//		$today = date('Y-m-d');
//		$this->db->select('sum(return_items.qty) as salereturnqty');
//		$this->db->from('return_items');
//		$this->db->join('sales_return','sales_return.id = return_items.order_id');
//		$this->db->join('products','products.code = return_items.product_code');
//		$this->db->where('products.sub_category_id_fk',$sub);
//		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')) )
//		{
//			$this->db->where('DATE_FORMAT(sales_return.created_at,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(sales_return.created_at,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
//		}
//		else 
//		{
//			$this->db->where('DATE_FORMAT(sales_return.created_at,"%Y-%m-%d")',$today);
//		}
//		
//		$query = $this->db->get();
//		return !empty($query->row()->salereturnqty)?$query->row()->salereturnqty:0;
//	}
	
	
//	public function PurchaseSubCategoryQty($sub)
//	{
//		$today = date('Y-m-d');
//		$this->db->select('sum(purchase_order_items.ordered_qty) as purchaseqty');
//		$this->db->from('purchase_order_items');
//		$this->db->join('purchase_order','purchase_order.id = purchase_order_items.po_id');
//		$this->db->join('products','products.code = purchase_order_items.product_code');
//		$this->db->where('products.sub_category_id_fk',$sub);
//		
//		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')) )
//		{
//			$this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
//		}
//		else 
//		{
//			$this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d")',$today);
//		}
//		
//		$query = $this->db->get();
//		return !empty($query->row()->purchaseqty)?$query->row()->purchaseqty:0;
//	}
	
	
	
//	public function PurchaseReturnQtySubCategoryQty($sub)
//	{
//		$today = date('Y-m-d');
//		$this->db->select('sum(purchase_return.returned_qty) as purchasereturnqty');
//		$this->db->from('purchase_return');
//		$this->db->join('products','products.code = purchase_return.product_code');
//		$this->db->where('products.sub_category_id_fk',$sub);
//		
//		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')) )
//		{
//			$this->db->where('DATE_FORMAT(purchase_return.created_date,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(purchase_return.created_date,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
//		}
//		else 
//		{
//			$this->db->where('DATE_FORMAT(purchase_return.created_date,"%Y-%m-%d")',$today);
//		}
//		
//		$query = $this->db->get();
//		return !empty($query->row()->purchasereturnqty)?$query->row()->purchasereturnqty:0;
//	}
	
	
	
	
//	
//	public function OpeningSubCategoryQty($sub)
//	{
//		$yesterday = date('Y-m-d',strtotime("-1 days"));
//		$this->db->select('sum(order_items.qty) as openingqty');
//		$this->db->from('order_items');
//		$this->db->join('orders','orders.id = order_items.order_id');
//		$this->db->join('products','products.code = order_items.product_code');
//		$this->db->where('products.sub_category_id_fk',$sub);
//		$this->db->where('order_items.status',0);
//		
//		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')) )
//		{
//			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
//		}
//		else 
//		{
//			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d")',$yesterday);
//		}
//		
//		$query = $this->db->get();
//		return !empty($query->row()->openingqty)?$query->row()->openingqty:0;
//	}
	
	
	
	public function getSubCategoryBalanceQty($sub)
	{
		$today = date('Y-m-d');
		$totalstock = 0;

		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('sub_category_id_fk',$sub);
		$query  = $this->db->get();
		
		if (!empty($query->result()))
		{
			foreach ($query->result() as $value)
			{
				$report_product = $this->db->select('*');
				$report_product = $this->db->from('product_report');
				$report_product = $this->db->where('product_code',$value->code);
				if(!empty($this->input->get('start_date')))
				{
					$report_product = $this->db->where('DATE_FORMAT(created_date,"%Y-%m-%d")',date('Y-m-d',strtotime($this->input->get('start_date'))));
//					$report_product = $this->db->where('DATE_FORMAT(created_date,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
				}
				else 
				{
					$report_product = $this->db->where('DATE_FORMAT(created_date,"%Y-%m-%d")',$today);
				}
				$report_product = $this->db->order_by('id','desc');
				$report_product = $this->db->limit('1');
				$report_product = $this->db->get();
				$totalqty = !empty($report_product->row()->balance_qty)?$report_product->row()->balance_qty:0;
				$totalstock = $totalstock + $totalqty;
				
			}
		}
		return !empty($totalstock)?number_format($totalstock,2):0;
	}
	
	
	public function getTanksTodaySoldStocks($id)
	{
		$today = date('Y-m-d');
		$this->db->select('SUM(order_items.qty) as totalQty');
		$this->db->from('order_items');
		$this->db->join('orders','orders.id = order_items.order_id');
		$this->db->where('order_items.ow_id',$id);
		$this->db->where('order_items.type','1');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d")',date('Y-m-d',strtotime($this->input->get('start_date'))));
//			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else 
		{
			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d")',$today);
		}
		$this->db->where('order_items.status',0);
		$query = $this->db->get();
		return $query->row()->totalQty;
		
	}
	
	
	public function getEmailUser($getemail)
	{
		$this->db->limit(1);
		$query = $this->db->get('users');
		return $query->row()->email;
	}
	
	public function getUsers($user_id)
	{
		$this->db->where('id',$user_id);
		$query = $this->db->get('users');
		return $query->row();
	}
	
	public function getMeterReset($user_id)
	{
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get('meter_reset');
		$number = !empty($query->row()->id)?$query->row()->id:0;
		return $number + 1;
	}
	

	
	public function getCustomerDetail($cust_id)
	{
		$this->db->where('id',$cust_id);
		$this->db->limit(1);
		$query = $this->db->get('customers');
		return $query->row();
	}
	
	public function getCustomerOderPayment($cust_id)
	{
		$this->db->select('gold_orders_payment.*,customers.outstanding as openingBalance,outlets.name as outlet_name');
		$this->db->from('gold_orders_payment');
		$this->db->join('customers','customers.id = gold_orders_payment.customer_id');
		$this->db->join('outlets','outlets.id = gold_orders_payment.outlet_id','left');
		$this->db->where('gold_orders_payment.customer_id',$cust_id);
		$query = $this->db->get();
		return $query->result();
	}



	#***********************************************************************
	#      added by a3frt date: 15-11-17 start
	#***********************************************************************

	function get_action_data()
	{
		$this->db->select('users.fullname as user_name,price_permission_by_admin.*');
		$this->db->from('price_permission_by_admin');
		$this->db->join('users','users.id = price_permission_by_admin.request_user');
	   $query = $this->db->get();

	   return $query->result();
	}

	function get_accept_user_name($id = null)
	{
		$this->db->select('fullname as accept_name');
		$this->db->where('id',"$id");
		$query = $this->db->get('users');

		return $query->result();
	}

	function update_accepted($id = null, $data = null)
	{
		$this->db->where('id', $id);
		$this->db->update('price_permission_by_admin', $data);
	}

	function get_accept_user_list()
	{
		$this->db->select('user_id');
		$con = array('sale_minimum_permission' => 1, 'sale_maximum_permission' => 1);
		$this->db->where($con);
		$this->db->group_by('user_id');
		$query = $this->db->get('permissions');

		return $query->result();
	}

	function check_pending_sale_below_above_price()
	{
		$this->db->select('id');
		$this->db->where('actions','pending');
		$query = $this->db->get('price_permission_by_admin');

		return $query->num_rows();
	}

	public function GetloanDetailData()
	{
		$this->db->select('*');
		$this->db->from('loan_detail');
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
// 		echo $this->db->last_query(); exit();
		return $query->result();
	
	}


	#***********************************************************************
	#      added by a3frt date: 15-11-17 end
	#************************************************************************

	
	
}
