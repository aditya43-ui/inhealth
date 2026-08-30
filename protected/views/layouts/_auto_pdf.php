<?php
$cs=Yii::app()->clientScript;
$cs->scriptMap=array(
    'bootstrap-tooltip.js'=>false,	
    'bootstrap-popover.js'=>false,
    'bootstrap.min.css'=>false,
    'jquery.js'=>false
);
?>
<!DOCTYPE html>
<html class="loading" lang="id" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
           
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/image/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">    
    <link rel="stylesheet" href="themes/neon/assets/css/neon.css">
    <title><?= CHtml::encode($this->pageTitle) ?></title>
   <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/global-prinout-pdf.css">    
    <script>
        function print_win(){
            window.print();
        }
    </script>
</head>
<body onload="print_win()">


    <!-- BEGIN: Content-->
    <?= $content ?>
    <!-- END: Content-->


</body>

</html>
