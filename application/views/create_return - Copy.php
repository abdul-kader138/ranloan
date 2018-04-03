<?php
require_once 'includes/header.php';
?>
<style type="text/css">
	label { font-size: 22px; }

	/*** custom checkboxes ***/

	input[type=checkbox] { display:none; } /* to hide the checkbox itself */
	input[type=checkbox] + label:before {
		font-family: FontAwesome;
		display: inline-block;
	}

	input[type=checkbox] + label:before { content: "\f096"; } /* unchecked icon */
	input[type=checkbox] + label:before { letter-spacing: 10px; } /* space between checkbox and label */

	input[type=checkbox]:checked + label:before { content: "\f046"; } /* checked icon */
	input[type=checkbox]:checked + label:before { letter-spacing: 5px; } /* allow space for check mark */	
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
		width: 312px;
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
		width: 312px;
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
</style>

<!-- Select2 -->
<link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet">

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Create Return Order</h1>
		</div>
	</div><!--/.row-->

	<form action="<?= base_url() ?>returnorder/insertReturnOrder" method="post" onsubmit="return confirm('Are you confirm to create Return Order?')">
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
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size: 13px;">Customer <span style="color: #F00">*</span></label>
									<select name="customer" class="form-control" style="width: 100%;" required id="customerSearch">
										<option value="">Choose Customer</option>
										<?php
										$custResult = $this->db->query('SELECT * FROM customers ORDER BY fullname');
										$custData = $custResult->result();
										for ($c = 0; $c < count($custData); ++$c) {
											$cust_id = $custData[$c]->id;
											$cust_fn = $custData[$c]->fullname;
											$cust_mb = $custData[$c]->mobile;
											?>
											<option value="<?php echo $cust_id; ?>" <?php
											if ($url_cust_id == $cust_id) {
												echo 'selected="selected"';
											}
											?>>
														<?php echo $cust_fn; ?>
														<?php
														if (!empty($cust_mb)) {
															echo '[' . $cust_mb . ']';
														}
														?>
											</option>
											<?php
											unset($cust_id);
											unset($cust_fn);
											unset($cust_mb);
										}
										unset($custResult);
										unset($custData);
										?>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label style="font-size: 13px;">Outlet <span style="color: #F00">*</span></label>
									<select name="outlet" class="form-control" required>
										<option value="">Choose Outlet</option>
										<?php
										if ($user_role == 1) {
											$outletData = $this->Constant_model->getDataOneColumnSortColumn('outlets', 'status', '1', 'name', 'ASC');
										} else {
											$outletData = $this->Constant_model->getDataOneColumn('outlets', 'id', "$user_outlet");
										}
										for ($u = 0; $u < count($outletData); ++$u) {
											$outlet_id = $outletData[$u]->id;
											$outlet_name = $outletData[$u]->name;
											?>
											<option value="<?php echo $outlet_id; ?>">
												<?php echo $outlet_name; ?>
											</option>
											<?php
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-5"></div>
						</div>

						<div class="row">
							<div class="col-md-7">
								<div class="form-group">
									<label style="font-size: 13px;">Remark</label>
									<textarea name="remark" class="form-control" style="height: 70px;"></textarea>
								</div>
							</div>
							<div class="col-md-5"></div>
						</div>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size: 13px;">Refund Amount (<?php echo $currency; ?>)</label>
								</div>
							</div>
							<div class="col-md-4">
								<input type="text" name="refund_amt" class="form-control" required onkeyup="calculateGrand(this.value)" />
							</div>
							<div class="col-md-5" style="padding-top: 10px; color: #afb1b2;">
								* Please type positive value for Refund Amount, invoice will effect with minus.
							</div>
						</div>

						<div class="row" style="padding-top: 5px;">
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size: 13px;">Refund Tax (<?php echo $tax; ?>%)</label>
								</div>
							</div>
							<div class="col-md-4">
								<input type="text" name="refund_tax" id="refund_tax" class="form-control" required readonly />
							</div>
							<div class="col-md-5" style="padding-top: 10px; color: #afb1b2;">
								* Invoice will effect with minus.
							</div>
						</div>

						<div class="row" style="padding-top: 5px;">
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size: 13px;">Refund Grand Total (<?php echo $currency; ?>)</label>
								</div>
							</div>
							<div class="col-md-4">
								<input type="text" name="refund_grand" id="refund_grand" class="form-control" required readonly />
							</div>
							<div class="col-md-5" style="padding-top: 10px; color: #afb1b2;">
								* Invoice will effect with minus.
							</div>
						</div>

						<input type="hidden" id="tax" value="<?php echo $tax; ?>" />



						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size: 13px;">Refund By</label>
								</div>
							</div>
							<div class="col-md-4">
								<select name="refund_by" class="form-control" style="" onchange="checkChequePayment(this.value)" required>
									<option value="">Choose Refund By</option>
									<?php
									$payMethodData = $this->Constant_model->getDataOneColumn('payment_method', 'status', '1');
									for ($p = 0; $p < count($payMethodData); ++$p) {
										$payMethod_id = $payMethodData[$p]->id;
										$payMethod_name = $payMethodData[$p]->name;

										if (($payMethod_id == 6) || ($payMethod_id == 7)) {
											continue;
										}
										?>
										<option value="<?php echo $payMethod_id; ?>"><?php echo $payMethod_name; ?></option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="col-md-5"></div>
						</div>

						<div class="row" id="cheque_wrp" style="display: none; padding-bottom: 5px; padding-top: 5px;">
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size: 13px;">Cheque Number</label>
								</div>
							</div>
							<div class="col-md-4">
								<input type="text" name="cheque_numb" class="form-control" id="cheque" style="" />
							</div>
							<div class="col-md-5"></div>
						</div>

						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-3">
								<div class="form-group">
									<label style="font-size: 13px;">Refund Method</label>
								</div>
							</div>
							<div class="col-md-4">
								<select name="refund_method" class="form-control" required style="">
									<option value="">Choose Refund Method</option>
									<option value="1">Full Refund</option>
									<option value="2">Partial Refund</option>
								</select>
							</div>
							<div class="col-md-5"></div>
						</div>

						<div class="row" style="margin-top: 5px;">
							<div class="col-md-12" style="border-top: 1px solid #ccc;"></div>
						</div>

						<!-- Product List // START -->
						<div class="row" style="padding-top: 7px;">
							<div class="col-md-4">
								<div class="form-group">
									<label style="font-size: 13px;">Search Product <span style="color: #F00">*</span></label>
									<!-- <input type="text" class="form-control" id="typeahead" placeholder="Search Product" name="typeahead" /> -->
									<select id="typeahead" class="add_product_po form-control">
										<option value="">Search Product by Name OR Code</option>
										<?php
										$prodData = $this->Constant_model->getDataAll("products", "id", "DESC");
										for ($p = 0; $p < count($prodData); $p++) {
											$prod_code = $prodData[$p]->code;
											$prod_name = $prodData[$p]->name;
											?>
											<option value="<?php echo $prod_code; ?>">
												<?php echo $prod_name . " [" . $prod_code . "]"; ?>
											</option>
											<?php
											unset($prod_code);
											unset($prod_name);
										}
										?>
									</select>
								</div>
							</div>
							<div class="col-md-8" style="padding-top: 23px;">
								<div style="background-color: #686868; color: #FFF; width: 150px; text-align: center; border-radius: 4px; padding: 9px 0px; cursor: pointer;" id="addToList">Add to Return Item(s)</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table">
										<thead>
											<tr>
												<th width="20%" style="background-color: #686868; color: #FFF;">Product Code</th>
												<th width="20%" style="background-color: #686868; color: #FFF;">Product Name</th>
												<th width="20%" style="background-color: #686868; color: #FFF;">Return Qty.</th>
												<th width="20%" style="background-color: #686868; color: #FFF;">Condition</th>
												<th width="10%" style="background-color: #686868; color: #FFF;">Action</th>
											</tr>
										</thead>
										<tbody id="addItemWrp">

										</tbody>
									</table>
								</div>
							</div>
						</div>

						<!-- Product List // END -->





						<div class="row">
							<div class="col-md-12">
								<div class="form-group" style="text-align: center;">
									<input type="hidden" id="row_count" name="row_count" value="1" />
									<button class="btn btn-primary" style="padding: 12px 20px;">
										Create Return Order
									</button>
								</div>
							</div>
						</div>



					</div><!-- Panel Body // END -->
				</div><!-- Panel Default // END -->

				<?php
				if ($url_sales_id > 0) {
					?>
					<div class="panel panel-default">
						<div class="panel-body">

							<div class="row">
								<div class="col-md-12">
									<h1 class="page-header" style="color: #0079c0; text-align: center;">Previous Sales</h1>
								</div>
							</div>

							<div class="row">
								<div class="col-md-3"></div>
								<div class="col-md-6">

									<style type="text/css" media="all">
										#wrapper { 
											min-width: 250px; 
											margin: 0px auto; 
										}
										#wrapper img { 
											max-width: 300px; 
											width: auto; 
										}

										h2, h3, p { 
											margin: 5px 0;
										}
										.left { 
											width:100%; 
											float:left; 
											text-align:left; 
											margin-bottom: 3px;
											margin-top: 3px;
										}
										.right { 
											width:40%; 
											float:right; 
											text-align:right; 
											margin-bottom: 3px; 
										}
										.table, .totals { 
											width: 100%; 
											margin:10px 0; 
										}
										.table th { 
											border-top: 1px solid #000; 
											border-bottom: 1px solid #000; 
											padding-top: 4px;
											padding-bottom: 4px;
										}
										.table td { 
											padding:0; 
										}
										.totals td { 
											width: 24%; 
											padding:0; 
										}
										.table td:nth-child(2) { 
											overflow:hidden; 
										}


									</style>					

									<?php
									$orderData = $this->Constant_model->getDataOneColumn('orders', 'id', $url_sales_id);
									if (count($orderData) == 1) {
										$ordered_dtm = date("$dateformat H:i A", strtotime($orderData[0]->ordered_datetime));
										$cust_fullname = $orderData[0]->customer_name;
										$outlet_id = $orderData[0]->outlet_id;
										$subTotal = $orderData[0]->subtotal;
										$dis_amt = $orderData[0]->discount_total;
										$tax_amt = $orderData[0]->tax;
										$grandTotal = $orderData[0]->grandtotal;
										$us_id = $orderData[0]->created_user_id;
										$pay_method_id = $orderData[0]->payment_method;
										$paid_amt = $orderData[0]->paid_amt;
										$return_change = $orderData[0]->return_change;
										$cheque_numb = $orderData[0]->cheque_number;
										$dis_percentage = $orderData[0]->discount_percentage;
										$card_numb = $orderData[0]->gift_card;

										$staff_name = '';
										$staffData = $this->Constant_model->getDataOneColumn('users', 'id', $us_id);

										$staff_name = $staffData[0]->fullname;

										$outlet_name = '';
										$outlet_address = '';
										$outlet_contact = '';

										$receipt_header = '';
										$receipt_footer = '';

										$outletNameData = $this->Constant_model->getDataOneColumn('outlets', 'id', $outlet_id);
										if (count($outletNameData) == 1) {
											$outlet_name = $outletNameData[0]->name;
											$outlet_address = $outletNameData[0]->address;
											$outlet_contact = $outletNameData[0]->contact_number;

											$receipt_header = $outletNameData[0]->receipt_header;
											$receipt_footer = $outletNameData[0]->receipt_footer;
										}

										$pay_method_name = '';
										$payNameData = $this->Constant_model->getDataOneColumn('payment_method', 'id', $pay_method_id);
										$pay_method_name = $payNameData[0]->name;
										?>
										<div id="wrapper">
											<h2 style="padding-top: 0px; padding-bottom: 20px; font-size: 22px;"><strong><?php echo $outlet_name; ?></strong></h2>
											<span class="left">Address : <?php echo $outlet_address; ?></span>	
											<span class="left">Tel : <?php echo $outlet_contact; ?></span> 
											<span class="left">Date : <?php echo $ordered_dtm; ?></span>
											<span class="left">Customer : <?php echo $cust_fullname; ?></span> 

											<div style="clear:both;"></div>

											<table class="table" cellspacing="0"  border="0"> 
												<thead> 
													<tr> 
														<th width="10%"><em>#</em></th> 
														<th width="35%" align="left">Product</th>
														<th width="10%">Qty</th>
														<th width="25%" style="text-align: center;">Per Item</th>
														<th width="20%" align="right" style="text-align: right;">Total</th> 
													</tr> 
												</thead> 
												<tbody> 
													<?php
													$total_item_amt = 0;
													$total_item_qty = 0;

													$orderItemResult = $this->db->query("SELECT * FROM order_items WHERE order_id = '$url_sales_id' ORDER BY id ");
													$orderItemData = $orderItemResult->result();
													for ($i = 0; $i < count($orderItemData); ++$i) {
														$pcode = $orderItemData[$i]->product_code;
														$name = $orderItemData[$i]->product_name;
														$qty = $orderItemData[$i]->qty;
														$price = $orderItemData[$i]->price;

														$each_row_price = 0;
														$each_row_price = $qty * $price;

														$total_item_amt += $each_row_price;
														?>
														<tr>
															<td style="text-align:center; width:30px;" valign="top"><?php echo $i + 1; ?></td>
															<td style="text-align:left; width:130px; padding-bottom: 10px" valign="top"><?php echo $name; ?><br />[<?php echo $pcode; ?>]</td>
															<td style="text-align:center; width:50px;" valign="top"><?php echo $qty; ?></td>
															<td style="text-align:center; width:50px;" valign="top"><?php echo number_format($price, 2); ?></td>
															<td style="text-align:right; width:70px;" valign="top"><?php echo number_format($each_row_price, 2); ?></td>
														</tr>	
														<?php
														$total_item_qty += $qty;

														unset($pcode);
														unset($name);
														unset($qty);
														unset($price);
													}
													unset($orderItemResult);
													unset($orderItemData);
													?>

												</tbody> 
											</table> 


											<table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000;">
												<tbody>
													<tr>
														<td style="text-align:left; padding-top: 5px;">Total Items</td>
														<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;"><?php echo $total_item_qty; ?></td>
														<td style="text-align:left; padding-left:1.5%;">Total</td>
														<td style="text-align:right;font-weight:bold;"><?php echo number_format($total_item_amt, 2, '.', ''); ?></td>
													</tr>

													<?php
													if ($dis_amt > 0) {
														?>
														<tr>
															<td style="text-align:left;"></td>
															<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;"></td>
															<td style="text-align:left; padding-left:1.5%; padding-bottom: 5px;">
																Discount&nbsp;<?php
																if (!empty($dis_percentage)) {
																	echo '(' . $dis_percentage . ')';
																}
																?>
															</td>
															<td style="text-align:right;font-weight:bold;">-<?php echo $dis_amt; ?></td>
														</tr>
													<?php }
													?>
													<tr>
														<td style="text-align:left; padding-top: 5px;">&nbsp;</td>
														<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;">&nbsp;</td>
														<td style="text-align:left; padding-left:1.5%;">Sub Total</td>
														<td style="text-align:right;font-weight:bold;"><?php echo $subTotal; ?></td>
													</tr>
													<tr>
														<td style="text-align:left; padding-top: 5px;">&nbsp;</td>
														<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;">&nbsp;</td>
														<td style="text-align:left; padding-left:1.5%;">Tax</td>
														<td style="text-align:right;font-weight:bold;"><?php echo $tax_amt; ?></td>
													</tr>
													<tr>
														<td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Grand Total</td>
														<td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;"><?php echo $grandTotal; ?></td>
													</tr>

													<tr>    
														<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">Paid</td>
														<td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;"><?php echo $paid_amt; ?></td>
													</tr>
													<?php
													if ($return_change > 0) {
														?>
														<tr>
															<td colspan="2" style="text-align:left; font-weight:bold; padding-top:5px;">Change</td>
															<td colspan="2" style="padding-top:5px; text-align:right; font-weight:bold;"><?php echo $return_change; ?></td>
														</tr>
													<?php }
													?>
													<tr>
														<td style="text-align:left; padding-top: 5px; font-weight: bold; border-top: 1px solid #000;">Paid By : </td>
														<td style="text-align:right; padding-top: 5px; border-top: 1px solid #000;font-weight:bold;" colspan="3">
															<?php echo $pay_method_name; ?>
															<?php
															if ($pay_method_id == '5') {
																echo "(Cheque No. : $cheque_numb)";
															}
															if ($pay_method_id == '7') {
																echo "(Card Number : $card_numb)";
															}
															?>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<?php
									}  // End of Checking Order;
									?>
								</div>
								<div class="col-md-3"></div>
							</div>

						</div>
					</div>
					<?php
				}
				?>


			</div><!-- Col md 12 // END -->
		</div><!-- Row // END -->
	</form>

	<br /><br /><br /><br /><br />

</div><!-- Right Colmn // END -->


<?php
require_once 'includes/footer.php';
?>


<script type="text/javascript" src="<?= base_url() ?>assets/js/search/jquery.searchabledropdown.js"></script>
<script src="<?= base_url() ?>assets/js/select2.full.min.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

		$("#addToList").click(function () {
            var row_count = document.getElementById("row_count").value;
            var pcode = document.getElementById("typeahead").value;

            if (pcode.length > 0) {

                var addNewCustomer = $.ajax({
                    url: '<?= base_url() ?>returnorder/checkPcode?pcode=' + pcode,
                    type: 'GET',
                    cache: false,
                    data: {
                        format: 'json'
                    },
                    error: function () {
                        //alert("Sorry! we do not have stock!");
                    },
                    dataType: 'json',
                    success: function (data) {
                        var status = data.errorMsg;
                        var name = data.name;

                        if (status == "failure") {
                            alert("Invalid Product Code! Please search Product by Product Code");


                        } else {
                            var cell = $('<tr id="row_' + row_count + '"><td>' + pcode + '</td><td>' + name + '</td><td><input type="text" class="form-control" name="qty_' + row_count + '" value="1" style="width: 50%;" /></td><td> <input id="box_' + row_count + '" type="checkbox" name="cond_' + row_count + '" /><label for="box_' + row_count + '">Good</label> </td><td><a onclick="deletediv(' + row_count + ')" style="cursor:pointer"><i class="icono-cross" style="color:#F00;"></i></a></td></tr><input type="hidden" class="form-control" name="pcode_' + row_count + '" value="' + pcode + '" />');


                            $('#addItemWrp').append(cell);


                            row_count++;

                            document.getElementById("typeahead").value = "";
                            document.getElementById("row_count").value = row_count;
                        }

                    }
                });





            } else {
                alert("Please search the product by Product Code!");
                document.getElementById("typeahead").focus();
            }

        });

		jQuery.browser = {};
		(function () {
			jQuery.browser.msie = false;
			jQuery.browser.version = 0;
			if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
				jQuery.browser.msie = true;
				jQuery.browser.version = RegExp.$1;
			}
		})();

		$(".add_product_po").select2({
			placeholder: "Search Product by Name OR Code",
			allowClear: true
		});
//		$("#customerSearch").searchable();		
	});
	
	function deletediv(ele) {
        $('#row_' + ele).remove();
    }
	
	function calculateGrand(ele) {
		if (ele.length > 0) {
			var tax = document.getElementById("tax").value;
			tax = parseFloat(tax);

			ele = parseFloat(ele);

			var total_tax_amt = ele * (tax / 100);
			var grandTotal = ele + total_tax_amt;


			document.getElementById("refund_tax").value = total_tax_amt.toFixed(2);
			document.getElementById("refund_grand").value = grandTotal.toFixed(2);
		} else {
			document.getElementById("refund_tax").value = 0;
			document.getElementById("refund_grand").value = 0;
		}
	}

		function checkChequePayment(ele) {
			if (ele == "5") {
				document.getElementById("cheque_wrp").style.display = "block";
				document.getElementById("cheque").required = true;
				document.getElementById("cheque").focus();
			} else {
				document.getElementById("cheque_wrp").style.display = "none";
				document.getElementById("cheque").required = false;
			}
		}
</script>