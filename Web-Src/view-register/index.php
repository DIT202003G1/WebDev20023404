<!DOCTYPE html>

<!-- Design by Xuanao Zhao 20023404. MIT License Applied -->

<?php require "/opt/lampp/htdocs/php-includes/common-includes.inc.php" ?>

<html>
	<head>
		<?php echo "$includes_head"; ?>
		<link rel="stylesheet" type="text/css" href="/view-register/register.css">
		<script type="text/javascript" src="/view-register/register.js"></script>
		<title>Sign Up - ACMS Pro</title>
	</head>
	<body>
		<div class="layoutCenter container box">
			<div class="layoutCenter center lightBox">
				<div class="layoutFlex container box horizontal lightBoxContent">
					<div class="primaryOption">
						<div class="titleFrame primary">
							<h1 class="formTitle primary">Sign Up</h1>
						</div>
						<div>
							<form>
								<div class="inputGroup">
									<div class="inputComponent content">
										<div class="label">
											<i class="fas fa-user-alt fa-2x"></i>
										</div>
										<div class="input">
											<input type="text" placeholder="Student ID" />
										</div>
									</div>
								</div>
								<div>
									<div class="doubleInputGroup inputGroup first">
										<div class="inputComponent content">
											<div class="label">
												<i class="fas fa-bars fa-2x"></i>
											</div>
											<div class="input">
												<input type="text" placeholder="First Name" />
											</div>
										</div>
									</div>
									<div class="doubleInputGroup inputGroup second">
										<div class="inputComponent content">
											<div class="label">
												<i class="fas fa-bars fa-2x"></i>
											</div>
											<div class="input">
												<input type="text" placeholder="Last Name" />
											</div>
										</div>
									</div>
								</div>
								<div class="inputGroup">
									<div class="inputComponent content">
										<div class="label">
											<i class="fas fa-bars fa-2x"></i>
										</div>
										<div class="input">
											<input type="text" placeholder="Middle Name (optional)" />
										</div>
									</div>
								</div>
								<div>
									<div class="doubleInputGroup inputGroup first">
										<div class="inputComponent content">
											<div class="label">
												<i class="fas fa-book-open fa-2x"></i>
											</div>
											<div class="input">
												<input type="text" placeholder="Course ID" />
											</div>
										</div>
									</div>
									<div class="doubleInputGroup inputGroup second">
										<div class="inputComponent content">
											<div class="label">
												<i class="fas fa-calendar fa-2x"></i>
											</div>
											<div class="input">
												<input type="text" placeholder="Intake" />
											</div>
										</div>
									</div>
								</div>
								<div class="inputGroup">
									<div class="inputComponent content">
										<div class="label">
											<i class="fas fa-key fa-2x"></i>
										</div>
										<div class="input">
											<input type="password" placeholder="Password" />
										</div>
									</div>
								</div>
								<div class="inputGroup">
									<div class="inputComponent content">
										<div class="label">
											<i class="fas fa-key fa-2x"></i>
										</div>
										<div class="input">
											<input type="password" placeholder="Re-Enter Password" />
										</div>
									</div>
								</div>
								<div class="inputGroup">
									<input type="submit" value="Sign In" class="light" />
								</div>
							</form>
						</div>
					</div>
					<div class="secondaryOption">
						<div class="titleFrame secondary">
							<h1 class="formTitle secondary">Alread has an account?</h1>
						</div>
						<p class="textContent secondary">
							Sign in with your id and password now!
						</p>
						<button class="dark button secondary noselect" onclick="gotoRegister()">Sign In</button>
					</div>
				</div>
			</div>
		</div>
		<?php echo "$includes_foots"; ?>
	</body>
</html>