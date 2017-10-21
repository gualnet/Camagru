<?php
	ob_start();
	session_start();

?>

<?php


	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	define("DEBUG_MODE", true);

	define('DIRSEP', DIRECTORY_SEPARATOR);
	define('HTTP_HOST', $_SERVER["HTTP_HOST"]);
	define('WEBROOT', dirname(__FILE__).DIRSEP);
	define('ROOT', dirname(WEBROOT).DIRSEP."Camagru".DIRSEP);
	define('CORE', ROOT.'core'.DIRSEP);
	define('BASE_URL', dirname(WEBROOT).DIRSEP);

	require CORE."includes.php";
	echo "<style>";
	// require ROOT."view/css/header.css";
	require ROOT."view/css/menubar.css";
	require ROOT."view/css/footer.css";
	echo "</style>";
	require ROOT."view/pages/header.php";

	if(!isset($_SESSION["login"]))
	{
		// echo "je set session[\"login\"] = none";
		$_SESSION["login"] = "none";
	}

	new Dispatcher();


	// echo " --> FILE ".__FILE__;
	// echo " --> WEBROOT ".WEBROOT;
	// echo " --> ROOT ".ROOT;
	// echo " --> CORE ".CORE;
	// echo " --> BASE_URL ".BASE_URL;
	// print_r($_SERVER);

	require ROOT."view/pages/footer.php";
	// echo "BYEBYE\n";

?>
