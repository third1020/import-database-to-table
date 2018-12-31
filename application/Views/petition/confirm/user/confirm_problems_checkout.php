<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('request.header_request')?></h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<?php if(isset($validation) && $validation->getErrors()) { ?>
<div class="alert alert-danger">
	<?php

    foreach ($validation->getErrors() as $key => $val) {
        printf("<p>" . $val . "</p>");
    }
    ?>
</div>
<?php } ?>
<!-- /.row -->
<div class="row">
	<?php echo form_open("Petition/Problems_checkout/$problems->id"); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<label><?=$problems->problems_tital?></label>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Detail</label>
						<textarea id="froala-editor">
						<?=$problems->problems_detail?>
						</textarea>
						<div class="clearfix"></div>
					</div>
					<div class="form-group">
						<div class="checkbox">
							<label> <input name="confirm" type="checkbox" value="true"> <?=lang('problems.confirm_checkbox_sucess')?>
							</label>
						</div>
					</div>

					<div class="form-group">
						<label><?=lang('problems.equipment_name')?></label>
                        <p class="form-control-static"><?=$problems->getEquipment()->equipment_name?></p>
					</div>

					<div class="form-group">
						<label><?=lang('problems.contact_name')?></label>
                        <p class="form-control-static"><?=$problems->getContact()->contact_name?></p>
					</div>

					<div class="form-group">
						<label><?=lang('problems.impact_name')?></label>
                        <p class="form-control-static"><?=$problems->getImpact()->impact_name?></p>
					</div>
					
					<div class="form-group">
						<label><?=lang('problems.priority_name')?></label>
                        <p class="form-control-static"><?=$problems->getPriority()->priority_name?></p>
					</div>
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
