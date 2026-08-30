<script type="text/javascript">
/**
 * set form kunjungan
 * @param {type} pendaftaran_id
 * @returns {undefined}
 */
function setKunjungan(pendaftaran_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKunjungan'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
                $("#cari_nomorindukpegawai").val(data.nomorindukpegawai);
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#instalasi_id").val(data.instalasi_id);
                $("#ruanganakhir_id").val(data.ruangan_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#tglmasukrs").val(data.tgl_pendaftaran);
                $("#instalasi_nama").val(data.instalasi_nama);
                $("#ruangan_nama").val(data.ruangan_nama);
                $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
                $("#carabayar_nama").val(data.carabayar_nama);
                $("#penjamin_nama").val(data.penjamin_nama);
                $("#no_rekam_medik").val(data.no_rekam_medik);
                $("#namadepan").val(data.namadepan);
                $("#nama_pasien").val(data.nama_pasien);
                $("#nama_bin").val(data.nama_bin);
                $("#tanggal_lahir").val(data.tanggal_lahir);
                $("#umur").val(data.umur);
                $("#jeniskelamin").val(data.jeniskelamin);
                $("#nama_pj").val(data.nama_pj);
                $("#pengantar").val(data.pengantar);
                $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
                $("#alamat_pasien").val(data.alamat_pasien);
                $("#dokterpenanggungjawab_nama").val(data.dokterpenanggungjawab_nama);
                $("#pegawaipenanggung_nama").val(data.pegawaipenanggung_nama);
                $("#pegawaipenanggung_id").val(data.pegawaipenanggung_id);
                $("#tglpasienpulang").val(data.tglpasienpulang);
                $("#nama_pegawai").val(data.nama_pegawai);
                $("#tglmasukkamar").val(data.tglmasukkamar);
                $("#tglkeluarrs").val(data.tglpulang);
                $("#kamarruangan_nokamar").val(data.kamarruangan_nokamar);
				$("#pegawai_id").val(data.pegawai_id);
                if(data.photopasien === null || data.photopasien === ""){ //set photo
                    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                }else{
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
				
                $("#form-datakunjungan > legend > .judul").html('Data Kunjungan '+data.no_pendaftaran);
                $("#form-datakunjungan > legend > .tombol").attr('style','display:true;');
                $("#form-datakunjungan > .box").addClass("well").removeClass("box");
            }
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan!"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        }
    });
}

/**
 * set form resume keperawatan
 * @param {type} pendaftaran_id
 * @returns {undefined}
 */
function setResumeKeperawatan(pendaftaran_id){
    $("#form-datakunjungan > div").addClass("animation-loading");
	$("#form-dataresume > .box").addClass("well").removeClass("box");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataResumeKeperawatan'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
//            if(data.status == 'ada'){
//				
//			}else{
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'keluhansaatmasuk');?>').parent().find('iframe').contents().find('#page').html(data.keluhansaatmasuk); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'keluhansaatmasuk');?>').val(data.keluhansaatmasuk); 
				
                $("#resumeperawat_id").val(data.resumeperawat_id);
				
				$('#diagnosaawal').html(data.diagnosaawal_nama); 
				$('#diagnosautama').html(data.diagnosautama_nama); 
				$('#diagnosaawal_id').val(data.diagnosaawal_id); 
				$('#diagnosautama_id').val(data.diagnosautama_id); 
				
				if(data.diagnosasekunder1_id != ''){
					$('.diagnosatambahan').parents('.control-group').attr('hidden',false);
					$('#diagnosasekunder1_id').val(data.diagnosasekunder1_id); 
					$('#diagnosasekunder2_id').val(data.diagnosasekunder2_id); 
					$('#diagnosasekunder3_id').val(data.diagnosasekunder3_id); 
					$('#diagnosatambahan1').html(data.diagnosasekunder1_nama);
					$('#diagnosatambahan2').html(data.diagnosasekunder2_nama);
					$('#diagnosatambahan3').html(data.diagnosasekunder3_nama);
				}
				
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'diagkeprwtdiatasi');?>').parent().find('iframe').contents().find('#page').html(data.diagkeprwtdiatasi); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'diagkeprwtdiatasi');?>').val(data.diagkeprwtdiatasi); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'tindakankeprwatan');?>').parent().find('iframe').contents().find('#page').html(data.tindakankeprwatan); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'tindakankeprwatan');?>').val(data.tindakankeprwatan); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'diagkeprwtblmteratasi');?>').parent().find('iframe').contents().find('#page').html(data.diagkeprwtblmteratasi); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'diagkeprwtblmteratasi');?>').val(data.diagkeprwtblmteratasi); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasikperiksalab');?>').parent().find('iframe').contents().find('#page').html(data.hasikperiksalab); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasikperiksalab');?>').val(data.hasikperiksalab); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksarad');?>').parent().find('iframe').contents().find('#page').html(data.hasilperiksarad); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksarad');?>').val(data.hasilperiksarad); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksadiet');?>').parent().find('iframe').contents().find('#page').html(data.hasilperiksadiet); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksadiet');?>').val(data.hasilperiksadiet); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksarehabmedis');?>').parent().find('iframe').contents().find('#page').html(data.hasilperiksarehabmedis); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksarehabmedis');?>').val(data.hasilperiksarehabmedis); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksalainlain');?>').parent().find('iframe').contents().find('#page').html(data.hasilperiksalainlain); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksalainlain');?>').val(data.hasilperiksalainlain); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'keadaanumumkeluar');?>').parent().find('iframe').contents().find('#page').html(data.keadaanumumkeluar); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'keadaanumumkeluar');?>').val(data.keadaanumumkeluar); 
				
				
				$('#suhu_saatkeluar').val(data.suhu_saatkeluar); 
				$('#nadi_saatkeluar').val(data.nadi_saatkeluar); 
				$('#tensi_saatkeluar').val(data.tensi_saatkeluar); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'tglkontrol');?>').val(data.tglkontrol); 
				
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'terapilanjutan');?>').parent().find('iframe').contents().find('#page').html(data.terapilanjutan); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'terapilanjutan');?>').val(data.terapilanjutan); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_diit');?>').parent().find('iframe').contents().find('#page').html(data.nasehat_diit); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_diit');?>').val(data.nasehat_diit); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_mobilisasi');?>').parent().find('iframe').contents().find('#page').html(data.nasehat_mobilisasi); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_mobilisasi');?>').val(data.nasehat_mobilisasi); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_eliminasi');?>').parent().find('iframe').contents().find('#page').html(data.nasehat_eliminasi); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_eliminasi');?>').val(data.nasehat_eliminasi); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_kontrol');?>').parent().find('iframe').contents().find('#page').html(data.nasehat_kontrol); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_kontrol');?>').val(data.nasehat_kontrol); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'carakeluar');?>').parent().find('iframe').contents().find('#page').html(data.carakeluar); 
				$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'carakeluar');?>').val(data.carakeluar); 
//			}
			
			
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data Resume Keperawatan tidak ditemukan!"); 
            console.log(errorThrown);
            setKunjunganReset();
            $("#form-datakunjungan > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        }
    });
}

/**
 * untuk mereset form kunjungan
 * @returns {undefined} */
function setKunjunganReset(){
    $("#form-datakunjungan input,textarea").each(function(){
        $(this).val("");
    });
    $("#form-dataresume input,textarea").each(function(){
        $(this).val("");
    });
	
	$('.diagnosatambahan').parents('.control-group').attr('hidden',true);
	$('#diagnosaawal').html(''); 
	$('#diagnosautama').html(''); 
	$('#diagnosaawal_id').val(''); 
	$('#diagnosautama_id').val(''); 
	$('#diagnosasekunder1_id').val(''); 
	$('#diagnosasekunder2_id').val(''); 
	$('#diagnosasekunder3_id').val(''); 
	$('#diagnosatambahan1').html(''); 
	$('#diagnosatambahan2').html(''); 
	$('#diagnosatambahan3').html(''); 
	
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'keluhansaatmasuk');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'keluhansaatmasuk');?>').val(""); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'diagkeprwtdiatasi');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'diagkeprwtdiatasi');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'tindakankeprwatan');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'tindakankeprwatan');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'diagkeprwtblmteratasi');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'diagkeprwtblmteratasi');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasikperiksalab');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasikperiksalab');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksarad');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksarad');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksadiet');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksadiet');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksarehabmedis');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksarehabmedis');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksalainlain');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'hasilperiksalainlain');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'keadaanumumkeluar');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'keadaanumumkeluar');?>').val(''); 
	$('#suhu_saatkeluar').val(''); 
	$('#nadi_saatkeluar').val(''); 
	$('#tensi_saatkeluar').val(''); 
	$('#nafas_saatkeluar').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'terapilanjutan');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'terapilanjutan');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_diit');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_diit');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_mobilisasi');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_mobilisasi');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_eliminasi');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_eliminasi');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_kontrol');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'nasehat_kontrol');?>').val(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'carakeluar');?>').parent().find('iframe').contents().find('#page').html(''); 
	$('#<?php echo CHtml::activeId($modResumeKeperawatan, 'carakeluar');?>').val(''); 
	
	$("#form-datakunjungan > legend > .judul").html('Data Kunjungan');
	$("#form-datakunjungan > legend > .tombol").attr('style','display:none;');
	$("#form-datakunjungan > .well").addClass("box").removeClass("well");
	$("#form-dataresume > .well").addClass("box").removeClass("well");
}

function print()
{
	var pendaftaran_id =  $("#pendaftaran_id").val();
	if (pendaftaran_id!=null){
		window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
	}else{
		myAlert("Transaksi belum disimpan!");
	}
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
	setTimeout(function(){
	$("#no_pendaftaran").focus();
	}, 1000);
	<?php if(isset($_GET['pendaftaran_id'])){ ?>
		$('.diagnosatambahan').parents('.control-group').attr('hidden',false);
	<?php } ?>
});
</script>