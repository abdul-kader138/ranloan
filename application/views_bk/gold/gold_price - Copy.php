<?php
//   require_once 'includes/header.php';
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add  Gold Grade & Prices</h1>
		</div>
	</div><!--/.row-->

	<form action="#" id="add-goldsmith" method="post" >
		<div id="message" class="message text-center"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">


						<table>
							<?php //if(!empty($grade[0]->grade_id)) { ?>
							<div class="row">

								<div class="col-md-3">
									<div class="form-group">
										<label>Date & Time<span style="color: #F00">*</span></label>
										<input type="text" name="dateandtime" class="form-control"  maxlength="499" autofocus disabled autocomplete="off" value="<?php echo date("Y-m-d H:i:s"); ?>" />
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Gold Grade<span style="color: #F00">*</span></label>
										<select class="form-control" onchange="getvalgradename(this);">
											<option>Select</option>
										<?php foreach($getgold_grade as $getgrade){?>	
											<option value="<?php echo $getgrade->grade_id;?>"><?php  echo $getgrade->grade_name; ?></option> 
										<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="col-md-2">
									<div class="form-group">
										<label>Gold Grade<span style="color: #F00">*</span></label>
										<input type="text" name="goldgrade"  value="<?php echo !empty($grade[0]->grade_name)?$grade[0]->grade_name:''; ?>" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
										<input type="hidden" name="goldgrade24" value="<?php echo !empty($grade[0]->grade_name)?$grade[0]->grade_name:''; ?>" class="form-control"  maxlength="499" autofocus required autocomplete="off" />

									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Gold Purity <span style="color: #F00">*</span></label>
										<input type="text" name="goldpurity" id="goldpurity12" value="<?php  echo !empty($grade[0]->gold_purity)?$grade[0]->gold_purity:''; ?>" class="form-control"    maxlength="499" autofocus required autocomplete="off" />
										<input type="hidden" name="goldpurity1" id="goldpurity1" value="<?php  echo !empty($grade[0]->gold_purity)?$grade[0]->gold_purity:''; ?>" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<label>Day Rate Per gram<span style="color: #F00">*</span></label>
										<input type="text" onkeyup="valuechange()" name="perdaterate" id="perdaterate" class="form-control" value="<?php echo  !empty($grade[0]->grade_price) ?$grade[0]->grade_price:''; ?>"  maxlength="499" autofocus required autocomplete="off" />
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<button type="button" style="margin-top: 25px;" class="btn btn-primary btn-circle" id="<?php  echo !empty($grade[0]->grade_id)?$grade[0]->grade_id:''; ?>" onclick="updatedata(<?php echo !empty($grade[0]->grade_id)?$grade[0]->grade_id:''; ?>)" data-toggle="modal"  data-target="#UpdateModal"><i class="fa fa-plus">Edit Purity</i></button>

										<button type="button" style="margin-top: 25px;" class="btn btn-primary btn-circle" id="<?php echo !empty($grade[0]->grade_id)?$grade[0]->grade_id:''; ?>" onclick="updatedata(<?php echo !empty($grade[0]->grade_id)?$grade[0]->grade_id:''; ?>)" data-toggle="modal"  data-target="#AddModal"><i class="fa fa-edit">Add Another Grade</i></button>

									</div>
								</div>
							</div>
						
						
							
							<div id="replaceable">

								<?php $counter = 0;
								foreach ($grade1 as $ex24):
								//	echo $grade1[0]->grade_name;
								?> 
									<div class="row" id="<?php echo $ex24->grade_id; ?>">
										<div class="col-md-3" id="">
											<div class="form-group">
												<label><span style=""></span></label>
												<input type="hidden" name="dateandtime1"  class="form-control"  maxlength="499" autofocus autocomplete="off" value="<?php echo date("Y-m-d H:i:s"); ?>" />
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Gold Grade<span style="color: #F00">*</span></label>
												<input type="text" name="newgrades_name1" disabled value="<?php echo !empty($ex24->grade_name)?$ex24->grade_name:''; ?>" class="form-control"  maxlength="499" id="grad<?php echo $counter; ?>" autofocus required autocomplete="off" />


												<input type="hidden" name="newgrades_name2[]" id="grade<?php echo $counter; ?>" value="<?php echo !empty($ex24->grade_name)?$ex24->grade_name:''; ?>" class="form-control"  maxlength="499"  autofocus required autocomplete="off" />
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Gold Purity <span style="color: #F00">*</span></label>
												<input type="text" name="newgold" id="purit<?php echo $counter; ?>" value="<?php
												$gold_purity=!empty($grade[0]->gold_purity)?$grade[0]->gold_purity:'';
												$grade_price=!empty($grade[0]->grade_price)?$grade[0]->grade_price:'';
												$pp = ($ex24->grade_name / 24) * $gold_purity;
												$prec = ($pp * $grade_price) / 100;
												echo round($pp, 3);
									?>" class="form-control"  disabled maxlength="499" autofocus required autocomplete="off" />


												<input type="hidden" name="newgoldpurity[]"   id="purity<?php echo $counter; ?>"   value="<?php echo round($pp, 3); ?>" class="form-control"  maxlength="499" autofocus required autocomplete="off" />

											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Day Rate Per gram<span style="color: #F00">*</span></label>
												<input type="text" name="newgradeprice1" id="pre<?php echo $counter; ?>"  class="form-control" value="<?php echo round($prec, 2); ?>"  maxlength="499" autofocus required autocomplete="off" disabled />
												<input type="hidden" name="newgradeprice1[]" id="pri<?php echo $counter; ?>" class="form-control" value="<?php echo round($prec, 2); ?>"  maxlength="499" autofocus required autocomplete="off" />

											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<button type="button" style="margin-top: 25px;" class="btn btn-primary btn-circle" id="<?php echo !empty($grade[0]->grade_id)?$grade[0]->grade_id:''; ?>" onclick="updatedata(<?php echo $ex24->grade_id; ?>)" data-toggle="modal"  data-target="#UpdateModal"><i class="fa fa-plus">Edit Purity</i></button>

												<button type="button" style="margin-top: 25px;" class="btn btn-primary btn-circle" class="<?php echo $ex24->grade_id; ?>" onclick="delete_grade(<?php echo $ex24->grade_id; ?>)" ><i class=" glyphicon glyphicon-trash"></i></button>                  



											</div>
										</div>
									</div>
									<?php $counter++;
								endforeach; ?>
							</div>	
							
							
							
							
							<input type="hidden" id="loops" value="<?php echo $counter; ?>">

							<div class="row">
								<div class="progress" style="height:40px;display:none;">
									<div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
										please wait...
									</div>
								</div>
								<div class="col-md-12 ">
									<div class="form-group pull-right ">
										<input type="submit" style="width: 130px;" class="btn btn-primary text-center" value="Save" / >
									</div>
								</div>


							</div>

					<?php//}else { echo "Please Add Gold Grade Name 24  ...!"; } ?>
						</table>




					</div><!-- Panel Body // END -->
				</div><!-- Panel Default // END -->


			</div><!-- Col md 12 // END -->
		</div><!-- Row // END -->
	</form>

	<br /><br /><br /><br /><br />

</div><!-- Right Colmn // END -->


<?php
// require_once 'includes/footer.php';
?>



<div class="modal fade" id="UpdateModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Update Gold Grade</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<div id="message2"></div>
						<form enctype="multipart/form-data" id="userupdate">

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


											<div class="row">
												<!-- <div class="col-md-6">
													<div class="form-group">
														<label>Grade Name <span style="color: #F00">*</span></label>
														<input type="text" name="fullname12" id="fullname12" class="form-control"  maxlength="499" autofocus required autocomplete="off" /> 
													</div> -->
											</div>
											<!-- <div class="col-md-6">
												<div class="form-group">
													<label>Price<span style="color: #F00">*</span></label>
																					<input type="number" name="price" id="price" class="form-control" required maxlength="254" autocomplete="off" />
												</div>
											</div>  -->
											<div class="col-md-6">
												<div class="form-group">
													<label>Gold Purity<span style="color: #F00">*</span></label>
													<input type="number" name="gold_purity" id="gold_purity"class="form-control" required maxlength="254" autocomplete="off" />


													<input type="hidden" name="id" id="id" class="form-control" required maxlength="254" autocomplete="off" />

												</div>
											</div>
										</div>



										<div class="row">
											<div class="progress" style="height:40px;display:none;">
												<div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
													please wait...
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-group ">
													<input type="submit" class="btn btn-primary text-center" value="Update Grade" / >
												</div>
											</div>
											<div class="col-md-4"></div>
											<div class="col-md-4"></div>
										</div>



									</div><!-- Panel Body // END -->
								</div><!-- Panel Default // END -->


							</div><!-- Col md 12 // END -->
					</div><!-- Row // END -->
                    </form>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<!-- end of row -->
		</div>
		<!-- end of modal body -->
	</div>   
	<!-- end of modal content --> 
</div>
<!-- end of modal dialogue -->
</div> <!--  Update modal is finish -->






<div class="modal fade" id="AddModal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4>Add Gold Grade</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<div id="message1"></div>
						<form enctype="multipart/form-data" id="addgrade">

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


											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Grade Name <span style="color: #F00">*</span></label>
														<input type="text" name="fullname12" id="fullname12" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
													</div>
												</div>

											</div>



											<div class="row">
												<div class="progress" style="height:40px;display:none;">
													<div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
														please wait...
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group ">
														<input type="submit" class="btn btn-primary text-center" value="Add Grade" / >
													</div>
												</div>
												<div class="col-md-4"></div>
												<div class="col-md-4"></div>
											</div>



										</div><!-- Panel Body // END -->
									</div><!-- Panel Default // END -->


								</div><!-- Col md 12 // END -->
							</div><!-- Row // END -->
						</form>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- end of row -->
			</div>
			<!-- end of modal body -->
		</div>   
		<!-- end of modal content --> 
    </div>
    <!-- end of modal dialogue -->
</div> <!--  Add modal is finish -->





<script>
    function updatedata(id) {

        event.preventDefault();
        $.ajax({url: "get_price",
            method: "post",
            data: {data: parseInt(id)},
            success: function (data) {
                //console.log(data);
                $("#fullname").val(data.message.grade_name);
                $("#price").val(data.message.grade_price);
                $("#gold_purity").val(data.message.gold_purity);
                $("#id").val(data.message.grade_id);

            }
        });

    }

    function delete_grade(id) {

        event.preventDefault();
        $.ajax({
            url: "grade_delete",
            method: "post",
            data: {data: parseInt(id)},
            success: function (data) {

                if (data.error == true)
                {
                    $("#" + id).remove();
                    setTimeout(function () {
                        // $("#message1").css("display","block");      
                        $("#message1").html("<div class='alert alert-success text-center'>Successfully ! Deleted</div>");
                        setTimeout(function () {
                            $("#message1").html("");
                        }, 100);
                    }, 100);
                } else
                {
                    $("#message1").html("<div class='alert alert-danger text-center'>Failed! to Failed to delete try again</div>");
                    setTimeout(function () {
                        $("#message1").html("");
                    }, 4000);
                }
            }
        });


    }


    $("#userupdate").on("submit", function (event) {
        event.preventDefault();
        var price = $("#price").val();
        var per = $("#gold_purity").val();

        var formdata = $("#userupdate").serialize();
        $('.progress').css('display', 'block');
        $.ajax({
            url: 'updated_data_grade',
            data: formdata,
            type: 'POST',
            success: function (data) {
                if (data.error == true)
                {
//       alert(per)

                    v6 = $("#goldpurity12").val(per);
                    v6 = $("#goldpurity1").val(per);
                    v6 = $("#goldpurity").val(per);

                    setTimeout(function () {
                        // $("#message1").css("display","block");
                        $('.progress').css('display', 'none');
                        $("#message2").html("<div class='alert alert-success text-center'>Successfully! Updated grade</div>");

                        setTimeout(function () {
                            $("#message2").html("");
                            //price_load();
                            valuechange1();
                            $("#UpdateModal").modal('hide');



                        }, 100);
                    }, 100);
                } else
                {
                    // $("#message1").css("visibility","visible");
                    $("#message1").html("<div class='alert alert-danger text-center'>Failed! to update Grade try again</div>");
                    setTimeout(function () {
                        // $("#message1").css("visibility","hidden");
                        $("#message1").html("");
                    }, 4000);
                }
            }
        });
    });

    function price_load() {

        $.ajax({
            url: "gold_price_ajax",
            method: "post",
            data: {data: 1},
            success: function (data) {
                $("#replaceable").html(data.message);
            }
        });
    }

</script>

<script type="text/javascript">
//get value
function getvalgradename(sel)
{
  //  alert(sel.value);
	 	var grade_id = $(sel).val();
		
				$.ajax({
				type:'POST',
				url:"<?=base_url();?>Gold/get_matchvalgradename",
				data: {grade_id: grade_id},
				dataType: 'JSON',
				success:function(data){
					$('#grade_id').val(data.grade_id);
					$('#gold_purity').val(data.gold_purity);
					$('#grade_price').val(data.grade_price);
				}
		 });

			
}
</script>
<script type="text/javascript">
    $("#addgrade").on("submit", function (event) {
        event.preventDefault();
        var formData = $("#addgrade").serialize();
        $('.progress').css('display', 'block');
        $('#created-cycle-btn').attr('disabled', 'disabled');
        $.ajax({
            url: 'save_goldgrade_purity',
            data: formData,
            type: 'POST',
            success: function (data) {
                if (data.error == true)
                {
                    //  setTimeout(function(){
                    $("#addgrade").get(0).reset();
                    $("#message").css("visibility", "visible");
                    $("#message").html("<div class='alert alert-success text-center'>Successfully! Add Grade</div>");
                    $('.progress').css('display', 'none');
                    $('#created-cycle-btn').removeAttr('disabled', 'disabled');
                    setTimeout(function () {
                        $("#message").css("visibility", "hidden");
                        $("#message").html("");
                        price_load();

                        $("#AddModal").modal('hide');

                    }, 100); //},1000);
                } else
                {
                    $('.progress').css('display', 'none');
                    $("#message").css("visibility", "visible");
                    $("#message").html("<div class='alert alert-danger text-center'>" + data.error + "</div>");
                    setTimeout(function () {
                        $("#message").css("visibility", "hidden");
                        $("#message").html("");
                    }, 4000);
                }
            }
        });


    });




    $("#add-goldsmith").on("submit", function (event) {
        event.preventDefault();
        var formData = $("#add-goldsmith").serialize();
        $('.progress').css('display', 'block');
        $('#created-cycle-btn').attr('disabled', 'disabled');
        $.ajax({
            url: 'save_newgoldgrade',
            data: formData,
            type: 'POST',
            success: function (data) {
                if (data.error == true)
                {
                    setTimeout(function () {
                        //$("#add-goldsmith").get(0).reset();
                        $("#message").css("visibility", "visible");
                        $("#message").html("<div class='alert alert-success text-center'>Successfully! Add Grade</div>");
                        $('.progress').css('display', 'none');
                        $('#created-cycle-btn').removeAttr('disabled', 'disabled');
                        setTimeout(function () {
                            $("#message").css("visibility", "hidden");
                            $("#message").html("");
                            price_load();

                            $("#AddModal").modal('hide');

                        }, 100);
                    }, 100);
                } else
                {
                    $('.progress').css('display', 'none');
                    $("#message").css("visibility", "visible");
                    $("#message").html("<div class='alert alert-danger text-center'>" + data.error + "</div>");
                    setTimeout(function () {
                        $("#message").css("visibility", "hidden");
                        $("#message").html("");
                    }, 4000);
                }
            }
        });


    });


    function valuechange() {
        var val = $("#perdaterate").val();
        var val12 = $("#loops").val();
        for (i = 0; i < val12; i++) {

            var purity = $("#purity" + i).val();
            setval = (purity * val) / 100;
            var pric = Math.round(setval * 100) / 100  //returns 8.111
            $("#pre" + i).val(pric);
            $("#pri" + i).val(pric);


        }

    }




    function valuechange1() {


// result=Math.round(8.111111*1000)/1000  //returns 8.111
        var val = $("#goldpurity1").val();
        var val12 = $("#loops").val();
        var perrate = $("#perdaterate").val();
        for (i = 0; i < val12; i++) {
            var grade = $("#grade" + i).val();
            setval = (grade / 24) * val;
            var purity = Math.round(setval * 1000) / 1000  //returns 8.111
            $("#purit" + i).val(purity);
            $("#purity" + i).val(purity);
            var purity = Math.round(setval * 1000) / 1000  //returns 8.111
            var price_gold = (setval * perrate) / 100;
            var p = Math.round(price_gold * 100) / 100  //returns 8.111

            $("#pre" + i).val(p);
            $("#pri" + i).val(p);

        }

    }



</script>





