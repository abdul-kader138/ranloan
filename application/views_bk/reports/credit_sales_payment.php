<?php
$this->load->view('includes/header');
?>

<script type="text/javascript">
   function openReceiptDetail(ele){
   	var myWindow = window.open(ele, "", "width=650, height=650");
   }	
</script>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Outstanding Received</h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate"   value="<?=!empty($this->input->get('start_date')) ? $this->input->get('start_date') : ''?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate"   value="<?=!empty($this->input->get('end_date')) ? $this->input->get('end_date') : ''?>" />
								</div>
							</div>


							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br />
									<button class="btn btn-primary" style="width: 100%;">Get Report</button>
								</div>
							</div>
						</div>
					</form>

					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th>Payment Form No.</th>
											<th>Date</th>
											<th>Outlet</th>
											<th>Customer</th>
											<th>Paid Amt</th>
											<th>Credit Limit Code</th>
											<th>View</th>
										</tr>
									</thead>
									
									<tbody>
									<?php
									
									$total_unpaid_amt = 0;
									$total_client = 0;
									
									foreach ($results as $data)
									{
											$total_client = $total_client + 1;
                                            $id = $data->id;
                                            $cust_name = $data->customer_name;
                                            $order_date = $data->ordered_datetime;
                                            $outlet_name = $data->outletname;
                                            $grandTotal = $data->grandtotal;
                                            $paid_amt = $data->paid_amt;
										    $unpaid_amt = 0;
                                            $unpaid_amt = $paid_amt - $grandTotal; 
											$out_unpaid_amt = $grandTotal - $paid_amt; 
											$outstanding = $grandTotal - $paid_amt; 
											$total_unpaid_amt = $total_unpaid_amt + $out_unpaid_amt;
										?>
										<tr>
										<td><?php echo $id; ?></td>
										<td><?php echo $order_date; ?></td>
										<td><?php echo $outlet_name; ?></td>
										<td><?php echo $cust_name; ?></td>
										<td><?php echo !empty($paid_amt)?number_format($paid_amt, 2):0; ?></td>
										<td>
													<?php
														$creditlimit = $data->credit_amount;
														if($creditlimit != 0 && $outstanding != 0)
														{
															$percenttage = ($outstanding * 100) / $creditlimit;
															foreach ($getCreditColor as $color)
															{
																if($color->to > $percenttage && $color->from < $percenttage )
																{ ?>
																	<button class="btn" style="background: #<?=$color->color?>">&nbsp;</button>
																	<?php 
																}
																else if($percenttage > 100)
																{ ?>
																	<button class="btn" style="background: #cc0000">&nbsp;</button>
																<?php 
																	break;
																}
															}
														}
														?>
												</td>
												<td>
													<a class="btn btn-primary" onclick="openReceiptDetail('<?=base_url()?>reports/outstanding_received_detail?id=<?php echo $id ?>')" style="text-decoration: none; cursor: pointer; border: none;" title="View Detail">
														Detail
													</a>
												</td>
										</tr>
										
								<?php	}
									?>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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
        });
    });
</script>
<?php
$this->load->view('includes/header_notification');
$this->load->view('includes/footer');
?>
