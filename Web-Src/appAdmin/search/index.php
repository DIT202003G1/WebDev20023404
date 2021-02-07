<!DOCTYPE html>


<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/adminUtils/controlPanel.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/database.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/dbUtils.inc.php" ?>

<?php
	sessionRedirectAdminApp();
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/appAdmin/dashboards/dashboard.css">
		<script type="text/javascript" src="/appAdmin/dashboards/manage.js"></script>
		<script type="text/javascript" src="/appAdmin/dashboards/links.js"></script>
		<title>Admin Control Panel - ACMS Pro</title>
		<?php
			$allStudents = getAllStudentAccountBasicInfo($sql_client);
			$allStudentsJson = json_encode($allStudents);
		?>
		<script type="text/javascript">
			const allStudents = <?= $allStudentsJson ?>;
		</script>
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
					<div onclick="nevigate('/appAdmin/pending')" class="listItem pending noselect">Pending Applications</div>
					<div onclick="nevigate('/appAdmin/search')" class="listItem search selected noselect">Manage Studnet's Accounts</div>
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
						Logged in as <a href="/appAdmin/admin/?id=<?= $_SESSION['userid']?>"><?= $_SESSION["userid"] ?></a>. <a href="/php-includes/logout.inc.php">Logout</a>
					</div>
				</div>
				<div class="rightPaneContainer">
					<div class="titleBox">Manage a Student's Account</div>
					<div class="content layoutFlex box horizontal">
						<div class="contentList layoutFlex box vertical">
							<div class="filter">
								<div class="appInputGroup">
									<select id="filterType" class="filter" onchange="filterChange()">
										<option value="inclusive">Inclusive</option>
										<option value="exclusive">Exclusive</option>
										<option value="courseinclusive">Course-Inclusive</option>
										<option value="courseexclusive">Course-Exclusive</option>
										<option value="intakeinclusive">Intake-Inclusive</option>
										<option value="intakeexclusive">Intake-Exclusive</option>
									</select>
								</div>
								<div class="appInputGroup">
									<input type="text" id="filterVal" oninput="filterChange()" onkeydown="filterChange()" onchange="filterChange()" placeholder="Filter Value" />
								</div>
							</div>
							<div class="list">
								<?php 
									foreach ($allStudents as $i){
										$id = $i["student_id"];
										$selected = ($i["student_id"] == $_GET["id"]) ? "selected" : "";
										$name = $i["first_name"]." ".$i["last_name"];
										$class = ($i["blocked"] == 1) ? "rejected" : "pass";
										$type = ($i["blocked"] == 1) ? "Blocked" : "Active";
										echo "
											<div onclick=\"nevigateToID('$id')\" id=\"listitem_$id\"class=\"item $selected noselect\">
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
							$appDisplay = $hasID ? "" : "none";
							$welcomeDisplay = $hasID ? "none" : "";
						?>
						<div style="background-color: rgba(0,0,0,0);display: <?=$welcomeDisplay?>;" class="layoutCenter box contentPanel"><div class="layoutCenter center">Select a student account in the list to begin.</div></div>
						<div style="display: <?=$appDisplay?>;" class="contentPanel">
							<div class="tabPages">
								<div onclick="switchTab('Details');" id="tabsel_Details"  class="tabPage noselect selected"> Details</div>
								<div onclick="switchTab('Emails');" id="tabsel_Emails"  class="tabPage noselect">Emails</div>
								<div onclick="switchTab('Addresses');" id="tabsel_Addresses"  class="tabPage noselect">Addresses</div>
								<div onclick="switchTab('PhoneNum');" id="tabsel_PhoneNum" class="tabPage noselect">Phone Num</div>
							</div>
							<!-- DETAILS -->
							<?php
								$studentDetails = getStudentAccountBasicInfo($sql_client,$_GET["id"]);
								$id = $studentDetails["student_id"];
								$fname = $studentDetails["first_name"];
								$mname = $studentDetails["middle_name"];
								$lname = $studentDetails["last_name"];
								$course = $studentDetails["course_id"];
								$intake = $studentDetails["intake"];
								$status = ($studentDetails["blocked"] == 1) ? "Blocked" : "Active";
								$statusStyle = ($studentDetails["blocked"] == 1) ? "color: var(--front_error);border: solid 2px var(--front_error);" : "color: var(--front_success);border: solid 2px var(--front_success);";
								$blockButton = ($studentDetails["blocked"] == 1) ? "Unblock" : "Block";
								$blockButtonName = ($studentDetails["blocked"] == 1) ? "unblock" : "block";
							?>
							<form method="post" action="/php-includes/adminUtils/update-student.inc.php">
								<div class="topMargin" id="tab_Details">
									<table class="appInputGroup super">
										<div class="layoutFlex box horizontal label">
											<div class="text">Student's Details</div>
											<div class="shape"></div>
										</div>
										<tr>
											<td class="inputLabel">Student ID</td>
											<td>
												<div class="appInputGroup secondDesign">
													<input type="text" readonly name="sd_id" value="<?=$id?>" />
												</div>
											</td>
										</tr>
										<tr>
											<td class="inputLabel">First Name</td>
											<td>
												<div class="appInputGroup secondDesign">
													<input type="text" name="sd_fname" value="<?=$fname?>" />
												</div>
											</td>
										</tr>
										<tr>
											<td class="inputLabel">Middle Name</td>
											<td>
												<div class="appInputGroup secondDesign">
													<input type="text" name="sd_mname" value="<?=$mname?>" />
												</div>
											</td>
										</tr>
										<tr>
											<td class="inputLabel">Last Name</td>
											<td>
												<div class="appInputGroup secondDesign">
													<input type="text" name="sd_lname" value="<?=$lname?>" />
												</div>
											</td>
										</tr>
										<tr>
											<td class="inputLabel">Course ID</td>
											<td>
												<div class="appInputGroup secondDesign">
													<!-- <input type="text" name="sd_course" value="<?=$course?>" /> -->
													<select name="sd_course" >
														<?php 
															$courses = getCourses($sql_client);
															foreach ($courses as $i){
																$selected = ($course == $i[0]) ? "selected" : "";
																echo "<option $selected value=\"$i[0]\">$i[0]</option>";
															}
														?>

													</select>
												</div>
											</td>
										</tr>
										<tr>
											<td class="inputLabel">Intake</td>
											<td>
												<div class="appInputGroup secondDesign">
													<input maxlength="6" type="text" name="sd_intake" value="<?=$intake?>" />
												</div>
											</td>
										</tr>
										<tr>
											<td class="inputLabel">Status</td>
											<td>
												<div class="appInputGroup pass secondDesign">
													<input type="text" style="<?=$statusStyle?>" readonly name="sd_status" value="<?=$status?>" />
												</div>
											</td>
										</tr>
										<tr>
											<td class="inputLabel"></td>
											<td class="inputButtonContainer">
												<input type="submit" name="sd_update" value="Update"/>
											</td>
									</table>
									<div class="layoutFlex box horizontal label">
										<div class="text">Account Actions</div>
										<div class="shape"></div>
									</div>
									<div class="inputGroup topMargin leftMargin">
										<input type="submit" class="light" value="Reset Password" name="reset" />
										<input type="submit" class="light" value="<?=$blockButton?> Account" name="<?=$blockButtonName?>" />
									</div>
								</form>
							</div>
							<!-- DETAILS -->
							<!-- EMAILS -->
							<div class="topMargin" id="tab_Emails">
								<?php
									$emails = getStudentEmails($sql_client, $_GET["id"]);
									foreach ($emails as $i){
										$emailContent = $i["email"];
										$emailIndex = $i["email_index"];
										$emailDesc = $i["description"];
										echo "
											<div id=\"email_$emailIndex\" class=\"contactList noselect email\">
												<div class=\"captions\">
													<h1>$emailDesc</h1>
													<p>$emailContent</p>
												</div>
												<div class=\"icons\">
													<form action=\"/php-includes/adminUtils/delete-contact.inc.php\" method=\"post\">
														<input type=\"hidden\" value=\"$id\" name=\"student_id\" />
														<input type=\"hidden\" value=\"email\" name=\"type\" />
														<input type=\"hidden\" value=\"$emailIndex\" name=\"index\" />
														<input type=\"submit\" value=\"\" name=\"delete\" class=\"delete\" value=\"\"/>
													</form>
												</div>
											</div>
										";
									}
								?>
							</div>
							<!-- EMAILS -->
							<!-- Addresses -->
							<div class="topMargin" id="tab_Addresses">
								<?php
									$addresses = getStudentAddresses($sql_client, $_GET["id"]);
									foreach ($addresses as $i){
										$addressDisplay = $i["address_line1"] . ", " . $i["address_line2"] . ", " . $i["city"] . ", " . $i["state_province"] . " ," . $i["country_name"];
										$addressIndex = $i["address_index"];
										$addressDesc = $i["description"];
										echo "
										<div id=\"address_$addressIndex\" class=\"contactList noselect address\">
											<div class=\"captions\">
												<h1>$addressDesc</h1>
												<p>$addressDisplay</p>
											</div>
											<div class=\"icons\">
												<form action=\"/php-includes/adminUtils/delete-contact.inc.php\" method=\"post\">
													<input type=\"hidden\" value=\"$id\" name=\"student_id\" />
														<input type=\"hidden\" value=\"address\" name=\"type\" />
														<input type=\"hidden\" value=\"$addressIndex\" name=\"index\" />
													<input type=\"submit\" name=\"delete\" class=\"delete\" value=\"\"/>
												</form>
											</div>
										</div>
										";
									};
									?>
							</div>
							<!-- Addresses -->
							<!-- PhoneNum -->
							<div class="topMargin" id="tab_PhoneNum">
								<?php
									$phoneNums = getStudentPhoneNums($sql_client, $_GET["id"]);
									foreach ($phoneNums as $i){
										$phoneNum = $i["phoneNum"];
										$phoneIndex = $i["phoneNum_index"];
										$phoneDesc = $i["description"];
										echo "
										<div id=\"phoneNum_$phoneIndex\" class=\"contactList noselect phone\">
											<div class=\"captions\">
												<h1>$phoneDesc</h1>
												<p>$phoneNum</p>
											</div>
											<div class=\"icons\">
												<form action=\"/php-includes/adminUtils/delete-contact.inc.php\" method=\"post\">
													<input type=\"hidden\" value=\"$id\" name=\"student_id\" />
														<input type=\"hidden\" value=\"phoneNum\" name=\"type\" />
														<input type=\"hidden\" value=\"$phoneIndex\" name=\"index\" />
													<input type=\"submit\" name=\"delete\" class=\"delete\" value=\"\"/>
												</form>
											</div>
										</div>
										";
									}
								?>
							</div>
							<!-- PhoneNum -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			init();
		</script>
		<?= $includes_foots ?>
	</body>
</html>