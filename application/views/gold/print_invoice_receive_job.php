<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Sale No : <?php echo $order_id; ?></title>
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
				<span class="left" style="text-align: left;">Receive Job Order No : <?=!empty($getwork_job_order_receive->id)?$getwork_job_order_receive->id:''?></span>	
				<span class="left" style="text-align: left;">GoldSmith : <?=!empty($getwork_job_order_receive->goldgrade_name)?$getwork_job_order_receive->goldgrade_name:''?></span> 
				<span class="left" style="text-align: left;">Receive Job Order No. : <?=!empty($getwork_job_order_receive->receive_job_sel_no)?$getwork_job_order_receive->receive_job_sel_no:''?></span>
				<span class="left" style="text-align: left;">Date : <?=date("Y-m-d", strtotime($getwork_job_order_receive->create_date));?></span>
				<span class="left" style="text-align: left;">Customer Order No.&nbsp; : <?=!empty($getwork_job_order_receive->customer_order_no)?$getwork_job_order_receive->customer_order_no:''?></span> 
				<span class="left" style="text-align: left;">Order Delivery Date : <?=date("Y-m-d", strtotime($getwork_job_order_receive->order_delivery_date));?></span>
			</td>
		</tr>   
    </table>
    
	
	    
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0"> 
		<thead> 
			<tr> 
				<th width="20%">Finish Product Item no</th> 
				<th width="20%">Gold Grade(kt)</th>
				<th width="20%">Weight(g) Product</th>
				<th width="20%">Weight Item(g</th>
			
			</tr> 
		</thead> 
		<tbody> 
			
			<tr>
				<td><?=$getwork_job_order_receive->productname?></td>
				<td><?=$getwork_job_order_receive->goldgrade_name?> </td>
				<td><?=$getwork_job_order_receive->weight_bluk_store?></td>
				<td><?=$getwork_job_order_receive->weight_item?></td>
								
			</tr>	
			
	
		</tbody> 
	</table>
			<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0" > 
		<thead> 
			
			<tr> 
			
				<th width="20%">Gold Weight(g)</th>
				<th width="20%">Alloy Weight(g)</th>
				<th width="20%">Qty</th>
				<th width="20%">Receive Qty</th>
			</tr> 
		</thead> 
		<tbody> 
			
			<tr>
				<td><?=$getwork_job_order_receive->gold_weight?></td>
				<td><?=$getwork_job_order_receive->alloy_weight?></td>
				<td><?=$getwork_job_order_receive->qty?></td>
				<td><?=$getwork_job_order_receive->receive_qty?></td>
				
			</tr>	
			
	
		</tbody> 
		
	</table> 
	
	<div style="clear:both;"></div>
    
	<table class="table" cellspacing="0"  border="0" > 
	<thead> 
			<tr> 
				<th width="20%">Prdouct Category</th> 
				<th width="20%">Receive Weight for all item</th>
				<th width="20%">Wastage(g)</th>
				<th width="20%">Stone Weight</th>
				<th width="20%">Labour Cost(Total)</th>
			</tr> 
		</thead> 
		<tbody> 
			
			<tr>
				<td><?=$getwork_job_order_receive->category_name?></td>
				<td><?=$getwork_job_order_receive->receive_weight_item?> </td>
				<td><?=$getwork_job_order_receive->wastage?></td>
				<td><?=$getwork_job_order_receive->stone_weight?></td>
				<td><?=$getwork_job_order_receive->labour_cost?></td>
				
			</tr>	
			
	
		</tbody> 
	
    	</table> 
   

    
    <div style="border-top:1px solid #000; padding-top:10px;">
    	<?php
//            echo $getmainOrder->gold_outlet_receipt_footer;
//        ?>    
    </div>

   
    <div id="bkpos_wrp">
    	<a href="<?=base_url()?>pos" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;">Back to POS</a>
    </div>
    
    <div id="bkpos_wrp">
    	<button type="button" onClick="window.print();return false;" style="width:101%; cursor:pointer; font-size:12px; background-color:#FFA93C; color:#000; text-align: center; border:1px solid #FFA93C; padding: 10px 0px; font-weight:bold;">Print Small Receipt</button>
    </div>
    
	<div id="bkpos_wrp" style="margin-top: 8px;">
    	<span class="left"><a href="#" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold;" id="email">Email</a></span>
    </div>
    
    <div id="bkpos_wrp">
    	<span class="left">
    		<a href="<?=base_url()?>Productions/view_invoice_receiveJob_a4?id=<?php echo $order_id; ?>" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#4FA950; border:2px solid #4FA950; padding: 10px 0px; font-weight:bold; margin-top: 6px;">
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
