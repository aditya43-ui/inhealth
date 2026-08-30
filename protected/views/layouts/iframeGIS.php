<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="en" />
	  <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

		<link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.css" media="screen, projection" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/GIS/MarkerCluster.css" media="print" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/GIS/MarkerCluster.Default.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/GIS/own_style.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/GIS/bootstrap.min.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/GIS/bootstrap-datetimepicker.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/GIS/bootstrap-select.min.css" />

		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animation-loading.css" />

		<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="page-body">
<div class="main-content">
<hr />
<style>
.panel-heading{
	background: none repeat scroll 0 0 #428bca !important;
	color : #eee !important;
}
</style>
<div class="panel-primary">
<?php echo $content; ?>
</div>
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){
    <?php if (isset($_GET["status"])) { ?>
        showToast('<?php echo $_GET["status"]; ?>');
    <?php } ?>
    $('.search-form span.required').hide();
});
// END TOAST SETTING
</script>

<!-- Bottom Scripts SCRIPT INI HARUS TETAP BERADA DI BAWAH -->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.3/leaflet.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/leaflet-hash.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/label.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/Autolinker.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/leaflet.markercluster.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/bootstrap.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/moment.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/bootstrap-select.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/amcharts.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/GIS/pie.js"></script>

<script src="<?php echo Yii::app()->baseUrl.'/data/GIS/exp_KecamatanJavaBPSJune2010.js'?>" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl.'/js/GIS/init-region.js'?>" type="text/javascript"></script>
<script src="<?php echo Yii::app()->baseUrl.'/js/GIS/penyebaran-diagnosa.js'?>" type="text/javascript"></script>
<?php
Yii::app()->clientScript->registerScript('resizeBody','
		document.body.style.height = "10px";
', CClientScript::POS_END);
?>
<!-- End Bottom Scripts -->
