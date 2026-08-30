<?php
/**
* - digunakan untuk menampung semua script javascript, agar mudah di tracing
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

?>
<script type="text/javascript">
/**
 * print status
 */


/**
 * - digunakan untuk memilih data triase
 * @param {type} obj
 * @returns {generate data ke hidden field}
 */
function pilihTriaseIni(obj){   
    var triase_id = $(obj).val();
    
    var rowtriase = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'form._formGetTriase',array('i'=>0,'modAsesTriDet'=>$modAsesTriDet,'form'>$form),true));?>';
    
    
    if($(obj).is(':checked')){        
        $("#tampung-triase").find('tbody').append(rowtriase);
        $("#tampung-triase").find('input[name$="[triase_id]"][value="#"]').val(triase_id);
        $("#tampung-triase").find('input[name$="[triase_id]"][value="#"]').attr('value',triase_id);
    }else{
        var delete_row = $("#tampung-triase").find('input[name$="[triase_id]"][value="'+triase_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRow($("#tampung-triase"),'triase');
}

/**
 * - digunakan untuk memilih data skala nyeri flaccs
 * @param {type} obj
 * @returns {generate data ke hidden field}
 */
function pilihNyeriFlaCcsIni(obj){   
    var skalanyeriflaccs_id = $(obj).val();
																														
    var rowflaccs = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'form._formGetNyeriFlaCcs',array('i'=>0,'modFlaCcs'=>$modFlaCcs,'form'>$form),true));?>';
    
    
    if($(obj).is(':checked')){        
        $("#tampung-flaccs").find('tbody').append(rowflaccs);
        $("#tampung-flaccs").find('input[name$="[skalanyeriflaccs_id]"][value="#"]').val(skalanyeriflaccs_id);
        $("#tampung-flaccs").find('input[name$="[skalanyeriflaccs_id]"][value="#"]').attr('value',skalanyeriflaccs_id);		
    }else{
        var delete_row = $("#tampung-flaccs").find('input[name$="[skalanyeriflaccs_id]"][value="'+skalanyeriflaccs_id+'"]').parents('tr');
        delete_row.detach();
    }
    renameInputRow($("#tampung-flaccs"),'flaccs');
}

/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table, get){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){                
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+get+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+get+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
    });
    
}

/**
 * - digunakan untuk menghitung total keseluruhan skor dan skor untuk rwayat jatuh
 * @param {type} obj
 * @returns {generate data ke field riwayatjatuh_skor} 
 **/
function hitRiwayatJatuh(obj){
    var penilaian = $(obj).val();
    
    if (penilaian == '<?php echo Params::JAWAB_YA ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'riwayatjatuh_skor') ?>").val(25);
    }else if (penilaian == '<?php echo Params::JAWAB_TIDAK ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'riwayatjatuh_skor') ?>").val(0);
    }
                
    totalSkor();
}

/**
 * - digunakan untuk menghitung total keseluruhan skor dan skor untuk diagnosa medis
 * @param {type} obj
 * @returns {generate data ke field riwayatjatuh_skor} 
 **/
function hitDiagnosisMedis(obj){
    var penilaian = $(obj).val();
    
    if (penilaian == '<?php echo Params::JAWAB_YA ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'diagnosismedis_skor') ?>").val(15);
    }else if (penilaian == '<?php echo Params::JAWAB_TIDAK ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'diagnosismedis_skor') ?>").val(0);
    }
                
    totalSkor();
}

/**
 * - digunakan untuk menghitung total keseluruhan skor dan skor untuk alat bantu
 * @param {type} obj
 * @returns {generate data ke field alatbantujalan_skor} 
 **/
function hitAlatBantu(obj){
    var penilaian = $(obj).val();
    
    if (penilaian == '<?php echo Params::ALAT_BANTU_1; ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'alatbantujalan_skor') ?>").val(0);
    }else if (penilaian == '<?php echo Params::ALAT_BANTU_2; ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'alatbantujalan_skor') ?>").val(15);
    }else if (penilaian == '<?php echo Params::ALAT_BANTU_3; ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'alatbantujalan_skor') ?>").val(30);
    }
                
    totalSkor();
}

/**
 * - digunakan untuk menghitung total keseluruhan skor dan skor untuk memakai terapi heparin
 * @param {type} obj
 * @returns {generate data ke field memakaiterapiheparin_skor} 
 **/
function hitHeparin(obj){
    var penilaian = $(obj).val();
    
     if (penilaian == '<?php echo Params::JAWAB_YA ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'memakaiterapiheparin_skor') ?>").val(20);
    }else if (penilaian == '<?php echo Params::JAWAB_TIDAK ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'memakaiterapiheparin_skor') ?>").val(0);
    }
                
    totalSkor();
}

/**
 * - digunakan untuk menghitung total keseluruhan skor dan skor untuk memakai terapi heparin
 * @param {type} obj
 * @returns {generate data ke field memakaiterapiheparin_skor} 
 **/
function hitCaraBerjalan(obj){
    var penilaian = $(obj).val();
    
    if (penilaian == '<?php echo Params::CARA_BERJALAN_1; ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'caraberjalan_skor') ?>").val(0);
    }else if (penilaian == '<?php echo Params::CARA_BERJALAN_2; ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'caraberjalan_skor') ?>").val(10);
    }else if (penilaian == '<?php echo Params::CARA_BERJALAN_3; ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'caraberjalan_skor') ?>").val(20);
    }
                
    totalSkor();
}

/**
 * - digunakan untuk menghitung total keseluruhan skor dan skor untuk memakai terapi heparin
 * @param {type} obj
 * @returns {generate data ke field memakaiterapiheparin_skor} 
 **/
function hitStatusMental(obj){
    var penilaian = $(obj).val();
    
    if (penilaian == '<?php echo Params::STATUS_MENTAL_1; ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'statusmental_skor') ?>").val(0);
    }else if (penilaian == '<?php echo Params::STATUS_MENTAL_2; ?>'){
        $("#<?php echo CHtml::activeId($modFisik, 'statusmental_skor') ?>").val(15);
    }
                
    totalSkor();
}

/**
* 

 * @returns {generate data ke field resikojatuh_skor} */
function totalSkor(){
    var tr = $("#resikoJatuh").find("tbody > tr");
    var total = 0;
    var resiko = '';
    var tindakan = '';
    tr.each(function(){
       var skor = parseInt($(this).find('.score').val());              
       
       total = total + skor;
    });
    
    $("#<?php echo CHtml::activeId($modFisik, 'resikojatuh_skor') ?>").val(total);
    
    if ( (total >= 0) && (total <= 24) ){
        resiko = '<?php echo Params::SKOR_RESIKO_JATUH_RESIKO_1; ?>';
        tindakan = '<?php echo Params::SKOR_RESIKO_JATUH_TINDAKAN_1 ?>';
    }else if ( (total >=25 ) && (total <= 50) ){
        resiko = '<?php echo Params::SKOR_RESIKO_JATUH_RESIKO_2; ?>';
        tindakan = '<?php echo Params::SKOR_RESIKO_JATUH_TINDAKAN_2 ?>';
    }else if ( (total >= 51)){
        resiko = '<?php echo Params::SKOR_RESIKO_JATUH_RESIKO_3; ?>';
        tindakan = '<?php echo Params::SKOR_RESIKO_JATUH_TINDAKAN_3 ?>';
    }
    
    $("#<?php echo CHtml::activeId($modFisik, '[0]resikojatuh_keterangan') ?>").val(resiko);
    $("#<?php echo CHtml::activeId($modFisik, '[1]resikojatuh_keterangan') ?>").val(tindakan);
    
}

/**
 * - digunakan untuk generate data, sesuai radio button nyeri yang dipilih
 * @param {type} obj
 * @returns {menyimpan data ke field skala_wongbaker_nrs}
 */
function getScalaNyeri(obj){
    var scala = $(obj).attr('value');
    
    $("#<?php echo CHtml::activeId($modFisik, 'skala_wongbaker_nrs') ?>").val(scala);
}

/**
 * - digunakan untuk menentukan, pilihan antara trauma atau non trauma
 * @param {type} obj
 * @returns {checklist}
 */
function cekTrauma(obj){
    var trauma = $("#<?php echo CHtml::activeId($modAsesTriase, 'trauma') ?>");
    var nontrauma = $("#<?php echo CHtml::activeId($modAsesTriase, 'nontrauma') ?>");
    var val = $(obj);    
        
    if (val.prop("checked")==true){                    
        if (val.attr('val') == 'trauma'){
            trauma.prop("checked",true);
            nontrauma.prop("checked",false);               
        }else if (val.attr('val') == 'nontrauma'){
            trauma.prop("checked",false);
            nontrauma.prop("checked",true);            
        }else{
            trauma.prop("checked",false);
            nontrauma.prop("checked",false);
        }
    }else{
        trauma.prop("checked",false);
        nontrauma.prop("checked",false);
    }                        
}

function addRow(obj)
{
	var trRencanaPelatihan = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'form._rowPetugasTriase',array('modTriPeg'=>$modTriPeg ,'form'=>$form,'removeButton'=>true,'i'=>0),true));?>);

	$("#petugas_triase > tbody > tr:last .tambahRow").attr('style','display:none;');
	$("#petugas_triase > tbody > tr:last .hapusRow").attr('style','display:true;');
        $(obj).parents('table').children('tbody').append(trRencanaPelatihan.replace());
	renameInput('#petugas_triase');   
}

function addRowDirectTable(obj)
{
	var id = $(obj).val();
	var val = $(obj).text();
	var trRencanaPelatihan = "	<tr>\n\
									<td>\n\
										<div class='control-group'>\n\
											<label class='control-label'></label>\n\
											<div class='controls'>\n\
												<input type='hidden' value='"+id+"' id='RDAsesmentriasepegT_0_pegawai_id' name='RDAsesmentriasepegT[0][pegawai_id]'>\n\
												<input type='text' value='"+val+"' readonly=true id='RDAsesmentriasepegT_0_nama_pegawai' name='RDAsesmentriasepegT[0][nama_pegawai]'>\n\
											</div>\n\
										</div>\n\
									</td>\n\
								</tr>";

	
        $('#petugas_triase').find('tbody').append(trRencanaPelatihan);
		renameInput('#petugas_triase');   
}

function hapusRow(obj){
	myConfirm('Apakah Anda akan membatalkan rencana pelatihan ini?','Perhatian!',
	function(r){
		if(r){
			$(obj).parents('tr').detach();	
			renameInput('#petugas_triase');
		}
	});
}

function hapusRowDirectTable(obj){
	
	var id = $(obj).val();
	var val = $(obj).text();
	
	var conf = confirm("Apakah Anda yakin akan menghapus petugas ini "+val+" ?");
	
	if(conf){			
		var delete_row = $("#petugas_triase").find('input[name$="[pegawai_id]"][value="'+id+'"]').parents('tr');
        delete_row.detach();
		renameInput('#petugas_triase');
	}else{
		return false;
	}
	
}

function renameInput(obj_table){
        var row = 0;	
	$(obj_table).find("tbody > tr").each(function(){
                        
            
           
            
            $(this).find("#no_urut").val(row+1);
            $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
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
            
            
            
            
            if ($(this).find('.id').val() == ''){
                if (row == 0){
                    $(this).find('.tambahRow').attr('style','display:block;');
                    $(this).find('.hapusRow').attr('style','display:none;');
                }else{
                    $(this).find('.tambahRow').attr('style','display:block;');
                    $(this).find('.hapusRow').attr('style','display:block;');
                }
            }else{
                $(this).find('.tambahRow').attr('style','display:block;');
                $(this).find('.hapusRow').attr('style','display:none;');		
            }
            
           
                        
            //if ()
        row++;
    });
    
}

var gcs = <?php echo RDGcsM::model()->listGCS(); ?>;

function hitungCGS(){
	var nilai = 0;
	
	var eye = $("input[name='RDAsesmentriaseT[gcs_eye]']:checked").val();
	var verbal = $("input[name='RDAsesmentriaseT[gcs_verbal]']:checked").val();
	var motorik = $("input[name='RDAsesmentriaseT[gcs_motorik]']:checked").val();

	if (typeof eye === "undefined"){
		eye = 0;
	}
	
	
	if (typeof verbal === "undefined"){
		verbal = 0;
	}
	
	if (typeof motorik === "undefined"){
		motorik = 0;
	}
	
	nilai = parseInt(eye) + parseInt(verbal) + parseInt(motorik);
	
	
	$.each(gcs, function(idx, val) {
		if (nilai >= val.gcs_nilaimin && nilai <= val.gcs_nilaimax) {
			$("#<?php echo CHtml::activeId($modAsesTriase, 'gcs_nama') ?>").val(val.gcs_nama);
			console.log("Nilai GCS", val.gcs_nama);
		}
	});
	
//	var nilainya = $('#RDAsesmentriaseT_gcs_nilai').val();
//	console.log(<?php // echo $keterangan = $modGcs->keterangan("nilai"); ?> );
	<?php
//	$ket = "nilai";
//	$keterangan = $modGcs->keterangan($ket);
//		$ket = RDGcsM::model()->keterangan();
//		echo "$('.hasilKeterangan').html(".$ket.")";
//	?>
//		console.log(<?php // echo $keterangan ; ?>);
//	$('.hasilKeterangan').html(nilainya);
	<?php
//		$namagcs = '<script>document.writeln(nilai);</script>';
		
//				exit();
//		$keterangan = $modGcs->keterangan();
	?>
	$("#<?php echo CHtml::activeId($modAsesTriase, 'gcs_nilai') ?>").val(nilai);
//	$("#<?php // echo CHtml::activeId($modAsesTriase, 'gcs_nama') ?>").val(gcs_nama);
}

/**
 * - digunalam umtuk menandakan status umur
 * @param {type} umur
 * @param {type} st
 * @returns {undefined}
 */
function cekUmur(umur, st){	
	var yes = $("#nyeriYes").prop("checked");
	
	if (yes){
		if (typeof st  === "undefined"){
			if (umur == '<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_1; ?>'){
				st = 'lebih';
			}else if (umur == '<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_2; ?>'){
				st = 'kurang';
			}
		}				
		
		var no = $("#<?php echo CHtml::activeId($modFisik, 'skala_wongbaker_nrs') ?>").val();
		
	
		if (st == 'lebih'){
			$(".umurlebih").addClass('borderradius');
			$(".umurkurang").removeClass('borderradius');
			$("#<?php echo CHtml::activeId($modFisik, 'skalanyeri_statusumur') ?>").val('<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_1; ?>');
			getNomor(no);			
		}else if (st == 'kurang'){
			$(".umurkurang").addClass('borderradius');
			$(".umurlebih").removeClass('borderradius');		
			$("#<?php echo CHtml::activeId($modFisik, 'skalanyeri_statusumur') ?>").val('<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_2; ?>');			
			getNyeriFlaccs(no);
		}
	}
}

function getSkala(obj){
	var no = $("#<?php echo CHtml::activeId($modFisik, 'skala_wongbaker_nrs') ?>").val();

	getNomor(no);
}

/**
* - digunakan untuk menandakan pilihan angka pada gambar nyeri
 * @param {type} no
 * @returns {undefined} */
function getNomor(no){
	var yes = $("#nyeriYes").prop("checked");
	
	if (yes){
            
                $("#RDPemeriksaanFisikT_skala_wongbaker_nrs").val(no);
            
		var umur =  $("#<?php echo CHtml::activeId($modFisik, 'skalanyeri_statusumur') ?>").val();

		$("[id^=nyerinomor_]").removeClass("borderradiusno");
		$("[id^=skalanyerirange_]").removeClass("borderradius");
		$("[id^=nyerilebih_]").removeClass("borderradius");

		if (umur == '<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_1 ?>'){				
			$("#nyerinomor_"+no).addClass("borderradiusno");

			$("[id^=nyerilebih_]").each(function(){
				var max = $(this).attr('max');
				var min = $(this).attr('min');

				if ( (no >= min) && (no <= max) ){
					$(this).addClass("borderradius");
				}
			});
		}else{
			$("#nyerinomor_"+no).addClass("borderradiusno");

			$("[id^=skalanyerirange_]").each(function(){
				var max = $(this).attr('max');
				var min = $(this).attr('min');

				if ( (no >= min) && (no <= max) ){
					$(this).addClass("borderradius");
				}
			});
		}
	}
}

/**
 * - digunakan untuk menandakan range nyeri pada
 * @param {type} no
 * @returns {undefined}
 */
function getNyeriFlaccs(no){
	var umur =  $("#<?php echo CHtml::activeId($modFisik, 'skalanyeri_statusumur') ?>").val();
	
	$("[id^=nyerinomor_]").removeClass("borderradiusno");
	$("[id^=skalanyerirange_]").removeClass("borderradius");
	$("[id^=nyerilebih_]").removeClass("borderradius");
	
	if (umur == '<?php echo Params::SKALA_NYERI_BERDASARKAN_UMUR_2 ?>'){		
		$("[id^=skalanyerirange_]").each(function(){
			var max = $(this).attr('max');
			var min = $(this).attr('min');
			
			if ( (no >= min) && (no <= max) ){
				$(this).addClass("borderradius");
			}
		});
	}
		
	
}

/**
 * -digunakan untuk engenerate data pegawai triase, agar tercek pada dropdown multiselect
 * @returns {undefined}
 */
function cekPegTriase(){
	
	
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('/ActionAjax/getPegTriase'); ?>',
        data: {id:<?php echo !empty($modAsesTriase->asesmentriase_id)?$modAsesTriase->asesmentriase_id:'000000'; ?>},
        dataType: "json",
        success:function(data){
			$.each(data.peg,function(key,val){
            setTimeout(function(){ 
                $('#getpegawaitriase').multiselect('select', val, true);            
            }, 1000); 
        });
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
	
}

function resetNyeri(obj){
	if ($(obj).prop('checked') == true){
		$("[id^=nyerinomor_]").removeClass("borderradiusno");
		$("[id^=skalanyerirange_]").removeClass("borderradius");
		$("[id^=nyerilebih_]").removeClass("borderradius");
		$(".umurlebih").removeClass("borderradius");
		$(".umurkurang").removeClass("borderradius");
	}
}

function resetSkala(obj){
	var umur = $("#<?php echo CHtml::activeId($modFisik, 'skalanyeri_statusumur') ?>").val();
	
	cekUmur(umur);
}

$(document).ready(function(){
	//totalSkor();    
	cekUmur('<?php echo $modFisik->skalanyeri_statusumur; ?>');      
  
     jQuery("#getpegawaitriase").multiselect({
            //includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
			onChange: function(element, checked) {				
				if (checked){
					addRowDirectTable(element);
				}else{
					hapusRowDirectTable(element);
				}
			},
    }).hide();	
     
	
	cekPegTriase();
	
});
</script>