<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Goldsmith No : <?php echo $getResult->gs_id; ?></title>
		<script src="<?= base_url() ?>assets/js/jquery-1.7.2.min.js"></script>
		<link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/datepicker3.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/styles.css" rel="stylesheet">

		<link href="<?= base_url() ?>assets/css/icono.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
		<link href="<?= base_url() ?>assets/css/multiple-select.css" rel="stylesheet" media="screen">
		<link href="<?= base_url() ?>assets/css/bootstrap-select.css" rel="stylesheet" media="screen">
		
		<link href="<?php echo base_url()?>assets/js/jquery.fancybox.css?v=2.1.5" rel="stylesheet" type="text/css" media="screen">
		<style type="text/css" media="all">
			body { 
				max-width: 770px; 
				margin:0 auto; 
				text-align:center; 
				color:#000; 
				
				font-size:12px; 
			}
		</style>
	</head>

	<body>

		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<table class="table">
						<tbody>
							<tr>
								<td>
									<div class="left" style="text-align: left; font-weight: bold;">Goldsmith Name : <?= !empty($getResult->fullname) ? $getResult->fullname : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Goldsmith Email : <?= !empty($getResult->email) ? $getResult->email : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Goldsmith Phone : <?= !empty($getResult->phone) ? $getResult->phone : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Goldsmith Address : <?= !empty($getResult->address) ? $getResult->address : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Land Phone No : <?= !empty($getResult->land_phone_number) ? $getResult->land_phone_number : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Employee No : <?= !empty($getResult->gold_smith_num) ? $getResult->gold_smith_num : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Opening Qty : <?= !empty($getResult->opening_gold_qty) ? $getResult->opening_gold_qty : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Status : <?= !empty($getResult->status) ? $getResult->status : '' ?></div>
									<div class="left" style="text-align: left; font-weight: bold;">Date : <?= $getResult->date_created ?></div>
								</td>
							</tr> 
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</body>
</html>


<script src="<?php echo base_url()?>assets/js/jquery.mousewheel-3.0.6.pack.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.fancybox.js?v=2.1.5"></script>

<script>
 $('.fancybox').fancybox();
</script>