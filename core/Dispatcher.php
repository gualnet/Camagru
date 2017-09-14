<?php

class Dispatcher
{

	var $request;

	function __construct()
	{
		$this->request = new Request();
		Router::parse($this->request->url, $this->request);
		// print_r($this->request);

		$controller = $this->loadController();

		// print_r($controller);
		if(!in_array($this->request->action, get_class_methods($controller)))
		{
			$this->error("Controller ".$this->request->controller
			." do not contain '".$this->request->action."' method");
		}
		call_user_func_array(array($controller, $this->request->action), $this->request->params);
		$controller->render($this->request->action);
	}

	function loadController()
	{
		$ctlrName = ucfirst($this->request->controller)."Controller";
		$ctlrPath = ROOT."controller".DIRSEP.$ctlrName.".php";
		// echo "--> ".$ctlrName;
		require $ctlrPath;
		return new $ctlrName($this->request);
	}

	function error($errMsg)
	{
		header("HTTP/1.0 404 NOT FOUND");
		$controller = new Controller($this->request);
		$controller->setVars("errMsg", $errMsg);
		$controller->render("/errors/404");
		die();
	}

}


?>
