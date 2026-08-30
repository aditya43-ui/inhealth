<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/dist/notiflix-aio-2.7.0.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/alertnotiflix/notiflixalert.js'); ?>

<head>
    <meta charset="utf-8">
    <!-- <title></title> -->
    <link rel="stylesheet" type="text/css" href="css/font.css" />
    <script>
        var ekt = document.body;
        if (ekt.requestFullscreen) {
            ekt.requestFullscreen();
        } else if (ekt.msRequestFullscreen) {
            ekt.msRequestFullscreen();
        } else if (ekt.mozRequestFullScreen) {
            ekt.mozRequestFullScreen();
        } else if (ekt.webkitRequestFullscreen) {
            ekt.webkitRequestFullscreen();
        }
    </script>
    <?php
    $data = ProfilrumahsakitM::model()->find();
    $config = KonfigsystemK::model()->find();
    ?>
    <style>
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        body {
            background-color: #efefef;
            margin-left: 20px;
            margin-right: auto;
        }

        .table {
            width: 100%;
            /* box-shadow: none; */
            /* border-radius: 0px; */
            border: none;
            /* border-collapse: collapse; */
        }

        tr td {
            background: #fff !important;
        }

        #ketersediaan-kamar-grid {
            height: calc(100vh - 200px) !important;
            overflow-y: auto;
            scroll-behavior: smooth;
            /* background: url("<?php //echo Yii::app()->request->baseUrl; 
                                ?>/images/antrian/dokter.jpg") center center no-repeat; */
            background-size: cover;
        }

        #ketersediaan-kamar-grid thead {
            /* background: white; */
            position: sticky;
            top: 0;
            left: 0;
            /* border: solid 1px #000 !important; */
            /* box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4); */
            z-index: 100;
        }

        #ketersediaan-kamar-grid tbody tr {
            /* opacity: .9 !important; */
        }

        .table>thead>tr:first-child>th:first-child {
            border-radius: 40px;
        }

        .table>thead>tr:first-child>th:last-child {
            border-radius: 40px;
        }

        .table>tbody>tr:last-child>td:last-child,
        .table>tbody>tr:last-child>td:first-child {
            border-radius: 40px;
        }

        .table th,
        .table td {
            /* background-color: white !important; */
            /* border: 1px solid black; */
            color: #006838;
            border-radius: 0px;
            padding: 6px;
            font-size: 10pt;
        }

        .background {
            position: fixed;
            left: 0;
            top: -20px;
            z-index: -100;
            width: 100vw;
            height: 110vh;
            background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/jadwal_dokter/BG-Jadwal-Dokter-06.jpg") center center no-repeat;
            background-size: cover;
            /* filter: blur(25px) brightness(125%);
            -webkit-filter: blur(25px) brightness(125%);
            -moz-filter: blur(25px) brightness(125%); */
        }

        .fw {
            color: #fff !important;
        }

        #header {
            display: flex;
            align-items: center;
            height: 100px;
            width: calc(100% - 15px);
            margin: 10px 0 10px;
            /* background: rgba(255, 255, 255, .85); */
        }

        #refresh {
            position: fixed;
            right: 5px;
            top: 5px;
            z-index: 50;
            padding: 5px;
            color: #fff;
            background: #57A595;
            border-radius: 5px;
        }

        #refresh a {
            color: #fff;
            font-size: 20px;
        }

        .tombolheader td {
            text-align: center;
        }

        .clock {
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 200px;
            height: 60px;
            color: #ffffff;
            /* border: 2px solid #999; */
            border-radius: 4px;
            text-align: center;
            background: linear-gradient(90deg, #000, #555);
        }

        #logo {
            float: left;
            width: 100%;
            height: 70px;
            background: url("<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit; ?>") left center no-repeat;
            background-size: contain;
        }

        .col-sm-3 {
            float: left;
            width: 25%;
        }

        .col-sm-6 {
            float: left;
            width: 50%;
        }

        .keterangan {
            font-size: 20px;
            font-weight: bold;
            color: grey;
            text-align: center;
        }

        .bases {
            text-align: center !important;
            width: 100%;
        }

        .page-title {
            display: inline-block;
            width: 90%;
            margin: 10px 0;
            padding-bottom: 10px;
            font-size: 1.15rem;
            border-bottom: solid 1px #ddd;
            text-transform: uppercase;
        }

        .content {
            width: 100%;
            padding: 0;
            margin: 0;
            position: static;
            display: block;
            text-align: center;
        }

        .block-footer-antrian {
            position: fixed;
            left: 0;
            bottom: 0;
        }

        .list-jadwal {
            border-collapse: collapse;
        }

        .list-jadwal td,
        .list-jadwal th {
            /* border: 1px solid #ddd; */
            padding: 8px;
        }

        .list-jadwal tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .list-jadwal tr:hover {
            background-color: #ddd;
        }

        .list-jadwal th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #00df92;
            color: #fff;
            font-family: oswald;
            font-weight: bold
        }

        .borderline {
            padding: 15px;
            /* border: 2px solid #00df92; */
            border-radius: 10px;
        }

        #footerAntrian {
            margin-top: 20px;
            width: calc(100% - 240px);
            box-shadow: 0 0 15px rgba(0, 0, 0, .5);
        }

        #footerClock {
            width: 240px;
            height: 60px;
            background: url(<?php echo Params::urlVideoAntrian(); ?>logo.gif) center center no-repeat;
            background-size: cover;
            border-radius: 30px 0 0 0;
            box-shadow: 0 0 5px rgba(0, 0, 0, .5);
        }

        #tab-text {
            color: #ED1E79 !important;
            display: block;
            margin-bottom: 10px;
            font-size: 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        #tab-text2 {
            color: #fff !important;
            display: block;
            padding-bottom: 10px;
            padding-top: 10px;
            margin: 0px 0px 10px 0px;
            /* margin: 0 20px; */
            font-size: 1.75rem;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #006838;
            border-radius: 40px;
        }

        .tab-pilih {
            margin: 0 15px;
            padding: 5px 0;
            background: #efefef;
            /* border: 2px solid #ddd; */
            border-bottom: none;
            border-radius: 15px 15px 0 0;
            overflow: hidden;
        }

        .tab-pilih>li {
            display: inline-block;
            width: 33%;
            margin: 0;
            font-size: 1rem;
            cursor: pointer;
        }

        .tab-pilih a {
            display: block;
            padding: 8px;
            text-decoration: none;
            color: #888;
        }

        .tab-pilih .past a,
        .tab-pilih .active a {
            color: #fff;
        }

        .penjamin-tab {
            background: #efefef;
            border-radius: 10px 0 0 0;
            transition: .15s;
        }

        .poli-tab {
            background: #efefef;
            transition: .15s;
        }

        .dokter-tab {
            background: #efefef;
            border-radius: 0 10px 0 0;
            transition: .15s;
        }

        .penjamin-tab.past,
        .poli-tab.past {
            background: #57a595;
        }

        .penjamin-tab.active,
        .poli-tab.active,
        .dokter-tab.active {
            font-weight: bold;
            background: #448074;
        }

        .item-select {
            display: flex;
            flex-wrap: wrap;
            position: relative;
            height: calc(100vh - 245px);
            overflow-y: auto;
            margin: 0 15px;
            padding: 15px 0;
            background: rgba(255, 255, 255, .5);
            text-align: center;
            /* border: 2px solid #ddd; */
            border-top: none;
            border-radius: 0 0 15px 15px;
        }

        .item-select>p {
            margin: 0;
            padding: 20px 50px 15px;
            font-size: 1.2rem;
        }

        .item {
            display: flex;
            flex-wrap: wrap;
            flex: 1 0 22%;
            max-width: calc(25% - 30px);
            vertical-align: top;
            top: 0;
            width: calc(24% - 30px);
            margin: 15px;
        }

        .maaf {
            position: absolute;
            top: 50%;
            left: 50%;
            text-align: center;
            font-size: 22px !important;
            transform: translate(-50%, -50%);
        }

        .tombol {
            flex: 1 0 21%;
            width: 100%;
            height: 280px;
            padding: 15px 0;
            border-radius: 20px;
            cursor: pointer;
            transition: .25s;
        }

        .tombol:hover {
            filter: brightness(80%);
        }

        .tombolbody hr {
            width: auto;
            height: 1px;
            margin: 0 30px 5px;
            /* border: none; */
            background: #fff;
        }

        .tombolpilih {
            width: 250px;
            margin-top: 3px;
            height: 250px;
            border-radius: 20px;
            cursor: pointer;
        }

        .tombolicon {
            font-size: 70px;
            color: #fff;
            padding: 15px 0;
            text-align: center;
        }

        .labeltiket {
            padding: 0 15px;
            font-size: 24px;
            color: #fff;
            font-family: oswald;
            text-align: center;
            font-weight: bold;
            padding-top: 5px;
            text-decoration: none;
        }

        .setakhir {
            font-size: 12pt;
        }

        #tab-tgl-text {
            color: #ED1E79 !important;
            display: block;
            margin-bottom: 10px;
            font-size: 1rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 300px 300px 300px;
            gap: 50px;
            background-color: white;
            padding: 10px;
            /* border : 1px solid gray; */
            justify-content: center;

        }

        .grid-container2 {
            display: grid;
            grid-template-columns: 40% 60%;
            gap: 50px;
            background-color: none;
            padding: 10px;
            /* border : 1px solid gray; */
            justify-content: center;
            margin-left: 50px;
            margin-right: 50px;

        }

        .grid-container_div {
            display: grid;
            grid-template-columns: 300px 300px 300px;
            gap: 50px;
            background-color: white;
            padding: 10px;
            /* border : 1px solid gray; */
            justify-content: center;
            /* background-color: white; */
            /* padding: 10px; */
            /* border : 1px solid gray; */
            /* justify-content: center;*/

        }

        .grid-container>div {
            background-color: green;
            text-align: center;
            font-size: 30px;
            height: 200px;
            border-radius: 8px;
            /* //opacity: 0; */
        }

        .grid-container2>div {
            background-color: none;
            text-align: center;
            font-size: 30px;
            /* height: 200px; */
            border-radius: 8px;
            /* //opacity: 0; */
        }

        .grid-container_div>div {
            /* background-color: rgba(255, 255, 255, 0.8); */
            /* text-align: center; */
            /* padding: 20px 0;*/
            background-color: green;
            text-align: center;
            font-size: 30px;
            height: 200px;
            border-radius: 8px;
        }

        a:link,
        a:visited {
            color: (internal value);
            text-decoration: none;
            cursor: pointer;
        }

        a:link:active,
        a:visited:active {
            color: (internal value);
        }

        .flex-container {
            display: flex;
            background-color: none;
            justify-content: center;
            flex-direction: row;
        }

        .flex-container>div {
            background-color: #f1f1f1;
            margin: 10px;
            padding: 20px;
            font-size: 30px;
        }

        .judul_form {
            font-size: 40pt;
            text-align: center;
            margin-bottom: 50px;
        }

        .judul_form p {
            font-size: 35pt;
        }

        .item-select {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            position: relative;
            height: calc(100vh - 245px);
            overflow-y: auto;
            margin: 0 15px;
            padding: 15px 0;
            background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/jadwal_dokter/BG-06.png") no-repeat;
            /* background: rgba(255, 255, 255, .5); */
            background-size: 100%;
            /* background-size:calc(100vh - 245px); */
            text-align: center;
            border: 2px solid #006838;
            border-top: none;
            border-radius: 0 0 15px 15px;
        }

        .item-select>p {
            margin: 0;
            padding: 20px 50px 15px;
            font-size: 1.2rem;
        }

        .poliklinik {
            background-color: none;
            width: 100%;
            height: 500px;
            overflow: scroll;
        }

        .ui-datepicker-calendar {
            font-size: xx-large;

        }

        #slotjadwal thead {
            font-size: 24px !important;
        }

        #slotjadwal tbody {
            font-size: 24px !important;
        }

        .content {
            position: relative;
            text-align: center;
            color: white;
        }

        .detail-pasien {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .bg {
            width: 550px;
            height: 300px;
            border: 1px solid greenyellow;
            margin: auto;
            /* width: 50%; */
            border: 3px solid green;
            margin-bottom: 40px;

        }

        .theme-table {
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 40px;
        }

        #logo-detail {
            position: relative;
            top: 20px;
            right: 25%;
            width: 400px;
        }

        table.theme-table tr td {
            font-size: 17px;
        }
    </style>
</head>

<body>
    <!-- <input type="hidden" id="pegawai_id" >
    <input type="hidden" id="ruangan_id" > -->

    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'booking',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
    ));
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        $model = BuatjanjipoliT::model()->findByPk($_GET['buatjanjipoli_id']);
        Yii::app()->user->setFlash('success', "Data Booking " . $model->pasien->namadepan . " " . $model->pasien->nama_pasien . " berhasil disimpan");
        echo "<script>$(document).ready(function() {
            printKarcis();
        });</script>";
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php
    echo $form->hiddenField($model, "ruangan_id", array("id" => "ruangan_id"));
    echo $form->hiddenField($model, "pegawai_id", array("id" => "pegawai_id"));

    echo $form->hiddenField($model, "pasien_id", array("id" => "pasien_id"));
    echo $form->hiddenField($model, "penjamin_id", array("id" => "penjamin_id"));
    echo $form->hiddenField($model, "carabayar_id", array("id" => "carabayar_id"));
    ?>
    <!-- <input type="hidden" id = 'waktumulai'> -->
    <?php echo $form->hiddenField($model, 'waktumulai', array("id" => 'waktumulai')); ?>
    <div class="background"></div>
    <!--<div id="headerAntrian">
                <div id="refresh" style="float:right;">-->
    <div class="bases">
        <div class="row">
            <div class="col-sm-3">
                <div></div>
            </div>
            <div class="col-sm-9" style="text-align: right;margin-top:5px;margin-right:10px;" hidden>
                <?php echo CHtml::image(Yii::app()->getBaseUrl('webroot') . "/images/dokter/link_4.png", 'RSSACPT', array(
                    'style' => 'width: 100px;',
                )); ?>
                <?php echo CHtml::image(Yii::app()->getBaseUrl('webroot') . "/images/dokter/link_3.png", 'RSSACPT', array(
                    'style' => 'width: 100px; ',
                )); ?>
                <?php echo CHtml::image(Yii::app()->getBaseUrl('webroot') . "/images/dokter/link_2.png", 'RSSACPT', array(
                    'style' => 'width: 100px; ',
                )); ?>
                <?php echo CHtml::image(Yii::app()->getBaseUrl('webroot') . "/images/dokter/link_1.png", 'RSSACPT', array(
                    'style' => 'width: 100px;',
                )); ?>
            </div>
        </div>
        <div id="header" class="row">
            <div class="col-sm-3" style="padding-right: 50px;">
                <div>
                    <?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
                    <?php echo CHtml::image(Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit, 'rssa', array(
                        'style' => 'width: 210px; margin-top: -20px;',
                    )); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div style=" text-align: center;">
                    <!-- <span class="page-title">
                        <?php //echo strtoupper($data->nama_rumahsakit); 
                        ?>
                    </span> -->
                    <span id="tab-text">
                        <!-- INFORMASI RESEP OBAT<br/> -->
                        <?php //echo strtoupper($data->nama_rumahsakit); 
                        ?>
                    </span>
                    <!-- <span id="tab-tgl-text">
                        <i><?php //echo date('d M Y') . ' s/d ' . date('d M Y', strtotime('+6 days')) 
                            ?></i>
                    </span> -->
                </div>
            </div>
            <div class="col-sm-3" style="margin-top: -17px; text-align: right; padding-right: 5px;">
                <!-- <div><?php //echo CHtml::image(Yii::app()->getBaseUrl('webroot')."/images/dokter/link_1.png", 'RSSACPT', array(
                            //     'style'=>'height: 20px;'
                            // )); 
                            ?></div>
                <div><?php //echo CHtml::image(Yii::app()->getBaseUrl('webroot')."/images/dokter/link_2.png", 'RSSACPT', array(
                        //     'style'=>'height: 20px;'
                        // )); 
                        ?></div>
                <div><?php //echo CHtml::image(Yii::app()->getBaseUrl('webroot')."/images/dokter/link_3.png", 'RSSACPT', array(
                        //     'style'=>'height: 20px;'
                        // )); 
                        ?></div>
                <div><?php //echo CHtml::image(Yii::app()->getBaseUrl('webroot')."/images/dokter/link_4.png", 'RSSACPT', array(
                        //     'style'=>'height: 20px;'
                        // )); 
                        ?></div> -->

                <p style="margin: 0; float: right;">
                    <?php echo "<span style='font-family: oswald; font-size:1.25vw;'>" . strtoupper(hari()) . ",</span>"; ?>
                    <?php
                    $tgl = date('d');
                    $tahun = date('Y');
                    echo "<span style='font-family:oswald;font-size:1.25vw;'>" . $tgl . " " . bulan() . " " . $tahun . "</span>";
                    ?>
                    <br />
                    <span id="clock" style="display: inline-block; width: 200px; font-family: oswald; font-size: 1.75vw;"></span>
                </p>
            </div>
            <!-- <div class="col-sm-3" style="padding-right: 30px;">
                <p style="margin: 0 15px 0 0; float: right;"> -->
            <?php //echo "<span style='font-family: oswald; font-size:1.75vw;'>" . strtoupper(hari()) . ",</span>"; 
            ?>
            <?php
            // $tgl = date('d');
            // $tahun = date('Y');
            // echo "<span style='font-family:oswald;font-size:1.75vw;'>" . $tgl . " " . bulan() . " " . $tahun . "</span>";
            ?>
            <!-- <span id="clock" style="display: inline-block; width: 200px; margin-top: 15px; font-family: oswald; font-size: 1.75vw;"></span> -->
            <!-- </p>
            </div> -->
        </div>
        <div class="row halaman1" style="margin: 10px auto 200px auto;width:fit-content;">

                    <br><br><br><br>
            <div class="judul_form">BOOKING POLIKLINIK <br>
                <p style="margin-top: 20px; font-size:24px;"><?php echo $modProfilRs->nama_rumahsakit; ?></p>
            </div>

            <p style="font-size: 20pt;">Silahkan Masukkan atau Scan</p>
            <p style="font-size: 20pt;">Nomor Rekam Medik atau Nomor <span style="font-weight: bold;">Kartu BPJS</span> atau <span style="font-weight: bold;">Kartu Tanda Penduduk (KTP)</span></p>
            <?php echo CHtml::textField('no_identitas_pasien', null, array('class' => '', 'id' => 'input_no_kartu', 'style' => 'width:700px;height:50px;font-size:30px; border-radius:5px;background-color:#B7FBB7;')) ?><br>
            <!-- <span style="color: red;" class="nodata">Data Anda tidak ditemukan</span> -->
            <br>
            <button type="button" class="btn btn-danger" style="font-size:30px; padding:20px 30px; border-radius:5px; margin-top:10px;background-color:#3E6F3E;" onclick="carino()"><i class="glyphicon glyphicon-search"></i> Proses</button>
            <div style="text-align: center; position:absolute;bottom: 8em; left:0;cursor: pointer;" onClick="kembaliKeHalamanAwal()">
                <i class='entypo-home' style="font-size: 80px;border:2px solid ;border-radius:100%;width:150px;height:100px;opacity:70%"></i>
            </div>
        </div>
        <div class="halaman3">
            <div style="margin-right:1250px;">
                <button type="button" class="btn " style="font-size:15px; padding:10px 20px; border-radius:5px;background-color:gray;" onclick="kembali(2)"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</button>
            </div>
            <div class="judul_form">Pilih Poliklinik</div>
            <div class="poliklinik">
                <div class="grid-container" style="margin:auto;width:fit-content;">

                    <?php
                    $ruangan = RuanganM::model()->findAllByAttributes(array(
                        'instalasi_id' => Params::INSTALASI_ID_RJ,
                        'ruangan_aktif' => true,
                    ), array(
                        'order' => 'ruangan_nama'
                    ));



                    foreach ($ruangan as $item) :

                        $hari = strtoupper(MyFormatter::getDayUser(date('w')));

                        $jadwal = JadwalbukapoliM::model()->findByAttributes(array(
                            'ruangan_id' => $item->ruangan_id,
                            'hari' => $hari,
                        ));

                        $ada = false;
                        $txt_tidakada = "";

                        if (empty($jadwal)) {
                            $ada = false;
                        } else {
                            $sekarang = strtotime(date('H:i:s'));
                            $buka = strtotime($jadwal->jammulai);
                            $tutup = strtotime($jadwal->jamtutup);

                            if ($sekarang < $buka) {
                                //$ada = true;
                                //$txt_tidakada = "Poliklinik belum dibuka";
                            } else if ($sekarang > $tutup) {
                                $ada = false;
                                $txt_tidakada = "Poliklinik sudah ditutup";
                            } else {
                                $ada = true;
                            }
                        }


                    ?>
                        <div style="margin:10px;" onclick="pilihPoli(<?php echo $item->ruangan_id; ?>)">

                            <div class="btn_poli_judul" style="font-size:30px;margin-top:80px;font-weight:bolde;color:white;">
                                <?php echo $item->ruangan_nama; ?>
                            </div>
                            <!-- <div class="btn_poli_desc">
                        <?php //echo empty($jadwal) ? "Tidak ada Jadwal" : ("Jam Buka Poli : " . $jadwal->jmabuka . (empty($txt_tidakada) ? "" : ("<br/>" . $txt_tidakada))); 
                        ?>
                    </div> -->
                        </div>
                    <?php

                    endforeach;

                    ?>
                </div>
            </div>
        </div>
        <div class="halaman4">
            <div style="margin-right:1250px;">
                <button type="button" class="btn " style="font-size:15px; padding:10px 20px; border-radius:5px;background-color:gray;" onclick="kembali(3)"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</button>
            </div>
            <div class="poliklinik">

                <div class="namainstalasi grid-container_div ">

                </div>
            </div>
            <div flex-container>
                <!-- <div><button type="button" onClick="beforepage()" style="font-size:30px; padding:20px 30px; border-radius:5px; margin-top:10px;background-color:#3E6F3E;">Kembali</button></div> -->
                <div><button type="button" class="btn" onClick="batalBooking1()" style="font-size:30px; padding:20px 30px; border-radius:5px; margin-top:10px;background-color:red;">Batal Booking</button></div>
            </div>
        </div>
        <div class="halaman2" style="margin: 50px auto 200px auto;width:fit-content;">
            <div style="margin-right:1250px;">
                <button type="button" class="btn " style="font-size:15px; padding:10px 20px; border-radius:5px;background-color:gray;" onclick="kembali(1)"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</button>
            </div>
            <div class="judul_form">Pilih Penjamin</div>
            <div class="bg">
                <img src="<?php echo Params::urlEkios() ?>logo-sariasih-07.png" id="logo-detail" alt="">
                <h3 style="margin-top:-40px; margin-bottom:40px;">Data Pasien</h3>
                <table class="theme-table">
                    <tr>
                        <td>No. RM</td>
                        <td>:</td>
                        <td id="no_rekam_medik"></td>
                        <td width="10%"></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>:</td>
                        <td id="tanggal_lahir"></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td id="nama_pasien"></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td id="alamat_pasien"></td>
                    </tr>
                </table>
            </div>
            <div class="content">
                <!-- <img src="<?php echo Params::urlEkios() ?>bg-pasien-detail.png " id="gambar"> -->
                <div class="theme">

                </div>
                <button type="button" class="btn btn-success btn-lg" style="font-size:35px;border-radius:10px;padding:25px;margin:20px 20px 20px auto " onclick="pilihCaraBayar('umum')">UMUM<?php //echo $carabayar[0]->carabayar_nama 
                                                                                                                                                                                                ?></button>
                <button type="button" class="btn btn-success btn-lg" style="font-size:35px;border-radius:10px;padding:25px;margin:20px auto 20px 20px" onclick="pilihCaraBayar('bpjs')">BPJS<?php //echo $carabayar[1]->carabayar_nama 
                                                                                                                                                                                            ?></button><br><br>
                <div>
                    <button type="button" class="btn" onClick="batalBooking()" style="font-size:30px; padding:20px 30px; border-radius:5px; margin-top:10px;background-color:red;">Batal Booking</button>
                </div>
            </div>
            <div class="halaman5">
                <div style="margin-right:1250px;">
                    <button type="button" class="btn " style="font-size:15px; padding:10px 20px; border-radius:5px;background-color:gray;" onclick="kembali(4)"><i class="glyphicon glyphicon-arrow-left"></i> Kembali</button>
                </div>
                <div class="grid-container2">
                    <div>
                        <p style="font-size:40px;">Tanggal Booking:</p>
                        <div style="margin-left: 110px;margin-top:20px;">
                            <?php
                            $model->tgljadwal = date('Y-m-d');
                            // $model->tglbuatjanji = date('Y-m-d H:i:s');

                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgljadwal',
                                'value' => date('Y-m-d'),
                                // 'flat'=>true,
                                // 'name' => 'datepicker-Inline',
                                // 'flat' => false,
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    // 'minDate' => '1d',
                                    //'onkeypress'=>"js:function(){hariBaru(this);}",
                                    'onSelect' => 'js:function(){AmbilHari();getjadwal();}',
                                    'sideBySide' => true,
                                    'showButtonPanel' => false,
                                    'showAnim' => 'slide',
                                    'minDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'class' => 'span3 tgl_jadwal',
                                    'placeholder' => 'Silakan pilih tanggal',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    <div>
                        <?php echo $form->hiddenField($model, "harijadwal", array('class' => 'hari')); //echo $form->textField($model, "pegawai_id", array('class' => 'hari'));
                        //echo $namadokter = PegawaiM::model()->findByPk($model->pegawai_id); 
                        ?>
                        <p style="font-size: 24px; text-align:left;">Jadwal <span class="namadokter"><?php echo !empty($namadokter->nama_pegawai);
                                                                                                        ?></span> <span class="hari"></span>,<span class="tanggal"></span></p>
                        <table width="100%" style="border: 1px solid black;" class="jadwal">
                            <thead>
                                <th>No</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Action</th>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="control-group">
                    <?php //echo $form->labelEx($modPPBuatJanjiPoli, 'harijadwal', array('class' => 'control-label')) 
                    ?>
                    <div class="controls">
                        <?php //echo $form->textField($modPPBuatJanjiPoli, 'harijadwal', array(
                        // 'placeholder' => 'Hari akan terisi otomatis',
                        // 'class' => 'span3',
                        // 'onkeypress' => "return $(this).focusNextInputField(event);",
                        // 'maxlength' => 20,
                        // 'readonly' => TRUE
                        //)); 
                        ?>
                    </div>
                    <div class="controls">
                        <?php //echo $form->textField($modPPBuatJanjiPoli, 'tgljadwal', array(
                        // 'placeholder' => 'Hari akan terisi otomatis',
                        // 'class' => 'span3',
                        // 'onkeypress' => "return $(this).focusNextInputField(event);",
                        // 'maxlength' => 20,
                        // 'readonly' => TRUE
                        // )); 
                        ?>
                    </div>
                </div>
            </div>

            <!-- <div>
            <div class="row">
                <div class="col-sm-12" style="padding-left: 20px; padding-right: 20px;">
                    <div id="ketersediaan-kamar-grid">
                        <table class="table table-striped table-condensed">
                            <tbody id="tab_jadwal_detail">
                                <?php //echo $this->renderPartial('_tabJadwalDokter', array('tabel' => $tabel), true); 
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" style="padding-left: 50px; padding-right: 50px;">
                    <?php
                    ?>
                </div>
            </div> -->
            <!-- <div class="col-sm-12 fw" style="padding-top: 20px;">
                <div style="float: left; width:70vw; padding-left: 10vw;">
                    <marquee direction="left" scrollamount="10" id="textrunning" style="font-size: 20px; color: green;">
                        <?php //echo $config->running_text_kamar; 
                        ?>
                    </marquee>

                </div>
                <p style="margin: 0; float: right;">
                    <?php //echo "<span style='font-family: oswald; font-size:1vw;'>" . strtoupper(hari()) . ",</span>"; 
                    ?>
                    <?php
                    // $tgl = date('d');
                    // $tahun = date('Y');
                    // echo "<span style='font-family:oswald;font-size:1vw;'>" . $tgl . " " . bulan() . " " . $tahun . "</span>";
                    ?>
                    <br/>
                    <span id="clock" style="display: inline-block; width: 200px; font-family: oswald; font-size: 1.75vw;"></span>
                </p>
            </div> -->
            <!-- </div> -->
            <div class="block-footer-antrian">
                <div id="footerAntrian">
                    <marquee direction="left" scrollamount="10" id="textrunning">
                        <?php echo $config->running_text_kamar; ?>
                    </marquee>
                </div>
                <div id="footerClock"></div>
            </div>
        </div>
        <iframe id="print_win" src="" style="display: none;"></iframe>
        <br>
    </div>
    <?php $this->endWidget(); ?>
</body>
<?php
// ===========================Dialog Verifikasi=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogJadwal',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Slot Jadwal Dokter',
        'autoOpen' => false,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
        'scroll' => false,
    ),
));
?>
<table id="slotjadwal" width="100%">

    <thead>
        <th>Nomor</th>
        <th>Jam Booking</th>
        <th>Status</th>
        <th>Action</th>
    </thead>

    <tbody>
        <!-- <tr>
            <td class="slot_jadwal"></td>
            <td>09.00</td>
            <td>Unedo</td>
            <td><button>Pilih</button></td>
        </tr> -->
    </tbody>
</table>
<!-- <iframe src="" id="frameVerifikasi" name="frameVerifikasi" style="width: 100%; height: 98%;"></iframe> -->
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

</html>
<?php $konfig = KonfigsystemK::model()->find(); ?>
<script type="text/javascript">
    var data_booking = {};
    var dataJanjipoli = []

    function kembaliKeHalamanAwal() {
        window.location.replace("<?php echo Yii::app()->createUrl('ekios/default/')  ?>")
    }

    function beforepage() {
        $(".halaman4").hide();
        $(".halaman3").show();
    }

    function create(waktuberbuka) {

        console.log(waktuberbuka);

        $('#waktumulai').val(waktuberbuka);
        $("#booking").submit();
        // $.ajax({
        //     type: 'POST',
        //     url: '<?php //echo Yii::app()->createUrl('/ekios/statusPenyiapanObat/Create') 
                        ?>',
        //     data: {
        //         data_booking
        //     },
        //     dataType: "json",
        //     success: function(data) {}});
    }
    // const formatDate = (date) => {
    //     let d = new Date(date);
    //     let month = (d.getMonth() + 1).toString();
    //     let day = d.getDate().toString();
    //     let year = d.getFullYear();
    //     if (month.length < 2) {
    //         month = '0' + month;
    //     }
    //     if (day.length < 2) {
    //         day = '0' + day;
    //     }
    //     return [year, month, day].join('-');
    // }
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

    function sasa(awal, tutup, tgl) {


        var pegawai_id = $("#pegawai_id").val();
        var tanggal = $(".tgl_jadwal").val();
        var ruangan_id = $("#ruangan_id").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/ekios/default/GetJadwal') ?>',
            data: {
                pegawai_id,
                ruangan_id,
                tanggal,
                awal,
                tutup,

            },
            dataType: "json",
            success: function(data) {

                $("#slotjadwal tbody").html("");
                $("#slotjadwal tbody").append(data.str)
            }
        });


    }

    function listKuota() {
        var pegawai_id = $("#PPBuatJanjiPoliT_pegawai_id").val();
        var tgl = $(".tgl_jadwal").val();
        var ruangan_id = $("#PPBuatJanjiPoliT_ruangan_id").val();

        console.log(pegawai_id, ruangan_id, tgl);


        if (pegawai_id == "" || ruangan_id == "" || tgl == "") {
            return false;
        }

        $(".panel_jadwal").empty();

        $.post("<?php echo $this->createUrl("getKuotaJanjiPoli") ?>", {
            pegawai_id: pegawai_id,
            ruangan_id: ruangan_id,
            tgl: tgl
        }, function(data) {

            if (data.is_penuh == 1) {
                myAlert(data.msg);
                $("#kuota_janji").val("");
                $("#sisa_kuota").val("");
                $("#PPBuatJanjiPoliT_pegawai_id").val(null);
                $(".panel_jadwal").html("");
                return false;
            }

            $("#kuota_janji").val(data.kuota);
            $("#sisa_kuota").val(data.sisa);
            $(".slot_jadwal").html(data.slot);
            $(".panel_jadwal").html(data.checkbox_jadwal);
            setCeklisJadwalDokter();
        }, 'json');
    }

    function pilihPoli(id) {
        console.log(id);
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/ekios/default/LoadDokter') ?>',
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == false) {
                    $(".nodata").show();
                    //alert("Data Anda tidak tersedia")
                } else {
                    console.log("data", data);
                    $(".namainstalasi").html('');
                    $.each(data, function(index, value) {
                        console.log("value", value);
                        $(".namainstalasi").append(`<div style="margin:10px;color:white;font-weight:bold;" onclick="$('#pegawai_id').val(${value.pegawai_id});$('#ruangan_id').val(${value.ruangan_id});getjadwal();AmbilHari();"><p style="margin-top:10px; padding:10px;font-size:22px"><u>` + value.ruangan_nama + `</u></p><div style="margin-top:10px;"><img style="height: 50px;  vertical-align: middle;" src="` + value.photopegawai + `"></div><div style="margin-top:15px;">` + value.nama_pegawai + `</div></div>`);
                        //$(".namainstalasi").append('<div class=poliklinik>'+value.nama_pegawai+'</div>');
                    })

                    $(".halaman4").show();
                    $(".halaman3").hide();
                }
                console.log("data pasien:", data);
            }
        });
        //renderPoli();
        //setKarcis();

        //resetDokter();
        //loadDokter();
        // $(".halaman4").show();
        // $(".halaman3").hide();
        // $(".form_ruangan_id").val(id);
        // console.log("result",result);
    }

    function getjadwal() {
        // console.log(pegawai_id, ruangan_id);
        var pegawai_id = $("#pegawai_id").val();
        var tanggal = $(".tgl_jadwal").val();
        var ruangan_id = $("#ruangan_id").val();
        data_booking.ruangan_id = ruangan_id;
        // $(".halaman5").show();
        // $(".halaman4").hide();
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/ekios/default/LoadJadwal') ?>',
            data: {
                pegawai_id,
                ruangan_id,
                tanggal
            },
            dataType: "json",
            success: function(data) {
                console.log("data", data)
                if (data.status == false) {
                    $(".nodata").show();
                    //alert("Data Anda tidak tersedia")
                } else {
                    // console.log("data---",data.returnVal);
                    $(".jadwal tbody").html('');
                    // $.each(data, function(index, value) {
                    $(".jadwal tbody").html(data.tabel);
                    //('<tr><td>'+(index+1)+'</td><td>Shift 1</td><td>'+value.jadwaldokter_mulai+'</td><td>'+value.jadwaldokter_tutup+'</td><td>PILIH</td></tr>');
                    // })
                    $(".namadokter").html(data.namadokter);
                    $(".halaman5").show();
                    $(".halaman4").hide();

                    loadbutajanjipoli(data, pegawai_id, ruangan_id, tanggal)
                }

                console.log("data pasien:", data);
            }
        });
    }

    function loadbutajanjipoli(datajadwal, pegawai_id, ruangan_id, tanggal) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/ekios/default/CariJadwal') ?>',
            data: {
                datajadwal,
                pegawai_id,
                ruangan_id,
                tanggal
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                if (data.length > 0) {
                    console.log('ok')
                    // dataJanjipoli=[];
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];

                        let jam = element.tgljadwal.split(' ')
                        dataJanjipoli[jam[0] + jam[1]] = element.nama_pasien
                    }
                    console.log('datajanji', dataJanjipoli)

                }
            }
        });
    }

    function AmbilHari() {
        var tanggal = $('.tgl_jadwal').val();
        var pegawai = $('#pegawai_id').val();
        console.log("tanggal", tanggal)

        $.post("<?php echo $this->createUrl('/ekios/default/GetHari'); ?>", {
                tanggal: tanggal
            },
            function(data) {
                $('#PPBuatJanjiPoliT_harijadwal').val(data.hari);
                $('#PPBuatJanjiPoliT_tgljadwal').val(tanggal);
                data_booking.tgljadwal = tanggal;
                $('.hari').html(data.hari);
                $('.tanggal').html(tanggal);
            }, "json");
    }

    function AmbilHari12() {
        //var tanggal = $('.tgl_jadwal').val();
        var pegawai = $('#pegawai_id').val();
        console.log("tanggal", pegawai)

        $.post("<?php echo $this->createUrl('/ekios/default/GetHari'); ?>", {
                tanggal: tanggal
            },
            function(data) {
                $('#PPBuatJanjiPoliT_harijadwal').val(data.hari);
                $('#PPBuatJanjiPoliT_tgljadwal').val(tanggal);
                data_booking.tgljadwal = tanggal;
                $('.hari').html(data.hari);
                $('.tanggal').html(tanggal);
            }, "json");
    }

    function renderPoli() {
        var id = $(".form_ruangan_id").val();
        $(".btn_poli").removeClass("pilih");
        $(".btn_poli#btn_poli_" + id).addClass("pilih");
    }

    function setKarcis() {
        var kelaspelayanan_id = <?php echo Params::KELASPELAYANAN_ID_TANPA_KELAS; ?>;
        var ruangan_id = $(".form_ruangan_id").val();
        var penjamin_id = <?php echo Params::PENJAMIN_ID_UMUM; ?>;
        var pasien_id = $("#<?php echo CHtml::activeId($modPasien, "pasien_id"); ?>").val();

        //alert(kelaspelayanan_id);

        // console.log(no_rekam_medik);

        if (kelaspelayanan_id !== "" && ruangan_id !== "" && penjamin_id !== "") {
            $("#form-karcis").addClass("animation-loading");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('SetKarcis'); ?>',
                data: {
                    kelaspelayanan_id: kelaspelayanan_id,
                    ruangan_id: ruangan_id,
                    penjamin_id: penjamin_id,
                    pasien_id: pasien_id,
                    no_rekam_medik: null,
                }, //
                dataType: "json",
                success: function(data) {
                    $("#form-karcis").html(data.listKarcis);
                    $("#form-karcis").removeClass("animation-loading");
                    $("form").find('.integer-decimal').each(function() {
                        $(this).val(formatThousandDecimal($(this).val()));
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            $("#content-karcis-html").html("");
        }

    }

    function pilihCaraBayar(tipe) {
        if (tipe == "umum") {
            $("#carabayar_id").val(<?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>);
            $("#penjamin_id").val(398);
            data_booking.penjami_id = '<?php echo Params::CARABAYAR_ID_MEMBAYAR; ?>'
            $(".halaman3").show();
            $(".halaman2").hide();
            console.log("data", data_booking)
        } else if (tipe == "bpjs") {
            $("#carabayar_id").val(<?php echo Params::CARABAYAR_ID_BPJS; ?>);
            $("#penjamin_id").val(574);
            data_booking.penjami_id = '<?php echo Params::CARABAYAR_ID_BPJS; ?>'
            $(".halaman3").show();
            $(".halaman2").hide();
            console.log("data", data_booking)
        } else if (tipe == "asuransi") {
            // $(".form_carabayar_id").val(<?php echo Params::CARABAYAR_ID_ASURANSI; ?>);
        }
    }

    function batalBooking() {
        $(".halaman2").hide();
        $(".halaman1").show();

    }

    function batalBooking1() {
        $(".halaman4").hide();
        $(".halaman1").show();

    }

    function hideawal() {
        $(".nodata").hide();
        $(".halaman2").hide();
        $(".halaman3").hide();
        $(".halaman4").hide();
        $(".halaman5").hide();
    }
    hideawal();
    var socket;
    var isRefresh = false;
    var refreshInterval = 10000;
    $(document).ready(function() {
        clockUpdate();
        setInterval(clockUpdate, 1000);
        setInterval(function() {
            if (!isRefresh) {
                isRefresh = true;
                console.log("Next Hidden", $("#ketersediaan-kamar-grid .next").hasClass("hidden"));
                if (!$("#ketersediaan-kamar-grid .next").hasClass("hidden")) {
                    console.log("Lanjut");
                    $("#ketersediaan-kamar-grid .next a").click();
                } else {
                    console.log("Kembali ke Halaman 1");
                    $("#ketersediaan-kamar-grid .halaman_satu a").click();
                }
                //$.fn.yiiGridView.update('ketersediaan-kamar-grid');
            }
        }, refreshInterval);
        $(function() {
            // let interval = setInterval(function() {
            let a = 100 * $("#ketersediaan-kamar-grid").scrollTop() / ($("#ketersediaan-kamar-grid").prop("scrollHeight") - $("#ketersediaan-kamar-grid").height());
            let b = $("#ketersediaan-kamar-grid").scrollTop();
            let scroller = 100;
            if (a != 100) {
                $("#ketersediaan-kamar-grid").scrollTop(b + scroller);
            } else {
                $("#ketersediaan-kamar-grid").scrollTop(0);
            }
            // }, 5000);
        });
    })

    function carino() {
        var id = $("#input_no_kartu").val();
        console.log(id);

        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createUrl('/ekios/default/ValidasiUtama') ?>',
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == false) {
                    Notiflix.Report.Failure("Gagal", "Data Anda tidak ditemukan ");
                    //$(".nodata").show();
                    //alert("Data Anda tidak tersedia")
                } else {
                    data_booking.data_pasien = data.pasien_id

                    $("#pasien_id").val(data.pasien_id);
                    $("#nama_pasien").html(data.nama_pasien);
                    $("#alamat_pasien").html(data.alamat_pasien);
                    $("#jeniskelamin").html(data.jeniskelamin);
                    $("#tanggal_lahir").html(data.tanggal_lahir);
                    $("#umur").html(data.umur);
                    $("#no_rekam_medik").html(data.no_rekam_medik);
                    $("#no_mobile_pasien").html(data.no_mobile_pasien);
                    $("#agama").html(data.agama);

                    $("#pasien_id").val(data.pasien_id);
                    $(".halaman2").show();
                    $(".halaman1").hide();
                }
                console.log("data pasien:", data_booking);
            }
        });


    }

    function clockUpdate() {
        var date = new Date();
        $('.clock').css({
            'color': '#fff',
            'text-shadow': '0 0 6px #ff0'
        });

        function addZero(x) {
            if (x < 10) {
                return x = '0' + x;
            } else {
                return x;
            }
        }

        function twelveHour(x) {
            if (x > 12) {
                return x = x - 12;
            } else if (x == 0) {
                return x = 12;
            } else {
                return x;
            }
        }
        var h = addZero(twelveHour(date.getHours()));
        var m = addZero(date.getMinutes());
        var s = addZero(date.getSeconds());
        $('.clock').text(h + ':' + m + ':' + s);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }; // add zero in front of numbers < 10
        return i;
    }

    function nextTabLog(elem) {
        //var inisial = $('#inisial').val();
        var norekam = $('#input_no_kartu').val();
        //var tgllahir = $('#picker').val();
        console.log(norekam);
        var statusaksi = false;


        if (norekam != "") {
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('/ekios/Default/ValidasiUtama') ?>',
                data: {
                    norekam: norekam,
                    tgllahir: tgllahir
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    // alert(data);
                    if (data.status != false) {
                        console.log("berhasil");
                        console.log(data.tempatbekerja_nama);
                        $("#no_rekam_medik").val(data.no_rekam_medik);
                        $("#BuatjanjipoliT_pasien_id").val(data.pasien_id);
                        $("#BuatjanjipoliT_rv_nama_pasien").val(data.nama_pasien);
                        $("#BuatjanjipoliT_pasien_id").val(data.pasien_id);
                        $("#BuatjanjipoliT_rv_tgl_lahir").val(data.tanggal_lahir);
                        $("#BuatjanjipoliT_tempatbekerja_nama").val(data.tempatbekerja_nama);
                        $("#BuatjanjipoliT_tempatbekerja_id").val(data.tempatbekerja_id);
                        $("#usia").val(data.umur);
                        $("#BuatjanjipoliT_rv_no_telepon").val(data.no_mobile_pasien);
                        $("#BuatjanjipoliT_rv_no_telepon_darurat").val(data.no_telepon_pasien);
                        $("#BuatjanjipoliT_rv_email").val(data.alamatemail);
                        $("#BuatjanjipoliT_rv_propinsi_id").val(data.propinsi_id).change();
                        $("#BuatjanjipoliT_rv_agama").val(data.agama);
                        $("#BuatjanjipoliT_rv_alamat").val(data.alamat_pasien);
                        $("#BuatjanjipoliT_rv_golongandarah").val(data.golongandarah);
                        // $("#BuatjanjipoliT_jambooking").val(jambooking);
                        setTimeout(function() {
                            $("#BuatjanjipoliT_rv_kabupaten_id").val(data.kabupaten_id).change();
                        }, 1000);
                        setTimeout(function() {
                            $("#BuatjanjipoliT_rv_kecamatan_id").val(data.kecamatan_id).change();
                        }, 2000);
                        setTimeout(function() {
                            $("#BuatjanjipoliT_rv_kelurahan_id").val(data.kelurahan_id).change();
                        }, 3000);

                        if (data.jeniskelamin == "LAKI-LAKI") {
                            $('#PPPasienM_jeniskelamin_0').attr("checked", 'checked');
                        } else if (data.jeniskelamin == "PEREMPUAN") {
                            $('#PPPasienM_jeniskelamin_1').attr("checked", 'checked');
                        }
                        $("textarea#PPPasienM_alamat_pasien").val(data.alamat_pasien);

                        if (data.jeniskelamin == "LAKI-LAKI") {
                            $('#BuatjanjipoliT_rv_jeniskelamin_0').attr("checked", 'checked');
                        } else if (data.jeniskelamin == "PEREMPUAN") {
                            $('#BuatjanjipoliT_rv_jeniskelamin_1').attr("checked", 'checked');
                        }
                        //  $("#BuatjanjipoliT_rv_propinsi_id option[value='"+data.propinsi_id+"']").prop('selected', true);
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled');
                        //nextTab($active);

                    } else {
                        alert("Data Yang Anda Cari Belum Terdaftar ");
                        return false;
                    }
                }
            });
        } else {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            //nextTab($active);
        }

        console.log(statusaksi);

    }
    <?php
    function hari()
    {
        $hari = date('l');
        /* $new = date('l, F d, Y', strtotime($Today)); */
        if ($hari == "Sunday") {
            return "Minggu";
        } elseif ($hari == "Monday") {
            return "Senin";
        } elseif ($hari == "Tuesday") {
            return "Selasa";
        } elseif ($hari == "Wednesday") {
            return "Rabu";
        } elseif ($hari == "Thursday") {
            return "Kamis";
        } elseif ($hari == "Friday") {
            return "Jum'at";
        } elseif ($hari == "Saturday") {
            return "Sabtu";
        }
    }

    function bulan()
    {
        $bulan = date('F');
        if ($bulan == "January") {
            return " Januari ";
        } elseif ($bulan == "February") {
            return " Februari ";
        } elseif ($bulan == "March") {
            return " Maret ";
        } elseif ($bulan == "April") {
            return " April ";
        } elseif ($bulan == "May") {
            return " Mei ";
        } elseif ($bulan == "June") {
            return " Juni ";
        } elseif ($bulan == "July") {
            return " Juli ";
        } elseif ($bulan == "August") {
            return " Agustus ";
        } elseif ($bulan == "September") {
            return " September ";
        } elseif ($bulan == "October") {
            return " Oktober ";
        } elseif ($bulan == "November") {
            return " November ";
        } elseif ($bulan == "December") {
            return " Desember ";
        }
    }

    ?>

    function printKarcis() {
        window.open('<?php echo $this->createUrl('/ekios/default/printKarcis', array('buatjanjipoli_id' => (isset($_GET['buatjanjipoli_id'])) ? $_GET['buatjanjipoli_id'] : "")); ?>', 'printwin', 'left=100,top=100,width=480,height=640');
    }

    function kembali(id) {
        var id = id;
        if (id == 1) {
            $('.halaman2').hide();
            $('.halaman1').show()
        } else if (id == 2) {
            $('.halaman3').hide();
            $('.halaman2').show()
        } else if (id == 3) {
            $('.halaman4').hide();
            $('.halaman3').show()
        } else if (id == 4) {
            $('.halaman5').hide();
            $('.halaman4').show()
        }
    }

    function angkabulan(bln) {
        switch (bln) {
            case 'Jan':
                return '1';
                break;
            case 'Feb':
                return '2';
                break;
            case 'Mar':
                return '3';
                break;
            case 'Apr':
                return '4';
                break;
            case 'Mei':
                return '5';
                break;
            case 'Jun':
                return '6';
                break;
            case 'Jul':
                return '7';
                break;
            case 'Agus':
                return '8';
                break;
            case 'Sep':
                return '9';
                break;
            case 'Okt':
                return '10';
                break;
            case 'Nop':
                return '11';
                break;
            case 'Des':
                return '12';
                break;
            default:
                return '01';
                break;
        }
    }
    // $("#datepicker").datepicker();
</script>