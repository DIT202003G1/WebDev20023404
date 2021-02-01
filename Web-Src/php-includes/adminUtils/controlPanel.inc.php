<?php 

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