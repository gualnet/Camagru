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
	var streaming	= false;
	var video		= document.querySelector("#video");
	var photo		= document.querySelector("#photo");
	var picTakeBtn	= document.querySelector("#picTakeBtn");
	var width 		= 1024;
	var height 		= 0;


	navigator.mediaDevices.getUserMedia({video: true, audio: false})
	.then(function(stream) {
		video.srcObject = stream;
	})
	.catch(function(error) {
		console.log("Echec MEP stream video!");
	});


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
		false
	);

	picTakeBtn.addEventListener("click",
	function(ev)
	{
		if(document.querySelector("#uplInp").value != "")
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
		else if(photo != null)
		{
			photo.getContext("2d", {alpha: true}).drawImage(video, 0, 0, width, height);
			var data = photo.toDataURL("image/png");
			photo.setAttribute("src", data);
			var picData = document.querySelector("#photo").getAttribute("src");
			document.querySelector("#dataSendPic").setAttribute("value", picData);
			document.querySelector(".hiddenForm").submit();
			ev.preventDefault();
		}
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

	var btnTakePic = document.querySelector(".btnBox ul");
	btnTakePic.style.display = "block";

	var upperLayer = document.querySelector(".upperLayer");
	upperLayer.innerHTML = "";
	var upLayer_img = document.createElement("img");
	var videoW = document.querySelector("#video").clientWidth;
	var videoH = document.querySelector("#video").clientHeight;
	var uplObj = document.querySelector(".uplObj");
	if(videoW == 0 && videoH == 0)
	{
		upLayer_img.setAttribute("width", uplObj.clientWidth);
		upLayer_img.setAttribute("height", uplObj.clientHeight);
	}
	else
	{
		upLayer_img.setAttribute("width", videoW);
		upLayer_img.setAttribute("height", videoH);
	}
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
		var img = document.createElement("img");
		img.classList.add("uplObj");
		img.file = file;

		var image = document.getElementsByClassName("uplObj");
		if(image[0])
		{
			var videoBox = document.getElementsByClassName("videoBox");
			videoBox[0].removeChild(image[0]);
		}

		var videoBox = document.getElementsByClassName("videoBox");
		document.querySelector(".videoBox").appendChild(img);

		var upperLayer = document.querySelector(".upperLayer");
		var calcs = document.getElementsByClassName("calcImg");
		upperLayer.innerHTML = "";
		for (i = 0; i < calcs.length; i++)
		{
			calcs[i].style.border = "none";
			calcs[i].style.opacity = "0.3";
		}

		var reader = new FileReader();
		reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
		reader.readAsDataURL(file);
		var video = document.querySelector("#video");
		video.style.display = "none";
	}
}

</script>
