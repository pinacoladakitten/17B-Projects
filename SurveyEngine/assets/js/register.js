$(document).ready(function(){
	$("#hideLogin").click(function() {
		$("#loginForm").hide();
		$("#registerForm").show();
	});

	$("#hideRegister").click(function() {
		$("#loginForm").show();
		$("#registerForm").hide();
	});
});

/*
hue=0;
offsetY=1;
textColor = function(){
		hue+=5;
		offsetY*=-1;
		document.getElementById("loginContainer").style.color = "hsl("+hue+", 100%, 50%)";
		document.getElementById("loginContainer").style.position = "relative";
		document.getElementById("loginContainer").style.top = offsetY + "px";
}

window.onload = function() {
	window.setInterval(textColor, 400);
}
*/