<?php

class controller
{

	public $request;
	private $vars = array();

	function __construct($request)
	{
		// echo "Controller Constructor\n";
		$this->request = $request;
	}

	public function render($viewName)
	{
		extract($this->vars);
		$viewPath = ROOT.DIRSEP."view".DIRSEP.$this->request->controller.DIRSEP.$viewName.".php";
		// echo " RENDER VIEWPATH = ".$viewPath;
		require $viewPath;
	}

	public function setVars($key, $value=null)
	{
		if(is_array($key))
		{
			$this->vars += $key;
		}
		else
		{
			$this->vars[$key] = $value;
		}
	}

	public function loadModel($modelName)
	{
		$filePath = ROOT.DIRSEP."model".DIRSEP.$modelName.".php";
		require_once($filePath);
		if(!isset($this->$modelName))
		{
			$this->$modelName = new $modelName();
		}
		else
		{
			echo " -Le model ".$modelName." a deja ete chargé- ";
		}
	}

}

?>
