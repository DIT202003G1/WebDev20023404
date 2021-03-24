<!DOCTYPE html>

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/appUtils/search.inc.php" ?>

<?php
	sessionRedirectStudnetApp();
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/application/app.css">
		<link rel="stylesheet" type="text/css" href="/application/app_control.css">
		<script type="text/javascript" src="/application/search.js"></script>
		<script type="text/javascript" src="/application/app.js"></script>
	</head>
	<body class="layoutFlex box horizontal-reversed">
		<div class="mainpanel">
			<?php require "/opt/lampp/htdocs/php-includes/appUtils/header.inc.php" ?>
			<div class="content container layoutCenter box">
				<?php
					$courses = getCourses($sql_client); 
					for ($i = 0; $i < count($search_query_result); $i ++) {
						$result = $search_query_result[$i];
						$profile = getProfilePicture($result["student_id"]);
						$bookmarked = (in_array($result["student_id"], $bookmarked_query_result)) ? "<img class=\"icon\" src=\"/assets/app/bookmark.svg\" />" : "";
						$id = $result["student_id"];
						$course_id = $result["course_id"];
						foreach($courses as $course_data){
							if ($course_data[0] === $course_id){
								$course_name = $course_data[1];
								break;
							}
						}
						$name = $result["first_name"]." ".$result["last_name"];
						if ($i % 2 === 0){
							echo "
								<div class=\"row\">
									<div class=\"col-md-6\">
										<div onclick=\"nevigateToID($id)\" class=\"card layoutFlex box horizontal\">
											<img class=\"profile\" src=\"$profile\" />
											<div class=\"title\">
												<h3>$name</h3>
												<span>$course_name</span>
											</div>
											$bookmarked
										</div>
									</div>
							";
							if ($i === (count($search_query_result) - 1)){
								echo "</div>";
							}
						}
						else{
							echo "
									<div class=\"col-md-6\">
										<div onclick=\"nevigateToID($id)\" class=\"card layoutFlex box horizontal\">
											<img class=\"profile\" src=\"$profile\" />
											<div class=\"title\">
												<h3>$name</h3>
												<span>$course_name</span>
											</div>
											$bookmarked
										</div>
									</div>
								</div>
							";
						}
					}
				// <div class="row">
				// 	<div class="col-md-6">
				// 		<div class="card layoutFlex box horizontal">
				// 			<img class="profile" src="" />
				// 			<div class="title">
				// 				<h3>Lorem</h3>
				// 				<span>Ipsum</span>
				// 			</div>
				// 			<img class="icon" src="/assets/app/bookmark.svg" />
				// 		</div>
				// 	</div>
				// 	<div class="col-md-6">
				// 		<div class="card layoutFlex box horizontal">
				// 			<img class="profile" src="" />
				// 			<div class="title">
				// 				<h3>Lorem</h3>
				// 				<span>Ipsum</span>
				// 			</div>
				// 			<img class="icon" src="/assets/app/bookmark.svg" />
				// 		</div>
				// 	</div>
				// </div>
				
				?>
				<div class="row">
				</div>
			</div>
		</div>
		<?php require "/opt/lampp/htdocs/php-includes/appUtils/leftPanel.inc.php" ?>
		<script type="text/javascript">
			registerKeyPressEvent();
		</script>
		<?= $includes_foots ?>
	</body>
</html>