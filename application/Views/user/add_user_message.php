<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('user.add_user_step_1')?></h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
	<?php if($validation->getErrors()) { ?>
		<div class="alert alert-danger">
		<?php
		foreach ( $validation->getErrors () as $key => $val ) {
			printf ( "<p>" . $val . "</p>" );
		}
		?>
		</div>
		<?php } ?>
        <?php echo form_open_multipart('User/Add', ["autocomplete" => "off"]); ?>
		<div class="panel panel-default">
			<div class="panel-heading"> <?=lang('user.userform_email')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('user.userform_username')?></label> <input name="username" class="form-control"
								value="<?=isset($input['username']) ? $input['username']  : ''?>" placeholder="Enter Username" autocomplete="off">
						</div>
						<div class="form-group">
							<label><?=lang('user.userform_password')?></label> <input name="password" type="password" class="form-control"
								value="<?=isset($input['password']) ? $input['password']  : ''?>" placeholder="Enter Password">
						</div>
						<div class="form-group">
							<label><?=lang('user.userform_name')?> </label> <input name="name" class="form-control"
								value="<?=isset($input['name']) ? $input['name']  : ''?>" placeholder="Enter Name">
						</div>
						<div class="form-group">
							<label><?=lang('user.userform_idCard')?></label> <input name="id_card" class="form-control"
								value="<?=isset($input['id_card']) ? $input['id_card']  : ''?>" placeholder="Enter id card">
						</div>
						<div class="form-group">
							<label><?=lang('user.userform_phone')?></label> <input name="phone_number" class="form-control"
								value="<?=isset($input['phone_number']) ? $input['phone_number']  : ''?>" placeholder="Enter phone number">
						</div>
						<div class="form-group">
							<label><?=lang('user.userform_email')?></label> <input name="email" class="form-control"
								value="<?=isset($input['email']) ? $input['email']  : ''?>" placeholder="Enter email">
						</div>
					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('user.headform_permissionform')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('user.permessionform_permissionName')?></label>
							<div class="form-group">
								<select class="form-control" name="permission_id">
								<?php foreach ($per as  $val) {  ?>
									<option value="<?=$val->id?>"><?=$val->permission_name?></option>
									<?php } ?>
								</select>
							</div>
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
$("form :input").attr("autocomplete", "off");
</script>
<!-- /.row -->
