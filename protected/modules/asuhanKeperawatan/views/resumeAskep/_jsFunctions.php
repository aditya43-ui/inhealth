<script type="text/javascript">
	function cekPendaftaran(pendaftaran_id) {
		if (pendaftaran_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('cekPendaftaran'); ?>',
				data: {pendaftaran_id: pendaftaran_id},
				dataType: "json",
				success: function (data) {

					if (data != null) {
						myAlert("Pendaftaran sudah dipilih!");
						return false;
					} else {
						$.ajax({
							type: 'GET',
							url: '<?php echo $this->createUrl('loadPasien'); ?>',
							data: {pendaftaran_id: pendaftaran_id},
							dataType: "json",
							success: function (data) {
								isiDataPasien(data);                                                                
								loadDiagnosaMedis(data.pasien_id,data.pendaftaran_id);
								loadDiagnosaTindakanKeperawatan(data.pendaftaran_id);
								loadAnamnesaMasuk(data.pendaftaran_id);
								loadAnamnesaPulang(data.pendaftaran_id);
								loadFisikMasuk(data.pendaftaran_id);
								loadFisikPulang(data.pendaftaran_id);
                                                                
							},
							error: function (jqXHR, textStatus, errorThrown) {
								console.log(errorThrown);
							}
						});
						return true;
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	function isiDataPasien(data)
	{
		$("#ASPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
		$("#ASPendaftaranT_pasien_id").val(data.pasien_id);
		$("#ASPendaftaranT_tgl_pendaftaran").val(data.tgl_pendaftaran);
		$("#ASPendaftaranT_no_pendaftaran").val(data.no_pendaftaran);
		$("#ASPendaftaranT_umur").val(data.umur);
		$("#ASPendaftaranT_jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
		$("#ASPendaftaranT_instalasi_id").val(data.instalasi_id);
		$("#ASPendaftaranT_instalasi_nama").val(data.instalasi_nama);
		$("#ASPendaftaranT_ruangan_nama").val(data.ruangan_nama);
		$("#ASPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
		$("#ASPendaftaranT_carabayar_id").val(data.carabayar_id);
		$("#ASPendaftaranT_penjamin_id").val(data.penjamin_id);
		$("#ASPendaftaranT_kelaspelayanan_id").val(data.kelaspelayanan_id);
		$("#ASPendaftaranT_kelaspelayanan_nama").val(data.kelaspelayanan_nama);
		$("#ASPendaftaranT_pasien_id").val(data.pasien_id);
		$("#ASTandabuktibayarUangMukaT_darinama_bkm").val(data.nama_pasien);

		$("#ASPasienM_jeniskelamin").val(data.jeniskelamin);
		$("#ASPasienM_no_rekam_medik").val(data.no_rekam_medik);
		$("#ASPasienM_nama_pasien").val(data.nama_pasien);
		$("#ASPasienM_pekerjaan_nama").val(data.pekerjaan_nama);
		$("#ASPasienM_pendidikan_nama").val(data.pendidikan_nama);
		$("#ASPasienM_alamat_pasien").val(data.alamat_pasien);
		$("#ASPasienM_agama").val(data.agama);
		$("#ASPendaftaranT_statusperkawinan").val(data.statusperkawinan);
		$("#ASPendaftaranT_carabayar_nama").val(data.carabayar_nama);
		$("#ASPendaftaranT_penjamin_nama").val(data.penjamin_nama);
		$("#ASPendaftaranT_no_kamarbed").val(data.kamarruangan_nokamar + " / " + data.kamarruangan_nobed);
		
		$("#ASResumeaskepR_tglkeluarrs").val(data.tglpasienpulang);
                
                $("#ASPasienM_no_rekam_medik").blur();
		//$('#ASTandabuktibayarUangMukaT_jmlpembayaran').focus();
		//$('#ASTandabuktibayarUangMukaT_jmlpembayaran').select();    
	}
	
	function loadDiagnosaMedis(pasien_id,pendaftaran_id)
	{
		if (pasien_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadDiagnosaMedis'); ?>',
				data: {pasien_id: pasien_id,pendaftaran_id:pendaftaran_id},
				dataType: "json",
				success: function (data) {
					$('#ASDiagnosaM_diagnosa_nama').val(data.diagnosa_nama);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	
	function loadDiagnosaTindakanKeperawatan(pendaftaran_id)
	{
		if (pendaftaran_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadDiagnosaTindakanKeperawatan'); ?>',
				data: {pendaftaran_id: pendaftaran_id},
				dataType: "json",
				success: function (data) {
					console.log(data);
					$('#ASResumeaskepR_tindakankeperawatan').val(data.tindakankeperawatan);
					$('#ASResumeaskepR_diagnosakeperawatan').val(data.diagnosakeperawatan);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	
	function loadAnamnesaMasuk(pendaftaran_id)
	{
		if (pendaftaran_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadAnamnesaMasuk'); ?>',
				data: {pendaftaran_id: pendaftaran_id},
				dataType: "json",
				success: function (data) {
					$('#ASResumeaskepR_keluhanutamamasuk').val(data.keluhanutama);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	
	function loadAnamnesaPulang(pendaftaran_id)
	{
		if (pendaftaran_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadAnamnesaPulang'); ?>',
				data: {pendaftaran_id: pendaftaran_id},
				dataType: "json",
				success: function (data) {
					$('#ASResumeaskepR_keluhanakhir').val(data.keluhanutama);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	
	function loadFisikMasuk(pendaftaran_id)
	{
		if (pendaftaran_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadFisikMasuk'); ?>',
				data: {pendaftaran_id: pendaftaran_id},
				dataType: "json",
				success: function (data) {
					$('#ASResumeaskepR_keadaanumummasuk').val(data.keadaanumum);
					if(data.gcs_eye != null){
						$('#ASResumeaskepR_gcs_eye').val(data.gcs_eye);
					}else{
						$('#ASResumeaskepR_gcs_eye').val(0);
					}
					
					if(data.gcs_motorik != null){
						$('#ASResumeaskepR_gcs_motorik').val(data.gcs_motorik);
					}else{
						$('#ASResumeaskepR_gcs_motorik').val(0);
					}
					
					if(data.gcs_verbal != null){
						$('#ASResumeaskepR_gcs_verbal').val(data.gcs_verbal);
					}else{
						$('#ASResumeaskepR_gcs_verbal').val(0);
					}
					
					$('#ASResumeaskepR_gcs_hasil').val(parseFloat($('#ASResumeaskepR_gcs_eye').val()) + parseFloat($('#ASResumeaskepR_gcs_motorik').val()) + parseFloat($('#ASResumeaskepR_gcs_verbal').val()));
				
					if(data.tekanandarah != null){
						$('#ASResumeaskepR_tekanandarahmasuk').val(data.tekanandarah);
					}else{
						$('#ASResumeaskepR_tekanandarahmasuk').val(0);
					}
					
					if(data.detaknadi != null){
						$('#ASResumeaskepR_detaknadimasuk').val(data.detaknadi);
					}else{
						$('#ASResumeaskepR_detaknadimasuk').val(0);
					}
					
					if(data.suhutubuh != null){
						$('#ASResumeaskepR_suhutubuhmasuk').val(data.suhutubuh);
					}else{
						$('#ASResumeaskepR_suhutubuhmasuk').val(0);
					}
					
					if(data.pernapasan != null){
						$('#ASResumeaskepR_pernapasanmasuk').val(data.pernapasan);
					}else{
						$('#ASResumeaskepR_pernapasanmasuk').val(0);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	
	function loadFisikPulang(pendaftaran_id)
	{
		if (pendaftaran_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadFisikPulang'); ?>',
				data: {pendaftaran_id: pendaftaran_id},
				dataType: "json",
				success: function (data) {
					$('#ASResumeaskepR_keadaanumummasuk').val(data.keadaanumum);
					
					if(data.tekanandarah != null){
						$('#ASResumeaskepR_tekanandarahakhir').val(data.tekanandarah);
					}else{
						$('#ASResumeaskepR_tekanandarahakhir').val(0);
					}
					
					if(data.detaknadi != null){
						$('#ASResumeaskepR_detaknadiakhir').val(data.detaknadi);
					}else{
						$('#ASResumeaskepR_detaknadiakhir').val(0);
					}
					
					if(data.suhutubuh != null){
						$('#ASResumeaskepR_suhutubuhakhir').val(data.suhutubuh);
					}else{
						$('#ASResumeaskepR_suhutubuhakhir').val(0);
					}
					
					if(data.pernapasan != null){
						$('#ASResumeaskepR_pernapasanakhir').val(data.pernapasan);
					}else{
						$('#ASResumeaskepR_pernapasanakhir').val(0);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	$(document).ready(function () {
        
            /*cekDisabled($('#pembayaran-form'));
            $('form').bind('click keyup select change', function(event) {
               cekDisabled(this);
            });
            $(document).on('click keyup select change','.ui-dialog-content',function(){
               cekDisabled('form');
            });*/
	});
</script>