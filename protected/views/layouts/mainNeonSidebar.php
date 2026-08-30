<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    /**
     * digunakan untuk pengaturan helpdesk jira
     */
    $konsys = KonfigsystemK::model()->find();
    ?>
    <?php
    $modul = null;
    if (isset(Yii::app()->session['modul_id'])) {
        $modul = ModulK::model()->findByPk(Yii::app()->session['modul_id']);
    }

    if (empty(Yii::app()->user->getState('modul_id')) && !empty($modul)) {
        Yii::app()->user->setState('modul_id', $modul->modul_id);
    }

    ?>
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    if ($modul) {
    ?>
        <link rel="shortcut icon" href="<?php echo Params::urlIconModulDirectory() . $modul->icon_modul; ?>" />
    <?php } else { ?>
        <link rel="shortcut icon" href="" />
    <?php } ?>

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
        media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mws/icons/icons.css"
        media="screen" />
    <link rel="stylesheet" type="text/css"
        href="<?php echo Yii::app()->request->baseUrl; ?>/css/treeview/jquery.treeview.css" media="screen" />
    <link rel="stylesheet"
        href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/neon.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/bootstrap.css">

    <link rel="stylesheet" href="themes/neon18/assets/css/neon-theme.css">
    <link rel="stylesheet"
        href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet"
        href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/rickshaw.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon18/assets/css/custom.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/customnew.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/skins/white.css">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom_neon.css" />
    <link rel="stylesheet" type="text/css"
        href="<?php echo Yii::app()->request->baseUrl; ?>/css/animation-loading.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mainOdontogram.css" />
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/neon-custom.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END); ?>
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
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/alertjs/js/jquery.ui.draggable.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/socket.io.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/dist/notiflix-aio-2.7.0.min.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/alertnotiflix/notiflixalert.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/promjs/build/jquery.dialog.min.js'); ?>
    <link rel="stylesheet" type="text/css"
        href="<?php echo Yii::app()->request->baseUrl; ?>/js/notiflix/promjs/build/jquery.dialog.min.css" />

    <link rel="stylesheet" href="themes/neon18/assets/css/sidebar/custom-sidebar-green.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/sidebar/neon-forms-green.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/sidebar/inovastyle.css">
    <?php
    $modulMenu = ((!empty($this->module->menu)) ? $this->module->menu : null);
    $menus = array();
    $result = array();
    $menu = MenuModul::getMenuModulAdmin($modulMenu);
    $ven = Params::getMenuVendor();
    $acc = Params::cekAkses(Yii::app()->user->getState('nama_pemakai'));
    if (isset($modulMenu)) {
        $z = 1;
        foreach ($menu as $index => $arrMenu) {
    ?>
        <?php
            if ($arrMenu['menus'] < 1) {
                $menus[] = array(
                    'label' => '<i class="' . $arrMenu['icon'] . '"></i><span>' . $arrMenu['label'] . '</span>',
                    'url' => !empty($arrMenu['url']) ? $arrMenu['url'] : '#',
                    'active' => $this->id == 'competitorReport' ? true : false,
                );
            } else {
                foreach ($arrMenu['menus'] as $i => $menu) {
                    $subRoute = strtolower($menu['url']['route']);
                    $pecahSub = explode('/', $subRoute);
                    if (isset($pecahSub[1])) {
                        $r = '/' . $pecahSub[1];
                        $con = $pecahSub[1];
                    } else {
                        $r = '';
                        $con = '';
                    }
                    $modCon = $pecahSub[0] . $r;
                    $subActive1 = strtolower(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id);
                    $subActive2 = strtolower(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id);
                    $result[] = array(
                        'label' => '<span><i class="' . $menu['icon'] . '"></i></span> <span>' . $menu['label'] . '</span>',
                        'url' => Yii::app()->createUrl($menu['url']['route'], $menu['url']['params']),
                        'active' => (($subActive1 == $subRoute) || ($subActive2 == $subRoute)) ? true : false,
                    );
                }
                $menus[] = array(
                    'label' => '<div align="center"><i  class="fa ' . $arrMenu['icon'] . '"></i><br><span style:>' . $arrMenu['label'] . '</div>',
                    'url' => '#',
                    'items' => $result
                );
                $result = array();
            }
        }
        ?>
    <?php } ?>

    <?php $model = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

    <style>
        .navbar-inner.navsty {
            background-position: center center !important;
            display: flex;
            align-items: center;
            min-height: 75px;
        }

        .modal-dialog {
            background: #fff;
        }

        .sidebar-menu {
            background: transparent !important;
        }

        #generateMenu {
            background: rgba(255, 255, 255, .75);
        }

        .main.footsty {
            position: relative;
            overflow: hidden;
        }

        /* --- Perbaikan Sidebar Shortcut Kiri --- */
        .page-container.favmenu {
            position: fixed !important;
            left: 0;
            top: 75px;
            bottom: 0;
            width: 56px !important;
            z-index: 99 !important;
            background: #ffffff !important;
            border-right: 1px solid #e0e6ed !important;
            box-shadow: 1px 0 6px rgba(0, 0, 0, 0.04);
            overflow-y: auto;
            overflow-x: hidden;
        }

        .page-container .sidebar-menu3 {
            width: 56px !important;
            height: 100% !important;
            top: 0 !important;
            background: transparent !important;
            padding: 8px 0 !important;
        }

        .page-container .sidebar-menu3 #main-menu {
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
        }

        .page-container .sidebar-menu3 #main-menu > li {
            width: 56px !important;
            text-align: center;
            margin-bottom: 6px;
        }

        .page-container .sidebar-menu3 #main-menu > li > a {
            display: flex !important;
            align-items: center;
            justify-content: center;
            height: 40px;
            width: 40px;
            margin: 0 auto;
            border-radius: 8px;
            color: #57a595 !important;
            background: #f8fafb;
            border: 1px solid #edf2f7;
            transition: all 0.2s ease;
        }

        .navbar-inner.navsty {
            background-position: center center !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            justify-content: flex-start !important;
            min-height: 60px !important;
            height: 60px !important;
            padding: 0 15px !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .modal-dialog {
            background: #fff;
        }

        .sidebar-menu {
            background: transparent !important;
        }

        #generateMenu {
            background: rgba(255, 255, 255, .75);
        }

        .main.footsty {
            position: relative;
            overflow: hidden;
        }

        /* --- Perbaikan Sidebar Shortcut Kiri (Sleek, Modern, Spacing Proporsional, Tanpa Garis Kaku) --- */
        .page-container.favmenu {
            position: fixed !important;
            left: 0 !important;
            top: 60px !important;
            bottom: 0 !important;
            width: 60px !important;
            z-index: 99 !important;
            background: #ffffff !important;
            border-right: 1px solid #edf2f7 !important;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.03) !important;
            padding: 6px 0 !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            scrollbar-width: none !important; /* Firefox */
            -ms-overflow-style: none !important; /* IE/Edge */
        }

        .page-container.favmenu::-webkit-scrollbar {
            display: none !important; /* Chrome/Safari */
        }

        .page-container .sidebar-menu.sidebar-menu3 {
            width: 60px !important;
            height: auto !important;
            top: 0 !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
            overflow: visible !important;
        }

        .page-container .sidebar-menu3 #main-menu,
        body .page-container .sidebar-menu3 #main-menu {
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 8px !important; /* Spacing antar tombol seragam */
            border: none !important;
        }

        /* Hapus SEMUA garis pembatas/separator horizontal pada LI */
        .page-container .sidebar-menu3 #main-menu > li,
        body .page-container .sidebar-menu3 #main-menu > li,
        .page-container .sidebar-menu3 #main-menu li {
            width: 60px !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            border-top: none !important;
            border-bottom: none !important;
            border-left: none !important;
            border-right: none !important;
            background: transparent !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            box-shadow: none !important;
        }

        .page-container .sidebar-menu3 #main-menu > li:before,
        .page-container .sidebar-menu3 #main-menu > li:after {
            display: none !important;
        }

        body .page-container .sidebar-menu3 #main-menu li a,
        .page-container .sidebar-menu3 #main-menu > li > a {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 40px !important;
            width: 40px !important;
            margin: 0 auto !important;
            padding: 0 !important;
            border-radius: 10px !important;
            color: #4a5568 !important;
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            filter: none !important;
            -webkit-filter: none !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03) !important;
        }

        body .page-container .sidebar-menu3 #main-menu li a:hover,
        .page-container .sidebar-menu3 #main-menu > li > a:hover {
            background: #ecfdf5 !important;
            color: #10b981 !important;
            border-color: #57a595 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 10px rgba(87, 165, 149, 0.25) !important;
            filter: none !important;
            -webkit-filter: none !important;
        }

        body .page-container .sidebar-menu3 #main-menu .active > a,
        .page-container .sidebar-menu3 #main-menu > li.active > a {
            background: #57a595 !important;
            color: #ffffff !important;
            border-color: #57a595 !important;
            transform: none !important;
            box-shadow: 0 3px 8px rgba(87, 165, 149, 0.4) !important;
            filter: none !important;
            -webkit-filter: none !important;
        }

        .page-container .sidebar-menu3 #main-menu > li > a i,
        body .page-container .sidebar-menu3 #main-menu li a i {
            font-size: 17px !important;
            line-height: 1 !important;
            color: inherit !important;
        }

        /* --- Perbaikan Konten Dashboard Agar Luas, Pas & Responsif --- */
        .page-container .main-content {
            margin-left: 60px !important;
            padding: 20px 30px !important;
            min-height: calc(100vh - 150px) !important;
            width: calc(100% - 60px) !important;
            box-sizing: border-box !important;
        }

        /* --- Navbar Bagian Kiri (Info Modul & Ruangan) --- */
        .modul-info-brand {
            display: flex !important;
            align-items: center !important;
            min-width: 220px !important;
            max-width: 320px !important;
            padding: 8px 10px !important;
            text-decoration: none !important;
            flex-shrink: 0 !important;
        }

        .modul-info-brand .modul-icon-wrap {
            border-radius: 8px;
            padding: 4px;
            background-color: #f0f7f5;
            border: 1px solid #e0ede9;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .modul-info-brand .modul-text-wrap {
            line-height: 1.25;
            overflow: hidden;
            text-align: left;
        }

        .modul-info-brand .modul-title {
            font-size: 13px;
            font-weight: 700;
            color: #2c534a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .modul-info-brand .ruangan-title {
            font-size: 10px;
            color: #607d8b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 2px;
        }

        /* --- Navbar Bagian Tengah (Menu Navigasi) --- */
        .navbar-nav.mainmenuatas {
            display: flex !important;
            align-items: center !important;
            margin: 0 0 0 15px !important;
            padding: 0 !important;
            flex: 0 1 auto !important;
        }

        /* --- Navbar Bagian Kanan (Search, Info, Jam, Profil User) -> WAJIB POJOK KANAN --- */
        .page-container.horizontal-menu header.navbar ul.nav.navbar-right,
        .navbar-inner.navsty ul.nav.navbar-right,
        .nav.navbar-right.pull-right {
            display: flex !important;
            align-items: center !important;
            margin-left: auto !important;
            margin-right: 0 !important;
            padding: 0 !important;
            flex-shrink: 0 !important;
            float: none !important;
        }

        .nav.navbar-right.pull-right > li {
            display: inline-flex !important;
            align-items: center !important;
            margin-left: 12px !important;
        }

        .img-kotakprof {
            width: 32px !important;
            height: 32px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            margin-right: 6px !important;
            border: 1px solid #c8e1db !important;
        }

        @media (max-width: 992px) {
            .page-container.favmenu {
                display: none !important;
            }
            .page-container .main-content {
                margin-left: 0 !important;
                padding: 15px !important;
                width: 100% !important;
            }
        }
    </style>
</head>

<body class="page-body page-fade-only">
    <?php
    $isSecure = false;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $isSecure = true;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
        $isSecure = true;
    }
    $REQUEST_PROTOCOL = $isSecure ? 'https://' : 'http://';
    ?>
    <script type="text/javascript">
        var app_timezone = '<?php echo Yii::app()->timeZone; ?>';
        // Socket dinonaktifkan sementara agar tidak memicu polling error
        window.socket = {
            emit: function() {},
            on: function() {}
        };
        $(document).ready(function() {
            <?php if ($this->validasi_pulsa): ?>
                cekValidasiPulsa();
            <?php endif; ?>
        });
    </script>
    <?php
    $idUser = (!empty(Yii::app()->user->id)) ? Yii::app()->user->id : null;
    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    ?>
    <div class="page-container horizontal-menu with-sidebar">
        <header class="navbar navbar-fixed-top">
            <div class="navbar-inner navsty">
                <div class="visible-lg">
                    <?php
                    $idModul = ((!empty($this->module->id)) ? $this->module->id : null);
                    $modul_nama = "Modul";
                    $url_modul = "";
                    $icon_modul = "no_photo.jpeg";
                    $modul_id = "";
                    $image_modul = '';
                    if (!empty(Yii::app()->user->getState('modul_id'))) {
                        $modul_id = Yii::app()->user->getState('modul_id');
                        $usersModul = Yii::app()->user->getState('usersModul');
                        $userRuangan = Yii::app()->user->getState('ruangan_nama');
                        $gen_modul = ModulK::model()->findByPk($modul_id);

                        $modul_nama = (!empty($gen_modul)) ? $gen_modul->modul_nama : $usersModul[$modul_id]['modul_nama'];
                        $url_modul = (!empty($gen_modul)) ? $gen_modul->url_modul : $usersModul[$modul_id]['url_modul'];
                        $icon_modul = (!empty($gen_modul)) ? $gen_modul->icon_modul : $usersModul[$modul_id]['icon_modul'];
                        if (!file_exists(Params::pathIconModulDirectory() . $icon_modul)) {
                            $image_modul = Params::urlIconModulDirectory() . Params::ICON_MODUL;
                        } else {
                            $image_modul = Params::urlIconModulDirectory() . $icon_modul;
                        }
                    }
                    $namaInstalasi = Yii::app()->user->getState('instalasi_nama');
                    $namaRuangan = Yii::app()->user->getState('ruangan_nama');
                    $namaInstalasi = !empty($namaInstalasi) ? $namaInstalasi : "";
                    $namaRuangan = !empty($namaRuangan) ? $namaRuangan : "";
                    $link_home = "";
                    if (isset($_GET['r'])) {
                        $a = explode("/", $_GET['r']);
                        $link_home = Yii::app()->createUrl($a[0]);
                        if ($modul) {
                            $link_home = Yii::app()->createUrl("/" . $modul->url_modul);
                            $link_home .= '&modul_id=' . $modul->modul_id;
                        }
                        if ($a[0] == 'site' && isset(Yii::app()->session['modul_id'])) {
                            unset(Yii::app()->session['modul_id']);
                        }
                    }
                    ?>
                    <a href="<?php echo $link_home ?>" class="modul-info-brand"
                        title="<?php echo !empty($namaInstalasi) ? $namaInstalasi : "" ?> - <?php echo !empty($namaRuangan) ? $namaRuangan : "" ?>">
                        <div class="modul-icon-wrap">
                            <img src="<?php echo $image_modul; ?>" style="height:32px;width:32px;object-fit:contain;" alt="" />
                        </div>
                        <div class="modul-text-wrap">
                            <div class="modul-title"><?php echo !empty($modul_nama) ? $modul_nama : "SIMRS"; ?></div>
                            <div class="ruangan-title"><?php echo !empty($namaRuangan) ? $namaRuangan : $namaInstalasi; ?></div>
                        </div>
                    </a>
                </div>
                <?php
                $this->widget('zii.widgets.CMenu', array(
                    'htmlOptions' => array(
                        'class' => 'navbar-nav mainmenuatas',
                    ),
                    'id' => 'main-menu',
                    'encodeLabel' => false,
                    'activeCssClass' => 'active opened',
                    'activateParents' => true,
                    'items' => $menus,
                ));
                ?>
                <ul class="nav navbar-right pull-right ">
                    <li class="hidden-sm hidden-xs">
                        <a href="#" data-toggle="tooltip" data-placement="left" title="Pencarian"
                            class="dropdown-toggle">
                            <i class="glyphicon glyphicon-search"
                                style="padding-top: 2px; font-size: 1.2em; color: #59A495;" id="tombolmodal"
                                data-toggle="modal" data-target="#myModalutama"></i>
                        </a>
                    </li>
                    <li class="hidden-sm hidden-xs">
                        <a href="#" data-toggle="tooltip" data-placement="left" title="Informasi"
                            class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                            data-close-others="true" onClick="viewInformasi()">
                            <i class="iconheader-informasi"></i>
                        </a>
                    </li>
                    <?php if ($konsys->notifikasi) : ?>
                        <li class="notifications dropdown hidden-sm hidden-xs">
                            <?php
                            $count_notif = "";
                            if (!empty(Yii::app()->controller->module->id)) {
                                $module = ModulK::model()->findByAttributes(array('url_modul' => Yii::app()->controller->module->id));
                                $attributes = array(
                                    'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
                                    'create_ruangan' => Yii::app()->user->getState('ruangan_id'),
                                    'modul_id' => $module->modul_id,
                                    'isread' => false,
                                    'tglnotifikasi' => date('Y-m-d')
                                );
                                Yii::app()->session['modulId'] = isset(Yii::app()->session['modulId']) ? Yii::app()->session['modulId'] : 99999;
                                $records = array();
                                if (Yii::app()->user->getState('instalasi_id') > 0) {
                                    $sql = "
                                    SELECT * FROM notifikasi_r WHERE																			
                                    isread = false	AND
                                    instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND
                                    create_ruangan = " . Yii::app()->user->getState('ruangan_id') . " AND
                                    modul_id = " . (!empty($module->modul_id) ? $module->modul_id : Yii::app()->user->getState('modul_id')) . " AND
                                                                        date(tglnotifikasi) = '" . date('Y-m-d') . "'
                                    order by tglnotifikasi desc
                                    limit 20									
                            ";
                                    $count = YII::app()->db->createCommand($sql)->queryAll();
                                    $records = YII::app()->db->createCommand($sql)->queryAll();
                                }
                                $isi_notif = "";
                            } else {
                                $records = array();
                            }
                            if (count((array)$records) > 0) {
                                foreach ($records as $value) {
                                    if ($value['isread']) {
                                        $isi_notif .= '<li class="notification-primary">
                                                                <a href="javascript:;" value="' . $value['nofitikasi_id'] . '" onclick= "$(\'#pop_pesan\').dialog(\'open\');getDetailNotifikasi(this);">
                                                                    <span class="line">
                                                                        ' . $value['judulnotifikasi'] . '
                                                                    </span>
                                                                    <span class="line small">
                                                                        ' . CustomFunction::time_since(time() - strtotime($value['tglnotifikasi'])) . '
                                                                    </span>
                                                                </a>
                                                            </li>';
                                    } else {
                                        $isi_notif .= '<li class="notification-primary">
                                                                <a href="javascript:;" value="' . $value['nofitikasi_id'] . '" onclick= "$(\'#pop_pesan\').dialog(\'open\');getDetailNotifikasi(this);">
                                                                    <span class="line">
                                                                        <strong>' . $value['judulnotifikasi'] . '</strong>
                                                                    </span>
                                                                    <span class="line small">
                                                                        ' . CustomFunction::time_since(time() - strtotime($value['tglnotifikasi'])) . '
                                                                    </span>
                                                                </a>
                                                            </li>';
                                    }
                                    $count_notif = (count((array)$count) == 0) ? '' : count((array)$count);
                                }
                            }
                            ?>
                            <a id="link_notif" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                data-close-others="true">
                                <i data-toggle="tooltip" data-placement="left"
                                    title="Notifikasi <?php echo (!empty($userRuangan) ? $userRuangan : '') ?>"
                                    class="iconheader-notifikasi"></i> <span class="badge badge-danger"
                                    id="count_notif"><?php echo $count_notif; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="top">
                                    <p class="small">
                                        <a href="#" class="pull-right" onclick="set_read_all();">Tandai Semua</a>
                                        Kamu memiliki <strong><?php echo ($count_notif > 0 ? $count_notif : 0); ?></strong>
                                        notifikasi baru.
                                    </p>
                                </li>
                                <li>
                                    <ul class="dropdown-menu-list scroller" id="pesan_notifikasi">
                                        <?php
                                        echo $isi_notif;
                                        ?>
                                    </ul>
                                </li>
                                <li class="external">
                                    <a href="#" onclick="viewNotifikasi();">Lihat Semua notifikasi</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    <?php if ($konsys->chat) : ?>
                        <li class="hidden-sm hidden-xs">
                            <a href="#" data-toggle="chat" data-animate="1" data-collapse-sidebar="1">
                                <i class="iconheader-chat" data-toggle="tooltip" data-placement="left" title="Chat"></i>
                                <span class="badge badge-success chat-notifications-badge is-hidden">0</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="hidden-sm hidden-xs">
                        <a class="marginplus navbar-link" href="javascript:void(0);" style="cursor: default;">
                            <i class="iconheader-jam" style="filter: grayscale(100%);"></i>
                            <div id="clock" class="headerTimeClock pull-right navbar-text-baru"
                                style="padding-top: 2px;"></div>
                        </a>
                    </li>
                    <li class="dropdown hidden-xs">
                        <a href="#" class="dropdown-toggle profilsty" data-toggle="dropdown">
                            <?php
                            $namaLengkap = "";
                            $image_user = "";
                            if (!empty(Yii::app()->user->getState('pegawai_id'))) {
                                $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                if (!empty($peg) && !empty($peg->photopegawai) && file_exists(Params::pathPegawaiDirectory() . $peg->photopegawai)) {
                                    $image_user = Params::urlPegawaiDirectory() . $peg->photopegawai;
                                } elseif (file_exists(Params::pathPegawaiDirectory() . Params::ICON_PROFIL_PEGAWAI)) {
                                    $image_user = Params::urlPegawaiDirectory() . Params::ICON_PROFIL_PEGAWAI;
                                } else {
                                    $image_user = Yii::app()->request->baseUrl . '/images/avatar-default.png';
                                }
                                $nomorindukpegawai = !empty($peg->nomorindukpegawai) ? $peg->nomorindukpegawai : "-";
                                $noidentitas = !empty($peg->noidentitas) ? $peg->noidentitas : "-";
                                $nama = !empty($peg->namaLengkap) ? $peg->namaLengkap : "-";
                                $namaLengkap = $nama . '<br/>' . $nomorindukpegawai;
                            } else {
                                $image_user = Yii::app()->request->baseUrl . '/images/avatar-default.png';
                            }
                            ?>
                            <img src="<?php echo $image_user; ?>" alt="" class="img-kotakprof" onerror="this.onerror=null;this.src='<?php echo Yii::app()->request->baseUrl; ?>/images/avatar-default.png';" />
                            <?php echo "<b>" . Yii::app()->user->name . "</b>";
                            ?>
                        </a>
                        <ul class="dropdown-menu profilmenussty">
                            <li class="caret"></li>
                            <li style="background-color:#f6f6f6">
                                <div class="row">
                                    <div class="col-xs-4" align="center"
                                        style="padding-right:0;padding-left:0; padding-top:10px">
                                        <div style="position:relative;height:100px">
                                            <img style=" position: absolute; top: 50%; left: 50%;  transform: translate(-50%, -50%);"
                                                src="<?php echo $image_user; ?>" alt="" class="img-kotakprofin"
                                                width="50" onerror="this.onerror=null;this.src='<?php echo Yii::app()->request->baseUrl; ?>/images/avatar-default.png';" />
                                        </div>
                                    </div>
                                    <div class="col-xs-8" style="padding-top:10px;padding-right:0;padding-left:0; ">
                                        <?php
                                        echo "<div class='namelongsty'><b>" . $namaLengkap . "</b></div>";
                                        $namaShif = ShiftM::model()->findByPk(Yii::app()->user->getState('shift_id'));
                                        $waktuLogin = LoginpemakaiK::model()->findByPk($idUser);
                                        echo ' Waktu Login : <br>';
                                        if (!empty($waktuLogin->waktuterakhiraktifitas)) {
                                            echo "<div ><b>" . MyFormatter::formatDateTimeForUser($waktuLogin->waktuterakhiraktifitas) . "</b></div>";
                                        }
                                        echo '<div> ' . $namaShif->shift_nama . "</div>";
                                        ?>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="javascript:dialogGantiPassword()">
                                    <i class="iconheader-gantikunci"></i>
                                    Ganti Password
                                </a>
                            </li>
                            <li>
                                <a href="javascript:dialog_kertas()">
                                    <i class="iconheader-gantikertas"></i>
                                    Ganti Kertas
                                </a>
                            </li>
                            <li>
                                <?php
                                if (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_SISADMIN) {
                                    $modulKey = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
                                    $init = (!empty($modulKey) ? $modulKey->modul_key : '');
                                } else {
                                    $init = '';
                                }
                                echo CHtml::link("<i class='iconheader-lihatprofil'></i> Lihat Profil", Yii::app()->createUrl('/sistemAdministrator/pegawaiProfil/viewUser'))
                                ?>
                            </li>
                            <li
                                visible="<?php echo (!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Admin')); ?>">
                                <a href="javascript:dialogTulisPengumuman()">
                                    <i class="iconheader-tulispengumuman"></i>
                                    Tulis Pengumuman
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo $this->createUrl('/site/logout'); ?>">
                                    <i class="iconheader-logout"></i> Keluar
                                    <?php echo "<b class='logsty'>" . Yii::app()->user->name . "</b>" ?>
                                </a>
                            </li>
                            <li><br></li>
                        </ul>
                    </li>
                    <li class="visible-xs">
                        <div class="horizontal-mobile-menu visible-xs">
                            <a href="#" class="with-animation">
                                <i class="entypo-menu"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="page-container favmenu">
                <div class="sidebar-menu sidebar-menu3">
                    <?php
                    if (!empty(Yii::app()->user->getState('modul_id'))) {
                        $criteria = new CDbCriteria();
                        $criteria->join = "  LEFT JOIN kelompokmenu_k kelompokmenu ON kelompokmenu.kelmenu_id = t.kelmenu_id ";
                        $criteria->addCondition(" modul_id = '" . Yii::app()->user->getState('modul_id') . "' ");
                        $criteria->addCondition('t.menu_aktif = true  AND menu_shortcut = TRUE ');
                        $criteria->order = 'menu_urutan';
                        $criteria->limit = 10;
                        $fav = MenumodulK::model()->findAll($criteria);
                        $favorit = array();
                        $subAc = strtolower(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id);
                        foreach ($fav as $f) {
                            $favorit[] = array(
                                'label' => '<div align="center" data-toggle="tooltip" data-placement="right" title="' . $f->menu_nama . '"><i class="' . $f->menu_icon . '"></i></div>',
                                'url' => !empty($f->menu_url) ? Yii::app()->createUrl('/' . $f->menu_url) : '#',
                                'active' => $subAc == strtolower($f->menu_url) ? true : false,
                            );
                        }
                    } else {
                        $favorit = array();
                    }
                    $this->widget('zii.widgets.CMenu', array(
                        'htmlOptions' => array(
                            'class' => 'main-menu menustyle',
                        ),
                        'id' => 'main-menu',
                        'encodeLabel' => false,
                        'activeCssClass' => 'active opened',
                        'activateParents' => true,
                        'items' => $favorit,
                    ));
                    ?>
                </div>
            </div>
        </header>
        <div class=" modal1 left fade" id="myModalutama" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document"
                style=" position: fixed !important; margin: auto !important; width: 320px !important; height: 100% !important; padding:0 !important; top:0; left:0; ">
                <div class="modal-content" style=" overflow-y:auto!important; height: 100% !important; ">
                    <div class="sidebar-menu">
                        <button
                            style="top: 0px;position:fixed;color:white!important;opacity:1;font-weight:normal; font-size:40px; left: 340px; right: auto; cursor: pointer;"
                            type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"> &times;</span></button>
                        <div class="menuhide">
                            <ul id="main-menu" class="" style="margin:0 !important;">
                                <li id="search" class="root-level">
                                    <div id="cari_menu_dynamic">
                                        <input style="height:45px" id="cari_menu" name="q" class="search-input"
                                            placeholder="Silakan ketik nama menu..." type="text"
                                            onkeypress=" runScript(event)" onchange="carimenu();">
                                        <button type="button">
                                            <i class="entypo-search"></i>
                                        </button>
                                    </div>
                                </li>
                            </ul>
                            <?php
                            $modulMenu = ((!empty($this->module->menu)) ? $this->module->menu : null);
                            $menus = array();
                            $result = array();
                            $menu = MenuModul::getMenuModulAdmin($modulMenu);
                            $ven = Params::getMenuVendor();
                            $acc = Params::cekAkses(Yii::app()->user->getState('nama_pemakai'));
                            if (isset($modulMenu)) {
                                foreach ($menu as $index => $arrMenu) {
                            ?>
                                <?php
                                    if ($arrMenu['menus'] < 1) {
                                        $menus[] = array(
                                            'label' => '<i class="' . $arrMenu['icon'] . '"></i><span>' . $arrMenu['label'] . '</span>',
                                            'url' => !empty($arrMenu['url']) ? $arrMenu['url'] : '#',
                                            'active' => $this->id == 'competitorReport' ? true : false,
                                        );
                                    } else {
                                        foreach ($arrMenu['menus'] as $i => $menu) {
                                            $subRoute = strtolower($menu['url']['route']);
                                            $pecahSub = explode('/', $subRoute);
                                            if (isset($pecahSub[1])) {
                                                $r = '/' . $pecahSub[1];
                                                $con = $pecahSub[1];
                                            } else {
                                                $r = '';
                                                $con = '';
                                            }
                                            $modCon = $pecahSub[0] . $r;
                                            $subActive1 = strtolower(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id);
                                            $subActive2 = strtolower(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id);
                                            $result[] = array(
                                                'label' => '<i class="' . $menu['icon'] . '"></i><span>' . $menu['label'] . '</span>',
                                                'url' => Yii::app()->createUrl($menu['url']['route'], $menu['url']['params']),
                                                'active' => (($subActive1 == $subRoute) || ($subActive2 == $subRoute)) ? true : false,
                                            );
                                        }
                                        $menus[] = array(
                                            'label' => '<i class="fa ' . $arrMenu['icon'] . '"></i><span>' . $arrMenu['label'] . '</span>',
                                            'url' => '#',
                                            'items' => $result
                                        );
                                        $result = array();
                                    }
                                }
                                ?>
                            <?php } ?>
                            <div id="generateMenu">
                                <?php
                                $this->widget('zii.widgets.CMenu', array(
                                    'htmlOptions' => array(
                                        'class' => 'main-menu'
                                    ),
                                    'id' => 'main-menu',
                                    'encodeLabel' => false,
                                    'activeCssClass' => 'active opened',
                                    'activateParents' => true,
                                    'items' => $menus,
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section id="popup1">
            <div class="row">
                <div class="col-md-12" style=" height:71px; padding-left:0;padding-right:0;">
                    <div align="center" class="col-md-4" style="padding-top:5px">
                        <div
                            style="position: relative;width:170px;height:170px;   border-radius:50%;background-color:white;">
                            <img src="<?php echo $image_modul; ?>" height="" alt="" style="position: absolute;
                                          top: 50%;
                                          left: 50%;  max-height:90px;transform: translate(-50%, -50%);height:90px;" />
                        </div>
                        <div>
                            <h3 style="color:white"><?php echo !empty($modul_nama) ? $modul_nama : "" ?></h3>
                        </div>
                    </div>
                    <div align="center" class="col-md-4" style="padding-top:5px">
                        <div
                            style="position: relative;width:170px;height:170px;  border-radius:50%;background-color:white;">
                            <img src="<?php echo Params::urlProfilRSDirectory() . $profil->logo_rumahsakit; ?>"
                                height="" alt=""
                                style="position: absolute; top: 50%; left: 50%;  max-height:90px;transform: translate(-50%, -50%); height:90px" />
                        </div>
                        <div>
                            <h3 style="color:white">
                                <?php echo !empty($profil->nama_rumahsakit) ? $profil->nama_rumahsakit : "" ?></h3>
                        </div>
                    </div>
                    <div align="center" class="col-md-4" style="padding-top:5px">
                        <div
                            style="position: relative;width:170px;height:170px;  border-radius:50%;background-color:white;">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/innovahospital.png"
                                min-height="45" alt=""
                                style=" position: absolute; top: 50%; left: 50%;  max-height:90px;transform: translate(-50%, -50%);" />
                        </div>
                        <div>
                            <h3 style="color:white">Ehealthsys</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="main-content">
            <div class="row">
                <div class="col-md-6 col-sm-8 clearfix">
                    <ul class="user-info pull-left pull-left-xs pull-none-xsm">
                    </ul>
                    <ul class="user-info pull-right pull-none-xsm">
                    </ul>
                </div>
                <div class="col-md-6 col-sm-4 clearfix hidden-xs" style="bottom:20px;">
                </div>
            </div>
            <?php
            $this->widget('ext.bootstrap.widgets.BootBreadcrumbs', array(
                'homeLink' => array(
                    'label' => 'Dashboard',
                    'url' => Yii::app()->createUrl(Yii::app()->controller->module->id)
                ),
                'links' => $this->breadcrumbs,
                'htmlOptions' => array(
                    'class' => 'breadcrumb bc-2',
                    'style' => 'margin-top: 25px;',
                ),
            ));
            ?>
            <?php echo $content; ?>
            <style>
                .logo-inova-footer {
                    display: inline-block;
                    width: 50px;
                    height: 50px;
                    margin: 0 auto 5px;
                    /* background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/ims-login.png') center center no-repeat #fff; */
                    background-size: contain;
                    border-radius: 5px;
                }
            </style>
            <footer class="main footsty"
                style="padding-bottom:10px;color:#fff;border-bottom-right-radius:10px;border-bottom-left-radius:10px;">
                <center style="color:white">
                    <div class="row">
                        <div class="col-md-12" align="center">
                            <div style="width:50px;height:50px;margin:0 auto 10px auto;position:relative;border-radius:5px;background-color:white;display:flex;align-items:center;justify-content:center;">
                                <img src="<?php echo Params::urlProfilRSDirectory() . $profil->logo_rumahsakit; ?>" alt="Logo"
                                    style="max-height:40px;max-width:40px;" />
                            </div>
                            <span style="color:white;font-weight:bold;"><?php echo $profil->nama_rumahsakit; ?></span> &copy; <?php echo date('Y') ?><br>
                            <span style="color:white;">All Rights Reserved</span>
                        </div>
                    </div>
                </center>
            </footer>
        </div>
        <div id="chat" class="fixed" data-current-user="<?php echo Yii::app()->user->name; ?>" data-order-by-status="1"
            data-max-chat-history="25">
            <?php
            $this->beginWidget('ListUserChatNeon', array(
                'htmlOptions' => array('class' => ''),
            ));
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php if ($konsys->suaranotifikasi) { ?>
        <audio id="suara_notif" src="data/sounds/notif/slow-spring-board.mp3" type="audio/mp3">
        </audio>
    <?php } ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'pop_pesan',
        'options' => array(
            'title' => 'Notifikasi',
            'autoOpen' => false,
            'width' => 400,
            'modal' => 'true',
            'resizelable' => false,
        ),
    ));
    ?>
    <div id="content_pesan"></div>
    <?php $this->endWidget(); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'notifikasidialog',
        'options' => array(
            'title' => 'Notifikasi',
            'autoOpen' => false,
            'width' => 720,
            'height' => 475,
            'close' => 'js:function(){ clearFrameSrc(); }',
            'modal' => true,
        ),
    ));
    echo '<iframe id="framenotifikasi" src="" height="100%" width="100%" style="border:none;"></iframe> ';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'informasidialog',
        'options' => array(
            'title' => 'Informasi',
            'autoOpen' => false,
            'width' => 720,
            'height' => 475,
            'close' => 'js:function(){ clearFrameSrc(); }',
            'modal' => true,
        ),
    ));
    echo '<iframe id="frameinformasi" src="" height="100%" width="100%" style="border:none;"></iframe> ';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'gantipassworddialog',
        'options' => array(
            'title' => 'Ganti Password',
            'autoOpen' => false,
            'width' => 710,
            'height' => 380,
            'close' => 'js:function(){ clearFrameSrc(); }',
            'modal' => true,
        ),
    ));
    echo '<iframe id="framegantipassword" src="" height="100%" width="100%" style="border:none;"></iframe> ';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
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
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'name' => 'btn_simpan', 'onclick' => 'simpan_kertas()'));
        ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-ban-circle icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'name' => 'btn_batal', 'onclick' => '$(\'#ubah_kertas\').dialog(\'close\')'));
        ?>
    </div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'profiluserdialog',
        'options' => array(
            'title' => 'Edit Profile User',
            'autoOpen' => false,
            'width' => 850,
            'height' => 600,
            'close' => 'js:function(){ clearFrameSrc(); }',
            'modal' => true,
        ),
    ));
    echo '<iframe id="frameprofiluser" src="" height="100%" width="100%" style="border:none;"></iframe> ';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'tulispengumumandialog',
        'options' => array(
            'title' => 'Tulis Pengumuman',
            'autoOpen' => false,
            'width' => 840,
            'height' => 450,
            'close' => 'js:function(){ clearFrameSrc(); }',
            'modal' => true,
        ),
    ));
    echo '<iframe id="frametulispengumuman" src="" height="100%" width="100%" style="border:none;"></iframe> ';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
    <?php
    if (!empty($konsys->refreshnotifikasi)) {
        $interval = $konsys->refreshnotifikasi * 1000;
    } else {
        $interval = 0;
    }
    ?>

    <script type="text/javascript">
        $("input").parents('label.control-label').css("cursor", "pointer");

        $(function() {
            $('body').on('keydown', 'input,textarea', function(e) {
                if (e.which === 32 && e.target.selectionStart === 0) {
                    return false;
                }
            });
        });

        function insert_notifikasi(params) {
            $.post("index.php?r=site/insertNotifikasi", {
                    NofitikasiR: params
                },
                function(data) {
                    if (data.status === 'ok') {
                        <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
                            socket.emit('send', {
                                conversationID: 'notification',
                                status: 1,
                                modul_id: data.modul_id
                            });
                        <?php } ?>
                        $('#pesan_notifikasi').html(data.template);
                        $('#count_notif').text(data.count_notif);
                    }
                    return false;
                }, "json"
            );
        }
        var tot_notif = null;
        var last_notif_id = 0;
        var added_notif = [];
        var init_notif = false;

        function get_notifikasi() {
            $.ajax({
                url: "index.php?r=site/getNotifikasi",
                cache: false,
                dataType: "json",
                success: function(data) {
                    if (data.count_notif > 0 && data.count_notif_raw > tot_notif) {
                        if (init_notif) {
                            play_notif();
                        }
                        $.each(data.notif_list, function(idx, val) {
                            if (!added_notif[idx]) {
                                if (init_notif) {
                                    var not_det = toastr.info(val);
                                    $(not_det).click(function() {
                                        getDetailNotifikasiVal(idx);
                                        $('#pop_pesan').dialog('open');
                                    });
                                }
                                added_notif[idx] = true;
                            }
                        });
                    }
                    tot_notif = data.count_notif_raw;
                    $('#pesan_notifikasi').html(data.template);
                    if (data.count_notif == 0) {
                        $('#count_notif').html("");
                        $('#count_notif').removeClass("mws-dropdown-notif");
                    } else {
                        $('#count_notif').html(data.count_notif);
                        $('#count_notif').addClass("mws-dropdown-notif");
                    }
                    init_notif = true;
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
                    $('#count_notif').html(data.count_notif);
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
                    set_read_notifikasi(params);
                }
            });
        }

        function getDetailNotifikasiVal(notifikasi_id) {
            $.ajax({
                url: "index.php?r=site/getDetailNotifikasi",
                cache: false,
                data: {
                    notifikasi_id: notifikasi_id
                },
                success: function(data) {
                    $("#content_pesan").html(data);
                    set_read_notifikasi_id(notifikasi_id);
                }
            });
        }

        function set_read_notifikasi_id(notifikasi_id) {
            var id_pesan_kirim = notifikasi_id;
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

        function set_read_notifikasi(params) {
            var id_pesan_kirim = $(params).attr('value');
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

        function set_read_all() {
            $.ajax({
                url: "index.php?r=site/setReadAllNotifikasi",
                cache: false,
                dataType: "json",
                success: function(data) {
                    if (data.pesan === "ok") {
                        find_notifikasi();
                    }
                }
            });
        }

        function clearFrameSrc() {
            $('#frameinformasi').attr('src', '');
            $('#framenotifikasi').attr('src', '');
            $('#frameprofiluser').attr('src', '');
            $('#frametulispengumuman').attr('src', '');
            $('#framegantipassword').attr('src', '');
        }

        function viewNotifikasi() {
            $('#notifikasidialog').dialog('open');
            $('#framenotifikasi').attr('src',
                '<?php echo Yii::app()->createUrl('sistemAdministrator/notifikasiFrame/admin'); ?>');
        }

        function viewPengumuman(id) {
            $('#pengumumandialog').dialog('open');
            if (!id)
                $('#frameinformasi').attr('src',
                    '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>');
            else
                $('#frameinformasi').attr('src',
                    '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>&id=' + id);
        }

        function dialogGantiPassword() {
            $('#gantipassworddialog').dialog('open');
            $('#framegantipassword').attr('src',
                '<?php echo Yii::app()->createUrl('sistemAdministrator/LoginPemakaiFrame/gantiPassword', array('id' => $idUser, 'modul' => $idModul,)) ?>'
            );
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
                },
                function(data) {
                    alert(data.pesan);
                    $('#ubah_kertas').dialog('close');
                    return false;
                }, "json");
        }

        function viewUser() {
            $('#profiluserdialog').dialog('open');
            $('#frameprofiluser').attr('src',
                '<?php echo Yii::app()->createUrl('sistemAdministrator/LoginpemakaiK/view'); ?>');
        }

        function dialogTulisPengumuman() {
            $('#tulispengumumandialog').dialog('open');
            $('#frametulispengumuman').attr('src',
                '<?php echo Yii::app()->createUrl('sistemAdministrator/tulisPengumumanFrame/create'); ?>');
        }

        function viewInformasi(id) {
            $('#informasidialog').dialog('open');
            if (!id)
                $('#frameinformasi').attr('src',
                    '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>');
            else
                $('#frameinformasi').attr('src',
                    '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>&id=' + id);
        }

        function cekValidasiPulsa() {
            console.log("MULAI CEK PULSA");
            $.post('<?php echo $this->createUrl('/actionAjax/cekPulsaKasir'); ?>', {}, function(data) {
                if (data.is_ada == 0) {
                    myAlert("Belum dilakukan penambahan saldo awal untuk tanggal <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d')) ?>" +
                        " pada ruangan <?php echo Yii::app()->user->getState('ruangan_nama'); ?>. Silahkan isi saldo awal terlebih dahulu",
                        "Konfirmasi Pengisian Saldo Awal");
                    window.location.replace(
                        '<?php echo $this->createUrl('/billingKasir/pengisiansaldoawalT/create') ?>');
                }
            }, 'json');
        }

        function startChat() {
            $.ajax({
                url: "index.php?r=chat&action=startchat",
                cache: false,
                dataType: "json",
                success: function(data) {
                    if (data.result != 0) {
                        var neon = neonChat;
                        hasil = data.result;
                        hasil.forEach(function(data) {
                            if (typeof data.msg !== 'undefined') {
                                msg = data.msg;
                                neon.pushMessage(data.from, msg.replace(/<.*?>/g, ''), data.from,
                                    new Date(), true, true);
                            }
                        });
                    }
                }
            });
        }

        function updateChat() {
            $.ajax({
                url: "index.php?r=chat&action=refreshchat",
                cache: false,
                dataType: "json",
                success: function(data) {
                    if (data.result != 0) {
                        var neon = neonChat;
                        hasil = data.result;
                        hasil.forEach(function(data) {
                            msg = data.msg;
                            neon.pushMessage(data.from, msg.replace(/<.*?>/g, ''), data.from,
                                new Date(), true, true);
                        });
                    }
                }
            });
        }

        function readChat(obj) {
            jml = $(obj).find('span.badge-info').html();
            jml = (jml == '') ? 0 : jml;
            id = $(obj).attr('id');
            if (jml > 0) {
                $.post("index.php?r=chat&action=readchat", {
                    id: id
                }, function(data) {
                    console.log('read');
                });
            }
        }

        function play_notif() {
            <?php if ($konsys->suaranotifikasi) { ?>
                var notif = suara_notif.cloneNode(true);
                notif.play();
            <?php } else { ?>
                return false;
            <?php } ?>
        }

        async function startChat2() {
            startChat();
        }

        $(document).ready(function() {
            <?php if (isset($_GET["status"])) { ?>
            <?php } ?>
            $('.search-form span.required').hide();

            <?php if ($konsys->chat) { ?>

                <?php if ($interval > 0) { ?>
                <?php } ?>
                $("[id^=group-]").find('a').each(function(index) {
                    var partnerId = $(this).attr('id');
                    var userId = '<?php echo Yii::app()->user->name; ?>';
                    urutkan = [partnerId, userId]
                    urutkan.sort();
                    conversationID = urutkan[0] + '' + urutkan[1];
                    socket.emit('subscribe', conversationID);
                    $(this).attr('conv-id', conversationID);
                });
                var neon = neonChat;
                var userId = '<?php echo Yii::app()->user->name; ?>';

                console.log('loading')
                startChat();
                startChat2()
                socket.on('message', function(data) {
                    updateChat();
                    console.log('message---', data)
                    if (data.type) {
                        if (data.type == 'typing') {
                            if (userId != data.userID) {
                                $('#chat .conversation-header small').html('Typing...');
                            }
                        } else if (data.type == 'blur') {
                            if (userId != data.userID) {
                                $('#chat .conversation-header small').html('Online...');
                            }
                        } else {
                            if (userId != data.userID) {
                                neon.pushMessage(data.userID, data.message, data.userID, new Date(), true,
                                    true);
                                neon.renderMessages(data.userID);
                                console.log(data.userID, data.message)
                            }
                            $('#chat .conversation-header small').html('Online......');
                        }
                    }
                });

                socket.on('notification', function(data) {
                    console.log('send---', data);
                    get_notifikasi();
                });
            <?php } else if ($konsys->notifikasi) { ?>
                socket.on('notification', function(data) {
                    get_notifikasi();
                });

            <?php } ?>
        });
    </script>
    <script>
        function toggleFullScreen() {
            $('.trigger-fullscreen').toggle();
            if (!document.fullscreenElement &&
                !document.mozFullScreenElement && !document.webkitFullscreenElement) {
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
    </script>
    <link rel="stylesheet" href="themes/neon/assets/js/daterangepicker/daterangepicker-bs3.css">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/gsap/main-gsap.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/joinable.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/resizeable.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-api.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/vendor/d3.v3.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/rickshaw.min.js"></script>
    <script
        src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js">
    </script>
    <script
        src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js">
    </script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/raphael-min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/morris.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery.peity.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery.sparkline.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/toastr.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-chat.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/neon-demo.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/custom.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/daterangepicker/moment.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/daterangepicker/daterangepicker.js">
    </script>
    <?php if ($konsys->issuecollector) : ?>
        <script type="text/javascript"
            src="https://piiproject.atlassian.net/s/ea6d8abeea8f9d4e9988279ef398643d-T/en_US-s4xgn2/65000/31/1.4.25/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?locale=en-US&collectorId=fcff53dd">
        </script>
        <script type="text/javascript">
            window.ATL_JQ_PAGE_PROPS = {
                "triggerFunction": function(showCollectorDialog) {
                    $("#myCustomTrigger").click(function(e) {
                        e.preventDefault();
                        showCollectorDialog();
                    });
                }
            };
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        $(".modal-backdrop").click(function(e) {
            $('#myModalutama').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
        $(function() {
            $('iframe').on('load', function() {
                var targetClass = ".ui-dialog";
                var is_dialogOpen = 0;
                $(targetClass).each(function() {
                    var displayValue = $(this).css("display");

                    if (displayValue === "block") {
                        console.log("load frame");
                        is_dialogOpen++;
                    }
                });

                const windowWidth = $(this).innerWidth();
                const windowHeight = $(this).innerHeight();

                const centerX = windowWidth / 2;
                const centerY = windowHeight / 2 + 320;

                if (is_dialogOpen < 1) {
                    window.scrollTo(centerX, centerY);
                }

            });
            $('#sdt_menu > li').bind('mouseenter', function() {
                var $elem = $(this);
                $elem.find('a img')
                    .stop(true)
                    .animate({
                        'width': '45px',
                        'height': '45px',
                        'left': '0px'
                    }, 400, 'easeOutBack')
                    .andSelf()
                    .find('.sdt_wrap')
                    .stop(true)
                    .animate({
                        'top': '140px'
                    }, 500, 'easeOutBack')
                    .andSelf()
                    .find('.sdt_active')
                    .stop(true)
                    .animate({
                        'height': '45px'
                    }, 300, function() {
                        var $sub_menu = $elem.find('.sdt_box');
                        if ($sub_menu.length) {
                            var left = '45px';
                            if ($elem.parent().children().length == $elem.index() + 1)
                                left = '-45px';
                            $sub_menu.show().animate({
                                'left': left
                            }, 200);
                        }
                    });
            }).bind('mouseleave', function() {
                var $elem = $(this);
                var $sub_menu = $elem.find('.sdt_box');
                if ($sub_menu.length)
                    $sub_menu.hide().css('left', '0px');
                $elem.find('.sdt_active')
                    .stop(true)
                    .animate({
                        'height': '0px'
                    }, 300)
                    .andSelf().find('a img')
                    .stop(true)
                    .animate({
                        'width': '0px',
                        'height': '0px',
                        'left': '85px'
                    }, 400)
                    .andSelf()
                    .find('.sdt_wrap')
                    .stop(true)
                    .animate({
                        'top': '25px'
                    }, 500);
            });
        });
        $('#popup1').popup();

        function carimenu() {
            var term = $("#cari_menu").val();
            $('#generateMenu').addClass("animation-loading");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('/ActionAjax/cariMenu/'); ?>',
                data: {
                    term: term
                },
                dataType: "json",
                success: function(data) {
                    $('#generateMenu').html(data.html);
                    $('#generateMenu').removeClass("animation-loading");
                    setup_sidebar_menu();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
        $('#cari_menu').on('keydown', function(e) {
            if (e.which == 13) {
                carimenu();
            }
        });
        var matched, browser;
        jQuery.uaMatch = function(ua) {
            ua = ua.toLowerCase();
            var match = /(chrome)[ \/]([\w.]+)/.exec(ua) ||
                /(webkit)[ \/]([\w.]+)/.exec(ua) ||
                /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(ua) ||
                /(msie) ([\w.]+)/.exec(ua) ||
                ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(ua) || [];
            return {
                browser: match[1] || "",
                version: match[2] || "0"
            };
        };
        matched = jQuery.uaMatch(navigator.userAgent);
        browser = {};
        if (matched.browser) {
            browser[matched.browser] = true;
            browser.version = matched.version;
        }
        if (browser.chrome) {
            browser.webkit = true;
        } else if (browser.webkit) {
            browser.safari = true;
        }
        jQuery.browser = browser;
    </script>

</body>

</html>