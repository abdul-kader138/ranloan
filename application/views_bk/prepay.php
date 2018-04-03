<?php
require_once 'includes/header.php';
?>

<style type="text/css">
	.fileUpload {
		position: relative;
		overflow: hidden;
		border-radius: 0px;
		margin-left: -4px;
		margin-top: -2px;
	}
	.fileUpload input.upload {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		font-size: 20px;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}
</style>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Manage Prepayment</h1>
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

					<div>
						<form action="<?= base_url() ?>customers/updateprepay" method="post" >
							<div class="row">
								<input type="hidden" name="cid" value="<?php echo $customer_id ?>" />
								<div class="col-md-2">
									<div class="form-group">
										<label>Outlet <span style="color: #F00">*</span></label>
										<select class="form-control" name="outlet_id" id="outlet_id" required="">
											<?php
												foreach($getOutlet as $outlet)
												{ ?>
													<option value="<?=$outlet->id?>"><?=$outlet->name?></option>
											<?php }
											?>
										</select>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Select Payment Type<span style="color: #F00">*</span></label>
										<select required="" class="form-control" name="payment_id" id="payment_id">
											<option value="">Select Payment Type</option>
										</select>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Payment <span style="color: #F00">*</span></label>
										<input required="" type="text" name="payment" class="form-control" placeholder="Payment" maxlength="499" required value=""  />
									</div>
								</div>
								
							</div> 
							<div class="row" style="margin-top: 20px;">
								<div class="col-md-4">
									<div class="form-group">
										<button class="btn btn-primary">Save Prepay</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive" >
								<table class="table" id="datatable">
									<thead>
										<tr>
											<th>Date &amp; Time</th>
											<th>Customer Name</th>
											<th>Outlet</th>
											<th>Payment Method</th>
											<th>Payment</th>
											
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($resultdata as $prepayment) { ?>
											<tr>
												<td><?=$prepayment->created?></td>
												<td><?=$prepayment->fullname ?></td>
												<td><?=$prepayment->outletname ?></td>
												<td><?=$prepayment->payment_name ?></td>
												<td><?=!empty($prepayment->payment)?number_format($prepayment->payment,2):'0.00' ?></td>
											</tr>
										<?php }
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			<a href="<?= base_url() ?>customers/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->


	<br /><br /><br />

</div><!-- Right Colmn // END -->
<?php
require_once 'includes/footer.php';
?>

<script type="text/javascript">
	$('document').ready(function(){
		$('#outlet_id').change(function(){
				outlet();
		});

		function outlet()
		{
			var outlet_id = $('#outlet_id').val();
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Customers/getPaymentMethod",
				data: {outlet_id: outlet_id},
				dataType: 'JSON',
				success:function(data){
					$('#payment_id').html(data.success);
				}
			 });
		}
		outlet();
		
		
		
		
		
		
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
			var pagetotal = addCommas(api.column( 6, {page:'current'} ).data().sum().toFixed(2));
			$( api.table().column(6).footer() ).html("<strong>"+pagetotal+" LKR </strong>");
			$( api.table().column(5).footer() ).html("<strong>"+addCommas(api.column( 5, {page:'current'} ).data().sum().toFixed(2))+" </strong>");
			$( api.table().column(4).footer() ).html("<strong>"+addCommas(api.column( 4, {page:'current'} ).data().sum().toFixed(2))+" (g) </strong>");
			
		}
		});
		
		
		
		
		
	});
</script>