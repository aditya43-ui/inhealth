<script type="text/javascript">
/**
 * pemanggilan antrian
 */
function panggilAntrian(ket){
    var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
    var noantrian = $("#<?php echo CHtml::activeId($modAntrian, 'noantrian'); ?>").val();
    var jml_panggil = parseInt($("#<?php echo CHtml::activeId($modAntrian, 'jml_panggil'); ?>").val());
    var sudahdipanggil = $("#<?php echo CHtml::activeId($modAntrian, 'panggil_flaq'); ?>").val();
    var attr_onclick = $("#btn-panggilantrian").attr("onclick"); //RTN-2259
    var loket_id = $("#cari_loket_id").val();
    var modelantrian_id = $("#modelantrian_id").val();
    
    if(modelantrian_id == "" && loket_id == ""){
        myAlert("Silakan tentukan antrian yang akan dipanggil!");
        return false;
    }
    if(loket_id == ""){
        myAlert("Silakan tentukan loket antrian!");
        return false;
    }

    if(jml_panggil >= 3 && ket != 'ulang'){
        myConfirm('Panggil antrian pasien yang ke '+(jml_panggil+1)+' kali nya?','Perhatian!',
        function(r){
            if(r){
                panggilAntrian('ulang');
            }else{
                return false;
            }
        });
        return false;
    }
    
    if(ket == 'panggil' && antrian_id==''){
        myAlert("Silakan tentukan antrian yang akan dipanggil!");
        return false;
    }
    
    $("#dialog-panggilantrian .btn-primary").parent().addClass('animation-loading');
    $("#panggil").addClass('animation-loading');
    $('#dialog-panggilantrian .btn-primary').attr("disabled",true);
    // $('#dialog-panggilantrian .btn-primary').removeAttr("onclick");
    $.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/Panggil'); ?>&antrian_id='+antrian_id+'&ket='+ket+'&loket_id='+loket_id,
        data: {},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
            socket.emit('send',{conversationID:'antrian',panggil:1,antrian_id:antrian_id});
            socket.emit('send',{conversationID:'panggilAntrianPendaftaran',antrian_id:antrian_id,user_id:data.update_loginpemakai_id});
            <?php } ?>
//            setFormAntrian("reset");
            $("#noantrian").html(data.noantrian+' <i class="icon-volume-up icon-white"></li>');
            if(data.jml_panggil != null){
                $('.badge_jmlPanggil').html(data.jml_panggil+' x');
                $('.badge_jmlPanggil').show();
            }else{
                $('.badge_jmlPanggil').html();
                $('.badge_jmlPanggil').hide();
            }
            $('.jml_antrian_free').html(data.sisaAntrian);
            $('.jml_antrian_free').show();
            
            $("#<?php echo CHtml::activeId($modAntrian, 'jml_panggil'); ?>").val(data.jml_panggil);
            $("#<?php echo CHtml::activeId($model, 'antrian_id')?>").val(data.antrian_id);
                        setTimeout(function(){
                                $("#dialog-panggilantrian .btn-primary").parent().removeClass('animation-loading');
                                $('#dialog-panggilantrian .btn-primary').removeAttr("disabled");
                                $("#panggil").removeClass("animation-loading");
                                // $('#dialog-panggilantrian .btn-primary').attr("onclick",attr_onclick);
                                $(".f_rm:first").focus();
                        },3000); //3 detik tombol baru aktif
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $('#panggil').removeClass("animation-loading");
        }
    });
    
}
/*
* 
* Batal Antrian
*/
function batalPanggil() {
    var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
    if (typeof antrian_id === "undefined"){
        antrian_id = $("#<?php echo CHtml::activeId($model, 'antrian_id'); ?>").val();
    }
    if(antrian_id==''){
        myAlert("Silakan tentukan antrian yang akan dipanggil!");
        return false;
    }else{
        myConfirm('Apakah akan batal antrian ini?','Perhatian!',
        function(r){
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/batalPanggil'); ?>',
                    data: {antrian_id:antrian_id},
                    dataType: "json",
                        success:function(data){
                        if(data.status == true){
                            myAlert(data.pesan);
                        }else{
                            myAlert(data.pesan);	
                        }	
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });
            }else{
                return false;
            }
        });
    }
}

/**
 * set form antrian 
 * @param {type} antrian_id
 * @returns {undefined} */
function setFormAntrian(record){
    var loket_id = $("#cari_loket_id").val();
    var modelantrian_id = $("#modelantrian_id").val();
    var noantrian = $("#<?php echo CHtml::activeId($modAntrian, 'noantrian'); ?>").val();
    $("#<?php echo CHtml::activeId($model, 'antrian_id')?>").val("");

    if(record == "reset"){
        noantrian = "";
    }
    if (loket_id == 1) {
        $(".rb_rm").eq(0).click();
    } else if (loket_id == 2) {
        $(".rb_rm").eq(1).click();
    }
    
    if(loket_id == '' && record != 'ulangi'){
        myAlert("Silakan tentukan loket antrian!");
        record = 'ulangi';
    }
    if(modelantrian_id == ""){
//        myAlert("Silakan tentukan antrian yang akan dipanggil!");
        record = 'ulangi';
    }
    if(noantrian == "" && record == 'prev'){
        myAlert("Antrian Habis!");
        return false;
    }
    
    $("#dialog-panggilantrian > .dialog-content").addClass('animation-loading');
    $.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetFormAntrian'); ?>',
        data: {loket_id:loket_id, noantrian : noantrian, record:record, modelantrian_id : modelantrian_id},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            $("#dialog-panggilantrian > .dialog-content").html(data.form_antrian);
            $("#dialog-panggilantrian > .dialog-content").removeClass('animation-loading');
            $("#noantrian").html(data.noantrian+' <i class="icon-volume-up icon-white"></li>');
            if(data.jml_panggil != null){
                $('.badge_jmlPanggil').html(data.jml_panggil+' x');
                $('.badge_jmlPanggil').show();
            }else{
                $('.badge_jmlPanggil').html();
                $('.badge_jmlPanggil').hide();
            }
            $('.jml_antrian_free').html(data.sisaAntrian);
            $('.jml_antrian_free').show();
            $(".f_rm:first").focus();
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    
}

function setDropdownModelAntrian(){
    var lokasi = $('#lokasi_karcisantrian').val();
    $('#modelantrian_id').empty();
    $('#cari_loket_id').empty();
    $('#modelantrian_id').html('<option value="">-- Pilih --</option>');
    $('#cari_loket_id').html('<option value="">-- Pilih --</option>');
    
    if(lokasi != ''){
        $.ajax({
            type:'POST',
            url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetModelAntrian'); ?>',
            data: {lokasi:lokasi},
            dataType: "json",
            success:function(data){
                $('#modelantrian_id').empty();
                $('#modelantrian_id').html(data.listModelAntrian);
                $('#cari_loket_id').empty();
                $('#cari_loket_id').html(data.listLoketAntrian);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
   
    setFormAntrian("ulangi"); //refresh
}
function setDropdownLoket(){
    var modelantrian_id = $('#modelantrian_id').val();
    $('#cari_loket_id').empty();
    $('#cari_loket_id').html('<option value="">-- Pilih --</option>');
    setFormAntrian("ulangi"); //refresh
    
    if(modelantrian_id != ''){
        $.ajax({
            type:'POST',
            url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetLoketAntrian'); ?>',
            data: {modelantrian_id:modelantrian_id},
            dataType: "json",
            success:function(data){
                $('#cari_loket_id').empty();
                $('#cari_loket_id').html(data.listLoketAntrian);
                $('.jml_antrian_free').html(data.sisaAntrian);
                $('.jml_antrian_free').show();
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
        setFormAntrian("ulangi"); //refresh
    }
}

$( document ).ready(function(){ 
    <?php 
    if(isset($_GET['antrian_id']) && !empty($_GET['antrian_id'])){
    ?>
        $.ajax({
            type:'POST',
            url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetAntrianPendaftaran'); ?>',
            data: {antrian_id:'<?php echo $_GET['antrian_id']; ?>'},
            dataType: "json",
            success:function(data){
                if(data.pesan == "OK"){
                    $('#lokasi_karcisantrian').val(data.lokasi_karcisantrian_id);
                    $('#modelantrian_id').empty();
                    $('#modelantrian_id').html(data.listModelAntrian);
                    $('#cari_loket_id').empty();
                    $('#cari_loket_id').html(data.listLoketAntrian);
                    setFormAntrian("reset");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    <?php
    }
    ?>
    
    <?php if(Yii::app()->user->getState('is_nodejsaktif') && empty($model->antrian_id)){ ?>
        var chatServer='<?php echo Yii::app()->user->getState("nodejs_host") ?>';
        if (chatServer == ''){
         chatServer='http://localhost';
        }
        var chatPort='<?php echo Yii::app()->user->getState("nodejs_port") ?>';
        socket = io.connect(chatServer+':'+chatPort);
        socket.emit('subscribe', 'panggilAntrianPendaftaran');
        socket.on('panggilAntrianPendaftaran', function(data){
            var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
            var loket_id = $("#cari_loket_id").val();
            console.log(data.antrian_id);
            if(data.user_id != '<?php echo Yii::app()->user->id; ?>' && antrian_id != '' && antrian_id == data.antrian_id && loket_id != ''){
                setFormAntrian("reset");
            }
        });
    <?php } ?>
});

</script>