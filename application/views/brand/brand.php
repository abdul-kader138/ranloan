<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/header.php';
?>
<style>
.dt-button{ background-color:#5fc509 !important; }
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">List Brand</h1>
		</div>
	</div>
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
							<a href="<?=base_url()?>brand/addBrand" style="text-decoration: none;">
								<button type="button" class="btn btn-primary" style="padding-top: 2px; padding-bottom: 2px; border: 0px;">
										<i class="icono-plus"></i> Add Brand
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
										<th style="display:none;">#</th>
										<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Date & Time</th>
										<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Brand</th>
										<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="15%">Supplier</th>
                            			<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Created By</th>
										<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd;" width="10%">Status</th>
										<th style="text-align: left;border-left: 1px solid #ddd; border-bottom: 1px solid #ddd; border-top: 1px solid #ddd; border-right: 1px solid #ddd;" width="20%">Action</th>
                                    </tr>
                            </thead>
                            <tbody>
									<?php

                                        if (count($results) > 0) {
                                            foreach ($results as $data) {
                                                $brand_id = $data->id;
                                                $brand = $data->brand;
                                                $brand_created_by = $data->created_by;
                                                $query = $this->db->get_where('users',array('id'=>$brand_created_by))->row();
                                                $brand_created_by = !empty($query->fullname)?$query->fullname:'';
                                                $brand_date = $data->created_at;
                                                $brand_status = $data->status;
												$query_supplier = $this->db->get_where('brand_suppliers',array('brand_id_fk'=>$brand_id))->result();
											?>
								<tr>
                                    <td style="display:none;"><?=$brand_id?></td>
                                    <td style="border-bottom: 1px solid #ddd;"><?=$brand_date;?></td>
                                    <td style="border-bottom: 1px solid #ddd;"><?=$brand?></td>
                                    <td style="border-bottom: 1px solid #ddd;"><?php
										$supplery = '';
										foreach ($query_supplier as $value) 
										{
											$supplier_id = $value->supplier_id_fk;
											$query_get_id = $this->db->get_where('suppliers',array('id'=>$supplier_id))->row();
											$supplery.= $query_get_id->name.",";
										}
                                    ?>
										<?=rtrim($supplery,",")?>
									</td>
                                    <td style="border-bottom: 1px solid #ddd;">  <?=$brand_created_by?></td>
                                    <td style="border-bottom: 1px solid #ddd;">  <?php    
											if($brand_status == 0){
												echo "Active";
											}else{
												echo "InActive";
											}
										?>
									</td>
                                    <td style="border-bottom: 1px solid #ddd;">
                                        <a href="<?=base_url()?>brand/edit_Brand?id=<?=$brand_id?>" class="btn btn-primary">Edit</a>
                                       <!--<a href="<?=base_url()?>brand/delete_brand?id=<?=$brand_id?>" id="<?=$brand_id?>" class="btn btn-primary brand_popup_show">Delete</a>-->
										<a  id="<?=$brand_id?>" class="btn btn-primary brand_popup_show" >Delete</a>
										
									</td>
								</tr>
								
									<div class="message-box animated fadeIn edit_brand_del" data-sound="alert" id="brand-signout<?=$brand_id?>">
											<div class="mb-container">
												<div class="mb-middle">
													<div class="mb-title"><span class="fa fa-times "></span> Remove<strong></strong> ?</div>
													<div class="mb-content">
														<p>Do you want to delete this Brand?</p>                    
														<p>Press No if youwant to continue work. Press Yes to Remove current Brand.</p>
													
													</div>
													<div class="mb-footer">
														<div class="pull-right">
															
																<a href="<?=base_url()?>brand/delete_brand?id=<?=$brand_id?>" class="btn btn-success btn-lg" >Yes</a>
																<a class="btn btn-default btn-lg mb-control-close" >No</a>
														
														</div>
													</div>
												</div>
											</div>
										</div>
					
						
									<?php
										}
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
						className: "change btn-primary",
						exportOptions:{columns:[0,1,2,3,4,5]},
					},
					{
						extend: "pageLength",
					},
	              ],
				  order:[0,"desc"],
	              responsive: true,
	            });
				
				$(".table").delegate(".brand_popup_show", "click", function(){
					var id = $(this).attr('id'); 
					$('#brand-signout'+id).modal('show');
					
			   });
			   
	      });
</script>	
	
<?php
$app = realpath(APPPATH);
    require_once $app.'/views/includes/footer.php';
?>
<script>
    $(function() {
        $('#ms').change(function() {
        }).multipleSelect({
            width: '100%'
        });
    });
</script>