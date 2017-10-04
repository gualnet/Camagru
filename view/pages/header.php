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
			border-bottom: 1px dotted white;
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
			background: #ebebf5;
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
			padding-top: 2%;
			padding-bottom: 2%;
			margin-left: 5%;
			margin-right: 5%;
			border-top: 2px dotted white;

		}

		.footer p
		{
			margin: 0px;
			padding: 0px;
		}

		.centralView
		{
			/*border: 1px solid blue;*/
			background-color: #f0f0f5;
			height: 80%;
			width: 90%;
			margin-left: 5%;
			margin-right: 5%;
		}

		</style>
	</HEAD>

	<BODY>
		<div class="topMenu">
			<ul>
			<li class="menuLeft"><a href="http://localhost:8888/pages/acceuil">Home</a></li>
			<li class="menuLeft"><a href="http://localhost:8888/pages/vue/1">Comment</a></li>
			<li class="menuLeft"><a href="http://localhost:8888/pages/webcamTest">test webcam</a></li>
			<?php
				if($_SESSION["login"] === "none")
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
