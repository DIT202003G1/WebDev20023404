<?php

$template = [
	"title" => "Title..",
	"content" => "Long Content/Description..",
	"buttons" => [
		"Text/Captions..." => "Link...",
		"Text/Captions..." => "Link..."
	]
];

$signed_up_successful = [
	"title" => "Thankyou for signing up",
	"content" => "Your registration request has been recorded. Please wait for an admin to approve your registration.",
	"buttons" => [
		"Take Me Back to Home Page" => "/"
	]
];

$wait_for_admin = [
	"title" => "Account not yet activated",
	"content" => "You are trying to sign in into an account that is yet to be approved by an admin. Please try again later or contact the Website Admin.",
	"buttons" => [
		"Take Me Back to Home Page" => "/"
	]
];

$account_rejected = [
	"title" => "Account is rejected",
	"content" => "The account you are trying to sign in is being rejected by an the Website Admin. For more information, please contact the Website Admin.",
	"buttons" => [
		"Back to Home" => "/",
		"Sign Up Again" => "/view-register"
	]
];

$account_blocked = [
	"title" => "Account is disabled",
	"content" => "The account you are trying to sign in has been diabled by an admin. For more information, please contact the Website Admin.",
	"buttons" => [
		"Back to Home" => "/"
	]
];