<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet" />
<script src="<?=base_url()?>assets/js/select2.min.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-6">
			<h1 class="page-header">Transfer Items</h1>
		</div>
		<div class="col-lg-6" style="text-align: right;">
			<a style="margin-top: 23px;" class="btn btn-primary" href="<?=base_url()?>Store/transfer_bulk_item" >Transfer Bulk Item</a> 
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form  id="Submittransgoldproduct" method="post">
						<div id="message" class="message text-center"></div>
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Date</label>
									<input type="text" id="date_data" name="date" class="form-control" readonly="" value="<?=date('Y-m-d H:i:s');?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Stores Transfer From No.</label>
									<input type="text" name="stores_transform_form_no" id="stores_transform_form_no" class="form-control" readonly="" value="<?=$getTransFormNumber?>" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Outlet</label>
									<select class="form-control Outlet" id="Outlet">
										<option value="">Select Outlet</option>
										<?php
											foreach ($getOutlets as $outlet)
											{ ?>
												<option data-val="<?=$outlet->name?>" value="<?=$outlet->id?>"><?=$outlet->name?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>From Store</label>
									<select  class="form-control FromStore">
										<option value="">Select From Store</option>
										<?php
											foreach ($getStore as $store)
											{ ?>
												<option value="<?=$store->s_id?>"><?=$store->s_name?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>To Store</label>
									<select  class="form-control ToStore">
										<option value="">Select To Store</option>
										<?php
											foreach ($getStore as $store)
											{ ?>
												<option value="<?=$store->s_id?>"><?=$store->s_name?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Item</label>
									<select  required="" id="product_id" class="form-control SelectItem">
										<option value="">Enter name / code</option>
										<?php
											foreach ($getProduct as $product)
											{ ?>
												<option value="<?=$product->code?>" data-weight="<?= $product->weight?>"><?=$product->name?> [<?=$product->code?>]</option>
										<?php }
										?>
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>In Stock</label>
									<input type="text"  class="form-control InStock" readonly="" placeholder="0" value="" />
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Qty</label>
									<input type="text"   class="form-control Qty" placeholder="0"  value="" />
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<button style="margin-top: 23px;" class="btn btn-primary addStansferStock" type="button">Add</button> 
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<button style="margin-top: 23px;" class="btn btn-primary add_item_popup" type="button">Transfer Bulk Item</button> 
								</div>
							</div>
							
						</div>
						<br />
						<div class="table-responsive">
							<table class="table" >
								<thead>
									<tr>
										<th width="10%">Date & Time</th>
										<th width="7%">Transfer From No.</th>
										<th width="8%">Outlet</th>
										<th width="8%">Code</th>
										<th width="13%">Products</th>
										<th width="13%">In Stock</th>
										<th width="8%">Cost</th>
										<th width="8%">Qty</th>
										<th width="8%">Product Weight</th>
										<th width="13%">Sub Cost</th>
										<th width="15%">Action</th>
									</tr>
								</thead>
								<tbody>
									
									<tr id="getTransferStockInfo">
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td><b>Total Cost:</b></td>
										<td colspan="2"><input id="TotalCost" readonly="" type="text" value="0" class="form-control"></td>
									</tr>
								</tbody>
							</table>
						</div>
							<div class="row">
							<div class="col-md-4">
								<div class="form-group ">
									<button style="width: 150px;" type="button" class="btn btn-primary SaveFormTransfer">Save</button>
								</div>
							</div>
							<div class="col-md-6"></div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Created By</label>
									<input type="text" readonly="" name="createdby" class="form-control"  value="<?=!empty($UserLoginName)?$UserLoginName:''?>" />
								</div>
								
							</div>
						</div>
					</form>
				</div>
			</div>
			<a style="width: 100px;" href="<?=base_url('Store/transfer_stocks')?>" class="btn btn-primary">Back</a>
		</div>
	</div>
	<br /><br /><br />
	<div class="row" style="margin-top: 10px;">
		<div class="col-md-12  panel panel-default ">
		</div>
	</div>
</div>


<!--make payment-->
<style>
	.bulkdialog{
		width:60%;
		margin: auto;
	}
</style>
<div id="showPopupadd_item" class="modal fade"> 
        <div class="modal-dialog bulkdialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #5fc509;">
					<h3 class="modal-title" style="color: #FFF; text-align: center;"  >Transfer Bulk Item</h3>
				</div>
				<form action="" method="post" id="TransferBulkItem">
					<div class="modal-body" style="overflow: visible; background-color: #FFF;">
						<div class="row">
							<div class="col-lg-12 ">
								<div class="col-lg-2 ">
										<div class="form-group">
											<label>Ref. Number</label>
											<input type="text" name="" id="" class="form-control" readonly="" value="<?=$getTransFormNumber?>" />
										</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label>Date & Time</label>
										<input type="text" id="" name="add_new_date" class="form-control" readonly="" value="<?=date('Y-m-d H:i:s');?>" />
									</div>
								</div>
								<div class="col-lg-2 ">
									<div class="form-group">
											<label>Outlet</label>
											<select class="form-control getOutletwiseStore" required="" name="outlet_id" id="Outlet">
												<?php
													foreach ($getOutlets as $outlet)
													{ ?>
														<option data-val="<?=$outlet->name?>" value="<?=$outlet->id?>"><?=$outlet->name?></option>
												<?php }
												?>
											</select>
									</div>
								</div>
								
								<div class="col-lg-2 ">
									<div class="form-group">
											<label>Store</label>
											<select class="form-control Store" required="" name="store_id" id="getWareHouse">
												<option value="">Select Store</option>
											</select>
									</div>
								</div>
								
								<div class="col-lg-3 ">
									<div class="form-group">
										<label>Category</label>
										<select class="form-control 
												"  required name="category" id="category">
											<?php
											foreach ($getCategory as $category)
											{ ?>
												<option value="<?=$category->id?>"><?=$category->name?></option>
											<?php 
											}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12 ">
								<div class="col-lg-2 ">
									<div class="form-group">
										<label>Sub Category</label>
										<select class="form-control sub_category" required name="sub_category" id="sub_category">
											<option value="">Select Sub Category</option>
										</select>
									</div>
								</div>

								<div class="col-lg-2">
									<div class="form-group">
										<label>Select Item</label>
										<select class="form-control" required name="bulk_product_item" id="bulk_product_item">
											<option value="">Select Item</option>
										</select>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label>Product Code</label>
										<input type="text" required id="code" name="code" class="form-control" />
										<input  type="hidden" name="product_num_id"	    id="product_num_id" />
										<input  type="hidden" name="profecctional_code"	id="profecctional_code" />
										<input  type="hidden" name="changeNewdate"		id="changeNewdate" /> 
									</div>
								</div>
								<div class="col-lg-3 ">
									<div class="form-group">
										<label>Product Name</label>
										<input type="text" required id="" name="product_name" class="form-control" />
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Gold Grade</label>
										<select required class="form-control" name="grade_id" id="GoldGrade">
										<option value="">Select Gold Grade</option>
											<?php
												foreach ($getGoldGrade as $Ggrade)
												{ ?>
										<option data-val="<?=$Ggrade->grade_name?>" data-status="<?=$Ggrade->gold_purity?>" value="<?=$Ggrade->grade_id?>"><?=$Ggrade->grade_name?></option>
												<?php 
												}
											?>
										</select>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12 ">

								<div class="col-lg-2">
									<div class="form-group">
										<label>Gold Weight(g)</label>
										<input type="text" id="GoldWeight" required name="GoldWeight" class="form-control calallitem" />
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<label>Stone Weight</label>
										<input type="text" id="StoneWeight" required name="StoneWeight" class="form-control calallitem" />
									</div>
								</div>
								<div class="col-lg-3 ">
									<div class="form-group">
										<label>Net Gold Weight (g)</label>
										<input type="text" id="NetGoldWeight" readonly="" name="NetGoldWeight" class="form-control" />
									</div>
								</div>
								<div class="col-lg-3 ">
									<div class="form-group">
										<label>Wastage (g) per 8 g</label>
										<input type="text" id="Wastageperg" required name="Wastageperg" class="form-control calallitem" />
									</div>
								</div>
								<div class="col-lg-2 ">
									<div class="form-group">
										<label>Wastage gold (g)</label>
										<input type="text" readonly="" id="Wastagegold" name="Wastagegold" class="form-control" />
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12 ">
								<div class="col-lg-3 ">
									<div class="form-group">
										<label>Stone Cost</label>
										<input type="text" id="StoneCost" name="StoneCost" class="form-control calallitem"  />
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label>Labour Cost</label>
										<input type="text" id="LabourCost" name="LabourCost" class="form-control calallitem" />
									</div>
								</div>
								<div class="col-lg-2 ">
									<div class="form-group">
										<label>Other Cost 1</label>
										<input type="text" id="OtherCost1" name="OtherCost1" class="form-control calallitem" />
									</div>
								</div>
								<div class="col-lg-2 ">
									<div class="form-group">
										<label>Other Cost 2</label>
										<input type="text" id="OtherCost2" name="OtherCost2" class="form-control calallitem" />
									</div>
								</div>
								<div class="col-lg-2 ">
									<div class="form-group">
										<label>Other Cost 3</label>
										<input type="text" id="OtherCost3" name="OtherCost3" class="form-control calallitem" />
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12 ">
								<div class="col-lg-3">
									<div class="form-group">
										<label>Total Gold Weight(g)</label>
										<input type="text" id="TotalGoldweight" readonly="" name="TotalGoldweight" class="form-control" />
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label>Gold Grade Current Price</label>
										<input type="text" id="GoldGradeCurrentPrice" readonly name="GoldGradeCurrentPrice" class="form-control" />
									</div>
								</div>

								<div class="col-md-2">
									<label >Total Gold Cost</label>
										<input type="text" id="TotalGoldCost" readonly name="TotalGoldCost" class="form-control" />
								</div>
								<div class="col-md-2">
									<label>Total All Other Cost</label>
										<input type="text" id="TotalAllOtherCost" readonly name="TotalAllOtherCost" class="form-control" />
								</div>
								<div class="col-md-2">
									<label>Transferred Cost</label>
									<input type="text" id="TransferredCost" name="TransferredCost" readonly class="form-control" />
								</div>
							</div>
						</div>




					</div>

					<div class="modal-footer" style="margin-right: 50px;">
						<div class="row">
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
							<div class="col-md-7">
								<div class="form-group" style="text-align: left;">
									<label>Note </label>
									<textarea name="note" class="form-control" ></textarea>
								</div>
							</div>
							<div class="col-md-2" style="padding-top: 3%;">
								<button type="submit" onclick="" name="sendBtn" class="btn btn-success" id="sendBtn" >Submit</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>


<!--end make payment-->
<!--//main other conform message-->
		<div class="message-box animated fadeIn transfer_item_popup" data-sound="alert" id="mb-signout">
			<div class="mb-container">
				<div class="mb-middle">
					<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
					<div class="mb-content">
						<p>Are you sure you want to Remove?</p>                    
						<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
						<input type="hidden" id="remove_id" >
						<input type="hidden" id="sub_total" >
						<input type="hidden" id="total_cost" >
					</div>
					<div class="mb-footer">
						<div class="pull-right">
							<a id="remove_row" class="btn btn-success btn-lg transfer_item_remove_row" data-dismiss="modal">Yes</a>
							<button class="btn btn-default btn-lg mb-control-close" >No</button>
						</div>
					</div>
				</div>
			</div>
		</div>



	<div id="myModalBulk" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Error</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12" style="color: red; font-size: 18px;">
							Bulk item not found Please add first Bulk item !!
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div id="myModalSuccess" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
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
					<button type="button" class="btn btn-primary RealodModal" >Ok</button>
				</div>
			</div>
		</div>
	</div>



<script type="text/javascript">
	
$('document').ready(function(){
	
	$('body').delegate('.add_item_popup','click',function(){
		$('#showPopupadd_item').modal('show');
	});
	
	$('.RealodModal').click(function(e){
		location.reload();
	});
		
	$('#TransferBulkItem').submit(function(e){
			e.preventDefault();
			var formData = new FormData();
			var contact = $(this).serializeArray();
			$.each(contact, function (key, input) {
				formData.append(input.name, input.value);
			});
		
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Store/SubmitTransferStore",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				success:function(data)
				{
					$('#myModalSuccess').modal({backdrop: 'static',});
				}
		});
		
	});

	
	$('.getOutletwiseStore').change(function(){
			getOutletwiseStore();
	});
	
	function getOutletwiseStore()
	{
		var val = $('.getOutletwiseStore').val();
		
		$.ajax({
			type:'POST',
			url:"<?=base_url()?>Products/get_warehouse_outletwise_bulk",
			data: {val: val},
			dataType: 'JSON',
			success:function(data){
					$('#getWareHouse').html(data.warehousedata);
				}
		});
	}
	
	getOutletwiseStore();
	
	$('#GoldGrade').change(function(){
		var grade_id		= $('#GoldGrade').val();
		var grade_name		= $('option:selected', this).attr('data-val');
		var gold_purity	= $('option:selected', this).attr('data-status');
		$.ajax({
			type:'POST',
			url:"<?=base_url()?>Store/getGoldGrade",
			data: {grade_id: grade_id,grade_name:grade_name,gold_purity:gold_purity},
			dataType: 'JSON',
			success:function(data){
				var finalval = parseFloat(data.CurrentPrice);
				$('#GoldGradeCurrentPrice').val(finalval.toFixed(2));
				allitemcall();
			}
		});
		
	});
	
	
	$('.calallitem').keyup(function(){
		allitemcall();
	});
	
	$('.calallitem').blur(function(){
		allitemcall();
	});
	
	
	function allitemcall()
	{
		var Wastagegold = 0;
		var GoldWeight = $('#GoldWeight').val();
		var StoneWeight = $('#StoneWeight').val();
		if(GoldWeight == "" || GoldWeight == 0)
		{
			GoldWeight = 0;
		}
		if(StoneWeight == "" || StoneWeight == 0)
		{
			StoneWeight = 0;
		}
		var NetGoldWeight  = parseFloat(GoldWeight) - parseFloat(StoneWeight);
		$('#NetGoldWeight').val(NetGoldWeight.toFixed(2));
		
		var Wastageperg = $('#Wastageperg').val();
		if(Wastageperg == "" || Wastageperg == 0)
		{
			Wastageperg = 0;
		}
		
		if(NetGoldWeight != 0  && Wastageperg != 0)
		{
			var Wastagegold = (parseFloat(NetGoldWeight) / 8) * parseFloat(Wastageperg);
			$('#Wastagegold').val(Wastagegold.toFixed(2));
		}
		else
		{
			$('#Wastagegold').val('0');	
		}
		
		var TotalGoldweight = parseFloat(NetGoldWeight) + parseFloat(Wastagegold);
		$('#TotalGoldweight').val(TotalGoldweight.toFixed(2));	
		
		var GoldGradeCurrentPrice = $('#GoldGradeCurrentPrice').val();
		if(GoldGradeCurrentPrice == 0  && GoldGradeCurrentPrice == "")
		{
			var GoldGradeCurrentPrice = 0;
		}
		var TotalGoldCost = parseFloat(TotalGoldweight) * parseFloat(GoldGradeCurrentPrice);
		$('#TotalGoldCost').val(TotalGoldCost.toFixed(2));
		
		var StoneCost = $('#StoneCost').val();
		var LabourCost = $('#LabourCost').val();
		var OtherCost1 = $('#OtherCost1').val();
		var OtherCost2 = $('#OtherCost2').val();
		var OtherCost3 = $('#OtherCost3').val();
		if(StoneCost == "" || StoneCost == 0)
		{
			StoneCost = 0;
		}
		if(LabourCost == "" || LabourCost == 0)
		{
			LabourCost = 0;
		}
		if(OtherCost1 == "" || OtherCost1 == 0)
		{
			OtherCost1 = 0;
		}
		if(OtherCost2 == "" || OtherCost2 == 0)
		{
			OtherCost2 = 0;
		}
		if(OtherCost3 == "" || OtherCost3 == 0)
		{
			OtherCost3 = 0;
		}
		
		var TotalAllOtherCost = parseFloat(StoneCost)+parseFloat(LabourCost)+parseFloat(OtherCost1)+parseFloat(OtherCost2)+parseFloat(OtherCost3);
		$('#TotalAllOtherCost').val(TotalAllOtherCost.toFixed(2));
		
		var TransferredCost = parseFloat(TotalAllOtherCost) +  parseFloat(TotalGoldCost);
		$('#TransferredCost').val(TransferredCost.toFixed(2));
	}
	
		
	$('#sub_category').change(function(){
		subcategory();
	});
	
		function subcategory()
		{
			var category = $('#category').val();
			var sub_category = $('#sub_category').val();
			if(sub_category != "")
			{
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>Store/getProductCodeItem",
					data: {category: category,sub_category:sub_category},
					dataType: 'JSON',
					success:function(data){
						if(data.bulk_product_count == 0)
						{
							$('#myModalBulk').modal('show');
						}
						if(data.success)
						{
							$('#code').attr('readonly', true);	
						}
						else
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
			else
			{
				$('#code').val('');
				$('#product_num_id').val('');
				$('#profecctional_code').val('');
				$('#changeNewdate').val('');
				$('#code').attr('readonly', false);
			}
		}
		
		
		$('.category').change(function(){
			categoryChange();
		})
		categoryChange();
		function categoryChange(){
			
			$('#code').val('');
			$('#product_num_id').val('');
			$('#profecctional_code').val('');
			$('#changeNewdate').val('');
			$('#code').attr('readonly', false);
			
			var category_id = $('.category').val();
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Store/categorywiseSubcategory",
				data: {category_id: category_id},
				dataType: 'JSON',
				success:function(data){
					$('.sub_category').html(data.getSubcategory);
					subcategory();
				}
			});	
		}
		
		
		
		$('#product_id').select2();
		
		$('.SaveFormTransfer').click(function(e){
			e.preventDefault();
			var TotalCost = $('#TotalCost').val();
			if(parseFloat(TotalCost) == 0 || TotalCost == "")
			{
				alert('Total Cost now Zero please check!!'); 
			}
			else
			{
				var formData = new FormData();
				var transfer = $('#Submittransgoldproduct').serializeArray();
				$.each(transfer, function (key, input) {
					formData.append(input.name, input.value);
				});
				

				$.ajax({
					type:'POST',
					url:"<?=base_url();?>Store/SubmitTransformStore",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'JSON',
					success:function(data){
						if(data.success)
						{
							alert('Stock Transform Successfully!!');
							window.location.href='<?=base_url()?>Store/transfer_stocks';
						}
						else
						{
							alert('Due to some Error Please try again!!');
							location.reload();
						}
					}
				});	
			}
		});
		
		$('.SelectItem').change(function(){
				var outlet_id = $('.Outlet').val();
				
				var fromwarehouse = $('.FromStore').val();
				if(outlet_id == "")
				{
					alert('Please Select Outlet!!');
				}
				else if(fromwarehouse == "" )
				{
					alert('Select From Store!!');
				}
				else
				{
					var product_code = $(this).val();
					if(product_code != "")
					{
						var FromStore_warehouse = $('.FromStore option:selected').attr('data-val');

						$.ajax({
							type:'POST',
							url:"<?=base_url()?>Store/InStockInventory",
							data: {product_code: product_code,outlet_id:outlet_id,FromStore_warehouse:FromStore_warehouse},
							dataType: 'JSON',
							success:function(data){
								if(data.InStock == 0)
								{
									alert('Stock not available!!');
									$('.InStock').val('0');
								}
								else
								{
									$('.InStock').val(data.InStock);
								}
							}
						});	
					}
					else
					{
						$('.InStock').val('0');
					}
				}
		});
		
		var item_row = 1;
		
		$('.addStansferStock').click(function(){
			var qty = $('.Qty').val();
			var product_code = $('.SelectItem').val();
			var instock = $('.InStock').val();
			
			var FromStore_warehouse = $('.FromStore option:selected').attr('data-val');
			var toStore_warehouse = $('.ToStore option:selected').attr('data-val');
			
			var from_store = $('.FromStore').val();
			var to_store = $('.ToStore').val();
			
			var outlet_id = $('.Outlet').val();
			var outlet_name = $('.Outlet option:selected').attr('data-val');
			var product_weight = $('.SelectItem option:selected').attr('data-weight');
			var tranferform_no=$('#stores_transform_form_no').val();
			var date_timea =$('#date_data').val();
			if(product_code == "")
			{
				alert('Please Select Item!!');
			}
			else if(qty == 0 || qty == "")
			{
				alert('Please Enter Qty!!');
			}
			else if(parseFloat(instock) < parseFloat(qty))
			{
				alert('Out of Stock!!'); 
				$('.Qty').val('0');
			}
			else
			{
				$.ajax({
						type:'POST',
						url:"<?=base_url()?>Store/getProductPurchasePrice",
						data: {product_code: product_code},
						dataType: 'JSON',
						success:function(data){
							var subtotal =  (parseFloat(data.price) * parseFloat(qty)).toFixed();
							var html = '<tr id="DeleteRow'+item_row+'" >\n\
										<td>'+date_timea+'</td>\n\
										<td>'+tranferform_no+'</td>\n\
										<td>'+outlet_name+'</td>\n\
										<td>'+product_code+' <input value='+product_code+' class="form-control" name="transfer['+item_row+'][product_code]" type="hidden">\n\
														<input value='+FromStore_warehouse+' class="form-control" name="transfer['+item_row+'][FromStore_warehouse]" type="hidden">\n\
														<input value='+toStore_warehouse+' class="form-control" name="transfer['+item_row+'][toStore_warehouse]" type="hidden">\n\
														<input value='+outlet_id+' class="form-control" name="transfer['+item_row+'][outlet_id]" type="hidden">\n\
														<input value='+from_store+' class="form-control" name="transfer['+item_row+'][from_store]" type="hidden">\n\
														<input value='+to_store+' class="form-control" name="transfer['+item_row+'][to_store]" type="hidden"></td>\n\
										<td>'+data.name+'       <input value='+data.name+' class="form-control" name="transfer['+item_row+'][product_name]" type="hidden"> </td>\n\
										<td>'+instock+'         <input value='+instock+' class="form-control" name="transfer['+item_row+'][instock]" type="hidden"> </td>\n\
										<td>'+data.price+'      <input value='+data.price+' class="form-control" name="transfer['+item_row+'][price]" type="hidden"> </td>\n\
										<td>'+qty+'             <input value='+qty+'  class="form-control" name="transfer['+item_row+'][qty]" type="hidden"> </td>\n\
										<td>'+product_weight+'  <input value='+product_weight+'  class="form-control" name="transfer['+item_row+'][product_weight]" type="hidden"> </td>\n\
										<td>'+subtotal+'        <input value='+subtotal+'  class="form-control" name="transfer['+item_row+'][subtotal]" type="hidden"> </td>\n\
										<td><i class="glyphicon glyphicon-remove-sign RemoveRow"  id='+item_row+' data-val='+subtotal+' style="color: red; cursor: pointer; font-size: 28px;"></i></td>\n\
										</tr>\n\
										';
							$('#getTransferStockInfo').before(html);
							var TotalCost = $('#TotalCost').val();
							var FinalCost  = parseFloat(TotalCost) + parseFloat(subtotal);
							$('#TotalCost').val(FinalCost);
							$('.Outlet').val('');
							$('.Qty').val('0');
							$('.InStock').val('0');
							outlet();
							item_row++;
						}
				});	
			}
		});
		
		
		
		
		$('body').delegate('.RemoveRow','click',function(){
				var id = $(this).attr('id');
				var subtotal = $(this).attr('data-val');
				var TotalCost = $('#TotalCost').val();
				$('#remove_id').val(id);
				$('#sub_total').val(subtotal);
				$('#total_cost').val(TotalCost);
				$('.transfer_item_popup').modal('show');
				
		});
		
		$('.transfer_item_remove_row').click(function(){
		var id = $('#remove_id').val();
		var subtotal = $('#sub_total').val();
		var TotalCost = $('#total_cost').val();
		var FinalCost  = parseFloat(TotalCost) - parseFloat(subtotal);
		$('#TotalCost').val(FinalCost);
		$('#DeleteRow'+id).remove();
		$('.transfer_item_popup').modal('hide');
	
	});
		
		
		$('.FromStore').change(function(){
			var outlet_id = $('.Outlet').val();
			if(outlet_id == "")
			{
				alert('Please Select Outlet!!');
			}
			else
			{
				var storeid = $(this).val();
				$.ajax({
					type:'POST',
					url:"<?=base_url()?>Store/FromStore",
					data: {storeid: storeid,outlet_id:outlet_id},
					dataType: 'JSON',
					success:function(data){
						$('.ToStore').html(data.toStore);
					}
				});	
			}
		});
		
		$('.Outlet').change(function(){
			outlet();
		});
		
		function outlet()
		{
			var outlet_id = $('.Outlet').val();
			$.ajax({
				type:'POST',
				url:"<?=base_url()?>Store/OutletWiseProductStore",
				data: {outlet_id: outlet_id},
				dataType: 'JSON',
				success:function(data){
					$('.ToStore').html(data.store);
					$('.FromStore').html(data.store);
					$('#product_id').html(data.product);
					$('#product_id').select2();
				}
			});
		}
		
	});
</script>






