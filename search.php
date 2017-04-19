
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
			<?php require 'navbar.php'; ?>
		</div>

		<div class="container">

			<div class="row">
				<div class="col-md-6">
				
					<h4 class="header">Search for Courses</h4>
						
					<div class="form-group">
						<label>Department</label>
						<input type="text" class="form-control" id="coursePrefix" value="cis">
					</div>
					<div class="form-group">
						<label>Course Number</label>
						<input type="text" class="form-control" id="courseNumber" placeholder="(optional)">
					</div>
						
					<button class="btn btn-success" id="getCourse">Get</button>
					
				</div>
				<div class="col-md-6">
				
					<div id="output"></div>
				
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
				
				var c;
				var shown = new Array();
				for (var i in data.courses) {
					c = data.courses[i];
					
					if (shown.indexOf(c.prefix + c.courseNumber) < 0) {
						shown.push (c.prefix + c.courseNumber);
						$("#accordion").append(drawAccordianCard (c, i));
					}
				}
				
			});
	});
	
	function drawAccordianCard (c, i) {
		
		var html = "";
		
		// Collapse
		html += '<div class="card">';
		html += 	'<div class="card-header" role="tab" id="heading' + i + '">';
		html += 	  '<h5 class="mb-0 float-left">';
		html += 		'<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse' + i + '" aria-expanded="false" aria-controls="collapse' + i + '">';
		html += 		  c.prefix + "-" + c.courseNumber + " - " + c.title + ' (' + c.credit + ')';
		html += 		'</a>';
		html += 	  '</h5>';
		//html +=		  '<span class="float-right">';
		//html +=		  '</span>';
		html += 	'</div>';
		html += 	'<div id="collapse' + i + '" class="collapse" role="tabpanel" aria-labelledby="heading' + i + '">';
		html += 	  '<div class="card-block">';
		html += 		'<p class="card-text"><small>' + c.description + '</small></p>';
		html +=			'<small><strong>Prereq.</strong> ' + c.prerequisites + '</small>';
		html += 	  '</div>';
		html += 	'</div>';
		html += '</div><!-- card -->';
		
		return html;
	}
			
</script>



