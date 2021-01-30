<!DOCTYPE html>

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/message.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>

<?php
	sessionRedirectAdminLogin();
?>


<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/appAdmin/view-login/login.css"/>
		<script type="text/javascript" src="/appAdmin/view-login/login.js"></script>
		<title>Admin Login - ACMS Pro</title>
	</head>
	<body>
		<div class="layoutCenter box">
			<div class="layoutCenter center">
				<div class="lightBox">
					<div class="titleBox">
						<h1>Sign in as Admin</h1>
					</div>
					<div class="errmsg" style="display:<?= isset($_GET["ecode"]) ? "" : "none"  ?>;"><?= ($_GET["ecode"] == "-1") ? ($msg_field_empty) : ($msg_login_velidation[$_GET["efield"]][$_GET["ecode"]]) ?><?= ($_GET["etype"] == "server") ? (". ".$msg_server_admin) : ""?></div>
					<div>
						<form action="/php-includes/adminUtils/login.inc.php" method="post">
							<div class="inputGroup">
								<div class="inputComponent content <?= $_GET["efield"]=="id" ? "error" : "" ?>">
									<div class="label">
										<i class="fas fa-user-alt fa-2x"></i>
									</div>
									<div class="input">
										<input type="text" placeholder="Admin ID" name="id"/>
									</div>
								</div>
							</div>
							<div class="inputGroup">
								<div class="inputComponent content <?= $_GET["efield"]=="password" ? "error" : "" ?>">
									<div class="label">
										<i class="fas fa-key fa-2x"></i>
									</div>
									<div class="input">
										<input type="password" placeholder="Password" name="password"/>
									</div>
								</div>
							</div>
							<div class="inputGroup">
								<input type="submit" value="Sign In" name="submit" class="light" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?= $includes_foots ?>
	</body>
</html>