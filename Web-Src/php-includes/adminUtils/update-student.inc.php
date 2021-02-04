<?php

session_start();
require("controlPanel.inc.php");
require("../sessionUtils.inc.php");
require("../database.inc.php");
require("../dbUtils.inc.php");
sessionRedirectAdminApp();

if (!isset($_POST["sd_update"])){
	header("Location: /appAdmin/search");
	exit();
}

function v_studentID($client,$id){
	// -1: empty
	// 0: success
	// 1: invalid lengthn
	// 2: invalid format (ints)
	$processed = trim($id);
	$length = strlen($processed);
	if (empty($processed)){
		return -1;
	}
	elseif ($length !== 8){
		return 1;
	}
	elseif (!is_numeric($processed)){
		return 2;
	}
	else{
		return 0;
	}
}

function v_name($client,$name){
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

function v_course($client,$course_id){
	// -1 : empty
	// 0 : success
	// 1 : invalid code
	$processed = strtoupper(trim($course_id));
	$courses = getCourseIDs($client);
	if (empty($processed)){
		return -1;
	}
	elseif (!in_array($processed,$courses)){
		return 1;
	}
	else{
		return 0;
	}
}

function v_intake($client, $intake){
	// -1 : empty
	// 0 : success
	// 1 : invalid code
	$processed = strtoupper(trim($intake));
	$exptest = "/20\d{2}0[1|3|9]/i";
	if (empty($processed)){
		return -1;
	}
	if (preg_match($exptest, $intake)){
		return 0;
	}
	else{
		return 1;
	}
}

function testRegistration($connection, $student_id){
	// 0 : success
	// 1 : STMT err
	// 2 : already registered (pending)
	// 3 : already registered (active)
	$sql_test = "SELECT * FROM PendingStudentUser WHERE student_id = ? and pending = 1;";
	$sql_test2 = "SELECT * FROM StudentUser WHERE student_id = ?;";
	$stmt = mysqli_stmt_init($connection);
	$stmt2 = mysqli_stmt_init($connection);
	if (!mysqli_stmt_prepare($stmt, $sql_test)){
		return 1;
	}
	if (!mysqli_stmt_prepare($stmt2, $sql_test2)){
		mysqli_stmt_close($stmt);
		return 1;
	}
	mysqli_stmt_bind_param($stmt, "i", $student_id);
	mysqli_stmt_execute($stmt);
	$stmtResult = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($stmtResult)){
		mysqli_stmt_close($stmt);
		mysqli_stmt_close($stmt2);
		return 2;
	}
	else{
		mysqli_stmt_bind_param($stmt2, "i", $student_id);
		mysqli_stmt_execute($stmt2);
		$stmtResult2 = mysqli_stmt_get_result($stmt2);
		if ($row = mysqli_fetch_assoc($stmtResult2)){
			mysqli_stmt_close($stmt);
			mysqli_stmt_close($stmt2);
			return 3;
		}
		mysqli_stmt_close($stmt);
		mysqli_stmt_close($stmt2);
		return 0;
	}
}

function sendError($ecode,$id){
	header("Location: /appAdmin/search/?id=$id&err=$ecode");
	exit();
}

function submitToDatabase($client, $id, $fname, $mname, $lname, $course, $intake){
	$sql = "UPDATE StudentUser SET student_id = ?, first_name = ?, middle_name = ?, last_name = ?, course_id = ?, intake = ? where student_id = ?";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		sendError(11,$_POST["sd_id"]);
	}
	mysqli_stmt_bind_param($stmt, "isssssi", $id, $fname, $mname, $lname, $course, $intake, $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

$test_id = v_studentID($sql_client, $_POST["sd_id"]);
$test_registration = testRegistration($sql_client, $_POST["sd_id"]);
$test_fname = v_name($sql_client, $_POST["sd_fname"]);
$test_mname = v_name($sql_client, $_POST["sd_mname"]);
$test_lname = v_name($sql_client, $_POST["sd_lname"]);
$test_course = v_course($sql_client, $_POST["sd_course"]);
$test_intake = v_intake($sql_client, $_POST["sd_intake"]);

if ($test_id === -1){
	sendError(0,$_POST["sd_id"]);
}
if ($test_fname === -1){
	sendError(1,$_POST["sd_id"]);
}
if ($test_lname === -1){
	sendError(2,$_POST["sd_id"]);
}
if ($test_course !== 0){
	sendError(3,$_POST["sd_id"]);
}
if ($test_intake !== 0){
	sendError(4,$_POST["sd_id"]);
}
if ($test_id !== 0){
	sendError(5,$_POST["sd_id"]);
}
if ($test_fname === 1){
	sendError(6,$_POST["sd_id"]);
}
if ($test_mname === 1){
	sendError(7,$_POST["sd_id"]);
}
if ($test_lname === 1){
	sendError(8,$_POST["sd_id"]);
}
if ($test_registration === 2){
	sendError(9,$_POST["sd_id"]);
}
if ($test_registration === 2){
	sendError(10,$_POST["sd_id"]);
}
if ($test_registration === 1) {
	sendError(11,$_POST["sd_id"]);
}

submitToDatabase($sql_client, $_POST["sd_id"],$_POST["sd_fname"],$_POST["sd_mname"],$_POST["sd_lname"],$_POST["sd_course"],$_POST["sd_intake"]);
$id = $_POST["sd_id"];
header("Location: /appAdmin/search/?id=$id");