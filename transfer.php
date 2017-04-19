<?php

	require_once ("../include/database.php");

	ini_set('file-uploads', true);
	
	
	if ($_FILES['file1']['size'] > 0 ) {
		
		$filename = $_FILES['file1']['name'];
		$tempname = $_FILES['file1']['tmp_name'];
		$filesize = $_FILES['file1']['size'];
		$filetype = $_FILES['file1']['type'];
		
		$filetype = (get_magic_quotes_gpc() == 0 ? mysql_escape_string($filetype) : mysql_escape_string(stripslashes($_FILES['file1'])));

		$fp = fopen($tempname, 'r');
		$content = fread($fp, filesize($tempname));
		$content = addslashes($content);
		fclose($fp);
		
		if (!get_magic_quotes_gpc()) {
			$filename = addslashes($filename);
		}
		
		// connect to database
		$conn = mysql_connect('localhost', 'masanch2', '495297') or die (mysql_error());
		
		$db = mysql_select_db('masanch2', $conn);
		
		
		if ($db) {
			$query = "INSERT INTO _upload (name, size, type, content) VALUES ('$filename', '$filesize', '$filetype', '$content')";
			
			//mysql_query($query) or die ('query failed');
			
			echo "upload successful";
		}
		
		mysql_close();

	}
	
	//show_source (__FILE__);

?>

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


    <!-- Custom styles for this template -->
    <link href="../css/draft.css" rel="stylesheet">
  </head>

  <body>
	
		<!-- Page Header -->
		<div class="pageHeader">
			<?php require 'navbar.php'; ?>
		</div>

		<div class="container">
		
			<div class="row">
				<div class="col-4">
					<form class="form" action='' enctype='multipart/form-data' method='post'>
					<div class="form-group">
						<label>Choose file: </label><br>
						<input type='file' name="file1" id="file1" />
						</div>
					
						<input type='submit' />
					</form>
				</div>
				<div class="col-4">
				
					<?php
					
						$array = explode(',', $content);
						var_dump($array);
						
						echo 'Filename: '. $filename .'<br>';
						echo 'Size: '. $filesize .'<br>';
						echo 'Type: '. $filetype .'<br>';
					
					?>
				
				</div>
				<div class="col-4">
				
					<?php
						// connect to database
						$conn = mysql_connect('localhost', 'masanch2', '495297') or die (mysql_error());
							
						$db = mysql_select_db('masanch2', $conn);
							
						// if no POST, set default id = 1
						isset($_POST['upload_id']) ? $id = $_POST['upload_id'] : $id = 1;

						$query = "SELECT * FROM _upload";
						$result = mysql_query ($query);
						
						while ($row = mysql_fetch_assoc($result)) {
							var_dump($row);
							//echo $row['id'] .' '. $row['name'] .' '. $row['size'] .' '. $row['type'];
						}
					?>
				
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
