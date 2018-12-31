<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('request.header_request')?></h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<?php if(isset($validation) && $validation->getErrors()) { ?>
<div class="alert alert-danger">
	<?php

			foreach ( $validation->getErrors () as $key => $val ) {
				printf ( "<p>" . $val . "</p>" );
			}
			?>
</div>
<?php } ?>
<!-- /.row -->
<div class="row">
	<?php echo form_open("Petition/Problems_confirm/$problems->id"); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<label><?=$problems->problems_tital?></label>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Detail</label> 
						<textarea id="froala-editor" name="problems_detail">
						<?=$problems->problems_detail?>
						</textarea>
						<div class="clearfix"></div>
					</div>
					<?php if($problems->problems_status != 0) { ?>
					<div class="form-group">
						<label style="color: red">The item has been updated.</label>
					</div>
					<?php } else { ?>
					<div class="form-group">
						<label>Status</label> <select name="problems_status" class="form-control">
							<option value="1">not allow</option>
							<option value="2">allow</option>
						</select>
						
						<label><?=lang('problems.contact_name')?></label>
							<select class="form-control" name="contact_id">
								<option value=""><?=lang('content.choose')?></option>
							<?php foreach ($contact as  $val) {  ?>
								<option value="<?=$val->id?>"><?=$val->contact_name?></option>
								<?php } ?>
							</select>

							<label><?=lang('problems.impact_name')?></label>
							<select class="form-control" name="impact_id">
								<option value=""><?=lang('content.choose')?></option>
							<?php foreach ($impact as  $val) {  ?>
								<option value="<?=$val->id?>"><?=$val->impact_name?></option>
								<?php } ?>
							</select>

							<label><?=lang('problems.priority_name')?></label>
							<select class="form-control" name="priority_id">
								<option value=""><?=lang('content.choose')?></option>
							<?php foreach ($priority as  $val) {  ?>
								<option value="<?=$val->id?>"><?=$val->priority_name?></option>
								<?php } ?>
							</select>
					</div>
					<?php } ?>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
	</div>
	<button type="submit" class="btn btn-default"><?=lang('datatables.bt_submit')?></button>
	<button type="reset" class="btn btn-default"><?=lang('datatables.bt_reset')?></button>
                    <?php form_close();?>
                    <!-- /.panel -->
</div>
<!-- /.col-lg-12 -->

<script>
$('#froala-editor').froalaEditor({
	toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',  '|', 'fontFamily',  '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent',  '-', '|',  'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'help', 'html', '|', 'undo', 'redo'],
	heightMin: 300,
  heightMax: 300
});

$("#froala-editor").froalaEditor("edit.off"); 
</script>
