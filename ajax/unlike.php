<?php
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

define('DIRSEP', DIRECTORY_SEPARATOR);
define('HTTP_HOST', $_SERVER["HTTP_HOST"]);
define('WEBROOT', dirname(__FILE__).DIRSEP);
define('ROOT', dirname(WEBROOT).DIRSEP);
define('CORE', ROOT.'core'.DIRSEP);
define('BASE_URL', dirname(WEBROOT).DIRSEP);

require CORE."includes.php";
require ROOT."controller/AjaxController.php";

class unlike extends AjaxController
{
	function doUnlike()
	{
		if(!isset($_POST["var1"]) or !isset($_POST["pic"]) and $_POST["var1"] !== "unlike3")
		{
			if(DEBUG_MODE === true)
				echo "<p>ERROR01</p>";
			return false;
		}

		$picInfo = $this->getPicInfo();

		$this->loadModel("Likes");
		$result = false;
		$result = $this->Likes->unlikePic($picInfo);
		if($result === true)
			echo "TRUE";
		else
			echo "FALSE";
	}
}

$truc = new unlike();
$truc->doUnlike();

?>
