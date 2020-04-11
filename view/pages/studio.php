<div class="centralView">
	<div id="displayContainer" class="container-fluid">
		<video id="video"></video>
			<div id="videoMask"></div>
			<canvas id="photo"></canvas>
	</div> <!-- display-container -->

	<div id="buttonContainer" class="container-fluid">
			<button id="addPicBtn" for="uploadInput" class="btn btn-secondary btn-sm">Add your picture</button>
			<button id="takePicBtn" class="btn btn-secondary-outlined btn-sm" disabled>Prendre une photo</button>
	</div>
	<div id="galerieContainer" class="container-fluid">
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
	<input id="uploadInput" type="file" name="uplData" accept="image/png, image/jpeg, image/jpg" onchange="showFile(this.files)" />
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
		const videoMask = document.querySelector("#videoMask");

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
		videoMask.setAttribute("width", media.width);
		videoMask.setAttribute("height", media.height);
			
		// then press play :)
		video.play();
	};


	function calcSelector(me) {
		const calcs = document.getElementsByClassName("calcImg");
		const calcUrl = me.getAttribute("src");
		//je set la visualisation de la selection du calc
		for (i = 0; i < calcs.length; i++) {
			calcs[i].style.border = "none";
			calcs[i].style.opacity = "0.3";
		}
		me.style.border = "1px dotted #ffffff";
		me.style.opacity = "1";
		const calcData = me.getAttribute("src");
		document.querySelector("#dataSendCalc").setAttribute("value", calcData);

		const btnTakePic = document.querySelector("#takePicBtn");
		btnTakePic.disabled = false;
		btnTakePic.className = "btn btn-secondary btn-sm";

		const videoMask = document.querySelector("#videoMask");
		videoMask.innerHTML = "";

		const upLayer_img = document.createElement("img");
		const videoW = document.querySelector("#video").clientWidth;
		const videoH = document.querySelector("#video").clientHeight;
		const uplObj = document.querySelector(".uplObj");
		if (videoW == 0 && videoH == 0) {
			upLayer_img.setAttribute("width", uplObj.clientWidth);
			upLayer_img.setAttribute("height", uplObj.clientHeight);
		} else {
			upLayer_img.setAttribute("width", videoW);
			upLayer_img.setAttribute("height", videoH);
		}
		upLayer_img.setAttribute("src", calcUrl);
		videoMask.appendChild(upLayer_img);
	}

	function showFile(files) {
		for (let i = 0; i < files.length; i++) {
			const file = files[i];
			const imageType = /^image\//;

			if (!imageType.test(file.type)) {
				continue;
			}
			const img = document.createElement("img");
			img.classList.add("uplObj");
			img.file = file;

			const image = document.getElementsByClassName("uplObj");
			if (image[0]) {
				const videoBox = document.getElementsByClassName("videoBox");
				videoBox[0].removeChild(image[0]);
			}

			const videoBox = document.getElementsByClassName("videoBox");
			document.querySelector(".videoBox").appendChild(img);

			const upperLayer = document.querySelector(".upperLayer");
			const calcs = document.getElementsByClassName("calcImg");
			upperLayer.innerHTML = "";
			for (i = 0; i < calcs.length; i++) {
				calcs[i].style.border = "none";
				calcs[i].style.opacity = "0.3";
			}

			const reader = new FileReader();
			reader.onload = (function(aImg) {
				return function(e) {
					aImg.src = e.target.result;
				};
			})(img);
			reader.readAsDataURL(file);
			const video = document.querySelector("#video");
			video.style.display = "none";
		}
	}
</script>