<script type="text/javascript">
	function getRuanganForCheckBox(obj){
		var instalasi_id = obj.value;
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('getRuanganForCheckBox'); ?>',
			data: {instalasi_id:instalasi_id},
			dataType: "json",
			success:function(data){
				$('#ruangan > #tabel-ruangan > tbody').html(data.form);
				$("#ruangan > #tabel-ruangan > tbody").find('.integer').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
					);
				$("#ruangan > #tabel-ruangan > tbody").find('.all-caps').keyup(function() {
					var allcaps = $(this).val().toUpperCase();
					$(this).val(allcaps);
					
					var searchTerm = $(this).parents('tr').find("input[name*='shiftygdiperbolehkan']").val();
					var pola = $(this).val();
					var originalPola = pola;
					var formasi = new RegExp("["+searchTerm+"]*","g");
					var formasi_new = new RegExp("[^"+searchTerm+"].*","g");
					pola = pola.replace(formasi, "");
					var msg = "Inputkan Pola berdasarkan Shift";
					
					if (pola != '') {
						originalPola = originalPola.replace(formasi_new, "")
						$(this).val(originalPola);
					}
				});
//				renameInput($("#tabel-ruangan")); 
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
	
	function checkSemua(obj){
		if($("#check_all").is(':checked')){
			 $("#tabel-ruangan tbody tr").find("input[name*='pilihruangan'][type='checkbox']").each(function(){
				 $(this).attr('checked',true);
			 });
		 }else{
			 $("#tabel-ruangan tbody tr").find("input[name*='pilihruangan'][type='checkbox']").each(function(){
				 $(this).removeAttr('checked');
			 });
		 } 
	 }
	function checkSemuaPegawai(obj){
		if($("#check_semua").is(':checked')){
			$("#tabel-penjadwalan tbody tr").find("input[name*='checklist'][type='checkbox']").each(function(){
				$(this).attr('checked',true);
			});
			//$("#tabel-penjadwalan tbody tr").find("select[name*='shift_id']").each(function(){				
			//	$(this).addClass('required');
			//});
		}else{
			$("#tabel-penjadwalan tbody tr").find("input[name*='checklist'][type='checkbox']").each(function(){
				$(this).removeAttr('checked');
			});
			//$("#tabel-penjadwalan tbody tr").find("select[name*='shift_id']").each(function(){
			//	$(this).removeClass('required error');
			//});
		} 
	}
	function setNolPegawai(obj){
		if($(obj).is(":checked")){
			obj.value = 1;
			//$(obj).parents("tr").find("select[name*='shift_id']").each(function(){
			//	$(this).addClass('required');
			//});
		}else{
			obj.value = 0;
			//$(obj).parents("tr").find("select[name*='shift_id']").each(function(){
			//	$(this).removeClass('required error');
			//});
		}
	}
	
	function getPenjadwalan(){
		
		$("#tabel-penjadwalan").addClass("animation-loading");
		var periodebuatjadwal = $('#<?php echo CHtml::activeId($model,'periodebuatjadwal'); ?>').val();
		var sampaidengan = $('#<?php echo CHtml::activeId($model,'sampaidengan'); ?>').val();
		var kelompokpegawai_id = $('#<?php echo CHtml::activeId($model,'kelompokpegawai_id'); ?>').val();
		var kelompokpegawai_nama = $('#<?php echo CHtml::activeId($model,'kelompokpegawai_id'); ?> option:selected').text();		
		var cekKelompok = 0;
		var instalasi_id = $('#<?php echo CHtml::activeId($model,'instalasi_id'); ?>').val();		
		var ruangan_id = $('#<?php echo CHtml::activeId($model,'ruangan_id'); ?>').val();		
		//var pegawai_id = $('#<?php //echo CHtml::activeId($model,'pegawai_id'); ?>').val();	//dari autocomplete	
		
		
		//alert(kelompokpegawai_id);
		
		//$('#tabel-ruangan tbody').find('tr').each(function(){
		//	var checklist = $(this).find('input[name*="pilihruangan"]');
		//	if(checklist.is(':checked')){
				//var ruangan_id = $(this).find('input[name*="[ruangan_id]"]').val();
				//var pola_shift = $(this).find('input[name*="[pola_shift]"]').val();
				//var jmlpegawais = [];
		//		var shift_kode = "";
		//		var i = 0;
				//$(this).find('input[name*="[jmlpegawai]"]').each(function(){
				//	shift_kode = $(this).parent().find('input[name*="[shift_kode]"]').val();
				//	jmlpegawais[i] = $(this).val();
				//	i ++;
				//});	
		if (kelompokpegawai_id != '' && instalasi_id != '' && ruangan_id != ''){
			
				$('#tabel-penjadwalan > tbody').each(function(){
					if ($(this).find('input[name*="kelompokpegawai_id"]').val() == kelompokpegawai_id){
						cekKelompok += 1;
					}
				});
				
				if (cekKelompok > 0){
					$("#tabel-penjadwalan").removeClass("animation-loading");
					myAlert(" Data pegawai dengan kelompok pegawai "+kelompokpegawai_nama+" sudah ditambahkan.","Perhatian");
					return false;
				}
			
				$.ajax({
					type:'POST',
					url:'<?php echo $this->createUrl('getPenjadwalan'); ?>',
					data: {
						periodepenjadwalan:periodebuatjadwal, 
						sampaidengan:sampaidengan, 
						kelompokpegawai_id:kelompokpegawai_id, 
						instalasi_id:instalasi_id,
						ruangan_id:ruangan_id, 
						//pola_shift:pola_shift, 
						//jmlpegawais:jmlpegawais,
						//pegawai_id:pegawai_id,
					},
					dataType: "json",
					success:function(data){
						
						if (data.form != ''){
							$("#tabel-penjadwalan").removeClass("animation-loading");
//							$('#tabel-penjadwalan > tbody').append(data.form); //RSPMC-984
                                                        $('#tabel-penjadwalan > tbody').html(data.form);
							$('#tabel-penjadwalan > thead #bulan').removeAttr('rowspan','2');
							$('#tabel-penjadwalan > thead #bulan').attr('colspan',(data.jumlah_hari+1));
							$('#tabel-penjadwalan > thead #bulan-tgl').html(data.kolom_tanggal);						
							renameInput($("#tabel-penjadwalan")); 
						}else{
							myAlert("Data tidak ditemukan.");
							$("#tabel-penjadwalan").removeClass("animation-loading");
						}
						
					},
					error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
				});
		}else{
			$("#tabel-penjadwalan").removeClass("animation-loading");
			myAlert(" Kelompok Pegawai, Instalasi dan Ruangan harus diisi, untuk melanjutkan proses ini ");
			return false;
		}
		//	}
		//});
	}
	
	/**
	* rename input grid
	*/ 
	function renameInput(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
			$(this).find('input,select,textarea').each(function(){ //element <input>
				var old_name = $(this).attr("name").replace(/]/g,"");
				var old_name_arr = old_name.split("[");
				if(old_name_arr.length == 3){
					$(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
					$(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
				}
			});
			
			//RenameInputShift
			var row_3 = 0;
			$(this).find('select[name*="shift_id"]').parent('td').each(function(){ //element <input>
				var select	= $(this).find('select[name*="shift_id"]');
				var input	= $(this).find('input[name*="tgljadwalpegawai"]');
				
				var old_name_input = input.attr("name").replace(/]/g,"");
				var old_name_input_arr = old_name_input.split("[");
				
				var old_name_select = select.attr("name").replace(/]/g,"");
				var old_name_select_arr = old_name_select.split("[");
				if(old_name_select_arr.length == 5){
					select.attr("id",old_name_select_arr[0]+"_"+row+"_"+old_name_select_arr[2]+"_"+row_3+"_"+old_name_select_arr[4]);
					select.attr("name",old_name_select_arr[0]+"["+row+"]["+old_name_select_arr[2]+"]["+row_3+"]["+old_name_select_arr[4]+"]");
				}
				if(old_name_input_arr.length == 5){
					input.attr("id",old_name_input_arr[0]+"_"+row+"_"+old_name_input_arr[2]+"_"+row_3+"_"+old_name_input_arr[4]);
					input.attr("name",old_name_input_arr[0]+"["+row+"]["+old_name_input_arr[2]+"]["+row_3+"]["+old_name_input_arr[4]+"]");
				}
				row_3++;
			});
			
			//Rename Jam Kerja
			/*var row_3 = 0;
			$(this).find('select[name*="shift_id"]').parent('td').each(function(){ //element <input>
				var select	= $(this).find('input[name*="jamkerjamasuk"]');
				var input	= $(this).find('input[name*="jamkerjapulang"]');
				
				var old_name_input = input.attr("name").replace(/]/g,"");
				var old_name_input_arr = old_name_input.split("[");
				
				var old_name_select = select.attr("name").replace(/]/g,"");
				var old_name_select_arr = old_name_select.split("[");
				if(old_name_select_arr.length == 5){
					select.attr("id",old_name_select_arr[0]+"_"+row+"_"+old_name_select_arr[2]+"_"+row_3+"_"+old_name_select_arr[4]);
					select.attr("name",old_name_select_arr[0]+"["+row+"]["+old_name_select_arr[2]+"]["+row_3+"]["+old_name_select_arr[4]+"]");
				}
				if(old_name_input_arr.length == 5){
					input.attr("id",old_name_input_arr[0]+"_"+row+"_"+old_name_input_arr[2]+"_"+row_3+"_"+old_name_input_arr[4]);
					input.attr("name",old_name_input_arr[0]+"["+row+"]["+old_name_input_arr[2]+"]["+row_3+"]["+old_name_input_arr[4]+"]");
				}
				row_3++;
			});*/
			
			row++;
		});
	}
	
	function getShiftJam(obj){
		var id = $(obj).find("option:selected").val();
		var shift = $(obj).find("option:selected").text();
		var timpa = shift.replace(/\)/g,"");
																	
		if (id != ''){
			var splitdata = timpa.split("(");

			var splitjam = splitdata[1].split(" - ");

			var jamkerjamasuk = splitjam[0];
			var jamkerjapulang = splitjam[1];
			
			$(obj).parents("td").find('input[name*="jamkerjamasuk"]').val(jamkerjamasuk);
			$(obj).parents("td").find('input[name*="jamkerjapulang"]').val(jamkerjapulang);
		}else{
			$(obj).parents("td").find('input[name*="jamkerjamasuk"]').val('');
			$(obj).parents("td").find('input[name*="jamkerjapulang"]').val('');
		}
	}
	
	function cekJadwal(){
		var awal = $("#<?php echo CHtml::activeId($model, 'periodebuatjadwal') ?>").val();
		var akhir = $("#<?php echo CHtml::activeId($model, 'sampaidengan') ?>").val();
		
		var awaltemp = $("#<?php echo CHtml::activeId($model, 'tglawaltemp') ?>").val();
		var akhirtemp = $("#<?php echo CHtml::activeId($model, 'tglakhirtemp') ?>").val();
						
		var tr = $('#tabel-penjadwalan > tbody > tr');
		
		if (tr.length > 0){
			if (awal != awaltemp){
				myConfirm(" Apakah Anda yakin akan menghapus data pada tabel penjadwalan, karena ada perubahan tanggal yang berbeda dengan sebelumnya ? ","Perhatian !",function(r){
					if (r){
						$('#tabel-penjadwalan > tbody').html('');
						$('#tabel-penjadwalan > thead > #bulan-tgl').html('');						
					}else{
						$("#<?php echo CHtml::activeId($model, 'periodebuatjadwal') ?>").val(awaltemp);
						$("#<?php echo CHtml::activeId($model, 'sampaidengan') ?>").val(akhirtemp);
					}
				});
				
				return false;
			}
			
			if (akhir != akhirtemp){
				myConfirm(" Apakah Anda yakin akan menghapus data pada tabel penjadwalan, karena ada perubahan tanggal yang berbeda dengan sebelumnya ? ","Perhatian !",function(r){
					if (r){
						$('#tabel-penjadwalan > tbody').html('');
						$('#tabel-penjadwalan > thead > #bulan-tgl').html('');
					}else{
						$("#<?php echo CHtml::activeId($model, 'periodebuatjadwal') ?>").val(awaltemp);
						$("#<?php echo CHtml::activeId($model, 'sampaidengan') ?>").val(akhirtemp);
					}
				});
				
				return false;
			}
		}
	}
	 
	 
	function cekValidasi(){
		if(requiredCheck($("#kppenjadwalan-t-form"))){
			var jadwal = $('#tabel-penjadwalan tbody tr').length;
			var cekShift = 0;
			
			$('#tabel-penjadwalan > tbody > tr').each(function(){
				//alert($(this).val());
				$(this).find('select[name*="shift_id"]').each(function(){
					if ($(this).val() != ''){						
						cekShift++;
					}
				});
			});
			
			if (cekShift < 1){
				myAlert('Shift untuk jadwal pegawai belum diset !');
				return false;
			}
			
			if(jadwal <= 0){
					myAlert('Jadwal pegawai belum diset !');
					return false;
			}else{
				$('#kppenjadwalan-t-form').submit();
			}
		}
		return false;
	}
        
$(document).ready(function(){
    <?php 
        if(isset($_GET['sukses'])){
            if($_GET['sukses']==1){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_KEPEGAWAIAN; ?>, judulnotifikasi:'Penjadwalan Pegawai', isinotifikasi:'Penjadwalan pegawai sudah dibuat dengan No. <?php echo $model->no_pembuatanjadwal; ?>, pada tanggal: <?php echo MyFormatter::formatDateTimeForUser($model->tglbuatjadwal); ?>'}; 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
            
});
</script>