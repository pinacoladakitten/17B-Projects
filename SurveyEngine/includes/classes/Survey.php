<?php 

	include("includes/serverStuff.php");

	class Survey{
		// Init Vars
		private $con;
		private $questionAmt;
		private $surveyName;
		private $SQL_usersTable;
		private $SQL_surveyTable;
		private $SQL_xRefSurvAns;

		// Create an array that looks at all errors when creating an account
		public function __construct($con, $surveyName, $questionAmt, $SQL_usersTable, $SQL_surveyTable, $SQL_xRefSurvAns) {
			$this->con = $con;
			$this->questionAmt =   $questionAmt;
			$this->surveyName =    $surveyName;
			$this->SQL_usersTable =     $SQL_usersTable;
			$this->SQL_surveyTable =    $SQL_surveyTable;
			$this->SQL_xRefSurvAns =   $SQL_xRefSurvAns;
		}

		// Strip any implode explode tags
		public function sanitizeFormString($inputText) {
			$inputText = strip_tags($inputText);
			$inputText = str_replace("|", "/", $inputText);
			return $inputText;
		}

		public function getSurveyData($SQL_answersTable) {
			$questions="";
			$ansA="";
			$ansB="";
			$ansC="";
			$ansD="";

			if(isset($_POST['surveyButton'])) 
			{
				for($i=1; $i < $this->questionAmt+1; $i++) {
					$questions .= $this->sanitizeFormString($_POST['question' . $i]) . "|";

					$ansA.=$this->sanitizeFormString($_POST['ansA' . $i])."|";
					$ansB.=$this->sanitizeFormString($_POST['ansB' . $i])."|";
					$ansC.=$this->sanitizeFormString($_POST['ansC' . $i])."|";
					$ansD.=$this->sanitizeFormString($_POST['ansD' . $i])."|";

				}
			}


			$result = $this->submitSurveyData($this->surveyName, $questions, $ansA, $ansB, $ansC, $ansD, $this->questionAmt, $SQL_answersTable);
			return $result;
		}

		public function submitSurveyData($surveyName, $questions, $ansA, $ansB, $ansC, $ansD, $qAmt, $SQL_answersTable) {
			$result = mysqli_query($this->con, "INSERT INTO $this->SQL_surveyTable VALUES 
				('', '$surveyName', '$questions', '$ansA', '$ansB', '$ansC', '$ansD', '$qAmt')");
			$sID = mysqli_insert_id($this->con);

			$ans_result = mysqli_query($this->con, "INSERT INTO $SQL_answersTable VALUES ('$sID', '')");

			$xref_result = mysqli_query($this->con, "INSERT INTO $this->SQL_xRefSurvAns VALUES 
				('', '$sID', '$sID')");

			return $result*$xref_result*$ans_result;
		}

		public function submitSurveyAnswers($surveyID, $answers, $SQL_answersTable) {
			$answersQuery = mysqli_query($this->con, "SELECT * FROM $SQL_answersTable WHERE id='$surveyID'");
			$ans = mysqli_fetch_array($answersQuery);

			$ansAns = $ans['answers'];
			$ansAns .= $answers;

			$result = mysqli_query($this->con, "UPDATE $SQL_answersTable SET answers='$ansAns' WHERE id='$surveyID'");

			return $result;
		}

	}

 ?>