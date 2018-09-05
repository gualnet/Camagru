
getWindowSize = () => {
	const winW = window.innerWidth;
	const winH = window.innerHeight;
	// console.log("w:" + winW + "h:" + winH);
	const elem = document.getElementById("001");
	elem.style.backgroundSize = winW+"px "+winH+"px";
	// console.log("elem:" + elem);
}
getWindowSize(); 

window.onresize = () => getWindowSize();