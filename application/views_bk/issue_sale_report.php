    <?php
require_once 'includes/header.php';

$orderRows = 0;
$dd_sps = $this->Constant_model->getddData('users', 'id', 'fullname', 'fullname');
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script>
    $(function () {
        $("#startDate").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });

        $("#endDate").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });
    });
</script>

<?php
$outlets = $this->Constant_model->getddData('outlets', 'id', 'name', 'id');

?>
<script type="text/javascript">
    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>

<script type="text/javascript" src="<?= base_url() ?>assets/js/datatables/jquery-1.12.3.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?= base_url() ?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">
<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Issue Sale Report</h1>
        </div>
    </div><!--/.row-->

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <form action="<?= base_url() ?>reports/issue_sale_report" method="get">
                        <div class="row">
                                  <div class="col-md-4">
                                                 <?php
                                                 //$sid_arr
                                                   if ($user_role == 1) {
                                                            $outlets = array('-'=>'All Outlets')+ $this->Constant_model->getddData('outlets','id','name', 'id');
                                                            echo sel_element($outlets,$url_outlet,'Outlet ','outlet_id','Choose Outlet ',1);
                                                    } else { 
                                                    ?>    
                                                    <div class="form-group">
                                                            <label>Outlet: </label>
                                                         <input type="text" class="form-control form-control-solid placeholder-no-fix" value="<?php echo $outlets[$user_outlet];?>" readonly />
                                                            <input type="hidden" name="outlet_id" id="outlet_id" value ="<?PHP echo $user_outlet;?>" />
                                                    </div>
                                                    <?php }   ?>
                                            
                            </div>
                            <div class="col-md-4">
                                <?php
                                
                                 echo sel_element($dd_sps, $sales_person_id, 'Select Sales Person', 'sales_person_id', 'Choose Sales Person', '', 1);
                                ?>
                            </div>
                            <div class="col-md-4">
                                <?php
 
                                 echo sel_element(array('morning'=>'Morning','evening'=>'Evening'), $session=0, 'Select Session', 'session', 'Choose Session');
                                ?>
                            </div>
                            </div> 
                         <div class="row">
                             <div class="col-md-4">
                                <?php
                                    $cid = $this->Constant_model->getSingle('category','id','name="'.NONINVENTORYITEMS.'"');

                                    $products =  array('='=>'All Products')+$this->Constant_model->getddData('products','code','name', 'id','category='.$cid);

                                 echo sel_element($products, $product_id=0, 'Select Product', 'product_id', 'Choose Product');
                                ?>
                            </div>
                        
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="text" name="start_date" class="form-control" id="startDate"   value="<?php echo $url_start; ?>" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input required type="text" required name="end_date" class="form-control" id="endDate"   value="<?php echo $url_end; ?>" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label><br />
                                    <input type="hidden" name="report" value="1" />
                                    <input type="submit" class="btn btn-primary" value="Get Report" />
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php
                    if (isset($_GET['report'])) {
                        
                        ?>
                    <div class="row" style="margin-top: 10px;margin-bototm:5%">
                            <div class="col-md-12" style="text-align: right;">
                                <a href="<?= base_url() ?>reports/exportIssueSaleReport?report=<?php echo $_GET['report']; ?>&start_date=<?php echo $url_start; ?>&end_date=<?php echo $url_end; ?>&outlet=<?php echo $url_outlet; ?>&sales_person_id=<?php echo $sales_person_id; ?>&session=<?php echo $session; ?>&product_id=<?php echo $product_id; ?>" style="text-decoration: none">
                                    <button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
                                        Export to Excel
                                    </button>
                                </a>
                            </div>
                        </div>
                         <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">

                                        <div class="table-responsive">
                            <table class="table">
                                    <thead>
                                            <tr>
                                            <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="13%">Date & Time</th>
                                            <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="7%">Session</th>
                                            <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Outlet</th>
                                                <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Sales Person</th>
                                                <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">Sold Amount</th>
                                                <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">Short Amount</th>
                                            <?php  if ($user_role == 1) {?>

<!--                                                                                    <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd; border-right: 1px solid #ddd;">Action</th>-->
                                            <?php } ?>
                                            </tr>
                                    </thead>
                                    <tbody>
									<?php
                                        if (count($results) > 0) {
                                            
                                              $tsold_amount=0;
                                              $tshort_amount=0;
                                            foreach ($results as $data) {
                                                $id = $data->id;
                                                $transfer_date = $data->sale_datetime;
                                                $session = ucfirst($data->session);
                                                $sales_person_id = $data->sales_person_id;
                                                $sold_amount = ci_format_number($data->grandtotal);
                                                $short_amount = ci_format_number($data->short_amount);
                                                $tsold_amount+= $sold_amount;
                                                $tshort_amount+= $short_amount;
                                                $outlet_id = $data->outlet_id;
                                                
                                                
                                                ?>
                                                                        <tr>
                                                                                 <td style="border-bottom: 1px solid #ddd;">
                                                                                <?php
                                                                                        if (empty($transfer_date)) {
                                                                                            echo '-';
                                                                                        } else {
                                                                                            echo $transfer_date;
                                                                                        } ?>	
                                                                                </td>
                                                                                <td style="border-bottom: 1px solid #ddd;">
                                                                                <?php
                                                                                        if (empty($session)) {
                                                                                            echo '-';
                                                                                        } else {
                                                                                            echo $session;
                                                                                        } ?>	
                                                                                </td>
                                                                                
                                                                                <td style="border-bottom: 1px solid #ddd;">
                                                                                <?php
                                                                                        if (empty($outlet_id)) {
                                                                                            echo '-';
                                                                                        } else {
                                                                                            echo $outlet[$outlet_id];
                                                                                        }
                                                                                ?>
                                                                                </td>
                                                                                <td style="border-bottom: 1px solid #ddd;">
                                                                                <?php
                                                                                        if (empty($sales_person_id)) {
                                                                                            echo '-';
                                                                                        } else {
                                                                                            echo $sales_person[$sales_person_id];
                                                                                        } ?>	
                                                                                </td>
                                                                                <td style="border-bottom: 1px solid #ddd;"><?php
                                                                                         
                                                                                            if (empty($sold_amount)) {
                                                                                            echo '-';
                                                                                        } else {echo $sold_amount;}
                                                                                         ?>
                                                                                </td>
                                                                                <td style="border-bottom: 1px solid #ddd;"><?php
                                                                                        if (empty($short_amount)) {
                                                                                            echo '-';
                                                                                        } else {
                                                                                            echo $short_amount;
                                                                                        } ?>
                                                                                </td>
                                                                            <?php  if ($user_role == 1) {?>

<!--                                                                                <td style="border-bottom: 1px solid #ddd;">
                                                                                    <a href="<?php echo base_url()?>bank_dt/editBdt?id=<?php echo $id; ?>" style="text-decoration: none;">
                                                                                            <button class="btn btn-primary" style="padding: 4px 12px;">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
                                                                                    </a>
 
                                                                                </td>-->
                                                                            <?php } ?>
                                                                        </tr>
									<?php

                                            }?>
                                                                        <tr>
                                                                            <td colspan="5" style="text-align: right;"><label>Total Sold Amount:</label>&nbsp;<?php echo ci_format_number($tsold_amount);?></td>
                                                                            <td style="text-align: right;"><label>Total Short Amount:</label>&nbsp;<?php echo ci_format_number($tshort_amount);?></td>
                                                                        </tr>
                                        <?php } else {
                                            ?>
											<tr>
												<td colspan="4">No matching records found</td>
											</tr>
									<?php

                                        }
                                    ?>
									</tbody>
                                                                        
								</table>
                                    </div>
							
                            </div>
                            </div>
					
                        <div class="row">
                                <div class="col-md-6" style="float: left; padding-top: 10px;">
                                        <?php echo $displayshowingentries; ?>
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                        <?php echo $links; ?>
                                </div>
                        </div>
   
                    <?php }?>



                    </div><!-- Panel Body // END -->
                </div><!-- Panel Default // END -->



            </div><!-- Col md 12 // END -->
        </div><!-- Row // END -->





        <br /><br /><br />

    </div><!-- Right Colmn // END -->

   
<?php
require_once 'includes/footer.php';
?>