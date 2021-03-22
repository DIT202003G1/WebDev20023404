<?php


/*Student Users*/
function su_isPending ($client, $id){
	// -1 STMT error
	// 0 FALSE
	// 1 TRUE
	$result = 0;
	$sql = "SELECT * FROM PendingStudentUser WHERE student_id = ? AND pending = 1;";
	$stmt = mysqli_stmt_init($client);
	if(! mysqli_stmt_prepare($stmt, $sql)){
		return -1;
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_execute($stmt);
	$stmtResult = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($stmtResult)){
		$result = 1;
	}
	mysqli_stmt_close($stmt);
	return $result;
}
function su_isRejected ($client, $id){
	// -1 STMT error
	// 0 FALSE
	// 1 TRUE
	$result = 1;
	$result2 = 1;
	$sql = "SELECT * FROM PendingStudentUser WHERE student_id = ? AND pending = 1;";
	$sql2 = "SELECT * FROM StudentUser WHERE student_id = ?;";
	$stmt = mysqli_stmt_init($client);
	$stmt2 = mysqli_stmt_init($client);
	if(!( mysqli_stmt_prepare($stmt, $sql) && mysqli_stmt_prepare($stmt2, $sql2) )){
		return -1; 
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$stmtResult = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($stmtResult)){
		$result = 0;
	}
	mysqli_stmt_close($stmt);
	mysqli_stmt_bind_param($stmt2, "i", $id);
	mysqli_execute($stmt2);
	$stmtResult2 = mysqli_stmt_get_result($stmt2);
	if ($row = mysqli_fetch_assoc($stmtResult2)){
		$result2 = 0;
	}
	mysqli_stmt_close($stmt2);
	return $result && $result2;
}
function su_isBlocked ($client, $id){
	$result = 0;
	$sql = "SELECT * FROM StudentUser WHERE student_id = ? AND blocked = 1;";
	$stmt = mysqli_stmt_init($client);
	if(! mysqli_stmt_prepare($stmt, $sql)){
		return -1;
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_execute($stmt);
	$stmtResult = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($stmtResult)){
		$result = 1;
	}
	mysqli_stmt_close($stmt);
	return $result;
}
function su_isActivated ($client, $id){
	$result = 0;
	$sql = "SELECT * FROM StudentUser WHERE student_id = ? AND blocked = 0;";
	$stmt = mysqli_stmt_init($client);
	if(! mysqli_stmt_prepare($stmt, $sql)){
		return -1;
	}
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_execute($stmt);
	$stmtResult = mysqli_stmt_get_result($stmt);
	if ($row = mysqli_fetch_assoc($stmtResult)){
		$result = 1;
	}
	mysqli_stmt_close($stmt);
	return $result;
}