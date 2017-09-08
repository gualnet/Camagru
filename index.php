Index.php loaded !
<?php
	// define()
	define('DIRSEP', DIRECTORY_SEPARATOR);
	define('WEBROOT', dirname(__FILE__));
	define('ROOT', dirname(WEBROOT));
	define('CORE', ROOT.DIRSEP.'core');

	require CORE.DIRSEP."includes.php";

	new Dispatcher();

	echo "BYEBYE\n";
	die();

?>
