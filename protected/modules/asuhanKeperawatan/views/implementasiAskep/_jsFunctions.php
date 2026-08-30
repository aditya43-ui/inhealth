<script type="text/javascript">
        const cetakRiwayat = () => {
            let rencanaaskep_id = $("#ASRencanaaskepT_rencanaaskep_id").val();
            
            if (rencanaaskep_id == ''){
                toastr.error("Rencana Askep belum dipilih!","Perhatian!");
            }else{
                window.open("<?php echo $this->createUrl("cetakRiwayat"); ?>/&rencanaaskep_id=" + rencanaaskep_id+"&caraPrint=PRINT", "", 'location=_new, width=900px, scrollbars=1');
            }
        }
    
	function cekRencanaId(rencanaaskep_id) {
		if (rencanaaskep_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('cekRencanaId'); ?>',
				data: {rencanaaskep_id: rencanaaskep_id},
				dataType: "json",
				success: function (data) {

					if (data != null) {
						myAlert("Rencana sudah dievaluasi!");
						return false;
					} else {
						
						loadPasien(rencanaaskep_id);
                                                refreshRiwayatImplementasi(rencanaaskep_id);
						return true;
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
        
        function refreshRiwayatImplementasi(rencanaaskep_id){
            $.fn.yiiGridView.update('implementasi-t-grid', {
                data: {
                    "ASInfoimplementasiaskepV[rencanaaskep_id]":rencanaaskep_id,
                }
            });
        }
	
	function cekRencana(obj) {
		var rencanaaskep_id = $("#<?php echo CHtml::activeId($modRencana, 'rencanaaskep_id') ?>").val();
		var iskeperawatan = $("#<?php echo CHtml::activeId($modRencana, 'iskeperawatan') ?>").val();
		if (rencanaaskep_id == '') {
			myAlert("Silakan Pilih Rencana!");
		} else {
			window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/ImplementasiAskep/DetailRencana"); ?>/&rencanaaskep_id=" + rencanaaskep_id + "&iskeperawatan=" + iskeperawatan, "", 'location=_new, width=900px, scrollbars=1');
		}
		return false;

	}

	function loadPasien(rencanaaskep_id)
	{
		if (rencanaaskep_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadPasien'); ?>',
				data: {rencanaaskep_id: rencanaaskep_id},
				dataType: "json",
				success: function (data) {
					console.log(data);
					if (data !== '') {
						$("#ASRencanaaskepT_rencanaaskep_id").val(data.rencanaaskep_id);
						$("#ASRencanaaskepT_no_rencana").val(data.no_rencana);
						$("#ASRencanaaskepT_rencanaaskep_tgl").val(data.rencanaaskep_tgl);
						$("#ASRencanaaskepT_pegawai_id").val(data.pegawai_id);
						$("#ASRencanaaskepT_nama_pegawai").val(data.nama_pegawai);
						
						if(data.iskeperawatan == true){
							$("#ASRencanaaskepT_iskeperawatan").val(1);

						}else{
							$("#ASRencanaaskepT_iskeperawatan").val(0);
						}
						
						$('#ASInforencanaaskepV_no_pendaftaran').val(data.no_pendaftaran);
						$('#ASInforencanaaskepV_nama_pasien').val(data.nama_pasien);
						$('#ASInforencanaaskepV_ruangan_nama').val(data.ruangan_nama);
						$('#ASInforencanaaskepV_tgl_pendaftaran').val(data.tgl_pendaftaran);
						$('#ASInforencanaaskepV_umur').val(data.umur);
						$('#ASInforencanaaskepV_kelaspelayanan_nama').val(data.kelaspelayanan_nama);
						$('#ASInforencanaaskepV_no_rekam_medik').val(data.no_rekam_medik);
						$('#ASInforencanaaskepV_diagnosa_nama').val(data.diagnosa_nama);
						$('#ASInforencanaaskepV_no_kamarbed').val( ((data.kamarruangan_nokamar !== null) ? data.kamarruangan_nokamar : '-') + ' / ' + ((data.kamarruangan_nobed !== null) ? data.kamarruangan_nobed : '-'));
						loadRencanaDet(data.rencanaaskep_id);
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}

//	var trTindakan = new String(<?php // echo CJSON::encode($this->renderPartial($this->path_view . '_rowRencanaDetail', array('modDetail' => $modDetail), true)); ?>);
//	var trTindakanFirst = new String(<?php // echo CJSON::encode($this->renderPartial($this->path_view . '_rowRencanaDetail', array('modDetail' => $modDetail), true)); ?>);

	function renameInputImplementasi(obj_table, modPilih)
        {
            var row = 0;
            $('#table-rencana').find("tbody > .rencanaaskepdet").each(function () {
                $(this).find("#table-tindakannya").each(function () {
                    $(this).find("tbody").each(function () {
                        var row2 = 0;
                        var row3 = 0;

                        $(this).find('.impls').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 5) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                            }
                            row3++;

                        });

                        $(this).find('.impls_id').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 5) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                            }
                            row3++;

                        });

                        $(this).find('input[name$="[indikatorimplkepdet_id]"]').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 5) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                            }
                            row3++;
                        });

                        $(this).find('.implsdet').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 6) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + row2 + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + row2 + "][" + old_name_arr[4] + "][indikatorimplkepdet_id]");
                            }
                            if (modPilih != "") {
                                for (i = 0; i < modPilih[row].length; i++) {
                                    var tg_id = modPilih[row][i].indikatorimplkepdet_id;
                                    if (tg_id !== 'undefined') {
                                        var x = tg_id.split(',');
                                        for (j = 0; j < x.length; j++) {
                                            console.log(x[j]);
                                            if ($(this).val() == x[j]) {
                                                $(this).attr("checked", "checked");
                                            }
                                        }
                                    }
                                }
                            }
                            row2++;

                        });
                    });
                });
                row++;
            });
        }

	function renameInputImplementasi2(obj_table, modPilih){
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

                    if (modPilih != "") {
                        alert(modPilih[row].length);
                        for (i = 0; i < modPilih[row].length; i++) {
                            var tg_id = modPilih[row][i].indikatorimplkepdet_id;
                            if (tg_id !== 'undefined') {
                                if ($(this).val() == tg_id) {
                                    $(this).attr("checked", "checked");
                                }
                            }
                        }
                    }

                    row2++;
                });
                row++;
            });
        }
        
	function renameInputImplementasiSimpan(obj_table, modPilih)
        {
            var row = 0;
            $('#table-rencana').find("tbody > .rencanaaskepdet").each(function () {
                $(this).find("#table-tindakannya").each(function () {
                    $(this).find("tbody").each(function () {
                        var row2 = 0;
                        var row3 = 0;

                        $(this).find('.impls').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 5) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                            }
                            row3++;

                        });

                        $(this).find('.impls_id').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 5) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                            }
                            row3++;

                        });

                        $(this).find('input[name$="[indikatorimplkepdet_id]"]').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 5) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + old_name_arr[4] + "]");
                            }
                            row3++;
                        });
                        $(this).find('.implsdet').each(function () { //element <input>
                            var old_name = $(this).attr("name").replace(/]/g, "");
                            var old_name_arr = old_name.split("[");
                            if (old_name_arr.length == 6) {
                                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_" + old_name_arr[3] + "_" + row2 + "_" + old_name_arr[4]);
                                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "][" + old_name_arr[3] + "][" + row2 + "][" + old_name_arr[4] + "][indikatorimplkepdet_id]");
                            }
                            if (modPilih != "") {
                                for (i = 0; i < modPilih[row].length; i++) {
                                    var tg_id = modPilih[row][i].indikatorimplkepdet_id;
                                    if (tg_id !== 'undefined') {
                                        var x = tg_id.split(',');
                                        for (j = 0; j < x.length; j++) {
                                            console.log(x[j]);
                                            if ($(this).val() == x[j]) {
                                                $(this).attr("checked", "checked");
                                            }
                                        }
                                    }
                                }
                            }
                            
                            $(this).attr('readonly', 'readonly');
                            
                            row2++;
                        });
                    });
                });
                row++;
            });
        }
    
	function renameInputDiagDetail(obj_table, modPilih)
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
				if (modPilih != "") {
					for (i = 0; i < modPilih[row].length; i++) {
						var tg_id = modPilih[row][i].alternatifdx_id;
						if (tg_id !== 'undefined') {
							if ($(this).val() == tg_id) {
								$(this).attr("checked", "checked");
							}
						}
					}
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
				if (modPilih != "") {
					for (i = 0; i < modPilih[row].length; i++) {
						var tg_id = modPilih[row][i].alternatifdx_id;
						if (tg_id !== 'undefined') {
							if ($(this).val() == tg_id) {
								$(this).attr("checked", "checked");

							}
						}

					}
				}
				$(this).attr("readonly", true);
				row2++;
			});
			row++;
		});
	}

	function renameInputRow(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {
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
	}

	function renameInputRowSimpan(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > .rencanaaskepdet").each(function () {

			$(this).find('input,select,textarea').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
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
			});
			row++;
		});

	}

	function loadDetail(rencanaaskep_id) {
		$("#table-rencana").addClass("animation-loading");
		$('#table-rencana > tbody').html("");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetPenunjang'); ?>',
			data: {rencanaaskep_id: rencanaaskep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-rencana > tbody').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-rencana").removeClass("animation-loading");
				renameInputRow($("#rencana-penunjang"));
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});

	}
	function setDialog(obj) {
		parent = $(obj).parents(".input-append").find("input").attr("id");
		dialog = "#dialogDiagnosa";
		$(dialog).attr("parent-dialog", parent);
		$(dialog).dialog("open");
	}

	function setDiagnosaAuto(diagnosakep_id) {

		diagnosakep_id = diagnosakep_id;
		dialog = "#dialogDiagnosa";
		/*
		 if(idDlg != null)
		 {
		 dialog = idDlg;
		 }
		 */
		parent = $(dialog).attr("parent-dialog");
		obj = $("#" + parent);
		$.get('<?php echo Yii::app()->createUrl('asuhanKeperawatan/RencanaKeperawatan/getDiagnosa'); ?>', {diagnosakep_id: diagnosakep_id}, function (data) {
			$(obj).val(data[0].diagnosakep_id);
			$(obj).val(data[0].diagnosakep_nama);
			setDiagnosa(obj, data[0]);
		}, "json");
		$(dialog).dialog("close");

	}

	function setDiagnosa(obj, item)
	{
		$(obj).parents('tr').find('input[name$="[diagnosakep_id]"]').val(item.diagnosakep_id);
		$(obj).parents('tr').find('input[name$="[diagnosakep_nama]"]').val(item.diagnosakep_nama);

		setTandaGejala(obj, item.diagnosakep_id);
		setTujuan(obj, item.diagnosakep_id);
		setKriteriaHasil(obj, item.diagnosakep_id);
		setIntervensi(obj, item.diagnosakep_id);
	}

	function isDiagnosa() {
		var obj = $('#table-rencana > tbody > tr').find('input[name$="[isdiagnosa]"]');
		if ($(obj).is(':checked')) {
			$(obj).val(1);
		} else {
			$(obj).val(0);
		}
	}

	function cekListDiagnosa(obj) {
		if ($(obj).is(':checked')) {
			$(obj).val(1);
		} else {
			$(obj).val(0);
		}
	}

	function loadRencanaDet(rencanaaskep_id) {
		$("#table-rencana").addClass("animation-loading");
		$('#table-rencana > tbody').html("");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetRencanaDet'); ?>',
			data: {rencanaaskep_id: rencanaaskep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-rencana > tbody').html(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-rencana").removeClass("animation-loading");
				$("#ASRencanaaskepT_no_rencana").blur();
                                renameInputImplementasi('#table-rencana', data.modPilih);
				renameInputDiagDetail('#table-rencana', data.modPilih);
				renameInputRow($("#table-rencana"));

			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	function loadImplDet(implementasiaskep_id) {
		$("#table-rencana").addClass("animation-loading");
		$('#table-rencana > tbody').html("");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetImplDet'); ?>',
			data: {implementasiaskep_id: implementasiaskep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-rencana > tbody').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-rencana").removeClass("animation-loading");
				renameInputImplementasiSimpan('#table-rencana', data.modPilih);
				renameInputDiagDetailSimpan('#table-rencana', data.modPilih);
				renameInputRowSimpan($("#table-rencana"));

			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}

	$(document).ready(function () {
		isDiagnosa();
		renameInputRow('#table-rencana');
<?php if (!empty($model->implementasiaskep_id)) { ?>
			loadImplDet('<?php echo $model->implementasiaskep_id; ?>');
<?php } ?>
                
                 cekDisabled($('#pembayaran-form'));
            $('form').bind('click keyup select change', function(event) {
               cekDisabled(this);
            });
            $(document).on('click keyup select change','.ui-dialog-content',function(){
               cekDisabled('form');
            });
	});
</script>

<?php if (!empty($_GET['rencanaaskep_id'])) { ?>
    <script>  
        $(document).ready(function () {     
            cekRencanaId('<?php echo $_GET['rencanaaskep_id']; ?>');

            setTimeout(function(){
               $('#table-rencana').find('textarea').redactor({
                        toolbar : 'smini'

                     }); 
            },500);
	});
    </script>                  
<?php } ?>