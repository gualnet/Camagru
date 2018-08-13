<?php

class Calcs extends Model
{
	function getCalcs()
	{
		$req = "";
		return $this->find($req);
	}
}

?>
