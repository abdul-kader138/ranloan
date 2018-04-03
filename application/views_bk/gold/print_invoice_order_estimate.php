<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Customer Order No : <?=!empty($getmainOrder->gold_id)?$getmainOrder->gold_id:''?></title>
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
			    	<img src="<?=base_url()?>assets/img/logo/<?php echo $setting_logo->site_logo; ?>" style="width: 60px;" />
			    </center>
		    </td>
	    </tr>
	    <tr>
		    <td width="100%" align="center">
			    <h2 style="padding-top: 0px; font-size: 24px;"><strong><?=!empty($getmainOrder->gold_outlet_name)?$getmainOrder->gold_outlet_name:''?></strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
				<span class="left" style="text-align: left;">Address : <?=!empty($getmainOrder->gold_outlet_address)?$getmainOrder->gold_outlet_address:''?></span>	
				<span class="left" style="text-align: left;">Tel : <?=!empty($getmainOrder->gold_gold_outlet_contact)?$getmainOrder->gold_gold_outlet_contact:''?></span> 
				<span class="left" style="text-align: left;">Customer Order No : <?=!empty($getmainOrder)?$getmainOrder->gold_id:''?></span>
				<span class="left" style="text-align: left;">
					Date : <?php if(!empty($getmainOrder)) echo $getmainOrder->gold_ordered_datetime; ?>
						
					</span>
				<span class="left" style="text-align: left;">Customer&nbsp;: <?=!empty($getmainOrder->gold_customer_name)?$getmainOrder->gold_customer_name:''?></span> 
				<span class="left" style="text-align: left;">Customer Phone : <?=!empty($getmainOrder->gold_customer_mobile)?$getmainOrder->gold_customer_mobile:''?></span>
				<span class="left" style="text-align: left;">Sales Person Name : <?=!empty($sales_person_name[0]->fullname)?$sales_person_name[0]->fullname:''?></span>
			</td>
		</tr>   
    </table>
    
	
	    
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
		<thead> 
			<tr> 
				<th width="10%"><em>#</em></th> 
				<th width="35%" align="left">Product</th>
				<th width="10%">Qty</th>
				<th width="25%">Per Item</th>
				<th width="25%">Discount</th>
				<th width="25%">Tax</th>
				<th width="25%">weight</th>
				<th width="20%" align="right">Total</th> 
			</tr> 
		</thead> 
		<tbody> 
			<?php
			$i=1;
            $total_item_qty = 0;
			$grand_total=0;
			foreach ($order_items_gold as $item)
			{ 
				$total_item_qty = $total_item_qty + $item->qty;
				$grand_total = $grand_total + $item->subtotal;
				?>
			<tr>
				<td><?=$i?></td>
				<td><?=$item->product_name?> <?=!empty($item->product_code)?'['.$item->product_code.']':''?></td>
				<td><?=$item->qty?></td>
				<td><?=number_format($item->price,2)?></td>
				<td><?=!empty($item->discount)?$item->discount:''?></td>
				<td><?=!empty($item->tax)?$item->tax:''?></td>
				<td><?=!empty($item->weight)?number_format($item->weight,2):'0.00'?></td>
				<td><?=!empty($item->subtotal)?number_format($item->subtotal,2):'0.00'?></td>
			</tr>	
			<?php
				$item_id=$item->id;
				$query= $this->db->query("SELECT * FROM gold_order_services join products on gold_order_services.services_name=products.id WHERE order_items_gold_id = '$item_id' ");
				$subval=$query->result();
				
				if($subval!=''){
				foreach ($subval as $val)
				{
					$grand_total = $grand_total+$val->price;
					$service=$val->price;
					if($val->pre_print_invoice !=0)
					{
				?>
			<tr>
				<td></td>
				<td><?=$val->name?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td><?=number_format($val->price,2)?></td>
				
			</tr>	
			
		<?php	}
				}	
			}
		$i++;
			}
			?>
		</tbody> 
	</table> 
	
	
	
	
    
    <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000; border-collapse: collapse;">
    	<tbody>
			<tr>
				<td style="text-align:left; padding-top: 5px;">Total Items</td>
				<td style="text-align:right; padding-right:1.5%; border-right: 1px solid #000;font-weight:bold;"><?php echo $total_item_qty; ?></td>
				<td style="text-align:left; padding-left:1.5%;">Total</td>
				<td style="text-align:right;font-weight:bold;"><?php echo number_format($grand_total, 2); ?></td>
			</tr>
			
		
			
			<tr>
				<td colspan="4" style="text-align:left; font-weight:bold; border-top:1px solid #000; padding-top:5px;">Payment Detail</td>
			</tr>
		</tbody>
    </table>
	 <table class="totals" cellspacing="0" border="0" style="margin-bottom:5px; border-top: 1px solid #000; border-collapse: collapse;">
				<tr>    
				<td  style="padding-top: 5px;text-align:left; font-weight:bold; ">Paid By: </td>
				<td  style="padding-top: 5px;text-align:left; font-weight:bold;">Status</td>
				<td  style="padding-top: 5px;text-align:right; font-weight:bold;">Amount</td>
    		</tr>	
			<?php
			$paid_am=0;
			$unpaid_am = 0;
			foreach ($getPaymentGoldOrder as $pay)
			{ ?>
			
			<tr>
				<td style="text-align:left; "><?= $pay->payment_method_name ?></td>
				<td style="text-align:left; "><?php 
				if(!empty($pay->paid_amt))
				{
					echo 'Paid';
				}
				else
				{
					echo 'UnPaid';
				}
				?></td>
				<td style="padding-top:5px; text-align:right; ">
					
				<?php 
				if(!empty($pay->paid_amt))
				{
					$paid_am = $paid_am + $pay->paid_amt;
					echo number_format($pay->paid_amt,2);
				}
				else
				{
					$unpaid_am = $unpaid_am + $pay->unpaid_amt;
					echo number_format($pay->unpaid_amt,2);
				}
				?>			
					
				</td>
				
				
			</tr>
			
			

		<?php	}
			?>
				<tr>
					<td colspan="100%" style="border-top: 1px solid;"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:left; padding-top: 5px;"><b>Paid Amount</b></td>
					<td style="text-align:right;font-weight:bold;"><?php echo !empty($paid_am )?number_format($paid_am , 2):0.00; ?></td>
				</tr>
				<?php
				$unpaid_am=$getmainOrder->gold_unpaid_amt;
				
				if($unpaid_am != 0)
				{
				?>
				<tr>
					<td colspan="2" style="text-align:left; padding-top: 5px;"><b>Unpaid Amount</b></td>
					<td style="text-align:right;font-weight:bold;"><?php echo !empty($unpaid_am)?number_format($unpaid_am, 2):0.00; ?></td>
				</tr>
				<?php 
				
				if($grand_total>=$paid_am)
				{
					$duepay = $grand_total - $paid_am;
				}
				else
				{
					$duepay =   $paid_am -$grand_total;
				}
				?>
				
				<tr>
					<td colspan="2" style="text-align:left; padding-top: 5px;"><b>Due Amount</b></td>
					<td style="text-align:right;font-weight:bold;"><?php echo !empty($duepay)?number_format($duepay, 2):0.00; ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="100%" style="border-top: 1px solid;"></td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:left; padding-top: 5px;"><b>Total Amount</b></td>
					<td style="text-align:right;font-weight:bold;"><?php echo number_format($paid_am + $unpaid_am, 2); ?></td>
				</tr>
				
	</table>
    
    <div style="border-top:1px solid #000; padding-top:10px;">
    	<?php
            echo $getmainOrder->gold_outlet_receipt_footer;
        ?>    
    </div>

   
    <div id="bkpos_wrp">
    	<a href="<?=base_url()?>Gold/order_estimate" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;">Back to Customer Order</a>
    </div>
    
    <div id="bkpos_wrp">
    	<button type="button" onClick="window.print();return false;" style="width:101%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 0px; font-weight:bold;">Print Small Receipt</button>
    </div>
    
	<div id="bkpos_wrp" style="margin-top: 8px;">
    	<span class="left"><a href="#" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold;" id="email">Email</a></span>
    </div>
    
    <div id="bkpos_wrp">
    	<span class="left">
    		<a href="<?=base_url()?>Gold/view_invoice_a4?id=<?php echo $order_id; ?>" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold; margin-top: 6px;">
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
