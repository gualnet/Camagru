<?php

class Likes extends Model
{

	private $currentUser	= false;
	private $picUrl			= false;
	private $picId			= false;
	private $picOwner		= false;

	function __construct()
	{
		parent::__construct();
		if(isset($_SESSION["user_id"]) and isset($_POST["var2"]))
		{
			if($this->currentUser === "none" or $this->currentUser === "")
			{
				if(DEBUG_MODE === true)
					die("Bad session uid : 002");
				die();
			}
			$this->currentUser = $_SESSION["user_id"];
			$this->PicUrl = $_POST["var2"];
		}
		else
		{
			if(DEBUG_MODE === true)
				die("Err LikesModel : 001");
			die();
		}
	}

	function createLike($picInfo)
	{
		// print_r($picInfo);
		$this->picId = $picInfo[0]->id;
		$this->picOwner = $picInfo[0]->user_id;

		$req = array(
			"conditions"	=> array(
				"user_id"	=> $this->currentUser,
				"pic_id"	=> $this->picId
			)
		);
		return $this->insert($req);

	}

	function checkLikes($picInfo)
	{
		$this->picId = $picInfo[0]->id;

		$req = array(
			"conditions"	=> array(
				"user_id"	=> $this->currentUser,
				"pic_Id"	=> $this->picId
			)
		);
		// print_r($req);
		return $this->find($req);
	}

	function unlikePic($picInfo)
	{
		$this->picId = $picInfo[0]->id;

		$req = array(
			"conditions"	=> array(
				"user_id"	=> $this->currentUser,
				"pic_Id"	=> $this->picId
			)
		);
		// print_r($req);
		return $this->delete($req);
	}
}

?>
