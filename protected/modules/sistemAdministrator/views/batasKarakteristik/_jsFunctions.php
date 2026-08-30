<script type="text/javascript">
	function setLookup(bataskarakteristik_id){
		$("#table-lookup").addClass("animation-loading");
		$('#table-lookup > tbody').html("");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('GetLookup'); ?>',
			data: {bataskarakteristik_id : bataskarakteristik_id},//
			dataType: "json",
			success:function(data){
				$('#table-lookup > tbody').append(data.form);
				jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				$(".integer").maskMoney(
			        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
			    );
				$("#table-lookup").removeClass("animation-loading");
				renameInputRow($("#table-lookup"));
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
		
	}

	function renameInputRow(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
                    $(this).attr('row-rincian', row);
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
		if(rowCount==1){
			$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
			$(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
			id = $(obj_table).find('tr:first-child input[name*="[lookup_id]"]').val();
			if(id!=""){
				$(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
			}
		}
		//====end button visibility

	}

	function hapusLookup(obj){
		var bataskarakteristikdet_id = $(obj).parents("tr").find("input[name$='[bataskarakteristikdet_id]']").val();
		if(bataskarakteristikdet_id !== ""){
			myConfirm("Apakah Anda yakin akan menghapus data ini?","Perhatian!",
			function(r){
				if(r){
					$(obj).parents('tr').detach();
					renameInputRow($("#table-lookup"));
					/*
					$.ajax({
						type:'POST',
						url:'<?php echo $this->createUrl('Delete'); ?>&id='+bataskarakteristikdet_id,
						data: {id : bataskarakteristikdet_id},//
						dataType: "json",
						success:function(data){
							if(data.sukses == 1){
								$(obj).parents('tr').detach();
								renameInputRow($("#table-lookup"));
							}
							myAlert(data.pesan);
							var rowCount = $("#table-lookup").find('tbody tr').length;
							if(rowCount==0){
								tambahLookup();
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
					});*/
				}
			});
		}else{
			$(obj).parents('tr').detach();
			renameInputRow($("#table-lookup"));
		}
	}

	function tambahLookup(){
		row = '<?php echo CJSON::encode($this->renderPartial($this->path_view. '_rowLookup',array('model'=>$modDetail),true));?>'
		$('#table-lookup').append(row);
		renameInputRow($("#table-lookup"));
                genExt();
		$("#table-lookup tr:last .integer").maskMoney(
	        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
	    );
	}
	
        function genExt() {
            $('.faktorpenyebab_daftar_nama').autocomplete({
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function (event, ui)
                {
                    $(this).val(ui.item.label);
                    return false;
                },
                'select': function (event, ui)
                {
                    setFaktorPenyebab(ui.item, this);
                    return false;
                },
                'source': function (request, response)
                {
                    $.ajax({
                        url: "<?php echo $this->createUrl('AutoCompleteFaktorPenyebab'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term,
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            });
        }

        function setFaktorPenyebab(data, obj){
            if (typeof $(obj).parents("tr").attr("row-rincian") === 'undefined'){
                var no = $("#norow").val();
            }else{
                var no = $(obj).parents("tr").attr("row-rincian");
            }

            $('#table-lookup > tbody > tr[row-rincian="'+no+'"]').find('.faktorpenyebab_daftar_id').val(data.faktorpenyebab_daftar_id);
            $('#table-lookup > tbody > tr[row-rincian="'+no+'"]').find('.faktorpenyebab_daftar_nama').val(data.faktorpenyebab_daftar_nama);

        }


        function setFaktorPenyebabdialog(id, nama, obj){
            if (typeof $(obj).parents("tr").attr("row-rincian") === 'undefined'){
                var no = $("#norow").val();
            }else{
                var no = $(obj).parents("tr").attr("row-rincian");
            }

            $('#table-lookup > tbody > tr[row-rincian="'+no+'"]').find('.faktorpenyebab_daftar_id').val(id);
            $('#table-lookup > tbody > tr[row-rincian="'+no+'"]').find('.faktorpenyebab_daftar_nama').val(nama);

        }
        
	function cek(obj) {
		if ($(obj).is(':checked')) {
			$(obj).parents("tr").find("input[name$='[bataskarakteristikdet_aktif]']").val(1);
		} else {
			$(obj).parents("tr").find("input[name$='[bataskarakteristikdet_aktif]']").val(0);
		}
	}

	function refreshTable() {
		var diagnosakep_id = $("#<?php echo CHtml::activeId($model, 'diagnosakep_id') ?>").val();
		var bataskarakteristik_nama = $("#<?php echo CHtml::activeId($model, 'bataskarakteristik_nama') ?>").val();

		if (diagnosakep_id !== '' && bataskarakteristik_nama !== '') {
			$('#table-lookup').addClass('animation-loading');

			$.ajax({
				type: 'GET',
				url: '<?php echo $this->createUrl('getLookup'); ?>',
				data: {diagnosakep_id: diagnosakep_id, bataskarakteristik_nama: bataskarakteristik_nama},
				dataType: "json",
				success: function (data) {
					$("#table-lookup > tbody").find('tr').detach();
					$("#table-lookup > tbody").append(data.form);
					$('#table-lookup').removeClass('animation-loading');
					renameInputRow($("#table-lookup"));
                                        genExt();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			});
		}
	}
	
        function setDialog(obj) {
            if (typeof $(obj).parents("tr").attr("row-rincian") === 'undefined'){
                var no = $("#norow").val();
            }else{
                var no = $(obj).parents("tr").attr("row-rincian");
            }
            var row = $("#norow").val(no);
            $("#dialogDaftarPenyebab").dialog("open");
        }
    
	$(document).ready(function(){
		tambahLookup();
		<?php if(!empty($model->bataskarakteristikdet_id)){ ?>
				setLookup('<?php echo $model->bataskarakteristik_id; ?>');
		<?php } ?>
			
		<?php if(!empty($model->bataskarakteristik_id)){ ?>
				refreshTable();
		<?php } ?>
		
	})


</script>