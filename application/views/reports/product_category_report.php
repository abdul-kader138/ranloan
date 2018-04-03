<?php
//require_once '../includes/header.php';
$this->load->view('includes/header');
?>
<script type="text/javascript">
    $(document).ready(function () {
        
		$("#outletdata_table").DataTable({
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
					className: "change btn-primary",
					exportOptions:{columns:[0,1,2,3,4,5,6,7,8]},
				},
				{
					extend: "pageLength",
				},
             ],
			order:[0,"desc"],
			responsive: true,
		});
		$("#example").DataTable({
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
					className: "change btn-primary",
					exportOptions:{columns:[0,1,2,3,4,5,6,7,8]},
				},
				{
					extend: "pageLength",
				},
             ],
			order:[0,"desc"],
			responsive: true,
		});
		
		
    });
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Product Category Report</h1>
        </div>
    </div><!--/.row-->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <form action="<?= base_url() ?>reports/product_category_report" method="get">
                        <div class="row">
							 <div class="col-md-6">
							 </div>
<!--                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Outlet</label>
                                    <select name="outlet" class="form-control" >
                                            <option value="">Choose Outlet</option>
											<?php
											foreach ($getOutletsFilter as $out)
											{
												$selected = '';
												if(!empty($this->input->get('outlet')))
												{	
													if($this->input->get('outlet') == $out->id)
													{
														$selected = 'selected';
													}
												}
												?>
											<option <?=$selected?> value="<?=$out->id?>"><?=$out->name?></option>
											<?php
											}
											?>
									 </select>
                                </div>
                            </div>-->
<!--                            <div class="col-md-3">
								<div class="form-group">
                                    <label>Select Category</label>
									<select class="form-control" name="cid">
										<option value="">Select Category</option>
										<?php
										foreach ($getCategoryFilter as $category)
										{ 
											$selected = '';
											if(!empty($this->input->get('cid')))
											{
												if($this->input->get('cid') == $category->id)
												{
													$selected = 'selected';
												}
											}
											
											?>
											<option <?=$selected?> value="<?=$category->id?>"><?=$category->name?></option>
									<?php }
										?>
									</select>
                                </div>
                            </div>-->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="text" name="start_date" class="form-control" id="startDate" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input  type="text"  name="end_date" class="form-control" id="endDate" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label><br />
                                    <input type="hidden" name="report" value="1" />
                                    <input type="submit" class="btn btn-primary" value="Get Report" />
                                </div>
                            </div>
                        </div>
                    </form>
					
<!--					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12" style="text-align: right;">
							<a href="<?= base_url() ?>reports/exportProductCategoryReport" style="text-decoration: none">
								<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
									Export to Excel
								</button>
							</a>
						</div>
					</div>-->
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="example" class="table">
									<thead>
										<tr>
											<th style="text-align: left;" width="30%">Category Name</th>
											<th style="text-align: left;" width="20%">Outlet</th>
											<th style="text-align: left;" width="30%">Quantity</th>
											<th style="text-align: left;" width="40%">Products Total Value</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($getCategory as $cate)
										{
											$outlet = $this->Reports_model->getCategoryReportOutlet($cate->outlet_id_fk);
										?>
										<tr>
											<td><?=$cate->name?></td>
											<td><?php
											$cincate_out = '';
												foreach ($outlet as $ou)
												{
													$cincate_out.= $ou->name.',';
												}
											echo trim($cincate_out,',');
											?></td>
											<td><?=!empty($cate->totalQty)? number_format($cate->totalQty,2):'0.00'?></td>
											<td><?=!empty($cate->productvalue)?number_format($cate->productvalue,2):'0.00'?></td>

										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					
					<div class="row" style="margin-top: 50px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table" id="outletdata_table">
									<thead>
										<tr>
											<th width="30%">Outlet Name</th>
											<th width="20%">Total Stock Qty</th>
											<th width="30%">Total Stock Value</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach ($getOutlet as $outlet)
											{ ?>
												<tr>
													<td><?=$outlet->name?></td>
													<td><?=!empty($outlet->totalQty)?number_format($outlet->totalQty,2):'0.00'?></td>
													<td><?=!empty($outlet->totalvalue)?number_format($outlet->totalvalue,2):'0.00'?></td>
												</tr>
											<?php
											}
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

<?php
//require_once 'includes/header_notification.php';
//require_once 'includes/footer.php';
$this->load->view('includes/header_notification');
$this->load->view('includes/footer');
?>