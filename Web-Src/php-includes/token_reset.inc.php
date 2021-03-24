<?php

require("/opt/lampp/htdocs/php-includes/password.inc.php");
require("/opt/lampp/htdocs/php-includes/database.inc.php");

function verifyToken($client,$token){
	
	$stmt = $client->prepare("SELECT * FROM PasswordToken WHERE token = ?;");
	$stmt->bind_param("s",$token);
	$stmt->execute();
	$result = $stmt->get_result();
	if ($row = $result->fetch_assoc()){
		$stmt = $client->prepare("DELETE FROM PasswordToken WHERE token = ?");
		$stmt->bind_param("s",$token);
		$stmt->execute();
		$stmt->close();
		return $row;
	}
	else sendError("1","client","id");
}

function velidatePassword($raw,$repeat){
	// -1 : empty
	// 0 : success
	// 1 : contains Student ID
	// 2 : length less then 8
	// 3 : contains no Upper letter/Lower letter/Special
	// 4 : not match
	$length = strlen($raw);
	$digits = "0123456789";
	$special = " !#$%&'()*+,-./:;<=>?@[\]^_`{|}~\""; 
	if (empty($raw)){
		return -1;
	}
	elseif ($length < 8){
		return 2;
	}
	else{
		$test1 = strtolower($raw) != $raw;
		$test2 = false; 
		$test3 = false;
		for($i = 0; $i < strlen($digits); $i++){
			if(str_contains($raw, $digits[$i])){
				$test2 = true;
				break;
			}
		}
		for($i = 0; $i < strlen($special); $i++){
			if(str_contains($raw, $special[$i])){
				$test3 = true;
				break;
			}
		}
		if (!($test1 && $test2 && $test3)){
			return 3;
		}
		elseif ($raw != $repeat){
			return 4;
		}
		else{
			return 0;
		}
	}
}

function resetPassword($client,$id,$password){
	$hashed = generateHashedPw($password);
	$stmt = $client->prepare("UPDATE StudentUser SET password_hash = ?, salt = ? WHERE student_id = ?");
	$stmt->bind_param("ssi",$hashed[1],$hashed[0],$id);
	$stmt->execute();
	$stmt->close();
}

function sendError($ecode,$etype,$efield){
	header("Location: /view-login/forget.php?ecode=$ecode&etype=$etype&efield=$efield");
	exit();
}

$test_token = verifyToken($sql_client, $_POST["id"]);

$test = velidatePassword($_POST["password"],$_POST["repassword"]);
if($test === 4){
	sendError($test,"client","repassword");
}
if(($test !== 0) && ($test !== 4)){
	sendError($test,"client","password");
}

resetPassword($sql_client, $test_token["student_id"], $_GET["password"]);

header("Location: /view-login?reset=yes");