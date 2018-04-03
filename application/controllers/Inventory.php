<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends CI_Controller
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Inventory_model');
        $this->load->model('Constant_model');
        $this->load->model('Reports_model');
        
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

    /*
	 * ***************************** View Page -- START ******************************
	 * View Product Category;
	 */
    public function view()
    {
		$permisssion_url = 'inventory';
         
		$permission			= $this->Constant_model->getPermissionPageWise($permisssion_url);
		$permission_re_id	= $permission->resource_id;
		$permisssion_sub_url = 'view';
		$permissionsub		= $this->Constant_model->getPermissionSubPageWise($permission_re_id,$permisssion_sub_url);
               
		if($permissionsub->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$format_array = ci_date_format();
		
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['site_currency']	= $format_array['siteSetting_currency'];
        $data['dateformat']		= $format_array['dateformat'];
		
		$this->load->model('Sales_model');
        // $data['getOutlets']     = $this->Constant_model->getOutlets();
		$data['getOutlets']		= $this->Inventory_model->getOutletsForInventory();
		$data['results']		= $this->Inventory_model->fetch_product_data();

		$this->load->view('inventory', $data);
    }
	
	public function inventory_changes()
	{
		$permisssion_url = 'inventory_changes';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		

		$data['results']		= $this->Inventory_model->getInventoryChange();

		$this->load->view('inventory_changes', $data);
	}
			
	

    public function view_detail()
    {
		$id			= $this->input->get('pcode');
		$product_data = $this->db->from('products')->where('id',$id)->get()->row();
        $pcode = $product_data->code;
		$prduct_array = $this->Constant_model->getSigleProductDetail($pcode);
        $p_name = !empty($prduct_array->name)?($prduct_array->name):'';
        $p_cat = !empty($prduct_array->categoryname)?($prduct_array->categoryname):'';
		$data['product_name'] = $p_name;
		$data['category_name'] = $p_cat;
    	$data['getinventory'] = $this->Inventory_model->getInventoryDetail($pcode);
        $data['product_code'] = $pcode;
        $data['product_data'] = $product_data;
		
        $this->load->view('inventory_detail', $data);
    }
	
	public function updateInventoryAjax()
	{
		$inventory_id = $this->input->post('inventory_id');
		$finalupdate_qty = $this->input->post('finalupdate_qty');
		$type		= $this->input->post('type');
		$tank_ware	= $this->input->post('tank_ware');
		$update_qty	= $this->input->post('update_qty');
		
		if($type==0)
		{
			$getStore = $this->Constant_model->OutletWarehouseget($tank_ware);
			$oldstore = $getStore->s_stock;
			$newstoreQty = $getStore->s_stock + $update_qty;
			$data_storeupdate = array(
				's_stock' => $newstoreQty,
				's_stock_upated' => $newstoreQty,
			);
			$this->Constant_model->UpdateStoreInventory($data_storeupdate, $getStore->store_id);
		}
		else
		{
			$outlet_id_array = $this->db->select('current_balance')->where('id',$tank_ware)->get('fuel_tanks')->row_array();
			$newbalance = $outlet_id_array['current_balance'] + $update_qty;
			$update_inventory = array(
				'current_balance'   => $newbalance,
			);
							
			$this->Constant_model->UpdateTankBalance($update_inventory, $tank_ware);
		}
		
		
		$this->Inventory_model->updateInventoryAjax($inventory_id,$finalupdate_qty);
		$json['success'] = true;
		echo json_encode($json);
	}



    public function exportInventory()
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
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Inventory Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Product Code');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Product Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Outlet Name');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Weight(g)');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Quantity');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Cost');

        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        
        $total_stock_qty 	= 0;
		$total_cost_amt = 0;
		
		
		$inventoryResult = $this->Inventory_model->fetch_product_data();
		foreach ($inventoryResult as $value)
		{
			$total_stock_qty = $total_stock_qty + $value->qty;
			$each_row_cost 	= $value->qty * $value->purchase_price;
			$total_cost_amt = $total_cost_amt + $each_row_cost;
												
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $value->code);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $value->name);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $value->outletname);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $value->weight);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, !empty($value->qty)?$value->qty:'0');
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, number_format($each_row_cost,2));
			$row++;
		}
      
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$row:E$row");
        $objPHPExcel->getActiveSheet()->setCellValue("A$row", 'Total Stock Qty');
        $objPHPExcel->getActiveSheet()->setCellValue("F$row", number_format($total_stock_qty,2));

        $objPHPExcel->getActiveSheet()->getStyle("A$row")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$row")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$row")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$row")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$row")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("F$row")->applyFromArray($style_header);
        
        $row++;
      
		$paginationData 		= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_currency 	= $paginationData[0]->currency;
		
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$row:E$row");
        $objPHPExcel->getActiveSheet()->setCellValue("A$row", "Total Stock Value ($siteSetting_currency) ");
        $objPHPExcel->getActiveSheet()->setCellValue("F$row", number_format($total_cost_amt,2));

        $objPHPExcel->getActiveSheet()->getStyle("A$row")->applyFromArray($text_align_style);
        $objPHPExcel->getActiveSheet()->getStyle("B$row")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("C$row")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("D$row")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("E$row")->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle("F$row")->applyFromArray($style_header);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Inventory_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
