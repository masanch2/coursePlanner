<?php

	require_once 'models/program.php';
	require 'tools/globals.php';
	
	session_start();
	
	// 
	if (isset($_SESSION['user_program']) || isset($_SESSION['guest_program'])) {
		
		// Testin stuff
		if (isset($_SESSION['user_program'])) {
			$p = $_SESSION['user_program'];
		} else {
			$p = $_SESSION['guest_program'];
		}
		
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
		header("location:login.php?data_error=true");
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
					<!-- <h6 class="header">Upcoming</h6>
					<div id="upcoming"></div>
					<br>
					
					<h6 class="header">Options <small class="extrafade">[Doesn't work]</small></h6>
					<form>
						<div class="form-check">
							<label class="form-check-label small">
								<input type="checkbox" class="form-check-input">
								Only show eligible courses
							</label>
						</div>
						<div class="form-check">
							<label class="form-check-label small">
								<input type="checkbox" class="form-check-input">
								Show completed courses
							</label>
						</div>
					</form>
					
					<br> -->
					<h6 class="header">Departments</h6>
					<div id="test">
						<form id="depts"></form>
					</div>
				</div>

				<!-- Available Section [COL-6 / COL-12] -->
				<div class="col-md-6 col-sm-12">
				
					<!-- TABS -->
					<ul class="nav nav-tabs" id="tabs" role="tablist"></ul>
					<br>
					
					<!-- Constant text -->
					<div class="row">
						<div class="col-10"><h6>Course Details</h6></div>
						<div class="col-2"><h6>Seats</h6></div>
					</div>
					
					<!-- TAB - CONTENT - Tab-Panes will be populated here -->
					<div class="tab-content" id="content"></div>
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
		
		// Courses still needed
		_need = <?php echo json_encode($need); ?>;
		
		// Current term & array of terms
		_term = <?php echo "'". $GLOBALS['current_term'] ."'"; ?>;
		_terms = <?php echo json_encode($GLOBALS['terms']); ?>;
		
		var currentTerm = new Term(_term).full;
		
		// List of deptartments still need for search queries
		var _depts = new Array();
		
		// Go through array of needed course strings
		for (var i in _need) {
			
			// Department ref
			d = new Course(_need[i]).prefix;
			
			// Add new department search
			if (_depts.indexOf(d) == -1) {
				
				// Add department string to 'depts' array from courses prefixes
				_depts.push(d);
				
				// Create dept checkboxes
				$('#depts').append('<div class="form-check"><label class="form-check-label"><input type="checkbox" class="form-check-input" id="' + d + '_check" checked="true"> ' + d.toUpperCase() + '</label></div>');
				$('#' + d + '_check').change(function() {
					
					deptName = $(this).parent().text().substr(1);
					for (var t in _terms) {
						var termName = new Term(_terms[t]).full;
						
						if ($(this).prop('checked') == false) {
							$('#' + termName + '_' + deptName).animate({
																opacity: 0,
																height: "toggle"
															  });
						} else {
							$('#' + termName + '_' + deptName).animate({
																opacity: 1,
																height: "toggle"
															  });
						}
					}
						
				});
				// Event - Change - dept checks
				
			}
		}
		/* Everything above here is DATA PROCESSING for the page */
		
		
		
		/* -------------------------
			PAGE LAYOUT BEGINS HERE
		   ------------------------- */
		
		// TERM LAYOUT - DEPENDENT ON API.COURSES 
		/* - So this section subdivides out content column into tabs each representing a single term */
		// Prepare tab & content divs
		for (var t in _terms) {
			
			// Create term id
			termRef = new Term(_terms[t]);
			termID = termRef.full;
			
			if (_terms[t] == _term) {
				$('#tabs').append('<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#' + termID +'" role="tab"><strong>' + _terms[t] + '</strong></a></li>');
				$('#content').append('<div class="tab-pane fade show active" id="' + termID + '" role="tabpanel"></div>');
			} else {
				$('#tabs').append('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' + termID +'" role="tab">' + _terms[t] + '</a></li>');
				$('#content').append('<div class="tab-pane fade" id="' + termID + '" role="tabpanel"></div>');
			}
			
			// Finally append a table to each TAB-PANE
			//$('#' + termID).append('<table class="table table-striped"><tbody id="' + termID + '_table"></tbody></table>');
			$('#' + termID).append('<table class="table table-striped" id="' + termID + '_table"></table>');
			
			
			// DEPARTMENT LAYOUT - DEPENDENT ON [_need]
			/* - Each term tab-pane will have a tbody for each department
			   - Ensures course results will always display in order */
			for (var i in _depts) {
				
				// Add a <tbody> for every department
				$('#' + termID + '_table').append('<tbody id="' + termID + '_' + _depts[i].toUpperCase() + '"></tbody>');
				
			}
		}
		
		
		/* ----------------
			LOAD PROCESSES
		   ---------------- */
		// Request every department through COURSES.API
		for (var t in _terms) {
			for (var d in _depts) {
				
				// Request each department individually
				$.get('https://api.svsu.edu/courses?prefix=' + _depts[d] + '&term=' + _terms[t], function(data) {
						
					// Create array only containing needed course strings
					var show = new Array();
					for (var i in data.courses) {
						c = data.courses[i];
						if (_need.indexOf(c.prefix.toLowerCase() + c.courseNumber) != -1) {
							show.push(data.courses[i]);
						}
					}
					
					// Determine tab-pane id
					paneID = new Term(data.courses[0].term).full;
					tbodyID = data.courses[0].prefix;
					
					// Update 'available' column
					for (var k in show) {
						// Update tab-page with table structure
						//$('#' + paneID + '_table').append('<tr><td>' + drawSection(show[k]) + '</td></tr>');
						$('#' + paneID + '_' + tbodyID).append('<tr><td>' + drawSection(show[k]) + '</td></tr>');
					}
					
				});
				
			}
		}
		
		// Event - Tab Click
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			var target = $(e.target).attr("href");
			currentTerm = target.substr(1);
		});
		
	});
	
	function drawSection (c) {
		
		// Start new course HTML
		cHTML = '';
			
		cHTML += '<div class="row">';
						
			cHTML += '<div class="col-10">';
							
				cHTML += '<b class="h5">' + c.prefix + '-' + c.courseNumber + '</b> - <span class="faded"><b class="h6">' + c.title + '</b> (' + c.credit + ' cr)</span>';
				cHTML += '<div class="row">';
							
					cHTML += '<div class="col-6 offset-1">';
						
						cHTML += '<p class="meetingtimes">';
							
							// Check for online
							if (c.meetingTimes[0].method == "ONL") {
								cHTML += '<b>[Online]</b><br>';
							// Check for TBA
							} else if (c.meetingTimes[0].room == "TBA"){
								cHTML += '<b>[TBA]</b><br>';
							} else {
								// Add all meetins times
								for (var j in c.meetingTimes) {
									// Loop ref
									mt = c.meetingTimes[j];
												
									// Add meeting time
									cHTML += '<b>' + mt.days + '</b> [' + mt.startTime + ' - ' + mt.endTime + ']<br>';
								}
							}
									
						cHTML += '</p>';
					
					cHTML += '</div>';
					
					cHTML += '<div class="col-5"><span class="text-right">';
										
						cHTML += '<small class="extrafade">Sec</small> ' + c.section + ' <small class="extrafade">Line#</small> ' + c.lineNumber;
						cHTML += '<br><small class="extrafade">' + c.instructors[0].name + '</small>';
									
					cHTML += '</span></div>';
								
				cHTML += '</div>';
				cHTML += '<div class="row"><div class="col-11 offset-1">';
					
					cHTML += '<small class="extrafade">' + c.prerequisites + '</small>';
					
				cHTML += '</div></div>';
								
			cHTML += '</div>';
			cHTML += '<div class="col-2">';
				
				cHTML += '<p class="text-center seats">' + c.seatsAvailable + '/' + c.capacity + '</p>';
				//cHTML += '<div class="text-center"><span class="badge badge-default">Save</span></div>';
			
			cHTML += '</div>';
					
		cHTML += '</div>';
		
		return cHTML;
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
		
		this.full = this.season + this.year;
	}
</script>
