<div id="reorderlevelReorder" class="modal fade "> 
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #5fc509;">
						<h3 class="modal-title" style="color: #FFF;">Product Re-Order notification </h3>
					</div>

					<div class="modal-body" style="overflow: visible; background-color: #FFF;max-height: 351px; overflow: auto;">
						<table class="table  table-responsive" width='100%'>
							<thead>
                                <tr>
                                    <th width="23%">Code</th>
                                    <th  width="25%">Product Name</th>
                                    <th  width="25%">Current Qty</th>
                                </tr>
							</thead>
							<tbody>
								<?php
								$OrderDispaly = 0;
								$Pro_Alert_Data = $this->db->get_where('products', array('status' => 1, 'alt_qty !=' => 0))->result();
								foreach ($Pro_Alert_Data as $value) {
									$code = $value->code;
									$name = $value->name;
									$outlet_id_fk = $value->outlet_id_fk;
									
									$get_inventoryrow = $this->db->query('SELECT SUM(qty) as qty FROM inventory WHERE product_code = "'.$code.'" ')->row();
									$get_qty = @$get_inventoryrow->qty;
									if ($get_qty <= $value->alt_qty AND $get_qty != 0) 
										{
											$OrderDispaly = 1;
										?>
											<tr>
												<td><?=$code?></td>
												<td><?=$name?></td>
												<td><?=$get_qty?></td>
											</tr>
									<?php }
									} ?>
							</tbody>
						</table>	
					</div>
					<button id="donotshowthisagainReorder" class="btn btn-primary">Do not show this again</button>
                </div>
            </div>
        </div>
		
		
		
		<div id="timepicker4ModalExpiry" class="modal fade deatail" > 
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background-color: #5fc509;">
						<h3 class="modal-title" style="color: #FFF;">Expiry notification </h3>
					</div>
					<div class="modal-body" style="overflow: visible; background-color: #FFF; max-height: 351px; overflow: auto;">
						<table class="table  table-responsive" width='100%'>
							<thead>
                                <tr>
                                    <th width="33%">Code</th>
                                    <th  width="33%">Batch No</th>
                                    <th  width="">Expiry</th>
                                </tr>
							</thead>
							<tbody>
								
								<?php
									$pro_Data = $this->db->select('inventory.product_code,batch_expire_multi.expirydate,batch_expire_multi.batch_no');
									$pro_Data = $this->db->from('inventory');
									$pro_Data = $this->db->join('batch_expire_multi','batch_expire_multi.inventory_id = inventory.id');
									$pro_Data = $this->db->get()->result();

									$today_date = date('Y-m-d');
									$yellow = 90;
									$ash = 30;
									$red = 7;
									$Display = 0;

								foreach ($pro_Data as $value) {
									$pcode			= $value->product_code;
									$pQuery			= $this->db->get_where("products", array('code' => $pcode))->row();
									$batch_no		= $value->batch_no;
									$expire_date	= $value->expirydate;
									$date1			= date_create($today_date);
									$date2			= date_create($expire_date);
									$diff			= date_diff($date1, $date2);
									$days			= $diff->format("%a");
									if ($today_date < $expire_date) {
										$Display = 1;
										if ($days <= $yellow AND $days > $ash) {
											?>
											<tr  style="background-color:yellow">
												<td> <?php echo $pcode; ?> </td>
												<td> <?php echo $batch_no; ?> </td>
												<td> <?php echo $expire_date; ?> </td>
											</tr>
											<?php
										} else if ($days <= $ash AND $days > $red) {
											?>
											<tr style="background-color:#b2beb5">
												<td> <?php echo $pcode; ?> </td>
												<td> <?php echo $batch_no; ?> </td>
												<td> <?php echo $expire_date; ?> </td>
											</tr>
											<?php
										} else if ($days <= $red) {
											?>
											<tr style="background-color:red">
												<td> <?php echo $pcode; ?> </td>
												<td> <?php echo $batch_no; ?> </td>
												<td> <?php echo $expire_date; ?> </td>
											</tr>
										<?php }
									}
								} ?>
							</tbody>
						</table>	
					</div>
					<a href="<?php echo base_url() . "/products/expireDetail"; ?>" class="btn btn-primary">View Expire Detail</a>
					<button id="donotshowthisagainExpiry" class="btn btn-primary">Do not show this again</button>
                </div>
            </div>
        </div>

<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.cookie.min.js"></script>
<?php
if ($OrderDispaly === 1) {
	?>
	<script type="text/javascript">
	    $(window).on('load',function(){
			if ($.cookie('modal_shown') == null) {
				$('#reorderlevelReorder').modal('show');	
			}
			
			$('body').delegate('#donotshowthisagainReorder','click',function(){
				$.cookie('modal_shown', 'yes', { expires: 1, path: '/' });
				$('#reorderlevelReorder').modal('hide');
			});
			
		});
	</script>
<?php } ?>
	
<?php 
if ($Display === 1) { 
?>
	<script type="text/javascript">
	$(window).on('load',function(){
		if ($.cookie('modal_shown_expiry') == null) {
			$('#timepicker4ModalExpiry').modal('show');
		}
		
		$('body').delegate('#donotshowthisagainExpiry','click',function(){
				$.cookie('modal_shown_expiry', 'yes', { expires: 1, path: '/' });
				$('#timepicker4ModalExpiry').modal('hide');
		});
		
	});
	</script> 
<?php
}
?>