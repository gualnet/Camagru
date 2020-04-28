<div class="centralView">
	<script>
		function likeChecker(me) {
			var xhr = new XMLHttpRequest();

			xhr.onreadystatechange = function() {
				if(this.readyState == 4 && xhr.status == 200) {
					var rspTxt = this.responseText;
					if(rspTxt === "\nTRUE") {
						me.parentElement.querySelector("#like").style.display = "none";
						me.parentElement.querySelector("#unlike").style.display = "list-item";
					}
				}
			}
			xhr.open("POST", "/ajax/likeChecker.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			data = me.getAttribute("src");
			xhr.send("var1=like2&pic="+data);
		}
	</script>

	<div class="picModal">
			<img id="imgModal" src=""/>
			<label id="lblCom">COMMENTS</label>
			<label id="lblSend" onclick="sendCom()">SEND</label>
			<input id="comInp" type="text"/>
			<div id="comments"></div>
			<div id="likers"></div>
	</div>
	<script>

		var picModal = document.querySelector(".picModal");
		function seeModal(me) {
			var imgData = me.getAttribute("src");
			requestPicCom(imgData);
			requestLikersList(imgData);
			document.querySelector("#imgModal").setAttribute("src", imgData);
			picModal.style.display = "grid";
		}

		window.onclick = function(event) {
			if (event.target == picModal)
				picModal.style.display = "none";
		}

		function sendCom() {
			var comData = document.querySelector("#comInp").value;
			var picData = document.querySelector("#imgModal").getAttribute("src");

			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if(this.readyState == 4 && xhr.status == 200) {
					var rspTxt = this.responseText;
					document.querySelector("#comInp").value = "";
					requestPicCom(picData);
				}
			}
			xhr.open("POST", "/ajax/postCom.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("var1=postComment2&pic="+picData+"&comData="+comData);
		}

		function requestPicCom(picData) {
			var comBox = document.querySelector("#comments");
			comBox.innerHTML = "";
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if(this.readyState == 4 && xhr.status == 200) {
					var rspTxt = this.responseText;
					comBox.innerHTML = rspTxt;
				}
			}
			xhr.open("POST", "/ajax/getCom.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("var1=getComment2&pic="+picData);
		}

		function requestLikersList(picData) {
			var likersBox = document.querySelector("#likers");
			var xhr = new XMLHttpRequest();

			xhr.onreadystatechange = function() {
				if(this.readyState == 4 && xhr.status == 200) {
					var rspTxt = this.responseText;
					likersBox.innerHTML = rspTxt;
				}
			}
			xhr.open("POST", "/ajax/getLikers.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("var1=getLikers&pic=" + picData);
		}
	</script>

	<div id="galeryContainer">
		<?php
			$pageReq -= 1;
			$cpt = 0;
			for($i = $nbrPics-1; $i >= 0; $i--) {
				$res = $i - ($pageReq * 6);
				if(isset($picsUrl[$res])) {
					$id = $i - ($pageReq * 6);
					echo "
					<div class=\"pictureCard\">
						<img class=\"img\" id=\"item-".$cpt."\" src=\"".$picsUrl[$id]."\" onload=\"likeChecker(this)\" onclick=\"seeModal(this)\"/>
						<div class=\"cardInfoBox\">
							<div id=\"cardInfos\">
								<div>User: xxx</div>
								<div>Date: xx/xx/xx</div>
							</div>
							<div id=\"likeIco\">
								<svg id=\"unlike\" onclick=unlike(this) class=\"bi bi-heart-fill\" width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\"><path fill-rule=\"evenodd\" d=\"M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z\" clip-rule=\"evenodd\"/></svg>

								<svg id=\"like\" onclick=like(this) class=\"bi bi-heart\" width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\"><path fill-rule=\"evenodd\" d=\"M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 01.176-.17C12.72-3.042 23.333 4.867 8 15z\" clip-rule=\"evenodd\"/></svg>
							</div>
						</div>
					</div>";
				}
				if($cpt === 5)
					break;
				$cpt++;
			}
		?>
	</div>
		<div class="pagination">
			<?php
				$max = ($nbrPics / 6);
				if(is_float($max))
					$max += 1;
				for($i = 1; $i < $max; $i++)
				{
					echo "<a href=\"http://".HTTP_HOST."/pages/galery/".$i."\">$i</a>";
				}
			?>
		</div>

</div>

<script>

	function like(me) {
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "/ajax/createLike.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		data = me.parentElement.parentElement.parentElement.getElementsByClassName("img")[0].getAttribute("src");
		xhr.send("var1=like&pic="+data+"&var3=none");
		me.parentElement.querySelector("#like").style.display = "none";
		me.parentElement.querySelector("#unlike").style.display = "list-item";
	}

	function unlike(me) {
		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function() {
			if(this.readyState == 4 && this.status == 200) {
				var rspTxt = this.responseText;
				if(rspTxt === "\nTRUE") {
					me.style.display = "none";
					me.parentElement.querySelector("#like").style.display = "list-item";
				}
			}
		}
		xhr.open("POST", "/ajax/unlike.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		data = me.parentElement.parentElement.parentElement.getElementsByClassName("img")[0].getAttribute("src");
		xhr.send("var1=unlike3&pic="+data);
	}

</script>
