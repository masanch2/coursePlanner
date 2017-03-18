<?php

	session_start();

	// Output completed class array from SESSION array
	if (isset($_SESSION['completed'])) {
		echo json_encode($_SESSION['completed']);
	
	// If SESSION array is empty
	} else {
		echo '[]';
	} 

?>