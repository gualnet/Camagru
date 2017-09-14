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
		if($id)
		{
			$findRet = $this->Comments->findFirst(array(
				"conditions" => "id=".$id));
		}
		else
		{
			$findRet = $this->Comments->findFirst(array());
		}

		$this->setVars("Comments", $findRet);
		// print_r($findRet);
	}

	// function view($name)
	// {
	// 	$this->setVars(
	// 		array(
	// 			"test" => "Be good on ".$name
	// 			));
	// 	$this->render("index");
	// }


}



?>
