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


<form action="<?=base_url()?>Store/insert_import_transferBulkItem" method="post" enctype="multipart/form-data">
	<div class="col-md-offset-6" style="margin-top: 40px;">
		<div class="form-group">
			<label>Import Transfers <span style="color: #F00">*</span></label>
			<br />
			<input id="uploadFile" readonly style="height: 40px; width: 250px; border: 1px solid #ccc" />
			<div class="fileUpload btn btn-primary" style="padding: 9px 12px;">
				<span>Browse</span>
				<input id="uploadBtn" name="result_file"  required="" type="file" class="upload" />
			</div>
		</div>

		<div class="form-group">
			<input type="submit" name="btn" value="save" class="btn" style="background-color: #5fc509; ">
			<a href="<?php echo base_url()."assets/importTransferBulk/11112017035133555450Bulk Item Import -test.xlsx"; ?>">
				<span class="btn btn-warning">Download a Demo File</span>
			</a>
		</div>
		
		 <div class="form-group">     
            <span style="color:#F00">
			<?php
            $msg =  $this->session->flashdata('import_error_message');
			if(!empty($msg))
			echo $msg;
			?>
            </span>
		</div>
	</div>
</form>