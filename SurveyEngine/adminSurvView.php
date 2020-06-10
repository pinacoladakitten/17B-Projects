<?php 
	include("includes/config.php");
	include("includes/mainHeader.php");
	include("includes/handlers/getInputValue.php");
	include("includes/classes/Constants.php");	// Error Constants
	include("includes/classes/Account.php");	// Account Class

	// Create Account Class
	$account = new Account($con, $SQL_usersTable, $SQL_surveyTable, $SQL_xRefSurvAns);

	include("includes/handlers/change-handler.php");
 ?>

	<link rel="stylesheet" type="text/css" href="assets/css/adminSurveyResults.css">
</head>
<body>
	<div id="backgroundMain">

		<div id="pageChoiceContainer">
			<h2>Edit Surveys</h2>

			<form id="userChoiceForm" action="admin.php" method="POST">
				<button type="submit" name="goBack">Click here to go back to the main page</button>
			</form>
			<br><br>

			<form id="userEditForm" action="adminSurvView.php" method="POST">
				<?php
					$surveyQuery = mysqli_query($con, "SELECT * FROM $SQL_surveyTable");
					echo "**Click a server name for answers**";
					while($survey = mysqli_fetch_array($surveyQuery)){
						echo "<table>
								<tr>
									<th>Survey Name</th>
									<th>Question #</th>
									<th>Click to Remove</th>
								</tr>
							 	<tr>
								    <td>
								    	<div class='getSurvey'>
											<button type='submit' id='surveyResults' name='surveyResults' value=" .$survey['id']. ">".$survey['surveyName']."</button>
										</div>
									</td>
								    <td> ".$survey['questionAmt']." </td>
							    	<td>
									    <div class='delSurv'>
											<button type='submit' name='delSurv' value=" .$survey['id']. ">REMOVE</button>
										</div>
									</td>
						  		</tr>
							</table>";

						if(isset($_POST["delSurv"])) {
							$id = $_POST["delSurv"];
							mysqli_query($con, "DELETE FROM $SQL_surveyTable WHERE id='$id'");
							mysqli_query($con, "DELETE FROM $SQL_answersTable WHERE id='$id'");
							mysqli_query($con, "DELETE FROM $SQL_xRefSurvAns WHERE survey_id='$id'");
							header("Location: adminSurvView.php");
						}
					}

					if(isset($_POST["surveyResults"])) {
						$id = $_POST["surveyResults"];
						$surveyQuery = mysqli_query($con, "SELECT * FROM $SQL_surveyTable WHERE id='$id'");
						$survey = mysqli_fetch_array($surveyQuery);
						$name = $survey['surveyName'];

						$questions = explode("|", $survey['questions']);
						$answersA = explode("|", $survey['ansA']);
						$answersB = explode("|", $survey['ansB']);
						$answersC = explode("|", $survey['ansC']);
						$answersD = explode("|", $survey['ansD']);


						$amount = $survey['questionAmt'];

						$answersQuery = mysqli_query($con, "SELECT * FROM $SQL_answersTable WHERE id='$id'");
						$ans = mysqli_fetch_array($answersQuery);
						$answers = explode("|", $ans['answers']);

						for($i=0; $i < $amount; $i++){
							echo $questions[$i] . "</br>" . "</br>";

							echo " <class id='userAnswers' name='userAnswers'>
									<label for='A$i'>$answersA[$i]</label>
									". count(array_keys($answers, 'A'.$i)) ."
								</br>
									<label for='B$i'>$answersB[$i]</label>
									". count(array_keys($answers, 'B'.$i)) ."
								</br>
									<label for='C$i'>$answersC[$i]</label>
									". count(array_keys($answers, 'C'.$i)) ."
								</br>
									<label for='D$i'>$answersD[$i]</label>
									". count(array_keys($answers, 'D'.$i)) ."
								</br></br>
								</class>";


						}
					}
  				?>
  				<br>
			</form>
		</div>
	</div>

</body>
</html>