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
			<h1 class="page-header">List of Purchase Bonuses</h1>
		</div>
	</div><!--/.row-->

	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
						<div class="col-md-12" style="text-align: right;">
							<a href="<?=base_url()?>purchase_order/exportpurchase_bonus" type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
								Export Inventory
							</a>
						</div>
					</div>
					<form action="" method="get">	
					<div class="row" style="margin-top: 10px;">
<!--						<div class="col-md-1" style="padding-left: 2px;">
							<div class="form-group">
								<label>Product Code</label>
								<input type="text"  value="<?=!empty($this->input->get('product_code'))?$this->input->get('product_code'):''?>" name="product_code" class="form-control">
							</div>
                        </div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Product Name</label>
								<input type="text" value="<?=!empty($this->input->get('product_name'))?$this->input->get('product_name'):''?>" name="product_name" class="form-control">
							</div>
                        </div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Outlet</label>
								<select class="form-control" name="outlet_id">
									<option value="">All Outlets</option>
									<?php
									foreach ($getOutlets as $outlets)
									{
										$selectd = '';
										if(!empty($this->input->get('outlet_id')))
										{
											if($outlets->id == $this->input->get('outlet_id'))
											{
												$selectd = 'selected';
											}
										}
									?>
									<option <?=$selectd?> value="<?=$outlets->id?>"><?=$outlets->name?></option>
									<?php }
									?>
								</select>
							</div>
                        </div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Supplier</label>
								<select class="form-control" name="supplier_id">
									<option value="">All Stores</option>
									<?php
									foreach ($getSupplier as $supplier)
									{
										$selectd = '';
										if(!empty($this->input->get('supplier_id')))
										{
											if($supplier->id == $this->input->get('supplier_id'))
											{
												$selectd = 'selected';
											}
										}
									?>
									<option <?=$selectd?> value="<?=$supplier->id?>"><?=$supplier->name?></option>
									<?php }
									?>
								</select>
							</div>
                        </div>-->
						<div class="col-md-3">
							<div class="form-group">
								<label>Start Date</label>
								<input type="text" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>"  name="start_date" id="startDate" class="form-control">
							</div>
                        </div>
						<div class="col-md-3">
							<div class="form-group">
								<label>End Date</label>
								<input type="text" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>"  name="end_date" id="endDate" class="form-control">
							</div>
                        </div>
                        
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;</label><br>
								<button class="btn btn-primary" style="width: 100%;">&nbsp;&nbsp;Search&nbsp;&nbsp;</button>
							</div>
						</div>
					</div>
					</form>	
					
					<div class="row" style="margin-top: 19px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th style="text-align: left;" class="table-left-border">Date & Time</th>
									    	<th style="text-align: left;" class="table-left-border">Product Code</th>
											<th style="text-align: left;" class="table-left-border">Product Name</th>
										    <th style="text-align: left;" class="table-left-border">Outlet</th>
										    <th style="text-align: left;" class="table-left-border">Purchase Order No</th>
                                            <th style="text-align: left;" class="table-left-border">Supplier</th>
                                            <th style="text-align: left;" class="table-left-border">Quantity</th>
                                            <th style="text-align: left;" class="table-left-border">Value</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($getBonusPurchase as $value)
										{ 
											$totalvalue = $value->purchase_price * $value->bonusqty;
											?>
										<tr>
											<td><?=$value->created_datetime?></td>
											<td><?=$value->product_code?></td>
											<td><?=$value->productname?></td>
											<td><?=$value->outletsname?></td>
											<td><?=$value->po_id?></td>
											<td><?=$value->suppliersname?></td>
											<td><?=!empty($value->bonusqty)?number_format($value->bonusqty,2):0?></td>
											<td><?=!empty($totalvalue)?number_format($totalvalue,2):0?></td>
										</tr>
									<?php }
										?>
									</tbody>
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
					{
						extend: "pageLength",
					},
	                
	              ],
					order:[0,'desc'],
					responsive: true,
	            });
	      });

</script>	
	
<?php
    require_once 'includes/footer.php';
?>