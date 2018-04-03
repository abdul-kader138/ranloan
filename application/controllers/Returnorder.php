<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Returnorder extends CI_Controller
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Returnorder_model');
        $this->load->model('Constant_model');
        $this->load->model('Inventory_model');
        $this->load->model('Pos_model');
        
        $this->load->library('pagination');
        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();
        $setting_timezone = $settingData->timezone;
        date_default_timezone_set("$setting_timezone");
		
		if($this->session->userdata('user_id') == "")
		{
			redirect(base_url());
		}
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }

    // ****************************** View Page -- START ****************************** //

    // ****************************** View Page -- END ****************************** //

    // Create Return Order;
    public function create_return()
    {
        $permisssion_url = 'create_return';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$getDefaultCustomer = $this->Pos_model->getDefaultCustomer();
		$data['totaltax'] = $getDefaultCustomer->tax;
		$userdata					= $this->Pos_model->getUserRoll();
		$data['RollID']             = $userdata->role_id;
		$outlet_id					= $userdata->outlet_id;
		if(!empty($outlet_id))
		{
			$data['outlet_id']			= $outlet_id;
			$data['UserOutletName']		= $this->Pos_model->UserOutlet($outlet_id);	
		}
		
		$data['getDefaultCustomer'] = !empty($getDefaultCustomer->default_customer_id)?$getDefaultCustomer->default_customer_id:1;	
		$data['getAllProduct']		= $this->Pos_model->getAllProduct();
		$data['LoginUser']		    = $this->Pos_model->LoginUser();
		$data['getInvoiceNumber']   = $this->Pos_model->getInvoiceNumber();
		$data['getCustomer']	    = $this->Pos_model->getCustomer();
		$data['getPaymentMethod']   = $this->Pos_model->getPaymentMethod();
		
		$data['getOutlets']		    = $this->Constant_model->getOutlets();
		$data['getSalesReturnID']   = $this->Constant_model->getSalesReturnID();
		$this->load->view('create_return',$data);
    }

    // Confirmation Return Order;
    public function confirmation()
    {
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');

        $return_id = $this->input->get('return_id');
        $site_date_format = $siteSettingData[0]->datetime_format;
        $site_currency = $siteSettingData[0]->currency;

        $data['return_id'] = $return_id;
        $data['site_dateformat'] = $site_date_format;
        $data['site_currency'] = $site_currency;

        $this->load->view('return_confirmation', $data);
    }

    // Print Return;
    public function printReturn()
    {
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');

        $return_id = $this->input->get('return_id');
		
		
        $site_date_format = $siteSettingData[0]->datetime_format;
        $site_currency = $siteSettingData[0]->currency;

        $data['return_id'] = $return_id;
        $data['site_dateformat'] = $site_date_format;
        $data['site_currency'] = $site_currency;

		$data['getReturnSalesPrint']	 = $this->Returnorder_model->getReturnSalesPrint($return_id);
		$data['getReturnSalesItemPrint'] = $this->Returnorder_model->getReturnSalesItemPrint($return_id);
		
		
        $this->load->view('print_return', $data);
    }

    // Return Report;
    public function return_report()
    {
		$permisssion_url = 'return_report';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
     	$data['getReturnSales'] = $this->Returnorder_model->getSalesReturnData();
        $this->load->view('reports/return_report', $data);
    }
	
	public function view_sales_return_detail()
	{
		$id = $this->input->get('id');
		$data['getReturnSalesItem'] = $this->Returnorder_model->getSalesReturnItemDetail($id);
		$this->load->view('view_sales_return_detail', $data);
	}

	// ****************************** Action To Database -- START ****************************** //

    // Submit;
    public function SalesReturnInsert()
	{
//		print_r($_POST);
//		die;
//		
		$user_outlet = $this->input->post('outlet');
		$user_id = $this->session->userdata('user_id');
		$sales_return = array(
			'customer_id'			=> $this->input->post('sales_customer'),
			'outlet_id'				=> $this->input->post('outlet'),
			'returned_qty'			=> $this->input->post('sales_returned_qty'),
			'ref_bill_no'			=> $this->input->post('sales_ref_bill_no'),
			'refund_tax'			=> $this->input->post('sales_refund_tax'),
			'total_discount_amount' => $this->input->post('total_discount_amount'),
			'total_discount_percent'=> $this->input->post('total_discount_percent'),
			'subtotal'				=> $this->input->post('sales_amount_refund_amount'),
			'grandtotal'			=> $this->input->post('sales_amount_refund_amount'),
			'refund_amount'			=> $this->input->post('sales_amount_refund_amount'),
			'payment_method'		=> $this->input->post('sales_payment_type'),
			'refund_method'			=> $this->input->post('sales_refund_method'),
			'condition'				=> $this->input->post('sales_condition'),
			'remark'				=> $this->input->post('sales_reason'),
			'created_by'			=> $user_id,
			'created_at'			=> date('Y-m-d H:i:s'),
		);
		
		$order_id = $this->Constant_model->insertDataReturnLastId('sales_return', $sales_return);
		
		$pay_query = $this->Constant_model->getPaymentIDName($this->input->post('sales_payment_type'));
		$pay_balance = $pay_query->balance;
		$now_balance = $pay_balance - $this->input->post('sales_amount_refund_amount');
		$pay_data = array(
				'balance' => $now_balance,
				'updated_user_id' => $user_id,
				'updated_datetime' => date('Y-m-d H:i:s')
		);
				
		$this->db->update('payment_method', $pay_data, array('id' => $this->input->post('sales_payment_type')));
			
		$transaction_data = array(
			'trans_type'	=> 'return',
			'order_id'		=> $order_id,
			'user_id'		=> $this->input->post('sales_customer'),
			'account_number'=> $this->input->post('sales_payment_type'),
			'outlet_id'		=> $this->input->post('outlet'),
			'amount'		=> $this->input->post('sales_amount_refund_amount'),
			'bring_forword' => $pay_balance,
			'created_by'	=> $user_id,
			'created'		=> date('Y-m-d H:i:s'),
		);	
		
		$this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);	
		
		
		
		$sales = $this->input->post('item');
		foreach ($sales as $value)
		{
				$pcode			= $value['product_code'];
				$price			= $value['product_price']; 
				$qty			= $value['qty']; 
				$warehouse		= $value['warehouse']; 
				$type			= $value['type']; 
				$totalamount	= $value['sub_amount'];
				
				
				$pcodeDtaData = $this->Constant_model->getDataOneColumn('products', 'code', $pcode);
				$product_id = $pcodeDtaData[0]->id;
				$pcode_name = $pcodeDtaData[0]->name;
				$pcode_category = $pcodeDtaData[0]->category;
				$cost = $pcodeDtaData[0]->purchase_price;
				
				$ins_order_item_data = array(
					'order_id'			=> $order_id,
					'product_id'		=> $product_id,
					'product_code'		=> $pcode,
					'product_name'		=> $pcode_name,
					'product_category'	=> $pcode_category,
					'price'				=> $price,
					'qty'				=> $qty,
					'tax'				=> $value['tax'],
					'discount'			=> $value['discount'],
					'subtotal'			=> $totalamount,
					'grandtotal'		=> $totalamount,
					'ow_id'				=> $warehouse,
					'type'				=> $type,
				);
				
				$this->Constant_model->insertData('return_items', $ins_order_item_data);
				
				$ex_qty = 0;
				$ckInvData = $this->Pos_model->getDataInventory($pcode,$user_outlet,$type,$warehouse);
				if (count($ckInvData) > 0) {
					
				
					if($type == 0)
					{
						$getStore = $this->Constant_model->OutletWarehouseget($warehouse);
						$oldstore = $getStore->s_stock;
						$newstoreQty = $getStore->s_stock + $qty;
						$data_storeupdate = array(
							's_stock' => $newstoreQty,
							's_stock_upated' => $newstoreQty,
						);
						$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);
					}
					else
					{
						$outlet_id_array = $this->db->select('current_balance')->where('id',$warehouse)->get('fuel_tanks')->row_array();
						$newbalance = $outlet_id_array['current_balance'] + $qty;
						$update_inventory = array(
							'current_balance'   => $newbalance,
						);
						
						$this->Constant_model->UpdateTankBalance($update_inventory, $warehouse);
					}
					
					$ex_inv_id = $ckInvData[0]->id;
					$ex_qty = $ckInvData[0]->qty;

					$deduct_qty = 0;
					$deduct_qty = $ex_qty + $qty;

					$upd_inv_data = array(
						'qty' => $deduct_qty,
					);
					$this->Constant_model->updateData('inventory', $upd_inv_data, $ex_inv_id);
				}
		}
		
		$json['order_id'] = $order_id;
		echo json_encode($json);
	}
	

    // ****************************** Action To Database -- END ****************************** //

    public function searchProduct()
    {
        $q = $this->input->get('q');

        $array = array();

        $searchResult = $this->db->query("SELECT * FROM products WHERE code LIKE '$q%' OR name LIKE '%$q%' ");
        $searchData = $searchResult->result();

        for ($s = 0; $s < count($searchData); ++$s) {
            $search_pcode = $searchData[$s]->code;
            $search_pname = $searchData[$s]->name;

            //$search_combile 	= $search_pcode." ($search_pname)";

            $search_combile = $search_pcode;

            $array[] = $search_combile;
        }
        unset($searchResult);
        unset($searchData);

        echo json_encode($array);
    }

    public function checkPcode()
    {
        $pcode = $this->input->get('pcode');

        $ckPcodeResult = $this->db->query("SELECT * FROM products WHERE code = '$pcode' ");
        $ckPcodeRows = $ckPcodeResult->num_rows();

        if ($ckPcodeRows == 0) {
            $response = array(
                'errorMsg' => 'failure',
                'name' => '',
            );
        } else {
            $ckPcodeData = $ckPcodeResult->result();
            $ckPcode_name = $ckPcodeData[0]->name;

            $response = array(
                'errorMsg' => 'success',
                'name' => $ckPcode_name,
            );
        }
        echo json_encode($response);
    }

    // ****************************** Export to Excel -- START ****************************** //

    public function exportReturnReport()
    {
        $report = $this->input->get('report');
        $url_start = $this->input->get('start_date');
        $url_end = $this->input->get('end_date');
        $url_outlet = $this->input->get('outlet');
        $url_paid_by = $this->input->get('paid');

        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $site_dateformat = $siteSettingData[0]->datetime_format;
        $site_currency = $siteSettingData[0]->currency;

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

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Return Order Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Sale Id');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Refund By');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Refund Method');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Sub Total ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Tax ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('H2', "Grand Total ($site_currency)");

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;
        $total_sub_amt = 0;
        $total_tax_amt = 0;
        $total_grand_amt = 0;

        $start_date = $url_start.' 00:00:00';
        $end_date = $url_end.' 23:59:59';

        $paid_sort = '';
        if ($url_paid_by == '-') {
            $paid_sort = ' AND payment_method > 0 ';
        } else {
            $paid_sort = " AND payment_method = '$url_paid_by' ";
        }

        $outlet_sort = '';
        if ($url_outlet == '-') {
            $outlet_sort = ' AND outlet_id > 0 ';
        } else {
            $outlet_sort = " AND outlet_id = '$url_outlet' ";
        }

        $orderResult = $this->db->query("SELECT * FROM orders WHERE ordered_datetime >= '$start_date' AND ordered_datetime <= '$end_date' AND status = '2' $paid_sort $outlet_sort ORDER BY ordered_datetime DESC ");
        $orderRows = $orderResult->num_rows();
        if ($orderRows > 0) {
            $orderData = $orderResult->result();
            for ($od = 0; $od < count($orderData); ++$od) {
	            $order_id 		= $orderData[$od]->id;
                $order_dtm = date("$site_dateformat H:i A", strtotime($orderData[$od]->ordered_datetime));
                $outlet_id = $orderData[$od]->outlet_id;
                $subTotal = $orderData[$od]->subtotal;
                $tax = $orderData[$od]->tax;
                $grandTotal = $orderData[$od]->grandtotal;
                $pay_method_id = $orderData[$od]->payment_method;
                $cheque_numb = $orderData[$od]->cheque_number;
                $vt_status = $orderData[$od]->refund_status;

                $outlet_name = $orderData[$od]->outlet_name;
                $payment_method_name = $orderData[$od]->payment_method_name;

                $method = '';
                if ($vt_status == '1') {
                    $method = 'Full Refund';
                }
                if ($vt_status == '2') {
                    $method = 'Partial Refund';
                }

                if (!empty($cheque_numb)) {
                    $payment_method_name = $payment_method_name." (Cheque No. : $cheque_numb)";
                }

                $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$order_dtm");
                $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$order_id");
                $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$outlet_name");
                $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$payment_method_name");
                $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$method");
                $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$subTotal");
                $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$tax");
                $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$grandTotal");

                $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
                $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
                $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
                $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
                $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
                $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
                $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);
                $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($account_value_style_header);

                $total_sub_amt += $subTotal;
                $total_tax_amt += $tax;
                $total_grand_amt += $grandTotal;

                unset($order_dtm);
                unset($outlet_id);
                unset($subTotal);
                unset($tax);
                unset($grandTotal);
                unset($pay_method_id);

                ++$jj;
            }
            unset($orderData);
        }
        unset($orderResult);
        unset($orderRows);

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:E$jj");
        $objPHPExcel->getActiveSheet()->setCellValue("A$jj", 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$total_sub_amt");
        $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$total_tax_amt");
        $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$total_grand_amt");

        $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Return_order_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    // ****************************** Export to Excel -- END ****************************** //
}
