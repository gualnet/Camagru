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

class GetLikers extends AjaxController
{
    function getLikers()
    {

        if(!isset($_POST["var1"]) or !isset($_POST["pic"]) or $_POST["var1"] !== "getLikers")
        {
            if(DEBUG_MODE === true)
                echo "WTF";
            return false;
        }

        $picInfo = $this->getPicInfo();
        $this->loadModel("Likes");
        $result = false;
        $likeList = $this->Likes->getLikersList($picInfo);
        $this->loadModel("Users");
        // echo count($likeList);
        if(count($likeList) < 1)
            echo ":{";
        else
        {
            foreach($likeList as $like)
            {
                $ret = $this->Users->getUserBy("id", $like->user_id);
                print("<p>'".$ret[0]->login."' like your pic</p>");
            }
        }
        
    }
}

new GetLikers();

?>