<script type="text/javascript">
	
	function isiDataPasien(data)
	{
		$("#RKPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
		$("#RKPendaftaranT_pasien_id").val(data.pasien_id);
		$("#RKPendaftaranT_tgl_pendaftaran").val(data.tgl_pendaftaran);
		$("#RKPendaftaranT_no_pendaftaran").val(data.no_pendaftaran);
		$("#RKPendaftaranT_umur").val(data.umur);
		$("#RKPendaftaranT_jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
		$("#RKPendaftaranT_instalasi_id").val(data.instalasi_id);
		$("#RKPendaftaranT_instalasi_nama").val(data.instalasi_nama);
		$("#RKPendaftaranT_ruangan_nama").val(data.ruangan_nama);
		$("#RKPendaftaranT_pendaftaran_id").val(data.pendaftaran_id);
		$("#RKPendaftaranT_carabayar_id").val(data.carabayar_id);
		$("#RKPendaftaranT_penjamin_id").val(data.penjamin_id);
		$("#RKPendaftaranT_kelaspelayanan_id").val(data.kelaspelayanan_id);
		$("#RKPendaftaranT_kelaspelayanan_nama").val(data.kelaspelayanan_nama);
		$("#RKPendaftaranT_pasien_id").val(data.pasien_id);
		$("#RKPendaftaranT_tempat_lahir").val(data.tempat_lahir);
		$("#RKPendaftaranT_tanggal_lahir").val(data.tanggal_lahir);
		$("#RKTandabuktibayarUangMukaT_darinama_bkm").val(data.nama_pasien);

		$("#RKPendaftaranT_jeniskelamin").val(data.jeniskelamin);
		$("#RKPendaftaranT_no_rekam_medik").val(data.no_rekam_medik);
		$("#RKPendaftaranT_nama_pasien").val(data.nama_pasien);
		$("#RKPendaftaranT_pekerjaan_nama").val(data.pekerjaan_nama);
		$("#RKPendaftaranT_pendidikan_nama").val(data.pendidikan_nama);
		$("#RKPendaftaranT_alamat_pasien").val(data.alamat_pasien);
		$("#RKPendaftaranT_agama").val(data.agama);
		$("#RKPendaftaranT_statusperkawinan").val(data.statusperkawinan);
		$("#RKPendaftaranT_carabayar_nama").val(data.carabayar_nama);
		$("#RKPendaftaranT_penjamin_nama").val(data.penjamin_nama);
		$("#RKPendaftaranT_no_kamarbed").val(data.kamarruangan_nokamar+" / "+data.kamarruangan_nobed);
		if (typeof data.norekammedik != 'undefined') {
			$('#RKPendaftaranT_no_rekam_medik').val(data.norekammedik);
		}
		//$('#ASTandabuktibayarUangMukaT_jmlpembayaran').focus();
		//$('#ASTandabuktibayarUangMukaT_jmlpembayaran').select();    
	}

	
	function loadPasienBerhutang(pendaftaran_id) {
		$('#hutang').addClass("animation-loading");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadPasienBerhutang'); ?>',
			data: {pendaftaran_id: pendaftaran_id},
			dataType: "json",
			success: function (data) {
				$('#hutang table > tbody').html(data.rows);
				$('#hutang table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$('#hutang').removeClass("animation-loading");
				renameInputRow($("#hutang"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function renameInputRow(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > tr").each(function () {
			$(this).find('span').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			row++;
		});

		//====button visibility
		//init
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
		$(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
		//set
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
		$(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
		var rowCount = $(obj_table).find('tbody tr').length;
		if (rowCount == 1) {
			$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
			$(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
			id = $(obj_table).find('tr:first-child input[name*="[datapenunjang_id]"]').val();
			if (id != "") {
				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
			}
		}
		//====end button visibility

	}
	
	function isBlacklist() {
		var obj = $('#RKPasienblacklistT_isblacklist');
		if ($(obj).is(':checked')) {
			$(obj).val(1);
		} else {
			$(obj).val(0);
		}
	}

	function cekListBlacklist(obj) {
		if ($(obj).is(':checked')) {
			$(obj).val(1);
		} else {
			$(obj).val(0);
		}
	}
	
$(document).ready(function () {
	//load daterangepicker
	$('input[name="RKPendaftaranT[tgl_pendaftaran]"]').daterangepicker({
		"maxDate": "<?php echo date('m/d/Y') ?>",
		"showDropdowns": true,
	});
		isBlacklist();
<?php if (!empty($model->pasienblacklist_id)) { ?>
			loadPasienBerhutang('<?php echo $model->pendaftaran_id; ?>');
<?php } ?>
});
</script>