<pre>
	<?php
		print_r($_GET);
	?>

</pre>

<div class=centralView>

	<form class="rescueForm" method="post" action="">
		<h2>New Password</h2>
		<label>Login </label>
		<input type="text" name="login" placeholder=<?php echo $_GET["ul"] ?> required="required" >
		<?php
			if($badPwd === false)
			{
				?>
				<label>New Password </label>
				<?php
			}
			else
			{
				?>
				<label>New Password </label><p class="errMsg">Password must at least contain:<br />6 characters, 2 numbers, 1 maj</p>
				<?php
			}
		?>
		<input type="password" name="pwd" required="required">
		<label>Confirm </label>
		<input type="password" name="pwd2" required="required" onkeyup="verif(this)">
		<button type="submit">OK</button>
	</form>

</div>

<script>

	function verif(me)
	{
		var pwd = document.querySelectorAll("input")[1].value;
		var btn = document.querySelectorAll("button")[0];
		if(pwd != me.value && me.value != "")
			me.style.background = "rgba(208, 39, 39, 0.5)";
		else if(pwd == me.value)
		{
			me.style.background = "rgba(40, 220, 20, 0.5)";
			btn.style.display = "block";
		}
		else
			me.style.background = "rgba(255, 255, 255)";
	}

</script>
