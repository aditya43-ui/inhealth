<script type="text/javascript">
/**
 * set antrian berdasarkan nr / or
 * @param {type} antrian_id
 * @returns {undefined} */
function setAntrians(antrianfarmasi_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetAntrians'); ?>',
        data: {antrianfarmasi_id:antrianfarmasi_id},
        dataType: "json",
        success:function(data){
            // console.log(data.loket2)
            if (data != null) {
                $(".ruangan span").html(data.ruangan.ruangan_nama);
                $(".pasien-deskripsi span").html(data.pasien + " - " + data.penjualan.noresep);
                $(".no-antrian").html(data.loket2.modelantrian_kode + data.loket.racikan_singkatan + "-" + data.antrian.noantrian);
                setSuaraPanggilan(data.loket.racikan_singkatan,data.antrian.noantrian,data.loket2.modelantrian_kode
);
            }
            /*
            var i = 0;
            var kodeantrians = [];
            var noantrians = [];
            var loket_ids = [];
            if(data.racikan.antrianfarmasi_id !== null){
                var antrianfarmasi_id = $("#loket_1").find("#<?php echo CHtml::activeId($model, 'antrianfarmasi_id'); ?>").val();
                if(antrianfarmasi_id != data.racikan.antrianfarmasi_id){
                    kodeantrians[i] = data.racikan.kodeantrian;
                    noantrians[i] = data.racikan.noantrian;
                    loket_ids[i] = data.racikan.racikan_id;
                    i++;
                    setFormAntrian($("#loket_1"),data.racikan);
                }
            }
            if(data.nonracikan.antrianfarmasi_id !== null){
                var antrianfarmasi_id = $("#loket_2").find("#<?php echo CHtml::activeId($model, 'antrianfarmasi_id'); ?>").val();
                if(antrianfarmasi_id != data.nonracikan.antrianfarmasi_id){
                    kodeantrians[i] = data.nonracikan.kodeantrian;
                    noantrians[i] = data.nonracikan.noantrian;
                    loket_ids[i] = data.nonracikan.racikan_id;
                    i++;
                    setFormAntrian($("#loket_2"),data.nonracikan);
                }
            }
            
            if(i > 0){ //agar tidak memanggil ketika refresh interval fungsi ini kecuali jika noantrian berubah
                setSuaraPanggilan(kodeantrians,noantrians,loket_ids);
            }
            $("#daftarantrian_1 .daftar-isi").html(data.racikan.daftarantrian);
            $("#daftarantrian_2 .daftar-isi").html(data.nonracikan.daftarantrian);
                */
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
    $(obj).find("#<?php echo CHtml::activeId($model, 'antrianfarmasi_id'); ?>").val(data.antrianfarmasi_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'racikan_id'); ?>").val(data.racikan_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>").val(data.ruangan_id);
    $(obj).find("#<?php echo CHtml::activeId($model, 'tglambilantrian'); ?>").val(data.tglambilantrian);
    $(obj).find("#<?php echo CHtml::activeId($model, 'noantrian'); ?>").val(data.noantrian);
    $(obj).find("#<?php echo CHtml::activeId($model, 'panggilantrian'); ?>").val(data.panggilantrian);
    $(obj).find("#<?php echo CHtml::activeId($model, 'antrianlewat'); ?>").val(data.antrianlewat);
    $(obj).find("#kodeantrian").val(data.kodeantrian);
    
    $(obj).find(".no-antrian").html(data.kodeantrian+"-"+data.noantrian);
}

/**
 * 
 * @param {type} param
 */
function setSuaraPanggilan(kodeantrians,noantrians, modelantrians){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('suaraPanggilan'); ?>',
        data: {kodeantrians:kodeantrians,noantrians:noantrians, modelantrians:modelantrians},
        dataType: "json",
        success:function(data){
            $("#suarapanggilan").html(data.suarapanggilan);
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
        console.log(data)
        if (data.panggil == 5) setAntrians(data.antrian_id);
    });
    <?php }else{ ?>
		setInterval(function(){setAntrians('');},4000);
    <?php } ?>
    //DINONAKTIF KAN KARENA BERAT JIKA DI EKSEKUSI DI SMART TV BOX (TARAKAN) >> setInterval(function(){reloadHalaman();},1000);
});    
</script>