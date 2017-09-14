<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<title>CAMAGRou view!</title>
	</head>

	<body>

	<h1>My view Heading</h1>
	<p>My view paragraph.</p>
	<p>***Message <?php echo $Pres; ?></p>
	<!-- <p> <?php print_r($returnedCom); ?> </p> -->
	<p> TITRE =
		<?php echo $returnedCom[0]->title; ?>
	</p>
	<p> Contenu =
		<?php echo $returnedCom[0]->content; ?>
	</p>

	</body>
</html>
