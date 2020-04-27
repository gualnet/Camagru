<?php
		if((isset($_SESSION["login"]) and $_SESSION["login"] === "none") or !isset($_SESSION["login"]))
		{
			echo "To Sign in";
			header('Location: /pages/login');

		} else {
			echo "To Galery";
			header('Location: /pages/galery');

		}
	?>
<!-- <div class="centralView"> -->
	<!-- MA PAGE D'acceuil loaded ! -->
<!-- </div> -->
