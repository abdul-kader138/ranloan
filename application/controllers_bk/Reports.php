<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Reports extends CI_Controller
{
    public function __construct()
    {
		parent::__construct();
        $this->load->library('session');
        $this->load->model('Reports_model');
        $this->load->model('Constant_model');
        $this->load->model('Inventory_model');
        
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

    public function sales_report()
    {
		$permisssion_url = 'sales_report';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);

		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
        $siteSettingData		= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency	= $siteSettingData[0]->currency;
        if ($siteSetting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($siteSetting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($siteSetting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($siteSetting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($siteSetting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($siteSetting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($siteSetting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($siteSetting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($siteSetting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }
		
		$data['site_dateformat']	= $siteSetting_dateformat;
        $data['site_currency']		= $siteSetting_currency;
        $data['dateformat']			= $dateformat;
		
		$data['payment_methods']	= $this->Constant_model->getPaymentType();
		$data['getOutlets']			= $this->Constant_model->getOutlets();		
		$data['getSalesReport']		= $this->Reports_model->getSalesReportNew();
		$data['getSalesReturnReport'] = $this->Reports_model->getSalesReturnReportNew();
        
        $this->load->view('reports/sales_report', $data);
    }
	
	public function sales_report_detail()
	{
		$siteSettingData			= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data['site_dateformat']	= $siteSettingData[0]->datetime_format;
        $data['site_currency']		= $siteSettingData[0]->currency;
		$data['getSalesReport']		= $this->Reports_model->getSalesReportById();
        $this->load->view('sales_report_detail', $data);
	}
	
	public function product_batch_expiry()
	{
		$permisssion_url = 'product_batch_expiry';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['ProductBatchExpiry'] = $this->Reports_model->ProductBatchExpiry();
		$this->load->view('product_batch_expiry',$data);
	}
	
	public function ViewPurchaseReturn()
	{
		$batchid = $this->input->post('batchid');
		$result	 = $this->Reports_model->getViewPurchaseReturn($batchid);	
		$html = '';
		
		$html.= '<div class="modal-dialog" style="width:70%">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Purchase Return Detail</h4>
				</div>
				<div class="modal-body">
				<table class="table" >
				<thead>
					<tr>
						<th>Date & Time</th>
						<th>Purchase Return No</th>
						<th>Product Code</th>
						<th>Ref Bill No</th>
						<th>Outlet</th>
						<th>Store</th>
						<th>Payment Type</th>
						<th>Returned Qty</th>
						<th>Refund Amount</th>
					</tr>
				</thead>
				<tbody>
				';
		
		if(!empty($result))
		{
			foreach ($result as $value)
			{
				$html.= '
					<tr>
						<td>'.$value->created_date.'</td>
						<td>'.$value->id.'</td>
						<td>'.$value->product_code.'</td>
						<td>'.$value->ref_bill_no.'</td>
						<td>'.$value->outlets_name.'</td>';
						if($value->type == 1)
						{
							$store =  $this->Inventory_model->getConcateFuelTanK($value->warehouse_tank);
							$html.= '<td>'.$store.'</td>.';
						}
						else
						{
							$store =  $this->Inventory_model->getConcateStore($value->warehouse_tank);
							$html.= '<td>'.$store.'</td>';
						}
				$html.= '<td>'.$value->payment_method_name.'</td>
						<td>'.$value->returned_qty.'</td>
						<td>'.number_format($value->refund_amount,2).'</td>
					</tr>';
			}
		}
		else
		{
			$html.= '<tr><td colspan="100%">No Record Found!!</td></tr>';
		}
		$html.= '</tbody>
				</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>';
		$json['success'] = $html;
		echo json_encode($json);
	}
	
	
	public function export_product_batch_expiry()
	{
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

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product Batch & Expiry Details');

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
		
		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Code');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Name');
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Category');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Brand');
		$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Batch Number');
		$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Expiry Date');
		
		$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$row = 3;
		$ProductBatchExpiry = $this->Reports_model->ProductBatchExpiry();
		foreach ($ProductBatchExpiry as $value)
		{
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $value->product_code);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $value->productname);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $value->categoryname);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $value->brandname);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $value->batch_no);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $value->expirydate);
			
			
			$objPHPExcel->getActiveSheet()->getStyle("A$row")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("B$row")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("C$row")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("D$row")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("E$row")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("F$row")->applyFromArray($account_value_style_header);
			$row++;
		}
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="product_batch_expiry.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	
    public function exportSalesReport()
    {
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $site_dateformat = $siteSettingData[0]->datetime_format;
        $site_currency = $siteSettingData[0]->currency;
		$this->load->library('excel');
		require_once './application/third_party/PHPExcel.php';
        require_once './application/third_party/PHPExcel/IOFactory.php';

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

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Sales Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Date');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Sale Id');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Payment');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Sub Total ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Tax ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Grand Total ($site_currency)");

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;
        $total_sub_amt = 0;
        $total_tax_amt = 0;
        $total_grand_amt = 0;

		$getSalesReport =  $this->Reports_model->getSalesReport();
		foreach ($getSalesReport as $value)
		{
			$total_sub_amt = $total_sub_amt + $value->subtotal;
			$total_tax_amt = $total_tax_amt  + $value->tax;
			$total_grand_amt = $total_grand_amt  + $value->grandtotal;
			
			$objPHPExcel->getActiveSheet()->setCellValue("A$jj", date("$site_dateformat H:i A", strtotime($value->ordered_datetime)));
			$objPHPExcel->getActiveSheet()->setCellValue("B$jj", $value->order_id.'-'.$value->id);
			$objPHPExcel->getActiveSheet()->setCellValue("C$jj", $value->outlet_name);
			$objPHPExcel->getActiveSheet()->setCellValue("D$jj", $value->payment_method_name);
			$objPHPExcel->getActiveSheet()->setCellValue("E$jj", $value->subtotal);
			$objPHPExcel->getActiveSheet()->setCellValue("F$jj", $value->tax);
			$objPHPExcel->getActiveSheet()->setCellValue("G$jj", $value->grandtotal);

			$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);
			$jj++;
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:D$jj");
        $objPHPExcel->getActiveSheet()->setCellValue("A$jj", 'Total');
        $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$total_sub_amt");
        $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$total_tax_amt");
        $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$total_grand_amt");

        $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);
		
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Sales_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
	
	public function credit_sales_payment()
	{
		$permisssion_url = 'credit_sales_payment';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getCreditColor'] = $this->Constant_model->getCreditColor();
		$data['results'] = $this->Reports_model->fetch_credit_data();
		
		$this->load->view('reports/credit_sales_payment',$data);
		
	}
	
	public function outstanding_received_detail()
	{
		
		$id = $this->input->get('id');	
		$data['customername'] = $this->Reports_model->getMainTablePayment($id);
		$data['payment_data'] = $this->Reports_model->outstanding_received_detail($id);

		$data['order_id'] = $id;
		$this->load->view('reports/outstanding_received_detail',$data);
	}
	
	
	public function taxes()
	{
		$permisssion_url = 'taxes';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$this->load->view('taxes');
	}
	
	public function product_report()
    {
		$permisssion_url = 'product_report';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['results']		= $this->Reports_model->getProductReportData();
		$data['url_outlet']		= $this->input->get('outlet');
        $data['url_start']		= $this->input->get('start_date');
        $data['url_end']		= $this->input->get('end_date');
        $data['cid']			= $this->input->get('cid');
		
        $format_array = ci_date_format();
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['site_currency']	 = $format_array['siteSetting_currency'];
        $data['dateformat']		 = $format_array['dateformat'];
        $data['getStore']		 = $this->Constant_model->getStore();
		$this->load->view('reports/product_report', $data);
    }
	
	public function exportProductReport()
    {
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

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Product Code');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Product Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Stores');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Supplier Name');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Opening Qty");
        $objPHPExcel->getActiveSheet()->setCellValue('H2', "Purchased Qty");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Sold Qty");
        $objPHPExcel->getActiveSheet()->setCellValue('I2', "Balance Qty");

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;
        $this->db->select('p.outlet_id,p.outlet_name,p.supplier_name,o.product_code,o.received_qty as purchase_qty,pr.name,sum(i.qty) as open_qty');
        $this->db->from('purchase_order as p');
        $this->db->join('purchase_order_items as o', 'o.po_id = p.id');
        $this->db->join('products as pr', 'pr.code = o.product_code');
        $this->db->join('inventory as i','i.product_code=pr.code');
        $this->db->group_by("p.id");
        $custDtaResult = $this->db->get();
        $custDtaData = $custDtaResult->result();
        for ($t = 0; $t < count($custDtaData); ++$t) {
			
			$stringstore = '';
			$store = $this->db->query("SELECT outlet_warehouse.*,stores.s_name FROM outlet_warehouse INNER JOIN stores ON stores.s_id = outlet_warehouse.w_id WHERE outlet_warehouse.out_id = '" .$custDtaData[$t]->outlet_id. "' ");
			foreach ($store->result() as $stor) {
				$stringstore.=$stor->s_name . ',';
			}
			$finalstringstore = rtrim($stringstore, ",");
			
            $cust_id = $custDtaData[$t]->product_code;
            $cust_fn = $custDtaData[$t]->product_code;
            $cust_em = $custDtaData[$t]->name;
            $cust_mb = $custDtaData[$t]->outlet_name;
            $cust_qt = $custDtaData[$t]->supplier_name;
            $open_qty = $custDtaData[$t]->open_qty;
            $purchase_qty = $custDtaData[$t]->purchase_qty;
            $balance_qty = $open_qty+$purchase_qty ;

            if (empty($cust_em)) {
                $cust_em = '-';
            }
            if (empty($cust_mb)) {
                $cust_mb = '-';
            }

            $total_ordered_qty = 0;
            $total_ordered_amt = 0;

            $orderData = $this->Constant_model->getDataOneColumn('orders', 'customer_id', $cust_id);
            for ($d = 0; $d < count($orderData); ++$d) {
                $order_grandTotal = $orderData[$d]->grandtotal;

                $total_ordered_amt += $order_grandTotal;

                ++$total_ordered_qty;
            }

            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$cust_fn");
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$cust_em");
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$cust_mb");
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$finalstringstore");
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$cust_qt");
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$open_qty");
            $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$purchase_qty");
            $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$total_ordered_amt");
            $objPHPExcel->getActiveSheet()->setCellValue("I$jj", "$balance_qty");

            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("I$jj")->applyFromArray($account_value_style_header);

            unset($cust_id);
            unset($cust_fn);
            unset($cust_em);
            unset($cust_mb);
            unset($cust_qt);
            unset($finalstringstore);

            ++$jj;
        }
        unset($custDtaResult);
        unset($custDtaData);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Customer_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
	
	public function product_category_report()
    {
		$permisssion_url = 'product_category_report';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['getCategory']		= $this->Reports_model->getCategoryProductReport();
		$data['getOutlet']			= $this->Reports_model->getOutletProductReport();
		$data['getCategoryFilter']	= $this->Constant_model->getCategory();
		$data['getOutletsFilter']	= $this->Constant_model->getOutlets();
		
		
		$format_array = ci_date_format();
        $data['site_dateformat']	= $format_array['siteSetting_dateformat'];
        $data['site_currency']		= $format_array['siteSetting_currency'];
        $data['dateformat']			= $format_array['dateformat'];
		
        $this->load->view('reports/product_category_report', $data);
    }
	
	
	public function goldsmith_payment_transaction()
    {
		$permisssion_url = 'goldsmith_payment_transaction';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getOutlet'] = $this->Reports_model->getoutletgoldsimth();
		$data['getresult'] = $this->Reports_model->getgoldsmith_pay_transation();
		
		
		
		$this->load->view('reports/goldsmith_payment_transactions',$data);
    }
	
	public function goldsmith_gold_transaction_report()
    {
		$permisssion_url = 'goldsmith_gold_transaction_report';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$data['getgoldsimthReport'] = $this->Reports_model->getgoldsimthReport();
		$data['getresult'] = $this->Reports_model->getgoldsmithAddWeight();
		$this->load->view('reports/goldsmith_gold_transaction_report',$data);
    }
	
	public function customer_invoice_list()
    {
		$permisssion_url = 'customer_invoice_list';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$single_status['user_id']=   $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $single_status['user_id']))->row();
		$data['logged_name'] = $get_logged_name->fullname;
		$data['getOutlet'] = $this->Constant_model->getDataWhere('outlets');
		$data['getCustomers'] = $this->Constant_model->getDataWhere('customers');
		$data['getresult'] = $this->Reports_model->getCustomerInvoiceList();
		$this->load->view('reports/customer_invoice_report',$data);
    }
	public function customer_invoice_deatils()
    {
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		$id = $this->input->get('id');
		$data['order_id'] = $id;
		$data['getmainOrder'] = $this->Reports_model->getcustomer_invoicePrint($id);
        $data['getItemOrder'] = $this->Reports_model->getcustome_invoice_itemPrint($id);
        $data['getPaymentOrder'] = $this->Reports_model->getcustomer_invoice_payment($id);
    	$this->load->view('reports/customer_invoice_print',$data);
    }
	
	
	
	public function exportProductCategoryReport()
    {
        $report = $this->input->get('report');
        $url_start = $this->input->get('start_date');
        $url_end = $this->input->get('end_date');
        $url_outlet = $this->input->get('outlet');
        $cid = $this->input->get('cid');

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

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product Category Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Category Name');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Outlet');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Quantity');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Product Total Value');

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
		
        $jj = 3;
		$getCategory = $this->Reports_model->getCategoryProductReport();
		foreach ($getCategory as $cate)
		{
			$outlet = $this->Reports_model->getCategoryReportOutlet($cate->outlet_id_fk);
			$cincate_out = '';
			foreach ($outlet as $ou)
			{
				$cincate_out.= $ou->name.',';
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue("A$jj", $cate->name);
			$objPHPExcel->getActiveSheet()->setCellValue("B$jj", trim($cincate_out,','));
			$objPHPExcel->getActiveSheet()->setCellValue("C$jj", !empty($cate->totalQty)? number_format($cate->totalQty,2):'0.00');
			$objPHPExcel->getActiveSheet()->setCellValue("D$jj", number_format($cate->purchase_price * $cate->totalQty,2));
			
			$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
			++$jj;
		}
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Product_Category_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

	public function sales_report_payement()
    {
		$permisssion_url = 'sales_report_payement';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
        $format_array = ci_date_format();
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['site_currency'] = $format_array['siteSetting_currency'];
        $data['dateformat'] = $format_array['dateformat'];
		
		$data['salesOrder']		= $this->Reports_model->getSalesOrder();
		$data['getSalesPerson'] = $this->Reports_model->getSalesPerson();
        $this->load->view('sales_report_payement', $data);
    }
	
	public function daily_summary_report()
	{
		$permisssion_url = 'daily_summary_report';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
	    $format_array = ci_date_format();
		$data['dateformat']		= $format_array['dateformat'];
		$data['getOutlet']		= $this->Constant_model->getOutlets();
		$data['getCategory']	= $this->Constant_model->getCategory();
		$data['getSubCategory'] = $this->Constant_model->getSubCategory();
		$data['getPaymentType'] = $this->Constant_model->getPaymentTypeGroup();
		
		$this->load->view('reports/daily_summary_report', $data);
	}
	
	public function product_purchase_report()
    {
        $this->db->select('p.outlet_id,p.id as pur_id, p.created_datetime,p.outlet_name,p.supplier_name,r.tank_qty as purchase_qty,o.cost as cost,o.product_code,pr.name');
        $this->db->from('purchase_order as p');
        $this->db->join('purchase_order_items as o', 'o.po_id = p.id');
        $this->db->join('purchase_received as r', 'r.purchase_item_id = o.id','left');
        $this->db->join('products as pr', 'pr.code = o.product_code');
		
		if (!empty($this->input->get('store')) &&  $this->input->get('store') != "all" ) {
			$this->db->join('outlet_warehouse','p.outlet_id=outlet_warehouse.out_id');
			$this->db->where('outlet_warehouse.w_id', $this->input->get('store'));
        }
		
        if ($this->input->get('product_code') != '') {
            $this->db->where('o.product_code', $this->input->get('product_code'));
            $data['product_code'] = $this->input->get('product_code');
        }
        if ($this->input->get('product_name') != '') {
            $this->db->where('pr.name', $this->input->get('product_name'));
            $data['product_name'] = $this->input->get('product_name');
        }
        if ($this->input->get('outlet') != '' && $this->input->get('outlet') != '-') {
            $this->db->where('p.outlet_id', $this->input->get('outlet'));
            $data['product_name'] = $this->input->get('product_name');
        }
		if ($this->input->get('start_date')!= '') {
			$this->db->where('DATE_FORMAT(p.created_datetime,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
        }
        if ($this->input->get('end_date')!= '') {
			$this->db->where('DATE_FORMAT(p.created_datetime,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
        }
        $data['product_report'] = $this->db->get();
		
        $data['url_outlet'] = $this->input->get('outlet');
        $data['url_start'] = $this->input->get('start_date');
        $data['url_end'] = $this->input->get('end_date');
        $data['cid'] = $this->input->get('cid');
        $format_array = ci_date_format();
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['site_currency'] = $format_array['siteSetting_currency'];
        $data['dateformat'] = $format_array['dateformat'];
		$data['getStore'] = $this->Constant_model->getStore();
		$data['getPurchaseReturnReport'] = $this->Reports_model->getPurchaseReturnReport();
        $this->load->view('reports/product_purchase_report', $data);
    }
	
	public function exportProductPurchaseReport()
    {
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

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product Purchase Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Product Code');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Product Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Store');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Total Purchased Qty ");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Total Purchased Cost");

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;
        $this->db->select('p.outlet_id,p.outlet_name,p.supplier_name,o.received_qty as purchase_qty,o.cost as cost,o.product_code,pr.name');
        $this->db->from('purchase_order as p');
        $this->db->join('purchase_order_items as o', 'o.po_id = p.id');
        $this->db->join('products as pr', 'pr.code = o.product_code');
        $custDtaResult = $this->db->get();
        $custDtaData = $custDtaResult->result();
        for ($t = 0; $t < count($custDtaData); ++$t) {
            $cust_id = $custDtaData[$t]->product_code;
            $cust_fn = $custDtaData[$t]->product_code;
            $cust_em = $custDtaData[$t]->name;
            $cust_mb = $custDtaData[$t]->outlet_name;
            $cust_qt = $custDtaData[$t]->supplier_name;
            $purchase_qty = $custDtaData[$t]->purchase_qty;
            $cost = $custDtaData[$t]->cost;

            if (empty($cust_em)) {
                $cust_em = '-';
            }
            if (empty($cust_mb)) {
                $cust_mb = '-';
            }
			
            $stringstore = '';
			$store = $this->db->query("SELECT outlet_warehouse.*,stores.s_name FROM outlet_warehouse INNER JOIN stores ON stores.s_id = outlet_warehouse.w_id WHERE outlet_warehouse.out_id = '" . $custDtaData[$t]->outlet_id . "' ");
			foreach ($store->result() as $stor) {
				$stringstore.=$stor->s_name . ',';
			}
			$cust_mbb =  rtrim($stringstore, ",");
			
			
            $total_ordered_qty = 0;
            $total_ordered_amt = 0;

            $orderData = $this->Constant_model->getDataOneColumn('orders', 'customer_id', $cust_id);
            for ($d = 0; $d < count($orderData); ++$d) {
                $order_grandTotal = $orderData[$d]->grandtotal;
                $total_ordered_amt += $order_grandTotal;
                ++$total_ordered_qty;
            }

            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$cust_fn");
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$cust_em");
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$cust_mb");
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$cust_mbb");
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$purchase_qty");
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$cost");

            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);

            unset($cust_id);
            unset($cust_fn);
            unset($cust_em);
            unset($cust_mb);

            ++$jj;
        }
        unset($custDtaResult);
        unset($custDtaData);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Customer_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
	
	public function sale_report()
    {
     	$data['getsalesProductReport'] = $this->Reports_model->ProductSalesItemReport();
		$data['getOutlets'] = $this->Constant_model->getOutlets();
        $this->load->view('product_sale_report', $data);
    }
	
	
	public function exportProductSaleReport()
    {
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

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product Sale Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Product Code');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Product Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Stores');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Total Qty Sold");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Total Sold Income");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Total Profit");

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $jj = 3;
		
		$getsalesProductReport = $this->Reports_model->ProductSalesItemReport();
		foreach ($getsalesProductReport as $sales)
		{
			$each_sales_cost = ($sales->price * $sales->qty);
			$each_profit = 0;
			$each_profit = $sales->grandtotal - $each_sales_cost - $sales->tax;
			
			$stringstore = '';
			$store  = $this->db->query("SELECT outlet_warehouse.*,stores.s_name FROM outlet_warehouse INNER JOIN stores ON stores.s_id = outlet_warehouse.w_id WHERE outlet_warehouse.out_id = '".$sales->outlet_id."' ");
			foreach ($store->result() as $stor)
			{
				$stringstore.=$stor->s_name.',';
			}
			
			$objPHPExcel->getActiveSheet()->setCellValue("A$jj", $sales->product_code);
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", $sales->product_name);
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", $sales->outlet_name);
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", rtrim($stringstore,","));
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", $sales->qty);
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", number_format($each_sales_cost,2));
            $objPHPExcel->getActiveSheet()->setCellValue("G$jj", number_format($each_profit,2));

            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);
			++$jj;
		}
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ProductSaleReport.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
	
	public function sale_bar_chart()
    {
        $this->db->select('p.outlet_id,p.outlet_name,p.supplier_name,o.product_code,pr.name');
        $this->db->from('purchase_order as p');
        $this->db->join('purchase_order_items as o', 'o.po_id = p.id');
        $this->db->join('products as pr', 'pr.code = o.product_code');
		if (!empty($this->input->get('store')) &&  $this->input->get('store') != "all" ) {
			$this->db->join('outlet_warehouse','p.outlet_id=outlet_warehouse.out_id');
			$this->db->where('outlet_warehouse.w_id', $this->input->get('store'));
        }
        if ($this->input->get('product_code') != '') {
            $this->db->where('o.product_code', $this->input->get('product_code'));
            $data['product_code'] = $this->input->get('product_code');
        }
        if ($this->input->get('product_name') != '') {
            $this->db->where('pr.name', $this->input->get('product_name'));
            $data['product_name'] = $this->input->get('product_name');
        }
        if ($this->input->get('outlet') != '' && $this->input->get('outlet') != '-') {
            $this->db->where('p.outlet_id', $this->input->get('outlet'));
            $data['product_name'] = $this->input->get('product_name');
        }
		if ($this->input->get('start_date')!= '') {
			$this->db->where('DATE_FORMAT(p.created_datetime,"%Y-%m-%d") >=', date('Y-m-d', strtotime($this->input->get('start_date'))));
        }
        if ($this->input->get('end_date')!= '') {
			$this->db->where('DATE_FORMAT(p.created_datetime,"%Y-%m-%d") <=',  date('Y-m-d', strtotime($this->input->get('end_date'))));
        }
        $data['product_report'] = $this->db->get();
        $data['url_outlet'] = $this->input->get('outlet');
        $data['url_start'] = $this->input->get('start_date');
        $data['url_end'] = $this->input->get('end_date');
        $data['cid'] = $this->input->get('cid');
        $format_array = ci_date_format();
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['site_currency'] = $format_array['siteSetting_currency'];
        $data['dateformat'] = $format_array['dateformat'];
		$data['getStore'] = $this->Constant_model->getStore();
        $this->load->view('product_sale_chart', $data);
    }
	
	public function issue_sale_report()
    {
                $permisssion_url = 'issue_sale_report';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		
        $product_id = $this->input->get('product_id');
        $url_outlet = $this->input->get('outlet_id');
        $session = $this->input->get('session');
        $sales_person_id = $this->input->get('sales_person_id');
        $url_start = $this->input->get('start_date');
        $url_end = $this->input->get('end_date');
        $is_get = (isset($_REQUEST['outlet_id'])) ? 1 : 0;
        $product_id = ($is_get == 1) ? $this->input->get('product_id') : $this->uri->segment(3);
        $outlet_id = ($is_get == 1) ? $this->input->get('outlet_id') : $this->uri->segment(4);
        $session = ($is_get == 1) ? $this->input->get('session') : $this->uri->segment(5);
        $sales_person_id = ($is_get == 1) ? $this->input->get('sales_person_id') : $this->uri->segment(6);
        $url_start = ($is_get == 1) ? $this->input->get('start_date') : $this->uri->segment(7);
        $url_end = ($is_get == 1) ? $this->input->get('end_date') : $this->uri->segment(8);

        $transfer_date = $this->input->post_get('transfer_date');
        $amount = $this->input->post_get('amount');
        $reference = $this->input->post_get('reference');
        $payment_method = $this->input->post_get('payment_method');

        if (empty($product_id)) {
            $product_id = '0';
        }
        if (empty($outlet_id)) {
            $outlet_id = '0';
        }
        if (empty($session)) {
            $session = '0';
        }
        if (empty($sales_person_id)) {
            $sales_person_id = '0';
        }
        if (empty($url_start)) {
            $url_start = '';
        }
        if (empty($url_end)) {
            $url_end = '';
        }
        //   echo "start=$url_start ==is_get=$is_get".$this->input->get('start_date')."===".empty($url_start)."<br>";

        $sort = '';
        if ($product_id != '0') {

            if ($product_id == '-') {
                $sort .= " AND id > 0";
            } else {
                $sort .= " AND id = (SELECT distinct(bakery_sale_id) from bakery_sale_items where product_code = '" . $product_id . "')";
            }
        }
        if ($session != '0') {


            $sort .= " AND session = '" . $session . "'";

        }
        if ($sales_person_id != '0') {


            $sort .= " AND sale_person_id = '" . $sales_person_id . "'";

        }
        if ($outlet_id != '0') {

            if ($outlet_id == '-') {
                $sort .= " AND outlet_id > 0";
            } else {
                $sort .= " AND outlet_id = '" . $outlet_id . "'";
            }
        }
        if ($url_start != '') {
//            echo "url_start=$url_start = $url_end";

            $url_start1 = date('Y-m-d', strtotime($url_start));
            $start_date = $url_start1 . ' 00:00:00';

            $sort .= " AND sale_datetime >= '$start_date'  ";
        }
        if ($url_end != '') {
            $url_end1 = date('Y-m-d', strtotime($url_end));

            $end_date = $url_end1 . ' 23:59:59';
            $sort .= " AND sale_datetime <= '$end_date'  ";
        }
        $sql = "SELECT * FROM bakery_sales WHERE sale_datetime != '0000-00-00 00:00:00' $sort ORDER BY id DESC ";
        //echo "sql=$sql";
        $data = records_with_page("sales/bakerySales/$product_id/$outlet_id/$session/$sales_person_id/$url_start/$url_end", '', '', 9, 'DESC', $sql);

        $data['url_start'] = $url_start;
        $data['url_end'] = $url_end;

        $format_array = ci_date_format();
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['user_role'] = $this->session->userdata('user_role');
        $data['session'] = $session;
        $data['sales_person_id'] = $sales_person_id;
        $data['product_id'] = $product_id;
        //$data['outlet']= $this->Constant_model->getDataCSV('products','outlet_id', 'category');
        $data['outlet'] = $this->Constant_model->getddData('outlets', 'id', 'name', 'id');

        $data['sales_person'] = $this->Constant_model->getddData('users', 'id', 'fullname', 'id');

        $data['url_outlet'] = $outlet_id;

        $data['site_currency'] = $format_array['siteSetting_currency'];
        $data['dateformat'] = $format_array['dateformat'];
        $this->load->view('issue_sale_report', $data);
    }


}
