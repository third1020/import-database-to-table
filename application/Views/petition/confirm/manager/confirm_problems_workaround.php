<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('problems.header_workaround')?></h4>
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
	<?php echo form_open("Petition/Problems_workaround/$problems->id"); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<label><?=$problems->problems_tital?></label>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
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
	<div class="panel panel-default">
		<div class="panel-heading">
			<label><?=lang('problems.workaround')?></label>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label><?=lang('problems.wr_action_start')?></label>
						<div class='input-group date' id='datetimepicker1'>
							<input name="action_start" type='text'
								onkeydown="return false" class="form-control"
								value="<?=isset($input['action_start']) ? $input['action_start'] : '' ?>" />
							<span class="input-group-addon"> <span
								class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label><?=lang('problems.wr_action_end')?></label>
						<div class='input-group date' id='datetimepicker2'>
							<input name="action_end" type='text'
								onkeydown="return false" class="form-control"
								value="<?=isset($input['action_end']) ? $input['action_end'] : '' ?>" />
							<span class="input-group-addon"> <span
								class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label><?=lang('problems.wr_title')?></label> <input
							name="wr_title" class="form-control"
							value="<?=isset($input['wr_title']) ? $input['wr_title'] : '' ?>">
					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<div class="col-lg-12">
				<div class="form-group">
						<label><?=lang('problems.wr_detail')?></label> 
						<textarea id="froala-editor" name="wr_detail" >
						<?=isset($input['wr_detail']) ? $input['wr_detail'] : '' ?>
						</textarea>
					</div>
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
	<!-- /.col-lg-12 -->
	<script>
$('#froala-editor').froalaEditor({
	toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',  '|', 'fontFamily',  '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent',  '-', '|',  'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'help', 'html', '|', 'undo', 'redo'],
	heightMin: 300,
  heightMax: 300
}); 

$(function () {
    $('#datetimepicker1').datetimepicker({
    		format: 'DD/MM/YYYY'
    });

    $('#datetimepicker2').datetimepicker({
		format: 'DD/MM/YYYY'
});
});
</script>