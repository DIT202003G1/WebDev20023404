<!DOCTYPE html>

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/adminUtils/controlPanel.inc.php" ?>

<?php
	sessionRedirectStudnetApp();
?>

<html>
	<head>
		<?= $includes_head ?>
		<link rel="stylesheet" type="text/css" href="/application/app.css">
		<link rel="stylesheet" type="text/css" href="/application/app_control.css">
		<script type="text/javascript" src="/application/options/options.js"></script>
		<script type="text/javascript" src="/application/search.js"></script>
		<script type="text/javascript" src="/application/app.js"></script>
	</head>
	<body class="layoutFlex box horizontal-reversed">
		<div class="mainpanel">
			<?php require "/opt/lampp/htdocs/php-includes/appUtils/options_header.inc.php" ?>
			<a name="info"></a>
			<div class="selfoptions layoutFlex box horizontal">
				<div class="index">
					<div>
						<a href="#info">Information</a>
						<a href="#emails">Emails</a>
						<a href="#phoneno">Phone No.</a>
						<a href="#addresses">Addresses</a>
					</div>
				</div>
				<div class="cards container">
					<div class="row">
						<div class="col-md-6">
							<div class="card layoutFlex box vertical">
								<h2>Name</h2>
								<?php
									$userinfo = getStudentUserInfo($sql_client, $_SESSION["userid"]);
								?>
								<p>Currently: <br/><?=$userinfo["first_name"]?> <?=$userinfo["middle_name"]?> <?=$username["last_name"]?></p>
								<button data-mdb-toggle="collapse" data-mdb-target="#name_update">Update</button>
								<div class="collapse multi-collapse mt3" id="name_update">
									<form>
										<input type="text" placeholder="First Name" name="fname" value="<?=$username["first_name"]?>" />
										<input type="text" placeholder="Middle Name" name="mname" value="<?=$username["middle_name"]?>" />
										<input type="text" placeholder="Last Name" name="lname" value="<?=$username["last_name"]?>" />
										<input type="submit" name="name_update"/>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card layoutFlex box vertical">
								<h2>Course Information</h2>
								<p>Currently: <?=$userinfo["course_id"]?> <?=$userinfo["intake"]?></p>
								<button data-mdb-toggle="collapse" data-mdb-target="#course_update">Update</button>
								<div class="collapse multi-collapse mt3" id="course_update">
									<form>
										<select name="course" value="awa">
											<?php
												$courses = getCourses($sql_client);
												foreach($courses as $i ){
													$selected = ($i[0] === $userinfo["course_id"]) ? "selected" : "";
													echo ("<option $selected value=\"$i[0]\">$i[1]</option>");
												}
											?>
										</select>
										<input type="text" placeholder="Intake" name="intake" value="<?=$userinfo["intake"]?>" />
										<input type="submit" name="course_update"/>
									</form>
								</div>
							</div>
						</div>
					</div>
					<a name="emails"></a>
					<div class="row">
						<div class="col-md-6">
							<div class="card layoutFlex box vertical">
								<h2>Password</h2>
								<p>Press update to update your password</p>
								<button data-mdb-toggle="collapse" data-mdb-target="#password_update">Update</button>
								<div class="collapse multi-collapse mt3" id="password_update">
									<form>
										<input type="password" placeholder="New Password" name="password" value="" />
										<input type="password" placeholder="Re-Enter" name="repassword" value="" />
										<input type="submit" name="password_update"/>
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card layoutFlex box vertical">
								<h2>Profile Picture</h2>
								<p>Press update to update your profile picture</p>
								<button data-mdb-toggle="collapse" data-mdb-target="#profile_update">Update</button>
								<div class="collapse multi-collapse mt3" id="profile_update">
									<form>
										<input type="file" name="profile" />
										<input type="submit" name="profile_update"/>
									</form>
								</div>
							</div>
						</div>
					</div>
					<a name="phoneno"></a>
					<div class="row">
						<div class="col-md-12">
							<div class="card layoutFlex box vertical">
								<h2>Emails</h2>
								<button onclick="addRow('email')" id="update-email-add">New Email</button>
								<form>
									<table>
										<tbody id="email">
											<tr class="header">
												<th scope="col">Description</th>
												<th scope="col">Email</th>
												<th scope="col">Hidden?</th>
											</tr>
											<?php
												$emails = getStudentEmails($sql_client,$_SESSION["userid"]);
												for ($i = 0; $i < count($emails); $i++) {
													echo "<tr id=\"email_$i\">";
														echo "<td class=\"description\">".$emails[$i]["description"]."</td>";
														echo "<td class=\"email\">".$emails[$i]["email"]."</td>";
														echo "<td class=\"". (($emails[$i]["isHidden"]) ? "hidden" : "shown") ."\">".(($emails[$i]["isHidden"]) ? "Hidden" : "Shown")."</td>";
													echo "</tr>";
												}
											?>
										</tbody>
									</table>
									<input id="update-email-submit" type="submit" value="Submit"/>
									<input onclick="reload()" id="update-email-cancel" type="submit" value="Cancel"/>
								</form>
								<button onclick="showEmailUpdate()" id="update-email-show">Update</button>
							</div>
						</div>
					</div>
					<a name="addresses"></a>
					<div class="row">
						<div class="col-md-12">
							<div class="card layoutFlex box vertical">
								<h2>Phone Numbers</h2>
								<button onclick="addRow('phone')" id="update-phone-add">New Number</button>
								<form>
									<table>
										<tbody id="phone">
											<tr class="header">
												<th scope="col">Description</th>
												<th scope="col">Phone Number</th>
												<th scope="col">Hidden?</th>
											</tr>
											<?php
												$phoneNums = getStudentPhoneNums($sql_client,$_SESSION["userid"]);
												for ($i = 0; $i < count($phoneNums); $i++) {
													echo "<tr id=\"phone_$i\">";
														echo "<td class=\"description\">".$phoneNums[$i]["description"]."</td>";
														echo "<td class=\"content\">".$phoneNums[$i]["phoneNum"]."</td>";
														echo "<td class=\"". (($phoneNums[$i]["isHidden"]) ? "hidden" : "shown") ."\">".(($phoneNums[$i]["isHidden"]) ? "Hidden" : "Shown")."</td>";
													echo "</tr>";
												}
											?>
										</tbody>
									</table>
									<input id="update-phone-submit"type="submit" value="Submit"/>
									<input onclick="reload()" id="update-phone-cancel"type="submit" value="Cancel"/>
								</form>
								<button onclick="showPhoneUpdate()" id="update-phone-show">Update</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card layoutFlex box vertical">
								<h2>Addresses</h2>
								<button onclick="addRow('address')" id="update-address-add">New Address</button>
								<form>
									<table>
										<tbody id="address">
											<tr class="header">
												<th scope="col">Description</th>
												<th scope="col">Address</th>
												<th scope="col">City</th>
												<th scope="col">State</th>
												<th scope="col">Country</th>
												<th scope="col">Hidden?</th>
											</tr>
											<?php
												$addresses = getStudentAddresses($sql_client,$_SESSION["userid"]);
												$countries = getCountries($sql_client);
												for ($i = 0; $i < count($addresses); $i++) {
													echo "<tr id=\"address_$i\">";
														echo "<td class=\"description\">".$addresses[$i]["description"]."</td>";
														echo "<td class=\"address\">".$addresses[$i]["address_line1"].", ".$addresses[$i]["address_line2"]."</td>";
														echo "<td class=\"city\">".$addresses[$i]["city"]."</td>";
														echo "<td class=\"state\">".$addresses[$i]["state_province"]."</td>";
														echo "<td class=\"country\">".$addresses[$i]["country_id"]."</td>";
														echo "<td class=\"". (($addresses[$i]["isHidden"]) ? "hidden" : "shown") ."\">".(($addresses[$i]["isHidden"]) ? "Hidden" : "Shown")."</td>";
													echo "</tr>";
												}
											?>
										</tbody>
									</table>
									<input id="update-address-submit"type="submit" value="Submit"/>
									<input onclick="reload()" id="update-address-cancel"type="submit" value="Cancel"/>
								</form>
								<button onclick="showAddressUpdate()" id="update-address-show">Update</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="leftpanel">
			<div class="noselect appInfo layoutFlex box horizontal">
				<h1>ACMS Pro</h1>
				<div class="version">Ver 1.0</div>
			</div>
			<div class="bookmarkList">
				<h2 class="noselect">Bookmarked Users</h2>
				<div class="listItem selected layoutFlex box horizontal">
					<img class="profile" src="">
					<div class="title">
						<h3>Lorem Ipsum</h3>
						<span>Dolor Sit Amet Consectetur Adipiscing</span>
					</div>
				</div>
				<div class="listItem layoutFlex box horizontal">
					<img class="profile" src="">
					<div class="title">
						<h3>Lorem Ipsum</h3>
						<span>Dolor Sit Amet</span>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			registerKeyPressEvent();
			init();
		</script>
		<?= $includes_foots ?>
	</body>
</html>