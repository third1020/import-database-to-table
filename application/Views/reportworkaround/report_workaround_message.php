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


    <form action="<?php echo site_url('/ReportWorkAround/Report');?>"  method="post">
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
<?php if (! empty($time)){ ?>
<table id="customers">
  <tr>
    <th>ลำดับ</th>
    <th>วันที่แจ้ง</th>
    <th>ชื่ออุปกรณ์</th>
    <th>ปัญหาที่แจ้ง</th>
    <th>ผู้รับเรื่อง</th>
    <th>ผู้ดำเนินการซ่อม</th>
    <th>สถานะการซ่อม</th>


  </tr>

  <?php for ($x = 0; $x <= count($temp_join); $x++) { ?>

    <?php if(empty($time[$x])){
      continue;
    }?>

  <tr>
    <td><?=$time[$x]->id?></td>
    <td><?=$time[$x]->created_at?></td>
    <td><?=$time[$x]->equipment_name?></td>
    <td><?=$time[$x]->problems_tital?></td>
    <td><?=$time[$x]->contact_name?></td>
    <td><?=$time[$x]->contact_name?></td>
<?php if ($time[$x]->problems_status== 1){ ?>
						<td>comfirm</td>
<?php }else ?>
<?php if ($time[$x]->problems_status == 2){ ?>
            <td>cancel</td>
<?php }else ?>
<?php if ($time[$x]->problems_status == 3){ ?>
            <td>access</td>
<?php }else?>
<?php if ($time[$x]->problems_status == 4){ ?>
            <td>workaround</td>
<?php } ?>

  </tr>
  <?php } ?>


</table>
<?php } ?>


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
