<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?=lang('incident.bt_add_incident')?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php if (! empty($errors)) : ?>
        <div class="alert alert-danger">
        <?php foreach ($errors as $field => $error){?>
                <p><?= $error ?></p>
        <?php } ?>
        </div>
<?php endif ?>
<?php echo form_open('Petition/Incident'); ?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('incident.equipment_incident')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('incident.equipment_name')?></label> 
							<select class="form-control" name="equipment_id">
								<option value=""><?=lang('content.choose')?></option>
							<?php foreach ($equipment as  $val) {  ?>
								<option value="<?=$val->id?>"><?=$val->equipment_name?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		
		<div class="panel panel-default">
			<div class="panel-heading"> <?=lang('incident.incident_form')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<label><?=lang('incident.incident_tital')?></label> 
							<input name="incident_tital" class="form-control"
								placeholder="Enter text" value="<?=isset($input['incident_tital']) ? $input['incident_tital'] : '' ?>">
						</div>
						<label><?=lang('request.request_detail')?></label></br>
						<textarea id="froala-editor" name="incident_detail">
							<?=isset($input['incident_detail']) ? $input['incident_detail'] : '' ?>
						</textarea>
						<br>
					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<button type="submit" class="btn btn-default"><?=lang('datatables.bt_submit')?></button>
		<button type="reset" class="btn btn-default"><?=lang('datatables.bt_reset')?></button>
                    <?php form_close();?>
                    <!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<script src="<?=base_url('assets')?>/js/froala_editor.min.js"></script>
<script src="<?=base_url('assets')?>/js/froala_editor.pkgd.min.js"></script>
<script src="<?=base_url('assets')?>/js/sb-admin-2.js"></script>
<script>
$('#froala-editor').froalaEditor({
	toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',  '|', 'fontFamily',  '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent',  '-', '|',  'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'help', 'html', '|', 'undo', 'redo'],
	heightMin: 300,
  heightMax: 300
});

function myFunction() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("text");
    if (checkBox.checked == true){
        text.style.display = "block";
    } else {
       text.style.display = "none";
    }
}

$('select[name=equipment_id] option[value=<?=isset($input['incident_detail']) ? $input['incident_detail'] : '' ?>]').attr('selected','selected');
</script>
