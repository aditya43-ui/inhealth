<script type="text/javascript">
	function cekPendaftaran(pendaftaran_id) {
                let instalasi_id = document.getElementById('instalasi_id').value
		if (pendaftaran_id !== undefined) {
                        const  set_data = {
                            pendaftaran_id,
                            instalasi_id
                        };
                        
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('cekPendaftaran'); ?>',
				data: {pendaftaran_id: pendaftaran_id},
				dataType: "json",
				success: function (data) {

					if (data != null) {
						myAlert("Pasien kunjungan sudah dilakukan pengkajian askep!");
						return false;
					} else {
						$.ajax({
							type: 'GET',
							url: '<?php echo $this->createUrl('loadPasien'); ?>',
							data: set_data,
							dataType: "json",
							success: function (data) {
								isiDataPasien(data);
								loadPenanggungJawab(data.penanggungjawab_id);
								loadRiwayatAnemnesa(data.pendaftaran_id);
								loadRiwayatPeriksaFisik(data.pendaftaran_id);
								loadTambahPenunjang(data.pendaftaran_id);
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
	function cekRequired() {

		var anamesa_id = $("#<?php echo CHtml::activeId($modPengkajian, 'anamesa_id') ?>").val();
		var pemeriksaanfisik_id = $("#<?php echo CHtml::activeId($modPengkajian, 'pemeriksaanfisik_id') ?>").val();

		if (anamesa_id == '' || pemeriksaanfisik_id == '') {
			myAlert("Silakan Pilih Anamesa dan Pemeriksaan Fisik!");
		} else {
			if (requiredCheck($("#pembayaran-form"))) {
				return true;
			}
		}
		return false;
	}

	function cekListPeriksa(obj) {
		$(obj).parents('table').find('tr').each(function () {
			$(this).find('input[name$="[isperiksafisik]"]').val(0);
			$(this).find('input[name$="[isperiksafisik]"]').prop('checked', false);
		});

		$(obj).val(1);
		$(obj).prop('checked', true);

		var periksa_id = $(obj).parents('tr').find('input[name$="[pemeriksaanfisik_id]"]').val();
		$('#ASPengkajianaskepT_pemeriksaanfisik_id').val(periksa_id);

	}

	function cekListAnamesa(obj) {
		$(obj).parents('table').find('tr').each(function () {
			$(this).find('input[name$="[isanamesa]"]').val(0);
			$(this).find('input[name$="[isanamesa]"]').prop('checked', false);
		});

		$(obj).val(1);
		$(obj).prop('checked', true);

		var anamesa_id = $(obj).parents('tr').find('input[name$="[anamesa_id]"]').val();
		$('#ASPengkajianaskepT_anamesa_id').val(anamesa_id);

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

		//$('#ASTandabuktibayarUangMukaT_jmlpembayaran').focus();
		//$('#ASTandabuktibayarUangMukaT_jmlpembayaran').select();    
	}

	function loadPenanggungJawab(penanggungjawab_id)
	{
		if (penanggungjawab_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadPenanggungJawab'); ?>',
				data: {penanggungjawab_id: penanggungjawab_id},
				dataType: "json",
				success: function (data) {
					if (data != null) {
						$("#ASPenanggungJawabM_nama_pj").val(data.nama_pj);
						$("#ASPenanggungJawabM_no_identitas").val(data.no_identitas);
						$("#ASPenanggungJawabM_jeniskelamin").val(data.jeniskelamin);
						$("#ASPenanggungJawabM_tgllahir_pj").val(data.tgllahir_pj);
						$("#ASPenanggungJawabM_no_teleponpj").val(data.no_teleponpj);
						$("#ASPenanggungJawabM_no_mobilepj").val(data.no_mobilepj);
						$("#ASPenanggungJawabM_hubungankeluarga").val(data.hubungankeluarga);
						$("#ASPenanggungJawabM_alamat_pj").val(data.alamat_pj);
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}

	function loadRiwayatAnemnesa(pendaftaran_id) {
		$('#anemnesa').addClass("animation-loading");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadRiwayatAnemnesa'); ?>',
			data: {pendaftaran_id: pendaftaran_id},
			dataType: "json",
			success: function (data) {
				$('#anemnesa table > tbody').html(data.rows);
				$('#anemnesa table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$('#anemnesa').removeClass("animation-loading");
				renameInputRow($("#anemnesa"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function loadTambahPenunjang(pendaftaran_id) {
		$('#table-penunjang').addClass("animation-loading");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadTambahPenunjang'); ?>',
			data: {pendaftaran_id: pendaftaran_id},
			dataType: "json",
			success: function (data) {
				$('#table-penunjang > tbody').html(data.rows);
				$('#table-penunjang > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$('#table-penunjang').removeClass("animation-loading");
				renameInputRow($("#table-penunjang"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function loadRiwayatPeriksaFisik(pendaftaran_id) {
		$('#periksafisik').addClass("animation-loading");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadRiwayatPeriksaFisik'); ?>',
			data: {pendaftaran_id: pendaftaran_id},
			dataType: "json",
			success: function (data) {
				$('#periksafisik table > tbody').html(data.rows);
				$('#periksafisik table > tbody').find('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$('#periksafisik').removeClass("animation-loading");
				renameInputRow($("#periksafisik"));
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


	function hapusLookup(obj) {
		var datapenunjang_id = $(obj).parents("tr").find("input[name$='[datapenunjang_id]']").val();
		if (datapenunjang_id !== "") {
			myConfirm("Apakah Anda yakin akan menghapus data ini dari database?", "Perhatian!",
					function (r) {
						if (r) {
							$.ajax({
								type: 'POST',
								url: '<?php echo $this->createUrl('DeletePenunjang'); ?>&id=' + datapenunjang_id,
								data: {id: datapenunjang_id}, //
								dataType: "json",
								success: function (data) {
									if (data.sukses == 1) {
										$(obj).parents('tr').detach();
										renameInputRow($("#table-penunjang"));
									}
									myAlert(data.pesan);
									var rowCount = $("#table-penunjang").find('tbody tr').length;
									if (rowCount == 0) {
										tambahPenunjang();
									}
								},
								error: function (jqXHR, textStatus, errorThrown) {
									console.log(errorThrown);
								}
							});
						}
					});
		} else {
			$(obj).parents('tr').detach();
			renameInputRow($("#table-penunjang"));
		}
	}

	function tambahPenunjang() {
		row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true)); ?>'
		$('#table-penunjang').append(row);
		renameInputRow($("#table-penunjang"));
		$("#table-penunjang tr:last .integer").maskMoney(
				{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
		);
	}

	function loadPenunjang(pengkajianaskep_id) {
		$("#table-penunjang").addClass("animation-loading");
		$('#table-penunjang > tbody').html("");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetPenunjang'); ?>',
			data: {pengkajianaskep_id: pengkajianaskep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-penunjang > tbody').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-penunjang").removeClass("animation-loading");
				renameInputRow($("#table-penunjang"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});

	}

	$(document).ready(function () {
//		tambahPenunjang();
<?php if (!empty($modPengkajian->pengkajianaskep_id)) { ?>
			loadPenanggungJawab('<?php echo $modPendaftaran->penanggungjawab_id; ?>');
			loadRiwayatAnemnesa('<?php echo $modPengkajian->pendaftaran_id; ?>');
			loadRiwayatPeriksaFisik('<?php echo $modPengkajian->pendaftaran_id; ?>');
			loadPenunjang('<?php echo $modPengkajian->pengkajianaskep_id; ?>');

<?php } ?>

                        /* cekDisabled($('#pembayaran-form'));
                        $('form').bind('click keyup select change', function(event) {
                           cekDisabled(this);
                        });
                        $(document).on('click keyup select change','.ui-dialog-content',function(){
                           cekDisabled('form');
                        });*/
	})
</script>