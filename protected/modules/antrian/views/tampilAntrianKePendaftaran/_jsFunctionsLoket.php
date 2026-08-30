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
        url:'<?php echo $this->createUrl('GetAntriansLoket'); ?>',
        data: {antrian_id:antrian_id},
        dataType: "json",
        success:function(data){
            var noantrians = [];
            var loket_ids = [];
            var ruangan_id = [];
            var html = '';
                var i = 0;
                for (var key in data) {
                    if (data.hasOwnProperty(key)) {
                        var obj = data[key];
                        if(obj.antrian_id !== null){
                        var antrian_id = $("#loket_"+obj.loket_singkatan+" #<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val();
                            noantrians[i] = obj.noantrian;
                            loket_ids[i] = obj.loket_id;
                            ruangan_id[i] = obj.ruangan_id;
                            html = obj.html;
                            i++;
                            setFormAntrian($("#loket_"+obj.loket_singkatan),obj);
                            
                            setTableStatistik($("#loket_"+obj.loket_id),obj);
                        }                        
                    }
                }
                console.log(i);
            if(i > 0){ //agar tidak memanggil ketika refresh interval fungsi ini kecuali jika noantrian berubah
                setSuaraPanggilan(noantrians,loket_ids, ruangan_id);
            }
            
            $("#form-list-antrian-belum-panggil").html(html);
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
    
    var noantrian = str_pad(data.noantrian, 3, '0', 'left');

    if(data.modelantrian_id == 1) {
        $(obj).find(".no-antrian").html(data.modelantrian_singkatan+"-"+noantrian);
    } else {
        $(obj).find(".no-antrian").html(data.ruangan_singkatan+"-"+noantrian);
    }
    $(obj).find(".loket-nama").find("div").html("LOKET "+data.loket_singkatan);
    if(data.jenis_kunjungan === 'fast track' || data.jenis_kunjungan === "Fast Track") {
        $(obj).find(".ruangan1").attr('style', 'background-color:#c00;height:5.5vw;padding:0;');
    } else {
        $(obj).find(".ruangan1").attr('style', 'background-color:#5ec196;height:5.5vw;padding:0;');
    }
    console.log(data.jenis_kunjungan);
}

function str_pad(input, length, padString, padType) {
  input = String(input);
  padString = padString || ' ';
  padType = padType || 'right';

  if (input.length >= length) {
    return input;
  }

  var padLength = length - input.length;
  var leftPadding = '';
  var rightPadding = '';

  if (padType === 'left') {
    leftPadding = padString.repeat(padLength);
  } else if (padType === 'right') {
    rightPadding = padString.repeat(padLength);
  } else if (padType === 'both') {
    var padSplit = padLength / 2;
    leftPadding = padString.repeat(Math.floor(padSplit));
    rightPadding = padString.repeat(Math.ceil(padSplit));
  }

  return leftPadding + input + rightPadding;
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
 * 
 * @param {type} param
 */
function setSuaraPanggilan(noantrians, loket_ids, ruangan_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('suaraPanggilan'); ?>',
        data: {noantrians:noantrians, loket_ids:loket_ids,untuk:'loket',ruangan_id},
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
        url:'<?php echo $this->createUrl('UpdateStatistikLoket'); ?>',
        data: {loket_id:loket_id},
        dataType: "json",
        success:function(data){
            setTableStatistik($("#loket_"+loket_id),data.stat);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

$( document ).ready(function(){  
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
    socket = io.connect(chatServer+':'+chatPort,{secure: true});
    socket.emit('subscribe', 'infoAntrian');
        
    socket.on('infoAntrian', function(data){           
        if (typeof data.arr !== 'undefined'){
            if (data.arr.loketId == '<?= $_GET['loket_id'] ?>' && data.panggil == 7) {                        
                let time = 0;            
                let i = 1;
                $.each(data.arr.antrianId, function(index, value){
                    setTimeout(()=>{
                        setAntrians(value);
                    }, i*time);                
                    time = 13000;
                    i++;
                });                            
            }
                  
        }
        if(data.panggil == 11) {
            location.reload();
        }  
    });
    <?php }else{ ?>

    <?php } ?>
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