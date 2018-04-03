<?php
	require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Expiry Details</h1>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">

					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">

							<div class="table-responsive">
								<table class="table" id="datatable">
									<thead>
										<tr>
											<th>Code</th>
											<th>Product Name</th>
											<th>Generic Name</th>
											<th>Outlet</th>
											<th>Store</th>
											<th>Batch Number</th>
											<th>Expire Date</th>

										</tr>
									</thead>
									
									<tbody>
										<?php
										$today_date = date('Y-m-d');
										$yellow = 90;
										$ash = 30;
										$red = 7;
										$Display = 0;
										
										foreach ($expireDetail as $valuee)
										{
											
											$date1 = date_create($today_date);
											$date2 = date_create($valuee->expirydate);
											$diff = date_diff($date1, $date2);
											$days = $diff->format("%a");
											
											if ($today_date < $expire_date) {
										if ($days <= $yellow AND $days > $ash) {
										?>
										<tr style="background-color:yellow"> 
											<td><?=$valuee->product_code?></td>
											<td><?=$valuee->product_name?></td>
											<td><?=$valuee->generic_name?></td>
											<td><?=$valuee->outletname?></td>
											<td>
												<?php
												if($valuee->category == 20)
												{
													echo $this->Inventory_model->getConcateFuelTanK($valuee->ow_id);
												}
												else
												{
													echo $this->Inventory_model->getConcateStore($valuee->ow_id);
												}
												?>
											</td>
											<td><?=$valuee->batch_no?></td>
											<td><?=$valuee->expirydate?></td>
										</tr> 
										<?php 
										} else if ($days <= $ash AND $days > $red) {
										?>
										<tr style="background-color:#b2beb5">
											<td><?=$valuee->product_code?></td>
											<td><?=$valuee->product_name?></td>
											<td><?=$valuee->generic_name?></td>
											<td><?=$valuee->outletname?></td>
											<td>
												<?php
												if($valuee->category == 20)
												{
													echo $this->Inventory_model->getConcateFuelTanK($valuee->ow_id);
												}
												else
												{
													echo $this->Inventory_model->getConcateStore($valuee->ow_id);
												}
												?>
											</td>
											<td><?=$valuee->batch_no?></td>
											<td><?=$valuee->expirydate?></td>
										</tr> 
										<?php
										} else if ($days <= $red) {
										?>
											<tr style="background-color:red">
											<td><?=$valuee->product_code?></td>
											<td><?=$valuee->product_name?></td>
											<td><?=$valuee->generic_name?></td>
											<td><?=$valuee->outletname?></td>
											<td>
												<?php
												if($valuee->category == 20)
												{
													echo $this->Inventory_model->getConcateFuelTanK($valuee->ow_id);
												}
												else
												{
													echo $this->Inventory_model->getConcateStore($valuee->ow_id);
												}
												?>
											</td>
											<td><?=$valuee->batch_no?></td>
											<td><?=$valuee->expirydate?></td>
										</tr> 
										
										<?php } 
											}
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
<!--star new-->
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
                    className: "change btn-primary",
                    exportOptions: {columns: [0, 1, 2, 4, 5, 6, 7, 8, 9]},
                },
            ],
           
        });




    });

</script>
<!--end new-->
<?php
require_once 'includes/footer.php';
?>