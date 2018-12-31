<head>

	<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.min.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.pkgd.min.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.pkgd.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.style.css">
	<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.style.min.css">


</head>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?=lang('problems.bt_add_problems')?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">

		<?php if (! empty($errors)) : ?>
        <div class="alert alert-danger">
        <?php foreach ($errors as $field => $error){?>
                <p><?= $error ?></p>
        <?php } ?>
        </div>
<?php endif ?>
                	<?php echo form_open('problems/Add'); ?>
                    <div class="panel panel-default">
			<div class="panel-heading"> <?=lang('problems.problems_form')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('problems.problems_tital')?></label> <input name="problems_tital"
								class="form-control" placeholder="Enter text">
						</div>

						<label><?=lang('request.request_detail')?></label></br>
						<textarea id="froala-editor" name="problems_detail" ></textarea><br>


						<div class="form-group">
							<input type="hidden" name="problems_status" class="form-control" value="0">
							 <label><?=lang('request.problems_status')?> </label> <input type="checkbox" id="myCheck" name="problems_status" onclick="myFunction()" value="1">


							 <p id="text" class="alert alert-success" style="display:none"><?=lang('request.problems_status')?>.1</p>

						</div>


					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>

		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('problems.equipment_problems')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">

							<label><?=lang('problems.equipment_name')?></label>
							<select class="form-control" name="equipment_id">
								<option value=""><?=lang('content.choose')?></option>
							<?php foreach ($equipment as  $val) {  ?>
								<option value="<?=$val->id?>"><?=$val->equipment_name?></option>
								<?php } ?>
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
</script>

<script>
function myFunction() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("text");
    if (checkBox.checked == true){
        text.style.display = "block";
    } else {
       text.style.display = "none";
    }
}
</script>
