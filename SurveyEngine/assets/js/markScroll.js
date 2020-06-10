var xPos = 0;
var x = 1;
var yPos = 0;
markScroll = function(){
	x*=-1;
	yPos-=10;
	xPos = x * (Math.floor(Math.random() * 17) + 1);
	document.getElementById("background").style.backgroundPosition = xPos + "px " + yPos + "px";
}

window.onload = function() {
	window.setInterval(markScroll, 20);
}