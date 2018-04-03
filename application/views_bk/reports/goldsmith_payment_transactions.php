<?php
//require_once '../includes/header.php';
$this->load->view('includes/header');
?>
<style>
	div#example_filter {
		display: none;
	}

	div#example_length {
		display: none;
	}
</style>
<script type="text/javascript">
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
<script type="text/javascript">
	function openReceipt(ele) {
		var myWindow = window.open(ele, "", "width=380, height=550");
	}
</script>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Goldsmith Payment Transactions</h1>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row" style="padding-bottom: 8px;">
						<div class="col-md-12">
							<div class="col-md-6">
							

							</div>

						</div>

					</div>

					<form action="<?= base_url() ?>reports/product_report" method="get">
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Outlet</label>
									 <select name="outlet" required="" class="form-control">
										<?php
										 foreach ($getOutlet as $outlet)
										 { 
											 $selected = '';
											 if(!empty($this->input->get('outlet'))) 
											 {
												 if($this->input->get('outlet') == $outlet->id)
												 {
													 $selected = 'selected';
												 }
											 }
											 ?>
											<option <?=$selected?> value="<?=$outlet->id?>"><?=$outlet->name?></option>
									 <?php }
										?>
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" required=""  name="start_date" class="form-control" id="startDate" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control"id="endDate" required="" value=""/>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<label>&nbsp;</label><br/>
									<input type="hidden" name="report" value="1"/>
									<input type="submit" class="btn btn-primary" value="Search"/>
								</div>
							</div>
						</div>
					</form>

					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table" cellspacing="0" width="100%">
									<thead>
                                        <tr>
											<th style="display: none;">#</th>
											<th style="text-align: left;" width="10%">Date & Time</th>
											<th style="text-align: left;" width="10%">Recevied Work Order</th>
											<th style="text-align: left;" width="10%">Outlet</th>
                                            <th style="text-align: left;" width="10%">Goldsimth</th>
<!--                                            <th style="text-align: left;" width="10%">Payment Type</th>-->
                                            <th style="text-align: left;" width="10%">B /F Balance</th>
                                            <th style="text-align: left;" width="10%">Total Cost</th>
                                            <th style="text-align: left;" width="10%">Paid</th>
                                            <th style="text-align: left;" width="10%">Balance</th>
											 <th style="text-align: left;" width="10%">Action</th>
                                        </tr>
									</thead>
									<tbody>
										<?php 
										foreach($getresult as $getview)
										{
										
										?>
										<tr>
											<td><?= $getview->gold_ordered_datetime ?></td>
											<td></td>
											<td><?= $getview->gold_outlet_name ?></td>
											<td></td>
											<td></td>
											<!--<td></td>-->
											<td></td>
											<td><?=  number_format($getview->gold_paid_amt,2) ?></td>
											<td></td>
											<td>
											<button class="btn btn-primary" style="padding: 4px 12px; width: 80px;" data-toggle="modal" data-target="#myModal">Action</button>
											<div id="myModal" class="modal fade" role="dialog">
											   <div class="modal-dialog">
												   <div class="modal-content">
													   <div class="modal-header">
														   <button type="button" class="close" data-dismiss="modal">&times;</button>
														   <h4 class="modal-title">Choose Your Action</h4>
													   </div>
													   <div class="modal-body">
														   
														   <ul style="list-style-type:none; text-align:center;">
																<li style="margin-bottom: 5px;">
																	<a class="btn btn-primary" onclick="openReceipt('')" style=" border: none;text-decoration: none; cursor: pointer; width: 100px;" title="Print Receipt">
																		Print
																	</a>
																</li>
																<li style="margin-bottom: 5px;">
																	<a class="btn btn-primary" onclick="openReceipt('')" style=" border: none;text-decoration: none; cursor: pointer; width: 100px;" title="Print Receipt">
																		Pay
																	</a>
																</li>
																<li style="margin-bottom: 5px;">
																	<a class="btn btn-primary" onclick="openReceipt('')" style=" border: none;text-decoration: none; cursor: pointer; width: 100px;" title="Print Receipt">
																		Details
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
										}
										?>
									</tbody>
									<tfoot>
										<tr>
											<td style="display: none;">#</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<!--<td></td>-->
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
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 style="color: #990000;">Summery</h3>
										<hr>
						<div class="col-md-12">
							<table>
								<tbody>
									<tr>
										<td><label style="color:#333333; font-size: 16px;">Total Cost:</label> </td>
										<td><label style="color:#333333; font-size: 16px;"><?=!empty($total_opening_qty)?number_format($total_opening_qty,2):'0.00'?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Paid:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($total_purchased_qty)?number_format($total_purchased_qty,2):'0.00'?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Balance to Pay:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($total_balance_qty)?number_format($total_balance_qty,2):'0.00'?></label></td>
									</tr>
								</tbody>
							</table>
						</div>
					<hr>
				</div>
			</div>
		</div>
		
		
	</div>
	<br /><br /><br />
</div>
<?php
	$this->load->view('includes/header_notification.php');
?>
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
				$( api.table().column(7).footer() ).html("<strong>"+addCommas(api.column( 7, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				$( api.table().column(8).footer() ).html("<strong>"+addCommas(api.column( 8, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				$( api.table().column(9).footer() ).html("<strong>"+addCommas(api.column( 9, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
				
			}
        });
    });
</script>

<?php
	$this->load->view('includes/footer.php');
?>