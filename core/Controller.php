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

}

?>
