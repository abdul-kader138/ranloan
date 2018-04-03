<?php

defined('BASEPATH') or exit('No direct script access allowed');
if(! function_exists('load_db')) {

    function format_order($pre,$id,$post){
        
        
        return $pre.$id.$post;
        
    }
    function sel_element($arr,$sel,$lbl_name,$element_name,$first_opt='',$is_required='',$element_id='',$attr='',$class=''){
        $id = ($element_id !='') ? $element_id:$element_name;
        $req_star=$req_str='';
        if($is_required==1){
            $req_star=' *';
            $req_str='required';
        }
        $lbl_str1='<label>'.$lbl_name.'<span style="color: #F00">'.$req_star.'</span></label>';

        $lbl_str = ($lbl_name == '') ? '' : $lbl_str1;

        $option = ($first_opt!='') ? '<option value="">'.$first_opt.'</option>':'';
         $str =  '<div class="form-group">
                    '.$lbl_str.'
                    <select id="'.$id.'" name="'.$element_name.'" class="form-control '.$class.'" '.$req_str.' '.$attr.' >'.$option;
         foreach($arr as $key=>$val){
            $selected = (trim($key)===trim($sel))? 'selected="selected"' :'';
            $str .=  '  <option value="'.$key.'" '.$selected.' >'.$val.'</option>';
        }
        $str .=  '</select></div>';
        
        return $str;
       
    }
   

}
function login_user_name(){
    $CI =& get_instance();
    
     $loginUserId= $CI->session->userdata('user_id');
        $loginData = $CI->Constant_model->getDataOneColumn('users', 'id', $loginUserId);
     echo   $user_name =  @$loginData[0]->fullname;
 }
if(! function_exists('ci_date_format')) {

    function ci_date_format(){
        
        $CI =& get_instance();

        $CI->load->model('Constant_model');
        $siteSettingData = $CI->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency = $siteSettingData[0]->currency;
        $keyboard = $siteSettingData[0]->display_keyboard;
        $tax = $siteSettingData[0]->tax;

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
        return array(
            'dateformat'=>$dateformat,
            'siteSetting_dateformat'=>$siteSetting_dateformat,
            'siteSetting_currency'=>$siteSetting_currency,
            'siteSetting_keyboard'=>$keyboard,
            'siteSetting_tax'=>$tax,        

                );
    }
    
   
}
if(! function_exists('ci_date_display_format')) {

    function ci_date_display_format($site_dateformat,$url_start,$url_end){
        if ($site_dateformat == 'd/m/Y') {
                $startArray = explode('/', $url_start);
                $endArray = explode('/', $url_end);

                $start_day = @$startArray[0];
                $start_mon = @$startArray[1];
                $start_yea = @$startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[0];
                $end_mon = $endArray[1];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($site_dateformat == 'd.m.Y') {
                $startArray = explode('.', $url_start);
                $endArray = explode('.', $url_end);

                $start_day = @$startArray[0];
                $start_mon = @$startArray[1];
                $start_yea = @$startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[0];
                $end_mon = $endArray[1];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($site_dateformat == 'd-m-Y') {
                $startArray = explode('-', $url_start);
                $endArray = explode('-', $url_end);

                $start_day = @$startArray[0];
                $start_mon = @$startArray[1];
                $start_yea = @$startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = @$endArray[0];
                $end_mon = @$endArray[1];
                $end_yea = @$endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }

            if ($site_dateformat == 'm/d/Y') {
                $startArray = explode('/', $url_start);
                $endArray = explode('/', $url_end);

                $start_day = @$startArray[1];
                $start_mon = @$startArray[0];
                $start_yea = @$startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[1];
                $end_mon = $endArray[0];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($site_dateformat == 'm.d.Y') {
                $startArray = explode('.', $url_start);
                $endArray = explode('.', $url_end);

                $start_day = @$startArray[1];
                $start_mon = @$startArray[0];
                $start_yea = @$startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[1];
                $end_mon = $endArray[0];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($site_dateformat == 'm-d-Y') {
                $startArray = explode('-', $url_start);
                $endArray = explode('-', $url_end);

                $start_day = @$startArray[1];
                $start_mon = @$startArray[0];
                $start_yea = @$startArray[2];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[1];
                $end_mon = $endArray[0];
                $end_yea = $endArray[2];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }

            if ($site_dateformat == 'Y.m.d') {
                $startArray = explode('.', $url_start);
                $endArray = explode('.', $url_end);

                $start_day = @$startArray[2];
                $start_mon = @$startArray[1];
                $start_yea = @$startArray[0];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[2];
                $end_mon = $endArray[1];
                $end_yea = $endArray[0];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($site_dateformat == 'Y/m/d') {
                $startArray = explode('/', $url_start);
                $endArray = explode('/', $url_end);

                $start_day = @$startArray[2];
                $start_mon = @$startArray[1];
                $start_yea = @$startArray[0];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[2];
                $end_mon = $endArray[1];
                $end_yea = $endArray[0];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            if ($site_dateformat == 'Y-m-d') {
                $startArray = explode('-', $url_start);
                $endArray = explode('-', $url_end);

                $start_day = @$startArray[2];
                $start_mon = @$startArray[1];
                $start_yea = @$startArray[0];

                $url_start = $start_yea.'-'.$start_mon.'-'.$start_day;

                $end_day = $endArray[2];
                $end_mon = $endArray[1];
                $end_yea = $endArray[0];

                $url_end = $end_yea.'-'.$end_mon.'-'.$end_day;
            }
            
            return array(
                  'url_end'=>$url_end,
                'url_start'=>$url_start
            );
    }
}
if(! function_exists('ci_set_settings')) {

    function ci_set_settings(){
            $CI =& get_instance();
            $settingResult = $CI->db->get_where('site_setting');
            $settingData = $settingResult->row();
            $new_sys_settings=array();
            if($settingData->new_settings !='')
            $new_sys_settings = json_decode($settingData->new_settings,true);
        return $new_sys_settings;
    }
}
if(! function_exists('ci_customer_deposit')) {

    function ci_customer_deposit(){
        
        $CI =& get_instance();
        return  $CI->Constant_model->getddData('customers','id','deposit', 'id');

            
    }
}
if(! function_exists('ci_is_service')) {

    function ci_is_service($category){
        $CI =& get_instance();
        $categories_ = $CI->Constant_model->getddData('category','name','id', 'id');
        $categories=array();
        foreach($categories_ as $name=>$cid){
            $categories[strtolower($name)]=$cid;
        }
        $is_service = ($category==$categories[strtolower(SERVICES)]) ? 1 : 0;    
        return $is_service;
    }
    
}
if(! function_exists('upload_image')) {

    function upload_image($field_name,$name,$dir,$table,$key,$col_name,$is_update=0){
        $name = str_replace('-', '', $name);
        $mainPhoto_fn = $_FILES[$field_name]['name'];
        if (!empty($mainPhoto_fn)) {
            $main_ext = pathinfo($mainPhoto_fn, PATHINFO_EXTENSION);
            $mainPhoto_name = $name.".$main_ext";
            //print_r($_FILES);
            // Main Photo -- START;
            $config['upload_path'] = 'assets/upload/'.$dir.'/';
            $config['allowed_types'] = '*';
            $config['file_name'] = $mainPhoto_name;
            $CI =& get_instance();

            $CI->load->library('upload', $config);

            if (!$CI->upload->do_upload($field_name)) {
                $error = array('error' => $CI->upload->display_errors());
              //  print_r($error);exit;
            } else {
                $width_array = array(100, 200);
                $height_array = array(100, 200);
                $dir_array = array('xsmall', 'small');

                $CI->load->library('image_lib');

                for ($i = 0; $i < count($width_array); ++$i) {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = "assets/upload/".$dir."/$mainPhoto_name";
                    $config['maintain_ratio'] = true;
                    $config['width'] = $width_array[$i];
                    $config['height'] = $height_array[$i];
                    $config['quality'] = '100%';

                    if (!file_exists('assets/upload/'.$dir.'/'.$dir_array[$i].'/'.$key)) {
                         @mkdir('assets/upload/'.$dir.'/'.$dir_array[$i].'/'.$name, 0777, true);
                    }

                    $config['new_image'] = 'assets/upload/'.$dir.'/'.$dir_array[$i].'/'.$name.'/'.$mainPhoto_name;

                    $CI->image_lib->clear();
                    $CI->image_lib->initialize($config);
                    $CI->image_lib->resize();
                }

                $CI->load->helper('file');
                $path = 'assets/upload/'.$dir.'/'.$mainPhoto_name;
                @unlink($path);

                $upd_file_data = array(
                        $col_name => $mainPhoto_name,
                );
                //if($is_update==0){
                    $CI->Constant_model->updateData($table, $upd_file_data, $key);
               // }
            }
            // Main Photo -- END;
        }// End of File;
    }
 }
 
 
if(! function_exists('bank_from_data')) {

    function bank_from_data(){
        $CI =& get_instance();

        $payment_methods = $CI->Constant_model->getddData('payment_method','id','name', 'name');
        $bdt0 = $CI->Constant_model->getddData('bank_accounts','id','account_number', 'id');
        //$bdt['-'] = 'All Bank Accounts';
        foreach($payment_methods as $key=>$val){
            $bdt['0'.$key]=$val;
        }
        foreach($bdt0 as $key=>$val){
            $bdt['-'.$key]=$val.' (Account number)';
        }
        return $bdt;

    }
}
if(! function_exists('display_bank_from')) {

    function display_bank_from($id){
        $CI =& get_instance();

        $payment_methods = $CI->Constant_model->getddData('payment_method','id','name', 'name');
        $bdt0 = $CI->Constant_model->getddData('bank_accounts','id','account_number', 'id');
        $id1 = substr($id,1);
        return  ($id{0}=='0') ? @$payment_methods[$id1] :@$bdt0[$id1].' <br /><span style="font-size:9px">(Account number)</span>';
        

    }
}
if(! function_exists('bank_to_data')) {

    function bank_to_data(){
        $CI =& get_instance();

        $payment_methods = $CI->Constant_model->getddData('payment_method','id','name', 'name');
        $bdt0 = $CI->Constant_model->getddData('bank_accounts','id','account_number', 'id');
        //$bdt['-'] = 'All Bank Accounts';
        foreach($payment_methods as $key=>$val){
            if(strtolower($val)=='cash') {$bdt['0'.$key]=$val;break;}
        }
        foreach($bdt0 as $key=>$val){
            $bdt['-'.$key]=$val.' (Account number)';
        }
        return $bdt;

    }
}
if(! function_exists('display_bank_to')) {

    function display_bank_to($id){
        $CI =& get_instance();

        $payment_methods = $CI->Constant_model->getddData('payment_method','id','name', 'name');
        $bdt0 = $CI->Constant_model->getddData('bank_accounts','id','account_number', 'id');
        $id1 = substr($id,1);
        return  ($id{0}=="0") ? @$payment_methods[$id1] :@$bdt0[$id1].' <br /><span style="font-size:9px">(Account number)</span>';
        

    }
}
if(! function_exists('ci_show_modal')) {

function ci_show_modal($id,$desc){
    return '<div id="'.$id.'" class="modal fade"> 
		<div class="modal-dialog">
			<div class="modal-content">
				<!--
				<div class="modal-header" style="background-color: #373942;">
					<h3 class="modal-title" style="color: #FFF;">Add New Customer</h3>
				</div>
				-->
				<div class="modal-body" style="overflow: visible; background-color: #FFF; border-radius: 12px;">
					
					<div class="row">
						<div class="col-md-12" style="text-align: center; font-size: 25px; padding-top: 20px; padding-bottom: 20px; color: #090;" id="desc'.$id.'">
 						'.$desc.'</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>';
    }
}
if(! function_exists('ci_show_info_modal')) {

function ci_show_info_modal($id,$title,$desc){
    return '<div id="'.$id.'" class="modal fade"> 
		<div class="modal-dialog">
			<div class="modal-content">
				<!--
				<div class="modal-header" style="background-color: #373942;">
					<h3 class="modal-title" style="color: #FFF;">Add New Customer</h3>
				</div>
				-->
				<div class="modal-body" style="overflow: visible; background-color: #FFF; border-radius: 12px;">
					
					<div class="row">
						<div class="col-md-12" style="text-align: center; font-size: 25px; padding-top: 20px; padding-bottom: 20px; color: #090;" id="desc'.$id.'">
 						'.$desc.'</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>';
    }
}
if(! function_exists('ci_format_number')) {

    function ci_format_number($amount){
        return @number_format($amount,2);
    }
}
if(! function_exists('records_with_page')) {

    function records_with_page($controller,$table,$key,$segment,$order,$sql=''){
        $CI =& get_instance();

        $paginationData = $CI->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit = $paginationData[0]->pagination;
        $setting_dateformat = $paginationData[0]->datetime_format;

        $config = array();
        $config['base_url'] = base_url().$controller.'/';

        $config['display_pages'] = true;
        $config['first_link'] = 'First';
        if($sql!=''){
            $page_count = $CI->db->query($sql)->num_rows();
        } else {
            $page_count = $CI->Constant_model->record_count($table,$key);
        }
        $config['total_rows'] = $page_count;
        //$pagination_limit=1;
        $config['per_page'] = $pagination_limit;
        $config['uri_segment'] = $segment;

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

        $CI->pagination->initialize($config);

        $page = ($CI->uri->segment($segment)) ? $CI->uri->segment($segment) : 0;

        if($sql != ''){
            $data['results']  = $CI->db->query($sql." LIMIT $page,".$config['per_page'])->result();

        } else {
             $data['results'] = $CI->Constant_model->fetch_data($table,$key,$order,$config['per_page'], $page);
        }

        $data['links'] = $CI->pagination->create_links();
        $have_count = $page_count;

        if ($page == 0) {

            $start_pg_point = 0;
            if ($have_count == 0) {
                $start_pg_point = 0;
            } else {
                $start_pg_point = 1;
            }

        $sh_text = "Showing $start_pg_point to ".count($data['results']).' of '.$have_count.' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$have_count.' entries';
        }
        $data['setting_dateformat'] = $setting_dateformat;

        $data['displayshowingentries'] = $sh_text;
        return $data;
    }

}
if(! function_exists('ci_show_settings')) {

    function ci_show_settings(){
        $CI =& get_instance();
        $settingResult = $CI->db->get_where('site_setting');
        $settingData = $settingResult->row();
        $new_sys_settings=array();
        if($settingData->new_settings !='')
            $new_sys_settings = json_decode($settingData->new_settings,true);

        return array('setting_data'=>$settingData,'new_data'=>$new_sys_settings);
    }

}
if(! function_exists('ci_validate_restriction')) {


function ci_validate_restriction($restriction,$table){
//        error_reporting(E_ERROR);
        $CI =& get_instance();
//
        $flag=true;
//        $fname = "assets/".$file;//restrictionoutlet.txt";
//        $f = fopen($fname, 'r');
// //       $fpath=dirname(__FILE__).DIRECTORY_SEPARATOR;
//        $restriction = fread($f,  filesize($fname));
//        fclose($f);
        
        $records=  $CI->db->from($table)->count_all_results();
         if($records>=$restriction){  
            $flag=false;
 
        }
         return $flag;
    }
}
if(! function_exists('ci_pump_validate_restriction')) {


function ci_pump_validate_restriction($file,$outlet,$table){
        error_reporting(E_ERROR);
        $CI =& get_instance();

        $flag=true;
        $restriction_arr = ci_pump_count_restriction($file);
        $restriction = $restriction_arr[$outlet];
        $records=  $CI->db->from($table)->count_all_results();
        if($records >=  $restriction){  
            $flag=false;
        }
         return $flag;
    }
}

if(! function_exists('ci_count_restriction')) {


    function ci_count_restriction($file){
        error_reporting(E_ERROR);
        $CI =& get_instance();

        $flag=true;
        $fname = "assets/".$file; 
        $f = fopen($fname, 'r'); 
        $restriction = fread($f,  filesize($fname));
        fclose($f);

       
         return $restriction;
    }
}
if(! function_exists('ci_pump_count_restriction')) {


    function ci_pump_count_restriction($file){
        error_reporting(E_ERROR);
        $CI =& get_instance();
        $restriction=0;
        $flag=true;
        $fname = "assets/".$file; 
        $f = fopen($fname, 'r'); 
        $restriction_str = fread($f,  filesize($fname));
        $res_arr1 = explode("\n",$restriction_str);
        foreach($res_arr1 as $row){
            $row_arr = explode('=',$row);
            $res_arr[$row_arr[0]] = $row_arr[1];
        }
        fclose($f);
        return $res_arr;
    }
}
if(! function_exists('ci_getSession_data')) {

    function ci_getSession_data(){
        $CI =& get_instance();

        $arr['user_id'] = $CI->session->userdata('user_id');
        $arr['user_email'] = $CI->session->userdata('user_email');
        $arr['user_role'] = $CI->session->userdata('user_role');
        $arr['user_role_name'] = $CI->session->userdata('user_role_name');

        $arr['user_outlet'] = $CI->session->userdata('user_outlet');
        return $arr;
    }
}
if(! function_exists('ci_get_response')) {

    function ci_get_response($url,$data){
    
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));//CURLOPT_HTTPGET	
        $reply=curl_exec($ch);//echo $reply;
        curl_close($ch);
        $res_arr = json_decode($reply,true);
        return $res_arr;
    }
//            $test_name = str_replace("_", " ",__FUNCTION__);

}
if(! function_exists('ci_get_unit_test_name')) {

    function ci_get_unit_test_name($func){
        return strtoupper( str_replace(array("_",'ci'), " ",$func));
    }
//            $test_name = str_replace("_", " ",__FUNCTION__);

}
if(! function_exists('ci_send_email')) {

    function ci_send_email($to,$subject,$message,$from='',$from_name=''){
        $CI =& get_instance();
        $CI->load->model('Constant_model');

        if($from==''){
            $user_data = $CI->Constant_model->getDataOneColumn('users', 'role_id', 1);
            $from = $from_name='';
            if(count($user_data)>0){
               $from= $user_data[0]->email;
               $from_name= $user_data[0]->fullname;

            }
        }

        $CI->load->library('email');

        $CI->email->from($from, $from_name);
        $CI->email->to($to); 
        $CI->email->subject($subject);
        $CI->email->message($message);	
        $CI->email->send();

         $CI->email->print_debugger();

    }
}

if(! function_exists('encryptPassword')) {

  function encryptPassword($password)
    {
        return md5("$password");
    }

}

if(! function_exists('ci_check_permission')) {

    function ci_check_permission($user_role){
        $CI =& get_instance();
        $CI->load->model('Constant_model');
        $rules_data = $CI->Constant_model->getDataWhere('rules', 'role_id='.$user_role.' AND allowed_type="allow" ');
        $name_data = $CI->Constant_model->getddData('resources','id','name', 'id');
        $rules_array = array();
        foreach($rules_data as $row){
            $resource = (array_key_exists($row->resource_id, $name_data))?$name_data[$row->resource_id]:'-';
            $rules_array[$resource]= 'allow';
        }
        return $rules_array;
    }
}

if(! function_exists('ci_check_user_permission')) {

    function ci_check_user_permission($user_id){
        $CI =& get_instance();
        $CI->load->model('Constant_model');
		
        $rules_data = $CI->Constant_model->getDataWhere('permissions', 'user_id='.$user_id.' ');
		
		/*
        $name_data = $CI->Constant_model->getddData('resources','id','name', 'id');
		
		echo '<Pre>';print_r($rules_data);exit;
		
        $rules_array = array();
        foreach($rules_data as $row){
            $resource = (array_key_exists($row->resource_id, $name_data))?$name_data[$row->resource_id]:'-';
            $rules_array[$resource]= 'allow';
        }
		*/
		
        return $rules_data;
    }
}


if(! function_exists('ci_permissionOnlySysRole')) {

    function  ci_permissionOnlySysRole(){
        $CI =& get_instance();
        $user_role = $CI->session->userdata('user_role');
        $user_role_name = $CI->session->userdata('user_role_name');
        $flag=false;
        if($user_role_name === 'SYSTEM_ADMIN_ROLE'){
            $flag=true;
        }
        return $flag;

    }
}
if(! function_exists('ci_permissionSysAdminRole')) {

    function  ci_permissionSysAdminRole(){
        $CI =& get_instance();
        $user_role = $CI->session->userdata('user_role');
        $user_role_name = $CI->session->userdata('user_role_name');
        $flag=false;
        if($user_role_name === SYSTEM_ADMIN_ROLE  || $user_role_name === ADMIN_ROLE){
            $flag=true;
        }
        return $flag;

    }
}
if(! function_exists('ci_permissionSysAdminSuperRole')) {

    function  ci_permissionSysAdminSuperRole(){
        $CI =& get_instance();
        $user_role = $CI->session->userdata('user_role');
        $user_role_name = $CI->session->userdata('user_role_name');
        $flag=false;
        if($user_role_name === SYSTEM_ADMIN_ROLE  || $user_role_name === ADMIN_ROLE  || $user_role_name === SUPER_MANAGER_ROLE ){
            $flag=true;
        }
        return $flag;

    }
}
if(! function_exists('ci_permissionSysAdminSuperManagerRole')) {

    function  ci_permissionSysAdminSuperManagerRole(){
        $CI =& get_instance();
        $user_role = $CI->session->userdata('user_role');
        $user_role_name = $CI->session->userdata('user_role_name');
        $flag=false;
        if($user_role_name === SYSTEM_ADMIN_ROLE  || $user_role_name === ADMIN_ROLE  
           || $user_role_name === SUPER_MANAGER_ROLE || $user_role_name === MANAGER_ROLE
        ){
            $flag=true;
        }
        return $flag;

    }
}
if(! function_exists('ci_permissionSysAdminSuperManagerSalesRole')) {

    function  ci_permissionSysAdminSuperManagerSalesRole(){
        $CI =& get_instance();
        $user_role = $CI->session->userdata('user_role');
        $user_role_name = $CI->session->userdata('user_role_name');
        $flag=false;
        if($user_role_name === SYSTEM_ADMIN_ROLE  || $user_role_name === ADMIN_ROLE  
           || $user_role_name === SUPER_MANAGER_ROLE || $user_role_name === MANAGER_ROLE || $user_role_name === SALES_PERSON_ROLE
        ){
            $flag=true;
        }
        return $flag;

    }
}
if(! function_exists('ci_permissionSysAdminSuperManagerSalesCustomerRole')) {

    function  ci_permissionSysAdminSuperManagerSalesCustomerRole(){
        $CI =& get_instance();
        $user_role = $CI->session->userdata('user_role');
        $user_role_name = $CI->session->userdata('user_role_name');
        $flag=false;
        if($user_role_name === 'SYSTEM_ADMIN_ROLE'  || $user_role_name === 'ADMIN_ROLE'  
           || $user_role_name === 'SUPER_MANAGER_ROLE' || $user_role_name === 'MANAGER_ROLE' || $user_role_name === 'SALES_PERSON_ROLE'
                || $user_role_name === 'CUSTOMER_ROLE'
        ){
            $flag=true;
        }
        return $flag;

    }
}
if(! function_exists('ci_add_transaction')) {

    function ci_add_transaction($user_outlet,$grandTotal,$pm,$tt='dep'){
        $CI =& get_instance();
        $CI->load->model('Constant_model');

        $payment['trans_type']=$tt;
        $payment['outlet_id']=$user_outlet;
        $payment['amount']=$grandTotal;
        $payment['account_number']= '0'.$pm;
       // $CI->db->insert('transactions', $payment);
       $tid = $CI->Constant_model->insertDataReturnLastId('transactions', $payment);
       return $tid;
    }
    
    
}
if(! function_exists('ci_manage_balance_pm')) {

    function ci_manage_balance_pm($payment_method,$payment,$outlet_id){
            $CI =& get_instance();

            $CI->load->model('Constant_model');
            $balance=0;
           // echo "pm=$payment_method out=$outlet_id";
            $balance_arr = json_decode($CI->Constant_model->getSingle('payment_method','balance','id='.$payment_method),true);
           // echo "<pre>";print_r($balance_arr);echo "</pre>";
            if(count($balance_arr)>0){
                if(array_key_exists($outlet_id, $balance_arr) && array_key_exists($payment_method, $balance_arr[$outlet_id]))
                {
                    $balance = (count($balance_arr[$outlet_id][$payment_method])>0)? $balance_arr[$outlet_id][$payment_method]: 0;
                }
            }
            
            $balance_arr[$outlet_id][$payment_method]   =  $balance + $payment;
            $balance =  json_encode($balance_arr);
            $sql = "UPDATE payment_method set balance='".$balance."' WHERE id=$payment_method";
            $CI->db->query($sql);   
    }
}
if(! function_exists('ci_manage_balance_customer')) {

    function ci_manage_balance_customer($cid,$payment,$type){
        $CI =& get_instance();

        $CI->load->model('Constant_model');
        $balance_arr = json_decode($CI->Constant_model->getSingle('customers','balance','id='.$cid,'balance'),true);
        $date = date('Y-m-d');
        if(is_array($balance_arr)){
                
            $balance_amount = (array_key_exists('balance', $balance_arr))?$balance_arr['balance']:0;
            $outstanding_tids = (array_key_exists('outstanding', $balance_arr))?$balance_arr['outstanding']:array();
            $settle_tids = (array_key_exists('settle', $balance_arr))?$balance_arr['settle']:array();
        }
        else{
            $balance_amount=0;
            $outstanding_tids=array();
            $settle_tids=array();
        }
        
        if($type == 'outstanding'){
            $balance_amount = $balance_amount + $payment;
            
            $outstanding_tids[$date][]=$payment;

        } else if($type == 'settle'){
            $balance_amount = $balance_amount - $payment;
            $settle_tids[$date][]=$payment;
        }
        $balance_arr_new['balance']=$balance_amount;
        $balance_arr_new['outstanding']=$outstanding_tids;
        $balance_arr_new['settle']=$settle_tids;


        $balance =  json_encode($balance_arr_new);

        $sql = "UPDATE customers set balance='".$balance."' WHERE id=$cid";
        $CI->db->query($sql);   
            
    }
}
if(! function_exists('ci_update_customer_deposit_tid')) {

    function ci_update_customer_deposit_tid($customer_id,$tid,$payment,$trans_type){
        $CI =& get_instance();
        $CI->load->model('Constant_model');
        $tid_json = $CI->Constant_model->getSingle('customers','tid','id='.$customer_id);
        $tid_json = json_decode($tid_json,TRUE);
        $tid_json[$trans_type]=$tid;
        $tid_json = json_encode($tid_json);
        $CI->db->query("UPDATE customers set deposit=deposit+$payment,tid='".$tid_json."' WHERE id=$customer_id");    
    }
}
if(! function_exists('updategiftCardaftersale')) {

        function updategiftCardaftersale($card_numb,$user_id,$tm,$value){
                    $CI =& get_instance();

             if (!empty($card_numb)) {
                        $ckGiftResult = $CI->db->query("SELECT * FROM gift_card WHERE card_number = '$card_numb' ");
                        $ckGiftRows = $ckGiftResult->num_rows();
                        if ($ckGiftRows == 1) {
                            $ckGiftData = $ckGiftResult->result();

                            $ckGift_id = $ckGiftData[0]->id;

                            $upd_gift_data = array(
                                      'status' => '1',
                                      'updated_user_id' => $user_id,
                                      'updated_datetime' => $tm,
                            );
                            $CI->db->query("UPDATE gift_card SET status='1','updated_user_id'= $user_id, "
                                    . "updated_datetime='".$tm."', values= value=$value "
                                    . "WHERE id = $ckGift_id ");
                            //$this->Constant_model->updateData('gift_card', $upd_gift_data, $ckGift_id);

                            unset($ckGiftData);
                        }
                        unset($ckGiftResult);
                        unset($ckGiftRows);
                    }

        }
        
}
//if(! function_exists('ci_submodules')) {
//
//        function ci_submodules(){
//            $CI =& get_instance();
//            $CI->load->model('Constant_model');
//            $sub_module_array=array();
//            $resource_dd =  $CI->Constant_model->getddData('resources','id','name', 'id');
//
//            foreach($resource_dd as $key1){
//                // echo "key=$key1";
//                 if($key1 == 'appointments' ){
//                     $sub_module_array[$key1]['index']='Appointments';
//                     $sub_module_array[$key1]['add_appointment']='Add Appointments';
//                     $sub_module_array[$key1]['list_appointment']='Manage Appointments';
//                 }  
//                 if($key1 == 'purchase_order' ){
//                     $sub_module_array[$key1]['po_view']='Purchases';
//                  }  
//                 if($key1 == 'sales' ){
//                     $sub_module_array[$key1]['customers/view']='Customers';
//                     $sub_module_array[$key1]['debit/view']='Credit Sales';
//                     $sub_module_array[$key1]['sales/list_sales']='Today Sales';
//                     $sub_module_array[$key1]['sales/opened_bill']='Opened Bill';
//                     $sub_module_array[$key1]['pos/index']='POS';
//                     $sub_module_array[$key1]['returnorder/create_return']='Sales Return';
//                     $sub_module_array[$key1]['returnorder/return_report']='Sales Return Receipt';
//                 }
//                 if($key1 == 'bakery_sales' ){
//                     $sub_module_array[$key1]['bakery_sales/bakerySales']='Bakery Sales';
//                    
//                 }
//                  if($key1 == 'pumps' ){
//                     $sub_module_array[$key1]['pumps/index']='List Pumps';
//                     $sub_module_array[$key1]['pumps/list_operators']='List Pump Operators';
//                     $sub_module_array[$key1]['pumps/list_ft']='List Fuel Tanks';
//                     $sub_module_array[$key1]['pumps/pumpSales']='Pump Comm & Shortage';
//
//                 }
//                  if($key1 == 'inventory' ){
//                     $sub_module_array[$key1]['inventory/view']='Inventory';
//
//                 }
//                  if($key1 == 'products' ){
//                      $sub_module_array[$key1]['products/list_products']='Products';
//                     $sub_module_array[$key1]['products/product_category']='Product Category';
//                     $sub_module_array[$key1]['products/print_label']='Print Product Label';
//
//                 }
//                 if($key1 == 'bank_accounts' ){
//                     $sub_module_array[$key1]['bank_accounts/index']='Bank Accounts';
//                      $sub_module_array[$key1]['bank_accounts/balance']='Account balance';
//
//                 }
//                 if($key1 == 'bank_dt' ){
//                      $sub_module_array[$key1]['bank_dt/index']='Bank Deposit / Transfer';
//
//                 }
//                 if($key1 == 'gift_card' ){
//                     $sub_module_array[$key1]['gift_card/add_gift_card']='Add Gift Card';
//                     $sub_module_array[$key1]['gift_card/list_gift_card']='List Gift Card';
//
//                 }
//                 if($key1 == 'expenses' ){
//                     $sub_module_array[$key1]['expenses/view']='Expenses';
//                     $sub_module_array[$key1]['expenses/expense_category']='Expense Category';
//
//                 }
//                  if($key1 == 'reports' ){
//                     $sub_module_array[$key1]['reports/sales_report']='Sales Report';
//                     $sub_module_array[$key1]['reports/product_category_report']='Product Category Report';
//                     $sub_module_array[$key1]['reports/issue_sale_report']='Issue Sales Report';
//
//                 }
//                 if($key1 == 'pnl' ){
//                     $sub_module_array[$key1]['pnl/view']='P & L Graphs';
//
//                 }
//                  if($key1 == 'pnl' ){
//                     $sub_module_array[$key1]['pnl_report/view_pnl_report']='P & L Report';
//
//                 }
//                 if($key1 == 'setting' ){
//                     $sub_module_array[$key1]['setting/outlets']='Outlets';
//                     $sub_module_array[$key1]['setting/users']='Users';
//                     $sub_module_array[$key1]['setting/payment_methods']='Payment Metods';
//                     $sub_module_array[$key1]['setting/system_setting']='System Setting';
//
//                 }
//                 if($key1 == 'Sys_admin' ){
//                     $sub_module_array[$key1]['Sys_admin/roles']='Manage Roles';
//                     $sub_module_array[$key1]['Sys_admin/modules']='Modules';
//                     $sub_module_array[$key1]['Sys_admin/rules']='Rules';
//                     $sub_module_array[$key1]['Sys_admin/Sys_setting']='System Setting';
//
//                 }
//
//             }
//                                                
//            return $sub_module_array;
//        }
//}
if(! function_exists('ci_submodules')) {

        function ci_submodules(){
            $CI =& get_instance();
            $CI->load->model('Constant_model');
            $sub_module_array=array();
            $resource_dd =  $CI->Constant_model->getddData('resources','id','name', 'id');

            foreach($resource_dd as $key1){
                // echo "key=$key1";
                 if($key1 == 'appointments' ){
                     $sub_module_array[$key1]['index']='Appointments';
                     $sub_module_array[$key1]['add_appointment']='Add Appointments';
                     $sub_module_array[$key1]['list_appointment']='Manage Appointments';
                 }  
                 if($key1 == 'purchase_order' ){
                     $sub_module_array[$key1]['po_view']='Purchases';
                  }  
                 if($key1 == 'sales' ){
             //        $sub_module_array[$key1]['view']='Customers';
                     $sub_module_array[$key1]['list_sales']='Today Sales';
                     $sub_module_array[$key1]['opened_bill']='Opened Bill';
                     
                 }
                 if($key1 == 'debit' ){
                     $sub_module_array[$key1]['view']='Credit Sales';
                    
                 }
                  if($key1 == 'customers' ){
                     $sub_module_array[$key1]['view']='Customers';
                    
                 }
                  if($key1 == 'pos' ){
                     $sub_module_array[$key1]['index']='POS';
                    
                 }
                 if($key1 == 'bakery_sales' ){
                     $sub_module_array[$key1]['bakerySales']='Bakery Sales';
                    
                 }
                 if($key1 == 'returnorder' ){
                     $sub_module_array[$key1]['create_return']='Sales Return';
                     $sub_module_array[$key1]['return_report']='Sales Return Receipt';                    
                 }
                  if($key1 == 'pumps' ){
                     $sub_module_array[$key1]['index']='List Pumps';
                     $sub_module_array[$key1]['list_operators']='List Pump Operators';
                     $sub_module_array[$key1]['list_ft']='List Fuel Tanks';
                     $sub_module_array[$key1]['pumpSales']='Pump Comm & Shortage';

                 }
                  if($key1 == 'inventory' ){
                     $sub_module_array[$key1]['view']='Inventory';

                 }
                  if($key1 == 'products' ){
                      $sub_module_array[$key1]['list_products']='Products';
                     $sub_module_array[$key1]['product_category']='Product Category';
                     $sub_module_array[$key1]['print_label']='Print Product Label';

                 }
                 if($key1 == 'bank_accounts' ){
                     $sub_module_array[$key1]['index']='Bank Accounts';
                      $sub_module_array[$key1]['balance']='Account balance';

                 }
                 if($key1 == 'bank_dt' ){
                      $sub_module_array[$key1]['index']='Bank Deposit / Transfer';

                 }
                 if($key1 == 'gift_card' ){
                     $sub_module_array[$key1]['add_gift_card']='Add Gift Card';
                     $sub_module_array[$key1]['list_gift_card']='List Gift Card';

                 }
                 if($key1 == 'expenses' ){
                     $sub_module_array[$key1]['view']='Expenses';
                     $sub_module_array[$key1]['expense_category']='Expense Category';

                 }
                  if($key1 == 'reports' ){
                     $sub_module_array[$key1]['sales_report']='Sales Report';
                     $sub_module_array[$key1]['product_category_report']='Product Category Report';
                     $sub_module_array[$key1]['issue_sale_report']='Issue Sales Report';

                 }
                 if($key1 == 'pnl' ){
                     $sub_module_array[$key1]['view']='P & L Graphs';

                 }
                  if($key1 == 'pnl' ){
                     $sub_module_array[$key1]['view_pnl_report']='P & L Report';

                 }
                 if($key1 == 'setting' ){
                     $sub_module_array[$key1]['outlets']='Outlets';
                     $sub_module_array[$key1]['users']='Users';
                     //$sub_module_array[$key1]['permission']='Permissions';
                     $sub_module_array[$key1]['payment_methods']='Payment Metods';
                     $sub_module_array[$key1]['system_setting']='System Setting';
                     $sub_module_array[$key1]['suppliers']='Suppliers';

                 }
                 if($key1 == 'Sys_admin' ){
                     $sub_module_array[$key1]['roles']='Manage Roles';
                     $sub_module_array[$key1]['modules']='Modules';
                     $sub_module_array[$key1]['rules']='Rules';
                     $sub_module_array[$key1]['Sys_setting']='System Setting';

                 }

             }
                                                
            return $sub_module_array;
        }
}
if(! function_exists('ci_is_sub_module')) {

    function ci_is_sub_module($module,$sub){
    $CI =& get_instance();

    $id      =  $CI->Constant_model->getSingle('resources','id','name="'.$module.'"');
    $res      =  $CI->Constant_model->getSingle('resources','name','name="'.$sub.'" AND pid='.$id);
    return strtolower($res);
    }
}