<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bank_dt extends CI_Controller
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('bdt_model');
        $this->load->model('Pos_model');
        $this->load->model('Constant_model');
        
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
		$permisssion_url = 'bank_dt';
		
        $permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                $permission_re_id=$permission->resource_id;
                $permisssion_sub_url = 'index';
                $permissionsub = $this->Constant_model->getPermissionSubPageWise($permission_re_id,$permisssion_sub_url);
               
		if($permissionsub->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
	    $format_array = ci_date_format();
		
        $data['site_dateformat']	= $format_array['siteSetting_dateformat'];
        $data['site_currency']		= $format_array['siteSetting_currency'];
        $data['dateformat']			= $format_array['dateformat'];
        $data['user_role']		= $this->session->userdata('user_role');
		
		$data['payment_methods']= $this->Constant_model->getPaymentType();
		$data['getOutlets']		= $this->Constant_model->getOutlets();
		$data['getTransform']	= $this->bdt_model->getBankTransform();
		
        $this->load->view('includes/header');
        $this->load->view('bank_dt/bdt', $data);
        $this->load->view('includes/footer');
    }
	
	function print_bank_transfer()
	{
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;

		$id = $this->input->get('id');
		$data['getTransform']	= $this->bdt_model->getBankSignleRecord($id);
		
		$this->load->view('print_bank_transfer', $data);
	}
	
	
		function show_ftdetails() 
		{
			$id = $this->input->get('id');
			$ftdetails = $this->Constant_model->getShowFtdetails($id);
			$html = '';
			if(!empty($ftdetails))
			{
				foreach ($ftdetails as $value) 
				{
					$statval=$value->total_tank_balance-$value->tank_qty;
					if($statval==0){
						$start_qty=$value->total_tank_balance;
					} else {
						$start_qty=$statval;
					}
					
					
					$befor = $value->available_tank_qty - $value->tank_qty;
					$html.= '<tr>
						<td>'.$value->created_date.'</td>
						<td>'.$value->fuel_tank_number.'</td>
						<td>'.$value->outletsname.'</td>
						<td>'.number_format($start_qty,2).'</td>
						<td>'.number_format($value->purchase_qty,2).'</td>
						<td>'.number_format($value->sold_qty,2).'</td>
						<td>'.number_format($value->available_tank_qty,2).'</td>
					</tr>'; 
				}
			}
			else
			{
				$html.= '<tr>
							<td colspan="100%">No Record Found!!</td>
						</tr>'; 
			}
		
		$json['success'] = $html;
		echo json_encode($json);
	}
	
	public function getOutletPayment()
	{
		$outlet_id = $this->input->post('outlet_id');
		$payment_method = $this->Constant_model->getOutletWisePaymentMethod($outlet_id);
		$html = '';
		$html.='<option value="">Choose Deposit / Transfer Account</option>';
		
		foreach ($payment_method as $payment)
		{
			$html.='<option value="'.$payment->id.'">'.$payment->name.'</option>';
		}
		
		$anotherpayment = '';
		$anotherpayment.='<option value="">Choose Deposit / Transfer Account</option>';
		
		foreach ($payment_method as $value)
		{
			if($value->name == 'Cash')
			{
				$anotherpayment.='<option data-val="cash" value="'.$value->id.'">'.$value->name.'</option>';
			}
		}
		$json['success'] = $html;
		$json['anotherpayment'] = $anotherpayment;
		echo json_encode($json);
	}
	
	
	public function addBdt()
    {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions',' user_id='.$user_id." and resource_id=(select id from modules where name='bank_dt')");
		if(!isset($permission_data[0]->add_right)|| (isset($permission_data[0]->add_right) && $permission_data[0]->add_right!=1)){
			$this->session->set_flashdata('alert_msg', array('failure', 'Add Bank DT', 'You can not add bank DT. Please ask administrator!'));
			redirect($this->agent->referrer());
		}
		
        $data['user_role'] = $this->session->userdata('user_role');
        $format_array = ci_date_format();
        $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
        $data['site_currency'] = $format_array['siteSetting_currency'];
        $data['dateformat'] = $format_array['dateformat'];
		
		$data['newid'] = $this->Constant_model->getNextId('bank_transfers');
		
		$sess_arr = ci_getSession_data();
		$data['user_role'] = $sess_arr['user_role'];
		$data['user_outlet'] = $sess_arr['user_outlet'];
		
		$data['getOutlet'] = $this->bdt_model->getOutletUserWise($sess_arr['user_outlet'], $this->session->userdata('user_role'));
		$data['payment_method'] = $this->bdt_model->getPaymentMethod();
		$data['bank_account'] = $this->bdt_model->getBankAccountNumber();
        $this->load->view('includes/header');
        $this->load->view('bank_dt/add_bdt',$data);
        $this->load->view('includes/footer');
    }
	
	function Get_notMatchAllGetAccount()
	{
		$bank_accounts_id = $this->input->post('bank_accounts_id');
		$getBankData = $this->bdt_model->getBankAccount_notsel($bank_accounts_id);
		$outlet_id = $this->input->post('outlet_id');
		$payment_method = $this->Constant_model->getOutletWisePaymentMethod($outlet_id);
		$anotherpayment = '';
		$anotherpayment.='<option value="">Choose Deposit / Transfer Account</option>';
		foreach ($payment_method as $value)
		{
			if($value->name == 'Cash')
			{
				$anotherpayment.='<option data-val="cash" value="'.$value->id.'">'.$value->name.'</option>';
			}
		}
		foreach ($getBankData as $val)
		{
			$anotherpayment.= '<option value='.$val->id.' data-val="bank_act_no">'.$val->account_number.'(Account Number) </option>';
		}

		$json['success'] = $anotherpayment;
		echo json_encode($json);
	}
	
	function showBalancee()
	{
		$id       = $this->input->get('id');
        $method   = $this->input->get('paymentmethod');
        if($method == 1)
        {
            $getPaymentData = $this->Constant_model->getDataOneColumn('bank_accounts', 'id', $id);
            if(count($getPaymentData) == 1){
                $name       = $getPaymentData[0]->account_number;
                $balance    = $getPaymentData[0]->current_balance;
            }       
        }
        else
        {
            $getPaymentData = $this->Constant_model->getDataOneColumn('payment_method', 'id', $id);
            if(count($getPaymentData) == 1){
                $name       = $getPaymentData[0]->name;
                $balance    = $getPaymentData[0]->balance;
            }
        }
		
		$arr = array('status' => 1,
					'Name'=>$name,
					'balance' => $balance
					);
		echo json_encode($arr);
	}
	
	public function insertBdt()
    {
		
        $format_array = ci_date_format();
		$data['site_dateformat']	= $format_array['siteSetting_dateformat'];
		$data['site_currency']		= $format_array['siteSetting_currency'];
		$data['dateformat']			= $format_array['dateformat'];

		$outlet_id		= $this->input->post('outlet_id');
		$bank_to_data_val= $this->input->post('bank_to_data_val');
		$transfer_date	= $this->input->post('transfer_date');
		$amount			= $this->input->post('amount');
        $balance_row2	= $this->input->post('balance_row2');
		$reference		= $this->input->post('reference');
		$us_id			= $this->session->userdata('user_id');
		$tm				= date('Y-m-d H:i:s', time());
		$payemtmethod		= $this->input->post('payemtmethod');

        if($payemtmethod == 0)
        {
            $bank_from      = $this->input->post('bank_from');
            $bank_to        = $this->input->post('bank_to');
            $this->form_validation->set_rules('bank_from', 'bank from', 'required');
            $this->form_validation->set_rules('bank_to', 'bank to. ', 'required');
        }
		else
        {
            $bank_from      = $this->input->post('bank_from_m');
            $bank_to        = $this->input->post('bank_to_m');
            $this->form_validation->set_rules('bank_from_m', 'bank from', 'required');
            $this->form_validation->set_rules('bank_to_m', 'bank to. ', 'required');
        }
        
        if ($this->form_validation->run() == FALSE) {
            redirect(base_url().'bank_dt/addBdt');       
        } else {
            if($amount > $balance_row2){
                $this->session->set_flashdata('alert_msg', array('failure', 'Add ', 'You can not transfer not more than available amount!'));
                    redirect(base_url().'bank_dt/addBdt');
            }
            
            if (empty($transfer_date)) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add '.BDT, 'Please enter Transfer Date!'));
                redirect(base_url().'bank_dt/addBdt');
            }

            $ins_data = array(
                    'outlet_id' => $outlet_id,
                    'transfer_date' =>    date('Y-m-d', strtotime(strip_tags($transfer_date))),
                    'bank_from' => $bank_from,
                    'bank_to'=>$bank_to,
                    'amount'=>$amount,
                    'reference'=>$reference,
                    'payment_method' => $payemtmethod,
                    'created_by' => $this->session->userdata('user_id'),
                    'created' => $tm,
            );

            if ($id=$this->Constant_model->insertDataReturnLastId('bank_transfers', $ins_data)) {
                $bank_from1 = $bank_from;
                $bank_to1   = $bank_to;
                upload_image('document',$bank_from.$bank_to,'bdt','bank_transfers',$id,'document');
                $this->session->set_flashdata('alert_msg', array('success', 'Add '.BDT, "Successfully Added".BDT));
              
                if($payemtmethod == 0)
                {
                    /*
                     * Reduce banace from account
                     */
                 // $cur_fbalance = $this->getBCByID($bank_from)->current_balance;
                 // $current_balance_from   =   $cur_fbalance   -   $amount;
                 // $this->db->where('id', $bank_from);
                 // $this->db->update("bank_accounts", array('current_balance'=>$current_balance_from));

                    $balance_arr    = $this->Constant_model->getSingle('payment_method','balance','id='.$bank_from,'balance');
					$balance        = (count($balance_arr)>0)?$balance_arr: 0;
                    $finalbalance_arr    = $balance-$amount;
               
                    $this->db->where('id', $bank_from);
                    $this->db->update("payment_method", array('balance'=>$finalbalance_arr));

                    
					$payment['trans_type']      = 'transfer';
					$payment['outlet_id']       = $outlet_id;
					$payment['amount']          = $amount;
					$payment['account_number']  = $bank_from1;
					$payment['bring_forword']  = $balance_arr;
					$this->db->insert('transactions', $payment);
					
					
					
                    /*
                     * Add balance in receiving account
                     */
                    $cur_tbalance       = $this->getBCByID($bank_to)->current_balance;
                    $current_balance_to = $cur_tbalance   +   $amount;
                    $this->db->where('id', $bank_to);
                    $this->db->update("bank_accounts", array('current_balance'=>$current_balance_to));
					
					$payment['trans_type']      = 'dep';
					$payment['outlet_id']       = $outlet_id;
					$payment['amount']          = $amount;
					$payment['account_number']  = $bank_to1;
					$payment['bring_forword']  = $cur_tbalance;
					$payment['transfer_status']  = 1;
					$this->db->insert('transactions', $payment);
					
					
					
					
					
                 //   if(substr($bank_from1,0,1)=='-'){
                 //       $bank_from = substr($bank_from,1);
                      

                 //   } else {
                 //       $bank_from        = substr($bank_from,1);
                       
                 //   }
                    
                 //   if(substr($bank_to1,0,1)=='-')
                 // {
                 //       $bank_to          = substr($bank_to,1);
                       
                 //   } 
                 // else 
                 // {
                 //       $bank_to      = substr($bank_to,1);
                 //       $balance_arr  = ($this->Constant_model->getSingle('payment_method', 'balance', 'id='.$bank_to, 'balance'));
                 //       $balance      = (count($balance_arr)>0)? $balance_arr: 0;
                 //       $balance_arr  = $balance + $amount;
                 //       $balance      = ($balance_arr);
                     
                 //     $this->db->where('id', $bank_to);
                 //       $this->db->update("payment_method", array('balance'=>$balance));
                 //   }
                    redirect(base_url().'bank_dt');
                }
                else
                {
                   
					if($bank_to_data_val=='bank_act_no')
					{
						
						$cur_tbalance       = $this->getBCByID($bank_from)->current_balance;
						$current_balance_form = $cur_tbalance   -   $amount;
						$this->db->where('id', $bank_from);
						$this->db->update("bank_accounts", array('current_balance'=>$current_balance_form));
						
						$cur_tbalance_to       = $this->getBCByID($bank_to)->current_balance;
						$current_balance_to = $cur_tbalance_to   +   $amount;
						$this->db->where('id', $bank_to);
						$this->db->update("bank_accounts", array('current_balance'=>$current_balance_to));
	
					}
					else
					{
						$balance_arr    = $this->Constant_model->getSingle('payment_method','balance','id='.$bank_to,'balance');
						$balance        = (count($balance_arr)>0)? $balance_arr: 0;
						$balance_arrfinal    = $balance + $amount;

						$this->db->where('id', $bank_from);
						$this->db->update("payment_method", array('balance'=>$balance_arrfinal));

						$payment['trans_type']      = 'wd';
						$payment['outlet_id']       = $outlet_id;
						$payment['amount']          = $amount;
						$payment['account_number']  = $bank_to;
						$payment['bring_forword']	= $balance_arr;
						$this->db->insert('transactions', $payment);



						/*
						 * Add balance in receiving account
						 */
						$cur_tbalance       = $this->getBCByID($bank_from)->current_balance;
						$current_balance_to = $cur_tbalance   -   $amount;
						$this->db->where('id', $bank_from);
						$this->db->update("bank_accounts", array('current_balance'=>$current_balance_to));

						$payment['trans_type']      = 'transfer';
						$payment['outlet_id']       = $outlet_id;
						$payment['amount']          = $amount;
						$payment['account_number']  = $bank_from;
						$payment['bring_forword']	= $cur_tbalance;
						$payment['transfer_status']  = 1;
						$this->db->insert('transactions', $payment);
					}
				
					
                    redirect(base_url().'bank_dt');
                }
            }
        }
    }
	
	 public function getBCByID($id)
    {
	   $q = $this->db->get_where('bank_accounts', array('id' => $id), 1);
		if ($q->num_rows() > 0) {
			return $q->row();
        }
        return FALSE;
    }
	
	
	 public function exportBdt()
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
        $objPHPExcel->getActiveSheet()->setCellValue('A1', BDT.' Report');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Transfer Date');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Outlet');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Bank From');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Bank To');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Amount');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Reference');

 
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(60);
		
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$jj = 3;
		
		$getTransform = $this->bdt_model->getBankTransform();
		foreach ($getTransform as $value)
		{
			$objPHPExcel->getActiveSheet()->setCellValue("A$jj", date('d-m-Y',strtotime($value->transfer_date)));
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", $value->outletname);
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", $value->paymenttype);
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", '');
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", $value->amount);
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", $value->reference);

 
            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
			$jj++;
		}
		
	    header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Bank_Deposit_Transfer_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
	
	
	
}
