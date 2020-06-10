<?php 

	if (isset($_POST['remInfoCookie'])) {
		echo '<script language="javascript">';
		echo 'var myJsonCook ='.$_POST['cookedCookie'].';';
		echo 'makeCookie.cook("username", myJsonCook.name);';
		echo 'makeCookie.cook("password", myJsonCook.password);';
		echo '</script>';
	}
	else if(isset($_POST['loginButton']) && !isset($_POST['remInfoCookie'])){
		echo '<script language="javascript">';
		echo 'makeCookie.uncook("username");';
		echo 'makeCookie.uncook("password");';
		echo '</script>';
	}

	if(isset($_POST['loginButton'])){
		// Login button was pressed
		$username = $_POST['loginUsername'];
		$password = $_POST['loginPassword'];
		$userType = "user";

		$result = $account->login($username, $password);

		$con; $admin=false;
		$adminQuery = mysqli_query($con, "SELECT * FROM $SQL_usersTable WHERE username='$username' AND admin='1'");

		if (mysqli_num_rows($adminQuery)==1) {$admin=true;}

		if($result == true) {
			if(!$admin){
				$_SESSION['userType'] = $userType;
				$_SESSION['userLogged'] = $username;
				echo '<script language="javascript">';
				echo 'window.location.assign("main.php")';
				echo '</script>';
			}
			else {
				$userType = "admin";
				$_SESSION['userType'] = $userType;
				$_SESSION['userLogged'] = $username;
				echo '<script language="javascript">';
				echo 'window.location.assign("admin.php")';
				echo '</script>';
			}
		}
	}


 ?>