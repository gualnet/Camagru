Index.php loaded !

<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	define('DIRSEP', DIRECTORY_SEPARATOR);
	define('WEBROOT', dirname(__FILE__).DIRSEP);
	define('ROOT', dirname(WEBROOT).DIRSEP);
	define('CORE', ROOT.'core'.DIRSEP);
	define('BASE_URL', dirname(WEBROOT).DIRSEP);

	require CORE."includes.php";

	new Dispatcher();


	// print_r($_SERVER);
	// echo " --> FILE ".__FILE__;
	// echo " --> WEBROOT ".WEBROOT;
	// echo " --> ROOT ".ROOT;
	// echo " --> CORE ".CORE;
	// echo " --> BASE_URL ".BASE_URL;


	// echo "BYEBYE\n";

?>

<pre>
	<?php
	// print_r($_SERVER);

	?>
</pre>
