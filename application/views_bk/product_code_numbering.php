<?php
    require_once 'includes/header.php';
?>
<style>
    
    .dt-button{ background-color:#5fc509 !important; }
	.table-left-border
	{
		border-left: 1px solid #ddd; border-bottom: 1px solid #ddd ! important; border-top: 1px solid #ddd;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">List Product Code Numbering</h1>
		</div>
	</div><!--/.row-->

	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
							<div role="alert" class="alert alert-success">
								<button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
								<strong>Well done!</strong>
								<?= $this->session->flashdata('SUCCESSMSG') ?>
							</div>
					<?php } ?>
					
					<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
						<div class="col-md-6">
							<a href="<?=base_url()?>setting/add_product_code_numbering" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Add Product Code Numbering
								</button>
							</a>
						</div>
					</div>

					
					
					<div class="row" style="margin-top: 19px;">
						<div class="col-md-12">
							
							
							<div class="row" style="margin-top: 19px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th>Date & Time</th>
											<th>Auto Generate Product Code</th>
									    	<th>Select Change Frequency</th>
										    <th>Current Year</th>
										    <th>Current Month</th>
										    <th>Current Day</th>
                                            <th>Starting Number</th>
                                            <th>Category</th>
                                            <th>Sub Category</th>
                                            <th>Sub Category Prefix</th>
                                            <th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($resultdata as $value)
										{ ?>
										<tr>
											<td><?=$value->created_date;?></td>
											<td><?=($value->auto_generate_code == 1)?'Yes':'No';?></td>
											<td>
											<?php
												if($value->change_daily == 1)
												{
													echo "Change Daily";
												}
												else if($value->change_weekly == 1)
												{
													echo "Change Weekly";
												}
												else if($value->change_monthly == 1)
												{
													echo "Change Monthly";	
												}
												else if($value->change_yearly == 1)
												{
													echo "Change Yearly";
												}
											?>
											</td>
											<td>
												<?=($value->current_year == 1)?'Yes':'No';?>
											</td>
											<td>
												<?=($value->current_month == 1)?'Yes':'No';?>
											</td>
											<td>
												<?=($value->current_day == 1)?'Yes':'No';?>
											</td>
											
											<td>
												<?=$value->enter_starting_number;?>
											</td>
											<td>
												<?=$value->categoryname;?>
											</td>
											<td>
												<?=$value->sub_category;?>
											</td>
											<td>
												<?=$value->prefix;?>
											</td>
											<td>
												<!--<a class="btn btn-primary" href="<?=base_url()?>Product_Code_Numbering/editproductcode?id=<?=$value->id;?>">Edit</a>-->
												<a  id="<?=$value->id;?>" class="btn btn-primary edit_popup_show" >Edit</a>
											</td>
										</tr>
										
										<div class="message-box animated fadeIn " data-sound="alert" id="editpage_popup_show<?=$value->id?>">
											<div class="mb-container">
												<div class="mb-middle">
													<div class="mb-title"><span class="fa fa-pencil "></span> Edit<strong></strong> ?</div>
													<div class="mb-content">
														<p>Do you want to edit this row?</p>                    
														<p>Press No if you want to continue work. Press Yes to edit current row.</p>

													</div>
													<div class="mb-footer">
														<div class="pull-right">

																<a href="<?=base_url()?>Product_Code_Numbering/editproductcode?id=<?=$value->id;?>" class="btn btn-success btn-lg" >Yes</a>
																<a class="btn btn-default btn-lg mb-control-close" >No</a>

														</div>
													</div>
												</div>
											</div>
										</div>
										
										
										
									<?php	}
										?>
									</tbody>
										
								

								</table>
							</div>
							
						</div>
					</div>
					
							
							
							
							</div>
							
						</div>
					</div>
					
					
					
				</div>
			</div>
		</div>
		<br /><br /><br />
	</div>
</div><!-- Right Colmn // END -->
	
<script>
	 $(document).ready(function() {
	 	
	 	$("#datatable").DataTable({
	              dom: "Bfrtip",
	              "bPaginate": true,ordering: true,"pageLength":15,
				  "language": {
						"decimal": ",",
						"thousands": "."
					},
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
	                 exportOptions:{columns:[0,1,2,3,4,5]},
 },
	                
	              ],
	              responsive: true,
	              /*
	              drawCallback: function () {
	              var api = this.api();
	              $( api.table().column(3).footer() ).html("<strong>"+
	              api.column( 3, {page:'current'} ).data().sum().toFixed(2)+" (LKR)</strong>"
	              );
	              }*/


	            });
				
				
	        

	        
	      });
		  
		$(".table").delegate(".edit_popup_show", "click", function(){
			  var id = $(this).attr('id'); 
			  $('#editpage_popup_show'+id).modal('show');

		 });

</script>	
	
<?php
    require_once 'includes/footer.php';
?>