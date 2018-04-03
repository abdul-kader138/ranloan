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

<script type="text/javascript">
        function openReceipt(ele) {
            var myWindow = window.open(ele, "", "width=380, height=550");
        }
        function openReceiptDetail(ele) {
            var myWindow = window.open(ele, "", "width=850, height=850");
        }
        function openReceiptA4(ele) {
            var myWindow = window.open(ele, "", "width=1020, height=650");
        }

</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Sales Report</h1>
      </div>
   </div>
   <!--/.row-->
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <form action="<?=base_url()?>reports/sales_report_payement" method="get">
                  <div class="row">

                     <div class="col-md-2">
                        <div class="form-group">
                           <label>Start Date</label>
                           <input type="text" name="start_date" class="form-control" id="startDate"  value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" />
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group">
                           <label>End Date</label>
                           <input type="text" name="end_date" class="form-control" id="endDate"  value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" />
                        </div>
                     </div>
                     <div class="col-md-2">
                        <div class="form-group">
                           <label>&nbsp;</label><br />
                           <input type="submit" class="btn btn-primary" value="Get Report" />
                        </div>
                     </div>
                  </div>
               </form>
				<div class="row" style="margin-top: 10px;">
                  <div class="col-md-12">
                     <div class="table-responsive">
                        <table id="datatable" class="display" cellspacing="0" width="100%">
                           <thead>
                              <tr>
								 <th>Date & Time</th>
                                 <th>Outlet</th>
                                 <th>Sale Id</th>
                                 <th>Customer Name</th>
                                 <th>Sales Officers</th>
                                 <th>Sub Amount (<?php echo $site_currency; ?>)</th>
                                 <th>Total Amount (<?php echo $site_currency; ?>)</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
							   <?php
								foreach ($salesOrder as $value)
								{
									$cust_id = $value->gold_id;
							   ?>
									<tr>
										<td><?= date("$site_dateformat H:i A", strtotime($value->gold_ordered_datetime))?></td>
										<td><?=$value->outlet_name?></td>
										<td><?=$value->gold_id?></td>
										<td><?=$value->fullname?></td>
										<td><?=$value->sales_person_name?></td>
										<td><?=!empty($value->gold_grandtotal)?number_format($value->gold_grandtotal,2):'0.00'?></td>
										<td><?=!empty($value->gold_grandtotal)?number_format($value->gold_grandtotal,2):'0.00'?></td>
										<td>
											<button class="btn btn-primary" style="padding: 4px 12px; width: 80px;" data-toggle="modal" data-target="#myModal<?php echo $cust_id; ?>">Action</button>
											<div id="myModal<?php echo $cust_id; ?>" class="modal fade" role="dialog">
											   <div class="modal-dialog">
												   <div class="modal-content">
													   <div class="modal-header">
														   <button type="button" class="close" data-dismiss="modal">&times;</button>
														   <h4 class="modal-title">Choose Your Action</h4>
													   </div>
													   <div class="modal-body">
														   
														   <ul style="list-style-type:none; text-align:center;">
																		<li style="margin-bottom: 5px;">
																			<a class="btn btn-primary" onclick="openReceipt('<?= base_url() ?>Gold/view_invoice?id=<?php echo $value->gold_id; ?>')" style=" border: none;text-decoration: none; cursor: pointer; width: 100px;" title="Print Receipt">
																				Normal Print
																			</a>
																		</li>
																		<li style="margin-bottom: 5px;">
																			<a class="btn btn-primary" onclick="openReceiptA4('<?= base_url() ?>Gold/view_invoice_a4?id=<?php echo $value->gold_id; ?>')" style=" border: none;text-decoration: none; cursor: pointer; width: 100px;" title="Print Receipt">
																				A4 Print
																			</a>
																		</li>
																		<li>
																			<a class="btn btn-primary" onclick="openReceiptDetail('<?= base_url() ?>Gold/view_order_detail?id=<?php echo $value->gold_id ?>')" style="text-decoration: none; cursor: pointer; border: none; width: 100px;" title="View Detail">
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
								<?php }
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
   <div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h3 style="color: #990000;">Summary</h3>
					<?php
					$totalsalesdata = $this->Reports_model->getTotalSalesAllData();
					$tolsales	= $totalsalesdata->totalsales * $totalsalesdata->totalqty;
					$tolcost	= $totalsalesdata->totalcost * $totalsalesdata->totalqty;
					$toltax		= $totalsalesdata->totaltax;
					$toldis		= $totalsalesdata->total_discount_amount;
					$tot_cos_tax_dis = $tolcost + $toltax + $toldis;
					$totalProfit = $tolsales - $tot_cos_tax_dis;
					
					?>
					<hr>
						<div class="col-md-12">
							<table>
								<tbody>
									<tr>
										<td><label style="color:#333333; font-size: 16px;">Total Sales:</label> </td>
										<td><label style="color:#333333; font-size: 16px;"><?=!empty($tolsales)?number_format($tolsales,2):'0.00';?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Cost:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($tolcost)?number_format($tolcost,2):'0.00';?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Tax:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($toltax)?number_format($toltax,2):'0.00';?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Discount:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($toldis)?number_format($toldis,2):'0.00';?></label></td>
									</tr>
									<tr>
										<td><label style="color:#333333;font-size: 16px;">Total Profit:</label> </td>
										<td><label style="color:#333333;font-size: 16px;"><?=!empty($totalProfit)?number_format($totalProfit,2):'0.00'?></label></td>
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
	require_once 'includes/header_notification.php';
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
			order:[2,"desc"],
            responsive: true,
        });
    });
</script>
<?php
   require_once 'includes/footer.php';
   ?>

