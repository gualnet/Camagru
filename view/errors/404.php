
<div class="centralView" id="404">

	<div style="text-align: center;">
		<!-- <h3> <?php echo $errMsg; ?> </h3> -->
	</div>

</div>

<script>
	getWindowSize = () => {
		const winW = window.innerWidth;
		const winH = window.innerHeight;
		console.log("w:" + winW + "h:" + winH);
		const elem = document.getElementById("404");
		elem.style.backgroundImage = "url('http://localhost:8888/ressources/404_Not_Found.jpg')";
		elem.style.backgroundSize = winW+"px "+winH+"px";
		console.log("elem:" + elem);
	}
	getWindowSize(); 

	window.onresize = () => getWindowSize();
</script>