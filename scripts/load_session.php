<?php

	session_start();

	$result = array();
		
	// Output completed class array from SESSION array
	if (isset($_SESSION['completed'])) {
		$completed = $_SESSION['completed'];
	} else {
		$completed = array();
	}
	$result['completed'] = $completed;
	
	//
	if (isset($_SESSION['current'])) {
		$current = $_SESSION['current'];
	} else {
		$current = array();
	}
	$result['current'] = $current;
	
	//
	if (isset($_SESSION['user_program'])) {
		$program = $_SESSION['user_program'];
	} else if (isset($_SESSION['guest_program'])) {
		$program = $_SESSION['guest_program'];
	} else {
		$program = null;
	}
	$result['program'] = $program;
	
	// Output two result arrays: 'completed', 'current'
	echo json_encode($result);

?>