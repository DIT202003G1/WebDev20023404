<?php

$bookmark_items = [];
$result = $sql_client->query("SELECT s.* FROM StudentUser as s, Bookmarks as b WHERE s.student_id = b.target_id AND b.student_id = ".$_SESSION["userid"]);
while ($row = $result->fetch_assoc()){
	array_push($bookmark_items, $row);
}
?>
<div class="leftpanel">
	<div class="noselect appInfo layoutFlex box horizontal">
		<h1>ACMS Pro</h1>
		<div class="version">Ver 1.0</div>
	</div>
	<div class="bookmarkList">
		<h2 class="noselect">Bookmarked Users</h2>
		<?php
			$courses = getCourses($sql_client);
			foreach ($bookmark_items as $item){
				$item_id = $item["student_id"];
				$name = $item["first_name"] . " " . $item["last_name"];
				$course_id = $item["course_id"];
				foreach ($courses as $course_data){
					if ($course_data[0] == $course_id){
						$course_name = $course_data[1];
						break;
					}
				}
				$profile = getProfilePicture($item_id);
				echo "
					<div onclick=\"nevigateToID('$item_id')\" class=\"listItem layoutFlex box horizontal\">
						<img class=\"profile\" src=\"$profile\">
						<div class=\"title\">
							<h3>$name</h3>
							<span>$course_name</span>
						</div>
					</div>
				";
			}
		?>
	</div>
</div>