<?php 
$alert_msg=$this->session->userdata('alert_msg');
?>
<script type="text/javascript">
    function openReceipt(ele) {
        var myWindow = window.open(ele, "", "width=380, height=550");
    }
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Goldsmith Wastage</h1>
        </div>
    </div><!--/.row-->

    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="search_box" method="get" >
						
                        <div class="row" style="margin-top: 10px;">
							
                            <div class="col-md-2" style="width:17%">
								<label>Date & Time</label>
								<input class="form-control" type="" value="<?=date('Y-m-d H:i:s')?>" readonly="" >
							</div>
                            <div class="col-md-2"style="width:17%">
								<label>Wastage Form No.</label>
								<input class="form-control" type="" value="" readonly="">
							</div>
                            <div class="col-md-2" style="width:22%">
								<label>Outlet</label>
								<select class="form-control" name="">
									<option  value="">Select outlet</option>
									<?php foreach($outlets as $viewoutlet) { ?>
									<option  value="<?= $viewoutlet->id?>"><?= $viewoutlet->name?></option>
									<?php } ?>
								</select>
							</div>
							
							<div class="col-md-2"style="width:22%">
								<label>Goldsmith</label>
								<select class="form-control" name="">
									<option  value="">Select Goldsmith</option>
									<?php foreach($goldsmith as $goldview){ ?>
									<option  value="<?=$goldview->gs_id?>"><?=$goldview->fullname?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-2" style="width:20%">
								<label>Wastage (g)per 8 g</label>
								<input class="form-control" type="" value="">
							</div>
							
                         
						</div>
						
					<div class="row" style="margin-top: 40px;">
                            <div class="col-md-2" style="width:20%">
								<label>Select Category</label>
								<select class="form-control category" name="category" id="category">
									<option  value="">Select Category</option>
									<?php foreach($category as $categoryview){ ?>
									<option  value="<?=$categoryview->id?>"><?=$categoryview->name?></option>
									<?php } ?>
								</select>
							</div>
							
							<div class="col-md-2" style="width:20%">
								<label>Select Sub Category</label>
								<select class="form-control" name="subcategory" id="subcategory">
									<option  value="">Select Sub Category</option>
								</select>
							</div>
							
							<div class="col-md-2">
								<label>Created By</label>
								<input class="form-control" type="" value="<?=$logged_name?>" readonly="" >
							</div>
							
                           <div class="col-md-2" style="margin-top: -15px;">
                                <div class="form-group">
                                    <label>&nbsp;</label><br />
                                    <input type="submit" class="btn btn-primary" style="width: 50%; margin-top: 14px;" value="Save" >
                                </div>
                            </div>
						</div>
						
						
						
						<br><br>
						<br>
						<br><br>
				    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-12" >
                            
                            <div class="table-responsive">
                                <table class="table" id="ReceivedWorkOrders">
                                    <thead>
                                        <tr>
											<th>Date & Time</th>
											<th>Wastage Form No.</th>
											<th>Outlet </th>
											<th>Goldsmith</th>
											<th>Sub Category</th>
											<th>Wastage (g)per 8 g</th>
											<th>User</th>
											<th>Action</th>
										</tr>
                                    </thead>
									
								
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
	$(document).ready(function () {

		$("#ReceivedWorkOrders").DataTable({
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
				},
				{
					extend: "pageLength",
				},
			],
			responsive: true,
			
		});
		
		
	$('.category').change(function () {
		var category_id = $(".category option:selected").val();	
		$.ajax({
			type: 'POST',
			url: "<?= base_url(); ?>Productions/getSubCategoryGoldsmith",
			data: {category_id: category_id},
			dataType: 'JSON',
			success: function (data) {
				$('#subcategory').html(data.subcategory);
			}
		});
	
	})
		
		
});
</script>
    

 