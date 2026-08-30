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
<?php
$config = KonfigsystemK::model()->find();
?>
<style>
    body {
        /* background:
            radial-gradient(black 15%, transparent 16%) 0 0,
            radial-gradient(black 15%, transparent 16%) 8px 8px,
            radial-gradient(rgba(255, 255, 255, .1) 15%, transparent 20%) 0 1px,
            radial-gradient(rgba(255, 255, 255, .1) 15%, transparent 20%) 8px 9px;
        background-color: #282828;
        background-size: 16px 16px; */
        background: url(<?php echo Yii::app()->request->baseUrl; ?>/images/antrianpoliklinik/antrian_poliklinik_BG-002-polos.jpg) center center no-repeat;
        /* background: url(<?php //echo Yii::app()->request->baseUrl; 
                            ?>/images/login_mixed_new.jpg) center center no-repeat; */
        background-size: cover;
        background-attachment: fixed;
    }

    .background2 {
        position: fixed;
        left: 0;
        top: 0;
        z-index: -100;
        width: 100vw;
        height: 110vh;
        background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/antrianpoliklinik/antrian_poliklinik_BG-02.jpg") center center no-repeat;
        background-size: cover;
    }

    .content {
        margin: 0;
    }

    .row {
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
        margin: 0 5px;
    }

    .judul {
        text-align: center;
        font-size: 35px;
        font-weight: bold;
        padding-bottom: 0;
    }

    .ruangan {
        width: 100%;
        height: 4.8vw;
        padding: 10px;
        background-color: #2b2e3b;
    }

    .ruangan1 {
        background-color: #2b2e3b;
        height: 2.75vw;
        width: 100%;
        margin-top: 10px;
    }

    .col-xs-4:nth-child(-n+3) .ruangan1 {
        margin-top: 30px;
    }

    .ruangan2 {
        width: 100%;
        /* height: 120px; */
        margin-top: 18px;
        /* margin-top: 75px; */
        padding: 0;
        color: #006836;
        font-size: 6vw;
        /* font-family: oswald; */
        /* font-weight: bold; */
        text-align: left;
    }

    .ruangan3 {
        width: 100%;
        /* height: 120px; */
        margin-top: 15px;
        /* padding-top: 10px; */
        color: #006836;
        font-size: 2.25vw;
        /* font-family: oswald; */
        /* font-weight: bold; */
        text-align: center !important;
        /* text-align: left; */
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
        color: #006836;
        text-align: center;
        font-size: 4vw;
        /* font-weight: bold; */
    }

    .no-antrian2 {
        color: #fff;
        text-align: center;
        font-size: 3.5vw;
    }

    /* .no-antrian {
        font-size: 5.5vw;
        line-height: 6vw;
    } */

    .pasien-deskripsi,
    ruangan {
        /*font-size: 70%;*/
        width: 100%;
        font-size: 2vw;
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
        bottom: 40px;
        right: 0;
        width: 200px;
        padding: 0 10px;
        color: #007;
        text-shadow: none;
        font-weight: bold;
        font-size: 15px;
        text-align: center;
        color: #fff;
        /* height: 40px; */
        font-family: oswald;
        /* background-color: #3753a4; */
    }

    #clock2 {
        position: absolute;
        bottom: 10px;
        right: 0;
        width: 200px;
        padding: 0 10px;
        color: #007;
        text-shadow: none;
        font-weight: bold;
        font-size: 20px;
        text-align: center;
        color: #fff;
        /* height: 40px; */
        font-family: oswald;
        /* background-color: #3753a4; */
    }

    .content {
        margin-left: 0 !important;
    }

    #pantrian {
        background-color: #2b2e3b;
        height: 125px;
        width: 25%;
    }

    /* #pantrian2 {
        background-color: #fff;
        height: 125px;
    } */
    .pantriantengah {
        width: 100%;
        height: 8.5vw;

        padding: 10px;
        /* background-color: #18476d; */
        color: #fff;
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        border-radius: 20px;
        /* font-family: oswald; */
        /* font-weight: bold; */
        text-align: center;
        margin: 5px 0px;
        border-color: #006836 !important;
    }

    #logo {
        position: absolute;
        float: left;
        /* width: 100%; */
        height: 60px;
        background: url("<?php echo Params::urlProfilRSDirectory() . $config->logolayarantrian; ?>") left center no-repeat;
        background-size: contain;
        border-color: none !important;
    }

    .h-full {
        height: 100% !important;
    }

    .pantriantengah2 {
        width: 100%;
        height: 6.5vw;

        padding: 10px;
        /* background-color: #18476d; */
        color: #fff;
        -moz-border-radius: 20px;
        -webkit-border-radius: 20px;
        border-radius: 20px;
        /* font-family: oswald; */
        /* font-weight: bold; */
        text-align: center;
        margin: 5px 0px;
        border-color: #006836 !important;
    }

    .pantriankanan {
        width: 100%;
        height: 40vw;
        ;
        /* padding: 10px; */
        /* background-image: url(images/antrianpoliklinik/antrian_poliklinik_BG-02.jpg); */
        /* background-color: #18476d; */
        color: #fff;
        -moz-border-radius: 40px;
        -webkit-border-radius: 40px;
        border-radius: 40px;
        /* font-family: oswald; */
        /* font-weight: bold; */
        text-align: center;
        margin: 5px 0px;
        border-color: #006836 !important;
    }

    .btn-danger {
        text-decoration: none;
        background-color: #fff !important;
    }

    .btn-danger:focus,
    .btn-danger:hover {
        text-decoration: none;
        background-color: #fff !important;
        border-color: none !important;
    }

    #pantrian2 {
        display: flex;
        align-items: left;
        justify-content: left;
        float: left;
        width: 100%;
        /* height: 100px; */

        /* z-index: -100; */
        /* padding: 10px; */
        /* background-color: rgba(255, 255, 255, .95); */
    }

    #pantrian2 img {
        width: 100%;
        max-width: 300px;
    }

    .btn-info {
        text-decoration: none;
        /* background-image: url(images/batik_papua.jpg); */
        background-image: url(images/antrianpoliklinik/Antrian_Poliklinik_bg-003.png);
        /* background-color: #fff !important; */
        -webkit-background-size: 100% 100%;
        background-color: transparent !important;
        border-color: #006836 !important;
        padding: 0px !important;
    }

    .btn-primary {
        text-decoration: none;
        background-color: #006836 !important;
        border-color: #006836 !important;
        padding: 0px !important;
    }

    .btn-info:focus,
    .btn-info.active,
    .btn-info:hover {
        text-decoration: none;
        /* background-image: url(images/batik_papua.jpg); */
        background-image: url(images/antrianpoliklinik/Antrian_Poliklinik_bg-003.png);
        /* background-image: url(images/antrianpoliklinik/Antrian_Poliklinik_bg-03.jpg); */
        /* background-image: url(images/antrianpoliklinik/antrian_poliklinik_BG-02.jpg); */
        background-color: transparent !important;
        -webkit-background-size: 100% 100%;
        border-color: none !important;
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
        margin-bottom: 50px;
        padding: 10px 0;
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

    .col-xs-3 {
        padding: 0px !important;
    }

    #kotak1 {
        margin-top: 0;
        /* border-radius: 40px; */
        /* width: 100%; */
        /* margin-left: 50px; */
        /* float: left; */
    }

    #kotak2 {
        /* margin-top: 45px; */
        /* border-radius: 40px; */
        /* width: 100%; */
        /* margin-left: 10px; */
        /* background-color: yellow; */
        /* padding: 10px; */
        float: left;
    }
</style>
<?php
// $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>
<?php echo CHtml::hiddenField('jamsekarang', "", array('readonly' => true, 'class' => 'realtime')); ?>
<!-- <div class="col-sm-12 " style="padding: 0 10px; margin-top:55px;">
            <div class="col-xs-4">
                <div class="col-sm-12" style="background: #fff;" padding: 10px;><img style="height:95px; margin-top: 0;" src="<?php //echo Params::urlProfilRSDirectory() . $config->logolayarantrian 
                                                                                                                                ?>" id="logo" /></div>
            </div>
        </div> -->

<!-- <div id="logo"></div> -->
<div class="row">
    <div style="margin: 10px 20px">
        <div class="col-xs-4" id="logo"></div>
    </div>
    <div class="col-sm-12" style="margin-top: 15px;">
    
        <div class="statistik" id="kotak1" style=" padding: 0 4px;">
            <div class="col-xs-4 ruangan2">
                <div class="col-sm-12">
                    Antrian Poliklinik
                </div>          
            </div>
            <!-- <div class="col-sm-12" style="padding: 0 30px;"> -->
            <!-- </div> -->
            <!-- <div class="clear"></div> -->
            <?php
                $total = count((array)$modRuangans);
                $style = '';
                if($total < 5) {
                    $style = 'display:flex;justify-content: center;';
                }
            ?>
            <div class="col-sm-12" style="padding: 0 5px;<?= $style ?>">
                <?php
                $col = array("#0c0", "#00a", "#ea0");
                $cnt = 0;
                if (!empty($modRuangans)) {
                    $total = count((array)$modRuangans);
                    foreach ($modRuangans as $i => $ruangan) {
                ?>
                        <div class="col-xs-3">
                            <div id="ruangan_<?php echo isset($ruangan->ruangan_id) ? $ruangan->ruangan_id : ''; ?>" class="antrian">
                                <!-- <div style="font-size:2vw; color:white; font-family:oswald; font-weight: bold;" class="col-xs-4 ruangan1 loket-nama" id="pasien-deskripsi_<?php echo $i; ?>">
                                <div class="col-sm-12 pasien-deskripsi">---</div>
                            </div> -->
                                <div class="btn-danger pantriantengah">
                                    <div class="h-full">
                                        <div class="no-antrian">
                                            <?php isset($ruangan->ruangan->ruangan_singkatan) ? $ruangan->ruangan->ruangan_singkatan : '';
                                            ?>
                                            000
                                            <?php isset($ruangan->ruangan->ruangan_nama) ? $ruangan->ruangan->ruangan_nama : '';
                                            ?>

                                        </div>
                                        <div style="font-size:1vw; font-weight:bold; color:#ED1E79">
                                            <?php echo isset($ruangan->ruangan->ruangan_nama) ? $ruangan->ruangan->ruangan_nama : ''; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-xs-4 ruangan" id="ruangan_nama_<?php //echo $i; 
                                                                                    ?>"> -->
                                <!-- <div class="col-sm-12" style="font-size:1.5vw;padding-left: 0; padding-right: 0;"><?php echo isset($ruangan->ruangan->ruangan_nama) ? $ruangan->ruangan->ruangan_nama : ''; ?></div> -->
                                <!-- <div class="col-sm-12 dokter" style="font-size:1.3vw;padding-left: 0; padding-right: 0;"><?php //echo '---'; 
                                                                                                                                ?></div> -->
                                <!-- </div> -->
                                <?php echo $this->renderPartial('_formKunjungan', array('model' => $model)); ?>
                            </div>
                        </div>
                    <?php
                        $cnt++;
                    }
                    ?>
                <?php
                }
                ?>
                <?php
                $col = array("#0c0", "#00a", "#ea0");
                $cnt = 0;
                if (count((array)$modLokets) > 0) {
                    foreach ($modLokets as $i => $loket) {
                        if (empty($model_col[$loket->modelantrian_id])) {
                            continue;
                        }
                ?>
                        <div class="col-sm-3 col-nopadding">
                            <div id="loket_<?php echo $loket->loket_id; ?>" class="antrian" data-antrian="<?php echo $loket->loket_id; ?>">
                                <div style="<?php echo empty($loket->modelantrian_id) ? "" : "background-color:" . $model_col[$loket->modelantrian_id]; ?>" class="col-xs-4 ruangan1" id="ruangan_<?php echo $i; ?>">
                                    <div class="col-sm-12">NO. ANTRIAN</div>
                                </div>
                                <div class="col-xs-4 " id="pantriantengah">
                                    <div class="col-sm-12 no-antrian">0-000</div>
                                </div>
                                <div class="col-xs-4 ruangan_loket loket-nama" id="pasien-deskripsi_<?php echo $i; ?>">
                                    <div class="col-sm-12">LOKET <?php echo $loket->loket_singkatan; ?></div>
                                </div>
                            </div>
                        </div>
                <?php
                        $cnt++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- <div class="col-sm-4" style="margin-top: 25px;">
        <div id="kotak2">
            <div class="col-sm-12 statistik" id="kotak2" style=" padding: 0 5px;">
                <div class="btn-info col-xs-3 pantriankanan">
                    <div class="col-xs-4 ruangan3">
                        <div class="" style="padding: 10px 0 ;">
                            Antrian yang Terlewatkan
                        </div>
                    </div>
                    <div class="col-sm-12" style="padding: 0 5px;"> -->
                        <?php
                        // $col = array("#0c0", "#00a", "#ea0");
                        // $cnt = 0;
                        // if (count((array)$modLokets) > 0) {
                        //     foreach ($modLokets as $i => $loket) {
                        //         if (empty($model_col[$loket->modelantrian_id])) {
                        //             continue;
                        //         }
                        //$col = array("#0c0", "#00a", "#ea0");
                        //$cnt = 0;
                       // if //(!empty($modRuangans)) {
                           // $total = count((array)$modRuangans);
                           // foreach ($modRuangans as $i => $ruangan) {
                        ?>
                                <!-- <div class="col-xs-6"style="padding: 0px;">
                                    <div id="loket_<?php //echo $loket->loket_id; 
                                                    ?>" class="antrian" data-antrian="<?php //echo $loket->loket_id; ?>">
                                        <div style="<?php //echo empty($loket->modelantrian_id) ? "" : "background-color:" . $model_col[$loket->modelantrian_id]; 
                                                    ?>" class="col-xs-4 ruangan1" id="ruangan_<?php //echo $i; ?>">
                                            <div class="col-sm-12">NO. ANTRIAN</div>
                                        </div>
                                        <div class="col-xs-4 " id="pantriantengah">
                                            <div class="col-sm-12 no-antrian">0-000</div>
                                        </div>
                                        <div class="col-xs-4 ruangan_loket loket-nama" id="pasien-deskripsi_<?php //echo $i; ?>">
                                            <div class="col-sm-12">LOKET <?php //echo $loket->loket_singkatan; 
                                                                            ?></div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="col-xs-6" style="padding: 0px;">
                                    <div id="ruangan_<?php //echo isset($ruangan->ruangan_id) ? $ruangan->ruangan_id : ''; ?>" class="antrian">
                                        <div class="btn-primary col-xs-6 pantriantengah2">
                                            <div class="no-antrian2">
                                                000
                                            </div>
                                            <div style="font-size:1vw; font-weight:bold;">
                                                <?php //echo isset($ruangan->ruangan->ruangan_nama) ? $ruangan->ruangan->ruangan_nama : ''; ?>
                                            </div>
                                        </div>
                                        <?php //echo $this->renderPartial('_formKunjungan', array('model' => $model)); 
                                        ?>
                                    </div>
                                </div> -->
                            <?php
                                //$cnt++;
                            //}
                            ?>
                        <?php
                        //}
                        ?>
                    <!-- </div>
                </div>
            </div>
        </div>
    </div> -->
</div>

<?php $profil = ProfilrumahsakitM::model()->find(); ?>
<div class="block-footer-antrian">
    <!-- <div id="footerAntrian"> -->
    <!-- <marquee direction="left" scrollamount="10" id="textrunning">
            <?php //echo $profil->nama_rumahsakit . " - " . $profil->motto; 
            ?>
        </marquee> -->
    <!-- </div> -->
    <?php //echo $this->renderPartial('application.views.headerReport.footerSocialMedia', array()); ?>

    <div id="footerClock">
        <div id="clock"></div>
        <div id="clock2"></div>
    </div>
</div>
<?php echo $this->renderPartial('_jsFunctions', array('model' => $model, 'modRuangans' => $modRuangans, 'modLayar' => $modLayar, 'konfig' => $konfig)); ?>
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
        // var currentTimeString = currentDate + " " + mon[currentMonth] + " " + currentYear + " " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
        daysId = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
        var currentTimeString = daysId[currentDay] + ", " + currentDate + " " + mon[currentMonth] + " " + currentYear;
        var currentTimeString2 = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
        $("#clock").html(currentTimeString);
        $("#clock2").html(currentTimeString2);
    }
    $(document).ready(function() {
        setInterval('updateClock()', 1000);
    });
</script>