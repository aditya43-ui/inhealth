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
        myAlert("Silahkan tentukan antrian yang akan dipanggil !");
        return false;
    }
    if(loket_id == ""){
        myAlert("Silahkan tentukan loket antrian !");
        return false;
    }

    if(jml_panggil >= 3 && ket != 'ulang'){
        myConfirm('Panggil antrian pasien yang ke '+(jml_panggil+1)+' kali nya ?','Perhatian!',
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
        myAlert("Silahkan tentukan antrian yang akan dipanggil !");
        return false;
    }
    
    $(".panggil_antrian").addClass('animation-loading');
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('Panggil'); ?>',
        data: {
            antrian_id:antrian_id, 
            ket:ket, 
            loket_id:loket_id,
            lokasi_karcisantrian: $("#lokasi_karcisantrian").val()
        },
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            <?php if($konfig->is_nodejsaktif){ ?>                        
            socket.emit('send',{conversationID:data.set_antrian,panggil:1,antrian_id:antrian_id});
            socket.emit('send',{conversationID:'panggilAntrianHasilPenunjang',antrian_id:antrian_id,user_id:data.update_loginpemakai_id,loket_id:loket_id});
            <?php } ?>
            $("#<?php echo CHtml::activeId($modAntrian, 'jml_panggil'); ?>").val('');
            $("#antrian_blm_dipanggil").html(data.sisaAntrian);
            $("#antrian_tdk_datang").html(data.jumlah_antrian_tidak_datang);
            $("#jumlah_antrian").html(data.jumlah_antrian);
            $("#<?php echo CHtml::activeId($modAntrian, 'jml_panggil')?>").val(data.jml_panggil);
            if(data.jml_panggil != null){
                $('.badge_jmlPanggil').html(data.jml_panggil+' x');
                $('.badge_jmlPanggil').show();
            }else{
                $('.badge_jmlPanggil').html('0 x');
                $('.badge_jmlPanggil').show();
            }
            $('.panggil_antrian').removeClass("animation-loading");
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $('.panggil_antrian').removeClass("animation-loading");
        }
    });
    
}
/*
* 
* Batal Antrian
*/
function batalPanggil() {
    var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
    var jml_panggil = $("#<?php echo CHtml::activeId($modAntrian, 'jml_panggil'); ?>").val();
    if (typeof antrian_id === "undefined"){
        antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
    }
    if(antrian_id==''){
        myAlert("Silahkan tentukan antrian yang akan dipanggil !");
        return false;
    }else if(jml_panggil == ''){
        myAlert("Silahkan panggil antrian terlebih dahulu !");
        return false;
    }else{
        myConfirm('Apakah akan batal antrian ini ?','Perhatian!',
        function(r){
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('batalPanggil'); ?>',
                    data: {antrian_id:antrian_id},
                    dataType: "json",
                        success:function(data){
                        if(data.status == true){
                            myAlert(data.pesan);
                            setFormAntrian("reset");
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

    if(record == "reset"){
        noantrian = "";
    }
    if (loket_id == 1) {
        $(".rb_rm").eq(0).click();
    } else if (loket_id == 2) {
        $(".rb_rm").eq(1).click();
    }
    
    if(loket_id == '' && record != 'ulangi'){
        //myAlert("Silahkan tentukan loket antrian !");
        record = 'ulangi';
    }
    if(modelantrian_id == ""){
//        myAlert("Silahkan tentukan antrian yang akan dipanggil !");
        record = 'ulangi';
    }
    if(noantrian == "" && record == 'prev'){
        myAlert("Antrian Habis !");
        return false;
    }
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetFormAntrian'); ?>',
        data: {loket_id:loket_id, noantrian : noantrian, record:record, modelantrian_id : modelantrian_id},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
                if(record=="next" || record=="prev"){
                    return false;
                }
            }
            $("#<?php echo CHtml::activeId($modAntrian, 'jml_panggil'); ?>").val('');
            $("#kode_antrian").html(data.modelantrian_singkatan);
            $("#no_antrian").html(data.noantrian);
            $("#antrian_blm_dipanggil").html(data.sisaAntrian);
            $("#antrian_tdk_datang").html(data.jumlah_antrian_tidak_datang);
            $("#jumlah_antrian").html(data.jumlah_antrian);
            $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id')?>").val(data.antrian_id);
            $("#<?php echo CHtml::activeId($modAntrian, 'jml_panggil')?>").val(data.jml_panggil);
            $("#<?php echo CHtml::activeId($modAntrian, 'noantrian')?>").val(data.noantrian);
            if(data.jml_panggil != null){
                $('.badge_jmlPanggil').html(data.jml_panggil+' x');
                $('.badge_jmlPanggil').show();
            }else{
                $('.badge_jmlPanggil').html('0 x');
                $('.badge_jmlPanggil').show();
            }
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
        }
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
            url:'<?php echo $this->createUrl('SetModelAntrian'); ?>',
            data: {lokasi:lokasi},
            dataType: "json",
            success:function(data){
                $('#modelantrian_id').empty();
                $('#modelantrian_id').html(data.listModelAntrian);
//                $('#cari_loket_id').empty();
//                $('#cari_loket_id').html(data.listLoketAntrian);
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
    
    if(modelantrian_id != ''){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetLoketAntrian'); ?>',
            data: {modelantrian_id:modelantrian_id},
            dataType: "json",
            success:function(data){
                $('#cari_loket_id').empty();
                $('#cari_loket_id').html(data.listLoketAntrian);
                $('.jml_antrian_free').html(data.sisaAntrian);
                $('.jml_antrian_free').show();
                setFormAntrian("ulangi"); //refresh
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
        
    }else{
        setFormAntrian("ulangi"); //refresh
    }
}


/**
 * set form antrian 
 * @param {type} antrian_id
 * @returns {undefined} */
function setHitunganNomorAntrian(){
    var modelantrian_id = $("#modelantrian_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetHitunganNomorAntrian'); ?>',
        data: {modelantrian_id : modelantrian_id},
        dataType: "json",
        success:function(data){
            $("#antrian_blm_dipanggil").html(data.sisaAntrian);
            $("#antrian_tdk_datang").html(data.jumlah_antrian_tidak_datang);
            $("#jumlah_antrian").html(data.jumlah_antrian);
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
        }
    });
    
}

$( document ).ready(function(){ 
    <?php 
    if(isset($_GET['antrian_id']) && !empty($_GET['antrian_id'])){
    ?>
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SetAntrianPendaftaran'); ?>',
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
    
    
        var chatServer = '<?php echo $konfig->nodejs_host ?>';
        if (chatServer == '') {
            chatServer = 'http://localhost';
        }
        var chatPort = '<?php echo $konfig->nodejs_port ?>';
        socket = io.connect(chatServer + ':' + chatPort);
        socket = io.connect(chatServer+':'+chatPort);
        socket.emit('subscribe', 'panggilAntrianHasilPenunjang');
        socket.on('panggilAntrianHasilPenunjang', function(data){
            var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
            var loket_id = $("#cari_loket_id").val();
                        
            if(antrian_id != '' && antrian_id == data.antrian_id && loket_id != '' && loket_id != data.loket_id){
                setFormAntrian("reset");
                setHitunganNomorAntrian();
            }
        });
        socket.emit('subscribe', 'panggilAntrianPendaftaran');
        socket.on('panggilAntrianPendaftaran', function(data){
            var modelantrian_id = $("#modelantrian_id").val();
            
            if(modelantrian_id != '' && modelantrian_id == data.antrian_id){
                setHitunganNomorAntrian();
            }
        });
    
    setDropdownModelAntrian();
});

</script>