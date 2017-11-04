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

class GetComment extends AjaxController
{
	function getPicComment()
	{
		if((!isset($_POST["var1"]) or !isset($_POST["pic"])) and $_POST["var1"] !== "getComment")
			return false;

		$picInfo = $this->getPicInfo();
		// print_r($picInfo);
		$this->loadModel("Comments");
		$comments = $this->Comments->getPicComments($picInfo);
		// print_r($comments);

		$this->loadModel("Users");
		foreach($comments as $com)
		{
			echo "<p>";
			echo "from: ".$this->Users->getUserById($com->com_owner_id)[0]->login."</br>";
			echo "com: ".$com->content;
			echo "</p>";
		}
	}
}

$ins = new GetComment();
$ins->getPicComment();

// echo "END";

?>
