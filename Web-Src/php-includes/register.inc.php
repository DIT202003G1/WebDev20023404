<?php 

/*
	Error encoding:
	stmt: STMT error
	v_n_m: velidation, n: field, m: id

	type server: Please report this to the server admin
	type client: none
/*

/* _POST dictionary
	id
	fname
	lname
	mname
	courseid
	intake
	password
	repassword
	submit
*/

require_once("database.inc.php");
require_once("dbUtils.inc.php");
require_once("password.inc.php");
require_once("redirect-template.inc.php");

if (!isset($_POST["submit"])){
	header("Location: /view-register");
}

echo $redurect_template;

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
	elseif (preg_match($exptest, $intake)){
		return 0;
	}
	else{
		return 1;
	}
}

function v_password($client,$raw,$repeat,$student_id){
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
	elseif ((!empty($student_id)) && (str_contains($raw, $student_id))) {
		return 1;
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

$test_hasError = false;
function error($ecode,$etype,$efield){
	global $test_hasError;
	$test_hasError = true;
	header("Location: /view-register?ecode=$ecode&etype=$etype&efield=$efield");
}

function getRegisterID($client, $id){
	$sql_test = "SELECT reg_id FROM PendingStudentUser WHERE student_id = ? ORDER BY reg_id;";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql_test)){
		mysqli_stmt_close($stmt);
		error($test_reg,"server","none");
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$stmtResult = mysqli_stmt_get_result($stmt);
	$finalResult = 1;
	while ($row = mysqli_fetch_assoc($stmtResult)){
		$finalResult = ((int) $row["reg_id"]) + 1;
	}
	mysqli_stmt_close($stmt);
	return $finalResult;
}

function registerIntoDb($client, $id, $fname, $mname, $lname, $course, $intake, $password, $salt){
	$regid = getRegisterID($client,$id);
	$sql = "INSERT INTO PendingStudentUser(student_id, reg_id, first_name, middle_name, last_name, course_id, intake, password_hash, salt) values (?,?,?,?,?,?,?,?,?);";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		mysqli_stmt_close($stmt);
		error($test_reg,"server","none");
	};
	mysqli_stmt_bind_param($stmt, "iisssssss", $id,$regid,$fname,$mname,$lname,$course,$intake,$password,$salt);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

#velidation
$test_id = v_studentID($sql_client,$_POST["id"]);
$test_fname = v_name($sql_client,$_POST["fname"]);
$test_lname = v_name($sql_client,$_POST["lname"]);
$test_mname = v_name($sql_client,$_POST["mname"]);
$test_course = v_course($sql_client,$_POST["courseid"]);
$test_intake = v_intake($sql_client,$_POST["intake"]);
$test_password = v_password($sql_client,$_POST["password"],$_POST["repassword"],$_POST["id"]);
$test_reg = testRegistration($sql_client,$_POST["id"]);

if($test_reg === 1){
	error($test_reg,"server","none");
}
if(($test_reg !== 0) && ($test_reg !== 1)){
	error($test_reg,"client","none");
}
if($test_password === 4){
	error($test_password,"client","repassword");
}
if(($test_password !== 0) && ($test_password !== 4)){
	error($test_password,"client","password");
}
if($test_intake !== 0){
	error($test_intake,"client","intake");
}
if($test_fname !== 0){
	error($test_fname,"client","fname");
}
if($test_course !== 0){
	error($test_course,"client","course");
}
if(($test_mname !== 0) && ($test_mname !== -1)){
	error($test_mname,"client","mname");
}
if($test_lname !== 0){
	error($test_lname,"client","lname");
}
if($test_fname !== 0){
	error($test_fname,"client","fname");
}
if($test_id !== 0){
	error($test_id,"client","id");
}

$passwords = generateHashedPw($_POST["password"]);
if (!$test_hasError){
	registerIntoDb($sql_client,$_POST["id"],$_POST["fname"],$_POST["mname"],$_POST["lname"],$_POST["courseid"],$_POST["intake"],$passwords[1],$passwords[0]);
}

// header("Location: /application/");