<script type="text/javascript">
	function cekPengkajianId(pengkajianaskep_id) {
		if (pengkajianaskep_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('cekPengkajianId'); ?>',
				data: {pengkajianaskep_id: pengkajianaskep_id},
				dataType: "json",
				success: function (data) {

					if (data != null) {
						myAlert("Pengkajian sudah dipilih!");
						return false;
					} else {

						loadPasien(pengkajianaskep_id);
						return true;
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}

	function cekPengkajian(obj) {
		var pengkajianaskep_id = $("#<?php echo CHtml::activeId($modPengkajian, 'pengkajianaskep_id') ?>").val();
		var iskeperawatan = $("#iskeperawatan").val();
		if (pengkajianaskep_id == '') {
			myAlert("Silakan Pilih Pengkajian!");
		} else {
			if (iskeperawatan == 1) {
				window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajianKeb"); ?>/&pengkajianaskep_id=" + pengkajianaskep_id, "", 'location=_new, width=900px, scrollbars=1');
			}
			if (iskeperawatan == 0) {
				window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/RencanaKeperawatan/DetailPengkajian"); ?>/&pengkajianaskep_id=" + pengkajianaskep_id, "", 'location=_new, width=900px, scrollbars=1');
			}
		}
		return false;
	}

	function cekListPeriksa(obj) {
		$(obj).parents('table').find('tr').each(function () {
			$(this).find('input[name$="[isperiksafisik]"]').val(0);
			$(this).find('input[name$="[isperiksafisik]"]').removeAttr('checked');
		});
		$(obj).val(1);
		$(obj).attr('checked', true);
		var periksa_id = $(obj).parents('tr').find('input[name$="[pemeriksaanfisik_id]"]').val();
		$('#ASPengkajianaskepT_pemeriksaanfisik_id').val(periksa_id);
	}

	function cekListAnamesa(obj) {
		$(obj).parents('table').find('tr').each(function () {
			$(this).find('input[name$="[isanamesa]"]').val(0);
			$(this).find('input[name$="[isanamesa]"]').removeAttr('checked');
		});
		$(obj).val(1);
		$(obj).attr('checked', true);
		var anamesa_id = $(obj).parents('tr').find('input[name$="[anamesa_id]"]').val();
		$('#ASPengkajianaskepT_anamesa_id').val(anamesa_id);
	}

	function isKeperawatan() {
		var obj = $("#iskeperawatan");
		if ($(obj).is(':checked')) {
			$(obj).val(1);
			$(".keperawatan").hide();
			$(".kebidanan").show();
		} else {
			$(obj).val(0);
			$(".keperawatan").show();
			$(".kebidanan").hide();
		}
	}

	function cekListKebidanan(obj) {
		if ($(obj).is(':checked')) {
			$(obj).val(1);
			$(".keperawatan").hide();
			$(".kebidanan").show();
		} else {
			$(obj).val(0);
			$(".keperawatan").show();
			$(".kebidanan").hide();
		}
	}

	function loadPasien(pengkajianaskep_id)
	{
		var iskeperawatan = $('#iskeperawatan').val();
		if (pengkajianaskep_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadPasien'); ?>',
				data: {pengkajianaskep_id: pengkajianaskep_id, iskeperawatan: iskeperawatan},
				dataType: "json",
				success: function (data) {
					if (data !== '') {

						$("#ASPengkajianaskepT_pengkajianaskep_id").val(data.pengkajianaskep_id);
						$("#ASPengkajianaskepT_pendaftaran_id").val(data.pendaftaran_id);
						$("#ASPengkajianaskepT_anamesa_id").val(data.anamesa_id);
						$("#ASPengkajianaskepT_pemeriksaanfisik_id").val(data.pemeriksaanfisik_id);
						$("#ASPengkajianaskepT_no_pengkajian").val(data.no_pengkajian);
						if(data.iskeperawatan == true){
							$("#ASPengkajianaskepT_no_pengkajian").val(data.no_pengkajian);
						}else{
						$("#ASPengkajianaskepT_no_pengkajian_keb").val(data.no_pengkajian);
						}
						
						$("#ASPengkajianaskepT_pengkajianaskep_tgl").val(data.pengkajianaskep_tgl);
						$("#ASPengkajianaskepT_pegawai_id").val(data.pegawai_id);
						$("#ASPengkajianaskepT_nama_pegawai").val(data.nama_pegawai);
						
						$('#ASInfopengkajianaskepV_no_pendaftaran').val(data.no_pendaftaran);
						$('#ASInfopengkajianaskepV_nama_pasien').val(data.nama_pasien);
						$('#ASInfopengkajianaskepV_ruangan_nama').val(data.ruangan_nama);
						$('#ASInfopengkajianaskepV_tgl_pendaftaran').val(data.tgl_pendaftaran);
						$('#ASInfopengkajianaskepV_umur').val(data.umur);
						$('#ASInfopengkajianaskepV_kelaspelayanan_nama').val(data.kelaspelayanan_nama);
						$('#ASInfopengkajianaskepV_no_rekam_medik').val(data.no_rekam_medik);
						$('#ASInfopengkajianaskepV_diagnosa_nama').val(data.diagnosa_nama);
						$('#ASInfopengkajianaskepV_no_kamarbed').val(((data.kamarruangan_nokamar !== null) ? data.kamarruangan_nokamar : '-') + ' / ' + ((data.kamarruangan_nobed !== null) ? data.kamarruangan_nobed : '-'));
						
						loadPenanggungJawab(data.penanggungjawab_id);
						loadRiwayatAnemnesa(data.pendaftaran_id);
						loadRiwayatPeriksaFisik(data.pendaftaran_id);
						loadPengkajian(data.pendaftaran_id);
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
		$('#ASPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
		$('#ASPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
		$('#ASPendaftaranT_umur').val(data.umur);
		$('#ASPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit);
		$('#ASPendaftaranT_instalasi_nama').val(data.namainstalasi);
		$('#ASPendaftaranT_ruangan_nama').val(data.namaruangan);
		$('#ASPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
		$('#ASPendaftaranT_pasien_id').val(data.pasien_id);
		$('#ASPendaftaranT_pasienadmisi_id').val(data.pasienadmisi_id);
		if (typeof data.norekammedik != 'undefined') {
			$('#ASPasienM_no_rekam_medik').val(data.norekammedik);
		}
		$('#ASPasienM_jeniskelamin').val(data.jeniskelamin);
		$('#ASPasienM_nama_pasien').val(data.namapasien);
		$('#ASPasienM_nama_bin').val(data.namabin);
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
                                    if (data != null){
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
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php } ?>
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

<?php if (!empty($model->verifikasiaskep_id)) { ?>
			$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
			$(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().hide();
<?php } ?>
		//====end button visibility

	}


	function hapusLookup(obj) {
		var bataskarakteristikdet_id = $(obj).parents("tr").find("input[name$='[bataskarakteristikdet_id]']").val();
		if (bataskarakteristikdet_id !== "") {
			myConfirm("Apakah Anda yakin akan menghapus data ini dari database?", "Perhatian!",
					function (r) {
						if (r) {
							$.ajax({
								type: 'POST',
								url: '<?php echo $this->createUrl('Delete'); ?>&id=' + bataskarakteristikdet_id,
								data: {id: bataskarakteristikdet_id}, //
								dataType: "json",
								success: function (data) {
									if (data.sukses == 1) {
										$(obj).parents('tr').detach();
										renameInputRow($("#table-lookup"));
									}
									myAlert(data.pesan);
									var rowCount = $("#table-lookup").find('tbody tr').length;
									if (rowCount == 0) {
										tambahLookup();
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
			renameInputRow($("#table-lookup"));
		}
	}

	function tambahPenunjang() {
		row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true)); ?>';
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

	// PENGKAJIAN
	function loadPengkajian(pendaftaran_id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadPengkajian'); ?>',
			data: {pendaftaran_id: pendaftaran_id},
			dataType: "json",
			success: function (data) {
				setPengkajian(data);
				loadRencana();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function setPengkajian(data) {
		$('#content-pengkajian-askep-t').addClass("animation-loading");
		$('#content-pengkajian-askep-t').html('');
		$('#content-pengkajian-askep-t').append(data.form);
		$('#content-pengkajian-askep-t').append(data.form2);
		$('#content-pengkajian-askep-t').append(data.form3);
		jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		$(".integer").maskMoney(
				{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
		);
		renameInputRow($("#table-penunjang"));
		$('#content-pengkajian-askep-t').removeClass("animation-loading");
	}

	function renameInputRowPenunjang(obj_table) {
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

	function tambahPenunjang() {
		row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowPenunjang', array('modPenunjang' => $modPenunjang), true)); ?>'
		$('#table-penunjang').append(row);
		renameInputRowPenunjang($("#table-penunjang"));
		$("#table-penunjang tr:last .integer").maskMoney(
				{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
		);
	}

	function hapusPenunjang(obj) {
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
										tambahLookup();
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
			renameInputRowPenunjang($("#table-penunjang"));
		}
	}

	// RENCANA
	function renameInput(modelName, attributeName)
	{
		var trLength = $('#table-rencana tr').length;
		var i = -1;
		$('#table-rencana tr').each(function () {
			if ($(this).has('input[name$="[diagnosakep_id]"]').length) {
				i++;
			}
			$(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
			$(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
			$(this).find('input[name$="[' + attributeName + '][]"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
			$(this).find('input[name$="[' + attributeName + '][]"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
			$(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
			$(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
			$(this).find('textarea[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
			$(this).find('textarea[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
			$(this).find('input[id="row"]').attr('value', i);
			$(this).find('input[id="row"]').val(i);
//        jQuery('input[name$="[daftartindakanNama]"]').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','maxDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
		});
	}
	function setDialog(obj) {
		parent = $(obj).parents(".input-append").find("input").attr("id");
		dialog = "#dialogDiagnosa";
		$(dialog).attr("parent-dialog", parent);
		$(dialog).dialog("open");
	}

	function setDiagnosaAuto(obj, diagnosakep_id) {
//		diagnosakep_id = diagnosakep_id;
		dialog = "#dialogDiagnosa";
		/*
		 if(idDlg != null)
		 {
		 dialog = idDlg;
		 }
		 */
//		parent = $(dialog).attr("parent-dialog");
//		obj = $("#" + parent);
		$.get('<?php echo Yii::app()->createUrl('asuhanKeperawatan/RencanaKeperawatan/getDiagnosa'); ?>', {diagnosakep_id: diagnosakep_id}, function (data) {
			$(obj).val(data[0].diagnosakep_id);
			$(obj).val(data[0].diagnosakep_nama);
			setDiagnosa(obj, data[0]);
		}, "json");
		$(dialog).dialog("close");
	}

	function setDiagnosaAutoDialog(diagnosakep_id) {
		dialog = "#dialogDiagnosa";

		parent = $(dialog).attr("parent-dialog");
		obj = $("#" + parent);
		$.get('<?php echo Yii::app()->createUrl('asuhanKeperawatan/RencanaKeperawatan/getDiagnosa'); ?>', {diagnosakep_id: diagnosakep_id}, function (data) {
			$(obj).val(data[0].diagnosakep_id);
			$(obj).val(data[0].diagnosakep_nama);
			setDiagnosaDialog(obj, data[0]);
		}, "json");
		$(dialog).dialog("close");
	}

	function setDiagnosa(obj, item)
	{
		$(obj).parents('tr').find('input[name$="[diagnosakep_id]"]').val(item.diagnosakep_id);
		$(obj).parents('tr').find('input[name$="[diagnosakep_nama]"]').val(item.diagnosakep_nama);
		var row_index = $(obj).parents('tr').index();
		setDiagnosaRow(item.diagnosakep_id);
		setTandaGejala(item.diagnosakep_id);
		setTujuan(item.diagnosakep_id);
		setKriteriaHasil(item.diagnosakep_id);
		setIntervensi(item.diagnosakep_id);
		tambahImplementasi(row_index, item);
		tambahEvaluasi(row_index, item);
	}

	function setDiagnosaDialog(obj, item)
	{
		$(obj).parents('tr').find('input[name$="[diagnosakep_id]"]').val(item.diagnosakep_id);
		$(obj).parents('tr').find('input[name$="[diagnosakep_nama]"]').val(item.diagnosakep_nama);
		var row_index = $(obj).parents('tr').index();
		setDiagnosaRow(item.diagnosakep_id);
		setTandaGejala(item.diagnosakep_id);
		setTujuan(item.diagnosakep_id);
		setKriteriaHasil(item.diagnosakep_id);
		setIntervensi(item.diagnosakep_id);
		tambahImplementasi(row_index, item);
		tambahEvaluasi(row_index, item);
	}

	function setDiagnosaRow(diagnosakep_id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo Yii::app()->createUrl('asuhanKeperawatan/RencanaKeperawatan/GetDiagnosaRow'); ?>',
			data: {diagnosakep_id: diagnosakep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-rencana').find('tr').find('.diagdetail').html("");
				$('#table-rencana').find('tr').find('.diagdetail').append(data.form);

				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-rencana").removeClass("animation-loading");
				renameInputDiagDetail('#table-rencana');
//				renameInputRow('#table-rencana');
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function setTandaGejala(diagnosakep_id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetTandaGejala'); ?>',
			data: {diagnosakep_id: diagnosakep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-rencana').find('tr').find('.tandagejala').html("");
				$('#table-rencana').find('tr').find('.tandagejala').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-rencana").removeClass("animation-loading");
				renameInputTandaGejala('#table-rencana');
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function setTujuan(diagnosakep_id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetTujuan'); ?>',
			data: {diagnosakep_id: diagnosakep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-rencana').find('tr').find('.tujuan').html("");
				$('#table-rencana').find('tr').find('.tujuan').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-rencana").removeClass("animation-loading");
				renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_hari');
				renameInput('ASRencanaaskepdetT', 'tujuan_id');
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function setKriteriaHasil(diagnosakep_id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetKriteriaHasil'); ?>',
			data: {diagnosakep_id: diagnosakep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-rencana').find('tr').find('.kriteriahasil').html("");
				$('#table-rencana').find('tr').find('.kriteriahasil').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$("#table-rencana").removeClass("animation-loading");
				renameInput('ASRencanaaskepdetT', 'kriteriahasil_id');
				renameInput('ASRencanaaskepdetT', 'kriteriahasil_nama');
				renameInputRowKriteria('#table-rencana');
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function setIntervensi(diagnosakep_id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetIntervensi'); ?>',
			data: {diagnosakep_id: diagnosakep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-rencana').find('tr').find('.intervensi').html("");
				$('#table-rencana').find('tr').find('.intervensi').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-rencana").removeClass("animation-loading");
				renameInputIntervensi('#table-rencana');
				renameInput('ASRencanaaskepdetT', 'intervensi_id');
				renameInput('ASRencanaaskepdetT', 'intervensi_nama');
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function isKolaborasi() {
		var obj = $('#table-rencana > tbody > tr').find('input[name$="[iskolaborasi]"]');
		if ($(obj).is(':checked')) {
			$(obj).val(1);
		} else {
			$(obj).val(0);
		}
	}

	function cekListKolaborasi(obj) {
		if ($(obj).is(':checked')) {
			$(obj).val(1);
			$(obj).parents('tr').find('textarea[name$="[rencanaaskepdet_ketkolaborasi]"]').removeAttr('readonly');
		} else {
			$(obj).val(0);
			$(obj).parents('tr').find('textarea[name$="[rencanaaskepdet_ketkolaborasi]"]').attr('readonly', true);
		}
	}

	function renameInputDiagDetail(obj_table)
	{
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			var row2 = 0;
			$(this).find('input[name$="[alternatifdx_id]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			$(this).find('input[name$="[alternatifdx_id][]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
				}
				row2++;
			});
			row++;
		});
	}

	function renameInputDiagDetailSimpan(obj_table, modPilih)
	{
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {

			var row2 = 0;
			$(this).find('input[name$="[alternatifdx_id]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			$(this).find('input[name$="[alternatifdx_id][]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
				}
				for (i = 0; i < modPilih[row].length; i++) {
					var tg_id = modPilih[row][i].alternatifdx_id;
					if (tg_id !== 'undefined') {
						if ($(this).val() == tg_id) {
							$(this).attr("checked", "checked");
						}
					}
				}
				row2++;
			});
			row++;
		});
	}

	function renameInputTandaGejala(obj_table)
	{
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {

			var row2 = 0;
			$(this).find('input[name*="[tandagejala_id]"]').each(function () { //element <input>

				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");

					row2++;
				}

			});
			$(this).find('input[name$="[tandagejala_id][]"]').each(function () {
				//element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
				}
				row2++;
			});
			row++;
		});
	}
	function renameInputIntervensi(obj_table)
	{
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			var row2 = 0;
			$(this).find('input[name*="[intervensidet_id]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");

					row2++;

				}
			});
			$(this).find('input[name$="[intervensidet_id][]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
				}
				row2++;
			});
			row++;
		});
	}
	function renameInputRowKriteria(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			var row2 = 0;
			$(this).find('.kriteria').find("tbody > tr").each(function () {
				$(this).find('span').each(function () { //element <input>
					var old_name = $(this).attr("name").replace(/]/g, "");
					var old_name_arr = old_name.split("[");
					if (old_name_arr.length == 3) {
						$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
					}
				});
				$(this).find('input,select,textarea').each(function () { //element <input>
					var old_name = $(this).attr("name").replace(/]/g, "");
					var old_name_arr = old_name.split("[");
					if (old_name_arr.length == 3) {
						$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
						$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
					}
				});
				row2++;
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
		var rowCount = $(obj_table).find('tbody > tr').length;
		if (rowCount == 1) {
			$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
			$(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
			id = $(obj_table).find('tr:first-child input[name*="[diagnosakep_id]"]').val();
			if (id != "") {
				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
			}
		}
		//====end button visibility

	}

	function loadRencana(callback) {
		var pengkajianaskep_id = $('#ASPengkajianaskepT_pengkajianaskep_id').val();
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadRencana'); ?>',
			data: {pengkajianaskep_id: pengkajianaskep_id},
			dataType: "json",
			success: function (data) {
				setRencana(data);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				jQuery('#ASRencanaaskepT_nama_pegawai').autocomplete(
						{
							'showAnim': 'fold',
							'minLength': 3,
							'focus': function (event, ui)
							{
								$(this).val(ui.item.label);
								return false;
							},
							'select': function (event, ui)
							{
								$("#ASRencanaaskepT_pegawai_id").val(ui.item.pegawai_id);
								$("#ASRencanaaskepT_nama_pegawai").val(ui.item.nama_pegawai);
								return false;
							},
							'source': function (request, response)
							{
								$.ajax({
									url: "<?php echo $this->createUrl('Pegawairiwayat'); ?>",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function (data) {
										response(data);
									}
								})
							}
						}
				);
				jQuery('#ASRencanaaskepT_rencanaaskep_tgl').datetimepicker(
						jQuery.extend(
								{
									showMonthAfterYear: false
								},
						jQuery.datepicker.regional['id'],
								{
									'dateFormat': 'dd M yy',
									'maxDate': 'd',
									'timeText': 'Waktu',
									'hourText': 'Jam',
									'minuteText': 'Menit',
									'secondText': 'Detik',
									'showSecond': true,
									'timeOnlyTitle': 'Pilih Waktu',
									'timeFormat': 'hh:mm:ss',
									'changeYear': true,
									'changeMonth': true,
									'showAnim': 'fold',
									'yearRange': '-80y:+20y'
								}
						)
						);
				jQuery('#ASRencanaaskepT_rencanaaskep_tgl_date').on('click', function () {
					jQuery('#ASRencanaaskepT_rencanaaskep_tgl').datepicker('show');

				});
				jQuery('input[name$="[diagnosakep_nama]"]').autocomplete(
						{
							'showAnim': 'fold',
							'minLength': 3,
							'focus': function (event, ui)
							{
								$(this).val(ui.item.diagnosakep_nama);
								return false;
							},
							'select': function (event, ui)
							{
								setDiagnosaAuto($(this), ui.item.diagnosakep_id);
								return false;
							},
							'source': function (request, response)
							{
								$.ajax({
									url: "<?php echo $this->createUrl('AutocompleteDiagnosa'); ?>",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function (data) {
										response(data);
									}
								})
							}
						}
				);
                                loadImplementasi();
				// if callback exist execute it
				callback && callback();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function setRencana(data) {
		$('#content-rencana-askep-t').addClass("animation-loading");
		$('#content-rencana-askep-t').html('');
		$('#content-rencana-askep-t').append(data.form);
		$('#content-rencana-askep-t').append(data.form1);
		jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		$(".integer").maskMoney(
				{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
		);
		$('#content-rencana-askep-t').removeClass("animation-loading");
		renameInputRowRencana($("#table-rencana"));
		renameInputDiagDetailSimpan('#table-rencana', data.modPilih);
		renameInputTandaGejalaRencanaSimpan('#table-rencana', data.modPilih);
		renameInputRowKriteriaRencanaSimpan('#table-rencana', data.modPilih);
		renameInputIntervensiRencanaSimpan('#table-rencana', data.modPilih);
                renameInputImplementasiSimpan('#table-rencana', data.modPilih);
	}

	function renameInputRowRencana(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
<?php // if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php // } ?>
			});
			row++;
		});
		//====button visibility
		//init
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
		$(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
		//set
		$(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
		$(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
		var rowCount = $(obj_table).find('tbody tr').length;
		if (rowCount == 1) {
			$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
			$(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
			id = $(obj_table).find('tr:first-child input[name*="[rencanaaskepdet_id]"]').val();
//			if (id != "") {
//				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
//			}
		}
		//====end button visibility

	}

	function renameInputRowKriteriaRencana(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			var row2 = 0;
			$(this).find('.kriteria').find("tbody > tr").each(function () {
				$(this).find('span').each(function () { //element <input>
					var old_name = $(this).attr("name").replace(/]/g, "");
					var old_name_arr = old_name.split("[");
					if (old_name_arr.length == 3) {
						$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
					}
				});
				$(this).find('input,select,textarea').each(function () { //element <input>
					var old_name = $(this).attr("name").replace(/]/g, "");
					var old_name_arr = old_name.split("[");
					if (old_name_arr.length == 3) {
						$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
						$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
					}
					if (old_name_arr.length == 4) {
						$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
						$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
					}
				});
				row2++;
			});
			row++;
		});
	}
	function renameInputRowKriteriaRencanaSimpan(obj_table, modPilih) {
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			var row2 = 0;
			$(this).find('.kriteria').find("tbody > tr").each(function () {
				$(this).find('span').each(function () { //element <input>
					var old_name = $(this).attr("name").replace(/]/g, "");
					var old_name_arr = old_name.split("[");
					if (old_name_arr.length == 3) {
						$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
					}
				});

				$(this).find('input,select,textarea').each(function () { //element <input>
					var old_name = $(this).attr("name").replace(/]/g, "");
					var old_name_arr = old_name.split("[");
					if (old_name_arr.length == 4) {
						$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
						$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
					}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
						$(this).attr('readonly', 'readonly');
<?php } ?>
				});

				$(this).find('select[name$="[rencanaaskep_ir]"]').each(function () { //element <input>
					var old_name = $(this).attr("name").replace(/]/g, "");
					var old_name_arr = old_name.split("[");
					if (old_name_arr.length == 3) {
						$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
						$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
					}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
						$(this).attr('readonly', 'readonly');
<?php } ?>
				});
				$(this).find('select[name$="[rencanaaskep_er]"]').each(function () { //element <input>
					var old_name = $(this).attr("name").replace(/]/g, "");
					var old_name_arr = old_name.split("[");
					if (old_name_arr.length == 3) {
						$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
						$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
					}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
						$(this).attr('readonly', 'readonly');
<?php } ?>
				});
				$(this).find('input[name$="[kriteriahasildet_id]"]').each(function () { //element <input>
					var old_name = $(this).attr("name").replace(/]/g, "");
					var old_name_arr = old_name.split("[");
					if (old_name_arr.length == 3) {
						$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
						$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]" + "[" + row2 + "]");
					}

					for (i = 0; i < modPilih[row].length; i++) {
						var tg_id = modPilih[row][i].kriteriahasildet_id;
						var ir = modPilih[row][i].rencanaaskep_ir;
						var er = modPilih[row][i].rencanaaskep_er;
						if (tg_id !== 'undefined') {
							if ($(this).val() == tg_id) {
								$(this).attr("checked", "checked");
								$(this).parents('tr').find('select[name$="[' + row + '][rencanaaskep_ir][' + row2 + ']"]').val(ir);
								$(this).parents('tr').find('select[name$="[' + row + '][rencanaaskep_er][' + row2 + ']"]').val(er);
							}
						}

					}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
						$(this).attr('readonly', 'readonly');
<?php } ?>
				});
				row2++;
			});
			row++;
		});
	}

	function renameInputIntervensiRencanaSimpan(obj_table, modPilih)
	{
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			var row2 = 0;
			$(this).find('input[name="[intervensidet_id]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php } ?>
			});
			$(this).find('input[name$="[intervensidet_id][]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
				}

				for (i = 0; i < modPilih[row].length; i++) {
					var tg_id = modPilih[row][i].intervensidet_id;
					if (tg_id !== 'undefined') {
						if ($(this).val() == tg_id) {
							$(this).attr("checked", "checked");
						}
					}
				}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php } ?>
				row2++;
			});
			row++;
		});
	}

	function renameInputTandaGejalaRencanaSimpan(obj_table, modPilih)
	{
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {

			var row2 = 0;
			$(this).find('input[name$="[tandagejala_id]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
			});
			$(this).find('input[name$="[tandagejala_id][]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
				}
				for (i = 0; i < modPilih[row].length; i++) {
					var tg_id = modPilih[row][i].tandagejala_id;
					if (tg_id !== 'undefined') {
						if ($(this).val() == tg_id) {
							$(this).attr("checked", "checked");
						}
					}
				}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr("readonly", "readonly");
<?php } ?>
				row2++;
			});
			row++;
		});
	}

	function cekListTandaGejalaRencana(obj) {
		if ($(obj).is(':checked')) {

		} else {
			var tandagejala_id = $(obj).val();
			var rencanaaskepdet_id = $(obj).parents('tr').find('input[name$="[rencanaaskepdet_id]"]').val();
			$.post('<?php echo $this->createUrl('DeleteTandaGejalaRencana') ?>', {tandagejala_id: tandagejala_id, rencanaaskepdet_id: rencanaaskepdet_id}, function (data) {
				if (data.success)
				{
					console.log('Data berhasil dihapus !!');
				} else {
					console.log('Data Gagal dihapus');
				}
			}, 'json');
		}
	}

	function cekListKriteriaHasilRencana(obj) {
		if ($(obj).is(':checked')) {

		} else {
			var kriteriahasildet_id = $(obj).val();
			var rencanaaskepdet_id = $(obj).parents('tr').find('input[name$="[rencanaaskepdet_id]"]').val();
			$.post('<?php echo $this->createUrl('DeleteKriteriaHasilRencana') ?>', {kriteriahasildet_id: kriteriahasildet_id, rencanaaskepdet_id: rencanaaskepdet_id}, function (data) {
				if (data.success)
				{
					console.log('Data berhasil dihapus !!');
				} else {
					console.log('Data Gagal dihapus');
				}
			}, 'json');
		}
	}

	function cekListIntervensiRencana(obj) {
		if ($(obj).is(':checked')) {

		} else {
			var intervensidet_id = $(obj).val();
			var rencanaaskepdet_id = $(obj).parents('tr').find('input[name$="[rencanaaskepdet_id]"]').val();
			$.post('<?php echo $this->createUrl('DeleteIntervensiRencana') ?>', {intervensidet_id: intervensidet_id, rencanaaskepdet_id: rencanaaskepdet_id}, function (data) {
				if (data.success)
				{
					console.log('Data berhasil dihapus !!');
				} else {
					console.log('Data Gagal dihapus');
				}
			}, 'json');
		}
	}

	var trRencana = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowRencanaDetail', array('modRencanaDet' => $modRencanaDet), true)); ?>);
	function addRowRencana(obj)
	{
		$(obj).parents('table').children('tbody').append(trRencana.replace());
<?php
$attributes = $modRencanaDet->attributeNames();
foreach ($attributes as $i => $attribute) {
	echo "renameInput('ASRencanaaskepdetT','$attribute');";
}
?>
		renameInput('ASRencanaaskepdetT', 'diagnosakep_nama');
		renameInput('ASRencanaaskepdetT', 'diagnosakep_id');
		renameInput('ASRencanaaskepdetT', 'tandagejala_id');
		renameInput('ASRencanaaskepdetT', 'istandagejala');
		renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_hari');
		renameInput('ASRencanaaskepdetT', 'tujuan_id');
		renameInput('ASRencanaaskepdetT', 'kriteriahasil_id');
		renameInput('ASRencanaaskepdetT', 'kriteriadet_id');
		renameInput('ASRencanaaskepdetT', 'kriteriahasil_id');
		renameInput('ASRencanaaskepdetT', 'kriteriahasil_nama');
		renameInput('ASRencanaaskepdetT', 'iskriteria');
		renameInput('ASRencanaaskepdetT', 'kriteriahasildet_id');
		renameInput('ASRencanaaskepdetT', 'rencanaaskep_ir');
		renameInput('ASRencanaaskepdetT', 'rencanaaskep_er');
		renameInput('ASRencanaaskepdetT', 'intervensi_id');
		renameInput('ASRencanaaskepdetT', 'intervensidet_id');
		renameInput('ASRencanaaskepdetT', 'intervensi_nama');
		renameInput('ASRencanaaskepdetT', 'isintervensi');
		renameInput('ASRencanaaskepdetT', 'iskolaborasi');
		renameInput('ASRencanaaskepdetT', 'rencanaaskepdet_ketkolaborasi');

		//====button visibility
		//init
		$(obj).parents('table').find('tr td.rowbutton .icon-plus-sign').parent().hide();
		$(obj).parents('table').find('tr td.rowbutton .icon-minus-sign').parent().show();
		//set
		$(obj).parents('table').find('tr td.rowbutton .icon-plus-sign').parent().hide();
		$(obj).parents('table').find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
		var rowCount = $(obj).parents('table').find('tbody tr').length;
		if (rowCount == 1) {
			$(obj).parents('table').find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
			$(obj).parents('table').find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
			id = $(obj).parents('table').find('tr:first-child input[name*="[rencanaaskepdet_id]"]').val();
//			if (id != "") {
//				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
//			}
		}
		//====end button visibility

		jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		jQuery('input[name$="[diagnosakep_nama]"]').autocomplete(
				{
					'showAnim': 'fold',
					'minLength': 3,
					'focus': function (event, ui)
					{
						$(this).val(ui.item.diagnosakep_nama);
						return false;
					},
					'select': function (event, ui)
					{
						setDiagnosa(this, ui.item);
						return false;
					},
					'source': function (request, response)
					{
						$.ajax({
							url: "<?php echo $this->createUrl('AutocompleteDiagnosa'); ?>",
							dataType: "json",
							data: {
								term: request.term,
							},
							success: function (data) {
								response(data);
							}
						})
					}
				}
		);
	}

	function hapusRencana(obj) {
		var rencanaaskepdet_id = $(obj).parents("tr").find("input[name$='[rencanaaskepdet_id]']").val();
		var diagnosakep_id = $(obj).parents("tr").find("input[name$='[diagnosakep_id]']").val();
		var row_index = $(obj).parents('tr').index();
		if (rencanaaskepdet_id !== "") {
			myConfirm("Apakah Anda yakin akan menghapus data ini dari database?", "Perhatian!",
					function (r) {
						if (r) {
							$.ajax({
								type: 'POST',
								url: '<?php echo $this->createUrl('DeleteRencana'); ?>&id=' + rencanaaskepdet_id,
								data: {id: rencanaaskepdet_id}, //
								dataType: "json",
								success: function (data) {
									
									$('#table-rencana').addClass("animation-loading");
									$('#table-evaluasi').addClass("animation-loading");
									$('#table-evaluasi').find('tbody > .rencanaaskepdet').eq(row_index).detach();
									renameInputRowEvaluasi("#table-evaluasi");
									$('#table-evaluasi').removeClass("animation-loading");

									$('#table-implementasi').addClass("animation-loading");
									$('#table-implementasi').find('tbody > .rencanaaskepdet').eq(row_index).detach();
									renameInputRowImplementasi("#table-implementasi");
									renameInputImplementasi("#table-implementasi");
									$('#table-implementasi').removeClass("animation-loading");

									$(obj).parents('tr').detach();
									renameInputTandaGejala("#table-rencana");
									renameInputRowKriteriaRencana("#table-rencana");
									renameInputIntervensi("#table-rencana");
									renameInputRowRencana("#table-rencana");

									var rowCount = $("#table-rencana").find('tbody > .rencanaaskepdet').length;
									if (rowCount == 0) {
										addRowRencana(obj);
									}
									$('#table-rencana').removeClass("animation-loading");
								},
								error: function (jqXHR, textStatus, errorThrown) {
									console.log(errorThrown);
								}
							});
						}
					});
		} else {
			if (diagnosakep_id !== "") {
				$('#table-evaluasi').addClass("animation-loading");
				$('#table-evaluasi').find('tbody > .rencanaaskepdet').eq(row_index).detach();
				renameInputRowEvaluasi($("#table-evaluasi"));
				$('#table-evaluasi').removeClass("animation-loading");

				$('#table-implementasi').addClass("animation-loading");
				$('#table-implementasi').find('tbody > .rencanaaskepdet').eq(row_index).detach();
				renameInputRowImplementasi($("#table-implementasi"));
				$('#table-implementasi').removeClass("animation-loading");

				$(obj).parents('tr').detach();
				renameInputRowRencana($("#table-rencana"));
			} else {
				$(obj).parents('tr').detach();
				renameInputRowRencana($("#table-rencana"));
			}

		}
	}

	// IMPLEMENTASI
	function loadImplementasi(callback) {
		var rencanaaskep_id = $('#ASRencanaaskepT_rencanaaskep_id').val();
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadImplementasi'); ?>',
			data: {rencanaaskep_id: rencanaaskep_id},
			dataType: "json",
			success: function (data) {
				setImplementasi(data);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				jQuery('#ASImplementasiaskepT_nama_pegawai').autocomplete(
						{
							'showAnim': 'fold',
							'minLength': 3,
							'focus': function (event, ui)
							{
								$(this).val(ui.item.label);
								return false;
							},
							'select': function (event, ui)
							{
								$("#ASImplementasiaskepT_pegawai_id").val(ui.item.pegawai_id);
								$("#ASImplementasiaskepT_nama_pegawai").val(ui.item.nama_pegawai);
								return false;
							},
							'source': function (request, response)
							{
								$.ajax({
									url: "<?php echo $this->createUrl('Pegawairiwayat'); ?>",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function (data) {
										response(data);
									}
								})
							}
						}
				);
				jQuery('#ASImplementasiaskepT_implementasiaskep_tgl').datetimepicker(
						jQuery.extend(
								{
									showMonthAfterYear: false
								},
						jQuery.datepicker.regional['id'],
								{
									'dateFormat': 'dd M yy',
									'maxDate': 'd',
									'timeText': 'Waktu',
									'hourText': 'Jam',
									'minuteText': 'Menit',
									'secondText': 'Detik',
									'showSecond': true,
									'timeOnlyTitle': 'Pilih Waktu',
									'timeFormat': 'hh:mm:ss',
									'changeYear': true,
									'changeMonth': true,
									'showAnim': 'fold',
									'yearRange': '-80y:+20y'
								}
						)
						);
				jQuery('#ASImplementasiaskepT_implementasiaskep_tgl_date').on('click', function () {
					jQuery('#ASImplementasiaskepT_implementasiaskep_tgl').datepicker('show');
				});
                                
                                loadEvaluasi();
				callback && callback();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function setImplementasi(data) {
		$('#content-implementasi-askep-t').addClass("animation-loading");
		$('#content-implementasi-askep-t').html('');
		$('#content-implementasi-askep-t').append(data.form);
		$('#content-implementasi-askep-t').append(data.form1);
		jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		$(".integer").maskMoney(
				{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
		);
		$('#content-implementasi-askep-t').removeClass("animation-loading");
		renameInputDiagDetailSimpan('#table-implementasi', data.modPilih);
		renameInputRowImplementasi($("#table-implementasi"));
		renameInputImplementasiSimpan('#table-implementasi', data.modPilih);
	}

	function renameInputImplementasi(obj_table)
	{
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			var row2 = 0;
			$(this).find('input[name*="[indikatorimplkepdet_id]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}

				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
					row2++;

				}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php } ?>
			});
			$(this).find('input[name$="[indikatorimplkepdet_id][]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
				}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php } ?>
				row2++;
			});
			row++;
		});
	}

	function renameInputImplementasiSimpan(obj_table, modPilih)
	{
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			var row2 = 0;
			$(this).find('input[name$="[indikatorimplkepdet_id]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
<?php // if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php // } ?>
			});
			$(this).find('input[name$="[indikatorimplkepdet_id][]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if (old_name_arr.length == 4) {

					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + row2);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + row2 + "]");
				}

				for (i = 0; i < modPilih[row].length; i++) {
					var tg_id = modPilih[row][i].indikatorimplkepdet_id;
					if (tg_id !== 'undefined') {
						if ($(this).val() == tg_id) {
							$(this).attr("checked", "checked");
						}
					}
				}
<?php // if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php // } ?>
				row2++;
			});
			row++;
		});
	}

	function renameInputRowImplementasi(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php } ?>
			});
			row++;
		});
	}

	function renameInputRowImplementasiSimpan(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {

			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php } ?>
			});
			$(this).find('input[name$="[isdiagnosa]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if ($(this).val() == 1) {
					$(this).attr('checked', 'checked');
					$(this).attr('readonly', 'readonly');
				}
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php } ?>
			});
			row++;
		});
	}

	function tambahImplementasi(row_index, item) {
		rowimplementasi = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowImplementasiDetail', array('modDetail' => $modImplementasiDet), true)); ?>';
		diagkep_id = $("#table-implementasi").find("tbody > tr:eq(" + row_index + ")").find('input[name$="[diagnosakep_id]"]').val();
		if (diagkep_id == undefined) {
			$("#table-implementasi").append(rowimplementasi);
		}
		$("#table-implementasi").find("tbody > tr:eq(" + row_index + ")").find('input[name$="[diagnosakep_id]"]').val(item.diagnosakep_id);
		$("#table-implementasi").find("tbody > tr:eq(" + row_index + ")").find('input[name$="[diagnosakep_nama]"]').val(item.diagnosakep_nama);
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetDiagnosaImplementasi'); ?>',
			data: {diagnosakep_id: item.diagnosakep_id}, //
			dataType: "json",
			success: function (data) {

				$("#table-implementasi").find("tbody > tr:eq(" + row_index + ")").find('.diagnosa').html("");
				$("#table-implementasi").find("tbody > tr:eq(" + row_index + ")").find('.diagnosa').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$("#table-implementasi").removeClass("animation-loading");
//				renameInputImplementasi("#table-implementasi");
				setImplementasiDetail(row_index, item.diagnosakep_id);
				setRencanaIntervensi(row_index, item.diagnosakep_id);
				renameInputDiagDetail("#table-implementasi");
				renameInputRowImplementasi("#table-implementasi");
				renameInputImplementasi("#table-implementasi");
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}
	function setImplementasiDetail(row_index, diagnosakep_id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('getImplementasiDetail'); ?>',
			data: {diagnosakep_id: diagnosakep_id}, //
			dataType: "json",
			success: function (data) {
				$("#table-implementasi").find("tbody > tr:eq(" + row_index + ")").find('.implementasi').html("");
				$("#table-implementasi").find("tbody > tr:eq(" + row_index + ")").find('.implementasi').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$("#table-implementasi").removeClass("animation-loading");
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				renameInputImplementasi('#table-implementasi');
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function setRencanaIntervensi(row_index, diagnosakep_id) {
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetRencanaIntervensi'); ?>',
			data: {diagnosakep_id: diagnosakep_id}, //
			dataType: "json",
			success: function (data) {
				$("#table-implementasi").find("tbody > tr:eq(" + row_index + ")").find('.intervensi').html("");
				$("#table-implementasi").find("tbody > tr:eq(" + row_index + ")").find('.intervensi').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$("#table-implementasi").removeClass("animation-loading");
				renameInputRowImplementasi('#table-implementasi');
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}


	function cekListImplementasiDetail(obj) {
		if ($(obj).is(':checked')) {

		} else {
			var indikatorimplkepdet_id = $(obj).val();
			var implementasiaskepdet_id = $(obj).parents('tr').find('input[name$="[implementasiaskepdet_id]"]').val();
			$.post('<?php echo $this->createUrl('DeletePilihImplementasi') ?>', {indikatorimplkepdet_id: indikatorimplkepdet_id, implementasiaskepdet_id: implementasiaskepdet_id}, function (data) {
				if (data.success)
				{
					myAlert('Data berhasil dihapus.');
				} else {
					myAlert('Data Gagal dihapus');
				}
			}, 'json');
		}
	}

	// EVALUASI
	function loadEvaluasi() {
		var implementasiaskep_id = $('#ASImplementasiaskepT_implementasiaskep_id').val();
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('loadEvaluasi'); ?>',
			data: {implementasiaskep_id: implementasiaskep_id},
			dataType: "json",
			success: function (data) {
				setEvaluasi(data);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				jQuery('#ASEvaluasiaskepT_nama_pegawai').autocomplete(
						{
							'showAnim': 'fold',
							'minLength': 3,
							'focus': function (event, ui)
							{
								$(this).val(ui.item.label);
								return false;
							},
							'select': function (event, ui)
							{
								$("#ASEvaluasiaskepT_pegawai_id").val(ui.item.pegawai_id);
								$("#ASEvaluasiaskepT_nama_pegawai").val(ui.item.nama_pegawai);
								return false;
							},
							'source': function (request, response)
							{
								$.ajax({
									url: "<?php echo $this->createUrl('Pegawairiwayat'); ?>",
									dataType: "json",
									data: {
										term: request.term,
									},
									success: function (data) {
										response(data);
									}
								})
							}
						}
				);
				jQuery('#ASEvaluasiaskepT_evaluasiaskep_tgl').datetimepicker(
						jQuery.extend(
								{
									showMonthAfterYear: false
								},
						jQuery.datepicker.regional['id'],
								{
									'dateFormat': 'dd M yy',
									'maxDate': 'd',
									'timeText': 'Waktu',
									'hourText': 'Jam',
									'minuteText': 'Menit',
									'secondText': 'Detik',
									'showSecond': true,
									'timeOnlyTitle': 'Pilih Waktu',
									'timeFormat': 'hh:mm:ss',
									'changeYear': true,
									'changeMonth': true,
									'showAnim': 'fold',
									'yearRange': '-80y:+20y'
								}
						)
						);
				jQuery('#ASEvaluasiaskepT_evaluasiaskep_tgl_date').on('click', function () {
					jQuery('#ASEvaluasiaskepT_evaluasiaskep_tgl').datepicker('show');
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function setEvaluasi(data) {
		$('#content-evaluasi-askep-t').addClass("animation-loading");
		$('#content-evaluasi-askep-t').html('');
		$('#content-evaluasi-askep-t').append(data.form);
		$('#content-evaluasi-askep-t').append(data.form1);
		jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
		$(".integer").maskMoney(
				{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
		);
		$('#content-evaluasi-askep-t').removeClass("animation-loading");
		renameInputRowEvaluasi($("#table-evaluasi"));
	}

	function renameInputRowEvaluasi(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {

			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
//				$(this).attr('readonly','readonly');
<?php if (!empty($model->verifikasiaskep_id)) { ?>
					$(this).attr('readonly', 'readonly');
<?php } ?>
			});
			$(this).find('input[name$="[isdiagnosa]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if ($(this).val() == 1) {
					$(this).attr('checked', 'checked');
//					$(this).attr('readonly','readonly');
				}
			});
			row++;
		});
	}

	function tambahEvaluasi(row_index, item) {
		rowevaluasi = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowEvaluasiDetail', array('modEvaluasiDet' => $modEvaluasiDet), true)); ?>';

		diagkep_id = $("#table-evaluasi").find("tbody > tr:eq(" + row_index + ")").find('input[name$="[diagnosakep_id]"]').val();
		if (diagkep_id == undefined) {
			$('#table-evaluasi').append(rowevaluasi);
		}
		$("#table-evaluasi").find("tbody > tr:eq(" + row_index + ")").find('input[name$="[diagnosakep_id]"]').val(item.diagnosakep_id);
		$("#table-evaluasi").find("tbody > tr:eq(" + row_index + ")").find('input[name$="[diagnosakep_nama]"]').val(item.diagnosakep_nama);
		renameInputRowEvaluasi('#table-evaluasi');
	}

	function loadKelasPelayanan(pendaftaran_id) {
		if (pendaftaran_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('getKelasPelayanan'); ?>',
				data: {pendaftaran_id: pendaftaran_id},
				dataType: "json",
				success: function (data) {

					if (data !== '') {
						$('#ASInfopengkajianaskepV_kelaspelayanan_nama').val(data);

					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}

	$(document).ready(function () {
		tambahPenunjang();
		isKeperawatan();
<?php if (!empty($model->verifikasiaskep_id)) { ?>
			loadPenanggungJawab('<?php echo $modPendaftaran->penanggungjawab_id; ?>');
			loadRiwayatAnemnesa('<?php echo $modPengkajian->pendaftaran_id; ?>');
			loadRiwayatPeriksaFisik('<?php echo $modPengkajian->pendaftaran_id; ?>');
			loadPengkajian('<?php echo $modPengkajian->pendaftaran_id; ?>');
			var iskeperawatan = <?php echo json_encode($modPengkajian->iskeperawatan); ?>;
			if (iskeperawatan == true) {
				$('#iskeperawatan').attr("unchecked", "unchecked");
				$('#iskeperawatan').attr("disabled", "disabled");
				$('#iskeperawatan').val(0);
				$(".keperawatan").show();
				$(".kebidanan").hide();
			}
			if (iskeperawatan == false) {
				$('#iskeperawatan').attr("checked", "checked");
				$('#iskeperawatan').attr("disabled", "disabled");
				$('#iskeperawatan').val(1);
				$(".keperawatan").hide();
				$(".kebidanan").show();
			}
<?php } ?>

            cekDisabled($('#pembayaran-form'));
            $('form').bind('click keyup select change', function(event) {
               cekDisabled(this);
            });
            $(document).on('click keyup select change','.ui-dialog-content',function(){
               cekDisabled('form');
            });
	});
        
  /**
        * - Digunakan untuk show hide asesmen berdasarkan ruangan instalasi
        * @website	   <.com>
        * @version     2.0.0
        * 
        */
        function showRiwayatAsesmen(data){
            
            console.log("dsds"+data.asesmenawalkebidanan_bidan_id);
            console.log("dsds"+data.asesmenawalkritis_id);
            
            if(data.ruangan_id == 246){
                //Ruangan VK
                var x = document.getElementById("awalkebidanans");
                if (x.style.display === "none") {
                    x.style.display = "block";
                }
                
                var y = document.getElementById("awalkritiss");
                if (y.style.display === "block") {
                    y.style.display = "none";
                }
                
                var z = document.getElementById("awalkeperawatans");
                if (z.style.display === "block") {
                    z.style.display = "none";
                }
            }else if(data.ruangan_id == 625 || data.ruangan_id == 630 || data.ruangan_id == 631 || data.ruangan_id == 46 || data.ruangan_id == 713 || data.ruangan_id == 661 ){
                //Instalasi Rawat Intensif
                var x = document.getElementById("awalkritiss");
                if (x.style.display === "none") {
                    x.style.display = "block";
                }
                
                var y = document.getElementById("awalkebidanans");
                if (y.style.display === "block") {
                    y.style.display = "none";
                }
                
                var z = document.getElementById("awalkeperawatans");
                if (z.style.display === "block") {
                    z.style.display = "none";
                }
            }else{
                //Ruangan Lainnya
                if(data.instalasi_id == 4 || data.instalasi_id == 116 || data.instalasi_id == 117 || data.instalasi_id == 190 || data.instalasi_id == 195 || data.instalasi_id == 196 || data.instalasi_id == 201){
                    var str = data.umur;
                    var res = str.substr(0, 3);
                    console.log(parseInt(res));
                    console.log(data.instalasi_id);
                    if(parseInt(res) >= 18){
                        var x = document.getElementById("awalkeperawatans");
                        if (x.style.display === "none") {
                            x.style.display = "block";
                        }
                        var b = document.getElementById("awalkeperawatananaks");
                        if (b.style.display === "block") {
                            b.style.display = "none";
                        }
                    }else if(parseInt(res) < 18){
                        var x = document.getElementById("awalkeperawatananaks");
                        if (x.style.display === "none") {
                            x.style.display = "block";
                        }
                        var b = document.getElementById("awalkeperawatans");
                        if (b.style.display === "block") {
                            b.style.display = "none";
                        }
                    }
                    
                    var a = document.getElementById("awalkeperawatandewasas");
                    if (a.style.display === "block") {
                        a.style.display = "none";
                    }
                }else{
                    var x = document.getElementById("awalkeperawatandewasas");
                    if (x.style.display === "none") {
                        x.style.display = "block";
                    }
                }
                
                var y = document.getElementById("awalkebidanans");
                if (y.style.display === "block") {
                    y.style.display = "none";
                }
                
                var z = document.getElementById("awalkritiss");
                if (z.style.display === "block") {
                    z.style.display = "none";
                }
            }
                
//                var y = document.getElementById("awalkritiss");
//                if (y.style.display === "block") {
//                    y.style.display = "none";
//                }
//                
//                var z = document.getElementById("awalkeperawatans");
//                if (z.style.display === "block") {
//                    z.style.display = "none";
//                }
            
        }     
        
        
    function setTindakan(obj) {

        var item = [];
        var i = 0;
        $(obj).parents('tr').find('.intervensi').each(function () {
            $(this).find('.intervensinya:checked').each(function (i) {
                var nama = $(this).val();
                var arraycontains_item = (item.indexOf(nama) > -1);
                console.log(arraycontains_item);

                if (arraycontains_item == false) {
                    item[i] = nama;
                    i++;
                }
            });
        });

        var intervensidet_id = item.join(',');
        $(obj).parents('tr').find('.tindakannya').each(function () {
            $(this).find("#table-tindakannya").addClass("animation-loading");
        });
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setTindakan'); ?>',
            data: {intervensidet_id: intervensidet_id},
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.tindakannya').each(function () {
                    $(this).find('#table-tindakannya').html("");
                    $(this).find('#table-tindakannya').append(data.tabel);
                    $(this).find("#table-tindakannya").removeClass("animation-loading");
                });
                renameInputImplementasi('#table-tindakannya');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>