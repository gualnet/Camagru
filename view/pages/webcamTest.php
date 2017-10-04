<HEAD>
	<style>

	.centralView
	{
		display: grid;
		grid-template-columns: repeat(10, 10%);
		grid-template-rows: repeat(10, 10%);
	}

	.btnBox
	{
		border: 2px solid blue;
		grid-column: 1/3;
		grid-row: 2/6;
	}
	.btnBox ul
	{
		list-style-type: none;
	}
	.btnBox li
	{
		width: 70%;
		padding: 8px;
		margin-bottom: 7px;
		background-color: #33b5e5;
		color: #ebebf5;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	}
	.btnBox li:hover
	{
		background-color: #ebebf5;
		color: #33b5e5;
	}

	.videoBox
	{
		border: 2px solid red;
		grid-column: 3/8;
		grid-row: 1/8;
	}
	.videoBox video
	{
		width: 100%;
		height: auto;
		background: none;
	}

	.galerieBox
	{
		border: 2px solid green;
		grid-column: 8/11;
		grid-row: 1/8;
	}
	.galerieBox canvas
	{
		width: 70%;
		height: auto;
		margin-left: 15%;
	}

	.calquesBox
	{
		border: 2px solid black;
		grid-column: 1/11;
		grid-row: 8/11;
	}
	.calquesBox img
	{
		height: 100%;width: auto;
	}


	</style>
</HEAD>

		<div class="centralView">
			<dic  class="btnBox">
				<!-- <button >Prendre une photo</button> -->
				<ul>
					<li id="pictureBtn">Prendre une photo</li>
					<li>inactif 1</li>
					<li>inactif 2</li>
					<li>inactif 3</li>
				</ul>
			</dic>
			<div class="videoBox">
				<!-- <img  id="calcs" src="http://pngimg.com/uploads/bat/bat_PNG35.png" alt="TRUC" style="width=300px;height=150px;"/> -->
				<video id="video"></video>

			</div>
			<div class="galerieBox">
				<canvas id="photo"></canvas>
				<canvas id="photo"></canvas>
				<canvas id="photo"></canvas>
				<canvas id="photo"></canvas>
			</div>
			<picture class="calquesBox"	>
				<?php
					$path = ROOT."ressources/calcs/CALC06.png";
					if(!file_exists($path))
					{
						echo "ERROR";
						echo $path00;
					}

				?>
				<img id="calcs" src="http://pngimg.com/uploads/bat/bat_PNG35.png" alt="TRUC" style="width=300px;height=150px;"></img>
			</picture>
		</div>

		<script type="text/javascript">

		(function()
		{
			var streaming = false,
			video	= document.querySelector("#video"),
			// cover	= document.querySelector("#cover"),
			// canvas	= document.querySelector("#canvas"),
			photo	= document.querySelector("#photo"),
			pictureBtn	= document.querySelector("#pictureBtn"),
			width = 300,
			height = 0;

			navigator.getMedia	= (navigator.getUserMedia ||
				navigator.webkitGetUserMedia ||
				navigator.mozGetUserMedia ||
				navigator.msGetUserMedia);

			navigator.getMedia(
			{
				video: true,
				audio: false
			},
		function(stream)
		{
			if (navigator.mozGetUserMedia)
			{
				video.mozSrcObject = stream;
			}
			else
			{
				var vendorURL = window.URL || window.webkitURL;
				console.log("->"+vendorURL.createObjectURL(stream));
				videoBox = document.querySelector(".videoBox");
				console.log("videoBox"+videoBox);
				video.style.background = vendorURL.createObjectURL(stream);
				// video.src = vendorURL.createObjectURL(stream);
			}
			video.play();
		},
		function(err)
		{
			console.log("An error occured! " + err);
		}
	);

	video.addEventListener("canplay",
		function(ev)
		{
			if (!streaming)
			{
				height = video.videoHeight / (video.videoWidth/width);
				video.setAttribute("width", width);
				video.setAttribute("height", height);
				photo.setAttribute("width", width);
				photo.setAttribute("height", height);
				streaming = true;
			}
		},
		false);

	function takepicture()
	{
		// photo.width = width;
		// photo.height = height;
		photo.getContext("2d").drawImage(video, 0, 0, width, height);
		var data = photo.toDataURL("image/png");
		console.log("data="+data);
		photo.setAttribute("src", data);
	}

	pictureBtn.addEventListener("click",
		function(ev)
		{
			takepicture();
			ev.preventDefault();
		},
		false);

	})();

		</script>
