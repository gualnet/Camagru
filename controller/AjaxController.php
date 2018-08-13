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
		require $viewPath;
		$this->rendered = true;
	}

	public function getPicInfo()
	{
		$this->loadModel("Pictures");
		$retPicInfo = $this->Pictures->getPicsByUrl($_POST["pic"]);
		if($retPicInfo === false)
		{
			if(DEBUG_MODE)
				die("Pic not listed in database");
		}
		return($retPicInfo);
	}

}

?>
