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
<?php echo form_open_multipart('EquipmentType/updateForm/'. $equipmentType->id); ?>
 				<div class="panel panel-default">
					<div class="panel-heading"><?=lang('news.news_type_heading_edit') ?></label>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label><?=lang('news.nesw_type_name')?></label> <input name="type_name"
										class="form-control" placeholder="Enter text" value="<?=isset($equipmentType->type_name) ? $equipmentType->type_name  : ''?>">
								</div>
								<!-- /.col-lg-6 (nested) -->
							</div>
							<!-- /.row (nested) -->
						</div>
						<!-- /.panel-body -->
					</div>
				</div>
				<button type="submit" onclick="" value="" class="btn btn-default"&times;><?=lang('content.bt_submit')?></button>
				<button type="reset" class="btn btn-default"><?=lang('content.bt_reset')?></button>
				<input type="hidden" name="news_type_id" value="<?=isset($equipmentType->id) ? $equipmentType->id  : ''?>">
                         <?php form_close(); ?>

                         <!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
	</div>
</body>
</html>
