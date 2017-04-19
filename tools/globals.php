<?php 

	// Editables
	//------------------
	// - The following values WILL need to be update for functionality to continue!!!
	// - Data Expiration: [[ 6/29/2021 ]]
	
	// Dates from: http://www.svsu.edu/academicaffairs/academiccalendar/
	$termDates[16] = [null, null, null, '8/29'];
	$termDates[17] = ['1/9', '5/8', '6/26', '8/28'];
	$termDates[18] = ['1/16', '5/14', '7/2', '8/27'];
	$termDates[19] = ['1/14', '5/13', '7/1', '8/26'];
	$termDates[20] = ['1/13', '5/11', '6/29', '8/31'];
	$termDates[21] = ['1/11', '5/10', '6/28'];
	
	// Constants
	//------------------ 
	// Term abbreviation in chronological order per year
	$termOrder = ['WI', 'SP', 'SU', 'FA'];
	$yr = date('y');
	
	// Determine current term
	foreach($termDates[$yr] as $curTerm => $d) { 
	
		// Splite up date string	[Note: This keeps it convenient to type in new term dates]
		$slash = strpos($d, '/');
		$mo = substr($d, 0, $slash);
		$day = substr($d, $slash+1, strlen($d)-($slash+1));
		
		// Once current timestamp is greater than term begin timestamp
		//	- cur term: $termOrder[$curTerm]
		if (time() > mktime(0, 0, 0, $mo, $day, $yr)) break;
	}
	
	// Set GLOBAL var - 'current_term'
	//---------------------------------
	$GLOBALS['current_term'] = $yr .'\/'. $termOrder[$curTerm];
	
	
	
	
	// MUST be offered EVERY semester
	$cPrefix = 'comm';
	$cNumber = '105a';
	
	
	// CURL request course data
	//------------------
	
	// create curl resource 
	$ch = curl_init(); 

	// set url 
	curl_setopt($ch, CURLOPT_URL, 'https://api.svsu.edu/courses?prefix='. $cPrefix .'&courseNumber='. $cNumber); 

	//return the transfer as a string 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	// $output contains the output string 
	$output = curl_exec($ch); 

	// close curl resource to free up system resources 
	curl_close($ch);
	
	// store first course object
	$courses = json_decode($output)->courses;
	
	
	// Data processing
	//--------------------
	// Create collection of terms
	$terms = array();
				
	foreach ($courses as $c) {
		
		$termRef = $c->term;
		
		if (array_search($termRef, $terms) === false) {
			if (!sizeof($terms)) {
				array_push($terms, $termRef);
			} else {
				
				$i = 0;
				foreach ($terms as $t) {
					
					if (compareTerms($termRef, $t, $termOrder) < 0) {
						break;
					} else if ($i < sizeof($terms)) {
						$i++;
					}
				}
				
				array_splice($terms, $i, 0, $termRef);
			}
		}
	}
	
	// Set global var - 'terms' - array of every term currently in courses API
	//--------------------------
	$GLOBALS['terms'] = $terms;
	
	function compareTerms($term1, $term2, $order) {
		$t1yr = substr($term1, 0, 2);
		$t1se = substr($term1, 3, 2);
		$t1ord = array_search($t1se, $order);
		
		$t2yr = substr($term2, 0, 2);
		$t2se = substr($term2, 3, 2);
		$t2ord = array_search($t2se, $order);
		
		if ($t1yr < $t2yr) {
			return -1;
		} else if ($t1yr > $t2yr) {
			return 1;
		} else if ($t1yr == $t2yr) {
			
			if ($t1ord < $t2ord) {
				return -1;
			} else if ($t1ord > $t2ord) {
				return 1;
			} else if ($t1ord == $t2ord) {
				return 0;
			}
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>