<?php

require("/opt/lampp/htdocs/php-includes/database.inc.php");
require("/opt/lampp/htdocs/php-includes/password.inc.php");

if (!isset($_POST["submit"])){
	header("Location: /appAdmin/view-login");
}

define("ROOT_PASSWORD","a");

//get account info
function getAccountInfo($client, $id){
	// false = invalid info
	// 1 = STMT ERR
	// object = account obj
	$processed = trim($id);
	if (empty($processed)){
		return false;
	}
	if (!is_numeric($processed)){
		return false;
	}
	$sql = "SELECT admin_id, password_hash, salt FROM AdminUser where admin_id = ?;";
	$stmt = mysqli_stmt_init($client);
	if (! mysqli_stmt_prepare($stmt, $sql)){
		return 1;
	}
	mysqli_stmt_bind_param($stmt, "i", $processed);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if($row = mysqli_fetch_assoc($result)){
		return $row;
	}
	return false;
}

//send Error
function sendError($ecode, $etype, $efield){
	header("Location: /appAdmin/view-login?ecode=$ecode&etype=$etype&efield=$efield");
	exit();
}

//Check is is root account
$isRootUid = $_POST["id"] === "root";
$isRootPwd = $_POST["password"] === ROOT_PASSWORD;

if($isRootUid && !$isRootPwd){
	sendError("1","client","password");
}
elseif($isRootPwd && $isRootUid){
	session_start();
	$_SESSION["userid"] = "root";
	$_SESSION["type"] = "admin";
	header("Location: /appAdmin");
	exit();
}

//verification of id and pw

$test_userID = getAccountInfo($sql_client, $_POST["id"]);

if (!$test_userID){
	sendError("1","client","id");
}
if ($test_userID === 1){
	sendError("1","server","none");
}
$test_password = testPassword($_POST["password"],$test_userID["salt"],$test_userID["password_hash"]);
if (!$test_password){
	sendError("1","client","password");
}

session_start();
$_SESSION["userid"] = trim($_POST["id"]);
$_SESSION["type"] = "admin";
header("Location: /appAdmin");
exit();