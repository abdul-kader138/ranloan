<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('Constant_model');
        
    }

 	public function cron_product_report()
    {
        $product_entry = $this->Constant_model->getProduct();
		foreach ($product_entry as $value)
		{
			$product_report = array(
					'product_code'	=> $value->code,
					'opening_qty'	=> $value->start_qty,
					'purchase_qty'	=> 0,
					'sales_qty'		=> 0,
					'balance_qty'   => $value->start_qty,
					'created_by'	=> $this->session->userdata('user_id'),
					'created_date'	=> date('Y-m-d H:i:s'),
				);
			$this->Constant_model->insertDataReturnLastId('product_report', $product_report);
		}
    }
	
}
