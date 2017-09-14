Index.php loaded !
<?php
	// define()
	define('DIRSEP', DIRECTORY_SEPARATOR);
	define('WEBROOT', __FILE__.DIRSEP);
	define('ROOT', dirname(WEBROOT));
	define('CORE', ROOT.DIRSEP.'core');
	// print_r($_SERVER);
	// echo " --> WEBROOT ".WEBROOT;
	// echo " --> CORE ".CORE;
	// echo " --> ".CORE.DIRSEP."includes.php";

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require CORE.DIRSEP."includes.php";
	// phpinfo();

	new Dispatcher();

	echo "BYEBYE\n";
	die();

?>
<pre>
	<?php print_r($_SERVER); ?>
</pre>
