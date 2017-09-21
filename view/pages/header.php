header
<HTML>
	<HEAD>
		<meta charset="utf-8">
		<style>

		.topMenu ul {
			margin: 0;
			padding: 0;
			background: rgb(240, 240, 245);
			height: 8vh;
			margin-left: 5vw;
			margin-right: 5vw;
			margin-top: 0vh;
			margin-bottom: 0vh;
		}

		.menuLeft {
			margin: 0;
			padding: 0;
			list-style-type: none;
			float: left;
			background: rgb(235, 235, 245);
			height: 4vh;
			padding-left: 0.5vw;
			padding-right: 0.5vw;
			padding-top: 2vh;
			padding-bottom: 2vh;
			border-right: 1px dotted white;
		}

		.menuRight
		{
			margin: 0;
			padding: 0;
			list-style-type: none;
			float: right;
			background: rgb(235, 235, 245);
			height: 4vh;
			padding-left: 0.5vw;
			padding-right: 0.5vw;
			padding-top: 2vh;
			padding-bottom: 2vh;

			border-left: 1px dotted white;
		}

		.footer
		{
			margin: 0;
			padding: 0;
			background-color: rgb(240, 240, 245);
			/*border: solid 1px red;*/
			text-align: center;
			width: 90%;
			margin-top: 2%;
			margin-left: 5%;
			margin-right: 5%;
		}

		.footer p
		{
			margin: 0px;
			padding: 0px;
		}

		.centralView
		{
			/*border: 1px solid blue;*/
			background-color: rgb(240, 240, 245);
			height: 80%;
			width: 90%;
			margin-left: 5%;
			margin-right: 5%;
		}

		.centralView form /*pour la vue login*/
		{
			/*background-color: rgb(240, 240, 245);*/
			text-align: center;
		}

		.errLoginMsg p
		{
			margin: 0;
			padding: 0;
			block-size: 2em;
			color: red;
			text-align: center;
			padding-top: 1em;
		}

		</style>
	</HEAD>

	<BODY>
		<div class="topMenu">
			<ul>
			<li class="menuLeft"><a href="http://localhost:8888/pages/acceuil">Home</a></li>
			<li class="menuLeft"><a href="http://localhost:8888/pages/vue/1">Comment</a></li>
			<li class="menuLeft"><a href="http://localhost:8888/pages/profil/2">Profil</a></li>
			<?php
				if($_SESSION["login"] === "none")
				{
					?>
					<li class="menuRight"><a href="http://localhost:8888/pages/login">Sign-in</a></li>
					<?php
				}
				else
				{
					?>
					<li class="menuRight"><a href="http://localhost:8888/pages/logout">Sign-out</a></li>
					<?php
				}
				?>
			  <li class="menuRight">Sign-up</li>
			</ul>
		</div>
	</BODY>
</HTML>
