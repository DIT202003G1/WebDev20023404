<?php

require("/opt/lampp/htdocs/php-includes/database.inc.php");
require("/opt/lampp/htdocs/php-includes/password.inc.php");
require("/opt/lampp/htdocs/php-includes/sessionUtils.inc.php");

session_start();

sessionRedirectAdminApp();

if(!isset($_POST["delete"])){
	header("Location: /appAdmin/search/");
}

function deletePhoneNumber($clinet,$id,$index){
	$sql='DELETE FROM PhoneNum WHERE student_id = ? AND phoneNum_index = ?';
	$stmt = mysqli_stmt_init($clinet);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		echo "STMT ERR 1";
		exit();
	}
	mysqli_stmt_bind_param($stmt, "ii", $id, $index);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

function deleteAddress($clinet,$id,$index){
	$sql='DELETE FROM Address WHERE student_id = ? AND address_index = ?';
	$stmt = mysqli_stmt_init($clinet);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		echo "STMT ERR 2";
		exit();
	}
	mysqli_stmt_bind_param($stmt, "ii", $id, $index);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

function deleteEmail($clinet, $id, $index){
	$sql='DELETE FROM Emails WHERE student_id = ? AND email_index = ?';
	$stmt = mysqli_stmt_init($clinet);
	if (!mysqli_stmt_prepare($stmt, $sql)){
		echo "STMT ERR 3";
		exit();
	}
	mysqli_stmt_bind_param($stmt, "ii", $id, $index);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
}

if ($_POST["type"]==="email"){
	deleteEmail($sql_client,$_POST["student_id"],$_POST["index"]);
}
if ($_POST["type"]==="address"){
	deleteAddress($sql_client,$_POST["student_id"],$_POST["index"]);
}
if ($_POST["type"]==="phoneNum"){
	deletePhoneNumber($sql_client,$_POST["student_id"],$_POST["index"]);
}


$id = $_POST["student_id"];
header("Location: /appAdmin/search/?id=$id");