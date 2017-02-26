			<div class="container">
				<nav class="nav">
					<h5 class="navbar-brand mb-0">_Planner</h5>
					<div class="dropdown">
					  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						User
					  </button>
					  <div class="dropdown-menu">
						<?php
						
							session_start();
							
							if (isset($_SESSION['user_name'])) {
								echo '<a class="dropdown-item" href="dashboard.php">Dashboard</a>';
								echo '<a class="dropdown-item" href="logout.php">Logout</a>';
							} else {
								echo '<a class="dropdown-item" href="login.php">Login</a>';
								echo '<a class="dropdown-item" href="register.php">Register</a>';
							}
						
						?>
					  </div>
					</div>
					<div class="dropdown">
					  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Courses
					  </button>
					  <div class="dropdown-menu">
						<a class="dropdown-item" href="index.php">By Degree</a>
						<a class="dropdown-item" href="search.php">By Search</a>
					  </div>
					</div>
				</nav>
			</div>
			