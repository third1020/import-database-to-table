<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('news.news_heading')?></h4>
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
                	<?php echo form_open('News/Add'); ?>
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('news.news_panel_heading')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('news.nesw_title')?></label> <input name="nesw_title"
								class="form-control" placeholder="Enter text" value="<?=isset($input['nesw_title']) ? $input['nesw_title']  : ''?>">
						</div>
						
						<div class="form-group">
							<label><?=lang('news.news_detail')?></label> 
							<textarea id="froala-editor" name="news_detail"><?=isset($input['news_detail']) ? $input['news_detail']  : ''?></textarea>
						</div>
						
						<div class="form-group">
							<label><?=lang('news.nesw_type')?></label>
							<select class="form-control" name="type_id">
								<?php foreach ($news_type as  $val) {  ?>
									<option value="<?=$val->id?>"><?=$val->type_name?></option>
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

<script>
$('#froala-editor').froalaEditor({
	toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',  '|', 'fontFamily',  '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent',  '-', '|',  'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'help', 'html', '|', 'undo', 'redo'],
	heightMin: 300,
  heightMax: 300
});
</script>
