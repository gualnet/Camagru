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

	private function sendNewComNotif($vars)
	{
		$to = $vars["mailto"];
		$subject = "CAMAGROu - New comment";
		$headers = "From: webmaster@camagrou.com \r\n";
		$headers .= "Reply-To: no-reply@camagrou.com \r\n";
		$headers .= "MIME-Version: 1.0 \r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
		$message =
			"<h2>Dear ".$vars["picOLogin"]."</h2>\r\n"
			."One of your pictures has been commented by ".$vars["comOLogin"]." !<br />\r\n"
			."follow the link to see the comment "
			."<a href=http://localhost:8888/pages/comview/?up=".$vars["picId"]." >"
			."<span>CLICK ME</span></a>";

		$ret = imap_mail($to, $subject, $message, $headers);
		if($ret)
			return true;
		else
			return false;
	}

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
		$comInfo = $this->Comments->createComment($picInfo);

		if($_SESSION["user_id"] !== $comInfo["com_owner_id"])
		{
			$this->loadModel("Users");
			$picOInfo = $this->Users->getUserBy("id", $comInfo["pic_owner_id"]);
			$comOInfo = $this->Users->getUserBy("id", $comInfo["com_owner_id"]);
			$picOInfo = $picOInfo[0];
			$comOInfo = $comOInfo[0];
			$mailVars = array(
				"mailto"	=> $picOInfo->mail,
				"picOLogin"	=> $picOInfo->login,
				"comOLogin"	=> $comOInfo->login,
				"picId"		=> $comInfo["picture_id"],
			);
			$this->sendNewComNotif($mailVars);
		}

// COMINFO:
// [title] => none
// [content] => 0
// [com_owner_id] => 4
// [picture_id] => 30
// [pic_owner_id] => 4
		//send notification mail


	}
}

new PostComment();

?>
