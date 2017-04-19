<?php

	require 'tools/globals.php';
	
	$curTerm = $GLOBALS['current_term'];
	$terms = $GLOBALS['terms'];
		
?>
		_term = <?php echo "'". $GLOBALS['current_term'] ."'"; ?>;
		_terms = <?php echo json_encode($GLOBALS['terms']); ?>;
		
		for (var t in _terms) {
			
			// Create term id
			termRef = new Term(_terms[t]);
			termID = termRef.year + termRef.season;
			
			if (_terms[t] == _term) {
				$('#tabs').append('<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#' + termID + '" role="tab">' + _terms[t] + '</a></li>');
				//$('#tabs').append('<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#' + termID +'" role="tab">' + _terms[t] + '</a></li>');
				$('#content').append('<div class="tab-pane fade show active" id="' + termID + '" role="tabpanel">' + termID + ' text' + '</div>');
			} else {
				$('#tabs').append('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' + termID + '" role="tab">' + _terms[t] + '</a></li>');
				//$('#tabs').append('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#' + termID +'" role="tab">' + _terms[t] + '</a></li>');
				$('#tabcontent').append('<div class="tab-pane fade" id="' + termID + '" role="tabpanel">' + termID + ' Text' + '</div>');
			}
		}