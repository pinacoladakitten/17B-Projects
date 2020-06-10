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

	if(isset($_POST['registerButton'])) {
		// Register button was pressed
		$username =  sanitizeFormUsername($_POST['username']);
		$firstName = sanitizeFormString($_POST['firstName']);
		$lastName =  sanitizeFormString($_POST['lastName']);
		$email =     sanitizeFormString($_POST['email']);
		$email2 =    sanitizeFormString($_POST['email2']);
		$password =  sanitizeFormPassword($_POST['password']);
		$password2 = sanitizeFormPassword($_POST['password2']);

		// If successful then register the account
		$wasSuccessful = $account->register($username, $firstName, $lastName, $email, $email2, $password, $password2);

		if($wasSuccessful) {
			$_SESSION['userLoggedIn'] = $username;
			header("Location: main.php");
		}
	}



 ?>