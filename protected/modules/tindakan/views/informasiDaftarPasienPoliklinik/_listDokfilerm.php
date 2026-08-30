<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dflip/js/libs/jquery.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dflip/js/dflip.min.js'); ?>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/dflip/css/dflip.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/dflip/css/themify-icons.min.css" rel="stylesheet" type="text/css">

<div id="flipbookContainer"></div>

<script type="text/javascript">
jQuery.browser = {};
(function () {
jQuery.browser.msie = false;
jQuery.browser.version = 0;
if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
jQuery.browser.msie = true;
jQuery.browser.version = RegExp.$1;
}
})();

jQuery(document).ready(function () {

 //uses source from online(make sure the file has CORS access enabled if used in cross domain)
 var pdf = '<?= $pdffile ?>';

 var options = {height: 500, duration: 800};

 var flipBook = $("#flipbookContainer").flipBook(pdf, options);
 console.log(flipbook)

 });

    </script>