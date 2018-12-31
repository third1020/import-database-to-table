<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('message.message_heading')?></h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<?php if($validation->getErrors()) { ?>
		<div class="alert alert-danger">
			<?php foreach ($validation->getErrors() as $key => $val) { 
			    printf("<p>" . $val ."</p>") ;
			}?>
		</div>
		<?php } ?>
                	<?php echo form_open('Message/Add'); ?>
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('message.message_panel_heading')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('message.message_title')?></label> <input name="message_title"
								class="form-control" placeholder="Enter text" value="<?=isset($input['message_title']) ? $input['message_title']  : ''?>">
						</div>
						<div class="form-group">
							<label><?=lang('message.message_message')?></label> 
							
							<textarea id="froala-editor" name="message_message"><?=isset($input['message_message']) ? $input['message_message']  : ''?></textarea>
						</div>
						<div class="form-group">
							<label><?=lang('message.message_to')?></label>
							<select class="form-control" name="message_to">
								<?php foreach ($user as  $val) {  ?>
									<option value="<?=$val->id?>"><?=$val->user_name?></option>
									<?php } ?>
								</select>
						</div>
					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				
			</div>
			<!-- /.row (nested) -->
		</div>
		<!-- /.panel-body -->
	</div>
	<button type="submit" class="btn btn-default"><?=lang('content.bt_submit')?></button>
	<button type="reset" class="btn btn-default"><?=lang('content.bt_reset')?></button>
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
</script>
