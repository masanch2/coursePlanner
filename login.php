<?php

	session_start();

	if (isset($_POST['user'])) {
		
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		
		// connect to database
		$conn = mysql_connect('localhost', 'masanch2', '495297') or die (mysql_error());
		
		$db = mysql_select_db('masanch2', $conn);

		// Check db for login data
		$sql="SELECT * FROM users WHERE username='$user' and password='$pass'";
		$result=mysql_query($sql);
				
		// Mysql_num_row is counting table row
		$count=mysql_num_rows($result);

		// If result matched $myusername and $mypassword, table row must be 1 row
		if($count==1){
			
			// Get user record
			$array = mysql_fetch_assoc($result);

			// Register $myusername, $mypassword and redirect to file "login_success.php"
			$_SESSION['user_id'] = $array['id'];
			$_SESSION['user_name'] = $array['username'];
			
			
			// Convert DB records to '_completed'
			$sql = "SELECT * FROM registrations WHERE user_id='". $_SESSION['user_id'] ."'";
			$result = mysql_query($sql);
			
			$courses = [];
			while($row = mysql_fetch_assoc($result)) {
				array_push($courses, $row['course_string']);
			}
			$_SESSION['completed'] = $courses;
			
			header("location:dashboard.php");
		} else {
			echo "Wrong Username or Password";
		}
		
		mysql_close();
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
			<?php require 'nav.php'; ?>
		</div>

		<div class="container">
		
			<div class="row">
			
				<div class="col-md-4 align-self-center">
			
				<form method="post">
				
					<div class="form-group">
						<label for="exampleInputEmail1">Username</label>
						<input type="text" class="form-control" name="user">
					</div>
				
					<div class="form-group">
						<label for="exampleInputEmail1">Password</label>
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

<script>
	
	// CLASS - convert course string into an object with two props: prefix, number
	function Course (courseString) {
		var firstDigit = courseString.indexOf(courseString.match(/\d/));
		
		this.prefix = courseString.slice(0, firstDigit);
		this.number = courseString.slice(firstDigit, courseString.length);
	}
	
</script>