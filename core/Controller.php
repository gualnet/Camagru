<?php

class Controller
{

	private $request;
	private $vars = array();
	private $rendered = false;

	function __construct($request=null)
	{
		if($request)
		{
			$this->request = $request;
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
		// echo "!-->".$viewName." ";
		// echo " - ".$this->request->controller." - ";
		// echo "!-->".$viewPath." ";
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
		// echo "MODEL NAME:".$modelName." | ";
		$modelPath = ROOT."model".DIRSEP.$modelName.".php";
		// echo "MODEL PATH:".$modelPath." | ";
		require_once($modelPath);
		if(!isset($this->$modelName))
			$this->$modelName = new $modelName();
	}

	function e404($errMsg)
	{
		// header("HTTP/1.0 404 NOT FOUND");
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
		// echo "--->".$ctlrPath;
		require_once $ctlrPath;
		$c = new $ctlrName();
		// print_r($c->$request);
		return $c->$action();
	}


}


?>
