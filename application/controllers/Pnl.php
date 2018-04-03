<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pnl extends CI_Controller
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
        $this->load->model('Pnl_model');
        $this->load->model('Constant_model');
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

    /*
	 *  ****************************** View Page -- START ******************************
	 */
    public function view()
    {
		 $permisssion_url = 'pnl';
         
		$permission = $this->Constant_model->getPermissionPageWise($permisssion_url);
                $permission_re_id=$permission->resource_id;
                $permisssion_sub_url = 'view';
                $permissionsub = $this->Constant_model->getPermissionSubPageWise($permission_re_id,$permisssion_sub_url);
               
		if($permissionsub->view_menu_right == 0)
		{
			redirect('dashboard');
		}
        $paginationData		= $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit		= $paginationData[0]->pagination;
        $siteSetting_dateformat = $paginationData[0]->datetime_format;
        $siteSetting_currency	= $paginationData[0]->currency;

        $data['site_currency']	= $siteSetting_currency;
        $data['dateformat']		= $siteSetting_dateformat;

		$this->load->view('includes/header');
		$this->load->view('pnl', $data);
		$this->load->view('includes/footer');
    }
}