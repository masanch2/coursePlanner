<?php
									
	session_start();
							
	// Determine with dropdown link should be highlighted
	$doc = basename(debug_backtrace()[0]['file']);
	
	if ($doc == 'dashboard.php' || $doc == 'login.php' || $doc == 'register.php' || $doc == 'profile.php') {
		$userActive = 'active';
	} else if ($doc == 'index.php' || $doc == 'search.php') {
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
				  
					<a class="navbar-brand" href="#">_Planner</a>
				  
					<div class="collapse navbar-collapse" id="navbarText">
				  
						<ul class="navbar-nav mr-auto">
					
							<li class="nav-item dropdown <?php echo $userActive; ?>">
								<a class="nav-link dropdown-toggle" href="http://example.com" id="navbarUserLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									User
								</a>
								<div class="dropdown-menu">
									<?php
										
										if (isset($_SESSION['user_name'])) {
											echo '<a class="dropdown-item" href="dashboard.php">Dashboard</a>';
											echo '<a class="dropdown-item" href="scripts/logout.php">Logout</a>';
										} else {
											echo '<a class="dropdown-item" href="login.php">Login</a>';
											echo '<a class="dropdown-item" href="register.php">Register</a>';
										}
									
									?>
								</div>
							</li>
							
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle <?php echo $coursesActive; ?>" href="http://example.com" id="navbarCoursesLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Courses
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarCoursesLink">
									<a class="dropdown-item" href="index.php">By Degree</a>
									<a class="dropdown-item" href="search.php">By Search</a>
								</div>
							</li>
							
							<?php
								// 'Report' link will only be displayed in the navbar when completed courses are detected
								if (isset($_SESSION['completed'])) {
									echo '<li class="nav-item"><a class="nav-link '. $summaryActive .'" href="summary.php">Summary</a></li>';
								}
							?>
							
						</ul>
					
				  </div>
				  
				</nav>
			</div><!-- container -->
