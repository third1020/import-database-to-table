<link href="<?=base_url('assets')?>/vendor/datatables-plugins/dataTables.bootstrap.css"
	rel="stylesheet">
<form action="<?php echo base_url();?>index.php/request/delete" method="post"></form>
<form action="<?php echo base_url();?>index.php/request/update" method="post"></form>

<!--check language -->





<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><?=lang('request.pageHeader')?></h3>
		<!-- 		<div class=""> -->
		<div class="panel-body">


			<div class="panel panel-default">
				<div class="panel-heading"><?=lang('request.pageHeaderTable') ?></div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover"
						id="dataTables-example">
						<thead>
							<tr>
								<th><?=lang('request.id')?></th>
								<th><?=lang('request.request_tital')?></th>
								<th><?=lang('request.request_status')?></th>




								<th style="width: 125px;"><?=lang('content.action')?></th>
							</tr>
						</thead>
					</table>
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">
					edit data <label id="idKey"></label>
				</h4>
				<p></p>
			</div>
			<div class="modal-body">
				<iframe src="" id="info" class="iframe" name="info" height="100%" width="100%"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-inside" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- /#updateModal -->

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">
					View data <label id="idKey"></label>
				</h4>
				<p></p>
			</div>
			<div class="modal-body">
				<iframe src="" id="info" class="iframe" name="info" height="100%" width="100%"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-inside" class="btn btn-default" data-dismiss="modal">Delete</button>
				<button type="button" id="btn-inside" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- /#deleteModal -->
<!-- /.row -->
<script src="<?=base_url('assets')?>/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets')?>/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url('assets')?>/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script>

$(document).ready(function() {
	var btnUpdate = '<button class="btn btn-warning" value="update"><i class="glyphicon glyphicon-pencil"></i></button>';
	var btnDelete = '<button class="btn btn-danger" value="delete"><i class="glyphicon glyphicon-remove"></i></button>';
	var table = $('#dataTables-example').DataTable( {
		"bProcessing": true,
		"bServerSide": true ,
	    "paging": true,
	    "searching": { "regex": false },
	    "bSort":false,
	    "ajax": {
	    	      url: "<?=site_url('request/dataProcessing')?>",
            	type: "POST",
            	pages: 5,
							ajax: "data.json"
		    },
	    "columns": [
	        {  name: "id",data: "id" },
	        {  name: "request_tital",data: "request_tital" },
	        {  name: "request_status",data: "request_status" },
	     


	        {
	            className:      'details-control',
	            orderable:      false,
	            data:           null,
	            defaultContent: btnUpdate + " " + btnDelete
	        }
	    ],
        "complete": function(response) {
            console.log(response);
       },

	});
 // setInterval( function () {
 //     table.ajax.reload(null,false);
 // }, 1000 );

	$('#dataTables-example tbody').on( 'click', 'button', function () {
	   	var $tr = $(this).closest('tr');
	    var rowData = $('#dataTables-example').DataTable().row($tr).data();

        if($(this).val() == 'update')  {
        		$('#updateModal #myModalLabel').text ("Update From #"+rowData['id']);


        		var frameSrc = "<?php echo base_url('index.php/request/updateForm/');?>"+rowData['id'];
        			$('iframe').attr("src",frameSrc);

        			$('#updateModal').modal({show:true})

        }

// 		console.log($(this).val());
	    // console.log(rowData['id']);
	} );

	$('#dataTables-example tbody').on( 'click', 'button', function () {
	var $tr = $(this).closest('tr');
	var rowData = $('#dataTables-example').DataTable().row($tr).data();
	if($(this).val() == 'delete')  {
		var frameSrc = "<?php echo base_url('index.php/request/deleteForm/');?>"+rowData['id'];
		$('#deleteModal #myModalLabel').text ("View From #"+rowData['id']);

			var frameSrc =  "<?php echo base_url('index.php/request/deleteForm/');?>"+rowData['id'];
				$('iframe').attr("src",frameSrc);

				$('#deleteModal').modal({show:true})

	}


});

	$('#updateModal').on('hidden.bs.modal', function () {
	    table.ajax.reload(null,false);
    });

	$('#deleteModal').on('hidden.bs.modal', function () {
	    table.ajax.reload(null,false);
	 });




	window.closeModalupdate = function(){
	    $('#updateModal').modal('hide');
	};

	window.closeModaldelete = function(){
			$('#deleteModal').modal('hide');
	};

});
</script>
