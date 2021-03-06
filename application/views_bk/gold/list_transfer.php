 
<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery-1.12.3.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">
 <style type="text/css">
          table{
            table-layout: fixed;
          }
          td
          {
            word-wrap: break-word;
          }
        </style>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#example').DataTable();
	} );
</script>
<?PHP
 $settingResult = $this->db->get_where('site_setting');
    $settingData = $settingResult->row();
     $new_sys_settings=array();
    if($settingData->new_settings !='')
    $new_sys_settings = json_decode($settingData->new_settings,true);

?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">List Transfer</h1>
		</div>
	</div><!--/.row-->

<script type="text/javascript">
	function openReceipt(ele){
		var myWindow = window.open(ele, "", "width=380, height=550");
	}	
</script>
	
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
 						<div class="col-md-6">
							<a href="<?=base_url()?>Gold/add_transfer" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Add Transfer
								</button>
							</a>
						</div>
						<div class="col-md-6" style="text-align: right;">							<a href="<?=base_url()?>sales/exportSales" style="text-decoration: none">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									Export to Excel
								</button>
							</a>
						</div>
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
							<div class="table-responsive">
								<table id="example" class="display" cellspacing="0" width="100%">
									<thead>
										<tr>
									    	<th width="7%">Date</th>
									    	<th width="8%">RJO No</th>
									    	<th width="8%">Grade</th>
									    	<th width="5%">Profit %</th>
										<th width="10%">Weight</th>
									    	<th width="8%">Stone</th>
										<th width="8%">Total Weight</th>
										<th width="7%">Stone Cost</th>
										<th width="9%">Otherweight</th>
										<th width="9%">Day Price</th>
										<th width="9%">Profit Calculation </th>
										<th width="9%">Minimum</th>
										<th width="9%">Note</th>


										    
										</tr>
									</thead>
									<tbody>
<?php 
foreach($transfer as $trans):
?>
<tr>
<td><?php  echo $trans->t_date_creation; ?></td>
<td><?php  echo $trans->rjo; ?></td>
<td><?php  echo $trans->trans_grade; ?></td>
<td><?php  echo $trans->trans_profit; ?></td>
<td><?php  echo $trans->trans_weight; ?></td>
<td><?php  echo $trans->trans_stone; ?></td>
<td><?php echo $trans->trans_total_weight; ?></td>
<td><?php echo $trans->trans_stonecost; ?></td>
<td><?php echo $trans->trans_totalother; ?></td>
<td><?php echo $trans->trans_day_price; ?></td>
<td><?php echo $trans->trans_grade_; ?></td>
<td><?php echo $trans->trans_grade_minimum; ?></td>
<td><?php echo $trans->trans_note; ?></td>

</tr>
<?php 
endforeach;

 ?>
 



									</tbody>
								</table>
							</div>
							
						</div>
					</div>
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
 