<?php
$app = realpath(APPPATH);
$this->load->view('includes/header.php');
$paid_bys = $this->Constant_model->getddData('payment_method', 'id', 'name', 'id');
?>
<style>
label.error{
	color:red;
	font-size: 12px;
}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<!--/popup add customer-->
	<div id="PopupCustomer" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Customer</h4>
				</div>
				<form id="add_customer" method="post">
					<div class="modal-body">
						<div class="panel-body">
							<span align="center" id="message_customer"></span>

							<div class="row">

								<div class="col-md-6">
									<div class="form-group">
										<label>Full Name <span style="color: #F00">*</span></label>
										<input type="text" name="fullname" id="fullname" class="form-control customer_empty"  maxlength="499" autofocus required autocomplete="off" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Email Address <span style="color: #F00">*</span></label>
										<input type="email" name="email" id="email" class="form-control customer_empty" required maxlength="254" autocomplete="off" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Mobile </label>
										<input type="text" name="mobile" id="mobile" class="form-control customer_empty" maxlength="499" autofocus autocomplete="off" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Address </label>
										<textarea name="address" id="address" class="form-control customer_empty" ></textarea>
									</div>
								</div>
								<!--start new-->
								<div class="col-md-6">
									<div class="form-group">
										<label>Customer Group </label>
										<div style="clear:both;"></div>
										<select class="form-control" name="group" id="group" required style="width:255px;">
											<option value="">--Select Customer Group--</option>
											<?php foreach ($group as $key => $value) { ?>
											<option  value="<?= $value->id ?>"><?= $value->name ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Nic<span style="color: #F00">*</span></label>
										<input type="text" name="nic" id="nic" class="form-control customer_empty" maxlength="499"  required autocomplete="off" value="" />
									</div>
								</div> 
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Password <span style="color: #F00">*</span></label>
										<input type="password" name="password" id="password" class="form-control customer_empty" maxlength="499" required autocomplete="off" value="" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Confirm Password <span style="color: #F00">*</span></label>
										<input type="password" name="conpassword" id="conpassword" class="form-control customer_empty" maxlength="499" data-match="#password" data-match-error="these don't match" required autocomplete="off" value="" />
									</div>
								</div>

							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Outstanding<span style="color: #F00"></span></label>
										<input type="number" name="outstanding" id="outstanding" class="form-control customer_empty" step=".01" autocomplete="off" value="" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Outlet <span style="color: #cc0000;">*</span></label>
										<div style="clear:both;"></div>
										<select required="" name="outlet_id" id="outlet_id" class="form-control" style="width:255px;">
											<?php
											foreach ($getOutlets as $outlet) {
												?>
												<option value="<?= $outlet->id ?>"><?= $outlet->name ?></option>		
												<?php }
												?>
											</select>

										</div>
									</div>
								</div>	

							</div><!-- Panel Body // END -->
						</div>
						<div class="modal-footer">
							<button class="btn btn-primary" style="width:100px;">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>	
		<!--/end popup add customer-->



		<form id="FormStockItemSubmit" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-3">
					<h2>Sales Invoice</h2>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Customer Order No</label>
						<select name="customer_order_no" id="customer_order_no" class="form-control customer_order_no"  autocomplete="off">
							<option value="">Select Order No</option>
							<?php
							foreach ($gold_orders as $order)
								{ ?>
									<option data-sale="<?=$order->sale_person_id?>"  data-val="<?=$order->gold_customer_id?>" value="<?=$order->gold_id?>"><?=$order->gold_id?></option>	
									<?php	}
									?>
								</select>	
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group" style="margin-top: 5px;">
								<label>Search Customer By Name, Mobile or NIC </label>
								<select name="ser_custome_name"  id="ser_custome_name"  class="form-control ser_custome_name"  autocomplete="off">
									<option value="">Select Customer</option>	
									<?php
									$default_customer = $this->Pos_model->getDefaultCustomer();
									$default_customer_id = $default_customer->default_customer_id;
									foreach ($customer as $cust_view)
									{ 
										$selected = '';
										if($default_customer_id == $cust_view->id)
										{
											$selected = 'selected'; 
										}
										?>

										<option <?= $selected ?> value="<?= $cust_view->id ?>"><?= $cust_view->fullname ?>[<?= $cust_view->mobile ?>][<?= $cust_view->nic ?>]</option>	

										<?php } ?>
									</select>	
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group" style="margin-top: 5px;">
									<label>Sales Person </label>
									<select name="user_sales" id="user_sales"  class="form-control"  autocomplete="off">
										<option value="">Sales Person</option>	

										<?php

										foreach ($sale_per_user as $sales_user_view) {
											?>
											<option  value="<?= $sales_user_view->id ?>"><?= $sales_user_view->fullname ?></option>	
											<?php } ?>
										</select>	
									</div>
								</div>



								<div class="col-md-1" >
									<div class="form-group" style="margin-top: 30px;">
										<a  class="btn btn-success PopupCustomerclick" >
											Add New Customer
										</a>

									</div>
								</div>

							</div><!--/.row-->

							<div class="row">
								<div class="col-md-12">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="row">
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-2">
															<div class="form-group">
																<label>Date & Time </label>
																<input type="text" name="date" value="<?= date('Y-m-d H:i:s') ?>"  class="form-control" style="margin-top: 5px;" readonly />
															</div>
														</div>

														<div class="col-md-2">
															<div class="form-group">
																<label>Sales Invoice No.</label>
																<input type="text" readonly="" name="estimate_no" class="form-control" value="<?= $getgold_orders; ?>" />
															</div>
														</div>

														<div class="col-md-3">
															<div class="form-group">
																<label>Customer Name</label>
																<input type="text" name="customer_name" id="customer_name" class="form-control" />
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label>Customer Mobile No.</label>
																<input type="text" name="customer_mobile_no" id="customer_mobile" class="form-control" />
															</div>
														</div>

														<div class="col-md-2">
															<div class="form-group">
																<label>Created By</label>
																<input readonly="" type="text" name="created_by" id="created_by" value="<?= $logged_name ?>" class="form-control" />
															</div>
														</div>

													</div>
													<div class="row">

														<div class="col-md-3">
															<div class="form-group">
																<label>Address</label>
																<textarea name="address" id="customer_address" class="form-control" ></textarea>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label>Note</label>
																<textarea name="note"  id="note" class="form-control" ></textarea>
															</div>
														</div>

													</div>

													<div class="row">

														<div class="col-md-3" style="margin-top: 22px;">
															<button type="button" id="stock_item_view" class="btn btn-primary" style="width:150px;">Showroom Items</button>
														</div>
														<div class="col-md-3">
															<div class="form-group" style="margin-top: 5px;">
																<label>Outlet</label>
																<select name="outlet_id" id="outlet_id" class="form-control outlet_id" required autocomplete="off">
																	<?php foreach ($outlets as $outlet_view) { ?>
																	<option  value="<?= $outlet_view->id ?>"><?= $outlet_view->name ?></option>	
																	<?php } ?>
																</select>	
															</div>
														</div>

														<div class="col-md-2">
															<div class="form-group">
																<label>Point</label>
																<input type="text"  name="point" id="point" class="form-control" />
															</div>
														</div>

														<div class="col-md-2" >
															<div class="form-group">
																<label>Balance</label>
																<input type="text"  name="balance" id="balance" class="form-control" />
															</div>
														</div>

													</div>


												</div>

										</div>

											<div id="Stock_Item_Show" style="display: none;">	
												<div class="row" style="margin-top: 10px;">
													<div class="col-md-12">
														<div class="" style="text-align: left;background: #f1f1f1;padding: 10px;">
															<h1 class="panel-title"><i class="fa fa-shopping-cart"></i> Showroom Items</h1>
														</div>
													</div>

													<div class="col-md-12" style="padding: 0px; margin-top: 10px;">
														<div class="col-md-2">
															<div class="form-group">
																<label>Warehouse</label>
																<select name="warehouse_tank" id="warehouse_tank"   class="form-control warehouse_tank" style="width: 100%;">
																	<option value="">Select Warehouse</option>					
																</select>	
															</div>
														</div>


														<div class="col-md-2">
															<div class="form-group">
																<label>Select Item / Code</label>
																<select name="product_name_code" id="product_name_code" class="form-control product_name_code" style="width: 100%;">
																	<option value="">Select Item / Code</option>
																</select>
																<div id="warehouse_tank_error" style="color: #ff0033;"></div>
															</div>
														</div>

														<div class="col-md-1">
															<div class="form-group">
																<label>G. Grade</label>
																<input type="hidden" id="grade_id" readonly="" name="grade_id"  class="form-control grade_id" />
																<input type="text" id="grade_name" readonly="" name="grade_name"  class="form-control grade_name" />
															</div>
														</div>

														<div class="col-md-1" style="display:none">
															<div class="form-group">
																<label>Bal. Stock</label>
																<input type="text" id="balance_stock" placeholder="0" readonly="" name="balance_stock"  class="form-control" />
															</div>
														</div>

														<div class="col-md-3">
															<div class="form-group">
																<label>Price</label>
																<input type="text"  onchange="setTwoNumberDecimal(this)" min="0"max="10" step="0.25" name="price" placeholder="0.0" id="product_price"  value="0" class="form-control" />
																<div id="min_product_price"></div>
															</div>
														</div>

														<!-- new adding by arafat -->
														<div class="col-md-2">
															<div class="form-group">
																<label>MinPrice</label>
																<input type="text"  name="minPrice" id="minPrice"   class="form-control" />
															</div>
														</div>
														<!-- new adding end here -->

														<div class="col-md-1">
															<div class="form-group">
																<label>Qty</label>
																<input type="text" name="qty" placeholder="0"  id="qty" value="" class="form-control" />
															</div>
														</div>
													</div>

													<div class="col-md-12" style="padding: 0px; margin-top: 10px;">
														<div class="col-md-3">
															<div class="form-group">
																<label>Discount</label>
																<input type="text" name="discount" id="discount" placeholder="0" value="" class="form-control discount" />
															</div>
														</div>

														<div class="col-md-3">
															<div class="form-group">
																<label>Tax</label>
																<input type="text" name="tax" readonly="" id="tax" placeholder="0.00" value="<?= !empty($totaltax) ? $totaltax : '' ?>" class="form-control tax" />
															</div>
														</div>



														<div class="col-md-3">
															<div class="form-group">
																<label>Weight (g)</label>
																<input type="text" name="price" id="product_weight" readonly="" class="form-control" />
															</div>
														</div>

														<div class="col-md-3" style="padding-left: 0px;">
															<div class="form-group" style="margin-top: 25px;">
																<button id="Stock_Item_submit"  class="btn btn-primary" style="width:80px;">Save</button>
															</div>
														</div>
													</div>
												</div>

												<div class="row" style="margin-top: 10px;">
													<div class="col-md-12">
														<table class="table" >
															<thead>
																<tr>
																	<th width="8%">Image</th>
																	<th width="9%">G. Grade</th>
																	<th width="9%">Code</th>
																	<th width="14%">Products</th>
																	<th style="display:none;" width="11%">Balance Stock</th>
																	<th width="9%">Price</th>
																	<th width="7%">Qty</th>
																	<th width="7%">Discount</th>
																	<th width="7%">Tax</th>
																	<th width="8%">Weight (g)</th>
																	<th width="10%">Sub Total</th>
																	<th width="14%" conspan="2" align="center" >Action</th>
																</tr>
															</thead>
															<tbody id="appendItem">
															</tbody>

															<tfoot>
																<tr>
																	<th colspan="3" style="text-align: right !important;">
																		<div style="margin-top: 10px;">Total Stock Item</div>
																	</th>
																	<th><input readonly="" type="text" name="subtotal" id="subtotal" value="0" class="form-control" /></th>
																	<th colspan="2"   style="text-align: right !important;">
																		<div style="margin-top: 10px;">Total Stock Services</div>
																	</th>
																	<th colspan="2"><input  readonly="" type="text" name="stock_services_subtotal" id="stock_services_subtotal" value="0" class="form-control" /></th>
																	<th  style="text-align: right !important;">
																		<div style="margin-top: 0px;">Grand Stock Total</div>
																	</th>
																	<th><input  readonly="" type="text" name="stock_grand_total" id="stock_grand_total" value="0" class="form-control" /></th>
																	<th></th>
																</tr>
															</tfoot>
														</table>
													</div>
												</div>

											</div>	



											<div class="row " id="show_btn_submit" style="margin-top: 10px; display: none;">
												<div class="col-md-12" style="text-align: right;">


													<button type="button" class="btn btn-primary make_payment_popup" id="make_payment_popup">Make Payment</button>
												</div>
											</div>


											<div class="row" style="margin-top: 10px;">
												<div class="col-md-12" style="margin-bottom: 10px;">
													<div class="col-md-2" style="margin-top:8px; color: #cc0033; ">
														<b>Total Amount</b>
													</div>

												</div>
												<div class="col-md-12" style="margin-bottom: 10px;">
													<div class="col-md-2" style="margin-top:8px; color: #cc0033; ">
														<b> Item Grand Total</b>
													</div>
													<div class="col-md-4">
														<input readonly=""  style="width: 200px;" type="text" name="product_total" id="product_total" value="0" class="form-control" />
													</div>
												</div>
												<div class="col-md-12" style="margin-bottom: 10px;">
													<div class="col-md-2" style="margin-top:8px;color: #cc0033; ">
														<b> Service Total </b>
													</div>
													<div class="col-md-4">
														<input readonly=""  style="width: 200px;" type="text" name="stock_service_total" id="stock_service_total" value="0" class="form-control" />
													</div>
												</div>

												<div class="col-md-12" style="margin-bottom: 10px;">
													<div class="col-md-2" style="margin-top:8px;color: #cc0033; ">
														<b>Discount Total </b>
													</div>
													<div class="col-md-4">
														<input readonly=""  style="width: 200px;" type="text" name="discount_grand_total" id="discount_grand_total" value="0" class="form-control" />
														<input readonly=""  style="width: 200px;" type="hidden" name="discount_grand_persantge" id="discount_grand_persantge" value="0" class="form-control" />
													</div>
												</div>
												<div class="col-md-12" style="margin-bottom: 10px;">
													<div class="col-md-2" style="margin-top:8px;color: #cc0033; ">
														<b>Tax Total </b>
													</div>
													<div class="col-md-4">
														<input readonly=""  style="width: 200px;" type="text" name="tax_grand_total" id="tax_grand_total" value="0" class="form-control" />
														<input readonly=""  style="width: 200px;" type="hidden" name="tax_grand_persantge" id="tax_grand_persantge" value="0" class="form-control" />
													</div>
												</div>

												<div class="col-md-12">
													<div class="col-md-2" style="margin-top:8px; color: #cc0033;">
														<b>Grand Total</b>
													</div>
													<div class="col-md-4">
														<input readonly=""  style="width: 200px;" type="text" name="grand_total" id="grand_total" value="0" class="form-control" />
													</div>
												</div>
											</div>
										</div>
									</div>

									<a href="<?= base_url() ?>Gold/view" style="text-decoration: none;">
										<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
											<i class="icono-caretLeft" style="color: #FFF;"></i>Back
										</div>
									</a>

								</div>
							</div>

							<div id="make_payment_popupshow" class="modal fade">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header" style="background-color: #5fc509;">
											<h3 class="modal-title" style="color: #FFF; text-align: center;">Make Payment </h3>
										</div>
										<div class="modal-body" style="overflow: visible; background-color: #FFF;">
											<input name="customer_id" type="hidden" value="" id="customerid"  />
											<input  type="hidden" value="" name="Outletdata_id" id="Outletdata_id"  />
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<select  id="paid_by" class="form-control ChangePayment" style="width:100%">

														</select>
														<span id="errorPayment" style="color: #cc0000;"></span>
													</div>
												</div>
												<div class="col-md-4">
													<input type="text"  class="form-control ChangeAmount" placeholder="0.00" value=""/>
													<span id="error_payment_amount" style="color: #cc0000;"></span>
												</div>
												<div class="col-md-4">
													<button class="btn btn-primary" type="button" id="AddPayment">Add Payment</button>
													<span id="add-item-loading3" style="display:none;position: absolute;top: 10%;left: 90%;"><img src="<?php echo base_url() . 'assets/img/loading.gif' ?>" /></span>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
													<span class="CheckDetail" style="display: none">
														<div class="col-md-4">
															<label>Cheque Number :</label><br>
															<input type="text" tabindex="3"  class="form-control" id="cheque" placeholder="Cheque Number" autocomplete="off" />
														</div>

														<div class="col-md-4">
															<label>Bank :</label>
															<input type="text"  id="bank" class="form-control" autocomplete="off" />
														</div>

														<div class="col-md-4">
															<label>Cheque Date :</label>
															<input type="text" id="cheque_date"  class="form-control datepicker" />
														</div>
													</span>

													<span class="CardNumber" style="display: none">
														<div class="col-md-4">
															<label>Card Number :</label>
															<input type="text"  id="addi_card_numb" class="form-control" autocomplete="off" />
														</div>
													</span>
													<span class="VoucherNumber" style="display: none">
														<div class="col-md-4">
															<label>Voucher Number :</label>
															<input type="text"  id="addi_voucher_numb" class="form-control" autocomplete="off" />
														</div>
													</span>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
													<div class="table-responsive">
														<table class="table">
															<thead>
																<tr>
																	<th>Payment Method</th>
																	<th>Amount</th>
																	<th>Action</th>
																</tr>
															</thead>
															<tbody id="addPaymentMethod">
															</tbody>
															<thead>
																<tr>
																	<th>Total Amount</th>
																	<th>
																		<input class="form-control" id="customer_total_amount" style="width: 100px;" name="total_amount" value="0" readonly="readonly" type="text">
																	</th>
																	<th></th>
																</tr>
															</thead>
														</table>

														<hr>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12" style="padding-bottom: 10px;">
													<div class="col-md-4">
														<b>Total Amount:</b>
													</div>
													<div class="col-md-4">
														<input type="text" name="grand_amount" readonly="" id="totalamount1" value="" class="form-control" />
													</div>
												</div>

												<div class="col-md-12"  style="padding-bottom: 10px;">
													<div class="col-md-4">
														<b>Total Paid:</b>
													</div>
													<div class="col-md-4">
														<input type="text" value="0"  readonly="" class="form-control tpaid" />
													</div>
												</div>
												<div class="col-md-12" style="padding-bottom: 10px;">
													<div class="col-md-4">
														<b>Balance:</b>
													</div>
													<div class="col-md-4">
														<input type="text" readonly="" value="" class="form-control BalanceAmount" />
														<input type="hidden" id="returned_change" name="returned_change" value="0" />
														<input type="hidden" id="row_column"  value="0" />
													</div>
												</div>
											</div>


										</div>

										<div class="modal-footer">
											<div class="row">
												<?php
												$us_id = $this->session->userdata('user_id');
												$get_logged_name = $this->db->get_where('users', array('id' => $us_id))->row();
												$logged_name = $get_logged_name->fullname;
												?>
												<div class="col-md-4">
													<div class="form-group">
														<label style="float: left;">Created By </label>
														<input type="text" name="created_by" class="form-control" value="<?= $logged_name ?>" readonly="">
													</div>
												</div>
												<div class="col-md-8">
													<img style="display:none;position: absolute;left: 70%;" src="<?= base_url() ?>assets/img/loading.gif" id="hide_loading" style="display:none;" >
													<button  type="submit" id="submitdata" class="btn btn-primary save_print_submit">Save & Print</button>

												</div>
											</div>
										</div>
									</div>
				<!-- Panel Body // END 
			</div>
			<!-- Panel Default // END -->
		</div>
		<br /><br /><br />
	</div>
</form>	

<br /><br />
<!--//main row delete-->
<div class="message-box animated fadeIn order_esta_popup" data-sound="alert" id="mb-signout">
	<div class="mb-container">
		<div class="mb-middle">
			<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
			<div class="mb-content">
				<p>Are you sure you want to Remove?</p>                    
				<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
				<input type="hidden" id="remove_data_ord" class="remove_data">
				<input type="hidden" id="totalval" class="totalval_data">
				<input type="hidden" id="stock_disco" class="stock_disco">
				<input type="hidden" id="stock_tax" class="stock_tax">

			</div>
			<div class="mb-footer">
				<div class="pull-right">
					<a id="remove_row" class="btn btn-success btn-lg esta_remove_row" data-dismiss="modal">Yes</a>
					<button class="btn btn-default btn-lg mb-control-close" >No</button>
				</div>
			</div>
		</div>
	</div>
</div>




<!--**service popup*-->
<div id="myModalData" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					<div class="" style="text-align: left;background: #f1f1f1;padding: 10px;">
						<h1 class="panel-title"><i class="fa fa-shopping-cart"></i> Services - <span id="product_code_popup" ></span></h1>

					</div>
				</h4>
			</div>
			<div class="modal-body">
				<form method="post" id="FormServiceSubmit"  >
					<div class="row" style="margin-top: 10px;">

						<div class="col-md-12" style="padding: 0px; margin-top: 10px;">

							<div class="col-md-5">
								<div class="form-group">
									<label>Select Service</label>
									<select name="service" id="service"  class="form-control service" style="width: 220px !important;">
										<option value="">Select Service</option>					
										<?php foreach ($getSubcategory as $subcatg_view) {
											?>
											<option  value="<?= $subcatg_view->id ?>"><?= $subcatg_view->sub_category ?></option>	
											<?php } ?>
										</select>	
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Price</label>
										<input type="text" placeholder="0" name="service_price" id="service_price" class="form-control" />
									</div>
								</div>
								<div class="col-md-3" style="padding-left: 0px;">
									<div class="form-group" style="margin-top: 28px;">
										<button  class="btn btn-primary" style="width:80px;">Add</button>
									</div>
								</div>

							</div>
						</div>

						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12">
								<table class="table popup_service_remove" >
									<thead>
										<tr>
											<th width="20%">Code</th>
											<th width="20%">Service</th>
											<th width="20%">Price</th>
											<th width="20%" align="center" >Action</th>
											<th width="20%"  align="center" >Print Invoice</th>
										</tr>
									</thead>
									<tbody id="appendItemservices">
									</tbody>
									<tfoot>
										<tr>
											<th colspan="2" style="text-align: right !important;">
												<div style="margin-top: 10px;">Total</div>
											</th>
											<th><input readonly=""  style="width: 100px;" type="text" name="service_subtotal" id="service_subtotal" value="0" class="form-control service_subtotal" /></th>
											<th colspan="2"></th>
										</tr>

									</tfoot>
								</table>
							</div>
						</div>

					</form>	
				</div>
				<div class="modal-footer">
					<button type="button"  class="btn btn-primary" id="services_stock_save" style="width:80px;" >save</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!--**end service popup*-->


	<!--***remove conform message service-->
	<div class="message-box animated fadeIn order_services_popup" data-sound="alert" id="mb-signout">
		<div class="mb-container">
			<div class="mb-middle">
				<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
				<div class="mb-content">
					<p>Are you sure you want to Remove?</p>                    
					<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
					<input type="hidden" id="remove_data_ser" class="serremove_data">
					<input type="hidden" id="totalvalser" class="totalser_data">
				</div>
				<div class="mb-footer">
					<div class="pull-right">
						<a id="remove_row" class="btn btn-success btn-lg services_remove_row" data-dismiss="modal">Yes</a>
						<button class="btn btn-default btn-lg mb-control-close" >No</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="message-box animated fadeIn order_services_popup_add" data-sound="alert" id="mb-signout">
		<div class="mb-container">
			<div class="mb-middle">
				<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
				<div class="mb-content">
					<p>Are you sure you want to Remove?</p>                    
					<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
					<input type="hidden" id="remove_data_ser" class="serremove_data">
					<input type="hidden" id="totalvalser" class="totalser_data">
				</div>
				<div class="mb-footer">
					<div class="pull-right">
						<a id="remove_row" class="btn btn-success btn-lg services_remove_row_add" data-dismiss="modal">Yes</a>
						<button class="btn btn-default btn-lg mb-control-close" >No</button>
					</div>
				</div>
			</div>
		</div>
	</div>




	<!--///check produtc and reomve paument-->


	<div class="message-box animated fadeIn payment_order_est_popup" data-sound="alert" id="mb-signout">
		<div class="mb-container">
			<div class="mb-middle">
				<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
				<div class="mb-content">
					<p>Are you sure you want to Remove?</p>                    
					<p>Press No if youwant to continue work. Press Yes to Remove current Row.</p>
					<input type="hidden" id="remove_paym_id" >
					<input type="hidden" id="remove_totlamt" >
				</div>
				<div class="mb-footer">
					<div class="pull-right">
						<a id="remove_row" class="btn btn-success btn-lg payment_order_remove_row" data-dismiss="modal">Yes</a>
						<button class="btn btn-default btn-lg mb-control-close" >No</button>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="CheckProductPopup" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Select Item / Code Message</h4>
				</div>
				<div class="modal-body">
					<h3 style="color:green;">Product already reserved.!</h3>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal" style="width:12%;">ok</button>
				</div>
			</div>
		</div>
	</div>
	<?php
	require_once $app . '/views/includes/footer.php';
	?>
	<br><br>

	<link href="<?= base_url() ?>assets/css/select2.min.css" rel="stylesheet" />
	<script src="<?= base_url() ?>assets/js/select2.min.js"></script>
	<script src="<?= base_url() ?>assets/js/jquery.validate.min.js"></script>

	<script>
		$('select').select2();
		$('.ser_custome_name').change(function (event) {
			customer_change()
		});
		customer_change();
		$('#stock_item_view').click(function () {
			$('#Stock_Item_Show').show();
			$('#show_btn_submit').show();
		});

//cal


function calamount()
{
	var Product_total = $('#subtotal').val();
	var Services_total = $('#service_subtotal').val();
	var discount_grand_total = $("#discount_grand_total").val()
	var stock_ser = $("#stock_service_total").val();
	$('#stock_services_subtotal').val(stock_ser);
	var stockgrandtotl = parseFloat(Product_total) + parseFloat(stock_ser);
	$('#stock_grand_total').val(stockgrandtotl.toFixed(2));
	var gardtotal = parseFloat(Product_total) + parseFloat(stock_ser) ;
	$("#product_total").val(parseFloat(Product_total).toFixed(2));
	$("#service_total").val(parseFloat(Services_total).toFixed(2));
	$("#grand_total").val(parseFloat(gardtotal).toFixed(2));


}

//end cal
function customer_change()
{
	var id = $('.ser_custome_name').attr('id');
	var customer_id = $(".ser_custome_name option:selected").val();
	$.ajax({
		type: 'POST',
		url: "<?= base_url(); ?>sales/get_matchCustomername",
		data: {id: customer_id},
		dataType: 'JSON',
		success: function (data) {
			$('#id').val(data.id);
			$('#customer_name').val(data.customer_name);
			$('#customer_mobile').val(data.customer_mobile);
			$('#customer_email').val(data.customer_email);
			$('#customer_address').val(data.customer_address);
			$('#balance').val(data.balance);
//                $('#customer_order_no').html(data.customer_order_no);
}
});
}



$('#customer_order_no').change(function(){
	var id = $(this).val();
	var data_val = $('#customer_order_no option:selected').attr('data-val');
	var data_sales_id = $('#customer_order_no option:selected').attr('data-sale');
	$.ajax({
		url: "<?=base_url()?>Sales/getgoldOrderItem",
		method: "post",
		dataType: 'json',
		data: {data: id,customer_id:data_val,data_sales_id:data_sales_id},
		success: function (data) {
			$("#product_name_code").html(data.success);
			$(".ser_custome_name").html(data.customer);
			$("#user_sales").html(data.sales);
			customer_change();
		}
	});
});


$('.outlet_id').change(function (event) {
	outletdata();
	make_pyment_method();
});

make_pyment_method();
function make_pyment_method()
{
	var oultet_id = $(".outlet_id").val();
	$.ajax({
		type: 'POST',
		url: "<?= base_url(); ?>sales/getMakepayment_name",
		data: {outlet_id: oultet_id},
		dataType: 'JSON',
		success: function (data) {
			$('#paid_by').html(data.success);

		}
	});
}


function outletdata()
{
	var oultet_id = $(".outlet_id").val();
	$.ajax({
		type: 'POST',
		url: "<?= base_url(); ?>sales/getOutletWiseWarehouse",
		data: {outlet_id: oultet_id},
		dataType: 'JSON',
		success: function (data) {
			$('.warehouse_tank').html(data.success);
			warehousegetdata();
		}
	});
}
outletdata();


$('.warehouse_tank').change(function (event) {
	warehousegetdata();
});

function warehousegetdata()
{
	var outlet_id = $('.outlet_id').val();
	var wareid = $(".warehouse_tank option:selected").val();
	var type = $('.warehouse_tank option:selected').attr('data-val');
	;
	$.ajax({
		type: 'POST',
		url: "<?= base_url(); ?>sales/getOutletWiseWarehouseProduct",
		data: {wareid: wareid, outlet_id: outlet_id, type: type},
		dataType: 'JSON',
		success: function (data) {
			$('#product_name_code').html(data.product);
			$('#product_price').val('');
			$('#balance_stock').val('');
		}
	});
}

$('.product_name_code').change(function (event) {
	var outlet_id = $('.outlet_id').val();
	var warehouse_tank = $('.warehouse_tank').val();
	$('#outlet_error').html('');
	$('#warehouse_tank_error').html('');
	var type = $('.warehouse_tank option:selected').attr('data-val');
	var product_code = $(this).val();
	$.ajax({
		type: 'POST',
		url: "<?= base_url(); ?>sales/getProductDetailInventory",
		data: {product_code: product_code, outlet_id: outlet_id, warehouse_tank: warehouse_tank, type: type},
		dataType: 'JSON',
		success: function (data) {
			if (data.status == 1)
			{
				$('#CheckProductPopup').modal('show');
			}
			//$('#product_price').val(data.product_price); //old_a2
			$('#product_price').val(accounting.formatMoney(data.product_price)); //new a2
			$('#balance_stock').val(data.balance_stock);
			$('#product_weight').val(data.product_weight);
			$('#grade_id').val(data.grade_id);
			$('#grade_name').val(data.grade_name);
			//$('#min_product_price').html(data.ProductMinPrice);
			$('#minPrice').val(accounting.formatMoney(data.ProductMinPrice)); //by a2
		}
	});

});

//*********************************item shop*************************
//image
function readURL(input,id) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#previewimage'+id).attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

$('#appendItem').delegate('.stockimagepreview','click',function(){
	var id = $(this).attr('data-val');
	$('#uploadFile'+id).click();
});

$('#appendItem').delegate('.previewimageUploadFile','change',function(){
	var id = $(this).attr('data-val');
	readURL(this,id);
});


var row_item = 1;
$('#Stock_Item_submit').click(function (e) {

	e.preventDefault();
	var outlet_id			= $('.outlet_id').val();
	var warehouse_tank		= $('.warehouse_tank').val();
	var product_code_val	= $("#product_name_code option:selected").val();
	var product_name_code	= $("#product_name_code option:selected").text();
	var gold_grade_id		= $("#grade_id").val();
	var gold_grade_name		= $("#grade_name").val();
		var balance_stock		= $("#balance_stock").val();//qty
		var product_price		= $('#product_price').val();
		var qty					= $('#qty').val();
		var discount_perce		= $('#discount').val();
		var tax					= $('#tax').val();
		var product_weight		= $('#product_weight').val();
		var total_val			= parseFloat(qty * product_price).toFixed(2);
		var calculateTax		= tax / 100 * total_val;
		total_val				= parseFloat(total_val) + parseFloat(calculateTax);
		//var min_product_price = $('#min_product_price').html();
		var min_product_price = $('#minPrice').val();
		if(min_product_price == "")
		{
			min_product_price = 0;
		}
			//check discount less then amount
			if (discount_perce.indexOf("%") >= 0)
			{
				var discount = discount_perce.substr(0, discount_perce.indexOf('%'));
				var discountamt = parseFloat((discount / 100) * total_val).toFixed(2);
				var netamount = parseFloat(total_val - discountamt).toFixed(2);
			} else
			{
				var discountamt = discount_perce;
				var netamount = parseFloat(total_val - discountamt).toFixed(2);
			}
			//end
			if ((parseFloat(qty) == '0') || (parseFloat(qty) == '')|| (qty == ""))
			{
				alert("Please add at least one item!!");
			} 
			else if (parseFloat(balance_stock) < parseFloat(qty))
			{
				alert("Balance stock less than qty !!");
			}
			else if (parseFloat(product_code_val) == "" || product_code_val == "")
			{
				alert("Please Select Item / Code !!");
			}
			else if (parseFloat(netamount) < 0 )
			{
				alert("Discount less than amount !!");
			}
			else if(parseFloat(min_product_price) > parseFloat(product_price))
			{
				alert("Please enter price less than minimum price!!");
			}
			else
			{

				if (calculateTax == '')
				{
					calculateTax = 0;
				}
				var tax_grand_total = $('#tax_grand_total').val();
				$("#tax_grand_total").val((parseFloat(calculateTax) + parseFloat(tax_grand_total)).toFixed(2));

				if (discountamt == '')
				{
					discountamt = 0;
				}
				var discount_grand_total = $('#discount_grand_total').val();
				$("#discount_grand_total").val((parseFloat(discountamt) + parseFloat(discount_grand_total)).toFixed(2));


				var html = '<tr id="RemoveData' + row_item + '">\n\
				<td><img data-val='+row_item+' id="previewimage'+row_item +'" class="stockimagepreview"  src="<?php echo base_url(); ?>assets/img/product_image.gif" style="cursor: pointer;height: 60px;width: 60px;position: relative;z-index: 10;"/>\n\
				<input type="file" data-val='+row_item+' class="previewimageUploadFile" id="uploadFile'+ row_item +'" name="return[' + row_item + '][product_image][]"  style="position: absolute; margin: 0px auto; visibility: hidden;" accept="image/*" />\n\
				</td>\n\
				<td>' + gold_grade_name + '</td>\n\
				<td><input type="text" readonly name="return[' + row_item + '][product_code_val]" value="' + product_code_val + '" class="form-control">\
				<input type="hidden" name="return[' + row_item + '][outlet_id]" value="' + outlet_id + '" class="form-control">\n\
				<input type="hidden" name="return[' + row_item + '][warehouse_tank]" value="' + warehouse_tank + '" class="form-control">\n\
				<input type="hidden" name="return[' + row_item + '][product_service_id]" value="' + product_code_val + row_item + '" class="form-control">\n\
				<input type="hidden" name="return[' + row_item + '][discount_amount]" value="' + discountamt + '" class="form-control">\n\
				<input type="hidden" name="return[' + row_item + '][gold_grade_id]" value="' + gold_grade_id + '" class="form-control">\n\
				<input type="hidden" name="return[' + row_item + '][tax_amount]" value="' + calculateTax + '" class="form-control">\n\
				</td>\n\
				<td><input type="text" readonly name="return[' + row_item + '][product_name_code]" value="' + product_name_code + '" class="form-control"></td>\n\
				<td style="display:none;"><input type="text" readonly name="return[' + row_item + '][balance_stock]"			 value="' + balance_stock + '" class="form-control"></td>\n\
				<td><input type="text" readonly name="return[' + row_item + '][product_price]"	 value="' + product_price + '" class="form-control"></td>\n\
				<td><input type="text" readonly name="return[' + row_item + '][qty]"		 value="' + qty + '" class="form-control"></td>\n\
				<td><input type="text" readonly name="return[' + row_item + '][discount]"		 value="' + discount_perce + '" placeholder="0" class="form-control all_discount_persentge"></td>\n\
				<td><input type="text" readonly name="return[' + row_item + '][tax]"		 value="' + tax + '" class="form-control all_tax_persentge"></td>\n\
				<td><input type="text"readonly name="return[' + row_item + '][product_weight]" value="' + product_weight + '" class="form-control"></td>\n\
				<td><input type="text"readonly name="return[' + row_item + '][total_val]" value="' + netamount + '" class="form-control">\n\
				<td width="12%">\n\
				<span style="cursor:pointer" data-tax-stock="' + calculateTax + '" data-dis-stock="' + discountamt + '" data-val="' + netamount + '" class="btn btn-primary btn-circle removeItem" id="' + row_item + '" ><i class=" glyphicon glyphicon-trash"></i></span>\n\
				<span style="cursor:pointer" data-val="' + product_code_val + '" class="btn btn-primary PopupServices " id="' + row_item + '" >Services</span></td>\n\
				</tr><tr><td colspan="100%" style="display:none;" id="service_append_hide' + row_item + '"><table class="table main_service_remove"><thead><tr><th width="20%">Code</th><th width="20%">Service</th><th width="20%">Price</th><th width="10%">Action</th><th width="10%">Print Invoice</th></tr></thead> <tbody id="service_append' + row_item + '"></tbody></table> </td></tr>';

				$('#appendItem').append(html);
				var subtotal = $('#subtotal').val();
				var finaltotal = parseFloat(subtotal) + parseFloat(netamount);
				$('#subtotal').val(finaltotal);
				outletdata();
				$(".warehouse_tank").select2().val("").trigger("change");
				$('#qty').val('');
				$('#discount').val('');
				$('#product_weight').val('');
				//$('#min_product_price').html('');
				$('#minPrice').val('');
				row_item++;
				calamount();
			}
		});

//services

var row = 0;
$('#FormServiceSubmit').submit(function (e) {

	e.preventDefault();
	var services_id = $('.service option:selected').val();
	var services_price = $('#service_price').val();
	var services_name = $(".service option:selected").text();
	var product_code_id = $("#product_code_popup").text();
	var total_val = services_price;

	if (services_id == "")
	{
		alert("Please select Service!!");
	} else if (services_price == 0 || services_price == "")
	{
		alert("Please add at least one item!!");
	} else
	{
		var html = '<tr id="RemoveDataService' + row + '" >\n\
		<td >' + services_id + '\
		<input type="hidden" name="return[' + product_code_id + '][sales_return][' + row + '][product_service_id]" value="' + product_code_id + '" class="form-control">\n\
		<input type="hidden" name="return[' + product_code_id + '][sales_return][' + row + '][services_id]" value="' + services_id + '" class="form-control">\n\
		</td>\n\
		<td>' + services_name + '</td>\n\
		<td><input type="text" style="width: 125px;" readonly name="return[' + product_code_id + '][sales_return][' + row + '][services_price]" value="' + services_price + '" class="form-control stock_ser_price"></td>\n\
		<td><span style="cursor:pointer" data-val="' + total_val + '" class="btn btn-primary btn-circle RemoveDataService"  id="' + row + '" ><i class=" glyphicon glyphicon-trash"></i>  </span></td>\n\
		<td> <span class="yes_print">  <input type="checkbox"  class="checkbox_event_stock_service"  name="return[' + product_code_id + '][sales_return][' + row + '][pre_print_invoice]" value="1" > </span></td>\n\
		</tr>';
		$('#appendItemservices').append(html);
		var service_subtotal = $('#service_subtotal').val();
		var finaltotal = parseFloat(service_subtotal) + parseFloat(total_val);
		$('#service_subtotal').val(finaltotal);
		$(".service").select2().val("").trigger("change");
		$('#service_price').val('');
		row++;

	}

});

//end services
$(".popup_service_remove").delegate(".RemoveDataService", "click", function () {
	var id = $(this).attr('id');
	var totalval = $(this).attr('data-val');
	$('.serremove_data').val(id);
	$('.totalser_data').val(totalval);
	$('.order_services_popup_add').modal('show');
});

$(".services_remove_row_add").click(function () {
	var id = $('.serremove_data').val();
	var total_val = $('.totalser_data').val();
	var service_subtotal_popup = $("#service_subtotal").val();
	if (parseFloat(service_subtotal_popup) != 0)
	{
		$("#service_subtotal").val((parseFloat(service_subtotal_popup) - parseFloat(total_val)));
	}
	$("#RemoveDataService" + id).remove();
});



//remove service
$("#Stock_Item_Show").delegate(".RemoveDataService", "click", function () {
	var id = $(this).attr('id');
	var totalval = $(this).attr('data-val');
	$('.serremove_data').val(id);
	$('.totalser_data').val(totalval);
	$('.order_services_popup').modal('show');
});

$(".services_remove_row").click(function () {
	var id = $('.serremove_data').val();
	var total_val = $('.totalser_data').val();
	var service_subtotal_popup = $("#service_subtotal").val();
	if (parseFloat(service_subtotal_popup) != 0)
	{
		$("#service_subtotal").val((parseFloat(service_subtotal_popup) - parseFloat(total_val)));
	}
	var stock_ser = $("#stock_service_total").val();
	if (parseFloat(stock_ser) != 0)
	{
		$("#stock_service_total").val((parseFloat(stock_ser) - parseFloat(total_val)).toFixed(2));
		calamount();
	}
	$("#RemoveDataService" + id).remove();


});
//end

//save service addd

$('#services_stock_save').click(function (e) {

	var service_subtotal = $('#service_subtotal').val();
	if (service_subtotal == 0 || service_subtotal == "")
	{
		alert("Please add atleast one service!!");
	} else
	{
            //server stock item
            var stcok_service_subtotal = $('#service_subtotal').val();
            var stock_service_total = $('#stock_service_total').val();
            $("#stock_service_total").val((parseFloat(stcok_service_subtotal) + parseFloat(stock_service_total)).toFixed(2));
            calamount()
            //
            var Product_code = $('#product_code_popup').text();
            $('#service_append_hide' + Product_code).show();
            var serviceval = $('#appendItemservices').html();
            $('#service_append' + Product_code).append(serviceval);
            $(".service").select2().val("").trigger("change");
            $('#service_price').val('');
            $('#appendItemservices').html('');
            $('#service_subtotal').val('0');
            $('#myModalData').modal('hide');

        }
    });

	//checkbox
	$("#myModalData").delegate(".checkbox_event_stock_service", "change", function () {

		if ($(this).is(":checked")) {
			this.setAttribute("checked", "checked");
		} else
		{
			this.setAttribute("checked", "checked");
		}

	});
//end se

    //popup
    $(".table").delegate(".removeItem", "click", function () {
    	var id = $(this).attr('id');
    	var totalval = $(this).attr('data-val');
    	var stock_disco = $(this).attr('data-dis-stock');
    	var stock_tax = $(this).attr('data-tax-stock');
    	$('.remove_data').val(id);
    	$('.totalval_data').val(totalval);
    	$('.stock_disco').val(stock_disco);
    	$('.stock_tax').val(stock_tax);
    	$('.order_esta_popup').modal('show');
    });

    $(".esta_remove_row").click(function () {
    	var id = $('.remove_data').val();
    	var total_val = $('.totalval_data').val();

        //service remove
        $('#service_append' + id).each(function () {
        	var totalstockprice = 0;
        	$(this).find('input.stock_ser_price').each(function () {
        		totalstockprice = totalstockprice + parseFloat($(this).val());
        	});

        	var stock_serv_totl = $('#stock_service_total').val();
        	var total_order_ser = (parseFloat(stock_serv_totl) - parseFloat(totalstockprice)).toFixed(2);
        	$("#stock_service_total").val(total_order_ser);
        });

        //end service
        //tax remove
        var stock_tax = $('#stock_tax').val();
        var tax_grand_total = $('#tax_grand_total').val();
        var total_tax = (parseFloat(tax_grand_total) - parseFloat(stock_tax)).toFixed(2);
        $("#tax_grand_total").val(total_tax);

        //endtax
        //discount
        var stock_discount = $('#stock_disco').val();
        var discount_grand_total = $('#discount_grand_total').val();
        var total_discount = (parseFloat(discount_grand_total) - parseFloat(stock_discount)).toFixed(2);
        $("#discount_grand_total").val(total_discount);
        //end discount
        var subtotal = $('#subtotal').val();
        var finaltotal = parseFloat(subtotal) - parseFloat(total_val);
        $('#subtotal').val(finaltotal);
        $("#service_append_hide" + id).remove();
        $("#RemoveData" + id).remove();
        calamount();
    });
    // popup	

    $("tbody").delegate(".PopupServices", "click", function () {
    	var id = $(this).attr('id');
    	$('#service_subtotal').val('0');
    	$('#product_code_popup').html(id);
    	$('#myModalData').modal('show');
    });



//end*******	
//payment
$('#make_payment_popup').click(function () {
	var grand_total			= $('#grand_total').val();
	var balant				= $('.BalanceAmount').val();
	var ser_custome_name	= $('#ser_custome_name').val();
	var user_sales			= $('#user_sales').val();
	$('#submitdata').hide();
	if (parseFloat(grand_total) == 0)
	{
		$('#submitdata').show();
	}
	if ((parseFloat(ser_custome_name) == 0) || ser_custome_name == "" && (parseFloat(user_sales) == 0) || user_sales == "")
	{
		alert("Please add at Search Customer & Sales Person !!");
	} else if ((parseFloat(grand_total) == 0) || grand_total == "")
	{
		alert("Please add at least one item!!");
	} else
	{
		$('#totalamount1').val(grand_total);
		$('.BalanceAmount').val(grand_total);
		$('#make_payment_popupshow').modal('show');
	}
});


$('.ChangePayment').change(function () {
	var paymenttype = $(".ChangePayment option:selected").text();
	$('#errorPayment').hide();
	if (paymenttype == 'Cheque')
	{
		$('#addi_card_numb').val('');
		$('.CardNumber').hide();
		$('.VoucherNumber').hide();
		$('.CheckDetail').show();
	} else if (paymenttype == 'Credit cards')
	{
		$('#cheque').val('');
		$('#bank').val('');
		$('#cheque_date').val('');
		$('.CheckDetail').hide();
		$('.VoucherNumber').hide();
		$('.CardNumber').show();
	}
	else if (paymenttype == 'Vouchers')
	{
		$('#addi_voucher_numb').val('');
		$('.CheckDetail').hide();
		$('.CardNumber').hide();
		$('.VoucherNumber').show();
	}
	else
	{
		$('#cheque').val('');
		$('#bank').val('');
		$('#cheque_date').val('');
		$('#addi_card_numb').val('');
		$('#addi_voucher_numb').val('');
		$('.CheckDetail').hide();
		$('.CardNumber').hide();
		$('.VoucherNumber').hide();
	}
});


function deletedivpay(ele) {
	var removevalue = ele;
	var total_paid	= $('.tpaid').val();
	var totalamount = parseFloat($('#totalamount1').val());
	var newtotal	= total_paid - removevalue;
	$("#customer_total_amount").val(newtotal);
	var a	= $(".tpaid").val(newtotal);
	var aa	= $(".tpaid").val();
	var b	= totalamount - aa;
	$('.BalanceAmount').val(parseFloat(b));
	var tpaid	 = $('.tpaid').val();
	var balant	 = $('.BalanceAmount').val();
	$('#submitdata').hide();

	if (parseFloat(tpaid) != 0 && parseFloat(tpaid) != "" && parseFloat(totalamount) >= parseFloat(tpaid) )
	{
		$('#submitdata').show();
	}

}

$("#addPaymentMethod").on('click', '#btndelete', function () {
	var id = $(this).attr('data-id');
	var totlamt = $(this).attr('data-totlamt');
	$('#remove_paym_id').val(id);
	$('#remove_totlamt').val(totlamt);
	$('.payment_order_est_popup').modal('show');
});

$('.payment_order_remove_row').click(function () {
	var id = $('#remove_paym_id').val();
	var totlamt = $('#remove_totlamt').val();
	$('#paym' + id).remove();
	deletedivpay(totlamt);
	$('.payment_order_est_popup').modal('hide');
});


$('#AddPayment').click(function () {
	var paid_by = $('#paid_by').val();
	var amount = $('.ChangeAmount').val();
	if (paid_by == "")
	{
		$('#errorPayment').show();
		$('#errorPayment').html('Please select payment type!!');
	} else if ((parseFloat(amount) == 0) || (parseFloat(amount) == "")|| (amount == ""))
	{
		$('#error_payment_amount').show();
		$('#error_payment_amount').html('');
		$('#error_payment_amount').html('Please Enter Amount!!');
	} else
	{
		var row_column				= $('#row_column').val();
		var customer_total_amount	= $('#customer_total_amount').val();
		var payname					= $('#paid_by option:selected').text();
		var cheque					= $('#cheque').val();
		var bank					= $('#bank').val();
		var cheque_date				= $('#cheque_date').val();
		var addi_card_numb			= $('#addi_card_numb').val();
		var addi_voucher_numb		= $('#addi_voucher_numb').val();
		var customer_name			= $('#customer_name').val();
		var finaltotal				= parseFloat(customer_total_amount) + parseFloat(amount);
		$('#customer_total_amount').val(finaltotal);
		$('.tpaid').val(finaltotal);


		var cell = $('<tr id="paym' + row_column + '"><td><label>' + payname + '</label> <input type="hidden" value="' + paid_by +
			'" name="payment[' + row_column + '][paid_by]" /> <input type="hidden" value="' + cheque +
			'" name="payment[' + row_column + '][cheque]"  /> <input type="hidden" value="' + addi_card_numb +
			'" name="payment[' + row_column + '][addi_card_numb]"  /> <input type="hidden" value="' + bank +
			'" name="payment[' + row_column + '][bank]"  /> <input type="hidden" value="' + cheque_date +
			'" name="payment[' + row_column + '][cheque_date]"   /> <input type="hidden" value="' + addi_voucher_numb +
			'" name="payment[' + row_column + '][addi_voucher_numb]"  /></td>\n\
			<td><input class="form-control" style="width: 100px;" type="text" readonly value="' + amount +
			'" name="payment[' + row_column + '][paid]" ></td><td><i class="glyphicon glyphicon-remove-sign" id="btndelete" data-id=' + row_column + ' data-totlamt=' + amount + ' style="color: red; cursor: pointer; font-size: 28px;"></i></td></tr>');
		$('#addPaymentMethod').append(cell);

		row_column++;

		$('#row_column').val(row_column);
		var totalamount1 = $('#totalamount1').val();
		var tpaid = $('.tpaid').val();
		$('.ChangeAmount').val('')
		$('#errorPayment').hide();
		$('#error_payment_amount').hide();
		$('#submitdata').hide();


		if (parseFloat(tpaid) != 0 && parseFloat(tpaid) != "" && parseFloat(totalamount1) >= parseFloat(tpaid))
		{
			$('#submitdata').show();
		}

		$('#cheque').val('');
		$('#bank').val('');
		$('#cheque_date').val('');
		$('#addi_card_numb').val('');
		$('.CheckDetail').hide();
		$('.CardNumber').hide();
		$('.VoucherNumber').hide();
	}


});

$('.ChangeAmount').keyup(function () {
	var total_paid = $(this).val();
	if (total_paid == 0 || total_paid == '') {
		total_paid = 0;
	}
	$('#returned_change').val(parseFloat(total_paid).toFixed(2));
	var balance1 = parseFloat($('#totalamount1').val()) - parseFloat($('.tpaid').val());
	var balance = parseFloat(balance1) - parseFloat(total_paid);
	var balance = parseFloat(balance).toFixed(2);
	$('.BalanceAmount').val(balance);
	$('#error_payment_amount').hide();

});
//end payment
//add customer
 //add new customer
 $('.PopupCustomerclick').click(function () {
 	$('#PopupCustomer').modal('show');
 });

 $("#add_customer").validate({
 	rules: {
 		fullname: "required",
 		email: {
 			required: true,
 			email: true,
 		},
 		nic: "required",

 		password: {
 			required: true,
				//number: true,
			},
			conpassword: {
				required: true,
				equalTo: '[name="password"]'
			},

			outlet_id: "required",

		},
		messages: {
			fullname: "Please enter your first name",
			password: {
				required: "Please provide a password",
			},
			email: "Please enter a valid email address",
			nic: "Please enter your group ",
			outlet_id: "Please enter your choice",

		},

		submitHandler: function (form) {
			var formData = new FormData();
			var contact = $('#add_customer').serializeArray();
			$.each(contact, function (key, input) {
				formData.append(input.name, input.value);
			});
			//	alert(formData);
			$
			$.ajax({
				type: 'POST',
				url: "<?= base_url(); ?>sales/addCustomerorder_estimate",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: 'JSON',
				success: function (data) {
					if (data.error_email)
					{
						$('#message_customer').html(data.error_email);
					} else
					{
						alert(data.success);
						$('.customer_empty').val('');
						$('#ser_custome_name').append(data.customer_id);
						customer_change();
						$('#PopupCustomer').modal('hide');
					}

				}
			});

		}
	});

//submit data all

$("#FormStockItemSubmit").on('submit', (function (e) {
	e.preventDefault();
	$('#hide_loading').show();
	var total_percentage = 0;
	$('.all_discount_persentge').each(function () {
		var discount = $(this).val();
		if (discount.indexOf("%") >= 0) {
			var discount_perstg = discount.substr(0, discount.indexOf('%'));
			total_percentage = total_percentage + parseFloat(discount_perstg);
		}
	});
	$("#discount_grand_persantge").val(total_percentage);
	var total_tax_percentage = 0;
	$('.all_tax_persentge').each(function () {
		total_tax_percentage = total_tax_percentage + parseFloat($(this).val());
	});
	$("#tax_grand_persantge").val(total_tax_percentage);

	var tpaid = $('.tpaid').val();
	var totalamount1 = $('#totalamount1').val();
	if (parseFloat(tpaid) > parseFloat(totalamount1))
	{
		alert("Please check total amount and total paid wrong !!");

	} 
	else
	{
		$.ajax({
//					url: "<?= base_url() ?>Gold/customer_order_esatb_add",
url: "<?= base_url() ?>sales/add_sales_invoice",
type: "POST",
data: new FormData(this),
contentType: false,
cache: false,
processData: false,
success: function (data) {
	alert('successfully add');
	window.location.href = '<?= base_url() ?>sales/sales_invoice';
//						window.location.href = '<?= base_url() ?>sales/view_invoice?id=' + data;
},
});
	}
}));


//end data all
//end customer

$(".datepicker").datepicker({
	format: 'yyyy-mm-dd',
	autoclose: true,
});

$(".ExpectedDeliveryDate").datepicker({
	format: 'yyyy-mm-dd',
	autoclose: true,
});
</script>