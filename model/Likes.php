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
		if(isset($_SESSION["user_id"]))
			$this->currentUser = $_SESSION["user_id"];
		if(isset($_POST["var2"]))
			$this->PicUrl = $_POST["var2"];
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
		$this->insert($req);
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
