<?php

function sessionIsLoggedIn(){
	return isset($_SESSION["userid"]);
}

function sessionIsAdmin(){
	return $_SESSION["type"] === "admin";
}
function sessionIsStudent(){
	return $_SESSION["type"] === "student";
}


//actions
function sessionRedirect($type){
	$destination = ($type === "student") ? "application" : "appAdmin";
	header("Location: /$destination");
	exit();
}
function sessionRedirectByType(){
	if (sessionIsAdmin()){
		sessionRedirect("admin");
	}elseif(sessionIsStudent()){
		sessionRedirect("student");
	}
}
function sessionRedirectStudnetLogin(){
	if(sessionIsLoggedIn()){
		sessionRedirectByType();
	}
}
function sessionRedirectStudnetApp(){
	if(sessionIsLoggedIn() && sessionIsAdmin()){
		sessionRedirectByType();
	}
	if(!sessionIsLoggedIn()){
		header("Location: /view-login");
		exit();
	}
}
function sessionRedirectAdminLogin(){
	if(sessionIsLoggedIn()){
		sessionRedirectByType();
	}
}
function sessionRedirectAdminApp(){
	if(sessionIsLoggedIn() && sessionIsStudent()){
		sessionRedirectByType();
	}
	if(!sessionIsLoggedIn()){
		header("Location: /appAdmin/view-login");
		exit();
	}
}