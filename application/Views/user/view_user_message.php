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
     <div class="row">
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
      <?php echo form_open('User/delete'); ?>
                         <div class="panel panel-default">
				<div class="panel-heading"><?=lang('user.headform_userform')?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
                  <?php foreach($user as $item){?>
     							<label><?=lang('user.userform_username')?> : </label>
     							<?php echo $item->username;?>
							</div>

							<div class="form-group">
								<label><?=lang('user.userform_name')?> : </label>
								<?php echo $item->name;?>
							</div>

							<div class="form-group">
								<label><?=lang('user.userform_idCard')?> : </label>
								<?php echo $item->id_card;?>
							</div>

							<div class="form-group">
								<label><?=lang('user.userform_phone')?> : </label>
								<?php echo $item->phone_number;?>
							</div>

							<div class="form-group">
								<label><?=lang('user.userform_email')?> : </label>
								<?php echo $item->email;?>
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
								<label><?=lang('user.permessionform_permissionName')?> :</label> <?php echo $item->permission_name;?>

							</div>
						</div>
						<!-- /.col-lg-6 (nested) -->
					</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>

         <?php }?>
         <button type="submit" onclick="window.parent.closeModaldelete();"  name="id" value="<?php echo $item->id;?>" class="btn btn-danger" &times;><?=lang('datatables.bt_delete')?></button>
         <button type="reset" onclick="window.parent.closeModaldelete();" class="btn btn-primary"><?=lang('content.bt_back')?></button>

         <?php form_close(); ?>



           <!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</body>
