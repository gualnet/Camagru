<?php

class PagesController extends Controller
{

	function index() {
		$this->render("acceuil");
	}

	function acceuil() {
		$this->render("acceuil");
	}

	function profil() {
		if ($_SESSION["user_id"] === "none") {
			header("location:index");
		}
		$this->loadModel("Users");
		if (isset($_SESSION["user_id"])) {
			$findRet = $this->Users->findFirst(array("conditions" => "id=" . $_SESSION["user_id"]));
		}
		if (empty($findRet)) {
			$this->e404("PAGE INTROUVABLE");
		}
		$this->setVars("User", $findRet);
		$this->render("profil");
	}

	private function checkPasswordComplexity($inputPwd) {
		if (($c = strlen($inputPwd)) < 6) {
			return "NOK";
		}
		$numCpt = 0;
		$majCpt = 0;
		for ($i = 0; $i < strlen($inputPwd); $i++) {
			if (is_numeric($inputPwd[$i])) {
				$numCpt++;
			}
			if (ctype_upper($inputPwd[$i])) {
				$majCpt++;
			}
		}
		if ($numCpt < 2 or $majCpt < 1) {
			return "NOK";
		}
	}

	function signup() {
		$this->setVars("displayErrMsg", false); //enable error message in case of login failure
		$this->setVars("loginRedir", false); //Enable home redirection in case of login success
		$this->setVars("inUse", array(
			"login"	=> false,
			"mail"	=> false
		)); //enable error message in case of mail already used
		$this->setVars("badPwd", false);
		if (isset($_POST["login"]) and isset($_POST["mail"]) and isset($_POST["pwd"])) {
			$this->loadModel("Users");
			$_POST["login"] = $this->Users->filterNewInput($_POST["login"]);
			$_POST["mail"] = $this->Users->filterNewInput($_POST["mail"]);
			if ($this->checkPasswordComplexity($_POST["pwd"]) === "NOK") {
				$this->setVars("badPwd", true);
			} else {
				$checkRet = $this->Users->checkSignupValidity();
				$this->setVars("inUse", $checkRet);
				if ($checkRet["login"] === false and $checkRet["mail"] === false) {
					$activator = $this->Users->registerNewUser();
					if (!$this->Users->sendConfirmMail($_POST["login"], $activator)) {
						$this->e404("An error occur, Confirmation mail not sent.<p>please contact the customer services !</p>");
					}
					$this->setVars("loginRedir", true);
				}
			}
		} else if ($_POST !== array()) {
			$this->e404("NON NON :) !!!!");
		}
	}

	function login() {
		$this->setVars("displayErrMsg", false); //enable error message in case of login failure
		$this->setVars("loginRedir", false); //Enable home redirection in case of login success
		if ($_POST) {
			$this->loadModel("Users");
			$_POST["login"] = $this->Users->filterNewInput($_POST["login"]);
			$loginRes = $this->Users->checkSignin();
			if ($loginRes === false) {
				$this->setVars("displayErrMsg", true);
			} else {
				$_SESSION["user_id"] = $loginRes[0]->id;
				$_SESSION["login"] = $loginRes[0]->login;
				$this->setVars("loginRedir", true);
			}
		}
	}

	function pwdRecovery() {
		if (!isset($_POST["email"])) {
			header("location:login");
		}

		$this->loadModel("Users");
		$_POST["email"] = $this->Users->filterNewInput($_POST["email"]);
		$ret = $this->Users->getUserBy("mail", $_POST["email"]);
		if ($ret === false) {
			$this->setVars("loginRedir", false);
			return 0;
		}

		$this->setVars("loginRedir", true);
		$activator = $this->Users->pwdResetStp1($ret[0]);
		$this->Users->sendPwdRecoveryMail($ret[0]->login, $activator);
	}

	function rescuepwd() {
		$this->setVars("badPwd", false);
		print_r($_POST);

		if ($_POST !== array() and $_POST["pwd"] === $_POST["pwd2"] and $_GET["ul"] === $_POST["login"]) {
			$this->loadModel("Users");
			//sanit input
			$_POST["login"] = $this->Users->filterNewInput($_POST["login"]);
			$_POST["pwd"] = $this->Users->filterNewInput($_POST["pwd"]);
			$_POST["pwd2"] = $this->Users->filterNewInput($_POST["pwd2"]);
			$_GET["ul"] = $this->Users->filterNewInput($_GET["ul"]);
			$_GET["ua"] = $this->Users->filterNewInput($_GET["ua"]);

			//verif login/activator validity
			$ret = $this->Users->find(array(
				"conditions"	=> array(
					"login"				=> $_POST["login"],
					"activation_hash"	=> $_GET["ua"]
				)
			));
			if ($ret === array()) {
				header("Location:../acceuil");
			}

			if ($this->checkPasswordComplexity($_POST["pwd"]) === "NOK") {
				$this->setVars("badPwd", true);
			} elseif ($ret !== array()) {
				//make change in db
				$this->Users->update(array(
					"set"			=> array(
						"password"			=> hash("sha1", $_POST["pwd"]),
						"activation_hash"	=> "activated"
					),
					"conditions"	=> array(
						"login"				=> $_POST["login"],
						"activation_hash"	=> $_GET["ua"]
					)
				));
			}
		} elseif (isset($_GET["ul"]) and isset($_GET["ua"])) {
			$this->loadModel("Users");
			$_GET["ul"] = $this->Users->filterNewInput($_GET["ul"]);
			$_GET["ua"] = $this->Users->filterNewInput($_GET["ua"]);
			$ret = $this->Users->find(array(
				"conditions"	=> array(
					"login"				=> $_POST["login"],
					"activation_hash"	=> $_GET["ua"]
				)
			));
			if ($ret === array()) {
				header("Location:../acceuil");
			}
		}
	}

	function comview() {
		if (!isset($_GET["up"])) {
			header("Location:../galery");
			return 0;
		}
		$this->loadModel("Users");
		$picId = $this->Users->filterNewInput($_GET["up"]);

		//chercher l'adresse de la photo
		$this->loadModel("Pictures");
		$picInfo = $this->Pictures->getPictureBy("id", $picId);
		if ($picInfo === array()) {
			header("Location:../galery");
			return 0;
		}

		$this->setVars("picUrl", $picInfo[0]->file_url);
	}

	function logout() {
		header("Location:acceuil");
		$_SESSION["login"] = "none";
		$_SESSION["user_id"] = "none";
		$this->acceuil();
		ob_end_flush();
	}

	function accountActivation() {
		$ul = empty($_GET["ul"]) ? NULL : $_GET["ul"];
		$ua = empty($_GET["ua"]) ? NULL : $_GET["ua"];
		$this->loadModel("Users");
		$reqCond["conditions"] = array(
			"login"				=> $ul,
			"activation_hash"	=> $ua
		);
		$userRet = $this->Users->find($reqCond);
		if (count($userRet) != 1) {
			$this->e404("Your account has already been activated");
			die();
		} else if ($this->Users->confirmActivation($userRet[0]) === false) {
			$this->e404("Authentication not allowed");
			die();
		}
		$_SESSION["user_id"] = $userRet[0]->id;
		$_SESSION["login"] = $userRet[0]->login;
		$this->setVars("loginRedir", true);
	}

	function studio() {
		if ($_SESSION["user_id"] === "none") {
			header("location:login");
		}
		$this->loadModel("Pictures");
		$this->loadModel("Calcs");
		$retCalcs = $this->Calcs->getCalcs();
		$retUserPics = $this->Pictures->getPics($_SESSION["user_id"]);
		$userPics = array();
		$calcsUrl = array();
		$calcsMiniUrl = array();

		if ($retUserPics != false) {
			for ($i = 0; $i < count($retUserPics); $i++)
				$userPics[] .= $retUserPics[$i]->file_url;
			$this->setVars("userPics", $userPics);
		}
		if ($retCalcs != false) {
			for ($i = 0; $i < count($retCalcs); $i++) {
				$calcsUrl[] .= $retCalcs[$i]->file_url;
				$calcsMiniUrl[] .= str_replace(".png", "_origin.png", $retCalcs[$i]->file_url);
			}
			$this->setVars("calcsUrl", $calcsUrl);
			$this->setVars("calcsMiniUrl", $calcsMiniUrl);
		}
		$this->render("studio");
	}

	function studioDelPic() {
		if (!isset($_POST["pic"])) {
			print("NON NON !!!!");
			return 0;
		}
		$this->loadModel("Users");
		$picUrl = $this->Users->filterNewInput($_POST["pic"]);
		$this->loadModel("Pictures");
		$sqlReq = array(
			"conditions"	=> array(
				"file_url"	=> $picUrl
			)
		);
		$ret = $this->Pictures->find($sqlReq);
		if ($ret === array()) {
			if (DEBUG_MODE)
				echo "This picture is not listed in table Pictures";
			return 0;
		} else {
			$req = array(
				"conditions"	=> array(
					"file_url"	=> $picUrl
				)
			);
			$this->Pictures->delete($req);
		}
	}

	function picRegistration() {
		$this->loadModel("Pictures");
		$this->Pictures->picRegistration();
		$this->render("picRegistration");
		header("Location:studio");
	}

	function galery() {
		$this->loadModel("Pictures");
		$retPics = $this->Pictures->getPics();
		if ($retPics === false) {
			$this->e404("SRY no picture found !");
		}
		if (isset($this->request->params[0]))
			$pageNum = intval($this->request->params[0]);
		else
			$pageNum = 1;

		$nbrPics = 0;
		$nbrPics = count($retPics);
		if ($nbrPics <= 0)
			$this->e404("SRY no picture found in the database !");

		$picsUrl = array();
		for ($i = 0; $i < $nbrPics; $i++) {
			$picsUrl[] .= $retPics[$i]->file_url;
		}

		if ($pageNum < 1 or $pageNum > ($nbrPics / 6) + 1) {
			$pageNum = 1;
		}

		$this->setVars("picsUrl", $picsUrl);
		$this->setVars("nbrPics", $nbrPics);
		$this->setVars("pageReq", $pageNum);

		$this->render("galery");
	}
}
