<?php 
	include("includes/config.php");
	include("includes/mainHeader.php");
	include("includes/handlers/getInputValue.php");
	include("includes/classes/Constants.php");	// Error Constants
	include("includes/classes/Account.php");	// Account Class
	include("includes/classes/Survey.php");	// Survey Class

	// Create Account Class
	$account = new Account($con, $SQL_usersTable, $SQL_surveyTable, $SQL_xRefSurvAns);

	include("includes/handlers/change-handler.php");
 ?>

	<link rel="stylesheet" type="text/css" href="assets/css/adminSurveyAdd.css">
</head>
<body>
	<div id="backgroundMain">

		<div id="pageChoiceContainer">
			<h2>Add Survey</h2>

			<form id="userChoiceForm" action="admin.php" method="GET">
				<button type="submit" name="goBack">Click here to go back to the main page</button>
			</form>
			<br><br>

			<form id="surveyAddForm" action="adminSurvAdd.php" method="GET">
				<p>
					<label for="surveyName">Enter a Survey Name</label>
					<input id="surveyName" name="surveyName" type="text" placeholder="HelloWorld" value="<?php getAdminInputValue('surveyName') ?>" required>
				</p>
				<p>
					<label for="questionNum">Enter a question amount</label>
					<input id="questionNum" name="questionNum" type="text" placeholder="e.g. 1,2,3" value="<?php getAdminInputValue('questionNum') ?>" required>
				</p>

				<button type="submit" name="submitButton">Submit</button>
			</form>

				<?php
					if(isset($_GET['submitButton']))
					{
						$name = $_GET['surveyName'];
						echo "Now adding: $name". "</br></br>";

						$amount = $_GET['questionNum'];

						for($i=1; $i < $amount+1; $i++){
							echo " Question $i

								<class id='surveyCreate' name='surveyCreate'>

									<form id='surveySubmit' action='adminSurvAdd.php' method='POST'>

										<input id='surveyName' name='surveyName' type='hidden' value=$name>
										<input id='questionNum' name='questionNum' type='hidden' value=$amount>

										<p>
											<label for='question$i'>Enter the question</label></br>
											<textarea id='question$i' name='question$i' required placeholder='e.g. What is my name?' rows='5' cols='30'
											value=". getInputValue('question$i') ."></textarea>
										</p>".

										"<p>
											<label for='ansA$i'>Enter answer A</label></br>
											<textarea id='ansA$i' name='ansA$i' placeholder='e.g. What is my name?' rows='5' cols='30'
											required value=". getInputValue('ansA$i') ."></textarea>
										</p>".

										"<p>
											<label for='ansB$i'>Enter answer B</label></br>
											<textarea id='ansB$i' name='ansB$i' placeholder='e.g. What is this bunny's name?' rows='5' cols='30'
											required value=". getInputValue('ansB$i') ."></textarea>
										</p>".

										"<p>
											<label for='ansC$i'>Enter answer C</label></br>
											<textarea id='ansC$i' name='ansC$i' placeholder='e.g. What is your name?' rows='5' cols='30'
											required value=".getInputValue('ansC$i') ."></textarea>
										</p>".

										"<p>
											<label for='ansD$i'>Enter answer D</label></br>
											<textarea id='ansD$i' name='ansD$i' placeholder='e.g. Who what when where why?' rows='5' cols='30'
											required value=". getInputValue('ansD$i') ."></textarea>
										</p>".

								"</class>";
						}

						echo "<button type='submit' name='surveyButton'>Submit</button>
						</form>";
					}

					if(isset($_POST['surveyButton'])) {
						$name = $_POST['surveyName'];
						$amount = $_POST['questionNum'];

						$survey = new Survey($con, $name, $amount, $SQL_usersTable, $SQL_surveyTable, $SQL_xRefSurvAns);

						$result=$survey->getSurveyData($SQL_answersTable);

						echo $result ? "Survey successfully submitted!" : "There was an issue submitting the survey";
					}
  				?>
  				<br>
		</div>

	</div>

</body>
</html>