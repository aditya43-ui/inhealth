<?php
/**
 * view yang digunakan untuk menyimpan fungsi - fungsi javascript
 * issue RSST-2812
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<script type="text/javascript">
/**
* untuk print hasil treadmill
 */
function print(caraPrint)
{
    var jantungkoroner_id = '<?php echo isset($modJantungKoroner->jantungkoroner_id) ? $modJantungKoroner->jantungkoroner_id : null ?>';
	var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&jantungkoroner_id='+jantungkoroner_id+'&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function setLevelTotKolesterol(){
	var total_kolesterol = $('#<?php echo CHtml::activeId($modJantungKoroner,'total_kolesterol'); ?>').val();
	var klasifikasiatp_jenis = "Cholesterol Total";
	if(total_kolesterol != ''){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetLevel'); ?>',
			data: { total: total_kolesterol, klasifikasiatp_jenis: klasifikasiatp_jenis},
			dataType: "json",
			success:function(data){
                            if (data.sukses == 1){
				$('#total_kolesterol').val(data.klasifikasiatp_nama);
				$("#<?php echo CHtml::activeId($modJantungKoroner,"total_kolesterol_level");?>").val(data.klasifikasiatp_level);
                            }else{
                                myAlert(data.pesan);
                            }
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
}

function setLevelTriglycerida(){
	var triglycerida = $('#<?php echo CHtml::activeId($modJantungKoroner,'triglycerida'); ?>').val();
	var klasifikasiatp_jenis = "Trigliserida";
	if(triglycerida != ''){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetLevel'); ?>',
			data: { total: triglycerida, klasifikasiatp_jenis: klasifikasiatp_jenis},
			dataType: "json",
			success:function(data){
                            if (data.sukses == 1){
				$('#triglyceride').val(data.klasifikasiatp_nama);
				$("#<?php echo CHtml::activeId($modJantungKoroner,"triglycerida_level");?>").val(data.klasifikasiatp_level);
                            }else{
                                myAlert(data.pesan);
                            }
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
}

function setLevelHdl(){
	var hdl_kolesterol = $('#<?php echo CHtml::activeId($modJantungKoroner,'hdl_kolesterol'); ?>').val();
	var klasifikasiatp_jenis = "Cholesterol HDL";
	if(hdl_kolesterol != ''){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetLevel'); ?>',
			data: { total: hdl_kolesterol, klasifikasiatp_jenis: klasifikasiatp_jenis},
			dataType: "json",
			success:function(data){
                            if (data.sukses == 1){
				$('#hdl_kolesterol').val(data.klasifikasiatp_nama);
				$("#<?php echo CHtml::activeId($modJantungKoroner,"hdl_kolesterol_level");?>").val(data.klasifikasiatp_level);
                            }else{
                                myAlert(data.pesan);
                            }
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
}

function setLevelLdl(){
	var ldl_kolesterol = $('#<?php echo CHtml::activeId($modJantungKoroner,'ldl_kolesterol'); ?>').val();
	var klasifikasiatp_jenis = "Cholesterol LDL";
	if(ldl_kolesterol != ''){
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('SetLevel'); ?>',
			data: { total: ldl_kolesterol, klasifikasiatp_jenis: klasifikasiatp_jenis},
			dataType: "json",
			success:function(data){
                            if (data.sukses == 1){
				$('#ldl_kolesterol').val(data.klasifikasiatp_nama);
				$("#<?php echo CHtml::activeId($modJantungKoroner,"ldl_kolesterol_level");?>").val(data.klasifikasiatp_level);
                            }else{
                                myAlert(data.pesan);
                            }
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
	}
}

function setLevelTekananDarah(){
	var tekanan_darah = $('#<?php echo CHtml::activeId($modJantungKoroner,'tekanandarah'); ?>').val();
	if(tekanan_darah != ''){
		if(tekanan_darah < 120){
			$('#tekanan_darah').val('< 120');
		}else if(tekanan_darah == 120 || tekanan_darah <= 129){
			$('#tekanan_darah').val('120 - 129');
		}else if(tekanan_darah == 130 || tekanan_darah <= 139){
			$('#tekanan_darah').val('130 - 139');
		}else if(tekanan_darah == 140 || tekanan_darah <= 149){
			$('#tekanan_darah').val('140 - 149');
		}else if(tekanan_darah == 150 || tekanan_darah <= 159){
			$('#tekanan_darah').val('150 - 159');
		}else if(tekanan_darah > 160){
			$('#tekanan_darah').val('> 160');
		}
	}
}

function checkFaktorB() {
    if ($("#ubah_b").is(":checked")) {
        $('#review_b input[name*="MCJantungkoronerT"]').each(function(){
           $(this).removeAttr('disabled');
        })
    } else {
       $('#review_b input[name*="MCJantungkoronerT"]').each(function(){
           $(this).attr('disabled',true);
        })
    }
    
} 

function checkFaktorMetabolisme() {
    if ($("#ubah_metabolisme").is(":checked")) {
        $('#gangguan_metabolisme input[name*="MCJantungkoronerT"]').each(function(){			
           $(this).removeAttr('disabled');
        })
    } else {
       $('#gangguan_metabolisme input[name*="MCJantungkoronerT"]').each(function(){
           $(this).attr('disabled',true);
        })
    }
    
}

function checkJumlahFaktorA() {
	if ($('#<?php echo CHtml::activeId($modJantungKoroner,'isriwayat_chd_a'); ?>').is(":checked") || $('#<?php echo CHtml::activeId($modJantungKoroner,'isresiko_chd_a'); ?>').is(":checked")) {
		var hasil_review = '<br>Review A:  CHD atau RESIKO CHD dalam 10 tahun = 20%. Nilai LDL yang diharapkan < 100 mg/dl. Nilai LDL yang diharuskan melakukan perubahan gaya hidup >= 100 mg/dl. Nilai LDL yang diharuskan untuk terapi menggunakan obat >= 130 mg/dl (100-129 mg/dl : dapat melakukan terapi)';		
		$("#<?php echo CHtml::activeId($modJantungKoroner,"hasil_review_ab");?>").append(hasil_review);
	}else{
		$("#<?php echo CHtml::activeId($modJantungKoroner,"hasil_review_ab");?>").html('');
		checkJumlahFaktorB();
	}
}

function checkJumlahFaktorB() {
	var jml = 0;
	$('#review_b input[name*="MCJantungkoronerT"]').each(function(){			
		if ($(this).is(":checked")) {
			jml++;
		}else{
			if($('#ubah_b').is(":checked")){
				if ($(this).is(":checked",false)) {
					jml--;
				}
			}
		}		
	})
		
	if(jml >= 2){
		var hasil_review = 'Review B: 2 atau lebih faktor yang sesuai, resiko dalam 10 tahun <= 20%. Nilai LDL yang diharapkan < 130 mg/dl. Nilai LDL yang diharuskan melakukan perubahan gaya hidup >= 130 mg/dl. Nilai LDL yang diharuskan untuk terapi menggunakan obat >= 160 mg/dl.';
		$("#<?php echo CHtml::activeId($modJantungKoroner,"hasil_review_ab");?>").append(hasil_review);
	}
	
	if(jml < 2){
		var hasil_review = '0-1 faktor yang sesuai. Nilai LDL yang diharapkan < 160 mg/dl. Nilai LDL yang diharuskan melakukan perubahan gaya hidup >= 160 mg/dl. Nilai LDL yang diharuskan untuk terapi menggunakan obat >= 190 mg/dl (160-189 : dapat menggunakan obat penurun LDL)';
		$("#<?php echo CHtml::activeId($modJantungKoroner,"hasil_review_ab");?>").append(hasil_review);
	}
	
	if(jml <= 0){
		$("#<?php echo CHtml::activeId($modJantungKoroner,"hasil_review_ab");?>").html('');
	}
	
}

function checkJumlahFaktorMetabolisme() {
	var jml = 0;
	
	$('#gangguan_metabolisme input[name*="MCJantungkoronerT"]').each(function(){			
		if ($(this).is(":checked")) {
			jml++;
		}else{
			if($('#ubah_metabolisme').is(":checked")){
				if ($(this).is(":checked",false)) {
					jml--;
				}
			}
		}
	});
	
	if(jml >= 3){
		var hasil_review = 'Pengobatan pokok dikarenakan overweight : melakukan manajemen berat badan dan memperbanyak aktivitas fisik. ';
		hasil_review += 'Melakukan pengobatan hipertensi. Melakukan pengobatan untuk CHD. Melakukan pengobatan kadar Triglyceride dan atau kadar HDL rendah.';
		$("#<?php echo CHtml::activeId($modJantungKoroner,"gangguan_metabolisme");?>").append(hasil_review);
	}
	if(jml < 3){
		$("#<?php echo CHtml::activeId($modJantungKoroner,"gangguan_metabolisme");?>").html('');
	}
}

function checkDataPasien(){
	var pasien_id = $('#<?php echo CHtml::activeId($modPasien,'pasien_id'); ?>').val();
	var no_rekam_medik = $('#<?php echo CHtml::activeId($modPasien,'no_rekam_medik'); ?>').val();
	var pendaftaran_id = '<?php echo $modPendaftaran->pendaftaran_id; ?>';
	
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetRiwayatPasien'); ?>',
        data: {pasien_id:pasien_id, no_rekam_medik:no_rekam_medik, pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
			if(data.status_merokok == 'Ya'){
				$('#ubah_b').attr('checked',true);
				checkFaktorB();
				$('#<?php echo CHtml::activeId($modJantungKoroner,'faktor_perokok_b'); ?>').attr('checked',true);
			}else{
				$('#ubah_b').removeAttr('checked',true);
				checkFaktorB();
				$('#<?php echo CHtml::activeId($modJantungKoroner,'faktor_perokok_b'); ?>').removeAttr('checked',true);
			}
			$("#status_merokok").val(data.status_merokok);
			
			if(data.umur == 'Ya'){
				$('#ubah_b').attr('checked',true);
				checkFaktorB();
				$('#<?php echo CHtml::activeId($modJantungKoroner,'faktor_umur_b'); ?>').attr('checked',true);
			}
			
			if(data.hipertensi == 'Ya'){
				$('#ubah_b').attr('checked',true);
				checkFaktorB();
				$('#<?php echo CHtml::activeId($modJantungKoroner,'faktor_hipertensi_b'); ?>').attr('checked',true);
			}
			
			if(data.gangguan_metabolisme_td == 'Ya'){
				$('#ubah_metabolisme').attr('checked',true);
				checkFaktorMetabolisme();
				$('#<?php echo CHtml::activeId($modJantungKoroner,'metabolisme_td'); ?>').attr('checked',true);
			}
			
			if(data.gangguan_metabolisme_abdominal == 'Ya'){
				$('#ubah_metabolisme').attr('checked',true);
				checkFaktorMetabolisme();
				$('#<?php echo CHtml::activeId($modJantungKoroner,'metabolisme_abdominal'); ?>').attr('checked',true);
			}
			$('#<?php echo CHtml::activeId($modJantungKoroner,'total_kolesterol'); ?>').val(data.total_kolesterol);
			$('#<?php echo CHtml::activeId($modJantungKoroner,'triglycerida'); ?>').val(data.triglceride);
			$('#<?php echo CHtml::activeId($modJantungKoroner,'hdl_kolesterol'); ?>').val(data.hdl_kolesterol);
			$('#<?php echo CHtml::activeId($modJantungKoroner,'ldl_kolesterol'); ?>').val(data.ldl_kolesterol);
			$('#<?php echo CHtml::activeId($modJantungKoroner,'tekanandarah'); ?>').val(data.td_systolic);
			
			$('#hdlpoints_point').val(data.hdlpoints_point);
			$('#umur_points').val(data.umur_points);
			$('#cholesterolpoints_point').val(data.cholesterolpoints_point);
			$('#smokerpoints_point').val(data.smokerpoints_point);
			$('#total_point').val(data.total_point);
			$('#pointtotalrisk').val(data.pointtotalrisk);
			$('#yearrisk_persen').val(data.yearrisk_persen);
			
			checkJumlahFaktorA();
			checkJumlahFaktorB();
			checkJumlahFaktorMetabolisme();
			setLevelTotKolesterol();
			setLevelTriglycerida();
			setLevelHdl();
			setLevelLdl();
			setLevelTekananDarah();
        },
        error: function (jqXHR, textStatus, errorThrown) { myAlert("Data Riwayat Pasien tidak ditemukan!"); $("#form-pasien > div").removeClass("animation-loading");}
    });
}

function hitungResiko(){
	var hdlpoints_point = $('#hdlpoints_point').val();
	var umur_points = $('#umur_points').val();
	var cholesterolpoints_point= $('#cholesterolpoints_point').val();
	var smokerpoints_point = $('#smokerpoints_point').val();
	var total_point = $('#total_point').val();
	var pointtotalrisk = $('#pointtotalrisk').val();
	var yearrisk_persen = $('#yearrisk_persen').val();
	
	$('#<?php echo CHtml::activeId($modJantungKoroner,'hasil_totalpoint'); ?>').val(total_point);
	$('#<?php echo CHtml::activeId($modJantungKoroner,'hasil_resiko_persen'); ?>').val(yearrisk_persen);
}
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */
$( document ).ready(function(){
	checkFaktorB();
	checkFaktorMetabolisme();
	checkDataPasien();
});
</script>