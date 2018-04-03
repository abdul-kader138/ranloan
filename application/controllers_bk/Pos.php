<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pos extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Pos_model');
        $this->load->model('Constant_model');
        
        $this->load->library('pagination');
        $this->load->helper('email');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();
        $setting_timezone = $settingData->timezone;
        date_default_timezone_set("$setting_timezone");
		if ($this->session->userdata('user_id') == "") {
			redirect(base_url());
		}
    }

	

	
	public function getOutletWiseTankWarehouse()
	{
		
		$default_store = $this->Pos_model->getDefaultCustomer();
		$default_store_id = $default_store->default_store_id;
		$html = '';
		$outlet_id = $this->input->post('outlet_id');
		$getOutletWisePaymentMethod = $this->Constant_model->getOutletWisePaymentMethod($outlet_id);
		$warehouse = $this->Constant_model->getOutletWareHouse($outlet_id);
		$role_id = $this->session->userdata('user_role');
		if($role_id == 3)
		{
			foreach ($warehouse as $ware)
			{
				$selected = '';
				if($default_store_id == $ware->w_id)
				{
					$selected = 'selected'; 
					$html.= '<option '.$selected.' data-val="0" value='.$ware->ow_id.'>'.$ware->s_name.'</option>';
				}
			}
		}
		else
		{
			$html.= '<option value="">Select Warehouse / Tank</option>';
			foreach ($warehouse as $ware)
			{
				$selected = '';
				if($default_store_id == $ware->w_id)
				{
					$selected = 'selected'; 
				}
				$html.= '<option '.$selected.' data-val="0" value='.$ware->ow_id.'>'.$ware->s_name.'</option>';
			}
			
		}
		
		
		$payment = '';
		
		foreach ($getOutletWisePaymentMethod as $payment_outlet) {
			$payment .= "<option value='".$payment_outlet->id."' >".$payment_outlet->name."</option>";
		}
		
		$json['payment'] = $payment;
		$json['success'] = $html;
		echo json_encode($json);
	}
	
	function getOutletWiseWarehouseProduct()
	{
		$wareid		= $this->input->post('wareid'); 
		$outlet_id	= $this->input->post('outlet_id'); 
		$productdata = $this->Pos_model->getOutletWiseWarehouseProduct($outlet_id,$wareid);
		$product = '';
		$product .= '<option value="" >Select Product by Name or Code</option>';
		foreach ($productdata as $pro)
		{
			$product .= "<option value='".$pro->product_code."'>".$pro->prdocuname." [".$pro->product_code."]</option>";
		}
		$json['product'] = $product;
		echo json_encode($json);
	}
	
	public function getProductDetailInventory()
	{
		$json = array();
		$pcode			= $this->input->post('product_code');
		$outlet_id		= $this->input->post('outlet_id');
		$warehouse_tank = $this->input->post('warehouse_tank');
		$inventory		= $this->Pos_model->getDataInventoryWise($pcode,$outlet_id,$warehouse_tank);
		if($inventory->num_rows() > 0)
		{
			$json['balance_stock']		= $inventory->row()->qty;
			$json['product_name_code']  = $inventory->row()->product_name;
			$json['product_price']		= $inventory->row()->retail_price;
			$json['batch_no']			= $inventory->row()->batch_no;
			$json['product_code']		= $inventory->row()->product_code;
		}
		else
		{
			$json['balance_stock']		= 0;
			$json['product_name_code']  = '';	
			$json['product_price']		= 0;
			$json['batch_no']			= '';
			$json['product_code']		= '';
		}
		echo json_encode($json);
	}
	
}
