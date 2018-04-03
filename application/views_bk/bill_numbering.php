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
			<h1 class="page-header">List - Bill Numbering</h1>
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
							<a href="<?=base_url()?>setting/add_bill_numbering" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i> Add Bill Numbering
								</button>
							</a>
						</div>
						
                                            
						<div class="col-md-6" style="text-align: right;">
							<a href="" style="text-decoration: none;">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									Export Bill Numbering
								</button>
							</a>
						</div>
                                            
					</div>
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-2">
							<div class="form-group">
								<label>Brand</label>
								<select class="form-control" name="getbrand">
									<option value="">All</option>
								 <?php
								 foreach ($getBrand as $brand)
								 { ?>
									<option value="<?=$brand->id?>"><?=$brand->brand?></option>
								<?php }
								 ?>
								</select>
								
							</div>
                        </div>
                        <div class="col-md-2">
							<div class="form-group">
								<label>Supplier</label>
								
								<select class="form-control" name="supplier_name">
									<option value="">All</option>
								 <?php
								 foreach ($getSupplier as $supplier)
								 { ?>
									<option value="<?=$supplier->id?>"><?=$supplier->name?></option>
								<?php }
								 ?>
								</select>
                            </div>
                        </div>
                        <div class="col-md-2">
							<div class="form-group">
								<label>Category</label>
								<select class="form-control" name="category_name">
									<option value="">All</option>
								 <?php
								 foreach ($getCategory as $category)
								 { ?>
									<option value="<?=$category->id?>"><?=$category->name?></option>
								<?php }
								 ?>
								</select>
                            </div>
                        </div>
                        <div class="col-md-2">
							<div class="form-group">
								<label>Sub Category</label>
								
								<select class="form-control" name="sub_category_name">
									<option value="">All</option>
								 <?php
								 foreach ($getSubCategory as $subcategory)
								 { ?>
									<option value="<?=$subcategory->id?>"><?=$subcategory->sub_category?></option>
								<?php }
								 ?>
								</select>
                            </div>
                        </div>
                        <div class="col-md-2">
							<div class="form-group">
								<label>Status</label>
								<select class="form-control" name="sub_category_name">
									<option value="">All</option>
									<option value="0">Active</option>
									<option value="1">Inactive</option>
								</select>
                            </div>
                        </div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;</label><br>
								<button class="btn btn-primary" style="width: 100%;">&nbsp;&nbsp;Search&nbsp;&nbsp;</button>
							</div>
						</div>
					</div>
					
					
					<div class="row" style="margin-top: 19px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<td style="display: none;">Id</td>
											<th class="table-left-border">Date & Time</th>
									    	<th class="table-left-border">Change Frequency</th>
											<th class="table-left-border">Bill Numbering Sales Invoice</th>
											<th class="table-left-border">Bill Numbering Custom Order</th>
										    <th class="table-left-border">Starting Number</th>
										    <th class="table-left-border">Created By</th>
                                            <th class="table-left-border">Status</th>
										</tr>
									</thead>
										
									<tbody>
										<?php foreach ($bilNUmbering_res as $v) { ?>
										
										<tr>
											<td style="display: none;"><?php echo $v->id; ?></td>
											<td><?php echo $v->created_date; ?></td>
											<td><?php  
												if($v->auto_number_change == 1)
												{
													echo "Yes";
												}
												else
												{
													echo "No";
												}
											 ?></td>
											<td><?php 

												echo $v->sale_invoice_num; 

											 ?></td>
											 <td><?php 

											 	echo $v->custom_order_num; 

											  ?></td>
											<td><?php echo $v->enter_starting_number; ?></td>
											<td><?php echo $v->fullname; ?></td>
											<td><?php 
												if($v->status == 1)
												{
													echo "Active";
												}
												else
												{
													echo "InActive";
												}
											 ?></td>
										</tr>

										<?php } ?>
									</tbody>

								</table>
							</div>
							
						</div>
					</div>
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br />
	
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
	              
	              drawCallback: function () {
	              var api = this.api();
	              $( api.table().column(3).footer() ).html("<strong>"+
	              api.column( 3, {page:'current'} ).data().sum().toFixed(2)+" (LKR)</strong>"
	              );
	              }


	            });	    

	            //add by a3frt

	      });

</script>	
	
<?php
    require_once 'includes/footer.php';
?>