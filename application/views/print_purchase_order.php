<?php
    $settingResult = $this->db->get_where('site_setting');
    $settingData = $settingResult->row();
    $setting_dateformat = $settingData->datetime_format;

    $poDtaData = $this->Constant_model->getDataOneColumn('purchase_order', 'id', $id);
	if(!empty($poDtaData)){
    $po_numb = $poDtaData[0]->po_number;
    $po_supplier_id = $poDtaData[0]->supplier_id;
    $po_outlet_id = $poDtaData[0]->outlet_id;
    $po_date = date("$setting_dateformat", strtotime($poDtaData[0]->po_date));
    $po_attachment = $poDtaData[0]->attachment_file;
    $po_note = $poDtaData[0]->note;
    $po_status = $poDtaData[0]->status;
	
    //$supplierNameData 		= $this->Constant_model->getDataOneColumn('suppliers', 'id', $po_supplier_id);
	  $supplier_id = $poDtaData[0]->supplier_id;
    $supplier_name = $poDtaData[0]->supplier_name;
    $supplier_address = $poDtaData[0]->supplier_address;
    $supplier_email = $poDtaData[0]->supplier_email;
    $supplier_tel = $poDtaData[0]->supplier_tel;
    $supplier_fax = $poDtaData[0]->supplier_fax;
    $purchase_bill_no = $poDtaData[0]->purchase_bill_no;

    //$outletNameData 		= $this->Constant_model->getDataOneColumn('outlets', 'id', $po_outlet_id);
    $outlet_name = $poDtaData[0]->outlet_name;
    $outlet_address = $poDtaData[0]->outlet_address;
    $outlet_contact = $poDtaData[0]->outlet_contact;
	}
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Print Purchase Order</title>
	
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
		min-width: 950px; 
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
    
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 11px;" width="100%" height="auto">
		<tr>
			<td width="100%" height="auto" align="center">
				<h1 style="font-size: 40px; color: #005b8a;">Purchase Order</h1>
			</td>
		</tr>
	</table>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 10px; border-bottom: 1px solid #656563; padding-bottom: 10px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="30%" style="font-size: 15px;" align="left">Supplier Invoice</td>
						<td width="70%" style="font-size: 15px;" align="left">: <?php if(!empty($poDtaData)){echo $supplier_id;} ?></td>
					</tr>
					<tr>
						<td width="30%" style="font-size: 15px;" align="left">Purchase Bill No</td>
						<td width="70%" style="font-size: 15px;" align="left">: <?php if(!empty($poDtaData)){echo $purchase_bill_no;} ?></td>
					</tr>
					<tr>
						<td width="30%" style="font-size: 15px;" align="left">Supplier</td>
						<td width="70%" style="font-size: 15px;" align="left">: <?php if(!empty($poDtaData)){echo $supplier_name;} ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left">Address</td>
						<td width="70%" align="left">: <?php if(!empty($poDtaData)){echo $supplier_address;} ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left">Email</td>
						<td width="70%" align="left">: <?php if(!empty($poDtaData)){ echo $supplier_email;} ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left">Tel</td>
						<td width="70%" align="left">: <?php if(!empty($poDtaData)){ echo $supplier_tel;} ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left">Fax</td>
						<td width="70%" align="left">: <?php if(!empty($poDtaData)){ echo $supplier_fax;} ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" height="auto" align="right" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="60%" height="20px" align="right" style="font-size: 15px; color: #005b8a;">PO Number&nbsp;&nbsp;</td>
						<td width="40%" style="font-size: 15px; color: #005b8a;">: &nbsp;<?php if(!empty($poDtaData)){ echo $po_numb;} ?></td>
					</tr>
					
					<tr>
						<td width="60%" height="20px" align="right" style="font-size: 15px; color: #005b8a;">PO Date&nbsp;&nbsp;</td>
						<td width="40%" style="font-size: 15px; color: #005b8a;">: &nbsp;<?php if(!empty($poDtaData)){ echo $po_date;} ?></td>
					</tr>
					
				</table>
			</td>
		</tr>
	</table>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 11px; margin-top: 0px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" align="left">
				<h1 style="font-size: 15px; color: #005b8a;">Ship To</h1>
			</td>
		</tr>
	</table>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 0px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="40%" height="20px" align="left">Outlet</td>
						<td width="60%" align="left">: <?php if(!empty($poDtaData)){ echo $outlet_name;} ?></td>
					</tr>
					<tr>
						<td width="40%" height="20px" align="left" valign="top">Address</td>
						<td width="60%" align="left">: <?php if(!empty($poDtaData)){ echo $outlet_address;} ?></td>
					</tr>
					<tr>
						<td width="40%" height="20px" align="left">Tel</td>
						<td width="60%" align="left">: <?php if(!empty($poDtaData)){ echo $outlet_contact;} ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" height="auto" align="right" valign="top">&nbsp;</td>
		</tr>
	</table>
    <table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 10px;" width="100%" height="auto">
		<tr>
			<td width="20%" height="25px" style="padding-left: 10px; font-weight: bold; border-bottom: 1px solid #656563;" align="left">Product Code</td>
			<td width="30%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Product Name</td>
			<td width="13%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Purchase Bill No.</td>
			<td width="13%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Ordered Qty.</td>
			<td width="13%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Product Amount.</td>
			<td width="11%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Sub Total</td>
		</tr>
	<?php
        $poItemData = $this->Constant_model->getDataOneColumnSortColumn('purchase_order_items', 'po_id', $id, 'id', 'ASC');
       $total_amount=0;
		for ($pi = 0; $pi < count($poItemData); ++$pi) {
            $po_item_id = $poItemData[$pi]->id;
            $po_item_pcode = $poItemData[$pi]->product_code;
			$po_item_billno = $poItemData[$pi]->bill_no;
            $po_item_qty = $poItemData[$pi]->ordered_qty;
			$po_item_amt = $poItemData[$pi]->cost;
			$po_item_grand_total = $poItemData[$pi]->subTotal;

            $poNameResult = $this->db->query("SELECT * FROM products WHERE code = '$po_item_pcode' ");
            $poNameData = $poNameResult->result();
			
			$total_amount+= $po_item_grand_total;
            $po_name = $poNameData[0]->name; ?>
			<tr>
				<td height="25px" style="padding-left: 10px; border-bottom: 1px solid #656563;" align="left"><?php echo $po_item_pcode; ?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?php echo $po_name; ?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?php if(!empty($poDtaData)){ echo $purchase_bill_no; } ?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?php echo $po_item_qty; ?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=!empty($po_item_amt)?number_format($po_item_amt,2):'0'?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=!empty($po_item_grand_total)?number_format($po_item_grand_total,2):'0'?></td>
			</tr>
	<?php	
        }
    ?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td align="left"><strong>Total Amount</strong></td>
				<td  align="left"><strong><?php echo number_format($total_amount,2);?></strong></td>
			</tr>
    </table>
	<?php
		if(!empty($DistributedPurchaseDetail))
		{
		?>	
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 11px; margin-top: 10px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" align="left">
				<h1 style="font-size: 15px; color: #005b8a;">Distributed Data WareHouse</h1>
			</td>
		</tr>
	</table>
	
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 0px;" width="100%" height="auto">
		<tr>
			<td width="40%" height="25px" style="padding-left: 10px; font-weight: bold; border-bottom: 1px solid #656563;" align="left">Warehouse / Tank</td>
			<td width="20%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Qty</td>
			<td width="20%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Outlet</td>
			<td width="20%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Created Date</td>
		</tr>
			<?php
				foreach ($DistributedPurchaseDetail as $values)
			{ ?>
			<tr>
				<td height="25px" style="padding-left: 10px; border-bottom: 1px solid #656563;" align="left">
					<?php
						if($values->type == 0)
						{
							echo $this->Purchaseorder_model->DistributedPurchaseWareHouse($values->id);
						}
						else
						{
							echo $this->Purchaseorder_model->DistributedPurchaseTank($values->id);
						}
					?>
				</td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=$values->tank_qty;?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=$values->outletname;?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=$values->created_at;?></td>
			</tr>
			<?php }
			?>
    </table>
	<?php 
	}
?>
	
	<?php
	if(!empty($PaymentPurchaseDetail))
	{
	?>	
	
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 11px; margin-top: 10px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" align="left">
				<h1 style="font-size: 15px; color: #005b8a;">Payment Detail</h1>
			</td>
		</tr>
	</table>
	
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 0px;" width="100%" height="auto">
		<tr>
			<td width="20%" height="25px" style="padding-left: 10px; font-weight: bold; border-bottom: 1px solid #656563;" align="left">Supplier Name</td>
			<td width="20%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Outlet Name</td>
			<td width="20%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Payment Type</td>
			<td width="20%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Amount</td>
			<td width="20%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">Created Date</td>
		</tr>
			<?php
			foreach ($PaymentPurchaseDetail as $values)
			{ ?>
			<tr>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=$values->supplier_name?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=$values->outlet_name?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=$values->payment_name?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=number_format($values->paid_amt,2)?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?=$values->paid_date?></td>
			</tr>
			<?php }
			?>
    </table>
	<?php 
	}
?>
	
	
	
	
	
    <table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 30px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" align="left" valign="top">
			
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="20%" valign="top" align="left"><b>Note</b> :</td>
						<td width="80%" align="left"><?php if(!empty($poDtaData)){ echo nl2br($po_note);} ?></td>
					</tr>
				</table>
			
			</td>
			<td width="50%" height="auto" align="right" valign="top">
				
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="40%" align="right"><b>Authorized By</b></td>
						<td width="60%" style="border-bottom: 1px solid #656563"></td>
					</tr>
					<tr>
						<td colspan="2" height="30px"></td>
					</tr>
					<tr>
						<td width="40%" align="right"><b>Signature</b></td>
						<td width="60%" style="border-bottom: 1px solid #656563"></td>
					</tr>
				</table>
				
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
