<?php

class Gold_module extends CI_Model
{
	function select_all_join($table,$table1,$table2)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table1,"$table1.s_id=$table.w_id");
		$this->db->join($table2,"$table2.id=$table.out_id");
		$result = $this->db->get();
		return $result->result();
	}
	
	function getValuegoldsmith($id)
	{
		$this->db->where('gs_id',$id);
		$this->db->limit(1);
		$query = $this->db->get('gold_smith');
		return !empty($query->row()->opening_gold_qty)?number_format($query->row()->opening_gold_qty,2):0;
	}
	
	public function getSubCategoryGoldsmith($category_id)
	{
		$this->db->where('category_id_fk',$category_id);
		$query = $this->db->get('sub_category');
		return $query->result();
	}
	
	public function getProducationReceive()
	{
		$this->db->select('stores.s_name as storename,work_job_order_receive.*,outlets.name as outletname, gold_smith.fullname as gold_smith_name,order_items_gold.product_name, category.name as category_name ');
		$this->db->from('work_job_order_receive');
		$this->db->join('gold_smith','gold_smith.gs_id = work_job_order_receive.goldsmith','left');
		$this->db->join('outlets','outlets.id = work_job_order_receive.outlet_id','left');
		$this->db->join('order_items_gold','order_items_gold.id = work_job_order_receive.finish_product_item','left');
		$this->db->join('stores','stores.s_id = work_job_order_receive.receiving_store','left');
		$this->db->join('category','category.id = work_job_order_receive.product_category','left');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getProducationPrintReceive($id)
	{
		$this->db->select('stores.s_name as storename, work_job_order_receive.*,outlets.name as outletname, gold_smith.fullname as gold_smith_name,order_items_gold.product_name, category.name as category_name ');
		$this->db->from('work_job_order_receive');
		$this->db->join('gold_smith','gold_smith.gs_id = work_job_order_receive.goldsmith','left');
		$this->db->join('outlets','outlets.id = work_job_order_receive.outlet_id','left');
		$this->db->join('order_items_gold','order_items_gold.id = work_job_order_receive.finish_product_item','left');
		$this->db->join('category','category.id = work_job_order_receive.product_category','left');
		$this->db->join('stores','stores.s_id = work_job_order_receive.receiving_store','left');
		$this->db->where('work_job_order_receive.id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	public function CustomerOutstandingBalance($cust_id)
	{
		
		$query = $this->db->select('SUM(unpaid_amt) AS totalunpaidamount ');
		$query = $this->db->where('customer_note','outstanding');
		$query = $this->db->where('customer_id',$cust_id);
		$query = $this->db->get('gold_orders_payment');
		$outstanding = !empty($query->row()->totalunpaidamount)?$query->row()->totalunpaidamount:0;
		
		
		$main = $this->db->select('SUM(gold_unpaid_amt) AS gold_unpaid_amttotal ');
		$main = $this->db->where('gold_customer_id',$cust_id);
		$main = $this->db->get('gold_orders');
		$outstanding_main = !empty($main->row()->gold_unpaid_amttotal)?$main->row()->gold_unpaid_amttotal:0;
		return $outstanding_main + $outstanding;
		
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
	
	function UnCompleteOrder()
	{
		$this->db->select('gold_orders.*');
		$this->db->from('gold_orders');
		$this->db->join('order_items_gold',"order_items_gold.order_id=gold_orders.gold_id",'left');
		$this->db->where('order_items_gold.work_completd_status',0);
		$this->db->group_by('gold_orders.gold_id');
		$query = $this->db->get();
		return $query->result();
	}
	
	function getCustomersingle($customer_id)
	{
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->where('id',$customer_id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
	function getSalesPersonSingle($data_sales_id)
	{
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id',$data_sales_id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	
	function getOrderDeliveryDate($id)
	{
		$this->db->where('gold_id',$id);
		$this->db->limit(1);
		$query = $this->db->get('gold_orders');
		return $query->row()->gold_delivery_date;
	}
	
	function getgoldOrderItem($id)
	{
		$this->db->where('order_id',$id);
		$this->db->where('work_completd_status',0);
		$query = $this->db->get('order_items_gold');
		return $query->result();
	}
	function getSubCategory()
	{
		$query = $this->db->get('sub_category');
		return $query->result();
	}
			
	
	function UpdateStatus($statusval,$id)
	{
		$this->db->set('status',$statusval);
		$this->db->where('gold_id',$id);
		$this->db->update('gold_orders');
		return true;
	}
	
	function ProductUpdateStatus($id)
	{
		$this->db->set('status_gold','1');
		$this->db->where('code',$id);
		$this->db->update('products');
		return true;
	}


			
	
	function insert_data($table_name,$data)
	{
		$message = array();
		$this->db->insert($table_name,$data);
		if($this->db->affected_rows()==true){
        $message['message'] = "Successfully ";
		$message['last'] = $this->db->insert_id();
        $message['error'] = true;
		return $message;}
		else{
        $message['message'] = "Not Added Try again ";
        $message['error'] = false;
        return $message;}
	}
	function production_join($table,$table1,$table2,$table3){
		$this->db->select("*");   
		$this->db->from($table);   
		$this->db->join($table1,"$table1.gs_id=$table.goldsmith");
		$this->db->join($table2,"$table2.s_id=$table.pro_ware");
		$this->db->join($table3,"$table3.id=$table.pro_out_id");
		$result = $this->db->get();
		return $result->result();
	}

	function multiple_joins($table,$table1,$table2,$table3)
	{
		$this->db->select("*,$table1.fullname,$table2.gpro_name,$table3.cate_name");
		$this->db->from($table);
		$this->db->join($table1,$table1.".gs_id=$table.goldsmith_id");
		$this->db->join($table2,$table2.".gpro_id=$table.pro_id");
		$this->db->join($table3,$table3.".pro_cate_id=$table.sub_id");
		$result = $this->db->get()->result();
		return $result;
	}
	
	function select_all_join_two($table,$table1)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($table1,"$table1.s_id=$table.w_id");
		$result = $this->db->get();
		return $result->result();
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
	
	
	

	
		function select_all($table_name)
		{
			$this->db->select('*');
			$record = $this->db->get($table_name);
			return $record->result();
		}
	
		function select_all_order($table_name,$order){
		  $this->db->select('*');
		  $this->db->order_by("gp_date_created", $order);
		  $record = $this->db->get($table_name);
		  return $record->result();
		}
	
		function getGoldGradeDetail($gold_id)
		{
				$this->db->select('*');
				$this->db->from('gold_grade');
				$this->db->where('grade_id',$gold_id);
				$res = $this->db->limit(1);
				$res = $this->db->get();
				return $res->row();
		}
	
		function getgold_gradeData()
		{
			$this->db->select('*');
			$this->db->from('gold_grade');
			$res = $this->db->get();
			return $res->result();
		}
		
		function getmatch_gold_gradeData($grade_id)
		{
			$this->db->select('*');
			$this->db->from('gold_grade');
			$this->db->where('grade_id',$grade_id);
			$this->db->limit(1);
			$query = $this->db->get();
			return $query;
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
	
	function getwarehouseData($finalid)
	{
		$this->db->select('*');
		$this->db->from('stores');
		$this->db->where_not_in('s_id',  explode(",", $finalid));
		$this->db->where('s_id !=',1);
		$res = $this->db->get();
		return $res->result();
	}
	
	function select_all_joins($table,$table1,$table2,$table3)
	{
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($table1,"$table1.code=$table.product_code");
        $this->db->join($table2,"$table2.ow_id=$table.ow_id");
        $this->db->join($table3,"$table3.id=$table.outlet_id");
        $result = $this->db->get();
        return $result->result();
    }
	
	function updated_data($table_name,$data,$condition)
	{
		$message = array();
		$this->db->where($condition);
		$this->db->update($table_name,$data);
		if($this->db->affected_rows()==true){
        $message['message'] = "Successfully Updated  ";
        $message['error'] = true;
        }
		else{
        $message['message'] = "Not Updated Try again ";
        $message['error'] = false;
        }
        return $message;

	}
	
	
	
	function get_all_data_specific_id($table_name,$condition)
	{
		$message = array();
		$this->db->select('*');
		$this->db->where($condition);
		$res = $this->db->get($table_name);    
		return $res->result();
	}
	
	public function getWarehouseStocks()
	{
		$this->db->select('inventory.id,inventory.gold_weight,products.product_type,products.name as productname,products.weight as product_weight,products.start_qty as product_qty,inventory.qty as inventoryqty,stores.s_name as storename, outlets.name as outletname,inventory.product_code');
        $this->db->from('inventory');
        $this->db->join('products',"products.code=inventory.product_code");
        $this->db->join('outlet_warehouse',"outlet_warehouse.ow_id=inventory.ow_id");
        $this->db->join('stores',"stores.s_id=outlet_warehouse.w_id");
        $this->db->join('outlets',"outlets.id=inventory.outlet_id");
        $result = $this->db->get();

        return $result->result();
	}

	#***************************************************
	#   added by a3frt 14-11-2017 start
	#****************************************************

	function get_sum_weight_qty($name = null)
	{
		$this->db->select('SUM(products.weight) as sum_weight, SUM(products.start_qty) as sum_qty');
		$this->db->from('products');
		$this->db->join('inventory',"products.code=inventory.product_code");
		$conditions = array('products.product_type !=' => "bulk", 'products.name' => "$name");
		$this->db->where($conditions);

		$result = $this->db->get();

		return $result->result();

	}


	function get_bulk_weight_qty($name = null)
	{

		$this->db->select('start_qty,weight');
		$this->db->from('products');
		$conditions = array('products.product_type' => "bulk", 'products.name' => "$name");
		$this->db->where($conditions);

		$result = $this->db->get();

		return $result->result();
	}


	#***************************************************
	#   added by a3frt 14-11-2017 end
	#****************************************************
	
	
	public function getDataReceiveJob($id)
	{
		$this->db->select('work_job_order_receive.*,category.name as category_name,gold_smith.fullname as gold_smith_fullname,gold_grade.grade_name as goldgrade_name,products.name as productname');
		$this->db->from('work_job_order_receive');
		$this->db->join('category',"category.id=work_job_order_receive.product_category");
		$this->db->join('gold_smith',"gold_smith.gs_id=work_job_order_receive.goldsmith");
		$this->db->join('gold_grade',"gold_grade.grade_id=work_job_order_receive.gold_grade");
		$this->db->join('products',"products.id=work_job_order_receive.finish_product_item");
		$this->db->where('work_job_order_receive.id',$id);
		$this->db->limit('1');
		$result = $this->db->get();
		return $result->row();
	}
	
	function getAllWarehouse()
	{
		$query  = $this->db->get('stores');
		return $query->result();
	}
	
	/*function getTransFormNumber()
	{
		$query  = $this->db->order_by('id','desc');
		$query  = $this->db->limit('1');
		$query  = $this->db->get('store_transform');
		$number = !empty($query->row()->id) ? $query->row()->id : 0;
		return $number + 1;
	}*/

	//modified by a3frt 01-nov-17 start
	function getTransFormNumber()
	{
		$query  = $this->db->order_by('id','desc');
		$query  = $this->db->limit('1');
		$query  = $this->db->get('store_transform');
		$number = !empty($query->row()->ref_number) ? $query->row()->ref_number : 'BU-0';

		$num = (int)substr($number, 3);
		$num++;
		$number = "BU-".$num;

		return $number;
	}

	function getTransFormNumber_inventory()
	{
		$query  = $this->db->order_by('id','desc');
		$query  = $this->db->limit('1');
		$query  = $this->db->get('inventory');
		$number = !empty($query->row()->ref_number) ? $query->row()->ref_number : 'BU-0';

		$num = (int)substr($number, 3);
		$num++;
		$number = "BU-".$num;

		return $number;
	}

	//modified by a3frt 01-nov-17 End

	function InStockInventory()
	{
		$this->db->where('product_code',$this->input->post('product_code'));
		$this->db->where('outlet_id',$this->input->post('outlet_id'));
		$this->db->where('ow_id',$this->input->post('FromStore_warehouse'));
		$this->db->where('type','0');
		$query = $this->db->get('inventory');
		return !empty($query->row()->qty) ? $query->row()->qty : 0;
	}
	
	function toWareTransformInventory($warehouse,$outlet_id,$product_code)
	{
		$this->db->where('product_code',$product_code);
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('ow_id',$warehouse);
		$this->db->where('type','0');
		$this->db->limit(1);
		$query = $this->db->get('inventory');
		return $query;
	}
	
	function UpdateInventory($update_to_inventory,$inventory_id)
	{
		$this->db->where('id',$inventory_id);
		$this->db->update('inventory',$update_to_inventory);
		return true;
	}
	
	function UpdateStock($update_store,$from_store_id)
	{
		$this->db->where('s_id',$from_store_id);
		$this->db->update('stores',$update_store);
		return true;
	}
	
	function get_store_data($from_store)
	{
		$this->db->where('s_id',$from_store);
		$query = $this->db->get('stores');
		return $query;
	}
	

	public function getProductPurchasePrice($product_code)
	{
		$this->db->where('code',$product_code);
		$query = $this->db->get('products');
		return $query->row();
	}
	
	public function getGoldItemDetailSignle($id)
	{
		$this->db->where('id',$id);
		$this->db->limit(1);
		$query = $this->db->get('order_items_gold');
		return $query->row();
	}
	

	function OutletWiseStore($outlet_id)
	{
		$this->db->select('outlet_warehouse.*,stores.s_name,stores.s_id');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
		$this->db->where('outlet_warehouse.out_id',$outlet_id);
		$query = $this->db->get();
		return $query->result();
	}
	
	function CustomerOrderList()
	{
		$this->db->select('gold_orders.*,customers.fullname as customername,outlets.name as outletsname,users.fullname as salesname,main_work_job_order.id as work_order_id,gold_smith.fullname as gold_smith_name,work_job_order_receive.id as receive_work_id');
		$this->db->from('gold_orders');
		$this->db->join('customers','customers.id = gold_orders.gold_customer_id','left');
		$this->db->join('outlets','outlets.id = gold_orders.gold_outlet_id','left');
		$this->db->join('users','users.id = gold_orders.sale_person_id','left');
		$this->db->join('main_work_job_order','main_work_job_order.customer_order_no = gold_orders.gold_id','left');
		$this->db->join('gold_smith','gold_smith.gs_id = main_work_job_order.gold_smith_id','left');
		$this->db->join('work_job_order_receive','work_job_order_receive.customer_order_no = main_work_job_order.job_order_no','left');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_created_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_created_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		if(!empty($this->input->get('status')))
		{
			$status  = $this->input->get('status') == 6 ? 0: $this->input->get('status');
			$this->db->where('gold_orders.status',$status);
		}
		
		
		$query = $this->db->get();
		return $query->result();
	}
	
	function getProduct_invertory()
	{
		$this->db->select('products.*,sub_category.sub_category as sub_category_name');
		$this->db->from('products');
		$this->db->join('inventory','inventory.product_code = products.code','left');
		$this->db->join('sub_category','sub_category.id = products.sub_category_id_fk','left');
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
			$this->db->where('products.sub_category_id_fk',$this->input->get('subcategory'));
		}
		
		$this->db->where('inventory.qty !=','0');
		$this->db->group_by('products.code');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function getProductOutlet($outlet_id)
	{
		$this->db->where('status','1');
		$this->db->where('category !=', 20);
		$this->db->where('outlet_id_fk', $outlet_id);
		$query = $this->db->get('products');
		return $query->result();
	}
	
	public function getTransformStock()
	{
		$this->db->select('store_transform.*,outlets.name as outletname, from.s_name as fromstore, to.s_name as toname,products.name,users.fullname');	
		$this->db->from('store_transform');	
		$this->db->join('outlets','outlets.id = store_transform.outlet_id','left');	
		$this->db->join('products','products.code = store_transform.product_code','left');	
		$this->db->join('users','users.id = store_transform.createdby','left');	
		$this->db->join('stores as from','from.s_id = store_transform.from_store','left');	
		$this->db->join('stores as to','to.s_id = store_transform.to_store','left');	
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(store_transform.date,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(store_transform.date,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}	
		if(!empty($this->input->get('outlet')))
		{
			$this->db->where('store_transform.outlet_id',$this->input->get('outlet'));
		}	
		if(!empty($this->input->get('product_code')))
		{
			$this->db->where('store_transform.product_code',$this->input->get('product_code'));
		}	
		
		$query = $this->db->get();	
		return $query->result();
	}
	
	public function getBulkTransaferStockDetail($id)
	{
		$this->db->select('store_transform.*,outlets.name as outletname, from.s_name as fromstore, to.s_name as toname,products.*,users.fullname');	
		$this->db->from('store_transform');	
		$this->db->join('outlets','outlets.id = store_transform.outlet_id','left');	
		$this->db->join('products','products.code = store_transform.product_code','left');	
		$this->db->join('users','users.id = store_transform.createdby','left');	
		$this->db->join('stores as from','from.s_id = store_transform.from_store','left');	
		$this->db->join('stores as to','to.s_id = store_transform.to_store','left');	
		$this->db->where('store_transform.id',$id);	
		$this->db->limit(1);	
		$query = $this->db->get();	
		return $query->row();
	}
	
	function transfer_join($table,$table1){
		$this->db->select("*");   
		$this->db->from($table);   
		$this->db->join($table1,"$table1.rjo_id=$table.trans_rjo");
		$result = $this->db->get();
		return $result->result();
	}
	
	
	function store_transfer_join($table,$table2,$table3){
		$this->db->select("*,users.fullname as fullname_gold");   
		$this->db->from($table);   

		$this->db->join($table2,"$table2.gs_id=$table.trans_goldsmith_id");
		$this->db->join($table3,"$table3.id=$table.str_user_id");
		$result = $this->db->get();
		return $result->result();
	}
	
	function select_all_order_($table_name,$field,$order){
	  	$this->db->select('*');
        $this->db->order_by($field, $order);
		$record = $this->db->get($table_name);
		return $record->result();
	}
	
	function get_record_by_id($table_name,$condition)
	{
		$message = array();
		$this->db->select('*');
		$this->db->where($condition);
		$res = $this->db->get($table_name)->row();    
		if(count($res)>0){
			$message['message'] = $res;
			$message['error'] = true;
        }
		else{
			$message['message'] = "No found data ";
			$message['error'] = false;
		}
        return $message;
	}
	
	public function getDataInventoryWise($pcode,$outlet_id,$type,$WareHouse)
	{
		$this->db->select('inventory.*,products.NetGoldWeight, products.Wastagegold, products.TotalAllOtherCost, products.category,products.sub_category_id_fk,products.grade_id,products.purchase_price,products.name as product_name,products.weight as product_weight,products.retail_price');
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
	public function getDataWork_job($receive_id)
	{
		$this->db->select('*');
		$this->db->from('work_job_order');
		$this->db->where('id',$receive_id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query;	
	}
	
	public function getOutletWiseWarehouseProduct($outlet_id,$warehouse_id,$type)
	{
		$this->db->select('inventory.*,products.name as prdocuname,products.id as product_id ');
		$this->db->from('inventory');
		$this->db->join('products','products.code = inventory.product_code');
		$this->db->where('outlet_id',$outlet_id);
		$this->db->where('ow_id',$warehouse_id);
		$this->db->where('type',$type);
		$this->db->where('products.category !=',9);
		$this->db->group_by('inventory.product_code');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	public function getInventoryqty($outlet_id,$warehouse_id,$product_code)
	{	
		$this->db->select('inventory.*,stores.*');
		$this->db->from('inventory');
		$this->db->join('outlet_warehouse','outlet_warehouse.ow_id = inventory.ow_id');
		$this->db->join('stores','stores.s_id = outlet_warehouse.w_id');
		$this->db->where('inventory.product_code',$product_code);
		$this->db->where('inventory.outlet_id',$outlet_id);
		$this->db->where('inventory.ow_id',$warehouse_id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	
	public function get_product_report_qty($product_code)
	{
		
		$this->db->limit(1);
		$this->db->order_by('id', 'DESC');
		$this->db->where('product_code',$product_code);
        $query = $this->db->get('product_report');
		return $query->row();
	}
	
	public function getgold_orders()
	{
		$this->db->limit(1);
		$this->db->order_by('gold_id', 'DESC');
        $query = $this->db->get('gold_orders');
		$number = !empty($query->row()->gold_id) ? $query->row()->gold_id : 0;
        return $number+1;
	}
	
	public function getrecevie_jobOrder()
	{
		$this->db->limit(1);
		$this->db->order_by('id', 'DESC');
        $query = $this->db->get('work_job_order_receive');
		$number = !empty($query->row()->id) ? $query->row()->id : 0;
        return $number+1;
	}

	
	public function getJobOrderNumber()
	{
		$this->db->limit(1);
		$this->db->order_by('id', 'DESC');
        $query = $this->db->get('main_work_job_order');
		$number = !empty($query->row()->id) ? $query->row()->id : 0;
        return $number+1;
	}
	
	
	
		public function getGoldSmithWiseReceive($goldsmith_id)
		{
			$this->db->select('*');
			$this->db->from('work_job_order');
			$this->db->where('gold_smith_id =',$goldsmith_id);
			$query = $this->db->get();
			return $query->result();
		}
	
		public function getMainworkjobWiseSubworkjobProduct($main_wokorder_id)
		{
			$this->db->select('work_job_order.*,order_items_gold.*,order_items_gold.id as order_item_gold_id');
			$this->db->from('work_job_order');
			$this->db->join('order_items_gold','order_items_gold.order_id = work_job_order.product_code_id');
			$this->db->where('work_job_order.job_order_no =',$main_wokorder_id);
			$query = $this->db->get();
			return $query->result();
		}
		public function DefaultgetoutletwiseStore()
		{
			$this->db->select('stores.*');
			$this->db->from('outlet_warehouse');
			$this->db->join('stores','stores.s_id = outlet_warehouse.w_id','left');
			$this->db->where('outlet_warehouse.ow_id ',1);
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}
		public function getdataorderitem($main_wokorder_id)
		{
			$this->db->select('order_items_gold.*,gold_grade.*');
			$this->db->from('order_items_gold');
			$this->db->join('gold_grade','gold_grade.grade_id = order_items_gold.gold_grade_id','left');
			$this->db->where('order_items_gold.order_id ',$main_wokorder_id);
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
		}
		public function getoutletwiseStore($outlet_id)
		{
			$this->db->select('stores.*');
			$this->db->from('outlet_warehouse');
			$this->db->join('stores','stores.s_id = outlet_warehouse.w_id','left');
			$this->db->where('out_id =',$outlet_id);
			$query = $this->db->get();
			return $query->result();
		}
	
	
		public function getworkjobOrder()
		{
			$this->db->select('main_work_job_order.*,outlets.name as outlets_name,gold_smith.fullname as gold_smith_name,customers.fullname as customer_fillname');
			$this->db->from('main_work_job_order');
			$this->db->join('outlets','outlets.id = main_work_job_order.outlet_id','left');
			$this->db->join('customers','customers.id = main_work_job_order.customer_id','left');
			$this->db->join('gold_smith','gold_smith.gs_id = main_work_job_order.gold_smith_id','left');
			if(!empty($this->input->get('start_date')))
			{
				$this->db->where('DATE_FORMAT(create_date,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
			}
			if(!empty($this->input->get('end_date')))
			{
				$this->db->where('DATE_FORMAT(create_date,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
			}
			$result = $this->db->get();

			return $result->result();
		}
		
		
		
	public function getWorkJobMainDetails($detail_id)
	{
		$this->db->select('main_work_job_order.*,outlets.name as outlets_name,outlets.address as outlets_address,outlets.contact_number as outlets_contact,gold_smith.fullname as gold_smith_name,customers.fullname as customer_fillname,customers.mobile as customer_mobile');
		$this->db->from('main_work_job_order');
		$this->db->join('outlets','outlets.id = main_work_job_order.outlet_id','left');
		$this->db->join('customers','customers.id = main_work_job_order.customer_id','left');
		$this->db->join('gold_smith','gold_smith.gs_id = main_work_job_order.gold_smith_id','left');
		$this->db->where('main_work_job_order.id',$detail_id );
		$this->db->limit(1);
		$result = $this->db->get();
		return $result->row();
	}
		
		
		
	public function getdetailvieworder($detail_id)
	{
		
		$this->db->select('work_job_order.*,order_items_gold.*,customers.fullname as customer_fillname');
		$this->db->from('work_job_order');
		$this->db->join('customers','customers.id = work_job_order.customer_id','left');
		$this->db->join('order_items_gold','order_items_gold.id = work_job_order.product_code_id','left');
		$this->db->where('work_job_order.job_order_no',$detail_id );
		$result = $this->db->get();
		return $result->result();
	}
		
	
	public function getOrderPrint($id)
	{
		$this->db->select('gold_orders.*, customers.fullname,customers.mobile,users.fullname as sales_person_name,outlets.address,outlets.contact_number,outlets.receipt_footer,outlets.name as outlet_name');
		$this->db->from('gold_orders');
		$this->db->join('customers','customers.id = gold_orders.gold_customer_id','left');
		$this->db->join('users','users.id = gold_orders.sale_person_id','left');
		$this->db->join('outlets','outlets.id = gold_orders.gold_outlet_id','left');
		$this->db->where('gold_orders.gold_id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	public function getgoldsmith_details($id)
	{
		$this->db->limit(1);
		$this->db->where('gs_id',$id);
		$query = $this->db->get('gold_smith');
		return $query->row();
	}
	public function getSales_invoiceOrderPrint($id)
	{
		$this->db->select('sales_invoice.*, customers.fullname,customers.mobile,users.fullname as sales_person_name,outlets.address,outlets.contact_number,outlets.receipt_footer,outlets.name as outlet_name');
		$this->db->from('sales_invoice');
		$this->db->join('customers','customers.id = sales_invoice.sales_customer_id','left');
		$this->db->join('users','users.id = sales_invoice.sale_person_id','left');
		$this->db->join('outlets','outlets.id = sales_invoice.sales_outlet_id','left');
		$this->db->where('sales_invoice.sales_id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
	
	
	public function getOrderItemPrint($id)
	{
		$this->db->select('order_items_gold.*');
		$this->db->from('order_items_gold');
		$this->db->where('order_items_gold.order_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function getSalesInvoiceItemPrint($id)
	{
		$this->db->select('sales_invoice_item.*');
		$this->db->from('sales_invoice_item');
		$this->db->where('sales_invoice_item.sales_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getOrderPaymentPrint($id)
	{
		$this->db->where('gold_orders_id',$id);
		$query = $this->db->get('gold_orders_payment');
		return $query->result();
	}
	public function getSalesInvoicePaymentPrint($id)
	{
		$this->db->where('sales_id',$id);
		$query = $this->db->get('sales_invoice_payment');
		return $query->result();
	}
	
	public function getGoldeGrade()
	{
		$this->db->select('gold_grade.*,users.fullname');
		$this->db->from('gold_grade');
		$this->db->join('users','users.id = gold_grade.created_by','left');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(date_created,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(date_created,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getGoldeGradeDetail()
	{
		$this->db->select('*');
		$this->db->from('gold_grade');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getGoldPriceDetail()
	{
		$this->db->select('gold_prices.*,users.fullname');
		$this->db->from('gold_prices');
		$this->db->join('users','users.id = gold_prices.created_by','left');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getSingleGrade($id)
	{
		$this->db->select('gold_grade.*,users.fullname');
		$this->db->from('gold_grade');
		$this->db->join('users','users.id = gold_grade.created_by','left');
		$this->db->where('gold_grade.grade_id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function updategrade($array_data,$id)
	{
		$this->db->where('grade_id',$id);
		$this->db->update('gold_grade',$array_data);
		return true;
	}
	
	
	public function getLastGoldeGradeDetail()
	{
		$this->db->where('grade_name',24);
		$this->db->limit(1);
		$this->db->order_by('grade_id','desc');
		$query = $this->db->get('gold_grade');
		return $query->row();
	}
	
	public function CheckValidation($gradename)
	{
		$this->db->where('grade_name',$gradename);
		$query = $this->db->get('gold_grade');
		return $query->num_rows();
	}
	
	public function getServiceProduct()
	{
//		$query = $this->db->select('products.*, category.name as category_name');
//		$query = $this->db->from('products');
//		$query = $this->db->join('category','category.id = products.category ');
		$this->db->where('products.category',9);
		$query = $this->db->get('products');
		return $query->result();
	}
	
	public function servicechangegetValue($product_id)
	{
		$this->db->where('id',$product_id);
		$this->db->limit(1);
		$query = $this->db->get('products');
		return $query->row();
	}

	# add by a3frt 04-11-17 start
	function get_current_billnumber()
	{
	    $this->db->select('sale_invoice_num,custom_order_num');
	    $this->db->order_by("id","DESC");
	    $query = $this->db->get('bill_numbering');
	    
	    return $query->result();
	}

	function get_current_billnumber_all_data($col = null,$bill_num = null)
	{
		if($col == "SI")
		{
			$col_num = "sale_invoice_num";
		}
		else if($col == "CO")
		{
			$col_num = "custom_order_num";
		}

	    $this->db->select('*');
	    $this->db->where("$col_num","$bill_num");
	    $query = $this->db->get('bill_numbering');
	    
	    return $query->result_array();
	}

	function insert_new_billnumber($data)
	{
		$this->db->insert("bill_numbering",$data);
		
		if($this->db->affected_rows()==true)
		{
			return true;
		}

		return false;

	}
	# add by a3frt 04-11-17 End


	#***********************************************************
	#       added by a3frt date 15-11-17 start
	#************************************************************

	function insert_min_sale_req($data)
	{
		$this->db->insert("price_permission_by_admin",$data);
		
		if($this->db->affected_rows()==true)
		{
			return true;
		}

		return false;
	}

	function get_req_sale_price($code = null)
	{
		$this->db->select('desire_price');
		$this->db->where('product_name_code',"$code");
		$query = $this->db->get('price_permission_by_admin');

		return $query->result();

	}

	function get_exchange_price($gold_grade_id = NULL)
	{

		$this->db->select('gp_price');
		$this->db->where('gp_grade', "$gold_grade_id");
		$query = $this->db->get('gold_prices');

		return $query->result();

	}

	function get_permission_above_price($p_name = NULL)
	{
		$this->db->select('desire_price');
		$con = array('product_name_code' => "$p_name", 'actions' => "accept");
		$this->db->where($con);
		$query = $this->db->get('price_permission_by_admin');

		return $query->result();
	}

	function insert_all_exchange_data($data = NULL)
	{
		$this->db->insert("exchange_gold",$data);
		
		if($this->db->affected_rows()==true)
		{
			return true;
		}

		return false;
	}


	#***********************************************************
	#       added by a3frt date 15-11-17 end
	#************************************************************
	
}


?>