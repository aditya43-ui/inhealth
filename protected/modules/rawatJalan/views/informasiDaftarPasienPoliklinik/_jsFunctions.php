<script type="text/javascript">
/**
 * memanggil antrian ke poliklinik
 * @param {type} pendaftaran_id
 * @returns {undefined} */
function panggilAntrian(pendaftaran_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/rawatJalan/daftarPasien/Panggil'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.data.pesan !== ""){
				myAlert(data.data.pesan);
			}
			if(data.data.smspasien==0){
				var params = [];
				params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
				insert_notifikasi(params);
			}
			<?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
			console.log("ANTRIAN POLI : emitting...");
			socket.emit('send',{conversationID:'antrian',panggil:5,antrian_id:data.data.pendaftaran_id});
			console.log('selesai emit');
			// setSuaraPanggilanSingle(data.data.ruangan_singkatan,data.data.no_urutantri,data.data.ruangan_id);
			<?php } ?>
            $.fn.yiiGridView.update('daftarpasien-v-grid');
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function ubahKasusPenyakit(obj,pendaftaran_id, jeniskasuspenyakit_id){
	var pendaftaran_id = pendaftaran_id;
	var jeniskasuspenyakit_id = jeniskasuspenyakit_id;
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('SetDropdownKasusPenyakit'); ?>',
	   data: {pendaftaran_id:pendaftaran_id,jeniskasuspenyakit_id:jeniskasuspenyakit_id},
	   dataType: "json",
	   success:function(data){
			$(obj).parents('tr').find('.list_kasus_penyakit').append(data.kasusPenyakit);
			$(obj).parents('td').find('.kasus_penyakit').hide();			
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
   });	
   return false;
}

function saveKasusPenyakit(obj,pendaftaran_id){
	var jeniskasuspenyakit_id = $(obj).val();
	var pendaftaran_id = pendaftaran_id;
	$.ajax({
	   type:'POST',
	   url:'<?php echo $this->createUrl('saveKasusPenyakit'); ?>',
	   data: {pendaftaran_id:pendaftaran_id,jeniskasuspenyakit_id:jeniskasuspenyakit_id},
	   dataType: "json",
	   success:function(data){
		   if(data.pesan == 'berhasil'){
				myAlert('Data Kasus Penyakit berhasil di ubah');
				$.fn.yiiGridView.update('daftarpasien-v-grid', {
					data: $(this).serialize()
				});
		   }else{
			   myAlert('Data Kasus Penyakit gagal di ubah');
		   }	
	   },
	   error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
   });	
   return false;
}
/**
 * suara panggilan per ruangan
 * @param {type} param
 * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
 */
function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){
    $("#suarapanggilan").attr("src","<?php echo $this->createUrl('/antrian/tampilAntrianKePoliklinik/suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
}

function ubahDokterPeriksa(pendaftaran_id)
{
    $('#temp_idPendaftaranDP').val(pendaftaran_id);
    jQuery.ajax({'url':'<?php echo $this->createUrl('ubahDokterPeriksa')?>',
        'data':$(this).serialize(),
        'type':'post',
        'dataType':'json',
        'success':function(data){
            if (data.status == 'create_form') {
                $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
            }else{
                $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $('form').serialize()
                });
                setTimeout("$('#editDokterPeriksa').dialog('close') ",500);
            }
        },
        'cache':false
    });
    return false; 
}

function setStatus(obj,status,pendaftaran_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
    
    myConfirm(' Yakin Akan Merubah Status Periksa Pasien? ', 'Perhatian!', function(r){
        if(r){
            $.post('<?php echo $this->createUrl('UbahStatusPeriksaPasien');?>', {status:status ,pendaftaran_id:pendaftaran_id}, function(data){
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

//Penambahan function untuk penerimaan dokumen
function penerimaanDokumen(obj,pengirimanrm_id,status,pendaftaran_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
	var pengirimanrm_id = pengirimanrm_id;
    
	if(status == 'SUDAH DIKIRIM'){
		myConfirm('Yakin Anda Menerima Dokumen Pasien? ', 'Perhatian!', function(r){
			if(r){
				$.post('<?php echo $this->createUrl('StatusDokumenTerima');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id}, function(data){
					if(data.status == 'proses_form'){
						$('#dialogStatusDokumen div.divForForm').html(data.div);
						$.fn.yiiGridView.update('daftarpasien-v-grid');
						setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
					}else{
						$('#alertDiv').show(); 
					}
				}, 'json');
			}else{
				 // preventDefault();
			}
		});
	}else if(status == 'SUDAH DITERIMA'){
	$('#dialogStatusDokumen').dialog('open');	
		$.post('<?php echo $this->createUrl('StatusDokumenKirim');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id}, function(data){
			if(data.status == 'proses_form'){				
				$('#dialogStatusDokumen div.divForForm').html(data.div);
				$.fn.yiiGridView.update('daftarpasien-v-grid');
				setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
			}else{
				$('#dialogStatusDokumen div.divForForm').html(data.div);
                $('#dialogStatusDokumen div.divForForm form').submit(setStatusDokumen); 
				
				jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
			}
		}, 'json');
	}else{	
		myConfirm('Apakah Anda yakin akan menerima dokumen pasien? ', 'Perhatian!', function(r){
			if(r){
				$.post('<?php echo $this->createUrl('StatusDokumenTerima');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id}, function(data){
					if(data.status == 'proses_form'){
						$('#dialogStatusDokumen div.divForForm').html(data.div);
						$.fn.yiiGridView.update('daftarpasien-v-grid');
						setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
					}else{
						$('#alertDiv').show(); 
					}
				}, 'json');
			}else{
				 // preventDefault();
			}
		});
	}    
}


 
function cekVerifikasiTindakLanjut(obj, id) {
    $.post('<?php echo $this->createUrl('/rawatJalan/daftarPasien/verifikasiTindakLanjut') ?>', {id: id}, function(data) {
        if (data.ok == 1) {
            // $("#frameTindakLanjut").prop('src', '<?php Yii::app()->controller->createUrl("/".Yii::app()->controller->module->id."/".Yii::app()->controller->id."/tindakLanjutRI"); ?>&pendaftaran_id=' + id
            //         + "&instalasi_id=<?php Params::INSTALASI_ID_RJ; ?>");
            // $("#dialogTindakLanjut").dialog('open');
            $("#frameTindakLanjut").prop('src', '<?php echo Yii::app()->controller->createUrl("/rawatDarurat/daftarPasien/pasienPulang"); ?>&pendaftaran_id=' + id
                                + "&dialog=1");
                        $("#dialogTindakLanjut").dialog('open');
        } else {
            
            if (data.is_confirm == 1) {
                myConfirm(data.msg, "Peringatan", function(r) {
                    if (r) {
                        $("#frameTindakLanjut").prop('src', '<?php echo Yii::app()->controller->createUrl("/rawatDarurat/daftarPasien/pasienPulang"); ?>&pendaftaran_id=' + id
                                + "&dialog=1");
                        $("#dialogTindakLanjut").dialog('open');
                    }
                    // if (r) {
                    //     $("#frameTindakLanjut").prop('src', '<?php Yii::app()->controller->createUrl("/".Yii::app()->controller->module->id."/".Yii::app()->controller->id."/tindakLanjutRI"); ?>&pendaftaran_id=' + id
                    //             + "&instalasi_id=<?php  Params::INSTALASI_ID_RJ; ?>");
                    //     $("#dialogTindakLanjut").dialog('open');
                    // }
                });
            } else if (data.is_notif == 1) {
                $("#isiPerhatian").html(data.msg);
                $("#dialogPertahian").dialog('open');
            } else {
                myAlert(data.msg);
            }
        }
    }, 'json');
}
</script>