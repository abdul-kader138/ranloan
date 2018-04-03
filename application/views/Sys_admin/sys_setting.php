<?php
 
$siteDtaData = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');

$site_name = $siteDtaData[0]->site_name;
$timezone = $siteDtaData[0]->timezone;
$pagination = $siteDtaData[0]->pagination;
$tax = $siteDtaData[0]->tax;
$currency = $siteDtaData[0]->currency;
$dtm_format = $siteDtaData[0]->datetime_format;
$display_product = $siteDtaData[0]->display_product;
$keyborad = $siteDtaData[0]->display_keyboard;
$def_cust_id = $siteDtaData[0]->default_customer_id;
$site_logo = $siteDtaData[0]->site_logo;
$new_settings = $siteDtaData[0]->new_settings;
$new_settings_array = json_decode($new_settings, true);
$is_point = (array_key_exists('is_point',$new_settings_array))?$new_settings_array['is_point']:'';
$pumps_arr= array();$pumps=$outlet=0;
?>

<link href="<?=base_url()?>assets/css/editor.css" rel="stylesheet">
<script>
    pump_arr = [];
	<?php
		foreach($outlets as $oid=>$outlet_rec){
			if(array_key_exists('max_pumps'.$oid, $new_settings_array)){
				?>
				pump_arr['<?php echo $oid;?>'] = '<?php echo $new_settings_array['max_pumps'.$oid]?>';
				<?php
			}
		}
	?>
    
    $(document).ready(function(){
    $('#outlet_id').on('change',function(){
        var oid = $('#outlet_id').val();
            if(typeof pump_arr[oid] === 'undefined'){
            $('#max_pumps').val(0);
		} else {
            $('#max_pumps').val(pump_arr[oid]);
        }
    });
});
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">System Setting</h1>
        </div>
    </div><!--/.row-->

    <form action="<?= base_url() ?>Sys_admin/updateSetting" method="post" id="settingForm" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php
                        if (!empty($alert_msg)) {
                            $flash_status = $alert_msg[0];
                            $flash_header = $alert_msg[1];
                            $flash_desc = $alert_msg[2];

                            if ($flash_status == 'failure') {
                                ?>
                                <div class="row" id="notificationWrp">
                                    <div class="col-md-12">
                                        <div class="alert bg-warning" role="alert">
                                            <i class="icono-exclamationCircle" style="color: #FFF;"></i> 
                                            <?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if ($flash_status == 'success') {
                                ?>
                                <div class="row" id="notificationWrp">
                                    <div class="col-md-12">
                                        <div class="alert bg-success" role="alert">
                                            <i class="icono-check" style="color: #FFF;"></i> 
                                            <?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                       
                        ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                        <label>Maximum Number of outlets</label>
                                        <input type="number" step="1" min="0" name="max_outlets" value="<?php echo (array_key_exists('max_outlets', $new_settings_array))? $new_settings_array['max_outlets']:0;?>" class="form-control" maxlength="499" autofocus autocomplete="off" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                        <label>Maximum Number of Pumps</label>
                                        <input type="number" step="1" min="0" name="max_pumps" id="max_pumps" value="<?php echo $pumps;?>" class="form-control" maxlength="499" autofocus autocomplete="off" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php 
                                     
                                    echo sel_element($outlets,$outlet,'Select Outlet','outlet_id','Choose Outlet ',0);

                                    ?>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="hero-unit">
                                <label>Invoice Footer Text  </label>

                                <?php //echo ci_getRichTextTollBar() ?>
                                <textarea id="invoice_footer" name="invoice_footer"></textarea> 

                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                        </div>
                
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button class="btn btn-primary">&nbsp;&nbsp;Update System Setting&nbsp;&nbsp;</button>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                        </div>
                        
                        <div class="row" style="width:30%;margin:5% 0 5% 0;padding:1% 0 0 0;background-color: #686868; color: #FFF;height:40px;font-weight: bold;">
                            <div class="col-md-9">
                                Maximum Allowed Outlets
                            </div>
                            <div class="col-md-3">
                                    <?php echo (array_key_exists('max_outlets', $new_settings_array))? $new_settings_array['max_outlets']:0;?>                           
                            </div>
                        </div>
						<div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" style="width: 30%">
                                        <thead>
                                            <tr>
                                                <th width="40%" style="background-color: #686868; color: #FFF;">Outlet Name</th>
                                                <th width="60%" style="background-color: #686868; color: #FFF;">Maximum Allowed Pumps</th>
                                             </tr>
                                        </thead>
                                        <tbody >
                                            <?php foreach ($outlets as $oid=>$onmae){?>
                                            <tr>
                                                <td><?php echo $onmae;?></td>
                                                <td><?php echo array_key_exists('max_pumps'.$oid, $new_settings_array)?$new_settings_array['max_pumps'.$oid]:0; ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div><!-- Panel Body // END -->
                </div><!-- Panel Default // END -->
            </div><!-- Col md 12 // END -->
        </div><!-- Row // END -->
    </form>

    <br /><br /><br />

</div><!-- Right Colmn // END -->

<script src="<?=base_url()?>assets/js/editor.js"></script>
<script>
$(document).ready(function() {
    $("#invoice_footer").Editor();
    $("#invoice_footer").Editor("setText",'<?php echo (array_key_exists('invoice_footer', $new_settings_array))?$new_settings_array['invoice_footer']:'';?>');

	<?php if($is_point !='') {?>
		$('#per_div').show();
	<?php } ?>
});

	$('#settingForm').on('submit',function(){
		var editor_html = $("#invoice_footer").Editor("getText");
		$("#invoice_footer").val(editor_html);
	})
    $('#is_point').on('change',function(){
        if($('#is_point').val() ==='yes' ){
			$('#per_div').show();
		} else{
			$('#per_div').hide();
		}
    });
</script>
