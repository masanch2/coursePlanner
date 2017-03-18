<?php
	
	class Course
	{
		// Public Vars
		public $prefix;
		public $courseNumber;
		
		public $data;
		
		
		// Constructor
		public function __construct ($courseString, $getData = false) {
				
			// Split course string
			preg_match('/^\D*(?=\d)/', $courseString, $m);
			$this->prefix = $m[0];
			$this->courseNumber = substr($courseString, strlen($this->prefix));
	
			// OPTION [$getData] - Loads full course data from SVSU course API
			if ($getData) {
			
				// create curl resource 
				$ch = curl_init(); 

				// set url 
				curl_setopt($ch, CURLOPT_URL, 'https://api.svsu.edu/courses?prefix='. $this->prefix .'&courseNumber='. $this->courseNumber); 

				//return the transfer as a string 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

				// $output contains the output string 
				$output = curl_exec($ch); 

				// close curl resource to free up system resources 
				curl_close($ch);
				
				// store first course object
				$this->data = json_decode($output)->courses[0];
			}
		}
		
	}
	
?>