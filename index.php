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
	require CORE.DIRSEP."includes.php";


	new Dispatcher();

	echo "BYEBYE\n";
	die();

?>
<pre>
	<?php print_r($_SERVER); ?>
</pre>
