
<?php

class PagesController extends Controller
{
	public function view($nom)
	{
		$this->loadModel("Comments");
		$returnedCom = $this->Comments->find(array("conditions" => "id=1"));
		echo " **RETURNEDCOM :[";
		print_r($returnedCom);
		echo "]** ";

		$this->setVars("Pres", "Presentation de " . $nom . " -- ");
		$this->render($nom);
	}
}

?>
