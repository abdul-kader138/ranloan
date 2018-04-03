<?php
require_once 'includes/header.php';
?>
    <style>
        div#example_filter {
            display: none;
        }

        div#example_length {
            display: none;
        }
    </style>

<?php
$orderRows = 0;
$dd_cat = $this->Constant_model->getddData('category', 'id', 'name', 'name');
?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <script>
        $(function () {
            $("#startDate").datepicker({
                format: "<?php echo $dateformat; ?>",
                autoclose: true
            });

            $("#endDate").datepicker({
                format: "<?php echo $dateformat; ?>",
                autoclose: true
            });
        });
    </script>

<?php


?>
    <script type="text/javascript">
        function openReceipt(ele) {
            var myWindow = window.open(ele, "", "width=380, height=550");
        }
    </script>

    <script type="text/javascript" src="<?= base_url() ?>assets/js/datatables/jquery-1.12.3.js"></script>
    <script type="text/javascript" src="<?= base_url() ?>assets/js/datatables/jquery.dataTables.min.js"></script>
    <link href="<?= base_url() ?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sale Bar Chart - Product Wise</h1>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px;">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <a href="<?= base_url() ?>reports/sale_report"
                                       style="text-decoration: none;">
                                        <button type="button" class="btn btn-success"
                                                style="background-color: #5cb85c; border-color: #4cae4c;">
                                            Sales Report
                                        </button>
                                    </a>
                                    <a href="<?= base_url() ?>reports/product_purchase_report"
                                       style="text-decoration: none;">
                                        <button type="button" class="btn btn-success"
                                                style="background-color: #5cb85c; border-color: #4cae4c;">
                                            Purchase Report
                                        </button>
                                    </a>
                                    <a href="<?= base_url() ?>reports/sale_bar_chart"
                                       style="text-decoration: none;">
                                        <button type="button" class="btn btn-success"
                                                style="background-color: #5cb85c; border-color: #4cae4c;">
                                            Sales Bar Chart
                                        </button>
                                    </a>
                                </div>
                                <div class="col-md-6" style="text-align: right;"></div>
                            </div>

                        </div>

                        <form action="" method="get">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Product Code</label>
                                        <input type="text" class="form-control" name="product_code"
                                               value="<?PHP if (isset($product_code)) {
                                                   echo $product_code;
                                               } ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Product Name</label>
                                        <input type="text" class="form-control" name="product_name"
                                               value="<?PHP if (isset($product_name)) {
                                                   echo $product_name;
                                               } ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Outlet</label>
                                        <select name="outlet" class="form-control">
                                            <?php
                                            if ($user_role == '1') {
                                                ?>
                                                <option value="">Choose Outlet</option>
                                                <option value="-" <?php
                                                if ($url_outlet == '-') {
                                                    echo 'selected="selected"';
                                                }
                                                ?>>All Outlets
                                                </option>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                            if ($user_role == '1') {
                                                $outletData = $this->Constant_model->getDataAll('outlets', 'id', 'ASC');
                                            } else {
                                                $outletData = $this->Constant_model->getDataOneColumn('outlets', 'id', "$user_outlet");
                                            }
                                            for ($o = 0; $o < count($outletData); ++$o) {
                                                $outlet_id = $outletData[$o]->id;
                                                $outlet_fn = $outletData[$o]->name;
                                                ?>
                                                <option value="<?php echo $outlet_id; ?>" <?php
                                                if ($url_outlet == $outlet_id) {
                                                    echo 'selected="selected"';
                                                }
                                                ?>>
                                                    <?php echo $outlet_fn; ?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
								<div class="col-md-2">
									<label>Select Store</label>
									<select name="store" class="form-control">
										<option value="">Choose Store</option>
										<?php
										if ($this->input->get('store') == "all") {
											$selectedall = "selected";
										}
										?>
										<option <?= !empty($selectedall) ? $selectedall : '' ?> value="all">All Store</option>
										<?php
										foreach ($getStore as $store) {
											$selected = '';
											if (!empty($this->input->get('store'))) {
												if ($store->s_id == $this->input->get('store') && $this->input->get('store') != "all") {
													$selected = "selected";
												}
											}
											?>
											<option <?= $selected ?> value="<?= $store->s_id ?>"><?= $store->s_name ?></option>
										<?php }
										?>
									</select>
								</div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" name="start_date" class="form-control" id="startDate"
                                               value="<?php echo $url_start; ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" name="end_date" class="form-control"
                                               id="endDate" value="<?php echo $url_end; ?>"/>
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
                                    <table class="display" cellspacing="0" width="100%">
                                        <tbody>
                                        <tr>
                                            <td>Product Code</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Product Name</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Outlet</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Stores</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Period</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><a href="#"
                                                   style="text-decoration: none;">
                                                    <button type="button" class="btn btn-success"
                                                            style="background-color: #5cb85c; border-color: #4cae4c;">
                                                        Monthly - Qty Sold
                                                    </button>
                                                </a></td>
                                            <td><a href="#"
                                                   style="text-decoration: none;">
                                                    <button type="button" class="btn btn-success"
                                                            style="background-color: #5cb85c; border-color: #4cae4c;">
                                                        Monthly - Income
                                                    </button>
                                                </a></td>
                                            <td><a href="#"
                                                   style="text-decoration: none;">
                                                    <button type="button" class="btn btn-success"
                                                            style="background-color: #5cb85c; border-color: #4cae4c;">
                                                        Monthly - Profit
                                                    </button>
                                                </a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
<?php
require_once 'includes/footer.php';
?>