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
   
   function openReceiptDetail(ele){
		window.open(ele, "", "width=1300%, height=900");
   }	
	function openReceiptPrint(ele){
		window.open(ele, "", "width=400, height=600");
	}
	function openReceiptPrinta4(ele){
		window.open(ele, "", "width=1000, height=600");
	}
   
   
   
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-8">
			<h1 class="page-header">Search Work Order</h1>
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
					
					
					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-3">
								<div class="form-group">
									<label>Start Date </label>
									<input type="text" name="start_date" id="startDate" class="form-control" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>"/>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>End Date </label>
									<input type="text" name="end_date" id="endDate" class="form-control" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>"/>
								</div>
							</div>
				
							<div class="col-md-2"  style="margin-top: 2%">
								<div class="form-group">
									<input id="btnSearch" style="display:block;" type="submit" name="submit" value="Search Work Order" class="btn btn-primary uppercase">					
								</div>
							</div>
						</div>
					</form>
					
					<div class="row">
						<div class="col-md-6"style="text-align: right;"></div>
 						<div class="col-md-6"style="text-align: right;">
							<a href="<?=base_url()?>Productions/add_work_job_order" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Create Work Order
								</button>
							</a>
						</div>
						
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
							<div class="table-responsive">
								<table class="table" id="datatable">
									<thead>
										<tr>
									    	<th>Date & Time</th>
									    	<th>Outlet</th>
									    	<th>Work order No</th>
									    	<th>Customer Order No</th>
									    	<th>Goldsmith</th>
									    	<th>Received Work Order No.</th>
									    	<th>Order Deliver Date</th>
									    	<th>Action</th>
                                     	</tr>
									</thead>
									<tbody>
								<?php 
								foreach($work_job_order as $view_job):
								?>
								<tr>
									<td><?php  echo $view_job->create_date; ?></td>
									<td><?php  echo $view_job->outlets_name; ?></td>
									<td><?php  echo $view_job->job_order_no; ?></td>
									<td><?php  echo $view_job->customer_order_no; ?></td>
									<td><?php  echo $view_job->gold_smith_name; ?></td>
									<td></td>
									<td><?php  echo $view_job->order_delivery_date; ?></td>
									
								<td><button class="btn btn-primary" style="padding: 4px 12px; width: 80px;" data-toggle="modal" data-target="#myModal<?=$view_job->id?>">Action</button>
									<div id="myModal<?=$view_job->id?>" class="modal fade" role="dialog">
											   <div class="modal-dialog">
												   <div class="modal-content">
													   <div class="modal-header">
														   <button type="button" class="close" data-dismiss="modal">&times;</button>
														   <h4 class="modal-title">Choose Your Action</h4>
													   </div>
													   <div class="modal-body">
														   <ul style="list-style-type:none; text-align:center;">
																
															   
															   <li style="padding: 1%;">
																	<a class="btn btn-primary"  onclick="openReceiptPrint('<?=base_url()?>productions/print_invoice_work_job?id=<?php echo $view_job->id; ?>')" style="text-decoration: none; cursor: pointer; border: none;width: 22%;" title="View Detail">
																		Normal Print
																	</a>
															   </li>
															    <li style="padding: 1%;">
																	<a class="btn btn-primary"  onclick="openReceiptPrinta4('<?=base_url()?>Productions/print_invoice_work_joba4?id=<?php echo $view_job->id; ?>')" style="text-decoration: none; cursor: pointer; border: none;width: 22%;" title="View Detail">
																		A4 Print
																	</a>
															   </li>
															   
															   <li style="padding: 1%;">
																	<a class="btn btn-primary" onclick="openReceiptDetail('<?=base_url()?>productions/work_job_view_detail?id=<?php echo $view_job->id; ?>')" style="text-decoration: none; cursor: pointer; border: none;width: 22%;" title="View Detail">
																		Detail
																	</a>
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
	
	
 <script type="text/javascript">
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
		});
	});
</script>