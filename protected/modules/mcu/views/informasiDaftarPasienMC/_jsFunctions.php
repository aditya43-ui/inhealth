<script type="text/javascript">
/**
 * memanggil antrian ke poliklinik
 * @param {type} pendaftaran_id
 * @returns {undefined} */
function panggilAntrian(pendaftaran_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('Panggil'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
            socket.emit('send',{conversationID:'antrian',panggil:1,antrian_id:pendaftaran_id});
            <?php } ?>
            $.fn.yiiGridView.update('daftarpasien-v-grid');
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

/**
 * suara panggilan per ruangan
 * @param {type} param
 * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
 */
function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){
    $("#suarapanggilan").attr("src","<?php echo $this->createUrl('/antrian/tampilAntrianKePoliklinik/suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
}

function setStatus(obj,status,pendaftaran_id,konsulpoli_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
    var konsulpoli_id = konsulpoli_id;
    window.parent.myConfirm(' Yakin Akan Merubah Status Periksa Pasien? ', 'Perhatian!', function(r){
        if(r){
            $.post('<?php echo $this->createUrl('UbahStatusPeriksaPasien');?>', {status:status ,pendaftaran_id:pendaftaran_id, konsulpoli_id:konsulpoli_id}, function(data){
                if(data.status == 'proses_form'){
					$('#dialogUbahStatusPasien div.divForForm').html(data.div);
					$.fn.yiiGridView.update('daftarpasien-v-grid');
					setTimeout("$('#dialogUbahStatus').dialog('close')",1000);
                }else{
                    $('#alertDiv').show(); 
                }
            }, 'json');
        }else{
			preventDefault();
        }
    });    
}
</script>

<!--Untuk Dialog Ubah Perawat-->
<script type="text/javascript">
    function loadDataPendaftaran()
    {
        var pendaftaran_id = $('#temp_idPendaftaranPPJP').val();
        $.post("<?php echo $this->createUrl('getDataPendaftaranMCU'); ?>", { pendaftaran_id: pendaftaran_id },
            function(data){
                $('#uubahKelPenyakit-form #MCPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
                $('#uubahKelPenyakit-form #MCPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
                $('#uubahKelPenyakit-form #np').val(data.nama_pasien);
                $('#uubahKelPenyakit-form #MCPendaftaranT_ruangan_id').val(data.ruangan_id);
                var perawat = data.perawatLengkap;
                $('#uubahKelPenyakit-form #dp').val(perawat);
                $('#uubahKelPenyakit-form #MCUbahperawatR_perawatlama_id').val(data.pegawai_id);
                listPerawatRuangan(data.ruangan_id, data.pegawai_id);
            },
        "json");
    }
    
    function listPerawatRuangan(idRuangan, idPegawai)
    {
        $.post("<?php echo $this->createUrl('/actionDynamic/ListPerawatRuangan')?>", { idPegawai:idPegawai, idRuangan: idRuangan },
            function(data){
                $('#uubahKelPenyakit-form #MCPendaftaranT_pegawai_id').html(data.listDokter);
        }, "json");
    }    
        
        $( document ).ready(function(){
            setValidasiCekDisabled($("#uubahKelPenyakit-form"), function() {                   
                   return true;
            });
        });
</script>


<script type="text/javascript">
    function loadDataPendaftaranDokter()
    {
        var pendaftaran_id = $('#temp_idPendaftaranDP').val();
        $.post("<?php echo ($this->module->id == 'mcu' ? $this->createUrl('getDataPendaftaranMCU') : Yii::app()->createUrl('pendaftaranPenjadwalan/infoKunjunganRJ/getDataPendaftaranRJ')); ?>", { pendaftaran_id: pendaftaran_id },
            function(data){
                $('#ubahKelPenyakit-form #MCPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
                $('#ubahKelPenyakit-form #MCPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
                $('#ubahKelPenyakit-form #np').val(data.nama_pasien);
                $('#ubahKelPenyakit-form #MCPendaftaranT_ruangan_id').val(data.ruangan_id);
                var dokter = data.gelardepan + " " + data.nama_pegawai + " " + data.gelarbelakang_nama;
                $('#ubahKelPenyakit-form #dp').val(dokter);
				$('#ubahKelPenyakit-form #MCUbahdokterR_dokterlama_id').val(data.pegawai_id);
                listDokterRuangan(data.ruangan_id);
                
                console.log("Kicker");
            },
        "json");
    }
    
    function listDokterRuangan(idRuangan)
    {
        $.post("<?php echo $this->createUrl('listDokterRuangan')?>", { idRuangan: idRuangan },
            function(data){
                $('#ubahKelPenyakit-form #MCPendaftaranT_pegawai_id').html(data.listDokter);
        }, "json");
    }    
	
</script>

<script>

function closeDialog(){
    window.parent.$('#editDokterPeriksa').dialog('close');
}

</script>