<?php

	if($loginRedir)
	{?>
		<script>
		alert("you will receive a mail to reset your password !");
		document.location.href="acceuil";
		</script>
	<?php
	}
	else
	{?>
		<script>
		alert("this address is not valide");
		document.location.href="login";
		</script>
	<?php
	}
	
?>
