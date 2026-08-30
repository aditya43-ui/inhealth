<script type="text/javascript">
    
var vidSources = <?php echo CJSON::encode($res_dat); ?>    


if (vidSources.length != 0) {

    if ($("#panel_video_antrian").length > 0) {

var videoContainer = document.getElementById('panel_video_antrian');
var output = document.getElementById('output');
var nextVideo;
var videoObjects =
    [
        document.createElement('video'),
        document.createElement('video')
    ];
    //random starting point
var nextActiveVideo = 0;

videoObjects[0].inx = 0; //set index
videoObjects[0].setAttribute("class", "padingvideo"); //set index
videoObjects[0].setAttribute("controls", "controls"); //set index
videoObjects[0].setAttribute("muted", "muted"); //set index
videoObjects[0].setAttribute("style", "width: 100%; line-height: 400px; background: #ddd; text-align: center;"); //set index

videoObjects[1].inx = 1;
videoObjects[1].setAttribute("class", "padingvideo"); //set index
videoObjects[1].setAttribute("controls", "controls"); //set index
videoObjects[1].setAttribute("muted", "muted"); //set index
videoObjects[1].setAttribute("style", "width: 100%; line-height: 400px; background: #ddd; text-align: center;"); //set index

initVideoElement(videoObjects[0]);
initVideoElement(videoObjects[1]);

videoObjects[0].autoplay = true;
videoObjects[0].src = vidSources[nextActiveVideo];
videoContainer.appendChild(videoObjects[0]);

videoObjects[1].style.display = 'none';
videoContainer.appendChild(videoObjects[1]);
    }

}


function initVideoElement(video)
{
    video.playsinline = true;
    video.muted = true;
    video.preload = 'auto'; //but do not set autoplay, because it deletes preload

    //loadedmetadata is wrong because if we use it then we get endless loop
    video.onplaying = function(e)
    {
        output.innerHTML = 'Current video source index: ' + nextActiveVideo;

        //select next index. If is equal vidSources.length then it is 0
        nextActiveVideo = ++nextActiveVideo % vidSources.length;

        //replace the video elements against each other:
        if(this.inx == 0)
            nextVideo = videoObjects[1];
        else
            nextVideo = videoObjects[0];

        nextVideo.src = vidSources[nextActiveVideo];
        nextVideo.pause();
        
        console.log("video", vidSources[nextActiveVideo]);
        
    };

    video.onended = function(e)
    {
        this.style.display = 'none';
        nextVideo.style.display = 'block';
        nextVideo.play();
    };
}



/**
 * set semua antrian 
 * @param {type} antrian_id
 * @returns {undefined} */
function setAntrians(antrian_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetAntrians'); ?>',
        data: {antrian_id:antrian_id},
        dataType: "json",
        success:function(data){
            var noantrians = [];
            var loket_ids = [];
			var i = 0;
			for (var key in data) {
				if (data.hasOwnProperty(key)) {
					var obj = data[key];
					if(obj.antrian_id !== null){
					var antrian_id = $("#loket_"+obj.loket_singkatan+" #<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val();
						//if(antrian_id != obj.antrian_id){
							noantrians[i] = obj.noantrian;
							loket_ids[i] = obj.loket_id;
							i++;
							setFormAntrian($("#loket_"+obj.loket_singkatan),obj);
						//}
					}
				    setTableStatistik($("#loket_"+obj.loket_id),obj);
				}
			}
			console.log(i);
            if(i > 0){ //agar tidak memanggil ketika refresh interval fungsi ini kecuali jika noantrian berubah
                setSuaraPanggilan(noantrians,loket_ids);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}


function setAntriansFarmasi(antrianfarmasi_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/antrian/tampilAntrianKeFarmasi/GetAntrians'); ?>',
        data: {antrianfarmasi_id:antrianfarmasi_id, is_pendaftaran: true, is_bpjs: <?php echo $this->is_bpjs ? 1 : 0; ?>},
        dataType: "json",
        success:function(data){
            var class_racikan = '';
            if (data != null) {
                if (data.ruangan != null) {
                    
                    if (data.antrian.racikan_id == 1) {
                        class_racikan = '.panel_antrian_racikan';
                    } else if (data.antrian.racikan_id == 2) {
                        class_racikan = '.panel_antrian_nonracikan';
                    }
                    
                    $(class_racikan + " .ruangan_farmasi span").html(data.ruangan.ruangan_nama);
                    $(class_racikan + " .pasien-deskripsi_farmasi span").html(data.pasien + " - " + data.penjualan.noresep);
                    $(class_racikan + " .no-antrian_farmasi").html(data.loket2.modelantrian_kode + data.loket.racikan_singkatan + "-" + data.antrian.noantrian);
                }
                $(".tab_racikan table tbody").html(data.tabel.racikan);
                $(".tab_nonracikan table tbody").html(data.tabel.nonracikan);
                setSuaraPanggilanFarmasi(data.loket2.modelantrian_kode, data.loket.racikan_singkatan,data.antrian.noantrian);
                
                
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * set semua antrian 
 * @param {type} antrian_id
 * @returns {undefined} */
function setAntriansKasir(antrian_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/antrian/tampilAntrianKeKasir/GetAntrians'); ?>',
        data: {antrian_id:antrian_id},
        dataType: "json",
        success:function(data){
            var noantrians = [];
            var loket_ids = [];
			var i = 0;
			for (var key in data) {
				if (data.hasOwnProperty(key)) {
					var obj = data[key];
					if(obj.antrian_id !== null){
					var antrian_id = $("#loket_"+obj.loket_id+" #<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val();
						//if(antrian_id != obj.antrian_id){
							noantrians[i] = obj.noantrian;
							loket_ids[i] = obj.loket_id;
							i++;
							setFormAntrian($("#loket_"+obj.loket_singkatan),obj);
						//}
					}
				    setTableStatistikKasir($("#loket_"+obj.loket_id),obj);
				}
			}
			console.log(i);
            if(i > 0){ //agar tidak memanggil ketika refresh interval fungsi ini kecuali jika noantrian berubah
                setSuaraPanggilanKasir(noantrians,loket_ids);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * set div antrian
 * @param {type} obj
 * @param {type} data
 * @returns {undefined} */
function setFormAntrian(obj, data){
    $(obj).find("#<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val(data.antrian_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").val(data.ruangan_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'carabayar_id'); ?>").val(data.carabayar_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'pendaftaran_id'); ?>").val(data.pendaftaran_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'profilrs_id'); ?>").val(data.profilrs_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'loket_id'); ?>").val(data.loket_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'modelantrian_id'); ?>").val(data.modelantrian_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'tglantrian'); ?>").val(data.tglantrian);
    $(obj).find("#<?php echo CHtml::activeId($model, 'noantrian'); ?>").val(data.noantrian);
    $(obj).find("#<?php echo CHtml::activeId($model, 'statuspasien'); ?>").val(data.statuspasien);
    $(obj).find("#<?php echo CHtml::activeId($model, 'carabayar_loket'); ?>").val(data.carabayar_loket);
    $(obj).find("#<?php echo CHtml::activeId($model, 'panggil_flaq'); ?>").val(data.panggil_flaq);
    
    $(obj).find(".no-antrian").html(data.modelantrian_singkatan+"-"+data.noantrian);
    $(obj).find(".loket-nama").html("LOKET "+data.loket_singkatan);
}

/**
 * set tabel statistik
 * @param {type} obj
 * @param {type} data
 * @returns {undefined}
 */
function setTableStatistik(obj, data){
    $(obj).find("#jmlpasien").html(data.jmlpasien);
    $(obj).find("#jmlmenunggu").html(data.jmlmenunggu);
    $(obj).find("#jmlterdaftar").html(data.jmlterdaftar);
    $(obj).find("#jmlterlewatkan").html(data.jmlterlewatkan);
}

/**
 * set tabel statistik
 * @param {type} obj
 * @param {type} data
 * @returns {undefined}
 */
function setTableStatistikKasir(obj, data){
    $(obj).find("#jmlpasien").html(data.jmlpasien);
    $(obj).find("#jmlmenunggu").html(data.jmlmenunggu);
    $(obj).find("#jmlterdaftar").html(data.jmlterdaftar);
}

/**
 * 
 * @param {type} param
 */
function setSuaraPanggilan(noantrians, loket_ids){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('suaraPanggilan'); ?>',
        data: {noantrians:noantrians, loket_ids:loket_ids},
        dataType: "json",
        success:function(data){
            $("#suarapanggilan").html(data.suarapanggilan);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * 
 * @param {type} param
 */
function setSuaraPanggilanFarmasi(loket, kodeantrians,noantrians){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/antrian/tampilAntrianKeFarmasi/suaraPanggilan'); ?>',
        data: {loket: loket, kodeantrians:kodeantrians,noantrians:noantrians},
        dataType: "json",
        success:function(data){
            $("#suarapanggilan").html(data.suarapanggilan);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}


/**
 * 
 * @param {type} param
 */
function setSuaraPanggilanKasir(noantrians, loket_ids){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/antrian/tampilAntrianKeKasir/suaraPanggilan'); ?>',
        data: {noantrians:noantrians, loket_ids:loket_ids},
        dataType: "json",
        success:function(data){
            $("#suarapanggilan").html(data.suarapanggilan);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function updateStatistik(loket_id) {
    console.log(loket_id);
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('updateStatistikModel'); ?>',
        data: {loket_id:loket_id},
        dataType: "json",
        success:function(data){
            setTableStatistik($("#loket_"+loket_id),data.stat);
            setTableStatistik($("#loket2_"+loket_id),data.stat);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

$( document ).ready(function(){
    <?php if (strtolower($this->action->id) == 'indexfarmasi'): ?>
        setAntriansFarmasi('');
    <?php endif; ?>
    //setAntrians('');
    <?php if($konfig->is_nodejsaktif){ ?>
    <?php 
            if (!empty($konfig->nodejs_host)){
    ?>
                    var chatServer='<?php echo 	$konfig->nodejs_host; ?>';
                    var chatPort='<?php echo 	$konfig->nodejs_port; ?>';                                        
    <?php
            }else{
    ?>
                    var chatServer='localhost';
                    var chatPort='3000';
    <?php
            }
    ?>	
    console.log("Trucks");
    socket = io.connect(chatServer+':'+chatPort,{secure: true});
    socket.emit('subscribe', 'antrian');
    socket.on('antrian', function(data){
        console.log(data);
        if (typeof data.loket_id !== 'undefined') {
            updateStatistik(data.loket_id);
        } else {
            if (data.panggil == 1) setAntrians(data.antrian_id);
            if (data.panggil == 10) setAntriansKasir(data.antrian_id);
            <?php if (in_array(strtolower($this->action->id), array('indexfarmasi', 'indexfarmasibpjs'))): ?>
            else if (data.panggil == 5) setAntriansFarmasi(data.antrian_id);
            <?php endif; ?>
        }
    });
    <?php }else{ ?>
    setInterval(function(){setAntrians('');},4000);
    <?php } ?>
    //DINONAKTIF KAN KARENA BERAT JIKA DI EKSEKUSI DI SMART TV BOX (TARAKAN) >> setInterval(function(){reloadHalaman();},1000);
    
    refreshAt(1, 0, 0);
});   

function refreshAt(hours, minutes, seconds) {
    var now = new Date();
    var then = new Date();

    if(now.getHours() > hours ||
       (now.getHours() == hours && now.getMinutes() > minutes) ||
        now.getHours() == hours && now.getMinutes() == minutes && now.getSeconds() >= seconds) {
        then.setDate(now.getDate() + 1);
    }
    then.setHours(hours);
    then.setMinutes(minutes);
    then.setSeconds(seconds);

    var timeout = (then.getTime() - now.getTime());
    setTimeout(function() { window.location.reload(true); }, timeout);
}

</script>