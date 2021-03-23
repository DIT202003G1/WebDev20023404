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

		$i = 0;
		$emails = [];
		while ($row = $result->fetch_assoc()) {
			$emails[$i]["email"] = $row["email"];
			$emails[$i]["description"] = $row["description"];

			$i++;
		}

		$stmt->close();
		return $emails;
	}

	function getPhoneNumbersByID($conn, $id) {
		$stmt = $conn->prepare("SELECT phoneNum, description FROM PhoneNum WHERE student_id = ? AND isHidden = 0;");
		$stmt->bind_param("i", $id);

		$stmt->execute();
		$result = $stmt->get_result();

		$i = 0;
		$phoneNumbers = [];
		while ($row = $result->fetch_assoc()) {
			$phoneNumbers[$i]["phone_number"] = $row["phoneNum"];
			$phoneNumbers[$i]["description"] = $row["description"];

			$i++;
		}

		$stmt->close();
		return $phoneNumbers;
	}

	function getAddressesByID($conn, $id) {
		$stmt = $conn->prepare("SELECT Address.address_line1, Address.address_line2, Address.city, Address.state_province, Address.description, Countries.country_name FROM Address, Countries WHERE Countries.country_id = Address.country_id AND Address.student_id = ? AND Address.isHidden = 0;");
		$stmt->bind_param("i", $id);

		$stmt->execute();
		$result = $stmt->get_result();

		$i = 0;
		$addresses = [];
		while ($row = $result->fetch_assoc()) {
			$addresses[$i]["address"] = $row["address_line1"] . ", " . $row["address_line2"];
			$addresses[$i]["city"] = $row["city"];
			$addresses[$i]["state"] = $row["state_province"];
			$addresses[$i]["country"] = $row["country_name"];
			$addresses[$i]["description"] = $row["description"];

			$i++;
		}

		$stmt->close();
		return $addresses;
	}

	function getUserByID($conn, $id) {
		$stmt = $conn->prepare("SELECT StudentUser.first_name, StudentUser.middle_name, StudentUser.last_name, StudentUser.intake, Course.course_name FROM StudentUser, Course WHERE Course.course_id = StudentUser.course_id AND StudentUser.student_id = ?;");
		$stmt->bind_param("i", $id);

		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		$user = array(
			"name" => sprintf(
				"%s %s %s",
				$row["first_name"],
				$row["middle_name"],
				$row["last_name"]
			),
			"course" => $row["course_name"],
			"intake" => sprintf(
				"%s/%s",
				substr($row["intake"], 4, 2),
				substr($row["intake"], 0, 4)
			)
		);

		$stmt->close();
		return $user;
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
								<?php
									$phoneNumbers = getPhoneNumbersByID($sql_client, $_GET["id"]);
									foreach ($phoneNumbers as &$phoneNumber) {
										echo "<tr>";
										echo "	<td>" . $phoneNumber["description"] . "</td>";
										echo "	<td>" . $phoneNumber["phone_number"] . "</td>";
										echo "</tr>";
									}
								?>
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
								
								<?php
									$addresses = getAddressesByID($sql_client, $_GET["id"]);
									foreach ($addresses as &$address) {
										echo "<tr>";
										echo "	<td>" . $address["description"] . "</td>";
										echo "	<td>" . $address["address"] . "</td>";
										echo "	<td>" . $address["city"] . "</td>";
										echo "	<td>" . $address["state"] . "</td>";
										echo "	<td>" . $address["country"] . "</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="info">
					<div class="card">
						<div class="profile"><img src=""></div>
						<?php
							$user = getUserByID($sql_client, $_GET["id"]);
							echo '<div class="name">' . $user["name"] . '</div>';
							echo '<div class="course">' . $user["course"] . '</div>';
							echo '<div class="intake">' . $user["intake"] . '</div>';
						?>
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