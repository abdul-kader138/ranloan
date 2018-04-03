<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Ref No : <?=$getTransform->id?></title>
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
			    <h2 style="padding-top: 0px; font-size: 24px;"><strong><?=!empty($getTransform->outletname)?$getTransform->outletname:''?></strong></h2>
		    </td>
	    </tr>
		<tr>
			<td width="100%">
				<span class="left" style="text-align: left;">Date : <?=date('d-m-Y',strtotime($getTransform->transfer_date))?></span>	
				<span class="left" style="text-align: left;">From Account : 
				<?php
				if($getTransform->payment_method == 0)
				{
					echo $this->bdt_model->getPaymentname($getTransform->bank_from);
				}
				else
				{
					echo $this->bdt_model->getBankName($getTransform->bank_from) .' (Account)';
				}
				?>
				</span>
				<span class="left" style="text-align: left;">To Account : 
				<?php
				if($getTransform->payment_method == 1)
				{
					echo $this->bdt_model->getPaymentname($getTransform->bank_to);													
				}
				else
				{
					echo $this->bdt_model->getBankName($getTransform->bank_to).' (Account)';;
				}
				?>
				</span>
				<span class="left" style="text-align: left;">Deposit Amount : <?=number_format($getTransform->amount,2)?></span> 
				<span class="left" style="text-align: left;">User : <?=$getTransform->fullname?></span> 
				<span class="left" style="text-align: left;">Reason: <?=$getTransform->reference?></span> 
			</td>
		</tr>   
    </table>
    
    
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
