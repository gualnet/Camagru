<div class="centralView">
	<div class="subCV">
		<img id="imgModal" src="<?php echo $picUrl; ?>" />
		<label id="lblCom">COMMENTS</label>
		<label id="lblSend" onclick="sendCom()">SEND</label>
		<input id="comInp" type="text"/>
		<div id="comments"></div>
	</div>

	<script>

		function sendCom()
		{
			var comData = document.querySelector("#comInp").value;
			var picData = document.querySelector("#imgModal").getAttribute("src");

			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if(this.readyState == 4 && xhr.status == 200)
				{
					var rspTxt = this.responseText;

					document.querySelector("#comInp").value = "";
					requestPicCom(picData);
				}
			}
			xhr.open("POST", "/ajax/postCom.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("var1=postComment2&pic="+picData+"&comData="+comData);
		}

		function requestPicCom(picData)
		{
			var comBox = document.querySelector("#comments");
			comBox.innerHTML = "";
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function()
			{
				if(this.readyState == 4 && xhr.status == 200)
				{
					var rspTxt = this.responseText;
					comBox.innerHTML = rspTxt;
				}
			}
			xhr.open("POST", "/ajax/getCom.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("var1=getComment2&pic="+picData);
		}

		window.onload = function()
		{
			var picData = document.querySelector("#imgModal").getAttribute("src");
			var comBox = document.querySelector("#comments");
			var xhr = new XMLHttpRequest();

			xhr.onreadystatechange = function()
			{
				if(this.readyState == 4 && xhr.status == 200)
				{
					var rspTxt = this.responseText;
					comBox.innerHTML = rspTxt;
				}
			}
			xhr.open("POST", "/ajax/getCom.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.send("var1=getComment2&pic="+picData);
		}
	</script>
