<?php


class Dispatcher
{
	var $request;

	function __construct()
	{
		// echo "construct Dispatcher";
		$this->request = new Request();
		Router::parse($this->request->url, $this->request);
		$controller = $this->loadController();
		// print_r(get_class_methods($controller));
		if(!in_array($this->request->action, get_class_methods($controller)))
		{
			$this->error("Error ".ucfirst($this->request->controller)."Controller do not have [".$this->request->action."] methode.");
		}
		else
		{
			call_user_func_array(array($controller, $this->request->action),$this->request->params);
		}
	}

	function loadController()
	{
		$name = ucfirst($this->request->controller) . "Controller";
		// echo "NAME : " . $name;
		$file = ROOT.DIRSEP."controller".DIRSEP.$name.".php";
		// echo " -- FILE : " . $file;
		require $file;
		return new $name($this->request);
	}

	function error($msg)
	{
		header("HTTP/1.0 404 Not Found");
		$this->request = new Request();
		$this->request->controller = "errors";
		$this->request->action = "view";
		$this->request->params[0] = "404";
		$controller = $this->loadController();
		$controller->setVars("msg", $msg);
		call_user_func_array(array($controller, $this->request->action),$this->request->params);
		die();
	}

}

?>
