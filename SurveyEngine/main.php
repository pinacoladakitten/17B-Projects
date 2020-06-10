<?php 
	include("includes/config.php");
	include("includes/mainHeader.php");
 ?>



<link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
	<div id="backgroundMain">

		<div id="pageChoiceContainer">
			<h2>Welcome to the main page for 'Not a Survey Engine'!</h2>

				<form id="userChoiceForm" action="main.php" method="POST">
					<button type="submit" name="EditAccount">Click here to Edit your Account</button>
					<button type="submit" name="ViewSurveys">Click here to take a Survey</button>
					<button type="submit" name="LogOut">LOG OUT</button>

					<?php 
						if(isset($_POST['EditAccount']))
						{
						     // View Account button was pressed
							//$usersQuery = mysqli_query($con, "SELECT id FROM users WHERE username='$userLoggedIn'");
							//$user = mysqli_fetch_array($usersQuery);

							header("Location: userInfo.php");
						}
						else if(isset($_POST['LogOut']))
						{
							session_destroy();
							header("Location: register.php");
						}
						else if(isset($_POST['ViewSurveys']))
						{
							header("Location: viewSurveys.php");
						}
				 	?>
			 	</form>
		</div>

	</div>

</body>
</html>