<?php
require_once 'includes/header.php';
$uniqid = uniqid();
?>









<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Refined Receieved Note</h1>
		</div>
	</div><!--/.row-->

	<form action="#" id="add-goldsmith" method="post">
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


						<div class="row">


							<div class="col-md-4">
								<div class="form-group">
									<label>Date <span style="color: #F00">*</span></label>
									<input type="text" disabled name="date1" class="form-control"  value="<?php echo date('Y-m-d'); ?>"  required autocomplete="off" />

									<input type="hidden" name="date2" class="form-control"  value="<?php echo date('Y-m-d'); ?>"  required autocomplete="off" />
								</div>
							</div>




							<div class="col-md-4">
								<div class="form-group">
									<label>Refined Gold Receieved Note No. <span style="color: #F00">*</span></label>
									<input type="text" disabled name="order" class="form-control"  value="<?php echo $uniqid; ?>"  required autocomplete="off" />  
									<input type="hidden" name="job" class="form-control"  value="<?php echo $uniqid; ?>"  required autocomplete="off" />
								</div>
							</div>


							<div class="col-md-4">
								<div class="form-group">
									<label>GoldSmiths <span style="color: #F00">*</span></label>
									<select name="gold" class="form-control" required autocomplete="off" onchange="get_job()"><option>Choose GoldSmith</option>
										<?php foreach ($goldsmiths as $golds): ?>
											<option value="<?php echo $golds->gs_id; ?>" ><?php echo $golds->fullname; ?>                      
											</option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>


							<div class="col-md-4">
								<div class="form-group">
									<label>Pending Job No.<span style="color: #F00">*</span></label>
									<select name="jobno"  id="jobno" class="form-control" required autocomplete="off" onchange="get_netweight()" >

									</select>	
								</div>
							</div>


							<div class="col-md-4">
								<div class="form-group">
									<label>Outlets<span style="color: #F00">*</span></label>
									<input type="text" disabled  name="out" id="out" class="form-control" required maxlength="254" autocomplete="off" />
									<input type="hidden"  name="out1" id="out1" class="form-control" required maxlength="254" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Gold Grade (Kt)<span style="color: #F00">*</span></label>
									<input type="number" disabled  name="grade" id="grade" class="form-control" required maxlength="254" autocomplete="off" />
									<input type="hidden" name="grade1" id="grade1" class="form-control" required maxlength="254" autocomplete="off" />
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<style>
										.number {
											padding: 5px 10px;
											font-size: 16px;
										}
									</style>
									<label>Actual Gold Received 24 kt <span style="color: #F00">*</span></label>
									<input type="text" name="weight" id="weight"  class="form-control number " required maxlength="254" autocomplete="off" />


								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Net Gold weight (g) in 24 kt – Estimated<span style="color: #F00">*</span></label>
									<input type="text" name="total"   id="total" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
									<input type="hidden" name="store1"  id="store1" class="form-control"  autofocus required  />
									<input type="hidden" name="total1" id="total1" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Receiving Warehouse<span style="color: #F00">*</span></label>
									<select name="ware"  id="ware" class="form-control" required autocomplete="off">
										<?php foreach ($warehouse as $ware): ?>
											<option value="<?php echo $ware->s_id; ?>" ><?php echo $ware->s_name; ?></option>
										<?php endforeach; ?>
									</select>	
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
									<input type="submit" id="created-btn" class="btn btn-primary text-center" value="Add Refined Received Note" / >
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

	<br /><br /><br /><br /><br />

</div><!-- Right Colmn // END -->


<?php
require_once 'includes/footer.php';
?>


<script type="text/javascript">
    $("#add-goldsmith").on("submit", function (event) {
        event.preventDefault();
        val = $("#jobno").val();
        var formData = $("#add-goldsmith").serialize();
        $('.progress').css('display', 'block');
        $('#created-cycle-btn').attr('disabled', 'disabled');
        $.ajax({
            url: 'save_addrjrn',
            data: formData,
            type: 'POST',
            success: function (data) {
                if (data.error == true)
                {
                    setTimeout(function () {
                        $("#add-goldsmith").get(0).reset();
                        $("#message").css("visibility", "visible");
                        $("#message").html("<div class='alert alert-success text-center'>Successfully!" + val + " </div>");
                        $('.progress').css('display', 'none');
                        $('#created-btn').removeAttr('disabled', 'disabled');
                        setTimeout(function () {
                            $("#message").css("visibility", "hidden");
                            $("#message").html("");
                        }, 2000);
                    }, 2000);
                } else
                {
                    $('.progress').css('display', 'none');
                    $("#message").css("visibility", "visible");
                    $("#message").html("<div class='alert alert-danger text-center'>" + data.error + "</div>");
                    setTimeout(function () {
                        $("#message").css("visibility", "hidden");
                        $("#message").html("");
                    }, 400);
                }
            }
        });


    });


    function get_job() {

        var val = $('select[name=gold]').val();
		alert(val);
        event.preventDefault();
        $.ajax({url: "get_jobno",
            method: "post",
            data: {data: val},
            success: function (data) {
                $("#jobno").html(data.message);
                var val = $('select[name=jobno]').val();

                if (val != null) {
                    get_netweight()
                } else {

                    $("#total").val('');
                    $("#out").val('');
                    $("#grade").val('');
                    $("#total1").val('');
                    $("#out1").val('');
                    $("#grade1").val('');
                    $("#store1").val('');

                }



            }
        });
    }

    function get_netweight() {
        var val = $('select[name=jobno]').val();
        event.preventDefault();
        $.ajax({url: "get_netweight",
            method: "post",
            data: {data: val},
            success: function (data) {
                $("#total").val('');
                $("#out").val('');
                $("#grade").val('');
                $("#total").val(data[0].estimated_weigth);
                $("#out").val(data[0].name);
                $("#store1").val('');
                $("#grade").val(data[0].gold_grade);
                $("#total1").val(data[0].estimated_weigth);
                $("#out1").val(data[0].id);
                $("#store1").val(data[0].store_id);
                $("#grade1").val(data[0].gold_grade);
                get_store();
            }
        });

    }

    function get_store() {

        var val = $('input[name=out1]').val();
        alert(val);
        event.preventDefault();
        $.ajax({url: "get_netstore",
            method: "post",
            data: {data: val},
            success: function (data) {
                $("#ware").html(data.message1);
            }
        });

    }

    function calculations() {


        var price = $('select[name=grade]').val();
        var weight = $("#weight").val();
        if (weight.length > 0) {

//alert(weight);
            var result = (price / 24) * weight;
//alert(price);
            $("#total").val('');
            $("#total").val(result.toFixed(3));

        }
    }


    $('.number').keypress(function (event) {
        var $this = $(this);
        if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
                ((event.which < 48 || event.which > 57) &&
                        (event.which != 0 && event.which != 8))) {
            event.preventDefault();
        }

        var text = $(this).val();
        if ((event.which == 46) && (text.indexOf('.') == -1)) {
            setTimeout(function () {
                if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                    $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                }
            }, 1);
        }

        if ((text.indexOf('.') != -1) &&
                (text.substring(text.indexOf('.')).length > 3) &&
                (event.which != 0 && event.which != 8) &&
                ($(this)[0].selectionStart >= text.length - 2)) {

            event.preventDefault();
        }
    });


</script>





