<?php

	require_once 'models/program.php';
	require 'tools/globals.php';
	
	session_start();
	
	// 
	if (isset($_SESSION['user_program'])) {
		
		// Testin stuff
		$p = $_SESSION['user_program'];
		
		$prog = new Program($p);
					
		// Get courses arrays: comp, cur, need
		$skip = array();
		
		$completed = $_SESSION['completed'];
		$current = $_SESSION['current'];
				
		foreach ($completed as $c) {
			array_push($skip, $c);
		}
		foreach ($current as $c) {
			array_push($skip, $c);
		}
		$need = $prog->stillNeed($skip);
						
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
    <!-- <link rel="icon" href=""> -->

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
				
				<!-- <div class="col-3">
					<h6 class="header">Completed</h6>
					<div id="completed">
						<?php
							/*foreach ($_SESSION['completed'] as $c) {
								echo $c .'<br>';
							}*/
						?>
					</div>
				</div> 
				
				<!-- List of [need] array -->
				<div class="col-md-3 col-sm-6">
					<h6 class="header">Still Needed</h6>
					<div id="need"></div>
					<?php
						foreach($need as $c) {
							echo $c .'<br>';
						}
					?>
					
					<br>
					<?php
						if (isset($_SESSION['current'])) {
							echo '<h6 class="header">Currently Taking</h6>';
						}
					?>
					<div id="current">
						<?php
							foreach ($_SESSION['current'] as $c) {
								echo $c .'<br>';
							}
						?>
					</div>
				</div>
				
				<!-- Option Columns [plus some test output] -->
				<div class="col-md-3 col-sm-6">
					<h6 class="header">Options <small class="extrafade">[Coming soon]</small></h6>
					<form>
						<div class="form-check">
							<label class="form-check-label small">
								<input type="checkbox" class="form-check-input">
								Only show eligible courses
							</label>
						</div>
						<div class="form-check">
							<label class="form-check-label small">
								<input type="checkbox" class="form-check-input" checked="true">
								Show completed courses
							</label>
						</div>
					</form>
					
					<br>
					<h6 class="header">Departments<br><small class="extrafade">Yeah, this doesn't work yet either..</small></h6>
					<div id="test">
						<form id="depts"></form>
					</div>
				</div>

				<!-- Available Section [COL-6 / COL-12] -->
				<div class="col-md-6 col-sm-12">
					<div class="row">
						
						<ul class="nav nav-tabs" id="tabs" role="tablist">
						</ul>
						
					</div><br>
					<div class="row">
						<div class="col-10"><h6>Course Details</h6></div>
						<div class="col-2"><h6>Seats</h6></div>
					</div>
					<table class="table table-striped" id="available">
						<tbody>
						
							<div class="tab-content" id="content">
							</div>
						
						</tbody>
					</table>
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
	$.get("scripts/load_session.php", function(result) {
			
		// Pass session array
		_completed = JSON.parse(result).completed;
		_current = JSON.parse(result).current;
		
		_need = <?php echo json_encode($need); ?>;
		
		_term = <?php echo "'". $GLOBALS['current_term'] ."'"; ?>;
		_terms = <?php echo json_encode($GLOBALS['terms']); ?>;
		
		// Populate term tabs
		for (var t in _terms) {
			
			// Create term id
			termRef = new Term(_terms[t]);
			termID = termRef.year + termRef.season;
			
			if (_terms[t] == _term) {
				$('#tabs').append('<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#' + termID +'" role="tab">' + _terms[t] + '</a></li>');
				//$('#content').append('<div class="tab-pane active" id="home" role="tabpanel">' + termID + ' text' + '</div>');
			} else {
				$('#tabs').append('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' + termID +'" role="tab">' + _terms[t] + '</a></li>');
				//$('#content').append('<div class="tab-pane" id="' + termID + '" role="tabpanel">' + termID + ' Text' + '</div>');
			}
		}
		
		// FROM [_need] determine which departments will be needed
		var depts = new Array();
		
		// Go through array of needed course strings
		for (var i in _need) {
			
			// Department ref
			d = new Course(_need[i]).prefix;
			
			// Only if 
			if (depts.indexOf(d) == -1) {
				
				// Add department string to 'depts' array from courses prefixes
				depts.push(d);
				// test output
				$('#depts').append('<div class="form-check"><label class="form-check-label"><input type="checkbox" class="form-check-input" checked="true"> ' + d.toUpperCase() + '</label></div>');
				
				// Request each department
				$.get('https://api.svsu.edu/courses?prefix=' + d + '&term=' + _term, function(data) {
					
					var show = new Array();
					
					for (var i in data.courses) {
						c = data.courses[i];
						if (_need.indexOf(c.prefix.toLowerCase() + c.courseNumber) != -1) {
							show.push(data.courses[i]);
						}
					}
					
					// Update 'available' column
					updateCourses(data.courses);
					
				});
			}
		}
		
	});
	
	
	
	
	
	function updateCourses (courses, clear = false)
	{
		// FOR NOW clear out output div for a fresh set of courses	
		if (clear) {
			$('#available > tbody').html('');
		}
		
		// Loop variables
		var c, mt, cHTML;
		
		// Draw EVERY course in [courses]
		for (var i in courses) {
			
			// Course ref
			c = courses[i];
		
			// Start new course HTML
			cHTML = '';
			
			cHTML += '<div class="row">';
						
				cHTML += '<div class="col-10">';
							
					cHTML += '<b class="h5">' + c.prefix + '-' + c.courseNumber + '</b> - <span class="faded"><b class="h6">' + c.title + '</b> (' + c.credit + ' cr)</span>';
					cHTML += '<div class="row">';
								
						cHTML += '<div class="col-6 offset-1">';
							
							// Check for online
							if (c.meetingTimes[0].method == "ONL") {
								cHTML += '<b>Online</b><br>';
							} else {
							// Add all meetins times
							for (var j in c.meetingTimes) {
								// Loop ref
								mt = c.meetingTimes[j];
										
								// Add meeting time
								cHTML += '<b>' + mt.days + '</b> [' + mt.startTime + ' - ' + mt.endTime + ']<br>';
							}
							}
									
						cHTML += '</div>';
						cHTML += '<div class="col-5"><span class="text-right">';
										
							cHTML += '<small class="extrafade">Sec</small> ' + c.section + ' <small class="extrafade">Line#</small> ' + c.lineNumber;
									
						cHTML += '</span></div>';
								
					cHTML += '</div>';
					cHTML += '<div class="row"><div class="col-11 offset-1">';
					
						cHTML += '<small>' + c.prerequisites + '</small>';
						//cHTML += '<small class="fade">' + c.prerequisites + '</small>';
					
					cHTML += '</div></div>';
								
				cHTML += '</div>';
				cHTML += '<div class="col-2"><p class="text-center">' + c.seatsAvailable + '/' + c.capacity + '</p></div>';
					
			cHTML += '</div>';
			
			// FOR NOW - this will always update the 'available' div (col-6)
			$('#available > tbody:last').append('<tr><td>' + cHTML + '</td></tr>');
		}
	}
	
	
	// CLASS - convert course string into an object with two props: prefix, number
	function Course (courseString) {
		var firstDigit = courseString.indexOf(courseString.match(/\d/));
		
		this.prefix = courseString.slice(0, firstDigit);
		this.number = courseString.slice(firstDigit, courseString.length);
	}
	
	function Term (termString) {
		var slash = termString.indexOf('\/');
		
		this.year = termString.slice(0, slash);
		this.season = termString.slice(slash + 1);
		
		/*this.format = function () {
			return this.year + '-' this.season;
		}*/
	}
</script>
