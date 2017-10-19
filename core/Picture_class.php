<?php

class Picture
{
	function createFile($path, $content)
	{
		if(!file_exists($path))
		{
			fopen($path, "w");
			fwrite($path, $content);
			fclose($path);
		}
	}
}

?>
