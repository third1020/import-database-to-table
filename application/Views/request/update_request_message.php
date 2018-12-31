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
<!-- <froala_editor core css > -->
<link rel="stylesheet" href="<?=base_url('assets')?>/css/froala_editor.pkgd.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet"
	type="text/css" />
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
        <?php if (! empty($errors)) : ?>
            <div class="alert alert-danger">
            <?php foreach ($errors as $field => $error){?>
                    <p><?= $error ?></p>
            <?php } ?>
            </div>
    <?php endif ?>
                     	<?php echo form_open('request/UpdateProcess'); ?>
                         <div class="panel panel-default">
				<div class="panel-heading"><?=lang('request.request_edit')?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label><?=lang('request.request_tital')?></label> <input name="request_tital" class="form-control"
									placeholder="Enter text" value="<?php echo $request->request_tital;?>">
							</div>
							<div class="form-group">
								<label><?=lang('request.request_detail')?></label>
								<textarea id="froala-editor" name="request_detail" value="<?php echo $request->request_detail;?>"><?php echo $request->request_detail;?></textarea>
								<br />
							</div>
							<div class="form-group">
								<input type="hidden" name="request_status" class="form-control" value="0"> <label><?=lang('request.request_status')?> </label>
								<input type="checkbox" id="myCheck" name="request_status" onclick="myFunction()" value="1">
								<p id="text" class="alert alert-success" style="display: none"><?=lang('request.request_status')?>.1</p>
							</div>
						</div>
						<!-- /.col-lg-6 (nested) -->
					</div>
					<!-- /.row (nested) -->
				</div>
				<!-- /.panel-body -->
			</div>
			<div class="panel panel-default">
				<div class="panel-heading"><?=lang('request.equipment_form')?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label><?=lang('request.equipment_name')?></label> <select class="form-control" name="equipment_id">
    							<?php foreach ($equipment_new as  $val) {  ?>
    								<option value="<?=$val->id?>"><?=$val->equipment_name?></option>
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
			<button type="submit" name="id" value="<?php echo $request->id;?>" class="btn btn-default"><?=lang('content.bt_submit')?></button>
			<button type="reset" class="btn btn-default"><?=lang('content.bt_reset')?></button>

                         <?php form_close(); ?>

                         <!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<script src="<?=base_url('assets')?>/js/froala_editor.min.js"></script>
	<script src="<?=base_url('assets')?>/js/froala_editor.pkgd.min.js"></script>
	<script src="<?=base_url('assets')?>/js/sb-admin-2.js"></script>
	<script>
     $(function() {
       $('textarea#froala-editor').froalaEditor({
         toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',  '|', 'fontFamily',  '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent',  '-', '|',  'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'help', 'html', '|', 'undo', 'redo'],
       	heightMin: 300,
         heightMax: 300
       })
     });
   </script>
	<script>
   function myFunction() {
       var checkBox = document.getElementById("myCheck");
       var text = document.getElementById("text");
       if (checkBox.checked == true){
           text.style.display = "block";
       } else {
          text.style.display = "none";
       }
   }

   $(document).ready(function() {
  	 $('select[name=equipment_id] option[value=<?=$request->equipment_id?>]').attr('selected','selected');
  	});
   </script>
</body>
