<?php 
    $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
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
        left: 0;
        top: 0;
        z-index: -100;
        width: 100vw;
        height: 100vh;        
    }   

   
    .video-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        line-height: 400px;
        background: #ddd;
    }

    .content {
        margin: 0;
        padding-bottom: 5px !important;
    }

    thead th {
        text-align: center;
        padding-right: 20px;
    }

    .antrian {
        margin-left: 5px;
    }
    #social-media {
        /* position: absolute; */
        text-align: left;
        width: 100%;
        height: 20px;
        z-index: 50;
        padding-top: 55px;
        margin-left: 75px;
        margin-bottom: 35px;
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

    .ruangan1,
    .ruangan {
        background-color: #fff;
        height: 2.5vw;
        width: 100%;
        margin-top: 5px;
        padding: 5px;
        font-size: 1.25vw;
        color: #fff;
        font-family: oswald;
        font-weight: bold;
        text-align: center;
        border-radius: 20px 20px 0px 0px;
        box-shadow: 7px 7px 3px 3px rgba(200, 200, 200, .5);
    }

    .ruangan_loket {
        background-color: #fff;
        height: 2vw;
        width: 100%;
        padding: 5px;
        font-size: 1vw;
        color: #006838;
        font-family: oswald;
        font-weight: bold;
        text-align: center;
        border-radius: 0px 0px 20px 20px;
        box-shadow: 7px 7px 3px 3px rgba(200, 200, 200, .5);
    }
    .ruangan {
        margin: 0;
    }

    .dokter {
        /*font-size: 70%;*/
        color: #00FF00;
        border: 1px solid #fff;
        border-bottom: none;
        border-top: none;
    }

    .no-antrian {
        color: #006836 !important;
        text-align: center;
        font-size: 1.75vw;
        font-weight: bold;
        box-shadow: 7px 7px 3px 3px rgba(200, 200, 200, .5);
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
        position: absolute;
        bottom: 0;
        width: 100%;
    }

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

    .row {
        margin: 0;
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
        /* background-image: linear-gradient(0deg, rgb(255, 255, 255) 71.8%, rgb(237, 30, 121) 71.8%); */
        /* background-image: -moz-linear-gradient(red , yellow 80%); */
        /* #2b2e3b; */
        height: 13vw;
        padding-top: 15px;
        /*height:125px;*/
        width: 50%;
        border-radius: 20px;
        border-color: #006836 !important;
        /* border-color: solid 1px #006838; */
        /* box-shadow: #000; */
        /* -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075); */
        box-shadow: 7px 7px 3px 3px rgba(200, 200, 200, .5);
    }


    .pantrianX {
        background-image: linear-gradient(0deg, rgb(255, 255, 255) 71.8%, rgb(255, 255, 255) 71.8%);
        /* background-image: -moz-linear-gradient(red , yellow 80%); */
        /* #2b2e3b; */
        height: 100%;
        padding-top: 15px;
        max-height: 400px;
        /*height:125px;*/
        width: 23%;
        margin: 5px;
        border-radius: 20px;
        border-color: #006836 !important;
        /* border-color: solid 1px #006838; */
        /* box-shadow: #000; */
        /* -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075); */
        box-shadow: 7px 7px 3px 3px rgba(200, 200, 200, .5);
    }
    

    #pantrian2 {
        display: flex;
        align-items: left;
        justify-content: left;
        float: left;
        width: 100%;
        height: 3vw;
        /* padding: 10px; */
        /* background-color: rgba(255, 255, 255, .95); */
    }

    #pantrian2 img {
        width: 100%;
        max-width: 300px;
    }

    #pantriantengah {
        background-color: #fff;
        font-family: oswald;
        width: 100%;
        padding: 0 !important;
    }

    #pantrianbawah {
        background-color: #fff;
        height: 150px;
        width: 100%;
    }

    #layar {
        background-color: #000;
        border-color: #f5f4f7;
        /* margin-top: 5px; */
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
        height: 320px;
    }
    #logo{
        padding-top: 0px !important;
        padding-bottom: 0px !important;
    }
    .tab_statistik {
        border-collapse: collapse;
    }

    .tab_statistik td {
        padding: 2px !important;
    }
    
    .footer{
        color:#fff;
        background: #000;
        font-size:2vw;
        padding:0.5vw;
        /* position:fixed; */
        width:100%;
        bottom:0;
    }
    
    .flex{
        display: flex;
        flex-wrap: wrap;
        justify-content:center;
    }  
    
    .flex-1 {
        flex: 1;
    }
    .flex-2 {
        flex: 2;
    }
    
    .flex-100 {
        flex: 1 100%;
    }
</style>
<?php

$config = KonfigsystemK::model()->find();

$res = scandir(Params::pathVideoAntrian());
$res_dat = array();
foreach ($res as $item) {
    if (in_array($item, array('.', '..', 'logo.gif'))) {
        continue;
    }

    $res_dat[] = Params::urlVideoAntrian() . $item;
}

// var_dump($res_dat); die;

echo CHtml::hiddenField('jamsekarang', "", array('readonly' => true, 'class' => 'realtime')); ?>
<header class="flex" style="padding-bottom: 0px;">
    <div class="flex-1">
        <?php        
            $path = Params::pathProfilRSDirectory().$profil->logo_rumahsakit;

            $res = "";
            $ext = "png";
            if (file_exists($path)) {
                $content = file_get_contents($path);
                $ext_data = pathinfo($path);

                if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
                    $ext = $ext_data['extension'];
                }

                $res = "data:image/".$ext.";base64,". base64_encode($content);
            }
        ?>
        <img src="<?= $res ?>" width="20%" style="position:fixed;">
    </div>    
</header> 
<div class="row" style="margin: 15px 15px 15px 0">
    <div class="col-sm-6 statistik" id="pantrian2">
        
    </div>
</div>
<h2 align='center'><b>ANTRIAN PENDAFTARAN LOKET <?= $modLokets[0]->loket_singkatan; ?></b></h2>
<div class="row " style="margin: 0 15px 15px 0">
    
    <div class="col-xs-12" style="padding-left: 5px; padding-right:5px;">
        <?php
        $col = array("#0c0", "#006838", "#006838", "#fff", "#fff");
        $model_col = array();
        $cnt = 0;
        if (count((array)$modLokets) > 0) {
            foreach ($modLokets as $i => $modelDetail) {
                $color = $col[0];
        ?>
                <div id="loket_<?php echo $modelDetail->loket_id; ?>" class="antrian" data-antrian="<?php echo $modelDetail->loket_id; ?>">                                                               
                        <div class="col-sm-12 col-nopadding" style='margin-top:2vw;display:flex;justify-content: center;flex-direction: column;align-items: center;'>
                            <div style="flex: 1 100%;width:40%;">
                                <div id="loket_<?php echo $modelDetail->loket_singkatan; ?>" class="" data-antrian="<?php echo $modelDetail->loket_singkatan; ?>" style="padding:0;">
                                    <div style="height:5.5vw;padding:0;<?php echo empty($modelDetail->modelantrian_id) ? "background-color:#5ec196;" : "background-color:#5ec196;"; ?>" class="col-xs-4 ruangan1" id="ruangan_<?php echo $i; ?>">
                                        <div class="col-sm-12" style="font-size:4vw;">NO. ANTRIAN</div>
                                    </div>
                                    <div class="col-xs-4 " id="pantriantengah">
                                        <div class="col-sm-12 no-antrian" style="font-size: 5vw;">0-000</div>
                                    </div>
                                    <div class="col-xs-4 ruangan_loket loket-nama" id="pasien-deskripsi_<?php echo $i; ?>" style="height:3vw;display:none;">
                                        <div class="col-sm-12" style="font-size: 4vw;">LOKET <?php echo $modelDetail->loket_singkatan; ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php if(count($list) < 5) {  ?>
                                <style>
                                    .frame-antrian{
                                        width: 100vw;
                                    }
                                </style>
                            <?php } ?>
                            <div class="row frame-antrian" style="display: flex;margin-top:0.5vw;">
                                <div class="col-sm-12" style="padding: 0 2px;" id="form-list-antrian-belum-panggil">
                                    <?php
                                        $col = array("#0c0", "#00a", "#ea0");
                                        $cnt = 0;
                                        $loket_singkatan = array();
                                       
                                        echo $this->renderPartial('baris/_antrianLoketNew',['loket'=>$modLokets[0], 'list'=>$list, 'i'=>$i], true);                                        
                                    ?>   
                                </div>
                            </div>
                        </div>
                    
                        <div  class="col-md-12" style="background:none;border-radius:0px;color:#006838; font-family:oswald; font-weight: bold;margin-top:2vw;width:100%;padding:0px;font-size:2.0vw;">                            
                            <?php
                            echo $this->renderPartial('_statistik_loket', array('modelDetail' => $modelDetail)); ?>
                        </div>
                </div>
        <?php
                $cnt++;
             
            }
        }
        ?>
    </div>
    <?php /*
        <div class="col-xs-6 col-video" style="padding-top:5px; padding-left: 5px; padding-right:5px;">
            <div class="col-sm-12" id="layar">
                <!--<div style="width:100%; height:350px">-->
                <div style="width:100%; height:350px; display: flex; align-items: center;" id="panel_video_antrian">
                    <?php
                    if ($res_dat > 0) {
                        $urlvidio = Params::urlVideoAntrian() . $modProfile->videoprofil;
                        echo '<div id="output" hidden></div>';
                    } else {
                        echo '<div class="video-placeholder">Video belum di-setting.</div>';
                    }
                    ?>
                </div>            
            </div>        
        </div>
     * 
     */ ?>
</div>
<div class="footer">
    <marquee direction="left" scrollamount="7" align="center">
        NOMOR ANTRIAN YANG TERTERA DILAYAR HARAP MENUJU KE PETUGAS PENDAFTARAN
    </marquee>
</div>
        
<?php echo $this->renderPartial('_jsFunctionsLoket', array('model' => $model, 'konfig' => $konfig, 'res_dat' => $res_dat)); ?>
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