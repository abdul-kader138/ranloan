<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Gift_card extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Giftcard_model');
        $this->load->model('Constant_model');
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

    // ****************************** View Page -- START ****************************** //

    // View Gift Card;
    public function list_gift_card()
    {
		
		$permisssion_url = 'list_gift_card';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency = $siteSettingData[0]->currency;

        $data['dateformat'] = $siteSetting_dateformat;
        $data['currency'] = $siteSetting_currency;

        $this->load->view('gift_card', $data);
    }

    // Create Gift Card;
    public function add_gift_card()
    {
		
		
		$permisssion_url = 'add_gift_card';
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                
		if($permission->view_menu_right == 0)
		{
			redirect('dashboard');
		}	
		
        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency = $siteSettingData[0]->currency;

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

        $data['site_currency'] = $siteSetting_currency;
        $data['dateformat'] = $dateformat;

        $this->load->view('add_gift_card', $data);
    }

    // ****************************** View Page -- END ****************************** //

    // ****************************** Action To Database -- START ****************************** //

    // Delete Gift Card;
    public function deletegiftcard()
    {
        $id = $this->input->get('id');

        $giftData = $this->Constant_model->getDataOneColumn('gift_card', 'id', $id);
        if (count($giftData) == 1) {
            $gift_numb = $giftData[0]->card_number;

            if ($this->Constant_model->deleteData('gift_card', $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Delete Gift Card', "Successfully Deleted Gift Card Number : $gift_numb"));
                redirect(base_url().'gift_card/list_gift_card');
            }
        } else {
            $this->session->set_flashdata('alert_msg', array('failure', 'Delete Gift Card', 'Error on deleting Gift Card!'));
            redirect(base_url().'gift_card/list_gift_card');
        }
    }

    // Add Generate;
    public function insertGiftCard()
    {
        $card_numb = $this->input->post('gift_card_numb');
        $value = $this->input->post('value');
        $expiry_date = $this->input->post('expiry_date');

        $us_id = $this->session->userdata('user_id');
        $tm = date('Y-m-d H:i:s', time());

        $siteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $site_dateformat = $siteSettingData[0]->datetime_format;

        if (empty($card_numb)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Gift Card', 'Please enter Gift Card!'));
            redirect(base_url().'gift_card/add_gift_card');
        } elseif (empty($value)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Gift Card', 'Please enter Gift Card Value!'));
            redirect(base_url().'gift_card/add_gift_card');
        } elseif (empty($expiry_date)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Gift Card', 'Please enter Gift Card Expiry!'));
            redirect(base_url().'gift_card/add_gift_card');
        } else {
            $url_start = '';

            if ($site_dateformat == 'd/m/Y') {
                $startArray = explode('/', $expiry_date);

                $start_day = $startArray[0];
                $start_mon = $startArray[1];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;
            }
            if ($site_dateformat == 'd.m.Y') {
                $startArray = explode('.', $expiry_date);

                $start_day = $startArray[0];
                $start_mon = $startArray[1];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;
            }
            if ($site_dateformat == 'd-m-Y') {
                $startArray = explode('-', $expiry_date);

                $start_day = $startArray[0];
                $start_mon = $startArray[1];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;
            }

            if ($site_dateformat == 'm/d/Y') {
                $startArray = explode('/', $expiry_date);

                $start_day = $startArray[1];
                $start_mon = $startArray[0];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;
            }
            if ($site_dateformat == 'm.d.Y') {
                $startArray = explode('.', $expiry_date);

                $start_day = $startArray[1];
                $start_mon = $startArray[0];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;
            }
            if ($site_dateformat == 'm-d-Y') {
                $startArray = explode('-', $expiry_date);

                $start_day = $startArray[1];
                $start_mon = $startArray[0];
                $start_yea = $startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;
            }

            if ($site_dateformat == 'Y.m.d') {
                $startArray = explode('.', $expiry_date);

                $start_day = $startArray[2];
                $start_mon = $startArray[1];
                $start_yea = $startArray[0];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;
            }
            if ($site_dateformat == 'Y/m/d') {
                $startArray = explode('/', $expiry_date);

                $start_day = $startArray[2];
                $start_mon = $startArray[1];
                $start_yea = $startArray[0];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;
            }
            if ($site_dateformat == 'Y-m-d') {
                $startArray = explode('-', $expiry_date);

                $start_day = $startArray[2];
                $start_mon = $startArray[1];
                $start_yea = $startArray[0];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;
            }

            $ckGiftResult = $this->db->query("SELECT * FROM gift_card WHERE card_number = '$card_numb' ");
            $ckGiftRows = $ckGiftResult->num_rows();
            if ($ckGiftRows == 0) {
                $ins_data = array(
                         'card_number' => $card_numb,
                         'value' => $value,
                         'expiry_date' => $url_start,
                         'created_user_id' => $us_id,
                         'created_datetime' => $tm,
                         'status' => '0',
                 );
                if ($this->Constant_model->insertData('gift_card', $ins_data)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Add Gift Card', "Successfully Added Gift Card Number : $card_numb"));
                    redirect(base_url().'gift_card/list_gift_card');
                }
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add Gift Card', "Gift Card Number $card_numb is already existing! Please try another Card Number!"));
                redirect(base_url().'gift_card/add_gift_card');
            }
        }
    }

    // ****************************** Action To Database -- END ****************************** //

    // ****************************** Export Excel -- START ****************************** //

    // ****************************** Export Excel -- END ****************************** //
}
