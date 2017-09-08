<?php

class Router
{

	/**
	*	Pour parser les url
	*	@param $url url a parser
	*	@return	un tableau contenant les parametres
	**/
	static function parse($url, $request)
	{
		$url = trim($url, '/');
		$params = explode('/', $url);
		$request->controller	= $params[0];
		$request->action		= isset($params[1]) ? $params[1] : "index.php";
		$request->params		= array_slice($params, 2);
		return true;
	}
}

?>
