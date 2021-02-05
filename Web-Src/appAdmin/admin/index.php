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
		<script type="text/javascript" src="/appAdmin/dashboards/admin.js"></script>
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
					<div onclick="nevigate('/appAdmin/search')" class="listItem search noselect">Manage Studnet's Accounts</div>
					<div>
						<div class="layoutFlex box horizontal label">
							<div class="text">System (Global) Configs</div>
							<div class="shape"></div>
						</div>
					</div>
					<div onclick="nevigate('/appAdmin/admin')" class="listItem admin selected noselect">Manage Admin's Accounts</div>
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
					<div class="titleBox">Manage a Admin's Account</div>
					<div class="content layoutFlex box horizontal">
						<div class="contentList layoutFlex box vertical">
							<div class="filter">
								<div class="link">
									<a href="#" >+ Add Account</a>
								</div>
							</div>
							<div class="list">
								<?php 
									$admins = getAllAdmins($sql_client);
									foreach ($admins as $i){
										$id = $i["admin_id"];
										$selected = ($id == $_GET["id"]) ? "selected" : "";
										$name = $i["first_name"] . " " . $i["list_name"];
										$type = ($id == $_SESSION["userid"]) ? "Current" : "";
										$class = ($id == $_SESSION["userid"]) ? "pass" : "";
										echo "
											<div onclick=\"nevigateToID($id)\" id=\"listitem_$id\"class=\"item $selected noselect\">
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
							<div class="layoutFlex box horizontal label">
								<div class="text">Admin's Details</div>
								<div class="shape"></div>
							</div>
							<form>
								<?php
									$adminDetails = getAdminAccountBasicInfo($sql_client, $_GET["id"]);
									$id = $adminDetails["admin_id"];
									$fname = $adminDetails["first_name"];
									$mname = $adminDetails["middle_name"];
									$lname = $adminDetails["last_name"];
									$title = $adminDetails["title"];
								?>
								<table class="appInputGroup super">
									<tr>
										<td class="inputLabel">Admin ID</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" readonly name="ad_id" value="<?=$id?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">First Name</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_fname" value="<?=$fname?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Middle Name</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_mname" value="<?=$mname?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Last Name</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_lname" value="<?=$lname?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel">Title</td>
										<td>
											<div class="appInputGroup secondDesign">
												<input type="text" name="ad_title" value="<?=$title?>" />
											</div>
										</td>
									</tr>
									<tr>
										<td class="inputLabel"></td>
										<td class="inputButtonContainer">
											<input type="submit" name="ad_update" value="Update"/>
										</td>
									</tr>
								</table>
							</form>
							<div class="layoutFlex box horizontal label">
								<div class="text">Reset Password</div>
								<div class="shape"></div>
							</div>
							<form>
								<table class="appInputGroup super">
								<tr>
									<td class="inputLabel">Password</td>
									<td>
										<div class="appInputGroup secondDesign">
											<input type="password" name="ad_lname" />
										</div>
									</td>
								</tr>
								<tr>
									<td class="inputLabel">Re-Type</td>
									<td>
										<div class="appInputGroup secondDesign">
											<input type="password" name="ad_title" />
										</div>
									</td>
								</tr>
								<tr>
									<td class="inputLabel"></td>
									<td class="inputButtonContainer">
										<input type="submit" name="ad_update" value="Update"/>
									</td>
								</tr>
								</table>
							</form>
							<div class="layoutFlex box horizontal label">
								<div class="text">Remove Account</div>
								<div class="shape"></div>
							</div>
							<form>
								<table class="appInputGroup super">
									<tr>
										<td class="inputLabel"></td>
										<td class="inputButtonContainer">
											<input type="submit" name="ad_update" value="Remove Account"/>
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
			init();
		</script>
		<?= $includes_foots ?>
	</body>
</html>