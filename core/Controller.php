<?php

class Controller
{

	protected	$request;
	protected	$vars = array();
	protected	$rendered = false;

	function __construct($request=null)
	{
		if($request)
		{
			$this->request = $request;
		}
	}

	private function getCssJs($viewName)
	{
		if(strpos($viewName, "/") === 0)
		{
			$cssPath = rtrim(ROOT, "/").DIRSEP."view".DIRSEP."css".DIRSEP.$viewName.".css";
			$jsPath = rtrim(ROOT, "/").DIRSEP."view".DIRSEP."js".DIRSEP.$viewName.".js";
		}
		else
		{
			$cssPath = ROOT."view".DIRSEP."css".DIRSEP.$viewName.".css";
			$jsPath = ROOT."view".DIRSEP."js".DIRSEP.$viewName.".js";
		}
		if(file_exists($cssPath))
		{
			echo "<style>";
			require_once $cssPath;
			echo "</style>";
		}
		if(file_exists($jsPath))
		{
			echo "<script>";
			require_once $jsPath;
			echo "</script>";
		}
	}

	public function render($viewName)
	{
		if($this->rendered)
			return false;
		extract($this->vars);
		if(strpos($viewName, "/") === 0)
			$viewPath = rtrim(ROOT, "/").DIRSEP."view".$viewName.".php";
		else
		{
			$viewPath = ROOT."view".DIRSEP.$this->request->controller.DIRSEP
				.$viewName.".php";
		}
		$this->getCssJs($viewName);
		require $viewPath;
		$this->rendered = true;
	}

	public function setVars($key, $value=null)
	{
		if(is_array($key))
			$this->vars += $key;
		else
			$this->vars[$key] = $value;
	}

	function loadModel($modelName)
	{
		$modelPath = ROOT."model".DIRSEP.$modelName.".php";
		require_once($modelPath);
		if(!isset($this->$modelName))
			$this->$modelName = new $modelName();
	}

	function e404($errMsg)
	{
		$this->setVars("errMsg", $errMsg);
		$this->render("/errors/404");
		require ROOT."view/pages/footer.php";
		die();
	}


	/**
	* Request : Permet d'appeller un controller directement depuis une view.
	**/
	function request($ctlrName, $action)
	{
		$ctlrName .= "Controller";
		$ctlrPath = ROOT."controller".DIRSEP.$ctlrName.".php";
		require_once $ctlrPath;
		$c = new $ctlrName();
		return $c->$action();
	}
}

?>
