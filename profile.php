<?php

	session_start();

	require 'tools/database.php';
	
	
	// Detect user login
	if (isset($_SESSION['user_id'])) {
		
		// connect to database
		Database::connect();
		
		// Process form POST vars
		if (isset($_POST['program'])) {
			
			// Store POST vars
			$program = $_POST['program'];
			$profile = mysql_real_escape_string($_POST['profile']);
			
			// Update DB 'user' - last date logged in value
			$sql = "UPDATE users SET program='". $program ."', profile='". $profile ."' WHERE id='". $_SESSION['user_id'] ."'";
			mysql_query($sql);
		
			// Update SESSION vars
			$_SESSION['user_program'] = $program;
			
			// Redirect to dash
			header("location:dashboard.php");
		
		
		/* All this just to display the profile..
			Every other var needed is stored in the SESSION already! 
		------------------------------------------------------------ */
		} else {
			
			// Get id from session
			$id = $_SESSION['user_id'];

			// Check db for login data
			$result = mysql_query("SELECT * FROM users WHERE id='$id'");
			
			// Mysql_num_row is counting table row
			$count = mysql_num_rows($result);
			
			// If result matched $myusername and $mypassword, table row must be 1 row
			if($count==1){
				$u = mysql_fetch_assoc($result);
			}
		}
			
		// disconnect from database
		Database::disconnect();
	
	} else {
		
		// Redirect to login page with error
		header("location:login.php?login_error=true");
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


    <!-- Custom styles for this template -->
    <link href="../css/draft.css" rel="stylesheet">
  </head>

  <body>
	
		<!-- Page Header -->
		<div class="pageHeader">
			<?php require 'navbar.php'; ?>
		</div>

		<div class="container">
		
			<div class="row">
				<div class="col-4">
				
					<h4 class="header">Edit profile</h4>
					
					<form class="form" action='profile.php' enctype='multipart/form-data' method='post'>
						<div class="form-group">
							<label>Program</label>
							<?php include 'views/program_dropdown.php'; ?>
						</div>
						<div class="form-group">
							<label>Profile</label>
							<textarea class="form-control" name="profile" rows="3"><?php echo $u['profile']; ?></textarea>
						</div>
						<input type="submit" class="btn btn-primary" value="Save"/>
						<a href="dashboard.php" class="btn btn-secondary">Nevermind</a>
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

<script>
	
	// CLASS - convert course string into an object with two props: prefix, number
	function Course (courseString) {
		var firstDigit = courseString.indexOf(courseString.match(/\d/));
		
		this.prefix = courseString.slice(0, firstDigit);
		this.number = courseString.slice(firstDigit, courseString.length);
	}
	
</script>
