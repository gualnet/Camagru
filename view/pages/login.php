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
		<form method="post">
		<?php
				if($displayErrMsg === true)
				{
					?>
					<div class="errLoginMsg form-group">
						<p>Wrong login or possword</p>
					</div>
					<?php
				}
			?>
			<div class="form-group">
				<input class="form-control" type="text" name="login" required="required" placeholder="Login or Email"/>
			</div>
			<div class="form-group">
				<input class="form-control" type="password" name="pwd"  required="required" placeholder="Password"/>
				<p id="pwdHelp" class="text-primary text-right font-weight-light" ><small onclick="pwdRecovery()">Forgot password</small></p>
			</div>
			<button type="submit" class="btn btn-outline-dark btn-sm">Valider</button><br />
		</form>

	<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Password recovery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span id="btn_close_modal" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form class="formModal" method="post" action="pwdRecovery">
					<input type="email" name="email" required="required" placeholder="Enter your email"/>
      </div>
      <div class="modal-footer">
					<button type="submit" class="btn btn-primary">Send</button>
				</form>
				
      </div>
    </div>
  </div>
</div>

<script>

	function pwdRecovery()
	{
		var pwdModal = document.querySelector(".modal");

		pwdModal.style.display = "block";
	}

	window.onclick = function(event)
	{
		console.log('click', event.target)
		// const ctrlView = document.querySelector(".centralView");
		const pwdModal = document.querySelector(".modal");
		const closeModal = document.querySelector("#btn_close_modal");
		// const formModal = document.querySelector(".formModal");
		if (event.target == pwdModal || event.target == closeModal)
		{
			pwdModal.style.display = "none";
		}
	}

</script>
