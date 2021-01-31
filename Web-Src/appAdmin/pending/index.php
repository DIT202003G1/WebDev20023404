<!DOCTYPE html>


<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/message.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>

<?php
	sessionRedirectAdminApp();
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/appAdmin/dashboards/dashboard.css">
		<script type="text/javascript" src="/appAdmin/dashboards/dashboard.js"></script>
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
									<select class="filter">
										<option value="none">(None)</option>
										<option value="inclusive">Inclusive</option>
										<option value="exclusive">Exclusive</option>
										<option value="course-inclusive">Course-Inclusive</option>
										<option value="course-exclusive">Course-Exclusive</option>
										<option value="intake-inclusive">Intake-Inclusive</option>
										<option value="intake-exclusive">Intake-Exclusive</option>
									</select>
								</div>
								<div class="appInputGroup">
									<input type="text" id="filterVal" placeholder="Filter Value" />
								</div>
								<div class="appInputGroup">
									<input type="checkbox" id="rejected" />
									<span>Show Accepted/Rejected Applications</span>
								</div>
							</div>
							<div class="list">
								<div class="item noselect selected">
									<div>
										<div class="id">12345678</div>
										<div class="name">Test Test</div>
									</div>
									<div class="status rejected">Rejected</div>
								</div>
								<div class="item noselect">
									<div>
										<div class="id">12345678</div>
										<div class="name">Test Test</div>
									</div>
									<div class="status pending">Pending</div>
								</div>
								<div class="item noselect">
									<div>
										<div class="id">12345678</div>
										<div class="name">Test Test</div>
									</div>
									<div class="status pass">Pass</div>
								</div>
							</div>
						</div>
						<div style="background-color: rgba(0,0,0,0);display: none" class="layoutCenter box contentPanel"><div class="layoutCenter center">Please select an page from the menu</div></div>
						<div style="" class="contentPanel">
							<div class="layoutFlex box horizontal label">
								<div class="text">Application Details</div>
								<div class="shape"></div>
							</div>
							<form>
								<table class="appInputGroup super">
									<tr>
										<td class="inputLabel">Student ID</td>
										<td>
											<div class="appInputGroup">
												<input type="text" name="ad_id" readonly />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Reg ID</td>
										<td>
											<div class="appInputGroup">
												<input type="text" name="ad_regid" readonly />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">First Name</td>
										<td>
											<div class="appInputGroup">
												<input type="text" name="ad_fname" readonly />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Middle Name</td>
										<td>
											<div class="appInputGroup">
												<input type="text" name="ad_mname" readonly />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Last Name</td>
										<td>
											<div class="appInputGroup">
												<input type="text" name="ad_lname" readonly />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Course ID</td>
										<td>
											<div class="appInputGroup">
												<input type="text" name="ad_course" readonly />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Intake</td>
										<td>
											<div class="appInputGroup">
												<input type="text" name="ad_intake" readonly />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Status</td>
										<td>
											<div class="appInputGroup">
												<input type="text" name="ad_status" readonly />
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
		<?= $includes_foots ?>
	</body>
</html>