<link href="<?=base_url('assets')?>/vendor/datatables-plugins/dataTables.bootstrap.css"
	rel="stylesheet">


<!--check language -->

 <!-- //charts -->
 <?php if (!empty($comfirm) || !empty($cancel) || !empty($access) || !empty($workaround)) : ?>
<div id="piechart"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);


function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Hours per Day'],
  ['comfirm', <?=$comfirm?>],
  ['cancel', <?=$cancel?>],
	['access', <?=$access?>],
  ['workaround', <?=$workaround?>]



]);

  var options = {'title':'กราฟอุบัติเหตุ', 'width':550, 'height':400};

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>



<?php endif ?>

		<h3 class="page-header"><?=lang('incident.pageHeader')?></h3>

    <?php if (! empty($error)) : ?>
				<div class="alert alert-danger">

								<p><?= $error ?></p>
				</div>
<?php endif ?>


    <form action="<?php echo site_url('/Incident/Report');?>"  method="post">
    <div class="row">




    <div class='col-md-6'>

        <div class="form-group">
            <div class='input-group date' id='datetimepicker6'>
                <input type='text' name="start_time" value="<?=$start_time?>"class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <div class='col-md-6'>
        <div class="form-group">
            <div class='input-group date' id='datetimepicker7'>
                <input type='text' name="end_time" value="<?=$end_time?>" class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-success">submit</button>
</div>
</form>

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

</script>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker();
        $('#datetimepicker7').datetimepicker({
            useCurrent: false //Important! See issue #1075
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>
