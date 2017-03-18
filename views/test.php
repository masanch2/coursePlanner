<?php

	if (isset($_GET['prefix']) && isset($_GET['cnum'])) {
		
		// Pass get parameters
		$prefix = $_GET['prefix'];
		$cNumber = $_GET['cnum'];
	
	//$string = file_get_contents('https://api.svsu.edu/courses?prefix=cs');
	//$json = json_decode($string);
	
        // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, 'https://api.svsu.edu/courses?prefix='. $prefix .'&courseNumber='. $cNumber); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);
		
		// show output string
		$class = new JSONObject(json_decode($output)->courses[0]);
		echo $class
	}
		
	
?>