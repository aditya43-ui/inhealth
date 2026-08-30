<script type="text/javascript">
document.getElementById('HDInfoKunjunganRDV_tgl_awal_date').setAttribute("style");
document.getElementById('HDInfoKunjunganRDV_tgl_akhir_date').setAttribute("style");


function verifikasiAntrian(pendaftaran_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('VerifikasiAntrian'); ?>',
        data: {
            pendaftaran_id:pendaftaran_id,
         //   konsulpoli_id:konsulpoli_id
        },
        dataType: "json",
        success:function(data){
            if(data.pesan !== ""){
                myAlert(data.pesan);
            }else{
                $.fn.yiiGridView.update('daftarPasien-grid');
            }
            
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function cekTanggal(){

    var checklist = $('#HDInfoKunjunganRDV_ceklis');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('HDInfoKunjunganRDV_tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('HDInfoKunjunganRDV_tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('HDInfoKunjunganRDV_tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('HDInfoKunjunganRDV_tgl_akhir_date').setAttribute("style","display:none;");
    }
}
$('document').ready(function(){
    $('#daftarPasien-grid button').each(function(){
        $('#orange').removeAttr('class');
        $('#red').removeAttr('class');
        $('#green').removeAttr('class');
        $('#blue').removeAttr('class');

        $('#orange').attr('class','btn btn-danger-blue');
        $('#red').attr('class','btn btn-danger-red');
        $('#green').attr('class','btn btn-danger');
        $('#blue').attr('class','btn btn-danger-yellow');
    });
	cekTanggal();
});

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
                $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('form').serialize()
                });
                setTimeout("$('#editDokterPeriksa').dialog('close') ",500);
            }
        },
        'cache':false
    });
    return false; 
}

function ubahStatusPeriksa()
{
    <?php 
            echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('ActionAjaxRIHD/ubahStatusPeriksaHD'),
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
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogUbahStatus').dialog('close') \",1000);
                }
 
            } ",
    ))
?>;
    return false; 
}

function addPasienPulang(pendaftaran_id,pasien_id)
{
    $('#pendaftaran_id').val(pendaftaran_id);
    $('#pasien_id').val(pasien_id);
    
    <?php 
            echo CHtml::ajax(array(
            'url'=>Yii::app()->createUrl('ActionAjaxRIHD/addPasienPulang'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogPasienPulang div.divForForm').html(data.div);
                    $('#dialogPasienPulang div.divForForm form').submit(addPasienPulang);
                    
                    jQuery('.dtPicker2-5').datetimepicker(jQuery.extend({showMonthAfterYear:false}, 
                    jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate'  : 'd','timeText':'Waktu','hourText':'Jam',
                         'minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih   Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
                    
                    
                }
                else
                {
                    $('#dialogPasienPulang div.divForForm').html(data.div);
                    $.fn.yiiGridView.update('daftarPasien-grid');
                    setTimeout(\"$('#dialogPasienPulang').dialog('close') \",1000);
                }
 
            } ",
    ))
?>;
    return false; 
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
    
    $.fn.yiiGridView.update('daftarPasien-grid', {
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

    $.post('<?php echo Yii::app()->createUrl('hemodialisa/ActionAjax/CekHakAkses');?>', 
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
              $.post('<?php echo Yii::app()->createUrl('hemodialisa/ActionAjax/dataPasien');?>', {pasien_id:pasien_id ,pendaftaran_id:pendaftaran_id}, function(dataPasien){
                  
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

function simpanAlasan()
{
    alasan =$('#dialogAlasan #Alasan').val();
    if(alasan==''){
        myAlert('Anda Belum Mengisi Alasan Pembatalan');
    }else{
        $.post('<?php echo Yii::app()->createUrl('hemodialisa/daftarPasien/BatalRawatInap');?>', $('#formAlasan').serialize(), function(data){
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

function cekStatus(status){
    var status = status;
    myAlert("Pasien "+status+" Tidak bisa melanjutkan pemeriksaan atau tindak lanjut");
}

function setWarningStatus(status){
    myAlert("Pasien belum memiliki "+status+" ");
}

function setStatus(obj,status,pendaftaran_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
    
    myConfirm(' Yakin Akan Merubah Status Periksa Pasien? ', 'Perhatian!', function(r){
        if(r){
            $.post('<?php echo $this->createUrl('UbahStatusPeriksaPasien');?>', {status:status ,pendaftaran_id:pendaftaran_id}, function(data){
                if(data.status == 'proses_form'){
					$('#dialogUbahStatusPasien div.divForForm').html(data.div);
					$.fn.yiiGridView.update('daftarPasien-grid');
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
						$.fn.yiiGridView.update('daftarPasien-grid');
						setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
					}else{
						$('#alertDiv').show(); 
					}
				}, 'json');
			}else{
				 preventDefault();
			}
		});
	}else if(status == 'SUDAH DITERIMA'){
	$('#dialogStatusDokumen').dialog('open');	
		$.post('<?php echo $this->createUrl('StatusDokumenKirim');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id}, function(data){
			if(data.status == 'proses_form'){				
				$('#dialogStatusDokumen div.divForForm').html(data.div);
				$.fn.yiiGridView.update('daftarPasien-grid');
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
		myConfirm('Yakin Anda Menerima Dokumen Pasien? ', 'Perhatian!', function(r){
			if(r){
				$.post('<?php echo $this->createUrl('StatusDokumenTerima');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id}, function(data){
					if(data.status == 'proses_form'){
						$('#dialogStatusDokumen div.divForForm').html(data.div);
						$.fn.yiiGridView.update('daftarPasien-grid');
						setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
					}else{
						$('#alertDiv').show(); 
					}
				}, 'json');
			}else{
				 preventDefault();
			}
		});
	}    
}

function setPenerimaan(obj,pengirimanrm_id,ruanganpenerimaan_id,status,pendaftaran_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
	var pengirimanrm_id = pengirimanrm_id;
    var ruanganpenerimaan_id = ruanganpenerimaan_id;
	
	if(ruanganpenerimaan_id == '' || ruanganpenerimaan_id == 99){
		myConfirm('Apakah anda akan membatalkan pengiriman? ', 'Perhatian!', function(r){
			if(r){
				$.post('<?php echo $this->createUrl('HapusDokumenPengiriman');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id}, function(data){
					if(data.status == 'proses_form'){
						$('#dialogStatusDokumen div.divForForm').html(data.div);
						$.fn.yiiGridView.update('daftarPasien-grid');
						setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
					}else{
						$('#alertDiv').show(); 
					}
				}, 'json');
			}else{
				 preventDefault();
			}
		});
	}else{
		$.post('<?php echo $this->createUrl('getStatusPenerimaan');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id,ruanganpenerimaan_id:ruanganpenerimaan_id}, function(data){
			$('#dialogStatusDokumen div.divForForm').html(data.div);
			$.fn.yiiGridView.update('daftarPasien-grid');
			setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
		}, 'json');
	}    
} 
/**
 * memanggil antrian ke HD
 * @param {type} pendaftaran_id
 * @returns {undefined} */
function panggilAntrian(pendaftaran_id){
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('Panggil'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){            
            $('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip('hide');
            if(data.pesan !== ""){
                toastr.info(data.pesan);
            }
            if(data.smspasien==0){
                var params = [];
                params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                insert_notifikasi(params);
            } 
            <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
            socket.emit('send',{conversationID:'antrian',panggil:2,antrian_id:pendaftaran_id});
            <?php } ?>            
            $.fn.yiiGridView.update('daftarPasien-grid');                     
            $('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip('hide');
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
// untuk panggilan HD
function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){
    $("#suarapanggilan").attr("src","<?php echo $this->createUrl('/antrian/tampilAntrianKeHD/suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
}

	$(document).ready(function() {
		var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');		
		var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');		
		var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');		
		var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');		
		var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');		
		var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');	
		var kec = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>');	
		var kel = jQuery('#<?php echo CHtml::activeId($model, 'kelurahan_id') ?>');	
		var pelayanan = jQuery('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>');	
		var tujuan = jQuery('#<?php echo CHtml::activeId($model, 'ruangantujuan_id') ?>');	
		var penunjang = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpenunj_id') ?>');	
		var obat = jQuery('#<?php echo CHtml::activeId($model, 'jenisobatalkes_id') ?>');	
		var cara_keluar = jQuery('#<?php echo CHtml::activeId($model, 'carakeluar') ?>');	
		var tindakan = jQuery('#<?php echo CHtml::activeId($model, 'tindakansudahbayar_id') ?>');	
		var nama_pegawai = jQuery('#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>');	
		
		jQuery(ins).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
					var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>   option:selected');
					var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
				
					var brands = ins_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					ru.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',					
						dataType: "json",
						data: {instalasiasal_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								ru.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								ru.html(data.ruangan);								
								ru.multiselect('rebuild');																
								ru.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});

			},
			onSelectAll: function() {
					var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
					var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>   option:selected');
					var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
					
					var brands = ins_all;
					var selected = [];
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					ru.addClass('animation-loading');


					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',					
						dataType: "json",
						data: {instalasiasal_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								ru.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								ru.html(data.ruangan);								
								ru.multiselect('rebuild');																
								ru.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});
					
			},
			onDeselectAll: function() {		
				var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
				var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>   option:selected');
				var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
					
				var brands = ins_all;
				var selected = '';

				

				ru.addClass('animation-loading');


				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',					
					dataType: "json",
					data: {instalasiasal_id:selected},
					success: function(data){	

						if (data.sukses != '1'){

							//toastr.error(data.pesan);
							ru.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							ru.html(data.ruangan);								
							ru.multiselect('rebuild');															
							ru.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);

					}
				});

			}
		}).hide();
		
		jQuery(ru).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		/**
		* multi select cara bayar dan penjamin
		 */
		
		
		jQuery(cara).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
					var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
					var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
				
					var brands = cara_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					penj.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',					
						dataType: "json",
						data: {carabayar_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								penj.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								penj.html(data.penjamin);								
								penj.multiselect('rebuild');																
								penj.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});

			},
			onSelectAll: function() {
					var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
					var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
					var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
					
					var brands = ins_all;
					var selected = [];
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					penj.addClass('animation-loading');


					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',					
						dataType: "json",
						data: {carabayar_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								penj.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								penj.html(data.penjaminan);								
								penj.multiselect('rebuild');																
								penj.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});
					
			},
			onDeselectAll: function() {		
				var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
				var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
				var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
					
				var brands = ins_all;
				var selected = '';

				

				penj.addClass('animation-loading');


				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',					
					dataType: "json",
					data: {carabayar_id:selected},
					success: function(data){	

						if (data.sukses != '1'){

							//toastr.error(data.pesan);
							penj.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							penj.html(data.penjamin);								
							penj.multiselect('rebuild');															
							penj.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);

					}
				});

			}
		}).hide();
		
		jQuery(penj).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		
		/**
		* multi select propinsi, kabupaten, kecamatan, kelurahan
		 */
		 
		 jQuery(prop).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var prop  = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
					var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
					var kab  = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
				
					var brands = prop_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					kab.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',					
						dataType: "json",
						data: {propinsi_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								kab.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								kab.html(data.kabupaten);								
								kab.multiselect('rebuild');																
								kab.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});

			},
			onSelectAll: function() {
					var prop  = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
					var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
					var kab  = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
					
					var brands = prop_all;
					var selected = [];
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					kab.addClass('animation-loading');


					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',					
						dataType: "json",
						data: {propinsi_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								kab.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								kab.html(data.kabupaten);								
								kab.multiselect('rebuild');																
								kab.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});
					
			},
			onDeselectAll: function() {		
				var prop  = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
				var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
				var kab  = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
					
				var brands = prop_all;
				var selected = '';

				

				kab.addClass('animation-loading');


				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',					
					dataType: "json",
					data: {propinsi_id:selected},
					success: function(data){	

						if (data.sukses != '1'){

							//toastr.error(data.pesan);
							kab.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							kab.html(data.kabupaten);								
							kab.multiselect('rebuild');															
							kab.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);

					}
				});

			}
		}).hide();

		 jQuery(kab).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var kab  = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
					var kab_all = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>   option:selected');
					var kec  = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>');
				
					var brands = kab_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					kab.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetKecamatanByMultiSelect') ?>',					
						dataType: "json",
						data: {kabupaten_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								kec.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								kec.html(data.kecamatan);								
								kec.multiselect('rebuild');																
								kec.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});

			},
			onSelectAll: function() {
					var kab  = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
					var kab_all = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>   option:selected');
					var kec  = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>');
					
					var brands = kab_all;
					var selected = [];
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					kab.addClass('animation-loading');


					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',					
						dataType: "json",
						data: {kabupaten_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								kec.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								kec.html(data.kecamatan);								
								kec.multiselect('rebuild');																
								kec.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});
					
			},
			onDeselectAll: function() {		
				var kab  = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
				var kab_all = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>   option:selected');
				var kec  = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>');
					
				var brands = kab_all;
				var selected = '';

				

				kab.addClass('animation-loading');


				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetKecamatanByMultiSelect') ?>',					
					dataType: "json",
					data: {kabupaten_id:selected},
					success: function(data){	

						if (data.sukses != '1'){

							//toastr.error(data.pesan);
							kec.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							kec.html(data.kecamatan);								
							kec.multiselect('rebuild');															
							kec.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);

					}
				});

			}
		}).hide();
                
                jQuery(kec).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
					var kec  = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>');
					var kec_all = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>   option:selected');
					var kel  = jQuery('#<?php echo CHtml::activeId($model, 'kelurahan_id') ?>');
				
					var brands = kec_all;
					var selected = [];
					
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					kab.addClass('animation-loading');
					//alert(selected);

					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetKelurahanByMultiSelect') ?>',					
						dataType: "json",
						data: {kecamatan_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								kel.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								kel.html(data.kelurahan);								
								kel.multiselect('rebuild');																
								kel.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});

			},
			onSelectAll: function() {
					var kec  = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>');
					var kec_all = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>   option:selected');
					var kel  = jQuery('#<?php echo CHtml::activeId($model, 'kelurahan_id') ?>');
					
					var brands = kec_all;
					var selected = [];
				
					$(brands).each(function(index, brand){
						selected.push($(this).val());
					});

					kab.addClass('animation-loading');


					jQuery.ajax({
						type:'POST',
						url: '<?php echo $this->createUrl('/ActionDynamic/GetKecamatanByMultiSelect') ?>',					
						dataType: "json",
						data: {kecamatan_id:selected},
						success: function(data){	
							
							if (data.sukses != '1'){
								
								//toastr.error(data.pesan);
								kel.addClass('animation-loading');
							}else{							
								//alert(data.ruangan);
								kel.html(data.kelurahan);								
								kel.multiselect('rebuild');																
								kel.removeClass('animation-loading');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { 					
							console.log(errorThrown);
							
						}
					});
					
			},
			onDeselectAll: function() {		
				var kec  = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>');
				var kec_all = jQuery('#<?php echo CHtml::activeId($model, 'kecamatan_id') ?>   option:selected');
				var kel  = jQuery('#<?php echo CHtml::activeId($model, 'kelurahan_id') ?>');
					
				var brands = kec_all;
				var selected = '';

				

				kab.addClass('animation-loading');


				jQuery.ajax({
					type:'POST',
					url: '<?php echo $this->createUrl('/ActionDynamic/GetKelurahanByMultiSelect') ?>',					
					dataType: "json",
					data: {kecamatan_id:selected},
					success: function(data){	

						if (data.sukses != '1'){

							//toastr.error(data.pesan);
							kel.addClass('animation-loading');
						}else{							
							//alert(data.ruangan);
							kel.html(data.kelurahan);								
							kel.multiselect('rebuild');															
							kel.removeClass('animation-loading');
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { 					
						console.log(errorThrown);

					}
				});

			}
		}).hide();

		jQuery(kel).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
    
    
		jQuery(pelayanan).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(tujuan).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(penunjang).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(obat).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(cara_keluar).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(tindakan).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
		
		jQuery(nama_pegawai).multiselect({
			includeSelectAllOption: true,
			buttonClass: "form-control",
			maxHeight: 300,
			buttonWidth: '150px',
			enableCaseInsensitiveFiltering: true
		}).hide();
});

</script>