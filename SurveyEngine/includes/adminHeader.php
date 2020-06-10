<!DOCTYPE html>

<?php // Start the session for the user
	if(isset($_SESSION['userLogged']) && isset($_SESSION['userType'])) {
		if($_SESSION['userType'] == 'admin'){
			$userLoggedIn = $_SESSION['userLogged'];
			$userType = $_SESSION['userType'];

			echo "<h3> Logged in as, ", $userType , ': ', $userLoggedIn, "</h3>";
		}
		else{
			header("Location: register.php");
		}
	}
	else{
		header("Location: register.php");
	}
?>

<html>
<head>
	<title>Admin of 'Not a Shopping Cart'</title>