
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
			if(isset($userPics))
			{
				$i = count($userPics) - 1;
				while($i >= 0)
				{
					echo "<img src=\"".$userPics[$i]."\" />";
					$i--;
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
	video		= document.querySelector("#video"),
	photo		= document.querySelector("#photo"),
	picTakeBtn	= document.querySelector("#picTakeBtn"),
	width 		= 1024,
	height 		= 0;

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
	console.log("stream:"+stream);
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
	var video = document.getElementsByClassName("preview");
	var videoBox = document.getElementsByClassName("videoBox");
	videoBox[0].removeChild(video[0]);
	photo = null;
	// alert("stop");
});

video.addEventListener("canplay",
function(ev)
{
	if (!streaming)
	{
		height = video.videoHeight / (video.videoWidth/width);
		// video.setAttribute("width", width);
		// video.setAttribute("height", height);
		// photo.setAttribute("width", width);
		// photo.setAttribute("height", height);
		streaming = true;
	}
},false);

picTakeBtn.addEventListener("click",
function(ev)
{
	if(photo != null)
	{
		photo.getContext("2d", {alpha: true}).drawImage(video, 0, 0, width, height);
		var data = photo.toDataURL("image/png");
		photo.setAttribute("src", data);
		var picData = document.querySelector("#photo").getAttribute("src");
		document.querySelector("#dataSendPic").setAttribute("value", picData);
		document.querySelector(".hiddenForm").submit();
		ev.preventDefault();
	}
	else
	{
		var uplobj = document.querySelector(".uplobj");
		if(uplobj)
		{
			var uplVal = uplobj.getAttribute("src");
			if(uplVal === null)
			{
				alert("uplVal="+uplVal+" Veuillez uploder une photo ou activer votre webcam");
			}
			else
			{
				var picData = document.querySelector(".uplObj").getAttribute("src");
				document.querySelector("#dataSendPic").setAttribute("value", picData);
				document.querySelector(".hiddenForm").submit();
			}
		}
	}
},false);
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

	var btnTakePic = document.querySelector(".btnBox ul");
	btnTakePic.style.display = "block";
//--------------------------test
	var upperLayer = document.querySelector(".upperLayer");
	upperLayer.innerHTML = "";
	var upLayer_img = document.createElement("img");
	var videoW = document.querySelector("#video").clientWidth;
	var videoH = document.querySelector("#video").clientHeight;
	console.log("W/H"+videoW+"/"+videoH);
	upLayer_img.setAttribute("width", videoW);
	upLayer_img.setAttribute("height", videoH);
	upLayer_img.setAttribute("src", calcUrl);
	upperLayer.appendChild(upLayer_img);



}

function showFile(files)
{
	for (var i = 0; i < files.length; i++)
	{
		var file = files[i];
		var imageType = /^image\//;

		if (!imageType.test(file.type))
		{
			continue;
		}
	//ici je modifie le dom pour afficher l'image uploadé a la place de la video
	var img = document.createElement("img");
	img.classList.add("uplObj");
	img.file = file;

	//si il y a deja une img je l'efface pour la remplacer
	var image = document.getElementsByClassName("uplObj");
	console.log(image);
	if(image[0])
	{
		console.log("BINGO"+image[0]);
		var videoBox = document.getElementsByClassName("videoBox");
		videoBox[0].removeChild(image[0]);
	}

	var videoBox = document.getElementsByClassName("videoBox");
	document.querySelector(".videoBox").appendChild(img);
	//chargement en mode asynchrone de l'image
	var reader = new FileReader();
	reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
	reader.readAsDataURL(file);
	var video = document.querySelector("#video");
	video.style.display = "none";
	// document.querySelector("#uplObj").setAttribute("max-height", "768px");
	}
}

</script>
