<?php
    require_once 'includes/header.php';
?>
<script>
	$( function() {
		$( "#startDate" ).datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});

		$("#endDate").datepicker({
			format: "<?php echo $dateformat; ?>",
			autoclose: true
		});
	});
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Purchase Bills Report</h1>
		</div>
	</div>

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
					<?php	}
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
					<?php  }
                        }
                    ?>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
							   <table class="table" id="datatable">
									<thead>
										<tr>
											<th style="display: none;" >id</th>
											<th style="text-align: left;" width="15%">Date & Time</th>
											<th style="text-align: left;" width="15%">Purchase Order Number</th>
											<th style="text-align: left;" width="12%">Outlet</th>
											<th style="text-align: left;" width="10%">Supplier</th>
											<th style="text-align: left;" width="10%">Payment Type</th>
											<th style="text-align: left;" width="10%">Paid Amount</th>
											<th style="text-align: left;" width="10%">Total Amount</th>
											<th style="text-align: left;" width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									foreach ($bill_data as  $value) { ?>
									<tr>
										<td style="display: none"> <?php echo $value->id; ?> </td>
										<td> <?php echo $value->paid_date; ?> </td>
										<td> <?php echo $value->po_number; ?> </td>
										<td> <?php echo $value->outlet_name; ?> </td>
										<td> <?php echo $value->supplier_name; ?> </td>
										<td> <?php echo $value->payment_name; ?> </td>
										<td> <?php echo !empty($value->paid_amt)?number_format($value->paid_amt,2):0; ?> </td>
										<td> <?php echo !empty($value->grandtotal)?number_format($value->grandtotal,2):0; ?> </td>
										<td>

											<button class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $value->id; ?>">View</button>
											<div id="myModal<?php echo $value->id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Purchase Bill Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Date & Time</b>
																</div>
																<div class="col-md-8">
																	<?=$value->paid_date;?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Purchase Order Number</b>
																</div>
																<div class="col-md-8">
																	<?=$value->po_number?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Outlet</b>
																</div>
																<div class="col-md-8">
																	<?=$value->outlet_name;?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Supplier</b>
																</div>
																<div class="col-md-8">
																	<?=$value->supplier_name;?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Payment Type</b>
																</div>
																<div class="col-md-8">
																	<?php
																	echo $value->payment_name;
																	if($value->payment_method == 5)
																	{
																		echo ' (Cheque Number: '.$value->cheque_number.')';
																	}
																	?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Paid Amount</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($value->paid_amt)?number_format($value->paid_amt,2):0?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Total Amount</b>
																</div>
																<div class="col-md-8">
																	<?=!empty($value->grandtotal)?number_format($value->grandtotal,2):0?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Due Amount</b>
																</div>
																<div class="col-md-8">
																	<?php
																	$finaltotal = $value->grandtotal - $value->paid_amt;
																	echo !empty($finaltotal)?number_format($finaltotal,2):0;
																	?>
																	
																</div>
															</div>
															<hr>
															<h3 style="padding-left: 0px;">Purchase Order Detail</h3>
															<div class="row">
																<table class="table">
																	<thead>
																		<tr>
																			<td>Product Name</td>
																			<td>Product Code</td>
																			<td>Qty</td>
																			<td>Price</td>
																			<td>Total</td>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																			$purchase_item = $this->Purchaseorder_model->purchase_Item_data($value->purchase_id);
																			foreach ($purchase_item as $item)
																			{
																		?>
																		<tr>
																			<td><?=$item->productname?></td>
																			<td><?=$item->product_code?></td>
																			<td><?=!empty($item->ordered_qty)?number_format($item->ordered_qty,2):0?></td>
																			<td><?=!empty($item->cost)?number_format($item->cost,2):0?></td>
																			<td><?=!empty($item->subTotal)?number_format($item->subTotal,2):0?></td>
																		</tr>
																			<?php }
																			?>
																	</tbody>
																</table>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
										</td>
									</tr>
									<?php }    ?>
									</tbody>
									<tfoot>
										<tr>
											<th style="display: none"></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
									</tfoot>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br /><br /><br />
</div>

<script>
$(document).ready(function(){
	$("#datatable").DataTable({
				dom: "Bfrtip",
                "bPaginate": true,ordering: true,"pageLength":15,
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
						exportOptions:{columns:[0,1,2,3,4,5,6]},
					},
					{
						extend: "pageLength",
					},
                  ],
				  order:[0,'desc'],
                  responsive: true,
                  drawCallback: function () {
                  var api = this.api();
                  $( api.table().column(6).footer() ).html(
						api.column( 6, {page:'current'} ).data().sum()+" (LKR)"
					);
                  }
			});
	});
</script>


<?php
    require_once 'includes/footer.php';
?>