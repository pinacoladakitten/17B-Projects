<!DOCTYPE html>

<script src="assets/js/cookies.js"></script>

<?php // Included PHP Files
	include("includes/config.php");				// Config SQL
	include("includes/classes/Account.php");	// Account Class
	include("includes/classes/Constants.php");	// Error Constants
	include("includes/handlers/getInputValue.php");
	// Create Account Class
	$account = new Account($con, $SQL_usersTable, $SQL_surveyTable, $SQL_xRefSurvAns);

	include("includes/handlers/register-handler.php");	// Register-handler
	include("includes/handlers/login-handler.php");		// Login-handler
 ?>

<!-- Head and title-->
<html>
<head>
	<title>Welcome to 'Not a Survey Engine'</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">

	<!-- Import JS files and JQuery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>

</head>
<body>
	<?php // JS to hide register form if Logging in, and hide log in when Registering
		if(isset($_POST['registerButton'])) {
			echo '<script>
					$(document).ready(function(){
						$("#loginForm").hide();
						$("#registerForm").show();

					});
				</script>';
		} else {
			echo '<script>
					$(document).ready(function(){
						$("#loginForm").show();
						$("#registerForm").hide();

					});
				</script>';
		}

	 ?>

	<!-- Background and logging in container-->
	<div id="background">
		<div id="loginContainer">

		<h1 id='WelcomeText'>Welcome to 'Not a Survey Engine'!</h1>

			<form id="loginForm" action="register.php" method="POST">
				<h2>Login to your account</h2>
				<p>
					<?php echo $account->getError(Constants::$loginFailed); ?>
					<label for="loginUsername">Username</label>
					<input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. HelloWorld" value="<?php getInputValue('loginUsername') ?>" required>
				</p>

				<script type="text/javascript">
				 	if(checkCookie('username')) {
				 		document.getElementById("loginUsername").value = checkCookie('username');
				 	}
				 </script>

				<p>
					<label for="loginPassword">Password</label>
					<input id="loginPassword" name="loginPassword" type="password" placeholder="e.g. !12345ABC" required>
				</p>

				<script type="text/javascript">
				 	if(checkCookie('password')) {
				 		document.getElementById("loginPassword").value = checkCookie('password');
				 	}
				 </script>


				 <p>
					<label for="remInfoCookie">Remember login info.?</label>
					<input type="checkbox" name="remInfoCookie" id="remInfoCookie" value="<?php getInputValue('remInfoCookie') ?>">
				</p>

				<p>
					<input type="hidden" name="cookedCookie" id="cookedCookie" value="<?php getInputValue('cookedCookie') ?>">
					<script type="text/javascript">
						var myInfo = {name: "<?php getInputValue('loginUsername') ?>",
						password: "<?php getInputValue('loginPassword') ?>"};

						var myJSON = JSON.stringify(myInfo);
						document.getElementById("cookedCookie").value = myJSON;
					</script>
				</p>

				<button type="submit" name="loginButton">LOG IN</button>

				<div class="hasAccountText">
					<span id="hideLogin">Don't have an account yet? Click here to Sign Up.</span>
				</div>
			</form>

			<!-- <script src="assets/js/markScroll.js"></script>--->

		<!-- Registering form---->

			<form id="registerForm" action="register.php" method="POST">
				<h2>Create your account</h2>
				<p>
					<?php echo $account->getError(Constants::$userNameCharacters); ?>
					<?php echo $account->getError(Constants::$userNameTaken); ?>
					<label for="username">Username</label>
					<input id="username" name="username" type="text" placeholder="e.g. HelloWorld" value="<?php getInputValue('username') ?>" required>
				</p>

				<p>
					<?php echo $account->getError(Constants::$firstNameCharacters); ?>
					<label for="firstName">First Name</label>
					<input id="firstName" name="firstName" type="text" placeholder="e.g. Hello" value="<?php getInputValue('firstName') ?>" required>
				</p>

				<p>
					<?php echo $account->getError(Constants::$lastNameCharacters); ?>
					<label for="lastName">Last Name</label>
					<input id="lastName" name="lastName" type="text" placeholder="e.g. World" value="<?php getInputValue('lastName') ?>" required>
				</p>

				<p>
					<?php echo $account->getError(Constants::$emailInvalid); ?>
					<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
					<?php echo $account->getError(Constants::$emailTaken); ?>
					<label for="email">Email</label>
					<input id="email" name="email" type="email" placeholder="e.g. helloworld@markLehr.com" value="<?php getInputValue('email') ?>" required>
				</p>

				<p>
					<label for="email2">Confirm email</label>
					<input id="email2" name="email2" type="email2" placeholder="e.g. helloworld@markLehr.com" value="<?php getInputValue('email2') ?>" required>
				</p>

				<p>
					<?php echo $account->getError(Constants::$passwordsNotAlphanumeric); ?>
					<?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
					<?php echo $account->getError(Constants::$passwordCharacters); ?>
					<label for="password">Password</label>
					<input id="password" name="password" type="password" placeholder="e.g. !12345ABC" value="<?php getInputValue('password') ?>" required>
				</p>

				<p>
					<label for="password2">Confirm password</label>
					<input id="password2" name="password2" type="password" placeholder="e.g. !12345ABC" value="<?php getInputValue('password2') ?>" required>
				</p>

				<button type="submit" name="registerButton">SIGN UP</button>

				<div class="hasAccountText">
					<span id="hideRegister">Already have an account? Click here to Login.</span>
				</div>
			</form>


		<!-- Extra text that doesn't matter---->
		</div>

		<div id="loginText">

		</div>

	</div>
</body>
</html>