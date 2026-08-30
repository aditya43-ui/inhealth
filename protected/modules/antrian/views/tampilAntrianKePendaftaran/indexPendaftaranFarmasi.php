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

    .ruangan,
    .dokter {
        background-color: #2b2e3b;
        height: 150px;
        width: 100%;
    }

    .noresep {
        background-color: #2b2e3b;
        padding: 5px;
        text-align: center;
    }

    .ruangan1,
    .ruangan {
        background-color: #2b2e3b;
        height: 2.5vw;
        width: 100%;
        margin-top: 5px;
        padding: 5px;
        font-size: 1.25vw;
        color: #fff;
        font-family: oswald;
        font-weight: bold;
        text-align: center;
    }

    .ruangan {
        margin: 0;
    }

    .ruangan2 {
        background-color: #2b2e3b;
        margin-top: 5px;
        text-align: center;
    }

    .dokter {
        /*font-size: 70%;*/
        color: #00FF00;
        border: 1px solid #fff;
        border-bottom: none;
        border-top: none;
    }

    .no-antrian {
        color: #fff;
        text-align: center;
        font-size: 5vw;
        font-weight: bold;
    }

    .pasien-deskripsi-farmasi {
        width: 100%;
        font-size: 1.5vw;
        border-top: none;
        background-color: #2b2e3b;
        color: #fff;
        font-family: oswald;
        font-weight: bold;
    }

    .daftar-judul {
        color: #fff;
        text-align: center;
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
        height: 175px;
        padding-top: 15px;
        /*height:125px;*/
        width: 33.3%;
    }

    #pantrian2 {
        background-color: #fff;
        height: 175px;
        /*height:125px;*/
        width: 33.3%;
    }

    #pantriantengah,
    #pantrianfarmasitengah {
        width: 100%;
        background-color: #3a3c4a;
    }

    #pantrianbawah {
        background-color: #2b2e3b;
        height: 150px;
        width: 100%;
    }

    #layar {
        background-color: #2b2e3b;
        border-color: #f5f4f7;
        margin-top: 5px;
    }

    #layarbor {
        background-color: #3a3c4a;
        height: 160px;
        width: 100%;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    #vimi {
        background-color: #0d8541;
        color: #fff;
        font-family: oswald;
        font-weight: lighter;
        font-size: 1vw;
        border-bottom-left-radius: 10px;
    }

    #vimi2 {
        background-color: #18476d;
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
        background-color: #0d8541;
        color: #fff;
        font-family: oswald;
        font-weight: lighter;
        font-size: 1vw;
        text-transform: uppercase;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    h3 {
        font-size: 22px;
        /*font-size:1vw;*/
    }

    .no-loket {
        margin-left: 5px;
    }

    .col-video {
        padding-right: 0;
    }

    .col-nopadding {
        padding-right: 0;
        padding-left: 0;
    }

    .frame-antrian {
        padding-right: 15px;
        margin-bottom: 0;
    }

    .padingvideo {
        width: 100%;
        height: 480px;
    }

    .tab_statistik {
        border-collapse: collapse;
    }

    .tab_statistik td {
        padding: 2px !important;
        font-size: 11pt;
    }
</style>
<?php $config = KonfigsystemK::model()->find(); ?>

<?php echo CHtml::hiddenField('jamsekarang', "", array('readonly' => true, 'class' => 'realtime')); ?>
<?php $i = "apotek"; ?>

<div class="row" style="margin: 0">
    <div class="col-sm-6">
        <div class="col-sm-12" style="background: #fff;" padding: 10px;><img style="height:95px; margin-top: 0;" src="<?php echo Params::urlProfilRSDirectory() . $config->logolayarantrian; ?>" id="logo" /></div>
        <!-- <div class="col-sm-12" style="background: rgba(255, 255, 255, .95); margin-top: 15px; padding: 10px; text-align: center;"><img style="height:95px; margin-top: 0;" src="<?php echo Yii::app()->request->baseUrl . '/images/antrian/logo-rspmc-transparan.png' ?>" id="logo" /></div> -->
        <div style="font-size:3vw; background-color:#18476d; color:white; font-family:oswald; font-weight: bold; text-align: center;">
            ANTRIAN FARMASI <?php echo $this->is_bpjs ? "BPJS" : "UMUM" ?>
        </div>
        <div class="row_fluid">
            <div class="col-xs-6 col-nopadding panel_antrian_racikan" style="padding-left: 2px; padding-right: 2px;">
                <div style="font-size:3vw; color:white; font-family:oswald; font-weight: bold;" class="col-md-12 ruangan2" id="ruangan_farmasi_<?php echo $i; ?>">
                    RACIKAN
                </div>
                <div class="col-md-12 no-antrian_farmasi" id="pantrianfarmasitengah" align="center" style=" color:white; font-family:oswald; font-weight: bold; font-size:5vw;">
                    0-000
                </div>
                <div class="col-md-12 noresep pasien-deskripsi-farmasi" id="pasien-deskripsi_<?php echo $i; ?>">
                    <span> NAMA PASIEN<br>NO RESEP </span>
                </div>
            </div>
            <div class="col-xs-6 col-nopadding panel_antrian_nonracikan" style="padding-left:2px; padding-right: 2px;">
                <div style="font-size:3vw; color:white; font-family:oswald; font-weight: bold;" class="col-md-12 ruangan2" id="ruangan_farmasi_<?php echo $i; ?>">
                    NON RACIKAN
                </div>
                <div class="col-md-12 no-antrian_farmasi" id="pantrianfarmasitengah" align="center" style=" color:white; font-family:oswald; font-weight: bold; font-size:5vw;">
                    0-000
                </div>
                <div class="col-md-12 noresep pasien-deskripsi-farmasi" id="pasien-deskripsi_<?php echo $i; ?>">
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
    <div class="col-sm-6">
        <div class="row" style="margin: 15px 0 0 -20px;">
            <?php
            $col = array("#2b2e3b", "#0d8541", "#18476d");
            $model_col = array();
            $cnt = 0;
            if (count((array)$modModels) > 0) {
                foreach ($modModels as $i => $modelDetail) {
                    $model_col[$modelDetail->modelantrian_id] = $col[$i];
            ?>
                    <div id="loket2_<?php echo $modelDetail->modelantrian_id; ?>" class="antrian" data-antrian="<?php echo $modelDetail->modelantrian_id; ?>">
                        <div class="col-xs-2 statistik" id="pantrian" style="font-size:16px; color:white; height:185px; font-family:oswald; font-weight: bold;background-color:<?php echo $col[$cnt]; ?>;">
                            <?php echo "<h4 style='color:white'>" . strtoupper($modelDetail->modelantrian_nama) . "</h4>"; ?>
                            <?php echo $this->renderPartial('_statistik_model', array('modelDetail' => $modelDetail)); ?>
                        </div>
                    </div>
            <?php
                    $cnt++;
                }
            }
            ?>
        </div>
        <div class="row frame-antrian">
            <?php
            $col = array("#0c0", "#00a", "#ea0");
            $cnt = 0;
            if (count((array)$modLokets) > 0) {
                foreach ($modLokets as $i => $loket) {
                    $sub_model = ModelantrianM::model()->findByPk($loket->modelantrian_id);
            ?>
                    <div class="col-xs-6 col-nopadding">
                        <div id="loket_<?php echo $loket->loket_id; ?>" class="antrian" data-antrian="<?php echo $loket->loket_id; ?>">
                            <div style="font-size:1.5vw; color:white; font-family:oswald; font-weight: bold; <?php echo empty($loket->modelantrian_id) ? "" : "background-color:" . $model_col[$loket->modelantrian_id]; ?>" class="col-xs-4 ruangan1" id="ruangan_<?php echo $i; ?>">
                                <div class="col-sm-12">NO. <?php echo strtoupper($sub_model->modelantrian_nama); ?> </div>
                            </div>
                            <div class="col-xs-4 " id="pantriantengah" align="center" style=" color:white; font-family:oswald; font-weight: bold;">
                                <div class="col-sm-12 no-antrian">0-000</div>
                            </div>
                            <div class="col-xs-4 ruangan loket-nama" id="pasien-deskripsi_<?php echo $i; ?>">
                                <div class="col-sm-12">LOKET <?php echo $loket->loket_singkatan; ?></div>
                            </div>
                        </div>
                    </div>
            <?php
                    $cnt++;
                }
            }
            ?>
            <?php
            $sisa = 6 - count((array)$modLokets);
            for ($cnt = 0; $cnt < $sisa; $cnt++) :
            ?>
                <div class="col-xs-3 col-nopadding">
                    <div class="no-loket">
                        <div style="font-size:2vw; color:white; font-family:oswald; font-weight: bold;" class="col-xs-4 ruangan1" id="ruangan_a_<?php echo $cnt; ?>">
                        </div>
                        <div class="col-xs-4 no-antrian" id="pantriantengah" align="center" style=" color:white; font-family:oswald; font-weight: bold;">
                            <div class="col-sm-12"> <img style="width:100%; margin-top: 0;" src="<?php echo Params::urlProfilRSDirectory() . $modProfile->noimagelayarantrian; ?>" id="logo" /></div>
                        </div>
                        <div class="col-xs-4 ruangan" id="pasien-deskripsi_<?php echo $i; ?>">
                            <div class="col-sm-12" style="font-size:1vw;padding-top:5%">MERAWAT DENGAN KASIH SAYANG</div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
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
<?php echo $this->renderPartial('_jsFunctions', array('model' => $model, 'konfig' => $konfig)); ?>
<div id="suarapanggilan"></div>
<script>
    var mon = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

    function updateClock() {
        var currentTime = new Date();
        var currentHours = currentTime.getHours();
        var currentMinutes = currentTime.getMinutes();
        var currentSeconds = currentTime.getSeconds();
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
        var currentTimeString = currentDate + " " + mon[currentMonth] + " " + currentYear + " - " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
        $("#clock").html(currentTimeString);
    }
    $(document).ready(function() {
        setInterval('updateClock()', 1000);
        setInterval(function() {
            $(".antrian").each(function() {
                updateStatistik($(this).data("antrian"));
            });
        }, 60000);
        $(".antrian").each(function() {
            updateStatistik($(this).data("antrian"));
        });
    });
</script>