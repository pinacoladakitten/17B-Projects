<?php 
	include("includes/config.php");
	include("includes/mainHeader.php");
	include("includes/classes/Account.php");	// Account Class
	include("includes/handlers/getInputValue.php");

	// Create Account Class
	$account = new Account($con, $SQL_usersTable, $SQL_storeTable);

	include("includes/handlers/addItem-handler.php");
 ?>

	<link rel="stylesheet" type="text/css" href="assets/css/cartMenu.css">
</head>
<body>
	<div id="backgroundMain">

		<div id="pageChoiceContainer">
			<h2>Edit your fantastic products!</h2>

			<form id="userChoiceForm" action="admin.php" method="POST">
				<button type="submit" name="goBack">Click here to go back to the main page</button>
			</form>
			<br><br>

			<form id="cartDelForm" action="adminStoreView.php" method="POST">
				<?php
					$storeQuery = mysqli_query($con, "SELECT * FROM $SQL_storeTable");
					$ItemQ = array();

					while($store = mysqli_fetch_array($storeQuery)){
						echo "<table>
								<div class='gridViewItem'>
									<tr>
										<th>Item Name</th>
										<th>Price</th>
									    <th>Preview</th> 
									    <th>Click to Remove</th> 
									</tr>
								 	<tr>
									    <td> ".$store['itemName']." </td>
									    <td> ".$store['price']." </td>
									    <td>
								    		<img id='itemImg' src=" . $store['image'] . ">
									    </td>
									    <td>
									    	<div class='delItem'>
												<button type='submit' name='delItem' value=".$store['id'].">REMOVE</button>
											</div></td>
						  			</tr>
						  		</div>
							</table>";
					}

					if(isset($_POST['delItem'])) {
						// Get the item
						$selected = $_POST['delItem'];
						// Delete the item from SQL
						$storeQueryDel = mysqli_query($con, "DELETE FROM $SQL_storeTable WHERE id='$selected'");
						header("Location: adminStoreView.php");
					}
  				?>
  				<br>
			</form>

			<form id="cartAddForm" action="adminStoreView.php" method="GET">
  				<h2>Add New Item:</h2>
  				<p>
					<label for="ItemName" style="padding: 0px 6px">Item Name</label>
					<input id="ItemName" name="ItemName" type="text" placeholder="Input Item Name" value="<?php getAdminInputValue('ItemName') ?>" required>
				</p>
				<p>
					<label for="ItemPrice" style="padding: 0px 9px">Item Price</label>
					<input id="ItemPrice" name="ItemPrice" type="text" placeholder="Input Item Price" value="<?php getAdminInputValue('ItemPrice') ?>" required>
				</p>
				<p>
					<label for="ItemImage" style="padding: 0px 5px">Item Image</label>
					<input id="ItemImage" name="ItemImage" type="text" placeholder="Input Link to Item Image" value="<?php getAdminInputValue('ItemImage') ?>" required>
				</p>

				<button type='submit' name='StoreAdd'>Add Item</button>
			</form>

		</div>

	</div>

</body>
</html>