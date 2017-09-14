
<?php

class PagesController extends Controller
{
	public function view($nom)
	{
		$this->loadModel("Comments");
		$returnedCom = $this->Comments->find(array("conditions" => "id=1"));
		// $returnedCom = $this->Comments->find(array("conditions" => "1"));
		echo " **RETURNEDCOM :[";
		print_r($returnedCom);
		print_r($returnedCom[0]->id);
		echo "]** ";

		$this->setVars("Pres", "Presentation de " . $nom . " -- ", $returnedCom);
		$this->setVars("returnedCom", $returnedCom);
		$this->render($nom);
	}
}

?>
