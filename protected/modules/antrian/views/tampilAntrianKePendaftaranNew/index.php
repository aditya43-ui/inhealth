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
        background-image: url("css/hijau.png");
		background-repeat: no-repeat;
		background-position: center top;
		background-size: 100% auto;
		/* width: 980px; */
		color: #000;
		height: 0;
    }
	.content {
		margin: 146px 20px 20px 20px;
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
        color:#fff;
        text-align: center;
        font-size: 80px;
        font-weight: bold;
        background-color:rgba(255,255,255,0.5);
        text-shadow:
            -2px -2px 0 #000,  
             1px -2px 0 #000,
             -2px 2px 0 #000,
              2px 2px 0 #000;
        -moz-border-radius: 0 0 5px 5px;
        -webkit-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
        border: 1px solid #fff;
        border-top: none;
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
    }
    
    #clock {
        position: absolute;
        bottom: 0px;
        right: 0px;
        color: #007;
        text-shadow: none;
        font-weight: bold;
        font-size: 20px;
        padding: 0px;
        padding-left: 6px;
        padding-right: 6px;
        background-color: white;
    }
    
    .content {
        margin-left: 0px;
        margin-right: 0px;
    }
</style>
<div class="row-fluid judul">NOMOR ANTRIAN PENDAFTARAN</div>
<?php echo CHtml::hiddenField('jamsekarang',"",array('readonly'=>true,'class'=>'realtime')) ;?>
<div class="row-fluid">
    <?php  
    $col = array("#0c0", "#00a", "#ea0");
    $cnt = 0;
    if(count($modLokets) > 0){
        foreach($modLokets AS $i => $loket){
    ?>
            <div class="span4">
                <div id="loket_<?php echo $loket->loket_id;?>" class="antrian" data-antrian="<?php echo $loket->loket_id;?>">
                    <div class="loket-nama" style="background-color:<?php echo $col[$cnt % 3]; ?>;">
                        <?php echo strtoupper($loket->loket_nama); ?><br/>DI LOKET <?php echo $loket->loket_singkatan; ?>
                    </div>
                    <div class="no-antrian">
                        <?php echo $loket->loket_singkatan; ?>-000
                    </div>
                    <?php echo $this->renderPartial('_formAntrian',array('model'=>$model)); ?>
                    <div class="statistik">
                        <?php echo $this->renderPartial('_statistik',array('loket'=>$loket)); ?>
                    </div>
                </div>
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
                                 
