<?php
   // require_once 'includes/header.php';
?>
<style>
	.validation p
	{
		color:red;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Gold Grade and Prices </h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<form action="<?=base_url()?>Gold/save_newgoldgrade" method="post">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<label>Date & Time <span style="color: #F00">*</span></label>
										<input type="text" name="date_time" class="form-control"  value="<?=date('Y-m-d H:i:s')?>" readonly=""  />
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<label>Gold Grade (Kt)<span style="color: #F00">*</span></label>
										<input type="hidden" name="gold_grade_id" class="form-control"  value="<?=!empty($getlastgrade->grade_id)?$getlastgrade->grade_id:0?>" />
										<input type="text" readonly=""  class="form-control"  value="24" />
										
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<label>Gold Purity<span style="color: #F00">*</span></label>
										<input type="text" readonly="" name="gold_purity" class="form-control" required="" id="gold_purity_gold" value="<?=!empty($getlastgrade->gold_purity)?$getlastgrade->gold_purity:''?>" />
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<label>Rate Per Gram<span style="color: #F00">*</span></label>
										<input  type="text" name="rate_per_gram" class="form-control" id="rate_per_gram" value="<?php echo set_value('rate_per_gram'); ?>" />
										<span class="validation"><?php echo form_error('rate_per_gram'); ?></span>
									</div>
								</div>

								<div class="col-md-2">
									<div class="form-group">
										<label>Created By </label>
										<input type="text" readonly="" value="<?= $logged_name ?>"  class="form-control"   />
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group ">

										<input style="margin-top: 25px;" type="submit" class="btn btn-primary text-center" value="Add Price" />
									</div>
								</div>
							</div>
						</form>


					</div>
				</div>

			</div>
		
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
						<div role="alert" class="alert alert-success">
						   <button data-dismiss="alert" class="close" type="button">
							   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
						   <strong>Well done!</strong>
						   <?= $this->session->flashdata('SUCCESSMSG') ?>
						</div>
						<?php } ?>
					
<!--					<div class="row">
						<div class="col-md-12">
							<a href="<?=base_url()?>Gold/gold_price" style="text-decoration: none">
								<button class="btn btn-primary" style="padding: 0px 12px;"><i class="icono-plus"></i>Add New Day Gold Price</button>
							</a>
						</div>
					</div>-->
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							
						<div class="table-responsive">
							<table class="table" id="datatable">
							    <thead>
							    	<tr>
										<th style="display: none;">#</th>
								    	<th width="15%">Date & Time</th>
									   <?php 
									   $array_push = array();
										foreach ($getGoldeGrade as $kt)
										{
											$array_defult["name"] = $kt->grade_name;
											$array_defult["gold_purity"] = $kt->gold_purity;
											array_push($array_push,$array_defult);
											?>
											<th width="15%"><?=$kt->grade_name?> (<?=$kt->gold_purity?>)</th>	
											
										<?php }
										?>
										<th width="10%">Created by</th>
									</tr>
							    </thead>
								<tbody>
								<?php
									foreach ($gold_prices as $data) 
									{
//										echo "<pre>";
//										print_r($data);
									?>
										<tr>
											<td style="display: none;"><?=$data->gp_id?></td>
											<td><?=$data->gp_date_created?></td>
											<?php
											foreach ($array_push as $grade)
											{
												$cal = '';
												if($grade['name'] == 24)
												{
													$cal = $data->gp_price;
												}
												else
												{
													$cal = ($data->gp_price / $data->gp_purity) * $grade['gold_purity'];
												}
												?>
											<td><?=number_format($cal,2)?> <?php //echo "(".$data->gp_price." / ".$data->gp_purity.") * ".$grade['gold_purity'];?></td>
										<?php	}
											?>
											<td><?=$data->fullname?></td>
										</tr>
								<?php 
									} ?>
								</tbody>
							</table>
						</div>
							
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6" style="float: left; padding-top: 10px;">
						
						</div>
						<div class="col-md-6" style="text-align: right;">
						
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
	<br /><br /><br />
	
</div>
<script>
$('document').ready(function(){
	$('.gold_grade_id').change(function(){
		var gold_id = $(this).val();
		if(gold_id != "")
		{
				$.ajax({
						type:'POST',
						url:"<?=base_url()?>Gold/getGoldGradeDetail",
						data: {gold_id: gold_id},
						dataType: 'JSON',
						success:function(data){
							$('#gold_purity_gold').val(data.gold_purity);
						}
					});
				 }
				 else
				 {
					$('#gold_purity_gold').val('');
				 }
	});
	
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
	
	
	
