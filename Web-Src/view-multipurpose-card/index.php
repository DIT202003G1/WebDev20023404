<!DOCTYPE html>

<!-- Design by Xuanao Zhao 20023404. MIT License Applied -->

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "card-content.inc.php" ?>

<?php
	$cardObject;
	if (isset($_GET["code"]) && isset($card_contents[$_GET["code"]])){
		$cardObject = $card_contents[$_GET["code"]];
	}else{
		$cardObject = $not_found;
	}
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/view-multipurpose-card/multipurpose-card.css">
		<script type="text/javascript" src="/view-multipurpose-card/multipurpose-card.js"></script>
		<title><?= $cardObject["pageTitle"]?> - ACMS Pro</title>
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