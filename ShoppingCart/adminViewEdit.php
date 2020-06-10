<?php 
	include("includes/config.php");
	include("includes/adminHeader.php");
	include("includes/handlers/getInputValue.php");
	include("includes/classes/Constants.php");	// Error Constants
	include("includes/classes/Account.php");	// Account Class
	include("includes/classes/Item.php");		// Item Class

	// Create Account Class
	$account = new Account($con, $SQL_usersTable, $SQL_storeTable);

	include("includes/handlers/change-handler.php");
 ?>

	<link rel="stylesheet" type="text/css" href="assets/css/adminViewEdit.css">
	<!-- Import JS files and JQuery-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<div id="backgroundMain">

		<div id="pageChoiceContainer">
			<h2>Edit a Users Details</h2>

			<form id="userChoiceForm" action="admin.php" method="POST">
				<button type="submit" name="goBack">Click here to go back to the main page</button>
			</form>
			<br><br>

			<form id="userEditForm" action="adminViewEdit.php" method="GET">
				<?php
					$usersQuery = mysqli_query($con, "SELECT * FROM $SQL_usersTable ORDER BY signUpDate");
					echo "*Click on a username to edit details.*";
					$editUser = $userLoggedIn;

					// ####################################### User's info. #######################################
					while($user = mysqli_fetch_array($usersQuery)){
						echo "<table>
								<tr>
									<th>Username</th>
									<th>Firstname</th>
								    <th>Lastname</th> 
								    <th>Email</th>
								</tr>
							 	<tr>
							 		<td>
								 		<div class='getUser'>
											<input type='submit' name='userButton' value=" .$user['username']. ">
										</div>
									</td>

								    <td> ".$user['firstName']." </td>
								    <td> ".$user['lastName']." </td>
								    <td> ".$user['email']." </td>
						  		</tr>
							</table>";

							// ####################################### User's Cart #######################################
							$curItems = array();
							if(strlen($user['Cart']) > 0) $curItems= explode(",", $user['Cart']);
							$itemQ = array();

							$totCost=0;
							$currUser = array();

							if(count($curItems) > 0){
								for($i=0; $i < count($curItems); $i++){

									if(!in_array($curItems[$i], $itemQ)){
										$storeQuery = mysqli_query($con, "SELECT * FROM $SQL_storeTable WHERE id=$curItems[$i]");
										$store = mysqli_fetch_array($storeQuery);

										// Create Item Class
										$item = new Item($curItems[$i], $con, $user['username'], $store, $SQL_usersTable, $SQL_storeTable);

										echo "<table>
												<div class='gridViewItem'>
													<tr>
														<th>Qty.</th>
														<th>Item Name</th>
														<th>Price</th>
													    <th>Click to Remove</th> 
													</tr>
												 	<tr>
													    <td>".$item->GetQuantity()."</td>
													    <td>".$item->GetName()."</td>
													    <td>".$item->GetPrice()."</td>
													    <td>
													    	<div class='delItem'>
													    		"; array_push($currUser, $item->GetID(), $user['username']);
													    		echo" <button type='submit' name='delItem' value=".implode(",", $currUser).">REMOVE</button>
															</div></td>
										  			</tr>
										  		</div>
											</table>";
											$currUser = array();
										array_push($itemQ, $curItems[$i]);
									}

								}
							}

						if(isset($_GET['delItem']) && count($curItems) > 0) {
							// Delete item...
							// Get the selected items through POST
							$selected = $_GET['delItem'];
							$arr = explode(",", $selected);
							// Search in array for item and delete
							$usersQuery = mysqli_query($con, "SELECT * FROM $SQL_usersTable WHERE username='$arr[1]'");
							$user = mysqli_fetch_array($usersQuery);
							$uCart = explode(",", $user['Cart']);
							$idx = array_search($arr[0], $uCart);
							unset($uCart[$idx]);
							//Put item array back into SQL
							$myItems = implode(",", $uCart);
							$result = mysqli_query($con, "UPDATE $SQL_usersTable SET Cart='$myItems' WHERE username='$arr[1]'");
							header("Location: adminViewEdit.php");
						}
						echo "</br></br>";
					}
  				?>

  				<p>
				<?php echo $account->getError(Constants::$firstNameCharacters); ?>
				<label for="firstName" style="padding: 0px 13px">First Name</label>
				<input id="firstName" name="firstName" type="text" placeholder="Input new First Name" value="<?php getAdminInputValue('firstName') ?>">
				</p>

				<p>
					<?php echo $account->getError(Constants::$lastNameCharacters); ?>
					<label for="lastName" style="padding: 0px 14px">Last Name</label>
					<input id="lastName" name="lastName" type="text" placeholder="Input new Last Name" value="<?php getAdminInputValue('lastName') ?>">
				</p>

				<p>
					<?php echo $account->getError(Constants::$emailInvalid); ?>
					<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
					<?php echo $account->getError(Constants::$emailTaken); ?>
					<label for="email" style="padding: 0px 30px">Email</label>
					<input id="email" name="email" type="email" placeholder="Input new Email" value="<?php getAdminInputValue('email') ?>">
				</p>

				<p>
					<label for="email2" style="padding: 0px 2px">Confirm email</label>
					<input id="email2" name="email2" type="email2" placeholder="Input new Email" value="<?php getAdminInputValue('email2') ?>">
				</p>

				<input id="password" name="password" type="password" placeholder="*Input your password to apply*" value="OwO" style = "visibility: hidden">
				<input id="password2" name="password2" type="password" placeholder="*Input your password to apply*" value="OwO" style = "visibility: hidden">
				<br>

				<?php  
					if(isset($_GET['userButton'])) {
						$selected = $_GET['userButton'];
						echo "Now Editing: " . $selected . "<br>";
						echo "<button type='submit' name='AdminSubmitCh' value='$selected'>Save Changes</button>";
					}
  				?>

			</form>

		</div>

	</div>

</body>
</html>