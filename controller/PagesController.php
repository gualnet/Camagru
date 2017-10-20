<?php

class PagesController extends Controller
{

	function index()
	{
		$this->render("acceuil");
	}

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
		if($_SESSION["user_id"] === "none")
		{
			header("location:index");
		}
		$this->loadModel("Users");
		if(isset($_SESSION["user_id"]))
		$findRet = $this->Users->findFirst(array(
			"conditions" => "id=".$_SESSION["user_id"]));
		if(empty($findRet))
			$this->e404("PAGE INTROUVABLE");
		$this->setVars("User", $findRet);
		$this->render("profil");
	}

	function signup()
	{
		$this->setVars("displayErrMsg", false); //enable error message in case of login failure
		$this->setVars("loginRedir", false); //Enable home redirection in case of login success
		$this->setVars("inUse", array(
			"login" => false,
			"mail" => false
		)); //enable error message in case of mail already used
		// print_r($_POST);
		if(isset($_POST["login"]) and isset($_POST["name"]) and
		isset($_POST["surname"]) and isset($_POST["mail"]) and
		isset($_POST["pwd"]))
		{
			$this->loadModel("Users");
			$checkRet = $this->Users->checkSignupValidity();
			$this->setVars("inUse", $checkRet);
			if($checkRet["login"] === false and $checkRet["mail"] === false)
			{
				$activator = $this->Users->registerNewUser();
				if(!$this->Users->sendConfirmMail($_POST["login"], $activator))
				{
					$this->e404("An error occur, Confirmation mail not sent.<p>please contact the customer services !</p>");
				}
				$this->setVars("loginRedir", true);
			}
		}
		else if($_POST !== array())
		{
			$this->e404("JOUE PAS AU CON !!!!");
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
		$_SESSION["user_id"] = "none";
		$this->acceuil();
		ob_end_flush();
	}

	function accountActivation()
	{
		$ul = empty($_GET["ul"]) ? NULL : $_GET["ul"];
		$ua = empty($_GET["ua"]) ? NULL : $_GET["ua"];
		$this->loadModel("Users");
		$reqCond["conditions"] = array(
			"login"				=> $ul,
			"activation_hash"	=> $ua
		);
		$userRet = $this->Users->find($reqCond);
		if(count($userRet) != 1)
		{
			$this->e404("!^!^!");
			die();
		}
		if($this->Users->confirmActivation($userRet[0]) === false)
		{
			$this->e404("Authentication not allowed");
			die();
		}
		$_SESSION["user_id"] = $userRet[0]->id;
		$_SESSION["login"] = $userRet[0]->login;
		$this->setVars("loginRedir", true);
	}

	function webcamTest()
	{
		if($_SESSION["user_id"] === "none")
		{
			header("location:index");
		}
		$this->loadModel("Pictures");
		$this->loadModel("Calcs");
		$retCalcs = $this->Calcs->getCalcs();
		$retUserPics = $this->Pictures->getPics($_SESSION["user_id"]);
		$userPics = array();
		$calcsUrl = array();
		if ($retUserPics != false)
		{
			for ($i = 0; $i < count($retUserPics); $i++)
			{
				$userPics[] .= $retUserPics[$i]->file_url;
			}
			$this->setVars("userPics", $userPics);
		}
		if($retCalcs != false)
		{
			for($i = 0; $i < count($retCalcs); $i++)
			{
				$calcsUrl[] .= $retCalcs[$i]->file_url;
				// print($retCalcs[$i]->file_url);
			}
			$this->setVars("calcsUrl", $calcsUrl);
		}
		$this->render("webcamTest");
	}

	function picRegistration()
	{
		$this->loadModel("Pictures");
		$this->Pictures->picRegistration();
		$this->render("picRegistration");
		// die("ICICICICICICICIC");
		header("Location:webcamTest");

	}

	function galery()
	{
		$this->loadModel("Pictures");
		$retPics = $this->Pictures->getPics();

		if(isset($this->request->params[0]))
			$pageNum = intval($this->request->params[0]);
		else
			$pageNum = 1;

		$nbrPics = 0;
		$nbrPics = count($retPics);
		if($nbrPics <= 0)
			$this->e404("SRY no picture found in the database !");
		$picsUrl = array();
		for($i = 0; $i < $nbrPics; $i++)
		{
			$picsUrl[] .= $retPics[$i]->file_url;
		}

		if($pageNum < 1 or $pageNum > ($nbrPics / 6) + 1)
		{
			$pageNum = 1;
		}

		$this->setVars("picsUrl", $picsUrl);
		$this->setVars("nbrPics", $nbrPics);
		$this->setVars("pageReq", $pageNum);

		$this->render("galery");
		// die("FIN");
	}

}

?>
