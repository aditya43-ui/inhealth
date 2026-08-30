<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/js.sound/jquery.jplayer.min.js'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/howler.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl.'/js/suara.antrian.js'; ?>"></script>

<script type="text/javascript">
/**
 * pemanggilan antrian
 */
function panggilAntrian(ket){
    var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
    var noantrian = $("#<?php echo CHtml::activeId($modAntrian, 'noantrian'); ?>").val();
    var pendaftaran_id = $("#<?php echo CHtml::activeId($modAntrian, 'pendaftaran_id'); ?>").val();
    var loket_id = $("#namaLoket").val();
    var loket = $("#namaLoket").val();
    if(loket_id == ""){
        myAlert("Silahkan tentukan Loket antrian terlebih dahulu !");
        return false;
    }
    if(antrian_id == ""){
        myAlert("Silahkan tentukan antrian yang akan dipanggil !");
        return false;
    }
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('Panggil'); ?>&antrian_id='+antrian_id+'&loket_id='+loket_id+'&ket='+ket,
        data: {},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            $("#BKPembayaranpelayananT_antrian_id").val(antrian_id);
            
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
            socket.emit('send',{conversationID:'antrian',panggil:10,antrian_id:antrian_id});
            <?php } ?>
            setFormAntrian(""); //refresh
            $("#noantrian").val(data.noantrian);
            setSuaraPanggilan([data.noantrian],[loket_id]);
            // setKunjungan(pendaftaran_id);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * 
 * @param {type} param
 */
function setSuaraPanggilan(noantrians, loket_ids){
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

/**
 * set form antrian 
 * @param {type} antrian_id
 * @returns {undefined} */
function setFormAntrian(record){
    var loket_id = $("#cari_loket_id").val();
    var noantrian = $("#<?php echo CHtml::activeId($modAntrian, 'noantrian'); ?>").val();
    var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
    //$("#<?php //echo CHtml::activeId($model, 'antrian_id')?>").val("");
    $("#noantrian").val("");
    if(record == "reset"){
        noantrian = "";
    }
    $("#dialog-panggilantrian > .dialog-content").addClass('animation-loading');
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetFormAntrian'); ?>',
        data: {antrian_id:antrian_id, loket_id:loket_id, noantrian : noantrian, record:record},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            $("#dialog-panggilantrian > .dialog-content").html(data.form_antrian);
            $("#dialog-panggilantrian > .dialog-content").removeClass('animation-loading');
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}


function setNamaLoket(idModelantrian){
	$.ajax({
        type:'POST',
//        url:'<?php // echo $this->createUrl('SetDropdownLoket'); ?>',
        url:'<?php echo Yii::app()->createUrl('billingKasir/pembayaranTagihanPasien/SetDropdownLoket'); ?>',
        data: {idModelantrian:idModelantrian},
        dataType: "json",
        success:function(data){
            $(".diLoketAjax").html(data.diLoket_antrian);
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

</script>