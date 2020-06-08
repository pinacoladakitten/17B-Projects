<?php 
	include("includes/config.php");
	include("includes/adminHeader.php");
 ?>



<link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
	<div id="backgroundMain">

		<div id="pageChoiceContainer">
			<h2>Welcome to the Admin page for 'Not a Shopping Cart'!</h2>

				<form id="userChoiceForm" action="admin.php" method="POST">
					<button type="submit" name="EditAccounts">Click here to View/Edit Accounts</button>
					<button type="submit" name="ViewStore">Click here to Edit the Store</button>
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
						else if(isset($_POST['ViewStore']))
						{
							header("Location: adminStoreView.php");
						}
				 	?>
			 	</form>
		</div>

	</div>

</body>
</html>