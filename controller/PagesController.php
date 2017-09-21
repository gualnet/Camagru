<?php

class PagesController extends Controller
{

	function acceuil()
	{
		$this->render("acceuil");
	}

	function vue($id=false)
	{
		$this->loadModel("Comments");
		if(!$id)
		{
			// $this->e404("PAGE INTROUVABLE");
			$this->setVars("Comments", false);
			$this->render("vue");
			die();
		}
		$findRet = $this->Comments->findFirst(array(
			"conditions" => "id=".$id));
		if(empty($findRet))
			$this->e404("PAGE INTROUVABLE");
		$this->setVars("Comments", $findRet);
		// print_r($findRet);
	}

	function profil($id=false)
	{
		$this->loadModel("Users");
		if(!$id)
		{
			$this->e404("PAGE INTROUVABLE");
			die("no id");
		}
		$findRet = $this->Users->findFirst(array(
			"conditions" => "id=".$id));
		if(empty($findRet))
			$this->e404("PAGE INTROUVABLE");
		$this->setVars("User", $findRet);
	}

	function login()
	{
		$this->setVars("displayErrMsg", false);
		if($_POST)
		{
			$this->loadModel("Users");
			$loginRes = $this->Users->checkLogin();
			// echo " --".$loginRes."-- ";
			if($loginRes === true)
			{
				// echo "login OK";
				echo "je set session[\"login\"] = longinOK";
				$_SESSION["login"] = "LoginOK";
			}
			else
			{
				$this->setVars("displayErrMsg", true);
			}
		}
	}

	function logout()
	{
		$_SESSION["login"] = "none";
		$this->acceuil();
	}

}



?>
