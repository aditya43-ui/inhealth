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
        margin: 146px 20px 20px 20px;
    }

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
        color: #FFFF00;
        width: 100%;
        height: 50px;
        /*font-size: 85%;*/
        overflow: hidden;
        text-align: center;
        background-color: #020;
    }

    .ruangan {
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
        border: 1px solid #fff;
        border-bottom: none;
        font-size: 35px;
    }

    .dokter {
        /*font-size: 70%;*/
        color: #00FF00;
        border: 1px solid #fff;
        border-bottom: none;
        border-top: none;
    }

    .no-antrian,
    .pasien-deskripsi {
        color: #fff;
        text-align: center;
        font-size: 120px;
        font-weight: bold;
        background-color: rgba(255, 255, 255, 0.5);
        text-shadow:
            -2px -2px 0 #000,
            2px -2px 0 #000,
            -2px 2px 0 #000,
            2px 2px 0 #000,
            0px -2px 0 #000,
            0px 2px 0 #000,
            -2px 0px 0 #000,
            2px 0px 0 #000;
    }

    .no-antrian {
        border: 1px solid #fff;
        border-bottom: none;
        border-top: none;
    }

    .pasien-deskripsi {
        /*font-size: 70%;*/
        width: 100%;
        font-size: 35px;
        -moz-border-radius: 0 0 5px 5px;
        -webkit-border-radius: 0 0 5px 5px;
        border-radius: 0 0 5px 5px;
        border: 1px solid #fff;
        border-top: none;
        background-color: #020;
        /*height: 20px;*/
    }

    .statistik {
        text-shadow:
            -1px -1px 0 #000,
            1px -1px 0 #000,
            -1px 1px 0 #000,
            1px 1px 0 #000;
        background-color: rgba(0, 0, 0, 0.7);
        height: 320px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        border: 1px solid #FFF;
    }

    .daftar-judul {
        color: #fff;
        text-align: center;
        -moz-border-radius: 5px 5px 0 0;
        -webkit-border-radius: 5px 5px 0 0;
        border-radius: 5px 5px 0 0;
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

    #textrunning {
        color: #007;
        text-shadow: none;
        font-size: 20px;
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
</style>
<!--<div class="row judul"><?php // echo isset($modLayar->layarantrian_judul)?$modLayar->layarantrian_judul:''; 
                            ?></div>
<div class="antrian_big" hidden>
	<div class="w2">
		<div id="ruangan_big" class="antrian" style="width: 100%;height:400px;">
			<div class="ruangan_big" id="ruangan_nama_big">
				<span>-</span>
			</div>
			<div class="dokter_big" id="dokter_big">
				<span>Nama Dokter</span>
			</div>
			<div class="no-antrian_big">
				XX-000
			</div>
			<div class="pasien-deskripsi_big" id="pasien-deskripsi_big">
				<span>Nama Pasien</span>
			</div>
		</div>
    </div>-->
<div class="row judul">NO. ANTRIAN PASIEN POLIKLINIK</div>
<div class="row">
    <?php $i = "poliklinik"; ?>
    <div>
        <div id="ruangan_<?php echo $i; ?>" class="antrian" style="width:100%;height:150px;">
            <div class="ruangan" id="ruangan_<?php echo $i; ?>">
                <span> Ruangan Poliklinik </span>
            </div>
            <?php /*
            <div class="dokter" id="dokter_<?php echo $i; ?>">
                <span>Nama Dokter</span>
            </div>
             * 
             */ ?>
            <div class="no-antrian">
                XX-000
            </div>
            <div class="pasien-deskripsi" id="pasien-deskripsi_<?php echo $i; ?>">
                <span> Nama Pasien </span>
            </div>
            <br>
            <iframe id="suarapanggilan" src="" style="display:none;">
            </iframe>
        </div>
    </div>
    <div class="isi_antrian">
        <?php
        if (count((array)$modRuangans) > 0) {
            foreach ($modRuangans as $i => $ruangan) {
                if (($i == 0) || ($i) % 4 == 0) {
                    echo '<div class="row">';
                }    ?>
                <div class="w1">
                    <div id="ruangan_<?php echo isset($ruangan->ruangan_id) ? $ruangan->ruangan_id : ''; ?>" class="antrian" style="width:230px;height:80px;">
                        <div class="ruangan" id="ruangan_nama_<?php echo $i; ?>">
                            <span><?php echo isset($ruangan->ruangan->ruangan_nama) ? strtoupper($ruangan->ruangan->ruangan_nama) : ''; ?></span>
                        </div>
                        <div class="dokter" id="dokter_<?php echo $i; ?>">
                            <span>Nama Dokter</span>
                        </div>
                        <div class="no-antrian">
                            <?php echo isset($ruangan->ruangan->ruangan_singkatan) ? $ruangan->ruangan->ruangan_singkatan : ''; ?>-000
                        </div>
                        <div class="pasien-deskripsi" id="pasien-deskripsi_<?php echo $i; ?>">
                            <span>Nama Pasien</span>
                        </div>
                        <?php echo $this->renderPartial('_formKunjungan', array('model' => $model)); ?>
                        <br>
                    </div>
                </div>
        <?php
                if (($i + 1 > 0) && (($i + 1) % 4 == 0)) {
                    echo '</div>';
                }
            }
        }
        ?>
        <?php $profil = ProfilrumahsakitM::model()->find(); ?>
    </div>
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
    <?php echo $this->renderPartial('_jsFunctions', array('model' => $model, 'modRuangans' => $modRuangans, 'modLayar' => $modLayar, 'konfig' => $konfig)); ?>
    <iframe id="suarapanggilan" src="" style="display:none;"></iframe>
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
        });
    </script>