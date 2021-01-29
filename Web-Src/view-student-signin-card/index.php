<!DOCTYPE html>

<!-- Design by Xuanao Zhao 20023404. MIT License Applied -->

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "card-content.inc.php" ?>

<?php
	$cardObject = $signed_up_successful;
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/view-student-signin-card/student-signin-card.css">
		<script type="text/javascript" src="/view-student-signin-card/student-signin-card.js"></script>
		<title>Sign In - ACMS Pro</title>
	</head>
	<body>
		<div class="layoutCenter box">
			<div class="layoutCenter center">
				<div class="lightBox">
					<div class="lightBoxCenter">
						<div class="titleBox">
							<h5><?= $cardObject["title"] ?></h5>
						</div>
						<div class="contentBox">
							<p><?= $cardObject["content"] ?></p>
						</div>
						<div class="buttonBox layoutFlex box horizontal">
							<?php
								foreach ($cardObject["buttons"] as $caption => $linkaddr){
									echo "<button class=\"dark\" onclick=\"nevigate('$linkaddr');\">$caption</button>";
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?= $includes_foots ?>
	</body>
</html>