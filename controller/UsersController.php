<?php

class UsersController extends Controller
{

	function login()
	{
		if($_POST)
		{
			$this->loadModel("Users");
			$loginRes = $this->Users->checkLogin();
			echo " --".$loginRes."-- ";
			if($loginRes === true)
			{
				echo "login OK";
			}
		}
	}

	function logout()
	{

	}




}

?>
