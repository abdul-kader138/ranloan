<?php
require_once 'includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Suppliers</h1>
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

					<div class="row">
						<div class="col-md-12">
							<?php
							if ($user_role == 1) {
								?>
								<a href="<?= base_url() ?>setting/addsupplier" style="text-decoration: none">
									<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>Add New Supplier</button>
								</a>
								<?php
							}
							?>
						</div>
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">

							<div class="table-responsive">
								<table class="table" id="datatable">
									<thead>
										<tr>
											<th width="20%">Name</th>
											<th width="15%">Email</th>
											<th width="10%">Tel</th>
											<th width="15%">Fax</th>
											<th width="10%">Status</th>
											<th width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
									<?php
									if (count($results) > 0) {
										foreach ($results as $data) {
											$id = $data->id;
											$name = $data->name;
											$email = $data->email;
											$tel = $data->tel;
											$fax = $data->fax;
											$status = $data->status;
											?>
												<tr>
													<td><?php echo $name; ?></td>
													<td>
														<?php
														if (empty($email)) {
															echo '-';
														} else {
															echo $email;
														}
														?>
													</td>
													<td>
														<?php
														if (empty($tel)) {
															echo '-';
														} else {
															echo $tel;
														}
														?>
													</td>
													<td>
														<?php
														if (empty($fax)) {
															echo '-';
														} else {
															echo $fax;
														}
														?>
													</td>
													<td style="font-weight: bold;">
														<?php
														if ($status == '1') {
															echo '<span style="color: #090;">Active</span>';
														}
														if ($status == '0') {
															echo '<span style="color: #f9243f;">Inactive</span>';
														}
														?>
													</td>
													<td>
														<a href="<?= base_url() ?>setting/editsupplier?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 5px;">
															<button class="btn btn-primary">Edit</button>
														</a>
													</td>
												</tr>
												<?php
											}
										}
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
	<br /><br /><br />
</div>
<?php
require_once 'includes/footer.php';
?>

<script>
$(document).ready(function() {
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
		responsive: true,
		
	});
});
</script>	
