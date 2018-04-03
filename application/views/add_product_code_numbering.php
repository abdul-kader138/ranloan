<?php
	$app = realpath(APPPATH);
	require_once $app.'/views/includes/header.php';
?>
<style>
   .play, .pause {width:80px;height:35px;
   border-radius: 36%;
   margin-top: 18px;
   }
   .boxremoveborder input {
   border: 0;
   background-color: #f7f7f8;
   }
   .boxremoveborder1 input {
   border: 0;
   background-color: #fff;
   }
   .active {
   background-color: orange !important;
   }
   #addPaymentMethod tr td input[type="text"]{
   border:none;
   }
 
input[type="checkbox"] {
    display:inline-block;
    width:19px;
    height:19px;
    margin:-2px 10px 0 0;
    vertical-align:middle;
    cursor:pointer;
}

</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
   <div class="row">
      <div class="col-lg-12">
         <h1 class="page-header">Add Product Code Numbering</h1>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-body">
               <div class="row">
				   <div class="col-md-4" id="firstPart">
					  <div class="col-md-6">
						 <div class="form-group">
							<label>Date & Time</label>
							<input type="text" name="created_date" class="form-control" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly />
						 </div>
					  </div>
					  <div class="col-md-6">
						 <div class="form-group">
							<label>Auto Generate <br />Product Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
							<input type="image" name="auto_number_change" id="auto_number_change" value="0" style="width: 55px; height: 25px;"  src="<?php echo base_url("assets/img/no.jpg"); ?>" class="play" onclick="toggle(this);"/>	
						 </div>
						  <span style="color: #ff0033;" class="message_auto_number_change"></span>
					  </div>
					   <div class="col-md-12 changecategorysubcategory" style="display: none;">
							<div class="form-group">
								<label>Category</label>
								<select class="form-control" id="category" >
									<option value="">Select Category</option>
									<?php
									foreach ($getCategory as $category)
									{
									?>
									<option value="<?=$category->id?>"><?=$category->name?></option>
									<?php
									}
									?>
								</select>
							</div>
					   </div>
					   <div class="col-md-12 changecategorysubcategory" style="display: none;">
							<div class="form-group">
								<input type="hidden" id="selected_subcategory" value="" >
								<label>Sub Category</label>
								<select class="form-control" name="sub_category" id="sub_category">
									<option>Select Sub Category</option>
								</select>
							</div>
					   </div>
					   
					   <div class="col-md-12" style="padding-top:100px;">
						   <div class="form-group">
							<label>Created By</label>
							<input type="text" value="<?=$UserLoginName?>" readonly="" class="form-control">
						 </div>
					   </div>
					</div>
				   
					<div class="col-md-3" style="display: none;"  id="secondPart">
						<div class="col-md-12">
							<label>Select Change Frequency</label>
						</div>
						
						<div class="col-md-12">
						  <table>
							  <tr>
								  <td valign="middle"><b>Change Daily</b></td>
								  <td><input type="image" value="0" name="change_detail" style="width: 55px; height: 25px;"  src="<?php echo base_url("assets/img/no.jpg"); ?>" id="dailyplay" class="dailyplay" onclick="dailyplay(this);"/></td>
							  </tr>
							  <tr>
								  <td valign='middle'><b>Change Weekly</b></td>
								  <td><input type="image" value="0" name="change_weekly" style="width: 55px; height: 25px;"  src="<?php echo base_url("assets/img/no.jpg"); ?>" id="weeklyplay" class="weeklyplay" onclick="weeklyplay(this);"/></td>
							  </tr>
							  <tr>
								  <td valign='middle'><b>Change Monthly</b></td>
								  <td><input type="image" value="0" name="change_monthly"  style="width: 55px; height: 25px;"  src="<?php echo base_url("assets/img/no.jpg"); ?>" id="monthlyplay" class="monthlyplay" onclick="monthlyplay(this);"/></td>
							  </tr>
							  <tr>
								  <td valign='middle'><b>Change Yearly</b></td>
								  <td><input type="image" value="0" name="change_yearly" style="width: 55px; height: 25px;"  src="<?php echo base_url("assets/img/no.jpg"); ?>" id="yearlyplay" class="yearlyplay" onclick="yearlyplay(this);"/></td>
							  </tr>
						  </table>
							<sapn class="message_at_least_one_required" style="color: #ff0033;"></sapn>
						</div>
						
					</div>
				   <div class="col-md-5" style="display: none;" id="thridPart">
					   <div class="col-md-12">
							<label>Select Invoice prefix, If need. (Click the Required Prefix)</label>
						</div>
						
						<div class="col-md-12">
						 <div class="form-group">
							 <label style="background: #e3e3e3; padding: 5px; width: 40%; text-align: center;">Current Year</label>
							 <input type="checkbox" name="current_year" value="0" id="current_year"  />
						 </div>
						</div>
						<div class="col-md-12">
						 <div class="form-group">
							 <label style="background: #e3e3e3; padding: 5px; width: 40%; text-align: center;">Current Month</label>
							 <input type="checkbox"  name="current_month" value="0" id="current_month"  />
						 </div>
						</div>
						<div class="col-md-12">
						 <div class="form-group">
							 <label style="background: #e3e3e3; padding: 5px; width: 40%; text-align: center;">Current Day</label>
							 <input type="checkbox" name="current_day" value="0" id="current_day"  />
						 </div>
						</div>
					   <div class="col-md-12" style="margin-top:40px ">
						 <div class="form-group">
							 <label>Enter Starting Number</label>
							 <input type="text" name="enter_starting_number" id="enter_starting_number" value="" placeholder="ex. 1" style="width: 150px;" class="form-control"  />
							 <span class="message_enter_starting_number" style="color: #ff0033;"></span>
						 </div>
						</div>
						
				   </div>
                  
               </div>
				<div class="col-md-12" style="text-align: right;"><button class="btn btn-primary" id="SubmitBillNumbering">Add Product Code Numbering</button></div>
            </div>
         </div>
		  
		  <a href="<?=base_url()?>setting/product_code_numbering" class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
			<i class="icono-caretLeft" style="color: #FFF;"></i>Back
		</a>
		  
         <!-- Right Colmn // END -->
         <!--end payment-->
      </div>
      <!-- Panel Body // END -->
   </div>
  
   <style>
      .modal-dialog{
      width:60%;
      margin: auto;
      }
   </style>
   
</div>
<!--end payment method-->
<?php
   $app = realpath(APPPATH);
       require_once $app.'/views/includes/footer.php';
   //    require_once 'includes/footer.php';
   ?>
<script>
	$('#category').change(function(){
		category();
	});
	
	function category()
	{
		var category_id = $("#category").val();
		var selected_subcategory = $("#selected_subcategory").val();
		$.ajax({
			type:'POST',
			url:"getSubCategory",
			data: {category_id: category_id,selected_subcategory:selected_subcategory},
			dataType: 'JSON',
			success:function(data){
				$('#sub_category').html(data.suucess);
			}
		 });
	}
	
	$('body').delegate('#SubmitBillNumbering','click',function(){
		var auto_number_change = $('#auto_number_change').val();
		var dailyplay =	$('#dailyplay').val();
		var weeklyplay = $('#weeklyplay').val();
		var monthlyplay = $('#monthlyplay').val();
		var yearlyplay = $('#yearlyplay').val();
	
	
		var current_year  = $('#current_year').val();
		var current_month  = $('#current_month').val();
		var current_day  = $('#current_day').val();
		var enter_starting_number  = $('#enter_starting_number').val();
		var category  = $('#category').val();
		var sub_category  = $('#sub_category').val();

		if(auto_number_change == '0')
		{
			$('.message_auto_number_change').html('Auto Generate Product Code Required!!');
		}
		else if(dailyplay == '0' && weeklyplay == '0' && monthlyplay == '0' && yearlyplay == '0' )
		{
			$('.message_at_least_one_required').html('At least one Required!!');
		}
		else if(enter_starting_number == '')
		{
			$('.message_enter_starting_number').html('This Field Required!!');
		}
		else if(category == '')
		{
			alert('Please Select Category');
		}
		else if(sub_category == '')
		{
			alert('Please Select Sub Category');
		}
		else
		{
			$('.message_enter_starting_number').html('');
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Product_Code_Numbering/SubmitProduct_Code_Numbering",
				data: {auto_number_change: auto_number_change,
						dailyplay:dailyplay,weeklyplay:weeklyplay,monthlyplay:monthlyplay,yearlyplay:yearlyplay,
						current_year:current_year,current_month:current_month,current_day:current_day,
						enter_starting_number:enter_starting_number,sub_category:sub_category,category:category
				},
				dataType: 'JSON',
				success:function(data){
					if(data.success)
					{
						window.location.href='<?=base_url()?>setting/product_code_numbering';
					}
					else if(data.error)
					{
						alert('Category and Subcategory all ready register please select different!!');
					}
				}
			});
		}
	});
	
$('#current_year').on('change', function(){
   this.value = this.checked ? 1 : 0;
});

$('#current_month').on('change', function(){
   this.value = this.checked ? 1 : 0;
});
$('#current_day').on('change', function(){
   this.value = this.checked ? 1 : 0;
});

	
function toggle(el){
	  if(el.className!="pause")
      {
          el.src="<?php echo base_url("assets/img/yes1.jpg"); ?>";
		  $('.message_auto_number_change').html('');
          $('#auto_number_change').val('1');
          el.className="pause";
          $('#secondPart').show();
		  
		  $('#dailyplay').removeClass('dailypause');
		  $('#dailyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#dailyplay').addClass('dailyplay');
		  
		  $('#weeklyplay').removeClass('weeklypause');
		  $('#weeklyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#weeklyplay').addClass('weeklyplay');
		  
		  $('#monthlyplay').removeClass('monthlypause');
		  $('#monthlyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#monthlyplay').addClass('monthlyplay');
		  
		  $('#yearlyplay').removeClass('yearlpause');
		  $('#yearlyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#yearlyplay').addClass('yearlyplay');
		  $('#dailyplay').val('0');
		  $('#weeklyplay').val('0');
		  $('#monthlyplay').val('0');
		  $('#yearlyplay').val('0');
		  $('.changecategorysubcategory').show();
		  
		  
      }
      else if(el.className=="pause")
      {
          el.src="<?php echo base_url("assets/img/no.jpg"); ?>";
          el.className="play";
		  $('#auto_number_change').val('0');
		  $('#secondPart').hide();
          $('#thridPart').hide();
          $('.changecategorysubcategory').hide();
		  $('#category').val('');
		  $('#sub_category').val('');
      }
      return false;
   }

   
function dailyplay(el){
      if(el.className!="dailypause")
      {
          el.src="<?php echo base_url("assets/img/yes1.jpg"); ?>";
		  $('.message_at_least_one_required').html('');
          el.className="dailypause";
		  $('#dailyplay').val('1');
		  $('#weeklyplay').val('0');
		  $('#monthlyplay').val('0');
		  $('#yearlyplay').val('0');
		  
		  $('#thridPart').show();
		  
		  $('#weeklyplay').removeClass('weeklypause');
		  $('#weeklyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#weeklyplay').addClass('weeklyplay');
		  
		  $('#monthlyplay').removeClass('monthlypause');
		  $('#monthlyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#monthlyplay').addClass('monthlyplay');
		  
		  $('#yearlyplay').removeClass('yearlpause');
		  $('#yearlyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#yearlyplay').addClass('yearlyplay');
		  
		  
      }
      else if(el.className=="dailypause")
      {
          el.src="<?php echo base_url("assets/img/no.jpg"); ?>";
		  $('#dailyplay').val('0');
          el.className="dailyplay";
		  $('#thridPart').hide();
		  
      }
      return false;
}

function weeklyplay(el){
      if(el.className!="weeklypause")
      {
          el.src="<?php echo base_url("assets/img/yes1.jpg"); ?>";
		  $('.message_at_least_one_required').html('');
          el.className="weeklypause";
		  $('#thridPart').show();
		  $('#weeklyplay').val('1');
		  $('#dailyplay').val('0');
		  $('#monthlyplay').val('0');
		  $('#yearlyplay').val('0');
		  
		  $('#dailyplay').removeClass('dailypause');
		  $('#dailyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#dailyplay').addClass('dailyplay');
		  
		  $('#monthlyplay').removeClass('monthlypause');
		  $('#monthlyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#monthlyplay').addClass('monthlyplay');
		  
		  $('#yearlyplay').removeClass('yearlpause');
		  $('#yearlyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#yearlyplay').addClass('yearlyplay');
		  
      }
      else if(el.className=="weeklypause")
      {
          el.src="<?php echo base_url("assets/img/no.jpg"); ?>";
          el.className="weeklyplay";
		  $('#weeklyplay').val('0');
		  $('#thridPart').hide();
      }
      return false;
}
function monthlyplay(el){
      if(el.className!="monthlypause")
      {
          el.src="<?php echo base_url("assets/img/yes1.jpg"); ?>";
		  $('.message_at_least_one_required').html('');
          el.className="monthlypause";
		  $('#monthlyplay').val('1');
		  $('#dailyplay').val('0');
		  $('#weeklyplay').val('0');
		  $('#yearlyplay').val('0');
		  $('#thridPart').show();
		  $('#dailyplay').removeClass('dailypause');
		  $('#dailyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#dailyplay').addClass('dailyplay');
		  
		  $('#weeklyplay').removeClass('weeklypause');
		  $('#weeklyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#weeklyplay').addClass('weeklyplay');
		  
		  $('#yearlyplay').removeClass('yearlpause');
		  $('#yearlyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
		  $('#yearlyplay').addClass('yearlyplay');
      }
      else if(el.className=="monthlypause")
      {
          el.src="<?php echo base_url("assets/img/no.jpg"); ?>";
          el.className="monthlyplay";
		  $('#monthlyplay').val('0');
		  $('#thridPart').hide();
      }
      return false;
}
function yearlyplay(el){
		if(el.className!="yearlpause")
		{
			el.src="<?php echo base_url("assets/img/yes1.jpg"); ?>";
			el.className="yearlpause";
			$('.message_at_least_one_required').html('');
			$('#yearlyplay').val('1');
			$('#dailyplay').val('0');
			$('#weeklyplay').val('0');
			$('#monthlyplay').val('0');
			
			
			$('#thridPart').show();
			$('#dailyplay').removeClass('dailypause');
			$('#dailyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
			$('#dailyplay').addClass('dailyplay');

			$('#weeklyplay').removeClass('weeklypause');
			$('#weeklyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
			$('#weeklyplay').addClass('weeklyplay');

			$('#monthlyplay').removeClass('monthlypause');
			$('#monthlyplay').attr('src', '<?php echo base_url("assets/img/no.jpg"); ?>');
			$('#monthlyplay').addClass('monthlyplay');
		}
		else if(el.className=="yearlpause")
		{
			el.src="<?php echo base_url("assets/img/no.jpg"); ?>";
			el.className="yearlyplay";
			$('#yearlyplay').val('0');
			$('#thridPart').hide();
		}
      return false;
}
   
</script>



