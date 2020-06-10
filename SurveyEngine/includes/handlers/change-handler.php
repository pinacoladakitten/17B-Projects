<?php 
	
	// Strip any SQL tags from the password
	function sanitizeFormPassword($inputText) {
		$inputText = strip_tags($inputText);
		return $inputText;
	}

	// Strip any SQL tags from the username
	function sanitizeFormUsername($inputText) {
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		return $inputText;
	}

	// Strip any SQL tags and spaces from selected string
	function sanitizeFormString($inputText) {
		$inputText = strip_tags($inputText);
		$inputText = str_replace(" ", "", $inputText);
		$inputText = ucfirst(strtolower($inputText));
		return $inputText;
	}

	// -------------------USER CHANGES-------------------
	if(isset($_POST['SubmitChanges'])) {
		// Get User Data
		$usersQuery = mysqli_query($con, "SELECT * FROM $SQL_usersTable WHERE username='$userLoggedIn'");
		$user = mysqli_fetch_array($usersQuery);

		// Register button was pressed
		$username =  $userLoggedIn;
		$firstName = sanitizeFormString($_POST['firstName']);
		$lastName =  sanitizeFormString($_POST['lastName']);
		$email = 	 sanitizeFormString($_POST['email']);
		$email2 = 	 sanitizeFormString($_POST['email2']);

		// Users need to type in password
		$password =  sanitizeFormString($_POST['password']);
		$password2 = sanitizeFormString($_POST['password2']);

		// Check if any are blank
		$firstName == "" ? $firstName = $user['firstName'] : $firstName=$firstName;
		$lastName  == "" ? $lastName  = $user['lastName'] : $lastName=$lastName;
		$email     == "" ? $email     = $user['email'] : $email=$email;
		$email2    == "" ? $email2    = $user['email'] : $email2=$email2;

		// If successful then register the account
		$wasSuccessful = $account->changeInfo($username, $firstName, $lastName, $email, $email2, $password, $password2);

		if($wasSuccessful) {
			echo "All changes saved to database successfully!";
		}
	}	// -------------------ADMIN CHANGES-------------------
	else if (isset($_GET['AdminSubmitCh'])) {
		// Get User Data
		$uName = $_GET['AdminSubmitCh'];
		$usersQuery = mysqli_query($con, "SELECT * FROM $SQL_usersTable WHERE username='$uName'");
		$user = mysqli_fetch_array($usersQuery);

		// Register button was pressed
		$username  =  $uName;
		$firstName = sanitizeFormString($_GET['firstName']);
		$lastName  = sanitizeFormString($_GET['lastName']);
		$email     = sanitizeFormString($_GET['email']);
		$email2    = sanitizeFormString($_GET['email2']);

		// Admins do not need the user's password
		$password =  $user['password'];
		$password2 = $user['password'];

		// Check if any are blank
		$firstName == "" ? $firstName = $user['firstName'] : $firstName=$firstName;
		$lastName  == "" ? $lastName  = $user['lastName'] : $lastName=$lastName;
		$email     == "" ? $email     = $user['email'] : $email=$email;
		$email2    == "" ? $email2    = $user['email'] : $email2=$email2;

		// If successful then register the account
		$wasSuccessful = $account->changeInfo($username, $firstName, $lastName, $email, $email2, $password, $password2, true);

		if($wasSuccessful) {
			echo "All changes saved to database successfully!";
		}
	}



 ?>