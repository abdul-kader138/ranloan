<?php
	$app = realpath(APPPATH);
	require_once $app . '/views/includes/header.php';
?>
<style>
    
    .dt-button{ background-color:#5fc509 !important; }
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Staff </h1>
		</div>
	</div><!--/.row-->

	
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
					
					<?php
                        if ($user_role < 4) {
                            ?>
					<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
						<div class="col-md-2">
							<a href="<?=base_url()?>staff/addStaff" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Add Staff
								</button>
							</a>
						</div>
<!--						<div class="col-md-4">
							<a href="<?=base_url()?>staff/adddivision" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Add Division
								</button>
							</a>
						</div>					-->
					</div>
					<?php

                        }
                    ?>
					
					<div class="row" style="margin-top: 19px;">
						<div class="col-md-12">
							
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th style="display: none;" >id</th>
											<th>Image</th>
											<th>Staff Name</th>
											<th>Staff Code</th>
											<th>Staff Nic</th>
											<th>Staff Mobile</th>
											<th>Outlet</th>
											<th>Balance Points</th>
											<th>Created Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
							<?php
								foreach ($results as $data) {
										$cust_id = $data->id;
										
										$cust_outlet = $data->assign_outlet_name;
								 ?>
							<tr>
								<td style="display: none;"><?=$cust_id;?></td>
								<td><img style="height: 50px; width: 50px;" src="<?=base_url()?>assets/upload/staff/<?=$data->thumbnail?>"></td>
								<td><?php echo !empty($data->staff_name)?$data->staff_name:''; ?></td>
								<td><?php echo !empty($data->staff_code)?$data->staff_code:''; ?></td>
								<td><?php echo !empty($data->staff_cni)?$data->staff_cni:''; ?></td>
								<td><?php echo !empty($data->staff_mobile)?$data->staff_mobile:''; ?></td>
								<td><?php echo !empty($cust_outlet)?$cust_outlet:''; ?></td>
								<td><?php echo !empty($data->point_percentage)?$data->point_percentage:'0.00'; ?></td>
								<td><?php echo !empty($data->date_cre)?$data->date_cre:''; ?></td>
								<td>
									<button class="btn btn-primary" style="padding: 4px 12px;" data-toggle="modal" data-target="#myModal1<?php echo $cust_id; ?>">&nbsp;&nbsp;Action&nbsp;&nbsp;</button>
								</td>
							</tr>
												<!-- Modal -->
                                                <div id="myModal1<?php echo $cust_id; ?>" class="modal fade" role="dialog">
                                                  <div class="modal-dialog">
                                                
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Choose Your Action</h4>
                                                      </div>
                                                      <div class="modal-body">
                                                    <ul style="list-style-type:none; text-align:center;">
                                                        <li>
                                                        <a href="<?=base_url()?>staff/edit_staff?id=<?php echo $cust_id; ?>" style="text-decoration: none; width:100px;">
                        									<button class="btn btn-primary" style="padding: 4px 12px; width:160px; margin-bottom:6px;">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
                        								</a>
                        								</li>
<!--                        								<li>
                        								<a href="<?=base_url()?>staff/staff_history?id=<?php echo $cust_id; ?>" style="text-decoration: none; ">
                        									<button class="btn btn-primary" style="padding: 4px 12px;width:160px; margin-bottom:6px;">&nbsp;&nbsp;Sales History&nbsp;&nbsp;</button>
                        								</a>
														</li>
                                                         <li>
                        								 <a href="#" style="text-decoration: none;">
                        									<button class="btn btn-primary" style="padding: 4px 12px;width:230px; margin-bottom:6px;">&nbsp;&nbsp;Total Sales Points Earned&nbsp;&nbsp;</button>
                        								</a></li>
														<li>
                        								 <a href="#" style="text-decoration: none;">
                        									<button class="btn btn-primary" style="padding: 4px 12px;width:230px; margin-bottom:6px;">&nbsp;&nbsp;Total Sales Points Reimbursed&nbsp;&nbsp;</button>
                        								</a></li>-->
                        								</ul>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                      </div>
                                                    </div>
                                                
                                                  </div>
                                                </div>
											<?php
											}	
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
	
<script>
	 $(document).ready(function() {
	 	
	 	$("#datatable").DataTable({
	              dom: "Bfrtip",
	              "bPaginate": false,ordering: true,"pageLength":10,
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
	              responsive: true,

			   });
	        
	      });

</script>	
	

<?php
$app = realpath(APPPATH);

require_once $app . '/views/includes/footer.php';

?>