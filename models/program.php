<?php

	require_once 'course.php';
	
	class Program
	{
		// Privare Vars
		public $type;
		public $dept;
		public $title;
		public $reqs = array();
		
		// Constructor
		public function __construct ($p_id, $getCourses = false) {
			
			// Load 'programs' JSON
			$string = file_get_contents('../data/programs.json');
			if (!$string) $string = file_get_contents('data/programs.json');
			$programs = json_decode($string);
			
			// Step through 'programs' Array
			foreach ($programs as $id => $p) {
					
				// Look for a matching dept in JSON
				if (strtoupper($p_id) == $id) {
					// Pass properties
					$this->type = $p->type;
					$this->dept = $p->dept;
					$this->title = $p->title;
					
					// Store requirements in $reqs array
					foreach ($p->requirements as $j => $r) {
						
						$this->reqs[$j] = $r;
						
						// Convert course string to course objects
						foreach ($this->reqs[$j]->courses as $k => $c) {
							$this->reqs[$j]->courses[$k] = new Course($c, $getCourses);
						}
					}
				}
			}
		} // __construct
		
		// public function
		public function required ()
		{
			$all = array();
			
				foreach ($this->reqs as $r) {
					foreach ($r->courses as $c) {
						array_push($all, $c->prefix . $c->courseNumber);
					}
				}
			
			return $all;
		}
		
		public function stillNeed ($taken)
		{
			$need = array ();
			
			foreach ($this->reqs as $r) {
				foreach ($r->courses as $c) {
					
					$cString = $c->prefix . $c->courseNumber;
					
					if (array_search($cString, $taken) === false) {
						if(!count($need)) {
							array_push($need, $cString);
						} else {
							$i = 0;
							while (strcmp($cString, $need[$i]) > 0 && $i < count($need)) {
								$i++;
							}
							array_splice($need, $i, 0, $cString);
						}
					}
				}
			}
			
			return $need;
		}
		
	}

?>