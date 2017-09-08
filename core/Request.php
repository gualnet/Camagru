<?php

class request
{

	public $url;

	function __construct()
	{
		// echo "construct Request";
		$this->url = $_SERVER["REQUEST_URI"];

	}
}

?>
