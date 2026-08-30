<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <!-- <title></title> -->
    <link rel="stylesheet" type="text/css" href="css/font.css" />
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/alertjs/js/jquery.ui.draggable.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/socket.io.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/dist/notiflix-aio-2.7.0.min.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/alertnotiflix/notiflixalert.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/notiflix/promjs/build/jquery.dialog.min.js'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/notiflix/promjs/build/jquery.dialog.min.css" />
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
        .back-button{
            float:right;
            border: 2px solid #000;
            padding:3px 10px;
        }
        .radius-penjamin{
            border-radius: 15px;
            
            height: 180px;
            
        }
        .radius{
            border-radius: 15px;
            /* margin-top: 30px; */
            height: 90px;
            /* clear:both;   */
        }
        .no_rm_fasttrack{
            height:2vw;
        }
        body {
            background-color: #efefef;
            margin-left: 40px;
            margin-right: 40px;
            margin-top: auto;
            margin-bottom: auto;
            /* warna text ciputat */
            color: #006838;
        }

        /* .background {
            position: fixed;
            left: 0;
            top: 0;
            z-index: -100;
            width: 105vw;
            height: 105vh;
            background: url("<?php //echo Yii::app()->request->baseUrl; ?>/images/antrian/antrianbaru.jpg") center center no-repeat;
            background-size: cover;
            filter: blur(25px) brightness(125%);
            -webkit-filter: blur(25px) brightness(125%);
            -moz-filter: blur(25px) brightness(125%);
        } */

        .background {
            position: fixed;
            left: 0;
            top: 0;
            z-index: -100;
            width: 100vw;
            height: 100vh;
            /*background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/jadwal_dokter/BG-06.jpg") center center no-repeat;*/
            background: url("<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit; ?>") center center no-repeat;
            /* background: url("<?php //echo Yii::app()->request->baseUrl; 
                                ?>/images/antrian/antrianbaru.jpg") center center no-repeat; */
            background-size: cover;
            opacity: 0.2;
            /* filter: blur(25px) brightness(125%);
            -webkit-filter: blur(25px) brightness(125%);
            -moz-filter: blur(25px) brightness(125%); */
        }
        #header {
            display: flex;
            align-items: center;
            height: 120px;
            width: calc(100% - 15px);
            margin: 25px 0 25px;
            rgb:(255, 255, 255, 85);
            height: auto;
        }

        #social-media {
            position: absolute;
            text-align: right;
            width: 100%;
            height: 50px;
            z-index: 50;
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
            border: 2px solid #999;
            border-radius: 4px;
            text-align: center;
            background: linear-gradient(90deg, #000, #555);
        }

        #logo {
            position: absolute;
            float: left;
            width: 100%;
            margin-left: -120px;
            height: 130px;
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
            padding: -5px;
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
            border: 1px solid #ddd;
            padding: 10px;
        }

        .list-jadwal tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .list-jadwal tr:hover {
            background-color: #ddd;
        }

        .list-jadwal th {
            padding-top: 13px;
            padding-bottom: 13px;
            text-align: left;
            background-color: #00df92;
            color: #fff;
            font-family: oswald;
            font-weight: bold
        }

        .borderline {
            padding: -15px;
            border: 2px solid #00df92;
            border-radius: 17px;
        }

        #footerAntrian {
            margin-top: 20px;
            width: calc(100% - 240px);
            box-shadow: 0 0 15px rgba(0, 0, 0, .5);
        }

        #footerClock {
            width: 240px;
            height: 60px;
            background: url("<?php echo Params::urlVideoAntrian(); ?>logo.gif") center center no-repeat;
            background-size: cover;
            border-radius: 30px 0 0 0;
            box-shadow: 0 0 5px rgba(0, 0, 0, .5);
        }

        #tab-text {            
            display: block;
            margin: 25px 0;
            font-size: 2rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .tab-pilih2 {
            margin: 4px 0px;
            /* padding: 5px 0; */
            /* background: #94C93D; */
            color: #000;
            /* border: 2px solid #006838; */
            border-bottom: none;
            /* border-radius: 15px 15px 0 0; */
            overflow: hidden;
            text-transform: uppercase;
            font-weight: bold;
            /* float:right; */
            text-align:right;
        }

        .tab-pilih2>li {
            display: inline-block;
            /* width: 24.75%; */
            margin: 0;
            font-size: 3rem;
            cursor: pointer;
        }

        .tab-pilih {
            margin: 0 13px;
            /* padding: 5px 0; */
            background: #94C93D;
            color: #000;
            border: 2px solid #006838;
            border-bottom: none;
            /* border-radius: 15px 15px 0 0; */
            overflow: hidden;
            text-transform: uppercase;
            font-weight: bold;
        }

        .tab-pilih>li {
            display: inline-block;
            /* width: 24.75%; */
            margin: 0;
            font-size: 4rem;
            cursor: pointer;
        }

        .tab-pilih a {
            display: block;
            /* padding: 8px; */
            text-decoration: none;
            color: #000;
        }

        .tab-pilih .past a{
            color: #000;
        }
        .tab-pilih .active a {
            color: #fff;
        }

        .penjamin-tab {
            background: #94C93D;
            /* border-radius: 10px 0 0 0; */
            transition: .15s;
            width:33%;
        }

        .poli-tab, .jeniskunjungan-tab {
            background: #94C93D;
            transition: .15s;
            color: #57A595;
            width:33%;
        }

        .dokter-tab {
            background: #94C93D;
            /* border-radius: 0 10px 0 0; */
            transition: .15s;
        }

        .penjamin-tab.past,
        .poli-tab.past, .jeniskunjungan-tab.past {
            background: #94C93D;
            width:35%;
        }

        .penjamin-tab.active,
        .poli-tab.active,
        .dokter-tab.active,.jeniskunjungan-tab.active {
            font-weight: bold;
            background: #006838;
            width:33%;
        }
        
        .flex-set{
            width:100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;                
            text-align: center;          
        }
        
    

        .item-select {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            position: relative;
            height: calc(100vh - 250px);
            overflow-y: none;
            margin: 0 5px;
            padding: 13px 0;
            /*background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/jadwal_dokter/BG-06.png") no-repeat;*/
            /* background: rgba(255, 255, 255, .5); */
            /*background-size: 100%;*/
            /* background-size:calc(100vh - 245px); */
            text-align: center;
            border: 2px solid #006838;
            /* border-top: none; */
            border-radius: 15px;
            /* border-radius: 0 0 15px 15px; */
        }

        .item-select>p {
            margin: 0;
            padding: 18px 40px 16px;
            font-size: 1.2rem;
        }

        .item-a {
            display: flex;
            flex-wrap: wrap;
            float: left;
            vertical-align:middle center;
            flex: 1 0 20%;
            max-width: 25%;
            /* max-width: calc(33.33333333% - 33.33333333px); */
            /* vertical-align: top; */
            top: 0;
            /* width: calc(33% - 30px); */
            margin: 15px;
            /* height:min-content; */
            /* max-height: 23vh; */
            /* max-height:fit-content(1vh); */
        }

        /* .clearfix:after {
            content: "";
            display: table;
            clear: both;
        } */


        .item-c {
            display: flex;
            flex-wrap: wrap;
            float:left;
            vertical-align:middle center;
            flex: 1 0 4%;
            max-width: 15%;
            width:14%;
            /* max-width: calc(33.33333333% - 33.33333333px); */
            /* vertical-align: top; */
            top: 0;
            /* width: calc(33% - 30px); */
            margin: 2px;
            margin-top: -56px;
            /* height:min-content; */
            /* max-height: 0.5vh; */
            /* max-height:fit-content(1vh); */
        }


        /* .clearfix:after {
            content: "";
            display: table;
            clear: both;
        } */

        .item-d {
            max-width: calc(50% - 50px);
            top: 0;
            width: calc(13%);
            margin: 5px;
            border-radius: 14px;
        }

        .item-b {
            max-width: calc(24% - 30px);
            vertical-align: top;
            top: 0;
            width: calc(13%);
            margin: 5px;
            border-radius: 20px;
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
            flex: 1 1 2px;
            width: 100%;
            /* height: 280px; */
            /* border-radius: 20px; */
            cursor: pointer;
            transition: .25s;
        }
        .tombol:hover {
            filter: brightness(80%);
        }

        .tombolbody hr {
            width: auto;
            height: 6px;
            margin: 0 6px 6px;
            border: none;
            background: #006838;
        }
        .tombolbody2 hr {
            width: auto;
            height: 6px;
            margin: 0 6px 6px;
            border: none;
            background: #fff;
        }

        .tombolpilih {
            width: 270px;
            margin-top: 1px;
            height: 270px;
            border-radius: 20px;
            cursor: pointer;
        }

        .tombolicon {
            font-size: 1vw;
            color: #fff;
            padding: 13px 0;
            text-align: center;
        }

        .labeltiket {
            padding: 6px 18px;
            font-size: 30px ;
            color: #fff;
            font-family: oswald;
            text-align: center;
            font-weight: bold;
            /* padding-top: 5px; */
            text-decoration: none;
        }
        .labeltiket2 {
            /* padding: 24px 14px;
            font-size: 17px;
            color: #006838;
            height: 15vw;
            text-align: center;
            font-family: oswald;
            font-weight: bold;
            padding-top: 5px;
            text-decoration: none; */

            padding: 6px 14px;
            font-size: 18px;
            color: #006838;
            height: fit-content;
            text-align: center;
            font-family: oswald;
            font-weight: bold;
            /* padding-top: 5px; */
            text-decoration: none;
            align-items: center;
            justify-content: center;
            display: flex;
        }
        
        .labeltiket3 {
            padding: 5px 5px;
            font-size: 18px;
            color: #fff;
            /*height: 2vw;*/
            font-family: oswald;
            text-align: center;
            font-weight: bold;
            /* padding-top: 5px; */
            text-decoration: none;
        }

        .radius2{
            border-radius: 20px;
            margin-top: 52px; 
            height: 100px;
            width : 40px;
            /* clear:both;   */
        }

        .radius3{
            border-radius: 17px;
            margin-top: 17px; 
            height: 110px;
            width : 50px;
            /* clear:both;   */
        }


        .labeltiket4 {
            padding: 17px 17px;
            font-size: 26px;
            color: #006838;
            height: 5vw;
            text-align: center;
            font-family: oswald;
            font-weight: bold;
            /* padding-top: 5px; */
            text-decoration: none;
        }


        .tombol2 {
            flex: 1 3 30px;
            width: 155px;
            /* height: 280px; */
            /* border-radius: 20px; */
            cursor: pointer;
            transition: .25s;
        }
        .tombol2:hover {
            filter: brightness(80%);
        }


        .setakhir {
            font-size: 11pt;
        }
        
        .tanggalreservasi{
            width:20vw !important;
            height:2vw;
            font-size:1.5vw;
        }
        
        .input-form-control{
            height:3vw;
            font-size:1.5vw;
            width:20vw !important;
            float:left !important;
        }

        .ui-datepicker {
            width:35em !important;
        }

        #poliklinik {
            margin-top: -50px;
        }

        #jeniskunjungan {
            margin-top: -39px;
        }

        #jeniskunjungan .item-select {
            height: 100vh;
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
    <!-- <div id="refresh">
        <?php
        // echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "javascript:void(0);", array(
        //     'onclick' => "window.location.href = window.location.href"
        // ));
        ?>
    </div> -->   
    <?= CHtml::hiddenField('ruanganpoli_pilih','') ?>
    <?php echo $form->hiddenField($model, 'modelantrian_id', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'ruangan_id', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'carabayar_id', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'statuspasien', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'carabayar_loket', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'loket_id', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'noantrian', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'jenis_kunjungan', array('class'=>'jenis_kunjungan','readonly' => true)); ?>
    

    <!-- </div> -->
    <!-- <div class="col-sm-4"> -->   
    <div class="bases">
        <!-- <div id="header" class="row">
            <div class="col-sm-3" style="padding-left: 30px;">
                <div id="logo"></div>
            </div>
            <div class="col-sm-6">
                <p style="margin: 0; text-align: center;">
                    <span class="page-title">
                        Antrian Pendaftaran Pasien
                    </span>
                    <span id="tab-text"></span>
                </p>
            </div>
            <div class="col-sm-3" style="padding-right: 30px;">
                <p style="margin: 0 15px 0 0; float: right;">
                    <?php //echo "<span style='font-family: oswald; font-size:1.5vw;'>" . strtoupper(hari()) . ",</span>"; ?>
                    <?php
                    // $tgl = date('d');
                    // $tahun = date('Y');
                    // echo "<span style='font-family:oswald;font-size:1.5vw;'>" . $tgl . " " . bulan() . " " . $tahun . " -</span>";
                    ?>
                    <span id="clock" style="display: inline-block; width: 110px;font-family: oswald; font-size: 1.5vw;"></span>
                </p>
            </div>
        </div> -->
        <div class="row">
            <div class="col-sm-4">
                <p style="margin: 0; text-align: center;">
                    <span id="tab-text"></span>
                </p>
            </div>
        </div>
        <div>
            <div class="row">
                
                <div id="penjamin">
                    <div class="col-sm-12" width="100%">
                        <ul class="tab-pilih2 col-sm-2">
                          
                            <!-- <li class="penjamin-tab"></li>
                            <li class="poli-tab"></li>
                            <li class="jeniskunjungan-tab"></a></li> -->
                            <!-- <li class="penjamin-tab"><a onclick="toPenjamin()">1. Jenis Antrian</a></li>
                            <li class="poli-tab"><a onclick="toPoli()">2. Poliklinik</a></li>
                            <li class="jeniskunjungan-tab"><a onclick="toJenisKunjungan()">3. Jenis Kunjungan</a></li>
                            <li class="dokter-tab"><a onclick="return false">4. Dokter</a></li> -->
                            <!-- <li><a href="#">Menu 3</a></li> -->
                        </ul>
                    </div>
                    <div class="item-select col-sm-12">
                        <?php
                        if (count($modLokets) > 0) {
                            $i = 1;
                            foreach ($modLokets as $key => $loket) {

                                // var_dump($loket->attributes); die;

                                $sql = "SELECT MAX(cast(noantrian as integer)) as nomaksimal FROM antrian_t
                                        WHERE DATE(tglantrian)='" . date('Y-m-d') . "'
                                            AND modelantrian_id = " . $loket->modelantrian_id;
                                $antrian = Yii::app()->db->createCommand($sql)->queryRow();

                                if (!isset($antrian['nomaksimal'])) {
                                    $antrian['nomaksimal'] = 0;
                                } ?>
                                <?php $k = "k" . $i ?>
                                <?php
                                $input_even = "#fff";
                                $input_odd = "#fff";

                                if ($i % 2 == 0) {
                                    $card_color = $input_even;
                                } else {
                                    $card_color = $input_odd;
                                }
                                ?>

                                <div class="item-a col-sm-12">
                                    <div class="radius-penjamin tombol loket_<?php echo $loket->modelantrian_id; ?>" onclick="toPoli(<?php echo $loket->modelantrian_id ?>,'<?php echo $loket->modelantrian_kode ?>' )" id="btn-<?php echo strtolower(str_replace(" ", "-", $loket->modelantrian_nama)) ?>" style="background-color:#448074;">
                                        <div class="tombolheader">
                                            <div class="labeltiket">
                                                <?php echo strtoupper($loket->modelantrian_nama); ?>
                                                <!-- <i class="far fa-address-card"></i> -->
                                            </div>
                                        </div>
                                        <div class="tombolbody2">
                                            <hr>                                            
                                            <div class="labeltiket3" >
                                                <div class="setakhir" style="font-size:1.5vw;">ANTRIAN TERAKHIR</div>
                                                <div class="setnomor" style="font-size:1.5vw;"><?php $loket->modelantrian_kode . "-" . $antrian['nomaksimal'];  echo $antrian['nomaksimal']; ?></div>
                                        <!-- <div class="clearfix"></div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                    ?>
                                </div>
                        <?php
                            }
                        } else {
                            echo '<p class="maaf">Maaf, belum ada penjamin.</p>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Poliklik -->
                <div id="poliklinik">
                    <div class="col-sm-12" width="100%">
                        <div class="col-sm-12" width="100%">
                            <ul class="tab-pilih2 col-sm-2">
                                <li class="">
                                    <div class="back-button">                                
                                        <i class="fas fa-long-arrow-alt-left" onclick="toPenjamin()"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="item-select col-sm-12">
                            <?php
                            if (count($modJadwalPolis) > 0) {
                                $i = 1;
                                foreach ($modJadwalPolis as $key => $poli) {
                                   
                            ?>
                                    <?php $k = "k" . $i ?>
                                    <?php
                                    $input_even = "#fff";
                                    $input_odd = "#fff";

                                    if ($i % 2 == 0) {
                                        $card_color = $input_even;
                                    } else {
                                        $card_color = $input_odd;
                                    }
                                    ?>
                                    <div class="item-b col-sm-4"
                                        data-ruangan="<?= $poli->ruangan_id ?>" 
                                        data-loket="<?= $poli->loket_id ?>" 
                                        data-modelantrian="<?= $poli->modelantrian_id ?>"                                   
                                    >
                                        <div class="tombol radius" onclick="toJenisKunjungan(<?php echo $poli->ruangan_id; ?>)" style="background-color:#448074;">
                                            <div class="tombolbody">
                                                <!-- <hr> -->
                                                <div class="labeltiket2" style="color:#fff;">                                           
                                                    <?php echo strtoupper($poli->ruangan->ruangan_nama); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $i++;
                                        ?>
                                    </div>
                            <?php
                                    
                            }
                            } else {
                                echo '<p class="maaf">Maaf, belum ada poliklinik.</p>';
                            }
                            ?>
                            <!-- <p>INI POLI</p> -->
                        </div>
                    </div>
                </div>
                <!-- end poliklinik -->
                
                <!-- start jenis kunjungan -->
                <div id="jeniskunjungan">
                    <div class="col-sm-12" width="100%">
                        <div class="col-sm-12" width="100%">
                            <ul class="tab-pilih2 col-sm-2">
                                <li class="">
                                    <div class="back-button">                                
                                        <i class="fas fa-long-arrow-alt-left" onclick="toPenjamin(<?php echo $poli->ruangan_id; ?>)"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="item-select col-sm-12">
                        <?= $this->renderPartial($this->pathView_umum_asuransi.'form/_jenisKunjungan',['model'=>$model], true) ?>
                        </div>
                    </div>
                </div>
                <!-- end jeniskunjungan -->
                
                <!-- dokter -->
                <div id="dokter" class="item-select doktertext"></div>
                <!-- end dokter -->
                <!-- <div class="row">
          <div class="col-xs-11" style="margin-top: 30px;position: center;">
            <div class="borderline">
              <p style="font-size:24px"><b>Perhatian</b></p>
              <ol>
                <li>Untuk ke Poliklinik dengan jaminan Umum</li>
                <li>Untuk ke Poliklinik dengan jaminan Asuransi / BPJS</li>
                <li>Untuk ke Laboratorium Langsung (APS)</li>
                <li>Untuk ke Radiologi Langsung (APS)</li>
              </ol>
            </div>
          </div>
        </div> -->
            </div>
            <div class="row">
                <div class="block-footer-antrian">
                    <div id="footerAntrian">
                        <marquee direction="left" scrollamount="10" id="textrunning">
                            <?php echo $config->running_text_kiosk; ?>
                        </marquee>
                    </div>
                    <div id="footerClock"></div>
                </div>
            </div>
        </div>
        <iframe id="print_win" src="" style="display: none;"></iframe>
        <br>
    </div>
    </div>
    <?php $this->endWidget(); ?>
</body>

</html>
<?php $konfig = KonfigsystemK::model()->find(); 

$this->renderPartial($this->pathView_umum_asuransi.'_dialog',[]);
?>
<script type="text/javascript">
    var socket;

    function simpan() {
        //salin ke form
        // console.log(pegawai_id)
        // if(!$(obj).hasClass("disabled")){
        //post form
        // $("button").attr("disabled");
        // $("button").addClass("disabled");
        // $.ajax({
        //   type:'POST',
        //   url:'<?php //echo $this->createUrl('SimpanTiket');
                    ?>',
        //   data: {
        //     pegawai_id:$("#<?php //echo CHtml::activeId($model, "pegawai_id")
                                ?>").val(),
        //     // data:$("#antrian-form").serialize(),
        //   },//
        //   dataType: "json",
        //   success:function(data){
        //     var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
        //     <?php //if($konfig->is_nodejsaktif){
                ?>
        //       socket.emit('send',{conversationID:'antrian',modelantrian_id: $("#<?php //echo CHtml::activeId($model, "modelantrian_id")
                                                                                    ?>").val()});
        //     <?php //}
                ?>
        //     // $("#"+obj).find(".setnomor").html(data.loket_singkatan+'-'+data.model.noantrian);
        //     print(data.model.antrian_id);
        //     setTimeout(function(){
        //       $("button").removeAttr("disabled");
        //       $("button").removeClass("disabled");
        //     },delaytombol);
        //   },
        //   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        // });
        // }
    }

    function toPenjamin(modelantrian_id) {
        $("#penjamin .item-a").show();
        $("#penjamin #item-checkin").hide();

        $('#penjamin').show();
        $('#poliklinik').hide();
        $('#jeniskunjungan, #dokter').hide();
        $('.penjamin-tab').removeClass('past');
        $('.poli-tab').removeClass('past');
        $('.penjamin-tab').addClass('active');
        $('.poli-tab').removeClass('active');
        $('.dokter-tab').removeClass('active');
        $('#tab-text').html('Silahkan Ambil Antrian')
        $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(modelantrian_id);
        
        formJenisKunjungan();
    }

    var model_kode = null;




    function toPoli2(modelantrian_id, modelantrian_kode) {

$("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(modelantrian_id);
if (typeof modelantrian_kode != undefined && modelantrian_kode != null) {
    model_kode = modelantrian_kode;
}

$("#poliklinik").find(".item-b").show();
if (modelantrian_kode == 'L' || modelantrian_kode == 'R' || modelantrian_kode == 'K') {
    toNomorLangsung(modelantrian_id, modelantrian_kode);
} else {
    $('#penjamin').hide();
    $('#poliklinik').show();
    $('#jeniskunjungan').show();
    
    $('.penjamin-tab').addClass('past');
    $('.poli-tab').removeClass('past');
    $('.penjamin-tab').removeClass('active');
    $('.poli-tab').addClass('active');
    $('.jeniskunjungan-tab,.dokter-tab').removeClass('active');
    formJenisKunjungan();
    
    $("#poliklinik").find(".item-b[data-modelantrian='"+modelantrian_id+"']").show();
    // $('#tab-text').html('Silakan Pilih Poliklinik Tujuan')
}

// console.log(modelantrian_kode)

}


    function toPoli(modelantrian_id, modelantrian_kode) {

        $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(modelantrian_id);
        if (typeof modelantrian_kode != undefined && modelantrian_kode != null) {
            model_kode = modelantrian_kode;
        }
        
        $("#poliklinik").find(".item-b").hide();
        if (modelantrian_kode == 'L' || modelantrian_kode == 'R' || modelantrian_kode == 'K') {
            toNomorLangsung(modelantrian_id, modelantrian_kode);
        } else {
            $('#penjamin').hide();
            $('#poliklinik').show();
            $('#jeniskunjungan, #dokter').hide();
            
            $('.penjamin-tab').addClass('past');
            $('.poli-tab').removeClass('past');
            $('.penjamin-tab').removeClass('active');
            $('.poli-tab').addClass('active');
            $('.jeniskunjungan-tab,.dokter-tab').removeClass('active');
            formJenisKunjungan();
            
            $("#poliklinik").find(".item-b[data-modelantrian='"+modelantrian_id+"']").show();
            
            // $('#tab-text').html('Silakan Pilih Poliklinik Tujuan')
        }

        // console.log(modelantrian_kode)

    }
    
    function toJenisKunjungan(ruangan_id){
        $("#ruanganpoli_pilih").val(ruangan_id);
        
        $('#penjamin').hide();
        $('#poliklinik,#dokter').hide();
        $("#jeniskunjungan").show();
        
        $('.penjamin-tab').addClass('past');
        $('.poli-tab,.dokter-tab').addClass('past');
        
        $('.poli-tab,.dokter-tab').removeClass('active');
        $('.jeniskunjungan-tab').addClass('active');     
        
        formJenisKunjungan();
        
    }
    
    function formJenisKunjungan(jeniskunjungan = 'utama'){
        $("[data-form-jenis-kunjungan]").hide();
        
        $("[data-form-jenis-kunjungan='"+jeniskunjungan+"']").show();    
        
        clearJenisKunjungan();
    }
    
    function cekJenisKunjungan(jeniskunjungan){
        const ruanganId = $("#ruanganpoli_pilih").val();
        
        const words = jeniskunjungan.split(" ");

        for (let i = 0; i < words.length; i++) {
            words[i] = words[i][0].toUpperCase() + words[i].substr(1);
        }
        $(".jenis_kunjungan").val(words.join(" "));
        
        if (ruanganId == ''){
            alert("poliklinik belum dipilih");
            return false;
        }
        
        if (jeniskunjungan == 'sekarang'){
            // toDokter(ruanganId);
            setDokterDanPrint(ruanganId)
        }else{
            formJenisKunjungan(jeniskunjungan);
        }
        
    }
    
    function setReservasi(){
        const tgldilayani = $("#tglakandilayani").val();        
        const form = $("[data-form-jenis-kunjungan='reservasi']");
        const ruanganId = $("#ruanganpoli_pilih").val();        
        
        $("#tglakandilayani").attr("style","");
        if (tgldilayani != ''){
            setDokterDanPrint(ruanganId,form,tgldilayani)
        }else{
            alert("Tanggal dilayani harus diisi");
            $("#tglakandilayani").attr("style","border:red 1px solid;");
        }
        
        return false;
    }
    
    function setFasttrack(){
        const ruanganId = $("#ruanganpoli_pilih").val();        
        const form = $("[data-form-jenis-kunjungan='fast track']");
  

        
        let kosong = 0;
        
        form.attr("style","");
        form.find(".required").each(function(){
            if ($(this).val() == ''){
                kosong++;
                $(this).attr("style","border:red 1px solid;");
            }
        });
        
        if (kosong > 0){
            alert("Inputan mandatory harus diisi");
        }else{
            $.ajax({
                type: 'GET',
                url: '<?php echo $this->createUrl('cekNoRm'); ?>',
                data: form.find("input,textarea").serialize(), //
                dataType: "json",
                success: function(data) {
                    if (data.ada){
                              
               setDokterDanPrint(ruanganId,form)
                        // toDokter(ruanganId);
                    }else{
                        setDokterDanPrint(ruanganId,form)
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });            
        }
        return false;
    }
    
    function clearJenisKunjungan(){
        $("[data-form-jenis-kunjungan='fast track'],[data-form-jenis-kunjungan='reservasi']").find("input,textarea").removeAttr("style").val("");
    }

    function toDokter(ruangan_id) {
        $('#penjamin').hide();
        $('#poliklinik').hide();
        $('#jeniskunjungan').hide();
        
        $('.penjamin-tab').addClass('past');
        $('.poli-tab').addClass('past');
        $('.jeniskunjungan-tab').addClass('past');
        
        $('.penjamin-tab').removeClass('active');
        $('.poli-tab,.jeniskunjungan-tab').removeClass('active');
        $('.dokter-tab').addClass('active');
        // $('#tab-text').html('Silakan Pilih Dokter Tujuan')
        $("#<?php echo CHtml::activeId($model, "ruangan_id") ?>").val(ruangan_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDokter'); ?>',
            data: {
                ruangan_id: ruangan_id,
                kode: model_kode,                
            }, //
            dataType: "json",
            success: function(data) {
                // console.log(data)
                $('#dokter').html(data)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        $('#dokter').show();
    }

    toPenjamin();
    formJenisKunjungan();

    function setDokterDanPrint(ruangan_id) {
        
    $("#<?php echo CHtml::activeId($model, "ruangan_id") ?>").val(ruangan_id);
    var pegawai_id = 
    $("#<?php echo CHtml::activeId($model, "pegawai_id") ?>")
    .val(<?php Yii::app()->user->id; ?>);
    if ($("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val() == "") {
        alert('Pilih antrian terlebih dahulu');
        return false;
    }
    if ($("#<?php echo CHtml::activeId($model, "ruangan_id") ?>").val() == "") {
        alert('Pilih poliklinik terlebih dahulu');
        return false;
    }
        
    // console.log('asfasjfhasjkhf')
    // simpan()
    $("button").attr("disabled");
    $("button").addClass("disabled");
    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('SimpanTiket'); ?>',
        data: {
            pegawai_id: pegawai_id,
            data: $("#antrian-form").serialize(),
        }, //
        dataType: "json",
        success: function(data) {
            if(data.antrianpenuh != 1) {
                var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
                <?php if ($konfig->is_nodejsaktif) { ?>
                    socket.emit('send', {
                        conversationID: 'antrian',
                        modelantrian_id: $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val()
                    });
                <?php } ?>
                print(data.model.antrian_id);
                $(".loket_" + data.model.modelantrian_id + " .setnomor").html(data.loket_singkatan + "-" + data.model.noantrian);
            
                $("#dokter_" + data.model.pegawai_id).find(".total_tiket").html(data.total);
                $("#dokter_" + data.model.pegawai_id).find(".total_tiket_u").html(data.total_u);
                $("#dokter_" + data.model.pegawai_id).find(".total_tiket_b").html(data.total_b);
    
            } else {
                myAlert('Tidak Dapat Ambil Antrian. Antrian Sudah Penuh');
            }
            clearJenisKunjungan();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });

    toPenjamin();
    }
    function setDokter(pegawai_id, modelantrian_kode) {

        $("#<?php echo CHtml::activeId($model, "pegawai_id") ?>").val(pegawai_id);
        if ($("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val() == "") {
            alert('Pilih antrian terlebih dahulu');
            return false;
        }
        if (modelantrian_kode != 'L' && modelantrian_kode != 'R') {
            console.log(modelantrian_kode)
            if ($("#<?php echo CHtml::activeId($model, "ruangan_id") ?>").val() == "") {
                alert('Pilih poliklinik terlebih dahulu');
                return false;
            }
        }

        // console.log('asfasjfhasjkhf')
        // simpan()
        $("button").attr("disabled");
        $("button").addClass("disabled");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SimpanTiket'); ?>',
            data: {
                pegawai_id: pegawai_id,
                data: $("#antrian-form").serialize(),
            }, //
            dataType: "json",
            success: function(data) {
                var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
                <?php if ($konfig->is_nodejsaktif) { ?>
                    socket.emit('send', {
                        conversationID: 'antrian',
                        modelantrian_id: $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val()
                    });
                <?php } ?>
                print(data.model.antrian_id);
                $(".loket_" + data.model.modelantrian_id + " .setnomor").html(data.loket_singkatan + "-" + data.model.noantrian);
            
                $("#dokter_" + data.model.pegawai_id).find(".total_tiket").html(data.total);
                $("#dokter_" + data.model.pegawai_id).find(".total_tiket_u").html(data.total_u);
                $("#dokter_" + data.model.pegawai_id).find(".total_tiket_b").html(data.total_b);

                clearJenisKunjungan();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

        toPenjamin();
    }

    function toNomorLangsung(id, kode) {
        $("button").attr("disabled");
        $("button").addClass("disabled");
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SimpanTiketLangsung'); ?>',
            data: {
                modelantrian_id: id,
                modelantrian_kode: kode
            }, //
            dataType: "json",
            success: function(data) {
                var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
                <?php if ($konfig->is_nodejsaktif) { ?>
                    socket.emit('send', {
                        conversationID: 'antrian',
                        modelantrian_id: $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val()
                    });
                <?php } ?>
                print(data.model.antrian_id);
                console.log("Print ke-2");
//                setTimeout(function() {
//                    printLangsung(data.model.antrian_id);
//                }, 2000); // akan diprint kembali 2 detik setelah print pertama
                $(".loket_" + data.model.modelantrian_id + " .setnomor").html(data.loket_singkatan + "-" + data.model.noantrian);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function print(antrian_id) {
        $("#print_win").attr('src', "<?php echo $this->createUrl('Print') ?>&antrian_id=" + antrian_id);
    }

    function printLangsung(antrian_id) {
        console.log("PRINT!!!");
        $("#print_win").attr('src', "<?php echo $this->createUrl('PrintLangsung') ?>&antrian_id=" + antrian_id);
    }

    function tampilkanRunningText() {
        $.post('<?php echo $this->createUrl('getRunningText') ?>', {}, function(data) {
            $('#textrunning').html(data);
        }, 'json');
    }
    // tampilkanRunningText();
    // setInterval(  // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
    //   function(){
    //     tampilkanRunningText()
    //     return false;
    //   },
    //   50000 // fungsi di eksekusi setiap 50 detik sekali
    // );
    // function tampilkanwaktu() {     //fungsi ini akan dipanggil di bodyOnLoad dieksekusi tiap 1000ms = 1detik
    //   var waktu = new Date();      //membuat object date berdasarkan waktu saat
    //   var sh = waktu.getHours() + "";  //memunculkan nilai jam, //tambahan script + "" supaya variable sh bertipe string sehingga bisa dihitung panjangnya : sh.length  //ambil nilai menit
    //   var sm = waktu.getMinutes() + ""; //memunculkan nilai detik
    //   var ss = waktu.getSeconds() + ""; //memunculkan jam:menit:detik dengan menambahkan angka 0 jika angkanya cuma satu digit (0-9)
    //   document.getElementById("clock").innerHTML = (sh.length == 1 ? "0" + sh : sh) + ":" + (sm.length == 1 ? "0" + sm : sm) + ":" + (ss.length == 1 ? "0" + ss : ss);
    // }
    $(document).ready(function() {
        clockUpdate();
        setInterval(clockUpdate, 1000);

        if($('#penjamin').show()){
            $('#backpenjamin').show()
            $('#backpoli').hide();
        }else{
            $('#backpenjamin').hide();
            $('#backpoli').show();
        }
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
        $('.clock').text(h + ':' + m + ':' + s)
    }
    // function startTime() {
    //      var today = new Date();
    //      $('.clock').css({'color': '#fff', 'text-shadow': '0 0 6px #ff0'});
    //
    //      // var h = today.getHours();
    //      // var m = today.getMinutes();
    //      // var s = today.getSeconds();
    //      // m = checkTime(m);
    //      // s = checkTime(s);
    //      function addZero(x) {
    //       if (x < 10) {
    //        return x = '0' + x;
    //       } else {
    //        return x;
    //       }
    //      }
    //
    //      function twelveHour(x) {
    //       if (x > 12) {
    //        return x = x - 12;
    //       } else if (x == 0) {
    //        return x = 12;
    //       } else {
    //        return x;
    //       }
    //      }
    //
    //      var h = addZero(twelveHour(today.getHours()));
    //      var m = addZero(today.getMinutes());
    //      var s = addZero(today.getSeconds());
    //
    //      document.getElementById('clock').innerHTML =
    //          h + ":" + m + ":" + s;
    //      var t = setTimeout(startTime, 500);
    //    }
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
        
        
    function setPasienLama(data){
        $("#<?= CHtml::activeId($model, 'nama_pasien') ?>").val(data.nama_pasien);
        $("#<?= CHtml::activeId($model, 'no_rekam_medik') ?>").val(data.no_rekam_medik);
        
        $("#dialogPasien").dialog("close");
    }
    
    function refreshGridPasien(){
        $.fn.yiiGridView.update('pasien-m-grid',{
            data:{
                'PPPasienM[default]':''
            }
        })
    }
    
    $(document).ready(function() {
        $('#poliklinik').hide();
        <?php if ($konfig->is_nodejsaktif) { ?>
            var chatServer = '<?php echo $konfig->nodejs_host ?>';
            if (chatServer == '') {
                chatServer = 'http://localhost';
            }
            var chatPort = '<?php echo $konfig->nodejs_port ?>';
            socket = io.connect(chatServer + ':' + chatPort);
            socket.emit('subscribe', 'antrian');
        <?php } ?>
            
        $(".item-select").css("background","");
        $(".item-select").css("height", document.body.clientHeight);
    });
</script>