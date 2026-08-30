<link rel="stylesheet" type="text/css" href="css/font.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
#page td {
    padding: 0;
    margin: 0;
}

html {
    padding: 0;
    margin: 0;
}

body {
    /*background-image: url("images/antrian/bg_antrian_1.jpg");*/
    background-color: #b5b5b5;
    background-repeat: no-repeat;
    background-position: center top;
    background-size: 100% auto;
    /* width: 980px; */
    color: #000;
    height: 0;
}

.content {
    margin-top: 1vh;
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
td {
    text-align: right;
    padding-right: 20px;
}

.judul {
    text-align: center;
    font-size: 25px;
    font-weight: bold;
    padding-bottom: 0px;
}

.loket-nama {
    font-size: 20px;
    text-align: center;
    background-color: rgba(0, 0, 0, 1);
    -moz-border-radius: 5px 5px 0 0;
    -webkit-border-radius: 5px 5px 0 0;
    border-radius: 5px 5px 0 0;
    border: 1px solid #fff;
    border-bottom: none;
}


.no-antrian-det1 {

    text-align: center;
    font-size: 1.7vw;
    color: white;
    font-family: oswald;
    font-weight: bolder;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.no-antrian2 {
    text-align: center;
    font-size: 5.2vw;
    color: white;
    font-family: oswald;
    font-weight: bolder;
    position: absolute;
    top: 50%;
    right: -25%;
    left: 50%;
    transform: translate(-50%, -50%);

}

.no-antrian3 {

    text-align: center;
    font-size: 2vw;
    color: white;
    font-family: oswald;
    font-weight: bolder;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

}

.no-antrianback3 {
    background-color: #2b2e3b;
    position: relative;
    height: 6.833333333vh;
    /*        height:6vh;*/
}

.no-antrianback2 {
    /*        margin-top: 0.5vw;  */
    height: 12.833333333vh;
    /*        margin-bottom: 1.8vw;*/
    position: relative;
}

.no-antrian-detback1 {
    background-color: #2b2e3b;
    /*        height:6vh;*/
    /*        margin-top:-5vw; */
    height: 5vh;
    position: relative;

}

.box-antrian {
    margin-top: 40px;
}

.statistik {
    font-size: 15px;
    color: #fff;
    text-shadow:
        -1px -1px 0 #000,
        1px -1px 0 #000,
        -1px 1px 0 #000,
        1px 1px 0 #000;
    background-color: rgba(34, 86, 11, 0.8);
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    padding: 2px 7px;
    border: 1px solid #fff;
}

/*
    #loket_2 .loket-nama{
        background-color:#000099 !important; 
    }
        #loket_3 .loket-nama{
        background-color:#bb0c0c !important; 
    }
    */
.block-footer-antrian {
    position: fixed;
    bottom: 5px;
    width: 100%;
    background-color: white;

}

#textrunning {
    color: #007;
    text-shadow: none;
    height: 60px;
    bottom: 0px;
    right: 0px;
    color: white;
    text-shadow: none;
    font-weight: bold;
    font-size: 1.8vw;
    padding-top: 0.3vw;
    font-family: oswald;
    padding-left: 86px;
    padding-right: 6px;
    background-color: #2b2e3b;
}

#clock {
    position: absolute;
    bottom: 0px;
    right: 0px;
    color: #007;
    text-shadow: none;
    font-weight: bold;
    font-size: 1.8vw;
    padding-top: 0.3vw;
    padding-left: 6px;
    padding-right: 6px;
    color: white;
    height: 60px;
    font-family: oswald;
    font-weight: bolder;
    background-color: #88007d;
}

.content {
    margin-left: 0px;
    margin-right: 0px;
}

.base_screen {
    min-height: calc(100vh - 240px);
}
</style>
<style>
#pantrian {
    background-color: #2b2e3b;
    height: 25vh;
    width: 100%;
    margin-left: 3%;
    margin-right: 1%;
}

#panggil {
    background-color: #3a3c4a;
    height: 24.5vh;
    width: 100%;
    border-color: white;
    margin-top: 1.0vh;
    margin-left: 3%;
    margin-right: 1%;
    margin-bottom: 1%;
    /*       border-top: 0.5vw solid #2b2e3b; */
    /*       border-bottom: 3.4vw solid #2b2e3b;       */
}

#panggil>table {
    padding: 20.5vh;
}

#layar {
    background-color: #2b2e3b;
    height: 50.7vh;
    border-color: #f5f4f7;
    /*       border-bottom: 4vw solid #88007d;*/
    position: relative;
    padding-left: 0px;
    padding-right: 0px;
}

.bantrian {
    /*        position: absolute;*/
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.bantrianluar {
    background-color: #88007d;
    height: 11vh;
    border-bottom: 0.5vw solid #73006a;
    position: relative;

}

.cantrian {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.cantrianluar {
    background-color: #3a3c4a;
    border-bottom: 0.5vw solid #2b2e3b;
    height: 11vh;
    position: relative;

}

.dantrian {

    position: absolute;
    top: 50%;
    right: -25%;
    left: 50%;
    transform: translate(-50%, -50%);

}

.dantrianluar {
    position: relative;
    background-color: #2b2e3b;
    height: 10vh;
}

#panelant {
    width: 100%;
}

.row {
    margin: -1.5vh;
}

.layarvideo {
    padding-left: 15px;
    padding-right: 15px;
}

.judullayar {
    height: 9.0vh;
    padding-left: 0;
    padding-right: 0;
    position: relative;
    background-color: #88007d;
}

.judulisi {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.8vw;

}

.hide-tr {
    display: none;
}

/**
    block utama untuk mengatur nomor antrian dan nama model
    **/
.modelluar {
    background-color: #2b2e3b;
    height: 9vh;
    /*border-bottom: 0.5vw solid #73006a;*/
}

/**digunakan untuk mengatur ukuran dan tampilan nama singkatan model**/
.modelluar>.singkatan-model {
    color: #fff;
    font-weight: bold;
    font-size: 3vw;
    line-height: 1.2;
}

/**digunakan untuk mengatur ukuran dan tampilan nama nama model**/
.modelluar>.nama-model {
    color: #fff;
    font-weight: bold;
    font-size: 0.8vw;
}

#konten-all {
    width: 99%;
}

</style>
<?php

$data=ProfilrumahsakitM::model()->findByPk(1); 


?>
<div id="konten-all">
    <div class="row">
        <div class="col-md-4" style=" padding-left:0px;margin-right: 0vw;">
            <div class="col-md-12" id="pantrian" style="text-align:center;">
                <img style="margin-top:20px;margin-left: 10px;" width="120px;"
                    src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?>" id="" />
            </div>
            <div class="clear"></div>
            <div class="" id="panggil" class="no-antrian1" style="padding:0px;">

                <div class="col-md-12" style="padding:0px;">
                    <div class="no-antrian-detback1" style="">
                        <div class="no-antrian-det1" style="">
                            NO. ANTRIAN
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="padding:0px;">

                    <div class="no-antrianback2" style="">
                        <div class="no-antrian2" style="">
                            X - XXX
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="padding:0px;">
                    <div class="no-antrianback3" style="">
                        <div class="no-antrian3" style="">
                            LOKET XX
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 " id="layar" style="width:66.1%">
            <div class="layarvideo">
                <!-- NON AKTIFKAN VIDEO SEMENTARA, VOLUME DOUBLE -->

                <!-- <video style="width:100%;height:30.7vh;" loop autoplay muted> -->
                <!--<source src="images/antrian/profil_rsud.mp4" type="video/mp4">-->
                <?php 
                    // if (!empty($layar->layarantrian_media_path) && file_exists(Params::pathVideoAntrian().$layar->layarantrian_media_path)){
                ?>
                <!-- <source src="<?php // echo Params::urlVideoAntrian().$layar->layarantrian_media_path; ?>" type="video/mp4"> -->
                <?php // }else{ ?>
                <!-- <source src="" type="video/mp4"> -->
                <?php // } ?>
                <!-- Browser anda tidak mendukung tag &lt;video&gt; dan/atau video mp4/ogg. -->
                <!-- </video> -->
            </div>
            <div class="judullayar"
                style=" text-align:center; font-size:1.7vw; color:white; font-family:oswald; font-weight:bolder;">
                <div class="judulisi">
                    <?php echo strip_tags(strtoupper($layar->layarantrian_judul)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="">
        <?php 
            if ($modelantrian_id == 'all'){
                echo $this->renderPartial($pathview.'lokasi/_listAntrianAllModel',array('nomor_loket'=>$nomor_loket, 'pathview'=>$pathview, 'model'=>$model, 'load_model'=>$load_model, 'nomor'=>$nomor, 'layar'=>$layar), true);         
            }else{
                echo $this->renderPartial($pathview.'lokasi/_listAntrian',array('nomor_loket'=>$nomor_loket, 'pathview'=>$pathview, 'model'=>$model), true);         
            }
        ?>
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
</div>
<?php echo $this->renderPartial($pathview.'lokasi/_jsFunctionsAntrianPendaftaran', array('model' => $model, 'konfig' => $konfig)); ?>
<div id="suarapanggilan"></div>
</div>
<script>
var arr = {};
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
    var currentTimeString = currentDate + " " + mon[currentMonth] + " " + currentYear + " - " + currentHours + ":" +
        currentMinutes + ":" + currentSeconds + " " + timeOfDay;

    $("#clock").html(currentTimeString);

}


/**
 * set semua antrian 
 * @param {type} antrian_id
 * @returns {undefined} */
function setAntrians(antrian_id, setangka) {
    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('GetAntrians'); ?>',
        data: {
            antrian_id: antrian_id,
            lokasi_karcisantrian_id: '<?php echo isset($_GET['lokasi_karcisantrian_id'])?$_GET['lokasi_karcisantrian_id']:null; ?>',
            modelantrian_id: '<?php echo isset($_GET['modelantrian_id'])?$_GET['modelantrian_id']:null; ?>',
            layarantrian_id: '<?php echo isset($_GET['layarantrian_id'])?$_GET['layarantrian_id']:null; ?>'
        },
        dataType: "json",
        success: function(data) {
            var noantrians = [];
            var loket_ids = [];
            var modelantrian_singkatan = [];
            var i = 0;
            arr = data;
            for (var key in data) {
                if (data.hasOwnProperty(key)) {
                    var obj = data[key];
                    if (obj.antrian_id !== null) {

                        //setFormAntrian($("#loket_"+obj.loket_singkatan+"[data-loket_id*='"+obj.loket_id+"']"), obj);                                                       
                        //$("#loket_"+obj.loket_singkatan+"[data-loket_id*='"+obj.loket_id+"']").show();

                        noantrians[i] = obj.noantrian;
                        loket_ids[i] = obj.loket_id;
                        modelantrian_singkatan[i] = obj.modelantrian_singkatan;


                        i++;
                    }
                    //setTableStatistik($("#loket_" + obj.loket_singkatan), obj);
                }
            }

            if (i > 0 && (antrian_id != '' && antrian_id !=
                undefined)) { //agar tidak memanggil ketika refresh interval fungsi ini kecuali jika noantrian berubah
                setSuaraPanggilan(noantrians, loket_ids, modelantrian_singkatan);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function customFungsi() {
    for (var key in arr) {
        if (arr.hasOwnProperty(key)) {
            var obj = arr[key];
            if (obj.antrian_id !== null) {
                setFormAntrian($(".loketAntrian_" + obj.loket_id + "  "), obj);
                $("#loket_" + obj.loket_id + "[data-loket_id='" + obj.loket_id + "']").show();
            }
        }
    }

    setAntrianAllTerakhir(
        '<?php echo isset($_GET['lokasi_karcisantrian_id'])?$_GET['lokasi_karcisantrian_id']:null; ?>',
        '<?php echo isset($_GET['modelantrian_id'])?$_GET['modelantrian_id']:null; ?>');
}

$(document).ready(function() {
    setInterval('updateClock()', 1000);
    setAntrianAllTerakhir(
        '<?php echo isset($_GET['lokasi_karcisantrian_id'])?$_GET['lokasi_karcisantrian_id']:null; ?>',
        '<?php echo isset($_GET['modelantrian_id'])?$_GET['modelantrian_id']:null; ?>');
    setAntrians('');
    <?php if ($konfig->is_nodejsaktif) { ?>
    var chatServer = '<?php echo $konfig->nodejs_host ?>';
    if (chatServer == '') {
        chatServer = 'http://localhost';
    }
    var chatPort = '<?php echo $konfig->nodejs_port ?>';
    socket = io.connect(chatServer + ':' + chatPort);
    socket.emit('subscribe', 'antrian');
    socket.on('antrian', function(data) {
        console.log(data.loket_id);
        if (data.panggil == 1) {
            if (typeof data.loket_id !== 'undefined') {
                updateStatistik(data.loket_id);
            } else {
                console.log(data);
                if (data.panggil == 1)
                    setAntrians(data.antrian_id);
            }
        }
    });
    <?php } else { ?>
    setInterval(function() {
        setAntrians('');
    }, 4000);

    <?php } ?>
    <?php if ($modelantrian_id == 'all'){ ?>
    setInterval(function() {
        //                listAntrian();
    }, 10000);

    setInterval(function() {
        //                listAntrianLoket();
    }, 5000);

    <?php } ?>

});

function listAntrianLoket() {
    var jumlah = parseInt($(".lis-antrian > table > tbody > tr").length);
    var jml_col = Math.floor(parseFloat(jumlah / 4)) + 1;

    if ((jumlah - 4) > 0) {
        var no = 0;
        $(".lis-antrian > table > tbody > tr").each(function() {
            if ($(this).hasClass('hide') == false) {
                no = parseInt($(this).attr('nolist'));
            }
        });

        if (jml_col == (no + 1)) {
            $(".lis-antrian > table > tbody > tr").addClass('hide');
            $(".lis-antrian > table > tbody > tr[nolist='0']").removeClass('hide');
        } else {
            no++;
            $(".lis-antrian > table > tbody > tr").addClass('hide');
            $(".lis-antrian > table > tbody > tr[nolist='" + no + "']").removeClass('hide');
        }
    }
}

function listAntrian() {
    var jumlah = parseInt($(".lis-antrian > table > thead > tr > td.modelname").length);
    var jml_col = Math.floor(parseFloat(jumlah / 6)) + 1;

    if ((jumlah - 6) > 0) {
        var no = 0;
        $(".lis-antrian > table > thead > tr > td.modelname").each(function() {
            if ($(this).hasClass('hide') == false) {
                no = parseInt($(this).attr('nolist'));
            }
        });

        if (jml_col == (no + 1)) {
            $(".lis-antrian > table > thead > tr > td").addClass('hide');
            $(".lis-antrian > table > thead > tr > td[nolist='0']").removeClass('hide');

            $(".lis-antrian > table > tbody > tr > td").addClass('hide');
            $(".lis-antrian > table > tbody > tr > td[nolist='0']").removeClass('hide');
        } else {
            no++;
            $(".lis-antrian > table > thead > tr > td").addClass('hide');
            $(".lis-antrian > table > thead > tr > td[nolist='" + no + "']").removeClass('hide');

            $(".lis-antrian > table > tbody > tr > td").addClass('hide');
            $(".lis-antrian > table > tbody > tr > td[nolist='" + no + "']").removeClass('hide');
        }
    }

}
</script>