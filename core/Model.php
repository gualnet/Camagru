<?php

class Model
{

	static $connexions = array();
	public $dbName = "NONE";
	protected $table = false;

	function __construct()
	{
		require_once "DbConf.php";
		$dbConf = new DbConf();
		$this->dbName = $dbConf->DB_NAME;
		if($this->table === false)
			$this->table = strtolower(get_class($this));
		if(isset(Model::$connexions[$this->dbName]))
			return true;
		try
		{
			$pdo = new PDO($dbConf->DB_DSN, $dbConf->DB_USER, $dbConf->DB_PASSWORD);
			Model::$connexions[$this->dbName] = $pdo;
			$pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			if(DEBUG_MODE)
				die($e->getMessage()); // pour le debug
			die(); //pour la prod
		}
	}

	public function filterNewInput($rawInput)
	{
		//trim
		$comSanit = trim($rawInput);
		//remove backslash - html_tags - encode html entites
		$comSanit = stripcslashes($comSanit);
		$comSanit = strip_tags($comSanit);
		$comSanit = htmlentities($comSanit);
		return $comSanit;
	}

	public function find($req)
	{
		$pdoConnexion = Model::$connexions[$this->dbName];
		$sqlReq = "SELECT * FROM ".$this->table;
		if(isset($req["conditions"]))
		{
			$sqlReq .= " WHERE ";
			if(is_array($req["conditions"]))
			{
				$cond = array();
				foreach ($req["conditions"] as $key => $val)
				{
					if(!is_numeric($val))
					{
						$val = $pdoConnexion->quote($val);
					}
					$cond[] = "$key=$val";
				}
				$sqlReq .= implode(" AND ", $cond);
				// die($sqlReq);
			}
			else
				$sqlReq .= $req["conditions"];
		}
		// print($sqlReq);
		try
		{
			$prep = $pdoConnexion->prepare($sqlReq);
			// print_r($prep);
			$prep->execute();
		}
		catch(PDOException $e)
		{
			if(DEBUG_MODE)
				die($e->getMessage()); // pour le debug
			die(); //pour la prod
		}
		return $prep->fetchAll(PDO::FETCH_OBJ);
	}

	public function findFirst($req)
	{
		return current($this->find($req));
	}

	public function insert($req)
	{
		$pdoConnexion = Model::$connexions[$this->dbName];
		$sqlReq = "INSERT INTO ".$this->table
		." (";
		if(isset($req["conditions"]))
		{
			$column = array();
			foreach($req["conditions"] as $key => $val)
			{
				// $key = $pdoConnexion->quote($key);
				$column[] = "$key";
			}
			$sqlReq .= implode(", ", $column);
			$sqlReq .= ") VALUES (";
			$cond = array();
			foreach($req["conditions"] as $key => $val)
			{
				if(!is_numeric($val))
				{
					$val = $pdoConnexion->quote($val);
				}
				$cond[] = "$val";
			}
			$sqlReq .= implode(", ", $cond);
			$sqlReq .= ");";
		}
		// echo "<p>-->".$sqlReq."<--</p>";
		try
		{
			$prep = $pdoConnexion->prepare($sqlReq);
			// print_r($prep);
			$prep->execute();
		}
		catch(PDOException $e)
		{
			if(DEBUG_MODE)
				die($e->getMessage()); // pour le debug
			die(); //pour la prod
		}
		return true;
	}

	public function delete($req)
	{
		$pdoConnexion = Model::$connexions[$this->dbName];
		$sqlReq = "DELETE FROM ".$this->table;
		if(isset($req["conditions"]))
		{
			$sqlReq .= " WHERE ";
			if(is_array($req["conditions"]))
			{
				$cond = array();
				foreach ($req["conditions"] as $key => $val)
				{
					if(!is_numeric($val))
					{
						$val = $pdoConnexion->quote($val);
					}
					$cond[] = "$key=$val";
				}
				$sqlReq .= implode(" AND ", $cond);
				// die($sqlReq);
			}
			else
				$sqlReq .= $req["conditions"];
		}
		try
		{
			$prep = $pdoConnexion->prepare($sqlReq);
			// print_r($prep);
			$prep->execute();
		}
		catch(PDOException $e)
		{
			if(DEBUG_MODE)
				die($e->getMessage()); // pour le debug
			die(); //pour la prod
		}
		return true;
	}

}


?>
