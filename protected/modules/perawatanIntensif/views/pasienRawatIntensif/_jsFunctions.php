<script type="text/javascript">
function dialogBatalPeriksa(pendaftaran_id,pasienadmisi_id,statusperiksa,nama_pasien)
{
	$('#titleNamaPasienBatal').html(nama_pasien);
	$('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
	$('#DialogBatalperiksa #pasienadmisi_id').val(pasienadmisi_id);
	$('#DialogBatalperiksa #statusperiksa').val(statusperiksa);
	$('#DialogBatalperiksa').dialog('open');					
} 

function periksaPembayaranUntukPulang(id) {
    
    var urlPulang = '<?php echo $this->createUrl('TindakLanjutDariPasienPI'); ?>';
    
    $.post('<?php echo $this->createUrl('cekTagihan'); ?>', {pendaftaran_id: id}, function(data) {
        if (data.status_tindakan == false || data.status_obat == false) {
            myAlert('Tagihan pasien belum diselesaikan di Kasir','Perhatian');
        } else {
            verifikasiPulangPasien(id);
            $("#iframeTindakLanjut").prop('src', urlPulang + '&pendaftaran_id=' + id);
        }
    }, 'json');
}

//function dialogBatalPeriksaOld(pendaftaran_id,pasienadmisi_id,statusperiksa,nama_pasien)
//{
//	$.ajax({
//		type:'POST',
//		url:'<?php echo $this->createUrl('cekTagihan'); ?>',
//		data: {pendaftaran_id: pendaftaran_id,pasienadmisi_id:pasienadmisi_id,statusperiksa:statusperiksa},//
//		dataType: "json",
//		success:function(data){
//			if(data.status_batal == true) {
//				$('#titleNamaPasienBatal').html(nama_pasien);
//				$('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
//				$('#DialogBatalperiksa #pasienadmisi_id').val(pasienadmisi_id);
//				$('#DialogBatalperiksa #statusperiksa').val(statusperiksa);
//				$('#DialogBatalperiksa').dialog('open');	
//				return false;
//			} else {
//				window.parent.myAlert(data.pesan);
//			}
//			$.fn.yiiGridView.update('daftarPasien-grid', {
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
	var pendaftaran_id=$('#DialogBatalperiksa #pendaftaran_id').val(); 
	var pasienadmisi_id=$('#DialogBatalperiksa #pasienadmisi_id').val(); 
	var tglbatal=$('#DialogBatalperiksa #tglbatal').val();
	var keterangan_batal=$('#DialogBatalperiksa #keterangan_batal').val();
	var nama_pemakai=$('#DialogBatalperiksa #username').val();
	var kata_kunci=$('#DialogBatalperiksa #password').val();

	if(tglbatal == ''){
		window.parent.myAlert('Tanggal Batal harus diisi!');
		return false;
	}
	if(keterangan_batal == ''){
		window.parent.myAlert('Alasan Batal harus diisi!');
		return false;
	}
	if(nama_pemakai == ''){
		window.parent.myAlert('Nama Pemakai harus diisi!');
		return false;
	}
	if(kata_kunci == ''){
		window.parent.myAlert('Kata Kunci harus diisi!');
		return false;
	}
	window.parent.myConfirm("Anda yakin akan membatalkan pemeriksaan rawat inap pasien ini?","Perhatian!",function(r) {
		if(r){
			$('#DialogBatalperiksa').dialog('close');
			  $.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalRawat'); ?>',
				data: {pendaftaran_id : pendaftaran_id, pasienadmisi_id:pasienadmisi_id,statusperiksa:statusperiksa,tglbatal:tglbatal,keterangan_batal:keterangan_batal,nama_pemakai:nama_pemakai,kata_kunci:kata_kunci},
				dataType: "json",
				success:function(data){
					if(data.status == true){
						window.parent.myAlert(data.pesan);
						$.fn.yiiGridView.update('daftarPasien-grid', {
							data: $(this).serialize() });
					}else if(data.pesan == 'exist'){
						window.parent.myAlert('Pasien telah melakukan pemeriksaan');
					}else{
						window.parent.myAlert(data.pesan);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
}	

function penerimaanDokumen(obj,pengirimanrm_id,status,pendaftaran_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
	var pengirimanrm_id = pengirimanrm_id;
    
	if(status == 'SUDAH DIKIRIM'){
		window.parent.myConfirm('Yakin Anda Menerima Dokumen Pasien? ', 'Perhatian!', function(r){
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
		window.parent.myConfirm('Yakin Anda Menerima Dokumen Pasien? ', 'Perhatian!', function(r){
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
		window.parent.myConfirm('Apakah Anda akan membatalkan pengiriman? ', 'Perhatian!', function(r){
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

function batalRencanaPulang(pasienadmisi_id){
	window.parent.myConfirm("Anda yakin akan membatalkan rencana pulang pasien ini?","Perhatian!",function(r) {
		if(r){
			  $.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalRencanaPulang'); ?>',
				data: {pasienadmisi_id:pasienadmisi_id},
				dataType: "json",
				success:function(data){
					if(data.status == true){
						window.parent.myAlert(data.pesan);
						$.fn.yiiGridView.update('daftarPasien-grid', {
							data: $(this).serialize() });
					}else if(data.pesan == 'exist'){
						window.parent.myAlert('Pasien telah dipulangkan');
					}else{
						window.parent.myAlert(data.pesan);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
}

function cekNurseStation(){//RSKG-864
	if($('#<?php echo CHtml::activeId($model, 'is_nursestation') ?>').is(':checked')){
		$(".judul").html('Informasi Pasien <b>Rawat Intensif</b> <?php echo Yii::app()->user->getState('nursestation_nama')?>');
	}else{
		$(".judul").html('Informasi Pasien <b>Rawat Intensif</b>');
	}
}
</script>