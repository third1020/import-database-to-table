<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('user.profile_header')?></h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
     	<?php if(isset($validation) && $validation->getErrors()) { ?>
		<div class="alert alert-danger">
			<?php
							foreach ( $validation->getErrors () as $key => $val ) {
								printf ( "<p>" . $val . "</p>" );
							}
							?>
		</div>
		<?php } ?>
	<?php echo form_open_multipart('Profile/UpdateProcess'); ?>
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('user.profile_detail') ?></label>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('user.userform_username')?> : </label> <?php echo $user->username;?>
     						</div>
						<div class="form-group input_password">
							<div class="reset-password-div" style="display: none; margin-bottom: 10px;">
								<label><?=lang('user.userform_password')?></label> <input name="password" class="form-control"
									placeholder="Enter text" value="" disabled>
							</div>
							<div class="">
								<button type="button"
									onclick="$('.reset-password-div').show(); $('.reset-password-div input').prop('disabled', false);"><?=lang('user.bt_reset_password')?></button>
							</div>
						</div>
						<div class="form-group">
							<label><?=lang('user.userform_name')?></label> <input name="name" class="form-control" placeholder="Enter text"
								value="<?php echo $user->name;?>">
						</div>
						<div class="form-group">
									<?php if(!empty($user->img)) {  ?>
									<label><?=lang('user.userform_img')?> </label>
							<div style="margin-bottom: 10px" class="imag-box-form">
								<img width="150" src="data:image/jpg;base64,<?=$user->img?>" />
							</div>
							<div style="margin-bottom: 10px; display: none;" class="imag-input-form">
								<input type="file" name="user_img" placeholder="Enter Name" disabled>
							</div>
							<div class="imag-button-form">
								<button type="button"
									onclick="$('.imag-button-form').hide(); $('.imag-box-form').hide(); $('.imag-input-form').show(); $('.imag-input-form input').prop('disabled', false);"><?=lang('user.bt_reset_image')?></button>
							</div>
									<?php } else { ?>
									<label><?=lang('user.userform_img')?> </label> <input type="file" name="user_img" placeholder="Enter Name">
									<?php } ?>
								</div>
						<div class="form-group">
							<label><?=lang('user.userform_idCard')?></label> <input name="id_card" class="form-control"
								placeholder="Enter text" value="<?php echo $user->id_card;?>">
						</div>
						<div class="form-group">
							<label><?=lang('user.userform_phone')?></label> <input name="phone_number" class="form-control"
								placeholder="Enter text" value="<?php echo $user->phone_number;?>">
						</div>
						<div class="form-group">
							<label><?=lang('user.userform_email')?></label> <input name="email" class="form-control" placeholder="Enter text"
								value="<?php echo $user->email;?>">
						</div>
					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('user.profile_permission_detial')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group"><label><?=lang('user.permission_class')?></label> <?=$user->getPermissionName()?></div>
					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<button type="submit" onclick=""  class="btn btn-default"&times;><?=lang('content.bt_submit')?></button>
		<button type="reset" class="btn btn-default"><?=lang('content.bt_reset')?></button>
		<input type="hidden" name="user_id" value="<?=$user->id?>">
	<?php form_close(); ?>

                         <!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<script>
</script>
