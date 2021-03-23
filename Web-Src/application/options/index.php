<!DOCTYPE html>

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>

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
									$username = getStudentUserName($sql_client, $_SESSION["userid"]);
								?>
								<p>Currently: <br/><?=$username["first_name"]?> <?=$username["middle_name"]?> <?=$username["last_name"]?></p>
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
								<p>Currently: {Course} {Intake}</p>
								<button data-mdb-toggle="collapse" data-mdb-target="#course_update">Update</button>
								<div class="collapse multi-collapse mt3" id="course_update">
									<form>
										<input type="text" placeholder="Course" name="course" value="awa" />
										<input type="text" placeholder="Intake" name="intake" value="awa" />
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
											<tr id="email_0">
												<td class="description">Main</td>
												<td class="content">Example@example.com</td>
												<td class="shown">Shown</td>
											</tr>
											<tr id="email_1">
												<td class="description">School</td>
												<td class="content">Example@school.edu</td>
												<td class="hidden">Hidden</td>
											</tr>
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
											<tr id="phone_0">
												<td class="description">Main</td>
												<td class="content">+0123456789</td>
												<td class="shown">Shown</td>
											</tr>
											<tr id="phone_1">
												<td class="description">School</td>
												<td class="content">+0123456789</td>
												<td class="hidden">Hidden</td>
											</tr>
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
											<tr id="address_0">
												<td class="description">Main</td>
												<td class="address">No1, Jalan Example</td>
												<td class="city">Example</td>
												<td class="state">Example</td>
												<td class="country">Example</td>
												<td class="shown">Shown</td>
											</tr>
											<tr id="address_1">
												<td class="description">Main</td>
												<td class="address">No1, Jalan Example</td>
												<td class="city">Example</td>
												<td class="state">Example</td>
												<td class="country">Example</td>
												<td class="shown">Shown</td>
											</tr>
											<tr id="address_2">
												<td class="description">Main</td>
												<td class="address">No1, Jalan Example</td>
												<td class="city">Example</td>
												<td class="state">Example</td>
												<td class="country">Example</td>
												<td class="shown">Shown</td>
											</tr>
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