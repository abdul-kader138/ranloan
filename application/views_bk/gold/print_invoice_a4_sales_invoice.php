<?php
    $settingResult = $this->db->get_where('site_setting');
    $settingData = $settingResult->row();
    $setting_dateformat = $settingData->datetime_format;
    $setting_site_logo = $settingData->site_logo;

   
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Sale No : <?php echo $sales_id; ?></title>
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
			    	<img src="<?=base_url()?>assets/img/logo/<?php echo $setting_site_logo; ?>" style="width: 80px;" />
			    </center>
		    </td>
	    </tr>
	    <tr>
		    <td width="100%" align="center">
			    <h2 style="padding-top: 0px; font-size: 24px;"><strong><?=!empty($getmainOrder->sales_outlet_name)?$getmainOrder->sales_outlet_name:''?></strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
				<span class="left" style="text-align: left;">Address : <?=!empty($getmainOrder->sales_outlet_address)?$getmainOrder->sales_outlet_address:''?></span>	
				<span class="left" style="text-align: left;">Tel : <?=!empty($getmainOrder->sales_outlet_contact)?$getmainOrder->sales_outlet_contact:''?></span> 
				<span class="left" style="text-align: left;">Sale Id :<?=!empty($getmainOrder->sales_id)?$getmainOrder->sales_id:''?></span>
				<span class="left" style="text-align: left;">Date : <?=$getmainOrder->sales_ordered_datetime?></span>
				<span class="left" style="text-align: left;">Customer Name&nbsp; : <?=!empty($getmainOrder->sales_customer_name)?$getmainOrder->sales_customer_name:''?></span> 
				<span class="left" style="text-align: left;">Customer Phone :<?=!empty($getmainOrder->sales_customer_mobile)?$getmainOrder->sales_customer_mobile:''?></span>
				<span class="left" style="text-align: left;">Sales Person Name : <?=!empty($sales_person_name[0]->fullname)?$sales_person_name[0]->fullname:''?></span>
			</td>
		</tr>   
    </table>
	 
	    
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
		<thead> 
			<tr> 
				<th><em>#</em></th> 
				<th align="left">Product</th>
				<th>Qty</th>
				<th>Per Item</th>
				<th>Discount</th>
				<th>Tax%</th>
				<th>weight</th>
				<th align="right">Total</th> 
			</tr> 
		</thead> 
		<tbody> 
		<?php
           $i=1;
			
            $total_item_qty = 0;
			$grand_total=0;
			foreach ($sales_invoice_item as $item)
			{ 
				
				$total_item_qty = $total_item_qty + $item->qty;
				$subtotal = $item->grandtotal;
				$grand_total = $grand_total + $subtotal;
			 ?>
				<tr>
	            	<td style="text-align:center; width:30px;" valign="top"><?php echo $i + 1; ?></td>
	                <td style="text-align:left; width:130px; padding-bottom: 10px" valign="top"><?=$item->product_name?> [<?=$item->product_code?>]</td>
	                <td style="text-align:center; width:50px;" valign="top"><?=$item->qty?></td>
	                <td style="text-align:center; width:50px;" valign="top"><?=number_format($item->price,2)?></td>
					<td style="text-align:center; width:50px;" valign="top"><?=!empty($item->discount)?$item->discount:''?></td>
					<td style="text-align:center; width:50px;" valign="top"><?=!empty($item->tax)?$item->tax:''?></td>
					<td style="text-align:center; width:50px;" valign="top"><?=!empty($item->weight)?number_format($item->weight,2):''?></td>
					<td style="text-align:right; width:70px;" valign="top"><?=!empty($subtotal)?number_format($subtotal,2):''?></td>
				</tr>	
		<?php
				$item_id=$item->id;
				$query= $this->db->query("SELECT * FROM sales_invoice_item_services join sub_category on sales_invoice_item_services.services_name=sub_category.id WHERE sales_invoice_item_id = '$item_id' && pre_print_invoice!='0'");
				$subval=$query->result();
				
				if($subval!=''){
				foreach ($subval as $val)
				{
					$grand_total = $grand_total+$val->price;
					$service=$val->price;
				?>
				<tr>
				<td></td>
				<td><?=!empty($val->sub_category)?$val->sub_category:''?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td style="text-align: right;"><?=!empty($val->price)?number_format($val->price,2):''?></td>
				
			</tr>	
			
		<?php	}
			}
		$i++;
			}
			?>
			 
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
			foreach ($getPaymentsalesInvoice as $pay)
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
					<td style="text-align:right;font-weight:bold;"><?php echo !empty($paid_am)?number_format($paid_am, 2):0.00; ?></td>
				</tr>
				<?php
				$unpaid_am=$getmainOrder->sales_unpaid_amt;
				
				if($unpaid_am != 0)
				{
				?>
				<tr>
					<td colspan="2" style="text-align:left; padding-top: 5px;"><b>Unpaid Amount</b></td>
					<td style="text-align:right;font-weight:bold;"><?php echo !empty($unpaid_am)?number_format($unpaid_am, 2):0.00; ?></td>
				</tr>
				<?php }
				$duepay = $unpaid_am - $paid_am;
				if($unpaid_am <= $paid_am)
				{
					$duepay = $paid_am - $unpaid_am;
				}
				
				?>
				
				<tr>
					<td colspan="2" style="text-align:left; padding-top: 5px;"><b>Due Amount</b></td>
					<td style="text-align:right;font-weight:bold;"><?php echo !empty($duepay)?number_format($duepay, 2):0.00; ?></td>
				</tr>
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
  echo $getmainOrder->sales_outlet_receipt_footer;           
        ?>    
    </div>
<!--
        <div id="buttons" style="padding-top:10px; text-transform:uppercase;">
    <span class="left"><a href="#" style="width:90%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 1px; font-weight:bold;" id="email">Email</a></span>
    <span class="right"><button type="button" onClick="window.print();return false;" style="width:100%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 1px; font-weight:bold;">Print</button></span>
    <div style="clear:both;"></div>
-->
   
    <div id="bkpos_wrp">
    	<a href="<?=base_url()?>sales/sales_invoice" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;">Back to Sales Invoice</a>
    </div>
    
    <div id="bkpos_wrp">
	    <a href="<?=base_url()?>gold/view_sales_invoice?id=<?php echo $sales_id; ?>" style="text-decoration: none;">
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
    
    <input type="hidden" id="id" value="<?php echo $sales_id; ?>" />
    
</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(document).ready(function(){ 
		$('#email').click( function(){
			var email 	= prompt("Please enter email address","test@mail.com");	
			var id 		= document.getElementById("id").value;
			
			$.ajax({
				type: "POST",
				url: "<?=base_url()?>gold/send_invoice",
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
