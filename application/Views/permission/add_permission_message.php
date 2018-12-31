<?php
$roles = APP_PERMISSION;
?>
<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('permission.heading')?> Step 1/3</h4>
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
                	<?php echo form_open('Permission/add'); ?>
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('permission.panel_heading')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('permission.permission_name')?></label> <input name="permission_name" class="form-control"
								placeholder="Enter text" value="<?=isset($input['permission_name']) ? $input['permission_name']  : ''?>">
						</div>
					</div>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<?php foreach ($roles as $keys=>$value) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="form-group">
							<div class="col-3">
								<label><?php 
								try {
									echo lang("permission.$keys");
								} catch (\Exception $e) {
									echo $e;
									}?></label>
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
	<button type="submit" class="btn btn-default"><?=lang('content.bt_submit')?></button>
	<button type="reset" class="btn btn-default"><?=lang('content.bt_reset')?></button>
                    <?php form_close();?>
                    <!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<script>
$(document).ready(function() {
    <?php if(isset($input['permission_roles'])) { foreach ($input['permission_roles'] as $val) { ?>
    $( "input[value=<?=$val?>]" ).attr("checked", true);
    <?php } }?>
});
</script>
