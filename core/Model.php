<?php

class Model
{

	static $connexions = array();
	public $db = "NONE";

	function __construct()
	{
		require_once "DbConf.php";
		$dbConf = new DbConf();
		if(isset(Model::$connexions[$dbConf->DB_NAME]))
		{
			return true;
		}
		try
		{
			$pdo = new PDO($dbConf->DB_DSN, $dbConf->DB_USER, $dbConf->DB_PASSWORD);
			Model::$connexions[$dbConf->DB_NAME] = $pdo;
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
		echo " PLOP ";




	}

	public function find()
	{

	}

}


?>
