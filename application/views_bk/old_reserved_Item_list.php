<?php
require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Reserved Item List - Old</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="get">
						<div class="row" style="margin-top: 10px;">
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Start Date</label>
									<input name="start_date" class="form-control" id="startDate" type="text" value="<?=!empty($this->input->get('start_date'))?$this->input->get('start_date'):''?>">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>End Date</label>
									<input name="end_date" class="form-control" id="endDate" value="<?=!empty($this->input->get('end_date'))?$this->input->get('end_date'):''?>"  type="text">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Sub Category</label>
									<select class="form-control" name="sub_category">
										<option value="">Select Sub Category</option>
										<?php
										foreach ($getSubCategory as $category)
										{
											$selected = '';
											if(!empty($this->input->get('sub_category')))
											{
												if($this->input->get('sub_category') == $category->id)
												{
													$selected = "selected";
												}
											}
											?>
										<option <?=$selected?> value="<?=$category->id?>"><?=$category->sub_category?></option>
										<?php }
										?>
									</select>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>&nbsp;</label><br>
									<button class="btn btn-primary" style="width: 100%; height: 35px;">Search</button>
								</div>
							</div>
						</div>
					</form>
					
					
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">

							<div class="table-responsive">
								<table id="example" class="table" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th width="10%">Date & Time</th>
											<th width="10%">Outlet</th>
											<th width="10%">Customer Order No</th>
											<th width="10%">Sub Category</th>
											<th width="10%">Code</th>
											<th width="10%">Item</th>
											<th width="10%">Work Order No</th>
											<th width="14%">Action</th>
										</tr>
									</thead>
									<tbody>
									
									
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
require_once 'includes/header_notification.php';
?>	
<script>
    $(function () {
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
                },
                {
                    extend: "pageLength",
                },
            ],
            order: [1, 'desc'],
            responsive: true,
        });
	});

</script>

<?php
require_once 'includes/footer.php';
?>