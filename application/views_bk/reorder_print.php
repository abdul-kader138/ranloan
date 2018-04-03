<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>S.R No : <?=$result->id?></title>
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
			    	<img src="<?=base_url()?>assets/img/logo/<?php echo $setting_site_logo; ?>" style="width: 60px;" />
			    </center>
		    </td>
	    </tr>
	    <tr>
		    <td width="100%" align="center">
			    <h2 style="padding-top: 0px; font-size: 24px;"><strong><?=!empty($result->outletname)?$result->outletname:''?></strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
				<span class="left" style="text-align: left;">Alert Date : <?=!empty($result->created_datetime)?$result->created_datetime:''?></span>	
				<span class="left" style="text-align: left;">Product Code : <?=!empty($result->code)?$result->code:''?></span>
				<span class="left" style="text-align: left;">Product Name : <?=!empty($result->name)?$result->name:''?></span>
				<span class="left" style="text-align: left;">Category : <?=!empty($result->category)?$result->category:''?>
					<span class="left" style="text-align: left;">Sub Category : <?=!empty($result->sub_category)?$result->sub_category:''?>
				<span class="left" style="text-align: left;">QTY : <?=!empty($result->qty)?number_format($result->qty,2):'0.00'?></span>
				<span class="left" style="text-align: left;">Product Price  : <?=!empty($result->purchase_price)?number_format($result->purchase_price,2):'0.00'?></span>
				<span class="left" style="text-align: left;">Amount : <?=number_format($result->purchase_price*$result->qty,2)?></span>
			</td>
		</tr>   
    </table>
    
    
</div>

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(window).load(function() { window.print(); });
</script>




</body>
</html>
