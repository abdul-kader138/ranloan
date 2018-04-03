<?php
require_once 'includes/header.php';
?>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Gold Grade</h1>
		</div>
	</div><!--/.row-->


	<div id="message" class="message text-center"></div>
	<div class="row">
		<form action="<?=base_url()?>Gold/updategrade"  method="post">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						
						<div class="row">
							
							<div class="col-md-2">
								<div class="form-group">
									<label>Grade Grade <span style="color: #F00">*</span></label>
									<input type="text" readonly=""  name="fullname" value="<?=!empty($getgold->grade_name)?$getgold->grade_name:''?>" class="form-control"  maxlength="499" autofocus required autocomplete="off" />
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<!-- <?php print_r($getgold); ?>  -->
									<label>Gold Purity<span style="color: #F00">*</span></label>
									<input type="hidden" name="last_gold_purity"  value="<?=!empty($getgold->gold_purity)?$getgold->gold_purity:''?>"  />
									<input type="hidden" name="grade_id"  value="<?=!empty($getgold->grade_id)?$getgold->grade_id:''?>"  />
									<input type="number" name="gold_purity" class="form-control" value="<?=!empty($getgold->gold_purity)?$getgold->gold_purity:''?>" required maxlength="254" autocomplete="off" step=".001" />
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Created By </label>
									<input type="text" readonly="" value="<?= $logged_name ?>"  class="form-control"   />
								</div>
							</div>
							
						</div>

						<div class="row">
							<div class="progress" style="height:40px;display:none;">
								<div class="progress-bar btn-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%;line-height:40px;">
									please wait...
                                </div>
                            </div>
							
							<div class="col-md-4">
								<div class="form-group ">
									<input type="submit" class="btn btn-primary text-center" value="Update" />
								</div>
							</div>
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<br /><br /><br /><br /><br />
</div>

<?php
require_once 'includes/footer.php';
?>







