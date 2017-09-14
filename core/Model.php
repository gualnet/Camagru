<?php

class Model
{

	static $connexions = array();
	public $dbName = "NONE";
	public $table = false;

	function __construct()
	{
		require_once "DbConf.php";
		$dbConf = new DbConf();
		$this->dbName = $dbConf->DB_NAME;
		if(isset(Model::$connexions[$this->dbName]))
		{
			return true;
		}
		try
		{
			$pdo = new PDO($dbConf->DB_DSN, $dbConf->DB_USER, $dbConf->DB_PASSWORD);
			Model::$connexions[$this->dbName] = $pdo;
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}

		if($this->table === false)
		{
			$this->table = strtolower(get_class($this));
		}



	}

	public function find($req)
	{
		$pdoConnexion = Model::$connexions[$this->dbName];
		$sqlReq = "SELECT * FROM ".$this->table;
		if(isset($req["conditions"]))
		{
			$sqlReq .= " WHERE ".$req["conditions"];
		}
		// echo $sqlReq;
		$prep = $pdoConnexion->prepare($sqlReq);
		$prep->execute();
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	public function findFirst($req)
	{
		return current($this->find($req));
	}

}


?>
