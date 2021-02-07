<?php

session_start();
require("controlPanel.inc.php");
require("../sessionUtils.inc.php");
require("../database.inc.php");
require("../dbUtils.inc.php");
require("../password.inc.php");
sessionRedirectAdminApp();

function sendError($ecode,$id){
	header("Location: /appAdmin/add-admin/?id=$id&err=$ecode");
	exit();
}

function v_adminID($client,$id){
	$processed = trim($id);
	$length = strlen($processed);
	if (empty($processed)){
		sendError(0 ,$_POST["ad_id"]);
	}
	elseif ($length > 8){
		sendError(4 ,$_POST["ad_id"]);
	}
	$sql = "SELECT * FROM AdminUser WHERE admin_id = ?;";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		sendError(11,$_POST["ad_id"]);
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if (mysqli_fetch_assoc($result)){
		mysqli_stmt_close($stmt);
		sendError(10,$_POST["ad_id"]);
	}
	mysqli_stmt_close($stmt);
}
function v_password($client, $password){
	if (empty($password)){
		sendError(9 ,$_POST["ad_id"]);
	}else{
		return 0;
	}
}
function v_others($client,$name, $type){
	$processed = trim($name);
	$length = strlen($processed);
	if (empty($processed)){
		if ($type === "fname"){
			sendError(1 ,$_POST["ad_id"]);
		}
		elseif($type==="lname"){
			sendError(2 ,$_POST["ad_id"]);
		}
		elseif($type==="title"){
			sendError(3 ,$_POST["ad_id"]);
		}
	}
	elseif ($length > 64){
		if ($type === "fname"){
			sendError(5 ,$_POST["ad_id"]);
		}
		elseif($type==="mname"){
			sendError(6 ,$_POST["ad_id"]);
		}
		elseif($type==="lname"){
			sendError(7 ,$_POST["ad_id"]);
		}
		elseif($type==="title"){
			sendError(8 ,$_POST["ad_id"]);
		}
	}
	else{
		return 0;
	}
}

function submitToDatabase($client, $id, $fname, $mname, $lname, $title, $password){
	$generated = generateHashedPw($password);
	$hash = $generated[1];
	$salt = $generated[0];
	$sql = "INSERT INTO AdminUser(admin_id, first_name, middle_name, last_name, title, password_hash, salt) VALUES (?,?,?,?,?,?,?)";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		sendError(11,$_POST["ad_id"]);
	}
	mysqli_stmt_bind_param($stmt, "issssss", $id, $fname, $mname, $lname, $title, $hash, $salt);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

if (!isset($_POST["ad_new"])){
	header("Location: /appAdmin/admin");
	exit();
}

v_adminID($sql_client, $_POST["ad_id"]);
v_others($sql_client, $_POST["ad_fname"], "fname");
v_others($sql_client, $_POST["ad_mname"], "mname");
v_others($sql_client, $_POST["ad_lname"], "lname");
v_others($sql_client, $_POST["ad_title"], "title");
v_password($sql_client, $_POST["ad_password"]);
submitToDatabase($sql_client, $_POST["ad_id"], $_POST["ad_fname"], $_POST["ad_mname"], $_POST["ad_lname"],$_POST["ad_title"],$_POST["ad_password"]);
$id = $_POST["ad_id"];
header("Location: /appAdmin/admin/?id=$id");