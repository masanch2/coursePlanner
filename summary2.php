<?php

	require_once 'models/program.php';
	require 'tools/globals.php';
	
	session_start();
	
	// Check for either User OR Guest program
	if (isset($_SESSION['user_program']) || isset($_SESSION['guest_program'])) {
		
		// Assign program to var
		if (isset($_SESSION['user_program'])) {
			$p = $_SESSION['user_program'];
		} else {
			$p = $_SESSION['guest_program'];
		}
		// For PHP model
		$prog = new Program($p);
					
		// List of courses that are not needed
		$skip = array();
		
		// Add completed courses to skip array
		$completed = $_SESSION['completed'];
		foreach ($completed as $c) {
			array_push($skip, $c);
		}
		
		// Get list of course still needed
		$need = $prog->stillNeed($skip);
						
	} else {
		// Redirect to login page with error
		header("location:login.php?program_error=true");
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
			
				<!-- List of [need] array -->
				<div class="col-md-3 col-sm-6">
					<?php
						if (isset($_SESSION['completed'])) {
							echo '<h6 class="header">Completed</h6>';
						}
					?>
					<div id="completed">
						<?php
							foreach ($_SESSION['completed'] as $c) {
								echo $c .'<br>';
							}
						?>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<h6 class="header">Still Needed</h6>
					<div id="need"></div>
					<?php
						foreach($need as $c) {
							echo $c .'<br>';
						}
					?>
				</div>
				
				<div class="col-md-6 col-sm-12">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
						  <li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#home" role="tab">Home</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#profile" role="tab">Profile</a>
						  </li>
						  <li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#messages" role="tab">Messages</a>
						  </li>
						</ul>
						
						<br>
						<div class="row">
							constant text
						</div>
						<br>
						
						<!-- Tab panes -->
						<div class="tab-content">
							<div class="tab-pane fade show active" id="home" role="tabpanel">
								<table class="table table-striped">
									<tbody>
										<div id="math">
											<tr><td>c1</td></tr>
										</div>
										<div id="cis">
											<tr><td>c3</td></tr>
										</div>
										<div id="cs">
											<tr><td>c2</td></tr>
										</div>
									</tbody>
								</table>
							  </div>
							  <div class="tab-pane fade" id="profile" role="tabpanel">
								<table class="table table-striped">
									<tbody>
										<tr><td>c4</td></tr>
									</tbody>
								</table>
							  </div>
							  <div class="tab-pane fade" id="messages" role="tabpanel">
								<table class="table table-striped">
									<tbody>
										<tr><td>c5</td></tr>
										<tr><td>c6</td></tr>
									</tbody>
								</table>
							</div>
						</div>
						
						<br><br>
						<div class="test">
							<ul class="nav nav-tabs" id="tabs" role="tablist">
							</ul>
							<div class="tab-content" id="content">
							</div>
						</div>
						
					<div id="courseResults">
					</div>
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
	$( document ).ready(function() {
		// Loads $_SESSION['completed'] JSON array
		$.get("scripts/load_session.php", function(result) {
				
			// Pass session array
			_completed = JSON.parse(result).completed;
			_current = JSON.parse(result).current;
			
			
			
			_need = <?php echo json_encode($need); ?>;
			
			_term = <?php echo "'". $GLOBALS['current_term'] ."'"; ?>;
			_terms = <?php echo json_encode($GLOBALS['terms']); ?>;
			
			for (var t in _terms) {
				
				// Create term id
				termRef = new Term(_terms[t]);
				termID = termRef.season + termRef.year;
				
				// Current/Active Term
				if (_terms[t] == _term) {
					// Tab
					$('#tabs').append('<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#' + termID + '" role="tab">' + _terms[t] + '</a></li>');
					// Content
					$('#content').append('<div class="tab-pane fade show active" id="' + termID + '" role="tabpanel">' + termID + ' text' + '</div>');
				
				// All other Terms
				} else {
					// Tab
					$('#tabs').append('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' + termID + '" role="tab">' + _terms[t] + '</a></li>');
					// Content
					$('#content').append('<div class="tab-pane fade" id="' + termID + '" role="tabpanel">' + termID + ' Text' + '</div>');
				}
				
			}
			
		});
	});
	
	function Term (termString) {
		var slash = termString.indexOf('\/');
		
		this.year = termString.slice(0, slash);
		this.season = termString.slice(slash + 1);
	}
</script>