<?php
require_once 'includes/header.php';
?>
<?php
$poDtaData = $this->Constant_model->getDataOneColumn('purchase_order', 'id', $id);
//$warehouses = $this->Gold_module->select_all_join('outlet_warehouse','stores','outlets');
if (count($poDtaData) == 0) {
	redirect(base_url());
}

$po_numb = $poDtaData[0]->po_number;
$po_supplier_id = $poDtaData[0]->supplier_id;
$po_outlet_id = $poDtaData[0]->outlet_id;
$po_date = $poDtaData[0]->po_date;
$po_attachment = $poDtaData[0]->attachment_file;
$po_note = $poDtaData[0]->note;
$po_status = $poDtaData[0]->status;

$po_outlet_name = $poDtaData[0]->outlet_name;
$po_supplier_name = $poDtaData[0]->supplier_name;

$discount = $poDtaData[0]->discount_amount;
$subTotal = $poDtaData[0]->subTotal;
$taxTotal = $poDtaData[0]->tax;
$grandTotal = $poDtaData[0]->grandTotal;
?>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/typeahead.min.js"></script>



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
</style>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Partial Purchase Order </h1>
        </div>
    </div><!--/.row-->

   <!-- <form action="<? /* =base_url() */ ?>purchase_order/ReceiveItemsPO" method="post" enctype="multipart/form-data">
	-->     <div class="row">
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
                            <div class="col-md-4"></div>
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
					<div class="row" style="margin-top: 7px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<thead>
                                        <tr>
                                            <th style="background-color: #686868; color: #FFF;">Product Code</th>
                                            <th style="background-color: #686868; color: #FFF;">Products</th>
                                            <th style="background-color: #686868; color: #FFF;">Price</th>
                                            <th style="background-color: #686868; color: #FFF;">In Stock</th>
                                            <th style="background-color: #686868; color: #FFF;">Order Qty.</th>
                                            <th style="background-color: #686868; color: #FFF;">Discount %</th>
                                            <th style="background-color: #686868; color: #FFF;">Tax</th>
                                            <th style="background-color: #686868; color: #FFF;">Sub total</th>
                                        </tr>
									</thead>
									<tbody>
										<?php
										$grandTotal = 0;
										foreach ($getPurchaseItem as $inventory)
										{
											$grandTotal = $grandTotal + $inventory->subTotal;
										?>
										<tr>
											<td><?=$inventory->product_code?></td>
											<td><?=$inventory->name?></td>
											<td><?=$inventory->purchase_price?></td>
											<td><?=$inventory->instock?></td>
											<td><?=$inventory->ordered_qty?></td>
											<td><?=$inventory->discount_percentage?></td>
											<td><?=$inventory->tax?></td>
											<td><?=$inventory->subTotal?></td>
											
										</tr>
										<?php 
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div id="grand_total" style="float:right;color: red; font-style: bold;font-size: 26px;"> Total :<?=number_format($grandTotal,2)?></div>
					
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
                                    <th width="60%">Product</th>
                                    <th width="20%">Ordered Quantity</th>
                                    <th width="20%">Distribute To Warehouse</th>
                                </thead>
                                <tbody>
								<?php 
									foreach ($getPurchaseItem as $value)
									{ ?>
										<tr>
											<td><?=$value->name?></td>
											<td><?=$value->ordered_qty?></td>
											<td>
												<?php
												if($value->warehouse_tank_status_partial == 0)
												{
												?>
												<button data-purchase="<?=$value->id?>" data-qty="<?=$value->ordered_qty?>" data-val="<?=$value->name?>" id="<?=$value->inven_id?>" type="button" class="btn btn-small btn-info WareHouseTank" style="text-align: center; display: flex; align-items: center; justify-content: center; margin-right: 40px; margin-left: 40px;"><i class="fa fa-arrow-circle-right" style="font-size: 20px;" aria-hidden="true"></i></button>
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
					   <div class="col-md-6 col-lg-6 col-sm-12 warehouse_table" style="display: none;">
                            <div class="row product_heading" style="text-align: center; font-size: 13px; color: #388E3C; background-color: #C8E6C9; padding-top: 7px; padding-bottom: 7px; margin-left: 0px; margin-right: 0px;"></div>
							<input type="hidden" value="" id="ordered_qty">
							<input type="hidden" value="" id="purchaseid">
							<span id="dataWarehouseTank"></span>
                        </div>
				</div>
				
				<a href="<?= base_url() ?>purchase_order/po_partial?p_status=8" style="text-decoration: none;">
					<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;">
						<i class="icono-caretLeft" style="color: #FFF;"></i>Back
					</div>
				</a>

			</div>
		</div>
		<br /><br /><br /><br /><br />

	</div>
    
    <script>
        $(document).ready(function () {

            $("#btncl").click(function () {
                if ($("#dist").css('display') == 'none') {
                    $("#dist").css('display', 'block');
                } else {
                    $("#dist").css('display', 'none');
                    $(".warehouse_table").css('display', 'none');
                    $("#mrk").css('display', 'none');
                }
            });
			
			$('.WareHouseTank').click(function(){
				var inventory_id = $(this).attr('id');
				var product_name = $(this).attr('data-val');
				var ordered_qty = $(this).attr('data-qty');
				var purchaseid = $(this).attr('data-purchase');
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>Purchase_order/WareHouseTank",
					data: {inventory_id: inventory_id},
					dataType: 'JSON',
					success:function(data){
						$('.warehouse_table').show();
						$('#ordered_qty').val(ordered_qty);
						$('#purchaseid').val(purchaseid);
						$('.product_heading').html(product_name);
						$('#dataWarehouseTank').html(data.html);
					}
				 });
			});

			
			$('#dataWarehouseTank').delegate('#add_to_warehouse','click',function(){
				var ordered_qty = $('#ordered_qty').val();
				var sum = 0;
				$(".warehouse_quantity").each(function() {
                var value = $(this).val();
				    if(!isNaN(value) && value.length != 0) {
					    sum += parseInt(value);
					}
				});
				if(parseInt(sum) === parseInt(ordered_qty)){
					
					var formData = new FormData();
					var warehouse = $('#formWarehouse').serializeArray();
					$.each(warehouse, function (key, input) {
							formData.append(input.name, input.value);
					});
					
					var purchaseid = $('#purchaseid').val();
					formData.append('purchaseid', purchaseid);
					
				$.ajax({
					type:'POST',
					url:"<?=base_url();?>purchase_order/add_to_different_warehouse_partial",
					data: formData,
					cache: false,
					contentType: false,
					processData: false,
					dataType: 'JSON',
					success:function(data){
						if(data.sucess)
						{
							alert('Stock Suucessfully Distribute to the Warehouse');
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
			else
			{
                alert('Quantity does not match');
            }
				
		});
				
		
		$('#dataWarehouseTank').delegate('#add_to_warehouse_one','click',function(){
        	var ordered_qty = $('#ordered_qty').val();
			var sum = 0;
            $(".warehouse_quantity").each(function() {
                var value = $(this).val();
                if(!isNaN(value) && value.length != 0) {
                    sum += parseInt(value);
                }
            });

            if(parseInt(sum) === parseInt(ordered_qty)){
				var formData = new FormData();
				var warehouse = $('#formTank').serializeArray();
				$.each(warehouse, function (key, input) {
					formData.append(input.name, input.value);
				});
				
				var purchaseid = $('#purchaseid').val();
				formData.append('purchaseid', purchaseid);
					
					$.ajax({
						type:'POST',
						url:"<?=base_url();?>purchase_order/add_to_different_tank_partial",
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						dataType: 'JSON',
						success:function(data){
							if(data.sucess)
							{
								alert('Stock Suucessfully Distribute to the Tank');
								location.reload();
							}
							else
							{
								alert('Due to some error please try again!!');
								location.reload();
							}
						}
					});
                
				}else{
					alert('Quantity does not match');
				}

			});

        });

	</script>

	<?php
	require_once 'includes/footer.php';
	?>
