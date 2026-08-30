
    
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	
	
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
      
        <link rel="stylesheet" href="themes/neon/assets/css/neon.css"></link>
    <script src="themes/neon/assets/bootTindakan/js/jquery-1.10.2.min.js"></script>
    <script src="themes/neon/assets/bootTindakan/js/jquery-ui.js"></script>
    <script src="themes/neon/assets/bootTindakan/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="themes/neon/assets/bootTindakan/css/bootstrap.min.css">
    <link href = "themes/neon/assets/bootTindakan/css/jquery-ui.css" rel = "stylesheet">
    <!-- Custom CSS -->
    <link href="themes/neon/assets/bootTindakan/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="themes/neon/assets/bootTindakan/searchasset/css/default.css" />
    <link rel="stylesheet" type="text/css" href="themes/neon/assets/bootTindakan/searchasset/css/component.css" />
    <script src="themes/neon/assets/bootTindakan/searchasset/js/modernizr.custom.js"></script>
    <script src="themes/neon/assets/bootTindakan/searchasset/js/classie.js"></script>
    <script src="themes/neon/assets/bootTindakan/searchasset/js/uisearch.js"></script>
    
</head>

<?php
	if(stripos($_GET['r'], 'antrian') !== false){
		echo '<body style="background: transparent;">';
	}else{
		echo '<body style="background:#ffffff;padding:7px;">';
	}
?>
<style>
	/* untuk label yg bisa refresh */
	label.refreshable:hover{
		cursor:pointer;
		color:#0000FF;
		font-weight: bold;
	}
        *,
*:before,
*:after {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
}
h1 {
  text-align: center;
}
.small-meta {
  font-size: 12px;
}
.dim {
  opacity: 0.4;
}
.image {
  width: 180px;
  height: 120px;
  background: #CCC;
  margin-left: auto;
  margin-right: auto;
}
.grid-wrapper {
  margin: 0 auto;
  width: 100%;
  vertical-align: middle;
  text-align: center;
  position: relative;
}
.tile-stats:hover {
    background:#c31884;
}
#setklik {
    background:#c31884;
}
.card-content {
/*  border: 1px solid #CCC;*/
  border-radius: 3px;
  padding: 25px 25px 10px 25px;
}
.card-content * {
  cursor: pointer;
}
.card-wrapper {
  position: relative;
/*  width: 235px;*/
/*  height: 270px;
  float: left;*/
/*  margin-right: 50px;
  margin-bottom: 50px;*/
background-color:#bcbcbc;
}
.tile-stats.tile-purple{
    background:#bcbcbc !important;
}
.c-card {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
  visibility: hidden;
}
.c-card ~ .card-content {
  transition: all 500ms ease-out;
}
.c-card ~ .card-content .card-state-icon {
  position: absolute;
  top: 5px;
  right: 5px;
  z-index: 2;
  width: 20px;
  height: 20px;
  background-position: 0 0;
  transition: all 100ms ease-out;
}
.c-card ~ .card-content:before {
  position: absolute;
  top: 1px;
  right: 1px;
  width: 0;
  height: 0;
/*  border-top: 52px solid #47cf73;*/
  border-left: 52px solid transparent;
  transition: all 200ms ease-out;
}
.c-card ~ .card-content:after {
  position: absolute;
  top: 1px;
  right: 1px;
  content: "";
  width: 0;
  height: 0;
/*  border-top: 50px solid #FFF;*/
  border-left: 50px solid transparent;
  transition: all 200ms ease-out;
}
.c-card ~ .card-content:hover {
/*  border: 1px solid #6dc5dc;*/

}
.c-card ~ .card-content:hover .card-state-icon {
  background-position: -30px 0;
}
.c-card ~ .card-content:hover:before {
/*  border-top: 52px solid #47cf73;*/
  background-color: red;
}
.c-card:checked ~ .card-content {
/*  border: 1px solid #6dc5dc;*/
}
.c-card:checked ~ .card-content .card-state-icon {
  background-position: -90px 2px;
}
.c-card:checked ~ .card-content:before {
/*  border-top: 52px solid #47cf73;*/
  background-color: red;
      background: url("https://www.shareicon.net/download/2016/08/20/817721_check.svg") no-repeat;
}
.c-card:checked ~ .card-content:after {
  border-top: 52px solid #841364;
 
}
.c-card:checked ~ .card-content::parent {
  background:blue ;
 
}

.c-card:checked:hover ~ .card-content .card-state-icon {
  background-position: -60px 2px;
}
.c-card:checked:hover ~ .card-content:before {
/*  border-top: 52px solid #47cf73;*/

}
.c-card:checked:hover ~ .card-content:after {
/*  border-top: 52px solid #47cf73;*/

}


#barset{
  background-color:white;  
  border-radius:50px;
  height:60px;
    -moz-box-shadow:    inset 0 0 10px #ededed;
   -webkit-box-shadow: inset 0 0 10px #ededed;
   box-shadow:         inset 0 0 10px #ededed;
}

#seaset{
    color:#c1298e;
    background-color:white;  
  border-radius:50px;
}
#sb-search{
   border-radius:20px; 
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  width:100%;
}

li {
  float: left;
  font-size:1.5vw;
}

li a {
  display: block;
  color: #6d2f57;
  text-align: center;
  padding: 16px;
  padding-top: 20px;
  text-decoration: none;
}

li a:hover {
  color:#c1298e;
  text-decoration: none;
}
</style>
<body>

<div class="container" style="width: 100%;">
   
    <?php echo $content; ?>
    
</div>

</body>

</html>
