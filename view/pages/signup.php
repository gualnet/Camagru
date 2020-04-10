<HEAD>
	<?php

		ob_end_flush();
	?>
</HEAD>

<div class="centralView">

	<!-- <h2 class="title">SIGN-UP</h2> -->
	<form method="post">
		<div class="form-group">
			<input class="form-control" type="text" name="login" required="required" placeholder="Login"/>
			<?php
				if($inUse["login"] !== false)
				{
					?>
						<small class="form-text text-danger">already used</small>
					<?php
				}
			?>
		</div>
		<div class="form-group">
			<input class="form-control" type="email" name="mail" required="required" placeholder="Mail"/>
			<?php
				if($inUse["mail"] !== false)
				{
					?>
						<small class="form-text text-danger">already used</small>
					<?php
				}
			?>
		</div>
		<div class="form-group">
			<input class="form-control" type="password" name="pwd" required="required" placeholder="Password"/>
			<?php
				if($badPwd !== false)
				{
					?>
						<small class="form-text text-danger">Password must at least contain:<br />6 characters, 2 numbers, 1 maj</small>
					<?php
				}
			?>
		</div>
		
		<button type="submit" class="btn btn-outline-dark btn-sm " value="submit">Valider</button>
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
