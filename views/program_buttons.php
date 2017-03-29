<?php

	session_start();

	require_once '../models/program.php';
	if (isset($_GET['id'])) {
		
		$programID = $_GET['id'];
		
		$prog = new Program($programID);
		
		foreach ($prog->reqs as $r) {
			echo '<div class="subheader">'. $r->title .' ('. $r->credits .' cr)</div>';
			
			// Start centered div
			echo '<div class="row justify-content-around">';
			
			// 
			foreach ($r->courses as $c) {
				
				// Default button class
				$btnClass = 'btn-secondary';
				
				// Change button class if completed
				if (isset($_SESSION['completed'])) {
					//echo $c->prefix . $c->courseNumber .' - '. array_search($c->prefix . $c->courseNumber, $_SESSION['completed']);
					if (array_search($c->prefix . $c->courseNumber, $_SESSION['completed']) !== false) {
						$btnClass = 'btn-success';
					}
				}
				if (isset($_SESSION['current'])) {
					if (array_search($c->prefix . $c->courseNumber, $_SESSION['current']) !== false) {
						$btnClass = 'btn-warning';
					}
				}
				
				// Output course button
				echo '<button type="button" class="btn cbtn '. $btnClass .'" id="'. $c->prefix . $c->courseNumber .'">'. strtoupper($c->prefix .'-'. $c->courseNumber) .'</button>';
				
				//echo '<a id="popoverData" class="btn cbtn '. $btnClass .'" data-content="'. $c->description .'" rel="popover" data-placement="bottom" data-original-title="'. $c->title .'" data-trigger="hover">'. strtoupper($c->prefix .'-'. $c->courseNumber) .'</a>';
				
				//echo '<button type="button" class="btn cbtn '. $btnClass .'" id="'. $c->prefix . $c->courseNumber .'" data-content="'. $c->data->description .'" rel="popover" data-placement="bottom" data-original-title="'. $c->data->title .'" data-trigger="hover">'. strtoupper($c->prefix .'-'. $c->courseNumber) .'</button>';
			}
			
			echo '</div>';
		}
	}

?>