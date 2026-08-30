<?php

/**
 * view ini digunakan untuk menampilkan no antrian tiap polik, dengan maksimum 6 data
 * 
 * @author Yusuf Putra Anugrah<yusufputra@.com>
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://.com>
 * @link    <http://piindonesia.co.id>
 */
?>
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
<style>
    body {
        /* background:
            radial-gradient(black 15%, transparent 16%) 0 0,
            radial-gradient(black 15%, transparent 16%) 8px 8px,
            radial-gradient(rgba(255, 255, 255, .1) 15%, transparent 20%) 0 1px,
            radial-gradient(rgba(255, 255, 255, .1) 15%, transparent 20%) 8px 9px;
        background-color: #282828;
        background-size: 16px 16px; */
        background: url(<?php echo Yii::app()->request->baseUrl; ?>/images/login_mixed_new.jpg) center center no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }

    .content {
        margin: 0;
    }

    /*    div{
            font-size: 20px;
            font-weight:bold;
            letter-spacing:2px;
            color: #fff;
            text-shadow:
                -1px -1px 0 #000,  
                 1px -1px 0 #000,
                 -1px 1px 0 #000,
                  1px 1px 0 #000;
        }*/
    thead th {
        text-align: center;
        padding-right: 20px;
    }

    .antrian {
        margin-left: 5px;
    }

    .judul {
        text-align: center;
        font-size: 35px;
        font-weight: bold;
        padding-bottom: 0;
    }

    .ruangan {
        background-color: #2b2e3b;
        height: 150px;
        width: 100%;
    }

    .ruangan1 {
        background-color: #2b2e3b;
        height: 30px;
        width: 100%;
        margin-top: 5px;
    }

    .ruangan3 {
        background-color: #2b2e3b;
        height: 75px;
        width: 100%;
        margin-top: 5px;
    }

    .ruangan2 {
        background-color: none;
        height: 50px;
        width: 100%;
        margin-top: 5px;
    }

    .ruangan {
        background-color: #2b2e3b;
        height: 50px;
        width: 100%;
    }

    /*    .dokter{
        font-size: 70%;
        color: #00FF00;
        border: 1px solid #fff;
        border-bottom: none;
        border-top:none;
    }*/
    .no-antrian,
    .pasien-deskripsi,
    .ruangan {
        color: #fff;
        text-align: center;
        font-size: 5vw;
        font-weight: bold;
    }

    .no-antrian {
        font-size: 3.8vw;
        line-height: 6vw;
    }

    .pasien-deskripsi,
    ruangan {
        /*font-size: 70%;*/
        width: 100%;
        font-size: 1.2vw;
        -moz-border-radius: 0 0 5px 5px;
        -webkit-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
        border-top: none;
        background-color: #2b2e3b;
        color: #fff;
        font-family: oswald;
        font-weight: bold;
        /*height: 20px;*/
    }

    .pasien-deskripsi_farmasi {
        /*font-size: 70%;*/
        width: 100%;
        font-size: 1.5vw;
        -moz-border-radius: 0 0 5px 5px;
        -webkit-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
        border-top: none;
        background-color: #2b2e3b;
        color: #fff;
        font-family: oswald;
        font-weight: bold;
        /*height: 20px;*/
    }

    .daftar-judul {
        color: #fff;
        text-align: center;
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
    }

    .daftar-isi td,
    th {
        color: #fff;
        background-color: rgba(0, 0, 0, 0.8) !important;
        font-size: 11px;
        text-align: left;
        font-weight: bold;
    }

    .block-footer-antrian {
        /* position: absolute;
        bottom: 0;
        width: 100%;
        background-color: #fff; */
        position: fixed;
        bottom: 0;
        width: 100%;
    }

    /*    #footerClock {
        position: absolute;
        width: 400px;
        top: 40px;
        right: 0;
    }*/
    /*    #footerClock #clock {
        background: none;
        color: black;
        font-size: 1.6vw;
    }*/
    .rheader {}

    #textrunning {
        color: #007;
        text-shadow: none;
        height: 40px;
        bottom: 0;
        right: 0;
        color: #fff;
        text-shadow: none;
        font-weight: bold;
        font-size: 30px;
        padding: 0;
        font-family: oswald;
        padding-left: 6px;
        padding-right: 6px;
        background-color: #2b2e3b;
    }

    #clock {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 300px;
        padding: 0 10px;
        color: #007;
        text-shadow: none;
        font-weight: bold;
        font-size: 30px;
        text-align: center;
        color: #fff;
        height: 40px;
        font-family: oswald;
        background-color: #3753a4;
    }

    .content {
        margin-left: 0 !important;
    }

    #pantrian {
        background-color: #2b2e3b;
        height: 125px;
        width: 25%;
    }

    #pantrian2 {
        background-color: #fff;
        height: 125px;
    }

    #pantriantengah {
        background-color: #3a3c4a;
        height: 130px;
        width: 100%;
    }

    #pantrianbawah {
        background-color: #2b2e3b;
        height: 150px;
        width: 100%;
    }

    #layar {
        background-color: #2b2e3b;
        border-color: #f5f4f7;
    }

    #layarbor {
        background-color: #3a3c4a;
        height: 160px;
        width: 100%;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    #vimi {
        background-color: #3a3c4a;
        color: #fff;
        font-family: oswald;
        font-weight: lighter;
        font-size: 1vw;
        border-bottom-left-radius: 10px;
    }

    #vimi2 {
        color: #fff;
        font-family: oswald;
        font-weight: bold;
        font-size: 2vw;
    }

    #vimi3 {
        background-color: #377fb7;
        color: #fff;
        font-family: oswald;
        font-weight: lighter;
        font-size: 1vw;
        text-transform: uppercase;
    }

    #vimi4 {
        color: #fff;
        font-family: oswald;
        font-weight: lighter;
        font-size: 8px;
        text-transform: uppercase;
    }

    #vimi5 {
        color: #fff;
        font-family: oswald;
        font-weight: lighter;
        font-size: 1vw;
    }

    #kotak1 {
        margin-top: 0;
    }

    #pantrianfarmasitengah {
        background-color: #3a3c4a;
        height: 120px;
        width: 100%;
    }
</style>
<?php echo CHtml::hiddenField('jamsekarang', "", array('readonly' => true, 'class' => 'realtime')); ?>
<div class="row">
    <div class="col-sm-12" style="padding-right: 0;padding-left: 0;">
        <div class="col-sm-12 statistik" id="kotak1" style="background-color:none; height:715px;padding-left: 0; padding-right: 0;">
            <div class="col-sm-12" style="padding-left: 0; padding-right: 0;">
                <div style="padding-left: 0; padding-right: 0; font-size:2vw; height:120px; color:white; font-family:oswald; font-weight: bold;" class="col-xs-4 ruangan2" id="">
                    <div class="col-sm-12"> <img style="height:95px; margin-top: 0;" src="<?php echo Yii::app()->request->baseUrl . '/images/antrian/logo-rspmc-transparanwhite.png' ?>" id="logo" /></div>
                    <div class="col-sm-12" id="vimi3" style="height:20%;">
                        MERAWAT DENGAN KASIH SAYANG
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <?php $i = "apotek"; ?>
            <div class="col-xs-6 " style=" padding-left: 0; padding-right: 0;">
                <div class="row_fluid" style="margin-top: 0;">
                    <div class="col-xs-6 col-nopadding panel_antrian_racikan" style="padding-left: 2px; padding-right: 2px;">
                        <div style="font-size:3vw; color:white; font-family:oswald; font-weight: bold;" class="col-md-12 ruangan3" id="ruangan_farmasi_<?php echo $i; ?>">
                            RACIKAN
                        </div>
                        <div class="col-md-12 no-antrian_farmasi" id="pantrianfarmasitengah" align="center" style=" color:white; font-family:oswald; font-weight: bold; font-size:55pt;">
                            0-000
                        </div>
                        <div class="col-md-12 noresep pasien-deskripsi_farmasi" id="pasien-deskripsi_<?php echo $i; ?>">
                            <span> NAMA PASIEN<br>NO RESEP </span>
                        </div>
                    </div>
                    <div class="col-xs-6 col-nopadding panel_antrian_nonracikan" style="padding-left:2px; padding-right: 2px;">
                        <div style="font-size:3vw; color:white; font-family:oswald; font-weight: bold;" class="col-md-12 ruangan3" id="ruangan_farmasi_<?php echo $i; ?>">
                            NON RACIKAN
                        </div>
                        <div class="col-md-12 no-antrian_farmasi" id="pantrianfarmasitengah" align="center" style=" color:white; font-family:oswald; font-weight: bold; font-size:55pt;">
                            0-000
                        </div>
                        <div class="col-md-12 noresep pasien-deskripsi_farmasi" id="pasien-deskripsi_<?php echo $i; ?>">
                            <span> NAMA PASIEN<br>NO RESEP </span>
                        </div>
                    </div>
                </div>
                <div class="row_fluid" style="margin-top: 15px;">
                    <div class="col-md-6 col-nopadding ruangantable rheader tab_racikan" align="center" style="font-size:3vw;   color:white; font-family:oswald; font-weight: bold; padding-left:2px; padding-right: 2px;">
                        <div style="padding-bottom:2%"></div>
                        <table id="tab_farmasi" class="table table-bordered" style="color:black">
                            <thead>
                                <tr>
                                    <th>NO. ANTRIAN</th>
                                    <th>NO. RESEP</th>
                                    <th>NO. REKAM MEDIK</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <br>
                    </div>
                    <div class="col-md-6 col-nopadding ruangantable rheader tab_nonracikan" align="center" style="font-size:3vw;   color:white; font-family:oswald; font-weight: bold; padding-left:2px; padding-right: 2px;">
                        <div style="padding-bottom:2%"></div>
                        <table id="tab_farmasi" class="table table-bordered" style="color:black">
                            <thead>
                                <tr>
                                    <th>NO. ANTRIAN</th>
                                    <th>NO. RESEP</th>
                                    <th>NO. REKAM MEDIK</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 " style=" padding-left: 0; padding-right: 0;">
                <?php
                $col = array("#0c0", "#00a", "#ea0");
                $cnt = 0;
                if (!empty($modRuangans)) {
                    $total = count((array)$modRuangans);
                    foreach ($modRuangans as $i => $ruangan) {
                ?>
                        <div class="col-xs-4" style="padding-left: 0; padding-right: 0;">
                            <div id="ruangan_<?php echo isset($ruangan->ruangan_id) ? $ruangan->ruangan_id : ''; ?>" class="antrian">
                                <div style="font-size:1.2vw; color:white; font-family:oswald; font-weight: bold;" class="col-xs-4 ruangan1 loket-nama" id="pasien-deskripsi_<?php echo $i; ?>">
                                    <div class="col-sm-12 pasien-deskripsi">---</div>
                                </div>
                                <div class="col-xs-4 " id="pantriantengah" align="center" style="height:85px; background-color:#18476d; color:white; font-family:oswald; font-weight: bold;">
                                    <div class="col-sm-12 no-antrian" style="padding-left: 0; padding-right: 0;"><?php echo isset($ruangan->ruangan->ruangan_singkatan) ? $ruangan->ruangan->ruangan_singkatan : ''; ?>-000</div>
                                </div>
                                <div class="col-xs-4 ruangan" id="ruangan_nama_<?php echo $i; ?>">
                                    <div class="col-sm-12" style="font-size:0.9vw;padding-left: 0; padding-right: 0;"><?php echo isset($ruangan->ruangan->ruangan_nama) ? $ruangan->ruangan->ruangan_nama : ''; ?></div>
                                    <div class="col-sm-12 dokter" style="font-size:0.9vw;padding-left: 0; padding-right: 0;"><?php echo '---'; ?></div>
                                </div>
                                <?php echo $this->renderPartial('_formKunjungan', array('model' => $model)); ?>
                            </div>
                        </div>
                        <?php
                        $cnt++;
                    }
                    if ($total < 6) {
                        $count = 9 - $total;
                        if ($count > 0) {
                            for ($ii = 1; $ii <= $count; $ii++) {
                        ?>
                                <div class="col-xs-4" style="padding-left: 0; padding-right: 0;">
                                    <div class="antrian">
                                        <div style="font-size:2vw; color:white; font-family:oswald; font-weight: bold;" class="col-xs-4 ruangan1 loket-nama" id="pasien-deskripsi_<?php echo $i; ?>">
                                        </div>
                                        <div class="col-xs-4 " id="pantriantengah" align="center" style="height: 85px; background-color: #3a3c4a; color:white; font-family:oswald; font-weight: bold;">
                                            <div class="col-sm-12 no-antrian" style="padding-top:1%"> <img style=" max-width: 100vw; height: 70px; margin-top: 0;" src="<?php echo Params::urlProfilRSDirectory() . $konfig->logolayarantrian; ?>" id="" /></div>
                                        </div>
                                        <div class="col-xs-4 ruangan">
                                        </div>
                                        <?php echo $this->renderPartial('_formKunjungan', array('model' => $model)); ?>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                <?php
                    }
                }
                ?>
            </div>
            <div class="col-sm-12 statistik" id="pantrian2" style="position: absolute; bottom: 0;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px; padding-right: 0;" hidden>
                <div class="col-sm-5">
                    <img style="width:65%; margin-top: 0; " src="<?php echo Yii::app()->request->baseUrl . '/images/antrian/RS_BALIMED.png' ?>" id="logo" />
                </div>
                <div class="col-md-2" style="height:100%;background-color:#0d8541; padding-left: 0; padding-right: 0;text-align:center;">
                    <div style="position: relative">
                        <!--<img style="width:70%; margin-top: 0;" src="<?php //echo Yii::app()->request->baseUrl . '/images/antrian/logo-kars-light.png' 
                                                                            ?>" id="logo"/>-->
                    </div>
                </div>
                <div class="col-md-5" style="height:100%;background-color:#18476d; padding-left: 0; padding-right: 0; border-bottom-right-radius: 10px;">
                    <div style="position:relative">
                        <div class="col-sm-12" id="vimi5" style="font-weight: bold; padding-top:2%">
                            MOTO BALIMED HOSPITAL
                        </div>
                        <div class="col-sm-12" id="vimi5">
                            Melayani dengan Integritas dan Kenyamanan
                        </div>
                        <div class="col-sm-12" id="vimi5">
                            <icon class="entypo-network"></icon>marketing@balimedhospital.co.id
                            <br>
                            <icon class="entypo-phone"></icon>+62 361 3117311<br>
                            <icon class="entypo-phone"></icon> +62 361 484748
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $profil = ProfilrumahsakitM::model()->find(); ?>
<div class="block-footer-antrian">
    <div id="footerAntrian">
        <marquee direction="left" scrollamount="10" id="textrunning">
            <?php echo $profil->nama_rumahsakit . " - " . $profil->motto; ?>
        </marquee>
    </div>
    <div id="footerClock">
        <div id="clock"></div>
    </div>
</div>
<?php echo $this->renderPartial('_jsFunctions', array('model' => $model, 'modRuangans' => $modRuangans, 'modLayar' => $modLayar, 'konfig' => $konfig)); ?>
<?php echo $this->renderPartial('_jsFunctionsFarmasi', array('model' => $model, 'modelantrian_id' => $modelantrian_id, 'modRuangans' => $modRuangans, 'modLayar' => $modLayar, 'konfig' => $konfig)); ?>
<iframe id="suarapanggilan" src="" style="display:none;"></iframe>
<script>
    var day = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    var mon = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

    function updateClock() {
        var currentTime = new Date();
        var currentHours = currentTime.getHours();
        var currentMinutes = currentTime.getMinutes();
        var currentSeconds = currentTime.getSeconds();
        var currentDay = currentTime.getDay();
        var currentDate = currentTime.getDate();
        var currentMonth = currentTime.getMonth();
        var currentYear = currentTime.getFullYear();
        // Pad the minutes and seconds with leading zeros, if required
        currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
        currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
        // Choose either "AM" or "PM" as appropriate
        var timeOfDay = (currentHours < 12) ? "AM" : "PM";
        // Convert the hours component to 12-hour format if needed
        currentHours = (currentHours > 12) ? currentHours - 12 : currentHours;
        // Convert an hours component of "0" to "12"
        currentHours = (currentHours == 0) ? 12 : currentHours;
        // Compose the string for display
        var currentTimeString = currentDate + " " + mon[currentMonth] + " " + currentYear + " " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
        $("#clock").html(currentTimeString);
    }
    $(document).ready(function() {
        setInterval('updateClock()', 1000);
    });
</script>