<?php

require ("/opt/lampp/htdocs/php-includes/database.inc.php");
require ("/opt/lampp/htdocs/php-includes/dbUtils.inc.php");
require ("/opt/lampp/htdocs/php-includes/password.inc.php");

function sendError($ecode){
	header("Location: /application/options?err=$ecode");
	exit();
}

function validateName($fname,$mname,$lname){
	$fname = trim($fname);
	$mname = trim($mname);
	$lname = trim($lname);

	if (empty($fname) || empty($lname)){
		sendError(1);
	}
	if ((strlen($fname) > 64 )|| (strlen($mname) > 64 ) || (strlen($lname) > 64 )){
		sendError(2);
	}
}

function setName($client,$id,$fname,$mname,$lname){
	$sql = "UPDATE StudentUser SET first_name = ?, middle_name = ?, last_name = ? WHERE student_id = ?";
	$stmt = mysqli_stmt_init($client);
	if (mysqli_stmt_prepare($stmt,$sql)){
		sendError(100);
	}
	mysqli_stmt_bind_param($stmt, "sssi", $fname, $mname, $lname, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

function getName($client, $id){
	$sql = "SELECT first_name, middle_name, last_name FROM StudentUser WHERE student_id = ?";
	$stmt = mysqli_stmt_init($client);
	if (mysqli_stmt_prepare($stmt,$sql)){
		sendError(100);
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$final = [];
	$result = mysqli_stmt_get_result($stmt);
	while ($row = mysqli_fetch_assoc($stmt)){
		$final["fname"] = $row["first_name"];
		$final["mname"] = $row["middle_name"];
		$final["lname"] = $row["last_name"];
	}
	mysqli_stmt_close($stmt);
	return $final;
}

/*

	$processed = strtoupper(trim($intake));
	$exptest = "/20\d{2}0[1|3|9]/i";
	if (empty($processed)){
		return -1;
	}
	elseif (preg_match($exptest, $intake)){
		return 0;
	}
	else{
		return 1;
	}

*/

function velidateCourse($client, $courseid, $intake){
	$courses = getCourseIDs($client);
	$intake = trim($intake);
	$exptest = "/20\d{2}0[1|3|9]/i";
	if (! in_array($courseid, $courses)){
		sendError(3);
	}
	elseif (preg_match($exptest, $intake)){
		return;
	}
	sendError(4);
}

function updateCourse($client, $id ,$courseid,$intake){
	$sql = "UPDATE StudentUser SET course_id = ?, intake = ? WHERE student_id = ?;";
	$stmt = mysqli_stmt_init($client);
	if (mysqli_stmt_prepare($stmt,$sql)){
		sendError(100);
	}
	mysqli_stmt_bind_param($stmt, "ssi", $courseid, $intake, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

function getCourse($client, $id){
	$sql = "SELECT course_id, intake FROM StudentUser WHERE student_id = ?";
	$stmt = mysqli_stmt_init($client);
	if (mysqli_stmt_prepare($stmt,$sql)){
		sendError(100);
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$final = [];
	$result = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($stmt)){
		$final["id"] = $row["course_id"];
		$final["intake"] = $row["intake"];
	}
	mysqli_stmt_close($stmt);
	return $final;
}

function velidatePassword($raw, $repeat){
	$digits = "0123456789";
	$special = " !#$%&'()*+,-./:;<=>?@[\]^_`{|}~\""; 
	if (strlen($raw) < 8){
		sendError(5);
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
			sendError(6);
		}
		if ($raw != $repeat){
			sendError(7);
		}
	}
}

function updatePassword($client, $id, $raw){
	$generated = generateHashedPw($raw);
	$salt = $generated[0];
	$hashed = $generated[1];
	$sql = "UPDATE StudentUser SET password_hashed = ?, salt = ? WHERE student_id = ?;";
	$stmt = mysqli_stmt_init($client);
	if (mysqli_stmt_prepare($stmt,$sql)){
		sendError(100);
	}
	mysqli_stmt_bind_param($stmt, "ssi", $hashed, $salt, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

function getProfilePicture($id){
	$profile_path = "/opt/lampp/htdocs/assets/profile_pictures/$id.png"; 
	return (file_exists($profile_path)) ? "/assets/profile_pictures/$id.png" : "/assets/profile_pictures/default.png"; 
}