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

	function profil()
	{
		$this->loadModel("Users");
		$findRet = $this->Users->findFirst(array(
			"conditions" => "id=".$_SESSION["user_id"]));
		if(empty($findRet))
			$this->e404("PAGE INTROUVABLE");
		$this->setVars("User", $findRet);
	}

	function signup()
	{
		$this->setVars("displayErrMsg", false); //enable error message in case of login failure
		$this->setVars("loginRedir", false); //Enable home redirection in case of login success
		$this->setVars("inUse", array(
			"login" => false,
			"mail" => false
		)); //enable error message in case of mail already used

		if($_POST)
		{
			$this->loadModel("Users");
			$checkRet = $this->Users->checkSignupValidity();
			$this->setVars("inUse", $checkRet);
			if($checkRet["login"] === false and $checkRet["mail"] === false)
			{
				$this->Users->registerNewUser();
			}
		}
	}

	function login()
	{
		$this->setVars("displayErrMsg", false); //enable error message in case of login failure
		$this->setVars("loginRedir", false); //Enable home redirection in case of login success
		if($_POST)
		{
			$this->loadModel("Users");
			$loginRes = $this->Users->checkSignin();
			// echo " --".$loginRes."-- ";
			if($loginRes === false)
			{
				$this->setVars("displayErrMsg", true);
			}
			else
			{
				$_SESSION["user_id"] = $loginRes[0]->id;
				$_SESSION["login"] = $loginRes[0]->login;
				$this->setVars("loginRedir", true);
			}
		}
	}

	function logout()
	{
		header("Location:acceuil");
		$_SESSION["login"] = "none";
		$this->acceuil();
		ob_end_flush();
	}

}

?>
