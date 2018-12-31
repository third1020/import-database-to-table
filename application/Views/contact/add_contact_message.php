<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?=lang('contact.bt_add_contact')?></h1>
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
                	<?php echo form_open('contact/Add'); ?>
                    <div class="panel panel-default">
			<div class="panel-heading"> <?=lang('contact.contact_form')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('contact.contact_name')?></label> <input name="contact_name" class="form-control"
								placeholder="contact_name"></br>
						</div>

						<div class="form-group">
							<label><?=lang('contact.contact_phone')?></label> <input name="contact_phone" class="form-control"
								placeholder="contact_phone"></br>
						</div>

						<div class="form-group">
							<label><?=lang('contact.contact_email')?></label> <input name="contact_email" class="form-control"
								placeholder="contact_email"></br>
						</div>

						<div class="form-group">
							<label><?=lang('contact.contact_address')?></label> <input name="contact_address" class="form-control"
								placeholder="contact_address"></br>
						</div>

								<label><?=lang('contact.contact_detail')?></label></br>
							<textarea id="froala-editor" name="contact_detail"></textarea>
							<br>
							
							<div class="form-group">
							<label><?=lang('contact.user_in_system')?></label>
							<select class="form-control" name="user_id">
								<option value=""><?=lang('content.choose')?></option>
							<?php foreach ($user as  $val) {  ?>
								<option value="<?=$val->id?>"><?=$val->name?></option>
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
