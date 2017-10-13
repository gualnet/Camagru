
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

	private function mergePng($regPath)
	{
		$pic = imagecreatefrompng($_POST["picData"]);
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
		imagecopy($final_img, $pic, 0, 0, 0, 0, $picWidth, $picHeight);
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
		$this->mergePng($this->curRegFilePath."/".$this->curRegFileName);
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
