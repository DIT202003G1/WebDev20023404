<?php

require_once("database.inc.php");
require_once("dbUtils.inc.php");
require_once("password.inc.php");
require_once("redirect-template.inc.php");
require_once("userUtils.inc.php");

if (!isset($_POST["submit"])){
	header("Location: /view-login");
}

echo $redurect_template;

$hasError = false;
function sendError($ecode,$etype,$efield){
	global $hasError;
	$hasError = true;
	header("Location: /view-login?ecode=$ecode&etype=$etype&efield=$efield");
	exit();
}

#velidations
function velidateID($id){
	/*
		-1 empty
		0 success
	*/
	$processed = trim($id);
	if (empty($processed)){
		return -1;
	}
	return 0;
}

function velidatePW($password){
	/*
		-1 empty
		0 success
	*/
	if (empty($password)){
		return -1;
	}
	return 0;
}

function getUserInfo($client,$id){
	/*
		0 success
		1 unknown user
		2 stmt err
	*/
	$processed = trim($id);
	$sql = "SELECT student_id, password_hash, salt from StudentUser WHERE student_id = ? AND blocked = 0;";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		sendError(1,"server","none");
		return [2, null];
	}
	mysqli_stmt_bind_param($stmt, "i", $processed);
	mysqli_stmt_execute($stmt);
	$stmtResult = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($stmtResult)){
		mysqli_stmt_close($stmt);
		return [0, $row];
	}
	mysqli_stmt_close($stmt);
	return [1, null];
}

function getUserStatus($client, $id){
	// 0 Successful
	// 1 Pending
	// 2 Rejected
	// 3 Blocked
	$processed = trim($id);
	$pending = su_isPending($client, $id);
	$rejected = su_isRejected($client, $id);
	$blocked = su_isBlocked($client, $id);
	if ($rejected === -1 || $pending === -1 || $blocked === -1){
		sendError(1,"server","none");
	}
	elseif($pending){
		return 1;
	}
	elseif($rejected){
		return 2;
	}
	elseif ($blocked) {
		return 3;
	}
	else{
		return 0;
	}
}

$test_id = velidateID($_POST["id"]);
$temp_usr = getUserInfo($sql_client,$_POST["id"]);
$test_user = $temp_usr[0];
$test_password = velidatePW($_POST["password"]);
$test_validPassword = ! testPassword($_POST["password"], $temp_usr[1]["salt"], $temp_usr[1]["password_hash"]);
$test_state = getUserStatus($sql_client, $_POST["id"]);

if ($temp_usr[0] === 1){
	sendError(1,"client","id");
}
if($test_state === 1){
	header("Location: /view-multipurpose-card?code=waitforadmin");
	exit();
}elseif($test_state === 2){
	header("Location: /view-multipurpose-card?code=rejected");
	exit();
}elseif($test_state === 3){
	header("Location: /view-multipurpose-card?code=blocked");
	exit();

if ($test_id === -1){
	sendError(-1,"client","id");
}elseif($test_user === 1){
	sendError(1,"client","id");
}elseif($test_user === 1){
	sendError(1,"client","none");
}elseif($test_password === -1){
	sendError(-1,"client","password");
}elseif($test_validPassword === 1){
	sendError(1,"client","password");
}
}

if (!$hasError){
	session_start();
	$_SESSION["userid"] = trim($_POST["id"]);
	$_SESSION["type"] = "student";
	header("Location: /application/");
}