<!DOCTYPE html>
<html lang="en">

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
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="" />
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/image/icon/faveicon.png" rel="shortcut icon" type="image/x-icon" />
    <!-- blueprint CSS framework -->
    <!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; 
                                                        ?>/css/screen.css" media="screen, projection" />-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--<link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl; 
                                                        ?>/css/mws/mws.style.css" media="screen" />-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mws/icons/icons.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/treeview/jquery.treeview.css" media="screen" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/fonts.css">
    <link rel="stylesheet" href="themes/neon/assets/css/neon.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/bootstrap.css">
    <!--<link rel="stylesheet" href="themes/neon18/assets/css/neon-core.css">-->
    <link rel="stylesheet" href="themes/neon18/assets/css/neon-theme.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/neon-forms.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/rickshaw/rickshaw.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon18/assets/css/custom.css">
    <link rel="stylesheet" href="themes/neon18/assets/css/skins/white.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/alertjs/css/jQuery.alert.css" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/js/bootstrap.min.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="<?php // echo Yii::app()->request->baseUrl; 
                                                        ?>/css/my-style.css" />-->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom_neon.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/animation-loading.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mainOdontogram.css" />
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/neon-custom.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/bootstrap-switch.min.js', CClientScript::POS_END); ?>
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
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--	[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
    <!--RSPMC-1082 -alert untuk biling kasir ditebalkan -->
    <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_KEUANGAN) { ?>
        <style type="text/css">
            .alert-success {
                font-size: 13px;
                font-weight: bold;
            }
        </style>
    <?php } ?>
</head>

<body class="page-body">
    <?php
    $isSecure = false;
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $isSecure = true;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
        $isSecure = true;
    }
    $REQUEST_PROTOCOL = $isSecure ? 'https://' : 'http://';
    $konsys = KonfigsystemK::model()->find();
    ?>
    <script>
        $(document).ready(function() {
            <?php
            if (!empty($konsys->nodejs_host)) {
            ?>
                var chatServer = '<?php echo     $konsys->nodejs_host; ?>';
                var chatPort = '<?php echo     $konsys->nodejs_port; ?>';
            <?php
            } else {
            ?>
                var chatServer = 'localhost';
                var chatPort = '3000';
            <?php
            }
            ?>
            socket = io.connect('<?php echo $REQUEST_PROTOCOL; ?>' + chatServer + ':' + chatPort, {
                secure: true
            });
        });
    </script>
    <div class="page-container sidebar-collapsed">
        <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
        <div class="sidebar-menu">
            <header class="logo-env">
                <!-- logo -->
                <div class="logo">
                    <?php
                    $idModul = ((!empty($this->module->id)) ? $this->module->id : null);
                    $idUser = ((!empty(Yii::app()->user->id)) ? Yii::app()->user->id : null);
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
                    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
                    if (file_exists(Params::pathProfilRSDirectory() . rtrim($profil->logo_rumahsakit))) {
                        $image = Params::urlProfilRSDirectory() . $profil->logo_rumahsakit;
                    } else {
                        $image = Params::urlProfilRSDirectory() . Params::ICON_PROFIL;
                    }
                    ?>
                    <a href="<?php echo Yii::app()->createUrl($url_modul, array('modulId' => $modul_id)); ?>" class="logo" style="float:left;">
                        <img src="<?php echo $image_modul; ?>" width="90" alt="" style=";float:left;" />
                        <!-- <p class="desclogo" style = "margin-top:10px;">								
                                <b style="padding-left:20px;"><?php //echo $profil->nama_rumahsakit; 
                                                                ?></b>
			</p>-->
                    </a>
                </div>
                <!-- logo collapse icon -->
                <div class="sidebar-collapse">
                    <a href="#" class="sidebar-collapse-icon">
                        <!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>
                <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                <div class="sidebar-mobile-menu visible-xs">
                    <a href="#" class="with-animation">
                        <!-- add class "with-animation" to support animation -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>
            </header>
            <div class="sidebar-user-info">
                <div class="sui-normal">
                    <a href="<?php echo Yii::app()->createUrl($url_modul, array('modulId' => $modul_id)); ?>" class="user-link">
                        <?php
                        if (!empty(Yii::app()->user->getState('pegawai_id'))) {
                            $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                            if (!empty($peg)) {
                                $namaLengkap = $peg->namaLengkap;
                                if (!empty($peg->photopegawai)) {
                                    $image_user = Params::urlUserProfile() . $peg->photopegawai;
                                } else {
                                    $image_user = Params::urlUserProfile() . Params::ICON_PROFIL_PEGAWAI;
                                }
                            } else {
                                $namaLengkap = Yii::app()->user->getState('nama_pemakai');
                                $image_user = Params::urlUserProfile() . Params::ICON_PROFIL_PEGAWAI;
                            }
                        } else {
                            $namaLengkap = Yii::app()->user->getState('nama_pemakai');
                            $image_user = Params::urlUserProfile() . Params::ICON_PROFIL_PEGAWAI;
                        }
                        ?>
                        <img src="<?php echo $image_user; ?>" width="55x" alt="" class="img-circle" />
                        <span>Selamat Datang,</span>
                        <strong><?php echo $namaLengkap; ?></strong>
                    </a>
                </div>
                <div style="font-size:10px;" class="sui-hover inline-links animate-in" style="padding: none;">
                    <!-- You can remove "inline-links" class to make links appear vertically, class "animate-in" will make A elements animateable when click on user profile -->
                    <?php $url_logout = $this->createUrl('/site/logout'); ?>
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <a href="javascript:dialogGantiPassword()" id="loadPassword" style="line-height: 22px;">
                                    <i class="entypo-key"></i>
                                    Ganti Password
                                </a>
                            </td>
                            <td width="50%">
                                <a href="javascript:dialog_kertas()" style="line-height: 22px;">
                                    <i class="entypo-print"></i>
                                    Ganti Kertas
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                $init = 'PTRS';
                                echo CHtml::link("<i class='entypo-user'></i> Lihat Profil", array('/sistemAdministrator/pegawaiProfil/viewUser'), array(
                                    'style' => "line-height: 22px;"
                                ))
                                ?>
                            </td>
                            <td>
                                <a href="javascript:dialogTulisPengumuman()" style="line-height: 22px;">
                                    <i class="entypo-info"></i>
                                    Tulis Pengumuman
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#" onclick="toggleFullScreen ();" style="line-height: 22px;">
                                    <!--Sementara Progress Menggunakan Lock Screen-->
                                    <i class="glyphicon glyphicon-resize-full"></i>
                                    Fullscreen
                                </a>
                            </td>
                            <td>
                                <a href="#" style="line-height: 22px;" onclick="myConfirm('Yakin akan keluar dari modul <?php echo $modul->modul_nama; ?>?', 'Peringatan', function(r) {
                                if (r) {
                                    window.location.href = '<?php echo $url_logout; ?>';
                                }
                            })">
                                    <!--Sementara Progress Menggunakan Lock Screen-->
                                    <i class="entypo-lock"></i>
                                    Log Out
                                </a>
                            </td>
                        </tr>
                    </table>
                    <span class="close-sui-popup">&times;</span><!-- this is mandatory -->
                </div>
            </div>
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
                            //if (!isset($ven[$con])){
                            $result[]  = array(
                                'label' => '<i class="' . $menu['icon'] . '"></i><span>' . $menu['label'] . '</span>',
                                'url' => Yii::app()->createUrl($menu['url']['route'], $menu['url']['params']),
                                'active' => (($subActive1 == $subRoute) || ($subActive2 == $subRoute)) ? true : false,
                            );
                            /*}else{
									if (Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))){
										$result[]  = array(
											'label' => '<i class="'.$menu['icon'].'"></i><span>'.$menu['label'].'</span>',
											'url' => Yii::app()->createUrl($menu['url']['route'],$menu['url']['params']),
											'active' => (($subActive1==$subRoute) || ($subActive2==$subRoute))?true:false,
										);	
									}
								}
                                 * 
                                 */
                        }
                        //asort($result);
                        $menus[] = array(
                            'label' => '<i class="fa ' . $arrMenu['icon'] . '"></i><span>' . $arrMenu['label'] . '</span>',
                            'url' => '#',
                            'items' => $result
                        );
                        $result = array();
                    }
                }
                ?>
            <?php  } ?>
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
            /*
	<ul id="main-menu">
	<!-- add class "multiple-expanded" to allow multiple submenus to open -->
	<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
	<!-- Search Bar -->
<!--	<li id="search">
		<form method="get" action="">
		<input type="text" name="q" class="search-input" placeholder="Search something..."/>
		<button type="submit">
			<i class="entypo-search"></i>
		</button>
		</form>
	</li>-->
	<?php
            $modulMenu = ((!empty($this->module->menu)) ? $this->module->menu : null);
            $menus = array();
            $result = array();
            $menu = MenuModul::getMenuModulAdmin($modulMenu);
            if(isset($modulMenu)){
                foreach ($menu as $index => $arrMenu){
            ?>
                    <li class="root-level has-sub">
                    <a href="#">
                        <i class="<?php  echo $arrMenu['icon']; ?> icon-white" style="color:white"></i>
                        <span><?php  echo $arrMenu['label']; ?></span>
                    </a>
                    <ul>
                    <?php  foreach ($arrMenu['menus'] as $i=>$menu) { ?>
                        <li class="">
                        <a href="<?php echo Yii::app()->createUrl($menu['url']['route'],$menu['url']['params']); ?>">
                            <i class="<?php  echo $menu['icon']; ?> icon-white"></i>
                            <span><?php echo $menu['label']; ?></span>
                        </a>
                        </li>
                    <?php  } ?>
                    </ul>
                    </li>
            <?php  } ?>
	<?php  } ?>
	</ul>
	*/ ?>
        </div>
        <div class="main-content">
            <div class="row">
                <!-- Profile Info and Notifications -->
                <div class="col-md-6 col-sm-8 clearfix">
                    <ul class="user-info pull-left pull-none-xsm">
                        <!-- Profile Info -->
                        <li class="profile-info dropdown">
                            <!-- add class "pull-right" if you want to place this from right -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php
                                if (Yii::app()->user->getState('photouser') != "") {
                                    if (file_exists(Params::pathUserProfile() . Yii::app()->user->getState('photouser'))) {
                                        $src = Params::urlUserProfile() . Yii::app()->user->getState('photouser');
                                    } else {
                                        $src = Params::urlUserProfile() . Params::ICON_PROFIL_USER;
                                    }
                                } else {
                                    $src = Params::urlUserProfile() . Params::ICON_PROFIL_USER;
                                }
                                ?>
                                <img src="<?php echo $src; ?>" alt="" class="img-circle" width="44" />
                                <?php echo Yii::app()->user->name; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Reverse Caret -->
                                <li class="caret"></li>
                                <!-- Profile sub-links -->
                                <li>
                                    <a href="javascript:dialogGantiPassword()">
                                        <i class="entypo-key"></i>
                                        Ganti Password
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:dialog_kertas()">
                                        <i class="entypo-print"></i>
                                        Ganti Kertas
                                    </a>
                                </li>
                                <li>
                                    <!--<a href="javascript:viewUser()">-->
                                    <?php
                                    if (Yii::app()->user->getState('modul_id') != Params::MODUL_ID_SISADMIN) {
                                        $modulKey = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
                                        $init = (count((array)$modulKey) > 0 ? $modulKey->modul_key : '');
                                    } else {
                                        $init = '';
                                    }
                                    echo CHtml::link("<i class='entypo-user'></i> Lihat Profil", Yii::app()->createUrl('/sistemAdministrator/pegawaiProfil/viewUser'))
                                    ?>
                                </li>
                                <li visible="<?php echo (!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('Admin')); ?>">
                                    <a href="javascript:dialogTulisPengumuman()">
                                        <i class="entypo-clipboard"></i>
                                        Tulis Pengumuman
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="user-info pull-left pull-right-xs pull-none-xsm">
                        <!-- Raw Notifications -->
                        <?php if ($konsys->notifikasi) : ?>
                            <li class="notifications dropdown" hidden>
                                <?php
                                if (!empty(Yii::app()->controller->module->id)) {
                                    $module = ModulK::model()->findByAttributes(array('url_modul' => Yii::app()->controller->module->id));
                                    $attributes = array(
                                        'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
                                        'create_ruangan' => Yii::app()->user->getState('ruangan_id'),
                                        'modul_id' => $module->modul_id,
                                        'isread' => false
                                    );
                                    // $data_notif = NofitikasiR::model()->findAllByAttributes($attributes, array('order'=>'nofitikasi_id desc'));
                                    Yii::app()->session['modulId'] = isset(Yii::app()->session['modulId']) ? Yii::app()->session['modulId'] : 99999;
                                    $records = array();
                                    if (Yii::app()->user->getState('instalasi_id') > 0) {
                                        // (SELECT DATE(NOW()) - DATE(r.create_time) FROM notifikasi_r r WHERE notifikasi_r.nofitikasi_id = r.nofitikasi_id) <= notifikasi_r.lamahrnotif AND
                                        $sql = "
                            SELECT * FROM notifikasi_r WHERE
                            notifikasi_r.isread = false AND
                            instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND
                            create_ruangan = " . Yii::app()->user->getState('ruangan_id') . " AND
                            modul_id = " . $module->modul_id . " AND
                            isread = false
                            order by tglnotifikasi desc
                        ";
                                        $records = YII::app()->db->createCommand($sql)->queryAll();
                                    }
                                    $isi_notif = "";
                                } else {
                                    $records = array();
                                }
                                if (count((array)$records) > 0) {
                                    foreach ($records as $value) {
                                        $isi_notif .= '<li class="notification-primary">';
                                        $url = Yii::app()->controller->createUrl("/billingKasir/pembayaran/index", array("idPendaftaran" => 890, "frame" => true));
                                        $isi_notif .= '<a href="' . $url . '" value="' . $value['nofitikasi_id'] . '" onClick="$(\'#pop_pesan\').dialog(\'open\');getDetailNotifikasi(this);set_read_notifikasi(this);return false;">';
                                        $isi_notif .= '<i class="entypo-user pull-right"></i>';
                                        $isi_notif .= '<span class="line">' . $value['judulnotifikasi'] . '</span>';
                                        $isi_notif .= '<span class="line">';
                                        $isi_notif .= '' . $value['isinotifikasi'] . '';
                                        $isi_notif .= '</span>';
                                        $isi_notif .= '<span class="line small">' . MyFormatter::formatDateTimeForUser($value['tglnotifikasi']) . '</span>';
                                        $isi_notif .= '</a>';
                                        $isi_notif .= '</li>';
                                    }
                                }
                                ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="entypo-list"></i> Notifications
                                    <span <?php echo (count((array)$records) > 0 ? 'class="badge badge-info"' : ""); ?>><?php echo (count((array)$records) > 0 ? count((array)$records) : ""); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="top">
                                        <p class="small">
                                            <a href="#" class="pull-right">Mark all Read</a>
                                            You have <strong><?php echo (count((array)$records) > 0 ? count((array)$records) : 0); ?></strong> new notifications.
                                        </p>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller">
                                            <?php if (!empty($isi_notif)) { ?>
                                                <?php echo $isi_notif; ?>
                                            <?php } else { ?>
                                                <li class="notification-primary">
                                                    <a href="#">
                                                        <i class="entypo-user pull-right"></i>
                                                        <span class="line">
                                                            <!--<strong>Privacy settings have been changed</strong>-->
                                                            <strong></strong>
                                                        </span>
                                                        <span class="line small">
                                                            <!--3 hours ago-->
                                                        </span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <!--<li class="notification-danger">
                                    <a href="#">
                                            <i class="entypo-cancel-circled pull-right"></i>
                                            <span class="line">
                                                    John cancelled the event
                                            </span>
                                            <span class="line small">
                                                    9 hours ago
                                            </span>
                                    </a>
                                    </li>-->
                                            <!--<li class="notification-info">
                                    <a href="#">
                                            <i class="entypo-info pull-right"></i>
                                            <span class="line">
                                                    The server is status is stable
                                            </span>
                                            <span class="line small">
                                                    yesterday at 10:30am
                                            </span>
                                    </a>
                                    </li>-->
                                            <!--<li class="notification-warning">
                                    <a href="#">
                                            <i class="entypo-rss pull-right"></i>
                                            <span class="line">
                                                    New comments waiting approval
                                            </span>
                                            <span class="line small">
                                                    last week
                                            </span>
                                    </a>
                                    </li>-->
                                        </ul>
                                    </li>
                                    <li class="external">
                                        <a href="#" onClick="viewNotifikasi();">Lihat semua notifikasi</a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <!-- Message Notifications -->
                        <li class="notifications dropdown" style="position:relative;bottom:5px;">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" onClick="viewInformasi()">
                                <i class="entypo-info"></i> Informasi
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <ul class="dropdown-menu-list scroller">
                                        <!-- <li class="">
                                                                    <a href="#">
                                                                            <span class="image pull-right">
                                                                                    <img src="<?php // echo Yii::app()->request->baseUrl; 
                                                                                                ?>/themes/neon/assets/images/thumb-1.png" alt="" class="img-circle" />
                                                                            </span>
                                                                            <span class="line">
                                                                                    <strong>Luc Chartier</strong>
                                                                                    - yesterday
                                                                            </span>
                                                                            <span class="line desc small">
                                                                                    This ain’t our first item, it is the best of the rest.
                                                                            </span>
                                                                    </a>
                                                                    </li> -->
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <?php if ($konsys->notifikasi) :  ?>
                            <li class="notifications dropdown">
                                <?php
                                if (!empty(Yii::app()->controller->module->id)) {
                                    $module = ModulK::model()->findByAttributes(array('url_modul' => Yii::app()->controller->module->id));
                                    $attributes = array(
                                        'instalasi_id' => Yii::app()->user->getState('instalasi_id'),
                                        'create_ruangan' => Yii::app()->user->getState('ruangan_id'),
                                        'modul_id' => $module->modul_id,
                                        'isread' => false
                                    );
                                    // $data_notif = NofitikasiR::model()->findAllByAttributes($attributes, array('order'=>'nofitikasi_id desc'));
                                    Yii::app()->session['modulId'] = isset(Yii::app()->session['modulId']) ? Yii::app()->session['modulId'] : 99999;
                                    $records = array();
                                    if (Yii::app()->user->getState('instalasi_id') > 0) {
                                        $sql = "
									SELECT * FROM notifikasi_r WHERE																			
									isread = false	AND
									instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND
									create_ruangan = " . Yii::app()->user->getState('ruangan_id') . " AND
									modul_id = " . $module->modul_id . " AND
                                                                        date(tglnotifikasi) = '" . date('Y-m-d') . "' AND
                                                                        (pegawai_id IS NULL OR pegawai_id IN (" . (!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 'null') . ") )
									order by tglnotifikasi desc
									limit 20									
							";
                                        //                                                        if(Yii::app()->user->getState('instalasi_id')== Params::INSTALASI_ID_RM && Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LOKET_PENDAFTARAN){
                                        //                                                            $sql = "
                                        //									SELECT * FROM notifikasi_r WHERE																			
                                        //									isread = false	AND
                                        //									instalasi_id = ".Yii::app()->user->getState('instalasi_id')." AND
                                        //									create_ruangan = ".Yii::app()->user->getState('ruangan_id')." AND
                                        //									modul_id = ".$module->modul_id." AND
                                        //                                                                        date(tglnotifikasi) between '". date("Y-m-d") ."' AND '".date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))))."' AND
                                        //                                                                        (pegawai_id IS NULL OR pegawai_id IN (".(!empty(Yii::app()->user->getState('pegawai_id'))?Yii::app()->user->getState('pegawai_id'):'null').") )
                                        //									order by tglnotifikasi desc
                                        //									limit 20									
                                        //                                                            ";  
                                        //                                                            
                                        //                                                        }
                                        //RSPMC-827 -gizi RSPMC-989
                                        if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_LAUNDRY or Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) {
                                            $sql = "
									SELECT * FROM notifikasi_r WHERE																			
									isread = false	AND
									instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND
									modul_id = " . $module->modul_id . " AND
                                                                        date(tglnotifikasi) between '" . date("Y-m-d") . "' AND '" . date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d")))) . "' AND
                                                                        (pegawai_id IS NULL OR pegawai_id IN (" . (!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 'null') . ") )
									order by tglnotifikasi desc
									limit 20									
                                                            ";
                                        }
                                        $count = YII::app()->db->createCommand($sql)->queryAll();
                                        //								 echo 'test ' + $count;
                                        //                                                          exit();
                                        $sql = "";
                                        $sql = "
									SELECT * FROM notifikasi_r WHERE
									instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND
									create_ruangan = " . Yii::app()->user->getState('ruangan_id') . " AND
									modul_id = " . $module->modul_id . " AND							
                                                                        date(tglnotifikasi) = '" . date('Y-m-d') . "'  AND
                                                                        (pegawai_id IS NULL OR pegawai_id IN (" . (!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 'null') . ") )
									order by tglnotifikasi desc
									limit 20
							"; //notifikasi_r.isread = false AND
                                        //                                                        if(Yii::app()->user->getState('instalasi_id')== Params::INSTALASI_ID_RM && Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LOKET_PENDAFTARAN){
                                        //                                                            $sql = "
                                        //									SELECT * FROM notifikasi_r WHERE
                                        //									
                                        //									instalasi_id = ".Yii::app()->user->getState('instalasi_id')." AND
                                        //									create_ruangan = ".Yii::app()->user->getState('ruangan_id')." AND
                                        //									modul_id = ".$module->modul_id." AND							
                                        //                                                                       date(tglnotifikasi) between '". date("Y-m-d") ."' AND '".date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d"))))."' AND
                                        //                                                                        (pegawai_id IS NULL OR pegawai_id IN (".(!empty(Yii::app()->user->getState('pegawai_id'))?Yii::app()->user->getState('pegawai_id'):'null').") )
                                        //									order by tglnotifikasi desc
                                        //									limit 20
                                        //							";
                                        //                                                            
                                        //                                                        }
                                        //RSPMC-827 -gizi RSPMC-989
                                        if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_LAUNDRY or Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) {
                                            $sql = "
									SELECT * FROM notifikasi_r WHERE
									instalasi_id = " . Yii::app()->user->getState('instalasi_id') . " AND
									modul_id = " . $module->modul_id . " AND							
                                                                        date(tglnotifikasi) between '" . date("Y-m-d") . "' AND '" . date('Y-m-d', strtotime("+1 day", strtotime(date("Y-m-d")))) . "' AND
                                                                        (pegawai_id IS NULL OR pegawai_id IN (" . (!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 'null') . ") )
									order by tglnotifikasi desc
									limit 20
							";
                                        }
                                        $records = YII::app()->db->createCommand($sql)->queryAll();
                                    }
                                    $isi_notif = "";
                                    $count_notif = "";
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
                                        } else { //$(\'#pop_pesan\').dialog(\'open\');getDetailNotifikasi(this);set_read_notifikasi(this);return false;
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
                                ?> <div id="panel_notif">
                                    <a id="link_notif" href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                        <i class="entypo-attention"></i> Notifikasi
                                        <span class="badge badge-info" id="count_notif"><?php echo $count_notif; ?></span>
                                        <p style="text-align:right;"><?php echo (!empty($userRuangan) ? $userRuangan : '') ?></p>
                                    </a>
                                    <ul class="dropdown-menu" style="width:300px;">
                                        <li class="top">
                                            <p class="small">
                                                <a href="#" class="pull-right" onclick="set_read_all();">Tandai Semua</a>
                                                Kamu memiliki <strong><?php echo ($count_notif > 0 ? $count_notif : 0); ?></strong> notifikasi baru.
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
                                            <a href="#" onclick="viewNotifikasi();">View all notifications</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                    </li>
                    </ul>
                </div>
                <!-- Raw Links -->
                <div class="col-md-6 col-sm-4 clearfix hidden-xs" style="bottom:20px;">
                    <ul class="list-inline links-list pull-right">
                        <!--			<li>
				<a href="<?php echo Yii::app()->request->baseUrl; ?>" target="_BLANK" >Show Aplikasi</a>
			</li>-->
                        <!--li-->
                        <?php //if($modul_id == 2) { 
                        ?>
                        <!--a href="<?php echo Yii::app()->createUrl($url_modul, array('modulId' => $modul_id)); ?><?php // echo Yii::app()->request->baseUrl; 
                                                                                                                    ?>">
															<img class="img-circle" width="20px" src="<?php echo Params::urlIconModulDirectory() . $icon_modul; ?>" width="140" alt="" />
															<?php echo $modul_nama ?>
															</a-->
                        <!--a ><?php //echo $userRuangan 
                                ?></a-->
                        <?php //} else { 
                        ?>
                        <!-- a hidden style="position:relative;left:38px;"href="<?php echo Yii::app()->createUrl($url_modul, array('modulId' => $modul_id)); ?><?php // echo Yii::app()->request->baseUrl; 
                                                                                                                                                                ?>">
	                            <img class="img-circle" width="20px" src="<?php echo Params::urlIconModulDirectory() . $icon_modul; ?>" width="140" alt="" />
															<?php echo $modul_nama ?>
														</a-->
                        <!--a ><?php //echo (!empty($userRuangan) ? $userRuangan : '') 
                                ?></a-->
                        <?php //} 
                        ?>
                        <!--/li-->
                        <li class="sep"></li>
                        <li>
                            <div id="clock" class="headerTimeClock pull-right navbar-text-baru"></div>
                            <a class="marginplus" href="javascript:void(0);" class="navbar-link"><img class="clock-image marginplus" src="images/clock.png" width="20px" height="20px" /></a>
                        </li>
                        <?php if ($konsys->chat) : ?>
                            <li class="sep"></li>
                            <li>
                                <a href="#" data-toggle="chat" data-animate="1" data-collapse-sidebar="1">
                                    <i class="entypo-chat"></i>
                                    Chat
                                    <span class="badge badge-success chat-notifications-badge is-hidden">0</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="sep"></li>
                        <li>
                            <a href="<?php echo $this->createUrl('/site/logout'); ?>">
                                Log Out <i class="entypo-logout"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr />
            <?php
            $this->widget('ext.bootstrap.widgets.BootBreadcrumbs', array(
                //'homeLink' => CHtml::link('<i class="entypo-home"></i>Dashboard', Yii::app()->homeUrl.'?r=sistemAdministrator'),
                'homeLink' => array(
                    'label' => 'Dashboard',
                    //'url' =>  Yii::app()->homeUrl.'?r='.str_replace(' ', '', lcfirst($modul_nama))
                    'url' => Yii::app()->createUrl(Yii::app()->controller->module->id)
                ),
                'links' => $this->breadcrumbs,
                'htmlOptions' => array('class' => 'breadcrumb bc-2'),
            ));
            ?>
            <?php echo $content; ?>
            <!-- Footer -->
            <footer class="main">
                <center><strong><?php echo $profil->nama_rumahsakit; ?> </strong>&copy; <?php echo date('Y') ?> All Rights Reserved
                </center>
            </footer>
        </div>
        <div id="chat" class="fixed" data-current-user="<?php echo Yii::app()->user->name; ?>" data-order-by-status="1" data-max-chat-history="25">
            <?php
            $this->beginWidget('ListUserChatNeon', array(
                // 'class'=>'ListUserChat',
                'htmlOptions' => array('class' => ''),
            ));
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <?php if ($konsys->suaranotifikasi) { ?>
        <audio id="suara_notif" src="data/sounds/notif/slow-spring-board.mp3" type="audio/mp3" />
    <?php } ?>
</body>

</html>
<!-- START NEON CHAT -->
<!--
<div id="chat" class="fixed" data-current-user="<?php //echo Yii::app()->user->name; 
                                                ?>" data-order-by-status="1" data-max-chat-history="25">
	<div class="chat-inner">
		<h2 class="chat-header">
			<a href="#" class="chat-close" data-animate="1"><i class="entypo-cancel"></i></a>
			<i class="entypo-users"></i>
			Chat
			<span class="badge badge-success is-hidden">0</span>
		</h2> -->
<!-- <div class="chat-group" id="group-1"> -->
<!-- <strong>Favorites</strong> -->
<!-- 			<a href="#" id="sample-user-123" data-conversation-history="#sample_history"><span class="user-status is-online"></span> <em>Catherine J. Watkins</em></a>
			<a href="#"><span class="user-status is-online"></span> <em>Nicholas R. Walker</em></a> -->
<!-- 			<a href="#"><span class="user-status is-busy"></span> <em>Susan J. Best</em></a>
			<a href="#"><span class="user-status is-offline"></span> <em>Brandon S. Young</em></a>
			<a href="#"><span class="user-status is-idle"></span> <em>Fernando G. Olson</em></a>
		</div> -->
<!-- </div> -->
<!-- conversation template -->
<!-- <div class="chat-conversation">
		<div class="conversation-header">
			<a href="#" class="conversation-close"><i class="entypo-cancel"></i></a>
			<span class="user-status"></span>
			<span class="display-name"></span>
			<small></small>
		</div>
		<ul class="conversation-body">
		</ul>
		<div class="chat-textarea">
			<textarea class="form-control autogrow" placeholder="Type your message"></textarea>
		</div>
	</div> -->
<!-- </div> -->
<!-- Chat Histories -->
<!-- <ul class="chat-history" id="sample_history">
	<li>
		<span class="user">Art Ramadani</span>
		<p>Are you here?</p>
		<span class="time">09:00</span>
	</li>
	<li class="opponent">
		<span class="user">Catherine J. Watkins</span>
		<p>This message is pre-queued.</p>
		<span class="time">09:25</span>
	</li>
	<li class="opponent">
		<span class="user">Catherine J. Watkins</span>
		<p>Whohoo!</p>
		<span class="time">09:26</span>
	</li>
	<li class="opponent unread">
		<span class="user">Catherine J. Watkins</span>
		<p>Do you like it?</p>
		<span class="time">09:27</span>
	</li>
</ul> -->
<!-- START DIALOG -->
<!-- NOTIFIKASI -->
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
    // additional javascript options for the dialog plugin
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
<!-- END NOTIFIKASI -->
<!-- INFORMASI -->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'informasidialog',
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
echo '<iframe id="frameinformasi" src="" height="100%" width="100%" style="border:none;"></iframe> ';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<!-- END INFORMASI -->
<!-- GANTI PASSWORD -->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'gantipassworddialog',
    // additional javascript options for the dialog plugin
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
<!-- END GANTI PASSWORD -->
<!-- GANTI KERTAS -->
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
<!-- END GANTI KERTAS -->
<!-- PROFILE -->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'profiluserdialog',
    // additional javascript options for the dialog plugin
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
<!-- END PROFILE -->
<!-- TULIS PENGUMUMAN -->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'tulispengumumandialog',
    // additional javascript options for the dialog plugin
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
<!-- END TULIS PENGUMUMAN -->
<!-- END DIALOG -->
<?php
//VARIABLE UNTUK JS
if (!empty($konsys->refreshnotifikasi)) {
    $interval = $konsys->refreshnotifikasi * 1000;
} else {
    $interval = 0;
}
?>
<script type="text/javascript">
    /*
	function textfield validation
	tidak boleh diawali dengan SPASI
*/
    $(function() {
        $('body').on('keydown', 'input,textarea', function(e) {
            console.log(this.value);
            if (e.which === 32 && e.target.selectionStart === 0) {
                return false;
            }
        });
    });
    /*
    	 end of function
    	 textfield validation
    */
    // function setMenuActive(){
    // 	var cari_url = getUrl();
    // 	var a_link = $("#main-menu a[href*='"+cari_url+"']");
    // 	a_link.parent().parent().parent().addClass('active opened');
    // 	a_link.parent().addClass('active');
    // }
    // function getUrl() {
    //     var loc = window.location;
    //     var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    //     var minUrl = loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    //     return url = $(location).attr('href').replace(minUrl,'');
    // }
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
                    // var notif_info = toastr.info("Terdapat " + data.count_notif + " notifikasi yang belum dibaca.");
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
        $('#framenotifikasi').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/notifikasiFrame/admin'); ?>');
    }

    function viewPengumuman(id) {
        $('#pengumumandialog').dialog('open');
        if (!id)
            $('#frameinformasi').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>');
        else
            $('#frameinformasi').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>&id=' + id);
    }

    function dialogGantiPassword() {
        $('#gantipassworddialog').dialog('open');
        $('#framegantipassword').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/LoginPemakaiFrame/gantiPassword', array('id' => $idUser, 'modul' => $idModul,)) ?>');
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
        $('#frameprofiluser').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/LoginpemakaiK/view'); ?>');
    }

    function dialogTulisPengumuman() {
        $('#tulispengumumandialog').dialog('open');
        $('#frametulispengumuman').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/tulisPengumumanFrame/create'); ?>');
    }

    function viewInformasi(id) {
        $('#informasidialog').dialog('open');
        if (!id)
            $('#frameinformasi').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>');
        else
            $('#frameinformasi').attr('src', '<?php echo Yii::app()->createUrl('sistemAdministrator/pengumumanFrame/admin'); ?>&id=' + id);
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
                        msg = data.msg;
                        neon.pushMessage(data.from, msg.replace(/<.*?>/g, ''), data.from, new Date(), true, true);
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
                        neon.pushMessage(data.from, msg.replace(/<.*?>/g, ''), data.from, new Date(), true, true);
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
    $(document).ready(function() {
        <?php if (isset($_GET["status"])) { ?>
            showToast('<?php echo $_GET["status"]; ?>');
        <?php } ?>
        // 	setMenuActive();
        get_notifikasi();
        <?php if ($konsys->chat) : ?>
            startChat();
            <?php if ($interval > 0) { ?>
                setInterval('updateChat();get_notifikasi();', <?php echo $interval ?>);
            <?php } ?>
            $('.search-form span.required').hide();
            //var chatServer='<?php //echo $konsys->nodejs_host 
                                ?>';
            //var chatPort='<?php //echo $konsys->nodejs_port 
                            ?>';
            // socket = io.connect('http://'+chatServer+':'+chatPort);
            $("[id^=group-]").find('a').each(function(index) {
                var partnerId = $(this).attr('id');
                var userId = '<?php echo Yii::app()->user->name; ?>';
                urutkan = [partnerId, userId]
                urutkan.sort();
                conversationID = urutkan[0] + '' + urutkan[1];
                console.log(partnerId);
                socket.emit('subscribe', conversationID);
                $(this).attr('conv-id', conversationID);
            });
            var neon = neonChat;
            var userId = '<?php echo Yii::app()->user->name; ?>';
            socket.on('message', function(data) {
                if (data.type) {
                    if (data.type == 'typing') {
                        if (userId != data.userID) {
                            $('#chat .conversation-header small').html('Typing...');
                        }
                    } else if (data.type == 'blur') {
                        if (userId != data.userID) {
                            $('#chat .conversation-header small').html('Online');
                        }
                    } else {
                        if (userId != data.userID) {
                            neon.pushMessage(data.userID, data.message, data.userID, new Date(), true, true);
                            neon.renderMessages(data.userID);
                        }
                        $('#chat .conversation-header small').html('Online');
                    }
                } else {
                    console.log(data);
                }
            });
        <?php endif; ?>
    });
</script>
<script>
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
<!-- End Bottom Scripts -->
<?php if ($konsys->issuecollector) : ?>
    <script type="text/javascript" src="https://piiproject.atlassian.net/s/ea6d8abeea8f9d4e9988279ef398643d-T/en_US-s4xgn2/65000/31/1.4.25/_/download/batch/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector/com.atlassian.jira.collector.plugin.jira-issue-collector-plugin:issuecollector.js?locale=en-US&collectorId=fcff53dd"></script>
    <script type="text/javascript">
        window.ATL_JQ_PAGE_PROPS = {
            "triggerFunction": function(showCollectorDialog) {
                //Requires that jQuery is available!
                $("#myCustomTrigger").click(function(e) {
                    e.preventDefault();
                    showCollectorDialog();
                });
            }
        };
    </script>
<?php endif; ?>