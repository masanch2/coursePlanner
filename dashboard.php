<?php 

	session_start();

	require_once 'models/course.php';
	require_once 'models/program.php';
	require_once 'tools/database.php';

	// Check for login
	if (isset($_SESSION['user_id'])) {
		
		$id = $_SESSION['user_id'];
		
		// connect to database
		Database::connect();

		// Check db for login data
		$result = mysql_query("SELECT * FROM users WHERE id='$id'");
		
		// Mysql_num_row is counting table row
		$count = mysql_num_rows($result);
		
		// If result matched $myusername and $mypassword, table row must be 1 row
		if($count==1){
			$u = mysql_fetch_assoc($result);
		}
		
		// Get program data from user's selected program code
		if ($u['program']) $prog =  new Program($u['program']);
		
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

		<!-- CSS for coursePlanner draft -->
		<link href="../css/draft.css" rel="stylesheet">
	</head>

	<body>
	
		<!-- Page Header -->
		<div class="pageHeader">
			<?php require 'navbar.php'; ?>
		</div>

		<div class="container">
		
			<div class="row">
			
				<div class="col-md-6">
				
					<h5 class="header">Welcome, <?php echo $u['username']; ?></h5>
					
					<p>
						<strong>Program:</strong> <?php echo $u['program'] ? $prog->title .' ('. $prog->type .')' : 'Undecided'; ?>
					</p>
					<p>
						<strong>Profile:</strong>
						
						<br>
						<?php echo $u['profile']; ?>
						
					</p>
					
					<br><br>
					<h6 class="header">From here you can:</h6>
					- <a href="index.php">Add courses</a><br>
					- <a href="summary.php">Check upcoming classes</a><br>
					- <a href="profile.php">Edit your profile</a>
				
				</div>
				<div class="col-md-6">
					
					<!-- Test Data -->
					<h6 class="header">Completed Courses</h6>
					<samp id="test"></samp>
					
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
	$.get("scripts/load_session.php", function(result) {
		
		// Pass session array
		_completed = JSON.parse(result).completed;
		
		$("#test").html("");
		for (var i in _completed) {
			$("#test").append(_completed[i] + "<br>");
		}
	});
	
</script>
