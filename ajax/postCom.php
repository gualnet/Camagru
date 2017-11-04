<?php
session_start();

error_reporting(E_ALL);	//3 lignes pour le debug
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

class PostComment extends AjaxController
{
	function postComment()
	{
		// echo $_POST["pic"];
		// echo $_POST["comData"];
		if((!isset($_POST["var1"]) or !isset($_POST["pic"]) or !isset($_POST["comData"])) and $_POST["var1"] !== "postComment")
			return false;

		if($_POST["comData"] === "")
		{
			if(DEBUG_MODE)
				die($e->getMessage("EMPTY MESSAGE !")); // pour le debug
			die(); //pour la prod
		}

		$picInfo = $this->getPicInfo();
		// print_r($picInfo);
		$this->loadModel("Comments");
		$ret = $this->Comments->createComment($picInfo);
	}
}

new PostComment();

?>
