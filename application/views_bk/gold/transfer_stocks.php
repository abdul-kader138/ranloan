<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Transfer Stocks</h1>
			<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
				<div role="alert" class="alert alert-success">
				   <button data-dismiss="alert" class="close" type="button">
					   <span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
				   <strong>Well done!</strong>
				   <?= $this->session->flashdata('SUCCESSMSG') ?>
				</div>
				<?php } ?>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
 						<div class="col-md-12">
							<a href="<?=base_url()?>Store/add_transfer_stocks" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i>Add Transfer Stocks
								</button>
							</a>
							<a href="<?=base_url()?>Store/transfer_bulk_item" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i>Transfer Bulk Item
								</button>
							</a>
							<a href="<?=base_url()?>Store/import_transferBulkItem" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
									<i class="icono-plus"></i>Import Transfer Bulk Item
								</button>
							</a>
						</div>
					</div>
					<form method="get">
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-3">
							<div class="form-group">
								<label>Product Code</label>
								<input name="product_code" class="form-control" value="<?=!empty($this->input->get('product_code'))?$this->input->get('product_code'):''?>" type="text">
							</div>
                        </div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Outlet</label>
								<select name="outlet" class="form-control">
									<option value="">Select Outlet</option>
								<?php
								foreach ($getOutlets as $outlet)
								{
									$selected = '';
									if(!empty($this->input->get('outlet')))
									{
										if($this->input->get('outlet') == $outlet->id)
										{
											$selected = 'selected';
										}
									}
									?>
									<option <?=$selected?> value="<?=$outlet->id?>"><?=$outlet->name?></option>
								<?php }
								?>
								</select>
							</div>
                        </div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Start Date</label>
								<input name="start_date" class="form-control"  id="startDate" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" type="text">
							</div>
                        </div>
                        <div class="col-md-2">
							<div class="form-group">
								<label>End Date</label>
								<input name="end_date" class="form-control" id="endDate" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" type="text">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>&nbsp;</label><br>
								<button type="submit" class="btn btn-primary" style="width: 100%;">Search</button>
							</div>
						</div>
					</div>
					</form>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th style="display: none;">#</th>
									    	<th>Date & Time</th>
									    	<th>Product Code</th>
									    	<th>Product</th>
									    	<th>Outlet</th>
									    	<th>From Store</th>
									    	<th>To Store</th>									    	
									    	<th>Transfer Qty</th>									    	
									    	<th>User</th>									    	
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 1;
										foreach ($getTransformStock as $stock)
										{
										?>
										<tr>
											<td style="display: none;"><?=$i++?></td>
											<td><?=date('d-m-Y H:i:s', strtotime($stock->date))?></td>
											<td><?=$stock->product_code?></td>
											<td><?=$stock->name?></td>
											<td><?=$stock->outletname?></td>
											<td><?=$stock->fromstore?></td>
											<td><?=$stock->toname?></td>
											<td><?=!empty($stock->qty)?number_format($stock->qty,2):0?></td>
											<td><?=$stock->fullname?></td>
										</tr>
										<?php }
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
	<br /><br /><br />
</div>
	
<script>	
$(document).ready(function() {
        
        $("#datatable").DataTable({
                  dom: "Bfrtip",
                  "bPaginate": true,ordering: true,"pageLength":15,
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
                  	},
					{
						extend: "pageLength",
					},
                    
                  ],
				  order:['0','desc'],
                  responsive: true,
                });
          });
</script>
 