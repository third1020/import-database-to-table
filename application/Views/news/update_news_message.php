<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title><?=lang('content.title')?></title>
<!-- jQuery -->
<script src="<?=base_url('assets')?>/vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?=base_url('assets')?>/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="<?=base_url('assets')?>/vendor/metisMenu/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?=base_url('assets')?>/dist/js/sb-admin-2.js"></script>
<script src="<?=base_url('assets')?>/js/custom.js"></script>
<!-- editor javascript -->
<script src="<?=base_url('assets')?>/js/froala_editor.min.js"></script>
<script src="<?=base_url('assets')?>/js/froala_editor.pkgd.min.js"></script>
<script src="<?=base_url('assets')?>/js/sb-admin-2.js"></script>

<!-- Bootstrap Core CSS -->
<link href="<?=base_url('assets')?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- MetisMenu CSS -->
<link href="<?=base_url('assets')?>/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?=base_url('assets')?>/dist/css/sb-admin-2.css" rel="stylesheet">
<!-- Morris Charts CSS -->
<link href="<?=base_url('assets')?>/vendor/morrisjs/morris.css" rel="stylesheet">
<!-- Custom Fonts -->
<link href="<?=base_url('assets')?>/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!-- Custom css -->
<link href="<?=base_url('assets')?>/manual/custom.css" rel="stylesheet" type="text/css">
<!-- editor css -->
<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.css">
<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.min.css">
<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.pkgd.min.css">
<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.pkgd.css">
<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.style.css">
<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.style.min.css">
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
<?php echo form_open_multipart('News/updateForm/'. $news->id); ?>
 				<div class="panel panel-default">
					<div class="panel-heading"><?=lang('news.news_heading_edit') ?></label>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label><?=lang('news.nesw_title')?></label> <input name="news_title" class="form-control"
										placeholder="Enter text" value="<?=isset($news->news_title) ? $news->news_title  : ''?>">
								</div>
								<div class="form-group">
									<label><?=lang('news.nesw_detail')?></label> 
									
									<textarea id="froala-editor" name="news_detail"><?=isset($news->news_detail) ? $news->news_detail  : ''?></textarea>
								</div>
								<div class="form-group">
									<label><?=lang('news.nesw_type')?></label> <select class="form-control" name="type_id">
								<?php foreach ($news_type as  $val) {  ?>
									<option value="<?=$val->id?>"><?=$val->type_name?></option>
									<?php } ?>
								</select>
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
				<input type="hidden" name="news_type_id" value="<?=isset($news->id) ? $news->id  : ''?>">
                         <?php form_close(); ?>

                         <!-- /.panel -->
			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
	</div>
<script>
$(document).ready(function() {
	 $('select[name=type_id] option[value=<?=$news->news_type?>]').attr('selected','selected');
	 $('#froala-editor').froalaEditor({
			toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',  '|', 'fontFamily',  '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent',  '-', '|',  'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'help', 'html', '|', 'undo', 'redo'],
			heightMin: 300,
		  heightMax: 300
		});
});
</script>
</body>
</html>
