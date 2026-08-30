<script type="text/javascript">
    const cetakRiwayat = () => {
        let rencanaaskep_id = $("#rencanaaskep_id").val();

        if (rencanaaskep_id == ''){
            toastr.error("Rencana Askep belum dipilih!","Perhatian!");
        }else{
            window.open("<?php echo $this->createUrl("cetakRiwayat"); ?>/&rencanaaskep_id=" + rencanaaskep_id+"&caraPrint=PRINT", "", 'location=_new, width=900px, scrollbars=1');
        }
    }
    
    const refreshRiwayatEvaluasi = (rencanaaskep_id) => {
   
        $.fn.yiiGridView.update('implementasi-t-grid', {
            data: {
                "ASInfoevaluasiaskepV[rencanaaskep_id]":rencanaaskep_id,
            }
        });
    }
	function cekImplementasiId(implementasiaskep_id) {
		if (implementasiaskep_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('cekImplementasiId'); ?>',
				data: {implementasiaskep_id: implementasiaskep_id},
				dataType: "json",
				success: function (data) {

					if (data['eval'] != null) {
						myAlert("Implementasi sudah dipilih!");
						return false;
					} else {
						loadPasien(implementasiaskep_id, data.rencanaaskep_id);
                                                $("#rencanaaskep_id").val(data.rencanaaskep_id);
						return true;
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	function cekImplementasi(obj) {
		var implementasiaskep_id = $("#ASImplementasiaskepT_implementasiaskep_id").val();
		var iskeperawatan = $("#ASImplementasiaskepT_iskeperawatan").val();
		if (implementasiaskep_id == '') {
			toastr.error("Pilih data impletementasi terlebih dahulu", 'Perhatian!');
		} else {
			window.open("<?php echo Yii::app()->controller->createUrl("/asuhanKeperawatan/EvaluasiAskep/DetailImpl"); ?>/&implementasiaskep_id=" + implementasiaskep_id + "&iskeperawatan=" + iskeperawatan, "", 'location=_new, width=900px, scrollbars=1');
		}
		return false;

	}

	function loadPasien(implementasiaskep_id, rencanaaskep_id)
	{
		if (implementasiaskep_id !== undefined) {
			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('loadPasien'); ?>',
				data: {implementasiaskep_id: implementasiaskep_id},
				dataType: "json",
				success: function (data) {
					if (data !== '') {
						$("#ASImplementasiaskepT_implementasiaskep_id").val(data.implementasiaskep_id);
						$("#ASImplementasiaskepT_no_implementasi").val(data.no_implementasi);
						$("#ASImplementasiaskepT_implementasiaskep_tgl").val(data.implementasiaskep_tgl);
						$("#ASImplementasiaskepT_pegawai_id").val(data.pegawai_id);
						$("#ASImplementasiaskepT_nama_pegawai").val(data.nama_pegawai);
											
						$('#ASInforencanaaskepV_no_pendaftaran').val(data.no_pendaftaran);
						$('#ASInforencanaaskepV_nama_pasien').val(data.nama_pasien);
						$('#ASInforencanaaskepV_ruangan_nama').val(data.ruangan_nama);
						$('#ASInforencanaaskepV_tgl_pendaftaran').val(data.tgl_pendaftaran);
						$('#ASInforencanaaskepV_umur').val(data.umur);
						$('#ASInforencanaaskepV_kelaspelayanan_nama').val(data.kelaspelayanan_nama);
						$('#ASInforencanaaskepV_no_rekam_medik').val(data.no_rekam_medik);
						$('#ASInforencanaaskepV_diagnosa_nama').val(data.diagnosa_nama);
						$('#ASInforencanaaskepV_no_kamarbed').val(((data.kamarruangan_nokamar !== null) ? data.kamarruangan_nokamar : '-') + ' / ' + ((data.kamarruangan_nobed !== null) ? data.kamarruangan_nobed : '-'));
						loadImplDet(implementasiaskep_id);
                                                refreshRiwayatEvaluasi(rencanaaskep_id);
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

	function renameInputImplementasi(obj_table)
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
				
				$(this).attr('readonly','readonly');

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
				$(this).attr('readonly','readonly');
			});
			$(this).find('input[name$="[isdiagnosa]"]').each(function () { //element <input>
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
					$(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
				}
				if ($(this).val() == 1){
					$(this).attr('checked','checked');
					$(this).attr('readonly','readonly');
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
                                $('#table-rencana > tbody > tr > td > .redactor').find('textarea').redactor({
                                    toolbar : 'smini'

                                 });
                                $('#table-rencana > tbody > tr').find('input[name$="[isdiagnosa]"]').prop('checked',true);
				$("#table-rencana").removeClass("animation-loading");
				renameInputImplementasiSimpan('#table-rencana', data.modPilih);
				renameInputRow($("#table-rencana"));

			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});
	}
	
	function loadEvDet(evaluasiaskep_id) {
		$("#table-rencana").addClass("animation-loading");
		$('#table-rencana > tbody').html("");
		$.ajax({
			type: 'GET',
			url: '<?php echo $this->createUrl('GetEvaluasiDet'); ?>',
			data: {evaluasiaskep_id: evaluasiaskep_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-rencana > tbody').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-rencana").removeClass("animation-loading");
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
<?php if (!empty($model->evaluasiaskep_id)) { ?>
        
                        
			loadEvDet('<?php echo $model->evaluasiaskep_id; ?>');
                        
                        setTimeout(function(){
                           $('#table-rencana').find('textarea').redactor({
                                    toolbar : 'smini'

                                 }); 
                                 refreshRiwayatEvaluasi(<?php echo $model->implementasiaskep->rencanaaskep_id; ?>);
                        },500);
                       
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

<?php if (!empty($_GET['implementasiaskep_id'])) { ?>
    <script>  
        $(document).ready(function () {     
            cekImplementasiId('<?php echo $_GET['implementasiaskep_id']; ?>');

            setTimeout(function(){
               $('#table-rencana').find('textarea').redactor({
                        toolbar : 'smini'

                     }); 
            },500);
	});
    </script>                  
<?php } ?>