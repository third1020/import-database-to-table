<?php
use App\Controllers\Home;

$userRoles = APP_PERMISSION_USER;
$newsRoles = APP_PERMISSION_NEWS;
$messageRoles = APP_PERMISSION_MESSAGE;
$requestRoles = APP_PERMISSION_REQUEST;
$problemsRoles = APP_PERMISSION_PROBLEMS;
$incidentRoles = APP_PERMISSION_INCIDENT;
$equipmentRoles = APP_PERMISSION_EQUIPMENT;
$permissionRoles = APP_PERMISSION_MANAGER;
$reportRoles = APP_PERMISSION_REPORT;
$petition = APP_PERMISSION_PETITION;

function checkRolesMainMenu($listUseRoles) {
	$session = session ();

	foreach ( $listUseRoles as $use ) {
		if (in_array ( $use, $session->get ( 'permissionRoles' ) ))
			return true;
	}
	return false;
}
function checkRolesSubMenu($strUseRoles) {
	$session = session ();
	if (in_array ( $strUseRoles, $session->get ( 'permissionRoles' ) ))
		return true;
}

?>
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span
				class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?=site_url('home')?>">IT Servicedesk priminister 2018</a>
	</div>
	<!-- /.navbar-header -->
	<ul class="nav navbar-top-links navbar-right">
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-envelope fa-fw"></i>
				<i class="fa fa-caret-down"></i>
		</a>
			<ul id="message-main" class="dropdown-menu dropdown-messages">

			</ul> <!-- /.dropdown-messages --></li>
		<!-- /.dropdown -->
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-tasks fa-fw"></i> <i
				class="fa fa-caret-down"></i>
		</a>
			<ul class="dropdown-menu dropdown-tasks">
				<li><a href="#">
						<div>
							<p>
								<strong><?=lang('content.service_request_nav')?></strong> <span class="pull-right text-muted">40% Complete</span>
							</p>
							<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0"
									aria-valuemax="100" style="width: 40%">
									<span class="sr-only">40% Complete (success)</span>
								</div>
							</div>
						</div>
				</a></li>
				<li class="divider"></li>
				<li><a href="#">
						<div>
							<p>
								<strong><?=lang('content.problems_request_nav')?></strong> <span class="pull-right text-muted">20% Complete</span>
							</p>
							<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0"
									aria-valuemax="100" style="width: 20%">
									<span class="sr-only">20% Complete</span>
								</div>
							</div>
						</div>
				</a></li>
				<li class="divider"></li>
				<li><a href="#">
						<div>
							<p>
								<strong><?=lang('content.incdent_request_nav')?></strong> <span class="pull-right text-muted">60% Complete</span>
							</p>
							<div class="progress progress-striped active">
								<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0"
									aria-valuemax="100" style="width: 60%">
									<span class="sr-only">60% Complete (warning)</span>
								</div>
							</div>
						</div>
				</a></li>
				<li class="divider"></li>
				<li><a class="text-center" href="#"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i>
				</a></li>
			</ul> <!-- /.dropdown-tasks --></li>
		<!-- /.dropdown -->
		<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-user fa-fw"></i> <i
				class="fa fa-caret-down"></i>
		</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="<?=site_url('Profile')?>"><i class="fa fa-user fa-fw"></i> <?=lang('content.user_profile')?></a></li>
				<li class="divider"></li>
				<li><a href="<?=site_url('login/logout')?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
			</ul> <!-- /.dropdown-user --></li>
		<!-- /.dropdown -->
	</ul>
	<!-- /.navbar-top-links -->
	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
				<li class="sidebar-search">
					<div class="input-group custom-search-form">
						<input type="text" class="form-control" placeholder="Search..."> <span class="input-group-btn">
							<button class="btn btn-default" type="button">
								<i class="fa fa-search"></i>
							</button>
						</span>
					</div> <!-- /input-group -->
				</li>
				<li><a href="<?=site_url('Home')?>"><i class="fa fa-home fa-fw"></i><?=lang('menu.Home'); ?></a></li>
				<?php if(checkRolesMainMenu($userRoles))  { ?>
				<li><a href="<?=site_url('User')?>"><i class="fa fa-user fa-fw"></i><?=lang('menu.user_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<?php if(checkRolesSubMenu($userRoles[0])) { ?><li><a href="<?=site_url('User/list')?>"><?=lang('menu.data_list'); ?></a></li><?php } ?>
						<?php if(checkRolesSubMenu($userRoles[1])) { ?><li><a href="<?=site_url('User/Add')?>"><?=lang('menu.add_user'); ?></a></li><?php } ?>
						<?php if(checkRolesMainMenu($permissionRoles))  { ?>
						<li><a href="<?=site_url('Permission')?>"><?=lang('menu.permission'); ?><span class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
								<li><a href="<?=site_url('Permission/Add')?>"><?=lang('menu.add_permission'); ?></a></li>
								<li><a href="<?=site_url('Permission/List')?>"><?=lang('menu.change_permission'); ?></a></li>
							</ul> <!-- /.nav-third-level -->
						</li>
						<?php } ?>
					</ul> <!-- /.nav-second-level -->
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($newsRoles))  { ?>
				<li><a href="<?=site_url('News')?>"><i class="fa fa-bullhorn fa-fw"></i><?=lang('menu.news_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('News/list')?>"><?=lang('menu.news_list'); ?></a></li>
						<li><a href="<?=site_url('News/Add')?>"><?=lang('menu.news_add'); ?></a></li>
						<li><a href="<?=site_url('NewsType')?>"><?=lang('menu.news_type'); ?><span class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
								<li><a href="<?=site_url('NewsType/List')?>"><?=lang('menu.news_type_list'); ?></a></li>
								<li><a href="<?=site_url('NewsType/Add')?>"><?=lang('menu.news_type_type_add'); ?></a></li>
							</ul> <!-- /.nav-third-level --></li>
					</ul> <!-- /.nav-second-level -->
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($messageRoles))  { ?>
				<li><a href="<?=site_url('Message')?>"><i class="fa fa-envelope-o fa-fw"></i><?=lang('message.message_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Message/list')?>"><?=lang('message.message_list'); ?></a></li>
						<li><a href="<?=site_url('Message/Add')?>"><?=lang('message.message_add'); ?></a></li>
					</ul>
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($equipmentRoles))  { ?>
				<li><a href="<?=site_url('Equipment')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.equipment_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Equipment/list')?>"><?=lang('menu.data_list'); ?></a></li>
						<li><a href="<?=site_url('Equipment/Add')?>"><?=lang('menu.add_equipment'); ?></a></li>
						<li><a href="<?=site_url('EquipmentRegister/list')?>"><?=lang('menu.list_register_equipment'); ?></a></li>
						<li><a href="<?=site_url('EquipmentRegister/Add')?>"><?=lang('menu.add_register_equipment'); ?></a></li>
						<li><a href="<?=site_url('EquipmentType')?>"><?=lang('menu.equipment_type'); ?><span class="fa arrow"></span></a>
							<ul class="nav nav-third-level">
								<li><a href="<?=site_url('EquipmentType/List')?>"><?=lang('menu.equipment_type_list'); ?></a></li>
								<li><a href="<?=site_url('EquipmentType/Add')?>"><?=lang('menu.equipment_type_type_add'); ?></a></li>
							</ul> <!-- /.nav-third-level --></li>
					</ul>
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($requestRoles))  { ?>
				<li><a href="<?=site_url('Request')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.request_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Request/list')?>"><?=lang('menu.data_list'); ?></a></li>
						<li><a href="<?=site_url('Request/Add')?>"><?=lang('menu.add_request'); ?></a></li>
					</ul> <!-- /.nav-second-level -->
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($problemsRoles))  { ?>
				<li><a href="<?=site_url('Problems')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.problems_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Problems/list')?>"><?=lang('menu.data_list'); ?></a></li>
						<li><a href="<?=site_url('Problems/Add')?>"><?=lang('menu.add_problems'); ?></a></li>
					</ul>
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($incidentRoles))  { ?>
				<li><a href="<?=site_url('Incident')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.incident_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Incident/list')?>"><?=lang('menu.data_list'); ?></a></li>
						<li><a href="<?=site_url('Incident/Add')?>"><?=lang('menu.add_incident'); ?></a></li>
					</ul> <!-- /.nav-second-level -->
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($incidentRoles)
						|| checkRolesMainMenu($problemsRoles))  { ?>
				<li><a href="<?=site_url('Contact')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.contact_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Contact/list')?>"><?=lang('menu.data_list'); ?></a></li>
						<li><a href="<?=site_url('Contact/Add')?>"><?=lang('menu.add_contact'); ?></a></li>
					</ul>
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($incidentRoles)
						|| checkRolesMainMenu($problemsRoles))  { ?>
				<li><a href="<?=site_url('Impact')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.impact_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Impact/list')?>"><?=lang('menu.data_list'); ?></a></li>
						<li><a href="<?=site_url('Impact/Add')?>"><?=lang('menu.add_impact'); ?></a></li>
					</ul>
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($incidentRoles)
						|| checkRolesMainMenu($problemsRoles))  { ?>
				<li><a href="<?=site_url('Priority')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.priority_manager'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Priority/list')?>"><?=lang('menu.data_list'); ?></a></li>
						<li><a href="<?=site_url('Priority/Add')?>"><?=lang('menu.add_priority'); ?></a></li>
					</ul>
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($incidentRoles)
						|| checkRolesMainMenu($problemsRoles))  { ?>
				<li><a href="<?=site_url('Workaround')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.workaround'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Workaround/List')?>"><?=lang('menu.workaround_list'); ?></a></li>
					</ul>
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($reportRoles))  { ?>
				<li><a href="<?=site_url('Report')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.report'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Request/Report')?>"><?=lang('menu.report_request'); ?></a></li>
						<li><a href="<?=site_url('Problems/Report')?>"><?=lang('menu.report_problems'); ?></a></li>
						<li><a href="<?=site_url('Incident/Report')?>"><?=lang('menu.report_incident'); ?></a></li>
						<li><a href="<?=site_url('AllReport/Report')?>"><?=lang('menu.allreport'); ?></a></li>
						<li><a href="<?=site_url('ReportWorkAround/Report')?>"><?=lang('menu.report_work'); ?></a></li>
					</ul>
				</li>
				<?php } ?>

				<?php if(checkRolesMainMenu($petition))  { ?>
				<li><a href="<?=site_url('Petition')?>"><i class="fa fa-table fa-fw"></i><?=lang('menu.petition'); ?><span
						class="fa arrow"></span></a>
					<ul class="nav nav-second-level">
						<li><a href="<?=site_url('Petition/Request')?>"><?=lang('menu.petition_request'); ?></a></li>
						<li><a href="<?=site_url('Petition/Problems')?>"><?=lang('menu.petition_problems'); ?></a></li>
						<li><a href="<?=site_url('Petition/Incident')?>"><?=lang('menu.petition_incident'); ?></a></li>

					</ul>
				</li>
				<?php } ?>
			</ul>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
	<!-- /.navbar-static-side -->
</nav>

<script>
var message = $("#message-sub");
var message_main = $("#message-main");

message_main.html(message.html() + message.html() + message.html());
console.log(message.html());

$.ajax({
	  url: "<?=site_url('Message/nav_menu')?>",
	}).done(function(data) {
		message_main.html(data)
	});
</script>
