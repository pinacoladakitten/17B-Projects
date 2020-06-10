function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie(name) {
  var getname = getCookie(name);
  if (getname == "") {
  	return false;
  }
  else {
  	return getname;
  }
}

function setCookie(cname,cvalue,exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires=" + d.toGMTString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

var makeCookie = {
	n : "name",
	v : "value",
	cook : function(name, value) {
		this.n =  name;
		this.v = value;
		return document.cookie = this.n+"="+this.v+"; path=/;";
	},

	uncook : function(name) {
		this.n =  name;
		return document.cookie = this.n+"=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	}
};