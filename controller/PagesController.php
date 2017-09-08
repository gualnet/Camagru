<?php
class PagesController extends Controller
{
	function view($nom)
	{
		loadModel


		$this->setVars("Pres", "Presentation de " . $nom . " -- ");
		$this->render($nom);
	}
}

?>
