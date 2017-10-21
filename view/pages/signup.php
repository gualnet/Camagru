<HEAD>

	<?php

		ob_end_flush();
	?>
</HEAD>

<div class="centralView">

		<form class="signupForm" method="post" action="" onsubmit="">
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
			<input type="text" name="login" required="required"/>
			<!-- <label>Name </label>
			<input type="text" name="name" required="required"/>
			<label>Surname </label>
			<input type="text" name="surname" required="required"/> -->
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
				document.location.href="acceuil";
				</script>
			<?php
			}
		?>

</div>
