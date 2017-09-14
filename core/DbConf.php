<?php

class DbConf
{

	public $DB_DSN = false;
	public $DB_NAME = false;
	public $DB_USER = false;
	public $DB_PASSWORD = false;

	function __construct()
	{
		require ROOT."config".DIRSEP."database.php";
		$this->DB_DSN = $DB_DSN;
		$this->DB_NAME = $DB_NAME;
		$this->DB_USER = $DB_USER;
		$this->DB_PASSWORD = $DB_PASSWORD;
	}

}


?>
