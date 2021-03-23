<?php

require "/opt/lampp/htdocs/php-includes/appUtils/userinfo.inc.php";
require "/opt/lampp/htdocs/php-includes/database.inc.php";

session_start();

if (isset($_POST["name_update"])){
	validateName($_POST["fname"],$_POST["mname"],$_POST["lname"]);
	$sql = "UPDATE StudentUser SET first_name = ?, middle_name = ?, last_name = ? WHERE student_id = ?";
	$stmt = mysqli_stmt_init($sql_client);
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_bind_param($stmt, "sssi", $_POST["fname"],$_POST["mname"],$_POST["lname"],$_SESSION["userid"]);
	mysqli_stmt_execute($stmt);
}
if (isset($_POST["course_update"])){
	velidateCourse($sql_client ,$_POST["course"],$_POST["intake"]);
	$sql = "UPDATE StudentUser SET course_id = ?, intake = ? WHERE student_id = ?";
	$stmt = mysqli_stmt_init($sql_client);
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_bind_param($stmt, "ssi", $_POST["course"],$_POST["intake"],$_SESSION["userid"]);
	mysqli_stmt_execute($stmt);
}
if (isset($_POST["password_update"])){
	velidatePassword($_POST["password"],$_POST["repassword"]);
	$hashed = generateHashedPw($_POST["password"]);
	$sql = "UPDATE StudentUser SET password_hash = ?, salt = ? WHERE student_id = ?";
	$stmt = mysqli_stmt_init($sql_client);
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_bind_param($stmt, "ssi", $hashed[1], $hashed[0],$_SESSION["userid"]);
	mysqli_stmt_execute($stmt);
}
if (isset($_POST["profile_update"])){
	$extension = strtolower(end(explode(".",$_FILES["profile"]["name"])));
	// print_r($_FILES);
	// exit();
	if ($extension !== "png"){
		header("Location: /application/options/?err=50");
	}
	move_uploaded_file($_FILES["profile"]["tmp_name"], "/opt/lampp/htdocs/assets/profile_pictures/".$_SESSION["userid"].".png");
}
header("Location: /application/options");
exit();