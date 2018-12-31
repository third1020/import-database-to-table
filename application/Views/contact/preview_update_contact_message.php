<?php
?>
<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('user.add_user_step_2')?></h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('permission.preview')?></div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<?=form_open(site_url('Request/UpdatePreviewProcess')) ?>

				<div class="form-group">
					<label><?=lang('request.request_tital')?> : </label>
					<?php echo $confirm['request_tital'];?>
					<input type="hidden" name="request_tital" value="<?php echo $confirm['request_tital'];?>"></input>
				</div>

				<div class="form-group">
					<label><?=lang('request.request_detail')?> : </label>
					<?php echo $confirm['request_detail'];?>
					<input type="hidden" name="request_detail" value="<?php echo $confirm['request_detail'];?>"></input>
				</div>


				<div class="form-group">
					<label><?=lang('request.request_status')?> : </label>
					<?php echo $confirm['request_status'];?>
					<input type="hidden" name="request_status" value="<?php echo $confirm['request_status'];?>"></input>
				</div>


				<div class="form-group">
					<label><?=lang('request.equipment_name')?> : </label>
					<?php echo $confirm['equipment_name'];?>

					<input type="hidden" name="equipment_id" value="<?php echo $confirm['equipment_id'];?>"></input>



				</div>




			</div>
		</div>

		<button type="submit"  class="btn btn-default" name="id" value="<?php echo $id;?>"><?=lang('content.bt_submit')?></button>
		<button type="button" onclick="window.history.back();"  class="btn btn-default"><?=lang('content.bt_back')?></button>
		<?=form_close()?>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
