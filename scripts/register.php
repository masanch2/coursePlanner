 <?php
	
	session_start();
	
	if ($_POST['user'] != '' && $_POST['pass'] != '') {
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$pass2 = $_POST['pass2'];
		$program = $_POST['program'];
		
		// connect to database
		$conn = mysql_connect('localhost', 'masanch2', '495297') or die (mysql_error());
		
		$db = mysql_select_db('masanch2', $conn);
		
		// Make sure entered passwords match
		if ($pass == $pass2) {
			$sql="SELECT * FROM users WHERE username='$user' and password='$pass'";
			$result=mysql_query($sql);
					
			// Mysql_num_row is counting table row
			$count=mysql_num_rows($result);
			
			if (!$count) {
				
				// Insert new user info into DB
				$query = "INSERT INTO users (username, password, program, profile, date_joined) VALUES ('$user', '$pass', '$program', 'Just some sample text..', '". time() ."')";
				mysql_query($query) or die ('query failed');
				
				// Now, select user info to get ID
				$sql = "SELECT * FROM users WHERE username='$user' and password='$pass'";
				$result = mysql_query($sql);
				$id = mysql_fetch_assoc($result)['id'];
				
				// Set session vars
				$_SESSION['user_id'] = $id;
				$_SESSION['user_name'] = $user;
				$_SESSION['user_program'] = $program;
				
			} else {
				echo "User name already exists.";
			}
			
		} else {
			echo "Passwords don't match!";
		}
		
		mysql_close();
	}
	
	
?>