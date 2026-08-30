<script type="text/javascript">
	//======================================Awal batal Periksa============================================================
	function dialogBatalPeriksa(pendaftaran_id, statusperiksa, namaPasien) {
		validasiDiagnosa(pendaftaran_id, 1, statusperiksa, namaPasien);
	}

	function cekValidasiVerifikasi(pendaftaran_id, menu) { 
		$.post('<?= $this->createUrl('cekValidasiVerifikasi') ?>', {
			pendaftaran_id:pendaftaran_id,
			menu:menu
		}, function(data){
			if(data.sukses == 1) {
				var url = '<?= Yii::app()->createUrl(Yii::app()->controller->module->id . "/verifikasiDiagnosa/index") ?>' + '&id=' + pendaftaran_id + '&menu=' + menu + '&frame=true';

				$("#dialogVerifikasiDiagnosa").dialog("open");
				$('#iframeVerifikasiDiagnosa').attr('src', url);
			} else {
				window.parent.myAlert('Pasien belum ditindak lanjut oleh pelayanan');
			}
		}, 'json');
		

	}
	function ubahPeriksa() {
		var url = $('#url').val();
		var statusperiksa = $('#DialogBatalperiksa #statusperiksa').val();
		var pendaftaran_id = $('#DialogBatalperiksa #pendaftaran_id').val();
		var tglbatal = $('#DialogBatalperiksa #tglbatal').val();
		var keterangan_batal = $('#DialogBatalperiksa #keterangan_batal').val();
		if (statusperiksa == '${statusPeriksaBatalPeriksa}') {
			myAlert('Pasien Sudah Dibatalkan');
		} else {
			$.ajax({
				type: 'POST',
				url: '<?php echo $this->createUrl('ubahPeriksa'); ?>',
				data: {
					pendaftaran_id: pendaftaran_id,
					statusperiksa: statusperiksa,
					tglbatal: tglbatal,
					keterangan_batal: keterangan_batal
				}, //
				dataType: "json",
				success: function(data) {
					if (data.success) {
						$('#DialogBatalperiksa').dialog('close');
						myAlert(data.message);
					} else {
						myAlert(data.message);
						$('#DialogBatalperiksa #keterangan_batal').attr('class', 'error');
					}
					$.fn.yiiGridView.update('PPInfoKunjungan-v', {
						data: $(this).serialize()
					});
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}

	}
	//=======================================Akhir Batal Periksa=============================================================   
	function loadFormCaraBayar(obj) {
		var url = $(obj).attr('href');
		$('#iframeUbahCaraBayar').attr('src', url);
	}

	function loadFormPerujuk(obj) {
		var url = $(obj).attr('href');
		$('#iframeUbahPerujuk').attr('src', url);
	}

	function printGC(id) {
		window.open('<?php echo $this->createUrl('/pendaftaranPenjadwalan/suratPersetujuanUmum/PrintGeneralConsent'); ?>&pendaftaran_id=' + id, 'printwin', 'left=100,top=100,width=860,height=480');
	}

	/**
	 * submit / simpan ubah ruangan 
	 **/
	function simpanUbahRuangan() {
		if ($('#ganti_poli #alasanperubahan').val() == '') {
			myAlert('Alasan Perubahan tidak boleh kosong!');
			$('#ganti_poli #alasanperubahan').addClass('error');
			return false;
		}
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('UbahRuangan'); ?>',
			data: {
				post: $("#form-ubahruangan input,select,textarea").serialize()
			},
			dataType: "json",
			success: function(data) {
				myAlert(data.pesan);
				$.fn.yiiGridView.update('PPInfoKunjungan-v', {
					data: $('#formCari').serialize()
				});
				$('#ganti_poli').dialog('close');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function validasiDiagnosa(id, params, statusperiksa = null, namaPasien = null) {

		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('validasiDiagnosa'); ?>',
			data: {
				id: id
			},
			dataType: "json",
			success: function(data) {
				if (data.exists) {
					myAlert('Data tidak dapat diedit karena sudah dilakukan verifikasi keuangan!');
				} else {
					if (params == 1) {
						$('#titleNamaPasienBatal').html(namaPasien);
						$('#DialogBatalperiksa #pendaftaran_id').val(id);
						$('#DialogBatalperiksa #statusperiksa').val(statusperiksa);
						$('#DialogBatalperiksa').dialog('open');
						return true;
					} else {
						$('#carabayardialog').dialog('open');
						loadFormCaraBayar(this);
						return false;
					}

				}


			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}
</script>