<script type="text/javascript">

    function openReceiptDetail(ele) {
        window.open(ele, "", "width=650, height=650");
    }
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">View Order Detail</h1>
		</div>

	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2><?= !empty($getmainOrder->outlet_name) ? $getmainOrder->outlet_name : '' ?></h2>
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<tbody>
										<tr>
											<td>
												<?php
												if (!empty($getmainOrder->operator_name)) {
													?>
													<div class="left" style="text-align: left; font-weight: bold;">Pumper Name&nbsp; : <?= !empty($getmainOrder->operator_name) ? $getmainOrder->operator_name : '' ?></div>
													<div class="left" style="text-align: left; font-weight: bold;">Pumper Phone : <?= !empty($getmainOrder->operator_mobile_number) ? $getmainOrder->operator_mobile_number : '' ?></div>
												<?php } ?>
												<div class="left" style="text-align: left; font-weight: bold;">Outlet Address : <?= !empty($getmainOrder->outlet_address) ? $getmainOrder->outlet_address : '' ?></div>
												<div class="left" style="text-align: left; font-weight: bold;">Outlet Tel : <?= !empty($getmainOrder->outlet_contact) ? $getmainOrder->outlet_contact : '' ?></div>
												<div class="left" style="text-align: left; font-weight: bold;">Sale Id : <?= !empty($getmainOrder->id) ? $getmainOrder->id : '' ?></div>
												<div class="left" style="text-align: left; font-weight: bold;">Last meter : <?= !empty($getmainOrder->total_items) ? $getmainOrder->total_items : '' ?></div>
												<div class="left" style="text-align: left; font-weight: bold;">Current meter : <?= !empty($getmainOrder->total_items) ? $getmainOrder->total_items : '' ?></div>
												<div class="left" style="text-align: left; font-weight: bold;">Date : <?= date("$setting_dateformat H:i A", strtotime(@$getmainOrder->created_at)); ?></div>
											</td>
										</tr> 
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2>Item Detail</h2>
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Sales Id</th>
											<th>Product Name</th>
											<th>Pump</th>
											<th>Last Meter</th>
											<th>Current Meter</th>
											<th>Price</th>
											<th>Qty</th>
											<th>Sub Total</th>
											<th>Tax%</th>
											<th>Discount%</th>
											<th>Grand Total </th>
										</tr>
									</thead>
									<tbody>
										<?php
										$totalqty = 0;
										$totalprice = 0;
										$totalsubtotal = 0;
										$totalgrandtotal = 0;
										foreach ($getItemOrder as $item) {
											$totalqty = $totalqty + $item->qty;
											$totalprice = $totalprice + $item->price;
											$subtotal = $item->price * $item->qty;
											$totalsubtotal = $totalsubtotal + $subtotal;
											$totalgrandtotal = $totalgrandtotal + $item->grandtotal;
											?>
											<tr>
												<td style="text-align: left;"><?= $item->order_id ?></td>
												<td style="text-align: left;"><?= $item->product_name ?></td>
												<td style="text-align: left;"><?= $item->pump_name ?></td>
												<td style="text-align: left;"><?= !empty($item->start_meter) ? number_format($item->start_meter, 2) : '' ?></td>
												<td style="text-align: left;"><?= !empty($item->end_meter) ? number_format($item->end_meter, 2) : '' ?></td>
												<td style="text-align: left;"><?= !empty($item->price) ? number_format($item->price, 2) : 0.00 ?></td>
												<td style="text-align: left;"><?= !empty($item->qty) ? number_format($item->qty, 2) : 0.00 ?></td>
												<td style="text-align: left;"><?= !empty($subtotal) ? number_format($subtotal, 2) : 0.00 ?></td>
												<td style="text-align: left;"><?= !empty($item->tax) ? number_format($item->tax, 2) : 0.00 ?></td>
												<td style="text-align: left;"><?= !empty($item->discount) ? $item->discount : 0 ?></td>
												<td style="text-align: left;"><?= !empty($item->grandtotal) ? number_format($item->grandtotal, 2) : 0.00 ?></td>
											</tr>
										<?php }
										?>
										<tr>
											<td colspan="5" style="text-align: left;"><b>Total</b></td>
											<td style="text-align: left;"><b><?= !empty($totalprice) ? number_format($totalprice, 2) : 0.00 ?></b></td>
											<td style="text-align: left;"><b><?= !empty($totalqty) ? number_format($totalqty, 2) : 0.00 ?></b></td>
											<td style="text-align: left;"><b><?= !empty($totalsubtotal) ? number_format($totalsubtotal, 2) : 0.00 ?></b></td>
											<td style="text-align: left;"></td>
											<td style="text-align: left;"></td>
											<td style="text-align: left;"><b><?= !empty($totalgrandtotal) ? number_format($totalgrandtotal, 2) : 0.00 ?></b></td>
										</tr>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h2>Payment Detail</h2>
					<div class="row" style="margin-top: 0px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Sales Id</th>
											<th>Payment Type</th>
											<th style="color: #cc0033;">Customer</th>
											<th>Paid Amount</th>
											<th>Unpaid Amount</th>
											<th>Sub Total</th>
											<th>Grand Total</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$paid_amt = 0;
										$unpaid_amt = 0;
										$subtotal = 0;
										$grandtotal = 0;
										foreach ($getPaymentOrder as $payment) {
											$paid_amt = $paid_amt + $payment->paid_amt;
											$unpaid_amt = $unpaid_amt + $payment->unpaid_amt;
											$subtotal = $subtotal + $payment->subtotal;
											$grandtotal = $grandtotal + $payment->grandtotal;
											?>
											<tr>
												<td style="text-align: left;"><?= $payment->order_id ?></td>
												<td style="text-align: left;"><?php
													echo $payment->payment_method_name;
													if ($payment->payment_method == 5) {
														echo ' (Cheque No: ' . $payment->cheque_number . ')';
													} elseif ($payment->payment_method == 3) {
														echo ' (Credit Cards No: ' . $payment->card_number . ')';
													}
													?></td>
												<td style="text-align: left;"><?= $payment->customer_name ?></td>
												<td style="text-align: left;"><?= !empty($payment->paid_amt) ? number_format($payment->paid_amt, 2) : 0.00 ?></td>
												<td style="text-align: left;"><?= !empty($payment->unpaid_amt) ? number_format($payment->unpaid_amt, 2) : 0.00 ?></td>
												<td style="text-align: left;"><?= !empty($payment->subtotal) ? number_format($payment->subtotal, 2) : 0.00 ?></td>
												<td style="text-align: left;"><?= !empty($payment->grandtotal) ? number_format($payment->grandtotal, 2) : 0.00 ?></td>
												<td>
													<?php
													if ($payment->payment_method_name == "Vouchers" || $payment->payment_method_name == "Debit / Credit Sales") {
														?>
														<button class="btn btn-primary" data-toggle="modal" data-target="#myModalData<?php echo $payment->id; ?>">More Details</button>

														<div id="myModalData<?= $payment->id ?>" class="modal fade" role="dialog">
															<div class="modal-dialog" style="width: 70%;">
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Customer: <?= $payment->customer_name ?></h4>
																	</div>
																	<form  id="CustomerDetailSubmit<?= $payment->id ?>" method="post" class="SubmitData" >
																		
																		<input type="hidden" name="sales_payment_id" value="<?=$payment->id?>" />
																		<input type="hidden" name="settlement_no"  value="<?=$getmainOrder->settlement_no?>" />
																		<input type="hidden" name="customer_id" value="<?=$payment->customer_id?>" />
																		
																		<div class="modal-body" style="overflow: visible; background-color: #FFF;">
																				<div class="row">
																					
																					<div class="col-md-4">
																						<div class="form-group">
																							<label>Product <span style="color: #F00">*</span></label>
																							<select id="product_code<?=$payment->id?>" data-val="<?=$payment->id?>" name="product_code" class="form-control ChangeEventProduct">
																								<option value="">Select Product</option>
																								<?php
																								foreach ($getItemOrder as $itemp) {
																									?>
																									<option value="<?= $itemp->product_code ?>"><?= $itemp->product_name ?></option>
																								<?php }
																								?>
																							</select>
																						</div>
																					</div>

																					<div class="col-md-2">
																						<div class="form-group">
																							<label>Unit Price </label>
																							<input id="unit_price<?=$payment->id?>" type="text" name="unit_price" class="form-control" readonly="" value="0" />
																						</div>
																					</div>
																					
																					<div class="col-md-2">
																						<div class="form-group">
																							<label>Qty  </label>
																							<input id="qty<?=$payment->id?>" type="text" name="qty" data-val="<?=$payment->id?>" class="form-control qty"  value="" />
																						</div>
																					</div>
																					<div class="col-md-2">
																						<div class="form-group">
																							<label>Total Amount  <span style="color: #F00">*</span></label>
																							<input readonly=""  id="total_amount<?=$payment->id?>"  type="text" name="total_amount" class="form-control"  value="0" />
																						</div>
																					</div>
																					<div class="col-md-2">
																						<div class="form-group">
																							<label>&nbsp;</label>
																							<button type="button" class="btn btn-primary SubmitDataTable" id="<?=$payment->id?>" style="margin-top: 26px; width: 100px;">Save</button>
																						</div>
																					</div>

																				</div>
																			
																			<div class="row">
																				<div class="col-md-12">
																					<table class="table" id="datatable">
																						<thead>
																							<tr>
																								<th>Product Name</th>
																								<th>Unit Price</th>
																								<th>Qty</th>
																								<th>Total Amount</th>
																								<th>Action</th>
																							</tr>
																						</thead>
																						<tbody id="appendValue<?=$payment->id?>">
																						</tbody>
																						<tfoot>
																							<tr>
																								<td></td>
																								<td></td>
																								<td><label style="margin-top: 10px;">Total</label></td>
																								<td><input readonly="" id="grandAmount<?=$payment->id?>" type="text" value="0" class="form-control" style="width: 100px;"></td>
																								<td></td>
																							</tr>
																						</tfoot>
																					</table>
																				</div>
																			</div>


																			
																		</div>
																		<div class="modal-footer" style="margin-top: 10px;">
																			<button type="button" class="btn btn-primary SubmitFormData" id="<?=$payment->id?>" style="background-color: #3fb618; color: #FFF; border: 0px; padding: 5px 25px; float: right;">Submit</button>
																		</div>
																	</form>
																</div>
															</div>
														</div>

													<?php }
													?>

												</td>
											</tr>
										<?php }
										?>
										<tr>
											<td colspan="3" style="text-align: left;"><b>Total</b></td>
											<td style="text-align: left;"><b><?= !empty($paid_amt) ? number_format($paid_amt, 2) : 0.00 ?></b></td>
											<td style="text-align: left;"><b><?= !empty($unpaid_amt) ? number_format($unpaid_amt, 2) : 0.00 ?></b></td>
											<td style="text-align: left;"><b><?= !empty($subtotal) ? number_format($subtotal, 2) : 0.00 ?></b></td>
											<td style="text-align: left;"><b><?= !empty($grandtotal) ? number_format($grandtotal, 2) : 0.00 ?></b></td>											
											<td></td>										
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<a href="<?=base_url()?>pumps/settlement_list" class="btn btn-primary">Back</a>
		</div>
		
	</div>
	<br /><br /><br />
</div>

<script>
	$('document').ready(function(){
	
		$('.modal').delegate('.ChangeEventProduct','change',function(){
			var id			  = $(this).attr('data-val');
			var product_code  = $('#product_code'+id).val();
			if(product_code != "")
			{
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>pumps/getSingleProductData",
					data: {product_code: product_code},
					dataType: 'JSON',
					success:function(data){
						$('#unit_price'+id).val(data.retail_price);
					}
				});
			}
			else
			{
				$('#unit_price'+id).val('0');
				$('#qty'+id).val('');
				$('#total_amount'+id).val('0');
			}
		});
		
		var row = 1;
		$('.modal').delegate('.SubmitDataTable','click',function(){
			var id = $(this).attr('id');
			var product_code	= $('#product_code'+id).val();
			var qty				= $('#qty'+id).val();
			var total_amount	= $('#total_amount'+id).val();
			var unit_price		= $('#unit_price'+id).val();
			if(product_code == "")
			{
				alert("Please Select Product First!!");
			}
			else if(qty == 0 || qty == '')
			{
				alert("Please Enter Qty!!");
			}
			else
			{
				var html = '';
				html +='<tr id="RemoveRow'+id+row+'">' +
							'<td>'+product_code+'\
				<input type="hidden" value='+product_code+' name="return['+row+'][product_code]" >\n\
				<input type="hidden" value='+unit_price+' name="return['+row+'][unit_price]" >\n\
				<input type="hidden" value='+qty+' name="return['+row+'][qty]" >\n\
				<input type="hidden" value='+total_amount+' name="return['+row+'][total_amount]" >\n\
					</td>'+ 
							'<td>'+unit_price+'</td>'+
							'<td>'+qty+'</td>'+
							'<td>'+total_amount+'</td>'+
							'<td><span style="cursor: pointer;" class="RemoveTableRow" data-val='+id+' id='+id+row+' data-amount='+total_amount+'>Remove</span></td>'+
						'</tr>';
				$('#appendValue'+id).prepend(html);
				
				var grandAmount = $('#grandAmount'+id).val();
				var finaltotal  = parseFloat(grandAmount) + parseFloat(total_amount);
				$('#grandAmount'+id).val(finaltotal.toFixed(2));
				
				$('#product_code'+id).val('');
				$('#unit_price'+id).val('0');
				$('#qty'+id).val('');
				$('#total_amount'+id).val('0');
				row++;
			}
		});
		
		
		
		
		$('.SubmitFormData').click(function(e){
				var id = $(this).attr('id');
				e.preventDefault();
				var grandAmount = $('#grandAmount'+id).val();
				if(grandAmount == "" || grandAmount == "0" )
				{
					alert('Grand Amount is Zero(0) Please add at lease one Item!!');
				}
				else
				{
					var formData = new FormData();
					var contact = $('#CustomerDetailSubmit'+id).serializeArray();
					$.each(contact, function (key, input) {
						formData.append(input.name, input.value);
					});

					$.ajax({
						type:'POST',
						url:"<?=base_url();?>pumps/SubmitDataDetailItemCustomer",
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						dataType: 'JSON',
						success:function(data){
							if(data.success)
							{
								alert('Data Successfully Save!!');
								location.reload();
							}
							else
							{
								alert('Due to some error please try again!!');
								location.reload();
							}
						}
					});
				}
		});
		
		
		$('.modal').delegate('.RemoveTableRow','click',function(){
			var amount = $(this).attr('data-amount');
			var id = $(this).attr('data-val');
			var rowid = $(this).attr('id');
			var grandAmount = $('#grandAmount'+id).val();
			var finaltotal  = parseFloat(grandAmount) - parseFloat(amount);
			$('#grandAmount'+id).val(finaltotal.toFixed(2));
			$('#RemoveRow'+rowid).html('');
		});
		
		$('.modal').delegate('.qty','keyup',function(){
			var id = $(this).attr('data-val');
			var price = $('#unit_price'+id).val();
			var qty = $(this).val();
			if(qty == "")
			{
				qty = 0;
			}
			var total = parseFloat(price) * parseFloat(qty);
			$('#total_amount'+id).val(total.toFixed(2));
		});
	});
</script>
	