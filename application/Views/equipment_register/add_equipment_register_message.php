<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?=lang('equipment.bt_add_equipment')?></h1>
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

                	<?php echo form_open('EquipmentRegister/Add'); ?>
                    <div class="panel panel-default">
			<div class="panel-heading"> <?=lang('equipment.equipment_form')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">



							 <div class="form-group">
	 						 <label><?=lang('equipment.name')?></label>
	 							 <input type="text" class="form-control" id="equipment_name" name="equipment_name">
	 						 </div>

						 <div class="form-group">
						 <label><?=lang('equipment.detail')?></label></br>
	 					<textarea id="froala-editor" name="detail"></textarea>
	 				 </div>

					 <div class="form-group">
					 <label><?=lang('equipment.department')?></label></br>
					 <input type="text" class="form-control" name="department">
				 </div>

				 <div class="form-group">
				 <label><?=lang('equipment.username')?></label></br>
				 <input type="text" class="form-control" name="username">
			   </div>

				 <div class="form-group">
				 <label><?=lang('equipment.history')?></label></br>
				 <input type="text" class="form-control" name="history">
			   </div>

					 <div class="form-group">
						 <label><?=lang('equipment.equipment_register_type')?></label>
						 <select class="form-control" name="equipment_type">
							 <?php foreach ($equipment_type as  $val) {  ?>
								 <option value="<?=$val->type_name?>"><?=$val->type_name?></option>
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


		<button type="submit"  value="upload" class="btn btn-default"><?=lang('datatables.bt_submit')?></button>
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
$(function() {
	$('textarea#froala-editor').froalaEditor({
		toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',  '|', 'fontFamily',  '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent',  '-', '|',  'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'help', 'html', '|', 'undo', 'redo'],
		heightMin: 300,
		heightMax: 300
	})
});
</script>

<script>

$(function previewFile() {
  var preview = document.querySelector('equipment_image');
  var file    = document.querySelector('input[type=file]').files[0];
  var reader  = new FileReader();

  reader.addEventListener("load", function () {
    preview.src = reader.result;
  }, false);

  if (file) {
    reader.readAsDataURL(file);
  }
});


</script>
