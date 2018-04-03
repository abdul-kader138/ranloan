<?php
   
	$app = realpath(APPPATH);
	require_once $app . '/views/includes/header.php';

    $custDtaData = $this->Constant_model->getDataOneColumn('staff', 'id', $id);
    if (count($custDtaData) == 0) {
        redirect(base_url());
    }

    $staff_name = $custDtaData[0]->staff_name;
    $email = $custDtaData[0]->email;
    $mobile = $custDtaData[0]->staff_mobile;
    
    
?>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
		    <div class="col-lg-9">
                        <h1 class="page-header" style="text-align:left;float:left;">Sales History</h1>
                        <h4 style="text-align:right;   float:right;  " >Sales Staff:  <?php echo $staff_name; ?> </h4> 

			</div>

		</div>
	</div><!--/.row-->
	
	
	<div class="row">
		<div class="col-md-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					
<div class="row">
   
    <?php          echo form_open_multipart('staff/staff_history_search');     ?>
<div class="col-md-3">
<div class="form-group">
<label>Start Date </label>
<input type="text" name="startdate" id="s" class="form-control datepicker"  maxlength="499"  required autocomplete="off" value="" />
<input type="hidden" name="hid"    value="<?php echo $id; ?>" />
</div>
</div>
<div class="col-md-3">
            <div class="form-group">
                    <label>End Date</label>
                    <input type="text" name="enddate" id="e" class="form-control datepicker"  maxlength="499"  required autocomplete="off" value="" />
            </div>
    </div> 

<div class="col-md-3">
            <div class="form-group">
                
                <button class="btn btn-primary" id="btn-filter"  style="margin-top: 24px;">Search</button>
               
            </div>
    </div>
</form>
<a href="<?php echo  base_url()."staff/staff_history?id=".$id; ?> " >
				<div class="btn btn-success" style=" margin-top: 24px;  background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Reset
				</div>
			</a>
</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
								    <thead>
								    	<tr>
									    <th>Date &amp; Time</th>
                                                                            <th>Outlet</th>
                                                                            <th>Bill No</th>
                                                                            <!--<th>Sales Id</th>-->
									    	<th>Bill Type</th>
										    <th>Bill Amount (<?php echo $currency; ?>)</th>
										    <th>Pionts Earned</th>
										    <th>Action</th>
										</tr>
								    </thead>
									<tbody>
							
<?php
    $total_subTotal_amt = 0;
    $total_taxTotal_amt = 0;
    $total_grandTotal_amt = 0;

   // $historyData = $this->Constant_model->getDataOneColumnSortColumn('orders', 'created_user_id', "$id", 'id', 'DESC');
    
  // print_r($historyData);
  // exit;
//    if(isset($searchQuery)){
//       $historyData = $searchQuery->result(); 
//    }
    
    if (count($historyData) > 0) {
       // print_r($historyData);
     //  exit;
        for ($h = 0; $h < count($historyData); ++$h) {
            $sales_id = $historyData[$h]->id;
            $sid = $historyData[$h]->sid;
            $outlet_name = $historyData[$h]->outlet_name;
            $staffPoint = $historyData[$h]->staffPoint;
            
            $dtm = date("$dateformat   H:i A", strtotime($historyData[$h]->ordered_datetime));
            $subTotal = $historyData[$h]->subtotal;
            $tax = $historyData[$h]->tax;
            $grandTotal = $historyData[$h]->grandtotal;
            $total_items = $historyData[$h]->total_items;
            $order_type = $historyData[$h]->status;

            $total_subTotal_amt += $subTotal;
            $total_taxTotal_amt += $tax;
            $total_grandTotal_amt += $grandTotal;

            $pcodeArray = array();
            $pnameArray = array();
            $qtyArray = array();

            if ($order_type == '1') {                // Order;

                $oItemResult = $this->db->query("SELECT * FROM order_items WHERE order_id = '$sales_id' ORDER BY id ");
                $oItemRows = $oItemResult->num_rows();
                if ($oItemRows > 0) {
                    $oItemData = $oItemResult->result();

                    for ($t = 0; $t < count($oItemData); ++$t) {
                        $oItem_pcode = $oItemData[$t]->product_code;
                        $oItem_pname = $oItemData[$t]->product_name;
                        $oItem_qty = $oItemData[$t]->qty;

                        array_push($pcodeArray, $oItem_pcode);
                        array_push($pnameArray, $oItem_pname);
                        array_push($qtyArray, $oItem_qty);

                        unset($oItem_pcode);
                        unset($oItem_pname);
                        unset($oItem_qty);
                    }

                    unset($oItemData);
                }
                unset($oItemResult);
                unset($oItemRows);
            } elseif ($order_type == '2') {    // Return;

                $rItemResult = $this->db->query("SELECT * FROM return_items WHERE order_id = '$sales_id' ORDER BY id ");
                $rItemRows = $rItemResult->num_rows();
                if ($rItemRows > 0) {
                    $rItemData = $rItemResult->result();
                    for ($r = 0; $r < count($rItemData); ++$r) {
                        $rItem_pcode = $rItemData[$r]->product_code;
                        $rItem_qty = $rItemData[$r]->qty;

                        $productData = $this->Constant_model->getDataOneColumn('products', 'code', $rItem_pcode);
                        $rItem_pname = $productData[0]->name;

                        array_push($pcodeArray, $rItem_pcode);
                        array_push($pnameArray, $rItem_pname);
                        array_push($qtyArray, $rItem_qty);

                        unset($rItem_pcode);
                        unset($rItem_qty);
                        unset($rItem_pname);
                    }
                    unset($rItemData);
                }
                unset($rItemResult);
                unset($rItemRows);
            } ?>			
			<tr>
                            <td><?php echo $dtm; ?></td>
                            <td><?php echo $outlet_name; ?></td>
				<td>
					<?php
                        if ($order_type == '1') {
                            ?>
					<a href="<?=base_url()?>pos/view_invoice?id=<?php echo $sales_id; ?>" style="text-decoration: none;" target="_blank">
					<?php	
                        }
            if ($order_type == '2') {
                ?>
					<a href="<?=base_url()?>returnorder/printReturn?return_id=<?php echo $sales_id; ?>" style="text-decoration: none;" target="_blank">
					<?php

            } ?>
						<?php echo format_order($new_sys_settings['pre_so'],$sid,$new_sys_settings['post_so']); ?>
					</a>
				</td>
				<td style="font-weight: bold;">
					<?php
                        if ($order_type == '1') {
                            echo 'Sale';
                        }
            if ($order_type == '2') {
                echo 'Return';
            } ?>
				</td>
				
				
				<td><?php echo number_format($grandTotal, 2); ?></td>
				<td><?php echo $staffPoint ?></td>
				<td>
					<?php
                        if ($order_type == '1') {
                            ?>
							<a href="<?=base_url()?>pos/view_invoice?id=<?php echo $sales_id; ?>" style="text-decoration: none;" target="_blank">
							    <button class="btn btn-primary" style="padding: 4px 12px;">View Invoice</button>
							</a>
					<?php

                        } else {
                            echo '-';
                        } ?>
				</td>
			</tr>
			<?php
                if (count($pcodeArray) > 1) {
                    for ($p = 1; $p < count($pcodeArray); ++$p) {
                        ?>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>
								<?php
                                    echo $pnameArray[$p].' ['.$pcodeArray[$p].']'; ?>
							</td>
							<td>
								<?php
                                    echo $qtyArray[$p]; ?>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
			<?php

                    }
                } ?>
<?php

        } ?>
<!--                                                <tfoot>
			<tr><td></td><td></td><td></td><td></td><td></td>
				<td  align="center" style="border-top: 1px solid #010101;"></td>
				<td style="border-top: 1px solid #010101;">
					
				</td>
				<td style="border-top: 1px solid #010101;">
					
				</td>
				<td style="border-top: 1px solid #010101;">
					
				</td>
				<td style="border-top: 1px solid #010101;"></td>
			</tr>	</tfoot>	-->
<?php

    } else {
        ?>

			<tr>
				<td colspan="6">No match record found</td>
			</tr>
<?php	
    }
?>
                         <tfoot>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                        </tfoot>
									</tbody>
								</table>
							</div>
							
						</div>
					</div>
					
					
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			
			<a href="<?=base_url()?>staff/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	<script>
	 $(document).ready(function() {
	 	
	 	$("#datatable").DataTable({
	              dom: "Bfrtip",
	              "bPaginate": true,"ordering": true,"pageLength":15,
	              buttons: [
	                {
	                  extend: "copy",
	                  className: "change btn-primary "
	                },
	                {
	                  extend: "csv",
	                  className: " change btn-primary"
	                },
	                {
	                  extend: "excel",
	                  className: "change btn-primary"
	                },
	                
	                {
	                  extend: "print",
	                 className: "change btn-primary",
	                 customize: function ( win ) {
	                    $(win.document.body).find( 'table' ).find("tbody").append($("tfoot").html());
	                    
	                  }
	                  },
	                
	              ],
                      
                
	               responsive: true,
	              drawCallback: function () {
	              var api = this.api();
//	              $( api.table().column().footer() ).html("<strong>Total</strong>"
//	              );
	              $( api.table().column(4).footer() ).html("<strong>"+
	              addCommas(api.column( 4, {page:'current'} ).data().sum().toFixed(2))+"(LKR)</strong>"
	              );
	              $( api.table().column(5).footer() ).html("<strong>"+
	              addCommas(api.column( 5, {page:'current'} ).data().sum().toFixed(2))+"(LKR)</strong>"
	              );
	              }
	            });
	          
	        

	        
	      });

 
</script>


<?php
$app = realpath(APPPATH);

require_once $app . '/views/includes/footer.php';

?>
<script>
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        autoclose: true
    });
   
</script>