<?php

class PagesController extends Controller
{

	function acceuil()
	{
		$this->render("acceuil");
	}

	function vue()
	{
		$this->loadModel("comments");
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
