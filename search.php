
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="../../favicon.ico"> -->

    <title>Course Lookup</title>

    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">


    <!-- Still might end up using draft2 -->
    <link href="../css/draft.css" rel="stylesheet">
  </head>

  <body>
	
		<!-- Page Header -->
		<div class="pageHeader">
			<?php require 'nav.php'; ?>
		</div>

		<div class="container">

			<div class="row">
				<div class="col-md-6">
				
					<h4 class="header">Search for Courses</h4>
						
					<div class="form-group">
						<label>Course Prefix</label>
						<input type="text" class="form-control" id="coursePrefix" value="cis">
					</div>
					<div class="form-group">
						<label>Course Number</label>
						<input type="text" class="form-control" id="courseNumber" placeholder="(optional)">
					</div>
						
					<button class="btn btn-success" id="getCourse">Get</button>
					
					<hr>
					
					<samp id="test"><strong>[Note]</strong> This won't alter your courses yet, but you can still search for them!</samp>
					
					<br><br><br>
					
					<div id="json"></div>
				
				</div>
				<div class="col-md-6">
				
					<div class="scroll" id="output"></div>
				
				</div>
			
			</div>
			
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
	
	// On Resize - fix output height
	$(document).ready(fixOutput);
	$(window).resize(fixOutput);

	function fixOutput() {
		$("#output").height($(window).height()-200);
	}

	// 'Get' - onClick
	$("#getCourse").click(function () {
		
		// create course query
		var baseURL = "https://api.svsu.edu/courses?"
		var cPrefix = $("#coursePrefix").val();
		var cNumber = $("#courseNumber").val();
		
		// get course info
		$.get(baseURL + "prefix=" + cPrefix + "&courseNumber=" + cNumber, function(data) {
			//
		})
			// On JSON complete
			.done(function(data) {
				
				// for testing
				//$("#json").html(JSON.stringify(data));
				
				// Reset 
				$("#output").html("");
				
				// Create accordian div
				$("#output").append('<div id="accordion" role="tablist" aria-multiselectable="true">');
				
				var c = data.courses;
				for (var i in data.courses) {
					$("#accordion").append(drawAccordianCard (data.courses[i], i));
				}
				
			});
	});
	
	function drawCourse (c)
	{
		// start with empty string
		var html = "";

		// build course HTML String
		//html = "(" + c.prefix + "-" + c.courseNumber + ") " + c.title + " - " + c.term;
		//c.title + " (" + c.prefix + "-" + c.courseNumber + ") - " + c.term;
		
		// build course button
		html = '<button type="button" class="btn btn-secondary">' + c.prefix + "-" + c.courseNumber + '</button>';
		
		/*/ Card
		html += '<div class="card">';
		html +=   '<div class="card-block">';
		html +=     '<h4 class="card-title">' + c.title + '</h4>';
		html +=     '<h6 class="card-subtitle mb-2 text-muted">(' + c.prefix + '-' + c.courseNumber + ')</h6>';
		html +=     '<p class="card-text">' + c.description + '</p>';
		html +=     '<a href="#" class="card-link">Card link</a>';
		html +=     '<a href="#" class="card-link">Another link</a>';
		html +=   '</div>';
		html += '</div>';
		
		// Card 2
		html += '<div class="card">';
		html +=   '<h5 class="card-header">';
		html +=     c.prefix + '-' + c.courseNumber;
		html +=   '</h5>';
		html +=   '<div class="card-block">';
		html +=     '<h4 class="card-title">' + c.title + '</h4>';
		html +=     '<p class="card-text">' + c.description + '</p>';
		//html +=     '<a href="#" class="btn btn-primary">Go somewhere</a>';
		html +=   '</div>';
		html += '</div>';*/
		
		return html
	}
	
	function drawAccordianCard (c, i) {
		
		var html = "";
		
		// Collapse
		html += '<div class="card">';
		html += 	'<div class="card-header" role="tab" id="heading' + i + '">';
		html += 	  '<h5 class="mb-0 float-left">';
		html += 		'<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse' + i + '" aria-expanded="false" aria-controls="collapse' + i + '">';
		html += 		  c.prefix + "-" + c.courseNumber;
		html += 		'</a>';
		html += 	  '</h5>';
		html +=		  '<span class="float-right">';
		html +=		 	'<input type="checkbox">';
		html +=		  '</span>';
		html += 	'</div>';
		html += 	'<div id="collapse' + i + '" class="collapse" role="tabpanel" aria-labelledby="heading' + i + '">';
		html += 	  '<div class="card-block">';
		html +=			'<h4 class="card-title">' + c.title + '</h4>';
		html += 		'<p class="card-text">' + c.description + '</p>';
		html += 	  '</div>';
		html += 	'</div>';
		html += '</div>';
		
		return html;
	}
			
</script>



