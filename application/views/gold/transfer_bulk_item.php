<style>
	.nav-tabs > li.active > a{
		color: #fff;
		background-color: #f99719 !important;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<!--	<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Transfer Bulk Item</h1>
			</div>
		</div>/.row-->

	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a  data-target="#page_transfer_bulk" data-toggle="tab" class="btn btn-primary disabled" style="padding: 10px 30px;">Transfer Bulk Item</a></li>
		<li><a data-target="#page_items" data-toggle="tab" class="btn btn-primary disabled" style="padding: 10px 30px;">Add Bulk-Item Details</a></li>
		<li><a data-target="#page_costing" data-toggle="tab" class="btn btn-primary disabled" style="padding: 10px 30px;">Add Bulk-Item Costing</a></li>
		<!--		<li><a data-target="#settings" data-toggle="tab" class="btn btn-primary" style="padding: 10px 30px;">page3</a></li>-->
	</ul>
	
	<form action="" method="post" id="TransferBulkItem">
		<div class="tab-content">
			<div class="tab-pane active" id="page_transfer_bulk">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">
										<h1 class="page-header">Transfer Bulk Item</h1>
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 ">
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Ref. Number</label>
												<input type="text" name="stores_transform_form_no" id="stores_transform_form_no" class="form-control" readonly="" value="<?= $getTransFormNumber ?>" />
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<label>Date & Time</label>
												<input type="text" id="" name="add_new_date" class="form-control" readonly="" value="<?= date('Y-m-d H:i:s'); ?>" />
											</div>
										</div>
										<div class="col-lg-3 ">
											<div class="form-group">
												<label>Outlet</label>
												<select class="form-control getOutletwiseStore"  name="outlet_id" id="getOutletwiseStore">
													<?php
													foreach ($getOutlets as $outlet) {
														?>
														<option data-val="<?= $outlet->name ?>" value="<?= $outlet->id ?>"><?= $outlet->name ?></option>
													<?php }
													?>
												</select>
											</div>
										</div>

										<div class="col-lg-3">
											<div class="form-group">
												<label>Receiving Store</label>
												<select class="form-control getWareHouse"  name="store_id" id="getWareHouse"></select>
											</div>
										</div>

										<div class="col-lg-3 ">
											<div class="form-group">
												<label>Category</label>
												<select class="form-control category" name="category" id="getcategorywiseSubcategoy">
													<option value="">Select Category</option>
													<?php foreach ($getCategory as $cateview) { ?>
														<option value="<?= $cateview->id ?>"><?= $cateview->name ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-lg-3 ">
											<div class="form-group">
												<label>Sub Category</label>
												<select class="form-control sub_category" name="sub_category" id="getcatewiseSubcate">
													<option value="">Select Sub Category</option>
												</select>
											</div>
										</div>
										
										<div class="col-lg-3 ">
											<div class="form-group">
												<button style="width: 100px;margin-top: 10%;" id="wheel-right" type="button" class="btn btn-primary wheel-right">NEXT</button>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="tab-pane" id="page_items">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">
										<h1 class="page-header">Add Bulk-Item Details</h1>
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 ">
										<div class="col-lg-3 ">
											<div class="form-group">
												<label>Goldsmith</label>
												<select class="form-control gold_smith" name="gold_smith" id="gold_smith">
													<option value="">Select Goldsmith</option>
													<?php foreach ($getgold_smith as $goldsmithview) { ?>
														<option value="<?= $goldsmithview->gs_id ?>"><?= $goldsmithview->fullname ?></option>
													<?php } ?>
												</select>

											</div>
										</div>
										<div class="col-lg-3 ">
											<div class="form-group">
												<label>Product Name</label>
												<select class="form-control product_item"   name="bulk_product_item" id="bulk_product_item">
													<option value="">Select Item</option>

												</select>
											</div>
										</div>
										<div class="col-lg-3 ">
											<div class="form-group">
												<label>Product Code</label>
												<input type="text" id="code" name="code" class="form-control"  />
												<input  type="hidden" name="product_num_id"	    id="product_num_id" />
												<input  type="hidden" name="profecctional_code"	id="profecctional_code" />
												<input  type="hidden" name="changeNewdate"		id="changeNewdate" /> 
											</div>
										</div>

										<div class="col-lg-3" style="display: none;">
											<div class="form-group">
												<label>Product Name</label>
												<input type="text" id="product_name" name="product_name" class="form-control"  />
											</div>
										</div>
										

										<div class="col-lg-3 ">
											<div class="form-group">
												<label>Gold Grade</label>
												<select class="form-control " name="grade_id" id="GoldGrade">
													<option value="">Select Gold Grade</option>
													<?php foreach ($getGoldGrade as $Ggrade) { ?>
														<option data-val="<?= $Ggrade->grade_name ?>" data-status="<?= $Ggrade->gold_purity ?>" value="<?= $Ggrade->grade_id ?>"><?= $Ggrade->grade_name ?></option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="col-lg-2">
											<div class="form-group">
												<label>Product Weight(g)</label>
												<input type="text" id="GoldWeight" name="GoldWeight" class="form-control calallitem"/>
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Stone Weight</label>
												<input type="text" id="StoneWeight" name="StoneWeight" class="form-control calallitem"  />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Net Gold Weight</label>
												<input type="text" readonly="" id="NetGoldWeight"name="NetGoldWeight" class="form-control"  />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Wastage(g) per 8g</label>
												<input type="text" id="Wastageperg" name="Wastageperg" class="form-control"  />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Wastage gold (g)</label>
												<input type="text" readonly="" id="Wastagegold" name="Wastagegold" class="form-control" />
											</div>
										</div>

										<div class="col-lg-3 ">
											<div class="form-group">
												<button style="width: 100px;margin-top: 10%;" id="wheel-left" type="button" class="btn btn-primary wheel-left">PREVIOUS</button>
												<button style="width: 100px;margin-top: 10%;" id="wheel-right1" type="button" class="btn btn-primary wheel-right">NEXT</button>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="page_costing">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">
										<h1 class="page-header">Add Bulk-Item Costing</h1>
										<br>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12 ">
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Stone Cost</label>
												<input type="text" id="StoneCost" name="StoneCost" class="form-control calallitem"  />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Labour Cost</label>
												<input type="text" id="LabourCost" name="LabourCost" class="form-control calallitem"  />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Other Cost-1</label>
												<input type="text" id="OtherCost1" name="OtherCost1" class="form-control calallitem"  />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Other Cost-2</label>
												<input type="text" id="OtherCost2" name="OtherCost2" class="form-control calallitem"  />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Other Cost-3</label>
												<input type="text" id="OtherCost3" name="OtherCost3" class="form-control calallitem"  />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Total Gold Weight(g)</label>
												<input type="text" id="TotalGoldweight" readonly="" name="TotalGoldweight" class="form-control calallitem"  />
											</div>
										</div>
										<div class="col-lg-3 " style="width:19%">
											<div class="form-group">
												<label>Gold Grade Current Price</label>
												<input type="text" id="GoldGradeCurrentPrice" readonly name="GoldGradeCurrentPrice" class="form-control" />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Total Gold Cost</label>
												<input type="text" id="TotalGoldCost" readonly name="TotalGoldCost" class="form-control calallitem"  />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Total All Other Cost</label>
												<input type="text" id="TotalAllOtherCost" readonly name="TotalAllOtherCost" class="form-control" />
											</div>
										</div>
										<div class="col-lg-2 ">
											<div class="form-group">
												<label>Transferred Cost</label>
												<input type="text" id="TransferredCost" name="TransferredCost" readonly class="form-control" />
											</div>
										</div>

										<?php
										$us_id = $this->session->userdata('user_id');
										$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
										$logged_name = $get_logged_name->fullname;
										?>
										<div class="col-md-3">
											<div class="form-group" style="text-align: left;">
												<label>Created By </label>
												<input type="text" name="created_by" class="form-control" value="<?= $logged_name ?>" readonly="">
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group" style="text-align: left;">
												<label>Note </label>
												<textarea name="note" class="form-control" ></textarea>
											</div>
										</div>
										<div class="col-lg-3 ">
											<div class="form-group">
												<button style="width: 100px;margin-top: 10%;" id="wheel-left" type="button" class="btn btn-primary wheel-left">PREVIOUS</button>
												<button style="width: 100px;margin-top: 10%;" id="sendBtn" name="sendBtn" type="submit" class="btn btn-primary">Save</button>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<!--		<div class="tab-pane" id="settings">Settings</div>-->
		</div>
	</form>
	
	<h3 class="text-success" style="text-align: center;">
		<?php
		if($this->session->flashdata('update_msg'))
		 echo $this->session->flashdata('update_msg');

		  ?>
	</h3>


	<div class="row" style="margin-top: 10px;">
		<div class="col-md-12">
			<div class="table-responsive">
				<table id="datatable" class="table" cellspacing="0" width="100%">
					<thead>
							<tr>
								<th>Ref. Number</th>
								<th>Date & Time</th>
								<th>Product Code</th>
								<th>Product</th>
								<th>Outlet</th>
								<th>From Store</th>
								<th>To Store</th>									    	
								<th>Transfer Qty</th>									    	
								<th>User</th>									    	
								<th>Actions</th>
								<th></th>									    	
							</tr>
					</thead>
					
					<tbody id="getdataBulkItem">
						<?php
							$i = 1;
							foreach ($getTransformStock as $stock)
							{
							?>
							<tr>
								<td><?=$stock->ref_number?></td>
								<td><?=date('d-m-Y H:i:s', strtotime($stock->date))?></td>
								<td><?=$stock->product_code?></td>
								<td><?=$stock->name?></td>
								<td><?=$stock->outletname?></td>
								<td><?=$stock->fromstore?></td>
								<td><?=$stock->toname?></td>
								<td><?=!empty($stock->qty)?number_format($stock->qty,2):0?></td>
								<td><?=$stock->fullname?></td>
								<td><button class="btn btn-primary ViewMoreDetail" id="<?=$stock->id?>">View</button></td>
								<td> <a href="<?=base_url('Store/get_edit_data').'/'.$stock->id;?>"> <button class="btn btn-warning edit" value="<?=$stock->id?>">EDIT</button> </a> </td>
							</tr>
						<?php }
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	
	<div id="myModalSuccess" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Success</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12" style="color: green; font-size: 18px;">
							Data Successfully Save!!
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default wheel-first" data-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>
	
	
	<div id="myModalError" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Error</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12" style="color: red; font-size: 18px;" id="errormsg"></div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	
	<div id="getBulkTransaferResponce" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Bulk Transfer Detail</h4>
				</div>
				<div class="modal-body">
					<div class="row" id="getvalueTransferPopup">
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<br /><br /><br />
	<a style="width: 100px;" href="<?= base_url('Store/transfer_stocks') ?>" class="btn btn-primary">Back</a>
</div>

<script>
    $(document).ready(function () {

	$('.table').delegate('.ViewMoreDetail','click',function(){
			var id = $(this).attr('id');
			
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Store/getBulkTransaferStockDetail",
				data: {id: id},
				dataType: 'JSON',
				success:function(data){
					$('#getvalueTransferPopup').html(data.success);
					$('#getBulkTransaferResponce').modal('show');
				}
			});
	});


	$('#bulk_product_item').change(function(){
		var productcode = $(this).val();
		if(productcode != "")
		{
			var product_name = $("#bulk_product_item option:selected").text();
			$('#product_name').val(product_name);
		}
		else
		{
			$('#product_name').val('');
		}
	});

    });

    var $tabs = $('#myTab li');
    $('.wheel-left').on('click', function () {
        $tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
    });
	
    $('.wheel-right').on('click', function () {
    	  var wheelright1 = this.id;
		  if( wheelright1 == 'wheel-right1')
		  {
			  if($("#bulk_product_item").val() == "")
				{
					$("#errormsg").html("Please select bulk box");
					$('#myModalError').modal({backdrop: 'static', });
					$("#sendBtn").removeAttr("disabled"); 
					return false;
				}
				
			if($("#GoldGrade").val() == "")
				{
					$("#errormsg").html("Please Enter Gold Grade");
					$('#myModalError').modal({backdrop: 'static', });
					$("#sendBtn").removeAttr("disabled"); 
					return false;
				}	
			  if(!$('#GoldWeight').val())
				{
					$("#errormsg").html("Please select Product Weight");
					$('#myModalError').modal({backdrop: 'static', });
					$("#sendBtn").removeAttr("disabled"); 
					return false;
				}
		  }	
        $tabs.filter('.active').next('li').find('a[data-toggle="tab"]').tab('show');
    });
	
	$('.wheel-first').on('click', function () {
        $tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
        $tabs.filter('.active').prev('li').find('a[data-toggle="tab"]').tab('show');
    });

//get code
	
	
	$('#sendBtn').click(function (e) {
//		$("#sendBtn").attr("disabled", "disabled");
	});
	
    $('#TransferBulkItem').submit(function (e) {
        e.preventDefault();
		
		if(!$('#GoldWeight').val())
		{
			$("#errormsg").html("Please select Product Weight");
			$('#myModalError').modal({backdrop: 'static', });
			$("#sendBtn").removeAttr("disabled"); 
			return false;
		}

		if($("#GoldGrade").val() == "")
		{
			$("#errormsg").html("Please Enter Gold Grade");
			$('#myModalError').modal({backdrop: 'static', });
			$("#sendBtn").removeAttr("disabled"); 
			return false;
		}
		
		if($("#GoldWeight").val() == "")
		{
			$("#errormsg").html("Please Enter Gold Weight");
			$('#myModalError').modal({backdrop: 'static', });
			$("#sendBtn").removeAttr("disabled"); 
			return false;
		}
		
		if($("#bulk_product_item").val() == "")
		{
			$("#errormsg").html("Please select bulk box");
			$('#myModalError').modal({backdrop: 'static', });
			$("#sendBtn").removeAttr("disabled"); 
			return false;
		}

        var formData = new FormData();
        var contact = $(this).serializeArray();
        $.each(contact, function (key, input) {
            formData.append(input.name, input.value);
        });

        $.ajax({
            type: 'POST',
            url: "<?= base_url(); ?>Store/SubmitTransferStore",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'JSON',
            success: function (data)
            {
				subcategorySuccess();
				if(data.success)
				{
					$('#myModalSuccess').modal({backdrop: 'static', });
					$("#sendBtn").removeAttr("disabled");
					$('#getdataBulkItem').html(data.bulkvalue);
					$('#stores_transform_form_no').val(data.getTransFormNumber);
					$('#GoldWeight').val(''); //a3frt
				}
				else
				{
					$("#sendBtn").removeAttr("disabled"); 
					$("#errormsg").html("Something Went wrong");
					$('#myModalError').modal({backdrop: 'static', });
				}
            }
        });

    });

    $('.RealodModal').click(function (e) {
        location.reload();
    });

    $('#GoldGrade').change(function () {
        var grade_id = $('#GoldGrade').val();
        var grade_name = $('option:selected', this).attr('data-val');
        var gold_purity = $('option:selected', this).attr('data-status');
        $.ajax({
            type: 'POST',
            url: "<?= base_url() ?>Store/getGoldGrade",
            data: {grade_id: grade_id, grade_name: grade_name, gold_purity: gold_purity},
            dataType: 'JSON',
            success: function (data) {
                var finalval = parseFloat(data.CurrentPrice);
                $('#GoldGradeCurrentPrice').val(finalval.toFixed(2));
                allitemcall();
            }
        });
    });

    $('#getcatewiseSubcate').change(function () {
        subcategory();
    });

    function subcategory()
    {
        var category = $('#getcategorywiseSubcategoy').val();
        var sub_category = $('#getcatewiseSubcate').val();
        if (sub_category != "")
        {
            $.ajax({
                type: 'POST',
                url: "<?= base_url(); ?>Store/getProductCodeItem",
                data: {category: category, sub_category: sub_category},
                dataType: 'JSON',
                success: function (data) {
                    if (data.bulk_product_count == 0)
                    {
                        $('#myModalBulk').modal('show');
                    }
                    if (data.success)
                    {
                        $('#code').attr('readonly', true);
                    } else
                    {
                        $('#code').attr('readonly', false);
                    }
                    $('#code').val(data.code);
                    $('#product_num_id').val(data.product_num_id);
                    $('#profecctional_code').val(data.profecctional_code);
                    $('#changeNewdate').val(data.changeNewdate);
                    $('#bulk_product_item').html(data.product);
                }
            });
        }
    }
	
	
    function subcategorySuccess()
    {
        var category = $('#getcategorywiseSubcategoy').val();
        var sub_category = $('#getcatewiseSubcate').val();
        if (sub_category != "")
        {
            $.ajax({
                type: 'POST',
                url: "<?= base_url(); ?>Store/getProductCodeItem",
                data: {category: category, sub_category: sub_category},
                dataType: 'JSON',
                success: function (data) {
                    if (data.bulk_product_count == 0)
                    {
                        $('#myModalBulk').modal('show');
                    }
                    if (data.success)
                    {
                        $('#code').attr('readonly', true);
                    } else
                    {
                        $('#code').attr('readonly', false);
                    }
                    $('#code').val(data.code);
                    $('#product_num_id').val(data.product_num_id);
                    $('#profecctional_code').val(data.profecctional_code);
                    $('#changeNewdate').val(data.changeNewdate);
               $('#bulk_product_item').html(data.product);
                }
            });
        }
    }

    getOutletwiseStore();
    $('.getOutletwiseStore').change(function () {
        getOutletwiseStore();
    });

    function getOutletwiseStore()
    {
        var val = $('.getOutletwiseStore').val();

        $.ajax({
            type: 'POST',
            url: "<?= base_url() ?>Products/get_warehouse_outletwise_bulk",
            data: {val: val},
            dataType: 'JSON',
            success: function (data) {
                $('#getWareHouse').html(data.warehousedata);
            }
        });
    }
    $('#getcategorywiseSubcategoy').change(function () {
        getCategwiseSubcategy();
    });

    function getCategwiseSubcategy()
    {
        var cate_id = $('#getcategorywiseSubcategoy').val();

        $.ajax({
            type: 'POST',
            url: "<?= base_url() ?>Store/get_Category_wise_Subcategory",
            data: {cate_id: cate_id},
            dataType: 'JSON',
            success: function (data) {
                $('#getcatewiseSubcate').html(data.subcategory);
            }
        });
    }


    //cal
    $('.calallitem').keyup(function () {
        allitemcall();
    });

    $('.calallitem').blur(function () {
        allitemcall();
    });

	$('#Wastageperg').blur(function () {
        allitemcall();
    });
	
	$('#Wastageperg').keyup(function () {
        allitemcall();
    });
	

    function allitemcall()
    {
        var Wastagegold = 0;
        var GoldWeight = $('#GoldWeight').val();
        var StoneWeight = $('#StoneWeight').val();
        if (GoldWeight == "" || GoldWeight == 0)
        {
            GoldWeight = 0;
        }
        if (StoneWeight == "" || StoneWeight == 0)
        {
            StoneWeight = 0;
        }
        var NetGoldWeight = parseFloat(GoldWeight) - parseFloat(StoneWeight);
        $('#NetGoldWeight').val(NetGoldWeight.toFixed(3));

        var Wastageperg = $('#Wastageperg').val();
        if (Wastageperg == "" || Wastageperg == 0)
        {
            Wastageperg = 0;
        }

        if (NetGoldWeight != 0 && Wastageperg != 0)
        {
            var Wastagegold = (parseFloat(NetGoldWeight) / 8) * parseFloat(Wastageperg);
            $('#Wastagegold').val(Wastagegold.toFixed(4));
        } else
        {
            $('#Wastagegold').val('0');
        }

        var TotalGoldweight = parseFloat(NetGoldWeight) + parseFloat(Wastagegold);
        $('#TotalGoldweight').val(TotalGoldweight.toFixed(3));

        var GoldGradeCurrentPrice = $('#GoldGradeCurrentPrice').val();
        if (GoldGradeCurrentPrice == 0 && GoldGradeCurrentPrice == "")
        {
            var GoldGradeCurrentPrice = 0;
        }
        var TotalGoldCost = parseFloat(TotalGoldweight) * parseFloat(GoldGradeCurrentPrice);
        $('#TotalGoldCost').val(TotalGoldCost.toFixed(3));

        var StoneCost = $('#StoneCost').val();
        var LabourCost = $('#LabourCost').val();
        var OtherCost1 = $('#OtherCost1').val();
        var OtherCost2 = $('#OtherCost2').val();
        var OtherCost3 = $('#OtherCost3').val();
        if (StoneCost == "" || StoneCost == 0)
        {
            StoneCost = 0;
        }
        if (LabourCost == "" || LabourCost == 0)
        {
            LabourCost = 0;
        }
        if (OtherCost1 == "" || OtherCost1 == 0)
        {
            OtherCost1 = 0;
        }
        if (OtherCost2 == "" || OtherCost2 == 0)
        {
            OtherCost2 = 0;
        }
        if (OtherCost3 == "" || OtherCost3 == 0)
        {
            OtherCost3 = 0;
        }

        var TotalAllOtherCost = parseFloat(StoneCost) + parseFloat(LabourCost) + parseFloat(OtherCost1) + parseFloat(OtherCost2) + parseFloat(OtherCost3);
        $('#TotalAllOtherCost').val(TotalAllOtherCost.toFixed(2));

        var TransferredCost = parseFloat(TotalAllOtherCost) + parseFloat(TotalGoldCost);
        $('#TransferredCost').val(TransferredCost.toFixed(2));

    }

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
           order: [0, "desc"],
           responsive: true,

       });


</script>


