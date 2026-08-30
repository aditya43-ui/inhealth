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
    
    .no-antrian-det1{
       margin-top:-4.2vw; 
       text-align:center; 
       font-size:2.5vw; 
       color:white;
       font-family:oswald; 
       font-weight:bolder;
       background-color: #2b2e3b;
        height:7.5vh;
    }
    .no-antrian2{                
        text-align:center; 
        font-size:3vw; 
        color:white; 
        font-family:oswald; 
        font-weight:bolder;        
        margin-top: 0.5vw;       
        margin-bottom: 1.8vw;       
    }
    .no-antrian3{       
        height:7.5vh;
        text-align:center; 
        font-size:2.5vw; 
        color:white; 
        font-family:oswald; 
        font-weight:bolder;
        background-color: #2b2e3b;        
    }
    
    .no-antrian1{
       
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
        font-size: 1.2vw;
        padding-top: 0.3vw;
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
        font-size: 1.2vw;
        padding-top: 0.3vw;
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
       height:20vh;
       width: 100%;
       margin-left:1%;
       margin-right:1%;
    }
    #panggil{
       background-color:#3a3c4a;
       height:29.5vh;
       width: 100%;
       border-color:white;
       margin-top:0.3vh;
       margin-left:1%;
       margin-right:1%;
       margin-bottom:1%;       
       border-top: 0.5vw solid #2b2e3b; 
       border-bottom: 3.4vw solid #2b2e3b;       
    }
    #layar{
       background-color:#2b2e3b;
       height:49.7vh;
       border-color:#f5f4f7;
       border-bottom: 4vw solid #88007d;
    }
    .bantrian{
       background-color: #88007d;       
       height: 11vh;
       border-bottom: 1vw solid #73006a;
    }
    .cantrian{
        background-color: #3a3c4a;
        border-bottom: 1vw solid #2b2e3b;
        height: 11vh;
    }
    #panelant{
        width:100%;  
    }
</style>
<div class="">
    <div class="col-md-4" style="padding-left:0px;margin-right: 0vw;">
        <div class="col-md-12" id="pantrian" style="text-align:center;">
            <img style="margin-top:0px;margin-left: 10px;" width="100%" src="<?php echo Yii::app()->request->baseUrl . '/images/kiosk/newekios/logo1.png' ?>" id=""/>            
        </div> 
        <div class="clear"></div>
        <div class="" id="panggil" class="no-antrian1" style="padding:0px;">            
            <br/><br/><br/>
            <div class="col-md-12" style="padding:0px;">
                <div class="no-antrian-det1"  style="">
                   NO. ANTRIAN                    
               </div>
            </div>
            <div class="col-md-12" style="padding:0px;">
                 <div class="no-antrian2" style="">
                            X - XXX                   
                        </div>
            </div>
            <div class="col-md-12" style="padding:0px;">
               <div class="no-antrian3" style="">
                            LOKET XX                 
                        </div>
            </div>                                         
        </div>
    </div>
    <div class="col-md-8 " id="layar" style="padding-right:20px;width:66.1%">
        <!-- <video style="width:100%;height:40.7vh; margin-top: 10px;"  loop autoplay muted> -->
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
        <div style="margin-top:0.5vw; text-align:center; font-size:1.7vw; color:white; font-family:oswald; font-weight:bolder;"><?php echo strip_tags(strtoupper($layar->layarantrian_judul)); ?></div>
    </div>
</div>
<div class="">
        <?php 
            if ($modelantrian_id == 'all'){
                echo $this->renderPartial($pathview.'lokasi/_listAntrianAllModel',array('nomor_loket'=>$nomor_loket, 'pathview'=>$pathview, 'model'=>$model, 'load_model'=>$load_model, 'nomor'=>$nomor), true);         
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
<?php echo $this->renderPartial($pathview.'lokasi/_jsFunctionsAntrianPendaftaran', array('model' => $model, 'konfig' => $konfig)); ?>
<div id="suarapanggilan" ></div>
<script>
    var arr = {};
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
    function setAntrians(antrian_id, setangka) {         
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetAntrians'); ?>',
            data: {
                antrian_id: antrian_id,
                lokasi_karcisantrian_id:'<?php echo isset($_GET['lokasi_karcisantrian_id'])?$_GET['lokasi_karcisantrian_id']:null; ?>',
                modelantrian_id:'<?php echo isset($_GET['modelantrian_id'])?$_GET['modelantrian_id']:null; ?>'
            },
            dataType: "json",
            success: function (data) {
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
                
                if (i > 0 && (antrian_id != '' && antrian_id != undefined)) { //agar tidak memanggil ketika refresh interval fungsi ini kecuali jika noantrian berubah
                    setSuaraPanggilan(noantrians, loket_ids, modelantrian_singkatan);                    
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    
    function customFungsi(){
        for (var key in arr) {
            if (arr.hasOwnProperty(key)) {
                var obj = arr[key];
                if (obj.antrian_id !== null) {
                    setFormAntrian($("#loket_"+obj.loket_singkatan+"[data-loket_id*='"+obj.loket_id+"']"), obj);                                                       
                    $("#loket_"+obj.loket_singkatan+"[data-loket_id*='"+obj.loket_id+"']").show();                                     
                }                
            }
        }
    
        setAntrianAllTerakhir('<?php echo isset($_GET['lokasi_karcisantrian_id'])?$_GET['lokasi_karcisantrian_id']:null; ?>','<?php echo isset($_GET['modelantrian_id'])?$_GET['modelantrian_id']:null; ?>');
    }

    $(document).ready(function ()
    {
        setInterval('updateClock()', 1000);        
        setAntrianAllTerakhir('<?php echo isset($_GET['lokasi_karcisantrian_id'])?$_GET['lokasi_karcisantrian_id']:null; ?>','<?php echo isset($_GET['modelantrian_id'])?$_GET['modelantrian_id']:null; ?>');
        setAntrians('');        
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
                if(data.panggil == 1){ 
                    if (typeof data.loket_id !== 'undefined') {
                        updateStatistik(data.loket_id);
                    } else {
                        if (data.panggil == 1)
                            setAntrians(data.antrian_id);                            
                    }
                }
            });
        <?php } else { ?>
            setInterval(function () {
                setAntrians('');
            }, 4000);
                       
        <?php } ?>
            <?php if ($modelantrian_id != 'all'){ ?>
            setInterval(function () {                
                listAntrian();
            }, 10000);  
            
            <?php } ?>
    });
    
    
    function listAntrian(){
        var jumlah = $(".lis-antrian").length;
        var no = 0;
        $(".lis-antrian").each(function(){
            if ($(this).hasClass('hide') == false){
                no = parseInt($(this).attr('nolist'));
            }
        }); 
        
        if (jumlah == (no+1)){           
            $(".lis-antrian").addClass('hide');
            $(".lis-antrian[nolist='0']").removeClass('hide');
        }else{            
            no++;                
            $(".lis-antrian").addClass('hide');
            $(".lis-antrian[nolist='"+no+"']").removeClass('hide');
        }
        
    }
</script>

