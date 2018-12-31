<?php
$roles = APP_PERMISSION;
?>
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
	<div id="wrapper" style="padding: 10px;">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="page-header"><?=lang('permission.heading_update')?></h4>
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
                	<?php echo form_open('Permission/UpdateForm/'. $data['permission']->id); ?>
		<div class="panel panel-default">
					<div class="panel-heading"><?=lang('permission.panel_heading')?></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label><?=lang('permission.permission_name')?></label> <input name="permission_name" class="form-control"
										placeholder="Enter text" value="<?=isset($data['permission']) ? $data['permission']->permission_name  : ''?>">
								</div>
							</div>
							<!-- /.col-lg-6 (nested) -->
						</div>
				<?php foreach ($roles as $key=>$value) { ?>
				<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<div class="col-3">
										<label><?=lang('permission.'.$key)?></label>
									</div>
									<div class="col-6">
							<?php foreach ($value as $val) { ?>
								<label class="checkbox-inline"> <input name="permission_roles[]" type="checkbox" value="<?=$val?>"><?=lang('permission.'.$val)?>
								</label>
							<?php } ?>
							</div>
								</div>
							</div>
						</div>
				<?php } ?>
			</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<div class="col-lg-12">
				<button type="submit" class="btn btn-default"><?=lang('content.bt_submit')?></button>
				<button type="reset" class="btn btn-default"><?=lang('content.bt_reset')?></button>
			<input type="hidden" name="permission_id" value="<?=isset($data['permission']) ? $data['permission']->id  : ''?>">
                    <?php form_close();?>
      </div>
			<!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<script>
$(document).ready(function() {
    <?php if(isset($data['permissionRoles'])) { foreach ($data['permissionRoles'] as $val) { ?>
    
    $( "input[value=<?=$val->permission_key?>]" ).attr("checked", true);
    <?php } }?>
});
</script>
</body>
</html>
