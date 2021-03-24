<!DOCTYPE html>

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/database.inc.php" ?>

<?php
	sessionRedirectStudnetApp();

	$result = $sql_client -> query("SELECT s.*, m.title, m.content, m.send_date, m.is_read, m.msg_index FROM StudentUser as s, Messages as m WHERE m.sender_id = s.student_id AND target_id = ".$_SESSION["userid"]);
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/application/inbox/inbox.css">
		<link rel="stylesheet" type="text/css" href="/application/app.css">
		<link rel="stylesheet" type="text/css" href="/application/app_control.css">
		<script type="text/javascript" src="/application/search.js"></script>
		<script type="text/javascript" src="/application/app.js"></script>
		<script type="text/javascript" src="/application/inbox/inbox.js"></script>
	</head>
	<body class="layoutFlex box horizontal-reversed">
		<div class="mainpanel">
			<?php require "/opt/lampp/htdocs/php-includes/appUtils/header.inc.php" ?>
			<div class="layoutFlex box horizontal inbox">
				<div class="inbox-list">
				<?php
					while ($row = $result->fetch_assoc()){
						$id = $row["student_id"];
						$index = $row["msg_index"];
						$name = $row["first_name"] . " " . $row["last_name"];
						$title = $row["title"];
						$profile = getProfilePicture($id);
						echo "
							<div onclick=\"nevigateToInbox('$id','$index')\" class=\"noselect item layoutFlex box horizontal\">
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
				?>
				</div>
				<?php
					$style = 'none';
					if (isset($_GET["id"])){
						$style = '';
						$stmt = $sql_client->prepare("SELECT * FROM Messages WHERE sender_id = ? AND msg_index = ? AND target_id = ?");
						$stmt->bind_param("iii", $_GET["id"], $_GET["index"], $_SESSION["userid"]);
						$stmt->execute();
						$result = $stmt->get_result();
						$row = $result->fetch_assoc();
					}
				?>
				<div class="inbox-content" style="display: <?= $style ?>">
					<div class="layoutFlex box horizontal title-group">
						<button onclick="newMessage('<?= $row['sender_id'] ?>')">Reply</button>
						<div>
							<h3><?=$row["title"]?></h3>
							<div class="meta"><?=$row["send_date"]?></div>
						</div>
					</div>
					<div class="content">
						<?=$row["content"]?>
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