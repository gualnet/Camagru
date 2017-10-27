<?php

session_start();

error_reporting(E_ALL);	//3 lignes pour le debug
ini_set('display_errors', 1);
define("DEBUG_MODE", false);

define('DIRSEP', DIRECTORY_SEPARATOR);
define('HTTP_HOST', $_SERVER["HTTP_HOST"]);
define('WEBROOT', dirname(__FILE__).DIRSEP);
define('ROOT', dirname(WEBROOT).DIRSEP);
define('CORE', ROOT.'core'.DIRSEP);
define('BASE_URL', dirname(WEBROOT).DIRSEP);

require CORE."includes.php";
require ROOT."controller/AjaxController.php";

class createLike extends AjaxController
{
	function createLike()
	{
		if((!isset($_POST["var1"]) or !isset($_POST["pic"])) and $_POST["var1"] !== "like")
			return false;

		$picInfo = $this->getPicInfo();
		// print_r($picInfo);

		$this->loadModel("Likes");
		$ret = $this->Likes->createLike($picInfo);
		if($ret === true)
		{
			echo "TRUE";
			return 1;
		}
		else
		{
			echo "FALSE";
			return 0;
		}
		// creer un like en base de donnee,-->ok
		// lier le like likeur_id et photoLiker_id,-->ok
		// notifier l'owner de la photo

		// incrementer le nombre de like de la photo concernées,
		// returner un true pour le changement de bouton sur la galerie.
	}

}

new createLike();

?>
