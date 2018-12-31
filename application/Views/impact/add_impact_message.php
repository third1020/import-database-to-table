
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?=lang('impact.bt_add_impact')?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<?php if (! empty($success)) : ?>
        <div class="alert alert-success">
			<label><?=lang('datatables.success')?> </label>
		</div>
<?php endif ?>

		<?php if (! empty($errors)) : ?>
        <div class="alert alert-danger">
        <?php foreach ($errors as $field => $error){?>
                <p><?= $error ?></p>
        <?php } ?>
        </div>
<?php endif ?>
                	<?php echo form_open('impact/Add'); ?>
                    <div class="panel panel-default">
			<div class="panel-heading"> <?=lang('impact.impact_form')?></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label><?=lang('impact.impact_name')?></label> <input name="impact_name" class="form-control"
								placeholder="impact_name"></br>
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

			<button type="submit" class="btn btn-default"><?=lang('datatables.bt_submit')?></button>
			<button type="reset" class="btn btn-default"><?=lang('datatables.bt_reset')?></button>
                    <?php form_close();?>
                    <!-- /.panel -->
		</div>
		<!-- /.col-lg-12 -->
	</div>


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
