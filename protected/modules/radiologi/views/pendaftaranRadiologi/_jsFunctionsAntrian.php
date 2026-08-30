<script type="text/javascript">
/**
 * pemanggilan antrian
 */
function panggilAntrian(ket){
    var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
    var noantrian = $("#<?php echo CHtml::activeId($modAntrian, 'noantrian'); ?>").val();
	var sudahdipanggil = $("#<?php echo CHtml::activeId($modAntrian, 'panggil_flaq'); ?>").val();
	var attr_onclick = $("#btn-panggilantrian").attr("onclick"); //RTN-2259
    if(antrian_id == ""){
        myAlert("Silakan tentukan antrian yang akan dipanggil!");
        return false;
    }
	//if(sudahdipanggil == 1){ //RTN-2259
	//	myAlert("Pasien ini sudah dipanggil!");
	//	return false;	
	//}
	$("#dialog-panggilantrian .btn-primary").parent().addClass('animation-loading');
	$('#dialog-panggilantrian .btn-primary').attr("disabled",true);
	// $('#dialog-panggilantrian .btn-primary').removeAttr("onclick");
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
			setTimeout(function(){
				$("#dialog-panggilantrian .btn-primary").parent().removeClass('animation-loading');
				$('#dialog-panggilantrian .btn-primary').removeAttr("disabled");
				// $('#dialog-panggilantrian .btn-primary').attr("onclick",attr_onclick);
                                $(".f_rm:first").focus();
			},3000); //3 detik tombol baru aktif
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
    if (loket_id == 1) {
        $(".rb_rm").eq(0).click();
    } else if (loket_id == 2) {
        $(".rb_rm").eq(1).click();
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
            $(".f_rm:first").focus();
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function setNamaLoket(idModelantrian){
	$.ajax({
        type:'POST',
//        url:'<?php // echo $this->createUrl('SetDropdownLoket'); ?>',
        url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRadiologiPP/SetDropdownLoket'); ?>',
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