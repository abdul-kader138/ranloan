<?php
    require_once 'includes/header.php';
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Customer Group</h1>
		</div>
	</div><!--/.row-->
	<form action="<?=base_url()?>customers/insertCustomergroup" method="post">
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
					
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							<input type="hidden" name="id" value="<?=$edit!=null?$edit['id']:"0"?>" >
								<label>Group Name<span style="color: #F00">*</span></label>
								<input type="text" value="<?=$edit['name']?>" name="name" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
							</div>
						</div>
						
					</div>
					
										
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<button class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
							</div>
						</div>
						<div class="col-md-4"></div>
						<div class="col-md-4"></div>
					</div>
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Customer Group View</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
				<table class="table">
					<thead>
						<th>#</th>
						<th>Customer Group</th>
						<th>Action</th>

					</thead>
					<tbody>
					<?php foreach ($group as $key => $value){ ?>
					<tr>
					<td><?=++$key;?></td>
					<td><?=$value->name?></td>
					<td><a href="<?php echo base_url()?>customers/addcustomergroup/<?=$value->id?>" class="btn btn-primary">Edit</a>
					<a href="<?php echo base_url()?>customers/delcustomergroup/<?=$value->id?>" class="btn btn-primary">Delete</a>
					</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				</div><!-- Panel Body // END -->
			</div>
			<a href="<?=base_url()?>customers/view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i>Back
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	</form>
</div>
<?php
    require_once 'includes/footer.php';
?>