<b>Hi <?=isset($name_to) ? $name_to : ''?>#<?=isset($to_id) ? $to_id : ''?></b>
<hr>
<p>
	device <b><?=isset($equipment_name) ? $equipment_name : ''?>#<?=isset($equipment_id) ? $equipment_id : ''?></b>
</p>
<label>Feedback <b style="color: red">
<?php if($status == 1) { echo "Not allow"; } else { echo "allow"; }?>
</b></label>
<hr>
<p><b>Message System</b><p>
