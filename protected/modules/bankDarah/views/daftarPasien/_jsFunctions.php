<script type="text/javascript">
function dialogBatalPeriksa(pendaftaran_id,pasienmasukpenunjang_id,statusperiksa,nama_pasien)
{
	$('#titleNamaPasienBatal').html(nama_pasien);
	$('#DialogBatalperiksa #pasienmasukpenunjang_id').val(pasienmasukpenunjang_id);
	$('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
	$('#DialogBatalperiksa #statusperiksa').val(statusperiksa);
	$('#DialogBatalperiksa').dialog('open');	
} 
//function dialogBatalPeriksaOld(pendaftaran_id,pasienmasukpenunjang_id,statusperiksa,nama_pasien)
//{
//	$.ajax({
//		type:'POST',
//		url:'<?php echo $this->createUrl('cekTagihan'); ?>',
//		data: {pendaftaran_id: pendaftaran_id,pasienmasukpenunjang_id:pasienmasukpenunjang_id,statusperiksa:statusperiksa},//
//		dataType: "json",
//		success:function(data){
//			if(data.status_batal == true) {
//				$('#titleNamaPasienBatal').html(nama_pasien);
//				$('#DialogBatalperiksa #pasienmasukpenunjang_id').val(pasienmasukpenunjang_id);
//				$('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
//				$('#DialogBatalperiksa #statusperiksa').val(statusperiksa);
//				$('#DialogBatalperiksa').dialog('open');	
//				return false;
//			} else {
//				myAlert(data.pesan);
//			}
//			$.fn.yiiGridView.update('daftarpasien-v-grid', {
//					data: $(this).serialize()
//			});
//		},
//		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//	});
//
//} 
function batalperiksa()
{
	var statusperiksa=$('#DialogBatalperiksa #statusperiksa').val();
	var pasienmasukpenunjang_id=$('#DialogBatalperiksa #pasienmasukpenunjang_id').val(); 
	var pendaftaran_id=$('#DialogBatalperiksa #pendaftaran_id').val(); 
	var nama_pemakai=$('#DialogBatalperiksa #username').val();
	var kata_kunci=$('#DialogBatalperiksa #password').val();

	if(nama_pemakai == ''){
		myAlert('Nama Pemakai harus diisi!');
		return false;
	}
	if(kata_kunci == ''){
		myAlert('Kata Kunci harus diisi!');
		return false;
	}
	myConfirm("Anda yakin akan membatalkan pemeriksaan bank darah pasien ini?","Perhatian!",function(r) {
		if(r){
			$('#DialogBatalperiksa').dialog('close');
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalPenunjang'); ?>',
				data: {pendaftaran_id : pendaftaran_id, pasienmasukpenunjang_id:pasienmasukpenunjang_id,nama_pemakai:nama_pemakai, kata_kunci:kata_kunci},//
				dataType: "json",
				success:function(data){
					if(data.status == true){
							myAlert(data.pesan);
							$.fn.yiiGridView.update('daftarpasien-v-grid', {
								data: $(this).serialize() });									
						}else if(data.pesan == 'exist'){
							myAlert('Pemeriksaan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!');
						}else{
							myAlert(data.pesan);
						}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
}	
//function batalperiksaOld()
//{
//	var statusperiksa=$('#DialogBatalperiksa #statusperiksa').val();
//	var pasienmasukpenunjang_id=$('#DialogBatalperiksa #pasienmasukpenunjang_id').val(); 
//	var pendaftaran_id=$('#DialogBatalperiksa #pendaftaran_id').val(); 
//	var tglbatal=$('#DialogBatalperiksa #tglbatal').val();
//	var keterangan_batal=$('#DialogBatalperiksa #keterangan_batal').val();
//	var nama_pemakai=$('#DialogBatalperiksa #username').val();
//	var kata_kunci=$('#DialogBatalperiksa #password').val();
//
//	if(tglbatal == ''){
//		myAlert('Tanggal Batal harus diisi!');
//		return false;
//	}
//	if(keterangan_batal == ''){
//		myAlert('Alasan Batal harus diisi!');
//		return false;
//	}
//	if(nama_pemakai == ''){
//		myAlert('Nama Pemakai harus diisi!');
//		return false;
//	}
//	if(kata_kunci == ''){
//		myAlert('Kata Kunci harus diisi!');
//		return false;
//	}
//	myConfirm("Anda yakin akan membatalkan pemeriksaan bank darah pasien ini?","Perhatian!",function(r) {
//		if(r){
//			$.post('<?php echo $this->createUrl('CekLoginBatalPemeriksaan');?>', {nama_pemakai:nama_pemakai, kata_kunci:kata_kunci}, function(data){
//				if(data.error != '')
//				$('#'+data.cssError).addClass('error');
//				if(data.status=='success'){
//					$('#DialogBatalperiksa').dialog('close');
//					  $.ajax({
//						type:'POST',
//						url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalPeriksaPasienLuar'); ?>',
//						data: {pendaftaran_id : pendaftaran_id, pasienmasukpenunjang_id:pasienmasukpenunjang_id,statusperiksa:statusperiksa,tglbatal:tglbatal,keterangan_batal:keterangan_batal,nama_pemakai:nama_pemakai,kata_kunci:kata_kunci},//
//						dataType: "json",
//						success:function(data){
//							if(data.status == true){
//									myAlert(data.pesan);
//									$.fn.yiiGridView.update('daftarpasien-v-grid', {
//										data: $(this).serialize() });
//
//									// Notifikasi Pasien
//									if(data.smspasien==0){
//										var params = [];
//										params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
//										simpanNotifikasi(params);
//									} 
//								}else if(data.pesan == 'exist'){
//									myAlert('Pasien telah melakukan pemeriksaan');
//								}else{
//									myAlert(data.pesan);
//								}
//						},
//						error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//					});
//				}else{
//					myAlert(data.status);
//				}
//			}, 'json');
//		}
//	});
//}	
function setStatus(obj,status,pasienmasukpenunjang_id,pendaftaran_id){
    var status = status;
    var pasienmasukpenunjang_id = pasienmasukpenunjang_id;
    var pendaftaran_id = pendaftaran_id;
	
    myConfirm(' Yakin Akan Merubah Status Periksa Pasien? ', 'Perhatian!', function(r){
        if(r){
            $.post('<?php echo $this->createUrl('UbahStatusPeriksaPasien');?>', {status:status ,pasienmasukpenunjang_id:pasienmasukpenunjang_id, pendaftaran_id:pendaftaran_id}, function(data){
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
				 preventDefault();
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
		myConfirm('Apakah Anda akan membatalkan pengiriman? ', 'Perhatian!', function(r){
			if(r){
				$.post('<?php echo $this->createUrl('HapusDokumenPengiriman');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id}, function(data){
					if(data.status == 'proses_form'){
						$('#dialogStatusDokumen div.divForForm').html(data.div);
						$.fn.yiiGridView.update('daftarpasien-v-grid');
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
			$.fn.yiiGridView.update('daftarpasien-v-grid');
			setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
		}, 'json');
	}    
}
</script>