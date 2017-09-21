<?php

/** Les Variables
*	user_id
**/

class Users extends Model
{
	function checkLogin()
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
				echo "Pas de retour";
				//integrer un message d'erreur sous les cases input
				return false;
			}
			else
			{
				print_r($retFind);
				return true;
			}
		}
		else //Normalement useless
		{
			return false;
		}

	}

}


?>
