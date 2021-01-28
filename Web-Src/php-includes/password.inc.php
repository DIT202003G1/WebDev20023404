<?php

function generateSalt(){
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
	$result = "";
	for($i = 0; $i < 8; $i++){
		$random = $chars[rand(0,strlen($chars) - 1)];
		$result .= $random;
	}
	return $result;
}

function hashPw($raw){
	return hash("sha256",$raw,false);
}

function generateHashedPw($raw){
	$salt = generateSalt();
	$hashed = hashPw($salt . $raw);
	return [$salt, $hashed];
}