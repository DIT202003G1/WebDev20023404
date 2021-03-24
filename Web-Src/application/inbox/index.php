<!DOCTYPE html>

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>

<?php
	sessionRedirectStudnetApp();
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/application/inbox/inbox.css">
		<link rel="stylesheet" type="text/css" href="/application/app.css">
		<link rel="stylesheet" type="text/css" href="/application/app_control.css">
		<script type="text/javascript" src="/application/search.js"></script>
		<script type="text/javascript" src="/application/app.js"></script>
	</head>
	<body class="layoutFlex box horizontal-reversed">
		<div class="mainpanel">
			<?php require "/opt/lampp/htdocs/php-includes/appUtils/header.inc.php" ?>
			<div class="layoutFlex box horizontal inbox">
				<div class="inbox-list">
					<div class="noselect item layoutFlex box horizontal">
							<div class="profile">
								<img src="" />
							</div>
							<div class="titles">
								<h3>A name here</h3>
								<p>a course here</p>
							</div>
						</div>
					</div>
					<div class="inbox-content">
						<div class="layoutFlex box horizontal title-group">
							<button >Reply</button>
							<div>
								<h3>Hello</h3>
								<div class="meta">03/02/2020 23:49</div>
							</div>
						</div>
						<div class="content">
							Today I ate a sandwitch.
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php require "/opt/lampp/htdocs/php-includes/appUtils/leftPanel.inc.php" ?>
		<script type="text/javascript">
			registerKeyPressEvent();
		</script>
		<?= $includes_foots ?>
	</body>
</html>