<?php


$msg_server_admin = "Please report this to the website admin.";
$msg_field_empty = "This field cannot be empty";

$msg_admin_manage_admin_add = [
	"Admin ID cannot be empty",
	"First name cannot be empty",
	"Last name cannot be empty",
	"Title cannot be empty",
	"Admin ID too long",
	"First name too long",
	"Middle name too long",
	"Last name too long",
	"Title too long",
	"Password cannot be empty",
	"Admin Account with same ID already exists",
	"Database STMT Error"
];
$msg_admin_manage_admin_update = [
	"Admin ID cannot be empty",
	"First name cannot be empty",
	"Last name cannot be empty",
	"Title cannot be empty",
	"Admin ID too long",
	"First name too long",
	"Middle name too long",
	"Last name too long",
	"Title too long",
	"Password cannot be empty",
	"Database STMT Error"
];
$msg_admin_manage_student_update = [
	"Student ID cannot be empty",
	"First name cannot be empty",
	"Last name cannot be empty",
	"Course invalid",
	"Intake invalid",
	"Student ID too short/long",
	"First name too long",
	"Middle name too long",
	"Last name too long",
	"Student ID already submit application",
	"Student ID already exist in database",
	"Database STMT Error"
];
$msg_admin_login_velidation = [
	"id"=>[
		"SUCCESS",
		"Invalid/Unknown Admin ID"
	],
	"password"=>[
		"SUCCESS",
		"Invalid Password"
	],
	"none"=>[
		"SUCCESS",
		"Database STMT Error"
	]
];
$msg_login_velidation = [
	"id"=>[
		"SUCCESS",
		"Unknown Student ID. Please enter again"
	],
	"password"=>[
		"SUCCESS",
		"Invalid Password"
	],
	"none"=>[
		"SUCCESS",
		"Database STMT Error"
	]
];

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