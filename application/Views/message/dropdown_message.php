<?php
foreach ($message as $mes) {
?>
<li><a href="<?=site_url("Message/viewDetail/$mes->id")?>">
		<div>
			<strong><?=$mes->getMessage_from()?></strong> 
			<span class="pull-right text-muted"> <em><?=$mes->getCreated_at()?></em>
			</span>
		</div>
		<div><?=substr($mes->getMessage_title(),0,255)?></div>
</a></li>
<li class="divider"></li>
<?php  } ?>
<li><a class="text-center" href="<?=site_url("Home/ListMessage")?>"> <strong>Read All Messages</strong> <i class="fa fa-angle-right"></i></a></li>