<?php

	session_start();
	
	require '../tools/database.php';

	if ($_POST['user'] != '' && $_POST['pass'] != '') {
		
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		// connect to database
		Database::connect();
		// Check db for login data

		$sql="SELECT * FROM users WHERE username='$user' and password='$pass'";
		$result = mysql_query($sql);
				
		// Mysql_num_row is counting table row
		$count = mysql_num_rows($result);

		// If result matched $myusername and $mypassword, table row must be 1 row
		if($count==1){
			
			// Get user record
			$array = mysql_fetch_assoc($result);

			// Register $myusername, $mypassword and redirect to file "login_success.php"
			$_SESSION['user_id'] = $array['id'];
			$_SESSION['user_name'] = $array['username'];
			$_SESSION['user_program'] = $array['program'];
			
			// Get rid of guest session if it's set
			if (isset($_SESSION['guest_program'])) {
				unset($_SESSION['guest_program']);
			}  
			
			// Update user last date logged in value
			$sql = "UPDATE users SET date_last='". time() ."' WHERE id='". $_SESSION['user_id'] ."'";
			mysql_query($sql);
			
			// Convert DB records to '_completed'
			$sql = "SELECT * FROM registrations WHERE user_id='". $_SESSION['user_id'] ."'";
			$result = mysql_query($sql);
			
			// Store '_completed' in SESSION
			$courses = [];
			while($row = mysql_fetch_assoc($result)) {
				array_push($courses, $row['course_id']);
			}
			$_SESSION['completed'] = $courses;
			
			// Redirect to user dashboard
			//header("location:dashboard.php");
			
		} else {
			echo "<strong>Oh snap!</strong> Wrong username or password!";
		}
		
		Database::disconnect();
	} else {
		echo "<strong>Missing info!</strong> Please type in your username AND password!";
	}
	
?>