<!DOCTYPE html>

<!-- Design by Xuanao Zhao 20023404. MIT License Applied -->

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>

<html>
	<head>
		<?php echo "$includes_head"; ?>
		<link rel="stylesheet" type="text/css" href="/view-home/home.css">
		<script type="text/javascript" src="/view-home/home.js"></script>
		<title>ACMS Pro - World's Leading ACMS</title>
	</head>
	<body>
		<div class="layoutFlex box horizontal mostout">
			<div class="primaryPane">
				<div class="primaryGradient layoutFlex box vertical-reversed">
					<?php
						if (isset($_SESSION["userid"])){
							$uid = $_SESSION['userid'];
							echo "
							<div class=\"loggedIn\">
								<h1 class=\"header primary\">
									You have Already Logged in
								</h1>
								<p class=\"paragraph primary\">
									Logged in as $uid.<br>
									<a href=\"application\">Click here</a> to enter the application page.<br>
									Not your account? <a href=\"\php-includes\logout.inc.php\">Logout</a>
								</p>
							</div>";
						}else{
							echo"
							<div class=\"loggedOut\">
								<h1 class=\"header primary\">
									New to ACMS pro?
								</h1>
								<p class=\"paragraph primary\">
									Join now to stay in touch with <br/>
									your friends!<br/>
									<br/>
									Register with in a minute
								</p>
								<div class=\"layoutFlex box horizontal buttonBox primary\">
									<button class=\"button dark\" onclick=\"gotoRegister()\">Sign Up</button>
									<button class=\"button dark noframe\" onclick=\"gotoLogin()\">Sign In</button>
								</div>
							</div>
							";
						}
					?>
				</div>
			</div>
			<div class="primaryDivision"></div>
			<div class="secondaryPane">
				<div class="logoBox">
					<img class="secondary logo" src="/assets/logo_large.svg" alt="logo"/>
					<h1 class="secondary subtitle">World's leading Alumni Contacts' Management System</h1>
				</div>
				<div class="featureBox">
					<div class="layoutFlex box horizontal featureGrid">
						<div class="featureIcon"><img src="/assets/feature_logos/friendly.svg" alt="User Friendly Icon"/></div>
						<div class="featureDescription">
							<h2 class="blue">Easy to Use</h2>
							<p>With the specially designed user interface, You will be able to find any information with ease.</p>
						</div>
					</div>
					<div class="layoutFlex box horizontal-reversed featureGrid">
						<div class="featureIcon"><img src="/assets/feature_logos/powerful.svg" alt="User Friendly Icon"/></div>
						<div class="featureDescription reversed">
							<h2 class="orange">Powerful</h2>
							<p>Stores your information with a few steps allows other people to find you with a few clicks.</p>
						</div>
					</div>
					<div class="layoutFlex box horizontal featureGrid">
						<div class="featureIcon"><img src="/assets/feature_logos/privacy.svg" alt="User Friendly Icon"/></div>
						<div class="featureDescription">
							<h2 class="green">Privacy</h2>
							<p>Choose what to show off to the world, what to hide from other's eyes.<br/>You can change your decision anytime, anywhere.</p>
						</div>
					</div>
				</div>
				<div class="footer">
					&copy; 2021 Xuanao Zhao, MIT License Applied
					&nbsp;&nbsp;|&nbsp;&nbsp;
					<a target="_new" href="https://github.com/DIT202003G1/WebDev20023404/blob/main/LICENSE">View License</a>
					&nbsp;&nbsp;|&nbsp;&nbsp;
					<a href="mailto:20023404@imail.sunway.edu.my">Contact</a>
					&nbsp;&nbsp;|&nbsp;&nbsp;
					<a href="view-admin-login">Admin Login</a>
					&nbsp;&nbsp;|&nbsp;&nbsp;
					DIT202003 Web Developement
				</div>
			</div>
		</div>
		<?php echo "$includes_foots"; ?>
	</body>
</html>