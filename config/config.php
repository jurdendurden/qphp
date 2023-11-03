<?php
	
	$GLOBALS["version"] = 1.0;	

	//App Root
	define('APP_ROOT', dirname(dirname(__FILE__)));
	define('URL_ROOT', '/');
	define('URL_SUBFOLDER', '');
	

	//DB Params
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', '');

	/*try 
	{
		$db = new PDO(DB_HOST, DB_USER);
	}
	catch (PDOException $e) 
	{
		$error_message = 'Database Error ' . $e->getMessage();		
		echo $error_message;
		include('view/error.php');
		exit();
	}*/

?>