<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header">News</h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="panel panel-default">
	<div class="panel-heading"><?=isset($news->news_title) ? $news->news_title  : ''?>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<?=isset($news->news_detail) ? $news->news_detail  : ''?>
				</div>
				<div class="form-group"></div>
				<!-- /.col-lg-6 (nested) -->
			</div>
			<!-- /.row (nested) -->
		</div>
		<!-- /.panel-body -->
	</div>
	<div class="panel-footer">
		<div class="pull-left">
						<?=lang('message.message_view_created_at')?><?=$news->getCreated_at()?> <br>
		</div>
		<div class="pull-right">
						<?=lang('message.message_view_updated_at')?><?=$news->getUpdated_at()?>
						</div>
		<div class="clearfix"></div>
	</div>
</div>
