<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('news.news_type_heading')?></h4>
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
                	<?php echo form_open('NewsType/Add'); ?>
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('news.news_type_panel_heading')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('news.nesw_type_name')?></label> <input name="type_name"
								class="form-control" placeholder="Enter text" value="<?=isset($input['type_name']) ? $input['type_name']  : ''?>">
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
</div>
<!-- /.row -->

<script>

</script>
