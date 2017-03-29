<?php

	session_start();
	
	// Overwrite SESSION array with '_completed' which represents FINAL USER INPUT
	$_SESSION['completed'] =  $_POST['completed'];
	$_SESSION['current'] = $_POST['current'];
	
	// Start 'save' report
	$report = '';

	
	
	// For LOGGED IN users
	//---------------------
	if (isset($_SESSION['user_id'])) {
	
		// Store session vars for user_error
		$userID = $_SESSION['user_id'];
	
		// connect to database
		$conn = mysql_connect('localhost', 'masanch2', '495297') or die (mysql_error());
			
		$db = mysql_select_db('masanch2', $conn);

		// Check db for login data
		$sql="SELECT * FROM registrations WHERE user_id='". $userID ."'";
		$result=mysql_query($sql);
		
		// Setup Report vars
		$report .= '<b>user_id = '. $userID .':</b><br>';
		$count = mysql_num_rows($result);
		$in = 0;
		$out = 0;
		
		// SELECT every course record for 'user_id'
		$sql = "SELECT * FROM registrations WHERE user_id='". $userID ."'";
		$result = mysql_query($sql);
		
		// First, we'll compare database entries to SESSION array
		while($row = mysql_fetch_assoc($result)) {
			
			// If course has DB record, but it not in SESSION anymore
			if (array_search($row['course_id'], $_SESSION['completed']) === false) {
				
				// Remove DB record
				$sql = "DELETE FROM registrations WHERE user_id='". $userID ."' AND course_id='". $row['course_id'] ."'";
				mysql_query($sql);
				
				$out += 1;
			}
		}
		
		
		// Next, process SESSION array into DB records
		foreach ($_SESSION['completed'] as $cString) {
				
			// Check DB for record with $cString
			$sql = "SELECT * FROM registrations WHERE user_id='". $userID ."' AND course_id='". $cString ."'";
			$result = mysql_query($sql);
				
			// If course doesn't exist, INSERT it
			if (mysql_num_rows($result) == 0) {
				$sql = "INSERT INTO registrations (user_id, course_id, completed) VALUES ('". $userID ."', '". $cString ."', true)";
				mysql_query ($sql);
					
				$in += 1;
			}
		}
		
		// Generate quick report info
		$report .= '- Inserted '. $in .' records<br>';
		$report .= '- Removed '. $out .' records<br>';
		$report .= 'DB records total: '. ($count - $out + $in);
		
		// Close database
		mysql_close();
		
		
		
		
	// Users are NOT LOGGIN IN
	//-------------------------
	} else {
		$report .= "Session saved. (Not logged in)";
	}
	
	
	echo '<script>var _report = "'. $report .'";</script>';
	echo "Successful!";
?>