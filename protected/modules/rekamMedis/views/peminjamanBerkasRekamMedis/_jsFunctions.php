<script type="text/javascript">
/**
 * set nilai umur dari tanggal_lahir 
 * @param {type} tanggal_lahir
 * @returns {undefined} */
function setUmur(tanggal_lahir)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetUmur'); ?>',
       data: {tanggal_lahir : tanggal_lahir},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($model,"umur");?>").val(data.umur);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}

function cekInputan(){
	if(requiredCheck($("form"))){
		var kosong=0;
		var jumlah=0;

		$('.cekList').each(function(){
			if ($(this).is(':checked')){
				var warnadokumen = $(this).parents("tr").find('select[name*="[warnadokrm_id]"]').val();
				if(warnadokumen == ''){
					kosong++;
				}
				jumlah++;
			}            
		});

		if(kosong > 0 || jumlah < 1){
			if(jumlah < 1){
				myAlert('Silakan pilih dokumen terlebih dahulu!');
				return false;
			}else{
				myAlert('Isi Warna Dokumen Rekam Medis');
				return false;
			}				
		}else{
			$('#rkpengirimanrm-t-form').submit();
		}

		$(".animation-loading").removeClass("animation-loading");
		$("form").find('.float').each(function(){
			$(this).val(formatFloat($(this).val()));
		});
		$("form").find('.integer').each(function(){
			$(this).val(formatInteger($(this).val()));
		});			
	}
	return false;
}
	
function print()
{    
	var peminjamanrm_id = $('#<?php echo CHtml::activeId($model,'peminjamanrm_id'); ?>').val();        
	var pasien_id = $('#<?php echo CHtml::activeId($model,'pasien_id'); ?>').val();        
	if (pasien_id == ''){
		myAlert('Isi Data Pasien yang akan d print');
		return false;
	}
	window.open('<?php echo $this->createUrl('printPeminjaman'); ?>/id/'+peminjamanrm_id+'','printwin','left=100,top=100,width=355,height=450,scrollbars=0');
}

function submitRekamMedis(no_rekam_medik, dokrekammedis_id, pasien_id, pendaftaran_id, ruangan_id){
	$('#<?php echo CHtml::activeId($model,'dokrekammedis_id'); ?>').val(dokrekammedis_id);
	$('#<?php echo CHtml::activeId($model,'pasien_id'); ?>').val(pasien_id);
	$('#<?php echo CHtml::activeId($model,'pendaftaran_id'); ?>').val(pendaftaran_id);
	$('#<?php echo CHtml::activeId($model,'no_rekam_medik'); ?>').val(no_rekam_medik);
}
</script>