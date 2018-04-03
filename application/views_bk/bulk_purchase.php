<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet" />
<style>
	label.error
	{
		color:red;
	}
</style>


<script src="<?=base_url()?>assets/js/select2.min.js"></script>
<?php
$us_id = $this->session->userdata('user_id');
$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
$logged_name = $get_logged_name->fullname;
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-6">
			<h1 class="page-header">Bulk Purchase</h1>
		</div>
		<div class="col-lg-6" style="text-align: right;">
		
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form  id="Submitbulkinsert" action="<?=base_url()?>Purchase_order/SubmitBulkPurchase" method="post">
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
									<label>Purchase order No.</label>
									<input type="text" name="purachase_no" id="purachase_no" value="<?=$purchaseOrderNumber?>" class="form-control purachase_no" readonly="" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Outlet</label>
									<select class="form-control getOutletwiseStore" name="outlet" id="Outlet">
										<?php foreach($getoutlets as $outlet) { ?>
											<option value="<?=$outlet->id?>"><?=$outlet->name?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Store</label>
									<select  class="form-control" name="store" id="getWareHouseStore">
										<option value="">Select Store</option>
										
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Supplier </label>
									<select  class="form-control supplier" name="supplier" id="supplier">
										<option value="">Select Supplier</option>
										<?php foreach($getsuppliers as $viewsup) { ?>
										<option value="<?=$viewsup->id?>"><?=$viewsup->name?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Category</label>
									<select  name="category" required="" id="getCategorywisesubcateg" class="form-control getCategorywisesubcateg">
										<option value="">Select Category</option>
										<?php foreach($getcategory as $viewcat) { ?>
										<option value="<?=$viewcat->id?>"><?=$viewcat->name?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Sub Category</label>
									<select  required="" name="sub_category" id="getCategSubcategory" class="form-control sub_category">
										<option value="">Select Sub Category</option>
									
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Select Item</label>
									<select name="product_item"  required="" id="product_id" class="form-control SelectItem">
										<option value="">Select Item</option>
										
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Gold Grade</label>
									<select class="form-control" name="gold_grade" >
										<option value="">Select Grade</option>
										<?php
										foreach ($getGoldGradedata as $grade)
										{ ?>
										<option value="<?=$grade->grade_id?>"><?=$grade->grade_name?></option>
									<?php	}
										?>
									</select>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Price</label>
									<input type="text" name="total_price"  class="form-control changecal" id="total_price"   value="" />
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Qty</label>
									<input type="text" name="qty"  class="form-control changecal" id="qty"   value="" />
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Grand Total</label>
									<input type="text" name="grand_total" readonly=""  class="form-control " id="grand_total" placeholder=""  value="" />
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Purchase Bill No.</label>
									<input type="text" name="purchase_bill_no" class="form-control" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Note</label>
									<textarea name="note" class="form-control"></textarea>
								</div>
							</div>
							
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Created By</label>
									<input type="text" readonly="" name="createdby" class="form-control"  value="<?=!empty($logged_name)?$logged_name:''?>" />
								</div>
								
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<button style="margin-top: 23px;width: 100px;" class="btn btn-primary "  type="submit">Save</button> 
								</div>
							</div>
							
							
						</div>
						<br />
					</form>
				</div>
			</div>
			<a style="width: 100px;" href="<?=base_url()?>purchase_order/po_view" class="btn btn-primary">Back</a>
		</div>
	</div>
	<br /><br /><br />
	<div class="row" style="margin-top: 10px;">
		<div class="col-md-12  panel panel-default ">
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

<script src="<?= base_url(); ?>assets/js/jquery.validate.min.js"></script>	


<script>
	
	getOutletwiseStore();
	$('.SelectItem').change(function(){
			var product_id = $(this).val();
			if(product_id != "")
			{
				$.ajax({
				type:'POST',
				url:"<?=base_url()?>Purchase_order/getPurchasePrice",
				data: {product_id: product_id},
				dataType: 'JSON',
				success:function(data){
					$('#total_price').val(data.purchase_price);
					}
				});
			}
			else
			{
				$('#total_price').val('');
			}
			
	});
	
	
	$('.changecal').keyup(function(){
		var total_price = $('#total_price').val();
		var qty			= $('#qty').val();
		if(total_price == "")
		{
			total_price = 0;
		}
		if(qty == "")
		{
			qty = 0;
		}
		
		var grand = parseFloat(total_price) * parseFloat(qty);
		if(grand == "")
		{
			grand = 0;
		}
		$('#grand_total').val(grand);
		
	});
	
	$('.getOutletwiseStore').change(function(){
			getOutletwiseStore();
	});
	
	
	
	
	
	
	function getOutletwiseStore()
	{
		var outlet_id = $('#Outlet').val();
		$.ajax({
			type:'POST',
			url:"<?=base_url()?>Purchase_order/get_warehouse_outletwise_bulk",
			data: {outlet_id: outlet_id},
			dataType: 'JSON',
			success:function(data){
					$('#getWareHouseStore').html(data.warehousedata);
			}
		});
	}
	$('.getCategorywisesubcateg').change(function(){
			getCategwiseSubcategy();
	});
	
	function getCategwiseSubcategy()
	{
		var cate_id = $('#getCategorywisesubcateg').val();
	
		$.ajax({
			type:'POST',
			url:"<?=base_url()?>Purchase_order/get_Category_wise_Subcategory",
			data: {cate_id: cate_id},
			dataType: 'JSON',
			success:function(data){
					$('#getCategSubcategory').html(data.subcategory);
			}
		});
	}
	
	$('#getCategSubcategory').change(function(){
		subcategorywiseItem();
	});
	
	function subcategorywiseItem()
	{
		var category = $('#getCategorywisesubcateg').val();
		var sub_category = $('#getCategSubcategory').val();
		if(sub_category != "")
		{
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Purchase_order/getsubcategorywiseProductItem",
				data: {category: category,sub_category:sub_category},
				dataType: 'JSON',
				success:function(data){
					if(data.bulk_product_count == 0)
					{
						$('#myModalBulk').modal('show');
					}
					$('#product_id').html(data.products);

				}
			});
		}
	}
	
	
	
	
	
	
$(function() {
	  
	$("#Submitbulkinsert").validate({
	  rules: {
			Outlet: "required",
			store: "required",
			qty: "required",
			category: "required",
			product_item: "required",
			gold_grade: {
				required: true,
				number: true,
			},
			total_price: {
				required: true,
				number: true,
			}
		},
		messages: {
			Outlet: "Please select outlet",
			store: "Please select store",
			category: "Please select category",
			product_item: "Please select item",
			gold_grade: {
				required: "Please enter gold grade",
				number: "Please provide a Numeric value",
			},
			total_price: {
				required: "Please enter total price",
				number: "Please provide a Numeric value",
			},
			
		},

		submitHandler: function(form) {
			var formData = $("#Submitbulkinsert").serialize();
			$.ajax({
				url: form.action,
				type: form.method,
				data: formData,
				dataType: "json",
				success: function(data) {
					if(data.success)
					{

						window.location.href='<?=base_url();?>purchase_order/po_view';
					}
					else
					{
						alert('Due to some error please try again!!');
						location.reaload();
					}
				}            
			});
		}
	});
	

});

	
	

</script>

