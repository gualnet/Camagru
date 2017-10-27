<?php

class Comments extends Model
{

	private $currentUser	= false;

	function __construct()
	{
		parent::__construct();
		if(isset($_SESSION["user_id"]) and isset($_POST["pic"]) and isset($_POST["comData"]))
		{
			if($this->currentUser === "none" or $this->currentUser === "")
			{
				if(DEBUG_MODE === true)
					die("Bad session uid : 002");
				die();
			}
			$this->currentUser = $_SESSION["user_id"];
			$this->PicUrl = $_POST["pic"];
		}
		else
		{
			if(DEBUG_MODE === true)
				die("Err LikesModel : 001");
			die();
		}
	}

	function createComment($picInfo)
	{
		$req = array(
			"conditions"	=> array(
				"title"			=> "none",
				"content"		=> $_POST["comData"],
				"com_owner_id"	=> $this->currentUser,
				"picture_id"	=> $picInfo[0]->id,
				"pic_owner_id"	=> $picInfo[0]->user_id
			)
		);
		return $this->insert($req);
	}


}


?>
