<script type="text/javascript">
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
					var antrian_id = $("#loket_"+obj.loket_id+" #<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val();
						//if(antrian_id != obj.antrian_id){
							noantrians[i] = obj.noantrian;
							loket_ids[i] = obj.loket_id;
							i++;
							setFormAntrian($("#loket_"+obj.loket_id),obj);
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
    $(obj).find("#<?php echo CHtml::activeId($model, 'tglantrian'); ?>").val(data.tglantrian);
    $(obj).find("#<?php echo CHtml::activeId($model, 'noantrian'); ?>").val(data.noantrian);
    $(obj).find("#<?php echo CHtml::activeId($model, 'statuspasien'); ?>").val(data.statuspasien);
    $(obj).find("#<?php echo CHtml::activeId($model, 'carabayar_loket'); ?>").val(data.carabayar_loket);
    $(obj).find("#<?php echo CHtml::activeId($model, 'panggil_flaq'); ?>").val(data.panggil_flaq);
    
    $(obj).find(".no-antrian").html(data.loket_singkatan+"-"+data.noantrian);
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

function updateStatistik(loket_id) {
    console.log(loket_id);
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('updateStatistik'); ?>',
        data: {loket_id:loket_id},
        dataType: "json",
        success:function(data){
            setTableStatistik($("#loket_"+loket_id),data.stat);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

$( document ).ready(function(){
    setAntrians('');
    <?php if($konfig->is_nodejsaktif){ ?>
    var chatServer='<?php echo $konfig->nodejs_host ?>';
    if (chatServer == ''){
        chatServer='http://localhost';
    }
    var chatPort='<?php echo $konfig->nodejs_port ?>';
    socket = io.connect(chatServer+':'+chatPort);
    socket.emit('subscribe', 'antrian');
    socket.on('antrian', function(data){
        console.log(data.loket_id);
        if (typeof data.loket_id !== 'undefined') {
            updateStatistik(data.loket_id);
        } else {
            if (data.panggil == 1) setAntrians(data.antrian_id);
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