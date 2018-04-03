<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
        $this->load->model('Dashboard_model');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');

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
        $dashSiteSettingData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $dash_currency = $dashSiteSettingData[0]->currency;

        $data['currency'] = $dash_currency;

        #***********************************************************************
        #      added by a3frt date: 15-11-17 start
        #***********************************************************************

        $data['all_accept_user_id'] = $this->all_user_who_have_permission_to_accept();

        $data['ck_pending'] = $this->check_any_pending_below_up_sale();

        $data['user_id'] = $this->session->userdata('user_id');

        #***********************************************************************
        #      added by a3frt date: 15-11-17 end
        #***********************************************************************


        $this->load->view('dashboard', $data);
    }


    #***********************************************************************
    #      added by a3frt date: 15-11-17 start
    #***********************************************************************

    function make_action()
    {
    
       $data['res'] = $this->Constant_model->get_action_data();

       $this->load->view('includes/header');
       $this->load->view('make_action', $data);
       $this->load->view('includes/footer');


    }

    function accept_by_admin($id = null)
    {
        $data = array(
            'accept_user' => $this->session->userdata('user_id'),
            'action_at' => date('Y-m-d H:i:s'),
            'actions' => 'accept'
        );

        $this->Constant_model->update_accepted($id,$data);

        redirect('dashboard/make_action');
    }

    function reject_by_admin($id = null)
    {
        $data = array(
            'accept_user' => $this->session->userdata('user_id'),
            'action_at' => date('Y-m-d H:i:s'),
            'actions' => 'reject'
        );

        $this->Constant_model->update_accepted($id,$data);

        redirect('dashboard/make_action');
    }

    function all_user_who_have_permission_to_accept()
    {
        $res = $this->Constant_model->get_accept_user_list();

        return $res;
    }

    function check_any_pending_below_up_sale()
    {
        $res = $this->Constant_model->check_pending_sale_below_above_price();

        if($res > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }

        }

    #***********************************************************************
    #      added by a3frt date: 15-11-17 end
    #***********************************************************************
}
