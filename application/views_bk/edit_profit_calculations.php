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
			<h1 class="page-header">Edit Profit Calculations</h1>
		</div>
	</div><!--/.row-->


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
									<select  name="category" id="category" class="form-control category">
										<option value=""> Select Category</option>
										<?php foreach($getCategory as $getview){
											$selected = '';
											if($get_edit_data->category_id == $getview->id)
											{
												$selected = 'selected'; 
											}
											?>
											
										<option  <?= $selected ?> value="<?= $getview->id ?>"><?= $getview->name ?></option>
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
											$selected = '';
											if($get_edit_data->gold_grade_id == $getGoldview->grade_id)
											{
												$selected = 'selected'; 
											}
											?>
										
										<option <?= $selected ?> value="<?= $getGoldview->grade_id ?>"><?= $getGoldview->grade_name ?></option>
										
										<?php } ?>
									</select>
									<span id="allreadyRegister" style="color: #ff0000"></span>
								</div>
							</div>

					</form>	
							<div class="col-md-1">
								<div class="form-group">
									<label>Profit% </label>
									<input type="text" name="profit" id="profit" value="<?= $get_edit_data->profit ?>" class="form-control"   />
									<input type="hidden" name="edit_id" id="edit_id" value="<?= $get_edit_data->id ?>" class="form-control"   />
									<input type="hidden" name="selected_subcategory" id="selected_subcategory" value="<?= !empty($get_edit_data->sub_category_id)?$get_edit_data->sub_category_id:'' ?>" class="form-control selected_subcategory"   />
								</div>
							</div>
							<div class="col-md-2" style="width: 10%">
								<div class="form-group">
									<label>Minimum Profit% </label>
									<input type="text" name="min_profit" id="min_profit" value="<?= $get_edit_data->min_profit ?>"  class="form-control"   />
								</div>
							</div>
							<div class="col-md-1" style="width: 10%">
								<div class="form-group">
									<label>Created By </label>
									<input type="text" readonly="" value="<?= $logged_name ?>"  class="form-control"   />
								</div>
							</div>
						</div>
						
						
						
						<div class="row" style="padding-top:1%;display:none" >
							<div class="col-md-12">
								<div class="col-md-6">
									<h4 style="color:blue;">Select Cost Calculation Parameters,(by <br>clicking the required button below):</h4>
								</div>
							</div>
						</div>
						<div class="row" style="padding-top:3%;">
							<div class="col-md-12" style="display:none;">
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Gold Weight(g) </label><br>
										<input type="image" value="<?php if($get_edit_data->gold_weight == 0) { echo "0";} else {echo "1";} ?>"
										accept=""src="<?php if($get_edit_data->gold_weight == 0) { echo base_url("assets/img/no.jpg");}else{echo base_url("assets/img/yes1.jpg");} ?>" id="gold_weight_play" 
										class="<?php if($get_edit_data->gold_weight == 0) { echo "gold_weight_play";} else {echo "gold_weight_pause";} ?>" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 14%;">
									<div class="form-group">
										<label>Wastage Weight(g) </label><br>
										<input type="image" value="<?php if($get_edit_data->wastage_weight == 0) { echo "0";} else {echo "1";}?>"  
										accept=""src="<?php if($get_edit_data->wastage_weight == 0) { echo base_url("assets/img/no.jpg");}else{echo base_url("assets/img/yes1.jpg");} ?>" id="wastage_weight_play" 
										class="<?php if($get_edit_data->wastage_weight == 0) { echo "wastage_weight_play";} else {echo "wastage_weight_pause";} ?>" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Stone Cost</label><br>
										<input type="image" value="<?php if($get_edit_data->stone_cost == 0) { echo "0";} else {echo "1";}?>" 
										src="<?php if($get_edit_data->stone_cost == 0) { echo base_url("assets/img/no.jpg");}else{echo base_url("assets/img/yes1.jpg");} ?>" id="stone_cost_play" 
										class="<?php if($get_edit_data->stone_cost == 0) { echo "stone_cost_play";} else {echo "stone_cost_pause";} ?>" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Labout Cost</label><br>
										<input type="image" value="<?php if($get_edit_data->labout_cost == 0) { echo "0";} else {echo "1";}?>"  
										src="<?php if($get_edit_data->labout_cost == 0) { echo base_url("assets/img/no.jpg");}else{echo base_url("assets/img/yes1.jpg");} ?>"id="labout_cost_play" 
										class="<?php if($get_edit_data->labout_cost == 0) { echo "labout_cost_play";} else {echo "labout_cost_pause";} ?>" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Other Cost1</label><br>
										<input type="image" value="<?php if($get_edit_data->other1_cost == 0) { echo "0";} else {echo "1";}?>"  
										src="<?php if($get_edit_data->other1_cost == 0) { echo base_url("assets/img/no.jpg");}else{echo base_url("assets/img/yes1.jpg");} ?>" id="other1_cost_play" 
										class="<?php if($get_edit_data->other1_cost == 0) { echo "other1_cost_play";} else {echo "other1_cost_pause";} ?>" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Other Cost2</label><br>
										<input type="image" value="<?php if($get_edit_data->other2_cost == 0) { echo "0";} else {echo "1";}?>"  
										src="<?php if($get_edit_data->other2_cost == 0) { echo base_url("assets/img/no.jpg");}else{echo base_url("assets/img/yes1.jpg");} ?>" id="other2_cost_play" 
										class="<?php if($get_edit_data->other2_cost == 0) { echo "other2_cost_play";} else {echo "other2_cost_pause";} ?>" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group">
										<label>Other Cost3</label><br>
										<input type="image" value="<?php if($get_edit_data->other3_cost == 0) { echo "0";} else {echo "1";}?>"  
										src="<?php if($get_edit_data->other3_cost == 0) { echo base_url("assets/img/no.jpg");}else{echo base_url("assets/img/yes1.jpg");} ?>" id="other3_cost_play" 
										class="<?php if($get_edit_data->other3_cost == 0) { echo "other3_cost_play";} else {echo "other3_cost_pause";} ?>" onclick="toggle(this);"/>
									</div>
								</div>
								<div class="col-md-1" style="width: 12%;">
									<div class="form-group ">
										<label>&nbsp;&nbsp;</label><br>
										<!--<input type="submit" id="add_grade_submit_data" class="btn btn-primary text-center" value="Update Grade" />-->
									</div>
								</div>
							</div>
							<div class="col-md-11" style="width: 85%;">
								</div>
							<div class="col-md-1" style="width: 12%;">
								<div class="form-group ">
									<label>&nbsp;&nbsp;</label><br>
									<input type="submit" id="add_grade_submit_data" class="btn btn-primary text-center" value="Update Grade" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!--</form>-->

		
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

 $('.category').change(function () {

	Subcategory();
})
Subcategory();
function Subcategory(){
	var category_id = $(".category option:selected").val();	
	var selected_subcategory = $(".selected_subcategory").val();	
	$.ajax({
		type: 'POST',
		url: "<?= base_url(); ?>Setting/getSubCategoryProfit",
		data: {category_id: category_id,selected_subcategory:selected_subcategory},
		dataType: 'JSON',
		success: function (data) {
			$('#subcategory').html(data.subcategory);
		}
	});
}

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
			var edit_id	 = $('#edit_id').val();
			$.ajax({
				type:'POST',
				url:"<?= base_url(); ?>setting/profitCalculations",
					data: {edit_id:edit_id,
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
						alert('successfully update..');
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





