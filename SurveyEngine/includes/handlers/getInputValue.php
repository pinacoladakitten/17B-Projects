<?php 
// Get a value through POST
	function getInputValue($name){
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}

	function getAdminInputValue($name){
		if(isset($_GET[$name])) {
			echo $_GET[$name];
		}
	}

 ?>