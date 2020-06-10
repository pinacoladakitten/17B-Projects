<?php 

	class Account{
		// Init Vars
		private $con;
		private $errorArray;
		private $SQL_usersTable;
		private $SQL_survey;
		private $SQL_xRefSurvAns;

		// Create an array that looks at all errors when creating an account
		public function __construct($con, $SQL_usersTable, $SQL_surveyTable, $SQL_xRefSurvAns) {
			$this->con = $con;
			$this->errorArray = array();
			$this->SQL_usersTable =     $SQL_usersTable;
			$this->SQL_surveyTable =    $SQL_surveyTable;
			$this->SQL_xRefSurvAns =   $SQL_xRefSurvAns;
		}

		// (LOGIN FUNCTION) Check the SQL Query to see if username and password are correct
		public function login($un, $pw) {
			$pw = md5($pw);
			$query = mysqli_query($this->con, "SELECT * FROM $this->SQL_usersTable WHERE username='$un' AND password='$pw'");

			// Check the query to see if it's correct
			if(mysqli_num_rows($query)==1) {
				return true;
			} else {
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		// (REGISTER FUNCTION) Validating user details to insert
		public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
			// First validate each input
			$this->validateUserName($un);
			$this->validateFirstName($fn);
			$this->validateLastName($ln);
			$this->validateEmails($em, $em2);
			$this->validatePasswords($pw, $pw2);

			if(empty($this->errorArray)) {
				// Insert into data base
				return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
			} else {
				return false;
			}
		}

		// Check to see which error occured in the error array
		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		// (INSERT INTO SQL) Inserting user's details into SQL server
		private function insertUserDetails($un, $fn, $ln, $em, $pw) {
			$admin=false;
			$encryptedPw = md5($pw);
			$profilePic = "assets/images/profile-pic/terry.png";
			$date = date("Y-m-d");

			if($un=="admin12345"){$admin=true;}

			$result = mysqli_query($this->con, "INSERT INTO $this->SQL_usersTable VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic', '$admin')");

			return $result;
		}




		// (CHANGE INFO FUNCTION) Validating user details to change
		public function changeInfo($un, $fn, $ln, $em, $em2, $pw, $pw2, $ad=false) {
			// First validate each input
			$this->validateFirstName($fn);
			$this->validateLastName($ln);
			$this->valSameEmails($em, $em2);
			if(!$ad)$this->validatePasswords($pw, $pw2);

			// Check and see if email is available or is for this user
			$checkEmailQuery = mysqli_query($this->con, "SELECT * FROM $this->SQL_usersTable WHERE email='$em'");
			$emails = mysqli_fetch_array($checkEmailQuery);
			//
			if($emails['username'] != $un) {
				$this->validateEmails($em, $em2);
			}

			// Then look too see if the password is right
			$ad ? $encryptedPw = $pw : $encryptedPw = md5($pw);
			$query = mysqli_query($this->con, "SELECT * FROM $this->SQL_usersTable WHERE username='$un' AND password='$encryptedPw'");

			// If no errors
			if(empty($this->errorArray))
			{
				// If right password
				if(mysqli_num_rows($query)==1){
					// Edit the data base
					return $this->editUserDetails($un, $fn, $ln, $em, $pw);
				}
				else{
					array_push($this->errorArray, Constants::$passwordFailed);
					return false;
				}
			} else {
				return false;
			}
		}

		// (EDIT IN SQL) Inserting edited user's details into SQL server
		private function editUserDetails($un, $fn, $ln, $em, $pw) {
			$profilePic = "assets/images/profile-pic/terry.png";

			$result = mysqli_query($this->con, "UPDATE $this->SQL_usersTable SET firstName='$fn', lastName='$ln', email='$em' WHERE username='$un'");

			return $result;
		}

		// Validation Functions

		// Username
		private function validateUserName($un) {
			// If valid username
			if(strlen($un) > 25 || strlen($un) < 5) {
				array_push($this->errorArray, Constants::$userNameCharacters);
				return;
			}

			// Then check the SQL Query to see if taken
			$checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM $this->SQL_usersTable WHERE username = '$un'");

			if(mysqli_num_rows($checkUsernameQuery) != 0) {
				array_push($this->errorArray, Constants::$userNameTaken);
				return;
			}
		}

		// First Name
		private function validateFirstName($fn) {
			if(strlen($fn) > 25 || strlen($fn) < 2) {
				array_push($this->errorArray, Constants::$firstNameCharacters);
				return;
			}
		}

		// Last Name
		private function validateLastName($ln) {
			if(strlen($ln) > 25 || strlen($ln) < 2) {
				array_push($this->errorArray, Constants::$lastNameCharacters);
				return;
			}
		}

		// Emails
		private function validateEmails($em, $em2) {
			// First check to see if emails 1 & 2 are matching
			if($em != $em2) {
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return;
			}

			// Then check to see if the email is valid syntax wise
			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}

			// Then check the SQL query to see if the email is taken
			$checkEmailQuery = mysqli_query($this->con, "SELECT email FROM $this->SQL_usersTable WHERE email='$em'");
			if(mysqli_num_rows($checkEmailQuery) != 0) {
				array_push($this->errorArray, Constants::$emailTaken);
				return;
			}
		}

		// Emails Validate When Changing
		private function valSameEmails($em, $em2) {
			// First check to see if emails 1 & 2 are matching
			if($em != $em2) {
				array_push($this->errorArray, Constants::$emailsDoNotMatch);
				return;
			}

			// Then check to see if the email is valid syntax wise
			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}
		}

		// Passwords
		private function validatePasswords($pw, $pw2) {
			// First check to see if both passwords are the same
			if($pw != $pw2) {
				array_push($this->errorArray, Constants::$passwordsDoNoMatch);
				return;
			}

			// Then check to see if the password is valid syntax wise
			if(preg_match('/[^A-Za-z0-9!$%&]/', $pw)) {
				array_push($this->errorArray, Constants::$passwordsNotAlphanumeric);
				return;
			}

			// Then check the length of the password
			if(strlen($pw) > 25 || strlen($pw) < 5) {
				array_push($this->errorArray, Constants::$passwordCharacters);
				return;
			}
		}


	}

 ?>