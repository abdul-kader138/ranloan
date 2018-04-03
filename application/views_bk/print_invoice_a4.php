
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Sale No : <?php echo $order_id; ?></title>
		<script src="<?=base_url()?>assets/js/jquery-1.7.2.min.js"></script>
		
<style type="text/css" media="all">
	body { 
		max-width: 950px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
	#wrapper { 
		min-width: 900px; 
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
		float:right; 
		text-align:right; 
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
   <table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
	    <tr>
		    <td width="100%" align="center">
			    <center>
			    	<img src="<?=base_url()?>assets/img/logo/<?php echo $setting_site_logo; ?>" style="width: 60px;" />
			    </center>
		    </td>
	    </tr>
	    <tr>
		    <td width="100%" align="center">
			    <h2 style="padding-top: 0px; font-size: 24px;"><strong><?=!empty($getmainOrder->outlet_name)?$getmainOrder->outlet_name:''?></strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
				<span class="left" style="text-align: left;">Address : <?=!empty($getmainOrder->outlet_address)?$getmainOrder->outlet_address:''?></span>	
				<span class="left" style="text-align: left;">Tel : <?=!empty($getmainOrder->outlet_contact)?$getmainOrder->outlet_contact:''?></span> 
				<span class="left" style="text-align: left;">Sale Id : <?=!empty($getmainOrder->id)?$getmainOrder->id:''?></span>
				<span class="left" style="text-align: left;">Date : <?=date("$setting_dateformat H:i A", strtotime($getmainOrder->created_at));?></span>
				<span class="left" style="text-align: left;">Customer Name&nbsp; : <?=!empty($getmainOrder->fullname)?$getmainOrder->fullname:''?></span> 
				<span class="left" style="text-align: left;">Customer Phone : <?=!empty($getmainOrder->mobile)?$getmainOrder->mobile:''?></span>
			</td>
		</tr>   
    </table>
	 
	      
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
		<thead> 
			<tr> 
				<th width="10%"><em>#</em></th> 
				<th width="10%" align="left">Product</th>
				<th width="10%">Pump Name</th>
				<th width="10%">Start Meter</th>
				<th width="10%">End Meter</th>
				<th width="10%">Qty</th>
				<th width="10%">Per Item</th>
				<th width="10%">Tax%</th>
				<th width="10%">Discount%</th>
				<th width="10%" align="right">Total</th> 
			</tr> 
		</thead> 
		<tbody> 
			<?php
			$i=1;
			$total_item_amt = 0;
            $total_item_qty = 0;
			foreach ($getItemOrder as $item)
			{ 
				$total_item_amt = $total_item_amt + $item->grandtotal;
				$total_item_qty = $total_item_qty + $item->qty;
				?>
			<tr>
				<td><?=$i?></td>
				<td style="text-align: left;"><?=$item->product_name?> [<?=$item->product_code?>]</td>
				<td><?= $item->pump_name ?></td>
				<td><?=!empty($item->start_meter)?number_format($item->start_meter,2):'' ?></td>
				<td><?=!empty($item->end_meter)?number_format($item->end_meter,2):'' ?></td>
				<td><?=!empty($item->qty)?$item->qty:0?></td>
				<td><?=!empty($item->price)?number_format($item->price,2):0?></td>
				<td><?=!empty($item->tax)?$item->tax:0?></td>
				<td><?=!empty($item->discount)?$item->discount:0?></td>
				<td style="text-align: right;"><?=!empty($item->grandtotal)?number_format($item->grandtotal,2):0?></td>
			</tr>	
		<?php	
		$i++;
			}
			?>
		</tbody> 
	</table> 
	
    
    <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000; border-collapse: collapse;">
    	<tbody>
			<tr>
				<td style="text-align:left; padding-top: 5px;">Total Items</td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;"><?php echo !empty($total_item_qty)?$total_item_qty:0.00; ?></td>
				<td style="text-align:left; padding-left:1.5%;">Total</td>
				<td style="text-align:right;font-weight:bold;"><?php echo !empty($total_item_amt)?number_format($total_item_amt, 2):0.00; ?></td>
			</tr>
			
			<tr>
				<td colspan="4" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Payment Detail</td>
			</tr>
		</tbody>
    </table>
	 <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000; border-collapse: collapse;">
			<tr>    
				<td  style="padding-top: 5px;text-align:left; font-weight:bold; ">Paid By: </td>
				<td  style="padding-top: 5px;text-align:right; font-weight:bold;">Status</td>
				<td  style="padding-top: 5px;text-align:right; font-weight:bold;">Amount</td>
    		</tr>	
			<?php
			$paid_am = 0;
			$unpaid_am = 0;
			foreach ($getPaymentOrder as $pay)
			{ ?>
			<tr>    
				<td style="text-align:left; "><?=$pay->payment_method_name?>
				<?php
				if($pay->payment_method == 5)
				{
					echo "(Cheque No. : $pay->cheque_number)";
				}
				?>
				</td>
				<td style="padding-top:5px; text-align:right; "><?php 
				if($pay->paid_amt > 0)
				{
					$paid_am = $paid_am + $pay->paid_amt;
					echo "Paid";
				}
				else
				{
					$unpaid_am = $unpaid_am + $pay->unpaid_amt;
					echo "UnPaid";
				}
				?></td>
				<td  style="padding-top:5px; text-align:right; "><?php echo !empty($pay->grandtotal)?number_format($pay->grandtotal, 2):0.00; ?></td>
			</tr>	
		<?php	}
			?>
				<tr>
					<td colspan="100%" style="border-top: 1px solid;"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:left; padding-top: 5px;"><b>Paid Amount</b></td>
					<td style="text-align:right;font-weight:bold;"><?php echo !empty($paid_am)? number_format($paid_am, 2):0.00; ?></td>
				</tr>
				<?php
				if($unpaid_am != 0)
				{
				?>
				<tr>
					<td colspan="2" style="text-align:left; padding-top: 5px;"><b>Unpaid Amount</b></td>
					<td style="text-align:right;font-weight:bold;"><?php echo !empty($unpaid_am)?number_format($unpaid_am, 2):0.00; ?></td>
				</tr>
				<?php }
				?>
				<tr>
					<td colspan="100%" style="border-top: 1px solid;"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:left; padding-top: 5px;"><b>Total Amount</b></td>
					<td style="text-align:right;font-weight:bold;"><?php echo !empty($total_item_amt)?number_format($total_item_amt, 2):0.00; ?></td>
				</tr>
				
	</table>
    
    <div style="border-top:1px solid #000; padding-top:10px;">
    	<?php
            echo $getmainOrder->outlet_receipt_footer;
			$jsondata  = json_decode($siteSetting->new_settings);
			echo !empty($jsondata->invoice_footer)?$jsondata->invoice_footer:'';
        ?>    
    </div>
   
    <div id="bkpos_wrp">
    	<a href="<?=base_url()?>pos" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;">Back to POS</a>
    </div>
    
    <div id="bkpos_wrp">
	    <a href="<?=base_url()?>pos/view_invoice?id=<?php echo $order_id; ?>" style="text-decoration: none;">
    		<button type="button" style="width:101%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 0px; font-weight:bold;">Print Small Receipt</button>
	    </a>
    </div>
    
	<div id="bkpos_wrp" style="margin-top: 8px;">
    	<span class="left"><a href="#" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold;" id="email">Email</a></span>
    </div>
    
    <div id="bkpos_wrp">
    	<span class="left">
    		<a href="" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold; margin-top: 6px;" onClick="window.print();return false;">
	    		Print A4
	    	</a>
	    </span>
    </div>
    
    <input type="hidden" id="id" value="<?php echo $order_id; ?>" />
    
</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('#email').click( function(){
			var email 	= prompt("Please enter email address","test@mail.com");	
			var id 		= document.getElementById("id").value;
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>pos/send_invoice",
				data: { email: email, id: id}
			}).done(function( msg ) {
			      alert( "Successfully Sent Receipt to "+email);
			});
			
		});
	});

	$(window).load(function() { window.print(); });
</script>




</body>
</html>
