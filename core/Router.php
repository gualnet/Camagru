<?php

class Router
{

	static function parse($url, $request)
	{
		$url = trim($url, "/");
		$params = explode("/", $url);

		$request->controller = $params[0];
		if($request->controller === "")
			$request->controller = "pages";
		$request->action = isset($params[1]) ? $params[1] : "acceuil";
		$request->params = array_slice($params, 2);
		return true;
	}
}

?>
