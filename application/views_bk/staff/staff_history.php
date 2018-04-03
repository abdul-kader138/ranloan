<?php
   
	$app = realpath(APPPATH);
	require_once $app . '/views/includes/header.php';

	$id=$_GET['id'];
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
			<?php  echo form_open_multipart('staff/staff_history_search');     ?>
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
									    <th>Sales invoice Date</th>
										<th>Sales invoice no</th>
										<th>Invoice amount</th>
										<th>Earned commission </th>
										</tr>
								    </thead>
									<tbody>
							
					<?php
						$total_subTotal_amt = 0;
						$total_taxTotal_amt = 0;
						$total_grandTotal_amt = 0;
					   if (count($historyData) > 0) {
						?>			
					
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							
						</tr>
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