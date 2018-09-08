<div class="centralView" id="001">
	<div class="upperLayer">
	</div>

	<div class="videoBox">
		<div class="preview">
			<video id="video" autoplay="true"></video>
			<canvas id="photo"></canvas>
		</div>
	</div>
	<div class="btnBox">
		<div id="uplBox">
			<label id="uplLbl" for="uplInp" style="width: 150px; height: 40px;">Add your picture</label>
		</div>
		<ul>
			<li id="picTakeBtn_off">Prendre une photo</li>
		</ul>
	</div>
	<div class="galerieBox">
		<?php
			if(isset($userPics))
			{
				$i = count($userPics) - 1;
				while($i >= 0)
				{
					echo "<div class=\"imgWrap\" >";
					echo "<img src=\"".$userPics[$i]."\" />";
					echo "<form method=\"POST\" action=\"studioDelPic\">";
					echo "<input name=\"pic\" value=\"".$userPics[$i]."\"/>";
					echo "<button>Delete</button>";
					echo "</form>";
					echo "</div>";
					$i--;
				}
			}
		?>
	</div>

	<div class="calquesBox">
	<img class="calcImg" src="/ressources/calcs/calc_bouche_prev.png" onclick="calcSelector(this)"/>
	<img class="calcImg" src="/ressources/calcs/calc_bat_prev.png" onclick="calcSelector(this)"/>
	<img class="calcImg" src="/ressources/calcs/calc_grass_prev.png" onclick="calcSelector(this)"/>
	<img class="calcImg" src="/ressources/calcs/calc_hair_prev.png" onclick="calcSelector(this)"/>
	<img class="calcImg" src="/ressources/calcs/calc_ugly_prev.png" onclick="calcSelector(this)"/>
	</div>

</div>
<form class="hiddenForm" method="POST" action="/pages/picRegistration">
	<input id="dataSendPic" type="image/png" name="picData" value="none"/>
	<input id="dataSendCalc" type="image/png" name="calcData" value="none"/>
	<input id="uplInp" type="file" name="uplData" accept="image/png, image/jpeg, image/jpg" onchange="showFile(this.files)"/>
</form>

<?php
	echo "<script>";
	require_once ROOT."view/scripts/studio.js";
	echo "</script>";
?>


