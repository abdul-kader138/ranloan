<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Debit extends CI_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Debit_model');
        $this->load->model('Constant_model');
        $this->load->model('Customers_model');
        $this->load->model('bdt_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;
		
        date_default_timezone_set("$setting_timezone");
		
		if(empty($this->session->userdata('user_id')))
		{
			redirect(base_url());
		}
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }
	
	public function debit_print()
	{
		$id	= $this->input->get('id');
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		$data['result'] = $this->Debit_model->getDebitPrint($id);
		$this->load->view('debit_print', $data);
	}
			
	

    public function searchDebit()
    {
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;

        if ($setting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($setting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($setting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($setting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($setting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($setting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($setting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($setting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($setting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }

        $data['dateformat'] = $dateformat;
        $data['display_dateformat'] = $setting_dateformat;

        $this->load->view('debit_search', $data);
    }

    // ****************************** View Page -- START ****************************** //

    // View Product Category;
    public function view()
    {
		$permisssion_url = 'debit';
        $permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		$permission_re_id=$permission->resource_id;
		$permisssion_sub_url = 'view';
		$permissionsub = $this->Constant_model->getPermissionSubPageWise($permission_re_id,$permisssion_sub_url);
               
		if($permissionsub->view_menu_right == 0)
		{
			redirect('dashboard');
		}
        
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;

        if ($setting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($setting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($setting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($setting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($setting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($setting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($setting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($setting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($setting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }
		
		$data['getCreditColor'] = $this->Constant_model->getCreditColor();
		$data['results'] = $this->Debit_model->fetch_debit_data();
	    $data['dateformat'] = $dateformat;
        $data['display_dateformat'] = $setting_dateformat;
		$this->load->view('debit', $data);
    }

    // Make Payment;
    public function make_payment()
    {
        $id					= $this->input->get('id');
        $paginationData		= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit	= $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;
		$loginUserId		= $this->session->userdata('user_id');
		$loginData			= $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
		$data['UserLoginName'] = @$loginData[0]->fullname;
        $data['id'] = $id;
		
		
		$data['result_payment']	  = $this->Debit_model->getPaymentDataOrder($id);
		$outlet_id = $data['result_payment']->outlet_id;
		$data['getPaymentMethod'] = $this->Constant_model->getOutletWisePaymentMethod($outlet_id);
		$data['dateformat'] = $setting_dateformat;
		$data['bank_account'] = $this->bdt_model->getBankAccountNumber();
        $this->load->view('debit_make_payment', $data);
    }
	
	public function Payment_Submit()
    {
		$user_id		= $this->session->userdata('user_id');
		$today			= date('Y-m-d H:i:s', time());
		
		$orderid		  = $this->input->post('orderid');
		$customer_id	  = $this->input->post('customer_id');
		$customer_name    = $this->input->post('customer_name');
		$outlet_id		  = $this->input->post('outlet_id');
		$outlet_name	  = $this->input->post('outlet_name');
		$payment		  = $this->input->post('payment');
		$total_amount	  = $this->input->post('total_amount');
		$grand_amount	  = $this->input->post('grand_amount');
		$unpaid_amount	  = $grand_amount - $total_amount;
		$us_id = $this->session->userdata('user_id');
        $tm    = date('Y-m-d H:i:s', time());
		
		
		if($total_amount > $grand_amount)
		{
			$deposite = $this->Customers_model->getCustomerDeposite($customer_id);
			$customerdeposite = $total_amount - $grand_amount;
			$finaldeposite = $deposite +  $customerdeposite;
			$deposite = $this->Customers_model->UpdateDeposite($finaldeposite,$customer_id);
			$total_amount = $grand_amount;
			$unpaid_amount	= 0;
		}
		
		
		$order_row = $this->db->get_where('gold_orders_payment', array(
            'id' => $orderid
        ))->row();
		
        $get_grandtotal  = $order_row->paid_amt;
		
		$update_order_id = array(
            'paid_amt' => $total_amount+$get_grandtotal,
            'unpaid_amt' => $unpaid_amount,
        );
		
        $this->db->update('gold_orders_payment', $update_order_id, array(
            'id' => $orderid
        ));
		
		foreach ($payment as $value)
		{
			$paid_amt       = $value['paid'];
			$payment_method = $value['paid_by'];
            
			$pay_query   = $this->db->get_where('payment_method', array(
                    'id' => $payment_method
            ))->row();
			
			$pay_balance = $pay_query->balance;
			$now_balance = $pay_balance + $paid_amt;
			$pay_data    = array(
				'balance' => $now_balance,
				'updated_user_id' => $us_id,
				'updated_datetime' => $tm
			);
			
			$this->db->update('payment_method', $pay_data, array(
					'id' => $payment_method
            ));
			
			$transaction_data = array(
				'trans_type'		=> 'dep',
				'order_payment_id'	=> $orderid,
				'outlet_id'			=> $outlet_id,
				'user_id'			=> $customer_id,
				'amount'			=> $paid_amt,
				'bring_forword'		=> $pay_balance,
				'account_number'	=> $payment_method,
				'created_by'		=> $user_id,
				'cheque_number'		=> $value['cheque'],
				'cheque_date'		=> !empty($value['cheque_date'])?date('Y-m-d', strtotime($value['cheque_date'])):'',
				'bank'				=> $value['bank'],
				'card_number'		=> $value['addi_card_numb'],
				'created'			=> $today
			);	
			$res1 = $this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);	
			    
			if ($res1) {
				$response = array(
					'status' => 1,
					'message' => 'Your Payment successfully saved!!'
				);
			}
			else 
			{
				$response = array(
					'status' => 0,
					'message' => 'Due to some error please try again !!'
				);
			}
        }
		echo json_encode($response);
    }
		

    // Export Debit;
    public function exportDebit()
    {
        $paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;

        $this->load->library('excel');

        require_once './application/third_party/PHPExcel.php';
        require_once './application/third_party/PHPExcel/IOFactory.php';

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        $default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000'),
        );

        $acc_default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => 'c7c7c7'),
        );
        $outlet_style_header = array(
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 10,
                'name' => 'Arial',
                'bold' => true,
            ),
        );
        $top_header_style = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff03'),
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 15,
                'name' => 'Arial',
                'bold' => true,
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff03'),
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
                'bold' => true,
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $account_value_style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $text_align_style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff03'),
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
                'bold' => true,
            ),
        );

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Debit Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Sale Id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Date');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet Name');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Customer');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Grand Total');

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;

        $total_amt = 0;

        $orderResult = $this->db->query("SELECT * FROM orders WHERE vt_status = '0' ORDER BY id DESC ");
        $orderData = $orderResult->result();

        for ($d = 0; $d < count($orderData); ++$d) {
            $order_id = $orderData[$d]->id;
            $cust_name = $orderData[$d]->customer_name;
            $order_date = date("$setting_dateformat", strtotime($orderData[$d]->ordered_datetime));
            $outlet_name = $orderData[$d]->outlet_name;
            $grandTotal = $orderData[$d]->grandtotal;

            $total_amt += $grandTotal;

            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$order_id");
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$order_date");
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$outlet_name");
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$cust_name");
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$grandTotal");

            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);

            unset($order_id);
            unset($cust_name);
            unset($order_date);
            unset($outlet_name);
            unset($grandTotal);

            $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(20);

            ++$jj;
        }
        unset($orderResult);
        unset($orderData);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:D$jj");
        $objPHPExcel->getActiveSheet()->setCellValue("A$jj", 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$total_amt");

        $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Debit_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
