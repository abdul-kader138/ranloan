<?php
   
    require_once 'includes/header.php';

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
			<h1 class="page-header" style="text-align:left;float:left;">Staff Points History </h1>
                        <h4 style="text-align:right;   float:right;  " >Sales Staff:  <?php echo $staff_name; ?> </h4> 
                        <!--<hr style="clear:both;"/>-->
		</div>
	</div><!--/.row-->
	
	
	<div class="row">
		<div class="col-md-12">
			
			<div class="panel panel-default">
				<div class="panel-body">
					
				<div class="row">
   
    <?php          echo form_open_multipart('staff/staff_point_search');     ?>
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
<a href="<?php echo  base_url()."staff/staff_point_history?id=".$id; ?> " >
				<div class="btn btn-success" style=" margin-top: 24px;  background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Reset
				</div>
			</a>
</div>	

					<!-- </div> -->
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
								    <thead>
								    	<tr>
									    	<!-- <th width="7%">Date & Time</th> -->
									    	<!-- <th width="7%">Outlet</th> -->
									    	<th>Date &amp; Time</th>
									    	<th>Outlet</th>
									    	<th>Bill No</th>
									    	<th>Bill Type</th>
									    	<th>Earned Points</th>
									    	<th>Redeemed Points</th>
									    	<th>Balance Points</th>
										    <th>Action</th>
										</tr>
								    </thead>
									<tbody>

					<?php


    //$historyData = $this->Constant_model->getDataOneColumnSortColumn('orders', 'created_user_id', "$id", 'id', 'DESC');

    if (count($historyData) > 0) {
        for ($h = 0; $h < count($historyData); ++$h) {
        	  $staffPoint = $historyData[$h]->staffPoint;
if($staffPoint > 0){

            $sales_id = $historyData[$h]->id;
           
             $outlet_name = $historyData[$h]->outlet_name;
         
            
            $dtm = date("$dateformat   H:i A", strtotime($historyData[$h]->ordered_datetime));
          
             $order_type = $historyData[$h]->status;          

                 ?>
		
				<td><?php echo $dtm; ?></td>
				<td><?php echo $outlet_name; ?></td>
				
				<td><?php echo $sales_id; ?></td>
				<td style="font-weight: bold;">
					<?php
                        if ($order_type == '1') {
                            echo 'Sale';
                        }
            if ($order_type == '2') {
                echo 'Return';
            } ?>
				</td>
				<td><?php echo $staffPoint; ?></td>
				<td>
					<?php
$redeemData = $this->db->where('order_id',$sales_id)->get('redeem')->result();
$totl = '';
foreach ($redeemData as  $value) {
	 $amount= $value-> staff_redeem;
	$totl +=$amount;
}
if($totl > 0){
	echo $totl;
}else{
	echo "0";
}
					?>
				</td>
				<td><?php echo $staffPoint -$totl  ; ?></td>
			


			
				<td>
<a href="<?=base_url()?>staff/staff_redeem?id=<?php echo $sales_id; ?>" style="text-decoration: none; width:100px;">
 <button class="btn btn-primary" >View</button>
</a>
                                </td>
			</tr>
			
<?php

     }   } ?>
                        	
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
//	              $( api.table().column(3).footer() ).html("<strong>Total</strong>"
//	              );
	              $( api.table().column(4).footer() ).html("<strong>"+
	              addCommas(api.column( 4, {page:'current'} ).data().sum().toFixed(2))+"(LKR)</strong>"
	              );
	              $( api.table().column(5).footer() ).html("<strong>"+
	              addCommas(api.column( 5, {page:'current'} ).data().sum().toFixed(2))+"(LKR)</strong>"
	              );
	              $( api.table().column(6).footer() ).html("<strong>"+
	              addCommas(api.column( 6, {page:'current'} ).data().sum().toFixed(2))+"(LKR)</strong>"
	              );
	              }
	            });
	          
	        

	        
	      });

</script>
	
<?php
    require_once 'includes/footer.php';
?>
<script>
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        autoclose: true
    });
   
</script>