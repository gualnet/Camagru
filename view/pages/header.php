<HTML>
	<HEAD>
		<meta charset="utf-8">
		
	</HEAD>

	<BODY>
		<div class="topMenu">
			<ul>
			<li class="menuLeft"><a href="http://localhost:8888/pages/acceuil">Home</a></li>
			<li class="menuLeft"><a href="http://localhost:8888/pages/vue/1">Comment</a></li>
			<li class="menuLeft"><a href="http://localhost:8888/pages/webcamTest">test webcam</a></li>
			<?php
				if(isset($_SESSION["login"]) and $_SESSION["login"] === "none")
				{
					?>
					<li class="menuRight"><a href="http://localhost:8888/pages/login">Sign-in</a></li>
					<li class="menuRight"><a href="http://localhost:8888/pages/signup">Sign-up</a></li>
					<?php
				}
				else
				{
					?>
					<li class="menuRight"><a href="http://localhost:8888/pages/logout">Sign-out</a></li>
					<li class="menuRight"><a href="http://localhost:8888/pages/profil">Profil</a></li>
					<?php
				}
				?>
			</ul>
		</div>
