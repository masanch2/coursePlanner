<?php
	class Database
	{
		private static $dbName = 'masanch2' ;
		private static $dbHost = 'localhost' ;
		private static $dbUsername = 'masanch2';
		private static $dbUserPassword = '495297';
		
		private static $conn = null;
		private static $db = null;
		
		public static function connect()
		{
			// connect to database
			self::$conn = mysql_connect(self::$dbHost, self::$dbUsername, self::$dbUserPassword) or die (mysql_error());
			
			self::$db = mysql_select_db(self::$dbName, self::$conn);
		}
		
		
		public static function disconnect()
		{
			mysql_close();
		}
		
	}

?>