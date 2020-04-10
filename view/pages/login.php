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
	<h2>SIGN-IN</h2>
	<!-- <div id="form-login"> -->
		<!-- <form class="signinForm" method="post" action=""> -->
		<form method="post">
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
			<div class="form-group">
				<input class="form-control" type="text" name="login" required="required" placeholder="Login or Email"/>
			</div>
			<div class="form-group">
				<input class="form-control" type="password" name="pwd"  required="required" placeholder="Password"/>
				<p id="pwdHelp" class="text-primary text-right font-weight-light" onclick="pwdRecovery()"><small>Forgot password</small></p>
			</div>
			<button type="submit" class="btn btn-outline-dark btn-sm">Valider</button><br />
		</form>
	<!-- </div> -->
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
		if (event.target == pwdModal || event.target == ctrlView)
		{
			pwdModal.style.display = "none";
		}
	}

</script>
