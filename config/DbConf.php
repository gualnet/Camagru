<?php

class DbConf
{
	static $db = array();

	function autoSet()
	{
		global $DB_DSN;
		global $DB_NAME;
		global $DB_USER;
		global $DB_PASSWORD;
		DbConf::$db["DB_DSN"] = $DB_DSN;
		DbConf::$db["DB_NAME"] = $DB_NAME;
		DbConf::$db["DB_USER"] = $DB_USER;
		DbConf::$db["DB_PASSWORD"] = $DB_PASSWORD;
	}
}

DbConf::autoSet();

?>
