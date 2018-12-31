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
                     	<?php echo form_open_multipart('EquipmentRegister/UpdateProcess'); ?>
                         <div class="panel panel-default">
     			<div class="panel-heading"><?=lang('equipment.equipment_form') ?></label></div>
     			<div class="panel-body">
     				<div class="row">
     					<div class="col-lg-6">
     						<div class="form-group">



                  							 <div class="form-group">
                  	 						 <label><?=lang('equipment.name')?></label>
                  	 							 <input type="text" class="form-control" id="equipment_name" name="equipment_name" value="<?php echo $equipment->equipment_name;?>">
                  	 						 </div>

                  						 <div class="form-group">
                  						 <label><?=lang('equipment.detail')?></label></br>
                  	 					<textarea id="froala-editor" name="detail" value="<?php echo $equipment->detail;?>" ><?php echo $equipment->detail;?></textarea>
                  	 				 </div>

                  					 <div class="form-group">
                  					 <label><?=lang('equipment.department')?></label></br>
                  					 <input type="text" class="form-control" name="department" value="<?php echo $equipment->department;?>">
                  				 </div>

                  				 <div class="form-group">
                  				 <label><?=lang('equipment.username')?></label></br>
                  				 <input type="text" class="form-control" name="username" value="<?php echo $equipment->username;?>">
                  			   </div>

                  				 <div class="form-group">
                  				 <label><?=lang('equipment.history')?></label></br>
                  				 <input type="text" class="form-control" name="history" value="<?php echo $equipment->history;?>">
                  			   </div>

                  					 <div class="form-group">
                  						 <label><?=lang('equipment.equipment_register_type')?></label>
                  						 <select class="form-control" name="equipment_type">
                  							 <?php foreach ($equipment_type as  $val) {  ?>
                  								 <option value="<?=$val->type_name?>"><?=$val->type_name?></option>
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



     		<button type="submit" name="id" value="<?php echo $equipment->id;?>" class="btn btn-default" &times;><?=lang('datatables.bt_submit')?></button>
     		<button type="reset" class="btn btn-default"><?=lang('datatables.bt_back')?></button>
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
     $('#froala-editor').froalaEditor({
     	toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough',  '|', 'fontFamily',  '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent',  '-', '|',  'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', '|', 'help', 'html', '|', 'undo', 'redo'],
     	heightMin: 300,
       heightMax: 300
     });
     </script>
</body>
