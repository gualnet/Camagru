<HEAD>
	<?php
	if($loginRedir === true)
	{
		header("Location:acceuil");
	}
	ob_end_flush();
	?>
</HEAD>

<div class="centralView">
	<form class="signinForm" method="post" action="">
		<h2>Please Sign-in</h2>
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
		<label>Login </label>
		<input type="text" name="login" required="required"/>
		<label>Password </label>
		<input type="password" name="pwd"  required="required"/>
		<button type="submit">OK</button>
	</form>


</div>
