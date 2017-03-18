<?php

	require_once 'models/program.php';
	
	session_start();
	
	if (isset($_SESSION['user_id'])) {
		// Testin stuff
		$p = $_SESSION['user_program'];
		
		$prog = new Program($p);
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
				
				<div class="col-3">
					<h6 class="header">Completed</h6>
					<div id="completed"></div>
				</div>
				
				<div class="col-3">
					<h6 class="header">Required</h6>
					<?php
						$cList = $prog->getCourseStrings();
						foreach($cList as $c) {
							echo $c .'<br>';
						}
					?>
				</div>
				
				<div class="col-3">
					<h6 class="header">Still Needed</h6>
					<?php
						$needed = $prog->stillNeeded($_SESSION['completed']);
						foreach($needed as $c) {
							echo $c .'<br>';
						}
					?>
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
	
	// Loads $_SESSION['completed'] JSON array
	$.get("scripts/load_completed.php", function(result) {
		
		// Pass session array
		_completed = JSON.parse(result);
		
		// If empty, create new array
		if (!_completed) _completed = [];
		
		$("#completed").html("");
		for (var i in _completed) {
			$("#completed").append(_completed[i] + "<br>");
		}
	});
	
</script>
