<?php

class request
{

	public $url;

	function __construct()
	{
		$this->url = $_SERVER["REQUEST_URI"];
	}
}

?>
