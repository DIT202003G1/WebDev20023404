<?php require "/opt/lampp/htdocs/php-includes/appUtils/userinfo.inc.php" ?>

<div class="appbar layoutFlex box horizontal">
	<div class="search">
		<input type="text" id="search" placeholder="Name / ID / Course / Intake" id="searchVal"/>
	</div>
	<div class="right layoutFlex box horizontal">
		<a href="/application/inbox">
			<img class="icon" src="/assets/app/messages.svg"/>
		</a>
		<div class="profile">
			<img onclick="nevigateToOptions()" src="<?= getProfilePicture($_SESSION['userid']) ?>"/>
		</div>
	</div>
</div>