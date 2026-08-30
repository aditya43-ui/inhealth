<script type="text/javascript">
function ubahLabelPanggilAntrianSelesai(statuspanggilan, obj){
    if (statuspanggilan == 'Pilih'){
        $("#judul-btn-selesaiantrian").html("Terpilih");
        $(obj).attr("data-status-panggilan","Sudah Selesai");        
        $(obj).attr("disabled", true);

        // untuk menampilkan form yang displaynya di none
        // $('#form-pasien').attr('style', 'margin-top: 17px; display: block;');
        // $('#data-kunjungan').attr('style', 'display: block;');
        // $('.form-actions').attr('style', 'display: block;');
        // untuk set no antrian
        var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
        var noantrian = $("#txt_no_antrian").val();
        var loket_id = $("#namaLoket").val();

        console.log('this is antrian id = ' + antrian_id);
        console.log('this is noantrian = ' + noantrian);
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('UpdateFlaq'); ?>',
            data: {
                antrian_id:antrian_id,
                noantrian:noantrian,
                loket_id:loket_id
            },
            dataType: "json",
            success:function(data){
                if(data.success = 1) {
                    $('#noantrian').val(noantrian);
                    $("#<?php echo CHtml::activeId($model, 'antrian_id')?>").val(antrian_id);
                    <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
                        socket.emit('send',{conversationID:'infoAntrian',panggil:11});
                    <?php } ?>
                } else {
                    myAlert(data.pesan);
                }
            }
        })
    }else{
        $("#judul-btn-selesaiantrian").html("Pilih");
        $(obj).attr("data-status-panggilan","Selesai");        
        $(obj).removeAttr("disabled");
    }
}
    
function ubahLabelPanggil(statuspanggilan, obj){
    if (statuspanggilan == 'Panggil'){
        $("#judul-btn-antrian").html("Sudah Dipanggil");
        $(obj).attr("data-status-panggilan","Sudah Dipanggil");
        ket = 'batal';
    }else{
        $("#judul-btn-antrian").html("Panggil"); 
        $(obj).attr("data-status-panggilan","Panggil");
    }
}
    
/**
 * pemanggilan antrian
 */
function panggilAntrian(ket, obj){
    var antrian_id = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id'); ?>").val();
    var noantrian = $("#txt_no_antrian").val();
    var sudahdipanggil = $("#<?php echo CHtml::activeId($modAntrian, 'panggil_flaq'); ?>").val();
    var attr_onclick = $("#btn-panggilantrian").attr("onclick"); //RTN-2259
    var loket_id = $("#namaLoket").val();
    const statuspanggilan = $(obj).attr("data-status-panggilan");
    if(antrian_id == ""){
        myAlert("Silakan tentukan antrian yang akan dipanggil!");
        return false;
    }
    if (loket_id == "") {
        myAlert("Silakan tentukan loket yang akan digunakan untuk memanggil antrian!");
        return false;
    }
        
    ubahLabelPanggil(statuspanggilan, obj);
    if (statuspanggilan != 'Panggil'){        
        ket = 'batal';
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
        url:'<?php echo $this->createUrl('Panggil'); ?>&antrian_id='+antrian_id+'&ket='+ket+'&loket_id='+loket_id+'&no_antrian='+noantrian,
        data: {},
        dataType: "json",
        success:function(data){
            // untuk memunculkan form yang di sembunyikan ketika masih belum panggil antrian pada permintaan issue rssa-2565
            // $('#form-pasien').attr('style', 'margin-top: 17px; display: block;');
            // $('#data-kunjungan').attr('style', 'display: block;');
            // $('.form-actions').attr('style', 'display: block;');
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
                socket.emit('send',{conversationID:'antrian',panggil:10,antrian_id:data.antrian_id});
                socket.emit('send',{conversationID:'infoAntrian',panggil:3});
                socket.emit('send',{conversationID:'infoAntrian',panggil:7,arr:{status:'panggil',antrianId:{antrian_id:antrian_id},loketId:loket_id}});
            <?php } ?>
            $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id')?>").val(data.antrian_id);
            $("#<?php echo CHtml::activeId($modAntrian, 'noantrian')?>").val(data.noantrian);
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
function setFormAntrian(record,antrianId=''){
    var modelantrian_id = $("#cari_loket_id").val(); //modelantrian
    var loket_id = $("#namaLoket").val();
    var noantrian = $("#<?php echo CHtml::activeId($modAntrian, 'noantrian'); ?>").val();
    $("#<?php echo CHtml::activeId($model, 'antrian_id')?>").val("");
    $("#noantrian").val("");
    if(record == "reset"){
        noantrian = "";
    }
    $("#dialog-panggilantrian > .dialog-content").addClass('animation-loading');
    $.ajax({
        type:'POST',
//        url:'<?php // echo $this->createUrl('SetFormAntrian'); ?>',
        url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetFormAntrian'); ?>',
        data: {
            loket_id, 
            noantrian : noantrian, 
            record:record,
            antrianId,
            modelantrian_id,            
        },
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            
            const listAntrianClone = $("#listAntrian").html();
            
            $("#dialog-panggilantrian > .dialog-content").html(data.form_antrian);
            $("#dialog-panggilantrian > .dialog-content").removeClass('animation-loading');
            
            let antrianId = '';
            $("#listAntrian").html(listAntrianClone);
            resetTombolStatusBarcode(data.antrianId);
            
            ubahLabelPanggil((data.panggil)?'Panggil':'Sudah Dipanggil', $("button[data-status-panggilan]"));            
            ubahLabelPanggilAntrianSelesai(data.statuspanggil, $("#btn-antrianselesai") );            
            
            genExt();
            
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function genExt(){
    $("#list_no_antrian").autocomplete(
        {
            'showAnim':'fold',
            'minLength':3,
            'focus':function(event, ui )
            {
                $(this).val("");
                return false;
            },
            'select':function( event, ui )
            {                                                
                setAntrianLoket(ui.item);
                return false;
            },
            'source':function(request, response)
            {                                                                                                                                  
                $.ajax({
                    url: "<?php echo $this->createUrl('AutocompleteNoAntrian');?>",
                    dataType: "json",
                    data:{
                        term: request.term,                                                
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            },
        }
    );
}

function setNamaLoket(idModelantrian){
	$.ajax({
        type:'POST',
//        url:'<?php // echo $this->createUrl('SetDropdownLoket'); ?>',
        url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/SetDropdownLoket'); ?>',
        data: {idModelantrian:idModelantrian},
        dataType: "json",
        success:function(data){
            $(".diLoketAjax").html(data.diLoket_antrian);
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
* no

 * @param {type} no
 * no 1 = Pending => berubah menjadi tombol selesai pending
 * no 2 = Selesai Pending => berubah menjadi tombol pending
 * 
 * no 1 dan 2, menggunakan tombol yang sama, hanya bertukar status dan label
 * 
 * no 3 = Terlambat => berubah menjadi tombol aktifkan dan hide tombol pending/selesai pending
 * no 4 = Aktifkan => berubah menjadi tombol terlambat dan tampilkan tombol pending/selesai pending
 * 
 * no 3 dan 4, menggunakan tombol yang sama, hanya bertukar status dan label
 * 
**/
function prosesStatusBarcode(no){
    const antrianID = $("#<?php echo CHtml::activeId($modAntrian, 'antrian_id')?>").val();
    const noAntrian = $("#txt_no_antrian").val();

    if (antrianID == ''){
        Notiflix.Report.Warning("Perhatian!","No Antrian belum ada yang dipilih","OK");
        return false;
    }
    
    const objListAntrianPending = $("#listAntrianPending");
    const objListAntrianTerlambat = $("#listAntrianTerlambat");

    $.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan/statusBarcodeAntrian'); ?>',
        data: {
            no,
            antrianID
        },
        dataType: "json",
        success:function(data){
            if (no == 1){
                objListAntrianPending.append("<option value='"+antrianID+"'>"+noAntrian+"</option>");
            }else if (no == 2){
                objListAntrianPending.find("option[value='"+antrianID+"']").detach();
            }else if (no == 3){
                objListAntrianTerlambat.append("<option value='"+antrianID+"'>"+noAntrian+"</option>");
            }else if (no == 4){
                objListAntrianTerlambat.find("option[value='"+antrianID+"']").detach();
            }else if (no == 7){
                ubahLabelPanggilAntrianSelesai('Pilih', $("#btn-antrianselesai"));
            }
            
            tombolStatusBarcode(no);
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function tombolStatusBarcode(no){
    const objBtnPending = $("#btn-pending");
    const objBtnTerlambat = $("#btn-terlambat");
    
    if (no == 1){        
        objBtnPending.html("<?= ParamsConst::STATUSBARCODE_ANTRIAN_SELESAIPENDING ?>");
        objBtnPending.attr("title", "Klik untuk mengubah status selesai pending antrian ini");
        objBtnPending.attr("onclick", "prosesStatusBarcode(2);");
    }else if (no == 2){
        objBtnPending.html("<?= ParamsConst::STATUSBARCODE_ANTRIAN_PENDING ?>");
        objBtnPending.attr("title", "Klik untuk mengubah status pending antrian ini");
        objBtnPending.attr("onclick", "prosesStatusBarcode(1);");
    }else if (no == 3){
        objBtnTerlambat.html("Aktifkan");
        objBtnTerlambat.attr("title", "Klik untuk mengubah status terlambat antrian ini");
        objBtnTerlambat.attr("onclick", "prosesStatusBarcode(4);");
        objBtnTerlambat.removeClass("btn-default");
        objBtnTerlambat.addClass("btn-success");
        
        objBtnPending.hide();
    }else if (no == 4){
        objBtnTerlambat.html("<?= ParamsConst::STATUSBARCODE_ANTRIAN_TERLAMBAT ?>");
        objBtnTerlambat.attr("title", "Klik untuk mengubah status pending antrian ini");
        objBtnTerlambat.attr("onclick", "prosesStatusBarcode(3);");
        objBtnTerlambat.removeClass("btn-success");
        objBtnTerlambat.addClass("btn-default");
        
        objBtnPending.show();
    }
    
    <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
        socket.emit('send',{conversationID:'infoAntrian',panggil:3});
    <?php } ?>
}

function resetTombolStatusBarcode(antrianId = 0){
    const objBtnPending = $("#btn-pending");
    const objBtnTerlambat = $("#btn-terlambat");
    
    const adaTerlambat = $("#listAntrianTerlambat").find("option[value='"+antrianId+"']").length;
    const adaPending = $("#listAntrianPending").find("option[value='"+antrianId+"']").length;
    
    if (adaTerlambat == 0 && adaPending == 0){
        objBtnPending.html("<?= ParamsConst::STATUSBARCODE_ANTRIAN_PENDING ?>");
        objBtnPending.attr("title", "Klik untuk mengubah status pending antrian ini");
        objBtnPending.attr("onclick", "prosesStatusBarcode(1);");

        objBtnTerlambat.html("<?= ParamsConst::STATUSBARCODE_ANTRIAN_TERLAMBAT ?>");
        objBtnTerlambat.attr("title", "Klik untuk mengubah status pending antrian ini");
        objBtnTerlambat.attr("onclick", "prosesStatusBarcode(3);");
        objBtnTerlambat.removeClass("btn-success");
        objBtnTerlambat.addClass("btn-default");
        
        objBtnPending.show();
    }else{        
        
        if (adaTerlambat > 0){
            objBtnPending.show();
            $("#listAntrianTerlambat").val(antrianId);
            tombolStatusBarcode(3);
        }else{            
            objBtnPending.show();
            if (adaPending > 0){
                $("#listAntrianPending").val(antrianId);                
                tombolStatusBarcode(1);
            }
        }
    }
}

function pilihNoAntrian(obj){
    const antrianId = $(obj).val();
    
    if (antrianId != ''){
        setFormAntrian('',antrianId);
    }
}

</script>