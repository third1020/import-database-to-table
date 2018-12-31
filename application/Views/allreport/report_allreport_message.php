<link href="<?=base_url('assets')?>/vendor/datatables-plugins/dataTables.bootstrap.css"
	rel="stylesheet">
	<link href="<?=base_url('assets')?>/css/allreport.css"	rel="stylesheet">




<!--check language -->

 <!-- //charts -->


		<h3 class="page-header"><?=lang('allreport.pageHeader')?></h3>

    <?php if (! empty($error)) : ?>
				<div class="alert alert-danger">

								<p><?= $error ?></p>
				</div>
<?php endif ?>


    <form action="<?php echo site_url('/AllReport/Report');?>"  method="post">
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
<?php if (!empty($incident) || !empty($problems) || !empty($incident)) : ?>
<section id="tabs" class="project-tab">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link" id="nav-report-tab" data-toggle="tab" href="#nav-report" role="tab" aria-controls="nav-report" aria-selected="true">Report</a>

                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">


													<div class="tab-pane fade active" id="nav-report" role="tabpanel" aria-labelledby="nav-profile-tab">
														<div id="piechart"></div>

														<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

														<script type="text/javascript">

														google.charts.load('current', {'packages':['corechart']});
														google.charts.setOnLoadCallback(drawChart);


														function drawChart() {
														  var data = google.visualization.arrayToDataTable([
														  ['Task', 'Hours per Day'],
															['request', <?=$request?>],
															['problems', <?=$problems?>],
														  ['incident', <?=$incident?>]




														]);

														  var options = {'title':'กราฟภาพรวมทั้งหมด', 'width':550, 'height':400};

														  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
														  chart.draw(data, options);
														}
														</script>

															<table id="customers" >
																	<thead>
																			<tr>
																					<th>AllReport</th>
																					<th style="width: 125px;">Count</th>
																			</tr>
																	</thead>
																	<tbody>
																			<tr>
																				<td class="nav-item nav-link" id="nav-request-tab" data-toggle="tab" href="#nav-request" role="tab" aria-controls="nav-request" aria-selected="flase"><a-blue href="#">Request</a-blue></td>

																					<td><?=$request?></td>

																			</tr>
																			<tr>
																					<td  id="nav-problems-tab" data-toggle="tab" href="#nav-problems"  aria-controls="nav-problems" ><a-red href="#">Problems</a-red></td>
																					<td><?=$problems?></td>

																			</tr>
																			<tr>
																					<td  id="nav-incident-tab" data-toggle="tab" href="#nav-incident" aria-controls="nav-incident" ><a-orange href="#">Incident</a-orange></td>
																					<td><?=$incident?></td>

																			</tr>
																	</tbody>
															</table>
													</div>

                            <div class="tab-pane fade active" id="nav-request" role="tabpanel" aria-labelledby="nav-request-tab">

															<div id="request"></div>

															<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

															<script type="text/javascript">

															google.charts.load('current', {'packages':['corechart']});
															google.charts.setOnLoadCallback(drawChartRequest);


															function drawChartRequest() {
																var data = google.visualization.arrayToDataTable([
																['Task', 'Hours per Day'],
																['success', <?=$success?>],
																['not_success', <?=$not_success?>]


															]);

																var options = {'title':'กราฟภาพรวมทั้งหมด', 'width':550, 'height':400};

																var chart = new google.visualization.PieChart(document.getElementById('request'));
																chart.draw(data, options);
															}
															</script>


                                <table id="customers">
                                    <thead>
                                        <tr>
                                            <th>Request</th>
                                            <th style="width: 125px;">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a-blue href="#">success</a-blue></td>
                                            <td><?=$success?></td>

                                        </tr>
                                        <tr>
                                            <td><a-red href="#">Not success</a-red></td>
                                            <td><?=$not_success?></td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade active" id="nav-problems" role="tabpanel" aria-labelledby="nav-problems-tab">

															<div id="problems"></div>

															<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

															<script type="text/javascript">

															google.charts.load('current', {'packages':['corechart']});
															google.charts.setOnLoadCallback(drawChartProblems);


															function drawChartProblems() {
																var data = google.visualization.arrayToDataTable([
																['Task', 'Hours per Day'],
																['comfirm', <?=$comfirm_problems?>],
															  ['cancel', <?=$cancel_problems?>],
																['access', <?=$access_problems?>],
															  ['workaround', <?=$workaround_problems?>]



															]);

																var options = {'title':'กราฟภาพรวมทั้งหมด', 'width':550, 'height':400};

																var chart = new google.visualization.PieChart(document.getElementById('problems'));
																chart.draw(data, options);
															}
															</script>

                                <table id="customers">
                                    <thead>
                                        <tr>
                                            <th>Problems</th>
                                            <th style="width: 125px;">Count</th>

                                        </tr>
                                    </thead>
                                    <tbody>
																			<tr>

																					<td><a-blue href="#">comfirm</a-blue></td>
																					<td><?=$comfirm_problems?></td>

																			</tr>
																			<tr>
																					<td><a-red href="#">cancel</a-red></td>
																					<td><?=$cancel_problems?></td>

																			</tr>
																			<tr>
																					<td><a-orange href="#">access</a-orange></td>
																					<td><?=$access_problems?></td>

																			</tr>
																			<tr>
																					<td><a-green href="#">workaround</a-green></td>
																					<td><?=$workaround_problems?></td>

																			</tr>
                                    </tbody>
                                </table>
                            </div>
														<div class="tab-pane fade active" id="nav-incident" role="tabpanel" aria-labelledby="nav-incident-tab">

															<div id="incident"></div>

															<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

															<script type="text/javascript">

															google.charts.load('current', {'packages':['corechart']});
															google.charts.setOnLoadCallback(drawChartIncident);


															function drawChartIncident() {
																var data = google.visualization.arrayToDataTable([
																['Task', 'Hours per Day'],
																['comfirm', <?=$comfirm_incident?>],
															  ['cancel', <?=$cancel_incident?>],
																['access', <?=$access_incident?>],
															  ['workaround', <?=$workaround_incident?>]



															]);

																var options = {'title':'กราฟภาพรวมทั้งหมด', 'width':550, 'height':400};

																var chart = new google.visualization.PieChart(document.getElementById('incident'));
																chart.draw(data, options);
															}
															</script>
																<table id="customers">
																		<thead>
																				<tr>
																						<th>Incident</th>
																						<th style="width: 125px;">Count</th>

																				</tr>
																		</thead>
																		<tbody>
																			<tr>

																					<td><a-blue href="#">comfirm</a-blue></td>
																					<td><?=$comfirm_incident?></td>

																			</tr>
																			<tr>
																					<td><a-red href="#">cancel</a-red></td>
																					<td><?=$cancel_incident?></td>

																			</tr>
																			<tr>
																					<td><a-orange href="#">access</a-orange></td>
																					<td><?=$access_incident?></td>

																			</tr>
																			<tr>
																					<td><a-green href="#">workaround</a-green></td>
																					<td><?=$workaround_incident?></td>

																			</tr>
																		</tbody>
																</table>
														</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
				<?php endif ?>







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
