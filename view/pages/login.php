<HEAD>
	<?php
	if($loginRedir === true)
	{
		header("Location:acceuil");
	}
	ob_end_flush();
	?>
	<style>
		.signinForm /*pour la vue login*/
		{
			background-color: rgb(240, 240, 245);
			margin: 0;padding: 0;
			height: 50%;
			width: 10%;
			padding-left: 45%;
			padding-right: 45%;
			display: inline-grid;
			text-align: center;
			align-content: center;
		}

		.signinForm h2/*pour la vue login*/
		{
			/*background-color: rgb(240, 240, 245);*/
			margin: 0;padding: 0;
			margin-bottom: 15%;
		}

		.signinForm button
		{
			margin: 0;padding: 0;
			margin-top: 10%;
			margin-left: 25%;
			width: 50%;
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

<div class="centralView">
	<form class="signinForm" method="post" action="">
		<h2>Please Sign-in</h2>
		<label>Login </label>
		<input type="text" name="login" required="required"/>
		<label>Password </label>
		<input type="password" name="pwd"  required="required"/>
		<button type="submit">OK</button>
	</form>
<?php
	if($displayErrMsg === true)
	{
		?>
		<div class="errLoginMsg">
			<p>Login or password incorrect</p>
		</div>
		<?php
	}
?>

</div>
