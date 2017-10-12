<pre>
	<?php
		print_r($_SESSION);
		print_r($_POST["calcData"]);

	?>
</pre>

<BODY>

	<div>
		<p>Mon image</p>
		<img height="300px" width="auto" src=" <?php echo $_POST["picData"];?> "/>
		<p>Mon calc</p>
		<img height="300px" width="auto" src=" <?php echo $_POST["calcData"];?> "/>
		<p>Les deux</p>
	</div>


<?php

$pic = imagecreatefrompng($_POST["picData"]);
imagesavealpha($pic, true);
$picWidth = imagesx($pic);
$picHeight = imagesy($pic);
$picSRatio = $picWidth / $picHeight;
$calc = imagecreatefrompng($_POST["calcData"]);
imagesavealpha($calc, true);
$calcWidth = imagesx($calc);
$calcHeight = imagesy($calc);
$calcSRatio = $calcHeight / $calcWidth;

//resize du calc
if($calcWidth < $calcHeight) // format portrait
{
	$newCalcHeight = $picHeight;
	$newCalcWidth = $picWidth * $calcSRatio;
}
else
{
	echo "PAYSAGE > ";
	$newCalcWidth = $picWidth;
	$newCalcHeight = $picHeight * $calcSRatio;
}

$resizedCalc = imagecreate($newCalcWidth, $newCalcHeight);
imagesavealpha($resizedCalc, true);
$alphaBackground = imagecolorallocatealpha($resizedCalc, 0, 0, 0, 127);
imagefill($resizedCalc, 0, 0, $alphaBackground);
imagecopyresampled($resizedCalc, $calc, 0, 0, 0, 0, $newCalcWidth, $newCalcHeight, $calcWidth, $calcHeight);







$final_img = imagecreatetruecolor($picWidth, $picHeight);
imagesavealpha($final_img, true);
$alphaBackground = imagecolorallocatealpha($final_img, 0, 0, 0, 127);
imagefill($final_img, 0, 0, $alphaBackground);

imagecopy($final_img, $pic, 0, 0, 0, 0, $picWidth, $picHeight);
imagecopy($final_img, $resizedCalc, 0, 0, 0, 0, $picWidth, $picHeight);

imagepng($final_img, 'final_img.png');





?>

<img height="700px" width="auto" src=" <?php echo "http://localhost:8888/final_img.png";?> "/>


</BODY>
