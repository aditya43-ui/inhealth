<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div id="container">
<div id="top"> <a href="http://php-dev-zone.blogspot.in">PHP Dev Zone </a>&nbsp;: <i>Password Strength Indicator </i></div>
    <div id="wrapper">
         <div id="form">
			 <label>Choose Your Password :</label>
			 <input type="password" autocomplete="off" name="passwd" class="passwd" />
	     </div>
    </div>
<div id="bottom"><a href="http://php-dev-zone.blogspot.in/2013/07/password-strength-checker-using-jquery.html"> Go Back To Tutorial</a></div>
</div>
<!-- js placed at bottom to make page load faster -->
<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery.password_strength.js"></script>
<script type="text/javascript">
$(function()
{
	$('.passwd').password_strength(); 
});
</script>
</body>
</html>
