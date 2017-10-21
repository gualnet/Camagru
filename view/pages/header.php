<HTML>
	<HEAD>
		<meta charset="utf-8">

	</HEAD>

	<BODY>
		<div class="topMenu">
			<ul>
			<li class="menuLeft"><a href="<?php HTTP_HOST ?>/pages/acceuil">Home</a></li>
			<li class="menuLeft"><a href="<?php HTTP_HOST ?>/pages/galery">Galery</a></li>
			<?php
				if(isset($_SESSION["login"]) and $_SESSION["login"] === "none")
				{
					?>
					<li class="menuRight"><a href="<?php HTTP_HOST ?>/pages/login">Sign-in</a></li>
					<li class="menuRight"><a href="<?php HTTP_HOST ?>/pages/signup">Sign-up</a></li>
					<?php
				}
				else
				{
					?>
					<li class="menuLeft"><a href="<?php HTTP_HOST ?>/pages/webcamTest">test webcam</a></li>
					<li class="menuRight"><a href="<?php HTTP_HOST ?>/pages/logout">Sign-out</a></li>
					<li class="menuRight"><a href="<?php HTTP_HOST ?>/pages/profil">Profil</a></li>
					<?php
				}
				?>
			</ul>
		</div>
