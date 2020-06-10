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

	<link rel="stylesheet" type="text/css" href="assets/css/userInfo.css">
</head>
<body>
	<div id="backgroundMain">

		<div id="pageChoiceContainer">
			<h2>Take a Survey</h2>

			<form id="userChoiceForm" action="main.php" method="POST">
				<button type="submit" name="goBack">Click here to go back to the main page</button>
			</form>
			<br><br>

			<form id="surveyChooseForm" action="viewSurveys.php" method="GET">
				<?php
					$surveyQuery = mysqli_query($con, "SELECT * FROM $SQL_surveyTable");
					while($survey = mysqli_fetch_array($surveyQuery)){
						echo "<table>
								<tr>
									<th>Survey Name</th>
									<th>Question Amt. #</th>
								</tr>
							 	<tr>
								    <td>
									    <div class='getSurvey'>
											<button id='surveyTake' name='surveyTake' value=" .$survey['id']. ">".$survey['surveyName']."</button>
										</div>
									</td>
								    <td> ".$survey['questionAmt']." </td>
						  		</tr>
							</table>";
						}
  				?>
  				<br>
  			</form>

  			<form id="surveyTakeForm" action="viewSurveys.php" method="POST">
  				<?php 
					if(isset($_GET["surveyTake"])) {
						$id = $_GET["surveyTake"];
						$surveyQuery = mysqli_query($con, "SELECT * FROM $SQL_surveyTable WHERE id='$id'");
						$survey = mysqli_fetch_array($surveyQuery);
						$name = $survey['surveyName'];

						$questions = explode("|", $survey['questions']);
						$answersA = explode("|", $survey['ansA']);
						$answersB = explode("|", $survey['ansB']);
						$answersC = explode("|", $survey['ansC']);
						$answersD = explode("|", $survey['ansD']);

						$amount = count($questions);

						for($i=0; $i < $amount-1; $i++){
							echo $questions[$i] . "</br>" . "</br>";

							echo "<input type='radio' id='A$i' name='ans$i' value=A$i> <label for='A$i'>$answersA[$i]</label>
								</br>
								<input type='radio' id='B$i' name='ans$i' value=B$i> <label for='B$i'>$answersB[$i]</label>
								</br>
								<input type='radio' id='C$i' name='ans$i' value=C$i> <label for='C$i'>$answersC[$i]</label>
								</br>
								<input type='radio' id='D$i' name='ans$i' value=D$i> <label for='D$i'>$answersD[$i]</label>
								</br></br>";
						}

						echo "	<input id='surveyID' name='surveyID' type='hidden' value=$id>
								<input id='QuesAmt' name='QuesAmt' type='hidden' value=$amount>
								<input id='name' name='name' type='hidden' value=$name>
							<button type='submit' name='submitUserSurvey'>Submit</button>
						";
					}

					if(isset($_POST['submitUserSurvey'])) {
						$id = $_POST['surveyID'];
						$name = $_POST['name'];
						$answers = "";
						$amount = $_POST['QuesAmt'];

						for($i=0; $i < $amount-1; $i++){
							$answers .= $_POST['ans'.$i] . "|";
						}

						$survey = new Survey($con, $name, $amount, $SQL_usersTable, $SQL_surveyTable, $SQL_xRefSurvAns);
						$result = $survey->submitSurveyAnswers($id, $answers, $SQL_answersTable);

						echo $result ? "Survey successfully submitted!" : "There was an issue submitting the survey";
					}
  			 	?>
  			</form>
		</div>

	</div>

</body>
</html>