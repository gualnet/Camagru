<?php

class AjaxController extends Controller
{

	public function render($viewName)
	{
		if($this->rendered)
			return false;
		extract($this->vars);
		if(strpos($viewName, "/") === 0)
			$viewPath = rtrim(ROOT, "/").DIRSEP."ajax".$viewName.".php";
		else
		{
			$viewPath = ROOT.$this->request->controller.DIRSEP
				.$viewName.".php";
		}
		// print($viewPath);
		require $viewPath;
		$this->rendered = true;
	}

	public function getPicInfo()
	{
		$this->loadModel("Pictures");
		$retPicInfo = $this->Pictures->getPicsByUrl($_POST["var2"]);
		if($retPicInfo === false)
		{
			if(DEBUG_MODE)
				die("Pic not listed in database"); // pour le debug
		}
		return($retPicInfo);
	}

	function galeryAjx()
	{
		if((!isset($_POST["var1"]) or !isset($_POST["var2"])) and $_POST["var1"] !== "like")
			return false;

		$picInfo = $this->getPicInfo();
		// print_r($picInfo);

		$this->loadModel("Likes");
		$this->Likes->createLike($picInfo);
		// creer un like en base de donnee,-->ok
		// lier le like likeur_id et photoLiker_id,-->ok
		// notifier l'owner de la photo

		// incrementer le nombre de like de la photo concernées,
		// returner un true pour le changement de bouton sur la galerie.
	}


}

?>
