<HEAD>
	<?php
		ob_end_flush();
	?>
</HEAD>

<div class="centralView" id="001">
	<form class="signupForm" method="post">
		<h2>SIGN-UP</h2>
		<?php
			if($inUse["login"] === false)
			{
				?>
				<label>Login </label>
				<?php
			}
			else
			{
				?>
				<label>Login </label><p class="errMsg">already used</p>
				<?php
			}
		?>
		<input type="text" name="login" required="required" autocomplete="login"/>
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
		<input type="email" name="mail" required="required" autocomplete="email"/>
		<?php
			if($badPwd === false)
			{
				?>
				<label>Password </label>
				<?php
			}
			else
			{
				?>
				<label>Password </label><p class="errMsg">Password must at least contain:<br />6 characters, 2 numbers, 1 maj</p>
				<?php
			}
		?>
		<input type="password" name="pwd" required="required" autocomplete="password"/>
		<button type="submit" value="submit">OK</button>
	</form>
	<?php
		if($loginRedir) {
			?>
				<script>
				var form = document.getElementsByClassName("signupForm")[0];
				var centralView = document.getElementsByClassName("centralView")[0];
				centralView.removeChild(form);
				alert("Success ! you will soon receive a mail to confirm your registration");
				document.location.href="acceuil";
				</script>
			<?php
		}
	?>
</div>
