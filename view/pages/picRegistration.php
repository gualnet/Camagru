<pre>
	<?php
		print_r($_SESSION);
		print_r($_POST["calcData"]);

	?>
</pre>

<?php
	// $userForlder = $_SESSION["user_id"]."_".$_SESSION["login"];
	// $filePath = ROOT."ressources".DIRSEP."pics".DIRSEP.$userForlder.DIRSEP;
	// if(!file_exists($filePath))//verif path
	// {
	// 	mkdir($filePath, 0777, true);
	// }
	// $fileName = microtime(true);
	// // $i = 0;
	// // while(file_exists($filePath.$fileName.".png"))
	// // {
	// // 	$fileName = $fileName.i;
	// // 	$i += 1;
	// // }
	// $fileName = $fileName.".png";
	// $expl = explode(",", $_POST["picData"]);
	// $picContent = base64_decode($expl[1]);
	// $picFile = fopen($filePath.$fileName, "w");
	// if($picFile === false)
	// {
	// 	echo "MARTE !!!!!";
	// 	die();
	// }
	// fwrite($picFile, $picContent);
	// fclose($picFile);
?>
