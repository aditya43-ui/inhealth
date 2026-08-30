<?php
/**
 *  halaman utama untuk pengaturan tampilan layar antrian
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
      body{
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
        margin: 20px 20px 20px 20px;
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
    td{
        text-align: right;
        padding-right: 20px;
    }
    .judul{
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        padding-bottom: 0px;
    }
    .loket-nama{
        font-size: 20px;
        text-align: center;
        background-color:rgba(0,0,0,1);
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
        border: 1px solid #fff;
        border-bottom: none;
    }
    .no-antrian{
        
    }
    .no-antrian1{
       
    }
    .no-antrian2{
      
    }
    .no-antrian3{
       
    }
    .box-antrian{
        margin-top: 40px;
    }
    .statistik{
        font-size: 15px;
        color:#fff;
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
        position: absolute;
        bottom: 0px;
        width: 100%;

        background-color: white;

    }
      #textrunning {
        color: #007;
        text-shadow: none;
        height: 40px;
        bottom: 0px;
        right: 0px;
        color: white;
        text-shadow: none;
        font-weight: bold;
        font-size: 30px;
        padding: 0px;
       font-family:oswald; 
        padding-left: 6px;
        padding-right: 6px;
        background-color:#2b2e3b;
    }

    #clock {
        position: absolute;
        bottom: 0px;
        right: 0px;
        color: #007;
        text-shadow: none;
        font-weight: bold;
        font-size: 30px;
        padding: 0px;
        padding-left: 6px;
        padding-right: 6px;
        color:white;
         height: 40px;
         font-family:oswald; font-weight:bolder;
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
    #pantrian{
       background-color:#2b2e3b;
       height:150px;
       width: 100%;
       margin-left:2%;
       margin-right:2%;
    }
    #panggil{
       background-color:#3a3c4a;
       height:470px;
       width: 100%;
       border-color:white;
       margin-top:2%;
       margin-left:2%;
       margin-right:2%;
       border-bottom: 100px solid #2b2e3b;
       border-top: 100px solid #2b2e3b;
       margin-bottom:2%; 
         
       
    }
    #layar{
       background-color:#2b2e3b;
       
       height:630px;
       border-color:#f5f4f7;
       border-bottom: 80px solid #88007d;
       
           
    }
    .bantrian{
       background-color: #88007d;
      
       margin-left:2%;
     
       height: 150px;
       border-bottom: 30px solid #73006a;
       
       
    }
    .cantrian{
       background-color: #3a3c4a;
       
    
     border-bottom: 30px solid #2b2e3b;
     height: 150px;
     
    
       
    }
    #panelant{
      width:100%;  
    }
</style>
<div class="row">
    <div class="col-md-4" >
        <div class="col-md-4" id="pantrian" align="center">
            <img style="margin-top:0px;" src="<?php echo Yii::app()->request->baseUrl.'/images/kiosk/newekios/logo1.png'?>" id="logo"/>
            
        </div>
        
        <div class="col-md-4" id="panggil" class="no-antrian1">
            <div  style="margin-top:-80px; text-align:center; font-size:50px; color:white; font-family:oswald; font-weight:bolder;">
                        NO. ANTRIAN                    
            </div>
           <div class="no-antrian2" style="margin-top:40px; text-align:center; font-size:140px; color:white; font-family:oswald; font-weight:bolder;">
                        X - XXX                   
            </div>
            
            <div class="no-antrian3" style="margin-top:40px; text-align:center; font-size:70px; color:white; font-family:oswald; font-weight:bolder;">
                         LOKET XX                 
            </div>
        </div>
    </div>
    <div class="col-md-8 " id="layar" >
                        <video style="width:100%;height:520px; margin-top: 10px;margin-left: 10px; "  controls loop autoplay muted>
            <!--<source src="images/antrian/profil_rsud.mp4" type="video/mp4">-->
            <?php 
                if (!empty($layar->layarantrian_media_path) && file_exists(Params::pathVideoAntrian().$layar->layarantrian_media_path)){
            ?>
            <source src="<?php echo Params::urlVideoAntrian().$layar->layarantrian_media_path; ?>" type="video/mp4">
                <?php }else{ ?>
            <source src="" type="video/mp4">
                <?php } ?>
            Browser anda tidak mendukung tag &lt;video&gt; dan/atau video mp4/ogg.
        </video>
        <div style="margin-top:25px; text-align:center; font-size:50px; color:white; font-family:oswald; font-weight:bolder;"><?php echo strtoupper($layar->layarantrian_nama); ?></div>
        
    </div>
</div>

<div class="row">
    <?php
    $col = array("#0c0", "#00a", "#ea0", "#0e0");
    $cnt = 0;
    if (count($nomor_loket) > 0) {
        foreach ($nomor_loket AS $i => $loket) {
            ?>
    <div class="col-md-12" style="
                 width:calc((100%/<?php echo count($nomor_loket); ?>) - 10px); float: left;
                 margin-top:  15px;
                 margin-left: 5px;
                 ">
                     <?php
                     $subCnt = 0;
                     foreach ($loket['loket_id'] as $loket_id):

                         $modLoket = LoketM::model()->findByPk($loket_id);
                         $modAntrian = ModelantrianM::model()->findByPk($modLoket->modelantrian_id);
                         ?>
                    <div 
                        id="loket_<?php echo $modLoket->loket_id; ?>" 
                        class="antrian loketAntrian_<?php echo$loket['loket_no']; ?>"
                        data-loket-no="<?php echo $loket['loket_no']; ?>" 
                        data-antrian="<?php echo $modLoket->loket_id; ?>"
                        <?php echo $subCnt ? "hidden" : "" ?>
                        >
                        
                            
                              
                                <div>
                                    <div class="col-md-7 bantrian" >
                                        <?php // echo $modAntrian->modelantrian_singkatan; ?>
                                        <p style="text-align:center; color:white;font-family:oswald; font-weight:bolder; padding-top:25px; font-size:20px;">NO. ANTRIAN</p>
                                        <p class="no-antrian" style="text-align:center; color:white;font-family:oswald; font-weight:bolder; padding-top:20px; font-size:55px;">X - 000</p>
                                    </div>
                                    <div class="col-md-4 cantrian" style="color:white; ">
                                       
                                           
                                            <div style="text-align:center; font-size:40px; font-family:oswald; font-weight:bolder;">
                                            <?php 
                                                $data=array();
                                                $data=(explode(" ",$modLoket->loket_nama));
                                                echo strtoupper($data[0]); 
                                                
                                            ?>
                                              </div>
                                             <div style="text-align:center; font-size:60px; margin-top:-20px; font-family:oswald; font-weight:bolder;">
                                                <?php
                                                    
                                                     echo strtoupper($data[1]);  
                                                ?>
                                             </div>   
                                            
                                        
                                      
                                    </div>
                                </div>
                                
                           
                        
                        <?php echo $this->renderPartial('layarAntrianJaminanLama1/_formAntrian', array('model' => $model)); ?>
                    </div>
                    <?php
                    $subCnt++;
                endforeach;
                ?>
            </div>
            <?php
            $cnt++;
        }
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
<?php echo $this->renderPartial('_jsFunctionsAntrianPendaftaran', array('model' => $model, 'konfig' => $konfig)); ?>
<div id="suarapanggilan" ></div>
<script>
    var mon = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
    function updateClock( )
    {


        var currentTime = new Date( );
        var currentHours = currentTime.getHours( );
        var currentMinutes = currentTime.getMinutes( );
        var currentSeconds = currentTime.getSeconds( );

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
    
    /**
     * set semua antrian 
     * @param {type} antrian_id
     * @returns {undefined} */
    function setAntrians(antrian_id) {
        var jenis = 'AntrianJaminanLama2';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetAntrians'); ?>',
            data: {antrian_id: antrian_id,jenis: jenis},
            dataType: "json",
            success: function (data) {
                var noantrians = [];
                var loket_ids = [];
                var modelantrian_singkatan = [];
                var i = 0;
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        var obj = data[key];
                        if (obj.antrian_id !== null) {

                            setFormAntrian($("#loket_" + obj.loket_id), obj);
                            if (obj.loket_id == 5 || obj.loket_id == 13 || obj.loket_id == 21) {
                                $('.loketAntrian_5').hide();
                                $("#loket_" + obj.loket_id).show();
                                noantrians[i] = obj.noantrian;
                                loket_ids[i] = obj.loket_id;
                                modelantrian_singkatan[i] = obj.modelantrian_singkatan;
                            } else if (obj.loket_id == 6 || obj.loket_id == 14 || obj.loket_id == 22) {
                                $('.loketAntrian_6').hide();
                                $("#loket_" + obj.loket_id).show();
                                noantrians[i] = obj.noantrian;
                                loket_ids[i] = obj.loket_id;
                                modelantrian_singkatan[i] = obj.modelantrian_singkatan;
                            } else if (obj.loket_id == 7 || obj.loket_id == 15 || obj.loket_id == 23) {
                                $('.loketAntrian_7').hide();
                                $("#loket_" + obj.loket_id).show();
                                noantrians[i] = obj.noantrian;
                                loket_ids[i] = obj.loket_id;
                                modelantrian_singkatan[i] = obj.modelantrian_singkatan;
                            } else if (obj.loket_id == 8 || obj.loket_id == 16 || obj.loket_id == 24) {
                                $('.loketAntrian_8').hide();
                                $("#loket_" + obj.loket_id).show();
                                noantrians[i] = obj.noantrian;
                                loket_ids[i] = obj.loket_id;
                                modelantrian_singkatan[i] = obj.modelantrian_singkatan;
                            }

                            i++;
                        }
                        setTableStatistik($("#loket_" + obj.loket_id), obj);
                    }
                }
                console.log(i);
                if (i > 0 && (antrian_id != '' && antrian_id != undefined)) { //agar tidak memanggil ketika refresh interval fungsi ini kecuali jika noantrian berubah
                    setSuaraPanggilan(noantrians, loket_ids, modelantrian_singkatan);
                    setAntrianAllTerakhir('AntrianJaminanLama2');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function ()
    {
        setInterval('updateClock()', 1000);
        setInterval(function () {
            $(".antrian").each(function () {
                updateStatistik($(this).data("antrian"));
            });
        }, 60000);
        $(".antrian").each(function () {
            updateStatistik($(this).data("antrian"));
        });
        
        setAntrians('');
        setAntrianAllTerakhir('AntrianJaminanLama2');
        <?php if ($konfig->is_nodejsaktif) { ?>
            var chatServer = '<?php echo $konfig->nodejs_host ?>';
            if (chatServer == '') {
                chatServer = 'http://localhost';
            }
            var chatPort = '<?php echo $konfig->nodejs_port ?>';
            socket = io.connect(chatServer + ':' + chatPort);
            socket.emit('subscribe', 'antrian');
            socket.on('antrian', function (data) {
                console.log(data.loket_id);
                if (typeof data.loket_id !== 'undefined') {
                    updateStatistik(data.loket_id);
                } else {
                    if (data.panggil == 1)
                        setAntrians(data.antrian_id);
                }
            });
        <?php } else { ?>
            setInterval(function () {
                setAntrians('');
            }, 4000);
        <?php } ?>
    });
</script>

