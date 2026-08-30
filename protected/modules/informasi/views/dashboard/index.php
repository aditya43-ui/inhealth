<style type="text/css">
    .row {
        margin: 0 -20px;
    }

    .col-sm-12.text-center {
        display: flex;
        flex-wrap: wrap;
    }

    .icon {
        display: inline-block;
        flex: 1 0 21%;
        width: calc(20% - 10px);
        margin: 5px;
        text-align: center;
        font-weight: bold;
        font-size: 15px;
        color: #837E7C;
        border: solid 1px #ddd;
        border-radius: 10px;
        text-decoration: none;
        transition: .25s;
        box-shadow: 0 0 5px 0 rgba(0, 0, 0, .1);
    }

    .icon:hover,
    .icon:focus {
        background: #eee;
        color: #4290D0;
    }

    .icon img {
        margin: 15px;
        width: 20vw;
        max-width: 90px;
        -webkit-transition: .5s;
        -moz-transition: .5s;
        transition: .5s;
    }

    .icon img:hover {
        opacity: .75;
    }

    .icon span {
        display: block;
        margin-bottom: 15px;
        padding: 0 15px;
    }
</style>
<?php
$modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
$nama_peg = (!empty(Yii::app()->user->getState('nama_pegawai')) ? Yii::app()->user->getState('nama_pegawai') : Yii::app()->user->getState('nama_pemakai'))
?>
<div class="well">
    <h1><?php echo date('d') . ' ' . MyFormatter::getMonthId(date('m')) . ' ' . date('Y'); ?></h1>
    <h3>Selamat Datang di Modul <?php echo $this->module->id; ?>, <b><?php echo $nama_peg; ?></b></h3>
</div>
<div class="white-container">
    <div class="row">
        <div class="col-sm-12 text-center">
            <?php
            foreach ($modMenu as $i => $menu) {
                switch ($menu->menu_nama) {
                    case "Tarif":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/tarif.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                        break;
                    case "Kamar":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/kamar.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                        break;
                    case "Antrian Poliklinik":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/antrian.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                        break;
                    case "Antrian Masuk Penunjang (new)":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/antrian.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                        break;
                    case "Antrian Pendaftaran (new)":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/antrian.png'><div>" . $menu->menu_namalainnya . "</a></div";
                        break;
                    case "Antrian Farmasi (new)":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/antrian.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                        break;
                    case "Rawat Jalan":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/rawat-jalan.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                        break;
                    case "Rawat Darurat":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/rawat-darurat.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                        break;
                    case "Rawat Inap":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/rawat-inap.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                        break;
                    case "Keluhan Pasien":
                        echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/rawat-inap.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                        break;
                }
                if ($menu->menu_nama == 'Profil Rs') {
                    echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/profil.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                }
                if ($menu->menu_nama == 'Sarana') {
                    echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/laporan.jpg'><span>" . $menu->menu_namalainnya . "</span></a>";
                }
                if ($menu->menu_nama == 'Say Hello') {
                    echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/say-hello.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                }
                if ($menu->menu_nama == 'Pengaduan') {
                    echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/pengaduan.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                }
                if ($menu->menu_nama == 'Laporan Informasi') {
                    echo "<a class='icon' href='" . Yii::app()->createUrl(isset($menu->menu_url) ? $menu->menu_url : '', array('modul_id' => Yii::app()->session['modul_id'])) . "'><img src='images/icon_informasi/laporan.png'><span>" . $menu->menu_namalainnya . "</span></a>";
                }
            } ?>
        </div>
    </div>
</div>