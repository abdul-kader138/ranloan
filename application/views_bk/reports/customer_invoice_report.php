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
	function openReceiptDetail(ele) {
		var myWindow = window.open(ele, "", "width=850, height=850");
	}
</script>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Customer Invoice List</h1>
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

					<form action="" method="get">
						<div class="row">
							<div class="col-md-2">
									<div class="form-group">
										<label>Date <span style="color: #F00"></span></label>
										<input type="text" name="create_date" class="form-control" value="<?php echo date('Y-m-d H:i:s');  ?>" maxlength="499" autofocus  disabled required autocomplete="off" />
								
								</div>
							</div>
							<div class="col-md-2">
									<div class="form-group">
										<label>Customer Invoice No. <span style="color: #F00"></span></label>
										<input type="text" name="custmoer_invoice" class="form-control" value="<?=$this->input->get('custmoer_invoice') ?>" autocomplete="off" />
								
								</div>
							</div>
							<div class="col-md-1"></div>
						
							<div class="col-md-2">
								<div class="form-group">
									<label>Outlet</label>
									 <select name="getoutlet"  class="form-control">
										 <option value="">Select Outlet</option>
										<?php
										 foreach ($getOutlet as $viewreport)
										 { 
											 $selected = '';
											 if(!empty($this->input->get('getoutlet'))) 
											 {
												 if($this->input->get('getoutlet') == $viewreport->id)
												 {
													 $selected = 'selected';
												 }
											 }
											 ?>
											<option <?=$selected?> value="<?=$viewreport->id?>"><?=$viewreport->name?></option>
									 <?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Customer</label>
									 <select name="customer_id"  class="form-control">
										 <option value="">Select customer</option>
										<?php
										 foreach ($getCustomers as $viewcust)
										 { 
											 $selected = '';
											 if(!empty($this->input->get('customer_id'))) 
											 {
												 if($this->input->get('customer_id') == $viewcust->id)
												 {
													 $selected = 'selected';
												 }
											 }
											 ?>
											<option <?=$selected?> value="<?=$viewcust->id?>"><?=$viewcust->fullname?></option>
									 <?php }
										?>
									</select>
								</div>
							</div>
					
						</div>
					
					<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text"   name="start_date" class="form-control" value="<?= $this->input->get('start_date')?>" id="startDate" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" value="<?=$this->input->get('end_date')?>" id="endDate"  value=""/>
								</div>
							</div>
						
						<div class="col-md-1"></div>
							<div class="col-md-2">
									<div class="form-group">
										<label>Created By </label>
										<input type="text" readonly="" value="<?= !empty($logged_name)?$logged_name:'' ?>"  class="form-control"   />
									</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<label>&nbsp;</label><br/>
									<input type="submit" class="btn btn-primary" value="Get Report"/>
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
											<th style="text-align: left;" width="4%">#</th>
											<th style="text-align: left;" width="10%">Date & Time</th>
											<th style="text-align: left;" width="10%">Outlet</th>
											<th style="text-align: left;" width="10%">Customer Name</th>
											<th style="text-align: left;" width="10%">From Date</th>
											<th style="text-align: left;" width="10%">To Date</th>
											<th style="text-align: left;" width="10%">Total Amount(LKR)</th>
											<th style="text-align: left;" width="10%">Action</th>
                                        </tr>
									</thead>
									<tbody>
										<?php $i = 1;
										foreach($getresult as $view) { 
											?>
										<tr>
											<td><?= $i ?></td>
											<td><?=$view->gold_ordered_datetime ?></td>
											<td><?=$view->outletname ?></td>
											<td><?=$view->customer_name ?></td>
											<td><?= $this->input->get('start_date') ?></td>
											<td><?= $this->input->get('end_date') ?></td>
											<td><?= number_format($view->gold_grandtotal,2) ?></td>
											<td>
											<button class="btn btn-primary" style="padding: 4px 12px; width: 80px;" onclick="openReceiptDetail('<?= base_url() ?>Reports/customer_invoice_deatils?id=<?php echo $view->gold_id; ?>')">View</button>
											</td>
										</tr>
										<?php $i++; }  ?>
										
										
									</tbody>
									
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
			order:[2,"desc"],
            responsive: true,
        });
    });
</script>
<?php
	$this->load->view('includes/footer.php');
?>