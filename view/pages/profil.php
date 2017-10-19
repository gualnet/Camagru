<HTML>
	<HEAD>
		<style>
			.infoBox
			{
				margin: 0; padding: 0;
				padding-top: 2%;
			}

			.infoBox p
			{
				margin: 0; padding: 0;
				text-align: center;
				margin-top: 2%;
			}

			.galerieBox
			{
				margin: 0; padding: 0;
				border: solid 1px rgb(126, 173, 6);
			}
		</style>
	</HEAD>
	<BODY>
		<div class="centralView">
			<div class="infoBox">
				<p>User_id : <?php echo $User->id ?></p>
				<p>Login : <?php echo $User->login ?></p>
				<p>Nom : <?php echo $User->nom ?></p>
				<p>Prenom : <?php echo $User->prenom ?></p>
				<p>Mail : <?php echo $User->mail ?></p>
				<p>Password : <?php echo "*****" ?></p>
			</div>
		</div>

	</BODY>
</HTML>
