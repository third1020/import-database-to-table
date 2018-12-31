problems<?php
?>
<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('problems.preview_header')?></h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('problems.preview')?></div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<?=form_open(site_url('Problems/AddProcessPreview')) ?>

				<div class="form-group">
					<label><?=lang('problems.problems_tital')?> : </label>
					<?php echo $confirm['problems_tital'];?>
					<input type="hidden" name="problems_tital" value="<?php echo $confirm['problems_tital'];?>"></input>
				</div>

				<div class="form-group">
					<label><?=lang('problems.problems_detail')?> : </label>
					<?php echo $confirm['problems_detail'];?>
					<input type="hidden" name="problems_detail" value="<?php echo $confirm['problems_detail'];?>"></input>
				</div>


				<div class="form-group">
					<label><?=lang('problems.problems_status')?> : </label>
					<?php echo $confirm['problems_status'];?>
					<input type="hidden" name="problems_status" value="<?php echo $confirm['problems_status'];?>"></input>
				</div>


				<div class="form-group">
					<label><?=lang('problems.equipment_id')?> : </label>
					<?php echo $confirm['equipment_id'];?></br>
					<label><?=lang('problems.contact_id')?> : </label>
					<?php echo $confirm['contact_id'];?></br>
					<label><?=lang('problems.impact_id')?> : </label>
					<?php echo $confirm['impact_id'];?></br>
					<label><?=lang('problems.priority_id')?> : </label>
					<?php echo $confirm['priority_id'];?>

          <input type="hidden" name="equipment_id" value="<?php echo $confirm['equipment_id'];?>"></input>
					<input type="hidden" name="contact_id" value="<?php echo $confirm['contact_id'];?>"></input>
					<input type="hidden" name="impact_id" value="<?php echo $confirm['impact_id'];?>"></input>
					<input type="hidden" name="priority_id" value="<?php echo $confirm['priority_id'];?>"></input>



				</div>




			</div>
		</div>

		<button type="submit"  class="btn btn-default"><?=lang('content.bt_submit')?></button>
		<button type="button" onclick="window.history.back();"  class="btn btn-default"><?=lang('content.bt_back')?></button>
		<?=form_close()?>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
