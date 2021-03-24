<?php

session_start();
require "/opt/lampp/htdocs/php-includes/database.inc.php";

$stmt = $sql_client->prepare("SELECT * FROM Messages WHERE sender_id = ? AND target_id = ? ORDER BY msg_index DESC LIMIT 1");
$stmt->bind_param("ii", $_SESSION["userid"], $_POST["id"]);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$index = intval($row["msg_index"]) + 1; 
$stmt->close();

$stmt = $sql_client->prepare("INSERT INTO Messages VALUES (?,?,?,?,?,CURDATE(),0)");
$stmt->bind_param("iiiss", $_SESSION["userid"], $_POST["id"], $index, $_POST["title"], $_POST["content"]);
$stmt->execute();
$stmt->close();

header("Location: /application/inbox/new.php?id=12345678&sent=yes");
exit();