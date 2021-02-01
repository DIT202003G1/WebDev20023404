<!DOCTYPE html>


<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/adminUtils/controlPanel.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/database.inc.php" ?>

<?php
	sessionRedirectAdminApp();
?>
<?php
	$pendingApplications = getAllPending($sql_client);
	$pendingApplicationsJson = json_encode($pendingApplications);
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/appAdmin/dashboards/dashboard.css">
		<script type="text/javascript" src="/appAdmin/dashboards/pending.js"></script>
		<script type="text/javascript" src="/appAdmin/dashboards/links.js"></script>
		<script type="text/javascript">
			var pendingApplications = <?= $pendingApplicationsJson ?>;
		</script>
		<title>Admin Control Panel - ACMS Pro</title>
	</head>
	<body>
		<div class="mainContainer">
			<div class="layoutFlex box horizontal">
				<div class="leftPane">
					<div class="logoBox">
						<img src="/assets/admin_panel.svg" alt="Admin Panel Logo"/>
					</div>
					<div>
						<div class="layoutFlex box horizontal label">
							<div class="text">Student's User Accounts</div>
							<div class="shape"></div>
						</div>
					</div>
					<div onclick="nevigate('/appAdmin/pending')" class="listItem pending selected noselect">Pending Applications</div>
					<div onclick="nevigate('/appAdmin/search')" class="listItem search noselect">Manage Studnet's Accounts</div>
					<div>
						<div class="layoutFlex box horizontal label">
							<div class="text">System (Global) Configs</div>
							<div class="shape"></div>
						</div>
					</div>
					<div onclick="nevigate('/appAdmin/admin')" class="listItem admin noselect">Manage Admin's Accounts</div>
					<div onclick="nevigate('/appAdmin/course')" class="listItem course noselect">Manage Courses</div>
					<div>
						<div class="layoutFlex box horizontal label">
							<div class="text">Logout</div>
							<div class="shape"></div>
						</div>
					</div>
					<div class="currentAdminDetails">
						Logged in as <a href="#"><?= $_SESSION["userid"] ?></a>. <a href="/php-includes/logout.inc.php">Logout</a>
					</div>
				</div>
				<div class="rightPaneContainer">
					<div class="titleBox">Pending Applications</div>
					<div class="content layoutFlex box horizontal">
						<div class="contentList layoutFlex box vertical">
							<div class="filter">
								<div class="appInputGroup">
									<select id="filterType" class="filter" onchange="filterTypeChange(pendingApplications)">
										<option value="inclusive">Inclusive</option>
										<option value="exclusive">Exclusive</option>
										<option value="courseinclusive">Course-Inclusive</option>
										<option value="courseexclusive">Course-Exclusive</option>
										<option value="intakeinclusive">Intake-Inclusive</option>
										<option value="intakeexclusive">Intake-Exclusive</option>
									</select>
								</div>
								<div class="appInputGroup">
									<input type="text" id="filterVal" oninput="filterOnChange(pendingApplications)" onkeydown="filterOnChange(pendingApplications)" onchange="filterOnChange(pendingApplications)" placeholder="Filter Value" />
								</div>
								<div class="appInputGroup">
									<input type="checkbox" id="rejected" onclick="toggleRejectedApplication(pendingApplications)"/>
									<span>Show Rejected Applications</span>
								</div>
							</div>
							<div class="list">
							<?php 
								for ($i = 0; $i < count($pendingApplications); $i ++){
									$name = $pendingApplications[$i]["first_name"] . " " . $pendingApplications[$i]["last_name"];
									$id = $pendingApplications[$i]["student_id"];
									$regid = $pendingApplications[$i]["reg_id"];
									$type = ($pendingApplications[$i]["pending"] == 1) ? "Pending" : "Rejected";
									$class = ($pendingApplications[$i]["pending"] == 1) ? "pending" : "rejected";
									$selected = (($_GET["id"] === $id) && ($_GET["regid"] === $regid)) ? "selected" : "";
									echo "
										<div onclick=\"nevigateToID('$id', '$regid', false)\" id=\"listitem_$id"."_"."$regid\" class=\"item $selected noselect\">
											<div>
												<div class=\"id\">$id</div>
												<div class=\"name\">$name</div>
											</div>
											<div class=\"status $class\">$type</div>
										</div>
									";
								}
							?>
							</div>
						</div>
						<?php 
							$hasID = isset($_GET["id"]);
							$promptStyle = $hasID ? "none" : "";
							$panelStyle = $hasID ? "" : "none";
						?>
						<div style="background-color: rgba(0,0,0,0);display: <?= $promptStyle ?>;" class="layoutCenter box contentPanel"><div class="layoutCenter center">Please select an page from the menu</div></div>
						<div style="display: <?= $panelStyle ?>;" class="contentPanel">
							<div class="layoutFlex box horizontal label">
								<div class="text">Application Details</div>
								<div class="shape"></div>
							</div>
							<form action="/php-includes/adminUtils/pending-approve.inc.php" method="post">
								<?php
									$studentData = getPendingByID($sql_client,$_GET["id"],$_GET["regid"]);
									$isPending = ($studentData["pending"] == 1);
									$pendingStyle = $isPending ? "color: var(--front_wait); border: var(--front_wait) 2px solid" : "color: var(--front_error); border: var(--front_error) 2px solid" ;
									$pendingStatus = $isPending ? "Pending" : "Rejected" ;
								?>
								<table class="appInputGroup super">
									<tr>
										<td class="inputLabel">Student ID</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_id" readonly value="<?= $studentData["student_id"] ?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Reg ID</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_regid" readonly value="<?= $studentData["reg_id"] ?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">First Name</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_fname" readonly value="<?= $studentData["first_name"] ?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Middle Name</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_mname" readonly value="<?= $studentData["middle_name"] ?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Last Name</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_lname" readonly value="<?= $studentData["last_name"] ?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Course ID</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_course" readonly value="<?= $studentData["course_id"] ?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Intake</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_intake" readonly value="<?= $studentData["intake"] ?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Status</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" style="<?= $pendingStyle ?>" name="ad_status" readonly value="<?= $pendingStatus ?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel"></td>
										<td class="inputButtonContainer">
											<input type="submit" value="Accept" name="accept" />
											<input type="submit" value="Deny" name="deny" />
										</td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			init(pendingApplications,<?= ($_GET["showReject"] === "true") ? "true" : "false" ?>);
		</script>
		<?= $includes_foots ?>
	</body>
</html>