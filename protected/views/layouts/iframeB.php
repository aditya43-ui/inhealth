<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <?php
    // Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/custom.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/custom_neon.css');
    ?>

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome5/css/all.css">
    <!-- <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon18/assets/css/fontsopensans.css"> -->
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/neon.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/bootstrap.css">
    <!--<link rel="stylesheet" href="themes/neon18/assets/css/neon-core.css">-->
    <link rel="stylesheet" href="themes/neon18/assets/css/neon-theme.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/neon-forms.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/rickshaw.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon18/assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/customnew.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon18/assets/css/custom-sidebar.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/skins/white.css">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/bootstrap.min.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->request->baseUrl;          
                                                        ?>/css/my-style.css" />-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom_neon.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animation-loading.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mainOdontogram.css" />
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/neon-custom.js'); ?>
    <?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/bootstrap-switch.min.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/loginTimer.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/toastr/toastr.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.popupoverlay.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.cookie.js'); ?>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.maskMoney.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.maskedinput.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/realtimeClock.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/webcam.js'); ?>

    <?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/alertjs/js/jQuery.alert.js');  
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/alertjs/js/jquery.ui.draggable.js'); ?>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/socket.io.js'); ?>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/dist/notiflix-aio-2.7.0.min.js'); ?>

    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/alertnotiflix/notiflixalert.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/promjs/build/jquery.dialog.min.js'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/notiflix/promjs/build/jquery.dialog.min.css" />
    <!--        <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl;   
                                                                ?>/js/alertjs/css/jQuery.alert.css" />-->
    <!-- for theme sidebar-->
    <link rel="stylesheet" href="themes/neon18/assets/css/sidebar/custom-sidebar-green.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/sidebar/neon-forms-green.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/sidebar/inovastyle.css">
</head>

<?php
if (stripos($_GET['r'], 'antrian') !== false) {
    echo '<body class="iframe" style="background: transparent;">';
} else {
    echo '<body class="iframe" style="background:#ffffff;padding:7px;">';
}
?>
<style>
    /* untuk label yg bisa refresh */
    label.refreshable:hover {
        cursor: pointer;
        color: #0000FF;
        font-weight: bold;
    }

    .main-content {
        margin: 10px;
    }
</style>

<!--<div class="container" style="width: 100%;">-->

<?php
if (isset($this->menu)) {
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type' => 'pills', // '', 'tabs', 'pills' (or 'list')
        'stacked' => false, // whether this is a stacked menu
        'items' => $this->menu,
    ));
}
?>

<div class="main-content">
    <?php echo $content; ?>
</div>

</body>
<?php
Yii::app()->clientScript->registerScript('resizeBody', '
		document.body.style.height = "10px";
', CClientScript::POS_END);
?>

</html>
<script type="text/javascript">
    // Deteksi label yang memiliki checkbox
    
    
    var app_timezone = '<?php echo Yii::app()->timeZone; ?>';
    
    $("input").parents('label.control-label').css("cursor", "pointer");

    function insert_notifikasi(params) {
        $.post("index.php?r=site/insertNotifikasi", {
                NofitikasiR: params
            },
            function(data) {
                if (data.pesan === 'ok') {
                    <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
                        var chatServer = '<?php echo Yii::app()->user->getState("nodejs_host") ?>';
                        if (chatServer == '') {
                            chatServer = 'http://localhost';
                        }
                        var chatPort = '<?php echo Yii::app()->user->getState("nodejs_port") ?>';
                        socket = io.connect(chatServer + ':' + chatPort);
                        socket.emit('send', {
                            conversationID: 'notification',
                            status: 1,
                            modul_id: data.modul_id
                        });
                        socket.disconnect();
                    <?php } ?>

                    $('#pesan_notifikasi').html(data.template);
                    if (data.count_notif == 0) {
                        $('#count_notif').text("");
                        //                    $('#count_notif').removeClass("mws-dropdown-notif");
                    } else {
                        if (data.count_notif > 10) {
                            count_notif = '10+';
                        } else if (data.count_notif > 0) {
                            count_notif = data.count_notif;
                        }
                        $('#count_notif').text(count_notif);
                        //                    $('#count_notif').addClass("mws-dropdown-notif");
                    }
                }
                return false;
            }, "json"
        );
    }
    
    
    var matched, browser;

    jQuery.uaMatch = function( ua ) {
        ua = ua.toLowerCase();

        var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
            /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
            /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
            /(msie) ([\w.]+)/.exec( ua ) ||
            ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
            [];

        return {
            browser: match[ 1 ] || "",
            version: match[ 2 ] || "0"
        };
    };

    matched = jQuery.uaMatch( navigator.userAgent );
    browser = {};

    if ( matched.browser ) {
        browser[ matched.browser ] = true;
        browser.version = matched.version;
    }

    // Chrome is Webkit, but Webkit is also Safari.
    if ( browser.chrome ) {
        browser.webkit = true;
    } else if ( browser.webkit ) {
        browser.safari = true;
    }

    jQuery.browser = browser;
</script>
<link rel="stylesheet" href="themes/neon/assets/js/daterangepicker/daterangepicker-bs3.css">
<!-- Bottom Scripts SCRIPT INI HARUS TETAP BERADA DI BAWAH -->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/gsap/main-gsap.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/joinable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/resizeable.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-api.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/vendor/d3.v3.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/rickshaw.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/raphael-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/morris.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery.peity.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery.sparkline.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/toastr.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-chat.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-demo.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/custom.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/daterangepicker/moment.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/daterangepicker/daterangepicker.js"></script>