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
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$config = KonfigsystemK::model()->find();
?>

<style>
    html {
        /* background: url(<?php //echo Yii::app()->request->baseUrl; 
                            ?>/images/tampilan_antrian_pendaftaran/TAMPILAN_ANTRIAN_PENDAFTARAN_bg-02polos.png) center center no-repeat; */
        /* background: url(<?php //echo Yii::app()->request->baseUrl; 
                            ?>/images/login_mixed_new.jpg) center center no-repeat; */
        /* background-size: cover;
        background-attachment: fixed; */
    }

    body {
        /* width: 100%;
        height: 100%; */
        /* padding-bottom: 70px; */
        background: none;
    }

    .background {
        position: fixed;
        left: 0;
        top: 0;
        z-index: -100;
        width: 100vw;
        height: 100vh;
        background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/tampilan_antrian_pendaftaran/TAMPILAN_ANTRIAN_PENDAFTARAN_bg-02polos.jpg") center center no-repeat;
        /* background: url("<?php //echo Yii::app()->request->baseUrl; 
                            ?>/images/jadwal_dokter/BG-Jadwal-Dokter-06.jpg") center center no-repeat; */
        /* background: url("<?php //echo Yii::app()->request->baseUrl; 
                            ?>/images/antrian/antrianbaru.jpg") center center no-repeat; */
        background-size: cover;
    }

    #header {
        display: flex;
        align-items: center;
        height: 120px;
        width: calc(100% - 15px);
        margin: 15px 0 15px;
    }

    #social-media {
        position: absolute;
        text-align: right;
        width: 95%;
        height: 50px;
        z-index: 50;
    }

    .backpanggil {
        /* background-color: #00df92; */
        margin: 0 50px;
        background: none;
        /* padding-top: 50px ; */
        font-family: oswald;
        /* text-align: center; */
        font-weight: bold;
    }

    #logo {
        float: left;
        width: 100%;
        height: 70px;
        background: url("<?php echo Params::urlProfilRSDirectory() . $data->logo_rumahsakit; ?>") left center no-repeat;
        background-size: contain;
    }

    #BGKotak {
        /* float: center; */
        width: 100%;
        height: 500px;
        background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/jadwal_dokter/BG_flow.png") center center no-repeat;
        background-size: 100% 100%;
            box-shadow: 0 0 5px rgba(0, 0, 0, .5);
            margin-bottom: 50px;
    }

    .deep-box {
        /* background-color: #006838; */
        padding-top: 50px;
        padding-left: 50px;
        padding-right: 50px;
        width: 100%;
    }

    #button-tiket {
        padding: 0 !important;
        vertical-align: middle !important;
    }

    .entypo-print {
        margin: 0px !important;
        /* display: block; */
        margin: 40px 0;
        left: 0px !important;
    }
.hovereffect{
    margin: 20px 30px;
}
    .btn-danger {
        background-color: #00df92;
        border-color: #00df92;
    }

    .keterangan {
        font-size: 20px;
        font-weight: bold;
        color: grey;
        text-align: center;
    }

    .bases {
        /* text-align: center !important; */
        width: 100%;
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
        width: 100%;
        left: 0;
        bottom: 0;
    }

    .list-jadwal {
        border-collapse: collapse;
    }

    .list-jadwal td,
    .list-jadwal th {
        border: 1px solid #ddd;
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
        border: 2px solid #00df92;
        border-radius: 10px;
    }

    .tombol {
        width: 100%;
        /* padding-bottom: 20px; */
        border-radius: 10px;
        cursor: pointer;
        background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, .5);
    }

    .tombolicon {
        font-size: 72pt;
        color: white;
    }

    .tombolicon table td {
        height: 110px;
        vertical-align: middle;
        text-align: center;
    }

    .labeltiket {
        font-size: 13pt;
        color: #006838;
        font-family: oswald;
        /* text-align: center; */
        font-weight: bold;
        padding: 5px 10px;
        text-decoration: none;
    }

    .setakhir {
        font-size: 12pt;
    }

    .borderline ol {
        margin: 0 !important;
    }

    .borderline li {
        display: block;
        margin: 0 auto;
        width: 350px;
        text-align: left;
    }

    .title {
        margin: 15px 50px;
        font-size: 2vw;
        font-family: oswald;
        font-weight: bold;
    }

    .title .img {
        padding: 10px 0;
        background: #fff;
    }

    .title .text {
        padding: 10px 0;
        /* background: #377fb7; */
        color: #006838;
        text-transform: uppercase;
        font-size: 30px;
    }

    .form-horizontal {
        padding: 0 15px
    }

    .tombol-tiket {
        transition: .25s;
    }

    .tombol-tiket:hover {
        filter: brightness(80%);
    }

    /* .labeltiket {
        padding-top: 15px;
    } */

    .gambar {
        display: block;
        margin: 40px 0;
    }
</style>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'antrian-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
));
?>

<!-- <div id="refresh">
    <?php
    // echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), "javascript:void(0);", array(
    //     'onclick' => "window.location.href = window.location.href"
    // ));
    ?>
</div> -->
<div class="background"></div>

<?php echo $form->hiddenField($model, 'modelantrian_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'ruangan_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'carabayar_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'statuspasien', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'carabayar_loket', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'loket_id', array('readonly' => true)); ?>
<?php echo $form->hiddenField($model, 'noantrian', array('readonly' => true)); ?>

<div class="bases">
    <div class="title">
        <!-- <div class="img"><img style="height: 100px;" src="<?php //echo Params::urlProfilRSDirectory() . $config->logolayarantrian 
                                                                ?>" id="logo" /></div> -->
        <div id="logo"></div>
        <div id="social-media">
            <a href=""><img style="height:20px; padding:0 5px;" src="images/logo_rssacpt/IG-Sari-Asih-07.png" /></a>
            <a href=""><img style="height:20px; padding:0 5px;" src="images/logo_rssacpt/FB-Sari-Asih-07.png" /></a>
            <a href=""><img style="height:15px; padding:0 5px;" src="images/logo_rssacpt/YT-Sari-Asih-07.png" /></a>
            <a href=""><img style="height:20px; padding:0 5px;" src="images/logo_rssacpt/WEB-Sari-Asih-07.png" /></a>
        </div>
        <div class="text" align="center"><b>Silahkan Ambil Antrian</b></div>
    </div>

    <div class="backpanggil">
        <div id="BGKotak" style="color: #006838;">
            <!-- <div style="width: 100%; background-color:#006838;"> -->
            <div class="deep-box">
                <div style="width: 33.33333333%; float:left; font-size:15px;">
                    <div class="text" style="text-align: center !important;"><b>MENU ANTRIAN PENDAFTARAN</b></div>
                    <div class=""  style="width: 100%;">
                        <?php
                        if (count($modLokets1) > 0) {
                            $i = 1;
                            foreach ($modLokets1 as $key => $loket) {

                                $nama =  strtolower(str_replace(" ", "-", $loket->modelantrian_nama));
                                $kode = "btn-" . strtolower($loket->modelantrian_kode);
                                $gambar = "";
                                if (!empty($loket->modelantrian_gambar)) {
                                    $gambar = Params::urlProfilRSDirectory() . $loket->modelantrian_gambar;
                                }
                                $warna = $loket->modelantrian_warna;
                        ?>
                                <div class='hovereffect col-xs-4'>

                                    <div class="tombol  btn-tiket1 tombol-tiket" id="<?php $kode ?>" onclick="simpan(this,<?php echo $loket->modelantrian_id ?>)">

                                        <div class="tombolbody">
                                            <div class="labeltiket">
                                                <div id="button-tiket">
                                                    <!-- <span class="fl"> -->
                                                    <?php
                                                    if (empty($gambar)) {
                                                    ?>
                                                        <i class="entypo-print"></i>
                                                    <?php } else { ?>
                                                        <!-- <center> -->
                                                            <i class="gambar" style="width: 50px; height: 50px;"><img src="<?php echo $gambar; ?>" /></i>
                                                        <!-- </center> -->

                                                    <?php } ?>
                                                    <!-- </span>
                                                    <span class="fl"> -->
                                                    <?php echo strtoupper($loket->modelantrian_nama); ?>
                                                    <!-- </span> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                    ?>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div style="width: 33.33333333%; float:left; font-size:15px;">
                    <div class="text" style="text-align: center !important;"><b>MENU ANTRIAN LABORATORIUM</b></div>
                    <div class=""  style="width: 100%;">
                        <?php
                        if (count($modLokets2) > 0) {
                            $i = 1;
                            foreach ($modLokets2 as $key => $loket) {

                                $nama =  strtolower(str_replace(" ", "-", $loket->modelantrian_nama));
                                $kode = "btn-" . strtolower($loket->modelantrian_kode);
                                $gambar = "";
                                if (!empty($loket->modelantrian_gambar)) {
                                    $gambar = Params::urlProfilRSDirectory() . $loket->modelantrian_gambar;
                                }
                                $warna = $loket->modelantrian_warna;
                        ?>
                                <div class='hovereffect col-xs-4'>

                                    <div class="tombol  btn-tiket1 tombol-tiket" id="<?php $kode ?>" onclick="simpan(this,<?php echo $loket->modelantrian_id ?>)">

                                        <div class="tombolbody">
                                            <div class="labeltiket">
                                                <div id="button-tiket">
                                                    <?php
                                                    if (empty($gambar)) {
                                                    ?>
                                                        <i class="entypo-print"></i>
                                                    <?php } else { ?>
                                                        <center>
                                                            <i class="gambar" style="width: 50px; height: 50px"><img src="<?php echo $gambar; ?>" /></i>
                                                        </center>

                                                    <?php } ?>
                                                    <?php echo strtoupper($loket->modelantrian_nama); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                    ?>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div style="width: 33.33333333%; float:left; font-size:15px;">
                    <div class="text" style="text-align: center !important;"><b>MENU ANTRIAN KASIR</b></div>
                    <div class=""  style="width: 100%;">
                        <?php
                        if (count($modLokets3) > 0) {
                            $i = 1;
                            foreach ($modLokets3 as $key => $loket) {

                                $nama =  strtolower(str_replace(" ", "-", $loket->modelantrian_nama));
                                $kode = "btn-" . strtolower($loket->modelantrian_kode);
                                $gambar = "";
                                if (!empty($loket->modelantrian_gambar)) {
                                    $gambar = Params::urlProfilRSDirectory() . $loket->modelantrian_gambar;
                                }
                                $warna = $loket->modelantrian_warna;
                        ?>
                                <div class='hovereffect col-xs-4'>

                                    <div class="tombol  btn-tiket1 tombol-tiket" id="<?php $kode ?>" onclick="simpan(this,<?php echo $loket->modelantrian_id ?>)">

                                        <div class="tombolbody">
                                            <div class="labeltiket">
                                                <div id="button-tiket">
                                                    <?php
                                                    if (empty($gambar)) {
                                                    ?>
                                                        <i class="entypo-print"></i>
                                                    <?php } else { ?>
                                                        <center>
                                                            <i class="gambar" style="width: 50px; height: 50px"><img src="<?php echo $gambar; ?>" /></i>
                                                        </center>

                                                    <?php } ?>
                                                    <?php echo strtoupper($loket->modelantrian_nama); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                    ?>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <!-- <div style="width: 33.33333333%; float:left; font-size:15px;">
                    <div class="text"><b>MENU ANTRIAN KASIR</b></div>
                </div> -->
            </div>
        </div>
        <!-- <table style="width: 100%; border: none;">
            <tr>
                <?php
                // if (count($modLokets) > 0) {
                //     $i = 1;
                //     foreach ($modLokets as $key => $loket) {

                //         $nama =  strtolower(str_replace(" ", "-", $loket->modelantrian_nama));
                //         $kode = "btn-" . strtolower($loket->modelantrian_kode);
                //         $gambar = "";
                //         if (!empty($loket->modelantrian_gambar)) {
                //             $gambar = Params::urlProfilRSDirectory() . $loket->modelantrian_gambar;
                //         }
                //         $warna = $loket->modelantrian_warna;
                ?>
                        <?php //$k = "k" . $i ?>
                        <?php
                        // $input = array("#fe344d", "#00d692", "#616ce6", "#f8005f", "#ab00b0", "#00bbd6", "#009d88", "#5E7B8B");
                        // $rand_keys = array_rand($input);
                        ?>
                        <td>
                            <div class='hovereffect col-xs-4'>

                                <div class="tombol  <?php //echo $k ?>btn-tiket1 tombol-tiket" style="background-color:<?php //echo !empty($warna) ? $warna : $input[$rand_keys] ?>" id="<?php //$kode ?>" onclick="simpan(this,<?php //echo $loket->modelantrian_id ?>)">


                                    <div class="tombolheader">
                                        <div class="tombolicon">
                                            <table style="width: 100%; border: none;">
                                                <tr>
                                                    <td>
                                                        <?php
                                                        // if (empty($gambar)) {
                                                        ?>
                                                            <i class="entypo-print"></i>
                                                        <?php //} else { ?>
                                                            <center>

                                                                <i class="gambar" style="width: 90px; height: 90px"><img src="<?php //echo $gambar; ?>" /></i>
                                                            </center>

                                                        <?php //} ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tombolbody">
                                        <div style="border:1px solid white;margin-left:20px; margin-right: 20px;"></div>
                                        <div class="labeltiket">
                                            ANTRIAN <br>
                                            <?php //echo strtoupper($loket->modelantrian_nama); ?>
                                        </div>
                                        <div class="labeltiket">
                                            <div class="setakhir">ANTRIAN AKHIR</div>
                                            <div class="setnomor">0-000</div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                // $i++;
                                ?>
                            </div>
                        </td>
                <?php
                //     }
                // }
                ?>
            </tr>
        </table> -->
        <!-- </div> -->
    </div>

    <!-- <div class="col-sm-12">
        <div style="margin-top: 30px;position: center;">
            <div class="borderline" style="color: #fff;">
                <p style="font-size:24px"><b>Perhatian</b></p>
                <ol>
                    <li>1. Untuk ke Poliklinik dengan jaminan Umum</li>
                    <li>2. Untuk ke Poliklinik dengan jaminan Asuransi / BPJS</li>
                    <li>3. Untuk ke Laboratorium Langsung (APS)</li>
                    <li>4. Untuk ke Radiologi Langsung (APS)</li>
                </ol>
            </div>
        </div>

    </div> -->
    <iframe id="print_win" src="" style="display: none;"></iframe>

    <div class="block-footer-antrian">
        <div id="footerAntrian" style="width: 100%; color:#006838;">
            <marquee direction="left" scrollamount="10" id="textrunning">
                <?php echo Yii::app()->user->getState('running_text_kiosk'); ?>
            </marquee>
        </div>
        <!-- <div id="footerClock">
            <div id="clock"></div>
        </div> -->
    </div>
</div>

<?php $this->endWidget(); ?>
<?php $konfig = KonfigsystemK::model()->find(); ?>

<script type="text/javascript">
    var socket;

    function simpan(obj, loket_id) {
        //salin ke form
        if (!$(obj).hasClass("disabled")) {
            $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(loket_id);
            // $("#<?php echo CHtml::activeId($model, "carabayar_id") ?>").val(carabayar_id);
            //post form
            $("button").attr("disabled");
            $("button").addClass("disabled");
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('SimpanTiket'); ?>',
                data: {
                    data: $("#antrian-form").serialize()
                }, //
                dataType: "json",
                success: function(data) {
                    var delaytombol = parseInt(data.delaytombol) * parseInt(1000);
                    <?php if ($konfig->is_nodejsaktif) { ?>
                        socket.emit('send', {
                            conversationID: 'antrian',
                            modelantrian_id: loket_id
                        });
                    <?php } ?>
                    $(obj).find(".setnomor").html(data.loket_singkatan + '-' + data.model.noantrian);
                    print(data.model.antrian_id);
                    setTimeout(function() {
                        $("button").removeAttr("disabled");
                        $("button").removeClass("disabled");
                    }, delaytombol);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    }

    function print(antrian_id) {
        console.log(antrian_id)
        $("#print_win").attr('src', "<?php echo $this->createUrl('Print') ?>&antrian_id=" + antrian_id);
    }

    function tampilkanRunningText() {
        $.post('<?php echo $this->createUrl('getRunningText') ?>', {}, function(data) {
            $('#textrunning').html(data);
        }, 'json');
    }
    tampilkanRunningText();
    setInterval( // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
        function() {
            tampilkanRunningText()
            return false;
        },
        50000 // fungsi di eksekusi setiap 50 detik sekali
    );
    $(document).ready(function() {
        <?php if ($konfig->is_nodejsaktif) { ?>
            var chatServer = '<?php echo $konfig->nodejs_host ?>';
            if (chatServer == '') {
                chatServer = 'http://localhost';
            }
            var chatPort = '<?php echo $konfig->nodejs_port ?>';
            socket = io.connect(chatServer + ':' + chatPort);
            socket.emit('subscribe', 'antrian');
        <?php } ?>
    });
</script>