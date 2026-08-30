<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <?php
    $modul = null;
    if (isset(Yii::app()->session['modul_id'])) {
        $modul = ModulK::model()->findByPk(Yii::app()->session['modul_id']);
    }
    if ($modul) { ?>
        <link rel="shortcut icon" href="<?php echo Params::urlIconModulDirectory() . $modul->icon_modul; ?>" />
    <?php  } else { ?>
        <link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl; ?>/images/icon/faveicon.png" />
    <?php  } ?>
    <style>
        .ui-jqgrid-hbox {
            background: #DCEDFA !important;
        }

        .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-jqgrid-labels th {
            background: #DCEDFA !important;
            font-weight: bold;
            border-left: 1px solid #DDDDDD !important;
            color: #333333 !important;
            vertical-align: bottom !important;
            height: 30px;
        }

        .ui-jqgrid {
            border: 1px solid #DDDDDD !important;
        }

        .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-jqgrid-labels th:hover {
            border: none !important;
        }

        .ui-jqgrid-btable {
            border: none !important;
        }

        .ui-jqgrid-btable tbody {
            border: none !important;
        }

        .ui-jqgrid-btable tbody .jqgrow {
            height: 25px !important;
        }

        .ui-jqgrid-btable tbody .jqgrow td {
            border: none !important;
            border-left: 1px solid #DDDDDD !important;
            vertical-align: bottom !important
        }

        .link-a {
            text-decoration: none;
            margin-top: 2px;
        }

        a.link-a:hover {
            text-decoration: none;
            font-color: #fff !important;
        }

        /* untuk label yg bisa refresh */
        label.refreshable:hover {
            cursor: pointer;
            color: #0000FF;
            font-weight: bold;
        }

        .shortcut {
            text-transform: uppercase;
            padding: 20px 10px !important;
        }

        .shortcut img {
            display: inline-block;
            margin-bottom: 8px !important;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--<link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->request->baseUrl; 
                                                        ?>/css/mws/mws.style.css" media="screen" />-->
    <!--<link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->request->baseUrl; 
                                                        ?>/css/mws/icons/icons.css" media="screen" />-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/treeview/jquery.treeview.css" media="screen" />
    <!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/alertjs/css/jQuery.alert.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animation-loading.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/toastr/toastr.css" />
    <!--Form Smart Wizard-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/formWizard/smart_wizard.css" />
    <?php /* <script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/howler.min.js'; ?>"></script> */ ?>
    <?php /* <script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/suara.antrian.js'; ?>"></script> */ ?>
    <?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery-1.3.2.js'); 
    ?>
    <?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mws.js'); 
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/loginTimer.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/toastr/toastr.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.cookie.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.maskMoney.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.maskedinput.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/realtimeClock.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/webcam.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/alertjs/js/jQuery.alert.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/alertjs/js/jquery.ui.draggable.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/socket.io.js'); ?>
    <link rel="shortcut icon" href="fav.ico" type="image/x-icon" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/custom.css');
    ?>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
</head>

<body>
    <?php
    $namaInstalasi = Yii::app()->user->getState('instalasi_nama');
    $namaRuangan = Yii::app()->user->getState('ruangan_nama');
    $idModul = ((!empty($this->module->id)) ? $this->module->id : null);
    $idUser = ((!empty(Yii::app()->user->id)) ? Yii::app()->user->id : null);
    $modulMenu = (!empty($this->module->menu) ? $this->module->menu : null);
    //            $modulMenu = $this->module->menu;
    $tglLogin = Yii::app()->user->getState('lastLoginTime');
    if (!empty($tglLogin)) {
        $tglLogin = MyFormatter::formatDateTimeForUser($tglLogin);
    }
    $records = array();
    $informasi = '<ul class="pull-right nav">
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown" onclick="viewPengumuman();">
                                    <i class="entypo-info-circled"></i>
                                    Informasi
                                </a>
                            </li>
                        </ul>';
    $isi_notif = "";
    $notifikasi = '<span class="pull-right nav">
                <div id="mws-user-tools" class="clearfix">
                <div id="mws-user-notif" class="mws-dropdown-menu">
                <a href="#" class="link-a" style="display:inline-block;padding:0px;color:#ffffff;margin-right:-10px;" onclick="viewNotifikasi();"><i class="icon-list-alt icon-white"></i> Notifikasi <span id="count_notif" ></span></a>
                    <!-- <div class="mws-dropdown-box">
                        <div class="mws-dropdown-content">
                            <ul class="mws-messages" id="pesan_notifikasi">' . $isi_notif . '</ul> -->
                            <!--
                            <div class="mws-dropdown-viewall">
                                <a href="index.php?r=sistemAdministrator/nofitikasiR/admin" onClick="window.location=this.href;">View All Comment</a>
                            </div>
                        </div>
                    </div> -->
                </div></div></span>';
    $a = array();
    $link_home = "";
    $nama_url = "";
    if (isset($_GET['r'])) {
        $a = explode("/", $_GET['r']);
        $link_home = Yii::app()->createUrl($a[0]);
        if ($modul) {
            $link_home .= '&modul_id=' . $modul->modul_id;
        }
        if ($a[0] == 'site' && isset(Yii::app()->session['modul_id'])) {
            unset(Yii::app()->session['modul_id']);
        }
    }
    ?>
    <div class="head-fix">
        <table class="box-header">
            <tr>
                <td rowspan="2" class="logo-rumkit">
                    <div class="bg-logo">
                        <a href="#" onclick="return false;">
                            <img src="<?php echo Params::urlProfilRSDirectory() . Yii::app()->user->getState('logo_rumahsakit'); ?> " alt="LOGO" style="max-height:50px" alt="LOGO" title="<?php echo Yii::app()->user->getState('nama_rumahsakit'); ?>" />
                        </a>
                    </div>
                </td>
                <td height="30px">
                    <?php $this->widget('bootstrap.widgets.BootNavbar2', array(
                        'fixed' => false,
                        'brand' => false,
                        'brandUrl' => Yii::app()->createUrl('/site/index'),
                        'collapse' => false, // requires bootstrap-responsive.css
                        'fluid' => false,
                        'excontainer' => 'cont2',
                        'items' =>
                        array(
                            array(
                                'class' => 'bootstrap.widgets.BootMenu',
                                'htmlOptions' => array('class' => 'pull-right'),
                                'encodeLabel' => false,
                                'items' => array(
                                    array('label' => 'Login', 'url' => Yii::app()->createUrl('/site/login'), 'visible' => Yii::app()->user->isGuest),
                                    array(
                                        'label' => ' <i class="icon-user icon-white"></i> ' . Yii::app()->user->name, 'visible' => !Yii::app()->user->isGuest,
                                        'items' => array(
                                            array('label' => ''),
                                            array('label' => 'Ganti Password', 'url' => 'javascript:dialogGantiPassword()'),
                                            array('label' => 'Ganti Kertas', 'url' => 'javascript:dialog_kertas()', array('id' => Yii::app()->user->id)),
                                            array('label' => 'Profile', 'url' => 'javascript:viewUser()'),
                                            array('label' => 'Tulis Pengumuman', 'visible' => (!Yii::app()->user->isGuest), 'url' => 'javascript:dialogTulisPengumuman()'),
                                            array('label' => 'Toggle Banner', 'visible' => (!Yii::app()->user->isGuest), 'url' => 'javascript:hideBanner();'),
                                            array('label' => 'Toggle Fullscreen', 'visible' => (!Yii::app()->user->isGuest), 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'javascript:toggleFullScreen();')),
                                            '---',
                                            array('label' => 'Logout', 'url' => Yii::app()->createUrl('/site/logout')),
                                        )
                                    ),
                                ),
                            ),
                            array(
                                'class' => 'ListUserChat',
                                'htmlOptions' => array('class' => 'pull-right nav'),
                            ),
                            $notifikasi,
                            $informasi,
                            '<div id="clock" class="realtime pull-right navbar-text-baru"></div>',
                            '<a class="marginplus" href="javascript:void(0);" class="navbar-link"><img class="clock-image marginplus" src="images/clock.png"/></a>',
                            '<div class="rumkit" style="margin-left: 5px; margin-top: 2px;">' . Yii::app()->user->getState('nama_rumahsakit') . '</div>',
                        ),
                    )); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <div class='box-menu'>
                        <table class="navbar-inner" width="100%">
                            <tr>
                                <td width="27%" style="padding:2px 0;">
                                    <?php $this->widget('bootstrap.widgets.BootNavbar', array(
                                        'fixed' => false,
                                        'brand' => false,
                                        //'brand'=>'<img src="images/home.jpg" class="navbar-image marginMin" title="Halaman Utama" rel="tooltip" />',
                                        //'brandUrl'=>Yii::app()->createUrl('/site/index'),
                                        'collapse' => false, // requires bootstrap-responsive.css
                                        'fluid' => false,
                                        'excontainer' => 'cont3',
                                        'items' =>
                                        array(
                                            ((empty($modul->icon_modul)) ?: "<a href='" . $link_home . "' class='navbar-link' rel='tooltip' data-original-title='" . $modul->modul_namalainnya . "'><img class='navbar-image marginplus' src='" . Params::urlIconModulDirectory() . $modul->icon_modul . "''/></a>"),
                                            ('<div class="blocking">' . ((empty($namaInstalasi)) ?: "<a class='navbar-text-baru' style='font-weight: bold;'>" . $namaInstalasi . "</a>" . ((empty($namaRuangan)) ? "" : "<br/><a class='navbar-text-baru' style='font-weight: bold;'>" . $namaRuangan . "</a>")) . "</div>"),
                                        ),
                                    ));
                                    ?>
                                </td>
                                <td style="vertical-align:middle;text-align:right;padding:0px;">
                                    <table class="outer-menulink">
                                        <tr>
                                            <td>
                                                <?php
                                                $this->widget(
                                                    'application.extensions.menu.SMenu',
                                                    array(
                                                        "menu" => MenuModul::getMenuModul($modulMenu),
                                                        "stylesheet" => "menu_default.css",
                                                        "menuID" => "myMenu",
                                                        "delay" => 3
                                                    )
                                                );
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="container" id="page">
        <?php
        if (isset($this->menu)) {
            $this->widget('bootstrap.widgets.BootMenu', array(
                'type' => 'pills', // '', 'tabs', 'pills' (or 'list')
                'stacked' => false, // whether this is a stacked menu
                'items' => $this->menu,
            ));
        } ?>
        <div style="margin-top:85px;"></div>
        <?php echo $content; ?>
        <div class="clear"></div>
        <div id="footer">
            Copyright &copy; <?php echo date('Y'); ?> by eHealthsys.
        </div>
    </div>
    <!--Form Smart Wizard-->
</body>

</html>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'ubah_kertas',
    'options' => array(
        'title' => 'Ubah Ukuran dan Posisi Kertas',
        'autoOpen' => false,
        'width' => 450,
        'height' => 300,
        'modal' => 'true',
        'hide' => 'explode',
        'resizelable' => false,
    ),
));
?>
<div class="control-group">
    <?php echo CHtml::label('Ukuran Kertas', 'print_ukuranKertas', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::dropDownList('ukuranKertas', Yii::app()->user->getState('ukuran_kertas'), CustomFunction::getUkuranKertas(), array('class' => 'span3')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Posisi Kertas', 'print_posisiKertas', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::dropDownList('posisiKertas', Yii::app()->user->getState('posisi_kertas'), CustomFunction::getPosisiKertas(), array('class' => 'span3')); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')),
        array('class' => 'btn btn-primary', 'type' => 'button', 'name' => 'btn_simpan', 'onclick' => 'simpan_kertas()')
    ); ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-ban-circle icon-white"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'button', 'name' => 'btn_batal', 'onclick' => '$(\'#ubah_kertas\').dialog(\'close\')')
    ); ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'pop_pesan',
    'options' => array(
        'title' => 'Notifikasi',
        'autoOpen' => false,
        'width' => 400,
        'height' => 150,
        'modal' => 'true',
        'resizelable' => false,
    ),
));
?>
<div id="content_pesan"></div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'pengumumandialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Informasi',
        'autoOpen' => false,
        'width' => 720,
        'height' => 475,
        'close' => 'js:function(){ clearFrameSrc(); }',
        'modal' => true,
    ),
));
echo '<iframe id="frameinformasi" src="" height="100%" width="100%"></iframe> ';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'notifikasidialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Notifikasi',
        'autoOpen' => false,
        'width' => 720,
        'height' => 475,
        'close' => 'js:function(){ clearFrameSrc(); get_notifikasi(); }',
        'modal' => true,
    ),
));
echo '<iframe id="framenotifikasi" src="" height="100%" width="100%"></iframe> ';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'profiluserdialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Profil User',
        'autoOpen' => false,
        'width' => 840,
        'height' => 475,
        'close' => 'js:function(){ clearFrameSrc(); }',
        'modal' => true,
    ),
));
echo '<iframe id="frameprofiluser" src="" height="100%" width="100%"></iframe> ';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'tulispengumumandialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Tulis Pengumuman',
        'autoOpen' => false,
        'width' => 840,
        'height' => 460,
        'close' => 'js:function(){ clearFrameSrc(); }',
        'modal' => true,
    ),
));
echo '<iframe id="frametulispengumuman" src="" height="100%" width="100%"></iframe> ';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'gantipassworddialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Ubah Kata Kunci',
        'autoOpen' => false,
        'width' => 460,
        'height' => 320,
        'close' => 'js:function(){ clearFrameSrc(); }',
        'modal' => true,
    ),
));
echo '<iframe id="framegantipassword" src="" height="100%" width="100%"></iframe> ';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
//VARIABLE UNTUK JS
$interval = Yii::app()->user->getState('refreshnotifikasi') * 1000;
?>
<script type="text/javascript">
    <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
        var chatServer = '<?php echo Yii::app()->user->getState("nodejs_host") ?>';
        if (chatServer == '') {
            chatServer = 'http://localhost';
        }
        var chatPort = '<?php echo Yii::app()->user->getState("nodejs_port") ?>';
        socket = io.connect(chatServer + ':' + chatPort);
    <?php } ?>

    function insert_notifikasi(params) {
        $.post("index.php?r=site/insertNotifikasi", {
                NofitikasiR: params
            },
            function(data) {
                if (data.pesan === 'ok') {
                    <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
                        socket.emit('send', {
                            conversationID: 'notification',
                            status: 1,
                            modul_id: data.modul_id
                        });
                    <?php } ?>
                    $('#pesan_notifikasi').html(data.template);
                    if (data.count_notif == 0) {
                        $('#count_notif').text("");
                        $('#count_notif').removeClass("mws-dropdown-notif");
                    } else {
                        if (data.count_notif > 10) {
                            count_notif = '10+';
                        } else if (data.count_notif > 0) {
                            count_notif = data.count_notif;
                        }
                        $('#count_notif').text(count_notif);
                        $('#count_notif').addClass("mws-dropdown-notif");
                    }
                }
                return false;
            }, "json"
        );
    }

    function get_notifikasi() {
        count_notif = '';
        $.ajax({
            url: "index.php?r=site/getNotifikasi",
            cache: false,
            dataType: "json",
            success: function(data) {
                $('#pesan_notifikasi').html(data.template);
                if (data.count_notif == 0) {
                    $('#count_notif').text("");
                    $('#count_notif').removeClass("mws-dropdown-notif");
                } else {
                    if (data.count_notif > 10) {
                        count_notif = '10+';
                    } else if (data.count_notif > 0) {
                        count_notif = data.count_notif;
                    }
                    $('#count_notif').text(count_notif);
                    $('#count_notif').addClass("mws-dropdown-notif");
                }
            }
        });
    }

    function find_notifikasi() {
        $.ajax({
            url: "index.php?r=site/getNotifikasi",
            cache: false,
            dataType: "json",
            success: function(data) {
                $('#pesan_notifikasi').html(data.template);
                if (data.count_notif == 0) {
                    $('#count_notif').text("");
                    $('#count_notif').removeClass("mws-dropdown-notif");
                    //$('#combo_content').removeClass("mws-dropdown-box");
                } else {
                    $('#count_notif').text(data.count_notif);
                    $('#count_notif').addClass("mws-dropdown-notif");
                    //$('#combo_content').addClass("mws-dropdown-box");
                }
            }
        });
    }

    function getDetailNotifikasi(params) {
        var notifikasi_id = $(params).attr('value');
        $.ajax({
            url: "index.php?r=site/getDetailNotifikasi",
            cache: false,
            data: {
                notifikasi_id: notifikasi_id
            },
            success: function(data) {
                $("#content_pesan").html(data);
            }
        });
    }

    function dialog_kertas() {
        $('#ubah_kertas').dialog('open');
    }

    function simpan_kertas() {
        ukuranKertas = $('#ukuranKertas').val();
        posisiKertas = $('#posisiKertas').val();
        posisiNama = $('#posisiKertas :selected').html();
        $.post("index.php?r=site/setKertas", {
            ukuranKertas: ukuranKertas,
            posisiKertas: posisiKertas,
            posisiNama: posisiNama
        }, function(data) {
            myAlert(data.pesan);
            $('#ubah_kertas').dialog('close');
            return false;
        }, "json");
    }

    function viewUser() {
        $('#profiluserdialog').dialog('open');
        $('#frameprofiluser').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/PegawaiM/ViewUser', array('frame' => 'frame')); ?>');
    }

    function viewPengumuman(id) {
        $('#pengumumandialog').dialog('open');
        if (!id)
            $('#frameinformasi').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>');
        else
            $('#frameinformasi').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>&id=' + id);
    }

    function viewNotifikasi() {
        $('#notifikasidialog').dialog('open');
        $('#framenotifikasi').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/notifikasiFrame/admin'); ?>');
    }

    function dialogTulisPengumuman() {
        $('#tulispengumumandialog').dialog('open');
        $('#frametulispengumuman').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/tulisPengumumanFrame/create'); ?>');
    }

    function dialogGantiPassword() {
        $('#gantipassworddialog').dialog('open');
        $('#framegantipassword').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/LoginPemakaiFrame/gantiPassword', array('id' => $idUser, 'modul' => $idModul,)) ?>');
    }

    function clearFrameSrc() {
        $('#frameinformasi').attr('src', '');
        $('#framenotifikasi').attr('src', '');
        $('#frameprofiluser').attr('src', '');
        $('#frametulispengumuman').attr('src', '');
        $('#framegantipassword').attr('src', '');
    }

    function hideBanner() {
        $("#banner").slideToggle("slow");
        if ($.cookie('banner') == 'true') {
            $.cookie('banner', 'false');
        } else {
            $.cookie('banner', 'true');
        }
    }

    function errorHandler() {
        myAlert('mozfullscreenerror');
    }
    document.documentElement.addEventListener('mozfullscreenerror', errorHandler, false);
    // toggle full screen
    function toggleFullScreen() {
        $('.trigger-fullscreen').toggle();
        if (!document.fullscreenElement && // alternative standard method
            !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
            }
            $.cookie('fullscreen', 'true');
        } else {
            if (document.cancelFullScreen) {
                document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
                document.webkitCancelFullScreen();
            }
            $.cookie('fullscreen', 'false');
        }
    }

    function set_read_notifikasi(params) {
        var id_pesan_kirim = $(params).attr('value');
        //var id_pesan_kirim = params.value;
        $.ajax({
            url: "index.php?r=site/setReadNotifikasi",
            cache: false,
            dataType: "json",
            data: {
                id_pesan: id_pesan_kirim
            },
            success: function(data) {
                if (data.pesan === "ok") {
                    find_notifikasi();
                }
            }
        });
    }
    $(document).ready(function() {
        if ($.cookie('fullscreen') == 'true') {
            //tidak mendukung fullscreen ketika onload
            //        toggleFullScreen();
        }
        //interval refresh chat
        <?php if ($interval > 0) { ?>
            setInterval('chatHeartbeat();get_notifikasi();', <?php echo $interval ?>);
        <?php } ?>
        get_notifikasi();
        <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
            $('#chatUsers').find('a').each(function(index) {
                var partnerId = $(this).attr('id');
                var userId = '<?php echo Yii::app()->user->name; ?>';
                urutkan = [partnerId, userId];
                urutkan.sort();
                conversationID = urutkan[0] + '' + urutkan[1];
                socket.emit('subscribe', conversationID);
                $(this).attr('conv-id', conversationID);
            });
            socket.emit('subscribe', 'notification');
            modul_id = '<?php echo (isset($modul->modul_id) ? $modul->modul_id : ""); ?>';
            socket.on('notification', function(data) {
                //        console.log(data);
                if (modul_id == data.modul_id) {
                    get_notifikasi();
                }
            });
            var userId = '<?php echo Yii::app()->user->name; ?>';
            socket.on('message', function(data) {
                if (data.type) {
                    if (data.type == 'typing') {
                        if (userId != data.userID) {
                            $("#chatbox_" + data.userID + " .status-user").html(' is typing...');
                        }
                    } else if (data.type == 'blur') {
                        if (userId != data.userID) {
                            $("#chatbox_" + data.userID + " .status-user").html('');
                        }
                    } else {
                        if (userId != data.userID) {
                            insertChat(data.userID, data.partnerID, data.message, 0, data.conversationID);
                        }
                    }
                }
            });
            socket.emit('subscribe', 'antrian');
        <?php } ?>
    });
</script>