<?php
require_once 'includes/header.php';
?>
<script src="<?=base_url();?>assets/datatable/jquery-ui.js"></script>

<style type="text/css">
    .fileUpload {
        position: relative;
        overflow: hidden;
        border-radius: 0px;
        margin-left: -4px;
        margin-top: -2px;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .typeahead, .tt-query, .tt-hint {
        border: 1px solid #CCCCCC;
        border-radius: 4px;
        font-size: 14px;
        height: 40px;
        line-height: 30px;
        outline: medium none;
        padding: 8px 12px;
        width: 360px;
    }
    .typeahead {
        background-color: #FFFFFF;
    }
    .typeahead:focus {
        border: 2px solid #0097CF;
    }
    .tt-query {
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    }
    .tt-hint {
        color: #999999;
    }
    .tt-dropdown-menu {
        background-color: #FFFFFF;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        margin-top: 0px;
        padding: 8px 0;
        width: 360px;
    }
    .tt-suggestion {
        font-size: 14px;
        line-height: 24px;
        padding: 3px 20px;
    }
    .tt-suggestion.tt-is-under-cursor {
        background-color: #0097CF;
        color: #FFFFFF;
    }
    .tt-suggestion p {
        margin: 0;
    }
	
	.greencolor
	{
		background-color: rgb(222, 164, 91) !important;
		border-color: rgb(222, 164, 91) !important;
	}
	
	
</style>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Receive Purchase Order </h1>
        </div>
    </div>

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
                                    <label>Purchase Order Number <span style="color: #F00">*</span></label><br />
                                    <?=!empty($getPurchase->po_number)?$getPurchase->po_number:'';?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Outlet <span style="color: #F00">*</span></label>
                                    <br />
                                    <?=!empty($getPurchase->outlet_name)?$getPurchase->outlet_name:'';?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Supplier <span style="color: #F00">*</span></label>
                                    <br />
                                    <?=!empty($getPurchase->supplier_name) ? $getPurchase->supplier_name : '';?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Purchase Order Date <span style="color: #F00">*</span></label>
                                    <br />
									<?=!empty($getPurchase->created_datetime) ? date($dateformat.' H:i:s',strtotime($getPurchase->created_datetime)) : '';?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Note</label>
                                    <br />
                                    
									<?=!empty($getPurchase->note)?$getPurchase->note:'';?>
                                </div>
                            </div>
                            <div class="col-md-4">
								<div class="form-group">
									<label>Purchase Bill No.</label>
									<input type="text" name="" class="form-control" style="width:200px;" value="" id="purchase_bill_no"/>
								</div>								
							</div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group" style="color: #c72a25;">
                                    <label>Purchase Order Status <span style="color: #F00">*</span></label>
                                    <br />
                                    <?=!empty($getPurchase->statusname)?$getPurchase->statusname:'';?>
                                </div>
                            </div>
                            <div class="col-md-8"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" style="border-top: 1px solid #ccc;"></div>
                        </div>
						
						<div style="color: #000000;font-size: 16px; margin-top: 10px;margin-bottom:10px;">Products</div>
						<div class="row" style="margin-top: 7px;">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table" id="items">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Products</th>
                                            <th>Price</th>
                                            <th>In Stock</th>
                                            <th>Qty</th>
                                            <th>Bonus Qty</th>
											<th>Discount %</th>
                                            <th>Tax</th>
                                            <th>Sub Total</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
										<tbody>
											<?php
											$totalinventory = 0;
											$discount_amount = 0;
											$totaltax = 0;
											$discount_percentage = 0;
											foreach ($getPurchaseItem as $inventory)
											{
												$totalinventory = $totalinventory + $inventory->subTotal;
												$totaltax = $totaltax + $inventory->tax;
												$discount_amount = $discount_amount + $inventory->discount_amount;
												$discount_percentage = $discount_percentage + $inventory->discount_percentage;
											?>
											
											<tr  id="item_row_<?=$inventory->id;?>" class="dynamic_row">
												<td><?=$inventory->product_code?></td>
												<td><?=$inventory->name?></td>
												<td><input id="rate<?=$inventory->id;?>"  readonly="" style="width: 106px;" class="form-control rate" type="text" value="<?=$inventory->purchase_price?>" /></td>
												<td><?=$inventory->instock?></td>
												<td><input id="qty<?=$inventory->id;?>" style="width: 75px;" class="form-control pcs" type="text" placeholder="0" value="<?=!empty($inventory->ordered_qty)?$inventory->ordered_qty:'';?>" /></td>
												<td><input id="bonusqty<?=$inventory->id;?>" style="width: 75px;" class="form-control bonusqty" type="text" placeholder="0" value="<?=!empty($inventory->bonusqty)?$inventory->bonusqty:'';?>" /></td>
												<td><input id="discount<?=$inventory->id;?>" style="width: 75px;" class="form-control discount" type="text" placeholder="0" value="<?=!empty($inventory->discount_percentage)?$inventory->discount_percentage:''; ?>">
													<input id="discount_amount<?=$inventory->id;?>" style="width: 75px;" class="form-control discount_amount" type="hidden" value="<?=$inventory->discount_amount?>" />
												</td>
												<td><input id="tax<?=$inventory->id;?>" style="width: 75px;" class="form-control tax" type="text" placeholder="0" value="<?=!empty($inventory->tax)?$inventory->tax:''; ?>" /></td>
												
												<td><span id="net_amount<?=$inventory->id;?>" class="net_amount"><?=$inventory->subTotal?></span></td>
												<td><button class="btn btn-primary updatePurchaseStock" data-val="" id="<?=$inventory->id;?>">Update</button></td>
											<tr>
											<?php }?>
											<tr>
												<td colspan="7">&nbsp;</td>
												<td><b>Grand Total Price :</b></td>
												<td><span id="total_net"><?=number_format($totalinventory,2); ?></td>
												<td>
													<input type="hidden" value="<?=$totaltax?>" id="totaltax">
													<input type="hidden" value="<?=$id?>" id="mainidpurchaseid">
													<input type="hidden" value="<?=$discount_percentage?>" id="discount_percent">
													<input type="hidden" value="<?=$discount_amount?>" id="discount_amount"></td>
												</tr>
										</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
						
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="hidden" id="rowcount" name="rowcount" value="1" />
                                    <button class="btn btn-primary"  id="btncl">Click Here To Distribute to the warehouses</button>
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4"></div>
                        </div>
													
						<div class="col-md-6 col-lg-6 col-sm-12"  id="dist" style="display: none;">
                            <table class="table table-bordered table-responsive">
                                <thead>
									<tr>
										<th width="60%">Product</th>
										<th width="20%">Ordered Quantity</th>
										<th width="20%">Distribute To Warehouse</th>
									</tr>
                                </thead>
                                <tbody>
								<?php 
									$totalOrderqty = 0;
									foreach ($getPurchaseItem as $value)
									{ 
										$totalOrderqty = $totalOrderqty + $value->ordered_qty + $value->bonusqty; 
										?>
										<tr>
											<td><?=$value->name?></td>
											<td><?=$value->ordered_qty + $value->bonusqty?></td>
											<td>
												<?php
												if($value->warehouse_tank_status == 0)
												{
												?>
												<span id="warehouse_tank<?=$value->id?>">
													<button data-purchase="<?=$value->id?>" data-qty="<?=$value->ordered_qty+ $value->bonusqty?>" data-val="<?=$value->name?>" id="<?=$value->product_code?>" type="button" class="btn btn-small btn-info WareHouseTank" ><i class="fa fa-arrow-circle-right" style="font-size: 20px;" aria-hidden="true"></i></button>
												</span>
												<?php 
												}
												else
												{
													echo "Distributed";
												}
												?>
											</td>
										</tr>
								<?php }
								?>	
							   </tbody>
                            </table>
                        </div>
						
						<input type="hidden" id="totalOrderqty" value="<?=$totalOrderqty?>"> 
						<input type="hidden" id="getrow" value="0"> 
						
						<form method="post" id="formTank"> 
							<div class="col-md-12 col-lg-12 col-sm-12 warehouse_table" style="display: none;">
							   <span id="dataWarehouseTank"></span>
							</div>
						</form>
                        <div class="col-md-12 col-lg-12 col-sm-12">
							<span id="button_show_hide" style="float: right; display: none;">
								<button class="btn btn-primary" data-val ="<?=$id?>" id="formSubmittankWareHouse">Submit</button>
							</span>
                        </div>
													
                        <div class="col-md-12 col-lg-12" id="mrk" style="display: none;">
                            <p id = "received_message" style="font-size: 13px;">
                                The order has already been raised. Please check if you have received all the products that you have ordered from the
                                supplier. Then mark the order as received. Marking the order as received will increase your stock level of the ordered
                                products and will also make the payment status of the order as paid.
                            </p>
                            <p>
                                <button  id = "received_button" onclick="confirm_modal_2('<?php echo base_url();?>purchase_order/receive/<?php echo $id;?>' ,
                                        '<?php echo base_url();?>purchase_order/po_received')"
                                   class="btn btn-success btn-icon icon-left btn-sm pull-left">
                                    Mark As Received
                                    <i class="entypo-check"></i>
                                </button>
                            </p>
                        </div>
                      
                    </div>
                    <a href="<?=base_url()?>purchase_order/po_view" style="text-decoration: none;">
                        <div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;">
                            <i class="icono-caretLeft" style="color: #FFF;"></i>Back
                        </div>
                    </a>
                </div>
				    <br /><br /><br /><br /><br />
            </div>
    
    <br /><br /><br /><br /><br />
	</div>
    
    
<script>
    $('.datepicker_class').datepicker({
        dateFormat: "yy-mm-dd",
    });
</script>

    <script>
		
	function confirm_modal_2(url , post_refresh_url)
    {
        $('#preloader-delete').html('');
        jQuery('#modal_confirm').modal('show', {backdrop: 'static'});
        document.getElementById('confirm_link').setAttribute("onClick" , "confirm('" + url + "' , '" + post_refresh_url + "')" );
        document.getElementById('confirm_link').focus();
    }
		
		
    $(document).ready(function(){
		$(".table").delegate(".updatePurchaseStock", "click", function() {
				var productid = $(this).attr('id');
				
				var qty = $('#qty'+productid).val();
				var bonusqty = $('#bonusqty'+productid).val();
				
				var discount = $('#discount'+productid).val();
				var sub_discount_amount = $('#discount_amount'+productid).val();
				var net_amount = $('#net_amount'+productid).html();
				var tax = $('#tax'+productid).val();
				
				
				var totaltax =  $("#totaltax").val();
				var total_net = $("#total_net").html();
				var mainidpurchaseid = $("#mainidpurchaseid").val();
				var discount_percent = $("#discount_percent").val();
				var discount_amount = $("#discount_amount").val();

				$.ajax({
					type:'POST',
					url:"UpdatePurchaseInvoice",
					data: {discount_amount:discount_amount,discount_percent:discount_percent,productid: productid,qty:qty,bonusqty:bonusqty,discount:discount,sub_discount_amount:sub_discount_amount,net_amount:net_amount,tax:tax,totaltax:totaltax,total_net:total_net,mainidpurchaseid:mainidpurchaseid},
					dataType: 'JSON',
					success:function(data){
						if(data.success)
						{
							alert('Data Successfully Updated!!')
							location.reload();
						}
					}
				});
				
		});

		$(".table").delegate(".dynamic_row input, select", "keyup", function() {
				calamount();
		});

		function calamount()
		{
			var totalnetamount = 0;
			var totaltax = 0;
			var discount_amount = 0;
			var discount_percent = 0;
			$("#items").find('.dynamic_row').each(function (i) {
				var $fieldset = $(this);
				var pcs        = ($('.pcs', $fieldset).val());
				var rate       = ($('.rate', $fieldset).val());
				var discount  = ($('.discount', $fieldset).val());
				var tax  = ($('.tax', $fieldset).val());
				
				if(pcs.trim()==''){
					pcs=0;
					$('.rate', $fieldset).val('0');
				}
				if(tax.trim()==''){
					tax=0;
					$('.tax', $fieldset).val('0');
				}
				if(discount.trim()==''){
					discount=0;
					$('.discount', $fieldset).val('0');
				}
				var grossamount = 0.00;
				var grossamount = parseFloat(pcs*rate).toFixed(2);
				
				
				
			
				if (discount.indexOf("%") >= 0) 
				{
					var discount = discount.substr(0, discount.indexOf('%'));
					var discountamt = parseFloat((discount/100)*grossamount).toFixed(2);
					var netamount = parseFloat(grossamount-discountamt);
					discount_percent  = parseFloat(discount_percent) + parseFloat(discount);
				}
				else
				{
					if(parseFloat(discount)>parseFloat(grossamount))
					{
						var discount = 0;
						$('.discount', $fieldset).val(discount);
						alert('Discount Amount must to less than Payable Amount!');
					}
					var discountamt = discount;
					var netamount = parseFloat(grossamount)-parseFloat(discount);
				}
				
				
				$('.discount_amount', $fieldset).val(discountamt);
			
				var total_tax_amt 		= parseFloat(grossamount) * (parseFloat(tax)/100);

				var finalamount = parseFloat(netamount)+parseFloat(total_tax_amt);
				$('.net_amount', $fieldset).html(finalamount.toFixed(2));

				discount_amount  = parseFloat(discount_amount) + parseFloat(discountamt);
				
				totalnetamount = parseFloat(totalnetamount) + parseFloat(finalamount);
				totaltax = parseFloat(totaltax) + parseFloat(tax);
				$("#totaltax").val(parseFloat(totaltax).toFixed(2));
				$("#total_net").text(parseFloat(totalnetamount).toFixed(2));
				$("#discount_percent").val(parseFloat(discount_percent).toFixed(2));
				$("#discount_amount").val(parseFloat(discount_amount).toFixed(2));
			});
	   }
		
		$('.WareHouseTank').click(function(){
			$(this).addClass('greencolor');
			var getrow = $('#getrow').val();
			var product_code = $(this).attr('id');
			var product_name = $(this).attr('data-val');
			var ordered_qty = $(this).attr('data-qty');
			var purchaseid = $(this).attr('data-purchase');
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Purchase_order/WareHouseTankReceive",
				data: {product_code: product_code,product_name:product_name,ordered_qty:ordered_qty,purchaseid:purchaseid,getrow:getrow},
				dataType: 'JSON',
				success:function(data){
					$('#getrow').val(data.row);
					$('.warehouse_table').show();
					$('#dataWarehouseTank').append(data.html);
					$('#warehouse_tank'+purchaseid).html('<button class="btn btn-small btn-info"><i class="fa fa-check" style="font-size: 20px;"  aria-hidden="true"></i></button>');
					$('.datepicker_class').datepicker({
							dateFormat: "yy-mm-dd"
					});
				}
			 });
		});
		
		var item_row = 1;
		$('#dataWarehouseTank').delegate('.AddBatch','click',function(e){
			var batch_id = $(this).attr('id');
			e.preventDefault();
			var html ='<span class="removeAddBatch'+batch_id+item_row+'"><div class="col-md-9" style="padding: 0px;">\n\
					   <input  class="form-control" name="warehouse['+batch_id+'][batch_no][]" type="text"></div>\n\
					   <div class="col-md-3" style="padding: 0px;margin-top:10px;"><a style="cursor: pointer;" class="item_remove_batch_warehouse" id='+batch_id+item_row+'>Remove</a></div></span>';
						   
			$("#item_batch_row"+batch_id).before(html);
			
			var exhtml ='<span class="removeAddBatch'+batch_id+item_row+'"><div class="col-md-9" style="padding: 0px;">\n\
					   <input  class="form-control datepicker_class" name="warehouse['+batch_id+'][expire_date][]" type="text"></div>\n\
					   <div class="col-md-3" style="padding: 0px;margin-top:10px;"><a style="cursor: pointer;" class="item_remove_batch_warehouse" id='+batch_id+item_row+'>Remove</a></div></span>';
			
			$("#item_expire_row"+batch_id).before(exhtml);
			item_row++;
			
			$('.datepicker_class').datepicker({
				dateFormat: "yy-mm-dd"
			});
		});
		

		
		$('#dataWarehouseTank').delegate('.item_remove_batch_warehouse','click',function(e){
			var id = $(this).attr('id');
			$('.removeAddBatch'+id).html('');
		});
		
		
		
	
        $("#btncl").click(function(){
            if($("#dist").css('display')=='none'){
                $("#dist").css('display', 'block');
            }else {
                $("#dist").css('display', 'none');
                $(".warehouse_table").css('display','none');
                $("#mrk").css('display','none');
            }
        });

   
        $('#distribute_to_warehouse').click(function(){
            $("#jumbotron").slideToggle();
        });
		
		
	
	$('#dataWarehouseTank').delegate('.add_to_warehouse_one','click',function(){
			var purchaseid = $(this).attr('id');
        	var ordered_qty = $('#ordered_qty'+purchaseid).val();
			var sum = 0;
            $(".warehouse_quantity"+purchaseid).each(function() {
                var value = $(this).val();
                if(!isNaN(value) && value.length != 0) {
                    sum += parseInt(value);
                }
            });

            if(parseInt(sum) === parseInt(ordered_qty)){
				 $('#TankSlideup'+purchaseid).slideToggle();
			     $('.product_heading_display'+purchaseid).slideToggle();
				 submitbutton();
            }
			
			else{
                alert('Quantity does not match');
            }
	});
	
	
	$('#dataWarehouseTank').delegate('.product_heading','click',function(){
		var purchaseid = $(this).attr('id');
		$(this).hide();
		$('#button_show_hide').hide();
		$('#TankSlideup'+purchaseid).slideToggle();
	});
		
	function submitbutton()
	{
		var sum = 0;
		$(".allqtytankandWarehouse").each(function() {
                var value = $(this).val();
                if(!isNaN(value) && value.length != 0) {
                    sum += parseInt(value);
                }
		});
		
		var totalOrderqty = $('#totalOrderqty').val()
		if(sum == totalOrderqty)
		{
			$('#button_show_hide').show();
		}
		else
		{
			$('#button_show_hide').hide();
		}
	}
	
	
	$('#formSubmittankWareHouse').click(function(e){
			e.preventDefault();
			$(this).addClass('disabled');
			var formData = new FormData();
			var tankware = $('#formTank').serializeArray();
			$.each(tankware, function (key, input) {
				formData.append(input.name, input.value);
			});
			
			var purchase_bill_no = $('#purchase_bill_no').val();
			var purchase_id  = $(this).attr('data-val');
			
			formData.append("purchase_bill_no", purchase_bill_no);
			formData.append("purchase_id", purchase_id);
			$('#formSubmittankWareHouse').addClass('disabled');
			$.ajax({
				type:'POST',
				url:"<?=base_url();?>Purchase_order/SubmitData",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				success:function(data){
				if(data.success)
				{
					alert('Warehouse and Tank Successfully Distributed!!');
					window.location.href='<?=base_url();?>purchase_order/po_received?p_status=6';
				}
				else
				{
					alert('Due to some error please try again!!');
					location.reload();
				}
			}
		});
	});
		
		
		
//	$('#dataWarehouseTank').delegate('#add_to_warehouse','click',function(){
//				var ordered_qty = $('#ordered_qty').val();
//				var sum = 0;
//				$(".warehouse_quantity").each(function() {
//                var value = $(this).val();
//				    if(!isNaN(value) && value.length != 0) {
//					    sum += parseInt(value);
//					}
//				});
//				if(parseInt(sum) === parseInt(ordered_qty)){
//					
//					var formData = new FormData();
//					var warehouse = $('#formWarehouse').serializeArray();
//					$.each(warehouse, function (key, input) {
//							formData.append(input.name, input.value);
//					});
//					
//					var purchaseid = $('#purchaseid').val();
//					formData.append('purchaseid', purchaseid);
//					
//				$.ajax({
//					type:'POST',
//					url:"<?=base_url();?>purchase_order/add_to_different_warehouse",
//					data: formData,
//					cache: false,
//					contentType: false,
//					processData: false,
//					dataType: 'JSON',
//					success:function(data){
//						if(data.sucess)
//						{
//							alert('Stock Suucessfully Distribute to the Warehouse');
//							location.reload();
//						}
//						else
//						{
//							alert('Due to some error please try again!!');
//							location.reload();
//						}
//					}
//				});
//			}
//			else
//			{
//                alert('Quantity does not match');
//            }
//				
//		});
//				
//		
		
		
		
		
		
		
//		$('#dataWarehouseTank').delegate('#add_to_warehouse_one','click',function(){
//        	var ordered_qty = $('#ordered_qty').val();
//			var sum = 0;
//            $(".warehouse_quantity").each(function() {
//                var value = $(this).val();
//                if(!isNaN(value) && value.length != 0) {
//                    sum += parseInt(value);
//                }
//            });
//
//            if(parseInt(sum) === parseInt(ordered_qty)){
//				var formData = new FormData();
//				var warehouse = $('#formTank').serializeArray();
//				$.each(warehouse, function (key, input) {
//					formData.append(input.name, input.value);
//				});
//				
//				var purchaseid = $('#purchaseid').val();
//				formData.append('purchaseid', purchaseid);
//					
//                $.ajax({
//					type:'POST',
//					url:"<?=base_url();?>purchase_order/add_to_different_tank",
//					data: formData,
//					cache: false,
//					contentType: false,
//					processData: false,
//					dataType: 'JSON',
//					success:function(data){
//						if(data.sucess)
//						{
//							alert('Stock Suucessfully Distribute to the Tank');
//							location.reload();
//						}
//						else
//						{
//							alert('Due to some error please try again!!');
//							location.reload();
//						}
//					}
//				});
//                
//            }else{
//                alert('Quantity does not match');
//            }
//
//        });
		
		
		
		
		
		
		
		
	});


    </script>
<?php
require_once 'includes/footer.php';
?>
