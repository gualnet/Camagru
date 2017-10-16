
<div class="centralView">

	<div class="videoBox">
		<div id="uplBox">
			<label id="uplLbl" for="uplInp" style="width: 150px; height: 40px;">Add your picture</label>
		</div>
		<ul>
			<li id="picTakeBtn">Prendre une photo</li>
		</ul>
		<div class="preview">
			<video id="video"></video>
			<canvas id="photo"></canvas>
		</div>
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
	</div>

	<div class="calquesBox">
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
	<input id="uplInp" type="file" name="uplData" accept="image/png, image/jpeg, image/jpg" onchange="showFile(this.files)"/>
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
	var calcUrl = me.getAttribute("src");
	//je set la visualisation de la selection du calc
	for (i = 0; i < calcs.length; i++)
	{
		calcs[i].style.border = "none";
		calcs[i].style.opacity = "0.3";
	}
	me.style.border = "1px dotted #ffffff";
	me.style.opacity = "1";
	var calcData = me.getAttribute("src");
	document.querySelector("#dataSendCalc").setAttribute("value", calcData);

	var btnTakePic = document.querySelector(".videoBox ul");
	btnTakePic.style.display = "block";
}

// function showFile(myFiles)
// {
// 	for(i = 0; i < myFiles.length; i++)
// 	{
// 		console.log("i="+i+" - type:"+myFiles[i].type);
// 	}
// 	var myPic = myFiles[0];
// 	var photo = document.querySelector("#photo");
// 	//
// 	var reader = new FileReader();
// 	console.log(" 2 type:"+myPic.type);
// 	reader.onload = (function(aImg){
// 		return function(e){
// 			aImg.src = e.target.result;
// 		};
// 	})(photo);
// 	var content = reader.readAsDataURL(myPic);
// 	console.log("CONTENT = "+ content);
// }
function showFile(files) {
  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var imageType = /^image\//;

    if (!imageType.test(file.type)) {
      continue;
    }

    var img = document.createElement("img");
    img.classList.add("obj");
    img.file = file;
	var video = document.getElementsByClassName("preview");
	console.log(video);
	console.log(video[0]);
	var videoBox = document.getElementsByClassName("videoBox");
	console.log(videoBox);
	console.log(videoBox[0]);
	videoBox[0].removeChild(video[0]);
    document.querySelector(".videoBox").appendChild(img); // En admettant que "preview" est l'élément div qui contiendra le contenu affiché.

    var reader = new FileReader();
    reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
    reader.readAsDataURL(file);
  }
}

</script>
