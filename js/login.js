var existing = window.onload;
window.onload = function()
{ 
	if(typeof(existing) == "function")
	{
		  //existing();
	}
	loadCapsChecker();
}
 
function loadCapsChecker()
{	
	capsClass = "capLocksCheck";
	capsNotice = "capsLockNotice";
 
	var inputs = document.getElementsByTagName('INPUT');
	var elements = new Array();
	for(var i=0; i<inputs.length; i++)
	{
		if(inputs[i].className.indexOf(capsClass) != -1)
		{
			elements[elements.length] = inputs[i];
		}
	}	
	for(var i=0; i<elements.length; i++)
	{
		if(document.addEventListener)
		{
			elements[i].addEventListener("keypress",checkCaps,"false");
		}
		else
		{
			elements[i].attachEvent("onkeypress",checkCaps);
		}
	}	
}
 
function checkCaps(e)
{
	var pushed = (e.charCode) ? e.charCode : e.keyCode;
	var shifted = false;		
	if(e.shiftKey)
	{
		shifted = e.shiftKey;
	}
	else if (e.modifiers)
	{
		shifted = !!(e.modifiers & 4);
	}			
	var upper = (pushed >= 65 && pushed <= 90);
	var lower = (pushed >= 97 && pushed <= 122);
	if((upper && !shifted) || (lower && shifted))
	{
		if(document.getElementById(capsNotice))
		{
			document.getElementById(capsNotice).style.display = 'block';
		}
		else
		{
			alert("Caps lock is on");
		}
	}
	else if((lower && !shifted) || (upper && shifted))
	{
		if(document.getElementById(capsNotice))
		{
			document.getElementById(capsNotice).style.display = 'none';
		}
	}
        }
