<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pnl_report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Pnlreport_model');
        $this->load->model('Constant_model');

        $this->load->library('pagination');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
    }

    public function index()
    {
        $this->load->view('dashboard', 'refresh');
    }
	
    /*
	  ****************************** View Page -- START ******************************
	 */
    public function view_pnl_report()
    {
		
		
		$permisssion_url = 'view_pnl_report';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
    	if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		
        $siteSettingData		= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency	= $siteSettingData[0]->currency;
		
		if(!empty($this->input->get('start_date')))
		{
			$data['startdate'] = $this->input->get('start_date');
		}
		else
		{
			$data['startdate'] = date('01-m-Y',strtotime('this month'));
		}
		if(!empty($this->input->get('end_date')))
		{
			$data['end_date'] = $this->input->get('end_date');
		}
		else
		{
			$data['end_date'] = date('t-m-Y',strtotime('this month'));
		}
		
		$data['site_dateformat']		= $siteSetting_dateformat;
        $data['site_currency']			= $siteSetting_currency;
      	$data['user_role']				= $this->session->userdata('user_role');
		$data['ProfileLossReport']		= $this->Pnlreport_model->getProfitLossReport();
		$data['getExpense']				= $this->Pnlreport_model->getExpenseSum();
		$data['getOutlets']				= $this->Constant_model->getOutlets();
		$this->load->view('includes/header');
		$this->load->view('pnl_report', $data);
		$this->load->view('includes/footer');
    }

    /*
	 * ***************************** Export Excel -- START ****************************** //
	 */
    public function exportpnlReport()
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
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Profit & Loss Report');

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
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "Grand Total ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Cost ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Tax ($site_currency)");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Profit ($site_currency)");

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
		$all_grand_amt = 0;
		$all_tax_amt = 0;
		$all_cost_amt = 0;
		$all_profit_amt = 0;
		
		$ProfileLossReport = $this->Pnlreport_model->getProfitLossReport();
		foreach ($ProfileLossReport as $report)
		{
			$order_id = $report->gold_id;
			$each_sales_cost = 0;
			$totaltax = 0;
			$order_type = $report->status;
			$itemResult = $this->Pnlreport_model->getProfitLossItemReport($order_id);
			foreach ($itemResult as $itemData) {
				$totaltax = $totaltax + $itemData->tax;
				$item_cost = $itemData->cost;
				$item_qty = $itemData->qty;
				$each_sales_cost = $each_sales_cost + ($item_cost * $item_qty);
			}
			
			$each_profit = $report->gold_grandtotal - $each_sales_cost - $totaltax;
			$all_grand_amt = $all_grand_amt + $report->gold_grandtotal;
			$all_tax_amt = $all_tax_amt + $totaltax;
			$all_cost_amt = $all_cost_amt + $each_sales_cost;
			$all_profit_amt = $all_profit_amt + $each_profit;
			
			$objPHPExcel->getActiveSheet()->setCellValue("A$jj", date("$site_dateformat H:i A", strtotime($report->gold_ordered_datetime)));
			$objPHPExcel->getActiveSheet()->setCellValue("B$jj", $order_id);
			$objPHPExcel->getActiveSheet()->setCellValue("C$jj", $report->gold_outlet_name);
			$objPHPExcel->getActiveSheet()->setCellValue("D$jj", number_format($report->gold_grandtotal, 2));
			$objPHPExcel->getActiveSheet()->setCellValue("E$jj",  number_format($each_sales_cost, 2));
			$objPHPExcel->getActiveSheet()->setCellValue("F$jj", number_format($totaltax, 2));
			$objPHPExcel->getActiveSheet()->setCellValue("G$jj", number_format($each_profit, 2));

			$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);
			
			++$jj;
		}
		
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:C$jj");
		$objPHPExcel->getActiveSheet()->setCellValue("A$jj", 'Total');
		$objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$all_grand_amt");
		$objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$all_cost_amt");
		$objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$all_tax_amt");
		$objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$all_profit_amt");

		$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
		$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($style_header);

		$objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Profit_Loss_Report.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
    }
}
