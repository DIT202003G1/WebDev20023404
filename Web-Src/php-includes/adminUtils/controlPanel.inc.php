<?php 

// pending users

function getAllPending($client){
	$result = $client->query("SELECT * FROM PendingStudentUser");
	$finalResult = [];
	while ($row = mysqli_fetch_assoc($result)){
		array_push($finalResult,$row);
	}
	return $finalResult;
}

function getPendingByID($client,$id,$regid){
	$result = $client->query("SELECT * FROM PendingStudentUser");
	while ($row = mysqli_fetch_assoc($result)){
		if (($row["student_id"] == $id) && ($row["reg_id"] == $regid)){
			return $row;
		}
	}
}

function setApproved($client, $id, $regid){
	$sql = "UPDATE PendingStudentUser SET pending = 2 WHERE student_id = ? and reg_id = ?;";
	$stmt = mysqli_stmt_init($client);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		return false;
	}
	mysqli_stmt_bind_param($stmt, "ii", $id, $regid);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return true;
}

function approveUser($client, $id, $reqid){
	$pending = getPendingByID($client, $id, $reqid);
	$sql = "INSERT INTO StudentUser(student_id, first_name, middle_name, last_name, course_id, intake, password_hash, salt) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
	$stmt = mysqli_stmt_init($client);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		return false;
	}
	mysqli_stmt_bind_param($stmt, "issssiss", $pending["student_id"], $pending["first_name"], $pending["middle_name"], $pending["last_name"], $pending["course_id"], $pending["intake"], $pending["password_hash"], $pending["salt"]);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	setApproved($client,$id, $reqid);
	return true;
}

function unPendingAll($client,$id){
	$sql = "UPDATE PendingStudentUser SET pending = 0 WHERE student_id = ? and pending = 1";
	$stmt = mysqli_stmt_init($client);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		return false;
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return true;
}

// search

function getStudentAccountBasicInfo($client,$id){
	$sql = "SELECT * FROM StudentUser WHERE student_id = ?";
	$stmt = mysqli_stmt_init($client);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		return false;
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($result)){
		return $row;
	}
	else{
		return false;
	}
}

function getStudentEmails($client,$id){
	$sql = "SELECT Emails.student_id, email_index, email, isHidden, description FROM Emails, StudentUser WHERE Emails.student_id = StudentUser.student_id and Emails.student_id = ?;";
	$stmt = mysqli_stmt_init($client);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		return false;
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$finalResult = [];
	if($row = mysqli_fetch_assoc($result)){
		array_push($finalResult, $row);
	}
	return $finalResult;
}

function getStudentPhoneNums($client,$id){
	$sql = "SELECT PhoneNum.student_id, phoneNum_index, phoneNum, isHidden, description FROM PhoneNum, StudentUser WHERE PhoneNum.student_id = StudentUser.student_id AND PhoneNum.student_id = ?;";
	$stmt = mysqli_stmt_init($client);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		return false;
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$finalResult = [];
	if($row = mysqli_fetch_assoc($result)){
		array_push($finalResult, $row);
	}
	return $finalResult;
}

function getStudentAddresses($client,$id){
	$sql = "SELECT Address.student_id, address_index, address_line1, address_line2, city, state_province, isHidden, Address.country_id, description, country_name FROM Address, StudentUser, Countries WHERE Address.student_id = StudentUser.student_id AND Address.country_id = Countries.country_id AND Address.student_id = ? ;";
	$stmt = mysqli_stmt_init($client);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		return false;
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$finalResult = [];
	if($row = mysqli_fetch_assoc($result)){
		array_push($finalResult, $row);
	}
	return $finalResult;
}

function getAllStudentAccountBasicInfo($client){
	$sql = "SELECT * FROM StudentUser";
	$result = $client->query($sql);
	$finalResult = [];
	while ($row = mysqli_fetch_assoc($result)){
		array_push($finalResult,$row);
	}
	return $finalResult;
}

//admin
function getAllAdmins($client){
	$result = $client->query("SELECT * FROM AdminUser;");
	$finalResult = [];
	while ($row = mysqli_fetch_assoc($result)){
		array_push($finalResult, $row);
	}
	return $finalResult;
}
function getAdminAccountBasicInfo($client,$id){
	$sql = "SELECT * FROM AdminUser WHERE admin_id = ?";
	$stmt = mysqli_stmt_init($client);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		return false;
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($result)){
		mysqli_stmt_close($stmt);
		return $row;
	}
	mysqli_stmt_close($stmt);
}