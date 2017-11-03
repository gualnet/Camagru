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
	<div>
		<form class="signinForm" method="post" action="">
			<h2>SIGN-IN</h2>
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
			<button type="submit">OK</button><br />
			<div id="pwdHelp" onclick="pwdRecovery()">I forgot my password</div>
		</form>
	</div>
	<div class="modal-pwdRecovery">
		<form class="formModal" method="post" action="pwdRecovery">
			<h3>Please enter your email address </h3>
			<input type="email" name="email" required="required"/>
			<button type="submit">OK</button>
		</form>
	</div>
</div>

<script>

	function pwdRecovery()
	{
		var pwdModal = document.querySelector(".modal-pwdRecovery");

		pwdModal.style.display = "flex";
	}

	window.onclick = function(event)
	{
		var ctrlView = document.querySelector(".centralView");
		var pwdModal = document.querySelector(".modal-pwdRecovery");
		var formModal = document.querySelector(".formModal");
		console.log("click");
		if (event.target == pwdModal || event.target == ctrlView)
		{
			console.log("dispar");
			pwdModal.style.display = "none";

		}
	}

</script>
