<script type="text/javascript">
function batalRujukan(pendaftaran_id,pasienkirimkeunitlain_id,obj)
{
	window.parent.myConfirm("Anda yakin akan membatalkan rujukan radiologi pasien ini?","Perhatian!",function(r) {
		if(r){
			$('#tblListPemeriksaanRad').addClass('animation-loading');
			$.ajax({
				type:'POST',
				url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'BatalRujukan'); ?>',
				data: {pendaftaran_id : pendaftaran_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},//
				dataType: "json",
				success:function(data){
					if(data.status == true){
						window.parent.myAlert(data.pesan);							
						$('#tblListPemeriksaanRad').removeClass('animation-loading');									
						$(obj).parents('tr').detach();
					}else if(data.pesan == 'exist'){
						window.parent.myAlert('Rujukan tidak bisa dibatalkan karena ada tindakan yang sudah dibayarkan!');
						$('#tblListPemeriksaanRad').removeClass('animation-loading');									
					}else{
						window.parent.myAlert(data.pesan);
						$('#tblListPemeriksaanRad').removeClass('animation-loading');									
					}
				},
				error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
			});
		}
	});
}
function ubahPemeriksaan(pendaftaran_id,pasienkirimkeunitlain_id,obj) {
	$.ajax({
		type:'POST',
		url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'UbahPemeriksaan'); ?>',
		data: {pendaftaran_id : pendaftaran_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},//
		dataType: "json",
		success:function(data){
			$('#pasienkirimkeunitlain_id').val(pasienkirimkeunitlain_id);
			$('#ruangan_id').val(data.ruangan_id);
			updateChecklistPemeriksaanRad(pendaftaran_id,pasienkirimkeunitlain_id);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

/**
 * update (refresh) checklist pemeriksaan rad
 * harus include /js/jquery.tiler.js
 * @param {obj} form_checklist
 */
function updateChecklistPemeriksaanRad(pendaftaran_id,pasienkirimkeunitlain_id){
    $('#formPeriksaLab').addClass("animation-loading");
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('UbahPemeriksaan'); ?>',
        data: {pendaftaran_id:pendaftaran_id, pasienkirimkeunitlain_id:pasienkirimkeunitlain_id},
        dataType: "json",
        success:function(data){
            $('#tblFormPemeriksaanRad > tbody').html(data.content);
            $('#formPeriksaLab').tile({widths : [ 190 ]});
            $('#formPeriksaLab').removeClass("animation-loading");
			$("#tblFormPemeriksaanRad > tbody > tr:last .integer").maskMoney({"defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0,"symbol":null});
			$('.integer').each(function(){this.value = formatNumber(this.value)});
			hitungTotal();
            setCheckedPemeriksaan($("#tblFormPemeriksaanRad"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
/**
 * set checked pemeriksaan yang sudah ada di daftar
 */
function setCheckedPemeriksaan(obj_table){
    $(".boxtindakan").find('input[name$="pemeriksaanRad[]"]').removeAttr('checked');
	$('.boxtindakan').find('input[class$="adaTindakan"]').val(0);
    $(obj_table).find('input[name*="[inputpemeriksaanrad]"]').each(function(){
        var pemeriksaanrad_id = $(this).val();
        $('.boxtindakan').find('input[name$="pemeriksaanRad[]"][value='+pemeriksaanrad_id+']').attr('checked',true);
		$('.boxtindakan').find('input[name$="adaTindakan_' + pemeriksaanrad_id + '"]').val(1);
    });    
}

function validasiCek(obj){
    if(requiredCheck($("form"))){
        var jumlah_pemeriksaan = $('#trPeriksaRadKosong').length;
        if(jumlah_pemeriksaan == 1){
			window.parent.myAlert('Silakan pilih pemeriksaan radiologi terlebih dahulu!');
            return false;
        }else{
            return true;
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
</script>