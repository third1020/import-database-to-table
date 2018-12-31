<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!-- jQuery -->
<script src="<?=base_url('assets')?>/vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?=base_url('assets')?>/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="<?=base_url('assets')?>/js/custom.js"></script>
<title>SB Admin 2 - Bootstrap Admin Theme</title>
<!-- Bootstrap Core CSS -->
<link href="<?=base_url('assets')?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- MetisMenu CSS -->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div id="wrapper">
		<div class="row">
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
                     	<?php echo form_open_multipart('User/UpdateProcess'); ?>
                         <div class="panel panel-default">
					<div class="panel-heading"><?=lang('user.Edit_User') ?></label>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
                  <?php foreach($user as $item){?>
     							<label><?=lang('user.userform_username')?> : </label> <?php echo $item->username;?>
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
										value="<?php echo $item->name;?>">
								</div>
								<div class="form-group">
									<?php if(!empty($item->img)) {  ?>
									<label><?=lang('user.userform_img')?> </label> 
									<div style="margin-bottom: 10px" class="imag-box-form">
										<img width="150" src="data:image/jpg;base64,<?=$item->img?>" />
									</div>
									<div style="margin-bottom: 10px; display:none;" class="imag-input-form">
										<input type="file" name="user_img" placeholder="Enter Name" disabled>
									</div>
									<div class="imag-button-form">
										<button type="button" onclick="$('.imag-button-form').hide(); $('.imag-box-form').hide(); $('.imag-input-form').show(); $('.imag-input-form input').prop('disabled', false);"><?=lang('user.bt_reset_image')?></button>
									</div>
									<?php } else { ?>
									<label><?=lang('user.userform_img')?> </label> <input type="file" name="user_img" placeholder="Enter Name">
									<?php } ?>
								</div>
								<div class="form-group">
									<label><?=lang('user.userform_idCard')?></label> <input name="id_card" class="form-control"
										placeholder="Enter text" value="<?php echo $item->id_card;?>">
								</div>
								<div class="form-group">
									<label><?=lang('user.userform_phone')?></label> <input name="phone_number" class="form-control"
										placeholder="Enter text" value="<?php echo $item->phone_number;?>">
								</div>
								<div class="form-group">
									<label><?=lang('user.userform_email')?></label> <input name="email" class="form-control"
										placeholder="Enter text" value="<?php echo $item->email;?>">
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
									<select class="form-control" name="permission_id">
										<option value=""><?=lang('content.choose')?></option>
                  <?php foreach ($per as  $val) {  ?>
                    <option value="<?=$val->id?>"><?=$val->permission_name?></option>
                    <?php } ?>
                  </select>
								</div>
							</div>
							<!-- /.col-lg-6 (nested) -->
						</div>
						<!-- /.row (nested) -->
					</div>
					<!-- /.panel-body -->
				</div>
         <?php }?>
     		  <button type="submit" onclick="" name="id" value="<?php echo $item->id;?>" class="btn btn-default"&times;><?=lang('content.bt_submit')?></button>
				<button type="reset" class="btn btn-default"><?=lang('content.bt_reset')?></button>
				<input type="hidden" name="user_id" value="<?=$item->id?>">
                         <?php form_close(); ?>

                         <!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
	</div>
	<script>
     $(document).ready(function() {
    	 $('select[name=permission_id] option[value=<?=$item->permission_id?>]').attr('selected','selected');
    	});
     </script>
</body>
</html>
