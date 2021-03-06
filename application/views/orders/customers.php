<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Customers</h1>
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
						<div class="col-md-6">
							<a href="<?=base_url()?>Gold/addCustomer" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Add Customer
								</button>
							</a>
						</div>
                                            <?php                          if ($user_role < 3) {
?>
						<div class="col-md-6" style="text-align: right;">
							<a href="<?=base_url()?>Gold/exportCustomer" style="text-decoration: none;">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									Export
								</button>
							</a>
						</div>
                                            <?php } ?>
					</div>
					<?php

                        }
                    ?>
					
					<form action="<?=base_url()?>Gold/searchcustomer" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-4">
								<div class="form-group">
									<label>Name </label>
									<input type="text" name="name" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Email </label>
									<input type="text" name="email" class="form-control" />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Mobile </label>
									<input type="text" name="mobile" class="form-control" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<button class="btn btn-primary" style="width: 100%;">&nbsp;&nbsp;Search&nbsp;&nbsp;</button>
								</div>
							</div>
						</div>
					</form>
					
					
					
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
									    	<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="26%">Customer Name</th>
									    	<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="16%">Email</th>
										    <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Mobile</th>
                                                                                    <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Deposit</th>

										    <th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd; border-right: 1px solid #ddd;" width="35%">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
                                        if (count($results) > 0) {
                                            foreach ($results as $data) {
                                                $cust_id = $data->id;
                                                $cust_fn = $data->fullname;
                                                $cust_em = $data->email;
                                                $cust_mb = $data->mobile; ?>
												<tr>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $cust_fn; ?></td>
													<td style="border-bottom: 1px solid #ddd;">
													<?php
                                                                                                                if (empty($cust_em)) {
                                                                                                                    echo '-';
                                                                                                                } else {
                                                                                                                    echo $cust_em;
                                                                                                                } ?>	
													</td>
													<td style="border-bottom: 1px solid #ddd;">
													<?php
                                                                                                                if (empty($cust_mb)) {
                                                                                                                    echo '-';
                                                                                                                } else {
                                                                                                                    echo $cust_mb;
                                                                                                                } ?>
													</td>
                                                                                                        <td style="border-bottom: 1px solid #ddd;"><?php echo (array_key_exists($cust_id, $deposits))? ci_format_number($deposits[$cust_id]):'-';?></td>
													<td style="border-bottom: 1px solid #ddd;">
								<a href="<?=base_url()?>Gold/edit_customer?cust_id=<?php echo $cust_id; ?>" style="text-decoration: none;">
									<button class="btn btn-primary" style="padding: 4px 12px;">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
								</a>
								
								<a href="<?=base_url()?>Gold/customer_history?cust_id=<?php echo $cust_id; ?>" style="text-decoration: none; margin-left: 10px;">
									<button class="btn btn-primary" style="padding: 4px 12px;">&nbsp;&nbsp;Sales History&nbsp;&nbsp;</button>
								</a>
                                                                <a href="<?=base_url()?>Gold/prepay?customer_id=<?php echo $cust_id; ?>" style="text-decoration: none; margin-left: 10px;">
									<button class="btn btn-primary" style="padding: 4px 12px;">Pre Payments</button>
								</a>
													</td>
												</tr>
									<?php

                                            }
                                        } else {
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
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
	
<?php
require_once $app.'/views/includes/footer.php';
?>