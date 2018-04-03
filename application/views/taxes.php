<?php
	require_once 'includes/header.php';
?>
<script src="<?= base_url() ?>assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/datatable/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/datatable/jquery-ui.css">
<script src="<?= base_url() ?>assets/datatable/jquery-1.12.4.js"></script>
<script src="<?= base_url() ?>assets/datatable/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/datatable/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/datatable/buttons.dataTables.min.css">
<script src="<?= base_url() ?>assets/datatable/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/datatable/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/datatable/sum().js"></script>
<script src="<?= base_url() ?>assets/datatable/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/datatable/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/datatable/buttons.print.min.js"></script>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Taxes</h1>
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
											<th>Date & Time</th>
											<th>Outlet</th>
											<th>Type</th>
											<th>Form No.</th>
											<th>Customer</th>
											<th>Invoice Sub Total</th>
											<th>Tax Amount</th>
											<th>Total Amount</th>
											<th>View</th>
										</tr>
									</thead>
									<tbody>
									
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
	require_once 'includes/header_notification.php';
?>
<?php
require_once 'includes/footer.php';
?>