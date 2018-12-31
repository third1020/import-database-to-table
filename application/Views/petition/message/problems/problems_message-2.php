<b>Hi <?=isset($name_to) ? $name_to : ''?>#<?=isset($to_id) ? $to_id : ''?></b>
<hr>
<p>
	device <b><?=isset($equipment_name) ? $equipment_name : ''?>#<?=isset($equipment_id) ? $equipment_id : ''?></b>
</p>
<label>Feedback <b style="color: red">
Accept
</b></label>
<p>Please follow the steps in the attached url.</p>
<a href="<?=isset($url_confirm) ? $url_confirm : '#'?>">link</a>
<hr>
<p><b>Message System</b><p>
