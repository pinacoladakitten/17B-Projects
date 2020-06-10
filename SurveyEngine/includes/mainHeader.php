<!DOCTYPE html>

<?php // Start the session for the user
	if(isset($_SESSION['userLogged']) && isset($_SESSION['userType'])) {
		$userLoggedIn = $_SESSION['userLogged'];
		$userType = $_SESSION['userType'];

		echo "<h3> Logged in as, ", $userType , ': ', $userLoggedIn, "</h3>";
	}
	else{
		header("Location: register.php");
	}

?>

<html>
<head>
	<title>Welcome to 'Not a Shopping Cart'</title>