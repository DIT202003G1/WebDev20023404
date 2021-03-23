<?php

$template = [
	"pageTitle" => "Page Title",
	"title" => "Title..",
	"content" => "Long Content/Description..",
	"buttons" => [
		"Text/Captions..." => "Link...",
		"Text/Captions..." => "Link..."
	]
];

$not_found = [
	"pageTitle" => "Not Found",
	"title" => "[404] Lost in the maze of website.",
	"content" => "Tap tap, click click, as the time slowly ticks... Welcome to no where.<br/><code>The page you have requested is unavailable</code>",
	"buttons" => [
		"Find Me the Way Back..." => "/"
	]
];

$signed_up_successful = [
	"pageTitle" => "Sign Up",
	"title" => "Thank you for signing up",
	"content" => "Your registration request has been recorded. Please wait for an admin to approve your registration.",
	"buttons" => [
		"Take Me Back to Home Page" => "/"
	]
];

$wait_for_admin = [
	"pageTitle" => "Sign In",
	"title" => "Account not yet activated",
	"content" => "You are trying to sign in into an account that is yet to be approved by an admin. Please try again later or contact the Website Admin.",
	"buttons" => [
		"Take Me Back to Home Page" => "/"
	]
];

$account_rejected = [
	"pageTitle" => "Sign In",
	"title" => "Account is rejected",
	"content" => "The account you are trying to sign in is being rejected by an the Website Admin. For more information, please contact the Website Admin.",
	"buttons" => [
		"Back to Home" => "/",
		"Sign Up Again" => "/view-register"
	]
];

$account_blocked = [
	"pageTitle" => "Sign In",
	"title" => "Account is Disabled",
	"content" => "The account you are trying to sign in has been diabled by an admin. For more information, please contact the Website Admin.",
	"buttons" => [
		"Back to Home" => "/"
	]
];


//Register to card content

$card_contents = [
	"successful"=>$signed_up_successful,
	"waitforadmin"=>$wait_for_admin,
	"rejected"=>$account_rejected,
	"blocked"=>$account_blocked,
	"not_found"=>$not_found
];