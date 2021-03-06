
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
		
			<div id="error"></div>
		
			<div class="row">
			
				<div class="col-md-4 align-self-center">
					
					<h4 class="header">User Login</h4>
			
					<div class="form-group">
						<label>Username</label>
						<input type="text" class="form-control" name="user">
					</div>
				
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="pass">
					</div>
					
					<button id="submit" class="btn btn-primary">Submit</button>
					
					<br>
					<br>
					<p class="small extrafade">Not a member yet? Click <a href="register.html">here</a> to register.</p>
				
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

	// Handles redirect from page where login is required
	if (getUrlParameter('login_error')) {
		$('#error').html('<div class="alert alert-danger" role="alert"><strong>Oh snap!</strong> You need to be logged in first..</div>');
		
	// Handles redirect from page that requires at least a program selected and stored in session
	} else if (getUrlParameter('data_error')) {
		$('#error').html('<div class="alert alert-danger" role="alert"><strong>No Data!</strong> You can either login in below or select a <a href="progress.php">program</a> as a guest.</div>');
		
	}

	// Event - 'Submit' button
	$('#submit').click(function(data) {
		
		// Collect form vars
		var user = $('input[name="user"]').val();
		var pass = $('input[name="pass"]').val();
		
		// Post form data
		$.post('scripts/login.php', { user: user, pass: pass } )
		
			// Handle form response
			.done(function (data) {
				if (!$.trim(data)) {
					window.location.href = 'dashboard.php';
				} else {
					$('#error').html('<div class="alert alert-danger" role="alert">' + data + '</div>');
				}
				
			});
	});

	// Function - Returns value of GET param in URL
	function getUrlParameter (sParam)
	{
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		var sParameterName;
		
		for (var i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');

			if (sParameterName[0] == sParam) {
				return sParameterName[1];
			}
		}
	}
	

</script>
