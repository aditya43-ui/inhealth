var page = "run.php";

function ajax(page) {
  // native XMLHttpRequest object
  if (window.XMLHttpRequest) {
    req = new XMLHttpRequest();
    req.onreadystatechange = function() 
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
      {
         document.getElementById("sms").innerHTML = req.responseText;
      }
	}
    req.open("GET", page, true);
    req.send(null);
    // IE/Windows ActiveX version
  } 
  // pemrosesan script run.php dilakukan setiap interval 3 detik (3000 mili sekon)
  setTimeout("ajax(page)", 3000);
}


