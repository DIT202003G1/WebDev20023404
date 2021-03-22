<?php

function getStudentUserName($client,$id){
	$sql = "SELECT first_name, middle_name, last_name FROM StudentUser WHERE student_id = ?";
	$stmt = mysqli_stmt_init($client);
	mysqli_stmt_prepare($stmt, $sql);
	mysqli_stmt_bind_param($stmt, "i", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	return mysqli_fetch_assoc($result);
}