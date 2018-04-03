<?php
//require_once '../includes/header.php';
$this->load->view('includes/header');
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Daily Summary Report</h1>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<form action="" method="get">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input required="" type="text" name="start_date" class="form-control ChagneDateEnd" id="startDate"
										value="<?= !empty($this->input->get('start_date')) ? $this->input->get('start_date') : '' ?>"/>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Outlet</label>
									<select class="form-control" name="outlet">
										<?php
										foreach ($getOutlet as $out)
										{ 
											$selected = '';
											if(!empty($this->input->get('outlet')))
											{
												if($this->input->get('outlet') == $out->id)
												{
													$selected = 'selected';
												}
											}
											?>
										<option <?=$selected?> value="<?=$out->id?>"><?=$out->name?></option>
										<?php 
										}
										?>
										
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br/>
									<input type="submit" class="btn btn-primary" value="Search"/>
								</div>
							</div>
						</div>
					</form>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive table-striped">
								<table class="table daily_summary_report" cellspacing="0" width="100%">
									<thead>
                                        <tr>
											<th style="display: none;">#</th>
											<th width="20%">#</th>
											<?php
											$outletarray=array();
											foreach ($getOutlet as $outlet)
											{
												array_push($outletarray,$outlet->id);
											?>
                                            <th style="font-size: 24px;"><?=$outlet->name?></th>
                                            
											<?php }
											?>
                                        </tr>
									</thead>
									<tbody>
										<tr>
											<td style="display: none;">2</td>
											<td>Sale Amount</td>
											<?php
											foreach ($outletarray as $outlet)
											{ 
												$totalsale = $this->Constant_model->getDailySummaryReport($outlet);
												
												?>
											<td><?=!empty($totalsale->totalsale)?number_format($totalsale->totalsale,2):'0.00'?></td>
										<?php }
											?>
										</tr>
										
										<tr>
											<td style="display: none;">3</td>
											<td><span style="color: #cc3300;"><b>Payment Receipt on Sales:</b></span></td>
											<?php
											foreach ($outletarray as $outlet)
											{ 
												?>
												<td></td>
										<?php }
											?>
										</tr>
										
										
										<?php
										$p = 5;
										foreach ($getPaymentType as $payment)
										{
										?>
											<tr>
												<td style="display: none;"><?=$p++;?></td>
												<td><?=$payment->name?></td>
												<?php
												foreach ($outletarray as $outlet)
												{ 
													$payment_id = $this->Constant_model->getSpecificPaymentID($outlet,$payment->name);
													$cash = $this->Constant_model->getDailySummaryReportCash($outlet,$payment_id);
													?>
												<td><?=!empty($cash->paymentamount)?number_format($cash->paymentamount,2):'0.00'?></td>
												<?php 
												}
												?>
											</tr>
										<?php 
										}
										?>
										
										
										
										<?php
										if(!empty($this->input->get('start_date')))
										{
										?>
										<tr>
											<td style="display: none;"><?=$p?></td>
											<td>Date</td>
										`	<?php
											$outi = 0;
											foreach ($outletarray as $outlet)
											{ ?>
											
											<td> 
												<?php
												if($outi == 0)
												{
												?>
												<?=$this->input->get('start_date')?>
												<?php }
												$outi++;
												?>
											</td>
											<?php } ?>
										</tr>
									<?php } ?>
										
									</tbody>
								</table>
								<hr>
								<table id="" class="table daily_summary_report" cellspacing="0" width="100%">
									<thead>
                                        <tr>
											<th style="display: none;">#</th>
											<th width="20%"><span style="color: #cc3300;"><b>Outstanding:</b></span></th>
											<th></th>
                                        </tr>
									</thead>
									<tbody>
										<tr>
											<td style="display: none;">1</td>
											<td>Opening Balance</td>
											<td>
												<?php
												 $BFOutstanding = $this->Constant_model->BFOutstanding();
												 echo !empty($BFOutstanding)?number_format($BFOutstanding ,2):'0.00';
												?>
											</td>
										</tr>
										<tr>
											<td style="display: none;">2</td>
											<td>Today Outstanding</td>
											<td>
												<?php
													$TodayOutstanding = $this->Constant_model->TodayOutstanding();
													echo !empty($TodayOutstanding)?number_format($TodayOutstanding ,2):'0.00';
												?>
											</td>
										</tr>
										<tr>
											<td style="display: none;">3</td>
											<td>Outstanding Received</td>
											<td>
												<?php
													$OutstandingReceived = $this->Constant_model->OutstandingReceived();
													echo !empty($OutstandingReceived)?number_format($OutstandingReceived,2):'0.00';
												?>
											</td>
										</tr>
										<tr>
											<td style="display: none;">4</td>
											<td>Balance Outstanding</td>
											<td>
												<?php
													$totalbalance = $BFOutstanding + $TodayOutstanding;
													$BalanceOutstanding = $totalbalance - $OutstandingReceived;
													echo !empty($BalanceOutstanding)?number_format($BalanceOutstanding,2):'0.00';
												?>
											</td>
										</tr>
										<?php
										if(!empty($this->input->get('start_date')))
										{
										?>
										<tr>
											<td style="display: none;">9</td>
											<td>Date </td>
											<td colspan="100%"> 
												<?=$this->input->get('start_date')?>
											</td>
										</tr>
									<?php } ?>
										
									</tbody>
								</table>
								<hr>
								<table id="" class="table daily_summary_report" cellspacing="0" width="100%">
									<thead>
                                        <tr>
											<th style="display: none;">#</th>
											<th width="20%"><span style="color:#cc3300; ">Sub Category:</span></th>
											<?php
											$subcategory = array();
											foreach ($getSubCategory as $subcate)
											{
												array_push($subcategory,$subcate->id);
												?>
												<th><?=$subcate->sub_category?></th>
												<?php 
											}
											?>
                                        </tr>
									</thead>
									<tbody>
										<tr>
											<td style="display: none;">1</td>
											<td>Sold Qty</td>
											<?php
											foreach ($subcategory as $sub)
											{ ?>
											<td>
												<?php
													$totalsubqty = $this->Constant_model->getSubCategoruQty($sub);
													echo !empty($totalsubqty->totalqty)?number_format($totalsubqty->totalqty,2):'0.00';
												?>
											</td>
											<?php }
											?>
										</tr>
										
										<tr>
											<td style="display: none;">2</td>
											<td>Sold Amount</td>
											<?php
											foreach ($subcategory as $sub)
											{ ?>
											<td>
												<?php
													$totalsubqty = $this->Constant_model->getSubCategoruQty($sub);
													echo !empty($totalsubqty->totalPurchaseprice)?number_format($totalsubqty->totalPurchaseprice,2):'0.00';
												?>
											</td>
											<?php }
											?>
										</tr>
										<tr>
											<td style="display: none;">3</td>
											<td>Balance Stock</td>
											<?php
											foreach ($subcategory as $sub)
											{ ?>
											<td>
												<?php
													echo $availableBalance = $this->Constant_model->getSubCategoryBalanceQty($sub);
												?>
											</td>
											<?php }
											?>
										</tr>
										<?php
										if(!empty($this->input->get('start_date')))
										{
										?>
										<tr>
											<td style="display: none;">4</td>
											<td>Date </td>
											<?php
											$subi = 0;
											foreach ($subcategory as $sub)
											{ ?>
											<td> 
												<?php
												if($subi == 0)
												{
												?>
												<?=$this->input->get('start_date')?>
												<?php } 
												$subi++;
												?>
												
											</td>
											<?php
											}
											?>
										</tr>
									<?php } ?>
										
									</tbody>
								</table>
								
								<hr>
								
								
								<table id="" class="table daily_summary_report" cellspacing="0" width="100%">
									<thead>
                                        <tr>
											<th style="display: none;">#</th>
											<th width="20%"><span style="color:#cc3300; ">Category:</span></th>
											<?php
											$categoryarray = array();
											foreach ($getCategory as $category)
											{
												array_push($categoryarray,$category->id);
												?>
												<th><?=$category->name?></th>
												<?php 
											}
											?>
                                        </tr>
									</thead>
									<tbody>
										<tr>
											<td style="display: none;">1</td>
											<td>Sale Qty</td>
											<?php
											foreach ($categoryarray as $cat)
											{ ?>
											<td>
												<?php
												$totalqty = $this->Constant_model->getCategoryWiseSaleQty($cat);
												echo !empty($totalqty->totalqty)?number_format($totalqty->totalqty,2):'0.00';
												?>
											</td>
											<?php }
											?>
										</tr>
										
										<tr>
											<td style="display: none;">2</td>
											<td>Sale Amount</td>
											<?php
											$totalcategoryamount = 0;
											foreach ($categoryarray as $cat)
											{ ?>
											<td>
												<?php
												$totalamount = $this->Constant_model->getCategoryWiseSaleQty($cat);
												if(!empty($totalamount->totalgrandtotal))
												{
													$salesamount = $totalamount->totalgrandtotal;
													$totalcategoryamount  = $totalcategoryamount + $salesamount;
												}
												else
												{
													$salesamount = 0;
												}
												echo !empty($salesamount)?number_format($salesamount,2):'0.00';
												?>
											</td>
											<?php }
											?>
										</tr>
										
										
										<?php
										if(!empty($this->input->get('start_date')))
										{
										?>
										<tr>
											<td style="display: none;">3</td>
											<td>Date </td>
											<?php
											$cati = 0;
											foreach ($categoryarray as $cat)
											{ ?>
											<td> 
												<?php
												if($cati == 0)
												{
												?>
												<?=$this->input->get('start_date')?>
												<?php } 
												$cati++;
												?>
												
											</td>
											<?php
											}
											?>
										</tr>
									<?php } ?>
										
										
										
									</tbody>
								</table>
								<hr>
								<table id="" class="table daily_summary_report" cellspacing="0" width="100%">
									<thead>
                                        <tr>
											<th style="display: none;">#</th>
											<th width="20%">#</th>
											<th>All Category</th>
                                        </tr>
									</thead>
									<tbody>
										<tr>
											<td style="display: none;">1</td>
											<td>Sale Amount</td>
											<td><?=!empty($totalcategoryamount)?number_format($totalcategoryamount,2):'0.00'?></td>
										</tr>
											
										<?php
										if(!empty($this->input->get('start_date')) )
										{
										?>
										<tr>
											<td style="display: none;">2</td>
											<td>Date </td>
											
											<td> 
												<?=$this->input->get('start_date')?> 
											</td>
										</tr>
									<?php } ?>
										
									</tbody>
								</table>
							
								<hr >
								<br /><br /><br /><br /><br /><br /><br />
								<table id="" class="table daily_summary_report" cellspacing="0" width="100%">
									<thead>
                                        <tr>
											<th>Signature</th>
                                        </tr>
									</thead>
									<tbody>
										<tr>
											<td>Coming Here</td>
										</tr>
									</tbody>
								</table>
								
							</div>
						</div>
					</div>
					<br /><br /><br /><br />
<?php
//require_once '../includes/header_notification.php';
$this->load->view('includes/header_notification');
?>	
<?php
$this->load->view('includes/footer');
//require_once 'includes/footer.php';
?>

<script>
	$(document).ready(function() {
		
//		$('.ChagneDateEnd').change(function(){
//			var date = $(this).val();
//			$('.RecieveStartDate').val(date);
//		});
//		
		
		$(".daily_summary_report").DataTable({
			dom: "Bfrtip",
			order:[0,'asc'],
			responsive: true,
			pageLength: 50
		});
	});
</script>	