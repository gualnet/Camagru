<?php

	ob_start();
	session_start();

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	define("DEBUG_MODE", false);

	define('DIRSEP', DIRECTORY_SEPARATOR);
	define('HTTP_HOST', $_SERVER["HTTP_HOST"]);
	define('WEBROOT', dirname(__FILE__).DIRSEP);
	define('ROOT', dirname(WEBROOT).DIRSEP."Camagru".DIRSEP);
	define('CORE', ROOT.'core'.DIRSEP);
	define('BASE_URL', dirname(WEBROOT).DIRSEP);

	require CORE."includes.php";

	if(!strstr($_SERVER["REQUEST_URI"], "ajax"))
	{
		require ROOT."view/pages/header.php";
		require ROOT."view/pages/menubar.php";

	}

	if(!isset($_SESSION["login"]))
	{
		$_SESSION["login"] = "none";
	}

	new Dispatcher();

	if(!strstr($_SERVER["REQUEST_URI"], "ajax"))
	{
		require ROOT."view/pages/footer.php";
	}

	echo "<script>";
	require_once ROOT."view/scripts/mainView.js";
	echo "</script>";

?>
