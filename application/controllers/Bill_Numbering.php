<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Bill_Numbering extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Customers_model');
        $this->load->model('Constant_model');
        $this->load->model('Bill_Numbering_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        $settingResult = $this->db->get_where('site_setting');
        $settingData   = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
        if ($this->session->userdata('user_id') == "") {
            redirect(base_url());
        }
    }

    public function bill_numbering()
    {

        $permisssion_url = 'bill_numbering';
        $permission      = $this->Constant_model->getPermissionPageWise($permisssion_url);

        if ($permission->view_menu_right == 0) {
            redirect('dashboard');
        }
        $data['getBrand']         = $this->Bill_Numbering_model->getBrand();
        $data['getSupplier']      = $this->Bill_Numbering_model->getSupplier();
        $data['getCategory']      = $this->Bill_Numbering_model->getCategory();
        $data['getSubCategory']   = $this->Bill_Numbering_model->getSubCategory();
        $data['bilNUmbering_res'] = $this->Bill_Numbering_model->get_BillNumbering(); //a3frt
        $this->load->view('bill_numbering', $data);
    }

    public function AddBillNumbering()
    {
        $loginUserId           = $this->session->userdata('user_id');
        $loginData             = $this->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
        $data['UserLoginName'] = $loginData[0]->fullname;
        $this->load->view('add_bill_numbering', $data);
    }

    public function SubmitBillNumbering()
    {

    if ($this->input->post('dailyplay') == 1) 
        {
            if($this->input->post('invoicepause') == 1 && $this->input->post('pospause') ==1 )
            {
              $sale_invoice_num = "SI-CD-".date("Ymd")."-".$this->input->post('enter_starting_number');
              $custom_order_num = "CO-CD-".date("Ymd")."-".$this->input->post('enter_starting_number');
            }
            else if($this->input->post('invoicepause') == 1 && $this->input->post('pospause') == 0 )
            {
              $sale_invoice_num = "SI-CD-".date("Ymd")."-".$this->input->post('enter_starting_number');
              $custom_order_num = "";
            }
           else if($this->input->post('invoicepause') == 0 && $this->input->post('pospause') == 1 )
            {
              $sale_invoice_num = "";
              $custom_order_num = "CO-CD-".date("Ymd")."-".$this->input->post('enter_starting_number');
            }
        }
     
    else if ($this->input->post('weeklyplay') == 1) 
      {
        if($this->input->post('invoicepause') == 1 && $this->input->post('pospause') ==1 )
          {
            $sale_invoice_num = "SI-CW-".date("Ymd")."-".$this->input->post('enter_starting_number');
            $custom_order_num = "CO-CW-".date("Ymd")."-".$this->input->post('enter_starting_number');
          }
        else if($this->input->post('invoicepause') == 1 && $this->input->post('pospause') == 0 )
          {
            $sale_invoice_num = "SI-CW-".date("Ymd")."-".$this->input->post('enter_starting_number');
            $custom_order_num = "";
          }
        else if($this->input->post('invoicepause') == 0 && $this->input->post('pospause') == 1 )
          {
            $sale_invoice_num = "";
            $custom_order_num = "CO-CW-".date("Ymd")."-".$this->input->post('enter_starting_number');
          }
      }
     else if ($this->input->post('monthlyplay') == 1)
      {
        if($this->input->post('invoicepause') == 1 && $this->input->post('pospause') ==1 )
          {
            $sale_invoice_num = "SI-CM-".date("Ymd")."-".$this->input->post('enter_starting_number');
            $custom_order_num = "CO-CM-".date("Ymd")."-".$this->input->post('enter_starting_number');
          }
        else if($this->input->post('invoicepause') == 1 && $this->input->post('pospause') == 0 )
          {
            $sale_invoice_num = "SI-CM-".date("Ymd")."-".$this->input->post('enter_starting_number');
            $custom_order_num = "";
          }
        else if($this->input->post('invoicepause') == 0 && $this->input->post('pospause') == 1 )
          {
            $sale_invoice_num = "";
            $custom_order_num = "CO-CM-".date("Ymd")."-".$this->input->post('enter_starting_number');
          }
      } 
    else if ($this->input->post('yearlyplay') == 1) 
      {
        if($this->input->post('invoicepause') == 1 && $this->input->post('pospause') ==1 )
          {
            $sale_invoice_num = "SI-CY-".date("Y0101")."-".$this->input->post('enter_starting_number');
            $custom_order_num = "CO-CY-".date("Y0101")."-".$this->input->post('enter_starting_number');
          }
        else if($this->input->post('invoicepause') == 1 && $this->input->post('pospause') == 0 )
          {
            $sale_invoice_num = "SI-CY-".date("Y0101")."-".$this->input->post('enter_starting_number');
            $custom_order_num = "";
          }
        else if($this->input->post('invoicepause') == 0 && $this->input->post('pospause') == 1 )
          {
            $sale_invoice_num = "";
            $custom_order_num = "CO-CY-".date("Y0101")."-".$this->input->post('enter_starting_number');
          }
      }

    $data = array(

        'user_id'               => $this->session->userdata('user_id'),
        'created_date'          => date('Y-m-d H:i:s'),
        'auto_number_change'    => $this->input->post('auto_number_change'),
        'change_daily'          => $this->input->post('dailyplay'),
        'change_weekly'         => $this->input->post('weeklyplay'),
        'change_monthly'        => $this->input->post('monthlyplay'),
        'change_yearly'         => $this->input->post('yearlyplay'),
        'sales_invoice'         => $this->input->post('invoicepause'),
        'pos_bill'              => $this->input->post('pospause'),
        'current_year'          => $this->input->post('current_year'),
        'current_month'         => $this->input->post('current_month'),
        'current_day'           => $this->input->post('current_day'),
        'enter_starting_number' => $this->input->post('enter_starting_number'),
        'sale_invoice_num'      => $sale_invoice_num,
        'custom_order_num'      => $custom_order_num,
        'status'                => '0',
    );

    $success = $this->Bill_Numbering_model->SubmitBillNumbering($data);

    $this->session->set_flashdata('SUCCESSMSG', 'Bill Numbering Added Successfully!!');
    $json['success'] = $success;
    echo json_encode($json);
}

}
