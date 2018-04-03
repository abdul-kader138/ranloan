<?php
require_once 'includes/header.php';

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
$def_store_id = $siteDtaData[0]->default_store_id;
$site_logo = $siteDtaData[0]->site_logo;
$pre_print_invoice=$siteDtaData[0]->pre_print_invoice;
$new_settings = $siteDtaData[0]->new_settings;
$new_settings_array = json_decode($new_settings, true);
$is_point = (array_key_exists('is_point',$new_settings_array))?$new_settings_array['is_point']:'';
?>
<style>
/* Extras */
a:visited{color:#888}
a{color:#444;text-decoration:none;}
p{margin-bottom:.3em;}

label > input{ /* HIDE RADIO */
  visibility: hidden; /* Makes input not-clickable */
  position: absolute; /* Remove input from document flow */
}
label > input + img{ /* IMAGE STYLES */
  cursor:pointer;
  border:2px solid transparent;
   border-radius: 90%;
}
label > input:checked + img{ /* (RADIO CHECKED) IMAGE STYLES */
  border:4px solid #5fc509;
  /*border:2px solid #f00;*/
   border-radius: 90%;
}
 </style> 

<style type="text/css">
	.fileUpload {
	    position: relative;
	    overflow: hidden;
	    border-radius: 0px;
	    margin-left: -4px;
	    margin-top: -2px;
	}
	.fileUpload input.upload {
	    position: absolute;
	    top: 0;
	    right: 0;
	    margin: 0;
	    padding: 0;
	    font-size: 20px;
	    cursor: pointer;
	    opacity: 0;
	    filter: alpha(opacity=0);
	}
	ul li
	{
		list-style: none;
	}
</style>

<link href="<?=base_url();?>assets/css/jquery.multiselect.css" rel="stylesheet" />

<script src="<?=base_url();?>assets/js/jquery.multiselect.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		document.getElementById("uploadBtn").onchange = function () {
			document.getElementById("uploadFile").value = this.value;
		};
	});
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-6">
			<h1 class="page-header">System Setting</h1>
		</div>
		<div class="col-lg-4" style="text-align: right; padding-top: 30px;">
			<a class="btn btn-primary" href="<?=base_url()?>setting/export_database">Export Database</a>
		</div>
		<div class="col-lg-1" style="text-align: right; padding-top: 30px;">
			<a class="btn btn-primary" href="<?=base_url()?>setting/email_system_setting">Email Setting</a>
		</div>
		
	</div><!--/.row-->
	
	<form action="<?=base_url()?>setting/updateSiteSetting" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php
                        if (!empty($alert_msg)) {
                            $flash_status = $alert_msg[0];
                            $flash_header = $alert_msg[1];
                            $flash_desc = $alert_msg[2];
                            if ($flash_status == 'failure') { ?>
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
                            if ($flash_status == 'success') { ?>
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
								<label>Site Name <span style="color: #F00">*</span></label>
								<input type="text" name="site_name" class="form-control" placeholder="Site Name" maxlength="499" autofocus required value="<?php echo $site_name; ?>" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>System Timezone</label>
								<select name="timezone" class="form-control" required>
								<?php
                                    $timeZoneData = $this->Constant_model->getDataAll('timezones', 'timezone', 'ASC');
                                    for ($t = 0; $t < count($timeZoneData); ++$t) {
                                        $timezone_name = $timeZoneData[$t]->timezone; ?>
										<option value="<?php echo $timezone_name; ?>" <?php if ($timezone_name == $timezone) {
                                            echo 'selected="selected"';
                                        } ?>>
											<?php echo $timezone_name; ?>
										</option>
								<?php	
                                        unset($timezone_name);
                                    }
                                ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Pagination Per Page <span style="color: #F00">*</span></label>
								<select name="pagination" class="form-control" required>
									<option value="10" <?php if ($pagination == '10') {
                                    echo 'selected="selected"';
                                } ?>>10</option>
									<option value="20" <?php if ($pagination == '20') {
                                    echo 'selected="selected"';
                                } ?>>20</option>
									<option value="50" <?php if ($pagination == '50') {
                                    echo 'selected="selected"';
                                } ?>>50</option>
									<option value="100" <?php if ($pagination == '100') {
                                    echo 'selected="selected"';
                                } ?>>100</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Tax (%) <span style="color: #F00">*</span></label>
								<input type="text" name="tax" class="form-control" placeholder="0.00" required value="<?php echo $tax; ?>" autocomplete="off" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Currency <span style="color: #F00">*</span></label>
								<select name="currency" class="form-control" required>
								<?php
                                    $currencyData = $this->Constant_model->getDataAll('currency', 'iso', 'ASC');
                                    for ($c = 0; $c < count($currencyData); ++$c) {
                                        $currency_iso = $currencyData[$c]->iso; ?>
										<option value="<?php echo $currency_iso; ?>" <?php if ($currency_iso == $currency) {
                                            echo 'selected="selected"';
                                        } ?>>
											<?php echo $currency_iso; ?>
										</option>
								<?php
                                        unset($currency_iso);
                                    }
                                ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>System Date Format <span style="color: #F00">*</span></label>
								<select name="date_format" class="form-control" required>
									<option value="Y-m-d" <?php if ($dtm_format == 'Y-m-d') {
                                    echo 'selected="selected"';
                                } ?>>yyyy-mm-dd</option>
									<option value="Y.m.d" <?php if ($dtm_format == 'Y.m.d') {
                                    echo 'selected="selected"';
                                } ?>>yyyy.mm.dd</option>
									<option value="Y/m/d" <?php if ($dtm_format == 'Y/m/d') {
                                    echo 'selected="selected"';
                                } ?>>yyyy/mm/dd</option>
									<option value="m-d-Y" <?php if ($dtm_format == 'm-d-Y') {
                                    echo 'selected="selected"';
                                } ?>>mm-dd-yyyy</option>
									<option value="m.d.Y" <?php if ($dtm_format == 'm.d.Y') {
                                    echo 'selected="selected"';
                                } ?>>mm.dd.yyyy</option>
									<option value="m/d/Y" <?php if ($dtm_format == 'm/d/Y') {
                                    echo 'selected="selected"';
                                } ?>>mm/dd/yyyy</option>
									<option value="d-m-Y" <?php if ($dtm_format == 'd-m-Y') {
                                    echo 'selected="selected"';
                                } ?>>dd-mm-yyyy</option>
									<option value="d.m.Y" <?php if ($dtm_format == 'd.m.Y') {
                                    echo 'selected="selected"';
                                } ?>>dd.mm.yyyy</option>
									<option value="d/m/Y" <?php if ($dtm_format == 'd/m/Y') {
                                    echo 'selected="selected"';
                                } ?>>dd/mm/yyyy</option>
								</select>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>POS Display Product <span style="color: #F00">*</span></label>
								<select name="display_product" class="form-control" required>
									<option value="1" <?php if ($display_product == '1') {
                                    echo 'selected="selected"';
                                } ?>>Name</option>
									<option value="2" <?php if ($display_product == '2') {
                                    echo 'selected="selected"';
                                } ?>>Photo</option>
									<option value="3" <?php if ($display_product == '3') {
                                    echo 'selected="selected"';
                                } ?>>Both</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>POS Display Keyboard <span style="color: #F00">*</span></label>
								<select name="display_keyboard" class="form-control" required>
									<option value="1" <?php if ($keyborad == '1') {
                                    echo 'selected="selected"';
                                } ?>>Yes</option>
									<option value="0" <?php if ($keyborad == '0') {
                                    echo 'selected="selected"';
                                } ?>>No</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>POS Default Customer <span style="color: #F00">*</span></label>
								<select name="default_customer" class="form-control" required="">
									<?php
									$customerData = $this->Constant_model->getDataAll('customers', 'id', 'ASC');
									for ($u = 0; $u < count($customerData); ++$u) {
										$customer_id = $customerData[$u]->id;
										$customer_name = $customerData[$u]->fullname;
										?>
										<option value="<?php echo $customer_id; ?>" <?php
										if ($customer_id == $def_cust_id) {
											echo 'selected="selected"';
										}
										?>>
										<?php echo $customer_name; ?>
										</option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
					</div>
                                   
					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<?php
									$explode_default_store = explode(",", $def_store_id);
								?>
								<label>POS Default Store <span style="color: #F00">*</span></label>
								<select name="default_store[]" id="multiselectStore" multiple="" class="form-control">
									<?php
									$storeData = $this->Constant_model->getOutletAssignStore('stores', 's_id', 'ASC');
									foreach ($storeData as $valueStore)
									{ 
										$selected = '';
										foreach ($explode_default_store as $de_store)
										{
											if($de_store == $valueStore->store_id)
											{
												$selected = "selected";
											}
										}
										?>
									<option <?=$selected?> value="<?=$valueStore->store_id?>" <?=$selected?> ><?=$valueStore->s_name;?></option>
									<?php 
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label>Logo <span style="color: #F00">*</span></label><br />
								<input id="uploadFile" readonly style="height: 40px; width: 230px; border: 1px solid #ccc" />
								<div class="fileUpload btn btn-primary" style="padding: 9px 12px;">
								    <span>Browse</span>
								    <input id="uploadBtn" name="uploadFile" type="file" class="upload" />
								</div>
							</div>
						</div>
						<div class="col-md-4">   
							<div class="form-group">
								<label><br> Pre Printed Invoice  </label> <br>
								 <label>
								<input type="radio" name="pre_print_invoice"  value="1" <?php if(isset($pre_print_invoice) && $pre_print_invoice==1) echo "checked"; ?>/>
								<img width="60px" class="img-circle" src="<?php echo base_url("assets/img/yes.jpg"); ?>">
								</label>
							   <label>
								<input type="radio" name="pre_print_invoice"  value="0" <?php if(isset($pre_print_invoice) && $pre_print_invoice==0) echo "checked"; ?>/>
								<img width="60px" class="img-circle" src="<?php echo base_url("assets/img/noo.jpg"); ?>">
								</label>
							</div>
						</div>
						<div class="col-md-4"></div>
					</div>
					
						
					  
				
					
					<div class="row">
						<div class="col-md-4">
							<img src="<?=base_url()?>assets/img/logo/<?php echo $site_logo; ?>" height="100px" />
						</div>
						 <div class="col-md-4">
                                <div class="form-group">
                                    <label>Points</label>
                            <?php echo  sel_element(array('yes'=>'Yes','no'=>'No'), $is_point, '', 'is_point', ' ', 0);?>

                                </div>
                            </div>
                            <div class="col-md-4" id="per_div" style="display: none">
                                <div class="form-group">
                                    <label>Point Percentage</label>
                                    <input type="number" step="0.01" max="100"  class="form-control" name="point_percentage" id="point_percentage" value="<?php echo (array_key_exists('point_percentage', $new_settings_array))?$new_settings_array['point_percentage']:''; ?>"/>
                                </div>
                                
                            </div>
						
						
<!--						<div class="col-md-4">
							 <div class="form-group" align='right'>
							<label>Award Points</label> <br>                                
							   <label>
							  <input type="radio" name="award_points" class="radioBtn" value="1" />
							  <img width="60px" class="img-circle" src="<?php echo base_url("assets/img/yes.jpg"); ?>">
							</label>
							   <label>
							  <input type="radio" name="award_points" class="radioBtn" value="0" />
							  <img width="60px" class="img-circle" src="<?php echo base_url("assets/img/noo.jpg"); ?>">
						   </label>
						   </div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Award Points Percentage</label>
								<input type="text" name="percentage" id="percentage" onkeypress='return isNumber(event)' class="form-control" maxlength="499"  required autocomplete="off" value="" />
							</div>
						</div>-->
					</div>
					
					
					
					<div class="row" style="margin-top: 20px;">
						<div class="col-md-4">
							<div class="form-group">
								<button class="btn btn-primary">Update System Setting</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
				</div>
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	</form>
	<br /><br /><br />
</div><!-- Right Colmn // END -->
<script>
	<?php if($is_point !='') {?>
    $('#per_div').show();

<?php } ?>
	
	$('#is_point').on('change',function(){
        if($('#is_point').val() ==='yes' )
		{
                $('#per_div').show();
		} 
		else
		{
            $('#point_percentage').val(0);
            $('#per_div').hide();
        }
    });
	
    $('document').ready(function(){
        $('#multiselectStore').multiselect({
            columns: 1,
            placeholder: 'Select Store',
            search: true,
            selectAll: true
        });
    });
	
</script>




	
<script type="text/javascript">
    $("#percentage").attr("disabled", true);
$(".radioBtn").click(function() {
    $("#percentage").attr("disabled", true);
    if ($("input[name=award_points]:checked").val() == 1) {
        $("#percentage").attr("disabled", false);
    }
});
     function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
</script> 
	
<?php
    require_once 'includes/footer.php';
?>