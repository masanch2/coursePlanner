
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
		<div class="pageHeader" id="pageHeader">
			<?php require 'navbar.php'; ?>
		</div>

		<div class="container">
		
			<div class="row">
			
				<!-- Form Column-->
				<div class="col-md-6 col-sm-12">
				
					<h4 class="header">Select program</h4>
					
					<!-- Degree Dropdown -->
					<div class="form-group">
						<?php include 'views/program_dropdown.php'; ?>
					</div>
					
					<!-- Save Button -->
					<button class="btn btn-primary" id="save" disabled="true">Save Changes</button>
					
					<!-- Reset Button
					<button class="btn btn-secondary" id="reset">Reset</button> -->
					
					<span id="saveResult"></span>
					
					<br><br><br><br>
					
					<!-- Save Report ->
					<div class="subheader">DB Report</div>
					<samp id="report"></samp>
					
					<br><br>-->
					
					<!-- Test Data
					<div class="subheader">$_SESSION['courses'] <i>array</i></div>
					<samp id="test"></samp> -->
				
				</div>
				
				<!-- Results Column -->
				<div class="col-md-6 col-sm-12">
				
					<p id="output"></p>
				
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
	
	// Page Initialization
	//---------------------
	//  - loads '_completed' from SESSION vars, if any
	$.get("scripts/load_session.php", function(result) {
		
		// Pass session array
		_completed = JSON.parse(result).completed;
		_current = JSON.parse(result).current;
		
		// TESTING - Output array for testing purposes
		//updateDBReport ("#test");
	});

				
	
	/*/ 'Degree' Dropdown
	//-------------------
	$.getJSON('data/programs.json', function(data) {
		
		// Update 'Output' column
		$('#programDropdown').change(function () {
				
			displayButtons(data[$(this).val()].requirements, '#output');
			// Populate with buttons
		});
	})
		.done (function(data) {
			//displayButtons(data[$('#programDropdown').val()].requirements, '#output');
		});*/
	
	// WORKIN ON IT
	// Draw initial buttons
	loadProgram ($('#programDropdown').val(), '#output');
	//$('#output').load('views/program_buttons.php?id=' + $('#programDropdown').val());
	
	// Update 'Output' column
	$('#programDropdown').change(function () {
				
		// Populate with buttons
		loadProgram ($(this).val(), '#output');
		//$('#output').load('views/program_buttons.php?id=' + $(this).val());
	});
	
	
	// 'Save' Button - Click
	//-----------------------
	//	- runs 'save.php' to convert '_completed' to SESSION array
	$("#save").click(function() {
		
		// Convert '_completed' array to SESSION var
		$.post("scripts/save_session.php", {"completed":_completed, "current":_current}, function(result){
			
			// Animate saving process
			$("#save").attr('disabled', true);
			$("#saveResult").html(result).fadeIn(1);
			$("#saveResult").delay(700).fadeOut("slow");
			
			// Update navbar with summary
			$('#pageHeader').load('navbar.php');
			
			// TESTING - Output array for testing purposes
			//updateDBReport ("#test");
		});
		
	});
		
	// FUNCTION - 
	function loadProgram (programID, outputID) {
		$(outputID).load('views/program_buttons.php?id=' + programID, function() {
			
			// Button Event - Setup button toggle
			//	- each click adds or removes a courses from '_completed' array
			$(".cbtn").click(function () {
					
				// Set - COMPLETED
				if ($(this).hasClass('btn-secondary')) { 
					$(this).removeClass('btn-secondary');
					$(this).addClass('btn-success');
						
					// Add courseString to 'completed'
					if (_completed.indexOf($(this).attr('id')) < 0) {
						_completed.push ($(this).attr('id'));
					}
					
				// Set - NOT COMPLETED	
				} else if ($(this).hasClass('btn-success')) {
					$(this).removeClass('btn-success');
					$(this).addClass('btn-secondary');
					
					// Remove courseString to 'completed'
					var index = _completed.indexOf($(this).attr('id'));
					_completed.splice(index, 1);
				}
				
				/*/ Set - COMPLETED
				if ($(this).hasClass('btn-secondary')) { 
					$(this).removeClass('btn-secondary');
					$(this).addClass('btn-success');
						
					// Add courseString to 'completed'
					if (_completed.indexOf($(this).attr('id')) < 0) {
						_completed.push ($(this).attr('id'));
					}
					
				// Set - CURRENTLY
				} else if ($(this).hasClass('btn-success')) {
					
					$(this).removeClass('btn-success');
					$(this).addClass('btn-warning');
					
					// Remove courseString to 'completed'
					var index = _completed.indexOf($(this).attr('id'));
					_completed.splice(index, 1);
						
					// Add courseString to 'current'
					if (_current.indexOf($(this).attr('id')) < 0) {
						_current.push ($(this).attr('id'));
					}
				
				// Set - INCOMPLETE
				} else if ($(this).hasClass('btn-warning')) {
				
					$(this).removeClass('btn-warning');
					$(this).addClass('btn-secondary');
					
					// Remove courseString to 'current'
					var index = _current.indexOf($(this).attr('id'));
					_current.splice(index, 1);
				}*/
				
				// Enable 'Save' button
				$("#save").attr('disabled', false);
				
			});
		});
		
	}
	
	
	
	// FUNCTION - updates <div="[output_ID param]"> with test data
	function updateDBReport (outputID) {
		
		$(outputID).html("");
		for (var i in _completed) {
			$(outputID).append(_completed[i] + "<br>");
		}
		
		// TESTING - Save report
		$("#report").html(_report);
	}
	
	// FUNCTION - Display degree requirements
	//	- as 2-state buttons
	function displayButtons (reqJSON, outputID) {
		
		// Reset output
		$(outputID).html("");
		
		// List requirements
		for (var j in reqJSON) {
			
			// Req. title
			$(outputID).append("<div class='subheader'>" + reqJSON[j].title + " (" + reqJSON[j].credits + " cr)</div>");
			
			// Start centered row
			$(outputID).append("<div class='row justify-content-around' id='reqGroup" + j + "'>");
			// Append course buttons
			for (var k in reqJSON[j].courses) {
				var c = new Course (reqJSON[j].courses[k]);
				var btn_class = "btn-secondary";
				
				// If course has been completed
				if (typeof _completed !== 'undefined') {
					if (_completed.indexOf(c.prefix + c.number) >= 0) {
						btn_class = "btn-success";
					}
				}
				
				// Course button HTML
				$("#reqGroup" + j).append('<button type="button" class="btn cbtn ' + btn_class + '" id="' + c.prefix + c.number + '">' + (c.prefix + "-" + c.number).toUpperCase() + '</button>');
			}
		}
		
		// Button Event - Setup button toggle
		//	- each click adds or removes a courses from '_completed' array
		$(".cbtn").click(function () {
				
			// Set - COMPLETED
			if ($(this).hasClass('btn-secondary')) { 
				$(this).removeClass('btn-secondary');
				$(this).addClass('btn-success');
					
				// Add courseString to 'completed'
				if (_completed.indexOf($(this).attr('id')) < 0) {
					_completed.push ($(this).attr('id'));
				}
				
			// Set - NOT COMPLETED	
			} else if ($(this).hasClass('btn-success')) {
				$(this).removeClass('btn-success');
				$(this).addClass('btn-secondary');
				
				// Remove courseString to 'completed'
				var index = _completed.indexOf($(this).attr('id'));
				_completed.splice(index, 1);
			}
			
			// Enable 'Save' button
			$("#save").attr('disabled', false);
			
		});
	}
	
	
	// CLASS - convert course string into an object with two props: prefix, number
	function Course (courseString) {
		var firstDigit = courseString.indexOf(courseString.match(/\d/));
		
		this.prefix = courseString.slice(0, firstDigit);
		this.number = courseString.slice(firstDigit, courseString.length);
	}
	
</script>