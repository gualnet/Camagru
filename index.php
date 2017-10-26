<?php
	ob_start();
	session_start();
?>
<pre>
	<?php
		// print_r($_SERVER);
		// print_r($_SESSION);
	?>
</pre>
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


	// rgb(0, 0, 0)
	// rgb(17, 3, 71)
	// rgb(36, 6, 159)
	// rgb(60, 16, 241)
	// rgb(106, 73, 242)
	// rgb(179, 162, 247)
	// rgb(255, 255, 255)

	require CORE."includes.php";

	if(!strstr($_SERVER["REQUEST_URI"], "ajax"))
	{
		require ROOT."view/pages/header.php";
		require ROOT."view/pages/menubar.php";

	}


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

	if(!strstr($_SERVER["REQUEST_URI"], "ajax"))
	{
		require ROOT."view/pages/footer.php";
	}
	// echo "BYEBYE\n";

?>
