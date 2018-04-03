<?php


//    $settingResult = $this->db->get_where('site_setting');
//    $settingData = $settingResult->row();

//    $setting_dateformat = $settingData->datetime_format;
//    $setting_site_logo = $settingData->site_logo;

    $productData = $this->Constant_model->getDataOneColumn('products', 'id', $id);

    if (count($productData) == 0) {
        $this->session->set_flashdata('alert_msg', array('success', 'Error', 'Something Wrong!'));
        redirect(base_url().'products');

        die();
    }

    $pname = $productData[0]->name;
    $pcode = $productData[0]->code;
    $generic_name = $productData[0]->generic_name;
    $category = $productData[0]->category;
    $sub_category_id_fk = $productData[0]->sub_category_id_fk;
    $rack = $productData[0]->rack;
    $purchase_price = $productData[0]->purchase_price;
    $retail_price = $productData[0]->retail_price;
    $alt_qty = $productData[0]->alt_qty;
    $supplier_id_fk = $productData[0]->supplier_id_fk;
    $code = $productData[0]->code;
    $thumbnail = $productData[0]->thumbnail;

    
    $q_category = $this->db->get_where('category',array('id'=>$category))->row();
    $category = $q_category->name;
    
    $q_sub_category = $this->db->get_where('sub_category',array('id'=>$sub_category_id_fk))->row();
    $sub_category_id_fk = @$q_sub_category->sub_category;
    
    $q_supplier = $this->db->get_where('suppliers',array('id'=>$supplier_id_fk))->row();
    $supplier_id_fk = @$q_supplier->name;
    
?>
    
    
    	<?php
            $this->load->library('Barcode39');
            // set Barcode39 object
            $bc = new Barcode39("$pcode");
            // set text size
            $bc->barcode_text_size = 1;


			$prod_name 	= "";
            $prod_price = "";
            $prod_code 	= "";
            
            $prodDtaResult 		= $this->db->query("SELECT * FROM products WHERE code = '$pcode' ");
            $prodDtaRows 		= $prodDtaResult->num_rows();
            if($prodDtaRows == 1){
                $prodDtaData 	= $prodDtaResult->result();
                
                $prod_name 		= $prodDtaData[0]->name;
                $prod_price 	= $prodDtaData[0]->retail_price;
                $prod_code 		= $prodDtaData[0]->code;
                
                unset($prodDtaData);
            }
            unset($prodDtaResult);
            unset($prodDtaRows);
            
            // display new barcode
            $bc->draw('./assets/barcode/'.$pcode.'.gif');
        ?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Product Code : <?php echo $code; ?></title>
                <link rel="stylesheet" href="<?=base_url() ?>assets/css/bootstrap.css">
		
<style type="text/css" media="all">
	body { 
		max-width: 700px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
	#wrapper { 
		min-width: 650px; 
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
        
        table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
</head>

<body

<div id="wrapper">
	
    <h2 >Product Detail</h2>
	    
	
    
	<table class="table" cellspacing="0"  border="0"> 

		<tbody> 
                    <tr>
                        <td>image</td>
<td>							<?php
   $large_file_path = '';


        if ($thumbnail == 'no_image.jpg') {
            $large_file_path = base_url().'assets/upload/products/small/no_image.jpg'; ?>
                                                        <img src="<?=base_url()?>assets/upload/products/xsmall/no_image.jpg" height="50px" style="border: 1px solid #ccc" />
                                                        <?php

        } else {
            $large_file_path = base_url().'assets/upload/products/small/'.$code.'/'.$thumbnail; ?>
                                                        <img src="<?=base_url()?>assets/upload/products/xsmall/<?php echo $code; ?>/<?php echo $thumbnail; ?>" height="50px" style="border: 1px solid #ccc" />
                                                        <?php

        } ?></td>
                    </tr>
                    <tr>
                        <td>Barcode</td>
                        <td>
                                    <table border="0"  width="140px" height="auto">
			<tr>
				<td style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 12px;">
					<?php echo $prod_name; ?>
				</td>
			</tr>
			<tr>
				<td style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 12px;">
					<img src="<?=base_url()?>assets/barcode/<?php echo $pcode; ?>.gif" />
				</td>
			</tr>
			<tr>
				<td style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 11px;">
					<?php echo $prod_code; ?>
				</td>
			</tr>
			<tr>
				<td style="font-family: Arial, Helvetica, sans-serif; text-align: center; font-size: 11px;">
						<?php if(!empty($prod_price)) { echo number_format($prod_price, 2, '.', ''); } else { echo $prod_price; } ?>	
				</td>
			</tr>
		</table>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><?=$pname;?></td>
                    </tr>
                    <tr style="display:none;">
                        <td>Generic Name</td>
                        <td><?= $generic_name ?></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td><?= $category; ?></td>
                    </tr>
                    <tr>
                        <td>Sub Category</td>
                        <td><?= $sub_category_id_fk; ?></td>
                    </tr>
                    <tr>
                        <td>Rack</td>
                        <td><?= $rack; ?></td>
                    </tr>
                    <tr>
                        <td>Cost</td>
                        <td><?= $purchase_price; ?></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><?= $retail_price; ?></td>
                    </tr>
                    <tr>
                        <td>Alert Quality</td>
                        <td><?= $alt_qty; ?></td>
                    </tr>
                    <tr>
                        <td>Supplier</td>
                        <td><?= $supplier_id_fk; ?></td>
                    </tr>
			 
    	</tbody> 
	</table> 
	
    
    
</div>




</body>
</html>
