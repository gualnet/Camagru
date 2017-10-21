<HEAD>

	<?php

		ob_end_flush();
	?>
	<style>

		.signupForm
		{
			margin: 0;
			padding: 0;
			background-color: rgb(240, 240, 245);
			display: flex;
			flex-direction: column;
			height: 70%;
			width: 30%;
			padding-left: 35%;
			padding-right: 35%;
			text-align: center;
		}

		.signupForm input/*pour la vue login*/
		{
			/*background-color: rgb(240, 240, 245);*/
			margin: 0;padding: 0;
			margin: 0;
			padding: 0;
			width: 70%;
			max-width: 200px;
			margin-left: auto;
			margin-right: auto;
		}

		.signupForm h2/*pour la vue login*/
		{
			/*background-color: rgb(240, 240, 245);*/
			margin: 0;padding: 0;
			margin-bottom: 15%;
		}

		.signupForm button
		{
			margin: auto;padding: 0;
			margin-top: 10%;
			margin-bottom: 0%;
			width: 50%;
			max-width: 50px;
		}

		.signupForm label
		{
			margin-top: 5%;
		}

		.errMsg
		{
			margin: 0;
			padding: 0;
			color: red;
			text-align: center;
		}

	</style>

</HEAD>

<!-- VARS
	$displayErrMsg
	$loginRedir
	$inUse["login"]
	$inUse["mail"]
-->
<div class="centralView">

		<form class="signupForm" method="post" action="" onsubmit="">
			<h2>SIGN-UP</h2>
			<?php
				if($inUse["login"] === false)
				{
					?>
					<label>Display Name </label>
					<?php
				}
				else
				{
					?>
					<label>Display Name </label><p class="errMsg">already used</p>
					<?php
				}
			?>
			<input type="text" name="login" required="required"/>
			<label>Name </label>
			<input type="text" name="name" required="required"/>
			<label>Surname </label>
			<input type="text" name="surname" required="required"/>
			<?php
				if($inUse["mail"] === false)
				{
					?>
					<label>Mail </label>
					<?php
				}
				else
				{
					?>
					<label>Mail </label><p class="errMsg">already used</p>
					<?php
				}
			?>
			<input type="text" name="mail" required="required"/>
			<label>Password </label>
			<input type="password" name="pwd" required="required"/>
			<button type="submit" value="submit">OK</button>
		</form>
		<?php
			if($loginRedir)
			{?>
				<script>
				var form = document.getElementsByClassName("signupForm")[0];
				var centralView = document.getElementsByClassName("centralView")[0];
				centralView.removeChild(form);
				alert("Success ! you will soon receive a mail to confirm your registration");
				</script>
			<?php
			}
		?>

</div>
