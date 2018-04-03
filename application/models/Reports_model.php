<?php
class Reports_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
	
	
	public function getTotalSalesAllData()
	{
		$this->db->select('SUM(price) AS totalsales, SUM(qty) AS totalqty,SUM(cost) AS totalcost, SUM(tax_amount) as totaltax, SUM(discount_amount) as total_discount_amount');
		$this->db->from('order_items_gold');
		$query = $this->db->get();
		return $query->row();
	}
	
	public function fetch_credit_data()
	{
		$this->db->select('orders_payment.*,customers.credit_amount,outlets.name as outletname');
		$this->db->from('orders_payment');
		$this->db->join('customers','customers.id = orders_payment.customer_id','left');
		$this->db->join('outlets','outlets.id = orders_payment.outlet_id','left');
	    $this->db->where_in('orders_payment.payment_method_name', array('Debit / Credit Sales','Vouchers'));
	    $this->db->where('orders_payment.paid_amt !=', 0);
		if (!empty($this->input->get('start_date'))) 
		{
            $this->db->where('DATE_FORMAT(orders_payment.ordered_datetime,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
        }
        if (!empty($this->input->get('end_date'))) 
		{
            $this->db->where('DATE_FORMAT(orders_payment.ordered_datetime,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
        }
        $query = $this->db->get();
        $result = $query->result();
        return $result;
	}
	public function getCustomerInvoiceList()
	{
		$this->db->select('gold_orders.*,outlets.name as outletname,customers.fullname as customer_name');
		$this->db->from('gold_orders');
		$this->db->join('customers','customers.id = gold_orders.gold_customer_id','left');
		$this->db->join('outlets','outlets.id = gold_orders.gold_outlet_id','left');
		if (!empty($this->input->get('custmoer_invoice'))) 
		{
            $this->db->where('gold_orders.gold_id', $this->input->get('custmoer_invoice'));
        }
		if (!empty($this->input->get('getoutlet'))) 
		{
            $this->db->where('gold_orders.gold_outlet_id', $this->input->get('getoutlet'));
        }
		if (!empty($this->input->get('customer_id'))) 
		{
            $this->db->where('gold_orders.gold_customer_id', $this->input->get('customer_id'));
        }
		if (!empty($this->input->get('start_date'))) 
		{
            $this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
        }
        if (!empty($this->input->get('end_date'))) 
		{
            $this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
        }
        $query = $this->db->get();
		if(!empty($_GET))
		{
			$result = $query->result();
		}
		else
		{
			$result	=array();
		}
        return $result;
	}
	
	
	public function getcustomer_invoicePrint($id)
	{
		$this->db->select('gold_orders.*, customers.fullname as customer_name,customers.mobile as customer_mob,customers.address as customer_addre,users.fullname as sales_person_name,outlets.address,outlets.contact_number,outlets.receipt_footer,outlets.name as outlet_name');
		$this->db->from('gold_orders');
		$this->db->join('customers','customers.id = gold_orders.gold_customer_id','left');
		$this->db->join('users','users.id = gold_orders.sale_person_id','left');
		$this->db->join('outlets','outlets.id = gold_orders.gold_outlet_id','left');
		$this->db->where('gold_orders.gold_id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}
	public function getcustome_invoice_itemPrint($id)
	{
		$this->db->select('order_items_gold.*');
		$this->db->from('order_items_gold');
		$this->db->where('order_items_gold.order_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function getcustomer_invoice_payment($id)
	{
		$this->db->where('gold_orders_id',$id);
		$query = $this->db->get('gold_orders_payment');
		return $query->result();
	}
	
	
	public function getMainTablePayment($id)
	{
		$this->db->select('orders_payment.*');
		$this->db->from('orders_payment');
		$this->db->where('id',$id);
		$this->db->limit(1);
		$query = $this->db->get();
        $result = $query->row();
        return $result;
	}
	
	
	public function outstanding_received_detail($id)
	{
		$this->db->select('transactions.*,payment_method.name as paymentname');
		$this->db->from('transactions');
		$this->db->join('payment_method','payment_method.id = transactions.account_number','left');
		$this->db->where('transactions.order_payment_id', $id);
        $query = $this->db->get();
        return $query->result();
	}


	public function getWarehosueDetail($ow_id)
	{
		$this->db->select('outlet_warehouse.*,stores.s_name');
		$this->db->from('outlet_warehouse');
		$this->db->join('stores','stores.s_id=outlet_warehouse.w_id');
		$this->db->where('outlet_warehouse.ow_id',$ow_id);
		$this->db->limit(1);
		$query = $this->db->get();
		return !empty($query->row()->s_name)?$query->row()->s_name:'';
	}
	

	
	public function getInventoryDetail($code)
	{
		$this->db->where('product_code',$code);
		$this->db->where('qty !=',0);
		$query = $this->db->get('inventory');
		return $query->result();
	}
	
	public function getProductReportData()
	{
		$this->db->select('products.*,outlets.name as outletname,suppliers.name as suppliers_name');
		$this->db->from('products');
		$this->db->join('outlets', 'outlets.id = products.outlet_id_fk', 'left');
		$this->db->join('suppliers', 'suppliers.id = products.supplier_id_fk', 'left');
		if (!empty($this->input->get('start_date'))) {
            $this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
        }
		
        if (!empty($this->input->get('end_date'))) {
            $this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
        }
		
		$query = $this->db->get();
		return $query->result();
	}

	public function getProductReportDataReport()
	{
		$this->db->select('product_report.*,outlets.name as outletname,suppliers.name as suppliers_name,products.outlet_id_fk,products.product_type,products.product_add_from,products.name');
		$this->db->from('product_report');
		$this->db->join('products', 'products.code = product_report.product_code', 'left');
		$this->db->join('outlets', 'outlets.id = products.outlet_id_fk', 'left');
		$this->db->join('suppliers', 'suppliers.id = products.supplier_id_fk', 'left');
		if (!empty($this->input->get('start_date'))) {
            $this->db->where('DATE_FORMAT(product_report.created_date,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
        }
		
        if (!empty($this->input->get('end_date'))) {
            $this->db->where('DATE_FORMAT(product_report.created_date,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
        }
		$this->db->order_by('product_report.id','ASC');
		$query = $this->db->get();

		// echo $this->db->last_query(); exit();
		return $query->result();
	}
	
	
	public function TodayAllQty($product_code)
	{
		$today = date('Y-m-d');
		$this->db->select('sum(product_report.purchase_qty) as TotalPurchaseQty, sum(sales_qty) as totalSaleQty, sum(bonusqty) as totalBonusqty,sum(product_report.purchase_wt) as TotalPurchaseWt, sum(sales_wt) as totalSaleWt, sum(bonus_wt) as totalBonuswt');
		$this->db->from('product_report');
		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')) )
		{
			$this->db->where('DATE_FORMAT(product_report.created_date,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
			$this->db->where('DATE_FORMAT(product_report.created_date,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		else
		{
			$this->db->where('DATE_FORMAT(product_report.created_date,"%Y-%m-%d")',$today);
		}
		$this->db->where('product_report.product_code',$product_code);
		$query = $this->db->get();
		return $query->row();
	}
	
	public function LastTotalBalance($code)
	{
		$get_product_report = $this->db->select('*');
		$get_product_report = $this->db->from('product_report');
		$get_product_report = $this->db->where('product_code',$code);
		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')) )
		{
			$this->db->where('DATE_FORMAT(created_date,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
			$this->db->where('DATE_FORMAT(created_date,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$get_product_report = $this->db->order_by('id','desc');
		$get_product_report = $this->db->limit('1');
		$get_product_report = $this->db->get()->row();
		return !empty($get_product_report->balance_qty)?$get_product_report->balance_qty:0;
	}

	public function LastTotalBalanceWt($code)
	{
		$get_product_report = $this->db->select('*');
		$get_product_report = $this->db->from('product_report');
		$get_product_report = $this->db->where('product_code',$code);
		if(!empty($this->input->get('start_date')) && !empty($this->input->get('end_date')) )
		{
			$this->db->where('DATE_FORMAT(created_date,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
			$this->db->where('DATE_FORMAT(created_date,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$get_product_report = $this->db->order_by('id','desc');
		$get_product_report = $this->db->limit('1');
		$get_product_report = $this->db->get()->row();
		return !empty($get_product_report->balance_wt)?$get_product_report->balance_wt:0;
	}
	
	
	
	
//	public function getProductReportData()
//	{
//		$this->db->select('purchase_order.outlet_id,purchase_order.supplier_name,purchase_order.created_datetime,purchase_order_items.product_code, SUM(purchase_order_items.ordered_qty) AS purchasesQty,outlets.name as outletname,products.name as product_name');
//		$this->db->from('purchase_order');
//		$this->db->join('purchase_order_items', 'purchase_order_items.po_id = purchase_order.id');
//		$this->db->join('outlets', 'outlets.id = purchase_order.outlet_id', 'left');
//		$this->db->join('products', 'products.code = purchase_order_items.product_code','left');
//		if (!empty($this->input->get('start_date'))) {
//            $this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
//        }
//        if (!empty($this->input->get('end_date'))) {
//            $this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
//        }
//		$this->db->group_by('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d")');
//		$this->db->group_by('purchase_order_items.product_code');
//		$query = $this->db->get();
//		return $query->result();
//	}
	
//	public function getYesterdayPurchaseQty($created_datetime, $product_code)
//	{
//		$today = date('Y-m-d',strtotime($created_datetime));
//		$yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today)));
//		
//		$this->db->select('SUM(purchase_order_items.ordered_qty) AS yesterdayPurchaseQty');
//		$this->db->from('purchase_order');
//		$this->db->join('purchase_order_items', 'purchase_order_items.po_id = purchase_order.id');
//		if (!empty($this->input->get('start_date'))) {
//            $this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
//        }
//        if (!empty($this->input->get('end_date'))) {
//            $this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
//        }
//		$this->db->where('DATE_FORMAT(purchase_order.created_datetime,"%Y-%m-%d")',$yesterday);
//		$this->db->where('purchase_order_items.product_code',$product_code);
//		$query = $this->db->get();
//		return !empty($query->row()->yesterdayPurchaseQty)?$query->row()->yesterdayPurchaseQty:0;
//		
//	}



//	public function getProductReportSoldQty($created_datetime,$product_code)
//	{
//		
//		$this->db->select('SUM(qty) as totalSoldQty');
//		$this->db->from('orders');
//		$this->db->join('order_items', 'order_items.order_id = orders.id');
//		$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d")',date('Y-m-d',strtotime($created_datetime)));
//		$this->db->where('order_items.product_code',$product_code);
//		if (!empty($this->input->get('start_date'))) {
//            $this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
//        }
//        if (!empty($this->input->get('end_date'))) {
//            $this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
//        }
//		$query = $this->db->get();
//		return !empty($query->row()->totalSoldQty)?$query->row()->totalSoldQty:0;
//	}
//	public function getYesterdaySoldQty($created_datetime,$product_code)
//	{
//		$today = date('Y-m-d',strtotime($created_datetime));
//		$yesterday = date('Y-m-d', strtotime('-1 day', strtotime($today)));
//		$this->db->select('SUM(qty) as yesterdaySoldQty');
//		$this->db->from('orders');
//		$this->db->join('order_items', 'order_items.order_id = orders.id');
//		$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d")',$yesterday);
//		$this->db->where('order_items.product_code',$product_code);
//		if (!empty($this->input->get('start_date'))) {
//            $this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
//        }
//        if (!empty($this->input->get('end_date'))) {
//            $this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
//        }
//		$query = $this->db->get();
//		return !empty($query->row()->yesterdaySoldQty)?$query->row()->yesterdaySoldQty:0;
//	}
	
	
	public function getSalesReport()
	{
		$this->db->select('orders_payment.*');
		$this->db->from('orders_payment');
		if(!empty($this->input->get('payment_type')))
		{
			$this->db->where('orders_payment.payment_method',$this->input->get('payment_type'));
		}
		if(!empty($this->input->get('outlet')))
		{
			$this->db->where('orders_payment.outlet_id',$this->input->get('outlet'));
		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(orders_payment.ordered_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(orders_payment.ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getSalesReportNew()
	{
		$this->db->select('gold_orders.*,o.product_code, o.product_name,o.weight, customers.fullname');
		$this->db->from('gold_orders');
		$this->db->join('order_items_gold as o', 'gold_orders.gold_id = o.order_id', 'left');
		$this->db->join('customers', 'customers.id = gold_orders.gold_customer_id', 'left');
		
		
//		if(!empty($this->input->get('payment_type')))
//		{
//			$this->db->where('orders.payment_method',$this->input->get('payment_type'));
//		}
//		if(!empty($this->input->get('outlet')))
//		{
//			$this->db->where('orders.outlet_id',$this->input->get('outlet'));
//		}
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
                
//		$this->db->where('gold_orders.status','0');
		$this->db->group_by('gold_orders.gold_id');
		$this->db->order_by('gold_orders.gold_id','ASC');
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function getSalesReportById()
	{
		$this->db->select('order_items_gold.*, o.gold_ordered_datetime, o.gold_outlet_name');
		$this->db->from('order_items_gold');
		$this->db->join('gold_orders as o', 'order_items_gold.order_id = o.gold_id');
		$this->db->where('order_items_gold.order_id',$this->input->get('id'));
//		$this->db->where('order_items_gold.status','0');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getSalesPerson()
	{
		$this->db->select('*');
		$this->db->from('users');
		$query = $this->db->get();
		return $query->result();
	}
	public function getgoldsimthReport()
	{
		$this->db->select('*');
		$this->db->from('gold_smith');
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getoutletgoldsimth()
	{
		$query = $this->db->get('outlets');
		return $query->result();
	}
	
	public function getgoldsmith_pay_transation()
	{
		$this->db->select('gold_orders.*,customers.fullname,outlets.name as outlet_name,users.fullname as sales_person_name');
		$this->db->from('gold_orders');
		$this->db->join('customers', 'customers.id = gold_orders.gold_customer_id','left');
		$this->db->join('users', 'users.id = gold_orders.sale_person_id','left');
		$this->db->join('outlets', 'outlets.id = gold_orders.gold_outlet_id','left');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
		
	}
	public function getgoldsmithAddWeight()
	{
		$this->db->select('work_job_order.*,outlets.name as oultlet_name,gold_smith.fullname as gold_smith_name,gold_smith.opening_gold_qty as gold_smith_opening_qty');
		$this->db->from('work_job_order');
		$this->db->join('gold_smith', 'gold_smith.gs_id = work_job_order.gold_smith_id','left');
		$this->db->join('outlets', 'outlets.id = work_job_order.outlet_id','left');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(work_job_order.create_date,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(work_job_order.create_date,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		if(!empty($this->input->get('gold_simth')))
		{
			$this->db->where('work_job_order.gold_smith_id',$this->input->get('gold_simth'));
		}
		$query = $this->db->get();
		return $query->result();
		
	}
	
	public function getSalesOrder()
	{
		$this->db->select('gold_orders.*,customers.fullname,outlets.name as outlet_name,users.fullname as sales_person_name');
		$this->db->from('gold_orders');
		$this->db->join('customers', 'customers.id = gold_orders.gold_customer_id','left');
		$this->db->join('users', 'users.id = gold_orders.sale_person_id','left');
		$this->db->join('outlets', 'outlets.id = gold_orders.gold_outlet_id','left');
		if(!empty($this->input->get('start_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") >=',date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{
			$this->db->where('DATE_FORMAT(gold_orders.gold_ordered_datetime,"%Y-%m-%d") <=',date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getCategoryReportOutlet($outlet_id_fk)
	{
		$this->db->select('*');
		$this->db->from('outlets');
		$this->db->where_in('id', explode(",", $outlet_id_fk));
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getCategoryProductReport()
	{
//		$this->db->select('category.*,avg(products.purchase_price) as purchase_price,SUM(inventory.qty) as totalQty, group_concat(products.outlet_id_fk) as outlet_id_fk');
//		$this->db->from('category');
//		$this->db->join('products','products.category = category.id','left');
//		$this->db->join('inventory','inventory.product_code = products.code','left');
//		$this->db->where('category.status','1');
//		if(!empty($this->input->get('start_date')))
//		{	
//			$this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
//		}
//		if(!empty($this->input->get('end_date')))
//		{	
//			$this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
//		}
//		if(!empty($this->input->get('cid')))
//		{	
//			$this->db->where('products.category',$this->input->get('cid'));
//		}
//		$this->db->group_by('category.id');
//		$query = $this->db->get();
		
		$subquery = '';
		if(!empty($this->input->get('start_date')))
		{	
			
			$subquery.= " AND DATE_FORMAT(products.created_datetime,'%Y-%m-%d') >= ".date('Y-m-d',strtotime($this->input->get('start_date')))." ";
		}
		if(!empty($this->input->get('end_date')))
		{	
			$subquery.= " AND DATE_FORMAT(products.created_datetime,'%Y-%m-%d') <= ".date('Y-m-d',strtotime($this->input->get('end_date')))." ";
		}
		
		$query =  $this->db->query('select id, name, created_user_id, created_datetime, updated_user_id,updated_datetime,status, SUM(purchase_price) as purchase_price ,SUM(totalQty) as totalQty, SUM(totalvalue) as productvalue, outlet_id_fk 
	FROM (
	SELECT `category`.*, products.purchase_price as purchase_price, inventory.qty as totalQty, products.outlet_id_fk as outlet_id_fk, (products.purchase_price * inventory.qty) as totalvalue
	FROM `category` 
	LEFT JOIN `products` ON `products`.`category` = `category`.`id` 
	LEFT JOIN `inventory` ON `inventory`.`product_code` = `products`.`code` WHERE `category`.`status` = 1 '.$subquery.') as a group by id');
//	print_r($this->db->last_query());
//	die;
		return $query->result();
	}
	
	public function getOutletProductReport()
	{
//		$this->db->select('outlets.*,avg(products.purchase_price) as purchase_price,SUM(inventory.qty) as totalQty');
//		$this->db->from('outlets');
//		$this->db->join('products','products.outlet_id_fk = outlets.id','left');
//		$this->db->join('inventory','inventory.product_code = products.code','left');
//		$this->db->where('outlets.status','1');
//		if(!empty($this->input->get('start_date')))
//		{	
//			$this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
//		}
//		if(!empty($this->input->get('end_date')))
//		{	
//			$this->db->where('DATE_FORMAT(products.created_datetime,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
//		}
//		if(!empty($this->input->get('outlet')))
//		{	
//			$this->db->where('products.outlet_id_fk',$this->input->get('outlet'));
//		}
//		$this->db->group_by('outlets.id');
//		$query = $this->db->get();
		
		
		
		$subquery = '';
		if(!empty($this->input->get('start_date')))
		{	
			$subquery.= " AND DATE_FORMAT(products.created_datetime,'%Y-%m-%d') <= ".date('Y-m-d',strtotime($this->input->get('start_date')))." ";
		}
		if(!empty($this->input->get('end_date')))
		{	
			$subquery.= " AND DATE_FORMAT(products.created_datetime,'%Y-%m-%d') <= ".date('Y-m-d',strtotime($this->input->get('end_date')))." ";
		}

		$query =  $this->db->query('SELECT id, name, store_id, address, contact_number, receipt_header, receipt_footer,	created_user_id, created_datetime, updated_user_id, 	updated_datetime, status, SUM(qty) as totalQty, SUM(totalvalue) AS totalvalue  FROM (SELECT `outlets`.*, products.purchase_price as purchase_price, inventory.qty , (products.purchase_price * inventory.qty) as totalvalue
									FROM `outlets` 
									LEFT JOIN `products` ON `products`.`outlet_id_fk` = `outlets`.`id` 
									LEFT JOIN `inventory` ON `inventory`.`product_code` = `products`.`code` WHERE `outlets`.`status` = 1 '.$subquery.') as a group by id');
		
		return $query->result();	
	}
	
	

	
	
	public function ProductSalesItemReport()
	{
		$this->db->select('order_items.*,orders.outlet_name,orders.outlet_id,orders.created_at,orders.id');
		$this->db->from('order_items');
		$this->db->join('orders','orders.id = order_items.order_id','left');
		if(!empty($this->input->get('start_date')))
		{	
			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{	
			$this->db->where('DATE_FORMAT(orders.created_at,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		if(!empty($this->input->get('product_code')))
		{	
			$this->db->where('order_items.product_code', $this->input->get('product_code'));
		}
		if(!empty($this->input->get('product_name')))
		{	
			$this->db->where('order_items.product_name', $this->input->get('product_name'));
		}
		if(!empty($this->input->get('outlet')))
		{	
			$this->db->where('orders.outlet_id', $this->input->get('outlet'));
		}
                $this->db->where('order_items.status','0');
		$this->db->order_by('order_items.id','desc');
		$query = $this->db->get();
		return $query->result();	
	}
	
	public function ProductBatchExpiry()
	{
		$this->db->select('batch_expire_multi.id as batch_expiry_id,inventory.qty,inventory.type,inventory.ow_id,products.outlet_id_fk,products.supplier_id_fk,suppliers.name as suppliers_name,batch_expire_multi.*,inventory.product_code,products.name as productname,category.name as categoryname,brand.brand as brandname');
		$this->db->from('batch_expire_multi');
		$this->db->join('inventory','inventory.id = batch_expire_multi.inventory_id','left');
		$this->db->join('products','products.code = inventory.product_code','left');
		$this->db->join('suppliers','suppliers.id = products.supplier_id_fk','left');
		$this->db->join('category','category.id = products.category','left');
		$this->db->join('brand','brand.id = products.brand_id_fk','left');
		if(!empty($this->input->get('start_date')))
		{	
			$this->db->where('DATE_FORMAT(batch_expire_multi.created_date,"%Y-%m-%d") >=', date('Y-m-d',strtotime($this->input->get('start_date'))));
		}
		if(!empty($this->input->get('end_date')))
		{	
			$this->db->where('DATE_FORMAT(batch_expire_multi.created_date,"%Y-%m-%d") <=', date('Y-m-d',strtotime($this->input->get('end_date'))));
		}
		$query = $this->db->get();
		return $query->result();
	}
	
	public function getViewPurchaseReturn($batchid)
	{
		$this->db->select('users.fullname,purchase_return.*, payment_method.name as payment_method_name,suppliers.name as suppliers_name, outlets.name as outlets_name, products.name as product_name');	
		$this->db->from('purchase_return');	
		$this->db->join('outlets','outlets.id = purchase_return.outlet_id','left');	
		$this->db->join('products','products.code = purchase_return.product_code','left');	
		$this->db->join('suppliers','suppliers.id = purchase_return.supplier_id','left');	
		$this->db->join('payment_method','payment_method.id = purchase_return.payment_type','left');	
		$this->db->join('users','users.id = purchase_return.created_by','left');	
		$this->db->where('purchase_return.batch_expiry_id',$batchid);
		$query = $this->db->get();
		return $query->result();
	}
	
	
}
