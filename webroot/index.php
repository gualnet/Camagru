<?php
	session_start();
?>
index
<pre>
	<?php
		echo "SESSION:";
		print_r($_SESSION);
		// print_r($_SERVER);x
	?>
</pre>
<?php


	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	define('DIRSEP', DIRECTORY_SEPARATOR);
	define('WEBROOT', dirname(__FILE__).DIRSEP);
	define('ROOT', dirname(WEBROOT).DIRSEP);
	define('CORE', ROOT.'core'.DIRSEP);
	define('BASE_URL', dirname(WEBROOT).DIRSEP);

	require CORE."includes.php";
	require ROOT."view/pages/header.php";

	if(!isset($_SESSION["login"]))
	{
		echo "je set session[\"login\"] = none";
		$_SESSION["login"] = "none";
	}

	new Dispatcher();


	// print_r($_SERVER);
	// echo " --> FILE ".__FILE__;
	// echo " --> WEBROOT ".WEBROOT;
	// echo " --> ROOT ".ROOT;
	// echo " --> CORE ".CORE;
	// echo " --> BASE_URL ".BASE_URL;

	require ROOT."view/pages/footer.php";
	// echo "BYEBYE\n";

?>
