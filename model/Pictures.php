
<?php

/** Les Variables
*	user_id
**/

class Pictures extends Model
{
	private $ownerLogin = false;
	private $ownerId = false;
	private $curRegFilePath = false;
	private $curRegFileName = false;

	function __construct()
	{
		parent::__construct();
		$this->ownerLogin = $_SESSION["login"];
		$this->ownerId = $_SESSION["user_id"];
	}

	private function picToFolder()
	{
		echo "construct ownerId".$this->ownerId;
		$this->curRegFilePath = "/Users/kriz/Documents/42/Camagru/ressources".DIRSEP."pics".DIRSEP
		.$this->ownerId."_".$this->ownerLogin.DIRSEP;
		if(!file_exists($this->curRegFilePath))//verif path
		{
			mkdir($this->curRegFilePath, 0777, true);
		}
		$this->curRegFileName = microtime(true);
		$this->curRegFileName = $this->curRegFileName.".png";
		$expl = explode(",", $_POST["picData"]);
		$picContent = base64_decode($expl[1]);
		$picFile = fopen($this->curRegFilePath.$this->curRegFileName, "w");
		if($picFile === false)
		{
			// echo "MARTE !!!!!";
			die();
		}
		fwrite($picFile, $picContent);
		fclose($picFile);
	}

	private function picToDatabase()
	{
		$curRegFileURL = "http://localhost:8888/ressources/pics/".$this->ownerId."_".$this->ownerLogin.DIRSEP;
		echo "->".$this->ownerLogin;
		echo "->".$this->ownerId;
		echo "->".$this->curRegFileName;
		$req = array(
			"conditions"	=> array(
				"name"		=> $this->curRegFileName,
				"file_url"	=> $curRegFileURL.$this->curRegFileName,
				"user_id"	=> $this->ownerId,
				"nbr_post"	=> 0,
				"nbr_like"	=> 0
			)
		);
		$this->insert($req);
	}

	function picRegistration()
	{
		$this->picToFolder();
		$this->picToDatabase();
	}

	function getUserPics()
	{
		$sqlReq = array(
			"conditions"	=> array(
				"user_id"	=> $_SESSION["user_id"]
			)
		);
		$retFind = $this->find($sqlReq);
		if(!isset($retFind) or $retFind === array())
		{
			// echo "pas de retour";
			return false;
		}
		return $retFind;
	}




}


?>
