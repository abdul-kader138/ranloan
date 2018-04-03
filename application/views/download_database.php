<?php
require_once 'includes/header.php';
?>
<style type="text/css">
	.fileUpload {
		position: relative;
		overflow: hidden;
		border-radius: 0px;
		margin-left: -4px;
		margin-top: -2px;
	}
	.fileUpload input.upload {
		position: absolute;
		top: 0;
		right: 0;
		margin: 0;
		padding: 0;
		font-size: 20px;
		cursor: pointer;
		opacity: 0;
		filter: alpha(opacity=0);
	}
</style>
<script type="text/javascript">
    $(document).ready(function () {
        document.getElementById("uploadBtn").onchange = function () {
            document.getElementById("uploadFile").value = this.value;
        };
    });
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Download Database</h1>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<?php if ($this->session->flashdata('SUCCESSMSG')) { ?>
						<div role="alert" class="alert alert-success">
							<button data-dismiss="alert" class="close" type="button">
								<span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
							<strong>Well done!</strong>
							<?= $this->session->flashdata('SUCCESSMSG') ?>
						</div>
					<?php } ?>
					<a class="btn btn-primary" href="<?= base_url() ?>setting/send_mail_database">Send Mail Database</a>
					<a class="btn btn-primary" href="<?= base_url() ?>setting/export_database">Export Database</a>
				</div>

				<div class="panel-body">
					<hr>
					<h3>Import Database</h3>
					<hr>

					<div class="col-md-12">
						<form method="post" action="<?=base_url()?>Setting/import_database" enctype="multipart/form-data" >
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>Select Database (.sql) <span style="color: #F00">*</span></label>
										<br>
										<input id="uploadFile" readonly="" style="height: 40px; width: 230px; border: 1px solid #ccc">
										<div class="fileUpload btn btn-primary" style="padding: 9px 12px;">
											<span>Browse</span>
											<input id="uploadBtn" required="" name="uploadFile" class="upload" type="file">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<button style="width: 150px;" type="submit" id="sendBtn" class="btn btn-primary LoaddataRegister">Import Database</button>
									</div>
								</div>
							</div>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>

</div>

<?php
require_once 'includes/footer.php';
?>