<div class="centralView">
	<div id="firstColumn">
		<div id="displayContainer">
			<div id="calqueLayer"></div>
			<div id="videoLayer">
				<video id="video"></video>
			</div>
			<canvas id="photoLayer"></canvas>
		</div>

		<div id="buttonContainer" class="container-fluid">
			<label id="addPicBtn" for="uploadInput" class="btn btn-secondary btn-sm">Add your picture</label>
			<div><label id="takePictureBtn" class="btn btn-secondary btn-sm disabled" disabled onclick="takePicture()">Prendre une photo</button></div>
			<div class="dropdown">
				<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" onclick="toggleDropDownMenu()" aria-haspopup="true" aria-expanded="false">
					Dropdown button
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<!-- <a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a> -->
					<?php
					$text = str_replace(".png", "", explode("/", $calcsUrl[1])[3]);
					echo "<a class=\"dropdown-item\" href='#' onclick=\"calcSelector2(this, $calcsUrl[1])\">$text</a>";
						// if (isset($calcsMiniUrl)) {
						// 	for ($i = 0; $i < count($calcsMiniUrl); $i++) {
						// 		// echo "<img class=\"calcImg\" src=\"" . $calcsMiniUrl[$i] . "\" onclick=\"calcSelector(this)\"/>";
						// 		$text = str_replace(".png", "", explode("/", $calcsUrl[$i])[3]);
						// 		echo "<a class=\"dropdown-item\" onclick=\"calcSelector2(this, $calcsUrl[$i])\">$text</a>";
						// 	}
						// }
					?>
				</div>
			</div>
		</div>

		<div id="calquesContainer">
			<?php
			if (isset($calcsMiniUrl)) {
				for ($i = 0; $i < count($calcsMiniUrl); $i++) {
					echo "<img class=\"calcImg\" src=\"" . $calcsMiniUrl[$i] . "\" onclick=\"calcSelector(this)\"/>";
				}
			}
			?>
		</div>
	</div>

	<div id="secondColumn">
		<div id="galerieContainer" class="container-fluid">
			<?php
			if (isset($userPics)) {
				$i = count($userPics) - 1;
				while ($i >= 0) {
					echo "<div class=\"imgWrap\" >";
					echo "<img src=\"" . $userPics[$i] . "\" />";
					echo "<form class=\"\" method=\"POST\" action=\"studioDelPic\">";
					echo "<input id=\"deletePicInput\" name=\"pic\" value=\"" . $userPics[$i] . "\"/>";
					echo "<button>Delete</button>";
					echo "</form>";
					echo "</div>";
					$i--;
				}
			}
			?>
		</div>
	</div>
	



</div>
<form class="hiddenForm" method="POST" action="/pages/picRegistration">
	<input id="dataSendPic" type="image/png" name="picData" value="none1" />
	<input id="dataSendCalc" type="image/png" name="calcData" value="none2" />
	<input id="uploadInput" type="file" name="uplData" accept="image/png, image/jpeg, image/jpg" onchange="showFile(this.files)" />
</form>



<script type="text/javascript">
	const media = {}; // contain data related to the video stream
	
	// on page load start the video stream
	startVideoStream();
	async function startVideoStream() {
		media.stream = await navigator.mediaDevices.getUserMedia({ video: true });
		const {heigth, width, aspectRatio} = media.stream.getVideoTracks()[0].getSettings()
		media.height = heigth;
		media.width = width;
		media.aspectRatio = aspectRatio;

		const video = document.querySelector("#video");
		const photo = document.querySelector("#photoLayer");
		const calque = document.querySelector("#calqueLayer");

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

		// resize the video to half window width
		const windowWidth = window.innerWidth;
		media.width = (windowWidth * 50 / 100);
		media.height = media.width / media.aspectRatio;
		// video.setAttribute("width", media.width);
		// video.setAttribute("height", media.height);
		// photo.setAttribute("width", media.width);
		// photo.setAttribute("height", media.height);
		// calque.setAttribute("width", media.width);
		// calque.setAttribute("height", media.height);

		// const firstColumnElem = document.getElementById("firstColumnContainer");
		// firstColumnElem.style.maxWidth = media.width;

		// and press play
		video.play();
	};

	function calcSelector2(me, calcUrl) {
		console.log(me, calcUrl);
		const calcs = document.getElementsByClassName("calcImg");
		// const calcUrl = me.getAttribute("src").replace("_origin", "");
		
		// Make the selected img more visible
		for (i = 0; i < calcs.length; i++) {
			calcs[i].style.border = "none";
			calcs[i].style.opacity = "0.3";
		}
		me.style.border = "1px dotted #ffffff";
		me.style.opacity = "1";

		const calcData = me.getAttribute("src").replace("_origin", "");
		document.querySelector("#dataSendCalc").setAttribute("value", calcData);

		const btnTakePic = document.querySelector("#takePictureBtn");
		btnTakePic.disabled = false;
		btnTakePic.className = "btn btn-secondary btn-sm";

		const calqueLayer = document.querySelector("#calqueLayer");
		calqueLayer.innerHTML = "";

		const upLayer_img = document.createElement("img");
		const videoW = document.querySelector("#video").clientWidth;
		const videoH = document.querySelector("#video").clientHeight;
		const uploadObject = document.querySelector(".uploadObject");
		if (videoW == 0 && videoH == 0) {
			upLayer_img.setAttribute("width", uploadObject.clientWidth);
			upLayer_img.setAttribute("height", uploadObject.clientHeight);
		} else {
			upLayer_img.setAttribute("width", videoW);
			upLayer_img.setAttribute("height", videoH);
		}
		upLayer_img.setAttribute("src", calcUrl);
		calqueLayer.appendChild(upLayer_img);
	}
	function calcSelector(me) {
		const calcs = document.getElementsByClassName("calcImg");
		const calcUrl = me.getAttribute("src").replace("_origin", "");
		
		// Make the selected img more visible
		for (i = 0; i < calcs.length; i++) {
			calcs[i].style.border = "none";
			calcs[i].style.opacity = "0.3";
		}
		me.style.border = "1px dotted #ffffff";
		me.style.opacity = "1";

		const calcData = me.getAttribute("src").replace("_origin", "");
		document.querySelector("#dataSendCalc").setAttribute("value", calcData);

		const btnTakePic = document.querySelector("#takePictureBtn");
		btnTakePic.disabled = false;
		btnTakePic.className = "btn btn-secondary btn-sm";

		const calqueLayer = document.querySelector("#calqueLayer");
		calqueLayer.innerHTML = "";

		const upLayer_img = document.createElement("img");
		const videoW = document.querySelector("#video").clientWidth;
		const videoH = document.querySelector("#video").clientHeight;
		const uploadObject = document.querySelector(".uploadObject");
		if (videoW == 0 && videoH == 0) {
			upLayer_img.setAttribute("width", uploadObject.clientWidth);
			upLayer_img.setAttribute("height", uploadObject.clientHeight);
		} else {
			upLayer_img.setAttribute("width", videoW);
			upLayer_img.setAttribute("height", videoH);
		}
		upLayer_img.setAttribute("src", calcUrl);
		calqueLayer.appendChild(upLayer_img);
	}

	function showFile(files) {
		for (let i = 0; i < files.length; i++) {
			const file = files[i];
			const imageType = /^image\//;

			if (!imageType.test(file.type)) {
				continue;
			}
			const img = document.createElement("img");
			img.classList.add("uploadObject");
			img.file = file;

			const image = document.getElementsByClassName("uploadObject");

			const videoLayer = document.querySelector("#videoLayer");
			if (image[0]) {
				videoLayer[0].removeChild(image[0]);
			}
			const imgElement = videoLayer.appendChild(img);
			imgElement.style.width = media.width;
			imgElement.style.heigth = media.height;

			const calcs = document.getElementsByClassName("calcImg");
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

	async function takePicture(event) {
		const btn = document.querySelector("#takePictureBtn");
		if (btn.disabled !== false) return;
		const videoLayer = document.getElementById("videoLayer");
		console.log("VL", videoLayer.offsetWidth);
		console.log("VL", videoLayer.offsetHeight);

		console.log("VL", videoLayer.getAttribute("height"));
		const photo = document.querySelector("#photoLayer");
		photo.width = video.offsetWidth;
		photo.height = video.offsetHeight;
		// photo.width = media.width;
		// photo.height = media.height;
		console.log("media", media);
		// return ;
		if(document.querySelector("#uploadInput").value != "") {
			const uploadObject = document.querySelector(".uploadObject");
			if(uploadObject) {
				const uploadedValue = uploadObject.getAttribute("src");
				if(uploadedValue === null) {
					alert("Value="+uploadedValue+" Veuillez uploder une photo ou activer votre webcam");
				} else {
					const picData = document.querySelector(".uploadObject").getAttribute("src");
					document.querySelector("#dataSendPic").setAttribute("value", picData);
					document.querySelector(".hiddenForm").submit();
				}
			}
		} else if(photo != null) {
			try {

				// console.log("test video", video.offsetWidth)
				// console.log("test photo", photo.offsetWidth)
				photo.getContext("2d", {alpha: true}).drawImage(video, 0, 0, videoLayer.offsetWidth, videoLayer.offsetHeight);
			} catch (error) {
				console.error(error);
			}
			const data = photo.toDataURL("image/png");
			photo.setAttribute("src", data);
			// await sleep(10000);
			const picData = photo.getAttribute("src");
			document.querySelector("#dataSendPic").setAttribute("value", picData);
			document.querySelector(".hiddenForm").submit();
			
			// btn.preventDefault();
		}
	};

	function toggleDropDownMenu() {
		const menuElem = document.querySelector(".dropdown-menu");
		menuElem.style.display = (getComputedStyle(menuElem).display === "none") ? "block" : "none";
	}

	function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
	}
</script>