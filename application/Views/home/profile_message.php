<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><img src="<?=base_url('100.png')?>" alt="" width="150" height="150">
			<img src="<?=base_url('010.jpg')?>" alt="" width="222" height="222">
			<img src="<?=base_url('001.png')?>" alt="" width="150" height="150"></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="col-md-12 ">
			<div class="panel panel-default">
				<div class="panel-heading"><?=lang('content.tab-message')?></div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<!-- Nav tabs -->
					<ul class="nav nav-pills">
						<li class="active"><a href="#home-pills" data-toggle="tab">Home</a></li>
						<li><a href="#profile-pills" data-toggle="tab">Profile</a></li>
						<li><a href="#messages-pills" data-toggle="tab">Messages</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane fade in active" id="home-pills">
							<h4>Home Tab</h4>
							<p><?=lang('content.welcomeMessage')?></p>
						</div>
						<div class="tab-pane fade" id="profile-pills">
							<h4>Profile Tab</h4>
							<div class="col-md-12" style="margin: 0; padding: 0">
								<table class="table-profile">
									<tbody>
										<tr>
											<td rowspan="6">
											<?php if(isset($user->img)) { ?>
												<img class="img-profile" alt="profile-img" src="data:image/jpg;base64,<?=$user->img?>">
											<?php } else { ?>
												<img class="img-profile" alt="profile-img" src="<?=base_url('assets/img/No_Image_Available.png')?>">
											<?php } ?>
											</td>
											<td></td>
											<td></td>
										</tr>
										<tr>
											<td><?=lang('content.user-username')?></td>
											<td><?=isset($user->username) ?  $user->username : ''?></td>
										</tr>
										<tr>
											<td><?=lang('content.user-fname')?></td>
											<td><?=isset($user->name) ? $user->name: ''?></td>
										</tr>
										<tr>
											<td><?=lang('content.user-email')?></td>
											<td><?=isset($user->email) ? $user->email: ''?></td>
										</tr>
										<tr>
											<td><?=lang('content.user-idcard')?></td>
											<td><?=isset($user->id_card) ? $user->id_card : ''?></td>
										</tr>
										<tr>
											<td><?=lang('content.user-permission')?></td>
											<td><?=isset($user->permission_id) ? $user->getPermissionName() : ''?></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-11"></div>
						</div>
						<div class="tab-pane fade" id="messages-pills">
							<h4>Messages Tab</h4>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore
								magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
								consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
								pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
								laborum.</p>
						</div>
					</div>
				</div>
				<!-- /.panel-body -->
			</div>
		</div>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?=lang('home.news')?></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<?php
		foreach ($newsType as $type) {
		?>
		<div class="col-lg-6">
			<div class="panel panel-default" style="min-height: 380px">
				<div class="panel-heading"><?=$type->type_name?></div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th style="width:60%"><?=lang('home.news_title')?></th>
									<th><?=lang('home.news_created_by')?></th>
									<th><?=lang('home.news_updated_at')?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($type->getNews() as $val) { ?>
								<tr>
									<td><?=$val->id?></td>
									<td><a href="<?=site_url("News/Detail/$val->id")?>"><?=$val->getNews_title()?></a></td>
									<td><?=$val->getCreated_by()?></td>
									<td><?=$val->getUpdated_at()?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
			</div>
			<!-- /.panel -->
		</div>
		<?php } ?>
	</div>
</div>
