 

<script type="text/javascript">
	function openReceiptDetail(ele) {
		var myWindow = window.open(ele, "", "width=400, height=500");
	}
</script>


 <style type="text/css">
          table{
            table-layout: fixed;
          }
          td
          {
            word-wrap: break-word;
          }
        </style>

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
			<h1 class="page-header">All Goldsmith</h1>
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
							<a href="<?=base_url()?>Goldsmith/addGoldsmith" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Add Goldsmith
								</button>
							</a>
						</div>
						<div class="col-md-offset-4 col-md-2" style="text-align: right;">				
						
<!--						<button type="button" class="btn btn-success pull-right " id="csv" style="background-color: #5cb85c; width: 100%;border-color: #4cae4c;">
                                    Export Excel
                                </button>-->
						
					<!--	<a href="#" style="text-decoration: none">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									Export to Excel
								</button>
							</a>-->
						</div>
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
						<style type="text/css">
          table{
            table-layout: fixed;
          }
          td
          {
            word-wrap: break-word;
          }</style>
							
							<div class="table-responsive">
									<table id="datatable" class="table" cellspacing="0" width="100%">	
									<thead>
										<tr><th width="4%">#</th>
									    	<th width="12%">Name</th>
									    	<th width="12%">Email</th>
									    	<th width="12%">Phone</th>
									    	<th width="12%">Land Phone Number</th>
										    <th width="12%">Employee No</th>
										    <th width="12%">Opening Qty</th>
											<th width="12%">Action</th>
										</tr>
									</thead>
									<tbody>
								<?php 
								foreach($goldsmith as $product):
								?>
								<tr>
								<td><?php  echo $product->gs_id; ?></td>
								<td><?php  echo $product->fullname; ?></td>
								<td><?php  echo $product->email; ?></td>
								<td><?php  echo $product->phone; ?></td>
								<td><?php  echo $product->land_phone_number; ?></td>
<!--								<td><?php  echo $product->gold_smith_num; ?></td>-->
								<td><?php  echo $product->emp_no; ?></td>
								<td><?php  echo !empty($product->opening_gold_qty)?number_format($product->opening_gold_qty,2):'0.00'; ?></td>
								<td>	
									<button class="btn btn-primary" style="padding: 4px 12px; width: 80px;" data-toggle="modal" data-target="#myModal<?=$product->gs_id?>">Action</button>
									<div id="myModal<?=$product->gs_id?>" class="modal fade" role="dialog">
									   <div class="modal-dialog">
										   <div class="modal-content">
											   <div class="modal-header">
												   <button type="button" class="close" data-dismiss="modal">&times;</button>
												   <h4 class="modal-title">Choose Your Action</h4>
											   </div>
											   <div class="modal-body">
												   <ul style="list-style-type:none; text-align:center;">
													   <li style="padding-bottom: 1%;">
															<a class="btn btn-primary" href="<?= base_url() ?>Goldsmith/editGoldsmith?id=<?php echo $product->gs_id; ?>" style="padding: 6px 33px;"  title="Edit Detail"> Edit </a>
														</li>
														<li style="padding-bottom: 1%;">
															<a class="btn btn-primary" onclick="openReceiptDetail('<?= base_url() ?>Gold/gold_smith_details?id=<?php echo $product->gs_id; ?>')" style="padding: 6px 30px;"  title="View Detail"> View </a>
														</li>
												   </ul>

											   </div>
											   <div class="modal-footer">
												   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											   </div>
										   </div>
									   </div>
									</div>
								</td>


								</tr>
								
								<?php 
								endforeach;

								 ?>
								</tbody>
									<tfoot>
										<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											
										</tr>
									</tfoot>
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
	
               <script>
	$("#csv").click(function(){
$(".btnExport").tableExport({
type:'excel',
escape:false,
}); 
});
</script>
 <script>
    $(document).ready(function () {

        $("#datatable").DataTable({
            dom: "Bfrtip",
            "bPaginate": true, ordering: true, "pageLength": 15,
            buttons: [
                {
                    extend: "copy",
                    className: "change btn-primary "
                },
                {
                    extend: "csv",
                    className: " change btn-primary"
                },
                {
                    extend: "excel",
                    className: "change btn-primary"
                },
                {
                    extend: "print",
                },
                {
                    extend: "pageLength",
                },
            ],
			order:[0,"desc"],
            responsive: true,
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api(), data;
				$( api.table().column(6).footer() ).html("<strong>"+addCommas(api.column( 6, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
//				$( api.table().column(7).footer() ).html("<strong>"+addCommas(api.column( 7, {page:'current'} ).data().sum().toFixed(2))+"(24 kt) </strong>");
			}
        });
    });
</script>