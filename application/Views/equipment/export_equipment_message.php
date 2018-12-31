<head>
	<link href="<?=base_url('assets')?>/css/tableexport.css" rel="stylesheet">
	<link href="<?=base_url('assets')?>/vendor/datatables-plugins/dataTables.bootstrap.css"
		rel="stylesheet">

    <link href="<?=base_url('assets')?>/css/tableexport.min.css" rel="stylesheet">

</head>
<body>
	<div class="container-fluid">
	    <h1><?=lang('equipment.pageHeader') ?></h1>

	    <div class="table-responsive">
	        <table id="bootstrap-table" class="table table-bordered">
	            <thead>
	            <tr>
                  <td><?=lang('equipment.id') ?></td>
	                <td><?=lang('equipment.equipment_name') ?></td>
	                <td><?=lang('equipment.equipment_detail') ?></td>
	                <td><?=lang('equipment.created_by') ?></td>


	            </tr>
	            </thead>
							<?php foreach($equipment as $item){?>
	            <tbody>
							<tr>
								  <td><?php echo $item->id ?></td>
	                <td><?php echo $item->equipment_name ?></td>
	                <td><?php echo $item->equipment_detail ?></td>
	                <td><?php echo $item->created_by ?></td>

	            </tr>
	            </tbody>
						<?php }?>
	            <!-- <tfoot>
	            <tr>
								  <td class="disabled"></td>
	                <td class="disabled"></td>
	                <td class="disabled"></td>
									<td class="disabled"></td>
	            </tr>
	            </tfoot> -->
	        </table>
	    </div>
	</div>

</body>



<script type="text/javascript" src="<?=base_url('assets')?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets')?>/js/xlsx.full.min.js"></script>
<script type="text/javascript" src="<?=base_url('assets')?>/js/FileSaver.js"></script>
<script type="text/javascript" src="<?=base_url('assets')?>/js/tableexport.min.js"></script>
<script>
$("table").tableExport({
	bootstrap: true
});
</script>
