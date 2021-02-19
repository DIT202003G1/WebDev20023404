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
		<script type="text/javascript" src="/application/search.js"></script>
		<script type="text/javascript" src="/application/app.js"></script>
	</head>
	<body class="layoutFlex box horizontal-reversed">
		<div class="mainpanel">
			<div class="appbar-special">
				<div class="normalbar layoutFlex box horizontal">
					<div class="search">
						<input type="text" id="search" placeholder="Name / ID / Course / Intake" id="searchVal"/>
					</div>
					<div class="profile">
						<img onclick="nevigateToOptions()" src=""/>
					</div>
				</div>
				<div class="greetings layoutFlex box horizontal">
					<div class="profile"><img src=""/></div>
					<div class="title">
						<h2>Welcome, {name}</h2>
						<p>Manage your information and contacts;<br/>Stay in touch with the others.</p>
					</div>
					<div class="logout">
						<button onclick="logout()">Sign Out</button>
					</div>
				</div>
			</div>
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
								<p>Currently: {Name}</p>
								<button data-mdb-toggle="collapse" data-mdb-target="#name_update">Update</button>
								<div class="collapse multi-collapse mt3" id="name_update">
									<form>
										<input type="text" placeholder="First Name" name="fname" value="awa" />
										<input type="text" placeholder="Middle Name" name="fname" value="awa" />
										<input type="text" placeholder="Last Name" name="fname" value="awa" />
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
								<form>
									<table>
										<tbody>
											<tr class="header">
												<th scope="col">Description</th>
												<th scope="col">Email</th>
												<th scope="col">Hidden?</th>
											</tr>
											<tr>
												<td>Main</td>
												<td>Example@example.com</td>
												<td class="shown">Shown</td>
											</tr>
											<tr>
												<td>School</td>
												<td>Example@school.edu</td>
												<td class="hidden">Hidden</td>
											</tr>
										</tbody>
									</table>
									<button>Update</button>
									<input type="submit" value="Update"/>
									<input type="submit" value="Cancel"/>
								</form>
							</div>
						</div>
					</div>
					<a name="addresses"></a>
					<div class="row">
						<div class="col-md-12">
							<div class="card layoutFlex box vertical">
								<h2>Phone Numbers</h2>
								<form>
									<table>
										<tbody>
											<tr class="header">
												<th scope="col">Description</th>
												<th scope="col">Phone Number</th>
												<th scope="col">Hidden?</th>
											</tr>
											<tr>
												<td>Main</td>
												<td>+0123456789</td>
												<td class="shown">Shown</td>
											</tr>
											<tr>
												<td>School</td>
												<td>+0123456789</td>
												<td class="hidden">Hidden</td>
											</tr>
										</tbody>
									</table>
									<button>Update</button>
									<input type="submit" value="Update"/>
									<input type="submit" value="Cancel"/>
								</form>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card layoutFlex box vertical">
								<h2>Addresses</h2>
								<form>
									<table>
										<tbody>
											<tr class="header">
												<th scope="col">Description</th>
												<th scope="col">Address</th>
												<th scope="col">City</th>
												<th scope="col">State</th>
												<th scope="col">Country</th>
												<th scope="col">Hidden?</th>
											</tr>
											<tr>
												<td>Main</td>
												<td>No1, Jalan Example</td>
												<td>Example</td>
												<td>Example</td>
												<td>Example</td>
												<td class="shown">Shown</td>
											</tr>
											<tr>
												<td>Main</td>
												<td>No1, Jalan Example</td>
												<td>Example</td>
												<td>Example</td>
												<td>Example</td>
												<td class="shown">Shown</td>
											</tr>
											<tr>
												<td>Main</td>
												<td>No1, Jalan Example</td>
												<td>Example</td>
												<td>Example</td>
												<td>Example</td>
												<td class="shown">Shown</td>
											</tr>
										</tbody>
									</table>
									<button>Update</button>
									<input type="submit" value="Update"/>
									<input type="submit" value="Cancel"/>
								</form>
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
		</script>
		<?= $includes_foots ?>
	</body>
</html>