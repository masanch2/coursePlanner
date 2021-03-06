<?php
									
	session_start();
							
	// Determine with dropdown link should be highlighted
	$doc = basename(debug_backtrace()[0]['file']);
	
	if ($doc == 'dashboard.php' || $doc == 'login.php' || $doc == 'register.html' || $doc == 'profile.php') {
		$userActive = 'active';
	} else if ($doc == 'progress.php' || $doc == 'search.php') {
		$coursesActive = 'active';
	} else if ($doc =='summary.php') {
		$summaryActive = 'active';
	}

?>

			<div class="container">
				<nav class="navbar navbar-toggleable-sm navbar-inverse">
				
					<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				  
					<?php
					
					if (isset($_SESSION['user_id'])) {
						echo '<a class="navbar-brand" href="dashboard.php">cPlanner</a>';
						
					} else {
						echo '<a class="navbar-brand" href="index.html">cPlanner</a>';
					}
					?>
				  
					<div class="collapse navbar-collapse" id="navbarText">
				  
						<ul class="navbar-nav mr-auto">
							
							<li class="nav-item" id="progressLink">
								<a class="nav-link <?php echo $coursesActive; ?>" href="progress.php">Progress</a>
							</li>
							<!-- <li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle <?php //echo $coursesActive; ?>" href="http://example.com" id="navbarCoursesLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Progress
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarCoursesLink">
									<a class="dropdown-item" href="index.php">Add/Remove</a>
									<a class="dropdown-item" href="search.php">Lookup Info</a>
								</div>
							</li> -->
							
							<?php
								// 'Report' link will only be displayed in the navbar when completed courses are detected
								if (isset($_SESSION['completed']) || isset($_SESSION['guest_program'])) {
									echo '<li class="nav-item" id="summaryLink"><a class="nav-link '. $summaryActive .'" href="summary.php">Summary</a></li>';
								} else {
									echo '<li class="nav-item" id="summaryLink"><a class="nav-link '. $summaryActive .' disabled" href="summary.php">Summary</a></li>';
								}
							?>
							
						</ul>
					</div>
					
					<?php
						// User login/register/dashboard area
						if (isset($_SESSION['user_name'])) {
							echo '<span class="navbar-text small">Logged in as: </span>
							<ul class="navbar-nav">
								<li class="nav-item dropdown">
									<a class="nav-link btn dropdown-toggle active" href="dashboard.php" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
										. $_SESSION['user_name'] .
									'</a>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a class="dropdown-item" href="dashboard.php">Dashboard</a>
										<a class="dropdown-item" href="scripts/logout.php">Logout</a>
									</div>
								</li>
							</ul>';
						} else {
							echo '<span class="navbar-text small">Need to <a href="login.php">login</a> or <a href="register.html">sign up</a>?</span>';
						}
					?>
					
				</nav>
			</div><!-- container -->
