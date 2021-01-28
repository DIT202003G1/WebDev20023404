<?php

require_once("database.inc.php");
require_once("dbUtils.inc.php");
require_once("password.inc.php");
require_once("redirect-template.inc.php");

if (!isset($_POST["submit"])){
	header("Location: /view-register");
}

echo $redurect_template;

function sendError($ecode,$etype,$efield){
	header("Location: /view-login?ecode=$ecode&etype=$etype&efield=$efield");
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
	$sql = "SELECT student_id, password_hash, salt from StudentUser WHERE student_id = ?";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql)){
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

$test_id = velidateID($_POST["id"]);
$temp_usr = getUserInfo($sql_client,$_POST["id"]);
$test_user = $temp_usr[0];
$test_password = velidatePW($_POST["password"]);
$test_validPassword = ! testPassword($_POST["password"], $temp_usr[1]["salt"], $temp_usr[1]["password_hash"]);

if ($test_id == -1){
	sendError(-1,"client","id");
}elseif($test_user == 1){
	sendError(1,"client","id");
}elseif($test_user == 1){
	sendError(1,"client","none");
}elseif($test_password == -1){
	sendError(-1,"client","password");
}elseif($test_validPassword == 1){
	sendError(1,"client","password");
}

header("Location: /application/");