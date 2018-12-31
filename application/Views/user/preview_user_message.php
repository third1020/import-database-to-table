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
				<div class="form-group">
					<label><?=lang('user.userform_username')?> : </label> 
					<?=$preData['username']?>
				</div>
				<div class="form-group">
					<label><?=lang('user.userform_password')?> : </label>
					<?=$preData['password']?>
				</div>
				<div class="form-group">
					<label><?=lang('user.userform_name')?> : </label>
					<?=$preData['name']?>
				</div>
				<div class="form-group">
					<label><?=lang('user.userform_idCard')?> : </label>
					<?=$preData['id_card']?>
				</div>
				<div class="form-group">
					<label><?=lang('user.userform_phone')?> : </label>
					<?=$preData['phone_number']?>
				</div>
				<div class="form-group">
					<label><?=lang('user.userform_email')?> : </label>
					<?=$preData['email']?>
				</div>
				<div class="form-group">
					<label><?=lang('permission.permission_name')?></label>
					<?=$preData['permission_id']?>
				</div>

				
			</div>
		</div>
		<?=form_open(site_url('User/AddProcess')) ?>
		<button type="submit" class="btn btn-default"><?=lang('content.bt_submit')?></button>
		<button type="button" onclick='window.history.back();' class="btn btn-default"><?=lang('content.bt_back')?></button>
		<?=form_close()?>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
