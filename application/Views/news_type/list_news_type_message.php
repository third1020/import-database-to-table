
<link href="<?=base_url('assets')?>/vendor/datatables-plugins/dataTables.bootstrap.css"
	rel="stylesheet">
<form action="<?php echo base_url();?>index.php/User/delete" method="post"></form>
<form action="<?php echo base_url();?>index.php/User/update" method="post"></form>

<!--check language -->
<?php $url =  "{$_SERVER['REQUEST_URI']}";
if($url == '/service/public/index.php/en/User/list'){$language="en";}
else{$language="th";}

?>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><?=lang('news.pageHeader_news_type_list')?></h3>
		<!-- 		<div class=""> -->
		<div class="panel-body">
			<div class="panel panel-default">
				<div class="panel-heading"><?=lang('news.pageHeaderTable_list') ?></div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover"
						id="dataTables-example">
						<thead>
							<tr>
								<th style="width: 75px;"><?=lang('news.field_news_type_id')?></th>
								<th><?=lang('news.field_news_type_name')?></th>
								<th style="width: 125px;"><?=lang('news.field_news_action')?></th>
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
<!-- /.row -->
<script src="<?=base_url('assets')?>/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets')?>/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="<?=base_url('assets')?>/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script>

$(document).ready(function() {
	var btnUpdate = '<button class="btn btn-warning" value="update"><i class="glyphicon glyphicon-pencil"></i></button>';
	var table = $('#dataTables-example').DataTable( {
		"bProcessing": true,
		"bServerSide": true ,
	    "paging": true,
	    "searching": { "regex": false },
	    "bSort":false,
	    "ajax": {
	    	      url: "<?=site_url('NewsType/ListProcessing')?>",
            	type: "POST",
            	pages: 5,
							ajax: "data.json"
		    },
	    "columns": [
	        {  name: "id",data: "id" },
	        {  name: "type_name",data: "type_name" },
	        {
	            className:      'details-control',
	            orderable:      false,
	            data:           null,
	            defaultContent: btnUpdate
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
        		$('#updateModal #myModalLabel').text ("<?=lang('news.news_type_main_heading_edit')?>"+rowData['id']);


        		var frameSrc = "<?php echo base_url('index.php/');?>/NewsType/updateForm/"+rowData['id'];
        			$('iframe').attr("src",frameSrc);

        			$('#updateModal').modal({show:true})

        }

// 		console.log($(this).val());
	    // console.log(rowData['id']);
	} );

	$('#updateModal').on('hidden.bs.modal', function () {
	    table.ajax.reload(null,false);
    });

	window.closeModal = function(){
	    $('#updateModal').modal('hide');
	};
});
</script>
