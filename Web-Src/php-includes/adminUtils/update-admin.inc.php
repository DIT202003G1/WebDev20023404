<?php

session_start();
require("controlPanel.inc.php");
require("../sessionUtils.inc.php");
require("../database.inc.php");
require("../dbUtils.inc.php");
require("../password.inc.php");
sessionRedirectAdminApp();

function v_password($client, $password){
	// -1 : empty
	// 0 : success
	if (empty($password)){
		return -1;
	}else{
		return 0;
	}
}

function v_adminID($client,$id){
	// -1 : empty
	// 0 : success
	// 1 : invalid length
	$processed = trim($id);
	$length = strlen($processed);
	if (empty($processed)){
		return -1;
	}
	elseif ($length > 8){
		return 1;
	}
	else{
		return 0;
	}
}
function v_others($client,$name){
	// -1 : empty
	// 0 : success
	// 1 : invalid length
	$processed = trim($name);
	$length = strlen($processed);
	if (empty($processed)){
		return -1;
	}
	elseif ($length > 64){
		return 1;
	}
	else{
		return 0;
	}
}

function sendError($ecode,$id){
	header("Location: /appAdmin/admin/?id=$id&err=$ecode");
	exit();
}

function submitToDatabase($client, $id, $fname, $mname, $lname, $title){
	$sql = "UPDATE AdminUser SET admin_id = ?, first_name = ?, middle_name = ?, last_name = ?, title = ? where admin_id = ?";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		sendError(10,$_POST["ad_id"]);
	}
	mysqli_stmt_bind_param($stmt, "issssi", $id, $fname, $mname, $lname, $title, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

function submitPassword($client, $password, $id){
	$result = generateHashedPw($password);
	$salt = $result[0];
	$hashed = $result[1];
	$sql = "UPDATE AdminUser SET password_hash = ?, salt = ? WHERE admin_id = ?";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		sendError(10,$_POST["ad_id"]);
	}
	mysqli_stmt_bind_param($stmt, "ssi", $hashed, $salt, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

if (isset($_POST["ad_updatePw"])){
	$test_pw = v_password($sql_client, $_POST["ad_password"]);
	if ($test_pw === -1){
		sendError(9,$_POST["ad_id"]);
	}
	submitPassword($sql_client, $_POST["ad_password"],$_POST["ad_id"]);
	$id = $_POST["ad_id"];
	header("Location: /appAdmin/admin/?id=$id");
	exit();
}

if (!isset($_POST["ad_update"])){
	header("Location: /appAdmin/admin");
	exit();
}

$test_id = v_adminID($sql_client, $_POST["ad_id"]);
$test_fname = v_others($sql_client, $_POST["ad_fname"]);
$test_mname = v_others($sql_client, $_POST["ad_mname"]);
$test_lname = v_others($sql_client, $_POST["ad_lname"]);
$test_title = v_others($sql_client, $_POST["ad_title"]);

if ($test_id === -1){
	sendError(0,$_POST["ad_id"]);
}
if ($test_fname === -1){
	sendError(1,$_POST["ad_id"]);
}
if ($test_lname === -1){
	sendError(2,$_POST["ad_id"]);
}
if ($test_title === -1){
	sendError(3,$_POST["ad_id"]);
}
if ($test_id === 1){
	sendError(4,$_POST["ad_id"]);
}
if ($test_fname === 1){
	sendError(5,$_POST["ad_id"]);
}
if ($test_mname === 1){
	sendError(6,$_POST["ad_id"]);
}
if ($test_lname === 1){
	sendError(7,$_POST["ad_id"]);
}
if ($test_title === 1){
	sendError(8,$_POST["ad_id"]);
}
submitToDatabase($sql_client, $_POST["ad_id"], $_POST["ad_fname"], $_POST["ad_mname"], $_POST["ad_lname"],$_POST["ad_title"]);
$id = $_POST["ad_id"];
header("Location: /appAdmin/admin/?id=$id");