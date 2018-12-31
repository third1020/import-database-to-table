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

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />


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
                     	<?php echo form_open('impact/UpdateProcess'); ?>
                         <div class="panel panel-default">
     		<div class="panel-heading"><?=lang('impact.impact_edit')?></div>
     			<div class="panel-body">
     				<div class="row">
     					<div class="col-lg-6">

     						<div class="form-group">
     							<label><?=lang('impact.impact_name')?></label> <input name="impact_name"
     								class="form-control" placeholder="Enter text" value="<?php echo $impact->impact_name;?>">
     						</div>

                <div>
      <h3><?=lang('impact.impact_value')?></h3>
      <label>
        <input type="checkbox" class="radio" value="1" name="impact_value" ><?=lang('impact.value_low')?></label>
      <label>
        <input type="checkbox" class="radio" value="2" name="impact_value" ><?=lang('impact.value_mediem')?></label>
      <label>
        <input type="checkbox" class="radio" value="3" name="impact_value" ><?=lang('impact.value_hight')?></label>
    </div>


     					</div>
     					<!-- /.col-lg-6 (nested) -->
     				</div>
     				<!-- /.row (nested) -->
     			</div>
     			<!-- /.panel-body -->
     		</div>



         <button type="submit"  name="id" value="<?php echo $impact->id;?>" class="btn btn-default" ><?=lang('content.bt_submit')?></button>
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
 	$("input:checkbox").on('click', function() {

   var $box = $(this);
   if ($box.is(":checked")) {

     var group = "input:checkbox[name='" + $box.attr("name") + "']";

     $(group).prop("checked", false);
     $box.prop("checked", true);
   } else {
     $box.prop("checked", false);
   }
 });
 	</script>



</body>
