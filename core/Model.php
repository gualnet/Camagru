<?php


class Model
{

	public $table = false;
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
		$sqlReq = "SELECT * FROM ".$this->$table." WHERE ".$request["conditions"];
		echo "MA REQUETE [".$sqlReq."] ";
		$prep = $this->dbPdo->prepare($sqlReq);
		$prep->execute();
		return $prep->fetchAll(PDO::FETCH_OBJ);
		echo " PREP -> OK <- ";



	}


}


?>
