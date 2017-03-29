<?php

	session_start();
	
	require 'tools/database.php';

	if (isset($_POST['user'])) {
		
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
			header("location:dashboard.php");
		} else {
			echo "Wrong Username or Password";
		}
		
		Database::disconnect();
	}
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>Course Planner</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <!-- CSS for coursePlanner draft -->
    <link href="../css/draft.css" rel="stylesheet">
  </head>

  <body>
	
		<!-- Page Header -->
		<div class="pageHeader">
			<?php require 'navbar.php'; ?>
		</div>

		<div class="container">
	
			<?php
				if (isset($_GET['login_error'])) {
					echo '<div class="alert alert-danger" role="alert"><strong>Oh snap!</strong> You need to be logged in first..</div>';
				}
				if (isset($_GET['program_error'])) {
					echo '<div class="alert alert-danger" role="alert"><strong>No Data!</strong> You can either login in or select a program as a guest <a href="index.php">here</a></div>';
				}
			?>
		
			<div class="row">
			
				<div class="col-md-4 align-self-center">
			
				<form method="post">
				
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="user">
					</div>
				
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="pass">
					</div>
					
					<button type="submit" class="btn btn-primary">Submit</button>
					
				</form>
				
				</div>
			
			</div><!-- row -->

			<hr>

			<footer>
				<p>Course Planner 2017</p>
			</footer>
		</div> <!-- /container -->


		<!-- Bootstrap core JavaScript
		================================================== -->
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	</body>
</html>
