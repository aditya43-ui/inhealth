<script type="text/javascript">
	function pilihNilaiRujukan(obj, nilairujukan_id){
		// var nilairujukan_id = $(obj).parents("tr").find("input[name$='[nilairujukan_id]']").val();
		var pemeriksaanlab_id = $("#pemeriksaanlab_id").val();
		var pemeriksaanlabdet_id = $("#ubahpemeriksaanlabdet_id").val();
		
		if(nilairujukan_id !== "" && pemeriksaanlab_id !== ""){
			$("#table-pemeriksaanlabdet").addClass("animation-loading");
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('SetFormPemeriksaanLabDet'); ?>',
				data: {pemeriksaanlab_id : pemeriksaanlab_id, nilairujukan_id : nilairujukan_id, pemeriksaanlabdet_id:pemeriksaanlabdet_id},//Jika pemeriksaanlabdet_id ada = ubah
				dataType: "json",
				success:function(data){
					if(pemeriksaanlabdet_id !== ""){
						var tr_replace = $('#table-pemeriksaanlabdet > tbody').find("input[name$='[pemeriksaanlabdet_id]'][value='"+pemeriksaanlabdet_id+"']").parents('tr');
						tr_replace.replaceWith(data.form)
						$("#ubahpemeriksaanlabdet_id").val("");
						$('#table-pemeriksaanlabdet > tbody').find('tr').show();
					}else{
						$('#table-pemeriksaanlabdet > tbody').append(data.form);
					}
					jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
					renameInputRow($("#table-pemeriksaanlabdet"));
					$("#table-pemeriksaanlabdet").removeClass("animation-loading");
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);$("#table-pemeriksaanlabdet").removeClass("animation-loading");}
			});
			
		}else{
			myAlert("Silakan pilih terlebih dahulu pemeriksaan lab!");
			$("#<?php echo CHtml::activeId($model, 'pemeriksaanlab_id') ?>").parent().parent().addClass("error");
		}
	}
	/**
 	 * menampilkan detail yang sudah pernah diinput
	 * @param {type} pemeriksaanlab_id
	 * @returns {undefined}	 */
	function setPemeriksaanLabDet(pemeriksaanlab_id){
		$("#table-pemeriksaanlabdet").addClass("animation-loading");
		$('#table-pemeriksaanlabdet > tbody').html("");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('GetPemeriksaanLabDet'); ?>',
			data: {pemeriksaanlab_id : pemeriksaanlab_id},//
			dataType: "json",
			success:function(data){
				$('#table-pemeriksaanlabdet > tbody').append(data.form);
				jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				renameInputRow($("#table-pemeriksaanlabdet"));
				$("#table-pemeriksaanlabdet").removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
		
	}	
	function renameInputRow(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
			$(this).find("input[name$='[pemeriksaanlabdet_nourut]']").val(row+1);
			$(this).find('span').each(function(){ //element <input>
				var old_name = $(this).attr("name").replace(/]/g,"");
				var old_name_arr = old_name.split("[");
				if(old_name_arr.length == 3){
					$(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
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
	}
	function pindahKeAtas(obj){
		var row = $(obj).parents("tr:first");
		row.insertBefore(row.prev());
		renameInputRow($("#table-pemeriksaanlabdet"));
	}
	function pindahKeBawah(obj){
		var row = $(obj).parents("tr:first");
		row.insertAfter(row.next());
		renameInputRow($("#table-pemeriksaanlabdet"));
	}
	function hapusDetail(obj){
		var pemeriksaanlabdet_id = $(obj).parents("tr").find("input[name$='[pemeriksaanlabdet_id]']").val();
		if(pemeriksaanlabdet_id !== ""){
			myConfirm("Apakah Anda yakin akan menghapus data ini dari database?","Perhatian!",
			function(r){
				if(r){
					$.ajax({
						type:'POST',
						url:'<?php echo $this->createUrl('Delete'); ?>&id='+pemeriksaanlabdet_id,
						data: {id : pemeriksaanlabdet_id},//
						dataType: "json",
						success:function(data){
							if(data.sukses == 1){
								$(obj).parents('tr').detach();
								renameInputRow($("#table-pemeriksaanlabdet"));
							}
							myAlert(data.pesan);
						},
						error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
					});
				}
			});
		}else{
			$(obj).parents('tr').detach();
		}
	}
	function ubahNilaiRujukan(obj){
		myConfirm("Apakah Anda akan mengubah nilai rujukan ini?","Perhatian!",
			function(r){
				myAlert("Silakan pilih nilai rujukan baru!");
				var pemeriksaanlabdet_id = $(obj).parents('tr').find('input[name$="[pemeriksaanlabdet_id]"]').val();
				$("#ubahpemeriksaanlabdet_id").val(pemeriksaanlabdet_id);
				$(obj).parents('tbody').find('tr').hide();
				$(obj).parents('tr').show();
			});
	}
	$(document).ready(function(){
		<?php if(!empty($model->pemeriksaanlab_id)){ ?>
				setPemeriksaanLabDet(<?php echo $model->pemeriksaanlab_id; ?>);
		<?php } ?>
	});
</script>