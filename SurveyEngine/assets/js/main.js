hue=0;
offsetY=1;
textColor = function(){
		hue+=5;
		offsetY*=-1;
		document.getElementById("backgroundMain").style.color = "hsl("+hue+", 100%, 50%)";
		document.getElementById("backgroundMain").style.position = "relative";
		document.getElementById("backgroundMain").style.top = offsetY + "px";

		document.getElementById("td").style.color = "hsl("+hue+", 100%, 50%)";
		document.getElementById("td").style.position = "relative";
		document.getElementById("td").style.top = offsetY + "px";
}

window.onload = function() {
	window.setInterval(textColor, 400);
}