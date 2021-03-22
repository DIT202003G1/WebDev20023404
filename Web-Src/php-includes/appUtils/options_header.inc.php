<?php require "/opt/lampp/htdocs/php-includes/appUtils/userinfo.inc.php" ?>

<div class="appbar-special">
	<div class="normalbar layoutFlex box horizontal">
		<div class="search">
			<input type="text" id="search" placeholder="Name / ID / Course / Intake" id="searchVal"/>
		</div>
		<div class="profile">
			<img onclick="nevigateToOptions()" src="<?= getProfilePicture($_SESSION['userid']) ?>"/>
		</div>
	</div>
	<div class="greetings layoutFlex box horizontal">
		<div class="profile"><img src="<?= getProfilePicture($_SESSION['userid']) ?>"/></div>
		<div class="title">
			<h2>Welcome, {name}</h2>
			<p>Manage your information and contacts;<br/>Stay in touch with the others.</p>
		</div>
		<div class="logout">
			<button onclick="logout()">Sign Out</button>
		</div>
	</div>
</div>