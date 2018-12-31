<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('request.header_request')?></h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<?php echo form_open("Petition/Request_confirm/$request->id"); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<label><?=$request->request_tital?></label>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Detail</label> 
						<?=$request->request_detail?>
					</div>
					
					<?php if($request->request_status != 0) { ?>
					<div class="form-group">
						<label style="color: red">The item has been updated.</label>
					</div>
					<?php } else { ?>
					<div class="form-group">
						<label>Status</label> <select name="request_status" class="form-control">
							<option value="1">not allow</option>
							<option value="2">allow</option>
						</select>
					</div>
					<?php } ?>
					<!-- /.col-lg-6 (nested) -->
				</div>
				<!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
	</div>
	<button type="submit" class="btn btn-default"><?=lang('datatables.bt_submit')?></button>
	<button type="reset" class="btn btn-default"><?=lang('datatables.bt_reset')?></button>
                    <?php form_close();?>
                    <!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
