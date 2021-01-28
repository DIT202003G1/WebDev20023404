<?php

function getCourses($client){
	$finalResult = [];
	if($result = $client->query("SELECT * FROM Course;")){
		while($row = mysqli_fetch_array($result)){
            array_push($finalResult, [$row["course_id"],$row["course_name"]]); 
        }
	}
	return $finalResult;
}
function getCountries($client){
	$finalResult = [];
	if($result = $client->query("SELECT * FROM Countries;")){
		while($row = mysqli_fetch_array($result)){
            array_push($finalResult, [$row["country_id"],$row["country_name"]]); 
        }
	}
	return $finalResult;
}

// [id,id,id ... id]
function getCountryIDs($client){
	$finalResult = [];
	if($result = $client->query("SELECT * FROM Countries;")){
		while($row = mysqli_fetch_array($result)){
            array_push($finalResult, $row["country_id"]); 
        }
	}
	return $finalResult;
}
function getCourseIDs($client){
	$finalResult = [];
	if($result = $client->query("SELECT * FROM Course;")){
		while($row = mysqli_fetch_array($result)){
            array_push($finalResult, $row["course_id"]); 
        }
	}
	return $finalResult;
}