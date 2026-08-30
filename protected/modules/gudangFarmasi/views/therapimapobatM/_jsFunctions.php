<script type="text/javascript">
	function pilihObatAlkes(obj){
		var obatalkes_id = $(obj).parents("tr").find("input[name$='[obatalkes_id]']").val();
		var therapiobat_id = $("#therapiobat_id").val();
		var tambahkandetail = true;
		var sudahada = false;
		
		if(obatalkes_id !== "" && therapiobat_id !== ""){
			$("#tablekelasterapi").addClass("animation-loading");
			$.ajax({
				type:'POST',
				url:'<?php echo $this->createUrl('SetFormTherapiMapObat'); ?>',
				data: {therapiobat_id : therapiobat_id, obatalkes_id : obatalkes_id},//
				dataType: "json",
				success:function(data){
					renameInputRow($("#tablekelasterapi"));
					$("#tablekelasterapi").removeClass("animation-loading");

					$("#tablekelasterapi").find("tbody > tr").each(function(){
						var obatalkesyangsama = $(this).find("input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
						var kelasterapiyangsama = $(this).find("input[name$='[therapiobat_id]'][value='"+therapiobat_id+"']");
						if((kelasterapiyangsama.val())&&(obatalkesyangsama.val())){
							sudahada = true;
						}
					});

					if(sudahada){ //jika ada kelas terapi sudah ada di table
						myAlert("Kelas terapi ini sudah ada!");
						renameInputRow($("#tablekelasterapi"));
						$("#tablekelasterapi").removeClass("animation-loading");  
						return false;
					}else{
						if(tambahkandetail){
							$('#tablekelasterapi > tbody').append(data.form);
							jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
							renameInputRow($("#tablekelasterapi"));
							$("#tablekelasterapi").removeClass("animation-loading");  
						}
					}		
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);$("#tablekelasterapi").removeClass("animation-loading");}
			});
		}else{
			myAlert("Silakan pilih terlebih dahulu kelas terapi!");
			$("#<?php echo CHtml::activeId($model, 'therapiobat_id') ?>").parent().parent().addClass("error");
		}
	}
	/**
 	 * menampilkan detail yang sudah pernah diinput
	 * @param {type} therapiobat_id
	 * @returns {undefined}	 */
	function setTherapiMapObat(therapiobat_id){
		$("#tablekelasterapi").addClass("animation-loading");
		$('#tablekelasterapi > tbody').html("");
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('GetTherapiMapObat'); ?>',
			data: {therapiobat_id : therapiobat_id},//
			dataType: "json",
			success:function(data){
				$('#tablekelasterapi > tbody').append(data.form);
				jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
				renameInputRow($("#tablekelasterapi"));
				$("#tablekelasterapi").removeClass("animation-loading");
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
		
	}
	function renameInputRow(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
			$(this).find("input[name$='[no_urut]']").val(row+1);
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
		var therapiobat_id = $(obj).parents("tr").find("input[name$='[therapiobat_id]']").val();
		var obatalkes_id = $(obj).parents("tr").find("input[name$='[obatalkes_id]']").val();
		var kosong = $(obj).parents("tr").find("input[name$='[kosong]']").val();
		
		if(kosong !== '1'){
			myConfirm("Apakah Anda yakin akan menghapus data ini dari database?","Perhatian!",
			function(r){
				if(r){
					$.ajax({
						type:'POST',
						url:'<?php echo $this->createUrl('Delete'); ?>&therapiobat_id='+therapiobat_id+'&obatalkes_id='+obatalkes_id,
						data: {therapiobat_id : therapiobat_id, obatalkes_id : obatalkes_id},//
						dataType: "json",
						success:function(data){
							if(data.sukses == 1){
								$(obj).parents('tr').detach();
								renameInputRow($("#tablekelasterapi"));
							}
							myAlert(data.pesan);
						},
						error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
					});
				}
			});
		}else{
			$(obj).parents('tr').detach();
			renameInputRow($("#tablekelasterapi"));
		}
	}
	$(document).ready(function(){
		<?php if(!empty($model->therapiobat_id)){ ?>
				setTherapiMapObat(<?php echo $model->therapiobat_id; ?>);
		<?php } ?>
	});
</script>