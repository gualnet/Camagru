vue.php loaded !
<div>
	<p>
		Commentaire de xx :
		<?php
			if($Comments === false)
				die();
			echo $Comments->content;
		?>
	</p>
</div>
