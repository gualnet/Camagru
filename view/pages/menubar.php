
<?php
	echo "<style>";
	require ROOT."view/css/menubar.css";
	echo "</style>";
?>

<div class="topMenu">
	<div id="logo"><a href="<?php HTTP_HOST ?>/pages/acceuil">CAMAGRU</a></div>
	<div id="btnContainer">
		<div class="button"><a href="<?php HTTP_HOST ?>/pages/galery">Galery</a></div>
		<?php
		if((isset($_SESSION["login"]) and $_SESSION["login"] === "none") or !isset($_SESSION["login"])) {
			?>
			<div class="button"><a href="<?php HTTP_HOST ?>/pages/login">Login</a></div>
			<div class="button"><a href="<?php HTTP_HOST ?>/pages/signup">Signup</a></div>
			<?php
		} else {
			?>
			<div class="button"><a href="<?php HTTP_HOST ?>/pages/studio">Studio</a></div>
			<div class="button"><a href="<?php HTTP_HOST ?>/pages/profil">Profil</a></div>
			<div class="button"><a href="<?php HTTP_HOST ?>/pages/logout">Sign-out</a></div>
			<?php
		}
		?>
	</div>
</div>
