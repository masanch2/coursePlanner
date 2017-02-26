<?php

	session_start();

	if (isset($_SESSION['completed'])) {
		echo json_encode($_SESSION['completed']);
	
	} else {
		echo '[]';
	} 

?>