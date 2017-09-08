<?php
	include 'config/database.php';

	try
	{
		$db_connect = new PDO("mysql:host=$DB_DSN; dbname:$DB_NAME", $DB_USER, $DB_PASSWORD);
		$db_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo"Database connection successfull !";
	}
	catch (PDOException $e)
	{
		echo "Database connection failed !" . $e->getMessage();
	}

?>
