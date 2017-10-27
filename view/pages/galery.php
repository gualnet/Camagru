<div class="centralView">

	<div class="picModal">
			<img id="imgModal" src=""/>
			<label id="lblCom">LE COM..</label>
			<label id="lblSend" onclick="sendCom()">SEND</label>
			<input id="comInp" type="text"/>
			<div id="comments"></div>
	</div>
	<script>

		var picModal = document.querySelector(".picModal");
		function seeModal(me)
		{
			console.log("seeModal");
			var imgData = me.getAttribute("src");
			document.querySelector("#imgModal").setAttribute("src", imgData);
			picModal.style.display = "grid";
		}

		window.onclick = function(event)
		{
			if (event.target == picModal)
				picModal.style.display = "none";
		}

		function sendCom()
		{
			var comData = document.querySelector("#comInp").value;
			console.log(comData);
			var picData = document.querySelector("#imgModal").getAttribute("src");
			// console.log("000");

			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if(this.readyState == 4 && xhr.status == 200)
				{
					var rspTxt = this.responseText;

				}
			}
			xhr.open("POST", "/ajax/postCom.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("var1=postComment2&pic="+picData+"&comData="+comData);
		}
	</script>

	<div class="flexBox">
		<?php
			$pageReq -= 1;
			$cpt = 0;
			for($i = $nbrPics-1; $i >= 0; $i--)
			{
				$res = $i - ($pageReq * 6);
				if(isset($picsUrl[$res]))
				{
					$id = $i - ($pageReq * 6);
					echo "<div class=\"sticker\">";
					echo "<img class=\"img\" id=\"item-".$cpt."\" src=\""
					.$picsUrl[$id]."\" onload=\"likeChecker(this)\"
					onclick=\"seeModal(this)\"/>\n";
					echo "<div class=\"imgSubBox\">
					<ul>
						<li id=\"like\" onclick=like(this)>Like</li>
						<li id=\"unlike\" onclick=unlike(this)>Unlike</li>
						<li>Comment</li>
					</ul>
					</div>";
					echo "</div>";
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
					// echo "<a href=\"http://localhost:8888/pages/galery/".$i."\">$i</a>";
				}
			?>
		</div>

</div>

<script>

	function like(me)
	{
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "/ajax/createLike.php", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		data = me.parentElement.parentElement.parentElement.getElementsByClassName("img")[0].getAttribute("src");
		xhr.send("var1=like&pic="+data+"&var3=none");
		me.parentElement.querySelector("#like").style.display = "none";
		me.parentElement.querySelector("#unlike").style.display = "list-item";

	}

	function likeChecker(me)
	{
		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function()
		{
			if(this.readyState == 4 && xhr.status == 200)
			{
				var rspTxt = this.responseText;
				if(rspTxt === "\nTRUE")
				{
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

	function unlike(me)
	{
		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function()
		{
			if(this.readyState == 4 && this.status == 200)
			{
				var rspTxt = this.responseText;
				console.log("RSP:" + rspTxt);
				if(rspTxt === "\nTRUE")
				{
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
