<?php 
	include("includes/config.php");
	include("includes/adminHeader.php");
 ?>



<link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
	<div id="backgroundMain">

		<div id="pageChoiceContainer">
			<h2>Welcome to the Admin page for 'Not a Survey Engine'!</h2>

				<form id="userChoiceForm" action="admin.php" method="POST">
					<button type="submit" name="EditAccounts">Click here to View/Edit Accounts</button>
					<button type="submit" name="ViewSurveys">Click here to Edit your Surveys</button>
					<button type="submit" name="AddSurvey">Click here to Add a Survey</button>
					<button type="submit" name="LogOut">LOG OUT</button>

					<?php 
						if(isset($_POST['EditAccounts']))
						{
						     // View Account button was pressed
							//$usersQuery = mysqli_query($con, "SELECT id FROM users WHERE username='$userLoggedIn'");
							//$user = mysqli_fetch_array($usersQuery);

							header("Location: adminViewEdit.php");
						}
						else if(isset($_POST['LogOut']))
						{
							session_destroy();
							header("Location: register.php");
						}
						else if(isset($_POST['ViewSurveys']))
						{
							header("Location: adminSurvView.php");
						}
						else if(isset($_POST['AddSurvey']))
						{
							header("Location: adminSurvAdd.php");
						}
				 	?>
			 	</form>
		</div>

	</div>

</body>
</html>