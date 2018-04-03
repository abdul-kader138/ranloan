<?php
require_once 'includes/header.php';
?>

<style>
    .dt-button{ background-color:#5fc509 !important; }
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">List Sub Category</h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">

					<?php
					if (!empty($alert_msg)) {
						$flash_status = $alert_msg[0];
						$flash_header = $alert_msg[1];
						$flash_desc = $alert_msg[2];
						if ($flash_status == 'failure') {
							?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-warning" role="alert">
										<i class="icono-exclamationCircle" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
							<?php
						}

						if ($flash_status == 'success') {
							?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-success" role="alert">
										<i class="icono-check" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
							<?php
						}
					}
					?>
					<?php
					if ($user_role < 4) {
						?>
						<div class="row" style="border-bottom: 1px solid #e0dede; padding-bottom: 8px; margin-top: -5px;">
							<div class="col-md-2">
								<a href="<?= base_url() ?>sub_category/addSubCategory" style="text-decoration: none;">
									<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
										<i class="icono-plus"></i> Add Sub Category
									</button>
								</a>
							</div>
						</div>
						<?php
					}
					?>
					<div class="row" style="margin-top: 19px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table id="datatable" class="table">
									<thead>
										<tr>
											<th style="display: none;">id</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Date & Time</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Category</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Sub Category</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="20%">Sub Category Prefix</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Created By</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Status</th>
											<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd; border-right: 1px solid #ddd;" width="20%">Action</th>
										</tr>
									</thead>
									<tbody>

										<?php
										if (count($results) > 0) {
											foreach ($results as $data) {
												$category_id = $data->id;
												$category_name = $data->sub_category;
												$category_id_fk = $data->category_id_fk;
												$query = $this->db->get_where('category', array('id' => $category_id_fk))->row();
												$category_id_fk = !empty($query->name)?$query->name:'';
												$category_prefix = $data->prefix;
												$category_created_by = $data->created_by;
												$query = $this->db->get_where('users', array('id' => $category_created_by))->row();
												$category_created_by = !empty($query->fullname)?$query->fullname:'';
												$category_date = $data->created_at;
												$category_status = $data->status;
												?>

												<tr>
													<td style="display: none;"><?php echo $category_id; ?></td>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $category_date; ?></td>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $category_id_fk; ?></td>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $category_name; ?></td>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $category_prefix; ?></td>
													<td style="border-bottom: 1px solid #ddd;"><?php echo $category_created_by; ?></td>
													<td style="border-bottom: 1px solid #ddd;"><?php
														if ($category_status == 0) {

															echo "Active";
														} else {

															echo "InActive";
														}
														?>
													</td>
													<td style="border-bottom: 1px solid #ddd;">
														<a href="<?= base_url() ?>sub_category/edit_SubCategory?id=<?php echo $category_id; ?>" class="btn btn-primary" >Edit</a>
<!--														<a href="<?= base_url() ?>sub_category/delete_SubCategory?id=<?php echo $category_id; ?>" class="btn btn-primary" >Delete</a>-->
														<a  id="<?=$category_id?>" class="btn btn-primary subcat_popup_show" >Delete</a>
													</td>
												</tr>
												
													<div class="message-box animated fadeIn " data-sound="alert" id="subcateg-signout<?=$category_id?>">
														<div class="mb-container">
															<div class="mb-middle">
																<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
																<div class="mb-content">
																	<p>Do you want to delete this Sub Category?</p>                    
																	<p>Press No if youwant to continue work. Press Yes to Remove current Sub Category.</p>

																</div>
																<div class="mb-footer">
																	<div class="pull-right">

																			<a href="<?= base_url() ?>sub_category/delete_SubCategory?id=<?php echo $category_id; ?>" class="btn btn-success btn-lg" >Yes</a>
																			<a class="btn btn-default btn-lg mb-control-close" >No</a>

																	</div>
																</div>
															</div>
														</div>
													</div>
												
												<?php
											}
										} else {
											?>
											<tr>
												<td colspan="4">No matching records found</td>
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
</div>

<script>
    $(document).ready(function () {
        $("#datatable").DataTable({
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
                    exportOptions: {columns: [0, 1, 2, 3, 4, 5]},
                },
				{
					extend: "pageLength",
				},
            ],
			order:[0,"desc"],
            responsive: true,
        });
			$(".table").delegate(".subcat_popup_show", "click", function(){
					var id = $(this).attr('id'); 
					$('#subcateg-signout'+id).modal('show');
					
			   });
    });
</script>	



<?php
require_once 'includes/footer.php';
?>