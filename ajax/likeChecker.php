<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
define("DEBUG_MODE", true);

define('DIRSEP', DIRECTORY_SEPARATOR);
define('HTTP_HOST', $_SERVER["HTTP_HOST"]);
define('WEBROOT', dirname(__FILE__).DIRSEP);
define('ROOT', dirname(WEBROOT).DIRSEP);
define('CORE', ROOT.'core'.DIRSEP);
define('BASE_URL', dirname(WEBROOT).DIRSEP);

require CORE."includes.php";
require ROOT."controller/AjaxController.php";

class LikeChecker extends AjaxController
{
	function likeChecker()
	{
		if(!isset($_POST["var1"]) or !isset($_POST["var2"]) and $_POST["var1"] !== "like2")
		{
			echo "<p>ERROR01</p>";
			return false;
		}

		$picInfo = $this->getPicInfo();
		// print_r($picInfo);

		$this->loadModel("Likes");
		$result = false;
		$result = $this->Likes->checkLikes($picInfo);
		// print_r($result);
		if($result == false or $result == array())
		{
			echo "FALSE";
			return 0;
		}
		echo "TRUE";
		return 1;
	}
}

new LikeChecker();





?>
