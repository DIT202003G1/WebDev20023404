<!DOCTYPE html>


<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/adminUtils/controlPanel.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/database.inc.php" ?>

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
						Logged in as <a href="#"><?= $_SESSION["userid"] ?></a>. <a href="/php-includes/logout.inc.php">Logout</a>
					</div>
				</div>
				<div class="rightPaneContainer">
					<div class="titleBox">Manage a Student's Account</div>
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
							</div>
							<div class="list">
								<!-- dummy list item -->
								<div onclick="nevigateToID('$id', '$regid', false)" id="listitem_$id"class="item $selected noselect">
									<div>
										<div class="id">$id #$regid</div>
										<div class="name">$name</div>
									</div>
									<div class="status $class">$type</div>
								</div>
								<!-- dummy list item -->
							</div>
						</div>
						<div style="background-color: rgba(0,0,0,0);display: none;" class="layoutCenter box contentPanel"><div class="layoutCenter center">Select a student account in the list to begin.</div></div>
						<div style="display: ;" class="contentPanel">
							<div class="tabPages">
								<div onclick="switchTab('Details');" id="tabsel_Details"  class="tabPage noselect selected"> Details</div>
								<div onclick="switchTab('Emails');" id="tabsel_Emails"  class="tabPage noselect">Emails</div>
								<div onclick="switchTab('Addresses');" id="tabsel_Addresses"  class="tabPage noselect">Addresses</div>
								<div onclick="switchTab('PhoneNum');" id="tabsel_PhoneNum" class="tabPage noselect">Phone Num</div>
							</div>
							<!-- DETAILS -->
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
												<input type="text" name="ad_id" readonly value="" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">First Name</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_fname" readonly value="" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Middle Name</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_mname" readonly value="" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Last Name</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_lname" readonly value="" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Course ID</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_course" readonly value="" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Intake</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_intake" readonly value="" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Status</td>
										<td>
											<div class="appInputGroup pass secondDesign">
												<input type="text" style="" name="ad_status" readonly value="Active" />
											</div>
										</td>
									</tr>
								</table>
								<div class="layoutFlex box horizontal label">
									<div class="text">Account Actions</div>
									<div class="shape"></div>
								</div>
								<div class="inputGroup topMargin leftMargin">
									<input type="submit" class="light" value="Reset Password" name="reset" />
									<input type="submit" class="light" value="Block Account" name="block" />
								</div>
							</div>
							<!-- DETAILS -->
							<!-- EMAILS -->
							<div class="topMargin" id="tab_Emails">
								<div class="contactList noselect email">
									<div class="captions">
										<h1>Main</h1>
										<p>john_smith@example.com</p>
									</div>
									<div class="icons"><img src="/assets/admin_content_icons/delete.svg" /></i></div>
								</div>
							</div>
							<!-- EMAILS -->
							<!-- Addresses -->
							<div class="topMargin" id="tab_Addresses">
								<div class="contactList noselect address">
									<div class="captions">
										<h1>Home</h1>
										<p>No 2, Jalan Example 1/1, Example, Selangor, Malaysia</p>
									</div>
									<div class="icons"><img src="/assets/admin_content_icons/delete.svg" /></i></div>
								</div>
							</div>
							<!-- Addresses -->
							<!-- PhoneNum -->
							<div class="topMargin" id="tab_PhoneNum">
								<div class="contactList noselect phone">
									<div class="captions">
										<h1>Main</h1>
										<p>+60123456789</p>
									</div>
									<div class="icons"><img src="/assets/admin_content_icons/delete.svg" /></i></div>
								</div>
								<div class="contactList noselect phone">
									<div class="captions">
										<h1>Main</h1>
										<p>+60123456789</p>
									</div>
									<div class="icons"><img src="/assets/admin_content_icons/delete.svg" /></i></div>
								</div>
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