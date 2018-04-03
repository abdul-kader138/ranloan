<?php
require_once 'includes/header.php';
?>


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
   
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Profit Calculations</h1>
		</div>
	</div><!--/.row-->

<?php 

//print_r($user_profit_calculations);
	if(!empty($user_profit_calculations))
	{
	$create_date = $user_profit_calculations->create_date;
	$category_name = $user_profit_calculations->category_name;
	$sub_category_name = $user_profit_calculations->sub_category_name;
	$gold_grade_name = $user_profit_calculations->gold_grade_name;
	$profit = $user_profit_calculations->profit;
	$min_profit = $user_profit_calculations->min_profit;
	}
	else
	{
	$create_date = '';
	$category_name = '';
	$sub_category_name = '';
	$gold_grade_name = '';
	$profit = '';
	$min_profit = '';
	}
?>
<input type="hidden" value="<?php echo $sub_category_name; ?>" id="sub_cat_name">
	<div id="message" class="message text-center"></div>
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
						
						
				<form  id="formsubmit" method="post">		
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Date & Time <span style="color: #F00"></span></label>
									<input type="text" name="datetime" class="form-control"  maxlength="499" autofocus value="<?php echo date('Y-m-d H:i:s');?>" autocomplete="off" readonly="readonly" />
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Category <span style="color: #F00">*</span></label>
									<select name="category" id="category" class="form-control category">
										<option value=""> Select Category</option>
										<?php foreach($getCategory as $getview){
											$getCategoryname = $getview->name;
											?>
										<option value="<?= $getview->id ?>" <?php if($category_name == $getCategoryname){ echo 'selected'; } ?> ><?= $getview->name ?></option>
										<?php } ?>
									</select>
									<span id="allreadyRegister" style="color: #ff0000"></span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Sub Category <span style="color: #F00"></span></label>
									<select  name="subcategory" id="subcategory" class="form-control subcategory">
										<option value=""> Select Sub Category</option>
                                        <?php if(!empty($sub_category_name))
										{ ?>
												<option value="<?= $sub_category_name ?>" selected ><?php echo $sub_category_name; ?></option>
									<?php	}
										?>
									</select>
									<span id="subcategory" style="color: #ff0000"></span>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Gold Grade <span style="color: #F00">*</span></label>
									<select  name="gold_grade" id="gold_grade" class="form-control gold_grade">
										<option value=""> Select Grade Grade</option>
										<?php foreach($getGoldGrade as $getGoldview){
											$Get_grade_name = $getGoldview->grade_name;
											?>
										<option value="<?= $getGoldview->grade_id ?>" <?php if($gold_grade_name == $Get_grade_name){ echo 'selected'; } ?> ><?= $getGoldview->grade_name ?></option>
										<?php } ?>
									</select>
									<span id="allreadyRegister" style="color: #ff0000"></span>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<label>Profit% </label>	
									<input type="text" name="profit" id="profit" class="form-control"  value="<?php echo $profit; ?>" />
								</div>
							</div>
							<div class="col-md-2" style="width: 10%">
								<div class="form-group">
									<label>Minimum Profit% </label>
									<input type="text" name="min_profit" id="min_profit"  value="<?php echo $min_profit; ?>"  class="form-control"   />
								</div>
							</div>
							<div class="col-md-1" style="width: 10%">
								<div class="form-group">
									<label>Created By </label>
									<input type="text" readonly="" value="<?= $logged_name ?>"  class="form-control"   />
								</div>
							</div>
						</div>
					</form>	
						<div class="row" style="padding-top:1%;display:none;">
							<div class="col-md-12">
								<div class="col-md-6">
									<h4 style="color:blue;">Select Cost Calculation Parameters,(by <br>clicking the required button below):</h4>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" style="display:none;">
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Gold Weight(g) </label><br>
										<input type="image" value="0" src="<?php echo base_url("assets/img/no.jpg"); ?>" id="gold_weight_play" class="gold_weight_play" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 14%;">
									<div class="form-group">
										<label>Wastage Weight(g) </label><br>
										<input type="image" value="0"  src="<?php echo base_url("assets/img/no.jpg"); ?>" id="wastage_weight_play" class="wastage_weight_play" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Stone Cost</label><br>
										<input type="image" value="0" src="<?php echo base_url("assets/img/no.jpg"); ?>" id="stone_cost_play" class="stone_cost_play" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Labout Cost</label><br>
										<input type="image" value="0"  src="<?php echo base_url("assets/img/no.jpg"); ?>"id="labout_cost_play" class="labout_cost_play" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Other Cost1</label><br>
										<input type="image" value="0"  src="<?php echo base_url("assets/img/no.jpg"); ?>" id="other1_cost_play" class="other1_cost_play" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Other Cost2</label><br>
										<input type="image" value="0"  src="<?php echo base_url("assets/img/no.jpg"); ?>" id="other2_cost_play" class="other2_cost_play" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Other Cost3</label><br>
										<input type="image" value="0"  src="<?php echo base_url("assets/img/no.jpg"); ?>" id="other3_cost_play" class="other3_cost_play" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group ">
										<label>&nbsp;&nbsp;</label><br>
										<!--<input type="submit" id="add_grade_submit_data" class="btn btn-primary text-center" value="Add Grade" />-->
									</div>
								</div>
							</div>
								<div class="col-md-11" style="width: 85%;"></div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group ">
										<label>&nbsp;&nbsp;</label><br>
										<input type="submit" id="add_grade_submit_data" class="btn btn-primary text-center" value="Add" />
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		<!--</form>-->

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<h2 style="margin-top: 0px;">List Profit Calculations</h2>
							
						<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
						<div role="alert" class="alert alert-success">
						   <button data-dismiss="alert" class="close" type="button">
							   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
						   <strong>Well done!</strong>
						   <?= $this->session->flashdata('SUCCESSMSG') ?>
						</div>
						<?php } ?>
							
							<form action="" method="get">
							  <div class="row">

								 <div class="col-md-2">
									<div class="form-group">
									   <label>Start Date</label>
									   <input name="start_date" class="form-control" id="startDate" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" type="text">
									</div>
								 </div>
								 <div class="col-md-2">
									<div class="form-group">
									   <label>End Date</label>
									   <input name="end_date" class="form-control" id="endDate"  value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" type="text">
									</div>
								 </div>
								 <div class="col-md-2">
									<div class="form-group">
									   <label>&nbsp;</label><br>
									   <input class="btn btn-primary" value="Get Report" type="submit">
									</div>
								 </div>
							  </div>
						   </form>
							<div class="table-responsive">
								<table class="table" id="datatable">
										<thead>
											<tr>
												<th>Date & Time</th>
												<th>Category</th>
												<th>Sub Category</th>
												<th>Gold Grade</th>
												<th>Profit %</th>
												<th>Minimum Profit %</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($ListGetProfitcal as $listview) {?>
											<tr>
												<td><?= $listview->create_date ?></td>
												<td><?= $listview->category_name ?></td>
												<td><?= !empty($listview->sub_category_name)?$listview->sub_category_name:'' ?></td>
												<td><?= $listview->gold_grade_name ?></td>
												<td><?= number_format($listview->profit,2); ?></td>
												<td><?= number_format($listview->min_profit,2); ?></td>
												<td> 
													<a href="<?=base_url().'setting/edit_profit_calculations?id='.$listview->id?>" class="btn btn-primary" >Edit</a>
													<button class="btn btn-primary oldModelHide" style="width: 70px;padding: 4px 12px;"   data-toggle="modal" data-target="#myModal<?php echo $listview->id; ?>">View</button>
												</td>
											</tr>
											
												<div id="myModal<?php echo $listview->id; ?>" class="modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">View Detail</h4>
														</div>
														<div class="modal-body">
															<div class="row">
																<div class="col-md-4">
																	<b>Date & Time</b>
																</div>
																<div class="col-md-8">
																	<?= date('d-m-Y H:i:s', strtotime($listview->create_date)) ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Category</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($listview->category_name)?$listview->category_name:'' ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Sub Category</b>
																</div>
																<div class="col-md-8">
																<?= !empty($listview->sub_category_name)?$listview->sub_category_name:'' ?>
																</div>
															</div>
														
															<div class="row">
																<div class="col-md-4">
																	<b>Gold Grade</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($listview->gold_grade_name)?$listview->gold_grade_name:'' ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Profit %</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($listview->profit)?number_format($listview->profit,2):'' ?>
																</div>
															</div>
															<div class="row">
																<div class="col-md-4">
																	<b>Minimum Profit %</b>
																</div>
																<div class="col-md-8">
																	<?= !empty($listview->min_profit)?number_format($listview->min_profit,2):'' ?>
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
 $(function () {
    $(".category").change();
});
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


 $('.category').change(function () {
	 var sub_cat_name = $("#sub_cat_name").val();	
	var category_id = $(".category option:selected").val();	
	$.ajax({
		type: 'POST',
		url: "<?= base_url(); ?>Setting/getSubCategoryProfit",
		data: {category_id: category_id,sub_cat_name: sub_cat_name},
		dataType: 'JSON',
		success: function (data) {
			$('#subcategory').html(data.subcategory);
		}
	});
	
})


$("#formsubmit").validate({
	  rules: {
			category: "required",
			gold_grade: "required",
			profit: {
				required: true,
				number: true,
			},
			min_profit: {
				required: true,
				number: true,
			}
		},
		messages: {
			category: "Please enter category",
			gold_grade: "Please enter gold grade",
			profit: {
				required: "Please provide a profit",
				number: "Please provide a Numeric value",
			},
			min_profit: {
				required: "Please provide a profit",
				number: "Please provide a Numeric value",
			},
		},

		submitHandler: function(form) {
			
			var category_id	 = $('.category option:selected').val();
			var category_name	 = $('.category option:selected').text();
			var sub_category_id	 = $('.subcategory option:selected').val();
			var sub_category_name	 = $('.subcategory option:selected').text();
			var gold_grade_id	 = $('.gold_grade option:selected').val();
			var gold_grade_name	 = $('.gold_grade option:selected').text();
			var profit		 = $('#profit').val();
			var min_profit	 = $('#min_profit').val();
			var gold_weight	 = $('#gold_weight_play').val();
			var wastage_weight	 = $('#wastage_weight_play').val();
			var stone_cost	 = $('#stone_cost_play').val();
			var labout_cost	 = $('#labout_cost_play').val();
			var other1_cost	 = $('#other1_cost_play').val();
			var other2_cost	 = $('#other2_cost_play').val();
			var other3_cost	 = $('#other3_cost_play').val();
			$.ajax({
				type:'POST',
				url:"<?= base_url(); ?>setting/profitCalculations",
				data: {
					category_id: category_id,category_name:category_name,
					sub_category_id: sub_category_id,sub_category_name:sub_category_name,
					gold_grade_id:gold_grade_id,gold_grade_name:gold_grade_name,
					profit:profit,min_profit:min_profit,gold_weight:gold_weight,
					wastage_weight:wastage_weight,stone_cost:stone_cost,labout_cost:labout_cost,
					other1_cost:other1_cost,other2_cost:other2_cost,other3_cost:other3_cost,
				},
				dataType: 'JSON',
				success:function(data){
					if(data.suceess)
					{
						alert('successfully add..');
						window.location.href = '<?= base_url() ?>setting/profit_calculations';
					}
				}
			});
		}
	});

$('#add_grade_submit_data').click(function(){
	$('#formsubmit').submit();
	
})







	function toggle(el) {
		console.log(el.className);
		//Gold Weight(g)
		if (el.className == "gold_weight_play")
		{
			el.src = "<?php echo base_url("assets/img/yes1.jpg"); ?>";
			el.className = "gold_weight_pause";
			$('.gold_weight_pause').val('1');
		} 
		else if (el.className == "gold_weight_pause")
		{
			el.src = "<?php echo base_url("assets/img/no.jpg"); ?>";
			el.className = "gold_weight_play";
			$('.gold_weight_play').val('0');
		}
		//Wastage Weight(g) 
		else if (el.className == "wastage_weight_play")
		{
			el.src = "<?php echo base_url("assets/img/yes1.jpg"); ?>";
			el.className = "wastage_weight_pause";
			$('.wastage_weight_pause').val('1');
		}
		else if (el.className == "wastage_weight_pause")
		{
			el.src = "<?php echo base_url("assets/img/no.jpg"); ?>";
			el.className = "wastage_weight_play";
			$('.wastage_weight_play').val('0');
		}
		//Stone Cost
		else if (el.className == "stone_cost_play")
		{
			el.src = "<?php echo base_url("assets/img/yes1.jpg"); ?>";
			el.className = "stone_cost_pause";
			$('.stone_cost_pause').val('1');
		}
		else if (el.className == "stone_cost_pause")
		{
			el.src = "<?php echo base_url("assets/img/no.jpg"); ?>";
			el.className = "stone_cost_play";
			$('.stone_cost_play').val('0');
		}
		//Labout Cost
		else if (el.className == "labout_cost_play")
		{
			el.src = "<?php echo base_url("assets/img/yes1.jpg"); ?>";
			el.className = "labout_cost_pause";
			$('.labout_cost_pause').val('1');
		}
		else if (el.className == "labout_cost_pause")
		{
			el.src = "<?php echo base_url("assets/img/no.jpg"); ?>";
			el.className = "labout_cost_play";
			$('.labout_cost_play').val('0');
		}
		//Other Cost1
		else if (el.className == "other1_cost_play")
		{
			el.src = "<?php echo base_url("assets/img/yes1.jpg"); ?>";
			el.className = "other1_cost_pause";
			$('.other1_cost_pause').val('1');
		}
		else if (el.className == "other1_cost_pause")
		{
			el.src = "<?php echo base_url("assets/img/no.jpg"); ?>";
			el.className = "other1_cost_play";
			$('.other1_cost_play').val('0');
		}
		//Other Cost2
		else if (el.className == "other2_cost_play")
		{
			el.src = "<?php echo base_url("assets/img/yes1.jpg"); ?>";
			el.className = "other2_cost_pause";
			$('.other2_cost_pause').val('1');
		}
		else if (el.className == "other2_cost_pause")
		{
			el.src = "<?php echo base_url("assets/img/no.jpg"); ?>";
			el.className = "other2_cost_play";
			$('.other2_cost_play').val('0');
		}
		//Other Cost3
		else if (el.className == "other3_cost_play")
		{
			el.src = "<?php echo base_url("assets/img/yes1.jpg"); ?>";
			el.className = "other3_cost_pause";
			$('.other3_cost_pause').val('1');
		}
		else if (el.className == "other3_cost_pause")
		{
			el.src = "<?php echo base_url("assets/img/no.jpg"); ?>";
			el.className = "other3_cost_play";
			$('.other3_cost_play').val('0');
		}
		
		
		
		return false;
	}
</script>





