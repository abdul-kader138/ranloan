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
      <!--<div class="col-lg-12">-->
      <div class="col-lg-4">
         <h1 class="page-header">Add Bill Numbering</h1>
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
							<label>Auto Number Change <br />in the Sales Invoice</label>
							<input type="image" name="auto_number_change" id="auto_number_change" value="0" style="width: 55px; height: 25px;"  src="<?php echo base_url("assets/img/no.jpg"); ?>" class="play" onclick="toggle(this);"/>
							
						 </div>
						  <span style="color: #ff0033;" class="message_auto_number_change"></span>
					  </div>
					   <div class="col-md-12" style="padding-top:100px;">
						   <div class="form-group">
							<label>Created By</label>
							<input type="text" value="<?=$UserLoginName?>" readonly="" class="form-control">
						 </div>
					   </div>
					</div>
				   
					<div class="col-md-4" style="display: none;"  id="secondPart">
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
						<div class="col-md-12" style="border: 1px solid #990000;padding: 10px;">
							<div class="col-md-12" style="padding-bottom:  10px;">
								<label>Sales Invoice Change for (if select both the <br />salestypes, then same prefix and <br /> number will continue, until the next <br /> auto change.);</label>
							</div>
							<div class="col-md-6">
								<label>Sales Invoice <br />
									<input type="image" style="width: 55px; height: 25px;" value="1" id="invoicepause" name="sales_invoice"  src="<?php echo base_url("assets/img/yes1.jpg"); ?>" class="invoicepause" onclick="invoicepause(this);"/>
								</label>
							</div>
							<div class="col-md-6">
								<label>Customer Order <br />
									<input type="image" style="width: 55px; height: 25px;" value="1" id="pospause" name="pos_bill"  src="<?php echo base_url("assets/img/yes1.jpg"); ?>" class="pospause" onclick="pospause(this);"/>
								</label>
							</div>
						</div>
					</div>
				   <div class="col-md-4" style="display: none;" id="thridPart">
					   <div class="col-md-12">
							<label>Select Invoice prefix, If need. (Click the Required Prefix)</label>
						</div>
						
						<div class="col-md-12">
						 <div class="form-group">
							 <label style="background: #e3e3e3; padding: 5px; width: 40%; text-align: center;">Current Year</label>
							 <input type="checkbox" name="current_year" value="0" id="current_year"  />
						 </div>
						</div>
						<div class="col-md-12" id="sh_month">
						 <div class="form-group">
							 <label style="background: #e3e3e3; padding: 5px; width: 40%; text-align: center;">Current Month</label>
							 <input type="checkbox"  name="current_month" value="0" id="current_month"  />
						 </div>
						</div>
						<div class="col-md-12" id="sh_curent_day">
						 <div class="form-group">
							 <label style="background: #e3e3e3; padding: 5px; width: 40%; text-align: center;">Current Day</label>
							 <input type="checkbox" name="current_day" value="0" id="current_day"  />
						 </div>
						</div>
					   <div class="col-md-12" style="margin-top:40px ">
						 <div class="form-group">
							 <label>Enter Starting Number</label>
							 <input type="text" name="enter_starting_number" id="enter_starting_number" value="" style="width: 150px;" class="form-control"  />
							 <span class="message_enter_starting_number" style="color: #ff0033;"></span>
						 </div>
						</div>
						
				   </div>
                  
               </div>
				<div class="col-md-12" style="text-align: right;"><button class="btn btn-primary" id="SubmitBillNumbering">Add Bill Numbering</button></div>
            </div>
         </div>
		  
		  <a href="<?=base_url()?>setting/bill_numbering" class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
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
<p id="test" class="col-md-offset-6"></p>
<!--end payment method-->
<?php
   $app = realpath(APPPATH);
       require_once $app.'/views/includes/footer.php';
   //    require_once 'includes/footer.php';
   ?>
<script>
	
	$('body').delegate('#SubmitBillNumbering','click',function(){
		var auto_number_change = $('#auto_number_change').val();
		var dailyplay =	$('#dailyplay').val();
		var weeklyplay = $('#weeklyplay').val();
		var monthlyplay = $('#monthlyplay').val();
		var yearlyplay = $('#yearlyplay').val();
		var pospause =  $('#pospause').val();
		var invoicepause =  $('#invoicepause').val();
		var current_year  = $('#current_year').val();
		var current_month  = $('#current_month').val();
		var current_day  = $('#current_day').val();
		var enter_starting_number  = $('#enter_starting_number').val();

		if(auto_number_change == '0')
		{
			$('.message_auto_number_change').html('Auto Number Change Required!!');
		}
		else if(dailyplay == '0' && weeklyplay == '0' && monthlyplay == '0' && yearlyplay == '0' )
		{
			$('.message_at_least_one_required').html('At least one Required!!');
		}
		else if(enter_starting_number == '')
		{
			$('.message_enter_starting_number').html('This Field Required!!');
		}
		else
		{
			$('.message_enter_starting_number').html('');
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Bill_Numbering/SubmitBillNumbering",
				data: {auto_number_change: auto_number_change,
						dailyplay:dailyplay,weeklyplay:weeklyplay,monthlyplay:monthlyplay,yearlyplay:yearlyplay,
						pospause:pospause,invoicepause:invoicepause,current_year:current_year,current_month:current_month,current_day:current_day,
						enter_starting_number:enter_starting_number
				},
				dataType: 'JSON',
				success:function(data)
				{
					if(data.success)
					{
						window.location.href='<?=base_url()?>setting/bill_numbering';
					}
					else
					{
						alert('I am here coder');
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
		  
		  
      }
      else if(el.className=="pause")
      {
          el.src="<?php echo base_url("assets/img/no.jpg"); ?>";
          el.className="play";
		  $('#auto_number_change').val('0');
		  $('#secondPart').hide();
          $('#thridPart').hide();
        
      }
      return false;
   }
function invoicepause(el){
      if(el.className!="invoicepause")
      {
          el.src="<?php echo base_url("assets/img/yes1.jpg"); ?>";
          el.className="invoicepause";
		  $('#invoicepause').val('1');
      }
      else if(el.className=="invoicepause")
      {
          el.src="<?php echo base_url("assets/img/no.jpg"); ?>";
          el.className="invoiceplay";
		  $('#invoicepause').val('0');
      }
      return false;
}

function pospause(el){
      if(el.className!="pospause")
      {
          el.src="<?php echo base_url("assets/img/yes1.jpg"); ?>";
          el.className="pospause";
		  $('#pospause').val('1');
      }
      else if(el.className=="pospause")
      {
          el.src="<?php echo base_url("assets/img/no.jpg"); ?>";
          el.className="posplay";
		  $('#pospause').val('0');
      }
      return false;
}
   
function dailyplay(el){

	$('#sh_curent_day').show(); //03-11-17 add by a3frt
	$('#sh_month').show(); //03-11-17 add by a3frt

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

	$('#sh_curent_day').hide(); //03-11-17 add by a3frt
	$('#sh_month').show(); //03-11-17 add by a3frt

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

	$('#sh_curent_day').hide(); //03-11-17 add by a3frt
	$('#sh_month').show();	//03-11-17 add by a3frt

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

	$('#sh_curent_day').hide(); //03-11-17 add by a3frt
	$('#sh_month').hide(); ////03-11-17 add by a3frt

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