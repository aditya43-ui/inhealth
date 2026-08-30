<script type="text/javascript">
function cekRenControl(event){
        myConfirm(' Yakin Akan Merubah Tgl. Rencana Kontrol? ', 'Perhatian!', function(r){
            if(r){
                $("#dialogRencanaKontrol").dialog("open");
            }else{
                // event.preventDefault();
            }
        });
}
function batal(){
    $('#loginDialog').dialog('close');
    $('#loginDialog #username').val('');
    $('#loginDialog #password').val('');
    $('#alertDiv').hide(); 
    $('#pasien_id').val('');
    $('#pendaftaran_id').val('');
     
    $('#dialogAlasan').dialog('close');
    $('#dialogAlasan #idOtoritas').val('');
    $('#dialogAlasan #namaOtoritas').val('');
    $('#dialogAlasan #idPasienPulang').val('');
    $('#dialogAlasan #pendaftaran_id').val('');
    
    $.fn.yiiGridView.update('daftarpasien-v-grid', {
        data: $('#daftarPasienPulang-form').serialize()
    });
}

function cekHakAkses(pendaftaran_id)
{
//       $('#dialogAlasan #idPasienPulang').val(idPasienPulang);
//       $('#dialogAlasan #pendaftaran_id').val(pendaftaran_id);
//       $('#pasien_id').val(pasien_id);
//       $('#pendaftaran_id').val(pendaftaran_id);
       
//    $('#konfirmasiDialog').dialog('open');

    $.post('<?php echo Yii::app()->createUrl('rawatJalan/ActionAjax/CekHakAkses');?>', 
    {pendaftaran_id:pendaftaran_id, idUser:'<?php echo Yii::app()->user->id; ?>',useName:'<?php echo Yii::app()->user->name; ?>'}, function(data){
//        console.log(data);
     var cekAdmisi = data.pendaftaran.pasienadmisi_id;
    
     if(cekAdmisi){
         $('#konfirmasiAdmisi').dialog('open');
          $('#konfirmasiAdmisi #ruanganPasien').html(data.ruanganPasien);
     }else{
        $('#konfirmasiDialog').dialog('open');
        if(data.cekAkses==true){
            $('#dialogAlasan').dialog('open');
            $('#dialogAlasan #idOtoritas').val(data.userid);
            $('#dialogAlasan #namaOtoritas').val(data.username);
        } else {
            $('#konfirmasiDialog').dialog('open');
        }
     }
       $('#dialogAlasan #idPasienPulang').val(data.pendaftaran.pasienpulang_id);
       $('#dialogAlasan #pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
       $('#pasien_id').val(data.pendaftaran.pasien_id);
       $('#pendaftaran_id').val(data.pendaftaran.pendaftaran_id);
    }, 'json');
}

function cekLogin()
{
    pasien_id = $('#pasien_id').val();    
    pendaftaran_id = $('#pendaftaran_id').val();    
    $.post('<?php echo Yii::app()->createUrl('ActionAjax/CekLoginPembatalRawatInap');?>', $('#formLogin').serialize(), function(data){
        if(data.error != '')
        $('#'+data.cssError).addClass('error');
        if(data.status=='success'){
              $.post('<?php echo Yii::app()->createUrl('rawatJalan/ActionAjax/dataPasien');?>', {pasien_id:pasien_id ,pendaftaran_id:pendaftaran_id}, function(dataPasien){
                  
              $('#divFormDataPasien').html(dataPasien.form);

             }, 'json');
                 
            $('#dialogAlasan').dialog('open');
            $('#dialogAlasan #idOtoritas').val(data.userid);
            $('#dialogAlasan #namaOtoritas').val(data.username);
            $('#loginDialog').dialog('close');
        }else{
    $('#alertDiv').show(); 
        }
    }, 'json');
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

function simpanAlasan()
{
    alasan =$('#dialogAlasan #Alasan').val();
    if(alasan==''){
        myAlert('Anda Belum Mengisi Alasan Pembatalan');
    }else{
        $.post('<?php echo Yii::app()->createUrl('rawatJalan/daftarPasien/BatalRawatInap');?>', $('#formAlasan').serialize(), function(data){
//            if(data.error != '')
//                myAlert(data.error);
//            $('#'+data.cssError).addClass('error');
            if(data.status=='success'){
                batal();
                myAlert('Data Berhasil Disimpan');
            }else{
                myAlert(data.status);
            }
        }, 'json');
   }     
}

function ubahStatusPeriksa()
{
    <?php 
            echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('ActionAjaxRIRD/ubahStatusPeriksaRJ'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogUbahStatus div.divForForm').html(data.div);
                    $('#dialogUbahStatus div.divForForm form').submit(ubahStatusPeriksa);
                    
                    jQuery('.dtPicker3').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    
                }
                else
                {
                    $('#dialogUbahStatus div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarpasien-v-grid');
                    setTimeout(\"$('#dialogUbahStatus').dialog('close') \",1000);
                }
 
            } ",
    ))
?>;
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
			// preventDefault();
        }
    });    
}

function penerimaanDokumen(obj,pengirimanrm_id,status,pendaftaran_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
	var pengirimanrm_id = pengirimanrm_id;
    
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
    
}

function setPenerimaan(obj,pengirimanrm_id,ruanganpenerimaan_id,status,pendaftaran_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
	var pengirimanrm_id = pengirimanrm_id;
	var ruanganpenerimaan_id = ruanganpenerimaan_id;
    		
    if(ruanganpenerimaan_id == null){
		myConfirm('Apakah Anda akan membatalkan pengiriman? ', 'Perhatian!', function(r){
			if(r){
				$.post('<?php echo $this->createUrl('BatalPengirimanDokumen');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id}, function(data){
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
	}else{
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
	}
    
}

function cekStatus(status){
    var status = status;
    myAlert("Pasien "+status+" Tidak bisa melanjutkan pemeriksaan atau tindak lanjut");
} 

function disableLink()
{
    var status = null;
    $("#daftarpasien-v-grid tbody").find('tr > td[class="rajal"]').each(
        function()
        {
            status = $(this).parent().find('td[class="status"]');
            var xxx = $(this).find('a');
            if(status.text() == 'SUDAH PULANG')
            {
               $(this).text($.trim(xxx.text()));
               $(this).find('a').remove();
            }
        }
    );
}
disableLink();  
        
function tindaklanjutrawatjalan(id){
    pendaftaran_id = id;
    myConfirm(' Yakin Pasien Akan Ditindak Lanjut ke Rawat Inap? ', 'Perhatian!', function(r){
        if(r){
            $.post('<?php echo Yii::app()->createUrl('rawatJalan/daftarPasien/pasienRujukRI'); ?>',{pendaftaran_id:pendaftaran_id}, function(data){
                $.fn.yiiGridView.update('daftarpasien-v-grid');
            });
        }else{
            
        }
    });
}

function ubahstatusperiksa(id){
    pendaftaran_id = id;
    myConfirm(' Yakin Pasien Akan Dirubah Status Periksa? ', 'Perhatian!', function(r){
        if(r){
            $('#dialogUbahStatus').dialog('open');
        }else{
            
        }
    });
}  

function ambilAntrianTerakhir(){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
        dataType: "json",
        success:function(data){
            if(data.pesan == ""){
                panggilAntrian(data.pendaftaran_id);
                setSuaraPanggilanSingle(data.ruangan_singkatan,data.no_urutantri,data.ruangan_id);
            }else{
                myAlert(data.pesan);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
} 

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
            if(data.smspasien==0){
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                insert_notifikasi(params);
            } 
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
            socket.emit('send',{conversationID:'antrian',panggil:1,antrian_id:pendaftaran_id});
            <?php } ?>
            $.fn.yiiGridView.update('daftarpasien-v-grid');
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function listRuangan(instalasi_id)
{
    $.post("<?php echo $this->createUrl('SetDropdownRuangan')?>", { instalasi_id: instalasi_id },
        function(data){
            $('#PengirimanrmT_ruangan_id').html(data.listRuangan);
    }, "json");
}

/**
 * suara panggilan per ruangan
 * @param {type} param
 * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
 */
function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){
    $("#suarapanggilan").attr("src","<?php echo $this->createUrl('/antrian/tampilAntrianKePoliklinik/suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
}
/**
 * fungsi ini harus tetap di bawah posisinya
 * @param {type} param */
$('document').ready(function(){
    $('#daftarpasien-v-grid button').each(function(){
        $('#orange').removeAttr('class');
        $('#red').removeAttr('class');
        $('#green').removeAttr('class');
        $('#blue').removeAttr('class');

        $('#orange').attr('class','btn btn-danger-blue');
        $('#red').attr('class','btn btn-primary');
        $('#green').attr('class','btn btn-danger');
        $('#blue').attr('class','btn btn-danger-yellow');
    });

});

</script>