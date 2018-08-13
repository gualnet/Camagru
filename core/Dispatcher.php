<?php

class Dispatcher
{

	var $request;

	function __construct()
	{
		$this->request = new Request();
		Router::parse($this->request->url, $this->request);
		$controller = $this->loadController();
		if(!in_array($this->request->action, array_diff(get_class_methods($controller), get_class_methods(get_parent_class($controller)))))
		{
			$this->error("Controller ".$this->request->controller
			." can't reach '".$this->request->action."' page");
		}
		call_user_func_array(array($controller, $this->request->action), $this->request->params);
		$controller->render($this->request->action);
	}

	function loadController()
	{
		if(!isset($this->request->controller))
			print("pas de controller");
		$ctlrName = ucfirst($this->request->controller)."Controller";
		$ctlrPath = ROOT."controller".DIRSEP.$ctlrName.".php";
		if(file_exists($ctlrPath))
			require $ctlrPath;
		else
			$this->error("Page Introuvable");
		return new $ctlrName($this->request);
	}

	function error($errMsg)
	{
		$controller = new Controller($this->request);
		$controller->e404($errMsg);
		die();
	}
}

?>
