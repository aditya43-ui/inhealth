<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mws/mws.style.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mws/icons/icons.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/treeview/jquery.treeview.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/imagesTampilAntrian/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animation-loading.css" />
        <link rel="stylesheet" href="themes/neon/assets/css/neon.css">
        <link rel="stylesheet" href="themes/neon/assets/css/bootstrap.css">
        <!--<link rel="stylesheet" href="themes/neon/assets/css/neon-core.css">-->
        <link rel="stylesheet" href="themes/neon/assets/css/neon-theme.css">
        <link rel="stylesheet" href="themes/neon/assets/css/neon-forms.css">  

        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/mws.js"></script>

        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.maskMoney.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.maskedinput.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/socket.io.js'); ?>

        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/js.sound/jquery.jplayer.min.js'); ?>
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/js/howler.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/js/suara.antrian.js'; ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/alertjs/css/jQuery.alert.css" />
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/alertjs/js/jquery.ui.draggable.js'); ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/alertjs/js/jQuery.alert.js'); ?>
        <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl; ?>/images/icon/favicon.png"/>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        </head>
            <body>
                <style>
                    body{ /* //default */
                        background-image:url("images/antrian/bg_antrian.jpg"); 
                        background-repeat:no-repeat;
                        /*width:980px;*/
                        color:#000;
                        background-position: center top;
                        background-size: 100% auto;
                        height: 0;
                    }
                    .content{
                        margin: 0px 40px 0px 40px;
                    }
                </style>
                <!--<div style="margin-top: 128px"></div>-->
                <div class="content">
                    <?php echo $content; ?>
                </div>
            </body>
            <script type="text/javascript">
                /**
                 * reload halaman (reset) pada jam tertentu
                 */
                function reloadHalaman() {
                    var jamsekarang = $('#jamsekarang').val().split(" ");
                    var jam = jamsekarang[3].substring(0, 8);
                    if (jam == "06:00:00") {
                        location.reload();
                    }
                }
            </script>
</html>
