<div class="centralView">
	<div class="upperLayer">
	</div>

	<div class="videoBox">
		<div class="preview">
			<video id="video"></video>
			<canvas id="photo"></canvas>
		</div>
	</div>
	<div class="btnBox">
		<div id="uplBox">
			<label id="uplLbl" for="uplInp" style="width: 150px; height: 40px;">Add your picture</label>
		</div>
		<ul>
			<li id="picTakeBtn">Prendre une photo</li>
		</ul>
	</div>
	<div class="galerieBox">
		<?php
		if (isset($userPics)) {
			$i = count($userPics) - 1;
			while ($i >= 0) {
				echo "<div class=\"imgWrap\" >";
				echo "<img src=\"" . $userPics[$i] . "\" />";
				echo "<form method=\"POST\" action=\"studioDelPic\">";
				echo "<input name=\"pic\" value=\"" . $userPics[$i] . "\"/>";
				echo "<button>Delete</button>";
				echo "</form>";
				echo "</div>";
				$i--;
			}
		}
		?>
	</div>

	<div class="calquesBox">
		<?php
		if (isset($calcsUrl)) {
			for ($i = 0; $i < count($calcsUrl); $i++) {
				echo "<img class=\"calcImg\" src=\"" . $calcsUrl[$i] . "\" onclick=\"calcSelector(this)\"/>";
			}
		}
		?>
	</div>

</div>
<form class="hiddenForm" method="POST" action="/pages/picRegistration">
	<input id="dataSendPic" type="image/png" name="picData" value="none" />
	<input id="dataSendCalc" type="image/png" name="calcData" value="none" />
	<input id="uplInp" type="file" name="uplData" accept="image/png, image/jpeg, image/jpg" onchange="showFile(this.files)" />
</form>



<script type="text/javascript">
	startVideoStream();
	async function startVideoStream() {
		const media = {
			width: 1024,
			height: 768,
			stream: undefined
		};

		media.stream = await navigator.mediaDevices.getUserMedia({
			video: true,
			width: media.width,
			heigth: media.height,
		});
		const video = document.querySelector("#video");
		const photo = document.querySelector("#photo");

		// Older browsers may not have srcObject
		if ('srcObject' in video) {
			try {
				video.srcObject = media.stream;
			} catch (error) {
				console.error(error);
				// Even if they do, they may only support MediaStream
				video.src = URL.createObjectURL(media.stream);
			}
		} else {
			video.src = URL.createObjectURL(media.stream);
		}

		video.setAttribute("width", media.width);
		video.setAttribute("height", media.height);
		photo.setAttribute("width", media.width);
		photo.setAttribute("height", media.height);
			
		// then press play :)
		video.play();
	};


	function calcSelector(me) {
		var calcs = document.getElementsByClassName("calcImg");
		var calcUrl = me.getAttribute("src");
		//je set la visualisation de la selection du calc
		for (i = 0; i < calcs.length; i++) {
			calcs[i].style.border = "none";
			calcs[i].style.opacity = "0.3";
		}
		me.style.border = "1px dotted #ffffff";
		me.style.opacity = "1";
		var calcData = me.getAttribute("src");
		document.querySelector("#dataSendCalc").setAttribute("value", calcData);

		var btnTakePic = document.querySelector(".btnBox ul");
		btnTakePic.style.display = "block";

		var upperLayer = document.querySelector(".upperLayer");
		upperLayer.innerHTML = "";
		var upLayer_img = document.createElement("img");
		var videoW = document.querySelector("#video").clientWidth;
		var videoH = document.querySelector("#video").clientHeight;
		var uplObj = document.querySelector(".uplObj");
		if (videoW == 0 && videoH == 0) {
			upLayer_img.setAttribute("width", uplObj.clientWidth);
			upLayer_img.setAttribute("height", uplObj.clientHeight);
		} else {
			upLayer_img.setAttribute("width", videoW);
			upLayer_img.setAttribute("height", videoH);
		}
		upLayer_img.setAttribute("src", calcUrl);
		upperLayer.appendChild(upLayer_img);
	}

	function showFile(files) {
		for (var i = 0; i < files.length; i++) {
			var file = files[i];
			var imageType = /^image\//;

			if (!imageType.test(file.type)) {
				continue;
			}
			var img = document.createElement("img");
			img.classList.add("uplObj");
			img.file = file;

			var image = document.getElementsByClassName("uplObj");
			if (image[0]) {
				var videoBox = document.getElementsByClassName("videoBox");
				videoBox[0].removeChild(image[0]);
			}

			var videoBox = document.getElementsByClassName("videoBox");
			document.querySelector(".videoBox").appendChild(img);

			var upperLayer = document.querySelector(".upperLayer");
			var calcs = document.getElementsByClassName("calcImg");
			upperLayer.innerHTML = "";
			for (i = 0; i < calcs.length; i++) {
				calcs[i].style.border = "none";
				calcs[i].style.opacity = "0.3";
			}

			var reader = new FileReader();
			reader.onload = (function(aImg) {
				return function(e) {
					aImg.src = e.target.result;
				};
			})(img);
			reader.readAsDataURL(file);
			var video = document.querySelector("#video");
			video.style.display = "none";
		}
	}
</script>