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
        body {
            background-color: #efefef;
            margin-left: 20px;
            margin-right: auto;
            /* warna text ciputat */
            color: #006838;
        }

        .background {
            position: fixed;
            left: 0;
            top: 0;
            z-index: -100;
            width: 100vw;
            height: 100vh;
            background: url("<?php echo Yii::app()->request->baseUrl; ?>/images/jadwal_dokter/BG-06.jpg") center center no-repeat;
            /* background: url("<?php //echo Yii::app()->request->baseUrl; 
                                ?>/images/antrian/antrianbaru.jpg") center center no-repeat; */
            background-size: cover;
            /* filter: blur(25px) brightness(125%);
            -webkit-filter: blur(25px) brightness(125%);
            -moz-filter: blur(25px) brightness(125%); */
        }

        #header {
            display: flex;
            align-items: center;
            height: 40px;
            width: calc(100% - 15px);
            margin: 15px 0 15px;
            /* background: rgba(255, 255, 255, .85); */
        }

        #social-media {
            position: absolute;
            text-align: right;
            width: 100%;
            height: 50px;
            z-index: 50;
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
            padding-top: 80px;
            display: block;
            margin: 10px 0;
            font-size: 2rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .tab-pilih {
            margin: 0 15px;
            padding: 5px 0;
            background: #efefef;
            border: 2px solid #ddd;
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
            justify-content: center;
            position: relative;
            height: calc(100vh - 245px);
            overflow-y: auto;
            margin: 0 15px;
            padding: 15px 0;
            background: rgba(255, 255, 255, .5);
            text-align: center;
            border: 2px solid #ddd;
            border-top: none;
            border-radius: 0 0 15px 15px;
        }
        .ambilantrian{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            position: relative;
            height: calc(100vh - 200px);
            overflow-y: auto;
            margin: 0 15px;
            padding: 15px 0;
            background-image: url(images/jadwal_dokter/BG-06.png)center center no-repeat;
            /* background: rgba(255, 255, 255, .5); */
            text-align: center;
            border: 2px solid #006838;
            /* border-top: none; */
            border-radius: 15px 15px;
        }
        .item-select>p {
            margin: 0;
            padding: 20px 50px 15px;
            font-size: 1.2rem;
        }

        .item-a {
            display: flex;
            flex-wrap: wrap;
            flex: 1 0 22%;
            max-width: calc(25% - 30px);
            vertical-align: top;
            top: 0;
            width: calc(24% - 30px);
            margin: 15px;
        }

        .item-b {
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
            border: none;
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
    <?php echo $form->hiddenField($model, 'modelantrian_id', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'ruangan_id', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'carabayar_id', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'statuspasien', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'carabayar_loket', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'loket_id', array('readonly' => true)); ?>
    <?php echo $form->hiddenField($model, 'noantrian', array('readonly' => true)); ?>

    <!-- <div class="col-sm-4"> -->
        <div id="logo"></div>
    <!-- </div> -->
    <!-- <div class="col-sm-4"> -->
    <div id="social-media">
        <a href=""><img style="height:30px;" src="images/jadwal_dokter/IG-Sari-Asih-07.png"/></a>
        <a href=""><img style="height:30px;" src="images/jadwal_dokter/FB-Sari-Asih-07.png"/></a>
        <a href=""><img style="height:30px;" src="images/jadwal_dokter/YT-Sari-Asih-07.png"/></a>
        <a href=""><img style="height:30px;" src="images/jadwal_dokter/WEB-Sari-Asih-07.png"/></a>
    </div>
    <!-- </div> -->
    <div class="bases">
        <!-- <div id="header"></div> -->
        <div class="row">
            <div class="col-sm-4">
                <p style="margin: 0; text-align: center;">
                    <span id="tab-text"></span>
                </p>
            </div>
        </div>
        <div>
            <div class="row ambilantrian">
                <!-- <div class="col-sm-12"> -->
                    <!-- <img style="position: center fixed;" src="images/jadwal_dokter/BG-06.png"> -->
                <div class="col-sm-12" width="100%">
                </div>
<!-- </img> -->
                <!-- </div> -->
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
<?php $konfig = KonfigsystemK::model()->find(); ?>
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
        $('#dokter').hide();
        $('.penjamin-tab').removeClass('past');
        $('.poli-tab').removeClass('past');
        $('.penjamin-tab').addClass('active');
        $('.poli-tab').removeClass('active');
        $('.dokter-tab').removeClass('active');
        $('#tab-text').html('Silakan Ambil Antrian')
        $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(modelantrian_id);
    }

    var model_kode = null;

    function toPoli(modelantrian_id, modelantrian_kode) {

        $("#<?php echo CHtml::activeId($model, "modelantrian_id") ?>").val(modelantrian_id);
        if (typeof modelantrian_kode != undefined && modelantrian_kode != null) {
            model_kode = modelantrian_kode;
        }

        if (modelantrian_kode == 'L' || modelantrian_kode == 'R' || modelantrian_kode == 'K') {
            toNomorLangsung(modelantrian_id, modelantrian_kode);
        } else {
            $('#penjamin').hide();
            $('#poliklinik').show();
            $('#dokter').hide();
            $('.penjamin-tab').addClass('past');
            $('.poli-tab').removeClass('past');
            $('.penjamin-tab').removeClass('active');
            $('.poli-tab').addClass('active');
            $('.dokter-tab').removeClass('active');
            $('#tab-text').html('Silakan Pilih Poliklinik Tujuan')
        }

        // console.log(modelantrian_kode)

    }

    function toDokter(ruangan_id) {
        $('#penjamin').hide();
        $('#poliklinik').hide();
        $('.penjamin-tab').addClass('past');
        $('.poli-tab').addClass('past');
        $('.penjamin-tab').removeClass('active');
        $('.poli-tab').removeClass('active');
        $('.dokter-tab').addClass('active');
        $('#tab-text').html('Silakan Pilih Dokter Tujuan')
        $("#<?php echo CHtml::activeId($model, "ruangan_id") ?>").val(ruangan_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDokter'); ?>',
            data: {
                ruangan_id: ruangan_id,
                kode: model_kode
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
    });
</script>