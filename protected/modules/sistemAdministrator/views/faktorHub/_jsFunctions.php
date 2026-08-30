<script type="text/javascript">
	function setLookup(faktorhub_id) {
		$("#table-lookup").addClass("animation-loading");
		$('#table-lookup > tbody').html("");
		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('GetLookup'); ?>',
			data: {faktorhub_id: faktorhub_id}, //
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

	function renameInputRow(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
                    $(this).attr('no-row', row);
                    $(this).find('span').each(function(){ //element <input>
                        if (typeof $(this).attr("name") !== 'undefined'){
                            var old_name = $(this).attr("name").replace(/]/g,"");
                            var old_name_arr = old_name.split("[");
                            if(old_name_arr.length == 3){
                                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                            }
                        }
                    });
                    $(this).find('input,select,textarea').each(function(){ //element <input>
                            var old_name = $(this).attr("name").replace(/]/g,"");
                            var old_name_arr = old_name.split("[");
                            if(old_name_arr.length == 3){
                                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
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
		if(rowCount==1){
			$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
			$(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
			id = $(obj_table).find('tr:first-child input[name*="[lookup_id]"]').val();
			if(id!=""){
				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
			}
		}
		//====end button visibility

		$("#table-lookup tbody tr").each(function() {
			var faktorhubdet_id = $(this).find("input[name$='[faktorhubdet_id]']").val();
			if(faktorhubdet_id !== "") {
				$(this).find("td.rowbutton .icon-minus-sign").parent().hide();
			}
		});
	}

	function hapusLookup(obj) {
		var faktorhubdet_id = $(obj).parents("tr").find("input[name$='[faktorhubdet_id]']").val();
		if (faktorhubdet_id !== "") {
			myConfirm("Apakah Anda yakin akan menghapus data ini?", "Perhatian!",
					function (r) {
						if (r) {
							$(obj).parents('tr').detach();
							renameInputRow($("#table-lookup"));
							/*
							$.ajax({
								type: 'POST',
								url: '<?php echo $this->createUrl('Delete'); ?>&id=' + faktorhubdet_id,
								data: {id: faktorhubdet_id}, //
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
			$(obj).parents("tr").find("input[name$='[faktorhubdet_aktif]']").val(1);
		} else {
			$(obj).parents("tr").find("input[name$='[faktorhubdet_aktif]']").val(0);
		}
	}

	function refreshTable() {
		var diagnosakep_id = $("#<?php echo CHtml::activeId($model, 'diagnosakep_id') ?>").val();
		var faktorhub_nama = $("#<?php echo CHtml::activeId($model, 'faktorhub_nama') ?>").val();

		if (diagnosakep_id !== '' && faktorhub_nama !== '') {
			$('#table-lookup').addClass('animation-loading');

			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('getLookup'); ?>',
				data: {diagnosakep_id: diagnosakep_id, faktorhub_nama: faktorhub_nama},
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
		<?php if (!empty($model->faktorhubdet_id)) { ?>
			setLookup('<?php echo $model->faktorhub_id; ?>');
		<?php } ?>

		<?php if (!empty($model->faktorhub_id)) { ?>
			refreshTable();
		<?php } ?>
	})

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
            console.log(no);
            $("#table-lookup").find('tbody > tr[no-row="' + no + '"]').find('.faktorhubdet_indikator').val(data.faktorhub_daftar_nama);
            $("#table-lookup").find('tbody > tr[no-row="' + no + '"]').find('.faktorhub_daftar_id').val(data.faktorhub_daftar_id);
            
            $("#dialogDaftarTanda").dialog("close");
        }
        
        function clearDaftarHasil(obj){            
            $(obj).parents("tr").find('.faktorhub_daftar_id').val('');
        }
        
        function getExtAutoComplete() {
            $("#table-lookup").find('.faktorhubdet_indikator').autocomplete(
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
                        url: "<?php echo $this->createUrl('/ActionAutoComplete/GetDaftarKondisiKlinis'); ?>",
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
</script>