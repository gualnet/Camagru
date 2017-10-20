
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
		if(isset($_SESSION["user_id"]))
			$this->ownerLogin = $_SESSION["login"];
		if(isset($_SESSION["user_id"]))
			$this->ownerId = $_SESSION["user_id"];
	}

	private function mergePng($regPath)
	{
		if(strstr($_POST["picData"], "data:image/png;base64"))
		{
			$pic = imagecreatefrompng($_POST["picData"]);

		}
		elseif (strstr($_POST["picData"], "data:image/jpeg;base64"))
		{
			$pic = imagecreatefromjpeg($_POST["picData"]);

		}
		else
		{
			// echo "ON SCASSE00";
			return false;
		}
		imagesavealpha($pic, true);
		$picWidth = imagesx($pic);
		$picHeight = imagesy($pic);
		$picSRatio = $picWidth / $picHeight;
		$calc = imagecreatefrompng($_POST["calcData"]);
		imagesavealpha($calc, true);
		$calcWidth = imagesx($calc);
		$calcHeight = imagesy($calc);
		$calcSRatio = $calcHeight / $calcWidth;
		//calcule de la nouvelle taille du calque pour fit sur la photo
		if($calcWidth < $calcHeight) // format portrait
		{
			$newCalcHeight = $picHeight;
			$newCalcWidth = $picWidth * $calcSRatio;
		}
		else // format paysage
		{
			$newCalcWidth = $picWidth;
			$newCalcHeight = $picHeight * $calcSRatio;
		}
		// creation du calques resize
		$resizedCalc = imagecreate($newCalcWidth, $newCalcHeight);
		imagesavealpha($resizedCalc, true);
		$alphaBackground = imagecolorallocatealpha($resizedCalc, 0, 0, 0, 127);
		imagefill($resizedCalc, 0, 0, $alphaBackground);
		imagecopyresampled($resizedCalc, $calc, 0, 0, 0, 0, $newCalcWidth, $newCalcHeight, $calcWidth, $calcHeight);
		// creation du support de l'image finale
		$final_img = imagecreatetruecolor($picWidth, $picHeight);
		imagesavealpha($final_img, true);
		$alphaBackground = imagecolorallocatealpha($final_img, 0, 0, 0, 127);
		imagefill($final_img, 0, 0, $alphaBackground);
		// je merge l'ensemble
		if(strstr($_POST["picData"], "data:image/png;base64") or strstr($_POST["picData"], "data:image/jpeg;base64"))
		{
			imagecopy($final_img, $pic, 0, 0, 0, 0, $picWidth, $picHeight);
		}
		imagecopy($final_img, $resizedCalc, 0, 0, 0, 0, $picWidth, $picHeight);
		//enregistrement de l'image
		imagepng($final_img, $regPath);
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
		if($this->mergePng($this->curRegFilePath."/".$this->curRegFileName) === false)
		{
			// echo "ON SCASSE01";
			return false;
		}
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

	public function picRegistration()
	{
		if($this->picToFolder() === false)
		{
			// echo "ON SCASSE02";
			return false;
		}
		$this->picToDatabase();
	}

	public function getPics($uid=false)
	{
		if($uid)
		{
			$sqlReq = array(
				"conditions"	=> array(
					"user_id"	=> $uid
				)
			);
		}
		else
		{
			$sqlReq = array();
		}
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
