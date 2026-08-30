<?php $modDetail->kriteriahasildet_aktif = 'aktif'; ?>
<script type="text/javascript">
        function setRow(obj) {
            var no = $(obj).parents("tr").attr('no-row');
            $("#norow").val(no);
        }
        
        function setDaftar(data, obj){            
            if (typeof $(obj).parents("tr").attr('no-row') === 'undefined') {
                var no = $("#norow").val();
            } else {
                var no = $(obj).parents("tr").attr('no-row');
            }

            $("#table-lookup").find('tbody > tr[no-row="' + no + '"]').find('.kriteriahasildet_indikator').val(data.kriteriahasil_daftar_nama);
            $("#table-lookup").find('tbody > tr[no-row="' + no + '"]').find('.kriteriahasil_daftar_id').val(data.kriteriahasil_daftar_id);
            
            $("#dialogDaftarHasil").dialog("close");
        }
    
        function clearDaftarHasil(obj){            
            $(obj).parents("tr").find('.kriteriahasil_daftar_id').val('');
        }
    
        function getExtAutoComplete() {

            $("#table-lookup").find('.kriteriahasildet_indikator').autocomplete(
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
                            setDaftar(ui.item, this);
                            return false;
                        },
                        'source': function (request, response)
                        {
                            $.ajax({
                                url: "<?php echo $this->createUrl('/ActionAutoComplete/GetDaftarKriteriaHasil'); ?>",
                                dataType: "json",
                                data: {
                                    term: request.term,                                    
                                },
                                success: function (data) {
                                    response(data);
                                }
                            });
                        }
                    }
            );


        }
    
	function setLookup(kriteriahasil_id) {
		$("#table-lookup").addClass("animation-loading");
		$('#table-lookup > tbody').html("");
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('GetLookup'); ?>',
			data: {kriteriahasil_id: kriteriahasil_id}, //
			dataType: "json",
			success: function (data) {
				$('#table-lookup > tbody').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				renameInputRow($("#table-lookup"));
                                getExtAutoComplete();
				$(".integer").maskMoney(
						{"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
				);
				$("#table-lookup").removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});

	}

	function renameInputRow(obj_table) {
		var row = 0;
		$(obj_table).find("tbody > tr").each(function () {
                        $(this).attr('no-row', row);
			$(this).find('span').each(function () { //element <input>
                            if (typeof $(this).attr("name") !== 'undefined'){
				var old_name = $(this).attr("name").replace(/]/g, "");
				var old_name_arr = old_name.split("[");
				if (old_name_arr.length == 3) {
					$(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
				}
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
			id = $(obj_table).find('tr:first-child input[name*="[lookup_id]"]').val();
			if (id != "") {
				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
			}
		}
		//====end button visibility

	}

	function hapusLookup(obj) {
		var kriteriahasildet_id = $(obj).parents("tr").find("input[name$='[kriteriahasildet_id]']").val();
		if (kriteriahasildet_id !== "") {
			myConfirm("Apakah Anda yakin akan menghapus data ini?", "Perhatian!",
					function (r) {
						if (r) {
							$(obj).parents('tr').detach();
							renameInputRow($("#table-lookup"));
                                                        getExtAutoComplete();
							/*
							$.ajax({
								type: 'POST',
								url: '<?php echo $this->createUrl('Delete'); ?>&id=' + kriteriahasildet_id,
								data: {id: kriteriahasildet_id}, //
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
							*/
						}
					});
		} else {
			$(obj).parents('tr').detach();
			renameInputRow($("#table-lookup"));
		}
	}

	function tambahLookup() {
		row = '<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowLookup', array('model' => $modDetail), true)); ?>'
		$('#table-lookup').append(row);
		renameInputRow($("#table-lookup"));
                getExtAutoComplete();
		$("#table-lookup tr:last .integer").maskMoney(
                    {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ".", "thousands": ",", "precision": 0}
		);
	}

	function cek(obj) {
		if ($(obj).is(':checked')) {
			$(obj).parents("tr").find("input[name$='[kriteriahasildet_aktif]']").val(1);
		} else {
			$(obj).parents("tr").find("input[name$='[kriteriahasildet_aktif]']").val(0);
		}
	}

	function refreshTable() {
		var luarankeperawatan_id = $("#<?php echo CHtml::activeId($model, 'luarankeperawatan_id') ?>").val();
		var kriteriahasil_nama = $("#<?php echo CHtml::activeId($model, 'kriteriahasil_nama') ?>").val();
                var rangekriteriahasil = $("#<?php echo CHtml::activeId($model, 'rangekriteriahasil') ?>").val();
                
		if (luarankeperawatan_id !== '' && kriteriahasil_nama !== '' && rangekriteriahasil !== '') {
			$('#table-lookup').addClass('animation-loading');

			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('getLookup'); ?>',
				data: {luarankeperawatan_id: luarankeperawatan_id, kriteriahasil_nama: kriteriahasil_nama, rangekriteriahasil:rangekriteriahasil},
				dataType: "json",
				success: function (data) {
					$("#table-lookup > tbody").find('tr').detach();
					$("#table-lookup > tbody").append(data.form);
					$('#table-lookup').removeClass('animation-loading');
					renameInputRow($("#table-lookup"));
                                        getExtAutoComplete();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}

	$(document).ready(function () {
		tambahLookup();
<?php if (!empty($model->kriteriahasildet_id)) { ?>
			setLookup('<?php echo $model->kriteriahasil_id; ?>');
<?php } ?>

<?php if (!empty($model->kriteriahasil_id)) { ?>
			refreshTable();
<?php } ?>
	})


</script>