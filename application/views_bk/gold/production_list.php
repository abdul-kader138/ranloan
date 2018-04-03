<!-- 
<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery-1.12.3.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.js"></script>
<link href="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">-->
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
			<h1 class="page-header">All Production</h1>
		</div>
	</div><!--/.row-->

<script type="text/javascript">
	function openReceipt(ele){
		var myWindow = window.open(ele, "", "width=380, height=550");
	}	
</script>
	
	
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
							<a href="<?=base_url()?>Productions/add_production" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Add Production
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
									    	<th width="8%">Reference</th>
									    	<th width="8%">Goldsmith</th>
									    	<th width="5%">Qty</th>
										<th width="10%">Warehouse</th>
									    	<th width="8%">Outlet</th>
										<th width="8%">Wastage</th>
										<th width="7%">Total product</th>
										<th width="9%">Otherweight</th>
										<th width="9%">Auto calculation</th>
										<th width="9%">Total gold wast </th>
										<th width="9%">Goldsmith Was</th>
                                                                                <th width="12%">Other Cost</th>

										    
										</tr>
									</thead>
									<tbody>
<?php 
foreach($production as $product):
?>
<tr>
<td><?php  echo $product->date_created; ?></td>
<td><?php  echo $product->pro_reference; ?></td>
<td><?php  echo $product->fullname; ?></td>
<td><?php  echo $product->pro_qty; ?></td>
<td><?php  echo $product->s_name; ?></td>
<td><?php  echo $product->name; ?></td>
<td><?php echo $product->pro_wastage; ?></td>
<td><?php echo $product->pro_total_product; ?></td>
<td><?php echo $product->pro_otherweight; ?></td>
<td><?php echo $product->pro_wastage_cal; ?></td>
<td><?php echo $product->pro_total_gold_wastage; ?></td>
<td><?php echo $product->pro_goldsmith_was; ?></td>
<td>
<?php 
$c=0;
foreach($others as $other){
if($other->pro_reference_id !=$product->pro_reference ){
continue;
}
$c=1;
?>

<?php echo $other->other_name."\t \t"; ?> <?php echo $other->other_cost."<br>"; ?>
<?php } if($c==0){ echo "No cost Added";  } ?>
</td>
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
	
	
 