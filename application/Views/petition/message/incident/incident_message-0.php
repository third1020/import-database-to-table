<b>Hi <?=isset($name_to) ? $name_to : ''?>#<?=isset($to_id) ? $to_id : ''?></b>
<hr>
<p>
	User <b><?=isset($name_from) ? $name_from: ''?>#<?=isset($from_id) ? $from_id : ''?></b> has send the request to problems
	device <b><?=isset($equipment_name) ? $equipment_name : ''?>#<?=isset($equipment_id) ? $equipment_id : ''?></b>
</p>
<p>Please follow the steps in the attached url in order to give or not to give permission.</p>
<a href="<?=isset($url_confirm) ? $url_confirm : '#'?>">link</a>
<hr>
<p><b>Message System</b><p>
