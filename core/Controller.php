<?php

class Controller
{

	private $request;
	private $vars = array();
	private $rendered = false;

	function __construct($request)
	{
		$this->request = $request;
	}

	public function render($viewName)
	{
		if($this->rendered)
		{
			return false;
		}
		extract($this->vars);

		if(strpos($viewName, "/") === 0)
		{

			$viewPath = rtrim(ROOT, "/").DIRSEP."view".$viewName.".php";
			echo "CAS1->";
		}
		else
		{
			$viewPath = ROOT."view".DIRSEP.$this->request->controller.DIRSEP
			.$viewName.".php";
		}

		echo "!-->".$viewName;
		echo "!-->".$viewPath;
		require $viewPath;
		$this->rendered = true;
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



}


?>
