<!DOCTYPE html>

<!-- Design by Xuanao Zhao 20023404. MIT License Applied -->

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/message.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>

<?php
	sessionRedirectStudnetLogin();
?>

<html>
	<head>
		<?php echo "$includes_head"; ?>
		<link rel="stylesheet" type="text/css" href="/view-login/login.css">
		<script type="text/javascript" src="/view-login/login.js"></script>
		<title>Sign In - ACMS Pro</title>
	</head>
	<body>
		<div class="layoutCenter container box">
			<div class="layoutCenter center lightBox">
				<div class="layoutFlex container box horizontal lightBoxContent">
					<div class="primaryOption">
						<div class="titleFrame primary">
							<h1 class="formTitle primary">Sign in to your ACMS account</h1>
						</div>
						<div class="errmsg" style="display:<?= isset($_GET["ecode"]) ? "" : "none"  ?>;">
							<?php
								// echo $msg_login_velidation;
								if ($_GET["ecode"] === "-1"){
									echo "Field cannot be empty";
								}
								else{
									$errmsg = $msg_reset_velidation[$_GET["efield"]][$_GET["ecode"]];
									echo $errmsg;
								}
								if ($_GET["etype"] === "server"){
									echo " $msg_server_admin";
								}
							?>
						</div>
						<div>
							<form action="/php-includes/token_reset.inc.php" method="post">
								<div class="inputGroup">
									<div class="inputComponent content <?= $_GET["efield"]=="id" ? "error" : "" ?>">
										<div class="label">
											<i class="fas fa-key fa-2x"></i>
										</div>
										<div class="input">
											<input type="text" placeholder="Reset Token" name="id"/>
										</div>
									</div>
								</div>
								<div class="inputGroup">
									<div class="inputComponent content <?= $_GET["efield"]=="password" ? "error" : "" ?>">
										<div class="label">
											<i class="fas fa-key fa-2x"></i>
										</div>
										<div class="input">
											<input type="password" placeholder="New Password" name="password"/>
										</div>
									</div>
								</div>
								<div class="inputGroup">
									<div class="inputComponent content <?= $_GET["efield"]=="password" ? "error" : "" ?>">
										<div class="label">
											<i class="fas fa-key fa-2x"></i>
										</div>
										<div class="input">
											<input type="password" placeholder="Re-Enter Password" name="repassword"/>
										</div>
									</div>
								</div>
								<div class="inputGroup">
									<input type="submit" value="Reset Password" name="submit" class="light" />
								</div>
							</form>
							<a class="light" href="/view-login">Back to Sign In</a>
							<p>Please request a <strong>password reset token</strong> from the website admin.</p>
						</div>
					</div>
					<div class="secondaryOption">
						<div class="titleFrame secondary">
							<h1 class="formTitle secondary">New to ACMS pro?</h1>
						</div>
						<p class="textContent secondary">
							Join now to stay in touch with your friends!
							<br/>
							<br/>
							Register with in a minute
						</p>
						<button class="dark button secondary noselect" onclick="gotoRegister()">Sign Up</button>
					</div>
				</div>
			</div>
		</div>
		<?php echo "$includes_foots"; ?>
	</body>
</html>