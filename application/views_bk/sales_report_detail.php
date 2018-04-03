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

<script>
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
		<div class="col-lg-6">
			<h1 class="page-header">Product Sales Report Detail</h1>
		</div>
		<div class="col-lg-6" style="text-align: right;">
			<br />
			
		</div>
		
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th width="12%">Date</th>
											<th width="12%">Code</th>
											<th width="12%">Name</th>
											<th width="12%">Quantity</th>
											<th width="12%">Outlet</th>
											<th width="10%">Payment</th>
											<th width="10%">Sub Total (<?php echo $site_currency; ?>)</th>
											<th width="10%">Tax (<?php echo $site_currency; ?>)</th>
											<th width="10%">Grand Total (<?php echo $site_currency; ?>)</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($getSalesReport as $value)
										{
											$order_id = $value->id;
											?>
											<tr>
												<td><?=date("$site_dateformat H:i A", strtotime($value->gold_ordered_datetime))?></td>
												<td><?=$value->product_code?></td>
												<td><?=$value->product_name?></td>
												<td><?=$value->qty?></td>
												<td><?=$value->gold_outlet_name?></td>
												<td><?=$value->payment_method_name?>
												<td><?=!empty($value->subtotal)?number_format($value->subtotal,2):0?></td>
												<td><?=!empty($value->tax)?number_format($value->tax,2):0?></td>
												<td><?=!empty($value->grandtotal)?number_format($value->grandtotal,2):0?></td>
												<td style="display: none;"><?=$value->id?></td>
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
			<a href="<?= base_url() ?>reports/sales_report" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
		</div>
	</div>
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
			order:[0,"desc"],
            responsive: true,
        });
    });
</script>
<?php
require_once 'includes/footer.php';
?>