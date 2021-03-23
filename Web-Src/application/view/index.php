<!DOCTYPE html>

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/sessionUtils.inc.php" ?>
<?php require "/opt/lampp/htdocs/php-includes/database.inc.php" ?>

<?php
	sessionRedirectStudnetApp();

	function getEmailsByID($conn, $id) {
		$stmt = $conn->prepare("SELECT email, description FROM Emails WHERE student_id = ? AND isHidden = 0;");
		$stmt->bind_param("i", $id);

		$stmt->execute();

		$result = $stmt->get_result();
		$emails = [];

		$i = 0;
		while ($row = $result->fetch_assoc()) {
			$emails[$i]["email"] = $row["email"];
			$emails[$i]["description"] = $row["description"];

			$i++;
		}

		$stmt->close();

		return $emails;
	}
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
			<div class="userinfo layoutFlex box horizontal">
				<div class="index">
					<div>
						<a href="#emails">Emails</a>
						<a href="#phoneno">Phone No.</a>
						<a href="#addresses">Addresses</a>
					</div>
				</div>
				<div class="feed">
					<div class="card">
						<a name="emails"></a>
						<h2>Emails</h2>
						<table>
							<tbody>
								<tr class="header">
									<th scope="col">Description</th>
									<th scope="col">Email</th>
								</tr>
								<?php
									$emails = getEmailsByID($sql_client, $_GET["id"]);
									foreach ($emails as &$email) {
										echo "<tr>";
										echo "	<td>" . $email["description"] . "</td>";
										echo "	<td>" . $email["email"] . "</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
					<div class="card">
						<a name="phoneno"></a>
						<h2>Phone Numbers</h2>
						<table>
							<tbody>
								<tr class="header">
									<th scope="col">Description</th>
									<th scope="col">Phone Number</th>
								</tr>
								<tr>
									<td>Main</td>
									<td>123456789</td>
								</tr>
								<tr>
									<td>Work</td>
									<td>234567890</td>
								</tr>
								<tr>
									<td>Work</td>
									<td>234567890</td>
								</tr>
								<tr>
									<td>Work</td>
									<td>234567890</td>
								</tr>
								<tr>
									<td>Work</td>
									<td>234567890</td>
								</tr>
								<tr>
									<td>Work</td>
									<td>234567890</td>
								</tr>
								<tr>
									<td>Work</td>
									<td>234567890</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="card">
						<a name="addresses"></a>
						<h2>Addresses</h2>
						<table>
							<tbody>
								<tr class="header">
									<th scope="col">Description</th>
									<th scope="col">Address</th>
									<th scope="col">City</th>
									<th scope="col">State</th>
									<th scope="col">Country</th>
								</tr>
								<tr>
									<td>Main</td>
									<td>No1, Jalan Example</td>
									<td>Example</td>
									<td>Example</td>
									<td>Example</td>
								</tr>
								<tr>
									<td>Main</td>
									<td>No1, Jalan Example</td>
									<td>Example</td>
									<td>Example</td>
									<td>Example</td>
								</tr>
								<tr>
									<td>Main</td>
									<td>No1, Jalan Example</td>
									<td>Example</td>
									<td>Example</td>
									<td>Example</td>
								</tr>
								<tr>
									<td>Main</td>
									<td>No1, Jalan Example</td>
									<td>Example</td>
									<td>Example</td>
									<td>Example</td>
								</tr>
								<tr>
									<td>Main</td>
									<td>No1, Jalan Example</td>
									<td>Example</td>
									<td>Example</td>
									<td>Example</td>
								</tr>
								<tr>
									<td>School</td>
									<td>No2, Jalan Example</td>
									<td>Example</td>
									<td>Example</td>
									<td>Example</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="info">
					<div class="card">
						<div class="profile"><img src=""></div>
						<div class="name">Lorem Ipsum</div>
						<div class="course">Foundation in Music</div>
						<div class="intake">March, 2020</div>
						<div class="action"><button onclick="addBookmark(1)" class="special bookmark">Bookmark</button></div>
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
				<div class="listItem layoutFlex box horizontal">
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