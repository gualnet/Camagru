<?php


class Model
{

	private $table = false;
	private $connexionStatus = false;
	private $dbPdo = false;

	public function __construct()
	{
		// print_r(DbConf::$db);
		if($this->$connexionStatus === true)
		{
			return true;
		}
		$dbConf = DbConf::$db;
		try
		{
			$pdo = new PDO($dbConf["DB_DSN"], $dbConf["DB_USER"], $dbConf["DB_PASSWORD"]);
			$pdo->setAttribute(PDO::ERRMODE_EXCEPTION);
			$this->dbPdo = $pdo;
			$this->$connexionStatus = true;
		}
		catch (PDOException $e)
		{
			die($e->getMessage());
		}

		if($this->table === false)
		{
			$this->$table = lcfirst(get_class($this));
		}

	}

	public function find($request)
	{
		// print_r($request);
		// echo "--->>".$this->$table."<<-- ";
		if($this->dbPdo->connect_error)
		{
			die("Erreur de connection a la db : ".$this->dbPdo->connect_error);
		}
		$sqlReq = "SELECT * FROM ".$this->$table;
		if(isset($request["conditions"]))
		{
			$sqlReq .= " WHERE ".$request["conditions"];
		}
		echo "MA REQUETE [".$sqlReq."] ";
		$prep = $this->dbPdo->prepare($sqlReq);
		$prep->execute();
		return $prep->fetchAll(PDO::FETCH_OBJ);

	}


}


?>
