# Camagru

<?php
	echo " LOGINUSED[".$loginUsed."]";
	if($loginUsed === false)
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
