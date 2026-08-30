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
                $("#pendaftaran_id").val(data.pendaftaran_id);
                $("#pasien_id").val(data.pasien_id);
                $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
                $("#carabayar_id").val(data.carabayar_id);
                $("#penjamin_id").val(data.penjamin_id);
                $("#penanggungjawab_id").val(data.penanggungjawab_id);
                $("#instalasi_id").val(data.instalasi_id);
                $("#ruangan_id").val(data.ruangan_id);
                $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
                $("#no_pendaftaran").val(data.no_pendaftaran);
                $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
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
                if(data.photopasien === null || data.photopasien === ""){ //set photo
                    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
                }else{
                    $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
                }
				
                $("#judul-form-datakunjungan  > .judul").html('<b>Data Kunjungan</b> "'+data.no_pendaftaran+'" ');
                $("#judul-form-datakunjungan > .tombol").attr('style','display:true;');                
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
 * set form resume
 * @param {type} pendaftaran_id
 * @returns {undefined}
 */
function setResume(pendaftaran_id){
    $("#form-dataresume > div").addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataIkhisar'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
				$('#<?php echo CHtml::activeId($modResume, 'ikhtisarkliniksingkat');?>').parent().find('iframe').contents().find('#page').html(data.ikhtisar); 
				$('#<?php echo CHtml::activeId($modResume, 'ikhtisarkliniksingkat');?>').val(data.ikhtisar); 
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });
	
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataDiagnosisKelainan'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
				$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanfisik');?>').parent().find('iframe').contents().find('#page').html(data.fisik); 
				$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanfisik');?>').val(data.fisik); 
				$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanlab');?>').parent().find('iframe').contents().find('#page').html(data.lab); 
				$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanlab');?>').val(data.lab); 
				$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanrad');?>').parent().find('iframe').contents().find('#page').html(data.radiologi); 
				$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanrad');?>').val(data.radiologi); 
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });
	
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataDiagnosisSementara'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
				$('#diagnosasementara-label').val(data.diagnosaawal);
				$('#diagnosaawal_id').val(data.diagnosaid); 
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });
	
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataDiagnosisAkhir'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
				$('#diagnosautama-label').val(data.diagnosautama);
				$('#diagnosautama_id').val(data.diagnosautamaid); 
				$('#diagnosasekunder1_id').val(data.diagnosasekunderid1); 
				$('#diagnosasekunder2_id').val(data.diagnosasekunderid2); 
				$('#diagnosasekunder3_id').val(data.diagnosasekunderid3);
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });
	
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataObatSementara'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
				$('#<?php echo CHtml::activeId($modResume, 'terapiperawatan');?>').parent().find('iframe').contents().find('#page').html(data.terapiperawatan); 
				$('#<?php echo CHtml::activeId($modResume, 'terapiperawatan');?>').val(data.terapiperawatan); 
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });
	
	$.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataObatPulang'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
				$('#<?php echo CHtml::activeId($modResume, 'terapisaatpulang');?>').parent().find('iframe').contents().find('#page').html(data.terapisaatpulang); 
				$('#<?php echo CHtml::activeId($modResume, 'terapisaatpulang');?>').val(data.terapisaatpulang); 
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });
    
    //riwayat operasi
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataRiwayatOperasi'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
		$('#<?php echo CHtml::activeId($modResume, 'riwayatoperasi');?>').parent().find('iframe').contents().find('#page').html(data.riwayatoperasi); 
		$('#<?php echo CHtml::activeId($modResume, 'riwayatoperasi');?>').val(data.riwayatoperasi); 
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });
    
    //Cara Keluar
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataCaraKeluar'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
		$('#<?php echo CHtml::activeId($modResume, 'carakeluar');?>').parent().find('iframe').contents().find('#page').html(data.carakeluar); 
		$('#<?php echo CHtml::activeId($modResume, 'carakeluar');?>').val(data.carakeluar); 
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });
    
    //keadaan /kondisi keluar
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataKondisiPulang'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
		$('#<?php echo CHtml::activeId($modResume, 'kondisipulang');?>').parent().find('iframe').contents().find('#page').html(data.kondisipulang); 
		$('#<?php echo CHtml::activeId($modResume, 'kondisipulang');?>').val(data.kondisipulang); 
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });
    
    //Saran/Instruksi untuk tindak lanjut
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataTindakLanjut'); ?>',
        data: {pendaftaran_id:pendaftaran_id},
        dataType: "json",
        success:function(data){
            if(data.pesan != ""){
                myAlert(data.pesan);
                setKunjunganReset();
            }else{
		$('#<?php echo CHtml::activeId($modResume, 'saran_resume');?>').parent().find('iframe').contents().find('#page').html(data.saran_resume); 
		$('#<?php echo CHtml::activeId($modResume, 'saran_resume');?>').val(data.saran_resume); 
            }
            $("#form-dataresume > div").removeClass("animation-loading");
            $("#no_pendaftaran").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
            $("#form-dataresume > div").removeClass("animation-loading");
        }
    });

}

function loadDiagnosa(){
	var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id'])?$_GET['pendaftaran_id']:''; ?>';
	if(pendaftaran_id != ''){
		var diagnosa_awal = '<?= empty($dataDiagnosa['diagnosaawal']) ? "" : $dataDiagnosa['diagnosaawal']; ?>';
		var diagnosa_akhir = '<?= empty($dataDiagnosa['diagnosautama']) ? "" : $dataDiagnosa['diagnosautama']; ?>';
		$('#diagnosasementara-label').val(diagnosa_awal);
		$('#diagnosautama-label').val(diagnosa_akhir);
	}
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
	$('#<?php echo CHtml::activeId($modResume, 'ikhtisarkliniksingkat');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResume, 'ikhtisarkliniksingkat');?>').val(""); 
	$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanfisik');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanfisik');?>').val(""); 
	$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanlab');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanlab');?>').val(""); 
	$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanrad');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResume, 'resume_pemeriksaanrad');?>').val(""); 
	$('#<?php echo CHtml::activeId($modResume, 'terapiperawatan');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResume, 'terapiperawatan');?>').val(""); 
	$('#<?php echo CHtml::activeId($modResume, 'terapisaatpulang');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResume, 'terapisaatpulang');?>').val("");
        $('#<?php echo CHtml::activeId($modResume, 'riwayatoperasi');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResume, 'riwayatoperasi');?>').val("");
        $('#<?php echo CHtml::activeId($modResume, 'carakeluar');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResume, 'carakeluar');?>').val("");
        $('#<?php echo CHtml::activeId($modResume, 'kondisipulang');?>').parent().find('iframe').contents().find('#page').html(""); 
	$('#<?php echo CHtml::activeId($modResume, 'kondisipulang');?>').val("");
	
    $("#ruangan_id").val(<?php echo $modKunjungan->ruangan_id; ?>);
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
	$("#judul-form-datakunjungan > .judul").html("<b>Data Kunjungan</b>");
	$("#judul-form-datakunjungan > .tombol").attr("style","display:none;");
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

function printResume()
{
	var pendaftaran_id =  $("#pendaftaran_id").val();
	if (pendaftaran_id!=null){
		window.open('<?php echo $this->createUrl('printResumePasien'); ?>&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=480,height=640');
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
		loadDiagnosa();
	<?php } ?>
});
</script>