
		<div class="centralView">

			<div class="videoBox">
				<video id="video"></video>
				<ul>
					<li id="picTakeBtn">Prendre une photo</li>
				</ul>
			</div>

			<div class="galerieBox">
				<?php
					if(isset($userPics))
					{
						for ($i = 0; $i < count($userPics); $i++)
						{
							echo "<img src=\"".$userPics[$i]."\" />";
						}
					}
				?>
				<canvas id="photo"></canvas>
			</div>

			<div class="calquesBox"	>
				<?php
					if(isset($calcsUrl))
					{
						for($i=0; $i < count($calcsUrl); $i++)
						{
							echo "<img class=\"calcImg\" src=\"".$calcsUrl[$i]."\" onclick=\"calcSelector(this)\"/>";
						}
					}
				?>
			</div>

		</div>
		<form class="hiddenForm" method="POST" action="/pages/picRegistration">
			<input id="dataSendPic" type="image/png" name="picData" value="none"/>
			<input id="dataSendCalc" type="image/png" name="calcData" value="none"/>
		</form>

<script type="text/javascript">

(function()
{
	var streaming = false,
	video	= document.querySelector("#video"),
	photo	= document.querySelector("#photo"),
	picTakeBtn	= document.querySelector("#picTakeBtn"),
	width = 1024,
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
		video.src = vendorURL.createObjectURL(stream);
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

picTakeBtn.addEventListener("click",
function(ev)
{
	photo.getContext("2d", {alpha: true}).drawImage(video, 0, 0, width, height);
	var data = photo.toDataURL("image/png");
	photo.setAttribute("src", data);
	var picData = document.querySelector("#photo").getAttribute("src");
	document.querySelector("#dataSendPic").setAttribute("value", picData);
	document.querySelector(".hiddenForm").submit();
	ev.preventDefault();
},
false);

})();

function calcSelector(me)
{
	var calcs = document.getElementsByClassName("calcImg");
	console.log("-->"+calcs+"<--"+calcs.length);
	var calcUrl = me.getAttribute("src");
	//je set la visualisation de la selection du calc
	for (i = 0; i < calcs.length; i++)
	{
		calcs[i].style.border = "none";
		calcs[i].style.opacity = "0.3";
	}
	me.style.border = "1px dotted #ffffff";
	me.style.opacity = "1";
	console.log("003");
	var calcData = me.
	document.querySelector("#dataSendCalc").setAttribute("value", calcData);

	var btnTakePic = document.querySelector(".videoBox ul");
	btnTakePic.style.display = "block";
}

	// function truc(me)
	// {
	// 	video	= document.querySelector(".videoBox #video")
	// 	var videoWidth = video.offsetWidth;
	// 	var videoHeight = video.offsetHeight;
	// 	//je set la visualisation de la selection du calc
	// 	var calcs = document.getElementsByClassName("calcImg");
	// 	// console.log(calcs);
	// 	// console.log(calcs.length);
	// 	for (i = 0; i < calcs.length; i++)
	// 	{
	// 		calcs[i].style.border = "0px";
	// 	}
	// 	me.style.border = "1px solid #0c1cf1";
	//
	// 	//j'insere mon calque sur la video
	// 	var source = me.getAttribute("src");
	// 	var sourceW = me.offsetWidth;
	// 	var sourceH = me.offsetHeight;
	// 	// console.log("SOURCE=>"+source);
	// 	// console.log("PHOTO=>"+photo);
	// 	console.log(videoWidth+"X"+videoHeight);
	// 	console.log(sourceW+"X"+sourceH);
	// 	// var photo = document.querySelector("#videoAlpha");
	// 	var videoBox = document.querySelector(".videoBox");
	// 	var toRemove = document.querySelector("#videoAlpha");
	// 	console.log("la:"+toRemove);
	// 	if(toRemove != null)
	// 	{
	// 		videoBox.removeChild(toRemove);
	// 	}
	// 	var oldContent = videoBox.innerHTML;
	// 	console.log("-->"+oldContent);
	// 	videoBox.innerHTML = "<img id=\"videoAlpha\" width=\""
	// 	+videoWidth+"\" height=\""+videoHeight+"\"/>"+oldContent;
	// 	var alpha = document.querySelector("#videoAlpha");
	// 	alpha.setAttribute("src", source);
	//
	// 	// photo.setAttribute("max-height", videoHeight);
	// 	// photo.setAttribute("max-width", videoWidth);
	// }

</script>
