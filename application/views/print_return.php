<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Return Sale No : <?php echo $return_id; ?></title>
		<script src="<?=base_url()?>assets/js/jquery-1.7.2.min.js"></script>
		
<style type="text/css" media="all">
	body { 
		max-width: 300px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
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

	@media print {
		body { text-transform: uppercase; }
		#buttons { display: none; }
		#wrapper { width: 100%; margin: 0; font-size:9px; }
		#wrapper img { max-width:300px; width: 80%; }
		#bkpos_wrp{
			display: none;
		}
	}
</style>
</head>

<body>
<div id="wrapper">
    <h2 style="padding-top: 0px; padding-bottom: 20px; font-size: 22px;"><strong><?=$getReturnSalesPrint->outlets_name;?></strong></h2>
	<span class="left">Address : <?=$getReturnSalesPrint->outlets_address;?></span>	
	<span class="left">Tel : <?=$getReturnSalesPrint->outlets_tel;?></span> 
	<span class="left">Date : <?=$getReturnSalesPrint->created_at;?></span>
	<span class="left">Customer : <?=$getReturnSalesPrint->customername;?></span> 
	    
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
		<thead> 
			<tr> 
				<th width="10%"><em>#</em></th> 
				<th width="30%" align="left">Code</th>
				<th width="25%" align="left">Name</th>
				<th width="10%">Store</th>
				<th width="25%" align="right">Qty</th>
				<th width="25%" align="right">Price</th>
				<th width="25%" align="right">Sub Total</th>
			</tr> 
		</thead> 
		<tbody> 
			<?php
			$total_item_qty = 0;
			$ret_subTotal	= 0;
			$ret_grandTotal	= 0;
			$i = 1;
			foreach ($getReturnSalesItemPrint as $value)
			{
				$total_item_qty = $total_item_qty + $value->qty;
				$ret_subTotal	= $ret_subTotal + $value->subtotal;
				$ret_grandTotal	= $ret_grandTotal + $value->subtotal;
				?>
				<tr>
					<td><?=$i?></td>
					<td><?=$value->product_code?></td>
					<td><?=$value->product_name?></td>
					<td><?php
					if($value->type == 1)
					{
						echo $this->Inventory_model->getConcateFuelTanK($value->ow_id);
					}
					else
					{
						echo $this->Inventory_model->getConcateStore($value->ow_id);
					}
					?></td>
					<td><?=number_format($value->qty,2)?></td>
					<td><?=number_format($value->price,2)?></td>
					<td><?=number_format($value->subtotal,2)?></td>
				</tr>
		<?php
			$i++;
			}
			?>
    	</tbody> 
	</table> 
	
    
    <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000;">
    	<tbody>
	    	<tr>
				<td style="text-align:left; padding-top: 5px;">Total Items</td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;"><?php echo $total_item_qty; ?></td>
				<td style="text-align:left; padding-left:1.5%;">Sub Total</td>
				<td style="text-align:right;font-weight:bold;"><?php echo number_format($ret_subTotal, 2); ?></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Grand Total</td>
				<td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;"><?php echo $ret_grandTotal; ?></td>
    		</tr>
    		
	    	<tr>
				<td style="text-align:left; padding-top: 5px; font-weight: bold; border-top: 1px solid #000;">Refund By : </td>
				<td style="text-align:right; padding-top: 5px; border-top: 1px solid #000;font-weight:bold;" colspan="3">
					<?=$getReturnSalesPrint->payment_method_name;?>
				</td>
			</tr>
			<tr>
				<td style="text-align:left; padding-top: 5px; font-weight: bold; border-top: 1px solid #000;" colspan="2">Refund Method : </td>
				<td style="text-align:right; padding-top: 5px; padding-right:1.5%; border-top: 1px solid #000;font-weight:bold;" colspan="2">
					<?php
                        if ($getReturnSalesPrint->refund_method == '0') {
                            echo 'Full Refund';
                        }
                        if ($getReturnSalesPrint->refund_method == '1') {
                            echo 'Partial Refund';
                        }
                    ?>
				</td>
			</tr>
			<tr>
				<td style="text-align:left; padding-top: 5px; font-weight: bold; border-top: 1px solid #000;" colspan="2">Condition : </td>
				<td style="text-align:right; padding-top: 5px; padding-right:1.5%; border-top: 1px solid #000;font-weight:bold;" colspan="2">
					<?php
                        if ($getReturnSalesPrint->condition == '0') {
                            echo 'Good';
                        }
                        if ($getReturnSalesPrint->condition == '1') {
                            echo 'Not Good';
                        }
                    ?>
				</td>
			</tr>
			<?php
                if (!empty($getReturnSalesPrint->remark)) {
                    ?>
			<tr>
				<td colspan="2" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Remark</td>
				<td colspan="2" style="border-top:1px solid #000; padding-top:5px; text-align:right; font-weight:bold;"><?php echo nl2br($getReturnSalesPrint->remark); ?></td>
    		</tr>
			<?php

                }
            ?>
    </tbody>
    </table>
    
    <div style="border-top:1px solid #000; padding-top:10px;">
    	<?php
            echo $getReturnSalesPrint->receipt_footer;
        ?>    
    </div>
   
    <div id="bkpos_wrp">
    	<a href="<?=base_url()?>returnorder/return_report" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;">Back</a>
    </div>
    
    
</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(window).load(function() { window.print(); });
</script>




</body>
</html>
