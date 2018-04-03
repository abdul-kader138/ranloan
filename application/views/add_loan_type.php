<?php
require_once 'includes/header.php';
?>

<link href="<?=base_url()?>assets/css/wickedpicker.min.css" rel="stylesheet"> 
<script type="text/javascript" src="<?=base_url()?>assets/js/wickedpicker.min.js"></script>
<style>
	label.error{
		color:red;
	}
	.gold_weight_play, .gold_weight_pause 
	{
		width:80px;height:35px;
		border-radius: 36%;
		
	}
	.wastage_weight_play, .wastage_weight_pause 
	{
		width:80px;height:35px;
		border-radius: 36%;
		
	}
	.stone_cost_play, .stone_cost_pause 
	{
		width:80px;height:35px;
		border-radius: 36%;
		
	}
	.labout_cost_play, .labout_cost_pause 
	{
		width:80px;height:35px;
		border-radius: 36%;
		
	}
	.other1_cost_play, .other1_cost_pause 
	{
		width:80px;height:35px;
		border-radius: 36%;
		
	}
	.other2_cost_play, .other2_cost_pause 
	{
		width:80px;height:35px;
		border-radius: 36%;
		
	}
	.other3_cost_play, .other3_cost_pause 
	{
		width:80px;height:35px;
		border-radius: 36%;
		
	}
	.play, .pause {width:80px;height:35px;
   border-radius: 36%;
   margin-top: 18px;
   }
   .loanDetail label {
   	padding: 3px;
   	/*margin-top: 50px;*/
   }
   .loan_row{
   	margin-top: 10px;
   	/*margin-bottom: 30px;*/
   }
   .late_charges_row{
   	padding: 10px;
   }
   .sub_rows{
   	padding:0px;
   	text-align: center;
   }
   
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Loan Type</h1>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form id="formsubmit" method="post">
					<div class="row">
						<div style="margin-top: 50px; margin-bottom: 50px;" class="col-lg-12">
							<div class="col-lg-8">
							<div align="center" class="row">
								<div class="col-lg-3">
										<label>Loan Name</label>
								</div>
								<div class="col-lg-3">
										<label>No 0f Months</label>
								</div>
								<div class="col-lg-3">
									<label>Monthly Intrest Rate %</label>
								</div>
								<div class="col-lg-3">
									<label>Grace Period Before Interest Charge - Days</label>
								</div>
								
							</div>
							<div  class="row">
								<div class="col-lg-3">
										<input type="text" id="loan_name" name="loan_name" class="form-control">
								</div>
								<div class="col-lg-3">
										<input type="text" id="no_of_month" name="no_of_month" class="form-control">
								</div>
								<div class="col-lg-3">
									<input type="text" id="monthly_interest" name="monthly_interest" class="form-control">
								</div>
								<div class="col-lg-3">
									<input type="text" id="grace_period" name="grace_period" class="form-control">
								</div>
								
							</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div style="margin-bottom: 20px;" class="col-lg-12">
							<h4 align="center" style="color:darkred"><strong>Penalty (late) Charges</strong></h4>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div style="border: 1px solid black;margin-left:40px; padding:0px 15px 15px 15px;" class="col-lg-5">
								<div class="row">
									<div class="col-lg-12">
										<h5 style="color:darkred"><strong>First Penalty</strong></h5>
									</div>
								</div>
								<div class="row late_charges_row">
									<div align="right" class="col-lg-6 loan_row">
										<strong>Interest Rate %</strong>
									</div>
									<div class="col-lg-3">
										<input type="text" id="first_penalty_interest" name="first_penalty_interest" class="form-control" value="">
									</div>
								</div>
								<div class="row late_charges_row">
									<div align="right" class="col-lg-6 loan_row">
										<strong>Grace Period - Days</strong>
									</div>
									<div class="col-lg-3">
										<input type="text" id="first_penalty_afterday" name="first_penalty_afterday" class="form-control">
									</div>
								</div>
								<div class="row late_charges_row">
									<div align="right" class="col-lg-6">
										<strong>Default Interest will apply for First Penalty grace period</strong>
									</div>
									<div class="col-lg-3">
										<input type="image" width="60px" src="<?php echo base_url("assets/img/no.jpg"); ?>" class="play1" onclick="return toggle1(this);"/>
										<input type="hidden" id="first_penalty_firstday" name="first_penalty_firstday" value="0">
									</div>
								</div>
								<div class="row">
									<div align="right" class="col-lg-6">
										<strong>First Penalty Interest apply from Date</strong>
									</div>
									<div class="col-lg-4">
										<input type="text" id="first_penalty_applyday" name="first_penalty_applyday" class="form-control" value="">
									</div>
								</div>
							</div>
							<div class="col-lg-1"></div>
							<div class="col-lg-5" style="border: 1px solid black;padding:0px 15px 15px 15px;">
								<div class="row">
									<div class="col-lg-12 ">
										<h5 style="color:darkred"><strong>Second Penalty</strong></h5>
									</div>
								</div>
								<div class="row late_charges_row">
									<div align="right" class="col-lg-6 loan_row">
										<strong>Interest Rate %</strong>
									</div>
									<div class="col-lg-3">
										<input type="text" id="second_penalty_interest" name="second_penalty_interest" class="form-control">
									</div>
								</div>
								<div class="row late_charges_row">
									<div align="right" class="col-lg-6 loan_row">
										<strong>Grace Period - Days</strong>
									</div>
									<div class="col-lg-3">
										<input type="text" id="second_penalty_afterday" name="second_penalty_afterday" class="form-control">
									</div>
								</div>
								<div class="row late_charges_row">
									<div align="right" class="col-lg-6">
										<strong>Default Interest will apply for Second Penalty grace period</strong>
									</div>
									<div class="col-lg-3">
										<input type="image" width="60px" src="<?php echo base_url("assets/img/no.jpg"); ?>" class="play2" onclick="return toggle2(this);"/>
										<input type="hidden" id="second_penalty_firstday" name="second_penalty_firstday" value="0">
									</div>
								</div>
								<div class="row">
									<div align="right" class="col-lg-6">
										<strong>Second Penalty Interest apply from Date</strong>
									</div>
									<div class="col-lg-4">
										<input type="text" id="second_penalty_applyday" name="second_penalty_applyday" class="form-control">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div style="margin-top:20px; margin-bottom: 50px;" class="col-lg-12">
							<div align="center" class="col-lg-2 col-lg-offset-10">
								<input type="submit" id="Save_loan" name="Save_loan" value="Save" class="btn btn-primary">
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div><!--/.row-->

	<div id="message" class="message text-center"></div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">							
							<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
							<div role="alert" class="alert alert-success">
							   <button data-dismiss="alert" class="close" type="button">
								   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
							   <strong>Well done!</strong>
							   <?= $this->session->flashdata('SUCCESSMSG') ?>
							</div>
							<?php } ?>
							<div class="table-responsive">
								<table class="table" id="datatable">
										<thead>
											<tr>
												<th style="display: none;">Id</th>
												<th>Date & Time</th>
												<th>Loan Name</th>
												<th>No of Months</th>
												<th>Interest %</th>
												<th>Grace Period</th>
												<!-- <th>Minimum Profit %</th> -->
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($GetloanDetailData as $loanDetail) {?>
										
											<tr>
												<td style="display: none;"><?= $loanDetail->id ?></td>
												<td><?= $loanDetail->create_date ?></td>
												<td><?= $loanDetail->loan_name ?></td>
												<td><?= !empty($loanDetail->no_of_month)?$loanDetail->no_of_month:0 ?></td>
												<td><?= $loanDetail->monthly_interest ?></td>
												<td><?=$loanDetail->grace_period; ?></td>
												<td> 
													<button class="btn btn-primary oldModelHide" style="width: 70px;padding: 4px 12px;"   data-toggle="modal" data-target="#myModal<?php echo $loanDetail->id; ?>">View</button>
												</td>
											</tr>
											
												<div id="myModal<?php echo $loanDetail->id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Detail</h4>
														</div>
														<div class="modal-body">
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Date & Time</b>
																</div>
																<div class="col-md-8">
																	<?= date('d-m-Y H:i:s', strtotime($loanDetail->create_date)) ?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Loan Name</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($loanDetail->loan_name)?$loanDetail->loan_name:'' ?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>No 0f Months</b>
																</div>
																<div class="col-md-8">
																<?= !empty($loanDetail->no_of_month)?$loanDetail->no_of_month:'' ?>
																</div>
															</div>
														
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Monthly Intrest Rate %</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($loanDetail->monthly_interest)?$loanDetail->monthly_interest:'' ?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Grace Period Before Interest Charge</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($loanDetail->grace_period)?number_format($loanDetail->grace_period,2):'' ?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-8">
																<h5><strong>First Penalty</strong></h5>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Interest Rate %</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($loanDetail->first_penalty_interest)?number_format($loanDetail->first_penalty_interest,2):'' ?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Grace Period</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($loanDetail->first_penalty_afterday)?($loanDetail->first_penalty_afterday):'' ?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Default Interest will apply for First Penalty grace period</b>
																</div>
																<div class="col-md-8">
																	<?php
																	if ($loanDetail->first_penalty_firstday == 1) {
																	 	echo "Yes";
																	 }else{
																	 	echo "No";
																	 } 
																	?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>First Penalty Interest apply from Date</b>
																</div>
																<div class="col-md-8">
																	<?= $loanDetail->first_penalty_applyday ?>

																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-8">
																<h5><strong>Second Penalty</strong></h5>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Interest Rate %</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($loanDetail->second_penalty_interest)?number_format($loanDetail->second_penalty_interest,2):'' ?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Grace Period</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($loanDetail->second_penalty_afterday)?($loanDetail->second_penalty_afterday):'' ?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Default Interest will apply for Second Penalty grace period</b>
																</div>
																<div class="col-md-8">
																	<?php
																	if ($loanDetail->second_penalty_firstday == 1) {
																	 	echo "Yes";
																	 }else{
																	 	echo "No";
																	 } 
																	?>
																</div>
															</div>
															<div style="margin-bottom: 3px;" class="row">
																<div class="col-md-4">
																	<b>Second Penalty Interest apply from Date</b>
																</div>
																<div class="col-md-8">
																	<?= $loanDetail->second_penalty_applyday ?>
																</div>
															</div>
															
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
											<?php } ?>
										</tbody>
									</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>


	<br /><br /><br /><br /><br />
</div>

<?php
require_once 'includes/footer.php';
?>
<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	
<script type="text/javascript">

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

$("#formsubmit").validate({
	  rules: {
			loan_name: "required",
			// monthly_interest: "required",
			no_of_month: {
				required: true,
				number: true,
			},
			monthly_interest: {
				required: true,
				number: true,
			}
		},
		messages: {
			loan_name: "Please enter Loan Name",
			// monthly_interest: "Please enter Monthly Intrest Rate",
			no_of_month: {
				required: "Please provide No 0f Months",
				number: "Please provide a Numeric value",
			},
			monthly_interest: {
				required: "Please provide Monthly Intrest Rate",
				number: "Please provide a Numeric value",
			}
		},

		submitHandler: function(form) {
			
			var loan_name	 = $('#loan_name').val();
			var no_of_month		 = $('#no_of_month').val();
			var monthly_interest	 = $('#monthly_interest').val();
			var grace_period	 = $('#grace_period').val();
			var first_penalty_interest	 = $('#first_penalty_interest').val();
			var first_penalty_afterday	 = $('#first_penalty_afterday').val();
			var first_penalty_firstday	 = $('#first_penalty_firstday').val();
			var first_penalty_applyday	 = $('#first_penalty_applyday').val();
			var second_penalty_interest	 = $('#second_penalty_interest').val();
			var second_penalty_afterday	 = $('#second_penalty_afterday').val();
			var second_penalty_firstday	 = $('#second_penalty_firstday').val();
			var second_penalty_applyday	 = $('#second_penalty_applyday').val();
			$.ajax({
				type:'POST',
				url:"<?= base_url(); ?>setting/submit_loan_detail",
				data: {
					loan_name: loan_name,no_of_month:no_of_month,
					monthly_interest: monthly_interest,grace_period:grace_period,
					first_penalty_interest:first_penalty_interest,first_penalty_afterday:first_penalty_afterday,
					first_penalty_firstday:first_penalty_firstday,first_penalty_applyday:first_penalty_applyday,second_penalty_interest:second_penalty_interest,second_penalty_afterday:second_penalty_afterday,
					second_penalty_firstday:second_penalty_firstday,second_penalty_applyday:second_penalty_applyday,
				},
				dataType: 'JSON',
				success:function(data){
					if(data.suceess)
					{
						alert('successfully add..');
						window.location.href = '<?= base_url() ?>setting/add_loan_type';
					}
				}
			});
		}
	});

	function toggle1(el) {
        if (el.className != "pause1")
        {
            el.src = "<?php echo base_url("assets/img/yes1.jpg"); ?>";
            el.className = "pause1";
            $('#first_penalty_firstday').val(1);
        } 
        else if (el.className == "pause1")
        {
            el.src = "<?php echo base_url("assets/img/no.jpg"); ?>";
            el.className = "play1";
            $('#first_penalty_firstday').val(0);
        }
        return false;
    }

    function toggle2(el) {
        if (el.className != "pause2")
        {
            el.src = "<?php echo base_url("assets/img/yes1.jpg"); ?>";
            el.className = "pause2";
            $('#second_penalty_firstday').val(1);
        } 
        else if (el.className == "pause2")
        {
            el.src = "<?php echo base_url("assets/img/no.jpg"); ?>";
            el.className = "play2";
            $('#second_penalty_firstday').val(2);
        }
        return false;
    }

$(document).ready(function() {
$('#second_penalty_applyday').datepicker({
format: "dd-mm-yyyy",

  });

  $('#second_penalty_applyday').datepicker();
  $('#first_penalty_applyday').datepicker({
format: "dd-mm-yyyy",

  });

  $('#first_penalty_applyday').datepicker();
});


    $(document).ready(function() {
        $('#second_penalty_interest').keypress(function (event) {
            return isNumber(event, this)
        });
        $('#first_penalty_interest').keypress(function (event) {
            return isNumber(event, this)
        });
        $('#monthly_interest').keypress(function (event) {
            return isNumber(event, this)
        });
        $('#no_of_month').keypress(function (event) {
            return isNumberonly(event, this)
        });
        $('#grace_period').keypress(function (event) {
            return isNumberonly(event, this)
        });
        $('#first_penalty_afterday').keypress(function (event) {
            return isNumberonly(event, this)
        });
        $('#second_penalty_afterday').keypress(function (event) {
            return isNumberonly(event, this)
        });
    });
    // THE SCRIPT THAT CHECKS IF THE KEY PRESSED IS A NUMERIC OR DECIMAL VALUE.
    function isNumber(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

    function isNumberonly(evt, element) {

        var charCode = (evt.which) ? evt.which : event.keyCode

        if (
            (charCode < 48 || charCode > 57))
            return false;

        return true;
    }    


</script>





