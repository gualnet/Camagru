<?php

class PagesController extends Controller
{

	function acceuil()
	{
		$this->render("acceuil");
	}

	function vue($id=false)
	{
		$this->loadModel("Comments");
		if(!$id)
		{
			// $this->e404("PAGE INTROUVABLE");
			$this->setVars("Comments", false);
			$this->render("vue");
			die();
		}
		$findRet = $this->Comments->findFirst(array(
			"conditions" => "id=".$id));

		if(empty($findRet))
			$this->e404("PAGE INTROUVABLE");
		$this->setVars("Comments", $findRet);
		// print_r($findRet);
	}

	function header()
	{
		// $this->render("user_visu");
	}


}



?>
