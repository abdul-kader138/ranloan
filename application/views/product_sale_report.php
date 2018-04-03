<?php
require_once 'includes/header.php';
?>
<script type="text/javascript">
	$(document).ready(function () {
	    $("#example").DataTable({
            dom: "Bfrtip",
            "bPaginate": true, ordering: true, "pageLength": 15,
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
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5, 6]},
                },
                {
                    extend: "pageLength",
                },
            ],
            order: [0, 'desc'],
            responsive: true,
        });
    });

    function openReceiptDetail(ele) {
        window.open(ele, "", "width=650, height=650");
    }
</script>
	
	
	

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Product Sale Report</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px;">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <a href="<?= base_url() ?>reports/product_report"
                                       style="text-decoration: none;">
                                        <button type="button" class="btn btn-success"
                                                style="background-color: #5cb85c; border-color: #4cae4c;">
                                            Product Report
                                        </button>
                                    </a>
                                    <a href="<?= base_url() ?>reports/product_purchase_report"
                                       style="text-decoration: none;">
                                        <button type="button" class="btn btn-success"
                                                style="background-color: #5cb85c; border-color: #4cae4c;">
                                            Purchase Report
                                        </button>
                                    </a>
<!--                                    <a href="<?= base_url() ?>reports/sale_bar_chart"
                                       style="text-decoration: none;">
                                        <button type="button" class="btn btn-success"
                                                style="background-color: #5cb85c; border-color: #4cae4c;">
                                            Sales Bar Chart
                                        </button>
                                    </a>-->
                                </div>
                                <div class="col-md-6" style="text-align: right;">
                                    <a href="<?= base_url() ?>reports/exportProductSaleReport"
                                       style="text-decoration: none;">
                                        <button type="button" class="btn btn-success"
                                                style="background-color: #5cb85c; border-color: #4cae4c;">
                                            Export to Excel
                                        </button>
                                    </a>
                                </div>
                            </div>

                        </div>
						<br />
                        <form action="<?= base_url() ?>reports/sale_report" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Product Code</label>
                                        <input type="text" class="form-control" name="product_code" value="<?=!empty($this->input->get('product_code'))?$this->input->get('product_code'):''?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" name="product_name" value="<?=!empty($this->input->get('product_name'))?$this->input->get('product_name'):''?>"> 
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Select Outlet</label>
                                        <select name="outlet" class="form-control">
											<option value="">Select Outlet</option>
											<?php
											 foreach ($getOutlets as $outlet)
											 { 
												 $selected = '';
												 if(!empty($this->input->get('outlet')))
												 {
													 if($outlet->id == $this->input->get('outlet'))
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
                                        <input type="text" name="start_date" class="form-control" id="startDate" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" name="end_date" class="form-control" id="endDate" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br/>
                                        <input type="hidden" name="report" value="1"/>
                                        <input type="submit" class="btn btn-primary" value="Search"/>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row" style="margin-top: 10px;">
                            <div class="col-md-12">
                                <div class="table-responsive table-striped">
                                    <table id="example" class="display" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
											<th width="10%">Date & Time</th>
											<th width="10%">Sales ID / Return Sale ID</th>
                                            <th width="20%">Code <i class="fa fa-fw fa-sort"></i></th>
                                            <th class="sorting" width="20%">Name<i class="fa fa-fw fa-sort"></i></th>
                                            <th width="20%">Outlet</th>
                                            <th width="20%">Stores</th>
                                            <th width="20%">Total Qty Sold</th>
                                            <th width="20%">Total Sold Income</th>
                                            <th width="20%">Total Profit</th>
                                            <th width="20%">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
											<?php
											foreach ($getsalesProductReport as $sales)
											{ ?>
												<tr>
													<td><?=$sales->created_at?></td>
													<td><?=$sales->order_id?></td>
													<td><?=$sales->product_code?></td>
													<td><?=$sales->product_name?></td>
													<td><?=$sales->outlet_name?></td>
													<td>
													<?php
														$stringstore = '';
														$store  = $this->db->query("SELECT outlet_warehouse.*,stores.s_name FROM outlet_warehouse INNER JOIN stores ON stores.s_id = outlet_warehouse.w_id WHERE outlet_warehouse.out_id = '".$sales->outlet_id."' ");
														foreach ($store->result() as $stor)
														{
															$stringstore.=$stor->s_name.',';
														}
														echo rtrim($stringstore,",");
													?>
													</td>
													<td><?=!empty($sales->qty)?$sales->qty:0?></td>
													<td>
													<?php
														$each_sales_cost = ($sales->price * $sales->qty);
														echo !empty($each_sales_cost)?number_format($each_sales_cost,2):'0.00';
														$each_purchase_cost = ($sales->cost* $sales->qty);
													?>
													</td>
													<td>
													<?php
														$each_profit = 0;
														$each_profit = $each_sales_cost - $each_purchase_cost - $sales->tax;
														echo !empty($each_profit)?number_format($each_profit,2):'0.00';
													?>
													</td>
													<td>
														<a class="btn btn-primary" onclick="openReceiptDetail('<?=base_url()?>pos/view_order_detail?id=<?php echo $sales->order_id; ?>')" style="text-decoration: none; cursor: pointer; border: none;" title="View Detail">
															View Detail
														</a>
													</td>
												</tr>
										<?php }
											?>
									     </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
<?php
require_once 'includes/footer.php';
?>