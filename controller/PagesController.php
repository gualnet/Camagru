<?php
class PagesController extends Controller
{
	function view($nom)
	{
		$this->setVars("Pres", "Presentation de " . $nom . " -- ");

		$this->render($nom);
	}
}

?>
