<?php 
	include("includes/config.php");
	include("includes/mainHeader.php");
	include("includes/handlers/getInputValue.php");
	include("includes/classes/Constants.php");	// Error Constants
	include("includes/classes/Account.php");	// Account Class

	// Create Account Class
	$account = new Account($con, $SQL_usersTable, $SQL_surveyTable, $SQL_xRefSurvAns);

	include("includes/handlers/change-handler.php");
 ?>

	<link rel="stylesheet" type="text/css" href="assets/css/userInfo.css">
</head>
<body>
	<div id="backgroundMain">

		<div id="pageChoiceContainer">
			<h2>Edit your User Details</h2>

			<form id="userChoiceForm" action="main.php" method="POST">
				<button type="submit" name="goBack">Click here to go back to the main page</button>
			</form>
			<br><br>

			<form id="userEditForm" action="userInfo.php" method="POST">
				<?php
					$usersQuery = mysqli_query($con, "SELECT * FROM $SQL_usersTable WHERE username='$userLoggedIn'");
					$user = mysqli_fetch_array($usersQuery);
					echo "<table>
							<tr>
								<th>Username</th>
								<th>Firstname</th>
							    <th>Lastname</th> 
							    <th>Email</th> 
							</tr>
						 	<tr>
							    <td> ".$user['username']." </td>
							    <td> ".$user['firstName']." </td>
							    <td> ".$user['lastName']." </td>
							    <td> ".$user['email']." </td>
					  		</tr>
						</table>";
					/*echo "<table>
							<tr>
								<th>Cart</th>
							</tr>
						</table>";*/
  				?>
  				<br>
  				<p>
  					<label id="starMeaning">* = Required to continue. Leave box blank if you do not want to modify</label>
  				</p>

				<?php echo $account->getError(Constants::$passwordFailed); ?>
  				<p>
  					<?php echo $account->getError(Constants::$firstNameCharacters); ?>
	  				<label for="firstName" style="padding: 0px 13px">First Name</label>
	  				<input id="firstName" name="firstName" type="text" placeholder="Input new First Name" value="<?php getInputValue('firstName') ?>">
  				</p>

  				<p>
	  				<?php echo $account->getError(Constants::$lastNameCharacters); ?>
					<label for="lastName" style="padding: 0px 14px">Last Name</label>
					<input id="lastName" name="lastName" type="text" placeholder="Input new Last Name" value="<?php getInputValue('lastName') ?>">
				</p>

				<p>
					<?php echo $account->getError(Constants::$emailInvalid); ?>
					<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
					<?php echo $account->getError(Constants::$emailTaken); ?>
					<label for="email" style="padding: 0px 30px">Email</label>
					<input id="email" name="email" type="email" placeholder="Input new Email" value="<?php getInputValue('email') ?>">
				</p>

				<p>
					<label for="email2" style="padding: 0px 2px">Confirm email</label>
					<input id="email2" name="email2" type="email2" placeholder="Input new Email" value="<?php getInputValue('email2') ?>">
				</p>

				<p>
					<?php echo $account->getError(Constants::$passwordsNotAlphanumeric); ?>
					<?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
					<?php echo $account->getError(Constants::$passwordCharacters); ?>
					<label for="password" style="padding: 0px 30px">*Password</label>
					<input id="password" name="password" type="password" placeholder="*Input your password to apply*" value="<?php getInputValue('password') ?>" required>
				</p>

				<p>
					<label for="password2">*Confirm password</label>
					<input id="password2" name="password2" type="password" placeholder="*Input your password to apply*" value="<?php getInputValue('password2') ?>" required>
				</p>

  				<br><br>
				<button type="submit" name="SubmitChanges">Save Changes</button>
			</form>

		</div>

	</div>

</body>
</html>