<?php
?>
<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header"><?=lang('incident.header')?> </h4>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"><?=lang('incident.insert_result_topic')?></div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="alert <?=isset($status) ? $status :  'alert-success'?>">
					<p class="form-control-static"><?=$message?></p>
				</div>
				<!-- <form action="<?php echo base_url('index.php/request/Add');?>"  method="post">
					<button type="submit" class="btn btn-success">
						<i class="glyphicon glyphicon-plus"></i> <?=lang('request.bt_add_request')?>
					</button> -->
			</div>
		</div>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->