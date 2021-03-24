<?php

require("/opt/lampp/htdocs/php-includes/database.inc.php");

/* EXAMPLE:

_GET:
	intake => "1,2,3"
	_misc => "1"

will become:
	SELECT * FROM StudentUser WHERE (intake like '%1%' OR intake like '%2%' OR intake like '%3%') AND ((first_name like '%1%' OR middle_name like '%1%' OR last_name like '%1%'));

*/

$args = [];

$ref = [
	"id"=>"student_id",
	"course"=>"course_id",
	"intake"=>"intake",
];

foreach ($_GET as $type => $val){
	$type = strtolower($type);
	$subConditions = [];
	$subElements = explode(",",$val);
	if ($type === "_misc") {
		foreach ($subElements as $i){
			array_push($subConditions, "(first_name like '%$i%' OR middle_name like '%$i%' OR last_name like '%$i%')");
		}
	}
	elseif ( in_array($type, ["id","course","intake"]) ){
		foreach ($subElements as $i){
			array_push($subConditions, "$ref[$type] like '%$i%'");
		}
	}
	$subConditions = "(" . join(" OR ",$subConditions) . ")";
	array_push($args,$subConditions);
}

// print_r($args);
$condition = join(" AND ",$args);

$search_query_result = [];
$result = $sql_client->query("SELECT * FROM StudentUser WHERE $condition;");
while ($row = $result->fetch_assoc()){
	array_push($search_query_result, $row);
}

$bookmarked_query_result = [];
$result = $sql_client->query("SELECT * FROM Bookmarks WHERE student_id = ".$_SESSION["userid"].";");
while ($row = $result->fetch_assoc()){
	array_push($bookmarked_query_result, $row["target_id"]);
}