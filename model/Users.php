
<?php

/** Les Variables
*	user_id
**/

class Users extends Model
{
	function checkSignin()
	{
		// echo "--->".$_POST["login"]. " - ".$_POST["pwd"]."<---";
		if(isset($_POST["login"]) and isset($_POST["pwd"]))
		{
			$req = array(
				"conditions" => array(
					"login" => $_POST["login"],
					"password" => $_POST["pwd"]
			));
			$retFind = $this->find($req);
			if(!isset($retFind) or $retFind === array())
			{
				return false;
			}
			else
			{
				// print_r($retFind);
				return $retFind;
			}
		}
		else //Normalement useless
		{
			return false;
		}
	}

	function checkSignupValidity()
	{
		/*
		*	Verifiaction de doublon login / mail
		*/
		$retArr = array(
			"login" => false,
			"mail" => false
		);

		function checkIfExist($here, $key)
		{
			$req = array(
				"conditions" => array(
					"$key" => $_POST["$key"],
				));
			$findRet = $here->findFirst($req);
			if($findRet)
			{
				return true;
			}
			return false;
		}

		if(isset($_POST["login"]) and isset($_POST["name"]) and
		isset($_POST["surname"]) and isset($_POST["mail"]) and isset($_POST["pwd"]))
		{
			$retArr["login"] = checkIfExist($this, "login");
			$retArr["mail"] = checkIfExist($this, "mail");
		}
		return $retArr;
	}

	function registerNewUser()
	{
		print_r($_POST);

		$req = array(
			"conditions"	=> array(
				"login"		=> $_POST["login"],
				"name"		=> $_POST["name"],
				"surname"	=> $_POST["surname"],
				"mail"		=> $_POST["mail"],
				"password"	=> password_hash($_POST["pwd"], PASSWORD_BCRYPT)
			));
		print_r($req["conditions"]);
		$this->addUser($req);
	}

}


?>
