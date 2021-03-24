<!DOCTYPE html>

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/database.inc.php" ?>

<?php
	sessionRedirectStudnetApp();

	$result = $sql_client -> query("SELECT s.*, m.title, m.content, m.send_date, m.is_read, m.msg_index FROM StudentUser as s, Messages as m WHERE m.sender_id = s.student_id AND target_id = ".$_SESSION["userid"]);
	$studnet_result = $sql_client->query("SELECT * FROM StudentUser WHERE student_id = ".$_GET["id"]);
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/application/inbox/inbox.css">
		<link rel="stylesheet" type="text/css" href="/application/app.css">
		<link rel="stylesheet" type="text/css" href="/application/app_control.css">
		<script type="text/javascript" src="/application/search.js"></script>
		<script type="text/javascript" src="/application/inbox/inbox.js"></script>
		<script type="text/javascript" src="/application/app.js"></script>
	</head>
	<body class="layoutFlex box horizontal-reversed">
		<div class="mainpanel">
			<?php require "/opt/lampp/htdocs/php-includes/appUtils/header.inc.php" ?>
			<div class="layoutFlex box horizontal inbox">
				<div class="inbox-list">
				<?php
					print_r($row);
					while ($row = $result->fetch_assoc()){
						$id = $row["student_id"];
						$index = $row["msg_index"];
						$name = $row["first_name"] . " " . $row["last_name"];
						$title = $row["title"];
						$profile = getProfilePicture($id);
						echo "
							<div onclick=\"nevigateToInbox('$id','$index')\" class=\"noselect item $selected layoutFlex box horizontal\">
								<div class=\"profile\">
									<img src=\"$profile\" />
								</div>
								<div class=\"titles\">
									<h3>$title</h3>
									<p>$name</p>
								</div>
							</div>
						";
					}
					$studnet_info = $studnet_result->fetch_assoc();
					$notification_style = (isset($_GET["sent"]) ? "" : "none");
				?>
				</div>
				<div class="inbox-content">
					<div style="display: <?= $notification_style ?>;" class="success-notification">Message Successfully Sent</div>
					<h3>To: <?= $studnet_info["first_name"] . " " . $studnet_info["last_name"] ?></h3>
					<form method="post" action="/php-includes/appUtils/newMessage.inc.php">
						<input type="text" name="title" placeholder="Title"/>
						<input type="hidden" name="id" value="<?=$_GET["id"]?>"/>
						<textarea name="content" placeholder="Content"></textarea>
						<div class="layoutFlex box horizontal-reversed">
							<input type="submit" value="Send"/>
						</div>
					</form>
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