<!-- Add jQuery library -->

<!--
 Add mousewheel plugin (this is optional) 
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

 Add fancyBox 
<link rel="stylesheet" href="<?= base_url() ?>assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

 Optionally add helpers - button, thumbnail and/or media 
<link rel="stylesheet" href="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?= base_url() ?>assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<script src="<?= base_url() ?>files/tableExport.js"></script>
<script src="<?= base_url() ?>files/jquery.base64.js"></script>
<script src="<?= base_url() ?>files/html2canvas.js"></script>
<script src="<?= base_url() ?>files/jspdf/jspdf.js"></script>
<script src="<?= base_url() ?>files/jspdf/libs/sprintf.js"></script>
<script src="<?= base_url() ?>files/jspdf/libs/base64.js"></script>-->




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
        $("#transfer_date").datepicker({
            format: "<?php echo $dateformat; ?>",
            autoclose: true
        });
    });
</script> 
<?php
$alert_msg = $this->session->userdata('alert_msg');
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?php echo "Refine order List "; ?></h1>
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

					<?php
					if ($user_role < 3) {
						?>
						<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
	                        <div class="col-md-10">
	                           <!-- <a href="<?= base_url() ?>bank_dt/addBdt" style="text-decoration: none;">
	                                <button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
	                                    <i class="icono-plus"></i> Add <?php echo BDT ?>
	                                </button>
	                            </a> -->
								<!-- //Gold/addrjo -->

								<a href="<?= base_url() ?>Refine_gold/add_refine_order" style="text-decoration: none;">
	                                <button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
	                                    <i class="icono-plus"></i> Add Refine order
	                                </button></a>
								<!-- Gold viewrjo  renamed   as   refine_order_list -->
								<!--refine_order_lis -->
								<a href="<?= base_url() ?>Refine_gold/add_refined_receive_note" style="text-decoration: none;">
	                                <button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
	                                    <i class="icono-eye"></i>Add Refined Receive Note
	                                </button></a>
								<!-- addrjrn -->
								<a href="<?= base_url() ?>Refine_gold/refined_gold" style="text-decoration: none;">
	                                <button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
	                                    <i class="icono-plus"></i> Refined Gold List
	                                </button></a>

	                        </div>
	                        <div class="col-md-2" style="text-align: right;">
	                           <!--  <a href="<?= base_url() ?>Gold/exportBdt" style="text-decoration: none;">
	                                <button type="button" class="btn btn-success" style="background-color: #5cb85c;width: 100%; border-color: #4cae4c;">
	                                    Export
	                                </button>
	                            </a> -->
								<button type="button" class="btn btn-success pull-right " id="csv" style="background-color: #5cb85c; width: 100%;border-color: #4cae4c;">
									Export Excel
								</button>
	                        </div>
	                    </div>
						<?php
					}
					?>

                    <form id="search_box" method="get" >
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-2">
								<label>Goldsmith</label>

								<select class="form-control" name="gold">
									<option value="<?php echo "all"; ?>" > <?php echo "All Goldsmith"; ?></option>
<?php foreach ($goldsmith as $gold): ?>
										<option value="<?php echo $gold->gs_id; ?>" > <?php echo $gold->fullname; ?></option>
									<?php endforeach; ?>
								</select>

							</div>
							<!--                                                        <div class="col-md-2">
<?php
$payment_methods['-'] = 'All Payment Types';
$payment_methods = $payment_methods + $this->Constant_model->getddData('payment_method', 'id', 'name', 'name');
echo sel_element($payment_methods, $payment_method = 0, 'Select Payment Type', 'payment_method', 'Choose Payment Type');
?>
																						 
																					</div>-->

							<div class="col-md-2">
								<label>Gold Grade</label>
								<select class="form-control" name="grade">

									<option value="<?php echo "all"; ?>" > <?php echo "All Grade"; ?></option>
<?php foreach ($grade as $gold1): ?>
										<option value="<?php echo $gold1->grade_name; ?>" > <?php echo $gold1->grade_name; ?></option>
									<?php endforeach; ?>
								</select>

							</div>
							<div class="col-md-2"> <label>Outlets</label>
								<select class="form-control" name="outlet">

									<option value="<?php echo "all"; ?>" > <?php echo "All Outlets"; ?></option>
<?php foreach ($outlet as $out): ?>
										<option value="<?php echo $out->id; ?>" > <?php echo $out->name; ?></option>
									<?php endforeach; ?>                        </select>                                    





                            </div>
							<div class="col-md-2"> <label>Status</label>
								<select class="form-control" name="status">

									<option value="<?php echo "completed"; ?>" >Completed</option>
									<option value="<?php echo "pending"; ?>" >Pending</option>
								</select>                                    





                            </div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input type="text" name="start_date" class="form-control" id="startDate"   value="<?php echo $url_start = ''; ?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input type="text" name="end_date" class="form-control" id="endDate"   value="<?php echo $url_end = ''; ?>" />
								</div>
							</div>

							<div>
								<div class="col-md-2 col-md-offset-4" style="margin-top: -15px;">
									<div class="form-group">
										<label>&nbsp;</label><br />

										<input type="submit" class="btn btn-primary" style="width: 100%;" value="Search" >
									</div>
								</div>
							</div>
                    </form>

					<script>
						$("#search_box").on("submit", function (event) {
							event.preventDefault();
							var formdata = $("#search_box").serialize();
							$.ajax({url: "search_gold_status_",
								method: "post",
								data: formdata,
								success: function (data) {
									$("#replaceable").html(data.message);

								}
							});
						});

						function exportexel(event) {
							event.preventDefault();

							var formdata = $("#search_box").serialize();
							$.ajax({url: "exportBdt",
								method: "get",
								data: formdata,
								dataType: 'json',
								success: function (data) {

								}
							});

					//alert("dgf");


						}


						$("#csv").click(function () {
							$("#btnExport").tableExport({
								type: 'excel',
								escape: false,
							});
						});
					</script>



                    <div class="row" style="margin-top: 0px;">
                        <div class="col-md-12">

                            <div class="table-responsive">
                                <table class="table" id="btnExport">
                                    <thead>
                                        <tr>


											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="10%">Date</th>
											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="15%">RJO No</th>
											<!--
											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="15%">RJRN No</th> -->
											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="15%">Goldsmith</th>
											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="15%">Gold Grade</th>
											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="10%">Gold Weight (g)</th>
											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="15%">Estimated Net Gold Weight (g) in 24 kt</th>
											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="20%">Refined Gold</th>
											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="20%">Outlet</th> 
											<th style="border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" class="text-center" width="30%">Status</th>

										</tr>
                                    </thead>
                                    <tbody id="replaceable">

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6" style="float: left; padding-top: 10px;">
<?php //echo $displayshowingentries;  ?>
                        </div>
                        <div class="col-md-6" style="text-align: right;">
							<?php // echo $links; ?>
                        </div>
                    </div>

                </div><!-- Panel Body // END -->
            </div><!-- Panel Default // END -->
        </div><!-- Col md 12 // END -->
    </div><!-- Row // END -->

    <br /><br /><br />

</div><!-- Right Colmn // END -->





