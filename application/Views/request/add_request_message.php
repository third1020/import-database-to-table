<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?=lang('request.bt_add_request')?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<?php if (! empty($success)) : ?>
        <div class="alert alert-success">
			<label><?=lang('datatables.success')?> </label>
		</div>
<?php endif ?>

		<?php if (! empty($errors)) : ?>
        <div class="alert alert-danger">
        <?php foreach ($errors as $field => $error){?>
                <p><?= $error ?></p>
        <?php } ?>
        </div>
<?php endif ?>
                	<?php echo form_open('request/Add'); ?>
    <div class="panel panel-default">
			<div class="panel-heading"> <?=lang('request.request_form')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('request.request_tital')?></label> <input name="request_tital" class="form-control"
								placeholder="request_tital"></br> <label><?=lang('request.request_detail')?></label></br>
							<textarea id="froala-editor" name="request_detail"></textarea>
							</br>
							<div class="form-group">
								<input type="hidden" name="request_status" class="form-control" value="0"> <label><?=lang('request.request_status')?> </label>
								<input type="checkbox" id="myCheck" name="request_status" onclick="myFunction()" value="1">
								<p id="text" class="alert alert-success" style="display: none"><?=lang('request.request_status')?>.1</p>
							</div>
						</div>
						<!-- /.col-lg-6 (nested) -->
					</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading"><?=lang('request.equipment_form')?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label><?=lang('request.equipment_name')?></label> <select class="form-control" name="equipment_id">

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
			<button type="submit" class="btn btn-default"><?=lang('datatables.bt_submit')?></button>
			<button type="reset" class="btn btn-default"><?=lang('datatables.bt_reset')?></button>
                    <?php form_close();?>
                    <!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>

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
