<div class="container">
	<h3 style="text-align: center" class="text-success">Showing all data for sale Below minimum sale price</h3>
	<div class="col-md-offset-3">
		<table class="table table-striped table-responsive " id="datatable">
			<tr>
				<th>Permission For</th>
				<th>Product Name/Code</th>
				<th>Desire Price</th>
				<th>Request User</th>
				<th>Accept By</th>
				<th>Requested At</th>
				<th>Accepted at</th>
				<th>Status</th>
				<th>Actions</th>
			</tr>
			<?php 

			$CI =& get_instance();
			$CI->load->model('Constant_model');

			foreach ($res as $v) { ?>
		
			<tr>
				<td>
					<?php echo $v->permission_for; ?>
				</td>
				<td>
					<?php echo $v->product_name_code; ?>
				</td>
				<td>
					<?php echo $v->desire_price; ?>
				</td>
				<td>
					<?php echo $v->user_name; ?>
				</td>
				<td>
					<?php 

					
					$r = $CI->Constant_model->get_accept_user_name($v->accept_user);

					if(!empty($r))
					{
						echo $r[0]->accept_name;
					}
					else
					{
						echo " ";
					}

					?>
				</td>
				<td>
					<?php echo $v->create_at; ?>
				</td>
				<td>
					<?php echo $v->action_at; ?>
				</td>
				<td>
					<?php echo $v->actions; ?>
				</td>
				<td>
					<a href="<?php echo base_url().'dashboard/accept_by_admin/'.$v->id; ?>"><span class="text-succes">Accept</span></a>
					<a href="<?php echo base_url().'dashboard/reject_by_admin/'.$v->id; ?>"><span class="text-danger">Reject</span></a>
				</td>
			</tr>
			<?php	} ?>
		</table>
	</div>
	
</div>

<script>
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
			},
			{
				extend: "pageLength",
			},
		],
		order:[1,'desc'],
		responsive: true,
		
	});
</script>