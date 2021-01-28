<?php


$msg_server_admin = "Please report this to the website admin.";
$msg_field_empty = "This field cannot be empty";

$msg_register_velidation = [
	"id" => [
		"SUCCESS",
		"Student ID should be in 8 Digit Numbers",
		"Student ID should be in 8 Digit Numbers"
	],
	"fname" => [
		"SUCCESS",
		"Name should not be exceeding 64 characters"
	],
	"lname" => [
		"SUCCESS",
		"Name should not be exceeding 64 characters"
	],
	"mname" => [
		"SUCCESS",
		"Name should not be exceeding 64 characters"
	],
	"course" => [
		"SUCCESS",
		"Unknown Course"
	],
	"intake" => [
		"SUCCESS",
		"Unknown Intake"
	],
	"password" => [
		"SUCCESS",
		"Password cannot contain your student ID",
		"Password length has to be atleast 8",
		"Password should contain atleast 1 Uppercase, Lowercase <strong>AND</strong> Special Characters each",
	],
	"repassword" =>[
		"SUCCESS",
		"",
		"",
		"",
		"Password does not match"
	],
	"none" =>[
		"SUCCESS",
		"Database STMT Error",
		"You have already submitted an registration request, Please wait for approval",
		"You have already signed up! Click on Sign In to sign in with your ACMS account!",
	]
];