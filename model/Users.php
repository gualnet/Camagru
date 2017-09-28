
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
					"login"		=> $_POST["login"],
					"password"	=> hash("sha1", $_POST["pwd"]),
					"activated"	=> 1
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
				"password"	=> hash("sha1", $_POST["pwd"])
			));
		// print_r($req["conditions"]);
		return $this->addUser($req); //return true if process ends ok
	}

	function sendConfirmMail($login, $activator)
	{
		$to = $_POST["mail"];
		$subject = "CAMAGROu - Confirmation of registration";
		$headers = "From: webmaster@camagrou.com \r\n";
		$headers .= "Reply-To: no-reply@camagrou.com \r\n";
		$headers .= "MIME-Version: 1.0 \r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
		$message =
			"<h4>Dear ".$_POST["login"]."</h4>\r\n"
			."<p>WELCOME...</p>\r\n"
			."<p>BLABLABLA.. click -=>"
			."<a href=http://localhost:8888/pages/accountActivation/?"."ul=".$login."&ua=".$activator.">"
			."<span>HERE</span></a>  <=- </p>\r\n";

		$ret = imap_mail($to, $subject, $message, $headers);
		if($ret)
			return true;
		else
			return false;
	}

	private function genHashActivator($pwd)
	{
		$activator = hash("sha1", microtime()).$pwd["password"];
		return $activator;
	}

	public function addUser($req)
	{
		$pdoConnexion = Model::$connexions[$this->dbName];
		$activator = $this->genHashActivator($req["conditions"]);
		$sqlReq = "INSERT INTO ".$this->table
		." (login, nom, prenom, mail, password, activation_hash)"
		." VALUES (";
		foreach ($req["conditions"] as $key => $val)
		{
			$val = $pdoConnexion->quote($val);
			$sqlReq .= " $val,";
		}
		// $sqlReq .= $pdoConnexion->quote(0);
		$sqlReq .= " ".$pdoConnexion->quote($activator);
		$sqlReq .= ");";
		// echo " ->".$sqlReq."<- ";
		// die();
		try
		{
			$prep = $pdoConnexion->prepare($sqlReq);
			$prep->execute();
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
		return $activator;
	}

	function confirmActivation($usr)
	{
		$req["updates"] = array(
			"activated" => 1,
			"activation_hash" => "active"
		);
		$this->updateUser($usr->id, $req);


		// return false;
	}

	public function updateUser($user_id, $req)
	{
		$pdoConnexion = Model::$connexions[$this->dbName];
		$sqlReq = "UPDATE users SET ";
		if(isset($req["updates"]))
		{
			if(is_array($req["updates"]))
			{
				$cond = array();
				foreach ($req["updates"] as $key => $val)
				{
					if(!is_numeric($val))
					{
						$val = $pdoConnexion->quote($val);
					}
					$cond[] = "$key=$val";
				}
				$sqlReq .= implode(" ,", $cond);
			}
			else
			{
				$sqlReq .= $req["updates"];
			}
			$sqlReq .= " WHERE id=$user_id";
			// echo $sqlReq;
			try
			{
				$prep = $pdoConnexion->prepare($sqlReq);
				$prep->execute();
			}
			catch(PDOException $e)
			{
				die($e->getMessage());
			}
			return true;
		}
		return false;
	}



}


?>
