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
        /*background-image:url("images/antrian/bg_antrian.jpg");*/
        background-color: #b5b5b5;
        background-repeat:no-repeat;
        /*width:980px;*/
        color:#000;
    }
	.content {
		
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
    thead th{
        text-align: center;
        padding-right: 20px;
    }
    .antrian {
        margin-left: 5px;
    }
    .judul{
        text-align: center;
        font-size: 35px;
        font-weight: bold;
        padding-bottom: 0px;
    }
    .ruangan,.dokter{
       background-color:#2b2e3b;
       height:130px;
       width: 100%;
    }
    .ruangan1{
       background-color:#2b2e3b;
       height:45px;
       width: 100%;
       margin-top:2%;
    }
    .ruangan{
        background-color:#2b2e3b;
       height:105px;
       width: 100%;
    }
    .ruangantable{
       background-color:#2b2e3b;
       width: 100%;
    }
    .dokter{
        /*font-size: 70%;*/
        color: #00FF00;
        border: 1px solid #fff;
        border-bottom: none;
        border-top:none;
    }
    .no-antrian, .pasien-deskripsi{
        color:#fff;
        text-align: center;
        font-size: 6.4vw;
        font-weight: bold;
        background-color:rgba(255,255,255,0.5);
    }
    .no-antrian{
        
    }
    .pasien-deskripsi{
        /*font-size: 70%;*/
        width: 100%;
        font-size: 3vw;
        -moz-border-radius: 0 0 4px 4px;
        -webkit-border-radius: 0 0 4px 4px;
        border-radius: 0 0 4px 4px;
       padding-top:-5%;
        border-top:none;
        background-color: #2b2e3b;
        height: 40px;
    }
    .statistik{
        text-shadow:
            -1px -1px 0 #000,  
             1px -1px 0 #000,
             -1px 1px 0 #000,
              1px 1px 0 #000;
        background-color:rgba(0,0,0,0.7);
        height: 200px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        border: 1px solid #FFF;
    }
    .daftar-judul{
        color:#fff;
        text-align: center;
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
    }
    .daftar-isi td, th{
        color:#fff;
        background-color:rgba(0,0,0,0.8) !important;
        font-size: 11px;
        text-align: left;
        font-weight: bold;
    }
    
    .block-footer-antrian {
        position: absolute;
        bottom: -2px;
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
        background-color: #85c227;
    }
    
    .content {
        margin-left: 0px !important;
    }
    #pantrian{
       background-color:#2b2e3b;
       height:100px;
       width: 100%;
       
       
    }
     #pantriantengah{
       background-color:#3a3c4a;
       height:120px;
       width: 100%;
       
       
    }
      #pantrianbawah{
       background-color:#2b2e3b;
       height:120px;
       width: 100%;
       
       
    }
     #pantriantengah2{
       background-color:#3a3c4a;
       margin-top: -4%;
      
       
       
    }
</style>
<!--<div class="row-fluid judul">NO. ANTRIAN PENGAMBILAN OBAT FARMASI</div>-->
<?php $i = "apotek"; ?>
<?php
    $profil = ProfilrumahsakitM::model()->find();
?>
 
<div class="row antrian " id="ruangan_<?php echo $i; ?>">
    <div class="col-md-6">
            <div class="col-md-12 ruangan rheader" id="ruangan_<?php echo $i; ?>" align="center">

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
        <img src="<?= $res ?>" id="logo" width="10%" >
             </div>
             <div style="font-size:3vw; color:white; font-family:oswald; font-weight:bolder;" class="col-md-12 ruangan1" id="ruangan_<?php echo $i; ?>" align="center">
                   <div class="col-md-12">NO. ANTRIAN</div>

             </div>
            <div class="col-md-12 no-antrian" id="pantriantengah" align="center" style=" color:white; font-family:oswald; font-weight:bolder;">

                <div class="col-md-12">X-XXX</div>
             </div>


            <div class="col-md-12 ruangan pasien-deskripsi"  id="pasien-deskripsi_<?php echo $i; ?>"  align="center">
                    <span>LOKET</span>  XX
             </div>
     </div>
    <div class="col-md-6">
            <div class="col-md-12 ruangantable rheader" align="center" style="font-size:3vw;   color:white; font-family:oswald; font-weight:bolder;">
                <div style="padding-bottom:1%"></div>
                <div class="controls" style="background-color:#85c227;">LAYAR ANTRIAN FARMASI </div>
                    <?php  
    if(count((array)$modLokets) > 0){
        foreach($modLokets AS $i => $loket){
    ?>
            <div class="statistik">
              <?php echo strtoupper($loket->racikan_nama."(".$loket->racikan_singkatan.")") ?>
              <?php echo $this->renderPartial('_daftarAntrian',array('data'=>array())); ?>
        </div>
    <?php
        }
    }
    ?>
                    </table>
            <br>
            
            


     </div>
    <br>
            <iframe id="suarapanggilan" src="" style="display:none;">
            </iframe>
    <?php /*
    <div class="span4">
        <div class="loket-nama" style="background-color:#005500">
            LOKET <?php echo strtoupper(RuanganM::model()->findByPk(Params::RUANGAN_ID_APOTEK_1)->ruangan_nama); ?>
        </div>
    <?php  
        if(count($modLokets) > 0){
            foreach($modLokets AS $i => $loket){
        ?>
                <div id="loket_<?php echo $loket->racikan_id ?>" class="antrian">
                    <div class="no-antrian">
                        <?php echo $loket->racikan_singkatan; ?>-0000
                    </div>
                    <?php echo $this->renderPartial('_formAntrian',array('model'=>$model,'loket'=>$loket)); ?>
                   
                </div>
        <?php
            }
        }
        ?>
    </div>

    <?php  
    /*
    if(count($modLokets) > 0){
        foreach($modLokets AS $i => $loket){
    ?>
        <div id="daftarantrian_<?php echo $loket->racikan_id ?>" class="span4">
            <div class="statistik">
                <div class="daftar-judul" style="background-color:#550000"><?php echo strtoupper($loket->racikan_nama."(".$loket->racikan_singkatan.")") ?></div>
                <div class="daftar-isi">
                    <?php echo $this->renderPartial('_daftarAntrian',array('data'=>array())); ?>
                </div>
            </div>
        </div>
    <?php
        }
    }
     * 
     */
    ?>
    
</div>
      
<div class="block-footer-antrian">
            <div id="footerAntrian">
                <?php $profil = ProfilrumahsakitM::model()->find(); ?> 
                <marquee direction="left" scrollamount="10" id="textrunning">
                    <?php echo $profil->nama_rumahsakit." - ".$profil->motto; ?>
                </marquee>
            </div> 
                <div id="footerClock">
                    <div id="clock"></div>
                </div>
            </div>
<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model,'konfig'=>$konfig)); ?>

<div id="suarapanggilan" ></div>
<script>
            var mon = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
            function updateClock ( )
            {
                
                
                var currentTime = new Date ( );
                var currentHours = currentTime.getHours ( );
                var currentMinutes = currentTime.getMinutes ( );
                var currentSeconds = currentTime.getSeconds ( );
                
                var currentDate = currentTime.getDate();
                var currentMonth = currentTime.getMonth();
                var currentYear = currentTime.getFullYear();
                
                // Pad the minutes and seconds with leading zeros, if required
                currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
                currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;
                
                // Choose either "AM" or "PM" as appropriate
                var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";
                
                // Convert the hours component to 12-hour format if needed
                currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;
                
                // Convert an hours component of "0" to "12"
                currentHours = ( currentHours == 0 ) ? 12 : currentHours;
                
                // Compose the string for display
                var currentTimeString = currentDate + " " + mon[currentMonth] + " " + currentYear + " - " + currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;
                
                $("#clock").html(currentTimeString);
                
            }
            
            $(document).ready(function()
            {
                setInterval('updateClock()', 1000);
            });
            
 </script>


