<?php
?>
<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('permission.heading')?> Step 2/3</h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('permission.preview')?></div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="form-group">
					<label><?=lang('permission.permission_name')?></label>
					<p class="form-control-static"><?=$preData['permission_name']?></p>
				</div>

				<div class="form-group">
					<label><?=lang('permission.permission_roles_view')?></label>
					<?php foreach ($preData['permission_roles'] as $val) { ?>
					<p class="form-control-static"><?=lang('permission.'.$val.'_preview')?></p>
					<?php } ?>
				</div>
			</div>
		</div>
		<?=form_open(site_url('Permission/InsertProcess')) ?>
		<button type="submit" class="btn btn-default"><?=lang('content.bt_submit')?></button>
		<button type="button" onclick='window.history.back();' class="btn btn-default"><?=lang('content.bt_back')?></button>
		<?=form_close()?>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
