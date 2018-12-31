<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('message.message_heading')?></h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading"><?=$mes->message_title?></div>
			<div class="panel-body">
						<?=$mes->message_message?>
					</div>
			<div class="panel-footer">
				<div class="pull-left">
						<?=lang('message.message_view_created_at')?><?=$mes->getCreated_at()?> <br>
						<?=lang('message.message_view_updated_at')?><?=$mes->getUpdated_at()?>
						</div>
				<div class="pull-right">
						<?=lang('message.message_view_user_from')?><?=$mes->getMessage_from()?> <br>
						<?=lang('message.message_view_user_to')?><?=$mes->getMessage_to()?>
						</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
