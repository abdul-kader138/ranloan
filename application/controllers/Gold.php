<?php

Class Gold extends CI_Controller {

	public function __construct() {
		// Call the Model constructor
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Gold_module');
		$this->load->model('Customers_model');
		$this->load->model('Constant_model');
		$this->load->model('Pos_model');
		$this->load->model('Sales_model');
		
		$this->load->library('pagination');
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$setting_timezone = $settingData->timezone;
		date_default_timezone_set("$setting_timezone");
		if ($this->session->userdata('user_id') == "") {
			redirect(base_url());
		}
	}
	
	public function list_order_estimate() 
	{
		$permisssion_url = 'list_order_estimate';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['getcustomer_order']=$this->Gold_module->CustomerOrderList();
		$this->load->view('includes/header');
		$this->load->view('gold/list_order_estimate',$data);
		$this->load->view('includes/footer');
	}
	
	
	 public function sales_price_calculations()
	 {
		$permisssion_url = 'sales_price_calculations';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$data['getSubCategory'] = $this->Gold_module->getSubCategory();
		$data['getProduct_invertory'] = $this->Gold_module->getProduct_invertory();
		$this->load->view('includes/header');
		$this->load->view('gold/sales_price_calculations',$data);
		$this->load->view('includes/footer');
	 }
	

	public function view_order_detail()
    {
        $settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		$id = $this->input->get('id');
		$data['order_id'] = $id;
		$data['getmainOrder'] = $this->Gold_module->getOrderPrint($id);
        $data['getItemOrder'] = $this->Gold_module->getOrderItemPrint($id);
        $data['getPaymentOrder'] = $this->Gold_module->getOrderPaymentPrint($id);
        $this->load->view('view_order_detail', $data);
    }
	 public function view_sales_invoice_detail()
    {
        $settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();
		$data['setting_dateformat'] = $settingData->datetime_format;
		$data['setting_site_logo'] = $settingData->site_logo;
		$id = $this->input->get('id');
		$data['sales_id'] = $id;
		$data['getmainOrder'] = $this->Gold_module->getSales_invoiceOrderPrint($id);
        $data['getItemOrder'] = $this->Gold_module->getSalesInvoiceItemPrint($id);
        $data['getPaymentOrder'] = $this->Gold_module->getSalesInvoicePaymentPrint($id);
        $this->load->view('view_sales_invoice_detail', $data);
    }
	
	public function send_invoice() {
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();

		$site_dateformat = $settingData->datetime_format;
		$site_name = $settingData->site_name;
		$setting_site_logo = $settingData->site_logo;

		$email = $this->input->post('email');
		$id = $this->input->post('id');

		$orderData = $this->Constant_model->getDataOneColumn('orders_gold', 'id', $id);
		$ordered_dtm = date("$site_dateformat H:i A", strtotime($orderData[0]->ordered_datetime));
		$cust_fullname = $orderData[0]->customer_name;
		$cust_mobile = $orderData[0]->customer_mobile;
		$outlet_id = $orderData[0]->outlet_id;
		$subTotal = $orderData[0]->subtotal;
		$dis_amt = $orderData[0]->discount_total;
		$tax_amt = $orderData[0]->tax;
		$grandTotal = $orderData[0]->grandtotal;
		$us_id = $orderData[0]->created_user_id;
		$pay_method_id = $orderData[0]->payment_method;
		$pay_method_name = $orderData[0]->payment_method_name;
		$paid_amt = $orderData[0]->paid_amt;
		$return_change = $orderData[0]->return_change;
		$cheque_numb = $orderData[0]->cheque_number;
		$dis_percentage = $orderData[0]->discount_percentage;

		$card_numb = $orderData[0]->gift_card;

		$outlet_name = $orderData[0]->outlet_name;
		$outlet_address = $orderData[0]->outlet_address;
		$outlet_contact = $orderData[0]->outlet_contact;

		$receipt_header = '';
		$receipt_footer = $orderData[0]->outlet_receipt_footer;

		$staff_name = '';
		$staffData = $this->Constant_model->getDataOneColumn('users', 'id', $us_id);

		$staff_name = $staffData[0]->fullname;

		if ($pay_method_id == '5') {
			$pay_method_name = $pay_method_name . " (Cheque No. : $cheque_numb)";
		}

		if ($pay_method_id == '7') {
			$pay_method_name = $pay_method_name . " (Card No. : $card_numb)";
		}

		if (empty($cust_mobile)) {
			$cust_mobile = '-';
		}

		$unpaid_amt = 0;
		if (($pay_method_id == '6')) {
			$unpaid_amt = $paid_amt - $grandTotal;
		}

		// Send Email -- START;
		$this->load->library('email');
		$fromemail = 'noreply@syzygy.technologies.com';
		$toemail = "$email";
		$subject = "Receipt from $site_name";
		$mesg = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
     
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reset BabyQ Password</title>
    <style type="text/css">
    
    @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
        body[yahoo] .hide {display: none!important;}
        body[yahoo] .buttonwrapper {background-color: transparent!important;}
        body[yahoo] .button {padding: 0px!important;}
        body[yahoo] .button a {background-color: #e05443; padding: 15px 15px 13px!important;}
        body[yahoo] .unsubscribe {display: block; margin-top: 20px; padding: 10px 50px; background: #2f3942; border-radius: 5px; text-decoration: none!important; font-weight: bold;}
    }
    
    /*@media only screen and (min-device-width: 601px) {
    .content {width: 600px !important;}
    .col425 {width: 425px!important;}
    .col380 {width: 380px!important;}
    }*/
    
    body { 
        max-width: 300px; 
        margin:0 auto; 
        text-align:center; 
        color:#000; 
        font-family: Arial, Helvetica, sans-serif; 
        font-size:12px; 
    }
    #wrapper { 
        min-width: 250px; 
        margin: 0px auto; 
    }
    #wrapper img { 
        max-width: 300px; 
        width: auto; 
    }

    h2, h3, p { 
        margin: 5px 0;
    }
    .left { 
        width:100%; 
        float: right; 
        text-align: right; 
        margin-bottom: 3px;
        margin-top: 3px;
    }
    .right { 
        width:40%; 
        float:right; 
        text-align:right; 
        margin-bottom: 3px; 
    }
    .table, .totals { 
        width: 100%; 
        margin:10px 0; 
    }
    .table th { 
        border-top: 1px solid #000; 
        border-bottom: 1px solid #000; 
        padding-top: 4px;
        padding-bottom: 4px;
    }
    .table td { 
        padding:0; 
    }
    .totals td { 
        width: 24%; 
        padding:0; 
    }
    .table td:nth-child(2) { 
        overflow:hidden; 
    }
    
    </style>
    </head>
    
    <body yahoo bgcolor="#f6f8f1" style="margin: 0; padding: 0; min-width: 100% !important;">
        <table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                <!--[if (gte mso 9)|(IE)]>
                <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                <td>
                <![endif]-->     
                    <table bgcolor="#ffffff" align="center" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial, Helvetica, sans-serif; width: 100%; max-width: 600px;">
                        <tr>
                            <td style="padding: 30px 20px 30px 20px;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td style="font-size: 13px; line-height: 22px;">



<div id="wrapper">
    <table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
        <tr>
            <td width="100%" align="center">
                <center>
                    <img src="' . base_url() . 'assets/img/logo/' . $setting_site_logo . '" style="width: 80px;" />
                </center>
            </td>
        </tr>
        <tr>
            <td width="100%" align="center">
                <h2 style="padding-top: 0px; font-size: 24px;"><strong>' . $outlet_name . '</strong></h2>
            </td>
        </tr>
        <tr>
            <td width="100%">
                <span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Address : ' . $outlet_address . '</span>   
                <span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Tel : ' . $outlet_contact . '</span> 
                <span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Sale Id : ' . $id . '</span>
                <span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Date : ' . $ordered_dtm . '</span>
                <span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Customer Name &nbsp;: ' . $cust_fullname . '</span>
                <span style="width:100%; float:right; text-align:left; margin-bottom: 3px; margin-top: 3px;">Customer Phone : ' . $cust_mobile . '</span>
            </td>
        </tr>   
    </table>
    
     
        
    <div style="clear:both;"></div>
    <table class="table" cellspacing="0"  border="0"> 
        <thead> 
            <tr> 
                <th width="10%" style="border-top:1px solid #000; border-bottom: 1px solid #000;"><em>#</em></th> 
                <th width="10%" style="border-top:1px solid #000; border-bottom: 1px solid #000;" align="left">Product</th>
                <th width="10%" style="border-top:1px solid #000; border-bottom: 1px solid #000;">Quantity</th>
                <th width="20%" style="border-top:1px solid #000; border-bottom: 1px solid #000;">Per Item</th>
                <th width="15%" style="border-top:1px solid #000; border-bottom: 1px solid #000;">Sub Section</th>
                <th width="10%" style="border-top:1px solid #000; border-bottom: 1px solid #000;">Weight</th>
                <th width="20%" style="border-top:1px solid #000; border-bottom: 1px solid #000;" align="right">Subtotal</th> 
            </tr> 
        </thead> 
        <tbody>';

		$total_item_amt = 0;
		$total_item_qty = 0;

		$orderItemResult = $this->db->query("SELECT * FROM order_items_gold WHERE order_id = '$id' ORDER BY id ");
		$orderItemData = $orderItemResult->result();
		for ($i = 0; $i < count($orderItemData); ++$i) {
			$pcode = $orderItemData[$i]->product_code;
			$name = $orderItemData[$i]->product_name;
			$qty = $orderItemData[$i]->qty;
			$price = $orderItemData[$i]->price;
			$subs = $orderItemData[$i]->subs;
			$weight = $orderItemData[$i]->weight;

			$each_row_price = 0;
			$each_row_price = $qty * $price;

			$total_item_amt += $each_row_price;

			$mesg .= '
                <tr>
                    <td style="text-align:center; width:30px;" valign="top">' . ($i + 1) . '</td>
                    <td style="text-align:left; width:130px; padding-bottom: 10px" valign="top">' . $name . '<br />[' . $pcode . ']</td>
                    <td style="text-align:center; width:50px;" valign="top">' . $qty . '</td>
                    <td style="text-align:center; width:50px;" valign="top">' . number_format($price, 2) . '</td>
                    <td style="text-align:center; width:50px;" valign="top">' . $subs . '</td>
                    <td style="text-align:center; width:50px;" valign="top">' . $weight . '</td>
                    <td style="text-align:right; width:70px;" valign="top">' . number_format($each_row_price, 2) . '</td>
                </tr>';

			$total_item_qty += $qty;

			unset($pcode);
			unset($name);
			unset($qty);
			unset($price);
		}
		unset($orderItemResult);
		unset($orderItemData);

		$mesg .= '   
        </tbody> 
    </table> 
    
    
    <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000;" width="100%">
        <tbody>
            <tr>
                <td style="text-align:left; padding-top: 5px;" width="25%">Total Items</td>
                <td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;" width="25%">' . $total_item_qty . '</td>
                <td style="text-align:left; padding-left:1.5%;" width="25%">Total</td>
                <td style="text-align:right;font-weight:bold;" width="25%">' . number_format($total_item_amt, 2) . '</td>
            </tr>';

		if ($dis_amt > 0) {
			$mesg .= '
                    <tr>
                        <td style="text-align:left;"></td>
                        <td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;"></td>
                        <td style="text-align:left; padding-left:1.5%; padding-bottom: 5px;">Discount';

			if (!empty($dis_percentage)) {
				$mesg .= ' (' . $dis_percentage . ')';
			}

			$mesg .= '
                        </td>
                        <td style="text-align:right;font-weight:bold;">-' . number_format($dis_amt, 2) . '</td>
                    </tr>';
		}

		$mesg .= '
            <tr>
                <td style="text-align:left; padding-top: 5px;">&nbsp;</td>
                <td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;">&nbsp;</td>
                <td style="text-align:left; padding-left:1.5%;">Sub Total</td>
                <td style="text-align:right;font-weight:bold;">' . number_format($subTotal, 2) . '</td>
            </tr>
            <tr>
                <td style="text-align:left; padding-top: 5px;">&nbsp;</td>
                <td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;">&nbsp;</td>
                <td style="text-align:left; padding-left:1.5%;">Tax</td>
                <td style="text-align:right;font-weight:bold;">' . number_format($tax_amt, 2) . '</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Grand Total</td>
                <td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;">' . number_format($grandTotal, 2) . '</td>
            </tr>
            
            <tr>    
                <td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">Paid</td>
                <td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . number_format($paid_amt, 2) . '</td>
            </tr>';

		if ($return_change > 0) {
			$mesg .= '
                        <tr>
                            <td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">Change</td>
                            <td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . number_format($return_change, 2) . '</td>
                        </tr>
                    ';
		}

		if ($unpaid_amt < 0) {
			$mesg .= '
                        <tr>
                            <td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">Unpaid</td>
                            <td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;">' . number_format($unpaid_amt, 2) . '</td>
                        </tr>
                    ';
		}

		$mesg .= '
                        <tr>
                            <td style="text-align:left; padding-top: 5px; font-weight: bold; border-top: 1px solid #000;">Paid By : </td>
                            <td style="text-align:right; padding-top: 5px; padding-right:1.5%; border-top: 1px solid #000;font-weight:bold;" colspan="3">' . $pay_method_name . '</td>
                        </tr>
    </tbody>
    </table>
    <center>
    <div style="border-top:1px solid #000; padding-top:10px;">' . $receipt_footer . '</div>
    </center>
</div>


                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20px"></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 13px; line-height: 22px;">
                                            Sincerely,
                                            <Br />
                                            - ' . $site_name . ' 
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
    
                    </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->
                </td>
            </tr>
        </table>
    </body>
    </html> 
        ';

		$this->load->library('email');
		$config = array(
			'charset' => 'utf-8',
			'wordwrap' => true,
			'mailtype' => 'html',
		);
		$this->email->initialize($config);
		$this->email->to($toemail);
		$this->email->from($fromemail, "$site_name");
		$this->email->subject($subject);
		$this->email->message($mesg);
		$mail = $this->email->send();
		// Send Email -- END;

		return true;
	}

	public function view_invoice() {
        if(!empty($this->input->get('id')))
        {
            $id = $this->input->get('id');
        }
        else
        {
            $id = NULL;
        }
	
        $data['setting_logo'] = $this->db->get_where('site_setting')->row();
		$data['getmainOrder']=$this->db->get_where('gold_orders', array('gold_id' => $id))->row();
        if(!empty($data['getmainOrder']))
        {
            $sales_id=$data['getmainOrder']->sale_person_id;
        }
        else
        {
            $sales_id = NULL;
        }
		
		$data['sales_person_name']=$this->Constant_model->getDataWhere('users','id='.$sales_id);
		$data['order_items_gold']=$this->Constant_model->getDataWhere('order_items_gold','order_id='.$id);
		$data['getPaymentGoldOrder'] = $this->Constant_model->getDataWhere('gold_orders_payment','gold_orders_id='.$id);
		
		$data['new_sys_settings'] = ci_set_settings();
		$data['order_id']=$id;
		$data['getPaymentOrder']=0;
		$this->load->view('gold/print_invoice_order_estimate', $data);
	}

	public function view_invoice_a4() {
		$id = $this->input->get('id');
		$data['getmainOrder']=$this->db->get_where('gold_orders', array('gold_id' => $id))->row();
		$sales_id=$data['getmainOrder']->sale_person_id;
		$data['sales_person_name']=$this->Constant_model->getDataWhere('users','id='.$sales_id);
		$data['order_items_gold']=$this->Constant_model->getDataWhere('order_items_gold','order_id='.$id);
		$data['getPaymentGoldOrder'] = $this->Constant_model->getDataWhere('gold_orders_payment','gold_orders_id='.$id);
		$data['new_sys_settings'] = ci_set_settings();
		$data['order_id']=$id;
		$this->load->view('gold/print_invoice_a4_gold', $data);
	}
	
	public function view_sales_invoice() {
		$id = $this->input->get('id');
        $data['setting_logo'] = $this->db->get_where('site_setting')->row();
		$data['getmainOrder']=$this->db->get_where('sales_invoice', array('sales_id' => $id))->row();
		$sales_id=$data['getmainOrder']->sale_person_id;
		$data['sales_person_name']=$this->Constant_model->getDataWhere('users','id='.$sales_id);
		$data['sales_invoice_item']=$this->Constant_model->getDataWhere('sales_invoice_item','sales_id='.$id);
		$data['getPaymentSalesInvoice'] = $this->Constant_model->getDataWhere('sales_invoice_payment','sales_id='.$id);
		$data['new_sys_settings'] = ci_set_settings();
		$data['sales_id']=$id;
		$this->load->view('gold/view_sales_invoice', $data);
	}
	public function sales_invoice_a4() {
		$id = $this->input->get('id');
        $data['getmainOrder']=$this->db->get_where('sales_invoice', array('sales_id' => $id))->row();
		$sales_id=$data['getmainOrder']->sale_person_id;
		$data['sales_person_name']=$this->Constant_model->getDataWhere('users','id='.$sales_id);
		$data['sales_invoice_item']=$this->Constant_model->getDataWhere('sales_invoice_item','sales_id='.$id);
		$data['getPaymentsalesInvoice'] = $this->Constant_model->getDataWhere('sales_invoice_payment','sales_id='.$id);
		$data['new_sys_settings'] = ci_set_settings();
		$data['sales_id']=$id;
		$this->load->view('gold/print_invoice_a4_sales_invoice', $data);
	}

	public function insertorder_estimate() {

		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='list_order_estimate')");

		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add order estimate', 'You can not add order estimate. Please ask administrator!'));
			redirect($this->agent->referrer());
		}


		$id2_arr = $this->input->post('id2');
		$codes_arr = $this->input->post('code1');
		$mini1_arr = $this->input->post('mini1');
		$subsections_arr = $this->input->post('subsection');
		$subsectionv_arr = $this->input->post('subsectionvl');
		$gold_grade1_arr = $this->input->post('gold_grade1');
		$item_name1_arr = $this->input->post('item_name1');
		$qty12_arr = $this->input->post('qty12');
		$weight1_arr = $this->input->post('weight1');
		$price_arr = $this->input->post('price');
		$startDate_arr = $this->input->post('startDate');
		$total_price_final1_arr = $this->input->post('total_price_final1');


		if (isset($_POST['hold_bill_submit'])) {
			$customer = $this->input->post('customer');
			$hold_ref = $this->input->post('hold_ref');
			$row_count = $this->input->post('row_count');
			$subTotal = $this->input->post('subTotal');
			$dis_amt = $this->input->post('dis_amt');
			$grandTotal = $this->input->post('final_total_payable');
			$total_item_qty = $this->input->post('final_total_qty');
			$taxTotal = $this->input->post('tax_amt');
			$user_id = $this->session->userdata('user_id');
			$user_outlet = $this->input->post('outlet');
			$tm = date('Y-m-d H:i:s', time());
			if (empty($dis_amt)) {
				$dis_amt = 0;
			} elseif (strpos($dis_amt, '%') > 0) {
				$temp_dis_Array = explode('%', $dis_amt);
				$temp_dis = $temp_dis_Array[0];
				$temp_item_price = 0;
				for ($i = 1; $i <= $row_count; ++$i) {
					$pcode = $this->input->post("pcode_$i");
					$price = $this->input->post("price_$i");
					$qty = $this->input->post("qty_$i");
					if (!empty($pcode)) {
						$temp_item_price += ($price * $qty);
					}
				}
				$dis_amt = number_format(($temp_item_price * ($temp_dis / 100)), 2, '.', '');
			}

			// Get Customer Detail;
			$custDtaData = $this->Constant_model->getDataOneColumn('customers', 'id', $customer);
			$custDta_fn = $custDtaData[0]->fullname;
			$custDta_email = $custDtaData[0]->email;
			$custDta_mb = $custDtaData[0]->mobile;
//$this->Constant_model->getDataOneColumn('orders', 'outlet_id', $user_outlet);

			$ins_sus_data = array(
				'customer_id' => $customer,
				'fullname' => $custDta_fn,
				'email' => $custDta_email,
				'mobile' => $custDta_mb,
				'ref_number' => $hold_ref,
				'outlet_id' => $user_outlet,
				'subtotal' => $subTotal,
				'discount_total' => $dis_amt,
				'tax' => $taxTotal,
				'grandtotal' => $grandTotal,
				'total_items' => $total_item_qty,
				'created_user_id' => $user_id,
				'created_datetime' => $tm,
				'status' => '0'
			);
			$sus_id = $this->Constant_model->insertDataReturnLastId('suspend', $ins_sus_data);

			// Order Item -- START;
			for ($i = 1; $i <= $row_count; ++$i) {
				$pcode = $this->input->post("pcode_$i");
				$price = $this->input->post("price_$i");
				$qty = $this->input->post("qty_$i");

				if (!empty($pcode)) {
					$pcodeDtaData = $this->Constant_model->getDataOneColumn('products', 'code', $pcode);
					$pcode_name = $pcodeDtaData[0]->name;
					$pcode_categeory_id = $pcodeDtaData[0]->category;
					$pcode_cost = $pcodeDtaData[0]->purchase_price;

					$ins_sus_item_data = array(
						'suspend_id' => $sus_id,
						'product_code' => $pcode,
						'product_name' => $pcode_name,
						'product_category' => $pcode_categeory_id,
						'product_cost' => $pcode_cost,
						'qty' => $qty,
						'product_price' => $price,
					);
					$this->Constant_model->insertData('suspend_items', $ins_sus_item_data);
				}
			}

			$this->session->set_flashdata('alert_msg', array('success', 'Add Opened Bill', 'Successfully Added to Opened Bill.'));
			redirect(base_url() . 'pos');
		} elseif (isset($_POST['add_prod_submit'])) {
			$pop_pcode = $this->input->post('pop_pcode');
			$pop_pname = $this->input->post('pop_pname');
			$pop_pcate = $this->input->post('pop_pcate');
			$pop_price = $this->input->post('pop_price');
			$mini_amt = 0;

			$user_id = $this->session->userdata('user_id');
			$tm = date('Y-m-d H:i:s', time());

			$ckProdCodeResult = $this->db->query("SELECT * FROM products WHERE code = '$pop_pcode' ");
			$ckProdCodeRows = $ckProdCodeResult->num_rows();

			if ($ckProdCodeRows > 0) {
				?>
				<script type="text/javascript">
				    alert("Product Code : <?php echo $pop_pcode; ?>is already existing in the system! Please try another one");
				    window.location.href = "<?= base_url() ?>pos";
				</script>
				<?php
			} else {
				$ins_prod_data = array(
					'code' => $pop_pcode,
					'name' => $pop_pname,
					'category' => $pop_pcate,
					'retail_price' => $pop_price,
					'thumbnail' => 'no_image.jpg',
					'created_user_id' => $user_id,
					'created_datetime' => $tm,
					'status' => '1',
				);
				$this->Constant_model->insertData('products', $ins_prod_data);

				$this->session->set_flashdata('alert_msg', array('success', 'Add New Product', 'Successfully Added New Product.'));
				redirect(base_url() . 'pos');
			}
		} else {	// Sales;
			$invoice = $this->input->post('invoice');
			$id2 = $this->input->post('id2');
			$item_name1 = $this->input->post('item_name1');
			$qty12 = $this->input->post('qty12');
			$subsections = $this->input->post('subsection');
			$subsectionv = $this->input->post('subsectionvl');
			$gold_grade1 = $this->input->post('gold_grade1');
			$weight1 = $this->input->post('weight1');
			$price = $this->input->post('price');
			$mini1 = $this->input->post('mini1');
			$code1 = $this->input->post('code1');
			$id2 = $this->input->post('id2');
			$startDate = $this->input->post('startDate');


			/*  Extra Code 
			  for($index=0; $index<count($codes_arr);$index++){

			  // echo "\t".$codes_arr[$index]."\t".$id2_arr[$index]."\t".$mini1_arr[$index]."\t".$subsections_arr[$index]."\t".$subsectionv_arr[$index]."\t".$item_name1_arr[$index]."\t".$price_arr[$index]."\t".$startDate_arr[$index]."\t".$total_price_final1_arr[$index]."<br>";

			  $other_nmae    =$this->input->post('other_name');
			  $other_nmae1    =$this->input->post('other1');
			  $total_othercost = $this->input->post('total_othercost'.$codes_arr[$index]);


			  $cc = $codes_arr[$index];
			  //for($index1 = 0 ;$index1<count($other_nmae[$cc]);$index1++){}
			  }


			 */


			//  $total_price_final1    =$this->input->post('total_price_final1'); 







			$addi_card_numb = $this->input->post("addi_card_numb");

			$suspend_id = $this->input->post('suspend_id');
			$row_count = $this->input->post('row_count');
			$card_numb = $this->input->post('card_numb');

			$subTotal = $this->input->post('to1');
			$dis_amt = $this->input->post('dis_amt');
			$grandTotal = $this->input->post('final_total_payable');
			$total_item_qty = $this->input->post('final_total_qty');
			$taxTotal = $this->input->post('tax_amt');

			$customer_id = $this->input->post('customer');
			$paid_by = $this->input->post('paid_by');
			$cheque = $this->input->post('cheque');
			$paid_amt = $this->input->post('paid');
			$return_change = $this->input->post('returned_change');

			$user_id = $this->session->userdata('user_id');
			$user_outlet = $this->input->post('out');
			$tm = date('Y-m-d H:i:s', time());

			$custDtaData = $this->Constant_model->getDataOneColumn('customers', 'id', $customer_id);
			$cust_full_name = $custDtaData[0]->fullname;
			$cust_email = $custDtaData[0]->email;
			$cust_mobile = $custDtaData[0]->mobile;

			$pay_name = '';
			$payNameData = $this->Constant_model->getDataOneColumn('payment_method', 'id', $paid_by);
			if (count($payNameData) == 1) {
				$pay_name = $payNameData[0]->name;
			}

			$vt_status = '';
			if ($paid_by == '6') {			// Debit;
				$vt_status = '0';
			} else {						// Full Payment;
				$vt_status = '1';
			}
			if ($paid_by == 8) {
				$this->db->query("UPDATE customers set deposit=deposit-$paid_amt WHERE id=$customer_id");
			}

			$outlet_name = '';
			$outlet_address = '';
			$outlet_contact = '';
			$outlet_footer = '';

			$outletDtaData = $this->Constant_model->getDataOneColumn('outlets', 'id', $user_outlet);
			$outlet_name = $outletDtaData[0]->name;
			$outlet_address = $outletDtaData[0]->address;
			$outlet_contact = $outletDtaData[0]->contact_number;
			$outlet_footer = $outletDtaData[0]->receipt_footer;

			$discount_percentage = '';

			if (empty($dis_amt)) {
				$dis_amt = 0;
			} elseif (strpos($dis_amt, '%') > 0) {
				$discount_percentage = $dis_amt;

				$temp_dis_Array = explode('%', $dis_amt);
				$temp_dis = $temp_dis_Array[0];

				$temp_item_price = 0;



				for ($i = 0; $i < count($codes); $i++) {
//echo $item_name1[$i]."\t";
					$total_item_qty+= $qty12[$i];
//echo $gold_grade1[$i]."\t";
					$total_weight+= $weight1[$i];
					$paid_amt += $price[$i];
					$minium += $mini1[$i];
					$total_price+= $total_price_final1[$i];
//echo "<br>";
				}


				for ($i = 0; $i < count($codes); ++$i) {
					//$pro_ = $this->Constant_model->getDataOneColumn('add_transfer', 'trans_rjo', $id2[$i]);                
					//$pro = $this->Constant_model->getDataOneColumn('gold_products', 'gpro_id', $pro_[0]->item_id);    
					//$pcode = $pro[0]->gpro_code;
					$price = $price[$i];
					$qty = $qty12[$i];
					$minium += $mini1[$i];
					if (!empty($pcode)) {
						$temp_item_price += ($price * $qty);
					}
				}

				$dis_amt = number_format(($temp_item_price * ($temp_dis / 100)), 2, '.', '');
			}
			$current_orders = $this->db->from('orders_gold')->where("outlet_id=" . $user_outlet)->count_all_results();  // Produces an integer, like 25
			$current_orders++; //echo $current_orders;exit;
			// Insert Into Order;
			$ins_order_data = array(
				'customer_id' => $customer_id,
				'customer_name' => $cust_full_name,
				'customer_email' => $cust_email,
				'customer_mobile' => $cust_mobile,
				'ordered_datetime' => $tm,
				'outlet_id' => $user_outlet,
				'outlet_name' => $outlet_name,
				'outlet_address' => $outlet_address,
				'outlet_contact' => $outlet_contact,
				'outlet_receipt_footer' => $outlet_footer,
				'gift_card' => $card_numb,
				'subtotal' => $subTotal,
				'discount_total' => $dis_amt,
				'discount_percentage' => $discount_percentage,
				'tax' => $taxTotal,
				'grandtotal' => $grandTotal,
				'total_items' => $total_item_qty,
				'payment_method' => $paid_by,
				'payment_method_name' => $pay_name,
				'cheque_number' => $cheque,
				'paid_amt' => $paid_amt,
				'return_change' => $return_change,
				'created_user_id' => $user_id,
				'created_datetime' => $tm,
				'vt_status' => $vt_status,
				'status' => '1',
				'card_number' => $addi_card_numb,
				'sid' => $current_orders,
				'sale_officer' => $this->input->post('sale'),
				'invoice_' => $this->input->post('invoice'),
				'minimum_total' => 100,
				'work_status' => 'Pending'
			);
			$order_id = $this->Constant_model->insertDataReturnLastId('orders_gold', $ins_order_data);
			//echo "Ordersss";

			$other_nmae = $this->input->post('other_name');
			$other_nmae1 = $this->input->post('other1');
			for ($index = 0; $index < count($codes_arr); $index++) {
				$total_othercost = $this->input->post('total_othercost' . $codes_arr[$index]);
				$cc = $codes_arr[$index];
				for ($index1 = 0; $index1 < count($other_nmae[$cc]); $index1++) {

					$data = array('code_' => $cc, 'invoice' => $this->input->post('invoice'), 'other_name' => $other_nmae[$cc][$index1], 'other_cost' => $other_nmae1[$cc][$index1], 'delivery_date' => $startDate_arr[$index], 'date_created' => date('Y-m-d'), 'order_id' => $order_id);
					$ordercs = $this->Constant_model->insertDataReturnLastId('other_cost_and_name_estimate_order', $data);
				}
			}

			for ($i = 0; $i < count($codes_arr); $i++) {

				if ($id2_arr[$i] == 'newitem') {
					$pro_ = $this->Constant_model->getDataOneColumn('add_transfer', 'trans_rjo', $codes_arr[$i]);
					$pro = $this->Constant_model->getDataOneColumn('gold_products', 'gpro_id', $pro_[0]->item_id);
					$pcode = $pro[0]->gpro_code;
				} else {
					$pcode = 0;
				}

				$price = $total_price_final1_arr[$i];
				$qty = $qty12_arr[$i];
				$subs = $subsections_arr[$i];
				$subv = $subsectionv_arr[$i];
				$weightt = $weight1_arr[$i];
				$cost = $price_arr[$i];
				$weight = $weight1[$i];

				if (!empty($pcode) || $pcode == 0) {
					$ins_order_item_data = array(
						'order_id' => $order_id,
						'product_code' => $pcode,
						'product_name' => $item_name1_arr[$i],
						'product_category' => 0,
						'cost' => $cost,
						'price' => $price,
						'qty' => $qty,
						'weight' => $weightt,
						'subv' => $subv,
						'subs' => $subs,
						'work_status_item' => 'Pending'
					);
					$this->Constant_model->insertData('order_items_gold', $ins_order_item_data);

					// Deduction Inventory -- START;
					$ex_qty = 0;
					$ckInvData = $this->Constant_model->getDataTwoColumn('gold_inventory', 'gold_code', $pcode, 'outlet_id', $user_outlet);

					if (count($ckInvData) == 1) {
						$ex_inv_id = $ckInvData[0]->id;
						$ex_qty = $ckInvData[0]->i_gold_qty;

						$deduct_qty = 0;
						$deduct_qty = $ex_qty - $qty;

						$upd_inv_data = array(
							'i_gold_qty' => $deduct_qty,
						);
						$this->Constant_model->updateData('gold_inventory', $upd_inv_data, $ex_inv_id);
					}
					// Deduction Inventory -- END;
				}
			}
			// Order Item -- END;

			if ($suspend_id > 0) {
				$ckSusData = $this->Constant_model->getDataOneColumn('suspend', 'id', $suspend_id);

				if (count($ckSusData) == 1) {
					$upd_data = array(
						'updated_user_id' => $user_id,
						'updated_datetime' => $tm,
						'status' => '1',
					);
					$this->Constant_model->updateData('suspend', $upd_data, $suspend_id);
				}
			}

			// Gift Card;
			if (!empty($card_numb)) {
				$ckGiftResult = $this->db->query("SELECT * FROM gift_card WHERE card_number = '$card_numb' ");
				$ckGiftRows = $ckGiftResult->num_rows();
				if ($ckGiftRows == 1) {
					$ckGiftData = $ckGiftResult->result();

					$ckGift_id = $ckGiftData[0]->id;

					$upd_gift_data = array(
						'status' => '1',
						'updated_user_id' => $user_id,
						'updated_datetime' => $tm,
					);
					$this->Constant_model->updateData('gift_card', $upd_gift_data, $ckGift_id);

					unset($ckGiftData);
				}
				unset($ckGiftResult);
				unset($ckGiftRows);
			}

			redirect(base_url() . 'gold/view_invoice?id=' . $order_id, 'refresh');
		}
	}

	public function insertSale() {
		if (isset($_POST['hold_bill_submit'])) {
			$customer = $this->input->post('customer');
			$hold_ref = $this->input->post('hold_ref');

			$row_count = $this->input->post('row_count');
			$subTotal = $this->input->post('subTotal');
			$dis_amt = $this->input->post('dis_amt');

			$grandTotal = $this->input->post('final_total_payable');
			$total_item_qty = $this->input->post('final_total_qty');
			$taxTotal = $this->input->post('tax_amt');

			$user_id = $this->session->userdata('user_id');
			$user_outlet = $this->input->post('outlet');
			$tm = date('Y-m-d H:i:s', time());

			if (empty($dis_amt)) {
				$dis_amt = 0;
			} elseif (strpos($dis_amt, '%') > 0) {
				$temp_dis_Array = explode('%', $dis_amt);
				$temp_dis = $temp_dis_Array[0];

				$temp_item_price = 0;

				for ($i = 1; $i <= $row_count; ++$i) {
					$pcode = $this->input->post("pcode_$i");
					$price = $this->input->post("price_$i");
					$qty = $this->input->post("qty_$i");

					if (!empty($pcode)) {
						$temp_item_price += ($price * $qty);
					}
				}

				$dis_amt = number_format(($temp_item_price * ($temp_dis / 100)), 2, '.', '');
			}

			// Get Customer Detail;
			$custDtaData = $this->Constant_model->getDataOneColumn('customers', 'id', $customer);
			$custDta_fn = $custDtaData[0]->fullname;
			$custDta_email = $custDtaData[0]->email;
			$custDta_mb = $custDtaData[0]->mobile;
			//  $this->Constant_model->getDataOneColumn('orders', 'outlet_id', $user_outlet);

			$ins_sus_data = array(
				'customer_id' => $customer,
				'fullname' => $custDta_fn,
				'email' => $custDta_email,
				'mobile' => $custDta_mb,
				'ref_number' => $hold_ref,
				'outlet_id' => $user_outlet,
				'subtotal' => $subTotal,
				'discount_total' => $dis_amt,
				'tax' => $taxTotal,
				'grandtotal' => $grandTotal,
				'total_items' => $total_item_qty,
				'created_user_id' => $user_id,
				'created_datetime' => $tm,
				'status' => '0'
			);
			$sus_id = $this->Constant_model->insertDataReturnLastId('suspend', $ins_sus_data);

			// Order Item -- START;
			for ($i = 1; $i <= $row_count; ++$i) {
				$pcode = $this->input->post("pcode_$i");
				$price = $this->input->post("price_$i");
				$qty = $this->input->post("qty_$i");

				if (!empty($pcode)) {
					$pcodeDtaData = $this->Constant_model->getDataOneColumn('products', 'code', $pcode);
					$pcode_name = $pcodeDtaData[0]->name;
					$pcode_categeory_id = $pcodeDtaData[0]->category;
					$pcode_cost = $pcodeDtaData[0]->purchase_price;

					$ins_sus_item_data = array(
						'suspend_id' => $sus_id,
						'product_code' => $pcode,
						'product_name' => $pcode_name,
						'product_category' => $pcode_categeory_id,
						'product_cost' => $pcode_cost,
						'qty' => $qty,
						'product_price' => $price,
					);
					$this->Constant_model->insertData('suspend_items', $ins_sus_item_data);
				}
			}

			$this->session->set_flashdata('alert_msg', array('success', 'Add Opened Bill', 'Successfully Added to Opened Bill.'));
			redirect(base_url() . 'pos');
		} elseif (isset($_POST['add_prod_submit'])) {
			$pop_pcode = $this->input->post('pop_pcode');
			$pop_pname = $this->input->post('pop_pname');
			$pop_pcate = $this->input->post('pop_pcate');
			$pop_price = $this->input->post('pop_price');
			$mini_amt = 0;

			$user_id = $this->session->userdata('user_id');
			$tm = date('Y-m-d H:i:s', time());

			$ckProdCodeResult = $this->db->query("SELECT * FROM products WHERE code = '$pop_pcode' ");
			$ckProdCodeRows = $ckProdCodeResult->num_rows();

			if ($ckProdCodeRows > 0) {
				?>
				<script type="text/javascript">
				    alert("Product Code : <?php echo $pop_pcode; ?>is already existing in the system! Please try another one");
				    window.location.href = "<?= base_url() ?>pos";
				</script>
				<?php
			} else {
				$ins_prod_data = array(
					'code' => $pop_pcode,
					'name' => $pop_pname,
					'category' => $pop_pcate,
					'retail_price' => $pop_price,
					'thumbnail' => 'no_image.jpg',
					'created_user_id' => $user_id,
					'created_datetime' => $tm,
					'status' => '1',
				);
				$this->Constant_model->insertData('products', $ins_prod_data);

				$this->session->set_flashdata('alert_msg', array('success', 'Add New Product', 'Successfully Added New Product.'));
				redirect(base_url() . 'pos');
			}
		} else {	// Sales;
			$codes = $this->input->post('code1');
			$id2 = $this->input->post('id2');

			$item_name1 = $this->input->post('item_name1');
			$qty12 = $this->input->post('qty12');

			$subsections = $this->input->post('subsection');
			$subsectionv = $this->input->post('subsectionvl');
//$gold_grade1        =$this->input->post('gold_grade1');
			$weight1 = $this->input->post('weight1');
			$price = $this->input->post('price');
			$mini1 = $this->input->post('mini1');
			$total_price_final1 = $this->input->post('total_price_final1');

			$addi_card_numb = $this->input->post("addi_card_numb");

			$suspend_id = $this->input->post('suspend_id');
			$row_count = $this->input->post('row_count');
			$card_numb = $this->input->post('card_numb');

			$subTotal = $this->input->post('to1');
			$dis_amt = $this->input->post('dis_amt');
			$grandTotal = $this->input->post('final_total_payable');
			$total_item_qty = $this->input->post('final_total_qty');
			$taxTotal = $this->input->post('tax_amt');

			$customer_id = $this->input->post('customer');
			$paid_by = $this->input->post('paid_by');
			$cheque = $this->input->post('cheque');
			$paid_amt = $this->input->post('paid');
			$return_change = $this->input->post('returned_change');

			$user_id = $this->session->userdata('user_id');
			$user_outlet = $this->input->post('out');
			$tm = date('Y-m-d H:i:s', time());

			$custDtaData = $this->Constant_model->getDataOneColumn('customers', 'id', $customer_id);
			$cust_full_name = $custDtaData[0]->fullname;
			$cust_email = $custDtaData[0]->email;
			$cust_mobile = $custDtaData[0]->mobile;

			$pay_name = '';
			$payNameData = $this->Constant_model->getDataOneColumn('payment_method', 'id', $paid_by);
			if (count($payNameData) == 1) {
				$pay_name = $payNameData[0]->name;
			}

			$vt_status = '';
			if ($paid_by == '6') {			// Debit;
				$vt_status = '0';
			} else {						// Full Payment;
				$vt_status = '1';
			}
			if ($paid_by == 8) {
				$this->db->query("UPDATE customers set deposit=deposit-$paid_amt WHERE id=$customer_id");
			}

			$outlet_name = '';
			$outlet_address = '';
			$outlet_contact = '';
			$outlet_footer = '';

			$outletDtaData = $this->Constant_model->getDataOneColumn('outlets', 'id', $user_outlet);
			$outlet_name = $outletDtaData[0]->name;
			$outlet_address = $outletDtaData[0]->address;
			$outlet_contact = $outletDtaData[0]->contact_number;
			$outlet_footer = $outletDtaData[0]->receipt_footer;

			$discount_percentage = '';

			if (empty($dis_amt)) {
				$dis_amt = 0;
			} elseif (strpos($dis_amt, '%') > 0) {
				$discount_percentage = $dis_amt;

				$temp_dis_Array = explode('%', $dis_amt);
				$temp_dis = $temp_dis_Array[0];

				$temp_item_price = 0;



				for ($i = 0; $i < count($codes); $i++) {
//echo $item_name1[$i]."\t";
					$total_item_qty+= $qty12[$i];
//echo $gold_grade1[$i]."\t";
					$total_weight+= $weight1[$i];
					$paid_amt += $price[$i];
					$minium += $mini1[$i];
					$total_price+= $total_price_final1[$i];
//echo "<br>";
				}


				for ($i = 0; $i < count($codes); ++$i) {
					$pro_ = $this->Constant_model->getDataOneColumn('add_transfer', 'trans_rjo', $id2[$i]);
					$pro = $this->Constant_model->getDataOneColumn('gold_products', 'gpro_id', $pro_[0]->item_id);
					$pcode = $pro[0]->gpro_code;
					$price = $price[$i];
					$qty = $qty12[$i];
					$minium += $mini1[$i];
					if (!empty($pcode)) {
						$temp_item_price += ($price * $qty);
					}
				}

				$dis_amt = number_format(($temp_item_price * ($temp_dis / 100)), 2, '.', '');
			}
			$current_orders = $this->db->from('orders')->where("outlet_id=" . $user_outlet)->count_all_results();  // Produces an integer, like 25
			$current_orders++; //echo $current_orders;exit;
			// Insert Into Order;
			$ins_order_data = array(
				'customer_id' => $customer_id,
				'customer_name' => $cust_full_name,
				'customer_email' => $cust_email,
				'customer_mobile' => $cust_mobile,
				'ordered_datetime' => $tm,
				'outlet_id' => $user_outlet,
				'outlet_name' => $outlet_name,
				'outlet_address' => $outlet_address,
				'outlet_contact' => $outlet_contact,
				'outlet_receipt_footer' => $outlet_footer,
				'gift_card' => $card_numb,
				'subtotal' => $subTotal,
				'discount_total' => $dis_amt,
				'discount_percentage' => $discount_percentage,
				'tax' => $taxTotal,
				'grandtotal' => $grandTotal,
				'total_items' => $total_item_qty,
				'payment_method' => $paid_by,
				'payment_method_name' => $pay_name,
				'cheque_number' => $cheque,
				'paid_amt' => $paid_amt,
				'return_change' => $return_change,
				'created_user_id' => $user_id,
				'created_datetime' => $tm,
				'vt_status' => $vt_status,
				'status' => '1',
				'card_number' => $addi_card_numb,
				'sid' => $current_orders,
				'sale_officer' => $this->input->post('sale'),
				'invoice_' => $this->input->post('invoice'),
				'minimum_total' => 100
			);
			$order_id = $this->Constant_model->insertDataReturnLastId('orders_gold', $ins_order_data);

			// Order Item -- START;
			for ($i = 0; $i < count($codes); $i++) {
				$pro_ = $this->Constant_model->getDataOneColumn('add_transfer', 'trans_rjo', $id2[$i]);
				$pro = $this->Constant_model->getDataOneColumn('gold_products', 'gpro_id', $pro_[0]->item_id);
				$pcode = $pro[0]->gpro_code;
				$price = $total_price_final1[$i];
				$qty = $qty12[$i];
				$subs = $subsections[$i];
				$subv = $subsectionv[$i];

				$weight = $weight1[$i];

				if (!empty($pcode)) {
					$pcode_name = '';
					$pcode_category = '0';
					$cost = 0;

					$pcodeDtaData = $this->Constant_model->getDataOneColumn('gold_products', 'gpro_code', $pcode);
					if (count($pcodeDtaData) == 1) {
						$pcode_name = $pcodeDtaData[0]->gpro_name;
						$pcode_category = $pcodeDtaData[0]->gpro_cate_id;
						$cost = $pcodeDtaData[0]->purchase;
					} else {
						if ($suspend_id > 0) {
							$ckSusItemResult = $this->db->query("SELECT * FROM suspend_items WHERE suspend_id = '$suspend_id' AND product_code = '$pcode' ");
							$ckSusItemRows = $ckSusItemResult->num_rows();
							if ($ckSusItemRows == 1) {
								$ckSusItemData = $ckSusItemResult->result();

								$pcode_name = $ckSusItemData[0]->product_name;
								$pcode_category = $ckSusItemData[0]->product_category;
								$cost = $ckSusItemData[0]->product_cost;

								unset($ckSusItemData);
							}
							unset($ckSusItemResult);
							unset($ckSusItemRows);
						}
					}

					$ins_order_item_data = array(
						'order_id' => $order_id,
						'product_code' => $pcode,
						'product_name' => $pcode_name,
						'product_category' => $pcode_category,
						'cost' => $cost,
						'price' => $price,
						'qty' => $qty,
						'weight' => $weight,
						'subv' => $subv,
						'subs' => $subs,
					);
					$this->Constant_model->insertData('order_items_gold', $ins_order_item_data);

					// Deduction Inventory -- START;
					$ex_qty = 0;
					$ckInvData = $this->Constant_model->getDataTwoColumn('gold_inventory', 'gold_code', $pcode, 'outlet_id', $user_outlet);

					if (count($ckInvData) == 1) {
						$ex_inv_id = $ckInvData[0]->id;
						$ex_qty = $ckInvData[0]->i_gold_qty;

						$deduct_qty = 0;
						$deduct_qty = $ex_qty - $qty;

						$upd_inv_data = array(
							'i_gold_qty' => $deduct_qty,
						);
						$this->Constant_model->updateData('gold_inventory', $upd_inv_data, $ex_inv_id);
					}
					// Deduction Inventory -- END;
				}
			}
			// Order Item -- END;

			if ($suspend_id > 0) {
				$ckSusData = $this->Constant_model->getDataOneColumn('suspend', 'id', $suspend_id);

				if (count($ckSusData) == 1) {
					$upd_data = array(
						'updated_user_id' => $user_id,
						'updated_datetime' => $tm,
						'status' => '1',
					);
					$this->Constant_model->updateData('suspend', $upd_data, $suspend_id);
				}
			}

			// Gift Card;
			if (!empty($card_numb)) {
				$ckGiftResult = $this->db->query("SELECT * FROM gift_card WHERE card_number = '$card_numb' ");
				$ckGiftRows = $ckGiftResult->num_rows();
				if ($ckGiftRows == 1) {
					$ckGiftData = $ckGiftResult->result();

					$ckGift_id = $ckGiftData[0]->id;

					$upd_gift_data = array(
						'status' => '1',
						'updated_user_id' => $user_id,
						'updated_datetime' => $tm,
					);
					$this->Constant_model->updateData('gift_card', $upd_gift_data, $ckGift_id);

					unset($ckGiftData);
				}
				unset($ckGiftResult);
				unset($ckGiftRows);
			}

			redirect(base_url() . 'gold/view_invoice?id=' . $order_id, 'refresh');
		}
	}

	public function list_sales() {
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$pagination_limit = $paginationData[0]->pagination;
		$setting_dateformat = $paginationData[0]->datetime_format;
		$data['user_role'] = $this->session->userdata('user_role');

		$data['setting_dateformat'] = $setting_dateformat;

		$this->load->view('includes/header');

		$this->load->view('sales/list_sales', $data);

		$this->load->view('includes/footer');
	}

	public function addGoldsmith() {
		$format_array = ci_date_format();
		$data['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$data['site_currency'] = $format_array['siteSetting_currency'];
		$data['dateformat'] = $format_array['dateformat'];
		$this->load->view('add_goldsmith', $data);
	}

// Save Goldsmith into the database
	public function save_goldsmith() {

		$old_date = $this->input->post('dob');
		$old_date_timestamp = strtotime($old_date);
		$new_date = date('Y-m-d', $old_date_timestamp);

		$array_data = array(
			'fullname' => $this->input->post('fullname'),
			'email' => $this->input->post('email'),
			'phone' => $this->input->post('mobile'),
			'address' => $this->input->post('address'),
			'land_phone_number' => $this->input->post('land'),
			'dob' => $new_date,
			'weight__qty_pergram' => $this->input->post('emp-num'),
			'gender' => 'Male',
			'status' => 'active',
			'gold_smith_num' => $this->input->post('emp-pergram'),
			'date_created' => date('Y-m-d'));

		$data = $this->Gold_module->insert_data('gold_smith', $array_data);
		
		
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function goldsmith() {

		$permisssion_url = 'goldsmith';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$format_array = ci_date_format();
		$data['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$data['site_currency'] = $format_array['siteSetting_currency'];
		$data['dateformat'] = $format_array['dateformat'];
		$data['goldsmith'] = $this->Gold_module->select_All('gold_smith');
		$this->load->view('includes/header');
		$this->load->view('gold/goldsmith_list', $data);
		$this->load->view('includes/footer');
	}
	
	public function gold_smith_details()
	{
		$id = $this->input->get('id');
		$data['order_id'] = $id;
		$data['getResult'] = $this->Gold_module->getgoldsmith_details($id);
        $this->load->view('gold/all_goldsmith_details', $data);
	}
	

// Add Gold Grade page
	public function addgrade() {
                
		$permisssion_url = 'addgrade';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		$us_id = $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
		$data['logged_name'] = $get_logged_name->fullname;
		$data['getGoldeGrade'] =  $this->Gold_module->getGoldeGrade();
		$this->load->view('add_grade',$data);
	}
	
	
	public function Editgrade()
	{
		$id = $this->input->get('id');
		$us_id = $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
		$data['logged_name'] = $get_logged_name->fullname;
		$data['getgold'] =  $this->Gold_module->getSingleGrade($id);
		$this->load->view('edit_grade',$data);
	}
	
	
	public function updategrade()
	{
		$id = $this->input->post('grade_id');
		$array_data = array(
			'last_gold_purity'	=> $this->input->post('last_gold_purity'),
			'gold_purity'	=> $this->input->post('gold_purity'),
		);
		
		$this->session->set_flashdata('SUCCESSMSG', "Data Successfully Updated!!");
		$this->Gold_module->updategrade($array_data,$id);
		redirect('Gold/addgrade');
	}
		
	
	public function save_goldgrade() {
		
		$validation = $this->Gold_module->CheckValidation($this->input->post('fullname'));
		if($validation == 0)
		{
			$array_data = array(
			'grade_name'	=> $this->input->post('fullname'),
			'status'		=> 'active',
			'trash'			=> '1',
			'gold_purity'	=> $this->input->post('gold_purity'),
			'date_created'	=> date('Y-m-d H:i:s'),
			'created_by'	=> $this->session->userdata('user_id')
			);

			$data = $this->Gold_module->insert_data('gold_grade', $array_data);
			$json['suceess'] = true;
		}
		else
		{
			$json['error'] = true;

		}
		echo json_encode($json);
	}

	public function save_newgoldgrade() {
		$this->form_validation->set_rules('rate_per_gram', 'Rate Per Gram', 'required|numeric');
		if ($this->form_validation->run() == FALSE)
		{
			$this->Gold_gold_prices();
		}
		else
		{
			$array = array(
				'gp_grade' => $this->input->post('gold_grade_id'),
				'gp_purity' => $this->input->post('gold_purity'),
				'gp_price' => $this->input->post('rate_per_gram'),
				'created_by' =>$this->session->userdata('user_id'),
				'gp_date' => date('Y-m-d'),
				'gp_date_created' => date('Y-m-d H:i:s')
			);

			$this->Gold_module->insert_data('gold_prices', $array);
			$this->session->set_flashdata('SUCCESSMSG', "Record Added Successfully!!");
			redirect(base_url() . 'Gold/Gold_gold_prices');
		}
	}

	public function save_goldgrade_purity() {



		$grade_name = $this->input->post('fullname12');


		$condition = array('grade_name' => 24);
		$data1 = $this->Gold_module->get_all_data_specific_id('gold_grade', $condition);
		$purity = ($grade_name / 24) * $data1[0]->gold_purity;
		$price = $purity * $data1[0]->grade_price;




		$array_data = array(
			'grade_name' => $grade_name,
			'grade_price' => $price / 100,
			'status' => 'active',
			'trash' => '1',
			'gold_purity' => $purity,
			'date_created' => date('Y-m-d')
		);
		$data = $this->Gold_module->insert_data('gold_grade', $array_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

// Add RJO  page
// old function Name addrjo
	/*
	  public function add_refine_order(){
	  $data['grades'] = $this->Gold_module->select_all('gold_grade');
	  $data['goldsmiths'] = $this->Gold_module->select_all('gold_smith');
	  $data['outlets'] = $this->Gold_module->select_all('outlets');
	  $data['warehouse'] = $this->Gold_module->select_all('stores');
	  $this->load->view('add_rjo',$data);
	  }
	 */

	function get_price() {
		$condition = array('grade_id' => $this->input->post('data'));
		$data = $this->Gold_module->edit_specific_data('gold_grade', $condition);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_jobno() {
		$condition = array('gold_smith_id' => $this->input->post('data'), 'status' => 'pending');
		$data['rjos'] = $this->Gold_module->get_all_data_specific_id('refined_job_order', $condition);
		$data_['message'] = $this->load->view('jobs.php', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($data_));
	}

	function get_netweight() {
		$condition = array('rjo' => $this->input->post('data'));
		$data = $this->Gold_module->get_all_data_specific_id_join('refined_job_order', $condition);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_netstore() {
		$condition = array('out_id' => $this->input->post('data'));

		$data['stores'] = $this->Gold_module->getwarehouse('outlet_warehouse', $condition);
		$data['message1'] = $this->load->view('gold/store_name.php', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

/// Save refined job order
	public function save_addrjo() {

		$array_data = array(
			'gold_smith_id' => $this->input->post('gold'),
			'outlet_id' => $this->input->post('out'),
			'gold_grade' => $this->input->post('grade'),
			'gold_weigth' => $this->input->post('weight'),
			'estimated_weigth' => $this->input->post('total'),
			'date' => $this->input->post('date2'),
			'rjo' => $this->input->post('job'),
			'rjo_store_id' => $this->input->post('ware'),
			'status' => 'pending',
			'date_created' => date('Y-m-d')
		);
		$data = $this->Gold_module->insert_data('refined_job_order', $array_data);

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

// Add RJO  page
// Old Function Name addrjrn 
	/* public function add_refined_receive_note(){
	  $data['grades'] = $this->Gold_module->select_all('gold_grade');
	  $data['goldsmiths'] = $this->Gold_module->select_all('gold_smith');
	  $data['outlets'] = $this->Gold_module->select_all('outlets');
	  $data['warehouse'] = $this->Gold_module->select_all('stores');
	  $this->load->view('rgrn',$data);
	  } */

	public function save_addrjrn() {

		/*
		  echo "<pre>";
		  print_r($_POST);
		  echo "</pre>";
		  die;
		 */
		$array_data = array(
			'gs_id' => $this->input->post('gold'),
			'outlet' => $this->input->post('out1'),
			'gold_grade' => $this->input->post('grade1'),
			'actual_gold_rec' => $this->input->post('weight'),
			'netgold_amount' => $this->input->post('total1'),
			'rjrn_store_id' => $this->input->post('store1'),
			'date_' => $this->input->post('date2'),
			'rjrnn_no' => $this->input->post('job'),
			'job_no' => $this->input->post('jobno'),
			'date_created' => date('Y-m-d')
		);


		$data = $this->Gold_module->insert_data('refined_job_received_note', $array_data);
		$data = $this->Gold_module->updated_data('refined_job_order', array('status' => 'completed'), array('rjo' => $this->input->post('jobno')));
		//   echo $this->db->last_query();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

// Old Function name view_gold
	/*
	  public function refined_gold()
	  {

	  $data=records_with_page('bank_dt','bank_transfers','id',2, 'desc');
	  $format_array = ci_date_format();
	  $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
	  $data['site_currency'] = $format_array['siteSetting_currency'];
	  $data['dateformat'] = $format_array['dateformat'];
	  $data['outlet'] =$this->Gold_module->select_all('outlets');
	  $data['goldsmith'] =$this->Gold_module->select_all('gold_smith');
	  $data['grade'] =$this->Gold_module->select_all('gold_grade');
	  $data['stores'] =$this->Gold_module->select_all('stores');
	  $data['user_role']=   $this->session->userdata('user_role');
	  $this->load->view('includes/header');
	  $this->load->view('gold/search-gold', $data);
	  $this->load->view('includes/footer');

	  }
	 */
	public function search_gold() {
		$con = array();
		if ($this->input->post('grade') != 'all') {
			$con['refined_job_received_note.gold_grade'] = $this->input->post('grade');
		}

		if ($this->input->post('gold') != 'all') {
			$con['refined_job_received_note.gs_id'] = $this->input->post('gold');
		}

		if ($this->input->post('outlet') != 'all') {
			$con['refined_job_received_note.outlet'] = $this->input->post('outlet');
		}

		if ($this->input->post('store') != 'all') {
			$con['refined_job_received_note.rjrn_store_id'] = $this->input->post('store');
		}

		if (empty($this->input->post('start_date'))) {
			
		} else {
			$con['refined_job_received_note.date_created>='] = date("Y-m-d", strtotime($this->input->post('start_date')));
			$con['refined_job_received_note.date_created<='] = date("Y-m-d", strtotime($this->input->post('end_date')));
		}
		$single_status['gold'] = $this->Gold_module->select_three_join('refined_job_received_note', $con);

		$data['message'] = $this->load->view('search_ajax_gold.php', $single_status, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function Gold_gradeview() {
                $permisssion_url = 'Gold_gradeview';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		

		$data['results'] = $this->Gold_module->select_all('gold_grade');
		$this->load->view('gold_grade', $data);
	}

	public function Gold_gold_prices() {
                
		$permisssion_url = 'Gold_gold_prices';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$us_id = $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
		$data['logged_name'] = $get_logged_name->fullname;
		$data['getGoldeGrade'] =  $this->Gold_module->getGoldeGradeDetail();
		$data['getlastgrade'] =  $this->Gold_module->getLastGoldeGradeDetail();
		$data['gold_prices'] = $this->Gold_module->getGoldPriceDetail();
		$this->load->view('includes/header');
		$this->load->view('gold/grade_price_view', $data);
		$this->load->view('includes/footer');
	}

	public function getGoldGradeDetail()
	{
		$gold_id = $this->input->post('gold_id');
		$getdata = $this->Gold_module->getGoldGradeDetail($gold_id);
		$data['gold_purity'] = $getdata->gold_purity;
		echo json_encode($data);
	}
	
	function get_matchCustomername() {
		$json = array();
		$cust_id= $this->input->post('id');
		
		$outstanding = $this->Gold_module->CustomerOutstandingBalance($cust_id);
		
		
		$customer_val	= $this->Gold_module->getmatchCustomer_Data($cust_id);
		if($customer_val->num_rows() > 0)
		{
			$deposit = $customer_val->row()->deposit;
			
			$bal = $deposit - $outstanding;
			
			$json['id']		= $customer_val->row()->id;
			$json['customer_name']    = $customer_val->row()->fullname;
			$json['customer_mobile']	= $customer_val->row()->mobile;
			$json['customer_email']	= $customer_val->row()->email;
			$json['customer_address']	= $customer_val->row()->address;
			$json['balance']	= $bal;
			$json['outstanding']	= $outstanding;
			
		}
		else
		{
			$json['id']	= '';
			$json['customer_name']  = '';	
			$json['customer_mobile']  = '';
			$json['customer_email']  = '';
			$json['customer_address']  = '';
			$json['balance']	= '';
			$json['outstanding']	= 0;
		}
		echo json_encode($json);
	}

	
	
	function updated_data_grade() {
		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='gold_gradeview')");
		if (!isset($permission_data[0]->edit_right) || (isset($permission_data[0]->edit_right) && $permission_data[0]->edit_right != 1)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Edit grade', 'You can not edit gold grade. Please ask administrator!'));
			redirect($this->agent->referrer());
		}
		
		$update_con = array('grade_id' => $this->input->post('id'));
		$array_data = array('gold_purity' => $this->input->post('gold_purity'),);
		
		$res = $this->Gold_module->updated_data('gold_grade', $array_data, $update_con);
		$this->output->set_content_type('application/json')->set_output(json_encode($res));
	}

	function grade_delete() {

		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='gold_gradeview')");

		if (!isset($permission_data[0]->delete_right) || (isset($permission_data[0]->delete_right) && $permission_data[0]->delete_right != 1)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Delete gold grade', 'You can not delete gold grade. Please ask administrator!'));
			redirect($this->agent->referrer());
		}

		$update_con = array('grade_id' => $this->input->post('data'));
		$res = $this->Gold_module->delete_data('gold_grade', $update_con);
		$this->output->set_content_type('application/json')->set_output(json_encode($res));
	}

///view_gold_status  renamed as  refined_gold_list

	/*  public function refine_order_list()
	  {

	  $data=records_with_page('bank_dt','bank_transfers','id',2, 'desc');
	  $format_array = ci_date_format();
	  $data['site_dateformat'] = $format_array['siteSetting_dateformat'];
	  $data['site_currency'] = $format_array['siteSetting_currency'];
	  $data['dateformat'] = $format_array['dateformat'];
	  $data['outlet'] =$this->Gold_module->select_all('outlets');
	  $data['goldsmith'] =$this->Gold_module->select_all('gold_smith');
	  $data['grade'] =$this->Gold_module->select_all('gold_grade');
	  $data['user_role']=   $this->session->userdata('user_role');
	  $this->load->view('includes/header');
	  $this->load->view('gold/search-gold_status', $data);
	  $this->load->view('includes/footer');

	  }
	 */

	public function search_gold_status() {


		$con = array();
		if ($this->input->post('grade') != 'all') {
			$con['refined_job_order.gold_grade'] = $this->input->post('grade');
		}

		if ($this->input->post('gold') != 'all') {
			$con['refined_job_order.gold_smith_id'] = $this->input->post('gold');
		}

		if ($this->input->post('outlet') != 'all') {
			$con['refined_job_order.outlet_id'] = $this->input->post('outlet');
		}



		$con['refined_job_order.status'] = $this->input->post('status');
		$con['refined_job_order.date_created>='] = date("Y-m-d", strtotime($this->input->post('start_date')));
		$con['refined_job_order.date_created<='] = date("Y-m-d", strtotime($this->input->post('end_date')));

		$single_status['gold'] = $this->Gold_module->select_three_join_status('refined_job_order', $con);

		$data['message'] = $this->load->view('gold/rjo_ajax.php', $single_status, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function search_gold_status_() {


		$con = array();
		if ($this->input->post('grade') != 'all') {
			$con['refined_job_order.gold_grade'] = $this->input->post('grade');
		}

		if ($this->input->post('gold') != 'all') {
			$con['refined_job_order.gold_smith_id'] = $this->input->post('gold');
		}

		if ($this->input->post('outlet') != 'all') {
			$con['refined_job_order.outlet_id'] = $this->input->post('outlet');
		}



		$con['refined_job_order.status'] = $this->input->post('status');
		$con['refined_job_order.date_created>='] = date("Y-m-d", strtotime($this->input->post('start_date')));
		$con['refined_job_order.date_created<='] = date("Y-m-d", strtotime($this->input->post('end_date')));

		$single_status['gold'] = $this->Gold_module->select_three_join_status('refined_job_order', $con);
		$data['message'] = $this->load->view('gold/searchrjo_ajax.php', $single_status, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function viewrjo() {
		$single_status = array();

		$format_array = ci_date_format();
		$single_status['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$single_status['site_currency'] = $format_array['siteSetting_currency'];
		$single_status['dateformat'] = $format_array['dateformat'];
		$single_status['outlet'] = $this->Gold_module->select_all('outlets');
		$single_status['goldsmith'] = $this->Gold_module->select_all('gold_smith');
		$single_status['grade'] = $this->Gold_module->select_all('gold_grade');
		$single_status['user_role'] = $this->session->userdata('user_role');
		$single_status['gold'] = $this->Gold_module->select_three_join_show('refined_job_order');

		$this->load->view('includes/header');
		$this->load->view('gold/viewrjo', $single_status); // $this->load->view('gold/viewrjo',$data);
		$this->load->view('includes/footer');
	}

	function gold_price() {

		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='gold_gold_prices')");
		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add gold prices', 'You can not add gold prices. Please ask administrator!'));
			redirect($this->agent->referrer());
		}

		$this->load->view('includes/header');
		$condition = array('grade_name' => 24);
		$condition1 = array('grade_name!=' => 24);
		$data['grade'] = $this->Gold_module->get_all_data_specific_id('gold_grade', $condition);
		$data['grade1'] = $this->Gold_module->get_all_data_specific_id('gold_grade', $condition1);
		$data['getgold_grade'] = $this->Gold_module->getgold_gradeData();
		$this->load->view('gold/gold_price', $data);
		$this->load->view('includes/footer');
	}
	
		function get_matchvalgradename() {
		$json = array();
		$grade_id= $this->input->post('grade_id');
	
		$grade_val	= $this->Gold_module->getmatch_gold_gradeData($grade_id);
		if($grade_val->num_rows() > 0)
		{
			$json['grade_id']		= $grade_val->row()->grade_id;
			$json['gold_purity']    = $grade_val->row()->gold_purity;
			$json['grade_price']	= $grade_val->row()->grade_price;
			
		}
		else
		{
			$json['grade_id']	= '';
			$json['gold_purity']  = 0;	
			$json['grade_price']  = 0;
		
		}
		echo json_encode($json);
	}
	

	function gold_price_ajax() {
		$condition1 = array('grade_name!=' => 24);
		$condition = array('grade_name' => 24);
		$data['grade1'] = $this->Gold_module->get_all_data_specific_id('gold_grade', $condition1);
		$data['grade'] = $this->Gold_module->get_all_data_specific_id('gold_grade', $condition);
		$datap['message'] = $this->load->view('gold/gold_price_ajax_form', $data, TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($datap));
	}

	public function addgold_product() {

		$format_array = ci_date_format();
		$single_status['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$single_status['site_currency'] = $format_array['siteSetting_currency'];
		$single_status['dateformat'] = $format_array['dateformat'];
		$single_status['outlets'] = $this->Gold_module->select_all('outlets');
		$single_status['warehouse'] = $this->Gold_module->select_all('stores');
		$single_status['grades'] = $this->Gold_module->select_all('gold_grade');
		$single_status['user_role'] = $this->session->userdata('user_role');
		$this->load->view('includes/header');
		$this->load->view('gold/add_product', $single_status);
		$this->load->view('includes/footer');
	}

	public function save_goldproduct() {

		$array_data = array(
			'gpro_name' => $this->input->post('gpro_name'),
			'gpro_weight' => $this->input->post('gpro_weight'),
			'gpro_updated_weight' => $this->input->post('gpro_weight'),
			'gpro_store_id' => $this->input->post('ware'),
			'gpro_outlet_id' => $this->input->post('out'),
			'grade_id' => $this->input->post('grade'),
			'gpro_date_added' => date('Y-m-d'),
			'gpro_date_creation' => date('Y-m-d'),
		);
		$data = $this->Gold_module->insert_data('gold_products', $array_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function add_transfer() {

		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='view_transfer')");

		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add transfer', 'You can not add transfer. Please ask administrator!'));
			redirect($this->agent->referrer());
		}

		$format_array = ci_date_format();
		$single_status['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$single_status['site_currency'] = $format_array['siteSetting_currency'];
		$single_status['dateformat'] = $format_array['dateformat'];
		$single_status['rjo'] = $this->Gold_module->select_all('refined_job_order');
		$single_status['warehouse'] = $this->Gold_module->select_all('stores');
		$single_status['grades'] = $this->Gold_module->select_all('gold_grade');
		$single_status['user_role'] = $this->session->userdata('user_role');
		$single_status['products'] = $this->Gold_module->select_all('gold_products');
		$this->load->view('includes/header');
		$this->load->view('gold/add-transfer', $single_status);
		$this->load->view('includes/footer');
	}

	public function save_transfer() {

		$condition = array('gpro_id' => $this->input->post('product_id'));
		$data1 = $this->Gold_module->get_record_by_id('gold_products', $condition);



		$array_data = array(
			'trans_rjo' => $this->input->post('out'),
			'trans_grade' => $this->input->post('grade'),
			'trans_profit' => $this->input->post('profit'),
			'trans_weight' => $this->input->post('weight'),
			'trans_stone' => $this->input->post('stone'),
			'trans_total_weight' => $this->input->post('total_weight'),
			'trans_stonecost' => $this->input->post('stonecost'),
			'trans_totalother' => $this->input->post('totalother'),
			'trans_day_price' => $this->input->post('day_price'),
			'trans_grade_' => $this->input->post('grade_'),
			'item_id' => $this->input->post('product_id'),
			'item_name' => $data1['message']->gpro_name,
			'trans_grade_minimum' => $this->input->post('grade_minimum'),
			'trans_note' => $this->input->post('note'),
			't_date_creation' => $this->input->post('gpro_name')
		);
		$data = $this->Gold_module->insert_data('add_transfer', $array_data);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_gold_day_price() {


//   $condition   =  array('gp_grade'=>$this->input->post('data'),'gp_date'=>date('Y-m-d'));
		$condition = array('gp_grade' => $this->input->post('data'));
		$data = $this->Gold_module->get_day_price('gold_prices', $condition);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_wastage_gram() {


//   $condition   =  array('gp_grade'=>$this->input->post('data'),'gp_date'=>date('Y-m-d'));
		$condition = array('gs_id' => $this->input->post('data'));
		$data = $this->Gold_module->get_record_by_id('gold_smith', $condition);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	public function store_transfer_record() {

		$user_id = $this->session->userdata('user_id');
		$permission_data = $this->Constant_model->getDataWhere('permissions', ' user_id=' . $user_id . " and resource_id=(select id from modules where name='list_store_transfer')");

		if (!isset($permission_data[0]->add_right) || (isset($permission_data[0]->add_right) && $permission_data[0]->add_right != 1)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add store transfer', 'You can not add store transfer. Please ask administrator!'));
			redirect($this->agent->referrer());
		}

		$format_array = ci_date_format();
		$single_status['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$single_status['site_currency'] = $format_array['siteSetting_currency'];
		$single_status['dateformat'] = $format_array['dateformat'];
		$single_status['rjo'] = $this->Gold_module->select_all('refined_job_order');
		$single_status['warehouse'] = $this->Gold_module->select_all('stores');
		$single_status['grades'] = $this->Gold_module->select_all('gold_grade');
		$single_status['goldsmith'] = $this->Gold_module->select_all('gold_smith');
		$single_status['products'] = $this->Gold_module->select_all('gold_products');
		$single_status['user_role'] = $this->session->userdata('user_role');
		$this->load->view('includes/header');
		$this->load->view('gold/stores-transfer-records', $single_status);
		$this->load->view('includes/footer');
	}

	/*


	  public function the_production()
	  {

	  $format_array = ci_date_format();
	  $single_status['site_dateformat'] = $format_array['siteSetting_dateformat'];
	  $single_status['site_currency'] = $format_array['siteSetting_currency'];
	  $single_status['dateformat'] = $format_array['dateformat'];
	  $single_status['rjo'] =$this->Gold_module->select_all('refined_job_order');
	  $single_status['warehouse'] =$this->Gold_module->select_all('stores');
	  $single_status['grades'] =$this->Gold_module->select_all('gold_grade');
	  $single_status['goldsmith'] =$this->Gold_module->select_all('gold_smith');
	  $single_status['outlets'] =$this->Gold_module->select_all('outlets');
	  $single_status['products'] =$this->Gold_module->select_all('gold_products');
	  $single_status['user_role']=   $this->session->userdata('user_role');
	  $this->load->view('includes/header');
	  $this->load->view('gold/production',$single_status);
	  $this->load->view('includes/footer');
	  }


	  public function save_production(){

	  $len = $this->input->post('other1');
	  $names = $this->input->post('other_name');
	  for($i=0;$i<count($len);$i++){

	  $other_data = array('pro_reference_id'=>$this->input->post('reference'),'other_name'=>$names[$i],'other_cost'=>$len[$i],'date_created'=>$this->input->post('gpro_name'));
	  $data = $this->Gold_module->insert_data('other_cost_and_name',$other_data);
	  }


	  $array_data =  array(
	  'pro_reference'=>$this->input->post('reference'),
	  'pro_out_id'=>$this->input->post('out'),
	  'goldsmith'=>$this->input->post('goldsmith'),
	  'pro_date_created'=>$this->input->post('gpro_name'),
	  'pro_type'=>$this->input->post('type'),
	  'pro_qty'=>$this->input->post('qty'),
	  'pro_ware'=>$this->input->post('ware'),
	  'pro_grade'=>$this->input->post('grade'),
	  'pro_wastage'=>$this->input->post('wastage'),
	  'pro_total_product'=>$this->input->post('total_product'),
	  'pro_otherweight'=>$this->input->post('otherweight'),
	  'pro_wastage_cal'=>$this->input->post('wastage_cal'),
	  'pro_total_gold_wastage'=>$this->input->post('total_gold_wastage'),
	  'pro_goldsmith_was'=>$this->input->post('goldsmith_was'),
	  'pro_date'=>date('Y-m-d'),
	  'design_cost'=>$this->input->post('design-cost'),
	  'stone_cost'=>$this->input->post('stone-cost'),
	  'labour_unit_cost'=>$this->input->post('labourunit'),
	  'labour_cost'=>$this->input->post('labourtotal'),
	  'day_price'=>$this->input->post('day_price'),
	  );


	  $data = $this->Gold_module->insert_data('production',$array_data);
	  $this->output->set_content_type('application/json')->set_output(json_encode($data));


	  }


	  function view_production(){


	  $data['production']  = $this->Gold_module->production_join('production','gold_smith','stores','outlets');
	  $data['others'] = $this->Gold_module->select_all('other_cost_and_name');

	  $this->load->view('includes/header');
	  $this->load->view('gold/production_list',$data);

	  $this->load->view('includes/footer');


	  }

	 */

	function view_transfer() {
                
            $permisssion_url = 'view_transfer';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		

		$data['transfer'] = $this->Gold_module->transfer_join('add_transfer', 'refined_job_order');
//$data['transfer']  = $this->Gold_module->select_all('add_transfer');
		$this->load->view('includes/header');
		$this->load->view('gold/list_transfer', $data);
		$this->load->view('includes/footer');
	}

	function add_store() {

		$format_array = ci_date_format();
		$single_status['site_dateformat'] = $format_array['siteSetting_dateformat'];
		$single_status['site_currency'] = $format_array['siteSetting_currency'];
		$single_status['dateformat'] = $format_array['dateformat'];
		$single_status['rjo'] = $this->Gold_module->select_all('refined_job_order');
		$single_status['warehouse'] = $this->Gold_module->select_all('stores');
		$single_status['grades'] = $this->Gold_module->select_all('gold_grade');
		$single_status['goldsmith'] = $this->Gold_module->select_all('gold_smith');
		$single_status['outlets'] = $this->Gold_module->select_all('outlets');
		$single_status['products'] = $this->Gold_module->select_all('gold_products');
		$single_status['user_role'] = $this->session->userdata('user_role');
		$this->load->view('includes/header');
		$this->load->view('gold/production', $single_status);
		$this->load->view('includes/footer');
	}

	function store_transfer_record_save() {



		$data_array = array(
			'str_date_created' => $this->input->post('gpro_name'),
			'trans_num' => $this->input->post('transfer_code'),
			'trans_from_w' => $this->input->post('from'),
			'trans_to_w' => $this->input->post('to'),
			'trans_goldsmith_id' => $this->input->post('out'),
			'trans_items' => $this->input->post('item'),
			'total_weight_trans_gold' => $this->input->post('total_w_transfer'),
			'total_item_trans' => $this->input->post('transfered'),
			'total_items_cost' => $this->input->post('total_items_cost'),
			'str_user_id' => $this->input->post('username'),
			'str_date' => date('Y-m-d')
		);

		$data = $this->Gold_module->insert_data('store_transfer_record', $data_array);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function list_store_transfer() {
                
                $permisssion_url = 'list_store_transfer';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		


		$single_status['transfer'] = $this->Gold_module->store_transfer_join('store_transfer_record', 'gold_smith', 'users');
		$single_status['warehouse'] = $this->Gold_module->select_all('stores');
		$this->load->view('includes/header');
		$this->load->view('gold/list_store_transfer', $single_status);
		$this->load->view('includes/footer');
	}

	function staff_save() {

		$code = strip_tags($this->input->post('code'));
		$name = strip_tags($this->input->post('name'));
		$category = strip_tags($this->input->post('mobile'));
		$purchase = strip_tags($this->input->post('nic'));
		$us_id = $this->session->userdata('user_id');
		$tm = date('Y-m-d H:i:s', time());

		if (empty($code)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add New Staff', 'Please enter Product Code!'));
			redirect(base_url() . 'Gold/add_staff');
		} elseif (!preg_match('#^[a-zA-Z0-9]+$#', $code)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add New Staff', 'Product Code only Allow Letter and Character!'));
			redirect(base_url() . 'Gold/add_staff');
		} elseif (empty($name)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add New Staff', 'Please enter Staff Name!'));
			redirect(base_url() . 'Gold/add_staff');
		} elseif (empty($category)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add New Staff', 'Please choose Mobile!'));
			redirect(base_url() . 'Gold/add_staff');
		} elseif (empty($purchase)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add New Product', 'Please enter NIC!'));
			redirect(base_url() . 'Gold/add_staff');
		} else {
			$temp_fn = $_FILES['uploadFile']['name'];
			if (!empty($temp_fn)) {
				$temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

				if (($temp_fn_ext == 'jpg') || ($temp_fn_ext == 'png') || ($temp_fn_ext == 'jpeg')) {
					if ($_FILES['uploadFile']['size'] > 102900) {
						$this->session->set_flashdata('alert_msg', array('failure', 'Add New Staff', 'Upload file size must be less than 100KB!'));
						redirect(base_url() . 'Gold/add_staff');

						die();
					}
				} else {
					$this->session->set_flashdata('alert_msg', array('failure', 'Add New Staff', 'Invalid File Format! Please upload JPG, PNG, JPEG File Format for Staff Image!'));
					redirect(base_url() . 'Gold/add_staff');

					die();
				}
			}

			$ckPcodeData = $this->Constant_model->getDataOneColumn('staff', 'staff_code', "$code");

			if (count($ckPcodeData) == 0) {
				$this->load->library('Barcode39');
				// set Barcode39 object
				$bc = new Barcode39("$code");
				// set text size
				$bc->barcode_text_size = 1;

				// display new barcode
				$bc->draw('./assets/barcode/' . $code . '.gif');

				$ins_data = array(
					'staff_code' => $code,
					'staff_name' => $name,
					'staff_mobile' => $category,
					'staff_cni' => $purchase,
					'thumbnail' => 'no_image.jpg',
					'created_user_id' => $us_id,
					'date_cre' => date('Y-m-d')
				);
				$pcode_id = $this->Constant_model->insertDataReturnLastId('staff', $ins_data);

				$mainPhoto_fn = $_FILES['uploadFile']['name'];
				if (!empty($mainPhoto_fn)) {
					$main_ext = pathinfo($mainPhoto_fn, PATHINFO_EXTENSION);
					$mainPhoto_name = $code . ".$main_ext";

					// Main Photo -- START;
					$config['upload_path'] = './assets/upload/staff/';
					$config['allowed_types'] = 'jpg|png|jpeg';
					$config['file_name'] = $mainPhoto_name;
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('uploadFile')) {
						$error = array('error' => $this->upload->display_errors());
						//print_r($error);
						//$this->load->view('upload_form', $error);
						//$this->session->set_flashdata('alert_msg', array('error','warning','Error',"$error"));
					} else {
						$width_array = array(100, 200);
						$height_array = array(100, 200);
						$dir_array = array('xsmall', 'small');

						$this->load->library('image_lib');

						for ($i = 0; $i < count($width_array); ++$i) {
							$config['image_library'] = 'gd2';
							$config['source_image'] = "./assets/upload/staff/$mainPhoto_name";
							$config['maintain_ratio'] = true;
							$config['width'] = $width_array[$i];
							$config['height'] = $height_array[$i];
							$config['quality'] = '100%';

							if (!file_exists('./assets/upload/staff/' . $dir_array[$i] . '/' . $code)) {
								mkdir('./assets/upload/staff/' . $dir_array[$i] . '/' . $code, 0777, true);
							}

							$config['new_image'] = './assets/upload/staff/' . $dir_array[$i] . '/' . $code . '/' . $mainPhoto_name;

							$this->image_lib->clear();
							$this->image_lib->initialize($config);
							$this->image_lib->resize();
						}

						$this->load->helper('file');
						$path = './assets/upload/staff/' . $mainPhoto_name;

						if (unlink($path)) {
							
						}

						$upd_file_data = array(
							'thumbnail' => $mainPhoto_name,
						);
						$this->Constant_model->updateData('staff', $upd_file_data, $pcode_id);
					}
					// Main Photo -- END;
				}// End of File;

				$this->session->set_flashdata('alert_msg', array('success', 'Add Staff', "Successfully Added New Staff: $code."));
				redirect(base_url() . 'Gold/add_staff');
			} else {
				$this->session->set_flashdata('alert_msg', array('failure', 'Add New Staff', "Product Code : $code is already existing in the System! Please try another one!"));
				redirect(base_url() . 'Gold/add_staff');
			}
		}
	}

	function add_staff() {
		$this->load->view('staff/add-staff');
	}

	function list_staff() {



		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$pagination_limit = $paginationData[0]->pagination;

		$config = array();
		$config['base_url'] = base_url() . 'Gold/list_staff/';

		$config['display_pages'] = true;
		$config['first_link'] = 'First';
		$result = $this->Gold_module->select_all('staff');

		$config['total_rows'] = count($result);
		$config['per_page'] = $pagination_limit;
		$config['uri_segment'] = 3;

		$config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = '<li>';
		$config['next_tagl_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tagl_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tagl_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tagl_close'] = '</li>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['results'] = $this->Gold_module->fetch_product_data_table('staff', $config['per_page'], $page);

		$data['links'] = $this->pagination->create_links();

		if ($page == 0) {
			$have_count = count($result);
			$sh_text = 'Showing 1 to ' . count($data['results']) . ' of ' . count($result) . ' entries';
		} else {
			$start_sh = $page + 1;
			$end_sh = $page + count($data['results']);
			$sh_text = "Showing $start_sh to $end_sh of " . count($result) . ' entries';
		}

		$data['displayshowingentries'] = $sh_text;
		$data['results'] = $result;



		$this->load->view('staff/list-staff', $data);
	}

////////////////   Customer Portion   /////////////////

	public function addCustomer() {
		$this->load->view('orders/add_customer');
	}

	public function view() {
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$pagination_limit = $paginationData[0]->pagination;
		$setting_dateformat = $paginationData[0]->datetime_format;

		$config = array();
		$config['base_url'] = base_url() . 'Gold/view/';

		$config['display_pages'] = true;
		$config['first_link'] = 'First';

		$config['total_rows'] = $this->Customers_model->record_customers_count();
		$config['per_page'] = $pagination_limit;
		$config['uri_segment'] = 3;

		$config['full_tag_open'] = "<ul class='pagination pagination-right margin-none'>";
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = '<li>';
		$config['next_tagl_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tagl_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tagl_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tagl_close'] = '</li>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data['results'] = $this->Customers_model->fetch_customers_data($config['per_page'], $page);

		$data['deposits'] = ci_customer_deposit();

		$data['links'] = $this->pagination->create_links();

		if ($page == 0) {
			$have_count = $this->Customers_model->record_customers_count();

			$start_pg_point = 0;
			if ($have_count == 0) {
				$start_pg_point = 0;
			} else {
				$start_pg_point = 1;
			}

			$sh_text = "Showing $start_pg_point to " . count($data['results']) . ' of ' . $this->Customers_model->record_customers_count() . ' entries';
		} else {
			$start_sh = $page + 1;
			$end_sh = $page + count($data['results']);
			$sh_text = "Showing $start_sh to $end_sh of " . $this->Customers_model->record_customers_count() . ' entries';
		}

		$data['displayshowingentries'] = $sh_text;
		$data['setting_dateformat'] = $setting_dateformat;
		$this->load->view('orders/customers', $data);
	}

	// Edit Customer;
	public function edit_customer() {
		$cust_id = $this->input->get('cust_id');

		$data['cust_id'] = $cust_id;
		$this->load->view('orders/edit_customer', $data);
	}

	// View Customer History;
	public function customer_history() {
		$paginationData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$setting_dateformat = $paginationData[0]->datetime_format;
		$setting_currency = $paginationData[0]->currency;

		$cust_id = $this->input->get('cust_id');

		$data['cust_id'] = $cust_id;
		$data['dateformat'] = $setting_dateformat;
		$data['currency'] = $setting_currency;

		$this->load->view('orders/customer_history', $data);
	}

	// Search Customer;
	public function searchcustomer() {
		$name = $this->input->get('name');
		$email = $this->input->get('email');
		$mobile = $this->input->get('mobile');

		$data['search_name'] = $name;
		$data['search_email'] = $email;
		$data['search_mobile'] = $mobile;
		$this->load->view('orders/search_customers', $data);
	}

	// ****************************** View Page -- END ****************************** //
	// ****************************** Action To Database -- START ****************************** //
	// Delete Customer;
	public function deleteCustomer() {
		$cust_id = $this->input->post('cust_id');
		$cust_fn = $this->input->post('cust_fn');

		if ($this->Constant_model->deleteData('customers', $cust_id)) {
			$this->session->set_flashdata('alert_msg', array('success', 'Delete Customer', "Successfully Deleted Customer : $cust_fn."));
			redirect(base_url() . 'Gold/view');
		}
	}

	// Insert New Customer;
	public function insertCustomer() {
		$fullname = $this->input->post('fullname');
		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');

		$us_id = $this->session->userdata('user_id');
		$tm = date('Y-m-d H:i:s', time());

		if (empty($fullname)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add Customer', 'Please enter Customer Full Name!'));
			redirect(base_url() . 'Gold/addCustomer');
		} else {
			if (!empty($email)) {
				$ckEmailData = $this->Constant_model->getDataOneColumn('customers', 'email', $email);

				if (count($ckEmailData) > 0) {
					$this->session->set_flashdata('alert_msg', array('failure', 'Add Customer', "Email Address : $email is already existing in the system! Please try another email address!"));
					redirect(base_url() . 'Gold/addCustomer');
					die();
				}
			}

			$ins_cust_data = array(
				'fullname' => $fullname,
				'email' => $email,
				'mobile' => $mobile,
				'created_user_id' => $us_id,
				'created_datetime' => $tm,
			);
			if ($this->Constant_model->insertData('customers', $ins_cust_data)) {
				$this->session->set_flashdata('alert_msg', array('success', 'Add Customer', "Successfully Added Customer : $fullname"));
				redirect(base_url() . 'Gold/addCustomer');
			}
		}
	}

	public function updateCustomer() {
		$cust_id = $this->input->post('cust_id');
		$fn = $this->input->post('fullname');
		$email = $this->input->post('email');
		$mb = $this->input->post('mobile');

		$us_id = $this->session->userdata('user_id');
		$tm = date('Y-m-d H:i:s', time());

		$upd_data = array(
			'fullname' => $fn,
			'email' => $email,
			'mobile' => $mb,
		);
		$this->Constant_model->updateData('customers', $upd_data, $cust_id);

		$this->session->set_flashdata('alert_msg', array('success', 'Update Customer', 'Successfully Updated Customer Detail!'));
		redirect(base_url() . 'Gold/edit_customer?cust_id=' . $cust_id);
	}

	// ****************************** Action To Database -- END ****************************** //
	// ****************************** Export Excel -- START ********************************** //

	public function exportCustomer() {
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

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Customer Report');

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);

		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Customer Full Name');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Customer Email');
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Customer Mobile');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Total Order(s)');
		$objPHPExcel->getActiveSheet()->setCellValue('E2', "Total Amount Spent ($site_currency)");

		$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);

		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$jj = 3;

		$custDtaResult = $this->db->query('SELECT * FROM customers ORDER BY fullname');
		$custDtaData = $custDtaResult->result();
		for ($t = 0; $t < count($custDtaData); ++$t) {
			$cust_id = $custDtaData[$t]->id;
			$cust_fn = $custDtaData[$t]->fullname;
			$cust_em = $custDtaData[$t]->email;
			$cust_mb = $custDtaData[$t]->mobile;

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
			$objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$total_ordered_qty");
			$objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$total_ordered_amt");

			$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);

			unset($cust_id);
			unset($cust_fn);
			unset($cust_em);
			unset($cust_mb);

			++$jj;
		}
		unset($custDtaResult);
		unset($custDtaData);

		// Redirect output to a client�s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Customer_Report.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	public function exportCustomerHistory() {
		$cust_id = $this->input->get('cust_id');

		$siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
		$site_dateformat = $siteSettingData[0]->datetime_format;
		$site_currency = $siteSettingData[0]->currency;

		$custDtaData = $this->Constant_model->getDataOneColumn('customers', 'id', "$cust_id");
		$cust_fn = $custDtaData[0]->fullname;

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
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "Sales History for : $cust_fn");

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($top_header_style);

		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Sale Id');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Type');
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Date & Time');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Product');
		$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Qty');
		$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Total Qty');
		$objPHPExcel->getActiveSheet()->setCellValue('G2', "Sub Total ($site_currency)");
		$objPHPExcel->getActiveSheet()->setCellValue('H2', "Tax ($site_currency)");
		$objPHPExcel->getActiveSheet()->setCellValue('I2', "Grand Total ($site_currency)");

		$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_header);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$jj = 3;

		$total_sub_amt = 0;
		$total_tax_amt = 0;
		$total_grand_amt = 0;

		$orderResult = $this->db->query("SELECT * FROM orders WHERE customer_id = '$cust_id' ORDER BY id DESC ");
		$orderData = $orderResult->result();
		for ($d = 0; $d < count($orderData); ++$d) {
			$order_id = $orderData[$d]->id;
			$ordered_dtm = date("$site_dateformat H:i A", strtotime($orderData[$d]->ordered_datetime));
			$subTotal = $orderData[$d]->subtotal;
			$gstTotal = $orderData[$d]->tax;
			$grandTotal = $orderData[$d]->grandtotal;
			$total_item_qty = $orderData[$d]->total_items;
			$order_type = $orderData[$d]->status;

			$total_sub_amt += $subTotal;
			$total_tax_amt += $gstTotal;
			$total_grand_amt += $grandTotal;

			$pcodeArray = array();
			$pnameArray = array();
			$qtyArray = array();
			$type_name = '';

			if ($order_type == '1') {				// Order;
				$type_name = 'Sale';

				$oItemResult = $this->db->query("SELECT * FROM order_items WHERE order_id = '$order_id' ORDER BY id ");
				$oItemRows = $oItemResult->num_rows();
				if ($oItemRows > 0) {
					$oItemData = $oItemResult->result();

					for ($t = 0; $t < count($oItemData); ++$t) {
						$oItem_pcode = $oItemData[$t]->product_code;
						$oItem_pname = $oItemData[$t]->product_name;
						$oItem_qty = $oItemData[$t]->qty;

						array_push($pcodeArray, $oItem_pcode);
						array_push($pnameArray, $oItem_pname);
						array_push($qtyArray, $oItem_qty);

						unset($oItem_pcode);
						unset($oItem_pname);
						unset($oItem_qty);
					}

					unset($oItemData);
				}
				unset($oItemResult);
				unset($oItemRows);
			} elseif ($order_type == '2') {	// Return;
				$type_name = 'Return';

				$rItemResult = $this->db->query("SELECT * FROM return_items WHERE order_id = '$order_id' ORDER BY id ");
				$rItemRows = $rItemResult->num_rows();
				if ($rItemRows > 0) {
					$rItemData = $rItemResult->result();
					for ($r = 0; $r < count($rItemData); ++$r) {
						$rItem_pcode = $rItemData[$r]->product_code;
						$rItem_qty = $rItemData[$r]->qty;

						$productData = $this->Constant_model->getDataOneColumn('products', 'code', $rItem_pcode);
						$rItem_pname = $productData[0]->name;

						array_push($pcodeArray, $rItem_pcode);
						array_push($pnameArray, $rItem_pname);
						array_push($qtyArray, $rItem_qty);

						unset($rItem_pcode);
						unset($rItem_qty);
						unset($rItem_pname);
					}
					unset($rItemData);
				}
				unset($rItemResult);
				unset($rItemRows);
			}

			$objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$order_id");
			$objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$type_name");
			$objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$ordered_dtm");

			if (count($pcodeArray) > 0) {
				$f_pcode = '';
				$f_pcode = $pnameArray[0] . ' [' . $pcodeArray[0] . ']';
				$objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$f_pcode");
			} else {
				$objPHPExcel->getActiveSheet()->setCellValue("D$jj", '');
			}

			if (count($qtyArray) > 0) {
				$f_qty = '';
				$f_qty = $qtyArray[0];
				$objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$f_qty");
			} else {
				$objPHPExcel->getActiveSheet()->setCellValue("E$jj", '');
			}

			$objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$total_item_qty");
			$objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$subTotal");
			$objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$gstTotal");
			$objPHPExcel->getActiveSheet()->setCellValue("I$jj", "$grandTotal");

			$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("I$jj")->applyFromArray($account_value_style_header);

			++$jj;

			if (count($pcodeArray) > 1) {
				for ($p = 1; $p < count($pcodeArray); ++$p) {
					$s_pcode = '';
					$s_qty = '';

					$s_pcode = $pnameArray[$p] . ' [' . $pcodeArray[$p] . ']';
					$s_qty = $qtyArray[$p];

					$objPHPExcel->getActiveSheet()->setCellValue("A$jj", '');
					$objPHPExcel->getActiveSheet()->setCellValue("B$jj", '');
					$objPHPExcel->getActiveSheet()->setCellValue("C$jj", '');
					$objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$s_pcode");
					$objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$s_qty");
					$objPHPExcel->getActiveSheet()->setCellValue("F$jj", '');
					$objPHPExcel->getActiveSheet()->setCellValue("G$jj", '');
					$objPHPExcel->getActiveSheet()->setCellValue("H$jj", '');
					$objPHPExcel->getActiveSheet()->setCellValue("I$jj", '');

					$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
					$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
					$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
					$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
					$objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);
					$objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($account_value_style_header);
					$objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($account_value_style_header);
					$objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($account_value_style_header);
					$objPHPExcel->getActiveSheet()->getStyle("I$jj")->applyFromArray($account_value_style_header);

					++$jj;
				}
			}

			unset($order_id);
			unset($ordered_dtm);
			unset($subTotal);
			unset($gstTotal);
			unset($grandTotal);
			unset($total_item_qty);
		}
		unset($orderResult);
		unset($orderData);

		$total_sub_amt = number_format($total_sub_amt, 2, '.', '');
		$total_tax_amt = number_format($total_tax_amt, 2, '.', '');
		$total_grand_amt = number_format($total_grand_amt, 2, '.', '');

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:F$jj");
		$objPHPExcel->getActiveSheet()->setCellValue("A$jj", 'Total');
		$objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$total_sub_amt ($site_currency)");
		$objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$total_tax_amt ($site_currency)");
		$objPHPExcel->getActiveSheet()->setCellValue("I$jj", "$total_grand_amt ($site_currency)");

		$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_align_style);
		$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle("I$jj")->applyFromArray($style_header);

		$objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);

		// Redirect output to a client�s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Sales_History_for_' . $cust_fn . '.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	// Search Customer;
	public function exportSearchCustomer() {
		$search_name = $this->input->get('search_name');
		$search_email = $this->input->get('search_email');
		$search_mobile = $this->input->get('search_mobile');

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

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Customer Report');

		$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);

		$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Full Name');
		$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Email');
		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Mobile');
		$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Total Order(s)');
		$objPHPExcel->getActiveSheet()->setCellValue('E2', "Total Amount Spent ($site_currency)");

		$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
		$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);

		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);

		$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

		$jj = 3;

		$sort = '';

		if (!empty($search_name)) {
			$sort .= " AND fullname LIKE '%$search_name%' ";
		}
		if (!empty($search_mobile)) {
			$sort .= " AND mobile LIKE '$search_mobile%' ";
		}
		if (!empty($search_email)) {
			$sort .= " AND email LIKE '$search_email%' ";
		}

		$custResult = $this->db->query("SELECT * FROM customers WHERE created_datetime != '0000-00-00 00:00:00' $sort ORDER BY fullname ");
		$custData = $custResult->result();
		for ($i = 0; $i < count($custData); ++$i) {
			$cust_id = $custData[$i]->id;
			$cust_fn = $custData[$i]->fullname;
			$cust_em = $custData[$i]->email;
			$cust_mb = $custData[$i]->mobile;

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
			$objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$total_ordered_qty");
			$objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$total_ordered_amt");

			$objPHPExcel->getActiveSheet()->getDefaultStyle("D$jj")->getAlignment()->setWrapText(true);

			$objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($account_value_style_header);
			$objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($account_value_style_header);

			unset($cust_id);
			unset($cust_fn);
			unset($cust_ln);
			unset($cust_em);
			unset($cust_mb);
			unset($house_numb);
			unset($street_name);
			unset($city);
			unset($state);
			unset($zip_code);

			++$jj;
		}
		unset($custResult);
		unset($custData);

		// Redirect output to a client�s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Customer_Report_Search_Result.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}

	// View Prepay;
	public function prepay() {
		$customer_id = $this->input->get('customer_id');

		$id = $this->input->get('id');

		$prepay_data = array();
		$prepay_data = $this->Constant_model->getDataOneColumn('prepay', 'id', $id);
		$data = records_with_page('customers/prepay', 'prepay', 'id', 3, 'desc');

		$data['prepay_data'] = (count($prepay_data) > 0) ? $prepay_data[0] : $prepay_data;
		$data['customer_id'] = $customer_id;
		$data['id'] = $id;

		$this->load->view('prepay', $data);
	}

	public function updateprepay() {
		$id = strip_tags($this->input->post('id'));

		$customer_id = strip_tags($this->input->post('cid'));
		$payment_method = strip_tags($this->input->post('payment_method'));
		$payment = strip_tags($this->input->post('payment'));
		$us_id = $this->session->userdata('user_id');

		if (empty($payment_method)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Update Prepayment', 'Please enter Payment Method!'));
			redirect(base_url() . 'customers/prepay?customer_id=' . $customer_id);
		} elseif (empty($payment)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Update Prepayment', 'Please enter Payment!'));
			redirect(base_url() . 'customers/prepay?customer_id=' . $customer_id);
		} else {


			$db_data = array(
				'customer_id' => $customer_id,
				'payment_method' => $payment_method,
				'payment' => $payment,
				'created_by' => $us_id,
			);
			$records = $this->db->where('id=' . $id)->from('prepay')->count_all_results();
			$tid = 0;
			if ($records > 0) {
				$otid = $this->Constant_model->getSingle('customers', 'tid', 'id=' . $customer_id, 'tid');
				$this->Constant_model->deleteData(transactions, $otid);
			}
			$payment_arr['outlet_id'] = $this->Constant_model->getSingle('users', 'outlet_id', 'id=' . $this->session->userdata('user_id'), 'outlet_id');

			$payment_arr['trans_type'] = 'dep';
			$payment_arr['amount'] = $payment;
			$payment_arr['account_number'] = '0' . $payment_method;
			$tid = $this->Constant_model->insertDataReturnLastId('transactions', $payment_arr);

			if ($this->Constant_model->add_update('prepay', 'id=' . $id, $db_data)) {

				$this->db->query("UPDATE customers set deposit=deposit+$payment,tid=$tid WHERE id=$customer_id");
				$this->session->set_flashdata('alert_msg', array('success', 'Update Prepayment', 'Successfully updated Prepayment Record.'));
				redirect(base_url() . 'customers/prepay?customer_id=' . $customer_id);
			}
		}
	}

	public function del_prepay() {
		$id = $this->input->get('id');
		$customer_id = $this->input->get('customer_id');


		if ($this->Constant_model->deleteData('prepay', $id)) {
			$this->session->set_flashdata('alert_msg', array('success', 'Delete Prepayment Record', "Successfully Deleted Prepayment Record."));
			redirect(base_url() . 'Gold/prepay?customer_id=' . $customer_id);
		}
	}

////////////////////////////////////////////////////////////    End of Customer ////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////    Show Sale Form  ////////////////////////////////////////////////////////////////////

	function viewsale() {
		$data['customer'] = $this->Gold_module->select_all('customers');
		$data['staff'] = $this->Gold_module->select_all('staff');
		$data['outlets'] = $this->Gold_module->select_all('outlets');
		$data['orders'] = $this->Gold_module->select_all('orders_gold');
		$data['warehouse'] = $this->Gold_module->select_all('stores');
		$data['products'] = $this->Gold_module->select_all('refined_job_order');
		$this->load->view('orders/original_sale.php', $data);

/// previous Page is orders/sale.php
	}

	
	 public function addCustomerorder_estimate()
    {
		$user_id		= $this->session->userdata('user_id');
		$today			= date('Y-m-d H:i:s', time());
		
        $fullname	= $this->input->post('fullname');
        $email		= $this->input->post('email');
        $mobile		= $this->input->post('mobile');
		$outstanding = $this->input->post('outstanding');
        $address	= $this->input->post('address');
        $nic		= $this->input->post('nic');
		$group		= $this->input->post('group');
		$outlet_id	= $this->input->post('outlet_id');
		$paid_by = 6;
		$getOutletPayment = $this->Constant_model->getOutletWisePaymentMethod($outlet_id);
		foreach ($getOutletPayment as $pay)
		{
			if($pay->name == "Debit / Credit Sales")
			{
				$paid_by = $pay->id;
			}
		}
		
        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

       
            if (!empty($email)) {
                $ckEmailData = $this->Constant_model->getDataOneColumn('customers', 'email', $email);
                if (count($ckEmailData) > 0) 
				{
                  $json['error_email']="<span style='color:red;'>Email already exits!</span>";
                }
				else
				{
			
					$ins_cust_data = array(
							  'fullname'		=> $fullname,
							  'email'			=> $email,
							  'mobile'			=> $mobile,
							  'created_user_id' => $us_id,
							  'created_datetime'=> $tm,
							  'nic'				=> $nic,
							  'outstanding'		=>$outstanding,
							  'address'			=>$address,
							  'outlet_id'		=>$outlet_id,
							  'customer_group'	=>$group,
					);
					$customer_id = $this->Constant_model->insertDataReturnLastId('customers', $ins_cust_data);

						$pay_query = $this->Constant_model->getPaymentIDName($paid_by);
						$pay_balance = $pay_query->balance;
						$now_balance = $pay_balance + $outstanding;
						$pay_data = array(
							'balance' => $now_balance,
							'updated_user_id' => $user_id,
							'updated_datetime' => $today
						);
						$this->db->update('payment_method', $pay_data, array('id' => $paid_by));


						$transaction_data = array(
							'trans_type' => 'outstanding',
							'user_id'		=> $customer_id,
							'outlet_id'		 => $outlet_id,
							'account_number' => $paid_by,
							'amount'		 => $outstanding,
							'bring_forword'	 => $pay_balance,
							'created_by'	 => $user_id,
							'created'        => $today
						);	

						$this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);

						$order_data = array(
								'outlet_id'			=> $outlet_id,
								'customer_id'		=> $customer_id,
								'customer_name'		=> $fullname,
								'customer_email'	=> $email,
								'customer_mobile'	=> $mobile,
								'ordered_datetime'	=> $today,
								'subtotal'			=> $outstanding,
								'grandtotal'		=> $outstanding,
								'payment_method'	=> $paid_by,
								'payment_method_name' => 'Debit / Credit Sales',
								'unpaid_amt'		=> $outstanding,
								'created_datetime'	=> $today,
								'customer_note'		=> 'outstanding'
						);	

						$this->Constant_model->insertDataReturnLastId('orders_payment', $order_data);
						$customer_details = $this->Constant_model->getDataOneColumn('customers', 'id', $customer_id);
						$html='<option selected="selected"  value='.$customer_details[0]->id.'>'.$customer_details[0]->fullname .'['. $customer_details[0]->mobile .']['. $customer_details[0]->nic .']'.'</option>';
						$json['customer_id']=$html;
						$json['success']="Successfully Added Customer";
				}
		}
		echo json_encode($json);
      
    }
	
	function UpdateStatus()
	{
		$statusval = $this->input->post('statusval');
		$id = $this->input->post('id');
		$this->Gold_module->UpdateStatus($statusval,$id);
		$json['suucess'] = true;
		echo json_encode($json);
	}
	
	
	function order_estimate() {
        $permisssion_url = 'order_estimate';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
		
		$getDefaultCustomer = $this->Pos_model->getDefaultCustomer();
		$data['totaltax'] = $getDefaultCustomer->tax;
		
		$us_id = $this->session->userdata('user_id');
		$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
		$data['logged_name'] = $get_logged_name->fullname;
		//customer details add
		$data['group']=$this->db->where('is_active',1)->get('customer_group')->result();
		$data['getOutlets'] = $this->Constant_model->getOutlets();
		//
		$data['getgold_grade']	= $this->Gold_module->select_all('gold_grade');
		$data['customer']		= $this->Gold_module->select_all('customers');
		$data['getgold_orders'] = $this->Gold_module->getgold_orders();
		$data['sale_per_user']	= $this->Constant_model->getDataWhere('users','role_id=3');
		$data['getSubcategory'] = $this->Gold_module->getCategorySubcategory();
		
		$data['getServiceProduct'] = $this->Gold_module->getServiceProduct();
		
		$data['staff']		= $this->Gold_module->select_all('staff');
		$data['outlets']	= $this->Gold_module->select_all('outlets');
		$data['orders']		= $this->Gold_module->select_all('orders_gold');
		$data['warehouse']	= $this->Gold_module->select_all('stores');
		$data['products']	= $this->Gold_module->select_all('refined_job_order');


        #*******************************************************************************
        #       ------- Bill Number Generate ---------------------------- start @ a3frt
        #*******************************************************************************

        $si_or_co = "CO"; #pass || SI || or || CO || SI = salesInvoice , CO = CustomOrder

        $res = $this->get_bill_num($si_or_co);

        if($res)
        {
            $data['getgold_orders'] = $res;
        }
        else
        {
            echo "<script> alert('No bill Number Found ! Please Add a Bill Number Or Contact admin'); </script>";
            $data['getgold_orders'] = "";
        }
		//$data['last_selected_values'] = $this->db->order_by("id","desc")->get_where('profit_calculations', array('created_by' => $us_id))->row();
        $data['select_last_wherehouse']	= $this->Gold_module->select_last_wherehouse($us_id);
		
		
        #*******************************************************************************
        #       ------- Bill Number Generate ---------------------------- End @ a3frt
        #*******************************************************************************


		$this->load->view('orders/order_estimate', $data);

/// previous Page is orders/sale.php
	}
	
	public function servicechangegetValue()
	{
		$product_id			= $this->input->post('product_id');
		$getServiceProduct	= $this->Gold_module->servicechangegetValue($product_id);
		$json['retail_price'] = !empty($getServiceProduct->retail_price)?$getServiceProduct->retail_price:0;
		echo json_encode($json);
	}
	
	
	
	public function customer_order_esatb_add()
	{
		$stock_item_val = $this->input->post('return');
		
		$order_item_val = $this->input->post('orderreturn');
		$payment	    = $this->input->post('payment');
		$customer_id    = $this->input->post('ser_custome_name');
		$outlet_id		= $this->input->post('outlet_id');
		$us_id			= $this->session->userdata('user_id');
		$grand_amount	= (float) str_replace(',', '',$this->input->post('grand_amount'));
		$pay_amount		= (float) str_replace(',', '',$this->input->post('total_amount'));
        $tm				= date('Y-m-d H:i:s', time());
		$us_id = $this->session->userdata('user_id');
		$paidpaymt = (float) str_replace(',', '',$this->input->post('total_amount'));
		$grandpaymt =(float) str_replace(',', '',  $this->input->post('grand_amount'));
		$unpaidamt =$grandpaymt - $paidpaymt;
		$totalqty=0;
//		print_r($_POST);
//		die;
		$oultlet_id=$this->db->get_where('outlets', array('id' =>$outlet_id))->row();
		$data = array(
			'gold_customer_id' => $customer_id,
			'gold_customer_name' => $this->input->post('customer_name'),
			'gold_customer_mobile' => $this->input->post('customer_mobile_no'),
			'gold_customer_note' => $this->input->post('note'),
			'sale_person_id' =>	$this->input->post('user_sales'),
			'gold_ordered_datetime' => date('Y-m-d H:i:s'),
			'gold_outlet_id' =>	$oultlet_id->id,
			'gold_outlet_name' =>	$oultlet_id->name,
			'gold_outlet_address' =>	$oultlet_id->address,
			'gold_gold_outlet_contact' =>	$oultlet_id->contact_number,
			'gold_outlet_receipt_footer' =>	$oultlet_id->receipt_footer,
			'gold_created_user_id'=>$us_id,
			'gold_delivery_date'=>$this->input->post('ExpectedDeliveryDate'),
			'gold_created_datetime'=>date('Y-m-d H:i:s'),
			'gold_stock_subtotal'=> (float) str_replace(',', '',$this->input->post('product_total')),
			'gold_paid_amt'=>$paidpaymt,
			'gold_unpaid_amt'=>$unpaidamt,
			'gold_stock_service_subtotal'=> (float) str_replace(',', '',$this->input->post('stock_service_total')),
			'gold_order_subtotal'=> (float) str_replace(',', '',$this->input->post('order_total')),
			'gold_order_service_subtotal'=> (float) str_replace(',', '',$this->input->post('order_service_total')),
			'gold_discount_total'=> (float) str_replace(',', '',$this->input->post('discount_grand_total')),
			'gold_discount_percentage'=> (float) str_replace(',', '',$this->input->post('discount_grand_persantge')),
			'gold_tax'=> (float) str_replace(',', '',$this->input->post('tax_grand_total')),
			'gold_tax_percentage'=> (float) str_replace(',', '',$this->input->post('tax_grand_persantge')),
			'gold_grandtotal'=> (float) str_replace(',', '',$this->input->post('grand_total')),
			'gold_point'=>$this->input->post('point'),
			'gold_balance'=> (float) str_replace(',', '',$this->input->post('balance')),
		);

		$last_id = $this->Constant_model->insertDataReturnLastId('gold_orders', $data);


        #************************************************************************************
        #insert a new bill number for future use becuse current one is success @ a3frt start
        #************************************************************************************
        $co_bill_num = $this->input->post('estimate_no');

        if($last_id)
        {
            $si_or_co = "CO";
            $ck = $this->insert_new_bill($si_or_co,$co_bill_num);
        }

        #************************************************************************************
        #insert a new bill number for future use becuse current one is success @ a3frt start
        #************************************************************************************


		if(!empty($stock_item_val))
		{
			foreach($stock_item_val as $key=>$st_val)
			{

				if(!empty($_FILES['return']['name'][$key]))
				{
					foreach ($_FILES['return']['name'][$key] as $name => $value)
					{
						$sourcePath = $_FILES['return']['tmp_name'][$key]['product_image'][0];//[$name]['result_file'][0]
						if(!empty($sourcePath))
						{
							$image_name=date('ymdHis').$_FILES['return']['name'][$key]['product_image'][0];
							$targetPath = "product_image/".$image_name;
							move_uploaded_file($sourcePath,$targetPath); 
						}
						else
						{
							$image_name='';
						}
					}
				}
				else
				{
					$image_name='';
				}

				$product_val=$this->db->get_where('products', array('code' => $st_val['product_code_val']))->row();
				$product_service_id	 =	$st_val['product_service_id'];
				$order_items_gold = array(
						'order_id'			=>$last_id,
						'warehouse_id'		=>$st_val['warehouse_tank'],
						'weight'			=>$st_val['product_weight'],
						'customer_id'		=>$customer_id,
						'price'				=>$st_val['product_price'],
						'qty'				=>$st_val['qty'],
						'discount'			=>$st_val['discount'],
						'tax'				=>$st_val['tax'],
						'gold_grade_id'		=>$st_val['gold_grade_id'],
						'product_image'		=>$image_name,
						'discount_amount'	=>$st_val['discount_amount'],
						'tax_amount'		=>$st_val['tax_amount'],
						'balance_stock'		=>$st_val['balance_stock'],
						'product_code'		=>$st_val['product_code_val'],
						'product_name'		=>$product_val->name,
						'cost'				=>$product_val->retail_price,
						'product_category'	=>$product_val->category,	
						'subtotal'			=>$st_val['total_val'],
						'grandtotal'		=>$st_val['total_val'],
				);
				
				$totalqty=$totalqty+$st_val['qty'];
				$order_last_id = $this->Constant_model->insertDataReturnLastId('order_items_gold', $order_items_gold);
				$this->Gold_module->ProductUpdateStatus($st_val['product_code_val']);
				
				//----invertory store qty descr
				$product_code		= $st_val['product_code_val'];
				$warehouse_id		= $st_val['warehouse_tank'];
				$outlet_id			= $oultlet_id->id;
				$inventory_get		= $this->Gold_module->getInventoryqty($outlet_id,$warehouse_id,$product_code);
				$inventory_id		= $inventory_get->id;
				$inventory_qty		= $inventory_get->qty;
				$inventory_ow_idstores	= $inventory_get->ow_id;
				$stores_sid			= $inventory_get->s_id;
				$stores_s_stock		= $inventory_get->s_stock;
				$stores_s_stock_upated	= $inventory_get->s_stock_upated;
				
				$up_inventory = array('qty'	=> $inventory_qty - $st_val['qty']);
				$this->db->update('inventory', $up_inventory, array('id' => $inventory_id));
				
				$up_stores = array('s_stock'		=> $stores_s_stock			- $st_val['qty'],
								   's_stock_upated'	=> $stores_s_stock_upated	- $st_val['qty']
							 );
				$this->db->update('stores', $up_stores, array('s_id' => $stores_sid));

				//----end invertory store qty descr
				//-----------product_report
				
				$product_report_get			= $this->Gold_module->get_product_report_qty($product_code);
				$product_rep_balance_qty	= $product_report_get->balance_qty;
				$product_rep_opening_qty	= $product_rep_balance_qty - $st_val['qty'];
				
				$product_report_data = array(
							'product_code'	=>	$product_code ,
							'opening_qty'	=>	$product_rep_balance_qty ,
							'sales_qty'		=> $st_val['qty'],
							'balance_qty'	=> $product_rep_opening_qty,
							'created_by'	=>	$us_id,
							'created_date'	=>	date('Y-m-d H:i:s'),
							);
				$this->db->insert('product_report', $product_report_data);
				
				//-----------end_product_report
			
				
				if(!empty($st_val['sales_return'])){
					$sales_return = $st_val['sales_return'];
					foreach($sales_return as $sal_view)
					{			

							$gold_oreder_service = array(
							'order_items_gold_id'	=>$order_last_id ,
							'services_name'			=> $sal_view['services_id'],
							'price'					=> $sal_view['services_price'],
							'pre_print_invoice'		=>!empty($sal_view['pre_print_invoice'])?$sal_view['pre_print_invoice']:'0',
							);
							$this->Constant_model->insertDataReturnLastId('gold_order_services', $gold_oreder_service);
					}
				}

			}

		}
		
		if(!empty($order_item_val))
		{
			foreach($order_item_val as $key=>$order_val)
			{
				
				if(!empty($_FILES['orderreturn']['name'][$key]))
				{
					foreach ($_FILES['orderreturn']['name'][$key] as $name => $value)
					{
						$sourcePath = $_FILES['orderreturn']['tmp_name'][$key]['product_image'][0];
						if(!empty($sourcePath))
						{
							$image_name=date('ymdHis').$_FILES['orderreturn']['name'][$key]['product_image'][0];
							$targetPath = "product_image/".$image_name;
							move_uploaded_file($sourcePath,$targetPath); 
						}
						else
						{
							$image_name='';
						}
					}
				}
				else
				{
					$image_name='';
				}
				
				$order_items_gold = array(
						'order_id'			=>$last_id,
						'product_name'		=>$order_val['product_name'],
						'product_details'	=>$order_val['order_product_details'],
						'price'				=>$order_val['order_price'],
						'qty'				=>$order_val['order_qty'],
						'discount'			=>$order_val['order_discount'],
						'product_image'		=>$image_name,
						'tax'				=>$order_val['order_tax'],
						'gold_grade_id'		=>$order_val['gold_grade_order_id'],
						'discount_amount'	=>$order_val['order_discount_amt'],
						'tax_amount'		=>$order_val['order_tax_amt'],
						'weight'			=>$order_val['order_weight'],
						'subtotal'			=>$order_val['total_val_order'],
						'grandtotal'		=>$order_val['total_val_order'],
				);
				
				$totalqty=$totalqty+$order_val['order_qty'];

				$order_item_last_id = $this->Constant_model->insertDataReturnLastId('order_items_gold', $order_items_gold);

				if(!empty($order_val['order_sales_return'])){
					$order_sales_return = $order_val['order_sales_return'];
					foreach($order_sales_return as $ordersal_view)
					{			

							$gold_oreder_service = array(
							'order_items_gold_id'	=>$order_item_last_id ,
							'services_name'			=> $ordersal_view['services_id'],
							'price'					=> $ordersal_view['services_price'],
							'pre_print_invoice'		=>!empty($ordersal_view['pre_print_invoice'])?$ordersal_view['pre_print_invoice']:'0',
							);
							$this->Constant_model->insertDataReturnLastId('gold_order_services', $gold_oreder_service);
					}
				}

			}
		}
		
		$up_paid_amt=0;
		$up_unpaid_amt=0;

        if(!empty($payment )) {

		foreach ($payment as $value)
		{
			$paid_amt       = $value['paid'];
			$payment_method = $value['paid_by'];
			
			$pay_query = $this->db->get_where('payment_method', array('id' => $payment_method))->row();
			$pay_mthod_name = $pay_query->name;
			$pay_balance = $pay_query->balance;
			$now_balance = $pay_balance + $paid_amt;
			$pay_data    = array(
				'balance' => $now_balance,
				'updated_user_id' => $us_id,
				'updated_datetime' => $tm
			);

			$this->db->update('payment_method', $pay_data, array('id' => $payment_method));
			
			$transaction_data = array(
				'trans_type'	=> 'dep',
				'user_id'		=> $customer_id,
				'outlet_id'		=> $outlet_id,
				'amount'		=> $paid_amt,
				'bring_forword'	=> $pay_balance,
				'account_number'=> $payment_method,
				'created_by'	=> $us_id,
				'cheque_number'	=> $value['cheque'],
				'voucher_number'=> $value['addi_voucher_numb'],
				'cheque_date'	=> !empty($value['cheque_date'])?$value['cheque_date']:'',
				'bank'			=> $value['bank'],
				'card_number'	=> $value['addi_card_numb'],
				'created'		=> $tm
			);	
			$res1 = $this->Constant_model->insertDataReturnLastId('transactions', $transaction_data);
			
		
			if($pay_mthod_name == 'Debit / Credit Sales' || $pay_mthod_name == 'Vouchers')
			{
				$up_unpaid_amt= $up_unpaid_amt + $paid_amt;
				$paid_string ='unpaid_amt';
			}
			else
			{
				$up_paid_amt = $up_paid_amt + $paid_amt;
				$paid_string ='paid_amt';
			}
            //customer percentage Edit by Soyab Badi
			$siteDtaData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
            $new_settings = $siteDtaData[0]->new_settings;
            $new_settings_array = json_decode($new_settings, true);
            $is_point = (array_key_exists('is_point', $new_settings_array)) ? $new_settings_array['is_point'] : '';
            $point_percentage = (array_key_exists('point_percentage', $new_settings_array)) ? $new_settings_array['point_percentage'] : '';
            if ($is_point == "yes") {
                $percenCustomer = $point_percentage / 100 * $paid_amt;
            } else {
                $percenCustomer = 0;
            }
            if($pay_mthod_name == 'Points'){
                $percenCustomer = -$percenCustomer;
            }
			$data = array(
				'gold_orders_id'	=> $last_id,
				'customer_id'		=> $customer_id,
				'ordered_datetime'	=> $tm,
				'outlet_id'			=> $outlet_id,
				'subtotal'			=> $paid_amt,
				'grandtotal'		=> $paid_amt,
				'payment_method'	=>$payment_method,
				'payment_method_name'=>$pay_mthod_name,
				'cheque_number'		=>$value['cheque'],
				'created_user_id'	=>$us_id,
				'card_number'		=>$value['addi_card_numb'],
				'voucher_number'	=> $value['addi_voucher_numb'],
				$paid_string		=>$paid_amt,
				'bank'				=>$value['bank'],
				'cheque_date'		=>!empty($value['cheque_date'])?$value['cheque_date']:'',
                'bring_forword'     =>$pay_balance,
				'customer_Point'	=>$percenCustomer,
				'customer_note'		=>$this->input->post('note'),
			);
			$this->Constant_model->insertDataReturnLastId('gold_orders_payment', $data);
		}
	}
		$unpaid_up = array(
			'gold_total_qty_item'	=> $totalqty,
			'gold_paid_amt'			=> $up_paid_amt,
			'gold_unpaid_amt'		=> $up_unpaid_amt + $unpaidamt
		);
		$this->db->update('gold_orders', $unpaid_up, array('gold_id' => $last_id));
		
		echo $last_id;
	}

	public function getOutletWiseWarehouse()
	{
		$default_store		= $this->Pos_model->getDefaultCustomer();
		$default_store_id	= $default_store->default_store_id;
		$html = '';
         $warehouse_tank_id		= $this->input->post('warehouse_tank_id');
		 $product_name_code_id		= $this->input->post('product_name_code_id');

		//$outlet_id = $this->input->post('outlet_id'); //old
        #added by a3frt date: 07-11-17 start

        $res_array_site_setting = $this->Sales_model->get_site_setting();
        $res_site_setting = $res_array_site_setting[0]->default_store_id;

        $outlet_id = explode(',', $res_site_setting); //new by a3frt for solve the setting issue

        #added by a3frt date: 07-11-17 End

		//$warehouse = $this->Constant_model->getOutletWareHouse($outlet_id); old 
        $warehouse =  $this->Sales_model->getOutletWareHouse($outlet_id); //new by a3frt
			$html.= '<option value="">Select Warehouse</option>';
			foreach ($warehouse as $ware)
			{
				$selected = '';
				$wname = $ware->s_name;
				$wid = $ware->s_id;
				if($default_store_id == $ware->s_id)
				{
					$selected = 'selected'; 
				}
				if($warehouse_tank_id == $wid)
			    $selected = 'selected';
			
			    $arr = array('Main Store ','Bulk Store ');
				$res = in_array($wname,$arr);
			    if($res != 1)
				$html.= '<option data-val="0" value='.$wid.'>'.$ware->s_name.'</option>';
			}
		
			$json['success'] = $html;
			echo json_encode($json);
	}
	
	
	
	public function getMakepayment_name()
	{
		$default_store = $this->Pos_model->getDefaultCustomer();
		$default_store_id = $default_store->default_store_id;
		
		$html = '';
		$outlet_id = $this->input->post('outlet_id');
		$payment_method = $this->Constant_model->getpayment_mehtd_name($outlet_id);
			$html.= '<option value="">Select Payment Type</option>';
			foreach ($payment_method as $paynm)
			{
				$html.= '<option  data-val="0" value='.$paynm->id.'>'.$paynm->name.'</option>';
			}
		
			$json['success'] = $html;
			echo json_encode($json);
	}
	
	
	
	
	public function getProductDetailInventory()
	{
		$json = array();
		$pcode			= $this->input->post('product_code');
		$outlet_id		= $this->input->post('outlet_id');
		$type		    = $this->input->post('type');
		$warehouse_tank = $this->input->post('warehouse_tank');
		$gradeval  = '';
		$gradeval.= '<option value="">Select G. Grade</option>';
		$getgold_grade = $this->Gold_module->select_all('gold_grade');
		$inventory		= $this->Gold_module->getDataInventoryWise($pcode,$outlet_id,$type,$warehouse_tank);
		
		if($inventory->num_rows() > 0)
		{	
			$gold_purity = 0;
			$grade_name = '';
			if(!empty($inventory->row()->grade_id))
			{
				$gradeval_id = $inventory->row()->grade_id;
				$value		= $this->Constant_model->getSingleGoldGrade($gradeval_id);
				$grade_id	=	!empty($value->grade_id)?$value->grade_id:'';
				$grade_name	=	!empty($value->grade_name)?$value->grade_name:'';
				$gold_purity =	!empty($value->gold_purity)?$value->gold_purity:0;
			}
			
			$grade_id_product = $inventory->row()->grade_id;
			$category		  = $inventory->row()->category;
			$sub_category     = $inventory->row()->sub_category_id_fk;
			
			$profile_calculation = $this->Sales_model->getProfileCalculationData($grade_id_product,$category, $sub_category);
			
			$min_profit = !empty($profile_calculation->min_profit)?$profile_calculation->min_profit:0;
			$profit		= !empty($profile_calculation->profit)?$profile_calculation->profit:0;
			
			
			
			$get_grade = $this->Constant_model->getLastGoldGradePrice();
			$CurrentPrice = !empty($get_grade->gp_price)?$get_grade->gp_price:0;
			$gp_purity	  = !empty($get_grade->gp_purity)?$get_grade->gp_purity:0;
			$cal = 0;

			if($grade_name == 24)
			{
				$cal = $CurrentPrice;
			}
			else
			{
				$cal = ($CurrentPrice / $gp_purity) * $gold_purity;
			}

			$NetGoldWeight = !empty($inventory->row()->NetGoldWeight)?$inventory->row()->NetGoldWeight:0;
			$calgoldnetWight = ($cal * ($NetGoldWeight + $inventory->row()->Wastagegold)) + $inventory->row()->TotalAllOtherCost;

			$salesPrice = $calgoldnetWight + (($calgoldnetWight * $profit) / 100);
			$MinPrice	= $calgoldnetWight + (($calgoldnetWight * $min_profit) / 100);
			
			
			$inventory_qty				= $inventory->row()->qty;
			$json['balance_stock']		= $inventory_qty;
			$json['product_price']		= $salesPrice;
			$json['ProductMinPrice']	= $MinPrice;
			$json['product_code']		= $inventory->row()->product_code;
			$json['product_weight']		= $inventory->row()->product_weight;
			$json['grade_id']			= !empty($grade_id)?$grade_id:'';
			$json['grade_name']			= !empty($grade_name)?$grade_name:'';
			
			if($inventory_qty == 0)
			{
				$json['status']=1;
			}
			
		}
		else
		{
			$json['ProductMinPrice']	= '';
			$json['balance_stock']		= 0;
			$json['product_price']		= 0;
			$json['product_code']		= '';
			$json['product_weight']		= '';
			$json['grade_id']			='';
			$json['grade_name']			=''	;
			$json['grade']				= $gradeval;
		}
		echo json_encode($json);
	}
	function getOutletWiseWarehouseProduct()
	{
		$wareid		= $this->input->post('wareid'); 
		$type		= $this->input->post('type'); 
		$outlet_id	= $this->input->post('outlet_id'); 
		$productdata = $this->Gold_module->getOutletWiseWarehouseProduct($outlet_id,$wareid,$type);
		$product = '';
		$product .= '<option value="" >Select Product Item & Code</option>';
		foreach ($productdata as $pro)
		{
			$product .= "<option value='".$pro->product_code."'>".$pro->prdocuname." [".$pro->product_code."]</option>";
		}
		$json['product'] = $product;
		echo json_encode($json);
	}
	function getOutletWiseWarehouseProductNew()
	{
		$wareid		= $this->input->post('wareid'); 
		$type		= $this->input->post('type'); 
		$outlet_id	= $this->input->post('outlet_id'); 
		$product_name_code_id	= $this->input->post('product_name_code_id'); 
		$productdata = $this->Gold_module->getOutletWiseWarehouseProductNew($outlet_id,$wareid,$type);
		$product = "";
		$product .= "<option value='' >Select Product Item & Code</option>";
		foreach ($productdata as $pro)
		{
			$selected = "";
			$product_code = $pro->product_code;
			if($product_name_code_id == $product_code)
			$selected = "selected";
			
			$product .= "<option ".$selected." value='".$product_code."'>".$pro->prdocuname." [".$pro->product_code."]</option>";
		}
		$json['product'] = $product;
		echo json_encode($json);
	}

	public function insertCustomer_ajax() {

		$fullname = $this->input->post('fullname');
		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');
		$nic = $this->input->post('nic');

		$us_id = $this->session->userdata('user_id');
		$tm = date('Y-m-d H:i:s', time());

		if (empty($fullname)) {
			$this->session->set_flashdata('alert_msg', array('failure', 'Add Customer', 'Please enter Customer Full Name!'));
			redirect(base_url() . 'Gold/addCustomer');
		} else {
			if (!empty($email)) {
				$ckEmailData = $this->Constant_model->getDataOneColumn('customers', 'email', $email);

				if (count($ckEmailData) > 0) {
					$this->session->set_flashdata('alert_msg', array('failure', 'Add Customer', "Email Address : $email is already existing in the system! Please try another email address!"));
					// redirect(base_url().'Gold/addCustomer');
					die();
				}
			}

			$ins_cust_data = array(
				'fullname' => $fullname,
				'email' => $email,
				'mobile' => $mobile,
				'nic' => $nic,
				'created_user_id' => $us_id,
				'created_datetime' => $tm,
			);
			if ($this->Constant_model->insertData('customers', $ins_cust_data)) {
				$data['error'] = true;
				$data['message'] = 'Successfully added';


				$this->output->set_content_type('application/json')->set_output(json_encode($data));
			}
		}
	}

	function getcustomer() {

		$data = $this->Gold_module->select_all_order_('customers', 'id', 'DESC');
		$datap['message'] = $this->load->view('orders/ajax/customer.php', array('customer' => $data), TRUE);
		$this->output->set_content_type('application/json')->set_output(json_encode($datap));
	}

	function store_transfer_record_uni() {
		$id = $this->input->post('data');
		$condition = array('trans_rjo' => $id);
		$data = $this->Gold_module->get_record_by_id('add_transfer', $condition);
		//$data1 = $this->Gold_module->select_all('gold_grade');
		//$data['message']  = $this->load->view();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_uni_customer() {
		$id = $this->input->post('data');
		$condition = array('id' => $id);
		$data = $this->Gold_module->get_record_by_id('customers', $condition);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_uni_customer_three() {
		$id = $this->input->post('data');
		$name = $this->input->post('name');
		$condition = array($name => $id);
		$data = $this->Gold_module->get_record_by_id('customers', $condition);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function get_value_order_item_details() {
		$id = $this->input->post('data');
		$condition = array('order_items_gold.order_id' => $id);
		$data = $this->Gold_module->transfer_join_where('order_items_gold', 'orders_gold', $condition);
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

	function viewsale1() {
		$data['customer'] = $this->Gold_module->select_all('customers');
		$data['staff'] = $this->Gold_module->select_all('staff');
		$data['products'] = $this->Gold_module->select_all('refined_job_order');
		$this->load->view('orders/sale.php', $data);

/// previous Page is orders/sale.php
	}

	public function loadCustomer() {
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();

		$site_default_cust_id = $settingData->default_customer_id;

		$getLastCustResult = $this->db->query('SELECT * FROM customers ORDER BY id DESC LIMIT 0,1');
		$getLastCustData = $getLastCustResult->result();

		$getLastCust_dtm = date('Y-m-d H:i:s', strtotime($getLastCustData[0]->created_datetime));

		unset($getLastCustResult);
		unset($getLastCustData);

		$current_date = date('Y-m-d H:i:s', time());

		$datetime1 = strtotime("$getLastCust_dtm");
		$datetime2 = strtotime("$current_date");
		$interval = abs($datetime2 - $datetime1);
		$minutes = round($interval / 60);

		if ($minutes <= 10) {
			$custData = $this->Constant_model->getDataAll('customers', 'id', 'DESC');
		} else {
			$custResult = $this->db->query("select * from customers order by case when id = '$site_default_cust_id' then 1 else 2 end ");
			$custData = $custResult->result();
		}

		$response = array('categories' => array());
		$dcid = 0;
		for ($i = 0; $i < count($custData); ++$i) {
			$cust_id = $custData[$i]->id;
			$cust_na = $custData[$i]->fullname;
			if ($i == 0) {
				$dcid = $cust_id;
			}

			//Chef listings.
			$dataRow = array(
				'cust_id' => $cust_id,
				'cust_name' => $cust_na,
			);
			array_push($response['categories'], $dataRow);
		}
		$deposits = ci_customer_deposit();
		$response['deposit'] = (array_key_exists($dcid, $deposits)) ? $deposits[$dcid] : 0;
		$response['success'] = 'true';
		echo json_encode($response);
	}

	function uni_id() {

		$id = uniqid();
		$data['uniqu'] = $id;

		$this->output->set_content_type('application/json')->set_output(json_encode($data));
	}

    # add by a3frt 04-11-17 start

    #this function return the bill num call the function with SI or CO

    function get_bill_num($SI_or_CO = null)
    {
        $bl_num = '';
        $bill_number = '';

        if($SI_or_CO == "SI")
        {
            $bl_num = 'sale_invoice_num';
        }

        else if($SI_or_CO == "CO")
        {
            $bl_num = 'custom_order_num';
        }

        $res = $this->Gold_module->get_current_billnumber();

        foreach ($res as  $v) 
        {
            if(strlen($v->$bl_num) > 2)
            {
                $bill_number = $v->$bl_num;
                break;
            }
        }

       if(empty($bill_number))
        {
            return false;
        }

        return  $bill_number;
    }

    
    function insert_new_bill($si_or_co = null,$bill_num = null)
    {
        $st = $bill_num;

        $change_detect = substr($st, 3,2);

        $ci_or_co = substr($st, 0,2); //use in 1st condition is SI or CI

        $bill_date = substr($st, 6,8); //use in date check is today == invoiceday

        $last_number = substr($st, -1); //use in increment last number example -> 5 to 6

        $cut_last_number = substr($st, 0,15); //use get the full bill_number - last number
        
        $cut_date = substr($st, 0,6); //use get the full bill_number - last number

        $dash_last_number = substr($st,-2); //use get the full bill_number - last number

        $bill_number = '';

        if($change_detect == "CD")
        {
            $today = date("Ymd");

            if($today == $bill_date)
            {
                $increment = ((int)$last_number) + 1;
                $bill_number = $cut_last_number.$increment;
            }
            else
            {
                $bill_number = $cut_date.$today.$dash_last_number;
            }
        }

        else if($change_detect == "CW")
        {
            $week_date = date("Ymd", strtotime("+6 days",strtotime($bill_date)));
            $bill_number = $cut_date.$week_date.$dash_last_number;
        }
        else if($change_detect == "CM")
        {
            $month_date = date("Ymd", strtotime("+1 month", strtotime($bill_date)));
            $bill_number = $cut_date.$month_date.$dash_last_number;
        }
        else if($change_detect == "CY")
        {
            $month_date = date("Ymd", strtotime("+1 year", strtotime($bill_date)));
            $bill_number = $cut_date.$month_date.$dash_last_number;
        }

       $rec_data =  $this->Gold_module->get_current_billnumber_all_data($si_or_co,$bill_num);
       // print_r($rec_data); exit();
       $rec_arr_data = $rec_data[0];
       
      if($si_or_co == "SI" && !empty($bill_number))
      {
        $rec_arr_data['sale_invoice_num'] = $bill_number;
        $rec_arr_data['user_id'] = $this->session->userdata('user_id');
        $rec_arr_data['created_date'] = date('Y-m-d H:i:s');

         unset($rec_arr_data['id']);

        $is_insert = $this->Gold_module->insert_new_billnumber($rec_arr_data);

      }
      else if($si_or_co == "CO" && !empty($bill_number))
      {
        $rec_arr_data['custom_order_num'] = $bill_number;
        $rec_arr_data['user_id'] = $this->session->userdata('user_id');
        $rec_arr_data['created_date'] = date('Y-m-d H:i:s');

         unset($rec_arr_data['id']);

        $is_insert = $this->Gold_module->insert_new_billnumber($rec_arr_data);
      }

      if($is_insert)
      {
        return true;
      }

      return false;

    }

    # add by a3frt 04-11-17 End


    #********************************************************
    # added by a3frt date 15-11-17 start
    #********************************************************

    /*
        function name: exchange_price
        @parm gold grade from ajax
        @return succes data on ajax
    */
    function exchange_price()
    {
        $gold_grade = $this->input->post('gold_grade');

        $res_obj = $this->Gold_module->get_exchange_price($gold_grade);

        if(!empty($res_obj ))
        {
            $r['ret_price'] = $res_obj [0]->gp_price;
        }
        else
        {
            $r['ret_price'] = 0;
        }

        echo json_encode($r);
    }

    function save_exchange_modal_request()
    {
        $p_name = $this->input->post('p_name');
        $desire_price = $this->input->post('desire_price');
        $permission_for = "sale Product above Maximum Price";

        $data = array(

            'permission_for' => $permission_for,
            'product_name_code' =>$p_name,
            'desire_price'      => $desire_price,
            'request_user'      => $this->session->userdata('user_id'),
            'create_at'         => date('Y-m-d H:i:s'),
            'actions'           => 'pending'

        );


        $res = $this->Gold_module->insert_min_sale_req($data);

        if($res)
        {
            $r['success'] = TRUE;
        }
        else
        {
            $r['success'] = FALSE;
        }

        echo json_encode($r);

    }

    function check_permission_above_price()
    {
        $p_name = $this->input->post('p_name');
        $res = $this->Gold_module->get_permission_above_price($p_name);

        if(!empty($res))
        {
            $r['success'] = $res[0]->desire_price;
        }
        else
        {
           $r['success'] = FALSE; 
        }

        echo json_encode($r);
    }

    function save_all_exchange_data()
    {
        $warehouse_id = $this->input->post('warehouse_id');
        $gold_grade_id = $this->input->post('gold_grade_id');
        $item_name = $this->input->post('item_name');
        $weight = $this->input->post('weight');
        $max_exchange_price = $this->input->post('max_exchange_price');
        $exchange_price = $this->input->post('exchange_price');
       
       $data = array(

        'warehouse_id' =>  $warehouse_id,
        'gold_grade_id' => $gold_grade_id,
        'item_name' => $item_name,
        'weight' => $weight,
        'max_exchange_price' => $max_exchange_price,
        'selling_price' => $exchange_price,
        'created_at' =>date('Y-m-d H:i:s'),
        'created_user' => $this->session->userdata('user_id')

       );

        $res = $this->Gold_module->insert_all_exchange_data($data);

        if(!empty($res))
        {
            $r['success'] = TRUE;
        }
        else
        {
           $r['success'] = FALSE; 
        }

        echo json_encode($r);
    }

    #********************************************************
    # added by a3frt date 15-11-17 end
    #********************************************************


}
?>
