<!DOCTYPE html>
<html lang="en" dir="ltr">

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
            /* background: url("<?php //echo Yii::app()->request->baseUrl; ?>/images/antrian/dokter.jpg") center center no-repeat; */
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
        .fw{
            color: #fff !important;
        }
        #header {
            display: flex;
            align-items: center;
            height: 100px;
            width: calc(100% - 15px);
            margin: 8px 0 8px;
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
            padding-top: 15px;
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
            margin-bottom: 17px;
            font-size: 1.4rem;
            font-weight: bold;
            text-transform: uppercase;
        }
        #tab-text2 {
            color: #fff !important;
            display: block;
            padding-bottom: 10px;
            padding-top: 18px;
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
            padding: 0 20px;
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
    </style>
</head>

<body>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'antrian-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
    ));
    ?>
    <div class="background"></div>
    <!--<div id="headerAntrian">
                <div id="refresh" style="float:right;">-->
 <?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());  ?>
    <div class="bases">
        <div id="header" class="row">
            <div class="col-sm-3" style="padding-left: 30px;">
            <div class="logo_profil">
                <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; margin-top: -38px; max-width: 98px; width:98px;" class='image_report'/>
                </div>
            </div>
            
            <div class="col-sm-6"><br>
                <div style=" text-align: center;">
                    <!-- <span class="page-title">
                        <?php //echo strtoupper($data->nama_rumahsakit); ?>
                    </span> -->
                    <span id="tab-text">
                        ANTRIAN PENGAMBILAN RESEP<br/>
                        <?php echo strtoupper($data->nama_rumahsakit); ?>
                    </span>
                    <!-- <span id="tab-tgl-text">
                        <i><?php //echo date('d M Y') . ' s/d ' . date('d M Y', strtotime('+6 days')) ?></i>
                    </span> -->
            </div>
            </div>
            <div class="col-sm-3" style="margin-top: -25px; text-align: right; padding-right: 5px;">
                <!-- <div><?php //echo CHtml::image(Yii::app()->getBaseUrl('webroot')."/images/dokter/link_1.png", 'RSSACPT', array(
                //     'style'=>'height: 20px;'
                // )); ?></div>
                <div><?php //echo CHtml::image(Yii::app()->getBaseUrl('webroot')."/images/dokter/link_2.png", 'RSSACPT', array(
                //     'style'=>'height: 20px;'
                // )); ?></div>
                <div><?php //echo CHtml::image(Yii::app()->getBaseUrl('webroot')."/images/dokter/link_3.png", 'RSSACPT', array(
                //     'style'=>'height: 20px;'
                // )); ?></div>
                <div><?php //echo CHtml::image(Yii::app()->getBaseUrl('webroot')."/images/dokter/link_4.png", 'RSSACPT', array(
                //     'style'=>'height: 20px;'
                // )); ?></div> -->

<p style="margin: 0; float: right;">
                    <?php echo "<span style='font-family: oswald; font-size:1.25vw;'>" . strtoupper(hari()) . ",</span>"; ?>
                    <?php
                    $tgl = date('d');
                    $tahun = date('Y');
                    echo "<span style='font-family:oswald;font-size:1.25vw;'>" . $tgl . " " . bulan() . " " . $tahun . "</span>";
                    ?>
                    <br/>
                    <span id="clock" style="display: inline-block; width: 200px; font-family: oswald; font-size: 1.75vw;"></span>
                </p>
            </div>
            <!-- <div class="col-sm-3" style="padding-right: 30px;">
                <p style="margin: 0 15px 0 0; float: right;"> -->
                    <?php //echo "<span style='font-family: oswald; font-size:1.75vw;'>" . strtoupper(hari()) . ",</span>"; ?>
                    <?php
                    // $tgl = date('d');
                    // $tahun = date('Y');
                    // echo "<span style='font-family:oswald;font-size:1.75vw;'>" . $tgl . " " . bulan() . " " . $tahun . "</span>";
                    ?>
                    <!-- <span id="clock" style="display: inline-block; width: 200px; margin-top: 15px; font-family: oswald; font-size: 1.75vw;"></span> -->
                <!-- </p>
            </div> -->
        </div>
        
        <div>
            <div class="row">
                <div class="col-sm-12" style="padding-left: 20px; padding-right: 20px;">
               
                    <div id="ketersediaan-kamar-grid">
                        
                        <table class="table table-striped table-condensed">
                            
                            <tbody id="tab_jadwal_detail">
                                <?php echo $this->renderPartial('_tabJadwalDokter', array('tabel' => $tabel), true); ?>
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
            </div>
            <!-- <div class="col-sm-12 fw" style="padding-top: 20px;">
                <div style="float: left; width:70vw; padding-left: 10vw;">
                    <marquee direction="left" scrollamount="10" id="textrunning" style="font-size: 20px; color: green;">
                        <?php //echo $config->running_text_kamar; ?>
                    </marquee>

                </div>
                <p style="margin: 0; float: right;">
                    <?php //echo "<span style='font-family: oswald; font-size:1vw;'>" . strtoupper(hari()) . ",</span>"; ?>
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

</html>
<?php $konfig = KonfigsystemK::model()->find(); ?>
<script type="text/javascript">
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
            let interval = setInterval(function() {
                let a = 100 * $("#ketersediaan-kamar-grid").scrollTop() / ($("#ketersediaan-kamar-grid").prop("scrollHeight") - $("#ketersediaan-kamar-grid").height());
                let b = $("#ketersediaan-kamar-grid").scrollTop();
                let scroller = 100;
                if (a != 100) {
                    $("#ketersediaan-kamar-grid").scrollTop(b + scroller);
                } else {
                    $("#ketersediaan-kamar-grid").scrollTop(0);
                }
            }, 5000);
        });
    })

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
</script>