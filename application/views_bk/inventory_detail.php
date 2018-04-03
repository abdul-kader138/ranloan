<?php
require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header" style="font-size: 26px;">Inventory for Product Code : <?php echo !empty($product_code) ? $product_code : ''; ?></h1>
			<h1 class="page-header" style="font-size: 26px;">Inventory for Product : <?php echo !empty($product_name) ? $product_name : ''; ?></h1>
			<h1 class="page-header" style="font-size: 26px;">Inventory for Category : <?php echo !empty($category_name) ? $category_name : ''; ?></h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h1 class="page-header" style="margin-top: 0px; padding-bottom: 4px; font-size: 30px; margin: 0px 0 11px; color: #0079c0;">
						Inventory by Outlet
					</h1>
					<div class="row" style="padding-top: 10px; padding-bottom: 10px;">
						<div class="col-md-3"><b style="color: #0079c0; letter-spacing: 0.2px; font-size: 17px;">Outlet Name</b></div>
						<div class="col-md-9"><b style="color: #0079c0; letter-spacing: 0.2px; font-size: 17px;">Current Inventory Quantity</b></div>
					</div>
					<?php
					$outletData = $this->Constant_model->getDataOneColumnSortColumn('outlets', 'status', '1', 'name', 'ASC');
					for ($t = 0; $t < count($outletData); ++$t) {
						$outlet_id = $outletData[$t]->id;
						$outlet_name = $outletData[$t]->name;
						?>
						<div class="row" style="padding-top: 10px; padding-bottom: 10px;">
							<div class="col-md-3" style="font-size: 16px;">
								<?php echo $outlet_name; ?>
							</div>
							<div class="col-md-9" style="font-size: 16px;">
								<?php
								$invQty = 0;
								$invQtyData = $this->Constant_model->getDataTwoColumn('inventory', 'product_code', $product_code, 'outlet_id', $outlet_id);
								if (count($invQtyData) > 0) {
									foreach ($invQtyData as $utletqty) {
										$invQty = $invQty + $utletqty->qty;
									}
								}
								echo !empty($invQty)?number_format($invQty, 2):'0.00';
								?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
			
		<a href="<?= base_url() ?>inventory/view" style="text-decoration: none;">
			<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
				<i class="icono-caretLeft" style="color: #FFF;"></i>Back
			</div>
		</a>
			
		</div>
	</div>
	<br /><br /><br />
</div>
<?php
require_once 'includes/footer.php';
require_once 'includes/header_notification.php';
?>
<script>
    $('document').ready(function () {
        $('.UpdateInventory').click(function () {
            var inventory_id = $(this).attr('id');
            var old_qty = $(this).attr('data-val');
            var type = $(this).attr('data-type');
            var tank_ware = $(this).attr('data');
            var update_qty = $("#UpdateQty" + inventory_id).val();
            if (update_qty == "" || update_qty == 0)
            {
                alert("Please Enter perfect Qty!!");
            } else
            {
                var finalupdate_qty = parseFloat(old_qty) + parseFloat(update_qty);
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url() ?>inventory/updateInventoryAjax",
                    data: {finalupdate_qty: finalupdate_qty, inventory_id: inventory_id,type:type,tank_ware:tank_ware,update_qty:update_qty},
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success)
                        {
                            alert('Inventory Successfully Updated!!');
                            location.reload();
                        } else
                        {
                            alert('Due to some error please try again!!');
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>