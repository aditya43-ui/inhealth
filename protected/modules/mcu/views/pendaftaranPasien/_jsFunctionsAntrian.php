<script type="text/javascript">
/**
 * pemanggilan antrian
 */
function panggilAntrian(ket){
    var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
    var noantrian = $("#<?php echo CHtml::activeId($modAntrian, 'noantrian'); ?>").val();
    if(antrian_id == ""){
        myAlert("Silakan tentukan antrian yang akan dipanggil!");
        return false;
    }
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('Panggil'); ?>&antrian_id='+antrian_id+'&ket='+ket,
        data: {},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
            socket.emit('send',{conversationID:'antrian',panggil:1,antrian_id:antrian_id});
            <?php } ?>
            setFormAntrian(""); //refresh
            $("#noantrian").val(data.noantrian);
            $("#<?php echo CHtml::activeId($model, 'antrian_id')?>").val(data.antrian_id);
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
    $("#<?php echo CHtml::activeId($model, 'antrian_id')?>").val("");
    $("#noantrian").val("");
    if(record == "reset"){
        noantrian = "";
    }
    $("#dialog-panggilantrian > .dialog-content").addClass('animation-loading');
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetFormAntrian'); ?>',
        data: {loket_id:loket_id, noantrian : noantrian, record:record},
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
</script>